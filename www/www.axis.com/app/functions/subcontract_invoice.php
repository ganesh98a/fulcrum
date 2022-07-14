<?php

	function invoicetoExpenses($database, $config, $user_company_id, $qb_param_arr,$supplier_arr){
		$return_val_arr = array('returnval'=>'N','qb_error_id'=>'');
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		if(!empty($QuickBookKeys['refresh_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['refresh_token_expires'])){ // Refresh Token Expire
			$return_val_arr['returnval'] = 'refreshtokenexpired';
		}else if(!empty($QuickBookKeys['access_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['access_token_expires'])){ // Access Token Expire
			
			refreshToken($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $user_company_id, $config, $database);
			$QuickBookKeys = getCompanyData($database, $user_company_id);
		}

		if(empty($QuickBookKeys['client_id'])){ // Quickbooks Keys are not available
			$return_val_arr['returnval'] = 'Quickbooks Keys are not available';
		}else{ // Quickbooks Keys are there
			$vendor_data = getVendor($database, $qb_param_arr[VENDOR_ID]);
			$vendor_name = $vendor_data[COMPANY];
			$vendor_arr = createUpdVendorQB($QuickBookKeys, $config, $vendor_name);
			

			if(!empty($vendor_arr['vendor_error'])){ // QB Vendor Create Error
				$param_err_arr = array('item_id'=>$qb_param_arr['invoice_id'], 'errorlog'=> $vendor_arr['vendor_error'],'item_type'=>'SubContract Invoice-SubContract');
				$return_val_arr['qb_error_id'] = qb_api_error_log($database, $param_err_arr);
			}else if(empty($vendor_arr[VENDOR_ID])){
				$return_val_arr['returnval'] = 'Vendor Id of QB is not available';
			}else{
				$contract_data = getContract($database, $qb_param_arr[COST_CODE_ID]);
				$category_name = $contract_data['division_number'].'-'.$contract_data['cost_code'].' '.$contract_data['cost_code_description'];
				$table_options_arr = array();
				$table_options_arr['table'] = 'qb_accounts';
				$table_options_arr['filter'] = array('id = ?'=>$qb_param_arr['gl_account_id']);
				$getSubContractAccount = TableService::GetTabularData($database, $table_options_arr);
				if(empty($getSubContractAccount['id'])){  // GL account is mapped in Accounting Portal
					$return_val_arr['returnval'] = 'GL account mapping error.';
				}else if(empty($getSubContractAccount['name']) && empty($getSubContractAccount['account_type']) && empty($getSubContractAccount['account_sub_type'])){  // Account name and types are there
					$return_val_arr['returnval'] = 'Please check the Account Name and SubTypes of the account mapped.';
				}else{
					$parentCategory_arr = getCategoryArrQB($QuickBookKeys, $config, $getSubContractAccount, 1);

					if(empty($parentCategory_arr)){ // Account mapped in Accounting portal is not in QB
						$return_val_arr['returnval'] = 'Check '.$getSubContractAccount['name'].' with '.$getSubContractAccount['account_type'].' type is exists as Primary Account in QB';
					}else{
						$category_param_arr = array();
						$category_param_arr['name'] = $category_name;
						$category_param_arr['account_type'] = $parentCategory_arr->AccountType;
						$category_param_arr['account_sub_type'] = $parentCategory_arr->AccountSubType;
						$category_param_arr['id'] = $parentCategory_arr->Id;
						$category_arr = createUpdCategoryQB($QuickBookKeys, $config, $category_param_arr);
						if(!empty($category_arr['category_error'])){
							$param_err_arr = array('item_id'=>$qb_param_arr['invoice_id'], 'errorlog'=>$category_arr['category_error'],'item_type'=>'SubContract Invoice-CostCode');
							$return_val_arr['qb_error_id'] = qb_api_error_log($database, $param_err_arr);
						}else if(empty($category_arr['category_id'])){ // Category id is not returned from QB
							$return_val_arr['returnval'] = 'Category Id of QB is not available';
						}else{
							$param_arr = array_merge( $vendor_arr, $category_arr);
							$param_arr['TxnDate'] = $qb_param_arr['TxnDate'];
							$param_arr['DueDate'] = $qb_param_arr['DueDate'];
							$param_arr['TotalAmt'] = $qb_param_arr['TotalAmt'];
							$param_arr['Desc'] = $qb_param_arr['Desc'];
							$param_arr[NOTES] = $qb_param_arr[NOTES];
							$param_arr['customer_id'] = $qb_param_arr['customer_id'];
							$param_arr[APPLICATION_NUMBER] = $qb_param_arr[APPLICATION_NUMBER];
							$param_arr['Project_name'] = $qb_param_arr['Project_name'];
							if(!empty( $qb_param_arr['qb_expense_id'])){
								$param_arr['qb_expense_id'] = $qb_param_arr['qb_expense_id'];
							}
							$expense_arr = createExpensesQB($QuickBookKeys, $config, $param_arr,$supplier_arr);
							if(!empty($expense_arr['expense_error'])){ // QB error on Bill creation
								$param_err_arr = array('item_id'=>$qb_param_arr['invoice_id'], 'errorlog'=>$expense_arr['expense_error'],'item_type'=>'SubContract Invoice-expense');
								$return_val_arr['qb_error_id'] = qb_api_error_log($database, $param_err_arr);
							}else{// if there is no QB error on creating bill
								if(!empty($expense_arr['expense_id']) && !empty($qb_param_arr['invoice_id'])){ // if bill id is there
									update_qb_expenseid($database, $qb_param_arr['invoice_id'], $expense_arr['expense_id']);
									$qb_stat_param_arr = array();
									$qb_stat_param_arr['invoiceId'] = $qb_param_arr['invoice_id'];
									$qb_stat_param_arr['project_id'] = $qb_param_arr['project_id'];
									if(!empty($eachsubcont_invoice->Id) && !empty($eachsubcont_invoice->DueDate) && !empty($eachsubcont_invoice->TxnDate) && strtotime($eachsubcont_invoice->DueDate) <  strtotime($eachsubcont_invoice->TxnDate)){
										updatesubcontInvoiceStatusOverdue($database, $qb_stat_param_arr);
									}else{
										updatesubcontInvoiceStatusOpen($database, $qb_stat_param_arr);	
									}
									

									$return_val_arr['returnval'] = 'Y';
								}

							}

						}

					}
				}
			}
		}
		

		if(!empty($qb_param_arr[FILE_MANAGER_FILE_ID]) && !empty($expense_arr['expense_id'])){
			$file_manager_file_id = $qb_param_arr[FILE_MANAGER_FILE_ID];
			$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
			$file_location_id = $fileManagerFile->file_location_id;
			$file_manager_base_path = $config->system->file_manager_base_path;
			$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
			$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;
			$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
			$arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];

			$parm_arr = array();
			$parm_arr['file_path'] = $arrPath;
			$parm_arr['file_name'] = $fileManagerFile->virtual_file_name;
			$parm_arr['file_mime_type'] = $fileManagerFile->virtual_file_mime_type;
			$parm_arr['qb_expense_id'] = $expense_arr['expense_id'];
			$upload_arr = uploadSubContAttachment($QuickBookKeys, $config, $parm_arr);
			
			if(!empty($upload_arr['file_upload_id']) && !empty($qb_param_arr['invoice_id'])){
				update_qb_attachmentid($database, $qb_param_arr['invoice_id'], $upload_arr['file_upload_id']);
			}
			if(!empty($qb_param_arr['qb_attachment_id'])){
				deleteAttachmentQB($QuickBookKeys, $config, $qb_param_arr['qb_attachment_id']);
			}
		}
		return $return_val_arr;
	}

	function PurchaseOrderToQB($database, $config, $user_company_id, $qb_param_arr){
		$return_val_arr = array('returnval'=>'N','qb_error_id'=>'');

		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		if(!empty($QuickBookKeys['refresh_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['refresh_token_expires'])){ // Refresh Token Expire
			$return_val_arr['returnval'] = 'refreshtokenexpired';
		}else if(!empty($QuickBookKeys['access_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['access_token_expires'])){ // Access Token Expire
			
			refreshToken($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $user_company_id, $config, $database);
			$QuickBookKeys = getCompanyData($database, $user_company_id);
		}
		$customerId = get_qb_projcustidbyname($QuickBookKeys,$config,$qb_param_arr['project_customer']);
		if(empty($QuickBookKeys['client_id'])){ // Quickbooks Keys are not available
			$return_val_arr['returnval'] = 'Quickbooks Keys are not available';
		}else{ // Quickbooks Keys are there
			if(empty($customerId)){
				$return_val_arr['returnval'] =  'Customer not mapped to project.';
			}else{
				$vendor_arr = createUpdVendorQB($QuickBookKeys, $config, $qb_param_arr['vendor_name']);
				if(!empty($vendor_arr['vendor_error'])){
					$param_err_arr = array('item_id'=>0, 'errorlog'=>$vendor_arr['vendor_error'],'item_type'=>'Purchase Order-SubContract');
					$return_val_arr['qb_error_id'] = qb_api_error_log($database, $param_err_arr);
				}else if(empty($vendor_arr[VENDOR_ID])){
					$return_val_arr['returnval'] =  'Vendor Id of QB is not available';
				}else{
					$category_name = $qb_param_arr['division_number'].'-'.$qb_param_arr['cost_code'].' '.$qb_param_arr['cost_code_description'];

					if(empty($qb_param_arr['gl_account_id'])){  // Account mapped in Accounting portal is not in QB
						$return_val_arr['returnval'] =  'GL account mapping is required.';
					}else{
						$table_options_arr = array();
						$table_options_arr['table'] = 'qb_accounts';
						$table_options_arr['filter'] = array('id = ?'=>$qb_param_arr['gl_account_id']);
						$getSubContractAccount = TableService::GetTabularData($database, $table_options_arr);
						
						if(empty($getSubContractAccount['id'])){ // GL account is mapped in Accounting Portal
							$return_val_arr['returnval'] =  'GL account mapping error.';
						}else{
							if(empty($getSubContractAccount['name']) && empty($getSubContractAccount['account_type']) && empty($getSubContractAccount['account_sub_type'])){// Account name and types are there
								$return_val_arr['returnval'] =  'Please check the Account Name and SubTypes of the account mapped.';
							}else{
								$parentCategory_arr = getCategoryArrQB($QuickBookKeys, $config, $getSubContractAccount, 1);

								if(empty($parentCategory_arr)){ // Account mapped in Accounting portal is not in QB
									$return_val_arr['returnval'] =  'Check '.$getSubContractAccount['name'].' is with '.$getSubContractAccount['account_type'].' type Primary Account in QB';
								}else{
									$category_param_arr = array();
									$category_param_arr['name'] = $category_name;
									$category_param_arr['account_type'] = $parentCategory_arr->AccountType;
									$category_param_arr['account_sub_type'] = $parentCategory_arr->AccountSubType;
									$category_param_arr['id'] = $parentCategory_arr->Id;
								
									$category_arr = createUpdCategoryQB($QuickBookKeys, $config, $category_param_arr);

									if(!empty($category_arr['category_error'])){
										$param_err_arr = array('item_id'=>0, 'errorlog'=>$category_arr['category_error'],'item_type'=>'Purchase Order-CostCode');
										$return_val_arr['qb_error_id'] = qb_api_error_log($database, $param_err_arr);
									}else if(empty($category_arr['category_id'])){ // Category id is not returned from QB
										$return_val_arr['returnval'] = 'Category Id of QB is not available';
									}else{
										$param_arr = array_merge( $vendor_arr, $category_arr);
										$param_arr['TotalAmt'] = $qb_param_arr['TotalAmt'];
										$param_arr['customer_id'] = $customerId;
										
										$purchaseorder_arr = createPurchaseOrderQB($QuickBookKeys, $config, $param_arr);

										if(!empty($purchaseorder_arr['purchase_order_error'])){ // QB error on Bill creation
											$param_err_arr = array('item_id'=>0, 'errorlog'=>$purchaseorder_arr['purchase_order_error'],'item_type'=>'Purchase Order- creation');
											$return_val_arr['qb_error_id'] = qb_api_error_log($database, $param_err_arr);
										}else if(!empty($purchaseorder_arr['purchase_order_id'])){
											$return_val_arr['returnval'] = 'Y';
										}
									}

								}

							}
							
						}				

					}
					

				}
				
			}			
		}
		return $return_val_arr;
	}

	function getContractsArr($database,$user_company_id, $project_id, $contact_company_id = ''){
		$contract_arr = array();
		if(!empty($contact_company_id)){
			$contract_arr = getContractsArrData($database, $user_company_id, $project_id, $contact_company_id);
		}
		
		$listId = CONTRACT_ID;
		$listClass = "form-control";
		$listjs = "onchange=SuppliersList()";
		$liststyle = "";
		$listDefault = "";
		$selectedcontract = "";

		return selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$contract_arr,$selectedcontract);
	}

	function getVendorArr($database,$user_company_id,$project_id){

		$vendor_arr = array();
		$company_arr = ContactCompany::loadContactCompaniesBySubcontractors($database, $user_company_id,$project_id);

		foreach ($company_arr AS $contactCompany) {
			if(!empty($contactCompany->contact_company_name)){
				$vendor_arr[$contactCompany->contact_company_id] =  $contactCompany->contact_company_name;	
			}
		}
		$listId = "company_id";
		$listClass = "form-control";
		$listjs = "";
		$liststyle = "";
		$listDefault = "All Vendors";
		$selectedvendor = "";
		return selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$vendor_arr,$selectedvendor);
	}

	function getSubContInvoice($database, $project_id, $userCanManageSubcontractInvoice, $vendor_id = '', $showallinvoice =false, $user_company_id ='', $currentlyActiveContactId=''){

		$subContInvoice = getSubContInvoiceArrDataSecOne($database, $project_id, $vendor_id, $showallinvoice);
		

		$table_subcontinvoice = '';		
		if(!empty($subContInvoice) && count($subContInvoice) > 0){
			foreach($subContInvoice as $eachContInvoice){				
				$recieved_date = '';
				if(!empty($eachContInvoice[RECIEVED_DATE]) && $eachContInvoice[RECIEVED_DATE] != EMPTY_DATE){
					$recieved_date = date(MDY,strtotime($eachContInvoice[RECIEVED_DATE]));
				}

				$period_to_date = '';
				if(!empty($eachContInvoice[PERIOD_TO]) && $eachContInvoice[PERIOD_TO] != EMPTY_DATE){
					$period_to_date = date(MDY,strtotime($eachContInvoice[PERIOD_TO]));
				}
				$conremAmount = $eachContInvoice['contract_remaining'];

				$subcont_status_db = getSubcontractInvoiceStatus($database);
				unset($subcont_status_db['11']);
				unset($subcont_status_db['12']);
				$subcont_status = "<select id='subcontract_invoice_status-".$eachContInvoice['id']."'  class='subcontractinvoice_status' style='width: 100%;' >";
				$invoice_status_attr = '';
				foreach($subcont_status_db as $key => $value){
					$listselected = '';
					if($key == $eachContInvoice['subcontract_invoice_status_id']){
						$listselected = 'selected';	
						$invoice_status_attr = $value;
					}
					if(empty($eachContInvoice['qb_expense_id']) && in_array($value, array('Open', 'Overdue', 'Paid' )) ){
						continue;
					}else if(!empty($eachContInvoice['qb_expense_id']) && !in_array($value, array('Open', 'Overdue', 'Paid' )) ){
						continue;

					}

					
					$subcont_status .= "<option value=".$key." $listselected>$value</option>";
				}
				$subcont_status .= "</select>";
				if(!$userCanManageSubcontractInvoice){
					$subcont_status = $invoice_status_attr;
				}


				$pm_approved_date = '';
				if($eachContInvoice['pm_approved'] != '0000-00-00'){
					$pm_approved_date = date(MDY,strtotime($eachContInvoice['pm_approved']));
				}
				// To get the costcode
				$costabb = findSubInvByCostId($database,$user_company_id,$eachContInvoice[COST_CODE_ID]);
				$invoice_file = '';
				if(!empty($eachContInvoice[APPLICATION_NUMBER])){
					$application_num = $eachContInvoice[APPLICATION_NUMBER];
				}
				if(!empty($eachContInvoice[VENDOR_ID])){
					$vendor_data = getVendor($database, $eachContInvoice[VENDOR_ID]);
					if(!empty($vendor_data[COMPANY])){
						$vendor_name = $vendor_data[COMPANY];
					}
				}

				if(!empty($eachContInvoice[FILE_ID])){
					$invoice_file = "<a class='preview_invoice' style='text-decoration: underline;' data-file='".$eachContInvoice['virtual_file_name']."'  data-fileid='".$eachContInvoice['file_id']."' data-invoice_id='".$eachContInvoice['id']."' id='preview_invoice-".$eachContInvoice['id']."'>Invoice</a> ";
					if($userCanManageSubcontractInvoice){
					$invoice_file .= " <a href='javascript:void(0)' class='change_file' id='change_file-".$eachContInvoice['id']."'  style='text-decoration: underline;'>Chg File</a>";
					}
					if(!empty($currentlyActiveContactId) && !empty($user_company_id) && $userCanManageSubcontractInvoice){


					// Convert to temp file upload with temp GUID
						$virtual_file_path = '/Subcontract Invoice/'.$eachContInvoice[PERIOD_TO] .'/';
						$vendor_name = $application_num = '';

						
						
						$vir_costcode_name = getCostCodeData($database, $user_company_id, $eachContInvoice['project_id'], $eachContInvoice['vendor_id'],$eachContInvoice[COST_CODE_ID]);
						$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
						$input = new Input();
						$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record-'.$eachContInvoice['id'];
						$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
						$input->project_id = $project_id;
						$input->virtual_file_path = $virtual_file_path;
						$input->virtual_file_name = $vir_costcode_name.' '.$vendor_name.' '.$application_num.' '.date('mdy',strtotime($eachContInvoice[PERIOD_TO])).'.pdf';
						$input->action = '/modules-file-manager-file-uploader-ajax.php';
						$input->method = 'uploadRequestForInformationAttachment';
						$input->allowed_extensions = 'pdf';
						$input->multiple = 'false';
						$input->style  = 'display:none;';
						
						$input->post_upload_js_callback = "Sub__invoiceAttachemntUpload(arrFileManagerFiles,".$eachContInvoice['id'].")";
						require_once("../../include/page-components/fileUploader.php");
						$fileUploader = buildFileUploader($input);
						$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

						$invoice_file .= $fileUploader.$fileUploaderProgressWindow;
					}
				}else{
					if(!empty($currentlyActiveContactId) && !empty($user_company_id) && $userCanManageSubcontractInvoice){


						// Convert to temp file upload with temp GUID
						$virtual_file_path = '/Subcontract Invoice/'.$eachContInvoice[PERIOD_TO] .'/';

						$vir_costcode_name = getCostCodeData($database, $user_company_id, $eachContInvoice['project_id'], $eachContInvoice[VENDOR_ID],$eachContInvoice[COST_CODE_ID]);
						$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
						$input = new Input();
						$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record-'.$eachContInvoice['id'];
						$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
						$input->project_id = $project_id;
						$input->virtual_file_path = $virtual_file_path;
						$input->virtual_file_name = $vir_costcode_name.' '.$vendor_name.' '.$application_num.' '.date('mdy',strtotime($eachContInvoice[PERIOD_TO])).'.pdf';
						$input->action = '/modules-file-manager-file-uploader-ajax.php';
						$input->method = 'uploadRequestForInformationAttachment';
						$input->allowed_extensions = 'pdf';
						$input->multiple = 'false';
						//, 'container--request_for_information_attachments--create-request_for_information-record'

						$input->post_upload_js_callback = "Sub__invoiceAttachemntUpload(arrFileManagerFiles,".$eachContInvoice['id'].")";
						require_once("../../include/page-components/fileUploader.php");
						$fileUploader = buildFileUploader($input);
						$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

						$invoice_file = $fileUploader.$fileUploaderProgressWindow;
					}else{
						$invoice_file = 'No file Attached';
					}
					//* Get the Dropdown Data --End*/
				}


				/* Project Mapped Customers - Start */

				
				if($userCanManageSubcontractInvoice && !in_array($eachContInvoice['subcontract_invoice_status_id'], array('7','8','9'))){
					$projectCustArr = getProjectCustomers($database,$user_company_id);
					$qb_cust_html = "<select id='qb_customer-".$eachContInvoice['id']."' class='qb_customer_edit' style='width:100%;' >

									<option value=''>Select a QB Customer</option>";
					foreach($projectCustArr as $qb_customer_id => $qb_customer){
						$project_cust_selected = '';
						if(!empty($eachContInvoice['qb_customer_id']) && $qb_customer_id == $eachContInvoice['qb_customer_id']){
							$project_cust_selected = " selected='selected'";
						}

						$qb_cust_html .= "<option value='".$qb_customer_id."' ".$project_cust_selected.">".$qb_customer."</option>";
					}
					$qb_cust_html .= "</select>";
				}else{
					$qb_cust_html = '<span style="color: #b30000;">No Customer:Project Selected.</span>';

					if(!empty($eachContInvoice['qb_customer_id'])){
						$qb_customer_options = array();
						$qb_customer_options['table'] = 'qb_customers';
						$qb_customer_options['filter'] = array('id = ?'=> $eachContInvoice['qb_customer_id']);

						$qb_customer_data = TableService::GetTabularData($database, $qb_customer_options);
						if(!empty($qb_customer_data['project_customer'])){
							$qb_cust_html = $qb_customer_data['project_customer'];
						}
					}



				}
				/* Project Mapped Customers - End */

				/* Sync to QB - Start */
				$synctoqb = "<a class='disabled'><img src='/images/forward-default.png' /></a>";

				if(!empty($eachContInvoice['subcontract_invoice_status_id']) && $eachContInvoice['subcontract_invoice_status_id'] == '2'){
					$synctoqb = "<a class='sync_to_qb' id='sync_to_qb-".$eachContInvoice['id']."'><img src='/images/forward-active.png' /></a>";
				}
				/* Sync to QB - End */

				$supplierName = '';
				$supplierAmount = '';
				$supplierArr = getPrelimsByInvoiceId($database, $eachContInvoice['id']);
				if (!empty($supplierArr)) {
					$i = 1;
					foreach ($supplierArr as $key => $value) {
						$supplierName .= $i.'. '.$value['supplier'].'<br>';
						$supplierAmount .= number_format($value['Amount'],2).'<br>';
						$i++;
					}
				}


				$table_subcontinvoice .= "<tr>
							<td>".$costabb."</td>
							<td><a href='javascript:void(0)' class='view_summary' data-vendorid='".$eachContInvoice['vendor_id']."' data-projectid='".$eachContInvoice['project_id']."' style='text-decoration: underline;' >".$eachContInvoice[COMPANY]."</a></td>
							<td>".$qb_cust_html."</td>
							<td>
								".$invoice_file."
								<input type='hidden' value='".$eachContInvoice[FILE_ID]."' id='existinvoice-".$eachContInvoice['id']."'>
							</td>
							<td>
								".$recieved_date."
							</td>
							<td>".$eachContInvoice[APPLICATION_NUMBER]."</td>
							<td>
								".$period_to_date."
							</td>
							<td>".number_format($eachContInvoice[AMOUNT],2)."</td>
							<td>".number_format($eachContInvoice[RETENTION],2)."</td>
							<td>".number_format($eachContInvoice[TOTAL],2)."</td>
							<td>".$supplierName."</td>
							<td>".$supplierAmount."</td>
							<td>".$conremAmount."</td>";
					if($userCanManageSubcontractInvoice){
						$table_subcontinvoice .="<td><textarea style='width: 250px;' class='edit_notes' id='notes-".$eachContInvoice['id']."'>".$eachContInvoice['notes']."</textarea></td>
							<td>".$pm_approved_date."</td>
							<!--<td>".$synctoqb."</td>-->
							<td>".$subcont_status."</td>
							<td><a href='javascript:void(0)' title='Delete Subcontract Invoice.' class='delete_invoice' id='".$eachContInvoice['id']."'>x</a></td>
						</tr>";
					}else{
						$table_subcontinvoice .="<td><textarea style='width: 250px;' readonly>".$eachContInvoice['notes']."</textarea></td><td>".$pm_approved_date."</td>
							<td>".$subcont_status."</td>
						</tr>";
					}
						$table_subcontinvoice .="";
			}
		}else{
			$colspan = 12;
			if(!empty($userCanManageSubcontractInvoice)){
				$colspan = 14;
			}
			$table_subcontinvoice .= "<tr><td colspan='".$colspan."' style='text-align: center;'>No Invoice found!</td></tr>";
		}
		
		return $table_subcontinvoice;

	}

	function getSubContInvoiceSecTwo($database, $project_id, $userCanManageSubcontractInvoice, $vendor_id = '', $user_company_id ='', $currentlyActiveContactId=''){

		$subContInvoice = getSubContInvoiceArrDataSecTwo($database, $project_id, $vendor_id);
		

		$table_subcontinvoice = '';		
		if(!empty($subContInvoice) && count($subContInvoice) > 0){
			foreach($subContInvoice as $eachContInvoice){				
				$recieved_date = '';
				if(!empty($eachContInvoice[RECIEVED_DATE]) && $eachContInvoice[RECIEVED_DATE] != EMPTY_DATE){
					$recieved_date = date(MDY,strtotime($eachContInvoice[RECIEVED_DATE]));
				}

				$period_to_date = '';
				if(!empty($eachContInvoice[PERIOD_TO]) && $eachContInvoice[PERIOD_TO] != EMPTY_DATE){
					$period_to_date = date(MDY,strtotime($eachContInvoice[PERIOD_TO]));
				}

				$pm_approved_date = '';
				if($eachContInvoice['pm_approved'] != '0000-00-00'){
					$pm_approved_date = date(MDY,strtotime($eachContInvoice['pm_approved']));
				}
				$invoice_file = '';
				if(!empty($eachContInvoice[APPLICATION_NUMBER])){
					$application_num = $eachContInvoice[APPLICATION_NUMBER];
				}
				if(!empty($eachContInvoice[VENDOR_ID])){
					$vendor_data = getVendor($database, $eachContInvoice[VENDOR_ID]);
					if(!empty($vendor_data[COMPANY])){
						$vendor_name = $vendor_data[COMPANY];
					}
				}

				// To get the costcode
				$costabb = findSubInvByCostId($database,$user_company_id,$eachContInvoice[COST_CODE_ID]);

				$subcontract_id = $eachContInvoice['subcontract_id'];
				$subcontract_invoice_id = $eachContInvoice['id'];
				$conremAmount = $eachContInvoice['contract_remaining'];

				$supparr = getPrelimsBysubcontractorId($database,$subcontract_id);

				$supplier_list = "<select class='supp_list' id='supp_list_".$subcontract_invoice_id."' style='width:100%;' multiple='multiple' onchange='supplierlineitemAppend(".$subcontract_id.",".$subcontract_invoice_id.")'><option value=''>All Supplier</option>";
					foreach($supparr AS $supplierdata){
						$is_selected = getValueFromSupplierSCLog($database,$subcontract_invoice_id,$supplierdata['prelim_id']);
						$selected = '';
						if($is_selected != ''){
							$selected = 'selected';
						}
						$supplier_list .= "<option value='".$supplierdata['prelim_id']."' $selected>".$supplierdata['supplier']."</option>";
					}
				$supplier_list .= "</select>";
				$supplier_list .= "</br>";
				$supplier_list .= "<span id='btnAddSupplierPopover_".$subcontract_id."' class='btnAddSupplier btn entypo entypo-click entypo-plus-circled supplierPopoverNew' style='margin-left:7px' onclick='supplierPopoverNew(".$subcontract_id.",".$subcontract_invoice_id.");'></span>";

				if(!empty($eachContInvoice[FILE_ID])){
					$invoice_file = "<a class='preview_invoice' style='text-decoration: underline;' data-file='".$eachContInvoice['virtual_file_name']."'  data-fileid='".$eachContInvoice['file_id']."' data-invoice_id='".$eachContInvoice['id']."' id='preview_invoice-".$eachContInvoice['id']."'>Invoice</a> ";
					if($userCanManageSubcontractInvoice){
					$invoice_file .= " <a href='javascript:void(0)' class='change_file' id='change_file-".$eachContInvoice['id']."'  style='text-decoration: underline;'>Chg File</a>";
					}
					if(!empty($currentlyActiveContactId) && !empty($user_company_id) && $userCanManageSubcontractInvoice){


					// Convert to temp file upload with temp GUID
						$virtual_file_path = '/Subcontract Invoice/'.$eachContInvoice[PERIOD_TO] .'/';
						$vendor_name = $application_num = '';

						
						
						$vir_costcode_name = getCostCodeData($database, $user_company_id, $eachContInvoice['project_id'], $eachContInvoice['vendor_id'],$eachContInvoice[COST_CODE_ID]);
						$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
						$input = new Input();
						$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record-'.$eachContInvoice['id'];
						$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
						$input->project_id = $project_id;
						$input->virtual_file_path = $virtual_file_path;
						$input->virtual_file_name = $vir_costcode_name.' '.$vendor_name.' '.$application_num.' '.date('mdy',strtotime($eachContInvoice[PERIOD_TO])).'.pdf';
						$input->action = '/modules-file-manager-file-uploader-ajax.php';
						$input->method = 'uploadRequestForInformationAttachment';
						$input->allowed_extensions = 'pdf';
						$input->multiple = 'false';
						$input->style  = 'display:none;';
						
						$input->post_upload_js_callback = "Sub__invoiceAttachemntUpload(arrFileManagerFiles,".$eachContInvoice['id'].")";
						require_once("../../include/page-components/fileUploader.php");
						$fileUploader = buildFileUploader($input);
						$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

						$invoice_file .= $fileUploader.$fileUploaderProgressWindow;
					}
				}else{
					if(!empty($currentlyActiveContactId) && !empty($user_company_id) && $userCanManageSubcontractInvoice){


						// Convert to temp file upload with temp GUID
						$virtual_file_path = '/Subcontract Invoice/'.$eachContInvoice[PERIOD_TO] .'/';

						$vir_costcode_name = getCostCodeData($database, $user_company_id, $eachContInvoice['project_id'], $eachContInvoice[VENDOR_ID],$eachContInvoice[COST_CODE_ID]);
						$rfiFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
						$input = new Input();
						$input->id = 'uploader--request_for_information_attachments--create-request_for_information-record-'.$eachContInvoice['id'];
						$input->folder_id = $rfiFileManagerFolder->file_manager_folder_id;
						$input->project_id = $project_id;
						$input->virtual_file_path = $virtual_file_path;
						$input->virtual_file_name = $vir_costcode_name.' '.$vendor_name.' '.$application_num.' '.date('mdy',strtotime($eachContInvoice[PERIOD_TO])).'.pdf';
						$input->action = '/modules-file-manager-file-uploader-ajax.php';
						$input->method = 'uploadRequestForInformationAttachment';
						$input->allowed_extensions = 'pdf';
						$input->multiple = 'false';
						//, 'container--request_for_information_attachments--create-request_for_information-record'

						$input->post_upload_js_callback = "Sub__invoiceAttachemntUpload(arrFileManagerFiles,".$eachContInvoice['id'].")";
						require_once("../../include/page-components/fileUploader.php");
						$fileUploader = buildFileUploader($input);
						$fileUploaderProgressWindow = buildFileUploaderProgressWindow();

						$invoice_file = $fileUploader.$fileUploaderProgressWindow;
					}else{
						$invoice_file = 'No file Attached';
					}
					//* Get the Dropdown Data --End*/
				}


				/* Project Mapped Customers - Start */

				
				if($userCanManageSubcontractInvoice && !in_array($eachContInvoice['subcontract_invoice_status_id'], array('7','8','9'))){
					$projectCustArr = getProjectCustomers($database,$user_company_id);
					$qb_cust_html = "<select id='qb_customer-".$eachContInvoice['id']."' class='qb_customer_edit' style='width:100%;' >

									<option value=''>Select a QB Customer</option>";
					foreach($projectCustArr as $qb_customer_id => $qb_customer){
						$project_cust_selected = '';
						if(!empty($eachContInvoice['qb_customer_id']) && $qb_customer_id == $eachContInvoice['qb_customer_id']){
							$project_cust_selected = " selected='selected'";
						}

						$qb_cust_html .= "<option value='".$qb_customer_id."' ".$project_cust_selected.">".$qb_customer."</option>";
					}
					$qb_cust_html .= "</select>";
				}else{
					$qb_cust_html = '<span style="color: #b30000;">No Customer:Project Selected.</span>';

					if(!empty($eachContInvoice['qb_customer_id'])){
						$qb_customer_options = array();
						$qb_customer_options['table'] = 'qb_customers';
						$qb_customer_options['filter'] = array('id = ?'=> $eachContInvoice['qb_customer_id']);

						$qb_customer_data = TableService::GetTabularData($database, $qb_customer_options);
						if(!empty($qb_customer_data['project_customer'])){
							$qb_cust_html = $qb_customer_data['project_customer'];
						}
					}



				}
				/* Project Mapped Customers - End */

				/* Sync to QB - Start */
				$synctoqb = "<a class='disabled'><img src='/images/forward-default.png' /></a>";

				if(!empty($eachContInvoice['subcontract_invoice_status_id']) && ($eachContInvoice['subcontract_invoice_status_id'] == '11' || $eachContInvoice['subcontract_invoice_status_id'] == '12')){
					$synctoqb = "<a class='sync_to_qb' id='sync_to_qb-".$eachContInvoice['id']."'><img src='/images/forward-active.png' /></a>";
				}
				/* Sync to QB - End */
				$syncStatus = true;
				$scAmt = $eachContInvoice['amount'];
				$retentionAmt = $eachContInvoice['retention'];
				$invoice_Total = $eachContInvoice['total'];
				$minInvoiceTotal = $scAmt - $retentionAmt;
				$balanceTotal = getTotalSumFromScLog($database, $subcontract_invoice_id);
				$balance_total = abs(number_format($balanceTotal['diff'],2));
				$maxInvoiceTotal = number_format($balanceTotal['sum'],2);
				$tot_arr_count = 0;

				$inv_checked = ($eachContInvoice['is_release'] == 1) ? 'checked' : '';
				if ($eachContInvoice['is_release'] == 0) {$syncStatus = false;}

				$release_received = "<table width='100%'><tbody>";
				$release_received .= "<tr><td style='padding-bottom: 6px;text-align:center;'><input type='checkbox' class='sup_rel_".$subcontract_invoice_id."' value='0' id='inv_chk_".$subcontract_invoice_id."' onchange='invCheckToInvLog(".$subcontract_invoice_id.")' ".$inv_checked."></td></tr>";

				$supplierName = "<table width='100%'><tbody>";
				$supplierAmount = "<table width='100%'><tbody>";
				$supplierName .= "<tr><td style='text-align: right;padding-bottom: 6px;'>Balance</td></tr>";
				$supplierAmount .= "<tr>
						<td style='padding-bottom: 4px;'><input type='text' id='balance_".$subcontract_invoice_id."' style='width: 102px;border: 1px solid #50e7df;border-radius: 2px;background-color: #50e7df;text-align: right;' value='".$balance_total."' readonly></td></tr>";
				$supplierArr = getPrelimsBySCidAndInvoiceId($database, $subcontract_invoice_id,$subcontract_id);
				if (!empty($supplierArr)) {
					$tot_arr_count = count($supplierArr);
					$i = 1;
					foreach ($supplierArr as $key => $value) {

						$textClass = ($value['is_release'] == 1) ? '' : 'rowRed';
						$sup_checked = ($value['is_release'] == 1) ? 'checked' : '';
						if ($value['is_release'] == 0 || $value['is_release'] == '') {$syncStatus = false;}

						$release_received .= "<tr><td style='padding-bottom: 6px;text-align:center;'><input type='checkbox' class='sup_rel_".$subcontract_invoice_id."' value='".$value['prelim_id']."' id='sup_rel_".$subcontract_invoice_id."_".$value['prelim_id']."' onchange='supCheckToSCLog(".$subcontract_invoice_id.",".$value['prelim_id'].")' ".$sup_checked."></td></tr>";
						$supplierName .= "<tr><td style='padding-bottom: 6px;display: inline-block;width: 200px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;' id='sup_name_".$subcontract_invoice_id."_".$value['prelim_id']."' class='".$textClass."'>".$i.'. '.$value['supplier']."</td></tr>";
						$supplierAmount .= "<tr>
							<td style='padding-bottom: 4px;'>
								<input type='hidden' id='old_sup_".$subcontract_invoice_id."_".$value['prelim_id']."' value='".$value['Amount']."'>
								<input type='text' class='sup_val_".$subcontract_invoice_id."' id='sup_".$subcontract_invoice_id."_".$value['prelim_id']."' value='".$value['Amount']."' style='text-align: right;width:100px;' onkeypress='return isNumberKey(event)' onchange='insertToSCLog(".$subcontract_invoice_id.",".$value['prelim_id'].",this.value)'>"."</td></tr>";
						$i++;
					}
				}
				$release_received .= "<tr id='chk_last_row_".$subcontract_invoice_id."'><td></td></tr></tbody></table>";
				$supplierName .= "<tr id='sup_last_row_".$subcontract_invoice_id."'><td><span id='btnAddSupplierPopover_".$subcontract_id."_".$subcontract_invoice_id."' class='btnAddSupplier btn entypo entypo-click entypo-plus-circled supplierPopoverNew' onclick='supplierPopoverNew(".$subcontract_id.",".$subcontract_invoice_id.");'>Add Supplier</span></td></tr></tbody></table>";
				$supplierAmount .= "<tr id='val_last_row_".$subcontract_invoice_id."'><td><input type='hidden' id='tot_arr_".$subcontract_invoice_id."' value='".$tot_arr_count."'></td></tr></tbody></table>";

				$subcont_status_db = getSubcontractInvoiceStatus($database);
				$subcont_status = "<select id='subcontract_invoice_status-".$eachContInvoice['id']."'  class='subcontractinvoice_status' style='width: 100%;' >";
				$invoice_status_attr = '';
				foreach($subcont_status_db as $key => $value){
					$listselected = '';
					$listDisabled = '';
					if($key == $eachContInvoice['subcontract_invoice_status_id']){
						$listselected = 'selected';	
						$invoice_status_attr = $value;
					}
					if ($key == '11' && $syncStatus == false) {
						$listDisabled = 'disabled="true"';	
						$invoice_status_attr = $value;
					}
					if ($key == '12' && $syncStatus == false) {
						$listDisabled = 'disabled="true"';	
						$invoice_status_attr = $value;
					}
					if(empty($eachContInvoice['qb_expense_id']) && in_array($value, array('Open', 'Overdue', 'Paid' )) ){
						continue;
					}else if(!empty($eachContInvoice['qb_expense_id']) && !in_array($value, array('Open', 'Overdue', 'Paid' )) ){
						continue;
					}
					
					$subcont_status .= "<option value=".$key." $listselected $listDisabled>$value</option>";
				}
				$subcont_status .= "</select>";
				if(!$userCanManageSubcontractInvoice){
					$subcont_status = $invoice_status_attr;
				}

				$table_subcontinvoice .= "<tr>
							<td>".$costabb."</td>
							<td><a href='javascript:void(0)' class='view_summary' data-vendorid='".$eachContInvoice['vendor_id']."' data-projectid='".$eachContInvoice['project_id']."' style='text-decoration: underline;' >".$eachContInvoice[COMPANY]."</a></td>
							<td>".$qb_cust_html."</td>
							<td>
								".$invoice_file."
								<input type='hidden' value='".$eachContInvoice[FILE_ID]."' id='existinvoice-".$eachContInvoice['id']."'>
							</td>
							<td>
								".$recieved_date."
							</td>
							<td>".$eachContInvoice[APPLICATION_NUMBER]."</td>
							<td>
								".$period_to_date."
							</td>
							<td>".$scAmt."</td>
							<td>".$retentionAmt."</td>
							<td>
								<input type='hidden' id='minInvoiceTot_".$eachContInvoice['id']."' value='".$minInvoiceTotal."'>
								<input type='hidden' id='oldInvoiceTot_".$eachContInvoice['id']."' value='".$invoice_Total."'>
								<input type='hidden' id='maxInvoiceTot_".$eachContInvoice['id']."' value='".$maxInvoiceTotal."'>
								<input type='text' style='width:100px' id='invoiceTotal_".$eachContInvoice['id']."' value=".$invoice_Total." onkeypress='return isNumberKey(event)' onchange='updateInvoiceTotal(".$eachContInvoice['id'].")'>
							</td>
							<td>".$release_received."</td>
							<td id=supplier_name_".$subcontract_invoice_id.">".$supplierName."</td>
							<td id=supplier_value_".$subcontract_invoice_id.">".$supplierAmount."</td>
							<td id=remianingcontract_amt_".$subcontract_invoice_id.">".$conremAmount."</td>";
					if($userCanManageSubcontractInvoice){
						$table_subcontinvoice .="<td><textarea style='width: 250px;' class='edit_notes' id='notes-".$eachContInvoice['id']."'>".$eachContInvoice['notes']."</textarea></td>
							<td>".$pm_approved_date."</td>
							<td>".$synctoqb."</td>
							<td>".$subcont_status."</td>
							<td><a href='javascript:void(0)' title='Delete Subcontract Invoice.' class='delete_invoice' id='".$eachContInvoice['id']."'>x</a></td>
						</tr>";
					}else{
						$table_subcontinvoice .="<td><textarea style='width: 250px;' readonly>".$eachContInvoice['notes']."</textarea></td><td>".$pm_approved_date."</td>
							<td>".$subcont_status."</td>
						</tr>";
					}
						$table_subcontinvoice .="";
			}
		}else{
			$colspan = 12;
			if(!empty($userCanManageSubcontractInvoice)){
				$colspan = 14;
			}
			$table_subcontinvoice .= "<tr><td colspan='".$colspan."' style='text-align: center;'>No Invoice found!</td></tr>";
		}
		
		return $table_subcontinvoice;

	}

	function SubcontractInvoiceStatus($database,$listId = '',$listClass= '' , $selectedstatus ='',$readonly =''){ // Accounting Portal Filter
		$subcont_status = getSubcontractInvoiceStatus($database);
		unset($subcont_status['11']);
		unset($subcont_status['12']);
		
		$subcont_status = array_diff($subcont_status, array("Open", "Overdue", "Paid"));
		$listjs = "";
		if(!empty($readonly)){
			$listjs = "disabled";
		}
		$liststyle = "";
		$listDefault = "";
		$res_drop = selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$subcont_status,$selectedstatus);
		$permissionTableTbody = <<<END_PER_TABLE_TBODY
	$res_drop
END_PER_TABLE_TBODY;
		return $permissionTableTbody;
	}
	function getContractSummary($database, $param_arr){


		$get_contract_summary = getSubContractSummaryData($database, $param_arr);
		$get_invoice_summary = getSubContractInoiceSummary($database, $param_arr);
		$get_paid_summary = getSubContractInoiceSummary($database, $param_arr, true);

		?>
		<style>
			.row{
			    margin-right: -15px;
    			margin-left: -15px;
			}
			.col-md-4,.col-md-3,.col-md-2{
				float: left;
				position: relative;
				min-height: 1px;
				padding-left: 15px;
			}
			.col-md-4{
				width: 33%;
			}
			.col-md-3{
				width: 25%;
			}
			.col-md-2{
				width: 16%;
			}
			.bold{
				font-weight: bold;
			}
			.text-center{
			   text-align: center;
			}
			.text-right{
		    	text-align: right;
			}
			.border-top{
			    border-top: 1px solid black;
			}
		</style>
		<div class="row">
			<div class="col-md-3" style="border-right: 1px solid black;">
				<table width="100%">
					<td colspan="3" class="bold text-center">Contract Summary</td>
					<?php
						$totalcontractamt = 0;
						foreach($get_contract_summary as $eachcontract_summary){
							//To check the SCO Exists for the subcontarctor
						$resdata =getChangeOrderData($database, $eachcontract_summary['cost_code_id'],$param_arr[PROJECT_ID],"all", $eachcontract_summary['gc_budget_line_item_id'], $eachcontract_summary['subcontract_id']);
						
					?>
					<tr>
						<td class="bold" nowrap><?php echo $eachcontract_summary['division_number'].'-'.$eachcontract_summary['cost_code']; ?></td>
						<td class="bold"><?php echo $eachcontract_summary['cost_code_description']; ?></td>
						<td class="text-right"><?php echo number_format($eachcontract_summary['subcontract_actual_value'],2); ?></td>
					</tr>
					
						<?php
						foreach($resdata as $eachresdata){ ?>
						<tr>
							<td></td>
							<td><?php echo $eachresdata['sequence_number']; ?></td>
							<td  class="text-right"><?php echo $eachresdata['estimated_amount_raw']; ?></td>
						</tr>

						<?php 
						$totalcontractamt += $eachresdata['estimated_amount_raw'];
						}
						
						$totalcontractamt += $eachcontract_summary['subcontract_actual_value'];
						}
					?>
					<tr>
						<td colspan="2" class="bold">Total Project Contract Amount</td>
						<td class="text-right"><?php echo number_format($totalcontractamt,2); ?></td>
					</tr>
				</table>
			</div>
			<div class="col-md-3"  style="border-right: 1px solid black;">
				
				<table width="100%">
					<tr>
						<td colspan="2" class="bold text-center">Invoices Summary</td>
					</tr>
					<tr>
						<td class="bold">Invoiced</td>
						<td  class="text-right">
							<?php echo number_format($get_invoice_summary['total_amount'],2); ?>
						</td>
					</tr>
					<tr>
						<td class="bold">Retention</td>
						<td class="text-right"><?php echo number_format($get_invoice_summary['total_retention'],2); ?></td>
					</tr>
					<tr>
						<td class="bold">Total Invoiced</td>
						<td class="border-top text-right"><?php echo number_format($get_invoice_summary['total_summary'],2); ?></td>
					</tr>
					<tr>
						<td class="bold">% of Contract</td>
						<td class="text-right">
							<?php 
								$contract_percent = ($get_invoice_summary['total_summary']/$totalcontractamt)*100;
								echo  number_format((float)$contract_percent, 2, '.', '').'%';
							?>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="height: 20px;"></td>
					</tr>
					<tr>
						<td class="bold">Contract Amount</td>
						<td class="text-right"><?php echo number_format($totalcontractamt,2); ?></td>
					</tr>
					<tr>
						<td>Less Total Invoiced</td>
						<td  class="text-right"><?php echo number_format($get_invoice_summary['total_summary'],2); ?></td>
					</tr>
					<tr>
						<td  class="bold">Remaining</td>
						<td  class="border-top text-right">
							<?php 
							$remaining_inv = $get_invoice_summary['total_summary'] - $totalcontractamt;
							echo number_format($remaining_inv,2); ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="col-md-3"  style="border-right: 1px solid black;">
				<table width="100%">
					<tr>
						<td colspan="2" class="bold text-center">Paid Summary</td>
					</tr>
					<tr>
						<td class="bold">Paid</td>
						<td class="text-right"><?php echo number_format($get_paid_summary['total_amount'],2); ?></td>
					</tr>
					<tr>
						<td class="bold">Retention Paid</td>
						<td class="text-right"><?php echo number_format($get_paid_summary['total_retention'],2); ?></td>
					</tr>
					<tr>
						<td class="bold">Total Paid</td>
						<td  class="border-top text-right"><?php echo number_format($get_paid_summary['total_summary'],2); ?></td>
					</tr>
					<tr>
						<td class="bold">% of Contract</td>
						<td class="text-right">
							<?php 
								$contract_percent = ($get_paid_summary['total_summary']/$totalcontractamt)*100;
								echo  number_format((float)$contract_percent, 2, '.', '').'%';
							?>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="height: 20px;"></td>
					</tr>
					<tr>
						<td class="bold">Contract Amount</td>
						<td class="text-right"><?php echo number_format($totalcontractamt,2); ?></td>
					</tr>
					<tr>
						<td>Less Total Recieved</td>
						<td class="text-right"><?php echo number_format($get_paid_summary['total_summary'],2); ?></td>
					</tr>
					<tr>
						<td  class="bold">Remaining</td>
						<td  class="border-top text-right">
							<?php 
							$remaining_inv = $get_paid_summary['total_summary'] - $totalcontractamt;
							echo number_format($remaining_inv,2); ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="col-md-2">
				
				<table>
					<tr>
						<td class="bold text-center">Balance</td>
					</tr>
					<tr>
						<td class="text-right">
							<?php echo number_format(($get_invoice_summary['total_amount'] - $get_paid_summary['total_amount']) , 2); ?>
						</td>
					</tr>
					<tr>
						<td class="text-right">
							<?php echo number_format(($get_invoice_summary['total_retention'] - $get_paid_summary['total_retention']), 2); ?>
						</td>
					</tr>
					<tr>
						<td  class="border-top text-right">
							<?php echo number_format(($get_invoice_summary['total_summary'] - $get_paid_summary['total_summary']), 2); ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php

	}

?>

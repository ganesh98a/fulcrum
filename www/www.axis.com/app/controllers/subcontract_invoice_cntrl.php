<?php

	// Sub contract Invoice Controller
	require_once('../constants/constants_qb.php');
	require_once('../models/subcontract_invoice_model.php');
	require_once('../models/accounting_model.php');
	require_once('../functions/subcontract_invoice.php');
	require_once('../functions/subcontract_invoice_quickbook.php');
	require_once('../functions/accounting-quickbook.php');
	require_once('lib/common/Service/TableService.php');

	require_once('../templates/dropdown_tmp.php');
	
	
	$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
	$init['ajax'] = false;
	$init['application'] = 'www.axis.com';
	$init['cache_control'] = 'nocache';
	$init['debugging_mode'] = true;
	$init['display'] = true;
	$init['geo'] = true;
	$init['get_maxlength'] = 2048;
	$init['get_required'] = false;
	$init['https'] = false;
	$init['https_admin'] = true;
	$init['https_auth'] = true;
	$init['no_db_init'] = false;
	$init['output_buffering'] = true;
	$init['override_php_ini'] = false;
	$init['skip_always_include'] = false;
	$init['skip_session'] = false;
	$init['skip_templating'] = false;
	$init['timer'] = false;
	$init['timer_start'] = false;

	require_once('lib/common/init.php');
	require_once('lib/common/File.php');
	require_once('lib/common/FileManager.php');
	require_once('lib/common/FileManagerFolder.php');
	require_once('lib/common/FileManagerFile.php');

	$session = Zend_Registry::get('session');
	// CONSTANT VARIABLES
	$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
	$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
	$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
	$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
	$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

	// SESSSION VARIABLES
	$user_company_id = $session->getUserCompanyId();
	$user_id = $session->getUserId();
	$userRole = $session->getUserRole();
	$project_id = $session->getCurrentlySelectedProjectId();
	$primary_contact_id = $session->getPrimaryContactId();
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
	$Project_name = $currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
	$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
	$currentlySelectedProjectTypeIndex = $session->getCurrentlySelectedProjectTypeIndex();


	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'getContracts'){

		 $contact_company_id = $_POST['vendor'];
		 $user_company_id = $_POST['user_company_id'];
		 $project_id = $_POST[PROJECT_ID];
		 $project_index =  $_POST['currentlySelectedProjectTypeIndex'];
		$contract_arr = getContractsArrData($database, $user_company_id, $project_id, $contact_company_id,$project_index);
		$contract_drop = '';
		foreach($contract_arr as $contract_id => $eachcontract){
			$contract_drop .= '<option value="'.$contract_id.'">'.$eachcontract.'</option>';

		}	

		echo $contract_drop;
		die;

	}
	// To get the Premils records
	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'getSuppliers'){
		 $subcontract_id = $_POST['subcontract_id'];
		 $user_company_id = $_POST['user_company_id'];
		 $project_id = $_POST[PROJECT_ID];

		$supparr = getPrelimsBysubcontractorId($database,$subcontract_id);
		foreach ($supparr AS $supplierdata) {
				$prelim_id = $supplierdata['prelim_id'] ;
				$suplier =  $supplierdata['supplier'];	
				$arrprelims[$prelim_id] = $suplier; 
			
		}
		
		$listId = "supplier_id";
		$listClass = "form-control multi-drop";
		$listjs = "onchange='supplierlineitem()'";
		$liststyle = "";
		$listDefault = "All Supplier";
		$selectedsupplier = "";
		$supp_drop =  selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$arrprelims,$selectedsupplier,true);

		$only_view = "<select style='width:100%;'><option value=''>$listDefault</option>";
			foreach($supparr AS $supplierdata){
				$only_view .= "<option value='".$supplierdata['prelim_id']."'>".$supplierdata['supplier']."</option>";
			}
		$only_view .= "</select>";

		echo $only_view;
		die;
	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'SuppliersLineItemAppend'){
		$supid = urldecode($_POST['supplierid']);
		$user_company_id = $_POST['user_company_id'];
		$project_id = $_POST[PROJECT_ID];
		$subcontractInvoiceId = $_POST['subcontractInvoiceId'];
		$deleteDeselectedSupplier = deleteSuppliersForDeSelect($database,$subcontractInvoiceId,$supid);
		
		$totSCLogAmount = getTotalSumFromScLog($database, $subcontractInvoiceId);
		$balanceAmt = abs(number_format($totSCLogAmount['diff'],2));

		$suppLinearr = getPrelimsAndSCLogId($database,$subcontractInvoiceId,$supid);
		$suplier_name=$supplier_value="";
		$i = 1;
		$suplier_name .= "<table width='100%'>
							<tbody>
								<tr>
									<td style='text-align: right;padding-bottom: 3px;'>Balance</td>
								</tr>";
		$supplier_value .= "<table width='100%'>
							<tbody>
								<tr>
									<td style='padding-bottom: 3px;'><input type='text' id='balance_".$subcontractInvoiceId."' style='width: 102px;border: 1px solid #50e7df;border-radius: 2px;background-color: #50e7df;text-align: right;' value='".$balanceAmt."' readonly></tr></td>";		
		foreach ($suppLinearr AS $suppLinedata) {
			$prelim_id = $suppLinedata['id'] ;
			$suplier =  $suppLinedata['supplier'];	
			$value = getValueFromSupplierSCLog($database,$subcontractInvoiceId,$prelim_id);
			$value = $value ? $value : '0.00';

			$suplier_name .= "<tr><td style='padding-bottom: 3px;'>".$i.'. '.$suplier."</td></tr>";	
			$supplier_value .=  "<tr>
				<td style='padding-bottom: 3px;'>
					<input type='hidden' id='old_sup_".$subcontractInvoiceId."_".$prelim_id."' value='".$value."'>
					<input type='text' style='text-align: right;width:100px;' id='sup_".$subcontractInvoiceId."_".$prelim_id."' value='".$value."' onkeypress='return isNumberKey(event)' onchange='insertToSCLog(".$subcontractInvoiceId.",".$prelim_id.",this.value)'>"."</td></tr>";	
			$i++;
		}
		$suplier_name .= "</tbody></table>";
		$supplier_value .= "</tbody></table>";
		
		echo $suplier_name.'~'.$supplier_value;
		die;

	}

	if (!empty($_POST[ACTION]) && $_POST[ACTION] == 'insertValueToSupplierSCLog') {
		$invoice_id = $_POST['invoice_id'];
		$prelim_id = $_POST['prelim_id'];
		$value = $_POST['value'];

		$checkIfInserted = getValueFromSupplierSCLog($database,$invoice_id,$prelim_id);
		if ($checkIfInserted['amount'] == '') {
			$supplierArr = array('invoice_id'=>$invoice_id,'prelim_id'=>$prelim_id,'Amount'=>$value);
			$ret_sup_arr = createSuppliers($database,$supplierArr);
		}else{
			$options = array();
			$options['table'] = 'supplier_for_subcontractorlog';
			$options['update'] = array('Amount = ?'=> $value);	
			$options['filter'] = array('invoice_id = ?'=> $invoice_id, 'prelim_id = ?'=> $prelim_id);
			$updateOption = TableService::UpdateMultipleTabularData($database,$options);
		}	

		$totSCLogAmount = getTotalSumFromScLog($database, $invoice_id);
		$balanceAmt = number_format($totSCLogAmount['diff'],2);
		$totalAmt = number_format($totSCLogAmount['sum'],2);

		echo $balanceAmt.'~'.$totalAmt;
		die;
	}

	// To get the suplier line Item
	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'SuppliersLineItem'){
		 $supid = urldecode($_POST['supplierid']);
		 $user_company_id = $_POST['user_company_id'];
		 $project_id = $_POST[PROJECT_ID];
		 $suppLinearr = getPrelimsRecordById($database,$supid);
		 $lineItems="";
		
		 foreach ($suppLinearr AS $suppLinedata) {
				$prelim_id = $suppLinedata['id'] ;
				$suplier =  $suppLinedata['supplier'];	
				// $amount =  $suppLinedata['amount'];
				$amount = '';	
				$lineItems .= "
				<tr id='pline_".$prelim_id."'>
					<td colspan='8' class='textAlignRight'>".$suplier."</td>
					<td>
						<input type='text'class='field-amt sup-amt' id='sup_".$prelim_id."' value='".$amount."'>&nbsp; <a href ='#' onclick='delLineItem(".$prelim_id.")'>X</a>
					</td>
					<td colspan='3'></td>
				</tr>
				";
				
			
		}
		echo $lineItems;
		die;

		}

	if (!empty($_POST[ACTION]) && $_POST[ACTION] == 'supCheckToSCLog') {

		$invoice_id = $_POST['invoice_id'];
		$prelim_id = $_POST['prelim_id'];
		$is_release = $_POST['is_release'];
		$date = ($is_release == 1) ? date('Y-m-d') : '';		

		$checkIfInserted = getValueFromSupplierSCLog($database,$invoice_id,$prelim_id);
		if ($checkIfInserted['amount'] == '') {
			$supplierArr = array('invoice_id'=>$invoice_id,'prelim_id'=>$prelim_id,'Amount'=>'');
			$ret_sup_arr = createSuppliers($database,$supplierArr);
		}		

		$options = array();
		$options['table'] = 'supplier_for_subcontractorlog';
		$options['update'] = array('is_release = ?'=> $is_release, 'release_date = ?'=> $date);	
		$options['filter'] = array('invoice_id = ?'=> $invoice_id, 'prelim_id = ?'=> $prelim_id);
		$updateOption = TableService::UpdateMultipleTabularData($database,$options);
		echo $updateOption;
		die;
	}	

	if (!empty($_POST[ACTION]) && $_POST[ACTION] == 'invCheckToInvLog') {

		$invoice_id = $_POST['invoice_id'];
		$is_release = $_POST['is_release'];
		$date = ($is_release == 1) ? date('Y-m-d') : '';	

		$options = array();
		$options['table'] = 'subcontract_invoices';
		$options['update'] = array('is_release = ?'=> $is_release, 'release_date = ?'=> $date);	
		$options['filter'] = array('id = ?'=> $invoice_id);
		$updateOption = TableService::UpdateMultipleTabularData($database,$options);
		echo $updateOption;
		die;
	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'getSubcontractInvoice'){

		$project_id = $_POST[PROJECT_ID];
		$vendor_id = '';
		if(!empty($_POST['vendor'])){
			$vendor_id = $_POST['vendor'];
		}
		$show_all_invoice = $_POST['show_all_invoice'];
		$user_company_id = $_POST['user_company_id'];
		$currentlyActiveContactId = $_POST['currentlyActiveContactId'];
		$userCanManageSubcontractInvoice = $_POST['userCanManageSubcontractInvoice'];
		$subcontinvoice = getSubContInvoice($database, $project_id, $userCanManageSubcontractInvoice, $vendor_id,$show_all_invoice,$user_company_id,$currentlyActiveContactId);
		echo $subcontinvoice;
		die;

	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'getSubcontractInvoiceSecTwo'){

		$project_id = $_POST[PROJECT_ID];
		$vendor_id = '';
		if(!empty($_POST['vendor'])){
			$vendor_id = $_POST['vendor'];
		}
		$user_company_id = $_POST['user_company_id'];
		$currentlyActiveContactId = $_POST['currentlyActiveContactId'];
		$userCanManageSubcontractInvoice = $_POST['userCanManageSubcontractInvoice'];
		$subcontinvoice = getSubContInvoiceSecTwo($database, $project_id, $userCanManageSubcontractInvoice, $vendor_id,$user_company_id,$currentlyActiveContactId);
		echo $subcontinvoice;
		die;

	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'AddPrelim'){
	
		$project_id = $_POST[PROJECT_ID];
		$supplier_name = $_POST['supplier_name'];
		$subcontract_id = $_POST['subcontract_id'];
		// To get the gc_budget_line_item_id
		$budget_id = TableService::getSingleField($database,'subcontracts','gc_budget_line_item_id','id',$subcontract_id);
		$prelim_id = InsertPrelims($database,$supplier_name,$subcontract_id,$project_id,$budget_id);
		if($prelim_id)
		{
			$retsel = "<option value='".$prelim_id."' selected>".$supplier_name."</option>";
			$retMul = "<div class='fs-option g0 selected' data-value='".$prelim_id."'><span class='fs-checkbox'><i></i></span><div class='fs-option-label'>".$supplier_name."</div></div>";
			$supplier_div = "
			<tr id='pline_".$prelim_id."'>
				<td colspan='8' class='textAlignRight'>".$supplier_name."</td>
				<td>
					<input type='text'class='field-amt sup-amt' id='sup_".$prelim_id."' value='0'>&nbsp; <a href ='#' onclick='delLineItem(".$prelim_id.")'>X</a>
				</td>
				<td colspan='3'></td>
			</tr>
			";

			$retdata  = $retsel.'~'.$retMul.'~'.$prelim_id.'~'.$supplier_name.'~'.$supplier_div;
		}else
		{
			$retdata = "1";
		}
		echo $retdata;
		die;


	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'AddPrelimNew'){
	
		$project_id = $_POST[PROJECT_ID];
		$invoice_id = $_POST['invoice_id'];
		$supplier_name = $_POST['supplier_name'];
		$subcontract_id = $_POST['subcontract_id'];
		$array_count = $_POST['array_count'];
		
		// To get the gc_budget_line_item_id
		$budget_id = TableService::getSingleField($database,'subcontracts','gc_budget_line_item_id','id',$subcontract_id);
		$prelim_id = InsertPrelims($database,$supplier_name,$subcontract_id,$project_id,$budget_id);
		if($prelim_id)
		{
			$chkTr = "<tr><td style='padding-bottom: 6px;text-align:center;'><input type='checkbox' class='sup_rel_".$invoice_id."' id='sup_rel_".$invoice_id."_".$prelim_id."' value='".$prelim_id."' onchange='supCheckToSCLog(".$invoice_id.",".$prelim_id.")'></td></tr>";
			$supTr = "<tr><td style='padding-bottom: 6px;display: inline-block;width: 200px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;' id='sup_name_".$invoice_id."_".$prelim_id."' class='rowRed'>".$array_count.". ".$supplier_name."</td></tr>";
			$valTr = "<tr><td style='padding-bottom: 4px;'><input type='hidden' id='old_sup_".$invoice_id."_".$prelim_id."' value=''><input type='text' class='sup_val_".$invoice_id."' id='sup_".$invoice_id."_".$prelim_id."' value='' style='text-align: right;width:100px;' onkeypress='return isNumberKey(event)' onchange='insertToSCLog(".$invoice_id.",".$prelim_id.",this.value)'></td></tr>";

			$retdata  = $chkTr.'~'.$supTr.'~'.$valTr;
		}else
		{
			$retdata = "1";
		}
		echo $retdata;
		die;
	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'create_invoice'){

		
		$insertarr = array(PROJECT_ID => '', VENDOR_ID =>  '',CONTRACT_ID=>'' ,COST_CODE_ID=>'' ,RECIEVED_DATE =>  '',APPLICATION_NUMBER => '',PERIOD_TO => '', AMOUNT =>  '', RETENTION => '', TOTAL => '' ,SUBCONTRACT_INVOICE_STATUS_ID =>'1' , NOTES => '','pm_approved'=>'0000-00-00', QB_CUSTOMER_ID=>'',CREATED_BY=>0, MODIFIED_BY=>0, 'created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s'));

		if(empty($_POST['project_mapped_customer'])){
			die('QB Customer:Project is required.');
		}else{
			$insertarr[QB_CUSTOMER_ID] = $_POST['project_mapped_customer'];
		}
		
		$getQBCustomer = array();
		$getQBCustomer['table'] = 'qb_customers';
		$getQBCustomer['filter'] = array('id = ?'=> $insertarr[QB_CUSTOMER_ID]);

		$qb_customer = TableService::GetTabularData($database, $getQBCustomer);
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		$customerId = get_qb_projcustidbyname($QuickBookKeys,$config,$qb_customer['project_customer']);

		if(empty($customerId)){
			die('Customer not mapped to project in QB.');
		}
		if(!empty($user_id)){
			$insertarr[CREATED_BY] = $insertarr[MODIFIED_BY] = $user_id;
		}
		
		if(!empty($_POST[PROJECT_ID])){
			$insertarr[PROJECT_ID] = $_POST[PROJECT_ID];
		}
		if(!empty($_POST[VENDOR_ID])){
			$insertarr[VENDOR_ID] = $_POST[VENDOR_ID];
		}

		if(!empty($_POST[CONTRACT_ID])){
			$insertarr[CONTRACT_ID] = $_POST[CONTRACT_ID];
		}
		if(!empty($_POST[COST_CODE_ID])){
			$insertarr[COST_CODE_ID] = $_POST[COST_CODE_ID];
		}
		if(!empty($_POST[RECIEVED_DATE])){
			$insertarr[RECIEVED_DATE] = date(YMD, strtotime($_POST[RECIEVED_DATE]));
		}
		if(!empty($_POST[APPLICATION_NUMBER])){
			$insertarr[APPLICATION_NUMBER] = $_POST[APPLICATION_NUMBER];
		}
		if(!empty($_POST[PERIOD_TO])){
			$insertarr[PERIOD_TO] = date(YMD,strtotime($_POST[PERIOD_TO]));
		}
		if(!empty($_POST[AMOUNT])){
			$insertarr[AMOUNT] = $_POST[AMOUNT];
		}
		if(!empty($_POST[RETENTION])){
			$insertarr[RETENTION] = $_POST[RETENTION];
		}
		
		if(!empty($_POST[TOTAL])){
			$insertarr[TOTAL] = $_POST[TOTAL];
		}
		if(!empty($_POST[NOTES])){
			$insertarr[NOTES] = $_POST[NOTES];
		}

		$insertarr['contract_remaining'] = $_POST['contract_remaining'];
		if(!empty($_POST['status_id'])){
			$insertarr[SUBCONTRACT_INVOICE_STATUS_ID] = $_POST['status_id'];
		}
		if(!empty($insertarr[SUBCONTRACT_INVOICE_STATUS_ID]) && $insertarr[SUBCONTRACT_INVOICE_STATUS_ID] != '1' ){
			$insertarr['pm_approved'] = date('Y-m-d');
		}

		$invoice_arr = createSubContInvoice($database,$insertarr);
		// To insert the suplier table
		if(!empty($invoice_arr[INVOICE_ID]))
		{
			$supplierids = $_POST['supplierids'];
			$supplierAmounts =  explode('|',trim($_POST['supplierAmounts'],'|'));
			foreach ($supplierids as $key => $supdata) {
				$supplierArr = array('invoice_id'=>$invoice_arr[INVOICE_ID],'prelim_id'=>$supdata,'Amount'=>$supplierAmounts[$key]);
				$ret_sup_arr = createSuppliers($database,$supplierArr);	
			}
		}
		if(!empty($invoice_arr[INVOICE_ID]) && !empty($_POST['file_id']) && !empty($_POST[CONTRACT_TEXT]) && !empty($insertarr[PERIOD_TO])){

			$invoice_id = $invoice_arr[INVOICE_ID];
			$filemanage_file_id = $_POST[FILE_ID];

			$vendor_name = $application_num = '';

			if(!empty($insertarr[VENDOR_ID])){
				$vendor_data = getVendor($database, $insertarr[VENDOR_ID]);
				if(!empty($vendor_data[COMPANY])){
					$vendor_name = $vendor_data[COMPANY];
				}
			}
			if(!empty($insertarr[APPLICATION_NUMBER])){
				$application_num = $insertarr[APPLICATION_NUMBER];
			}
			

			$file_manager_file = FilemanagerFile::findById($database, $filemanage_file_id);
			// Folder
			// Save the file_manager_folders record (virtual_file_path) to the db and get the id

			//2019-07-31\03311 Covi Concrete 073119.pdf 00000 UNCODED _Architects Inc. 1234 081619.pdf
			$RN_virtual_file_path = '/Subcontract Invoice/'.$insertarr[PERIOD_TO] .'/';
			$virtual_file_name_tmp = $_POST['contract_text'].' '.$vendor_name.' '.$application_num.' '.date('mdy',strtotime($insertarr[PERIOD_TO])).'.pdf';

			// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
			$RN_arrFolders = preg_split('#/#', $RN_virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$RN_currentVirtualFilePath = '/';
			foreach ($RN_arrFolders as $RN_folder) {
				$RN_tmpVirtualFilePath = array_shift($RN_arrFolders);
				$RN_currentVirtualFilePath .= $RN_tmpVirtualFilePath.'/';
							// Save the file_manager_folders record (virtual_file_path) to the db and get the id
				$RN_fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $project_id, $RN_currentVirtualFilePath);
				
			}
			// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
			$file_manager_folder_id = $RN_fileManagerFolder->file_manager_folder_id;
			$data = array(
						'virtual_file_name'=>$virtual_file_name_tmp,
						'file_manager_folder_id' => $file_manager_folder_id
					);
			$file_manager_file->setData($data);

			$file_manager_file->save();
			
			update_subinvoiceid($database, $invoice_id, $filemanage_file_id);
	
		}
		echo $invoice_arr[STATUS];
		die;
	}
	if(!empty($_POST[ACTION]) && $_POST[ACTION] =='updateInvoiceStatus'){
		if(empty($_POST[INVOICE_ID]) || empty($_POST[STATUS])){

			$message = 'Required Fields are missing.';
			exit($message);
		}else{
			$invoice_id = $_POST[INVOICE_ID];
			$status_id = $_POST[STATUS];
			$returnval = 'N';
			if(!empty($status_id) && $status_id !='3'){
				$returnval = update_statusid($database, $invoice_id, $status_id);
			}
			exit($returnval);
		}
		die;
	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'synctoqb'){
		
		$return_arr = array('return_val'=>'Y','qb_error_id'=>'');
		if(empty($_POST['invoice_id'])){ // Invoice Id is not passed
			$return_arr['return_val'] = 'Invoice Id is required.';
		}else { // Invoice Id is passed
			$invoice_id = $_POST['invoice_id'];
			$prelim_arr = $_POST['prelim_arr'];
			// create bill data
			$supplier_arr = getPrelimsByInvoiceId($database, $invoice_id);
			/* Fulcrum to QB - start */
			$invoice_arr = getSubContInvoiceData($database, $invoice_id);
			if(!empty($invoice_arr['id'])){
				if(empty($invoice_arr[QB_CUSTOMER_ID])){ // If the Project Mapped Customer of QB is missing
					$return_arr['return_val'] = 'Please Select the Project:Customer';
				}else{ // If the Project Mapped Customer of QB is there
					$getQBCustomer = array();
					$getQBCustomer['table'] = 'qb_customers';
					$getQBCustomer['filter'] = array('id = ?'=> $invoice_arr[QB_CUSTOMER_ID]);

					$qb_customer = TableService::GetTabularData($database, $getQBCustomer);
					$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
					$customerId = get_qb_projcustidbyname($QuickBookKeys,$config,$qb_customer['project_customer']);
					if(empty($customerId)){ // The Project Mapped Customer is not in QB
						$return_arr['return_val'] = 'Customer Not mapped to project in QB.';
					}else{
						$qb_param_arr = array();
						$qb_param_arr[FILE_MANAGER_FILE_ID] = '';
						if(!empty($invoice_arr['invoice_files'])){
							$qb_param_arr[FILE_MANAGER_FILE_ID] = $invoice_arr['invoice_files'];
						}
						
						$qb_param_arr[INVOICE_ID] = $invoice_arr['id'];
						$qb_param_arr[VENDOR_ID] = $invoice_arr[VENDOR_ID];
						$qb_param_arr[COST_CODE_ID] = $invoice_arr[COST_CODE_ID];
						$qb_account_id = getGLAccountDetail($database, $user_company_id, $project_id, $invoice_arr[VENDOR_ID], $invoice_arr[COST_CODE_ID]);
						if(empty($qb_account_id)){ // GL account mapped in QB
							$return_arr['return_val'] = 'Please map GL account in the Accounting Portal.';
						}else{ // GL account is not mapped in QB
							$qb_param_arr['TxnDate'] = $invoice_arr[RECIEVED_DATE];
							$qb_param_arr['DueDate'] = $invoice_arr[PERIOD_TO];
							$qb_param_arr['TotalAmt'] = $invoice_arr['amount']-$invoice_arr['retention'];
							$qb_param_arr[APPLICATION_NUMBER] = $invoice_arr[APPLICATION_NUMBER];
							$qb_param_arr[NOTES] = $invoice_arr[NOTES];
							if(!empty($supplier_arr))
							{
								$vendor_data = getVendor($database, $qb_param_arr[VENDOR_ID]);
								$vendor_name = $vendor_data[COMPANY];
								$qb_param_arr['Desc'] = $vendor_name;
							}else
							{
							$qb_param_arr['Desc'] = $currentlySelectedProjectName.' - APP#'.$invoice_arr[APPLICATION_NUMBER];
							}
							$qb_param_arr['gl_account_id'] = $qb_account_id;
							if(!empty($invoice_arr[QB_EXPENSE_ID])){
								$qb_param_arr[QB_EXPENSE_ID] = $invoice_arr[QB_EXPENSE_ID];
							}
							if(!empty($invoice_arr[QB_ATTACHMENT_ID])){
								$qb_param_arr[QB_ATTACHMENT_ID] = $invoice_arr[QB_ATTACHMENT_ID];
							}
							// if (!empty($prelim_arr)) {
							// 	updatePrelimReleaseDate($database, $prelim_arr);
							// }
							$qb_param_arr['customer_id'] = $customerId;
							$qb_param_arr[PROJECT_ID] = $project_id;
							$qb_param_arr['Project_name'] = $Project_name;
						
							$returnval_arr =  invoicetoExpenses($database, $config, $user_company_id,$qb_param_arr,$supplier_arr);

							$return_arr['return_val'] = $returnval_arr['returnval'];
							$return_arr['qb_error_id'] = $returnval_arr['qb_error_id'];
						}
						

					}
				}
			}
			/* Fulcrum to QB - end */
		}
		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($return_arr);
		die;
	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] =='update_invoice_id'){
		$return_status = 'N';
		if(!empty($_POST[INVOICE_ID]) && !empty($_POST[FILE_ID])){

			$invoice_id = $_POST[INVOICE_ID];
			$filemanage_file_id = $_POST[FILE_ID];
			$invoice_arr = getSubContInvoiceData($database, $invoice_id);
			if(!empty($filemanage_file_id) && !empty($invoice_arr[QB_EXPENSE_ID])){
				$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
				if(!empty($QuickBookKeys[REFRESH_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[REFRESH_TOKEN_EXPIRES])){ // Refresh Token Expire
					exit(REFRESH_TOKEN_EXPIRED);
				}else if(!empty($QuickBookKeys[ACCESS_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[ACCESS_TOKEN_EXPIRES])){ // Access Token Expire
					
					refreshToken($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $user_company_id, $config, $database);
					$QuickBookKeys = getCompanyData($database, $user_company_id);
				}
				
				$file_manager_file_id = $filemanage_file_id;
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
				$parm_arr[QB_EXPENSE_ID] = $invoice_arr[QB_EXPENSE_ID];
				$upload_arr = uploadSubContAttachment($QuickBookKeys, $config, $parm_arr);
				
				if(!empty($upload_arr['file_upload_id']) && !empty($invoice_id)){
					update_qb_attachmentid($database, $invoice_id, $upload_arr['file_upload_id']);
				}
				if(!empty($invoice_arr[QB_ATTACHMENT_ID])){
					deleteAttachmentQB($QuickBookKeys, $config, $invoice_arr[QB_ATTACHMENT_ID]);
				}
			}

			update_subinvoiceid($database, $invoice_id, $filemanage_file_id);


			$return_status = 'Y';
		}
		exit($return_status);
			

	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] =='delete_invoice'){
		$invoice_id = $_POST[INVOICE_ID];
		$return_status = 'N';
		if(!empty($invoice_id)){
			$invoice_arr = getSubContInvoiceData($database, $invoice_id);
			if(!empty($invoice_arr[QB_EXPENSE_ID])){
				$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
				if(!empty($QuickBookKeys[REFRESH_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[REFRESH_TOKEN_EXPIRES])){ // Refresh Token Expire
					exit(REFRESH_TOKEN_EXPIRED);
				}else if(!empty($QuickBookKeys[ACCESS_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[ACCESS_TOKEN_EXPIRES])){ // Access Token Expire
					
					refreshToken($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $user_company_id, $config, $database);
					$QuickBookKeys = getCompanyData($database, $user_company_id);
				}
				$delete_arr = deleteExpenseQB($QuickBookKeys,$config,$invoice_arr[QB_EXPENSE_ID]);
				if(!empty($delete_arr['delete_error'])){
					print_r($delete_arr['delete_error']);
					die;
				}
			}
			$return_status = deleteSubContInvoice($database, $invoice_id);
		}

		exit($return_status);
	}
	if(!empty($_POST[ACTION]) && $_POST[ACTION] =='update_invoice_notes'){
		$return_status = 'N';
		if(!empty($_POST[INVOICE_ID])){

			$update_arr = array();
			$update_arr['invoiceId'] = $_POST[INVOICE_ID];
			$update_arr['notes'] = $_POST[NOTES];
			$update_arr['user_id'] = $user_id;
			$return_status = update_notes($database, $update_arr);
		}
		exit($return_status);
	}
	if(!empty($_POST[ACTION]) && $_POST[ACTION] =='update_invoice_total'){
		$return_status = 'N';
		if(!empty($_POST[INVOICE_ID])){

			$update_arr = array();
			$update_arr['invoiceId'] = $_POST[INVOICE_ID];
			$update_arr['value'] = $_POST[value];
			$update_arr['user_id'] = $user_id;
			$return_status = update_invoice_total($database, $update_arr);

			$totSCLogAmount = getTotalSumFromScLog($database, $_POST[INVOICE_ID]);
			$balanceAmt = number_format($totSCLogAmount['diff'],2);
		}
		echo $balanceAmt;
		die;
	}
	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'checkinvoice_exist'){
	
		$param_arr = array();
		$param_arr[VENDOR_ID] = $_POST[VENDOR_ID];
		$subcontract_id = $_POST[CONTRACT_ID];
		$contract_id = getCostCodeBasedonSubcontract($database, $subcontract_id);

		$param_arr[CONTRACT_ID] = $contract_id;
		$period_to = $_POST[PERIOD_TO];
		
		$param_arr[PERIOD_TO] = date(YMD,strtotime($period_to));
		$param_arr[APPLICATION_NUMBER] = $_POST[APPLICATION_NUMBER];

		$invoice_arr = checkExistenceInvoice($database, $param_arr);
		
		$return_arr = array();
		$return_arr['cost_code_id'] = $contract_id;
		$return_arr['return_val'] = 'Y';
		if(!empty($invoice_arr)){
			$return_arr['return_val'] = 'N';
		}
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($return_arr);
		die;
	}

	if(!empty($_GET[ACTION]) &&  $_GET[ACTION]== 'contractsummary'){
		$param_arr = array();

		$param_arr[PROJECT_ID] = $_GET[PROJECT_ID];
		$param_arr[VENDOR_ID] = $_GET[VENDOR_ID];

		getContractSummary($database, $param_arr);

		die;
	}
	if(!empty($_GET[ACTION]) &&  $_GET[ACTION]== 'billstatus'){

		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		if(!empty($QuickBookKeys[REFRESH_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[REFRESH_TOKEN_EXPIRES])){ // Refresh Token Expire
			exit(REFRESH_TOKEN_EXPIRED);
		}else if(!empty($QuickBookKeys[ACCESS_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[ACCESS_TOKEN_EXPIRES])){ // Access Token Expire
			
			refreshToken($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $user_company_id, $config, $database);
			$QuickBookKeys = getCompanyData($database, $user_company_id);
		}
		$dataService =  getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $config);

		$Bill = $dataService->FindbyId('bill', 162);
		echo '<pre>';
		print_r($Bill);

	}

	if(!empty($_GET[ACTION]) && $_GET[ACTION] =='updateQBCustomerInvoice'){
		$qb_customer = $_GET['qb_customer'];
		$invoice_id = $_GET['invoice_id'];
		$returnval = 0;
		if(!empty($qb_customer) && !empty($invoice_id)){ // Has QB Customer & Invoice Id

			$table_options = array();
			$table_options['table'] =  'subcontract_invoices';
			$upd_arr = array();
			$upd_arr[QB_CUSTOMER_ID.' = ?'] = $qb_customer;
			if(!empty($user_id)){
				$upd_arr[MODIFIED_BY.' = ?'] = $user_id;
			}
			$upd_arr['modified = ?'] = date('Y-m-d H:i:s');
			$table_options['update'] = $upd_arr;
			$table_options['filter'] = array('id = ?'=>$invoice_id);

			$returnval = TableService::UpdateMultipleTabularData($database, $table_options);
		}
		
		exit($returnval);
	}

	if(!empty($_GET[ACTION]) && $_GET[ACTION] =='checkVendorExist'){ // Check Vendor Exist
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		if(!empty($QuickBookKeys[REFRESH_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[REFRESH_TOKEN_EXPIRES])){ // Refresh Token Expire
			exit(REFRESH_TOKEN_EXPIRED);
		}else if(!empty($QuickBookKeys[ACCESS_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[ACCESS_TOKEN_EXPIRES])){ // Access Token Expire
			
			refreshToken($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $user_company_id, $config, $database);
			$QuickBookKeys = getCompanyData($database, $user_company_id);
		}

		$return_arr = array('message'=>'','vendor_id'=>'','vendor_name'=>'','qb_vendor_id'=>'');

		$vendor_id = $_GET['vendor_contact_company_id'];
		if(empty($vendor_id)){
			$return_arr['message'] = 'Vendor Id is Required.';
		}else{
			$return_arr['vendor_id'] = $vendor_id;
			$vendor_data = getVendor($database, $vendor_id);
			if(empty($vendor_data['company'])){
				$return_arr['message'] = 'Vendor Name is Required.';
			}else{
				$vendor_qb_id = getVendorQB($QuickBookKeys,$config,$vendor_data['company']);
				$return_arr['vendor_name'] = $vendor_data['company'];
				if(!empty($vendor_qb_id)){
					$return_arr['message'] = 'VendorExists';
					$return_arr['qb_vendor_id'] = $vendor_qb_id;
				}else{
					$return_arr['message'] = 'VendorNotExists';
				}
			}
		}
		
		
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($return_arr);
		
		die;
	}

	if(!empty($_GET[ACTION]) && $_GET[ACTION] == 'create_vendor'){

		if(!empty($_GET['vendor_name'])){
			$vendor_name = $_GET['vendor_name'];
		}
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		if(!empty($QuickBookKeys[REFRESH_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[REFRESH_TOKEN_EXPIRES])){ // Refresh Token Expire
			exit(REFRESH_TOKEN_EXPIRED);
		}else if(!empty($QuickBookKeys[ACCESS_TOKEN_EXPIRES]) &&  strtotime("now") > strtotime($QuickBookKeys[ACCESS_TOKEN_EXPIRES])){ // Access Token Expire
			
			refreshToken($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $user_company_id, $config, $database);
			$QuickBookKeys = getCompanyData($database, $user_company_id);
		}
		$vendor_arr = createUpdVendorQB($QuickBookKeys, $config, $vendor_name);
		$response_msg = 'Error in Creation of Vendor';
		if(!empty($vendor_arr['vendor_error'])){
			$response_msg = $vendor_arr['vendor_error'];
		}else if(empty($vendor_arr[VENDOR_ID])){
			$response_msg =  'Vendor Id of QB is not available';
		}else if(is_numeric($vendor_arr[VENDOR_ID])){
			$response_msg = 'vendorcreated';
		}
		print_r($response_msg);
		die;
	}

	if(!empty($_GET[ACTION]) && $_GET[ACTION] == 'createPurchaseOrder'){
		$return_arr = array('return_val'=>'Y','qb_error_id'=>'');
		if(!empty($_GET['subcontract_template_id'])){
			$subcontract_template_id = $_GET['subcontract_template_id'];
			$subcontract_actual_value = $_GET['subcontract_actual_value'];
			$vendor_contact_company_id = $_GET['vendor_contact_company_id'];
			$cost_code_division_id = $_GET['cost_code_division_id'];
			$cost_code_id = $_GET['cost_code_id'];
			$target_execution = $_GET['target_execution'];
			$project_customer = $_GET['project_customer'];
			$gl_account_id = $_GET['gl_account_id'];

			if(empty($gl_account_id)){ // GL Account ID mapping is missing
				$return_arr['return_val'] = 'Please map the GL account in Accounting Portal.';
			}else{
				$checkSubContractTemplateisPO = checkSubContractTemplateisPO($database, $subcontract_template_id);
				if($checkSubContractTemplateisPO == 'Y'){ // Subcontract is a Purchase Order or Purchase Agreement

					$costCodeData = getCostCodeDataById($database, $cost_code_id, $cost_code_division_id);

					$vendorData = getVendor($database, $vendor_contact_company_id);
					$qb_param_arr = array();
					$qb_param_arr['division_number'] = $costCodeData['division_number'];
					$qb_param_arr['cost_code'] = $costCodeData['cost_code'];
					$qb_param_arr['cost_code_description'] = $costCodeData['cost_code_description'];
					$qb_param_arr['vendor_name'] = $vendorData['company'];
					$qb_param_arr['vendor_contact_company_id'] = $vendorData['id'];
					$qb_param_arr['subcontract_actual_value'] = $subcontract_actual_value;
					$qb_param_arr['target_execution'] = $target_execution;
					$qb_param_arr['TotalAmt'] = $subcontract_actual_value;
					$qb_param_arr['project_customer'] = $project_customer;
					$qb_param_arr['gl_account_id'] = $gl_account_id;
					$returnval_arr =  PurchaseOrderToQB($database, $config, $user_company_id,$qb_param_arr);
					$return_arr['return_val'] = $returnval_arr['returnval'];
					$return_arr['qb_error_id'] = $returnval_arr['qb_error_id'];
				}
			}	
		}else{
			$return_arr['return_val'] ='Subcontract Template Id is required.';
		}
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($return_arr);
	}

	if(!empty($_GET[ACTION]) && $_GET[ACTION] == 'checkSubContractTemplateType'){
		$return_arr = array('template_type'=>'','is_po'=>'0','is_gl_account_available'=>'0','error'=>'','gl_account_id'=>'0');
		if(!empty($_GET['subcontract_template_id'])){
			$subcontract_template_id = $_GET['subcontract_template_id'];
			$checkSubContractTemplate = getSubContractTemplateType($database, $subcontract_template_id);
		
			$table_options_arr = array();
			$table_options_arr['table'] = 'qb_subcontract_accounts';
			$table_options_arr['filter'] = array('company_id = ?'=>$user_company_id, 'project_id = ?'=>$project_id,'subcontract_type_id = ?'=>$checkSubContractTemplate['subcontract_type_id']);
			$getSubContractAccount = TableService::GetTabularData($database, $table_options_arr);
			if(!empty($getSubContractAccount['qb_account_id'])){
				$return_arr['is_gl_account_available'] = '1';
				$return_arr['gl_account_id'] = $getSubContractAccount['qb_account_id'];
			}
			if(!empty($checkSubContractTemplate['subcontract_type'])){
				$return_arr['template_type'] = $checkSubContractTemplate['subcontract_type'];
			}
			$purchase_order_type = array('Internal Purchase Agreement','External Purchase Agreement','Purchase Order');
			if(!empty($checkSubContractTemplate['subcontract_type']) && in_array($checkSubContractTemplate['subcontract_type'],$purchase_order_type)){
				$return_arr['is_po'] = '1';
			}


		}else{
			$return_arr['error'] = 'Subcontract Template Id is required.';
		}
    	header('Content-type: application/json');
		echo json_encode($return_arr);
	}

	if(!empty($_POST[ACTION]) && $_POST[ACTION] == 'contractAmount'){

		 $contract_id = $_POST['contract_id'];
		
		$conAmt = TableService::getSingleField($database,'subcontracts','subcontract_actual_value','id',$contract_id);
		$preamount = TableService::getSingleField($database,'subcontract_invoices','sum(total)','subcontract_id',$contract_id);
		// To get the SCO approved amount
		$scoamt= SCOAmountAginstSubcontractor($database,$contract_id);
		$contract_amt = ($conAmt+$scoamt) - $preamount;
		echo $contract_amt;
		die;

	}
?>

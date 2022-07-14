<?php
	//require_once('../vendor/quickbooks/vendor/autoload.php');
	
	require_once('accounting-quickbook.php');


	use QuickBooksOnline\API\DataService\DataService;
	use QuickBooksOnline\API\Facades\Bill;
	//use QuickBooksOnline\API\Facades\Purchase;
	use QuickBooksOnline\API\Facades\Account;
	use QuickBooksOnline\API\Facades\Vendor;
	use QuickBooksOnline\API\Facades\PurchaseOrder;
	use QuickBooksOnline\API\Data\IPPReferenceType;
	use QuickBooksOnline\API\Data\IPPAttachableRef;
	use QuickBooksOnline\API\Data\IPPAttachable;

	function uploadSubContAttachment($QuickBookKeys, $config, $param_arr){
		$dataService = getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID],$config);
		
		$filepath = $param_arr['file_path'];
		
		// Prepare entities for attachment upload
		$imageBase64 = array();
		$imageBase64['application/pdf'] = echoBase64($filepath);
		$sendMimeType = "application/pdf";
		// Create a new IPPAttachable
		$randId = rand();
		$entityRef = new IPPReferenceType(array('value'=>$param_arr['qb_expense_id'], 'type'=>'Bill'));
		$attachableRef = new IPPAttachableRef(array('EntityRef'=>$entityRef));
		$objAttachable = new IPPAttachable();
		$objAttachable->FileName = basename($param_arr['file_name'], ".pdf").".pdf";
		$objAttachable->AttachableRef = $attachableRef;
		//$objAttachable->Category = 'Image';
		$objAttachable->Tag = 'Tag_' . $randId;
		// Upload the attachment to the Bill
		$resultObj = $dataService->Upload(base64_decode($imageBase64[$sendMimeType]),
		$objAttachable->FileName,
		$sendMimeType,
		$objAttachable);

		$error = $dataService->getLastError();

		$file_upload_arr = array('file_upload_error'=>'','file_upload_id'=>'');
		if ($error){
			$file_upload_arr['file_upload_error'] = $error->getResponseBody();
		}
		if(!empty($resultObj->Attachable->Id)){
			$file_upload_arr['file_upload_id'] = $resultObj->Attachable->Id;
		}
		return $file_upload_arr;
	}
	
	function echoBase64($filename){
		$contents = file_get_contents($filename);
		$base64_contents = base64_encode($contents);
		$base64_contents_split = str_split($base64_contents, 80);
		$imageBase64 = "\"\" . \n";
		foreach ($base64_contents_split as $one_line) {
			$imageBase64.= "\t\t\"{$one_line}\" . \n";
		}
		$imageBase64 .= "\t\t\"\";\n";
		return $imageBase64;
	}

	function createExpensesQB($QuickBookKeys, $config, $param_arr,$supplier_arr){
		$dataService = getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID],$config);

		$accountBasedExpenseLineDetail = array();
		$accountBasedExpenseLineDetail['AccountRef'] = array(
						                    "name"=> $param_arr['category_name'], 
											"value"=> $param_arr['category_id']
						                );
		if(!empty($param_arr['customer_id'])){
			$accountBasedExpenseLineDetail['CustomerRef'] = array(
						            		"value"=> $param_arr['customer_id']
						            	);
		}
		// Vendor recod
		$SupLinearr=array();
		$SupLinearr[] =array(
		            "Id" => "1",
		            "Amount" => $param_arr['TotalAmt'],
		            "DetailType" => "AccountBasedExpenseLineDetail",
		            "AccountBasedExpenseLineDetail" => $accountBasedExpenseLineDetail,
		            "Description"=> $param_arr['Desc']
		        );
		// joint record
		if(!empty($supplier_arr))
		{
			$lineId =1;
			foreach ($supplier_arr as $key => $supvalue) {
				$lineId = $lineId +1;
				$SupLinearr[] =array(
					"Id" => $lineId,
					"Amount" => $supvalue['Amount'],
					"DetailType" => "AccountBasedExpenseLineDetail",
					"AccountBasedExpenseLineDetail" => $accountBasedExpenseLineDetail,
					"Description"=> $supvalue['supplier']);
			}
		}
		
		$expense_arr = 	array(
							"DocNumber" => $param_arr[APPLICATION_NUMBER],
							"PrivateNote" => $param_arr['Project_name'],
							"TxnDate"=> $param_arr['TxnDate'],
							"TotalAmt"=>$param_arr['TotalAmt'],
							"Memo" => $param_arr['Project_name'],
							"VendorRef" => array(
							        "name" => $param_arr['vendor_name'], 
									"value" => $param_arr[VENDOR_ID]
						    ),
						    "SalesTermRef"=>  array(
						      "value"=> "3"
						    ), 
						    "DueDate"=> $param_arr['DueDate'],
						    "Line" => $SupLinearr,
    						// "Line" => array(
						    //     array(
						    //         "Id" => "1",
						    //         "Amount" => $param_arr['TotalAmt'],
						    //         "DetailType" => "AccountBasedExpenseLineDetail",
						    //         "AccountBasedExpenseLineDetail" => $accountBasedExpenseLineDetail,
						    //         "Description"=> $param_arr['Desc']
						    //     )
						    // )
						);
		
	
		if(!empty($param_arr['qb_expense_id'])){
			$purchase_arr = $dataService->FindbyId('bill', $param_arr['qb_expense_id']);
		}

		if(!empty($purchase_arr)){
			$theResourceObj = Bill::update($purchase_arr , $expense_arr);
			$resultingObj = $dataService->Update($theResourceObj);
		}else{
			$theResourceObj = Bill::create($expense_arr);
			$resultingObj = $dataService->Add($theResourceObj);
		}
		
		// for joint check record
		// if(!empty($newexpense_arr)){
				// $theResourceObj1 = Bill::create($newexpense_arr);
			// $resultingObj1 = $dataService->Add($theResourceObj1);				
			// }

		$error = $dataService->getLastError();
		$ret_expense_arr = array('expense_error'=>'','expense_id'=>'');
		if ($error) {
			$ret_expense_arr['expense_error'] = $error->getResponseBody();
		}
		if(!empty($resultingObj->Id)){
			$ret_expense_arr['expense_id'] = $resultingObj->Id;
		}
		return $ret_expense_arr;				  
	}

	function createPurchaseOrderQB($QuickBookKeys, $config, $param_arr){
		$dataService = getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID],$config);
		$accountBasedExpenseLineDetail = array();
		$accountBasedExpenseLineDetail['AccountRef'] = array(
						                    "name"=> $param_arr['category_name'], 
											"value"=> $param_arr['category_id']
						                );
		if(!empty($param_arr['customer_id'])){
			$accountBasedExpenseLineDetail['CustomerRef'] = array(
						            		"value"=> $param_arr['customer_id']
						            	);
		}


		$PurchaseOrder_arr = array(
								"VendorRef" => array(
								        "name" => $param_arr['vendor_name'], 
										"value" => $param_arr[VENDOR_ID]
							    ),
								"Line" => array(
							        array(
							            "Id" => "1",
							            "Amount" => $param_arr['TotalAmt'],
							            "DetailType" => "AccountBasedExpenseLineDetail",
							            "AccountBasedExpenseLineDetail" => $accountBasedExpenseLineDetail,
							            "Description"=> $param_arr['Desc']
							        )
						    	)
							);

		$theResourceObj = PurchaseOrder::create($PurchaseOrder_arr);
		$resultingObj = $dataService->Add($theResourceObj);

		$error = $dataService->getLastError();
		$ret_purchaseOrder_arr = array('purchase_order_error'=>'','purchase_order_id'=>'');
		if ($error) {
			$ret_purchaseOrder_arr['purchase_order_error'] = $error->getResponseBody();
		}
		if(!empty($resultingObj->Id)){
			$ret_purchaseOrder_arr['purchase_order_id'] = $resultingObj->Id;
		}
		return $ret_purchaseOrder_arr;
	}

	function createUpdCategoryQB($QuickBookKeys, $config, $category_arr){
		$dataService = getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID],$config);
		$get_category_arr = getCategoryArrQB($QuickBookKeys,$config,$category_arr);
		$ret_category_arr = array('category_error'=>'','category_name'=>'','category_id'=>'');
		$ret_cat_id = '';
		if(!empty($get_category_arr)){
			$ret_cat_id = $get_category_arr->Id;
		}else{
			$request_category_arr = array(
								"Name" => $category_arr['name'], 
								"AccountType"=>$category_arr['account_type'],
								"AccountSubType"=>$category_arr['account_sub_type'],
								"SubAccount"=>'true',
								"ParentRef"=>$category_arr['id']
							);
			
			$theResourceObj = Account::create($request_category_arr);
			$resultingObj = $dataService->Add($theResourceObj);
			$error = $dataService->getLastError();
			if ($error) {
				$ret_category_arr['category_error'] = $error->getResponseBody();
			}
			if(!empty($resultingObj->Id)){
				$ret_cat_id = $resultingObj->Id;
			}
		}
		$ret_category_arr['category_name'] = $category_arr['name'];
		$ret_category_arr['category_id'] = $ret_cat_id;

		return $ret_category_arr;
	}

	function getCategoryArrQB($QuickBookKeys, $config, $category_arr, $subAccount ='0', $parentRef = ''){ // To check the Account exist
		$dataService =  getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID],$config);
		$subAccountQuery = " AND SubAccount = false ";
		if(empty($subAccount)){
			$subAccountQuery = " AND SubAccount = true ";
		}
		$parentAccountQuery = '';
		if(!empty($ParentRef)){
			$parentAccountQuery = ' AND ParentRef ='.$parentRef;
		}
		$query = "Select * from Account where Name = '".$category_arr['name']."' AND  AccountType = '".$category_arr['account_type']."' AND AccountSubType = '".$category_arr['account_sub_type']."' ".$subAccountQuery.' '.$parentAccountQuery;
		$category = $dataService->Query($query);
		$cat_arr = '';
		if(!empty($category['0']->Id)){
			$cat_arr = $category['0'];
		}
		return $cat_arr;
	}

	function createUpdVendorQB($QuickBookKeys, $config, $vendor_name){ //Vendor Creation and Updates
		
		$dataService = getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID],$config);
		$vendor = getVendorQB($QuickBookKeys,$config,$vendor_name);
		$ret_vendor_arr = array('vendor_error'=>'','vendor_id'=>'','vendor_name'=>'');

		$ret_vendor_id = '';
		if(!empty($vendor)){
			$ret_vendor_id = $vendor;
		}else{
			$vendor_arr = array(
				"DisplayName" => $vendor_name,
				"CompanyName" => $vendor_name, 
				"GivenName" => $vendor_name, 
				"PrintOnCheckName" => $vendor_name
			);	
			$theResourceObj = Vendor::create($vendor_arr);
			$resultingObj = $dataService->Add($theResourceObj);
			$error = $dataService->getLastError();
			
			if ($error) {
				$ret_vendor_arr['vendor_error'] = $error->getResponseBody();
			}
			if(!empty($resultingObj->Id)){
				$ret_vendor_id = $resultingObj->Id;
			}
		}
		$ret_vendor_arr['vendor_name'] = $vendor_name;
		$ret_vendor_arr['vendor_id'] = $ret_vendor_id;
		return $ret_vendor_arr;
	}


	function getVendorQB($QuickBookKeys,$config,$vendor){
		$dataService =  getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID],$config);

		$query = "Select * from Vendor where DisplayName = '".$vendor."'";
		$vendor = $dataService->Query($query);
		
		$vendor_id = '';
		if(!empty($vendor['0']->Id)){
			$vendor_id = $vendor['0']->Id;
		}
		return $vendor_id;

	}

	function deleteExpenseQB($QuickBookKeys, $config, $expenseID){
		$dataService =  getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $config);

		$Expense = $dataService->FindbyId('bill', $expenseID);
		$resultingObj = $dataService->Delete($Expense);
		
		$ret_error = array('delete_error'=>'','delete_id'=>'');
		$error = $dataService->getLastError();
		if ($error) {
			$ret_error['delete_error'] =  $error->getResponseBody();
		} else {
			$ret_error['delete_id'] = $resultingObj->Id;
		}
		return $ret_error;
	}

	function deleteAttachmentQB($QuickBookKeys, $config, $attachmentID){
		$dataService =  getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $config);


		$attachable = $dataService->FindbyId('attachable', $attachmentID);
		
		$entityRef = new IPPReferenceType(array('value'=>$attachable->AttachableRef->EntityRef, 'type'=>'Bill'));
		$attachableRef = new IPPAttachableRef(array('EntityRef'=>$entityRef));
		

		$attachable->AttachableRef = $attachableRef;
		$resultingObj = $dataService->Delete($attachable);
		$error = $dataService->getLastError();

		$delete_attachment_arr = array('delete_attachment_arr'=>'','delete_attachment_id'=>'');
		if ($error) {
			$delete_attachment_arr['delete_attachment_arr'] = $error->getResponseBody();
		}
		if(!empty($resultingObj->Id)){
			$delete_attachment_arr['delete_attachment_id'] = $resultingObj->Id;
		}
		return $delete_attachment_arr;
	}

	function getbillarrById($QuickBookKeys, $config, $subcontinvoice_arr){
		$subcontinvoice = "'" . implode ( "', '", $subcontinvoice_arr ) . "'";

		$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
		$query = "Select * from Bill WHERE Id IN (".$subcontinvoice.")";
		$Subcont_invoices = $dataService->Query($query);

		return $Subcont_invoices;
	}

	function getBillById($QuickBookKeys, $config, $expense_id){

		$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
		$Expense = $dataService->FindbyId('bill', $expense_id);

		return $Expense;
	}
	


?>

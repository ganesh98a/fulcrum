<?php
	/*
		drawTotalvalue --> Overall Current App Value
		qb_invoicestatus --> Quickbooks Invoice Status
		accountingportals --> Accounting Portal Filter
		getsignatureblock --> Get the Signature Block Contents
	*/	

	function drawTotalvalue($database, $projectId, $drawData ){ // Overall draw Total
 		$totalProjectCurrentApp = 0;
 		if(!empty($drawData)){
			$isDrawDisbaled = true;
			$budgetGridHtml = renderBudgetGridHtml($projectId, $drawData['id'], $drawData['application_number'],$isDrawDisbaled);
			$totalBudgetCurrentApp = $budgetGridHtml['totalBudgetCurrentApp'];
			$changeOrderGridHtml = renderChangeOrderGridHtml($projectId, $drawData['id'], $drawData['application_number'],$isDrawDisbaled);
			$totalCoCurrentApp = $changeOrderGridHtml['totalCoCurrentApp'];
			$totalProjectCurrentApp = $totalBudgetCurrentApp+$totalCoCurrentApp;
 		}
		return $totalProjectCurrentApp;
	}
	function retentionDrawTotalValue($database, $projectId, $drawData){
		
		$totalProjectCurrentRetainerVal = 0;
 		if(!empty($drawData)){
			$isRetentionDisbaled = true;
			$budgetGridHtml = renderRetentionBudgetGridHtml($database, $projectId, $drawData['id'], $drawData['application_number'], $isRetentionDisbaled);
			$totalBudgetCurrentRetainerValue = $budgetGridHtml['totalBudgetCurrentRetainerValue'];

			$getTabIndex = $budgetGridHtml['tabIndex'];

			$changeOrderGridHtml = renderRetentionChangeOrderGridHtml($database, $projectId, $drawData['id'], $drawData['application_number'], $isRetentionDisbaled, $getTabIndex);
			
			$totalCOCurrentRetainerValue = $changeOrderGridHtml['totalCOCurrentRetainerValue'];

			$totalProjectCurrentRetainerVal = $totalBudgetCurrentRetainerValue + $totalCOCurrentRetainerValue;
		}
		return $totalProjectCurrentRetainerVal;

	}
	function qb_invoicestatus($invoice){ // Get the Quickbooks Invoice Status
		$invoicestatus = '';
		if(!empty($invoice->Balance) && $invoice->TotalAmt != $invoice->Balance){
				$invoicestatus  = 'Partial Paid';
		}else if(empty($invoice->Balance)){
				$invoicestatus  = 'Paid';
		}else if(!empty($invoice->EInvoiceStatus) && $invoice->EInvoiceStatus =='Sent'){
			$invoicestatus  = 'Sent';
		}else if(!empty($invoice->EInvoiceStatus) && $invoice->EInvoiceStatus =='Viewed'){
			$invoicestatus  = 'Viewed';
			if(!empty($invoice->Balance) && $invoice->TotalAmt == $invoice->Balance){
				$invoicestatus  = 'Viewed';
			}else if(empty($invoice->Balance)){
				$invoicestatus  = 'Paid';
			}
		}else if(empty($invoice->EInvoiceStatus)){
			if(!empty($invoice->Balance) && $invoice->TotalAmt != $invoice->Balance && !empty($invoice->EmailStatus) && $invoice->EmailStatus !='EmailSent'){
				$invoicestatus  = 'Partial Paid';
			}elseif(empty($invoice->Balance)  && !empty($invoice->EmailStatus) && $invoice->EmailStatus !='EmailSent'){
				$invoicestatus  = 'Deposited';
			}else {
				$invoicestatus  = 'Not Sent';
			}
		}
		return $invoicestatus;
	}

	
	

	function accountingportals($database,$selectedportal,$readonly){ // Accounting Portal Filter
		$accountingportals = getAccountingPortals($database);
		$listId="accounting_portal";
		$listClass="";
		$listjs="";
		/*if(!empty($readonly)){
			$listjs="disabled";
		}*/
		$liststyle="";
		$listDefault="Please select a Accounting Portal";
		$res_drop=selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$accountingportals,$selectedportal);
		$permissionTableTbody = <<<END_PER_TABLE_TBODY
	$res_drop
END_PER_TABLE_TBODY;
		return $permissionTableTbody;
	}

	function getContractingEntities($database,$ContractingEntities,$selectedEntity,$readonly){
		$listId="contracting_entity";
		$listClass="";
		$listjs="disabled";
		/*if(!empty($readonly)){
			$listjs="disabled";
		}*/
		$liststyle="width:100%;";
		$listDefault="";
		$res_drop=selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$ContractingEntities,$selectedEntity);
		$permissionTableTbody = <<<END_PER_TABLE_TBODY
	$res_drop
END_PER_TABLE_TBODY;
		return $permissionTableTbody;
	}

	
	
	function getsignatureblock($database, $project_id ,$applicationId,$user_company_id,$debugMode,$user_id, $type =''){

		
		if(!empty($type) && $type=='retention'){
			$draw_id = RetentionDraws::findLastRetentionIdUsingAppId($database, $project_id, $applicationId);
			$drawData = RetentionDraws::findById($database, $draw_id);
		
			$totalval = retentionDrawTotalValue($database, $project_id, $drawData);
		}else{
			$draw_id = Draws::findLastDrawIdUsingAppId($database, $project_id, $applicationId);
			$drawData = Draws::findById($database, $draw_id);
			$totalval = drawTotalvalue($database, $project_id, $drawData);
		}
		


		$project = Project::findById($database, $project_id);
		
		$drawStatus = $drawData['status'];
		$isDrawDisbaled = false;
		$disabled = '';
		$hideButtonForPosted = '';

		$projectOwnerName = $project->project_owner_name;
		$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $project->user_company_id);
		// /* @var $userCompany UserCompany */
		$userCompanyName = $userCompany->user_company_name;
		// get all signature Types
		$loadSignatureTypeOptions = new Input();
		$loadSignatureTypeOptions->forceLoadFlag = true;
		$arrSignatureTypeArr = DrawSignatureType::loadAllDrawSignatureType($database, $loadSignatureTypeOptions);

  		$signatureTypArr = array();

  		$signatureTypArr['currentApp'] = $totalval;
  		$signatureTypArr['drawId'] = intVal($draw_id);
  		$signatureTypArr['qb_invoiceid'] = '';

  		$signatureTypArr['project_name'] = $project->project_name;
  		$signatureTypArr['user_custom_project_id'] = $project->user_custom_project_id;

  		if(!empty($drawData['quickbook_invoice_id'])){
  			$signatureTypArr['qb_invoiceid'] = $drawData['quickbook_invoice_id'];
  		}
  		$signatureTypArr['qb_invoiceid'] = $drawData['quickbook_invoice_id'];
  		$signatureTypArr['qb_itemid'] = $drawData['quickbook_item_id'];
  		$signatureTypArr['company'] = $userCompanyName;
  		$signatureTypArr['application_number'] = $drawData['application_number'];
  		$signatureTypArr['through_date'] = $drawData['through_date'];

  		$signatureTypArr['project_id'] =  $project_id;
  		$signatureTypArr['user_id'] =  $user_id;

  		
  		foreach($arrSignatureTypeArr as $signatureTypeId => $signatureTypes) {
		  	// get signature block id
			$loadSignatureBlockOptions = new Input();
			$loadSignatureBlockOptions->forceLoadFlag = true;
			$loadSignatureBlockOptions->arrOrderByAttributes = array(
				'dsb.`id`' => 'ASC'
			);
			if(!empty($type) && $type=='retention'){
				$signatureBlockArr = RetentionSignatureBlocks::findByRetentionSignatureBlocksById($database, $signatureTypeId, $project_id, $draw_id, $loadSignatureBlockOptions);
			}else{
				$signatureBlockArr = DrawSignatureBlocks::findByDrawSignatureBlocksById($database, $signatureTypeId, $project_id, $draw_id, $loadSignatureBlockOptions);
			}
			
			$otherCount = 0;
			if($signatureTypeId == 6){
				$otherCount = count($signatureBlockArr);
				if($otherCount == 0){
					$otherCount = 1;
				}
			}
			$updatedDescflag = 'N';
			if(isset($signatureBlockArr) && !empty($signatureBlockArr)) {
				$counti = 0;
				foreach($signatureBlockArr as $signature_block_id => $signatureBolck) {
					if($counti > 0){
						break;
					}
					$signatureBlockId = $signatureBolck->signature_block_id;
					$enable_flag = $signatureBolck->enable_flag;
					$description = $signatureBolck->signature_block_description;
					$updatedDescflag = $signatureBolck->signature_block_desc_update_flag;
					$counti++;
				}
				if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
					$description = $userCompanyName;
				}
				if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
					$description = $projectOwnerName;
				}
		
			} else {
				$description = '';
				if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
					$description = $userCompanyName;
				}
				if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
					$description = $projectOwnerName;
				}
				$signatureBlockId = 0;

				$enable_flag = '';
			}
			$signatureTypeBlockHtmlInput = '';
		    $uniqueId = $signatureTypes->signature_type_entity."1";
		    $uniqueId =str_replace(' ','_',$uniqueId);
		    $signType = str_replace(' ','_',$signatureTypes->signature_type_entity);
    
    
		    if($signatureTypes->signature_type_default_editable_flag == 'Y' && $signatureTypeId != 5) {
		          $signatureTypeBlockHtmlInput = $description;
		    } else {
		    	if($signatureTypes->signature_type_default_editable_flag == 'Y') {
					$signatureTypeBlockHtmlInput = $description;
		    	}
		    }    
		    $signatureTypeBlockHtmlInputCLTR = '';

    		if($signatureTypeId == 5) {
      			// get Signature block CL (Construction Lender)

				$loadSignatureBlockCLOptions = new Input();
				$loadSignatureBlockCLOptions->forceLoadFlag = true;
				if(!empty($type) && $type=='retention'){
					$arrSBCL = RetentionSignatureBlocksConstructionLender::loadRetentionSignatureBlocksCLBySBId($database, $signatureBlockId, $loadSignatureBlockCLOptions);
				}else{
					$arrSBCL = DrawSignatureBlocksConstructionLender::loadDrawSignatureBlocksCLBySBId($database, $signatureBlockId, $loadSignatureBlockCLOptions);
				}


				
				$address1 = '';
				$address2 = '';
				$city_state_zip = '';
				$sb_cl_id = 0;
		      	if(isset($arrSBCL) && !empty($arrSBCL)) {
		      		$sb_cl_id = $arrSBCL->signature_block_construction_lender_id;
		      		$address1 = $arrSBCL->signature_block_construction_lender_address_1;
		      		$address2 = $arrSBCL->signature_block_construction_lender_address_2;
		      		$city_state_zip = $arrSBCL->signature_block_construction_lender_city_state_zip;
		      	}
				$signatureTypArr['address'] = array();
				$signatureTypArr['address']['Address 1'] = $address1;
				$signatureTypArr['address']['Address 2'] = $address2;
				$addressarr = explode(',',$city_state_zip);

				$signatureTypArr['address']['city'] = $addressarr[0];
				$signatureTypArr['address']['state'] = $addressarr[1];
				$signatureTypArr['address']['zip'] = $addressarr[2];
      
    		}

    		$signature_types = str_replace(' ','_',$signatureTypes->signature_type_entity);
			$signatureTypArr[$signature_types] = array();
			$signatureTypArr[$signature_types]['description'] = $signatureTypeBlockHtmlInput;
			$signatureTypArr[$signature_types]['enableflag'] = $enable_flag;
			$signatureTypArr[$signature_types]['signatureTypeId'] = intVal($signatureTypeId);
			$signatureTypArr[$signature_types]['projectId'] = intVal($project_id);
			$signatureTypArr[$signature_types]['drawId'] = intVal($draw_id);
			$signatureTypArr[$signature_types]['signatureBlockId'] = intVal($signatureBlockId);
			if(!empty($signatureBolck->quickbook_cust_id)){
				$signatureTypArr[$signature_types]['quickbook_cust_id'] = intVal($signatureBolck->quickbook_cust_id);
			}
		}
		//  other more than 2
	  	// get signature block id
		$loadSignatureBlockOptions = new Input();
		$loadSignatureBlockOptions->forceLoadFlag = true;
		$loadSignatureBlockOptions->arrOrderByAttributes = array(
			'dsb.`id`' => 'ASC'
		);
		if(!empty($type) && $type=='retention'){
			$signatureBlockArr = RetentionSignatureBlocks::findByRetentionSignatureBlocksById($database, $signatureTypeId, $project_id, $draw_id, $loadSignatureBlockOptions);
		}else{
			$signatureBlockArr = DrawSignatureBlocks::findByDrawSignatureBlocksById($database, $signatureTypeId, $project_id, $draw_id, $loadSignatureBlockOptions);
		}
		$updatedDescflag = 'N';
		if(isset($signatureBlockArr) && !empty($signatureBlockArr)) {
			$counti = 0;
			foreach($signatureBlockArr as $signature_block_id => $signatureBolck) {
				if($counti == 0){
					$counti++;
					continue;
				}
				$signatureBlockId = $signatureBolck->signature_block_id;
				$enable_flag = $signatureBolck->enable_flag;
				$description = $signatureBolck->signature_block_description;
				$updatedDescflag = $signatureBolck->signature_block_desc_update_flag;

				if($updatedDescflag == 'N' && ($signatureTypeId == 1)){
					$description = $userCompanyName;
				}
				if($updatedDescflag == 'N' && ($signatureTypeId == 2)){
					$description = $projectOwnerName;
				}
		
				$signatureTypeBlockHtmlInput = '';
				$uniqueId = $signatureTypes->signature_type_entity.($counti+1);
				$uniqueId =str_replace(' ','_',$uniqueId);
				$signType = str_replace(' ','_',$signatureTypes->signature_type_entity);
				
				if($signatureTypes->signature_type_default_editable_flag == 'Y' && $signatureTypeId != 5) {
        			$signatureTypeBlockHtmlInput = $description;
				}
      
				$signature_types = str_replace(' ','_',$signatureTypes->signature_type_entity);

		   		$signatureTypArr[$signature_types] = array();
			   	$signatureTypArr[$signature_types]['description'] = $signatureTypeBlockHtmlInput;
				$signatureTypArr[$signature_types]['enableflag'] = $enable_flag;

				$signatureTypArr[$signature_types]['signatureTypeId'] = intVal($signatureTypeId);
				$signatureTypArr[$signature_types]['projectId'] = intVal($project_id);
				$signatureTypArr[$signature_types]['drawId'] = intVal($draw_id);
				$signatureTypArr[$signature_types]['signatureBlockId'] = intVal($signatureBlockId);
				if(!empty($signatureBolck->quickbook_cust_id)){
					$signatureTypArr[$signature_types]['quickbook_cust_id'] = intVal($signatureBolck->quickbook_cust_id);
				}
				$counti++;
			}
		}
		return $signatureTypArr;

	}

	function CustomertoQB($database ,$projectids,  $QuickBookKeys, $config){
		$db = DBI::getInstance($database);
		$db->free_result();
		$user_company_id = $QuickBookKeys['company_id'];
		echo $signature_block_query = 
						"SELECT `draw_signature_blocks`.* FROM `draws` 
							INNER JOIN draw_signature_blocks 
						ON draws.`id` = `draw_signature_blocks`.`draw_id` 
							INNER JOIN draw_signature_type 
						ON `draw_signature_type`.`id` = `draw_signature_blocks`.`signature_type_id` 
						LEFT JOIN `qb_customers` 
							ON `qb_customers`.customer = `draw_signature_blocks`.`description` AND `qb_customers`.`company_id` = ".$user_company_id."
						WHERE `draws`.`is_deleted_flag` = 'N' AND `draw_signature_type`.`signature_type_entity` = 'Owner' AND `draws`.`project_id` IN (".$projectids.")  AND `qb_customers`.`customer` IS NULL AND `draw_signature_blocks`.`description` != '' GROUP BY `draw_signature_blocks`.`description`";
		echo '<br/>';
		$db->execute($signature_block_query);
		while($eachsignatureblock = $db->fetch()){
			print_r($eachsignatureblock);
			if(!empty($eachsignatureblock['description'])){
				echo $qb_cust_id = get_qb_custidbyname($QuickBookKeys, $config, $eachsignatureblock['description']);
				if(empty($qb_cust_id) && !empty($eachsignatureblock['description'])){
					$params_arr = array();
					$params_arr['customer_name'] = $eachsignatureblock['description'];
					$params_arr['project_id'] = $eachsignatureblock['project_id'];
					print_r($params_arr);
					$qb_cust_id = customerCreateOnly($database, $QuickBookKeys,  $config, $params_arr);
					
				}
				if(!empty($qb_cust_id) && !empty($eachsignatureblock['description'])){
					$params_arr = array();
					$params_arr['customer'] = $eachsignatureblock['description'];
					$params_arr['user_company_id'] = $user_company_id;
					$params_arr['customer_id'] = $qb_cust_id;
					$params_arr['project_id'] = $eachsignatureblock['project_id'];
					CheckandUpdateQBCustomer($database, $params_arr);
				}
				//die;
				
			}
			
		}

	}

	function ProjectMappedCustomertoFulcrum($database, $QuickBookKeys, $config){
		$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $config);
		$user_company_id = $QuickBookKeys['company_id'];
		/* Get the Project Mapped Customer from Fulcrum - Start */
		$db = DBI::getInstance($database);
        $db->free_result();
        /* Get the Max CustId of the project Customer Mapped in Fulcrum */
        $qb_customers_sql = "SELECT MAX(qb_project_cust_id) as max_cust_id FROM qb_customers WHERE company_id = ? AND qb_project_cust_id != ? AND realmID = ? LIMIT 1";

        $db->execute($qb_customers_sql, array($user_company_id, 0, $QuickBookKeys['realmID']), MYSQLI_USE_RESULT);
        $qb_project_cust_id_in_fulcrum = $db->fetch();

       	$qb_project_cust_id_fulcrum = '';
		if(!empty($qb_project_cust_id_in_fulcrum['max_cust_id'])){
			$qb_project_cust_id_fulcrum  .= " AND Id > '".$qb_project_cust_id_in_fulcrum['max_cust_id']."'";
		}

		/* Get the Project Mapped Customer from Fulcrum - End */
		$customers = $dataService->Query("Select * from Customer WHERE FullyQualifiedName LIKE '%:%' ".$qb_project_cust_id_fulcrum." ORDERBY Id");

		foreach($customers as $eachCustomers){
		
			if(!empty($eachCustomers->IsProject) && $eachCustomers->IsProject =='true' && !empty($eachCustomers->DisplayName) && !empty($QuickBookKeys['realmID'])){
				
				$params_arr = array();
				$params_arr['user_company_id'] = $user_company_id;
				$params_arr['qb_project_cust_id'] = $eachCustomers->Id;
				$params_arr['project'] = $eachCustomers->DisplayName;
				$params_arr['project_customer'] = $eachCustomers->FullyQualifiedName;
				$customer = strtok($eachCustomers->FullyQualifiedName, ':');
				$params_arr['customer'] = $customer;
				$params_arr['qb_cust_id'] = $eachCustomers->ParentRef;
				$params_arr['realmID'] = $QuickBookKeys['realmID'];
				
				checkAndInsertProjectCustomer($database, $params_arr);
			}
		}
	}

	function QBbills_old($database, $QuickBookKeys, $config){
		$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $config);
		/* Get the Project Mapped Customer from Fulcrum - End */
		$bills=[];
		$vendors = $dataService->Query("Select Id, Active, CompanyName from Vendor");
		// foreach($vendors as $eachVendors){
		// 	$id=$eachVendors->Id;

		// 	$bills = $dataService->Query("Select * from Bill where VendorRef =".$id." ");

		// }
		return $QuickBookKeys;
	}

	function QBbills($database, $QuickBookKeys, $config, $vendor_name, $qb_project_name,$revised_subcontract_total){
		$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $config);
		// -----------------
        // Generate the report output.
        // -----------
		$bills=[];$end=[];
		$co_output = [];
		$bill_output = [];
		$change_orders = [];
		$vendor_id=0;
		$project = '';$html = '';
		$msg='';
		$change_order_total = $revised_total = 0;
		$retention_total = $unpaid = $balance = 0;
		$subcontract_value = $total_paid = $total_due = 0;

		$html='<tr class="borederRowBid">
		<td><h3>Invoices:</h3></td>
		<td></td>
		</tr>
		<tr class="borederRowBid">
		<th style="padding-bottom:20px;" class="align-left">Invoice#:</th>
		<th style="padding-bottom:20px;" class="align-left">Date:</th>
		<th style="padding-bottom:20px;" class="align-left">Description:</th>
		<th style="padding-bottom:20px;" class="align-left">Amount Due:</th>
		<th style="padding-bottom:20px;" class="align-left">Amount Paid:</th>                        
		</tr>
		';
		# Find the matching vendor (does it need to be Active?)
		$vendor_name= addslashes($vendor_name);
		$vendors = $dataService->Query("Select Id, Active, CompanyName from Vendor where DisplayName like '%$vendor_name%' ");

		if(count($vendors)>0){
			foreach($vendors as $eachVendors){
				$vendor_id=$eachVendors->Id;
				
			}
		}else{
			$msg = 'No vendor found in QB for name: '.$vendor_name;
		}

		# Use Vendor Id to find any Bill records
        # Can we quailify the query to only records matching the project?
        # For now, just excluding non matching projects from the bills list,
        # so we dont query any unneeded BillPayment records.
        # ! An odd quirk of QB, when trying to only query the columns we
        # need for the Bill record it fails because some Bill records
        # dont include LinkedTxn, so using select * for now.

		if($vendor_id>0){
			$billsData = $dataService->Query("Select * from bill where VendorRef ='".$vendor_id."' ");
			if(count($billsData)>0){
				foreach($billsData as $eachBills){
					
				// Initialization of Bill instance. Set necessary
    			// attrs and values, raise error if any missing.
    			// Find project name from nested CustomerRef.
    			// Some Bill records have no LinkedTxn attribute.

					if((isset($eachBills->Id) && $eachBills->Id!='') && ( isset($eachBills->DocNumber) && $eachBills->DocNumber!='') && (isset($eachBills->TxnDate) && $eachBills->TxnDate!='') && (isset($eachBills->Line) && $eachBills->Line!='')){
						if(is_array($eachBills->Line)){
						// foreach ($eachBills->Line as $eachLines) {
							$project = Bill($eachBills->Line,$dataService);
							if($project!='' && (strtolower($qb_project_name)==strtolower($project))) {
								$bills[] = $eachBills;
						// }
							}
						}else{
							$project = Bill($eachBills->Line,$dataService);
							if($project!='' && (strtolower($qb_project_name)==strtolower($project))) {	
								$bills[] = $eachBills;
							}
						}

					}				
				}

			# Check BillPayment for any linked transactions for Amount Paid
        	# ! Must match line item TxnId to Bill Id, because there can
        	# be multiple line items pointing to different Bill records.
				if(count($bills)>0){

					foreach ($bills as $bill) {
						$amount_paid = 0;
						$paidAmt=[];
						$bill_linked_id = '';
						if(is_array($bill->LinkedTxn)){
							foreach ((array)$bill->LinkedTxn as $linked_txn) {
								$bill_linked_id = $linked_txn->TxnId;
								if($bill_linked_id){
									$amount_paid += BillPayment($bill_linked_id,$dataService,$bill);
									$paidAmt[]=floatval(BillPayment($bill_linked_id,$dataService,$bill));
								}
							}
						}else{
							$linked_txn=$bill->LinkedTxn;
							$bill_linked_id = $linked_txn->TxnId;
							if($bill_linked_id){
								$amount_paid += BillPayment($bill_linked_id,$dataService,$bill);
							}
						}
						
            		# Parse Bill line items for Invoice#, Description, Date, Amount Due
            # Append vals to bill_output list to be written to file and add
            # to the calculated running totals
						if(is_array($bill->Line)){
							foreach ($bill->Line as $billLine) {
								
								$AmountPaid=0;
								$amount_due = $billLine->Amount;
								if(count($paidAmt)>0){
									if(in_array(floatval($amount_due), $paidAmt)){
										$AmountPaid = $amount_due;

										foreach ($paidAmt as $key => $value){
											if ($value == floatval($amount_due)) {
												unset($paidAmt[$key]);
												break;
											}
										}
									}
									
								}
								if(strrpos($billLine->Description, 'RET') !== false){
									$retention_total += $amount_due;
									$AmountPaid=0;
								}
								$html.='<tr  class="borederRowBid">
								<td>'.$bill->DocNumber.'</td>
								<td>'.$bill->TxnDate.'</td>
								<td>'.$billLine->Description.'</td>
								<td>'.number_format($amount_due,2).'</td>
								<td>'.number_format($AmountPaid,2).'</td>                        
								</tr>';


								

								$total_due += $amount_due;
								$total_paid += $amount_paid;
								$amount_paid = 0;
							}
							

						}else{
							$AmountPaid=0;
							if($amount_paid){
								$AmountPaid = $amount_paid;
							}
							$amount_due = $bill->Line->Amount;
							$html.='<tr  class="borederRowBid">
							<td>'.$bill->DocNumber.'</td>
							<td>'.$bill->TxnDate.'</td>
							<td>'.$bill->Line->Description.'</td>
							<td>'.number_format($amount_due,2).'</td>
							<td>'.number_format($AmountPaid,2).'</td>                        
							</tr>';


							if(strrpos($bill->Line->Description, 'RET') !== false){
								$retention_total += $amount_due;
							}

							$total_due += floatval($amount_due);
							$total_paid += floatval($AmountPaid);
							$amount_paid = 0;  
						}
						
					}

				}else{

					$msg = 'No bill found in QB for name: '.$vendor_name;
				}

				
				$unpaid = $total_due - $total_paid - $retention_total;
				$balance = floatval($revised_subcontract_total) - floatval($total_due);

				

			}else{
				
				$msg = 'No bill found in QB for name: '.$vendor_name;
			}
		}else{
			$msg = 'No vendor found in QB for name: '.$vendor_name;
		}
		if($msg!=''){

			$html.= '<tr><td  colspan="5" >'.$msg.'</td></tr>';
		}
		 # Finish all subtotal calculations and format file output
		$html.='
		<tr  class="borederRowBid">
		<td colspan="3"></td>
		<td>Total Invoiced to Date:</td>
		<td>'.number_format($total_due,2).'</td>
		</tr>
		<tr  class="borederRowBid">
		<td colspan="3"></td>
		<td>Retention Billed to Date:</td>
		<td>'.number_format($retention_total,2).'</td>
		</tr>
		<tr  class="borederRowBid">
		<td colspan="3"></td>
		<td>Unpaid Progress Billed:</td>
		<td>'.number_format($unpaid,2).'</td>
		</tr>
		<tr  class="borederRowBid">
		<td colspan="3"></td>
		<td>Balance to be Billed on Subcontract:</td>
		<td>'.number_format($balance,2).'</td>
		</tr>
		';
		return $html;
	}

	function Bill($Line, $dataService)
	{
		$project='';
		if(is_array($Line)){
			foreach ($Line as $LineValue) {
				if(isset($LineValue->AccountBasedExpenseLineDetail->CustomerRef)){
					$CustomerRef = $LineValue->AccountBasedExpenseLineDetail->CustomerRef;
					$project = BillSub($CustomerRef, $dataService);	
				}
				break;
			}
		}else{
			if(isset($Line->AccountBasedExpenseLineDetail->CustomerRef)){
				$CustomerRef = $Line->AccountBasedExpenseLineDetail->CustomerRef;
				$project = BillSub($CustomerRef, $dataService);
			}
		}
		
		return $project;
	}
	function BillSub($CustomerRef, $dataService)
	{
		$project='';
		# Find the matching vendor (does it need to be Active?)
		$Customer = $dataService->Query("Select Id, DisplayName from Customer where Id='$CustomerRef' ");

		if(count($Customer)>0){
			foreach($Customer as $eachCustomers){
				$project=$eachCustomers->DisplayName;
			}
		}
		return $project;
	}

	function BillPayment($bill_linked_id,$dataService,$bill){
		$bill_payment_result = $dataService->Query("Select Line from BillPayment where Id ='".$bill_linked_id."' ");

		if(count($bill_payment_result)>0){            			 		
			foreach ($bill_payment_result as $bill_payment) {

				$bp_line_get = $bill_payment->Line;						
				if(is_array($bp_line_get)){
					foreach ($bp_line_get as $bp_line) {

						$payment_amount = isset($bp_line->Amount) ? $bp_line->Amount : 0;
						$payment_linked_txn = isset($bp_line->LinkedTxn) ? $bp_line->LinkedTxn : [];
						if($payment_linked_txn->TxnId==$bill->Id){
							$amount_paid += floatval($payment_amount);

						}
					}
				}else{

					$payment_amount = isset($bp_line_get->Amount) ? $bp_line_get->Amount : 0;
					$payment_linked_txn = isset($bp_line_get->LinkedTxn) ? $bp_line_get->LinkedTxn : [];
					if($payment_linked_txn->TxnId==$bill->Id){
						$amount_paid += floatval($payment_amount);

					}
				}
			}
		}
		return $amount_paid;
	}
?>

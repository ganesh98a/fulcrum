<?php
	// Accounting Controller
	require_once('../constants/constants_qb.php');
	require_once('../models/accounting_model.php');
	require_once('../models/subcontract_invoice_model.php');
	require_once('../functions/accounting.php');
	require_once('../functions/accounting-quickbook.php');
	require_once('../functions/subcontract_invoice_quickbook.php');
	require_once('../templates/dropdown_tmp.php');
	require_once('../vendor/quickbooks/vendor/autoload.php');
	require_once('lib/common/Service/TableService.php');


	use QuickBooksOnline\API\DataService\DataService;
	use QuickBooksOnline\API\Facades\Invoice;
	use QuickBooksOnline\API\Facades\Customer;
	
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
	require_once('lib/common/Draws.php');
	require_once('lib/common/RetentionItems.php');
	require_once('lib/common/RetentionSignatureBlocks.php');
	require_once('lib/common/DrawSignatureType.php');
	require_once('lib/common/DrawSignatureBlocks.php');
	require_once('lib/common/DrawSignatureBlocksConstructionLender.php');
	require_once('lib/common/RetentionSignatureBlocksConstructionLender.php');
	require_once('lib/common/Project.php');
	require_once('lib/common/UserCompany.php');
	require_once('../../modules-draw-list-function.php');
	
	$session = Zend_Registry::get('session');


	if(!empty($_GET['action']) && $_GET['action'] == 'updateQB'){ // Send the Draw to Quickbook
		$return_arr = array('return_val'=>'','qb_error_id'=>'');

		$user_company_id = $session->getUserCompanyId();
		$project_id = $session->getCurrentlySelectedProjectId();
		$user_id = $session->getUserId();
		
		if(empty($_GET['applicationId'])){
			$return_arr['return_val'] = 'Application ID not passed';
		}else{
			$applicationId = $_GET['applicationId'];
			$custId = 0;
			if(empty($_GET['name'])){
				$return_arr['return_val'] = 'customernotexist';
			}else if(empty($_GET['project_customer'])){
				$return_arr['return_val'] = 'customernotexist';
			}else{
				if(!empty($_GET['customerid'])){
					$custId = $_GET['customerid'];
				}
				$debugMode = $session->getDebugMode();
				$type = '';
				$signatureTypArr =  getsignatureblock($database, $project_id ,$applicationId,$user_company_id,$debugMode,$user_id, $type);
				$QuickBookKeys = getCompanyData($database, $user_company_id);
				$budget_arr = array();

				if(!empty($signatureTypArr['drawId'])){
					$drawId = $signatureTypArr['drawId'];
					$cor_type = Project::CORAboveOrBelow($database,$project_id);
					$budgetList = DrawItems::getBudgetDrawItems($database,$drawId,'',$cor_type);
					foreach($budgetList as $eachbudget){
						$current_app_aft_retention = $eachbudget['current_app'] - $eachbudget['current_retainer_value'];
						if(!empty($current_app_aft_retention) && $current_app_aft_retention !='0.00'){
							$each_budget_arr = array();
							$each_budget_arr['costCode'] = $eachbudget['division_number'].'-'.$eachbudget['cost_code'];
							$each_budget_arr['costCodeData'] = $eachbudget['cost_code_description'];
							$each_budget_arr['current_app'] = $current_app_aft_retention;
							$budget_arr[] = $each_budget_arr;	
						}
					}
					$cor_type = Project::CORAboveOrBelow($database,$project_id);
					$changeOrderRequests = DrawItems::getChangeOrderDrawItems($database,$drawId,'',$cor_type);
					foreach($changeOrderRequests as $changeOrderValue){
						$current_app_aft_retention = $changeOrderValue['current_app'] - $changeOrderValue['current_retainer_value'];
						if(!empty($current_app_aft_retention) && $current_app_aft_retention !='0.00'){
							$changeOrderTitle = $changeOrderValue['co_title'];
			    			$changeOrderPrefix = $changeOrderValue['co_type_prefix'];

			    			$each_budget_arr = array();
			    			$each_budget_arr['costCode'] = $changeOrderPrefix;
							$each_budget_arr['costCodeData'] = $changeOrderTitle;
							$each_budget_arr['current_app'] = $current_app_aft_retention;
							$budget_arr[] = $each_budget_arr;
						}
					}
				}
				$signatureTypArr['budget'] = $budget_arr;
				$customer_name = $_GET['name'];
				$signatureTypArr['Owner']['description'] = $customer_name;
				$signatureTypArr['Owner']['project_customer'] =$_GET['project_customer'];
				

				if(!empty($QuickBookKeys['accounting_portal_id']) && !empty($config->defined_constants->ACCOUNTING_PORTAL_QB) && $QuickBookKeys['accounting_portal_id'] == $config->defined_constants->ACCOUNTING_PORTAL_QB){ 	// QB Selected
					$return_arr = drawtoquickbooks($database, $QuickBookKeys,$signatureTypArr,$user_company_id,$config,$custId);
				}else{
					$return_arr['return_val'] = 'No Accounting Portal Passed.';
				}

			}
		}
		
		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($return_arr);
		
		
	}else if(!empty($_GET['action']) && $_GET['action'] == 'updateretentionQB'){
		$return_arr = array('return_val'=>'','qb_error_id'=>'');

		$user_company_id = $session->getUserCompanyId();
		$project_id = $session->getCurrentlySelectedProjectId();
		$user_id = $session->getUserId();
		$applicationNumber = '';
		if(empty($_GET['applicationId'])){
			$return_arr['return_val'] = 'Application ID not passed';
		}else if(empty($_GET['retentionId'])){
			$return_arr['return_val'] = 'RetentionId is not passed.';
		}else if(empty($_GET['name'])){
			$return_arr['return_val'] = 'customernotexist';
		}else if(empty($_GET['project_customer'])){
			$return_arr['return_val'] = 'customernotexist';
		}else{
			$RetentionId = $_GET['retentionId'];
			$applicationNumber = $applicationId = $_GET['applicationId'];
			$custId = 0;
			if(!empty($_GET['customerid'])){
				$custId = $_GET['customerid'];
			}
			$debugMode = $session->getDebugMode();
			$project_id = $session->getCurrentlySelectedProjectId();
			$type = '';
			if(!empty($_GET['type']) && $_GET['type'] =='retention'){
				$type = 'retention';
			}
			$signatureTypArr =  getsignatureblock($database, $project_id ,$applicationId,$user_company_id,$debugMode,$user_id, $type);
			$QuickBookKeys = getCompanyData($database, $user_company_id);
			$budget_arr = array();
			if(!empty($RetentionId)){
			
				$budgetList =  RetentionItems::getBudgetGridRetentionItems($database,$RetentionId);
				foreach($budgetList as $eachbudget){
					if(!empty($eachbudget['current_retainer_value']) && $eachbudget['current_retainer_value'] !='0.00'){
						$each_budget_arr = array();
						$each_budget_arr['costCode'] = $eachbudget['division_number'].'-'.$eachbudget['cost_code'];
						$each_budget_arr['costCodeData'] = $eachbudget['cost_code_description'];
						$each_budget_arr['current_app'] = $eachbudget['current_retainer_value'];
						$budget_arr[] = $each_budget_arr;	
					}
				}

				$changeOrderRequests = RetentionItems::getChangeOrderRetentionItems($database,$RetentionId);
				foreach($changeOrderRequests as $changeOrderValue){
					if(!empty($changeOrderValue['current_retainer_value']) && $changeOrderValue['current_retainer_value'] !='0.00'){
						$each_budget_arr = array();
						$each_budget_arr['costCode'] = $changeOrderValue['co_type_prefix'];
						$each_budget_arr['costCodeData'] = $changeOrderValue['co_title'];
						$each_budget_arr['current_app'] = $changeOrderValue['current_retainer_value'];
						$budget_arr[] = $each_budget_arr;
					}
				}
				$signatureTypArr['budget'] = $budget_arr;
				$signatureTypArr['Owner']['description'] = $_GET['name'];
				$signatureTypArr['Owner']['project_customer'] =$_GET['project_customer'];
				$signatureTypArr['application_number'] = $applicationNumber;
				

				if(!empty($QuickBookKeys['accounting_portal_id']) && !empty($config->defined_constants->ACCOUNTING_PORTAL_QB) && $QuickBookKeys['accounting_portal_id'] == $config->defined_constants->ACCOUNTING_PORTAL_QB){ // QB Selected
					$signatureTypArr['qb_invoiceid'] = '';
					$return_arr = drawtoquickbooks($database, $QuickBookKeys,$signatureTypArr,$user_company_id,$config,$custId,'retention');
				}else{
					$return_arr['return_val'] = 'No Accounting Portal Passed.';
				}
			}
		}
		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($return_arr);	

	}else if(!empty($_GET['action']) && $_GET['action'] == 'checkAccountingPortal'){  
	          // Check Accounting Portal is Active or not
		$user_company_id = $session->getUserCompanyId();

		$companyData = getCompanyData($database, $user_company_id);
		$accountingportal_active = 'N';
		if(!empty($companyData['id'])){
			$accountingportal_active = 'Y';
		}
		echo $accountingportal_active;
		die;

	}else if(!empty($_GET['action']) && $_GET['action'] == 'getinvoiceStatus'){ // Get the Invoice Status
		
		$invoiceId = $_GET['invoiceId'];
		echo $user_company_id = $session->getUserCompanyId();

		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		
		echo '<pre>';
		print_r($QuickBookKeys);
		
		$invoice = getInvoice($invoiceId, $QuickBookKeys, $config);
		
		print_r($invoice);
		
	
		$invoicestatus = qb_invoicestatus($invoice);
		print_r($invoicestatus);
		

		exit;
	}else if(!empty($_GET['action']) && $_GET['action'] == 'getcustomerbyname'){ // Get the Customer Exist or not
		if(empty($_GET['name'])){
			exit('customernotexist');
		}

		if(empty($_GET['applicationId'])){
			exit('Application Id is not available.');
		}
		
		$user_company_id = $session->getUserCompanyId();
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		if(empty($QuickBookKeys['client_id'])){
			exit($QuickBookKeys);
		}


		$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
		$customer_name = $_GET['name'];
		$customerId = get_qb_custidbyname($QuickBookKeys,$config,$customer_name);
	
		$debugMode = $session->getDebugMode();
		$project_id = $session->getCurrentlySelectedProjectId();
		$user_id = $session->getUserId();
		$type = '';
		if(!empty($_GET['type']) && $_GET['type'] =='retention'){
			$type = 'retention';
		}

		$applicationId = $_GET['applicationId'];
		
		$signatureTypArr =  getsignatureblock($database, $project_id ,$applicationId,$user_company_id,$debugMode,$user_id, $type);

		$signatureTypArr['Owner']['description'] = $customer_name;
		if(empty($customerId)){
			customerCreate($database, $QuickBookKeys,$signatureTypArr,$config);
		}
		if(empty($signatureTypArr['user_custom_project_id'])){
			exit('projectidrequired');
		}
		
		if(empty($_GET['project_customer'])){
			exit('projectnotexist');
		}
		$project_cust_name = $_GET['project_customer'];
		$project_cust_id = get_qb_projcustidbyname($QuickBookKeys,$config,$project_cust_name);

		if(empty($project_cust_id)){
		 	exit('customerprojnotexistinqb');
		}else{
		 	echo $project_cust_id;
		}
		exit;
	}else if(!empty($_GET['action']) && $_GET['action'] == 'updateQBstatus'){ // Update Invoice Status

		$qb_companies  = getQBCompanies($database);
		
		$draw_count = $error_count = $update_count = $skip_count =  0;
		foreach($qb_companies as $eachcompany){
			$activedraws = getactivedraws($database, $eachcompany['company_project_id']);
			
			foreach($activedraws as $eachdraw){
				sleep(2);
				$draw_count++;
				$user_company_id = $eachcompany['company_id'];
				
				$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
				if(empty($QuickBookKeys['client_id'])){
					$errorArr = array();
					$errorArr['draw_id'] = $eachdraw['id'];
					$errorArr['application_number'] = $eachdraw['application_number'];
					$errorArr['project_id'] =  $eachdraw['project_id'];
					$errorArr['user_id'] =  '';
					$errorArr['quickbook'] = 'cronjob';
					$errorArr['log'] = $QuickBookKeys;
					addQBerrorLog($database,$errorArr);
					$error_count++;
					continue;
				}
				$invoiceId = $eachdraw['quickbook_invoice_id'];
				
				$invoice = getInvoice($invoiceId, $QuickBookKeys, $config);
				if(empty($invoice->Id)){
					
					$errorArr = array();
					$errorArr['draw_id'] = $eachdraw['id'];
					$errorArr['application_number'] = $eachdraw['application_number'];
					$errorArr['project_id'] =  $eachdraw['project_id'];
					$errorArr['user_id'] =  '';
					$errorArr['quickbook'] = 'cronjob1';
					$errorArr['log'] = $invoice;
					addQBerrorLog($database,$errorArr);
					$error_count++;
					continue;
					
				}
				$invoicestatus = qb_invoicestatus($invoice);
				$drawstatus = '';
				if(!empty($invoicestatus) && ($invoicestatus =='Sent' ||  $invoicestatus =='Not Sent' )){
					$drawstatus = 'Posted';
				}else if(!empty($invoicestatus) && $invoicestatus =='Viewed'){
					$drawstatus = 'Open';

				}else if(!empty($invoicestatus) && $invoicestatus =='Partial Paid'){
					$drawstatus = 'Partially Paid';

				}else if(!empty($invoicestatus) && ($invoicestatus =='Deposited' ||$invoicestatus =='Paid'  )){
					$drawstatus = 'Paid';
				}
	    		if(!empty($drawstatus) && $drawstatus != $eachdraw['status']){
	    			updateqbstatus($database, $eachdraw['id'], $drawstatus);
	    			$update_count++;
	    		}else{
	    			$skip_count++;
	    		}
			}

			



		}
		$message = '';
		$message .= "Total QB Active Draws Count ".$draw_count;
		$message .= "<br/> Total QB Active Draws Error Count ". $error_count;
		$message .= "<br/> Total QB Active Draws Update Count ".$update_count;
		$message .= "<br/> Total QB Active Draws Skip Count ".$skip_count;

		print_r($message);

		$errorArr = array();
		$errorArr['draw_id'] = '';
		$errorArr['application_number'] = '';
		$errorArr['project_id'] =  '';
		$errorArr['user_id'] =  '';
		$errorArr['quickbook'] = 'cronjob_status';
		$errorArr['log'] = $message;
		
		addQBerrorLog($database,$errorArr);
	
		
		exit('qb');
	}else if(!empty($_GET['action']) && $_GET['action'] == 'updateQBbulkstatus'){

		

		$qb_companies  = getQBCompanies($database);
		
		$draw_count = $error_count = $update_count = $skip_count =  0;
		foreach($qb_companies as $eachcompany){
			$projectid = $eachcompany['company_project_id'];
			$project_id_arr = explode(',',$projectid);
			$projectid_result = "'" . implode ( "', '", $project_id_arr ) . "'";


			$user_company_id = $eachcompany['company_id'];
			
			$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
			

			if(empty($QuickBookKeys['client_id'])){
				$message = $QuickBookKeys;
				$errorArr = array();
				$errorArr['draw_id'] = '';
				$errorArr['application_number'] = '';
				$errorArr['project_id'] =  $projectid_result;
				$errorArr['user_id'] =  '';
				$errorArr['quickbook'] = $projectid_result.'cronjob_bulk_status';
				$errorArr['log'] = $message;

				addQBerrorLog($database,$errorArr);
				continue;
			}
			/* SubCont - Start */
			$subcontract_total = overAllSubContInvoiceCount($database,  $projectid_result);

			$total = 0;
			$limit = 500;
			if(!empty($subcontract_total['total_subcontinvoice'])){
				$numrows = $row_total['total_subcontinvoice'];
				$totalpages = ceil($numrows / $limit);
				foreach (range(0, $totalpages) as $page) {
					$offset = ($page)  * $limit;
					$subcontinvoice_arr = array();
					$qbsubcontinvoicearr = array();
					$subcontinvoiceidarr = array();

					$activesubcontInvoice = getActiveSubContInvoice($database,  $projectid_result, $limit, $offset);


					if(!empty($activesubcontInvoice['subcontinvoice_count'])){
    					$subcontinvoice_count = $activesubcontInvoice['subcontinvoice_count'];
    				}
    				if(!empty($activesubcontInvoice['subcontinvoice_arr'])){
    					$subcontinvoice_arr = $activesubcontInvoice['subcontinvoice_arr'];
    				}
    				if(!empty($activesubcontInvoice['subcontinvoiceidarr'])){
    					$subcontinvoiceidarr = $activesubcontInvoice['subcontinvoiceidarr'];
    				}

    				if(!empty($subcontinvoice_arr)){
    					$subcont_invoices = getbillarrById($QuickBookKeys, $config, $subcontinvoice_arr);


    					foreach($subcont_invoices as $eachsubcont_invoice){

    						if(!empty($eachsubcont_invoice->Id) && empty($eachsubcont_invoice->Balance)){
								updatesubcontInvoiceStatus($database, $subcontinvoiceidarr[$eachsubcont_invoice->Id]['invoice_id']);
    							$updatesub_count++;

    						}else if(!empty($eachsubcont_invoice->Id) && !empty($eachsubcont_invoice->DueDate) && !empty($eachsubcont_invoice->TxnDate) && strtotime($eachsubcont_invoice->DueDate) <  strtotime($eachsubcont_invoice->TxnDate)){
    							updatesubcontInvoiceStatusOverdue($database, $subcontinvoiceidarr[$eachsubcont_invoice->Id]['invoice_id']);

    							$updatesub_count++;
    						}
							$qbsubcontinvoicearr[] = $eachsubcont_invoice->Id;
						}
    					$missedoutsubcontinvoice_arr = array_diff($subcontinvoice_arr,$qbsubcontinvoicearr);

    					if(!empty($missedoutsubcontinvoice_arr)){

							foreach($missedoutsubcontinvoice_arr as $eachmissedoutinvoice){
								$message = 'Sub Contract Invoice not in QB';
								$errorArr = array();
								$errorArr['draw_id'] = $drawidarr[$eachmissedoutinvoice]['qb_expense_id'];
								$errorArr['application_number'] = $drawidarr[$eachmissedoutinvoice]['invoice_id'];
								$errorArr['project_id'] =  $drawidarr[$eachmissedoutinvoice]['project_id'];
								$errorArr['user_id'] =  $drawidarr[$eachmissedoutinvoice]['vendor_id'];
								$errorArr['quickbook'] = 'cronjob_bulk_status';
								$errorArr['log'] = $message;

								
								addQBerrorLog($database,$errorArr);
								$updatesub_error_count++;
							}
						}

    				}
				}
			}


			/* SubCont - End */

			/* Draws - Start */

			$row_total = overAllDrawCount($database, $projectid_result);
			
			$total = 0;
			$limit = 500;
			if(!empty($row_total['total_invoice'])){
				$numrows = $row_total['total_invoice'];
				$totalpages = ceil($numrows / $limit);

				foreach (range(0, $totalpages) as $page) {

					// Calculate the offset for the query

					$offset = ($page)  * $limit;

					
					$invoicearr = array();
					$qbinvoicearr = array();
					$drawidarr = array();
	    			

    				$get_draw_data = getInvoicearr($database, $projectid_result, $limit, $offset);
    				if(!empty($get_draw_data['draw_count'])){
    					$draw_count = $get_draw_data['draw_count'];
    				}
    				if(!empty($get_draw_data['invoice_arr'])){
    					$invoicearr = $get_draw_data['invoice_arr'];
    				}
    				if(!empty($get_draw_data['drawidarr'])){
    					$drawidarr = $get_draw_data['drawidarr'];
    				}

	    			if(!empty($invoicearr)){
	    				
						$invoices = getinvoicearrById($QuickBookKeys, $config, $invoicearr);
						

						foreach($invoices as $eachinvoice){
							$invoicestatus = qb_invoicestatus($eachinvoice);
							$drawstatus = '';
							if(!empty($invoicestatus) && ($invoicestatus =='Sent' ||  $invoicestatus =='Not Sent' )){
								$drawstatus = 'Posted';
							}else if(!empty($invoicestatus) && $invoicestatus =='Viewed'){
								$drawstatus = 'Open';

							}else if(!empty($invoicestatus) && $invoicestatus =='Partial Paid'){
								$drawstatus = 'Partially Paid';

							}else if(!empty($invoicestatus) && ($invoicestatus =='Deposited' ||$invoicestatus =='Paid'  )){
								$drawstatus = 'Paid';
							}
							$invoiceId = $eachinvoice->Id;
							$qbinvoicearr[] = $invoiceId;
							
							if(!empty($drawstatus) && !empty($drawidarr[$invoiceId]['draw_id']) && !empty($drawidarr[$invoiceId]['draw_status']) &&  $drawstatus != $drawidarr[$invoiceId]['draw_status'] ){
								updateqbstatus($database, $drawidarr[$invoiceId]['draw_id'], $drawstatus);
								$update_count++;
							}else{
								$skip_count++;
							}
						}

						$missedoutinvoice_arr = array_diff($invoicearr,$qbinvoicearr);
						if(!empty($missedoutinvoice_arr)){

							foreach($missedoutinvoice_arr as $eachmissedoutinvoice){
								$message = 'Invoice not in QB';
								$errorArr = array();
								$errorArr['draw_id'] = $drawidarr[$eachmissedoutinvoice]['draw_id'];
								$errorArr['application_number'] = $drawidarr[$eachmissedoutinvoice]['application_number'];
								$errorArr['project_id'] =  $drawidarr[$eachmissedoutinvoice]['project_id'];
								$errorArr['user_id'] =  '';
								$errorArr['quickbook'] = 'cronjob_bulk_status';
								$errorArr['log'] = $message;

				
								addQBerrorLog($database,$errorArr);
								$error_count++;
							}
						}
					}
    				


				}
			}
			/* Draws - End */



		}
		$message = '';
		$message .= "Total QB Active Draws Count ".$draw_count;
		$message .= "<br/> Total QB Active Draws Error Count ". $error_count;
		$message .= "<br/> Total QB Active Draws Update Count ".$update_count;
		$message .= "<br/> Total QB Active Draws Skip Count ".$skip_count;
		$message .= "<br/> Total QB Active SubCont Invoice ".$subcontinvoice_count;
		$message .= "<br/> Total QB Active SubCont Update Count ".$updatesub_count;
		$message .= "<br/> Total QB Active SubCont Error Count ". $updatesub_error_count;

		print_r($message);

		$errorArr = array();
		$errorArr['draw_id'] = '';
		$errorArr['application_number'] = '';
		$errorArr['project_id'] =  '';
		$errorArr['user_id'] =  '';
		$errorArr['quickbook'] = 'cronjob_status';
		$errorArr['log'] = $message;
		
		addQBerrorLog($database,$errorArr);

		exit('bulkstatus update');
	}elseif(!empty($_GET['action']) && $_GET['action'] == 'qbaccountinglog'){
		die('hided');
		?>

		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<link  rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></link>
		<script>
			$(document).ready(function() {
    			$('#example').DataTable();
			} );
		</script>
		<table id="example" class="display" style="width:100%">
	        <thead>
	            <tr>
	                <th>Draw Id</th>
	                <th>Application Number</th>
	                <th>Project ID</th>
	                <th>User ID</th>
	                <th>quickbook</th>
	                <th>log</th>
	                <th>date</th>
	            </tr>
	        </thead>
	        <tbody>

	        
		<?php
		$accountinglog_arr  = getAccountingLog($database);
		foreach ($accountinglog_arr as $row){?>
			<tr>
                <td><?php echo $row['draw_id']; ?></td>
                <td><?php echo $row['application_number']; ?></td>
                <td><?php echo $row['project_id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['quickbook']; ?></td>
                <td><?php echo $row['log']; ?></td>
                <td><?php echo $row['date']; ?></td>
            </tr>
	
	<?php
		} ?>
		</tbody>
	    </table>
		<?php
	}else if(!empty($_GET['action']) && $_GET['action'] == 'updateQuickbooksKey'){
		if(!empty($_GET['clientId']) && !empty($_GET['clientSecret']) && !empty($_GET['usercompanyId'])){
			// && !empty($_GET['contractEntity'])
			 // All data's Available
			updateQuickbooksData($database, $_GET['clientId'], $_GET['clientSecret'], $_GET['usercompanyId'],$_GET['webhooktoken']);
			//, $_GET['contractEntity']
		}
		die;
	}else if(!empty($_GET['action']) && $_GET['action'] == 'updateAccountingPortal'){
		// if(!empty($_GET['accountPortal']) && !empty($_GET['usercompanyId']) && !empty($_GET['contractEntity'])){
		if(!empty($_GET['accountPortal']) && !empty($_GET['usercompanyId'])){
			updateAccountingPortal($database,  $_GET['accountPortal'], $_GET['usercompanyId']);
			//, $_GET['contractEntity']
		}
		die;
	}elseif(!empty($_GET['action']) && $_GET['action'] == 'getCustomers'){
		$user_company_id = $session->getUserCompanyId();
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
		$query = "Select * from Customer WHERE FullyQualifiedName = 'Suganthi:New Project'";
		$customer = $dataService->Query($query);
		
		echo '<pre>';
		print_r($customer); die;
	}else if(!empty($_GET['action']) && $_GET['action'] == 'getProjectCustomers'){
		$qb_company = getQBCompanies($database);
		foreach($qb_company as $eachcompany){
			$user_company_id = $eachcompany['company_id'];
		
			$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
			if(empty($QuickBookKeys['client_id'])){
				$message = $QuickBookKeys;
				$errorArr = array();
				$errorArr['draw_id'] = '';
				$errorArr['application_number'] = '';
				$errorArr['project_id'] =  $projectid_result;
				$errorArr['user_id'] =  '';
				$errorArr['quickbook'] = $projectid_result.'cronjob_bulk_status';
				$errorArr['log'] = $message;

				addQBerrorLog($database,$errorArr);
				continue;
			}


			$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);

			$customers = $dataService->Query("Select * from Customer WHERE FullyQualifiedName LIKE '%:%'");
			foreach($customers as $eachCustomers){
			
				if(!empty($eachCustomers->IsProject) && $eachCustomers->IsProject =='true'){

					$params_arr = array();
					$params_arr['user_company_id'] = $user_company_id;
					$params_arr['qb_project_cust_id'] = $eachCustomers->Id;
					$params_arr['project'] = $eachCustomers->DisplayName;
					$params_arr['project_customer'] = $eachCustomers->FullyQualifiedName;
					$customer = strtok($eachCustomers->FullyQualifiedName, ':');
					$params_arr['customer'] = $customer;
					$params_arr['realmID'] = $QuickBookKeys['realmID'];
					
					checkAndInsertProjectCustomer($database, $params_arr);
				}
			}
		}
		die('working');

	}else if(!empty($_GET['action']) && $_GET['action'] =='checkprojectcustomerexist'){
		$user_company_id = $session->getUserCompanyId();
		$customer_name = '';
		if(!empty($_GET['owner_name'])){
			$customer_name = $_GET['owner_name'];
		}
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		if(!empty($QuickBookKeys['client_id']) && !empty($QuickBookKeys['client_secret']) && !empty($QuickBookKeys['access_token']) && !empty($QuickBookKeys['refresh_token']) && !empty($QuickBookKeys['realmID'])){
			$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
			$customerId = get_qb_projcustidbyname($QuickBookKeys,$config,$customer_name);
			if(!empty($customerId)){
				exit('exists');
			}else{
				exit('notexists');
			}
		}else{
			exit('notexists');
		}
		
	}else  if(!empty($_GET['action']) && $_GET['action'] =='checkQBAndCustomer'){
		$user_company_id = $session->getUserCompanyId();

		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		$returnval = 'noaccountingportal';

		if(!empty($QuickBookKeys['id'])){ // No Key / Accounting Portal is there 
			if(empty($_GET['ownername'])){ // No Owner Passed
				$returnval = 'noownerpassed';
			}else{
				$owner_name = $_GET['ownername'];
				$qbcustid = get_qb_custidbyname($QuickBookKeys, $config, $owner_name);
				if(empty($qbcustid)){
					$returnval = 'nocustomerinQB';
				}else{
					$returnval = $qbcustid;
				}
			}
		}
	 	exit($returnval);
	}else if(!empty($_GET['action']) && $_GET['action'] == 'insertQBCustomer'){
		$user_company_id = $session->getUserCompanyId();

		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		$params_arr = array();
		$params_arr['customer_name'] = $_GET['ownername'];
		$params_arr['project_id'] = $_GET['project_id'];
		customerCreateOnly($database, $QuickBookKeys,  $config, $params_arr);
	}else if(!empty($_GET['action']) && $_GET['action'] == 'UpdateQBCustomerID'){
		if(!empty($_GET['owner_name']) && !empty($_GET['drawId'])){
			$projectcustomer = $_GET['owner_name'];
			$options = array();
			$options['fields'] = array('id','project_customer');
			$condition_arr = array();
			$condition_arr['project_customer = ?'] = $projectcustomer;
			$options['filter'] = $condition_arr;
			$options['table'] = 'qb_customers';
			$qbcustomer = TableService::GetTabularData($database, $options);
			if(!empty($qbcustomer['id'])){
				if(!empty($_GET['type']) && $_GET['type'] =='retention'){
					$update_table = 'retention_draws';
				}else{
					$update_table = 'draws';
				}
				TableService::UpdateTabularData($database, $update_table, 'qb_customer_id', $_GET['drawId'], $qbcustomer['id']);
			}
		}
		die;
	}else if(!empty($_GET['action']) && $_GET['action'] == 'migrateallcustomer'){
		$qb_company = getQBCompanies($database);
		foreach ($qb_company as $portal => $eachcompany) {
			$user_company_id = $eachcompany['company_id'];
		
			$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
			$projectid_result = $eachcompany['company_project_id'];

			if(empty($QuickBookKeys['client_id'])){
				$message = $QuickBookKeys;
				$errorArr = array();
				$errorArr['draw_id'] = '';
				$errorArr['application_number'] = '';
				$errorArr['project_id'] =  $user_company_id;
				$errorArr['user_id'] =  '';
				$errorArr['quickbook'] = $projectid_result.'cronjob_bulk_custupdate';
				$errorArr['log'] = $message;

				addQBerrorLog($database,$errorArr);
				continue;
			}

			/* Fulcrum to QB - Customer - Start */
			CustomertoQB($database, $projectid_result, $QuickBookKeys, $config);
			/* Fulcrum to QB - Customer - End */

			/* Fulcrum Project Mapped Customer to QB - Start */


			ProjectMappedCustomertoFulcrum($database, $QuickBookKeys, $config);

			/* Fulcrum Project Mapped Customer to QB - End */
		}
	}else if(!empty($_GET['action']) && $_GET['action'] == 'checkForCustomer'){

		$invoiceId = $_GET['invoiceId'];
		echo $user_company_id = $session->getUserCompanyId();

		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		
		echo '<pre>';
		print_r($QuickBookKeys);
		
		$invoice = getInvoice($invoiceId, $QuickBookKeys, $config);

		print_r($invoice);


	}else if(!empty($_GET['action']) && $_GET['action'] =='getAllProjectCustomer'){
		$user_company_id = $session->getUserCompanyId();
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		if(!empty($QuickBookKeys['client_id'])){
			ProjectMappedCustomertoFulcrum($database, $QuickBookKeys, $config);
		}

		$projectCustArr = getProjectCustomers($database,$user_company_id);
		$qb_cust_html = "<option value=''>Select a QB Customer</option>";
		foreach($projectCustArr as $qb_customer_id => $qb_customer){
   
			$qb_cust_html .= "<option value='".$qb_customer."'>".$qb_customer."</option>";
  		}
  		echo $qb_cust_html;
	}else if(!empty($_GET['action']) && $_GET['action'] =='getBillData'){
		$user_company_id = $session->getUserCompanyId();
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		$expense_id  = $_GET['expense_id'];


		$expense_arr = getBillById($QuickBookKeys, $config, $expense_id);
		echo '<pre>';
		print_r($expense_arr);

		if(!empty($expense_arr->Id) && empty($expense_arr->Balance)){
			echo 'Paid';
		}else if(!empty($expense_arr->Id) && !empty($expense_arr->DueDate) && !empty($expense_arr->TxnDate) && strtotime($expense_arr->DueDate) <  strtotime($expense_arr->TxnDate)){
			echo 'OverDue';
		}else{
			echo 'Open';
		}

	}else if(!empty($_GET['action']) && $_GET['action'] =='createretentiondraw'){
		$user_company_id = $session->getUserCompanyId();
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);

		if(!empty($QuickBookKeys['client_id'])){ // Has Client Details

		}else{ // Error
			print_r($QuickBookKeys);
		}
	}else if(!empty($_GET['action']) && $_GET['action'] =='getAllQbBill'){
		$user_company_id = $session->getUserCompanyId();
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		$QBbills='';
		$vendor_name=$_POST['vendor'];
		 $qb_project_name=explode(":", $_POST['qb_customer'])[1];
		 $revised_subcontract_total=$_POST['revised_subcontract_total'];
		if(!empty($QuickBookKeys['client_id'])){ // Has Client Details
			$QBbills = QBbills($database, $QuickBookKeys, $config, $vendor_name, $qb_project_name, $revised_subcontract_total);
		}


		// $jsonOutput = json_encode($QBbills);

        // Send HTTP Content-Type header to alert client of JSON output
        // header('Content-Type: application/json');
        echo $QBbills;
	}

?>

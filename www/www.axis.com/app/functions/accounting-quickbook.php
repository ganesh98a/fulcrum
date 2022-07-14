<?php
	/*
		getQBConfigLogin --> Used to Generate the QB Authorization URL
		getQBConfig --> Used in the QB API Calls
		getAuthorizationUrl --> Used to generate the Connect API URL
		refreshToken --> To Generate the Refresh Token
		quickbookTokens --> To get the Tokens and refresh the Token if its needed
		qb_stepsactive --> Accounting Portal Active Bar
		qb_stepstoconnect --> Quickbooks Connecting Steps
		getInvoice --> Get Invoice Based on ID
		invoice --> To create or Update Invoice
		customerCreate --> To Create the Customer
		drawtoquickbooks --> Draw to Quickbooks
		getAccountingPortal --> Accounting Portal Connecting form
	*/
	$vendor_path = '../vendor/quickbooks/vendor/autoload.php';
	if (file_exists($vendor_path))  
	{ 
		require_once($vendor_path);
	}
	use QuickBooksOnline\API\DataService\DataService;
	use QuickBooksOnline\API\Facades\Invoice;
	use QuickBooksOnline\API\Facades\Customer;
	use QuickBooksOnline\API\Facades\Item;
	use QuickBooksOnline\API\Facades\Account;
	use QuickBooksOnline\API\Facades\Category;


	function getQBConfigLogin($clientId, $clientSecret, $config){ // Config of Login for getting the Token

		return DataService::Configure(array(
					    'auth_mode' => 'oauth2',
					    'ClientID' => $clientId,
					    'ClientSecret' =>  $clientSecret,
					    'RedirectURI' => $config->quickbook->oauth_redirect_uri,
					    'scope' => $config->quickbook->oauth_scope,
					    'baseUrl' => $config->quickbook->environment
					));
	}
	function getQBConfig($client_id, $client_secret, $accesstoken, $refreshtoken, $RealmID,$config){ // Config with the tokens
		
		return DataService::Configure(array(
						    'auth_mode' => 'oauth2',
						    'ClientID' => $client_id,
						    'ClientSecret' => $client_secret,
						    'accessTokenKey' => $accesstoken,
						    'refreshTokenKey' => $refreshtoken,
						    'QBORealmID' => $RealmID,
						    'baseUrl' => $config->quickbook->environment
						));
	}
	function getAuthorizationUrl($clientId, $clientSecret,$config){ // Authorization URL for client ID
		$dataService = getQBConfigLogin($clientId, $clientSecret, $config);
		$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
		return $OAuth2LoginHelper->getAuthorizationCodeURL();
	}

	function quickbookrealmidTokens($database, $real_mid){
		if(empty($real_mid)){
			exit('Real mId is empty.');
		}
		$QuickBookKeys = getCompanyRealmData($database, $real_mid);
		if(!empty($QuickBookKeys['id'])){
			$user_company_id = $QuickBookKeys['company_id'];

			if(!empty($QuickBookKeys['refresh_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['refresh_token_expires'])){ // Access Token Expire
				return 'refreshtokenexpired';
			}else if(!empty($QuickBookKeys['access_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['access_token_expires'])){ // Access Token Expire

				refreshToken($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $user_company_id, $config, $database);

				$QuickBookKeys = getCompanyData($database, $user_company_id);
			}

		}
		return $QuickBookKeys;
	}

	function quickbookTokens($database, $user_company_id){
		if(empty($user_company_id)){
			exit('User Company Id is empty.');
		}
		$QuickBookKeys = getCompanyData($database, $user_company_id);
		if(!empty($QuickBookKeys['refresh_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['refresh_token_expires'])){ // Access Token Expire
			exit('refreshtokenexpired');
		}else if(!empty($QuickBookKeys['access_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['access_token_expires'])){ // Access Token Expire

			refreshToken($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $user_company_id, $config, $database);

			$QuickBookKeys = getCompanyData($database, $user_company_id);
		}
		
		return $QuickBookKeys;

	}
	function quickbookNewTokens($database, $user_company_id, $config){
		$returnval = '';
		if(empty($user_company_id)){
			$returnval = 'User Company Id is empty.';
			return $returnval;
		}
		$QuickBookKeys = getCompanyData($database, $user_company_id);
		$returnval = $QuickBookKeys;
		if(!empty($QuickBookKeys['refresh_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['refresh_token_expires'])){ // Access Token Expire
			$returnval = 'refreshtokenexpired';
			return $returnval;
		}else {
			try {
				refreshToken($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $user_company_id, $config, $database);//If the exception is thrown, this text will not be shown
				$returnval = getCompanyData($database, $user_company_id);
			}

			//catch exception
			catch(Exception $e) {
			  $returnval = $e->getMessage();
			}
		}
		
		return $returnval;
	}

	function qb_stepsactive($clientId, $clientSecret){ // View Quickbooks Active Bar
		$step1 = 'active';			
		$step2 = '';	
		$complet = '';
		if(!empty($clientId) || !empty($clientSecret)){	
			$step1 = 'active';	
			$step2 = 'active';	
			$complet = '<span style="color: green; text-transform: capitalize;"> (Completed)</span>';
		}
		$activestepsqb =  <<<END_PER_TABLE_TBODY
				<ul>
					<li class="importSteps {$step1}" id="importStepOne">
						<span class="number">1</span>
						<span class="name">Set Developer Account{$complet}</span>
					</li>
					<li class="importSteps  {$step2}" id="importStepTwo">
						<span class="number">2</span>
						<span class="name">Connect to Quickbooks</span>
					</li>
				</ul>
END_PER_TABLE_TBODY;
		return $activestepsqb;

	}
	function qb_stepstoconnect($clientId, $clientSecret,$config){ // Accounting portal steps
		$displaystyle = '';			
		if(!empty($clientId) || !empty($clientSecret)){	
			$displaystyle = 'displayNone';	
		}
		$stepstoconnectqb =  <<<END_PER_TABLE_TBODY
	<div class="panel panel-default  {$displaystyle}" id="qb_connectsteps">
		<div  class="panel-body">
			<h4 style="margin-top:0;">Create and Configure Quickbooks Developer portal</h4>
			<ol style="list-style: disc; margin-left: 40px;">
				<li style="margin-bottom: 0.8em;"><a href="https://accounts.intuit.com/signup.html" target="_blank" title="Sign Up To Developer Portal">Sign Up</a> / <a href="https://accounts.intuit.com/index.html" target="_blank" title="Sign In Developer Portal">Sign In</a> into the developer portal and click <a href="https://developer.intuit.com/app/developer/myapps" target="_blank" title="Go to Apps Page">My Apps</a> on the top right corner.</li>
				<li style="margin-bottom: 0.8em;">Click Create new app .</li>
				<li style="margin-bottom: 0.8em;">Click Select APIs under Just start coding.</li>
				<li style="margin-bottom: 0.8em;">Select Accounting and click on Create app.</li>
				<li style="margin-bottom: 0.8em;">Complete the Account Profile.</li>
				<li style="margin-bottom: 0.8em;">Provide EULA & Privacy Policy URLs in Settings</li>
				<li style="margin-bottom: 0.8em;">Add the Redirect URI (<strong>{$config->quickbook->oauth_redirect_uri}</strong>) in the Production sections</li>
				<li style="margin-bottom: 0.8em;">Click on the Keys tab to get your production keys - Client ID and Client Secret -from the developer portal.</li>
				<li style="margin-bottom: 0.8em;">Select all the event triggers and enter Endpoint URL in production webhook <strong>https://{$_SERVER['HTTP_HOST']}/app/views/quickbook_webhook.php</strong></li>
				<li style="margin-bottom: 0.8em;">Enter the Webhook Token in the Accounting portal</li>
			</ol>
		</div>
		<div class="panel-footer clearfix">
			<input type="button" style="float:right;" value="Next" id="gotosteptwo">
		</div>
	</div>
END_PER_TABLE_TBODY;
		return $stepstoconnectqb;
	}
	function getInvoice($invoiceId , $QuickBookKeys, $config){
		
		$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);

		$invoice = $dataService->FindbyId('invoice', $invoiceId);
		
		
		$error = $dataService->getLastError();
		if ($error) {
		    echo $error->getResponseBody();
		    return $error->getResponseBody();
		}
		else {
			return $invoice;
		}
	}
	function getPayments($paymentId , $QuickBookKeys, $config){
		
		$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);

		$payment = $dataService->FindbyId('payment', $paymentId);
		
		
		$error = $dataService->getLastError();
		if ($error) {
		    echo $error->getResponseBody();
		    return;
		}
		else {
			return $payment;
		}
	}
	function invoice($database, $QuickBookKeys, $signatureTypArr,$custID,$config,$invoiceId = '',$type=''){ // To Create Invoice
		$return_val_arr = array('returnval'=>'','qb_error_id'=>'');

		$items_ret_arr = Item($QuickBookKeys, $config,$signatureTypArr,$database,$type);

		if($items_ret_arr['qb_error_id']){
			$return_val_arr['qb_error_id'] = $items_ret_arr['qb_error_id'];
		}else{
			if(empty($items_ret_arr['returnval'])){
				$itemid = 1;
				$items_arr = array(
								    array(
								    	"Id"=> "1", 
								        "LineNum" => "1",
							        	"Description"=> $signatureTypArr['company'].' - '.$signatureTypArr['project_name'].' - Draws '.$signatureTypArr['application_number'],
								        "Amount" => $signatureTypArr['currentApp'],
								        "DetailType" => "SalesItemLineDetail",
								        "SalesItemLineDetail" => array(
								           "ItemRef" => array(
															"value" => $itemid,
															"Name" => $signatureTypArr['project_name']." - Draws ".$signatureTypArr['application_number'],
														),
								            "TaxCodeRef" => array(
							             		"value" => "NON"
							           		)
								        )

								    ),

							    );
			}else{
				$items_arr = $items_ret_arr['returnval'];
			}
			$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
			if(!empty($type) && $type =='retention'){
				$item_type = 'Retention Draw - Invoice';
				$docNumber = substr($signatureTypArr['user_custom_project_id'],0,11).' (Ret#'.$signatureTypArr['application_number'].')';
			}else{
				$item_type = 'Draw - Invoice';
				$docNumber = substr($signatureTypArr['user_custom_project_id'],0,11).' ('.$signatureTypArr['application_number'].')';
			}
			$invoicearr = 	array(
						    "Line" => $items_arr,
						    "CustomerRef"=> array(
						          "value"=> $custID
						    ),
						    "DocNumber"=>$docNumber,
						    "TxnDate"=>$signatureTypArr['through_date']
						);

		
			if(!empty($invoiceId)){ // Update an Existing Invoice
				$invoice = $dataService->FindbyId('invoice', $invoiceId);
				$theResourceObj = Invoice::update($invoice, $invoicearr);
				$resultingObj = $dataService->Update($theResourceObj);
			}else{ //Add a new Invoice
				$theResourceObj = Invoice::create($invoicearr);
				$resultingObj = $dataService->Add($theResourceObj);
			}
			$error = $dataService->getLastError();
			$invoiceId = '';
			if ($error) {
				$param_err_arr = array('item_id'=>$signatureTypArr['drawId'], 'errorlog'=> $error->getResponseBody(),'item_type'=>$item_type);
				$return_val_arr['qb_error_id'] = qb_api_error_log($database, $param_err_arr);

			} else {
				if(!empty($signatureTypArr['drawId'])){
		    	update_invoiceid($database, $signatureTypArr['drawId'], $resultingObj->Id);
		   		}
			    $invoiceId = $resultingObj->Id;
			    $return_val_arr['returnval'] = 'invoicecreated';
			}
		}
		return $return_val_arr;
		
	}

	function customerCreateOnly($database, $QuickBookKeys,  $config, $params_arr = array()){
		$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
		$customerarr = array();
		$customerarr['FullyQualifiedName'] = $params_arr['customer_name'];
		$customerarr['CompanyName']  = $params_arr['customer_name'];
		$customerarr['DisplayName']  = $params_arr['customer_name'];
		$customerarr['GivenName']  = $params_arr['customer_name'];

		$theResourceObj = Customer::create($customerarr);


		$resultingObj = $dataService->Add($theResourceObj);

		$error = $dataService->getLastError();
		$customerId = '';
		if ($error) {
			echo $error->getResponseBody();
		    $errorArr  = array();
			
			$errorArr['project_id'] = $params_arr['project_id'];
			$errorArr['quickbook'] = 'Customer - name add Error';
			$errorArr['log'] = $error->getResponseBody();

			addQBerrorLog($database,$errorArr);
		} else {
		    $customerId = $resultingObj->Id; 
		}
		return $customerId;
	}

	function customerCreate($database, $QuickBookKeys, $signatureTypArr,$config){ // To create Customer

		$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
	
        $customerarr = array();
        $customerarr['BillAddr']['Line1'] = $signatureTypArr['address']['Address 1'].' '.$signatureTypArr['address']['Address 2'];
        $customerarr['BillAddr']['City'] = $signatureTypArr['address']['city'];
        $customerarr['BillAddr']['Country'] = 'USA';
        $customerarr['BillAddr']['CountrySubDivisionCode'] = $signatureTypArr['address']['state'];
        $customerarr['BillAddr']['PostalCode'] = $signatureTypArr['address']['zip'];
		$customerarr['FullyQualifiedName'] = $signatureTypArr['Owner']['description'];
		$customerarr['CompanyName']  = $signatureTypArr['Owner']['description'];
		$customerarr['DisplayName']  = $signatureTypArr['Owner']['description'];
		$customerarr['GivenName']  = $signatureTypArr['Owner']['description'];


        $theResourceObj = Customer::create($customerarr);


		$resultingObj = $dataService->Add($theResourceObj);
		$error = $dataService->getLastError();
		$customerId = '';
		if ($error) {
			echo $error->getResponseBody();
		    $errorArr  = array();
			$errorArr['draw_id'] = $signatureTypArr['drawId'];
			$errorArr['application_number'] = $signatureTypArr['application_number'];
			$errorArr['project_id'] = $signatureTypArr['project_id'];
			$errorArr['user_id'] = $signatureTypArr['user_id'];
			$errorArr['quickbook'] = 'Customer';
			$errorArr['log'] = $error->getResponseBody();

			addQBerrorLog($database,$errorArr);
		    die;
		}
		else {
		    if(!empty($signatureTypArr['Owner']['signatureBlockId'])){
		    	update_customerid($database,$signatureTypArr['Owner']['signatureBlockId'], $resultingObj->Id);
		    }
		    $customerId = $resultingObj->Id; 
		}
		return $customerId;
	}
	function refreshToken($client_id, $client_secret, $refreshtoken, $RealmID, $user_company_id, $config, $database){ // To get Refresh Token

	    $dataService = DataService::Configure(array(
	        'auth_mode' => 'oauth2',
	        'ClientID' => $client_id,
	        'ClientSecret' =>  $client_secret,
	        'RedirectURI' => $config->quickbook->oauth_redirect_uri,
	        'baseUrl' => $config->quickbook->environment,
	        'refreshTokenKey' => $refreshtoken,
	        'QBORealmID' => $RealmID,
	    ));

	    /*
	     * Update the OAuth2Token of the dataService object
	     */
	    $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
	    $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
	   

	    $accessToken = $refreshedAccessTokenObj;
	    $accessTokenJson = array(
						'token_type' => 'bearer',
					    'access_token' => $accessToken->getAccessToken(),
					    'refresh_token' => $accessToken->getRefreshToken(),
					    'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
					    'expires_in' => $accessToken->getAccessTokenExpiresAt(),
					    'realmID' => $RealmID
					);


		if(!empty($accessToken->getAccessToken()) && !empty($accessToken->getRefreshToken())){
			updateQBTokenDetails($database, $user_company_id, $accessTokenJson);
		}
	}
	function drawtoquickbooks($database,$QuickBookKeys,$signatureTypArr,$user_company_id,$config,$custID,$type=''){
		$return_val_arr = array('returnval'=>'N','qb_error_id'=>'');

		// Check Token & Refresh Token		
		if(!empty($QuickBookKeys['refresh_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['refresh_token_expires'])){ // Refresh Token Expire
			$return_val_arr['returnval'] = 'refreshtokenexpired';
		}else if(!empty($QuickBookKeys['access_token_expires']) &&  strtotime("now") > strtotime($QuickBookKeys['access_token_expires'])){ // Access Token Expire
			
			refreshToken($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'], $user_company_id, $config, $database);
			$QuickBookKeys = getCompanyData($database, $user_company_id);
		}

		if(empty($QuickBookKeys['client_id'])){ // Quickbooks Keys are not available
			$return_val_arr['returnval'] = 'Quickbooks Keys are not available';
		}else{ // Quickbooks Keys are there

			$description = $signatureTypArr['Owner']['description'];
			$qbcustid = get_qb_custidbyname($QuickBookKeys,$config,$description);
			
			if(empty($qbcustid)){ // Create the Customer 
				$customerId = customerCreate($database, $QuickBookKeys,$signatureTypArr,$config);
			}else{
				$customerId = $qbcustid;
				$signBlockId = $signatureTypArr['Owner']['signatureBlockId'];
				if(empty($signatureTypArr['Owner']['quickbook_cust_id']) || $signatureTypArr['Owner']['quickbook_cust_id'] != $customerId){
					update_customerid($database, $signBlockId, $qbcustid);
				}
			}

			$project_cust_name = $signatureTypArr['Owner']['project_customer'];
		
			$customerId = get_qb_projcustidbyname($QuickBookKeys,$config,$project_cust_name);

			// Invoice
			if(!empty($customerId)){
				if(!empty($signatureTypArr['qb_invoiceid'])){ // Update Invoice
					$return_invoice_arr = invoice($database,$QuickBookKeys,$signatureTypArr,$customerId,$config, $signatureTypArr['qb_invoiceid'],$type);
				}else{ // Create Invoice
					$return_invoice_arr =  invoice($database,$QuickBookKeys,$signatureTypArr,$customerId,$config,'',$type);
				}
				$return_val_arr['returnval'] = $return_invoice_arr['returnval'];
				$return_val_arr['qb_error_id'] = $return_invoice_arr['qb_error_id'];
			}else{
				$return_val_arr['returnval'] = 'Customer is not available in Quickbooks';
			}
		}
		return $return_val_arr;
	}

	function get_qb_custidbyname($QuickBookKeys,$config,$customer_name){

		$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);

		$query = "Select * from Customer where DisplayName = '".$customer_name."'";
		$customer = $dataService->Query($query);
		
		$customer_id = '';
		if(!empty($customer['0']->Id)){
			$customer_id = $customer['0']->Id;
		}
		return $customer_id;
	}
	function get_qb_projcustidbyname($QuickBookKeys,$config,$customer_name){

		$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);

		$query = "Select * from Customer where FullyQualifiedName = '".$customer_name."'";
		$customer = $dataService->Query($query);
		
		$customer_id = '';
		if(!empty($customer['0']->Id)){
			$customer_id = $customer['0']->Id;
		}
		return $customer_id;
	}
	function get_qb_itemidbyname($QuickBookKeys,$config,$item_name){

		$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);

		$query = "Select * from Item where Name = '".$item_name."'";
		$item = $dataService->Query($query);
		$item_id = '';
		if(!empty($item['0']->Id)){
			$item_id = $item['0']->Id;
		}
		return $item_id;
	}
	function checkaccountingportal($database, $user_company_id,$config){

		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		$returnstatus = '<input style="font-weight: bold; background: #28a745; color: white;" value="Connected" type="text" class="form-control">';
		if(empty($QuickBookKeys['client_id'])){
			$returnstatus = '<input style="font-weight: bold; background:#dc3545; color: white;" value="Disconnected" type="text" class="form-control">';
		}

		return $returnstatus;

	}
	function getAccountingPortal($clientId, $clientSecret, $user_company_id,$quickbook_status, $webhooktoken, $readonly){ // Accounting Portal Page
				
		$textfielddis  = $buttondisable = '';
		if(!empty($readonly)){
			$textfielddis  = 'readonly';
			$buttondisable = 'disabled';
		}
		$displaystyle = 'displayNone';
		if(!empty($clientId) || !empty($clientSecret)){	
			$displaystyle = '';	
		}


		$accountingportal =  <<<END_PER_TABLE_TBODY
		<div class="panel panel-default {$displaystyle}" id="qb_connectkeys">
			<div class="panel-heading accounting-header">Quickbooks</div>
			<div  class="panel-body">
				<div class="" style="display: block;overflow: hidden;margin-bottom: 20px;">
					<label style="width: 20%; font-weight: 700;">Client Id <span style="color: red;">*</span></label>
					<div class="" style="float: left;width: 75%;">
						<input type="text" placeholder="Client ID" value="$clientId" id="clientID" class="form-control" $textfielddis> 
					</div>
				</div>
				<div class="" style="display: block;overflow: hidden;margin-bottom: 20px;">
					<label style="width: 20%; font-weight: 700;">Client Secret <span style="color: red;">*</span></label>
					<div class="" style="float: left;width: 75%;">
						<input type="text" placeholder="Client Secret" value="$clientSecret" id="clientSecret" class="form-control" $textfielddis>
					</div>
				</div>
				<div class="" style="display: block;overflow: hidden;margin-bottom: 20px;">
					<label style="width: 20%; font-weight: 700;">Webhook Verifier Token <span style="color: red;">*</span></label>
					<div class="" style="float: left;width: 75%;">
						<input type="text" placeholder="Webhook Token" value="$webhooktoken" id="webhooktoken" class="form-control" $textfielddis>
					</div>
				</div>
				<div class="" style="display: block;overflow: hidden;margin-bottom: 20px;">
					<label style="width: 20%; font-weight: 700;">Status</label>
					<div class="" style="float: left;width: 75%;">
						{$quickbook_status}
					</div>
				</div>
				<input type="hidden" id="user_company_id" value="$user_company_id">
			</div>
			<div class="panel-footer clearfix">
				<input type="button" value="Back" id="gotostepone"/>
				<input type="button" style="float:right;" value="Test Connection" id="connectW" $buttondisable/>
			</div>
		</div>
END_PER_TABLE_TBODY;

		return $accountingportal;
	}
	function Item($QuickBookKeys, $config,$signatureTypArr , $database, $type=''){
		$return_val_arr = array('returnval'=>'','qb_error_id'=>'');
		$dataService =  getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
		$accounts = $dataService->Query("Select * from Account WHERE AccountSubType='SalesOfProductIncome'");
		$itemId = '';
		$sales_line_item_arr = array();
		if(!empty($accounts['0']->Id)){
			$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
			$IncomeAccountRef = $accounts['0']->Id;

			$sales_line_id = 1;
			$sales_line_desc = $signatureTypArr['company'].' - '.$signatureTypArr['project_name'].' - Draws '.$signatureTypArr['application_number'];	

			$error_message = '';

			foreach($signatureTypArr['budget'] as $eachbudget){
				$itemId = '';
				$sku = $itemname = $eachbudget['costCode'];

				$itemarr = array(
						"Name" => $itemname,
						"Sku" => $sku,
						"Type" => "Service",
						"Description" => $eachbudget['costCode'],
						"IncomeAccountRef" =>array("value" => $IncomeAccountRef),
						
					);
				$qbitemid =  get_qb_itemidbyname($QuickBookKeys,$config,$itemname);

				if(!empty($qbitemid)){ // Update an Existing Invoice
					$item = $dataService->FindbyId('item', $qbitemid);
					$theResourceObj = Item::update($item, $itemarr);
					$resultingObj = $dataService->Add($theResourceObj);
				}else{ //Add a new Invoice
					$theResourceObj = Item::create($itemarr);
					$resultingObj = $dataService->Add($theResourceObj);
				}
				$error = $dataService->getLastError();

				if ($error) {
				 	$error_message .= $error->getResponseBody();
				} else {
					$itemId = $resultingObj->Id;
					if(!empty($itemId)){
						$sales_line_item_arr[] = array(
							"Id"=> $sales_line_id, 
						    "LineNum" => $sales_line_id,
							"Description"=> $eachbudget['costCodeData'],
						    "Amount" => $eachbudget['current_app'],
						    "DetailType" => "SalesItemLineDetail",
						    "SalesItemLineDetail" => array(
						       "ItemRef" => array(
									"value" => $itemId,
									"Name" => $itemname,
								),
						        "TaxCodeRef" => array(
						     		"value" => "NON"
						   		)
						    )
						);
						$sales_line_id++;
					}
				}
			}

			if(!empty($type) && $type =='retention'){
				$item_type = 'Retention Draw - Items';
			}else{
				$item_type = 'Draw - Items';
			}

			if(!empty($error_message)){
				$param_err_arr = array('item_id'=>$signatureTypArr['drawId'], 'errorlog'=> $error_message,'item_type'=>$item_type);
				$return_val_arr['qb_error_id'] = qb_api_error_log($database, $param_err_arr);
			}

			$return_val_arr['returnval'] = $sales_line_item_arr;
		}
		return $return_val_arr;
	}

	function getinvoicearrById($QuickBookKeys, $config, $invoicearr){
		$invoice = "'" . implode ( "', '", $invoicearr ) . "'";

		$dataService = getQBConfig($QuickBookKeys['client_id'], $QuickBookKeys['client_secret'], $QuickBookKeys['access_token'], $QuickBookKeys['refresh_token'], $QuickBookKeys['realmID'],$config);
		$query = "Select * from Invoice WHERE Id IN (".$invoice.")";
		$invoices = $dataService->Query($query);

		return $invoices;
	}

	
?>

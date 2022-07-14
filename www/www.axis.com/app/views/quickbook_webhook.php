<?php 
	/*$myfile = fopen("../../quickbooks.txt", "w") or die("Unable to open file!");
	$text = 'quickbook';
	fwrite($myfile, "\n". $text);
	fclose($myfile);
	die;*/	
	// Quickbook Webhook
	require_once('../models/accounting_model.php');
	require_once('../functions/accounting.php');
	require_once('../functions/accounting-quickbook.php');
	
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

	$session = Zend_Registry::get('session');

 
		// Step - 1
		// Log into your Intuit Developer account and navigate into the application you are developing. Click on settings and scroll down to Webhooks.
		// Paste your endpoint URL. This URL must be exposed over the internet and be secured via HTTPS.
		// Check the events desired (or Select All to enable all of them).
		// Click Save.
		// After you are done, click the 'Show Token' button and copy that token and paste here($webhook_token).
	//$webhook_token = "c1409f19-834c-43de-8575-2b7b9e05089d";
	
/*	$payLoad = print_r(file_get_contents("php://input"),TRUE);
	$myfile = fopen("../../quickbooks.txt", "a") or die("Unable to open file!");
	fwrite($myfile, "\n". print_r($_SERVER,TRUE));
	fclose($myfile);*/

 	$payLoad = print_r(file_get_contents("php://input"),TRUE);
	$myfile = fopen("../../quickbooks.txt", "a") or die("Unable to open file!");
	fwrite($myfile, "\n". $payLoad);
	fclose($myfile);
	if (isset($_SERVER['HTTP_INTUIT_SIGNATURE']) && !empty($_SERVER['HTTP_INTUIT_SIGNATURE'])) 
	{
		$payLoad = print_r(file_get_contents("php://input"),TRUE);
/*		$myfile = fopen("../../quickbooks.txt", "a") or die("Unable to open file!");
		fwrite($myfile, "\n". $payLoad);
		fclose($myfile);*/
		//if ($this->isValidJSON($payLoad)) {
		if (true) {
			$payLoad_data = json_decode($payLoad, true);

				
			foreach ($payLoad_data['eventNotifications'] as $event_noti) {
				$realmId = $event_noti['realmId'];	//	this is your company-ID from Intuit
				$QuickBookKeys = quickbookrealmidTokens($database, $realmId);
				if(!empty($QuickBookKeys['webhook_token'])){
					$webhook_token = $QuickBookKeys['webhook_token'];
					$payloadHash = hash_hmac('sha256', $payLoad, $webhook_token);
					$singatureHash = bin2hex(base64_decode($_SERVER['HTTP_INTUIT_SIGNATURE']));

					$text = 'Webhooktoken'.$webhook_token.'Payload'.$payloadHash.'signaturehash'.$singatureHash;

					$myfile = fopen("../../quickbooks.txt", "a") or die("Unable to open file!");
					fwrite($myfile, "\n". $text);
					fclose($myfile);
					

					if($payloadHash == $singatureHash) {

					// now do whatever you want to do with data received from Intuit...
						foreach($event_noti['dataChangeEvent']['entities'] as $entries) {
								// ...
							if(!empty($entries) && $entries['name'] ==  'Payment'){

								$paymentId = $entries['id'];
								$payments = getPayments($paymentId , $QuickBookKeys, $config);
								
								if(!empty($payments)){
									$payments_array = json_decode(json_encode($payments), true);
										
									if(!empty($payments_array['Line']['LinkedTxn']['TxnId']))
									{
										$invoiceId = $payments_array['Line']['LinkedTxn']['TxnId'];
										$drawData = getDrawData($database, $QuickBookKeys, $invoiceId);
										$invoice = getInvoice($invoiceId, $QuickBookKeys, $config);

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
							    		if(!empty($drawstatus) && $drawstatus != $drawData['status']){
							    			updateqbstatus($database, $drawData['id'], $drawstatus);
							    		}
									}
								}
							}else if(!empty($entries['name']) && $entries['name'] == 'Invoice'){

								$QuickBookKeys = quickbookrealmidTokens($database, $realmId);
								$invoiceId = $entries['id'];
							
								$drawData = getDrawData($database,$QuickBookKeys, $invoiceId);
								$invoice = getInvoice($invoiceId, $QuickBookKeys, $config);

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
					    		if(!empty($drawstatus) && $drawstatus != $drawData['status']){
					    			updateqbstatus($database, $drawData['id'], $drawstatus);
					    		}

							}
						}
					} else {
							// not verified
					}
				}
			}
		}
	}
	 
	 
	// check JSON
	function isValidJSON($string) {
		if (!isset($string) || trim($string) === '') {
			return false;
		}

		@json_decode($string);
		if (json_last_error() != JSON_ERROR_NONE) {
			return false;
		}
		return true;
	}
?>
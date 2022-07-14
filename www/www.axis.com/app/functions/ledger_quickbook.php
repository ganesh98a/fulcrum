<?php
	use QuickBooksOnline\API\DataService\DataService;
	use QuickBooksOnline\API\Facades\Account;

	function getAccountDetailsFromQB($database, $config, $user_company_id){ // Get the Other Current Asset Accounts From QB to Fulcrum.
		$QuickBookKeys = quickbookNewTokens($database, $user_company_id, $config);
		$dataService =  getQBConfig($QuickBookKeys[CLIENT_ID], $QuickBookKeys[CLIENT_SECRET], $QuickBookKeys[ACCESS_TOKEN], $QuickBookKeys[REFRESH_TOKEN], $QuickBookKeys[REALMID], $config);
		$query = "Select * from Account MaxResults 250";
		
		$return_arr = array();
		$return_arr[REALMID] = $QuickBookKeys[REALMID];
		$return_arr['accounts'] = $dataService->Query($query);
		
		return $return_arr;
	}


?>

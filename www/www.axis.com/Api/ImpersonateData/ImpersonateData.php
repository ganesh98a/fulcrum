<?php
/* Impersonate company data get*/
require_once('lib/common/UserCompany.php');

if(isset($RN_user['actual_user_role']) && $RN_user['actual_user_role'] == "global_admin"){
	$RN_arrTmp = UserCompany::loadUserCompaniesList($database);
	$RN_arrImpersonatedUserCompanyOptions = $RN_arrTmp['options_list'];

	$RN_jsonEC['data']['impersonate_data']['companies'] = $RN_arrImpersonatedUserCompanyOptions;
	// user list
	foreach($RN_arrTmp['options_list'] as $RN_key => $RN_CompanyName){
		$RN_arrImpersonatedUserOptions = array();
		$RN_selectedImpersonatedUserCompany = $RN_key;
		// get the users against companies
		$RN_arrTmp = User::loadUsersList($database, $RN_selectedImpersonatedUserCompany);
		$RN_arrImpersonatedUserOptions = $RN_arrTmp['options_list'];
		//  Assign the users to json variable
		$RN_jsonEC['data']['impersonate_data']['users'][$RN_key] = $RN_arrImpersonatedUserOptions;
	}
}else{
	$RN_jsonEC['data']['impersonate_data'] = null;
}
?>
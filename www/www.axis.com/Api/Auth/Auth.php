<?php
if (is_int(strpos($RN_NE, '@'))) {
	$u = User::findUserByEmailAuthentication($database, $RN_NE, $RN_PD, '', true);
} elseif (is_int(ctype_digit($RN_NE))) {
	$u = User::findUserByMobilePhoneNumberAuthentication($database, $RN_NE, $RN_PD, '', true);
} else {
	$u = User::findUserByScreenNameAuthentication($database, $RN_NE, $RN_PD, '', true);
}

if($u){
	$RN_arrayTemp = array();
	$RN_arrayTempVal = 0;
	$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $u->user_company_id);
	$RN_arrayTemp[$RN_arrayTempVal]['user_company_id'] = $u->user_company_id;
	$RN_arrayTemp[$RN_arrayTempVal]['user_company_name'] = $userCompany->user_company_name;
	$RN_arrayTemp[$RN_arrayTempVal]['user_id'] = $u->user_id;
	$RN_arrayTemp[$RN_arrayTempVal]['role_id'] = $u->role_id;
	$RN_arrayTemp[$RN_arrayTempVal]['actual_role'] = $u->getUserRole();
	$RN_arrayTemp[$RN_arrayTempVal]['primary_contact_id'] = (int) $u->primary_contact_id;
	$RN_arrayTemp[$RN_arrayTempVal]['default_project_id'] = $u->default_project_id;
	$RN_arrayTemp[$RN_arrayTempVal]['active_contact_id'] = (int) $u->currentlyActiveContactId;
	$RN_arrayTemp[$RN_arrayTempVal]['screen_name'] = $u->screen_name;
	$RN_arrayTemp[$RN_arrayTempVal]['mobile_phone_number'] = $u->mobile_phone_number;
	$RN_arrayTemp[$RN_arrayTempVal]['email'] = $u->email;
	$RN_arrayTemp[$RN_arrayTempVal]['password_hash'] = $u->password_hash;
	$RN_arrayTemp[$RN_arrayTempVal]['password_guid'] = $u->password_guid;
	$RN_arrayTemp[$RN_arrayTempVal]['change_password_flag'] = $u->change_password_flag;
	$RN_arrayTemp[$RN_arrayTempVal]['security_phrase'] = $u->security_phrase;
	$RN_arrayTemp[$RN_arrayTempVal]['modified'] = $u->modified;
	$RN_arrayTemp[$RN_arrayTempVal]['accessed'] = $u->accessed;
	$RN_arrayTemp[$RN_arrayTempVal]['created'] = $u->created;
	$RN_arrayTemp[$RN_arrayTempVal]['tc_accepted_flag'] = $u->tc_accepted_flag;
	$RN_arrayTemp[$RN_arrayTempVal]['remember_me_flag'] = $u->remember_me_flag;
	$RN_arrayTemp[$RN_arrayTempVal]['disabled_flag'] = $u->disabled_flag;
	$RN_arrayTemp[$RN_arrayTempVal]['deleted_flag'] = $u->deleted_flag;
	$RN_arrayTemp[$RN_arrayTempVal]['currentlySelectedProjectUserCompanyId'] = $u->currentlySelectedProjectUserCompanyId;
	$RN_arrayTemp[$RN_arrayTempVal]['currentlySelectedProjectId'] = $u->currentlySelectedProjectId;
	$RN_arrayTemp[$RN_arrayTempVal]['currentlySelectedProjectName'] = $u->currentlySelectedProjectName;
	$RN_arrayTemp[$RN_arrayTempVal]['currentlyActiveContactId'] = $u->currentlyActiveContactId;
	$RN_arrayTemp[$RN_arrayTempVal]['currentlyActiveTemplateTheme'] = $u->currentlyActiveTemplateTheme;
	$RN_arrayTemp[$RN_arrayTempVal]['projects'] = array();
	// $RN_arrayTemp[$RN_arrayTempVal]['projects'] = array_values($u->getArrOwnedProjects());
	if (isset($u) && $u->change_password_flag == 'Y') {
		$RN_jsonEC['status'] = 401;
		$RN_jsonEC['err_message'] = "Please update your account password to continue";
	}else{
		// save the user device details id
		include_once('UserDeviceInfoSave.php');	
		// return response
		$RN_jsonEC['status'] = 202;
		$RN_jsonEC['message'] = "Login Successfully";
		$RN_jsonEC['access_token'] = $u->password_guid;
		$RN_jsonEC['data'] = $RN_arrayTemp[$RN_arrayTempVal];
	}
}else{
	$RN_jsonEC['status'] = 401;
	$RN_jsonEC['err_message'] = "Invalid username or password";
}
?>

<?php
/**
 * User profile.
 *
 */
$init['access_level'] = 'global_admin';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

require_once('lib/common/PageComponents.php');
require_once('lib/common/Role.php');
require_once('lib/common/UserDetail.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

// Conditionally show password related fields for "New User Creation" case only
if (isset($get) && $get->mode && ($get->mode == 'update') && $get->user_id) {
	$showPasswordFields = false;
} else {
	$showPasswordFields = true;
}


// retrieve any postback data from the session store.
$postBack = Egpcs::sessionGet($applicationLabel, 'admin-user-creation-form.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	if (isset($get) && $get->mode && ($get->mode == 'update') && $get->user_id) {
		$selectedUser = $get->user_id;
	} else {
		$selectedUser = '';
	}

	// set values using $postBack
	// User Security Information (users table)
	$user_company_id = $postBack->user_company_id;
	$role_id = $postBack->role_id;
	$mobile_phone_area_code = $postBack->mobile_phone_area_code;
	$mobile_phone_prefix = $postBack->mobile_phone_prefix;
	$mobile_phone_number = $postBack->mobile_phone_number;
	$mobile_network_carrier_id = $postBack->mobile_network_carrier_id;
	$email = $postBack->email;
	$screen_name = $postBack->screen_name;
	$password = $postBack->password;
	$password2 = $postBack->password2;
	$security_question = $postBack->security_question;
	$security_answer = $postBack->security_answer;
	// alerts
	$alerts = $postBack->alertTypes;
	if (isset($alerts) && !empty($alerts)) {
		$arrAlertTypes = array();
		foreach ($alerts as $value) {
			$arrAlertTypes[$value] = 1;
		}

		if (isset($arrAlertTypes['emailAlert'])) {
			$alertsEmailChecked = 'checked';
		} else {
			$alertsEmailChecked = '';
		}

		if (isset($arrAlertTypes['smsAlert'])) {
			$alertsSmsChecked = 'checked';
		} else {
			$alertsSmsChecked = '';
		}
	} else {
		$alertsEmailChecked = 'checked';
		$alertsSmsChecked = 'checked';
	}

	// Optional Personal Information (user_details table)
	$first_name = $postBack->first_name;
	$last_name = $postBack->last_name;
	$jobTitle = $postBack->title;
	$company_name = $postBack->company_name;
	$website = $postBack->website;
	$phoneAreaCode = $postBack->phoneAreaCode;
	$phonePrefix = $postBack->phonePrefix;
	$phoneNumber = $postBack->phoneNumber;
	$phoneExtension = $postBack->phoneExtension;
	$address_line_1 = $postBack->address_line_1;
	$address_line_2 = $postBack->address_line_2;
	$address_line_3 = $postBack->address_line_3;
	$address_city = $postBack->address_city;
	$address_state = $postBack->address_state;
	$address_zip = $postBack->address_zip;
	$address_country = $postBack->address_country;
} else {
	// Check if update mode
	if (isset($get) && $get->mode && ($get->mode == 'update') && $get->user_id) {
		$user_id = $get->user_id;
		$selectedUser = $user_id;
		$u = User::findUserById($database, $user_id);
		/* @var $u User */
		$ud = UserDetail::findUserDetailByUserId($database, $user_id);
		/* @var $ud UserDetail */

		$password = '';
		$securityQuestion = '';
		$securityAnswer = '';

		// User Security Information (users table)
		$user_company_id = $u->user_company_id;
		$role_id = $u->role_id;
		$mobile_phone_number = $u->mobile_phone_number;
		$mobilePhoneAreaCode = substr($mobile_phone_number, 0, 3);
		$mobilePhonePrefix = substr($mobile_phone_number, 3, 3);
		$mobilePhoneNumber = substr($mobile_phone_number, 6, 4);
		$mobile_phone_area_code = $mobilePhoneAreaCode;
		$mobile_phone_prefix = $mobilePhonePrefix;
		$mobile_phone_number = $mobilePhoneNumber;
		$mobile_network_carrier_id = $u->mobile_network_carrier_id;
		$email = $u->email;
		$screen_name = $u->screen_name;
		$password = '';
		$password2 = '';
		$security_question = '';
		$security_answer = '';
		$alerts = $u->alerts;
		if ($alerts == 'Both') {
			$alertsEmailChecked = 'checked';
			$alertsSmsChecked = 'checked';
		} elseif ($alerts == 'Email') {
			$alertsEmailChecked = 'checked';
			$alertsSmsChecked = '';
		} elseif ($alerts == 'SMS') {
			$alertsEmailChecked = '';
			$alertsSmsChecked = 'checked';
		} else {
			$alertsEmailChecked = '';
			$alertsSmsChecked = '';
		}

		// Optional Personal Information (user_details table)
		$first_name = $ud->first_name;
		$last_name = $ud->last_name;
		$jobTitle = $ud->title;
		$company_name = '';
		$website = '';
		$phoneAreaCode = '';
		$phonePrefix = '';
		$phoneNumber = '';
		$phoneExtension = '';
		$address_line_1 = '';
		$address_line_2 = '';
		$address_line_3 = '';
		$address_city = '';
		$address_state = '';
		$address_zip = '';
		$address_country = '';
	} else {
		// set default from field values as empty strings
		// Initialize form values to blank
		$selectedUser = '';
		$password = '';
		$securityQuestion = '';
		$securityAnswer = '';

		//User Security Information (users table)
		$user_id = '';
		$user_company_id = '';
		$role_id = '';
		$mobile_phone_area_code = '';
		$mobile_phone_prefix = '';
		$mobile_phone_number = '';
		$mobile_network_carrier_id = '';
		$email = '';
		$screen_name = '';
		$password = '';
		$password2 = '';
		$security_question = '';
		$security_answer = '';
		$alertsEmailChecked = '';
		$alertsSmsChecked = '';

		// Optional Personal Information (user_details table)
		$first_name = '';
		$last_name = '';
		$jobTitle = '';
		$company_name = '';
		$website = '';
		$phoneAreaCode = '';
		$phonePrefix = '';
		$phoneNumber = '';
		$phoneExtension = '';
		$address_line_1 = '';
		$address_line_2 = '';
		$address_line_3 = '';
		$address_city = '';
		$address_state = '';
		$address_zip = '';
		$address_country = '';
	}
}


// Load a list of User Companies
$arrTmp = UserCompany::loadUserCompaniesList($database);
$arrTemp = array('' => 'Select A Company');
$arrUserCompanyOptions = $arrTmp['options_list'];
$arrUserCompanyOptions = $arrTemp + $arrUserCompanyOptions;
$selectedUserCompany = $user_company_id;
$template->assign('selectedUserCompany', $selectedUserCompany);
$template->assign('arrUserCompanyOptions', $arrUserCompanyOptions);

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
  <script src="/js/fSelect.js"></script>
  <script src="/js/admin-creation.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlCss .= <<<END_HTML_CSS
<link href="/css/fSelect.css" rel="stylesheet">
END_HTML_CSS;

$htmlTitle = 'User Admin';
// $htmlBody = "onload='setFocus();'";

require('template-assignments/main.php');

$template->assign('queryString', $uri->queryString);
//$template->assign('htmlMessages', $htmlMessages);
$template->assign('loginName', $loginName);
$template->assign('screen_name', $screen_name);
$template->assign('user_id', $user_id);
$emailUrlEncoded = urlencode($email);
$template->assign('emailUrlEncoded', $emailUrlEncoded);

$template->assign('showPasswordFields', $showPasswordFields);

// users table
$template->assign('mobile_phone_area_code', $mobile_phone_area_code);
$template->assign('mobile_phone_prefix', $mobile_phone_prefix);
$template->assign('mobile_phone_number', $mobile_phone_number);
$template->assign('mobile_network_carrier_id', $mobile_network_carrier_id);
$template->assign('email', $email);
$template->assign('password', $password);
$template->assign('password2', $password2);
$template->assign('security_question', $security_question);
$template->assign('security_answer', $security_answer);

$template->assign('alertsSmsChecked', $alertsSmsChecked);
$template->assign('alertsEmailChecked', $alertsEmailChecked);

// user_details table
$template->assign('first_name', $first_name);
$template->assign('last_name', $last_name);
$template->assign('job_title', $jobTitle);
$template->assign('company_name', $company_name);
$template->assign('website', $website);
//$template->assign('displayedPhoneNumber', $displayedPhoneNumber);
$template->assign('address_line_1', $address_line_1);
$template->assign('address_line_2', $address_line_2);
$template->assign('address_line_3', $address_line_3);
$template->assign('address_city', $address_city);
$template->assign('address_state', $address_state);
$template->assign('address_zip', $address_zip);
$template->assign('address_country', $address_country);

// Load a list of Users
$arrTmp = User::loadUsersList($database);
$arrTemp = array('' => 'Please Select A Registered User To Edit');
$arrUserOptions = $arrTmp['options_list'];
$arrUserOptions = $arrTemp + $arrUserOptions;
$template->assign('arrUserOptions', $arrUserOptions);
$template->assign('selectedUser', $selectedUser);
$dropdownUserListOnChange = 'window.location=\'admin-user-creation-form.php?mode=update&user_id=\'+(this.options[this.selectedIndex].value)';
$template->assign('dropdownUserListOnChange', $dropdownUserListOnChange);


// Load a list of User Roles
$arrUserRoles = Role::loadUserRoles($database);
$arrUserRoleList = array('' => 'Select An Access Level');
foreach ($arrUserRoles as $tmpUserRole) {
	/* @var $tmpUserRole Role */

	$tmpRoleName = $tmpUserRole->role;
	$tmpRoleId = $tmpUserRole->role_id;

	// don't allow Global Admin, unless user creating the other user is a Global Admin
	if (($userRole != 'global_admin') && ($tmpRoleName == 'Global Admin')) {
		continue;
	}
	if($tmpRoleName == 'Global Admin')
	{
		continue;
	}

	$arrUserRoleList[$tmpRoleId] = $tmpRoleName;
}
$template->assign('arrUserRoles', $arrUserRoleList);
$selectedUserRole = $role_id;
$template->assign('selectedUserRole', $selectedUserRole);

// Query strings for new and edit cases
if ($uri->queryString) {
	$createUserQueryString = $uri->queryString . '&mode=insert';
	$editUserQueryString = $uri->queryString . '&mode=update';
} else {
	$createUserQueryString = '?mode=insert';
	$editUserQueryString = '?mode=update';
}
$template->assign('createUserQueryString', $createUserQueryString);
$template->assign('editUserQueryString', $editUserQueryString);

$htmlContent = $template->fetch('admin-user-creation-form.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');
exit;

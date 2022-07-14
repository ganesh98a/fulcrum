<?php
/**
 * User profile.
 *
 */
$init['access_level'] = 'anon';
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
require_once('lib/common/UserInvitation.php');
require_once('lib/common/ContactCompany.php');



require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

// Verify access to this page via the GUID passed in on the $_GET query string
$accessDenied = true;
if (isset($get) && $get->guid) {
	$guid = $get->guid;
	$userInvitation = UserInvitation::verifyInvitation($database, $guid);
	/* @var $userInvitation UserInvitation */

	if ($userInvitation && ($userInvitation instanceof UserInvitation)) {
		$accessDenied = false;
	}
}

if ($accessDenied) {
	$url = $uri->referrer;
	header("Location: $url");
	exit;
}


// retrieve any postback data from the session store.
$postBack = Egpcs::sessionGet($applicationLabel, 'account-registration-form.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

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
	// set default from field values as empty strings
	// Initialize form values to blank
	$password = '';
	$securityQuestion = '';
	$securityAnswer = '';


	// Use the contact's data to pre-populate the form fields.
	$contact_id = $userInvitation->contact_id;
	$contact = new Contact($database);
	$key = array('id' => $contact_id);
	$contact->setKey($key);
	$contact->load();
	$contact->convertDataToProperties();

	$contact_company_id = $contact->contact_company_id;
	$contactCompany = new ContactCompany($database);
	$key = array('id' => $contact_company_id);
	$contactCompany->setKey($key);
	$contactCompany->load();
	$contactCompany->convertDataToProperties();


	// User Security Information (users table)
	$company_name = $contactCompany->contact_company_name;
	$user_company_id = $contactCompany->contact_user_company_id;
	$employer_identification_number = $contactCompany->employer_identification_number;
	$construction_license_number = $contactCompany->construction_license_number;
	$construction_license_number_expiration_date = $contactCompany->construction_license_number_expiration_date;
	$role_id = '';
	$mobile_phone_area_code = '';
	$mobile_phone_prefix = '';
	$mobile_phone_number = '';
	$mobile_network_carrier_id = '';
	$email = $contact->email;
	$screen_name = '';
	$password = '';
	$password2 = '';
	$security_question = '';
	$security_answer = '';
	$alertsEmailChecked = '';
	$alertsSmsChecked = '';

	// Optional Personal Information (user_details table)
	$first_name = $contact->first_name;
	$last_name = $contact->last_name;
	$jobTitle = $contact->title;
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


/*
// Load a list of User Companies
// Core class are already included
//require_once('lib/common/UserCompany.php');
$arrTmp = UserCompany::loadUserCompaniesList($database);
$arrUserCompanyOptions = $arrTmp['options_list'];
$selectedUserCompany = $user_company_id;
$template->assign('selectedUserCompany', $selectedUserCompany);
$template->assign('arrUserCompanyOptions', $arrUserCompanyOptions);
*/


$htmlTitle = 'Account Registration';
$htmlBody = "onload='setFocus();'";

require('template-assignments/main.php');

$template->assign('queryString', $uri->queryString);
//$template->assign('htmlMessages', $htmlMessages);
$template->assign('loginName', $loginName);
$template->assign('screen_name', $screen_name);

// users table
$template->assign('mobile_phone_area_code', $mobile_phone_area_code);
$template->assign('mobile_phone_prefix', $mobile_phone_prefix);
$template->assign('mobile_phone_number', $mobile_phone_number);
$template->assign('mobile_network_carrier_id', $mobile_network_carrier_id);
$template->assign('email', $email);
$template->assign('password', $password);
$template->assign('security_question', $security_question);
$template->assign('security_answer', $security_answer);

$template->assign('alertsSmsChecked', $alertsSmsChecked);
$template->assign('alertsEmailChecked', $alertsEmailChecked);

// user_details table
$template->assign('first_name', $first_name);
$template->assign('last_name', $last_name);
$template->assign('job_title', $jobTitle);
$template->assign('company_name', $company_name);
//$template->assign('website', $website);
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
$arrTemp = array('' => 'Select A User');
$arrUserOptions = $arrTmp['options_list'];
$arrUserOptions = $arrTemp + $arrUserOptions;
$template->assign('arrUserOptions', $arrUserOptions);
// Temporary
$selectedUser = '';
$template->assign('selectedUser', $selectedUser);


// Load a list of User Roles
require_once('lib/common/Role.php');
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

	$arrUserRoleList[$tmpRoleId] = $tmpRoleName;
}
$template->assign('arrUserRoles', $arrUserRoleList);
$selectedUserRole = $role_id;
$template->assign('selectedUserRole', $selectedUserRole);

$template->assign('contact_company_name', $company_name);

$template->assign('employer_identification_number', $employer_identification_number);
$template->assign('construction_license_number', $construction_license_number);
$template->assign('construction_license_number_expiration_date', $construction_license_number_expiration_date);
$template->assign('user_invitation_guid', $guid);

$htmlContent = $template->fetch('account-registration-form.tpl');
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');

$template->display('master-web-html5.tpl');
exit;

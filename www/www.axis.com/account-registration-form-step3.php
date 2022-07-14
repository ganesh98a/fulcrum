<?php
/**
 * User account registration.
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
require_once('lib/common/MobileNetworkCarrier.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);


if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

<style>
#wrapper {
	border: 0px solid #f0f0f0;
	margin-left: auto;
	margin-right: auto;
	width: 800px;
}
</style>
END_HTML_CSS;


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
} else {
	// Determine if we have a "Registered Company" or not
	$contact_user_company_id = $userInvitation->contact_user_company_id;

	if ($contact_user_company_id == 1) {
		// account-registration-form-step2.php required the Fed Tax ID to be entered
		// account-registration-form-step2-submit.php checked for a user_companies record based on that Fed Tax ID
		// if contact_user_company_id is 1 then we will be creating a new user_companies record as well as new contact_companies and contacts records
		//		for the newly registered User Company/User
		$contactCompanyRegisteredFlag = false;

if (!isset($htmlJavaScriptHead)) {
	$htmlJavaScriptHead = '';
}
$htmlJavaScriptHead .= <<<END_HTML_JAVASCRIPT_HEAD

<script>
function setFocus()
{
	var obj = document.getElementById("user_company_name");
	if (obj != null) {
		obj.focus();
		if (obj.select) {
			obj.select();
		}
	}
}
</script>
END_HTML_JAVASCRIPT_HEAD;

	} else {

		$contactCompanyRegisteredFlag = true;

if (!isset($htmlJavaScriptHead)) {
	$htmlJavaScriptHead = '';
}
$htmlJavaScriptHead .= <<<END_HTML_JAVASCRIPT_HEAD

<script>
function setFocus()
{
	var obj = document.getElementById("mobile_phone_area_code");
	if (obj != null) {
		obj.focus();
		if (obj.select) {
			obj.select();
		}
	}
}
</script>
END_HTML_JAVASCRIPT_HEAD;

	}

	$contact_id = $userInvitation->contact_id;
	require_once('lib/common/Contact.php');
	$contact = new Contact($database);
	$key = array('id' => $contact_id);
	$contact->setKey($key);
	$contact->load();
	$contact->convertDataToProperties();

	$contact_company_id = $contact->contact_company_id;
	require_once('lib/common/ContactCompany.php');
	$contactCompany = new ContactCompany($database);
	$key = array('id' => $contact_company_id);
	$contactCompany->setKey($key);
	$contactCompany->load();
	$contactCompany->convertDataToProperties();

	if ($contactCompany->contact_user_company_id == 1) {
		// Check the value in the user_invitations record to see if step2 provided a "Registered Company" value
		if ($userInvitation->contact_user_company_id != 1) {
			$contact_user_company_id = $userInvitation->contact_user_company_id;
			$employer_identification_number = $userInvitation->employer_identification_number;
		} else {
			$contact_user_company_id = '';
			$employer_identification_number = '';
		}
	} else {
		$contact_user_company_id = $contactCompany->contact_user_company_id;
	}
}

// Reset the form inputs from account-registration-form-step1.php
Egpcs::sessionClearKey($applicationLabel, 'account-registration-form-step1.php', 'post');

// retrieve any postback data from the session store.
$postBack = Egpcs::sessionGet($applicationLabel, 'account-registration-form-step3.php', 'post');
/* @var $postBack Egpcs */

// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// set values using $postBack
	// User Company Data (user_companies table)
	$user_company_name = $postBack->user_company_name;
	$employer_identification_number = $postBack->employer_identification_number;
	$construction_license_number = $postBack->construction_license_number;
	$construction_license_number_expiration_date = $postBack->construction_license_number_expiration_date;

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

	// User Company Data (user_companies table)
	$user_company_name = $contactCompany->contact_company_name;
	if (isset($userInvitation->employer_identification_number) && !empty($userInvitation->employer_identification_number)) {
		$employer_identification_number = $userInvitation->employer_identification_number;
	} else {
		$employer_identification_number = $contactCompany->employer_identification_number;
	}
	$construction_license_number = $contactCompany->construction_license_number;
	$construction_license_number_expiration_date = $contactCompany->construction_license_number_expiration_date;

	// User Security Information (users table)
	$user_company_id = $contactCompany->contact_user_company_id;
	$role_id = '';

	require_once('lib/common/MobilePhoneNumber.php');
	$mobilePhoneNumber = $contact->getMobilePhoneNumber();
	if ($mobilePhoneNumber)  {
		$mobile_phone_area_code = $mobilePhoneNumber->area_code;
		$mobile_phone_prefix = $mobilePhoneNumber->prefix;
		$mobile_phone_number = $mobilePhoneNumber->number;
		$mobile_network_carrier_id = $mobilePhoneNumber->mobile_network_carrier_id;
		$alertsSmsChecked = 'checked';
	} else {
		$mobile_phone_area_code = '';
		$mobile_phone_prefix = '';
		$mobile_phone_number = '';
		$mobile_network_carrier_id = '';
		$alertsSmsChecked = '';
	}

	$email = $contact->email;
	$screen_name = '';
	$password = '';
	$password2 = '';
	$security_question = '';
	$security_answer = '';
	$alertsEmailChecked = 'checked';

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


$htmlTitle = 'Account Registration';
//$htmlBody = "onload='setFocus();'";
$htmlBody = '';

$headline = 'Register Your Fulcrum Account';
$template->assign('headline', $headline);

require('template-assignments/main.php');

$template->assign('queryString', $uri->queryString);
//$template->assign('htmlMessages', $htmlMessages);
$template->assign('loginName', $loginName);
$template->assign('screen_name', $screen_name);

// user_companies table
$template->assign('user_company_name', $user_company_name);
$template->assign('employer_identification_number', $employer_identification_number);
$template->assign('construction_license_number', $construction_license_number);
$template->assign('construction_license_number_expiration_date', $construction_license_number_expiration_date);

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
//$template->assign('website', $website);
//$template->assign('displayedPhoneNumber', $displayedPhoneNumber);
$template->assign('address_line_1', $address_line_1);
$template->assign('address_line_2', $address_line_2);
$template->assign('address_line_3', $address_line_3);
$template->assign('address_city', $address_city);
$template->assign('address_state', $address_state);
$template->assign('address_zip', $address_zip);
$template->assign('address_country', $address_country);

$template->assign('user_invitation_guid', $guid);

$template->assign('contact_user_company_id', $contact_user_company_id);

$htmlContent = $template->fetch('account-registration-form-step3.tpl');
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');

$template->display('master-web-unauthenticated-html5.tpl');
exit;

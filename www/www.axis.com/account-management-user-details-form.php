<?php
/**
 * Account management - update Optional Personal Information (user_details table).
 *
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');



// Retrieve any html messages
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

$loginName = $session->getLoginName();
// retrieve any postback data
$postBack = Egpcs::sessionGet($applicationLabel, 'account-management-user-details-form.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// set values using $postBack
	// Password/security section
	$currentPassword = $postBack['currentPassword'];
	//$securityQuestion = $postBack['security_question']; //?
	//$securityAnswer = $postBack['security_answer']; //?


	// User Details
	$name_prefix = $postBack->name_prefix;
	$first_name = $postBack->first_name;
	$additional_name = $postBack->additional_name;
	$middle_name = $postBack->middle_name;
	$last_name = $postBack->last_name;
	$name_suffix = $postBack->name_suffix;

	$address_line_1 = $postBack->address_line_1;
	$address_line_2 = $postBack->address_line_2;
	$address_line_3 = $postBack->address_line_3;
	$address_city = $postBack->address_city;
	$address_state = $postBack->address_state;
	$address_zip = $postBack->address_zip;
	$address_country = $postBack->address_country;

	$website = $postBack->website;
	$jobTitle = $postBack->title;
	$company_name = $postBack->company_name;
	$pseudonym = $postBack->pseudonym;
	$avatar = $postBack->avatar;
	$image = $postBack->image;
	$bgimage = $postBack->bgimage;
	$watermark = $postBack->watermark;
} else {
	$user_id = $session->getUserId();

	$currentPassword = '';

	// Load User information from the database
	// users table ($u)
	$u = new User($database);
	$key = array('id' => $user_id);
	$u->setKey($key);
	$u->load();
	$u->convertDataToProperties();

	$securityQuestion = $u->security_question;
	$securityAnswer = $u->security_answer;
	$phone = $u->mobile_phone_number;
	$phoneAreaCode = substr($phone, 0, 3);
	$phonePrefix = substr($phone, 3, 3);
	$phoneNumber = substr($phone, 6, 4);
	$phoneExtension = substr($phone, 10, 5);


	// Load User Details information from the database
	// user_details table ($ud)
	require_once('lib/common/UserDetail.php');
	$ud = new UserDetail($database);
	$key = array('user_id' => $user_id);
	$ud->setKey($key);
	$ud->load();
	$ud->convertDataToProperties();

	$name_prefix = $ud->name_prefix;
	$first_name = $ud->first_name;
	$additional_name = $ud->additional_name;
	$middle_name = $ud->middle_name;
	$last_name = $ud->last_name;
	$name_suffix = $ud->name_suffix;

	$address_line_1 = $ud->address_line_1;
	$address_line_2 = $ud->address_line_2;
	$address_line_3 = $ud->address_line_3;
	$address_city = $ud->address_city;
	$address_state = $ud->address_state;
	$address_zip = $ud->address_zip;
	$address_country = $ud->address_country;

	$website = $ud->website;
	$jobTitle = $ud->title;
	$company_name = $ud->company_name;
	$pseudonym = $ud->pseudonym;
	$avatar = $ud->avatar;
	$image = $ud->image;
	$bgimage = $ud->bgimage;
	$watermark = $ud->watermark;
}

$htmlTitle = 'Update Your Optional Personal Information';
$htmlBody = "onload='setFocus();'";

if (!empty($phone)) {
	$displayedPhoneNumber = '';
	$displayedPhoneNumber .= !empty($phoneAreaCode) ? ' ('.$phoneAreaCode.')':'';
	$displayedPhoneNumber .= !empty($phonePrefix) ? ' '.$phonePrefix:'';
	$displayedPhoneNumber .= !empty($phoneNumber) ? '-'.$phoneNumber:'';
	$displayedPhoneNumber .= !empty($phoneExtension) ? ' x'.$phoneExtension:'';
}

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

$template->assign('queryString', $uri->queryString);
$template->assign('loginName', $loginName);
$template->assign('currentPassword', $currentPassword);

$template->assign('first_name', $first_name);
$template->assign('last_name', $last_name);
$template->assign('job_title', $jobTitle);
$template->assign('company_name', $company_name);
$template->assign('website', $website);
$template->assign('address_line_1', $address_line_1);
$template->assign('address_line_2', $address_line_2);
$template->assign('address_line_3', $address_line_3);
$template->assign('address_city', $address_city);
$template->assign('address_state', $address_state);
$template->assign('address_zip', $address_zip);
$template->assign('address_country', $address_country);
if (isset($useMobileTemplatesFlag) && $useMobileTemplatesFlag) {
	$htmlContent = $template->fetch('account_management_mobile.tpl');
} else {
	$htmlContent = $template->fetch('account-management-user-details-form.tpl');
}
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-html5.tpl');

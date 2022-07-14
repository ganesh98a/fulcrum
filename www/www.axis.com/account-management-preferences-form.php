<?php
/**
 * Account management - update account profile information.
 *
 *
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

header('X-Robots-Tag: noindex, noarchive, nosnippet', true);

require_once('lib/common/PageComponents.php');
require_once('lib/common/UserDetail.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

$loginName = $session->getLoginName();


// Initialize form values to blank
$currentPassword = '';

$mobile_phone_area_code = '';
$mobile_phone_prefix = '';
$mobile_phone_number = '';

$mobile_network_carrier = '';

$email = '';

$screen_name = '';

$security_question = '';

$security_answer = '';

$alerts = 'Both';

$privacy = 'Prompt to Share';

// retrieve any postback data
$postBack = Egpcs::sessionGet($applicationLabel, 'account-management-preferences-form.php', 'post');
/* @var $postBack Egpcs */
// check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	$mobile_phone_area_code = $postBack->mobile_phone_area_code;
	$mobile_phone_prefix = $postBack->mobile_phone_prefix;
	$mobile_phone_number = $postBack->mobile_phone_number;

	$mobile_network_carrier_id = $postBack->mobile_network_carrier_id;

	$email = $postBack->email;

	$screen_name = $postBack->screen_name;

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
} else {
	// Load user account information
	$user_id = Session::getInstance()->getUserId();
	$u = User::findUserById($database, $user_id);
	/* @var $u User */

	$phone = $u->mobile_phone_number;
	$mobile_phone_area_code = substr($phone, 0, 3);
	$mobile_phone_prefix = substr($phone, 3, 3);
	$mobile_phone_number = substr($phone, 6, 4);

	$mobile_network_carrier_id = $u->mobile_network_carrier_id;

	$email = $u->email;

	$screen_name = $u->screen_name;

	$security_question = $u->security_question;

	$security_answer = $u->security_answer;

	$alerts = $u->alerts;
	switch ($alerts) {
		case 'SMS':
			$alertsSmsChecked = 'checked';
			$alertsEmailChecked = '';
			break;

		case 'Email':
			$alertsSmsChecked = '';
			$alertsEmailChecked = 'checked';
			break;

		case 'Both':
			$alertsSmsChecked = 'checked';
			$alertsEmailChecked = 'checked';
			break;

		default:
			$alertsSmsChecked = 'checked';
			$alertsEmailChecked = 'checked';
			break;
	}
}


// Potentially hide the form...on successful password reset
if (isset($get->hideForm) && ($get->hideForm == 1)) {
	$template->assign('hideForm', 1);
	$template->assign('startOverUrl', $uri->currentPhpScript);
}


$htmlTitle = 'Update Your Account Security Information';
$htmlBody = "onload='setFocus();'";


if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="/css/color-picker-spectrum-jquery.css" rel="stylesheet" type="text/css">
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/color-picker-spectrum-jquery.js"></script>
	<script src="/js/user-preferences.js"></script>
END_HTML_JAVASCRIPT_BODY;

require('template-assignments/main.php');

ob_start();
include('templates/account-management-preferences.php');
$htmlContent = ob_get_clean();
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-html5.tpl');

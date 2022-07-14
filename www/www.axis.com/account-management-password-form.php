<?php
/**
 * Account management - password.
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

// retrieve any html messages
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
// retrieve any postback data
$postBack = Egpcs::sessionGet($applicationLabel, 'account-management-password-form.php', 'post');
/* @var $postBack Egpcs */
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// set values using $postBack
	$currentPassword = $postBack->auth_pass;
	$newPassword1 = $postBack->new_pass1;
	$newPassword2 = $postBack->new_pass2;
} else {
	if (isset($get->n) && !empty($get->n)) {
		$currentPassword = $get->n;
	} else {
		$currentPassword = '';
	}

	$newPassword1 = '';
	$newPassword2 = '';
}


// Potentially hide the form...on successful password reset
if (isset($get->hideForm) && ($get->hideForm == 1)) {
	$template->assign('hideForm', 1);
	$template->assign('startOverUrl', $uri->currentPhpScript);
}

if (isset($get->n) && !empty($get->n)) {
	$currentPasswordDocumentId = '';
	$newPasswordDocumentId = 'id="first_element"';
} else {
	$currentPasswordDocumentId = 'id="first_element"';
	$newPasswordDocumentId = '';
}

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS

END_HTML_CSS;
if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY

END_HTML_JAVASCRIPT_BODY;

$template->assign('currentPasswordDocumentId', $currentPasswordDocumentId);
$template->assign('newPasswordDocumentId', $newPasswordDocumentId);

$htmlTitle = 'MyFulcrum.com - Change Your Password';
$htmlBody = "onload='setFocus();'";

require('template-assignments/main.php');

$template->assign('queryString', $uri->queryString);
$template->assign('currentPassword', $currentPassword);
$template->assign('newPassword1', $newPassword1);
$template->assign('newPassword2', $newPassword2);

$htmlContent = $template->fetch('account-management-password-form.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

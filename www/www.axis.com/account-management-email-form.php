<?php
/**
 * Account management - update email address (users table).
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
// Always load user account information since we are displaying the current email address for this form
// Load User information from the database
// users table ($u)
$u = new User($database);
$user_id = $session->getUserId();
$key = array('id' => $user_id);
$u->setKey($key);
$u->load();
$u->convertDataToProperties();
$email = $u->email;

// Retrieve any postback data
$postBack = Egpcs::sessionGet($applicationLabel, 'account-management-email-form.php', 'post');
/* @var $postBack Egpcs */
// Check $postBackFlag to see if info is queried from db or comes from postBack via submit script.
$postBackFlag = $postBack->getPostBackFlag();
if ($postBackFlag && $postBack instanceof Egpcs) {
	// htmlentities for all $postBack values
	$postBack->convertToHtml();

	// Set values using $postBack
	// Always reset currentPassword field to ""
	$currentPassword = '';

	$new_email1 = $postBack->new_email1;
	$new_email2 = $postBack->new_email2;
} else {
	// Always reset currentPassword field to ""
	$currentPassword = '';

	$new_email1 = '';
	$new_email2 = '';
}


// Potentially hide the form...on successful password reset
if (isset($get->hideForm) && ($get->hideForm == 1)) {
	$template->assign('hideForm', 1);
	$template->assign('startOverUrl', $uri->currentPhpScript);
}


$htmlTitle = 'Change Your Email Address';
$htmlBody = "onload='setFocus();'";

require('template-assignments/main.php');

$template->assign('queryString', $uri->queryString);
$template->assign('email', $email);
$template->assign('currentPassword', $currentPassword);
$template->assign('new_email1', $new_email1);
$template->assign('new_email2', $new_email2);

$htmlContent = $template->fetch('account-management-email-form.tpl');
$template->assign('htmlContent', $htmlContent);

$template->display('master-web-html5.tpl');

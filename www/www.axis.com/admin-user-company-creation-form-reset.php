<?php
/**
 * Reset the form.
 *
 */
$init['access_level'] = 'global_admin';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

Egpcs::sessionClearKey($applicationLabel, 'admin-user-company-creation-form.php', 'post');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset('admin-user-company-creation-form.php');
$message->sessionPut();

$session->setFormSubmitted(false);

if (isset($get) && $get->mode) {
	$mode = $get->mode;
	if ($mode == 'insert') {
		$url = 'admin-user-company-creation-form.php';
	} elseif ($mode == 'update') {
		$managed_user_company_id = $get->managed_user_company_id;
		$url = 'admin-user-company-creation-form.php?mode=update&managed_user_company_id='.$managed_user_company_id;
	} else {
		$url = 'admin-user-company-creation-form.php';
	}
} else {
	$url = 'admin-user-company-creation-form.php';
}

header('Location: '.$url);
exit;

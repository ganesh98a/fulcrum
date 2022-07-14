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

Egpcs::sessionClearKey($applicationLabel, 'admin-user-creation-form.php', 'post');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset('admin-user-creation-form.php');
$message->sessionPut();

$session->setFormSubmitted(false);

if (isset($get) && $get->mode) {
	$mode = $get->mode;
	if ($mode == 'insert') {
		$url = 'admin-user-creation-form.php';
	} elseif ($mode == 'update') {
		// Verify User (user_id)
		if (!$get->user_id) {
			$message->enqueueError('Please select a valid user.', 'admin-user-creation-form.php');
			$message->sessionPut();
			header('Location: /admin-user-creation-form.php');
			exit;
		}

		$user_id = $get->user_id;
		$url = 'admin-user-creation-form.php?mode=update&user_id='.$user_id;
	} else {
		$url = 'admin-user-creation-form.php';
	}
} else {
	$url = 'admin-user-creation-form.php';
}

header('Location: '.$url);
exit;

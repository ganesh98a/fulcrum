<?php
/**
 * Reset the form.
 *
 */
$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

Egpcs::sessionClearKey($applicationLabel, 'account-registration-form.php', 'post');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset('account-registration-form.php');
$message->enqueueConfirm('You have successfully reset the form.', 'account-registration-form.php');
$message->sessionPut();

$session->setFormSubmitted(false);

$registrationStep = $get->registrationStep;
if ($registrationStep) {
	switch ($registrationStep) {
		case 'step1':
			$url = 'account-registration-form-step1.php';
			break;
		case 'step2':
			$url = 'account-registration-form-step2.php';
			break;
		case 'step3':
			$url = 'account-registration-form-step3.php';
			break;
		case 'step4':
			$url = 'account-registration-form-step4.php';
			break;
		case 'step5':
			$url = 'account-registration-form-step5.php';
			break;
		case 'step6':
			$url = 'account-registration-form-step6.php';
			break;
		default:
			$url = 'account-registration-form.php';
			break;
	}
} else {
	$url = 'account-registration-form.php';
}

header('Location: '.$url);
exit;

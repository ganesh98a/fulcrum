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

Egpcs::sessionClearKey($applicationLabel, 'account-registration-form-step3.php', 'post');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset('account-registration-form-step3.php');
$message->enqueueConfirm('You have successfully reset the form.', 'account-registration-form-step3.php');
$message->sessionPut();

$session->setFormSubmitted(false);

$url = 'account-registration-form-step3.php'.$uri->queryString;

header('Location: '.$url);
exit;

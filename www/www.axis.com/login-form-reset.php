<?php
/**
 * Reset the form.
 *
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');



Egpcs::sessionClearKey($applicationLabel, 'login-form.php', 'post');

$message = Message::getInstance();
/* @var $message Message */
$message->reset('login-form.php');
$message->enqueueConfirm('You have successfully reset the form.', 'login-form.php');
$message->sessionPut();
$session->setFormSubmitted(false);

$url = 'login-form.php' . $uri->queryString;
header('Location: '.$url);
exit;

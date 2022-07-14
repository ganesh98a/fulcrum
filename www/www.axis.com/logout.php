<?php
/**
 * Logout script.
 */
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
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
//require_once('lib/common/Egpcs.php');

/* @var $session Session */
$session->logOut();
unset($_SESSION['scheduledValuesOnly']);
$message = Message::getInstance();
/* @var $message Message */
$message->resetAll();
$message->enqueueConfirm('You have successfully logged out.', 'login-form.php');
$message->sessionPut();

//$filter = new Egpcs();
//$filter->sessionClear();

header('Location: login-form.php');
exit;

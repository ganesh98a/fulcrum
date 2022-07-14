<?php
/**
 * Turn debugging mode on or off. Global Admin only.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

// Test permissions against actual role, so "auth" since may be impersonating a user.
$actualUserRole = $session->getActualUserRole();
if ($actualUserRole <> 'global_admin') {
	exit;
}

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset();

if (isset($get->debugMode)) {

	// Toggle the debugMode via the session
	$debugMode = (bool) $get->debugMode;
	$session->setDebugMode($debugMode);

} elseif (isset($get->cssDebugMode)) {

	// Toggle cssDebugMode via the session
	$cssDebugMode = (bool) $get->cssDebugMode;
	$session->setCssDebugMode($cssDebugMode);

} elseif (isset($get->javaScriptDebugMode)) {

	// Toggle javaScriptDebugMode via the session
	$javaScriptDebugMode = (bool) $get->javaScriptDebugMode;
	$session->setJavaScriptDebugMode($javaScriptDebugMode);

} elseif (isset($get->showJSExceptions)) {

	// Toggle showJSExceptions via the session
	$showJSExceptions = (bool) $get->showJSExceptions;
	$session->setShowJSExceptions($showJSExceptions);

} elseif (isset($get->ajaxUrlDebugMode)) {

	// Toggle ajaxUrlDebugMode via the session
	$ajaxUrlDebugMode = (bool) $get->ajaxUrlDebugMode;
	$session->setAjaxUrlDebugMode($ajaxUrlDebugMode);

} elseif (isset($get->consoleLoggingMode)) {

	// Toggle consoleLoggingMode via the session
	$consoleLoggingMode = (bool) $get->consoleLoggingMode;
	$session->setConsoleLoggingMode($consoleLoggingMode);

}

exit;

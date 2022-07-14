<?php
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['ajax'] = true;
$init['get_required'] = true;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');

// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

// DATABASE VARIABLES
$db = DBI::getInstance($database);

// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();

ob_start();

switch ($methodCall) {
	case 'deleteUserRegistrationLogRecord':
		$user_registration_log_id = $get->user_registration_log_id;

		if (($userRole == 'admin') || ($userRole == 'global_admin') && $user_registration_log_id) {
			require_once('lib/common/UserRegistrationLog.php');
			$userRegistrationLog = new UserRegistrationLog($database);
			$key = array('id' => $user_registration_log_id);
			$userRegistrationLog->setKey($key);
			$userRegistrationLog->delete();
		}

		echo $user_registration_log_id;
		ob_flush();
		exit;
		break;
	default:
		break;
}

ob_flush();
exit;

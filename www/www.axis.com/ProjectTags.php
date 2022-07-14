<?php
try{

$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset();
// SESSION VARIABLES
/* @var $session Session */
$session = Zend_Registry::get('session');
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_id = $session->getUserId();
$user_company_id = $session->getUserCompanyId();
$project_id = $session->getCurrentlySelectedProjectId();

require_once('Project_tag_functions.php');



setlocale(LC_MONETARY, 'en_US');
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
$db = DBI::getInstance($database);
require_once('module-html-contents/Projects-tag-html.php');
	echo $buildUnitsHtml;

} catch (Exception $e) {
	require('./error/500.php');
}
exit;



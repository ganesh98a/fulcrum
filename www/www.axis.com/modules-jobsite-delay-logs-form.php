<?php
/**
 * DELAYS Module.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['skip_always_include'] = false;
$init['skip_session'] = false;
$init['skip_templating'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('lib/common/Message.php');
$message = Message::getInstance();
require_once('modules-jobsite-delay-logs-functions.php');

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
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

//New Permissions
require('app/models/permission_mdl.php');
//Check the permisson for view delay
$userCanViewDelays = checkPermissionForAllModuleAndRole($database,'delay_logs_view');
$userCanManageDelays = checkPermissionForAllModuleAndRole($database,'delay_logs_manage');



// If No Access
if($userRole !="global_admin")
{
if (!$userCanViewDelays &&(!$userCanManageDelays) || (!$userCanManageDelays &&(!$userCanViewDelays) ) ) {
	$errorMessage = 'Permission denied.';
	$message->enqueueError($errorMessage, $currentPhpScript);
	
}
}
if($userRole =="global_admin")
{
	$userCanManageDelays=1;
}
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
// Include css
if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="/css/modules-requests-for-information.css" rel="stylesheet">
<link href="/css/fSelect.css" rel="stylesheet">
END_HTML_CSS;

// Include javascript
if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
	<script src="/js/generated/file_manager_files-js.js" async></script>
	<script src="/js/jobsite_delay_log.js" async></script>
	<script src="/js/fSelect.js"></script>
	<script src="/js/jquery.ui.sortable.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Delays - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();

// Generate a log table of delay datas and assign to variable
$delayTable = renderDelayListView_AsHtml($database,$project_id,$userCanManageDelays);
// Dialog window for create Delay log
$createDelayDialog = buildCreateDelayDialog($database, $user_company_id, $project_id, $currentlyActiveContactId, $dummyId);

$delayDetails = '';



if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

$template->assign('delayTable', $delayTable);
$template->assign('createDelayDialog', $createDelayDialog);
$template->assign('userCanManageDelays', $userCanManageDelays);
$template->assign('loadershow', '1');




$htmlContent = $template->fetch('modules-jobsite-delay-logs-form.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');


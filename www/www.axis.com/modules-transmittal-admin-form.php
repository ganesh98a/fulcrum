<?php
/**
 * TAM Module.
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
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
$init['skip_always_include'] = false;
$init['skip_session'] = false;
$init['skip_templating'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('lib/common/Message.php');
require_once('lib/common/Date.php');
/*transmittal admin functionms */
require_once('modules-transmittal-admin-functions.php');

$message = Message::getInstance();
/* @var $message Message */

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

// PERMISSION VARIABLES
require_once('app/models/permission_mdl.php');
$userCanViewTAM = checkPermissionForAllModuleAndRole($database,'transmittal_template_view');
$userCanManageTAM = checkPermissionForAllModuleAndRole($database,'transmittal_template_manage');
if($userRole !="global_admin")
{
if (!$userCanViewTAM) {
	// Error and exit
	$errorMessage = 'Permission denied.';
	$message->enqueueError($errorMessage, $currentPhpScript);
	// throw new Exception($errorMessage);
}
}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
// Generate a log table of transmittal template files if permission assigned only
if(!$userCanViewTAM && ($userRole !="global_admin")){
	$TAMTable = '';
}else{
	$TAMTable = renderTemplateTypeListView_AsHtml($userCanManageTAM,$database,$userRole);
}
if (!isset($htmlCss)) {
	$htmlCss = '';
}
/*Externel style sheet includes*/
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="/css/module-transmittal-admin.css"></link>
<style>
#softwareModuleHeadline
{
	display:none;
}
</style>
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
/*Script includes*/
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
	<script src="/js/transmittal_admin.js"></script>
	<script src="/js/ckeditor/ckeditor.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Transmittal Admin - MyFulcrum.com';
$htmlBody = '';

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}
/*assign template variables*/
require('template-assignments/main.php');
$template->assign('TAMTable', $TAMTable);
$template->assign('TAMTable', $TAMTable);
$htmlContent = $template->fetch('modules-transmittal-admin-form.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;

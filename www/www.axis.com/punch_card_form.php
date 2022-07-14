<?php

/**
 * Punch Card  Module.
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
require_once('punch_card_functions.php');


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
/*Custome Permission call return value*/

$userCanViewPunch = checkPermissionForAllModuleAndRole($database,'view_punch_card');
$userCanManagePunch = checkPermissionForAllModuleAndRole($database,'manage_punch_card');

// If No Access
if($userRole !="global_admin")
{
if (!$userCanViewPunch &&(!$userCanManagePunch) || (!$userCanManagePunch &&(!$userCanViewPunch) ) ) {
	$errorMessage = 'Permission denied.';
	$message->enqueueError($errorMessage, $currentPhpScript);

}
}
//The modules Should be visible For Global Admin 
if($userRole =="global_admin")
{
	$userCanManagePunch=$userCanViewPunch=1;
}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="/css/modules-requests-for-information.css" rel="stylesheet">


<link rel="stylesheet" media="screen" href="handsontable/css/jquery.handsontable.full.css">
<link rel="stylesheet" media="screen" href="handsontable/css/demo-style.css">

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
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
	<script src="/js/punch_card_admin.js"></script>
	<script src="/js/generated/file_manager_files-js.js"></script>

	<script src="handsontable/js/jquery-ui.custom.min.js"></script>
	<script src="handsontable/js/jquery.handsontable.full.js"></script>
	<script src="handsontable/js/numeral.js"></script>
	<script src="handsontable/js/jquery.handsontable-excel.js"></script>

END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Punch List Admin - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();

// Generate a log table of Defects datas and assign to variable
$buildDefectTable= renderDefectsListView($project_id,$user_company_id,$currentlyActiveContactId,$userCanManagePunch);



$db = DBI::getInstance($database);
	

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
} 
require('template-assignments/main.php');
$template->assign('buildDefectTable', $buildDefectTable);
$template->assign('userCanManagePunch', $userCanManagePunch);
$template->assign('userCanViewPunch', $userCanViewPunch);
// $template->assign('loadershow', '1');
$htmlContent = $template->fetch('punch_card_admin.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;




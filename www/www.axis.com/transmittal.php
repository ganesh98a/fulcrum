<?php

/**
 * Transmittal  Module.
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
require_once('transmittal-functions.php');

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
$permissions = Zend_Registry::get('permissions');
/*Custome Permission call return value*/

require_once('app/models/permission_mdl.php');
$userCanViewTransmittal = checkPermissionForAllModuleAndRole($database,'view_transmittal');
$userCanManageTransmittal = checkPermissionForAllModuleAndRole($database,'create_transmittal');

// If No Access
if($userRole !="global_admin"){
	if (!$userCanViewTransmittal &&(!$userCanManageTransmittal) || (!$userCanManageTransmittal &&(!$userCanViewTransmittal) ) ) {
		$errorMessage = 'Permission denied.';
		$message->enqueueError($errorMessage, $currentPhpScript);

	}
}
//The modules Should be visible For Global Admin 
if($userRole =="global_admin"){
	$userCanManageTransmittal=1;
}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="/css/modules-requests-for-information.css" rel="stylesheet">
<link href="/css/fSelect.css" rel="stylesheet">
<style>
	td#manage-transmittal_data-record-- {
    	vertical-align: top;
	}
	td#manage-transmittal_data-record-- span{
		word-break: break-all;
	    white-space: normal;
	    padding-right: 2px;
	}
	
</style>
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
	<script src="/js/transmittals.js"></script>
	<script src="/js/generated/file_manager_files-js.js"></script>
	<script src="/js/fSelect.js"></script>
	<script src="/js/jquery.ui.sortable.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Transmittal - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();

// Generate a log table of Transmittal datas and assign to variable
$TransmittalTable = renderTransmittalListView_AsHtml($project_id,$userCanManageTransmittal,$database);

$db = DBI::getInstance($database);
	
if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
} 
require('template-assignments/main.php');
$template->assign('TransmittalTable', $TransmittalTable);
$template->assign('userCanManageTransmittal', $userCanManageTransmittal);
$htmlContent = $template->fetch('transmittal.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;




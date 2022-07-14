<?php

/**
 * Subcontractor Change Order  Module.
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
require_once('modules-submittals-registry-functions.php');
require_once('modules-change-orders-functions.php');

$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

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

$db = DBI::getInstance($database);
		//role_id  5 for project manager 
 $query = "SELECT *  FROM `projects_to_contacts_to_roles` WHERE `contact_id` = $currentlyActiveContactId and project_id=$project_id and role_id IN ('5')";
		$db->execute($query);
		$row = $db->fetch();
		if($row)
		{
			$is_manager='1';
		}else
		{
			$is_manager='0';
		}

require_once('app/models/permission_mdl.php');
$userCanManageSubOrder=$userCanManageSCO = checkPermissionForAllModuleAndRole($database,'subcontract_change_order');
$userCanViewSCO = checkPermissionForAllModuleAndRole($database,'subcontract_change_order_view');
// If No Access
if($userRole !="global_admin")
{
	if (!$userCanViewSCO &&(!$userCanManageSCO) || (!$userCanManageSCO &&(!$userCanViewSCO) ) ) {
			$errorMessage = 'Permission denied.';
			$message->enqueueError($errorMessage, $currentPhpScript);
		}
	
}

//The modules Should be visible For Global Admin 
if($userRole =="global_admin" )
{
	$userCanManageSubOrder=$userCanViewSCO=1;
}

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="/css/modules-submittals.css" rel="stylesheet"><link rel="stylesheet" href="/css/modules-budget.css">
<link href="/css/fSelect.css" rel="stylesheet">

END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY



	
	<script src="/js/modules-gc-submittal-registry.js"></script>
	<script src="/js/subcontract_change_order.js"></script>
	<script src="/js/modules-change-orders.js"></script>
	<script src="/js/generated/change_orders-js.js"></script>
	<script src="/js/generated/file_manager_files-js.js"></script>
	<script src="/js/fileuploader-custom.js"></script>
	<script src="/js/generated/submittals-js.js"></script>
	<script src="/js/fSelect.js"></script>
	<script src="/js/jquery.ui.sortable.js"></script>
	<script src="/js/modules-submittals-registry.js"></script>








END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Submittal Registry - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();

	$OrderTable= renderSubcontractChangeOrderListViewRegistry($project_id,$user_company_id,$currentlyActiveContactId,'costcode',null,'all',$database,'Y');

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
} 
require('template-assignments/main.php');
$template->assign('userCanManageSubOrder', $userCanManageSubOrder);
$template->assign('OrderTable', $OrderTable);
$htmlContent = $template->fetch('modules-submittals-registry.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;




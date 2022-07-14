<?php
/**
 * Change Order Module.
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
require_once('lib/common/ChangeOrderDraft.php');
$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;
require('app/models/permission_mdl.php');
require_once('modules-change-orders-functions.php');

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

$userCanViewChangeOrders = checkPermissionForAllModuleAndRole($database,'change_orders_view');
$userCanManageChangeOrders = checkPermissionForAllModuleAndRole($database,'change_orders_manage');
$userCanAnswerChangeOrders = checkPermissionForAllModuleAndRole($database,'change_orders_respond');

if($userRole !="global_admin")
{
if (!$userCanViewChangeOrders &&(!$userCanManageChangeOrders) || (!$userCanManageChangeOrders &&(!$userCanViewChangeOrders) ) ) {
	$errorMessage = 'Permission denied.';
	$message->enqueueError($errorMessage, $currentPhpScript);
	
}
}


if($userRole =="global_admin")
{
	$userCanManageChangeOrders=$userCanViewChangeOrders=$userCanAnswerChangeOrders = 1;
}

$project = Project::findById($database, $project_id);
/* @var $project Project */

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="/css/modules-change-orders.css" rel="stylesheet">
<link href="/css/fSelect.css" rel="stylesheet">

END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/generated/file_manager_files-js.js"></script>
	<script src="/js/generated/change_order_attachments-js.js"></script>
	<script src="/js/generated/change_order_draft_attachments-js.js"></script>
	<script src="/js/generated/change_order_drafts-js.js"></script>
	<script src="/js/generated/change_order_notifications-js.js"></script>
	<script src="/js/generated/change_order_recipients-js.js"></script>
	<script src="/js/generated/change_order_responses-js.js"></script>
	<script src="/js/generated/change_orders-js.js"></script>

	<script src="/js/modules-change-orders.js"></script>
	<script src="/js/fSelect.js"></script>
	<script src="/js/jquery.ui.sortable.js"></script>

END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Change Orders - MyFulcrum.com';
$htmlBody = '';


$dummyId = Data::generateDummyPrimaryKey();

$coTable = renderCoListView_AsHtml($database, $project_id,$user_company_id);
$createCoDialog = buildCreateCoDialog($database, $user_company_id, $project_id, $currentlyActiveContactId, $dummyId);

$ddlChangeOrderDrafts = '';

$coDetails = '';
if (isset($get) && $get->change_order_id) {
	$change_order_id = $get->change_order_id;
	$coDetails = loadChangeOrder($database, $user_company_id, $currentlyActiveContactId, $currentlySelectedProjectId, $change_order_id);
}

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

$template->assign('coTable', $coTable);
$template->assign('coDetails', $coDetails);
$template->assign('createCoDialog', $createCoDialog);
$template->assign('ddlChangeOrderDrafts', $ddlChangeOrderDrafts);
$template->assign('userCanManageChangeOrders', $userCanManageChangeOrders);
//$template->assign('arrContactsByUserCompanyIdJson', $arrContactsByUserCompanyIdJson);

$htmlContent = $template->fetch('modules-change-orders-form.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;

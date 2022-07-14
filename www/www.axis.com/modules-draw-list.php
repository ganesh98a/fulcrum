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
require_once('lib/common/Draws.php');
require_once('lib/common/Message.php');
$message = Message::getInstance();

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

require_once('modules-draw-list-function.php');
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

//Check the permisson for view,edit and post draws
require_once('app/models/permission_mdl.php');
$userCanViewDraws = checkPermissionForAllModuleAndRole($database,'view_draws');
$userCanEditDraws = checkPermissionForAllModuleAndRole($database,'edit_draws');
$userCanPostDraws = checkPermissionForAllModuleAndRole($database,'post_draws');
// If No Access
// if($userRole !="global_admin")
// {
//   if (!$userCanViewDraws && !$userCanEditDraws && !$userCanPostDraws) {
//     $errorMessage = 'Permission denied.';
//     $message->enqueueError($errorMessage, $currentPhpScript);
//   }
// }
// if($userRole =="global_admin")
// {
  $userCanEditDraws=1;
// }
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);


// Include javascript
if (!isset($htmlJavaScriptBody)) {
  $htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
	<script src="/js/modules-draw-list.js" async></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Draws - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();

// Generate draw list grid and assign to variable
$drawListTable = renderDrawListHtml($database,$project_id);
$drawStatus = renderDrawStatusHtml($database);
$getDraftDrawItemCount = Draws::findDraftDrawIdUsingProjectId($database, $project_id);

if (isset($get) && ($get->mobile == 1)) {
  $useMobileTemplatesFlag = true;
} else {
  $useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

$template->assign('userCanViewDraws', $userCanViewDraws);
$template->assign('userCanEditDraws', $userCanEditDraws);
$template->assign('userCanPostDraws', $userCanPostDraws);
$template->assign('drawListTable', $drawListTable);
$template->assign('drawStatus', $drawStatus);
$template->assign('drawDraftCount', $getDraftDrawItemCount);

$htmlContent = $template->fetch('modules-draw-list.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');
exit;

<?php
/**
* Draw Module.
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
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

require_once('modules-draw-list-function.php');
require_once('modules-draw-signature-block-functions.php');

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

$htmlCss = <<<END_HTML_CSS
<link href="/css/modules-create-draw.css" rel="stylesheet">
<link href="/css/fSelect.css" rel="stylesheet">
END_HTML_CSS;
// Include javascript
if (!isset($htmlJavaScriptBody)) {
  $htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
  <script src="/js/modules-draw-list.js" async></script>
  <script src="/js/modules-draw-signature-blocks.js" async></script>
  <script src="/js/generated/draw-signature-blocks.js" async></script>
  <script src="/js/fSelect.js"></script>
 
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Draws - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();

// Generate create draw grid and assign to variable
$currentUrl = parse_url($_SERVER['QUERY_STRING']);
parse_str($currentUrl['path'], $query);
$applicationId = $query['drawId'];


// generate signature blocks
// $draw_id = 1;

$createDrawForm = renderCreateDrawHtml($database,$project_id,$applicationId);
$draw_id = Draws::findLastDrawIdUsingAppId($database, $project_id, $applicationId);
updateProjectOwnerContractor($database, $project_id, $draw_id);
$signaterwDrawContent = renderSignatureBlockContent($database, $project_id, $draw_id);
if (isset($get) && ($get->mobile == 1)) {
  $useMobileTemplatesFlag = true;
} else {
  $useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

$template->assign('createDrawForm', $createDrawForm);
$template->assign('signatureDrawContent', $signaterwDrawContent);
$template->assign('applicationId', $applicationId);
$template->assign('drawId', $draw_id);
$template->assign('softwareModuleFunctionLabel','Draws');

$htmlContent = $template->fetch('modules-create-draw.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');
exit;

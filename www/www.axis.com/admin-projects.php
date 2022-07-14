<?php
/**
 * Project Management.
 *
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');



$session = Zend_Registry::get('session');
/* @var $session Session */
$userRole = $session->getUserRole();
$message = Message::getInstance();
/* @var $message Message */
require_once('app/models/permission_mdl.php');
$userCanManageProjects = checkPermissionForAllModuleAndRole($database,'admin_projects_manage');
$userCanCreateProjects = checkPermissionForAllModuleAndRole($database,'admin_projects_create');
$userCanManageThirdPartyProjects = checkPermissionForAllModuleAndRole($database,'admin_projects_manage_by_third_party');
$userCanViewProjects = checkPermissionForAllModuleAndRole($database,'admin_projects_view');
$userCreateProjects = checkPermissionForAllModuleAndRole($database,'projects_create');

if($userRole =="global_admin")
{
	$userCanManageProjects = $userCanCreateProjects = $userCanManageThirdPartyProjects =$userCanViewProjects=$userCreateProjects=1;
}
$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="css/modules-project-information.css" rel="stylesheet" type="text/css">
END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/jquery.numeric.js"></script>

	<script src="/js/generated/meeting_types-js.js"></script>
	<script src="/js/generated/project_types-js.js"></script>
	<script src="/js/generated/projects-js.js"></script>
	<script src="/js/library-code-generator.js"></script>
	<script src="/js/admin-projects.js"></script>
	<script src="/js/modules-collaboration-manager.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Project Management - MyFulcrum.com';
$htmlBody = '';


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

ob_start();
$show_creation = 0;
if (isset($from_create_menu) && $from_create_menu) {
	$show_creation = 1;
	$template->assign('softwareModuleFunctionLabel', '');
	$template->assign('projectName', '');
}
if ($userCanManageThirdPartyProjects || $userCanManageProjects || $userCanCreateProjects ||$userCanViewProjects || $userCreateProjects || $userRole =="global_admin") {
echo '
<input id="from_creation_menu" name="from_creation_menu" type="hidden" value="'.$show_creation.'">
<input id="the_project_id" name="the_project_id" type="hidden" value="'.$session->getCurrentlySelectedProjectId().'">
<input id="active_project_id" name="active_project_id" type="hidden" value="'.$session->getCurrentlySelectedProjectId().'">
<div id="divProjectInfo"></div>
<div id="divCompanies"></div>
<div id="divSubContractors"></div>
<div id="divProjectTypesDialog" class="hidden"></div>
<div id="divMeetingTypesDialog" class="hidden"></div>
<div id="divRetainerRateDialog"></div>
';
}
else
{
	
	$errorMessage = 'Permission denied.';
    $message->enqueueError($errorMessage, $currentPhpScript);
	$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);
	 if ( !empty($htmlMessages) )
  	echo "<div>$htmlMessages</div>";


}
$htmlContent = ob_get_clean();

$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');
exit;

<?php
/**
 * Submittal Module.
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
require_once('lib/common/SubmittalDraft.php');
$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;
require('app/models/permission_mdl.php');
require_once('modules-submittals-functions.php');

// DATABASE VARIABLES
$db = DBI::getInstance($database);
// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
if(isset($_GET['pID']) && $_GET['pID']!=''){
	$project_id = $currentlySelectedProjectId = base64_decode($_GET['pID']);
}else{
	$project_id = $currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
}
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$login_name=$session->getLoginName();

// PERMISSION VARIABLES

$userCanViewSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_view');
$userCanManageSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_manage');
$userCanAnswerSubmittals = checkPermissionForAllModuleAndRole($database,'submittals_respond');

if($userRole !="global_admin")
{
if (!$userCanViewSubmittals &&(!$userCanManageSubmittals) || (!$userCanManageSubmittals &&(!$userCanViewSubmittals) ) ) {
	$errorMessage = 'Permission denied.';
	$message->enqueueError($errorMessage, $currentPhpScript);
	
}
}


if($userRole =="global_admin")
{
	$userCanManageSubmittals=$userCanViewSubmittals=$userCanAnswerSubmittals = 1;
}

$project = Project::findById($database, $project_id);
/* @var $project Project */

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="/css/modules-submittals.css" rel="stylesheet">
<link href="/css/fSelect.css" rel="stylesheet">
<link href="/css/tags/bootstrap-tokenfield.min.css" rel="stylesheet" type="text/css">


END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/generated/file_manager_files-js.js"></script>
	<script src="/js/generated/submittal_attachments-js.js"></script>
	<script src="/js/generated/submittal_draft_attachments-js.js"></script>
	<script src="/js/generated/submittal_drafts-js.js"></script>
	<script src="/js/generated/submittal_notifications-js.js"></script>
	<script src="/js/generated/submittal_recipients-js.js"></script>
	<script src="/js/generated/submittal_responses-js.js"></script>
	<script src="/js/generated/submittals-js.js"></script>
	<script src="/js/modules-submittals.js"></script>
	<script src="/js/fSelect.js"></script>
	<script src="/js/jquery.ui.sortable.js"></script>
	<script src="/js/bootstrap-tokenfield.js"></script>
	<script src="/js/tag.js"></script>
	<script src="/js/tag_cdnjs.js"></script>

END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Submittals - MyFulcrum.com';
$htmlBody = '';


$dummyId = Data::generateDummyPrimaryKey();

$suTable = renderSuListView_AsHtml($database, $project_id, $user_company_id);

$createSuDialog ="";
$ddlSubmittalDrafts = submittalDraftDropDown($database, $project_id);

$suDetails = '';
if (isset($get) && $get->submittal_id) {
	$submittal_id = $get->submittal_id;
	$suDetails = loadSubmittal($database, $user_company_id, $currentlyActiveContactId, $currentlySelectedProjectId, $submittal_id);
}

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

$template->assign('suTable', $suTable);
$template->assign('suDetails', $suDetails);
$template->assign('ddlSubmittalDrafts', $ddlSubmittalDrafts);
$template->assign('primary_contact_id', $primary_contact_id);
$template->assign('primary_name', $login_name);
$template->assign('userCanViewSubmittals', $userCanViewSubmittals);
$template->assign('userCanManageSubmittals', $userCanManageSubmittals);
$template->assign('userCanAnswerSubmittals', $userCanAnswerSubmittals);


//$template->assign('arrContactsByUserCompanyIdJson', $arrContactsByUserCompanyIdJson);

$htmlContent = $template->fetch('modules-submittals-form.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;

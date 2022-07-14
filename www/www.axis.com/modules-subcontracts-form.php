<?php
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');

require_once('lib/common/Contact.php');
require_once('lib/common/File.php');

require_once('lib/common/Subcontract.php');
require_once('lib/common/SubcontractTemplate.php');
require_once('lib/common/Vendor.php');
require_once('lib/common/SubcontractType.php');
require_once('lib/common/SubcontractTemplateToSubcontractItemTemplate.php');
require_once('lib/common/SubcontractItemTemplate.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/UserCompanyFileTemplate.php');
require_once('lib/common/SubcontractDocument.php');
require_once('lib/common/FileManagerFile.php');

require_once('./modules-subcontracts-functions.php');

$db = DBI::getInstance($database);

$message = Message::getInstance();
/* @var $message Message */
$message->reset();

$db = DBI::getInstance($database);


// SESSION VARIABLES
/* @var $session Session */
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$project_name = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$userRole = $session->getUserRole();

// Set permission variables
require_once('app/models/permission_mdl.php');
$userCanManageTemplates = checkPermissionForAllModuleAndRole($database,'subcontract_templates_manage');
$userCanViewTemplates = checkPermissionForAllModuleAndRole($database,'subcontract_templates_view');


if($userRole =="global_admin")
{
	$userCanManageTemplates=$userCanViewTemplates=1;
}

/*
$selected_bid_list_id = 0; // THIS COULD GET STORED IN THE SESSION
$selected_bid_list_name = '&nbsp;';
*/

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link rel="stylesheet" href="/css/modules-subcontracts.css">
<style>
	.noGreen .evenRow:hover{
		background-color: white;
	}
	 .noGreen .oddRow:hover{
		background-color: #efefef;
	}
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
	<script src="/js/generated/subcontract_item_templates-js.js"></script>
	<script src="/js/generated/subcontract_templates-js.js"></script>
	<script src="/js/generated/subcontract_templates_to_subcontract_item_templates-js.js"></script>

	<script src="/js/modules-subcontracts.js"></script>
END_HTML_JAVASCRIPT_BODY;

require('template-assignments/main.php');

//ob_start();

// Create the "View Permissions" button

$viewModulePermissions = '';
if ($userCanManageTemplates) {
	//$viewModulePermissions = '<a href="javascript:loadPermissionModal(\'15_Y\', \''.$currentlySelectedProjectId.'\');" style="margin-right:10px;">Contract Permissions</a>';
}
	//clone default template for current project if it has no templates created yet
	$res=cloneDefaultTemplateForcurrentProject($database,$user_company_id);

	$subcontractTemplatesWithSubcontractTemplateItemsTable = loadSubcontractTemplatesWithSubcontractTemplateItems($database, $user_company_id,$currentlyActiveContactId);
	$subcontractItemTemplatesTable = loadSubcontractItemTemplates($database, $user_company_id, $currentlySelectedProjectId,$currentlyActiveContactId);

	//Fulcrum global admin
	$config = Zend_Registry::get('config');
	$fulcrum_user = $config->system->fulcrum_user;
	$companyQuery = "SELECT email FROM users where primary_contact_id='$currentlyActiveContactId'  limit 1 ";
	$db->execute($companyQuery);
	$row = $db->fetch();
	$user_email=$row['email'];
	$db->free_result();
	if($user_email == $fulcrum_user)
	{
		$globalAccess="1";
	}else
	{
		$globalAccess="0";
	}

$GlobalFulcrumItemTemplatesTable = loadSubcontractItemTemplates($database, 1, $currentlySelectedProjectId,$currentlyActiveContactId,$globalAccess);

if ($userCanManageTemplates || $userCanViewTemplates || $userRole =="global_admin") {

$htmlContent = <<<END_HTML_CONTENT

<div style="margin-bottom:15px">
	<input type="button" value="Create New Subcontract Template" onclick="Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Template(this, event);">
</div>
$subcontractTemplatesWithSubcontractTemplateItemsTable
<div style="margin-bottom:15px">
	<input type="button" value="Create New Subcontract Item Template" onclick="Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Item_Template(this, event);">
</div>
END_HTML_CONTENT;

if($globalAccess=="1"){

$htmlContent .= <<<END_HTML_CONTENT
<div id="divSubcontractItemTemplates">
	$GlobalFulcrumItemTemplatesTable
</div>
END_HTML_CONTENT;
}


$htmlContent .= <<<END_HTML_CONTENT
<div id="divSubcontractItemTemplates">
	$subcontractItemTemplatesTable
</div>
END_HTML_CONTENT;


$htmlContent .= <<<END_HTML_CONTENT
<div id="divPermissionModal" title="$project_name Purchasing Permissions"></div>
<div id="divModalWindow" title="">&nbsp;</div>
<div id="divModalWindow2" title="">&nbsp;</div>
<div id="uploadProgressWindow" class="uploadResult" style="display:none;">
	<h3>FILE UPLOAD PROGRESS: <input type="button" value="Close File Progress Window" onclick="document.getElementById('uploadProgressWindow').style.display='none';"></h3>
	<ul id="UL-FileList" class="qq-upload-list"></ul>
	<span id="uploadProgressErrorMessage"></span>
</div>
END_HTML_CONTENT;
}
else
{
	$errorMessage = 'Permission denied.';
    $message->enqueueError($errorMessage, $currentPhpScript);
	$htmlContent = $message->getFormattedHtmlMessages($currentPhpScript);
	
}

//$htmlContent = ob_get_clean();
$template->assign('htmlContent', $htmlContent);

//require_once('page-components/axis/footer_smarty.php');
$template->display('master-web-html5.tpl');

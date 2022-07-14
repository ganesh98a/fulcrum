<?php

/**
 * Roles permission  Module.
 */
$init['access_level'] = 'global_admin'; // anon, auth, admin, global_admin
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
require_once('../controllers/permission_cntrl.php');
require_once('../models/permission_mdl.php');

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

//The modules Should be visible For Global Admin 
if($userRole =="global_admin" || $userRole =="admin")
{
	$userCanManagePermission=1;
}

	//For fulcrum global admin
	$config = Zend_Registry::get('config');
	$fulcrum_user = $config->system->fulcrum_user;
	$db = DBI::getInstance($database);
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

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="../css/permission.css" rel="stylesheet">
<link rel="stylesheet" href="../../css/fSelect.css">

END_HTML_CSS;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}

$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="../js/rolepermission.js"></script>
<script src="../../js/permission.js"></script>
<script src="../../js/fSelect.js"></script>
<script>
	$('.demo').fSelect();
</script>

END_HTML_JAVASCRIPT_BODY;
$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Roles and Permission - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();

	
if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
} 

$perTable = SoftwaremoduleforpermissionASList($database); //All software modules
$permissiongrid = rolesAssociatedWithPermission($database,$user_company_id,$userRole); //All software modules
$allCompany =listAllCompany($database);
$roleListTable = RolesASList($database); //All Roles
$roleWithModule = SoftwaremoduleforRoleASList($database); //All software modules for roles

$alphabetarrange = roleAlphabetic($database,'N');
$roleCount = getlastroleid($database);


$innerStructure = 1;
require("../../include/template-assignments/main.php");

$template->assign('userCanManagePermission', $userCanManagePermission);
$template->assign('perTable', $perTable);
$template->assign('permissiongrid',$permissiongrid);
$template->assign('roleListTable', $roleListTable);
$template->assign('roleWithModule', $roleWithModule);
$template->assign('alphabetarrange', $alphabetarrange);
$template->assign('globalAccess', $globalAccess);
$template->assign('allCompany', $allCompany);
$template->assign('roleCount', $roleCount);

$htmlContent = $template->fetch('permsision_template.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;




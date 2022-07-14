<?php

/**
 * permission Manager  Module for admin.
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
$userManage = checkPermissionForAllModuleAndRole($database,'manage_system_permission');
$userCanViewpermission = checkPermissionForAllModuleAndRole($database,'view_system_permission');


// If No Access
if($userRole !="global_admin")
{
if (!$userCanViewpermission &&(!$userManage) || (!$userManage &&(!$userCanViewpermission) ) ) {
	$errorMessage = 'Permission denied.';
	$message->enqueueError($errorMessage, $currentPhpScript);
	
}
}
//The modules Should be visible For Global Admin 
if($userRole =="global_admin")
{
	// $userManage=1;
	$successMessage = 'Permission can be set using Global Admin Menu.';
	$message->enqueueError($successMessage, $currentPhpScript);
}


	//For fulcrum global admin
	// $config = Zend_Registry::get('config');
	// $fulcrum_user = $config->system->fulcrum_user;
	// $db = DBI::getInstance($database);
	// $companyQuery = "SELECT email FROM users where primary_contact_id='$currentlyActiveContactId'  limit 1 ";
	// $db->execute($companyQuery);
	// $row = $db->fetch();
	// $user_email=$row['email'];
	// $db->free_result();
	// if($user_email == $fulcrum_user)
	// {
	// 	$globalAccess="1";

	// }else
	// {
	//since it is doing within the admin menu 
		$globalAccess="0";
	// }

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
$htmlTitle = 'System Level Permissions - '.$currentlySelectedProjectName;
$htmlBody = '';
$dummyId = Data::generateDummyPrimaryKey();


if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
} 
$perTable = SoftwaremoduleforpermissionASList($database); //All software modules
if($userRole == 'global_admin')
{
	$permissiongrid =  rolesAssociatedWithPermission($database,$user_company_id,$userRole);
}else 
{
	$permissiongrid = rolesAssociatedWithPermissionforAdmin($database,$user_company_id,$userRole);//All software modules grid
}

$allCompany =listAllCompany($database);
$roleListTable = RolesASList($database); //All Roles
$roleWithModule = SoftwaremoduleforRoleASList($database); //All software modules for roles

$alphabetarrange = roleAlphabetic($database,'Y');
$roleCount = getlastroleid($database);

//For implement team member tab
$tab = '1';

if (isset($get) && !empty($get)) {
	if (!empty($get->tab)) {
		$tab = (string) $get->tab;
	}
}

$tabContent = '';
$teamSelected = '';
$subcontractorsSelected = '';
$biddersSelected = '';

switch ($tab) {
	case '1':		
		$teamSelected = 'activeTabGreen';
		break;
	case '2':		
		$subcontractorsSelected = 'activeTabGreen';
		break;
	case '3':		
		$biddersSelected = 'activeTabGreen';
		break;	
	default:	
		$teamSelected = 'activeTabGreen';
		$tab = '1';
		break;
}
//End of team member
$javaScriptHandler = 'teamManagement';
include('../../include/page-components/contact_search_by_contact_company_name_or_contact_name.php');
$template->assign('permissionsSearchForm', $contact_search_form_by_contact_company_name_or_contact_name_html);


$innerStructure = 1;
require("../../include/template-assignments/main.php");
$template->assign('perTable', $perTable);
$template->assign('permissiongrid',$permissiongrid);
$template->assign('roleListTable', $roleListTable);
$template->assign('roleWithModule', $roleWithModule);
$template->assign('alphabetarrange', $alphabetarrange);
$template->assign('globalAccess', $globalAccess);
$template->assign('allCompany', $allCompany);
$template->assign('userCanManagePermission', $userManage);
$template->assign('roleCount', $roleCount);

$template->assign('activeTab', $tab);
$template->assign('tabContent', $tabContent);
$template->assign('teamSelected', $teamSelected);
$template->assign('subcontractorsSelected', $subcontractorsSelected);
$template->assign('biddersSelected', $biddersSelected);
$template->assign('userRole', $userRole);


$htmlContent = $template->fetch('admin_permission_template.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');

exit;




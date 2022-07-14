<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/Api/MobileNavigation.php');
require_once('lib/common/Api/MobileNavigationMenuType.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/Contact.php');
require_once('lib/common/SoftwareModule.php');
require_once('lib/common/Role.php');
require_once('lib/common/SoftwareModuleCategory.php');
require_once('lib/common/SoftwareModuleFunction.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/UserInvitation.php');

require_once('ModulePermissionFunction.php');

if($RN_project_id == null || $RN_project_id == ''){
	$RN_project_id = $user->currentlySelectedProjectId;
}
/*get the permission for menus*/
$RN_permissions = RN_Permissions::loadPermissions($database, $user, $RN_project_id, true);
/*get the navigation count*/
$RN_arrNavigation = $RN_permissions->getArrNav();
// check the count if 0 return
if (count($RN_arrNavigation) == 0) {
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}

$footerPermission = array();
//  Get the permission of Project Management module to users
$module_navigation = 'ProjectUtilitesMenus';
$RN_PUPermission = getModuleAccessWithNavigation($database, $module_navigation, $RN_user_company_id, $RN_project_id, $RN_primary_contact_id, $RN_userRole);
$footerPermission['ProjectUtilitesMenus'] = $RN_PUPermission;
// Fetch the menu is main menu or sub menu
$module_navigation = 'FileManager';
$RN_filemanagerPermission = getModuleAccessWithNavigation($database, $module_navigation, $RN_user_company_id, $RN_project_id, $RN_primary_contact_id, $RN_userRole);
$footerPermission['FileManager'] = $RN_filemanagerPermission;
//  Get the permission of report module to users
$module_navigation = 'Reports';
$RN_reportPermission = getModuleAccessWithNavigation($database, $module_navigation, $RN_user_company_id, $RN_project_id, $RN_primary_contact_id, $RN_userRole);
$footerPermission['Reports'] = $RN_reportPermission;
// $RN_jsonEC['data']['permissions'] = array_values($RN_arrayTemp);
$RN_jsonEC['data']['footer_permission'] = $footerPermission;


?>

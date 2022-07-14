<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/Api/MobileNavigation.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/Contact.php');
require_once('lib/common/SoftwareModule.php');
require_once('lib/common/Role.php');
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

$RN_arrSoftwareModuleCategorySortOrder = $RN_permissions->getArrSoftwareModuleCategorySortOrder();
/*check & store the data's*/
$RN_projectAdminIncludedFlag = false;
$RN_arrayTemp = array();
foreach ($RN_arrSoftwareModuleCategorySortOrder as $RN_software_module_category_id => $RN_software_module_category_sort_order) {
	// print_r($RN_arrNavigation[$RN_software_module_category_id]);
	// Not all permissions may be set in the Menu/Navigation
	if (!isset($RN_arrNavigation[$RN_software_module_category_id]['name'])) {
		continue;
	}
	$RN_software_module_category_label = $RN_arrNavigation[$RN_software_module_category_id]['name'];
	$RN_mobile_navigation_id = $RN_arrNavigation[$RN_software_module_category_id]['mobile_navigation_id'];
	
	$RN_software_module_category = $RN_arrNavigation[$RN_software_module_category_id]['software_module_category'];
	if($RN_version== null && ($RN_software_module_category == 'file_manager' || $RN_software_module_category == 'Dashboard')) {
		continue;
	}
	$module_nav = '';
	$module_icon = '';
	$module_available = false;
	if ($RN_mobile_navigation_id != '' && $RN_mobile_navigation_id != NULL) {
		$mobileNavigation = MobileNavigation::findById($database, $RN_mobile_navigation_id);
		if (!empty($mobileNavigation) && isset($mobileNavigation)) {
			$module_nav = $mobileNavigation->module_navigation;
			$module_icon = $mobileNavigation->module_icon;
			if ($mobileNavigation->module_is_available == 'Y') {
				$module_available = true;
			}
		}
	}
	switch($RN_software_module_category){
		case 'Dashboard':
		case 'global_admin':
		case 'file_manager':
		case 'ad_hoc':
		case 'admin':
		case 'user_account_personal_profile':
		$image = $module_icon;
		$nav = $module_nav;
		break;
		case 'project_management':
		$image = 'project_Utilites_icon';
		// To prevent the issue with old build version of mobile
		switch ($RN_version) {
		case 'v1':
			$RN_software_module_category_label = 'Project Utilities';
			break;
		case 'v1.1':
			$RN_software_module_category_label = $RN_software_module_category_label;
			break;
		default:
			$RN_software_module_category_label = 'Project Utilities';
			break;
		}	
		$nav = $module_nav;
		break;
		case 'reporting':
		$image = 'reports_icon';
		// To prevent the issue with old build version of mobile
		switch ($RN_version) {
		case 'v1':
			$RN_software_module_category_label = 'Reports';
			break;
		case 'v1.1':
			$RN_software_module_category_label = $RN_software_module_category_label;
			break;
		default:
			$RN_software_module_category_label = 'Reports';
			break;
		}
		$nav = $module_nav;
		break;
		default:
		$image = $module_icon;
		$nav = $module_nav;
		break;
	}
	// check modules count
	$countModules = 1;
	if($RN_arrNavigation[$RN_software_module_category_id] && $RN_arrNavigation[$RN_software_module_category_id]['modules']) {
		$countModules = count($RN_arrNavigation[$RN_software_module_category_id]['modules']);
	}
	$redirectToSubMenu = false;

	$access = true;	

	if($countModules > 1) {
		$redirectToSubMenu = true;
	} else {
		$module = array_values($RN_arrNavigation[$RN_software_module_category_id]['modules']);
		$RN_module_mobile_navigation_id = '';
		if(isset($module) && !empty($module)) {
			$RN_module_mobile_navigation_id = $module[0]['mobile_navigation_id'];	
		}
		if($RN_module_mobile_navigation_id != $RN_mobile_navigation_id) {
			$redirectToSubMenu = true;
			if ($RN_module_mobile_navigation_id != '' && $RN_module_mobile_navigation_id != NULL) {
				$mobileModuleNavigation = MobileNavigation::findById($database, $RN_module_mobile_navigation_id);
				if (!empty($mobileModuleNavigation) && isset($mobileModuleNavigation)) {
					$module_nav = $mobileModuleNavigation->module_navigation;
					$module_icon = $mobileModuleNavigation->module_icon;
					if ($mobileModuleNavigation->module_is_available == 'Y') {
						$module_available = true;
					}
				}
			}
		}
	}
	//  Get the permission of Project Management module to users
	$project_specific_flag = 'N';

	$access = RN_permissions::checkSoftwareModuleCategoryPrePermission($database, $RN_user_company_id, $RN_software_module_category, $RN_project_id, $RN_primary_contact_id, $project_specific_flag, $RN_userRole);

	if($RN_project_id == 1 && $countModules < 2) {
		$access = false;
	}

	// $RN_PUPermission = getModuleAccessWithNavigation($database, $module_navigation, $RN_user_company_id, $RN_project_id, $RN_primary_contact_id, $RN_userRole);

	$RN_arrayTemp[$RN_software_module_category_id]['software_module_category_label'] = $RN_software_module_category_label;
	$RN_arrayTemp[$RN_software_module_category_id]['software_module_category'] = $RN_software_module_category;
	$RN_arrayTemp[$RN_software_module_category_id]['software_module_category_id'] = $RN_software_module_category_id;
	$RN_arrayTemp[$RN_software_module_category_id]['icon'] = $image;
	$RN_arrayTemp[$RN_software_module_category_id]['nav'] = $nav;
	$RN_arrayTemp[$RN_software_module_category_id]['module_is_available'] = $module_available;
	$RN_arrayTemp[$RN_software_module_category_id]['access'] = $access;
	$RN_arrayTemp[$RN_software_module_category_id]['redirect_to_sub_menu'] = $redirectToSubMenu;
}
// custom menu dashboard - Task Summery
$RN_softwareModuleCategoryId = '';
$RN_softwareModuleId = '';
$RN_softwareModuleFunctionId = '';
// software module
$RN_softwareModuleName = 'Dashboard';
$db = DBI::getInstance($database);
$db->free_result();
$RN_arrayTempEx = array();
$RN_softwareModule = SoftwareModule::findBySoftwareModule($database, $RN_softwareModuleName);
if (isset($RN_softwareModule)) {
	$RN_softwareModuleCategoryId = $RN_softwareModule->software_module_category_id;
	$RN_softwareModuleId = $RN_softwareModule->software_module_id;
	// software module function 
	$db->free_result();
	$RN_softwareModuleFunctionName = 'view_task_summary';
	$RN_softwareModuleFunction = SoftwareModuleFunction::findBySoftwareModuleIdAndSoftwareModuleFunction($database, $RN_softwareModuleId, $RN_softwareModuleFunctionName);
	if (isset($RN_softwareModuleFunction)) {
		$RN_softwareModuleFunctionId = $RN_softwareModuleFunction->software_module_function_id;
	}
	// check permission
	$db->free_result();
	$RN_Permissions = new RN_Permissions();
	$RN_task_summery_permission = $RN_Permissions->checkDelayPermission($database, $RN_softwareModuleFunctionName, $user, $RN_softwareModuleFunctionId, $RN_softwareModuleId, $RN_project_id);	
	// check the reole if bidder or subcontract restrict the permission
	$RN_currentlyActiveContactId = $user->currentlyActiveContactId;
	$RN_checkRestriction = RN_Permissions::checkProjectManagerORBidder($database, $RN_project_id, $RN_currentlyActiveContactId);

	if($RN_task_summery_permission && (isset($RN_checkRestriction) && !$RN_checkRestriction['bidder_subcontract'])) {
		$RN_arrayTempEx['software_module_category_label'] = 'Task Summary';
		$RN_arrayTempEx['software_module_category_id'] = $RN_softwareModuleCategoryId;
		$RN_arrayTempEx['module_is_available'] = true;
		$RN_arrayTempEx['icon'] = 'dashboard_icon';
		$RN_arrayTempEx['nav'] = 'TaskSummary';
		$RN_arrayTempEx['access'] = true;
	} else {
		$RN_task_summery_permission = false;
	}
}
if (isset($RN_arrayTempEx) && !empty($RN_arrayTempEx)) {
	array_unshift($RN_arrayTemp, $RN_arrayTempEx);
}
$RN_jsonEC['data']['permissions'] = array_values($RN_arrayTemp);
$RN_jsonEC['data']['impersonate_data'] = array();
?>

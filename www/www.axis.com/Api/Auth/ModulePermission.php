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
require_once('lib/common/ActionItemAssignment.php');

/*get the permission for menus*/
$RN_permissions = RN_Permissions::loadPermissions($database, $user, $RN_project_id, true);
/*get the navigation count*/
$RN_arrNavigation = $RN_permissions->getArrNav();

$RN_getArrSoftwareModuleFunctionsByFunction = $RN_permissions->getArrSoftwareModuleFunctionsByFunction();

$RN_getArrPermissions = $RN_permissions->getArrPermissions();
// check the count if 0 return
if (count($RN_arrNavigation) == 0) {
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}

$RN_arrSoftwareModuleCategorySortOrder = $RN_permissions->getArrSoftwareModuleCategorySortOrder();

$RN_getArrSoftwareModuleFunctionsByFunction = $RN_permissions->getArrSoftwareModuleFunctionsByFunction();

/*check & store the data's*/
$RN_projectAdminIncludedFlag = false;
$RN_arrayTemp = array();
foreach ($RN_arrSoftwareModuleCategorySortOrder as $RN_software_module_category_id => $RN_software_module_category_sort_order) {
	$RN_notify_flag = false;
	$RN_red_notify_flag = false;
	// Not all permissions may be set in the Menu/Navigation
	if (!isset($RN_arrNavigation[$RN_software_module_category_id]['name'])) {
		continue;
	}
	if($RN_GetSoftware_Module_Category_id != $RN_software_module_category_id){
		continue;
	}

	$RN_mobile_navigation_id = $RN_arrNavigation[$RN_software_module_category_id]['mobile_navigation_id'];

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

	$RN_software_module_category_label = $RN_arrNavigation[$RN_software_module_category_id]['name'];
	$RN_software_module_category = $RN_arrNavigation[$RN_software_module_category_id]['software_module_category'];
	$RN_arrayTemp[$RN_software_module_category_id]['software_module_category_label'] = $RN_software_module_category_label;
	$RN_arrayTemp[$RN_software_module_category_id]['software_module_category'] = $RN_software_module_category;	
	$RN_arrayTemp[$RN_software_module_category_id]['software_module_category_id'] = $RN_software_module_category_id;
	$RN_arrayTemp[$RN_software_module_category_id]['icon'] = $module_icon;
	$RN_arrayTemp[$RN_software_module_category_id]['nav'] = $module_nav;
	$RN_arrayTemp[$RN_software_module_category_id]['module_is_available'] = $module_available;
	$RN_arrayTemp[$RN_software_module_category_id]['access'] = true;

	$RN_arrSoftwareModules = $RN_arrNavigation[$RN_software_module_category_id]['modules'];
	//echo $arrSoftwareModules;  //array
	$RN_softwareModulesCount = count($RN_arrSoftwareModules);
	//echo $softwareModulesCount;// 7 1 2 7
	foreach ($RN_arrSoftwareModules AS $RN_software_module_id => $RN_arrSoftwareModule) {
		$RN_notify_flag = false;
		$RN_red_notify_flag = false;
		$RN_software_module_label = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['name'];
		$RN_software_module = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['software_module'];

		$RN_su_mobile_navigation_id = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['mobile_navigation_id'];

		$su_module_nav = '';
		$su_module_icon = '';
		$su_module_available = false;
		if ($RN_su_mobile_navigation_id != '' && $RN_su_mobile_navigation_id != NULL) {
			$su_mobileNavigation = MobileNavigation::findById($database, $RN_su_mobile_navigation_id);
			if (!empty($su_mobileNavigation) && isset($su_mobileNavigation)) {
				$su_module_nav = $su_mobileNavigation->module_navigation;
				$su_module_icon = $su_mobileNavigation->module_icon;
				if ($su_mobileNavigation->module_is_available == 'Y') {
					$su_module_available = true;
				}
			}
		}

		// Skip Create A New Project if Projects Admin is a vailable
		if ($RN_software_module == 'projects_admin') {
			$RN_projectAdminIncludedFlag = true;
		}
		if ($RN_projectAdminIncludedFlag) {
			if ($RN_software_module == 'projects_creation_admin') {
				continue;
			}
		}
		// We can't just get the function keys because some functions might not be tagged to display in the navigation
		// Therefore we need to loop through the function keys and see if it is set to display in the navigation
		// and then build the $arrSoftwareModuleFunctionIds array manually.
		$RN_arrSoftwareModuleFunctionIdsTmp = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'];
		$RN_arrSoftwareModuleFunctionIds = array();
		foreach ($RN_arrSoftwareModuleFunctionIdsTmp AS $RN_software_module_function_id => $RN_arrSoftwareModuleFunction) {
			$RN_show_in_navigation_flag = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['show'];
			if ($RN_show_in_navigation_flag == 'Y') {
				$RN_arrSoftwareModuleFunctionIds[] = $RN_software_module_function_id;
			}
		}
		$RN_softwareModuleFunctionIdsCount = count($RN_arrSoftwareModuleFunctionIds);
		// echo $RN_software_module_label.' - '.$RN_softwareModuleFunctionIdsCount.'<br>';
		$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_id'] = $RN_software_module_id;
		$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module'] = $RN_software_module;
		$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['icon'] = $su_module_icon;
		$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['module_is_available'] = $su_module_available;
		$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['nav'] = $su_module_nav;
		if ($RN_softwareModuleFunctionIdsCount > 1) {
			if ($RN_softwareModulesCount > 1) {
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_label;
			}
			$RN_software_module_function_navigation_label = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['label'];
			$RN_default_software_module_function_url = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['path'];
			/*software module id*/
			switch ($RN_version) {
				case 'v1':
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_function_navigation_label;
				break;
				case 'v1.1':
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_label;	
				break;
				default:
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_function_navigation_label;
				break;
			}
			
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_function_label'] = null;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_function_id'] = null;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = false;

			foreach ($RN_arrSoftwareModuleFunctionIds AS $RN_Function_id ) {
				/*software module function id*/
				$RN_Function_name = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_Function_id]['name'];
				if (strpos($RN_Function_name, 'delay') !== false || strpos($RN_Function_name, 'transmittal') !== false) {
					$checkAccesslvl = $RN_permissions->checkDelayPermission($database, $RN_Function_name, $user, $RN_Function_id, $RN_software_module_id, $RN_project_id);
				}else{
					if (isset($RN_getArrSoftwareModuleFunctionsByFunction[$RN_Function_name])) {
						$checkAccesslvl = true;
					} else {
						$checkAccesslvl = false;
					}
				}
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['software_module_function_id'] = $RN_Function_id;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['software_module_function'] = $RN_Function_name;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['access'] = $checkAccesslvl;

				if($checkAccesslvl){
					$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = true;
				}
			}
		}elseif ($RN_softwareModuleFunctionIdsCount == 1) {
			$RN_software_module_function_navigation_label = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['label'];
			$RN_default_software_module_function_url = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['path'];
			/*software module id*/
			switch ($RN_version) {
				case 'v1':
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_function_navigation_label;
				break;
				case 'v1.1':
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_label;	
				break;
				default:
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_function_navigation_label;
				break;
			}

			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_function_label'] = null;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_function_id'] = null;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = false;
			/*$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'] = $RN_getArrPermissions[$RN_software_module_category_id][$RN_software_module_id];*/
			foreach($RN_getArrPermissions[$RN_software_module_category_id][$RN_software_module_id] as $RN_Function_id => $RN_Function_name){
				if (strpos($RN_Function_name, 'delay') !== false || strpos($RN_Function_name, 'transmittal') !== false) {
					$checkAccesslvl = $RN_permissions->checkDelayPermission($database, $RN_Function_name, $user, $RN_Function_id, $RN_software_module_id, $RN_project_id);
				}else{
					if (isset($RN_getArrSoftwareModuleFunctionsByFunction[$RN_Function_name])) {
						$checkAccesslvl = true;
					} else {
						$checkAccesslvl = false;
					}
				}
				if($checkAccesslvl){
					$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = true;
				}
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['software_module_function_id'] = $RN_Function_id;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['software_module_function'] = $RN_Function_name;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['access'] = $checkAccesslvl;
			}
		}else{
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_label;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_function_label'] = null;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_function_id'] = null;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = false;
			foreach($RN_getArrPermissions[$RN_software_module_category_id][$RN_software_module_id] as $RN_Function_id => $RN_Function_name){
				if (strpos($RN_Function_name, 'delay') !== false || strpos($RN_Function_name, 'transmittal') !== false) {
					$checkAccesslvl = $RN_permissions->checkDelayPermission($database, $RN_Function_name, $user, $RN_Function_id, $RN_software_module_id, $RN_project_id);
				}else{
					if (isset($RN_getArrSoftwareModuleFunctionsByFunction[$RN_Function_name])) {
						$checkAccesslvl = true;
					} else {
						$checkAccesslvl = false;
					}
				}
				if($checkAccesslvl){
					$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = true;
				}
				// $RN_index++;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['software_module_function_id'] = $RN_Function_id;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['software_module_function'] = $RN_Function_name;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['access'] = $checkAccesslvl;

			}
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'] = ($RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions']);
		}
		// check the permission view if not unset
		$userCanViewPage = true;
		if($RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module'] == 'jobsite_daily_logs'){
			$userCanViewPage = $RN_permissions->determineAccessToSoftwareModuleFunction('jobsite_daily_logs_view');
		}
		// Submittal
		if($RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module'] == 'submittals'){
			$userCanViewPage = $RN_permissions->determineAccessToSoftwareModuleFunction('submittals_view');
		}
		// Meetings
		if($RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module'] == 'meetings'){
			$userCanViewPage = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_view');
			$actionItemAssignment = new ActionItemAssignment($database);
			$RN_Notify = $actionItemAssignment->findByActionItemUsingContactIdApi($database, $RN_currentlyActiveContactId, $RN_project_id);
			$RN_notify_flag = $RN_Notify['notify'];
			$RN_red_notify_flag = $RN_Notify['red_notify'];
		}
		// Budget
		if($RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module'] == 'gc_budgets'){
			$userCanViewPage = $RN_permissions->determineAccessToSoftwareModuleFunction('gc_budgets_view');
		}
		if(!$userCanViewPage){
			// array_slice($RN_arrayTemp[$RN_software_module_category_id]['sub_menu'], $RN_software_module_id);
			// unset($RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]);
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = false;
		}
		if ($RN_project_id == 1) {
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = false;
		}
		// Notify flag
		$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['notify'] = $RN_notify_flag;
		$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['red_notify'] = $RN_red_notify_flag;
	}

	$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'] = array_values($RN_arrayTemp[$RN_software_module_category_id]['sub_menu']);
}
$RN_jsonEC['data']['permissions'] = ($RN_arrayTemp);
$RN_jsonEC['data']['impersonate_data'] = array();
?>

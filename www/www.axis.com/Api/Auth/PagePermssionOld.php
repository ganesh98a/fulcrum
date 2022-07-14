<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/Contact.php');
require_once('lib/common/SoftwareModule.php');
require_once('lib/common/Role.php');
require_once('lib/common/SoftwareModuleFunction.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/UserInvitation.php');

/*get the permission for menus*/
$RN_permissions = RN_Permissions::loadPermissions($database, $user);
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
	// Not all permissions may be set in the Menu/Navigation
	if (!isset($RN_arrNavigation[$RN_software_module_category_id]['name'])) {
		continue;
	}
	if($RN_GetSoftware_Module_Category_id != $RN_software_module_category_id){
		continue;
	}

	$RN_software_module_category_label = $RN_arrNavigation[$RN_software_module_category_id]['name'];
	$RN_arrayTemp[$RN_software_module_category_id]['software_module_category_label'] = $RN_software_module_category_label;
	$RN_arrayTemp[$RN_software_module_category_id]['software_module_category_id'] = $RN_software_module_category_id;
	$RN_arrayTemp[$RN_software_module_category_id]['access'] = true;

	$RN_arrSoftwareModules = $RN_arrNavigation[$RN_software_module_category_id]['modules'];
	//echo $arrSoftwareModules;  //array
	$RN_softwareModulesCount = count($RN_arrSoftwareModules);
	//echo $softwareModulesCount;// 7 1 2 7
	foreach ($RN_arrSoftwareModules AS $RN_software_module_id => $RN_arrSoftwareModule) {

		if($RN_GetSoftware_Module_id != $RN_software_module_id){
			continue;
		}

		$RN_software_module_label = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['name'];
		// Skip Create A New Project if Projects Admin is a vailable
		if ($RN_software_module_label == 'Projects Admin') {
			$RN_projectAdminIncludedFlag = true;
		}
		if ($RN_projectAdminIncludedFlag) {
			if ($RN_software_module_label == 'Create A New Project') {
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
		if ($RN_softwareModuleFunctionIdsCount > 1) {
			if ($RN_softwareModulesCount > 1) {
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_label;
			}
			foreach ($RN_arrSoftwareModuleFunctionIds AS $RN_software_module_function_id) {
				$RN_software_module_function_navigation_label = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['label'];
				$RN_default_software_module_function_url = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['path'];
				$RN_software_module_function_navigation_label;
				/*software module function id*/
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_function_id]['software_module_function_label'] = $RN_software_module_function_navigation_label;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_function_id]['software_module_function_id'] = $RN_software_module_function_id;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_function_id]['software_module_id'] = $RN_software_module_id;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_function_id]['software_module_label'] = null;

				$RN_Function_name = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['name'];
				if (strpos($RN_Function_name, 'delay') !== false || strpos($RN_Function_name, 'transmittal') !== false) {
					$checkAccesslvl = RN_Permissions::checkDelayPermission($RN_Function_name, $user, $RN_software_module_function_id, $RN_software_module_id);
				}else{
					if (isset($RN_getArrSoftwareModuleFunctionsByFunction[$RN_Function_name])) {
						$checkAccesslvl = true;
					} else {
						$checkAccesslvl = false;
					}
				}
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_function_id]['access'] = $checkAccesslvl;
			}
		}elseif ($softwareModuleFunctionIdsCount == 1) {
			$RN_software_module_function_navigation_label = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['label'];
			$RN_default_software_module_function_url = $RN_arrNavigation[$RN_software_module_category_id]['modules'][$RN_software_module_id]['functions'][$RN_software_module_function_id]['path'];
			/*software module id*/
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_label'] = $RN_software_module_function_navigation_label;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_function_label'] = null;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['software_module_function_id'] = null;
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['access'] = false;
			/*$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'] = $RN_getArrPermissions[$RN_software_module_category_id][$RN_software_module_id];*/
			foreach($RN_getArrPermissions[$RN_software_module_category_id][$RN_software_module_id] as $RN_Function_id => $RN_Function_name){
				if (strpos($RN_Function_name, 'delay') !== false || strpos($RN_Function_name, 'transmittal') !== false) {
					$checkAccesslvl = RN_Permissions::checkDelayPermission($RN_Function_name, $user, $RN_Function_id, $RN_software_module_id);
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
					$checkAccesslvl = RN_Permissions::checkDelayPermission($RN_Function_name, $user, $RN_Function_id, $RN_software_module_id);
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
				$RN_index++;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['software_module_function_id'] = $RN_Function_id;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['software_module_function'] = $RN_Function_name;
				$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'][$RN_Function_id]['access'] = $checkAccesslvl;

			}
			$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions'] = ($RN_arrayTemp[$RN_software_module_category_id]['sub_menu'][$RN_software_module_id]['functions']);
		}		
		
	}
	$RN_arrayTemp[$RN_software_module_category_id]['sub_menu'] = array_values($RN_arrayTemp[$RN_software_module_category_id]['sub_menu']);
}
$RN_jsonEC['data']['permissions'] = ($RN_arrayTemp);
?>
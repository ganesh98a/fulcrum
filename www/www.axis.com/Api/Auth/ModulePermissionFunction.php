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
require_once('lib/common/Api/MobileNavigation.php');
require_once('lib/common/Api/MobileNavigationMenuType.php');
require_once('lib/common/SoftwareModuleCategory.php');

/*get the permission for menus*/
function checkPermission($database, $user, $RN_project_id, $RN_GetSoftware_Module_id) {
    $RN_permissions = RN_Permissions::loadPermissions($database, $user, $RN_project_id);

    $RN_arrayTemp = array();
    $RN_softwareModule = RN_Permissions::loadSoftwareModuleByIds($database, $RN_GetSoftware_Module_id);
    if($RN_softwareModule['software_module'] == 'jobsite_daily_logs'){
        $RN_userCanViewJobsiteDailyLog = $RN_permissions->determineAccessToSoftwareModuleFunction('jobsite_daily_logs_view');
        $RN_userCanManageJobsiteDailyLog = $RN_permissions->determineAccessToSoftwareModuleFunction('jobsite_daily_logs_manage');
        $RN_userCanManageJobsiteDailyLogAdmin = $RN_permissions->determineAccessToSoftwareModuleFunction('jobsite_daily_logs_admin_manage');
        $RN_userCanGenerateDCR = $RN_permissions->determineAccessToSoftwareModuleFunction('daily_construction_report');

        $RN_arrayTemp['jobsite_daily_logs_view'] = $RN_userCanViewJobsiteDailyLog;
        $RN_arrayTemp['jobsite_daily_logs_manage'] = $RN_userCanManageJobsiteDailyLog;
        $RN_arrayTemp['jobsite_daily_logs_admin_manage'] = $RN_userCanManageJobsiteDailyLogAdmin;
        $RN_arrayTemp['daily_construction_report'] = $RN_userCanGenerateDCR;
    }
    if($RN_softwareModule['software_module'] == 'submittals'){
        $RN_userCanViewSubmittals = $RN_permissions->determineAccessToSoftwareModuleFunction('submittals_view');
        $RN_userCanManageSubmittals = $RN_permissions->determineAccessToSoftwareModuleFunction('submittals_manage');
        $RN_userCanAnswerSubmittals = $RN_permissions->determineAccessToSoftwareModuleFunction('submittals_respond');

        $RN_arrayTemp['submittals_view'] = $RN_userCanViewSubmittals;
        $RN_arrayTemp['submittals_manage'] = $RN_userCanManageSubmittals;
        $RN_arrayTemp['submittals_respond'] = $RN_userCanAnswerSubmittals;
    }
    if($RN_softwareModule['software_module'] == 'rfis'){
        $RN_userCanViewRFIs = $RN_permissions->determineAccessToSoftwareModuleFunction('rfis_view');
        $RN_userCanManageRFIs = $RN_permissions->determineAccessToSoftwareModuleFunction('rfis_manage');
        $RN_userCanAnswerRFIs = $RN_permissions->determineAccessToSoftwareModuleFunction('rfis_respond_to_question');

        $RN_arrayTemp['rfis_view'] = $RN_userCanViewRFIs;
        $RN_arrayTemp['rfis_manage'] = $RN_userCanManageRFIs;
        $RN_arrayTemp['rfis_respond_to_question'] = $RN_userCanAnswerRFIs;
    }
    if($RN_softwareModule['software_module'] == 'meetings'){
        $RN_userCanViewDiscussionItems = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_view');
        $RN_userCanCreateDiscussionItems = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_add_discussion_item');
        $RN_userCanCreateActionItems = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_add_action_item');
        $RN_userCanCreateDiscussionItemComments = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_add_comment');
        $RN_userCanManageMeetings = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_manage');

        $RN_arrayTemp['meetings_view'] = $RN_userCanViewDiscussionItems;
        $RN_arrayTemp['meetings_add_discussion_item'] = $RN_userCanCreateDiscussionItems;
        $RN_arrayTemp['meetings_add_action_item'] = $RN_userCanCreateActionItems;
        $RN_arrayTemp['meetings_add_comment'] = $RN_userCanCreateDiscussionItemComments;
        $RN_arrayTemp['meetings_manage'] = $RN_userCanManageMeetings;
    }
    if($RN_softwareModule['software_module'] == 'gc_budgets'){
        $RN_gc_budgets_view = $RN_permissions->determineAccessToSoftwareModuleFunction('gc_budgets_view');
        $RN_gc_budgets_manage = $RN_permissions->determineAccessToSoftwareModuleFunction('gc_budgets_manage');
        $RN_gc_budgets_import_line_items = $RN_permissions->determineAccessToSoftwareModuleFunction('gc_budgets_import_line_items');

        $RN_arrayTemp['gc_budgets_view'] = $RN_gc_budgets_view;
        $RN_arrayTemp['gc_budgets_manage'] = $RN_gc_budgets_manage;
        $RN_arrayTemp['gc_budgets_import_line_items'] = $RN_gc_budgets_import_line_items;
    }
    if($RN_softwareModule['software_module'] == 'punch_list'){
        $db = DBI::getInstance($database);
        // print_r($RN_softwareModule->getArrSoftwareModuleFunctions());
        $RN_GetSoftwareModuleId = $RN_softwareModule['id'];
        $query =
        "
        SELECT smf.`id` AS software_module_function_id, smf.`software_module_function`, smf.`software_module_function_label`,
        smf.`software_module_function_navigation_label`, smf.`default_software_module_function_url`,
        smf.`show_in_navigation_flag`, smf.`global_admin_only_flag`,
        sm.`id` AS software_module_id, sm.`software_module`, sm.`software_module_label`, sm.`default_software_module_url`,
        smc.`id` AS software_module_category_id, smc.`software_module_category`, smc.`software_module_category_label`, smc.`sort_order` AS software_module_category_sort_order
        FROM `software_module_functions` smf, `software_modules` sm, `software_module_categories` smc
        WHERE smf.`software_module_id` = sm.`id`
        AND sm.`software_module_category_id` = smc.`id`
        AND smf.`software_module_id` IN ($RN_GetSoftwareModuleId)
        ORDER BY smc.`sort_order` ASC, sm.`sort_order` ASC, smf.`sort_order` ASC
        ";
                //"GROUP BY smf.`software_module_function_navigation_label`";
        $db->query($query);
        $arrSoftwareModuleFunctionsGroupedByNavigationLabel = array();
        while ($row = $db->fetch()) {
            // print_r($row);
            $arrSoftwareModuleFunctionsGroupedByNavigationLabel[] = $row;
        }

        foreach($arrSoftwareModuleFunctionsGroupedByNavigationLabel as $key => $row){
            $RN_Function_id = $row['software_module_function_id'];
            $RN_Function_name = $row['software_module_function'];
            $RN_punch_list_permission = RN_Permissions::checkDelayPermission($database, $RN_Function_name, $user, $RN_Function_id, $RN_GetSoftwareModuleId, $RN_project_id);

            $RN_arrayTemp[$RN_Function_name] = $RN_punch_list_permission;
        }	
    }
    if($RN_softwareModule['software_module'] == 'Dashboard') {
        
        $RN_softwareModuleId = $RN_softwareModule['id'];
        // software module function
        $RN_softwareModuleFunctionName = 'view_task_summary';
        $RN_softwareModuleFunction = SoftwareModuleFunction::findBySoftwareModuleIdAndSoftwareModuleFunction($database, $RN_softwareModuleId, $RN_softwareModuleFunctionName);
        if (isset($RN_softwareModuleFunction)) {
            $RN_softwareModuleFunctionId = $RN_softwareModuleFunction->software_module_function_id;
            $RN_Function_id = $RN_softwareModuleFunction->software_module_function_id;
            $RN_Function_name = $RN_softwareModuleFunction->software_module_function;
        }

        $RN_task_summery_permission = RN_Permissions::checkDelayPermission($database, $RN_Function_name, $user, $RN_Function_id, $RN_softwareModuleId, $RN_project_id);	
        // check the reole if bidder or subcontract restrict the permission
        $RN_currentlyActiveContactId = $user->currentlyActiveContactId;
        $RN_checkRestriction = RN_Permissions::checkProjectManagerORBidder($database, $RN_project_id, $RN_currentlyActiveContactId);
        if($RN_task_summery_permission && isset($RN_checkRestriction) && !$RN_checkRestriction['bidder_subcontract']) {
            $RN_task_summery_permission = true;
        } else {
            $RN_task_summery_permission = false;
        }
        $RN_arrayTemp[$RN_softwareModuleFunctionName] = $RN_task_summery_permission;
    }
return ($RN_arrayTemp);
}
/*
* Get the user have permission or not
*/
function getModuleAccessWithNavigation($database, $module_navigation, $RN_user_company_id, $RN_project_id, $RN_primary_contact_id, $RN_userRole) {
    $mobileNavigation = MobileNavigation::findByModuleNavigation($database, $module_navigation);
    if ($mobileNavigation !== null) {
        $RN_mobile_navigation_id = $mobileNavigation->id;
        $menu_type_id = $mobileNavigation->menu_type;
        $module_nav = $mobileNavigation->module_navigation;
        $module_icon = $mobileNavigation->module_icon;
        $module_is_available = $mobileNavigation->module_is_available;
        if ($mobileNavigation->module_is_available == 'Y') {
            $module_is_available = true;
        }
        $menu_type = '';
        $RN_permissionModule = false;
        if($menu_type_id != '') {
            $menuType = MobileNavigationMenuType::findById($database, $menu_type_id);
            
            if(!empty($menuType)) {
                $menu_type = $menuType->menu_type;
            }       
        }
        $redirectToSubMenu = false;
        $module_id = '';
        $module_label = '';
        $module_unique = '';
        //  check the permission based on menu type
        if ($menu_type == 'main_menu') {
            $software_module_category = $mobileNavigation->software_module_category;
            // get detail of software_module_category
            $getSoftwareModuleCategory = SoftwareModuleCategory::findBySoftwareModuleCategory($database, $software_module_category);
            if (!empty($getSoftwareModuleCategory)) {
                $module_id = $getSoftwareModuleCategory->software_module_category_id;
                $module_label = $getSoftwareModuleCategory->software_module_category_label;
                $module_unique = $software_module_category;
            }
            //  Get the permission of file_manager module to users with project non specific
            $project_specific_flag = 'N';
            $RN_permissionModule = false;
            if ($software_module_category != '' && $software_module_category != NULL) {
                $RN_permissionModule = RN_permissions::checkSoftwareModuleCategoryPrePermission($database, $RN_user_company_id, $software_module_category, $RN_project_id, $RN_primary_contact_id, $project_specific_flag, $RN_userRole);
            }
            $countModules = RN_Permissions::checkSoftwareModuleCount($database, $software_module_category);
            // check if main menu redirect to submenu
            if($countModules > 1) {
                $redirectToSubMenu = true;
            } else {
                $RN_module_mobile_navigation_id = RN_Permissions::getSoftwareModuleByCategory($database, $software_module_category);                
                if( $RN_module_mobile_navigation_id != '' && ($RN_module_mobile_navigation_id != $RN_mobile_navigation_id)) {
                    $redirectToSubMenu = true;
                    if ($RN_module_mobile_navigation_id != '' && $RN_module_mobile_navigation_id != NULL) {
                        $mobileModuleNavigation = MobileNavigation::findById($database, $RN_module_mobile_navigation_id);
                        if (!empty($mobileModuleNavigation) && isset($mobileModuleNavigation)) {
                            $module_nav = $mobileModuleNavigation->module_navigation;
                            $module_icon = $mobileModuleNavigation->module_icon;
                            if ($mobileModuleNavigation->module_is_available == 'Y') {
                                $module_is_available = true;
                            }
                        }
                    }
                }
            }
            if($RN_project_id == 1 && $countModules < 2) {
                $RN_permissionModule = false;
            }
        }
        if (!$RN_permissionModule) {
            $arrContactPermissionsMatrix = RN_Permissions::loadContactsForSoftwareModulePermissionsMatrixApi($database, $RN_user_company_id, $module_id, $RN_project_id);
            if(isset($arrContactPermissionsMatrix['admin_contact_ids']) && isset($arrContactPermissionsMatrix['admin_contact_ids'][$RN_primary_contact_id])) {
                $RN_permissionModule = true;
            }
        }

        if ($menu_type == 'sub_menu') {
            $redirectToSubMenu = false;
            $software_module = $mobileNavigation->software_module;
            // get software_module details
            $getSoftwareModule = SoftwareModule::findBySoftwareModule($database, $software_module);
            $project_specific_flag = 'Y';
            if (!empty($getSoftwareModule)) {
                $module_id = $getSoftwareModule->software_module_id;
                $module_label = $getSoftwareModule->software_module_label;
                $module_unique = $software_module;
                $project_specific_flag = $getSoftwareModule->project_specific_flag;
            }
            //  Get the permission of file_manager module to users with project specific
            $RN_permissionModule = false;
            if ($software_module != '' && $software_module != NULL) {
                $RN_permissionModule = RN_permissions::checkSoftwareModulePrePermission($database, $RN_user_company_id, $software_module, $RN_project_id, $RN_primary_contact_id, $project_specific_flag, $RN_userRole);
            }
            if (!$RN_permissionModule) {
                $arrContactPermissionsMatrix = RN_Permissions::loadContactsForSoftwareModulePermissionsMatrixApi($database, $RN_user_company_id, $module_id, $RN_project_id);
                if($arrContactPermissionsMatrix['admin_contact_ids'][$RN_primary_contact_id]) {
                    $RN_permissionModule = true;
                }
            }
            if ($RN_permissionModule) {
                $arrContactPermissionsMatrix = RN_Permissions::checkSoftwareModuleCompanyHavePermission($database, $module_id, $RN_user_company_id);
                $RN_permissionModule = $arrContactPermissionsMatrix;
            }
        }
        $index = 0;
        $arrayTmp['software_module_category_label'] = $module_label;
        $arrayTmp['software_module_category'] = $module_unique;
        $arrayTmp['software_module_category_id'] = $module_id;
        $arrayTmp['menu_type'] = $menu_type;        
        $arrayTmp['icon'] = $module_icon;
        $arrayTmp['nav'] = $module_nav;
        $arrayTmp['access'] = $RN_permissionModule;
        $arrayTmp['module_is_available'] = $module_is_available;
        $arrayTmp['redirect_to_sub_menu'] = $redirectToSubMenu;
        
        return $arrayTmp;
    }
    return null;
}
?>

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
	$RN_meetings_type_1 = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_type_1');
	$RN_meetings_type_2 = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_type_2');
	$RN_meetings_type_3 = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_type_3');
	$RN_meetings_type_4 = $RN_permissions->determineAccessToSoftwareModuleFunction('meetings_type_4');
	
	$RN_arrayTemp['meetings_view'] = $RN_userCanViewDiscussionItems;
	$RN_arrayTemp['meetings_manage'] = $RN_userCanManageMeetings;
	$RN_arrayTemp['meetings_add_discussion_item'] = $RN_userCanCreateDiscussionItems;
	$RN_arrayTemp['meetings_add_action_item'] = $RN_userCanCreateActionItems;
	$RN_arrayTemp['meetings_add_comment'] = $RN_userCanCreateDiscussionItemComments;
	$RN_arrayTemp['meetings_type_1'] = $RN_meetings_type_1;
	$RN_arrayTemp['meetings_type_2'] = $RN_meetings_type_2;
	$RN_arrayTemp['meetings_type_3'] = $RN_meetings_type_3;
	$RN_arrayTemp['meetings_type_4'] = $RN_meetings_type_4;
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

	$RN_task_summery_permission = $RN_permissions->checkDelayPermission($database, $RN_Function_name, $user, $RN_Function_id, $RN_softwareModuleId, $RN_project_id);	
	// check the reole if bidder or subcontract restrict the permission
	$RN_currentlyActiveContactId = $user->currentlyActiveContactId;
	$RN_checkRestriction = $RN_permissions->checkProjectManagerORBidder($database, $RN_project_id, $RN_currentlyActiveContactId);
	if($RN_task_summery_permission && isset($RN_checkRestriction) && !$RN_checkRestriction['bidder_subcontract']) {
		$RN_task_summery_permission = true;
	} else {
		$RN_task_summery_permission = false;
	}
	$RN_arrayTemp[$RN_softwareModuleFunctionName] = $RN_task_summery_permission;
}
$RN_jsonEC['data']['permissions'] = ($RN_arrayTemp);
?>

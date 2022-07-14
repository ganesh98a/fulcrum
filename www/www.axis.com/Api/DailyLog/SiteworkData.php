<?php
$RN_jsonEC['data']['tabs'] = null;
$RN_jsonEC['data']['tabs'][2] = null;
$RN_jsonEC['data']['tabs']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
$RN_jsonEC['status'] = 200;
// Debug
$RN_filterByManpowerFlag='';
if ($RN_filterByManpowerFlag) {
	$RN_arrFilterReturn = Subcontract::loadCostCodesBySubcontractsByProjectId($database, $RN_project_id);
	$RN_arrCostCodesBySubcontractsByProjectId = $RN_arrFilterReturn['cost_codes_by_subcontracts_by_project_id'];
}

$RN_loadJobsiteSiteworkActivitiesByProjectIdOptions = new Input();
$RN_loadJobsiteSiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
$RN_loadJobsiteSiteworkActivitiesByProjectIdOptions->extendedReturn = true;
$RN_arrTmp = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByProjectId($database, $RN_project_id, $RN_loadJobsiteSiteworkActivitiesByProjectIdOptions);
$RN_arrCostCodeIds = $RN_arrTmp['cost_code_ids'];
$RN_arrJobsiteSiteworkActivityIds = $RN_arrTmp['jobsite_sitework_activity_ids'];
$RN_arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId = $RN_arrTmp['jobsite_sitework_activities_by_cost_code_id'];
$RN_arrJobsiteSiteworkActivitiesByProjectId = $RN_arrTmp['jobsite_sitework_activities_by_project_id'];
$RN_jobsiteSiteworkActivityLabelMaxLength = $RN_arrTmp['jobsite_sitework_activity_label_maxlength'];

if (isset($RN_arrCostCodeIds) && !empty($RN_arrCostCodeIds)) {
	$RN_arrCostCodes = CostCode::loadCostCodesByArrCostCodeIds($database, $RN_arrCostCodeIds);
} else {
	$RN_arrCostCodes = array();
}

$RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions = new Input();
$RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
$RN_arrReturn = JobsiteDailySiteworkActivityLog::loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions);
$RN_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = $RN_arrReturn['objects'];
$RN_arrJobsiteDailySiteworkActivityLogIds = $RN_arrReturn['jobsite_daily_sitework_activity_log_ids'];
$RN_arrJobsiteSiteworkActivityIds = $RN_arrReturn['jobsite_sitework_activity_ids'];
$RN_arrJobsiteSiteworkRegionIds = $RN_arrReturn['jobsite_sitework_region_ids'];

$RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions = new Input();
$RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
$RN_arrReturn = JobsiteDailySiteworkActivityLog::loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions);
$RN_arrJobsiteDailySiteworkActivityLogs = $RN_arrReturn['jobsite_sitework_activity_ids'];

$RN_numColumns = 4;
$RN_tdWidth = 1 / $RN_numColumns * 100;

	// Apply appropriate permission: probably jobsite_daily_logs_admin_manage or jobsite_daily_logs_manage.
$RN_userCanManageDailyLog = false;
$RN_popoverContent = '';

$RN_siteworkActivityCells = array();
$RN_Total = 0;
$RN_index = 0;
foreach ($RN_arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId as $RN_cost_code_id => $RN_arrJobsiteSiteworkActivities) {

		// Filter By Manpower
	if (isset($RN_cost_code_id)) {
		if ($RN_filterByManpowerFlag) {
			if (!isset($RN_arrCostCodesBySubcontractsByProjectId[$RN_cost_code_id])) {
				continue;
			}
		}
	}

	foreach ($RN_arrJobsiteSiteworkActivities as $RN_jobsite_sitework_activity_id => $RN_jobsiteSiteworkActivity) {
		$RN_jobsite_sitework_activity_label = $RN_jobsiteSiteworkActivity->jobsite_sitework_activity_label;

		if (isset($RN_arrJobsiteDailySiteworkActivityLogs[$RN_jobsite_sitework_activity_id])) {
			$RN_checked = true;
		} else {
			$RN_checked = false;
		}
		// $RN_Total = $RN_Total + $RN_number_of_people;
		$RN_jsonEC['data']['tabs'][2][$RN_index]['sitework_activity'] = htmlspecialchars_decode($RN_jobsite_sitework_activity_label);
		$RN_jsonEC['data']['tabs'][2][$RN_index]['sitework_activity'] = html_entity_decode($RN_jsonEC['data']['tabs'][2][$RN_index]['sitework_activity'], ENT_QUOTES, "UTF-8");

		$RN_jsonEC['data']['tabs'][2][$RN_index]['checked'] = $RN_checked;
		$RN_jsonEC['data']['tabs'][2][$RN_index]['sitework_activity_id'] = $RN_jobsite_sitework_activity_id;
		$RN_index++;
	}
}
$RN_total_rows = ($RN_index);
$RN_pages = ceil($RN_total_rows / $RN_per_page);
$RN_current_page = isset($RN_page) ? $RN_page : 1;
$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);
if (isset($RN_jsonEC['data']['tabs'][2]) && !empty($RN_jsonEC['data']['tabs'][2])) {
	$RN_jsonEC['data']['tabs'][2] = array_slice($RN_jsonEC['data']['tabs'][2], $RN_start, $RN_per_page);
}
else {
	$RN_jsonEC['data']['tabs'][2] = null; 
} 
$RN_jsonEC['data']['tabs']['total_row'] = $RN_total_rows;
$RN_jsonEC['data']['tabs']['total_pages'] = $RN_pages;
$RN_jsonEC['data']['tabs']['per_pages'] = $RN_per_page;
$RN_jsonEC['data']['tabs']['from'] = ($RN_start+1);
$RN_jsonEC['data']['tabs']['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
$RN_jsonEC['data']['tabs']['prev_page'] = $RN_prev_page;
$RN_jsonEC['data']['tabs']['current_page'] = $RN_current_page;
$RN_jsonEC['data']['tabs']['next_page'] = $RN_next_page;

?>

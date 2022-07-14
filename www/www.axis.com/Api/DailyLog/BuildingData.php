<?php
$RN_jsonEC['data']['tabs'] = null;
$RN_jsonEC['data']['tabs'][3] = null;
$RN_jsonEC['data']['tabs']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
$RN_jsonEC['status'] = 200;
$RN_filter = 0;
if(isset($RN_params['filterby']) && $RN_params['filterby'] != null){
	$RN_filter = filter_var($RN_params['filterby'], FILTER_VALIDATE_BOOLEAN);
}

// Debug
if ($RN_filter) {
	$RN_arrFilterReturn = Subcontract::loadCostCodesBySubcontractsByProjectId($database, $RN_project_id);
	$RN_arrCostCodesBySubcontractsByProjectId = $RN_arrFilterReturn['cost_codes_by_subcontracts_by_project_id'];
	$RN_filterByManpowerFlagChecked = ' checked';
} else {
	$RN_filterByManpowerFlagChecked = '';
}

$RN_loadJobsiteBuildingActivitiesByProjectIdOptions = new Input();
$RN_loadJobsiteBuildingActivitiesByProjectIdOptions->extendedReturn	= true;
$RN_loadJobsiteBuildingActivitiesByProjectIdOptions->filterByCostCode	= false;
$RN_loadJobsiteBuildingActivitiesByProjectIdOptions->forceLoadFlag		= true;

$RN_arrTmp = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByProjectId($database, $RN_project_id, $RN_loadJobsiteBuildingActivitiesByProjectIdOptions);
$RN_arrCostCodeIds = $RN_arrTmp['cost_code_ids'];
$RN_arrJobsiteBuildingActivityIds = $RN_arrTmp['jobsite_building_activity_ids'];
$RN_arrJobsiteBuildingActivitiesByProjectIdByCostCodeId = $RN_arrTmp['jobsite_building_activities_by_cost_code_id'];
$RN_arrJobsiteBuildingActivitiesByProjectId = $RN_arrTmp['jobsite_building_activities_by_project_id'];
$RN_jobsiteBuildingActivityLabelMaxLength = $RN_arrTmp['jobsite_building_activity_label_maxlength'];

$RN_arrCostCodes = $RN_arrCostCodes = CostCode::loadCostCodesByArrCostCodeIds($database, $RN_arrCostCodeIds);

$RN_loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions = new Input();
$RN_loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
$RN_arrReturn = JobsiteDailyBuildingActivityLog::loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId($database, $RN_jobsite_daily_log_id, $RN_loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions);
$RN_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = $RN_arrReturn['objects'];
$RN_arrJobsiteDailyBuildingActivityLogIds = $RN_arrReturn['jobsite_daily_building_activity_log_ids'];
$RN_arrJobsiteBuildingActivityIds = $RN_arrReturn['jobsite_building_activity_ids'];
$RN_arrJobsiteBuildingIds = $RN_arrReturn['jobsite_building_ids'];
$RN_arrJobsiteBuildingcostcodes = $RN_arrReturn['cost_code_id'];

$RN_numColumns = 4;
$RN_tdWidth = 1 / $RN_numColumns * 100;
$RN_arrBuildingActivityCells = array();
$RN_arrCostCodeOptions = array();
$RN_index = 0 ;
foreach ($RN_arrJobsiteBuildingActivitiesByProjectIdByCostCodeId as $RN_cost_code_id => $RN_arrJobsiteBuildingActivities) {

		// Filter By Manpower
	if (isset($RN_cost_code_id)) {
		if ($RN_filter) {
			if (!isset($RN_arrCostCodesBySubcontractsByProjectId[$RN_cost_code_id])) {
				continue;
			}
		}

		if (isset($RN_arrCostCodes[$RN_cost_code_id])) {
			$RN_costCode = $RN_arrCostCodes[$RN_cost_code_id];
			$RN_formattedCostCode = $RN_costCode->getFormattedCostCodeApi($database, true, $RN_user_company_id);
			$RN_arrCostCodeOptions[] = '<option value="'.$RN_cost_code_id.'">'.$RN_formattedCostCode.'</option>';
		} else {
			$RN_formattedCostCode = 'No Trade Specified';
		}
	} else {
		$RN_formattedCostCode = 'No Trade Specified';
	}

	// $RN_arrBuildingActivityCells[] = $RN_buildingActivityCell;

	foreach ($RN_arrJobsiteBuildingActivities as $RN_jobsite_building_activity_id => $RN_jobsiteBuildingActivity) {
		/* @var $RN_jobsiteBuildingActivity JobsiteBuildingActivity */

		$RN_jobsiteBuildingActivity->htmlEntityEscapeProperties();

		$RN_jobsite_building_activity_label = $RN_jobsiteBuildingActivity->jobsite_building_activity_label;
		$RN_escaped_jobsite_building_activity_label = $RN_jobsiteBuildingActivity->escaped_jobsite_building_activity_label;

		if (isset($RN_arrJobsiteBuildingActivityIds[$RN_jobsite_building_activity_id])) {
			if(in_array($RN_cost_code_id, $RN_arrJobsiteBuildingcostcodes))
			{
				$RN_checked = true;
			} else {
				$RN_checked = false;
			}
			if($RN_cost_code_id == 'null' )
			{
				$RN_checked =true;
			}
		} else {
			$RN_checked = false;
		}

		$RN_divWidth = ' style="width: '.($RN_jobsiteBuildingActivityLabelMaxLength*9).'px;"';
		$RN_divWidth = '';

		$RN_jsonEC['data']['tabs'][3][$RN_index]['category'] = htmlspecialchars_decode($RN_formattedCostCode);
		$RN_jsonEC['data']['tabs'][3][$RN_index]['category'] = html_entity_decode($RN_jsonEC['data']['tabs'][3][$RN_index]['category'], ENT_QUOTES, "UTF-8");
		$RN_jsonEC['data']['tabs'][3][$RN_index]['building_activity'] = htmlspecialchars_decode($RN_escaped_jobsite_building_activity_label);
		$RN_jsonEC['data']['tabs'][3][$RN_index]['building_activity'] = html_entity_decode($RN_jsonEC['data']['tabs'][3][$RN_index]['building_activity'], ENT_QUOTES, "UTF-8");
		$RN_jsonEC['data']['tabs'][3][$RN_index]['building_activity_id'] = $RN_jobsite_building_activity_id;
		$RN_jsonEC['data']['tabs'][3][$RN_index]['cost_code_id'] = $RN_cost_code_id;
		$RN_jsonEC['data']['tabs'][3][$RN_index]['checked'] = $RN_checked;
		// $RN_arrBuildingActivityCells[] = $RN_buildingActivityCell;
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
if (isset($RN_jsonEC['data']['tabs'][3]) && !empty($RN_jsonEC['data']['tabs'][3])) {
	$RN_jsonEC['data']['tabs'][3] = array_slice($RN_jsonEC['data']['tabs'][3], $RN_start, $RN_per_page); 
}
else {
	$RN_jsonEC['data']['tabs'][3] = null; 
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

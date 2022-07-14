<?php
$RN_jsonEC['message'] = null;
$RN_jsonEC['data'] = null;
$RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
$RN_jobsite_activity_id = $RN_params['jobsite_activity_id'];
$RN_cost_code_id = $RN_params['cost_code_id'];
if($RN_jobsite_daily_log_id == null && $RN_jobsite_daily_log_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite daily log id is Required";
}else
if($RN_jobsite_activity_id == null && $RN_jobsite_activity_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Building Activity id is Required";
}else{
	$RN_jobsite_building_activity_id = (int) $RN_jobsite_activity_id;
	$RN_jobsiteDailyBuildingActivityLog =
	JobsiteDailyBuildingActivityLog::findByJobsiteDailyLogIdAndJobsiteBuildingActivityId($database, $RN_jobsite_daily_log_id, $RN_jobsite_building_activity_id, $RN_cost_code_id);

	if ($RN_jobsiteDailyBuildingActivityLog) {
		$RN_crudOperation = 'delete';
		$RN_jobsiteDailyBuildingActivityLog->delete();
		$RN_jsonEC['message'] = "Building activity deleted successfully";
	} else {
		$RN_crudOperation = 'create';
		$RN_newAttributeGroupName = '';
		$RN_jobsiteDailyBuildingActivityLog = new JobsiteDailyBuildingActivityLog($database);
		$RN_data = array(
			'jobsite_daily_log_id' => $RN_jobsite_daily_log_id,
			'jobsite_building_activity_id' => $RN_jobsite_building_activity_id,
			'cost_code_id' => $RN_cost_code_id
		);
		$RN_jobsiteDailyBuildingActivityLog->setData($RN_data);
		$RN_jobsite_daily_building_activity_log_id = $RN_jobsiteDailyBuildingActivityLog->save();
		$RN_jsonEC['message'] = "Building activity saved successfully";
	}
	updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $RN_currentlyActiveContactId);
	$RN_jsonEC['status'] = 200;

	$RN_jsonEC['data']['building_data']['jobsite_building_activity_id'] = $RN_jobsite_building_activity_id;
	$RN_jsonEC['data']['building_data']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
}
?>

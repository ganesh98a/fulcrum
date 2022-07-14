<?php
$RN_jsonEC['message'] = null;
$RN_jsonEC['data'] = null;
$RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
$RN_jobsite_activity_id = $RN_params['jobsite_activity_id'];
if($RN_jobsite_daily_log_id == null && $RN_jobsite_daily_log_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite daily log id is Required";
}else
if($RN_jobsite_activity_id == null && $RN_jobsite_activity_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Sitework Activity id is Required";
}else{

	$RN_jobsite_sitework_activity_id = (int) $RN_jobsite_activity_id;
	$RN_jobsite_sitework_region_id = 1;

	$RN_jobsiteDailySiteworkActivityLog =
	JobsiteDailySiteworkActivityLog::findByJobsiteDailyLogIdAndJobsiteSiteworkActivityId($database, $RN_jobsite_daily_log_id, $RN_jobsite_sitework_activity_id);

	if ($RN_jobsiteDailySiteworkActivityLog) {
		$RN_crudOperation = 'delete';
		$RN_jobsiteDailySiteworkActivityLog->delete();
		$RN_jsonEC['message'] = "Sitework activity deleted successfully";
	} else {
		$RN_crudOperation = 'create';
		$RN_newAttributeGroupName = '';
		$RN_jobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);
		$RN_data = array(
			'jobsite_daily_log_id' => $RN_jobsite_daily_log_id,
			'jobsite_sitework_activity_id' => $RN_jobsite_sitework_activity_id,
			'jobsite_sitework_region_id' => $RN_jobsite_sitework_region_id
		);
		$RN_jobsiteDailySiteworkActivityLog->setData($RN_data);
		$RN_jobsite_daily_sitework_activity_log_id = $RN_jobsiteDailySiteworkActivityLog->save();
		$RN_jsonEC['message'] = "Sitework activity saved successfully";
	}
	updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $RN_currentlyActiveContactId);
	$RN_jsonEC['status'] = 200;

	$RN_jsonEC['data']['sitework_data']['jobsite_sitework_activity_id'] = $RN_jobsite_sitework_activity_id;
	$RN_jsonEC['data']['sitework_data']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
}
?>
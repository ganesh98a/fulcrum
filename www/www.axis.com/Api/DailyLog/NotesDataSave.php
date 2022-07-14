<?php
$RN_jsonEC['message'] = null;
$RN_jsonEC['data'] = null;
$RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
$RN_jobsite_note = $RN_params['jobsite_note'];
$RN_jobsite_note_type_id = $RN_params['jobsite_note_type_id'];

if($RN_jobsite_daily_log_id == null && $RN_jobsite_daily_log_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite daily log id is Required";
}else
if($RN_jobsite_note_type_id == null && $RN_jobsite_note_type_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite note type id is Required";
}
else{
	
	$RN_data = array(
		'jobsite_daily_log_id' => $RN_jobsite_daily_log_id,
		'jobsite_note_type_id' => $RN_jobsite_note_type_id,
		'jobsite_note' => $RN_jobsite_note,
	);

	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */
	$RN_db->throwExceptionOnDbError = true;
	$RN_jobsiteNote = new JobsiteNote($database);
	// Retrieve all of the $RN__GET inputs automatically for the JobsiteNote record
	$RN_jobsiteNote->setData($RN_data);
	$RN_jobsiteNote->convertDataToProperties();

	$RN_jobsiteNote->convertPropertiesToData();
	$RN_data = $RN_jobsiteNote->getData();
	// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
	$RN_jobsite_note_id = $RN_jobsiteNote->insertOnDuplicateKeyUpdate();

	updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $RN_currentlyActiveContactId);
	/*load details*/
	$RN_notestArray = array(
		1 => 'General Notes',
		2 => 'Safty',
		3 => 'Visitors',
		4 => 'SWPPP',
		5 => 'Deliveries',
		6 => 'Extra Work',
		7 => 'Delay Notes'
	);
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['message'] = "Jobsite note saved successfully";
	$RN_jsonEC['data']['note_data']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
	$RN_jsonEC['data']['note_data']['jobsite_note'] = $RN_jobsite_note;
	$RN_jsonEC['data']['note_data']['jobsite_note_type_id'] = $RN_jobsite_note_type_id;
	$RN_jsonEC['data']['note_data']['jobsite_note_name'] = $RN_notestArray[$RN_jobsite_note_type_id];
}	
?>
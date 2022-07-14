<?php
$RN_jsonEC['message'] = null;
$RN_jsonEC['data'] = null;
$RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
$RN_subcontract_id = $RN_params['subcontract_id'];
$RN_number_of_people = $RN_params['number_of_people'];
if($RN_number_of_people == null && $RN_number_of_people == ''){
	$RN_number_of_people = 0;
}
if($RN_date == null && $RN_date == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "date is Required";
}else
if($RN_jobsite_daily_log_id == null && $RN_jobsite_daily_log_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite daily log id is Required";
}else
if($RN_subcontract_id == null && $RN_subcontract_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Subcontractor id is Required";
}else
// if($RN_number_of_people == null && $RN_number_of_people == ''){
// 	$RN_jsonEC['status'] = 200;
// 	$RN_number_of_people = 0;
// 	$RN_jsonEC['err_message'] = "Number of people is Required";
// }else
if(!is_numeric($RN_number_of_people)){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Number of people must be Number";
}else{
	$RN_jsonEC['data']['manpower_data'] = null;
	$RN_jsonEC['status'] = 200;
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$query ="
	SELECT *
	FROM `jobsite_man_power`
	WHERE `jobsite_daily_log_id` = $RN_jobsite_daily_log_id 
	AND `subcontract_id` = $RN_subcontract_id
	";
	$db->execute($query);
	$row = $db->fetch();
	$db->free_result();
	if(isset($row) && !empty($row) && $row){
		/*update*/
		$RN_data = array(
			'jobsite_man_power_id' => $row['id'],
			'jobsite_daily_log_id' => $RN_jobsite_daily_log_id,
			'subcontract_id' => $RN_subcontract_id,
			'number_of_people' => $RN_number_of_people,
		);
		$RN_data_update = array(
			'number_of_people' => $RN_number_of_people,
		);
		$RN_jobsite_man_power_id = $row['id'];
		$RN_save = true;
		$RN_jobsiteManPower = JobsiteManPower::findById($database, $RN_jobsite_man_power_id);
		if ($RN_save) {
			$RN_jobsiteManPower->setData($RN_params);
			$RN_jobsiteManPower->convertDataToProperties();
			// $jobsite_man_power_id = $jobsiteManPower->insertOnDuplicateKeyUpdate();
			$RN_jobsiteManPower->insertOnDuplicateKeyUpdate();
			updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $currentlyActiveContactId);
			$RN_jsonEC['status'] = 200;
			$RN_jsonEC['message'] = "Manpower on site updated successfully";
		}
	}else{
		/*create*/
		$RN_jobsiteManPower = new JobsiteManPower($database);
		$RN_jobsiteManPower->setData($RN_params);
		$RN_jobsiteManPower->convertDataToProperties();
		$RN_jobsite_man_power_id = $RN_jobsiteManPower->insertOnDuplicateKeyUpdate();
		updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $currentlyActiveContactId);
		$RN_jsonEC['status'] = 200;
		$RN_jsonEC['message'] = "Manpower on site saved successfully";
	}
	$RN_jsonEC['data']['manpower_data']['jobsite_man_power_id'] = $RN_jobsite_man_power_id;
	$RN_jsonEC['data']['manpower_data']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
	$RN_jsonEC['data']['manpower_data']['subcontract_id'] = $RN_subcontract_id;
	$RN_jsonEC['data']['manpower_data']['number_of_people'] = $RN_number_of_people;
	/*Total Manpoer*/
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */
	$query ="
	SELECT SUM(number_of_people) as total_onsite
	FROM `jobsite_man_power`
	WHERE `jobsite_daily_log_id` = $RN_jobsite_daily_log_id GROUP BY jobsite_daily_log_id
	";
	$db->execute($query);
	$row = $db->fetch();
	$db->free_result();
	$RN_jsonEC['data']['manpower_data']['total_onsite'] = $row['total_onsite'];
}

?>

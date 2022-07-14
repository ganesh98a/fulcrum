<?php
$RN_jsonEC['message'] = null;
$RN_jsonEC['data'] = null;
$RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
if (isset($RN_params['jobsite_inspection_type_id']) && !empty($RN_params['jobsite_inspection_type_id'])) {
	$RN_jobsite_inspection_type_id = $RN_params['jobsite_inspection_type_id'];
} else {
	$RN_jobsite_inspection_type_id = '';
}

$RN_jobsite_inspection_passed_flag = $RN_params['jobsite_inspection_passed_flag'];
$RN_jobsite_inspection_note = $RN_params['jobsite_inspection_note'];
if (isset($RN_params['jobsite_inspection_id']) && !empty($RN_params['jobsite_inspection_id'])) {
	$RN_jobsite_inspection_id = $RN_params['jobsite_inspection_id'];
} else {
	$RN_jobsite_inspection_id = '';
}


$RN_method = $RN_params['method'];
$valid = false;
if($RN_method == 'Create'){
	$valid = true;
}

if($RN_jobsite_daily_log_id == null && $RN_jobsite_daily_log_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite daily log id is Required";
}else
if($RN_jobsite_inspection_type_id == null && $RN_jobsite_inspection_type_id == '' && $valid){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite inspection type id is Required";
}else
if($RN_jobsite_inspection_passed_flag == null && $RN_jobsite_inspection_passed_flag == '' && $valid){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = " Jobsite inspection passed flag is Required";
}else
if($RN_method == null && $RN_method == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = " Method is Required";
}
else{
	if($RN_method == 'Create'){
		$RN_db = DBI::getInstance($database);
		/* @var $RN_db DBI_mysqli */
		$RN_db->throwExceptionOnDbError = true;	
		// Retrieve all of the $RN__GET inputs automatically for the JobsiteInspection record

		$RN_jobsiteInspection = new JobsiteInspection($database);
		$RN_data = array(
			'jobsite_daily_log_id' => $RN_jobsite_daily_log_id,
			'jobsite_inspection_type_id' => $RN_jobsite_inspection_type_id,
			'jobsite_inspection_passed_flag' => $RN_jobsite_inspection_passed_flag,
			'jobsite_inspection_note' => $RN_jobsite_inspection_note,
		);
		$RN_jobsiteInspection->setData($RN_data);
		$RN_jobsiteInspection->convertDataToProperties();

		$RN_jobsiteInspection->convertPropertiesToData();
		$RN_data = $RN_jobsiteInspection->getData();
		$RN_jobsiteInspection->setKey(null);
		$RN_jobsiteInspection->setData($RN_data);
		$RN_jobsite_inspection_id = $RN_jobsiteInspection->save();
		if (isset($RN_jobsite_inspection_id) && !empty($RN_jobsite_inspection_id)) {
			$RN_jobsiteInspection->jobsite_inspection_id = $RN_jobsite_inspection_id;
			$RN_jobsiteInspection->setId($RN_jobsite_inspection_id);
			$RN_jobsite_daily_log_id = $RN_jobsiteInspection->jobsite_daily_log_id;

				// jobsite_inspection_note
			$RN_jobsite_inspection_note = (string) $RN_jobsite_inspection_note;
			if (!empty($RN_jobsite_inspection_note)) {
				$RN_jobsiteInspectionNote = JobsiteInspectionNote::findByJobsiteInspectionId($database, $RN_jobsite_inspection_id);
				/* @var $RN_jobsiteInspectionNote JobsiteInspectionNote */
				if ($RN_jobsiteInspectionNote) {
					$RN_data = array(
						'jobsite_inspection_note' => $RN_jobsite_inspection_note
					);
					$RN_jobsiteInspectionNote->setData($RN_data);
					$RN_jobsiteInspectionNote->save();
				} else {
					$RN_jobsiteInspectionNote = new JobsiteInspectionNote($database);
					$RN_data = array(
						'jobsite_inspection_id' => $RN_jobsite_inspection_id,
						'jobsite_inspection_note' => $RN_jobsite_inspection_note
					);
					$RN_jobsiteInspectionNote->setData($RN_data);
					$RN_jobsiteInspectionNote->save();
				}
				$RN_jobsiteInspectionNote->convertDataToProperties();
			} else {
				$RN_jobsiteInspectionNote = false;
			}
		}
		updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $RN_currentlyActiveContactId);
		/*load details*/
		if ($RN_jobsiteInspectionNote && ($RN_jobsiteInspectionNote instanceof JobsiteInspectionNote)) {
			$RN_jobsiteInspectionNote->htmlEntityEscapeProperties();
			$RN_escaped_jobsite_inspection_note = $RN_jobsiteInspectionNote->escaped_jobsite_inspection_note;
		} else {
			$RN_escaped_jobsite_inspection_note = '';
		}

		$RN_jobsiteInspectionType = JobsiteInspectionType::findById($database, $RN_jobsite_inspection_type_id);
		/* @var $RN_jobsiteInspectionType JobsiteInspectionType */
		$RN_jobsiteInspectionType->htmlEntityEscapeProperties();
		$RN_jobsite_inspection_type = $RN_jobsiteInspectionType->jobsite_inspection_type;
		$RN_escaped_jobsite_inspection_type = $RN_jobsiteInspectionType->escaped_jobsite_inspection_type;
		$RN_jobsite_inspection_passed_flag = $RN_jobsiteInspection->jobsite_inspection_passed_flag;

		$RN_jsonEC['status'] = 200;
		$RN_jsonEC['message'] = "Jobsite inspection saved successfully";
		$RN_jsonEC['data']['inspection_data']['jobsite_inspection_id'] = $RN_jobsite_inspection_id;
		$RN_jsonEC['data']['inspection_data']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
		$RN_jsonEC['data']['inspection_data']['jobsite_inspection_type_id'] = $RN_jobsite_inspection_type_id;		
		$RN_jsonEC['data']['inspection_data']['jobsite_inspection_type'] = htmlspecialchars_decode($RN_escaped_jobsite_inspection_type);
		$RN_jsonEC['data']['inspection_data']['jobsite_inspection_passed_flag'] = $RN_jobsite_inspection_passed_flag;
		$RN_jsonEC['data']['inspection_data']['jobsite_inspection_note'] = htmlspecialchars_decode($RN_escaped_jobsite_inspection_note);
	}else{
		$RN_jobsite_inspection_id = $RN_jobsite_inspection_id;
		// Put in findById() or findByUniqueKey() as appropriate
		$RN_jobsiteInspection = JobsiteInspection::findById($database, $RN_jobsite_inspection_id);
		/* @var $jobsiteInspection JobsiteInspection */
		if ($RN_jobsiteInspection) {
			$RN_jobsiteInspection->delete();
			updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $RN_currentlyActiveContactId);
			$RN_jsonEC['status'] = 200;
			$RN_jsonEC['message'] = "Jobsite inspection deleted successfully";
			$RN_jsonEC['data']['inspection_data']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
		} else {
			// Perhaps trigger an error
			$RN_jsonEC['status'] = 400;
			$RN_jsonEC['err_message'] = "Jobsite Inspection record does not exist";
		}
	}
}	
?>

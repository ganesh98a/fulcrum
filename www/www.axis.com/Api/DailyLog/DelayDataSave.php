<?php
$RN_jsonEC['message'] = null;
$RN_jsonEC['data'] = null;
$RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
$RN_jobsite_delay_category_id = '';
if (isset($RN_params['jobsite_delay_category_id']) && !empty($RN_params['jobsite_delay_category_id'])) {
	$RN_jobsite_delay_category_id = $RN_params['jobsite_delay_category_id'];
}
$RN_jobsite_delay_subcategory_id = '';
if (isset($RN_params['jobsite_delay_subcategory_id']) && !empty($RN_params['jobsite_delay_subcategory_id'])) {
	$RN_jobsite_delay_subcategory_id = $RN_params['jobsite_delay_subcategory_id'];
}
$RN_jobsite_delay_note = '';
if (isset($RN_params['jobsite_delay_note']) && !empty($RN_params['jobsite_delay_note'])) {
	$RN_jobsite_delay_note = $RN_params['jobsite_delay_note'];
}
$RN_jobsite_delay_id = '';
if (isset($RN_params['jobsite_delay_id']) && !empty($RN_params['jobsite_delay_id'])) {
	$RN_jobsite_delay_id = $RN_params['jobsite_delay_id'];
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
if($RN_jobsite_delay_category_id == null && $RN_jobsite_delay_category_id == '' && $valid){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite delay category type id is Required";
}else
// if($RN_jobsite_delay_subcategory_id == null && $RN_jobsite_delay_subcategory_id == '' && $valid){
// 	$RN_jsonEC['status'] = 400;
// 	$RN_jsonEC['err_message'] = " Jobsite delay subcategory type is Required";
// }else
if($RN_method == null && $RN_method == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = " Method is Required";
}
else{
	if($RN_method == 'Create'){
		if($RN_jobsite_delay_subcategory_id == null && $RN_jobsite_delay_subcategory_id == '' && $valid){
			$RN_jobsite_delay_subcategory_id = 13;
		}
		$RN_db = DBI::getInstance($database);
		/* @var $RN_db DBI_mysqli */
		$RN_db->throwExceptionOnDbError = true;
		// Retrieve all of the $RN__GET inputs automatically for the JobsiteDelay record
		$RN_data = array(
			'jobsite_daily_log_id' => $RN_jobsite_daily_log_id,
			'jobsite_delay_category_id' => $RN_jobsite_delay_category_id,
			'jobsite_delay_subcategory_id' => $RN_jobsite_delay_subcategory_id,
			'jobsite_delay_note' => $RN_jobsite_delay_note,
		);

		$RN_jobsiteDelay = new JobsiteDelay($database);

		$RN_jobsiteDelay->setData($RN_data);
		$RN_jobsiteDelay->convertDataToProperties();

		$RN_jobsiteDelay->convertPropertiesToData();
		$RN_data = $RN_jobsiteDelay->getData();

		$RN_jobsiteDelay->setData($RN_data);
		$RN_jobsite_delay_id = $RN_jobsiteDelay->save();
		if (isset($RN_jobsite_delay_id) && !empty($RN_jobsite_delay_id)) {
			$RN_jobsiteDelay->jobsite_delay_id = $RN_jobsite_delay_id;
			$RN_jobsiteDelay->setId($RN_jobsite_delay_id);
			$RN_jobsite_daily_log_id = $RN_jobsiteDelay->jobsite_daily_log_id;

				// jobsite_delay_note
			// $RN_jobsite_delay_note = (string) $RN_get->jobsite_delay_note;
			$RN_jobsiteDelayNote = null;
			if (!empty($RN_jobsite_delay_note)) {
				$RN_jobsiteDelayNote = JobsiteDelayNote::findByJobsiteDelayId($database, $RN_jobsite_delay_id);
				/* @var $RN_jobsiteDelayNote JobsiteDelayNote */
				if ($RN_jobsiteDelayNote) {
					$RN_data = array(
						'jobsite_delay_note' => $RN_jobsite_delay_note
					);
					$RN_jobsiteDelayNote->setData($RN_data);
					$RN_jobsiteDelayNote->save();
				} else {
					$RN_jobsiteDelayNote = new JobsiteDelayNote($database);
					$RN_data = array(
						'jobsite_delay_id' => $RN_jobsite_delay_id,
						'jobsite_delay_note' => $RN_jobsite_delay_note
					);
					$RN_jobsiteDelayNote->setData($RN_data);
					$RN_jobsiteDelayNote->save();
				}
				$RN_jobsiteDelayNote->convertDataToProperties();
			} else {
				$RN_jobsiteDelayNote = false;
			}
		}

		updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $RN_currentlyActiveContactId);
		/*load details*/

		$RN_jobsiteDelayCategory = JobsiteDelayCategory::findById($database, $RN_jobsite_delay_category_id);
		/* @var $RN_jobsiteDelayCategory JobsiteDelayCategory */

		$RN_jobsiteDelaySubcategory = JobsiteDelaySubcategory::findById($database, $RN_jobsite_delay_subcategory_id);
		/* @var $RN_jobsiteDelaySubcategory JobsiteDelaySubcategory */

		$RN_jobsiteDelayCategory->htmlEntityEscapeProperties();
		$RN_jobsiteDelaySubcategory->htmlEntityEscapeProperties();

		$RN_jobsite_delay_category = $RN_jobsiteDelayCategory->jobsite_delay_category;
		$RN_escaped_jobsite_delay_category = $RN_jobsiteDelayCategory->escaped_jobsite_delay_category;

		$RN_jobsite_delay_subcategory = $RN_jobsiteDelaySubcategory->jobsite_delay_subcategory;
		$RN_escaped_jobsite_delay_subcategory = $RN_jobsiteDelaySubcategory->escaped_jobsite_delay_subcategory;

		if ($RN_jobsiteDelayNote && ($RN_jobsiteDelayNote instanceof JobsiteDelayNote)) {
			$RN_jobsiteDelayNote->htmlEntityEscapeProperties();
			$RN_jobsite_delay_note = $RN_jobsiteDelayNote->jobsite_delay_note;
			$RN_escaped_jobsite_delay_note = $RN_jobsiteDelayNote->escaped_jobsite_delay_note;
		} else {
			$RN_jobsite_delay_note = '';
			$RN_escaped_jobsite_delay_note = '';
		}

		$RN_jsonEC['status'] = 200;
		$RN_jsonEC['message'] = "Jobsite delay saved successfully";
		$RN_jsonEC['data']['delay_data']['jobsite_delay_id'] = $RN_jobsite_delay_id;
		$RN_jsonEC['data']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
		$RN_jsonEC['data']['delay_data']['jobsite_delay_category'] = htmlspecialchars_decode($RN_escaped_jobsite_delay_category);
		$RN_jsonEC['data']['delay_data']['jobsite_delay_subcategory'] = htmlspecialchars_decode($RN_escaped_jobsite_delay_subcategory);
		$RN_jsonEC['data']['delay_data']['jobsite_delay_note'] = htmlspecialchars_decode($RN_escaped_jobsite_delay_note);
	}else{

		// Put in findById() or findByUniqueKey() as appropriate
		$RN_jobsiteDelay = JobsiteDelay::findById($database, $RN_jobsite_delay_id);
		/* @var $RN_jobsiteDelay JobsiteDelay */
		if ($RN_jobsiteDelay) {
			$RN_jobsiteDelay->delete();
			updateJobsiteDailyLogModifiedFields($database, $RN_jobsite_daily_log_id, $RN_currentlyActiveContactId);
			$RN_jsonEC['status'] = 200;
			$RN_jsonEC['message'] = "Jobsite delays deleted successfully";
			$RN_jsonEC['data']['delay_data']['jobsite_daily_log_id'] = $RN_jobsite_daily_log_id;
		} else {
			// Perhaps trigger an error
			$RN_jsonEC['status'] = 400;
			$RN_jsonEC['message'] = "Jobsite delay record does not exist";
		}
	}
}	
?>

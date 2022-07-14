<?php
$RN_methodSave = $RN_params['method_save'];
$RN_internal_use_only_flag = $RN_params['internal_use_only_flag'];

$RN_file_manager_file_id = $RN_jsonEC['data']['file_data'][0]['file_manager_file_id'];
$RN_jobsite_daily_log_id = $RN_jsonEC['data']['file_data'][0]['jobsite_daily_log_id'];

if($RN_methodSave == 'jobsite_sign_in_sheets'){
	$RN_data = array(
		"jobsite_sign_in_sheet_file_manager_file_id" => $RN_file_manager_file_id,
		"jobsite_daily_log_id" => $RN_jobsite_daily_log_id,
	);
	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */
	$RN_db->throwExceptionOnDbError = true;

	// Retrieve all of the $RN__GET inputs automatically for the JobsiteSignInSheet record
	
	$RN_jobsiteSignInSheet = new JobsiteSignInSheet($database);

	$RN_jobsiteSignInSheet->setData($RN_data);
	$RN_jobsiteSignInSheet->convertDataToProperties();

	$RN_jobsiteSignInSheet->convertPropertiesToData();
	$RN_data = $RN_jobsiteSignInSheet->getData();

	// Test for existence via standard findByUniqueIndex method
	$RN_jobsiteSignInSheet->findByUniqueIndex();
	if ($RN_jobsiteSignInSheet->isDataLoaded()) {
		// Error code here
		$RN_errorMessage = 'Jobsite Sign In Sheet already exists.';
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['message'] = null;
		$RN_jsonEC['data'] = null;
		$RN_jsonEC['err_message'] = "Jobsite Sign In Sheet already exists.";
	} else {
		$RN_jobsiteSignInSheet->setKey(null);
		$RN_jobsiteSignInSheet->setData($RN_data);
	}

	$RN_jobsite_sign_in_sheet_id = $RN_jobsiteSignInSheet->save();
	if (isset($RN_jobsite_sign_in_sheet_id) && !empty($RN_jobsite_sign_in_sheet_id)) {
		$RN_jsonEC['data']['file_data'][0]['jobsite_sign_in_sheet_id'] = $RN_jobsite_sign_in_sheet_id;
		$RN_jsonEC['data']['raw_file_data']['id'] = $RN_jobsite_sign_in_sheet_id;
	}
}

if($RN_methodSave == 'jobsite_field_reports'){
	$RN_data = array(
		"jobsite_field_report_file_manager_file_id" => $RN_file_manager_file_id,
		"jobsite_daily_log_id" => $RN_jobsite_daily_log_id,
	);
	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */
	$RN_db->throwExceptionOnDbError = true;
	// Retrieve all of the $RN__GET inputs automatically for the JobsiteFieldReport record

	$RN_jobsiteFieldReport = new JobsiteFieldReport($database);

	$RN_jobsiteFieldReport->setData($RN_data);
	$RN_jobsiteFieldReport->convertDataToProperties();

	$RN_jobsiteFieldReport->convertPropertiesToData();
	$RN_data = $RN_jobsiteFieldReport->getData();

			// Test for existence via standard findByUniqueIndex method
	$RN_jobsiteFieldReport->findByUniqueIndex();
	if ($RN_jobsiteFieldReport->isDataLoaded()) {
				// Error code here
		$RN_errorMessage = 'Jobsite Field Report already exists.';
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['message'] = null;
		$RN_jsonEC['data'] = null;
		$RN_jsonEC['err_message'] = $RN_errorMessage;
	} else {
		$RN_jobsiteFieldReport->setKey(null);
		$RN_jobsiteFieldReport->setData($RN_data);
	}

	$RN_jobsite_field_report_id = $RN_jobsiteFieldReport->save();
	if (isset($RN_jobsite_field_report_id) && !empty($RN_jobsite_field_report_id)) {
		$RN_jsonEC['data']['file_data'][0]['jobsite_field_report_id'] = $RN_jobsite_field_report_id;
		$RN_jsonEC['data']['raw_file_data']['id'] = $RN_jobsite_field_report_id;
		
	}
}
if($RN_methodSave == 'jobsite_photos'){
	$RN_data = array(
		"jobsite_photo_file_manager_file_id" => $RN_file_manager_file_id,
		"jobsite_daily_log_id" => $RN_jobsite_daily_log_id,
		"internal_use_only_flag" => $RN_internal_use_only_flag
	);
	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */

	$RN_db->throwExceptionOnDbError = true;
	// Retrieve all of the $RN__GET inputs automatically for the JobsitePhoto record
	
	$RN_jobsitePhoto = new JobsitePhoto($database);

	$RN_jobsitePhoto->setData($RN_data);
	$RN_jobsitePhoto->convertDataToProperties();

	$RN_jobsitePhoto->convertPropertiesToData();
	$RN_data = $RN_jobsitePhoto->getData();

	// Test for existence via standard findByUniqueIndex method
	$RN_jobsitePhoto->findByUniqueIndex();
	if ($RN_jobsitePhoto->isDataLoaded()) {
	// Error code here
		$RN_errorMessage = 'Jobsite Photo already exists.';
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['message'] = null;
		$RN_jsonEC['data'] = null;
		$RN_jsonEC['err_message'] = $RN_errorMessage;
	} else {
		$RN_jobsitePhoto->setKey(null);
		$RN_jobsitePhoto->setData($RN_data);
	}

	$RN_jobsite_photo_id = $RN_jobsitePhoto->save();
	$RN_jsonEC['data']['file_data'][0]['jobsite_photo_id'] = $RN_jobsite_photo_id;
	$RN_jsonEC['data']['raw_file_data']['id'] = $RN_jobsite_photo_id;
}

?>
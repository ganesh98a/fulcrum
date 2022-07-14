<?php
$RN_jsonEC['message'] = null;
$RN_jsonEC['data'] = null;
$RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
$RN_jobsite_sign_in_sheet_id = $RN_params['id'];
$RN_jobsite_field_report_id = $RN_params['id'];
$RN_jobsite_photo_id = $RN_params['id'];
$RN_method = $RN_params['method'];

if($RN_jobsite_daily_log_id == null && $RN_jobsite_daily_log_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite daily log id is Required";
}else
if($RN_method == null && $RN_method == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Method is Required";
}else{
	
	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */
	$RN_db->throwExceptionOnDbError = true;
	if ($RN_method == 'sign_in_sheet') {
		if($RN_jobsite_sign_in_sheet_id == null && $RN_jobsite_sign_in_sheet_id == ''){
			$RN_jsonEC['status'] = 400;
			$RN_jsonEC['err_message'] = "Jobsite sign in sheet id is Required";
		}else{
			// Put in findById() or findByUniqueKey() as appropriate
			$RN_jobsiteSignInSheet = JobsiteSignInSheet::findById($database, $RN_jobsite_sign_in_sheet_id);
			/* @var $RN_jobsiteSignInSheet JobsiteSignInSheet */

			if ($RN_jobsiteSignInSheet) {
				$RN_jobsiteSignInSheet->delete();
				$RN_jsonEC['status'] = 200;
				$RN_jsonEC['message'] = "Jobsite sign in sheets deleted successfully";
			} else {
				$RN_jsonEC['status'] = 400;
				$RN_jsonEC['message'] = "Jobsite Sign In Sheet record does not exist.";
			}
		}
	}else
	if ($RN_method == 'field_report') {
		if($RN_jobsite_field_report_id == null && $RN_jobsite_field_report_id == ''){
			$RN_jsonEC['status'] = 400;
			$RN_jsonEC['err_message'] = "Jobsite field report id is Required";
		}else{
			// Put in findById() or findByUniqueKey() as appropriate
			$RN_jobsiteFieldReport = JobsiteFieldReport::findById($database, $RN_jobsite_field_report_id);
			/* @var $RN_jobsiteFieldReport JobsiteFieldReport */

			if ($RN_jobsiteFieldReport) {
				$RN_jobsiteFieldReport->delete();
				$RN_jsonEC['status'] = 200;
				$RN_jsonEC['message'] = "Jobsite Field Report deleted successfully";
			} else {
				$RN_jsonEC['status'] = 400;
				$RN_jsonEC['message'] = "Jobsite Field Report record does not exist.";
			}
		}
	}else
	if ($RN_method == 'jobsite_photo') {
		if($RN_jobsite_photo_id == null && $RN_jobsite_photo_id == ''){
			$RN_jsonEC['status'] = 400;
			$RN_jsonEC['err_message'] = "Jobsite photo id is Required";
		}else{
			$RN_jobsitePhoto = JobsitePhoto::findById($database, $RN_jobsite_photo_id);
			/* @var $RN_jobsitePhoto JobsitePhoto */

			if ($RN_jobsitePhoto) {
				$RN_jobsitePhoto->delete();
				$RN_jsonEC['status'] = 200;
				$RN_jsonEC['message'] = "Jobsite Photo deleted successfully";
			} else {
				$RN_jsonEC['status'] = 400;
				$RN_jsonEC['message'] = "Jobsite Photo record does not exist.";
			}
		}
	}
}
?>
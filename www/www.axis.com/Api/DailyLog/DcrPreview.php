<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');

$RN_timezone = date_default_timezone_get();
$RN_i=date('H:i:s', time());
$RN_timedate=date('d/m/Y h:i a', time());

$RN_jsonEC['message'] = null;
// $RN_jsonEC['data'] = null;
$RN_jsonEC['data']['tabs'][5]['pdf'] = null;
// $RN_jobsite_daily_log_id = $RN_params['jobsite_daily_log_id'];
if($RN_jobsite_daily_log_id == null && $RN_jobsite_daily_log_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Jobsite daily log id is Required";
}
else{
	$RN_jobsiteDailyLog = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $RN_jobsite_daily_log_id);
	/* @var $RN_jobsiteDailyLog JobsiteDailyLog */
	$RN_jobsite_daily_log_created_date = $RN_jobsiteDailyLog->jobsite_daily_log_created_date;

	$RN_fileManagerFile = generateDailyConstructionReport($database, $RN_jobsiteDailyLog, true, false);
	/* @var $RN_fileManagerFile FileManagerFile */
	// PDF Link
	if ($RN_fileManagerFile) {
		$RN_project = $RN_fileManagerFile->getProject();
		/* @var $RN_project Project */
		$RN_project->htmlEntityEscapeProperties();

		$RN_escaped_project_name = $RN_project->escaped_project_name;
		// print_r($RN_fileManagerFile);
		$RN_CreatedDate = date('Y-m-d',strtotime($RN_fileManagerFile->created));

		$RN_CustomeName = 'Daily Construction Report - '.$RN_escaped_project_name.' - '.$RN_CreatedDate.' - '.$RN_i.'.pdf';

		$RN_fileUrl = $RN_fileManagerFile->generateUrl(true);
		$RN_virtual_file_name = $RN_fileManagerFile->virtual_file_name;
		$RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
		$RN_htmlContent = '<b>' . $RN_escaped_project_name . ' DCR PDF:</b> <a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$RN_fileUrl.'" title="'.$RN_virtual_file_name.'">'.$RN_virtual_file_name.'</a>';
		$RN_explodeValue = explode('?', $RN_fileUrl);
		if(isset($RN_explodeValue[1])){
			$RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
		}
		/* file permission*/
		$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_fileManagerFile->file_manager_file_id);
		$accessFiles = false;
		if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
			if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
				$accessFiles = false;
			} else {
				$accessFiles = true;
			}
		}

		$RN_jsonEC['status'] = 200;
		$RN_jsonEC['data']['tabs'][5]['pdf']['name'] =  $RN_escaped_project_name;
		$RN_jsonEC['data']['tabs'][5]['pdf']['url'] =  $RN_fileUrl;
		$RN_jsonEC['data']['tabs'][5]['pdf']['id'] =  $RN_id;
		$RN_jsonEC['data']['tabs'][5]['pdf']['virtual_file_name'] =  $RN_CustomeName;
		$RN_jsonEC['data']['tabs'][5]['pdf']['file_access'] =  $accessFiles;
		
	}
}
?>

<?php
/**
 * cron job to generate jobsite daily log dcr report
 */

// Secret key via url allows access to this script
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
	if ($id == '76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C') {
		$init['access_level'] = 'anon';
	} else {
		$init['access_level'] = 'auth';
	}
} else {
	$init['access_level'] = 'auth';
}

//$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');

require_once('./modules-jobsite-daily-logs-functions.php');
require_once('lib/common/Mail.php');
require_once('lib/common/Permissions.php');
require_once('lib/common/Module.php');
require_once('renderPDF.php');


// Debug
//$get->date = '2016-02-16';

// we will get the date on the fly to pass it to the function
if (isset($get)) {
	$dcrReportDate = trim($get->date);
} else {
	$dcrReportDate = '';
}

if (isset($get->project_id)) {
	$project_id = $get->project_id;
}else{
	$project_id = '';
}

if (!empty($dcrReportDate)) {
	if (!preg_match("/\d{4}-\d{2}-\d{2}/", $dcrReportDate)) {
		throw new Exception('parameter for date requested [' . $_REQUEST['date'] . '] is an invalid date.');
	}
	$time = '';
} else {
	$dcrReportDate = date('Y-m-d');
	$min = date('i');
	if ($min % 5 == 0) {
		$time = date('H:i').':00';
	}else{
		$mod_min = 5 * ((int)($min / 5));
		$time = date('H').':'.$mod_min.':00';
	}	
	// $time = date('H:i', strtotime(date('H:i:s').'+ 10 minutes')).':00';
}
echo $time;

$arrForDcrFile = JobsiteDailyLog::loadJobsiteDailyLogsByJobsiteDailyLogCreatedDate($database, $dcrReportDate, $time, $project_id);

// arr of created and not mailed project
$arrFromDcrFile = JobsiteDailyLog::getProjectFromDcrFile($database, $dcrReportDate,0);

foreach ($arrForDcrFile as $jobsite_daily_log_id => $jobsiteDailyLog) {

	$proId = $jobsiteDailyLog->project_id;

	if (array_key_exists($proId, $arrFromDcrFile)) {
		continue;
	}else{
		$fileManagerFile = generateDailyConstructionReport($database, $jobsiteDailyLog);

		if ($fileManagerFile) {
			
			$project_id = $fileManagerFile->project_id;	
			// for file size greater than 17 mb
			$attachmentFileName = $fileManagerFile->virtual_file_name;
			$cdnFileUrl = $fileManagerFile->generateUrl(true);
			$daliyFileId = $fileManagerFile->file_location_id;
	        $filemaxSize=Module::getfilemanagerfilesize($daliyFileId,$database);
	        $insertOrUpdate = 1; // 1 means insert else update

	        // Function to insert and update DCR file_details
			$loadDCRfileDetails = JobsiteDailyLog::loadDCRfileDetails($database, $project_id, $cdnFileUrl, $attachmentFileName, $filemaxSize, $dcrReportDate, $insertOrUpdate);
	    }
	}
}

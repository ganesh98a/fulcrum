<?php
/**
 * Daily Log Module.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['skip_always_include'] = false;
$init['skip_session'] = false;
$init['skip_templating'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('renderPDF.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */

// CONSTANT VARIABLES
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$AXIS_TEMPLATE_USER_COMPANY_ID = AXIS_TEMPLATE_USER_COMPANY_ID;

require_once('modules-jobsite-daily-logs-functions.php');
require_once('include/page-components/FineUploader.php');

// DATABASE VARIABLES
$db = DBI::getInstance($database);

// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
// PERMISSION VARIABLES
require_once('app/models/permission_mdl.php');

$userCanViewJobsiteDailyLog = checkPermissionForAllModuleAndRole($database,'jobsite_daily_logs_view');
$userCanManageJobsiteDailyLog = checkPermissionForAllModuleAndRole($database,'jobsite_daily_logs_manage');
$userCanManageJobsiteDailyLogAdmin = checkPermissionForAllModuleAndRole($database,'jobsite_daily_logs_admin_manage');
$userCanDcrReport = checkPermissionForAllModuleAndRole($database,'daily_construction_report');


// If No Access
if($userRole !="global_admin"){
	if (!$userCanViewJobsiteDailyLog &&(!$userCanManageJobsiteDailyLog) || (!$userCanManageJobsiteDailyLog &&(!$userCanViewJobsiteDailyLog) ) ) {
		$errorMessage = 'Permission denied.';
		$message->enqueueError($errorMessage, $currentPhpScript);

	}
}
if($userRole =="global_admin"){
	$userCanManageJobsiteDailyLog = $userCanViewJobsiteDailyLog = $userCanManageJobsiteDailyLogAdmin=$userCanDcrReport=1;
}


$project = Project::findById($database, $project_id);
/* @var $project Project */

$htmlMessages = $message->getFormattedHtmlMessages($currentPhpScript);

if (!isset($htmlCss)) {
	$htmlCss = '';
}
$htmlCss .= <<<END_HTML_CSS
<link href="/css/modules-jobsite-daily-logs.css" rel="stylesheet">
	<link href="/css/modules-daily-construction-report.css" rel="stylesheet">
		<link href="/css/slideshow.css" rel="stylesheet">
END_HTML_CSS;

//<script src="/js/jobsite_daily_activity_logs-js.js"></script>

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= <<<END_HTML_JAVASCRIPT_BODY
<script src="/js/generated/jobsite_activity_labels-js.js"></script>
	<script src="/js/generated/jobsite_activity_list_templates-js.js"></script>
	<script src="/js/generated/jobsite_building_activities-js.js"></script>
	<script src="/js/generated/jobsite_building_activities_to_cost_codes-js.js"></script>
	<script src="/js/generated/jobsite_building_activity_templates-js.js"></script>
	<script src="/js/generated/jobsite_building_activity_templates_to_cost_codes-js.js"></script>
	<script src="/js/generated/jobsite_buildings-js.js"></script>
	<script src="/js/generated/jobsite_delays-js.js"></script>
	<script src="/js/generated/jobsite_field_reports-js.js"></script>
	<script src="/js/generated/jobsite_inspections-js.js"></script>
	<script src="/js/generated/jobsite_man_power-js.js"></script>
	<script src="/js/generated/jobsite_notes-js.js"></script>
	<script src="/js/generated/jobsite_offsitework_activities-js.js"></script>
	<script src="/js/generated/jobsite_offsitework_activities_to_cost_codes-js.js"></script>
	<script src="/js/generated/jobsite_offsitework_activity_templates-js.js"></script>
	<script src="/js/generated/jobsite_offsitework_activity_templates_to_cost_codes-js.js"></script>
	<script src="/js/generated/jobsite_offsitework_regions-js.js"></script>
	<script src="/js/generated/jobsite_photos-js.js"></script>
	<script src="/js/generated/jobsite_sign_in_sheets-js.js"></script>
	<script src="/js/generated/jobsite_sitework_activities-js.js"></script>
	<script src="/js/generated/jobsite_sitework_activities_to_cost_codes-js.js"></script>
	<script src="/js/generated/jobsite_sitework_activity_templates-js.js"></script>
	<script src="/js/generated/jobsite_sitework_activity_templates_to_cost_codes-js.js"></script>
	<script src="/js/generated/jobsite_sitework_regions-js.js"></script>

	<script src="/js/modules-jobsite-daily-logs.js"></script>
	<script src="/js/slideshow.js"></script>
END_HTML_JAVASCRIPT_BODY;

$htmlDoctype = '<!DOCTYPE html>';
$htmlTitle = 'Daily Log - MyFulcrum.com';
$htmlBody = '';

if (isset($get) && ($get->mobile == 1)) {
	$useMobileTemplatesFlag = true;
} else {
	$useMobileTemplatesFlag = false;
}

require('template-assignments/main.php');

$jobsite_daily_log_id = null;
$tab = '1';
$filterByManpowerFlag = false;

// Date logic.
$selectedDateIndex = '0';
$jobsite_daily_log_created_date = date('Y-m-d');
$todayAsMysqlDate = $jobsite_daily_log_created_date;
$today = date('F j, Y');
$interval = 60 * 60 * 24;
$yesterday = date('F j, Y', time() - $interval);
$interval *= 2;
$twoDaysAgo = date('F j, Y', time() - $interval);

$subtab = '';
$subsubtab = '';
$jobsite_activity_list_template_id = null;
if (isset($get) && !empty($get)) {

	// Actively Selected "Tab"
	if (!empty($get->tab)) {
		$tab = (string) $get->tab;
	}

	// Actively Selected "subtab"
	if (!empty($get->subtab)) {
		$subtab = (string) $get->subtab;
	}

	// Actively Selected "subsubtab"
	if (!empty($get->subsubtab)) {
		$subsubtab = (string) $get->subsubtab;
	}

	if (!empty($get->jobsite_activity_list_template_id)) {
		$jobsite_activity_list_template_id = (string) $get->jobsite_activity_list_template_id;
	}

	$filterByManpower = (string) $get->filterByManpower;
	if (!empty($filterByManpower) && ($filterByManpower == '1')) {
		$filterByManpowerFlag = true;
	}

	// jobsite_daily_log_id from jobsite_daily_logs table
	if (!empty($get->jobsite_daily_log_id)) {
		$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
	}

	// date
	if (!empty($get->date)) {
		$queryStringDateCreated = (string) $get->date;
		$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $queryStringDateCreated);
		/* @var $jobsiteDailyLog JobsiteDailyLog */
		if ($jobsiteDailyLog) {
			$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
			$created_by_contact_id = $jobsiteDailyLog->created_by_contact_id;
			if (!isset($created_by_contact_id) || empty($created_by_contact_id)) {
				$data = array(
					'created_by_contact_id' => $currentlyActiveContactId
				);
				$jobsiteDailyLog->setData();
				$jobsiteDailyLog->save();
				$jobsiteDailyLog->created_by_contact_id = $currentlyActiveContactId;
				$jobsiteDailyLog->convertPropertiesToData();
			}
		} else {
			if($currentlyActiveContactId && $project_id && $jobsite_daily_log_created_date){
				$created_by_contact_id = $currentlyActiveContactId;
				$jobsiteDailyLog = new JobsiteDailyLog($database);
				$jobsiteDailyLog->project_id = $project_id;
				$jobsiteDailyLog->jobsite_daily_log_created_date = $queryStringDateCreated;
				$jobsiteDailyLog->modified_by_contact_id = $currentlyActiveContactId;
				$jobsiteDailyLog->created_by_contact_id = $created_by_contact_id;
				$jobsiteDailyLog->convertPropertiesToData();
				$jobsite_daily_log_id = $jobsiteDailyLog->save();
		 	}
		}

		// Reformat date to match date dropdown.
		$timestamp = strtotime($queryStringDateCreated);
		$date = date('F j, Y', $timestamp);
		if ($date === $yesterday) {
			$selectedDateIndex = '1';
		} elseif ($date === $twoDaysAgo) {
			$selectedDateIndex = '2';
		}
	}

	if (!empty($get->dcr)) {

		if (isset($jobsite_daily_log_id)) {

			$jobsiteDailyLog = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$jobsite_daily_log_created_date = $jobsiteDailyLog->jobsite_daily_log_created_date;

		} else {

			if (!isset($jobsite_daily_log_created_date) || empty($jobsite_daily_log_created_date)) {
				$jobsite_daily_log_created_date = date('Y-m-d');
			}

			$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $jobsite_daily_log_created_date);
			/* @var $jobsiteDailyLog JobsiteDailyLog */

			if ($jobsiteDailyLog) {

				$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
				$created_by_contact_id = $jobsiteDailyLog->created_by_contact_id;

			} else {
        		if($currentlyActiveContactId && $project_id && $jobsite_daily_log_created_date){
					$created_by_contact_id = $currentlyActiveContactId;
					$jobsiteDailyLog = new JobsiteDailyLog($database);
					$jobsiteDailyLog->project_id = $project_id;
					$jobsiteDailyLog->jobsite_daily_log_created_date = $jobsite_daily_log_created_date;
					$jobsiteDailyLog->created_by_contact_id = $created_by_contact_id;
					$jobsiteDailyLog->convertPropertiesToData();
					$jobsite_daily_log_id = $jobsiteDailyLog->save();
        		}
			}

			$jobsiteDailyLog = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */

		}


		$fileManagerFile = generateDailyConstructionReport($database, $jobsiteDailyLog, true);
		/* @var $fileManagerFile FileManagerFile */

		// PDF Link
		if ($fileManagerFile) {
			$project = $fileManagerFile->getProject();
			/* @var $project Project */
			$project->htmlEntityEscapeProperties();
			$escaped_project_name = $project->escaped_project_name;

			$fileUrl = $fileManagerFile->generateUrl();
			$virtual_file_name = $fileManagerFile->virtual_file_name;
			$id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
			$htmlContent = '<b>' . $escaped_project_name . ' DCR PDF:</b> <a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$fileUrl.'" title="'.$virtual_file_name.'">'.$virtual_file_name.'</a>';
			$htmlContent .= '<br><br><input onclick="javascript:alert(\'Add This Feature\');" type="button" value="Email DCR To Yourself">';
			$htmlContent .= '<br><br><input onclick="window.location=\'/dcr-dailylog-jobs.php'.$id.'\'; return false;" type="button" value="Email DCR To Recipients">';
			$htmlContent .= '<br><br><a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="/dcr-dailylog-jobs.php'.$id.'">Email DCR To Recipients</a>';
			echo $htmlContent;
		}

		exit;
	}
}

$todayPrefix = 'Today, ';
$yesterdayPrefix = 'Yesterday, ';
$twoDaysAgoPrefix = date('l', time() - $interval) . ', ';

$today = $todayPrefix . $today;
$yesterday = $yesterdayPrefix . $yesterday;
$twoDaysAgo = $twoDaysAgoPrefix . $twoDaysAgo;

if (!isset($jobsite_daily_log_id)) {
	$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $jobsite_daily_log_created_date);
	/* @var $jobsiteDailyLog JobsiteDailyLog */

	if ($jobsiteDailyLog) {
		$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
		$created_by_contact_id = $jobsiteDailyLog->created_by_contact_id;
	} else {
		if($currentlyActiveContactId && $project_id && $jobsite_daily_log_created_date){
			$created_by_contact_id = $currentlyActiveContactId;
			$jobsiteDailyLog = new JobsiteDailyLog($database);
			$jobsiteDailyLog->project_id = $project_id;
			$jobsiteDailyLog->jobsite_daily_log_created_date = $jobsite_daily_log_created_date;
			// $jobsiteDailyLog->created_by_contact_id = $created_by_contact_id;
			$jobsiteDailyLog->convertPropertiesToData();
			if($userCanManageJobsiteDailyLog || $userCanManageJobsiteDailyLogAdmin)
			{
			$jobsite_daily_log_id = $jobsiteDailyLog->save();
			}
  	}
	}
}

if($created_by_contact_id){
	$createdByContact = Contact::findById($database, $created_by_contact_id);
	/* @var $createdByContact Contact */
	$createdByContactFullNameHtmlEscaped = $createdByContact->getContactFullNameHtmlEscaped();
}


$modified_by_contact_id = $jobsiteDailyLog->modified_by_contact_id;
if (isset($modified_by_contact_id) && !empty($modified_by_contact_id)) {
	$modifiedByContact = Contact::findById($database, $modified_by_contact_id);
	/* @var $modifiedByContact Contact */
	$modifiedBy = $modifiedByContact->getContactFullName();
} else {
	$modifiedBy = '';
}

$jobsite_daily_log_created_date = $jobsiteDailyLog->jobsite_daily_log_created_date;
$createdHumanReadable = strtotime($jobsite_daily_log_created_date);
$createdAt = date('F j, Y', $createdHumanReadable);

$modified = $jobsiteDailyLog->modified;
if ($modified) {
	$modifiedHumanReadable = strtotime($modified);
	$modifiedAt = date('F j, Y g:ia', $modifiedHumanReadable);
} else {
	$modifiedAt = '';
}

// Weather data.


$arrReturn = getAmPmWeatherTemperaturesAndConditions($database, $project_id, $jobsite_daily_log_created_date);
$amTemperature = $arrReturn['amTemperature'];
$amCondition   = $arrReturn['amCondition'];
$pmTemperature = $arrReturn['pmTemperature'];
$pmCondition   = $arrReturn['pmCondition'];

// Template variables.

$tabContent = '';
$manpowerSelected = '';
$siteworkSelected = '';
$buildingSelected = '';
$detailsSelected  = '';
$previewSelected  = '';
$adminSelected    = '';
/*PDF restrict count*/
$GenerateId = GetCountOfValue($project_id,$jobsite_daily_log_created_date, $database);
$GetCount = getlogscount($GenerateId, $database);




switch ($tab) {
	case '1':
		$tabContent = buildManpowerSection($database, $user_company_id, $project_id, $jobsite_daily_log_id,$userCanViewJobsiteDailyLog,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin,$userCanDcrReport);
		$manpowerSelected = 'activeTabGreen';
		break;
	case '2':
		$tabContent = buildSiteworkSection($database, $project_id, $jobsite_daily_log_id, $filterByManpowerFlag,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin);
		$siteworkSelected = 'activeTabGreen';
		break;
	case '3':
		$tabContent = buildBuildingSection($database, $project_id, $jobsite_daily_log_id, $filterByManpowerFlag,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin);
		$buildingSelected = 'activeTabGreen';
		break;
	case '4':
		$tabContent = buildDetailsSection($database, $project_id, $jobsite_daily_log_id,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin);
		$detailsSelected = 'activeTabGreen';
		break;
	case '5':
		if($userCanDcrReport){
			$jobsiteDailyLog = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$tabContent = buildDCRPreviewSection($database, $jobsiteDailyLog, $user_company_id);
			$jobsiteDailyLogCreatedDate = $jobsiteDailyLog->jobsite_daily_log_created_date;
			$previewSelected = 'activeTabGreen';
			if($userCanManageJobsiteDailyLog || $userCanManageJobsiteDailyLogAdmin)
			{
				if($GetCount!=0){
					$tabContent = '<div align="right" style="padding: 2px 0 0 0; margin: 0;"><a href="/modules-jobsite-daily-logs-form.php?tab=5&dcr=1&date='.$jobsiteDailyLogCreatedDate.'" target="_blank" class="btn-cmn" style="color: white; text-decoration:none;">Render DCR PDF</a>&nbsp;&nbsp;</div>' . $tabContent;
				}else{
					$disabls='disabled=disabled';
					$tabContent = '<div align="right" style="padding: 2px 0 0 0; margin: 0;"><a onclick="NoDataToGenerate()" disabled="disabled" href="#" class="btn-cmn" style="color: white; text-decoration:none;">Render DCR PDF</a>&nbsp;&nbsp;</div>' . $tabContent;
				}
			}
		}else{
			$tabContent = '';
		}

		break;
	case '6':
		// Permissions
		if ($userCanManageJobsiteDailyLogAdmin) {
			$tabContent = buildAdminSection($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $subtab, $subsubtab, $jobsite_activity_list_template_id);
			$adminSelected = 'activeTabGreen';
		} else {
			$tabContent = '';
		}
		break;
	default:
		$tabContent = buildManpowerSection($database, $user_company_id, $project_id, $jobsite_daily_log_id,$userCanViewJobsiteDailyLog,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin,$userCanDcrReport);
		$manpowerSelected = 'activeTabGreen';
		$tab = '1';
		break;
}

// Admin Tab Permissions - Display Admin Tab
if ($userCanManageJobsiteDailyLogAdmin) {
	$displayJobsiteDailyLogAdminTab = 1;
} else {
	$displayJobsiteDailyLogAdminTab = 0;
}

$template->assign('selectedDateIndex', $selectedDateIndex);
$template->assign('jobsite_daily_log_id', $jobsite_daily_log_id);
$template->assign('activeTab', $tab);
$template->assign('today', $today);
$template->assign('yesterday', $yesterday);
$template->assign('twoDaysAgo', $twoDaysAgo);
$template->assign('tabContent', $tabContent);
$template->assign('manpowerSelected', $manpowerSelected);
$template->assign('siteworkSelected', $siteworkSelected);
$template->assign('buildingSelected', $buildingSelected);
$template->assign('detailsSelected',  $detailsSelected);
$template->assign('previewSelected',  $previewSelected);
$template->assign('adminSelected',    $adminSelected);
$template->assign('displayJobsiteDailyLogAdminTab', $displayJobsiteDailyLogAdminTab);
$template->assign('userCanDcrReport', $userCanDcrReport);


$template->assign('createdBy', $createdByContactFullNameHtmlEscaped);
$template->assign('modifiedBy', $modifiedBy);
$template->assign('createdAt', $createdAt);
$template->assign('modifiedAt', $modifiedAt);

$template->assign('amTemperature', $amTemperature);
$template->assign('pmTemperature', $pmTemperature);
$template->assign('amCondition', $amCondition);
$template->assign('pmCondition', $pmCondition);

$fineUploaderTemplate = FineUploader::renderTemplate();
$template->assign('fineUploaderTemplate', $fineUploaderTemplate);


$htmlContent = $template->fetch('modules-jobsite-daily-logs-form.tpl');
$template->assign('htmlContent', $htmlContent);
$template->display('master-web-html5.tpl');
exit;

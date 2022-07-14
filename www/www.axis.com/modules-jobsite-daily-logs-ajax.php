<?php
try {

/**
 * Daily Log Module.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = true;
$init['get_maxlength'] = 16777215;
$init['get_required'] = true;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['skip_session'] = false;
$init['skip_templating'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');
require_once('renderPDF.php');
// PERMISSION VARIABLES
require_once('app/models/permission_mdl.php');

$userCanViewJobsiteDailyLog = checkPermissionForAllModuleAndRole($database,'jobsite_daily_logs_view');
$userCanManageJobsiteDailyLog = checkPermissionForAllModuleAndRole($database,'jobsite_daily_logs_manage');
$userCanManageJobsiteDailyLogAdmin = checkPermissionForAllModuleAndRole($database,'jobsite_daily_logs_admin_manage');
$userCanDcrReport = checkPermissionForAllModuleAndRole($database,'daily_construction_report');
// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}


require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */

require_once('modules-jobsite-daily-logs-functions.php');


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

if (!$userCanViewJobsiteDailyLog) {
	// Error and exit
	$errorMessage = 'Permission denied.';
	$message->enqueueError($errorMessage, $currentPhpScript);
}
if($userRole =="global_admin")
{
	$userCanManageJobsiteDailyLog = $userCanViewJobsiteDailyLog = $userCanManageJobsiteDailyLogAdmin=$userCanDcrReport=1;
}

ob_start();

switch ($methodCall) {
	case 'renderTabContent':

		$jobsite_daily_log_id = null;
		$tab = '';
		$subtab = '';
		$subsubtab = '';
		$jobsite_activity_list_template_id = null;
		$filterByManpowerFlag = false;

		if (isset($get) && !empty($get)) {

			// Actively Selected "Tab"
			if (!empty($get->tab)) {
				$tab = (string) $get->tab;
			}

			// Actively Selected "subtab"
			if (!empty($get->subtab)) {
				$subtab = (string) $get->subtab;
			}

			// Actively Selected "subtab"
			if (!empty($get->subsubtab)) {
				$subsubtab = (string) $get->subsubtab;
			}

			if (!empty($get->jobsite_activity_list_template_id)) {
				$jobsite_activity_list_template_id = (string) $get->jobsite_activity_list_template_id;
			}

			// jobsite_daily_log_id from jobsite_daily_logs table
			if (!empty($get->jobsite_daily_log_id)) {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			}

			// jobsite_daily_log_id from jobsite_daily_logs table
			$filterByManpower = $get->filterByManpower;
			if (!empty($filterByManpower)) {
				$filterByManpowerFlag = true;
			}

		}

		if (!isset($jobsite_daily_log_id)) {
			$jobsite_daily_log_created_date = date('Y-m-d');
			$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $jobsite_daily_log_created_date);
			if ($jobsiteDailyLog) {
				$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
			} else {
				$jobsiteDailyLog = new JobsiteDailyLog($database);
				$jobsiteDailyLog->project_id = $project_id;
				$jobsiteDailyLog->jobsite_daily_log_created_date = $jobsite_daily_log_created_date;
				$jobsiteDailyLog->convertPropertiesToData();
				$jobsite_daily_log_id = $jobsiteDailyLog->save();
			}
		}

		switch ($tab) {
			case '1':
				$tabContent = buildManpowerSection($database, $user_company_id, $project_id, $jobsite_daily_log_id,$userCanViewJobsiteDailyLog,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin,$userCanDcrReport);
				echo $tabContent;
			break;
			case '2':
				$tabContent = buildSiteworkSection($database, $project_id, $jobsite_daily_log_id, $filterByManpowerFlag,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin);
				echo $tabContent;
			break;
			case '3':
				$tabContent = buildBuildingSection($database, $project_id, $jobsite_daily_log_id, $filterByManpowerFlag,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin);
				echo $tabContent;
			break;
			case '4':
				$tabContent = buildDetailsSection($database, $project_id, $jobsite_daily_log_id,$userCanManageJobsiteDailyLog,$userCanManageJobsiteDailyLogAdmin);
				echo $tabContent;
			break;
			case '5':
				if($userCanDcrReport){ 
					$jobsiteDailyLog = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $jobsite_daily_log_id);
					/* @var $jobsiteDailyLog JobsiteDailyLog */
					$tabContent = buildDCRPreviewSection($database, $jobsiteDailyLog, $user_company_id);
					$jobsiteDailyLogCreatedDate = $jobsiteDailyLog->jobsite_daily_log_created_date;
					/*PDF restrict count*/
					$GenerateId = GetCountOfValue($project_id,$jobsiteDailyLogCreatedDate, $database);
					$GetCount = getlogscount($GenerateId, $database);
					if($userCanManageJobsiteDailyLog || $userCanManageJobsiteDailyLogAdmin)
					{
					if($GetCount!=0){
						$tabContent = '<div align="right" style="padding: 2px 0 0 0; margin: 0;"><a href="/modules-jobsite-daily-logs-form.php?tab=5&dcr=1&date='.$jobsiteDailyLogCreatedDate.'" target="_blank" class="btn-cmn" style="color: white; text-decoration:none;">Render DCR PDF</a>&nbsp;&nbsp;</div>' . $tabContent;
					}else{
						$tabContent = '<div align="right" style="padding: 2px 0 0 0; margin: 0;"><a onclick="NoDataToGenerate()"  href="#" disabled="disabled" class="btn-cmn" style="color: white; text-decoration:none;">Render DCR PDF</a>&nbsp;&nbsp;</div>' . $tabContent;
					}
					}
				}else{
					$tabContent = '';
				}
				echo $tabContent;
			break;
			case '6':
				// Permissions
				if ($userCanManageJobsiteDailyLogAdmin) {
					$tabContent = buildAdminSection($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $subtab, $subsubtab, $jobsite_activity_list_template_id);
					$adminSelected = 'activeTabGreen';
				} else {
					$tabContent = '';
				}
				echo $tabContent;
				break;
			default:
				$tabContent = buildManpowerSection($database, $user_company_id, $project_id, $jobsite_daily_log_id);
				echo $tabContent;
			break;
		}

	break;
		
	case 'UpdatemodifiedContents':

		$project_id = $get->project_id;
		$jobsite_daily_log_id = $get->jobsite_daily_log_id;
		$calc_date =$get->jobsite_daily_date;
		if($calc_date == "undefined" || $calc_date == "" )
		{
			$calc_date =  date('Y-m-d');
		}
		$arrResData=UpdateModifiedContentsData($database, $project_id,$jobsite_daily_log_id,$calc_date);

		echo json_encode($arrResData);
	break;

	case 'toggleJobsiteActivity':

		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Daily Activity Log';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Check permissions - manage
			if (!$userCanManageJobsiteDailyLog) {
				// Error and exit
				$errorMessage = 'Permission denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

			// Get primary key / unique key via get input
			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
			$attributeName = (string) $get->attributeName;
			$formattedAttributeName = (string) $get->formattedAttributeName;
			$uniqueId = (string) $get->uniqueId;
			$newValue = (string) $get->newValue;

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Activity Log';
			}

			// Unique index attibutes
			if ($get->jobsite_daily_log_id) {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			} else {
				$jobsite_daily_log_id = null;
			}
			if ($get->jobsite_activity_id) {
				$jobsite_activity_id = (int) $get->jobsite_activity_id;
			} else {
				$jobsite_activity_id = null;
			}
			if ($attributeSubgroupName == 'jobsite_daily_building_activity_logs') {
				// jobsite_building_activities
				$jobsite_building_activity_id = $jobsite_activity_id;
				$get->jobsite_building_activity_id = $jobsite_building_activity_id;

				// jobsite_buildings
				if ($get->jobsite_building_id) {
					$jobsite_building_id = (int) $get->jobsite_building_id;
				} else {
					$jobsite_building_id = null;
				}
			} elseif ($attributeSubgroupName == 'jobsite_daily_offsitework_activity_logs') {
				// jobsite_offsitework_activities
				$jobsite_offsitework_activity_id = $jobsite_activity_id;
				$get->jobsite_offsitework_activity_id = $jobsite_offsitework_activity_id;

				// jobsite_offsitework_regions
				if ($get->jobsite_offsitework_region_id) {
					$jobsite_offsitework_region_id = (int) $get->jobsite_offsitework_region_id;
				} else {
					$jobsite_offsitework_region_id = null;
				}
			} elseif ($attributeSubgroupName == 'jobsite_daily_sitework_activity_logs') {
				// jobsite_sitework_activities
				$jobsite_sitework_activity_id = $jobsite_activity_id;
				$get->jobsite_sitework_activity_id = $jobsite_sitework_activity_id;

				// jobsite_sitework_regions
				if ($get->jobsite_sitework_region_id) {
					$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;
				} else {
					$jobsite_sitework_region_id = null;
				}
			}

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'jobsite_daily_building_activity_log_id' => 'jobsite daily_building activity log id',
				'jobsite_daily_offsitework_activity_log_id' => 'jobsite daily_offsitework activity log id',
				'jobsite_daily_sitework_activity_log_id' => 'jobsite daily_sitework activity log id',
				'jobsite_daily_log_id' => 'jobsite daily log id',
				'jobsite_building_activity_id' => 'jobsite building activity id',
				'cost_code_id' => 'cost code id',
				'jobsite_offsitework_activity_id' => 'jobsite offsitework activity id',
				'jobsite_sitework_activity_id' => 'jobsite sitework activity id',
				'jobsite_building_id' => 'jobsite building id',
				'jobsite_offsitework_region_id' => 'jobsite offsitework region id',
				'jobsite_sitework_region_id' => 'jobsite sitework region id',
			);

			if (isset($arrAllowableAttributes[$attributeName])) {
				// Allow formatted attribute name to be passed in
				if (!isset($formattedAttributeName) || empty($formattedAttributeName)) {
					$formattedAttributeName = $arrAllowableAttributes[$attributeName];
					$arrTmp = explode(' ', $formattedAttributeName);
					$arrFormattedAttributeName = array_map('ucfirst', $arrTmp);
					$formattedAttributeName = join(' ', $arrFormattedAttributeName);
				}
			} else {
				$errorMessage = 'Invalid attribute.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($attributeSubgroupName == 'jobsite_daily_building_activity_logs') {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
				$jobsite_building_activity_id = (int) $get->jobsite_activity_id;
				$cost_code_id = (int) $get->cost_code_id;
				$jobsite_building_id = 1;

				$jobsiteDailyBuildingActivityLog =
					JobsiteDailyBuildingActivityLog::findByJobsiteDailyLogIdAndJobsiteBuildingActivityId($database, $jobsite_daily_log_id, $jobsite_building_activity_id,$cost_code_id);

				if ($jobsiteDailyBuildingActivityLog) {
					if($newValue == "N")
					{
					$crudOperation = 'delete';
					$jobsiteDailyBuildingActivityLog->delete();
					$is_selected ='N';
				}
				} 
				if ($newValue == "Y"){
					$crudOperation = 'create';
					$newAttributeGroupName = '';
					$jobsiteDailyBuildingActivityLog = new JobsiteDailyBuildingActivityLog($database);
					$data = array(
						'jobsite_daily_log_id' => $jobsite_daily_log_id,
						'jobsite_building_activity_id' => $jobsite_building_activity_id,
						'jobsite_building_id' => $jobsite_building_id,
						'cost_code_id' => $cost_code_id
					);
					$jobsiteDailyBuildingActivityLog->setData($data);
					$jobsite_daily_building_activity_log_id = $jobsiteDailyBuildingActivityLog->save();
					$is_selected ='Y';
				}

				$errorNumber = 0;
				$errorMessage = '';
				$resetToPreviousValue = 'N';
				$message->reset($currentPhpScript);
				updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);

				$primaryKeyAsString = $jobsiteDailyBuildingActivityLog->getPrimaryKeyAsString();
			} elseif ($attributeSubgroupName == 'jobsite_daily_offsitework_activity_logs') {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
				$jobsite_offsitework_activity_id = (int) $get->jobsite_activity_id;
				$jobsite_offsitework_region_id = 1;

				$jobsiteDailyOffsiteworkActivityLog =
					JobsiteDailyOffsiteworkActivityLog::findByJobsiteDailyLogIdAndJobsiteOffsiteworkActivityId($database, $jobsite_daily_log_id, $jobsite_offsitework_activity_id);

				if ($jobsiteDailyOffsiteworkActivityLog) {
					$crudOperation = 'delete';
					$jobsiteDailyOffsiteworkActivityLog->delete();
				} else {
					$crudOperation = 'create';
					$newAttributeGroupName = '';
					$jobsiteDailyOffsiteworkActivityLog = new JobsiteDailyOffsiteworkActivityLog($database);
					$data = array(
						'jobsite_daily_log_id' => $jobsite_daily_log_id,
						'jobsite_offsitework_activity_id' => $jobsite_offsitework_activity_id,
						'jobsite_offsitework_region_id' => $jobsite_offsitework_region_id
					);
					$jobsiteDailyOffsiteworkActivityLog->setData($data);
					$jobsite_daily_offsitework_activity_log_id = $jobsiteDailyOffsiteworkActivityLog->save();
				}

				$errorNumber = 0;
				$errorMessage = '';
				$resetToPreviousValue = 'N';
				$message->reset($currentPhpScript);
				updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);

				$primaryKeyAsString = $jobsiteDailyOffsiteworkActivityLog->getPrimaryKeyAsString();
			} elseif ($attributeSubgroupName == 'jobsite_daily_sitework_activity_logs') {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
				$jobsite_sitework_activity_id = (int) $get->jobsite_activity_id;
				$jobsite_sitework_region_id = 1;

				$jobsiteDailySiteworkActivityLog =
					JobsiteDailySiteworkActivityLog::findByJobsiteDailyLogIdAndJobsiteSiteworkActivityId($database, $jobsite_daily_log_id, $jobsite_sitework_activity_id);

				if ($jobsiteDailySiteworkActivityLog) {
					$crudOperation = 'delete';
					$jobsiteDailySiteworkActivityLog->delete();
				} else {
					$crudOperation = 'create';
					$newAttributeGroupName = '';
					$jobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);
					$data = array(
						'jobsite_daily_log_id' => $jobsite_daily_log_id,
						'jobsite_sitework_activity_id' => $jobsite_sitework_activity_id,
						'jobsite_sitework_region_id' => $jobsite_sitework_region_id
					);
					$jobsiteDailySiteworkActivityLog->setData($data);
					$jobsite_daily_sitework_activity_log_id = $jobsiteDailySiteworkActivityLog->save();
				}

				$errorNumber = 0;
				$errorMessage = '';
				$resetToPreviousValue = 'N';
				$message->reset($currentPhpScript);
				updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);

				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$attributeName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$formattedAttributeName|$resetToPreviousValue|$performRefreshOperation";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'toggleJobsiteActivityToCostCode':

		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Daily Activity Log';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Check permissions - manage
			if (!$userCanManageJobsiteDailyLog) {
				// Error and exit
				$errorMessage = 'Permission denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

			// Get primary key / unique key via get input
			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
			$attributeName = (string) $get->attributeName;
			$formattedAttributeName = (string) $get->formattedAttributeName;
			$uniqueId = (string) $get->uniqueId;
			$newValue = (string) $get->newValue;

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Activity Log';
			}

			// Unique index attibutes
			if ($get->jobsite_daily_log_id) {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			} else {
				$jobsite_daily_log_id = null;
			}
			if ($get->jobsite_activity_id) {
				$jobsite_activity_id = (int) $get->jobsite_activity_id;
			} else {
				$jobsite_activity_id = null;
			}
			if ($attributeSubgroupName == 'jobsite_daily_building_activity_logs') {
				// jobsite_building_activities
				$jobsite_building_activity_id = $jobsite_activity_id;
				$get->jobsite_building_activity_id = $jobsite_building_activity_id;

				// jobsite_buildings
				if ($get->jobsite_building_id) {
					$jobsite_building_id = (int) $get->jobsite_building_id;
				} else {
					$jobsite_building_id = null;
				}
			} elseif ($attributeSubgroupName == 'jobsite_daily_offsitework_activity_logs') {
				// jobsite_offsitework_activities
				$jobsite_offsitework_activity_id = $jobsite_activity_id;
				$get->jobsite_offsitework_activity_id = $jobsite_offsitework_activity_id;

				// jobsite_offsitework_regions
				if ($get->jobsite_offsitework_region_id) {
					$jobsite_offsitework_region_id = (int) $get->jobsite_offsitework_region_id;
				} else {
					$jobsite_offsitework_region_id = null;
				}
			} elseif ($attributeSubgroupName == 'jobsite_daily_sitework_activity_logs') {
				// jobsite_sitework_activities
				$jobsite_sitework_activity_id = $jobsite_activity_id;
				$get->jobsite_sitework_activity_id = $jobsite_sitework_activity_id;

				// jobsite_sitework_regions
				if ($get->jobsite_sitework_region_id) {
					$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;
				} else {
					$jobsite_sitework_region_id = null;
				}
			}

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'jobsite_daily_building_activity_log_id' => 'jobsite daily_building activity log id',
				'jobsite_daily_offsitework_activity_log_id' => 'jobsite daily_offsitework activity log id',
				'jobsite_daily_sitework_activity_log_id' => 'jobsite daily_sitework activity log id',
				'jobsite_daily_log_id' => 'jobsite daily log id',
				'jobsite_building_activity_id' => 'jobsite building activity id',
				'jobsite_offsitework_activity_id' => 'jobsite offsitework activity id',
				'jobsite_sitework_activity_id' => 'jobsite sitework activity id',
				'jobsite_building_id' => 'jobsite building id',
				'jobsite_offsitework_region_id' => 'jobsite offsitework region id',
				'jobsite_sitework_region_id' => 'jobsite sitework region id',
			);

			if (isset($arrAllowableAttributes[$attributeName])) {
				// Allow formatted attribute name to be passed in
				if (!isset($formattedAttributeName) || empty($formattedAttributeName)) {
					$formattedAttributeName = $arrAllowableAttributes[$attributeName];
					$arrTmp = explode(' ', $formattedAttributeName);
					$arrFormattedAttributeName = array_map('ucfirst', $arrTmp);
					$formattedAttributeName = join(' ', $arrFormattedAttributeName);
				}
			} else {
				$errorMessage = 'Invalid attribute.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($attributeSubgroupName == 'jobsite_daily_building_activity_logs') {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
				$jobsite_building_activity_id = (int) $get->jobsite_activity_id;
				$jobsite_building_id = 1;

				$jobsiteDailyBuildingActivityLog =
					JobsiteDailyBuildingActivityLog::findByJobsiteDailyLogIdAndJobsiteBuildingActivityId($database, $jobsite_daily_log_id, $jobsite_building_activity_id);

				if ($jobsiteDailyBuildingActivityLog) {
					$jobsiteDailyBuildingActivityLog->delete();
				} else {
					$jobsiteDailyBuildingActivityLog = new JobsiteDailyBuildingActivityLog($database);
					$data = array(
						'jobsite_daily_log_id' => $jobsite_daily_log_id,
						'jobsite_building_activity_id' => $jobsite_building_activity_id,
						'jobsite_building_id' => $jobsite_building_id
					);
					$jobsiteDailyBuildingActivityLog->setData($data);
					$jobsite_daily_building_activity_log_id = $jobsiteDailyBuildingActivityLog->save();
				}

				$errorNumber = 0;
				$errorMessage = '';
				$resetToPreviousValue = 'N';
				$message->reset($currentPhpScript);
				updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);

				$primaryKeyAsString = $jobsiteDailyBuildingActivityLog->getPrimaryKeyAsString();
			} elseif ($attributeSubgroupName == 'jobsite_daily_offsitework_activity_logs') {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
				$jobsite_offsitework_activity_id = (int) $get->jobsite_activity_id;
				$jobsite_offsitework_region_id = 1;

				$jobsiteDailyOffsiteworkActivityLog =
					JobsiteDailyOffsiteworkActivityLog::findByJobsiteDailyLogIdAndJobsiteOffsiteworkActivityId($database, $jobsite_daily_log_id, $jobsite_offsitework_activity_id);

				if ($jobsiteDailyOffsiteworkActivityLog) {
					$jobsiteDailyOffsiteworkActivityLog->delete();
				} else {
					$jobsiteDailyOffsiteworkActivityLog = new JobsiteDailyOffsiteworkActivityLog($database);
					$data = array(
						'jobsite_daily_log_id' => $jobsite_daily_log_id,
						'jobsite_offsitework_activity_id' => $jobsite_offsitework_activity_id,
						'jobsite_offsitework_region_id' => $jobsite_offsitework_region_id
					);
					$jobsiteDailyOffsiteworkActivityLog->setData($data);
					$jobsite_daily_offsitework_activity_log_id = $jobsiteDailyOffsiteworkActivityLog->save();
				}

				$errorNumber = 0;
				$errorMessage = '';
				$resetToPreviousValue = 'N';
				$message->reset($currentPhpScript);
				updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);

				$primaryKeyAsString = $jobsiteDailyOffsiteworkActivityLog->getPrimaryKeyAsString();
			} elseif ($attributeSubgroupName == 'jobsite_daily_sitework_activity_logs') {
				$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
				$jobsite_sitework_activity_id = (int) $get->jobsite_activity_id;
				$jobsite_sitework_region_id = 1;

				$jobsiteDailySiteworkActivityLog =
					JobsiteDailySiteworkActivityLog::findByJobsiteDailyLogIdAndJobsiteSiteworkActivityId($database, $jobsite_daily_log_id, $jobsite_sitework_activity_id);

				if ($jobsiteDailySiteworkActivityLog) {
					$jobsiteDailySiteworkActivityLog->delete();
				} else {
					$jobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);
					$data = array(
						'jobsite_daily_log_id' => $jobsite_daily_log_id,
						'jobsite_sitework_activity_id' => $jobsite_sitework_activity_id,
						'jobsite_sitework_region_id' => $jobsite_sitework_region_id
					);
					$jobsiteDailySiteworkActivityLog->setData($data);
					$jobsite_daily_sitework_activity_log_id = $jobsiteDailySiteworkActivityLog->save();
				}

				$errorNumber = 0;
				$errorMessage = '';
				$resetToPreviousValue = 'N';
				$message->reset($currentPhpScript);
				updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);

				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$attributeName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$formattedAttributeName|$resetToPreviousValue|$performRefreshOperation|$previousId";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'uploadFiles':

		$project_id = $get->project_id;
		$file_manager_folder_id = $get->folder_id;
		$virtual_file_path = $get->virtual_file_path;
		$virtual_file_name = $get->virtual_file_name;
		$allowed_extensions = $get->allowed_extensions;

		$folder_id_exists = false;
		if (isset($file_manager_folder_id) && !empty($file_manager_folder_id)) {
			$folder_id_exists = true;
		}

		$project_id_and_virtual_file_path_exists = false;
		if (isset($virtual_file_path) && !empty($virtual_file_path) && isset($project_id) && !empty($project_id)) {
			$project_id_and_virtual_file_path_exists = true;
		}

		// output a json_encoded() success message
		$jsonOutput = json_encode(array('success'=> "File upload successful."));

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		exit(0);

	break;

	case 'loadImportJobsiteActivitiesDialog':

		// Potentially Import:

		// Project Scope
		// jobsite_activity_labels into jobsite_building_activities, jobsite_offsitework_activities, jobsite_sitework_activities
		// jobsite_building_activities from other projects into jobsite_building_activities
		// jobsite_offsitework_activities from other projects into jobsite_offsitework_activities
		// jobsite_sitework_activities from other projects into jobsite_sitework_activities

		// Template Scope
		// jobsite_activity_labels into jobsite_building_activity_templates, jobsite_offsitework_activity_templates, jobsite_sitework_activity_templates
		// jobsite_building_activities from other projects into jobsite_building_activity_templates
		// jobsite_offsitework_activities from other projects into jobsite_offsitework_activity_templates
		// jobsite_sitework_activities from other projects into jobsite_sitework_activity_templates

		$datasource = $get->datasource;

		require('page-components/import_jobsite_activities.php');

		break;

	case 'importJobsiteActivities':

		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error importing data';
			$message->enqueueError($errorMessage, $currentPhpScript);


			// Get primary key / unique key via get input
			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
			$attributeName = (string) $get->attributeName;
			$formattedAttributeName = (string) $get->formattedAttributeName;
			$uniqueIds = (string) $get->uniqueIds;

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Activities';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Import Activities';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$success = importJobsiteActivities($database, $project_id, $attributeSubgroupName, $attributeName, $uniqueIds);

			if ($success) {
				$errorNumber = 0;
				$errorMessage = '';
				$resetToPreviousValue = 'N';
				$message->reset($currentPhpScript);
				$primaryKeyAsString = '';
			} else {
				$errorNumber = 1;
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();
			$errorNumber = 1;

		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$attributeName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$formattedAttributeName|$resetToPreviousValue|$performRefreshOperation|$previousId";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadJobsiteActivitiesToCostCodesDialog':

		$jobsiteActivityTableName = $get->jobsiteActivityTableName;
		$jobsite_activity_id = $get->jobsite_activity_id;

		require('page-components/link_jobsite_activities_to_cost_codes.php');

	break;

	case 'loadJobsiteBuildingActivityTemplateDetailsDialog':

		// Ajax Handler Inputs
		require('code-generator/ajax-get-inputs.php');

		$jobsite_activity_list_template_id = $get->jobsite_activity_list_template_id;

		$tbody = '';
		$arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId =
			JobsiteBuildingActivityTemplate::loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId($database, $jobsite_activity_list_template_id);

		foreach ($arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId as $jobsite_activity_list_template_id => $jobsiteBuildingActivityTemplate) {
			/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */

			$jobsiteBuildingActivityTemplate->htmlEntityEscapeProperties();

			$escaped_jobsite_building_activity_label = $jobsiteBuildingActivityTemplate->escaped_jobsite_building_activity_label;
			$jobsite_building_activity_label = $jobsiteBuildingActivityTemplate->jobsite_building_activity_label;

			$tbody .= <<<END_TBODY

				<tr>
					<td class="textAlignCenter tdSortBars"><img src="/images/sortbars.png"></td>
					<td class="textAlignLeft">$escaped_jobsite_building_activity_label</td>
					<td class="textAlignCenter"><a href="#" onclick="deleteJobsiteBuildingActivity1(this); return false;">X</a></td>
				</tr>
END_TBODY;

		}

		$htmlContent = <<<END_HTML_CONTENT

		<div class="widgetContainer" style="font-size: 0.9em; width: 500px;">
			<h3 class="title">Create Jobsite Building Activity</h3>
			<table class="content" cellpadding="5px" width="95%">
				<tr>
					<td style="vertical-align: middle;">Label:</td>
					<td><input type="text" style="width:400px"></td>
				</tr>
				<tr>
					<td></td>
					<td class="textAlignRight"><input type="button" value="Create Jobsite Building Activity"></td>
				</tr>
			</table>
		</div>

		<table id="tableJobsiteBuildingActivityTemplateDetails" width="95%" cellpadding="5px" style="font-size:0.9em">
			<thead class="borderBottom">
				<tr>
					<th class="textAlignCenter" style="width:70px">Sort</th>
					<th class="textAlignLeft">Label</th>
					<th class="textAlignCenter" style="width:70px">Delete</th>
				</tr>
			</thead>
			<tbody class="altColors">
				$tbody
			</tbody>
		</table>
END_HTML_CONTENT;

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'toggleJobsiteActivityToCostCode1':

		$errorNumber = 1;
		$messageText = 'An error occurred.';

		try {

			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
			$attributeName = (string) $get->attributeName;
			$formattedAttributeName = (string) $get->formattedAttributeName;
			$uniqueId = (string) $get->uniqueId;
			$create = (int) $get->create;

			$tableName = $attributeSubgroupName . '_to_cost_codes';

			$attributeNames = explode('-', $attributeName);
			$jobsite_activity_id_attribute = $attributeNames[0];
			$cost_code_id_attribute = $attributeNames[1];


			$uniqueIds = explode('-', $uniqueId);
			$jobsite_activity_id = $uniqueIds[0];
			$cost_code_id = $uniqueIds[1];

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($create == 0) {
				$messageText = 'Cost code successfully unlinked from activity.';
				$query ="DELETE FROM $tableName
							WHERE `$jobsite_activity_id_attribute` = $jobsite_activity_id
						AND `$cost_code_id_attribute` = $cost_code_id";
			} elseif ($create == 1) {
				$messageText = 'Cost code successfully linked to activity.';
				$query ="INSERT INTO $tableName VALUES ($jobsite_activity_id, $cost_code_id)";
			}

			$db->execute($query);
			$db->free_result();

			$errorNumber = 0;

		} catch (Exception $e) {

		}

		$arrOutput = array(
			'errorNumber' => $errorNumber,
			'messageText' => $messageText
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

	case 'deleteJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId':
		$loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateIdOptions = new Input();
		$loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateIdOptions->forceLoadFlag = true;
		$jobsite_building_activity_template_id = $get->jobsite_building_activity_template_id;
		$arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId =
			JobsiteBuildingActivityTemplateToCostCode::loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId($database, $jobsite_building_activity_template_id, $loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateIdOptions);
		$arrJobsiteBuildingActivityTemplatesToCostCodes = $arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId[$jobsite_building_activity_template_id];
		foreach($arrJobsiteBuildingActivityTemplatesToCostCodes as $cost_code_id => $jobsiteBuildingActivityTemplateToCostCode) {
			$jobsiteBuildingActivityTemplateToCostCode->delete();
		}
	break;

	case 'deleteJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId':
		$loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateIdOptions = new Input();
		$loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateIdOptions->forceLoadFlag = true;
		$jobsite_sitework_activity_template_id = $get->jobsite_sitework_activity_template_id;
		$arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId =
			JobsiteSiteworkActivityTemplateToCostCode::loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId($database, $jobsite_sitework_activity_template_id, $loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateIdOptions);
		$arrJobsiteSiteworkActivityTemplatesToCostCodes = $arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId[$jobsite_sitework_activity_template_id];
		foreach($arrJobsiteSiteworkActivityTemplatesToCostCodes as $cost_code_id => $jobsiteSiteworkActivityTemplateToCostCode) {
			$jobsiteSiteworkActivityTemplateToCostCode->delete();
		}
	break;

	case 'deleteJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId':
		$loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateIdOptions = new Input();
		$loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateIdOptions->forceLoadFlag = true;
		$jobsite_offsitework_activity_template_id = $get->jobsite_offsitework_activity_template_id;
		$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId =
			JobsiteOffsiteworkActivityTemplateToCostCode::loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId($database, $jobsite_offsitework_activity_template_id, $loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateIdOptions);
		$arrJobsiteOffsiteworkActivityTemplatesToCostCodes = $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId[$jobsite_offsitework_activity_template_id];
		foreach($arrJobsiteOffsiteworkActivityTemplatesToCostCodes as $cost_code_id => $jobsiteOffsiteworkActivityTemplateToCostCode) {
			$jobsiteOffsiteworkActivityTemplateToCostCode->delete();
		}
	break;

	case 'deleteJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId':
		$jobsite_building_activity_id = $get->jobsite_building_activity_id;

		$errorNumber = 1;
		$numDeleted = 0;
		$messageText = 'An error occurred.';

		try {
			$loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityIdOptions = new Input();
			$loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityIdOptions->forceLoadFlag = true;
			$arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId = JobsiteBuildingActivityToCostCode::loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId($database, $jobsite_building_activity_id, $loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityIdOptions);
			$arrJobsiteBuildingActivitiesToCostCodes = $arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId[$jobsite_building_activity_id];
			foreach($arrJobsiteBuildingActivitiesToCostCodes as $cost_code_id => $jobsiteBuildingActivityToCostCode) {
				$jobsiteBuildingActivityToCostCode->delete();
				$errorNumber = 0;
				$numDeleted++;
			}

			$messageText = $numDeleted . ' JobsiteBuildingActivityToCostCode records successfully deleted.';

		} catch(Exception $e) {

		}

		$arrReturn = array(
			'errorNumber' => $errorNumber,
			'numDeleted' => $numDeleted,
			'messageText' => $messageText,
		);

		$jsonOutput = json_encode($arrReturn);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'deleteJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId':
		$jobsite_sitework_activity_id = $get->jobsite_sitework_activity_id;

		$errorNumber = 1;
		$numDeleted = 0;
		$messageText = 'An error occurred.';

		try {
			$loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityIdOptions = new Input();
			$loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityIdOptions->forceLoadFlag = true;
			$arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId = JobsiteSiteworkActivityToCostCode::loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId($database, $jobsite_sitework_activity_id, $loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityIdOptions);
			$arrJobsiteSiteworkActivitiesToCostCodes = $arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId[$jobsite_sitework_activity_id];
			foreach($arrJobsiteSiteworkActivitiesToCostCodes as $cost_code_id => $jobsiteSiteworkActivityToCostCode) {
				$jobsiteSiteworkActivityToCostCode->delete();
				$errorNumber = 0;
				$numDeleted++;
			}

			$messageText = $numDeleted . ' JobsiteSiteworkActivityToCostCode records successfully deleted.';

		} catch(Exception $e) {

		}

		$arrReturn = array(
			'errorNumber' => $errorNumber,
			'numDeleted' => $numDeleted,
			'messageText' => $messageText,
		);

		$jsonOutput = json_encode($arrReturn);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'deleteJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId':
		$jobsite_offsitework_activity_id = $get->jobsite_offsitework_activity_id;

		$errorNumber = 1;
		$numDeleted = 0;
		$messageText = 'An error occurred.';

		try {
			$loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityIdOptions = new Input();
			$loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityIdOptions->forceLoadFlag = true;
			$arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId = JobsiteOffsiteworkActivityToCostCode::loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId($database, $jobsite_offsitework_activity_id, $loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityIdOptions);
			$arrJobsiteOffsiteworkActivitiesToCostCodes = $arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId[$jobsite_offsitework_activity_id];
			foreach($arrJobsiteOffsiteworkActivitiesToCostCodes as $cost_code_id => $jobsiteOffsiteworkActivityToCostCode) {
				$jobsiteOffsiteworkActivityToCostCode->delete();
				$errorNumber = 0;
				$numDeleted++;
			}

			$messageText = $numDeleted . ' JobsiteOffsiteworkActivityToCostCode records successfully deleted.';

		} catch(Exception $e) {

		}

		$arrReturn = array(
			'errorNumber' => $errorNumber,
			'numDeleted' => $numDeleted,
			'messageText' => $messageText,
		);

		$jsonOutput = json_encode($arrReturn);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;
	case 'loadJobsiteBuildingActivityTemplatesTbody':
		$jobsite_activity_list_template_id = $get->jobsite_activity_list_template_id;
		$htmlContent = buildJobsiteBuildingActivityTemplatesTbody($database, $jobsite_activity_list_template_id);
		echo $htmlContent;
	break;
	case 'loadImportJobsiteActivitiesTbody':

		$primaryDatasource = $get->primaryDatasource;     // building | offsitework | sitework
		$secondaryDatasource = $get->secondaryDatasource; // project | template
		$uniqueId = $get->uniqueId;

		$arrJobsiteActivities = array();
		$arrJobsiteActivitiesAlreadyImported = array();
		if ($primaryDatasource == 'building') {

			$loadJobsiteBuildingActivitiesByProjectIdOptions = new Input();
			$loadJobsiteBuildingActivitiesByProjectIdOptions->filterByCostCode = false;
			$loadJobsiteBuildingActivitiesByProjectIdOptions->forceLoadFlag = true;
			$loadJobsiteBuildingActivitiesByProjectIdOptions->extendedReturn = true;
			$arrTmp = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByProjectId($database, $project_id, $loadJobsiteBuildingActivitiesByProjectIdOptions);

			$arrJobsiteActivitiesAlreadyImported = $arrTmp['jobsite_building_activities_by_project_id_by_jobsite_building_activity_label'];
			$labelAttributeName = 'jobsite_building_activity_label';
			if ($secondaryDatasource == 'project') {

				$loadJobsiteBuildingActivitiesByProjectIdOptions = new Input();
				$loadJobsiteBuildingActivitiesByProjectIdOptions->filterByCostCode = false;
				$loadJobsiteBuildingActivitiesByProjectIdOptions->forceLoadFlag = true;
				$loadJobsiteBuildingActivitiesByProjectIdOptions->extendedReturn = false;
				$arrJobsiteActivities = JobsiteBuildingActivity::loadJobsiteBuildingActivitiesByProjectId($database, $uniqueId, $loadJobsiteBuildingActivitiesByProjectIdOptions);

			} elseif ($secondaryDatasource == 'template') {
				$loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateIdOptions = new Input();
				$loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateIdOptions->forceLoadFlag = true;
				$arrJobsiteActivities = JobsiteBuildingActivityTemplate::loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId($database, $uniqueId, $loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateIdOptions);
			}

		} elseif ($primaryDatasource == 'offsitework') {

			$loadJobsiteOffsiteworkActivitiesByProjectIdOptions = new Input();
			$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
			$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
			$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->extendedReturn = true;
			$arrTmp = JobsiteOffsiteworkActivity::loadJobsiteOffsiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteOffsiteworkActivitiesByProjectIdOptions);

			$arrJobsiteActivitiesAlreadyImported = $arrTmp['jobsite_offsitework_activities_by_project_id_by_jobsite_offsitework_activity_label'];
			$labelAttributeName = 'jobsite_offsitework_activity_label';
			if ($secondaryDatasource == 'project') {

				$loadJobsiteOffsiteworkActivitiesByProjectIdOptions = new Input();
				$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
				$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
				$loadJobsiteOffsiteworkActivitiesByProjectIdOptions->extendedReturn = false;
				$arrJobsiteActivities = JobsiteOffsiteworkActivity::loadJobsiteOffsiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteOffsiteworkActivitiesByProjectIdOptions);

			} elseif ($secondaryDatasource == 'template') {

				$loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions = new Input();
				$loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions->forceLoadFlag = true;
				$arrJobsiteActivities = JobsiteOffsiteworkActivityTemplate::loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId($database, $uniqueId, $loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions);

			}

		} elseif ($primaryDatasource == 'sitework') {

			$loadJobsiteSiteworkActivitiesByProjectIdOptions = new Input();
			$loadJobsiteSiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
			$loadJobsiteSiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
			$loadJobsiteSiteworkActivitiesByProjectIdOptions->extendedReturn = true;
			$arrTmp = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByProjectId($database, $project_id, $loadJobsiteSiteworkActivitiesByProjectIdOptions);
			$arrJobsiteActivitiesAlreadyImported = $arrTmp['jobsite_sitework_activities_by_project_id_by_jobsite_sitework_activity_label'];
			$labelAttributeName = 'jobsite_sitework_activity_label';

			if ($secondaryDatasource == 'project') {

				$loadJobsiteSiteworkActivitiesByProjectIdOptions = new Input();
				$loadJobsiteSiteworkActivitiesByProjectIdOptions->filterByCostCode = null;
				$loadJobsiteSiteworkActivitiesByProjectIdOptions->forceLoadFlag = true;
				$loadJobsiteSiteworkActivitiesByProjectIdOptions->extendedReturn = false;
				$arrJobsiteActivities = JobsiteSiteworkActivity::loadJobsiteSiteworkActivitiesByProjectId($database, $uniqueId, $loadJobsiteSiteworkActivitiesByProjectIdOptions);

			} elseif ($secondaryDatasource == 'template') {

				$loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions = new Input();
				$loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions->forceLoadFlag = true;
				$arrJobsiteActivities = JobsiteSiteworkActivityTemplate::loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId($database, $uniqueId, $loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateIdOptions);

			}

		}

		$importJobsiteActivityTemplatesTbody = '';
		foreach($arrJobsiteActivities as $jobsite_activity_id => $jobsiteActivity) {
			$jobsite_activity_label = $jobsiteActivity->$labelAttributeName;
			$disabled = '';
			$checked = '';
			if (isset($arrJobsiteActivitiesAlreadyImported[$jobsite_activity_label])) {
				$disabled = 'disabled';
				$checked = 'checked';
			}
			$checkboxElementId = 'checkbox--'.$jobsite_activity_id;
			$importJobsiteActivityTemplatesTbody .=
			'
			<tr>
			<td class="textAlignCenter"><input id="'.$checkboxElementId.'" type="checkbox" value="'.$jobsite_activity_id.'" '.$disabled.' '.$checked.'></td>
			<td><label for="'.$checkboxElementId.'" style="float:none; text-align: left; padding-top:0">'.$jobsite_activity_label.'</label></td>
			</tr>
			';
		}
		if (count($arrJobsiteActivities) == 0) {
			$importJobsiteActivityTemplatesTbody = '<tr><td colspan="2">No data.</td></tr>';
		}

		$arrOutput = array(
			'htmlRecords' => $importJobsiteActivityTemplatesTbody
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;
	case 'importJobsiteActivitiesByCsvJobsiteActivityIds':

		$csvJobsiteActivityIds = $get->csvJobsiteActivityIds;
		$containerElementId = $get->containerElementId;
		$primaryDatasource = $get->primaryDatasource;     // building | offsitework | sitework
		$secondaryDatasource = $get->secondaryDatasource; // project | template

		$arrTmp = array();
		$arrJobsiteActivities = array();
		if ($primaryDatasource == 'building') {

			if ($secondaryDatasource == 'project') {
				$arrTmp = importJobsiteBuildingActivitiesByCsvJobsiteBuildingActivityIds($database, $csvJobsiteActivityIds, $project_id);
			} elseif ($secondaryDatasource == 'template') {
				$arrTmp = importJobsiteBuildingActivitiesByCsvJobsiteBuildingActivityTemplateIds($database, $csvJobsiteActivityIds, $project_id);
			}
			$arrJobsiteActivities = $arrTmp['arrJobsiteBuildingActivities'];
			$labelAttributeName = 'jobsite_building_activity_label';
			$elementIdPrefix = 'record_container--manage-jobsite_building_activity-record--jobsite_building_activities--sort_order--';
			$tableName = 'jobsite_building_activities';
			$attributeGroupName = 'manage-jobsite_building_activity-record';
			$jsDeleteFunction = 'deleteJobsiteBuildingActivityAndDependentDataAndReloadDataTableViaPromiseChain';

		} elseif ($primaryDatasource == 'offsitework') {

			if ($secondaryDatasource == 'project') {
				$arrTmp = importJobsiteOffsiteworkActivitiesByCsvJobsiteOffsiteworkActivityIds($database, $csvJobsiteActivityIds, $project_id);
			} elseif ($secondaryDatasource == 'template') {
				$arrTmp = importJobsiteOffsiteworkActivitiesByCsvJobsiteOffsiteworkActivityTemplateIds($database, $csvJobsiteActivityIds, $project_id);
			}
			$arrJobsiteActivities = $arrTmp['arrJobsiteOffsiteworkActivities'];
			$labelAttributeName = 'jobsite_offsitework_activity_label';
			$elementIdPrefix = 'record_container--manage-jobsite_offsitework_activity-record--jobsite_offsitework_activities--sort_order--';
			$tableName = 'jobsite_offsitework_activities';
			$attributeGroupName = 'manage-jobsite_offsitework_activity-record';
			$jsDeleteFunction = 'deleteJobsiteOffsiteworkActivityAndDependentDataAndReloadDataTableViaPromiseChain';

		} elseif ($primaryDatasource == 'sitework') {

			if ($secondaryDatasource == 'project') {
				$arrTmp = importJobsiteSiteworkActivitiesByCsvJobsiteSiteworkActivityIds($database, $csvJobsiteActivityIds, $project_id);
			} elseif ($secondaryDatasource == 'template') {
				$arrTmp = importJobsiteSiteworkActivitiesByCsvJobsiteSiteworkActivityTemplateIds($database, $csvJobsiteActivityIds, $project_id);
			}
			$arrJobsiteActivities = $arrTmp['arrJobsiteSiteworkActivities'];
			$labelAttributeName = 'jobsite_sitework_activity_label';
			$elementIdPrefix = 'record_container--manage-jobsite_sitework_activity-record--jobsite_sitework_activities--sort_order--';
			$tableName = 'jobsite_sitework_activities';
			$attributeGroupName = 'manage-jobsite_sitework_activity-record';
			$jsDeleteFunction = 'deleteJobsiteSiteworkActivityAndDependentDataAndReloadDataTableViaPromiseChain';

		}

		$htmlRecords = '';
		$errorNumber = 0;
		if (count($arrJobsiteActivities) == 0) {
			$errorNumber = 1;
		}

		foreach ($arrJobsiteActivities as $jobsite_activity_id => $jobsiteActivity) {
			/* @var $jobsiteActivity JobsiteActivity */

			$jobsiteActivity->htmlEntityEscapeProperties();

			$escapedLabelAttributeName = "escaped_{$labelAttributeName}";
			$jobsite_activity_label = $jobsiteActivity->$labelAttributeName;
			$escaped_jobsite_activity_label = $jobsiteActivity->$escapedLabelAttributeName;
			$sort_order = $jobsiteActivity->sort_order;

			$containerElementId = $elementIdPrefix . $jobsite_activity_id;
			$htmlRecords .= <<<END_HTML_RECORD
			<tr id="$containerElementId">
				<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
				<td class="textAlignLeft">$escaped_jobsite_activity_label</td>
				<td class="textAlignLeft"><a href="javascript:loadJobsiteActivitiesToCostCodesDialog('$tableName', '$jobsite_activity_id', '$escaped_jobsite_activity_label');">View Cost Code Links</a></td>
				<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="$jsDeleteFunction('$containerElementId', '$attributeGroupName', '$jobsite_activity_id'); "></span></td>
			</tr>
END_HTML_RECORD;

		}

		$messageText = count($arrJobsiteActivities) . ' activities imported. ';
		$numDuplicates = $arrTmp['numDuplicates'];
		if ($numDuplicates > 0) {
			$messageText .= $numDuplicates . ' duplicate entries ignored.';
		}
		$arrOutput = array(
			'errorNumber' => $errorNumber,
			'messageText' => $messageText,
			'htmlRecords' => $htmlRecords,
			'containerElementId' => $attributeGroupName
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;
	case 'loadCreateJobsiteActivityListTemplateDialog':

		$loadProjectTypesByUserCompanyIdOptions = new Input();
		$loadProjectTypesByUserCompanyIdOptions->forceLoadFlag = true;
		$arrProjectTypesByUserCompanyId = ProjectType::loadProjectTypesByUserCompanyId($database, $user_company_id, $loadProjectTypesByUserCompanyIdOptions);
		$ddlProjectTypesId = 'ddl--create-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--dummy';
		$prependedOption = '<option value="">Please Select a Project Type</option>';
		$js = 'class="required"';
		$ddlProjectTypes = PageComponents::dropDownListFromObjects($ddlProjectTypesId, $arrProjectTypesByUserCompanyId, 'project_type_id', null, 'project_type', null, '', '', $js, $prependedOption);

		$htmlContent = <<<END_HTML_CONTENT

		<div class="widgetContainer" style="border: 0;">
			<form id="formCreateJobsiteActivityListTemplate">
			<table id="container--create-jobsite_activity_list_template-record--dummy" class="content" cellpadding="5px" width="95%">
				<tr>
					<td class="textAlignRight verticalAlignMiddle">Project Type:</td>
					<td class="textAlignLeft">$ddlProjectTypes</td>
				</tr>
				<tr>
					<td class="textAlignRight verticalAlignMiddle">Jobsite Activity List Template:</td>
					<td class="textAlignLeft"><input type="text" id="create-jobsite_activity_list_template-record--jobsite_activity_list_templates--jobsite_activity_list_template--dummy" class="required" style="width: 375px;"></td>
				</tr>
			</table>
			</form>
		</div>
END_HTML_CONTENT;

		echo $htmlContent;

	break;

	case 'loadCreateJobsiteBuildingActivityTemplateDialog':

		$htmlContent = <<<END_HTML_CONTENT

		<form id="formCreateJobsiteBuildingActivityTemplate">
		<table id="container--create-jobsite_building_activity_template-record--dummy" class="content" cellpadding="15px" width="95%">
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Jobsite Activity List Template:</td>
				<td class="textAlignLeft">$ddlJobsiteActivityListTemplatesByUserCompanyId</td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Name:</td>
				<td class="textAlignLeft"><input type="text" id="create-jobsite_building_activity_template-record--jobsite_building_activity_templates--jobsite_building_activity_label--dummy" class="required" style="width: 375px;"></td>
			</tr>
			<tr>
				<td></td>
				<td class="textAlignRight">
					<input type="button" value="Create Jobsite Building Activity Template" onclick="createJobsiteBuildingActivityTemplateAndReloadDataTableViaPromiseChain('create-jobsite_building_activity_template-record', 'dummy');">
					<input id="create-jobsite_building_activity_template-record--jobsite_building_activity_templates--project_id--dummy" type="hidden" value="$project_id">
				</td>
			</tr>
		</table>
		</form>
END_HTML_CONTENT;

		echo $htmlContent;

	break;

	case 'loadManageJobsiteActivityListTemplates':

		$htmlContent = buildAdminManageJobsiteActivityListTemplates($database, $user_company_id);

		echo $htmlContent;

	break;

	case 'subsubtabClicked':

		$jobsite_activity_list_template_id = $get->jobsite_activity_list_template_id;
		$subsubtab = $get->subsubtab;
		$jobsite_daily_log_id = $get->jobsite_daily_log_id;

		if (!isset($jobsite_daily_log_id)) {
			$jobsite_daily_log_created_date = date('Y-m-d');
			$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $jobsite_daily_log_created_date);
			if ($jobsiteDailyLog) {
				$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
			}
		}

		$htmlContent = '';
		if ($subsubtab == 'manageJobsiteBuildingActivityTemplates') {
			$htmlContent = buildAdminManageJobsiteBuildingActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id);
		} elseif ($subsubtab == 'manageJobsiteSiteworkActivityTemplates') {
			$htmlContent = buildAdminManageJobsiteSiteworkActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id);
		} elseif ($subsubtab == 'manageJobsiteOffsiteworkActivityTemplates') {
			$htmlContent = buildAdminManageJobsiteOffsiteworkActivityTemplates($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName, $jobsite_activity_list_template_id);
		} elseif ($subsubtab == 'manageJobsiteBuildingActivities') {
			$htmlContent = buildAdminManageJobsiteBuildingActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName);
		} elseif ($subsubtab == 'manageJobsiteSiteworkActivities') {
			$htmlContent = buildAdminManageJobsiteSiteworkActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName);
		} elseif ($subsubtab == 'manageJobsiteOffsiteworkActivities') {
			$htmlContent = buildAdminManageJobsiteOffsiteworkActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName);
		} elseif ($subsubtab == 'manageJobsiteActivities') {
			$htmlContent = buildAdminManageJobsiteActivities($database, $user_company_id, $project_id, $currentlySelectedProjectName);
		} elseif ($subsubtab == 'manageJobsiteOffsiteworkActivities') {
			$htmlContent = buildAdminManageJobsiteOffsiteworkActivities($database, $user_company_id, $project_id, $jobsite_daily_log_id, $currentlySelectedProjectName);
		}

		echo $htmlContent;

	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;
ob_flush();

exit;

} catch (Exception $e) {
	$error->outputErrorMessages();
	exit;
}

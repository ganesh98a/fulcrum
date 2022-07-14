<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

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

require_once('lib/common/PageComponents.php');

require_once('lib/common/JobsiteDailySiteworkActivityLog.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('jobsite_daily_sitework_activity_logs-functions.php');

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'createJobsiteDailySiteworkActivityLog':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_daily_sitework_activity_logs_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Jobsite Daily Sitework Activity Log.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Sitework Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Sitework Activity Logs';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_daily_sitework_activity_log-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the JobsiteDailySiteworkActivityLog record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);

			$jobsiteDailySiteworkActivityLog->setData($httpGetInputData);
			$jobsiteDailySiteworkActivityLog->convertDataToProperties();

			$jobsiteDailySiteworkActivityLog->convertPropertiesToData();
			$data = $jobsiteDailySiteworkActivityLog->getData();

			// Test for existence via standard findByUniqueIndex method
			$jobsiteDailySiteworkActivityLog->findByUniqueIndex();
			if ($jobsiteDailySiteworkActivityLog->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Jobsite Daily Sitework Activity Log already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$jobsiteDailySiteworkActivityLog->setKey(null);
				$jobsiteDailySiteworkActivityLog->setData($data);
			}

			$jobsite_daily_sitework_activity_log_id = $jobsiteDailySiteworkActivityLog->save();
			if (isset($jobsite_daily_sitework_activity_log_id) && !empty($jobsite_daily_sitework_activity_log_id)) {
				$jobsiteDailySiteworkActivityLog->jobsite_daily_sitework_activity_log_id = $jobsite_daily_sitework_activity_log_id;
				$jobsiteDailySiteworkActivityLog->setId($jobsite_daily_sitework_activity_log_id);
			}

			$jobsiteDailySiteworkActivityLog->convertDataToProperties();
			$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Daily Sitework Activity Log.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
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
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($jobsiteDailySiteworkActivityLog) && $jobsiteDailySiteworkActivityLog instanceof JobsiteDailySiteworkActivityLog) {
				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadJobsiteDailySiteworkActivityLog':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_daily_sitework_activity_logs_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Daily Sitework Activity Log.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Sitework Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Sitework Activity Logs';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_sitework_activity_id = (int) $get->jobsite_sitework_activity_id;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($jobsiteDailySiteworkActivityLog) && $jobsiteDailySiteworkActivityLog instanceof JobsiteDailySiteworkActivityLog) {
				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
			}
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadAllJobsiteDailySiteworkActivityLogRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_daily_sitework_activity_logs_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Daily Sitework Activity Log.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Sitework Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Sitework Activity Logs';
			}
			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_sitework_activity_id = (int) $get->jobsite_sitework_activity_id;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$containerElementId|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateJobsiteDailySiteworkActivityLog':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Daily Sitework Activity Log';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_daily_sitework_activity_logs_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Jobsite Daily Sitework Activity Log - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Sitework Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Sitework Activity Logs';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_sitework_activity_id = (int) $get->jobsite_sitework_activity_id;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'jobsite_daily_sitework_activity_log_id' => 'jobsite daily sitework activity log id',
				'jobsite_daily_log_id' => 'jobsite daily log id',
				'jobsite_sitework_activity_id' => 'jobsite sitework activity id',
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

			if ($attributeSubgroupName == 'jobsite_daily_sitework_activity_logs') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$jobsite_daily_sitework_activity_log_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteDailySiteworkActivityLog = JobsiteDailySiteworkActivityLog::findById($database, $jobsite_daily_sitework_activity_log_id);
				/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */

				if ($jobsiteDailySiteworkActivityLog) {
					// Check if the value actually changed
					$existingValue = $jobsiteDailySiteworkActivityLog->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'jobsite_daily_log_id' => 1,
						'jobsite_sitework_activity_id' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $jobsiteDailySiteworkActivityLog->$attributeName;
						$jobsiteDailySiteworkActivityLog->$attributeName = $newValue;
						$possibleDuplicateJobsiteDailySiteworkActivityLog = JobsiteDailySiteworkActivityLog::findByJobsiteDailyLogIdAndJobsiteSiteworkActivityId($database, $jobsiteDailySiteworkActivityLog->jobsite_daily_log_id, $jobsiteDailySiteworkActivityLog->jobsite_sitework_activity_id);
						if ($possibleDuplicateJobsiteDailySiteworkActivityLog) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Jobsite Daily Sitework Activity Log $newValue already exists.";
						} else {
							$jobsiteDailySiteworkActivityLog->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$jobsiteDailySiteworkActivityLog->setData($data);
						$jobsiteDailySiteworkActivityLog->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Daily Sitework Activity Log record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

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

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($jobsiteDailySiteworkActivityLog) && $jobsiteDailySiteworkActivityLog instanceof JobsiteDailySiteworkActivityLog) {
				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
			}
		}

		// Dummy placeholder for now
		$previousId = '';

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
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

	case 'updateAllJobsiteDailySiteworkActivityLogAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Daily Sitework Activity Log';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_daily_sitework_activity_logs_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Jobsite Daily Sitework Activity Log.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Sitework Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Sitework Activity Logs';
			}
			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_sitework_activity_id = (int) $get->jobsite_sitework_activity_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_daily_sitework_activity_logs') {
				$jobsite_daily_sitework_activity_log_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteDailySiteworkActivityLog = JobsiteDailySiteworkActivityLog::findById($database, $jobsite_daily_sitework_activity_log_id);
				/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */

				if ($jobsiteDailySiteworkActivityLog) {
					$existingData = $jobsiteDailySiteworkActivityLog->getData();

					// Retrieve all of the $_GET inputs automatically for the JobsiteDailySiteworkActivityLog record
					$httpGetInputData = $get->getData();

					$jobsiteDailySiteworkActivityLog->setData($httpGetInputData);
					$jobsiteDailySiteworkActivityLog->convertDataToProperties();
					$jobsiteDailySiteworkActivityLog->convertPropertiesToData();

					$newData = $jobsiteDailySiteworkActivityLog->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$jobsiteDailySiteworkActivityLog->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Jobsite Daily Sitework Activity Log<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}
					$jobsiteDailySiteworkActivityLog->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Daily Sitework Activity Log record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}
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

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($jobsiteDailySiteworkActivityLog) && $jobsiteDailySiteworkActivityLog instanceof JobsiteDailySiteworkActivityLog) {
				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$resetToPreviousValue";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'deleteJobsiteDailySiteworkActivityLog':

		$crudOperation = 'delete';
		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_daily_sitework_activity_logs_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Jobsite Daily Sitework Activity Log.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Sitework Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Sitework Activity Logs';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_sitework_activity_id = (int) $get->jobsite_sitework_activity_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_daily_sitework_activity_logs') {
				$jobsite_daily_sitework_activity_log_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteDailySiteworkActivityLog = JobsiteDailySiteworkActivityLog::findById($database, $jobsite_daily_sitework_activity_log_id);
				/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */

				if ($jobsiteDailySiteworkActivityLog) {
					$jobsiteDailySiteworkActivityLog->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Daily Sitework Activity Log record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}
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

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($jobsiteDailySiteworkActivityLog) && $jobsiteDailySiteworkActivityLog instanceof JobsiteDailySiteworkActivityLog) {
				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$recordContainerElementId|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$performDomDeleteOperation";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'saveJobsiteDailySiteworkActivityLog':

		$crudOperation = 'save';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_daily_sitework_activity_logs_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Jobsite Daily Sitework Activity Log.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Daily Sitework Activity Log';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Daily Sitework Activity Logs';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_daily_sitework_activity_log-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$jobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);

			// Retrieve all of the $_GET inputs automatically for the JobsiteDailySiteworkActivityLog record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteDailySiteworkActivityLog->setData($httpGetInputData);
			$jobsiteDailySiteworkActivityLog->convertDataToProperties();

			$jobsiteDailySiteworkActivityLog->convertPropertiesToData();
			$data = $jobsiteDailySiteworkActivityLog->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$jobsite_daily_sitework_activity_log_id = $jobsiteDailySiteworkActivityLog->insertOnDuplicateKeyUpdate();
			if (isset($jobsite_daily_sitework_activity_log_id) && !empty($jobsite_daily_sitework_activity_log_id)) {
				$jobsiteDailySiteworkActivityLog->jobsite_daily_sitework_activity_log_id = $jobsite_daily_sitework_activity_log_id;
				$jobsiteDailySiteworkActivityLog->setId($jobsite_daily_sitework_activity_log_id);
			}

			$jobsiteDailySiteworkActivityLog->convertDataToProperties();
			$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Daily Sitework Activity Log.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
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
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($jobsiteDailySiteworkActivityLog) && $jobsiteDailySiteworkActivityLog instanceof JobsiteDailySiteworkActivityLog) {
				$primaryKeyAsString = $jobsiteDailySiteworkActivityLog->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}

<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 16777215;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['post_maxlength'] = 16777215;
$init['post_required'] = true;
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
} else if (isset($post)) {
	$methodCall = $post->method;
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
$message->reset($currentPhpScript);

require_once('modules-jobsite-daily-logs-functions.php');

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('jobsite_delays-functions.php');
	}
}

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
	case 'createJobsiteDelay':

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
					'jobsite_delays_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Jobsite Delay.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Delay';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Delays';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_delay-record';
			}
			$jobsite_daily_log_id = (int) $post->jobsite_daily_log_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);
			updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);

			// Retrieve all of the $_GET inputs automatically for the JobsiteDelay record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteDelay = new JobsiteDelay($database);

			$jobsiteDelay->setData($httpGetInputData);
			$jobsiteDelay->convertDataToProperties();

			$jobsiteDelay->convertPropertiesToData();
			$data = $jobsiteDelay->getData();

			// Test for existence via standard findByUniqueIndex method
			$jobsiteDelay->findByUniqueIndex();
			if ($jobsiteDelay->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Jobsite Delay already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$jobsiteDelay->setKey(null);
				$jobsiteDelay->setData($data);
			}

			$jobsite_delay_id = $jobsiteDelay->save();
			if (isset($jobsite_delay_id) && !empty($jobsite_delay_id)) {
				$jobsiteDelay->jobsite_delay_id = $jobsite_delay_id;
				$jobsiteDelay->setId($jobsite_delay_id);
				$jobsite_daily_log_id = $jobsiteDelay->jobsite_daily_log_id;

				// jobsite_delay_note
				$jobsite_delay_note = (string) $post->jobsite_delay_note;
				if (!empty($jobsite_delay_note)) {
					$jobsiteDelayNote = JobsiteDelayNote::findByJobsiteDelayId($database, $jobsite_delay_id);
					/* @var $jobsiteDelayNote JobsiteDelayNote */
					if ($jobsiteDelayNote) {
						$data = array(
							'jobsite_delay_note' => $jobsite_delay_note
						);
						$jobsiteDelayNote->setData($data);
						$jobsiteDelayNote->save();
					} else {
						$jobsiteDelayNote = new JobsiteDelayNote($database);
						$data = array(
							'jobsite_delay_id' => $jobsite_delay_id,
							'jobsite_delay_note' => $jobsite_delay_note
						);
						$jobsiteDelayNote->setData($data);
						$jobsiteDelayNote->save();
					}
					$jobsiteDelayNote->convertDataToProperties();
				} else {
					$jobsiteDelayNote = false;
				}
			}

			$jobsiteDelay->convertDataToProperties();
			$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Delay.';
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
			if (isset($jobsiteDelay) && $jobsiteDelay instanceof JobsiteDelay) {
				$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
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

	case 'loadJobsiteDelay':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_delays_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Delay.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Delay';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Delays';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_delay_subcategory_id = (int) $get->jobsite_delay_subcategory_id;
			$jobsite_building_id = (int) $get->jobsite_building_id;
			$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;

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
			if (isset($jobsiteDelay) && $jobsiteDelay instanceof JobsiteDelay) {
				$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
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

	case 'loadAllJobsiteDelayRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_delays_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Delay.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Delay';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Delays';
			}
			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_delay_subcategory_id = (int) $get->jobsite_delay_subcategory_id;
			$jobsite_building_id = (int) $get->jobsite_building_id;
			$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;

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

	case 'updateJobsiteDelay':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Delay';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_delays_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Jobsite Delay - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Delay';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Delays';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_delay_subcategory_id = (int) $get->jobsite_delay_subcategory_id;
			$jobsite_building_id = (int) $get->jobsite_building_id;
			$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'jobsite_delay_id' => 'jobsite delay id',
				'jobsite_daily_log_id' => 'jobsite daily log id',
				'jobsite_delay_subcategory_id' => 'jobsite delay subcategory id',
				'jobsite_building_id' => 'jobsite building id',
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

			if ($attributeSubgroupName == 'jobsite_delays') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$jobsite_delay_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteDelay = JobsiteDelay::findById($database, $jobsite_delay_id);
				/* @var $jobsiteDelay JobsiteDelay */

				if ($jobsiteDelay) {
					// Check if the value actually changed
					$existingValue = $jobsiteDelay->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'jobsite_daily_log_id' => 1,
						'jobsite_delay_subcategory_id' => 1,
						'jobsite_building_id' => 1,
						'jobsite_sitework_region_id' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $jobsiteDelay->$attributeName;
						$jobsiteDelay->$attributeName = $newValue;
						$possibleDuplicateJobsiteDelay = JobsiteDelay::findByJobsiteDailyLogIdAndJobsiteDelaySubcategoryIdAndJobsiteBuildingIdAndJobsiteSiteworkRegionId($database, $jobsiteDelay->jobsite_daily_log_id, $jobsiteDelay->jobsite_delay_subcategory_id, $jobsiteDelay->jobsite_building_id, $jobsiteDelay->jobsite_sitework_region_id);
						if ($possibleDuplicateJobsiteDelay) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Jobsite Delay $newValue already exists.";

						} else {
							$jobsiteDelay->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$jobsiteDelay->setData($data);
						$jobsiteDelay->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
						updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Delay record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
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
			if (isset($jobsiteDelay) && $jobsiteDelay instanceof JobsiteDelay) {
				$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
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

	case 'updateAllJobsiteDelayAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Delay';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_delays_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Jobsite Delay.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Delay';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Delays';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_delay_subcategory_id = (int) $get->jobsite_delay_subcategory_id;
			$jobsite_building_id = (int) $get->jobsite_building_id;
			$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_delays') {
				$jobsite_delay_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteDelay = JobsiteDelay::findById($database, $jobsite_delay_id);
				/* @var $jobsiteDelay JobsiteDelay */

				if ($jobsiteDelay) {
					$existingData = $jobsiteDelay->getData();

					// Retrieve all of the $_GET inputs automatically for the JobsiteDelay record
					$httpGetInputData = $get->getData();
					
					$jobsiteDelay->setData($httpGetInputData);
					$jobsiteDelay->convertDataToProperties();
					$jobsiteDelay->convertPropertiesToData();

					$newData = $jobsiteDelay->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$jobsiteDelay->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Jobsite Delay<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					$jobsiteDelay->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
					updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Delay record does not exist.';
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
			if (isset($jobsiteDelay) && $jobsiteDelay instanceof JobsiteDelay) {
				$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
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

	case 'deleteJobsiteDelay':

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
					'jobsite_delays_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Jobsite Delay.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Delay';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Delays';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_delay_subcategory_id = (int) $get->jobsite_delay_subcategory_id;
			$jobsite_building_id = (int) $get->jobsite_building_id;
			$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_delays') {
				$jobsite_delay_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteDelay = JobsiteDelay::findById($database, $jobsite_delay_id);
				/* @var $jobsiteDelay JobsiteDelay */

				if ($jobsiteDelay) {
					$jobsiteDelay->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
					updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Delay record does not exist.';
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
			if (isset($jobsiteDelay) && $jobsiteDelay instanceof JobsiteDelay) {
				$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
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

	case 'saveJobsiteDelay':

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
					'jobsite_delays_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Jobsite Delay.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Delay';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Delays';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_delay-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$jobsiteDelay = new JobsiteDelay($database);

			// Retrieve all of the $_GET inputs automatically for the JobsiteDelay record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteDelay->setData($httpGetInputData);
			$jobsiteDelay->convertDataToProperties();

			$jobsiteDelay->convertPropertiesToData();
			$data = $jobsiteDelay->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$jobsite_delay_id = $jobsiteDelay->insertOnDuplicateKeyUpdate();
			if (isset($jobsite_delay_id) && !empty($jobsite_delay_id)) {
				$jobsiteDelay->jobsite_delay_id = $jobsite_delay_id;
				$jobsiteDelay->setId($jobsite_delay_id);
			}

			$jobsiteDelay->convertDataToProperties();
			$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Delay.';
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
			if (isset($jobsiteDelay) && $jobsiteDelay instanceof JobsiteDelay) {
				$primaryKeyAsString = $jobsiteDelay->getPrimaryKeyAsString();
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

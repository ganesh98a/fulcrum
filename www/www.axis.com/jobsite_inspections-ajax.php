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
		require_once('jobsite_inspections-functions.php');
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
	case 'createJobsiteInspection':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecordTr = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_inspections_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Jobsite Inspection.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Inspection';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Inspections';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_inspection-record';
			}
			$jobsite_daily_log_id = (int) $post->jobsite_daily_log_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the JobsiteInspection record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteInspection = new JobsiteInspection($database);

			$jobsiteInspection->setData($httpGetInputData);
			$jobsiteInspection->convertDataToProperties();

			$jobsiteInspection->convertPropertiesToData();
			$data = $jobsiteInspection->getData();

			// Test for existence via standard findByUniqueIndex method
			$jobsiteInspection->findByUniqueIndex();
			if ($jobsiteInspection->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Jobsite Inspection already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$jobsiteInspection->setKey(null);
				$jobsiteInspection->setData($data);
			}

			$jobsite_inspection_id = $jobsiteInspection->save();
			if (isset($jobsite_inspection_id) && !empty($jobsite_inspection_id)) {
				$jobsiteInspection->jobsite_inspection_id = $jobsite_inspection_id;
				$jobsiteInspection->setId($jobsite_inspection_id);
				$jobsite_daily_log_id = $jobsiteInspection->jobsite_daily_log_id;

				// jobsite_inspection_note
				$jobsite_inspection_note = (string) $post->jobsite_inspection_note;
				if (!empty($jobsite_inspection_note)) {
					$jobsiteInspectionNote = JobsiteInspectionNote::findByJobsiteInspectionId($database, $jobsite_inspection_id);
					/* @var $jobsiteInspectionNote JobsiteInspectionNote */
					if ($jobsiteInspectionNote) {
						$data = array(
							'jobsite_inspection_note' => $jobsite_inspection_note
						);
						$jobsiteInspectionNote->setData($data);
						$jobsiteInspectionNote->save();
					} else {
						$jobsiteInspectionNote = new JobsiteInspectionNote($database);
						$data = array(
							'jobsite_inspection_id' => $jobsite_inspection_id,
							'jobsite_inspection_note' => $jobsite_inspection_note
						);
						$jobsiteInspectionNote->setData($data);
						$jobsiteInspectionNote->save();
					}
					$jobsiteInspectionNote->convertDataToProperties();
				} else {
					$jobsiteInspectionNote = false;
				}
			}

			$jobsiteInspection->convertDataToProperties();
			$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
				updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);

				if ($jobsiteInspectionNote && ($jobsiteInspectionNote instanceof JobsiteInspectionNote)) {
					$jobsiteInspectionNote->htmlEntityEscapeProperties();
					$escaped_jobsite_inspection_note = $jobsiteInspectionNote->escaped_jobsite_inspection_note;
				} else {
					$escaped_jobsite_inspection_note = '';
				}

				$recordContainerElementId = "record_container--manage-jobsite_inspection-record--jobsite_inspections--$primaryKeyAsString";
				$jobsite_inspection_type_id = (int) $post->jobsite_inspection_type_id;
				$jobsiteInspectionType = JobsiteInspectionType::findById($database, $jobsite_inspection_type_id);
				/* @var $jobsiteInspectionType JobsiteInspectionType */
				$jobsiteInspectionType->htmlEntityEscapeProperties();
				$jobsite_inspection_type = $jobsiteInspectionType->jobsite_inspection_type;
				$escaped_jobsite_inspection_type = $jobsiteInspectionType->escaped_jobsite_inspection_type;
				$jobsite_inspection_passed_flag = $jobsiteInspection->jobsite_inspection_passed_flag;
				$htmlRecordTr = <<<END_HTML_RECORD_TR

				<tr id="$recordContainerElementId">
					<td>$escaped_jobsite_inspection_type</td>
					<td>$escaped_jobsite_inspection_note</td>
					<td>$jobsite_inspection_passed_flag</td>
					<td><a href="javascript:deleteJobsiteInspection('$recordContainerElementId', 'manage-jobsite_inspection-record', $primaryKeyAsString, { responseDataType: 'json' });">x</a></td>
				</tr>
END_HTML_RECORD_TR;
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Inspection.';
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
			if (isset($jobsiteInspection) && $jobsiteInspection instanceof JobsiteInspection) {
				$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
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

	case 'loadJobsiteInspection':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_inspections_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Inspection.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Inspection';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Inspections';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_inspection_type_id = (int) $get->jobsite_inspection_type_id;
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
			if (isset($jobsiteInspection) && $jobsiteInspection instanceof JobsiteInspection) {
				$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
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

	case 'loadAllJobsiteInspectionRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_inspections_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Jobsite Inspection.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Inspection';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Inspections';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_inspection_type_id = (int) $get->jobsite_inspection_type_id;
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

	case 'updateJobsiteInspection':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Inspection';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_inspections_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Jobsite Inspection - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Inspection';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Inspections';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_inspection_type_id = (int) $get->jobsite_inspection_type_id;
			$jobsite_building_id = (int) $get->jobsite_building_id;
			$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'jobsite_inspection_id' => 'jobsite inspection id',
				'jobsite_daily_log_id' => 'jobsite daily log id',
				'jobsite_inspection_type_id' => 'jobsite inspection type id',
				'inspector_contact_id' => 'inspector contact id',
				'jobsite_building_id' => 'jobsite building id',
				'jobsite_sitework_region_id' => 'jobsite sitework region id',
				'jobsite_inspection_passed_flag' => 'jobsite inspection passed flag',
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

			if ($attributeSubgroupName == 'jobsite_inspections') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$jobsite_inspection_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteInspection = JobsiteInspection::findById($database, $jobsite_inspection_id);
				/* @var $jobsiteInspection JobsiteInspection */

				if ($jobsiteInspection) {
					// Check if the value actually changed
					$existingValue = $jobsiteInspection->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'jobsite_daily_log_id' => 1,
						'jobsite_inspection_type_id' => 1,
						'jobsite_building_id' => 1,
						'jobsite_sitework_region_id' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $jobsiteInspection->$attributeName;
						$jobsiteInspection->$attributeName = $newValue;
						$possibleDuplicateJobsiteInspection = JobsiteInspection::findByJobsiteDailyLogIdAndJobsiteInspectionTypeIdAndJobsiteBuildingIdAndJobsiteSiteworkRegionId($database, $jobsiteInspection->jobsite_daily_log_id, $jobsiteInspection->jobsite_inspection_type_id, $jobsiteInspection->jobsite_building_id, $jobsiteInspection->jobsite_sitework_region_id);
						if ($possibleDuplicateJobsiteInspection) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Jobsite Inspection $newValue already exists.";

						} else {
							$jobsiteInspection->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$jobsiteInspection->setData($data);
						// $jobsite_inspection_id = $jobsiteInspection->save();
						$jobsiteInspection->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
						updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Inspection record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
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
			if (isset($jobsiteInspection) && $jobsiteInspection instanceof JobsiteInspection) {
				$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
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

	case 'updateAllJobsiteInspectionAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Inspection';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_inspections_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Jobsite Inspection.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Inspection';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Inspections';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_inspection_type_id = (int) $get->jobsite_inspection_type_id;
			$jobsite_building_id = (int) $get->jobsite_building_id;
			$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_inspections') {
				$jobsite_inspection_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteInspection = JobsiteInspection::findById($database, $jobsite_inspection_id);
				/* @var $jobsiteInspection JobsiteInspection */

				if ($jobsiteInspection) {
					$existingData = $jobsiteInspection->getData();

					// Retrieve all of the $_GET inputs automatically for the JobsiteInspection record
					$httpGetInputData = $get->getData();
					$jobsiteInspection->setData($httpGetInputData);
					$jobsiteInspection->convertDataToProperties();
					$jobsiteInspection->convertPropertiesToData();

					$newData = $jobsiteInspection->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$jobsiteInspection->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Jobsite Inspection<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}
					$jobsiteInspection->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
					updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Inspection record does not exist.';
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
			if (isset($jobsiteInspection) && $jobsiteInspection instanceof JobsiteInspection) {
				$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
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

	case 'deleteJobsiteInspection':

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
					'jobsite_inspections_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Jobsite Inspection.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Inspection';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Inspections';
			}

			// Unique index attibutes
			$jobsite_daily_log_id = (int) $get->jobsite_daily_log_id;
			$jobsite_inspection_type_id = (int) $get->jobsite_inspection_type_id;
			$jobsite_building_id = (int) $get->jobsite_building_id;
			$jobsite_sitework_region_id = (int) $get->jobsite_sitework_region_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_inspections') {
				$jobsite_inspection_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteInspection = JobsiteInspection::findById($database, $jobsite_inspection_id);
				/* @var $jobsiteInspection JobsiteInspection */

				if ($jobsiteInspection) {
					$jobsiteInspection->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
					updateJobsiteDailyLogModifiedFields($database, $jobsite_daily_log_id, $currentlyActiveContactId);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Inspection record does not exist.';
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
			if (isset($jobsiteInspection) && $jobsiteInspection instanceof JobsiteInspection) {
				$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
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

	case 'saveJobsiteInspection':

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
					'jobsite_inspections_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Jobsite Inspection.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Inspection';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Inspections';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_inspection-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$jobsiteInspection = new JobsiteInspection($database);

			// Retrieve all of the $_GET inputs automatically for the JobsiteInspection record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteInspection->setData($httpGetInputData);
			$jobsiteInspection->convertDataToProperties();

			$jobsiteInspection->convertPropertiesToData();
			$data = $jobsiteInspection->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$jobsite_inspection_id = $jobsiteInspection->insertOnDuplicateKeyUpdate();
			if (isset($jobsite_inspection_id) && !empty($jobsite_inspection_id)) {
				$jobsiteInspection->jobsite_inspection_id = $jobsite_inspection_id;
				$jobsiteInspection->setId($jobsite_inspection_id);
			}

			$jobsiteInspection->convertDataToProperties();
			$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Inspection.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Jobsite Inspection';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($jobsiteInspection) && $jobsiteInspection instanceof JobsiteInspection) {
				$primaryKeyAsString = $jobsiteInspection->getPrimaryKeyAsString();
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

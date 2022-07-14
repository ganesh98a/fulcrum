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

require_once('lib/common/JobsiteBuildingActivityTemplateToCostCode.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('jobsite_building_activity_templates_to_cost_codes-functions.php');

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
	case 'createJobsiteBuildingActivityTemplateToCostCode':

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
					'jobsite_building_activity_templates_to_cost_codes_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Jobsite Building Activity Template To Cost Code.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template To Cost Code';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates To Cost Codes';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_building_activity_template_to_cost_code-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the JobsiteBuildingActivityTemplateToCostCode record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteBuildingActivityTemplateToCostCode = new JobsiteBuildingActivityTemplateToCostCode($database);

			$jobsiteBuildingActivityTemplateToCostCode->setData($httpGetInputData);
			$jobsiteBuildingActivityTemplateToCostCode->convertDataToProperties();

			$jobsiteBuildingActivityTemplateToCostCode->convertPropertiesToData();
			$data = $jobsiteBuildingActivityTemplateToCostCode->getData();

			// Test for existence via standard findByUniqueIndex method
			$jobsiteBuildingActivityTemplateToCostCode->findByUniqueIndex();
			if ($jobsiteBuildingActivityTemplateToCostCode->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Jobsite Building Activity Template To Cost Code already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$jobsiteBuildingActivityTemplateToCostCode->setKey(null);
				$jobsiteBuildingActivityTemplateToCostCode->setData($data);
			}

			$jobsiteBuildingActivityTemplateToCostCode->save();

			$jobsiteBuildingActivityTemplateToCostCode->convertDataToProperties();
			$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Building Activity Template To Cost Code.';
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
			if (isset($jobsiteBuildingActivityTemplateToCostCode) && $jobsiteBuildingActivityTemplateToCostCode instanceof JobsiteBuildingActivityTemplateToCostCode) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
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

	case 'loadJobsiteBuildingActivityTemplateToCostCode':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_building_activity_templates_to_cost_codes_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Building Activity Template To Cost Code.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template To Cost Code';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates To Cost Codes';
			}

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
			if (isset($jobsiteBuildingActivityTemplateToCostCode) && $jobsiteBuildingActivityTemplateToCostCode instanceof JobsiteBuildingActivityTemplateToCostCode) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
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

	case 'loadAllJobsiteBuildingActivityTemplateToCostCodeRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_building_activity_templates_to_cost_codes_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Building Activity Template To Cost Code.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template To Cost Code';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates To Cost Codes';
			}

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

	case 'updateJobsiteBuildingActivityTemplateToCostCode':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Building Activity Template To Cost Code';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_building_activity_templates_to_cost_codes_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Jobsite Building Activity Template To Cost Code - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template To Cost Code';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates To Cost Codes';
			}

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'jobsite_building_activity_template_id' => 'jobsite building activity template id',
				'cost_code_id' => 'cost code id',
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

			if ($attributeSubgroupName == 'jobsite_building_activity_templates_to_cost_codes') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$arrTmp = explode('-', $uniqueId);
				$jobsite_building_activity_template_id = (int) array_shift($arrTmp);
				$cost_code_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteBuildingActivityTemplateToCostCode = JobsiteBuildingActivityTemplateToCostCode::findByJobsiteBuildingActivityTemplateIdAndCostCodeId($database, $jobsite_building_activity_template_id, $cost_code_id);
				/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */

				if ($jobsiteBuildingActivityTemplateToCostCode) {
					// Check if the value actually changed
					$existingValue = $jobsiteBuildingActivityTemplateToCostCode->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$jobsiteBuildingActivityTemplateToCostCode->setData($data);
						$jobsiteBuildingActivityTemplateToCostCode->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Building Activity Template To Cost Code record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
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
			if (isset($jobsiteBuildingActivityTemplateToCostCode) && $jobsiteBuildingActivityTemplateToCostCode instanceof JobsiteBuildingActivityTemplateToCostCode) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
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

	case 'updateAllJobsiteBuildingActivityTemplateToCostCodeAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Building Activity Template To Cost Code';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_building_activity_templates_to_cost_codes_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Jobsite Building Activity Template To Cost Code.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template To Cost Code';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates To Cost Codes';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_building_activity_templates_to_cost_codes') {
				$arrTmp = explode('-', $uniqueId);
				$jobsite_building_activity_template_id = (int) array_shift($arrTmp);
				$cost_code_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteBuildingActivityTemplateToCostCode = JobsiteBuildingActivityTemplateToCostCode::findByJobsiteBuildingActivityTemplateIdAndCostCodeId($database, $jobsite_building_activity_template_id, $cost_code_id);
				/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */

				if ($jobsiteBuildingActivityTemplateToCostCode) {
					$existingData = $jobsiteBuildingActivityTemplateToCostCode->getData();

					// Retrieve all of the $_GET inputs automatically for the JobsiteBuildingActivityTemplateToCostCode record
					$httpGetInputData = $get->getData();
					
					$jobsiteBuildingActivityTemplateToCostCode->setData($httpGetInputData);
					$jobsiteBuildingActivityTemplateToCostCode->convertDataToProperties();
					$jobsiteBuildingActivityTemplateToCostCode->convertPropertiesToData();

					$newData = $jobsiteBuildingActivityTemplateToCostCode->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$jobsiteBuildingActivityTemplateToCostCode->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Jobsite Building Activity Template To Cost Code<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					$jobsiteBuildingActivityTemplateToCostCode->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Building Activity Template To Cost Code record does not exist.';
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
			if (isset($jobsiteBuildingActivityTemplateToCostCode) && $jobsiteBuildingActivityTemplateToCostCode instanceof JobsiteBuildingActivityTemplateToCostCode) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
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

	case 'deleteJobsiteBuildingActivityTemplateToCostCode':

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
					'jobsite_building_activity_templates_to_cost_codes_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Jobsite Building Activity Template To Cost Code.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template To Cost Code';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates To Cost Codes';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_building_activity_templates_to_cost_codes') {
				$arrTmp = explode('-', $uniqueId);
				$jobsite_building_activity_template_id = (int) array_shift($arrTmp);
				$cost_code_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteBuildingActivityTemplateToCostCode = JobsiteBuildingActivityTemplateToCostCode::findByJobsiteBuildingActivityTemplateIdAndCostCodeId($database, $jobsite_building_activity_template_id, $cost_code_id);
				/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */

				if ($jobsiteBuildingActivityTemplateToCostCode) {
					$jobsiteBuildingActivityTemplateToCostCode->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Building Activity Template To Cost Code record does not exist.';
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
			if (isset($jobsiteBuildingActivityTemplateToCostCode) && $jobsiteBuildingActivityTemplateToCostCode instanceof JobsiteBuildingActivityTemplateToCostCode) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
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

	case 'saveJobsiteBuildingActivityTemplateToCostCode':

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
					'jobsite_building_activity_templates_to_cost_codes_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Jobsite Building Activity Template To Cost Code.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template To Cost Code';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates To Cost Codes';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_building_activity_template_to_cost_code-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$jobsiteBuildingActivityTemplateToCostCode = new JobsiteBuildingActivityTemplateToCostCode($database);

			// Retrieve all of the $_GET inputs automatically for the JobsiteBuildingActivityTemplateToCostCode record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteBuildingActivityTemplateToCostCode->setData($httpGetInputData);
			$jobsiteBuildingActivityTemplateToCostCode->convertDataToProperties();

			$jobsiteBuildingActivityTemplateToCostCode->convertPropertiesToData();
			$data = $jobsiteBuildingActivityTemplateToCostCode->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$jobsiteBuildingActivityTemplateToCostCode->insertIgnore();

			$jobsiteBuildingActivityTemplateToCostCode->convertDataToProperties();
			$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Building Activity Template To Cost Code.';
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
			if (isset($jobsiteBuildingActivityTemplateToCostCode) && $jobsiteBuildingActivityTemplateToCostCode instanceof JobsiteBuildingActivityTemplateToCostCode) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplateToCostCode->getPrimaryKeyAsString();
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

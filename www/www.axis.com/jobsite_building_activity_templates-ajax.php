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

require_once('lib/common/JobsiteBuildingActivityTemplate.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('jobsite_building_activity_templates-functions.php');
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
	case 'createJobsiteBuildingActivityTemplate':

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
					'jobsite_building_activity_templates_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Jobsite Building Activity Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_building_activity_template-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the JobsiteBuildingActivityTemplate record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteBuildingActivityTemplate = new JobsiteBuildingActivityTemplate($database);

			$jobsiteBuildingActivityTemplate->setData($httpGetInputData);
			$jobsiteBuildingActivityTemplate->convertDataToProperties();
			$jobsiteBuildingActivityTemplate->convertPropertiesToData();
			$data = $jobsiteBuildingActivityTemplate->getData();

			// Test for existence via standard findByUniqueIndex method
			$jobsiteBuildingActivityTemplate->findByUniqueIndex();
			if ($jobsiteBuildingActivityTemplate->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Jobsite Building Activity Template already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$jobsiteBuildingActivityTemplate->setKey(null);
				$jobsiteBuildingActivityTemplate->setData($data);
			}

			$jobsite_building_activity_template_id = $jobsiteBuildingActivityTemplate->save();
			if (isset($jobsite_building_activity_template_id) && !empty($jobsite_building_activity_template_id)) {
				$jobsiteBuildingActivityTemplate->jobsite_building_activity_template_id = $jobsite_building_activity_template_id;
				$jobsiteBuildingActivityTemplate->setId($jobsite_building_activity_template_id);
			}

			$jobsiteBuildingActivityTemplate->convertDataToProperties();
			$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				$jobsiteBuildingActivityTemplate->htmlEntityEscapeProperties();

				$jobsite_building_activity_label = $jobsiteBuildingActivityTemplate->jobsite_building_activity_label;
				$escaped_jobsite_building_activity_label = $jobsiteBuildingActivityTemplate->escaped_jobsite_building_activity_label;

				$containerElementId = "record_container--manage-jobsite_building_activity_template-record--jobsite_building_activity_templates--sort_order--$primaryKeyAsString";
				$checkboxElementId =                    "manage-jobsite_building_activity_template-record--jobsite_building_activity_templates--jobsite_building_activity_template_id--$primaryKeyAsString";

				$htmlRecord = <<<END_HTML_RECORD

				<tr id="$containerElementId">
					<td class="textAlignLeft">$escaped_jobsite_building_activity_label</td>
					<td class="textAlignLeft"><a href="javascript:loadJobsiteActivitiesToCostCodesDialog('jobsite_building_activity_templates', '$primaryKeyAsString', '$escaped_jobsite_building_activity_label');">View Cost Code Links</a></td>
					<td class="textAlignCenter"><span class="entypo entypo-click entypo-cancel" onclick="deleteJobsiteBuildingActivityTemplateAndDependentDataAndReloadDataTableViaPromiseChain('$containerElementId', 'manage-jobsite_building_activity_template-record', '$primaryKeyAsString');"></span></td>
				</tr>
END_HTML_RECORD;

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Building Activity Template.';
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
			if (isset($jobsiteBuildingActivityTemplate) && $jobsiteBuildingActivityTemplate instanceof JobsiteBuildingActivityTemplate) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlRecord";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadJobsiteBuildingActivityTemplate':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_building_activity_templates_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Building Activity Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates';
			}
			// Unique index attibutes
			$jobsite_activity_list_template_id = (int) $get->jobsite_activity_list_template_id;
			$jobsite_building_activity_label = (string) $get->jobsite_building_activity_label;

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
			if (isset($jobsiteBuildingActivityTemplate) && $jobsiteBuildingActivityTemplate instanceof JobsiteBuildingActivityTemplate) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
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

	case 'loadAllJobsiteBuildingActivityTemplateRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_building_activity_templates_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Building Activity Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates';
			}
			// Unique index attibutes
			$jobsite_activity_list_template_id = (int) $get->jobsite_activity_list_template_id;
			$jobsite_building_activity_label = (string) $get->jobsite_building_activity_label;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

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

	case 'updateJobsiteBuildingActivityTemplate':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Building Activity Template';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_building_activity_templates_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Jobsite Building Activity Template - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates';
			}

			// Unique index attibutes
			$jobsite_activity_list_template_id = (int) $get->jobsite_activity_list_template_id;
			$jobsite_building_activity_label = (string) $get->jobsite_building_activity_label;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'jobsite_building_activity_template_id' => 'jobsite building activity template id',
				'jobsite_activity_list_template_id' => 'jobsite activity list template id',
				'jobsite_building_activity_label' => 'jobsite building activity label',
				'sort_order' => 'sort order',
				'disabled_flag' => 'disabled flag',
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

			if ($attributeSubgroupName == 'jobsite_building_activity_templates') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$jobsite_building_activity_template_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteBuildingActivityTemplate = JobsiteBuildingActivityTemplate::findById($database, $jobsite_building_activity_template_id);
				/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */

				if ($jobsiteBuildingActivityTemplate) {
					// Check if the value actually changed
					$existingValue = $jobsiteBuildingActivityTemplate->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'jobsite_activity_list_template_id' => 1,
						'jobsite_building_activity_label' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $jobsiteBuildingActivityTemplate->$attributeName;
						$jobsiteBuildingActivityTemplate->$attributeName = $newValue;
						$possibleDuplicateJobsiteBuildingActivityTemplate = JobsiteBuildingActivityTemplate::findByJobsiteActivityListTemplateIdAndJobsiteBuildingActivityLabel($database, $jobsiteBuildingActivityTemplate->jobsite_activity_list_template_id, $jobsiteBuildingActivityTemplate->jobsite_building_activity_label);
						if ($possibleDuplicateJobsiteBuildingActivityTemplate) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Jobsite Building Activity Template $newValue already exists.";
						} else {
							$jobsiteBuildingActivityTemplate->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$jobsiteBuildingActivityTemplate->setData($data);
						$jobsiteBuildingActivityTemplate->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Building Activity Template record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
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
			if (isset($jobsiteBuildingActivityTemplate) && $jobsiteBuildingActivityTemplate instanceof JobsiteBuildingActivityTemplate) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
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

	case 'updateAllJobsiteBuildingActivityTemplateAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Building Activity Template';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_building_activity_templates_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Jobsite Building Activity Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates';
			}

			// Unique index attibutes
			$jobsite_activity_list_template_id = (int) $get->jobsite_activity_list_template_id;
			$jobsite_building_activity_label = (string) $get->jobsite_building_activity_label;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_building_activity_templates') {
				$jobsite_building_activity_template_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteBuildingActivityTemplate = JobsiteBuildingActivityTemplate::findById($database, $jobsite_building_activity_template_id);
				/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */

				if ($jobsiteBuildingActivityTemplate) {
					$existingData = $jobsiteBuildingActivityTemplate->getData();

					// Retrieve all of the $_GET inputs automatically for the JobsiteBuildingActivityTemplate record
					$httpGetInputData = $get->getData();
					
					$jobsiteBuildingActivityTemplate->setData($httpGetInputData);
					$jobsiteBuildingActivityTemplate->convertDataToProperties();
					$jobsiteBuildingActivityTemplate->convertPropertiesToData();

					$newData = $jobsiteBuildingActivityTemplate->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$jobsiteBuildingActivityTemplate->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Jobsite Building Activity Template<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					$jobsiteBuildingActivityTemplate->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Building Activity Template record does not exist.';
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
			if (isset($jobsiteBuildingActivityTemplate) && $jobsiteBuildingActivityTemplate instanceof JobsiteBuildingActivityTemplate) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
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

	case 'deleteJobsiteBuildingActivityTemplate':

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
					'jobsite_building_activity_templates_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Jobsite Building Activity Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates';
			}

			// Unique index attibutes
			$jobsite_activity_list_template_id = (int) $get->jobsite_activity_list_template_id;
			$jobsite_building_activity_label = (string) $get->jobsite_building_activity_label;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_building_activity_templates') {
				$jobsite_building_activity_template_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteBuildingActivityTemplate = JobsiteBuildingActivityTemplate::findById($database, $jobsite_building_activity_template_id);
				/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */

				if ($jobsiteBuildingActivityTemplate) {
					$jobsiteBuildingActivityTemplate->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Building Activity Template record does not exist.';
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
			if (isset($jobsiteBuildingActivityTemplate) && $jobsiteBuildingActivityTemplate instanceof JobsiteBuildingActivityTemplate) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
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

	case 'saveJobsiteBuildingActivityTemplate':

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
					'jobsite_building_activity_templates_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Jobsite Building Activity Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Building Activity Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Building Activity Templates';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_building_activity_template-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$jobsiteBuildingActivityTemplate = new JobsiteBuildingActivityTemplate($database);

			// Retrieve all of the $_GET inputs automatically for the JobsiteBuildingActivityTemplate record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteBuildingActivityTemplate->setData($httpGetInputData);
			$jobsiteBuildingActivityTemplate->convertDataToProperties();

			$jobsiteBuildingActivityTemplate->convertPropertiesToData();
			$data = $jobsiteBuildingActivityTemplate->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$jobsite_building_activity_template_id = $jobsiteBuildingActivityTemplate->insertOnDuplicateKeyUpdate();
			if (isset($jobsite_building_activity_template_id) && !empty($jobsite_building_activity_template_id)) {
				$jobsiteBuildingActivityTemplate->jobsite_building_activity_template_id = $jobsite_building_activity_template_id;
				$jobsiteBuildingActivityTemplate->setId($jobsite_building_activity_template_id);
			}

			$jobsiteBuildingActivityTemplate->convertDataToProperties();
			$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Building Activity Template.';
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
			if (isset($jobsiteBuildingActivityTemplate) && $jobsiteBuildingActivityTemplate instanceof JobsiteBuildingActivityTemplate) {
				$primaryKeyAsString = $jobsiteBuildingActivityTemplate->getPrimaryKeyAsString();
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

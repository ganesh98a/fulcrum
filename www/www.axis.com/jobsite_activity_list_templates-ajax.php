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

require_once('lib/common/JobsiteActivityListTemplate.php');
require_once('lib/common/ProjectType.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('jobsite_activity_list_templates-functions.php');
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
	case 'createJobsiteActivityListTemplate':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$htmlRecordTr = '';
		$htmlRecordOption = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_activity_list_templates_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Jobsite Activity List Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Activity List Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Activity List Templates';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_activity_list_template-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the JobsiteActivityListTemplate record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteActivityListTemplate = new JobsiteActivityListTemplate($database);

			$jobsiteActivityListTemplate->setData($httpGetInputData);
			$jobsiteActivityListTemplate->convertDataToProperties();

			$jobsiteActivityListTemplate->user_company_id = $user_company_id;

			$jobsiteActivityListTemplate->convertPropertiesToData();
			$data = $jobsiteActivityListTemplate->getData();

			// Test for existence via standard findByUniqueIndex method
			$jobsiteActivityListTemplate->findByUniqueIndex();
			if ($jobsiteActivityListTemplate->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Jobsite Activity List Template already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$jobsiteActivityListTemplate->setKey(null);
				$jobsiteActivityListTemplate->setData($data);
			}

			$jobsite_activity_list_template_id = $jobsiteActivityListTemplate->save();
			if (isset($jobsite_activity_list_template_id) && !empty($jobsite_activity_list_template_id)) {
				$jobsiteActivityListTemplate->jobsite_activity_list_template_id = $jobsite_activity_list_template_id;
				$jobsiteActivityListTemplate->setId($jobsite_activity_list_template_id);
			}

			$jobsiteActivityListTemplate->convertDataToProperties();
			$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				$jobsite_activity_list_template = $jobsiteActivityListTemplate->jobsite_activity_list_template;
				$project_type_id = $jobsiteActivityListTemplate->project_type_id;
				$sort_order = $jobsiteActivityListTemplate->sort_order;
				$disabled_flag = $jobsiteActivityListTemplate->disabled_flag;

				$checked = '';
				if ($disabled_flag == 'Y') {
					$checked = 'checked';
				}

				$loadProjectTypesByUserCompanyIdOptions = new Input();
				$loadProjectTypesByUserCompanyIdOptions->forceLoadFlag = true;
				$ddlProjectTypesId = 'manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--project_type_id--'.$primaryKeyAsString;
				$ddlProjectTypesJs = 'onchange="updateJobsiteActivityListTemplate(this);"';
				$arrProjectTypesByUserCompanyId = ProjectType::loadProjectTypesByUserCompanyId($database, $user_company_id, $loadProjectTypesByUserCompanyIdOptions);
				$ddlProjectTypes = PageComponents::dropDownListFromObjects($ddlProjectTypesId, $arrProjectTypesByUserCompanyId, 'project_type_id', null, 'project_type', null, $project_type_id, '', $ddlProjectTypesJs, '');

				$htmlRecordOption = '<option value="'.$primaryKeyAsString.'">'.$jobsite_activity_list_template.'</option>';
				$htmlRecordTr .= <<<END_HTML_ROW
<tr id="record_container--manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--sort_order--$jobsite_activity_list_template_id">
	<td class="tdSortBars textAlignCenter"><input type="hidden" value="$sort_order"><img src="/images/sortbars.png"></td>
	<td class="textAlignLeft"><input type="text" style="width:300px" value="$jobsite_activity_list_template" onchange="updateJobsiteActivityListTemplate(this);" id="manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--jobsite_activity_list_template--$primaryKeyAsString"></td>
	<td class="textAlignLeft">$ddlProjectTypes</td>
	<td class="textAlignCenter"><input type="checkbox" onchange="updateJobsiteActivityListTemplate(this);" id="manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--disabled_flag--$primaryKeyAsString" $checked></td>
	<td class="textAlignCenter"><a href="javascript:Daily_Log__Admin__Manage_Jobsite_Activity_List_Templates__deleteJobsiteActivityListTemplate('record_container--manage-jobsite_activity_list_template-record--jobsite_activity_list_templates--sort_order--$primaryKeyAsString', 'manage-jobsite_activity_list_template-record', '$primaryKeyAsString');">X</a></td>
</tr>
END_HTML_ROW;

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Activity List Template.';
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
			if (isset($jobsiteActivityListTemplate) && $jobsiteActivityListTemplate instanceof JobsiteActivityListTemplate) {
				$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlRecordTr|$htmlRecordOption";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadJobsiteActivityListTemplate':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_activity_list_templates_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Activity List Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Activity List Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Activity List Templates';
			}

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$jobsite_activity_list_template = (string) $get->jobsite_activity_list_template;

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
			if (isset($jobsiteActivityListTemplate) && $jobsiteActivityListTemplate instanceof JobsiteActivityListTemplate) {
				$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
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

	case 'loadAllJobsiteActivityListTemplateRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_activity_list_templates_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Jobsite Activity List Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Activity List Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Activity List Templates';
			}
			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$jobsite_activity_list_template = (string) $get->jobsite_activity_list_template;

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

	case 'updateJobsiteActivityListTemplate':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Activity List Template';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_activity_list_templates_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Jobsite Activity List Template - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Activity List Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Activity List Templates';
			}

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$jobsite_activity_list_template = (string) $get->jobsite_activity_list_template;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'jobsite_activity_list_template_id' => 'jobsite activity list template id',
				'user_company_id' => 'user company id',
				'project_type_id' => 'project type id',
				'jobsite_activity_list_template' => 'jobsite activity list template',
				'disabled_flag' => 'disabled flag',
				'sort_order' => 'sort order',
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

			if ($attributeSubgroupName == 'jobsite_activity_list_templates') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$jobsite_activity_list_template_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteActivityListTemplate = JobsiteActivityListTemplate::findById($database, $jobsite_activity_list_template_id);
				/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */

				if ($jobsiteActivityListTemplate) {
					// Check if the value actually changed
					$existingValue = $jobsiteActivityListTemplate->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'user_company_id' => 1,
						'jobsite_activity_list_template' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $jobsiteActivityListTemplate->$attributeName;
						$jobsiteActivityListTemplate->$attributeName = $newValue;
						$possibleDuplicateJobsiteActivityListTemplate = JobsiteActivityListTemplate::findByUserCompanyIdAndJobsiteActivityListTemplate($database, $jobsiteActivityListTemplate->user_company_id, $jobsiteActivityListTemplate->jobsite_activity_list_template);
						if ($possibleDuplicateJobsiteActivityListTemplate) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Jobsite Activity List Template $newValue already exists.";
						} else {
							$jobsiteActivityListTemplate->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$jobsiteActivityListTemplate->setData($data);
						$jobsiteActivityListTemplate->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Activity List Template record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
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
			if (isset($jobsiteActivityListTemplate) && $jobsiteActivityListTemplate instanceof JobsiteActivityListTemplate) {
				$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
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

	case 'updateAllJobsiteActivityListTemplateAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Jobsite Activity List Template';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'jobsite_activity_list_templates_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Jobsite Activity List Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Activity List Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Activity List Templates';
			}
			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$jobsite_activity_list_template = (string) $get->jobsite_activity_list_template;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_activity_list_templates') {
				$jobsite_activity_list_template_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteActivityListTemplate = JobsiteActivityListTemplate::findById($database, $jobsite_activity_list_template_id);
				/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */

				if ($jobsiteActivityListTemplate) {
					$existingData = $jobsiteActivityListTemplate->getData();

					// Retrieve all of the $_GET inputs automatically for the JobsiteActivityListTemplate record
					$httpGetInputData = $get->getData();
					
					$jobsiteActivityListTemplate->setData($httpGetInputData);
					$jobsiteActivityListTemplate->convertDataToProperties();
					$jobsiteActivityListTemplate->convertPropertiesToData();

					$newData = $jobsiteActivityListTemplate->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$jobsiteActivityListTemplate->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Jobsite Activity List Template<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}
					$jobsiteActivityListTemplate->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Activity List Template record does not exist.';
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
			if (isset($jobsiteActivityListTemplate) && $jobsiteActivityListTemplate instanceof JobsiteActivityListTemplate) {
				$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
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

	case 'deleteJobsiteActivityListTemplate':

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
					'jobsite_activity_list_templates_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Jobsite Activity List Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Activity List Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Activity List Templates';
			}

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$jobsite_activity_list_template = (string) $get->jobsite_activity_list_template;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'jobsite_activity_list_templates') {
				$jobsite_activity_list_template_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$jobsiteActivityListTemplate = JobsiteActivityListTemplate::findById($database, $jobsite_activity_list_template_id);
				/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */

				if ($jobsiteActivityListTemplate) {
					$jobsiteActivityListTemplate->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Jobsite Activity List Template record does not exist.';
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
			if (isset($jobsiteActivityListTemplate) && $jobsiteActivityListTemplate instanceof JobsiteActivityListTemplate) {
				$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
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

	case 'saveJobsiteActivityListTemplate':

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
					'jobsite_activity_list_templates_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Jobsite Activity List Template.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Jobsite Activity List Template';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Jobsite Activity List Templates';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-jobsite_activity_list_template-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$jobsiteActivityListTemplate = new JobsiteActivityListTemplate($database);

			// Retrieve all of the $_GET inputs automatically for the JobsiteActivityListTemplate record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$jobsiteActivityListTemplate->setData($httpGetInputData);
			$jobsiteActivityListTemplate->convertDataToProperties();

			$jobsiteActivityListTemplate->convertPropertiesToData();
			$data = $jobsiteActivityListTemplate->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$jobsite_activity_list_template_id = $jobsiteActivityListTemplate->insertOnDuplicateKeyUpdate();
			if (isset($jobsite_activity_list_template_id) && !empty($jobsite_activity_list_template_id)) {
				$jobsiteActivityListTemplate->jobsite_activity_list_template_id = $jobsite_activity_list_template_id;
				$jobsiteActivityListTemplate->setId($jobsite_activity_list_template_id);
			}

			$jobsiteActivityListTemplate->convertDataToProperties();
			$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Jobsite Activity List Template.';
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
			if (isset($jobsiteActivityListTemplate) && $jobsiteActivityListTemplate instanceof JobsiteActivityListTemplate) {
				$primaryKeyAsString = $jobsiteActivityListTemplate->getPrimaryKeyAsString();
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

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
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
//$init['skip_always_include'] = true;
//$init['skip_session'] = true;
//$init['skip_templating'] = true;
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

require_once('lib/common/MeetingType.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('meeting_types-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewMeetingTypes = $permissions->determineAccessToSoftwareModuleFunction('meeting_types_view');
$userCanManageMeetingTypes = $permissions->determineAccessToSoftwareModuleFunction('meeting_types_manage');
*/

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
	case 'createMeetingType':

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
					'meeting_types_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Meeting Type data values.';
				$arrErrorMessages = array(
					'Error creating: Meeting Type.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Type';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Types';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-meeting_type-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_type_id = (int) $get->meeting_type_id;
			$project_id = (int) $get->project_id;
			$meeting_type = (string) $get->meeting_type;
			$meeting_type_abbreviation = (string) $get->meeting_type_abbreviation;
			$show_construction_flag = (string) $get->show_construction_flag;
			$show_schedule_flag = (string) $get->show_schedule_flag;
			$show_plans_flag = (string) $get->show_plans_flag;
			$show_delays_flag = (string) $get->show_delays_flag;
			$show_rfis_flag = (string) $get->show_rfis_flag;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if (isset($scenarioName)) {
				if ($scenarioName == 'createMeetingTypeFromMeetingTypeTemplate') {

					// Fake $_GET inputs for the meeting_type by loading the template record data
					$meeting_type_template_id = Data::parseInt($get->meeting_type_template_id);

					// Check for $meeting_type_template_id
					if (!isset($meeting_type_template_id) || empty($meeting_type_template_id)) {
						$errorMessage = 'Error creating Meeting Type from Template data.<br>Missing meeting_type_template_id.';
						$message->enqueueError($errorMessage, $currentPhpScript);
						throw new Exception($errorMessage);
					}

					require_once('lib/common/MeetingTypeTemplate.php');
					$meetingTypeTemplate = MeetingTypeTemplate::findMeetingTypeTemplateByIdExtended($database, $meeting_type_template_id);
					/* @var $meetingTypeTemplate MeetingTypeTemplate */

					if (!$meetingTypeTemplate) {
						$errorMessage = 'Error creating Meeting Type from Template data.<br>Template does not exist.';
						$message->enqueueError($errorMessage, $currentPhpScript);
						throw new Exception($errorMessage);
					}

					$get->meeting_type = $meetingTypeTemplate->meeting_type;
					$get->meeting_type_abbreviation = $meetingTypeTemplate->meeting_type_abbreviation;

					$ajaxHtmlIncludeFilePath = 'Collaboration_Manager/createMeetingType.php';

				} elseif ($scenarioName == 'createMeetingType') {
					$includeHtmlContentInJsonResponse = true;
					$ajaxHtmlIncludeFilePath = 'Collaboration_Manager/createMeetingType.php';
				}
			}

			// Retrieve all of the $_GET inputs automatically for the MeetingType record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$meetingType = new MeetingType($database);

			$meetingType->setData($httpGetInputData);
			$meetingType->convertDataToProperties();

			/*
			$meetingType->meeting_type_id = $meeting_type_id;
			$meetingType->project_id = $project_id;
			$meetingType->meeting_type = $meeting_type;
			$meetingType->meeting_type_abbreviation = $meeting_type_abbreviation;
			$meetingType->show_construction_flag = $show_construction_flag;
			$meetingType->show_schedule_flag = $show_schedule_flag;
			$meetingType->show_plans_flag = $show_plans_flag;
			$meetingType->show_delays_flag = $show_delays_flag;
			$meetingType->show_rfis_flag = $show_rfis_flag;
			$meetingType->sort_order = $sort_order;
			*/

			$meetingType->project_id = $project_id;

			$meetingType->convertPropertiesToData();
			$data = $meetingType->getData();

			// Test for existence via standard findByUniqueIndex method
			$meetingType->findByUniqueIndex();
			if ($meetingType->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Meeting Type already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$meetingType->setKey(null);
				$meetingType->setData($data);
			}

			$meeting_type_id = $meetingType->save();
			if (isset($meeting_type_id) && !empty($meeting_type_id)) {
				$meetingType->meeting_type_id = $meeting_type_id;
				$meetingType->setId($meeting_type_id);
			}
			// $meetingType->save();

			$meetingType->convertDataToProperties();
			$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Meeting Type.';
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
			//$errorMessage = 'Error creating: Meeting Type';
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
			if (isset($meetingType) && $meetingType instanceof MeetingType) {
				$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
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

	case 'loadMeetingType':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_types_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Meeting Type.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Type';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Types';
			}

			// Primary key attibutes
			//$meeting_type_id = (int) $get->uniqueId;
			// Debug
			//$meeting_type_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type = (string) $get->meeting_type;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Meeting Type';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

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
			if (isset($meetingType) && $meetingType instanceof MeetingType) {
				$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
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

	case 'loadAllMeetingTypeRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_types_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Meeting Type.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Type';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Types';
			}

			// Primary key attibutes
			//$meeting_type_id = (int) $get->uniqueId;
			// Debug
			//$meeting_type_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type = (string) $get->meeting_type;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|meeting_types|Meeting Type|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Meeting Type';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
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

	case 'updateMeetingType':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Meeting Type';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_types_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Meeting Type - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Type';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Types';
			}

			// Primary key attibutes
			//$meeting_type_id = (int) $get->uniqueId;
			// Debug
			//$meeting_type_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type = (string) $get->meeting_type;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'meeting_type_id' => 'meeting type id',
				'project_id' => 'project id',
				'meeting_type' => 'meeting type',
				'meeting_type_abbreviation' => 'meeting type abbreviation',
				'show_construction_flag' => 'show construction flag',
				'show_schedule_flag' => 'show schedule flag',
				'show_plans_flag' => 'show plans flag',
				'show_delays_flag' => 'show delays flag',
				'show_rfis_flag' => 'show rfis flag',
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
				//$error->outputErrorMessages();
				//exit;
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($attributeSubgroupName == 'meeting_types') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$meeting_type_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$meetingType = MeetingType::findById($database, $meeting_type_id);
				/* @var $meetingType MeetingType */

				if ($meetingType) {
					// Check if the value actually changed
					$existingValue = $meetingType->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'project_id' => 1,
						'meeting_type' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $meetingType->$attributeName;
						$meetingType->$attributeName = $newValue;
						$possibleDuplicateMeetingType = MeetingType::findByProjectIdAndMeetingType($database, $meetingType->project_id, $meetingType->meeting_type);
						if ($possibleDuplicateMeetingType) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Meeting Type $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$meetingType->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$meetingType->setData($data);
						// $meeting_type_id = $meetingType->save();
						$meetingType->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting Type record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Meeting Type';
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
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meetingType) && $meetingType instanceof MeetingType) {
				$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
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

	case 'updateAllMeetingTypeAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Meeting Type';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_types_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Meeting Type.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Type';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Types';
			}

			// Primary key attibutes
			//$meeting_type_id = (int) $get->uniqueId;
			// Debug
			//$meeting_type_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type = (string) $get->meeting_type;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_type_id = (int) $get->meeting_type_id;
			$project_id = (int) $get->project_id;
			$meeting_type = (string) $get->meeting_type;
			$meeting_type_abbreviation = (string) $get->meeting_type_abbreviation;
			$show_construction_flag = (string) $get->show_construction_flag;
			$show_schedule_flag = (string) $get->show_schedule_flag;
			$show_plans_flag = (string) $get->show_plans_flag;
			$show_delays_flag = (string) $get->show_delays_flag;
			$show_rfis_flag = (string) $get->show_rfis_flag;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'meeting_types') {
				$meeting_type_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$meetingType = MeetingType::findById($database, $meeting_type_id);
				/* @var $meetingType MeetingType */

				if ($meetingType) {
					$existingData = $meetingType->getData();

					// Retrieve all of the $_GET inputs automatically for the MeetingType record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$meetingType->setData($httpGetInputData);
					$meetingType->convertDataToProperties();
					$meetingType->convertPropertiesToData();

					$newData = $meetingType->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$meetingType->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Meeting Type<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$meetingType->meeting_type_id = $meeting_type_id;
			$meetingType->project_id = $project_id;
			$meetingType->meeting_type = $meeting_type;
			$meetingType->meeting_type_abbreviation = $meeting_type_abbreviation;
			$meetingType->show_construction_flag = $show_construction_flag;
			$meetingType->show_schedule_flag = $show_schedule_flag;
			$meetingType->show_plans_flag = $show_plans_flag;
			$meetingType->show_delays_flag = $show_delays_flag;
			$meetingType->show_rfis_flag = $show_rfis_flag;
			$meetingType->sort_order = $sort_order;
					*/

					// $meeting_type_id = $meetingType->save();
					$meetingType->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting Type record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Meeting Type';
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
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meetingType) && $meetingType instanceof MeetingType) {
				$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
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

	case 'deleteMeetingType':

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
					'meeting_types_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Meeting Type.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Type';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Types';
			}

			// Primary key attibutes
			//$meeting_type_id = (int) $get->uniqueId;
			// Debug
			//$meeting_type_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type = (string) $get->meeting_type;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'meeting_types') {
				$meeting_type_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$meetingType = MeetingType::findById($database, $meeting_type_id);
				/* @var $meetingType MeetingType */

				if ($meetingType) {
					$meetingType->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting Type record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error deleting: Meeting Type';
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
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meetingType) && $meetingType instanceof MeetingType) {
				$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
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

	case 'saveMeetingType':

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
					'meeting_types_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Meeting Type data values.';
				$arrErrorMessages = array(
					'Error saving Meeting Type.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Type';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Types';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-meeting_type-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_type_id = (int) $get->meeting_type_id;
			$project_id = (int) $get->project_id;
			$meeting_type = (string) $get->meeting_type;
			$meeting_type_abbreviation = (string) $get->meeting_type_abbreviation;
			$show_construction_flag = (string) $get->show_construction_flag;
			$show_schedule_flag = (string) $get->show_schedule_flag;
			$show_plans_flag = (string) $get->show_plans_flag;
			$show_delays_flag = (string) $get->show_delays_flag;
			$show_rfis_flag = (string) $get->show_rfis_flag;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$meetingType = new MeetingType($database);

			// Retrieve all of the $_GET inputs automatically for the MeetingType record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$meetingType->setData($httpGetInputData);
			$meetingType->convertDataToProperties();

			/*
			$meetingType->meeting_type_id = $meeting_type_id;
			$meetingType->project_id = $project_id;
			$meetingType->meeting_type = $meeting_type;
			$meetingType->meeting_type_abbreviation = $meeting_type_abbreviation;
			$meetingType->show_construction_flag = $show_construction_flag;
			$meetingType->show_schedule_flag = $show_schedule_flag;
			$meetingType->show_plans_flag = $show_plans_flag;
			$meetingType->show_delays_flag = $show_delays_flag;
			$meetingType->show_rfis_flag = $show_rfis_flag;
			$meetingType->sort_order = $sort_order;
			*/

			$meetingType->convertPropertiesToData();
			$data = $meetingType->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$meeting_type_id = $meetingType->insertOnDuplicateKeyUpdate();
			if (isset($meeting_type_id) && !empty($meeting_type_id)) {
				$meetingType->meeting_type_id = $meeting_type_id;
				$meetingType->setId($meeting_type_id);
			}
			// $meetingType->insertOnDuplicateKeyUpdate();
			// $meetingType->insertIgnore();

			$meetingType->convertDataToProperties();
			$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Meeting Type.';
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
			//$errorMessage = 'Error creating: Meeting Type';
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
			if (isset($meetingType) && $meetingType instanceof MeetingType) {
				$primaryKeyAsString = $meetingType->getPrimaryKeyAsString();
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

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

require_once('lib/common/ActionItemAssignment.php');

require_once('lib/common/Message.php');
require_once('lib/common/User.php');
require_once('lib/common/ActionItem.php');
require_once('lib/common/ActionItemType.php');
require_once('lib/common/Api/UsersNotifications.php');
require_once('lib/common/Api/UsersDeviceInfo.php');

require_once('firebase-push-notification.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF']) && ($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('action_item_assignments-functions.php');
}

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'createActionItemAssignment':

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
					'action_item_assignments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Action Item Assignment data values.';
				$arrErrorMessages = array(
					'Error creating: Action Item Assignment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Action Item Assignment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Action Item Assignments';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-action_item_assignment-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the ActionItemAssignment record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			// Customization: Allow multiple contact_id values at one time.
			$csvContactIds = (string) $get->csvContactIds;
			if (!isset($csvContactIds) || empty($csvContactIds)) {
				$csvContactIds = $get->action_item_assignee_contact_id;
			}
			$arrContactIds = explode(',', $csvContactIds);

		// Customization: Allow multiple contact_id values at one time.
		// foreach loop - indentation for diff of code gen
		$liEditable = '';
		$liUneditable = '';
		foreach ($arrContactIds as $action_item_assignee_contact_id) {

			$actionItemAssignment = new ActionItemAssignment($database);

			$actionItemAssignment->setData($httpGetInputData);
			$actionItemAssignment->convertDataToProperties();

			// Customization: Allow multiple contact_id values at one time.
			// foreach loop - assign each contact_id value
			$actionItemAssignment->action_item_assignee_contact_id = (int) $action_item_assignee_contact_id;

			$actionItemAssignment->convertPropertiesToData();
			$data = $actionItemAssignment->getData();

			// Test for existence via standard findByUniqueIndex method
			$actionItemAssignment->findByUniqueIndex();
			if ($actionItemAssignment->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Action Item Assignment already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$actionItemAssignment->setKey(null);
				$actionItemAssignment->setData($data);
			}
	
			$actionItemAssignment->save();

			$actionItemAssignment->convertDataToProperties();
			$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				$contact = Contact::findById($database, $action_item_assignee_contact_id);
				/* @var $contact Contact */

				$user_id = $contact->user_id;
				// save notification
				// get ActionItemType 
				$action_item_type = 'Meeting Minutes';
				$actionItemType = ActionItemType::findByActionItemType($database, $action_item_type);
				$action_item_type_id = null;
				if (isset($actionItemType) && !empty($actionItemType)) {
					$action_item_type_id = $actionItemType->action_item_type_id;
				}
				//  Notification
				$userNotification = new UsersNotifications($database);
				$arrNotification = array();
				$arrNotification['user_id'] = $user_id;
				$arrNotification['project_id'] = $project_id;
				$arrNotification['user_notification_type_id'] = $action_item_type_id;
				$arrNotification['user_notification_type_reference_id'] = $data['action_item_id'];
				$userNotification->setData($arrNotification);
				$userNotification->convertDataToProperties();
				$user_notification_id = $userNotification->save();
				
				// get the device Token using ids
				$userDeviceInfoFcmToken = UsersDeviceInfo::findByIdUsingUserId($database, $user_id);
				if($userDeviceInfoFcmToken != null) {
					$arrFcmToken  = $userDeviceInfoFcmToken;
				}
				if(isset($arrFcmToken) && !empty($arrFcmToken)){
					$user = User::findById($database, $user_id);
					$user->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
					$user->currentlyActiveContactId = $action_item_assignee_contact_id;
					
					/* @var $contact User */
					
					$checkPermissionTaskSummary = checkPermissionTaskSummary($database, $user, $project_id);
					/* check permission to view tasksummary */
					$actionItem = ActionItem::findById($database, $data['action_item_id']);
					/* get action item*/
					
					$title = 'Meeting Minutes';
					// $bodyContent = 'You have new task to visit';
					$bodyContent = $actionItem->action_item;
					$bodyContent = strlen($bodyContent) > 50 ? substr($bodyContent,0,50)."... Read More" : $bodyContent;
					$options = array();
					$options['task'] = $title;
					$options['project_id'] = $project_id;
					$options['project_name'] = $project_name;
					$options['task_id'] = $data['action_item_id'];
					$options['task_title'] = $actionItem->action_item;
					$options['navigate'] = $checkPermissionTaskSummary;
					$fcm_notification = send_notification($database, $arrFcmToken, $title, $bodyContent, $options);
				}

				$contactFullNameHtmlEscaped = $contact->getContactFullNameHtmlEscaped();

				$elementId = 'record_container--manage-action_item_assignment-record--action_item_assignments--'.$primaryKeyAsString;
				$liEditable .= <<<END_LI_EDITABLE
					<li id="$elementId">
						<a href="javascript:Collaboration_Manager__Meetings__deleteActionItemAssignment('$elementId', 'manage-action_item_assignment-record', '$primaryKeyAsString');">X</a>
						$contactFullNameHtmlEscaped
					</li>
END_LI_EDITABLE;

				$liUneditable .= <<<END_LI_UNEDITABLE
					<li id="record_container--manage-action_item_assignment-record-read_only--action_item_assignments--$primaryKeyAsString">
						$contactFullNameHtmlEscaped
					</li>
END_LI_UNEDITABLE;

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Action Item Assignment.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

		// Customization: Allow multiple contact_id values at one time.
		} // end foreach loop - indentation for diff of code gen

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
			if (isset($actionItemAssignment) && $actionItemAssignment instanceof ActionItemAssignment) {
				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
			}
		}

		// @todo add interface name here as conditionaly include...
		$arrCustomizedJsonOutput = array();
		if (isset($discussion_item_id) && !empty($discussion_item_id)) {
			$arrCustomizedJsonOutput['discussion_item_id'] = $discussion_item_id;
		}
		if (isset($liEditable) && !empty($liEditable)) {
			$arrCustomizedJsonOutput['liEditable'] = $liEditable;
		}
		if (isset($liUneditable) && !empty($liUneditable)) {
			$arrCustomizedJsonOutput['liUneditable'] = $liUneditable;
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

	case 'loadActionItemAssignment':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'action_item_assignments_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Action Item Assignment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Action Item Assignment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Action Item Assignments';
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
			if (isset($actionItemAssignment) && $actionItemAssignment instanceof ActionItemAssignment) {
				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
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

	case 'loadAllActionItemAssignmentRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'action_item_assignments_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Action Item Assignment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Action Item Assignment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Action Item Assignments';
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

	case 'updateActionItemAssignment':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Action Item Assignment';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'action_item_assignments_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Action Item Assignment - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Action Item Assignment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Action Item Assignments';
			}

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'action_item_id' => 'action item id',
				'action_item_assignee_contact_id' => 'action item assignee contact id',
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

			if ($attributeSubgroupName == 'action_item_assignments') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$arrTmp = explode('-', $uniqueId);
				$action_item_id = (int) array_shift($arrTmp);
				$action_item_assignee_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$actionItemAssignment = ActionItemAssignment::findByActionItemIdAndActionItemAssigneeContactId($database, $action_item_id, $action_item_assignee_contact_id);
				/* @var $actionItemAssignment ActionItemAssignment */

				if ($actionItemAssignment) {
					// Check if the value actually changed
					$existingValue = $actionItemAssignment->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$actionItemAssignment->setData($data);
						// $action_item_assignment_id = $actionItemAssignment->save();
						$actionItemAssignment->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Action Item Assignment record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
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
			if (isset($actionItemAssignment) && $actionItemAssignment instanceof ActionItemAssignment) {
				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
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

	case 'updateAllActionItemAssignmentAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Action Item Assignment';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'action_item_assignments_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Action Item Assignment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Action Item Assignment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Action Item Assignments';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'action_item_assignments') {
				$arrTmp = explode('-', $uniqueId);
				$action_item_id = (int) array_shift($arrTmp);
				$action_item_assignee_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$actionItemAssignment = ActionItemAssignment::findByActionItemIdAndActionItemAssigneeContactId($database, $action_item_id, $action_item_assignee_contact_id);
				/* @var $actionItemAssignment ActionItemAssignment */

				if ($actionItemAssignment) {
					$existingData = $actionItemAssignment->getData();

					// Retrieve all of the $_GET inputs automatically for the ActionItemAssignment record
					$httpGetInputData = $get->getData();

					$actionItemAssignment->setData($httpGetInputData);
					$actionItemAssignment->convertDataToProperties();
					$actionItemAssignment->convertPropertiesToData();

					$newData = $actionItemAssignment->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$actionItemAssignment->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Action Item Assignment<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					$actionItemAssignment->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Action Item Assignment record does not exist.';
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
			if (isset($actionItemAssignment) && $actionItemAssignment instanceof ActionItemAssignment) {
				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
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

	case 'deleteActionItemAssignment':

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
					'action_item_assignments_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Action Item Assignment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Action Item Assignment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Action Item Assignments';
			}
			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'action_item_assignments') {
				$arrTmp = explode('-', $uniqueId);
				$action_item_id = (int) array_shift($arrTmp);
				$action_item_assignee_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$actionItemAssignment = ActionItemAssignment::findByActionItemIdAndActionItemAssigneeContactId($database, $action_item_id, $action_item_assignee_contact_id);
				/* @var $actionItemAssignment ActionItemAssignment */

				if ($actionItemAssignment) {
					$actionItemAssignment->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Action Item Assignment record does not exist.';
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
			if (isset($actionItemAssignment) && $actionItemAssignment instanceof ActionItemAssignment) {
				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
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

	case 'saveActionItemAssignment':

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
					'action_item_assignments_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Action Item Assignment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Action Item Assignment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Action Item Assignments';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-action_item_assignment-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$actionItemAssignment = new ActionItemAssignment($database);

			// Retrieve all of the $_GET inputs automatically for the ActionItemAssignment record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$actionItemAssignment->setData($httpGetInputData);
			$actionItemAssignment->convertDataToProperties();

			$actionItemAssignment->convertPropertiesToData();
			$data = $actionItemAssignment->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$actionItemAssignment->insertIgnore();

			$actionItemAssignment->convertDataToProperties();
			$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Action Item Assignment.';
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
			if (isset($actionItemAssignment) && $actionItemAssignment instanceof ActionItemAssignment) {
				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();
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
	default:
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

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
	$init['get_required'] = true;
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
}else if(isset($post)){
	$methodCall = $_POST['method'];

	$attributeGroupName 			= $_POST['attributeGroupName'];
	$attributeSubgroupName 			= $_POST['attributeSubgroupName'];
	$sortOrderFlag 					= $_POST['sortOrderFlag'];
	$uniqueId 						= $_POST['uniqueId'];
	$newAttributeGroupName 			= isset($_POST['newAttributeGroupName'])?$_POST['newAttributeGroupName']:"";
	$formattedAttributeGroupName 	= $_POST['formattedAttributeGroupName'];
	$formattedAttributeSubgroupName = $_POST['formattedAttributeSubgroupName'];	
	$attributeName 					= isset($_POST['attributeName'])?$_POST['attributeName']:"";	
	$newValue 						= isset($_POST['newValue'])?$_POST['newValue']:"";
	$newValueText 					= isset($_POST['newValueText'])?$_POST['newValueText']:"";	
	$formattedAttributeName 		= isset($_POST['formattedAttributeName'])?$_POST['formattedAttributeName']:"";
	$responseDataType				= isset($_POST['responseDataType'])?$_POST['responseDataType']:"";
	$rfi_element					= isset($_POST['rfi_element'])?$_POST['rfi_element']:"";
	$submittal_element				= isset($_POST['submittal_element'])?$_POST['submittal_element']:"";
	$meeting_id						= isset($_POST['meeting_id'])?$_POST['meeting_id']:"";
	$created_by_contact_id			= isset($_POST['created_by_contact_id'])?$_POST['created_by_contact_id']:"";
	$discussion_item_title			= isset($_POST['discussion_item_title'])?$_POST['discussion_item_title']:"";
	$discussion_item				= isset($_POST['discussion_item'])?$_POST['discussion_item']:"";

	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

require_once('lib/common/PageComponents.php');

require_once('lib/common/ActionItem.php');
require_once('lib/common/DiscussionItem.php');
require_once('lib/common/DiscussionItemPriority.php');
require_once('lib/common/DiscussionItemStatus.php');
require_once('lib/common/Meeting.php');

require_once('lib/common/Message.php');
require_once('discussion-new-ajax.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('discussion_items-functions.php');
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
	case 'createDiscussionItem':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = 'Please fill in the Highlighted area';
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
					'discussion_items_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Discussion Item.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Discussion Item';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Discussion Items';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-discussion_item-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the DiscussionItem record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$discussionItem = new DiscussionItem($database);

			$discussionItem->setData($httpGetInputData);
			$discussionItem->convertDataToProperties();
			$discussionItem->convertPropertiesToData();
			$data = $discussionItem->getData();
			/*crack the sort_order*/
			$data['sort_order'] = 0;
			// Test for existence via standard findByUniqueIndex method
			$discussionItem->findByUniqueIndex();
			if ($discussionItem->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Discussion Item already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$discussionItem->setKey(null);
				$data['created'] = null;
				$data['discussion_item'] = $discussion_item;
				$discussionItem->setData($data);
			}

			$discussion_item_id = $discussionItem->save();
			if (isset($discussion_item_id) && !empty($discussion_item_id)) {
				$discussionItem->discussion_item_id = $discussion_item_id;
				$discussionItem->setId($discussion_item_id);
				/*crack the sort_order*/
				$newValue = 0;
				$discussionItem->updateSortOrder($database, $newValue, $discussion_item_id);
			}

			$discussionItem->convertDataToProperties();
			$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
				//If the discussion contains RFI and submittals
			if (!empty($rfi_element) || !empty($submittal_element)) {
				Discussion_AddAction($database,$rfi_element,$submittal_element,$primaryKeyAsString,$created_by_contact_id,$project_id);
			}
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Discussion Item.';
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
			if (isset($discussionItem) && $discussionItem instanceof DiscussionItem) {
				$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
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

	case 'loadDiscussionItem':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'discussion_items_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Discussion Item.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Discussion Item';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Discussion Items';
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
			if (isset($discussionItem) && $discussionItem instanceof DiscussionItem) {
				$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
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

	case 'loadAllDiscussionItemRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'discussion_items_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Discussion Item.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Discussion Item';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Discussion Items';
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

	case 'updateDiscussionItem':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Discussion Item';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'discussion_items_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Discussion Item - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Discussion Item';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Discussion Items';
			}

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'discussion_item_id' => 'discussion item id',
				'meeting_id' => 'meeting id',
				'discussion_item_sequence_number' => 'discussion item sequence number',
				'discussion_item_status_id' => 'discussion item status id',
				'discussion_item_priority_id' => 'discussion item priority id',
				'discussion_item_cost_code_id' => 'discussion item cost code id',
				'created_by_contact_id' => 'created by contact id',
				'discussion_item_title' => 'discussion item title',
				'discussion_item' => 'discussion item',
				'created' => 'created',
				'discussion_item_closed_date' => 'discussion item closed date',
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

			if ($attributeSubgroupName == 'discussion_items') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$discussion_item_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$discussionItem = DiscussionItem::findById($database, $discussion_item_id);
				/* @var $discussionItem DiscussionItem */

				if ($discussionItem) {
					// Check if the value actually changed
					$existingValue = $discussionItem->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					if ($attributeName == 'sort_order') {
						$discussionItem->updateSortOrder($database, $newValue);
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$discussionItem->setData($data);
						$discussionItem->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);

						if ($attributeName == 'discussion_item_status_id') {
							$discussionItemStatus = DiscussionItemStatus::findById($database, $newValue);
							$newValueHtml = $discussionItemStatus->discussion_item_status;
						} elseif ($attributeName == 'discussion_item') {
							$newValueHtml = nl2br($newValue);
						} else {
							$newValueHtml = $newValue;
						}
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Discussion Item record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
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
			if (isset($discussionItem) && $discussionItem instanceof DiscussionItem) {
				$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
			}
		}

		// Dummy placeholder for now
		$previousId = '';

		// @todo add interface name here as conditionaly include...
		$arrCustomizedJsonOutput = array();
		if (isset($newValueHtml) && !empty($newValueHtml)) {
			$arrCustomizedJsonOutput['htmlRecord'] = $newValueHtml;
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$attributeName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$formattedAttributeName|$resetToPreviousValue|$performRefreshOperation|$previousId";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateAllDiscussionItemAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Discussion Item';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'discussion_items_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Discussion Item.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Discussion Item';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Discussion Items';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'discussion_items') {
				$discussion_item_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$discussionItem = DiscussionItem::findById($database, $discussion_item_id);
				/* @var $discussionItem DiscussionItem */

				if ($discussionItem) {
					$existingData = $discussionItem->getData();

					// Retrieve all of the $_GET inputs automatically for the DiscussionItem record
					$httpGetInputData = $get->getData();
					
					$discussionItem->setData($httpGetInputData);
					$discussionItem->convertDataToProperties();
					$discussionItem->convertPropertiesToData();

					$newData = $discussionItem->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$discussionItem->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Discussion Item<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}
					$discussionItem->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Discussion Item record does not exist.';
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
			if (isset($discussionItem) && $discussionItem instanceof DiscussionItem) {
				$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
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

	case 'deleteDiscussionItem':

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
					'discussion_items_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Discussion Item.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Discussion Item';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Discussion Items';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'discussion_items') {
				$discussion_item_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$discussionItem = DiscussionItem::findById($database, $discussion_item_id);
				/* @var $discussionItem DiscussionItem */

				if ($discussionItem) {
					// Delete Action Items
					ActionItem::deleteActionItemsByDiscussionItemId($database, $discussion_item_id);

					$discussionItem->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Discussion Item record does not exist.';
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
			if (isset($discussionItem) && $discussionItem instanceof DiscussionItem) {
				$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
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

	case 'saveDiscussionItem':

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
					'discussion_items_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Discussion Item.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Discussion Item';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Discussion Items';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-discussion_item-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$discussionItem = new DiscussionItem($database);

			// Retrieve all of the $_GET inputs automatically for the DiscussionItem record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$discussionItem->setData($httpGetInputData);
			$discussionItem->convertDataToProperties();

			$discussionItem->convertPropertiesToData();
			$data = $discussionItem->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$discussion_item_id = $discussionItem->insertOnDuplicateKeyUpdate();
			if (isset($discussion_item_id) && !empty($discussion_item_id)) {
				$discussionItem->discussion_item_id = $discussion_item_id;
				$discussionItem->setId($discussion_item_id);
			}

			$discussionItem->convertDataToProperties();
			$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Discussion Item.';
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
			if (isset($discussionItem) && $discussionItem instanceof DiscussionItem) {
				$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
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

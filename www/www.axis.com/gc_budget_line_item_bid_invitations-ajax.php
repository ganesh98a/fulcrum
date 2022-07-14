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

require_once('lib/common/FileManagerFile.php');
require_once('lib/common/GcBudgetLineItemBidInvitation.php');
require_once('lib/common/GcBudgetLineItem.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('gc_budget_line_item_bid_invitations-functions.php');

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
	case 'createGcBudgetLineItemBidInvitation':

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
					'gc_budget_line_item_bid_invitations_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Gc Budget Line Item Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Bid Invitations';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-gc_budget_line_item_bid_invitation-record';
			}

			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the GcBudgetLineItemBidInvitation record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$gcBudgetLineItemBidInvitation = new GcBudgetLineItemBidInvitation($database);

			$gcBudgetLineItemBidInvitation->setData($httpGetInputData);
			$gcBudgetLineItemBidInvitation->convertDataToProperties();

			if (!isset($get->gc_budget_line_item_bid_invitation_sequence_number)) {
				$gc_budget_line_item_bid_invitation_sequence_number = GcBudgetLineItemBidInvitation::findNextGcBudgetLineItemBidInvitationSequenceNumber($database, $gc_budget_line_item_id);
				$gcBudgetLineItemBidInvitation->gc_budget_line_item_bid_invitation_sequence_number = $gc_budget_line_item_bid_invitation_sequence_number;
			}

			$gcBudgetLineItemBidInvitation->convertPropertiesToData();
			$data = $gcBudgetLineItemBidInvitation->getData();

			// Test for existence via standard findByUniqueIndex method
			$gcBudgetLineItemBidInvitation->findByUniqueIndex();
			if ($gcBudgetLineItemBidInvitation->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Gc Budget Line Item Bid Invitation already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$gcBudgetLineItemBidInvitation->setKey(null);
				$data['created'] = null;
				$gcBudgetLineItemBidInvitation->setData($data);
			}

			$gc_budget_line_item_bid_invitation_id = $gcBudgetLineItemBidInvitation->save();
			if (isset($gc_budget_line_item_bid_invitation_id) && !empty($gc_budget_line_item_bid_invitation_id)) {
				$gcBudgetLineItemBidInvitation->gc_budget_line_item_bid_invitation_id = $gc_budget_line_item_bid_invitation_id;
				$gcBudgetLineItemBidInvitation->setId($gc_budget_line_item_bid_invitation_id);
			}

			$gcBudgetLineItemBidInvitation->convertDataToProperties();
			$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				if ($includeHtmlRecord) {
					// Insert custom HTML Record code here...
					// "tr" or "li"
					switch ($htmlRecordType) {
						case 'tr':
							// @todo Add companion renderOrmAsLiElement(...) function to php include
							$htmlRecord = renderGcBudgetLineItemBidInvitationAsTrElement($database, $gcBudgetLineItemBidInvitation);
							break;
						default:
						case 'li':
							// @todo Add companion renderOrmAsLiElement(...) function to php include
							$htmlRecord = renderGcBudgetLineItemBidInvitationAsLiElement($database, $gcBudgetLineItemBidInvitation);
							break;
						case 'dropdown':
							// @todo Add companion renderOrmAsLiElement(...) function to php include
							$loadGcBudgetLineItemBidInvitationsByGcBudgetLineItemIdOptions = new Input();
							$loadGcBudgetLineItemBidInvitationsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
							$arrGcBudgetLineItemBidInvitations =
								GcBudgetLineItemBidInvitation::loadGcBudgetLineItemBidInvitationsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadGcBudgetLineItemBidInvitationsByGcBudgetLineItemIdOptions);
							$htmlRecord = renderGcBudgetLineItemBidInvitationsAsBootstrapDropdown($database, $arrGcBudgetLineItemBidInvitations, $debugMode);
							break;
					}
				}

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Gc Budget Line Item Bid Invitation.';
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
			if (isset($gcBudgetLineItemBidInvitation) && $gcBudgetLineItemBidInvitation instanceof GcBudgetLineItemBidInvitation) {
				$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$uniqueId|$htmlRecord|$refreshWindow|$refreshWindowDomContainer|$refreshWindowAjaxUrl";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadGcBudgetLineItemBidInvitation':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'gc_budget_line_item_bid_invitations_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Gc Budget Line Item Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Bid Invitations';
			}
			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$gc_budget_line_item_bid_invitation_sequence_number = (int) $get->gc_budget_line_item_bid_invitation_sequence_number;

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
			if (isset($gcBudgetLineItemBidInvitation) && $gcBudgetLineItemBidInvitation instanceof GcBudgetLineItemBidInvitation) {
				$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
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

	case 'loadAllGcBudgetLineItemBidInvitationRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'gc_budget_line_item_bid_invitations_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Gc Budget Line Item Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Bid Invitations';
			}

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$gc_budget_line_item_bid_invitation_sequence_number = (int) $get->gc_budget_line_item_bid_invitation_sequence_number;

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

	case 'updateGcBudgetLineItemBidInvitation':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Gc Budget Line Item Bid Invitation';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'gc_budget_line_item_bid_invitations_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Gc Budget Line Item Bid Invitation - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Bid Invitations';
			}

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$gc_budget_line_item_bid_invitation_sequence_number = (int) $get->gc_budget_line_item_bid_invitation_sequence_number;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'gc_budget_line_item_bid_invitation_id' => 'gc budget line item bid invitation id',
				'gc_budget_line_item_id' => 'gc budget line item id',
				'gc_budget_line_item_bid_invitation_sequence_number' => 'gc budget line item bid invitation sequence number',
				'gc_budget_line_item_bid_invitation_file_manager_file_id' => 'gc budget line item bid invitation file manager file id',
				'gc_budget_line_item_bid_invitation_file_sha1' => 'gc budget line item bid invitation file sha1',
				'created' => 'created',
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

			if ($attributeSubgroupName == 'gc_budget_line_item_bid_invitations') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$gc_budget_line_item_bid_invitation_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$gcBudgetLineItemBidInvitation = GcBudgetLineItemBidInvitation::findById($database, $gc_budget_line_item_bid_invitation_id);
				/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */

				if ($gcBudgetLineItemBidInvitation) {
					// Check if the value actually changed
					$existingValue = $gcBudgetLineItemBidInvitation->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'gc_budget_line_item_id' => 1,
						'gc_budget_line_item_bid_invitation_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $gcBudgetLineItemBidInvitation->$attributeName;
						$gcBudgetLineItemBidInvitation->$attributeName = $newValue;
						$possibleDuplicateGcBudgetLineItemBidInvitation = GcBudgetLineItemBidInvitation::findByGcBudgetLineItemIdAndGcBudgetLineItemBidInvitationSequenceNumber($database, $gcBudgetLineItemBidInvitation->gc_budget_line_item_id, $gcBudgetLineItemBidInvitation->gc_budget_line_item_bid_invitation_sequence_number);
						if ($possibleDuplicateGcBudgetLineItemBidInvitation) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Gc Budget Line Item Bid Invitation $newValue already exists.";
						} else {
							$gcBudgetLineItemBidInvitation->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$gcBudgetLineItemBidInvitation->setData($data);
						$gcBudgetLineItemBidInvitation->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Gc Budget Line Item Bid Invitation record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
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
			if (isset($gcBudgetLineItemBidInvitation) && $gcBudgetLineItemBidInvitation instanceof GcBudgetLineItemBidInvitation) {
				$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
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

	case 'updateAllGcBudgetLineItemBidInvitationAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Gc Budget Line Item Bid Invitation';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'gc_budget_line_item_bid_invitations_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Gc Budget Line Item Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Bid Invitations';
			}

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$gc_budget_line_item_bid_invitation_sequence_number = (int) $get->gc_budget_line_item_bid_invitation_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'gc_budget_line_item_bid_invitations') {
				$gc_budget_line_item_bid_invitation_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$gcBudgetLineItemBidInvitation = GcBudgetLineItemBidInvitation::findById($database, $gc_budget_line_item_bid_invitation_id);
				/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */

				if ($gcBudgetLineItemBidInvitation) {
					$existingData = $gcBudgetLineItemBidInvitation->getData();

					// Retrieve all of the $_GET inputs automatically for the GcBudgetLineItemBidInvitation record
					$httpGetInputData = $get->getData();

					$gcBudgetLineItemBidInvitation->setData($httpGetInputData);
					$gcBudgetLineItemBidInvitation->convertDataToProperties();
					$gcBudgetLineItemBidInvitation->convertPropertiesToData();

					$newData = $gcBudgetLineItemBidInvitation->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$gcBudgetLineItemBidInvitation->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Gc Budget Line Item Bid Invitation<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					$gcBudgetLineItemBidInvitation->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Gc Budget Line Item Bid Invitation record does not exist.';
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
			if (isset($gcBudgetLineItemBidInvitation) && $gcBudgetLineItemBidInvitation instanceof GcBudgetLineItemBidInvitation) {
				$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
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

	case 'deleteGcBudgetLineItemBidInvitation':

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
					'gc_budget_line_item_bid_invitations_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Gc Budget Line Item Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Bid Invitations';
			}

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$gc_budget_line_item_bid_invitation_sequence_number = (int) $get->gc_budget_line_item_bid_invitation_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'gc_budget_line_item_bid_invitations') {
				$gc_budget_line_item_bid_invitation_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$gcBudgetLineItemBidInvitation = GcBudgetLineItemBidInvitation::findById($database, $gc_budget_line_item_bid_invitation_id);
				/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */

				if ($gcBudgetLineItemBidInvitation) {
					$gcBudgetLineItemBidInvitation->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Gc Budget Line Item Bid Invitation record does not exist.';
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
			if (isset($gcBudgetLineItemBidInvitation) && $gcBudgetLineItemBidInvitation instanceof GcBudgetLineItemBidInvitation) {
				$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
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

	case 'saveGcBudgetLineItemBidInvitation':

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
					'gc_budget_line_item_bid_invitations_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Gc Budget Line Item Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Bid Invitations';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-gc_budget_line_item_bid_invitation-record';
			}
			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$gcBudgetLineItemBidInvitation = new GcBudgetLineItemBidInvitation($database);

			// Retrieve all of the $_GET inputs automatically for the GcBudgetLineItemBidInvitation record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$gcBudgetLineItemBidInvitation->setData($httpGetInputData);
			$gcBudgetLineItemBidInvitation->convertDataToProperties();

			$gcBudgetLineItemBidInvitation->convertPropertiesToData();
			$data = $gcBudgetLineItemBidInvitation->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$gc_budget_line_item_bid_invitation_id = $gcBudgetLineItemBidInvitation->insertOnDuplicateKeyUpdate();
			if (isset($gc_budget_line_item_bid_invitation_id) && !empty($gc_budget_line_item_bid_invitation_id)) {
				$gcBudgetLineItemBidInvitation->gc_budget_line_item_bid_invitation_id = $gc_budget_line_item_bid_invitation_id;
				$gcBudgetLineItemBidInvitation->setId($gc_budget_line_item_bid_invitation_id);
			}

			$gcBudgetLineItemBidInvitation->convertDataToProperties();
			$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Gc Budget Line Item Bid Invitation.';
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
			if (isset($gcBudgetLineItemBidInvitation) && $gcBudgetLineItemBidInvitation instanceof GcBudgetLineItemBidInvitation) {
				$primaryKeyAsString = $gcBudgetLineItemBidInvitation->getPrimaryKeyAsString();
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

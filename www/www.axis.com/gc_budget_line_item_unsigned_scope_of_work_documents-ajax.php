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
require_once('lib/common/GcBudgetLineItemUnsignedScopeOfWorkDocument.php');
require_once('lib/common/GcBudgetLineItem.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);
		require_once('gc_budget_line_item_unsigned_scope_of_work_documents-functions.php');
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
	case 'createGcBudgetLineItemUnsignedScopeOfWorkDocument':

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
					'gc_budget_line_item_unsigned_scope_of_work_documents_manage' => 1
				);
				$arrErrorMessages = array(
					'Error creating: Gc Budget Line Item Unsigned Scope Of Work Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Unsigned Scope Of Work Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Unsigned Scope Of Work Documents';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-gc_budget_line_item_unsigned_scope_of_work_document-record';
			}

			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the GcBudgetLineItemUnsignedScopeOfWorkDocument record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$gcBudgetLineItemUnsignedScopeOfWorkDocument = new GcBudgetLineItemUnsignedScopeOfWorkDocument($database);

			$gcBudgetLineItemUnsignedScopeOfWorkDocument->setData($httpGetInputData);
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertDataToProperties();

			if (!isset($get->unsigned_scope_of_work_document_sequence_number)) {
				$unsigned_scope_of_work_document_sequence_number = GcBudgetLineItemUnsignedScopeOfWorkDocument::findNextGcBudgetLineItemUnsignedScopeOfWorkDocumentSequenceNumber($database, $gc_budget_line_item_id);
				$gcBudgetLineItemUnsignedScopeOfWorkDocument->unsigned_scope_of_work_document_sequence_number = $unsigned_scope_of_work_document_sequence_number;
			}

			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertPropertiesToData();
			$data = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getData();

			// Test for existence via standard findByUniqueIndex method
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->findByUniqueIndex();
			if ($gcBudgetLineItemUnsignedScopeOfWorkDocument->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Gc Budget Line Item Unsigned Scope Of Work Document already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			} else {
				$gcBudgetLineItemUnsignedScopeOfWorkDocument->setKey(null);
				$data['created'] = null;
				$gcBudgetLineItemUnsignedScopeOfWorkDocument->setData($data);
			}

			$gc_budget_line_item_unsigned_scope_of_work_document_id = $gcBudgetLineItemUnsignedScopeOfWorkDocument->save();
			if (isset($gc_budget_line_item_unsigned_scope_of_work_document_id) && !empty($gc_budget_line_item_unsigned_scope_of_work_document_id)) {
				$gcBudgetLineItemUnsignedScopeOfWorkDocument->gc_budget_line_item_unsigned_scope_of_work_document_id = $gc_budget_line_item_unsigned_scope_of_work_document_id;
				$gcBudgetLineItemUnsignedScopeOfWorkDocument->setId($gc_budget_line_item_unsigned_scope_of_work_document_id);
			}

			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertDataToProperties();
			$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();

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
							$htmlRecord = renderGcBudgetLineItemUnsignedScopeOfWorkDocumentAsTrElement($database, $gcBudgetLineItemUnsignedScopeOfWorkDocument);
							break;
						default:
						case 'li':
							// @todo Add companion renderOrmAsLiElement(...) function to php include
							$htmlRecord = renderGcBudgetLineItemUnsignedScopeOfWorkDocumentAsLiElement($database, $gcBudgetLineItemUnsignedScopeOfWorkDocument);
							break;
						case 'dropdown':
							// @todo Add companion renderOrmAsLiElement(...) function to php include
							$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions = new Input();
							$loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
							$arrGcBudgetLineItemUnsignedScopeOfWorkDocuments =
								GcBudgetLineItemUnsignedScopeOfWorkDocument::loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemIdOptions);
							$htmlRecord = renderGcBudgetLineItemUnsignedScopeOfWorkDocumentsAsBootstrapDropdown($database, $arrGcBudgetLineItemUnsignedScopeOfWorkDocuments, $debugMode);
							break;
					}
				}

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Gc Budget Line Item Unsigned Scope Of Work Document.';
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
			if (isset($gcBudgetLineItemUnsignedScopeOfWorkDocument) && $gcBudgetLineItemUnsignedScopeOfWorkDocument instanceof GcBudgetLineItemUnsignedScopeOfWorkDocument) {
				$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
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

	case 'loadGcBudgetLineItemUnsignedScopeOfWorkDocument':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'gc_budget_line_item_unsigned_scope_of_work_documents_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Gc Budget Line Item Unsigned Scope Of Work Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Unsigned Scope Of Work Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Unsigned Scope Of Work Documents';
			}

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$unsigned_scope_of_work_document_sequence_number = (int) $get->unsigned_scope_of_work_document_sequence_number;

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
			if (isset($gcBudgetLineItemUnsignedScopeOfWorkDocument) && $gcBudgetLineItemUnsignedScopeOfWorkDocument instanceof GcBudgetLineItemUnsignedScopeOfWorkDocument) {
				$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
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

	case 'loadAllGcBudgetLineItemUnsignedScopeOfWorkDocumentRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'gc_budget_line_item_unsigned_scope_of_work_documents_view' => 1
				);
				$arrErrorMessages = array(
					'Error loading: Gc Budget Line Item Unsigned Scope Of Work Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Unsigned Scope Of Work Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Unsigned Scope Of Work Documents';
			}

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$unsigned_scope_of_work_document_sequence_number = (int) $get->unsigned_scope_of_work_document_sequence_number;

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

	case 'updateGcBudgetLineItemUnsignedScopeOfWorkDocument':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Gc Budget Line Item Unsigned Scope Of Work Document';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'gc_budget_line_item_unsigned_scope_of_work_documents_manage' => 1
				);
				$arrErrorMessages = array(
					"Error updating Gc Budget Line Item Unsigned Scope Of Work Document - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Unsigned Scope Of Work Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Unsigned Scope Of Work Documents';
			}
			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$unsigned_scope_of_work_document_sequence_number = (int) $get->unsigned_scope_of_work_document_sequence_number;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'gc_budget_line_item_unsigned_scope_of_work_document_id' => 'gc budget line item unsigned scope of work document id',
				'gc_budget_line_item_id' => 'gc budget line item id',
				'unsigned_scope_of_work_document_sequence_number' => 'unsigned scope of work document sequence number',
				'unsigned_scope_of_work_document_file_manager_file_id' => 'unsigned scope of work document file manager file id',
				'unsigned_scope_of_work_document_file_sha1' => 'unsigned scope of work document file sha1',
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

			if ($attributeSubgroupName == 'gc_budget_line_item_unsigned_scope_of_work_documents') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$gc_budget_line_item_unsigned_scope_of_work_document_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$gcBudgetLineItemUnsignedScopeOfWorkDocument = GcBudgetLineItemUnsignedScopeOfWorkDocument::findById($database, $gc_budget_line_item_unsigned_scope_of_work_document_id);
				/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */

				if ($gcBudgetLineItemUnsignedScopeOfWorkDocument) {
					// Check if the value actually changed
					$existingValue = $gcBudgetLineItemUnsignedScopeOfWorkDocument->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'gc_budget_line_item_id' => 1,
						'unsigned_scope_of_work_document_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $gcBudgetLineItemUnsignedScopeOfWorkDocument->$attributeName;
						$gcBudgetLineItemUnsignedScopeOfWorkDocument->$attributeName = $newValue;
						$possibleDuplicateGcBudgetLineItemUnsignedScopeOfWorkDocument = GcBudgetLineItemUnsignedScopeOfWorkDocument::findByGcBudgetLineItemIdAndUnsignedScopeOfWorkDocumentSequenceNumber($database, $gcBudgetLineItemUnsignedScopeOfWorkDocument->gc_budget_line_item_id, $gcBudgetLineItemUnsignedScopeOfWorkDocument->unsigned_scope_of_work_document_sequence_number);
						if ($possibleDuplicateGcBudgetLineItemUnsignedScopeOfWorkDocument) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Gc Budget Line Item Unsigned Scope Of Work Document $newValue already exists.";
						} else {
							$gcBudgetLineItemUnsignedScopeOfWorkDocument->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$gcBudgetLineItemUnsignedScopeOfWorkDocument->setData($data);
						$gcBudgetLineItemUnsignedScopeOfWorkDocument->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Gc Budget Line Item Unsigned Scope Of Work Document record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}

				$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
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
			if (isset($gcBudgetLineItemUnsignedScopeOfWorkDocument) && $gcBudgetLineItemUnsignedScopeOfWorkDocument instanceof GcBudgetLineItemUnsignedScopeOfWorkDocument) {
				$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
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

	case 'updateAllGcBudgetLineItemUnsignedScopeOfWorkDocumentAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Gc Budget Line Item Unsigned Scope Of Work Document';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'gc_budget_line_item_unsigned_scope_of_work_documents_manage' => 1
				);
				$arrErrorMessages = array(
					'Error updating Gc Budget Line Item Unsigned Scope Of Work Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Unsigned Scope Of Work Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Unsigned Scope Of Work Documents';
			}

			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$unsigned_scope_of_work_document_sequence_number = (int) $get->unsigned_scope_of_work_document_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'gc_budget_line_item_unsigned_scope_of_work_documents') {
				$gc_budget_line_item_unsigned_scope_of_work_document_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$gcBudgetLineItemUnsignedScopeOfWorkDocument = GcBudgetLineItemUnsignedScopeOfWorkDocument::findById($database, $gc_budget_line_item_unsigned_scope_of_work_document_id);
				/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */

				if ($gcBudgetLineItemUnsignedScopeOfWorkDocument) {
					$existingData = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getData();

					// Retrieve all of the $_GET inputs automatically for the GcBudgetLineItemUnsignedScopeOfWorkDocument record
					$httpGetInputData = $get->getData();
					
					$gcBudgetLineItemUnsignedScopeOfWorkDocument->setData($httpGetInputData);
					$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertDataToProperties();
					$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertPropertiesToData();

					$newData = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$gcBudgetLineItemUnsignedScopeOfWorkDocument->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Gc Budget Line Item Unsigned Scope Of Work Document<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}
					$gcBudgetLineItemUnsignedScopeOfWorkDocument->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Gc Budget Line Item Unsigned Scope Of Work Document record does not exist.';
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
			if (isset($gcBudgetLineItemUnsignedScopeOfWorkDocument) && $gcBudgetLineItemUnsignedScopeOfWorkDocument instanceof GcBudgetLineItemUnsignedScopeOfWorkDocument) {
				$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
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

	case 'deleteGcBudgetLineItemUnsignedScopeOfWorkDocument':

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
					'gc_budget_line_item_unsigned_scope_of_work_documents_manage' => 1
				);
				$arrErrorMessages = array(
					'Error deleting Gc Budget Line Item Unsigned Scope Of Work Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Unsigned Scope Of Work Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Unsigned Scope Of Work Documents';
			}
			// Unique index attibutes
			$gc_budget_line_item_id = (int) $get->gc_budget_line_item_id;
			$unsigned_scope_of_work_document_sequence_number = (int) $get->unsigned_scope_of_work_document_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'gc_budget_line_item_unsigned_scope_of_work_documents') {
				$gc_budget_line_item_unsigned_scope_of_work_document_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$gcBudgetLineItemUnsignedScopeOfWorkDocument = GcBudgetLineItemUnsignedScopeOfWorkDocument::findById($database, $gc_budget_line_item_unsigned_scope_of_work_document_id);
				/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */

				if ($gcBudgetLineItemUnsignedScopeOfWorkDocument) {
					$gcBudgetLineItemUnsignedScopeOfWorkDocument->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Gc Budget Line Item Unsigned Scope Of Work Document record does not exist.';
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
			if (isset($gcBudgetLineItemUnsignedScopeOfWorkDocument) && $gcBudgetLineItemUnsignedScopeOfWorkDocument instanceof GcBudgetLineItemUnsignedScopeOfWorkDocument) {
				$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
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

	case 'saveGcBudgetLineItemUnsignedScopeOfWorkDocument':

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
					'gc_budget_line_item_unsigned_scope_of_work_documents_manage' => 1
				);
				$arrErrorMessages = array(
					'Error saving Gc Budget Line Item Unsigned Scope Of Work Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Gc Budget Line Item Unsigned Scope Of Work Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Gc Budget Line Item Unsigned Scope Of Work Documents';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-gc_budget_line_item_unsigned_scope_of_work_document-record';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$gcBudgetLineItemUnsignedScopeOfWorkDocument = new GcBudgetLineItemUnsignedScopeOfWorkDocument($database);

			// Retrieve all of the $_GET inputs automatically for the GcBudgetLineItemUnsignedScopeOfWorkDocument record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$gcBudgetLineItemUnsignedScopeOfWorkDocument->setData($httpGetInputData);
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertDataToProperties();

			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertPropertiesToData();
			$data = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$gc_budget_line_item_unsigned_scope_of_work_document_id = $gcBudgetLineItemUnsignedScopeOfWorkDocument->insertOnDuplicateKeyUpdate();
			if (isset($gc_budget_line_item_unsigned_scope_of_work_document_id) && !empty($gc_budget_line_item_unsigned_scope_of_work_document_id)) {
				$gcBudgetLineItemUnsignedScopeOfWorkDocument->gc_budget_line_item_unsigned_scope_of_work_document_id = $gc_budget_line_item_unsigned_scope_of_work_document_id;
				$gcBudgetLineItemUnsignedScopeOfWorkDocument->setId($gc_budget_line_item_unsigned_scope_of_work_document_id);
			}

			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertDataToProperties();
			$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Gc Budget Line Item Unsigned Scope Of Work Document.';
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
			if (isset($gcBudgetLineItemUnsignedScopeOfWorkDocument) && $gcBudgetLineItemUnsignedScopeOfWorkDocument instanceof GcBudgetLineItemUnsignedScopeOfWorkDocument) {
				$primaryKeyAsString = $gcBudgetLineItemUnsignedScopeOfWorkDocument->getPrimaryKeyAsString();
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

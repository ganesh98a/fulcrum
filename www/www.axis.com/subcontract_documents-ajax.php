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

require_once('lib/common/SubcontractDocument.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('subcontract_documents-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewSubcontractDocuments = $permissions->determineAccessToSoftwareModuleFunction('subcontract_documents_view');
$userCanManageSubcontractDocuments = $permissions->determineAccessToSoftwareModuleFunction('subcontract_documents_manage');
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
	case 'createSubcontractDocument':

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
					'subcontract_documents_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Subcontract Document data values.';
				$arrErrorMessages = array(
					'Error creating: Subcontract Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontract Documents';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-subcontract_document-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$subcontract_document_id = (int) $get->subcontract_document_id;
			$subcontract_id = (int) $get->subcontract_id;
			$subcontract_item_template_id = (int) $get->subcontract_item_template_id;
			$unsigned_subcontract_document_file_manager_file_id = (int) $get->unsigned_subcontract_document_file_manager_file_id;
			$signed_subcontract_document_file_manager_file_id = (int) $get->signed_subcontract_document_file_manager_file_id;
			$auto_generated_flag = (string) $get->auto_generated_flag;
			$disabled_flag = (string) $get->disabled_flag;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the SubcontractDocument record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$subcontractDocument = new SubcontractDocument($database);

			$subcontractDocument->setData($httpGetInputData);
			$subcontractDocument->convertDataToProperties();

			/*
			$subcontractDocument->subcontract_document_id = $subcontract_document_id;
			$subcontractDocument->subcontract_id = $subcontract_id;
			$subcontractDocument->subcontract_item_template_id = $subcontract_item_template_id;
			$subcontractDocument->unsigned_subcontract_document_file_manager_file_id = $unsigned_subcontract_document_file_manager_file_id;
			$subcontractDocument->signed_subcontract_document_file_manager_file_id = $signed_subcontract_document_file_manager_file_id;
			$subcontractDocument->auto_generated_flag = $auto_generated_flag;
			$subcontractDocument->disabled_flag = $disabled_flag;
			$subcontractDocument->sort_order = $sort_order;
			*/

			$subcontractDocument->convertPropertiesToData();
			$data = $subcontractDocument->getData();

			// Test for existence via standard findByUniqueIndex method
			$subcontractDocument->findByUniqueIndex();
			if ($subcontractDocument->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Subcontract Document already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$subcontractDocument->setKey(null);
				$subcontractDocument->setData($data);
			}

			$subcontract_document_id = $subcontractDocument->save();
			if (isset($subcontract_document_id) && !empty($subcontract_document_id)) {
				$subcontractDocument->subcontract_document_id = $subcontract_document_id;
				$subcontractDocument->setId($subcontract_document_id);
			}
			// $subcontractDocument->save();

			$subcontractDocument->convertDataToProperties();
			$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Subcontract Document.';
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
			//$errorMessage = 'Error creating: Subcontract Document';
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
			if (isset($subcontractDocument) && $subcontractDocument instanceof SubcontractDocument) {
				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
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

	case 'loadSubcontractDocument':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'subcontract_documents_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Subcontract Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontract Documents';
			}

			// Primary key attibutes
			//$subcontract_document_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_document_id = (int) 1;

			// Unique index attibutes
			$subcontract_id = (int) $get->subcontract_id;
			$subcontract_item_template_id = (int) $get->subcontract_item_template_id;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Subcontract Document';
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
			if (isset($subcontractDocument) && $subcontractDocument instanceof SubcontractDocument) {
				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
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

	case 'loadAllSubcontractDocumentRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'subcontract_documents_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Subcontract Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontract Documents';
			}

			// Primary key attibutes
			//$subcontract_document_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_document_id = (int) 1;

			// Unique index attibutes
			$subcontract_id = (int) $get->subcontract_id;
			$subcontract_item_template_id = (int) $get->subcontract_item_template_id;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|subcontract_documents|Subcontract Document|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Subcontract Document';
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

	case 'updateSubcontractDocument':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Subcontract Document';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'subcontract_documents_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Subcontract Document - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontract Documents';
			}

			// Primary key attibutes
			//$subcontract_document_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_document_id = (int) 1;

			// Unique index attibutes
			$subcontract_id = (int) $get->subcontract_id;
			$subcontract_item_template_id = (int) $get->subcontract_item_template_id;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'subcontract_document_id' => 'subcontract document id',
				'subcontract_id' => 'subcontract id',
				'subcontract_item_template_id' => 'subcontract item template id',
				'unsigned_subcontract_document_file_manager_file_id' => 'unsigned subcontract document file manager file id',
				'signed_subcontract_document_file_manager_file_id' => 'signed subcontract document file manager file id',
				'auto_generated_flag' => 'auto generated flag',
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
				//$error->outputErrorMessages();
				//exit;
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($attributeSubgroupName == 'subcontract_documents') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$subcontract_document_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontractDocument = SubcontractDocument::findById($database, $subcontract_document_id);
				/* @var $subcontractDocument SubcontractDocument */

				if ($subcontractDocument) {
					// Check if the value actually changed
					$existingValue = $subcontractDocument->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'subcontract_id' => 1,
						'subcontract_item_template_id' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $subcontractDocument->$attributeName;
						$subcontractDocument->$attributeName = $newValue;
						$possibleDuplicateSubcontractDocument = SubcontractDocument::findBySubcontractIdAndSubcontractItemTemplateId($database, $subcontractDocument->subcontract_id, $subcontractDocument->subcontract_item_template_id);
						if ($possibleDuplicateSubcontractDocument) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Subcontract Document $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$subcontractDocument->$attributeName = $existingValue;
						}
					}

					if ($attributeName == 'sort_order') {
						$subcontractDocument->updateSortOrder($database, $newValue);
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$subcontractDocument->setData($data);
						// $subcontract_document_id = $subcontractDocument->save();
						$subcontractDocument->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Subcontract Document record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Subcontract Document';
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
			if (isset($subcontractDocument) && $subcontractDocument instanceof SubcontractDocument) {
				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
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

	case 'updateAllSubcontractDocumentAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Subcontract Document';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'subcontract_documents_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Subcontract Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontract Documents';
			}

			// Primary key attibutes
			//$subcontract_document_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_document_id = (int) 1;

			// Unique index attibutes
			$subcontract_id = (int) $get->subcontract_id;
			$subcontract_item_template_id = (int) $get->subcontract_item_template_id;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$subcontract_document_id = (int) $get->subcontract_document_id;
			$subcontract_id = (int) $get->subcontract_id;
			$subcontract_item_template_id = (int) $get->subcontract_item_template_id;
			$unsigned_subcontract_document_file_manager_file_id = (int) $get->unsigned_subcontract_document_file_manager_file_id;
			$signed_subcontract_document_file_manager_file_id = (int) $get->signed_subcontract_document_file_manager_file_id;
			$auto_generated_flag = (string) $get->auto_generated_flag;
			$disabled_flag = (string) $get->disabled_flag;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'subcontract_documents') {
				$subcontract_document_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontractDocument = SubcontractDocument::findById($database, $subcontract_document_id);
				/* @var $subcontractDocument SubcontractDocument */

				if ($subcontractDocument) {
					$existingData = $subcontractDocument->getData();

					// Retrieve all of the $_GET inputs automatically for the SubcontractDocument record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$subcontractDocument->setData($httpGetInputData);
					$subcontractDocument->convertDataToProperties();
					$subcontractDocument->convertPropertiesToData();

					$newData = $subcontractDocument->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$subcontractDocument->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Subcontract Document<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$subcontractDocument->subcontract_document_id = $subcontract_document_id;
			$subcontractDocument->subcontract_id = $subcontract_id;
			$subcontractDocument->subcontract_item_template_id = $subcontract_item_template_id;
			$subcontractDocument->unsigned_subcontract_document_file_manager_file_id = $unsigned_subcontract_document_file_manager_file_id;
			$subcontractDocument->signed_subcontract_document_file_manager_file_id = $signed_subcontract_document_file_manager_file_id;
			$subcontractDocument->auto_generated_flag = $auto_generated_flag;
			$subcontractDocument->disabled_flag = $disabled_flag;
			$subcontractDocument->sort_order = $sort_order;
					*/

					// $subcontract_document_id = $subcontractDocument->save();
					$subcontractDocument->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Subcontract Document record does not exist.';
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
			//$errorMessage = 'Error updating: Subcontract Document';
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
			if (isset($subcontractDocument) && $subcontractDocument instanceof SubcontractDocument) {
				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
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

	case 'deleteSubcontractDocument':

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
					'subcontract_documents_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Subcontract Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontract Documents';
			}

			// Primary key attibutes
			//$subcontract_document_id = (int) $get->uniqueId;
			// Debug
			//$subcontract_document_id = (int) 1;

			// Unique index attibutes
			$subcontract_id = (int) $get->subcontract_id;
			$subcontract_item_template_id = (int) $get->subcontract_item_template_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'subcontract_documents') {
				$subcontract_document_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$subcontractDocument = SubcontractDocument::findById($database, $subcontract_document_id);
				/* @var $subcontractDocument SubcontractDocument */

				if ($subcontractDocument) {
					$subcontractDocument->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Subcontract Document record does not exist.';
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
			//$errorMessage = 'Error deleting: Subcontract Document';
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
			if (isset($subcontractDocument) && $subcontractDocument instanceof SubcontractDocument) {
				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
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

	case 'saveSubcontractDocument':

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
					'subcontract_documents_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Subcontract Document data values.';
				$arrErrorMessages = array(
					'Error saving Subcontract Document.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Subcontract Document';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Subcontract Documents';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-subcontract_document-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$subcontract_document_id = (int) $get->subcontract_document_id;
			$subcontract_id = (int) $get->subcontract_id;
			$subcontract_item_template_id = (int) $get->subcontract_item_template_id;
			$unsigned_subcontract_document_file_manager_file_id = (int) $get->unsigned_subcontract_document_file_manager_file_id;
			$signed_subcontract_document_file_manager_file_id = (int) $get->signed_subcontract_document_file_manager_file_id;
			$auto_generated_flag = (string) $get->auto_generated_flag;
			$disabled_flag = (string) $get->disabled_flag;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$subcontractDocument = new SubcontractDocument($database);

			// Retrieve all of the $_GET inputs automatically for the SubcontractDocument record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$subcontractDocument->setData($httpGetInputData);
			$subcontractDocument->convertDataToProperties();

			/*
			$subcontractDocument->subcontract_document_id = $subcontract_document_id;
			$subcontractDocument->subcontract_id = $subcontract_id;
			$subcontractDocument->subcontract_item_template_id = $subcontract_item_template_id;
			$subcontractDocument->unsigned_subcontract_document_file_manager_file_id = $unsigned_subcontract_document_file_manager_file_id;
			$subcontractDocument->signed_subcontract_document_file_manager_file_id = $signed_subcontract_document_file_manager_file_id;
			$subcontractDocument->auto_generated_flag = $auto_generated_flag;
			$subcontractDocument->disabled_flag = $disabled_flag;
			$subcontractDocument->sort_order = $sort_order;
			*/

			$subcontractDocument->convertPropertiesToData();
			$data = $subcontractDocument->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$subcontract_document_id = $subcontractDocument->insertOnDuplicateKeyUpdate();
			if (isset($subcontract_document_id) && !empty($subcontract_document_id)) {
				$subcontractDocument->subcontract_document_id = $subcontract_document_id;
				$subcontractDocument->setId($subcontract_document_id);
			}
			// $subcontractDocument->insertOnDuplicateKeyUpdate();
			// $subcontractDocument->insertIgnore();

			$subcontractDocument->convertDataToProperties();
			$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Subcontract Document.';
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
			//$errorMessage = 'Error creating: Subcontract Document';
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
			if (isset($subcontractDocument) && $subcontractDocument instanceof SubcontractDocument) {
				$primaryKeyAsString = $subcontractDocument->getPrimaryKeyAsString();
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

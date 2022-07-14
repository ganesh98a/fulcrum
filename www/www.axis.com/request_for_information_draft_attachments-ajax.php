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

require_once('lib/common/RequestForInformationDraftAttachment.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('request_for_information_draft_attachments-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewRequestForInformationDraftAttachments = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_draft_attachments_view');
$userCanManageRequestForInformationDraftAttachments = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_draft_attachments_manage');
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
	case 'createRequestForInformationDraftAttachment':

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
					'request_for_information_draft_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Request For Information Draft Attachment data values.';
				$arrErrorMessages = array(
					'Error creating: Request For Information Draft Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Draft Attachments';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_draft_attachment-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_draft_id = (int) $get->request_for_information_draft_id;
			$rfi_attachment_file_manager_file_id = (int) $get->rfi_attachment_file_manager_file_id;
			$rfi_attachment_source_contact_id = (int) $get->rfi_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$csvRfiFileManagerFileIds = $get->csvRfiFileManagerFileIds;
			$arrRfiFileManagerFileIds = explode(',', $csvRfiFileManagerFileIds);
			foreach ($arrRfiFileManagerFileIds as $rfi_attachment_file_manager_file_id) {
				$rfi_attachment_file_manager_file_id = (int) $rfi_attachment_file_manager_file_id;
				if ($rfi_attachment_file_manager_file_id == 0) {
					continue;
				}

				$requestForInformationDraftAttachment = new RequestForInformationDraftAttachment($database);

				// Retrieve all of the $_GET inputs automatically for the RequestForInformationDraftAttachment record
				$httpGetInputData = $get->getData();
				foreach ($httpGetInputData as $k => $v) {
					if (empty($v)) {
						unset($httpGetInputData[$k]);
					}
				}

				$requestForInformationDraftAttachment->setData($httpGetInputData);
				$requestForInformationDraftAttachment->convertDataToProperties();

				/*
				$requestForInformationDraftAttachment->request_for_information_draft_id = $request_for_information_draft_id;
				$requestForInformationDraftAttachment->rfi_attachment_file_manager_file_id = $rfi_attachment_file_manager_file_id;
				$requestForInformationDraftAttachment->rfi_attachment_source_contact_id = $rfi_attachment_source_contact_id;
				$requestForInformationDraftAttachment->sort_order = $sort_order;
				*/

				$requestForInformationDraftAttachment->rfi_attachment_file_manager_file_id = $rfi_attachment_file_manager_file_id;

				$requestForInformationDraftAttachment->convertPropertiesToData();
				$data = $requestForInformationDraftAttachment->getData();

				// Test for existence via standard findByUniqueIndex method
				$requestForInformationDraftAttachment->findByUniqueIndex();
				if ($requestForInformationDraftAttachment->isDataLoaded()) {
					// Want ALL the data saved so do not throw an exception
					continue;

					/*
					// Error code here
					$errorMessage = 'Request For Information Draft Attachment already exists.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
					throw new Exception($errorMessage);
					*/
					//$error->outputErrorMessages();
					//exit;
				} else {
					$requestForInformationDraftAttachment->setKey(null);
					$requestForInformationDraftAttachment->setData($data);
				}

				// $request_for_information_draft_attachment_id = $requestForInformationDraftAttachment->save();
				$requestForInformationDraftAttachment->save();

				$requestForInformationDraftAttachment->convertDataToProperties();
				$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();

				// Output standard formatted error or success message
				if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
					// Success
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Error code here
					$errorNumber = 1;
					$errorMessage = 'Error creating: Request For Information Draft Attachment.';
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
			//$errorMessage = 'Error creating: Request For Information Draft Attachment';
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
			if (isset($requestForInformationDraftAttachment) && $requestForInformationDraftAttachment instanceof RequestForInformationDraftAttachment) {
				$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
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

	case 'loadRequestForInformationDraftAttachment':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_draft_attachments_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Draft Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Draft Attachments';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Draft Attachment';
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
			if (isset($requestForInformationDraftAttachment) && $requestForInformationDraftAttachment instanceof RequestForInformationDraftAttachment) {
				$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
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

	case 'loadAllRequestForInformationDraftAttachmentRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_draft_attachments_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Draft Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Draft Attachments';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|request_for_information_draft_attachments|Request For Information Draft Attachment|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Draft Attachment';
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

	case 'updateRequestForInformationDraftAttachment':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Draft Attachment';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_draft_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Request For Information Draft Attachment - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Draft Attachments';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'request_for_information_draft_id' => 'request for information draft id',
				'rfi_attachment_file_manager_file_id' => 'rfi attachment file manager file id',
				'rfi_attachment_source_contact_id' => 'rfi attachment source contact id',
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

			if ($attributeSubgroupName == 'request_for_information_draft_attachments') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_draft_id = (int) array_shift($arrTmp);
				$rfi_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationDraftAttachment = RequestForInformationDraftAttachment::findByRequestForInformationDraftIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_draft_id, $rfi_attachment_file_manager_file_id);
				/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */

				if ($requestForInformationDraftAttachment) {
					// Check if the value actually changed
					$existingValue = $requestForInformationDraftAttachment->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$requestForInformationDraftAttachment->setData($data);
						// $request_for_information_draft_attachment_id = $requestForInformationDraftAttachment->save();
						$requestForInformationDraftAttachment->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Draft Attachment record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Request For Information Draft Attachment';
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
			if (isset($requestForInformationDraftAttachment) && $requestForInformationDraftAttachment instanceof RequestForInformationDraftAttachment) {
				$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
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

	case 'updateAllRequestForInformationDraftAttachmentAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Draft Attachment';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_draft_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Request For Information Draft Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Draft Attachments';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_draft_id = (int) $get->request_for_information_draft_id;
			$rfi_attachment_file_manager_file_id = (int) $get->rfi_attachment_file_manager_file_id;
			$rfi_attachment_source_contact_id = (int) $get->rfi_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_draft_attachments') {
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_draft_id = (int) array_shift($arrTmp);
				$rfi_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationDraftAttachment = RequestForInformationDraftAttachment::findByRequestForInformationDraftIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_draft_id, $rfi_attachment_file_manager_file_id);
				/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */

				if ($requestForInformationDraftAttachment) {
					$existingData = $requestForInformationDraftAttachment->getData();

					// Retrieve all of the $_GET inputs automatically for the RequestForInformationDraftAttachment record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$requestForInformationDraftAttachment->setData($httpGetInputData);
					$requestForInformationDraftAttachment->convertDataToProperties();
					$requestForInformationDraftAttachment->convertPropertiesToData();

					$newData = $requestForInformationDraftAttachment->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$requestForInformationDraftAttachment->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Request For Information Draft Attachment<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$requestForInformationDraftAttachment->request_for_information_draft_id = $request_for_information_draft_id;
			$requestForInformationDraftAttachment->rfi_attachment_file_manager_file_id = $rfi_attachment_file_manager_file_id;
			$requestForInformationDraftAttachment->rfi_attachment_source_contact_id = $rfi_attachment_source_contact_id;
			$requestForInformationDraftAttachment->sort_order = $sort_order;
					*/

					// $request_for_information_draft_attachment_id = $requestForInformationDraftAttachment->save();
					$requestForInformationDraftAttachment->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Draft Attachment record does not exist.';
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
			//$errorMessage = 'Error updating: Request For Information Draft Attachment';
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
			if (isset($requestForInformationDraftAttachment) && $requestForInformationDraftAttachment instanceof RequestForInformationDraftAttachment) {
				$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
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

	case 'deleteRequestForInformationDraftAttachment':

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
					'request_for_information_draft_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Request For Information Draft Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Draft Attachments';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_draft_attachments') {
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_draft_id = (int) array_shift($arrTmp);
				$rfi_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationDraftAttachment = RequestForInformationDraftAttachment::findByRequestForInformationDraftIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_draft_id, $rfi_attachment_file_manager_file_id);
				/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */

				if ($requestForInformationDraftAttachment) {
					$requestForInformationDraftAttachment->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Draft Attachment record does not exist.';
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
			//$errorMessage = 'Error deleting: Request For Information Draft Attachment';
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
			if (isset($requestForInformationDraftAttachment) && $requestForInformationDraftAttachment instanceof RequestForInformationDraftAttachment) {
				$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
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

	case 'saveRequestForInformationDraftAttachment':

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
					'request_for_information_draft_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Request For Information Draft Attachment data values.';
				$arrErrorMessages = array(
					'Error saving Request For Information Draft Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Draft Attachments';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_draft_attachment-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_draft_id = (int) $get->request_for_information_draft_id;
			$rfi_attachment_file_manager_file_id = (int) $get->rfi_attachment_file_manager_file_id;
			$rfi_attachment_source_contact_id = (int) $get->rfi_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$requestForInformationDraftAttachment = new RequestForInformationDraftAttachment($database);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformationDraftAttachment record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$requestForInformationDraftAttachment->setData($httpGetInputData);
			$requestForInformationDraftAttachment->convertDataToProperties();

			/*
			$requestForInformationDraftAttachment->request_for_information_draft_id = $request_for_information_draft_id;
			$requestForInformationDraftAttachment->rfi_attachment_file_manager_file_id = $rfi_attachment_file_manager_file_id;
			$requestForInformationDraftAttachment->rfi_attachment_source_contact_id = $rfi_attachment_source_contact_id;
			$requestForInformationDraftAttachment->sort_order = $sort_order;
			*/

			$requestForInformationDraftAttachment->convertPropertiesToData();
			$data = $requestForInformationDraftAttachment->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			// $request_for_information_draft_attachment_id = $requestForInformationDraftAttachment->insertOnDuplicateKeyUpdate();
			$requestForInformationDraftAttachment->insertOnDuplicateKeyUpdate();
			// $requestForInformationDraftAttachment->insertIgnore();

			$requestForInformationDraftAttachment->convertDataToProperties();
			$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information Draft Attachment.';
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
			//$errorMessage = 'Error creating: Request For Information Draft Attachment';
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
			if (isset($requestForInformationDraftAttachment) && $requestForInformationDraftAttachment instanceof RequestForInformationDraftAttachment) {
				$primaryKeyAsString = $requestForInformationDraftAttachment->getPrimaryKeyAsString();
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

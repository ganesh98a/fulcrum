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

require_once('lib/common/Contact.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/RequestForInformationAttachment.php');
require_once('lib/common/RequestForInformationDraftAttachment.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('request_for_information_attachments-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewRequestForInformationAttachments = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_attachments_view');
$userCanManageRequestForInformationAttachments = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_attachments_manage');
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
	case 'createRequestForInformationAttachment':

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
					'request_for_information_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Request For Information Attachment data values.';
				$arrErrorMessages = array(
					'Error creating: Request For Information Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Attachments';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_attachment-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_id = (int) $get->request_for_information_id;
			$rfi_attachment_file_manager_file_id = (int) $get->rfi_attachment_file_manager_file_id;
			$rfi_attachment_source_contact_id = (int) $get->rfi_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$csvRfiFileManagerFileIds = $get->csvRfiFileManagerFileIds;
			$csvRfiFileManagerFileIds = trim($csvRfiFileManagerFileIds, " \t\n\r\0\x0B,");
			$arrRfiFileManagerFileIds = explode(',', $csvRfiFileManagerFileIds);

			// If $get->rfi_attachment_file_manager_file_id is set then ignore $csvRfiFileManagerFileIds.
			$rfi_attachment_file_manager_file_id = (int) $get->rfi_attachment_file_manager_file_id;
			if ($rfi_attachment_file_manager_file_id > 0) {
				$arrRfiFileManagerFileIds = array($rfi_attachment_file_manager_file_id);
			}
			$sort_order=0;
			foreach ($arrRfiFileManagerFileIds as $rfi_attachment_file_manager_file_id) {
				$rfi_attachment_file_manager_file_id = (int) $rfi_attachment_file_manager_file_id;
				if ($rfi_attachment_file_manager_file_id == 0) {
					continue;
				}

				$requestForInformationAttachment = new RequestForInformationAttachment($database);

				// Retrieve all of the $_GET inputs automatically for the RequestForInformationAttachment record
				$httpGetInputData = $get->getData();
				foreach ($httpGetInputData as $k => $v) {
					if (empty($v)) {
						unset($httpGetInputData[$k]);
					}
				}

				$requestForInformationAttachment->setData($httpGetInputData);
				$requestForInformationAttachment->convertDataToProperties();

				/*
				$requestForInformationAttachment->request_for_information_id = $request_for_information_id;
				$requestForInformationAttachment->rfi_attachment_file_manager_file_id = $rfi_attachment_file_manager_file_id;
				$requestForInformationAttachment->rfi_attachment_source_contact_id = $rfi_attachment_source_contact_id;
				$requestForInformationAttachment->sort_order = $sort_order;
				*/

				$requestForInformationAttachment->rfi_attachment_file_manager_file_id = $rfi_attachment_file_manager_file_id;

				$requestForInformationAttachment->convertPropertiesToData();
				$data = $requestForInformationAttachment->getData();
				$data['sort_order']=$sort_order;
				$sort_order++;

				// Test for existence via standard findByUniqueIndex method
				$requestForInformationAttachment->findByUniqueIndex();
				if ($requestForInformationAttachment->isDataLoaded()) {
					// Error code here
					$errorMessage = 'Request For Information Attachment already exists.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				} else {
					$requestForInformationAttachment->setKey(null);
					$requestForInformationAttachment->setData($data);
				}

				// $request_for_information_attachment_id = $requestForInformationAttachment->save();
				$requestForInformationAttachment->save();

				$requestForInformationAttachment->convertDataToProperties();
				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();

				// Output standard formatted error or success message
				if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
					// Success
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);

					$fileManagerFile = FileManagerFile::findById($database, $requestForInformationAttachment->rfi_attachment_file_manager_file_id);
					/* @var $fileManagerFile FileManagerFile */
					$fileManagerFile->htmlEntityEscapeProperties();
					$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
					$fileUrl = $fileManagerFile->generateUrl();
					$containerElementId = "record_container--manage-request_for_information_attachment-record--request_for_information_attachments--sort_order--$primaryKeyAsString";
					//$index = strpos($containerElementId, 'manage');
					$index = false;
					if ($index) {
						$rfi_attachment_source_contact_id = $requestForInformationAttachment->rfi_attachment_source_contact_id;
						$rfiAttachmentSourceContact = Contact::findContactByIdExtended($database, $rfi_attachment_source_contact_id);
						/* @var $rfiAttachmentSourceContact Contact */
						$rfiAttachmentSourceContact->htmlEntityEscapeProperties();
						$rfiAttachmentSourceContactFullNameHtmlEscaped = $rfiAttachmentSourceContact->getContactFullNameHtmlEscaped();

						$htmlRecord .= <<<END_HTML_RECORD

						<tr id="$containerElementId">
							<td width="60%">
								<a href="javascript:RFIs__deleteRequestForInformationAttachmentViaPromiseChain('$containerElementId', 'manage-request_for_information_attachment-record', '$primaryKeyAsString');">X</a>
								<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
							</td>
							<td width="40%">$rfiAttachmentSourceContactFullNameHtmlEscaped</td>
						</tr>
END_HTML_RECORD;

					} else {

						$htmlRecord .= <<<END_HTML_RECORD

						<li id="$containerElementId">
							<a href="javascript:RFIs__deleteRequestForInformationAttachmentViaPromiseChain('$containerElementId', 'manage-request_for_information_attachment-record', '$primaryKeyAsString');">X</a>
							<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
						</li>
END_HTML_RECORD;

					}

				} else {
					// Error code here
					$errorNumber = 1;
					$errorMessage = 'Error creating: Request For Information Attachment.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
			}
			// @todo Update this to support a list of files
			$arrCustomizedJsonOutput = array('containerElementId' => $containerElementId);

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Request For Information Attachment';
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
			if (isset($requestForInformationAttachment) && $requestForInformationAttachment instanceof RequestForInformationAttachment) {
				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$uniqueId|$htmlRecord|$containerElementId";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadRequestForInformationAttachment':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_attachments_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Attachments';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;
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
			//$errorMessage = 'Error loading: Request For Information Attachment';
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
			if (isset($requestForInformationAttachment) && $requestForInformationAttachment instanceof RequestForInformationAttachment) {
				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
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

	case 'loadAllRequestForInformationAttachmentRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_attachments_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Attachments';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|request_for_information_attachments|Request For Information Attachment|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Attachment';
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

	case 'updateRequestForInformationAttachment':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Attachment';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Request For Information Attachment - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Attachments';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'request_for_information_id' => 'request for information id',
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

			if ($attributeSubgroupName == 'request_for_information_attachments') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_id = (int) array_shift($arrTmp);
				$rfi_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationAttachment = RequestForInformationAttachment::findByRequestForInformationIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_id, $rfi_attachment_file_manager_file_id);
				/* @var $requestForInformationAttachment RequestForInformationAttachment */

				if ($requestForInformationAttachment) {
					// Check if the value actually changed
					$existingValue = $requestForInformationAttachment->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$requestForInformationAttachment->setData($data);
						// $request_for_information_attachment_id = $requestForInformationAttachment->save();
						$requestForInformationAttachment->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Attachment record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Request For Information Attachment';
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
			if (isset($requestForInformationAttachment) && $requestForInformationAttachment instanceof RequestForInformationAttachment) {
				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
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

	case 'updateAllRequestForInformationAttachmentAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Attachment';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Request For Information Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Attachments';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_id = (int) $get->request_for_information_id;
			$rfi_attachment_file_manager_file_id = (int) $get->rfi_attachment_file_manager_file_id;
			$rfi_attachment_source_contact_id = (int) $get->rfi_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_attachments') {
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_id = (int) array_shift($arrTmp);
				$rfi_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationAttachment = RequestForInformationAttachment::findByRequestForInformationIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_id, $rfi_attachment_file_manager_file_id);
				/* @var $requestForInformationAttachment RequestForInformationAttachment */

				if ($requestForInformationAttachment) {
					$existingData = $requestForInformationAttachment->getData();

					// Retrieve all of the $_GET inputs automatically for the RequestForInformationAttachment record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$requestForInformationAttachment->setData($httpGetInputData);
					$requestForInformationAttachment->convertDataToProperties();
					$requestForInformationAttachment->convertPropertiesToData();

					$newData = $requestForInformationAttachment->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$requestForInformationAttachment->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Request For Information Attachment<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$requestForInformationAttachment->request_for_information_id = $request_for_information_id;
			$requestForInformationAttachment->rfi_attachment_file_manager_file_id = $rfi_attachment_file_manager_file_id;
			$requestForInformationAttachment->rfi_attachment_source_contact_id = $rfi_attachment_source_contact_id;
			$requestForInformationAttachment->sort_order = $sort_order;
					*/

					// $request_for_information_attachment_id = $requestForInformationAttachment->save();
					$requestForInformationAttachment->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Attachment record does not exist.';
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
			//$errorMessage = 'Error updating: Request For Information Attachment';
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
			if (isset($requestForInformationAttachment) && $requestForInformationAttachment instanceof RequestForInformationAttachment) {
				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
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

	case 'deleteRequestForInformationAttachment':

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
					'request_for_information_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Request For Information Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Attachments';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_attachments') {
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_id = (int) array_shift($arrTmp);
				$rfi_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationAttachment = RequestForInformationAttachment::findByRequestForInformationIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_id, $rfi_attachment_file_manager_file_id);
				/* @var $requestForInformationAttachment RequestForInformationAttachment */

				if ($requestForInformationAttachment) {
					$requestForInformationAttachment->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);

					$fileManagerFile = FileManagerFile::findById($database, $rfi_attachment_file_manager_file_id);
					if ($fileManagerFile) {
						$fileManagerFile->delete();
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Attachment record does not exist.';
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
			//$errorMessage = 'Error deleting: Request For Information Attachment';
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
			if (isset($requestForInformationAttachment) && $requestForInformationAttachment instanceof RequestForInformationAttachment) {
				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
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

	case 'deleteRequestForInformationAttachmentDraft':

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
					'request_for_information_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Request For Information Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Attachments';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;
			//$rfi_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$rfi_attachment_file_manager_file_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);			
			
			if ($attributeSubgroupName == 'request_for_information_attachments') {

				$arrTmp = explode('-', $uniqueId);
				$request_for_information_id = (int) array_shift($arrTmp);
				$rfi_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationAttachment = RequestForInformationDraftAttachment::findByRequestForInformationDraftIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_id, $rfi_attachment_file_manager_file_id);				
				
				if ($requestForInformationAttachment) {					
					$requestForInformationAttachment->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);

					$fileManagerFile = FileManagerFile::findById($database, $rfi_attachment_file_manager_file_id);
					if ($fileManagerFile) {
						$fileManagerFile->delete();
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Attachment record does not exist.';
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
			//$errorMessage = 'Error deleting: Request For Information Attachment';
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
			if (isset($requestForInformationAttachment) && $requestForInformationAttachment instanceof RequestForInformationAttachment) {
				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
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

	case 'saveRequestForInformationAttachment':

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
					'request_for_information_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Request For Information Attachment data values.';
				$arrErrorMessages = array(
					'Error saving Request For Information Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Attachments';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_attachment-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_id = (int) $get->request_for_information_id;
			$rfi_attachment_file_manager_file_id = (int) $get->rfi_attachment_file_manager_file_id;
			$rfi_attachment_source_contact_id = (int) $get->rfi_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$requestForInformationAttachment = new RequestForInformationAttachment($database);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformationAttachment record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$requestForInformationAttachment->setData($httpGetInputData);
			$requestForInformationAttachment->convertDataToProperties();

			/*
			$requestForInformationAttachment->request_for_information_id = $request_for_information_id;
			$requestForInformationAttachment->rfi_attachment_file_manager_file_id = $rfi_attachment_file_manager_file_id;
			$requestForInformationAttachment->rfi_attachment_source_contact_id = $rfi_attachment_source_contact_id;
			$requestForInformationAttachment->sort_order = $sort_order;
			*/

			$requestForInformationAttachment->convertPropertiesToData();
			$data = $requestForInformationAttachment->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			// $request_for_information_attachment_id = $requestForInformationAttachment->insertOnDuplicateKeyUpdate();
			$requestForInformationAttachment->insertOnDuplicateKeyUpdate();
			// $requestForInformationAttachment->insertIgnore();

			$requestForInformationAttachment->convertDataToProperties();
			$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information Attachment.';
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
			//$errorMessage = 'Error creating: Request For Information Attachment';
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
			if (isset($requestForInformationAttachment) && $requestForInformationAttachment instanceof RequestForInformationAttachment) {
				$primaryKeyAsString = $requestForInformationAttachment->getPrimaryKeyAsString();
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

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
require_once('lib/common/SubmittalAttachment.php');
require_once('lib/common/SubmittalDraftAttachment.php');


require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('submittal_attachments-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewSubmittalAttachments = $permissions->determineAccessToSoftwareModuleFunction('submittal_attachments_view');
$userCanManageSubmittalAttachments = $permissions->determineAccessToSoftwareModuleFunction('submittal_attachments_manage');
*/

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
	case 'createSubmittalAttachment':

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
					'submittal_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Submittal Attachment data values.';
				$arrErrorMessages = array(
					'Error creating: Submittal Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Attachments';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal_attachment-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_id = (int) $get->submittal_id;
			$su_attachment_file_manager_file_id = (int) $get->su_attachment_file_manager_file_id;
			$su_attachment_source_contact_id = (int) $get->su_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$csvSuFileManagerFileIds = $get->csvSuFileManagerFileIds;
			$csvSuFileManagerFileIds = trim($csvSuFileManagerFileIds, " \t\n\r\0\x0B,");
			$arrSuFileManagerFileIds = explode(',', $csvSuFileManagerFileIds);

			// If $get->su_attachment_file_manager_file_id is set then ignore $csvSuFileManagerFileIds.
			$su_attachment_file_manager_file_id = (int) $get->su_attachment_file_manager_file_id;
			if ($su_attachment_file_manager_file_id > 0) {
				$arrSuFileManagerFileIds = array($su_attachment_file_manager_file_id);
			}
			$sort_order = 0;
			foreach ($arrSuFileManagerFileIds as $su_attachment_file_manager_file_id) {
				$su_attachment_file_manager_file_id = (int) $su_attachment_file_manager_file_id;
				if ($su_attachment_file_manager_file_id == 0) {
					continue;
				}

				// check the project user_company_id with logged in user_company_id
				if ($currentlySelectedProjectUserCompanyId != $user_company_id) {
					$fileManagerFile = FileManagerFile::findById($database, $su_attachment_file_manager_file_id);
					if (isset($fileManagerFile) && !empty($fileManagerFile)) {
						$fileUserCompanyId = $fileManagerFile->user_company_id;
						$file_manager_folder_id = $fileManagerFile->file_manager_folder_id;
						// Set Permissions of the file to match the parent folder.
						// $fileManagerFileSetPermission = FileManagerFile::setPermissionsToMatchParentFolder($database, $su_attachment_file_manager_file_id, $file_manager_folder_id);
						//  if not match update the user_company_id as project user_company_id
						if ($currentlySelectedProjectUserCompanyId != $fileUserCompanyId) {
							$data = array(
								'user_company_id' => $currentlySelectedProjectUserCompanyId
							);
							$fileManagerFile->convertPropertiesToData();
							$fileManagerFile->setData($data);
							$fileManagerFile->save();
						}
					}
				}

				$submittalAttachment = new SubmittalAttachment($database);

				// Retrieve all of the $_GET inputs automatically for the SubmittalAttachment record
				$httpGetInputData = $get->getData();
				foreach ($httpGetInputData as $k => $v) {
					if (empty($v)) {
						unset($httpGetInputData[$k]);
					}
				}

				$submittalAttachment->setData($httpGetInputData);
				$submittalAttachment->convertDataToProperties();

				/*
				$submittalAttachment->submittal_id = $submittal_id;
				$submittalAttachment->su_attachment_file_manager_file_id = $su_attachment_file_manager_file_id;
				$submittalAttachment->su_attachment_source_contact_id = $su_attachment_source_contact_id;
				$submittalAttachment->sort_order = $sort_order;
				*/

				$submittalAttachment->su_attachment_file_manager_file_id = $su_attachment_file_manager_file_id;

				$submittalAttachment->convertPropertiesToData();
				$data = $submittalAttachment->getData();
				$data['sort_order']=$sort_order;
				$sort_order++;

				// Test for existence via standard findByUniqueIndex method
				$submittalAttachment->findByUniqueIndex();
				if ($submittalAttachment->isDataLoaded()) {
					// Error code here
					$errorMessage = 'Submittal Attachment already exists.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				} else {
					$submittalAttachment->setKey(null);
					$submittalAttachment->setData($data);
				}

				// $submittal_attachment_id = $submittalAttachment->save();
				$submittalAttachment->save();

				$submittalAttachment->convertDataToProperties();
				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();

				// Output standard formatted error or success message
				if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
					// Success
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);

					$fileManagerFile = FileManagerFile::findById($database, $submittalAttachment->su_attachment_file_manager_file_id);
					/* @var $fileManagerFile FileManagerFile */
					$fileManagerFile->htmlEntityEscapeProperties();
					$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
					$fileUrl = $fileManagerFile->generateUrl();
					$containerElementId = "record_container--manage-submittal_attachment-record--submittal_attachments--sort_order--$primaryKeyAsString";
					//$index = strpos($containerElementId, 'manage');
					$index = false;
					if ($index) {
						$su_attachment_source_contact_id = $submittalAttachment->su_attachment_source_contact_id;
						$suAttachmentSourceContact = Contact::findContactByIdExtended($database, $su_attachment_source_contact_id);
						/* @var $suAttachmentSourceContact Contact */
						$suAttachmentSourceContact->htmlEntityEscapeProperties();
						$suAttachmentSourceContactFullNameHtmlEscaped = $suAttachmentSourceContact->getContactFullNameHtmlEscaped();

						$htmlRecord .= <<<END_HTML_RECORD

						<tr id="$containerElementId">
							<td width="60%">
								<a href="javascript:Submittals__deleteSubmittalAttachmentViaPromiseChain('$containerElementId', 'manage-submittal_attachment-record', '$primaryKeyAsString');">X</a>
								<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
							</td>
							<td width="40%">$suAttachmentSourceContactFullNameHtmlEscaped</td>
						</tr>
END_HTML_RECORD;

					} else {

						$htmlRecord .= <<<END_HTML_RECORD

						<li id="$containerElementId">
							<a href="javascript:Submittals__deleteSubmittalAttachmentViaPromiseChain('$containerElementId', 'manage-submittal_attachment-record', '$primaryKeyAsString');">X</a>
							<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
						</li>
END_HTML_RECORD;

					}

				} else {
					// Error code here
					$errorNumber = 1;
					$errorMessage = 'Error creating: Submittal Attachment.';
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
			//$errorMessage = 'Error creating: Submittal Attachment';
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
			if (isset($submittalAttachment) && $submittalAttachment instanceof SubmittalAttachment) {
				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
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

	case 'loadSubmittalAttachment':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_attachments_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Attachments';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;
			//$su_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$su_attachment_file_manager_file_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal Attachment';
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
			if (isset($submittalAttachment) && $submittalAttachment instanceof SubmittalAttachment) {
				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
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

	case 'loadAllSubmittalAttachmentRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_attachments_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Attachments';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;
			//$su_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$su_attachment_file_manager_file_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|submittal_attachments|Submittal Attachment|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal Attachment';
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

	case 'updateSubmittalAttachment':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal Attachment';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Submittal Attachment - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Attachments';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;
			//$su_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$su_attachment_file_manager_file_id = (int) 1;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'submittal_id' => 'submittal id',
				'su_attachment_file_manager_file_id' => 'su attachment file manager file id',
				'su_attachment_source_contact_id' => 'su attachment source contact id',
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

			if ($attributeSubgroupName == 'submittal_attachments') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$arrTmp = explode('-', $uniqueId);
				$submittal_id = (int) array_shift($arrTmp);
				$su_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalAttachment = SubmittalAttachment::findBySubmittalIdAndSuAttachmentFileManagerFileId($database, $submittal_id, $su_attachment_file_manager_file_id);
				/* @var $submittalAttachment SubmittalAttachment */

				if ($submittalAttachment) {
					// Check if the value actually changed
					$existingValue = $submittalAttachment->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$submittalAttachment->setData($data);
						// $submittal_attachment_id = $submittalAttachment->save();
						$submittalAttachment->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Attachment record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Submittal Attachment';
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
			if (isset($submittalAttachment) && $submittalAttachment instanceof SubmittalAttachment) {
				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
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

	case 'updateAllSubmittalAttachmentAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal Attachment';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Submittal Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Attachments';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;
			//$su_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$su_attachment_file_manager_file_id = (int) 1;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_id = (int) $get->submittal_id;
			$su_attachment_file_manager_file_id = (int) $get->su_attachment_file_manager_file_id;
			$su_attachment_source_contact_id = (int) $get->su_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittal_attachments') {
				$arrTmp = explode('-', $uniqueId);
				$submittal_id = (int) array_shift($arrTmp);
				$su_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalAttachment = SubmittalAttachment::findBySubmittalIdAndSuAttachmentFileManagerFileId($database, $submittal_id, $su_attachment_file_manager_file_id);
				/* @var $submittalAttachment SubmittalAttachment */

				if ($submittalAttachment) {
					$existingData = $submittalAttachment->getData();

					// Retrieve all of the $_GET inputs automatically for the SubmittalAttachment record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$submittalAttachment->setData($httpGetInputData);
					$submittalAttachment->convertDataToProperties();
					$submittalAttachment->convertPropertiesToData();

					$newData = $submittalAttachment->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$submittalAttachment->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Submittal Attachment<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$submittalAttachment->submittal_id = $submittal_id;
			$submittalAttachment->su_attachment_file_manager_file_id = $su_attachment_file_manager_file_id;
			$submittalAttachment->su_attachment_source_contact_id = $su_attachment_source_contact_id;
			$submittalAttachment->sort_order = $sort_order;
					*/

					// $submittal_attachment_id = $submittalAttachment->save();
					$submittalAttachment->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Attachment record does not exist.';
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
			//$errorMessage = 'Error updating: Submittal Attachment';
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
			if (isset($submittalAttachment) && $submittalAttachment instanceof SubmittalAttachment) {
				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
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

	case 'deleteSubmittalAttachment':

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
					'submittal_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Submittal Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Attachments';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;
			//$su_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$su_attachment_file_manager_file_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittal_attachments') {
				$arrTmp = explode('-', $uniqueId);
				$submittal_id = (int) array_shift($arrTmp);
				$su_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalAttachment = SubmittalAttachment::findBySubmittalIdAndSuAttachmentFileManagerFileId($database, $submittal_id, $su_attachment_file_manager_file_id);
				/* @var $submittalAttachment SubmittalAttachment */

				if ($submittalAttachment) {
					$submittalAttachment->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);

					$fileManagerFile = FileManagerFile::findById($database, $su_attachment_file_manager_file_id);
					if ($fileManagerFile) {
						$fileManagerFile->delete();
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Attachment record does not exist.';
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
			//$errorMessage = 'Error deleting: Submittal Attachment';
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
			if (isset($submittalAttachment) && $submittalAttachment instanceof SubmittalAttachment) {
				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
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

	case 'deleteSubmittalAttachmentDraft':

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
					'submittal_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Submittal Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Attachments';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;
			//$su_attachment_file_manager_file_id = (int) $get->uniqueId;
			// Debug
			//$su_attachment_file_manager_file_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittal_attachments') {
				$arrTmp = explode('-', $uniqueId);
				$submittal_id = (int) array_shift($arrTmp);
				$su_attachment_file_manager_file_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalAttachment = SubmittalDraftAttachment::findBySubmittalDraftIdAndSuAttachmentFileManagerFileId($database, $submittal_id, $su_attachment_file_manager_file_id);
				/* @var $submittalAttachment SubmittalAttachment */

				if ($submittalAttachment) {
					$submittalAttachment->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);

					$fileManagerFile = FileManagerFile::findById($database, $su_attachment_file_manager_file_id);
					if ($fileManagerFile) {
						$fileManagerFile->delete();
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Attachment record does not exist.';
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
			//$errorMessage = 'Error deleting: Submittal Attachment';
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
			if (isset($submittalAttachment) && $submittalAttachment instanceof SubmittalAttachment) {
				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
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

	case 'saveSubmittalAttachment':

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
					'submittal_attachments_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Submittal Attachment data values.';
				$arrErrorMessages = array(
					'Error saving Submittal Attachment.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Attachment';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Attachments';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal_attachment-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_id = (int) $get->submittal_id;
			$su_attachment_file_manager_file_id = (int) $get->su_attachment_file_manager_file_id;
			$su_attachment_source_contact_id = (int) $get->su_attachment_source_contact_id;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$submittalAttachment = new SubmittalAttachment($database);

			// Retrieve all of the $_GET inputs automatically for the SubmittalAttachment record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$submittalAttachment->setData($httpGetInputData);
			$submittalAttachment->convertDataToProperties();

			/*
			$submittalAttachment->submittal_id = $submittal_id;
			$submittalAttachment->su_attachment_file_manager_file_id = $su_attachment_file_manager_file_id;
			$submittalAttachment->su_attachment_source_contact_id = $su_attachment_source_contact_id;
			$submittalAttachment->sort_order = $sort_order;
			*/

			$submittalAttachment->convertPropertiesToData();
			$data = $submittalAttachment->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			// $submittal_attachment_id = $submittalAttachment->insertOnDuplicateKeyUpdate();
			$submittalAttachment->insertOnDuplicateKeyUpdate();
			// $submittalAttachment->insertIgnore();

			$submittalAttachment->convertDataToProperties();
			$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal Attachment.';
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
			//$errorMessage = 'Error creating: Submittal Attachment';
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
			if (isset($submittalAttachment) && $submittalAttachment instanceof SubmittalAttachment) {
				$primaryKeyAsString = $submittalAttachment->getPrimaryKeyAsString();
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

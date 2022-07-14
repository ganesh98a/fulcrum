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

require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/RequestForInformation.php');
require_once('lib/common/Service/TableService.php');
require_once('lib/common/ActionItemAssignment.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('request_for_information_recipients-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewRequestForInformationRecipients = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_recipients_view');
$userCanManageRequestForInformationRecipients = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_recipients_manage');
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
	case 'createRequestForInformationRecipient':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$csvPrimaryKeys = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Request For Information Recipient data values.';
				$arrErrorMessages = array(
					'Error creating: Request For Information Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Recipients';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_recipient-record';
			}
			$csvRfiRecipientIds = (string) $get->csvRfiRecipientIds;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_notification_id = (int) $get->request_for_information_notification_id;
			$rfi_additional_recipient_contact_id = (int) $get->rfi_additional_recipient_contact_id;
			$rfi_additional_recipient_contact_mobile_phone_number_id = (int) $get->rfi_additional_recipient_contact_mobile_phone_number_id;
			*/
			$request_for_information_notification_id = $get->request_for_information_notification_id;
			$smtp_recipient_header_type = (string) $get->smtp_recipient_header_type;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$arrRfiRecipientIds = explode(',', $csvRfiRecipientIds);

				if(!empty($arrRfiRecipientIds) && $smtp_recipient_header_type == 'To')
				{
					// Get 'To' contact id from submittal recipient
					$prev_ids = RequestForInformationRecipient::getRecipientBasedOnHeader($database,$request_for_information_notification_id,$smtp_recipient_header_type);

					// To save deleted and newly inserted 'To' contacts in log
					$save_to_recipient_log = RequestForInformationRecipient::saveToRecipientBeforeDelete($database,$request_for_information_notification_id,$prev_ids,$arrRfiRecipientIds,$currentlyActiveContactId);
					sleep(3);
				}

				if(!empty($arrRfiRecipientIds))
				{
					// delete the previous header
					$res = RequestForInformationRecipient::deleteRecipientHeaderData($database,$request_for_information_notification_id,$smtp_recipient_header_type);
				}

				if($res){

			foreach ($arrRfiRecipientIds as $rfi_additional_recipient_contact_id) {

				$requestForInformationRecipient = new RequestForInformationRecipient($database);

				// Retrieve all of the $_GET inputs automatically for the RequestForInformationRecipient record
				$httpGetInputData = $get->getData();
				foreach ($httpGetInputData as $k => $v) {
					if (empty($v)) {
						unset($httpGetInputData[$k]);
					}
				}

				$requestForInformationRecipient->setData($httpGetInputData);
				$requestForInformationRecipient->convertDataToProperties();

				/*
				$requestForInformationRecipient->request_for_information_notification_id = $request_for_information_notification_id;
				$requestForInformationRecipient->rfi_additional_recipient_contact_id = $rfi_additional_recipient_contact_id;
				$requestForInformationRecipient->rfi_additional_recipient_contact_mobile_phone_number_id = $rfi_additional_recipient_contact_mobile_phone_number_id;
				
				*/
				$requestForInformationRecipient->smtp_recipient_header_type = $smtp_recipient_header_type;

				$requestForInformationRecipient->rfi_additional_recipient_contact_id = $rfi_additional_recipient_contact_id;

				$requestForInformationRecipient->convertPropertiesToData();
				$data = $requestForInformationRecipient->getData();

				// Test for existence via standard findByUniqueIndex method
				$requestForInformationRecipient->findByUniqueIndex();
				if ($requestForInformationRecipient->isDataLoaded()) {
					// Error code here
					// $errorMessage = 'Request For Information Recipient already exists.';
					// $message->enqueueError($errorMessage, $currentPhpScript);
					$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
					continue;
					//throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				} else {
					$requestForInformationRecipient->setKey(null);
					$requestForInformationRecipient->setData($data);
				}

				// $request_for_information_recipient_id = $requestForInformationRecipient->save();
				$requestForInformationRecipient->save();

				$requestForInformationRecipient->convertDataToProperties();
				$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();

				// Output standard formatted error or success message
				if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
					// Success
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);

					if (empty($csvPrimaryKeys)) {
						$csvPrimaryKeys = $primaryKeyAsString;
					} else {
						$csvPrimaryKeys .= ',' . $primaryKeyAsString;
					}
				} else {
					// Error code here
					$errorNumber = 1;
					$errorMessage = 'Error creating: Request For Information Recipient.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

			}

			$arrCustomizedJsonOutput = array('csvPrimaryKeys' => $csvPrimaryKeys);
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Request For Information Recipient';
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
			if (isset($requestForInformationRecipient) && $requestForInformationRecipient instanceof RequestForInformationRecipient) {
				$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$csvPrimaryKeys";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadRequestForInformationRecipient':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_recipients_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Recipients';
			}

			// Primary key attibutes
			//$request_for_information_notification_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_notification_id = (int) 1;
			//$rfi_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$rfi_additional_recipient_contact_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Recipient';
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
			if (isset($requestForInformationRecipient) && $requestForInformationRecipient instanceof RequestForInformationRecipient) {
				$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
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

	case 'loadAllRequestForInformationRecipientRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_recipients_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Recipients';
			}

			// Primary key attibutes
			//$request_for_information_notification_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_notification_id = (int) 1;
			//$rfi_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$rfi_additional_recipient_contact_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|request_for_information_recipients|Request For Information Recipient|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Recipient';
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

	case 'updateRequestForInformationRecipient':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Recipient';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Request For Information Recipient - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Recipients';
			}

			// Primary key attibutes
			//$request_for_information_notification_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_notification_id = (int) 1;
			//$rfi_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$rfi_additional_recipient_contact_id = (int) 1;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'request_for_information_notification_id' => 'request for information notification id',
				'rfi_additional_recipient_contact_id' => 'rfi additional recipient contact id',
				'rfi_additional_recipient_contact_mobile_phone_number_id' => 'rfi additional recipient contact mobile phone number id',
				'smtp_recipient_header_type' => 'smtp recipient header type',
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

			if ($attributeSubgroupName == 'request_for_information_recipients') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_notification_id = (int) array_shift($arrTmp);
				$rfi_additional_recipient_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationRecipient = RequestForInformationRecipient::findByRequestForInformationNotificationIdAndRfiAdditionalRecipientContactId($database, $request_for_information_notification_id, $rfi_additional_recipient_contact_id);
				/* @var $requestForInformationRecipient RequestForInformationRecipient */

				if ($requestForInformationRecipient) {
					// Check if the value actually changed
					$existingValue = $requestForInformationRecipient->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$requestForInformationRecipient->setData($data);
						// $request_for_information_recipient_id = $requestForInformationRecipient->save();
						$requestForInformationRecipient->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Recipient record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Request For Information Recipient';
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
			if (isset($requestForInformationRecipient) && $requestForInformationRecipient instanceof RequestForInformationRecipient) {
				$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
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

	case 'updateAllRequestForInformationRecipientAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Recipient';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Request For Information Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Recipients';
			}

			// Primary key attibutes
			//$request_for_information_notification_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_notification_id = (int) 1;
			//$rfi_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$rfi_additional_recipient_contact_id = (int) 1;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_notification_id = (int) $get->request_for_information_notification_id;
			$rfi_additional_recipient_contact_id = (int) $get->rfi_additional_recipient_contact_id;
			$rfi_additional_recipient_contact_mobile_phone_number_id = (int) $get->rfi_additional_recipient_contact_mobile_phone_number_id;
			$smtp_recipient_header_type = (string) $get->smtp_recipient_header_type;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_recipients') {
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_notification_id = (int) array_shift($arrTmp);
				$rfi_additional_recipient_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationRecipient = RequestForInformationRecipient::findByRequestForInformationNotificationIdAndRfiAdditionalRecipientContactId($database, $request_for_information_notification_id, $rfi_additional_recipient_contact_id);
				/* @var $requestForInformationRecipient RequestForInformationRecipient */

				if ($requestForInformationRecipient) {
					$existingData = $requestForInformationRecipient->getData();

					// Retrieve all of the $_GET inputs automatically for the RequestForInformationRecipient record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$requestForInformationRecipient->setData($httpGetInputData);
					$requestForInformationRecipient->convertDataToProperties();
					$requestForInformationRecipient->convertPropertiesToData();

					$newData = $requestForInformationRecipient->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$requestForInformationRecipient->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Request For Information Recipient<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$requestForInformationRecipient->request_for_information_notification_id = $request_for_information_notification_id;
			$requestForInformationRecipient->rfi_additional_recipient_contact_id = $rfi_additional_recipient_contact_id;
			$requestForInformationRecipient->rfi_additional_recipient_contact_mobile_phone_number_id = $rfi_additional_recipient_contact_mobile_phone_number_id;
			$requestForInformationRecipient->smtp_recipient_header_type = $smtp_recipient_header_type;
					*/

					// $request_for_information_recipient_id = $requestForInformationRecipient->save();
					$requestForInformationRecipient->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Recipient record does not exist.';
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
			//$errorMessage = 'Error updating: Request For Information Recipient';
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
			if (isset($requestForInformationRecipient) && $requestForInformationRecipient instanceof RequestForInformationRecipient) {
				$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
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

	case 'deleteRequestForInformationRecipient':

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
					'request_for_information_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Request For Information Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Recipients';
			}

			// Primary key attibutes
			//$request_for_information_notification_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_notification_id = (int) 1;
			//$rfi_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$rfi_additional_recipient_contact_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_recipients') {
				$arrTmp = explode('-', $uniqueId);
				$request_for_information_notification_id = (int) array_shift($arrTmp);
				$rfi_additional_recipient_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationRecipient = RequestForInformationRecipient::findByRequestForInformationNotificationIdAndRfiAdditionalRecipientContactId($database, $request_for_information_notification_id, $rfi_additional_recipient_contact_id);
				/* @var $requestForInformationRecipient RequestForInformationRecipient */

				if ($requestForInformationRecipient) {
					$requestForInformationRecipient->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Recipient record does not exist.';
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
			//$errorMessage = 'Error deleting: Request For Information Recipient';
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
			if (isset($requestForInformationRecipient) && $requestForInformationRecipient instanceof RequestForInformationRecipient) {
				$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
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
	case 'delete_reciptents':
		$db = DBI::getInstance($database);
		$db->free_result();
		$reciptentid = Data::parseInt($get->reciptent_id);
		$mail_type = $get->mail_type;
		
		
        $query_res = "DELETE FROM `request_for_information_recipients` WHERE `rfi_additional_recipient_contact_id` = $reciptentid AND `smtp_recipient_header_type`= '".$mail_type."'";
           
       if( $db->execute($query_res))
       {
     		echo $jsonOutput = json_encode(array('status'=>'success'));
     	}else
     	{
     		echo $jsonOutput = json_encode(array('status'=>'error'));
     	}

     	$db->free_result();

	break;
	case 'saveRequestForInformationRecipient':

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
					'request_for_information_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Request For Information Recipient data values.';
				$arrErrorMessages = array(
					'Error saving Request For Information Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Recipients';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_recipient-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_notification_id = (int) $get->request_for_information_notification_id;
			$rfi_additional_recipient_contact_id = (int) $get->rfi_additional_recipient_contact_id;
			$rfi_additional_recipient_contact_mobile_phone_number_id = (int) $get->rfi_additional_recipient_contact_mobile_phone_number_id;
			$smtp_recipient_header_type = (string) $get->smtp_recipient_header_type;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$requestForInformationRecipient = new RequestForInformationRecipient($database);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformationRecipient record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$requestForInformationRecipient->setData($httpGetInputData);
			$requestForInformationRecipient->convertDataToProperties();

			/*
			$requestForInformationRecipient->request_for_information_notification_id = $request_for_information_notification_id;
			$requestForInformationRecipient->rfi_additional_recipient_contact_id = $rfi_additional_recipient_contact_id;
			$requestForInformationRecipient->rfi_additional_recipient_contact_mobile_phone_number_id = $rfi_additional_recipient_contact_mobile_phone_number_id;
			$requestForInformationRecipient->smtp_recipient_header_type = $smtp_recipient_header_type;
			*/

			$requestForInformationRecipient->convertPropertiesToData();
			$data = $requestForInformationRecipient->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			// $request_for_information_recipient_id = $requestForInformationRecipient->insertOnDuplicateKeyUpdate();
			$requestForInformationRecipient->insertOnDuplicateKeyUpdate();
			// $requestForInformationRecipient->insertIgnore();

			$requestForInformationRecipient->convertDataToProperties();
			$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information Recipient.';
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
			//$errorMessage = 'Error creating: Request For Information Recipient';
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
			if (isset($requestForInformationRecipient) && $requestForInformationRecipient instanceof RequestForInformationRecipient) {
				$primaryKeyAsString = $requestForInformationRecipient->getPrimaryKeyAsString();
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
	case 'saveAdditionalRecipient': // To Change the To Recipient and create an history.
		try {

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */
			$db->free_result();
			$to_reciptentid = Data::parseInt($get->to_id);
			$notification_id = Data::parseInt($get->notification_id);
			$rfi_id = Data::parseInt($get->rfi_id);

			if(empty($notification_id) &&!empty($rfi_id))
			{
				// create notification Id
				$notification_id = RequestForInformationRecipient::InsertNotification($database,$rfi_id);
			}

			if(!empty($to_reciptentid) && !empty($notification_id)){
				//$get_notification = "" ;
				//check whether To field is capture in the rfi recipient if not capture the data and return old contact id
				$captureToField = RequestForInformationRecipient::checkandUpdateRfiToField($database,$rfi_id,$notification_id,$currentlyActiveContactId);	

				if(!empty($captureToField) && $captureToField != $to_reciptentid){
					// Replace the old contact to new contact in meeting
					$updateToFiledInMeeting = ActionItemAssignment::updateAassignments($database,'5',$rfi_id,$captureToField,$to_reciptentid);
				}	

				// Change in the To Recipient
				$return_stat = TableService::UpdateTabularData($database,'requests_for_information','rfi_recipient_contact_id', $rfi_id, $to_reciptentid,$currentlyActiveContactId);
				/* Check Recipient Exist - Start */

				$query = "SELECT * FROM request_for_information_recipients WHERE smtp_recipient_header_type='To' AND rfi_additional_recipient_contact_id = ? AND request_for_information_notification_id = ?";

				$arrValues = array($to_reciptentid,$notification_id);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$exist_other_reciepent = $db->fetch();
				$db->free_result();

				// To get is_to_history last number
				$query = "SELECT * FROM request_for_information_recipients WHERE smtp_recipient_header_type='To' AND request_for_information_notification_id = ? ORDER BY `is_to_history` DESC LIMIT 1";
				$arrValues = array($notification_id);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$last_is_to_history = $db->fetch();
				$db->free_result();

				$is_to_history = $last_is_to_history['is_to_history']+1;

				// To delay the entry of "To" in recipient table for created time
				sleep(3);

				if($last_is_to_history['rfi_additional_recipient_contact_id'] != $to_reciptentid){
					if(!empty($return_stat)){ // Success in updating
						$query = "INSERT INTO `request_for_information_recipients`(`request_for_information_notification_id`, `rfi_additional_recipient_contact_id`,  `smtp_recipient_header_type`,`rfi_additional_recipient_creator_contact_id`,`is_to_history`) VALUES (?,?,?,?,?)";
						$arrValues = array($notification_id, $to_reciptentid,'To',$currentlyActiveContactId,$is_to_history);

						$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
						$db->free_result();
					}
				}
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}
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

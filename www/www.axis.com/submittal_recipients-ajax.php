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

require_once('lib/common/SubmittalRecipient.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('submittal_recipients-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewSubmittalRecipients = $permissions->determineAccessToSoftwareModuleFunction('submittal_recipients_view');
$userCanManageSubmittalRecipients = $permissions->determineAccessToSoftwareModuleFunction('submittal_recipients_manage');
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
	case 'createSubmittalRecipient':

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
					'submittal_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Submittal Recipient data values.';
				$arrErrorMessages = array(
					'Error creating: Submittal Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Recipients';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal_recipient-record';
			}
			$csvSuRecipientIds = (string) $get->csvSuRecipientIds;
			$submittal_notification_id = $get->submittal_notification_id;
			$smtp_recipient_header_type = $get->smtp_recipient_header_type;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_notification_id = (int) $get->submittal_notification_id;
			$su_additional_recipient_contact_id = (int) $get->su_additional_recipient_contact_id;
			$su_additional_recipient_contact_mobile_phone_number_id = (int) $get->su_additional_recipient_contact_mobile_phone_number_id;
			$smtp_recipient_header_type = (string) $get->smtp_recipient_header_type;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$arrSuRecipientIds = explode(',', $csvSuRecipientIds);

				if(!empty($arrSuRecipientIds) && $smtp_recipient_header_type == 'To')
				{
					// Get 'To' contact id from submittal recipient
					$prev_ids = SubmittalRecipient::getRecipientBasedOnHeader($database,$submittal_notification_id,$smtp_recipient_header_type);

					// To save deleted and newly inserted 'To' contacts in log
					$save_to_recipient_log = SubmittalRecipient::saveToRecipientBeforeDelete($database,$submittal_notification_id,$prev_ids,$arrSuRecipientIds,$currentlyActiveContactId);
					sleep(3);
				}
			
				if(!empty($arrSuRecipientIds))
				{
					// delete the previous header
					$res = SubmittalRecipient::deleteRecipientHeaderData($database,$submittal_notification_id,$smtp_recipient_header_type);
				}
				if($res)
				{
			foreach ($arrSuRecipientIds as $su_additional_recipient_contact_id) {

				$submittalRecipient = new SubmittalRecipient($database);

				// Retrieve all of the $_GET inputs automatically for the SubmittalRecipient record
				$httpGetInputData = $get->getData();
				foreach ($httpGetInputData as $k => $v) {
					if (empty($v)) {
						unset($httpGetInputData[$k]);
					}
				}

				$submittalRecipient->setData($httpGetInputData);
				$submittalRecipient->convertDataToProperties();

				/*
				$submittalRecipient->submittal_notification_id = $submittal_notification_id;
				$submittalRecipient->su_additional_recipient_contact_id = $su_additional_recipient_contact_id;
				$submittalRecipient->su_additional_recipient_contact_mobile_phone_number_id = $su_additional_recipient_contact_mobile_phone_number_id;
				$submittalRecipient->smtp_recipient_header_type = $smtp_recipient_header_type;
				*/

				$submittalRecipient->su_additional_recipient_contact_id = $su_additional_recipient_contact_id;

				$submittalRecipient->convertPropertiesToData();
				$data = $submittalRecipient->getData();

				//To add creator id in recipient table
				$data['su_additional_recipient_creator_contact_id']=$currentlyActiveContactId;

				// Test for existence via standard findByUniqueIndex method
				$submittalRecipient->findByUniqueIndex();
				if ($submittalRecipient->isDataLoaded()) {
					// Error code here
					/* $errorMessage = 'Submittal Recipient already exists.';
					$message->enqueueError($errorMessage, $currentPhpScript); */
					$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
					/*throw new Exception($errorMessage); */
					continue;
					//$error->outputErrorMessages();
					//exit;
				} else {
					$submittalRecipient->setKey(null);
					$submittalRecipient->setData($data);
				}

				// $submittal_recipient_id = $submittalRecipient->save();
				$submittalRecipient->save();

				$submittalRecipient->convertDataToProperties();
				$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();

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
					$errorMessage = 'Error creating: Submittal Recipient.';
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
			//$errorMessage = 'Error creating: Submittal Recipient';
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
			if (isset($submittalRecipient) && $submittalRecipient instanceof SubmittalRecipient) {
				$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
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

	case 'loadSubmittalRecipient':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_recipients_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Recipients';
			}

			// Primary key attibutes
			//$submittal_notification_id = (int) $get->uniqueId;
			// Debug
			//$submittal_notification_id = (int) 1;
			//$su_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$su_additional_recipient_contact_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal Recipient';
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
			if (isset($submittalRecipient) && $submittalRecipient instanceof SubmittalRecipient) {
				$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
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

	case 'loadAllSubmittalRecipientRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_recipients_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Recipients';
			}

			// Primary key attibutes
			//$submittal_notification_id = (int) $get->uniqueId;
			// Debug
			//$submittal_notification_id = (int) 1;
			//$su_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$su_additional_recipient_contact_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|submittal_recipients|Submittal Recipient|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal Recipient';
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

	case 'updateSubmittalRecipient':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal Recipient';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Submittal Recipient - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Recipients';
			}

			// Primary key attibutes
			//$submittal_notification_id = (int) $get->uniqueId;
			// Debug
			//$submittal_notification_id = (int) 1;
			//$su_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$su_additional_recipient_contact_id = (int) 1;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'submittal_notification_id' => 'submittal notification id',
				'su_additional_recipient_contact_id' => 'su additional recipient contact id',
				'su_additional_recipient_contact_mobile_phone_number_id' => 'su additional recipient contact mobile phone number id',
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

			if ($attributeSubgroupName == 'submittal_recipients') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$arrTmp = explode('-', $uniqueId);
				$submittal_notification_id = (int) array_shift($arrTmp);
				$su_additional_recipient_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalRecipient = SubmittalRecipient::findBySubmittalNotificationIdAndSuAdditionalRecipientContactId($database, $submittal_notification_id, $su_additional_recipient_contact_id);
				/* @var $submittalRecipient SubmittalRecipient */

				if ($submittalRecipient) {
					// Check if the value actually changed
					$existingValue = $submittalRecipient->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$submittalRecipient->setData($data);
						// $submittal_recipient_id = $submittalRecipient->save();
						$submittalRecipient->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Recipient record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Submittal Recipient';
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
			if (isset($submittalRecipient) && $submittalRecipient instanceof SubmittalRecipient) {
				$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
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

	case 'updateAllSubmittalRecipientAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal Recipient';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Submittal Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Recipients';
			}

			// Primary key attibutes
			//$submittal_notification_id = (int) $get->uniqueId;
			// Debug
			//$submittal_notification_id = (int) 1;
			//$su_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$su_additional_recipient_contact_id = (int) 1;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_notification_id = (int) $get->submittal_notification_id;
			$su_additional_recipient_contact_id = (int) $get->su_additional_recipient_contact_id;
			$su_additional_recipient_contact_mobile_phone_number_id = (int) $get->su_additional_recipient_contact_mobile_phone_number_id;
			$smtp_recipient_header_type = (string) $get->smtp_recipient_header_type;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittal_recipients') {
				$arrTmp = explode('-', $uniqueId);
				$submittal_notification_id = (int) array_shift($arrTmp);
				$su_additional_recipient_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalRecipient = SubmittalRecipient::findBySubmittalNotificationIdAndSuAdditionalRecipientContactId($database, $submittal_notification_id, $su_additional_recipient_contact_id);
				/* @var $submittalRecipient SubmittalRecipient */

				if ($submittalRecipient) {
					$existingData = $submittalRecipient->getData();

					// Retrieve all of the $_GET inputs automatically for the SubmittalRecipient record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$submittalRecipient->setData($httpGetInputData);
					$submittalRecipient->convertDataToProperties();
					$submittalRecipient->convertPropertiesToData();

					$newData = $submittalRecipient->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$submittalRecipient->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Submittal Recipient<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$submittalRecipient->submittal_notification_id = $submittal_notification_id;
			$submittalRecipient->su_additional_recipient_contact_id = $su_additional_recipient_contact_id;
			$submittalRecipient->su_additional_recipient_contact_mobile_phone_number_id = $su_additional_recipient_contact_mobile_phone_number_id;
			$submittalRecipient->smtp_recipient_header_type = $smtp_recipient_header_type;
					*/

					// $submittal_recipient_id = $submittalRecipient->save();
					$submittalRecipient->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Recipient record does not exist.';
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
			//$errorMessage = 'Error updating: Submittal Recipient';
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
			if (isset($submittalRecipient) && $submittalRecipient instanceof SubmittalRecipient) {
				$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
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

	case 'deleteSubmittalRecipient':

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
					'submittal_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Submittal Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Recipients';
			}

			// Primary key attibutes
			//$submittal_notification_id = (int) $get->uniqueId;
			// Debug
			//$submittal_notification_id = (int) 1;
			//$su_additional_recipient_contact_id = (int) $get->uniqueId;
			// Debug
			//$su_additional_recipient_contact_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittal_recipients') {
				$arrTmp = explode('-', $uniqueId);
				$submittal_notification_id = (int) array_shift($arrTmp);
				$su_additional_recipient_contact_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalRecipient = SubmittalRecipient::findBySubmittalNotificationIdAndSuAdditionalRecipientContactId($database, $submittal_notification_id, $su_additional_recipient_contact_id);
				/* @var $submittalRecipient SubmittalRecipient */

				if ($submittalRecipient) {
					$submittalRecipient->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Recipient record does not exist.';
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
			//$errorMessage = 'Error deleting: Submittal Recipient';
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
			if (isset($submittalRecipient) && $submittalRecipient instanceof SubmittalRecipient) {
				$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
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

	case 'saveSubmittalRecipient':

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
					'submittal_recipients_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Submittal Recipient data values.';
				$arrErrorMessages = array(
					'Error saving Submittal Recipient.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Recipient';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Recipients';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal_recipient-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_notification_id = (int) $get->submittal_notification_id;
			$su_additional_recipient_contact_id = (int) $get->su_additional_recipient_contact_id;
			$su_additional_recipient_contact_mobile_phone_number_id = (int) $get->su_additional_recipient_contact_mobile_phone_number_id;
			$smtp_recipient_header_type = (string) $get->smtp_recipient_header_type;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$submittalRecipient = new SubmittalRecipient($database);

			// Retrieve all of the $_GET inputs automatically for the SubmittalRecipient record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$submittalRecipient->setData($httpGetInputData);
			$submittalRecipient->convertDataToProperties();

			/*
			$submittalRecipient->submittal_notification_id = $submittal_notification_id;
			$submittalRecipient->su_additional_recipient_contact_id = $su_additional_recipient_contact_id;
			$submittalRecipient->su_additional_recipient_contact_mobile_phone_number_id = $su_additional_recipient_contact_mobile_phone_number_id;
			$submittalRecipient->smtp_recipient_header_type = $smtp_recipient_header_type;
			*/

			$submittalRecipient->convertPropertiesToData();
			$data = $submittalRecipient->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			// $submittal_recipient_id = $submittalRecipient->insertOnDuplicateKeyUpdate();
			$submittalRecipient->insertOnDuplicateKeyUpdate();
			// $submittalRecipient->insertIgnore();

			$submittalRecipient->convertDataToProperties();
			$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal Recipient.';
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
			//$errorMessage = 'Error creating: Submittal Recipient';
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
			if (isset($submittalRecipient) && $submittalRecipient instanceof SubmittalRecipient) {
				$primaryKeyAsString = $submittalRecipient->getPrimaryKeyAsString();
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

<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 16777215;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['post_maxlength'] = 16777215;
$init['post_required'] = true;
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
} else if (isset($post)) {
	$methodCall = $post->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

require_once('lib/common/PageComponents.php');
require_once('lib/common/SubmittalResponse.php');
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/Service/TableService.php');
require_once('lib/common/Message.php');
require_once('lib/common/Tagging.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('submittal_responses-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewSubmittalResponses = $permissions->determineAccessToSoftwareModuleFunction('submittal_responses_view');
$userCanManageSubmittalResponses = $permissions->determineAccessToSoftwareModuleFunction('submittal_responses_manage');
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
	case 'createSubmittalResponse':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');
			unset($_COOKIE['tempNotes']);
			unset($_COOKIE['tempEmailBody']);
            setcookie('tempNotes', null, -1, '/');
            setcookie('tempEmailBody', null, -1, '/');
			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Submittal Response data values.';
				$arrErrorMessages = array(
					'Error creating: Submittal Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Responses';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal_response-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_response_id = (int) $get->submittal_response_id;
			$submittal_id = (int) $get->submittal_id;
			$submittal_response_sequence_number = (int) $get->submittal_response_sequence_number;
			$submittal_response_type_id = (int) $get->submittal_response_type_id;
			$su_responder_contact_id = (int) $get->su_responder_contact_id;
			$su_responder_contact_company_office_id = (int) $get->su_responder_contact_company_office_id;
			$su_responder_phone_contact_company_office_phone_number_id = (int) $get->su_responder_phone_contact_company_office_phone_number_id;
			$su_responder_fax_contact_company_office_phone_number_id = (int) $get->su_responder_fax_contact_company_office_phone_number_id;
			$su_responder_contact_mobile_phone_number_id = (int) $get->su_responder_contact_mobile_phone_number_id;
			$submittal_response_title = (string) $get->submittal_response_title;
			$submittal_response = (string) $get->submittal_response;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			*/
			$submittal_id = (int) $post->submittal_id;
			$sub_Tags = (string) $post->sub_Tags;
			$arr_sub_tags = explode(',', $sub_Tags);
			$arrtag ='';
			foreach ($arr_sub_tags as $key => $rval) {
				$tagid = Tagging::searchAndInsertTag($database,$rval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');
			TableService::UpdateTabularData($database,'submittals','tag_ids',$submittal_id,$arrtag);

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the SubmittalResponse record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
				if($v =="sub_Tags")
				{	unset($httpGetInputData[$k]); }
			}

			$submittalResponse = new SubmittalResponse($database);

			$submittalResponse->setData($httpGetInputData);
			$submittalResponse->convertDataToProperties();

			/*
			$submittalResponse->submittal_response_id = $submittal_response_id;
			$submittalResponse->submittal_id = $submittal_id;
			$submittalResponse->submittal_response_sequence_number = $submittal_response_sequence_number;
			$submittalResponse->submittal_response_type_id = $submittal_response_type_id;
			$submittalResponse->su_responder_contact_id = $su_responder_contact_id;
			$submittalResponse->su_responder_contact_company_office_id = $su_responder_contact_company_office_id;
			$submittalResponse->su_responder_phone_contact_company_office_phone_number_id = $su_responder_phone_contact_company_office_phone_number_id;
			$submittalResponse->su_responder_fax_contact_company_office_phone_number_id = $su_responder_fax_contact_company_office_phone_number_id;
			$submittalResponse->su_responder_contact_mobile_phone_number_id = $su_responder_contact_mobile_phone_number_id;
			$submittalResponse->submittal_response_title = $submittal_response_title;
			$submittalResponse->submittal_response = $submittal_response;
			$submittalResponse->modified = $modified;
			$submittalResponse->created = $created;
			*/

			// Begin hacks.
			
			$submittalResponse->submittal_id = $submittal_id;
			$submittalResponse->su_responder_contact_id = $currentlyActiveContactId;
			$submittalResponse->created = date('Y-m-d H:i:s');

			// to update contracting Entity
			$entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
			TableService::UpdateTabularData($database,'submittals','contracting_entity_id',$submittal_id,$entity_id);


			// submittal_response_sequence_number
			$next_submittal_response_sequence_number = SubmittalResponse::findNextSubmittalResponseSequenceNumber($database, $submittal_id);
			$submittalResponse->submittal_response_sequence_number = $next_submittal_response_sequence_number;

			/*
			$loadSubmittalResponsesBySubmittalIdOptions = new Input();
			$loadSubmittalResponsesBySubmittalIdOptions->forceLoadFlag = true;
			$arrSuResponsesBySuId = SubmittalResponse::loadSubmittalResponsesBySubmittalId($database, $submittal_id, $loadSubmittalResponsesBySubmittalIdOptions);
			$submittalResponse->submittal_response_sequence_number = 1 + count($arrSuResponsesBySuId);
			*/

			$arrCustomizedJsonOutput = array('submittal_id' => $submittal_id);
			// End hacks.

			$submittalResponse->convertPropertiesToData();
			$data = $submittalResponse->getData();

			// Test for existence via standard findByUniqueIndex method
			$submittalResponse->findByUniqueIndex();
			if ($submittalResponse->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Submittal Response already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$submittalResponse->setKey(null);
				$data['created'] = null;
				$submittalResponse->setData($data);
			}

			$submittal_response_id = $submittalResponse->save();
			if (isset($submittal_response_id) && !empty($submittal_response_id)) {
				$submittalResponse->submittal_response_id = $submittal_response_id;
				$submittalResponse->setId($submittal_response_id);
			}
			// $submittalResponse->save();

			$submittalResponse->convertDataToProperties();
			$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal Response.';
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
			//$errorMessage = 'Error creating: Submittal Response';
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
			if (isset($submittalResponse) && $submittalResponse instanceof SubmittalResponse) {
				$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
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

	case 'loadSubmittalResponse':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_responses_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Responses';
			}

			// Primary key attibutes
			//$submittal_response_id = (int) $get->uniqueId;
			// Debug
			//$submittal_response_id = (int) 1;

			// Unique index attibutes
			$submittal_id = (int) $post->submittal_id;
			$submittal_response_sequence_number = (int) $post->submittal_response_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal Response';
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
			if (isset($submittalResponse) && $submittalResponse instanceof SubmittalResponse) {
				$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
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

	case 'loadAllSubmittalResponseRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_responses_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Responses';
			}

			// Primary key attibutes
			//$submittal_response_id = (int) $get->uniqueId;
			// Debug
			//$submittal_response_id = (int) 1;

			// Unique index attibutes
			$submittal_id = (int) $post->submittal_id;
			$submittal_response_sequence_number = (int) $post->submittal_response_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|submittal_responses|Submittal Response|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal Response';
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

	case 'updateSubmittalResponse':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal Response';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Submittal Response - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Responses';
			}

			// Primary key attibutes
			//$submittal_response_id = (int) $get->uniqueId;
			// Debug
			//$submittal_response_id = (int) 1;

			// Unique index attibutes
			$submittal_id = (int) $post->submittal_id;
			$submittal_response_sequence_number = (int) $post->submittal_response_sequence_number;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'submittal_response_id' => 'submittal response id',
				'submittal_id' => 'submittal id',
				'submittal_response_sequence_number' => 'submittal response sequence number',
				'submittal_response_type_id' => 'submittal response type id',
				'su_responder_contact_id' => 'su responder contact id',
				'su_responder_contact_company_office_id' => 'su responder contact company office id',
				'su_responder_phone_contact_company_office_phone_number_id' => 'su responder phone contact company office phone number id',
				'su_responder_fax_contact_company_office_phone_number_id' => 'su responder fax contact company office phone number id',
				'su_responder_contact_mobile_phone_number_id' => 'su responder contact mobile phone number id',
				'submittal_response_title' => 'submittal response title',
				'submittal_response' => 'submittal response',
				'modified' => 'modified',
				'created' => 'created',
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

			if ($attributeSubgroupName == 'submittal_responses') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$submittal_response_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalResponse = SubmittalResponse::findById($database, $submittal_response_id);
				/* @var $submittalResponse SubmittalResponse */

				if ($submittalResponse) {
					// Check if the value actually changed
					$existingValue = $submittalResponse->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'submittal_id' => 1,
						'submittal_response_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $submittalResponse->$attributeName;
						$submittalResponse->$attributeName = $newValue;
						$possibleDuplicateSubmittalResponse = SubmittalResponse::findBySubmittalIdAndSubmittalResponseSequenceNumber($database, $submittalResponse->submittal_id, $submittalResponse->submittal_response_sequence_number);
						if ($possibleDuplicateSubmittalResponse) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Submittal Response $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$submittalResponse->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$submittalResponse->setData($data);
						// $submittal_response_id = $submittalResponse->save();
						$submittalResponse->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Response record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Submittal Response';
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
			if (isset($submittalResponse) && $submittalResponse instanceof SubmittalResponse) {
				$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
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

	case 'updateAllSubmittalResponseAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal Response';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Submittal Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Responses';
			}

			// Primary key attibutes
			//$submittal_response_id = (int) $get->uniqueId;
			// Debug
			//$submittal_response_id = (int) 1;

			// Unique index attibutes
			$submittal_id = (int) $post->submittal_id;
			$submittal_response_sequence_number = (int) $post->submittal_response_sequence_number;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_response_id = (int) $get->submittal_response_id;
			$submittal_id = (int) $get->submittal_id;
			$submittal_response_sequence_number = (int) $get->submittal_response_sequence_number;
			$submittal_response_type_id = (int) $get->submittal_response_type_id;
			$su_responder_contact_id = (int) $get->su_responder_contact_id;
			$su_responder_contact_company_office_id = (int) $get->su_responder_contact_company_office_id;
			$su_responder_phone_contact_company_office_phone_number_id = (int) $get->su_responder_phone_contact_company_office_phone_number_id;
			$su_responder_fax_contact_company_office_phone_number_id = (int) $get->su_responder_fax_contact_company_office_phone_number_id;
			$su_responder_contact_mobile_phone_number_id = (int) $get->su_responder_contact_mobile_phone_number_id;
			$submittal_response_title = (string) $get->submittal_response_title;
			$submittal_response = (string) $get->submittal_response;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittal_responses') {
				$submittal_response_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalResponse = SubmittalResponse::findById($database, $submittal_response_id);
				/* @var $submittalResponse SubmittalResponse */

				if ($submittalResponse) {
					$existingData = $submittalResponse->getData();

					// Retrieve all of the $_GET inputs automatically for the SubmittalResponse record
					$httpGetInputData = $post->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$submittalResponse->setData($httpGetInputData);
					$submittalResponse->convertDataToProperties();
					$submittalResponse->convertPropertiesToData();

					$newData = $submittalResponse->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$submittalResponse->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Submittal Response<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$submittalResponse->submittal_response_id = $submittal_response_id;
			$submittalResponse->submittal_id = $submittal_id;
			$submittalResponse->submittal_response_sequence_number = $submittal_response_sequence_number;
			$submittalResponse->submittal_response_type_id = $submittal_response_type_id;
			$submittalResponse->su_responder_contact_id = $su_responder_contact_id;
			$submittalResponse->su_responder_contact_company_office_id = $su_responder_contact_company_office_id;
			$submittalResponse->su_responder_phone_contact_company_office_phone_number_id = $su_responder_phone_contact_company_office_phone_number_id;
			$submittalResponse->su_responder_fax_contact_company_office_phone_number_id = $su_responder_fax_contact_company_office_phone_number_id;
			$submittalResponse->su_responder_contact_mobile_phone_number_id = $su_responder_contact_mobile_phone_number_id;
			$submittalResponse->submittal_response_title = $submittal_response_title;
			$submittalResponse->submittal_response = $submittal_response;
			$submittalResponse->modified = $modified;
			$submittalResponse->created = $created;
					*/

					// $submittal_response_id = $submittalResponse->save();
					$submittalResponse->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Response record does not exist.';
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
			//$errorMessage = 'Error updating: Submittal Response';
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
			if (isset($submittalResponse) && $submittalResponse instanceof SubmittalResponse) {
				$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
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

	case 'deleteSubmittalResponse':

		$crudOperation = 'delete';
		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Submittal Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Responses';
			}

			// Primary key attibutes
			//$submittal_response_id = (int) $get->uniqueId;
			// Debug
			//$submittal_response_id = (int) 1;

			// Unique index attibutes
			$submittal_id = (int) $post->submittal_id;
			$submittal_response_sequence_number = (int) $post->submittal_response_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittal_responses') {
				$submittal_response_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalResponse = SubmittalResponse::findById($database, $submittal_response_id);
				/* @var $submittalResponse SubmittalResponse */

				if ($submittalResponse) {
					$submittalResponse->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Response record does not exist.';
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
			//$errorMessage = 'Error deleting: Submittal Response';
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
			if (isset($submittalResponse) && $submittalResponse instanceof SubmittalResponse) {
				$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
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

	case 'saveSubmittalResponse':

		$crudOperation = 'save';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Submittal Response data values.';
				$arrErrorMessages = array(
					'Error saving Submittal Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Responses';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal_response-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_response_id = (int) $get->submittal_response_id;
			$submittal_id = (int) $get->submittal_id;
			$submittal_response_sequence_number = (int) $get->submittal_response_sequence_number;
			$submittal_response_type_id = (int) $get->submittal_response_type_id;
			$su_responder_contact_id = (int) $get->su_responder_contact_id;
			$su_responder_contact_company_office_id = (int) $get->su_responder_contact_company_office_id;
			$su_responder_phone_contact_company_office_phone_number_id = (int) $get->su_responder_phone_contact_company_office_phone_number_id;
			$su_responder_fax_contact_company_office_phone_number_id = (int) $get->su_responder_fax_contact_company_office_phone_number_id;
			$su_responder_contact_mobile_phone_number_id = (int) $get->su_responder_contact_mobile_phone_number_id;
			$submittal_response_title = (string) $get->submittal_response_title;
			$submittal_response = (string) $get->submittal_response;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$submittalResponse = new SubmittalResponse($database);

			// Retrieve all of the $_GET inputs automatically for the SubmittalResponse record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$submittalResponse->setData($httpGetInputData);
			$submittalResponse->convertDataToProperties();

			/*
			$submittalResponse->submittal_response_id = $submittal_response_id;
			$submittalResponse->submittal_id = $submittal_id;
			$submittalResponse->submittal_response_sequence_number = $submittal_response_sequence_number;
			$submittalResponse->submittal_response_type_id = $submittal_response_type_id;
			$submittalResponse->su_responder_contact_id = $su_responder_contact_id;
			$submittalResponse->su_responder_contact_company_office_id = $su_responder_contact_company_office_id;
			$submittalResponse->su_responder_phone_contact_company_office_phone_number_id = $su_responder_phone_contact_company_office_phone_number_id;
			$submittalResponse->su_responder_fax_contact_company_office_phone_number_id = $su_responder_fax_contact_company_office_phone_number_id;
			$submittalResponse->su_responder_contact_mobile_phone_number_id = $su_responder_contact_mobile_phone_number_id;
			$submittalResponse->submittal_response_title = $submittal_response_title;
			$submittalResponse->submittal_response = $submittal_response;
			$submittalResponse->modified = $modified;
			$submittalResponse->created = $created;
			*/

			$submittalResponse->convertPropertiesToData();
			$data = $submittalResponse->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$submittal_response_id = $submittalResponse->insertOnDuplicateKeyUpdate();
			if (isset($submittal_response_id) && !empty($submittal_response_id)) {
				$submittalResponse->submittal_response_id = $submittal_response_id;
				$submittalResponse->setId($submittal_response_id);
			}
			// $submittalResponse->insertOnDuplicateKeyUpdate();
			// $submittalResponse->insertIgnore();

			$submittalResponse->convertDataToProperties();
			$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal Response.';
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
			//$errorMessage = 'Error creating: Submittal Response';
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
			if (isset($submittalResponse) && $submittalResponse instanceof SubmittalResponse) {
				$primaryKeyAsString = $submittalResponse->getPrimaryKeyAsString();
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

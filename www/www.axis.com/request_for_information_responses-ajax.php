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
}else if (isset($post)) {
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
require_once('lib/common/RequestForInformationResponse.php');
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/Service/TableService.php');
require_once('lib/common/Tagging.php');
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('request_for_information_responses-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewRequestForInformationResponses = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_responses_view');
$userCanManageRequestForInformationResponses = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_responses_manage');
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
	case 'createRequestForInformationResponse':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';

		try {
			unset($_COOKIE['tempAnswer']);
			setcookie('tempAnswer', null, -1, '/');
			unset($_COOKIE['tempRfiEmail']);
            setcookie('tempRfiEmail', null, -1, '/');
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Request For Information Response data values.';
				$arrErrorMessages = array(
					'Error creating: Request For Information Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Responses';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_response-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_response_id = (int) $get->request_for_information_response_id;
			$request_for_information_id = (int) $get->request_for_information_id;
			$request_for_information_response_sequence_number = (int) $get->request_for_information_response_sequence_number;
			$request_for_information_response_type_id = (int) $get->request_for_information_response_type_id;
			$rfi_responder_contact_id = (int) $get->rfi_responder_contact_id;
			$rfi_responder_contact_company_office_id = (int) $get->rfi_responder_contact_company_office_id;
			$rfi_responder_phone_contact_company_office_phone_number_id = (int) $get->rfi_responder_phone_contact_company_office_phone_number_id;
			$rfi_responder_fax_contact_company_office_phone_number_id = (int) $get->rfi_responder_fax_contact_company_office_phone_number_id;
			$rfi_responder_contact_mobile_phone_number_id = (int) $get->rfi_responder_contact_mobile_phone_number_id;
			$request_for_information_response_title = (string) $get->request_for_information_response_title;
			$request_for_information_response = (string) $get->request_for_information_response;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			*/
			$request_for_information_id = (int) $post->request_for_information_id;
			$rfi_Tags = (string) $post->rfi_Tags;
			$arr_rfi_tags = explode(',', $rfi_Tags);
			$arrtag ='';
			foreach ($arr_rfi_tags as $key => $rval) {
				$tagid = Tagging::searchAndInsertTag($database,$rval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');
			TableService::UpdateTabularData($database,'requests_for_information','tag_ids',$request_for_information_id,$arrtag);

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformationResponse record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
				if($v =="rfi_Tags")
				{	unset($httpGetInputData[$k]); }
			}

			$requestForInformationResponse = new RequestForInformationResponse($database);

			$requestForInformationResponse->setData($httpGetInputData);
			$requestForInformationResponse->convertDataToProperties();

			/*
			$requestForInformationResponse->request_for_information_response_id = $request_for_information_response_id;
			$requestForInformationResponse->request_for_information_id = $request_for_information_id;
			$requestForInformationResponse->request_for_information_response_sequence_number = $request_for_information_response_sequence_number;
			$requestForInformationResponse->request_for_information_response_type_id = $request_for_information_response_type_id;
			$requestForInformationResponse->rfi_responder_contact_id = $rfi_responder_contact_id;
			$requestForInformationResponse->rfi_responder_contact_company_office_id = $rfi_responder_contact_company_office_id;
			$requestForInformationResponse->rfi_responder_phone_contact_company_office_phone_number_id = $rfi_responder_phone_contact_company_office_phone_number_id;
			$requestForInformationResponse->rfi_responder_fax_contact_company_office_phone_number_id = $rfi_responder_fax_contact_company_office_phone_number_id;
			$requestForInformationResponse->rfi_responder_contact_mobile_phone_number_id = $rfi_responder_contact_mobile_phone_number_id;
			$requestForInformationResponse->request_for_information_response_title = $request_for_information_response_title;
			$requestForInformationResponse->request_for_information_response = $request_for_information_response;
			$requestForInformationResponse->modified = $modified;
			$requestForInformationResponse->created = $created;
			*/

			// Begin hacks.
		
			$requestForInformationResponse->request_for_information_id = $request_for_information_id;
			$requestForInformationResponse->rfi_responder_contact_id = $currentlyActiveContactId;
			$requestForInformationResponse->created = date('Y-m-d H:i:s');

			// to update contracting Entity
			$entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
			TableService::UpdateTabularData($database,'requests_for_information','contracting_entity_id',$request_for_information_id,$entity_id);

			// request_for_information_response_sequence_number
			$next_request_for_information_response_sequence_number = RequestForInformationResponse::findNextRequestForInformationResponseSequenceNumber($database, $request_for_information_id);
			$requestForInformationResponse->request_for_information_response_sequence_number = $next_request_for_information_response_sequence_number;

			/*
			$loadRequestForInformationResponsesByRequestForInformationIdOptions = new Input();
			$loadRequestForInformationResponsesByRequestForInformationIdOptions->forceLoadFlag = true;
			$arrRfiResponsesByRfiId = RequestForInformationResponse::loadRequestForInformationResponsesByRequestForInformationId($database, $request_for_information_id, $loadRequestForInformationResponsesByRequestForInformationIdOptions);
			$requestForInformationResponse->request_for_information_response_sequence_number = 1 + count($arrRfiResponsesByRfiId);
			*/

			$arrCustomizedJsonOutput = array('request_for_information_id' => $request_for_information_id);
			// End hacks.

			$requestForInformationResponse->convertPropertiesToData();
			$data = $requestForInformationResponse->getData();

			// Test for existence via standard findByUniqueIndex method
			$requestForInformationResponse->findByUniqueIndex();
			if ($requestForInformationResponse->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Request For Information Response already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$requestForInformationResponse->setKey(null);
				$data['created'] = null;
				$requestForInformationResponse->setData($data);
			}

			$request_for_information_response_id = $requestForInformationResponse->save();
			if (isset($request_for_information_response_id) && !empty($request_for_information_response_id)) {
				$requestForInformationResponse->request_for_information_response_id = $request_for_information_response_id;
				$requestForInformationResponse->setId($request_for_information_response_id);
			}
			// $requestForInformationResponse->save();

			$requestForInformationResponse->convertDataToProperties();
			$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information Response.';
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
			//$errorMessage = 'Error creating: Request For Information Response';
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
			if (isset($requestForInformationResponse) && $requestForInformationResponse instanceof RequestForInformationResponse) {
				$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
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

	case 'loadRequestForInformationResponse':

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
					'request_for_information_responses_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Responses';
			}

			// Primary key attibutes
			//$request_for_information_response_id = (int) $post->uniqueId;
			// Debug
			//$request_for_information_response_id = (int) 1;

			// Unique index attibutes
			$request_for_information_id = (int) $post->request_for_information_id;
			$request_for_information_response_sequence_number = (int) $post->request_for_information_response_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Response';
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
			if (isset($requestForInformationResponse) && $requestForInformationResponse instanceof RequestForInformationResponse) {
				$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
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

	case 'loadAllRequestForInformationResponseRecords':

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
					'request_for_information_responses_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Responses';
			}

			// Primary key attibutes
			//$request_for_information_response_id = (int) $post->uniqueId;
			// Debug
			//$request_for_information_response_id = (int) 1;

			// Unique index attibutes
			$request_for_information_id = (int) $post->request_for_information_id;
			$request_for_information_response_sequence_number = (int) $post->request_for_information_response_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|request_for_information_responses|Request For Information Response|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Response';
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

	case 'updateRequestForInformationResponse':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Response';
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
					'request_for_information_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Request For Information Response - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Responses';
			}

			// Primary key attibutes
			//$request_for_information_response_id = (int) $post->uniqueId;
			// Debug
			//$request_for_information_response_id = (int) 1;

			// Unique index attibutes
			$request_for_information_id = (int) $post->request_for_information_id;
			$request_for_information_response_sequence_number = (int) $post->request_for_information_response_sequence_number;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'request_for_information_response_id' => 'request for information response id',
				'request_for_information_id' => 'request for information id',
				'request_for_information_response_sequence_number' => 'request for information response sequence number',
				'request_for_information_response_type_id' => 'request for information response type id',
				'rfi_responder_contact_id' => 'rfi responder contact id',
				'rfi_responder_contact_company_office_id' => 'rfi responder contact company office id',
				'rfi_responder_phone_contact_company_office_phone_number_id' => 'rfi responder phone contact company office phone number id',
				'rfi_responder_fax_contact_company_office_phone_number_id' => 'rfi responder fax contact company office phone number id',
				'rfi_responder_contact_mobile_phone_number_id' => 'rfi responder contact mobile phone number id',
				'request_for_information_response_title' => 'request for information response title',
				'request_for_information_response' => 'request for information response',
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

			if ($attributeSubgroupName == 'request_for_information_responses') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$request_for_information_response_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationResponse = RequestForInformationResponse::findById($database, $request_for_information_response_id);
				/* @var $requestForInformationResponse RequestForInformationResponse */

				if ($requestForInformationResponse) {
					// Check if the value actually changed
					$existingValue = $requestForInformationResponse->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'request_for_information_id' => 1,
						'request_for_information_response_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $requestForInformationResponse->$attributeName;
						$requestForInformationResponse->$attributeName = $newValue;
						$possibleDuplicateRequestForInformationResponse = RequestForInformationResponse::findByRequestForInformationIdAndRequestForInformationResponseSequenceNumber($database, $requestForInformationResponse->request_for_information_id, $requestForInformationResponse->request_for_information_response_sequence_number);
						if ($possibleDuplicateRequestForInformationResponse) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Request For Information Response $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$requestForInformationResponse->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$requestForInformationResponse->setData($data);
						// $request_for_information_response_id = $requestForInformationResponse->save();
						$requestForInformationResponse->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Response record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Request For Information Response';
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
			if (isset($requestForInformationResponse) && $requestForInformationResponse instanceof RequestForInformationResponse) {
				$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
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

	case 'updateAllRequestForInformationResponseAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Response';
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
					'request_for_information_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Request For Information Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Responses';
			}

			// Primary key attibutes
			//$request_for_information_response_id = (int) $post->uniqueId;
			// Debug
			//$request_for_information_response_id = (int) 1;

			// Unique index attibutes
			$request_for_information_id = (int) $post->request_for_information_id;
			$request_for_information_response_sequence_number = (int) $post->request_for_information_response_sequence_number;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_response_id = (int) $get->request_for_information_response_id;
			$request_for_information_id = (int) $get->request_for_information_id;
			$request_for_information_response_sequence_number = (int) $get->request_for_information_response_sequence_number;
			$request_for_information_response_type_id = (int) $get->request_for_information_response_type_id;
			$rfi_responder_contact_id = (int) $get->rfi_responder_contact_id;
			$rfi_responder_contact_company_office_id = (int) $get->rfi_responder_contact_company_office_id;
			$rfi_responder_phone_contact_company_office_phone_number_id = (int) $get->rfi_responder_phone_contact_company_office_phone_number_id;
			$rfi_responder_fax_contact_company_office_phone_number_id = (int) $get->rfi_responder_fax_contact_company_office_phone_number_id;
			$rfi_responder_contact_mobile_phone_number_id = (int) $get->rfi_responder_contact_mobile_phone_number_id;
			$request_for_information_response_title = (string) $get->request_for_information_response_title;
			$request_for_information_response = (string) $get->request_for_information_response;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_responses') {
				$request_for_information_response_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationResponse = RequestForInformationResponse::findById($database, $request_for_information_response_id);
				/* @var $requestForInformationResponse RequestForInformationResponse */

				if ($requestForInformationResponse) {
					$existingData = $requestForInformationResponse->getData();

					// Retrieve all of the $_GET inputs automatically for the RequestForInformationResponse record
					$httpGetInputData = $post->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$requestForInformationResponse->setData($httpGetInputData);
					$requestForInformationResponse->convertDataToProperties();
					$requestForInformationResponse->convertPropertiesToData();

					$newData = $requestForInformationResponse->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$requestForInformationResponse->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Request For Information Response<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$requestForInformationResponse->request_for_information_response_id = $request_for_information_response_id;
			$requestForInformationResponse->request_for_information_id = $request_for_information_id;
			$requestForInformationResponse->request_for_information_response_sequence_number = $request_for_information_response_sequence_number;
			$requestForInformationResponse->request_for_information_response_type_id = $request_for_information_response_type_id;
			$requestForInformationResponse->rfi_responder_contact_id = $rfi_responder_contact_id;
			$requestForInformationResponse->rfi_responder_contact_company_office_id = $rfi_responder_contact_company_office_id;
			$requestForInformationResponse->rfi_responder_phone_contact_company_office_phone_number_id = $rfi_responder_phone_contact_company_office_phone_number_id;
			$requestForInformationResponse->rfi_responder_fax_contact_company_office_phone_number_id = $rfi_responder_fax_contact_company_office_phone_number_id;
			$requestForInformationResponse->rfi_responder_contact_mobile_phone_number_id = $rfi_responder_contact_mobile_phone_number_id;
			$requestForInformationResponse->request_for_information_response_title = $request_for_information_response_title;
			$requestForInformationResponse->request_for_information_response = $request_for_information_response;
			$requestForInformationResponse->modified = $modified;
			$requestForInformationResponse->created = $created;
					*/

					// $request_for_information_response_id = $requestForInformationResponse->save();
					$requestForInformationResponse->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Response record does not exist.';
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
			//$errorMessage = 'Error updating: Request For Information Response';
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
			if (isset($requestForInformationResponse) && $requestForInformationResponse instanceof RequestForInformationResponse) {
				$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
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

	case 'deleteRequestForInformationResponse':

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
					'request_for_information_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Request For Information Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Responses';
			}

			// Primary key attibutes
			//$request_for_information_response_id = (int) $post->uniqueId;
			// Debug
			//$request_for_information_response_id = (int) 1;

			// Unique index attibutes
			$request_for_information_id = (int) $post->request_for_information_id;
			$request_for_information_response_sequence_number = (int) $post->request_for_information_response_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_responses') {
				$request_for_information_response_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationResponse = RequestForInformationResponse::findById($database, $request_for_information_response_id);
				/* @var $requestForInformationResponse RequestForInformationResponse */

				if ($requestForInformationResponse) {
					$requestForInformationResponse->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Response record does not exist.';
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
			//$errorMessage = 'Error deleting: Request For Information Response';
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
			if (isset($requestForInformationResponse) && $requestForInformationResponse instanceof RequestForInformationResponse) {
				$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
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

	case 'saveRequestForInformationResponse':

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
					'request_for_information_responses_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Request For Information Response data values.';
				$arrErrorMessages = array(
					'Error saving Request For Information Response.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Response';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Responses';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_response-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_response_id = (int) $get->request_for_information_response_id;
			$request_for_information_id = (int) $get->request_for_information_id;
			$request_for_information_response_sequence_number = (int) $get->request_for_information_response_sequence_number;
			$request_for_information_response_type_id = (int) $get->request_for_information_response_type_id;
			$rfi_responder_contact_id = (int) $get->rfi_responder_contact_id;
			$rfi_responder_contact_company_office_id = (int) $get->rfi_responder_contact_company_office_id;
			$rfi_responder_phone_contact_company_office_phone_number_id = (int) $get->rfi_responder_phone_contact_company_office_phone_number_id;
			$rfi_responder_fax_contact_company_office_phone_number_id = (int) $get->rfi_responder_fax_contact_company_office_phone_number_id;
			$rfi_responder_contact_mobile_phone_number_id = (int) $get->rfi_responder_contact_mobile_phone_number_id;
			$request_for_information_response_title = (string) $get->request_for_information_response_title;
			$request_for_information_response = (string) $get->request_for_information_response;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$requestForInformationResponse = new RequestForInformationResponse($database);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformationResponse record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$requestForInformationResponse->setData($httpGetInputData);
			$requestForInformationResponse->convertDataToProperties();

			/*
			$requestForInformationResponse->request_for_information_response_id = $request_for_information_response_id;
			$requestForInformationResponse->request_for_information_id = $request_for_information_id;
			$requestForInformationResponse->request_for_information_response_sequence_number = $request_for_information_response_sequence_number;
			$requestForInformationResponse->request_for_information_response_type_id = $request_for_information_response_type_id;
			$requestForInformationResponse->rfi_responder_contact_id = $rfi_responder_contact_id;
			$requestForInformationResponse->rfi_responder_contact_company_office_id = $rfi_responder_contact_company_office_id;
			$requestForInformationResponse->rfi_responder_phone_contact_company_office_phone_number_id = $rfi_responder_phone_contact_company_office_phone_number_id;
			$requestForInformationResponse->rfi_responder_fax_contact_company_office_phone_number_id = $rfi_responder_fax_contact_company_office_phone_number_id;
			$requestForInformationResponse->rfi_responder_contact_mobile_phone_number_id = $rfi_responder_contact_mobile_phone_number_id;
			$requestForInformationResponse->request_for_information_response_title = $request_for_information_response_title;
			$requestForInformationResponse->request_for_information_response = $request_for_information_response;
			$requestForInformationResponse->modified = $modified;
			$requestForInformationResponse->created = $created;
			*/

			$requestForInformationResponse->convertPropertiesToData();
			$data = $requestForInformationResponse->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$request_for_information_response_id = $requestForInformationResponse->insertOnDuplicateKeyUpdate();
			if (isset($request_for_information_response_id) && !empty($request_for_information_response_id)) {
				$requestForInformationResponse->request_for_information_response_id = $request_for_information_response_id;
				$requestForInformationResponse->setId($request_for_information_response_id);
			}
			// $requestForInformationResponse->insertOnDuplicateKeyUpdate();
			// $requestForInformationResponse->insertIgnore();

			$requestForInformationResponse->convertDataToProperties();
			$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information Response.';
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
			//$errorMessage = 'Error creating: Request For Information Response';
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
			if (isset($requestForInformationResponse) && $requestForInformationResponse instanceof RequestForInformationResponse) {
				$primaryKeyAsString = $requestForInformationResponse->getPrimaryKeyAsString();
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

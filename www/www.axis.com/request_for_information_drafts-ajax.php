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
 }else {
	echo '';
	exit;
}

require_once('lib/common/PageComponents.php');

require_once('lib/common/RequestForInformationDraft.php');

require_once('lib/common/Message.php');

require_once('lib/common/RequestForInformationDraftRecipient.php');

require_once('lib/common/Tagging.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('request_for_information_drafts-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewRequestForInformationDrafts = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_drafts_view');
$userCanManageRequestForInformationDrafts = $permissions->determineAccessToSoftwareModuleFunction('request_for_information_drafts_manage');
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
	case 'createRequestForInformationDraft':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$buttonDeleteRfiDraft = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'request_for_information_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Request For Information Draft data values.';
				$arrErrorMessages = array(
					'Error creating: Request For Information Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Drafts';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_draft-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_draft_id = (int) $get->request_for_information_draft_id;
			$project_id = (int) $get->project_id;
			$request_for_information_type_id = (int) $get->request_for_information_type_id;
			$request_for_information_priority_id = (int) $get->request_for_information_priority_id;
			$rfi_file_manager_file_id = (int) $get->rfi_file_manager_file_id;
			$rfi_cost_code_id = (int) $get->rfi_cost_code_id;
			$rfi_creator_contact_id = (int) $get->rfi_creator_contact_id;
			$rfi_creator_contact_company_office_id = (int) $get->rfi_creator_contact_company_office_id;
			$rfi_creator_phone_contact_company_office_phone_number_id = (int) $get->rfi_creator_phone_contact_company_office_phone_number_id;
			$rfi_creator_fax_contact_company_office_phone_number_id = (int) $get->rfi_creator_fax_contact_company_office_phone_number_id;
			$rfi_creator_contact_mobile_phone_number_id = (int) $get->rfi_creator_contact_mobile_phone_number_id;
			$rfi_recipient_contact_id = (int) $get->rfi_recipient_contact_id;
			$rfi_recipient_contact_company_office_id = (int) $get->rfi_recipient_contact_company_office_id;
			$rfi_recipient_phone_contact_company_office_phone_number_id = (int) $get->rfi_recipient_phone_contact_company_office_phone_number_id;
			$rfi_recipient_fax_contact_company_office_phone_number_id = (int) $get->rfi_recipient_fax_contact_company_office_phone_number_id;
			$rfi_recipient_contact_mobile_phone_number_id = (int) $get->rfi_recipient_contact_mobile_phone_number_id;
			$rfi_initiator_contact_id = (int) $get->rfi_initiator_contact_id;
			$rfi_initiator_contact_company_office_id = (int) $get->rfi_initiator_contact_company_office_id;
			$rfi_initiator_phone_contact_company_office_phone_number_id = (int) $get->rfi_initiator_phone_contact_company_office_phone_number_id;
			$rfi_initiator_fax_contact_company_office_phone_number_id = (int) $get->rfi_initiator_fax_contact_company_office_phone_number_id;
			$rfi_initiator_contact_mobile_phone_number_id = (int) $get->rfi_initiator_contact_mobile_phone_number_id;
			$rfi_title = (string) $get->rfi_title;
			$rfi_plan_page_reference = (string) $get->rfi_plan_page_reference;
			$rfi_statement = (string) $get->rfi_statement;
			$rfi_due_date = (string) $get->rfi_due_date;
			*/
			$rfi_Tags = (string) $post->rfi_Tags;
			$arr_rfi_tags = explode(',', $rfi_Tags);
			$arrtag ='';
			foreach ($arr_rfi_tags as $key => $rval) {
				$tagid = Tagging::searchAndInsertTag($database,$rval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');

			$rfi_title = (string) $post->rfi_title;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformationDraft record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
				if($v =="rfi_Tags")
				{	unset($httpGetInputData[$k]); }
			}
			$httpGetInputData['tag_ids']=$arrtag;

			$requestForInformationDraft = new RequestForInformationDraft($database);

			$requestForInformationDraft->setData($httpGetInputData);
			$requestForInformationDraft->convertDataToProperties();

			/*
			$requestForInformationDraft->request_for_information_draft_id = $request_for_information_draft_id;
			$requestForInformationDraft->project_id = $project_id;
			$requestForInformationDraft->request_for_information_type_id = $request_for_information_type_id;
			$requestForInformationDraft->request_for_information_priority_id = $request_for_information_priority_id;
			$requestForInformationDraft->rfi_file_manager_file_id = $rfi_file_manager_file_id;
			$requestForInformationDraft->rfi_cost_code_id = $rfi_cost_code_id;
			$requestForInformationDraft->rfi_creator_contact_id = $rfi_creator_contact_id;
			$requestForInformationDraft->rfi_creator_contact_company_office_id = $rfi_creator_contact_company_office_id;
			$requestForInformationDraft->rfi_creator_phone_contact_company_office_phone_number_id = $rfi_creator_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_creator_fax_contact_company_office_phone_number_id = $rfi_creator_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_creator_contact_mobile_phone_number_id = $rfi_creator_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_recipient_contact_id = $rfi_recipient_contact_id;
			$requestForInformationDraft->rfi_recipient_contact_company_office_id = $rfi_recipient_contact_company_office_id;
			$requestForInformationDraft->rfi_recipient_phone_contact_company_office_phone_number_id = $rfi_recipient_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_recipient_fax_contact_company_office_phone_number_id = $rfi_recipient_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_recipient_contact_mobile_phone_number_id = $rfi_recipient_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_initiator_contact_id = $rfi_initiator_contact_id;
			$requestForInformationDraft->rfi_initiator_contact_company_office_id = $rfi_initiator_contact_company_office_id;
			$requestForInformationDraft->rfi_initiator_phone_contact_company_office_phone_number_id = $rfi_initiator_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_initiator_fax_contact_company_office_phone_number_id = $rfi_initiator_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_initiator_contact_mobile_phone_number_id = $rfi_initiator_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_title = $rfi_title;
			$requestForInformationDraft->rfi_plan_page_reference = $rfi_plan_page_reference;
			$requestForInformationDraft->rfi_statement = $rfi_statement;
			$requestForInformationDraft->rfi_due_date = $rfi_due_date;
			*/

			$requestForInformationDraft->convertPropertiesToData();
			$data = $requestForInformationDraft->getData();

			// Test for existence via standard findByUniqueIndex method
			$requestForInformationDraft->findByUniqueIndex();
			if ($requestForInformationDraft->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Request For Information Draft already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$requestForInformationDraft->setKey(null);
				$requestForInformationDraft->setData($data);
			}

			$request_for_information_draft_id = $requestForInformationDraft->save();
			if (isset($request_for_information_draft_id) && !empty($request_for_information_draft_id)) {
				$requestForInformationDraft->request_for_information_draft_id = $request_for_information_draft_id;
				$requestForInformationDraft->setId($request_for_information_draft_id);
			}

			$rfi_to_recipient_contact_ids = (string) $post->rfi_to_recipient_contact_ids;
			if(!empty($rfi_to_recipient_contact_ids)){
				RequestForInformationDraftRecipient::saveToRecipients($database, $request_for_information_draft_id, $rfi_to_recipient_contact_ids);
			}

            $rfi_cc_recipient_contact_ids = (string) $post->rfi_cc_recipient_contact_ids;
			if(!empty($rfi_cc_recipient_contact_ids)){
				RequestForInformationDraftRecipient::saveCcRecipients($database, $request_for_information_draft_id, $rfi_cc_recipient_contact_ids);
			}

			$rfi_bcc_recipient_contact_ids = (string) $post->rfi_bcc_recipient_contact_ids;
			if(!empty($rfi_bcc_recipient_contact_ids)){
				RequestForInformationDraftRecipient::saveBccRecipients($database, $request_for_information_draft_id, $rfi_bcc_recipient_contact_ids);
			}
			// $requestForInformationDraft->save();

			$requestForInformationDraft->convertDataToProperties();
			$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				$htmlRecord = '<option value="'.$primaryKeyAsString.'">'.$rfi_title.'</option>';
				$buttonDeleteRfiDraft = <<<END_HTML_CONTENT
<input type="button" value="Delete RFI Draft" onclick="RFIs__deleteRequestForInformationDraft('manage-request_for_information_draft-record', 'request_for_information_drafts', '$primaryKeyAsString', { successCallback: RFIs__deleteRequestForInformationDraftSuccess });" style="font-size: 10pt;">
END_HTML_CONTENT;

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information Draft.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}

			$arrCustomizedJsonOutput = array('buttonDeleteRfiDraft' => $buttonDeleteRfiDraft);

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Request For Information Draft';
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
			if (isset($requestForInformationDraft) && $requestForInformationDraft instanceof RequestForInformationDraft) {
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlRecord|$buttonDeleteRfiDraft";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadRequestForInformationDraft':

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
					'request_for_information_drafts_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Drafts';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Draft';
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
			if (isset($requestForInformationDraft) && $requestForInformationDraft instanceof RequestForInformationDraft) {
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
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

	case 'loadAllRequestForInformationDraftRecords':

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
					'request_for_information_drafts_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Drafts';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|request_for_information_drafts|Request For Information Draft|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information Draft';
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

	case 'updateRequestForInformationDraft':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Draft';
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
					'request_for_information_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Request For Information Draft - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Drafts';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'request_for_information_draft_id' => 'request for information draft id',
				'project_id' => 'project id',
				'request_for_information_type_id' => 'request for information type id',
				'request_for_information_priority_id' => 'request for information priority id',
				'rfi_file_manager_file_id' => 'rfi file manager file id',
				'rfi_cost_code_id' => 'rfi cost code id',
				'rfi_creator_contact_id' => 'rfi creator contact id',
				'rfi_creator_contact_company_office_id' => 'rfi creator contact company office id',
				'rfi_creator_phone_contact_company_office_phone_number_id' => 'rfi creator phone contact company office phone number id',
				'rfi_creator_fax_contact_company_office_phone_number_id' => 'rfi creator fax contact company office phone number id',
				'rfi_creator_contact_mobile_phone_number_id' => 'rfi creator contact mobile phone number id',
				'rfi_recipient_contact_id' => 'rfi recipient contact id',
				'rfi_recipient_contact_company_office_id' => 'rfi recipient contact company office id',
				'rfi_recipient_phone_contact_company_office_phone_number_id' => 'rfi recipient phone contact company office phone number id',
				'rfi_recipient_fax_contact_company_office_phone_number_id' => 'rfi recipient fax contact company office phone number id',
				'rfi_recipient_contact_mobile_phone_number_id' => 'rfi recipient contact mobile phone number id',
				'rfi_initiator_contact_id' => 'rfi initiator contact id',
				'rfi_initiator_contact_company_office_id' => 'rfi initiator contact company office id',
				'rfi_initiator_phone_contact_company_office_phone_number_id' => 'rfi initiator phone contact company office phone number id',
				'rfi_initiator_fax_contact_company_office_phone_number_id' => 'rfi initiator fax contact company office phone number id',
				'rfi_initiator_contact_mobile_phone_number_id' => 'rfi initiator contact mobile phone number id',
				'rfi_title' => 'rfi title',
				'rfi_plan_page_reference' => 'rfi plan page reference',
				'rfi_statement' => 'rfi statement',
				'rfi_due_date' => 'rfi due date',
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

			if ($attributeSubgroupName == 'request_for_information_drafts') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$request_for_information_draft_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationDraft = RequestForInformationDraft::findById($database, $request_for_information_draft_id);
				/* @var $requestForInformationDraft RequestForInformationDraft */

				if ($requestForInformationDraft) {
					// Check if the value actually changed
					$existingValue = $requestForInformationDraft->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$requestForInformationDraft->setData($data);
						// $request_for_information_draft_id = $requestForInformationDraft->save();
						$requestForInformationDraft->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Draft record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Request For Information Draft';
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
			if (isset($requestForInformationDraft) && $requestForInformationDraft instanceof RequestForInformationDraft) {
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
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

	case 'updateAllRequestForInformationDraftAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information Draft';
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
					'request_for_information_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Request For Information Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Drafts';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_draft_id = (int) $get->request_for_information_draft_id;
			$project_id = (int) $get->project_id;
			$request_for_information_type_id = (int) $get->request_for_information_type_id;
			$request_for_information_priority_id = (int) $get->request_for_information_priority_id;
			$rfi_file_manager_file_id = (int) $get->rfi_file_manager_file_id;
			$rfi_cost_code_id = (int) $get->rfi_cost_code_id;
			$rfi_creator_contact_id = (int) $get->rfi_creator_contact_id;
			$rfi_creator_contact_company_office_id = (int) $get->rfi_creator_contact_company_office_id;
			$rfi_creator_phone_contact_company_office_phone_number_id = (int) $get->rfi_creator_phone_contact_company_office_phone_number_id;
			$rfi_creator_fax_contact_company_office_phone_number_id = (int) $get->rfi_creator_fax_contact_company_office_phone_number_id;
			$rfi_creator_contact_mobile_phone_number_id = (int) $get->rfi_creator_contact_mobile_phone_number_id;
			$rfi_recipient_contact_id = (int) $get->rfi_recipient_contact_id;
			$rfi_recipient_contact_company_office_id = (int) $get->rfi_recipient_contact_company_office_id;
			$rfi_recipient_phone_contact_company_office_phone_number_id = (int) $get->rfi_recipient_phone_contact_company_office_phone_number_id;
			$rfi_recipient_fax_contact_company_office_phone_number_id = (int) $get->rfi_recipient_fax_contact_company_office_phone_number_id;
			$rfi_recipient_contact_mobile_phone_number_id = (int) $get->rfi_recipient_contact_mobile_phone_number_id;
			$rfi_initiator_contact_id = (int) $get->rfi_initiator_contact_id;
			$rfi_initiator_contact_company_office_id = (int) $get->rfi_initiator_contact_company_office_id;
			$rfi_initiator_phone_contact_company_office_phone_number_id = (int) $get->rfi_initiator_phone_contact_company_office_phone_number_id;
			$rfi_initiator_fax_contact_company_office_phone_number_id = (int) $get->rfi_initiator_fax_contact_company_office_phone_number_id;
			$rfi_initiator_contact_mobile_phone_number_id = (int) $get->rfi_initiator_contact_mobile_phone_number_id;
			$rfi_title = (string) $get->rfi_title;
			$rfi_plan_page_reference = (string) $get->rfi_plan_page_reference;
			$rfi_statement = (string) $get->rfi_statement;
			$rfi_due_date = (string) $get->rfi_due_date;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$rfi_Tags = (string) $post->rfi_Tags;
			$arr_rfi_tags = explode(',', $rfi_Tags);
			$arrtag ='';
			foreach ($arr_rfi_tags as $key => $rval) {
				$tagid = Tagging::searchAndInsertTag($database,$rval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');

			if ($attributeSubgroupName == 'request_for_information_drafts') {
				$request_for_information_draft_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationDraft = RequestForInformationDraft::findById($database, $request_for_information_draft_id);
				/* @var $requestForInformationDraft RequestForInformationDraft */

				if ($requestForInformationDraft) {
					$existingData = $requestForInformationDraft->getData();

					// Retrieve all of the $_GET inputs automatically for the RequestForInformationDraft record
					$httpGetInputData = $post->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/
					$httpGetInputData['tag_ids'] =$arrtag;
					$requestForInformationDraft->setData($httpGetInputData);
					$requestForInformationDraft->convertDataToProperties();
					$requestForInformationDraft->convertPropertiesToData();

					$newData = $requestForInformationDraft->getData();
					$data = Data::deltify($existingData, $newData);
                    
                    //save cc and bcc recipients
                    RequestForInformationDraftRecipient::deletRecipients($database, $request_for_information_draft_id);

                    $rfi_to_recipient_contact_ids = (string) $post->rfi_to_recipient_contact_ids;
                    if(!empty($rfi_to_recipient_contact_ids)){
                    	RequestForInformationDraftRecipient::saveToRecipients($database, $request_for_information_draft_id, $rfi_to_recipient_contact_ids);
                    }

					$rfi_cc_recipient_contact_ids = (string) $post->rfi_cc_recipient_contact_ids;
					if(!empty($rfi_cc_recipient_contact_ids)){
						RequestForInformationDraftRecipient::saveCcRecipients($database, $request_for_information_draft_id, $rfi_cc_recipient_contact_ids);
					}

					$rfi_bcc_recipient_contact_ids = (string) $post->rfi_bcc_recipient_contact_ids;
					if(!empty($rfi_bcc_recipient_contact_ids)){
						RequestForInformationDraftRecipient::saveBccRecipients($database, $request_for_information_draft_id, $rfi_bcc_recipient_contact_ids);
					}
					if (!empty($data)) {
						$requestForInformationDraft->setData($data);
						$save = true;
					} else {
						$errorNumber = 2;
						$errorMessage = 'Error updating: Request For Information Draft<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$requestForInformationDraft->request_for_information_draft_id = $request_for_information_draft_id;
			$requestForInformationDraft->project_id = $project_id;
			$requestForInformationDraft->request_for_information_type_id = $request_for_information_type_id;
			$requestForInformationDraft->request_for_information_priority_id = $request_for_information_priority_id;
			$requestForInformationDraft->rfi_file_manager_file_id = $rfi_file_manager_file_id;
			$requestForInformationDraft->rfi_cost_code_id = $rfi_cost_code_id;
			$requestForInformationDraft->rfi_creator_contact_id = $rfi_creator_contact_id;
			$requestForInformationDraft->rfi_creator_contact_company_office_id = $rfi_creator_contact_company_office_id;
			$requestForInformationDraft->rfi_creator_phone_contact_company_office_phone_number_id = $rfi_creator_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_creator_fax_contact_company_office_phone_number_id = $rfi_creator_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_creator_contact_mobile_phone_number_id = $rfi_creator_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_recipient_contact_id = $rfi_recipient_contact_id;
			$requestForInformationDraft->rfi_recipient_contact_company_office_id = $rfi_recipient_contact_company_office_id;
			$requestForInformationDraft->rfi_recipient_phone_contact_company_office_phone_number_id = $rfi_recipient_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_recipient_fax_contact_company_office_phone_number_id = $rfi_recipient_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_recipient_contact_mobile_phone_number_id = $rfi_recipient_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_initiator_contact_id = $rfi_initiator_contact_id;
			$requestForInformationDraft->rfi_initiator_contact_company_office_id = $rfi_initiator_contact_company_office_id;
			$requestForInformationDraft->rfi_initiator_phone_contact_company_office_phone_number_id = $rfi_initiator_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_initiator_fax_contact_company_office_phone_number_id = $rfi_initiator_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_initiator_contact_mobile_phone_number_id = $rfi_initiator_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_title = $rfi_title;
			$requestForInformationDraft->rfi_plan_page_reference = $rfi_plan_page_reference;
			$requestForInformationDraft->rfi_statement = $rfi_statement;
			$requestForInformationDraft->rfi_due_date = $rfi_due_date;
					*/

					// $request_for_information_draft_id = $requestForInformationDraft->save();
					$requestForInformationDraft->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Draft record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			if ($errorNumber == 0) {
				$errorNumber = 1;
			}

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Request For Information Draft';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			if ($errorNumber == 0) {
				$errorNumber = 1;
			}
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($requestForInformationDraft) && $requestForInformationDraft instanceof RequestForInformationDraft) {
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
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

	case 'deleteRequestForInformationDraft':

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
					'request_for_information_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Request For Information Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Drafts';
			}

			// Primary key attibutes
			//$request_for_information_draft_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_draft_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'request_for_information_drafts') {
				$request_for_information_draft_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformationDraft = RequestForInformationDraft::findById($database, $request_for_information_draft_id);
				/* @var $requestForInformationDraft RequestForInformationDraft */

				if ($requestForInformationDraft) {
					$requestForInformationDraft->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information Draft record does not exist.';
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
			//$errorMessage = 'Error deleting: Request For Information Draft';
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
			if (isset($requestForInformationDraft) && $requestForInformationDraft instanceof RequestForInformationDraft) {
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
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

	case 'saveRequestForInformationDraft':

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
					'request_for_information_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Request For Information Draft data values.';
				$arrErrorMessages = array(
					'Error saving Request For Information Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Request For Information Drafts';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information_draft-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_draft_id = (int) $get->request_for_information_draft_id;
			$project_id = (int) $get->project_id;
			$request_for_information_type_id = (int) $get->request_for_information_type_id;
			$request_for_information_priority_id = (int) $get->request_for_information_priority_id;
			$rfi_file_manager_file_id = (int) $get->rfi_file_manager_file_id;
			$rfi_cost_code_id = (int) $get->rfi_cost_code_id;
			$rfi_creator_contact_id = (int) $get->rfi_creator_contact_id;
			$rfi_creator_contact_company_office_id = (int) $get->rfi_creator_contact_company_office_id;
			$rfi_creator_phone_contact_company_office_phone_number_id = (int) $get->rfi_creator_phone_contact_company_office_phone_number_id;
			$rfi_creator_fax_contact_company_office_phone_number_id = (int) $get->rfi_creator_fax_contact_company_office_phone_number_id;
			$rfi_creator_contact_mobile_phone_number_id = (int) $get->rfi_creator_contact_mobile_phone_number_id;
			$rfi_recipient_contact_id = (int) $get->rfi_recipient_contact_id;
			$rfi_recipient_contact_company_office_id = (int) $get->rfi_recipient_contact_company_office_id;
			$rfi_recipient_phone_contact_company_office_phone_number_id = (int) $get->rfi_recipient_phone_contact_company_office_phone_number_id;
			$rfi_recipient_fax_contact_company_office_phone_number_id = (int) $get->rfi_recipient_fax_contact_company_office_phone_number_id;
			$rfi_recipient_contact_mobile_phone_number_id = (int) $get->rfi_recipient_contact_mobile_phone_number_id;
			$rfi_initiator_contact_id = (int) $get->rfi_initiator_contact_id;
			$rfi_initiator_contact_company_office_id = (int) $get->rfi_initiator_contact_company_office_id;
			$rfi_initiator_phone_contact_company_office_phone_number_id = (int) $get->rfi_initiator_phone_contact_company_office_phone_number_id;
			$rfi_initiator_fax_contact_company_office_phone_number_id = (int) $get->rfi_initiator_fax_contact_company_office_phone_number_id;
			$rfi_initiator_contact_mobile_phone_number_id = (int) $get->rfi_initiator_contact_mobile_phone_number_id;
			$rfi_title = (string) $get->rfi_title;
			$rfi_plan_page_reference = (string) $get->rfi_plan_page_reference;
			$rfi_statement = (string) $get->rfi_statement;
			$rfi_due_date = (string) $get->rfi_due_date;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$requestForInformationDraft = new RequestForInformationDraft($database);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformationDraft record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$requestForInformationDraft->setData($httpGetInputData);
			$requestForInformationDraft->convertDataToProperties();

			/*
			$requestForInformationDraft->request_for_information_draft_id = $request_for_information_draft_id;
			$requestForInformationDraft->project_id = $project_id;
			$requestForInformationDraft->request_for_information_type_id = $request_for_information_type_id;
			$requestForInformationDraft->request_for_information_priority_id = $request_for_information_priority_id;
			$requestForInformationDraft->rfi_file_manager_file_id = $rfi_file_manager_file_id;
			$requestForInformationDraft->rfi_cost_code_id = $rfi_cost_code_id;
			$requestForInformationDraft->rfi_creator_contact_id = $rfi_creator_contact_id;
			$requestForInformationDraft->rfi_creator_contact_company_office_id = $rfi_creator_contact_company_office_id;
			$requestForInformationDraft->rfi_creator_phone_contact_company_office_phone_number_id = $rfi_creator_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_creator_fax_contact_company_office_phone_number_id = $rfi_creator_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_creator_contact_mobile_phone_number_id = $rfi_creator_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_recipient_contact_id = $rfi_recipient_contact_id;
			$requestForInformationDraft->rfi_recipient_contact_company_office_id = $rfi_recipient_contact_company_office_id;
			$requestForInformationDraft->rfi_recipient_phone_contact_company_office_phone_number_id = $rfi_recipient_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_recipient_fax_contact_company_office_phone_number_id = $rfi_recipient_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_recipient_contact_mobile_phone_number_id = $rfi_recipient_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_initiator_contact_id = $rfi_initiator_contact_id;
			$requestForInformationDraft->rfi_initiator_contact_company_office_id = $rfi_initiator_contact_company_office_id;
			$requestForInformationDraft->rfi_initiator_phone_contact_company_office_phone_number_id = $rfi_initiator_phone_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_initiator_fax_contact_company_office_phone_number_id = $rfi_initiator_fax_contact_company_office_phone_number_id;
			$requestForInformationDraft->rfi_initiator_contact_mobile_phone_number_id = $rfi_initiator_contact_mobile_phone_number_id;
			$requestForInformationDraft->rfi_title = $rfi_title;
			$requestForInformationDraft->rfi_plan_page_reference = $rfi_plan_page_reference;
			$requestForInformationDraft->rfi_statement = $rfi_statement;
			$requestForInformationDraft->rfi_due_date = $rfi_due_date;
			*/

			$requestForInformationDraft->convertPropertiesToData();
			$data = $requestForInformationDraft->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$request_for_information_draft_id = $requestForInformationDraft->insertOnDuplicateKeyUpdate();
			if (isset($request_for_information_draft_id) && !empty($request_for_information_draft_id)) {
				$requestForInformationDraft->request_for_information_draft_id = $request_for_information_draft_id;
				$requestForInformationDraft->setId($request_for_information_draft_id);
			}
			// $requestForInformationDraft->insertOnDuplicateKeyUpdate();
			// $requestForInformationDraft->insertIgnore();

			$requestForInformationDraft->convertDataToProperties();
			$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information Draft.';
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
			//$errorMessage = 'Error creating: Request For Information Draft';
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
			if (isset($requestForInformationDraft) && $requestForInformationDraft instanceof RequestForInformationDraft) {
				$primaryKeyAsString = $requestForInformationDraft->getPrimaryKeyAsString();
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

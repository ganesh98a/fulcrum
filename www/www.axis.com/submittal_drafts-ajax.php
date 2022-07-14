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

require_once('lib/common/SubmittalDraft.php');

require_once('lib/common/Message.php');

require_once('lib/common/SubmittalDraftRecipient.php');

require_once('lib/common/Tagging.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('submittal_drafts-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewSubmittalDrafts = $permissions->determineAccessToSoftwareModuleFunction('submittal_drafts_view');
$userCanManageSubmittalDrafts = $permissions->determineAccessToSoftwareModuleFunction('submittal_drafts_manage');
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
	case 'createSubmittalDraft':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$buttonDeleteSuDraft = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittal_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Submittal Draft data values.';
				$arrErrorMessages = array(
					'Error creating: Submittal Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Drafts';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal_draft-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_draft_id = (int) $get->submittal_draft_id;
			$project_id = (int) $get->project_id;
			$submittal_type_id = (int) $get->submittal_type_id;
			$submittal_priority_id = (int) $get->submittal_priority_id;
			$submittal_distribution_method_id = (int) $get->submittal_distribution_method_id;
			$su_file_manager_file_id = (int) $get->su_file_manager_file_id;
			$su_cost_code_id = (int) $get->su_cost_code_id;
			$su_creator_contact_id = (int) $get->su_creator_contact_id;
			$su_creator_contact_company_office_id = (int) $get->su_creator_contact_company_office_id;
			$su_creator_phone_contact_company_office_phone_number_id = (int) $get->su_creator_phone_contact_company_office_phone_number_id;
			$su_creator_fax_contact_company_office_phone_number_id = (int) $get->su_creator_fax_contact_company_office_phone_number_id;
			$su_creator_contact_mobile_phone_number_id = (int) $get->su_creator_contact_mobile_phone_number_id;
			$su_recipient_contact_id = (int) $get->su_recipient_contact_id;
			$su_recipient_contact_company_office_id = (int) $get->su_recipient_contact_company_office_id;
			$su_recipient_phone_contact_company_office_phone_number_id = (int) $get->su_recipient_phone_contact_company_office_phone_number_id;
			$su_recipient_fax_contact_company_office_phone_number_id = (int) $get->su_recipient_fax_contact_company_office_phone_number_id;
			$su_recipient_contact_mobile_phone_number_id = (int) $get->su_recipient_contact_mobile_phone_number_id;
			$su_initiator_contact_id = (int) $get->su_initiator_contact_id;
			$su_initiator_contact_company_office_id = (int) $get->su_initiator_contact_company_office_id;
			$su_initiator_phone_contact_company_office_phone_number_id = (int) $get->su_initiator_phone_contact_company_office_phone_number_id;
			$su_initiator_fax_contact_company_office_phone_number_id = (int) $get->su_initiator_fax_contact_company_office_phone_number_id;
			$su_initiator_contact_mobile_phone_number_id = (int) $get->su_initiator_contact_mobile_phone_number_id;
			$su_title = (string) $get->su_title;
			$su_plan_page_reference = (string) $get->su_plan_page_reference;
			$su_statement = (string) $get->su_statement;
			$su_due_date = (string) $get->su_due_date;
			*/
			$sub_Tags = (string) $post->sub_Tags;
			$arr_sub_Tags = explode(',', $sub_Tags);
			$arrtag ='';
			foreach ($arr_sub_Tags as $key => $rval) {
				$tagid = Tagging::searchAndInsertTag($database,$rval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');

			$su_title = (string) $post->su_title;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the SubmittalDraft record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
				if($v =="sub_Tags")
				{	unset($httpGetInputData[$k]); }
			}
			$httpGetInputData['tag_ids']=$arrtag;

			$submittalDraft = new SubmittalDraft($database);

			$submittalDraft->setData($httpGetInputData);
			$submittalDraft->convertDataToProperties();

			/*
			$submittalDraft->submittal_draft_id = $submittal_draft_id;
			$submittalDraft->project_id = $project_id;
			$submittalDraft->submittal_type_id = $submittal_type_id;
			$submittalDraft->submittal_priority_id = $submittal_priority_id;
			$submittalDraft->submittal_distribution_method_id = $submittal_distribution_method_id;
			$submittalDraft->su_file_manager_file_id = $su_file_manager_file_id;
			$submittalDraft->su_cost_code_id = $su_cost_code_id;
			$submittalDraft->su_creator_contact_id = $su_creator_contact_id;
			$submittalDraft->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;
			$submittalDraft->su_creator_phone_contact_company_office_phone_number_id = $su_creator_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_creator_fax_contact_company_office_phone_number_id = $su_creator_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_creator_contact_mobile_phone_number_id = $su_creator_contact_mobile_phone_number_id;
			$submittalDraft->su_recipient_contact_id = $su_recipient_contact_id;
			$submittalDraft->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;
			$submittalDraft->su_recipient_phone_contact_company_office_phone_number_id = $su_recipient_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_recipient_fax_contact_company_office_phone_number_id = $su_recipient_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_recipient_contact_mobile_phone_number_id = $su_recipient_contact_mobile_phone_number_id;
			$submittalDraft->su_initiator_contact_id = $su_initiator_contact_id;
			$submittalDraft->su_initiator_contact_company_office_id = $su_initiator_contact_company_office_id;
			$submittalDraft->su_initiator_phone_contact_company_office_phone_number_id = $su_initiator_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_initiator_fax_contact_company_office_phone_number_id = $su_initiator_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_initiator_contact_mobile_phone_number_id = $su_initiator_contact_mobile_phone_number_id;
			$submittalDraft->su_title = $su_title;
			$submittalDraft->su_plan_page_reference = $su_plan_page_reference;
			$submittalDraft->su_statement = $su_statement;
			$submittalDraft->su_due_date = $su_due_date;
			*/

			$submittalDraft->convertPropertiesToData();
			$data = $submittalDraft->getData();

			// Test for existence via standard findByUniqueIndex method
			$submittalDraft->findByUniqueIndex();
			if ($submittalDraft->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Submittal Draft already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$submittalDraft->setKey(null);
				$submittalDraft->setData($data);
			}

			$submittal_draft_id = $submittalDraft->save();
			if (isset($submittal_draft_id) && !empty($submittal_draft_id)) {
				$submittalDraft->submittal_draft_id = $submittal_draft_id;
				$submittalDraft->setId($submittal_draft_id);
			}
			// to
			$to_recipient_contact_ids = (string) $post->su_to_recipient_contact_ids;
			if(!empty($to_recipient_contact_ids)){
				SubmittalDraftRecipient::saveToRecipients($database, $submittal_draft_id, $to_recipient_contact_ids);
			}

			$cc_recipient_contact_ids = (string) $post->su_cc_recipient_contact_ids;
			if(!empty($cc_recipient_contact_ids)){
				SubmittalDraftRecipient::saveCcRecipients($database, $submittal_draft_id, $cc_recipient_contact_ids);
			}

			$bcc_recipient_contact_ids = (string) $post->su_bcc_recipient_contact_ids;
			if(!empty($bcc_recipient_contact_ids)){
				SubmittalDraftRecipient::saveBccRecipients($database, $submittal_draft_id, $bcc_recipient_contact_ids);
			}
			// $submittalDraft->save();

			$submittalDraft->convertDataToProperties();
			$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				$htmlRecord = '<option value="'.$primaryKeyAsString.'">'.$su_title.'</option>';
				$buttonDeleteSuDraft = <<<END_HTML_CONTENT
<input type="button" value="Delete Submittal Draft" onclick="Submittals__deleteSubmittalDraft('manage-submittal_draft-record', 'submittal_drafts', '$primaryKeyAsString', { successCallback: Submittals__deleteSubmittalDraftSuccess });" style="font-size: 10pt;">
END_HTML_CONTENT;

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal Draft.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}

			$arrCustomizedJsonOutput = array('buttonDeleteSuDraft' => $buttonDeleteSuDraft);

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Submittal Draft';
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
			if (isset($submittalDraft) && $submittalDraft instanceof SubmittalDraft) {
				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlRecord|$buttonDeleteSuDraft";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'createSubmittalDraftSR':

		try {
			$crudOperation = 'load';
			$errorNumber = 0;
			$errorMessage = '';
			$primaryKeyAsString = '';
			$htmlContent = '';
			$id=$_POST['id'];
			//To get the project Company Id
			$db = DBI::getInstance($database);
			$query ="SELECT project_id,contracting_entity_id,su_sequence_number,su_cost_code_id,su_creator_contact_id,su_initiator_contact_id,su_title,su_statement,submittal_type_id,submittal_status_id,submittal_priority_id,su_spec_no FROM `submittal_registry` WHERE `id` = '$id'  ";
			$db->execute($query);
			$row=$db->fetch();

			$project_id=$row['project_id'];
			$su_spec_no=$row['su_spec_no'];
			$su_cost_code_id=$row['su_cost_code_id'];
			$su_creator_contact_id=$row['su_creator_contact_id'];
			$su_title=$row['su_title'];
			$su_statement=$row['su_statement'];
			$su_initiator_contact_id=$row['su_initiator_contact_id'];
			$submittal_type_id=$row['submittal_type_id'];
			// $submittal_priority_id=$row['submittal_status_id'];
			$submittal_priority_id=$row['submittal_priority_id'];
			$db->free_result();


			$db = DBI::getInstance($database);

			$query ="INSERT INTO `submittal_drafts` (`project_id`,`su_spec_no`, `su_cost_code_id`,`su_creator_contact_id`,`su_title`,`su_statement`,`su_initiator_contact_id`,`submittal_type_id`,`submittal_priority_id`)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ";
			$arrValues = array($project_id,$su_spec_no, $su_cost_code_id,$su_creator_contact_id,$su_title,$su_statement,$su_initiator_contact_id,$submittal_type_id,$submittal_priority_id);
			$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
			// $row=$db->fetch();

			$submittal_id = $db->insertId;
			$db->free_result();

			// echo json_encode(['id'=>$row['id']]);

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		header('Content-Type: application/json');
		echo json_encode(['id'=>$submittal_id]);
	break;

	case 'loadSubmittalDraft':

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
					'submittal_drafts_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Drafts';
			}

			// Primary key attibutes
			//$submittal_draft_id = (int) $get->uniqueId;
			// Debug
			//$submittal_draft_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal Draft';
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
			if (isset($submittalDraft) && $submittalDraft instanceof SubmittalDraft) {
				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
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

	case 'loadAllSubmittalDraftRecords':

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
					'submittal_drafts_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Drafts';
			}

			// Primary key attibutes
			//$submittal_draft_id = (int) $get->uniqueId;
			// Debug
			//$submittal_draft_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|submittal_drafts|Submittal Draft|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal Draft';
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

	case 'updateSubmittalDraft':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal Draft';
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
					'submittal_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Submittal Draft - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Drafts';
			}

			// Primary key attibutes
			//$submittal_draft_id = (int) $get->uniqueId;
			// Debug
			//$submittal_draft_id = (int) 1;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'submittal_draft_id' => 'submittal draft id',
				'project_id' => 'project id',
				'submittal_type_id' => 'submittal type id',
				'submittal_priority_id' => 'submittal priority id',
				'submittal_distribution_method_id' => 'submittal distribution method id',
				'su_file_manager_file_id' => 'su file manager file id',
				'su_cost_code_id' => 'su cost code id',
				'su_creator_contact_id' => 'su creator contact id',
				'su_creator_contact_company_office_id' => 'su creator contact company office id',
				'su_creator_phone_contact_company_office_phone_number_id' => 'su creator phone contact company office phone number id',
				'su_creator_fax_contact_company_office_phone_number_id' => 'su creator fax contact company office phone number id',
				'su_creator_contact_mobile_phone_number_id' => 'su creator contact mobile phone number id',
				'su_recipient_contact_id' => 'su recipient contact id',
				'su_recipient_contact_company_office_id' => 'su recipient contact company office id',
				'su_recipient_phone_contact_company_office_phone_number_id' => 'su recipient phone contact company office phone number id',
				'su_recipient_fax_contact_company_office_phone_number_id' => 'su recipient fax contact company office phone number id',
				'su_recipient_contact_mobile_phone_number_id' => 'su recipient contact mobile phone number id',
				'su_initiator_contact_id' => 'su initiator contact id',
				'su_initiator_contact_company_office_id' => 'su initiator contact company office id',
				'su_initiator_phone_contact_company_office_phone_number_id' => 'su initiator phone contact company office phone number id',
				'su_initiator_fax_contact_company_office_phone_number_id' => 'su initiator fax contact company office phone number id',
				'su_initiator_contact_mobile_phone_number_id' => 'su initiator contact mobile phone number id',
				'su_title' => 'su title',
				'su_plan_page_reference' => 'su plan page reference',
				'su_statement' => 'su statement',
				'su_due_date' => 'su due date',
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

			if ($attributeSubgroupName == 'submittal_drafts') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$submittal_draft_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalDraft = SubmittalDraft::findById($database, $submittal_draft_id);
				/* @var $submittalDraft SubmittalDraft */

				if ($submittalDraft) {
					// Check if the value actually changed
					$existingValue = $submittalDraft->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$submittalDraft->setData($data);
						// $submittal_draft_id = $submittalDraft->save();
						$submittalDraft->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Draft record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Submittal Draft';
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
			if (isset($submittalDraft) && $submittalDraft instanceof SubmittalDraft) {
				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
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

	case 'updateAllSubmittalDraftAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal Draft';
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
					'submittal_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Submittal Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Drafts';
			}

			// Primary key attibutes
			//$submittal_draft_id = (int) $get->uniqueId;
			// Debug
			//$submittal_draft_id = (int) 1;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_draft_id = (int) $get->submittal_draft_id;
			$project_id = (int) $get->project_id;
			$submittal_type_id = (int) $get->submittal_type_id;
			$submittal_priority_id = (int) $get->submittal_priority_id;
			$submittal_distribution_method_id = (int) $get->submittal_distribution_method_id;
			$su_file_manager_file_id = (int) $get->su_file_manager_file_id;
			$su_cost_code_id = (int) $get->su_cost_code_id;
			$su_creator_contact_id = (int) $get->su_creator_contact_id;
			$su_creator_contact_company_office_id = (int) $get->su_creator_contact_company_office_id;
			$su_creator_phone_contact_company_office_phone_number_id = (int) $get->su_creator_phone_contact_company_office_phone_number_id;
			$su_creator_fax_contact_company_office_phone_number_id = (int) $get->su_creator_fax_contact_company_office_phone_number_id;
			$su_creator_contact_mobile_phone_number_id = (int) $get->su_creator_contact_mobile_phone_number_id;
			$su_recipient_contact_id = (int) $get->su_recipient_contact_id;
			$su_recipient_contact_company_office_id = (int) $get->su_recipient_contact_company_office_id;
			$su_recipient_phone_contact_company_office_phone_number_id = (int) $get->su_recipient_phone_contact_company_office_phone_number_id;
			$su_recipient_fax_contact_company_office_phone_number_id = (int) $get->su_recipient_fax_contact_company_office_phone_number_id;
			$su_recipient_contact_mobile_phone_number_id = (int) $get->su_recipient_contact_mobile_phone_number_id;
			$su_initiator_contact_id = (int) $get->su_initiator_contact_id;
			$su_initiator_contact_company_office_id = (int) $get->su_initiator_contact_company_office_id;
			$su_initiator_phone_contact_company_office_phone_number_id = (int) $get->su_initiator_phone_contact_company_office_phone_number_id;
			$su_initiator_fax_contact_company_office_phone_number_id = (int) $get->su_initiator_fax_contact_company_office_phone_number_id;
			$su_initiator_contact_mobile_phone_number_id = (int) $get->su_initiator_contact_mobile_phone_number_id;
			$su_title = (string) $get->su_title;
			$su_plan_page_reference = (string) $get->su_plan_page_reference;
			$su_statement = (string) $get->su_statement;
			$su_due_date = (string) $get->su_due_date;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);
			$sub_Tags = (string) $post->sub_Tags;
			$arr_sub_tags = explode(',', $sub_Tags);
			$arrtag ='';
			foreach ($arr_sub_tags as $key => $rval) {
				$tagid = Tagging::searchAndInsertTag($database,$rval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');

			if ($attributeSubgroupName == 'submittal_drafts') {
				$submittal_draft_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalDraft = SubmittalDraft::findById($database, $submittal_draft_id);
				/* @var $submittalDraft SubmittalDraft */

				if ($submittalDraft) {
					$existingData = $submittalDraft->getData();

					// Retrieve all of the $_GET inputs automatically for the SubmittalDraft record
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
					$submittalDraft->setData($httpGetInputData);
					$submittalDraft->convertDataToProperties();
					$submittalDraft->convertPropertiesToData();

					$newData = $submittalDraft->getData();
					$data = Data::deltify($existingData, $newData);
          //save To cc and bcc recipients
          SubmittalDraftRecipient::deletRecipients($database, $submittal_draft_id);

         			$to_recipient_contact_ids = (string) $post->su_to_recipient_contact_ids;
					if(!empty($to_recipient_contact_ids)){
						SubmittalDraftRecipient::saveToRecipients($database, $submittal_draft_id, $to_recipient_contact_ids);
					}


					$cc_recipient_contact_ids = (string) $post->su_cc_recipient_contact_ids;
					if(!empty($cc_recipient_contact_ids)){
						SubmittalDraftRecipient::saveCcRecipients($database, $submittal_draft_id, $cc_recipient_contact_ids);
					}

					$bcc_recipient_contact_ids = (string) $post->su_bcc_recipient_contact_ids;
					if(!empty($bcc_recipient_contact_ids)){
						SubmittalDraftRecipient::saveBccRecipients($database, $submittal_draft_id, $bcc_recipient_contact_ids);
					}
					if (!empty($data)) {
						$submittalDraft->setData($data);
						$save = true;
					} else {
						$errorNumber = 2;
						$errorMessage = 'Error updating: Submittal Draft<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$submittalDraft->submittal_draft_id = $submittal_draft_id;
			$submittalDraft->project_id = $project_id;
			$submittalDraft->submittal_type_id = $submittal_type_id;
			$submittalDraft->submittal_priority_id = $submittal_priority_id;
			$submittalDraft->submittal_distribution_method_id = $submittal_distribution_method_id;
			$submittalDraft->su_file_manager_file_id = $su_file_manager_file_id;
			$submittalDraft->su_cost_code_id = $su_cost_code_id;
			$submittalDraft->su_creator_contact_id = $su_creator_contact_id;
			$submittalDraft->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;
			$submittalDraft->su_creator_phone_contact_company_office_phone_number_id = $su_creator_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_creator_fax_contact_company_office_phone_number_id = $su_creator_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_creator_contact_mobile_phone_number_id = $su_creator_contact_mobile_phone_number_id;
			$submittalDraft->su_recipient_contact_id = $su_recipient_contact_id;
			$submittalDraft->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;
			$submittalDraft->su_recipient_phone_contact_company_office_phone_number_id = $su_recipient_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_recipient_fax_contact_company_office_phone_number_id = $su_recipient_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_recipient_contact_mobile_phone_number_id = $su_recipient_contact_mobile_phone_number_id;
			$submittalDraft->su_initiator_contact_id = $su_initiator_contact_id;
			$submittalDraft->su_initiator_contact_company_office_id = $su_initiator_contact_company_office_id;
			$submittalDraft->su_initiator_phone_contact_company_office_phone_number_id = $su_initiator_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_initiator_fax_contact_company_office_phone_number_id = $su_initiator_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_initiator_contact_mobile_phone_number_id = $su_initiator_contact_mobile_phone_number_id;
			$submittalDraft->su_title = $su_title;
			$submittalDraft->su_plan_page_reference = $su_plan_page_reference;
			$submittalDraft->su_statement = $su_statement;
			$submittalDraft->su_due_date = $su_due_date;
					*/

					// $submittal_draft_id = $submittalDraft->save();
					$submittalDraft->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Draft record does not exist.';
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
			//$errorMessage = 'Error updating: Submittal Draft';
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
			if (isset($submittalDraft) && $submittalDraft instanceof SubmittalDraft) {
				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
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

	case 'deleteSubmittalDraft':

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
					'submittal_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Submittal Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Drafts';
			}

			// Primary key attibutes
			//$submittal_draft_id = (int) $get->uniqueId;
			// Debug
			//$submittal_draft_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittal_drafts') {
				$submittal_draft_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittalDraft = SubmittalDraft::findById($database, $submittal_draft_id);
				/* @var $submittalDraft SubmittalDraft */

				if ($submittalDraft) {
					$submittalDraft->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal Draft record does not exist.';
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
			//$errorMessage = 'Error deleting: Submittal Draft';
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
			if (isset($submittalDraft) && $submittalDraft instanceof SubmittalDraft) {
				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
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

	case 'saveSubmittalDraft':

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
					'submittal_drafts_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Submittal Draft data values.';
				$arrErrorMessages = array(
					'Error saving Submittal Draft.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal Draft';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal Drafts';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal_draft-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_draft_id = (int) $get->submittal_draft_id;
			$project_id = (int) $get->project_id;
			$submittal_type_id = (int) $get->submittal_type_id;
			$submittal_priority_id = (int) $get->submittal_priority_id;
			$submittal_distribution_method_id = (int) $get->submittal_distribution_method_id;
			$su_file_manager_file_id = (int) $get->su_file_manager_file_id;
			$su_cost_code_id = (int) $get->su_cost_code_id;
			$su_creator_contact_id = (int) $get->su_creator_contact_id;
			$su_creator_contact_company_office_id = (int) $get->su_creator_contact_company_office_id;
			$su_creator_phone_contact_company_office_phone_number_id = (int) $get->su_creator_phone_contact_company_office_phone_number_id;
			$su_creator_fax_contact_company_office_phone_number_id = (int) $get->su_creator_fax_contact_company_office_phone_number_id;
			$su_creator_contact_mobile_phone_number_id = (int) $get->su_creator_contact_mobile_phone_number_id;
			$su_recipient_contact_id = (int) $get->su_recipient_contact_id;
			$su_recipient_contact_company_office_id = (int) $get->su_recipient_contact_company_office_id;
			$su_recipient_phone_contact_company_office_phone_number_id = (int) $get->su_recipient_phone_contact_company_office_phone_number_id;
			$su_recipient_fax_contact_company_office_phone_number_id = (int) $get->su_recipient_fax_contact_company_office_phone_number_id;
			$su_recipient_contact_mobile_phone_number_id = (int) $get->su_recipient_contact_mobile_phone_number_id;
			$su_initiator_contact_id = (int) $get->su_initiator_contact_id;
			$su_initiator_contact_company_office_id = (int) $get->su_initiator_contact_company_office_id;
			$su_initiator_phone_contact_company_office_phone_number_id = (int) $get->su_initiator_phone_contact_company_office_phone_number_id;
			$su_initiator_fax_contact_company_office_phone_number_id = (int) $get->su_initiator_fax_contact_company_office_phone_number_id;
			$su_initiator_contact_mobile_phone_number_id = (int) $get->su_initiator_contact_mobile_phone_number_id;
			$su_title = (string) $get->su_title;
			$su_plan_page_reference = (string) $get->su_plan_page_reference;
			$su_statement = (string) $get->su_statement;
			$su_due_date = (string) $get->su_due_date;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$submittalDraft = new SubmittalDraft($database);

			// Retrieve all of the $_GET inputs automatically for the SubmittalDraft record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$submittalDraft->setData($httpGetInputData);
			$submittalDraft->convertDataToProperties();

			/*
			$submittalDraft->submittal_draft_id = $submittal_draft_id;
			$submittalDraft->project_id = $project_id;
			$submittalDraft->submittal_type_id = $submittal_type_id;
			$submittalDraft->submittal_priority_id = $submittal_priority_id;
			$submittalDraft->submittal_distribution_method_id = $submittal_distribution_method_id;
			$submittalDraft->su_file_manager_file_id = $su_file_manager_file_id;
			$submittalDraft->su_cost_code_id = $su_cost_code_id;
			$submittalDraft->su_creator_contact_id = $su_creator_contact_id;
			$submittalDraft->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;
			$submittalDraft->su_creator_phone_contact_company_office_phone_number_id = $su_creator_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_creator_fax_contact_company_office_phone_number_id = $su_creator_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_creator_contact_mobile_phone_number_id = $su_creator_contact_mobile_phone_number_id;
			$submittalDraft->su_recipient_contact_id = $su_recipient_contact_id;
			$submittalDraft->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;
			$submittalDraft->su_recipient_phone_contact_company_office_phone_number_id = $su_recipient_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_recipient_fax_contact_company_office_phone_number_id = $su_recipient_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_recipient_contact_mobile_phone_number_id = $su_recipient_contact_mobile_phone_number_id;
			$submittalDraft->su_initiator_contact_id = $su_initiator_contact_id;
			$submittalDraft->su_initiator_contact_company_office_id = $su_initiator_contact_company_office_id;
			$submittalDraft->su_initiator_phone_contact_company_office_phone_number_id = $su_initiator_phone_contact_company_office_phone_number_id;
			$submittalDraft->su_initiator_fax_contact_company_office_phone_number_id = $su_initiator_fax_contact_company_office_phone_number_id;
			$submittalDraft->su_initiator_contact_mobile_phone_number_id = $su_initiator_contact_mobile_phone_number_id;
			$submittalDraft->su_title = $su_title;
			$submittalDraft->su_plan_page_reference = $su_plan_page_reference;
			$submittalDraft->su_statement = $su_statement;
			$submittalDraft->su_due_date = $su_due_date;
			*/

			$submittalDraft->convertPropertiesToData();
			$data = $submittalDraft->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$submittal_draft_id = $submittalDraft->insertOnDuplicateKeyUpdate();
			if (isset($submittal_draft_id) && !empty($submittal_draft_id)) {
				$submittalDraft->submittal_draft_id = $submittal_draft_id;
				$submittalDraft->setId($submittal_draft_id);
			}
			// $submittalDraft->insertOnDuplicateKeyUpdate();
			// $submittalDraft->insertIgnore();

			$submittalDraft->convertDataToProperties();
			$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal Draft.';
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
			//$errorMessage = 'Error creating: Submittal Draft';
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
			if (isset($submittalDraft) && $submittalDraft instanceof SubmittalDraft) {
				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
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

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

require_once('lib/common/Submittal.php');


require_once('lib/common/SubmittalRegistry.php');
require_once('lib/common/Message.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('lib/common/ActionItemType.php');

require_once('lib/common/Api/UsersNotifications.php');

require_once('lib/common/Api/UsersDeviceInfo.php');

require_once('lib/common/Service/TableService.php');

require_once('lib/common/SubmittalRecipient.php');

require_once('lib/common/SubmittalNotification.php');

require_once('modules-submittals-functions.php');

require_once('firebase-push-notification.php');

require_once('lib/common/ActionItemAssignment.php');

require_once('lib/common/ContractingEntities.php');

require_once('lib/common/Tagging.php');


// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('submittals-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewSubmittals = $permissions->determineAccessToSoftwareModuleFunction('submittals_view');
$userCanManageSubmittals = $permissions->determineAccessToSoftwareModuleFunction('submittals_manage');
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
	case 'createSubmittal':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$suTable = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittals_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Submittal data values.';
				$arrErrorMessages = array(
					'Error creating: Submittal.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittals';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_id = (int) $get->submittal_id;
			$project_id = (int) $get->project_id;
			$su_sequence_number = (int) $get->su_sequence_number;
			$submittal_type_id = (int) $get->submittal_type_id;
			$submittal_status_id = (int) $get->submittal_status_id;
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
			$created = (string) $get->created;
			$su_due_date = (string) $get->su_due_date;
			$su_closed_date = (string) $get->su_closed_date;
			*/
			$currentlySelectedProjectId = (int) $post->currentlySelectedProjectId;
			$user_company_id = (int) $post->user_company_id;
			$currentlyActiveContactId = (int) $post->currentlyActiveContactId;
			$primary_contact_id = (int) $post->primary_contact_id;
			$primary_contact_name = (string) $post->primary_contact_name;
			$project_id = (int) $post->project_id;

			$sub_Tags = (string) $post->sub_Tags;
			$arr_sub_tags = explode(',', $sub_Tags);
			$arrtag ='';
			foreach ($arr_sub_tags as $key => $sval) {
				$tagid = Tagging::searchAndInsertTag($database,$sval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the Submittal record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
				if($v =="sub_Tags")
				{	unset($httpGetInputData[$k]); }
			}
			// to include contracting entity
			$entityId = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
			$httpGetInputData['contracting_entity_id']=$entityId;
			$httpGetInputData['tag_ids']=$arrtag;

			$submittal = new Submittal($database);

			$submittal->setData($httpGetInputData);
			$submittal->convertDataToProperties();

			/*
			$submittal->submittal_id = $submittal_id;
			$submittal->project_id = $project_id;
			$submittal->su_sequence_number = $su_sequence_number;
			$submittal->submittal_type_id = $submittal_type_id;
			$submittal->submittal_status_id = $submittal_status_id;
			$submittal->submittal_priority_id = $submittal_priority_id;
			$submittal->submittal_distribution_method_id = $submittal_distribution_method_id;
			$submittal->su_file_manager_file_id = $su_file_manager_file_id;
			$submittal->su_cost_code_id = $su_cost_code_id;
			$submittal->su_creator_contact_id = $su_creator_contact_id;
			$submittal->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;
			$submittal->su_creator_phone_contact_company_office_phone_number_id = $su_creator_phone_contact_company_office_phone_number_id;
			$submittal->su_creator_fax_contact_company_office_phone_number_id = $su_creator_fax_contact_company_office_phone_number_id;
			$submittal->su_creator_contact_mobile_phone_number_id = $su_creator_contact_mobile_phone_number_id;
			$submittal->su_recipient_contact_id = $su_recipient_contact_id;
			$submittal->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;
			$submittal->su_recipient_phone_contact_company_office_phone_number_id = $su_recipient_phone_contact_company_office_phone_number_id;
			$submittal->su_recipient_fax_contact_company_office_phone_number_id = $su_recipient_fax_contact_company_office_phone_number_id;
			$submittal->su_recipient_contact_mobile_phone_number_id = $su_recipient_contact_mobile_phone_number_id;
			$submittal->su_initiator_contact_id = $su_initiator_contact_id;
			$submittal->su_initiator_contact_company_office_id = $su_initiator_contact_company_office_id;
			$submittal->su_initiator_phone_contact_company_office_phone_number_id = $su_initiator_phone_contact_company_office_phone_number_id;
			$submittal->su_initiator_fax_contact_company_office_phone_number_id = $su_initiator_fax_contact_company_office_phone_number_id;
			$submittal->su_initiator_contact_mobile_phone_number_id = $su_initiator_contact_mobile_phone_number_id;
			$submittal->su_title = $su_title;
			$submittal->su_plan_page_reference = $su_plan_page_reference;
			$submittal->su_statement = $su_statement;
			$submittal->created = $created;
			$submittal->su_due_date = $su_due_date;
			$submittal->su_closed_date = $su_closed_date;
			*/

			$submittal->project_id = $project_id;
			$submittal->su_creator_contact_id = $currentlyActiveContactId;

			// Begin total hacks.
			$suCreatorContact = Contact::findContactByIdExtended($database, $currentlyActiveContactId);
			$suCreatorContactCompany = $suCreatorContact->getContactCompany();
			$su_creator_contact_company_id = $suCreatorContactCompany->contact_company_id;
			$arrSuCreatorContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $su_creator_contact_company_id);
			$hqFlagIndex = 0;
			foreach ($arrSuCreatorContactCompanyOffices as $i => $suCreatorContactCompanyOffice) {
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$head_quarters_flag = $suCreatorContactCompanyOffice->head_quarters_flag;
				if ($head_quarters_flag == 'Y') {
					$hqFlagIndex = $i;
					continue;
				}
			}
			$su_creator_contact_company_office_id = $arrSuCreatorContactCompanyOffices[$hqFlagIndex]->contact_company_office_id;
			$submittal->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;

			$su_recipient_contact_id = (int) $post->su_recipient_contact_id;
			$suRecipientContact = Contact::findContactByIdExtended($database, $su_recipient_contact_id);
			if (!$suRecipientContact) {
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal. "To:" field is required.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}
			$suRecipientContactCompany = $suRecipientContact->getContactCompany();
			$su_recipient_contact_company_id = $suRecipientContactCompany->contact_company_id;
			$arrSuRecipientContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $su_recipient_contact_company_id);
			$hqFlagIndex = 0;
			foreach ($arrSuRecipientContactCompanyOffices as $i => $suRecipientContactCompanyOffice) {
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$head_quarters_flag = $suRecipientContactCompanyOffice->head_quarters_flag;
				if ($head_quarters_flag == 'Y') {
					$hqFlagIndex = $i;
					continue;
				}
			}
			$su_recipient_contact_company_office_id = $arrSuRecipientContactCompanyOffices[$hqFlagIndex]->contact_company_office_id;
			$submittal->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;

			// Next su_sequence_number
			//$loadSubmittalsByProjectIdOptions = new Input();
			//$loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
			//$arrSusForCurrentProject = Submittal::loadSubmittalsByProjectId($database, $project_id, $loadSubmittalsByProjectIdOptions);
			//$su_sequence_number = 1 + count($arrSusForCurrentProject);
			$nextSuSequenceNumber = Submittal::findNextSubmittalSequenceNumber($database, $project_id);
			$nextSuSequenceNumber = str_pad($nextSuSequenceNumber, 3, 0, STR_PAD_LEFT);
			$submittal->su_sequence_number = $nextSuSequenceNumber;

			$submittalStatus = SubmittalStatus::findBySubmittalStatus($database, 'Open');
			$submittal_status_id = $submittalStatus->submittal_status_id;
			$submittal->submittal_status_id = $submittal_status_id;
			// End total hacks.

			$submittal->convertPropertiesToData();
			$data = $submittal->getData();

			// Test for existence via standard findByUniqueIndex method
			$submittal->findByUniqueIndex();
			if ($submittal->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Submittal already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$submittal->setKey(null);
				$data['created'] = null;
				$submittal->setData($data);
			}

			$submittal_id = $submittal->save();
			// save notification
			$su_recipient_contact_id = $submittal->su_recipient_contact_id;
			$su_title = $submittal->su_title;
			$contact = Contact::findById($database, $su_recipient_contact_id);
			/* @var $contact Contact */

			$user_notification_user_id = $contact->user_id;
			// get ActionItemType 
			$action_item_type = 'Submittal';
			$actionItemType = ActionItemType::findByActionItemType($database, $action_item_type);
			$action_item_type_id = null;
			if (isset($actionItemType) && !empty($actionItemType)) {
				$action_item_type_id = $actionItemType->action_item_type_id;
			}
			//  Notification
			$userNotification = new UsersNotifications($database);
			$arrNotification = array();
			$arrNotification['user_id'] = $user_notification_user_id;
			$arrNotification['project_id'] = $project_id;
			$arrNotification['user_notification_type_id'] = $action_item_type_id;
			$arrNotification['user_notification_type_reference_id'] = $submittal_id;
			$userNotification->setData($arrNotification);
			$userNotification->convertDataToProperties();
			$user_notification_id = $userNotification->save();
			
			// send Notification
			
			// get the device Token using ids
			$userDeviceInfoFcmToken = UsersDeviceInfo::findByIdUsingUserId($database, $user_notification_user_id);
			if($userDeviceInfoFcmToken != null) {
				$arrFcmToken  = $userDeviceInfoFcmToken;
			}
			if(isset($arrFcmToken) && !empty($arrFcmToken)){
				$user = User::findById($database, $user_notification_user_id);
				$user->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
				$user->currentlyActiveContactId = $su_recipient_contact_id;
				
				/* @var $contact User */
				
				$checkPermissionTaskSummary = checkPermissionTaskSummary($database, $user, $project_id);
				/* check permission to view tasksummary */
				
				/* get action item*/
				$title = $action_item_type;
				// $bodyContent = 'You have new task to visit';
				$bodyContent = $su_title;
				$bodyContent = strlen($bodyContent) > 50 ? substr($bodyContent,0,50). "... Read More" : $bodyContent;
				$options = array();
				$options['task'] = $title;
				$options['project_id'] = $project_id;
				$options['project_name'] = $project_name;
				$options['task_id'] = $submittal_id;
				$options['task_title'] = $su_title;
				$options['navigate'] = $checkPermissionTaskSummary;
				$fcm_notification = send_notification($database, $arrFcmToken, $title, $bodyContent, $options);
			}
			// Another hack.
			$suTable = renderSuListView_AsHtml($database, $project_id, $user_company_id);
			$arrCustomizedJsonOutput = array('suTable' => $suTable);

			if (isset($submittal_id) && !empty($submittal_id)) {
				$submittal->submittal_id = $submittal_id;
				$submittal->setId($submittal_id);
			}
			// $submittal->save();

			$submittal->convertDataToProperties();
			$primaryKeyAsString = $submittal->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal.';
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
			//$errorMessage = 'Error creating: Submittal';
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
			if (isset($submittal) && $submittal instanceof Submittal) {
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
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
	case 'createSubmittalRegistry':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$suTable = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittals_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Submittal data values.';
				$arrErrorMessages = array(
					'Error creating: Submittal.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittals';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal-record';
			}
			$currentlySelectedProjectId = (int) $post->currentlySelectedProjectId;
			$user_company_id = (int) $post->user_company_id;
			$currentlyActiveContactId = (int) $post->currentlyActiveContactId;
			$primary_contact_id = (int) $post->primary_contact_id;
			$primary_contact_name = (string) $post->primary_contact_name;
			$project_id = (int) $post->project_id;
			$submittal_draft_id = (int) $post->submittal_id;

			$sub_Tags = (string) $post->sub_Tags;
			$arr_sub_tags = explode(',', $sub_Tags);
			$arrtag ='';
			foreach ($arr_sub_tags as $key => $sval) {
				$tagid = Tagging::searchAndInsertTag($database,$sval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the Submittal record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
				if($v =="sub_Tags")
				{	unset($httpGetInputData[$k]); }
			}
			// to include contracting entity
			$entityId = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
			$httpGetInputData['contracting_entity_id']=$entityId;
			$httpGetInputData['tag_ids']=$arrtag;


			if($submittal_draft_id){
				$submittal = SubmittalRegistry::findById($database, $submittal_draft_id);
			}else{
				$submittal = new SubmittalRegistry($database);
			}

			$submittal->setData($httpGetInputData);
			$submittal->convertDataToProperties();


			$submittal->project_id = $project_id;
			$submittal->su_creator_contact_id = $currentlyActiveContactId;

			// Begin total hacks.
			$suCreatorContact = Contact::findContactByIdExtended($database, $currentlyActiveContactId);
			$suCreatorContactCompany = $suCreatorContact->getContactCompany();
			$su_creator_contact_company_id = $suCreatorContactCompany->contact_company_id;
			$arrSuCreatorContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $su_creator_contact_company_id);
			$hqFlagIndex = 0;
			foreach ($arrSuCreatorContactCompanyOffices as $i => $suCreatorContactCompanyOffice) {
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$head_quarters_flag = $suCreatorContactCompanyOffice->head_quarters_flag;
				if ($head_quarters_flag == 'Y') {
					$hqFlagIndex = $i;
					continue;
				}
			}
			$su_creator_contact_company_office_id = $arrSuCreatorContactCompanyOffices[$hqFlagIndex]->contact_company_office_id;
			$submittal->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;

			
			$su_recipient_contact_company_office_id = $arrSuRecipientContactCompanyOffices[$hqFlagIndex]->contact_company_office_id;
			$submittal->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;

			
			$nextSuSequenceNumber = SubmittalRegistry::findNextSubmittalSequenceNumber($database, $project_id);
			$nextSuSequenceNumber = str_pad($nextSuSequenceNumber, 3, 0, STR_PAD_LEFT);
			$submittal->su_sequence_number = $nextSuSequenceNumber;

		
			$submittal->convertPropertiesToData();
			$data = $submittal->getData();

			// Test for existence via standard findByUniqueIndex method
			$submittal->findByUniqueIndex();
			if ($submittal->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Submittal Registry already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$submittal->setKey(null);
				$data['created'] = null;
				$submittal->setData($data);
			}
// echo "<pre>"; print_r($submittal);die();
			$submittal_id = $submittal->save();
			// save notification
			$su_recipient_contact_id = $submittal->su_recipient_contact_id;
			$su_title = $submittal->su_title;
			$contact = Contact::findById($database, $su_recipient_contact_id);
			/* @var $contact Contact */

			$user_notification_user_id = $contact->user_id;
			// get ActionItemType 
			$action_item_type = 'Submittal';
			$actionItemType = ActionItemType::findByActionItemType($database, $action_item_type);
			$action_item_type_id = null;
			if (isset($actionItemType) && !empty($actionItemType)) {
				$action_item_type_id = $actionItemType->action_item_type_id;
			}
			
			
			// get the device Token using ids
			$userDeviceInfoFcmToken = UsersDeviceInfo::findByIdUsingUserId($database, $user_notification_user_id);
			if($userDeviceInfoFcmToken != null) {
				$arrFcmToken  = $userDeviceInfoFcmToken;
			}
			if(isset($arrFcmToken) && !empty($arrFcmToken)){
				$user = User::findById($database, $user_notification_user_id);
				$user->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
				$user->currentlyActiveContactId = $su_recipient_contact_id;
				
				/* @var $contact User */
				
				$checkPermissionTaskSummary = checkPermissionTaskSummary($database, $user, $project_id);
				/* check permission to view tasksummary */
				
				/* get action item*/
				$title = $action_item_type;
				// $bodyContent = 'You have new task to visit';
				$bodyContent = $su_title;
				$bodyContent = strlen($bodyContent) > 50 ? substr($bodyContent,0,50). "... Read More" : $bodyContent;
				$options = array();
				$options['task'] = $title;
				$options['project_id'] = $project_id;
				$options['project_name'] = $project_name;
				$options['task_id'] = $submittal_id;
				$options['task_title'] = $su_title;
				$options['navigate'] = $checkPermissionTaskSummary;
				$fcm_notification = send_notification($database, $arrFcmToken, $title, $bodyContent, $options);
			}
			// Another hack.
			$suTable = renderSuListView_AsHtml($database, $project_id, $user_company_id);
			$arrCustomizedJsonOutput = array('suTable' => $suTable);

			if (isset($submittal_id) && !empty($submittal_id)) {
				$submittal->submittal_id = $submittal_id;
				$submittal->setId($submittal_id);
			}
			// $submittal->save();

			$submittal->convertDataToProperties();
			$primaryKeyAsString = $submittal->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal Registry.';
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
			//$errorMessage = 'Error creating: Submittal';
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
			if (isset($submittal) && $submittal instanceof Submittal) {
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
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
	case 'deleteSubmittalsAnswer':
	$subdeleteid = Data::parseInt($post->subdeleteid);
	$db = DBI::getInstance($database);
    $query_res = "Delete  FROM submittal_responses where id = $subdeleteid";
               if( $db->execute($query_res))
               {
     		echo $jsonOutput = json_encode(array('status'=>'success'));
     	}else
     	{
     		echo $jsonOutput = json_encode(array('status'=>'error'));
     	}


	break;
	case 'delete_reciptents':
		$db = DBI::getInstance($database);
		$db->free_result();
		$reciptentid = Data::parseInt($post->reciptent_id);
		$mail_type = $post->mail_type;
		
		
        $query_res = "DELETE FROM `submittal_recipients` WHERE `su_additional_recipient_contact_id` = $reciptentid AND `smtp_recipient_header_type`= '".$mail_type."'";
           
       if( $db->execute($query_res))
       {
     		echo $jsonOutput = json_encode(array('status'=>'success'));
     	}else
     	{
     		echo $jsonOutput = json_encode(array('status'=>'error'));
     	}

     	$db->free_result();

	break;
	case 'loadSubmittal':

		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$notificationId="";

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'submittals_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittals';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;

			// Unique index attibutes
			$project_id = Data::parseInt($post->project_id);
			$su_sequence_number = Data::parseInt($post->su_sequence_number);

			$submittal_id = Data::parseInt($post->submittal_id);
			$primaryKeyAsString = (string) $submittal_id;
			$currentlySelectedProjectId = (int) $post->currentlySelectedProjectId;
			$user_company_id = (int) $post->user_company_id;
			$currentlyActiveContactId = (int) $post->currentlyActiveContactId;
			$primary_contact_id = (int) $post->primary_contact_id;
			$primary_contact_name = (string) $post->primary_contact_name;

		
			$notificationId = TableService::getSingleField($database,'submittal_notifications','id','submittal_id',$submittal_id);
			// To fetch the project name
			$subdata = Submittal::submittalProject($database,$submittal_id);
			$subproject_id = $subdata['project_id'];
			$subproject_name = $subdata['project_name'];
			$sub_company = $subdata['company'];

			$htmlContent = loadSubmittal($database, $user_company_id, $currentlyActiveContactId, $currentlySelectedProjectId, $submittal_id, $subproject_id);

			$arrCustomizedJsonOutput = array(
				'submittal_id' => $submittal_id,
				'notificationId' =>$notificationId,
				'project_name' =>$subproject_name,
				'company' =>$sub_company,
				'htmlContent' => $htmlContent
			);

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal';
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
			if (isset($submittal) && $submittal instanceof Submittal) {
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
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

	case 'loadAllSubmittalRecords':

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
					'submittals_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Submittal.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittals';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$su_sequence_number = (int) $post->su_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|submittals|Submittal|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Submittal';
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

	case 'updateSubmittal':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;
		$newLabel = '';

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal';
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
					'submittals_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Submittal - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittals';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$su_sequence_number = (int) $post->su_sequence_number;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'submittal_id' => 'submittal id',
				'project_id' => 'project id',
				'su_sequence_number' => 'su sequence number',
				'submittal_type_id' => 'submittal type id',
				'submittal_status_id' => 'submittal status id',
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
				'created' => 'created',
				'su_due_date' => 'su due date',
				'su_closed_date' => 'su closed date',
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

			if ($attributeSubgroupName == 'submittals') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$submittal_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittal = Submittal::findById($database, $submittal_id);
				/* @var $submittal Submittal */

				if ($submittal) {
					// Check if the value actually changed
					$existingValue = $submittal->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'project_id' => 1,
						'su_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $submittal->$attributeName;
						$submittal->$attributeName = $newValue;
						$possibleDuplicateSubmittal = Submittal::findByProjectIdAndSuSequenceNumber($database, $submittal->project_id, $submittal->su_sequence_number);
						if ($possibleDuplicateSubmittal) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Submittal $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$submittal->$attributeName = $existingValue;
						}
					}

					if ($save) {

						$data = array($attributeName => $newValue);

						if ($attributeName == 'submittal_status_id') {

							$submittalStatus = SubmittalStatus::findById($database, (int) $newValue);
							$newLabel = $submittalStatus->submittal_status;

							//$submittalStatusOpen = SubmittalStatus::findBySubmittalStatus($database, 'Open');
							//$submittalStatusClosed = SubmittalStatus::findBySubmittalStatus($database, 'Closed');

							// stati of 2 (Approved) or 3(Approved w/ Notes) captures date of approval
							if (($newValue == 2) || ($newValue == 3)) {
								$data['su_closed_date'] = date('Y-m-d');
							} else {
								// Reset the closed date to null for all other stati
								$data['su_closed_date'] = null;
							}

						} elseif ($attributeName == 'submittal_priority_id') {

							$submittalPriority = SubmittalPriority::findById($database, (int) $newValue);
							$newLabel = $submittalPriority->submittal_priority;

						} elseif ($attributeName == 'su_title') {
							$newLabel = $newValue;
						}
						// to update contracting Entity
						$entity_id = ContractingEntities::getcontractEntityAgainstProject($database,$submittal->project_id);
						$data['contracting_entity_id'] = $entity_id;
						$submittal->setData($data);
						// $submittal_id = $submittal->save();
						$submittal->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);

					}

				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
				$arrCustomizedJsonOutput = array('newLabel' => $newLabel);

				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Submittal';
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
			if (isset($submittal) && $submittal instanceof Submittal) {
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
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

	case 'updateSubmittalRegistry':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;
		$newLabel = '';
		$formattedAttributeGroupName = 'Submittal registry';

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal registry';
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
					'submittals_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Submittal registry - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$su_sequence_number = (int) $post->su_sequence_number;
			$submittal_id = (int) $post->submittal_id;

			

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittal = SubmittalRegistry::findById($database, $submittal_id);
				/* @var $submittal Submittal */

				if ($submittal) {					
						
						$data['su_title'] = $post->su_title;
						$data['su_statement'] = $post->su_statement;
						$data['su_spec_no'] = $post->su_spec_no;
						$data['su_cost_code_id'] = $post->su_cost_code_id;
						$submittal->setData($data);
						// echo "<pre>";print_r($submittal);die();
						// $submittal_id = $submittal->save();
						$submittal->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);


				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal registry record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
				}
				$arrCustomizedJsonOutput = array('newLabel' => $newLabel);

				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
			
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Submittal';
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
			if (isset($submittal) && $submittal instanceof SubmittalRegistry) {
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
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

	case 'updateAllSubmittalAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Submittal';
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
					'submittals_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Submittal.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittals';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$su_sequence_number = (int) $post->su_sequence_number;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_id = (int) $get->submittal_id;
			$project_id = (int) $get->project_id;
			$su_sequence_number = (int) $get->su_sequence_number;
			$submittal_type_id = (int) $get->submittal_type_id;
			$submittal_status_id = (int) $get->submittal_status_id;
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
			$created = (string) $get->created;
			$su_due_date = (string) $get->su_due_date;
			$su_closed_date = (string) $get->su_closed_date;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittals') {
				$submittal_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittal = Submittal::findById($database, $submittal_id);
				/* @var $submittal Submittal */

				if ($submittal) {
					$existingData = $submittal->getData();

					// Retrieve all of the $_GET inputs automatically for the Submittal record
					$httpGetInputData = $post->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$submittal->setData($httpGetInputData);
					$submittal->convertDataToProperties();
					$submittal->convertPropertiesToData();

					$newData = $submittal->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$submittal->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Submittal<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$submittal->submittal_id = $submittal_id;
			$submittal->project_id = $project_id;
			$submittal->su_sequence_number = $su_sequence_number;
			$submittal->submittal_type_id = $submittal_type_id;
			$submittal->submittal_status_id = $submittal_status_id;
			$submittal->submittal_priority_id = $submittal_priority_id;
			$submittal->submittal_distribution_method_id = $submittal_distribution_method_id;
			$submittal->su_file_manager_file_id = $su_file_manager_file_id;
			$submittal->su_cost_code_id = $su_cost_code_id;
			$submittal->su_creator_contact_id = $su_creator_contact_id;
			$submittal->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;
			$submittal->su_creator_phone_contact_company_office_phone_number_id = $su_creator_phone_contact_company_office_phone_number_id;
			$submittal->su_creator_fax_contact_company_office_phone_number_id = $su_creator_fax_contact_company_office_phone_number_id;
			$submittal->su_creator_contact_mobile_phone_number_id = $su_creator_contact_mobile_phone_number_id;
			$submittal->su_recipient_contact_id = $su_recipient_contact_id;
			$submittal->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;
			$submittal->su_recipient_phone_contact_company_office_phone_number_id = $su_recipient_phone_contact_company_office_phone_number_id;
			$submittal->su_recipient_fax_contact_company_office_phone_number_id = $su_recipient_fax_contact_company_office_phone_number_id;
			$submittal->su_recipient_contact_mobile_phone_number_id = $su_recipient_contact_mobile_phone_number_id;
			$submittal->su_initiator_contact_id = $su_initiator_contact_id;
			$submittal->su_initiator_contact_company_office_id = $su_initiator_contact_company_office_id;
			$submittal->su_initiator_phone_contact_company_office_phone_number_id = $su_initiator_phone_contact_company_office_phone_number_id;
			$submittal->su_initiator_fax_contact_company_office_phone_number_id = $su_initiator_fax_contact_company_office_phone_number_id;
			$submittal->su_initiator_contact_mobile_phone_number_id = $su_initiator_contact_mobile_phone_number_id;
			$submittal->su_title = $su_title;
			$submittal->su_plan_page_reference = $su_plan_page_reference;
			$submittal->su_statement = $su_statement;
			$submittal->created = $created;
			$submittal->su_due_date = $su_due_date;
			$submittal->su_closed_date = $su_closed_date;
					*/

					// $submittal_id = $submittal->save();
					$submittal->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal record does not exist.';
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
			//$errorMessage = 'Error updating: Submittal';
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
			if (isset($submittal) && $submittal instanceof Submittal) {
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
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

	case 'deleteSubmittal':

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
					'submittals_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Submittal.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittals';
			}

			// Primary key attibutes
			//$submittal_id = (int) $get->uniqueId;
			// Debug
			//$submittal_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$su_sequence_number = (int) $post->su_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'submittals') {
				$submittal_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$submittal = Submittal::findById($database, $submittal_id);
				/* @var $submittal Submittal */

				if ($submittal) {
					$submittal->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Submittal record does not exist.';
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
			//$errorMessage = 'Error deleting: Submittal';
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
			if (isset($submittal) && $submittal instanceof Submittal) {
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
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

	case 'saveSubmittal':

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
					'submittals_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Submittal data values.';
				$arrErrorMessages = array(
					'Error saving Submittal.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittals';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-submittal-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$submittal_id = (int) $get->submittal_id;
			$project_id = (int) $get->project_id;
			$su_sequence_number = (int) $get->su_sequence_number;
			$submittal_type_id = (int) $get->submittal_type_id;
			$submittal_status_id = (int) $get->submittal_status_id;
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
			$created = (string) $get->created;
			$su_due_date = (string) $get->su_due_date;
			$su_closed_date = (string) $get->su_closed_date;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$submittal = new Submittal($database);

			// Retrieve all of the $_GET inputs automatically for the Submittal record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$submittal->setData($httpGetInputData);
			$submittal->convertDataToProperties();

			/*
			$submittal->submittal_id = $submittal_id;
			$submittal->project_id = $project_id;
			$submittal->su_sequence_number = $su_sequence_number;
			$submittal->submittal_type_id = $submittal_type_id;
			$submittal->submittal_status_id = $submittal_status_id;
			$submittal->submittal_priority_id = $submittal_priority_id;
			$submittal->submittal_distribution_method_id = $submittal_distribution_method_id;
			$submittal->su_file_manager_file_id = $su_file_manager_file_id;
			$submittal->su_cost_code_id = $su_cost_code_id;
			$submittal->su_creator_contact_id = $su_creator_contact_id;
			$submittal->su_creator_contact_company_office_id = $su_creator_contact_company_office_id;
			$submittal->su_creator_phone_contact_company_office_phone_number_id = $su_creator_phone_contact_company_office_phone_number_id;
			$submittal->su_creator_fax_contact_company_office_phone_number_id = $su_creator_fax_contact_company_office_phone_number_id;
			$submittal->su_creator_contact_mobile_phone_number_id = $su_creator_contact_mobile_phone_number_id;
			$submittal->su_recipient_contact_id = $su_recipient_contact_id;
			$submittal->su_recipient_contact_company_office_id = $su_recipient_contact_company_office_id;
			$submittal->su_recipient_phone_contact_company_office_phone_number_id = $su_recipient_phone_contact_company_office_phone_number_id;
			$submittal->su_recipient_fax_contact_company_office_phone_number_id = $su_recipient_fax_contact_company_office_phone_number_id;
			$submittal->su_recipient_contact_mobile_phone_number_id = $su_recipient_contact_mobile_phone_number_id;
			$submittal->su_initiator_contact_id = $su_initiator_contact_id;
			$submittal->su_initiator_contact_company_office_id = $su_initiator_contact_company_office_id;
			$submittal->su_initiator_phone_contact_company_office_phone_number_id = $su_initiator_phone_contact_company_office_phone_number_id;
			$submittal->su_initiator_fax_contact_company_office_phone_number_id = $su_initiator_fax_contact_company_office_phone_number_id;
			$submittal->su_initiator_contact_mobile_phone_number_id = $su_initiator_contact_mobile_phone_number_id;
			$submittal->su_title = $su_title;
			$submittal->su_plan_page_reference = $su_plan_page_reference;
			$submittal->su_statement = $su_statement;
			$submittal->created = $created;
			$submittal->su_due_date = $su_due_date;
			$submittal->su_closed_date = $su_closed_date;
			*/

			$submittal->convertPropertiesToData();
			$data = $submittal->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$submittal_id = $submittal->insertOnDuplicateKeyUpdate();
			if (isset($submittal_id) && !empty($submittal_id)) {
				$submittal->submittal_id = $submittal_id;
				$submittal->setId($submittal_id);
			}
			// $submittal->insertOnDuplicateKeyUpdate();
			// $submittal->insertIgnore();

			$submittal->convertDataToProperties();
			$primaryKeyAsString = $submittal->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Submittal.';
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
			//$errorMessage = 'Error creating: Submittal';
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
			if (isset($submittal) && $submittal instanceof Submittal) {
				$primaryKeyAsString = $submittal->getPrimaryKeyAsString();
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
	case 'getClosedDate':
		$SubmittalId = (int) $post->SubmittalId;
		$attributeName =  $post->attributeName;
		$db = DBI::getInstance($database);
		$su_closed_date = TableService::getSingleField($database,'submittals',$attributeName,'id',$SubmittalId);
		if($su_closed_date !="")
		{
			$closeDateUnixTimestamp = strtotime($su_closed_date);
			$formattedSuClosedDate = date("m/d/Y", $closeDateUnixTimestamp);
		}
		echo $formattedSuClosedDate;

	break;

	case 'saveAdditionalRecipient':
	try {

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->free_result();
		$to_reciptentid = Data::parseInt($post->to_id);
		$notification_id = Data::parseInt($post->notification_id);
		$submittal_id =Data::parseInt($post->submittal_id);

		if(empty($notification_id) &&!empty($submittal_id))
		{
			// create notification Id
			$notification_id = SubmittalNotification::InsertNotification($database,$submittal_id);
		}

		
		if(!empty($to_reciptentid) && !empty($notification_id)){
			//$get_notification = "" ;
			//check whether To field is capture in the submittal recipient if not capture the data and return old contact id
			$captureToField = SubmittalRecipient::checkandUpdateSubmittalToField($database,$submittal_id,$notification_id,$currentlyActiveContactId);
			
			if(!empty($captureToField) && $captureToField != $to_reciptentid){
				// Replace the old contact to new contact in meeting
				$updateToFiledInMeeting = ActionItemAssignment::updateAassignments($database,'7',$submittal_id,$captureToField,$to_reciptentid);
			}
			
			// Change in the To Recipient
			$return_stat = TableService::UpdateTabularData($database,'submittals','su_recipient_contact_id', $submittal_id, $to_reciptentid,$currentlyActiveContactId);
			/* Check Recipient Exist - Start */

			$query = "SELECT * FROM submittal_recipients WHERE smtp_recipient_header_type='To' AND su_additional_recipient_contact_id = ? AND submittal_notification_id = ?";

			$arrValues = array($to_reciptentid,$notification_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$exist_other_reciepent = $db->fetch();
			$db->free_result();

			// To get is_to_history last number
			$query = "SELECT * FROM submittal_recipients WHERE smtp_recipient_header_type='To' AND submittal_notification_id = ? ORDER BY `is_to_history` DESC LIMIT 1";
			$arrValues = array($notification_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$last_is_to_history = $db->fetch();
			$db->free_result();

			$is_to_history = $last_is_to_history['is_to_history']+1;

			// To delay the entry of "To" in recipient table for created time
			sleep(3);
			
			if($last_is_to_history['su_additional_recipient_contact_id'] != $to_reciptentid){
				if(!empty($return_stat)){ // Success in updating
					$query = "INSERT INTO `submittal_recipients`(`submittal_notification_id`, `su_additional_recipient_contact_id`,  `smtp_recipient_header_type`,`su_additional_recipient_creator_contact_id`,`is_to_history`) VALUES (?,?,?,?,?)";

					
					$arrValues = array($notification_id, $to_reciptentid,'To',$currentlyActiveContactId, $is_to_history);

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

	case 'fetchtags':
	$queryng_data = $post->query;
	$arr_sear_data = Tagging::searchTagName($database,$queryng_data,$project_id);
	echo json_encode($arr_sear_data);
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

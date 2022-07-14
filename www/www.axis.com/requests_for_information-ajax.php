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

require_once('lib/common/RequestForInformation.php');

require_once('lib/common/Message.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('lib/common/ActionItemType.php');
require_once('lib/common/Tagging.php');

require_once('lib/common/Api/UsersNotifications.php');

require_once('lib/common/Api/UsersDeviceInfo.php');

require_once('lib/common/Service/TableService.php');
require_once('lib/common/ContractingEntities.php');

require_once('modules-requests-for-information-functions.php');

require_once('firebase-push-notification.php');

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('requests_for_information-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewRequestsForInformation = $permissions->determineAccessToSoftwareModuleFunction('requests_for_information_view');
$userCanManageRequestsForInformation = $permissions->determineAccessToSoftwareModuleFunction('requests_for_information_manage');
*/

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$primary_contact_id = $session->getPrimaryContactId();
$primary_contact_name = $session->getLoginName();
$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'createRequestForInformation':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$rfiTable = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');
			require('code-generator/ajax-post-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'requests_for_information_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Request For Information data values.';
				$arrErrorMessages = array(
					'Error creating: Request For Information.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Requests For Information';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_id = (int) $get->request_for_information_id;
			$project_id = (int) $get->project_id;
			$rfi_sequence_number = (int) $get->rfi_sequence_number;
			$request_for_information_type_id = (int) $get->request_for_information_type_id;
			$request_for_information_status_id = (int) $get->request_for_information_status_id;
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
			$created = (string) $get->created;
			$rfi_due_date = (string) $get->rfi_due_date;
			$rfi_closed_date = (string) $get->rfi_closed_date;
			*/
			$currentlySelectedProjectId = (int) $post->currentlySelectedProjectId;
			$user_company_id = (int) $post->user_company_id;
			$currentlyActiveContactId = (int) $post->currentlyActiveContactId;
			$primary_contact_id = (int) $post->primary_contact_id;
			$primary_contact_name = (string) $post->primary_contact_name;

			$project_id = (int) $post->project_id;
			
			$rfi_Tags = (string) $post->rfi_Tags;
			$arr_rfi_tags = explode(',', $rfi_Tags);
			$arrtag ='';
			foreach ($arr_rfi_tags as $key => $rval) {
				$tagid = Tagging::searchAndInsertTag($database,$rval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformation record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
				if($v =="rfi_Tags")
				{	unset($httpGetInputData[$k]); }
			}
			// to include contracting entity
			$entityId = ContractingEntities::getcontractEntityAgainstProject($database,$project_id);
			$httpGetInputData['contracting_entity_id']=$entityId;
			$httpGetInputData['tag_ids']=$arrtag;

			$requestForInformation = new RequestForInformation($database);

			$requestForInformation->setData($httpGetInputData);
			$requestForInformation->convertDataToProperties();

			/*
			$requestForInformation->request_for_information_id = $request_for_information_id;
			$requestForInformation->project_id = $project_id;
			$requestForInformation->rfi_sequence_number = $rfi_sequence_number;
			$requestForInformation->request_for_information_type_id = $request_for_information_type_id;
			$requestForInformation->request_for_information_status_id = $request_for_information_status_id;
			$requestForInformation->request_for_information_priority_id = $request_for_information_priority_id;
			$requestForInformation->rfi_file_manager_file_id = $rfi_file_manager_file_id;
			$requestForInformation->rfi_cost_code_id = $rfi_cost_code_id;
			$requestForInformation->rfi_creator_contact_id = $rfi_creator_contact_id;
			$requestForInformation->rfi_creator_contact_company_office_id = $rfi_creator_contact_company_office_id;
			$requestForInformation->rfi_creator_phone_contact_company_office_phone_number_id = $rfi_creator_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_creator_fax_contact_company_office_phone_number_id = $rfi_creator_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_creator_contact_mobile_phone_number_id = $rfi_creator_contact_mobile_phone_number_id;
			$requestForInformation->rfi_recipient_contact_id = $rfi_recipient_contact_id;
			$requestForInformation->rfi_recipient_contact_company_office_id = $rfi_recipient_contact_company_office_id;
			$requestForInformation->rfi_recipient_phone_contact_company_office_phone_number_id = $rfi_recipient_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_recipient_fax_contact_company_office_phone_number_id = $rfi_recipient_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_recipient_contact_mobile_phone_number_id = $rfi_recipient_contact_mobile_phone_number_id;
			$requestForInformation->rfi_initiator_contact_id = $rfi_initiator_contact_id;
			$requestForInformation->rfi_initiator_contact_company_office_id = $rfi_initiator_contact_company_office_id;
			$requestForInformation->rfi_initiator_phone_contact_company_office_phone_number_id = $rfi_initiator_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_initiator_fax_contact_company_office_phone_number_id = $rfi_initiator_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_initiator_contact_mobile_phone_number_id = $rfi_initiator_contact_mobile_phone_number_id;
			$requestForInformation->rfi_title = $rfi_title;
			$requestForInformation->rfi_plan_page_reference = $rfi_plan_page_reference;
			$requestForInformation->rfi_statement = $rfi_statement;
			$requestForInformation->created = $created;
			$requestForInformation->rfi_due_date = $rfi_due_date;
			$requestForInformation->rfi_closed_date = $rfi_closed_date;
			*/

			$requestForInformation->project_id = $project_id;
			$requestForInformation->rfi_creator_contact_id = $currentlyActiveContactId;

			// Begin total hacks.
			$rfiCreatorContact = Contact::findContactByIdExtended($database, $currentlyActiveContactId);
			$rfiCreatorContactCompany = $rfiCreatorContact->getContactCompany();
			$rfi_creator_contact_company_id = $rfiCreatorContactCompany->contact_company_id;
			$arrRfiCreatorContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $rfi_creator_contact_company_id);
			$hqFlagIndex = 0;
			foreach ($arrRfiCreatorContactCompanyOffices as $i => $rfiCreatorContactCompanyOffice) {
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$head_quarters_flag = $rfiCreatorContactCompanyOffice->head_quarters_flag;
				if ($head_quarters_flag == 'Y') {
					$hqFlagIndex = $i;
					continue;
				}
			}
			$rfi_creator_contact_company_office_id = $arrRfiCreatorContactCompanyOffices[$hqFlagIndex]->contact_company_office_id;
			$requestForInformation->rfi_creator_contact_company_office_id = $rfi_creator_contact_company_office_id;

			$rfi_recipient_contact_id = (int) $post->rfi_recipient_contact_id;
			$rfiRecipientContact = Contact::findContactByIdExtended($database, $rfi_recipient_contact_id);
			if (!$rfiRecipientContact) {
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information. "To:" field is required.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}
			$rfiRecipientContactCompany = $rfiRecipientContact->getContactCompany();
			$rfi_recipient_contact_company_id = $rfiRecipientContactCompany->contact_company_id;
			$arrRfiRecipientContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $rfi_recipient_contact_company_id);
			$hqFlagIndex = 0;
			foreach ($arrRfiRecipientContactCompanyOffices as $i => $rfiRecipientContactCompanyOffice) {
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$head_quarters_flag = $rfiRecipientContactCompanyOffice->head_quarters_flag;
				if ($head_quarters_flag == 'Y') {
					$hqFlagIndex = $i;
					continue;
				}
			}
			$rfi_recipient_contact_company_office_id = $arrRfiRecipientContactCompanyOffices[$hqFlagIndex]->contact_company_office_id;
			$requestForInformation->rfi_recipient_contact_company_office_id = $rfi_recipient_contact_company_office_id;

			// Next rfi_sequence_number
			//$loadRequestsForInformationByProjectIdOptions = new Input();
			//$loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
			//$arrRfisForCurrentProject = RequestForInformation::loadRequestsForInformationByProjectId($database, $project_id, $loadRequestsForInformationByProjectIdOptions);
			//$rfi_sequence_number = 1 + count($arrRfisForCurrentProject);
			$nextRfiSequenceNumber = RequestForInformation::findNextRFISequenceNumber($database, $project_id);
			$nextRfiSequenceNumber = str_pad($nextRfiSequenceNumber, 3, 0, STR_PAD_LEFT);
			$requestForInformation->rfi_sequence_number = $nextRfiSequenceNumber;

			$requestForInformationStatus = RequestForInformationStatus::findByRequestForInformationStatus($database, 'Open');
			$request_for_information_status_id = $requestForInformationStatus->request_for_information_status_id;
			$requestForInformation->request_for_information_status_id = $request_for_information_status_id;
			// End total hacks.

			$requestForInformation->convertPropertiesToData();
			$data = $requestForInformation->getData();

			// Test for existence via standard findByUniqueIndex method
			$requestForInformation->findByUniqueIndex();
			if ($requestForInformation->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Request For Information already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$requestForInformation->setKey(null);
				$data['created'] = null;
				$requestForInformation->setData($data);
			}

			$request_for_information_id = $requestForInformation->save();
			// save notification
			$rfi_recipient_contact_id = $requestForInformation->rfi_recipient_contact_id;
			$rfi_title = $requestForInformation->rfi_title;
			$contact = Contact::findById($database, $rfi_recipient_contact_id);
			/* @var $contact Contact */

			$user_notification_user_id = $contact->user_id;
			// get ActionItemType 
			$action_item_type = 'RFI';
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
			$arrNotification['user_notification_type_reference_id'] = $request_for_information_id;
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
				$user->currentlyActiveContactId = $rfi_recipient_contact_id;
				
				/* @var $contact User */
				
				$checkPermissionTaskSummary = checkPermissionTaskSummary($database, $user, $project_id);
				/* check permission to view tasksummary */
				
				/* get action item*/
				$title = $action_item_type;
				$bodyContent = 'You have new task to visit';
				$bodyContent = $rfi_title;
				$bodyContent = strlen($bodyContent) > 50 ? substr($bodyContent,0,50). "... Read More" : $bodyContent;
				$options = array();
				$options['task'] = $title;
				$options['project_id'] = $project_id;
				$options['project_name'] = $project_name;
				$options['task_id'] = $request_for_information_id;
				$options['task_title'] = $rfi_title;
				$options['navigate'] = $checkPermissionTaskSummary;
				$fcm_notification = send_notification($database, $arrFcmToken, $title, $bodyContent, $options);
			}
			// Another hack.
			$rfiTable = renderRfiListView_AsHtml($database, $project_id);
			$arrCustomizedJsonOutput = array('rfiTable' => $rfiTable);

			if (isset($request_for_information_id) && !empty($request_for_information_id)) {
				$requestForInformation->request_for_information_id = $request_for_information_id;
				$requestForInformation->setId($request_for_information_id);
			}
			// $requestForInformation->save();

			$requestForInformation->convertDataToProperties();
			$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information.';
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
			//$errorMessage = 'Error creating: Request For Information';
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
			if (isset($requestForInformation) && $requestForInformation instanceof RequestForInformation) {
				$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
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

	case 'loadRequestForInformation':

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
					'requests_for_information_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Requests For Information';
			}

			// Unique index attibutes
			$project_id = Data::parseInt($post->project_id);
			$rfi_sequence_number = Data::parseInt($post->rfi_sequence_number);

			$request_for_information_id = Data::parseInt($post->request_for_information_id);
			$primaryKeyAsString = (string) $request_for_information_id;
			$currentlySelectedProjectId = (int) $post->currentlySelectedProjectId;
			$user_company_id = (int) $post->user_company_id;
			$currentlyActiveContactId = (int) $post->currentlyActiveContactId;
			$primary_contact_id = (int) $post->primary_contact_id;
			$primary_contact_name = (string) $post->primary_contact_name;

			$notificationId = TableService::getSingleField($database,'request_for_information_notifications','id','request_for_information_id',$request_for_information_id);

			// To fetch the project name
			$RFIdata = RequestForInformation::RequestForInformationProject($database,$request_for_information_id);
			$RFIproject_id = $RFIdata['project_id'];
			$RFIproject_name = $RFIdata['project_name'];
			$RFI_company = $RFIdata['company'];

			$htmlContent = loadRequestForInformation($database, $user_company_id, $currentlyActiveContactId, $currentlySelectedProjectId, $request_for_information_id, $primary_contact_id, $primary_contact_name, $RFIproject_id);


			$arrCustomizedJsonOutput = array(
				'request_for_information_id' => $request_for_information_id,
				'notificationId' =>$notificationId,
				'project_name' =>$RFIproject_name,
				'company' =>$RFI_company,
				'htmlContent' => $htmlContent
			);

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($requestForInformation) && $requestForInformation instanceof RequestForInformation) {
				$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
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
	case 'deleteRFIAnswer':
	$RFIdeleteid = Data::parseInt($post->RFIdeleteid);
	$db = DBI::getInstance($database);
    $query_res = "Delete  FROM request_for_information_responses where id = $RFIdeleteid";
               if( $db->execute($query_res))
               {
     		echo $jsonOutput = json_encode(array('status'=>'success'));
     	}else
     	{
     		echo $jsonOutput = json_encode(array('status'=>'error'));
     	}


	break;

	case 'loadAllRequestForInformationRecords':

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
					'requests_for_information_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Request For Information.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Requests For Information';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$rfi_sequence_number = (int) $post->rfi_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|requests_for_information|Request For Information|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Request For Information';
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

	case 'updateRequestForInformation':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;
		$newLabel = '';

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information';
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
					'requests_for_information_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Request For Information - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Requests For Information';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $post->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$rfi_sequence_number = (int) $post->rfi_sequence_number;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'request_for_information_id' => 'request for information id',
				'project_id' => 'project id',
				'rfi_sequence_number' => 'rfi sequence number',
				'request_for_information_type_id' => 'request for information type id',
				'request_for_information_status_id' => 'request for information status id',
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
				'created' => 'created',
				'rfi_due_date' => 'rfi due date',
				'rfi_closed_date' => 'rfi closed date',
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

			if ($attributeSubgroupName == 'requests_for_information') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$request_for_information_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformation = RequestForInformation::findById($database, $request_for_information_id);
				/* @var $requestForInformation RequestForInformation */

				if ($requestForInformation) {
					// Check if the value actually changed
					$existingValue = $requestForInformation->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'project_id' => 1,
						'rfi_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $requestForInformation->$attributeName;
						$requestForInformation->$attributeName = $newValue;
						$possibleDuplicateRequestForInformation = RequestForInformation::findByProjectIdAndRfiSequenceNumber($database, $requestForInformation->project_id, $requestForInformation->rfi_sequence_number);
						if ($possibleDuplicateRequestForInformation) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Request For Information $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$requestForInformation->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						if ($attributeName == 'request_for_information_status_id') {
							$requestForInformationStatus = RequestForInformationStatus::findById($database, (int) $newValue);
							$newLabel = $requestForInformationStatus->request_for_information_status;

							$requestForInformationStatusOpen = RequestForInformationStatus::findByRequestForInformationStatus($database, 'Open');
							$requestForInformationStatusClosed = RequestForInformationStatus::findByRequestForInformationStatus($database, 'Closed');

							if ($newValue == $requestForInformationStatusClosed->request_for_information_status_id) {
								$data['rfi_closed_date'] = date('Y-m-d');
								$requestForInformationStatusClosed = RequestForInformationStatus::insertClosedDate($database,$request_for_information_id,$data['rfi_closed_date'],'closed' );

							} elseif ($newValue == $requestForInformationStatusOpen->request_for_information_status_id) {
								$data['rfi_closed_date'] = null;
								$openDate  = date('Y-m-d');
								$requestForInformationStatusClosed = RequestForInformationStatus::insertClosedDate($database,$request_for_information_id,$openDate,'open' );

							}
						} elseif ($attributeName == 'request_for_information_priority_id') {
							$requestForInformationPriority = RequestForInformationPriority::findById($database, (int) $newValue);
							$newLabel = $requestForInformationPriority->request_for_information_priority;
						}
						$requestForInformation->setData($data);
						// $request_for_information_id = $requestForInformation->save();
						$requestForInformation->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
				if (!isset($newLabel) || empty($newLabel)) {
					$newLabel = $newValue;
				}
				$arrCustomizedJsonOutput = array('newLabel' => $newLabel);

				$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Request For Information';
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
			if (isset($requestForInformation) && $requestForInformation instanceof RequestForInformation) {
				$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
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

	case 'updateAllRequestForInformationAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Request For Information';
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
					'requests_for_information_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Request For Information.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Requests For Information';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $post->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$rfi_sequence_number = (int) $post->rfi_sequence_number;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_id = (int) $get->request_for_information_id;
			$project_id = (int) $get->project_id;
			$rfi_sequence_number = (int) $get->rfi_sequence_number;
			$request_for_information_type_id = (int) $get->request_for_information_type_id;
			$request_for_information_status_id = (int) $get->request_for_information_status_id;
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
			$created = (string) $get->created;
			$rfi_due_date = (string) $get->rfi_due_date;
			$rfi_closed_date = (string) $get->rfi_closed_date;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'requests_for_information') {
				$request_for_information_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformation = RequestForInformation::findById($database, $request_for_information_id);
				/* @var $requestForInformation RequestForInformation */

				if ($requestForInformation) {
					$existingData = $requestForInformation->getData();

					// Retrieve all of the $_GET inputs automatically for the RequestForInformation record
					$httpGetInputData = $post->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$requestForInformation->setData($httpGetInputData);
					$requestForInformation->convertDataToProperties();
					$requestForInformation->convertPropertiesToData();

					$newData = $requestForInformation->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$requestForInformation->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Request For Information<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$requestForInformation->request_for_information_id = $request_for_information_id;
			$requestForInformation->project_id = $project_id;
			$requestForInformation->rfi_sequence_number = $rfi_sequence_number;
			$requestForInformation->request_for_information_type_id = $request_for_information_type_id;
			$requestForInformation->request_for_information_status_id = $request_for_information_status_id;
			$requestForInformation->request_for_information_priority_id = $request_for_information_priority_id;
			$requestForInformation->rfi_file_manager_file_id = $rfi_file_manager_file_id;
			$requestForInformation->rfi_cost_code_id = $rfi_cost_code_id;
			$requestForInformation->rfi_creator_contact_id = $rfi_creator_contact_id;
			$requestForInformation->rfi_creator_contact_company_office_id = $rfi_creator_contact_company_office_id;
			$requestForInformation->rfi_creator_phone_contact_company_office_phone_number_id = $rfi_creator_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_creator_fax_contact_company_office_phone_number_id = $rfi_creator_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_creator_contact_mobile_phone_number_id = $rfi_creator_contact_mobile_phone_number_id;
			$requestForInformation->rfi_recipient_contact_id = $rfi_recipient_contact_id;
			$requestForInformation->rfi_recipient_contact_company_office_id = $rfi_recipient_contact_company_office_id;
			$requestForInformation->rfi_recipient_phone_contact_company_office_phone_number_id = $rfi_recipient_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_recipient_fax_contact_company_office_phone_number_id = $rfi_recipient_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_recipient_contact_mobile_phone_number_id = $rfi_recipient_contact_mobile_phone_number_id;
			$requestForInformation->rfi_initiator_contact_id = $rfi_initiator_contact_id;
			$requestForInformation->rfi_initiator_contact_company_office_id = $rfi_initiator_contact_company_office_id;
			$requestForInformation->rfi_initiator_phone_contact_company_office_phone_number_id = $rfi_initiator_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_initiator_fax_contact_company_office_phone_number_id = $rfi_initiator_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_initiator_contact_mobile_phone_number_id = $rfi_initiator_contact_mobile_phone_number_id;
			$requestForInformation->rfi_title = $rfi_title;
			$requestForInformation->rfi_plan_page_reference = $rfi_plan_page_reference;
			$requestForInformation->rfi_statement = $rfi_statement;
			$requestForInformation->created = $created;
			$requestForInformation->rfi_due_date = $rfi_due_date;
			$requestForInformation->rfi_closed_date = $rfi_closed_date;
					*/

					// $request_for_information_id = $requestForInformation->save();
					$requestForInformation->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information record does not exist.';
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
			//$errorMessage = 'Error updating: Request For Information';
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
			if (isset($requestForInformation) && $requestForInformation instanceof RequestForInformation) {
				$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
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

	case 'deleteRequestForInformation':

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
					'requests_for_information_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Request For Information.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Requests For Information';
			}

			// Primary key attibutes
			//$request_for_information_id = (int) $get->uniqueId;
			// Debug
			//$request_for_information_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $post->project_id;
			$rfi_sequence_number = (int) $post->rfi_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'requests_for_information') {
				$request_for_information_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$requestForInformation = RequestForInformation::findById($database, $request_for_information_id);
				/* @var $requestForInformation RequestForInformation */

				if ($requestForInformation) {
					$requestForInformation->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Request For Information record does not exist.';
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
			//$errorMessage = 'Error deleting: Request For Information';
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
			if (isset($requestForInformation) && $requestForInformation instanceof RequestForInformation) {
				$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
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

	case 'saveRequestForInformation':

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
					'requests_for_information_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Request For Information data values.';
				$arrErrorMessages = array(
					'Error saving Request For Information.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Request For Information';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Requests For Information';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-request_for_information-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$request_for_information_id = (int) $get->request_for_information_id;
			$project_id = (int) $get->project_id;
			$rfi_sequence_number = (int) $get->rfi_sequence_number;
			$request_for_information_type_id = (int) $get->request_for_information_type_id;
			$request_for_information_status_id = (int) $get->request_for_information_status_id;
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
			$created = (string) $get->created;
			$rfi_due_date = (string) $get->rfi_due_date;
			$rfi_closed_date = (string) $get->rfi_closed_date;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$requestForInformation = new RequestForInformation($database);

			// Retrieve all of the $_GET inputs automatically for the RequestForInformation record
			$httpGetInputData = $post->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$requestForInformation->setData($httpGetInputData);
			$requestForInformation->convertDataToProperties();

			/*
			$requestForInformation->request_for_information_id = $request_for_information_id;
			$requestForInformation->project_id = $project_id;
			$requestForInformation->rfi_sequence_number = $rfi_sequence_number;
			$requestForInformation->request_for_information_type_id = $request_for_information_type_id;
			$requestForInformation->request_for_information_status_id = $request_for_information_status_id;
			$requestForInformation->request_for_information_priority_id = $request_for_information_priority_id;
			$requestForInformation->rfi_file_manager_file_id = $rfi_file_manager_file_id;
			$requestForInformation->rfi_cost_code_id = $rfi_cost_code_id;
			$requestForInformation->rfi_creator_contact_id = $rfi_creator_contact_id;
			$requestForInformation->rfi_creator_contact_company_office_id = $rfi_creator_contact_company_office_id;
			$requestForInformation->rfi_creator_phone_contact_company_office_phone_number_id = $rfi_creator_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_creator_fax_contact_company_office_phone_number_id = $rfi_creator_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_creator_contact_mobile_phone_number_id = $rfi_creator_contact_mobile_phone_number_id;
			$requestForInformation->rfi_recipient_contact_id = $rfi_recipient_contact_id;
			$requestForInformation->rfi_recipient_contact_company_office_id = $rfi_recipient_contact_company_office_id;
			$requestForInformation->rfi_recipient_phone_contact_company_office_phone_number_id = $rfi_recipient_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_recipient_fax_contact_company_office_phone_number_id = $rfi_recipient_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_recipient_contact_mobile_phone_number_id = $rfi_recipient_contact_mobile_phone_number_id;
			$requestForInformation->rfi_initiator_contact_id = $rfi_initiator_contact_id;
			$requestForInformation->rfi_initiator_contact_company_office_id = $rfi_initiator_contact_company_office_id;
			$requestForInformation->rfi_initiator_phone_contact_company_office_phone_number_id = $rfi_initiator_phone_contact_company_office_phone_number_id;
			$requestForInformation->rfi_initiator_fax_contact_company_office_phone_number_id = $rfi_initiator_fax_contact_company_office_phone_number_id;
			$requestForInformation->rfi_initiator_contact_mobile_phone_number_id = $rfi_initiator_contact_mobile_phone_number_id;
			$requestForInformation->rfi_title = $rfi_title;
			$requestForInformation->rfi_plan_page_reference = $rfi_plan_page_reference;
			$requestForInformation->rfi_statement = $rfi_statement;
			$requestForInformation->created = $created;
			$requestForInformation->rfi_due_date = $rfi_due_date;
			$requestForInformation->rfi_closed_date = $rfi_closed_date;
			*/

			$requestForInformation->convertPropertiesToData();
			$data = $requestForInformation->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$request_for_information_id = $requestForInformation->insertOnDuplicateKeyUpdate();
			if (isset($request_for_information_id) && !empty($request_for_information_id)) {
				$requestForInformation->request_for_information_id = $request_for_information_id;
				$requestForInformation->setId($request_for_information_id);
			}
			// $requestForInformation->insertOnDuplicateKeyUpdate();
			// $requestForInformation->insertIgnore();

			$requestForInformation->convertDataToProperties();
			$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Request For Information.';
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
			//$errorMessage = 'Error creating: Request For Information';
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
			if (isset($requestForInformation) && $requestForInformation instanceof RequestForInformation) {
				$primaryKeyAsString = $requestForInformation->getPrimaryKeyAsString();
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

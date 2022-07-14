<?php
/*Meeting service*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
header('Accept: *');
/*
	METHOD POST OR GET
	Variables Params
	$RN_token
*/
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/ActionItem.php');
require_once('lib/common/ActionItemAssignment.php');
require_once('lib/common/ActionItemPriority.php');
require_once('lib/common/ActionItemStatus.php');
require_once('lib/common/ActionItemType.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/Data.php');
require_once('lib/common/DiscussionItem.php');
require_once('lib/common/DiscussionItemComment.php');
require_once('lib/common/DiscussionItemPriority.php');
require_once('lib/common/DiscussionItemRelationship.php');
require_once('lib/common/DiscussionItemStatus.php');
require_once('lib/common/DiscussionItemToActionItem.php');
require_once('lib/common/DiscussionItemToDiscussionItemComment.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/Log.php');
require_once('lib/common/Meeting.php');
require_once('lib/common/MeetingAttendee.php');
require_once('lib/common/MeetingLocation.php');
require_once('lib/common/MeetingLocationTemplate.php');
require_once('lib/common/MeetingType.php');
require_once('lib/common/MeetingTypeTemplate.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/ProjectToWeatherUndergroundReportingStation.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/RequestForInformation.php');
require_once('lib/common/RequestForInformationAttachment.php');
require_once('lib/common/RequestForInformationNotification.php');
require_once('lib/common/RequestForInformationPriority.php');
require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/RequestForInformationResponse.php');
require_once('lib/common/RequestForInformationResponseType.php');
require_once('lib/common/RequestForInformationStatus.php');
require_once('lib/common/RequestForInformationType.php');
require_once('lib/common/Submittal.php');

require_once('lib/common/Api/UsersNotifications.php');
require_once('lib/common/Api/UsersDeviceInfo.php');
require_once('../firebase-push-notification.php');

$_SERVER['REQUEST_METHOD'];
/*Validate the requeset method*/
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$RN_params = $_GET;
}else{
	$RN_params = $_POST;	
}
/*get the request values*/
if(isset($RN_params['token'])) {
	$RN_token = $RN_params['token'];
}
$RN_view = $RN_params['view'];
$RN_project_id = $RN_params['project_id'];
$RN_view = 'MeetingData';
$RN_page = 1;
$RN_meeting_type_id = null;
$RN_meeting_id = null;
$RN_flagUpdate = false;
if(isset($RN_params['meeting_type_id']) && $RN_params['meeting_type_id']!=null){
	$RN_meeting_type_id = $RN_params['meeting_type_id'];
}
if(isset($RN_params['meeting_id']) && $RN_params['meeting_id']!=null){
	$RN_meeting_id = $RN_params['meeting_id'];
}
if(isset($RN_params['view']) && $RN_params['view']!=null){
	$RN_view = $RN_params['view'];
}
if(isset($RN_params['flag_update']) && $RN_params['flag_update']!=null){
	$RN_flagUpdate =  filter_var($RN_params['flag_update'], FILTER_VALIDATE_BOOLEAN);
}
$RN_per_page = 20;
if(isset($RN_params['per_page']) && $RN_params['per_page']!=null){
	$RN_per_page = $RN_params['per_page'];
}
$RN_page = 1;
if(isset($RN_params['page']) && $RN_params['page']!=null){
	$RN_page = $RN_params['page'];
}

$RN_meetingTypeId = null;
if(isset($RN_params['meeting_type_id']) && $RN_params['meeting_type_id']!=null){
	$RN_meetingTypeId = $RN_params['meeting_type_id'];
}

$RN_filterValue = null;
if(isset($RN_params['filter_value']) && $RN_params['filter_value']!=null){
	$RN_filterValue = $RN_params['filter_value'];
}

$RN_filterType = null;
if(isset($RN_params['filter_type']) && $RN_params['filter_type']!=null){
	$RN_filterType = $RN_params['filter_type'];
}
/* varirable json encode*/
$RN_jsonEC = array();

/*response index value init*/
$RN_jsonEC['status'] = 400;
$RN_jsonEC['token'] = null;
$RN_jsonEC['message'] = null;
$RN_jsonEC['err_message'] = null;
$RN_jsonEC['data'] = null;

/*Validate the current user access is valid or not*/
include_once('./Auth/AuthAccess.php');


if($RN_project_id == null || $RN_project_id == ''){
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Project Id is Required";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}

$RN_user_company_id = $user->user_company_id;
$RN_user_id = $user->user_id;
$RN_userRole = $user->getUserRole();
// $RN_project_id = $user->currentlySelectedProjectId;
$RN_primary_contact_id = $user->primary_contact_id;
$RN_currentlyActiveContactId = $user->currentlyActiveContactId;
$RN_currentlySelectedProjectName = $user->currentlySelectedProjectName;
$RN_currentlySelectedProjectUserCompanyId = $user->currentlySelectedProjectUserCompanyId;
/* @var $project Project */
$project = Project::findById($database, $RN_project_id);
$RN_encodedProjectName = Data::entity_encode($project->project_name);
$RN_project_name = $RN_encodedProjectName;
/*
	Fetch the data from Meeting folder file.
	filename-v1.php files wrote for meeting page rescratch api 
	it's have different response data formats
*/
/*get the details of view*/
switch($RN_view){
	case "MeetingData":
	/*get the Meeting details */
	include_once('./Meetings/MeetingData.php');
	break;
	case "DiscussionItem":
	/*get the Meeting Discussion details */
	include_once('./Meetings/DiscussionData.php');
	break;
	case "UpdateDiscussionItem":
	/*get the Meeting Discussion item update*/
	include_once('./Meetings/UpdateDiscussionData.php');
	break;
	case "DownloadPDF":
	/*get the Meeting PDF without store in filemanager*/
	include_once('./Meetings/DownloadPDF.php');
	// phase 2
	break;
	case "MeetingData-v1":
	/*get the Meeting details */
	include_once('./Meetings/MeetingData-v1.php');
	break;
	case "MeetingCreateList-v1":
	/*get the Meeting create details */
	include_once('./Meetings/MeetingCreateList-v1.php');
	break;
	case "CreateMeeting-v1":
	/*get the Meeting create details */
	include_once('./Meetings/CreateMeeting-v1.php');
	break;
	case "EditMeeting-v1":
	/*get the Meeting create details */
	include_once('./Meetings/EditMeeting-v1.php');
	break;
	case "DeleteMeeting-v1":
	/*get the Meeting create details */
	include_once('./Meetings/DeleteMeeting-v1.php');
	break;
	case "MeetingDiscussionData-v1":
	/*get the Meeting create details */
	include_once('./Meetings/MeetingDiscussionData-v1.php');
	break;
	case "MeetingDiscussionItem-v1":
	/*get the Meeting create details */
	include_once('./Meetings/MeetingDiscussionItem-v1.php');
	break;
	case "CreateMeetingDiscussionItem-v1":
	/*get the Meeting create details */
	include_once('./Meetings/CreateMeetingDiscussionItem-v1.php');
	break;
	case "EditMeetingDiscussionItem-v1":
	/*get the Meeting create details */
	include_once('./Meetings/EditMeetingDiscussionItem-v1.php');
	break;
	case "DeleteMeetingDiscussionItem-v1":
	/*get the Meeting create details */
	include_once('./Meetings/DeleteMeetingDiscussionItem-v1.php');
	break;
	case "CreateMeetingActionItem-v1":
	/*get the Meeting create details */
	include_once('./Meetings/CreateMeetingActionItem-v1.php');
	break;
	case "EditMeetingActionItem-v1":
	/*get the Meeting create details */
	include_once('./Meetings/EditMeetingActionItem-v1.php');
	break;
	case "DeleteMeetingActionItem-v1":
	/*get the Meeting create details */
	include_once('./Meetings/DeleteMeetingActionItem-v1.php');
	break;
	case "CreateDiscussionItemComment-v1":
	/*get the Meeting create details */
	include_once('./Meetings/CreateDiscussionItemComment-v1.php');
	break;
	case "EditDiscussionItemComment-v1":
	/*get the Meeting create details */
	include_once('./Meetings/EditDiscussionItemComment-v1.php');
	break;
	case "DeleteDiscussionItemComment-v1":
	/*get the Meeting create details */
	include_once('./Meetings/DeleteDiscussionItemComment-v1.php');
	break;
	case "ActionItemDateUpdate-v1":
	/*get the Meeting create details */
	include_once('./Meetings/ActionItemDateUpdate-v1.php');
	break;
	case "EditMeetingDiscussionItemStatus-v1":
	/*get the Meeting create details */
	include_once('./Meetings/EditMeetingDiscussionItemStatus-v1.php');
	break;
	default:
	break;
}

if($RN_jsonEC['status'] == 200){
	$RN_GetSoftware_Module_Category_id = 4;
	$RN_GetSoftware_Module_id = 'meetings';
	include_once('./Auth/PagePermssion.php');
	//  Impersonate data(companies)
	// include_once('./ImpersonateData/ImpersonateData.php');
}
header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>

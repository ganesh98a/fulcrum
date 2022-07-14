<?php
/*Dailylog service*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: *');
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
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/PunchItem.php');
require_once('lib/common/PunchItemAttachment.php');
require_once('lib/common/PunchItemStatus.php');
require_once('lib/common/PunchItemBuilding.php');
require_once('lib/common/PunchItemBuildingRoom.php');
require_once('lib/common/PunchItemDefect.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Contact.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/Module.php');
require_once('lib/common/PdfTools.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('../modules-punch-item-functions.php');
require_once('../image-resize-functions.php');
require_once('../transmittal-functions.php');
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
$RN_view = $RN_params['method'];
$RN_project_id = $RN_params['project_id'];

$RN_page = 1;
if(isset($RN_params['page']) && $RN_params['page']!=null){
	$RN_page = $RN_params['page'];
}
$RN_view = 'List';
if(isset($RN_params['method']) && $RN_params['method']!=null){
	$RN_view = $RN_params['method'];
}
$RN_per_page = 20;
if(isset($RN_params['per_page']) && $RN_params['per_page']!=null){
	$RN_per_page = $RN_params['per_page'];
}
$RN_filterValue = null;
if(isset($RN_params['filter_value']) && $RN_params['filter_value']!=null){
	$RN_filterValue = $RN_params['filter_value'];
}
$RN_filterType = null;
if(isset($RN_params['filter_type']) && $RN_params['filter_type']!=null){
	$RN_filterType = $RN_params['filter_type'];
}
$RN_draft_flag = 'All';
if(isset($RN_params['draft_flag']) && $RN_params['draft_flag']!=null){
	$RN_draft_flag = $RN_params['draft_flag'];
}
$RN_by_status = null;
if(isset($RN_params['by_status']) && $RN_params['by_status']!=null){
	$RN_by_status = $RN_params['by_status'];
}
$RN_version = null;
if(isset($RN_params['version'])){
	$RN_version = $RN_params['version'];
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
	$RN_jsonEC['status'] = 400;
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
/* @var $project Project */
$project = Project::findById($database, $RN_project_id);
/*get the details of view*/

$RN_virtual_file_path = "/Punch Lists/";
$RN_punchItemUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_virtual_file_path);
/* @var $jobsiteSignInSheetUploadfileManagerFolder FileManagerFolder */
$RN_file_manager_folder_id = $RN_punchItemUploadFileManagerFolder->file_manager_folder_id;

$RN_virtual_file_path = "/Punch Lists/Punch List Draft Attachments/";
$RN_punchItemUploadFileManagerFolderDraft = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_virtual_file_path);

$RN_draft_file_manager_folder_id = $RN_punchItemUploadFileManagerFolderDraft->file_manager_folder_id;
/* @var $jobsiteSignInSheetUploadfileManagerFolder FileManagerFolder */

$uploadDetailsTmp['action'] = '/modules-file-manager-file-uploader-ajax.php';
$uploadDetailsTmp['append_date_to_filename'] = 0;
$uploadDetailsTmp['virtual_file_path'] = $RN_virtual_file_path;
$uploadDetailsTmp['folder_id'] = $RN_file_manager_folder_id;
$uploadDetailsTmp['draft_folder_id'] = $RN_draft_file_manager_folder_id;
$uploadDetailsTmp['allowed_extensions'] = 'gif,jpg,jpeg,pdf,png,tif,tiff,heic';
$uploadDetailsTmp['id'] = 'photo_upload';
$uploadDetailsTmp['method'] = 'uploadFiles';
$uploadDetailsTmp['method_save'] = 'jobsite_photos';
$uploadDetailsTmp['internal_use_only_flag'] = 'N';
$RN_jsonEC['data']['CreatePunchListData'] = null;
$RN_jsonEC['data']['CreatePunchListData']['uploadDetails'] = $uploadDetailsTmp;
/*echo $RN_htmlContent = buildPiAsHtmlForPdfConversion($database, $RN_user_company_id, 240,$RN_currentlyActiveContactId,$RN_user_company_id, array(6934 => 'test'));
exit;*/
switch($RN_view){
	case "ListPunchItem":
	/*create punch list item */
	include_once('./PunchItem/ListPunchItem.php');
	break;
	case "CreatePunchItem":
	/*create punch list item */
	include_once('./PunchItem/CreatePunchItem.php');
	break;
	/* Upload Doc */
	case "UploadDoc":
	include_once('./PunchItem/UploadDoc.php');
	break;
	/* DeleteUploadDoc */
	case "DeleteUploadDoc":
	include_once('./PunchItem/DeleteUploadDoc.php');
	break;
	/* UpdateStatus */
	case "UpdateStatus":
	include_once('./PunchItem/UpdateStatus.php');
	break;
	case "GetRecipient":
	include_once('./PunchItem/GetRecipientByCostCodeId.php');
	break;
	case "GetRoom":
	include_once('./PunchItem/GetRoomByBuildingId.php');
	break;
	case "SendNotification":
	include_once('./PunchItem/SendNotification.php');
	break;
	case "CreateTransmittal":
	include_once('./PunchItem/CreateTransmittal.php');
	break;
	case "SendDraft":
	include_once('./PunchItem/SaveDraftAndTransmittal.php');
	break;
	case "EditAndSaveDraft":
	include_once('./PunchItem/EditAndSaveDraft.php');
	break;
	case "DeleteDraft":
	include_once('./PunchItem/DeleteDraft.php');
	case "CreatePunchItemData":
	include_once('./PunchItem/CreatePunchItemData.php');
	break;
	default:
	break;
}

if($RN_jsonEC['status'] == 200){
	$RN_GetSoftware_Module_Category_id = 4;
	$RN_GetSoftware_Module_id = 'punch_list';
	include_once('./Auth/PagePermssion.php');
	//  Impersonat data(companies)
	// include_once('./ImpersonateData/ImpersonateData.php');
}
header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>

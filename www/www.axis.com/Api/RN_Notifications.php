<?php
/*Notification service*/
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
require_once('lib/common/ActionItemType.php');
require_once('lib/common/RequestForInformation.php');
require_once('lib/common/Submittal.php');
require_once('lib/common/Contact.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');

require_once('lib/common/Api/UsersNotifications.php');

require_once('./Auth/ModulePermissionFunction.php');

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

if(isset($RN_params['project_id'])) {
	$RN_project_id = $RN_params['project_id'];
}

$RN_page = 1;
if(isset($RN_params['page']) && $RN_params['page']!=null){
	$RN_page = $RN_params['page'];
}

$RN_view = 'ListAllNotification';
if(isset($RN_params['method']) && $RN_params['method']!=null){
	$RN_view = $RN_params['method'];
}

$RN_per_page = 20;
if(isset($RN_params['per_page']) && $RN_params['per_page']!=null){
	$RN_per_page = $RN_params['per_page'];
}

$RN_filterValue = 'All';
if(isset($RN_params['filterValue']) && $RN_params['filterValue']!=null){
	$RN_filterValue = $RN_params['filterValue'];
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
/* @var $project Project */
$project = Project::findById($database, $RN_project_id);
/*get the details of view*/
switch($RN_view){
	case "ListAllNotification":
	/*get the notification details */
	include_once('./Notifications/NotificationListData.php');
	break;
	case "OverAllUnReadCount":
	include_once('./Notifications/OverAllUnReadCount.php');
	break;
	case "StatusUpdate":
	include_once('./Notifications/NotificationStatusUpdate.php');
	break;
	case "MarkAsAllRead":
	include_once('./Notifications/NotificationMarkAsCompleted.php');
	break;
	default:
	break;
}

if($RN_jsonEC['status'] == 200){
	$RN_permission = array();
	$RN_GetSoftware_Module_Category_id = 4;
	// RFi permission get
	$RN_GetSoftware_Module_id = 'rfis';
	$rfiCheckPermission = checkPermission($database, $user, $RN_project_id, $RN_GetSoftware_Module_id);
	// Submittals permission get
	$RN_GetSoftware_Module_id = 'submittals';
	$suCheckPermission = checkPermission($database, $user, $RN_project_id, $RN_GetSoftware_Module_id);
	// meeting permission get
	$RN_GetSoftware_Module_id = 'meetings';
	$meetingCheckPermission = checkPermission($database, $user, $RN_project_id, $RN_GetSoftware_Module_id);

	$RN_permission = array_merge($rfiCheckPermission, $suCheckPermission, $meetingCheckPermission);
	$RN_jsonEC['data']['permissions'] = ($RN_permission);

}
header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>

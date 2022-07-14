<?php

/*Menu Service for show the menu user Access in Fulcrum*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
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
require_once('lib/common/init.php');
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/File.php');
require_once('lib/common/FileLocation.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/RoleToFolder.php');
require_once('lib/common/RoleToFile.php');
require_once('lib/common/WorkflowProgressIndicator.php');
require_once('lib/common/Message.php');
// require_once('../app/models/permission_mdl.php');
require_once('lib/common/Permissions.php');
$_SERVER['REQUEST_METHOD'];
/*Validate the requeset method*/
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$RN_params = $_GET;
}else{
	$RN_params = $_POST;	
}

/*get the request values*/
if(isset($RN_params['token']) && $RN_params['token'] != null){
	$RN_token = $RN_params['token'];
} else {
	$RN_token = '';
}
if(isset($RN_params['method']) && $RN_params['method'] != null){
	$RN_view = $RN_params['method'];
} else {
	$RN_view = '';
}
// print_r($RN_view);exit;

if(isset($RN_params['project_id'])){
	$RN_project_id = $RN_params['project_id'];
}else{
	$RN_project_id = null;
}


include_once('./Auth/AuthAccess.php');

/* varirable json encode*/
$RN_jsonEC = array();

/*response index value init*/
$RN_jsonEC['status'] = 400;
$RN_jsonEC['token'] = null;
$RN_jsonEC['message'] = null;
$RN_jsonEC['err_message'] = null;
$RN_jsonEC['data'] = null;

$RN_user_company_id = $user->user_company_id;
$RN_user_id = $user->user_id;
$RN_userRole = $user->getUserRole();

// $RN_project_id = $user->currentlySelectedProjectId;
$RN_primary_contact_id = $user->primary_contact_id;
$RN_currentlyActiveContactId = $user->currentlyActiveContactId;
$RN_currentlySelectedProjectName = $user->currentlySelectedProjectName;
/* @var $project Project */
$project = Project::findById($database, $RN_project_id);
$RN_encodedProjectName = Data::entity_encode($project->project_name);
$RN_project_name = $RN_encodedProjectName;
$currentlySelectedProjectUserCompanyId=$project->user_company_id;
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $RN_user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;
/*get the details of view*/

$RN_Dir=$RN_params['dir'];
$isTrash=$RN_params['isTrash'];
switch($RN_view){
	case "LoadFiles":
		include_once('./FileManager/LoadFiles.php');
	break;
	default:
	break;
}

header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>

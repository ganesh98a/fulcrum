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
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PdfTools.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/UserCompany.php');

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
if(isset($RN_params['reportType']) && $RN_params['reportType'] != null){
	$RN_reportType = $RN_params['reportType'];
} else {
	$RN_reportType = '';
}
if(isset($RN_params['downloadType']) && $RN_params['downloadType'] != null){
	$RN_downloadType = $RN_params['downloadType'];
} else {
	$RN_downloadType = '';
}
if(isset($RN_params['reportsStartDate']) && $RN_params['reportsStartDate'] != null){
	$RN_reportsStartDate = $RN_params['reportsStartDate'];
} else {
	$RN_reportsStartDate = '';
}
if(isset($RN_params['reportsEndDate']) && $RN_params['reportsEndDate'] != null){
	$RN_reportsEndDate = $RN_params['reportsEndDate'];
} else {
	$RN_reportsEndDate = '';
}
if(isset($RN_params['description']) && $RN_params['description'] != null){
	$RN_reportsDescription = $RN_params['description'];
} else {
	$RN_reportsDescription = '';
}
if(isset($RN_params['groupco']) && $RN_params['groupco'] != null){
	$RN_groupco = $RN_params['groupco'];
} else {
	$RN_groupco = '';
}
if(isset($RN_params['generalco']) && $RN_params['generalco'] != null){
	$RN_generalco = $RN_params['generalco'];
} else {
	$RN_generalco = '';
}
if(isset($RN_params['includeNotes']) && $RN_params['includeNotes'] != null){
	$RN_includeNotes = $RN_params['includeNotes'];
} else {
	$RN_includeNotes = '';
}
if(isset($RN_params['subTotal']) && $RN_params['subTotal'] != null){
	$RN_subTotal = $RN_params['subTotal'];
} else {
	$RN_subTotal = '';
}
if(isset($RN_params['project_id'])){
	$RN_project_id = $RN_params['project_id'];
}else{
	$RN_project_id = null;
}
if(isset($RN_params['filterType'])){
	$RN_filter_type = $RN_params['filterType'];
}else{
	$RN_filter_type = null;
}
if(isset($RN_params['filterBy'])){
	$RN_filter_by = $RN_params['filterBy'];
}else{
	$RN_filter_by = null;
}
if(isset($RN_params['showRejected'])){
	$RN_show_rejected = $RN_params['showRejected'];
}else{
	$RN_show_rejected = 'false';
}

$RN_version = null;
if(isset($RN_params['version'])){
	$RN_version = $RN_params['version'];
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

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $RN_user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;
/*get the details of view*/


switch($RN_view){
	case "GetReportsData":
	/*Get reports list  */
	include_once('./Reports/GetReportsData.php');
	break;
	case "GetDownloadRecords":
	/* Get download records */
	include_once('./Reports/GetDownloadRecords.php');
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

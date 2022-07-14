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

require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/Log.php');
require_once('../renderPDF.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');

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
if(isset($RN_params['date']) && $RN_params['date']!='') {
	$RN_date = $RN_params['date'];
} else {
	$RN_date = '';
}
if(isset($RN_params['tab']) && $RN_params['tab']!='') {
	$RN_tab = $RN_params['tab'];
} else {
	$RN_tab = '';
}
$RN_project_id = $RN_params['project_id'];

if ($RN_date == 'null' || $RN_date == Null || $RN_date == 'undefined') {
	$RN_date = date('Y-m-d');
} else {
	$RN_date = date('Y-m-d', strtotime($RN_date));
}
// $RN_date;
// exit;
$RN_page = 1;
if(isset($RN_params['page']) && $RN_params['page']!=null){
	$RN_page = $RN_params['page'];
}
$RN_tab = 1;
if(isset($RN_params['tab']) && $RN_params['tab']!=null){
	$RN_tab = $RN_params['tab'];
}
$RN_per_page = 70;
if(isset($RN_params['per_page']) && $RN_params['per_page']!=null){
	$RN_per_page = $RN_params['per_page'];
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
// VARIABLES
require_once('../modules-jobsite-daily-logs-functions.php');

$RN_user_company_id = $user->user_company_id;
$RN_user_id = $user->user_id;
$RN_userRole = $user->getUserRole();
// $RN_project_id = $user->currentlySelectedProjectId;
$RN_primary_contact_id = $user->primary_contact_id;
$RN_currentlyActiveContactId = $user->currentlyActiveContactId;
$RN_currentlySelectedProjectName = $user->currentlySelectedProjectName;
/* @var $project Project */
$project = Project::findById($database, $RN_project_id);
/*Get the date details of selected date*/
include_once('./DailyLog/WeatherData.php');
/*get the details of tab*/
switch($RN_tab){
	case 1:
	/*get the company details & onsite workers*/
	include_once('./DailyLog/ManpowerData.php');
	break;
	case "ManpowerDataSave":
	/*get the company details & onsite workers*/
	include_once('./DailyLog/ManpowerDataSave.php');
	break;
	case "ManpowerDocDelete":
	/*get the company details & onsite workers*/
	include_once('./DailyLog/ManpowerDocDelete.php');
	break;
	case 2:
	/*get the company details & onsite workers*/
	include_once('./DailyLog/SiteworkData.php');
	break;
	case 'SiteworkDataSave':
	/*get the company details & onsite workers*/
	include_once('./DailyLog/SiteworkDataSave.php');
	break;
	case 3:
	/*get the company details & onsite workers*/
	include_once('./DailyLog/BuildingData.php');
	break;
	case 'BuildingDataSave':
	/*get the company details & onsite workers*/
	include_once('./DailyLog/BuildingDataSave.php');
	break;
	case 4:
	/*get the company details & onsite workers*/
	include_once('./DailyLog/DetailData.php');
	break;
	case 'InspectionDataSave':
	/*get the company details & onsite workers*/
	include_once('./DailyLog/InspectionDataSave.php');
	break;
	case 'DelayDataSave':
	/*get the company details & onsite workers*/
	include_once('./DailyLog/DelayDataSave.php');
	break;
	case 'NotesDataSave':
	/*get the company details & onsite workers*/
	include_once('./DailyLog/NotesDataSave.php');
	break;
	case 5:
	/*get the company details & onsite workers*/
	include_once('./DailyLog/RenderData.php');
	break;
	case 'UploadDoc':
	/*get the company details & onsite workers*/
	include_once('./DailyLog/UploadDoc.php');
	break;
	case 'UpdateImageCaption':
	include_once('./DailyLog/UpdateImageCaption.php');
	break;
	case 'DcrPreview':
	/*PDF restrict count*/
	$RN_GenerateId = GetCountOfValue($RN_project_id, $RN_jobsite_daily_log_created_date, $database);
	$RN_GetCount = getlogscount($RN_GenerateId, $database);
	/*get the company details & onsite workers*/
	if($RN_GetCount > 0){
		include_once('./DailyLog/DcrPreview.php');
	}else{
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['message'] = null;
		$RN_jsonEC['err_message'] = "No more change for PDF generation";
		$RN_jsonEC['data'] = null;
	}
	break;
	default:
	break;
}

if($RN_jsonEC['status'] == 200){
	$RN_GetSoftware_Module_Category_id = 4;
	$RN_GetSoftware_Module_id = 'jobsite_daily_logs';
	include_once('./Auth/PagePermssion.php');
	//  Impersonat data(companies)
	// include_once('./ImpersonateData/ImpersonateData.php');
	$RN_jsonEC['data']['functions']['Manpower']['tab'] = 1;
	$RN_jsonEC['data']['functions']['Manpower']['save'] = 'ManpowerDataSave';
	$RN_jsonEC['data']['functions']['Sitework']['tab'] = 2;
	$RN_jsonEC['data']['functions']['Sitework']['save'] = 'SiteworkDataSave';
	$RN_jsonEC['data']['functions']['Building']['tab'] = 3;
	$RN_jsonEC['data']['functions']['Building']['save'] = 'BuildingDataSave';
	$RN_jsonEC['data']['functions']['Detail']['tab'] = 4;
	$RN_jsonEC['data']['functions']['Detail']['save'] = 'DetailDataSave';
}
header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>

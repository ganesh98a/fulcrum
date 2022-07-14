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
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCodeType.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/Log.php');
require_once('lib/common/MobileNetworkCarrier.php');
require_once('lib/common/MobilePhoneNumber.php');
require_once('lib/common/PageComponents.php');
require_once('lib/common/Pdf.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/SubcontractDocument.php');
require_once('lib/common/SubcontractItemTemplate.php');
require_once('lib/common/SubcontractorBid.php');
require_once('lib/common/SubcontractorBidStatus.php');
require_once('lib/common/SubcontractTemplate.php');
require_once('lib/common/SubcontractTemplateToSubcontractItemTemplate.php');
require_once('lib/common/SubcontractType.php');
require_once('lib/common/UserCompanyFileTemplate.php');
require_once('lib/common/Vendor.php');

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
$RN_project_id = $RN_params['project_id'];
$RN_view = "";

$RN_page = 1;
if(isset($RN_params['page']) && $RN_params['page']!=null){
	$RN_page = $RN_params['page'];
}
if(isset($RN_params['view']) && $RN_params['view']!=null){
	$RN_view = $RN_params['view'];
}
$RN_per_page = 20;
if(isset($RN_params['per_page']) && $RN_params['per_page']!=null){
	$RN_per_page = $RN_params['per_page'];
}
$RN_sort = '';
if(isset($RN_params['sort']) && $RN_params['sort']!=null){
	$RN_sort = $RN_params['sort'];
}
$RN_scheduled_values_only = false;
if(isset($RN_params['scheduled_values_only']) && $RN_params['scheduled_values_only']!=null){
	$RN_scheduled_values_only =  filter_var($RN_params['scheduled_values_only'], FILTER_VALIDATE_BOOLEAN);
}

$RN_needed_buy_out = false;
if(isset($RN_params['needed_buy_out']) && $RN_params['needed_buy_out']!=null){
	$RN_needed_buy_out =  filter_var($RN_params['needed_buy_out'], FILTER_VALIDATE_BOOLEAN);
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

include_once('./Budget/BudgetData.php');

if($RN_jsonEC['status'] == 200){
	$RN_GetSoftware_Module_Category_id = 4;
	$RN_GetSoftware_Module_id = 'gc_budgets';
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

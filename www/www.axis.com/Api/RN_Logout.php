<?php
/*Login Service for validate the user Access in Fulcrum*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');
/*
	METHOD POST OR GET
	Variables Params
	$RN_NE
	$RN_PD
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
require_once('lib/common/User.php');
require_once('lib/common/UserCompany.php');
require_once('lib/common/Validate.php');
require_once('lib/common/Api/UsersDeviceInfo.php');

/* varirable json encode*/
$RN_jsonEC = array();

$_SERVER['REQUEST_METHOD'];
/*Validate the requeset method*/
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$RN_params = $_GET;
}else{
	$RN_params = $_POST;	
}

/*response index value init*/
$RN_jsonEC['status'] = 400;
$RN_jsonEC['access_token'] = null;
$RN_jsonEC['message'] = null;
$RN_jsonEC['err_message'] = null;
$RN_jsonEC['data'] = null;
$RN_httpGetInputData = $RN_params;
if(isset($RN_httpGetInputData['device_id']) && $RN_httpGetInputData['device_id'] != null) {
	$RN_userDeviceInfoId = UsersDeviceInfo::findByUserDeviceId($database, $RN_httpGetInputData['device_id']);
	if ($RN_userDeviceInfoId !== null) {
		$RN_userDevieInfo = UsersDeviceInfo:: findById($database, $RN_userDeviceInfoId);
		if($RN_userDevieInfo) {
			$RN_data = array("is_active" => "N", "modified_date" => date('Y-m-d h:i:s', time()));
			$RN_userDevieInfo->setData($RN_data);
			$RN_userDevieInfo->convertDataToProperties();
			$RN_message = 'User Device Deactivated Successfully';
			$RN_errorMessage = null;
			$RN_status = 200;
			$RN_user_device_id = $RN_userDevieInfo->save();
		} else {
			$RN_message = 'User Device Not Exists';
			$RN_errorMessage = 'User Device Not Exists';
			$RN_status = 400;
		}
	}
} else {
	$RN_message = 'User Device Not Exists';
	$RN_errorMessage = 'User Device Not Exists';
	$RN_status = 400;
}
$RN_jsonEC['status'] = $RN_status;
$RN_jsonEC['message'] = $RN_message;
$RN_jsonEC['err_message'] = $RN_errorMessage;

header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>
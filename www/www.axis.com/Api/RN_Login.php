<?php
/*Login Service for validate the user Access in Fulcrum*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json, application/x-www-form-urlencoded');
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

if (!isset($RN_params) && empty($RN_params)) {
	$RN_params = json_decode(file_get_contents('php://input'), true);
}

/*get the request values*/
$RN_NE = $RN_params['username'];
$RN_PD = $RN_params['password'];

/*response index value init*/
$RN_jsonEC['status'] = 400;
$RN_jsonEC['access_token'] = null;
$RN_jsonEC['message'] = null;
$RN_jsonEC['err_message'] = null;
$RN_jsonEC['data'] = null;


/*validate the inputs using if else */
if(($RN_NE == null || $RN_NE == '') && ($RN_PD == null || $RN_PD == '')){
	$RN_jsonEC['err_message'] = "Enter valid username & password";	
}else
if($RN_NE == null || $RN_NE == ''){
	$RN_jsonEC['err_message'] = "Enter valid username";
}else
if($RN_PD == null || $RN_PD == ''){
	$RN_jsonEC['err_message'] = "Enter valid password";
}else
if ( (strlen($RN_NE) < 5)) {
	$RN_jsonEC['err_message'] ="Enter valid username";
}else
if ( (strlen($RN_PD) < 5)) {
	$RN_jsonEC['err_message'] = "Enter valid password";
}
else
{
	$validEmailFlag = Validate::email2($RN_NE);
	if($validEmailFlag){
		include_once('./Auth/Auth.php');
	}else{
		$RN_jsonEC['err_message'] = "Enter valid username";
	}
}
header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>

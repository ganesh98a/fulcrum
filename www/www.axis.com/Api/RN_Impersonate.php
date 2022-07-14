<?php
/*impersonate Service for validate the user Access in Fulcrum*/
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

/* varirable json encode*/
$RN_jsonEC = array();

$_SERVER['REQUEST_METHOD'];
/*Validate the requeset method*/
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$RN_params = $_GET;
}else{
	$RN_params = $_POST;	
}
$RN_token = $RN_params['token'];
/*get the request values*/
$RN_UCI = $RN_params['impersonate_user_company_id'];
$RN_UI = $RN_params['impersonate_user_id'];

/*response index value init*/
$RN_jsonEC['status'] = 400;
$RN_jsonEC['access_token'] = null;
$RN_jsonEC['message'] = null;
$RN_jsonEC['err_message'] = null;
$RN_jsonEC['data'] = null;

/*validate the inputs using if else */
if(($RN_UCI == null || $RN_UCI == '') && ($RN_UI == null || $RN_UI == '')){
	$RN_jsonEC['err_message'] = "Please provide the user company and user";	
}else
if($RN_UCI == null || $RN_UCI == ''){
	$RN_jsonEC['err_message'] = "Please select the user company";
}else
if($RN_UI == null || $RN_UI == ''){
	$RN_jsonEC['err_message'] = "Please select the user";
}
else
{
	$RN_viewImpersonate = true;
	include_once('./Auth/AuthAccess.php');
	//  Impersonat data(companies)
	include_once('./ImpersonateData/ImpersonateData.php');
}
header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>
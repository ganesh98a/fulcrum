<?php
try {

$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('trailsignup-function.php'); 


//Method To check the mail already exist or not
if(isset($_GET['method']) && $_GET['method']=="checkEmailExist")
{
	$email =  $_GET['email'];

	$resdata= checkEmailExist($email);
	echo $resdata;	
}


}catch (Exception $e) {


}
?>

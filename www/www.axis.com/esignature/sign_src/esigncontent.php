<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');
require_once('lib/common/File.php');
// echo "value : ".$_GET['method'];
if((isset($_GET['method'])) && $_GET['method'] =="esigncontent")
	{
	$session = Zend_Registry::get('session');
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

	$filename = md5($currentlyActiveContactId);
	$config = Zend_Registry::get('config');	
	$file_manager_base_path = $config->system->file_manager_base_path;
	$save = $file_manager_base_path.'backend/procedure/';
	
	$signfile_name = $save.$filename.'.png';


	$filegetcontent = file_get_contents($signfile_name);
	$base64 = 'data:image;base64,' . base64_encode($filegetcontent);

	$db = DBI::getInstance($database);
	$query ="Select `date` from  signature_data where `contact_id`= ?";
	$arrValues = array($currentlyActiveContactId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$updated_date =$row['date'];
	if($updated_date !="")
	{
		$dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $updated_date);
		$updated_date = $dateObj->format('m/d/Y');
	}
	echo $base64.'~'.$updated_date;
}
	
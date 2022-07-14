<?php
/**
* Delete Delay
*/

$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');
$projectId = $session->getCurrentlySelectedProjectId();
$db = DBI::getInstance($database);     	// Db Initialize


$id = $_POST['id'];

if ($_POST['is_archive'] == 'true') {
	$value = 'Y';
}else{
	$value = 'N';
}

$que1="SELECT * FROM `contacts` WHERE id=?";
$arrValue1 = array($id);
$db->execute($que1,$arrValue1);
$row2=$db->fetch();
$user_id=$row2['user_id'];
$db->free_result();  

if ($user_id != 1) {

	$que2="UPDATE contacts SET is_archive = ? where id = ?";
	$arrValue2 = array($value,$id);
	$db->execute($que2,$arrValue2);
	$db->free_result();

	$que3="UPDATE contacts SET is_archive = ? where user_id = ?";
	$arrValue3 = array($value,$user_id);
	$db->execute($que3,$arrValue3);
	$db->free_result();

	$que4="UPDATE users SET is_archive = ? where id = ?";
	$arrValue4 = array($value,$user_id);
	if($db->execute($que4,$arrValue4)){
		echo true;
	}
	$db->free_result();

}else{

	$que5="UPDATE contacts SET is_archive = ? where id = ?";
	$arrValue5 = array($value,$id);
	if($db->execute($que5,$arrValue5)){
		echo true;
	}	
	$db->free_result(); 
}

<?php
/**
* Delete Transmittal
*/

$init['application'] = 'www.axis.com';
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');
$db = DBI::getInstance($database);     	// Db Initialize


$id = $_POST['id'];

$query = "UPDATE transmittal_data SET status='1' WHERE id='$id'";									// Set delete flag

if($db->execute($query)){
	echo true;
}
$db->free_result();


      
         
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
//to get delay sequence number
 $que1="SELECT delay_sequence_number from jobsite_delay_data where id='$id' ";
$db->execute($que1);
$row1=$db->fetch();
$sequence_number=$row1['delay_sequence_number'];
$db->free_result();
//to get the file manager
 $que2="SELECT * FROM `file_manager_folders` WHERE `virtual_file_path` LIKE '/Delays/Delay #".$sequence_number."/'  and project_id='$projectId'";
$db->execute($que2);
$row2=$db->fetch();
$folder_id=$row2['id'];
$db->free_result();

//to get the files
 $que3="SELECT file_location_id,id,file_manager_folder_id FROM `file_manager_files` WHERE `file_manager_folder_id` = $folder_id ";
$db->execute($que3);
$row3=$db->fetch();
$file_manger_id=$row3['id'];
$file_loc_id=$row3['file_location_id'];
$folder_id=$row3['file_manager_folder_id'];
$db->free_result();

//to delete the file 
 $que4="DELETE from file_manager_files where id='$file_manger_id'";
$db->execute($que4);
$db->free_result();

//to get the files location
 $que3="DELETE from file_locations where id='$file_loc_id'";
$db->execute($que3);
$db->free_result();

//to delete the file 
 $que5="DELETE from file_manager_folders where id='$folder_id'";
$db->execute($que5);
$db->free_result();


$query="DELETE from jobsite_delay_data where id='$id' ";

if($db->execute($query)){
	echo true;
}
$db->free_result();


      
         

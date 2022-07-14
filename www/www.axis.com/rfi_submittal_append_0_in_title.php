<?php 
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Message.php');

// DATABASE VARIABLES
$db = DBI::getInstance($database);

// To get submittal details
$query1 = "SELECT su.`id`,su.`su_title`,su.`su_sequence_number`,su.`su_file_manager_file_id`,ff.`file_manager_folder_id`,ff.`deleted_flag` FROM `submittals` as su LEFT JOIN `file_manager_files` as ff ON ff.`id` = su.`su_file_manager_file_id` WHERE `su_sequence_number` < 100";
$db->execute($query1);
$su_array = array();
while ($row = $db->fetch()) {
    $su_array[$row['id']] = $row;
}
$db->free_result();
echo "Submittal count : ".count($su_array)."<br><hr>";
$su_count = 1;
foreach ($su_array as $key => $value) {
    $su_id = $value['id'];
    $su_title = $value['su_title'];
    $su_sequence_number = $value['su_sequence_number'];
    $su_file_id = $value['su_file_manager_file_id'];
    $su_folder_id = $value['file_manager_folder_id'];
    $su_deleted_flag = $value['deleted_flag'];

    if ($su_deleted_flag == 'Y') {
        $su_file_rename = 'tr~Submittal #'.$su_sequence_number.' - '.$su_title.'.pdf';
    }else{
        $su_file_rename = 'Submittal #'.$su_sequence_number.' - '.$su_title.'.pdf';
    }    
    $su_folder_rename = '/Submittals/Submittal #'.$su_sequence_number.'/';

    $query2= "UPDATE `file_manager_folders` SET `virtual_file_path` = '$su_folder_rename' WHERE `id` = $su_folder_id";
    $db->execute($query2, MYSQLI_STORE_RESULT);
    $db->free_result();

    $query3= "UPDATE `file_manager_files` SET `virtual_file_name` = '$su_file_rename' WHERE `id` = $su_file_id";
    $db->execute($query3, MYSQLI_STORE_RESULT);
    $db->free_result();

    echo "Submittal updated successfully ".$su_count."<br>";
    $su_count++;
}

// To get rfi details
$query4 = "SELECT rfi.`id`,rfi.`rfi_title`,rfi.`rfi_sequence_number`,rfi.`rfi_file_manager_file_id`,ff.`file_manager_folder_id`,ff.`deleted_flag` FROM `requests_for_information` as rfi LEFT JOIN `file_manager_files` as ff ON ff.`id` = rfi.`rfi_file_manager_file_id` WHERE `rfi_sequence_number` < 100";
$db->execute($query4);
$rfi_array = array();
while ($row = $db->fetch()) {
    $rfi_array[$row['id']] = $row;
}
$db->free_result();
echo "<hr>Rfi count : ".count($rfi_array)."<br><hr>";
$rfi_count = 1;
foreach ($rfi_array as $key => $value) {
    $rfi_id = $value['id'];
    $rfi_title = $value['rfi_title'];
    $rfi_sequence_number = $value['rfi_sequence_number'];
    $rfi_file_id = $value['rfi_file_manager_file_id'];
    $rfi_folder_id = $value['file_manager_folder_id'];
    $rfi_deleted_flag = $value['deleted_flag'];

    if ($rfi_deleted_flag == 'Y') {
        $rfi_file_rename = 'tr~RFI #'.$rfi_sequence_number.' - '.$rfi_title.'.pdf';
    }else{
        $rfi_file_rename = 'RFI #'.$rfi_sequence_number.' - '.$rfi_title.'.pdf';
    }    
    $rfi_folder_rename = '/RFIs/RFI #'.$rfi_sequence_number.'/';

    $query5= "UPDATE `file_manager_folders` SET `virtual_file_path` = '$rfi_folder_rename' WHERE `id` = $rfi_folder_id";
    $db->execute($query5, MYSQLI_STORE_RESULT);
    $db->free_result();

    $query6= "UPDATE `file_manager_files` SET `virtual_file_name` = '$rfi_file_rename' WHERE `id` = $rfi_file_id";
    $db->execute($query6, MYSQLI_STORE_RESULT);
    $db->free_result();

    echo "RFI updated successfully ".$rfi_count."<br>";
    $rfi_count++;
}
?>
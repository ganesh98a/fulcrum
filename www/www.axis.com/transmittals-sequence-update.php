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

$Db = DBI::getInstance($database);  // Db Initialize

$sequence_query = "SELECT * FROM transmittal_data ORDER BY id ASC";

$arrayTransmittal = array();
$Db->execute($sequence_query);
while($row = $Db->fetch()){
	$project_id = $row['project_id'];
	$arrayTransmittal[$project_id][] = $row;
}
$Db->free_result();

foreach($arrayTransmittal as $tmpProjectId => $transmittals){
	foreach($transmittals as $index => $eachTransmittal){
		// sequence number
		$primaryId = $eachTransmittal['id'];
		$tmpSequenceNumber = $index+1;
		$sequenceNumber = $arrayTransmittal[$tmpProjectId][$index]['sequence_number'];
		if($sequenceNumber== '' && $sequenceNumber==null){
			$arrayTransmittal[$tmpProjectId][$index]['new_sequence_number'] = $tmpSequenceNumber;
			$sequenceUpdate = "UPDATE transmittal_data SET sequence_number = $tmpSequenceNumber WHERE id = $primaryId";
			$Db->execute($sequenceUpdate);
			$Db->free_result();
		}
		// folder data get
		$folderquery = "SELECT * FROM file_manager_folders where project_id = $tmpProjectId AND virtual_file_path = '/Transmittals/Transmittal #$primaryId/'";	
		$Db->execute($folderquery);
		$folderData = $Db->fetch();
		$Db->free_result();
		$arrayTransmittal[$tmpProjectId][$index]['file'] = $folderData;

		if(isset($folderData) && !empty($folderData) && ($sequenceNumber==null && $sequenceNumber=='') ){
			$folderId = $folderData['id'];
			$tmpVirtualPath = "/Transmittals/Transmittal #$tmpSequenceNumber/";
			$arrayTransmittal[$tmpProjectId][$index]['file']['new_virtual_file_path'] = $tmpVirtualPath;
			$folderIdUpdate = "UPDATE file_manager_folders SET virtual_file_path = '$tmpVirtualPath' WHERE id = $folderId";
			$Db->execute($folderIdUpdate);
			$Db->free_result();
		}
	}
}
print_r($arrayTransmittal);
// echo json_encode($arrayTransmittal);
// echo 'Transmittal SequenceNumber Updated Successfully';
?>

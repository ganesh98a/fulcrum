<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');

$db = DBI::getInstance($database);
// To add extra 1 mins for same created time in rfi recipients
$query5="SELECT rfi.`id` as rfid,rfi.`rfi_recipient_contact_id` as rficon, rfir.`id` as rfinot from requests_for_information as rfi INNER JOIN `request_for_information_notifications` rfir ON `rfi`.`id` = `rfir`.`request_for_information_id` INNER JOIN `request_for_information_recipients` rfirc ON `rfir`.`id` = `rfirc`.`request_for_information_notification_id` WHERE rfirc.`smtp_recipient_header_type` = 'To' AND rfirc.`rfi_additional_recipient_contact_id` = rfi.`rfi_recipient_contact_id`";
$db->execute($query5);
$records5=array();
while($row = $db->fetch())
    {	
    	$not_id = $row['rfid'];
        $records5[$not_id]= $row;
    }
$db->free_result();

foreach ($records5 as $key => $value) {
	$query1="UPDATE `request_for_information_recipients` SET `rfi_additional_recipient_created_date` = `rfi_additional_recipient_created_date`+ INTERVAL 1 MINUTE WHERE `request_for_information_notification_id` = ".$value['rfinot']." AND `rfi_additional_recipient_contact_id` = ".$value['rficon'];
			$db->execute($query1, MYSQLI_STORE_RESULT);
			$db->free_result();
}

// To add extra 1 mins for same created time in submittal recipients
$query6="SELECT su.`id` as suid,su.`su_recipient_contact_id` as sucon, sur.`id` as sunot from submittals as su INNER JOIN `submittal_notifications` sur ON `su`.`id` = `sur`.`submittal_id` INNER JOIN `submittal_recipients` surc ON `sur`.`id` = `surc`.`submittal_notification_id` WHERE surc.`smtp_recipient_header_type` = 'To' AND surc.`su_additional_recipient_contact_id` = su.`su_recipient_contact_id`";
$db->execute($query6);
$records6=array();
while($row = $db->fetch())
    {	
    	$not_id = $row['suid'];
        $records6[$not_id]= $row;
    }
$db->free_result();

foreach ($records6 as $key => $value) {
	$query1="UPDATE `submittal_recipients` SET `su_additional_recipient_created_date` = `su_additional_recipient_created_date`+ INTERVAL 1 MINUTE WHERE `submittal_notification_id` = ".$value['sunot']." AND `su_additional_recipient_contact_id` = ".$value['sucon'];
			$db->execute($query1, MYSQLI_STORE_RESULT);
			$db->free_result();
}

// For rfi recipients
$query="SELECT * from request_for_information_recipients WHERE `smtp_recipient_header_type` = 'To' ORDER BY `rfi_additional_recipient_created_date` ASC ";
$db->execute($query);
$records=array();
while($row = $db->fetch())
    {	
    	$not_id = $row['request_for_information_notification_id'];
    	$con_id = $row['rfi_additional_recipient_contact_id'];
        $records[$not_id][$con_id]= $row;
    }

$db->free_result();

foreach ($records as $key => $value) {
	$count = 1;
	foreach ($value as $key => $value1) {
		$notId = $value1['request_for_information_notification_id'];
		$conId	= $value1['rfi_additional_recipient_contact_id'];
		$notZero = $value1['is_to_history'];
		if ($notZero == 0) {
			$query1="Update request_for_information_recipients set is_to_history='".$count."' where request_for_information_notification_id='".$notId."' and rfi_additional_recipient_contact_id='".$conId."' ";
			$db->execute($query1, MYSQLI_STORE_RESULT);
			$db->free_result();
			echo "Rfi Updated. <br>";
		}else{			
			echo "Rfi Already Updated.<br>";
		}
		$count++;
	}
}

// For submittal recipients	

$query="SELECT * from submittal_recipients WHERE `smtp_recipient_header_type` = 'To' ORDER BY `su_additional_recipient_created_date` ASC ";
$db->execute($query);
$records=array();
while($row = $db->fetch())
    {	
    	$not_id = $row['submittal_notification_id'];
    	$con_id = $row['su_additional_recipient_contact_id'];
        $records[$not_id][$con_id]= $row;
    }

$db->free_result();

foreach ($records as $key => $value) {
	$count = 1;
	foreach ($value as $key => $value1) {
		$notId = $value1['submittal_notification_id'];
		$conId	= $value1['su_additional_recipient_contact_id'];
		$notZero = $value1['is_to_history'];
		if ($notZero == 0) {
			$query1="Update submittal_recipients set is_to_history='".$count."' where submittal_notification_id='".$notId."' and su_additional_recipient_contact_id='".$conId."' ";
			$db->execute($query1, MYSQLI_STORE_RESULT);
			$db->free_result();
			echo "Submittal Updated. <br>";
		}else{			
			echo "Submittal Already Updated.<br>";
		}
		$count++;
	}
}

?>

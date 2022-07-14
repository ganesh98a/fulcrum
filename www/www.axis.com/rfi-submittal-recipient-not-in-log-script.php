<?php 
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Message.php');

// DATABASE VARIABLES
$db = DBI::getInstance($database);

// To get submittal details which is not having data in submittal recipient table
$query = "
SELECT 
sunot.`id` as submittal_notification_id,
su.`su_recipient_contact_id` as su_additional_recipient_contact_id,
su.`su_creator_contact_id` as su_additional_recipient_creator_contact_id,
su.`id`,su.`project_id`
FROM `submittals` su
INNER JOIN `submittal_notifications` sunot on su.`id` = sunot.`submittal_id`
WHERE su.`id` IN 
	( SELECT submittal_id FROM `submittal_notifications` 
		WHERE id NOT IN 
		( SELECT `submittal_notification_id` FROM `submittal_recipients` 
			WHERE `smtp_recipient_header_type` = 'To' 
			GROUP BY `submittal_notification_id`)
	) 
ORDER BY sunot.`id`
";
$db->execute($query);
$submittal_array = array();
while ($row = $db->fetch()) {
	$submittal_array[$row['id']] = $row;
}
$db->free_result();

// To insert above result into submittal recipient table and recipient log table
foreach ($submittal_array as $value) {
	$query1 =
    "INSERT INTO `submittal_recipients` (`submittal_notification_id`,`su_additional_recipient_contact_id`,`smtp_recipient_header_type`,`su_additional_recipient_creator_contact_id`,`is_to_history`)
    VALUES (?,?,?,?,?)
    ";
    $arrValues1 = array($value['submittal_notification_id'],$value['su_additional_recipient_contact_id'],'To',$value['su_additional_recipient_creator_contact_id'],1);
    $db->execute($query1, $arrValues1, MYSQLI_USE_RESULT);  
    $db->free_result();

    $query2 =
    "INSERT INTO `submittal_to_recipients_log` (`submittal_notification_id`,`su_to_recipient_contact_id`,`su_to_recipient_creator_contact_id`,`status`,`history`)
    VALUES (?,?,?,?,?)
    ";
    $arrValues2 = array($value['submittal_notification_id'],$value['su_additional_recipient_contact_id'],$value['su_additional_recipient_creator_contact_id'],1,1);
    $db->execute($query2, $arrValues2, MYSQLI_USE_RESULT);     
    $db->free_result();

    echo "<br>Inserted Successfully";   
}

echo "<br>No Submittal data is to update";

// To get rfi details which is not having data in rfi recipient table
$query3 = "
SELECT 
rfinot.`id` as request_for_information_notification_id,
rfi.`rfi_recipient_contact_id` as rfi_additional_recipient_contact_id,
rfi.`rfi_creator_contact_id` as rfi_additional_recipient_creator_contact_id,
rfi.`id`,rfi.`project_id`
FROM `requests_for_information` rfi
INNER JOIN `request_for_information_notifications` rfinot on rfi.`id` = rfinot.`request_for_information_id`
WHERE rfi.`id` IN 
	( SELECT request_for_information_id FROM `request_for_information_notifications` 
		WHERE id NOT IN 
		( SELECT `request_for_information_notification_id` FROM `request_for_information_recipients` 
			WHERE `smtp_recipient_header_type` = 'To' 
			GROUP BY `request_for_information_notification_id`)
	) 
ORDER BY rfinot.`id`
";
$db->execute($query3);
$rfi_array = array();
while ($row = $db->fetch()) {
	$rfi_array[$row['id']] = $row;
}
$db->free_result();

// To insert above result into rfi recipient table and recipient log table
foreach ($rfi_array as $value) {
	$query4 =
    "INSERT INTO `request_for_information_recipients` (`request_for_information_notification_id`,`rfi_additional_recipient_contact_id`,`smtp_recipient_header_type`,`rfi_additional_recipient_creator_contact_id`,`is_to_history`)
    VALUES (?,?,?,?,?)
    ";
    $arrValues4 = array($value['request_for_information_notification_id'],$value['rfi_additional_recipient_contact_id'],'To',$value['rfi_additional_recipient_creator_contact_id'],1);
    $db->execute($query4, $arrValues4, MYSQLI_USE_RESULT);  
    $db->free_result();

    $query5 =
    "INSERT INTO `request_for_information_to_recipients_log` (`request_for_information_notification_id`,`rfi_to_recipient_contact_id`,`rfi_to_recipient_creator_contact_id`,`status`,`history`)
    VALUES (?,?,?,?,?)
    ";
    $arrValues5 = array($value['request_for_information_notification_id'],$value['rfi_additional_recipient_contact_id'],$value['rfi_additional_recipient_creator_contact_id'],1,1);
    $db->execute($query5, $arrValues5, MYSQLI_USE_RESULT);     
    $db->free_result();

    echo "<br>Inserted Successfully";   
}

echo "<br>No RFI data is to update";

?>
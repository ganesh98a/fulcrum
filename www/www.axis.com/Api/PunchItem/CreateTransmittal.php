<?php
$db = DBI::getInstance($database);
$query1 = "SELECT * FROM transmittal_types where transmittal_category='Punch List'";
$db->execute($query1);
while($row1 = $db->fetch())
{
	$val = $row1['id'];
	$category = $row1['transmittal_category'];
}
$RN_transmittalTypeId = $val; // Refer to Transmittal_types table
$category = str_replace(' ', '', $category);
// $db->free_result();
$RN_recipient_contact_id = $RN_params['recipient_contact_id'];
$RN_initiator_contact_id =null;
if(isset($RN_params['initiator_contact_id']) && $RN_params['initiator_contact_id']!= null){
	$RN_initiator_contact_id = $RN_params['initiator_contact_id'];
}

$RN_fileAttachments = null;
if(isset($RN_params['punch_item_id']) && $RN_params['punch_item_id']!=null){
	$RN_punch_item_id = $RN_params['punch_item_id'];
}
if(isset($RN_params['attachments']) && !empty($RN_params['attachments'])){
	$RN_fileAttachments = $RN_params['attachments'];
	$RN_csvPiFileManagerFileIds = $RN_params['attachments'];
	$RN_csvPiFileManagerFileIds = trim($RN_csvPiFileManagerFileIds, " \t\n\r\0\x0B,");
	$RN_fileAttachments = explode(',', $RN_csvPiFileManagerFileIds);
}
$RN_sequence_no = getSequenceNumberForTransmittals($database, $RN_project_id);
$query = "
INSERT INTO transmittal_data
(
	sequence_number,
	transmittal_type_id,
	project_id,
	raised_by,
	mail_to
) 
VALUES
(
	$RN_sequence_no,
	'$RN_transmittalTypeId',
	'$RN_project_id',
	'$RN_currentlyActiveContactId',
	'$RN_recipient_contact_id'
)";
$RN_transmittalId = null;
if($db->execute($query)){
	$RN_transmittalId = $db->insertId; 
	$status = '1';
}
$db->free_result();

/*echo $val = buildPiAsHtmlForTransmittalPdfConversion($database, $RN_user_company_id, $RN_punch_item_id, $RN_currentlyActiveContactId, $RN_fileAttachments);
exit;*/

//function For creating transmittal and sending email
$RN_arrPunchItemId = array();
$RN_arrPunchItemId[] = $RN_punch_item_id;
$Tran_result= punchItemTransmittalAndEmail($database, $RN_user_company_id, $RN_transmittalId, $RN_currentlySelectedProjectName, $RN_project_id, $RN_user_id, $RN_fileAttachments, $RN_recipient_contact_id, $RN_currentlyActiveContactId, 'Punch List', $category, $status, $RN_arrPunchItemId);

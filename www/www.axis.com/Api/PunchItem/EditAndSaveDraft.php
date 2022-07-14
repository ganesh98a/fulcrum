<?php
$RN_status = 200;
if(!isset($RN_params['punch_item_id']) || $RN_params['punch_item_id']==null){
	$RN_status = '400';
	$RN_errorMessage = 'Punch Item Id is required';
}else
if(!isset($RN_params['cost_code_id']) || $RN_params['cost_code_id']==null){
	// $RN_status = '400';
	$RN_errorMessage = 'CostCode is required';
}else
if(!isset($RN_params['initiator_contact_id']) || $RN_params['initiator_contact_id']==null){
	// $RN_status = '400';
	$RN_errorMessage = 'Subcontractor is required';
}else
if(!isset($RN_params['recipient_contact_id']) || $RN_params['recipient_contact_id']==null){
	$RN_status = '400';
	$RN_errorMessage = 'Recipient is required';
}else
if(!isset($RN_params['location_id']) || $RN_params['location_id']==null){
	$RN_status = '400';
	$RN_errorMessage = 'Location id is required';
}else
if(!isset($RN_params['room_id']) || $RN_params['room_id']==null){
	$RN_status = '400';
	$RN_errorMessage = 'Room id is required';
}else
if(!isset($RN_params['due_date']) || $RN_params['due_date']==null){
	$RN_status = '400';
	$RN_errorMessage = 'Due Date is required';
}else
if(!isset($RN_params['description_id']) || $RN_params['description_id']==null){
	$RN_status = '400';
	$RN_errorMessage = 'Description is required';
}else
if(isset($RN_params['description_id']) && $RN_params['description_id']==0 && ($RN_params['description']==null || !isset($RN_params['description']))){
	$RN_status = '400';
	$RN_errorMessage = 'Description is required';
}
if($RN_status == 400){
	$RN_jsonEC['status'] = $RN_status;
	$RN_jsonEC['data'] = null;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = $RN_errorMessage;
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
$RN_punch_item_id = $RN_params['punch_item_id'];
$RN_httpGetInputData = $RN_params;
$RN_db = DBI::getInstance($database);
/* @var $RN_db DBI_mysqli */

// Retrieve all of the $RN__GET inputs automatically for the Submittal record

foreach ($RN_httpGetInputData as $RN_k => $RN_v) {
	if (empty($RN_v)) {
		unset($RN_httpGetInputData[$RN_k]);
	}
}

// $RN_punchItem = new PunchItem($database);
$RN_punchItem = PunchItem::findById($database, $RN_punch_item_id);

$RN_punchItem->setData($RN_httpGetInputData);
$RN_punchItem->convertDataToProperties();

// Due Date
$RN_due_date = $RN_params['due_date'];
$RN_due_date = date('Y-m-d',strtotime($RN_due_date));
$RN_punchItem->due_date = $RN_due_date;
$RN_subcontractorId = $RN_punchItem->recipient_contact_id;
// Begin hacks. Creator contact id
$RN_piCreatorContact = Contact::findContactByIdExtended($database, $RN_currentlyActiveContactId);
$RN_piCreatorContactCompany = $RN_piCreatorContact->getContactCompany();
$RN_pi_creator_contact_company_id = $RN_piCreatorContactCompany->contact_company_id;
$RN_punchItem->creator_contact_id = $RN_currentlyActiveContactId;
$RN_punchItem->creator_contact_company_id = $RN_pi_creator_contact_company_id;

// Begin hacks. recipient contact id
if ($RN_punchItem->initiator_contact_id) {
	$RN_piInitiatorContact = Contact::findContactByIdExtended($database, $RN_punchItem->initiator_contact_id );
	$RN_piInitiatorContactCompany = $RN_piInitiatorContact->getContactCompany();
	$RN_pi_initiator_contact_company_id = $RN_piInitiatorContactCompany->contact_company_id;
	$RN_punchItem->initiator_contact_company_id = $RN_pi_initiator_contact_company_id;	
} else {
	$RN_punchItem->initiator_contact_id = Null;
	$RN_punchItem->initiator_contact_company_id = Null;
}

// Begin hacks. recipient contact id
$RN_piRecipientContact = Contact::findContactByIdExtended($database, $RN_punchItem->recipient_contact_id );
$RN_piRecipientContactCompany = $RN_piRecipientContact->getContactCompany();
$RN_pi_recipient_contact_company_id = $RN_piRecipientContactCompany->contact_company_id;
$RN_punchItem->recipient_contact_company_id = $RN_pi_recipient_contact_company_id;

// get ContractingEntities id
$contract_entity_id = ContractingEntities::getcontractEntityAgainstProject($database, $RN_project_id);

if ($contract_entity_id != null) {
	$RN_punchItem->contracting_entity_id = $contract_entity_id;
}

$RN_punchItem->convertPropertiesToData();
$RN_data = $RN_punchItem->getData();

// Test for existence via standard findByUniqueIndex method
// $RN_punchItem->setKey(null);
$RN_data['created_date'] = null;
if($RN_params['description_id'] == 0){
	$RN_data['description_id'] = 0;
}
$RN_punchItem->setData($RN_data);

// print_r($RN_punchItem);
$RN_message = 'Punch Item Saved Successfully';
$RN_errorMessage = null;
$RN_status = 200;
$RN_punchItem->save();

if($RN_status == 400){
	$RN_jsonEC['status'] = $RN_status;
	$RN_jsonEC['data'] = null;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = $RN_errorMessage;
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}

if(isset($RN_params['attachments']) || !empty($RN_params['attachments'])) {

	$RN_csvPiFileManagerFileIds = $RN_params['attachments'];
	$RN_csvPiFileManagerFileIds = trim($RN_csvPiFileManagerFileIds, " \t\n\r\0\x0B,");
	$RN_arrPiFileManagerFileIds = explode(',', $RN_csvPiFileManagerFileIds);
	foreach ($RN_arrPiFileManagerFileIds as $RN_pi_attachment_file_manager_file_id) {
		$RN_pi_attachment_file_manager_file_id = (int) $RN_pi_attachment_file_manager_file_id;
		if ($RN_pi_attachment_file_manager_file_id == 0) {
			continue;
		}

		$RN_punchItemAttachment = new PunchItemAttachment($database);

		$RN_punchItemAttachment->punch_item_id = $RN_punch_item_id;
		$RN_punchItemAttachment->pi_attachment_file_manager_file_id = $RN_pi_attachment_file_manager_file_id;
		$RN_punchItemAttachment->pi_attachment_source_contact_id = $RN_currentlyActiveContactId;
	// $RN_punchItemAttachment->sort_order = $RN_sort_order;


	// $RN_punchItemAttachment->su_attachment_file_manager_file_id = $RN_su_attachment_file_manager_file_id;

		$RN_punchItemAttachment->convertPropertiesToData();
		$RN_data = $RN_punchItemAttachment->getData();

	// Test for existence via standard findByUniqueIndex method
		$RN_punchItemAttachment->findByUniqueIndex();
		if ($RN_punchItemAttachment->isDataLoaded()) {
					// Error code here
			$RN_errorMessage = 'Punch Item Attachment already exists.';
			$RN_primaryKeyAsString = $RN_punchItemAttachment->getPrimaryKeyAsString();
		} else {
			$RN_punchItemAttachment->setKey(null);
			$RN_punchItemAttachment->setData($RN_data);
			$RN_punch_item_attachment_id = $RN_punchItemAttachment->save();
		}	
		// $RN_punchItemAttachment->save();

		$RN_punchItemAttachment->convertDataToProperties();
		$RN_primaryKeyAsString = $RN_punchItemAttachment->getPrimaryKeyAsString();

		// Output standard formatted error or success message
		if (isset($RN_primaryKeyAsString) && (!empty($RN_primaryKeyAsString))) {
			// Success
			$RN_errorNumber = 0;
			$RN_errorMessage = '';
			$RN_index = false;
			$RN_status = 200;
		} else {
			// Error code here
			$RN_errorNumber = 1;
			$RN_errorMessage = 'Error creating: Punch Item Attachment.';
			$RN_status = 400;
		}
	}
}
if($RN_status == 400){
	$RN_jsonEC['status'] = $RN_status;
	$RN_jsonEC['data'] = null;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = $RN_errorMessage;
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
if($RN_params['draft_flag'] == 'Y') {
	// punch Item list
	$arrPiDetailListTmp = getPunchItemDetails($database, $RN_punch_item_id, $user, $RN_project_id);
	$RN_jsonEC['data']['punch_item']['raw_data'] = $arrPiDetailListTmp;
} else {
	$RN_fileAttachments = null;
	$RN_punchItemIds = array(0=>$RN_punch_item_id);
	$punchItemIds = array();

	foreach($RN_punchItemIds as $key => $RN_punch_item_id){
	// PunchITem get
		$db = DBI::getInstance($database);
		$db->free_result();
		$db->begin();
		$RN_punchItem = PunchItem::findById($database, $RN_punch_item_id);
	//  sequence no
		$RN_nextSuSequenceNumber = PunchItem::findNextPunchItemSequenceNumberWithSubcontractGrouping($database, $RN_project_id, $RN_punchItem->recipient_contact_company_id);

		$RN_oldData = $RN_punchItem->getData();
		$RN_data = array(
			'draft_flag' => 'N',
			'sequence_number' => $RN_nextSuSequenceNumber
		);
		$RN_punchItem->setData($RN_data);
		$RN_punchItem->save();
		$punchItemIds[] = $RN_punch_item_id;
	// include_once('SaveAsPunchItemPDF.php');
		$RN_filemanager_fule_id_pi = SaveAsPDFPunchItem($database, $RN_currentlyActiveContactId, $RN_project_id, $RN_user_company_id, $RN_punch_item_id);

		$arrPunchItemAttachment = PunchItemAttachment::findPunchItemAttachmentByPunchItemId($database, $RN_punch_item_id);
		if(isset($arrPunchItemAttachment) && !empty($arrPunchItemAttachment)){
			$RN_fileAttachments = implode(',',$arrPunchItemAttachment);
		}
	}
// createTransmittal
	include_once('CreateTransmittalFromDraft.php');
}

// exit;
/*response index value init*/
$RN_jsonEC['status'] = $RN_status;
$RN_jsonEC['message'] = $RN_message;
$RN_jsonEC['err_message'] = $RN_errorMessage;

header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);

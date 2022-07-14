<?php
$RN_status = 200;
if(!isset($RN_params['cost_code_id']) || $RN_params['cost_code_id']==null){
	// $RN_status = 400;
	$RN_errorMessage = 'Cost Code Id is required';
}else
if(!isset($RN_params['subcontractor_id']) || $RN_params['subcontractor_id']==null){
	$RN_status = 400;
	$RN_errorMessage = 'Subcontractor Id is required';
}else
if(!isset($RN_params['punch_item_id']) || $RN_params['punch_item_id']==null){
	$RN_status = 400;
	$RN_errorMessage = 'Punch Item Id is required';
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
// $RN_costCodeId = $RN_params['cost_code_id'];
$RN_subcontractorId = $RN_params['subcontractor_id'];

$RN_csvPunchItemIds = $RN_params['punch_item_id'];
$RN_csvPunchItemIds = trim($RN_csvPunchItemIds, " \t\n\r\0\x0B,");
$RN_punchItemIds = explode(',', $RN_csvPunchItemIds);

// Get the punch list using costcode & subcontractor
// $RN_arrPunchLists = PunchItem::loadPunchItemByProjectIdWithCostCodeSubcontractor($database, $RN_project_id, 'Y', $RN_currentlyActiveContactId, true, $RN_costCodeId, $RN_subcontractorId);
$RN_fileAttachments = null;
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
	// get ContractingEntities id
	$contract_entity_id = ContractingEntities::getcontractEntityAgainstProject($database, $RN_project_id);
	if ($contract_entity_id != null) {
		$RN_data = array(
			'draft_flag' => 'N',
			'sequence_number' => $RN_nextSuSequenceNumber,
			'contracting_entity_id' => $contract_entity_id
		);
	}

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

/*response index value init*/
$RN_jsonEC['status'] = $RN_status;
$RN_jsonEC['message'] = 'Punch list saved successfully';
$RN_jsonEC['err_message'] = $RN_errorMessage;

header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);

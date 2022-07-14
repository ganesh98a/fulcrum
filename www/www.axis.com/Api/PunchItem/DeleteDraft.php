<?php
$RN_status = 200;
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

$RN_punchItemId = $RN_params['punch_item_id'];
// find by punch item id
$RN_punchItemDraft = PunchItem::findPunchItemByIdExtended($database, $RN_punchItemId);

if($RN_punchItemDraft){
	$RN_punchItemDraft->delete();
	$RN_status = 200;
	$RN_message = 'Item Deleted Successfully.';
} else {
	$RN_status = 400;
	$RN_message = "record does n't exists ";
}

// Delete Attached Documents
$RN_arrPunchItemAttachment = PunchItemAttachment::findPunchItemAttachmentByPunchItemId($database, $RN_punchItemId);
if($RN_arrPunchItemAttachment){
	$RN_punchItemAttachmentDelete = PunchItemAttachment::deletePunchItemAttachmentByPunchItemId($database, $RN_punchItemId);
	if($RN_punchItemAttachmentDelete){
		$RN_message = 'Item Deleted Successfully.';
	}
}
$RN_jsonEC['status'] = $RN_status;
$RN_jsonEC['message'] = $RN_message;
$RN_jsonEC['data'] = null;

<?php
$RN_status = 200;
if(!isset($RN_params['status_id']) || $RN_params['status_id']==null){
	$RN_status = '400';
	$RN_errorMessage = 'Status id is required';
}

if(!isset($RN_params['punch_item_id']) || $RN_params['punch_item_id']==null){
	$RN_status = '400';
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

$RN_punch_item_id = $RN_params['punch_item_id'];
$RN_status_id = $RN_params['status_id'];
$RN_punchItem = PunchItem::findById($database, $RN_punch_item_id);
$RN_file_manager_file_id = null;
if ($RN_punchItem) {
	$RN_tmpData = $RN_punchItem->getData();
	$RN_data = array(
		'status_id' => $RN_status_id
	);
	// get ContractingEntities id
	$contract_entity_id = ContractingEntities::getcontractEntityAgainstProject($database, $RN_project_id);
	if ($contract_entity_id != null) {
		$RN_data = array(
			'status_id' => $RN_status_id,
			'contracting_entity_id' => $contract_entity_id
		);
	}
	
	$RN_file_manager_file_id = $RN_tmpData['file_manager_file_id'];
	$RN_punchItem->setData($RN_data);
	$RN_punchItem->save();
	$RN_status = 200;
	$RN_errorMessage = '';
	$RN_message = 'Status Updated successfully';
} else {
		// Perhaps trigger an error
	$RN_status = 400;
	$RN_jsonEC['data'] = null;
	$RN_message = null;
	$RN_errorMessage = 'record does not exist.';
}
// update pdf 
if($RN_file_manager_file_id){
	$RN_fileManagerFile = FileManagerFile::findById($database, $RN_file_manager_file_id);
	$RN_basefileUrl = $RN_fileManagerFile->generateUrlBasePath(true);
	$RN_fileManagerFile->delete();
	if (file_exists($RN_basefileUrl)) {
		unlink($RN_basefileUrl);
	}	
}
$RN_filemanager_file_id_pi = SaveAsPDFPunchItem($database, $RN_currentlyActiveContactId, $RN_project_id, $RN_user_company_id, $RN_punch_item_id);

$arrPiDetailListTmp = getPunchItemDetails($database, $RN_punch_item_id, $user, $RN_project_id);
$RN_jsonEC['data']['punch_item']['raw_data'] = $arrPiDetailListTmp;

$RN_jsonEC['status'] = $RN_status;
$RN_jsonEC['err_message'] = $RN_errorMessage;
$RN_jsonEC['message'] = $RN_message;

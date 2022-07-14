<?php
$RN_status = 200;
if(!isset($RN_params['file_manager_file_id']) || $RN_params['file_manager_file_id']==null){
	$RN_status = '400';
	$RN_errorMessage = 'File manager file id is required';
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
$RN_file_manager_file_id = intVal($RN_params['file_manager_file_id']);

if(isset($RN_params['punch_item_id']) || $RN_params['punch_item_id']!=null ){
	
	$punch_item_id = intVal($RN_params['punch_item_id']);
	// Put in findById() or findByUniqueKey() as appropriate
	$punchItemAttachment = PunchItemAttachment::findByPunchItemIdAndPiAttachmentFileManagerFileId($database, $punch_item_id, $RN_file_manager_file_id);
	/* @var $puncItemAttachment SubmittalAttachment */

	if ($punchItemAttachment) {
		$punchItemAttachment->delete();
		$RN_status = 200;
		$RN_errorMessage = '';
		$RN_message = 'Attachment deleted successfully';
	} else {
		// Perhaps trigger an error
		$RN_status = 400;
		$RN_jsonEC['data'] = null;
		$RN_message = null;
		$RN_errorMessage = 'Attachment record does not exist.';
	}
}
// Put in findById() or findByUniqueKey() as appropriate
$RN_fileManagerFile = FileManagerFile::findById($database, $RN_file_manager_file_id);
/* @var $fileManagerFile FileManagerFile */

if ($RN_fileManagerFile) {
	$RN_fileManagerFile->delete();
	$RN_status = 200;
	$RN_errorMessage = '';
	$RN_message = 'Attachment deleted successfully';
} else {
	// Perhaps trigger an error
	$RN_status = 400;
	$RN_jsonEC['data'] = null;
	$RN_message = null;
	$RN_errorMessage = 'File Manager File record does not exist.';
}


$RN_jsonEC['status'] = $RN_status;
$RN_jsonEC['err_message'] = $RN_errorMessage;
$RN_jsonEC['message'] = $RN_message;
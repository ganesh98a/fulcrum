<?php
try {
	$RN_status = 200;
	/*
	* Mandatory params & values
	*/
	if($RN_params['action_item_id']==null || !isset($RN_params['action_item_id'])){
		$RN_status = 400;
		$RN_errorMessage = 'Action item id is required';
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

	$action_item_id = $RN_params['action_item_id'];
	/*
	* Meeting Delete
	*/
	$actionItem = ActionItem::findById($database, $action_item_id);
	if(!isset($actionItem) || empty($actionItem)) {
		$RN_errorMessage = 'Error updateing: Action item not exist';
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['data'] = null;
		header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
		$RN_jsonEC['err_message'] = $RN_errorMessage;
		/*encode the array*/
		$RN_jsonEC = json_encode($RN_jsonEC);
		/*echo the json response*/
		echo $RN_jsonEC;
		exit(0);
	}
	$actionItem->delete();

	/*
	* Attendees Delete
	*/
	$deleteExistContact = ActionItemAssignment::deleteActionItemAssigneeByActionItemId($database, $action_item_id);
	
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['error'] = null;
	$RN_jsonEC['err_message'] = null;
	$RN_jsonEC['message'] = 'Action item deleted successfully';
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}
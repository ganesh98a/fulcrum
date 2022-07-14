<?php
try{
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['err_message'] = "";

	if(!isset($RN_params['action_item_id']) && $RN_params['action_item_id']==null){
		$RN_errorMessage = "Item id is required";		
		$RN_status = 400;
	} 
	// else if(!isset($RN_params['completed_date']) && $RN_params['completed_date']==null){
	// 	$RN_errorMessage = "Item completed date is required";
	// 	$RN_status = 400;
	// } 
	else {
		$RN_action_item_id = $RN_params['action_item_id'];
		if(!isset($RN_params['completed_date']) || $RN_params['completed_date'] == null){
			$RN_action_item_completed_date = date('Y-m-d 00:00:00');
		} else {
			$RN_action_item_completed_date = $RN_params['completed_date'];
		}
		$RN_status = 200;
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
	// get discusstion item id by user
	$RN_itemList = null;
	$RN_action_item_id = intVal($RN_action_item_id);
	
	// Put in findById() or findByUniqueKey() as appropriate
	$RN_actionItem = ActionItem::findById($database, $RN_action_item_id);
	if ($RN_actionItem) {
		$RN_action_item_completed_date = date('Y-m-d', strtotime($RN_action_item_completed_date));
		$RN_data = array('action_item_completed_timestamp' => $RN_action_item_completed_date);
		$RN_actionItem->setData($RN_data);
		$RN_actionItem->save();
		$RN_status = 200;
		$RN_message = 'Updated Successfully';
		$RN_errorMessage = '';
		$RN_itemList = ActionItem::findById($database, $RN_action_item_id);
	} else {
		// Perhaps trigger an error
		$RN_status = 400;
		$RN_errorMessage = 'Record does not exist.';
	}
	
	
	$RN_jsonEC['err_message'] = $RN_errorMessage;
	$RN_jsonEC['message'] = $RN_message;
	$RN_jsonEC['data']['taskList'] = $RN_itemList;
	// print_r($RN_arrDiscussionItemsByProjectUserId);
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
?>

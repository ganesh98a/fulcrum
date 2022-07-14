<?php
try {
	$RN_status = 200;
	/*
	* Mandatory params & values
	*/
	if(!isset($RN_params['discussion_item_title']) || $RN_params['discussion_item_title']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Discussion item title is required';
	}
	if(!isset($RN_params['discussion_item_id']) || $RN_params['discussion_item_id']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Discussion item id is required';
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
	$discussion_item_id = false;
	if(isset($RN_params['discussion_item_id']) && $RN_params['discussion_item_id'] != null)
	{
		$discussion_item_id = $RN_params['discussion_item_id'];
	}

	$RN_httpGetInputData = $RN_params;

	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */
	// Retrieve all of the $RN__GET inputs automatically for the Submittal record
	foreach ($RN_httpGetInputData as $RN_k => $RN_v) {
		if (empty($RN_v)) {
			unset($RN_httpGetInputData[$RN_k]);
		}
	}

	$discussionItem = DiscussionItem::findById($database, $discussion_item_id);
	if(!isset($discussionItem) || empty($discussionItem)) {
		$RN_errorMessage = 'Error updateing: Discussion item not exist';
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
	$discussionItem->setData($RN_httpGetInputData);
	$discussionItem->convertDataToProperties();
	$discussionItem->convertPropertiesToData();
	$data = $discussionItem->getData();
	/*crack the sort_order*/
	if(isset($RN_params['discussion_item_title']) && $RN_params['discussion_item_title'] != null)
	{
		$data['discussion_item_title'] = $RN_httpGetInputData['discussion_item_title'];	
	}
	
	if(!isset($RN_params['discussion_item']) || $RN_params['discussion_item'] == null)
	{
		$data['discussion_item'] = NULL;	
	} else {
		$data['discussion_item'] = $RN_httpGetInputData['discussion_item'];	
	}
	
	if(isset($RN_params['discussion_item_status_id']) && $RN_params['discussion_item_status_id'] != null)
	{
		$data['discussion_item_status_id'] = $RN_httpGetInputData['discussion_item_status_id'];
	}
	// Test for existence via standard findByUniqueIndex method
	$data['created'] = null;
	$discussionItem->setData($data);

	$discussion_item_id = $discussionItem->save();
	if (isset($discussion_item_id) && !empty($discussion_item_id)) {
		$discussionItem->discussion_item_id = $discussion_item_id;
		$discussionItem->setId($discussion_item_id);	
	}

	$discussionItem->convertDataToProperties();
	$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
	// Output standard formatted error or success message
	$primaryKeyAsString = 1;
	if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
		$errorNumber = 0;
	} else {
		// Error code here
		$errorNumber = 1;
		$RN_errorMessage = 'Error updateing: Discussion item.';
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
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['error'] = null;
	$RN_jsonEC['err_message'] = null;
	$RN_jsonEC['message'] = 'Discussion item updated successfully';

} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}
<?php
try {
	$RN_status = 200;
	/*
	* Mandatory params & values
	*/
	if(!isset($RN_params['discussion_item_id']) || $RN_params['discussion_item_id']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Discussion item id is required';
	}else
	if(!isset($RN_params['discussion_item_comment']) || $RN_params['discussion_item_comment']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Discussion item comment is required';
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

	$RN_httpGetInputData = $RN_params;

	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */
	// Retrieve all of the $RN__GET inputs automatically for the Submittal record
	foreach ($RN_httpGetInputData as $RN_k => $RN_v) {
		if (empty($RN_v)) {
			unset($RN_httpGetInputData[$RN_k]);
		}
	}
	$discussionItemComment = new DiscussionItemComment($database);

	$discussionItemComment->setData($RN_httpGetInputData);
	$discussionItemComment->convertDataToProperties();
	$discussionItemComment->created_by_contact_id = $RN_currentlyActiveContactId;
	
	$is_visible_flag = 'Y';
	if(isset($RN_params['is_visible_flag']) && $RN_params['is_visible_flag']=='false'){
		$is_visible_flag = 'N';
	}
	$discussionItemComment->is_visible_flag = $is_visible_flag;

	$discussionItemComment->convertPropertiesToData();
	$data = $discussionItemComment->getData();

			// Test for existence via standard findByUniqueIndex method
	$discussionItemComment->findByUniqueIndex();
	if ($discussionItemComment->isDataLoaded()) {
				// Error code here
		$RN_errorMessage = 'Discussion item comment already exists.';
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['data'] = null;
		header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
		$RN_jsonEC['err_message'] = $RN_errorMessage;
		/*encode the array*/
		$RN_jsonEC = json_encode($RN_jsonEC);
		/*echo the json response*/
		echo $RN_jsonEC;
		exit(0);
	} else {
		$discussionItemComment->setKey(null);
		$data['created'] = date('Y-m-d H:i:s');
		$discussionItemComment->setData($data);
	}

	$discussion_item_comment_id = $discussionItemComment->save();
	if (isset($discussion_item_comment_id) && !empty($discussion_item_comment_id)) {
		$discussionItemComment->discussion_item_comment_id = $discussion_item_comment_id;
		$discussionItemComment->setId($discussion_item_comment_id);
	}

	$discussionItemComment->convertDataToProperties();
	$primaryKeyAsString = $discussionItemComment->getPrimaryKeyAsString();

		// Output standard formatted error or success message
	if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
		// Success
		$errorNumber = 0;
		$errorMessage = '';
	} else {
		// Error code here
		$errorNumber = 1;
		$RN_errorMessage = 'Error creating: Discussion item comment.';
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
	$RN_jsonEC['message'] = 'Discusstion item comment created successfully';

} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}
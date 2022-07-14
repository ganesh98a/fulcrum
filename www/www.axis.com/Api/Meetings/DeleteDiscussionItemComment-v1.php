<?php
try {
	$RN_status = 200;
	/*
	* Mandatory params & values
	*/
	if(!isset($RN_params['discussion_item_comment_id']) || $RN_params['discussion_item_comment_id']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Discussion item comment id is required';
	}else
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

	
	$discussion_item_comment_id = null;
	if(isset($RN_params['discussion_item_comment_id']) && $RN_params['discussion_item_comment_id']!=null){
		$discussion_item_comment_id = $RN_params['discussion_item_comment_id'];
	}
	
	$discussionItemComment = null;
	if($discussion_item_comment_id) {
		$discussionItemComment = DiscussionItemComment::findById($database, $discussion_item_comment_id);
	}	
	if(!$discussionItemComment) {
		$RN_errorMessage = 'Discussion Item Comment not exists.';
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
	$discussionItemComment->delete();
	
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['error'] = null;
	$RN_jsonEC['err_message'] = null;
	$RN_jsonEC['message'] = 'Discusstion item comment deleted successfully';

} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}
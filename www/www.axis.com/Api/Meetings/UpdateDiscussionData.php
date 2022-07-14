<?php
$RN_jsonEC['data'] = null;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['MeetingData'] = null;
$RN_discussion_item_id = null;
$RN_newValue = null;
if(isset($RN_params['meeting_id']) && $RN_params['meeting_id']!=null){
	$RN_meeting_id = $RN_params['meeting_id'];
}
if($RN_meeting_id == null || $RN_meeting_id == ''){
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Meeting Id is Required";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
if(isset($RN_params['active_index']) && $RN_params['active_index']!=null){
	$RN_active_index = $RN_params['active_index'];
}
if($RN_active_index == null || $RN_active_index == ''){
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Active Index Id is Required";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
if(isset($RN_params['sort_order']) && $RN_params['sort_order']!=null){
	$RN_sort_order = $RN_params['sort_order'];
}
if($RN_sort_order == null || $RN_sort_order == ''){
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Sort Order Value is Required";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
// $RN_newValue = $RN_params['new_value'];
$RN_exSortOrder = explode(',',$RN_sort_order);
$RN_DICount = count($RN_exSortOrder);
// Get all discussion items for this project
$RN_arrDiscussionItemsByMeetingId = DiscussionItem::loadDiscussionItemsByMeetingId($database, $RN_meeting_id);
$RN_DIRCount = count($RN_arrDiscussionItemsByMeetingId);
// check the DI count is equal or not if not reload the page
if($RN_DIRCount != $RN_DICount){
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Pls reload the page. your sorting order not saved.";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
$tmpDiscussionTem = array();
$RN_i = 0;
$RN_arrDiscussionItemsByMeetingId = array_values($RN_arrDiscussionItemsByMeetingId);
// foreach ($RN_arrDiscussionItemsByMeetingId as $key => $RN_discussionItem) {
// 	// print_r($RN_discussionItem);
// 	$RN_sortOrder = $RN_discussionItem->sort_order;
// 	$RN_index = $RN_exSortOrder[$RN_i];	
// 	if($RN_exSortOrder[$RN_i] != $RN_sortOrder) {
// 		if($RN_i == 0){
// 			$RN_discussion_item_id = $RN_discussionItem->discussion_item_id;
// 			$Newkey = array_search($RN_active_index, $RN_exSortOrder);
// 			$RN_newValue = ($Newkey-1);
// 		}else{
// 			// down to up sort
// 			$RN_discussion_item_id = $RN_arrDiscussionItemsByMeetingId[$RN_active_index]->discussion_item_id;
// 			$Newkey = array_search($RN_active_index, $RN_exSortOrder);
// 			$RN_newValue = ($Newkey-1);
// 		}
// 		break;
// 	}
// 	$RN_i++;
// }
$RN_discussion_item_id = $RN_arrDiscussionItemsByMeetingId[$RN_active_index]->discussion_item_id;
$Newkey = array_search($RN_active_index, $RN_exSortOrder);
$RN_newValue = ($Newkey);
// echo $RN_discussion_item_id.'-'.$RN_newValue;
// exit;
if($RN_discussion_item_id == null && $RN_newValue == null){
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Sort Order did not change in value";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
// Put in findById() or findByUniqueKey() as appropriate
$RN_discussionItem = DiscussionItem::findById($database, $RN_discussion_item_id);
/* @var $discussionItem DiscussionItem */
$RN_tmpDiItem = array();
$RN_attributeName = 'sort_order';
if ($RN_discussionItem) {
	// Check if the value actually changed
	$RN_existingValue = $RN_discussionItem->$RN_attributeName;
	if ($RN_existingValue === $RN_newValue) {
		$RN_errorNumber = 1;
		$RN_errorMessage = "Discussion Item did not change in value.";
	} else
	{
		$RN_errorNumber = 0;
		$RN_errorMessage = '';
		$RN_message = "Discussion Item Sorted Successfully.";
		$RN_discussionItem->updateSortOrder($database, $RN_newValue);
		$RN_data = array($RN_attributeName => $RN_newValue);
		$RN_discussionItem->setData($RN_data);
		$success = $RN_discussionItem->save();

		// get DI's after update order 
		$RN_arrDiscussionItemsByMeetingId = array();
		$RN_arrDiscussionItemsByMeetingId = DiscussionItem::loadDiscussionItemsByMeetingId($database, $RN_meeting_id);
		$RN_DIRCount = count($RN_arrDiscussionItemsByMeetingId);
		$tmpDiscussionTem = array();
		$RN_i = 0;
		$RN_arrDiscussionItemsByMeetingId = array_values($RN_arrDiscussionItemsByMeetingId);
		foreach ($RN_arrDiscussionItemsByMeetingId as $key => $RN_discussionItem) {
			$RN_discussionItemStatus = $RN_discussionItem->getDiscussionItemStatus();
			/* @var $discussionItemStatus DiscussionItemStatus */
			$RN_discussion_item_status = $RN_discussionItemStatus->discussion_item_status;
			// Encoded Discussion Item Data
			$RN_discussionItem->htmlEntityEscapeProperties();
			$RN_escaped_discussion_item_title = $RN_discussionItem->escaped_discussion_item_title;
			$RN_escaped_discussion_item = $RN_discussionItem->escaped_discussion_item;
			$RN_escaped_discussion_item_nl2br = $RN_discussionItem->escaped_discussion_item_nl2br;
			$tmpDiscussionTem[$RN_i]['id'] =  $RN_discussionItem->discussion_item_id;
			$tmpDiscussionTem[$RN_i]['title'] =  $RN_escaped_discussion_item_title;
			$tmpDiscussionTem[$RN_i]['status'] =  $RN_discussion_item_status;
			$RN_i++;
		}
		$RN_jsonEC['data']['MeetingData']['meetingDetails']['discussion_item']['list'] = array_values($tmpDiscussionTem);
		$RN_jsonEC['data']['MeetingData']['meetingDetails']['discussion_item']['count'] = count($RN_arrDiscussionItemsByMeetingId);
	}
	$RN_primaryKeyAsString = $RN_discussionItem->getPrimaryKeyAsString();
} else {
	// Perhaps trigger an error
	$RN_errorNumber = 1;
	$RN_errorMessage = 'Discussion Item record does not exist.';	
}
if($RN_errorNumber == 1){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = $RN_errorMessage;
}else{
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['message'] = $RN_message;
}

$RN_jsonEC['data']['MeetingData']['meetingDetails']['discussion_item']['id'] = $RN_primaryKeyAsString;
?>

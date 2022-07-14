<?php
$RN_jsonEC['data'] = null;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['MeetingData'] = null;
$RN_discussion_item_id = null;
if(isset($RN_params['discussion_item_id']) && $RN_params['discussion_item_id']!=null){
	$RN_discussion_item_id = $RN_params['discussion_item_id'];
}
if($RN_discussion_item_id == null || $RN_discussion_item_id == ''){
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Discussion Item Id is Required";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
// Get all discussion items for this project
$RN_discussionItem = DiscussionItem::findDiscussionItemByIdExtended($database, $RN_discussion_item_id);
$RN_tmpDiItem = array();
$RN_discussionItemStatus = $RN_discussionItem->getDiscussionItemStatus();
/* @var $discussionItemStatus DiscussionItemStatus */
$RN_discussion_item_status = $RN_discussionItemStatus->discussion_item_status;
/*
$RN_discussionItemStatus->htmlEntityEscapeProperties();
$discussion_item_status_id = $discussionItemStatus->discussion_item_status_id;
$escaped_discussion_item_status = $discussionItemStatus->escaped_discussion_item_status;
*/
// Encoded Discussion Item Data
$RN_discussionItem->htmlEntityEscapeProperties();
$RN_escaped_discussion_item_title = $RN_discussionItem->escaped_discussion_item_title;
$RN_escaped_discussion_item = $RN_discussionItem->escaped_discussion_item;
$RN_escaped_discussion_item_nl2br = $RN_discussionItem->escaped_discussion_item_nl2br;

$RN_tmpDiItem['id'] = $RN_discussion_item_id;
$RN_tmpDiItem['title'] = $RN_escaped_discussion_item_title;
$RN_tmpDiItem['status'] = $RN_discussion_item_status;
// Load all action item for this discussion item

$RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions = new Input();
$RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions->forceLoadFlag = true;
$RN_arrDiscussionItemsToActionItemsByDiscussionItemId = DiscussionItemToActionItem::loadDiscussionItemsToActionItemsByDiscussionItemId($database, $RN_discussion_item_id, $RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions);
$RN_numDiscussionItemsToActionItemsByDiscussionItemId = count($RN_arrDiscussionItemsToActionItemsByDiscussionItemId);
$RN_tmpActionItem = array();
foreach ($RN_arrDiscussionItemsToActionItemsByDiscussionItemId as $key => $RN_discussionItemToActionItem) {
	/* @var $actionItem ActionItem */
	$RN_action_item_id = $RN_discussionItemToActionItem->action_item_id;
	$actionItem = ActionItem::findActionItemByIdExtended($database, $RN_action_item_id);
	$RN_action_item = $actionItem->action_item;
	$RN_sort_order = $actionItem->sort_order;
	$RN_action_item_due_date = $actionItem->action_item_due_date;
	$RN_red_notify_flag = false;
	if ($RN_action_item_due_date == '') {
		$RN_dueDateUneditable = 'N/A';
	} else {
		$RN_dueDateUneditable = date('M j, Y', strtotime($RN_action_item_due_date));
		$current_date = date('M j, Y');
		if(strtotime($RN_dueDateUneditable) == strtotime($current_date)){
			$RN_red_notify_flag = true;
		}
	}
	$RN_action_item_completed_timestamp = $actionItem->action_item_completed_timestamp;
	if ($RN_action_item_completed_timestamp == '0000-00-00 00:00:00' || $RN_action_item_completed_timestamp == null ) {
		$RN_completedDateUneditable = 'N/A';
	} else {
		$RN_completedDateUneditable = date('M j, Y', strtotime($RN_action_item_completed_timestamp));
	}
	$RN_loadActionItemAssignmentsByActionItemIdOptions = new Input();
	$RN_loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
	$RN_arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $RN_action_item_id, $RN_loadActionItemAssignmentsByActionItemIdOptions);
	$tmpActionAssignee = array();
	$RN_notify_flag = false;
	foreach ($RN_arrActionItemAssignmentsByActionItemId as $RN_actionItemAssignment) {
		/* @var $actionItemAssignment ActionItemAssignment */
		$RN_actionItemAssigneeContact = $RN_actionItemAssignment->getActionItemAssigneeContact();
		/* @var $actionItemAssigneeContact Contact */
		$RN_actionItemAssigneeFullName = $RN_actionItemAssigneeContact->getContactFullNameHtmlEscaped();
		$RN_action_item_assignee_contact_id = $RN_actionItemAssigneeContact->contact_id;
		$RN_notify_flag_raw = $RN_actionItemAssignment->notify_flag;
		if($RN_notify_flag_raw == 'Y' && $RN_currentlyActiveContactId == $RN_action_item_assignee_contact_id){
			$RN_notify_flag = true;
		}
		$tmpActionAssignee[] = $RN_actionItemAssigneeFullName;
	}
	if($RN_flagUpdate) {
		//  update action Item flace Once shown
		ActionItemAssignment::UpdateByActionItemUsingContactIdApi($database, $RN_currentlyActiveContactId, $RN_action_item_id);	
	}	

	$RN_tmpActionItem[$key]['id'] = $RN_action_item_id;
	$RN_tmpActionItem[$key]['title'] = $RN_action_item;
	$RN_tmpActionItem[$key]['due_date'] = $RN_dueDateUneditable;
	$RN_tmpActionItem[$key]['completed_date'] = $RN_completedDateUneditable;
	$RN_tmpActionItem[$key]['assignee'] = $tmpActionAssignee;
	$RN_tmpActionItem[$key]['expand'] = false;
	$RN_tmpActionItem[$key]['notify'] = $RN_notify_flag;
	$RN_tmpActionItem[$key]['red_notify'] = $RN_red_notify_flag;
	
}
$RN_jsonEC['data']['MeetingData']['discussion_item'] = $RN_tmpDiItem;
$RN_jsonEC['data']['MeetingData']['discussion_item']['action_item']['list'] = $RN_tmpActionItem;
$RN_jsonEC['data']['MeetingData']['discussion_item']['action_item']['count'] = count($RN_arrDiscussionItemsToActionItemsByDiscussionItemId);

// Get any comments associated with any of these discussion items
$RN_arrDiscussionItemCommentsByDiscussionItemIds = DiscussionItemComment::loadDiscussionItemCommentsByDiscussionItemId($database, $RN_discussion_item_id);
$tmpDiComments = array();
foreach ($RN_arrDiscussionItemCommentsByDiscussionItemIds AS $RN_discussion_item_comment_id => $RN_discussionItemComment) {
	/* @var $discussionItemComment DiscussionItemComment */
	
	$RN_discussionItemComment = DiscussionItemComment::findDiscussionItemCommentByIdExtended($database, $RN_discussion_item_comment_id);

	$RN_discussionItem = $RN_discussionItemComment->getDiscussionItem();
	/* @var $discussionItem DiscussionItem */

	$RN_createdByContact = $RN_discussionItemComment->getCreatedByContact();
	/* @var $createdByContact Contact */

	$RN_commentCreatorContactFullNameHtmlEscaped = $RN_createdByContact->getContactFullNameHtmlEscaped();

			//$commentCreated = $arrComments[$discussion_item_id][$discussion_item_comment_id]['created_date'];
	$RN_created = $RN_discussionItemComment->created;
	if (!isset($RN_created) || $RN_created == '0000-00-00 00:00:00') {
		$RN_commentCreated = null;
		$RN_commentCreatedTime = null;
	} else {
		$RN_createdUnixTimestamp = strtotime($RN_created);
		$RN_commentCreatedDate = date('M j, Y', $RN_createdUnixTimestamp);
		$RN_commentCreatedTime = date('g:ia', $RN_createdUnixTimestamp);
	}

	$RN_is_visible_flag = $RN_discussionItemComment->is_visible_flag;

	$RN_checkboxChecked = '';
	if ($RN_is_visible_flag == 'Y') {
		$RN_checkboxChecked = ' checked';
	}

	$RN_discussionItemComment->htmlEntityEscapeProperties();

	$RN_escaped_discussion_item_comment = $RN_discussionItemComment->escaped_discussion_item_comment;
	$RN_escaped_discussion_item_comment_nl2br = $RN_discussionItemComment->escaped_discussion_item_comment_nl2br;

	$tmpDiComments[$RN_discussion_item_comment_id]['id'] = $RN_discussion_item_comment_id;
	$tmpDiComments[$RN_discussion_item_comment_id]['comment'] = $RN_escaped_discussion_item_comment;
	$tmpDiComments[$RN_discussion_item_comment_id]['created_by'] = $RN_commentCreatorContactFullNameHtmlEscaped;
	$tmpDiComments[$RN_discussion_item_comment_id]['date'] = $RN_commentCreatedDate;
	$tmpDiComments[$RN_discussion_item_comment_id]['time'] = $RN_commentCreatedTime;
	$tmpDiComments[$RN_discussion_item_comment_id]['expand'] = false;
	
}
$RN_jsonEC['data']['MeetingData']['discussion_item']['comments']['list'] = array_values($tmpDiComments);
$RN_jsonEC['data']['MeetingData']['discussion_item']['comments']['count'] = count($RN_arrDiscussionItemCommentsByDiscussionItemIds);
?>

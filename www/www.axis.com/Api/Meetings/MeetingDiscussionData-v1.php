<?php
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
$RN_filter = false;
if($RN_filterType == 'by_completed_task'){
	$RN_filter = true;
}
$RN_rfiFilter = false;
if($RN_filterType == 'by_rfi'){
	$RN_rfiFilter = true;
}
$RN_submittalFilter = false;
if($RN_filterType == 'by_submittals'){
	$RN_submittalFilter = true;
}
$RN_meetingFilter = false;
if($RN_filterType == 'by_meetings'){
	$RN_meetingFilter = true;
}

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
// Where filter by condition
$RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions->whereCondFlag = false;
switch($RN_filterType) {
	case 'by_completed_task':
	$whereCondFlag = true;
	$whereSql = 'AND ( ai.`action_item_completed_timestamp` != \'0000-00-00 00:00:00\' AND ai.`action_item_completed_timestamp` IS NOT NULL)';
	break;
	case 'by_rfi':
	$whereCondFlag = true;
	$whereSql = 'AND ai.`action_item_type_id` = 5 ';
	break;
	case 'by_submittals':
	$whereCondFlag = true;
	$whereSql = 'AND ai.`action_item_type_id` = 7 ';
	break;
	case 'by_meetings':
	$whereCondFlag = true;
	$whereSql = 'AND ai.`action_item_type_id` = 1 ';
	break;
	default:
	$whereCondFlag = false;
	$whereSql = '';
	// $whereCondFlag = true;
	// $whereSql = 'AND ( ai.`action_item_completed_timestamp` = \'0000-00-00 00:00:00\' OR ai.`action_item_completed_timestamp` IS NULL)';
	break;
}
$RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions->whereCondFlag = $whereCondFlag;
$RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions->whereCondQuery = $whereSql;

$RN_arrDiscussionItemsToActionItemsByDiscussionItemId = DiscussionItemToActionItem::loadDiscussionItemsToActionItemsByDiscussionItemIdApi($database, $RN_discussion_item_id, $RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions);
$RN_numDiscussionItemsToActionItemsByDiscussionItemId = count($RN_arrDiscussionItemsToActionItemsByDiscussionItemId);
$RN_tmpActionItem = array();
foreach ($RN_arrDiscussionItemsToActionItemsByDiscussionItemId as $key => $RN_discussionItemToActionItem) {
	/* @var $actionItem ActionItem */
	$RN_action_item_id = $RN_discussionItemToActionItem->action_item_id;
	$actionItem = ActionItem::findActionItemByIdExtended($database, $RN_action_item_id);
	$RN_action_item = $actionItem->action_item;
	$RN_action_item = htmlspecialchars_decode($RN_action_item);
	$RN_action_item = html_entity_decode($RN_action_item, ENT_QUOTES, "UTF-8");
	$RN_sort_order = $actionItem->sort_order;
	$RN_action_item_due_date = $actionItem->action_item_due_date;
	$RN_red_notify_flag = false;
	$RN_action_item_type_id = intVal($actionItem->action_item_type_id);
	$RN_action_item_type_reference_id = intVal($actionItem->action_item_type_reference_id);
	// get the squence number of rfi & submittals
	$sequenceNumber = null;
	switch($RN_action_item_type_id) {
		case 5:
		$RN_arrActionItemsByReferenceId = RequestForInformation::findById($database, $RN_action_item_type_reference_id);
		if($RN_arrActionItemsByReferenceId) {
			$sequenceNumber = $RN_arrActionItemsByReferenceId->rfi_sequence_number;
		}
		break;
		case 7:
		$RN_arrActionItemsByReferenceId = Submittal::findById($database, $RN_action_item_type_reference_id);
		if($RN_arrActionItemsByReferenceId) {
			$sequenceNumber = $RN_arrActionItemsByReferenceId->su_sequence_number;
		}
		break;
		default:
		break;
	}
	if ($RN_action_item_due_date == '') {
		$RN_dueDateUneditable = 'N/A';
		$RN_action_item_due_date = date('m/d/Y');
	} else {
		$RN_dueDateUneditable = date('M j, Y', strtotime($RN_action_item_due_date));
		$current_date = date('M j, Y');
		if(strtotime($RN_dueDateUneditable) == strtotime($current_date)){
			$RN_red_notify_flag = true;
		}
		$RN_action_item_due_date = date('m/d/Y', strtotime($RN_action_item_due_date));
	}
	$RN_action_item_completed_timestamp = $actionItem->action_item_completed_timestamp;

	if ($RN_action_item_completed_timestamp == '0000-00-00 00:00:00' || $RN_action_item_completed_timestamp == null ) {
		$RN_completedDateUneditable = 'N/A';
		$RN_action_item_completed_timestamp = date('m/d/Y');
	} else {
		$RN_completedDateUneditable = date('M j, Y', strtotime($RN_action_item_completed_timestamp));
		$RN_action_item_completed_timestamp = date('m/d/Y', strtotime($RN_action_item_completed_timestamp));
	}
	$RN_loadActionItemAssignmentsByActionItemIdOptions = new Input();
	$RN_loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
	$RN_arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $RN_action_item_id, $RN_loadActionItemAssignmentsByActionItemIdOptions);
	$tmpActionAssignee = array();
	$RN_notify_flag = false;
	$AIindex = 0;
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
		$tmpActionAssignee[$AIindex]['name'] = $RN_actionItemAssigneeFullName;
		$tmpActionAssignee[$AIindex]['id'] = $RN_action_item_assignee_contact_id;
		$AIindex++;
	}
	if($RN_flagUpdate) {
		//  update action Item flace Once shown
		ActionItemAssignment::UpdateByActionItemUsingContactIdApi($database, $RN_currentlyActiveContactId, $RN_action_item_id);	
	}	

	$RN_tmpActionItem[$key]['id'] = $RN_action_item_id;
	$RN_tmpActionItem[$key]['title'] = $RN_action_item;
	$RN_tmpActionItem[$key]['due_date_display'] = $RN_dueDateUneditable;
	$RN_tmpActionItem[$key]['due_date'] = $RN_action_item_due_date;
	$RN_tmpActionItem[$key]['completed_date_display'] = $RN_completedDateUneditable;
	$RN_tmpActionItem[$key]['completed_date'] = $RN_action_item_completed_timestamp;
	$RN_tmpActionItem[$key]['action_item_type_id'] = $RN_action_item_type_id;	
	$RN_tmpActionItem[$key]['assignee'] = $tmpActionAssignee;
	$RN_tmpActionItem[$key]['expand'] = false;
	$RN_tmpActionItem[$key]['notify'] = $RN_notify_flag;
	$RN_tmpActionItem[$key]['red_notify'] = $RN_red_notify_flag;
	$RN_tmpActionItem[$key]['action_item_sequence_number'] = $sequenceNumber;
	$RN_tmpActionItem[$key]['action_item_type_reference_id'] = $RN_action_item_type_reference_id;
	

	
}
$RN_jsonEC['data']['meetingData']['action_item']['list'] = $RN_tmpActionItem;
$RN_jsonEC['data']['meetingData']['action_item']['count'] = count($RN_tmpActionItem);

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
	$RN_is_visible_flag = $RN_discussionItemComment->is_visible_flag;
	
	if($RN_is_visible_flag == 'Y') {
		$RN_is_visible_flag = true;
	} else {
		$RN_is_visible_flag = false;
	}

	if (!isset($RN_created) || $RN_created == '0000-00-00 00:00:00') {
		$RN_commentCreated = null;
		$RN_commentCreatedTime = null;
	} else {
		$RN_createdUnixTimestamp = strtotime($RN_created);
		$RN_commentCreatedDate = date('M j, Y', $RN_createdUnixTimestamp);
		$RN_commentCreatedTime = date('g:ia', $RN_createdUnixTimestamp);
	}

	// $RN_is_visible_flag = $RN_discussionItemComment->is_visible_flag;

	// $RN_checkboxChecked = '';
	// if ($RN_is_visible_flag == 'Y') {
	// 	$RN_checkboxChecked = ' checked';
	// }

	$RN_discussionItemComment->htmlEntityEscapeProperties();

	$RN_escaped_discussion_item_comment = $RN_discussionItemComment->escaped_discussion_item_comment;
	$RN_escaped_discussion_item_comment_nl2br = $RN_discussionItemComment->escaped_discussion_item_comment_nl2br;

	$tmpDiComments[$RN_discussion_item_comment_id]['id'] = $RN_discussion_item_comment_id;
	$tmpDiComments[$RN_discussion_item_comment_id]['comment'] = $RN_escaped_discussion_item_comment;
	$tmpDiComments[$RN_discussion_item_comment_id]['is_visible_flag'] = $RN_is_visible_flag;
	$tmpDiComments[$RN_discussion_item_comment_id]['created_by'] = $RN_commentCreatorContactFullNameHtmlEscaped;
	$tmpDiComments[$RN_discussion_item_comment_id]['date'] = $RN_commentCreatedDate;
	$tmpDiComments[$RN_discussion_item_comment_id]['time'] = $RN_commentCreatedTime;
	$tmpDiComments[$RN_discussion_item_comment_id]['expand'] = false;
	
}
$RN_jsonEC['data']['meetingData']['comments']['list'] = array_values($tmpDiComments);
$RN_jsonEC['data']['meetingData']['comments']['count'] = count($tmpDiComments);

/* Filter Values */
$filterArr = array();
$filterArr[0]['id'] = 'by_completed_task';
$filterArr[0]['name'] = 'Filter By Completed Task';
$filterArr[1]['id'] = 'by_rfi';
$filterArr[1]['name'] = 'Filter By RFIs Task';
$filterArr[2]['id'] = 'by_submittals';
$filterArr[2]['name'] = 'Filter By Submittal Task';
$filterArr[3]['id'] = 'by_meetings';
$filterArr[3]['name'] = 'Filter By General Task';
$RN_jsonEC['data']['meetingData']['filter']['filter_type'] = $filterArr;
?>

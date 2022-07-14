<?php
try {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['data']['meetingData'] = null;
	// required params
	$RN_status = 200;
	if($RN_params['meeting_id']==null || !isset($RN_params['meeting_id'])){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting id is required';
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
	// Discussion Item
	$RN_meeting_id = $RN_params['meeting_id'];
	// Get all discussion items for this project
	$RN_arrDiscussionItemsByMeetingId = DiscussionItem::loadDiscussionItemsByMeetingId($database, $RN_meeting_id);
	$tmpDiscussionTem = array();
	$tmpDiscussionTemRaw = array();
	foreach ($RN_arrDiscussionItemsByMeetingId as $RN_discussion_item_id => $RN_discussionItem) {
		$RN_discussionItemStatus = $RN_discussionItem->getDiscussionItemStatus();
		/* @var $discussionItemStatus DiscussionItemStatus */
		$RN_discussion_item_status = $RN_discussionItemStatus->discussion_item_status;
		// Encoded Discussion Item Data
		$RN_discussionItem->htmlEntityEscapeProperties();
		$RN_escaped_discussion_item_title = $RN_discussionItem->escaped_discussion_item_title;
		$RN_escaped_discussion_item = $RN_discussionItem->escaped_discussion_item;
		$RN_escaped_discussion_item_nl2br = $RN_discussionItem->escaped_discussion_item_nl2br;
		$tmpDiscussionTemRaw[] = $RN_escaped_discussion_item_title;
		$tmpDiscussionTem[$RN_discussion_item_id]['id'] =  $RN_discussion_item_id;
		$tmpDiscussionTem[$RN_discussion_item_id]['title'] =  $RN_escaped_discussion_item_title;
		$tmpDiscussionTem[$RN_discussion_item_id]['status'] =  $RN_discussion_item_status;
		$tmpDiscussionTem[$RN_discussion_item_id]['description'] =  $RN_escaped_discussion_item;

		$RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions = new Input();
		$RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions->forceLoadFlag = true;
		$RN_arrDiscussionItemsToActionItemsByDiscussionItemId = DiscussionItemToActionItem::loadDiscussionItemsToActionItemsByDiscussionItemId($database, $RN_discussion_item_id, $RN_loadDiscussionItemsToActionItemsByDiscussionItemIdOptions);
		$RN_red_notify_flag = false;
		$RN_notify_flag = false;
		foreach ($RN_arrDiscussionItemsToActionItemsByDiscussionItemId as $key => $RN_discussionItemToActionItem) {
			/* @var $actionItem ActionItem */
			$RN_action_item_id = $RN_discussionItemToActionItem->action_item_id;
			$actionItem = ActionItem::findActionItemByIdExtended($database, $RN_action_item_id);
			$RN_action_item = $actionItem->action_item;
			$RN_sort_order = $actionItem->sort_order;
			$RN_action_item_due_date = $actionItem->action_item_due_date;
		// $RN_red_notify_flag = false;
			if ($RN_action_item_due_date == '') {
				$RN_dueDateUneditable = 'N/A';
			} else {
				$RN_dueDateUneditable = date('M j, Y', strtotime($RN_action_item_due_date));
				$current_date = date('M j, Y');
				if(strtotime($RN_dueDateUneditable) == strtotime($current_date)){
					$RN_red_notify_flag = true;
				}
			}

			$RN_loadActionItemAssignmentsByActionItemIdOptions = new Input();
			$RN_loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
			$RN_arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $RN_action_item_id, $RN_loadActionItemAssignmentsByActionItemIdOptions);
			// $RN_notify_flag = false;
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
			}
		}

		$tmpDiscussionTem[$RN_discussion_item_id]['notify'] =  $RN_notify_flag;
		$tmpDiscussionTem[$RN_discussion_item_id]['red_notify'] =  $RN_red_notify_flag;
	}
	// print_r($tmpDiscussionTem);
	
	$RN_jsonEC['data']['meetingData']['discussion_item']['list'] = array_values($tmpDiscussionTem);
	$RN_jsonEC['data']['meetingData']['discussion_item']['list_raw'] = array_values($tmpDiscussionTemRaw);
	$RN_jsonEC['data']['meetingData']['discussion_item']['count'] = count($RN_arrDiscussionItemsByMeetingId);
	// Get Rfi open status list
	$openStatus = 'Open';
	$loadRfiByProjectIdAndStatusOptions = new Input();
	$loadRfiByProjectIdAndStatusOptions->forceLoadFlag = true;
	$getRFIOpenList = RequestForInformation::loadRequestsForInformationByRequestForInformationStatusAndProjectId($database, $RN_project_id, $openStatus, $loadRfiByProjectIdAndStatusOptions);
	
	$RN_jsonEC['data']['meetingData']['createDiscusstionData']['open_rfis'] = array_values($getRFIOpenList);

	// Get Open Submittals	
	$loadSuByProjectIdAndStatusOptions = new Input();
	$loadSuByProjectIdAndStatusOptions->forceLoadFlag = true;
	$getSuOpenList = Submittal::loadAllOpenSubmittalsByOpenStatusAndProjectId($database, $RN_project_id, $openStatus, $loadSuByProjectIdAndStatusOptions);
	$RN_jsonEC['data']['meetingData']['createDiscusstionData']['open_submittals'] = array_values($getSuOpenList);
	// Get Action Item assignees
	$meeting = Meeting::findById($database, $RN_meeting_id);
	$meeting_type_id =null;
	if(isset($meeting) && !empty($meeting)) {
		$meeting_type_id = $meeting->meeting_type_id;
	}
	$arrContactOptions = array();
	if($meeting_type_id) {
		$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $RN_project_id, $meeting_type_id);
		foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
			/* @var $contact Contact */
			$contactFullName = $contact->getContactFullName();
			$arrContactOptions[$contact_id]['id'] = $contact_id;
			$arrContactOptions[$contact_id]['name'] = $contactFullName;
		}
	}	
	$RN_jsonEC['data']['meetingData']['createActionItemData']['assignees'] = array_values($arrContactOptions);
	// get default values of tasks & comments
	$tmpDiscussionTem = array_values($tmpDiscussionTem);
	if(isset($tmpDiscussionTem) && !empty($tmpDiscussionTem) && isset($tmpDiscussionTem[0])){
		$RN_params['discussion_item_id'] = $tmpDiscussionTem[0]['id'];
		$RN_jsonEC['data']['meetingData']['discussion_item']['default_discussion_item_id'] = $tmpDiscussionTem[0]['id'];
		$RN_jsonEC['data']['meetingData']['discussion_item']['default_discussion_item_index'] = 0;
		include_once('MeetingDiscussionData-v1.php');
	}
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

} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}


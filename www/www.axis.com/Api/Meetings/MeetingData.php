<?php
$RN_jsonEC['data'] = null;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['MeetingData'] = null;

// Meeting Type dropdown.
$RN_arrMeetingTypes = MeetingType::loadMeetingTypesByProjectId($database, $RN_project_id);
// $RN_jsonEC['data']['MeetingData']['meeting_type'] = $RN_arrMeetingTypes;
$RN_default_meeting_type_id = null;
$RN_tmpDropDown = array();
foreach ($RN_arrMeetingTypes as $RN_tmpMeetingType) {
	/* @var $tmpMeetingType MeetingType */
	$key = $RN_tmpMeetingType->meeting_type_id;
	$RN_tmpDropDown[$key]['type'] = $RN_tmpMeetingType->meeting_type;
	$RN_tmpDropDown[$key]['id'] = $RN_tmpMeetingType->meeting_type_id;

	// Get Notification Flag
	$RN_Notify = Meeting::findNotifyFlagUsingMeetingTypeIdApi($database, $key, $RN_currentlyActiveContactId);
	$RN_notify_flag = $RN_Notify['notify'];
	$RN_red_notify_flag = $RN_Notify['red_notify'];

	$RN_tmpDropDown[$key]['notify'] = $RN_notify_flag;
	$RN_tmpDropDown[$key]['red_notify'] = $RN_red_notify_flag;

	if($RN_notify_flag && !$RN_red_notify_flag){
		$RN_tmpDropDown[$key]['type'] = $RN_tmpDropDown[$key]['type']. ' !';
	}
	if($RN_red_notify_flag){
		$RN_tmpDropDown[$key]['type'] = $RN_tmpDropDown[$key]['type'].' !!';	
	}

	if ($RN_tmpMeetingType->meeting_type == 'Owner Meeting') {
		$RN_defaultMeetingType = $RN_tmpMeetingType;
		/* @var $defaultMeetingType MeetingType */
		$RN_default_meeting_type_id = $RN_defaultMeetingType->meeting_type_id;
	}
}
$RN_jsonEC['data']['MeetingData']['meeting_type']['list'] = array_values($RN_tmpDropDown);
$RN_jsonEC['data']['MeetingData']['meeting_type']['default_meeting_type_id'] = $RN_default_meeting_type_id;

// Get Meetings using Meeting Type
/* 
** Param  $RN_default_meeting_type_id
*/
if($RN_default_meeting_type_id && $RN_meeting_type_id == null){
	$RN_meeting_type_id = $RN_default_meeting_type_id;
}

$RN_meeting_type_id = Data::parseInt($RN_meeting_type_id);

$RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
$RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
$RN_arrMeetingsByProjectIdAndMeetingTypeId = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $RN_project_id, $RN_meeting_type_id, $RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions);
$RN_tmpDropDown = array();
$RN_default_meeting_id = null;
foreach ($RN_arrMeetingsByProjectIdAndMeetingTypeId as $RN_mId => $RN_meeting) {
	/* @var $meeting Meeting */
	$RN_meeting_sequence_number = $RN_meeting->meeting_sequence_number;
	$options = 'Meeting '.$RN_meeting_sequence_number;
	$RN_tmpDropDown[$RN_mId]['type'] = $options;
	$RN_tmpDropDown[$RN_mId]['id'] = $RN_mId;
	// Get Notification Flag
	$RN_Notify = Meeting::findNotifyFlagUsingMeetingIdApi($database, $RN_mId, $RN_currentlyActiveContactId);
	$RN_notify_flag = $RN_Notify['notify'];
	$RN_red_notify_flag = $RN_Notify['red_notify'];

	if($RN_notify_flag && !$RN_red_notify_flag){
		$RN_tmpDropDown[$RN_mId]['type'] = $RN_tmpDropDown[$RN_mId]['type']. ' !';
	}

	if($RN_red_notify_flag){
		$RN_tmpDropDown[$RN_mId]['type'] = $RN_tmpDropDown[$RN_mId]['type'].' !!';	
	}

	$RN_tmpDropDown[$RN_mId]['notify'] = $RN_notify_flag;
	$RN_tmpDropDown[$RN_mId]['red_notify'] = $RN_red_notify_flag;

}
if(isset($RN_tmpDropDown) && !empty($RN_tmpDropDown)){
	$RN_tmpDropDown = array_values($RN_tmpDropDown);
	krsort($RN_tmpDropDown);
	$RN_default_meeting_id = $RN_tmpDropDown[0]['id'];
}
if (count($RN_arrMeetingsByProjectIdAndMeetingTypeId) == 0) {
	$options = 'No Meetings Exist';
	$RN_tmpDropDown[0]['type'] = $options;
	$RN_tmpDropDown[0]['id'] = null;
}
$RN_tmpDropDown = array_values($RN_tmpDropDown);
krsort($RN_tmpDropDown);
$RN_jsonEC['data']['MeetingData']['meetings']['list'] = array_values($RN_tmpDropDown);
$RN_jsonEC['data']['MeetingData']['meetings']['default_meeting_id'] = $RN_default_meeting_id;
// Meeting Details

$RN_arrMeetingAttendeesByMeetingId = array();
$RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
$RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
$RN_arrMeetingsByProjectIdAndMeetingTypeId = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $RN_project_id, $RN_meeting_type_id, $RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions);
$RN_firstMeetingOfThisTypeForThisProject = true;
if (count($RN_arrMeetingsByProjectIdAndMeetingTypeId) > 0) {
	$RN_firstMeetingOfThisTypeForThisProject = false;
}
$RN_arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $RN_project_id, $RN_meeting_type_id);

if($RN_default_meeting_id && $RN_meeting_id == null){
	$RN_meeting_id = $RN_default_meeting_id;
}

$RN_meeting = false;
$RN_nextMeeting = false;
$RN_meetingLocation = false;
$RN_nextMeetingLocation = false;
if ($RN_meeting_id > 0) {
	$RN_meeting = Meeting::loadMeetingPlusNextMeetingById($database, $RN_meeting_id);
	//$nextMeeting = Meeting::loadMeetingPlusNextMeetingById($database, $meeting_id);
	/* @var $nextMeeting Meeting */
	/* @var $meeting Meeting */

	if (!$RN_meeting) {
		$RN_meeting = Meeting::findMeetingByIdExtended($database, $RN_meeting_id);
	}

	$RN_loadMeetingAttendeesByMeetingIdOptions = new Input();
	$RN_loadMeetingAttendeesByMeetingIdOptions->forceLoadFlag = true;
	$RN_arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingId($database, $RN_meeting_id, $RN_loadMeetingAttendeesByMeetingIdOptions);
}

if ($RN_meeting) {
	$RN_previous_meeting_id = $RN_meeting->previous_meeting_id;
	$RN_meeting_sequence_number = $RN_meeting->meeting_sequence_number;

	//$previousMeeting = $meeting->getPreviousMeeting();
	/* @var $previousMeeting Meeting */

	$RN_nextMeeting = $RN_meeting->getNextMeeting();
	/* @var $nextMeeting Meeting */

	$RN_loadMeetingAttendeesByMeetingIdOptions = new Input();
	$RN_loadMeetingAttendeesByMeetingIdOptions->forceLoadFlag = true;
	$RN_arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingId($database, $RN_meeting_id, $RN_loadMeetingAttendeesByMeetingIdOptions);

	$RN_project = $RN_meeting->getProject();
	/* @var $project Project */

	$RN_meetingType = $RN_meeting->getMeetingType();
	/* @var $meetingType MeetingType */

	$RN_meetingLocation = $RN_meeting->getMeetingLocation();
	/* @var $meetingLocation MeetingLocation */

	if ($RN_meetingLocation) {
		$RN_meeting_location_id = $RN_meetingLocation->meeting_location_id;
		$RN_meeting_location = $RN_meetingLocation->meeting_location;
	} else {
		$RN_meeting_location_id = '';
		$RN_meeting_location = '';
	}
	// These will be overridden by actual values below if the $nextMeeting exists
	$RN_next_meeting_location_id = $RN_meeting_location_id;
	$RN_next_meeting_location = $RN_meeting_location;

	if ($RN_meetingType) {
		$RN_meeting_type = $RN_meetingType->meeting_type;
	}

	// $meeting_start_date and $next_meeting_start_date
	$RN_meeting_start_date = $RN_meeting->meeting_start_date;
	if (isset($RN_meeting_start_date) && ($RN_meeting_start_date != '0000-00-00')) {
		$RN_meetingStartDateAsUnixTimestamp = strtotime($RN_meeting_start_date);
		$RN_meetingStartDateDisplay = date('M j, Y', $RN_meetingStartDateAsUnixTimestamp);
		$RN_meeting_start_date = date('m/d/Y', $RN_meetingStartDateAsUnixTimestamp);
		// Set the next meeting start date to $meeting_start_date + 1 week in the future (604800 seconds).
		//$nextMeetingStartDateAsUnixTimestamp = $meetingStartDateAsUnixTimestamp + 604800;
		//$nextMeetingStartDateDisplay = date('M d, Y', $nextMeetingStartDateAsUnixTimestamp);
		//$next_meeting_start_date = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
	} else {
		$RN_meeting_start_date = '';
		$RN_meetingStartDateDisplay = '';
		$RN_next_meeting_start_date = '';
		$RN_nextMeetingStartDateDisplay = '';
	}

	// $meeting_start_time and $next_meeting_start_time
	$RN_meeting_start_time = $RN_meeting->meeting_start_time;
	if (isset($RN_meeting_start_time) && ($RN_meeting_start_time != '00:00:00')) {
		$RN_meetingStartTimeDisplay = date('g:ia', strtotime($RN_meeting_start_time));
		//$next_meeting_start_time = $meeting_start_time;
		//$nextMeetingStartTimeDisplay = $meetingStartTimeDisplay;
	} else {
		$RN_meeting_start_time = '';
		$RN_meetingStartTimeDisplay = '';
		$RN_next_meeting_start_time = '';
		$RN_nextMeetingStartTimeDisplay = '';
	}

	// $meeting_end_date and $next_meeting_end_date
	$RN_meeting_end_date = $RN_meeting->meeting_end_date;
	if (isset($RN_meeting_end_date) && ($RN_meeting_end_date != '0000-00-00')) {
		$RN_meetingEndDateAsUnixTimestamp = strtotime($RN_meeting_end_date);
		$RN_meetingEndDateDisplay = date('M j, Y', $RN_meetingEndDateAsUnixTimestamp);
		$RN_meeting_end_date = date('m/d/Y', $RN_meetingEndDateAsUnixTimestamp);
		// Set the next meeting end date to $meeting_end_date + 1 week in the future (604800 seconds).
		//$nextMeetingEndDateAsUnixTimestamp = $meetingEndDateAsUnixTimestamp + 604800;
		//$nextMeetingEndDateDisplay = date('M d, Y', $nextMeetingEndDateAsUnixTimestamp);
		//$next_meeting_end_date = date('m/d/Y', $nextMeetingEndDateAsUnixTimestamp);
	} else {
		$RN_meetingEndDateDisplay = '';
		$RN_meeting_end_date = '';
		$RN_nextMeetingEndDateDisplay = '';
		$RN_next_meeting_end_date = '';
	}

	// $meeting_end_time and $next_meeting_end_time
	$RN_meeting_end_time = $RN_meeting->meeting_end_time;
	if (isset($RN_meeting_end_time) && ($RN_meeting_end_time != '00:00:00')) {
		$RN_meetingEndTimeDisplay = date('g:ia', strtotime($RN_meeting_end_time));
		//$next_meeting_end_time = $meeting_end_time;
		//$nextMeetingEndTimeDisplay = $meetingEndTimeDisplay;
	} else {
		$RN_meetingEndTimeDisplay = '';
		$RN_meeting_end_time = '';
		$RN_nextMeetingEndTimeDisplay = '';
		$RN_next_meeting_end_time = '';
	}
	if ($RN_meetingType) {
		$RN_meeting_type = $RN_meetingType->meeting_type;
	}
	$RN_meetingHeaderText = $RN_encodedProjectName . ' - ' . $RN_meeting_type . ' ' . $RN_meeting_sequence_number;

	$RN_uniqueId = $RN_meeting_id;
	$RN_attributeGroupName = 'manage-meeting-record';
	$RN_meetingOnChangeJs = ' onchange="updateMeetingHelper(this);"';
	$RN_all_day_event_flag = $RN_meeting->all_day_event_flag;
	if ($RN_all_day_event_flag == 'Y') {
		$RN_meetingAllDayEventFlagChecked = 'checked';
	}
} else {
	$RN_project = false;
	$RN_meetingType = false;
	$RN_meetingLocation = false;
	// There are no meetings at all for this meeting type.
	//$meetingHeaderText = $encodedProjectName . " : New " . $meeting_type . " " . $meeting_sequence_number;
}

if ($RN_nextMeeting) {
			// Override defaults if explicitly set here
	if (isset($RN_nextMeeting->meeting_start_date) && ($RN_nextMeeting->meeting_start_date != '0000-00-00')) {
		$RN_next_meeting_start_date = $RN_nextMeeting->meeting_start_date;
		$RN_nextMeetingStartDateAsUnixTimestamp = strtotime($RN_next_meeting_start_date);
		$RN_nextMeetingStartDateDisplay = date('M j, Y', $RN_nextMeetingStartDateAsUnixTimestamp);
		$RN_next_meeting_start_date = date('m/d/Y', $RN_nextMeetingStartDateAsUnixTimestamp);
	}

	if (isset($RN_nextMeeting->meeting_start_time) && ($RN_nextMeeting->meeting_start_time != '00:00:00')) {
		$RN_next_meeting_start_time = $RN_nextMeeting->meeting_start_time;
		$RN_nextMeetingStartTimeDisplay = date('g:ia', strtotime($RN_next_meeting_start_time));
	}

	if (isset($RN_nextMeeting->meeting_end_date) && ($RN_nextMeeting->meeting_end_date != '0000-00-00')) {
		$RN_next_meeting_end_date = $RN_nextMeeting->meeting_end_date;
		$nextMeetingEndDateAsUnixTimestamp = strtotime($RN_next_meeting_end_date);
		$RN_nextMeetingEndDateDisplay = date('M j, Y', $RN_nextMeetingEndDateAsUnixTimestamp);
		$RN_next_meeting_end_date = date('m/d/Y', $RN_nextMeetingEndDateAsUnixTimestamp);
	}

	if (isset($RN_nextMeeting->meeting_end_time) && ($RN_nextMeeting->meeting_end_time != '00:00:00')) {
		$RN_next_meeting_end_time = $RN_nextMeeting->meeting_end_time;
		$RN_nextMeetingEndTimeDisplay = date('g:ia', strtotime($RN_next_meeting_end_time));
	}

	$RN_nextMeetingLocation = $RN_nextMeeting->getMeetingLocation();
	/* @var $nextMeetingLocation MeetingLocation */

	if ($RN_nextMeetingLocation) {
		$RN_next_meeting_location_id = $RN_nextMeetingLocation->meeting_location_id;
		$RN_next_meeting_location = $RN_nextMeetingLocation->meeting_location;
	}

	$RN_nextMeetingAttributeGroupName = 'manage-next_meeting-record';
	$RN_nextMeetingUniqueId = $RN_nextMeeting->meeting_id;
	$RN_nextMeetingOnChangeJs = ' onchange="updateMeetingHelper(this);"';
	$RN_nextMeetingCreateButton = '';
	$RN_next_all_day_event_flag = $RN_nextMeeting->all_day_event_flag;
	if ($RN_next_all_day_event_flag == 'Y') {
		$RN_nextMeetingAllDayEventFlagChecked = 'checked';
	}
}

// Current Meetinsgs
$RN_jsonEC['data']['MeetingData']['meetingDetails']['current_meeting'] = null;
$tmpCurrentArray = array();
// $tmpCurrentArray['header'] =  $RN_meetingHeaderText;
$tmpCurrentArray['start_date'] =  $RN_meetingStartDateDisplay;
$tmpCurrentArray['start_time'] =  $RN_meetingStartTimeDisplay;
$tmpCurrentArray['end_date'] =  $RN_meetingEndDateDisplay;
$tmpCurrentArray['end_time'] =  $RN_meetingEndTimeDisplay;
$tmpCurrentArray['locations'] =  $RN_meeting_location;

$RN_jsonEC['data']['MeetingData']['meetingDetails']['header'] = $RN_meetingHeaderText;
$RN_jsonEC['data']['MeetingData']['meetingDetails']['current_meeting'] = $tmpCurrentArray;

// Next Meetings
$RN_jsonEC['data']['MeetingData']['meetingDetails']['next_meeting'] = null;
$tmpNxtMeetArray = array();
// $tmpNxtMeetArray['header'] =  $RN_meetingHeaderText;
$tmpNxtMeetArray['start_date'] =  $RN_nextMeetingStartDateDisplay;
$tmpNxtMeetArray['start_time'] =  $RN_nextMeetingStartTimeDisplay;
$tmpNxtMeetArray['end_date'] =  $RN_nextMeetingEndDateDisplay;
$tmpNxtMeetArray['end_time'] =  $RN_nextMeetingEndTimeDisplay;
$tmpNxtMeetArray['locations'] =  $RN_next_meeting_location;

$RN_jsonEC['data']['MeetingData']['meetingDetails']['next_meeting'] = $tmpNxtMeetArray;

// Meeting Attendees
$RN_arrListedContacts = array();
foreach ($RN_arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $RN_contact_id => $RN_contact) {
	$RN_contactFullName = $RN_contact->getContactFullName(true, '(');
	$RN_encodedContactFullName = Data::entity_encode($RN_contactFullName);

	if (!isset($RN_arrListedContacts[$RN_contact_id])) {
		$RN_isCheckedAttribute = "";

		if (array_key_exists($RN_contact_id, $RN_arrMeetingAttendeesByMeetingId)) {
			$RN_arrListedContacts[$RN_contact_id]['name'] = $RN_contactFullName;
			$RN_arrListedContacts[$RN_contact_id]['contact_id'] = $RN_contact_id;
		}

	}
}

$RN_jsonEC['data']['MeetingData']['meetingDetails']['attendees'] = array_values($RN_arrListedContacts);

// Discussion Item
// Get all discussion items for this project
$RN_arrDiscussionItemsByMeetingId = DiscussionItem::loadDiscussionItemsByMeetingId($database, $RN_meeting_id);
$tmpDiscussionTem = array();
foreach ($RN_arrDiscussionItemsByMeetingId as $RN_discussion_item_id => $RN_discussionItem) {
	$RN_discussionItemStatus = $RN_discussionItem->getDiscussionItemStatus();
	/* @var $discussionItemStatus DiscussionItemStatus */
	$RN_discussion_item_status = $RN_discussionItemStatus->discussion_item_status;
	// Encoded Discussion Item Data
	$RN_discussionItem->htmlEntityEscapeProperties();
	$RN_escaped_discussion_item_title = $RN_discussionItem->escaped_discussion_item_title;
	$RN_escaped_discussion_item = $RN_discussionItem->escaped_discussion_item;
	$RN_escaped_discussion_item_nl2br = $RN_discussionItem->escaped_discussion_item_nl2br;
	$tmpDiscussionTem[$RN_discussion_item_id]['id'] =  $RN_discussion_item_id;
	$tmpDiscussionTem[$RN_discussion_item_id]['title'] =  $RN_escaped_discussion_item_title;
	$tmpDiscussionTem[$RN_discussion_item_id]['status'] =  $RN_discussion_item_status;

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
$RN_jsonEC['data']['MeetingData']['meetingDetails']['discussion_item']['list'] = array_values($tmpDiscussionTem);
$RN_jsonEC['data']['MeetingData']['meetingDetails']['discussion_item']['count'] = count($RN_arrDiscussionItemsByMeetingId);

if (count($RN_arrDiscussionItemsByMeetingId) > 0) {
	$RN_status = null;
}else {
	if ($RN_meeting_id == -2) {
		$RN_status = 'No meetings exist for this meeting type';
	} else {
		$RN_status = 'This project does not have any discussion items for this meeting';
	}
}
$RN_jsonEC['data']['MeetingData']['meetingDetails']['discussion_item']['status'] = $RN_status;

?>

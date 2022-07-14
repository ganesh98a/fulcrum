<?php
try {
	$RN_jsonEC['status'] = 200;
	/* 
	 * Meeting Type dropdown 
	 */
	$RN_arrMeetingTypes = MeetingType::loadMeetingTypesByProjectIdApi($database, $RN_project_id);
	$RN_jsonEC['data']['meetingData']['createList']['meetingTypes'] = array_values($RN_arrMeetingTypes);
	$RN_arrMeetingTypes = array_values($RN_arrMeetingTypes);
	$RN_meeting_type_id = $RN_meetingTypeId;
	if(isset($RN_arrMeetingTypes) && isset($RN_arrMeetingTypes[0]) && $RN_meetingTypeId == null) {
		$RN_meeting_type_id = $RN_arrMeetingTypes[0]['meeting_type_id'];
	}
	/*
	* Get previous meeting data
	*/
	$meetingDateDisplay = date('M j, Y');
	$meeting_start_date = date('m/d/Y');
	$meeting_end_date = date('m/d/Y');
	$meetingTimeDisplay = date('g:i a');
	$meeting_start_time = date('g:i a');
	$meeting_start_time_iso = date('Y-m-d\TH:i:s');
	$meeting_end_time = date('g:i a', strtotime("+1 hours"));
	$meeting_end_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_end_time));
	// Set the next meeting start date to $meeting_start_date + 1 week in the future (604800 seconds).
	$meetingStartDateAsUnixTimestamp = strtotime($meeting_start_date);
	$nextMeetingStartDateAsUnixTimestamp = $meetingStartDateAsUnixTimestamp + 604800;
	// Set the next meeting end date to $meeting_end_date + 1 week in the future (604800 seconds).
	$meetingEndDateAsUnixTimestamp = strtotime($meeting_end_date);
	$nextMeetingEndDateAsUnixTimestamp = $meetingEndDateAsUnixTimestamp + 604800;

	$nextMeetingDateDisplay = date('M j, Y', $nextMeetingStartDateAsUnixTimestamp);
	$next_meeting_start_date = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
	$next_meeting_end_date = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
	$nextMeetingTimeDisplay = $meetingTimeDisplay;
	$next_meeting_start_time = $meeting_start_time;
	$next_meeting_start_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_start_time));
	$next_meeting_end_time = $meeting_end_time;
	$next_meeting_end_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_end_time));
	$meeting_location = null;
	$meeting_location_id = null;
	$next_meeting_location = null;
	$next_meeting_location_id = null;
	$meeting = false;
	if($RN_meeting_type_id != null) {

		$meeting = Meeting::loadHiddenNextMeetingByMeetingTypeId($database, $RN_meeting_type_id);
	}
	if($meeting) {
		$meeting_id = $meeting->meeting_id;

		$previousMeeting = $meeting->getPreviousMeeting();
		/* @var $previousMeeting Meeting */
		$nextMeeting = $meeting->getNextMeeting();
		/* @var $nextMeeting Meeting */

		if ($previousMeeting) {
			$loadMeetingAttendeesByMeetingIdOptions = new Input();
			$loadMeetingAttendeesByMeetingIdOptions->forceLoadFlag = true;
			$arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingId($database, $previousMeeting->meeting_id, $loadMeetingAttendeesByMeetingIdOptions);
		}

		$meetingLocation = $meeting->getMeetingLocation();
		/* @var $meetingLocation MeetingLocation */
		if ($meetingLocation) {
			$meeting_location_id = $meetingLocation->meeting_location_id;
			$meeting_location = $meetingLocation->meeting_location;
		} else {
			$meeting_location_id = '';
			$meeting_location = '';
		}

		// These will be overridden by actual values below if the $nextMeeting exists
		$next_meeting_location_id = $meeting_location_id;
		$next_meeting_location = $meeting_location;

		$meeting_start_date = $meeting->meeting_start_date;
		if (isset($meeting_start_date) && ($meeting_start_date != '0000-00-00')) {
			$meetingStartDateAsUnixTimestamp = strtotime($meeting_start_date);
			$meetingDateDisplay = date('M j, Y', $meetingStartDateAsUnixTimestamp);
			$meeting_start_date = date('m/d/Y', $meetingStartDateAsUnixTimestamp);
			// Set the next meeting start date to $meeting_start_date + 1 week in the future (604800 seconds).
			$nextMeetingStartDateAsUnixTimestamp = $meetingStartDateAsUnixTimestamp + 604800;
			$nextMeetingDateDisplay = date('M j, Y', $nextMeetingStartDateAsUnixTimestamp);
			$next_meeting_start_date = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
		} else {
			$meeting_start_date = date('Y-m-d');
			$meetingStartDateAsUnixTimestamp = strtotime($meeting_start_date);
			$meetingDateDisplay = date('M j, Y', $meetingStartDateAsUnixTimestamp);
			$meeting_start_date = date('m/d/Y', $meetingStartDateAsUnixTimestamp);
			// Set the next meeting start date to $meeting_start_date + 1 week in the future (604800 seconds).
			$nextMeetingStartDateAsUnixTimestamp = $meetingStartDateAsUnixTimestamp + 604800;
			$nextMeetingDateDisplay = date('M j, Y', $nextMeetingStartDateAsUnixTimestamp);
			$next_meeting_start_date = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
		}
		// $meeting_start_time and $next_meeting_start_time
		$meeting_start_time = $meeting->meeting_start_time;
		if (isset($meeting_start_time) && ($meeting_start_time != '00:00:00')) {
			$meetingTimeDisplay = date('g:i a', strtotime($meeting_start_time));
			$next_meeting_start_time = $meetingTimeDisplay;
			$meeting_start_time = $meetingTimeDisplay;
			$meeting_start_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_start_time));
			$next_meeting_start_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_start_time));
		} else {
			$meeting_start_time = date('h:i:s');
			$meetingTimeDisplay = date('g:i a', strtotime($meeting_start_time));
			$next_meeting_start_time = $meetingTimeDisplay;
			$meeting_start_time = $meetingTimeDisplay;
			$meeting_start_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_start_time));
			$next_meeting_start_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_start_time));
		}
		// $meeting_end_date and $next_meeting_end_date
		$meeting_end_date = $meeting->meeting_end_date;
		if (isset($meeting_end_date) && ($meeting_end_date != '0000-00-00')) {
			$meetingEndDateAsUnixTimestamp = strtotime($meeting_end_date);
			$meetingDateDisplay = date('M j, Y', $meetingEndDateAsUnixTimestamp);
			$meeting_end_date = date('m/d/Y', $meetingEndDateAsUnixTimestamp);
			// Set the next meeting end date to $meeting_end_date + 1 week in the future (604800 seconds).
			$nextMeetingEndDateAsUnixTimestamp = $meetingEndDateAsUnixTimestamp + 604800;
			$nextMeetingDateDisplay = date('M j, Y', $nextMeetingEndDateAsUnixTimestamp);
			$next_meeting_end_date = date('m/d/Y', $nextMeetingEndDateAsUnixTimestamp);
		} else {
			$meeting_end_date = date('Y-m-d');
			$meetingEndDateAsUnixTimestamp = strtotime($meeting_end_date);
			$meetingDateDisplay = date('M j, Y', $meetingEndDateAsUnixTimestamp);
			$meeting_end_date = date('m/d/Y', $meetingEndDateAsUnixTimestamp);
			// Set the next meeting end date to $meeting_end_date + 1 week in the future (604800 seconds).
			$nextMeetingEndDateAsUnixTimestamp = $meetingEndDateAsUnixTimestamp + 604800;
			$nextMeetingDateDisplay = date('M j, Y', $nextMeetingEndDateAsUnixTimestamp);
			$next_meeting_end_date = date('m/d/Y', $nextMeetingEndDateAsUnixTimestamp);
		}
		// $meeting_end_time and $next_meeting_end_time
		$meeting_end_time = $meeting->meeting_end_time;
		if (isset($meeting_end_time) && ($meeting_end_time != '00:00:00')) {
			$meetingTimeDisplay = date('g:i a', strtotime($meeting_end_time));
			$next_meeting_end_time = $meetingTimeDisplay;
			$meeting_end_time = $meetingTimeDisplay;
			$meeting_end_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_end_time));
			$next_meeting_end_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_end_time));
		} else {
			$meeting_end_time = date('h:i:s');
			$meetingTimeDisplay = date('g:i a', strtotime($meeting_end_time));
			$next_meeting_end_time = $meetingTimeDisplay;
			$meeting_end_time = $meetingTimeDisplay;
			$meeting_end_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_end_time));
			$next_meeting_end_time_iso = date('Y-m-d\TH:i:s', strtotime($meeting_end_time));
		}		
	}

	$tmpCurrentArray = array();
	$tmpCurrentArray['start_date'] =  $meeting_start_date;
	$tmpCurrentArray['start_time'] =  $meeting_start_time;
	$tmpCurrentArray['start_time_iso'] =  $meeting_start_time_iso;
	$tmpCurrentArray['end_date'] =  $meeting_end_date;
	$tmpCurrentArray['end_time'] =  $meeting_end_time;
	$tmpCurrentArray['end_time_iso'] =  $meeting_end_time_iso;
	$tmpCurrentArray['location'] =  $meeting_location;
	$tmpCurrentArray['location_id'] =  $meeting_location_id;

	$tmpNxtMeetArray = array();
	$tmpNxtMeetArray['start_date'] =  $next_meeting_start_date;
	$tmpNxtMeetArray['start_time'] =  $next_meeting_start_time;
	$tmpNxtMeetArray['start_time_iso'] =  $next_meeting_start_time_iso;
	$tmpNxtMeetArray['end_date'] =  $next_meeting_end_date;
	$tmpNxtMeetArray['end_time'] =  $next_meeting_end_time;
	$tmpNxtMeetArray['end_time_iso'] =  $next_meeting_end_time_iso;
	$tmpNxtMeetArray['location'] =  $next_meeting_location;
	$tmpNxtMeetArray['location_id'] =  $next_meeting_location_id;
	$RN_jsonEC['data']['meetingData']['createList']['meeting_type_id'] = $RN_meeting_type_id;
	$RN_jsonEC['data']['meetingData']['createList']['currentMeeting'] = $tmpCurrentArray;
	$RN_jsonEC['data']['meetingData']['createList']['nextMeeting'] = $tmpNxtMeetArray;
	/*
	* Meeting Location dropdown
	*/
	$loadMeetingLocationsByUserCompanyIdOptions = new Input();
	$loadMeetingLocationsByUserCompanyIdOptions->forceLoadFlag = true;
	$arrMeeetingLocations = MeetingLocation::loadMeetingLocationsByUserCompanyIdApi($database, $RN_user_company_id, $loadMeetingLocationsByUserCompanyIdOptions);
	$RN_jsonEC['data']['meetingData']['createList']['meetingLocations'] = array_values($arrMeeetingLocations);
	$default_meeting_location = 'Conference Room';
	$arrDefaultMeeetingLocationId = MeetingLocation::findMeetingLocationByUserCompanyIdAndLocation($database, $RN_user_company_id, $default_meeting_location);
	$RN_jsonEC['data']['meetingData']['createList']['default_meeting_location_id'] = $arrDefaultMeeetingLocationId;
	
	// Conference Room
	/*
	* Meeting Attendees
	*/
	$arrListedContacts = array();
	if($RN_meeting_type_id != null) {
		$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $RN_project_id, $RN_meeting_type_id);

		foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
			$isCheckedAttribute = false;
			if (isset($arrMeetingAttendeesByMeetingId[$contact_id])) {
				$isCheckedAttribute = true;
			}
			/* @var $contact Contact */
			$contactFullName = $contact->getContactFullName(true, '(');
			$arrListedContacts[$contact_id]['attendee_contact_id'] = $contact_id;
			$arrListedContacts[$contact_id]['attendee_contact_name'] = $contactFullName;
			$arrListedContacts[$contact_id]['checked'] = $isCheckedAttribute;
		}
	}
	$RN_jsonEC['data']['meetingData']['createList']['meetingAttendees'] = array_values($arrListedContacts);

} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}


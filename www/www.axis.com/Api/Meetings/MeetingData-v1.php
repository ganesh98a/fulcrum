<?php
try {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['data']['meetingData'] = null;
	/*
	* Filter value applies
	*/
	$RN_where = "";
	$RN_status = 200;
	$RN_arrValues = array();
	if((isset($RN_filterType) && $RN_filterType!=null) && (!isset($RN_filterValue) && $RN_filterValue==null)){
		$RN_errorMessage = "Filter by meeting type id should not be null";
		$RN_status = 400;
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
	if($RN_filterType == 'by_meeting_type'){
		if($RN_filterValue == 'All'){
			$RN_where = '';
		}
		else{		
			$RN_where = "\nAND m.`meeting_type_id` = ?";
			$RN_arrValues[] = $RN_filterValue;
		}
	}
	if($RN_filterType == 'by_upcoming_meeting'){
		$minDate = date('Y-m-d');
		$RN_where = "\nAND m.`meeting_start_date` > ?";
		$RN_arrValues[] = $minDate;
	}
	/* Get meetings by project id */
	$RN_arrMeetingsByProjectId = array();
	$RN_loadMeetingsByProjectIdOptions = new Input();
	$RN_loadMeetingsByProjectIdOptions->forceLoadFlag = true;
	$RN_loadMeetingsByProjectIdOptions->whereCause = $RN_where;
	$RN_loadMeetingsByProjectIdOptions->whereCauseValues = $RN_arrValues;
	$RN_loadMeetingsByProjectIdOptions->arrOrderByAttributes = array(
		'm.`id`' => 'DESC'
	);
	$RN_arrMeetingsByProjectId = Meeting::loadAllMeetingsByProjectId($database, $RN_project_id, $RN_loadMeetingsByProjectIdOptions);

	// lazy load calculation
	$RN_per_page = $RN_per_page;
	$RN_total_rows = count($RN_arrMeetingsByProjectId);
	$RN_pages = ceil($RN_total_rows / $RN_per_page);
	$RN_current_page = isset($RN_page) ? $RN_page : 1;
	$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
	$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
	$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
	$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);

	$RN_arrMeetingsByProjectId = array_slice($RN_arrMeetingsByProjectId, $RN_start, $RN_per_page); 
	$arrLazyLoadData = array();
	$arrLazyLoadData['total_row'] = $RN_total_rows;
	$arrLazyLoadData['total_pages'] = $RN_pages;
	$arrLazyLoadData['per_pages'] = $RN_per_page;
	$arrLazyLoadData['from'] = ($RN_start+1);
	$arrLazyLoadData['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
	$arrLazyLoadData['prev_page'] = $RN_prev_page;
	$arrLazyLoadData['current_page'] = $RN_current_page;
	$arrLazyLoadData['next_page'] = $RN_next_page;

	$RN_jsonEC['data']['meetingData'] = $arrLazyLoadData;

	$arrTmp = array();
	// Store the data in array
	foreach ($RN_arrMeetingsByProjectId as $key => $meeting) {
		$RN_meeting_type_id = $meeting->meeting_type_id;
		$RN_meeting_id = $meeting->meeting_id;

		$RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
		$RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
		$RN_arrMeetingsByProjectIdAndMeetingTypeId = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $RN_project_id, $RN_meeting_type_id, $RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions);

		$RN_meeting = Meeting::loadMeetingPlusNextMeetingById($database, $RN_meeting_id);

		if (!$RN_meeting) {
			$RN_meeting = Meeting::findMeetingByIdExtended($database, $RN_meeting_id);
		}

		$RN_meeting_sequence_number = $RN_meeting->meeting_sequence_number;
		$options = 'Meeting '.$RN_meeting_sequence_number;
		$arrTmp[$key]['meeting_id'] = $RN_meeting_id;
		$arrTmp[$key]['meeting'] = $options;		
		// Meeting Type
		$RN_meetingType = $RN_meeting->getMeetingType();
		if ($RN_meetingType) {
			$RN_meeting_type = $RN_meetingType->meeting_type;
		}
		$arrTmp[$key]['meeting_type'] = $RN_meeting_type;
		$arrTmp[$key]['meeting_type_id'] = $RN_meeting_type_id;
		/* 
		 * Meeting Location 
		 */
		$RN_meetingLocation = $RN_meeting->getMeetingLocation();
		/* @var $meetingLocation MeetingLocation */
		if ($RN_meetingLocation) {
			$RN_meeting_location_id = $RN_meetingLocation->meeting_location_id;
			$RN_meeting_location = $RN_meetingLocation->meeting_location;
		} else {
			$RN_meeting_location_id = '';
			$RN_meeting_location = '';
		}
		/*
		 * Meeting date & time start
		 */
		$RN_meeting_start_date = $RN_meeting->meeting_start_date;
		if (isset($RN_meeting_start_date) && ($RN_meeting_start_date != '0000-00-00')) {
			$RN_meetingStartDateAsUnixTimestamp = strtotime($RN_meeting_start_date);
			$RN_meetingStartDateDisplay = date('m/d/Y', $RN_meetingStartDateAsUnixTimestamp);
			$RN_meeting_start_date = date('m/d/Y', $RN_meetingStartDateAsUnixTimestamp);
		} else {
			$RN_meetingStartDateAsUnixTimestamp = null;
			$RN_meeting_start_date = null;
			$RN_meetingStartDateDisplay = null;
		}
		// Meeting Start time
		$RN_meeting_start_time = $RN_meeting->meeting_start_time;
		if (isset($RN_meeting_start_time) && ($RN_meeting_start_time != '00:00:00')) {
			$RN_meetingStartTimeDisplay = date('g:i a', strtotime($RN_meeting_start_time));
			$meeting_start_time_iso = date('Y-m-d\TH:i:s', strtotime($RN_meeting_start_time));
		} else {
			$RN_meetingStartTimeDisplay = '';
			$meeting_start_time_iso = date('Y-m-d\TH:i:s');
		}
		// Meeting end date
		$RN_meeting_end_date = $RN_meeting->meeting_end_date;
		if (isset($RN_meeting_end_date) && ($RN_meeting_end_date != '0000-00-00')) {
			$RN_meetingEndDateAsUnixTimestamp = strtotime($RN_meeting_end_date);
			$RN_meetingEndDateDisplay = date('m/d/Y', $RN_meetingEndDateAsUnixTimestamp);
			$RN_meeting_end_date = date('m/d/Y', $RN_meetingEndDateAsUnixTimestamp);
		} else {
			$RN_meetingEndDateDisplay = '';
			$RN_meeting_end_date = '';
		}
		// Meeing end time
		$RN_meeting_end_time = $RN_meeting->meeting_end_time;
		if (isset($RN_meeting_end_time) && ($RN_meeting_end_time != '00:00:00')) {
			$RN_meetingEndTimeDisplay = date('g:i a', strtotime($RN_meeting_end_time));
			$meeting_end_time_iso = date('Y-m-d\TH:i:s', strtotime($RN_meeting_end_time));
		} else {
			$RN_meetingEndTimeDisplay = '';
			$meeting_end_time_iso = date('Y-m-d\TH:i:s');
		}
		$RN_meetingHeaderText = $RN_encodedProjectName . ' - ' . $RN_meeting_type . ' ' . $RN_meeting_sequence_number;
		$arrTmp[$key]['header'] = $RN_meetingHeaderText;
		$arrTmp[$key]['currentMeeting'] = null;
		
		$tmpCurrentArray = array();
		$tmpCurrentArray['start_date'] =  $RN_meetingStartDateDisplay;
		$tmpCurrentArray['start_time_iso'] =  $meeting_start_time_iso;
		$tmpCurrentArray['start_time'] =  $RN_meetingStartTimeDisplay;
		$tmpCurrentArray['end_date'] =  $RN_meetingEndDateDisplay;
		$tmpCurrentArray['end_time'] =  $RN_meetingEndTimeDisplay;
		$tmpCurrentArray['end_time_iso'] =  $meeting_end_time_iso;
		$tmpCurrentArray['locations'] =  $RN_meeting_location;
		$tmpCurrentArray['location_id'] =  $RN_meeting_location_id;
		
		$arrTmp[$key]['currentMeeting'] = $tmpCurrentArray;
		/* 
		 * Next meeting details
		 */
		$RN_next_meeting_start_date = null;
		$RN_nextMeetingStartDateDisplay = null;
		$RN_next_meeting_start_time = null;
		$RN_nextMeetingStartTimeDisplay = null;
		$RN_nextMeetingEndDateDisplay = null;
		$RN_next_meeting_end_date = null;
		$RN_nextMeetingEndTimeDisplay = null;
		$RN_next_meeting_end_time = null;
		$RN_next_meeting_location_id = null;
		$RN_next_meeting_location = null;
		$next_meeting_start_time_iso = null;
		$next_meeting_end_time_iso = null;
		$RN_nextMeeting = $RN_meeting->getNextMeeting();
		if ($RN_nextMeeting) {
			// Override defaults if explicitly set here
			if (isset($RN_nextMeeting->meeting_start_date) && ($RN_nextMeeting->meeting_start_date != '0000-00-00')) {
				$RN_next_meeting_start_date = $RN_nextMeeting->meeting_start_date;
				$RN_nextMeetingStartDateAsUnixTimestamp = strtotime($RN_next_meeting_start_date);
				$RN_nextMeetingStartDateDisplay = date('m/d/Y', $RN_nextMeetingStartDateAsUnixTimestamp);
				$RN_next_meeting_start_date = date('m/d/Y', $RN_nextMeetingStartDateAsUnixTimestamp);
			}

			if (isset($RN_nextMeeting->meeting_start_time) && ($RN_nextMeeting->meeting_start_time != '00:00:00')) {
				$RN_next_meeting_start_time = $RN_nextMeeting->meeting_start_time;
				$RN_nextMeetingStartTimeDisplay = date('g:i a', strtotime($RN_next_meeting_start_time));
				$next_meeting_start_time_iso = date('Y-m-d\TH:i:s', strtotime($RN_next_meeting_start_time));
			}

			if (isset($RN_nextMeeting->meeting_end_date) && ($RN_nextMeeting->meeting_end_date != '0000-00-00')) {
				$RN_next_meeting_end_date = $RN_nextMeeting->meeting_end_date;
				$RN_nextMeetingEndDateAsUnixTimestamp = strtotime($RN_next_meeting_end_date);
				$RN_nextMeetingEndDateDisplay = date('m/d/Y', $RN_nextMeetingEndDateAsUnixTimestamp);
				$RN_next_meeting_end_date = date('m/d/Y', $RN_nextMeetingEndDateAsUnixTimestamp);
			}

			if (isset($RN_nextMeeting->meeting_end_time) && ($RN_nextMeeting->meeting_end_time != '00:00:00')) {
				$RN_next_meeting_end_time = $RN_nextMeeting->meeting_end_time;
				$RN_nextMeetingEndTimeDisplay = date('g:i a', strtotime($RN_next_meeting_end_time));
				$next_meeting_end_time_iso = date('Y-m-d\TH:i:s', strtotime($RN_nextMeetingEndTimeDisplay));
			}

			$RN_nextMeetingLocation = $RN_nextMeeting->getMeetingLocation();
			/* @var $nextMeetingLocation MeetingLocation */

			if ($RN_nextMeetingLocation) {
				$RN_next_meeting_location_id = $RN_nextMeetingLocation->meeting_location_id;
				$RN_next_meeting_location = $RN_nextMeetingLocation->meeting_location;
			}
		}

		// Next Meetings
		$arrTmp[$key]['nextMeeting'] = null;
		$tmpNxtMeetArray = array();
		$tmpNxtMeetArray['start_date'] =  $RN_nextMeetingStartDateDisplay;
		$tmpNxtMeetArray['start_time'] =  $RN_nextMeetingStartTimeDisplay;
		$tmpNxtMeetArray['start_time_iso'] =  $next_meeting_start_time_iso;
		$tmpNxtMeetArray['end_date'] =  $RN_nextMeetingEndDateDisplay;
		$tmpNxtMeetArray['end_time'] =  $RN_nextMeetingEndTimeDisplay;
		$tmpNxtMeetArray['end_time_iso'] =  $next_meeting_end_time_iso;
		$tmpNxtMeetArray['locations'] =  $RN_next_meeting_location;
		$tmpNxtMeetArray['location_id'] =  $RN_next_meeting_location_id;
		
		$arrTmp[$key]['nextMeeting'] = $tmpNxtMeetArray;
		/*
		* Meeting Attendees
		*/
		$arrTmp[$key]['meetingAttendees'] = null;

		$RN_loadMeetingAttendeesByMeetingIdOptions = new Input();
		$RN_loadMeetingAttendeesByMeetingIdOptions->forceLoadFlag = true;
		$RN_arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingId($database, $RN_meeting_id, $RN_loadMeetingAttendeesByMeetingIdOptions);

		$RN_arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $RN_project_id, $RN_meeting_type_id);

		$RN_arrListedContacts = array();
		foreach ($RN_arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $RN_contact_id => $RN_contact) {
			$RN_contactFullName = $RN_contact->getContactFullName(true, '(');
			$RN_encodedContactFullName = Data::entity_encode($RN_contactFullName);
			if (!isset($RN_arrListedContacts[$RN_contact_id]) && array_key_exists($RN_contact_id, $RN_arrMeetingAttendeesByMeetingId)) {
				$RN_arrListedContacts[$RN_contact_id]['attendee_contact_id'] = $RN_contact_id;
				$RN_arrListedContacts[$RN_contact_id]['attendee_contact_name'] = $RN_contactFullName;
				$RN_arrListedContacts[$RN_contact_id]['checked'] = true;
			}
		}
		$arrTmp[$key]['meetingAttendees'] = $RN_arrListedContacts;
		//  get the count of discussion item reference by meeting id
		$RN_arrDICount = DiscussionItem::loadDiscussionItemCountsByMeetingId($database, $RN_meeting_id);
		$arrTmp[$key]['discussion_item_count'] = $RN_arrDICount;
	}
	$RN_jsonEC['data']['meetingData']['listData'] = array_values($arrTmp);
	/*
	* Filter Type
	*/
	$RN_arrFilterType = array();
	$RN_arrFilterType[0]['id'] = 'by_meeting_type';
	$RN_arrFilterType[0]['name'] = 'Filter By Meeting Type';
	$RN_arrFilterType[1]['id'] = 'by_upcoming_meeting';
	$RN_arrFilterType[1]['name'] = 'Filter By Upcoming Meetings';

	$RN_jsonEC['data']['meetingData']['filter']['filter_types'] = array_values($RN_arrFilterType);

	$RN_arrFilterMT = array();
	$RN_arrFilterMT[0]['meeting_type_id'] = "All";
	$RN_arrFilterMT[0]['meeting_type'] = "All";
	$RN_arrMeetingTypes = MeetingType::loadMeetingTypesByProjectIdApi($database, $RN_project_id);
	$RN_jsonEC['data']['meetingData']['createList']['meetingTypes'] = array_values($RN_arrMeetingTypes);
	$RN_arrFilterMT = array_merge($RN_arrFilterMT, $RN_arrMeetingTypes);
	$RN_arrMeetingTypes = array_values($RN_arrMeetingTypes);
	$RN_jsonEC['data']['meetingData']['filter']['by_meeting_type'] = array_values($RN_arrFilterMT);
	/* 
	* create item data list for meetings
	*/
	include_once('MeetingCreateList-v1.php');
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}


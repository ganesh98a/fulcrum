<?php
try {
	$RN_status = 200;
	/*
	* Mandatory params & values
	*/
	if(!isset($RN_params['meeting_type_id']) || $RN_params['meeting_type_id']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting type id is required';
	}else
	if(!isset($RN_params['meeting_location_id']) || $RN_params['meeting_location_id']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting location id is required';
	}else
	if(!isset($RN_params['meeting_start_date']) || $RN_params['meeting_start_date']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting start date is required';
	}else
	if(!isset($RN_params['meeting_start_time']) || $RN_params['meeting_start_time']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting start time is required';
	}else
	if(!isset($RN_params['meeting_end_date']) || $RN_params['meeting_end_date']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting end date is required';
	}else
	if(!isset($RN_params['meeting_end_time']) || $RN_params['meeting_end_time']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting end time is required';
	}else
	if(!isset($RN_params['next_meeting_location_id']) || $RN_params['next_meeting_location_id']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Next meeting location id is required';
	}else
	if(!isset($RN_params['next_meeting_start_date']) || $RN_params['next_meeting_start_date']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Next Meeting start date is required';
	}else
	if(!isset($RN_params['next_meeting_start_time']) || $RN_params['next_meeting_start_time']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Next Meeting start time is required';
	}else
	if(!isset($RN_params['next_meeting_end_date']) || $RN_params['next_meeting_end_date']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Next Meeting end date is required';
	}else
	if(!isset($RN_params['next_meeting_end_time']) || $RN_params['next_meeting_end_time']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Next Meeting end time is required';
	}else
	if($RN_params['meeting_attendees']==null || !isset($RN_params['meeting_attendees'])){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting Attendees is required';
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
	
	// Convert the format of date and time for current meeting
	$RN_httpGetInputData['meeting_start_date'] = date('Y-m-d',strtotime($RN_httpGetInputData['meeting_start_date']));
	$RN_httpGetInputData['meeting_end_date'] = date('Y-m-d',strtotime($RN_httpGetInputData['meeting_end_date']));
	$RN_httpGetInputData['meeting_start_time'] = date('Y-m-d H:i:00',strtotime($RN_httpGetInputData['meeting_start_time']));
	$RN_httpGetInputData['meeting_end_time'] = date('Y-m-d H:i:00',strtotime($RN_httpGetInputData['meeting_end_time']));

	// Convert the format of date and time for next meeting
	$RN_httpGetInputData['next_meeting_start_date'] = date('Y-m-d',strtotime($RN_httpGetInputData['next_meeting_start_date']));
	$RN_httpGetInputData['next_meeting_end_date'] = date('Y-m-d',strtotime($RN_httpGetInputData['next_meeting_end_date']));
	$RN_httpGetInputData['next_meeting_start_time'] = date('Y-m-d H:i:00',strtotime($RN_httpGetInputData['next_meeting_start_time']));
	$RN_httpGetInputData['next_meeting_end_time'] = date('Y-m-d H:i:00',strtotime($RN_httpGetInputData['next_meeting_end_time']));
	// Get existing meeting if meeting id not null of param
	if(isset($RN_httpGetInputData) && isset($RN_httpGetInputData['meeting_id'])) {
		$meeting_id = $RN_httpGetInputData['meeting_id'];
		$meeting = Meeting::findById($database, $meeting_id);
	} else {
		$meeting = new Meeting($database);	
	}
	$meeting->setData($RN_httpGetInputData);
	$meeting->convertDataToProperties();
	$meeting_type_id = $meeting->meeting_type_id;
	// meeting type id requires
	if (!isset($meeting_type_id)) {
		// Error code here
		$RN_errorMessage = 'Missing meeting type.';
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
	//  Meeting Squence Number
	$nextMeetingSequenceNumberByMeetingTypeId = Meeting::findNextMeetingSequenceNumberByMeetingTypeId($database, $meeting_type_id);
	$meeting->meeting_sequence_number = $nextMeetingSequenceNumberByMeetingTypeId;
	// previous meeting id
	$getPreviousMeetingId = Meeting::findPreviousMeetingIdByMeetingTypeIdAndProjectId($database, $meeting_type_id, $RN_project_id);
	$meeting->convertPropertiesToData();
	$data = $meeting->getData();
	// Indent is one tab out to facilitate diff & merge
	$createFromHidden = false;
	if($getPreviousMeetingId != null && $getPreviousMeetingId != '' ) {
		$createFromHidden = true;
	}	
	if ($createFromHidden) {
		$meeting_id = (int) $getPreviousMeetingId;
		$meeting->meeting_id = $meeting_id;
		$key = array('id' => $meeting_id);
		$meeting->setKey($key);
		$meeting->save();
	} else {
		// Test for existence via standard findByUniqueIndex method
		$meeting->findByUniqueIndex();
		if ($meeting->isDataLoaded()) {
			$meeting_id = (int) $meeting->meeting_id;
			$meeting_sequence_number = (string) $meeting->meeting_sequence_number;
			if (isset($meeting_sequence_number) && !empty($meeting_sequence_number)) {
				// Error code here
				$RN_errorMessage = 'Meeting already exists. Try another location.';
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
				$existingData = $meeting->getData();				
				// Retrieve all of the $_GET inputs automatically for the Meeting record
				$meeting->setData($RN_httpGetInputData);
				$meeting->convertDataToProperties();
				$meeting->meeting_sequence_number = $nextMeetingSequenceNumberByMeetingTypeId;
				$meeting->project_id = $RN_project_id;
				$meeting->convertPropertiesToData();
				$newData = $meeting->getData();
				// Get different between new data and old data of meetings
				$data = Data::deltify($existingData, $newData);
				if (!empty($data)) {
					if ($meeting_id > 0) {
						$key = array('id' => $meeting_id);
						$meeting->setKey($key);
					}
					$meeting->setData($data);
					$save = true;
					$meeting->save();
				} else {
					$RN_errorMessage = 'Error updating: Meeting<br>No Changes In Values';
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

			}
		} else {
			$meeting->setKey(null);
			$data['created'] = null;
			$data['modified_by_contact_id'] = $currentlyActiveContactId;
			$meeting->setData($data);
			$meeting_id = (int) $meeting->save();
		}
	}
	// $createFromHidden = $get->createFromHidden;
	/*
	* Meeting Attendees
	*/
	$csvMeetingAttendees = $RN_httpGetInputData['meeting_attendees'];
	if (isset($meeting_id) && !empty($meeting_id)) {
		$meeting->meeting_id = $meeting_id;
		$meeting->setId($meeting_id);

		if (isset($csvMeetingAttendees) && !empty($csvMeetingAttendees)) {
			$arrMeeetingAttendees = explode(',', $csvMeetingAttendees);
			foreach ($arrMeeetingAttendees as $contact_id) {
				$contact_id = (int) $contact_id;
				$meeetingAttendee = new MeetingAttendee($database);
				$data = array(
					'meeting_id' => $meeting_id,
					'contact_id' => $contact_id
				);
				$meeetingAttendee->setData($data);
				$meeetingAttendee->findByUniqueIndex();
				if (!$meeetingAttendee->isDataLoaded()) {
					$meeetingAttendee->setKey(null);
					$meeetingAttendee->setData($data);
					$meeetingAttendee->save();
				}
			}
		}
	}
	$meeting->convertDataToProperties();
	$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
	// $RN_httpGetInputData['meeting_id'] = $primaryKeyAsString;
	// Save "next" meeting
	if ($RN_httpGetInputData['next_meeting_location_id'] || $RN_httpGetInputData['next_meeting_start_date'] || $RN_httpGetInputData['next_meeting_start_time']) {
		$nextMeeting = Meeting::instantiateOrm($database, 'Meeting', $RN_httpGetInputData, null, null, 'next_');
		/* @var $nextMeeting Meeting */
		$nextMeeting->previous_meeting_id = $meeting->meeting_id;
		$nextMeeting->project_id = $meeting->project_id;
		$nextMeeting->meeting_type_id = $meeting->meeting_type_id;
		$nextMeeting->meeting_chair_contact_id = $meeting->meeting_chair_contact_id;
		$nextMeeting->modified_by_contact_id = $meeting->modified_by_contact_id;
		$nextMeeting->meeting_sequence_number = '';
		$nextMeeting->convertPropertiesToData();
		$nextMeeting['created'] = null;
		$nextMeeting->save();
	}
	$arrTmp = array();
	$key = 0;
	if ($primaryKeyAsString != '' && $primaryKeyAsString != null) {
		$RN_meeting_id = $primaryKeyAsString;
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
	}
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['data']['meetingData'] = $arrTmp;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['error'] = null;
	$RN_jsonEC['err_message'] = null;
	$RN_jsonEC['message'] = 'Meeting created successfully';
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}

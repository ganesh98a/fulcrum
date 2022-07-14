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
	}else
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
	
	if(isset($RN_httpGetInputData) && isset($RN_httpGetInputData['meeting_id'])) {
		$meeting_id = $RN_httpGetInputData['meeting_id'];
		$meeting = Meeting::findById($database, $meeting_id);
	} else {
		$meeting = new Meeting($database);	
	}
	
	$meeting->setData($RN_httpGetInputData);
	$meeting->convertDataToProperties();
	$meeting_type_id = $meeting->meeting_type_id;
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
	// previous meeting id
	$getPreviousMeetingId = Meeting::findPreviousMeetingIdByMeetingTypeIdAndProjectId($database, $meeting_type_id, $RN_project_id);
	// $meeting->previous_meeting_id = $getPreviousMeetingId;	
	$meeting->convertPropertiesToData();
	$data = $meeting->getData();
	// Indent is one tab out to facilitate diff & merge
	$meeting_id = (int) $RN_httpGetInputData['meeting_id'];
	$meeting->meeting_id = $meeting_id;
	$key = array('id' => $meeting_id);
	$meeting->setKey($key);
	$meeting->save();

	/*
	* Meeting Attendees
	*/

	$csvMeetingAttendees = $RN_httpGetInputData['meeting_attendees'];
	if (isset($meeting_id) && !empty($meeting_id)) {
		$meeting->meeting_id = $meeting_id;
		$meeting->setId($meeting_id);
		//  Delete exist mapping
		$deleteAttendees = MeetingAttendee::deleteAttendeesByMeetingId($database, $meeting_id);

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

	// Save "next" meeting
	if ($RN_httpGetInputData['next_meeting_location_id'] || $RN_httpGetInputData['next_meeting_start_date'] || $RN_httpGetInputData['next_meeting_start_time']) {
		$RN_httpGetInputDataNext = array();
		// echo $RN_httpGetInputDataNext['previous_meeting_id'] = $meeting_id;
		$nextMeeting = Meeting::findNextMeetingByProjectIdAndMeetingId($database, $RN_project_id, $meeting_id);
		/* @var $nextMeeting Meeting */
		$RN_httpGetInputDataNext['id'] = $nextMeeting->id;
		$RN_httpGetInputDataNext['meeting_location_id'] = $RN_httpGetInputData['next_meeting_location_id'];
		$RN_httpGetInputDataNext['meeting_start_date'] = $RN_httpGetInputData['next_meeting_start_date'];
		$RN_httpGetInputDataNext['meeting_start_time'] = $RN_httpGetInputData['next_meeting_start_time'];
		$RN_httpGetInputDataNext['meeting_end_date'] = $RN_httpGetInputData['next_meeting_end_date'];
		$RN_httpGetInputDataNext['meeting_end_time'] = $RN_httpGetInputData['next_meeting_end_time'];
		$RN_httpGetInputDataNext['meeting_chair_contact_id'] = $meeting->meeting_chair_contact_id;
		$RN_httpGetInputDataNext['modified_by_contact_id'] = $meeting->modified_by_contact_id;

		$nextMeeting->setData($RN_httpGetInputDataNext);
		$nextMeeting->convertDataToProperties();
		$nextMeeting->convertPropertiesToData();
		$data = $nextMeeting->getData();
	
		$nextMeeting->save();

		$RN_jsonEC['data'] = null;
		$RN_jsonEC['status'] = 200;
		$RN_jsonEC['error'] = null;
		$RN_jsonEC['err_message'] = null;
		$RN_jsonEC['message'] = 'Meeting Updated successfully';
	}
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}

<?php
try {
	$RN_status = 200;
	/*
	* Mandatory params & values
	*/
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

	$meeting_id = $RN_params['meeting_id'];
	/*
	* Meeting Delete
	*/
	$meeting = Meeting::findById($database, $meeting_id);
	$meeting->delete();
	/*
	* Meeting Attendees Delete
	*/
	$deleteAttendees = MeetingAttendee::deleteAttendeesByMeetingId($database, $meeting_id);
	/*
	* Next Meetin Delete
	*/
	$nextMeeting = Meeting::findNextMeetingByProjectIdAndMeetingId($database, $RN_project_id, $meeting_id);
	if(isset($nextMeeting) && isset($nextMeeting->meeting_id)) {
		$meeting = Meeting::findById($database, $nextMeeting->meeting_id);
		$meeting->delete();
	}
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['error'] = null;
	$RN_jsonEC['err_message'] = null;
	$RN_jsonEC['message'] = 'Meeting deleted successfully';
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}
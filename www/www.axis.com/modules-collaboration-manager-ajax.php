<?php
/**
 * Discussion manager.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');
$timer->startTimer();
$_SESSION['timer'] = $timer;

require_once('lib/common/Message.php');
require_once('lib/common/Service/TableService.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('./modules-collaboration-manager-functions.php');

$db = DBI::getInstance($database);

// Get variables needed to enforce permission for a given file.
/* @var $session Session */
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$primary_contact_id = $session->getPrimaryContactId();
if(isset($_GET['pID']) && $_GET['pID']!=''){
	$project_id =$_GET['pID'];
}else{

$project_id = $session->getCurrentlySelectedProjectId();
}
$project_name = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$userRole = $session->getUserRole();
$arrContactOptions = array();

$encodedProjectName = Data::entity_encode($project_name);

// Set permission variables
require_once('app/models/permission_mdl.php');


$userCanViewDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_view');
$userCanCreateDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_add_discussion_item');
$userCanCreateActionItems = checkPermissionForAllModuleAndRole($database,'meetings_add_action_item');
$userCanCreateDiscussionItemComments = checkPermissionForAllModuleAndRole($database,'meetings_add_comment');
$userCanManageMeetings = checkPermissionForAllModuleAndRole($database,'meetings_manage');
$userCanViewMeetingsType1 = checkPermissionForAllModuleAndRole($database,'meetings_type_1');
$userCanViewMeetingsType2 = checkPermissionForAllModuleAndRole($database,'meetings_type_2');
$userCanViewMeetingsType3 = checkPermissionForAllModuleAndRole($database,'meetings_type_3');
$userCanViewMeetingsType4 = checkPermissionForAllModuleAndRole($database,'meetings_type_4');

if($userRole == "global_admin")
{
	$userCanViewDiscussionItems = $userCanCreateDiscussionItems = $userCanCreateActionItems =$userCanCreateDiscussionItemComments = $userCanManageMeetings= $userCanViewMeetingsType1 =$userCanViewMeetingsType2 =$userCanViewMeetingsType3 = $userCanViewMeetingsType4 = 1 ;
}

if ( ( $currentlySelectedProjectUserCompanyId == $user_company_id ) && ( $userRole == "admin" ) ) {
	$projectOwnerAdmin = true;
} else {
	$projectOwnerAdmin = false;
}

$meetingShowElement = '';
$meetingEditElement = '';
$discussionShowElement = '';
$discussionEditElement = '';
$actionShowElement = '';
$actionEditElement = '';

// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

if ($userCanManageMeetings) {
	$meetingShowElement = 'showElement';
	$meetingEditElement = 'editElement';
	$discussionShowElement = 'showElement';
	$discussionEditElement = 'editElement';
	$actionShowElement = 'showElement';
	$actionEditElement = 'editElement';
}
if ($userCanCreateDiscussionItems) {
	$discussionShowElement = 'showElement';
	$discussionEditElement = 'editElement';
}
if ($userCanCreateActionItems) {
	$actionShowElement = 'showElement';
	$actionEditElement = 'editElement';
}

// Start output buffering to prevent output from being echo'd out
ob_start();

switch ($methodCall) {

	case 'loadCreateMeetingDialog':

		$meeting_type_id = Data::parseInt($get->meeting_type_id);

		$attributeGroupName = 'create-meeting-record-modal';
		$uniqueId = Data::generateDummyPrimaryKey();

		// Attempt to load a hidden "next" placeholder meeting if it exists
		// meeting_sequence_number IS NULL for the given meeting_type_id
		if (isset($meeting_type_id) && ($meeting_type_id > 0)) {
			$meeting = Meeting::loadHiddenNextMeetingByMeetingTypeId($database, $meeting_type_id);
			/*
			$loadMeetingsByMeetingTypeIdOptions = new Input();
			$loadMeetingsByMeetingTypeIdOptions->forceLoadFlag = true;
			$arrMeetingsByMeetingTypeId = Meeting::loadMeetingsByMeetingTypeId($database, $meeting_type_id, $loadMeetingsByMeetingTypeIdOptions);
			$loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
			$loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
			//$arrMeetingsByProjectIdAndMeetingTypeId = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id, $loadMeetingsByProjectIdAndMeetingTypeIdOptions);
			$firstMeetingOfThisTypeForThisProject = true;
			if (count($arrMeetingsByMeetingTypeId) > 0) {
				$firstMeetingOfThisTypeForThisProject = false;
			}
			*/

			// @todo eliminate the $project_id input below as is it captured by meeting_types
			$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);
		} else {
			$meeting = false;
			$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = array();
		}
		/* @var $meeting Meeting */
		/* @var $nextMeeting Meeting */

		$meeting_id = -1;
		$meeting_type = '';
		$arrMeetingAttendeesByMeetingId = array();
		$previousMeeting = false;
		$nextMeeting = false;

		$meeting_sequence_number = 1;

		$meeting_location_id = '';
		$meeting_location = '';
		$meeting_start_date = '';
		$meeting_start_time = '';
		$meeting_end_date = '';
		$meeting_end_time = '';
		$meetingDateDisplay = '';
		$meetingTimeDisplay = '';

		$previous_meeting_location_id = '';
		$previous_meeting_location = '';
		$previous_meeting_start_date = '';
		$previous_meeting_start_time = '';
		$previous_meeting_end_date = '';
		$previous_meeting_end_time = '';
		$previousMeetingDateDisplay = '';
		$previousMeetingTimeDisplay = '';

		$next_meeting_location_id = '';
		$next_meeting_location = '';
		$next_meeting_start_date = '';
		$next_meeting_start_time = '';
		$next_meeting_end_date = '';
		$next_meeting_end_time = '';
		$nextMeetingDateDisplay = '';
		$nextMeetingTimeDisplay = '';

		if ($meeting) {
			$meeting_id = $meeting->meeting_id;

			//$meeting_sequence_number = $meeting->meeting_sequence_number;
			// This meeting is the last meeting number + 1
			//$meeting_sequence_number = $meeting_sequence_number + 1;
			// This meeting date time and location should be the "next"_item of the last meeting

			$previousMeeting = $meeting->getPreviousMeeting();
			/* @var $previousMeeting Meeting */

			$nextMeeting = $meeting->getNextMeeting();
			/* @var $nextMeeting Meeting */

			if ($previousMeeting) {
				$loadMeetingAttendeesByMeetingIdOptions = new Input();
				$loadMeetingAttendeesByMeetingIdOptions->forceLoadFlag = true;
				$arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingId($database, $previousMeeting->meeting_id, $loadMeetingAttendeesByMeetingIdOptions);
			}

			$project = $meeting->getProject();
			/* @var $project Project */

			$meetingType = $meeting->getMeetingType();
			/* @var $meetingType MeetingType */

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

			if ($meetingType) {
				$meeting_type = $meetingType->meeting_type;
			}

			// $meeting_start_date and $next_meeting_start_date
			$meeting_start_date = $meeting->meeting_start_date;
			if (isset($meeting_start_date) && ($meeting_start_date != '0000-00-00')) {
				$meetingStartDateAsUnixTimestamp = strtotime($meeting_start_date);
				$meetingDateDisplay = date('M d, Y', $meetingStartDateAsUnixTimestamp);
				$meeting_start_date = date('m/d/Y', $meetingStartDateAsUnixTimestamp);
				// Set the next meeting start date to $meeting_start_date + 1 week in the future (604800 seconds).
				$nextMeetingStartDateAsUnixTimestamp = $meetingStartDateAsUnixTimestamp + 604800;
				//$next_meeting_start_date = strtotime(date('Y-m-d', $meetingStartDateAsUnixTimestamp) . ' +1 week');
				//$meetingStartDateAsUnixTimestamp = strtotime(date('Y-m-d', $meetingStartDateAsUnixTimestamp) . ' +1 week');
				$nextMeetingDateDisplay = date('M d, Y', $nextMeetingStartDateAsUnixTimestamp);
				$next_meeting_start_date = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
			} else {
				$meetingDateDisplay = '';
				$meeting_start_date = '';
				$nextMeetingDateDisplay = '';
				$next_meeting_start_date = '';
			}

			// $meeting_start_time and $next_meeting_start_time
			$meeting_start_time = $meeting->meeting_start_time;
			if (isset($meeting_start_time) && ($meeting_start_time != '00:00:00')) {
				$meetingTimeDisplay = date('g:ia', strtotime($meeting_start_time));
				$next_meeting_start_time = $meeting_start_time;
				$nextMeetingTimeDisplay = $meetingTimeDisplay;
			} else {
				$meeting_start_time = '';
				$meetingTimeDisplay = '';
				$nextMeetingTimeDisplay = '';
				$next_meeting_start_time = '';
			}

			// $meeting_end_date and $next_meeting_end_date
			$meeting_end_date = $meeting->meeting_end_date;
			if (isset($meeting_end_date) && ($meeting_end_date != '0000-00-00')) {
				$meetingEndDateAsUnixTimestamp = strtotime($meeting_end_date);
				$meetingDateDisplay = date('M d, Y', $meetingEndDateAsUnixTimestamp);
				$meeting_end_date = date('m/d/Y', $meetingEndDateAsUnixTimestamp);
				// Set the next meeting end date to $meeting_end_date + 1 week in the future (604800 seconds).
				$nextMeetingEndDateAsUnixTimestamp = $meetingEndDateAsUnixTimestamp + 604800;
				//$next_meeting_end_date = strtotime(date('Y-m-d', $meetingEndDateAsUnixTimestamp) . ' +1 week');
				//$meetingEndDateAsUnixTimestamp = strtotime(date('Y-m-d', $meetingEndDateAsUnixTimestamp) . ' +1 week');
				$nextMeetingDateDisplay = date('M d, Y', $nextMeetingEndDateAsUnixTimestamp);
				$next_meeting_end_date = date('m/d/Y', $nextMeetingEndDateAsUnixTimestamp);
			} else {
				$meetingDateDisplay = '';
				$meeting_end_date = '';
				$nextMeetingDateDisplay = '';
				$next_meeting_end_date = '';
			}

			// $meeting_end_time and $next_meeting_end_time
			$meeting_end_time = $meeting->meeting_end_time;
			if (isset($meeting_end_time) && ($meeting_end_time != '00:00:00')) {
				$meetingTimeDisplay = date('g:ia', strtotime($meeting_end_time));
				$next_meeting_end_time = $meeting_end_time;
				$nextMeetingTimeDisplay = $meetingTimeDisplay;
			} else {
				$meeting_end_time = '';
				$meetingTimeDisplay = '';
				$nextMeetingTimeDisplay = '';
				$next_meeting_end_time = '';
			}

			//$meetingHeaderText = $encodedProjectName . " : New " . $meeting_type . " " . $meeting_sequence_number;
			//$meetingHeaderText = $encodedProjectName . ' : ' . $meeting_type . ' ' . $meeting_sequence_number;

			$uniqueId = $meeting_id;
			$attributeGroupName = 'manage-meeting-record-modal';
			$meetingOnChangeJs = ' onchange="updateMeetingHelper(this,'.$uniqueId.','.$nextMeeting->meeting_id.');"';
		} else {
			$project = false;
			$meetingType = false;
			$meetingLocation = false;

			// There are no meetings at all for this meeting type.

			//$meetingHeaderText = $encodedProjectName . " : New " . $meeting_type . " " . $meeting_sequence_number;

		}

		if ($nextMeeting) {
			// Override defaults if explicitly set here
			$next_meeting_start_date = $nextMeeting->meeting_start_date;
			$next_meeting_start_time = $nextMeeting->meeting_start_time;

			$nextMeetingLocation = $nextMeeting->getMeetingLocation();
			/* @var $nextMeetingLocation MeetingLocation */

			if ($nextMeetingLocation) {
				$next_meeting_location_id = $nextMeetingLocation->meeting_location_id;
				$next_meeting_location = $nextMeetingLocation->meeting_location;
			}
		}

		$ddlMeetingLocationsElementId = $attributeGroupName.'--meetings--meeting_location_id--'.$uniqueId;
		$loadMeetingLocationsByUserCompanyIdOptions = new Input();
		$loadMeetingLocationsByUserCompanyIdOptions->forceLoadFlag = true;
		$arrMeeetingLocations = MeetingLocation::loadMeetingLocationsByUserCompanyId($database, $user_company_id, $loadMeetingLocationsByUserCompanyIdOptions);
		$ddlMeetingLocations = PageComponents::dropDownListFromObjects($ddlMeetingLocationsElementId, $arrMeeetingLocations, 'meeting_location_id', null, 'meeting_location', null, $meeting_location_id, '', 'class="meetingLocations" onchange="setNextMeetingLocation(this);"', '');
		$ddlNextMeetingLocationsElementId = $attributeGroupName.'--meetings--next_meeting_location_id--'.$uniqueId;
		$ddlNextMeetingLocations = PageComponents::dropDownListFromObjects($ddlNextMeetingLocationsElementId, $arrMeeetingLocations, 'meeting_location_id', null, 'meeting_location', null, $next_meeting_location_id, '', 'class="meetingLocations nextMeetingDataCreateCase"', '');

		$arrListedContacts = array();
		$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);
		$meetingAttendeesTableTbody = '';
		$requireAttendees = 'false';
		foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
			/* @var $contact Contact */

			$contactFullName = $contact->getContactFullName(true, '(');
			$encodedContactFullName = Data::entity_encode($contactFullName);

			if (!isset($arrListedContacts[$contact_id])) {
				$isCheckedAttribute = "";
				if (isset($arrMeetingAttendeesByMeetingId[$contact_id])) {
					$isCheckedAttribute = ' checked';
				}
				if ($contact['is_archive'] == 'Y') {
					continue;
				}
				$meetingAttendeeCheckBoxElementId = "$attributeGroupName--meeting_attendees--contact_id--$contact_id";
				$meetingAttendeesTableTbody .= <<<END_HTML_CONTENT

				<tr>
					<td>
						<input id="$meetingAttendeeCheckBoxElementId" class="$attributeGroupName--meetingAttendee" type="checkbox"$isCheckedAttribute value="$contact_id">
						<label for="$meetingAttendeeCheckBoxElementId" style="float: none;">$encodedContactFullName</label>
					</td>
				</tr>
END_HTML_CONTENT;
				$arrListedContacts[$contact_id] = 1;
				$requireAttendees = 'true';
			}
		}

		$loadMeetingTypesByProjectIdOptions = new Input();
		$loadMeetingTypesByProjectIdOptions->forceLoadFlag = true;
		$arrMeetingTypes = MeetingType::loadMeetingTypesBasedOnPermission($database, $project_id, $userCanViewMeetingsType1,$userCanViewMeetingsType2,$userCanViewMeetingsType3,$userCanViewMeetingsType4);
		$ddlMeetingTypesElementId = "ddl--$attributeGroupName--meetings--meeting_type_id--$uniqueId";
		$prependedOption = '<option value="">Please Select A Meeting Type</option>';
		$js = 'onchange="loadCreateMeetingDialog(this);meetingTypeSelectedInCreateMeetingDialog(this);" class="required" style="padding: 4px;"';
		$ddlMeetingTypes = PageComponents::dropDownListFromObjects($ddlMeetingTypesElementId, $arrMeetingTypes, 'meeting_type_id', null, 'meeting_type', '', $meeting_type_id, '', $js, $prependedOption);
		if (count($arrMeetingTypes) == 0) {
			$ddlMeetingTypes = '<select id="'.$ddlMeetingTypesElementId.'"><option value="">No Meeting Types Exist</option></select>';
		}

		$htmlContent = <<<END_HTML_CONTENT

		<div id="container--$attributeGroupName--$uniqueId" class="widgetContainer" style="font-size: 0.9em; border:0;">
			<form id="formCreateMeeting">
				<input id="$attributeGroupName--meetings--meeting_type_id--$uniqueId" type="hidden" value="$meeting_type_id">
				&nbsp;&nbsp;&nbsp;Meeting Type:
				$ddlMeetingTypes
				<br><br>
				<table width="95%">
					<thead class="">
					<tr>
						<th class="textAlignCenter">Meeting Info</th>
						<th class="textAlignCenter" style="min-width: 200px;">Attendees</th>
						<th class="textAlignCenter">Next Meeting Info</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>
							<table class="content" width="100%" cellpadding="5px">
								<tr>
									<td class="textAlignRight verticalAlignMiddle" nowrap>Start Time:</td>
									<td class="textAlignLeft">
										<input type="text" id="$attributeGroupName--meetings--meeting_start_date--$uniqueId" class="datepicker required meetingTime" onchange="changeDataTonext(&apos;$attributeGroupName--meetings--meeting_start_time--$uniqueId&apos;);" value="$meeting_start_date" readonly>
										<input type="text" id="$attributeGroupName--meetings--meeting_start_time--$uniqueId" class="timepicker required meetingTime" style="width: 110px;" onchange="cloneMeetingDataToNextMeeting(this);" value="$meeting_start_time">
									</td>
								</tr>
								<tr>
									<td class="textAlignRight verticalAlignMiddle" nowrap>End Time:</td>
									<td class="textAlignLeft">
										<input type="text" id="$attributeGroupName--meetings--meeting_end_date--$uniqueId" class="datepicker required meetingTime" value="$meeting_end_date" readonly>
										<input type="text" id="$attributeGroupName--meetings--meeting_end_time--$uniqueId" class="timepicker required meetingTime" style="width: 110px;" value="$meeting_end_time">
									</td>
								</tr>
								<tr>
									<td colspan="2" style="padding-left:100px">
END_HTML_CONTENT;

										// <input type="checkbox" id="$attributeGroupName--meetings--all_day_event_flag--$uniqueId" onchange="setNextMeetingAllDayEventFlag(this);">
										// <label style="float: none; padding-right: 70px;" for="$attributeGroupName--meetings--all_day_event_flag--$uniqueId">All Day Event</label>
$htmlContent .= <<<END_HTML_CONTENT

										<a href="javascript:clearMeetingTimes('meetingTime');" style="font-size: 85%; position: relative; top: -8px;">Clear</a>
									</td>
								</tr>
								<tr>
									<td class="textAlignRight verticalAlignMiddle" nowrap>Location:</td>
									<td class="textAlignLeft">
										$ddlMeetingLocations
									</td>
								</tr>
								<tr>
									<td></td>
									<td><a href="javascript:loadManageMeetingLocationsDialogHelper();" style="font-size: 85%; color: #06c;">Manage Meeting Locations</a></td>
								</tr>
							</table>
						</td>
						<td>
							<table id="tableMeetingAttendees" class="content" width="100%" cellpadding="2px">
								<tr>
									<td style="padding-bottom: 10px;">
										<input id="checkboxCheckAll" type="checkbox" onclick="createMeetingToggleAllAttendees(this, '$attributeGroupName');">
										<label for="checkboxCheckAll" style="float: none;">Toggle All</label>
									</td>
								</tr>
								$meetingAttendeesTableTbody
							</table>
						</td>
						<td>
							<table class="content" width="100%" cellpadding="5px">
								<tr>
									<td class="textAlignRight verticalAlignMiddle" nowrap>Next Meeting Start Time:</td>
									<td class="textAlignLeft">
										<input type="text" id="$attributeGroupName--meetings--next_meeting_start_date--$uniqueId" class="datepicker nextMeetingTime nextMeetingDataCreateCase" value="$next_meeting_start_date" readonly>
										<input type="text" id="$attributeGroupName--meetings--next_meeting_start_time--$uniqueId" class="timepicker nextMeetingTime nextMeetingDataCreateCase" style="width: 110px;" value="$next_meeting_start_time">
									</td>
								</tr>
								<tr>
									<td class="textAlignRight verticalAlignMiddle" nowrap>Next Meeting End Time:</td>
									<td class="textAlignLeft">
										<input type="text" id="$attributeGroupName--meetings--next_meeting_end_date--$uniqueId" class="datepicker nextMeetingTime nextMeetingDataCreateCase" value="$next_meeting_end_date" readonly>
										<input type="text" id="$attributeGroupName--meetings--next_meeting_end_time--$uniqueId" class="timepicker nextMeetingTime nextMeetingDataCreateCase" style="width: 110px;" value="$next_meeting_end_time">
									</td>
								</tr>
								<tr>
									<td colspan="2" style="padding-left:190px">
END_HTML_CONTENT;


										// <input type="checkbox" id="$attributeGroupName--meetings--next_all_day_event_flag--$uniqueId" class="nextMeetingDataCreateCase">
										// <label style="float: none; padding-right: 70px;" for="$attributeGroupName--meetings--next_all_day_event_flag--$uniqueId">All Day Event</label>
$htmlContent .= <<<END_HTML_CONTENT

										<a href="javascript:clearMeetingTimes('nextMeetingTime');" style="font-size:85%; position:relative; top:-8px">Clear</a>
									</td>
								</tr>
								<tr>
									<td class="textAlignRight verticalAlignMiddle" nowrap>Next Meeting Location:</td>
									<td class="textAlignLeft">$ddlNextMeetingLocations</td>
								</tr>
								<tr>
									<td></td>
									<td><a href="javascript:loadManageMeetingLocationsDialogHelper();" style="font-size: 85%; color: #06c;">Manage Meeting Locations</a></td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
				</table>
				<div class="textAlignRight">
					<input type="hidden" id="$attributeGroupName--meetings--meeting_id--$uniqueId" value="$meeting_id">
				</div>
			</form>
		</div>
END_HTML_CONTENT;

		$arrOutput = array(
			'htmlContent' => $htmlContent,
			'attributeGroupName' => $attributeGroupName,
			'uniqueId' => $uniqueId,
			'options' => array('requireAttendees' => $requireAttendees)
		);
		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;
	case 'updateMeetingPermission':
		$meeting_type_id = $get->meeting_type_id;
		$role_id = $get->role_id;
		$project_id = $get->project_id;
		$is_check = $get->is_check;

		$meetins = MeetingAttendee::InsertMeetingAttendeesToContact($database,$meeting_type_id,$role_id,$project_id,$is_check);
		if($meetins)
		{
			// To get the meeting id
			$software_module_function_id = MeetingType::GetSoftwareModuleIdForMeeting($database,$meeting_type_id);
			if($software_module_function_id != 0)
			{
			 UpdateProjectSpecificSoftwareFunction($database,$software_module_function_id,$role_id,$is_check,$project_id);
			}
		}
	break;

	case 'resetMeetingPermission':

		// Owner Meetings software_module_functions id
		$ownerMetModuleId = TableService::getSingleField($database,'software_module_functions','id','software_module_function','meetings_type_1');
		// LEED Meetings software_module_functions id
		$leedMetModuleId = TableService::getSingleField($database,'software_module_functions','id','software_module_function','meetings_type_2');
		// Subcontractor Meetings software_module_functions id
		$subcontractMetModuleId = TableService::getSingleField($database,'software_module_functions','id','software_module_function','meetings_type_3');
		// Internal Meetings software_module_functions id
		$internalMetModuleId = TableService::getSingleField($database,'software_module_functions','id','software_module_function','meetings_type_4');

		// Owner Meeting meeting_types id
		$owner_arr = array(); $owner_arr['table'] = 'meeting_types';
		$owner_arr['fields'] = array('id');
		$owner_arr['filter'] = array('project_id = ?'=>$project_id, 'meeting_type = ?'=>'Owner Meeting');
		$projectOwnerMet = TableService::GetTabularData($database, $owner_arr);
		$projectOwnerMetId = $projectOwnerMet['id'];

		// LEED Meeting meeting_types id
		$leed_arr = array(); $leed_arr['table'] = 'meeting_types';
		$leed_arr['fields'] = array('id');
		$leed_arr['filter'] = array('project_id = ?'=>$project_id, 'meeting_type = ?'=>'LEED Meeting');
		$projectLeedMet = TableService::GetTabularData($database, $leed_arr);
		$projectLeedMetId = $projectLeedMet['id'];

		// Weekly Subcontractor Meeting meeting_types id
		$subcontract_arr = array(); $subcontract_arr['table'] = 'meeting_types';
		$subcontract_arr['fields'] = array('id');
		$subcontract_arr['filter'] = array('project_id = ?'=>$project_id, 'meeting_type = ?'=>'Weekly Subcontractor Meeting');
		$projectSubcontractMet = TableService::GetTabularData($database, $subcontract_arr);
		$projectSubcontractMetId = $projectSubcontractMet['id'];

		// Internal Meeting meeting_types id
		$interal_arr = array(); $interal_arr['table'] = 'meeting_types';
		$interal_arr['fields'] = array('id');
		$interal_arr['filter'] = array('project_id = ?'=>$project_id, 'meeting_type = ?'=>'Internal Meeting');
		$projectInteralMet = TableService::GetTabularData($database, $interal_arr);
		$projectInteralMetId = $projectInteralMet['id'];

		// Combine meeting_types id
		$meeting_type_ids = array();
		if ($projectOwnerMetId != '') { array_push($meeting_type_ids,$projectOwnerMetId); }
		if ($projectLeedMetId != '') { array_push($meeting_type_ids,$projectLeedMetId); }
		if ($projectSubcontractMetId != '') { array_push($meeting_type_ids,$projectSubcontractMetId); }
		if ($projectInteralMetId != '') { array_push($meeting_type_ids,$projectInteralMetId); }
		$meeting_type_id = '('.implode(",",$meeting_type_ids).')';

		// Delete meeting permission by project_id and meeting_type_id
		$deleteMeetingPermission = MeetingAttendee::deleteMeetingAccessToContactByProIdAndMeetingId($database,$project_id,$meeting_type_id);

		// Insert meeting permission
		$meeting_moudle_id = '('.$ownerMetModuleId.','.$leedMetModuleId.','.$subcontractMetModuleId.','.$internalMetModuleId.')';
		$getRoleIdFromPermissiontable = MeetingAttendee::getRoleFromPermissionTable($database,$project_id,$meeting_moudle_id);

		foreach ($getRoleIdFromPermissiontable as $module_id => $module_id_value) {

			if ($module_id == $ownerMetModuleId) { $meeting_type_id = $projectOwnerMetId; }
			else if ($module_id == $leedMetModuleId) { $meeting_type_id = $projectLeedMetId; }
			else if ($module_id == $subcontractMetModuleId) { $meeting_type_id = $projectSubcontractMetId; }
			else if ($module_id == $internalMetModuleId) { $meeting_type_id = $projectInteralMetId; }
			
			foreach ($module_id_value as $role_id => $role_id_value) {
				MeetingAttendee::InsertMeetingAttendeesToContact($database,$meeting_type_id,$role_id,$project_id,'Y');
			}
		}

	break;

	case 'filterMeetingPermission':
		$role_spec = $get->role_spec;
		$role_filter = $get->role_filter;
		$MeetingContent = MeetingPermissionModal($database,$project_id,$role_spec,$role_filter);
		echo $MeetingContent;

	break;

	case 'loadMeetingPermission':

	$alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	
	$rolesContent = <<<END_HTML_CONTENT
	<span id="perall" class="filrol" onclick="filtermeetingroles('all')">Role(s)</span>
	<span class="filrol">
		<select id="specify_sel" class="addpermission" onchange="filtermeetingroles()" style="margin-left:5px;margin-right:5px;font-size:14px;">
			<option value='all'>Both roles</option>
			<option value='Y' selected>Proj Spec</option>
			<option value='N' $selected>Not Proj Spec</option>
		</select>
	</span>
END_HTML_CONTENT;

	foreach ($alpha as  $Alpvalue) {
	$rolesContent .= <<<END_HTML_CONTENT
	<span id="per$Alpvalue" class="filrol" onclick="filtermeetingroles('$Alpvalue')">$Alpvalue</span>
END_HTML_CONTENT;
}
	$MeetingContent = MeetingPermissionModal($database,$project_id,'Y');

	$htmlContent = <<<END_HTML_CONTENT
	<div id="div_permission">
	<div id="alpah" class="perlist" style="font-weight: bold;color: #3b90ce;padding-bottom:10px;font-size:12px;">
	$rolesContent
	</div>
	<div id="" class="nonProSpecTable" >
	$MeetingContent
	</div></div>
	
END_HTML_CONTENT;

	$arrOutput = array(
			'htmlContent' => $htmlContent
		);
		$jsonOutput = json_encode($arrOutput);


	header('Content-Type: application/json');
		echo $jsonOutput;

	break; 

	case 'loadMeetingsByProjectAndType':

		$meeting_type_id = Data::parseInt($get->meeting_type_id);
		$selected_meeting_id = Data::parseInt($get->selected_meeting_id);

		if (!isset($selected_meeting_id) || empty($selected_meeting_id)) {
			$selected_meeting_id = 0;
		}

		$htmlContent = '';
		$arrMeetings = array();

		if ($meeting_type_id != 0) {
			$loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
			$loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
			$arrMeetings = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id, $loadMeetingsByProjectIdAndMeetingTypeIdOptions);
			foreach ($arrMeetings as $meeting_id => $meeting) {
				$meeting_sequence_number = $meeting->meeting_sequence_number;
				if ($selected_meeting_id == $meeting_id) {
					$htmlContent .= <<<END_HTML_CONTENT

					<option value="$meeting_id" selected>Meeting $meeting_sequence_number</option>
END_HTML_CONTENT;
				} else {
					$htmlContent .= <<<END_HTML_CONTENT

					<option value="$meeting_id">Meeting $meeting_sequence_number</option>
END_HTML_CONTENT;
				}
			}
		}

		if (count($arrMeetings) == 0) {
			$htmlContent = '<option value="-2">No Meetings Exist</option>';
		}

		echo $htmlContent;

	break;

	case 'loadDiscussionItemsByMeetingId':

		$show_all_flag = (string) $get->showAll;
		$meeting_type_id = Data::parseInt($get->meeting_type_id);
		$meeting_id = Data::parseInt($get->meeting_id);

		$htmlContent = '';

		// Get all discussion items for this project
		$arrDiscussionItemsByMeetingId = DiscussionItem::loadDiscussionItemsByMeetingId($database, $meeting_id);

		if ($show_all_flag == 'false') {
			foreach ($arrDiscussionItemsByMeetingId as $discussion_item_id => $discussionItem) {
				$discussionItemStatus = $discussionItem->getDiscussionItemStatus();
				/* @var $discussionItemStatus DiscussionItemStatus */
				$discussion_item_status = $discussionItemStatus->discussion_item_status;
				if ($discussion_item_status != 'Open') {
					unset($arrDiscussionItemsByMeetingId[$discussion_item_id]);
				}
			}
		}

		// If there are discussion items
		if (count($arrDiscussionItemsByMeetingId) > 0) {

			$arrContactOptions[0] = 'Select Assignee';
			$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);
			foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
				/* @var $contact Contact */
				if ($contact['is_archive'] == 'N') {
					$contactFullName = $contact->getContactFullName(true);
					$arrContactOptions[$contact_id] = $contactFullName;
				}				
			}

			$arrDiscussionItemIds = array_keys($arrDiscussionItemsByMeetingId);
			$csvDiscussionItemIds = join(',', $arrDiscussionItemIds);

			// Get any action items associated with any of these discussion items
			$arrActionItemsByDiscussionItemIds = ActionItem::loadActionItemsByArrDiscussionItemIds($database, $arrDiscussionItemIds);

			// Get any comments associated with any of these discussion items
			$arrDiscussionItemCommentsByDiscussionItemIds = DiscussionItemComment::loadDiscussionItemCommentsByDiscussionItemIds($database, $arrDiscussionItemIds);

			// Display for each discussion
			foreach ($arrDiscussionItemsByMeetingId AS $discussion_item_id => $discussionItem) {
				/* @var $discussionItem DiscussionItem */

				$discussionItemStatus = $discussionItem->getDiscussionItemStatus();
				/* @var $discussionItemStatus DiscussionItemStatus */

				$discussionItemStatus->htmlEntityEscapeProperties();
				$discussion_item_status_id = $discussionItemStatus->discussion_item_status_id;
				$escaped_discussion_item_status = $discussionItemStatus->escaped_discussion_item_status;

				// Encoded Discussion Item Data
				$discussionItem->htmlEntityEscapeProperties();
				$escaped_discussion_item_title = $discussionItem->escaped_discussion_item_title;
				$escaped_discussion_item = $discussionItem->escaped_discussion_item;
				$escaped_discussion_item_nl2br = $discussionItem->escaped_discussion_item_nl2br;

				// Build the action table and assign it to a variable
				$isPrintView = false;
				$meetingInput = new Input();
				$meetingInput->database = $database;
				$meetingInput->arrContactOptions = $arrContactOptions;
				$meetingInput->userCanCreateActionItems = $userCanCreateActionItems;
				$meetingInput->userCanManageMeetings = $userCanManageMeetings;
				$meetingInput->actionShowElement = $actionShowElement;
				$meetingInput->actionEditElement = $actionEditElement;
				$meetingInput->isPrintView = $isPrintView;
				$meetingInput->currentlyActiveContactId = $currentlyActiveContactId;

				//$actionItemsTableByDiscussionItemId = buildMeetingActionItemsTableByDiscussionItemId($arrActionItemsByDiscussionItemIds, $discussion_item_id, $meetingInput);
				$actionItemsTableByDiscussionItemId = buildMeetingActionItemsTableByDiscussionItemId1($database, $project_id, $discussion_item_id, $arrContactOptions);

				// Build discussion_item_comment section and assign it to a variable
				$discussionItemCommentsTableByDiscussionItemId = buildDiscussionItemCommentsTableByDiscussionItemId($arrDiscussionItemCommentsByDiscussionItemIds, $discussion_item_id, $meetingInput);

				$htmlContent .= <<<END_HTML_CONTENT

					<div id="record_container--manage-discussion_item-record--discussion_items--sort_order--$discussion_item_id" class="sortableContainer">
END_HTML_CONTENT;

				if ($userCanManageMeetings || $userCanCreateActionItems) {
					$htmlContent .= <<<END_HTML_CONTENT

						<div id="edit_BtnContainer_$discussion_item_id" class="header-edit-container">
END_HTML_CONTENT;
				}

				if ($userCanManageMeetings) {

					$js = <<<END_HTML_CONTENT
					onchange="Collaboration_Manager__Meetings__updateDiscussionItem(this);" class="$discussionEditElement accordion header-status-edit"
END_HTML_CONTENT;
					$ddlDiscussionItemStatusesElementId = 'manage-discussion_item-record--discussion_items--discussion_item_status_id--'.$discussion_item_id;
					$loadAllDiscussionItemStatusesOptions = new Input();
					$loadAllDiscussionItemStatusesOptions->forceLoadFlag = true;
					$arrDiscussionItemStatuses = DiscussionItemStatus::loadAllDiscussionItemStatuses($database, $loadAllDiscussionItemStatusesOptions);
					$ddlDiscussionItemStatuses = PageComponents::dropDownListFromObjects($ddlDiscussionItemStatusesElementId, $arrDiscussionItemStatuses, 'discussion_item_status_id', null, 'discussion_item_status', null, $discussion_item_status_id, '', $js, '');
					$htmlContent .= <<<END_HTML_CONTENT

					<a class="smallerFont $discussionEditElement discussion-item-delete-button bs-tooltip" onclick="Collaboration_Manager__Meetings__deleteDiscussionItem(this, event, $discussion_item_id);" style="cursor: pointer;" data-original-title="Delete Discussion Item">
						<img src="/images/icons/delete-file-black.png">
					</a>
						  <input id="manage-discussion_item-record--discussion_items--discussion_item_title--$discussion_item_id" type="text" value="$escaped_discussion_item_title" onchange="Collaboration_Manager__Meetings__updateDiscussionItem(this);" class="$discussionEditElement accordion header-title-edit">
						  $ddlDiscussionItemStatuses
END_HTML_CONTENT;

				}

				if ($userCanManageMeetings || $userCanCreateActionItems) {
					//		<a id="btnEditDiscussion_$discussion_item_id" href="javascript:showEditDiscussion('$discussion_item_id');" class="smallerFont showElement discussion-item-edit-button">Edit</a>
					//		<input id="btnEditDiscussion_$discussion_item_id" class="smallerFont showElement discussion-item-edit-button" onclick="showEditDiscussion('$discussion_item_id');" type="button" value="Edit">
					$htmlContent .= <<<END_HTML_CONTENT

							<a id="btnEditDiscussion_$discussion_item_id" style="color:#fff;" href="javascript:showEditDiscussion('$discussion_item_id');" class="showElement discussion-item-edit-button">Edit</a>
						</div>
END_HTML_CONTENT;

				}

				$userCanAddActionStyle = '';
				if ($userCanCreateActionItems || $userCanManageMeetings) {
					//$userCanAddActionStyle = ' marginRight100';
					$userCanAddActionStyle = '';
				}

				// Output the discussion table
				$htmlContent .= <<<END_HTML_CONTENT

					<div id="item_$discussion_item_id" class="accordion">
						<div class="header" style="min-height: 19px;">
							<div id="manage-discussion_item-record-read_only--discussion_items--discussion_item_title--$discussion_item_id" class="$discussionShowElement header-title">$escaped_discussion_item_title</div>
							<div id="manage-discussion_item-record-read_only--discussion_items--discussion_item_status_id--$discussion_item_id" class="$discussionShowElement header-status">$escaped_discussion_item_status</div>
						</div>
						<div style="position: relative;">
END_HTML_CONTENT;

				/*
				if ($userCanCreateActionItems || $userCanManageMeetings) {
					$htmlContent .= <<<END_HTML_CONTENT

							<input id="btnNewAction_$discussion_item_id" type="button" value="Add Action" onclick="showCreateActionItemDialog('$discussion_item_id');" class="action-button-add">
END_HTML_CONTENT;
				}
				*/

				$htmlContent .= <<<END_HTML_CONTENT

							<div id="manage-discussion_item-record-read_only--discussion_items--discussion_item--$discussion_item_id" class="$discussionShowElement$userCanAddActionStyle">$escaped_discussion_item_nl2br</div>
							<div class="$userCanAddActionStyle">
								<textarea id="manage-discussion_item-record--discussion_items--discussion_item--$discussion_item_id" onchange="Collaboration_Manager__Meetings__updateDiscussionItem(this);" class="autogrow $discussionEditElement" style="display: none;width:98%">$escaped_discussion_item</textarea>
							</div>
							<div id="accordionCommment_$discussion_item_id" class="accordionComments$userCanAddActionStyle">
								$discussionItemCommentsTableByDiscussionItemId
							</div>
END_HTML_CONTENT;

				if ($userCanCreateDiscussionItemComments || $userCanManageMeetings) {

					$discussionItemCommentDummyId = Data::generateDummyPrimaryKey();
					$attributeGroupName = 'create-discussion_item_comment-record';

					$htmlContent .= <<<END_HTML_CONTENT

							<div id="record_creation_form_container--$attributeGroupName--$discussionItemCommentDummyId" style="margin-top: 10px;padding: 7px !important;" class="$userCanAddActionStyle">
								<textarea id="$attributeGroupName--discussion_item_comments--discussion_item_comment--$discussionItemCommentDummyId" class="autogrow commentBox required" placeholder="Add comment..." style="width: 99%;"></textarea>
								<input id="$attributeGroupName--discussion_item_comments--discussion_item_id--$discussionItemCommentDummyId" type="hidden" value="$discussion_item_id">
							</div>
							<div class="textAlignRight" style="margin: 2px 0px 0 0;">
							<button id="save_comment_$discussion_item_id" class="action-item-save-button-mt" onclick="Collaboration_Manager__Meetings__createDiscussionItemComment('$attributeGroupName', '$discussionItemCommentDummyId');" value="Save Comment">Save Comment</button>
							</div>
END_HTML_CONTENT;

				}

				$htmlContent .= <<<END_HTML_CONTENT

							<div id="accordionAction_$discussion_item_id" class="accordionActions$userCanAddActionStyle">
								$actionItemsTableByDiscussionItemId
							</div>
						</div>
					</div>
				</div>
END_HTML_CONTENT;

			}

		// End if there are discussion items
		} else {

			if ($meeting_id == -2) {

				$htmlContent .= <<<END_HTML_CONTENT

					<br>No meetings exist for this meeting type
END_HTML_CONTENT;

			} else {

				if ($show_all_flag == 'false') {

					// There are no discussion items
					$htmlContent .= <<<END_HTML_CONTENT

						<br>This project does not have any open discussion items for this meeting
END_HTML_CONTENT;

				} else {

					$htmlContent .= <<<END_HTML_CONTENT

						<br>This project does not have any discussion items for this meeting
END_HTML_CONTENT;

				}

			}

		}
		$session = Zend_Registry::get('session');
		$userRole = $session->getUserRole();
		$userCanViewDiscussionItems = checkPermissionForAllModuleAndRole($database,'meetings_view');
		if($userRole == "global_admin")
		{
			$userCanViewDiscussionItems=1;
		}
		if($userCanViewDiscussionItems)
		{
		echo $htmlContent;
		}

		break;

	case 'loadMeetingDetails':

		$meeting_id = Data::parseInt($get->meeting_id);
		$meeting_type_id = Data::parseInt($get->meeting_type_id);

		$previous_meeting_id = null;

		$htmlContent = '';

		$meeting_location_id = '';
		$meeting_location = '';
		$meeting_start_date = '';
		$meeting_start_time = '';
		$meeting_end_date = '';
		$meeting_end_time = '';
		$meetingStartDateDisplay = '';
		$meetingStartTimeDisplay = '';
		$meetingEndDateDisplay = '';
		$meetingEndTimeDisplay = '';
		$meetingAllDayEventFlagChecked = '';

		$previous_meeting_location_id = '';
		$previous_meeting_location = '';
		$previous_meeting_start_date = '';
		$previous_meeting_start_time = '';
		$previous_meeting_end_date = '';
		$previous_meeting_end_time = '';
		$previousMeetingStartDateDisplay = '';
		$previousMeetingStartTimeDisplay = '';
		$previousMeetingEndDateDisplay = '';
		$previousMeetingEndTimeDisplay = '';

		$next_meeting_location_id = '';
		$next_meeting_location = '';
		$next_meeting_start_date = '';
		$next_meeting_start_time = '';
		$next_meeting_end_date = '';
		$next_meeting_end_time = '';
		$nextMeetingStartDateDisplay = '';
		$nextMeetingStartTimeDisplay = '';
		$nextMeetingEndDateDisplay = '';
		$nextMeetingEndTimeDisplay = '';
		$nextMeetingAllDayEventFlagChecked = '';

		$attributeGroupName = 'create-meeting-record';
		$nextMeetingAttributeGroupName = 'create-next_meeting-record';
		$meetingOnChangeJs = ' onchange=""';
		$nextMeetingOnChangeJs = ' onchange=""';
		$uniqueId = Data::generateDummyPrimaryKey();
		$nextMeetingUniqueId = Data::generateDummyPrimaryKey();
		$nextMeetingCreateButton = <<<END_HTML_CONTENT

		<input type="button" id="buttonCreateNextMeeting" onclick="Collaboration_Manager__createMeeting('$nextMeetingAttributeGroupName', '$nextMeetingUniqueId', { ddl_meeting_type_id: true });" value="Create Next Meeting" class="$meetingEditElement hidden">
END_HTML_CONTENT;

		$arrMeetingAttendeesByMeetingId = array();
		$loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
		$loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
		$arrMeetingsByProjectIdAndMeetingTypeId = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id, $loadMeetingsByProjectIdAndMeetingTypeIdOptions);
		$firstMeetingOfThisTypeForThisProject = true;
		if (count($arrMeetingsByProjectIdAndMeetingTypeId) > 0) {
			$firstMeetingOfThisTypeForThisProject = false;
		}
		$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);

		$meeting = false;
		$nextMeeting = false;
		$meetingLocation = false;
		$nextMeetingLocation = false;
		if ($meeting_id > 0) {
			$meeting = Meeting::loadMeetingPlusNextMeetingById($database, $meeting_id);
			//$nextMeeting = Meeting::loadMeetingPlusNextMeetingById($database, $meeting_id);
			/* @var $nextMeeting Meeting */
			/* @var $meeting Meeting */

			if (!$meeting) {
				$meeting = Meeting::findMeetingByIdExtended($database, $meeting_id);
			}

			$loadMeetingAttendeesByMeetingIdOptions = new Input();
			$loadMeetingAttendeesByMeetingIdOptions->forceLoadFlag = true;
			$arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingId($database, $meeting_id, $loadMeetingAttendeesByMeetingIdOptions);
		}


		if ($meeting) {
			$previous_meeting_id = $meeting->previous_meeting_id;
			$meeting_sequence_number = $meeting->meeting_sequence_number;

			//$previousMeeting = $meeting->getPreviousMeeting();
			/* @var $previousMeeting Meeting */

			$nextMeeting = $meeting->getNextMeeting();
			/* @var $nextMeeting Meeting */

			$loadMeetingAttendeesByMeetingIdOptions = new Input();
			$loadMeetingAttendeesByMeetingIdOptions->forceLoadFlag = true;
			$arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingId($database, $meeting_id, $loadMeetingAttendeesByMeetingIdOptions);

			$project = $meeting->getProject();
			/* @var $project Project */

			$meetingType = $meeting->getMeetingType();
			/* @var $meetingType MeetingType */

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

			if ($meetingType) {
				$meeting_type = $meetingType->meeting_type;
			}

			// $meeting_start_date and $next_meeting_start_date
			$meeting_start_date = $meeting->meeting_start_date;
			if (isset($meeting_start_date) && ($meeting_start_date != '0000-00-00')) {
				$meetingStartDateAsUnixTimestamp = strtotime($meeting_start_date);
				$meetingStartDateDisplay = date('m/d/Y', $meetingStartDateAsUnixTimestamp);
				$meeting_start_date = date('m/d/Y', $meetingStartDateAsUnixTimestamp);
				// Set the next meeting start date to $meeting_start_date + 1 week in the future (604800 seconds).
				//$nextMeetingStartDateAsUnixTimestamp = $meetingStartDateAsUnixTimestamp + 604800;
				//$nextMeetingStartDateDisplay = date('M d, Y', $nextMeetingStartDateAsUnixTimestamp);
				//$next_meeting_start_date = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
			} else {
				$meeting_start_date = '';
				$meetingStartDateDisplay = '';
				$next_meeting_start_date = '';
				$nextMeetingStartDateDisplay = '';
			}

			// $meeting_start_time and $next_meeting_start_time
			$meeting_start_time = $meeting->meeting_start_time;
			if (isset($meeting_start_time) && ($meeting_start_time != '00:00:00')) {
				$meetingStartTimeDisplay = date('g:ia', strtotime($meeting_start_time));
				//$next_meeting_start_time = $meeting_start_time;
				//$nextMeetingStartTimeDisplay = $meetingStartTimeDisplay;
			} else {
				$meeting_start_time = '';
				$meetingStartTimeDisplay = '';
				$next_meeting_start_time = '';
				$nextMeetingStartTimeDisplay = '';
			}

			// $meeting_end_date and $next_meeting_end_date
			$meeting_end_date = $meeting->meeting_end_date;
			if (isset($meeting_end_date) && ($meeting_end_date != '0000-00-00')) {
				$meetingEndDateAsUnixTimestamp = strtotime($meeting_end_date);
				$meetingEndDateDisplay = date('m/d/Y', $meetingEndDateAsUnixTimestamp);
				$meeting_end_date = date('m/d/Y', $meetingEndDateAsUnixTimestamp);
				// Set the next meeting end date to $meeting_end_date + 1 week in the future (604800 seconds).
				//$nextMeetingEndDateAsUnixTimestamp = $meetingEndDateAsUnixTimestamp + 604800;
				//$nextMeetingEndDateDisplay = date('M d, Y', $nextMeetingEndDateAsUnixTimestamp);
				//$next_meeting_end_date = date('m/d/Y', $nextMeetingEndDateAsUnixTimestamp);
			} else {
				$meetingEndDateDisplay = '';
				$meeting_end_date = '';
				$nextMeetingEndDateDisplay = '';
				$next_meeting_end_date = '';
			}

			// $meeting_end_time and $next_meeting_end_time
			$meeting_end_time = $meeting->meeting_end_time;
			if (isset($meeting_end_time) && ($meeting_end_time != '00:00:00')) {
				$meetingEndTimeDisplay = date('g:ia', strtotime($meeting_end_time));
				//$next_meeting_end_time = $meeting_end_time;
				//$nextMeetingEndTimeDisplay = $meetingEndTimeDisplay;
			} else {
				$meetingEndTimeDisplay = '';
				$meeting_end_time = '';
				$nextMeetingEndTimeDisplay = '';
				$next_meeting_end_time = '';
			}

			$meetingHeaderText = $encodedProjectName . ' : ' . $meeting_type . ' ' . $meeting_sequence_number;

			$uniqueId = $meeting_id;
			$attributeGroupName = 'manage-meeting-record';
			$meetingOnChangeJs = ' onchange="updateMeetingHelper(this,'.$uniqueId.','.$nextMeeting->meeting_id.');"';
			$all_day_event_flag = $meeting->all_day_event_flag;
			if ($all_day_event_flag == 'Y') {
				$meetingAllDayEventFlagChecked = 'checked';
			}
		} else {
			$project = false;
			$meetingType = false;
			$meetingLocation = false;

			// There are no meetings at all for this meeting type.
			//$meetingHeaderText = $encodedProjectName . " : New " . $meeting_type . " " . $meeting_sequence_number;
		}

		if ($nextMeeting) {
			// Override defaults if explicitly set here
			if (isset($nextMeeting->meeting_start_date) && ($nextMeeting->meeting_start_date != '0000-00-00')) {
				$next_meeting_start_date = $nextMeeting->meeting_start_date;
				$nextMeetingStartDateAsUnixTimestamp = strtotime($next_meeting_start_date);
				$nextMeetingStartDateDisplay = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
				$next_meeting_start_date = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
			}

			if (isset($nextMeeting->meeting_start_time) && ($nextMeeting->meeting_start_time != '00:00:00')) {
				$next_meeting_start_time = $nextMeeting->meeting_start_time;
				$nextMeetingStartTimeDisplay = date('g:ia', strtotime($next_meeting_start_time));
			}

			if (isset($nextMeeting->meeting_end_date) && ($nextMeeting->meeting_end_date != '0000-00-00')) {
				$next_meeting_end_date = $nextMeeting->meeting_end_date;
				$nextMeetingEndDateAsUnixTimestamp = strtotime($next_meeting_end_date);
				$nextMeetingEndDateDisplay = date('m/d/Y', $nextMeetingEndDateAsUnixTimestamp);
				$next_meeting_end_date = date('m/d/Y', $nextMeetingEndDateAsUnixTimestamp);
			}

			if (isset($nextMeeting->meeting_end_time) && ($nextMeeting->meeting_end_time != '00:00:00')) {
				$next_meeting_end_time = $nextMeeting->meeting_end_time;
				$nextMeetingEndTimeDisplay = date('g:ia', strtotime($next_meeting_end_time));
			}

			$nextMeetingLocation = $nextMeeting->getMeetingLocation();
			/* @var $nextMeetingLocation MeetingLocation */

			if ($nextMeetingLocation) {
				$next_meeting_location_id = $nextMeetingLocation->meeting_location_id;
				$next_meeting_location = $nextMeetingLocation->meeting_location;
			}

			$nextMeetingAttributeGroupName = 'manage-next_meeting-record';
			$nextMeetingUniqueId = $nextMeeting->meeting_id;
			$nextMeetingOnChangeJs = ' onchange="updateMeetingHelper(this,'.$meeting_id.','.$nextMeetingUniqueId.');"';
			$nextMeetingCreateButton = '';
			$next_all_day_event_flag = $nextMeeting->all_day_event_flag;
			if ($next_all_day_event_flag == 'Y') {
				$nextMeetingAllDayEventFlagChecked = 'checked';
			}
		}

		echo '
			<hr class="hrClass"></hr>
		';
		$helpHintStyle = "hiddenHint";
		if ($userCanManageMeetings) {
			$helpHintStyle = "help-hint";
			$htmlContent .= <<<END_HTML_CONTENT

				<table width="100%">
					<tr>
						<td align="right">
							<button class="button-com-add-mt $meetingEditElement" id="btnCancelEditMeetingInformation" onclick="editMeetingInfo();" type="button" value="Cancel">Cancel</button>
							<button class="button-com-add-mt" id="btnEditMeetingInformation" onclick="editMeetingInfo();" type="button" value="Edit Meeting Information">Edit Meeting Information</button>
						</td>
					</tr>
				</table>
END_HTML_CONTENT;
		}

		$meeting_chair_contact_id = $currentlyActiveContactId;

		$ddlMeetingLocationsElementId = $attributeGroupName.'--meetings--meeting_location_id--'.$uniqueId;
		$loadMeetingLocationsByUserCompanyIdOptions = new Input();
		$loadMeetingLocationsByUserCompanyIdOptions->forceLoadFlag = true;
		$arrMeeetingLocations = MeetingLocation::loadMeetingLocationsByUserCompanyId($database, $user_company_id, $loadMeetingLocationsByUserCompanyIdOptions);
		$selectedOption = '';
		if ($meetingLocation) {
			$selectedOption = $meetingLocation->meeting_location_id;
		}

		// Add another javascript function into the onchange="" handler
		// 1) First remove the right most double quote
		$rTrimmedMeetingOnChangeJs = rtrim($meetingOnChangeJs, '"');
		// 2) Add the second javascript callback
		$ddlMeetingLocationOnChangeJs = <<<END_DDL_MEETING_LOCATION_ON_CHANGE_JS
$rTrimmedMeetingOnChangeJs updateNextMeetingLocation(this, 'manage-next_meeting-record--meetings--meeting_location_id--$nextMeetingUniqueId');"
END_DDL_MEETING_LOCATION_ON_CHANGE_JS;

		//bs-tooltip colorDarkGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant
		//colorDarkGray entypo-cancel-squared fakeHrefBox
		//entypo entypo-click entypo-cancel-circled bs-tooltip meeting-delete-button editElement

		$ddlMeetingLocations = PageComponents::dropDownListFromObjects($ddlMeetingLocationsElementId, $arrMeeetingLocations, 'meeting_location_id', null, 'meeting_location', null, $selectedOption, '', $ddlMeetingLocationOnChangeJs.'style="display:none;" class="meetingLocations '.$meetingEditElement.'"', '');
		$htmlContent .= <<<END_HTML_CONTENT

			<div id="container--$attributeGroupName--$uniqueId" class="padInputs containerEditCls">
			<input id="$attributeGroupName--meetings--meeting_sequence_number--$uniqueId" type="hidden" value="$meeting_sequence_number">
			<input id="$attributeGroupName--meetings--meeting_chair_contact_id--$uniqueId" type="hidden" value="$meeting_chair_contact_id">
			<table width="100%">
				<tr valign="top">
					<td width="35%">
						<span class="bs-tooltip colorDarkGray entypo-cancel-squared fakeHrefBox verticalAlignMiddleImportant meeting-delete-button editElement" title="Delete Meeting Record" onclick="Collaboration_Manager__deleteMeeting(this, event, $meeting_id);"></span>
						<table class="nowrapCells marginRight" cellpadding="3px">
							<tr>
								<th colspan="2" class="columnHeader">
									$meetingHeaderText
								</th>
							</tr>
							<tr>
								<td class="verticalAlignMiddle">Start Time:</td>
								<td>
									<span id="$attributeGroupName-read_only--meetings--meeting_start_date--$uniqueId" class="$meetingShowElement">$meetingStartDateDisplay</span>
									<input id="$attributeGroupName--meetings--meeting_start_date--$uniqueId" type="text" value="$meeting_start_date" class="$meetingEditElement datepicker auto-hint required" placeholder="MM/DD/YYYY" style="display: none; color: #222;"$meetingOnChangeJs readonly>
									<span id="$attributeGroupName-read_only--meetings--meeting_start_time--$uniqueId" class="$meetingShowElement">$meetingStartTimeDisplay</span>
									<input id="$attributeGroupName--meetings--meeting_start_time--$uniqueId" type="text" value="$meeting_start_time" class="$meetingEditElement timepicker auto-hint required" placeholder="12:00pm" style="display: none; color: #222;"$meetingOnChangeJs>
								</td>
							</tr>
							<tr>
								<td class="verticalAlignMiddle">End Time:</td>
								<td>
									<span id="$attributeGroupName-read_only--meetings--meeting_end_date--$uniqueId" class="$meetingShowElement">$meetingEndDateDisplay</span>
									<input id="$attributeGroupName--meetings--meeting_end_date--$uniqueId" type="text" value="$meeting_end_date" class="$meetingEditElement datepicker auto-hint required" placeholder="MM/DD/YYYY" style="display: none; color: #222;"$meetingOnChangeJs readonly>
									<span id="$attributeGroupName-read_only--meetings--meeting_end_time--$uniqueId" class="$meetingShowElement">$meetingEndTimeDisplay</span>
									<input id="$attributeGroupName--meetings--meeting_end_time--$uniqueId" type="text" value="$meeting_end_time" class="$meetingEditElement timepicker auto-hint required" placeholder="12:00pm" style="display: none; color: #222;"$meetingOnChangeJs>
								</td>
							</tr>
							
END_HTML_CONTENT;


								// <tr>
								// <td></td>
								// <td>
								// 	<input type="checkbox" id="$attributeGroupName--meetings--all_day_event_flag--$uniqueId" class="toggleDisabledElement" onchange="updateMeeting(this);" disabled $meetingAllDayEventFlagChecked>
								// 	<label style="float: none;" for="$attributeGroupName--meetings--all_day_event_flag--$uniqueId">All Day Event</label>
								// </td>
								// </tr>
$htmlContent .= <<<END_HTML_CONTENT


							
							<tr>
								<td class="verticalAlignMiddle">Location:</td>
								<td>
									<span id="$attributeGroupName-read_only--meetings--meeting_location_id--$uniqueId" class="$meetingShowElement required">$meeting_location</span>
									$ddlMeetingLocations
								</td>
							</tr>
							<tr>
								<td class="verticalAlignMiddle" colspan="2">
									<a href="javascript:loadManageMeetingLocationsDialog();" class="$meetingEditElement" style="font-size:85%; margin-left: 80px;">Manage Meeting Locations</a>
								</td>
							</tr>
						</table>
					</td>
					<td width="30%">
						<div class="$meetingShowElement">
							<table class="nowrapCells marginRight">
								<tr>
									<th class="columnHeader" colspan="2">Attendees</th>
								</tr>
END_HTML_CONTENT;

								$arrListedContacts = array();
								foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
									/* @var $contact Contact */
									$contactFullName = $contact->getContactFullName(true, '(');

									if (!isset($arrListedContacts[$contact_id])) {
										$isAttendeeParam = 'style="display:none;"';
										if (array_key_exists($contact_id, $arrMeetingAttendeesByMeetingId)) {
											$isAttendeeParam = '';
										}
										// Rows for display only
										$htmlContent .= '
											<tr id="show_meetingAttendee_'.$contact_id.'"'.$isAttendeeParam.'>
												<td>'.$contactFullName.'</td>
											</tr>
										';
										$arrListedContacts[$contact_id] = 1;
									}
								}
		$htmlContent .= <<<END_HTML_CONTENT

							</table>
						</div>
						<div class="$meetingEditElement" style="display: none;">
							<table class="nowrapCells marginRight">
								<tr>
									<th class="columnHeader" colspan="2">Attendees<div id="help-attendees" class="$helpHintStyle">?</div></th>
								</tr>
END_HTML_CONTENT;
								$arrListedContacts = array();
								foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
									$contactFullName = $contact->getContactFullName(true, '(');
									$encodedContactFullName = Data::entity_encode($contactFullName);

									if($contact['is_archive'] == 'Y'){
										$checked_disable = ' disabled';
									}else{
										$checked_disable = '';
									}

									if (!isset($arrListedContacts[$contact_id])) {
										$isCheckedAttribute = "";
										if (isset($arrMeetingAttendeesByMeetingId[$contact_id])) {
											$isCheckedAttribute = ' checked';
										}
										// Rows for editing
												//<td><input id="edit_meetingAttendee_' . $contact_id . '" type="checkbox"'.$isCheckedAttribute.' onclick="toggleAttendee(\''.$contact_id.'\');"></td>
										$meetingAttendeeCheckBoxElementId = $attributeGroupName.'--meeting_attendees--contact_id--'.$contact_id;
										$htmlContent .= '
											<tr>
												<td><input id="'.$meetingAttendeeCheckBoxElementId.'" class="'.$attributeGroupName.'--meetingAttendee" type="checkbox"'.$isCheckedAttribute.' onclick="toggleAttendee(\''.$contact_id.'\');"'.$checked_disable.' value="'.$contact_id.'"></td>
												<td><label for="'.$meetingAttendeeCheckBoxElementId.'" style="float:none">'.$encodedContactFullName.'</label></td>
											</tr>
										';
										$arrListedContacts[$contact_id] = 1;
									}

								}

		$ddlNextMeetingLocationsElementId = "$nextMeetingAttributeGroupName--meetings--meeting_location_id--$nextMeetingUniqueId";
		$selectedOption = '';
		if ($nextMeetingLocation) {
			$selectedOption = $nextMeetingLocation->meeting_location_id;
		}

		$tmpJavaScript = <<<END_TMP_JAVASCRIPT
			$nextMeetingOnChangeJs style="display: none;" class="nextMeetingData meetingLocations $meetingEditElement"
END_TMP_JAVASCRIPT;

		$ddlNextMeetingLocations = PageComponents::dropDownListFromObjects($ddlNextMeetingLocationsElementId, $arrMeeetingLocations, 'meeting_location_id', null, 'meeting_location', null, $selectedOption, '', $tmpJavaScript, '');

		$htmlContent .= <<<END_HTML_CONTENT

							</table>
						</div>


					</td>
					<td width="35%" align="right">
						<table class="nowrapCells marginRight" cellpadding="3px">
							<tr>
								<th class="columnHeader" colspan="2">Next Meeting</th>
							</tr>
							<tr>
								<td class="verticalAlignMiddle">Next Meeting Start Time:</td>
								<td>
									<span id="$nextMeetingAttributeGroupName-read_only--meetings--meeting_start_date--$nextMeetingUniqueId" class="$meetingShowElement">$nextMeetingStartDateDisplay</span>
									<input id="$nextMeetingAttributeGroupName--meetings--meeting_start_date--$nextMeetingUniqueId" type="text" value="$next_meeting_start_date" class="$meetingEditElement datepicker auto-hint required nextMeetingData" placeholder="MM/DD/YYYY" style="display: none; color: #222;"$nextMeetingOnChangeJs readonly>
									<span id="$nextMeetingAttributeGroupName-read_only--meetings--meeting_start_time--$nextMeetingUniqueId" class="$meetingShowElement">$nextMeetingStartTimeDisplay</span>
									<input id="$nextMeetingAttributeGroupName--meetings--meeting_start_time--$nextMeetingUniqueId" type="text" value="$next_meeting_start_time" class="$meetingEditElement timepicker auto-hint required nextMeetingData" placeholder="12:00pm" style="display: none; color: #222;"$nextMeetingOnChangeJs>
								</td>
							</tr>
							</tr>
								<td class="verticalAlignMiddle">Next Meeting End Time:</td>
								<td>
									<span id="$nextMeetingAttributeGroupName-read_only--meetings--meeting_end_date--$nextMeetingUniqueId" class="$meetingShowElement">$nextMeetingEndDateDisplay</span>
									<input id="$nextMeetingAttributeGroupName--meetings--meeting_end_date--$nextMeetingUniqueId" type="text" value="$next_meeting_end_date" class="$meetingEditElement datepicker auto-hint required nextMeetingData" placeholder="MM/DD/YYYY" style="display: none; color: #222;"$nextMeetingOnChangeJs readonly>
									<span id="$nextMeetingAttributeGroupName-read_only--meetings--meeting_end_time--$nextMeetingUniqueId" class="$meetingShowElement">$nextMeetingEndTimeDisplay</span>
									<input id="$nextMeetingAttributeGroupName--meetings--meeting_end_time--$nextMeetingUniqueId" type="text" value="$next_meeting_end_time" class="$meetingEditElement timepicker auto-hint required nextMeetingData" placeholder="12:00pm" style="display: none; color: #222;"$nextMeetingOnChangeJs>
								</td>
							</tr>
END_HTML_CONTENT;

							// <tr>
							// 	<td></td>
							// 	<td>
							// 		<input type="checkbox" id="$attributeGroupName--meetings--all_day_event_flag--$nextMeetingUniqueId" class="toggleDisabledElement" onchange="updateMeeting(this);" disabled $nextMeetingAllDayEventFlagChecked>
							// 		<label style="float: none;" for="$attributeGroupName--meetings--all_day_event_flag--$nextMeetingUniqueId">All Day Event</label>
							// 	</td>
							// </tr>
		$htmlContent .= <<<END_HTML_CONTENT

							<tr>
								<td class="verticalAlignMiddle">Next Meeting Location:</td>
								<td>
									<span id="$nextMeetingAttributeGroupName-read_only--meetings--meeting_location_id--$nextMeetingUniqueId" class="$meetingShowElement required">$next_meeting_location</span>
									$ddlNextMeetingLocations
								</td>
							</tr>
							<tr>
								<td class="verticalAlignMiddle" colspan="2">
									<a href="javascript:loadManageMeetingLocationsDialog();" class="$meetingEditElement" style="font-size: 85%; margin-left: 160px;">Manage Meeting Locations</a>
								</td>
							</tr>
							<tr>
								<td colspan="2" class="textAlignRight" style="padding: 10px;">$nextMeetingCreateButton</td>
								<input id="$nextMeetingAttributeGroupName--meetings--previous_meeting_id--$nextMeetingUniqueId" type="hidden" value="$meeting_id">
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</div>
END_HTML_CONTENT;
		/*
		if ($meeting_id == 0) {
			echo '
			<table>
				<tr>
					<td colspan="3">
						<table>
							<tr>
								<td><input id="btnSaveNewMeeting" type="button" value="Save New Meeting" onclick="Collaboration_Manager__createMeeting(\''.$attributeGroupName.'\', \''.$uniqueId.'\');"></td>
								<td><input id="btnCancelNewMeeting" type="button" value="Cancel" onclick="cancelNewMeeting();"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<hr class="hrClass"></hr>
			';
		}
		*/
		$htmlContent .= <<<END_HTML_CONTENT

			<form id="formExport" name="formExport" target="_blank" action="/modules-collaboration-manager-report.php">
			<input id="meeting_id" name="meeting_id" type="hidden">
			<input id="sAll" name="sAll" type="hidden">
			<input id="theAction" name="theAction" type="hidden">
			<table class="exportOptions" width="100%">
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td><input id="btnPrintMeetingReport" name="btnPrintMeetingReport" type="button" value="Print" onclick="openMeetingPdfInNewTab();"></td>
								<td><input id="btnEmailMeetingReport" name="btnEmailMeetingReport" type="button" value="Email" onclick="loadEmailMeetingPdfDialog();"></td>
								<td width="90%" align="right"><input id="btnEmailMeetingRenderReport" name="btnEmailMeetingRenderReport" type="button" value="Render PDF" onclick="loadRenderPDF();"></td>
END_HTML_CONTENT;
		/*
		if ($userCanManageMeetings) {
			echo '
								<!--<td><input id="btnEditMeetingInformation" type="button" value="Edit Meeting Information" onclick="editMeetingInfo();"></td>-->
								<!--<td><input id="btnDeleteMeeting" type="button" value="Delete Meeting" onclick="alert(\'Add This Functionality\');"></td>-->
			';
		}
		*/
		$htmlContent .= <<<END_HTML_CONTENT

							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
			<hr class="hrClass exportOptions"></hr>
END_HTML_CONTENT;

		// Create the "New Discussion Item" button
		$createDiscussionBtn = '';
		if ($userCanCreateDiscussionItems || $userCanManageMeetings) {
			if ($meeting_id != 0) {
				$createDiscussionBtn = '<input id="btnShowNewDiscussionItem" type="button" value="New Discussion Item" onclick="showNewDiscussion();">';
			} else {
				$createDiscussionBtn = '<input id="btnShowNewDiscussionItem" type="button" value="New Discussion Item" onclick="showNewDiscussion();" style="display: none;">';
			}
		}

		// Create the "Import Discussion Items" button
		$importDiscussionBtn = '';
		if ($userCanManageMeetings && $meeting_id > 0 && isset($previous_meeting_id)) {
			$arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType = DiscussionItem::loadDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType($database, $previous_meeting_id);
			if (!empty($arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType)) {
				$importDiscussionBtn = <<<END_HTML_CONTENT

				<input id="btnImportDiscussionItem" type="button" value="Import Discussion Items" style="margin-left: 15px;" onclick="showImportDiscussionOptions('$meeting_id', '$previous_meeting_id');">
END_HTML_CONTENT;
			}
		}

		$htmlContent .= <<<END_HTML_CONTENT

			<table style="width: 100%; margin-top: 10px; margin-bottom: 10px;" border="0" cellspacing="0">
				<tr>
					<td style="padding-top: 10px; width: 100%;">$createDiscussionBtn $importDiscussionBtn</td>
					<td id="td-discussion-expandOptions" style="padding-top: 10px; padding-right: 25px; white-space: nowrap;" align="right">
						<a href="javascript:expandAllItems();" id="aExpandAll">Expand All</a> / <a href="javascript:collapseAllItems();" id="aCollapseAll">Collapse All</a>
					</td>
					<td id="td-discussion-showAll" style="padding-top: 10px; padding-right: 10px; white-space: nowrap;" align="right">
						<input id="chkShowAll" type="checkbox" onclick="loadDiscussionItemsByMeetingId();" checked>&nbsp;Show All
					</td>
					<td id="td-discussion-editOption" style="padding-top: 10px; padding-right: 10px; white-space: nowrap;" align="right">
END_HTML_CONTENT;
							if ($userCanManageMeetings) {
								$htmlContent .= <<<END_HTML_CONTENT

								<a id="btnGlobalEdit" href="javascript:globalShowEditDiscussion();" style="margin-left: 15px;">Edit Discussion Items</a>
END_HTML_CONTENT;
							}
		$htmlContent .= <<<END_HTML_CONTENT

					</td>
				</tr>
			</table>
END_HTML_CONTENT;

		echo $htmlContent;

		break;

	case 'reloadComments':

		$discussion_item_id = Data::parseInt($get->discussion_item_id);
		$arrDiscussionItemIds = array($discussion_item_id);

		$isPrintView = false;
		$meetingInput = new Input();
		$meetingInput->database = $database;
		$meetingInput->arrContactOptions = $arrContactOptions;
		$meetingInput->userCanCreateActionItems = $userCanCreateActionItems;
		$meetingInput->userCanManageMeetings = $userCanManageMeetings;
		$meetingInput->actionShowElement = $actionShowElement;
		$meetingInput->actionEditElement = $actionEditElement;
		$meetingInput->isPrintView = $isPrintView;

		// Get any comments associated with any of these discussion items
		$arrDiscussionItemCommentsByDiscussionItemIds = DiscussionItemComment::loadDiscussionItemCommentsByDiscussionItemIds($database, $arrDiscussionItemIds);

		// Build discussion_item_comment section and assign it to a variable
		$discussionItemCommentsTableByDiscussionItemId = buildDiscussionItemCommentsTableByDiscussionItemId($arrDiscussionItemCommentsByDiscussionItemIds, $discussion_item_id, $meetingInput);

		echo $discussionItemCommentsTableByDiscussionItemId;

		break;

	case 'newAction':

		// @todo Add sequence number

		// 06/14/2012 due date hopefully comes like this
		$discussion_item_id = Data::parseInt($get->discussion_item_id);

		$actionGetName = 'newAction_' . $discussion_item_id;
		$dueDateGetName = 'newActionDueDate_' . $discussion_item_id;
		//$assigneesGetName = 'newActionAssignees_' . $discussion_item_id;
		$assigneesGetName = 'selNewAssignedTo_' . $discussion_item_id;

		// Variable variables
		$action_item = $get->$actionGetName;
		$dueDate = $get->$dueDateGetName;
		$assigneesList = $get->$assigneesGetName;

		$action_item = trim($action_item);
		$dueDate = trim($dueDate);

		if ($dueDate == 'MM/DD/YYYY') {
			$dueDate = '';
		}

		if (!empty($dueDate)) {
			if (preg_match('#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#', $dueDate)) {
				$arrTemp = explode('/',$dueDate);
				$dueDate = $arrTemp[2] . '-' . $arrTemp[0] . '-' . $arrTemp[1];
			} else {
				$message->enqueueError($dueDateGetName.'|Action Due Date Must Be In Format "MM/DD/YYYY"', $currentPhpScript);
				trigger_error("Invalid Date Format");
			}
		}
		$arrAssignees = preg_split('#[,]+#', $assigneesList, -1, PREG_SPLIT_NO_EMPTY);
		$db->begin();
		$query =
"
INSERT
INTO `action_items` (`project_id`, `action_item_type_id`, `created_by_contact_id`, `action_item_title`, `action_item`, `created`, `action_item_due_date`)
VALUES ($project_id, 1, $currentlyActiveContactId, '', ?, null, ?)
";
		$arrValues = array($action_item, $dueDate);
		$db->execute($query, $arrValues);
		$action_item_id = $db->insertId;

		$query =
"
INSERT
INTO `discussion_items_to_action_items` (`discussion_item_id`, `action_item_id`)
VALUES ($discussion_item_id, $action_item_id)
";
		$db->query($query);

		foreach ($arrAssignees AS $contact_id) {
			$query =
"
INSERT
INTO `action_item_assignments` (`action_item_id`, `action_item_assignee_contact_id`)
VALUES ($action_item_id, $contact_id)
";
			$db->query($query);
		}
		$db->commit();
		echo $discussion_item_id;

		break;

	case 'reloadActions':

		$discussion_item_id = Data::parseInt($get->discussion_item_id);
		$meeting_type_id = Data::parseInt($get->meeting_type_id);

		$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);
		$arrContactOptions[0] = 'Select Assignee';
		foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
			/* @var $contact Contact */
			$contactFullName = $contact->getContactFullName();
			$arrContactOptions[$contact_id] = $contactFullName;
		}

		$arrDiscussionItemIds = array($discussion_item_id);
		$arrActionItemsByDiscussionItemIds = ActionItem::loadActionItemsByArrDiscussionItemIds($database, $arrDiscussionItemIds);

		// Build the action table and assign it to a variable
		$isPrintView = false;
		$meetingInput = new Input();
		$meetingInput->database = $database;
		$meetingInput->arrContactOptions = $arrContactOptions;
		$meetingInput->userCanCreateActionItems = $userCanCreateActionItems;
		$meetingInput->userCanManageMeetings = $userCanManageMeetings;
		$meetingInput->actionShowElement = $actionShowElement;
		$meetingInput->actionEditElement = $actionEditElement;
		$meetingInput->isPrintView = $isPrintView;

		$actionItemsTableByDiscussionItemId = buildMeetingActionItemsTableByDiscussionItemId($arrActionItemsByDiscussionItemIds, $discussion_item_id, $meetingInput);

		echo $actionItemsTableByDiscussionItemId;

		break;

	case 'addActionAssignee':

		//$discussion_item_id = Data::parseInt($get->discussion_item_id);
		$action_item_id = Data::parseInt($get->action_item_id);
		$contact_id = Data::parseInt($get->contact_id);

		$message->enqueueError('|Unable to add assignee to action', $currentPhpScript);

		$query =
"
SELECT *
FROM `action_item_assignments`
WHERE `action_item_id` = $action_item_id
AND `action_item_assignee_contact_id` = $contact_id
";
		$db->execute($query, array(), MYSQLI_STORE_RESULT);

		if ($db->rowCount == 0) {
			$query =
"
INSERT
INTO `action_item_assignments` (`action_item_id`, `action_item_assignee_contact_id`)
VALUES($action_item_id, $contact_id)
";
			$db->query($query);
			$reload = 1;
		} else {
			$reload = 0;
		}

		//echo $reload .'|'. $discussion_item_id . '|' . $action_item_id;
		echo $reload .'|'. $action_item_id;

		break;

	case 'removeActionAssignee':

		$action_item_id = Data::parseInt($get->action_item_id);
		$contact_id = Data::parseInt($get->contact_id);

		$message->enqueueError('|Unable to remove assignee from action', $currentPhpScript);

		$query =
"
DELETE
FROM `action_item_assignments`
WHERE `action_item_id` = $action_item_id
AND `action_item_assignee_contact_id` = $contact_id
";
		$db->query($query);

		echo '1|' . $action_item_id;

		break;

	case 'reloadAssigneesForAction':

		$action_item_id = Data::parseInt($get->action_item_id);

		$loadActionItemAssignmentsByActionItemIdOptions = new Input();
		$loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
		$loadActionItemAssignmentsByActionItemIdOptions->arrOrderByAttributes = array(
			'aia_fk_ai_assignee_c.`first_name`' => 'ASC',
			'aia_fk_ai_assignee_c.`last_name`' => 'ASC',
		);
		$arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $action_item_id, $loadActionItemAssignmentsByActionItemIdOptions);

		$listItems = buildAssigneeListItemsForActionItem($action_item_id, $arrActionItemAssignmentsByActionItemId);

		echo $listItems;

		break;

	case 'updateMeetingItem':

		if ($userCanManageMeetings) {
			$elementType = $get->elementId;
			$meeting_id = Data::parseInt($get->meeting_id);
			$newValue = $get->newValue;
			$elementId = 'edit_' . $elementType;
			$message->enqueueError($elementId.'|Unable to update meeting item', $currentPhpScript);

			$arrFields = array(
				'meeting_start_date' => 'meeting_start_date',
				'next_meeting_start_date' => 'next_meeting_start_date',
				'meeting_start_time' => 'meeting_start_time',
				'next_meeting_start_time' => 'next_meeting_start_time',
				//'meeting_location' => 'meeting_location',
				'next_meeting_location' => 'next_meeting_location'
			);
			if (!isset($arrFields[$elementType])) {
				$message->enqueueError("Invalid attribute.", $currentPhpScript);
				trigger_error("Insufficient Permission");
			}

			$dbAttribute = $arrFields[$elementType];

			if ($elementType == 'meeting_start_date' || $elementType == 'next_meeting_start_date') {
				$newValue = date('Y-m-d',strtotime($newValue));
				$messageTitle = "date";
			} elseif ($elementType == 'meeting_start_time' || $elementType == 'next_meeting_start_time') {
				$newValue = date("H:i", strtotime($newValue));
				$messageTitle = "time";
			} elseif ($elementType == 'meeting_location' || $elementType == 'next_meeting_location') {
				$messageTitle = "location";
			}

			$query =
"
UPDATE
`meetings`
SET `$dbAttribute` = ?, `modified` = NULL, `modified_by_contact_id` = ?
WHERE `id` = ?
";
			$arrValues = array($newValue, $currentlyActiveContactId, $meeting_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			echo $elementType . '|' . $messageTitle;

		} else {
			$message->enqueueError("You do not have permission to update discussion items", $currentPhpScript);
			trigger_error("Insufficient Permission");
		}

		break;

	case 'updateDiscussionItem':

		if ($userCanManageMeetings) {
			$elementType = $get->elementId;
			$discussion_item_id = Data::parseInt($get->discussion_item_id);
			$newValue = $get->newValue;
			$elementId = 'edit_' . $elementType . '_' . $discussion_item_id;

			$message->enqueueError($elementId.'|Unable to update discussion item', $currentPhpScript);

			$arrFields = array(
				'discussion_item_title' => 1,
				'discussion_item' => 1,
				'status' => 1
			);

			if (!isset($arrFields[$elementType])) {
				$message->enqueueError("You are a very bad person!", $currentPhpScript);

				trigger_error("Insufficient Permission");
			}

			$query =
"
UPDATE
`discussion_items`
SET `$elementType` = ?
WHERE `id` = ?
";
			$arrValues = array($newValue,$discussion_item_id);
			$db->execute($query,$arrValues,MYSQLI_USE_RESULT);

			//echo $elementType . '|' . $meeting_id;
			echo $elementType . '_' . $discussion_item_id;
		} else {
			$message->enqueueError("You do not have permission to update discussion items", $currentPhpScript);

			trigger_error("Insufficient Permission");
		}
		break;

	case 'toggleAttendee':

		if ($userCanManageMeetings) {
			$meeting_id = Data::parseInt($get->meeting_id);
			$contact_id = Data::parseInt($get->contact_id);
			$elementId = 'edit_meetingAttendee_' . $contact_id;

			$message->enqueueError($elementId.'|Unable to update attendee', $currentPhpScript);

			$query =
"
SELECT *
FROM `meeting_attendees`
WHERE `meeting_id` = $meeting_id
AND `contact_id` = $contact_id
";
			$db->execute($query,array(),MYSQLI_STORE_RESULT);
			if ($db->rowCount == 0) {
				$query =
"
INSERT
INTO `meeting_attendees` (`meeting_id`, `contact_id`)
VALUES($meeting_id, $contact_id)
";
				$db->query($query);
				$displayIt = 1;
			} else {
				$query =
"
DELETE
FROM `meeting_attendees`
WHERE `meeting_id` = $meeting_id
AND `contact_id` = $contact_id
";
				$db->query($query);
				$displayIt = 0;
			}
			$db->free_result();
			echo $contact_id . '|' . $displayIt;
		} else {
			$message->enqueueError("You do not have permission to update action items", $currentPhpScript);
			trigger_error("Insufficient Permission");
		}

		break;

	case 'deleteMeeting':

		if ($userCanManageMeetings) {
			$meeting_id = Data::parseInt($get->meeting_id);
			$message->enqueueError('Unable to delete the meeting', $currentPhpScript);

			$db = DBI::getInstance($database);

			$meeting = Meeting::findById($database, $meeting_id);
			$meeting->delete();

			break;


			$db->begin();
			// Select all action items that are not associated with any other discussion items.
			$query =
"
SELECT `action_item_id`
FROM `discussion_items_to_action_items`
WHERE `action_item_id` IN(
	SELECT ai.`id`
	FROM `action_items` ai, `discussion_items_to_action_items` di2ai, `discussion_items` di
	WHERE ai.`id` = di2ai.`action_item_id`
	AND di2ai.`discussion_item_id` = di.`id`
	AND di.`meeting_id` = ?
)
GROUP BY `action_item_id`
HAVING COUNT(`action_item_id`) = 1 ;
";
			$arrValues = array($meeting_id);
			$db->execute($query, $arrValues);
			$arrActionItemIds = array();
			while ($row = $db->fetch()) {
				$action_item_id = $row['action_item_id'];
				$arrActionItemIds[] = $action_item_id;
			}
			$db->free_result();
			$csvActionItemIds = join(',', $arrActionItemIds);

			// Select all discussion_ids in the action to discussion relationship table
			$query =
"
SELECT `id`
FROM `discussion_items` di
WHERE `meeting_id` = ? ;
";
			$arrValues = array($meeting_id);
			$db->execute($query, $arrValues);
			$arrDiscussionIds = array();
			while ($row = $db->fetch()) {
				$discussion_item_id = $row['id'];
				$arrDiscussionIds[] = $discussion_item_id;
			}
			$db->free_result();
			$csvDiscussionItemIds = join(',', $arrDiscussionIds);

			if (isset($csvDiscussionItemIds) && !empty($csvDiscussionItemIds)) {
				// Delete all action_ids in the action to discussion relationship table
				$query =
"
DELETE
FROM `discussion_items_to_action_items`
WHERE `discussion_item_id` IN($csvDiscussionItemIds);
";
				$db->execute($query);
				$db->free_result();
			}

			if (isset($csvActionItemIds) && !empty($csvActionItemIds)) {
				// Delete all action item assignments of action items not associated with any other discussion items.
				$query =
"
DELETE
FROM `action_item_assignments`
WHERE `action_item_id` IN($csvActionItemIds);
";
				$db->execute($query);
				$db->free_result();


				// Delete all action items that are not associated with any other discussion items.
				$query =
"
DELETE
FROM `action_items`
WHERE `id` IN($csvActionItemIds);
";
				$db->execute($query);
				$db->free_result();
			}

			// Delete all comments associated with discussion items in this meeting
			$query =
"
SELECT dic.`id`
FROM `discussion_item_comments` dic, `discussion_items_to_discussion_item_comments` di2dic, `discussion_items` di
WHERE dic.`id` = di2dic.`discussion_item_comment_id`
AND di2dic.`discussion_item_id` = di.`id`
AND di.`meeting_id` = ? ;
";
			$arrValues = array($meeting_id);
			$db->execute($query, $arrValues);
			$arrDiscussionItemCommentIds = array();
			while ($row = $db->fetch()) {
				$discussion_item_comment_id = $row['id'];
				$arrDiscussionItemCommentIds[] = $discussion_item_comment_id;
			}
			$in = join(',', $arrDiscussionItemCommentIds);

			if (isset($in) && !empty($in)) {
				// Delete all comment_ids in the comment to discussion relationships table
				$query =
"
DELETE
FROM `discussion_items_to_discussion_item_comments`
WHERE `discussion_item_comment_id` IN($in)
";
				$db->execute($query);
				$db->free_result();

				$query =
"
DELETE
FROM `discussion_item_comments`
WHERE `id` IN($in);
";
				$db->execute($query);
				$db->free_result();
			}

			// Delete all discussion items
			$query =
"
DELETE
FROM `discussion_items`
WHERE `meeting_id` = ?
";
			$arrValues = array($meeting_id);
			$db->execute($query, $arrValues);
			$db->free_result();

			// Delete all meeting attendees
			$query =
"
DELETE
FROM `meeting_attendees`
WHERE `meeting_id` = ?
";
			$arrValues = array($meeting_id);
			$db->execute($query, $arrValues);
			$db->free_result();

			// Delete the meeting record
			$query =
"
DELETE
FROM `meetings`
WHERE `id` = ?
";
			$arrValues = array($meeting_id);
			$db->execute($query, $arrValues);
			$db->free_result();

			$db->commit();
		} else {
			$message->enqueueError('You do not have permission to delete meetings', $currentPhpScript);
			trigger_error("Insufficient Permission");
		}

		break;

	case 'deleteDiscussionItem':

		if ($userCanManageMeetings || $userCanCreateDiscussionItems) {

			$discussion_item_id = Data::parseInt($get->discussion_item_id);
			$message->enqueueError('Unable to delete the discussion item', $currentPhpScript);
			$db = DBI::getInstance($database);
			$db->begin();
			// Select all action items that are not associated with any other discussion items.
			$query =
"
SELECT `action_item_id`
FROM `discussion_items_to_action_items`
WHERE `action_item_id` IN(
	SELECT ai.`id`
	FROM `action_items` ai, `discussion_items_to_action_items` di2ai
	WHERE ai.`id` = di2ai.`action_item_id`
	AND di2ai.`discussion_item_id` = ?
)
GROUP BY `action_item_id`
HAVING COUNT(`action_item_id`) = 1 ;
";
			$arrValues = array($discussion_item_id);
			$db->execute($query, $arrValues);
			$arrActionItemIds = array();
			while ($row = $db->fetch()) {
				$action_item_id = $row['action_item_id'];
				$arrActionItemIds[] = $action_item_id;
			}
			$db->free_result();
			$csvActionItemIds = join(',', $arrActionItemIds);

			// Delete all action_ids in the action to discussion relationship table
			$query =
"
DELETE
FROM `discussion_items_to_action_items`
WHERE `discussion_item_id` = $discussion_item_id;
";
			$db->execute($query);
			$db->free_result();

			if (isset($csvActionItemIds) && !empty($csvActionItemIds)) {
			// Delete all action item assignments of action items not associated with any other discussion items.
				$query =
"
DELETE
FROM `action_item_assignments`
WHERE `action_item_id` IN($csvActionItemIds);
";
				$db->execute($query);
				$db->free_result();


				// Delete all action items that are not associated with any other discussion items.
				$query =
"
DELETE
FROM `action_items`
WHERE `id` IN($csvActionItemIds);
";
				$db->execute($query);
				$db->free_result();
			}

			// Delete all comments associated with discussion items in this meeting
			$query =
"
SELECT dic.`id`
FROM `discussion_item_comments` dic, `discussion_items_to_discussion_item_comments` di2dic
WHERE dic.`id` = di2dic.`discussion_item_comment_id`
AND di2dic.`discussion_item_id` = ? ;
";
			$arrValues = array($discussion_item_id);
			$db->execute($query, $arrValues);
			$arrDiscussionItemCommentIds = array();
			while ($row = $db->fetch()) {
				$discussion_item_comment_id = $row['id'];
				$arrDiscussionItemCommentIds[] = $discussion_item_comment_id;
			}
			$db->free_result();
			$in = join(',', $arrDiscussionItemCommentIds);

			if (isset($in) && !empty($in)) {
				// Delete all comment_ids in the comment to discussion relationships table
				$query =
"
DELETE
FROM `discussion_items_to_discussion_item_comments`
WHERE `discussion_item_comment_id` IN($in)
";
				$db->execute($query);
				$db->free_result();

				$query =
"
DELETE
FROM `discussion_item_comments`
WHERE `id` IN ($in);
";
				$db->execute($query);
				$db->free_result();
			}

			// Delete the discussion item
			$query =
"
DELETE
FROM `discussion_items`
WHERE `id` = ?
";
			$arrValues = array($discussion_item_id);
			$db->execute($query, $arrValues);
			$db->free_result();

			$db->commit();

			echo $discussion_item_id;

		} else {
			$message->enqueueError('You do not have permission to delete meetings', $currentPhpScript);
			trigger_error("Insufficient Permission");
		}

		break;

	case 'loadEmailWindow':

		// @todo Convert meeting_type to meeting_type_id
		$meeting_type = (string) $get->meeting_type;
		$arrAssignedRolesByProject = ProjectToContactToRole::loadAssignedRolesByProjectId($database, $project_id);

		$htmlContent = <<<END_HTML_CONTENT

			<table width="100%" border="0">
				<tr valign="top">
					<td>
						<div class="permissionTableMainHeader">Who would you like to send this email to?</div>
						<div class="accordionEmailOptions emailOptions">
							<div class="emailGroupSubcategory">Predefined Groups</div>
							<div>
								<div class="evenRow" onclick="addMeetingAttendeesToSelectedList();">Meeting Attendees</div>
								<div class="evenRow" onclick="addProjectContactsToSelectedList();">All Project Contacts That Can View $meeting_type's</div>
							</div>
END_HTML_CONTENT;

		if (count($arrAssignedRolesByProject) > 0) {
			$htmlContent .= <<<END_HTML_CONTENT

							<div class="emailGroupSubcategory">Project Contacts Filtered By Role</div>
							<div>
END_HTML_CONTENT;
			$loopCounter = 0;
			foreach ($arrAssignedRolesByProject AS $role_id => $role) {
				if ($loopCounter%2) {
					$rowStyle = 'evenRow';
				} else {
					$rowStyle = 'evenRow';
				}
				$roleName = $role->role;
				if ($role_id == 3) {
					$roleName = 'All Project Contacts';
				}
				$htmlContent .= <<<END_HTML_CONTENT

								<div class="$rowStyle" onclick="addContactsWithRoleToSelectedList('$role_id');">$roleName</div>
END_HTML_CONTENT;
				$loopCounter ++;
			}
				$htmlContent .= <<<END_HTML_CONTENT

							</div>
END_HTML_CONTENT;
		}

		// @todo Refactor these to come from View objects
		$javaScriptHandler = 'emailMeetingReport';
		include('page-components/contact_search_by_contact_company_name_or_contact_name.php');

		$htmlContent .= <<<END_HTML_CONTENT

							<div class="emailGroupSubcategory">Search For Individuals</div>
							<div>
								<div id="emailMeetingReport" class="contact-search-parent-container" style="height: 300px;">
									$contact_search_form_by_contact_company_name_or_contact_name_html
									$contact_search_form_by_contact_company_name_or_contact_name_javascript
								</div>
							</div>
						</div>
						<div class="permissionTableMainHeader">Additional Comments</div>
						<textarea id="adHocEmailMessageText" style="width:98.4%" class="autogrow" placeholder="Add addional comments to the email"></textarea>
					</td>
					<td width="30%">
						<input id="csvContactIds" name="csvContactIds" type="hidden">
						<input id="csvNoContactIds" name="csvContactIds" type="hidden">
						<table id="tblSelectedItems" cellpadding="3" cellspacing="0">
							<tr>
								<th colspan="2" style="text-align: left;">Selected Recipients</th>
							</tr>
						</table>
					</td>
				<tr>
			<table>
END_HTML_CONTENT;

			echo $htmlContent;

		break;

	case 'addMeetingAttendeesToList':

		$meeting_id = Data::parseInt($get->meeting_id);

		$arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingIdAndProjectId($database, $meeting_id, $project_id);
		$arrContacts = array();
		foreach($arrMeetingAttendeesByMeetingId as $meeting_attendee_id => $meetingAttendee) {
			/* @var $meetingAttendee MeetingAttendee */

			$contact = $meetingAttendee->getContact();
			/* @var $contact Contact */

			$contactCompany = $contact->getContactCompany();
			/* @var $contactCompany ContactCompany */

			$contactCompany->htmlEntityEscapeProperties();
			$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;

			$contact->htmlEntityEscapeProperties();
			$contactFullNameHtmlEscaped = $contact->getContactFullNameHtmlEscaped();

			$contact_id = $contact->contact_id;
			$escaped_first_name = $contact->escaped_first_name;
			$escaped_last_name = $contact->escaped_last_name;
			$escaped_email = $contact->getContactFullEmail();
			$is_archive = $contact->is_archive;

			$arrContacts[] = array(
				'contact_id' => $contact_id,
				'company_name' => $escaped_contact_company_name,
				'fullName' => $contactFullNameHtmlEscaped,
				'first_name' => $escaped_first_name,
				'last_name' => $escaped_last_name,
				'email' => $escaped_email,
				'is_archive' => $is_archive
			);
		}

		$jsonOutput = json_encode($arrContacts);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

	case 'addProjectContactsToList':

		$meeting_type_id = Data::parseInt($get->meeting_type_id);

		$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);
		$arrContacts = array();
		foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
			/* @var $contact Contact */

			$contactCompany = $contact->getContactCompany();
			/* @var $contactCompany ContactCompany */

			$contactCompany->htmlEntityEscapeProperties();
			$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;

			$contact->htmlEntityEscapeProperties();
			$contactFullNameHtmlEscaped = $contact->getContactFullNameHtmlEscaped();

			$contact_id = $contact->contact_id;
			$escaped_first_name = $contact->escaped_first_name;
			$escaped_last_name = $contact->escaped_last_name;
			$escaped_email = $contact->getContactFullEmail();
			$is_archive = $contact->is_archive;

			$arrContacts[] = array(
				'contact_id' => $contact_id,
				'company_name' => $escaped_contact_company_name,
				'fullName' => $contactFullNameHtmlEscaped,
				'first_name' => $escaped_first_name,
				'last_name' => $escaped_last_name,
				'email' => $escaped_email,
				'is_archive' => $is_archive
			);
		}

		$jsonOutput = json_encode($arrContacts);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

	case 'addContactsWithRoleToSelectedList':

		$role_id = Data::parseInt($get->role_id);

		$arrContactsByProjectIdAndRoleId = ProjectToContactToRole::loadContactsByProjectIdAndRoleId($database, $project_id, $role_id);
		$arrContacts = array();
		foreach ($arrContactsByProjectIdAndRoleId AS $contact_id => $contact) {
			/* @var $contact Contact */

			$contactCompany = $contact->getContactCompany();
			/* @var $contactCompany ContactCompany */

			$contactCompany->htmlEntityEscapeProperties();
			$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;

			$contact->htmlEntityEscapeProperties();
			$contactFullNameHtmlEscaped = $contact->getContactFullNameHtmlEscaped();

			$contact_id = $contact->contact_id;
			$escaped_first_name = $contact->escaped_first_name;
			$escaped_last_name = $contact->escaped_last_name;
			$escaped_email = $contact->getContactFullEmail();
			$is_archive = $contact->is_archive;

			$arrContacts[] = array(
				'contact_id' => $contact_id,
				'company_name' => $escaped_contact_company_name,
				'fullName' => $contactFullNameHtmlEscaped,
				'first_name' => $escaped_first_name,
				'last_name' => $escaped_last_name,
				'email' => $escaped_email,
				'is_archive' => $is_archive
			);
		}

		$jsonOutput = json_encode($arrContacts);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

		break;

	case 'loadImportDiscussionOptionsWindow':

		$meeting_id = Data::parseInt($get->meeting_id);
		$previous_meeting_id = Data::parseInt($get->previous_meeting_id);

		// Check for discussion items to import
		$arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType = DiscussionItem::loadDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType($database, $previous_meeting_id);
		if (isset($arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType['Open'])) {
			$openDiscussionItemCount = $arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType['Open'];
		} else {
			$openDiscussionItemCount = 0;
		}
		if (isset($arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType['Closed'])) {
			$closedDiscussionItemCount = $arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType['Closed'];
		} else {
			$closedDiscussionItemCount = 0;
		}
		if (isset($arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType['All'])) {
			$allTypesDiscussionItemCount = $arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType['All'];
		} else {
			$allTypesDiscussionItemCount = 0;
		}

		$htmlContent = <<<END_HTML_CONTENT

<form id="frmImportItems" name="frmImportItems">
	<table cellpadding="5">
		<tr>
			<td>Where would you like to import discussion items from?</td>
		</tr>
		<tr>
			<td>
				<input id="lastMeetingOpenOnly" name="importFrom" type="radio" value="lastMeetingOpenOnly">
				<label for="lastMeetingOpenOnly" style="float:none"> Last Meeting (Open Items Only) &mdash; $openDiscussionItemCount
			</td>
		</tr>
		<tr>
			<td>
				<input id="lastMeetingAll" name="importFrom" type="radio" value="lastMeetingAll">
				<label for="lastMeetingAll" style="float:none"> Last Meeting (All Items) &mdash; $allTypesDiscussionItemCount
			</td>
		</tr>
	</table>
</form>
END_HTML_CONTENT;
			echo $htmlContent;

		break;

	case 'importDiscussionItems':

		if ($userCanManageMeetings) {
			$meeting_id = Data::parseInt($get->meeting_id);
			$previous_meeting_id = Data::parseInt($get->previous_meeting_id);
			$importType = $get->importType;

			$openStatusOnly = false;
			if ($importType == 'lastMeetingOpenOnly') {
				$openStatusOnly = true;
			}

			/*
			$arrOptions = array('lastMeetingAll'=>-1,'lastMeetingOpenOnly'=>0);

			if (!isset($arrOptions[$itemsToImport])) {

				$message->enqueueError("You are a very bad person!", $currentPhpScript);

				trigger_error("Insufficient Permission");
				exit;
			} else {
				$statusParam = $arrOptions[$itemsToImport];
				//echo $statusParam;
			}
			*/

			$loadDiscussionItemsByMeetingIdOptions = new Input();
			$loadDiscussionItemsByMeetingIdOptions->forceLoadFlag = true;
			$arrDiscussionItemsByPreviousMeetingId = DiscussionItem::loadDiscussionItemsByMeetingId($database, $previous_meeting_id, $loadDiscussionItemsByMeetingIdOptions);

			$loadDiscussionItemsToActionItemsByDiscussionItemIdOptions = new Input();
			$loadDiscussionItemsToActionItemsByDiscussionItemIdOptions->forceLoadFlag = true;

			$loadDiscussionItemCommentsByDiscussionItemIdOptions = new Input();
			$loadDiscussionItemCommentsByDiscussionItemIdOptions->forceLoadFlag = true;


			foreach ($arrDiscussionItemsByPreviousMeetingId as $previous_discussion_item_id => $previousDiscussionItem) {
				/* @var $previousDiscussionItem DiscussionItem */
				$discussion_item_status_id = $previousDiscussionItem->discussion_item_status_id;
				$previousDiscussionItemStatus = $previousDiscussionItem->getDiscussionItemStatus();
				/* @var $previousDiscussionItemStatus DiscussionItemStatus */
				$previous_discussion_item_status = $previousDiscussionItemStatus->discussion_item_status;
				// Check status. Do not import if status is closed and we only want open statuseses.
				if (!$openStatusOnly || ($openStatusOnly && $previous_discussion_item_status == 'Open')) {
					// Create DiscussionItem.
					$data = $previousDiscussionItem->getData();
					$data['id'] = null;
					$data['meeting_id'] = $meeting_id;
					$discussionItem = new DiscussionItem($database);
					$discussionItem->setData($data);
					$discussion_item_id = $discussionItem->save();

					// Create a DiscussionItemToActionItem record for each of the previous DiscussionItemToActionItems.
					$arrDiscussionItemToActionItemsByPreviousDiscussionItemId = DiscussionItemToActionItem::loadDiscussionItemsToActionItemsByDiscussionItemId($database, $previous_discussion_item_id, $loadDiscussionItemsToActionItemsByDiscussionItemIdOptions);
					foreach ($arrDiscussionItemToActionItemsByPreviousDiscussionItemId as $previousDiscussionItemToActionItem) {
						$data = $previousDiscussionItemToActionItem->getData();
						$actClone=$data['action_item_id'];
						$data['discussion_item_id'] = $discussion_item_id;
						//To insert the Action items
						$db=DBI::getInstance($database);
						$actionque ="INSERT INTO `action_items`(SELECT NULL, `project_id`, `action_item_type_id`, `action_item_type_reference_id`, `action_item_sequence_number`, `action_item_status_id`, `action_item_priority_id`, `action_item_cost_code_id`, `created_by_contact_id`, `action_item_title`, `action_item`, `created`, `action_item_due_date`, `action_item_completed_timestamp`, `sort_order` From action_items where id=$actClone)";
						$db->execute($actionque);
						$newActionId=$db->insertId;
						$db->free_result();
						$data['action_item_id'] = $newActionId;
						//End To insert the Action items
						//To insert the action_item_assignments
						$db=DBI::getInstance($database);
						$actAssign ="SELECT * From `action_item_assignments` WHERE `action_item_id` = $actClone";
						$db->execute($actAssign);
						$assineearr=array();
						while ($row=$db->fetch()) {
							$assineearr[]=$row;
						}
						foreach ($assineearr as $key => $row) {
							
							$assContact=$row['action_item_assignee_contact_id'];
							$db=DBI::getInstance($database);
							$Assign ="INSERT into `action_item_assignments` (`action_item_id`, `action_item_assignee_contact_id`) VALUES ($newActionId,'".$assContact."') ";
							$db->execute($Assign);
						}
						$db->free_result();
						$data['action_item_id'] = $newActionId;

						//End of action_item_assignments
						// To romove the action_item_type_id from the data array
						unset($data['action_item_type_id']);
						$discussionItemToActionItem = new DiscussionItemToActionItem($database);
						$discussionItemToActionItem->setData($data);
						$discussionItemToActionItem->save();
					}

					// Create DiscussionItemComments.
					$arrDiscussionItemCommentsByPreviousDiscussionItemId = DiscussionItemComment::loadDiscussionItemCommentsByDiscussionItemId($database, $previous_discussion_item_id, $loadDiscussionItemCommentsByDiscussionItemIdOptions);
					foreach ($arrDiscussionItemCommentsByPreviousDiscussionItemId as $discussion_item_comment_id => $previousDiscussionItemComment) {
						$data = $previousDiscussionItemComment->getData();
						$data['id'] = null;
						$data['discussion_item_id'] = $discussion_item_id;
						$discussionItemComment = new DiscussionItemComment($database);
						$discussionItemComment->setData($data);
						$discussionItemComment->save();
					}
				}
			}

			
		} else {
			$message->enqueueError("You do not have permission to import discussion items", $currentPhpScript);
			trigger_error("Insufficient Permission");
		}

		break;

	case 'toggleCommentVisibility':

		if ($userCanManageMeetings) {
			$discussion_item_comment_id = Data::parseInt($get->discussion_item_comment_id);
			$newValue = (string) $get->newValue;
			if (($newValue == 0) || ($newValue == 'N')) {
				$newValue = 'N';
			} else {
				$newValue = 'Y';
			}

			$query =
"
UPDATE
`discussion_item_comments`
SET `is_visible_flag` = ?
WHERE `id` = ?
";
			$arrValues = array($newValue, $discussion_item_comment_id);
			$db->execute($query, $arrValues);

			echo $discussion_item_comment_id;
		}
		break;

	case 'loadManageMeetingLocationsDialog':

		$reopenCreateMeetingDialog = $get->reopenCreateMeetingDialog;
		$reopenCreateMeetingDialogInput = '';
		if ($reopenCreateMeetingDialog == '1') {
			$reopenCreateMeetingDialogInput = '<input type="hidden" id="reopenCreateMeetingDialog" value="1">';
		}

		$loadMeetingLocationsByUserCompanyIdOptions = new Input();
		$loadMeetingLocationsByUserCompanyIdOptions->forceLoadFlag = true;
		$arrMeetingLocations = MeetingLocation::loadMeetingLocationsByUserCompanyId($database, $user_company_id, $loadMeetingLocationsByUserCompanyIdOptions);
		$tableMeetingLocationsTbody = '';
		foreach ($arrMeetingLocations as $meeting_location_id => $meetingLocation) {
			/* @var $meetingLocation MeetingLocation */
			$meeting_location = $meetingLocation->meeting_location;
			$attributeGroupName = 'manage-meeting_location-record';
			$elementId = $attributeGroupName.'--meeting_locations--sort_order--'.$meeting_location_id;
			$tableMeetingLocationsTbody .=
			'
			<tr id="'.$elementId.'">
				<td class="textAlignLeft">'.$meeting_location.'</td>
				<td class="textAlignCenter"><a href="javascript:deleteMeetingLocation(\''.$elementId.'\', \''.$attributeGroupName.'\',  \''.$meeting_location_id.'\');">X</a></td>
			</tr>
			';
		}
		if (count($arrMeetingLocations) == 0) {
			$tableMeetingLocationsTbody = '<tr><td class="textAlignLeft" colspan="2">No data.</tr>';
		}

		$attributeGroupName = 'create-meeting_location-record';
		$uniqueId = '';

		$htmlContent = <<<END_HTML_CONTENT

		<div id="container--$attributeGroupName--$uniqueId" class="widgetContainer" style="width: 500px; font-size: 0.9em;">
			<h3 class="title">Create Meeting Location</h3>
			<form id="formCreateMeetingLocation">
				<table class="content" width="95%" cellpadding="5px">
					<tr>
						<td class="textAlignRight verticalAlignMiddle">Location:</td>
						<td class="textAlignLeft"><input type="text" id="$attributeGroupName--meeting_locations--meeting_location--$uniqueId" class="required" style="width: 380px"></td>
					</tr>
					<tr>
						<td class="textAlignRight" colspan="2"><input type="button" value="Create Meeting Location" onclick="Collaboration_Manager__Meetings__createMeetingLocation('$attributeGroupName', '$uniqueId');"></td>
					</tr>
				</table>
			</form>
		</div>
		<table id="tableMeetingLocations" cellpadding="5px" width="100%" style="font-size: 0.9em;">
			<thead class="borderBottom">
				<tr>
				<th class="textAlignLeft">Meeting Location</th>
				<th class="textAlignCenter">Delete</th>
				</tr>
			</thead>
			<tbody class="altColors">
				$tableMeetingLocationsTbody
			</tbody>
		</table>
		$reopenCreateMeetingDialogInput
END_HTML_CONTENT;

		echo $htmlContent;

		break;

	case 'loadMeetingsByMeetingTypeId':

		$meeting_type_id = Data::parseInt($get->meeting_type_id);

		$loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
		$loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
		$arrMeetingsByProjectIdAndMeetingTypeId = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id, $loadMeetingsByProjectIdAndMeetingTypeIdOptions);
		$options = '<option value="">Select A Meeting</option>';
		foreach ($arrMeetingsByProjectIdAndMeetingTypeId as $meeting_id => $meeting) {
			/* @var $meeting Meeting */
			$meeting_sequence_number = $meeting->meeting_sequence_number;
			$options .= '<option value="'.$meeting_id.'">Meeting '.$meeting_sequence_number.'</option>';
		}
		if (count($arrMeetingsByProjectIdAndMeetingTypeId) == 0) {
			$options = '<option value="">No Meetings Exist</option>';
		}

		echo $options;

		break;

	case 'loadMeetingAttendeesByMeetingTypeId':

		$meeting_type_id = Data::parseInt($get->meeting_type_id);

		$arrListedContacts = array();
		$arrMeetingAttendeesByMeetingId = array();
		$arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);
		$meetingAttendeesTableTbody = <<<END_HTML_CONTENT

		<tr>
			<td style="padding-bottom: 10px;">
				<input id="checkboxCheckAll" type="checkbox" onclick="createMeetingToggleAllAttendees(this, '$attributeGroupName')">
				<label for="checkboxCheckAll" style="float: none;">Toggle All</label>
			</td>
		</tr>
END_HTML_CONTENT;
		foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
			$contactFullName = $contact->getContactFullName();
			$encodedContactFullName = Data::entity_encode($contactFullName);

			if (!isset($arrListedContacts[$contact_id])) {
				$isCheckedAttribute = "";
				if (isset($arrMeetingAttendeesByMeetingId[$contact_id])) {
					$isCheckedAttribute = ' checked';
				}
				$meetingAttendeeCheckBoxElementId = $attributeGroupName.'--meeting_attendees--contact_id--'.$contact_id;
				$meetingAttendeesTableTbody .= <<<END_HTML_CONTENT

				<tr>
					<td>
						<input id="$meetingAttendeeCheckBoxElementId" class="$attributeGroupName--meetingAttendee" type="checkbox"$isCheckedAttribute onchange="toggleAttendee('$contact_id');" value="$contact_id">
						<label for="$meetingAttendeeCheckBoxElementId" style="float: none;">$encodedContactFullName</label>
					</td>
				</tr>
END_HTML_CONTENT;
				$arrListedContacts[$contact_id] = 1;
			}
		}

		echo $meetingAttendeesTableTbody;

		break;

	case 'loadDdlMeetingTypes':

		$loadMeetingTypesByProjectIdOptions = new Input();
		$loadMeetingTypesByProjectIdOptions->forceLoadFlag = true;
		$arrMeetingTypes = MeetingType::loadMeetingTypesByProjectId($database, $project_id, $loadMeetingTypesByProjectIdOptions);
		$htmlContent = '<option value="">Please Select A Meeting Type</option>';
		foreach ($arrMeetingTypes as $meeting_type_id => $meetingType) {
			$meeting_type = $meetingType->meeting_type;
			$htmlContent .= <<<END_HTML_CONTENT

			<option value="$meeting_type_id">$meeting_type</option>
END_HTML_CONTENT;
		}
		if (count($arrMeetingTypes) == 0) {
			$htmlContent = '<option value="-2">No Meeting Types Exist</option>';
		}

		echo $htmlContent;

		break;
		case 'loadRenderPDF':
		try{
			$meeting_type = (string) $get->meeting_type;
			$meeting_id = (int) $get->meeting_id;
			// DATABASE VARIABLES
			$db = DBI::getInstance($database);

			// date_default_timezone_set('Asian/kolkata');
			$timezone = date_default_timezone_get();
			$dates = date('d-m-Y h', time());
			$i=date('i', time());
			$s=date('s a', time());
			$a=date('a', time());
			$timedate=date('m/d/Y h:i a', time());
			// SESSSION VARIABLES
			/* @var $session Session */
			$user_company_id = $session->getUserCompanyId();
			$user_id = $session->getUserId();
			$userRole = $session->getUserRole();
			$primary_contact_id = $session->getPrimaryContactId();
			$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
			$project_id = $session->getCurrentlySelectedProjectId();
			$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
			$project_name = $session->getCurrentlySelectedProjectName();
			$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
			$userRole = $session->getUserRole();
			$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
			$userCompany = UserCompany::findById($database, $currentlySelectedProjectUserCompanyId);
			$user_company_name = $userCompany->user_company_name;
			// require_once('module-report-ajax.php');
			require_once('module-report-meeting-functions.php');
			/*RFI Functions*/
			require_once('lib/common/RequestForInformationPriority.php');
			require_once('lib/common/RequestForInformationRecipient.php');
			require_once('lib/common/RequestForInformationResponse.php');
			require_once('lib/common/RequestForInformationResponseType.php');
			require_once('lib/common/RequestForInformationStatus.php');
			require_once('lib/common/RequestForInformationType.php');
			require_once('lib/common/RequestForInformation.php');
			/*Submittal Functions*/
			require_once('lib/common/Submittal.php');
			require_once('lib/common/SubmittalDistributionMethod.php');
			require_once('lib/common/SubmittalDraftAttachment.php');
			require_once('lib/common/SubmittalPriority.php');
			require_once('lib/common/SubmittalRecipient.php');
			require_once('lib/common/SubmittalStatus.php');
			require_once('lib/common/SubmittalType.php');
			/*dompdf*/
			require_once('dompdf/dompdf_config.inc.php');

			$meetingData = meetingDataPreview($database, $project_id, '', $meeting_id, $currentlySelectedProjectName);
			$htmlContent = $meetingData;
			$type_mention= "";
			/*html content with header*/
			$htmlContentWHeader = meetingDataPreviewWithHeader($database, $user_company_id, $project_name, $type_mention, $htmlContent);
			// Save the file_manager_folders record (virtual_file_path) to the db and get the id
			// $virtual_file_path = '/Meetings/Meeting #' . $meeting_id . '/';
			$virtual_file_path = '/Meetings/'. $meeting_type . '/';			
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$currentVirtualFilePath = '/';
			foreach ($arrFolders as $folder) {
				$tmpVirtualFilePath = array_shift($arrFolders);
				$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
				// Save the file_manager_folders record (virtual_file_path) to the db and get the id
				$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $project_id, $currentVirtualFilePath);
			}
			/* @var $fileManagerFolder FileManagerFolder */

			// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
			$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
			// Copy all pdf files to the server's local disk
			$config = Zend_Registry::get('config');
			$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
			$baseDirectory = $config->system->base_directory;
			$fileManagerBasePath = $config->system->file_manager_base_path;
			$fileManagerFileNamePrefix = $config->system->file_manager_file_name_prefix;
			$basePath = $fileManagerBasePath.'frontend/'.$user_company_id;
			$compressToDir = $fileManagerBasePath.'temp/'.$user_company_id.'/'.$project_id.'/';
			$urlDirectory = 'downloads/'.'temp/'.$user_company_id.'/'.$project_id.'/';
			$outputDirectory = $baseDirectory.'www/www.axis.com/'.$urlDirectory;

			$tempFileName = File::getTempFileName();
			$tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
			$fileObject = new File();
			$fileObject->mkdir($tempDir, 0777);
			// Build the HTML for the RFI pdf document (html to pdf via DOMPDF)
			$htmlContent = html_entity_decode($htmlContentWHeader);
			$htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
			// Write RFI to temp folder as a pdf document
			$dompdf = new DOMPDF();
			$dompdf->load_html($htmlContent);
			$dompdf->set_paper("letter","landscape");
			// $dompdf->set_paper('A3','landscape');
			// $dompdf->set_paper('ledger');

			$dompdf->render();
			$canvas = $dompdf->get_canvas();
			$font = Font_Metrics::get_font("helvetica", "6");
			$canvas->page_text(1000, 805, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(.66,.66,.66));
			// $canvas->page_text(270, 550, "33302 VALLE ROAD, SUITE 125 | SAN JUAN CAPISTRANO, CA 92675", $font, 8, array(0,0,0) );
			// $canvas->page_text(250, 565, "949.582.2044 | (F)949.582.2041 | WWW.ADVENTCOMPANIES.COM | LIC# 922928", $font, 8, array(0,0,0) );
			$canvas->page_text(35, 1190, "Printed : ".$timedate, $font, 8, array(.66,.66,.66));
			$pdf_content = $dompdf->output();

			// Filename of temporary rfi pdf file
			// pdf file gets 1 in the list
			$tempPdfFile = '00001' . '.' . $tempFileName . '.pdf';
			$tempFilePath = $tempDir . $tempPdfFile;
			file_put_contents ($tempFilePath, $pdf_content);

			$sha1 = sha1_file($tempFilePath);
			$size = filesize($tempFilePath);
			$fileExtension = 'pdf';
			$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);
			/*Meeting info*/
			$meeting = Meeting::findMeetingByIdExtended($database, $meeting_id);
			$created = $meeting->created;
			$meeting_sequence_number = $meeting->meeting_sequence_number;
			$meeting_sequence_number = sprintf("%02d", $meeting_sequence_number);
			// $created = DateTime::createFromFormat('Y-m-d H:i:s', $created);
			// $createdDate = $created->format('m-d-Y');
			// Final RFI pdf document
			$virtual_file_name_tmp = 'Meeting '.$meeting_sequence_number.'.pdf';
			$tmpFileManagerFile = new FileManagerFile($database);
			$tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
			$virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();
			// Convert file content to File object
			$error = null;

			$file = new File();
			$file->sha1 = $sha1;
			//$file->form_input_name = $formFileInputName;
			//$file->error = $error;
			$file->name = $virtual_file_name;
			$file->size = $size;
			//$file->tmp_name = $tmp_name;
			$file->type = $virtual_file_mime_type;
			$file->tempFilePath = $tempFilePath;
			$file->fileExtension = $fileExtension;

			//$arrFiles = File::parseUploadedFiles();
			$file_location_id = FileManager::saveUploadedFileToCloud($database, $file);
						// save the file information to the file_manager_files db table
			$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $currentlyActiveContactId, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
			/* @var $fileManagerFile FileManagerFile */

			$file_manager_file_id = $fileManagerFile->file_manager_file_id;
			FileManagerFile::restoreFromTrash($database,$file_manager_file_id);
			// Potentially update file_location_id
			if ($file_location_id <> $fileManagerFile->file_location_id) {
				$fileManagerFile->file_location_id = $file_location_id;
				$data = array('file_location_id' => $file_location_id);
				$fileManagerFile->setData($data);
				$fileManagerFile->save();
			}

			// Set Permissions of the file to match the parent folder.
			$parent_file_manager_folder_id = $fileManagerFolder->getParentFolderId();
			FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
			FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);
			// Delete temp files
			$fileObject->rrmdir($tempDir);

			// Load PDF files list
			//$arrBidSpreadPdfFilenames =

			$virtual_file_name_url = $uri->cdn . '_' . $file_manager_file_id;
			$virtual_file_name_url_encoded = urlencode($virtual_file_name_url);
			// Debug
			$primaryKeyAsString = $meeting_id;

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				echo $errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error rendering:'.$meeting_type. $meeting_sequence_number .' PDF.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();

			$errorNumber = 1;
			//$errorMessage = 'Error creating: Bid Spread.';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = '';

			// Delete temp files
			if (isset($tempDir) && !empty($tempDir) && is_dir($tempDir)) {
				$fileObject->rrmdir($tempDir);
			}
		}
		break;

	default:
		break;
}

ob_flush();
exit;

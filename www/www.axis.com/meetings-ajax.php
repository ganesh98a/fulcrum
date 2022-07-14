<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
//$init['skip_always_include'] = true;
//$init['skip_session'] = true;
//$init['skip_templating'] = true;
$init['timer'] = false;
$init['timer_start'] = false;
require_once('lib/common/init.php');

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

require_once('lib/common/PageComponents.php');

require_once('lib/common/Meeting.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('modules-collaboration-manager-functions.php');

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('meetings-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewMeetings = $permissions->determineAccessToSoftwareModuleFunction('meetings_view');
$userCanManageMeetings = $permissions->determineAccessToSoftwareModuleFunction('meetings_manage');
*/

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'createMeeting':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';
		$htmlSelectOptions = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meetings_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Meeting data values.';
				$arrErrorMessages = array(
					'Error creating: Meeting.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			$csvMeetingAttendees = $get->csvMeetingAttendees;
			$createFromHidden = $get->createFromHidden;

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meetings';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-meeting-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_id = (int) $get->meeting_id;
			$previous_meeting_id = (int) $get->previous_meeting_id;
			$project_id = (int) $get->project_id;
			$meeting_type_id = (int) $get->meeting_type_id;
			$meeting_location_id = (int) $get->meeting_location_id;
			$meeting_chair_contact_id = (int) $get->meeting_chair_contact_id;
			$modified_by_contact_id = (int) $get->modified_by_contact_id;
			$meeting_sequence_number = (string) $get->meeting_sequence_number;
			$meeting_start_date = (string) $get->meeting_start_date;
			$meeting_start_time = (string) $get->meeting_start_time;
			$meeting_end_date = (string) $get->meeting_end_date;
			$meeting_end_time = (string) $get->meeting_end_time;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			$all_day_event_flag = (string) $get->all_day_event_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the Meeting record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$meeting = new Meeting($database);

			$meeting->setData($httpGetInputData);
			$meeting->convertDataToProperties();

			$meeting_type_id = $meeting->meeting_type_id;
			if (!isset($meeting_type_id)) {
				// Error code here
				$errorMessage = 'Missing meeting type.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
			}

			$nextMeetingSequenceNumberByMeetingTypeId = Meeting::findNextMeetingSequenceNumberByMeetingTypeId($database, $meeting_type_id);
			$meeting->meeting_sequence_number = $nextMeetingSequenceNumberByMeetingTypeId;

			$meeting->project_id = $project_id;

			/*
			$meeting->meeting_id = $meeting_id;
			$meeting->previous_meeting_id = $previous_meeting_id;
			$meeting->project_id = $project_id;
			$meeting->meeting_type_id = $meeting_type_id;
			$meeting->meeting_location_id = $meeting_location_id;
			$meeting->meeting_chair_contact_id = $meeting_chair_contact_id;
			$meeting->modified_by_contact_id = $modified_by_contact_id;
			$meeting->meeting_sequence_number = $meeting_sequence_number;
			$meeting->meeting_start_date = $meeting_start_date;
			$meeting->meeting_start_time = $meeting_start_time;
			$meeting->meeting_end_date = $meeting_end_date;
			$meeting->meeting_end_time = $meeting_end_time;
			$meeting->modified = $modified;
			$meeting->created = $created;
			$meeting->all_day_event_flag = $all_day_event_flag;
			*/

			$meeting->convertPropertiesToData();
			$data = $meeting->getData();

		// Indent is one tab out to facilitate diff & merge
		if ($createFromHidden) {
			$meeting_id = (int) $get->meeting_id;
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
					$errorMessage = 'Meeting already exists. Try another time or location.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				} else {
					//$meeting->setData($data);

					$existingData = $meeting->getData();

					// Retrieve all of the $_GET inputs automatically for the Meeting record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/
					$meeting->setData($httpGetInputData);
					$meeting->convertDataToProperties();
					$meeting->meeting_sequence_number = $nextMeetingSequenceNumberByMeetingTypeId;
					$meeting->project_id = $project_id;
					$meeting->convertPropertiesToData();

					$newData = $meeting->getData();
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
						$errorNumber = 1;
						$errorMessage = 'Error updating: Meeting<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
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

			if (isset($meeting_id) && !empty($meeting_id)) {
				$meeting->meeting_id = $meeting_id;
				$meeting->setId($meeting_id);

				if (isset($csvMeetingAttendees) && !empty($csvMeetingAttendees)) {
					$arrMeeetingAttendees = explode(',', $csvMeetingAttendees);
					foreach ($arrMeeetingAttendees as $contact_id) {
						$contact_id = (int) $contact_id;
						$meeetingAttendee = New MeetingAttendee($database);
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
			// $meeting->save();

			$meeting->convertDataToProperties();
			$primaryKeyAsString = $meeting->getPrimaryKeyAsString();

			// Save "next" meeting
			if ($get->next_meeting_location_id || $get->next_meeting_start_date || $get->next_meeting_start_time) {
				$nextMeeting = Meeting::instantiateOrm($database, 'Meeting', $httpGetInputData, null, null, 'next_');
				/* @var $nextMeeting Meeting */
				$nextMeeting->previous_meeting_id = $meeting->meeting_id;
				$nextMeeting->project_id = $meeting->project_id;
				$nextMeeting->meeting_type_id = $meeting->meeting_type_id;
				$nextMeeting->meeting_chair_contact_id = $meeting->meeting_chair_contact_id;
				$nextMeeting->modified_by_contact_id = $meeting->modified_by_contact_id;
				// Set to null and keep hidden until the "new meeting is created" and then update with current values at that time
				//$nextMeeting->meeting_sequence_number = $meeting->meeting_sequence_number + 1;
				$nextMeeting->meeting_sequence_number = '';
				$nextMeeting->convertPropertiesToData();
				$nextMeeting['created'] = null;
				$nextMeeting->save();
			}

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				$loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
				$loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
				$meeting_type_id = $meeting->meeting_type_id;
				$arrMeetingsByProjectIdAndMeetingTypeId = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id, $loadMeetingsByProjectIdAndMeetingTypeIdOptions);
				$htmlSelectOptions = '<option value="">Please Select A Meeting</option>';
				foreach ($arrMeetingsByProjectIdAndMeetingTypeId as $temp_meeting_id => $tempMeeting) {
					$meeting_sequence_number = $tempMeeting->meeting_sequence_number;
					if ($temp_meeting_id == $meeting_id) {
						$htmlSelectOptions .= '<option value="'.$temp_meeting_id.'" selected>Meeting '.$meeting_sequence_number.'</option>';
					} else {
						$htmlSelectOptions .= '<option value="'.$temp_meeting_id.'">Meeting '.$meeting_sequence_number.'</option>';
					}
				}

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Meeting.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Meeting';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meeting) && $meeting instanceof Meeting) {
				$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
			}
		}

		// @todo add interface name here as conditionaly include...
		$arrCustomizedJsonOutput = array();
		if (isset($htmlSelectOptions) && !empty($htmlSelectOptions)) {
			$arrCustomizedJsonOutput['htmlSelectOptions'] = $htmlSelectOptions;
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadMeeting':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meetings_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Meeting.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meetings';
			}

			// Primary key attibutes
			//$meeting_id = (int) $get->uniqueId;
			// Debug
			//$meeting_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type_id = (int) $get->meeting_type_id;
			$meeting_sequence_number = (string) $get->meeting_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Meeting';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meeting) && $meeting instanceof Meeting) {
				$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
			}
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'loadAllMeetingRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meetings_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Meeting.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meetings';
			}

			// Primary key attibutes
			//$meeting_id = (int) $get->uniqueId;
			// Debug
			//$meeting_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type_id = (int) $get->meeting_type_id;
			$meeting_sequence_number = (string) $get->meeting_sequence_number;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|meetings|Meeting|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Meeting';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$containerElementId|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$htmlContent";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateMeeting':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;
		$newValueHtml = '';

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Meeting';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meetings_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Meeting - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meetings';
			}

			// Primary key attibutes
			//$meeting_id = (int) $get->uniqueId;
			// Debug
			//$meeting_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type_id = (int) $get->meeting_type_id;
			$meeting_sequence_number = (string) $get->meeting_sequence_number;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'meeting_id' => 'meeting id',
				'previous_meeting_id' => 'previous meeting id',
				'project_id' => 'project id',
				'meeting_type_id' => 'meeting type id',
				'meeting_location_id' => 'meeting location id',
				'meeting_chair_contact_id' => 'meeting chair contact id',
				'modified_by_contact_id' => 'modified by contact id',
				'meeting_sequence_number' => 'meeting sequence number',
				'meeting_start_date' => 'meeting start date',
				'meeting_start_time' => 'meeting start time',
				'meeting_end_date' => 'meeting end date',
				'meeting_end_time' => 'meeting end time',
				'modified' => 'modified',
				'created' => 'created',
				'all_day_event_flag' => 'all day event flag',
			);

			if (isset($arrAllowableAttributes[$attributeName])) {
				// Allow formatted attribute name to be passed in
				if (!isset($formattedAttributeName) || empty($formattedAttributeName)) {
					$formattedAttributeName = $arrAllowableAttributes[$attributeName];
					$arrTmp = explode(' ', $formattedAttributeName);
					$arrFormattedAttributeName = array_map('ucfirst', $arrTmp);
					$formattedAttributeName = join(' ', $arrFormattedAttributeName);
				}
			} else {
				$errorMessage = 'Invalid attribute.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			if ($attributeSubgroupName == 'meetings') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$meeting_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$meeting = Meeting::findById($database, $meeting_id);
				/* @var $meeting Meeting */

				if ($meeting) {
					// Check if the value actually changed
					$existingValue = $meeting->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'project_id' => 1,
						'meeting_type_id' => 1,
						'meeting_sequence_number' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $meeting->$attributeName;
						$meeting->$attributeName = $newValue;
						$possibleDuplicateMeeting = Meeting::findByProjectIdAndMeetingTypeIdAndMeetingSequenceNumber($database, $meeting->project_id, $meeting->meeting_type_id, $meeting->meeting_sequence_number);
						if ($possibleDuplicateMeeting) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Meeting $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$meeting->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$meeting->setData($data);
						// $meeting_id = $meeting->save();
						$meeting->save();
						$meeting->convertDataToProperties();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);

						switch ($attributeName) {
							case 'meeting_start_date':
							case 'meeting_end_date':
							case 'next_meeting_start_date':
							case 'next_meeting_end_date':
								if ($newValue) {
									$newValueHtml = date('M d, Y', strtotime($newValue));
								}
								break;
							case 'meeting_start_time':
							case 'meeting_end_time':
							case 'next_meeting_start_time':
							case 'next_meeting_end_time':
								if ($newValue) {
									$newValueHtml = date('g:ia', strtotime($newValue));
								}
								break;
							case 'meeting_location_id':
							case 'next_meeting_location_id':
								$meeting_location_id = $meeting->$attributeName;
								$meetingLocation = MeetingLocation::findById($database, $meeting_location_id);
								$meeting_location = $meetingLocation->meeting_location;
								$newValueHtml = $meeting_location;
								break;
							default:
								$newValueHtml = $newValue;
								break;
						}

					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
			}

			$htmlContent = $newValueHtml;
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Meeting';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meeting) && $meeting instanceof Meeting) {
				$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
			}
		}

		// Dummy placeholder for now
		$previousId = '';

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$attributeName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$formattedAttributeName|$resetToPreviousValue|$performRefreshOperation|$previousId|$newValueHtml";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateAllMeetingAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Meeting';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meetings_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Meeting.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meetings';
			}

			// Primary key attibutes
			//$meeting_id = (int) $get->uniqueId;
			// Debug
			//$meeting_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type_id = (int) $get->meeting_type_id;
			$meeting_sequence_number = (string) $get->meeting_sequence_number;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_id = (int) $get->meeting_id;
			$previous_meeting_id = (int) $get->previous_meeting_id;
			$project_id = (int) $get->project_id;
			$meeting_type_id = (int) $get->meeting_type_id;
			$meeting_location_id = (int) $get->meeting_location_id;
			$meeting_chair_contact_id = (int) $get->meeting_chair_contact_id;
			$modified_by_contact_id = (int) $get->modified_by_contact_id;
			$meeting_sequence_number = (string) $get->meeting_sequence_number;
			$meeting_start_date = (string) $get->meeting_start_date;
			$meeting_start_time = (string) $get->meeting_start_time;
			$meeting_end_date = (string) $get->meeting_end_date;
			$meeting_end_time = (string) $get->meeting_end_time;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			$all_day_event_flag = (string) $get->all_day_event_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'meetings') {
				$meeting_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$meeting = Meeting::findById($database, $meeting_id);
				/* @var $meeting Meeting */

				if ($meeting) {
					$existingData = $meeting->getData();

					// Retrieve all of the $_GET inputs automatically for the Meeting record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$meeting->setData($httpGetInputData);
					$meeting->convertDataToProperties();
					$meeting->convertPropertiesToData();

					$newData = $meeting->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$meeting->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Meeting<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$meeting->meeting_id = $meeting_id;
			$meeting->previous_meeting_id = $previous_meeting_id;
			$meeting->project_id = $project_id;
			$meeting->meeting_type_id = $meeting_type_id;
			$meeting->meeting_location_id = $meeting_location_id;
			$meeting->meeting_chair_contact_id = $meeting_chair_contact_id;
			$meeting->modified_by_contact_id = $modified_by_contact_id;
			$meeting->meeting_sequence_number = $meeting_sequence_number;
			$meeting->meeting_start_date = $meeting_start_date;
			$meeting->meeting_start_time = $meeting_start_time;
			$meeting->meeting_end_date = $meeting_end_date;
			$meeting->meeting_end_time = $meeting_end_time;
			$meeting->modified = $modified;
			$meeting->created = $created;
			$meeting->all_day_event_flag = $all_day_event_flag;
					*/

					// $meeting_id = $meeting->save();
					$meeting->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Meeting';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meeting) && $meeting instanceof Meeting) {
				$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$resetToPreviousValue";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'deleteMeeting':

		$crudOperation = 'delete';
		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meetings_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Meeting.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meetings';
			}

			// Primary key attibutes
			//$meeting_id = (int) $get->uniqueId;
			// Debug
			//$meeting_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$meeting_type_id = (int) $get->meeting_type_id;
			$meeting_sequence_number = (string) $get->meeting_sequence_number;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'meetings') {
				$meeting_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				//$meeting = Meeting::findById($database, $meeting_id);
				$meeting = Meeting::loadMeetingPlusNextMeetingById($database, $meeting_id);
				/* @var $meeting Meeting */

				if ($meeting) {
					$nextMeeting = $meeting->getNextMeeting();
					/* @var $nextMeeting Meeting */
					if ($nextMeeting) {
						// Check if next meeting is just a "Next meeting placeholder" with no meeting_sequence_number set.
						$next_meeting_sequence_number = $nextMeeting->meeting_sequence_number;
						if (empty($next_meeting_sequence_number)) {
							$nextMeeting->delete();
						} else {
							$data = array('previous_meeting_id' => null);
							$nextMeeting->setData($data);
							$nextMeeting->save();
						}
					}
					$meeting->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error deleting: Meeting';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);
			$resetToPreviousValue = 'Y';

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meeting) && $meeting instanceof Meeting) {
				$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$recordContainerElementId|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$performDomDeleteOperation";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'saveMeeting':

		$crudOperation = 'save';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meetings_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Meeting data values.';
				$arrErrorMessages = array(
					'Error saving Meeting.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meetings';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-meeting-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_id = (int) $get->meeting_id;
			$previous_meeting_id = (int) $get->previous_meeting_id;
			$project_id = (int) $get->project_id;
			$meeting_type_id = (int) $get->meeting_type_id;
			$meeting_location_id = (int) $get->meeting_location_id;
			$meeting_chair_contact_id = (int) $get->meeting_chair_contact_id;
			$modified_by_contact_id = (int) $get->modified_by_contact_id;
			$meeting_sequence_number = (string) $get->meeting_sequence_number;
			$meeting_start_date = (string) $get->meeting_start_date;
			$meeting_start_time = (string) $get->meeting_start_time;
			$meeting_end_date = (string) $get->meeting_end_date;
			$meeting_end_time = (string) $get->meeting_end_time;
			$modified = (string) $get->modified;
			$created = (string) $get->created;
			$all_day_event_flag = (string) $get->all_day_event_flag;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$meeting = new Meeting($database);

			// Retrieve all of the $_GET inputs automatically for the Meeting record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$meeting->setData($httpGetInputData);
			$meeting->convertDataToProperties();

			/*
			$meeting->meeting_id = $meeting_id;
			$meeting->previous_meeting_id = $previous_meeting_id;
			$meeting->project_id = $project_id;
			$meeting->meeting_type_id = $meeting_type_id;
			$meeting->meeting_location_id = $meeting_location_id;
			$meeting->meeting_chair_contact_id = $meeting_chair_contact_id;
			$meeting->modified_by_contact_id = $modified_by_contact_id;
			$meeting->meeting_sequence_number = $meeting_sequence_number;
			$meeting->meeting_start_date = $meeting_start_date;
			$meeting->meeting_start_time = $meeting_start_time;
			$meeting->meeting_end_date = $meeting_end_date;
			$meeting->meeting_end_time = $meeting_end_time;
			$meeting->modified = $modified;
			$meeting->created = $created;
			$meeting->all_day_event_flag = $all_day_event_flag;
			*/

			$meeting->convertPropertiesToData();
			$data = $meeting->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$meeting_id = $meeting->insertOnDuplicateKeyUpdate();
			if (isset($meeting_id) && !empty($meeting_id)) {
				$meeting->meeting_id = $meeting_id;
				$meeting->setId($meeting_id);
			}
			// $meeting->insertOnDuplicateKeyUpdate();
			// $meeting->insertIgnore();

			$meeting->convertDataToProperties();
			$primaryKeyAsString = $meeting->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Meeting.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Meeting';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($meeting) && $meeting instanceof Meeting) {
				$primaryKeyAsString = $meeting->getPrimaryKeyAsString();
			}
		}

		if (($errorNumber == 0) && $includeHtmlContentInJsonResponse) {
			require('code-generator/ajax-html-content-generator.php');
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}

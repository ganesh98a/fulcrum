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

require_once('lib/common/MeetingLocation.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('meeting_locations-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewMeetingLocations = $permissions->determineAccessToSoftwareModuleFunction('meeting_locations_view');
$userCanManageMeetingLocations = $permissions->determineAccessToSoftwareModuleFunction('meeting_locations_manage');
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
	case 'createMeetingLocation':

		$crudOperation = 'create';
		$errorNumber = 0;
		$errorMessage = '';
		$save = true;
		$primaryKeyAsString = '';
		$htmlRecord = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_locations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Meeting Location data values.';
				$arrErrorMessages = array(
					'Error creating: Meeting Location.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Location';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Locations';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-meeting_location-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_location_id = (int) $get->meeting_location_id;
			$user_company_id = (int) $get->user_company_id;
			$meeting_location = (string) $get->meeting_location;
			$meeting_location_abbreviation = (string) $get->meeting_location_abbreviation;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the MeetingLocation record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$meetingLocation = new MeetingLocation($database);

			$meetingLocation->setData($httpGetInputData);
			$meetingLocation->convertDataToProperties();

			/*
			$meetingLocation->meeting_location_id = $meeting_location_id;
			$meetingLocation->user_company_id = $user_company_id;
			$meetingLocation->meeting_location = $meeting_location;
			$meetingLocation->meeting_location_abbreviation = $meeting_location_abbreviation;
			$meetingLocation->sort_order = $sort_order;
			*/

			$meetingLocation->user_company_id = $user_company_id;

			$meetingLocation->convertPropertiesToData();
			$data = $meetingLocation->getData();

			// Test for existence via standard findByUniqueIndex method
			$meetingLocation->findByUniqueIndex();
			if ($meetingLocation->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Meeting Location already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$meetingLocation->setKey(null);
				$meetingLocation->setData($data);
			}

			$meeting_location_id = $meetingLocation->save();
			if (isset($meeting_location_id) && !empty($meeting_location_id)) {
				$meetingLocation->meeting_location_id = $meeting_location_id;
				$meetingLocation->setId($meeting_location_id);
			}
			// $meetingLocation->save();

			$meetingLocation->convertDataToProperties();
			$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				$attributeGroupName = 'manage-meeting_location-record';
				$elementId = $attributeGroupName.'--meeting_locations--sort_order--'.$meeting_location_id;
				$htmlRecord = '
				<tr id="'.$elementId.'">
					<td class="textAlignLeft">'.$meetingLocation->meeting_location.'</td>
					<td class="textAlignCenter"><a href="javascript:Collaboration_Manager__Meetings__deleteMeetingLocation(\''.$elementId.'\', \''.$attributeGroupName.'\', \''.$meeting_location_id.'\');">X</a></td>
				</tr>
				';
				$htmlSelectOption = '<option value="'.$meeting_location_id.'">'.$meetingLocation->meeting_location.'</option>';

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Meeting Location.';
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
			//$errorMessage = 'Error creating: Meeting Location';
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
			if (isset($meetingLocation) && $meetingLocation instanceof MeetingLocation) {
				$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
			}
		}

		// @todo add interface name here as conditionaly include...
		$arrCustomizedJsonOutput = array();
		if (isset($htmlSelectOption) && !empty($htmlSelectOption)) {
			$arrCustomizedJsonOutput['htmlSelectOption'] = $htmlSelectOption;
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

	case 'loadMeetingLocation':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_locations_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Meeting Location.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Location';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Locations';
			}

			// Primary key attibutes
			//$meeting_location_id = (int) $get->uniqueId;
			// Debug
			//$meeting_location_id = (int) 1;

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$meeting_location = (string) $get->meeting_location;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Meeting Location';
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
			if (isset($meetingLocation) && $meetingLocation instanceof MeetingLocation) {
				$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
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

	case 'loadAllMeetingLocationRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_locations_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Meeting Location.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Location';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Locations';
			}

			// Primary key attibutes
			//$meeting_location_id = (int) $get->uniqueId;
			// Debug
			//$meeting_location_id = (int) 1;

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$meeting_location = (string) $get->meeting_location;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|meeting_locations|Meeting Location|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Meeting Location';
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

	case 'updateMeetingLocation':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Meeting Location';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_locations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Meeting Location - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Location';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Locations';
			}

			// Primary key attibutes
			//$meeting_location_id = (int) $get->uniqueId;
			// Debug
			//$meeting_location_id = (int) 1;

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$meeting_location = (string) $get->meeting_location;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'meeting_location_id' => 'meeting location id',
				'user_company_id' => 'user company id',
				'meeting_location' => 'meeting location',
				'meeting_location_abbreviation' => 'meeting location abbreviation',
				'sort_order' => 'sort order',
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

			if ($attributeSubgroupName == 'meeting_locations') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$meeting_location_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$meetingLocation = MeetingLocation::findById($database, $meeting_location_id);
				/* @var $meetingLocation MeetingLocation */

				if ($meetingLocation) {
					// Check if the value actually changed
					$existingValue = $meetingLocation->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'user_company_id' => 1,
						'meeting_location' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $meetingLocation->$attributeName;
						$meetingLocation->$attributeName = $newValue;
						$possibleDuplicateMeetingLocation = MeetingLocation::findByUserCompanyIdAndMeetingLocation($database, $meetingLocation->user_company_id, $meetingLocation->meeting_location);
						if ($possibleDuplicateMeetingLocation) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Meeting Location $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$meetingLocation->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$meetingLocation->setData($data);
						// $meeting_location_id = $meetingLocation->save();
						$meetingLocation->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting Location record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Meeting Location';
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
			if (isset($meetingLocation) && $meetingLocation instanceof MeetingLocation) {
				$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
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
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$attributeName|$primaryKeyAsString|$formattedAttributeGroupName|$formattedAttributeSubgroupName|$formattedAttributeName|$resetToPreviousValue|$performRefreshOperation|$previousId";
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;

	case 'updateAllMeetingLocationAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Meeting Location';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'meeting_locations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Meeting Location.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Location';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Locations';
			}

			// Primary key attibutes
			//$meeting_location_id = (int) $get->uniqueId;
			// Debug
			//$meeting_location_id = (int) 1;

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$meeting_location = (string) $get->meeting_location;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_location_id = (int) $get->meeting_location_id;
			$user_company_id = (int) $get->user_company_id;
			$meeting_location = (string) $get->meeting_location;
			$meeting_location_abbreviation = (string) $get->meeting_location_abbreviation;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'meeting_locations') {
				$meeting_location_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$meetingLocation = MeetingLocation::findById($database, $meeting_location_id);
				/* @var $meetingLocation MeetingLocation */

				if ($meetingLocation) {
					$existingData = $meetingLocation->getData();

					// Retrieve all of the $_GET inputs automatically for the MeetingLocation record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$meetingLocation->setData($httpGetInputData);
					$meetingLocation->convertDataToProperties();
					$meetingLocation->convertPropertiesToData();

					$newData = $meetingLocation->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$meetingLocation->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Meeting Location<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$meetingLocation->meeting_location_id = $meeting_location_id;
			$meetingLocation->user_company_id = $user_company_id;
			$meetingLocation->meeting_location = $meeting_location;
			$meetingLocation->meeting_location_abbreviation = $meeting_location_abbreviation;
			$meetingLocation->sort_order = $sort_order;
					*/

					// $meeting_location_id = $meetingLocation->save();
					$meetingLocation->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting Location record does not exist.';
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
			//$errorMessage = 'Error updating: Meeting Location';
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
			if (isset($meetingLocation) && $meetingLocation instanceof MeetingLocation) {
				$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
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

	case 'deleteMeetingLocation':

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
					'meeting_locations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Meeting Location.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Location';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Locations';
			}

			// Primary key attibutes
			//$meeting_location_id = (int) $get->uniqueId;
			// Debug
			//$meeting_location_id = (int) 1;

			// Unique index attibutes
			$user_company_id = (int) $get->user_company_id;
			$meeting_location = (string) $get->meeting_location;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'meeting_locations') {
				$meeting_location_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$meetingLocation = MeetingLocation::findById($database, $meeting_location_id);
				/* @var $meetingLocation MeetingLocation */

				if ($meetingLocation) {
					$meetingLocation->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Meeting Location record does not exist.';
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
			//$errorMessage = 'Error deleting: Meeting Location';
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
			if (isset($meetingLocation) && $meetingLocation instanceof MeetingLocation) {
				$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
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

	case 'saveMeetingLocation':

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
					'meeting_locations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Meeting Location data values.';
				$arrErrorMessages = array(
					'Error saving Meeting Location.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'Y';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Meeting Location';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Meeting Locations';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-meeting_location-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$meeting_location_id = (int) $get->meeting_location_id;
			$user_company_id = (int) $get->user_company_id;
			$meeting_location = (string) $get->meeting_location;
			$meeting_location_abbreviation = (string) $get->meeting_location_abbreviation;
			$sort_order = (int) $get->sort_order;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$meetingLocation = new MeetingLocation($database);

			// Retrieve all of the $_GET inputs automatically for the MeetingLocation record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$meetingLocation->setData($httpGetInputData);
			$meetingLocation->convertDataToProperties();

			/*
			$meetingLocation->meeting_location_id = $meeting_location_id;
			$meetingLocation->user_company_id = $user_company_id;
			$meetingLocation->meeting_location = $meeting_location;
			$meetingLocation->meeting_location_abbreviation = $meeting_location_abbreviation;
			$meetingLocation->sort_order = $sort_order;
			*/

			$meetingLocation->convertPropertiesToData();
			$data = $meetingLocation->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$meeting_location_id = $meetingLocation->insertOnDuplicateKeyUpdate();
			if (isset($meeting_location_id) && !empty($meeting_location_id)) {
				$meetingLocation->meeting_location_id = $meeting_location_id;
				$meetingLocation->setId($meeting_location_id);
			}
			// $meetingLocation->insertOnDuplicateKeyUpdate();
			// $meetingLocation->insertIgnore();

			$meetingLocation->convertDataToProperties();
			$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Meeting Location.';
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
			//$errorMessage = 'Error creating: Meeting Location';
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
			if (isset($meetingLocation) && $meetingLocation instanceof MeetingLocation) {
				$primaryKeyAsString = $meetingLocation->getPrimaryKeyAsString();
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

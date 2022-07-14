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

require_once('lib/common/FileManagerFile.php');
require_once('lib/common/ProjectBidInvitation.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
//if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
//	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('project_bid_invitations-functions.php');
//	}
//}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewProjectBidInvitations = $permissions->determineAccessToSoftwareModuleFunction('project_bid_invitations_view');
$userCanManageProjectBidInvitations = $permissions->determineAccessToSoftwareModuleFunction('project_bid_invitations_manage');
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
	case 'createProjectBidInvitation':

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
					'project_bid_invitations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Project Bid Invitation data values.';
				$arrErrorMessages = array(
					'Error creating: Project Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Project Bid Invitations';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-project_bid_invitation-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$project_bid_invitation_id = (int) $get->project_bid_invitation_id;
			$project_id = (int) $get->project_id;
			$project_bid_invitation_sequence_number = (int) $get->project_bid_invitation_sequence_number;
			$project_bid_invitation_file_manager_file_id = (int) $get->project_bid_invitation_file_manager_file_id;
			$created = (string) $get->created;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the ProjectBidInvitation record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$projectBidInvitation = new ProjectBidInvitation($database);

			$projectBidInvitation->setData($httpGetInputData);
			$projectBidInvitation->convertDataToProperties();

			/*
			$projectBidInvitation->project_bid_invitation_id = $project_bid_invitation_id;
			$projectBidInvitation->project_id = $project_id;
			$projectBidInvitation->project_bid_invitation_sequence_number = $project_bid_invitation_sequence_number;
			$projectBidInvitation->project_bid_invitation_file_manager_file_id = $project_bid_invitation_file_manager_file_id;
			$projectBidInvitation->created = $created;
			*/

			$project_bid_invitation_sequence_number = ProjectBidInvitation::findNextProjectBidInvitationSequenceNumber($database, $project_id);
			$projectBidInvitation->project_bid_invitation_sequence_number = $project_bid_invitation_sequence_number;
			$projectBidInvitation->project_id = $project_id;

			$projectBidInvitation->convertPropertiesToData();
			$data = $projectBidInvitation->getData();

			// Test for existence via standard findByUniqueIndex method
			$projectBidInvitation->findByUniqueIndex();
			if ($projectBidInvitation->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Project Bid Invitation already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$projectBidInvitation->setKey(null);
				$data['created'] = null;
				$projectBidInvitation->setData($data);
			}

			$project_bid_invitation_id = $projectBidInvitation->save();
			if (isset($project_bid_invitation_id) && !empty($project_bid_invitation_id)) {
				$projectBidInvitation->project_bid_invitation_id = $project_bid_invitation_id;
				$projectBidInvitation->setId($project_bid_invitation_id);
			}
			// $projectBidInvitation->save();

			$projectBidInvitation->convertDataToProperties();
			$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

				if ($includeHtmlRecord) {
					// Insert custom HTML Record code here...
					// "tr" or "li"
					switch ($htmlRecordType) {
						case 'tr':
							// @todo Add companion renderOrmAsLiElement(...) function to php include
							$htmlRecord = renderProjectBidInvitationAsTrElement($database, $projectBidInvitation);
							break;
						default:
						case 'li':
							// @todo Add companion renderOrmAsLiElement(...) function to php include
							$htmlRecord = renderProjectBidInvitationAsLiElement($database, $projectBidInvitation);
							break;
						case 'dropdown':
							$loadProjectBidInvitationsByProjectIdOptions = new Input();
							$loadProjectBidInvitationsByProjectIdOptions->forceLoadFlag = true;
							$loadProjectBidInvitationsByProjectIdOptions->arrOrderByAttributes = array(
								'project_bid_invitation_sequence_number' => 'DESC'
							);
							$arrProjectBidInvitations = ProjectBidInvitation::loadProjectBidInvitationsByProjectId($database, $project_id, $loadProjectBidInvitationsByProjectIdOptions);
							$htmlRecord = renderProjectBidInvitationsAsBootstrapDropdown($database, $arrProjectBidInvitations, $debugMode);
							break;
					}
				}

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Project Bid Invitation.';
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
			//$errorMessage = 'Error creating: Project Bid Invitation';
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
			if (isset($projectBidInvitation) && $projectBidInvitation instanceof ProjectBidInvitation) {
				$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
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

	case 'loadProjectBidInvitation':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'project_bid_invitations_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Project Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Project Bid Invitations';
			}

			// Primary key attibutes
			//$project_bid_invitation_id = (int) $get->uniqueId;
			// Debug
			//$project_bid_invitation_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$project_bid_invitation_file_manager_file_id = (int) $get->project_bid_invitation_file_manager_file_id;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Project Bid Invitation';
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
			if (isset($projectBidInvitation) && $projectBidInvitation instanceof ProjectBidInvitation) {
				$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
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

	case 'loadAllProjectBidInvitationRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'project_bid_invitations_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Project Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Project Bid Invitations';
			}

			// Primary key attibutes
			//$project_bid_invitation_id = (int) $get->uniqueId;
			// Debug
			//$project_bid_invitation_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$project_bid_invitation_file_manager_file_id = (int) $get->project_bid_invitation_file_manager_file_id;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|project_bid_invitations|Project Bid Invitation|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Project Bid Invitation';
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

	case 'updateProjectBidInvitation':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Project Bid Invitation';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'project_bid_invitations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Project Bid Invitation - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Project Bid Invitations';
			}

			// Primary key attibutes
			//$project_bid_invitation_id = (int) $get->uniqueId;
			// Debug
			//$project_bid_invitation_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$project_bid_invitation_file_manager_file_id = (int) $get->project_bid_invitation_file_manager_file_id;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'project_bid_invitation_id' => 'project bid invitation id',
				'project_id' => 'project id',
				'project_bid_invitation_sequence_number' => 'project bid invitation sequence number',
				'project_bid_invitation_file_manager_file_id' => 'project bid invitation file manager file id',
				'created' => 'created',
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

			if ($attributeSubgroupName == 'project_bid_invitations') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$project_bid_invitation_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$projectBidInvitation = ProjectBidInvitation::findById($database, $project_bid_invitation_id);
				/* @var $projectBidInvitation ProjectBidInvitation */

				if ($projectBidInvitation) {
					// Check if the value actually changed
					$existingValue = $projectBidInvitation->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					// Confirm uniqueness of the attribute being updated if it is in the list of "first unique index attributes".
					// Hence, the attribute affects the uniqueness of the data and may collide with other datums.
					$arrAjaxUniqueIndexAttributes = array(
						'project_id' => 1,
						'project_bid_invitation_file_manager_file_id' => 1,
					);
					if (isset($arrAjaxUniqueIndexAttributes[$attributeName])) {
						$existingValue = $projectBidInvitation->$attributeName;
						$projectBidInvitation->$attributeName = $newValue;
						$possibleDuplicateProjectBidInvitation = ProjectBidInvitation::findByProjectIdAndProjectBidInvitationFileManagerFileId($database, $projectBidInvitation->project_id, $projectBidInvitation->project_bid_invitation_file_manager_file_id);
						if ($possibleDuplicateProjectBidInvitation) {
							$save = false;
							$resetToPreviousValue = 'Y';
							$errorMessage = "Project Bid Invitation $newValue already exists.";

							//$message->enqueueError($errorMessage, $currentPhpScript);
							//$error->outputErrorMessages();
							//exit;
						} else {
							$projectBidInvitation->$attributeName = $existingValue;
						}
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$projectBidInvitation->setData($data);
						// $project_bid_invitation_id = $projectBidInvitation->save();
						$projectBidInvitation->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project Bid Invitation record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Project Bid Invitation';
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
			if (isset($projectBidInvitation) && $projectBidInvitation instanceof ProjectBidInvitation) {
				$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
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

	case 'updateAllProjectBidInvitationAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Project Bid Invitation';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'project_bid_invitations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Project Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Project Bid Invitations';
			}

			// Primary key attibutes
			//$project_bid_invitation_id = (int) $get->uniqueId;
			// Debug
			//$project_bid_invitation_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$project_bid_invitation_file_manager_file_id = (int) $get->project_bid_invitation_file_manager_file_id;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$project_bid_invitation_id = (int) $get->project_bid_invitation_id;
			$project_id = (int) $get->project_id;
			$project_bid_invitation_sequence_number = (int) $get->project_bid_invitation_sequence_number;
			$project_bid_invitation_file_manager_file_id = (int) $get->project_bid_invitation_file_manager_file_id;
			$created = (string) $get->created;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'project_bid_invitations') {
				$project_bid_invitation_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$projectBidInvitation = ProjectBidInvitation::findById($database, $project_bid_invitation_id);
				/* @var $projectBidInvitation ProjectBidInvitation */

				if ($projectBidInvitation) {
					$existingData = $projectBidInvitation->getData();

					// Retrieve all of the $_GET inputs automatically for the ProjectBidInvitation record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$projectBidInvitation->setData($httpGetInputData);
					$projectBidInvitation->convertDataToProperties();
					$projectBidInvitation->convertPropertiesToData();

					$newData = $projectBidInvitation->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$projectBidInvitation->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Project Bid Invitation<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$projectBidInvitation->project_bid_invitation_id = $project_bid_invitation_id;
			$projectBidInvitation->project_id = $project_id;
			$projectBidInvitation->project_bid_invitation_sequence_number = $project_bid_invitation_sequence_number;
			$projectBidInvitation->project_bid_invitation_file_manager_file_id = $project_bid_invitation_file_manager_file_id;
			$projectBidInvitation->created = $created;
					*/

					// $project_bid_invitation_id = $projectBidInvitation->save();
					$projectBidInvitation->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project Bid Invitation record does not exist.';
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
			//$errorMessage = 'Error updating: Project Bid Invitation';
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
			if (isset($projectBidInvitation) && $projectBidInvitation instanceof ProjectBidInvitation) {
				$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
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

	case 'deleteProjectBidInvitation':

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
					'project_bid_invitations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Project Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Project Bid Invitations';
			}

			// Primary key attibutes
			//$project_bid_invitation_id = (int) $get->uniqueId;
			// Debug
			//$project_bid_invitation_id = (int) 1;

			// Unique index attibutes
			$project_id = (int) $get->project_id;
			$project_bid_invitation_file_manager_file_id = (int) $get->project_bid_invitation_file_manager_file_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'project_bid_invitations') {
				$project_bid_invitation_id = (int) $uniqueId;

				// Put in findById() or findByUniqueKey() as appropriate
				$projectBidInvitation = ProjectBidInvitation::findById($database, $project_bid_invitation_id);
				/* @var $projectBidInvitation ProjectBidInvitation */

				if ($projectBidInvitation) {
					$projectBidInvitation->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project Bid Invitation record does not exist.';
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
			//$errorMessage = 'Error deleting: Project Bid Invitation';
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
			if (isset($projectBidInvitation) && $projectBidInvitation instanceof ProjectBidInvitation) {
				$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
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

	case 'saveProjectBidInvitation':

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
					'project_bid_invitations_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Project Bid Invitation data values.';
				$arrErrorMessages = array(
					'Error saving Project Bid Invitation.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project Bid Invitation';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Project Bid Invitations';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-project_bid_invitation-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$project_bid_invitation_id = (int) $get->project_bid_invitation_id;
			$project_id = (int) $get->project_id;
			$project_bid_invitation_sequence_number = (int) $get->project_bid_invitation_sequence_number;
			$project_bid_invitation_file_manager_file_id = (int) $get->project_bid_invitation_file_manager_file_id;
			$created = (string) $get->created;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$projectBidInvitation = new ProjectBidInvitation($database);

			// Retrieve all of the $_GET inputs automatically for the ProjectBidInvitation record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$projectBidInvitation->setData($httpGetInputData);
			$projectBidInvitation->convertDataToProperties();

			/*
			$projectBidInvitation->project_bid_invitation_id = $project_bid_invitation_id;
			$projectBidInvitation->project_id = $project_id;
			$projectBidInvitation->project_bid_invitation_sequence_number = $project_bid_invitation_sequence_number;
			$projectBidInvitation->project_bid_invitation_file_manager_file_id = $project_bid_invitation_file_manager_file_id;
			$projectBidInvitation->created = $created;
			*/

			$projectBidInvitation->convertPropertiesToData();
			$data = $projectBidInvitation->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			$project_bid_invitation_id = $projectBidInvitation->insertOnDuplicateKeyUpdate();
			if (isset($project_bid_invitation_id) && !empty($project_bid_invitation_id)) {
				$projectBidInvitation->project_bid_invitation_id = $project_bid_invitation_id;
				$projectBidInvitation->setId($project_bid_invitation_id);
			}
			// $projectBidInvitation->insertOnDuplicateKeyUpdate();
			// $projectBidInvitation->insertIgnore();

			$projectBidInvitation->convertDataToProperties();
			$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Project Bid Invitation.';
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
			//$errorMessage = 'Error creating: Project Bid Invitation';
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
			if (isset($projectBidInvitation) && $projectBidInvitation instanceof ProjectBidInvitation) {
				$primaryKeyAsString = $projectBidInvitation->getPrimaryKeyAsString();
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

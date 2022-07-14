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

require_once('lib/common/ProjectToContactToRole.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// Make code gen files match in diff when deployed
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
	if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
		require_once('projects_to_contacts_to_roles-functions.php');
	}
}

/*
// Set permission variables
$permissions = Zend_Registry::get('permissions');
$userCanViewProjectsToContactsToRoles = $permissions->determineAccessToSoftwareModuleFunction('projects_to_contacts_to_roles_view');
$userCanManageProjectsToContactsToRoles = $permissions->determineAccessToSoftwareModuleFunction('projects_to_contacts_to_roles_manage');
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
	case 'createProjectToContactToRole':

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
					'projects_to_contacts_to_roles_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Project To Contact To Role data values.';
				$arrErrorMessages = array(
					'Error creating: Project To Contact To Role.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project To Contact To Role';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects To Contacts To Roles';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-project_to_contact_to_role-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$project_id = (int) $get->project_id;
			$contact_id = (int) $get->contact_id;
			$role_id = (int) $get->role_id;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			// Retrieve all of the $_GET inputs automatically for the ProjectToContactToRole record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$projectToContactToRole = new ProjectToContactToRole($database);

			$projectToContactToRole->setData($httpGetInputData);
			$projectToContactToRole->convertDataToProperties();

			/*
			$projectToContactToRole->project_id = $project_id;
			$projectToContactToRole->contact_id = $contact_id;
			$projectToContactToRole->role_id = $role_id;
			*/

			$projectToContactToRole->convertPropertiesToData();
			$data = $projectToContactToRole->getData();

			// Test for existence via standard findByUniqueIndex method
			$projectToContactToRole->findByUniqueIndex();
			if ($projectToContactToRole->isDataLoaded()) {
				// Error code here
				$errorMessage = 'Project To Contact To Role already exists.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			} else {
				$projectToContactToRole->setKey(null);
				$projectToContactToRole->setData($data);
			}

			// $project_to_contact_to_role_id = $projectToContactToRole->save();
			$projectToContactToRole->save();

			$projectToContactToRole->convertDataToProperties();
			$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);

			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Project To Contact To Role.';
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
			//$errorMessage = 'Error creating: Project To Contact To Role';
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
			if (isset($projectToContactToRole) && $projectToContactToRole instanceof ProjectToContactToRole) {
				$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
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

	case 'loadProjectToContactToRole':

		$crudOperation = 'load';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_to_contacts_to_roles_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Project To Contact To Role.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project To Contact To Role';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects To Contacts To Roles';
			}

			// Primary key attibutes
			//$project_id = (int) $get->uniqueId;
			// Debug
			//$project_id = (int) 1;
			//$contact_id = (int) $get->uniqueId;
			// Debug
			//$contact_id = (int) 1;
			//$role_id = (int) $get->uniqueId;
			// Debug
			//$role_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Project To Contact To Role';
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
			if (isset($projectToContactToRole) && $projectToContactToRole instanceof ProjectToContactToRole) {
				$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
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

	case 'loadAllProjectToContactToRoleRecords':

		$crudOperation = 'loadAll';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - read
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_to_contacts_to_roles_view' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error loading: Project To Contact To Role.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project To Contact To Role';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects To Contacts To Roles';
			}

			// Primary key attibutes
			//$project_id = (int) $get->uniqueId;
			// Debug
			//$project_id = (int) 1;
			//$contact_id = (int) $get->uniqueId;
			// Debug
			//$contact_id = (int) 1;
			//$role_id = (int) $get->uniqueId;
			// Debug
			//$role_id = (int) 1;

			if ($includeHtmlContentInJsonResponse) {
				require('code-generator/ajax-html-content-generator.php');
			}

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|projects_to_contacts_to_roles|Project To Contact To Role|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Project To Contact To Role';
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

	case 'updateProjectToContactToRole':

		$crudOperation = 'update';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Project To Contact To Role';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_to_contacts_to_roles_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					"Error updating Project To Contact To Role - {$attributeName}.<br>Permission Denied." => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project To Contact To Role';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects To Contacts To Roles';
			}

			// Primary key attibutes
			//$project_id = (int) $get->uniqueId;
			// Debug
			//$project_id = (int) 1;
			//$contact_id = (int) $get->uniqueId;
			// Debug
			//$contact_id = (int) 1;
			//$role_id = (int) $get->uniqueId;
			// Debug
			//$role_id = (int) 1;

			if ($newValue == '') {
				$newValue = null;
			}

			$arrAllowableAttributes = array(
				'project_id' => 'project id',
				'contact_id' => 'contact id',
				'role_id' => 'role id',
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

			if ($attributeSubgroupName == 'projects_to_contacts_to_roles') {
				// @todo Add in $previousId logic to check if a candidate key attribute value changed
				$arrTmp = explode('-', $uniqueId);
				$project_id = (int) array_shift($arrTmp);
				$contact_id = (int) array_shift($arrTmp);
				$role_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$projectToContactToRole = ProjectToContactToRole::findByProjectIdAndContactIdAndRoleId($database, $project_id, $contact_id, $role_id);
				/* @var $projectToContactToRole ProjectToContactToRole */

				if ($projectToContactToRole) {
					// Check if the value actually changed
					$existingValue = $projectToContactToRole->$attributeName;
					if ($existingValue === $newValue) {
						$errorNumber = 1;
						$errorMessage = "$formattedAttributeName did not change in value.";
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
						//$error->outputErrorMessages();
						//exit;
					}

					if ($save) {
						$data = array($attributeName => $newValue);
						$projectToContactToRole->setData($data);
						// $project_to_contact_to_role_id = $projectToContactToRole->save();
						$projectToContactToRole->save();
						$errorNumber = 0;
						$errorMessage = '';
						$resetToPreviousValue = 'N';
						$message->reset($currentPhpScript);
					}
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project To Contact To Role record does not exist.';
					$message->enqueueError($errorMessage, $currentPhpScript);
					throw new Exception($errorMessage);
					//$error->outputErrorMessages();
					//exit;
				}

				$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error updating: Project To Contact To Role';
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
			if (isset($projectToContactToRole) && $projectToContactToRole instanceof ProjectToContactToRole) {
				$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
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

	case 'updateAllProjectToContactToRoleAttributes':

		$crudOperation = 'updateAll';
		$errorNumber = 0;
		$errorMessage = '';
		$resetToPreviousValue = 'N';
		$save = true;

		try {

			$message->reset($currentPhpScript);
			$errorMessage = 'Error updating: Project To Contact To Role';
			$message->enqueueError($errorMessage, $currentPhpScript);

			// Update All case may check permissions by Attribute so retrieve inputs first
			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			// Check permissions - manage - Update Permissions may be dependent upon which attribute is being updated
			$enforcePermissions = false;
			if ($enforcePermissions) {
				$arrRequiredAndPermissions = array();
				$arrRequiredOrPermissions = array(
					'projects_to_contacts_to_roles_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error updating Project To Contact To Role.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project To Contact To Role';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects To Contacts To Roles';
			}

			// Primary key attibutes
			//$project_id = (int) $get->uniqueId;
			// Debug
			//$project_id = (int) 1;
			//$contact_id = (int) $get->uniqueId;
			// Debug
			//$contact_id = (int) 1;
			//$role_id = (int) $get->uniqueId;
			// Debug
			//$role_id = (int) 1;

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$project_id = (int) $get->project_id;
			$contact_id = (int) $get->contact_id;
			$role_id = (int) $get->role_id;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'projects_to_contacts_to_roles') {
				$arrTmp = explode('-', $uniqueId);
				$project_id = (int) array_shift($arrTmp);
				$contact_id = (int) array_shift($arrTmp);
				$role_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$projectToContactToRole = ProjectToContactToRole::findByProjectIdAndContactIdAndRoleId($database, $project_id, $contact_id, $role_id);
				/* @var $projectToContactToRole ProjectToContactToRole */

				if ($projectToContactToRole) {
					$existingData = $projectToContactToRole->getData();

					// Retrieve all of the $_GET inputs automatically for the ProjectToContactToRole record
					$httpGetInputData = $get->getData();
					// May want to "blank out" an attribute or set to null
					/*
					foreach ($httpGetInputData as $k => $v) {
						if (empty($v)) {
							unset($httpGetInputData[$k]);
						}
					}
					*/

					$projectToContactToRole->setData($httpGetInputData);
					$projectToContactToRole->convertDataToProperties();
					$projectToContactToRole->convertPropertiesToData();

					$newData = $projectToContactToRole->getData();
					$data = Data::deltify($existingData, $newData);

					if (!empty($data)) {
						$projectToContactToRole->setData($data);
						$save = true;
					} else {
						$errorNumber = 1;
						$errorMessage = 'Error updating: Project To Contact To Role<br>No Changes In Values';
						$message->enqueueError($errorMessage, $currentPhpScript);
						$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
						throw new Exception($errorMessage);
					}

					/*
			$projectToContactToRole->project_id = $project_id;
			$projectToContactToRole->contact_id = $contact_id;
			$projectToContactToRole->role_id = $role_id;
					*/

					// $project_to_contact_to_role_id = $projectToContactToRole->save();
					$projectToContactToRole->save();
					$errorNumber = 0;
					$errorMessage = '';
					$resetToPreviousValue = 'N';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project To Contact To Role record does not exist.';
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
			//$errorMessage = 'Error updating: Project To Contact To Role';
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
			if (isset($projectToContactToRole) && $projectToContactToRole instanceof ProjectToContactToRole) {
				$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
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

	case 'deleteProjectToContactToRole':

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
					'projects_to_contacts_to_roles_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				$arrErrorMessages = array(
					'Error deleting Project To Contact To Role.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project To Contact To Role';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects To Contacts To Roles';
			}

			// Primary key attibutes
			//$project_id = (int) $get->uniqueId;
			// Debug
			//$project_id = (int) 1;
			//$contact_id = (int) $get->uniqueId;
			// Debug
			//$contact_id = (int) 1;
			//$role_id = (int) $get->uniqueId;
			// Debug
			//$role_id = (int) 1;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			if ($attributeSubgroupName == 'projects_to_contacts_to_roles') {
				$arrTmp = explode('-', $uniqueId);
				$project_id = (int) array_shift($arrTmp);
				$contact_id = (int) array_shift($arrTmp);
				$role_id = (int) array_shift($arrTmp);

				// Put in findById() or findByUniqueKey() as appropriate
				$projectToContactToRole = ProjectToContactToRole::findByProjectIdAndContactIdAndRoleId($database, $project_id, $contact_id, $role_id);
				/* @var $projectToContactToRole ProjectToContactToRole */

				if ($projectToContactToRole) {
					$projectToContactToRole->delete();
					$errorNumber = 0;
					$errorMessage = '';
					$message->reset($currentPhpScript);
				} else {
					// Perhaps trigger an error
					$errorNumber = 1;
					$errorMessage = 'Project To Contact To Role record does not exist.';
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
			//$errorMessage = 'Error deleting: Project To Contact To Role';
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
			if (isset($projectToContactToRole) && $projectToContactToRole instanceof ProjectToContactToRole) {
				$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
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

	case 'saveProjectToContactToRole':

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
					'projects_to_contacts_to_roles_manage' => 1
				);
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot save new Project To Contact To Role data values.';
				$arrErrorMessages = array(
					'Error saving Project To Contact To Role.<br>Permission Denied.' => 1
				);
				require('code-generator/ajax-permissions.php');
			}

			if (!isset($sortOrderFlag) || empty($sortOrderFlag)) {
				$sortOrderFlag = 'N';
			}
			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Project To Contact To Role';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Projects To Contacts To Roles';
			}
			if (!isset($newAttributeGroupName) || empty($newAttributeGroupName)) {
				$newAttributeGroupName = 'manage-project_to_contact_to_role-record';
			}

			/*
			// Complete list of attibutes
			// The below assignments are for convenience and can be deleted
			$project_id = (int) $get->project_id;
			$contact_id = (int) $get->contact_id;
			$role_id = (int) $get->role_id;
			*/

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$message->reset($currentPhpScript);

			$projectToContactToRole = new ProjectToContactToRole($database);

			// Retrieve all of the $_GET inputs automatically for the ProjectToContactToRole record
			$httpGetInputData = $get->getData();
			foreach ($httpGetInputData as $k => $v) {
				if (empty($v)) {
					unset($httpGetInputData[$k]);
				}
			}

			$projectToContactToRole->setData($httpGetInputData);
			$projectToContactToRole->convertDataToProperties();

			/*
			$projectToContactToRole->project_id = $project_id;
			$projectToContactToRole->contact_id = $contact_id;
			$projectToContactToRole->role_id = $role_id;
			*/

			$projectToContactToRole->convertPropertiesToData();
			$data = $projectToContactToRole->getData();

			// Save or update via INSERT ON DUPLICATE KEY UPDATE or INSERT IGNORE
			// $project_to_contact_to_role_id = $projectToContactToRole->insertOnDuplicateKeyUpdate();
			// $projectToContactToRole->insertOnDuplicateKeyUpdate();
			$projectToContactToRole->insertIgnore();

			$projectToContactToRole->convertDataToProperties();
			$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Project To Contact To Role.';
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
			//$errorMessage = 'Error creating: Project To Contact To Role';
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
			if (isset($projectToContactToRole) && $projectToContactToRole instanceof ProjectToContactToRole) {
				$primaryKeyAsString = $projectToContactToRole->getPrimaryKeyAsString();
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

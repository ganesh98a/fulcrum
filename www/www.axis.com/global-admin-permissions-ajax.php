<?php
/**
 * Global admin permissions management.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['get_required'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
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

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

$db = DBI::getInstance($database);

//$session = Zend_Registry::get('session');
/* @var $session Session */
$users_user_company_id = $session->getUserCompanyId();
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
$axisTemplateProjectId = AXIS_TEMPLATE_PROJECT_ID;
$axisTemplateUserCompanyId = AXIS_TEMPLATE_USER_COMPANY_ID;

// Start output buffering to prevent output from being echo'd out
ob_start();

switch ($methodCall) {
	case 'updateSMFFlag':
		$input_id = $get->inputID;
		$isChecked = $get->isChecked;

		$message->enqueueError($input_id . '|Permission change was not saved!', $currentPhpScript);

		$arrInput = explode('__', $input_id);
		$software_module_function_id = $arrInput[0];
		$softwareModuleFunctionFlag = $arrInput[1];
		$softwareModuleFunctionFlagValue = $arrInput[2];

		if ($isChecked == 'true') {
			$dbFlagValue = 'Y';
		} else {
			$dbFlagValue = 'N';
		}

		$query =
"
UPDATE `software_module_functions`
SET `$softwareModuleFunctionFlag` = ?
WHERE `id` = ?
";
		$arrValues = array($dbFlagValue, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		break;

	case 'updateRoleFunctionPermission':

		$input_id = $get->inputID;
		$isChecked = $get->isChecked;

		$message->enqueueError($input_id . '|Permission change was not saved!', $currentPhpScript);

		$inputArray = explode("_",$input_id);
		$contact_id = $inputArray[1];
		$software_module_id = $inputArray[2];
		$project_id = $inputArray[3];
		$role_id = $inputArray[4];
		$software_module_function_id = $inputArray[5];

		if ($isChecked == "true") {
			$query =
"
INSERT
INTO `roles_to_software_module_function_templates` (`role_id`, `software_module_function_id`,`user_company_id`)
VALUES (?, ?, $users_user_company_id)
";
		} else {
			$query =
"
DELETE FROM `roles_to_software_module_function_templates`
WHERE `role_id` = ?
AND `software_module_function_id` = ?
";
		}
		$arrValues = array($role_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		echo $input_id ."|Permission updated";
		break;

		// If permission change is NOT tied to a specific contact
		if ($contact_id == "0") {
			if ($project_id == "0") {
				// If this module is not project specific query the `roles_to_software_module_functions` table
				if ($isChecked == "true") {
					$query =
"
INSERT
INTO `roles_to_software_module_functions` (`user_company_id`, `role_id`, `software_module_function_id`)
VALUES ($users_user_company_id, $role_id, $software_module_function_id)
";
				} else {
					$query =
"
DELETE FROM `roles_to_software_module_functions`
WHERE `user_company_id` = $users_user_company_id
AND `role_id` = $role_id
AND `software_module_function_id` = $software_module_function_id
";
				}
			} else {
				// If this module is project specific projects_to_roles_to_software_module_functions
				if ($isChecked == "true") {
					$query =
"
INSERT
INTO `projects_to_roles_to_software_module_functions` (`project_id`, `role_id`, `software_module_function_id`)
VALUES ($project_id, $role_id, $software_module_function_id)
";
				} else {
					$query =
"
DELETE FROM `projects_to_roles_to_software_module_functions`
WHERE `project_id` = $project_id
AND `role_id` = $role_id
AND `software_module_function_id` = $software_module_function_id
";
				}

			}
		} else {
			// If permission change is tied to a specific contact, then use contacts_to_software_module_functions table
			/**
			 *  @todo	Do we need to create an association between this contact and a project?
			 *
			 *  @todo	Are we giving them a chance to assign contacts to things that are not project specific?
			 */
			if ($isChecked == "true") {
				$query =
"
INSERT
INTO `contacts_to_software_module_functions` (`project_id`, `contact_id`, `software_module_function_id`)
VALUES ($project_id, $contact_id, $software_module_function_id)
";
			} else {
				$query =
"
DELETE
FROM `contacts_to_software_module_functions`
WHERE `contact_id` = $contact_id
AND `project_id` = $project_id
AND `software_module_function_id` = $software_module_function_id
";
			}
		}

		$db->query($query);

		echo $input_id ."|Permission updated";

		break;

	case 'removeContactFromFunctions':

		$contact_id = Data::parseInt($get->contact_id);
		$csvSoftwareModuleFunctionIds = $get->csvSoftwareModuleFunctionIds;

		$message->enqueueError('contactRow_' . $contact_id . '|Contact removal failed!', $currentPhpScript);

		$query =
"
DELETE
FROM `contacts_to_software_module_functions`
WHERE `contact_id` = ?
AND `software_module_function_id` = ?
";

		$arrSoftareModuleFunctionIds = explode(',', $csvSoftwareModuleFunctionIds);
		foreach ($arrSoftareModuleFunctionIds as $software_module_function_id) {
			$software_module_function_id = (int) $software_module_function_id;
			$arrValues = array($contact_id, $software_module_function_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		echo 'contactRow_' . $contact_id . '|Contact successfully removed';

		break;

	case 'resetToDefaultPermissions':

		$message->enqueueError('|Permissions Reset Failed!', $currentPhpScript);

		$project_id = Data::parseInt($get->project_id);
		$software_module_id = Data::parseInt($get->software_module_id);
		$project_specific_flag = (string) $get->project_specific_flag;

		if ($project_specific_flag == "N") {
			// If this module is not project specific - query the `roles_to_software_module_functions` table
			// Delete all exisiting permisisons for this module and user company
			$query =
"
DELETE r2smf
FROM `roles_to_software_module_functions` r2smf, `software_module_functions`  smf
WHERE r2smf.`user_company_id` = $users_user_company_id
AND r2smf.`software_module_function_id` = smf.`id`
AND smf.`software_module_id` = $software_module_id
";
			$db->query($query);

			$query =
"
INSERT
INTO `roles_to_software_module_functions` (`user_company_id`, `role_id`, `software_module_function_id`)
SELECT $users_user_company_id, `role_id`, `software_module_function_id`
FROM `roles_to_software_module_functions` r2smf, `software_module_functions` smf
WHERE r2smf.`user_company_id` = $axisTemplateUserCompanyId
AND r2smf.`software_module_function_id` = smf.`id`
AND smf.`software_module_id` = $software_module_id
AND (`role_id` <> $AXIS_USER_ROLE_ID_GLOBAL_ADMIN AND `role_id` <> $AXIS_USER_ROLE_ID_ADMIN)
";
			$db->query($query);
		} else {
			// This module is project specific - projects_to_roles_to_software_module_functions
			$query =
"
DELETE p2r2smf
FROM `projects_to_roles_to_software_module_functions` p2r2smf, `software_module_functions`  smf
WHERE p2r2smf.`project_id` = $project_id
AND p2r2smf.`software_module_function_id` = smf.`id`
AND smf.`software_module_id` = $software_module_id
";
			$db->query($query);

			$query =
"
INSERT
INTO `projects_to_roles_to_software_module_functions` (`project_id`, `role_id`, `software_module_function_id`)
SELECT $project_id, `role_id`, `software_module_function_id`
FROM `projects_to_roles_to_software_module_functions` p2r2smf, `software_module_functions` smf
WHERE p2r2smf.`project_id` = $axisTemplateProjectId
AND p2r2smf.`software_module_function_id` = smf.`id`
AND smf.`software_module_id` = $software_module_id
AND (`role_id` <> $AXIS_USER_ROLE_ID_GLOBAL_ADMIN AND `role_id` <> $AXIS_USER_ROLE_ID_ADMIN)
";
			$db->query($query);
		}

		break;
}

ob_flush();
exit;

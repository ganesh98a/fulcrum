<?php
try {

/**
 * Admin - manage permissions.
 */
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

require_once('lib/common/Contact.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/ProjectToContactToSoftwareModuleFunction.php');
require_once('lib/common/Role.php');
require_once('lib/common/RoleToSoftwareModuleFunction.php');
require_once('lib/common/SoftwareModuleFunction.php');
require_once('lib/common/SoftwareModuleRoleRecommendation.php');

require_once('page-components/dropDownListWidgets.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

// DATABASE VARIABLES
$db = DBI::getInstance($database);
/* @var $db DBI_mysqli */

// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$userRole = $session->getUserRole();

$encodedProjectName = Data::entity_encode($project_name);

// PERMISSION VARIABLES
require_once('app/models/permission_mdl.php');
/* @var $permissions Permissions */
$userCanViewPermissions = checkPermissionForAllModuleAndRole($database,'admin_permissions_view');
$userCanManagePermissions = checkPermissionForAllModuleAndRole($database,'admin_permissions_manage');
$userCanManageTeamMembers = checkPermissionForAllModuleAndRole($database,'admin_projects_team_members_manage');

if($userRole =="global_admin")
{
	$userCanViewPermissions = $userCanManagePermissions = $userCanManageTeamMembers=1;
}

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'loadPermissionModal':

		$htmlContent = '';

		// @todo Convert "#_Y/N" to separate variables with separate values
		// E.g. software_module_id=15_Y
		$software_module_id = (string) $get->software_module_id;

		// E.g. project_id=16
		$project_id = Data::parseInt($get->project_id);

		if (isset($project_id) && !empty($project_id)) {
			$project_id = (int) $project_id;
		} else {
			$project_id = 0;
		}

		$htmlContent .= <<<END_HTML_CONTENT

			<input id="ddl_software_module_id" type="hidden" value="$software_module_id">
			<input id="project_id" type="hidden" value="$project_id">
END_HTML_CONTENT;

		if (strstr($software_module_id, 'Y')) {

			if ($userCanManageTeamMembers) {

				$javaScriptHandler = 'teamManagement';
				include('page-components/contact_search_by_contact_company_name_or_contact_name.php');

				$htmlContent .= <<<END_HTML_CONTENT

					<table border="1" cellpadding="5" cellspacing="0" class="permissionTable" width="100%">
						<tr>
							<th class="permissionTableMainHeader">Add New Team Member</th>
						</tr>
						<tr>
							<td id="teamManagement" class="contact-search-parent-container">
								$contact_search_form_by_contact_company_name_or_contact_name_html
								$contact_search_form_by_contact_company_name_or_contact_name_javascript
							</td>
						</tr>
					</table>
END_HTML_CONTENT;

			}
		}

	$htmlContent .= <<<END_HTML_CONTENT
			<div id="divPermissionsAssignmentsByContact"></div>
			<div id="divPermissionsMatrix"></div>
			
END_HTML_CONTENT;
	if (strstr($software_module_id, 'Y')) {

		$htmlContent .= <<<END_HTML_CONTENT

					<div id="divProjectContactList"></div>
END_HTML_CONTENT;

		}

	

		echo $htmlContent;

	break;

	case 'loadPermissionsConfigurationMatrixByRole':

		try {

			if (!$userCanViewPermissions && !$userCanManagePermissions && !$userCanManageTeamMembers) {
				// Error and exit
				$errorMessage = 'Permission denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			// $db->throwExceptionOnDbError = true;

			/*
			* 1. Get all the module functions
			* 2. Get all roles
			* 3. IF project_id != 0
			* 		build roleFunctionArray from projects_to_roles_to_software_module_functions
			* 	  ELSE
			* 		build roleFunctionArray from roles_to_software_module_functions
			* 4. Get all this users contacts
			* 5. Get any contacts that have been assigned access to any of this modules' functions from contacts_to_software_module_functions
			*
			* START TO BUILD HTML
			* 5. headerRow:  loop through functions
			* 6. Loop through each role
			* 			Subloop through each function
			* 				Mark as checked if value exists in roleFunctionArray
			* 7. Create contact drop down
			* 8. Loop through contacts that have specific function access
			*/
			//To get the delay roles
			$query1 = "SELECT id FROM software_modules where software_module='jobsite_delay_logs' ";
				$db->execute($query1);
				$row1 = $db->fetch();
				$soft_id=$row1['id'];
			$query2 = "SELECT id FROM software_modules where software_module='Transmittal' ";
				$db->execute($query2);
				$row2 = $db->fetch();
				$trans_id=$row2['id'];
			/*Transmittal Admin Id Fetch*/
			$query3 = "SELECT id FROM software_modules where software_module='transmittal_admin' ";
				$db->execute($query3);
				$row2 = $db->fetch();
				$TAroleID=$row2['id'];
			/*Transmittal Admin Id Fetch*/
			$software_module_id = Data::parseInt($get->software_module_id);
			$project_id = Data::parseInt($get->project_id);
			
			$filter_by_recommended_roles_flag = Data::parseInt($get->filter_by_recommended_roles_flag);

			$softwareModule = SoftwareModule::findById($database, $software_module_id);
			/* @var $softwareModuleFunction SoftwareModuleFunction */
			$software_module_label = $softwareModule->software_module_label;
			$encodedSoftwareModuleLabel = Data::entity_encode($software_module_label);

			$is_disabled = ' disabled="disabled"';
			if ($userCanManagePermissions) {
				$is_disabled = '';
			}

			// Get all the software module functions for this module.
			$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions = new Input();
			$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->global_admin_only_flag = 'N';
			$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->forceLoadFlag = true;
			//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->arrOrderByAttributes = array(
			//	'smf.`sort_order`' => 'ASC',
			//	'smf.`software_module_function_label`' => 'ASC'
			//);
			//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->limit = 10;
			//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->offset = 0;
			$arrSoftwareModuleFunctionsBySoftwareModuleId = SoftwareModuleFunction::loadSoftwareModuleFunctionsBySoftwareModuleId($database, $software_module_id, $loadSoftwareModuleFunctionsBySoftwareModuleIdOptions);

/*
			// Get all the software module functions for this module.
			$query =
"
SELECT
	smf.*,
	smf.`id` as 'software_module_function_id'
FROM `software_module_functions` smf
WHERE smf.`software_module_id` = ?
AND smf.`global_admin_only_flag` = 'N'
AND smf.`disabled_flag` = 'N'
ORDER BY smf.`sort_order` ASC
";
			$arrValues = array($software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrSoftwareModuleFunctions = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['software_module_function_id'];

				//$row['id'] = $software_module_function_id;
				$softwareModuleFunction = IntegratedMapper::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id);
				$softwareModuleFunction->convertPropertiesToData();
				//$softwareModuleFunction->loadDependencies();

				$arrSoftwareModuleFunctions[$software_module_function_id] = $softwareModuleFunction;
			}
			$db->free_result();
*/
			/* @var $softwareModuleFunction SoftwareModuleFunction */


			// Get all roles
			/**
			 * @todo Decide how we want to manage roles as far as project specific or not project specific etc.
			 * contact_roles is the answer to that question
			 * user_roles and contact_roles comprise the end-to-end permission system
			 */
/*
			if ($userRole == "global_admin") {
				$query =
"
SELECT r.*
FROM `roles` r
ORDER BY r.`id`
";
			} else {
*/
			if ($project_id == 0) {
				// Load all Contact Roles (less User)
				// Use the role_alias values for "Contact Roles"
				// Do not skip the "User" role
				//$arrRoles = Role::loadContactRoles($database, true, true, false, $filter_by_recommended_roles_flag);
				$loadContactRolesOptions = new Input();
				$loadContactRolesOptions->forceLoadFlag = true;
				$loadContactRolesOptions->useRoleAliasesFlag = true;
				$loadContactRolesOptions->skipUserRoleFlag = false;
			/*Transmittal Admin Id compare*/
				if($software_module_id==$TAroleID )
					$roleTA = 'transmittal_roles';
				else
					$roleTA = 'contact_roles';
			/*Transmittal Admin Id compare*/
				$arrRoles = Role::loadContactRoles($database, $loadContactRolesOptions, $roleTA);
			} else {
				// Load all Project Roles (less User)
				// Use the role_alias values for "Project Roles"
				// Do not skip the "User" role
				//$arrRoles = Role::loadProjectRoles($database, true, true, false, $filter_by_recommended_roles_flag);
				$loadProjectRolesOptions = new Input();
				$loadProjectRolesOptions->forceLoadFlag = true;
				$loadProjectRolesOptions->useRoleAliasesFlag = true;
				$loadProjectRolesOptions->skipUserRoleFlag = false;
				if($software_module_id==$soft_id || $software_module_id==$trans_id){		// For Delay Roles and fot transmittal roles
					$arrRoles = Role::loadDelayRoles($database, $loadProjectRolesOptions);
				}else{
					$arrRoles = Role::loadProjectRoles($database, $loadProjectRolesOptions);
				}
				
			}

			$arrRecommendedRolesBySoftwareModuleId = SoftwareModuleRoleRecommendation::loadSoftwareModuleRoleRecommendationsBySoftwareModuleId($database, $software_module_id);
			$arrRecommendedRoles = array();
			foreach ($arrRecommendedRolesBySoftwareModuleId as $k => $softwareModuleRoleRecommendation) {
				$tmpRoleId = $softwareModuleRoleRecommendation->recommended_role_id;
				if (isset($arrRoles[$tmpRoleId])) {
					$tmpRole = $arrRoles[$tmpRoleId];
				} else {
					$tmpRole = 1;
				}
				$arrRecommendedRoles[$tmpRoleId] = $tmpRole;
			}
			// Possibly restrict the roles here
			/*
			foreach ($arrRoles as $tmpRoleId => $tmpRole) {
				if (!isset($arrRolesToKeep[$tmpRoleId])) {
					unset($arrRoles[$tmpRoleId]);
				}
			}
			*/

/*
			$query =
"
SELECT r.*
FROM `roles` r
WHERE r.`id` <> 1 AND r.`id` <> 2
ORDER BY r.`id`
";
			//}
			$db->query($query);

			//$arrRoles = array(0 => 'Everyone');
			$arrRoles = array();
			while ($row = $db->fetch()) {
				$role_id = $row['id'];
				$role = $row['role'];
				$arrRoles[$role_id] = $role;
			}
			$arrRoles[3] = 'All Users';
*/

			// Build $arrRolesToSoftwareModuleFunctions...a list of Software Module Functions (SMFs) by role_id (role)
			if ($project_id == 0) {
				$query =
"
SELECT r2smf.*
FROM `roles_to_software_module_functions` r2smf
WHERE r2smf.`user_company_id` = $user_company_id
";
				$db->query($query);

				$arrRolesToSoftwareModuleFunctions = array();
				while ($row = $db->fetch()) {
					$role_id = $row['role_id'];
					$software_module_function_id = $row['software_module_function_id'];
					$arrRolesToSoftwareModuleFunctions[$role_id][$software_module_function_id] = 1;
				}
			} else {
				$query =
"
SELECT p2r2smf.*
FROM `projects_to_roles_to_software_module_functions` p2r2smf
WHERE `project_id` = ?
";
				$arrValues = array($project_id);
				$db->free_result();
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$arrRolesToSoftwareModuleFunctions = array();
				while ($row = $db->fetch()) {
					$role_id = $row['role_id'];
					$software_module_function_id = $row['software_module_function_id'];
					$arrRolesToSoftwareModuleFunctions[$role_id][$software_module_function_id] = 1;
				}
				$db->free_result();
			}

			// 4. Get all this user_company's contacts
			$loadContactsByUserCompanyIdOptions = new Input();
			$loadContactsByUserCompanyIdOptions->forceLoadFlag = false;
			$arrContactsByUserCompanyId = Contact::loadContactsByUserCompanyId($database, $user_company_id, $loadContactsByUserCompanyIdOptions);

			// Get any contacts that have been assigned access to any of this modules' functions
			// first, determine which table to use: contacts_to_software_module_functions or projects_to_contacts_to_software_module_functions
			$db->free_result();
			if ($project_id == 0) {
				$query =
"
SELECT
	c2smf.*
FROM `contacts` c
	INNER JOIN `contacts_to_software_module_functions` c2smf ON c.`id` = c2smf.`contact_id`
	INNER JOIN `software_module_functions` smf ON c2smf.`software_module_function_id` = smf.`id`
WHERE c.`user_company_id` = ?
AND c.`is_archive`='N'
AND smf.`software_module_id` = ?
ORDER BY c.`first_name` ASC, c.`last_name` ASC
";
				$arrValues = array($user_company_id, $software_module_id);
			} elseif ($project_id <> 0) {
				$query =
"
SELECT
	p2c2smf.*
FROM `contacts` c
	INNER JOIN `projects_to_contacts_to_software_module_functions` p2c2smf ON c.`id` = p2c2smf.`contact_id`
	INNER JOIN `software_module_functions` smf ON p2c2smf.`software_module_function_id` = smf.`id`
WHERE p2c2smf.`project_id` = ?
and c.`user_company_id` = ?
AND c.`is_archive`='N'
AND smf.`software_module_id` = ?
ORDER BY c.`first_name` ASC, c.`last_name` ASC
";
				$arrValues = array($project_id, $user_company_id, $software_module_id);
			}
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrCustomizedPermissionsByContact = array();
			while ($row = $db->fetch()) {
				$contact_id = $row['contact_id'];
				$software_module_function_id = $row['software_module_function_id'];

				$contact = $arrContactsByUserCompanyId[$contact_id];

				//$arrCustomizedPermissionsByContact[$software_module_function_id][$contact_id] = $contact;
				$arrCustomizedPermissionsByContact[$contact_id]['contacts'] = $contact;
				$arrCustomizedPermissionsByContact[$contact_id]['functions'][$software_module_function_id] = 1;
			}
			$db->free_result();

			$softwareModuleFunctionCount = count($arrSoftwareModuleFunctionsBySoftwareModuleId);
			$roleCount = count($arrRoles);

			require('include/page-components/permissions-configuration-matrix-by-role.php');

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|contact_companies|Contact Company|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();

			// @todo Figure out this section
			// Output red section on form
			$errorNumber = 1;
			$errorMessage = 'Error loading: Permissions Matrix.';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$primaryKeyAsString = '';

			echo $errorMessage;
		}

	break;

	case 'loadPermissionsAssignmentsByRole':

		try {

			if (!$userCanViewPermissions && !$userCanManagePermissions && !$userCanManageTeamMembers) {
				// Error and exit
				$errorMessage = 'Permission denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
			}

			/*
			 * 1. Get all the module functions
			 * 2. Get all roles
			 *
			 *
			 * START TO BUILD HTML
			 * 5. headerRow:  loop through functions
			 * 6. Loop through each role
			 * 			Subloop through each function
			 * 				Mark as checked if value exists in roleFunctionArray
			 * 8. Loop through contacts that have specific function access
			 */

			$software_module_id = $get->software_module_id;
			$project_id = $get->project_id;
			$filterval = $get->filterval;
			

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$softwareModule = SoftwareModule::findById($database, $software_module_id);
			/* @var $softwareModuleFunction SoftwareModuleFunction */
			$software_module_label = $softwareModule->software_module_label;
			$encodedSoftwareModuleLabel = Data::entity_encode($software_module_label);

			// Get all the software module functions for this module.
			$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions = new Input();
			$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->global_admin_only_flag = 'N';
			$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->forceLoadFlag = true;
			//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->arrOrderByAttributes = array(
			//	'smf.`sort_order`' => 'ASC',
			//	'smf.`software_module_function_label`' => 'ASC'
			//);
			//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->limit = 10;
			//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->offset = 0;
			$arrSoftwareModuleFunctionsBySoftwareModuleId = SoftwareModuleFunction::loadSoftwareModuleFunctionsBySoftwareModuleId($database, $software_module_id, $loadSoftwareModuleFunctionsBySoftwareModuleIdOptions);

			/*
			$query =
"
SELECT smf.*
FROM `software_module_functions` smf
WHERE smf.`software_module_id` = ?
AND smf.`global_admin_only_flag` = 'N'
ORDER BY smf.`id`
";
			$arrValues = array($software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrSoftwareModuleFunctions = array();
			while ($row = $db->fetch()) {
				$software_module_function_id = $row['id'];
				$software_module_function_label = $row['software_module_function_label'];
				$arrSoftwareModuleFunctions[$software_module_function_id] = $software_module_function_label;
			}
			$db->free_result();
*/


			// Get all roles
			/**
			 * @todo Decide how we want to manage roles as far as project specific or not project specific etc.
			 * contact_roles is the answer to that question
			 * user_roles and contact_roles comprise the end-to-end permission system
			 */
			//$arrRoles = Role::loadAllRoles($database, true);

/*
			$query =
"
SELECT r.*
FROM `roles` r
WHERE r.`id` <> 1 AND r.`id` <> 2
ORDER BY r.`id`
";
			//}
			$db->query($query);

			$arrRoles = array();
			while ($row = $db->fetch()) {
				$role_id = $row['id'];
				$role = $row['role'];
				$arrRoles[$role_id] = $role;
			}
*/


			$arrContactPermissionsMatrix = Permissions::loadContactsForSoftwareModulePermissionsMatrix($database, $user_company_id, $software_module_id, $project_id);
			// To check whether the array is present or not and assign it to the variable
			$arrContacts = (isset($arrContactPermissionsMatrix['contacts_objects']))?$arrContactPermissionsMatrix['contacts_objects']:array();

			// Build $arrRolesToSoftwareModuleFunctions...a list of Software Module Functions (SMFs) by role_id (role)
			if ($project_id == 0) {
				// System Permission Assignments
				$permissionsHeadline = "&ldquo;$encodedSoftwareModuleLabel&rdquo; System Permissions By Role";

				$query =
"
SELECT r2smf.*
FROM `roles_to_software_module_functions` r2smf
WHERE r2smf.`user_company_id` = $user_company_id
";
				$db->query($query);

				$arrRolesToSoftwareModuleFunctions = array();
				while ($row = $db->fetch()) {
					$role_id = $row['role_id'];
					$software_module_function_id = $row['software_module_function_id'];
					$arrRolesToSoftwareModuleFunctions[$role_id][$software_module_function_id] = 1;
				}
			} else {
				$permissionsHeadline = "&ldquo;$encodedSoftwareModuleLabel&rdquo; Permission Assignments For &ldquo;$encodedProjectName&rdquo; ";

				$query =
"
SELECT p2r2smf.*
FROM `projects_to_roles_to_software_module_functions` p2r2smf
WHERE `project_id` = ?
";
				$arrValues = array($project_id);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

				$arrRolesToSoftwareModuleFunctions = array();
				while ($row = $db->fetch()) {
					$role_id = $row['role_id'];
					$software_module_function_id = $row['software_module_function_id'];
					$arrRolesToSoftwareModuleFunctions[$role_id][$software_module_function_id] = 1;
				}
				$db->free_result();
			}
			// To check whether the array is present or not and assign it to the variable
			$arrSortedRoles = (isset($arrContactPermissionsMatrix['sortable_roles_by_name']))?$arrContactPermissionsMatrix['sortable_roles_by_name']:array();
			$arrSortedRoles = array_flip($arrSortedRoles);

			$softwareModuleFunctionCount = count($arrSoftwareModuleFunctionsBySoftwareModuleId);

			// START TO BUILD HTML
					//<tr><th class="permissionTableMainHeader" colspan="'.($softwareModuleFunctionCount + 1).'">Contacts With '.$permissionsHeadline.' Permissions Based On Above Assignments</th></tr>

			echo '
				<table class="permissionTable" border="1" cellpadding="5" cellspacing="0">
					<tr><th class="permissionTableMainHeader" colspan="'.($softwareModuleFunctionCount + 1).'">'.$permissionsHeadline.' (based on the above assignments)</th></tr>
					<tr>
						<th class="permissionFunctionCell">Contact</th>
						<!--<th>Company</th>-->
			';
			foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $softwareModuleFunction) {
				echo '
						<th class="permissionFunctionCell">'.$softwareModuleFunction->software_module_function_label.'</th>
				';
			}
			echo '
					</tr>
			';

			$arrSortedContacts =(isset($arrContactPermissionsMatrix['sortable_contacts_by_full_name']))?$arrContactPermissionsMatrix['sortable_contacts_by_full_name']:array();
			uksort($arrSortedContacts, 'strnatcasecmp');
			if(!empty($arrSortedContacts)){
			foreach ($arrSortedContacts AS $null => $contact_id) {
				$contact = $arrContacts[$contact_id];
				$contactCompany = $contact->getContactCompany();
				$arrContactsRoles = $contact->getRoles();

				$contactFullName = $contact->getContactFullName();

				$contactFullNameWithEmail = $contact->getContactFullNameWithEmail(true, '<', '-');
				$encodedContactFullNameWithEmail = Data::entity_encode($contactFullNameWithEmail);


				// If the the contact is only an admin, then we don't want to show the contact
				if ( isset($arrContactPermissionsMatrix['admin_contact_ids'][$contact_id]) && count($arrContactsRoles) == 0 ) {
					//continue;
				}

				$team_member= '
					<tr>
						<td nowrap title="'.$contactCompany->contact_company_name.'" class="permissionFirstCell">
							<a href="javascript:showContactsRoles(\''.$contact->id.'\')">'.$encodedContactFullNameWithEmail.'</a>
						</td>
						<!--<td>Company</td>-->
				';
				$team_inner ='';
				foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $softwareModuleFunction) {
					$team_inner .= '
						<td class="permissionFunctionCell" title="'.$software_module_function_id.'">
					';
					if (
						isset($arrContactPermissionsMatrix['role_based']['software_module_function_ids_to_contact_ids'][$software_module_function_id][$contact_id])
						||
							isset($arrContactPermissionsMatrix['ad_hoc']['software_module_function_ids_to_contact_ids'][$software_module_function_id][$contact_id])
						||
							(isset($arrContactPermissionsMatrix['admin_contact_ids'][$contact_id]) && $softwareModuleFunction['software_module_function_label'] != 'DCR Report') //given access for admin for all modules expect DCR Report
					) {
						$team_inner .= 'YES';
					} else {
						$team_inner .= '&nbsp;';
					}
					$team_inner .= '
						</td>
					';
				}
				$team_inner .= '
					</tr>
				';

				// Loop through each contacts roles
				$arrContactsRolesTemp = array_intersect_key($arrSortedRoles, $arrContactsRoles);
				$arrContactsRolesTemp = array_flip($arrContactsRolesTemp);
				uksort($arrContactsRolesTemp, 'strnatcasecmp');
				$Permission_contact='';
				$to_show_team='';
				$tmember_arr=array();
				$k=0;
				
				foreach ($arrContactsRolesTemp as $role_name => $role_id) {
					//$role = $arrContactsRoles[$role_id];
					if($role_id=='14' || $role_id=='15' || $role_id=='3')
					{
						$to_show_team='1';
						$tmember_arr[$k]='1';

					}else
					{
						$tmember_arr[$k]='0';
					}
					$k++;
					$Permission_contact .= '
					<tr class="permissionContactRoleRow contact_'.$contact->id.' hidden">
					';
					$Permission_contact .= '
						<td nowrap class="permissionContactRoleCell">'.$role_name.'</td>
					';
					// Loop through each software module function
					foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $softwareModuleFunction) {
						$Permission_contact .= '
							<td class="permissionFunctionCell">
						';
						if (isset($arrRolesToSoftwareModuleFunctions[$role_id][$software_module_function_id])) {
							$Permission_contact .= 'YES';
						} else {
							$Permission_contact .= '&nbsp;';
						}
						$Permission_contact .= '
							</td>
						';
					}
					$Permission_contact .= '
					</tr>
					';
				}
				if($filterval)
				{
				if((in_array('0', $tmember_arr)))
				{
					
						echo $team_member.$team_inner.$Permission_contact;
				}
				// if($to_show_team!='1')
		// echo $team_member.$team_inner.$Permission_contact;
}
else
{
	echo $team_member.$team_inner.$Permission_contact;
}

				// Check all boxes for Admins
				if ( isset($arrContactPermissionsMatrix['admin_contact_ids'][$contact->id]) ) {
					echo '
					<tr class="permissionContactRoleRow contact_'.$contact->id.' hidden">
					';
					echo '
						<td nowrap class="permissionContactRoleCell">Admin</td>
					';
					// Loop through each software module function
					foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $softwareModuleFunction) {
            //given access for admin for all modules expect DCR Report
						if (
							isset($arrContactPermissionsMatrix['role_based']['software_module_function_ids_to_contact_ids'][$software_module_function_id][$contact_id])
							||
								isset($arrContactPermissionsMatrix['ad_hoc']['software_module_function_ids_to_contact_ids'][$software_module_function_id][$contact_id])
							||
								(isset($arrContactPermissionsMatrix['admin_contact_ids'][$contact_id]) && $softwareModuleFunction['software_module_function_label'] != 'DCR Report')
						) {
							echo '
							<td class="permissionFunctionCell">YES</td>
							';
						}else{
							echo '
							<td class="permissionFunctionCell">&nbsp;</td>
							';
						}

					}
					echo '
					</tr>
					';
				}
			}
		}

			echo'
				</table>
			';

			//require('include/page-components/permissions-assignments-by-role.php');

			// Load Output Format: "Error #|Error Message|Record/Attribute Group Name|Formatted Record/Attribute Group Name|HTML Output"
			// DOM Element Container id format: record_list_container--sql_table_name/attribute_group_name
			//echo "$errorNumber|$errorMessage|contact_companies|Contact Company|$htmlContent";

		} catch (Exception $e) {
			$db->rollback();

			// @todo Figure out this section
			// Output red section on form
			$errorNumber = 1;
			$errorMessage = 'Error loading Permissions Assignments.';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$primaryKeyAsString = '';

			echo $errorMessage;
		}

	break;

	case 'updateRoleFunctionPermission':
		// InputID = user_company_id _ contact_id _ software_module_id _ project_id _ role_id _ software_module_function_id
		$input_id = $get->inputID;
		$isChecked = $get->isChecked;

		$csvInputIds = $get->csvInputIds;
		$arrInputIds = explode(',', $csvInputIds);
		if (empty($csvInputIds)) {
			$arrInputIds = array($input_id);
		}

		$message->enqueueError($input_id . '|Permission change was not saved!', $currentPhpScript);

		foreach ($arrInputIds as $input_id) {

			$inputArray = explode("_",$input_id);
			//$user_company_id = $inputArray[0];
			$contact_id = $inputArray[1];
			$software_module_id = $inputArray[2];
			$project_id = $inputArray[3];
			$role_id = $inputArray[4];
			$software_module_function_id = $inputArray[5];

			// 1) check project_id
			// 2) check contact_id
			// 3) apply permission change
			if ($project_id == 0) {
				// roles_to_software_module_functions
				// or
				// contacts_to_software_module_functions
				if ($contact_id == 0) {
					// roles_to_software_module_functions
					$arrValues = array($user_company_id, $role_id, $software_module_function_id);
					if ($isChecked == "true") {
						$query =
"
INSERT IGNORE
INTO `roles_to_software_module_functions` (`user_company_id`, `role_id`, `software_module_function_id`)
VALUES (?, ?, ?)
";
					} else {
						$query =
"
DELETE
FROM `roles_to_software_module_functions`
WHERE `user_company_id` = ?
AND `role_id` = ?
AND `software_module_function_id` = ?
";
					}
				} elseif ($contact_id <> 0) {
					// contacts_to_software_module_functions
					$arrValues = array($contact_id, $software_module_function_id);
					if ($isChecked == "true") {
						$query =
"
INSERT IGNORE
INTO `contacts_to_software_module_functions` (`contact_id`, `software_module_function_id`)
VALUES (?, ?)
";
					} else {
						$query =
"
DELETE
FROM `contacts_to_software_module_functions`
WHERE `contact_id` = ?
AND `software_module_function_id` = ?
";
					}
				}
			} elseif ($project_id <> 0) {
				// projects_to_roles_to_software_module_functions
				// or
				// projects_to_contacts_to_software_module_functions
				if ($contact_id == 0) {
					// projects_to_roles_to_software_module_functions
					$arrValues = array($project_id, $role_id, $software_module_function_id);
					if ($isChecked == "true") {
						$query =
"
INSERT IGNORE
INTO `projects_to_roles_to_software_module_functions` (`project_id`, `role_id`, `software_module_function_id`)
VALUES (?, ?, ?)
";
					} else {
						$query =
"
DELETE
FROM `projects_to_roles_to_software_module_functions`
WHERE `project_id` = ?
AND `role_id` = ?
AND `software_module_function_id` = ?
";
					}
				} else {
					// projects_to_contacts_to_software_module_functions
					$arrValues = array($project_id, $contact_id, $software_module_function_id);
					if ($isChecked == "true") {
						$query =
"
INSERT IGNORE
INTO `projects_to_contacts_to_software_module_functions` (`project_id`, `contact_id`, `software_module_function_id`)
VALUES (?, ?, ?)
";
					} else {
						$query =
"
DELETE
FROM `projects_to_contacts_to_software_module_functions`
WHERE `project_id` = ?
AND `contact_id` = ?
AND `software_module_function_id` = ?
";
					}
				}
			}

			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

		}

		//echo $input_id ."|Permission updated";
		$customSuccessMessage = 'Permission Updated';

		$arrOutput = array(
			'elementId' => $input_id,
			'project_id' => $project_id,
			'contact_id' => $contact_id,
			'role_id' => $role_id,
			'software_module_id' => $software_module_id,
			'software_module_function_id' => $software_module_function_id,
			'customSuccessMessage' => $customSuccessMessage,
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'removeContactFromFunctions':

		$contact_id = $get->contact_id;
		$csvSoftwareModuleFunctionIds = $get->csvSoftwareModuleFunctionIds;
		$project_id = $get->project_id;

		$message->enqueueError('contactRow_' . $contact_id . '|Contact removal failed!', $currentPhpScript);

		if ($project_id == 0) {

			$query =
"
DELETE
FROM `contacts_to_software_module_functions`
WHERE `contact_id` = ?
AND `software_module_function_id` = ?
";

		} else {

			$query =
"
DELETE
FROM `projects_to_contacts_to_software_module_functions`
WHERE `project_id` = ?
AND `contact_id` = ?
AND `software_module_function_id` = ?
";

		}

		$arrSoftareModuleFunctionIds = explode(',', $csvSoftwareModuleFunctionIds);
		foreach ($arrSoftareModuleFunctionIds as $software_module_function_id) {
			if ($project_id == 0) {
				$arrValues = array($contact_id, $software_module_function_id);
			} else {
				$arrValues = array($project_id, $contact_id, $software_module_function_id);
			}
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}
		//echo 'contactRow_' . $contact_id . '|Contact successfully removed';

		$elementId = 'contactRow_' . $contact_id;
		$customSuccessMessage = 'Contact Successfully Removed';

		$arrOutput = array(
			'elementId' => $elementId,
			'project_id' => $project_id,
			'contact_id' => $contact_id,
			'csvSoftwareModuleFunctionIds' => $csvSoftwareModuleFunctionIds,
			'customSuccessMessage' => $customSuccessMessage,
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'resetToDefaultPermissions':
		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		$message->enqueueError('|Permissions Reset Failed!', $currentPhpScript);

		$project_id = Data::parseInt($get->project_id);
		$software_module_id = Data::parseInt($get->software_module_id);
		$project_specific_flag = (string) $get->project_specific_flag;
		if ($project_specific_flag == 'N') {
			// If this module is not project specific - query the `roles_to_software_module_functions` table
			// Delete all exisiting permisisons for this module and user company
			$query =
"DELETE r2smf
FROM `roles_to_software_module_functions` r2smf, `software_module_functions` smf
WHERE r2smf.`user_company_id` = $user_company_id
AND r2smf.`software_module_function_id` = smf.`id`
AND smf.`software_module_id` = ?
";
			$arrValues = array($software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$query =
"
INSERT
INTO `roles_to_software_module_functions` (`user_company_id`, `role_id`, `software_module_function_id`)
SELECT $user_company_id, `role_id`, `software_module_function_id`
FROM `roles_to_software_module_function_templates` r2smft, `software_module_functions` smf
WHERE r2smft.`software_module_function_id` = smf.`id`
AND smf.`software_module_id` = ?
AND (r2smft.`role_id` <> $AXIS_USER_ROLE_ID_GLOBAL_ADMIN AND r2smft.`role_id` <> $AXIS_USER_ROLE_ID_ADMIN)  GROUP BY `user_company_id`, `role_id`, `software_module_function_id`
";
			$arrValues = array($software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} else {
			// This module is project specific - projects_to_roles_to_software_module_functions
			$query =
"
DELETE p2r2smf
FROM `projects_to_roles_to_software_module_functions` p2r2smf, `software_module_functions`  smf
WHERE p2r2smf.`project_id` = ?
AND p2r2smf.`software_module_function_id` = smf.`id`
AND smf.`software_module_id` = ?
";
			$arrValues = array($project_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
// echo $AXIS_USER_ROLE_ID_GLOBAL_ADMIN."-".$AXIS_USER_ROLE_ID_ADMIN;die();
			$query =
"
INSERT
INTO `projects_to_roles_to_software_module_functions` (`project_id`, `role_id`, `software_module_function_id`)
SELECT ?, `role_id`, `software_module_function_id`
FROM `roles_to_software_module_function_templates` p2r2smft, `software_module_functions` smf
WHERE p2r2smft.`software_module_function_id` = smf.`id` 
AND smf.`software_module_id` = ?
AND (`role_id` <> $AXIS_USER_ROLE_ID_GLOBAL_ADMIN AND `role_id` <> $AXIS_USER_ROLE_ID_ADMIN)  GROUP BY  `role_id`, `software_module_function_id`
";
			$arrValues = array($project_id, $software_module_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

	break;
	case 'updateSiteMenuOption':
	$menu_value = (string) $get->menu_value;
	$query =
"
UPDATE site_settings SET `site_value` = '$menu_value'
WHERE `site_option` = 'Menu'
";
			$db->execute($query);
			$db->free_result();
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

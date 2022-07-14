<?php
/**
 * Permissions Management Details.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Contact.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/ProjectToContactToSoftwareModuleFunction.php');
require_once('lib/common/Role.php');
require_once('lib/common/RoleToSoftwareModuleFunction.php');
require_once('lib/common/SoftwareModuleFunction.php');

require_once('page-components/dropDownListWidgets.php');


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

$software_module_id = Data::parseInt($get->software_module_id);
$project_id = Data::parseInt($get->project_id);

$user_company_id = $session->getUserCompanyId();
$userRole = $session->getUserRole();

// Set permission variables
require_once('app/models/permission_mdl.php');
$userCanViewPermissions = checkPermissionForAllModuleAndRole($database,'admin_permissions_view');
$userCanManagePermissions = checkPermissionForAllModuleAndRole($database,'admin_permissions_manage');

if($userRole =="global_admin")
{
	$userCanViewPermissions = $userCanManagePermissions =1;
}

$is_disabled = ' disabled="disabled"';
if ($userCanManagePermissions) {
	$is_disabled = '';
}

$db = DBI::getInstance($database);

// Get all the software module functions for this module.
$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions = new Input();
$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->global_admin_only_flag = 'N';
$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->disabled_flag = 'N';
$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->forceLoadFlag = true;
//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->arrOrderByAttributes = array(
//	'smf.`sort_order`' => 'ASC',
//	'smf.`software_module_function_label`' => 'ASC'
//);
//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->limit = 10;
//$loadSoftwareModuleFunctionsBySoftwareModuleIdOptions->offset = 0;
$arrSoftwareModuleFunctionsBySoftwareModuleId = SoftwareModuleFunction::loadSoftwareModuleFunctionsBySoftwareModuleId($database, $software_module_id, $loadSoftwareModuleFunctionsBySoftwareModuleIdOptions);


// Get all roles
/**
 * @todo Decide how we want to manage roles as far as project specific or not project specific etc.
 * contact_roles is the answer to that question
 * user_roles and contact_roles comprise the end-to-end permission system
 */
/*
if ($userRole == 'global_admin') {
	$query =
"
SELECT r.*
FROM `roles` r
ORDER BY r.`id`
";
} else {
*/
$loadContactRolesOptions = new Input();
$loadContactRolesOptions->forceLoadFlag = true;
$arrRoles = Role::loadContactRoles($database, $loadContactRolesOptions);

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
if ($project_id == 0) {
	$query =
"
SELECT
	c2smf.*
FROM `contacts` c
	INNER JOIN `contacts_to_software_module_functions` c2smf ON c.`id` = c2smf.`contact_id`
	INNER JOIN `software_module_functions` smf ON c2smf.`software_module_function_id` = smf.`id`
WHERE c.`user_company_id` = ?
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

// START TO BUILD HTML
?>
<table class="permissionTable" border="1" cellpadding="5" cellspacing="0">
<!--
	<tr>
<?php if ($project_id == 0) { ?>
		<th colspan="<?php echo ($softwareModuleFunctionCount + 1); ?>">Customized Permissions by Role<br>(contacts_to_roles, roles_to_software_module_functions)<br>or<br>"Everyone / All Users"<br>(user_companies_to_all_contacts_to_software_module_functions)<br><br>Software Module Functions</th>
<?php } else { ?>
		<th colspan="<?php echo ($softwareModuleFunctionCount + 1); ?>">Customized Permissions by Project by Role<br>(projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions)<br>or<br>(user_companies_to_all_owned_projects_to_contacts_to_roles, user_companies_to_all_owned_projects_to_roles_to_software_module_functions)<br><br>Software Module Functions</th>
<?php } ?>
	</tr>
 -->
 	<tr>
 		<th class="permissionTableMainHeader" colspan="<?php echo ($softwareModuleFunctionCount + 1); ?>">Configure Module Permissions By Roles</th>
 	</tr>

	<tr>
		<th class="permissionFunctionCell">Roles</th>
<?php

$softwareModule = SoftwareModule::findById($database, $software_module_id);
$software_module_label = $softwareModule->software_module_label;
echo '<th class="thCheckAll">Toggle all</th>';

// Build and set the module functionality headers
foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $softwareModuleFunction) {
	/* @var $softwareModuleFunction SoftwareModuleFunction */

	$headerStyle = "";
	if ($softwareModuleFunction->show_in_navigation_flag == 'N') {
		$headerStyle = ' style="background-color:grey;" title="This function does not cause this module to appear in the navigation"';
	} else {
		$headerStyle = ' title="This function causes this module to appear in the navigation."';
	}
	echo '
		<th class="permissionFunctionCell bs-tooltip"'.$headerStyle.' data-toggle="tooltip" data-placement="right">'.$softwareModuleFunction->software_module_function_label.'</th>
	';
}

?>
	</tr>

<?php
// Loop through each role
foreach ($arrRoles as $role_id => $role) {
	/* @var $role Role */
	$role_name = $role->role;
	echo '<tr><td nowrap class="permissionFirstCell">'.$role_name.'</td>';
	echo '<td class="textAlignCenter"><input type="checkbox" onchange="toggleAllCheckboxesInRow(this);"></td>';

	// Loop through each software module function
	foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $softwareModuleFunction) {
		/* @var $softwareModuleFunction SoftwareModuleFunction */

		$softwareModuleFunction->loadDependencies();
		$arrSoftwareModuleFunctionDependencies = $softwareModuleFunction->getDependencies();
		if (isset($arrSoftwareModuleFunctionDependencies[$software_module_function_id])) {
			$arrTemp = $arrSoftwareModuleFunctionDependencies[$software_module_function_id];
			$dependenciesList = array_keys($arrTemp);
			$dependenciesList = join(",", $dependenciesList);
		} else {
			$dependenciesList = '';
		}
		$softwareModuleFunction->loadPrerequisites();
		$arrSoftwareModuleFunctionPrerequisites = $softwareModuleFunction->getPrerequisites();
		if (isset($arrSoftwareModuleFunctionPrerequisites[$software_module_function_id])) {
			$arrTemp = $arrSoftwareModuleFunctionPrerequisites[$software_module_function_id];
			$prerequisitesList = array_keys($arrTemp);
			$prerequisitesList = join(",", $prerequisitesList);
		} else {
			$prerequisitesList = '';
		}
		if (isset($arrRolesToSoftwareModuleFunctions[$role_id]) && isset($arrRolesToSoftwareModuleFunctions[$role_id][$software_module_function_id])) {
			echo '<td id="td_'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" class="permissionFunctionCell">
					<input id="'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" type="checkbox"'.$is_disabled.' checked onclick="togglePermission(this.id, \''.$prerequisitesList.'\', \''.$dependenciesList.'\');">
				  </td>';
		} else {
			echo '<td id="td_'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" class="permissionFunctionCell">
					<input id="'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" type="checkbox"'.$is_disabled.' onclick="togglePermission(this.id, \''.$prerequisitesList.'\', \''.$dependenciesList.'\');">
				  </td>';
		}
	}

	echo '
	</tr>
	';
}

echo '
	<tr>
		<td colspan="'.($roleCount + 2).'" class="loginForm">
			<a href="javascript:showAdHocRow();">In rare cases you may want to give a contact more permission than what their roles permit</a>
		</td>
	</tr>
';

// DDL of contacts
$input = new Input();
$input->database = $database;
$input->user_company_id = $user_company_id;
$input->csvContactIdExclusionList = $arrCustomizedPermissionsByContact;
$input->selected_contact_id = '';
$input->htmlElementId = 'ddlContact';
$input->js = 'onchange="ddlContactChanged();"';
$input->firstOption = 'Add Specific Contact';
$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildContactsFullNameWithEmailByUserCompanyIdDropDownList($input);

echo '
	<tr id="addHocRow" style="display:none;">
		<td>
			'.$contactsFullNameWithEmailByUserCompanyIdDropDownList.'
			<br>
			<br>
';
/*
			<select id="ddlContact"'.$is_disabled.' onchange="ddlContactChanged();">
				<option value="0">Add Specific Contact</option>
';
*/

// Loop through each contact
//foreach ($arrContactsByUserCompanyId as $contact_id => $contact) {
//	/* @var $contact Contact */
//	if (!array_key_exists($contact_id, $arrCustomizedPermissionsByContact)) {
//		$contactFullName = $contact->getContactFullName();
//
//		echo '
//				<option value="'.$contact_id.'">'.$contactFullName.'</option>
//		';
//	}
//}

// </select>
echo '
		</td>
';
// Loop through each Software Module Function
foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $null) {
	echo '
		<td id="td_'.$user_company_id.'_X_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" style="text-align: center;">
			<input id="'.$user_company_id.'_X_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" name="newContactPermissionCheckbox" type="checkbox"'.$is_disabled.' onclick="newContactPermissionClicked(this.id);" style="display:none;">
		</td>
	';
}

echo'
	</tr>
';

// Loop through each role
$csvSoftwareModuleFunctionIds = implode(",",array_keys($arrSoftwareModuleFunctionsBySoftwareModuleId));
foreach ($arrCustomizedPermissionsByContact as $tmpContactId => $null) {
	$contact = 	$arrCustomizedPermissionsByContact[$tmpContactId]['contacts'];
	//$contactFullName = $contact->getContactFullName();
	$contactFullNameWithEmail = $contact->getContactFullNameWithEmail(true, '<', '(');
	$encodedContactFullNameWithEmail = Data::entity_encode($contactFullNameWithEmail);

	echo '
	<tr id="contactRow_'.$tmpContactId.'">
		<td><a class="smallerFont" href="javascript:removeContactFromModule('.$tmpContactId.', \''.$csvSoftwareModuleFunctionIds.'\', \''.$project_id.'\')">X</a> '.$encodedContactFullNameWithEmail.'</td>
	';

	// Loop through each module function
	foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $softwareModuleFunction) {
		/* @var $softwareModuleFunction SoftwareModuleFunction */

		$softwareModuleFunction->loadDependencies();
		$arrSoftwareModuleFunctionDependencies = $softwareModuleFunction->getDependencies();
		if (isset($arrSoftwareModuleFunctionDependencies[$software_module_function_id])) {
			$arrTemp = $arrSoftwareModuleFunctionDependencies[$software_module_function_id];
			$dependenciesList = array_keys($arrTemp);
			$dependenciesList = join(",", $dependenciesList);
		} else {
			$dependenciesList = '';
		}
		$softwareModuleFunction->loadPrerequisites();
		$arrSoftwareModuleFunctionPrerequisites = $softwareModuleFunction->getPrerequisites();
		if (isset($arrSoftwareModuleFunctionPrerequisites[$software_module_function_id])) {
			$arrTemp = $arrSoftwareModuleFunctionPrerequisites[$software_module_function_id];
			$prerequisitesList = array_keys($arrTemp);
			$prerequisitesList = join(",", $prerequisitesList);
		} else {
			$prerequisitesList = '';
		}
		if (array_key_exists($tmpContactId, $arrCustomizedPermissionsByContact) && array_key_exists($software_module_function_id, $arrCustomizedPermissionsByContact[$tmpContactId]["functions"])) {
			echo '
		<td id="td_'.$user_company_id.'_'.$tmpContactId.'_'.$software_module_id.'_'.$project_id.'_0_'.$software_module_function_id.'" style="text-align: center;">
			<input id="'.$user_company_id.'_'.$tmpContactId.'_'.$software_module_id.'_'.$project_id.'_0_'.$software_module_function_id.'" type="checkbox"'.$is_disabled.' checked onclick="togglePermission(this.id, \''.$prerequisitesList.'\', \''.$dependenciesList.'\');">
		</td>
			';
		} else {
			echo '
		<td id="td_'.$user_company_id.'_'.$tmpContactId.'_'.$software_module_id.'_'.$project_id.'_0_'.$software_module_function_id.'" style="text-align: center;">
			<input id="'.$user_company_id.'_'.$tmpContactId.'_'.$software_module_id.'_'.$project_id.'_0_'.$software_module_function_id.'" type="checkbox"'.$is_disabled.' onclick="togglePermission(this.id, \''.$prerequisitesList.'\', \''.$dependenciesList.'\');">
		</td>';
		}
	}

	echo '
	</tr>
	';
}
?>
</table>

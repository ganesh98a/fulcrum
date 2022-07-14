<?php
/**
 * Permissions Management Details.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = true;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
require_once('lib/common/init.php');



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

$software_module_id = $get->software_module_id;
$project_id = $get->project_id;

$user_company_id = $session->getUserCompanyId();
$userRole = $session->getUserRole();
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

$arrSoftwareModuleFunctionFlags = array();
$arrSoftwareModuleFunctionFlagsTmp = array(
	'show_in_navigation_flag' => 'Show in<br>Navigation',
	'available_to_all_users_flag' => 'Available to<br>All Users',
	'global_admin_only_flag' => 'Global Admins Only',
	'purchased_function_flag' => 'Purchased Function',
	'customer_configurable_permissions_by_role_flag' => 'Customer Configurable Permissions<br>br Role',
	'customer_configurable_permissions_by_project_by_role_flag' => 'Customer Configurable Permissions<br>by Project<br>by Role',
	'customer_configurable_permissions_by_contact_flag' => 'Customer Configurable Permissions<br>by Contact',
	'project_specific_flag' => 'Project Specific',
);

$db = DBI::getInstance($database);

// Get all the software module functions for the currently selected software module.
$query =
"
SELECT smf.*
FROM `software_module_functions` smf
WHERE smf.`software_module_id` = ?
ORDER BY smf.`id`
";
$arrValues = array($software_module_id);
$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

$arrSoftwareModuleFunctions = array();
while ($row = $db->fetch()) {
	$software_module_function_id = $row['id'];
	$software_module_function_label = $row['software_module_function_label'];
	$arrSoftwareModuleFunctions[$software_module_function_id] = $software_module_function_label;

	foreach ($arrSoftwareModuleFunctionFlagsTmp as $softwareModuleFunctionFlag => $softwareModuleFunctionFlagLabel) {
		$softwareModuleFunctionFlagValue = $row[$softwareModuleFunctionFlag];
		if ($softwareModuleFunctionFlagValue == 'Y') {
			$softwareModuleFunctionFlagValue = 'checked';
		} else {
			$softwareModuleFunctionFlagValue = '';
		}
		$arrSoftwareModuleFunctionFlags[$software_module_function_id][$softwareModuleFunctionFlag] = $softwareModuleFunctionFlagValue;
	}
}
$db->free_result();


// Get all roles
/**
 * @todo Decide how we want to manage roles as far as project specific or not project specific etc.
 * contact_roles is the answer to that question
 * user_roles and contact_roles comprise the end-to-end permission system
 */
if ($userRole == "global_admin") {
	$query =
"
SELECT r.*
FROM `roles` r
WHERE r.`id` <> $AXIS_USER_ROLE_ID_GLOBAL_ADMIN AND r.`id` <> $AXIS_USER_ROLE_ID_ADMIN
ORDER BY r.`id`
";
} else {
	$query =
"
SELECT r.*
FROM `roles` r
WHERE r.`id` <> $AXIS_USER_ROLE_ID_GLOBAL_ADMIN AND r.`id` <> $AXIS_USER_ROLE_ID_ADMIN
ORDER BY r.`id`
";
}
$db->query($query);

$arrRoles = array();
while ($row = $db->fetch()) {
	$role_id = $row['id'];
	$role = $row['role'];
	$arrRoles[$role_id] = $role;
}

// Build $arrRolesToSoftwareModuleFunctions...a list of Software Module Functions (SMFs) by role_id (role)
// Now using `roles_to_software_module_function_templates` for the Global Admin Permissions module
$query =
"
SELECT *
FROM `roles_to_software_module_function_templates`
";
$db->query($query);

$arrRolesToSoftwareModuleFunctions = array();
while ($row = $db->fetch()) {
	$role_id = $row['role_id'];
	$software_module_function_id = $row['software_module_function_id'];
	$arrRolesToSoftwareModuleFunctions[$role_id][$software_module_function_id] = 1;
}
// Get all this users_user_company's contacts
$query =
"
SELECT c.*
FROM `contacts` c
WHERE c.`user_company_id` = $user_company_id
AND c.`first_name` <> ''
AND c.`last_name` <> ''
ORDER BY c.`first_name` ASC, c.`last_name` ASC
";
$db->query($query);

$arrContacts = array();
while ($row = $db->fetch()) {
	$contact_id = $row['id'];
	$arrContacts[$contact_id] = $row;
}

// Get any contacts that have been assigned access to any of this modules' functions
$query =
"
SELECT p2c2smf.*, c.*
FROM `projects_to_contacts_to_software_module_functions` p2c2smf, `software_module_functions` smf, `contacts` c
WHERE p2c2smf.`software_module_function_id` = smf.`id`
AND smf.`software_module_id` = ?
AND p2c2smf.`contact_id` = c.`id`
AND p2c2smf.`project_id` = ?
AND c.`user_company_id` = ?
ORDER BY c.`first_name` ASC, c.`last_name` ASC
";
$arrValues = array($software_module_id, $project_id, $user_company_id);
$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

$arrContactFunction = array();
$arrContactsWithPermissions = array();
while ($row = $db->fetch()) {
	$contact_id = $row['contact_id'];
	$arrContactsWithPermissions[$contact_id] = $row;

	$software_module_function_id = $row['software_module_function_id'];
	$arrContactFunction[$contact_id][$software_module_function_id] = 1;
}
$db->free_result();

$softwareModuleFunctionCount = count($arrSoftwareModuleFunctions);
$roleCount = count($arrRoles);
$softwareModuleFunctionFlagCount = count($arrSoftwareModuleFunctionFlagsTmp);

// START TO BUILD HTML
?>
<table border="1" cellpadding="5" cellspacing="0">
<tr>
<th>Software<br>Module<br>Function</th>
<th width="10"></th>
<th colspan="<?php echo $softwareModuleFunctionFlagCount; ?>">Per-Function Flag Settings (software_module_functions)</th>
<th width="10"></th>
<th colspan="<?php echo $roleCount; ?>">Default Permissions by Role (roles_to_software_module_function_templates)</th>
</tr>
<tr>
<th></th>
<?php

echo '<th width="10"></th>';

foreach ($arrSoftwareModuleFunctionFlagsTmp as $a => $b) {
	echo '<th width="100">'.$b.'</th>';
}

echo '<th width="10"></th>';

// Build and set the module functionality headers
foreach ($arrRoles as $role_id => $role) {
	echo '<th width="100">'.$role.'</th>';
}

?>
</tr>

<?php
// Loop through each software module function
foreach ($arrSoftwareModuleFunctions as $software_module_function_id => $software_module_function) {
	echo '<tr>';
	echo '<td><b>'.$software_module_function.'</b></td>';
	echo '<th width="10"></th>';

	// Loop through each software module function flag
	foreach ($arrSoftwareModuleFunctionFlagsTmp as $softwareModuleFunctionFlag => $softwareModuleFunctionFlagLabel) {
		if (isset($arrSoftwareModuleFunctionFlags[$software_module_function_id][$softwareModuleFunctionFlag])) {
			$softwareModuleFunctionFlagValue = $arrSoftwareModuleFunctionFlags[$software_module_function_id][$softwareModuleFunctionFlag];
			echo '<td id="td_'.$software_module_function_id.'_'.$softwareModuleFunctionFlag.'" style="text-align: center;">
					<input id="'.$software_module_function_id.'__'.$softwareModuleFunctionFlag.'__'.$softwareModuleFunctionFlagValue.'" type="checkbox" '.$softwareModuleFunctionFlagValue.' onclick="toggleSMFFlag(this.id);">
				  </td>';
		} else {
			echo '<td id="td_'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" style="text-align: center;">
					<input id="'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" type="checkbox" onclick="togglePermission(this.id);">
				  </td>';
		}
	}

	echo '<th width="10"></th>';

	// Loop through each role
	foreach ($arrRoles as $role_id => $role) {
		if (isset($arrRolesToSoftwareModuleFunctions[$role_id]) && isset($arrRolesToSoftwareModuleFunctions[$role_id][$software_module_function_id])) {
			echo '<td id="td_'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" style="text-align: center;">
					<input id="'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" type="checkbox" checked onclick="togglePermission(this.id);">
				  </td>';
		} else {
			echo '<td id="td_'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" style="text-align: center;">
					<input id="'.$user_company_id.'_0_'.$software_module_id.'_'.$project_id.'_'.$role_id.'_'.$software_module_function_id.'" type="checkbox" onclick="togglePermission(this.id);">
				  </td>';
		}
	}

	echo '</tr>';
}
echo '
	</table>
';

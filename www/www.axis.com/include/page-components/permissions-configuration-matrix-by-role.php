<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */
?>

<?php

// START TO BUILD HTML
?>
<table class="permissionTable" border="1" cellpadding="5" cellspacing="0">
<!--
	<tr>
<?php
	$softwareModule = SoftwareModule::findById($database, $software_module_id);
	$software_module_label = $softwareModule->software_module_label;

	if ($project_id == 0) {
		$permissionsHeadline = "Configure &ldquo;$encodedSoftwareModuleLabel&rdquo; System Permissions By Role";
?>
		<th colspan="<?php echo ($softwareModuleFunctionCount + 1); ?>">Customized Permissions by Role<br>(contacts_to_roles, roles_to_software_module_functions)<br>or<br>"Everyone / All Users"<br>(user_companies_to_all_contacts_to_software_module_functions)<br><br>Software Module Functions</th>

<?php
	} else {
		$permissionsHeadline = "Configure &ldquo;$encodedSoftwareModuleLabel&rdquo; Permissions By Role For &ldquo;$encodedProjectName&rdquo;";
?>
		<th colspan="<?php echo ($softwareModuleFunctionCount + 1); ?>">Customized Permissions by Project by Role<br>(projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions)<br>or<br>(user_companies_to_all_owned_projects_to_contacts_to_roles, user_companies_to_all_owned_projects_to_roles_to_software_module_functions)<br><br>Software Module Functions</th>
<?php }

	$colspan = $softwareModuleFunctionCount + 2;

	if (empty($arrRecommendedRoles)) {
		$filterByRecommendedRolesCheckbox = '';
	} else {
		$filterByRecommendedRolesCheckbox = 'checked';
	}
?>
	</tr>
 -->
 	<tr>
 		<th class="permissionTableMainHeader" colspan="<?php echo $colspan; ?>"><?php echo $permissionsHeadline;?></th>
 	</tr>

	<tr>
		<th id="thRoles" valign="middle">
			Roles<br>
			<input id="checkboxFilterRoles" type="checkbox" onclick="toggleFilterByRecommendedRoles();" <?php echo $filterByRecommendedRolesCheckbox;?>>
			<label for="checkboxFilterRoles">Filter by recommended roles</label>
		</th>
<?php

echo '<th class="thCheckAll" valign="middle">Toggle all</th>';
// Build and set the module functionality headers
foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $smf) {
	$headerStyle = "";
	if ($smf->show_in_navigation_flag == "N") {
		$headerStyle = ' style="background-color:grey;" title="This function does not cause this module to appear in the navigation"';
	} else {
		$headerStyle = ' title="This function causes this module to appear in the navigation."';
	}
	echo '
		<th class="permissionFunctionCell bs-tooltip"'.$headerStyle.' data-toggle="tooltip" data-placement="right" valign="middle">'.$smf->software_module_function_label.'</th>
	';
}

?>
	</tr>

<?php

// @todo Replace $recommendedRole logic with actual recommended roles.
//$recommendedRole = true;

// Loop through each role
foreach ($arrRoles as $role_id => $role) {
	/* @var $role Role */
	$role_name = $role->role;

	if (!empty($arrRecommendedRoles)) {
		if (isset($arrRecommendedRoles[$role_id])) {
			$nonRecommendedRoleClass = '';
		} else {
			$nonRecommendedRoleClass = 'nonRecommendedRole hidden';
		}
	} else {
		$nonRecommendedRoleClass = '';
	}

	/*
	$recommendedRole = !$recommendedRole;
	if ($recommendedRole) {
		$nonRecommendedRoleClass = '';
	} else {
		$nonRecommendedRoleClass = 'nonRecommendedRole hidden';
	}
	*/

	echo '<tr class="'.$nonRecommendedRoleClass.'"><td nowrap class="permissionFirstCell">'.$role_name.'</td>';
	echo '<td class="textAlignCenter"><input type="checkbox" onchange="toggleAllCheckboxesInRow(this);"></td>';

	// Loop through each software module function
	foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $smf) {
		/* @var $smf SoftwareModuleFunction */
		$smf->loadDependencies();
		$arrSoftwareModuleFunctionDependencies = $smf->getDependencies();
		if (isset($arrSoftwareModuleFunctionDependencies[$software_module_function_id])) {
			$arrTemp = $arrSoftwareModuleFunctionDependencies[$software_module_function_id];
			$dependenciesList = array_keys($arrTemp);
			$dependenciesList = join(",", $dependenciesList);
		} else {
			$dependenciesList = '';
		}
		$smf->loadPrerequisites();
		$arrSoftwareModuleFunctionPrerequisites = $smf->getPrerequisites();
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
		<td colspan="'.$colspan.'" class="loginForm">
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
echo '<td class="textAlignCenter"><input name="newContactPermissionCheckbox" type="checkbox" onchange="toggleAllCheckboxesInRowCus(this);" style="display:none;"></td>';
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
	echo '<td class="textAlignCenter"><input type="checkbox" onchange="toggleAllCheckboxesInRow(this);"></td>';
	// Loop through each module function
	foreach ($arrSoftwareModuleFunctionsBySoftwareModuleId as $software_module_function_id => $smf) {
			$smf->loadDependencies();
		$arrSoftwareModuleFunctionDependencies = $smf->getDependencies();
		if (isset($arrSoftwareModuleFunctionDependencies[$software_module_function_id])) {
			$arrTemp = $arrSoftwareModuleFunctionDependencies[$software_module_function_id];
			$dependenciesList = array_keys($arrTemp);
			$dependenciesList = join(",", $dependenciesList);
		} else {
			$dependenciesList = '';
		}
		$smf->loadPrerequisites();
		$arrSoftwareModuleFunctionPrerequisites = $smf->getPrerequisites();
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

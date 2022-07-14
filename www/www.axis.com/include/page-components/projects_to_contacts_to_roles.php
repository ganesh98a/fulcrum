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

/**
 * This page has three states:
 * 1) Show Nothing
 * 2) Read Only
 * 3) Allow Writes
 */

$htmlContent = '';
$encodedContactFullName = Data::entity_encode($fullName);

// Debug
$permissionsDisabled = '';

$htmlContent .= <<<END_HTML_CONTENT

<div class="contactSectionHeader">Project Access / Roles - <span id="contactProjectAccessHeaderContactName">$encodedContactFullName</span></div>
<table class="contactSectionTablepermission width100-per">
	<tr>
		<td>
END_HTML_CONTENT;

// Unassigned Projects Section
if (isset($arrUnassignedProjects) && !empty($arrUnassignedProjects) && ($userCanManageMyContactRoles || $userCanManageThirdPartyContactRoles)) {

	$htmlContent .= <<<END_HTML_CONTENT

			<table style="margin-bottom: 20px;">
				<tr>
					<td>
						<!--<label for="ddlUserCompanyProjects">Possible Projects</label>-->
						<select id="ddlUserCompanyProjects" name="ddlUserCompanyProjects" $permissionsDisabled>
						<option value="">Please Select A Project To Add</option>
END_HTML_CONTENT;

	foreach ($arrUnassignedProjects as $project_id => $project) {
		/* @var $project Project */

		$encodedProjectName = Data::entity_encode($project->project_name);
		$htmlContent .= <<<END_HTML_CONTENT

<option value="$project_id">$encodedProjectName</option>
END_HTML_CONTENT;

	}

	$htmlContent .= <<<END_HTML_CONTENT

						</select>
						<input id="btnAddUserToProject" name="btnAddUserToProject" type="button" value="Add $encodedContactFullName To This Project" onclick="addContactToProject('$contact_id');" $permissionsDisabled>
					</td>
				</tr>
			</table>
END_HTML_CONTENT;

}

$htmlContent .= <<<END_HTML_CONTENT

			<table border="0" width="100%" cellpadding="3">
END_HTML_CONTENT;

// Assigned Projects Section
if (isset($arrAssignedProjects) && !empty($arrAssignedProjects)) {

	$htmlContent .= <<<END_HTML_CONTENT

				<tr>
					<th style="text-align: left; border-bottom: 2px solid black; padding-right: 45px;">Assigned Projects &amp; Roles</th>
					<th style="text-align: left; border-bottom: 2px solid black;">
END_HTML_CONTENT;

	if (($userCanManageMyContactRoles || $userCanManageThirdPartyContactRoles)) {
		$htmlContent .= 'Role Options';
	} else {
		$htmlContent .= '&nbsp;';
	}

	$htmlContent .= <<<END_HTML_CONTENT

					</th>
				</tr>
END_HTML_CONTENT;

} else {

	// No Assigned Projects Section
	$htmlContent .= <<<END_HTML_CONTENT

				<tr style="border-top: 2px solid black;">
					<td colspan="2" style="padding-left:35px;">No Projects Assigned</td>
				</tr>
END_HTML_CONTENT;

}

// Assigned Projects Section
foreach ($arrAssignedProjects as $project_id => $project) {
	/* @var $project Project */

	$arrAssignedProjectRoles = $arrAssignedRolesByProjectId[$project_id];

	$arrUnassignedProjectRoles = array_diff($arrProjectRoles, $arrAssignedProjectRoles);

	$htmlContent .= <<<END_HTML_CONTENT

				<tr style="border-top: 2px solid black;">
					<td>
END_HTML_CONTENT;

	if (($userCanManageMyContactRoles || $userCanManageThirdPartyContactRoles)) {
		$htmlContent .= <<<END_HTML_CONTENT

						<a href="javascript:removeContactFromProject('$project_id', '$contact_id');" class="smallerFont">X</a>&nbsp;
END_HTML_CONTENT;
	}

	$upperCasedProjectName = strtoupper($project->project_name);
	$encodedUpperCasedProjectName = Data::entity_encode($upperCasedProjectName);

	$htmlContent .= <<<END_HTML_CONTENT

						$encodedUpperCasedProjectName
					</td>
					<td>
END_HTML_CONTENT;

	if (($userCanManageMyContactRoles || $userCanManageThirdPartyContactRoles)) {
		$htmlContent .= <<<END_HTML_CONTENT

						<select id="ddlRoleOptions_$project_id" name="ddlRoleOptions_$project_id" $permissionsDisabled>
						<option value="">Please Select A Role To Add</option>
END_HTML_CONTENT;

		foreach ($arrUnassignedProjectRoles as $role_id => $role) {
			$encodedRoleName = Data::entity_encode($role->role);
			$htmlContent .= <<<END_HTML_CONTENT
<option value="$role_id">$encodedRoleName</option>
END_HTML_CONTENT;
		}

		//<input id="btnAddRoleToContactOnProject_$project_id" name="btnAddRoleToContactOnProject_$project_id" type="button" value="Give $encodedContactFullName This Role On $project->project_name">
		$htmlContent .= <<<END_HTML_CONTENT

						</select>
						<input id="btnAddRoleToContactOnProject_$project_id" name="btnAddRoleToContactOnProject_$project_id" type="button" value="Add Role To Contact" onclick="addRoleToContactOnProject('$project_id', '$contact_id');"/>
END_HTML_CONTENT;

	}

	$htmlContent .= <<<END_HTML_CONTENT

					<td>
				</tr>
				<tr>
					<td></td>
					<td>
						<table id="tblContactRolesOnProject_$project_id" class="listTable">
END_HTML_CONTENT;

	foreach ($arrAssignedProjectRoles as $role_id => $role) {
		if ($role_id != 3) {
			$encodedRoleName = Data::entity_encode($role->role);

			$htmlContent .= <<<END_HTML_CONTENT

							<tr>
								<td>
END_HTML_CONTENT;

			if (($userCanManageMyContactRoles || $userCanManageThirdPartyContactRoles)) {
				$htmlContent .= <<<END_HTML_CONTENT

									<a href="javascript:removeRoleFromContactOnProject('$project_id', '$contact_id', '$role_id');">X</a>
END_HTML_CONTENT;
			}

			$htmlContent .= <<<END_HTML_CONTENT

								</td>
								<td>$encodedRoleName</td>
							</tr>
END_HTML_CONTENT;

		}
	}

	$htmlContent .= <<<END_HTML_CONTENT

						</table>
					</td>
				</tr>
END_HTML_CONTENT;

}

$htmlContent .= <<<END_HTML_CONTENT

			</table>
		</td>
	</tr>
</table>
END_HTML_CONTENT;

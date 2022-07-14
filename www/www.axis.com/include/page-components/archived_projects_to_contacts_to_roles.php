<?php

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

	$upperCasedProjectName = strtoupper($project->project_name);
	$encodedUpperCasedProjectName = Data::entity_encode($upperCasedProjectName);

	$htmlContent .= <<<END_HTML_CONTENT

						$encodedUpperCasedProjectName
					</td>
				
END_HTML_CONTENT;

	$htmlContent .= <<<END_HTML_CONTENT
					<td>
						<table id="tblContactRolesOnProject_$project_id" class="listTable">
END_HTML_CONTENT;

	foreach ($arrAssignedProjectRoles as $role_id => $role) {
		if ($role_id != 3) {
			$encodedRoleName = Data::entity_encode($role->role);

			$htmlContent .= <<<END_HTML_CONTENT

							<tr>
END_HTML_CONTENT;


			$htmlContent .= <<<END_HTML_CONTENT

								<td>- $encodedRoleName</td>
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

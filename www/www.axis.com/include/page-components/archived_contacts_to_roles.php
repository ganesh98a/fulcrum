<?php

$htmlContent = '';
$encodedContactFullName = Data::entity_encode($fullName);


$htmlContent .= <<<END_HTML_CONTENT
	<div class="contactSectionHeader">System Roles (Not Tied To Specific Projects) - <span id="contactRolesHeaderContactName">$encodedContactFullName</span></div>
		<table class="contactSectionTablepermission width100-per">
			<tr>
				<td>
					<table id="tblContactRoles_$contact_id" class="listTable">
END_HTML_CONTENT;

$contactHasRoles = false;
					foreach ($arrAssignedRolesByContactId as $role_id => $objContactRole) {

						$encodedRoleName = Data::entity_encode($objContactRole->role);

						if (($role_id == $AXIS_USER_ROLE_ID_USER) || ($role_id == $AXIS_USER_ROLE_ID_ADMIN) ||($role_id == $AXIS_USER_ROLE_ID_GLOBAL_ADMIN)) {
							continue;
						}

						if (isset($arrContactRoles[$role_id])) {
							$objContactRole = $arrContactRoles[$role_id];
							$contactHasRoles = true;
						} else {
							continue;
						}

$htmlContent .= <<<END_HTML_CONTENT
						<tr>
							<td>- $encodedRoleName</td>
						</tr>
END_HTML_CONTENT;
					}

if ($contactHasRoles == false) {

	$htmlContent .= <<<END_HTML_CONTENT
				<tr>
					<td>&nbsp;</td><td>No Contact (Non-Project Specific) Roles Assigned</td>
				</tr>
END_HTML_CONTENT;
}

$htmlContent .= <<<END_HTML_CONTENT
			</table>
		</td>
	</tr>
</table>
END_HTML_CONTENT;

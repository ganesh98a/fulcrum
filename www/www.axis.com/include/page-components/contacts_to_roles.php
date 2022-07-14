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

$adminFlag = $contact->isAdmin();
$contactIsAdmininstratorChecked = '';
if ($adminFlag) {
	$contactIsAdmininstratorChecked = 'checked';
}

$htmlContent .= <<<END_HTML_CONTENT

<div class="contactSectionHeader">System Roles (Not Tied To Specific Projects) - <span id="contactRolesHeaderContactName">$encodedContactFullName</span></div>
<table class="contactSectionTablepermission width100-per">
END_HTML_CONTENT;

// Only show the DDL select if the currently logged in user can manage roles
// @todo add check for my vs third party data cases and add the logic
if (isset($arrEligibleContactRoles) && !empty($arrEligibleContactRoles) && ($userCanManageMyContactRoles || $userCanManageThirdPartyContactRoles)) {

	// 1) Generate the DDL <select> for: assignment of NEW "Eligible Contact Roles"
	$dummyId = Data::generateDummyPrimaryKey();

	$htmlContent .= <<<END_HTML_CONTENT

	<tr>
		<td>
			<input id="create-contact_to_role-record--contacts_to_roles--contact_id--$dummyId" type="hidden" value="$contact_id">
			<input id="create-contact_to_role-record--contacts_to_roles--role_id--$dummyId" type="hidden" value="">
			<select id="ddl--create-contact_to_role-record--contacts_to_roles--role_id--$dummyId" onchange="ddlOnChange_UpdateHiddenInputValue(this, 'create-contact_to_role-record--contacts_to_roles--role_id--$dummyId');">
				<option value="">Please Select A Role To Add</option>
END_HTML_CONTENT;

	foreach ($arrEligibleContactRoles as $role_id) {
		$objContactRole = $arrContactRoles[$role_id];
		/* @var $objContactRole Role */

		$encodedRoleName = Data::entity_encode($objContactRole->role);
		$htmlContent .= <<<END_HTML_CONTENT

				<option value="$role_id">$encodedRoleName</option>
END_HTML_CONTENT;
	}

	$htmlContent .= <<<END_HTML_CONTENT

			</select>
			<input id="btnAddRoleToContact" name="btnAddRoleToContact" type="button" value="Add Role To This Contact" onclick="Contacts_Manager__createContactToRole('create-contact_to_role-record', '$dummyId');">
END_HTML_CONTENT;

	if ($userRole == 'admin') {
		if ($primary_contact_id != $contact_id) {

			$htmlContent .= <<<END_HTML_CONTENT
<input id="chkIsAdmin" name="chkIsAdmin" type="checkbox" $contactIsAdmininstratorChecked value="1" style="margin-left:50px;" onclick="toggleAdministrator('$contact_id');"> Administrator
END_HTML_CONTENT;

		} else {

			$htmlContent .= <<<END_HTML_CONTENT
<input id="chkIsAdmin" name="chkIsAdmin" type="checkbox" $contactIsAdmininstratorChecked value="1" style="margin-left:50px;" disabled> Administrator
END_HTML_CONTENT;

		}
	}

	$htmlContent .= <<<END_HTML_CONTENT

		</td>
	</tr>
END_HTML_CONTENT;

}

$htmlContent .= <<<END_HTML_CONTENT

	<tr>
		<td>
			<table id="tblContactRoles_$contact_id" class="listTable">
END_HTML_CONTENT;

$contactHasRoles = false;
foreach ($arrAssignedRolesByContactId as $role_id => $objContactRole) {
	/* @var $objContactRole Role */

	$encodedRoleName = Data::entity_encode($objContactRole->role);

	// Skip user access roles and admin as a separate checkbox is used
	// Global Admin is assigned via users from the Global Admin Manager
	if (($role_id == $AXIS_USER_ROLE_ID_USER) || ($role_id == $AXIS_USER_ROLE_ID_ADMIN) ||($role_id == $AXIS_USER_ROLE_ID_GLOBAL_ADMIN)) {
		continue;
	}

	if (isset($arrContactRoles[$role_id])) {
		$objContactRole = $arrContactRoles[$role_id];
		/* @var $objContactRole Role */
		$contactHasRoles = true;
	} else {
		// Bug - role data does not exist in the array of contact roles
		continue;
	}

	$htmlContent .= <<<END_HTML_CONTENT

				<tr>
					<td>
END_HTML_CONTENT;

	// @todo add check for my vs third party data cases and add the logic
	if ($userCanManageMyContactRoles || $userCanManageThirdPartyContactRoles) {

		$htmlContent .= <<<END_HTML_CONTENT
						<a href="javascript:removeRoleFromContact('$contact_id', '$role_id');">X</a>
END_HTML_CONTENT;

	} else {

		$htmlContent .= '&nbsp;';

	}

	$htmlContent .= <<<END_HTML_CONTENT

					</td>
					<td>$encodedRoleName</td>
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

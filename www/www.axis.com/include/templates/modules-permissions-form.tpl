
{*
<select id="ddlSoftwareModules" name="ddlSoftwareModules" onchange="softwareModuleChanged();">
{foreach $arrSoftwareModuleList as $row}
	<option value="{$row.software_module_id}">{$row.software_module}</option>
{/foreach}
</select><br><br>
*}
{include file="dropdown-software-modules-list.tpl"}

{*<br><br>*}
{include file="dropdown-projects-list.tpl"}
<input id="btnReloadPermissionsData" type="button" value="Refresh Permissions Data" onclick="softwareModuleChanged();">
<input id="btnResetPermissions" type="button" value="Reset To System Default Permissions" onclick="resetDefaultPermissions();" {$btnResetStyleParam}>
{*Clone Permission from Project: <select></select>*}
<br><br>
<div id="divAddTeamMembers">
{php}

// Debug.
$user_can_manage_team_members = true;
if ($user_can_manage_team_members) {
	echo '
<table class="permissionTable table-team-members">
	<tr>
		<th class="permissionTableMainHeader">Add New Team Members</th>
	</tr>
	<tr>
		<td>
			<table class="table-contact-roles" width="100%">
				<tr>
					<td id="teamManagement" class="contact-search-parent-container">
	';
}
{/php}
	{$permissionsSearchForm}
{php}
$user_can_manage_team_members = true;
if ($user_can_manage_team_members) {
	echo '
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
	';
}

{/php}
</div>
<div id="divPermissionsAssignmentsByContact"></div>
<div id="divPermissionsMatrix"></div>
<div class="divTabs">
	<ul>
		<li><a id="teamTab" class="tab {$teamSelected}" onclick="tabClicked(this, '1');">Team</a></li>
		<li><a id="subcontractorsTab" class="tab {$subcontractorsSelected}" onclick="tabClicked(this, '2');">Subcontractors</a></li>
		<li><a id="biddersTab" class="tab {$biddersSelected}" onclick="tabClicked(this, '3');">Bidders</a></li>		
	</ul>
</div>
<div id="divProjectContactList"></div>
<input type="hidden" id="activeTab" value="{$activeTab}">


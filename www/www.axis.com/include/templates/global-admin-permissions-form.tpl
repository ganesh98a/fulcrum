
{*
<select id="ddlSoftwareModules" name="ddlSoftwareModules" onchange="softwareModuleChanged();">
{foreach $arrSoftwareModuleList as $row}
	<option value="{$row.software_module_id}">{$row.software_module}</option>
{/foreach}
</select><br><br>
*}

{include file="dropdown-software-modules-list.tpl"}

<input id="btnResetPermissions" type="button" value="Reset To System Default Permissions" onclick="resetDefaultPermissions();" {$btnResetStyleParam}>
<br><br>
{include file="dropdown-projects-list.tpl"}
<br><br>
<div id="divPermissionsMatrix"></div>
<br>
<br>

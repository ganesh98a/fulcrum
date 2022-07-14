<form name="frm_create_profile" action="admin-user-creation-form-submit.php{$queryString}" method="post" enctype="multipart/form-data">

<table border="0" cellpadding="3" cellspacing="0" height="73" width="100%">

<tr>
<td height="20"><div class="headerStyle">Manage Users &mdash; Create/Edit a User</div></td>
</tr>

<tr>
<td height="20">
<br>
<input type="button" value="Create A New Registered User" onclick="window.location='admin-user-creation-form-reset.php{$createUserQueryString}'">
<br>
<br>
{include file="dropdown-user-list.tpl"}
<noscript>
<input type="button" value="Edit An Existing User" onclick="userRedirect(this.form, 'admin-user-creation-form-reset.php');">
</noscript>
<br>
<br>
</td>
</tr>

<tr>
<td>

	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{/if}

	{include file="admin-user-security-information-form-inputs.tpl"}

	<br>
	<br>

	{include file="admin-user-details-form-inputs.tpl"}

	<br>
	<div align="left">
	<input type="reset" value="    Reset Form    " name="Submit" tabindex="3002" onclick="window.location='admin-user-creation-form-reset.php{$queryString}'">
	&nbsp;&nbsp;
	<input type="submit" value="       Save       " name="Submit" tabindex="3001">
	</div>

	{*
	<br>
	<div align="right">
	By clicking “Create User” you confirm that you accept the <a href="/terms-and-conditions.php" tabindex="3000">Terms of Service</a>.
	<br>
	<br>
	<input type="reset" value="    Reset Form    " name="Submit" tabindex="3002" onclick="window.location='admin-user-creation-form-reset.php{$queryString}'">&nbsp;&nbsp;<input type="submit" value="       Create User       " name="Submit" tabindex="3001">
	</div>
	*}

</td>
</tr>

</table>
</form>

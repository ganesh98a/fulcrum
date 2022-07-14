<form name="frm_create_profile" action="admin-user-company-creation-form-submit.php{$queryString}" method="post" enctype="multipart/form-data">
{*<input type="hidden" name="user_company_id" value="{$user_company_id}">*}

<table border="0" cellpadding="3" cellspacing="0" height="73" width="100%">

<tr>
<td height="20"><div class="headerStyle">Manage Customers &mdash; Create/Edit a Customer (User Company)</div></td>
</tr>

<tr>
<td height="20">
<br>
<input type="button" value="Create A New Registered Company (User Company)" onclick="window.location='admin-user-company-creation-form-reset.php{$createUserCompanyQueryString}'">
<br>
<br>
{include file="dropdown-user-company-list.tpl"}
<noscript>
<input type="button" value="Edit An Existing Customer (User Company)" onclick="userCompanyRedirect(this.form, 'admin-user-company-creation-form-reset.php');">
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

	{include file="admin-user-company-information-form-inputs.tpl"}

	<br>
	<div align="left">
	<input type="reset" value="    Reset Form    " name="Submit" tabindex="3002" onclick="window.location='admin-user-company-creation-form-reset.php{$queryString}'">
	&nbsp;&nbsp;
	<input type="submit" value="       Save       " name="Submit" tabindex="3001">
	</div>
</td>
</tr>

</table>
</form>
{$fineUploaderTemplate}
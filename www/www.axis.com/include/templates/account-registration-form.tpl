<form name="frm_create_profile" action="account-registration-form-submit.php{$queryString}" method="post" enctype="multipart/form-data">
<input type="hidden" name="user_invitation_guid" value="{$user_invitation_guid}">
<input type="hidden" name="user_company_id" value="{$user_company_id}">

<table border="0" cellpadding="3" cellspacing="0" height="73" width="100%">

<tr>
<td height="20"><div class="headerStyle">Register Your Fulcrum Account</div></td>
</tr>

<tr>
<td>

	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{/if}

	{include file="account-registration-security-information-form-inputs.tpl"}

	<br>
	<br>

	{include file="account-registration-user-details-form-inputs.tpl"}

	<br>
	<div align="right">
	By clicking “Register” you confirm that you accept the <a href="/terms-and-conditions.php" tabindex="3000">Terms of Service</a>.
	<br>
	<br>
	<input type="reset" value="    Reset Form    " name="Submit" tabindex="3002" onclick="window.location='admin-user-creation-form-reset.php{$queryString}'">&nbsp;&nbsp;<input type="submit" value="       Register       " name="Submit" tabindex="3001">
	</div>
</td>
</tr>

</table>
</form>

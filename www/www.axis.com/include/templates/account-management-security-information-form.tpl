
<div class="headerStyle">Account Management - Required Login &amp; Security Information</div>

{if (isset($htmlMessages)) && !empty($htmlMessages) }
	<div style="margin-top:5px;">{$htmlMessages}</div>
{/if}

{if isset($hideForm) && $hideForm}
<input value="Click Here to Try Updating Your Security Information Again" type="button" onclick="window.location='{$startOverUrl}';">
{else}
<form name="frm_account_management_security_information" action="account-management-security-information-form-submit.php" method="post">
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td>
<div align="left">If you need to change the security information on your account, follow these steps:
<ol class="instructionsList" type="i">
<li>Change your information as desired by editing the fields below.</li>
{*<li>Enter your password for authentication.</li>*}
<li>Click &ldquo;Save Changes&rdquo;.</li>
</ol>
</div>
</td>
</tr>
<tr>
<td align="left" width="100%">

	{include file="security-information-form-inputs.tpl"}

	{*
	<br>

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 0px #ccc;">
	<tr>
	<td colspan="2"><strong>You Are Currently Logged In As &mdash; <i>{$loginName}</i></strong></td>
	</tr>

	<tr>
	<td width="10%" nowrap>Enter Current Password</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td><input id="first_element" type="password" name="currentPassword" value="{$currentPassword}" maxlength="30" size="25" tabindex="110" style="width:200px;"></td>
		<td>&nbsp;(required for authentication)</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
	*}

	<br>
	<input type="reset" value="    Reset Form    " name="Submit1" tabindex="22" onclick="window.location='account-management-security-information-form-reset.php'">&nbsp;|&nbsp;<input type="submit" value="   Save Changes   " name="Submit2" tabindex="21">

</td>
</tr>
</table>
</form>
{/if}

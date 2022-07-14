<form name="frm_pass_update" action="account-management-password-form-submit.php" method="post">
<table border="0" cellpadding="3" cellspacing="0" width="100%">

{*
<tr>
<td height="20" width="100%"><div class="headerStyle">Account Management - Change Your Password</div></td>
</tr>

<tr>
<td height="20" width="100%"></td>
</tr>
*}

{if (isset($htmlMessages)) && !empty($htmlMessages) }
	<tr><td nowrap><br>{$htmlMessages}</td></tr>
{/if}

<tr>
<td align="left">
{if isset($hideForm) && $hideForm}
	<input value="Click Here To Update Your Password Again" type="button" onclick="window.location='{$startOverUrl}';">
{else}
	<div class="headerStyle">Note: passwords are stored in a secure, one-way encrypted format.</div>
	<table cellSpacing="2" cellPadding="1" width="947">
	<tr>
	<td nowrap align="left" width="30%">Enter your current password</td>
	<td align="left" width="70%"><input {$currentPasswordDocumentId} tabindex="500" type="password" maxlength="30" size="33" name="auth_pass" value="{$currentPassword}">&nbsp;(required for authentication)</td>
	</tr>
	<tr>
	<td nowrap align="left" width="30%">Enter your new password</td>
	<td align="left" width="70%"><input {$newPasswordDocumentId} type="password" tabindex="501" maxlength="30" size="33" name="new_pass1" value="{$newPassword1}"></td>
	</tr>
	<tr>
	<td nowrap align="left" width="30%">Re-enter your new password</td>
	<td align="left" width="70%"><input type="password" tabindex="502" maxlength="30" size="33" name="new_pass2" value="{$newPassword2}">
	</td>
	</tr>
	<tr>
	<td nowrap align="right" width="30%" height="49"><input tabindex="504" class="button" onclick="window.location='account-management-password-form-reset.php'" type="button" value="Reset Form">&nbsp;&nbsp;</td>
	<td align="left" width="70%" height="49"><input tabindex="503" class="button" type="submit" value="Change Password" name="submit">
	</td>
	</tr>
	</table>
{/if}
</td>
</tr>

</table>
</form>



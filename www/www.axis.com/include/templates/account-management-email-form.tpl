
<div class="headerStyle">Account Management - Change Your Email Address</div>

{if (isset($htmlMessages)) && !empty($htmlMessages) }
	<div>{$htmlMessages}</div>
{/if}

{if isset($hideForm) && $hideForm}
<br>
<input value="Click Here to Try Updating Your Email Address Again" type="button" onclick="window.location='{$startOverUrl}';">
{else}
<form name="frm_email_update" action="account-management-email-form-submit.php" method="post">
<input type="hidden" name="currentEmail" value="{$email}">
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td>
<div align="left">If you need to change the email address on your account, follow these steps:
<ol class="instructionsList" type="i">
<li>Your current email address is shown below.</li>
<li>Change your email address by editing the fields below.</li>
<li>Enter your password for authentication.</li>
<li>Click &ldquo;Save Changes&rdquo;.</li>
</ol>
</div>
</td>
</tr>

<tr>
<td align="left">

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
	<tr>
	<td colspan="2"><strong>Update Your Email Address Below</strong></td>
	</tr>

	<tr>
	<td width="10%" nowrap>Enter Your New Email Address</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td width="10%"><input type="email" tabindex="101" maxlength="30" size="33" name="new_email1" value="{$new_email1}"></td>
		<td>&nbsp;</td>
		</tr>
		</table>
	</td>
	</tr>

	<tr>
	<td width="10%" nowrap>Re-enter Your New Email Address</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td width="10%"><input type="email" tabindex="101" maxlength="30" size="33" name="new_email2" value="{$new_email2}"></td>
		<td>&nbsp;</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>

	<br>

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
	<tr>
	<td colspan="2"><strong>Your current email address is: <i>{$email}</i></strong></td>
	</tr>

	<tr>
	<td width="10%" nowrap>Enter Current Password</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td><input id="first_element" tabindex="100" type="password" name="currentPassword" value="{$currentPassword}" maxlength="30" size="25" style="width:200px;"></td>
		<td>&nbsp;(required for authentication)</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>

	<div align="left">
	<br>
	<input type="reset" value="    Reset Form    " name="Reset" tabindex="3002" onclick="window.location='account-management-email-form-reset.php'">&nbsp;|&nbsp;<input class="button" type="submit" value="   Change Email   " name="Submit" tabindex="3001">
	</div>

</td>
</tr>
</table>
</form>
{/if}

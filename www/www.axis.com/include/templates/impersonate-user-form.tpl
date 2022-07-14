
<form id="frm_impersonate" name="frm_impersonate" action="/impersonate-users-form-submit.php" method="post">
<input type="hidden" name="currentEmail" value="{$email}">
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td width="100%" height="20">
<div class="headerStyle">User Impersonation</div>
<br>
</td>
</tr>

<tr>
<td align="left">

	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}<div>
	{/if}

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 0px #ccc;">
	<tr>
	<td colspan="2"><strong>You are currently logged in as: <i>{$email}</i></strong></td>
	</tr>

	{*
	<tr>
	<td width="10%" nowrap>Enter Current Password</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td><input id="first_element" tabindex="100" type="password" name="currentPassword" value="{$currentPassword}" maxlength="14" size="25" style="width:200px;"></td>
		<td>&nbsp;(required for authentication)</td>
		</tr>
		</table>
	</td>
	</tr>
	*}
	</table>

	<br>

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
	<tr>
	<td colspan="2">{include file="form-user-impersonation.tpl"}</td>
	</tr>
	</table>

	{*
	<div align="right">
	<br>
	<input type="reset" value="    Reset Form    " name="Reset" tabindex="3002" onclick="window.location='impersonate-users-form-reset.php'">&nbsp;|&nbsp;<input class="button" type="submit" value="   Impersonate User   " name="Submit" tabindex="3001">
	</div>
	*}

</td>
</tr>
</table>
</form>

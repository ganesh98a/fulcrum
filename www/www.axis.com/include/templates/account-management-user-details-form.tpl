
<form name="frm_account_update" action="account-management-user-details-form-submit.php" method="post" enctype="multipart/form-data">
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td width="100%" height="20"><div class="headerStyle">Account Management - Optional Personal Information</div></td>
</tr>
<tr>
<td>
<div align="left">If you need to change the personal information on your account, follow these steps:
<ol type="i">
<li>Input your password into the text box below for authentication.</li>
<li>Your current information is show in the form fields below.</li>
<li>To change any information, simply change the information in the form fields and click Save Changes.</li>
</ol>
</div>
</td>
</tr>
<tr>
<td align="left" width="100%">

	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{/if}

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
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

	<br>
	<br>

	{include file="user-details-form-inputs.tpl"}

	<div align="right">
	<br>
	<input type="reset" value="    Reset Form    " name="Reset" tabindex="3002" onclick="window.location='account-management-user-details-form-reset.php'">&nbsp;|&nbsp;<input type="submit" value="   Save Changes   " name="Submit" tabindex="3001">
	</div>

</td>
</tr>
</table>
</form>

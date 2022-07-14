<form name="frm_validate_ein" action="account-registration-form-step2-submit.php{$queryString}" method="post">
<input type="hidden" name="user_invitation_guid" value="{$user_invitation_guid}">
<input type="hidden" name="registrationStep" value="step2">

<table border="0" cellpadding="3" cellspacing="0" height="73" width="100%">

<tr>
<td height="20"><div class="headerStyle">Please Enter Your Companies Federal Tax ID (EIN/FEIN/SSN) </div></td>
</tr>
  <tr><td><div style="font-size:70%;">Note: Tax ID is used by the contractor when cutting payment checks to you on a project. Please ensure accuracy.</div></td></tr>

<tr>
<td>

	{if (isset($htmlMessages)) && !empty($htmlMessages) }
		<div>{$htmlMessages}</div>
	{/if}

	<input id="first_element" type="text" name="ein" value="{$ein}">

	<input type="submit" value="Submit" name="Submit" tabindex="3">
</td>
</tr>

<tr>
<td class="loginForm">
<a href="javascript:history.back();" style="font-size:70%;">Already Have A Fulcrum Account?</a>
</td>
</tr>

</table>
</form>

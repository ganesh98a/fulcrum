
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">

{if !isset($hideForm) || $hideForm == 0}
<tr>
<td>
<div class="forgotPasswordBody">
If you have forgotten your Password, follow these steps:
<ol type="i">
<li>Enter your login email address below.
<li>Follow the instructions of the e-mail that you receive.</li>
</ol>
</div>
</td>
</tr>
{/if}

<tr>
<td>
	{if (isset($htmlMessages) && !empty($htmlMessages)) }
		<div>{$htmlMessages}</div>
	{/if}
	{if isset($hideForm) && $hideForm}
		{*<a href="/login-form.php">Login To Your Account</a>*}
		<input value="Login To Your Account" type="button" onclick="window.location='/login-form.php';">
		<br>
		<br>
		<input value="Click Here to Try Resetting Your Password Again" type="button" onclick="window.location='{$startOverUrl}';">
	{else}
		{include file="password-retrieval-form-inputs-web.tpl"}
	{/if}
</td>
</tr>

</table>

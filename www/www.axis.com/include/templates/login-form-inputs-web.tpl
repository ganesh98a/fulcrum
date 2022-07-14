
<form action="login-form-submit.php{$queryString}" method="post" name="frm_login">
<table class="loginForm">

<tr>
	<td align="right" class="formInputLabel">Username:</td>
	<td>
		<input id="first_element" class="loginFormInput" maxlength="50" name="auth_name" size="30" tabindex="101" type="email" value="{$username}">
	</td>
</tr>

<tr>
	<td align="right" class="formInputLabel">Password:</td>
	<td>
		<input class="loginFormInput" maxlength="20" name="auth_pass" size="30" tabindex="102" type="password" value="{$password}">
	</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>
<a href="password-retrieval-form.php" tabindex="104">Forgot Password?</a>
</td>
</tr>

<tr>
<td></td>
<td align="left">
<input tabindex="103" type="submit" value="LOGIN" name="auth_login" class="formInputSubmit">
</td>
</tr>

</table>
</form>

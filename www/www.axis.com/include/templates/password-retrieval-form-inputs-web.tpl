
<form action="password-retrieval-form-submit.php{$queryString}" method="post" name="frm_forgot_password">
<table class="loginForm">

<tr>
<td nowrap align="left" class="formInputLabel">Login Email Address:</td>
<td align="left"><input autofocus id="first_element" class="loginFormInput" maxlength="50" name="auth_name" size="33" type="email" value="{$username}"></td>
</tr>

<tr>
<td class="captcha" align="center" colspan="2">
<table>
<tr>
<td width="99%">{$captcha}</td>
{*<td width="1%"><img onclick="document.location.reload(true);" src="/images/icons/reload-gray.png"></td>*}
<td width="1%"><img onclick="refreshCaptcha();" src="/images/icons/reload-gray.png"></td>
</tr>
</table>
</td>
</tr>

<tr>
<td nowrap align="left" class="formInputLabel">Please input the above text:</td>
<td align="left"><input class="loginFormInput" maxlength="30" name="captcha_input" size="33" type="text"></td>
</tr>

<tr>
<td></td>
<td nowrap align="right">
<input class="button formInputSubmit" type="submit" value="Retrieve Password" name="Submit">
{*<input class="button formInputSubmit" src="/images/buttons/retrieve-password-button.gif" type="image" name="Submit">*}
</td>
</tr>

</table>
</form>

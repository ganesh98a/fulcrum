{if isset($loginErrors) && $loginErrors}
	<table id="tblLogin" border="0" cellpadding="3" cellspacing="0" width="100%">
{else}
	<table id="tblLogin" border="0" cellpadding="3" cellspacing="0" width="100%" style="display:none;">
{/if}
	<tr>
		<td>
			{if (isset($htmlMessages)) && !empty($htmlMessages) }
				<div>{$htmlMessages}</div>
			{/if}
		</td>
	</tr>
	<tr>
		<td width="49%">
			<!--Already a Fulcrum User? Sign In Below<br><br>-->
			<form name="frm_auth" action="login-form-submit.php{$queryString}" method="post">
				<input type="hidden" name="user_invitation_guid" value="{$user_invitation_guid}">
				<input type="hidden" name="user_company_id" value="{$user_company_id}">
				<table class="loginForm">
					{if (!isset($user_invitation_guid) || empty($user_invitation_guid)) }
						<tr>
							<td align="right" class="formInputLabel">Email Invitation Code:</td>
							<td>
								<input id="guid" tabindex="1" type="email" size="50" maxlength="50" name="guid" value="{$user_invitation_guid}" class="loginFormInput">
							</td>
						</tr>
					{/if}
					<tr>
						<td align="left" class="formInputLabel">Username:</td>
						<td>
							<input id="first_element" tabindex="2" type="email" size="30" maxlength="50" name="auth_name" value="{$email}" class="loginFormInput">
						</td>
					</tr>
					<tr>
						<td align="right" class="formInputLabel">Password:</td>
						<td>
							<input tabindex="3" type="password" size="30" maxlength="30" name="auth_pass" value="{$password}" class="loginFormInput">
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><a href="password-retrieval-form.php" style="font-size:70%;">Forgot Password?</a></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><a href="{$accountRegistrationStep}" style="font-size:70%;">Need To Register?</a></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<input tabindex="4" type="submit" value="LOGIN" name="auth_login" class="formInputSubmit">
						</td>
					</tr>
				</table>
			</form>
		</td>
		{*
		<td width="49%" style="border: solid 1px #000;">
			New To Fulcrum? Click the button below to Register<br><br>
			<button tabindex="5" onclick="location='{$accountRegistrationStep}'" name="register" style="margin-top:5px;">REGISTER</button>
		</td>
		*}
	</tr>
</table>



{if isset($loginErrors) && $loginErrors}
	<table id="tblNewAccountOptions" width="100%" style="margin-top:40px; display:none;">
{else}
	<table id="tblNewAccountOptions" width="100%" style="margin-top:40px;">
{/if}
	<tr>
		<td align="center" width="49%">
			<input type="button" value="I HAVE A FULCRUM ACCOUNT" style="padding:20px; font-size:16px; width:360px;" onclick="document.getElementById('tblLogin').style.display='block';document.getElementById('tblNewAccountOptions').style.display='none';">
		</td>
		<td align="center" width="49%">
			<input type="button" value="REGISTER A NEW ACCOUNT" style="padding:20px; font-size:16px; width:360px;" onclick="location='{$accountRegistrationStep}'">
		</td>
	</tr>
</table>
</form>

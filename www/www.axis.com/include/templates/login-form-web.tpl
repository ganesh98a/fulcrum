<!-- 

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">

	<tr>
		<td align="center"><img src="/images/home/splash-page-axis-logo-white.gif" width="288"></td>
		<td rowspan="2">&nbsp;</td>
	</tr>

	<tr>
		<td align="center" valign="middle" style="padding-top:80px; padding-right: 10px;">
			{if (isset($htmlMessages) && !empty($htmlMessages)) }
				<div class="loginFormMessageContainer">{$htmlMessages}</div>
			{/if}
			{include file="login-form-inputs-web.tpl"}
		</td>
		<td>&nbsp;</td>
	</tr>
</table> -->

<link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700" rel="stylesheet">

 <div class="background"></div>
  <div class="background2"></div>
    <div class="login-form-sec"> 
    <hgroup>
      <h1><a href="/"><img src="/images/home/splash-page-axis-logo-white.gif" style="max-width:100%;"></a></h1>
    </hgroup>
	<h2>Login</h2>
    <form action="login-form-submit.php{$queryString}" method="post" name="frm_login">
      {if (isset($htmlMessagesGeneraic) && !empty($htmlMessagesGeneraic)) }
       <div class="error generic-error">{$htmlMessagesGeneraic}</div>   
       {/if}
      {if (isset($htmlMessagesGeneraicSuccess) && !empty($htmlMessagesGeneraicSuccess)) }
       <div class="generic-success">{$htmlMessagesGeneraicSuccess}</div>   
       {/if}
      <div class="group">        
		<input id="first_element" class="loginFormInput" maxlength="50" name="auth_name" size="30" tabindex="101" type="email" value="{$username}">
		<span class="highlight"></span><span class="bar"></span>
        <label>Username</label>
        {if (isset($htmlMessagesUsername) && !empty($htmlMessagesUsername)) }
		<span class="error tooltip-msg" data-tooltip="Please enter a valid Username"></span>
		{/if}
      </div>
      <div class="group m-0">
		<input class="loginFormInput" maxlength="30" name="auth_pass" size="30" tabindex="102" type="password" value="{$password}">
		<span class="highlight"></span><span class="bar"></span>
        <label>Password</label>
        {if (isset($htmlMessagesPassword) && !empty($htmlMessagesPassword)) }
		<span class="error tooltip-msg" data-tooltip="Please enter a valid Password."></span>
		{/if}
      </div>   
	  <div class="forgot">
	   <a href="password-retrieval-form.php" tabindex="104">Forgot Password?</a>   
	  </div>
	  <input tabindex="103" type="submit" value="Login" name="auth_login" class="buttonui"> 
    </form>
	<div class="powered">
		<a href="/">&copy;2017 MyFulcrum.com&trade;</a>
		<a href="/login-form.php">Login</a>
		<a href="/account.php">Account</a>
      </div>
  </div>


<style>

body {
    background: #ebebeb;
    -webkit-font-smoothing: antialiased;
}
#footer
{
    display:none;
}
</style>






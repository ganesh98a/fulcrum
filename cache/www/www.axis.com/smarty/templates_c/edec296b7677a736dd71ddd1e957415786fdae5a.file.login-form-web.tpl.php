<?php /* Smarty version Smarty-3.0.8, created on 2022-07-11 10:06:57
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/login-form-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2660662cbda21e07904-05175745%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edec296b7677a736dd71ddd1e957415786fdae5a' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/login-form-web.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2660662cbda21e07904-05175745',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!-- 

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">

	<tr>
		<td align="center"><img src="/images/home/splash-page-axis-logo-white.gif" width="288"></td>
		<td rowspan="2">&nbsp;</td>
	</tr>

	<tr>
		<td align="center" valign="middle" style="padding-top:80px; padding-right: 10px;">
			<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))){?>
				<div class="loginFormMessageContainer"><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
			<?php }?>
			<?php $_template = new Smarty_Internal_Template("login-form-inputs-web.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
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
    <form action="login-form-submit.php<?php echo $_smarty_tpl->getVariable('queryString')->value;?>
" method="post" name="frm_login">
      <?php if ((isset($_smarty_tpl->getVariable('htmlMessagesGeneraic',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlMessagesGeneraic',null,true,false)->value))){?>
       <div class="error generic-error"><?php echo $_smarty_tpl->getVariable('htmlMessagesGeneraic')->value;?>
</div>   
       <?php }?>
      <?php if ((isset($_smarty_tpl->getVariable('htmlMessagesGeneraicSuccess',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlMessagesGeneraicSuccess',null,true,false)->value))){?>
       <div class="generic-success"><?php echo $_smarty_tpl->getVariable('htmlMessagesGeneraicSuccess')->value;?>
</div>   
       <?php }?>
      <div class="group">        
		<input id="first_element" class="loginFormInput" maxlength="50" name="auth_name" size="30" tabindex="101" type="email" value="<?php echo $_smarty_tpl->getVariable('username')->value;?>
">
		<span class="highlight"></span><span class="bar"></span>
        <label>Username</label>
        <?php if ((isset($_smarty_tpl->getVariable('htmlMessagesUsername',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlMessagesUsername',null,true,false)->value))){?>
		<span class="error tooltip-msg" data-tooltip="Please enter a valid Username"></span>
		<?php }?>
      </div>
      <div class="group m-0">
		<input class="loginFormInput" maxlength="30" name="auth_pass" size="30" tabindex="102" type="password" value="<?php echo $_smarty_tpl->getVariable('password')->value;?>
">
		<span class="highlight"></span><span class="bar"></span>
        <label>Password</label>
        <?php if ((isset($_smarty_tpl->getVariable('htmlMessagesPassword',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlMessagesPassword',null,true,false)->value))){?>
		<span class="error tooltip-msg" data-tooltip="Please enter a valid Password."></span>
		<?php }?>
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






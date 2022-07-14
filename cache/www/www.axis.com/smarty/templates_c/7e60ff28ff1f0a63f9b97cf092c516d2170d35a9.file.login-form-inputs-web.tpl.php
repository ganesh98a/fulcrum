<?php /* Smarty version Smarty-3.0.8, created on 2017-06-19 18:25:28
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/login-form-inputs-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4993334795947c9c0ba0687-57913762%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e60ff28ff1f0a63f9b97cf092c516d2170d35a9' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/login-form-inputs-web.tpl',
      1 => 1450949886,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4993334795947c9c0ba0687-57913762',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<form action="login-form-submit.php<?php echo $_smarty_tpl->getVariable('queryString')->value;?>
" method="post" name="frm_login">
<table class="loginForm">

<tr>
	<td align="right" class="formInputLabel">Username:</td>
	<td>
		<input id="first_element" class="loginFormInput" maxlength="50" name="auth_name" size="30" tabindex="101" type="email" value="<?php echo $_smarty_tpl->getVariable('username')->value;?>
">
	</td>
</tr>

<tr>
	<td align="right" class="formInputLabel">Password:</td>
	<td>
		<input class="loginFormInput" maxlength="20" name="auth_pass" size="30" tabindex="102" type="password" value="<?php echo $_smarty_tpl->getVariable('password')->value;?>
">
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

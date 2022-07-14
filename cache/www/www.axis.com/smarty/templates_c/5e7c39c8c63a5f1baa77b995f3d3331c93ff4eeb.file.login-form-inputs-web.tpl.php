<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:35
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/login-form-inputs-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:392020567592bbfcf459cd8-48957272%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e7c39c8c63a5f1baa77b995f3d3331c93ff4eeb' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/login-form-inputs-web.tpl',
      1 => 1450949886,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '392020567592bbfcf459cd8-48957272',
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

<?php /* Smarty version Smarty-3.0.8, created on 2017-06-12 13:32:59
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/password-retrieval-form-inputs-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:981210543593e4ab3c07033-58980486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03f2775e11d7fb5fd69980590124ffb51dbf8a08' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/password-retrieval-form-inputs-web.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '981210543593e4ab3c07033-58980486',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<form action="password-retrieval-form-submit.php<?php echo $_smarty_tpl->getVariable('queryString')->value;?>
" method="post" name="frm_forgot_password">
<table class="loginForm">

<tr>
<td nowrap align="left" class="formInputLabel">Login Email Address:</td>
<td align="left"><input autofocus id="first_element" class="loginFormInput" maxlength="50" name="auth_name" size="33" type="email" value="<?php echo $_smarty_tpl->getVariable('username')->value;?>
"></td>
</tr>

<tr>
<td class="captcha" align="center" colspan="2">
<table>
<tr>
<td width="99%"><?php echo $_smarty_tpl->getVariable('captcha')->value;?>
</td>
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
</td>
</tr>

</table>
</form>

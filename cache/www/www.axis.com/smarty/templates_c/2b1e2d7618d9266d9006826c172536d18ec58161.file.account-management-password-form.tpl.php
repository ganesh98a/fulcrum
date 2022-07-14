<?php /* Smarty version Smarty-3.0.8, created on 2017-06-15 16:11:58
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/account-management-password-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10385391165942647602b188-51607704%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b1e2d7618d9266d9006826c172536d18ec58161' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/account-management-password-form.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10385391165942647602b188-51607704',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form name="frm_pass_update" action="account-management-password-form-submit.php" method="post">
<table border="0" cellpadding="3" cellspacing="0" width="100%">

<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
	<tr><td nowrap><br><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</td></tr>
<?php }?>

<tr>
<td align="left">
<?php if (isset($_smarty_tpl->getVariable('hideForm',null,true,false)->value)&&$_smarty_tpl->getVariable('hideForm')->value){?>
	<input value="Click Here To Update Your Password Again" type="button" onclick="window.location='<?php echo $_smarty_tpl->getVariable('startOverUrl')->value;?>
';">
<?php }else{ ?>
	<div class="headerStyle">Note: passwords are stored in a secure, one-way encrypted format.</div>
	<table cellSpacing="2" cellPadding="1" width="947">
	<tr>
	<td nowrap align="left" width="30%">Enter your current password</td>
	<td align="left" width="70%"><input <?php echo $_smarty_tpl->getVariable('currentPasswordDocumentId')->value;?>
 tabindex="500" type="password" maxlength="30" size="33" name="auth_pass" value="<?php echo $_smarty_tpl->getVariable('currentPassword')->value;?>
">&nbsp;(required for authentication)</td>
	</tr>
	<tr>
	<td nowrap align="left" width="30%">Enter your new password</td>
	<td align="left" width="70%"><input <?php echo $_smarty_tpl->getVariable('newPasswordDocumentId')->value;?>
 type="password" tabindex="501" maxlength="30" size="33" name="new_pass1" value="<?php echo $_smarty_tpl->getVariable('newPassword1')->value;?>
"></td>
	</tr>
	<tr>
	<td nowrap align="left" width="30%">Re-enter your new password</td>
	<td align="left" width="70%"><input type="password" tabindex="502" maxlength="30" size="33" name="new_pass2" value="<?php echo $_smarty_tpl->getVariable('newPassword2')->value;?>
">
	</td>
	</tr>
	<tr>
	<td nowrap align="right" width="30%" height="49"><input tabindex="504" class="button" onclick="window.location='account-management-password-form-reset.php'" type="button" value="Reset Form">&nbsp;&nbsp;</td>
	<td align="left" width="70%" height="49"><input tabindex="503" class="button" type="submit" value="Change Password" name="submit">
	</td>
	</tr>
	</table>
<?php }?>
</td>
</tr>

</table>
</form>

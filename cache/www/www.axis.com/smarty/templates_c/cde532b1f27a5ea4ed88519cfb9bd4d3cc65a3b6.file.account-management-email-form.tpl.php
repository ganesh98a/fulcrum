<?php /* Smarty version Smarty-3.0.8, created on 2022-01-03 06:25:32
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/account-management-email-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1273561d288ccaeb439-25798725%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cde532b1f27a5ea4ed88519cfb9bd4d3cc65a3b6' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/account-management-email-form.tpl',
      1 => 1631167917,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1273561d288ccaeb439-25798725',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<div class="headerStyle">Account Management - Change Your Email Address</div>

<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
	<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
<?php }?>

<?php if (isset($_smarty_tpl->getVariable('hideForm',null,true,false)->value)&&$_smarty_tpl->getVariable('hideForm')->value){?>
<br>
<input value="Click Here to Try Updating Your Email Address Again" type="button" onclick="window.location='<?php echo $_smarty_tpl->getVariable('startOverUrl')->value;?>
';">
<?php }else{ ?>
<form name="frm_email_update" action="account-management-email-form-submit.php" method="post">
<input type="hidden" name="currentEmail" value="<?php echo $_smarty_tpl->getVariable('email')->value;?>
">
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td>
<div align="left">If you need to change the email address on your account, follow these steps:
<ol class="instructionsList" type="i">
<li>Your current email address is shown below.</li>
<li>Change your email address by editing the fields below.</li>
<li>Enter your password for authentication.</li>
<li>Click &ldquo;Save Changes&rdquo;.</li>
</ol>
</div>
</td>
</tr>

<tr>
<td align="left">

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
	<tr>
	<td colspan="2"><strong>Update Your Email Address Below</strong></td>
	</tr>

	<tr>
	<td width="10%" nowrap>Enter Your New Email Address</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td width="10%"><input type="email" tabindex="101" maxlength="30" size="33" name="new_email1" value="<?php echo $_smarty_tpl->getVariable('new_email1')->value;?>
"></td>
		<td>&nbsp;</td>
		</tr>
		</table>
	</td>
	</tr>

	<tr>
	<td width="10%" nowrap>Re-enter Your New Email Address</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td width="10%"><input type="email" tabindex="101" maxlength="30" size="33" name="new_email2" value="<?php echo $_smarty_tpl->getVariable('new_email2')->value;?>
"></td>
		<td>&nbsp;</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>

	<br>

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
	<tr>
	<td colspan="2"><strong>Your current email address is: <i><?php echo $_smarty_tpl->getVariable('email')->value;?>
</i></strong></td>
	</tr>

	<tr>
	<td width="10%" nowrap>Enter Current Password</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td><input id="first_element" tabindex="100" type="password" name="currentPassword" value="<?php echo $_smarty_tpl->getVariable('currentPassword')->value;?>
" maxlength="30" size="25" style="width:200px;"></td>
		<td>&nbsp;(required for authentication)</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>

	<div align="left">
	<br>
	<input type="reset" value="    Reset Form    " name="Reset" tabindex="3002" onclick="window.location='account-management-email-form-reset.php'">&nbsp;|&nbsp;<input class="button" type="submit" value="   Change Email   " name="Submit" tabindex="3001">
	</div>

</td>
</tr>
</table>
</form>
<?php }?>

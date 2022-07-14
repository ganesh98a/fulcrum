<?php /* Smarty version Smarty-3.0.8, created on 2017-06-15 16:12:00
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/account-management-security-information-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1504472102594264782059d0-01459795%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd6fca93d4903ed0d6648232c1392cbd551f7c854' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/account-management-security-information-form.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1504472102594264782059d0-01459795',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<div class="headerStyle">Account Management - Required Login &amp; Security Information</div>

<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
	<div style="margin-top:5px;"><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
<?php }?>

<?php if (isset($_smarty_tpl->getVariable('hideForm',null,true,false)->value)&&$_smarty_tpl->getVariable('hideForm')->value){?>
<input value="Click Here to Try Updating Your Security Information Again" type="button" onclick="window.location='<?php echo $_smarty_tpl->getVariable('startOverUrl')->value;?>
';">
<?php }else{ ?>
<form name="frm_account_management_security_information" action="account-management-security-information-form-submit.php" method="post">
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td>
<div align="left">If you need to change the security information on your account, follow these steps:
<ol class="instructionsList" type="i">
<li>Change your information as desired by editing the fields below.</li>
<li>Click &ldquo;Save Changes&rdquo;.</li>
</ol>
</div>
</td>
</tr>
<tr>
<td align="left" width="100%">

	<?php $_template = new Smarty_Internal_Template("security-information-form-inputs.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

	<br>
	<input type="reset" value="    Reset Form    " name="Submit1" tabindex="22" onclick="window.location='account-management-security-information-form-reset.php'">&nbsp;|&nbsp;<input type="submit" value="   Save Changes   " name="Submit2" tabindex="21">

</td>
</tr>
</table>
</form>
<?php }?>

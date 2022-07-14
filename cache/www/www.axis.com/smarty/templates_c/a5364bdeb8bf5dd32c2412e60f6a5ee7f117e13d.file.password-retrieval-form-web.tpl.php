<?php /* Smarty version Smarty-3.0.8, created on 2017-06-12 13:32:59
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/password-retrieval-form-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:457120160593e4ab3bcb8c4-85197773%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5364bdeb8bf5dd32c2412e60f6a5ee7f117e13d' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/password-retrieval-form-web.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '457120160593e4ab3bcb8c4-85197773',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">

<?php if (!isset($_smarty_tpl->getVariable('hideForm',null,true,false)->value)||$_smarty_tpl->getVariable('hideForm')->value==0){?>
<tr>
<td>
<div class="forgotPasswordBody">
If you have forgotten your Password, follow these steps:
<ol type="i">
<li>Enter your login email address below.
<li>Follow the instructions of the e-mail that you receive.</li>
</ol>
</div>
</td>
</tr>
<?php }?>

<tr>
<td>
	<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }?>
	<?php if (isset($_smarty_tpl->getVariable('hideForm',null,true,false)->value)&&$_smarty_tpl->getVariable('hideForm')->value){?>
		<input value="Login To Your Account" type="button" onclick="window.location='/login-form.php';">
		<br>
		<br>
		<input value="Click Here to Try Resetting Your Password Again" type="button" onclick="window.location='<?php echo $_smarty_tpl->getVariable('startOverUrl')->value;?>
';">
	<?php }else{ ?>
		<?php $_template = new Smarty_Internal_Template("password-retrieval-form-inputs-web.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<?php }?>
</td>
</tr>

</table>

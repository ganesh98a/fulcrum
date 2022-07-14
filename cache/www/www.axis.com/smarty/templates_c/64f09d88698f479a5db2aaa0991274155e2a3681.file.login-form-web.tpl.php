<?php /* Smarty version Smarty-3.0.8, created on 2017-06-19 18:25:28
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/login-form-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19732808005947c9c0b87a33-84875328%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64f09d88698f479a5db2aaa0991274155e2a3681' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/login-form-web.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19732808005947c9c0b87a33-84875328',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<br>
<br>

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
</table>

<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:35
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/login-form-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:471891908592bbfcf42bd07-37963763%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2debcddfadd6f11b7349e1e7e912414cd8e31ed' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/login-form-web.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '471891908592bbfcf42bd07-37963763',
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

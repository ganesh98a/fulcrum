<?php /* Smarty version Smarty-3.0.8, created on 2021-11-25 09:21:15
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/impersonate-users-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15146619f477b3a3077-49232724%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '43dc3379e58b4b7775ef396fda4971d2dd31d368' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/impersonate-users-form.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15146619f477b3a3077-49232724',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<form id="frm_impersonate" name="frm_impersonate" action="/impersonate-users-form-submit.php" method="post">
<input type="hidden" name="currentEmail" value="<?php echo $_smarty_tpl->getVariable('email')->value;?>
">
<table border="0" width="100%" cellspacing="0" cellpadding="3">
<tr>
<td width="100%" height="20">
<div class="headerStyle">User Impersonation</div>
<br>
</td>
</tr>

<tr>
<td align="left">

	<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
<div>
	<?php }?>

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 0px #ccc;">
	<tr>
	<td colspan="2"><strong>You are currently logged in as: <i><?php echo $_smarty_tpl->getVariable('email')->value;?>
</i></strong></td>
	</tr>
	</table>

	<br>

	<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
	<tr>
	<td colspan="2"><?php $_template = new Smarty_Internal_Template("form-user-impersonation.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?></td>
	</tr>
	</table>

</td>
</tr>
</table>
</form>

<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:29
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/admin-user-creation-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:397819574592bbfc92c4864-45118275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '100406be39f919c909f60974a53efb062209dec5' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/admin-user-creation-form.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '397819574592bbfc92c4864-45118275',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form name="frm_create_profile" action="admin-user-creation-form-submit.php<?php echo $_smarty_tpl->getVariable('queryString')->value;?>
" method="post" enctype="multipart/form-data">

<table border="0" cellpadding="3" cellspacing="0" height="73" width="100%">

<tr>
<td height="20"><div class="headerStyle">Manage Users &mdash; Create/Edit a User</div></td>
</tr>

<tr>
<td height="20">
<br>
<input type="button" value="Create A New Registered User" onclick="window.location='admin-user-creation-form-reset.php<?php echo $_smarty_tpl->getVariable('createUserQueryString')->value;?>
'">
<br>
<br>
<?php $_template = new Smarty_Internal_Template("dropdown-user-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<noscript>
<input type="button" value="Edit An Existing User" onclick="userRedirect(this.form, 'admin-user-creation-form-reset.php');">
</noscript>
<br>
<br>
</td>
</tr>

<tr>
<td>

	<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }?>

	<?php $_template = new Smarty_Internal_Template("admin-user-security-information-form-inputs.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

	<br>
	<br>

	<?php $_template = new Smarty_Internal_Template("admin-user-details-form-inputs.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

	<br>
	<div align="left">
	<input type="reset" value="    Reset Form    " name="Submit" tabindex="3002" onclick="window.location='admin-user-creation-form-reset.php<?php echo $_smarty_tpl->getVariable('queryString')->value;?>
'">
	&nbsp;&nbsp;
	<input type="submit" value="       Save       " name="Submit" tabindex="3001">
	</div>

</td>
</tr>

</table>
</form>

<?php /* Smarty version Smarty-3.0.8, created on 2017-05-27 18:58:55
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/admin-user-company-creation-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:729645178592a2edf7af965-49663264%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fddaa1abbea9bbdd29a12f4c78e1bfe012f3b93b' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/admin-user-company-creation-form.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '729645178592a2edf7af965-49663264',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form name="frm_create_profile" action="admin-user-company-creation-form-submit.php<?php echo $_smarty_tpl->getVariable('queryString')->value;?>
" method="post" enctype="multipart/form-data">

<table border="0" cellpadding="3" cellspacing="0" height="73" width="100%">

<tr>
<td height="20"><div class="headerStyle">Manage Customers &mdash; Create/Edit a Customer (User Company)</div></td>
</tr>

<tr>
<td height="20">
<br>
<input type="button" value="Create A New Registered Company (User Company)" onclick="window.location='admin-user-company-creation-form-reset.php<?php echo $_smarty_tpl->getVariable('createUserCompanyQueryString')->value;?>
'">
<br>
<br>
<?php $_template = new Smarty_Internal_Template("dropdown-user-company-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<noscript>
<input type="button" value="Edit An Existing Customer (User Company)" onclick="userCompanyRedirect(this.form, 'admin-user-company-creation-form-reset.php');">
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

	<?php $_template = new Smarty_Internal_Template("admin-user-company-information-form-inputs.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

	<br>
	<div align="left">
	<input type="reset" value="    Reset Form    " name="Submit" tabindex="3002" onclick="window.location='admin-user-company-creation-form-reset.php<?php echo $_smarty_tpl->getVariable('queryString')->value;?>
'">
	&nbsp;&nbsp;
	<input type="submit" value="       Save       " name="Submit" tabindex="3001">
	</div>
</td>
</tr>

</table>
</form>

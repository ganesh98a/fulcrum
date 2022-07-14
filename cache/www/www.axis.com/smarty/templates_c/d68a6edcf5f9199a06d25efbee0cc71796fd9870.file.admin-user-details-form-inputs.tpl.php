<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:29
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/admin-user-details-form-inputs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1120832618592bbfc940c3f0-33323229%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd68a6edcf5f9199a06d25efbee0cc71796fd9870' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/admin-user-details-form-inputs.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1120832618592bbfc940c3f0-33323229',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<table width="100%" border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
<tr>
<td colspan="2"><strong>Optional User Information</strong></td>
</tr>

<tr>
<td width="10%" nowrap>First Name</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="10%"><input maxlength="50" size="25" name="first_name" value="<?php echo $_smarty_tpl->getVariable('first_name')->value;?>
" tabindex="220" style="width:150px;"></td>
	<td>&nbsp;</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Last Name</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="last_name" value="<?php echo $_smarty_tpl->getVariable('last_name')->value;?>
" tabindex="221" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td nowrap>Title/Position</td>
<td>
	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td><input maxlength="50" size="25" name="title" value="<?php echo $_smarty_tpl->getVariable('job_title')->value;?>
" tabindex="229" style="width:150px;"></td>
	<td> </td>
	</tr>
	</table>
</td>
</tr>

</table>

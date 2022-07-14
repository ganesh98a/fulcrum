<?php /* Smarty version Smarty-3.0.8, created on 2022-04-13 07:20:38
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/project-budget-import-items-form-web.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1837262565da63f4871-80256507%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0235b98588d10688c5d4d2a853f309354222cbc2' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/project-budget-import-items-form-web.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1837262565da63f4871-80256507',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_counter')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\function.counter.php';
?><table border="0" cellpadding="3" cellspacing="0" width="100%">
	<tr>
		<td colspan="2" height="20" valign="middle" width="100%">
			<div class="headerStyle">Development BudgetsHERE &mdash; Import Budget Items</div>
			<div style="float: right; padding: 4px 0;">TEST<!--<a href="account-management.php">Manage Your Account</a>--></div>
		</td>
	</tr>
	<tr>
		<td id="messageList" colspan="2" nowrap><?php echo preg_replace('!\s+!u', ' ',$_smarty_tpl->getVariable('htmlMessages')->value);?>
</td>
	</tr>

	<tr>
		<td valign="top">
			<table id="tblSystemDefaultBudgetItems" border="1" cellpadding="3" cellspacing="0" width="100%">
				<tr>
					<th></th>
					<th height="20" valign="middle">
						<h2 style="color: #111987; text-align: left;"><?php echo $_smarty_tpl->getVariable('currentlySelectedProjectName')->value;?>
 (import into this project)</h2>
					</th>
				</tr>

				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrCurrentlySelectedGcBudgetLineItems')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
					<?php ob_start();?><?php echo smarty_function_counter(array(),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_tmp1, null, null);?>
					<tr>
						<td><input type="checkbox" name="row_<?php echo $_smarty_tpl->getVariable('i')->value;?>
_checkbox" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['gc_budget_line_item_id'];?>
"></td>
						<td><?php echo $_smarty_tpl->tpl_vars['row']->value['cost_code'];?>
 &mdash; <?php echo $_smarty_tpl->tpl_vars['row']->value['cost_code_description'];?>
</td>
					</tr>
				<?php }} ?>
			</table>
		</td>
		<td valign="top">
			<form action="/modules-gc-budget-import-line-items-form-submit.php?importFromProjectUserCompanyId=<?php echo $_smarty_tpl->getVariable('importFromProjectUserCompanyId')->value;?>
&importFromProjectId=<?php echo $_smarty_tpl->getVariable('importFromProjectId')->value;?>
" method="post" name="frmTabularData">
				<table id="tblSystemDefaultBudgetItems" border="1" cellpadding="3" cellspacing="0" width="100%">
					<tr>
						<th></th>
						<th height="20" valign="middle">
							<h2 style="color: #111987; text-align: left;">Import From Project Budget <?php $_template = new Smarty_Internal_Template("dropdown-projects-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?></h2>
						</th>
					</tr>

					<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrImportFromGcBudgetLineItems')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
						<?php ob_start();?><?php echo smarty_function_counter(array(),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_tmp2, null, null);?>
						<tr>
							<td><input type="checkbox" name="row_<?php echo $_smarty_tpl->getVariable('i')->value;?>
_checkbox" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['gc_budget_line_item_id'];?>
"></td>
							<td><?php echo $_smarty_tpl->tpl_vars['row']->value['cost_code'];?>
 &mdash; <?php echo $_smarty_tpl->tpl_vars['row']->value['cost_code_description'];?>
</td>
						</tr>
					<?php }} ?>
				</table>
				<br>
				<div>
					<input type="submit" value="Import Selected Budget Items">
					<input class="button" onclick="window.location='modules-gc-budget-import-line-items-form-reset.php?importFromProjectUserCompanyId=<?php echo $_smarty_tpl->getVariable('importFromProjectUserCompanyId')->value;?>
&importFromProjectId=<?php echo $_smarty_tpl->getVariable('importFromProjectId')->value;?>
'" type="button" value="Reset Form">
				</div>
			</form>
		</td>
	</tr>
</table>
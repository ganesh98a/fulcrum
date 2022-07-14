<?php /* Smarty version Smarty-3.0.8, created on 2017-06-17 12:40:06
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/modules-permissions-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:460640955944d5cec5d0d9-78877912%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc0f8cdb46dc3e7c93deb34e0d9708a628ae1eda' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/modules-permissions-form.tpl',
      1 => 1497530994,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '460640955944d5cec5d0d9-78877912',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include '/var/www/myfulcrum/engine/include/smarty-3.0.8/plugins/block.php.php';
?>
<?php $_template = new Smarty_Internal_Template("dropdown-software-modules-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template("dropdown-projects-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<input id="btnReloadPermissionsData" type="button" value="Refresh Permissions Data" onclick="softwareModuleChanged();">
<input id="btnResetPermissions" type="button" value="Reset To System Default Permissions" onclick="resetDefaultPermissions();" <?php echo $_smarty_tpl->getVariable('btnResetStyleParam')->value;?>
>
<br><br>
<div id="divAddTeamMembers">
<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>


// Debug.
$user_can_manage_team_members = true;
if ($user_can_manage_team_members) {
	echo '
<table class="permissionTable table-team-members">
	<tr>
		<th class="permissionTableMainHeader">Add New Team Members</th>
	</tr>
	<tr>
		<td>
			<table class="table-contact-roles" width="100%">
				<tr>
					<td id="teamManagement" class="contact-search-parent-container">
	';
}
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	<?php echo $_smarty_tpl->getVariable('permissionsSearchForm')->value;?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

$user_can_manage_team_members = true;
if ($user_can_manage_team_members) {
	echo '
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
	';
}

<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

</div>
<div id="divProjectContactList"></div>
<div id="divPermissionsMatrix"></div>
<div id="divPermissionsAssignmentsByContact"></div>
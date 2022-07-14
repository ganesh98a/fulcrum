<?php /* Smarty version Smarty-3.0.8, created on 2022-03-28 10:23:06
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-permissions-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:83936241706ad74026-91478695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f98416575ccd8c4440ad50814e20dbb3a0b6316' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-permissions-form.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '83936241706ad74026-91478695',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\block.php.php';
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
<div id="divPermissionsAssignmentsByContact"></div>
<div id="divPermissionsMatrix"></div>
<div class="divTabs">
	<ul>
		<li><a id="teamTab" class="tab <?php echo $_smarty_tpl->getVariable('teamSelected')->value;?>
" onclick="tabClicked(this, '1');">Team</a></li>
		<li><a id="subcontractorsTab" class="tab <?php echo $_smarty_tpl->getVariable('subcontractorsSelected')->value;?>
" onclick="tabClicked(this, '2');">Subcontractors</a></li>
		<li><a id="biddersTab" class="tab <?php echo $_smarty_tpl->getVariable('biddersSelected')->value;?>
" onclick="tabClicked(this, '3');">Bidders</a></li>		
	</ul>
</div>
<div id="divProjectContactList"></div>
<input type="hidden" id="activeTab" value="<?php echo $_smarty_tpl->getVariable('activeTab')->value;?>
">


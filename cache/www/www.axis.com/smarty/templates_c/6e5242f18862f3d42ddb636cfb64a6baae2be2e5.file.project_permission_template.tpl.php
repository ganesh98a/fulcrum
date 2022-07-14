<?php /* Smarty version Smarty-3.0.8, created on 2021-09-22 07:53:44
         compiled from "project_permission_template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25094614ac4e805a938-15914139%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e5242f18862f3d42ddb636cfb64a6baae2be2e5' => 
    array (
      0 => 'project_permission_template.tpl',
      1 => 1631167903,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25094614ac4e805a938-15914139',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="div_permission" class="custom_delay_padding grid_view custom_datatable_style">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
	

	<div style="float:left;width:100%;margin-bottom:5px;">
	<input type="hidden" id="lastroleid" value=<?php echo $_smarty_tpl->getVariable('roleCount')->value;?>
>
	
	</div>
	<div id="perTable" class="perlist" style="float:left;display:block;margin-right: 10px;" width="100%">
	<!-- <span><img class="datepicker datedivseccal_icon_gk" alt="" src="../../images/filter.png" id="dp1557294692941" width="20"></span> -->
	<?php echo $_smarty_tpl->getVariable('perTable')->value;?>
</div>
		<div id="alpah" class="perlist" style="font-weight: bold;color: #3b90ce;float:left;font-size:12px;"> <?php echo $_smarty_tpl->getVariable('alphabetarrange')->value;?>
 </div>
	
	<div style="float:left;display:block;margin-left: 10px;" width="100%">
		<input id="btnResetPermissions" type="button" value="Reset To System Default Permissions" onclick="projectSpecificResetDefaultPermissions();">
	</div>
	

	<div id="mainlist" style="margin-top:20px;float:left;" class="perlist">
	</div> 
	


	<div id="divCreateRole" class="modal"></div>

	
	<div id="viewsubchange" class="modal"></div>

	<div id="dialog-confirm"></div>
	<br>
	<!-- for grid -->
	<div id="PermissionsBasedonContact"></div>
	<!--For team member adding -->
	<div id="divAddTeamMembers" style="width:1000px;clear: both;">
	<br>
	<table class="permissionTable table-team-members" >
	<tr>
	<th class="permissionTableMainHeader">Add New Team Members</th>
	</tr>
	<tr>
	<td>
	<table class="table-contact-roles" width="100%">
	<tr>
	<td id="teamManagement" class="contact-search-parent-container">
	<?php echo $_smarty_tpl->getVariable('permissionsSearchForm')->value;?>

	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	</div>
	
	<!--For team member listing -->
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

	<!--For team member adding -->
	<div id="divProjectContactList" style="width: 1000px;"></div>

<input type="hidden" id="activeTab" value="<?php echo $_smarty_tpl->getVariable('activeTab')->value;?>
">
<input type="hidden" id="userRole" value="<?php echo $_smarty_tpl->getVariable('userRole')->value;?>
">
	<?php }?>
</div>
	

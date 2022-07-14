<?php /* Smarty version Smarty-3.0.8, created on 2022-03-21 06:09:50
         compiled from "admin_permission_template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:253096238089e93e271-30062487%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4b30ae9d27ee293803fa29e1f3b71e7da3da320' => 
    array (
      0 => 'admin_permission_template.tpl',
      1 => 1631167903,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '253096238089e93e271-30062487',
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
	<div style="float:left;display:block;margin-left:10px;" width="100%">
		<input id="btnResetPermissions" type="button" value="Reset To System Default Permissions" onclick="projectNonSpecificResetDefaultPermissions();">
	</div>
	<!-- <option value='Y' style="color:#3b90ce;">Project Specific</option>
	<option value='N' style="color:#999999;">Not Project Specific</option> -->

	<div id="mainlist" style="margin-top:20px;float:left;" class="perlist">
	</div> 
	

	<div id="wholemanage">
	<div id="manageRole" class="select-role manageRole" style="display:none;">
	<?php if ((isset($_smarty_tpl->getVariable('globalAccess',null,true,false)->value))&&($_smarty_tpl->getVariable('globalAccess')->value=='1')){?>
	<!--<?php echo $_smarty_tpl->getVariable('allCompany')->value;?>
-->
	<?php }?>
	<div class="" style="float:left;width: 13%;">
	<p class="subhead">Select role</p>
	</div>
	<div class="" style="float:left;width: 87%;">
	<div class="topselect">
	<?php echo $_smarty_tpl->getVariable('roleListTable')->value;?>

	</div>
	</div>
	<div class="block-section roleSet" style="display:none;">
	<p class="main-head">Selected role(s)</p>
	<div id="role_items" class="block-section m-t-10 m-b-0"></div>
	</div>

	<div class="block-section">	
	<div class="" style="float:left;width: 13%;">
	<p class="subhead">Select module </p>
	</div>
	<div class="" style="float:left;width: 87%;">
	<div id="soft_role" class="topselect">
	<?php echo $_smarty_tpl->getVariable('roleWithModule')->value;?>

	</div>
	</div>
	<div id="mod_role" class="block-section"></div>
	</div>

	<div class="block-section" style="text-align:right;">
	<input type="button" onclick="showback();" id="backrol" value="Cancel" style="margin-bottom:15px;margin-right:10px;background:#8e979e;">
	<input type="button" class="persave" onclick="saveRoleAndPermission('<?php echo $_smarty_tpl->getVariable('globalAccess')->value;?>
');" value="Save" style="margin-bottom:15px;"> </div>

	</div></div>   <!-- manage role div -->

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
	<!--<div class="divTabs">
		<ul>
			<li><a id="teamTab" class="tab <?php echo $_smarty_tpl->getVariable('teamSelected')->value;?>
" onclick="tabClicked(this, '1');">Team</a></li>
			<li><a id="subcontractorsTab" class="tab <?php echo $_smarty_tpl->getVariable('subcontractorsSelected')->value;?>
" onclick="tabClicked(this, '2');">Subcontractors</a></li>
			<li><a id="biddersTab" class="tab <?php echo $_smarty_tpl->getVariable('biddersSelected')->value;?>
" onclick="tabClicked(this, '3');">Bidders</a></li>		
		</ul>
	</div>-->

	<!--For team member adding -->
	<!--<div id="divProjectContactList" style="width: 1000px;"></div>-->

<input type="hidden" id="activeTab" value="<?php echo $_smarty_tpl->getVariable('activeTab')->value;?>
">
<input type="hidden" id="userRole" value="<?php echo $_smarty_tpl->getVariable('userRole')->value;?>
">
	<?php }?>
</div>
	

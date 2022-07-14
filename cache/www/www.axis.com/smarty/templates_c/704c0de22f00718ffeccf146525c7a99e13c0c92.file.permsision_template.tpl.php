<?php /* Smarty version Smarty-3.0.8, created on 2022-03-21 06:36:28
         compiled from "permsision_template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1236162380edc5d33a8-70765435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '704c0de22f00718ffeccf146525c7a99e13c0c92' => 
    array (
      0 => 'permsision_template.tpl',
      1 => 1631167903,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1236162380edc5d33a8-70765435',
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
	<!--<input type="button" class="addpermission" onclick="ManageRoles();"  value="Add Role and Permission" style="margin-bottom:15px"> -->
	<input type="button" class="addpermission" onclick="showcreateRoleDialog();" value="Create Role" style="margin-bottom:15px">
	<input type="hidden" id="lastroleid" value=<?php echo $_smarty_tpl->getVariable('roleCount')->value;?>
>

	

	
	</div>
	<div id="perTable" class="perlist" style="float:left;display:block;margin-right: 10px;" width="100%">
	<!-- <span><img class="datepicker datedivseccal_icon_gk" alt="" src="../../images/filter.png" id="dp1557294692941" width="20"></span> -->
	<?php echo $_smarty_tpl->getVariable('perTable')->value;?>
</div>
	<div id="alpah" class="perlist" style="font-weight: bold;color: #3b90ce;float:left;font-size:12px;"> <?php echo $_smarty_tpl->getVariable('alphabetarrange')->value;?>
 </div>

	<div id="mainlist" style="margin-top:20px;float:left;" class="perlist">
	<!--<?php echo $_smarty_tpl->getVariable('permissiongrid')->value;?>
-->
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
	<p class="subhead">Select module</p>
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
	<?php }?>
</div>
	

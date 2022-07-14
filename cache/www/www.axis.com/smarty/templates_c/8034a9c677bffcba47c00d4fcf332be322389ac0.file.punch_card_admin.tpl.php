<?php /* Smarty version Smarty-3.0.8, created on 2021-11-25 10:58:49
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/punch_card_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7420619f5e5968b826-16393655%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8034a9c677bffcba47c00d4fcf332be322389ac0' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/punch_card_admin.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7420619f5e5968b826-16393655',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="punch_card" class="custom_delay_padding grid_view custom_datatable_style">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
		<div>

		<?php if (($_smarty_tpl->getVariable('userCanManagePunch')->value)){?>
		<input type="button" onclick="CreateDefectsDialog(null);" value="Create Defects" style="margin-bottom:15px">	
		
			
		<?php }?>

		
	</div>
	<div style="margin:20px;" ></div>
	<div id="defectTable"><?php echo $_smarty_tpl->getVariable('buildDefectTable')->value;?>
</div>
	<div id="divCreatepunch" class="modal hidden"></div>
	<div id="divdefect" class="modal"></div>
	<div id="dataTable"></div>
	<div id="myconsole"></div>
	
	
	<?php }?>
</div>

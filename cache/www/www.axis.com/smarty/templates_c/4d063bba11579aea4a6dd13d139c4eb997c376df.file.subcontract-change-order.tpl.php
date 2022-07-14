<?php /* Smarty version Smarty-3.0.8, created on 2022-05-25 17:18:56
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/subcontract-change-order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19914628e48e0104c68-70156915%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d063bba11579aea4a6dd13d139c4eb997c376df' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/subcontract-change-order.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19914628e48e0104c68-70156915',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="sub_change_order" class="custom_delay_padding grid_view custom_datatable_style">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
		<div>

		<?php if (($_smarty_tpl->getVariable('userCanManageSubOrder')->value)){?>
		<input type="button" onclick="CreateSubChangeOrderDialog(null);" value="Create Subcontract Change Order" style="margin-bottom:15px">		
		<?php }?>

		<select id="view_status" onchange="gridViewChange()" style="margin-bottom:15px">
			<option value="costcode" selected="">costcode view</option>
			<option value="subcontractor">subcontractor view</option>
		</select>

		<select id="sco_filter" onchange="gridViewChange()" style="margin-bottom:15px">
			<option value="all">All</option>
			<option value="potential">Potential</option>
			<option value="approved">Approved</option>
		</select>

		<?php if (($_smarty_tpl->getVariable('userCanManageSubOrder')->value)){?>
		<input type="button" onclick="downloadSubcontractPDF();" value="Print SCO Lists as PDF" style="margin-bottom:15px">
		<?php }?>

		<input type="checkbox" name="in_potential" id="in_potential" onclick="gridViewChange()" checked> Total Potential

	
	</div>
	<div id="OrderTable"><?php echo $_smarty_tpl->getVariable('OrderTable')->value;?>
</div>
	<div id="divCreateOrder" class="hidden"></div>
	<div id="divCreateCo" class="hidden"></div>
	<input type="hidden" id="active_change_order_id" value="">
	<input type="hidden" id="active_change_order_draft_id" value="">
	<input type="hidden" id="active_change_order_notification_id" value="">
	
	<div id="viewsubchange" class="modal"></div>

	<div id="dialog-confirm"></div>
	<?php }?>
</div>
	

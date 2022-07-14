<?php /* Smarty version Smarty-3.0.8, created on 2022-06-28 10:02:25
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-change-orders-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:196262bab59111a378-60719651%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '298a4ef8315c96a23bd10ae3a5c5d6d39636db3d' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-change-orders-form.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '196262bab59111a378-60719651',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="CHANGE_ORDER">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
	<div>
	<?php if (($_smarty_tpl->getVariable('userCanManageChangeOrders')->value)){?>
		<input type="button" onclick="project_ownerCheck();" value="Create A New Change Order" style="margin-bottom:15px">
		<span style="padding: 0 20px;">or</span>
		<?php echo $_smarty_tpl->getVariable('ddlChangeOrderDrafts')->value;?>

		<span style="padding: 0 0px;">&nbsp;</span>
		<?php }?>	
		<!--ChangeOrders__loadCreateCoDialog(null); span style="padding: 0 20px;">&nbsp;</span>
		<span class="fakeHref" onclick="ChangeOrders__generateChangeOrdersListViewPdf();"><img src="/images/printer.gif" style="vertical-align: top;"> Print Change Order List as PDF</span>
		<span style="padding: 0 20px;">&nbsp;</span-->
		<select onchange="ChangeOrders__performAction(this);" style="margin-bottom:15px">
			<option value="-1">Change Order Actions</option>
			<option value="all">Print All Change Orders (PCOs/CORs) As List View PDF</option>
			<option value="cor">Print Change Order Requests (CORs) As List View PDF</option>
			<option value="pco">Print Potential Change Orders (PCOs) As List View PDF</option>
		</select>
		<span style="padding: 0 20px;"><input type="checkbox" name="showreject" id="showreject"> Show Rejected</span>
	</div>
	<div id="dialog-confirm"></div>
	<div id="coTable"><?php echo $_smarty_tpl->getVariable('coTable')->value;?>
</div>
	<div id="coDetails"><?php echo $_smarty_tpl->getVariable('coDetails')->value;?>
</div>
	<div id="divCreateCo" class="hidden"><?php echo $_smarty_tpl->getVariable('createCoDialog')->value;?>
</div>
	<input type="hidden" id="active_change_order_id" value="">
	<input type="hidden" id="active_change_order_draft_id" value="">
	<input type="hidden" id="active_change_order_notification_id" value="">
	<?php }?>
</div>

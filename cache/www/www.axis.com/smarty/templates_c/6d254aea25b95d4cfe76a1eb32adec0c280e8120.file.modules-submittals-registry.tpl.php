<?php /* Smarty version Smarty-3.0.8, created on 2022-04-27 08:53:24
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-submittals-registry.tpl" */ ?>
<?php /*%%SmartyHeaderCode:181166268e864cbfb08-86981218%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d254aea25b95d4cfe76a1eb32adec0c280e8120' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-submittals-registry.tpl',
      1 => 1642069497,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '181166268e864cbfb08-86981218',
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
		<div style="text-align: right;">
	
		<span>		
		<a tabindex="52" href="/modules-submittals-registry-form.php">Export registry items</a> |
		<a tabindex="52" href="javascript:void(0)" onclick="loadImportCostCodesIntoBudgetDialog('submittal_regitry'); return false;">Import registry items</a> | 
		<a tabindex="52" href="javascript:void(0)" onclick="Submittalsregistry__loadCreateSuDialog(null);setTimeout('Submittals__automaticRecipient(<?php echo $_smarty_tpl->getVariable('primary_contact_id')->value;?>
,\'<?php echo $_smarty_tpl->getVariable('primary_name')->value;?>
\')', 2000);" >Add registry item +</a>
		</span>
	</div><br />
	<div id="OrderTable"><?php echo $_smarty_tpl->getVariable('OrderTable')->value;?>
</div>
	<div id="divCreateOrder" class="hidden"></div>
	<div id="divCreateSuRe" class="hidden"></div>
	<div id="divModalWindow" class="hidden" style=""></div>
	<input type="hidden" id="active_change_order_id" value="">
	<input type="hidden" id="active_change_order_draft_id" value="">
	<input type="hidden" id="active_change_order_notification_id" value="">
	
	<div id="viewsubchange" class="modal"></div>

	<div id="dialog-confirm"></div>
	<?php }?>
</div>
	

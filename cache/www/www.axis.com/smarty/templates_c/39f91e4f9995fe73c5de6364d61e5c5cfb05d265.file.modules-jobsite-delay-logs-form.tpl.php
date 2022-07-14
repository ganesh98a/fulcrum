<?php /* Smarty version Smarty-3.0.8, created on 2021-11-25 08:56:43
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-jobsite-delay-logs-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23699619f41bb3e2bb3-26290219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39f91e4f9995fe73c5de6364d61e5c5cfb05d265' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-jobsite-delay-logs-form.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23699619f41bb3e2bb3-26290219',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="Delays" class="custom_delay_padding grid_view custom_datatable_style">
	<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>

	<div>

		<?php if (($_smarty_tpl->getVariable('userCanManageDelays')->value)){?>
		<input type="button" onclick="Delays__loadCreateDelayDialog(null);" value="Create Delay" style="margin-bottom:15px">		
		<?php }?>
		<input type="hidden" id="ManageDelays" name="ManageDelays" value="<?php echo $_smarty_tpl->getVariable('userCanManageDelays')->value;?>
">
		<img src="./images/pdfprint.png" width="40px" height="40px" style="float:right; cursor: pointer;" onclick="pdf_generationdelay();">
	</div>
	<div id="rfiTable" style="display:none;"><?php echo $_smarty_tpl->getVariable('delayTable')->value;?>
</div>
	<div id="divCreateRfi" class="hidden"><?php echo $_smarty_tpl->getVariable('createDelayDialog')->value;?>
</div>
	
	<input type="hidden" id="active_request_for_information_id" value="">
	<input type="hidden" id="active_request_for_information_draft_id" value="">
	<input type="hidden" id="active_request_for_information_notification_id" value="">
	<div id="dialog-confirm"></div>
	<?php }?>
</div>

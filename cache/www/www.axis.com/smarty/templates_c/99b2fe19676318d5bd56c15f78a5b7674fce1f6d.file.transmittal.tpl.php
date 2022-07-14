<?php /* Smarty version Smarty-3.0.8, created on 2021-12-11 07:12:04
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/transmittal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2227261b441340e2e84-43580870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99b2fe19676318d5bd56c15f78a5b7674fce1f6d' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/transmittal.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2227261b441340e2e84-43580870',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="Tranmittals" class="custom_delay_padding grid_view custom_datatable_style">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
		<div>

		<?php if (($_smarty_tpl->getVariable('userCanManageTransmittal')->value)){?>
		<input type="button" onclick="CreateTransmittalsDialog(null);" value="Create Transmittal" style="margin-bottom:15px">		
		<?php }?>

		<!-- <img src="./images/pdfprint.png" width="40px" height="40px" style="float:right; cursor: pointer;" onclick="pdf_generationdelay();"> -->
	</div>
	<div id="TransmittalTable"><?php echo $_smarty_tpl->getVariable('TransmittalTable')->value;?>
</div>
	<div id="divCreateTransmittal" class="hidden"></div>
	
	
	<div id="dialog-confirm"></div>
	<?php }?>
</div>
	

<?php /* Smarty version Smarty-3.0.8, created on 2022-01-18 10:38:00
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/module_punch_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2167961e68a786dfdf3-55544042%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae80f058ac2ff6b11fb1844b6d17e2aa452ff26d' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/module_punch_list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2167961e68a786dfdf3-55544042',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="punch_list" class="custom_delay_padding grid_view custom_datatable_style">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
		<div>
	</div>
	<div id="punchlist"><?php echo $_smarty_tpl->getVariable('punchlist')->value;?>
</div>
	<div id="divpunchlist" class="hidden"></div>

	
	<div id="viewpunchlist" class="modal"></div>

	<div id="dialog-confirm"></div>
	<?php }?>
</div>
	

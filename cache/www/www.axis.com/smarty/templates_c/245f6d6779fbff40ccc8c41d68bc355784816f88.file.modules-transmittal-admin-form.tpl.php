<?php /* Smarty version Smarty-3.0.8, created on 2021-11-25 10:55:40
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-transmittal-admin-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29667619f5d9c2c1899-82898052%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '245f6d6779fbff40ccc8c41d68bc355784816f88' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-transmittal-admin-form.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29667619f5d9c2c1899-82898052',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="TAMs">
	<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
	<?php }?>
	<div id="TAMsDetails"></div>
	<div class="TAMTableGrid" id="TAMTableGrid">
	<?php echo $_smarty_tpl->getVariable('TAMTable')->value;?>

	</div>
</div>

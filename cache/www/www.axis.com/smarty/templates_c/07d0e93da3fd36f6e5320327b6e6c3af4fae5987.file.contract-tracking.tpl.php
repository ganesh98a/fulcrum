<?php /* Smarty version Smarty-3.0.8, created on 2022-06-09 06:37:17
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/contract-tracking.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2432762a178fd3e1c52-81460871%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07d0e93da3fd36f6e5320327b6e6c3af4fae5987' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/contract-tracking.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2432762a178fd3e1c52-81460871',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="Subcontract">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
	<div id="tracking-data"><?php echo $_smarty_tpl->getVariable('trackingdata')->value;?>
</div>
	<?php }?>

</div>

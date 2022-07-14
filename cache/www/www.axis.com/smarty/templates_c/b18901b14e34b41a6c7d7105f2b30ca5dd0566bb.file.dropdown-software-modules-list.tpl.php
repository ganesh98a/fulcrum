<?php /* Smarty version Smarty-3.0.8, created on 2022-03-28 10:23:06
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-software-modules-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:255506241706ae15a42-14448882%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b18901b14e34b41a6c7d7105f2b30ca5dd0566bb' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-software-modules-list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '255506241706ae15a42-14448882',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\block.php.php';
if (!is_callable('smarty_function_html_options')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\function.html_options.php';
?>
<?php if (!isset($_smarty_tpl->getVariable('dropdownSoftwareModuleListStyle',null,true,false)->value)||empty($_smarty_tpl->getVariable('dropdownSoftwareModuleListStyle',null,true,false)->value)){?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
$dropdownSoftwareModuleListStyle = '';<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }?>

<?php if (isset($_smarty_tpl->getVariable('dropdownSoftwareModuleListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownSoftwareModuleListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"ddl_software_module_id",'name'=>'ddl_software_module_id','options'=>$_smarty_tpl->getVariable('arrSoftwareModuleOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedSoftwareModule')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownSoftwareModuleListOnChange')->value),'style'=>($_smarty_tpl->getVariable('dropdownSoftwareModuleListStyle')->value)),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"ddl_software_module_id",'name'=>'ddl_software_module_id','options'=>$_smarty_tpl->getVariable('arrSoftwareModuleOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedSoftwareModule')->value,'style'=>($_smarty_tpl->getVariable('dropdownSoftwareModuleListStyle')->value)),$_smarty_tpl);?>

<?php }?>

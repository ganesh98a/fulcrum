<?php /* Smarty version Smarty-3.0.8, created on 2021-11-25 09:19:46
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-user-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4148619f4722b6ddc2-54609974%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d28fe19a0d1ccb382da5fe6eed6d45710e1022c' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-user-list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4148619f4722b6ddc2-54609974',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownUserListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownUserListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_id",'class'=>"gc_user_search",'name'=>'ddl_user_id','options'=>$_smarty_tpl->getVariable('arrUserOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedUser')->value),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_id",'class'=>"gc_user_search",'name'=>'ddl_user_id','options'=>$_smarty_tpl->getVariable('arrUserOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedUser')->value),$_smarty_tpl);?>

<?php }?>

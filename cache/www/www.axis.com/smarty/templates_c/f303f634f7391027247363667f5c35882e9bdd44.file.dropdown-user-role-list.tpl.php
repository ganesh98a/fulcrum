<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:29
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-user-role-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:512324557592bbfc93f11e5-22618789%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f303f634f7391027247363667f5c35882e9bdd44' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-user-role-list.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '512324557592bbfc93f11e5-22618789',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/data/sites/beta_myfulcrum_com_1/engine/include/smarty-3.0.8/plugins/function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownUserRoleListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownUserRoleListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_role_id",'name'=>'ddl_user_role_id','options'=>$_smarty_tpl->getVariable('arrUserRoles')->value,'selected'=>$_smarty_tpl->getVariable('selectedUserRole')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownUserRoleListOnChange')->value)),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_role_id",'name'=>'ddl_user_role_id','options'=>$_smarty_tpl->getVariable('arrUserRoles')->value,'selected'=>$_smarty_tpl->getVariable('selectedUserRole')->value),$_smarty_tpl);?>

<?php }?>

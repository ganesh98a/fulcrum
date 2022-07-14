<?php /* Smarty version Smarty-3.0.8, created on 2021-11-25 09:19:47
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-user-role-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19619619f4723245848-96271034%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99170cddba3f3dfd2c686cae6eb82f1d94b66482' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-user-role-list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19619619f4723245848-96271034',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownUserRoleListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownUserRoleListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_role_id",'name'=>'ddl_user_role_id','options'=>$_smarty_tpl->getVariable('arrUserRoles')->value,'selected'=>$_smarty_tpl->getVariable('selectedUserRole')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownUserRoleListOnChange')->value)),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_role_id",'name'=>'ddl_user_role_id','options'=>$_smarty_tpl->getVariable('arrUserRoles')->value,'selected'=>$_smarty_tpl->getVariable('selectedUserRole')->value),$_smarty_tpl);?>

<?php }?>

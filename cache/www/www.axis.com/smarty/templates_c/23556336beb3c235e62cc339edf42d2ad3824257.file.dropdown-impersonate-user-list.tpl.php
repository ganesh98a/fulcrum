<?php /* Smarty version Smarty-3.0.8, created on 2022-07-13 13:41:23
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-impersonate-user-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2458462ceaf6309d8f9-90065980%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23556336beb3c235e62cc339edf42d2ad3824257' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-impersonate-user-list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2458462ceaf6309d8f9-90065980',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownImpersonateUserListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownImpersonateUserListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"impersonated_user_id",'name'=>'impersonated_user_id','options'=>$_smarty_tpl->getVariable('arrImpersonatedUserOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedImpersonatedUser')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownImpersonateUserListOnChange')->value),'tabindex'=>"2"),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"impersonated_user_id",'name'=>'impersonated_user_id','options'=>$_smarty_tpl->getVariable('arrImpersonatedUserOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedImpersonatedUser')->value,'tabindex'=>"2"),$_smarty_tpl);?>

<?php }?>

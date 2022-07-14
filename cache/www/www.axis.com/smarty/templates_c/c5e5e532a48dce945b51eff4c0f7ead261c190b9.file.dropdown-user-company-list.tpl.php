<?php /* Smarty version Smarty-3.0.8, created on 2022-03-21 07:19:08
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-user-company-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19768623818dc8d7014-92009468%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5e5e532a48dce945b51eff4c0f7ead261c190b9' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-user-company-list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19768623818dc8d7014-92009468',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownUserCompanyListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownUserCompanyListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_company_id",'name'=>'ddl_user_company_id','options'=>$_smarty_tpl->getVariable('arrUserCompanyOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedUserCompany')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownUserCompanyListOnChange')->value)),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_company_id",'name'=>'ddl_user_company_id','options'=>$_smarty_tpl->getVariable('arrUserCompanyOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedUserCompany')->value),$_smarty_tpl);?>

<?php }?>

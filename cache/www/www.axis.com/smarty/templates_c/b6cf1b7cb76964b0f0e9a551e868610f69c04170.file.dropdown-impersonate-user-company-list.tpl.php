<?php /* Smarty version Smarty-3.0.8, created on 2022-07-13 13:41:23
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-impersonate-user-company-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2500362ceaf6300d6f3-44558775%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6cf1b7cb76964b0f0e9a551e868610f69c04170' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-impersonate-user-company-list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2500362ceaf6300d6f3-44558775',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownImpersonateUserCompanyListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownImpersonateUserCompanyListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"impersonated_user_company_id",'name'=>'impersonated_user_company_id','options'=>$_smarty_tpl->getVariable('arrImpersonatedUserCompanyOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedImpersonatedUserCompany')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownImpersonateUserCompanyListOnChange')->value),'tabindex'=>"1"),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"impersonated_user_company_id",'name'=>'impersonated_user_company_id','options'=>$_smarty_tpl->getVariable('arrImpersonatedUserCompanyOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedImpersonatedUserCompany')->value,'tabindex'=>"1"),$_smarty_tpl);?>

<?php }?>

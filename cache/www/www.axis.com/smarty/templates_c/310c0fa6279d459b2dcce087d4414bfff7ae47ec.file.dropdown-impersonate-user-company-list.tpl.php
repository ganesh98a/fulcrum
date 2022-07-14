<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:45
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-impersonate-user-company-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1895326682592bbfd9c90894-16076339%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '310c0fa6279d459b2dcce087d4414bfff7ae47ec' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-impersonate-user-company-list.tpl',
      1 => 1450949886,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1895326682592bbfd9c90894-16076339',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/data/sites/beta_myfulcrum_com_1/engine/include/smarty-3.0.8/plugins/function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownImpersonateUserCompanyListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownImpersonateUserCompanyListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"impersonated_user_company_id",'name'=>'impersonated_user_company_id','options'=>$_smarty_tpl->getVariable('arrImpersonatedUserCompanyOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedImpersonatedUserCompany')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownImpersonateUserCompanyListOnChange')->value),'tabindex'=>"1"),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"impersonated_user_company_id",'name'=>'impersonated_user_company_id','options'=>$_smarty_tpl->getVariable('arrImpersonatedUserCompanyOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedImpersonatedUserCompany')->value,'tabindex'=>"1"),$_smarty_tpl);?>

<?php }?>

<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:29
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-user-company-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1853915257592bbfc93d7a71-45209124%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f10a2d09acd91519d9089a31088525ec95744f3' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-user-company-list.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1853915257592bbfc93d7a71-45209124',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/data/sites/beta_myfulcrum_com_1/engine/include/smarty-3.0.8/plugins/function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownUserCompanyListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownUserCompanyListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_company_id",'name'=>'ddl_user_company_id','options'=>$_smarty_tpl->getVariable('arrUserCompanyOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedUserCompany')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownUserCompanyListOnChange')->value)),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_company_id",'name'=>'ddl_user_company_id','options'=>$_smarty_tpl->getVariable('arrUserCompanyOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedUserCompany')->value),$_smarty_tpl);?>

<?php }?>

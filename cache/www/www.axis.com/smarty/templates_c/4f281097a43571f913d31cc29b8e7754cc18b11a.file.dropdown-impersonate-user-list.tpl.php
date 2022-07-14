<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:45
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-impersonate-user-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:538158063592bbfd9cb2927-31704299%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4f281097a43571f913d31cc29b8e7754cc18b11a' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-impersonate-user-list.tpl',
      1 => 1450949886,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '538158063592bbfd9cb2927-31704299',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/data/sites/beta_myfulcrum_com_1/engine/include/smarty-3.0.8/plugins/function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownImpersonateUserListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownImpersonateUserListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"impersonated_user_id",'name'=>'impersonated_user_id','options'=>$_smarty_tpl->getVariable('arrImpersonatedUserOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedImpersonatedUser')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownImpersonateUserListOnChange')->value),'tabindex'=>"2"),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"impersonated_user_id",'name'=>'impersonated_user_id','options'=>$_smarty_tpl->getVariable('arrImpersonatedUserOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedImpersonatedUser')->value,'tabindex'=>"2"),$_smarty_tpl);?>

<?php }?>

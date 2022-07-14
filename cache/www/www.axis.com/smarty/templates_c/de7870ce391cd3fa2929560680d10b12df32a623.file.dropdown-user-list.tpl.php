<?php /* Smarty version Smarty-3.0.8, created on 2017-05-28 23:29:29
         compiled from "/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-user-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:588472749592bbfc9319699-20624274%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de7870ce391cd3fa2929560680d10b12df32a623' => 
    array (
      0 => '/data/sites/beta_myfulcrum_com_1/www/www.axis.com/include/templates/dropdown-user-list.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '588472749592bbfc9319699-20624274',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/data/sites/beta_myfulcrum_com_1/engine/include/smarty-3.0.8/plugins/function.html_options.php';
?>
<?php if (isset($_smarty_tpl->getVariable('dropdownUserListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownUserListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_id",'name'=>'ddl_user_id','options'=>$_smarty_tpl->getVariable('arrUserOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedUser')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownUserListOnChange')->value)),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"ddl_user_id",'name'=>'ddl_user_id','options'=>$_smarty_tpl->getVariable('arrUserOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedUser')->value),$_smarty_tpl);?>

<?php }?>

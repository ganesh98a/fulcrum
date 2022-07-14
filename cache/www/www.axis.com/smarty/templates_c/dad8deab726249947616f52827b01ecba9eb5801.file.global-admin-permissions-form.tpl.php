<?php /* Smarty version Smarty-3.0.8, created on 2022-03-21 07:19:14
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/global-admin-permissions-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4449623818e25f66b8-65985708%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dad8deab726249947616f52827b01ecba9eb5801' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/global-admin-permissions-form.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4449623818e25f66b8-65985708',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<?php $_template = new Smarty_Internal_Template("dropdown-software-modules-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<input id="btnResetPermissions" type="button" value="Reset To System Default Permissions" onclick="resetDefaultPermissions();" <?php echo $_smarty_tpl->getVariable('btnResetStyleParam')->value;?>
>
<br><br>
<?php $_template = new Smarty_Internal_Template("dropdown-projects-list.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<br><br>
<div id="divPermissionsMatrix"></div>
<br>
<br>

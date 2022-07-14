<?php /* Smarty version Smarty-3.0.8, created on 2022-04-13 07:20:38
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-projects-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3038162565da6687843-22290847%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7e6233acee0c1e830abc512381c75242097bdd3f' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/dropdown-projects-list.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3038162565da6687843-22290847',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\block.php.php';
if (!is_callable('smarty_function_html_options')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\function.html_options.php';
?>
<?php if (!isset($_smarty_tpl->getVariable('dropdownProjectListStyle',null,true,false)->value)||empty($_smarty_tpl->getVariable('dropdownProjectListStyle',null,true,false)->value)){?>
	<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

		$dropdownProjectListStyle = '';
		$template->assign("dropdownProjectListStyle", $dropdownProjectListStyle);
	<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }?>

<?php if (isset($_smarty_tpl->getVariable('dropdownProjectListOnChange',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('dropdownProjectListOnChange',null,true,false)->value)){?>
<?php echo smarty_function_html_options(array('id'=>"project_id",'name'=>'project_id','options'=>$_smarty_tpl->getVariable('arrProjectOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedProject')->value,'onchange'=>($_smarty_tpl->getVariable('dropdownProjectListOnChange')->value),'style'=>($_smarty_tpl->getVariable('dropdownProjectListStyle')->value)),$_smarty_tpl);?>

<?php }else{ ?>
<?php echo smarty_function_html_options(array('id'=>"project_id",'name'=>'project_id','options'=>$_smarty_tpl->getVariable('arrProjectOptions')->value,'selected'=>$_smarty_tpl->getVariable('selectedProject')->value,'style'=>($_smarty_tpl->getVariable('dropdownProjectListStyle')->value)),$_smarty_tpl);?>

<?php }?>

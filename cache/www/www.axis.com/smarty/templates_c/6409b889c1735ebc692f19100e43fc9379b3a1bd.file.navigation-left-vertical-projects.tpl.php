<?php /* Smarty version Smarty-3.0.8, created on 2017-06-19 19:58:29
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/navigation-left-vertical-projects.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13766524495947df8dcc6bd8-44361412%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6409b889c1735ebc692f19100e43fc9379b3a1bd' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/navigation-left-vertical-projects.tpl',
      1 => 1496926196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13766524495947df8dcc6bd8-44361412',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/myfulcrum/engine/include/smarty-3.0.8/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/myfulcrum/engine/include/smarty-3.0.8/plugins/modifier.truncate.php';
?>
<?php if (isset($_smarty_tpl->getVariable('showProjectNavBox',null,true,false)->value)&&$_smarty_tpl->getVariable('showProjectNavBox')->value){?>

												<div id="navBoxProject" class="sidebarBox projectNavBox">
													<div class="arrowlistmenu">
<?php if (count($_smarty_tpl->getVariable('arrActiveProjects')->value)>0){?>
														<div class="menuheader expandable">Active Projects</div>
<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectTypeIndex')->value==0){?>
														<div id="0_selected" name="selectedProjectDiv" class="selectedProject"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
<img alt="" src="/images/navigation/left-nav-arrow-green.gif"></div>
<?php }else{ ?>
														<div id="0_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
</div>
<?php }?>
														<ul class="categoryitems">
<?php  $_smarty_tpl->tpl_vars['projectName'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['project_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrActiveProjects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['projectName']->key => $_smarty_tpl->tpl_vars['projectName']->value){
 $_smarty_tpl->tpl_vars['project_id']->value = $_smarty_tpl->tpl_vars['projectName']->key;
?>
<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectId')->value!=$_smarty_tpl->tpl_vars['project_id']->value){?>
															<li onclick="navigationProjectSelected(0, '<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
', '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['projectName']->value,'url');?>
');"><a class="projectLinks" href="#"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['projectName']->value,27);?>
</a></li>
<?php }?>
<?php }} ?>
														</ul>
<?php }?>
<?php if (count($_smarty_tpl->getVariable('arrBiddingProjects')->value)>0){?>
														<div class="menuheader expandable">Bidding Projects</div>
<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectTypeIndex')->value==1){?>
														<div id="1_selected" name="selectedProjectDiv" class="selectedProject"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
<img alt="" src="/images/navigation/left-nav-arrow-green.gif"></div>
<?php }else{ ?>
														<div id="1_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
</div>
<?php }?>
														<ul class="categoryitems">
<?php  $_smarty_tpl->tpl_vars['projectName'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['project_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrBiddingProjects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['projectName']->key => $_smarty_tpl->tpl_vars['projectName']->value){
 $_smarty_tpl->tpl_vars['project_id']->value = $_smarty_tpl->tpl_vars['projectName']->key;
?>
<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectId')->value!=$_smarty_tpl->tpl_vars['project_id']->value){?>
															<li onclick="navigationProjectSelected(1, '<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
', '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['projectName']->value,'url');?>
');"><a href="#"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['projectName']->value,27);?>
</a></li>
<?php }?>
<?php }} ?>
														</ul>
<?php }?>
<?php if (count($_smarty_tpl->getVariable('arrCompletedProjects')->value)>0){?>
														<div class="menuheader expandable">Completed Projects</div>
<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectTypeIndex')->value==2){?>
														<div id="2_selected" name="selectedProjectDiv" class="selectedProject"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
<img alt="" src="/images/navigation/left-nav-arrow-green.gif"></div>
<?php }else{ ?>
														<div id="2_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
</div>
<?php }?>
														<ul class="categoryitems">
<?php  $_smarty_tpl->tpl_vars['projectName'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['project_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrCompletedProjects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['projectName']->key => $_smarty_tpl->tpl_vars['projectName']->value){
 $_smarty_tpl->tpl_vars['project_id']->value = $_smarty_tpl->tpl_vars['projectName']->key;
?>
<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectId')->value!=$_smarty_tpl->tpl_vars['project_id']->value){?>
															<li onclick="navigationProjectSelected(2, '<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
', '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['projectName']->value,'url');?>
');"><a href="#"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['projectName']->value,27);?>
</a></li>
<?php }?>
<?php }} ?>
														</ul>
<?php }?>
<?php if (count($_smarty_tpl->getVariable('arrOtherProjects')->value)>0){?>
														<div class="menuheader expandable">Other Projects</div>
<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectTypeIndex')->value==3){?>
														<div id="3_selected" name="selectedProjectDiv" class="selectedProject"><?php echo $_smarty_tpl->getVariable('currentlySelectedProjectName')->value;?>
</div>
<?php }else{ ?>
														<div id="3_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;"><?php echo $_smarty_tpl->getVariable('currentlySelectedProjectName')->value;?>
</div>
<?php }?>
														<ul class="categoryitems">
<?php  $_smarty_tpl->tpl_vars['projectName'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['project_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrOtherProjects')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['projectName']->key => $_smarty_tpl->tpl_vars['projectName']->value){
 $_smarty_tpl->tpl_vars['project_id']->value = $_smarty_tpl->tpl_vars['projectName']->key;
?>
<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectId')->value!=$_smarty_tpl->tpl_vars['project_id']->value){?>
															<li onclick="navigationProjectSelected(3, '<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
', '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['projectName']->value,'url');?>
');"><a href="#"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['projectName']->value,27);?>
</a></li>
<?php }?>
<?php }} ?>
														</ul>
<?php }?>
													</div>
												</div>
												<div class="leftNavSpacer">&nbsp;</div>
<?php }?>

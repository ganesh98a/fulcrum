<?php /* Smarty version Smarty-3.0.8, created on 2022-07-13 13:41:23
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/navigation-left-vertical-projects.tpl" */ ?>
<?php /*%%SmartyHeaderCode:92962ceaf6311c0d1-12464984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '133e92103673731ffa3f346ba7668ff63d15f038' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/navigation-left-vertical-projects.tpl',
      1 => 1656945835,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92962ceaf6311c0d1-12464984',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\modifier.escape.php';
if (!is_callable('smarty_modifier_truncate')) include 'C:\xampp5.6\htdocs\full_delay\fulcrum\engine\include\smarty-3.0.8\plugins\modifier.truncate.php';
?>
<?php if (isset($_smarty_tpl->getVariable('showProjectNavBox',null,true,false)->value)&&$_smarty_tpl->getVariable('showProjectNavBox')->value){?>
	<div id="navBoxProject" class="sidebarBox projectNavBox">
		<div class="arrowlistmenu">
			<?php if (count($_smarty_tpl->getVariable('arrActiveProjects')->value)>0){?>
				<input type="hidden" id="actcurprj" value="<?php echo $_smarty_tpl->getVariable('currentlySelectedProjectName')->value;?>
">
				<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectTypeIndex')->value==0){?>
					<div class="menuheader expandable <?php echo $_smarty_tpl->getVariable('menuActiveClass')->value;?>
">Active Projects</div>
					<div id="0_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
<span style="margin-left:5%;"/></div>
					<ul class="categoryitems" <?php echo $_smarty_tpl->getVariable('cssDisplay')->value;?>
>
				<?php }else{ ?>
					<div class="menuheader expandable">Active Projects</div>
					<div id="0_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
</div>
					<ul class="categoryitems">
				<?php }?>
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
');"><a class="projectLinks" href="javascript:void(0);" data-groupIndex = "0" data-project_id ='<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
' data-encodedProjectName = '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['projectName']->value,'url');?>
'><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['projectName']->value,27);?>
</a></li>
						<?php }?>
					<?php }} ?>
				</ul>
			<?php }?>
			<?php if (count($_smarty_tpl->getVariable('arrBiddingProjects')->value)>0){?>
				<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectTypeIndex')->value==1){?>
					<div class="menuheader expandable <?php echo $_smarty_tpl->getVariable('menuActiveClass')->value;?>
">Bidding Projects</div>
					<div id="1_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
<span style="margin-left:5%;"/></div><!-- <img alt="" src="/images/navigation/left-nav-arrow-green.gif"> -->
					<ul class="categoryitems" <?php echo $_smarty_tpl->getVariable('cssDisplay')->value;?>
>
				<?php }else{ ?>
					<div class="menuheader expandable">Bidding Projects</div>
					<div id="1_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
</div>
					<ul class="categoryitems" >
				<?php }?>
				
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
');"><a class="projectLinks" href="javascript:void(0);" data-groupIndex = "1" data-project_id ='<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
' data-encodedProjectName = '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['projectName']->value,'url');?>
'><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['projectName']->value,27);?>
</a></li>
						<?php }?>
					<?php }} ?>
				</ul>
			<?php }?>
			<?php if (count($_smarty_tpl->getVariable('arrCompletedProjects')->value)>0){?>
				<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectTypeIndex')->value==2){?>
					<div class="menuheader expandable <?php echo $_smarty_tpl->getVariable('menuActiveClass')->value;?>
">Completed Projects</div>
					<div id="2_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
<span style="margin-left:5%;"/></div>
					<ul class="categoryitems" <?php echo $_smarty_tpl->getVariable('cssDisplay')->value;?>
>
				<?php }else{ ?>
					<div class="menuheader expandable">Completed Projects</div>
					<div id="2_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('currentlySelectedProjectName')->value),27);?>
</div>
					<ul class="categoryitems" >
				<?php }?>
				
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
');"><a class="projectLinks" href="javascript:void(0);" data-groupIndex = "2" data-project_id ='<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
' data-encodedProjectName = '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['projectName']->value,'url');?>
'><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['projectName']->value,27);?>
</a></li>
						<?php }?>
					<?php }} ?>
				</ul>
			<?php }?>
			<?php if (count($_smarty_tpl->getVariable('arrOtherProjects')->value)>0){?>
				<?php if ($_smarty_tpl->getVariable('currentlySelectedProjectTypeIndex')->value==3){?>
					<div class="menuheader expandable <?php echo $_smarty_tpl->getVariable('menuActiveClass')->value;?>
">Other Projects</div>
					<div id="3_selected" name="selectedProjectDiv" class="selectedProject" onclick="goToDashboard();"><?php echo $_smarty_tpl->getVariable('currentlySelectedProjectName')->value;?>
<span style="margin-left:5%;"/></div>
				<ul class="categoryitems" <?php echo $_smarty_tpl->getVariable('cssDisplay')->value;?>
>
				<?php }else{ ?>
					<div class="menuheader expandable">Other Projects</div>
					<div id="3_selected" name="selectedProjectDiv" class="selectedProject" style="display:none;" onclick="goToDashboard();"><?php echo $_smarty_tpl->getVariable('currentlySelectedProjectName')->value;?>
</div>
				<ul class="categoryitems" >
				<?php }?>				
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
');"><a class="projectLinks" href="javascript:void(0);" data-groupIndex = "3" data-project_id ='<?php echo $_smarty_tpl->tpl_vars['project_id']->value;?>
' data-encodedProjectName = '<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['projectName']->value,'url');?>
'><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['projectName']->value,27);?>
</a></li>
						<?php }?>
					<?php }} ?>
				</ul>
			<?php }?>
		</div>
	</div>
	<div class="leftNavSpacer">&nbsp;</div>
<?php }?>

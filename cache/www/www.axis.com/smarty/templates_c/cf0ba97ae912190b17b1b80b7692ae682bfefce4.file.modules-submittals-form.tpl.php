<?php /* Smarty version Smarty-3.0.8, created on 2022-05-16 08:00:41
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-submittals-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:175216281e889362f69-32735749%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf0ba97ae912190b17b1b80b7692ae682bfefce4' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-submittals-form.tpl',
      1 => 1639975737,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '175216281e889362f69-32735749',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="SUBMITTAL">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
	<div>
		<?php if (($_smarty_tpl->getVariable('userCanManageSubmittals')->value)){?>
		 <input type="button" onclick="Submittals__loadCreateSuDialog(null);setTimeout('Submittals__automaticRecipient(<?php echo $_smarty_tpl->getVariable('primary_contact_id')->value;?>
,\'<?php echo $_smarty_tpl->getVariable('primary_name')->value;?>
\')', 2000);" value="Create A New Submittal" style="margin-bottom:15px">
		 <span style="padding: 0 20px;">or</span>

		 <span id="subDraftDropDown"><?php echo $_smarty_tpl->getVariable('ddlSubmittalDrafts')->value;?>
</span>
		 <span style="padding: 0 20px;">&nbsp;</span>
		<?php }?>

		<!--span style="padding: 0 20px;">&nbsp;</span>
		<span class="fakeHref" onclick="Submittals__generateSubmittalsListViewPdf();"><img src="/images/printer.gif" style="vertical-align: top;"> Print Submittal List as PDF</span>
		<span style="padding: 0 20px;">&nbsp;</span-->
		<select onchange="Submittals__performAction(this);">
			<option value="-1">Submittal Actions</option>
			<option value="print_list_view_pdf">Print Submittal List as PDF</option>
		</select>

		<a tabindex="52" href="/modules-submittals-registry-form.php">Submittal Registry</a>

	</div>
	<div id="suTable"><?php echo $_smarty_tpl->getVariable('suTable')->value;?>
</div>
	<div id="suDetails"><?php echo $_smarty_tpl->getVariable('suDetails')->value;?>
</div>
	<div id="divCreateSu" class="hidden"></div>
	<input type="hidden" id="active_submittal_id" value="">
	<input type="hidden" id="active_submittal_draft_id" value="">
	<input type="hidden" id="active_submittal_notification_id" value="">
	<div id="dialog-confirmation"></div>
	<?php }?>
</div>

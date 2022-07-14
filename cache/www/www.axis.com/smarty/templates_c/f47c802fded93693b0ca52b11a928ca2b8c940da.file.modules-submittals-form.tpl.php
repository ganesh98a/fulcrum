<?php /* Smarty version Smarty-3.0.8, created on 2017-06-19 19:58:29
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/modules-submittals-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:947627195947df8db9a8d5-64306345%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f47c802fded93693b0ca52b11a928ca2b8c940da' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/modules-submittals-form.tpl',
      1 => 1497853082,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '947627195947df8db9a8d5-64306345',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="SUBMITTAL">
	<div>
		<input type="button" onclick="Submittals__loadCreateSuDialog(null);" value="Create A New Submittal" style="margin-bottom:15px">
		<span style="padding: 0 20px;">or</span>
		<?php echo $_smarty_tpl->getVariable('ddlSubmittalDrafts')->value;?>

		<span style="padding: 0 20px;">&nbsp;</span>
		<!--span style="padding: 0 20px;">&nbsp;</span>
		<span class="fakeHref" onclick="Submittals__generateSubmittalsListViewPdf();"><img src="/images/printer.gif" style="vertical-align: top;"> Print Submittal List as PDF</span>
		<span style="padding: 0 20px;">&nbsp;</span-->
		<select onchange="Submittals__performAction(this);">
			<option value="-1">Submittal Actions</option>
			<option value="print_list_view_pdf">Print Submittal List as PDF</option>
		</select>
	</div>
	<div id="suTable"><?php echo $_smarty_tpl->getVariable('suTable')->value;?>
</div>
	<div id="suDetails"><?php echo $_smarty_tpl->getVariable('suDetails')->value;?>
</div>
	<div id="divCreateSu" class="hidden"><?php echo $_smarty_tpl->getVariable('createSuDialog')->value;?>
</div>
	<input type="hidden" id="active_submittal_id" value="">
	<input type="hidden" id="active_submittal_draft_id" value="">
	<input type="hidden" id="active_submittal_notification_id" value="">
</div>

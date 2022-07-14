<?php /* Smarty version Smarty-3.0.8, created on 2017-06-19 19:47:05
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/modules-jobsite-delay-logs-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12680648165947dce1a527e9-89539634%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5312bc53371a97d9dfb589248f97921edc89365' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/modules-jobsite-delay-logs-form.tpl',
      1 => 1497865315,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12680648165947dce1a527e9-89539634',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="RFI">
	<div>
		<input type="button" onclick="" value="Create Delay" style="margin-bottom:15px">
		<!--<span style="padding:0 20px">or</span>
		<?php echo $_smarty_tpl->getVariable('ddlRequestForInformationDrafts')->value;?>
-->
		<span style="padding: 0 20px;">&nbsp;</span>
		<!--span style="padding: 0 20px;">&nbsp;</span>
		<span class="fakeHref" onclick="Submittals__generateSubmittalsListViewPdf();"><img src="/images/printer.gif" style="vertical-align: top;"> Print Submittal List as PDF</span>
		<span style="padding: 0 20px;">&nbsp;</span-->
		<select onchange="Submittals__performAction(this);">
			<option value="-1">Delays Log Actions</option>
			<option value="print_list_view_pdf">Print Delays List as PDF</option>
		</select>
	</div>
	<div id="rfiTable"><?php echo $_smarty_tpl->getVariable('rfiTable')->value;?>
</div>
	<div id="rfiDetails"><?php echo $_smarty_tpl->getVariable('rfiDetails')->value;?>
</div>
	<div id="divCreateRfi" class="hidden"><?php echo $_smarty_tpl->getVariable('createRfiDialog')->value;?>
</div>
	<input type="hidden" id="active_request_for_information_id" value="">
	<input type="hidden" id="active_request_for_information_draft_id" value="">
	<input type="hidden" id="active_request_for_information_notification_id" value="">
</div>

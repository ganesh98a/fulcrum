<?php /* Smarty version Smarty-3.0.8, created on 2017-06-19 11:41:53
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/modules-requests-for-information-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:125327815759476b29aace45-05814044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db943fd1bb183fe0c0d26e2dbde58718f6119bab' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/modules-requests-for-information-form.tpl',
      1 => 1497354374,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '125327815759476b29aace45-05814044',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="RFI">
	<div>
		<input type="button" onclick="RFIs__loadCreateRfiDialog(null);" value="Create A New RFI" style="margin-bottom:15px">
		<span style="padding:0 20px">or</span>
		<?php echo $_smarty_tpl->getVariable('ddlRequestForInformationDrafts')->value;?>

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

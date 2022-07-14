<?php /* Smarty version Smarty-3.0.8, created on 2022-07-12 15:14:06
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-requests-for-information-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2196562cd739e4b50e4-07060400%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb6acde4ee8526b7673cc0eb8bfc1ac7de8c9a16' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/modules-requests-for-information-form.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2196562cd739e4b50e4-07060400',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="RFI">
<?php if ((isset($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value))&&!empty($_smarty_tpl->getVariable('htmlMessages',null,true,false)->value)){?>
		<div><?php echo $_smarty_tpl->getVariable('htmlMessages')->value;?>
</div>
	<?php }else{ ?>
	<?php if (($_smarty_tpl->getVariable('userCanManageRFIs')->value)){?>
	<div>
		<input type="button" onclick="RFIs__loadCreateRfiDialog(null);setTimeout('RFIs__automaticRecipient(<?php echo $_smarty_tpl->getVariable('primary_contact_id')->value;?>
,\'<?php echo $_smarty_tpl->getVariable('primary_name')->value;?>
\')', 2000);" value="Create A New RFI" style="margin-bottom:15px">
		<span style="padding:0 20px">or</span>
		<span id="rfiDraftDropDown"><?php echo $_smarty_tpl->getVariable('ddlRequestForInformationDrafts')->value;?>
</span>
	</div>
	<?php }?>
	
	<div id="rfiTable"><?php echo $_smarty_tpl->getVariable('rfiTable')->value;?>
</div>
	<div id="rfiDetails"><?php echo $_smarty_tpl->getVariable('rfiDetails')->value;?>
</div>
	<div id="divCreateRfi" class="hidden"></div>
	<input type="hidden" id="active_request_for_information_id" value="">
	<input type="hidden" id="active_request_for_information_draft_id" value="">
	<input type="hidden" id="active_request_for_information_notification_id" value="">
	<div id="dialog-confirmation"></div>
	<?php }?>

</div>

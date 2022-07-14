<?php /* Smarty version Smarty-3.0.8, created on 2017-06-17 14:30:41
         compiled from "/var/www/myfulcrum/www/www.axis.com/include/templates/modules-contacts-manager-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10431999515944efb9364431-48560978%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c503d434be7720797ae7be7889b3bda3a60f7248' => 
    array (
      0 => '/var/www/myfulcrum/www/www.axis.com/include/templates/modules-contacts-manager-form.tpl',
      1 => 1441831398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10431999515944efb9364431-48560978',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo $_smarty_tpl->getVariable('contactsManagerHelpHints')->value;?>


<h2>Administration</h2>

<div style="padding-bottom:15px"><input id="btnCreateNewCompany" type="button" value="Create New Company" onclick="loadCreateContactCompanyDialog();"></div>

<?php echo $_smarty_tpl->getVariable('ddlContactCompaniesListDiv')->value;?>
 <input id="refreshCompanyDataId" style="display:none;" type="button" value="Refresh Company Data" onclick="ddlContactCompanyChanged();">
<table width="100%" cellpadding="3" style="margin-top:10px; margin-bottom:10px;">
	<tr valign="top">
		<th style="padding-top:7px;" nowrap>COMPANY/VENDOR NAME:<div id="help-company-name" class="help-hint">?</div></th>
		<td style="padding-top:7px;"><input name="company" id="company" style="width:300px;"></td>
		<td><input id="btnCompanySearch" type="button" value="Search"></td>
		<td><input id="btnManageCompany" type="button" value="Manage Company"></td>
		<td width="100%" style="text-align:right; padding-right:10px;">&nbsp;</td>
	</tr>
</table>

<input name="contact_company_id" id="contact_company_id" type="hidden">
<input name="myCompanyName" id="myCompanyName" type="hidden" value="<?php echo $_smarty_tpl->getVariable('myCompanyName')->value;?>
">

<table width="100%">
	<tr valign="top">
		<td colspan="2">
			<div id="divCompanyInfo" style="display:none;"></div>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2">
			<div id="divOfficeDetails" style="display:none;" class="fieldsetLeft"></div>
			<div id="divOfficesList" style="display:none;" class="fieldsetLeft"></div>
		</td>
	</tr>
	<tr valign="top">
		<td width="300px" style="padding-right:20px;">
			<div id="divEmployees" style="display:none;"></div>
		</td>
		<td>
			<div id="divContactInformation" style="display:none;"></div>

			<div id="divContactPermissions" style="display:none;"></div>
		</td>
	</tr>
</table>
<div id="dialogHelp"></div>

<div id="divCreateContactCompanyDialog" class="hidden"></div>
<div id="divCreateContactCompanyOfficeDialog" class="hidden"></div>
<?php /* Smarty version Smarty-3.0.8, created on 2022-03-21 07:19:08
         compiled from "C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/admin-user-company-information-form-inputs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8465623818dcad3bd4-98324087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c18b81e4e63e7c174217c32daa3f14de03a4a91b' => 
    array (
      0 => 'C:/xampp5.6/htdocs/full_delay/fulcrum/www/www.axis.com/include/templates/admin-user-company-information-form-inputs.tpl',
      1 => 1631167918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8465623818dcad3bd4-98324087',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<table border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
	<tr>
		<td colspan="2" nowrap><strong>Required Customer (User Company) Information</strong></td>
	</tr>

	<tr>
		<td width="10%" nowrap>Customer Name (User Company Name)</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="10%"><input maxlength="50" size="25" name="user_company_name" value="<?php echo $_smarty_tpl->getVariable('user_company_name')->value;?>
" tabindex="108" style="width:150px;"></td>
					<td>* Required Field</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td nowrap>Employer Identification Number (Fed Tax ID/EIN/SSN)&nbsp;</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="10%"><input maxlength="50" size="25" name="employer_identification_number" value="<?php echo $_smarty_tpl->getVariable('employer_identification_number')->value;?>
" tabindex="109" style="width:150px;"></td>
					<td>* Required Field</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td nowrap>Construction License Number</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><input type="text" name="construction_license_number" value="<?php echo $_smarty_tpl->getVariable('construction_license_number')->value;?>
" maxlength="14" size="25" tabindex="110" style="width:150px;"></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td nowrap>Construction License Number Expiration Date&nbsp;</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input class="datepicker auto-hint" title="MM/DD/YYYY" type="text" name="construction_license_number_expiration_date" value="<?php echo $_smarty_tpl->getVariable('construction_license_number_expiration_date')->value;?>
" maxlength="14" size="25" tabindex="111" style="width:150px;">
					</td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	<td>Company Logo</td>
	<td>
	<?php echo $_smarty_tpl->getVariable('uploadWindow')->value;?>

		<div id="uploaderJobsitePhotos"></div>
		<?php echo $_smarty_tpl->getVariable('uploaderPhotos')->value;?>

		<ul id="record_list_container--manage-jobsite_photo-record" class="ulUploadedFiles" style="margin:10px 0 5px 0px"><?php echo $_smarty_tpl->getVariable('liUploadedPhotos')->value;?>
</ul>
		<span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('rfi_draft_help');">(?)</span><span id="rfi_draft_help" class="displayNone verticalAlignBottom"> Note : Only gif, jpg, jpeg, png images are allowed. Image size allowed from 150x40 to 500x100 .</span>
		<input id="jobsite_photo_file_manager_folder_id" type="hidden" value="$jobsite_photo_file_manager_folder_id">
		
		<input type="hidden" id="gc_logo" name="gc_logo" value="<?php echo $_smarty_tpl->getVariable('image_manager_image_id')->value;?>
">
		</td>
	</tr>
	<tr>
		<td nowrap style="border-top: solid 0px #ccc;border-bottom: solid 0px #ccc;border-left: solid 0px #ccc;">Customer Status</td>
		<td style="border-top: solid 0px #ccc;border-right: solid 0px #ccc;border-bottom: solid 0px #ccc;">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input onclick="checkAllPayingCustomerModules(this);" type="checkbox" name="paying_customer_flag" <?php echo $_smarty_tpl->getVariable('paying_customer_flag')->value;?>
 maxlength="14" size="25" tabindex="112">Paying Customer (Y/N)
					</td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td nowrap valign="top">Software Modules</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="input checkbox text-align:left !important;">
						<?php echo $_smarty_tpl->getVariable('htmlCheckboxes')->value;?>

					</td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td colspan="2" height="5"></td>
	</tr>

</table>


<table border="0" cellspacing="2" cellpadding="2" style="border: dashed 2px #ccc;">
	<tr>
		<td colspan="2" nowrap><strong>Required Customer (User Company) Information</strong></td>
	</tr>

	<tr>
		<td width="10%" nowrap>Customer Name (User Company Name)</td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="10%"><input maxlength="50" size="25" name="user_company_name" value="{$user_company_name}" tabindex="108" style="width:150px;"></td>
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
					<td width="10%"><input maxlength="50" size="25" name="employer_identification_number" value="{$employer_identification_number}" tabindex="109" style="width:150px;"></td>
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
					<td><input type="text" name="construction_license_number" value="{$construction_license_number}" maxlength="14" size="25" tabindex="110" style="width:150px;"></td>
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
						{*html_select_date prefix='construction_license_number_expiration_date' time="0000-00-00" month_empty='' year_empty='' start_year='+0' end_year='+10' display_days=true*}
						<input class="datepicker auto-hint" title="MM/DD/YYYY" type="text" name="construction_license_number_expiration_date" value="{$construction_license_number_expiration_date}" maxlength="14" size="25" tabindex="111" style="width:150px;">
					</td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	<td>Company Logo</td>
	<td>
	{$uploadWindow}
		<div id="uploaderJobsitePhotos"></div>
		{$uploaderPhotos}
		<ul id="record_list_container--manage-jobsite_photo-record" class="ulUploadedFiles" style="margin:10px 0 5px 0px">{$liUploadedPhotos}</ul>
		<span class="fakeHref verticalAlignBottom" onclick="showHideDomElement('rfi_draft_help');">(?)</span><span id="rfi_draft_help" class="displayNone verticalAlignBottom"> Note : Only gif, jpg, jpeg, png images are allowed. Image size allowed from 150x40 to 500x100 .</span>
		<input id="jobsite_photo_file_manager_folder_id" type="hidden" value="$jobsite_photo_file_manager_folder_id">
		
		<input type="hidden" id="gc_logo" name="gc_logo" value="{$image_manager_image_id}">
		</td>
	</tr>
	<tr>
		<td nowrap style="border-top: solid 0px #ccc;border-bottom: solid 0px #ccc;border-left: solid 0px #ccc;">Customer Status</td>
		<td style="border-top: solid 0px #ccc;border-right: solid 0px #ccc;border-bottom: solid 0px #ccc;">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input onclick="checkAllPayingCustomerModules(this);" type="checkbox" name="paying_customer_flag" {$paying_customer_flag} maxlength="14" size="25" tabindex="112">Paying Customer (Y/N)
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
						{*html_checkboxes name='software_modules' options=$arrSoftwareModuleCheckboxes selected=$arrSelectedSoftwareModuleCheckboxes separator='<br>' labels=false*}
						{$htmlCheckboxes}
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

<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * This page has three states:
 * 1) Create a new Contact Company Office
 * 2) Update Existing Contact Company Office
 * 3) Display Contact Company Office (not updateable in this mode/view
 */

// Start with: $contactCompanyOffice
/* @var $contactCompanyOffice ContactCompanyOffice */

// Default data points
$contact_company_id = '';
$office_nickname = '';
$address_line_1 = '';
$address_line_2 = '';
$address_line_3 = '';
$address_line_4 = '';
$address_city = '';
$address_county = '';
$address_state_or_region = '';
$address_postal_code = '';
$address_postal_code_extension = '';
$address_country = 'United States';
$head_quarters_flag = 'N';
$btnSaveOfficeText = 'Create New Office';
$business_phone_id  = 0;
$formattedBusinessPhoneNumber = '';
$business_fax_id  = 0;
$formattedBusinessFaxNumber = '';

if ($contactCompanyOffice && ($contactCompanyOffice instanceof ContactCompanyOffice)) {
	// This value may already be set
	$contact_company_office_id = (int) $contactCompanyOffice->contact_company_office_id;

	$contact_company_id = $contactCompanyOffice->contact_company_id;
	$office_nickname = $contactCompanyOffice->office_nickname;
	$address_line_1 = $contactCompanyOffice->address_line_1;
	$address_line_2 = $contactCompanyOffice->address_line_2;
	$address_city = $contactCompanyOffice->address_city;
	$address_state_or_region = $contactCompanyOffice->address_state_or_region;
	$address_postal_code = $contactCompanyOffice->address_postal_code;
	$country_code = $contactCompanyOffice->address_country;
	$address_country = Address::convertCountryCodeToCountry('location', $country_code);
	$head_quarters_flag = $contactCompanyOffice->head_quarters_flag;
	$btnSaveOfficeText = 'Save Office Changes';

	$businessPhoneNumber = $contactCompanyOffice->getBusinessPhoneNumber();
	/* @var $businessPhoneNumber ContactCompanyOfficePhoneNumber */
	if ($businessPhoneNumber) {
		$business_phone_id  = $businessPhoneNumber->contact_company_office_phone_number_id;
		$formattedBusinessPhoneNumber = $businessPhoneNumber->getFormattedPhoneNumber();
	}

	$businessFaxNumber = $contactCompanyOffice->getBusinessFaxNumber();
	/* @var $businessFaxNumber ContactCompanyOfficePhoneNumber */
	if ($businessFaxNumber) {
		$business_fax_id  = $businessFaxNumber->contact_company_office_phone_number_id;
		$formattedBusinessFaxNumber = $businessFaxNumber->getFormattedPhoneNumber();
	}
}

?>
<?php if (($mode == 'create') || ($mode == 'update')) { ?>
<!--<fieldset>-->
<div class="contactSectionHeader">Office Information</div>
<?php } ?>
<form class="addressForm" id="frmOfficeDetails--<?=$contact_company_office_id;?>" name="frmOfficeDetails--<?=$contact_company_office_id;?>">
<input id="selectedOfficeId" name="selectedOfficeId" type="hidden" value="<?php echo $contact_company_office_id; ?>">
<table border="0" class="contactSectionTable" >
<tr>
<td>
<table>
<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label class="contactLabelImp">Office Nickname:</label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {
	$officeNickname = '<input name="office_nickname" id="manage-contact_company_office-record--contact_company_offices--office_nickname--'.$contact_company_office_id.'" type="text" class="addressTmp" value="'.$office_nickname.'">';
} else {
	$officeNickname = $office_nickname;
}

echo $officeNickname;
?>
</td>
</tr>
<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label class="contactLabelImp">Address Line 1:</label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {
	$addressLineOne = '<input name="address_line_1" id="manage-contact_company_office-record--contact_company_offices--address_line_1--'.$contact_company_office_id.'" type="text" class="addressTmp" value="'.$address_line_1.'">';
} else {
	$addressLineOne = $address_line_1;
}

echo $addressLineOne;
?>
</td>
</tr>

<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label class="contactLabelImp">Address Line 2:</label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {
	$addressLineTwo = '<input name="address_line_2" id="manage-contact_company_office-record--contact_company_offices--address_line_2--'.$contact_company_office_id.'" type="text" class="addressTmp" value="'.$address_line_2.'">';
} else {
	$addressLineTwo = $address_line_2;
}

echo $addressLineTwo;
?>
</td>
</tr>

<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label class="contactLabelImp">Zip:</label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {

	$addressPostalCode = <<<END_HTML_CONTENT
<input id="manage-contact_company_office-record--contact_company_offices--address_postal_code--$contact_company_office_id" class="zipTmp" name="address_postal_code" onchange="checkAddressPostalCode('manage-contact_company_office-record', '$contact_company_office_id');" type="text" value="$address_postal_code">
END_HTML_CONTENT;

} else {
	$addressPostalCode = $address_postal_code;
}

echo $addressPostalCode;
?>
</td>
</tr>

<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label class="contactLabelImp">City:</label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {

	$addressCity = <<<END_HTML_CONTENT
<input id="manage-contact_company_office-record--contact_company_offices--address_city--$contact_company_office_id" class="addressTmp" name="address_city" type="text" value="$address_city">
END_HTML_CONTENT;

} else {
	$addressCity = $address_city;
}

echo $addressCity;
?>
</td>
</tr>

<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label class="contactLabelImp">State:</label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {

	$addressStateOrRegion = <<<END_HTML_CONTENT
<input id="manage-contact_company_office-record--contact_company_offices--address_state_or_region--$contact_company_office_id" class="stateTmp" name="address_state_or_region" type="text" value="$address_state_or_region">
END_HTML_CONTENT;

} else {
	$addressStateOrRegion = $address_state_or_region;
}

echo $addressStateOrRegion;
?>
</td>
</tr>

<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label class="contactLabelImp">Country:</label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {
	require_once('page-components/select_country_list.php');
	$addressCountry = getCountrySelectBox($address_country);
} else {
	$addressCountry = $address_country;
}

echo $addressCountry;
?>
</td>
</tr>

<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label class="contactLabelImp">HeadQuarters:</label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {
	$headQuartersFlag = '<select id="manage-contact_company_office-record--contact_company_offices--head_quarters_flag--'.$contact_company_office_id.'"" name="headerquarters">';
	if ($head_quarters_flag == "Y") {
		$headQuartersFlag .= '<option value="Y" selected>Yes</option><option value="N">No</option>';
	} else {
		$headQuartersFlag .= '<option value="Y">Yes</option><option value="N" selected>No</option>';
	}
	$headQuartersFlag .= '</select>';
} else {
	if ($head_quarters_flag == "Y") {
		$headQuartersFlag = 'YES';
	} else {
		$headQuartersFlag = 'NO';
	}
}

echo $headQuartersFlag;
?>
</td>
</tr>

<tr>
<td>
<?php if ($mode <> 'view') { ?>
<label></label>
<?php } ?>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {

	$formButtons = <<<END_FORM_BUTTONS
<input type="button" value="$btnSaveOfficeText" onclick="Contacts_Manager__updateAllContactCompanyOfficeAttributes('manage-contact_company_office-record', '$contact_company_office_id');">
<input type="button" value="Cancel" onclick="cancelOfficeDetails('$contact_company_id');">
END_FORM_BUTTONS;

} else {
	$formButtons = '';
/*
'
<input name="btnCloseOfficeDetails" id="btnCloseOfficeDetails" type="button" value="Return To Office List" onclick="cancelOfficeDetails(\''.$contact_company_id.'\');">
';
*/
}

echo $formButtons;
?>
</td>
</tr>

</table>
</td>
<td style="vertical-align: top;">

<?php
if (isset($contact_company_office_id) && !empty($contact_company_office_id)) {
?>
<table>
<tr>
<td>
<label class="contactLabelImp" for="phone">Business Phone:</label>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {
	$formattedBusinessPhoneNumberHtml =
'
<input id="businessPhone" class="phoneExtension" name="businessPhone" onchange="updateOfficePhoneField('.$contact_company_office_id.', '.$business_phone_id.', \'businessPhone\', '.PhoneNumberType::BUSINESS.');" value="'.$formattedBusinessPhoneNumber.'" tabindex="">
';
} else {
	$formattedBusinessPhoneNumberHtml = $formattedBusinessPhoneNumber;
}

echo $formattedBusinessPhoneNumberHtml;
?>
</td>
</tr>

<tr>
<td>
<label class="contactLabelImp" for="phone">Business Fax:</label>
<?php
if (($mode <> 'view') && $userCanManageContactCompanyOffices) {
	$formattedBusinessFaxNumberHtml =
'
<input id="businessFax" class="phoneNumber" name="businessFax" onchange="updateOfficePhoneField('.$contact_company_office_id.', '.$business_fax_id.', \'businessFax\', '.PhoneNumberType::BUSINESS_FAX.');" value="'.$formattedBusinessFaxNumber.'" tabindex="">
';
} else {
	$formattedBusinessFaxNumberHtml = $formattedBusinessFaxNumber;
}

echo $formattedBusinessFaxNumberHtml;
?>
</td>
</tr>
</table>
<?php
}
?>
</td>
</tr>
</table>
</form>
<?php if (($mode == 'create') || ($mode == 'update')) { ?>
<!--</fieldset>-->
<?php } ?>

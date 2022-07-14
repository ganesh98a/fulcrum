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
?>

<?php

$attributeGroupName = 'create-contact-record';
$uniqueId = Data::generateDummyPrimaryKey();

// Get first office in list for now
$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
$arrContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $contact_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);
$contact_company_office_id = 0;

//if (isset($arrContactCompanyOffices[0]) && !empty($arrContactCompanyOffices[0])) {
//	$contactCompanyOffice = $arrContactCompanyOffices[0];
//	/* @var $contactCompanyOffice ContactCompanyOffice */
//	$contact_company_office_id = $contactCompanyOffice->contact_company_office_id;
//} else {
//	$contact_company_office_id = 0;
//}

$formattedMobilePhoneNumber = '';
$contact_mobile_phone_number_id = 0;
$mobile_network_carrier_id = '';
$formattedPhoneNumber = '';
$contact_phone_number_id = 0;

// Get auto-complete options for business phone
$phoneAutocompleteList = '';
$arrAutocompleteList = array();
$arrContactPhoneNumbers = ContactPhoneNumber::loadContactCompanyPhoneNumbersListByContactCompanyId($database, $contact_company_id, PhoneNumberType::BUSINESS);
if (isset($arrContactPhoneNumbers) && !empty($arrContactPhoneNumbers)) {
	foreach ($arrContactPhoneNumbers as $contactPhoneNumber) {
		$formattedAutocompletePhoneNumber = $contactPhoneNumber->getFormattedNumber();
		//$strippedPhoneNumber = Data::parseInt($formattedAutocompletePhoneNumber);
		$strippedPhoneNumber = preg_replace('[\D]', '', $formattedAutocompletePhoneNumber);

		// Could pass back serialized objects to the front-end, but would then need to modify the JavaScript
		// Return data in a format that makes JQuery happy
		$arrTmp['label'] = $strippedPhoneNumber;
		$arrTmp['value'] = $formattedAutocompletePhoneNumber;
		array_push($arrAutocompleteList, $arrTmp);
	}
}
$phoneAutocompleteList = htmlentities(json_encode($arrAutocompleteList));

// Fax...needs some refactoring all around...quick and dirty for now...
$arrContactFaxNumbers = ContactPhoneNumber::loadContactCompanyPhoneNumbersListByContactCompanyId($database, $contact_company_id, PhoneNumberType::BUSINESS_FAX);
if (isset($arrContactFaxNumbers[0]) && !empty($arrContactFaxNumbers[0])) {
	$contactFaxNumber = $arrContactFaxNumbers[0];
	/* @var $contactFaxNumber ContactPhoneNumber */
	$formattedFaxNumber = $contactFaxNumber->getFormattedNumber();
	$contact_fax_number_id = $contactFaxNumber->contact_phone_number_id;
} else {
	$formattedFaxNumber = '';
	$contact_fax_number_id = 0;
}

// Get auto-complete options for business fax
$faxAutocompleteList = '';
$arrFaxAutocompleteList = array();
$arrContactFaxNumbers = ContactPhoneNumber::loadContactCompanyPhoneNumbersListByContactCompanyId($database, $contact_company_id, PhoneNumberType::BUSINESS_FAX);

if (isset($arrContactFaxNumbers) && !empty($arrContactFaxNumbers)) {
	foreach ($arrContactFaxNumbers as $contactFaxNumber) {
		$formattedAutocompletePhoneNumber = $contactFaxNumber->getFormattedNumber();
		//$strippedPhoneNumber = Data::parseInt($formattedAutocompletePhoneNumber);
		$strippedPhoneNumber = preg_replace('[\D]', '', $formattedAutocompletePhoneNumber);

		// Could pass back serialized objects to the front-end, but would then need to modify the JavaScript
		// Return data in a format that makes JQuery happy
		$arrTmp['label'] = $strippedPhoneNumber;
		$arrTmp['value'] = $formattedAutocompletePhoneNumber;
		array_push($arrFaxAutocompleteList, $arrTmp);
	}
}
$faxAutocompleteList = htmlentities(json_encode($arrFaxAutocompleteList));


//$ddlContactCompanyElementId = 'ddl--create-contact-record--contact_company_offices--contact_company_office_id--' . $uniqueId;
//$ddlOffices = PageComponents::dropDownListFromObjects($ddlContactCompanyElementId, $arrContactCompanyOffices, 'contact_company_office_id', null, 'office_nickname', null, '', '', '', '');
//createOfficeDropDownWithSelection($database, $contact_company_id, $contact_id, $contact_company_office_id, 406, false);
$ddlOffices = '';


$ddlMobileNetworkCarriers = '';
$arrOptions = MessageGateway_Sms::generateSmsGatewayList($database, 'mobile_network_carriers');
//$arrOptions = MessageGateway_Sms::$arrSmsGatewaysDropDownList;
// ddl--create-contact-record--mobile_network_carriers--mobile_network_carrier_id--dummy_id_14027197024574
$ddlMobileNetworkCarriers = '<select tabindex="109" id="ddl--create-contact-record--mobile_network_carriers--mobile_network_carrier_id--'.$uniqueId.'" name="mobile_network_carrier_id">';
$first = true;
foreach ($arrOptions as $optionGroup => $arrOptionList) {
	if ($first) {
		$first = false;
	} else {
		$ddlMobileNetworkCarriers .= '</optgroup>';
	}
	$ddlMobileNetworkCarriers .= '<optgroup label="'.$optionGroup.'">';
	foreach ($arrOptionList as $optionKey => $optionValue) {
		if ($mobile_network_carrier_id == $optionValue) {
			$selectedCarrier = 'selected';
		} else {
			$selectedCarrier = '';
		}
		$ddlMobileNetworkCarriers .= '<option '.$selectedCarrier.' value="'.$optionValue.'">'.$optionKey.'</option>';
	}
}
$ddlMobileNetworkCarriers .= '</optgroup></select>';


$htmlContent = <<<HTMLCONTENT

<div class="contactSectionHeader"><b>Create A New Contact</b></div>
	<form id="frmContactInfo" name="frmContactInfo">

		<input id="formattedAttributeGroupName--create-contact-record" type="hidden" value="Contact">
		<input id="formattedAttributeSubgroupName--create-contact-record" type="hidden" value="Contact">

		<!-- user_company_id -->
		<input id="create-contact-record--contacts--user_company_id--$uniqueId" type="hidden" value="$user_company_id">
		<input id="formattedAttributeGroupName--create-contact-record--contacts--user_company_id--$uniqueId" type="hidden" value="User Company ID">
		<input id="formattedAttributeSubgroupName--create-contact-record--contacts--user_company_id--$uniqueId" type="hidden" value="User Company ID">

		<!-- user_id -->
		<input id="create-contact-record--contacts--user_id--$uniqueId" type="hidden" value="1">
		<input id="formattedAttributeGroupName--create-contact-record--contacts--user_id--$uniqueId" type="hidden" value="User ID">
		<input id="formattedAttributeSubgroupName--create-contact-record--contacts--user_id--$uniqueId" type="hidden" value="User ID">

		<!-- contact_company_id -->
		<input id="create-contact-record--contacts--contact_company_id--$uniqueId" type="hidden" value="$contact_company_id">
		<input id="formattedAttributeGroupName--create-contact-record--contacts--contact_company_id--$uniqueId" type="hidden" value="User Company ID">
		<input id="formattedAttributeSubgroupName--create-contact-record--contacts--contact_company_id--$uniqueId" type="hidden" value="User Company ID">

		<table class="contactSectionTable">

			<tr>
				<td>
					<label for="first_name"><b>First Name:</b></label>
					<input name="first_name" id="create-contact-record--contacts--first_name--$uniqueId" tabindex="400" value="">
				</td>
				<!--td>
					<label for="mobile_network_carrier_id">Mobile Network Carrier:</label>
					$ddlMobileNetworkCarriers
				</td-->
			</tr>

			<tr>
				<td>
					<label for="last_name"><b>Last Name:</b></label>
					<input name="last_name" id="create-contact-record--contacts--last_name--$uniqueId" tabindex="401" value="">
				</td>
			</tr>

			<tr>
				<td>
					<label for="email"><b>Email:</b></label>
					<input name="email" id="create-contact-record--contacts--email--$uniqueId" tabindex="402" value="">
				</td>
				<!--td>
					<label for="phone">Business Phone:</label>
					<input name="phone" id="create-contact-record--contacts--phone--$uniqueId" class="phoneNumber" tabindex="405" value="">
					<input id="phoneAutocompleteOptions" type="hidden" value="">
				</td-->
			</tr>

			<tr>			
				<td>
					<label for="mobilephone"><b>Mobile Phone:</b></label>
					<input name="mobilephone" id="create-contact-record--contacts--mobilephone--$uniqueId" class="phoneNumber" tabindex="403" value="">
				</td>
			</tr>
			
			<tr>
				<td>
					<label for="title"><b>Title:</b></label>
					<input name="title" id="create-contact-record--contacts--title--$uniqueId" tabindex="404" value="">
				</td>
				<!--td>
					<label for="fax">Business Fax:</label>
					<input name="fax" id="fax" class="phoneNumber" tabindex="405" value="">
					<input id="faxAutocompleteOptions" type="hidden" value="">
				</td-->
			</tr>

			<!--tr>
				<td>
					<label for="contact_company_office_id">Primary Office:</label>
					<div id="ddlOfficesDiv" style="display:inline-block;">$ddlOffices</div>
				</td>
				<td>&nbsp;
				</td>
			</tr-->

			<tr>
				<td style="padding-top:10px;">
					<label></label>
					<input name="btnSaveNewContact" id="btnSaveNewContact" onclick="Contacts_Manager__createContact('$attributeGroupName', '$uniqueId');" value="Save New Contact" type="button">
					<input name="btnCancelNewContact" id="btnCancelNewContact" onclick="cancelNewContact();" value="Cancel New Contact" type="button">
				</td>
			</tr>

		</table>
	</form>
HTMLCONTENT;

return $htmlContent;

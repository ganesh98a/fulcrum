<?php
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$contactFullName = $contact->getContactFullName();
if ($user_id == $contact->user_id) {
	$contactFullName .= ' (My Record)';
}
$encodedContactFullName = Data::entity_encode($contactFullName);

$encodedEmail = Data::entity_encode($contact->email);
$encodedContactFirstName = Data::entity_encode($contact->first_name);
$encodedContactLastName = Data::entity_encode($contact->last_name);
$encodedContactTitle = Data::entity_encode($contact->title);

// Get first office in list for now
$arrContactCompanyOffices = $contact->getOfficeList();
if (isset($arrContactCompanyOffices[0]) && !empty($arrContactCompanyOffices[0])) {
	$contactCompanyOffice = $arrContactCompanyOffices[0];
	/* @var $contactCompanyOffice ContactCompanyOffice */
	$contact_company_office_id = $contactCompanyOffice->contact_company_office_id;
} else {
	$contact_company_office_id = 0;
}

// Mobile Phone...needs some refactoring all around...quick and dirty for now...
$arrContactPhoneNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $contact_id, PhoneNumberType::MOBILE);
//$arrContactPhoneNumbers = $contact->getPhoneNumberList();
if (isset($arrContactPhoneNumbers[0]) && !empty($arrContactPhoneNumbers[0])) {
	$contactPhoneNumber = $arrContactPhoneNumbers[0];
	/* @var $contactPhoneNumber ContactPhoneNumber */
	$formattedMobilePhoneNumber = $contactPhoneNumber->getFormattedNumber();
	$contact_mobile_phone_number_id = $contactPhoneNumber->contact_phone_number_id;
	$mobile_network_carrier_id = $contactPhoneNumber->mobile_network_carrier_id;
} else {
	$formattedMobilePhoneNumber = '';
	$contact_mobile_phone_number_id = 0;
	$mobile_network_carrier_id = '';
}

// Business Phone...needs some refactoring all around...quick and dirty for now...
$arrContactPhoneNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $contact_id, PhoneNumberType::BUSINESS);
//$arrContactPhoneNumbers = $contact->getPhoneNumberList();
if (isset($arrContactPhoneNumbers[0]) && !empty($arrContactPhoneNumbers[0])) {
	$contactPhoneNumber = $arrContactPhoneNumbers[0];
	/* @var $contactPhoneNumber ContactPhoneNumber */
	$formattedPhoneNumber = $contactPhoneNumber->getFormattedNumber();
	$contact_phone_number_id = $contactPhoneNumber->contact_phone_number_id;
} else {
	$formattedPhoneNumber = '';
	$contact_phone_number_id = 0;
}

// Get auto-complete options for business phone
$phoneAutocompleteList = '';
$arrAutocompleteList = array();
$arrContactPhoneNumbers = ContactPhoneNumber::loadContactCompanyPhoneNumbersListByContactCompanyId($database, $contact->contact_company_id, PhoneNumberType::BUSINESS);
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
$arrContactFaxNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $contact_id, PhoneNumberType::BUSINESS_FAX);
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
$arrContactFaxNumbers = ContactPhoneNumber::loadContactCompanyPhoneNumbersListByContactCompanyId($database, $contact->contact_company_id, PhoneNumberType::BUSINESS_FAX);
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

$ddlOffices = createOfficeDropDownWithSelection($database, $contact_company_id, $contact_id, $contact_company_office_id, 406, true);

//echo '<fieldset>';
echo '

<div class="contactSectionHeader">Contact Information - <span id="contactInfoHeaderContactName">'.$encodedContactFullName.'<span></div>
	<form id="frmContactInfo" name="frmContactInfo">
		<input id="selectedContactId" name="selectedContactId" type="hidden" value="'.$contact_id.'">
		<input id="selectedUserId" name="selectedUserId" type="hidden" value="'.$contact->user_id.'">
		<table class="contactSectionTable width100-per">
			<tr>
				<td>
					<label for="first_name" class="contactLabelImp">First Name:</label>
';

if ($userCanManageContacts) {
	echo '			<input name="first_name" id="first_name" tabindex="400" value="'.$encodedContactFirstName.'" disabled>';
} else {
	echo 			$encodedContactFirstName;
}
echo '
				</td>
				<td>
					<label for="contact_company_office_id" class="contactLabelImp">Primary Office:</label>
';
if ($userCanManageContacts) {
	echo '			<div id="ddlOfficesDiv" style="display:inline-block;">'.$ddlOffices.'</div>';
} else {
	$cco = new ContactCompanyOffice($database);
	$key = array('id' => $contact_company_office_id);
	$cco->setKey($key);
	$cco->load();
	$cco->convertDataToProperties();
	$encodedAddressLine1 = Data::entity_encode($cco->address_line_1);
	echo 			$encodedAddressLine1;
}
	echo'
			</tr>
			<tr>
				<td>
					<label for="last_name" class="contactLabelImp">Last Name:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="last_name" id="last_name" tabindex="401" value="'.$encodedContactLastName.'" disabled>';
} else {
	echo 			$encodedContactLastName;
}
echo '
				</td>
				<td>
					<label for="mobilephone" class="contactLabelImp">Mobile Phone:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="mobilephone" id="mobilephone" class="phoneNumber" tabindex="404" value="'.$formattedMobilePhoneNumber.'" disabled>';
} else {
	echo 			$formattedMobilePhoneNumber;
}
echo '
				</td>
			</tr>
			<tr>
				<td>
					<label for="email" class="contactLabelImp">Email:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="email" id="email" tabindex="402" value="' . $encodedEmail . '" disabled>';
} else {
	echo 			$encodedEmail;
}
echo '
				</td>
				<td>
					<label for="phone" class="contactLabelImp">Business Phone:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="phone" id="phone" class="phoneExtension" tabindex="405" value="'.$formattedPhoneNumber.'" disabled>';
} else {
	echo 			$formattedPhoneNumber;
}
echo '
					<input id="phoneAutocompleteOptions" type="hidden" value="'.$phoneAutocompleteList.'">
				</td>
			</tr>
			<tr>
				<td>
					<label for="title" class="contactLabelImp">Title:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="title" id="title" tabindex="403" value="' . $encodedContactTitle . '" disabled>';
} else {
	echo 			$encodedContactTitle;
}
echo '
				</td>
				<td>
					<label for="fax" class="contactLabelImp">Business Fax:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="fax" id="fax" class="phoneNumber" tabindex="405" value="'.$formattedFaxNumber.'" disabled>';
} else {
	echo 			$formattedFaxNumber;
}
echo '
					<input id="faxAutocompleteOptions" type="hidden" value="'.$faxAutocompleteList.'">
				</td>
			</tr>';

if ($userCanManageContacts) {
	//$emailUrlEncoded = urlencode($contact->email);
	echo'
			<tr>
				<td colspan="2">
					<label>&nbsp;</label>
					<input type="button" onclick="loadToReArchiveContactDialog('.$contact_id.')" value="Restore contact">
				</td>
			</tr>
		';
}
echo '
		</table>
	</form>';

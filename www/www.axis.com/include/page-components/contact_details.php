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

$ddlOffices = createOfficeDropDownWithSelection($database, $contact_company_id, $contact_id, $contact_company_office_id, 406, false);

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
	echo '			<input name="first_name" id="first_name" tabindex="400" value="'.$encodedContactFirstName.'" onchange="updateContactField('.$contact_id.',\'first_name\');">';
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
				/*mobile carrier field hide */
				/*<td>
					<label for="mobile_network_carrier_id">Mobile Network Carrier:</label>
';
if ($userCanManageContacts) {
	$arrOptions = MessageGateway_Sms::generateSmsGatewayList($database, 'mobile_network_carriers');
	//$arrOptions = MessageGateway_Sms::$arrSmsGatewaysDropDownList;
	$select = '<select tabindex="109" id="mobile_network_carrier_id" name="mobile_network_carrier_id" onchange="updateMobileNetworkCarrier('.$contact_id.', '.$contact_mobile_phone_number_id.')">';
	$first = true;
	foreach ($arrOptions as $optionGroup => $arrOptionList) {
		if ($first) {
			$first = false;
		} else {
			$select .= '</optgroup>';
		}
		$select .= '<optgroup label="'.$optionGroup.'">';
		foreach ($arrOptionList as $optionKey => $optionValue) {
			if ($mobile_network_carrier_id == $optionValue) {
				$selectedCarrier = 'selected';
			} else {
				$selectedCarrier = '';
			}
			$select .= '<option '.$selectedCarrier.' value="'.$optionValue.'">'.$optionKey.'</option>';
		}
	}
	$select .= '</optgroup></select>';
	echo $select;
} else {
	$contactMobileNetworkCarrier = '';
	$arrOptions = MessageGateway_Sms::generateSmsGatewayList($database, 'mobile_network_carriers');
	//$arrOptions = MessageGateway_Sms::$arrSmsGatewaysDropDownList;
	$select = '<select tabindex="109" id="mobile_network_carrier_id" name="mobile_network_carrier_id" onchange="updateMobileNetworkCarrier('.$contact_id.', '.$contact_mobile_phone_number_id.')">';
	$first = true;
	foreach ($arrOptions as $optionGroup => $arrOptionList) {
		if ($first) {
			$first = false;
		} else {
			$select .= '</optgroup>';
		}
		$select .= '<optgroup label="'.$optionGroup.'">';
		foreach ($arrOptionList as $optionKey => $optionValue) {
			if ($mobile_network_carrier_id == $optionValue) {
				$selectedCarrier = 'selected';
				$contactMobileNetworkCarrier = $optionKey;
			} else {
				$selectedCarrier = '';
			}
			$select .= '<option '.$selectedCarrier.' value="'.$optionValue.'">'.$optionKey.'</option>';
		}
	}
	$select .= '</optgroup></select>';
	echo $contactMobileNetworkCarrier;
}
echo '
				</td>*/
				echo'
			</tr>
			<tr>
				<td>
					<label for="last_name" class="contactLabelImp">Last Name:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="last_name" id="last_name" tabindex="401" value="'.$encodedContactLastName.'" onchange="updateContactField('.$contact_id.',\'last_name\');">';
} else {
	echo 			$encodedContactLastName;
}
echo '
				</td>
				<td>
					<label for="mobilephone" class="contactLabelImp">Mobile Phone:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="mobilephone" id="mobilephone" class="phoneNumber" tabindex="404" value="'.$formattedMobilePhoneNumber.'" onchange="updateContactPhoneNumber('.$contact_id.','.$contact_mobile_phone_number_id.',\'mobilephone\', '.PhoneNumberType::MOBILE.');">';
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
	echo '			<input name="email" id="email" tabindex="402" value="' . $encodedEmail . '" onchange="updateContactField('.$contact_id.',\'email\');">';
} else {
	echo 			$encodedEmail;
}
echo '
				</td>
				<td>
					<label for="phone" class="contactLabelImp">Business Phone:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="phone" id="phone" class="phoneExtension" tabindex="405" value="'.$formattedPhoneNumber.'" onchange="updateContactPhoneNumber('.$contact_id.','.$contact_phone_number_id.',\'phone\', '.PhoneNumberType::BUSINESS.');">';
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
	echo '			<input name="title" id="title" tabindex="403" value="' . $encodedContactTitle . '" onchange="updateContactField('.$contact_id.', \'title\');">';
} else {
	echo 			$encodedContactTitle;
}
echo '
				</td>
				<td>
					<label for="fax" class="contactLabelImp">Business Fax:</label>
';
if ($userCanManageContacts) {
	echo '			<input name="fax" id="fax" class="phoneNumber" tabindex="405" value="'.$formattedFaxNumber.'" onchange="updateContactPhoneNumber('.$contact_id.', '.$contact_fax_number_id.',\'fax\', '.PhoneNumberType::BUSINESS_FAX.');">';
} else {
	echo 			$formattedFaxNumber;
}
echo '
					<input id="faxAutocompleteOptions" type="hidden" value="'.$faxAutocompleteList.'">
				</td>
			</tr>';

			/*<tr>
				<td>
					<label for="contact_company_office_id">Primary Office:</label>
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
echo '
				</td>
				<td>&nbsp;
				</td>
			</tr>*/

$role_id = Contact::findRoleId($database, $contact->user_id);

if ($userCanManageContacts && $contact->user_id) {
	if ($contact->user_id <> 1) {
		echo'
		<tr>			
			<td colspan="2">
				<label>&nbsp;</label>
		';
		if (($currentlyActiveContactId != $contact_id) && ($role_id != 1)) {
			echo '<input type="button"  value="Archive contact" onclick="loadToArchiveContactDialog('.$contact_id.')"> ';
		}
			echo ' <input type="button" onclick="resetUserPassword('.$contact->user_id.', \''.$contact->email.'\');" value="Send Password Reset Email" title="Reset ' . $encodedContactFullName . '\'s Password and Send to ' . $encodedEmail . '">
			</td>
		</tr>
		';
	}else{
		if ($currentlyActiveContactId != $contact_id) {
			echo'
			<tr>			
				<td colspan="2">
					<label>&nbsp;</label>
					<input type="button"  value="Archive contact" onclick="loadToArchiveContactDialog('.$contact_id.')">
				</td>
			</tr>
			';
		}
	}	
}


if ($contact_id == 0) {
	echo '
			<tr>
				<td colspan="2">
					<label></label>
					<input name="btnSaveNewContact" id="btnSaveNewContact" onclick="saveNewContact();" value="Save New Contact" type="button">
					<input name="btnCancelNewContact" id="btnCancelNewContact" onclick="cancelNewContact();" value="Cancel New Contact" type="button">
				</td>
			</tr>
	';
}

echo '
		</table>
	</form>';

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
echo '
<table>
	<tr>
		<td class="contactSectionHeader">Office List</td>
		<td align="right">
';

if ($userCanManageOffices) {
	echo '
			<input name="btnNewOffice" id="btnNewOffice" onclick="loadCreateContactCompanyOfficeDialog();" value="New Office" type="button">
	';
}

echo '
			&nbsp;
		</td>
	</tr>
</table>
';

if (isset($arrContactCompanyOffices) && !empty($arrContactCompanyOffices)) {
	echo '
<table id="tblOffices" width="100%" class="listTable contactSectionTable addressForm table-border-td">
	<tr class="padding5 officeheader">
	';
	if ($userCanManageOffices) {
		echo '
		<th>&nbsp;</th>';
	}
	echo '
		<th>Headquarters</th>
		<th>Nickname</th>
		<th align="center">Address</th>
		<th>City</th>
		<th>State</th>
		<th>Zip</th>
		<th>Bus Phone</th>
		<th>Bus Fax</th>
	</tr>
	';
	$loopCounter = 0;
	foreach ($arrContactCompanyOffices as $key => $contactCompanyOffice) {
		/* @var $contactCompanyOffice ContactCompanyOffice */
		$contact_company_office_id = $contactCompanyOffice->contact_company_office_id;
		$contact_company_id = $contactCompanyOffice->contact_company_id;
		$office_nickname = $contactCompanyOffice->office_nickname;
		$address_line_1 = $contactCompanyOffice->address_line_1;
		$address_line_2 = $contactCompanyOffice->address_line_2;
		$address_line_3 = $contactCompanyOffice->address_line_3;
		$address_line_4 = $contactCompanyOffice->address_line_4;
		$address_city = $contactCompanyOffice->address_city;
		$address_county = $contactCompanyOffice->address_county;
		$address_state_or_region = $contactCompanyOffice->address_state_or_region;
		$address_postal_code = $contactCompanyOffice->address_postal_code;
		$address_postal_code_extension = $contactCompanyOffice->address_postal_code_extension;
		$address_country = $contactCompanyOffice->address_country;
		$head_quarters_flag = $contactCompanyOffice->head_quarters_flag;
		$address_validated_by_user_flag = $contactCompanyOffice->address_validated_by_user_flag;
		$address_validated_by_web_service_flag = $contactCompanyOffice->address_validated_by_web_service_flag;
		$address_validation_by_web_service_error_flag = $contactCompanyOffice->address_validation_by_web_service_error_flag;

		$address = $address_line_1.' '.$address_line_2.' '.$address_line_3.' '.$address_line_4;
		$address = Data::singleSpace($address);

		$businessPhoneNumber = $contactCompanyOffice->getBusinessPhoneNumber();
		/* @var $businessPhoneNumber ContactCompanyOfficePhoneNumber */
		if ($businessPhoneNumber) {
			$formattedBusinessPhoneNumber = $businessPhoneNumber->getFormattedPhoneNumber();
			$formatbusinesphone=explode('-',$formattedBusinessPhoneNumber);
			$number=substr($formatbusinesphone[1],0,4);
			$ext=substr($formatbusinesphone[1],4,4);
			$formattedBusinessPhoneNumber = $formatbusinesphone[0].'-'.$number.' ext. '.$ext;
		} else {
			$formattedBusinessPhoneNumber = '';
		}

		$businessFaxNumber = $contactCompanyOffice->getBusinessFaxNumber();
		/* @var $businessFaxNumber ContactCompanyOfficePhoneNumber */
		if ($businessFaxNumber) {
			$formattedBusinessFaxNumber = $businessFaxNumber->getFormattedPhoneNumber();
		} else {
			$formattedBusinessFaxNumber = '';
		}

		if ($loopCounter % 2) {
			$rowStyle = 'oddRow';
		} else {
			$rowStyle = 'evenRow';
		}

		echo '
	<tr id="office_'.$contact_company_office_id.'" class="'.$rowStyle.' textAlignCenter">
		';

		if ($userCanManageOffices) {
			echo '
	<tr id="office_'.$contact_company_office_id.'" class="'.$rowStyle.' textAlignCenter">
		<td><a href="javascript:deleteOffice(\'office_'.$contact_company_office_id.'\', \''.$contact_company_office_id.'\')">X</a></td>
		<td onclick="showOfficeDetails(\''.$contact_company_office_id.'\');">'.$head_quarters_flag.'</td>
		<td onclick="showOfficeDetails(\''.$contact_company_office_id.'\');">'.$office_nickname.'</td>
		<td onclick="showOfficeDetails(\''.$contact_company_office_id.'\');">'.$address.'</td>
		<td onclick="showOfficeDetails(\''.$contact_company_office_id.'\');">'.$address_city.'</td>
		<td onclick="showOfficeDetails(\''.$contact_company_office_id.'\');">'.$address_state_or_region.'</td>
		<td onclick="showOfficeDetails(\''.$contact_company_office_id.'\');">'.$address_postal_code.'</td>
		<td onclick="showOfficeDetails(\''.$contact_company_office_id.'\');">'.$formattedBusinessPhoneNumber.'</td>
		<td onclick="showOfficeDetails(\''.$contact_company_office_id.'\');">'.$formattedBusinessFaxNumber.'</td>
		';
		} else {
			$rowStyle .= 'NotClickable';
			echo '
	<tr id="office_'.$contact_company_office_id.'" class="'.$rowStyle.'">
		<td>'.$head_quarters_flag.'</td>
		<td>'.$office_nickname.'</td>
		<td>'.$address.'</td>
		<td>'.$address_city.'</td>
		<td>'.$address_state_or_region.'</td>
		<td>'.$address_postal_code.'</td>
		<td>'.$formattedBusinessPhoneNumber.'</td>
		<td>'.$formattedBusinessFaxNumber.'</td>
		';
		}

		echo '
	</tr>
		';
		$loopCounter ++;
	}
	//<input name="selectedOfficeId" id="selectedOfficeId" type="hidden" value="0">
	echo '
</table>
	';
} else {
	echo '
<table class="contactSectionTable listTable" width="350">
	<tr>
		<td>No Office Information Has Been Created</td>
	</tr>
</table>
	';
}

	// Load Contact Company Trades.
require('subcontractor_trades.php');
?>

<?php

require_once('page-components/select_country_list.php');

// FUNCTIONS
function createOfficeDropDownWithSelection($database, $contact_company_id, $contact_id, $selectedOfficeId, $tabIndex, $is_archive)
{
	$arrContactCompanyOfficesByContactCompanyId = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $contact_company_id);

	if ($is_archive == true) {
		$archive = "disabled";
	}

	$htmlContent = <<<END_HTML_CONTENT

	<select name="ddlOffices" id="ddlOffices" tabindex="$tabIndex" onchange="ddlOfficesChanged('ddlOffices', $contact_id);" $archive>
END_HTML_CONTENT;


	if (count($arrContactCompanyOfficesByContactCompanyId) == 0) {

		$htmlContent .= <<<END_HTML_CONTENT
		<option value="0">Please Create An Office</option>
END_HTML_CONTENT;

	} else if (count($arrContactCompanyOfficesByContactCompanyId) > 0) {

		$htmlContent .= <<<END_HTML_CONTENT

		<option value="0">Select An Office</option>
END_HTML_CONTENT;

	}

	foreach ($arrContactCompanyOfficesByContactCompanyId as $contact_company_office_id => $contactCompanyOffice) {
		/* @var $contactCompanyOffice ContactCompanyOffice */

		$contact_company_office_id = $contactCompanyOffice->contact_company_office_id;
		$office_nickname = $contactCompanyOffice->office_nickname;
		$address_line_1 = $contactCompanyOffice->address_line_1;
		$address_line_2 = $contactCompanyOffice->address_line_2;
		$address_line_3 = $contactCompanyOffice->address_line_3;
		$address_line_4 = $contactCompanyOffice->address_line_4;
		$address_city = $contactCompanyOffice->address_city;
		$address_county = $contactCompanyOffice->address_county;
		$address_state_or_region = $contactCompanyOffice->address_state_or_region;
		$address_country = $contactCompanyOffice->address_country;
		$address = $address_line_1 . ' ' . $address_line_2 . ' ' . $address_line_3 . ' ' . $address_line_4;
		$address = Data::singleSpace($address);

		if (empty($address)) {
			$arrAddress = array(
				$office_nickname,
				$address_city,
				$address_county,
				$address_state_or_region,
				$address_country
			);
			$address = join(' ', $arrAddress);
			$address = Data::singleSpace($address);
		}

		if ($contact_company_office_id == $selectedOfficeId) {
			$selected = ' selected';
		} else {
			$selected = '';
		}

		$htmlContent .= <<<END_HTML_CONTENT

		<option value="$contact_company_office_id"$selected>$address</option>
END_HTML_CONTENT;
	}

	$htmlContent .= <<<END_HTML_CONTENT

	</select>

END_HTML_CONTENT;

	return $htmlContent;
}

function objectArrayLessObjectsFromSecondObjectArray($objectArray1, $objectArray2, $keyToCompare)
{
	$returnArray = array();

	foreach ($objectArray1 as $key => $objectArray1RecordAry) {
		$objOneValue = $objectArray1RecordAry[$keyToCompare];
		$addThisObject = true;
		foreach ($objectArray2 as $key => $objectArray2RecordAry) {
			$objTwoValue = $objectArray2RecordAry[$keyToCompare];
			if ($objOneValue == $objTwoValue) {
				$addThisObject = false;
				break;
			}
		}
		if ($addThisObject) {
			$returnArray[] = $objectArray1RecordAry;
		}
	}

	return $returnArray;
}

/**
 * Enter description here...
 *
 * @param string $database
 * @param int $user_company_id
 * @param string $userRole
 * @param string $mode view|manage
 * @return string
 */
function createTradeDropDownForUserCompanyId($database, $user_company_id, $userRole, $mode='view')
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$htmlContent = <<<END_HTML_CONTENT

<select id="ddlCompanyTrade" multiple size="10" style="width: 400px;">
END_HTML_CONTENT;

	$query =
"
SELECT

	codes.`id` AS 'cost_code_id',
	ccd.`division_number`,
	ccd.`division_code_heading`,
	ccd.`division`,
	codes.`cost_code`,
	codes.`cost_code_description`

FROM `cost_code_divisions` ccd
	INNER JOIN `cost_codes` codes ON ccd.`id` = codes.`cost_code_division_id`
WHERE ccd.`user_company_id` = ?
AND codes.`disabled_flag` = 'N'
";
	$arrValues = array($user_company_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$noItems = true;
	$currentDivisionNumber = -1;
	$firstDivision = true;
	while ($row = $db->fetch()) {

		if ($noItems) {

			if ($mode <> 'view') {

				$htmlContent .= <<<END_HTML_CONTENT

	<option value="0">Please Select A Trade To Add</option>
END_HTML_CONTENT;

			}

		}

		$noItems = false;
		$cost_code_id = $row['cost_code_id'];
		$cost_code = $row['cost_code'];
		$cost_code_description = $row['cost_code_description'];
		$division_number = $row['division_number'];
		$division_code_heading = $row['division_code_heading'];
		$division = $row['division'];

		if ($currentDivisionNumber <> $division_number) {
			$currentDivisionNumber = $division_number;

			if ($firstDivision) {

				$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$division ($division_number-$division_code_heading)">
END_HTML_CONTENT;

			} else {

				$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$division ($division_number-$division_code_heading)">
END_HTML_CONTENT;

			}

		}

		$htmlContent .= <<<END_HTML_CONTENT

		<option value="$cost_code_id">$division_number-$cost_code $cost_code_description</option>
END_HTML_CONTENT;

	}
	$db->free_result();

	if ($noItems) {

		$htmlContent .= <<<END_HTML_CONTENT

		<option value="-1">Master List Of Trades Needed</option>
END_HTML_CONTENT;

	} else {

		$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
END_HTML_CONTENT;

	}

	$htmlContent .= <<<END_HTML_CONTENT

</select>
END_HTML_CONTENT;

	/*
	$htmlContent .= <<<END_HTML_CONTENT

<input value="Reset" type="button" onclick="document.getElementById('ddlCompanyTrade')..selectedIndex=0;">
END_HTML_CONTENT;
	*/

	if ($noItems) {
		//TODO: figure out a better place to stick the Master Budget Edit Stuff and tie it to a permission somehow that is not project specific

		// PERMISSION VARIABLES
		//$permissions = Zend_Registry::get('permissions');
		//$userCanManageBudgets = $permissions->determineAccessToSoftwareModuleFunction('gc_budgets_manage');
		//if ($userCanManageBudgets) {

		if ($userRole == 'admin') {

			$htmlContent = '<input onclick="loadManageGcCostCodesDialog();" type="button" value="Manage Master Budget List">';

		} else {

			$htmlContent = 'Contact Your Company Admin To Setup A Master List Of Trades';

		}
	}

	return $htmlContent;
}

function getContactCompanyTradesTable($database, $user_company_id, $contact_company_id, $userCanManageCompanyTrades)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$htmlContent = '';

	// @todo Refactor to use standard ORM API and HTML Entities
	$query =
"
SELECT

	codes.`id` AS 'cost_code_id',
	ccd.`division_number`,
	ccd.`division_code_heading`,
	ccd.`division`,
	codes.`cost_code`,
	codes.`cost_code_description`

FROM `subcontractor_trades` st
	INNER JOIN `cost_codes` codes ON st.`cost_code_id` = codes.`id`
	INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE st.`contact_company_id` = ?
";
	$contact_company_id = (int) $contact_company_id;
	$arrValues = array($contact_company_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$noItems = true;
	while ($row = $db->fetch()) {

		if ($noItems) {

			$htmlContent = <<<END_HTML_CONTENT

<table cellspacing="0" style="width:100%;">
<thead class="contactSectionHeader"><tr><td colspan='2' style="padding: 8px 0;"><u>Selected Trades</u></td></tr></thead>
END_HTML_CONTENT;

			$noItems = false;

		}

		$cost_code_id = $row['cost_code_id'];
		$cost_code = $row['cost_code'];
		$cost_code_description = $row['cost_code_description'];
		$division_number = $row['division_number'];

		$htmlContent .= <<<END_HTML_CONTENT

	<tr id="tradeRow_$cost_code_id">
END_HTML_CONTENT;

$htmlContent .= <<<END_HTML_CONTENT

		<td>$division_number-$cost_code $cost_code_description</td>
	
END_HTML_CONTENT;

		if ($userCanManageCompanyTrades) {

			$htmlContent .= <<<END_HTML_CONTENT

		<td><a href="javascript:removeTradeFromCompany('$contact_company_id', '$cost_code_id');">X</a></td></tr>
END_HTML_CONTENT;

		}

		

	}
	$db->free_result();

	if ($noItems == false) {

		$htmlContent .= <<<END_HTML_CONTENT

</table>
END_HTML_CONTENT;

	} else {

		if ($userCanManageCompanyTrades == false) {

			$htmlContent = <<<END_HTML_CONTENT

<table cellpadding="5">
	<tr>
		<td>No Trades Have Been Specified For This Company</td>
	</tr>
</table>
END_HTML_CONTENT;

		}

	}

	return $htmlContent;
}

function buildCreateContactCompanyOfficeWidget($database, $contact_company_id, $small=false, $createFunction='createContactCompanyOffice', $options='{}')
{
	$dummyId = Data::generateDummyPrimaryKey();

	$ddlCountries = getCountrySelectBox('United States', null, "create-contact_company_office-record--contact_companies--address_country--$dummyId");
	$db = DBI::getInstance($database);
    //To check whether the contact company alredy has headQuarters
    $query1="SELECT  id FROM `contact_company_offices` WHERE `contact_company_id` = $contact_company_id and `head_quarters_flag`='Y'"; 
    $db->execute($query1);
    $row1=$db->fetch();
    if($row1)
    {
    	$data="0";
    }else
    {
    	$data="1";
    }

	$ddlHeadquarters = <<<END_HTML_CONTENT

<select id="create-contact_company_office-record--contact_company_offices--head_quarters_flag--$dummyId">
END_HTML_CONTENT;
 if($data)
    {
	$ddlHeadquarters .= <<<END_HTML_CONTENT
	<option value="Y" >Yes</option>
END_HTML_CONTENT;
}

	$ddlHeadquarters .= <<<END_HTML_CONTENT
	<option value="N">No</option>
</select>
END_HTML_CONTENT;

	if ($small) {
		$cellpadding = '1';
	} else {
		$cellpadding = '5';
	}

	$htmlContent = <<<END_HTML_CONTENT

	<div id="record_creation_form_container--create-contact_company_office-record--$dummyId" class="widgetContainer" style="border: 0;">
		<table class="content" style="border: 0;" cellpadding="$cellpadding">
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Office Nickname:</td>
				<td><input id="create-contact_company_office-record--contact_company_offices--office_nickname--$dummyId" class="required companyNameModal" style="width: 350px;" type="text"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Address Line 1:</td>
				<td><input class="required" id="create-contact_company_office-record--contact_company_offices--address_line_1--$dummyId" style="width: 350px;" type="text"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Address Line 2:</td>
				<td><input id="create-contact_company_office-record--contact_company_offices--address_line_2--$dummyId" style="width: 350px;" type="text"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Zip:</td>
				<td><input id="create-contact_company_office-record--contact_company_offices--address_postal_code--$dummyId" onchange="checkAddressPostalCode('create-contact_company_office-record', '$dummyId');" style="width: 350px;" type="text"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">City:</td>
				<td><input class="required" id="create-contact_company_office-record--contact_company_offices--address_city--$dummyId" style="width: 350px;" type="text"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">State:</td>
				<td><input class="required" id="create-contact_company_office-record--contact_company_offices--address_state_or_region--$dummyId" style="width: 350px;" type="text"></td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Country:</td>
				<td>$ddlCountries</td>
			</tr>
			<tr>
				<td class="textAlignRight verticalAlignMiddle">Headquarters:</td>
				<td>$ddlHeadquarters</td>
			</tr>
			<tr>
				<td class="textAlignRight" colspan="2">
					<input onclick="$createFunction('create-contact_company_office-record', '$dummyId', $options);" type="submit" value="Create Contact Company Office">
				</td>
			</tr>
		</table>
	</div>
	<input type="hidden" id="divCreateContactCompanyOfficeDialogDummyId" value="$dummyId">
	<input type="hidden" id="create-contact_company_office-record--contact_company_offices--contact_company_id--$dummyId" value="$contact_company_id">
END_HTML_CONTENT;

	return $htmlContent;
}

function buildCreateContactCompanyWidget($small=false, $createFunction='createContactCompany', $options='{}')
{
	$dummyId = Data::generateDummyPrimaryKey();

	if ($small) {
		$cellpadding = '1';
	} else {
		$cellpadding = '5';
	}

	$htmlContent = <<<END_HTML_CONTENT

	<form id="frmCompanyInfoModal">
		<div id="record_creation_form_container--create-contact_company-record--$dummyId" class="widgetContainer" style="border: 0;">
			<table class="content contactSectionTable" cellpadding="$cellpadding" style="border: 0;">
				<tr>
					<td class="textAlignRight verticalAlignMiddle">Company Name:</td>
					<td><input id="create-contact_company-record--contact_companies--company--$dummyId" class="required companyNameModal" style="width: 350px;" type="text"></td>
				</tr>
				<tr>
					<td class="textAlignRight verticalAlignMiddle">Primary Phone Number:</td>
					<td><input id="create-contact_company-record--contact_companies--primary_phone_number--$dummyId" style="width: 350px;" type="text" value="" class="phoneExtension"></td>
				</tr>
				<tr>
					<td class="textAlignRight verticalAlignMiddle">Federal Tax ID:</td>
					<td><input id="create-contact_company-record--contact_companies--employer_identification_number--$dummyId" style="width: 350px;" type="text"></td>
				</tr>
				<tr>
					<td class="textAlignRight verticalAlignMiddle">License:</td>
					<td><input id="create-contact_company-record--contact_companies--construction_license_number--$dummyId" style="width: 350px;" type="text"></td>
				</tr>
				<tr>
					<td class="textAlignRight verticalAlignMiddle">License Exp.:</td>
					<td><input id="create-contact_company-record--contact_companies--construction_license_number_expiration_date--$dummyId" class="datepicker" style="width: 350px;" title="MM/DD/YYYY" type="text"></td>
				</tr>
				<tr>
					<td></td>
					<td class="textAlignRight"><input id="btnSaveNewCompanyModal" type="button" value="Create Company" onclick="$createFunction('create-contact_company-record', '$dummyId', $options);" style="width: 360px;"></td>
				</tr>
			</table>
		</div>
	</form>
	<div id="divSimilarCompanyNamesContainer" class="divSimilarCompanyNamesContainer">Similar company names already in Fulcrum:</div>
	<input id="divCreateContactCompanyDialogDummyId" type="hidden" value="$dummyId">
END_HTML_CONTENT;

	return $htmlContent;
}
/*mobilephone import function*/
function mobilePhoneImportByContactId($database, $ce, $data, $mobilephone, $type){
	$contact_id = $ce;
	$contact = Contact::findContactById($database, $ce);
	$existingData = $contact->getData();
	$httpGetInputData = $data;
	$contact->setData($httpGetInputData);
	$contact->convertDataToProperties();
	$contact->convertPropertiesToData();

	$newData = $contact->getData();
	$data = Data::deltify($existingData, $newData);
	if (!empty($data)) {
		$contact->setData($data);
		$save = true;
		$contact->save();
	}
	//$pn = PhoneNumber::parsePhoneNumber($mobilephone);
	$pn = PhoneNumberType::parsePhoneNumber($mobilephone);
	$area_code = $pn['area_code'];
	$prefix = $pn['prefix'];
	$number = $pn['number'];
	// $area_code = $pn->area_code;
	// $prefix = $pn->prefix;
	// $number = $pn->number;
	$mobile_phone_number = $area_code.$prefix.$number;
	$dbField = 'mobilephone';
	$inputCommonName = 'Mobile Phone';
	$objToUpdate = 'contactPhone';
	if($type == 'mobile'){
	$phone_number_type_id = PhoneNumberType::MOBILE;
	}
	if($type == 'business'){
	$phone_number_type_id = PhoneNumberType::BUSINESS;
	}
	if($type == 'fax'){
	$phone_number_type_id = PhoneNumberType::BUSINESS_FAX;
	}
	$contactPhoneNumber = new ContactPhoneNumber($database);
	$contact_phone_number_id = 0;
	if (isset($contact_phone_number_id) && !empty($contact_phone_number_id)) {
		$key = array('id' => $contact_phone_number_id);
	} else {
				//unique index(`contact_id`, `phone_number_type_id`)
		$key = array(
			'contact_id' => $contact_id,
			'phone_number_type_id' => $phone_number_type_id
		);
	}

			// Check for existing data case
	$contactPhoneNumber->setKey($key);
	$contactPhoneNumber->load();
	$isDataLoaded = $contactPhoneNumber->isDataLoaded();
	if ($isDataLoaded) {
		$contactPhoneNumber->convertDataToProperties();
		$contact_phone_number_id = $contactPhoneNumber->contact_phone_number_id;
	} else {
		$contactPhoneNumber->setKey(null);
	}
	$data = array(
		'contact_id' => $contact_id,
		'phone_number_type_id' => $phone_number_type_id,
		'country_code' => '',
		'area_code' => $area_code,
		'prefix' => $prefix,
		'number' => $number,
		'extension' => '', 
		'itu' => '',
	);
	$contactPhoneNumber->setData($data);
	if ($isDataLoaded) {
		$contactPhoneNumber->save();
	} else {
		$contact_phone_number_id = $contactPhoneNumber->save();
	}
					// Check if the mobile_phone_number already exists in the users table

						// Insert into mobile_phone_numbers if not already in use
						// UUID check occurred above so okay
	if (
							//isset($contact->user_id) && !empty($contact->user_id) &&
		isset($contact_id) && !empty($contact_id) &&
		isset($contact_phone_number_id) && !empty($contact_phone_number_id) &&
		isset($mobile_network_carrier_id) && !empty($mobile_network_carrier_id)) {

		$mobilePhoneNumber = new MobilePhoneNumber($database);

							// Check for existing data case
		$key = array(
			'contact_id' => $contact_id,
			'contact_phone_number_id' => $contact_phone_number_id
		);
		$mobilePhoneNumber->setKey($key);
		$mobilePhoneNumber->load();
		$isDataLoaded = $mobilePhoneNumber->isDataLoaded();
		if (!$isDataLoaded) {
			$mobilePhoneNumber->setKey(null);
		}

							//$mobilePhoneNumber->user_id = $contact->user_id;
		$mobilePhoneNumber->contact_id = $contact_id;
		$mobilePhoneNumber->contact_phone_number_id = $contact_phone_number_id;
		$mobilePhoneNumber->mobile_network_carrier_id = $mobile_network_carrier_id;
		$mobilePhoneNumber->convertPropertiesToData();
		$mobilePhoneNumber->save();
	}

}
/*import office mobile no*/
function mobilePhoneImportByContactIdOffice($database, $cco, $data, $mobilephone, $type){

		// $elementId = $get->elementId;
	$newValue = $mobilephone;
	$contact_company_office_id = $cco;
	$contact_company_office_phone_number_id = 0;

	$phone_number_type_id = 1;
	if($type == 'business'){
		$phone_number_type_id = 1;
	}
	if($type == 'fax'){
		$phone_number_type_id = 2;
	}
	if (isset($newValue) && !empty($newValue)) {
		$arrPhoneNumber = PhoneNumberType::parsePhoneNumber($newValue);
		$area_code = $arrPhoneNumber['area_code'];
		$prefix = $arrPhoneNumber['prefix'];
		$number = $arrPhoneNumber['number'];
	} else {
		$area_code = '';
		$prefix = '';
		$number = '';
	}

	

		// delete case
	if (!empty($contact_company_office_phone_number_id) && empty($area_code) && empty($prefix) && empty($number)) {
		$ormAction = 'delete';
	} else {
		$ormAction = 'save';
		$data = array(
			'contact_company_office_id' => $contact_company_office_id,
			'phone_number_type_id' => $phone_number_type_id,
					'country_code' => '', // add this later...
					'area_code' => $area_code,
					'prefix' => $prefix,
					'number' => $number,
					'extension' => '', // add this later...
					'itu' => '',
				);
	}


		// contact_phone_numbers table
		// unique index(`contact_id`, `phone_number_type_id`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`),

	if (isset($contact_company_office_phone_number_id) && !empty($contact_company_office_phone_number_id)) {
		$contactCompanyOfficePhoneNumber = ContactCompanyOfficePhoneNumber::findById($database, $contact_company_office_phone_number_id);
	} else {
		$contactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
		$contactCompanyOfficePhoneNumber->setKey(null);
		$contactCompanyOfficePhoneNumber->setData($data);
		$contactCompanyOfficePhoneNumber->save();

		// $contactCompanyOfficePhoneNumber->load();
		// if ($contactCompanyOfficePhoneNumber->isDataLoaded()) {
		// 	$errorMessage = 'Phone number already exists.';
		// 	$message->enqueueError($errorMessage, $currentPhpScript);
		// }
		


	}
}

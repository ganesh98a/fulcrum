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
 * Build a fancy <select> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 */
function buildCostCodeDropDownList(Input $input)
{
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$selected_cost_code = $input->selected_cost_code;
	$htmlElementId = $input->htmlElementId;
	$firstOption = $input->firstOption;
	$selectCssStyle = $input->selectCssStyle;
	$selectedOption = $input->selectedOption;
	$additionalOnchange = (string) $input->additionalOnchange;

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT

	<option value="0">Please Select A Cost Code Below</option>
END_HTML_CONTENT;

	}

	$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadCostCodesByUserCompanyIdOrganizedByCostCodeTypeId($database, $user_company_id);

	$htmlContent = <<<END_HTML_CONTENT

<select id="$htmlElementId" $selectCssStyle onchange="ddlOnChange_UpdateHiddenInputValue(this);$additionalOnchange">
$firstOption
END_HTML_CONTENT;

	foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {

		$currentDivisionNumber = -1;
		$firstDivision = true;

		foreach ($arrCostCodes as $cost_code_id => $costCode) {
			/* $costCode CostCode */

			$costCode->htmlEntityEscapeProperties();
			$escaped_cost_code = $costCode->escaped_cost_code;
			$escaped_cost_code_description = $costCode->escaped_cost_code_description;
			$escaped_cost_code_description_abbreviation = $costCode->escaped_cost_code_description_abbreviation;

			$costCodeDivision = $costCode->getCostCodeDivision();
			/* $costCodeDivision CostCodeDivision */

			$costCodeDivision->htmlEntityEscapeProperties();
			$escaped_division_number = $costCodeDivision->escaped_division_number;
			$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
			$escaped_division = $costCodeDivision->escaped_division;
			$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;

			if ($currentDivisionNumber <> $costCodeDivision->division_number) {
				$currentDivisionNumber = $costCodeDivision->division_number;
				if ($firstDivision) {

					$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$escaped_division ($escaped_division_number-$escaped_division_code_heading)">
END_HTML_CONTENT;

				} else {

					$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$escaped_division ($escaped_division_number-$escaped_division_code_heading)">
END_HTML_CONTENT;

				}
			}

			if ($cost_code_id == $selectedOption) {
				$selected = ' selected';
			} else {
				$selected = '';
			}

			$htmlContent .= <<<END_HTML_CONTENT

		<option value="$cost_code_id"$selected>$escaped_division_number-$escaped_cost_code $escaped_cost_code_description</option>
END_HTML_CONTENT;

		}
	}

	$htmlContent .= <<<END_HTML_CONTENT

</select>
END_HTML_CONTENT;

	return $htmlContent;
}

/**
 * Build a fancy <select> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 * select for the cost codes that has subcontract
 */
function buildCostCodeDropDownListhavesubcontracts(Input $input)
{
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$project_id = $input->project_id;
	$selected_cost_code = $input->selected_cost_code;
	$htmlElementId = $input->htmlElementId;
	$firstOption = $input->firstOption;
	$selectCssStyle = $input->selectCssStyle;
	$selectedOption = $input->selectedOption;
	$additionalOnchange = (string) $input->additionalOnchange;
  //cost code divider
	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT

	<option value="0">Please Select A Cost Code Below</option>
END_HTML_CONTENT;

	}

	$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadCostCodesByUserCompanyIdHasSubcontract($database, $user_company_id,$project_id);

	$htmlContent = <<<END_HTML_CONTENT

<select id="$htmlElementId" $selectCssStyle onchange="ddlOnChange_UpdateHiddenInputValue(this);$additionalOnchange">
$firstOption
END_HTML_CONTENT;

	foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {

		$currentDivisionNumber = -1;
		$firstDivision = true;

		foreach ($arrCostCodes as $cost_code_id => $costCode) {
			/* $costCode CostCode */

			$costCode->htmlEntityEscapeProperties();
			$escaped_cost_code = $costCode->escaped_cost_code;
			$escaped_cost_code_description = $costCode->escaped_cost_code_description;
			$escaped_cost_code_description_abbreviation = $costCode->escaped_cost_code_description_abbreviation;

			$costCodeDivision = $costCode->getCostCodeDivision();
			/* $costCodeDivision CostCodeDivision */

			$costCodeDivision->htmlEntityEscapeProperties();
			$escaped_division_number = $costCodeDivision->escaped_division_number;
			$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
			$escaped_division = $costCodeDivision->escaped_division;
			$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;

			if ($currentDivisionNumber <> $costCodeDivision->division_number) {
				$currentDivisionNumber = $costCodeDivision->division_number;
				$divisionLabel = $escaped_division.'&nbsp;('.$escaped_division_number.$costCodeDividerType.$escaped_division_code_heading.')';
				if ($firstDivision) {

					$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$divisionLabel">
END_HTML_CONTENT;

				} else {

					$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$divisionLabel">
END_HTML_CONTENT;

				}
			}

			if ($cost_code_id == $selectedOption) {
				$selected = ' selected';
			} else {
				$selected = '';
			}
      $costCodeData = $escaped_division_number.$costCodeDividerType.$escaped_cost_code.'&nbsp;'.$escaped_cost_code_description;
			$htmlContent .= <<<END_HTML_CONTENT

		<option value="$cost_code_id"$selected>$costCodeData</option>
END_HTML_CONTENT;

		}
	}

	$htmlContent .= <<<END_HTML_CONTENT

</select>
END_HTML_CONTENT;

	return $htmlContent;
}
/**
 * Build a fancy <select> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 */
function buildProjectTeamMembersDropDownList(Input $input)
{
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$selected_cost_code = $input->selected_cost_code;
	$htmlElementId = $input->htmlElementId;
	$firstOption = $input->firstOption;
	$selectCssStyle = $input->selectCssStyle;

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT
	<option value="0">Please Select A Cost Code Below</option>
END_HTML_CONTENT;

	}

$arrProjectTeamMembers = Contact::loadProjectTeamMembers($database, $project_id);
$js = ' class="moduleRFI_dropdown4"';
$prependedOption = '<option value="-1">Select a contact</option>';

$ddlProjectTeamMembersToId = 'ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--'.$dummyId;
$ddlProjectTeamMembersTo = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersToId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);

$ddlProjectTeamMembersCcId = 'ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-'.$dummyId;
$ddlProjectTeamMembersCc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersCcId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);

$ddlProjectTeamMembersBccId = 'ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-'.$dummyId;
$ddlProjectTeamMembersBcc = PageComponents::dropDownListFromObjects($ddlProjectTeamMembersBccId, $arrProjectTeamMembers, 'contact_id', null, null, 'getContactFullName', null, null, $js, $prependedOption);



	$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadCostCodesByUserCompanyIdOrganizedByCostCodeTypeId($database, $user_company_id);

	$htmlContent = <<<END_HTML_CONTENT

<select id="$htmlElementId" $selectCssStyle>
$firstOption
END_HTML_CONTENT;

	foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {

		$currentDivisionNumber = -1;
		$firstDivision = true;

		foreach ($arrCostCodes as $cost_code_id => $costCode) {
			/* $costCode CostCode */

			$costCode->htmlEntityEscapeProperties();
			$escaped_cost_code = $costCode->escaped_cost_code;
			$escaped_cost_code_description = $costCode->escaped_cost_code_description;
			$escaped_cost_code_description_abbreviation = $costCode->escaped_cost_code_description_abbreviation;

			$costCodeDivision = $costCode->getCostCodeDivision();
			/* $costCodeDivision CostCodeDivision */

			$costCodeDivision->htmlEntityEscapeProperties();
			$escaped_division_number = $costCodeDivision->escaped_division_number;
			$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
			$escaped_division = $costCodeDivision->escaped_division;
			$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;

			if ($currentDivisionNumber <> $costCodeDivision->division_number) {
				$currentDivisionNumber = $costCodeDivision->division_number;

				if ($firstDivision) {

					$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$escaped_division ($escaped_division_number-$escaped_division_code_heading)">
END_HTML_CONTENT;

				} else {

					$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$escaped_division ($escaped_division_number-$escaped_division_code_heading)">
END_HTML_CONTENT;

				}

			}

			$htmlContent .= <<<END_HTML_CONTENT

		<option value="$cost_code_id">$escaped_division_number-$escaped_cost_code $escaped_cost_code_description</option>
END_HTML_CONTENT;

		}
	}

	$htmlContent .= <<<END_HTML_CONTENT

</select>
END_HTML_CONTENT;

	return $htmlContent;
}

/**
 * Build a fancy <select> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 */
function buildContactsFullNameWithEmailByUserCompanyIdDropDownList(Input $input)
{
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$selected_contact_id = $input->selected_contact_id;
	$csvContactIdExclusionList = $input->csvContactIdExclusionList;
	$htmlElementId = (string) $input->htmlElementId;
	$firstOption = (string) $input->firstOption;
	$selectCssStyle = (string) $input->selectCssStyle;
	$js = (string) $input->js;
	$costcode = $input->costcode;
	$project_id = $input->project_id;

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT
	<option value="">Please Select A Contact</option>
END_HTML_CONTENT;

	} else {

		//$firstOption = '<option disabled selected>'.$firstOption.'</option>';
		//$firstOption = '<optgroup label="'.$firstOption.'"><option value="0">'.$firstOption.'</option></optgroup>';
		//$firstOption = '<optgroup><option value="0">'.$firstOption.'</option></optgroup>';

		$firstOption = <<<END_HTML_CONTENT
	<optgroup label="">
		<option value="0">$firstOption</option>
	</optgroup>
END_HTML_CONTENT;

	}

	$loadContactsByUserCompanyIdOptions = new Input();
	$loadContactsByUserCompanyIdOptions->forceLoadFlag = false;
	if (isset($costcode) && $costcode) {

		$arrContactsByUserCompanyId = Contact::loadContactsBycostcodeandUserCompanyId($database, $user_company_id,$costcode,$project_id, $loadContactsByUserCompanyIdOptions);
	}else{
		
	$arrContactsByUserCompanyId = Contact::loadContactsByUserCompanyId($database, $user_company_id, $loadContactsByUserCompanyIdOptions);
}

	$htmlContent = <<<END_HTML_CONTENT

<select id="$htmlElementId" $selectCssStyle $js>
$firstOption
END_HTML_CONTENT;

	$currentCompany = '';
	$first = true;
	
	foreach ($arrContactsByUserCompanyId as $contact_id => $contact) {
		/* @var $contact Contact */

		if (isset($csvContactIdExclusionList[$contact_id])) {
			continue;
		}

		//$contact->htmlEntityEscapeProperties();

		$contactFullNameWithEmail = $contact->getContactFullNameWithEmail(false, '<', '-');
		$encodedContactFullNameWithEmail = Data::entity_encode($contactFullNameWithEmail);

		$contactCompany = $contact->getContactCompany();
		/* @var $contactCompany ContactCompany */

		$contactCompany->htmlEntityEscapeProperties();

		$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;

		if ($currentCompany <> $contactCompany->contact_company_name) {

			$currentCompany = $contactCompany->contact_company_name;
			if ($first) {

				$first = false;

				$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$escaped_contact_company_name">
END_HTML_CONTENT;

			} else {

				$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$escaped_contact_company_name">
END_HTML_CONTENT;

			}

		}
		if($selected_contact_id==$contact_id)
		{
			$selected_opt="selected";
		}else
		{
			$selected_opt="";
		}

		$htmlContent .= <<<END_HTML_CONTENT

		<option value="$contact_id" $selected_opt>$encodedContactFullNameWithEmail</option>
END_HTML_CONTENT;

	}

	$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
</select>
END_HTML_CONTENT;

	return $htmlContent;
}
// COR Recipients
function buildRecipientGrpbyCompanyIdDropDownList(Input $input,$arrProjectTeamMembers)
{
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$selected_contact_id = $input->selected_contact_id;
	$csvContactIdExclusionList = $input->csvContactIdExclusionList;
	$htmlElementId = (string) $input->htmlElementId;
	$firstOption = (string) $input->firstOption;
	$selectCssStyle = (string) $input->selectCssStyle;
	$js = (string) $input->js;
	$costcode = $input->costcode;
	$project_id = $input->project_id;

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT
	<option value="">Please Select A Contact</option>
END_HTML_CONTENT;

	} else {

		
		$firstOption = <<<END_HTML_CONTENT
	<optgroup label="">
		<option value="">$firstOption</option>
	</optgroup>
END_HTML_CONTENT;

	}

	$htmlContent = <<<END_HTML_CONTENT

<select id="$htmlElementId" name="$htmlElementId" $selectCssStyle $js>
$firstOption
END_HTML_CONTENT;

	$currentCompany = '';
	$first = true;
	
	foreach ($arrProjectTeamMembers as $contact_id => $contact) {
		/* @var $contact Contact */

		if (isset($csvContactIdExclusionList[$contact_id])) {
			continue;
		}

		//$contact->htmlEntityEscapeProperties();

		$contactFullNameWithEmail = $contact->getContactFullNameWithEmail(false, '<', '-');
		$encodedContactFullNameWithEmail = Data::entity_encode($contactFullNameWithEmail);

		$contactCompany = $contact->getContactCompany();
		/* @var $contactCompany ContactCompany */

		$contactCompany->htmlEntityEscapeProperties();

		$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;

		if ($currentCompany <> $contactCompany->contact_company_name) {

			$currentCompany = $contactCompany->contact_company_name;
			if ($first) {

				$first = false;

				$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$escaped_contact_company_name">
END_HTML_CONTENT;

			} else {

				$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$escaped_contact_company_name">
END_HTML_CONTENT;

			}

		}
		if($selected_contact_id==$contact_id)
		{
			$selected_opt="selected";
		}else
		{
			$selected_opt="";
		}

		$htmlContent .= <<<END_HTML_CONTENT

		<option value="$contact_id" $selected_opt>$encodedContactFullNameWithEmail</option>
END_HTML_CONTENT;

	}

	$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
</select>
END_HTML_CONTENT;

	return $htmlContent;
}

/**
 * Build a fancy <select> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 */
function buildSubmittalsContactsFullNameWithEmailByUserCompanyIdDropDownList(Input $input)
{
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$selected_contact_id = $input->selected_contact_id;
	$csvContactIdExclusionList = $input->csvContactIdExclusionList;
	$htmlElementId = (string) $input->htmlElementId;
	$firstOption = (string) $input->firstOption;
	$selectCssStyle = (string) $input->selectCssStyle;
	$js = (string) $input->js;
	$costcode = $input->costcode;
	$project_id = $input->project_id;

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT
	<option value="">Please Select A Contact</option>
END_HTML_CONTENT;

	} else {

		$firstOption = <<<END_HTML_CONTENT
	<optgroup label="">
		<option value="0">$firstOption</option>
	</optgroup>
END_HTML_CONTENT;

	}

	$loadContactsByUserCompanyIdOptions = new Input();
	$loadContactsByUserCompanyIdOptions->forceLoadFlag = false;
    $arrContactsByUserCompanyId = Contact::loadSubcontractsByProjectIdAndCostCodeId($database, $user_company_id,$costcode,$project_id, $loadContactsByUserCompanyIdOptions);
	$htmlContent = <<<END_HTML_CONTENT

<select id="$htmlElementId" $selectCssStyle $js>
$firstOption
END_HTML_CONTENT;

	$currentCompany = '';
	$first = true;
	
	foreach ($arrContactsByUserCompanyId as $contact_id => $contact) {
		/* @var $contact Contact */

		if (isset($csvContactIdExclusionList[$contact_id])) {
			continue;
		}

		//$contact->htmlEntityEscapeProperties();

		$contactFullNameWithEmail = $contact->getContactFullNameWithEmail(false, '<', '-');
		$encodedContactFullNameWithEmail = Data::entity_encode($contactFullNameWithEmail);

		$contactCompany = $contact->getContactCompany();
		/* @var $contactCompany ContactCompany */

		$contactCompany->htmlEntityEscapeProperties();

		$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;

		if ($currentCompany <> $contactCompany->contact_company_name) {

			$currentCompany = $contactCompany->contact_company_name;
			if ($first) {

				$first = false;

				$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$escaped_contact_company_name">
END_HTML_CONTENT;

			} else {

				$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$escaped_contact_company_name">
END_HTML_CONTENT;

			}

		}
		if($selected_contact_id==$contact_id)
		{
		   $selected_opt="selected";
		}else if(count($arrContactsByUserCompanyId)==1){
			$selected_opt="selected";
		}else
		{
		   $selected_opt="";
		}

		$htmlContent .= <<<END_HTML_CONTENT

		<option value="$contact_id" $selected_opt>$encodedContactFullNameWithEmail</option>
END_HTML_CONTENT;

	}

	$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
</select>
END_HTML_CONTENT;

	return $htmlContent;
}

function buildProjectFullNameWithEmailDropDownListNew($arrProjectTeamMembers,$js,$name,$selectedId=null){
	$dropDownList = <<<END_DROP_DOWN_LIST
<select id="$name" name="$name" $js>
	<optgroup label="">
		<option value="">Select A Contact</option>
	</optgroup>
END_DROP_DOWN_LIST;
$curcompany='';
$first='';
foreach ($arrProjectTeamMembers as $value) {
	$company  =$value['c_fk_cc__company'];
	if($value['first_name']!='' && $value['last_name']!='')
	{
		$username=$value['first_name'].' '.$value['last_name'].' - ';

	}else
	{
		$username='';

	}
	$email=$value['email'];
	$contact_id=$value['id'];
if($curcompany <> $company)
{
	$curcompany=$company;
	if ($first) {

	$first = false;
	$dropDownList .= <<<END_DROP_DOWN_LIST
	<optgroup label="$company">
END_DROP_DOWN_LIST;

}else {

				$dropDownList .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$company">
END_HTML_CONTENT;

			}
		}
		if($selectedId==$contact_id){
		   $selected_opt="selected";
		}else{
		   $selected_opt="";
		}

	$dropDownList .= <<<END_DROP_DOWN_LIST

<option value="$contact_id" $selected_opt>$username $email</option>
END_DROP_DOWN_LIST;

}
return $dropDownList .= <<<END_DROP_DOWN_LIST
	</select>
END_DROP_DOWN_LIST;

}


function ddlProjectTeamMembers(Input $input){
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$selected_contact_id = $input->selected_contact_id;
	$csvContactIdExclusionList = $input->csvContactIdExclusionList;
	$htmlElementId = (string) $input->htmlElementId;
	$firstOption = (string) $input->firstOption;
	$selectCssStyle = (string) $input->selectCssStyle;
	$js = (string) $input->js;
	$costcode = $input->costcode;
	$project_id = $input->project_id;
	$arrContactsByUserCompanyId = $input->arrContactsByUserCompanyId;

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT
	<option value="">Please Select A Contact</option>
END_HTML_CONTENT;

	} else {

		$firstOption = <<<END_HTML_CONTENT
	<optgroup label="">
		<option value="0">$firstOption</option>
	</optgroup>
END_HTML_CONTENT;

	}

	$loadContactsByUserCompanyIdOptions = new Input();
	$loadContactsByUserCompanyIdOptions->forceLoadFlag = false;
	$htmlContent = <<<END_HTML_CONTENT

<select id="$htmlElementId" $selectCssStyle $js>
$firstOption
END_HTML_CONTENT;

	$currentCompany = '';
	$first = true;
	
	foreach ($arrContactsByUserCompanyId as $contact_id => $contact) {
		/* @var $contact Contact */

		if (isset($csvContactIdExclusionList[$contact_id])) {
			continue;
		}

		//$contact->htmlEntityEscapeProperties();

		$contactFullNameWithEmail = $contact->getContactFullNameWithEmail(false, '<', '-');
		$encodedContactFullNameWithEmail = Data::entity_encode($contactFullNameWithEmail);

		$contactCompany = $contact->getContactCompany();
		/* @var $contactCompany ContactCompany */

		$contactCompany->htmlEntityEscapeProperties();

		$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;

		if ($currentCompany <> $contactCompany->contact_company_name) {

			$currentCompany = $contactCompany->contact_company_name;
			if ($first) {

				$first = false;

				$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$escaped_contact_company_name">
END_HTML_CONTENT;

			} else {

				$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$escaped_contact_company_name">
END_HTML_CONTENT;

			}

		}
		if($selected_contact_id==$contact_id)
		{
		   $selected_opt="selected";
		}else
		{
		   $selected_opt="";
		}

		$htmlContent .= <<<END_HTML_CONTENT

		<option value="$contact_id" $selected_opt>$encodedContactFullNameWithEmail</option>
END_HTML_CONTENT;

	}

	$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
</select>
END_HTML_CONTENT;

	return $htmlContent;
}

/**
 * Build a fancy <select> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 * select all cost codes from project
 */
function buildProjectCostCodeDropDownList(Input $input)
{
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$project_id = $input->project_id;
	$selected_cost_code = $input->selected_cost_code;
	$htmlElementId = $input->htmlElementId;
	$firstOption = $input->firstOption;
	$selectCssStyle = $input->selectCssStyle;
	$selectedOption = $input->selectedOption;
	$additionalOnchange = (string) $input->additionalOnchange;

	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT

	<option value="0">Please Select A Cost Code Below</option>
END_HTML_CONTENT;

	}

	$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadProjectCostCodes($database, $user_company_id,$project_id);

	$htmlContent = <<<END_HTML_CONTENT

<select id="$htmlElementId" $selectCssStyle onchange="ddlOnChange_UpdateHiddenInputValue(this);$additionalOnchange">
$firstOption
END_HTML_CONTENT;

	foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {

		$currentDivisionNumber = -1;
		$firstDivision = true;

		foreach ($arrCostCodes as $cost_code_id => $costCode) {
			/* $costCode CostCode */

			$costCode->htmlEntityEscapeProperties();
			$escaped_cost_code = $costCode->escaped_cost_code;
			$escaped_cost_code_description = $costCode->escaped_cost_code_description;
			$escaped_cost_code_description_abbreviation = $costCode->escaped_cost_code_description_abbreviation;

			$costCodeDivision = $costCode->getCostCodeDivision();
			/* $costCodeDivision CostCodeDivision */

			$costCodeDivision->htmlEntityEscapeProperties();
			$escaped_division_number = $costCodeDivision->escaped_division_number;
			$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
			$escaped_division = $costCodeDivision->escaped_division;
			$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;

			if ($currentDivisionNumber <> $costCodeDivision->division_number) {
				$currentDivisionNumber = $costCodeDivision->division_number;
				$divisionName = $escaped_division_number.$costCodeDividerType.$escaped_division_code_heading;

				if ($firstDivision) {

					$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$escaped_division ($divisionName)">
END_HTML_CONTENT;

				} else {

					$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$escaped_division ($divisionName)">
END_HTML_CONTENT;

				}
			}

			if ($cost_code_id == $selectedOption) {
				$selected = ' selected';
			} else {
				$selected = '';
			}
      $costCodeData = $escaped_division_number.$costCodeDividerType.$escaped_cost_code.'&nbsp;'.$escaped_cost_code_description;
			$htmlContent .= <<<END_HTML_CONTENT

		<option value="$cost_code_id"$selected>$costCodeData</option>
END_HTML_CONTENT;

		}
	}

	$htmlContent .= <<<END_HTML_CONTENT

</select>
END_HTML_CONTENT;

	return $htmlContent;
}

/**
 * Build a fancy <option> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 * select all cost codes from project
 */
function buildProjectCostCodeDropDownListOptions(Input $input)
{
	// Debug
	//$data = $input->getData();

	$database = $input->database;
	$user_company_id = $input->user_company_id;
	$project_id = $input->project_id;
	$selected_cost_code = $input->selected_cost_code;
	$htmlElementId = $input->htmlElementId;
	$firstOption = $input->firstOption;

	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

	if (!isset($firstOption) || empty($firstOption)) {

		$firstOption = <<<END_HTML_CONTENT

	<option value="0">Please Select A Cost Code Below</option>
END_HTML_CONTENT;

	}

	$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadProjectCostCodes($database, $user_company_id,$project_id);

	$htmlContent = <<<END_HTML_CONTENT
	$firstOption
END_HTML_CONTENT;

	foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {

		$currentDivisionNumber = -1;
		$firstDivision = true;

		foreach ($arrCostCodes as $cost_code_id => $costCode) {
			/* $costCode CostCode */

			$costCode->htmlEntityEscapeProperties();
			$escaped_cost_code = $costCode->escaped_cost_code;
			$escaped_cost_code_description = $costCode->escaped_cost_code_description;
			$escaped_cost_code_description_abbreviation = $costCode->escaped_cost_code_description_abbreviation;

			$costCodeDivision = $costCode->getCostCodeDivision();
			/* $costCodeDivision CostCodeDivision */

			$costCodeDivision->htmlEntityEscapeProperties();
			$escaped_division_number = $costCodeDivision->escaped_division_number;
			$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
			$escaped_division = $costCodeDivision->escaped_division;
			$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;

			if ($currentDivisionNumber <> $costCodeDivision->division_number) {
				$currentDivisionNumber = $costCodeDivision->division_number;
				$divisionName = $escaped_division_number.$costCodeDividerType.$escaped_division_code_heading;

				if ($firstDivision) {

					$htmlContent .= <<<END_HTML_CONTENT

	<optgroup label="$escaped_division ($divisionName)">
END_HTML_CONTENT;

				} else {

					$htmlContent .= <<<END_HTML_CONTENT

	</optgroup>
	<optgroup label="$escaped_division ($divisionName)">
END_HTML_CONTENT;

				}
			}

			if ($cost_code_id == $selected_cost_code) {
				$selected = ' selected';
			} else {
				$selected = '';
			}
      $costCodeData = $escaped_division_number.$costCodeDividerType.$escaped_cost_code.'&nbsp;'.$escaped_cost_code_description;
			$htmlContent .= <<<END_HTML_CONTENT

		<option value="$cost_code_id"$selected>$costCodeData</option>
END_HTML_CONTENT;

		}
	}

	return $htmlContent;
}

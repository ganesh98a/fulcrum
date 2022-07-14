<?php

/*
	$listId - Id of the select box
	$listClass - class of the select box
	$listjs - js of the select box
	$liststyle - Style of the select box
	$listDefault - Default option for the select box
*/
function selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$arr_module_result,$selectedkey,$listMultiple=false)
{
	$multiple = $class = $style = '';
	if($listClass !="")
	{
		$class = "class='$listClass'";
	}
	if($liststyle !=  "") 
	{
		$style="style=$liststyle";
	}
	if($listMultiple == true) 
	{
		$multiple="multiple=multiple";
	}
	$droplistTbody = <<<END_Drop_TABLE_TBODY
	<select id="$listId" name="$listId" $class $style $listjs $multiple>
END_Drop_TABLE_TBODY;
	if($listDefault!="") 
	{
		$droplistTbody .= <<<END_Drop_TABLE_TBODY
		<option value="">$listDefault</option>
END_Drop_TABLE_TBODY;
	}

	foreach ($arr_module_result as $key => $modvalue) {

		if($selectedkey == $key)
		{
			$listselected = "selected";
		}else
		{
			$listselected = "";
		}

		$droplistTbody .= <<<END_Drop_TABLE_TBODY
		<option value="$key" $listselected>$modvalue</option>
END_Drop_TABLE_TBODY;
	}

	$droplistTbody .= <<<END_Drop_TABLE_TBODY
	</select>
END_Drop_TABLE_TBODY;
	return $droplistTbody;
}

/*
	for group select box
	$listId - Id of the select box
	$listClass - class of the select box
	$listjs - js of the select box
	$liststyle - Style of the select box
	$listDefault - Default option for the select box
*/
function selectGroupDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault="",$arr_module_result,$listselected="",$listMultiple=false)
{
	$class =  $style = $multiple = "";
	if($listClass != "")
	{
		$class="class='$listClass'";
	}
	if($liststyle != "") 
	{
		$style="style=$liststyle";
	}
	if($listMultiple == true) 
	{
		$multiple="multiple=multiple";
	}
	$droplistTbody = <<<END_Drop_TABLE_TBODY
	<select id="$listId" name="$listId" $class $style $listjs $multiple>
END_Drop_TABLE_TBODY;
	if($listDefault!="") 
	{
		$droplistTbody .= <<<END_Drop_TABLE_TBODY
		<option value="">$listDefault</option>
END_Drop_TABLE_TBODY;
	}
	
	foreach ($arr_module_result as $title => $softresult) {
		$currentprjtag = "";
		$firstDivision = true;

		foreach ($softresult as $key => $modvalue) {
			$groupdata = $title;

			if ($currentprjtag != $groupdata) {
				$currentprjtag = $groupdata;
				if ($firstDivision) {

					$droplistTbody .= <<<END_HTML_CONTENT

					<optgroup label="$groupdata">
END_HTML_CONTENT;

				} else {

					$droplistTbody .= <<<END_HTML_CONTENT

					</optgroup>
					<optgroup label="$groupdata">
END_HTML_CONTENT;

				}
			}

		if($listselected ==$key)
		{
			$listselected="selected";
		}else
		{
			$listselected="";
		}

		$droplistTbody .= <<<END_Drop_TABLE_TBODY
		<option value="$key" $listselected>$modvalue</option>
END_Drop_TABLE_TBODY;
}
	}

	$droplistTbody .= <<<END_Drop_TABLE_TBODY
	</select>
END_Drop_TABLE_TBODY;
	return $droplistTbody;
}

/**
 * Build a fancy <select> with <optgroups>
 *
 * @param Input $input
 * @return HTML String
 */
function buildContactsForPermissionFullNameWithEmailByUserCompanyIdDropDownList(Input $input)
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

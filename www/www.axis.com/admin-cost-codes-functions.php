<?php

require_once('lib/common/CostCodeType.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/CostCode.php');

function renderCostCodeDivisionForm($database, $user_company_id)
{
	$loadCostCodeDivisionsByUserCompanyIdOptions = new Input();
	$loadCostCodeDivisionsByUserCompanyIdOptions->arrOrderByAttributes = array(
		'ccd.`division_number`' => 'ASC'
	);
	$arrCostCodeDivisionsByUserCompanyId = CostCodeDivision::loadCostCodeDivisionsByUserCompanyId($database, $user_company_id, $loadCostCodeDivisionsByUserCompanyIdOptions);

	$costCodeDivision = new CostCodeDivision($database);
	$arrAttributesMap = $costCodeDivision->getArrAttributesMap();

	if (isset($arrAttributesMap['sort_order'])) {
		$sortOrderFlag = true;
		$sortOrderPlaceHolderTd = '<td width="20">&nbsp;</td>';
	} else {
		$sortOrderFlag = false;
		$sortOrderPlaceHolderTd = '';
	}

	//ob_start();


	$htmlCreateFormHeader = '';
	$htmlFormHeader = '';
	$htmlFormRow = '';
	$htmlForm =
'
<form>
<br>
<div align="center"><b>Cost Code Division Records - C.R.U.D. Pattern</b></div>
<div align="center"><b>cost_code_divisions Records - C.R.U.D. Pattern</b></div>
<br>
<input id="formattedAttributeGroupName--create-cost_code_division-record" type="hidden" value="Cost Code Division">
<input id="formattedAttributeSubgroupName--create-cost_code_division-record" type="hidden" value="Cost Code Divisions">
<input id="formattedAttributeGroupName--manage-cost_code_division-record" type="hidden" value="Cost Code Division">
<input id="formattedAttributeSubgroupName--manage-cost_code_division-record" type="hidden" value="Cost Code Divisions">
<table>
';
	// Header code with sortable attributes via ajax load

	$arrPropertiesToFormattedPropertyNames = array();
	$htmlCreateFormHeader = '<tr>
<td width="5">&nbsp;</td>
';

	$htmlFormHeader = <<<END_HTML_FORM_HEADER
<thead>
<tr>
$sortOrderPlaceHolderTd
<td width="20">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="5">&nbsp;</td>
END_HTML_FORM_HEADER;

	$htmlCreateRecord = '<tr>
<td width="5">&nbsp;</td>
';

	$dummyPlaceholderRow = '<tr>
';

	$dummyRecordPrimaryKeyTop = 'dummy_id_top-'.uniqid();
	$dummyRecordPrimaryKeyBottom = 'dummy_id_bottom-'.uniqid();
	foreach ($arrAttributesMap as $attribute => $property) {
		$htmlClass = '';
		if (($attribute == 'modified') || ($attribute == 'created')) {
			$readonly = ' readonly';
		} else {
			$readonly = '';

			if (is_int(strpos($attribute, 'date'))) {
				$htmlClass = ' class="datepicker"';
			}
		}

		$htmlCreateFormHeader .= '<td>';
		// E.g. loadAllCostCodeDivisionRecords(recordListContainerElementId, attributeGroupName, options)
		$htmlFormHeader .= '<td onclick="loadAllCostCodeDivisionRecords(\'record_list_container--manage-cost_code_division-record\', \'manage-cost_code_division-record\');">';

		// @todo Add maxlength
		$arrTmp = explode('_', $property);
		$arrHtmlFormInputName = array_map('ucfirst', $arrTmp);
		$formattedAttributeName = join(' ', $arrHtmlFormInputName);
		$htmlFormInputName = join('<br>', $arrHtmlFormInputName);
		$arrPropertiesToFormattedPropertyNames[$property] = $arrHtmlFormInputName;

		$htmlCreateFormHeader .= $htmlFormInputName;
		$htmlCreateFormHeader .= '</td>
';

		$htmlFormHeader .= $htmlFormInputName;
		$htmlFormHeader .= '</td>
';

		$htmlCreateRecord .= '<td width="1%">';
		if (is_int(strpos($attribute, '_flag'))) {
			$checked = '';
			$htmlCreateRecord .= '
<input id="create-cost_code_division-record--cost_code_divisions--'.$attribute.'-----find_replace_dummy_primary_key---"'.$htmlClass.' type="checkbox"'.$readonly.$checked.'>
';
		} else {
			$htmlCreateRecord .= '
<input id="create-cost_code_division-record--cost_code_divisions--'.$attribute.'-----find_replace_dummy_primary_key---"'.$htmlClass.' type="text" value=""'.$readonly.'>
';
		}
		$htmlCreateRecord .=
'<input id="formattedAttributeName--create-cost_code_division-record--cost_code_divisions--'.$attribute.'-----find_replace_dummy_primary_key---" type="hidden" value="'.$formattedAttributeName.'">
</td>
';

		$dummyPlaceholderRow .= '<td>&nbsp;</td>';

	}
	$dummyPlaceholderRow .= '</tr>
';

	$htmlCreateFormHeader .= '</tr>
';

	$htmlFormHeader .= '<td>&nbsp;</td>
</tr>
</thead>
';

	$htmlCreateRecord .= <<<END_HTML_CREATE_RECORD
<td><input type="button" onclick="createCostCodeDivision('create-cost_code_division-record', '---find_replace_dummy_primary_key---', { responseDataType : 'json', performRefreshOperation: 'Y' });" type="text" value="Create New Cost Code Division"></td>
</tr>
END_HTML_CREATE_RECORD;

	$htmlCreateRecord = $htmlCreateFormHeader . $htmlCreateRecord;

	$htmlCreateRecordTop = str_replace('---find_replace_dummy_primary_key---', $dummyRecordPrimaryKeyTop, $htmlCreateRecord);

	$htmlForm .= $htmlCreateRecordTop;
	$htmlForm .= $dummyPlaceholderRow;
	$htmlForm .= $dummyPlaceholderRow;

	$htmlForm .= '</table>
<table id="record_list_container--manage-cost_code_division-record" border="1">
';
	$htmlForm .= $htmlFormHeader;

	$htmlForm .= '
<tbody>
';

	if ($sortOrderFlag) {
		//$trIdPrefix = 'manage-cost_code_division-record--cost_code_divisions--sort_order--';
		$trIdPrefix = 'record_container--manage-cost_code_division-record--cost_code_divisions--sort_order--';
	} else {
		$trIdPrefix = 'record_container--manage-cost_code_division-record--cost_code_divisions--';
	}

	foreach ($arrCostCodeDivisionsByUserCompanyId as $cost_code_division_id => $costCodeDivision) {
		$primaryKeyAsString = $costCodeDivision->getPrimaryKeyAsString();

		if ($sortOrderFlag) {
			$sort_order = $costCodeDivision->sort_order;
			$sortOrderHiddenElement = '<input id="formattedAttributeName--manage-action_item_assignment-record--action_item_assignments--sort_order--'.$primaryKeyAsString.'" type="hidden" value="Sort Order">';
			$sortOrderTd = '<td class="tdSortBars textAlignCenter"><input type="hidden" id="manage-action_item_assignment-record--action_item_assignments--sort_order--'.$primaryKeyAsString.'" value="'.$sort_order.'"><img class="bs-tooltip" src="/images/sortbars.png" title="Drag bars to change sort order"></td>';
		} else {
			$sortOrderHiddenElement = '';
			$sortOrderTd = '';
		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		$htmlForm .= '<tr id="'.$trIdPrefix.$primaryKeyAsString.'">' . $sortOrderHiddenElement;

		// @todo Add a foreach loop for all database candidate keys to have delete html code here:
		// , performDomDeleteOperation : 'Y'
		$htmlForm .= <<<HTML_FORM
$sortOrderTd
<td><span class="entypo entypo-click entypo-plus-circled bs-tooltip" onclick="renderCostCodeDivisionCreationForm('tabularDataRowHorizontalCreationForm', '{$trIdPrefix}{$primaryKeyAsString}');" title="Insert Blank Row"></span></td>

<td width="5"><a class="bs-tooltip" title="Delete Cost Code Division Record" href="javascript:deleteCostCodeDivision('{$trIdPrefix}{$primaryKeyAsString}', 'manage-cost_code_division-record', '$primaryKeyAsString', { responseDataType : 'json' });">X</a></td>
<td width="5"><a class="bs-tooltip" title="Custom Delete Cost Code Division Record" href="javascript:deleteCostCodeDivision_interfaceSpecific(this, event, '$primaryKeyAsString');">X</a></td>
<td width="5"><a class="bs-tooltip" title="Custom Delete Cost Code Division Record" href="#" onclick="deleteCostCodeDivision_interfaceSpecific(this, event, '$primaryKeyAsString');">X</a></td>
<td width="5"><a class="bs-tooltip" title="Custom Delete Cost Code Division Record" href="javascript:void(0);" onclick="deleteCostCodeDivision_interfaceSpecific(this, event, '$primaryKeyAsString');">X</a></td>

<td><span class="entypo entypo-click entypo-cancel-circled bs-tooltip" title="Custom Delete Cost Code Division Record" onclick="deleteCostCodeDivision_interfaceSpecific(this, event, '$primaryKeyAsString');"></span></td>

HTML_FORM;
		$data = $costCodeDivision->getData();
		foreach ($arrAttributesMap as $attribute => $property) {
			if (isset($data[$attribute])) {
				$value = $data[$attribute];
			} else {
				$value = '';
			}
			$htmlClass = '';
			if (($attribute == 'modified') || ($attribute == 'created')) {
				$readonly = ' readonly';
			} else {
				$readonly = '';

				if (is_int(strpos($attribute, 'date')) || is_int(strpos($attribute, 'datetime')) || is_int(strpos($attribute, 'timestamp'))) {
					$htmlClass = ' class="datepicker"';
				}
			}
			$htmlForm .= '<td width="1%">';
			if (is_int(strpos($attribute, '_flag'))) {
				if ($value == 'Y') {
					$checked = ' checked';
				} else {
					$checked = '';
				}
				$htmlForm .= '<input id="manage-cost_code_division-record--cost_code_divisions--'.$property.'--'.$primaryKeyAsString.'"'.$htmlClass.' onchange="updateCostCodeDivision(this, { responseDataType : \'json\' })" type="checkbox"'.$readonly.$checked.'>';
			} else {
				$htmlForm .= '<input id="manage-cost_code_division-record--cost_code_divisions--'.$property.'--'.$primaryKeyAsString.'"'.$htmlClass.' onchange="updateCostCodeDivision(this, { responseDataType : \'json\' })" type="text" value="'.$value.'"'.$readonly.'>';
			}
			$htmlForm .= '<input id="previous--manage-cost_code_division-record--cost_code_divisions--'.$property.'--'.$primaryKeyAsString.'" type="hidden" value="'.$value.'">';
			$htmlForm .= '</td>
';
		} //updateAllCostCodeDivisionAttributes(attributeGroupName, uniqueId)
		$htmlForm .= '<td><input type="button" onclick="updateAllCostCodeDivisionAttributes(\'manage-cost_code_division-record\', \''.$primaryKeyAsString.'\');" type="text" value="Update all Fields"></td>
';
		$htmlForm .= '</tr>
';
	}

	$htmlCreateRecordBottom = str_replace('---find_replace_dummy_primary_key---', $dummyRecordPrimaryKeyBottom, $htmlCreateRecord);

	$htmlForm .= '</tbody>
</table>
<table>
';
	$htmlForm .= $dummyPlaceholderRow;
	$htmlForm .= $dummyPlaceholderRow;
	$htmlForm .= $htmlCreateRecordBottom;
	$htmlForm .= $dummyPlaceholderRow;
	$htmlForm .= $dummyPlaceholderRow;

	$htmlForm .=
'
</table>
</form>
';

	//$html = ob_get_clean();

	return $htmlForm;
}

function renderCostCodeDivisionTabularDataRowHorizontalCreationForm(CostCodeDivision $costCodeDivision, Input $options)
{
	// Get primary key / unique key via get input
	$attributeGroupName = (string) $options->attributeGroupName;
	$attributeSubgroupName = (string) $options->attributeSubgroupName;
	$uniqueId = (string) $options->uniqueId;
	$newAttributeGroupName = (string) $options->newAttributeGroupName;
	$formattedAttributeGroupName = (string) $options->formattedAttributeGroupName;
	$formattedAttributeSubgroupName = (string) $options->formattedAttributeSubgroupName;

	$responseDataType = (string) $options->responseDataType;
	$skipDefaultSuccessCallback = (string) $options->skipDefaultSuccessCallback;
	$htmlRecordCreationFormType = (string) $options->htmlRecordCreationFormType;

	// @todo Add these above to allow for them to affect the form creation and form "Create Button"
	$performDomSwapOperation = (string) $options->performDomSwapOperation;
	$performReplaceOperation = (string) $options->performReplaceOperation;
	$performAppendOperation = (string) $options->performAppendOperation;
	$performRefreshOperation = (string) $options->performRefreshOperation;
	$refreshOperationType = (string) $options->refreshOperationType;
	$refreshOperationContainerElementId = (string) $options->refreshOperationContainerElementId;
	$refreshOperationUrl = (string) $options->refreshOperationUrl;
	$displayUserMessages = (string) $options->displayUserMessages;
	$displayCustomErrorMessage = (string) $options->displayCustomErrorMessage;
	$customErrorMessage = (string) $options->customErrorMessage;
	$displayCustomSuccessMessage = (string) $options->displayCustomSuccessMessage;
	$customSuccessMessage = (string) $options->customSuccessMessage;
	$displayAdditionalCustomUserMessage = (string) $options->displayAdditionalCustomUserMessage;
	$additionalCustomUserMessageType = (string) $options->additionalCustomUserMessageType;
	$additionalCustomUserMessage = (string) $options->additionalCustomUserMessage;

	// Foreign key values

	// This does not exist and is for an example only
	$sort_order = 1; 
	
	$dummyId = $uniqueId;

	// Test for existence of sort_order attribute
	// E.g. $htmlRecordContainerElementId = 'record_container--create-project-record--projects--'.$dummyId;
	$htmlRecordContainerElementId = 'record_container--' . $attributeGroupName . '--' . $attributeSubgroupName . '--sort_order--' . $dummyId;

	// E.g. $attributeElementIdPrefix = 'create-project-record--projects';
	$attributeElementIdPrefix = $attributeGroupName . '--' . $attributeSubgroupName;

	// Note: Add the "Insert Blank Row" and "Delete Row" cells
	$htmlRecordCreationForm = <<<END_HTML_CREATION_FORM

<tr id="$htmlRecordContainerElementId" class="">

<td class="spread-td tdSortBars textAlignCenter">
<img src="/images/sortbars.png" rel="tooltip" title="Drag bars to change sort order">
</td>

<td width="20">&nbsp;</td>
<td width="5">
<a class="bs-tooltip" href="javascript:removeDomElement('$htmlRecordContainerElementId');" title="Delete Row">X</a>
</td>

END_HTML_CREATION_FORM;

	$tabIndex = 1;
	$arrAttributesMap = $costCodeDivision->getArrAttributesMap();
	foreach ($arrAttributesMap as $attribute => $property) {
		$htmlClass = '';
		if (($attribute == 'modified') || ($attribute == 'created')) {
			$readonly = ' readonly';
		} else {
			$readonly = '';

			if (is_int(strpos($attribute, 'date'))) {
				$htmlClass = ' class="datepicker"';
			}
		}

		// @todo Add maxlength
		$arrTmp = explode('_', $property);
		$arrHtmlFormInputName = array_map('ucfirst', $arrTmp);
		$formattedAttributeName = join(' ', $arrHtmlFormInputName);

		$value = '';
		if (is_int(strpos($attribute, '_flag'))) {
			if ($value == 'Y') {
				$checked = ' checked';
			} else {
				$checked = '';
			}

			$htmlRecordCreationForm .= <<<END_HTML_CREATION_FORM

<td class="">
<input id="$attributeElementIdPrefix--$attribute--$dummyId"$htmlClass onchange="" tabIndex="$tabIndex" type="checkbox"{$readonly}{$checked}>

END_HTML_CREATION_FORM;

		} else {

			$htmlRecordCreationForm .= <<<END_HTML_CREATION_FORM

<td class="">
<input id="$attributeElementIdPrefix--$attribute--$dummyId"$htmlClass onchange="" tabIndex="$tabIndex" type="text" value="">

END_HTML_CREATION_FORM;

		}
		$htmlRecordCreationForm .= <<<END_HTML_CREATION_FORM
<input id="formattedAttributeName--$attributeElementIdPrefix--$attribute--$dummyId" type="hidden" value="$formattedAttributeName">
</td>

END_HTML_CREATION_FORM;

		$tabIndex++;

	}

	// @todo Add all the "Create Button" directives inline below
	if ($performDomSwapOperation == 'Y') {
		$performDomSwapOperationDirective = ", performDomSwapOperation: 'Y'";
	}
	$htmlRecordCreationForm .= <<<END_HTML_CREATION_FORM

<td>
<input type="button" onclick="createCostCodeDivision('$attributeGroupName', '$dummyId', { responseDataType : 'json'$performDomSwapOperationDirective });" type="text" value="Create New CostCodeDivision">
</td>

</tr>
END_HTML_CREATION_FORM;

	return $htmlRecordCreationForm;

}

function renderCostCodeForm($database, $user_company_id, $cost_code_type_id)
{
	$loadCostCodesByUserCompanyIdAndCostCodeTypeIdOptions = new Input();
	$loadCostCodesByUserCompanyIdAndCostCodeTypeIdOptions->arrOrderByAttributes = array(
		'codes.`cost_code`' => 'ASC'
	);
	$arrAllCostCodeRecords = CostCode::loadCostCodesByUserCompanyIdAndCostCodeTypeId($database, $user_company_id, $cost_code_type_id, $loadCostCodesByUserCompanyIdAndCostCodeTypeIdOptions);

	$costCode = new CostCode($database);
	$arrAttributesMap = $costCode->getArrAttributesMap();

	if (isset($arrAttributesMap['sort_order'])) {
		$sortOrderFlag = true;
		$sortOrderPlaceHolderTd = '<td width="20">&nbsp;</td>';
	} else {
		$sortOrderFlag = false;
		$sortOrderPlaceHolderTd = '';
	}

	//ob_start();


	$htmlCreateFormHeader = '';
	$htmlFormHeader = '';
	$htmlFormRow = '';
	$htmlForm =
'
<form>
<br>
<div align="center"><b>Cost Code Records - C.R.U.D. Pattern</b></div>
<div align="center"><b>cost_codes Records - C.R.U.D. Pattern</b></div>
<br>
<input id="formattedAttributeGroupName--create-cost_code-record" type="hidden" value="Cost Code">
<input id="formattedAttributeSubgroupName--create-cost_code-record" type="hidden" value="Cost Codes">
<input id="formattedAttributeGroupName--manage-cost_code-record" type="hidden" value="Cost Code">
<input id="formattedAttributeSubgroupName--manage-cost_code-record" type="hidden" value="Cost Codes">
<table>
';
	// $costCode = array_shift($arrAllCostCodeRecords);
	// Header code with sortable attributes via ajax load

	$arrPropertiesToFormattedPropertyNames = array();
	$htmlCreateFormHeader = '<tr>
<td width="5">&nbsp;</td>
';

	$htmlFormHeader = <<<END_HTML_FORM_HEADER
<thead>
<tr>
$sortOrderPlaceHolderTd
<td width="20">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="5">&nbsp;</td>
<td width="5">&nbsp;</td>
END_HTML_FORM_HEADER;

	$htmlCreateRecord = '<tr>
<td width="5">&nbsp;</td>
';

	$dummyPlaceholderRow = '<tr>
';

	$dummyRecordPrimaryKeyTop = 'dummy_id_top-'.uniqid();
	$dummyRecordPrimaryKeyBottom = 'dummy_id_bottom-'.uniqid();
	foreach ($arrAttributesMap as $attribute => $property) {
		$htmlClass = '';
		if (($attribute == 'modified') || ($attribute == 'created')) {
			$readonly = ' readonly';
		} else {
			$readonly = '';

			if (is_int(strpos($attribute, 'date'))) {
				$htmlClass = ' class="datepicker"';
			}
		}

		$htmlCreateFormHeader .= '<td>';
		// E.g. loadAllCostCodeRecords(recordListContainerElementId, attributeGroupName, options)
		$htmlFormHeader .= '<td onclick="loadAllCostCodeRecords(\'record_list_container--manage-cost_code-record\', \'manage-cost_code-record\');">';

		// @todo Add maxlength
		$arrTmp = explode('_', $property);
		$arrHtmlFormInputName = array_map('ucfirst', $arrTmp);
		$formattedAttributeName = join(' ', $arrHtmlFormInputName);
		$htmlFormInputName = join('<br>', $arrHtmlFormInputName);
		$arrPropertiesToFormattedPropertyNames[$property] = $arrHtmlFormInputName;

		$htmlCreateFormHeader .= $htmlFormInputName;
		$htmlCreateFormHeader .= '</td>
';

		$htmlFormHeader .= $htmlFormInputName;
		$htmlFormHeader .= '</td>
';

		$htmlCreateRecord .= '<td width="1%">';
		if (is_int(strpos($attribute, '_flag'))) {
			$checked = '';
			$htmlCreateRecord .= '
<input id="create-cost_code-record--cost_codes--'.$attribute.'-----find_replace_dummy_primary_key---"'.$htmlClass.' type="checkbox"'.$readonly.$checked.'>
';
		} else {
			$htmlCreateRecord .= '
<input id="create-cost_code-record--cost_codes--'.$attribute.'-----find_replace_dummy_primary_key---"'.$htmlClass.' type="text" value=""'.$readonly.'>
';
		}
		$htmlCreateRecord .=
'<input id="formattedAttributeName--create-cost_code-record--cost_codes--'.$attribute.'-----find_replace_dummy_primary_key---" type="hidden" value="'.$formattedAttributeName.'">
</td>
';

		$dummyPlaceholderRow .= '<td>&nbsp;</td>';

	}
	$dummyPlaceholderRow .= '</tr>
';

	$htmlCreateFormHeader .= '</tr>
';

	$htmlFormHeader .= '<td>&nbsp;</td>
</tr>
</thead>
';

	$htmlCreateRecord .= <<<END_HTML_CREATE_RECORD
<td><input type="button" onclick="createCostCode('create-cost_code-record', '---find_replace_dummy_primary_key---', { responseDataType : 'json', performRefreshOperation: 'Y' });" type="text" value="Create New Cost Code"></td>
</tr>
END_HTML_CREATE_RECORD;

	$htmlCreateRecord = $htmlCreateFormHeader . $htmlCreateRecord;

	$htmlCreateRecordTop = str_replace('---find_replace_dummy_primary_key---', $dummyRecordPrimaryKeyTop, $htmlCreateRecord);

	$htmlForm .= $htmlCreateRecordTop;
	$htmlForm .= $dummyPlaceholderRow;
	$htmlForm .= $dummyPlaceholderRow;

	$htmlForm .= '</table>
<table id="record_list_container--manage-cost_code-record" border="1">
';
	$htmlForm .= $htmlFormHeader;

	$htmlForm .= '
<tbody>
';

	if ($sortOrderFlag) {
		$trIdPrefix = 'record_container--manage-cost_code-record--cost_codes--sort_order--';
	} else {
		$trIdPrefix = 'record_container--manage-cost_code-record--cost_codes--';
	}

	foreach ($arrAllCostCodeRecords as $cost_code_id => $costCode) {
		$primaryKeyAsString = $costCode->getPrimaryKeyAsString();

		if ($sortOrderFlag) {
			$sort_order = $costCode->sort_order;
			$sortOrderHiddenElement = '<input id="formattedAttributeName--manage-action_item_assignment-record--action_item_assignments--sort_order--'.$primaryKeyAsString.'" type="hidden" value="Sort Order">';
			$sortOrderTd = '<td class="tdSortBars textAlignCenter"><input type="hidden" id="manage-action_item_assignment-record--action_item_assignments--sort_order--'.$primaryKeyAsString.'" value="'.$sort_order.'"><img class="bs-tooltip" src="/images/sortbars.png" title="Drag bars to change sort order"></td>';
		} else {
			$sortOrderHiddenElement = '';
			$sortOrderTd = '';
		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		$htmlForm .= '<tr id="'.$trIdPrefix.$primaryKeyAsString.'">' . $sortOrderHiddenElement;

		// @todo Add a foreach loop for all database candidate keys to have delete html code here:
		// , performDomDeleteOperation : 'Y'
		$htmlForm .= <<<HTML_FORM
$sortOrderTd
<td><span class="entypo entypo-click entypo-plus-circled bs-tooltip" onclick="renderCostCodeCreationForm('tabularDataRowHorizontalCreationForm', '{$trIdPrefix}{$primaryKeyAsString}');" title="Insert Blank Row"></span></td>

<td width="5"><a class="bs-tooltip" title="Delete Cost Code Record" href="javascript:deleteCostCode('{$trIdPrefix}{$primaryKeyAsString}', 'manage-cost_code-record', '$primaryKeyAsString', { responseDataType : 'json' });">X</a></td>
<td width="5"><a class="bs-tooltip" title="Custom Delete Cost Code Record" href="javascript:deleteCostCode_interfaceSpecific(this, event, '$primaryKeyAsString');">X</a></td>
<td width="5"><a class="bs-tooltip" title="Custom Delete Cost Code Record" href="#" onclick="deleteCostCode_interfaceSpecific(this, event, '$primaryKeyAsString');">X</a></td>
<td width="5"><a class="bs-tooltip" title="Custom Delete Cost Code Record" href="javascript:void(0);" onclick="deleteCostCode_interfaceSpecific(this, event, '$primaryKeyAsString');">X</a></td>

<td><span class="entypo entypo-click entypo-cancel-circled bs-tooltip" title="Custom Delete Cost Code Record" onclick="deleteCostCode_interfaceSpecific(this, event, '$primaryKeyAsString');"></span></td>

HTML_FORM;
		$data = $costCode->getData();
		foreach ($arrAttributesMap as $attribute => $property) {
			if (isset($data[$attribute])) {
				$value = $data[$attribute];
			} else {
				$value = '';
			}
			$htmlClass = '';
			if (($attribute == 'modified') || ($attribute == 'created')) {
				$readonly = ' readonly';
			} else {
				$readonly = '';

				if (is_int(strpos($attribute, 'date')) || is_int(strpos($attribute, 'datetime')) || is_int(strpos($attribute, 'timestamp'))) {
					$htmlClass = ' class="datepicker"';
				}
			}
			$htmlForm .= '<td width="1%">';
			if (is_int(strpos($attribute, '_flag'))) {
				if ($value == 'Y') {
					$checked = ' checked';
				} else {
					$checked = '';
				}
				$htmlForm .= '<input id="manage-cost_code-record--cost_codes--'.$property.'--'.$primaryKeyAsString.'"'.$htmlClass.' onchange="updateCostCode(this, { responseDataType : \'json\' })" type="checkbox"'.$readonly.$checked.'>';
			} else {
				$htmlForm .= '<input id="manage-cost_code-record--cost_codes--'.$property.'--'.$primaryKeyAsString.'"'.$htmlClass.' onchange="updateCostCode(this, { responseDataType : \'json\' })" type="text" value="'.$value.'"'.$readonly.'>';
			}
			$htmlForm .= '<input id="previous--manage-cost_code-record--cost_codes--'.$property.'--'.$primaryKeyAsString.'" type="hidden" value="'.$value.'">';
			$htmlForm .= '</td>
';
		} //updateAllCostCodeAttributes(attributeGroupName, uniqueId)
		$htmlForm .= '<td><input type="button" onclick="updateAllCostCodeAttributes(\'manage-cost_code-record\', \''.$primaryKeyAsString.'\');" type="text" value="Update all Fields"></td>
';
		$htmlForm .= '</tr>
';
	}

	$htmlCreateRecordBottom = str_replace('---find_replace_dummy_primary_key---', $dummyRecordPrimaryKeyBottom, $htmlCreateRecord);

	$htmlForm .= '</tbody>
</table>
<table>
';
	$htmlForm .= $dummyPlaceholderRow;
	$htmlForm .= $dummyPlaceholderRow;
	$htmlForm .= $htmlCreateRecordBottom;
	$htmlForm .= $dummyPlaceholderRow;
	$htmlForm .= $dummyPlaceholderRow;

	$htmlForm .=
'
</table>
</form>
';

	//$html = ob_get_clean();

	return $htmlForm;
}

function renderCostCodeTabularDataRowHorizontalCreationForm(CostCode $costCode, Input $options)
{
	// Get primary key / unique key via get input
	$attributeGroupName = (string) $options->attributeGroupName;
	$attributeSubgroupName = (string) $options->attributeSubgroupName;
	$uniqueId = (string) $options->uniqueId;
	$newAttributeGroupName = (string) $options->newAttributeGroupName;
	$formattedAttributeGroupName = (string) $options->formattedAttributeGroupName;
	$formattedAttributeSubgroupName = (string) $options->formattedAttributeSubgroupName;

	$responseDataType = (string) $options->responseDataType;
	$skipDefaultSuccessCallback = (string) $options->skipDefaultSuccessCallback;
	$htmlRecordCreationFormType = (string) $options->htmlRecordCreationFormType;

	// @todo Add these above to allow for them to affect the form creation and form "Create Button"
	$performDomSwapOperation = (string) $options->performDomSwapOperation;
	$performReplaceOperation = (string) $options->performReplaceOperation;
	$performAppendOperation = (string) $options->performAppendOperation;
	$performRefreshOperation = (string) $options->performRefreshOperation;
	$refreshOperationType = (string) $options->refreshOperationType;
	$refreshOperationContainerElementId = (string) $options->refreshOperationContainerElementId;
	$refreshOperationUrl = (string) $options->refreshOperationUrl;
	$displayUserMessages = (string) $options->displayUserMessages;
	$displayCustomErrorMessage = (string) $options->displayCustomErrorMessage;
	$customErrorMessage = (string) $options->customErrorMessage;
	$displayCustomSuccessMessage = (string) $options->displayCustomSuccessMessage;
	$customSuccessMessage = (string) $options->customSuccessMessage;
	$displayAdditionalCustomUserMessage = (string) $options->displayAdditionalCustomUserMessage;
	$additionalCustomUserMessageType = (string) $options->additionalCustomUserMessageType;
	$additionalCustomUserMessage = (string) $options->additionalCustomUserMessage;

	// This does not exist and is for an example only
	$sort_order = 1;

	$dummyId = $uniqueId;

	// Test for existence of sort_order attribute
	// E.g. $htmlRecordContainerElementId = 'record_container--create-project-record--projects--'.$dummyId;
	$htmlRecordContainerElementId = 'record_container--' . $attributeGroupName . '--' . $attributeSubgroupName . '--sort_order--' . $dummyId;

	// E.g. $attributeElementIdPrefix = 'create-project-record--projects';
	$attributeElementIdPrefix = $attributeGroupName . '--' . $attributeSubgroupName;

	// Note: Add the "Insert Blank Row" and "Delete Row" cells
	$htmlRecordCreationForm = <<<END_HTML_CREATION_FORM

<tr id="$htmlRecordContainerElementId" class="">

<td class="spread-td tdSortBars textAlignCenter">
<img src="/images/sortbars.png" rel="tooltip" title="Drag bars to change sort order">
</td>

<td width="20">&nbsp;</td>
<td width="5">
<a class="bs-tooltip" href="javascript:removeDomElement('$htmlRecordContainerElementId');" title="Delete Row">X</a>
</td>

END_HTML_CREATION_FORM;

	$tabIndex = 1;
	$arrAttributesMap = $costCode->getArrAttributesMap();
	foreach ($arrAttributesMap as $attribute => $property) {
		$htmlClass = '';
		if (($attribute == 'modified') || ($attribute == 'created')) {
			$readonly = ' readonly';
		} else {
			$readonly = '';

			if (is_int(strpos($attribute, 'date'))) {
				$htmlClass = ' class="datepicker"';
			}
		}

		// @todo Add maxlength
		$arrTmp = explode('_', $property);
		$arrHtmlFormInputName = array_map('ucfirst', $arrTmp);
		$formattedAttributeName = join(' ', $arrHtmlFormInputName);

		$value = '';
		if (is_int(strpos($attribute, '_flag'))) {
			if ($value == 'Y') {
				$checked = ' checked';
			} else {
				$checked = '';
			}

			$htmlRecordCreationForm .= <<<END_HTML_CREATION_FORM

<td class="">
<input id="$attributeElementIdPrefix--$attribute--$dummyId"$htmlClass onchange="" tabIndex="$tabIndex" type="checkbox"{$readonly}{$checked}>

END_HTML_CREATION_FORM;

		} else {

			$htmlRecordCreationForm .= <<<END_HTML_CREATION_FORM

<td class="">
<input id="$attributeElementIdPrefix--$attribute--$dummyId"$htmlClass onchange="" tabIndex="$tabIndex" type="text" value="">

END_HTML_CREATION_FORM;

		}
		$htmlRecordCreationForm .= <<<END_HTML_CREATION_FORM
<input id="formattedAttributeName--$attributeElementIdPrefix--$attribute--$dummyId" type="hidden" value="$formattedAttributeName">
</td>

END_HTML_CREATION_FORM;

		$tabIndex++;

	}

	// @todo Add all the "Create Button" directives inline below
	if ($performDomSwapOperation == 'Y') {
		$performDomSwapOperationDirective = ", performDomSwapOperation: 'Y'";
	}
	$htmlRecordCreationForm .= <<<END_HTML_CREATION_FORM

<td>
<input type="button" onclick="createCostCode('$attributeGroupName', '$dummyId', { responseDataType : 'json'$performDomSwapOperationDirective });" type="text" value="Create New CostCode">
</td>

</tr>
END_HTML_CREATION_FORM;

	return $htmlRecordCreationForm;

}

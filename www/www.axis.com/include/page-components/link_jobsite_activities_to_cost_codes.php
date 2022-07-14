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

$userCompany = UserCompany::findById($database, $user_company_id);
/* @var $userCompany UserCompany */

$jobsiteActivityTableName;
$jobsite_activity_id;

$attributeGroupName = '';
$jobsite_activity_id_attribute = '';

$options = new Input();
$options->forceLoadFlag = true;

// Load the relationshipd data to allow "checked" checkboxes
if ($jobsiteActivityTableName == 'jobsite_building_activities') {
	$jobsite_building_activity_id = $jobsite_activity_id;
	$arrJobsiteBuildingActivitiesToCostCodes = JobsiteBuildingActivityToCostCode::loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId($database, $jobsite_building_activity_id, $options);
	$arrActivitiesToCostCodes = $arrJobsiteBuildingActivitiesToCostCodes;
	$attributeGroupName = 'toggle-jobsite_building_activity_to_cost_code-record';
	$jobsite_activity_id_attribute = 'jobsite_building_activity_id';
} elseif ($jobsiteActivityTableName == 'jobsite_offsitework_activities') {
	$jobsite_offsitework_activity_id = $jobsite_activity_id;
	$arrJobsiteOffsiteworkActivitiesToCostCodes = JobsiteOffsiteworkActivityToCostCode::loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId($database, $jobsite_offsitework_activity_id, $options);
	$arrActivitiesToCostCodes = $arrJobsiteOffsiteworkActivitiesToCostCodes;
	$attributeGroupName = 'toggle-jobsite_offsitework_activity_to_cost_code-record';
	$jobsite_activity_id_attribute = 'jobsite_offsitework_activity_id';
} elseif ($jobsiteActivityTableName == 'jobsite_sitework_activities') {
	$jobsite_sitework_activity_id = $jobsite_activity_id;
	$arrJobsiteSiteworkActivitiesToCostCodes = JobsiteSiteworkActivityToCostCode::loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId($database, $jobsite_sitework_activity_id, $options);
	$arrActivitiesToCostCodes = $arrJobsiteSiteworkActivitiesToCostCodes;
	$attributeGroupName = 'toggle-jobsite_sitework_activity_to_cost_code-record';
	$jobsite_activity_id_attribute = 'jobsite_sitework_activity_id';
} elseif ($jobsiteActivityTableName == 'jobsite_building_activity_templates') {
	$jobsite_building_activity_template_id = $jobsite_activity_id;
	$arrJobsiteBuildingActivityTemplatesToCostCodes = JobsiteBuildingActivityTemplateToCostCode::loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId($database, $jobsite_building_activity_template_id, $options);
	$arrActivitiesToCostCodes = $arrJobsiteBuildingActivityTemplatesToCostCodes;
	$attributeGroupName = 'toggle-jobsite_building_activity_template_to_cost_code-record';
	$jobsite_activity_id_attribute = 'jobsite_building_activity_template_id';
} elseif ($jobsiteActivityTableName == 'jobsite_offsitework_activity_templates') {
	$jobsite_offsitework_activity_template_id = $jobsite_activity_id;
	$arrJobsiteOffsiteworkActivityTemplatesToCostCodes = JobsiteOffsiteworkActivityTemplateToCostCode::loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId($database, $jobsite_offsitework_activity_template_id, $options);
	$arrActivitiesToCostCodes = $arrJobsiteOffsiteworkActivityTemplatesToCostCodes;
	$attributeGroupName = 'toggle-jobsite_offsitework_activity_template_to_cost_code-record';
	$jobsite_activity_id_attribute = 'jobsite_offsitework_activity_template_id';
} elseif ($jobsiteActivityTableName == 'jobsite_sitework_activity_templates') {
	$jobsite_sitework_activity_template_id = $jobsite_activity_id;
	$arrJobsiteSiteworkActivityTemplatesToCostCodes = JobsiteSiteworkActivityTemplateToCostCode::loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId($database, $jobsite_sitework_activity_template_id, $options);
	$arrActivitiesToCostCodes = $arrJobsiteSiteworkActivityTemplatesToCostCodes;
	$attributeGroupName = 'toggle-jobsite_sitework_activity_template_to_cost_code-record';
	$jobsite_activity_id_attribute = 'jobsite_sitework_activity_template_id';
}

$arrCostCodeTypes = CostCodeType::loadAllCostCodeTypes($database);
$arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId = CostCode::loadCostCodesByUserCompanyIdOrganizedByCostCodeTypeId($database, $user_company_id);
$arrCostCodeTypeIds = array_keys($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId);
list($cost_code_type_id, $arrCostCodesByUserCompanyId) = each($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId);

$costCodeType = $arrCostCodeTypes[$cost_code_type_id];

$arrCostCodeTypesByUserCompanyId = array();
$first_cost_code_type_id = 1;
$first = true;
$costCodeHtml = '';
$currentDivisionNumber = '';
$arrCostCodesByUserCompanyId = $arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId[$cost_code_type_id];

foreach ($arrCostCodesByUserCompanyIdOrganizedByCostCodeTypeId as $cost_code_type_id => $arrCostCodes) {

	if ($first) {
		$first = false;
		$first_cost_code_type_id = $cost_code_type_id;
	}

	if (isset($arrCostCodeTypes[$cost_code_type_id])) {
		$costCodeType = $arrCostCodeTypes[$cost_code_type_id];
		$arrCostCodeTypesByUserCompanyId[$cost_code_type_id] = $costCodeType;
	}

}

$ddlCostCodesByUserCompanyId = PageComponents::dropDownListFromObjects('cost_code_type_id', $arrCostCodeTypesByUserCompanyId, 'cost_code_type_id', null, 'cost_code_type', null, $first_cost_code_type_id, '', '', '');


$htmlContent = '';
$firstUlInstance = true;
foreach ($arrCostCodesByUserCompanyId as $cost_code_id => $costCode) {

	/* @var $costCode CostCode */
	$cost_code_id = $costCode->cost_code_id;
	$cost_code = $costCode->cost_code;
	$cost_code_description = $costCode->cost_code_description;
	$cost_code_description_abbreviation = $costCode->cost_code_description_abbreviation;
	$formattedCostCode = $costCode->getFormattedCostCode($database);

	$costCodeDivision = $costCode->getCostCodeDivision();
	/* @var $costCodeDivision CostCodeDivision */

	$division_number = $costCodeDivision->division_number;
	$division_code_heading = $costCodeDivision->division_code_heading;
	$division = $costCodeDivision->division;
	$division_abbreviation = $costCodeDivision->division_abbreviation;

	if ($division_number <> $currentDivisionNumber) {
		$currentDivisionNumber = $division_number;

		if ($firstUlInstance) {
			$firstUlInstance = false;
			$closingUl = '';
		} else {
			$closingUl = "\n</ul>";
		}

		$htmlContent .= <<<END_HTML_CONTENT
$closingUl
<h4 style="margin:0; padding:0; font-size:0.9em; font-weight: bold;" class="borderBottom">Division $division_number - $division</h4>
<ul style="list-style:none; padding-left: 20px;">
END_HTML_CONTENT;
	}

	// checked?
	if (isset($arrActivitiesToCostCodes[$jobsite_activity_id][$cost_code_id])) {
		$checked = ' checked';
	} else {
		$checked = '';
	}

	$elementId = "$attributeGroupName--$jobsiteActivityTableName--$jobsite_activity_id_attribute-cost_code_id--$jobsite_activity_id-$cost_code_id";

	$htmlContent .= <<<END_HTML_CONTENT

<li style="padding:2px">
	<input id="$elementId" class="input-import-checkbox" type="checkbox" value="$cost_code_id" $checked onchange="toggleJobsiteActivityToCostCode1(this, event);">
	<label for="$elementId" style="float:none; padding:0;">$formattedCostCode</label>
</li>
END_HTML_CONTENT;

}

	$htmlContent .=
'
</ul>';

echo $htmlContent;

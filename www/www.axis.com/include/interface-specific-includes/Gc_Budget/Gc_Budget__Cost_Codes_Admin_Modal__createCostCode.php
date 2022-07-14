<?php

if ($costCode) {
/* @var $costCode CostCode */

// @todo Convert this to use a view class
// @todo May need to have different attributeGroup names for each widget

$cost_code_id = $costCode->cost_code_id;
$cost_code_division_id = $costCode->cost_code_division_id;

$costCode->htmlEntityEscapeProperties();

$escaped_cost_code = $costCode->escaped_cost_code;
$escaped_cost_code_description = $costCode->escaped_cost_code_description;
$escaped_cost_code_description_abbreviation = $costCode->escaped_cost_code_description_abbreviation;

$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);
/* @var $costCodeDivision CostCodeDivision */

$costCodeDivision->htmlEntityEscapeProperties();

$cost_code_division_id = $costCodeDivision->cost_code_division_id;
$escaped_division_number = $costCodeDivision->escaped_division_number;
$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
$escaped_division = $costCodeDivision->escaped_division;
$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;


$elementId = "record_container--manage-cost_code-record--cost_codes--sort_order--$cost_code_id";

$htmlRecordTr = <<<END_HTML_RECORD_TR

				<tr id="$elementId">
					<td class="textAlignCenter"><a href="javascript:Gc_Budget__Cost_Codes_Admin_Modal__deleteCostCode('record_container--manage-cost_code-record--cost_codes--sort_order--$cost_code_id', 'manage-cost_code-record', '$cost_code_id');">X</a></td>
					<td align="right">$escaped_division_number</td>
					<td>
						<input id="previous--manage-cost_code-record--cost_codes--cost_code--$cost_code_id" type="hidden" value="$escaped_cost_code">
						<input id="manage-cost_code-record--cost_codes--cost_code--$cost_code_id" type="text" value="$escaped_cost_code" class="input-costCode" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCode(this);">
					</td>
					<td>
						<input id="previous--manage-cost_code-record--cost_codes--cost_code_description--$cost_code_id" type="hidden" value="$escaped_cost_code_description">
						<input id="manage-cost_code-record--cost_codes--cost_code_description--$cost_code_id" style="width: 100%;" type="text" value="$escaped_cost_code_description" class="input-lineItem" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCode(this);">
					</td>
					<td>
						<input id="previous--manage-cost_code-record--cost_codes--cost_code_description_abbreviation--$cost_code_id" type="hidden" value="$escaped_cost_code_description_abbreviation">
						<input id="manage-cost_code-record--cost_codes--cost_code_description_abbreviation--$cost_code_id" style="width: 100%;" type="text" value="$escaped_cost_code_description_abbreviation" class="input-lineItem" onchange="Gc_Budget__Cost_Codes_Admin_Modal__updateCostCode(this);">
					</td>
				</tr>
END_HTML_RECORD_TR;


$htmlRecordTrSecondary = <<<END_HTML_RECORD_TR

END_HTML_RECORD_TR;

$arrCustomizedJsonOutput = array('htmlRecordTrSecondary' => $htmlRecordTrSecondary);

}

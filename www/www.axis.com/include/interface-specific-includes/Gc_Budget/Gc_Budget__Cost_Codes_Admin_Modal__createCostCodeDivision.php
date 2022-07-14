<?php

if ($costCodeDivision) {
/* @var $costCodeDivision CostCodeDivision */

// @todo Convert this to use a view class
// @todo May need to have different attributeGroup names for each widget

$costCodeDivision = CostCodeDivision::findById($database, $cost_code_division_id);
/* @var $costCodeDivision CostCodeDivision */

$costCodeDivision->htmlEntityEscapeProperties();

$cost_code_division_id = $costCodeDivision->cost_code_division_id;
$escaped_division_number = $costCodeDivision->escaped_division_number;
$escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
$escaped_division = $costCodeDivision->escaped_division;
$escaped_division_abbreviation = $costCodeDivision->escaped_division_abbreviation;


$elementId = "record_container--manage-cost_code_division-record--cost_code_divisions--sort_order--$cost_code_division_id";

$htmlRecordTr = <<<END_HTML_RECORD_TR

				<tr id="$elementId" style="background: #D2DF9A;">
					<th colspan="5" align="left">
						<a style="font-weight: normal;" href="javascript:deleteCostCodeDivision('$cost_code_division_id');">X</a>
						Division
						<input id="division_number_previous-$cost_code_division_id" type="hidden" value="$escaped_division_number">
						<input id="division_code_heading_previous-$cost_code_division_id" type="hidden" value="$escaped_division_code_heading">
						<input id="division_previous-$cost_code_division_id" type="hidden" value="$escaped_division">
						<input id="division_abbreviation_previous-$cost_code_division_id" type="hidden" value="$escaped_division_abbreviation">
						<input id="division_number-$cost_code_division_id" style="margin: 0 3px 0 10px; text-align: right; width: 40px;" type="text" value="$escaped_division_number" onchange="updateCostCodeDivision(this);">-<input id="division_code_heading-$cost_code_division_id" style="margin: 0 20px 0 3px; text-align: left; width: 40px;" type="text" value="$escaped_division_code_heading" onchange="updateCostCodeDivision(this);">
						<input id="division-$cost_code_division_id" style="width: 250px;" type="text" value="$escaped_division" onchange="updateCostCodeDivision(this);">
						<input id="division_abbreviation_-$cost_code_division_id" style="width: 200px;" type="text" value="$escaped_division_abbreviation" onchange="updateCostCodeDivision(this);">
					</th>
				</tr>
END_HTML_RECORD_TR;


$htmlRecordOption = <<<END_HTML_RECORD_TR
	<option value="$cost_code_division_id">$escaped_division_number-$escaped_division_code_heading $escaped_division</option>
END_HTML_RECORD_TR;

}

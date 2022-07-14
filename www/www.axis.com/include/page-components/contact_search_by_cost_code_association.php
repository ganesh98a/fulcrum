<?php

if (!isset($jsOptions)) {
	$jsOptions = '{}';
}

$contact_search_form_by_cost_code_javascript = <<<END_HTML_JAVASCRIPT_BODY

<script>
//# sourceURL=dynamicScript.js
$(document).ready(function() {
	$(".table-contact-search--input-search").autocomplete({
		delay: 500,
		minLength: 2,
		source: function() {
			executeSearchForContactsByCompanyTrades('$javaScriptHandler');
		}
	});
});
</script>
END_HTML_JAVASCRIPT_BODY;

$contact_search_form_by_cost_code_html = <<<END_HTML_CONTENT

<table class="table-contact-search">
	<tr>
		<th>Division Name</th>
		<th>Division Number</th>
		<th>Cost Code Number</th>
		<th>Cost Code Description</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input class="table-contact-search--input-search" id="searchDivision_$javaScriptHandler" name="searchDivision_$javaScriptHandler" type="text"></td>
		<td><input class="table-contact-search--input-search" id="searchDivisionNumber_$javaScriptHandler" name="searchDivisionNumber_$javaScriptHandler"></td>
		<td><input class="table-contact-search--input-search" id="searchCostCode_$javaScriptHandler" name="searchCostCode_$javaScriptHandler" type="text"></td>
		<td><input class="table-contact-search--input-search" id="searchCostCodeDescription_$javaScriptHandler" name="searchCostCodeDescription_$javaScriptHandler" type="text"></td>
		<td><input id="btnClearBudgetSearch_$javaScriptHandler" name="btnClearBudgetSearch_$javaScriptHandler" type="button" value="Clear" onclick="clearSearchForContactsByCompanyTrades('$javaScriptHandler');"></td>
	</tr>
</table>
<div id="divPossibleContactsByTrade_$javaScriptHandler" style="display:none;"></div>
END_HTML_CONTENT;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= $contact_search_form_by_cost_code_javascript;

$arrContactSearchFormByCostCode_Components = array(
	'html' => $contact_search_form_by_cost_code_html,
	'javascript' => $contact_search_form_by_cost_code_javascript,
);

//echo $contact_search_form_by_cost_code_html;

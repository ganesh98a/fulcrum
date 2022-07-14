<?php

if (!isset($jsOptions)) {
	$jsOptions = '{}';
}

$contact_search_form_by_contact_company_name_or_contact_name_javascript = <<<END_HTML_JAVASCRIPT_BODY

<script>
//# sourceURL=dynamicScript.js
$(document).ready(function() {
	$("#searchCompany_$javaScriptHandler, #searchContactFirstName_$javaScriptHandler,#searchContactLastName_$javaScriptHandler, #searchContactEmail_$javaScriptHandler").autocomplete({
		delay: 500,
		minLength: 2,
		source: function() {
			executeSearchForContactsByCompanyOrContact('$javaScriptHandler', $jsOptions);
		}
	});
});
</script>
END_HTML_JAVASCRIPT_BODY;

$contact_search_form_by_contact_company_name_or_contact_name_html = <<<END_HTML_CONTENT

<table class="table-contact-search">
	<tr>
		<th>Company Name</th>
		<th>Contact First Name</th>
		<th>Contact Last Name</th>
		<th>Contact Email</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><input id="searchCompany_$javaScriptHandler" name="searchCompany_$javaScriptHandler" type="text"></td>
		<td><input id="searchContactFirstName_$javaScriptHandler" name="searchContactFirstName_$javaScriptHandler" type="text"></td>
		<td><input id="searchContactLastName_$javaScriptHandler" name="searchContactLastName_$javaScriptHandler" type="text"></td>
		<td><input id="searchContactEmail_$javaScriptHandler" name="searchContactEmail_$javaScriptHandler" type="text"></td>
		<td><input id="btnClearSearch_$javaScriptHandler" name="btnClearSearch_$javaScriptHandler" type="button" value="Clear" onclick="clearSearchForContactsByCompanyOrContact('$javaScriptHandler');"></td>
	</tr>
</table>
<div id="divPossibleContacts_$javaScriptHandler" style="display:none;"></div>
END_HTML_CONTENT;

if (!isset($htmlJavaScriptBody)) {
	$htmlJavaScriptBody = '';
}
$htmlJavaScriptBody .= $contact_search_form_by_contact_company_name_or_contact_name_javascript;

$arrContactSearchFormByCompanyOrName_Components = array(
	'html' => $contact_search_form_by_contact_company_name_or_contact_name_html,
	'javascript' => $contact_search_form_by_contact_company_name_or_contact_name_javascript,
);

//echo $contact_search_form_by_contact_company_name_or_contact_name_html;

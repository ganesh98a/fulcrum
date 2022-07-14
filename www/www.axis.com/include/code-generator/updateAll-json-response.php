<?php

$arrOutput = array(
	// Error Section
	'errorNumber' => $errorNumber, // E.g. "0" Comes from this ajax being successful or unsuccessful
	'errorMessage' => $errorMessage, // E.g. "Error Updating Project Record" Comes from this ajax code

	// Below come from get input or are set to defaults via patterns
	// Existing HTML Record Attribute Group Name
	'attributeGroupName' => $attributeGroupName, // E.g. "manage-project-record" - Existing HTML Record Attribute Group Name

	// HTML Record Attribute Subgroup Name
	'attributeSubgroupName' => $attributeSubgroupName, // E.g. "projects" - Existing HTML Record Attribute Subgroup Name

	// sortOrderFlag
	'sortOrderFlag' => $sortOrderFlag, // E.g. May have "--sort_order--" in recordContainerElementId

	// Existing HTML Record pk/uk - May change if a candidate key attribute value is updated
	'uniqueId' => $primaryKeyAsString, // New/Existing Id - uniqueId in javascript

	// HTML Record Formatted Attribute Group Name
	'formattedAttributeGroupName' => $formattedAttributeGroupName, // E.g. "Project" - Existing HTML Record Formatted Attribute Group Name

	// HTML Record Formatted Attribute Subgroup Name
	'formattedAttributeSubgroupName' => $formattedAttributeSubgroupName, // E.g. "Projects" - Existing HTML Record Formatted Attribute Subgroup Name

	// Previous HTML Record pk/uk (Some updates may change a candidate key attribute value - may not change)
	'previousId' => $uniqueId, // Old pk/uk - previousId in javascript - may not be different than uniqueId in javascript

	// Response data type will be detected via the HTTP response header for the json case
	// Content-Type: application/json
	'responseDataType' => $responseDataType,

	// Skip the default JS success handler
	// Typical values: "" or "Y" or "N" - "" is the same as "N"
	'skipDefaultSuccessCallback' => $skipDefaultSuccessCallback,

	// DOM SWAP
	// Dom Swap Operation - Change out id and onchange handler of html record - in the event that a candidate key value changes
	'performDomSwapOperation' => $performDomSwapOperation, // "Y" or "N"
	'onchangeHandlerFunction' => $onchangeHandlerFunction, // "updateFoo"

	// Refresh Operation Directives
	'performRefreshOperation' => $performRefreshOperation, // "Y" or "N"
	'refreshOperationType' => $refreshOperationType, // "" or "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
	'refreshOperationContainerElementId' => $refreshOperationContainerElementId, // "" or "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
	'refreshOperationUrl' => $refreshOperationUrl, // "" or url to use for refresh operation

	// Display any messages at all to the user
	'displayUserMessages' => $displayUserMessages, // "" or "Y" or "N" - Default is "Y" if not present

	// Custom Error Message
	// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
	'displayCustomErrorMessage' => $displayCustomErrorMessage, // "" or "Y" or "N"
	'customErrorMessage' => $customErrorMessage, // Override auto-created error message

	// Custom Success Message
	'displayCustomSuccessMessage' => $displayCustomSuccessMessage, // "" or "Y" or "N"
	'customSuccessMessage' => $customSuccessMessage, // Override auto-created success message

	// Custom Additional User Message
	'displayAdditionalCustomUserMessage' => $displayAdditionalCustomUserMessage, // "" or "Y" or "N"
	'additionalCustomUserMessageType' => $additionalCustomUserMessageType, // "error" or "success" or "information"
	'additionalCustomUserMessage' => $additionalCustomUserMessage, // "" or "Additional message here..."

	'resetToPreviousValue' => $resetToPreviousValue,
);

// Potentially override the defaults
if (isset($arrCustomizedJsonOutput) && !empty($arrCustomizedJsonOutput)) {
	$arrOutput = array_merge($arrOutput, $arrCustomizedJsonOutput);
}

$output = json_encode($arrOutput);
$jsonFlag = true;

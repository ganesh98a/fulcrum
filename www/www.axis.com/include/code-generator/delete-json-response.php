<?php

$arrOutput = array(
	// Error Section
	'errorNumber' => $errorNumber, // E.g. "0" Comes from this ajax being successful or unsuccessful
	'errorMessage' => $errorMessage, // E.g. "Error Deleting Project Record" Comes from this ajax code

	// @todo Integrate <tr> record_container id with sort_order
	'recordContainerElementId' => $recordContainerElementId, // E.g. "record_container--manage-project-record--projects--sort_order--7"

	// Below come from get input or are set to defaults via patterns
	// Existing HTML Record Attribute Group Name
	'attributeGroupName' => $attributeGroupName, // E.g. "manage-project-record" - Existing HTML Record Attribute Group Name

	// HTML Record Attribute Subgroup Name
	'attributeSubgroupName' => $attributeSubgroupName, // E.g. "projects" - Existing HTML Record Attribute Subgroup Name

	// sortOrderFlag
	'sortOrderFlag' => $sortOrderFlag, // E.g. May have "--sort_order--" in recordContainerElementId

	// Existing HTML Record unique id - May change if a candidate key value is updated
	'uniqueId' => $primaryKeyAsString, // New/Existing Id - uniqueId in javascript

	// HTML Record Formatted Attribute Group Name
	'formattedAttributeGroupName' => $formattedAttributeGroupName, // E.g. "Project" - Existing HTML Record Formatted Attribute Group Name

	// HTML Record Formatted Attribute Subgroup Name
	'formattedAttributeSubgroupName' => $formattedAttributeSubgroupName, // E.g. "Projects" - Existing HTML Record Formatted Attribute Subgroup Name

	// Response data type will be detected via the HTTP response header for the json case
	// Content-Type: application/json
	'responseDataType' => $responseDataType,

	// Skip the default JS success handler
	// Typical values: "" or "Y" or "N" - "" is the same as "N"
	'skipDefaultSuccessCallback' => $skipDefaultSuccessCallback,

	// DOM Delete Operation Directives
	'performDomDeleteOperation' => $performDomDeleteOperation, // Typical values: "" or "Y" or "N" - Default is "Y" if not present
	'domDeleteOperationType' => $domDeleteOperationType, // Typical values: "" or "html_record" or "html_record_list" or "html_dom_container"
	'domDeleteOperationAction' => $domDeleteOperationAction, // Typical values: "" or "delete" or "hide" or "disable" - "" is the same as "delete"
	// Assumed to be the recordContainerElementId for the { domDeleteOperationType: html_record, or domDeleteOperationType: "" } cases
	'domDeleteOperationContainerElementId' => $domDeleteOperationContainerElementId, // Typical values: "" or "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node

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
);

// Potentially override the defaults
if (isset($arrCustomizedJsonOutput) && !empty($arrCustomizedJsonOutput)) {
	$arrOutput = array_merge($arrOutput, $arrCustomizedJsonOutput);
}

$output = json_encode($arrOutput);
$jsonFlag = true;

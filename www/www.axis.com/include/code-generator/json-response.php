<?php

$arrOutput = array();

$arrOutput['crudOperation'] = $crudOperation;

// Error Section
if (isset($errorNumber)) {
	$arrOutput['errorNumber'] = $errorNumber; // E.g. "0" Comes from this ajax being successful or unsuccessful
}
if (isset($errorMessage)) {
	$arrOutput['errorMessage'] = $errorMessage; // E.g. "Error Creating Project Record" Comes from this ajax code
}

// moduleName
if (isset($moduleName)) {
	// Module
	$arrOutput['moduleName'] = $moduleName; // E.g. "Collaboration_Manager" from "Collaboration_Manager__Meetings__createMeeting"
}

// subModuleName
if (isset($subModuleName)) {
	// SubModule
	$arrOutput['subModuleName'] = $subModuleName; // E.g. "Meetings" from "Collaboration_Manager__Meetings__createMeeting"
}

// interfaceName
if (isset($interfaceName)) {
	// Complete Name / Label of the given interface making this ajax call
	$arrOutput['interfaceName'] = $interfaceName; // E.g. "Collaboration_Manager__Meetings__createMeeting"
}

// scenarioName
if (isset($scenarioName)) {
	// Scenario
	$arrOutput['scenarioName'] = $scenarioName; // E.g. "createMeetingTypeFromMeetingTypeTemplate"
}

// containerElementId
if (isset($containerElementId)) {
	// E.g. container--container_label
	$arrOutput['containerElementId'] = $containerElementId;
}

// recordListContainerElementId
if (isset($recordListContainerElementId)) {
	// E.g. record_list_container--manage-project-record
	$arrOutput['recordListContainerElementId'] = $recordListContainerElementId;
}

// recordContainerElementId
if (isset($recordContainerElementId)) {
	// E.g. record_container--manage-project-record--projects--sort_order--uniqueId
	$arrOutput['recordContainerElementId'] = $recordContainerElementId;
}

// attributeElementId
if (isset($attributeElementId)) {
	// E.g. manage-project-record--projects--project_name--uniqueId
	$arrOutput['attributeElementId'] = $attributeElementId;
}

// recordCreationFormContainerElementId
if (isset($recordCreationFormContainerElementId)) {
	// E.g. record_creation_form_container--create-project-record--dummyId
	$arrOutput['recordCreationFormContainerElementId'] = $recordCreationFormContainerElementId;
}

// @todo Opine on save here
// Below comes from get input or are set to defaults via patterns
if ($crudOperation == 'create') {

	// @todo Update code base to use: "manageAttributeGroupName"?
	// creationFormAttributeGroup
	// vs
	// attributeGroup

	// Below come from get input or are set to defaults via patterns
	// Create Case: New HTML Record Attribute Group Name
	$arrOutput['attributeGroupName'] = $newAttributeGroupName; // E.g. "manage-project-record" - New HTML Record Attribute Group Name

	// @todo Update code base to use: "createAttributeGroupName"
	// Previous HTML Record Attribute Group Name
	$arrOutput['previousAttributeGroupName'] = $attributeGroupName; // E.g. "create-project-record" - Previous HTML Record Attribute Group Name

	// New or Existing HTML Record unique id
	$arrOutput['uniqueId'] = $primaryKeyAsString; // New/Existing Id - Pk/Uk/Candidate Key

	// Previous HTML Record unique id (Original "Create Form")
	$arrOutput['dummyId'] = $uniqueId; // Old pk/uk dummy placeholder - dummyId in javascript

	/*
	// uniqueId
	if (isset($primaryKeyAsString)) {
	} elseif(isset($uniqueId)) {
		$arrOutput['uniqueId'] = $uniqueId;
	}
	*/

} elseif (($crudOperation == 'update') || (($crudOperation == 'updateAll'))) {

	// Other Cases: Existing HTML Record Attribute Group Name
	$arrOutput['attributeGroupName'] = $attributeGroupName; // E.g. "manage-project-record" - Existing HTML Record Attribute Group Name

	// Existing HTML Record unique id - May change if a candidate key value is updated
	$arrOutput['uniqueId'] = $primaryKeyAsString; // New/Existing Id - uniqueId in javascript

	// Previous HTML Record unique id (Some updates may change a candidate key attribute value - may not change)
	$arrOutput['previousId'] = $uniqueId; // Old pk/uk value - previousId in javascript - may not be different than uniqueId in javascript

	// resetToPreviousValue
	if (isset($resetToPreviousValue)) {
		$arrOutput['resetToPreviousValue'] = $resetToPreviousValue; // "Y" or "N"
	}

} elseif ($crudOperation == 'renderCreationForm') {



} else {

	// Other Cases: Existing HTML Record Attribute Group Name
	$arrOutput['attributeGroupName'] = $attributeGroupName; // E.g. "manage-project-record" - Existing HTML Record Attribute Group Name

	// New or Existing HTML Record unique id
	$arrOutput['uniqueId'] = $primaryKeyAsString; // New/Existing Id - Pk/Uk/Candidate Key

	// dummyId
	if (isset($dummyId)) {
		// Previous HTML Record unique id (Original "Create Form")
		$arrOutput['dummyId'] = $dummyId; // Old pk/uk dummy placeholder - dummyId in javascript
	}

}

// HTML Record Attribute Subgroup Name (same for new and old HTML Record)
if (isset($attributeSubgroupName)) {
	$arrOutput['attributeSubgroupName'] = $attributeSubgroupName; // E.g. "projects" - Previous/New HTML Record Attribute Subgroup Name
}

// sortOrderFlag
if (isset($sortOrderFlag)) {
	$arrOutput['sortOrderFlag'] = $sortOrderFlag; // E.g. May have "--sort_order--" in recordContainerElementId
}

// attributeName
if (isset($attributeName)) {
	// HTML Record Attribute Name
	$arrOutput['attributeName'] = $attributeName; // E.g. "project_name"
}

// newValue
if (isset($newValue)) {
	// Updated value for the given attribute
	// E.g. "Tst Project" to "Test Project"
	if (is_null($newValue)) {
		$arrOutput['newValue'] = '';
	} else {
		$arrOutput['newValue'] = $newValue;
	}
}

// newValueText
if (isset($newValueText)) {
	// Updated value for the given attribute
	// E.g. "Tst Project" to "Test Project"
	if (is_null($newValueText)) {
		$arrOutput['newValueText'] = '';
	} else {
		$arrOutput['newValueText'] = $newValueText;
	}
}

// HTML Record Formatted Attribute Group Name
if (isset($formattedAttributeGroupName)) {
	// Previous HTML Record unique id (Original "Create Form")
	$arrOutput['formattedAttributeGroupName'] = $formattedAttributeGroupName; // E.g. "Project" - Previous/New HTML Record Formatted Attribute Group Name
}

// formattedAttributeSubgroupName
if (isset($formattedAttributeSubgroupName)) {
	// HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
	$arrOutput['formattedAttributeSubgroupName'] = $formattedAttributeSubgroupName; // E.g. "Projects" - Previous/New HTML Record Formatted Attribute Subgroup Name
}

// formattedAttributeName
if (isset($formattedAttributeName)) {
	// HTML Record Formatted Attribute Name
	$arrOutput['formattedAttributeName'] = $formattedAttributeName; // E.g. "Project Name"
}

// responseDataType
if (isset($responseDataType)) {
	// Response data type will be detected via the HTTP response header for the json case
	// Content-Type: application/json
	$arrOutput['responseDataType'] = $responseDataType; // E.g. "json"
}

// skipDefaultSuccessCallback
if (isset($skipDefaultSuccessCallback)) {
	// Skip the default JS success handler
	// Typical values: "" or "Y" or "N" - "" is the same as "N"
	$arrOutput['skipDefaultSuccessCallback'] = $skipDefaultSuccessCallback;
}

// htmlRecordType
if (isset($htmlRecordType)) {
	// HTML Record template to use for html output
	$arrOutput['htmlRecordType'] = $htmlRecordType; // E.g. "tr" or "li"
}

// htmlRecordTemplate
if (isset($htmlRecordTemplate)) {
	// HTML Record template name
	$arrOutput['htmlRecordTemplate'] = $htmlRecordTemplate;
}

// htmlRecord
if (isset($htmlRecord)) {
	// HTML Record Itself
	$arrOutput['htmlRecord'] = $htmlRecord; // HTML itself
}

// htmlRecordTr
if (isset($htmlRecordTr)) {
	// HTML Record Itself
	$arrOutput['htmlRecordTr'] = $htmlRecordTr; // HTML itself
}

// htmlRecordLi
if (isset($htmlRecordLi)) {
	// HTML Record Itself
	$arrOutput['htmlRecordLi'] = $htmlRecordLi; // HTML itself
}

// htmlRecordOption
if (isset($htmlRecordOption)) {
	// HTML Record Itself
	$arrOutput['htmlRecordOption'] = $htmlRecordOption; // HTML itself
}

// htmlRecordList
if (isset($htmlRecordList)) {
	// HTML Record List
	$arrOutput['htmlRecordList'] = $htmlRecordList; // HTML itself
}

// htmlContent
if (isset($htmlContent)) {
	// HTML Content
	$arrOutput['htmlContent'] = $htmlContent; // HTML itself
}

// performDomSwapOperation
if (isset($performDomSwapOperation)) {
	// DOM SWAP
	// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
	$arrOutput['performDomSwapOperation'] = $performDomSwapOperation; // "Y" or "N"
}

// onchangeHandlerFunction
if (isset($onchangeHandlerFunction)) {
	// DOM SWAP
	// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
	$arrOutput['onchangeHandlerFunction'] = $onchangeHandlerFunction; // "updateFoo"
}

// performReplaceOperation
if (isset($performReplaceOperation)) {
	// Replace Operation
	$arrOutput['performReplaceOperation'] = $performReplaceOperation; // "Y" or "N" - Replace HTML Record with new html
}

// performAppendOperation
if (isset($performAppendOperation)) {
	// Append Operation
	// @todo Add prepend and insert sorted options
	$arrOutput['performAppendOperation'] = $performAppendOperation; // "" or "insert" or "append" or "prepend" - Add HTML Record to the list
}

// performRefreshOperation
if (isset($performRefreshOperation)) {
	// Refresh Operation Directives
	$arrOutput['performRefreshOperation'] = $performRefreshOperation; // "" or "Y" or "N" - Default is "N" if not present

	if (isset($refreshOperationType)) {
		$arrOutput['refreshOperationType'] = $refreshOperationType; // "" or "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
	}

	if (isset($refreshOperationContainerElementId)) {
		$arrOutput['refreshOperationContainerElementId'] = $refreshOperationContainerElementId; // "" or "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
	}

	if (isset($refreshOperationUrl)) {
		$arrOutput['refreshOperationUrl'] = $refreshOperationUrl; // "" or url to use for refresh operation
	}
}

// displayUserMessages
if (isset($displayUserMessages)) {
	// Display any messages at all to the user
	$arrOutput['displayUserMessages'] = $displayUserMessages; // "" or "Y" or "N" - Default is "Y" if not present
}

// displayErrorMessage
if (isset($displayErrorMessage)) {
	// Display An Error Message if an error occurred
	$arrOutput['displayErrorMessage'] = $displayErrorMessage; // "" or "Y" or "N"
}

// displayCustomErrorMessage
if (isset($displayCustomErrorMessage)) {
	// Custom Error Message
	// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
	$arrOutput['displayCustomErrorMessage'] = $displayCustomErrorMessage; // "" or "Y" or "N"

	if (isset($customErrorMessage)) {
		$arrOutput['customErrorMessage'] = $customErrorMessage; // Override auto-created error message
	}
}


// displayCustomSuccessMessage
if (isset($displayCustomSuccessMessage)) {
	// Custom Success Message
	$arrOutput['displayCustomSuccessMessage'] = $displayCustomSuccessMessage; // "" or "Y" or "N"

	if (isset($customSuccessMessage)) {
		$arrOutput['customSuccessMessage'] = $customSuccessMessage; // Override auto-created success message
	}
}

// displayAdditionalCustomUserMessage
if (isset($displayAdditionalCustomUserMessage)) {
	// Custom Additional User Message
	$arrOutput['displayAdditionalCustomUserMessage'] = $displayAdditionalCustomUserMessage; // "" or "Y" or "N"

	if (isset($additionalCustomUserMessageType)) {
		$arrOutput['additionalCustomUserMessageType'] = $additionalCustomUserMessageType; // "error" or "success" or "information"
	}

	if (isset($additionalCustomUserMessage)) {
		$arrOutput['additionalCustomUserMessage'] = $additionalCustomUserMessage; // "" or "Additional message here..."
	}
}

// htmlRecordCreationFormType
if (isset($htmlRecordCreationFormType)) {
	if (isset($htmlRecordCreationFormType)) {
		// HTML Record template to use for html output
		$arrOutput['htmlRecordCreationFormType'] = $htmlRecordCreationFormType; // E.g. "tabularDataRowHorizontalCreationForm" or "li"
	}

	if (isset($htmlRecordCreationForm)) {
		// HTML Record Itself
		$arrOutput['htmlRecordCreationForm'] = $htmlRecordCreationForm; // HTML itself
	}

	if (isset($optionalReferenceElementId)) {
		// Dom Reference element
		$arrOutput['optionalReferenceElementId'] = $optionalReferenceElementId; // Reference element for "prepend" or "insert" or "append"
	}

	if (isset($performCreationFormAppendOperation)) {
		// Dom Reference element
		$arrOutput['performCreationFormAppendOperation'] = $performCreationFormAppendOperation; // Reference element for "prepend" or "insert" or "append"
	}
}


// Potentially override the defaults
if (isset($arrCustomizedJsonOutput) && !empty($arrCustomizedJsonOutput)) {
	$arrOutput = array_merge($arrOutput, $arrCustomizedJsonOutput);
}

$output = json_encode($arrOutput);
$jsonFlag = true;

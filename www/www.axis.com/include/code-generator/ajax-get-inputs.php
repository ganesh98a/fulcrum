<?php

/**
 * Note: Any input may be optional and will come through as NULL or "" when not present in $_GET.
 */

// Which interface/sub-interface did this request come from
if (isset($_GET['moduleName'])) {
	$moduleName = (string) $get->moduleName;
}
if (isset($_GET['subModuleName'])) {
	$subModuleName = (string) $get->subModuleName;
}
if (isset($_GET['interfaceName'])) {
	$interfaceName = (string) $get->interfaceName;
}
if (isset($_GET['scenarioName'])) {
	$scenarioName = (string) $get->scenarioName;
}

// Optional HTML element id values
if (isset($_GET['containerElementId'])) {
	$containerElementId = (string) $get->containerElementId;
}
if (isset($_GET['recordListContainerElementId'])) {
	$recordListContainerElementId = (string) $get->recordListContainerElementId;
}
if (isset($_GET['recordContainerElementId'])) {
	$recordContainerElementId = (string) $get->recordContainerElementId;
}
if (isset($_GET['attributeElementId'])) {
	$attributeElementId = (string) $get->attributeElementId;
}
if (isset($_GET['recordCreationFormContainerElementId'])) {
	$recordCreationFormContainerElementId = (string) $get->recordCreationFormContainerElementId;
}

// Optional Read-Only HTML element id values
if (isset($_GET['readOnlyRecordContainerElementId'])) {
	$readOnlyRecordContainerElementId = (string) $get->readOnlyRecordContainerElementId;
}
if (isset($_GET['readOnlyAttributeElementId'])) {
	$readOnlyAttributeElementId = (string) $get->readOnlyAttributeElementId;
}


// [HTML Record Pattern component labels]
//
// HTML Record List:
//			record_list_container--attributeGroupName
//			record_list_container--attributeGroupName--optionalGroupingAttributeName--optionalGroupingAttributeUniqueId
//
// HTML Record:
//			record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId
//			record_container--attributeGroupName-read_only--attributeSubgroupName--sort_order--uniqueId
//
//			record_container--attributeGroupName--attributeSubgroupName--uniqueId
//			record_container--attributeGroupName-read_only--attributeSubgroupName--uniqueId
//
// HTML Record Attribute:
//			Note: --sort_order-- is only in record_container, not attribute itself
//
// 			attributeGroupName--attributeSubgroupName--attributeName--uniqueId
// 			attributeGroupName-read_only--attributeSubgroupName--attributeName--uniqueId
//
if (isset($_GET['attributeGroupName'])) {
	$attributeGroupName = (string) $get->attributeGroupName; // E.g. Create case: "create_foo". Other cases: "manage_foo"
}
if (isset($_GET['newAttributeGroupName'])) {
	$newAttributeGroupName = (string) $get->newAttributeGroupName; // E.g. Create case becomes update case: "manage_foo" to facilitate DOM SWAP, etc.
}
if (isset($_GET['attributeSubgroupName'])) {
	$attributeSubgroupName = (string) $get->attributeSubgroupName;
}
if (isset($_GET['sortOrderFlag'])) {
	$sortOrderFlag = (string) $get->sortOrderFlag;
}
if (isset($_GET['attributeName'])) {
	$attributeName = (string) $get->attributeName;
}
if (isset($_GET['uniqueId'])) {
	$uniqueId = (string) $get->uniqueId; // dummy_id for create & renderCreationForm casees, Primary key / unique key for all other cases
}

// Update case will have a single new value for a single attribute
if (isset($_GET['newValue'])) {
	$newValue = (string) $get->newValue;
}

// <select> option value for post processing in JS
if (isset($_GET['newValueText'])) {
	$newValueText = (string) $get->newValueText;
}

// Formatted Labels - HTML Record Pattern components
if (isset($_GET['formattedAttributeGroupName'])) {
	$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
}
if (isset($_GET['formattedAttributeSubgroupName'])) {
	$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
}
if (isset($_GET['formattedAttributeName'])) {
	$formattedAttributeName = (string) $get->formattedAttributeName;
}

// json or pipe-delimited
if (isset($_GET['responseDataType'])) {
	$responseDataType = (string) $get->responseDataType;
} else {
	$responseDataType = 'json';
}

// json or pipe-delimited
if (isset($_GET['legacyKeyConversion']) && ($_GET['legacyKeyConversion'] == 'Y')) {
	$legacyKeyConversion = true;
} else {
	$legacyKeyConversion = false;
}

// Potentially skip default ajax callback function
if (isset($_GET['skipDefaultSuccessCallback'])) {
	$skipDefaultSuccessCallback = (string) $get->skipDefaultSuccessCallback;
}

if (isset($_GET['trapJavaScriptEvent'])) {
	$trapJavaScriptEvent = (string) $get->trapJavaScriptEvent;
}

// HTML Content - Send back with response
if (isset($_GET['includeHtmlContent'])) {
	$includeHtmlContent = (string) $get->includeHtmlContent;
}

// HTML Record Include Definition
// Include directive for the type of HTML Record to send back
if (isset($_GET['htmlRecordType'])) {
	$htmlRecordType = (string) $get->htmlRecordType;
}

// HTML Record Template
// Include directive for the type of HTML Record to send back
if (isset($_GET['htmlRecordTemplate'])) {
	$htmlRecordTemplate = (string) $get->htmlRecordTemplate;
}

// Creation Form Directives
// Include directive for the type of HTML Record Creation Form to send back
if (isset($_GET['htmlRecordCreationFormType'])) {
	$htmlRecordCreationFormType = (string) $get->htmlRecordCreationFormType;
}
if (isset($_GET['optionalReferenceElementId'])) {
	$optionalReferenceElementId = (string) $get->optionalReferenceElementId;
}
if (isset($_GET['performCreationFormAppendOperation'])) {
	$performCreationFormAppendOperation = (string) $get->performCreationFormAppendOperation;
}

// DOM SWAP
if (isset($_GET['performDomSwapOperation'])) {
	$performDomSwapOperation = (string) $get->performDomSwapOperation;
}
if (isset($_GET['onchangeHandlerFunction'])) {
	$onchangeHandlerFunction = (string) $get->onchangeHandlerFunction;
}

// Potentially replace some old HTML with a new HTML Record or HTML Record List
if (isset($_GET['performReplaceOperation'])) {
	$performReplaceOperation = (string) $get->performReplaceOperation;
}

// Potentially append a new HTML Record with new HTML
if (isset($_GET['performAppendOperation'])) {
	$performAppendOperation = (string) $get->performAppendOperation;
}

// Delete Operations
if (isset($_GET['performDomDeleteOperation'])) {
	$performDomDeleteOperation = (string) $get->performDomDeleteOperation;
} elseif (isset($crudOperation) && $crudOperation == 'delete') {
	$performDomDeleteOperation = 'Y';
}
if (isset($_GET['domDeleteOperationType'])) {
	$domDeleteOperationType = (string) $get->domDeleteOperationType;
}
if (isset($_GET['domDeleteOperationAction'])) {
	$domDeleteOperationAction = (string) $get->domDeleteOperationAction;
}
if (isset($_GET['domDeleteOperationContainerElementId'])) {
	$domDeleteOperationContainerElementId = (string) $get->domDeleteOperationContainerElementId;
}

// Refresh Operations
if (isset($_GET['performRefreshOperation'])) {
	$performRefreshOperation = (string) $get->performRefreshOperation;
}
if (isset($_GET['refreshOperationType'])) {
	$refreshOperationType = (string) $get->refreshOperationType;
}
if (isset($_GET['refreshOperationContainerElementId'])) {
	$refreshOperationContainerElementId = (string) $get->refreshOperationContainerElementId;
}
if (isset($_GET['refreshOperationUrl'])) {
	$refreshOperationUrl = (string) $get->refreshOperationUrl;
}

// Customized User Messaging
if (isset($_GET['displayUserMessages'])) {
	$displayUserMessages = (string) $get->displayUserMessages;
}
if (isset($_GET['displayErrorMessage'])) {
	$displayErrorMessage = (string) $get->displayErrorMessage;
}
if (isset($_GET['displayCustomErrorMessage'])) {
	$displayCustomErrorMessage = (string) $get->displayCustomErrorMessage;
}
if (isset($_GET['customErrorMessage'])) {
	$customErrorMessage = (string) $get->customErrorMessage;
}
if (isset($_GET['displayCustomSuccessMessage'])) {
	$displayCustomSuccessMessage = (string) $get->displayCustomSuccessMessage;
}
if (isset($_GET['customSuccessMessage'])) {
	$customSuccessMessage = (string) $get->customSuccessMessage;
}
if (isset($_GET['displayAdditionalCustomUserMessage'])) {
	$displayAdditionalCustomUserMessage = (string) $get->displayAdditionalCustomUserMessage;
}
if (isset($_GET['additionalCustomUserMessageType'])) {
	$additionalCustomUserMessageType = (string) $get->additionalCustomUserMessageType;
}
if (isset($_GET['additionalCustomUserMessage'])) {
	$additionalCustomUserMessage = (string) $get->additionalCustomUserMessage;
}

// HTML Confirmation Modal Dialog Window
if (isset($_GET['confirmationDialogMessage'])) {
	$confirmationDialogMessage = (string) $get->confirmationDialogMessage;
}
if (isset($_GET['confirmationDialogTitle'])) {
	$confirmationDialogTitle = (string) $get->confirmationDialogTitle;
}
if (isset($_GET['confirmButtonText'])) {
	$confirmButtonText = (string) $get->confirmButtonText;
}
if (isset($_GET['cancelButtonText'])) {
	$cancelButtonText = (string) $get->cancelButtonText;
}
if (isset($_GET['confirmationDialogWidth'])) {
	$confirmationDialogWidth = (string) $get->confirmationDialogWidth;
}
if (isset($_GET['confirmationDialogHeight'])) {
	$confirmationDialogHeight = (string) $get->confirmationDialogHeight;
}

// loadAll Pattern filters
if (isset($_GET['offset'])) {
	$offset = (string) $get->offset;
}
if (isset($_GET['limit'])) {
	$limit = (string) $get->limit;
}
if (isset($_GET['filterBy'])) {
	$filterBy = (string) $get->filterBy;
}
if (isset($_GET['orderBy'])) {
	$orderBy = (string) $get->orderBy;
}


// Default Values Section
// Values will be passed back in JSON response so use "Y" or "N" instead of true or false

if (!isset($performRefreshOperation) || empty($performRefreshOperation)) {
	$performRefreshOperation = 'N';
}

// Variables are tested for existence before inclusion in the JSON response array so they do not need to exist.
// Don't set variables just because they are empty.
$includeHtmlContentInJsonResponse = false;

if (isset($includeHtmlContent) && !empty($includeHtmlContent)) {
	$includeHtmlContentInJsonResponse = true;
}

// $htmlRecordType implies that the ajax handler should return an html record or attribute group
// Typical values include: "tr" or "li"
if (isset($htmlRecordType) && !empty($htmlRecordType)) {
	$includeHtmlContentInJsonResponse = true;
}

if (isset($htmlRecordTemplate) && !empty($htmlRecordTemplate)) {
	$includeHtmlContentInJsonResponse = true;
}

/*
if (!isset($htmlRecord)) {
	$htmlRecord = '';
}

if (!isset($htmlRecordList)) {
	$htmlRecordList = '';
}

if (!isset($htmlContent)) {
	$htmlContent = '';
}
*/

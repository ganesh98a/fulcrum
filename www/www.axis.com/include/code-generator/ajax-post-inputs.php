<?php

/**
 * Note: Any input may be optional and will come through as NULL or "" when not present in $_GET.
 */

// Which interface/sub-interface did this request come from

if (isset($_POST['moduleName'])) {
	$moduleName = (string) $post->moduleName;
}
if (isset($_POST['subModuleName'])) {
	$subModuleName = (string) $post->subModuleName;
}
if (isset($_POST['interfaceName'])) {
	$interfaceName = (string) $post->interfaceName;
}
if (isset($_POST['scenarioName'])) {
	$scenarioName = (string) $post->scenarioName;
}

// Optional HTML element id values

if (isset($_POST['containerElementId'])) {
	$containerElementId = (string) $post->containerElementId;
}
if (isset($_POST['recordListContainerElementId'])) {
	$recordListContainerElementId = (string) $post->recordListContainerElementId;
}
if (isset($_POST['recordContainerElementId'])) {
	$recordContainerElementId = (string) $post->recordContainerElementId;
}
if (isset($_POST['attributeElementId'])) {
	$attributeElementId = (string) $post->attributeElementId;
}
if (isset($_POST['recordCreationFormContainerElementId'])) {
	$recordCreationFormContainerElementId = (string) $post->recordCreationFormContainerElementId;
}

// Optional Read-Only HTML element id values

if (isset($_POST['readOnlyRecordContainerElementId'])) {
	$readOnlyRecordContainerElementId = (string) $post->readOnlyRecordContainerElementId;
}
if (isset($_POST['readOnlyAttributeElementId'])) {
	$readOnlyAttributeElementId = (string) $post->readOnlyAttributeElementId;
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
if (isset($_POST['attributeGroupName'])) {
	$attributeGroupName = (string) $post->attributeGroupName; // E.g. Create case: "create_foo". Other cases: "manage_foo"
}
if (isset($_POST['newAttributeGroupName'])) {
	$newAttributeGroupName = (string) $post->newAttributeGroupName; // E.g. Create case becomes update case: "manage_foo" to facilitate DOM SWAP, etc.
}
if (isset($_POST['attributeSubgroupName'])) {
	$attributeSubgroupName = (string) $post->attributeSubgroupName;
}
if (isset($_POST['sortOrderFlag'])) {
	$sortOrderFlag = (string) $post->sortOrderFlag;
}
if (isset($_POST['attributeName'])) {
	$attributeName = (string) $post->attributeName;
}
if (isset($_POST['uniqueId'])) {
	$uniqueId = (string) $post->uniqueId; // dummy_id for create & renderCreationForm casees, Primary key / unique key for all other cases
}

// Update case will have a single new value for a single attribute

if (isset($_POST['newValue'])) {
	$newValue = (string) $post->newValue;
}

// <select> option value for post processing in JS

if (isset($_POST['newValueText'])) {
	$newValueText = (string) $post->newValueText;
}

// Formatted Labels - HTML Record Pattern components

if (isset($_POST['formattedAttributeGroupName'])) {
	$formattedAttributeGroupName = (string) $post->formattedAttributeGroupName;
}
if (isset($_POST['formattedAttributeSubgroupName'])) {
	$formattedAttributeSubgroupName = (string) $post->formattedAttributeSubgroupName;
}
if (isset($_POST['formattedAttributeName'])) {
	$formattedAttributeName = (string) $post->formattedAttributeName;
}

// json or pipe-delimited
if (isset($_POST['responseDataType'])) {
	$responseDataType = (string) $post->responseDataType;
} else {
	$responseDataType = 'json';
}

// json or pipe-delimited
if (isset($_POST['legacyKeyConversion']) && ($_POST['legacyKeyConversion'] == 'Y')) {
	$legacyKeyConversion = true;
} else {
	$legacyKeyConversion = false;
}

// Potentially skip default ajax callback function
if (isset($_POST['skipDefaultSuccessCallback'])) {
	$skipDefaultSuccessCallback = (string) $post->skipDefaultSuccessCallback;
}

if (isset($_POST['trapJavaScriptEvent'])) {
	$trapJavaScriptEvent = (string) $post->trapJavaScriptEvent;
}

// HTML Content - Send back with response
if (isset($_POST['includeHtmlContent'])) {
	$includeHtmlContent = (string) $post->includeHtmlContent;
}

// HTML Record Include Definition
// Include directive for the type of HTML Record to send back
if (isset($_POST['htmlRecordType'])) {
	$htmlRecordType = (string) $post->htmlRecordType;
}

// HTML Record Template
// Include directive for the type of HTML Record to send back
if (isset($_POST['htmlRecordTemplate'])) {
	$htmlRecordTemplate = (string) $post->htmlRecordTemplate;
}

// Creation Form Directives
// Include directive for the type of HTML Record Creation Form to send back
if (isset($_POST['htmlRecordCreationFormType'])) {
	$htmlRecordCreationFormType = (string) $post->htmlRecordCreationFormType;
}
if (isset($_POST['optionalReferenceElementId'])) {
	$optionalReferenceElementId = (string) $post->optionalReferenceElementId;
}
if (isset($_POST['performCreationFormAppendOperation'])) {
	$performCreationFormAppendOperation = (string) $post->performCreationFormAppendOperation;
}

// DOM SWAP
if (isset($_POST['performDomSwapOperation'])) {
	$performDomSwapOperation = (string) $post->performDomSwapOperation;
}
if (isset($_POST['onchangeHandlerFunction'])) {
	$onchangeHandlerFunction = (string) $post->onchangeHandlerFunction;
}

// Potentially replace some old HTML with a new HTML Record or HTML Record List
if (isset($_POST['performReplaceOperation'])) {
	$performReplaceOperation = (string) $post->performReplaceOperation;
}

// Potentially append a new HTML Record with new HTML
if (isset($_POST['performAppendOperation'])) {
	$performAppendOperation = (string) $post->performAppendOperation;
}

// Delete Operations
if (isset($_POST['performDomDeleteOperation'])) {
	$performDomDeleteOperation = (string) $post->performDomDeleteOperation;
} elseif (isset($crudOperation) && $crudOperation == 'delete') {
	$performDomDeleteOperation = 'Y';
}
if (isset($_POST['domDeleteOperationType'])) {
	$domDeleteOperationType = (string) $post->domDeleteOperationType;
}
if (isset($_POST['domDeleteOperationAction'])) {
	$domDeleteOperationAction = (string) $post->domDeleteOperationAction;
}
if (isset($_POST['domDeleteOperationContainerElementId'])) {
	$domDeleteOperationContainerElementId = (string) $post->domDeleteOperationContainerElementId;
}

// Refresh Operations
if (isset($_POST['performRefreshOperation'])) {
	$performRefreshOperation = (string) $post->performRefreshOperation;
}
if (isset($_POST['refreshOperationType'])) {
	$refreshOperationType = (string) $post->refreshOperationType;
}
if (isset($_POST['refreshOperationContainerElementId'])) {
	$refreshOperationContainerElementId = (string) $post->refreshOperationContainerElementId;
}
if (isset($_POST['refreshOperationUrl'])) {
	$refreshOperationUrl = (string) $post->refreshOperationUrl;
}

// Customized User Messaging
if (isset($_POST['displayUserMessages'])) {
	$displayUserMessages = (string) $post->displayUserMessages;
}
if (isset($_POST['displayErrorMessage'])) {
	$displayErrorMessage = (string) $post->displayErrorMessage;
}
if (isset($_POST['displayCustomErrorMessage'])) {
	$displayCustomErrorMessage = (string) $post->displayCustomErrorMessage;
}
if (isset($_POST['customErrorMessage'])) {
	$customErrorMessage = (string) $post->customErrorMessage;
}
if (isset($_POST['displayCustomSuccessMessage'])) {
	$displayCustomSuccessMessage = (string) $post->displayCustomSuccessMessage;
}
if (isset($_POST['customSuccessMessage'])) {
	$customSuccessMessage = (string) $post->customSuccessMessage;
}
if (isset($_POST['displayAdditionalCustomUserMessage'])) {
	$displayAdditionalCustomUserMessage = (string) $post->displayAdditionalCustomUserMessage;
}
if (isset($_POST['additionalCustomUserMessageType'])) {
	$additionalCustomUserMessageType = (string) $post->additionalCustomUserMessageType;
}
if (isset($_POST['additionalCustomUserMessage'])) {
	$additionalCustomUserMessage = (string) $post->additionalCustomUserMessage;
}

// HTML Confirmation Modal Dialog Window
if (isset($_POST['confirmationDialogMessage'])) {
	$confirmationDialogMessage = (string) $post->confirmationDialogMessage;
}
if (isset($_POST['confirmationDialogTitle'])) {
	$confirmationDialogTitle = (string) $post->confirmationDialogTitle;
}
if (isset($_POST['confirmButtonText'])) {
	$confirmButtonText = (string) $post->confirmButtonText;
}
if (isset($_POST['cancelButtonText'])) {
	$cancelButtonText = (string) $post->cancelButtonText;
}
if (isset($_POST['confirmationDialogWidth'])) {
	$confirmationDialogWidth = (string) $post->confirmationDialogWidth;
}
if (isset($_POST['confirmationDialogHeight'])) {
	$confirmationDialogHeight = (string) $post->confirmationDialogHeight;
}

// loadAll Pattern filters
if (isset($_POST['offset'])) {
	$offset = (string) $post->offset;
}
if (isset($_POST['limit'])) {
	$limit = (string) $post->limit;
}
if (isset($_POST['filterBy'])) {
	$filterBy = (string) $post->filterBy;
}
if (isset($_POST['orderBy'])) {
	$orderBy = (string) $post->orderBy;
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

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

/**
 * Note: options can come in from outside other first calling fcn so can allow override of defaults to support "draft" case.
 *
 */
function deriveHtmlRecordMetaAttributes(crudOperation, options)
{
	try {

		var objResponseData = { };

		var defaultFormattedAttributeGroupName = options.defaultFormattedAttributeGroupName;
		var defaultFormattedAttributeSubgroupName = options.defaultFormattedAttributeSubgroupName;

		var newValueText = '';

		if ((crudOperation == 'create') || (crudOperation == 'save')) {

			var attributeGroupName = options.attributeGroupName;
			var uniqueId = options.uniqueId;
			var defaultNewAttributeGroupName = options.defaultNewAttributeGroupName;

			// New attribute group name (create and/or save cases) - E.g. "manage-project-record"
			var newAttributeGroupNameSpecificElementId = 'newAttributeGroupName--' + uniqueId;
			var newAttributeGroupNameGeneralElementId = 'newAttributeGroupName--' + attributeGroupName;
			if ($("#" + newAttributeGroupNameSpecificElementId).val()) {
				var newAttributeGroupName = $("#" + newAttributeGroupNameSpecificElementId).val();
			} else if ($("#" + newAttributeGroupNameGeneralElementId).length && $("#" + newAttributeGroupNameGeneralElementId).val() != '') {
				var newAttributeGroupName = $("#" + newAttributeGroupNameGeneralElementId).val();
			} else {
				var newAttributeGroupName = defaultNewAttributeGroupName;
			}
			objResponseData.newAttributeGroupName = newAttributeGroupName;

		} else if (crudOperation == 'update') {

			// See Below case
			//var element = options.element;

		}

		// Test for options.element
		// This identifies the needs if an element is passed in.
		// E.g "update" case
		if (options && ('element' in options)) {

			var element = options.element;

			// Test for ddl-- prepended to the element id
			var elementId = $(element).attr('id');
			// Get the first five characters of the element id string
			var elementIdSubstring = elementId.substring(0, 5);
			if (elementIdSubstring == 'ddl--') {
				var newValueText = $("#" + elementId + ' option:selected').text();
				var originalElementId = elementId;
				// Strip off "ddl--" from the element id
				elementId = elementId.substring(5);
			} else {
				var displayedValue = $(element).attr('displayedValue');
				if ((typeof displayedValue !== typeof undefined) && (displayedValue !== false)) {
					var newValueText = displayedValue;
				} else {
					var newValueText = '';
				}
			}
			objResponseData.newValueText = newValueText;

			// Test for record_container-- prepended to the element id for sort_order case
			var index = elementId.indexOf('sort_order');
			if (index > -1) {
				var elementIdSubstring = elementId.substring(0, 18);
				if (elementIdSubstring == 'record_container--') {
					elementId = elementId.substring(18);
				}
			}
			objResponseData.elementId = elementId;

			var arrParts = elementId.split('--');
			var attributeGroupName = arrParts[0];
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];

			objResponseData.attributeGroupName = attributeGroupName;
			objResponseData.attributeSubgroupName = attributeSubgroupName;
			objResponseData.attributeName = attributeName;
			objResponseData.uniqueId = uniqueId;

			// HTML Record Formatted Attribute Name
			// E.g. "Project Name"
			// Example element id: formattedAttributeName--create-project-record--projects--project_name--1234
			var formattedAttributeNameElementId = 'formattedAttributeName--' + elementId;
			if ($("#" + formattedAttributeNameElementId).val()) {
				var formattedAttributeName = $("#" + formattedAttributeNameElementId).val();
			} else {
				var formattedAttributeName = '';
			}
			objResponseData.formattedAttributeName = formattedAttributeName;

		}

		// E.g. "Project"
		var formattedAttributeGroupNameSpecificElementId = 'formattedAttributeGroupName--' + uniqueId;
		var formattedAttributeGroupNameGeneralElementId = 'formattedAttributeGroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeGroupNameSpecificElementId).val()) {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeGroupNameGeneralElementId).length && $("#" + formattedAttributeGroupNameGeneralElementId).val() != '') {
			var formattedAttributeGroupName = $("#" + formattedAttributeGroupNameGeneralElementId).val();
		} else {
			var formattedAttributeGroupName = defaultFormattedAttributeGroupName;
		}
		objResponseData.formattedAttributeGroupName = formattedAttributeGroupName;

		// E.g. "Projects"
		var formattedAttributeSubgroupNameSpecificElementId = 'formattedAttributeSubgroupName--' + uniqueId;
		var formattedAttributeSubgroupNameGeneralElementId = 'formattedAttributeSubgroupName--' + attributeGroupName;
		if ($("#" + formattedAttributeSubgroupNameSpecificElementId).val()) {
			var formattedAttributeSubgroupName = $("#" + formattedAttributeSubgroupNameSpecificElementId).val();
		} else if ($("#" + formattedAttributeSubgroupNameGeneralElementId).length && $("#" + formattedAttributeSubgroupNameGeneralElementId).val() != '') {
			var formattedAttributeSubgroupName = $("#" + formattedAttributeSubgroupNameGeneralElementId).val();
		} else {
			var formattedAttributeSubgroupName = defaultFormattedAttributeSubgroupName;
		}
		objResponseData.formattedAttributeSubgroupName = formattedAttributeSubgroupName;

		return objResponseData;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function generateAjaxQueryStringFromOptions(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var ajaxQueryString = '';

		// adHocQueryParmaters
		// Extra key/value pairs to add to the query string
		// These should already be escaped properly
		var adHocQueryParameters = options.adHocQueryParameters;
		if (adHocQueryParameters) {
			ajaxQueryString = ajaxQueryString + adHocQueryParameters;
		}

		// responseDataType is the data encoding returned by the server
		// Typical values: "json" or pipe-delimited ("|")
		var responseDataType = options.responseDataType;
		if (responseDataType) {
			ajaxQueryString = ajaxQueryString + '&responseDataType=' + encodeURIComponent(responseDataType);
		}

		// legacyKeyConversion means to convert inputs
		// Typical values: "Y" or "N"
		var legacyKeyConversion = options.legacyKeyConversion;
		if (legacyKeyConversion) {
			ajaxQueryString = ajaxQueryString + '&legacyKeyConversion=' + encodeURIComponent(legacyKeyConversion);
		}

		// skipDefaultSuccessCallback skips the default JS success handler
		// Typical values: "" or "Y" or "N" - "" is the same as "N"
		var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
		if (skipDefaultSuccessCallback) {
			ajaxQueryString = ajaxQueryString + '&skipDefaultSuccessCallback=' + encodeURIComponent(skipDefaultSuccessCallback);
		}

		// Module
		// E.g. "Collaboration_Manager" from "Collaboration_Manager__Meetings__createMeeting"
		var moduleName = options.moduleName;
		if (moduleName) {
			ajaxQueryString = ajaxQueryString + '&moduleName=' + encodeURIComponent(moduleName);
		}

		// SubModule
		// E.g. "Meetings" from "Collaboration_Manager__Meetings__createMeeting"
		var subModuleName = options.subModuleName;
		if (subModuleName) {
			ajaxQueryString = ajaxQueryString + '&subModuleName=' + encodeURIComponent(subModuleName);
		}

		// Complete Name / Label of the given interface making this ajax call
		// E.g. "Collaboration_Manager__Meetings__createMeeting"
		var interfaceName = options.interfaceName;
		if (interfaceName) {
			ajaxQueryString = ajaxQueryString + '&interfaceName=' + encodeURIComponent(interfaceName);
		}

		// Scenario
		// E.g. "createMeetingTypeFromMeetingTypeTemplate"
		var scenarioName = options.scenarioName;
		if (scenarioName) {
			ajaxQueryString = ajaxQueryString + '&scenarioName=' + encodeURIComponent(scenarioName);
		}

		// Ad hoc HTML Container Element id Format: id="container--uniqueId"
		var containerElementId = options.containerElementId;
		if (containerElementId) {
			ajaxQueryString = ajaxQueryString + '&containerElementId=' + encodeURIComponent(containerElementId);
		}

		// HTML Record List Container Element id Format: id="record_list_container--htmlAttributeGroup"
		// var recordListContainerElementId = 'record_list_container--' + attributeGroupName;
		var recordListContainerElementId = options.recordListContainerElementId;
		if (recordListContainerElementId) {
			ajaxQueryString = ajaxQueryString + '&recordListContainerElementId=' + encodeURIComponent(recordListContainerElementId);
		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		var recordContainerElementId = options.recordContainerElementId;
		if (recordContainerElementId) {
			ajaxQueryString = ajaxQueryString + '&recordContainerElementId=' + encodeURIComponent(recordContainerElementId);
		}

		// record_container--create-project-record--projects--sort_order--dummy_id-1439545204522
		// to
		// record_container--manage-project-record--projects--sort_order--6
		var recordContainerElementIdOld = options.recordContainerElementIdOld;
		if (recordContainerElementIdOld) {
			ajaxQueryString = ajaxQueryString + '&recordContainerElementIdOld=' + encodeURIComponent(recordContainerElementIdOld);
		}

		// HTML Record Attribute Element id Format: id="attributeGroupName--attributeSubgroupName--attributeName--uniqueId"
		// attributeName elementId
		var attributeElementId = options.attributeElementId;
		if (attributeElementId) {
			ajaxQueryString = ajaxQueryString + '&attributeElementId=' + encodeURIComponent(attributeElementId);
		}

		// Typical values: "Y" or "N" or ""
		var includeHtmlContent = options.includeHtmlContent;
		if (includeHtmlContent) {
			ajaxQueryString = ajaxQueryString + '&includeHtmlContent=' + encodeURIComponent(includeHtmlContent);
		}

		// @todo loadAll case: This will be a list of HTML records
		// htmlRecordType implies that the ajax handler should return an html record or attribute group
		// Typical values: "tr_horizontal" or "tr_vertical" or "li_horizontal" or "li_vertical"
		var htmlRecordType = options.htmlRecordType;
		if (htmlRecordType) {
			ajaxQueryString = ajaxQueryString + '&htmlRecordType=' + encodeURIComponent(htmlRecordType);
		}

		// htmlRecordTemplate
		// Typical values: "tr_vertical", "tr_horizontal", "li_vertical", "li_horizontal"
		var htmlRecordTemplate = options.htmlRecordTemplate;
		if (htmlRecordTemplate) {
			ajaxQueryString = ajaxQueryString + '&htmlRecordTemplate=' + encodeURIComponent(htmlRecordTemplate);
		}

		// performDomSwapOperation
		// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
		// Typical values: "" or "Y" or "N"
		var performDomSwapOperation = options.performDomSwapOperation;
		var onchangeHandlerFunction = options.onchangeHandlerFunction;
		if (performDomSwapOperation && onchangeHandlerFunction) {
			ajaxQueryString = ajaxQueryString + '&performDomSwapOperation=' + encodeURIComponent(performDomSwapOperation);
			ajaxQueryString = ajaxQueryString + '&onchangeHandlerFunction=' + encodeURIComponent(onchangeHandlerFunction);
		}

		// performReplaceOperation
		// Replace HTML Record with new html
		// Typical values: "" or "Y" or "N"
		var performReplaceOperation = options.performReplaceOperation ;
		if (performReplaceOperation ) {
			ajaxQueryString = ajaxQueryString + '&performReplaceOperation =' + encodeURIComponent(performReplaceOperation );
		}

		// performAppendOperation
		// Typical values: "" or "insert" or "append" or "prepend"
		var performAppendOperation = options.performAppendOperation;
		if (performAppendOperation) {
			ajaxQueryString = ajaxQueryString + '&performAppendOperation=' + encodeURIComponent(performAppendOperation);
		}

		// performRefreshOperation
		// performRefreshOperation implies that the ajax handler should pass back a directive to reload the URL
		// Typical values: "" or "Y" or "N" - Default is "N" if not present
		var performRefreshOperation = options.performRefreshOperation;
		if (performRefreshOperation) {
			ajaxQueryString = ajaxQueryString + '&performRefreshOperation=' + encodeURIComponent(performRefreshOperation);
		}

		// refreshOperationType
		// Typical values: "" or "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
		var refreshOperationType = options.refreshOperationType;
		if (refreshOperationType) {
			ajaxQueryString = ajaxQueryString + '&refreshOperationType=' + encodeURIComponent(refreshOperationType);
		}

		// refreshOperationContainerElementId
		// Typical values: "" or "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
		var refreshOperationContainerElementId = options.refreshOperationContainerElementId;
		if (refreshOperationContainerElementId) {
			ajaxQueryString = ajaxQueryString + '&refreshOperationContainerElementId=' + encodeURIComponent(refreshOperationContainerElementId);
		}

		// refreshOperationUrl
		// Typical values: "" or url to use for refresh operation
		var refreshOperationUrl = options.refreshOperationUrl;
		if (refreshOperationUrl) {
			ajaxQueryString = ajaxQueryString + '&refreshOperationUrl=' + encodeURIComponent(refreshOperationUrl);
		}

		// displayUserMessages
		// Typical values: "" or "Y" or "N" - Default is "Y" if not present
		var displayUserMessages = options.displayUserMessages;
		if (displayUserMessages) {
			ajaxQueryString = ajaxQueryString + '&displayUserMessages=' + encodeURIComponent(displayUserMessages);
		}

		// displayErrorMessage
		// Display an error message to the user if the operation fails
		// Typical values: "" or "Y" or "N" - Default is "Y"
		var displayErrorMessage = options.displayErrorMessage;
		if (displayErrorMessage) {
			ajaxQueryString = ajaxQueryString + '&displayErrorMessage=' + encodeURIComponent(displayErrorMessage);
		}

		// displayCustomErrorMessage
		// Display a custom error message to the user if the operation fails
		// Typical values: "" or "Y" or "N" - Default is "N"
		var displayCustomErrorMessage = options.displayCustomErrorMessage;
		if (displayCustomErrorMessage) {
			ajaxQueryString = ajaxQueryString + '&displayCustomErrorMessage=' + encodeURIComponent(displayCustomErrorMessage);
		}

		// customErrorMessage - Override auto-created error message
		// Typical values: "" or "Custom error message here..."
		var customErrorMessage = options.customErrorMessage;
		if (customErrorMessage) {
			ajaxQueryString = ajaxQueryString + '&customErrorMessage=' + encodeURIComponent(customErrorMessage);
		}

		// displayCustomSuccessMessage
		// Display a custom success message to the user if the operation is successful
		// Typical values: "" or "Y" or "N"
		var displayCustomSuccessMessage = options.displayCustomSuccessMessage;
		if (displayCustomSuccessMessage) {
			ajaxQueryString = ajaxQueryString + '&displayCustomSuccessMessage=' + encodeURIComponent(displayCustomSuccessMessage);
		}

		// customSuccessMessage - Override auto-created success message
		// Custom success message to be displayed to the user if the operation is successful
		// Typical values: "" or "Custom success message here..."
		var customSuccessMessage = options.customSuccessMessage;
		if (customSuccessMessage) {
			ajaxQueryString = ajaxQueryString + '&customSuccessMessage=' + encodeURIComponent(customSuccessMessage);
		}

		// displayAdditionalCustomUserMessage
		// Typical values: "" or "Y" or "N"
		var displayAdditionalCustomUserMessage = options.displayAdditionalCustomUserMessage;
		if (displayAdditionalCustomUserMessage) {
			ajaxQueryString = ajaxQueryString + '&displayAdditionalCustomUserMessage=' + encodeURIComponent(displayAdditionalCustomUserMessage);
		}

		// additionalCustomUserMessageType
		// Typical values: "error" or "success" or "information"
		var additionalCustomUserMessageType = options.additionalCustomUserMessageType;
		if (additionalCustomUserMessageType) {
			ajaxQueryString = ajaxQueryString + '&additionalCustomUserMessageType=' + encodeURIComponent(additionalCustomUserMessageType);
		}

		// additionalCustomUserMessage
		// Typical values: "" or "Additional message here..."
		var additionalCustomUserMessage = options.additionalCustomUserMessage;
		if (additionalCustomUserMessage) {
			ajaxQueryString = ajaxQueryString + '&additionalCustomUserMessage=' + encodeURIComponent(additionalCustomUserMessage);
		}

		// Reload the page or a portion of the page via a specific URL (ajax or whole page refresh)
		var refreshUrl = options.refreshUrl;
		if (refreshUrl) {
			ajaxQueryString = ajaxQueryString + '&refreshUrl=' + encodeURIComponent(refreshUrl);
		}


		// loadAll Section
		// Sorting Directives
		// @todo Figure out how to use a sub array of order by: attribute => asc/desc
		var orderBy = options.orderBy;
		if (orderBy) {
			ajaxQueryString = ajaxQueryString + '&orderBy=' + encodeURIComponent(orderBy);
		}

		// Pagination Directives - limit
		var limit = options.limit;
		if (limit) {
			ajaxQueryString = ajaxQueryString + '&limit=' + encodeURIComponent(limit);
		}

		// Pagination Directives - offset
		var offset = options.offset;
		if (offset) {
			ajaxQueryString = ajaxQueryString + '&offset=' + encodeURIComponent(offset);
		}


		// delete Section
		// performDomDeleteOperation
		// performDomDeleteOperation implies that the ajax handler should pass back a directive to delete a DOM node
		// Typical values: "" or "Y" or "N" - Default is "Y" if not present
		var performDomDeleteOperation = options.performDomDeleteOperation;
		if (performDomDeleteOperation) {
			ajaxQueryString = ajaxQueryString + '&performDomDeleteOperation=' + encodeURIComponent(performDomDeleteOperation);
		}

		// domDeleteOperationType
		// Typical values: "" or "html_record" or "html_record_list" or "html_dom_container" - Default is "html_record"
		var domDeleteOperationType = options.domDeleteOperationType;
		if (domDeleteOperationType) {
			ajaxQueryString = ajaxQueryString + '&domDeleteOperationType=' + encodeURIComponent(domDeleteOperationType);
		}

		// domDeleteOperationAction
		// Typical values: "" or "delete" or "hide" or "disable" - Default is "delete"
		// "" is the same as "delete"
		var domDeleteOperationAction = options.domDeleteOperationAction;
		if (domDeleteOperationAction) {
			ajaxQueryString = ajaxQueryString + '&domDeleteOperationAction=' + encodeURIComponent(domDeleteOperationAction);
		}

		// domDeleteOperationContainerElementId
		// Typical values: "" or "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
		// Assumed to be the recordContainerElementId for the { domDeleteOperationType: html_record, or domDeleteOperationType: "" } cases
		var domDeleteOperationContainerElementId = options.domDeleteOperationContainerElementId;
		if (domDeleteOperationContainerElementId) {
			ajaxQueryString = ajaxQueryString + '&domDeleteOperationContainerElementId=' + encodeURIComponent(domDeleteOperationContainerElementId);
		}

		return ajaxQueryString;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function parseInputToTemporalDataTypeByAttributeName(attributeName, tmpValue)
{
	try {

		// Default
		var newValue = tmpValue;
		var inputDataFiltered = false;

		// Check for "datetime" before "date"
		index = attributeName.indexOf('_datetime');
		if (index > -1) {
			// Potentially concatenate a time value
			newValue = convertDatetimeToMySQLFormat(tmpValue);
			inputDataFiltered = true;
		} else {
			index = attributeName.indexOf('_date');
			if (index > -1) {
				newValue = convertDateToMySQLFormat(tmpValue);
				inputDataFiltered = true;
			} else {
				index = attributeName.indexOf('_timestamp');
				if (index > -1) {
					// Time options: Any actual time value, 'deriveFromInput', 'useNowAsTimePortion', '00:00:00' (default).
					newValue = convertTimestampToMySQLFormat(tmpValue, '0000-00-00 00:00:00', '00:00:00');
					inputDataFiltered = true;
				} else {
					index = attributeName.indexOf('_time');
					if (index > -1) {
						newValue = convertTimeToMySQLFormat(tmpValue);
						inputDataFiltered = true;
					}
				}
			}
		}

		var objReturn = { inputDataFiltered: inputDataFiltered, newValue: newValue };
		return objReturn;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 * HTTP 200 Response is "success" so any errors can be passed back and handled here.
 *
 */
function defaultAjaxSuccessCallback(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var responseDataType = jqXHR.getResponseHeader('Content-Type');

		// Debug
		//alert(responseDataType);
		//return;

		if (responseDataType == 'application/json') {

			var json = data;

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var jsonObjectAsString = JSON.stringify(json);
				var continueDebug = window.confirm(jsonObjectAsString);
				if (continueDebug != true) {
					return;
				}
			}

			// Get custom result set of JSON HTML Record objects to iterate over them - each has directives and data
			//var arrHtmlRecordObjects = json.arrHtmlRecordObjects;

			// @todo Implement this after fully switched over to json
			// Iterate over JSON objects here via for loop...

			// Potentially skip this entire success callback - useful when a custom callback is needed for a specific interface or code block
			var skipDefaultSuccessCallback = json.skipDefaultSuccessCallback; // "Y" or "N"
			if (skipDefaultSuccessCallback && (skipDefaultSuccessCallback == 'Y')) {
				return;
			}

			// crudOperation
			var crudOperation = json.crudOperation;

			// Error Section
			var errorNumber = json.errorNumber; // E.g. "0"
			var errorMessage = json.errorMessage; // E.g. "Error Creating Project Record"

			// Ad hoc HTML Container Element id
			var containerElementId = json.containerElementId;

			// HTML Record List-Container Element id
			var recordListContainerElementId = json.recordListContainerElementId; // Complete HTML Record List Container Element Id

			// Deleted HTML Record Container Element id
			var recordContainerElementId = json.recordContainerElementId; // Complete HTML Record Container Element Id

			// Potentially delete Read-Only HTML Record Container Element id if it exists
			var readOnlyRecordContainerElementId = json.readOnlyRecordContainerElementId; // Complete Read-Only HTML Record Container Element Id

			// HTML Record Invidual Attribute Element Id
			var attributeElementId = json.attributeElementId; // Complete HTML Record Invidual Attribute Element Id

			// Read-Only HTML Record Invidual Attribute Element Id
			var readOnlyAttributeElementId = json.readOnlyAttributeElementId; // Complete HTML Record Invidual Attribute Element Id

			// New HTML Record Attribute Group Name
			var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"

			// HTML Record Attribute Subgroup Name (same for new and old HTML Record)
			var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"

			// May have "--sort_order--" in recordContainerElementId
			var sortOrderFlag = json.sortOrderFlag;

			// New HTML Record Container Element id pk/uk portion (last id portion)
			var uniqueId = json.uniqueId; // New Id, E.g. "--1234"

			// New HTML Record Formatted Attribute Group Name
			var formattedAttributeGroupName = json.formattedAttributeGroupName; // E.g. "Project"

			// HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName; // E.g. "Projects"

			// Previous HTML Record Attribute Group Name
			var previousAttributeGroupName = json.previousAttributeGroupName; // E.g. "create-project-record"

			// Previous HTML Record Container Element id pk/uk portion (Original "Create Form")
			var dummyId = json.dummyId; // Old pk/uk dummy placeholder

			// HTML Record Type
			var htmlRecordType = json.htmlRecordType; // HTML template type

			// HTML Record Template
			var htmlRecordTemplate = json.htmlRecordTemplate; // HTML template or include pseudo-label

			// HTML Record Itself
			var htmlRecord = json.htmlRecord; // HTML itself

			// HTML Record List
			var htmlRecordList = json.htmlRecordList; // HTML record set

			// HTML Content
			var htmlContent = json.htmlContent; // HTML ad-hoc content

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = json.performDomSwapOperation; // "Y" or "N"
			var onchangeHandlerFunction = json.onchangeHandlerFunction; // "updateFoo"

			// Replace Operation
			var performReplaceOperation = json.performReplaceOperation; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation
			// @todo Add prepend and insert sorted options
			var performAppendOperation = json.performAppendOperation; // "" or "insert" or "append" or "prepend" - Add HTML Record to the list

			// Refresh Operation Directives
			var performRefreshOperation = json.performRefreshOperation; // "Y" or "N"
			var refreshOperationType = json.refreshOperationType; // "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
			var refreshOperationContainerElementId = json.refreshOperationContainerElementId; // E.g. "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
			var refreshOperationUrl = json.refreshOperationUrl; // url to use for refresh operation

			// Display any messages at all to the user
			var displayUserMessages = json.displayUserMessages; // "Y" or "N" - Default is "Y" if not present

			// Custom Success Message
			var displayCustomSuccessMessage = json.displayCustomSuccessMessage; // "Y" or "N"
			var customSuccessMessage = json.customSuccessMessage; // Override auto-created success message

			// Custom Additional User Message
			var displayAdditionalCustomUserMessage = json.displayAdditionalCustomUserMessage; // "Y" or "N"
			var additionalCustomUserMessageType = json.additionalCustomUserMessageType; // "error" or "success" or "information"
			var additionalCustomUserMessage = json.additionalCustomUserMessage; // "" or "Additional message here..."

			// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
			// Custom Error Message
			var displayCustomErrorMessage = json.displayCustomErrorMessage; // "Y" or "N"
			var customErrorMessage = json.customErrorMessage; // Override auto-created error message

		} else {

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(data);
				if (continueDebug != true) {
					return;
				}
			}

			// Create Output Format: Error #|Error Message|Record/Attribute Group Name|Record/Attribute Subgroup Name|Record id|Formatted Record/Attribute Group Name|Formatted Record/Attribute Subgroup Name|Dummy HTML Element ID|HTML Record Output|Refresh Window Flag|Refresh Window Dom Container Element Id|Refresh Window Ajax Url String
			var arrTemp = data.split('|');
			var errorNumber = arrTemp[0]; // E.g. "0" - Error Section
			var errorMessage = arrTemp[1]; // E.g. "Error Creating Project Record"
			var attributeGroupName = arrTemp[2]; // E.g. "manage-project-record" - New HTML Record Attribute Group Name
			var attributeSubgroupName = arrTemp[3]; // E.g. "projects" - HTML Record Attribute Subgroup Name (same for new and old HTML Record)
			var uniqueId = arrTemp[4]; // New pk/uk value - New HTML Record Container Element id pk/uk portion
			var formattedAttributeGroupName = arrTemp[5]; // E.g. "Manage Table Name Record" - New HTML Record Formatted Attribute Group Name
			var formattedAttributeSubgroupName = arrTemp[6]; // E.g. "Projects" - HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var previousAttributeGroupName = arrTemp[7]; // E.g. "create-project-record" - Previous HTML Record Attribute Group Name
			var dummyId = arrTemp[8]; // Old pk/uk dummy placeholder value - Previous HTML Record Container Element id pk/uk portion (Original "Create Form")
			var htmlRecord = arrTemp[9]; // HTML itself - HTML Record
			var refreshWindow = arrTemp[10]; // "Y" or "N" - full screen refresh - Reload the browser window via javascript

			if (refreshWindow && (refreshWindow == 'Y')) {
				var performRefreshOperation = 'Y';
				var refreshOperationType = 'full_screen_refresh';
			}

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = arrTemp[11]; // "Y" or "N" - Change out id and onchange handler

			// Replace Operation Directives
			var performReplaceOperation = arrTemp[12]; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation Directives
			// @todo Add prepend and insert sorted options
			var performAppendOperation = arrTemp[13]; // "Y" or "N" - Add HTML Record to the list

			// Custom Success Message
			var displayCustomSuccessMessage = arrTemp[14]; // "Y" or "N"
			var customSuccessMessage = arrTemp[15]; // Override auto-created success message

			// May have "--sort_order--" in recordContainerElementId
			// Default to true for pipe-delimited case
			var sortOrderFlag = 'Y';

		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		if (typeof recordContainerElementId == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			} else {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;
			}
		}

		// Previous HTML Record Container Element id
		if (typeof recordContainerElementIdOld == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + dummyId;
			} else {
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--' + dummyId;
			}
		}

		// HTML Record List Container Element id Format: id="record_list_container--htmlAttributeGroup"
		if (typeof recordListContainerElementId == 'undefined') {
			var recordListContainerElementId = 'record_list_container--' + attributeGroupName;
		}

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm('New recordContainerElementId: ' + recordContainerElementId + ' Previous recordContainerElementId: ' + recordContainerElementIdOld);
			if (continueDebug != true) {
				return;
			}
		}

		if (errorNumber == 0) {

			// Dom Swap
			if (performDomSwapOperation == 'Y') {
				// Iterate over the record container and each child element and change the element id and add an onchange handler
				// 1) Modify the HTML Record Container itself to have the updated id value
				$("#" + recordContainerElementIdOld).attr('id', recordContainerElementId);

				// 2) Modify each child element to have an updated element id and an onchange handler
				// var onchangeHandler = "updateActionItemAssignment(this, { responseDataType : 'json' })";
				var onchangeHandler = onchangeHandlerFunction + "(this, { responseDataType : 'json' })";
				var arrChildrenIds = $("#" + recordContainerElementId).find('[id]');
				$.each(arrChildrenIds,
					function() {
						var tmpId = this.id;

						// Not all of the elements have an id attribute defined
						// The above find operation should filter the list though
						if (tmpId) {
							var index = tmpId.indexOf(previousAttributeGroupName);
							if (index == 0) {
								// find/replace the id with the updated attributeGroupName
								// E.g. "create-project-record" to "manage-project-record"
								newId = tmpId.replace(previousAttributeGroupName, attributeGroupName);
								newId = newId.replace(dummyId, uniqueId);

								// Debug
								//alert(newId);

								$(this).attr('id', newId);
								$(this).attr('onchange', onchangeHandler);
							}
						}
					}
				);
			}

			// Replace old HTML placeholder with the returned HTML Record
			if (performReplaceOperation == 'Y') {
				$("#" + recordContainerElementIdOld).replaceWith(htmlRecord);
			}

			// Append the returned HTML Record to the list
			if (performAppendOperation != '') {
				// @todo Add prepend and insert sorted options
				$("#" + recordListContainerElementId).append(htmlRecord);
			}

			// User Messaging
			// Only skip all messaging for displayUserMessages == "N"
			// If the variable is not explicitly set/present and "N" in value, then display messages
			if (!displayUserMessages || (displayUserMessages == 'Y')) {
				if (responseDataType == 'application/json') {
					libCodeGen_userMessaging(json, crudOperation);
				}
			}

			// @todo Add all refresh operations here...
			if (performRefreshOperation && (performRefreshOperation == 'Y')) {
				if (refreshOperationType = 'full_screen_refresh') {
					window.location.reload(true);
				}
				if (refreshOperationType = 'dom_element_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + refreshOperationContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_list_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordListContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'callback_handler_refresh') {
					// @todo...???
				}
			}
			UpdateDaliytab(); //For update the Daliylog tab

			//window.location.reload(true);
		} else {
			messageAlert(data, 'errorMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}


function getUrlVars() {
var vars = {};
var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
vars[key] = value;
});
return vars;
}

//Function to update the created by and modified on
function UpdateDaliytab(){
	// var date= window.location.search.substring(1);
	var date = getUrlVars()["date"];
	var project_id=$("#currentlySelectedProjectId").val();
	var jobsite_daily_log_id=$("#jobsite_daily_log_id").val();

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-jobsite-daily-logs-ajax.php?method=UpdatemodifiedContents';
	var ajaxQueryString =
			'jobsite_daily_log_id=' + encodeURIComponent(jobsite_daily_log_id) +
			'&jobsite_daily_date=' + encodeURIComponent(date)+
			'&project_id=' + encodeURIComponent(project_id);
			
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

	var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			dataType:'Json',
			success: function(res){
				$("#created_by").html(res.created_by);
				$("#createdAt").html(res.createdAt);
				$("#modified_by").html(res.modified_by);
				$("#modified_on").html(res.modified_on);

			},
			error: errorHandler
		});

	
}

function defaultAjaxCallback_createSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var responseDataType = jqXHR.getResponseHeader('Content-Type');

		// Debug
		//alert(responseDataType);
		//return;

		if (responseDataType == 'application/json') {

			var json = data;

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var jsonObjectAsString = JSON.stringify(json);
				var continueDebug = window.confirm(jsonObjectAsString);
				if (continueDebug != true) {
					return;
				}
			}

			// Get custom result set of JSON HTML Record objects to iterate over them - each has directives and data
			//var arrHtmlRecordObjects = json.arrHtmlRecordObjects;

			// @todo Implement this after fully switched over to json
			// Iterate over JSON objects here via for loop...

			// Potentially skip this entire success callback - useful when a custom callback is needed for a specific interface or code block
			var skipDefaultSuccessCallback = json.skipDefaultSuccessCallback; // "Y" or "N"
			if (skipDefaultSuccessCallback && (skipDefaultSuccessCallback == 'Y')) {
				return;
			}

			// Error Section
			var errorNumber = json.errorNumber; // E.g. "0"
			var errorMessage = json.errorMessage; // E.g. "Error Creating Project Record"

			// Ad hoc HTML Container Element id
			var containerElementId = json.containerElementId;

			// HTML Record List-Container Element id
			var recordListContainerElementId = json.recordListContainerElementId; // Complete HTML Record List Container Element Id

			// Deleted HTML Record Container Element id
			var recordContainerElementId = json.recordContainerElementId; // Complete HTML Record Container Element Id

			// Potentially delete Read-Only HTML Record Container Element id if it exists
			var readOnlyRecordContainerElementId = json.readOnlyRecordContainerElementId; // Complete Read-Only HTML Record Container Element Id

			// HTML Record Creation Form HTML Container Element id
			var recordCreationFormContainerElementId = json.recordCreationFormContainerElementId;

			// New HTML Record Attribute Group Name
			var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"

			// HTML Record Attribute Subgroup Name (same for new and old HTML Record)
			var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"

			// May have "--sort_order--" in recordContainerElementId
			var sortOrderFlag = json.sortOrderFlag;

			// New HTML Record Container Element id pk/uk portion (last id portion)
			var uniqueId = json.uniqueId; // New Id, E.g. "--1234"

			// New HTML Record Formatted Attribute Group Name
			var formattedAttributeGroupName = json.formattedAttributeGroupName; // E.g. "Project"

			// HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName; // E.g. "Projects"

			// Previous HTML Record Attribute Group Name
			var previousAttributeGroupName = json.previousAttributeGroupName; // E.g. "create-project-record"

			// Previous HTML Record Container Element id pk/uk portion (Original "Create Form")
			var dummyId = json.dummyId; // Old pk/uk dummy placeholder

			// HTML Record Type
			var htmlRecordType = json.htmlRecordType; // HTML template type

			// HTML Record Template
			var htmlRecordTemplate = json.htmlRecordTemplate; // HTML template or include pseudo-label

			// HTML Record Itself
			var htmlRecord = json.htmlRecord; // HTML itself

			// HTML Record List
			var htmlRecordList = json.htmlRecordList; // HTML record set

			// HTML Content
			var htmlContent = json.htmlContent; // HTML ad-hoc content

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = json.performDomSwapOperation; // "Y" or "N"
			var onchangeHandlerFunction = json.onchangeHandlerFunction; // "updateFoo"

			// Replace Operation
			var performReplaceOperation = json.performReplaceOperation; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation
			// @todo Add prepend and insert sorted options
			var performAppendOperation = json.performAppendOperation; // "" or "insert" or "append" or "prepend" - Add HTML Record to the list

			// Refresh Operation Directives
			var performRefreshOperation = json.performRefreshOperation; // "Y" or "N"
			var refreshOperationType = json.refreshOperationType; // "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
			var refreshOperationContainerElementId = json.refreshOperationContainerElementId; // E.g. "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
			var refreshOperationUrl = json.refreshOperationUrl; // url to use for refresh operation

			// Display any messages at all to the user
			var displayUserMessages = json.displayUserMessages; // "Y" or "N" - Default is "Y" if not present

			// Custom Success Message
			var displayCustomSuccessMessage = json.displayCustomSuccessMessage; // "Y" or "N"
			var customSuccessMessage = json.customSuccessMessage; // Override auto-created success message

			// Custom Additional User Message
			var displayAdditionalCustomUserMessage = json.displayAdditionalCustomUserMessage; // "Y" or "N"
			var additionalCustomUserMessageType = json.additionalCustomUserMessageType; // "error" or "success" or "information"
			var additionalCustomUserMessage = json.additionalCustomUserMessage; // "" or "Additional message here..."

			// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
			// Custom Error Message
			var displayCustomErrorMessage = json.displayCustomErrorMessage; // "Y" or "N"
			var customErrorMessage = json.customErrorMessage; // Override auto-created error message

		} else {

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(data);
				if (continueDebug != true) {
					return;
				}
			}

			// Create Output Format: Error #|Error Message|Record/Attribute Group Name|Record/Attribute Subgroup Name|Record id|Formatted Record/Attribute Group Name|Formatted Record/Attribute Subgroup Name|Dummy HTML Element ID|HTML Record Output|Refresh Window Flag|Refresh Window Dom Container Element Id|Refresh Window Ajax Url String
			var arrTemp = data.split('|');
			var errorNumber = arrTemp[0]; // E.g. "0" - Error Section
			var errorMessage = arrTemp[1]; // E.g. "Error Creating Project Record"
			var attributeGroupName = arrTemp[2]; // E.g. "manage-project-record" - New HTML Record Attribute Group Name
			var attributeSubgroupName = arrTemp[3]; // E.g. "projects" - HTML Record Attribute Subgroup Name (same for new and old HTML Record)
			var uniqueId = arrTemp[4]; // New pk/uk value - New HTML Record Container Element id pk/uk portion
			var formattedAttributeGroupName = arrTemp[5]; // E.g. "Manage Table Name Record" - New HTML Record Formatted Attribute Group Name
			var formattedAttributeSubgroupName = arrTemp[6]; // E.g. "Projects" - HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var previousAttributeGroupName = arrTemp[7]; // E.g. "create-project-record" - Previous HTML Record Attribute Group Name
			var dummyId = arrTemp[8]; // Old pk/uk dummy placeholder value - Previous HTML Record Container Element id pk/uk portion (Original "Create Form")
			var htmlRecord = arrTemp[9]; // HTML itself - HTML Record
			var refreshWindow = arrTemp[10]; // "Y" or "N" - full screen refresh - Reload the browser window via javascript

			if (refreshWindow && (refreshWindow == 'Y')) {
				var performRefreshOperation = 'Y';
				var refreshOperationType = 'full_screen_refresh';
			}

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = arrTemp[11]; // "Y" or "N" - Change out id and onchange handler

			// Replace Operation Directives
			var performReplaceOperation = arrTemp[12]; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation Directives
			// @todo Add prepend and insert sorted options
			var performAppendOperation = arrTemp[13]; // "Y" or "N" - Add HTML Record to the list

			// Custom Success Message
			var displayCustomSuccessMessage = arrTemp[14]; // "Y" or "N"
			var customSuccessMessage = arrTemp[15]; // Override auto-created success message

			// May have "--sort_order--" in recordContainerElementId
			// Default to true for pipe-delimited case
			var sortOrderFlag = 'Y';

		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		if (typeof recordContainerElementId == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			} else {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;
			}
		}

		// Previous HTML Record Container Element id
		if (typeof recordContainerElementIdOld == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + dummyId;
			} else {
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--' + dummyId;
			}
		}

		// HTML Record List Container Element id Format: id="record_list_container--htmlAttributeGroup"
		if (typeof recordListContainerElementId == 'undefined') {
			var recordListContainerElementId = 'record_list_container--' + attributeGroupName;
		}

		// HTML Record List Container Element id Format: id="record_list_container--htmlAttributeGroup"
		if (typeof recordCreationFormContainerElementId == 'undefined') {
			var recordCreationFormContainerElementId = 'record_creation_form_container--' + attributeGroupName + '--' + dummyId;
		}

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm('New recordContainerElementId: ' + recordContainerElementId + ' Previous recordContainerElementId: ' + recordContainerElementIdOld);
			if (continueDebug != true) {
				return;
			}
		}

		if (errorNumber == 0) {

			// Dom Swap
			if (performDomSwapOperation == 'Y') {
				// Iterate over the record container and each child element and change the element id and add an onchange handler
				// 1) Modify the HTML Record Container itself to have the updated id value
				$("#" + recordContainerElementIdOld).attr('id', recordContainerElementId);

				// 2) Modify each child element to have an updated element id and an onchange handler
				// var onchangeHandler = "updateActionItem(this, { responseDataType : 'json' })";
				var onchangeHandler = onchangeHandlerFunction + "(this, { responseDataType : 'json' })";
				var arrChildrenIds = $("#" + recordContainerElementId).find('[id]');
				$.each(arrChildrenIds,
					function() {
						var tmpId = this.id;

						// Not all of the elements have an id attribute defined
						// The above find operation should filter the list though
						if (tmpId) {
							var index = tmpId.indexOf(previousAttributeGroupName);
							if (index == 0) {
								// find/replace the id with the updated attributeGroupName
								// E.g. "create-project-record" to "manage-project-record"
								newId = tmpId.replace(previousAttributeGroupName, attributeGroupName);
								newId = newId.replace(dummyId, uniqueId);

								// Debug
								//alert(newId);

								$(this).attr('id', newId);
								$(this).attr('onchange', onchangeHandler);
							}
						}
					}
				);
			}

			// Replace old HTML placeholder with the returned HTML Record
			if (performReplaceOperation == 'Y') {
				$("#" + recordContainerElementIdOld).replaceWith(htmlRecord);
			}

			// Append the returned HTML Record to the list
			if (performAppendOperation != '') {
				// @todo Add prepend and insert sorted options
				$("#" + recordListContainerElementId).append(htmlRecord);
			}

			// User Messaging
			// Only skip all messaging for displayUserMessages == "N"
			// If the variable is not explicitly set/present and "N" in value, then display messages
			if (!displayUserMessages || (displayUserMessages == 'Y')) {
				if (responseDataType == 'application/json') {
					libCodeGen_userMessaging(json, 'create');
				}
			}

			// @todo Add all refresh operations here...
			if (performRefreshOperation && (performRefreshOperation == 'Y')) {
				if (refreshOperationType = 'full_screen_refresh') {
					window.location.reload(true);
				}
				if (refreshOperationType = 'dom_element_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + refreshOperationContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_list_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordListContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'callback_handler_refresh') {
					// @todo...???
				}
			}

			//window.location.reload(true);
		} else {
			messageAlert(errorMessage, 'errorMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function defaultAjaxCallback_loadSuccess(data, textStatus, jqXHR)
{
	try {

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

		// Load (Read) Output Format: Error #|Error Message|Record/Attribute Container Name|Record/Attribute Container id|Formatted Record/Attribute Container Name|HTML Output
		var arrTemp = data.split('|');
		var errorNumber = arrTemp[0];
		var errorMessage = arrTemp[1];
		var recordContainerElementId = arrTemp[2];
		var uniqueId = arrTemp[3];
		var formattedRecordContainerName = arrTemp[4];
		var htmlOutput = arrTemp[5];

		// HTML Record Container Element id Format:
		// id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		// or
		// another format, but passed in dynamically so does not matter

		//var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;

		if (errorNumber == 0) {
			$("#" + recordContainerElementId).html(htmlOutput);
		} else {
			messageAlert(errorMessage, 'errorMessage', 'errorMessageLabel', recordContainerElementId);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function defaultAjaxCallback_loadAllRecordsSuccess(data, textStatus, jqXHR)
{
	try {

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

		// Load (Read) Output Format: Error #|Error Message|Record/Attribute Container Name|Record/Attribute Container id|Formatted Record/Attribute Container Name|HTML Output
		var arrTemp = data.split('|');
		var errorNumber = arrTemp[0];
		var errorMessage = arrTemp[1];
		var attributeGroupName = arrTemp[2];
		var attributeSubgroupName = arrTemp[3];
		var recordListContainerElementId = arrTemp[4];
		var formattedAttributeGroupName = arrTemp[5];
		var formattedAttributeSubgroupName = arrTemp[6];
		var htmlOutput = arrTemp[7];

		// HTML Record List Container Element id Format:
		// id="record_list_container--attributeGroupName"
		// or
		// another format, but passed in dynamically so does not matter

		//var recordListContainerElementId = 'record_list_container--' + attributeGroupName;
		//if ($("#" + recordListContainerElementId).length) {

		if (errorNumber == 0) {
			$("#" + recordListContainerElementId).html(htmlOutput);
		} else {
			messageAlert(errorMessage, 'errorMessage', 'errorMessageLabel', recordListContainerElementId);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function defaultAjaxCallback_updateSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var responseDataType = jqXHR.getResponseHeader('Content-Type');

		// Debug
		//alert(responseDataType);
		//return;

		if (responseDataType == 'application/json') {

			var json = data;

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var jsonObjectAsString = JSON.stringify(json);
				var continueDebug = window.confirm(jsonObjectAsString);
				if (continueDebug != true) {
					return;
				}
			}

			// Get custom result set of JSON HTML Record objects to iterate over them - each has directives and data
			//var arrHtmlRecordObjects = json.arrHtmlRecordObjects;

			// @todo Implement this after fully switched over to json
			// Iterate over JSON objects here via for loop...

			// Potentially skip this entire success callback - useful when a custom callback is needed for a specific interface or code block
			var skipDefaultSuccessCallback = json.skipDefaultSuccessCallback; // "Y" or "N"
			if (skipDefaultSuccessCallback && (skipDefaultSuccessCallback == 'Y')) {
				return;
			}

			// Error Section
			var errorNumber = json.errorNumber; // E.g. "0"
			var errorMessage = json.errorMessage; // E.g. "Error Creating Project Record"

			// Ad hoc HTML Container Element id
			var containerElementId = json.containerElementId;

			// HTML Record List-Container Element id
			var recordListContainerElementId = json.recordListContainerElementId; // Complete HTML Record List Container Element Id

			// Deleted HTML Record Container Element id
			var recordContainerElementId = json.recordContainerElementId; // Complete HTML Record Container Element Id

			// Potentially delete Read-Only HTML Record Container Element id if it exists
			var readOnlyRecordContainerElementId = json.readOnlyRecordContainerElementId; // Complete Read-Only HTML Record Container Element Id

			// HTML Record Invidual Attribute Element Id
			var attributeElementId = json.attributeElementId; // Complete HTML Record Invidual Attribute Element Id

			// Read-Only HTML Record Invidual Attribute Element Id
			var readOnlyAttributeElementId = json.readOnlyAttributeElementId; // Complete HTML Record Invidual Attribute Element Id

			// Existing HTML Record Attribute Group Name
			var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"

			// Existing HTML Record Attribute Subgroup Name
			var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"

			// Existing HTML Record Attribute Name
			var attributeName = json.attributeName; // E.g. "project_name"

			// May have "--sort_order--" in recordContainerElementId
			var sortOrderFlag = json.sortOrderFlag;

			// Existing HTML Record Container Element id pk/uk portion (last id portion)
			var uniqueId = json.uniqueId; // E.g. "--1234"

			// Updated value for the given attribute
			var newValue = json.newValue; // E.g. "Tst Project" to "Test Project"

			// Existing HTML Record Formatted Attribute Group Name
			var formattedAttributeGroupName = json.formattedAttributeGroupName; // E.g. "Project"

			// Existing HTML Record Formatted Attribute Subgroup Name
			var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName; // E.g. "Projects"

			// Existing HTML Record Formatted Attribute Name
			var formattedAttributeName = json.formattedAttributeName; // E.g. "Project Name"

			// Previous HTML Record Container Element id pk/uk portion (will not change unless a candidate key attribute is updated)
			var previousId = json.previousId; // Old pk/uk if a candidate key attribue changed

			// Potentially sync a read_only sister attribute that is hidden - Default to "N"
			var syncReadOnlySisterAttribute = json.syncReadOnlySisterAttribute; // "Y" or "N"
			var syncReadOnlySisterAttributeType = json.syncReadOnlySisterAttributeType; // "text" or "checkbox" or "radio" or "select"
			if (!syncReadOnlySisterAttribute || (syncReadOnlySisterAttribute != 'N')) {
				syncReadOnlySisterAttribute = 'N';
			}

			// HTML Record Type
			var htmlRecordType = json.htmlRecordType; // HTML template type

			// HTML Record Template
			var htmlRecordTemplate = json.htmlRecordTemplate; // HTML template or include pseudo-label

			// HTML Record Itself
			var htmlRecord = json.htmlRecord; // HTML itself

			// HTML Content
			var htmlContent = json.htmlContent; // HTML ad-hoc content

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = json.performDomSwapOperation; // "Y" or "N"
			var onchangeHandlerFunction = json.onchangeHandlerFunction; // "updateFoo"

			// Replace Operation
			var performReplaceOperation = json.performReplaceOperation; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation
			// @todo Add prepend and insert sorted options
			var performAppendOperation = json.performAppendOperation; // "" or "insert" or "append" or "prepend" - Add HTML Record to the list

			// Refresh Operation Directives
			var performRefreshOperation = json.performRefreshOperation; // "Y" or "N"
			var refreshOperationType = json.refreshOperationType; // "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
			var refreshOperationContainerElementId = json.refreshOperationContainerElementId; // E.g. "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
			var refreshOperationUrl = json.refreshOperationUrl; // url to use for refresh operation

			// Display any messages at all to the user
			var displayUserMessages = json.displayUserMessages; // "Y" or "N" - Default is "Y" if not present

			// Custom Success Message
			var displayCustomSuccessMessage = json.displayCustomSuccessMessage; // "Y" or "N"
			var customSuccessMessage = json.customSuccessMessage; // Override auto-created success message

			// Custom Additional User Message
			var displayAdditionalCustomUserMessage = json.displayAdditionalCustomUserMessage; // "Y" or "N"
			var additionalCustomUserMessageType = json.additionalCustomUserMessageType; // "error" or "success" or "information"
			var additionalCustomUserMessage = json.additionalCustomUserMessage; // "" or "Additional message here..."

			// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
			var displayErrorMessage = json.displayErrorMessage;
			if (!displayErrorMessage || (displayErrorMessage != 'N')) {
				displayErrorMessage = 'Y';
			}

			// Custom Error Message
			var displayCustomErrorMessage = json.displayCustomErrorMessage; // "Y" or "N"
			var customErrorMessage = json.customErrorMessage; // Override auto-created error message

		} else {

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(data);
				if (continueDebug != true) {
					return;
				}
			}

			// Update Output Format: Error #|Error Message|Record/Attribute Group Name|Record/Attribute Subgroup Name|Attribute Name|Record id|Formatted Record/Attribute Group Name|Formatted Record/Attribute Subgroup Name|Formatted Attribute Name|Reset To Previous Value|Refresh Window Flag|Previous PK/UK Value
			var arrTemp = data.split('|');
			var errorNumber = arrTemp[0]; // E.g. "0" - Error Section
			var errorMessage = arrTemp[1]; // E.g. "Error Creating Project Record"
			var attributeGroupName = arrTemp[2]; // E.g. "manage-project-record" - New HTML Record Attribute Group Name
			var attributeSubgroupName = arrTemp[3]; // E.g. "projects" - HTML Record Attribute Subgroup Name
			var attributeName = arrTemp[4]; // E.g. "project_name"
			var uniqueId = arrTemp[5]; // E.g. "--1234" Existing HTML Record Container Element id pk/uk portion (last id portion)
			var formattedAttributeGroupName = arrTemp[6]; // E.g. "Manage Table Name Record" - Existing HTML Record Formatted Attribute Group Name
			var formattedAttributeSubgroupName = arrTemp[7]; // E.g. "Projects" - HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var formattedAttributeName = arrTemp[8];
			var resetToPreviousValue = arrTemp[9];
			var refreshWindow = arrTemp[10]; // "Y" or "N" - full screen refresh - Reload the browser window via javascript
			var previousId = arrTemp[11]; // Old pk/uk if a candidate key attribue changed - Previous HTML Record Container Element id pk/uk portion (will not change unless a candidate key attribute is updated)

			if (refreshWindow && (refreshWindow == 'Y')) {
				var performRefreshOperation = 'Y';
				var refreshOperationType = 'full_screen_refresh';
			}

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			//var performDomSwapOperation = arrTemp[12]; // "Y" or "N" - Change out id and onchange handler

			// Custom Success Message
			//var displayCustomSuccessMessage = arrTemp[13]; // "Y" or "N"
			//var customSuccessMessage = arrTemp[14]; // Override auto-created success message

			// May have "--sort_order--" in recordContainerElementId
			// Default to true for pipe-delimited case
			var sortOrderFlag = 'Y';

		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		if (typeof recordContainerElementId == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
				var readOnlyRecordContainerElementId = 'record_container--' + attributeGroupName + '-read_only--' + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			} else {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;
				var readOnlyRecordContainerElementId = 'record_container--' + attributeGroupName + '-read_only--' + '--' + attributeSubgroupName + '--' + uniqueId;
			}
		}

		// Previous HTML Record Container Element id
		if (previousId && (typeof recordContainerElementIdOld == 'undefined')) {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementIdOld = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + previousId;
				var readOnlyRecordContainerElementIdOld = 'record_container--' + attributeGroupName + '-read_only--' + '--' + attributeSubgroupName + '--sort_order--' + previousId;
			} else {
				var recordContainerElementIdOld = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + previousId;
				var readOnlyRecordContainerElementIdOld = 'record_container--' + attributeGroupName + '-read_only--' + '--' + attributeSubgroupName + '--' + previousId;
			}
		}

		// HTML Record List Container Element id Format: id="record_list_container--htmlAttributeGroup"
		if (typeof recordListContainerElementId == 'undefined') {
			var recordListContainerElementId = 'record_list_container--' + attributeGroupName;
		}
		var recordListContainerElement = $("#" + recordListContainerElementId);

		// HTML element of the HTML Record Attribute that was updated
		// HTML Element id Format: id="attributeGroupName--attributeSubgroupName--attributeName--uniqueId"
		var elementId = attributeGroupName + '--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;
		var readOnlyElementId = attributeGroupName + '-read_only--' + '--' + attributeSubgroupName + '--' + attributeName + '--' + uniqueId;

		var element = $("#" + elementId);
		var readOnlyElement = $("#" + readOnlyElementId);

		// @todo Finish DOM SWAP as that would make the most sense with full HTML for a change to the unique_id (primary key) value
		if (uniqueId != previousId) {
			var elementIdOld = attributeGroupName + '--' + attributeSubgroupName + '--' + attributeName + '--' + previousId;
			var readOnlyElementIdOld = attributeGroupName + '-read_only--' + '--' + attributeSubgroupName + '--' + attributeName + '--' + previousId;
		} else {
			elementIdOld = '';
			var readOnlyElementIdOld = '';
		}

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm('elementId: ' + elementId + ' Previous elementId: ' + elementIdOld);
			if (continueDebug != true) {
				return;
			}
		}

		//if ($("#" + elementId).length) {
		if (errorNumber == 0) {

			// Potentially sync a read_only sister attribute that is hidden - Default to "N"
			if (syncReadOnlySisterAttribute == 'Y') {
				if ($(readOnlyElement).length) {

					// Check if checkbox, etc.
					if (syncReadOnlySisterAttributeType == 'html') {

						var updatedValue = $(element).val();
						$(readOnlyElement).html(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'button') && $(readOnlyElement).is(':button')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'checkbox') && $(readOnlyElement).is(':checkbox')) {

						var updatedCheckedValue = $(element).is(':checked') || false;
						$(readOnlyElement).prop('checked', updatedCheckedValue);

					} else if ((syncReadOnlySisterAttributeType == 'file') && $(readOnlyElement).is('input:file')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'hidden') && $(readOnlyElement).is('input:hidden')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'image') && $(readOnlyElement).is('input:image')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'password') && $(readOnlyElement).is('input:password')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'radio') && $(readOnlyElement).is('input:radio')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'reset') && $(readOnlyElement).is('input:reset')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'submit') && $(readOnlyElement).is('input:submit')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else if ((syncReadOnlySisterAttributeType == 'text') && $(readOnlyElement).is('input:text')) {

						var updatedValue = $(element).val();
						$(readOnlyElement).val(updatedValue);

					} else {

						// Auto sniff val vs html
						var updatedValue = $(element).val();
						var tmpElement = $(readOnlyElement);
						if (tmpElement[0].value !== undefined) {
							tmpElement.val(updatedValue);
						} else {
							tmpElement.html(updatedValue);
						}

					}

				}
			}

			// Dom Swap - Candidate key (pk/uk) attribute value changed case
			if ((typeof performDomSwapOperation != 'undefined') && (performDomSwapOperation == 'Y')) {
				$("#" + recordContainerElementIdOld).attr('id', recordContainerElementId);
				// var onchangeHandler = 'onchange="updateActionItem(this, { responseDataType : \'json\' });"';
				var onchangeHandler = 'onchange="' + onchangeHandlerFunction + '(this, { responseDataType : \'json\' });"';
				$("#" + recordContainerElementId).change(onchangeHandler);
			}

			// Replace old HTML placeholder with the returned HTML Record
			if ((typeof performReplaceOperation != 'undefined') && (performReplaceOperation == 'Y')) {
				$("#" + recordContainerElementIdOld).replaceWith(htmlRecord);
			}

			// Append the returned HTML Record to the list
			if ((typeof performAppendOperation != 'undefined') && (performAppendOperation != '')) {
				// @todo Add prepend and insert sorted options
				var performAppendOperationSuccessFlag = libCodeGen_performAppendOperation(performAppendOperation, recordListContainerElement, htmlRecord, json);
			}

			// User Messaging
			// Only skip all messaging for displayUserMessages == "N"
			// If the variable is not explicitly set/present and "N" in value, then display messages
			if (!displayUserMessages || (displayUserMessages == 'Y')) {
				if (responseDataType == 'application/json') {
					libCodeGen_userMessaging(json, 'update');
				}
			}

			// @todo Add all refresh operations here...
			if (performRefreshOperation && (performRefreshOperation == 'Y')) {
				if (refreshOperationType = 'full_screen_refresh') {
					window.location.reload(true);
				}
				if (refreshOperationType = 'dom_element_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + refreshOperationContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_list_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordListContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'callback_handler_refresh') {
					// @todo...???
				}
			}

		} else {
			if ((typeof displayErrorMessage != 'undefined') && (displayErrorMessage == 'Y')) {
				// messageAlert(errorMessage, 'errorMessage', 'errorMessageLabel', elementId);
				messageAlert(errorMessage, 'errorMessage');
			}

			// Debug
			//alert(resetToPreviousValue);

			if (resetToPreviousValue == 'Y') {
				var previousElementId = 'previous--' + elementId;
				var previousValue = $("#" + previousElementId).val();
				$("#" + elementId).val(previousValue);
			}
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function defaultAjaxCallback_updateAllAttributesSuccess(data, textStatus, jqXHR)
{
	try {

		defaultAjaxCallback_updateSuccess(data, textStatus, jqXHR);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function defaultAjaxCallback_deleteSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var responseDataType = jqXHR.getResponseHeader('Content-Type');

		// Debug
		//alert(responseDataType);
		//return;

		if (responseDataType == 'application/json') {

			var json = data;

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var jsonObjectAsString = JSON.stringify(json);
				var continueDebug = window.confirm(jsonObjectAsString);
				if (continueDebug != true) {
					return;
				}
			}

			// Get custom result set of JSON HTML Record objects to iterate over them - each has directives and data
			//var arrHtmlRecordObjects = json.arrHtmlRecordObjects;

			// @todo Implement this after fully switched over to json
			// Iterate over JSON objects here via for loop...

			// Potentially skip this entire success callback - useful when a custom callback is needed for a specific interface or code block
			var skipDefaultSuccessCallback = json.skipDefaultSuccessCallback; // "Y" or "N"
			if (skipDefaultSuccessCallback && (skipDefaultSuccessCallback == 'Y')) {
				return;
			}

			// Error Section
			var errorNumber = json.errorNumber; // E.g. "0"
			var errorMessage = json.errorMessage; // E.g. "Error Deleting Project Record"

			// Ad hoc HTML Container Element id
			var containerElementId = json.containerElementId;

			// HTML Record List-Container Element id
			var recordListContainerElementId = json.recordListContainerElementId; // Complete HTML Record List Container Element Id

			// Deleted HTML Record Container Element id
			var recordContainerElementId = json.recordContainerElementId; // Complete HTML Record Container Element Id

			// Potentially delete Read-Only HTML Record Container Element id if it exists
			var readOnlyRecordContainerElementId = json.readOnlyRecordContainerElementId; // Complete Read-Only HTML Record Container Element Id

			// Deleted HTML Record Attribute Group Name
			var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"

			// Deleted HTML Record Attribute Subgroup Name
			var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"

			// May have "--sort_order--" in recordContainerElementId
			var sortOrderFlag = json.sortOrderFlag;

			// Deleted HTML Record Container Element id pk/uk portion (last id portion)
			var uniqueId = json.uniqueId; // E.g. "--1234"

			// Deleted HTML Record Formatted Attribute Group Name
			var formattedAttributeGroupName = json.formattedAttributeGroupName; // E.g. "Project"

			// HTML Record Formatted Attribute Subgroup Name
			var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName; // E.g. "Projects"

			// DOM Delete Operation Directives
			var performDomDeleteOperation = json.performDomDeleteOperation; // Typical values: "" or "Y" or "N" - Default is "Y" if not present
			var domDeleteOperationType = json.domDeleteOperationType; // Typical values: "" or "html_record" or "html_record_list" or "html_dom_container"
			var domDeleteOperationAction = json.domDeleteOperationAction; // Typical values: "" or "delete" or "hide" or "disable" - "" is the same as "delete"
			// Assumed to be the recordContainerElementId for the { domDeleteOperationType: html_record, or domDeleteOperationType: "" } cases
			var domDeleteOperationContainerElementId = json.domDeleteOperationContainerElementId; // Typical values: "" or "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node

			// Refresh Operation Directives
			var performRefreshOperation = json.performRefreshOperation; // "Y" or "N"
			var refreshOperationType = json.refreshOperationType; // "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
			var refreshOperationContainerElementId = json.refreshOperationContainerElementId; // E.g. "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
			var refreshOperationUrl = json.refreshOperationUrl; // url to use for refresh operation

			// Display any messages at all to the user
			var displayUserMessages = json.displayUserMessages; // "Y" or "N" - Default is "Y" if not present

			// Custom Success Message
			var displayCustomSuccessMessage = json.displayCustomSuccessMessage; // "Y" or "N"
			var customSuccessMessage = json.customSuccessMessage; // Override auto-created success message

			// Custom Additional User Message
			var displayAdditionalCustomUserMessage = json.displayAdditionalCustomUserMessage; // "Y" or "N"
			var additionalCustomUserMessageType = json.additionalCustomUserMessageType; // "error" or "success" or "information"
			var additionalCustomUserMessage = json.additionalCustomUserMessage; // "" or "Additional message here..."

			// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
			// Custom Error Message
			var displayCustomErrorMessage = json.displayCustomErrorMessage; // "Y" or "N"
			var customErrorMessage = json.customErrorMessage; // Override auto-created error message

		} else {

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(data);
				if (continueDebug != true) {
					return;
				}
			}

			// Delete Output Format: Error #|Error Message|Record/Attribute Group Name|Record id|Formatted Record/Attribute Group Name
			var arrTemp = data.split('|');
			var errorNumber = arrTemp[0];
			var errorMessage = arrTemp[1];
			var recordContainerElementId = arrTemp[2];
			var attributeGroupName = arrTemp[3];
			var attributeSubgroupName = arrTemp[4];
			var uniqueId = arrTemp[5];
			var formattedAttributeGroupName = arrTemp[6];
			var formattedAttributeSubgroupName = arrTemp[7];
			var performDomDeleteOperation = arrTemp[8];

			// Set defaults for legacy pipe-delimited case
			if (performDomDeleteOperation && (performDomDeleteOperation == 'Y')) {
				var performDomDeleteOperation = 'Y';
				var domDeleteOperationType = 'html_record';
				var domDeleteOperationAction = 'delete';
				var domDeleteOperationContainerElementId = recordContainerElementId;
			}

			// Check the recordContainerElementId
			if (!recordContainerElementId || (recordContainerElementId == '')) {
				// May have "--sort_order--" in recordContainerElementId
				// Default to true for pipe-delimited case
				var sortOrderFlag = 'Y';
			} else if (recordContainerElementId) {
				var tmpIndex = recordContainerElementId.indexOf('sort_order');
				if (tmpIndex > -1) {
					var sortOrderFlag = 'Y';
				} else {
					var sortOrderFlag = 'N';
				}
			}

		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		if (typeof recordContainerElementId == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			} else {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;
			}
		}

		// Read-only HTML Record Container Element
		if (typeof readOnlyRecordContainerElementId == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var readOnlyRecordContainerElementId = 'record_container--' + attributeGroupName + '-read_only--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			} else {
				var readOnlyRecordContainerElementId = 'record_container--' + attributeGroupName + '-read_only--' + attributeSubgroupName + '--' + uniqueId;
			}
		}

		var recordContainerElement = $("#" + recordContainerElementId);
		var readOnlyRecordContainerElement = $("#" + readOnlyRecordContainerElementId);

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm('[recordContainerElementId]: ' + recordContainerElementId + ' [performDomDeleteOperation]: ' + performDomDeleteOperation + ' [domDeleteOperationType]: ' + domDeleteOperationType);
			if (continueDebug != true) {
				return;
			}
		}

		if (errorNumber == 0) {

			// DOM Delete Operations
			// Set the defaults
			if (!performDomDeleteOperation || (performDomDeleteOperation == '')) {
				var performDomDeleteOperation = 'Y';
				var domDeleteOperationType = 'html_record';
				var domDeleteOperationAction = 'delete';
				var domDeleteOperationContainerElementId = recordContainerElementId;
			}

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm('[performDomDeleteOperation:] ' + performDomDeleteOperation + ' [domDeleteOperationType:] ' + domDeleteOperationType + ' [domDeleteOperationAction:] ' + domDeleteOperationAction + ' [domDeleteOperationContainerElementId:] ' + domDeleteOperationContainerElementId);
				if (continueDebug != true) {
					return;
				}
			}

			// Perform the delete operations
			if (performDomDeleteOperation && (performDomDeleteOperation == 'Y')) {
				if (domDeleteOperationType == 'html_record') {
					if (domDeleteOperationAction == 'delete') {
						$(recordContainerElement).remove();
						$(readOnlyRecordContainerElement).remove();
					}
				}

				// @todo Implement all DOM delete operations
			}

			// User Messaging
			// Only skip all messaging for displayUserMessages == "N"
			// If the variable is not explicitly set/present and "N" in value, then display messages
			if (!displayUserMessages || (displayUserMessages == 'Y')) {
				if (responseDataType == 'application/json') {
					libCodeGen_userMessaging(json, 'delete');
				}
			}

			// @todo Add all refresh operations here...
			if (performRefreshOperation && (performRefreshOperation == 'Y')) {
				if (refreshOperationType = 'full_screen_refresh') {
					window.location.reload(true);
				}
				if (refreshOperationType = 'dom_element_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + refreshOperationContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_list_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordListContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'callback_handler_refresh') {
					// @todo...???
				}
			}

			// @todo Remove this directive after implementation of: performRefreshOperation
			//window.location.reload(true);
		} else {
			messageAlert(errorMessage, 'errorMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function defaultAjaxCallback_saveSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var responseDataType = jqXHR.getResponseHeader('Content-Type');

		// Debug
		//alert(responseDataType);
		//return;

		if (responseDataType == 'application/json') {

			var json = data;

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var jsonObjectAsString = JSON.stringify(json);
				var continueDebug = window.confirm(jsonObjectAsString);
				if (continueDebug != true) {
					return;
				}
			}

			// Get custom result set of JSON HTML Record objects to iterate over them - each has directives and data
			//var arrHtmlRecordObjects = json.arrHtmlRecordObjects;

			// @todo Implement this after fully switched over to json
			// Iterate over JSON objects here via for loop...

			// Potentially skip this entire success callback - useful when a custom callback is needed for a specific interface or code block
			var skipDefaultSuccessCallback = json.skipDefaultSuccessCallback; // "Y" or "N"
			if (skipDefaultSuccessCallback && (skipDefaultSuccessCallback == 'Y')) {
				return;
			}

			// Error Section
			var errorNumber = json.errorNumber; // E.g. "0"
			var errorMessage = json.errorMessage; // E.g. "Error Creating Project Record"

			// New HTML Record Attribute Group Name
			var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"

			// HTML Record Attribute Subgroup Name (same for new and old HTML Record)
			var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"

			// May have "--sort_order--" in recordContainerElementId
			var sortOrderFlag = json.sortOrderFlag;

			// New HTML Record Container Element id pk/uk portion (last id portion)
			var uniqueId = json.uniqueId; // New Id, E.g. "--1234"

			// New HTML Record Formatted Attribute Group Name
			var formattedAttributeGroupName = json.formattedAttributeGroupName; // E.g. "Project"

			// HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName; // E.g. "Projects"

			// Previous HTML Record Attribute Group Name
			var previousAttributeGroupName = json.previousAttributeGroupName; // E.g. "create-project-record"

			// Previous HTML Record Container Element id pk/uk portion (Original "Create Form")
			var dummyId = json.dummyId; // Old pk/uk dummy placeholder

			// HTML Record Type
			var htmlRecordType = json.htmlRecordType; // HTML template or include pseudo-label

			// HTML Record Itself
			var htmlRecord = json.htmlRecord; // HTML itself

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = json.performDomSwapOperation; // "Y" or "N"
			var onchangeHandlerFunction = json.onchangeHandlerFunction; // "updateFoo"

			// Replace Operation
			var performReplaceOperation = json.performReplaceOperation; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation
			// @todo Add prepend and insert sorted options
			var performAppendOperation = json.performAppendOperation; // "" or "insert" or "append" or "prepend" - Add HTML Record to the list

			// Refresh Operation Directives
			var performRefreshOperation = json.performRefreshOperation; // "Y" or "N"
			var refreshOperationType = json.refreshOperationType; // "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
			var refreshOperationContainerElementId = json.refreshOperationContainerElementId; // E.g. "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
			var refreshOperationUrl = json.refreshOperationUrl; // url to use for refresh operation

			// Display any messages at all to the user
			var displayUserMessages = json.displayUserMessages; // "Y" or "N" - Default is "Y" if not present

			// Custom Success Message
			var displayCustomSuccessMessage = json.displayCustomSuccessMessage; // "Y" or "N"
			var customSuccessMessage = json.customSuccessMessage; // Override auto-created success message

			// Custom Additional User Message
			var displayAdditionalCustomUserMessage = json.displayAdditionalCustomUserMessage; // "Y" or "N"
			var additionalCustomUserMessageType = json.additionalCustomUserMessageType; // "error" or "success" or "information"
			var additionalCustomUserMessage = json.additionalCustomUserMessage; // "" or "Additional message here..."

			// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
			// Custom Error Message
			var displayCustomErrorMessage = json.displayCustomErrorMessage; // "Y" or "N"
			var customErrorMessage = json.customErrorMessage; // Override auto-created error message

		} else {

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(data);
				if (continueDebug != true) {
					return;
				}
			}

			// Create Output Format: Error #|Error Message|Record/Attribute Group Name|Record/Attribute Subgroup Name|Record id|Formatted Record/Attribute Group Name|Formatted Record/Attribute Subgroup Name|Dummy HTML Element ID|HTML Record Output|Refresh Window Flag|Refresh Window Dom Container Element Id|Refresh Window Ajax Url String
			var arrTemp = data.split('|');
			var errorNumber = arrTemp[0]; // E.g. "0" - Error Section
			var errorMessage = arrTemp[1]; // E.g. "Error Creating Project Record"
			var attributeGroupName = arrTemp[2]; // E.g. "manage-project-record" - New HTML Record Attribute Group Name
			var attributeSubgroupName = arrTemp[3]; // E.g. "projects" - HTML Record Attribute Subgroup Name (same for new and old HTML Record)
			var uniqueId = arrTemp[4]; // New pk/uk value - New HTML Record Container Element id pk/uk portion
			var formattedAttributeGroupName = arrTemp[5]; // E.g. "Manage Table Name Record" - New HTML Record Formatted Attribute Group Name
			var formattedAttributeSubgroupName = arrTemp[6]; // E.g. "Projects" - HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var previousAttributeGroupName = arrTemp[7]; // E.g. "create-project-record" - Previous HTML Record Attribute Group Name
			var dummyId = arrTemp[8]; // Old pk/uk dummy placeholder value - Previous HTML Record Container Element id pk/uk portion (Original "Create Form")
			var htmlRecord = arrTemp[9]; // HTML itself - HTML Record
			var refreshWindow = arrTemp[10]; // "Y" or "N" - full screen refresh - Reload the browser window via javascript

			if (refreshWindow && (refreshWindow == 'Y')) {
				var performRefreshOperation = 'Y';
				var refreshOperationType = 'full_screen_refresh';
			}

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = arrTemp[11]; // "Y" or "N" - Change out id and onchange handler

			// Replace Operation Directives
			var performReplaceOperation = arrTemp[12]; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation Directives
			// @todo Add prepend and insert sorted options
			var performAppendOperation = arrTemp[13]; // "Y" or "N" - Add HTML Record to the list

			// Custom Success Message
			var displayCustomSuccessMessage = arrTemp[14]; // "Y" or "N"
			var customSuccessMessage = arrTemp[15]; // Override auto-created success message

			// May have "--sort_order--" in recordContainerElementId
			// Default to true for pipe-delimited case
			var sortOrderFlag = 'Y';

		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		if (typeof recordContainerElementId == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			} else {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;
			}
		}

		// Previous HTML Record Container Element id
		if (typeof recordContainerElementIdOld == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + dummyId;
			} else {
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--' + dummyId;
			}
		}

		// HTML Record List Container Element id Format: id="record_list_container--htmlAttributeGroup"
		if (typeof recordListContainerElementId == 'undefined') {
			var recordListContainerElementId = 'record_list_container--' + attributeGroupName;
		}

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm('New recordContainerElementId: ' + recordContainerElementId + ' Previous recordContainerElementId: ' + recordContainerElementIdOld);
			if (continueDebug != true) {
				return;
			}
		}

		if (errorNumber == 0) {

			// Dom Swap
			if (performDomSwapOperation == 'Y') {
				$("#" + recordContainerElementIdOld).attr('id', recordContainerElementId);
				// var onchangeHandler = 'onchange="updateActionItem(this, { responseDataType : \'json\' });"';
				var onchangeHandler = 'onchange="' + onchangeHandlerFunction + '(this, { responseDataType : \'json\' });"';
				$("#" + recordContainerElementId).change(onchangeHandler);
			}

			// Replace old HTML placeholder with the returned HTML Record
			if (performReplaceOperation == 'Y') {
				$("#" + recordContainerElementIdOld).replaceWith(htmlRecord);
			}

			// Append the returned HTML Record to the list
			if (performAppendOperation != '') {
				// @todo Add prepend and insert sorted options
				$("#" + recordListContainerElementId).append(htmlRecord);
			}

			// User Messaging
			// Only skip all messaging for displayUserMessages == "N"
			// If the variable is not explicitly set/present and "N" in value, then display messages
			if (!displayUserMessages || (displayUserMessages == 'Y')) {
				if (responseDataType == 'application/json') {
					libCodeGen_userMessaging(json, 'save');
				}
			}

			// @todo Add all refresh operations here...
			if (performRefreshOperation && (performRefreshOperation == 'Y')) {
				if (refreshOperationType = 'full_screen_refresh') {
					window.location.reload(true);
				}
				if (refreshOperationType = 'dom_element_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + refreshOperationContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_list_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordListContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'callback_handler_refresh') {
					// @todo...???
				}
			}

			//window.location.reload(true);
		} else {
			messageAlert(data, 'errorMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function defaultAjaxCallback_renderCreationFormSuccess(data, textStatus, jqXHR)
{
	try {

		var responseDataType = jqXHR.getResponseHeader('Content-Type');

		// Debug
		//alert(responseDataType);
		//return;

		if (responseDataType == 'application/json') {

			var json = data;

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var jsonObjectAsString = JSON.stringify(json);
				var continueDebug = window.confirm(jsonObjectAsString);
				if (continueDebug != true) {
					return;
				}
			}

			// Get custom result set of JSON HTML Record objects to iterate over them - each has directives and data
			//var arrHtmlRecordObjects = json.arrHtmlRecordObjects;

			// @todo Implement this after fully switched over to json
			// Iterate over JSON objects here via for loop...

			// Potentially skip this entire success callback - useful when a custom callback is needed for a specific interface or code block
			var skipDefaultSuccessCallback = json.skipDefaultSuccessCallback; // "Y" or "N"
			if (skipDefaultSuccessCallback && (skipDefaultSuccessCallback == 'Y')) {
				return;
			}

			// Error Section
			var errorNumber = json.errorNumber; // E.g. "0"
			var errorMessage = json.errorMessage; // E.g. "Error Creating Project Record"

			// New HTML Record Attribute Group Name
			var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"

			// HTML Record Attribute Subgroup Name (same for new and old HTML Record)
			var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"

			// May have "--sort_order--" in recordContainerElementId
			var sortOrderFlag = json.sortOrderFlag;

			// New HTML Record Container Element id pk/uk portion (last id portion)
			var uniqueId = json.uniqueId; // New Id, E.g. "--1234"

			// New HTML Record Formatted Attribute Group Name
			var formattedAttributeGroupName = json.formattedAttributeGroupName; // E.g. "Project"

			// HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName; // E.g. "Projects"

			// Previous HTML Record Attribute Group Name
			var previousAttributeGroupName = json.previousAttributeGroupName; // E.g. "create-project-record"

			// Previous HTML Record Container Element id pk/uk portion (Original "Create Form")
			var dummyId = json.dummyId; // Old pk/uk dummy placeholder

			// HTML Creation Form Type
			var htmlRecordCreationFormType = json.htmlRecordCreationFormType; // E.g. "tabularDataRowHorizontalCreationForm"

			// HTML Creation Form Itself
			var htmlRecordCreationForm = json.htmlRecordCreationForm; // HTML Itself

			// Dom Reference element
			var optionalReferenceElementId = json.optionalReferenceElementId; // Reference element for "prepend" or "insert" or "append"

			// Dom Reference element
			var performCreationFormAppendOperation = json.performCreationFormAppendOperation; // "" or "insert" or "append" or "prepend" - Add HTML Creation Form to the list

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = json.performDomSwapOperation; // "Y" or "N"
			var onchangeHandlerFunction = json.onchangeHandlerFunction; // "updateFoo"

			// Replace Operation
			var performReplaceOperation = json.performReplaceOperation; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation
			// @todo Add prepend and insert sorted options
			var performAppendOperation = json.performAppendOperation; // "" or "insert" or "append" or "prepend" - Add HTML Record to the list

			// Refresh Operation Directives
			var performRefreshOperation = json.performRefreshOperation; // "Y" or "N"
			var refreshOperationType = json.refreshOperationType; // "full_screen_refresh" or "dom_element_refresh" or "html_record_list_refresh" or "html_record_refresh" or "callback_handler_refresh"
			var refreshOperationContainerElementId = json.refreshOperationContainerElementId; // E.g. "div" or "record_list_container--htmlAttributeGroup" or any other block level dom node
			var refreshOperationUrl = json.refreshOperationUrl; // url to use for refresh operation

			// Display any messages at all to the user
			var displayUserMessages = json.displayUserMessages; // "Y" or "N" - Default is "Y" if not present

			// Custom Success Message
			var displayCustomSuccessMessage = json.displayCustomSuccessMessage; // "Y" or "N"
			var customSuccessMessage = json.customSuccessMessage; // Override auto-created success message

			// Custom Additional User Message
			var displayAdditionalCustomUserMessage = json.displayAdditionalCustomUserMessage; // "Y" or "N"
			var additionalCustomUserMessageType = json.additionalCustomUserMessageType; // "error" or "success" or "information"
			var additionalCustomUserMessage = json.additionalCustomUserMessage; // "" or "Additional message here..."

			// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
			// Custom Error Message
			var displayCustomErrorMessage = json.displayCustomErrorMessage; // "Y" or "N"
			var customErrorMessage = json.customErrorMessage; // Override auto-created error message

		} else {

			// This will show either a pipe-delimited string or [object object] for the JSON case
			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(data);
				if (continueDebug != true) {
					return;
				}
			}

			// Create Output Format: Error #|Error Message|Record/Attribute Group Name|Record/Attribute Subgroup Name|Record id|Formatted Record/Attribute Group Name|Formatted Record/Attribute Subgroup Name|Dummy HTML Element ID|HTML Record Output|Refresh Window Flag|Refresh Window Dom Container Element Id|Refresh Window Ajax Url String
			var arrTemp = data.split('|');
			var errorNumber = arrTemp[0]; // E.g. "0" - Error Section
			var errorMessage = arrTemp[1]; // E.g. "Error Creating Project Record"
			var attributeGroupName = arrTemp[2]; // E.g. "manage-project-record" - New HTML Record Attribute Group Name
			var attributeSubgroupName = arrTemp[3]; // E.g. "projects" - HTML Record Attribute Subgroup Name (same for new and old HTML Record)
			var uniqueId = arrTemp[4]; // New pk/uk value - New HTML Record Container Element id pk/uk portion
			var formattedAttributeGroupName = arrTemp[5]; // E.g. "Manage Table Name Record" - New HTML Record Formatted Attribute Group Name
			var formattedAttributeSubgroupName = arrTemp[6]; // E.g. "Projects" - HTML Record Formatted Attribute Subgroup Name (same for new and old HTML Record)
			var previousAttributeGroupName = arrTemp[7]; // E.g. "create-project-record" - Previous HTML Record Attribute Group Name
			var dummyId = arrTemp[8]; // Old pk/uk dummy placeholder value - Previous HTML Record Container Element id pk/uk portion (Original "Create Form")
			var htmlRecord = arrTemp[9]; // HTML itself - HTML Record
			var refreshWindow = arrTemp[10]; // "Y" or "N" - full screen refresh - Reload the browser window via javascript

			if (refreshWindow && (refreshWindow == 'Y')) {
				var performRefreshOperation = 'Y';
				var refreshOperationType = 'full_screen_refresh';
			}

			// DOM SWAP
			// Dom Swap Operation - Change out id and onchange handler of html record from "dummy create" to "pk-id update"
			var performDomSwapOperation = arrTemp[11]; // "Y" or "N" - Change out id and onchange handler

			// Replace Operation Directives
			var performReplaceOperation = arrTemp[12]; // "Y" or "N" - Replace HTML Record with new html

			// Append Operation Directives
			// @todo Add prepend and insert sorted options
			var performAppendOperation = arrTemp[13]; // "Y" or "N" - Add HTML Record to the list

			// Custom Success Message
			var displayCustomSuccessMessage = arrTemp[14]; // "Y" or "N"
			var customSuccessMessage = arrTemp[15]; // Override auto-created success message

			// May have "--sort_order--" in recordContainerElementId
			// Default to true for pipe-delimited case
			var sortOrderFlag = 'Y';

		}

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		if (typeof recordContainerElementId == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			} else {
				var recordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--' + uniqueId;
			}
		}

		// Previous HTML Record Container Element id
		if (typeof recordContainerElementIdOld == 'undefined') {
			if (sortOrderFlag == 'Y') {
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + dummyId;
			} else {
				var recordContainerElementIdOld = 'record_container--' + previousAttributeGroupName + '--' + attributeSubgroupName + '--' + dummyId;
			}
		}

		// HTML Record List Container Element id Format: id="record_list_container--htmlAttributeGroup"
		if (typeof recordListContainerElementId == 'undefined') {
			var recordListContainerElementId = 'record_list_container--' + attributeGroupName;
		}

		/*
		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm('htmlRecordCreationForm: ' + htmlRecordCreationForm);
			if (continueDebug != true) {
				return;
			}
		}
		*/

		if (errorNumber == 0) {

			// Append the returned HTML Record to the list
			if (performCreationFormAppendOperation == 'append') {
				// @todo Add prepend and insert sorted options
				//$("#" + recordListContainerElementId).append(htmlRecord);
				//$("#" + optionalReferenceElementId + " tr:last").after(htmlRecordCreationForm);
				$("#" + optionalReferenceElementId).after(htmlRecordCreationForm);
				$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
				$(".bs-tooltip").tooltip();
			}

			/*
			// Dom Swap
			if (performDomSwapOperation == 'Y') {
				// Iterate over the record container and each child element and change the element id and add an onchange handler
				// 1) Modify the HTML Record Container itself to have the updated id value
				$("#" + recordContainerElementIdOld).attr('id', recordContainerElementId);

				// 2) Modify each child element to have an updated element id and an onchange handler
				// var onchangeHandler = 'onchange="updateActionItem(this, { responseDataType : \'json\' });"';
				var onchangeHandler = 'onchange="' + onchangeHandlerFunction + '(this, { responseDataType : \'json\' });"';
				var arrChildren = $("#" + recordContainerElementId).children();
				$.each(arrChildren,
					function() {
						var tmpId = $(this).attr('id');
						var index = tmpId.indexOf(previousAttributeGroupName);
						if (index == 0) {
							// find/replace the id with the updated attributeGroupName
							// E.g. "create-project-record" to "manage-project-record"
							newId = tmpId.replace(previousAttributeGroupName, attributeGroupName);
							$(this).attr('id', newId);
							$(this).change(onchangeHandler);
						}
					}
				);
			}

			// Replace old HTML placeholder with the returned HTML Record
			if (performReplaceOperation == 'Y') {
				$("#" + recordContainerElementIdOld).replaceWith(htmlRecord);
			}

			// Append the returned HTML Record to the list
			if (performAppendOperation != '') {
				// @todo Add prepend and insert sorted options
				$("#" + recordListContainerElementId).append(htmlRecord);
			}

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm('performAppendOperation: ' + performAppendOperation + ' optionalReferenceElementId: ' + optionalReferenceElementId);
				if (continueDebug != true) {
					return;
				}
			}

			// User Messaging
			// Only skip all messaging for displayUserMessages == "N"
			// If the variable is not explicitly set/present and "N" in value, then display messages
			if (!displayUserMessages || (displayUserMessages == 'Y')) {
				if (responseDataType == 'application/json') {
					libCodeGen_userMessaging(json, 'renderCreationForm');
				}
			}

			// @todo Add all refresh operations here...
			if (performRefreshOperation && (performRefreshOperation == 'Y')) {
				if (refreshOperationType = 'full_screen_refresh') {
					window.location.reload(true);
				}
				if (refreshOperationType = 'dom_element_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + refreshOperationContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_list_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordListContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'html_record_refresh') {
					if (refreshOperationContainerElementId) {
						$("#" + recordContainerElementId).load(refreshOperationUrl);
					}
				}
				if (refreshOperationType = 'callback_handler_refresh') {
					// @todo...???
				}
			}
			*/

			//window.location.reload(true);
		} else {
			messageAlert(data, 'errorMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function libCodeGen_performAppendOperation(performAppendOperation, recordListContainerElement, htmlRecord, json)
{
	try {

		if (performAppendOperation == 'append') {
			// @todo Add prepend and insert sorted options
			$(recordListContainerElement).append(htmlRecord);

			return true;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return false;
		}

	}
}

function libCodeGen_userMessaging(json, crudOperation)
{
	try {

		// Existing HTML Record Formatted Attribute Group Name
		var formattedAttributeGroupName = json.formattedAttributeGroupName; // E.g. "Project"

		// Existing HTML Record Formatted Attribute Subgroup Name
		var formattedAttributeSubgroupName = json.formattedAttributeSubgroupName; // E.g. "Projects"

		// Existing HTML Record Formatted Attribute Name
		var formattedAttributeName = json.formattedAttributeName; // E.g. "Project Name"

		// Display any messages at all to the user
		var displayUserMessages = json.displayUserMessages; // "Y" or "N" - Default is "Y" if not present

		// Custom Success Message
		var displayCustomSuccessMessage = json.displayCustomSuccessMessage; // "Y" or "N"
		var customSuccessMessage = json.customSuccessMessage; // Override auto-created success message

		// Custom Additional User Message
		var displayAdditionalCustomUserMessage = json.displayAdditionalCustomUserMessage; // "Y" or "N"
		var additionalCustomUserMessageType = json.additionalCustomUserMessageType; // "error" or "success" or "information"
		var additionalCustomUserMessage = json.additionalCustomUserMessage; // "" or "Additional message here..."

		// Note: Errors can be trapped in PHP and an HTTP 200 response header is output so errors are potentially included here...
		// Custom Error Message
		var displayCustomErrorMessage = json.displayCustomErrorMessage; // "Y" or "N"
		var customErrorMessage = json.customErrorMessage; // Override auto-created error message

		// User Messaging
		// Only skip all messaging for displayUserMessages == "N"
		// If the variable is not explicitly set/present and "N" in value, then display messages
		if (!displayUserMessages || (displayUserMessages == 'Y')) {
			var messageText = '';

			if (crudOperation == 'create') {
				var messageAction = 'created';
			} else if ((crudOperation == 'update') || (crudOperation == 'updateAll')) {
				var messageAction = 'updated';
			} else if (crudOperation == 'delete') {
				var messageAction = 'deleted';
			} else {
				var messageAction = 'performed';
			}

			// Success Messaging
			if (customSuccessMessage && displayCustomSuccessMessage && (displayCustomErrorMessage == 'Y')) {
				messageText = customSuccessMessage;
			} else {

				if (crudOperation == 'create') {
					if (formattedAttributeGroupName != '') {
						messageText = messageText + ' ' + formattedAttributeGroupName;
					} else if (formattedAttributeSubgroupName != '') {
						messageText = messageText + ' ' + formattedAttributeSubgroupName;
					}

					messageText = messageText + ' successfully created.';
				}

				if (crudOperation == 'save') {
					if (formattedAttributeGroupName != '') {
						messageText = messageText + ' ' + formattedAttributeGroupName;
					} else if (formattedAttributeSubgroupName != '') {
						messageText = messageText + ' ' + formattedAttributeSubgroupName;
					}

					messageText = messageText + ' successfully saved.';
				}

				if ((crudOperation == 'update') || (crudOperation == 'updateAll')) {
					// updated
					if ((typeof formattedAttributeSubgroupName != 'undefined') && (formattedAttributeSubgroupName != '')) {
						messageText = formattedAttributeGroupName;
						var includeHyphen = true;
					} else {
						var includeHyphen = false;
					}

					if ((typeof formattedAttributeName != 'undefined') && (formattedAttributeName != '')) {
						if (includeHyphen) {
							messageText = messageText + ' - ';
						}

						messageText = messageText + formattedAttributeName;
					}

					messageText = messageText + ' successfully updated.';
				}

				if (crudOperation == 'delete') {
					// deleted
					if (formattedAttributeGroupName != '') {
						messageText = messageText + ' ' + formattedAttributeGroupName;
					} else if (formattedAttributeSubgroupName != '') {
						messageText = messageText + ' ' + formattedAttributeSubgroupName;
					}

					messageText = messageText + ' successfully deleted.';
				}

			}

			if (additionalCustomUserMessage && displayAdditionalCustomUserMessage && (displayAdditionalCustomUserMessage == 'Y') && (additionalCustomUserMessageType == 'success')) {
				messageText = messageText + ' ' + additionalCustomUserMessage;
			}

			messageText = $.trim(messageText);

			if (messageText != '') {
				messageAlert(messageText, 'successMessage');
			}

			// Error Messaging
			if (errorMessage) {
				errorMessageText = errorMessage;
			} else {
				errorMessageText = '';
			}

			if (displayCustomErrorMessage && (displayCustomErrorMessage == 'Y')) {
				errorMessageText = displayCustomErrorMessage;
			}

			if (additionalCustomUserMessage && displayAdditionalCustomUserMessage && (displayAdditionalCustomUserMessage == 'Y') && (additionalCustomUserMessageType == 'error')) {
				errorMessageText = errorMessageText + ' ' + additionalCustomUserMessage;
			}

			errorMessageText = $.trim(errorMessageText);

			if (errorMessageText != '') {
				messageAlert(errorMessageText, 'errorMessage');
			}
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function convertStringToObject(value){

	var string = value.replace(/&/g, '", "'); 
	var stringReplace = string.replace(/=/g, '":"'); 
	var sringFirstDelete = stringReplace.substr(2);
	var ojectReplace = "{ "+sringFirstDelete+'"'+"}";
	var obj = JSON.parse(ojectReplace);
	return obj;

}

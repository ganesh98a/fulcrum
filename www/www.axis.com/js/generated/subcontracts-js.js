
/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function createSubcontract(attributeGroupName, uniqueId, options)
{
	// Debug
	//return;

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		var valid = validateForm(attributeGroupName, uniqueId);
		if (!valid) {
			if (promiseChain) {
				var promise = getDummyRejectedPromise();
				return promise;
			} else {
				return;
			}
		}

		window.savePending = true;

		// create case attribute group - E.g. "create-project-record"
		attributeGroupName = $.trim(attributeGroupName);
		// Dummy ID placeholder (instead of a candidate key) - E.g. "dummy_id-5492a6d72da39"
		uniqueId = $.trim(uniqueId);

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Subcontract';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Subcontracts';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-subcontract-record';
			htmlRecordMetaAttributesOptions.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributesOptions.uniqueId = uniqueId;
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('create', htmlRecordMetaAttributesOptions);
		}

		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;
		var newAttributeGroupName			= htmlRecordMetaAttributes.newAttributeGroupName;

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'N';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'subcontracts-ajax.php?method=createSubcontract';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newAttributeGroupName=' + encodeURIComponent(newAttributeGroupName) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName);

		if (!optionsObjectIsEmpty && options.skipBuildHtmlRecordAttributesAsAjaxQueryString) {
			var htmlRecordAttributesAsAjaxQueryString = '';
		} else {
			if (!optionsObjectIsEmpty && options.htmlRecordAttributeOptions) {
				htmlRecordAttributeOptions = options.htmlRecordAttributeOptions;
			} else {
				htmlRecordAttributeOptions = { };
			}
			var htmlRecordAttributesAsAjaxQueryString = buildSubcontractHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
			var ajaxQueryString = ajaxQueryString + htmlRecordAttributesAsAjaxQueryString;
		}

		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options) {
				// property exists
				// conditionally skip the default success callback function
				var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
			} else {
				var skipDefaultSuccessCallback = false;
			}
			// options is an object containing values so form a query string of the key/value pairs
			var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
			ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// Optional $.ajax callbacks may be passed in via the options object
		if (skipDefaultSuccessCallback) {
			var arrSuccessCallbacks = [ ];
		} else {
			var arrSuccessCallbacks = [ defaultAjaxCallback_createSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadSubcontract(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	// Debug
	//return;

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		recordContainerElementId = $.trim(recordContainerElementId);
		attributeGroupName = $.trim(attributeGroupName);
		uniqueId = $.trim(uniqueId);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'subcontracts-ajax.php?method=loadSubcontract';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		var subcontract_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_id--' + uniqueId;
		if ($("#" + subcontract_id_element_id).length) {
			var subcontract_id = $("#" + subcontract_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&subcontract_id=' + encodeURIComponent(subcontract_id);
		}

		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options) {
				// property exists
				// conditionally skip the default success callback function
				var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
			} else {
				var skipDefaultSuccessCallback = false;
			}
			// options is an object containing values so form a query string of the key/value pairs
			var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
			ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		//$("#" + recordContainerElementId).load(ajaxUrl);

		// Optional $.ajax callbacks may be passed in via the options object
		if (skipDefaultSuccessCallback) {
			var arrSuccessCallbacks = [ ];
		} else {
			var arrSuccessCallbacks = [ defaultAjaxCallback_loadSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadAllSubcontractRecords(recordListContainerElementId, attributeGroupName, options)
{
	// Debug
	//return;

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		recordListContainerElementId = $.trim(recordListContainerElementId);
		attributeGroupName = $.trim(attributeGroupName);

		var offset = options.offset;
		var limit = options.limit;
		var filterBy = options.filterBy;
		var orderBy = options.orderBy;

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'subcontracts-ajax.php?method=loadAllSubcontractRecords';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'recordListContainerElementId=' + encodeURIComponent(recordListContainerElementId) +
			'&attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options) {
				// property exists
				// conditionally skip the default success callback function
				var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
			} else {
				var skipDefaultSuccessCallback = false;
			}
			// options is an object containing values so form a query string of the key/value pairs
			var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
			ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		//$("#" + recordListContainerElementId).load(ajaxUrl);

		// Optional $.ajax callbacks may be passed in via the options object
		if (skipDefaultSuccessCallback) {
			var arrSuccessCallbacks = [ ];
		} else {
			var arrSuccessCallbacks = [ defaultAjaxCallback_loadAllRecordsSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 * element is the HTML ELement itself passed in ("this")
 * options is an object with a collection of optional directives
 */
function updateSubcontract(element, options)
{
	// Debug
	//return;

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.element									= element;
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Subcontract';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Subcontracts';
			htmlRecordMetaAttributesOptions.formattedAttributeName					= '';
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('update', htmlRecordMetaAttributesOptions);
		}

		var attributeGroupName 				= htmlRecordMetaAttributes.attributeGroupName;
		var attributeName 					= htmlRecordMetaAttributes.attributeName;
		var uniqueId 						= htmlRecordMetaAttributes.uniqueId;
		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;
		var formattedAttributeName			= htmlRecordMetaAttributes.formattedAttributeName;
		var newValueText					= htmlRecordMetaAttributes.newValueText;

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else if (htmlRecordMetaAttributes.attributeSubgroupName) {
			var attributeSubgroupName 		= htmlRecordMetaAttributes.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		var inputDataFiltered = false;
		if (!optionsObjectIsEmpty && options.newValue) {

			// Assume final input
			var newValue = options.newValue;
			inputDataFiltered = true;

		} else if (!optionsObjectIsEmpty && options.endIndex && (attributeName == 'sort_order')) {

			// sort_order case
			newValue = options.endIndex;
			inputDataFiltered = true;

		} else if ((typeof element !== 'undefined') && $(element).is(':checkbox')) {

			// Checkbox input element
			// Test for application-specific standardized cases
			var index = attributeName.indexOf('_flag');
			if (index > -1) {
				var newValue = 'N';
				if ($(element).is(':checked')) {
					newValue = 'Y';
				}
				inputDataFiltered = true;
			} else {

				// Get the value of the element that was updated.
				var tmpValue = $(element).val();

			}

		} else  {

			// Get the value of the element that was updated.
			var tmpValue = $(element).val();

		}

		if (!inputDataFiltered) {
			var objReturn = filterSubcontractHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
			var inputDataFiltered = objReturn.inputDataFiltered;
			var newValue = objReturn.newValue;

			if (!inputDataFiltered) {
				var objReturn = parseInputToTemporalDataTypeByAttributeName(attributeName, tmpValue);
				var inputDataFiltered = objReturn.inputDataFiltered;
				var newValue = objReturn.newValue;
			}
		}

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'N';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'subcontracts-ajax.php?method=updateSubcontract';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&attributeName=' + encodeURIComponent(attributeName) +
			'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(newValue) +
			'&newValueText=' + encodeURIComponent(newValueText) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName) +
			'&formattedAttributeName=' + encodeURIComponent(formattedAttributeName);

		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options) {
				// property exists
				// conditionally skip the default success callback function
				var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
			} else {
				var skipDefaultSuccessCallback = false;
			}
			// options is an object containing values so form a query string of the key/value pairs
			var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
			ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// Optional $.ajax callbacks may be passed in via the options object
		if (skipDefaultSuccessCallback) {
			var arrSuccessCallbacks = [ ];
		} else {
			var arrSuccessCallbacks = [ defaultAjaxCallback_updateSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
			error: errorHandler
		});

		// if (promiseChain) {
			return returnedJqXHR;
		// }

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a pk/uk to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function updateAllSubcontractAttributes(attributeGroupName, uniqueId, options)
{
	// Debug
	//return;

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		var valid = validateForm(attributeGroupName, uniqueId);
		if (!valid) {
			if (promiseChain) {
				var promise = getDummyRejectedPromise();
				return promise;
			} else {
				return;
			}
		}

		window.savePending = true;

		attributeGroupName = $.trim(attributeGroupName);
		uniqueId = $.trim(uniqueId);

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		// HTML Element id Format: id="attributeGroupName--attributeSubgroupName--attributeName--uniqueId"
		//var arrParts = recordContainerElementId.split('--');
		//var attributeGroupName = arrParts[1];
		var attributeSubgroupName = 'subcontracts';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Subcontract';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Subcontracts';
			htmlRecordMetaAttributesOptions.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributesOptions.uniqueId = uniqueId;
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('updateAll', htmlRecordMetaAttributesOptions);
		}

		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'N';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'subcontracts-ajax.php?method=updateAllSubcontractAttributes';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName);

		if (!optionsObjectIsEmpty && options.skipBuildHtmlRecordAttributesAsAjaxQueryString) {
			var htmlRecordAttributesAsAjaxQueryString = '';
		} else {
			if (!optionsObjectIsEmpty && options.htmlRecordAttributeOptions) {
				htmlRecordAttributeOptions = options.htmlRecordAttributeOptions;
			} else {
				htmlRecordAttributeOptions = { };
			}
			var htmlRecordAttributesAsAjaxQueryString = buildSubcontractHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
			var ajaxQueryString = ajaxQueryString + htmlRecordAttributesAsAjaxQueryString;
		}

		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options) {
				// property exists
				// conditionally skip the default success callback function
				var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
			} else {
				var skipDefaultSuccessCallback = false;
			}
			// options is an object containing values so form a query string of the key/value pairs
			var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
			ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// Optional $.ajax callbacks may be passed in via the options object
		if (skipDefaultSuccessCallback) {
			var arrSuccessCallbacks = [ ];
		} else {
			var arrSuccessCallbacks = [ defaultAjaxCallback_updateAllAttributesSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 * recordContainerElementId is the complete DOM element id of the HTML Record being deleted
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a primary or candidate key to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function deleteSubcontract(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	// Debug
	//return;

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		var confirmDelete = options.confirmation;
		if (confirmDelete) {
			var confirmDeleteAnswer = window.confirm('Are You Sure That You Want To Delete This Subcontract?');
			if (confirmDeleteAnswer != true) {
				if (promiseChain) {
					var promise = getDummyRejectedPromise();
					return promise;
				} else {
					return;
				}
			}

		}

		window.savePending = true;

		// HTML Record container element id
		recordContainerElementId = $.trim(recordContainerElementId);
		// delete case attribute group - E.g. "manage-project-record"
		attributeGroupName = $.trim(attributeGroupName);
		// Primary or candidate key - E.g. "1234"
		uniqueId = $.trim(uniqueId);

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--uniqueId"
		//var arrParts = recordContainerElementId.split('--');
		//var attributeGroupName = arrParts[1];
		var attributeSubgroupName = 'subcontracts';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Subcontract';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Subcontracts';
			htmlRecordMetaAttributesOptions.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributesOptions.uniqueId = uniqueId;
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('delete', htmlRecordMetaAttributesOptions);
		}

		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'N';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'subcontracts-ajax.php?method=deleteSubcontract';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'recordContainerElementId=' + encodeURIComponent(recordContainerElementId) +
			'&attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName);

		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options) {
				// property exists
				// conditionally skip the default success callback function
				var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
			} else {
				var skipDefaultSuccessCallback = false;
			}
			// options is an object containing values so form a query string of the key/value pairs
			var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
			ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		// Debug
		//$("#" + recordContainerElementId).remove();
		//return;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// Optional $.ajax callbacks may be passed in via the options object
		if (skipDefaultSuccessCallback) {
			var arrSuccessCallbacks = [ ];
		} else {
			var arrSuccessCallbacks = [ defaultAjaxCallback_deleteSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function saveSubcontract(attributeGroupName, uniqueId, options)
{
	// Debug
	//return;

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.promiseChain) {
			var promiseChain = options.promiseChain;
		} else {
			var promiseChain = false;
		}

		var valid = validateForm(attributeGroupName, uniqueId);
		if (!valid) {
			if (promiseChain) {
				var promise = getDummyRejectedPromise();
				return promise;
			} else {
				return;
			}
		}

		window.savePending = true;

		// create case attribute group - E.g. "create-project-record"
		attributeGroupName = $.trim(attributeGroupName);
		// Dummy ID placeholder (instead of a candidate key) - E.g. "dummy_id-5492a6d72da39"
		uniqueId = $.trim(uniqueId);

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Subcontract';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Subcontracts';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-subcontract-record';
			htmlRecordMetaAttributesOptions.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributesOptions.uniqueId = uniqueId;
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('save', htmlRecordMetaAttributesOptions);
		}

		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;
		var newAttributeGroupName			= htmlRecordMetaAttributes.newAttributeGroupName;

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'N';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'subcontracts-ajax.php?method=saveSubcontract';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newAttributeGroupName=' + encodeURIComponent(newAttributeGroupName) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName);

		if (!optionsObjectIsEmpty && options.skipBuildHtmlRecordAttributesAsAjaxQueryString) {
			var htmlRecordAttributesAsAjaxQueryString = '';
		} else {
			if (!optionsObjectIsEmpty && options.htmlRecordAttributeOptions) {
				htmlRecordAttributeOptions = options.htmlRecordAttributeOptions;
			} else {
				htmlRecordAttributeOptions = { };
			}
			var htmlRecordAttributesAsAjaxQueryString = buildSubcontractHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
			var ajaxQueryString = ajaxQueryString + htmlRecordAttributesAsAjaxQueryString;
		}

		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options) {
				// property exists
				// conditionally skip the default success callback function
				var skipDefaultSuccessCallback = options.skipDefaultSuccessCallback;
			} else {
				var skipDefaultSuccessCallback = false;
			}
			// options is an object containing values so form a query string of the key/value pairs
			var ajaxQueryStringFromOptions = generateAjaxQueryStringFromOptions(options);
			ajaxQueryString = ajaxQueryString + ajaxQueryStringFromOptions;
		}

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// Optional $.ajax callbacks may be passed in via the options object
		if (skipDefaultSuccessCallback) {
			var arrSuccessCallbacks = [ ];
		} else {
			var arrSuccessCallbacks = [ defaultAjaxCallback_saveSuccess ];
		}
		if (!optionsObjectIsEmpty && options.successCallback) {
			var successCallback = options.successCallback;
			if (typeof successCallback == 'function') {
				arrSuccessCallbacks.push(successCallback);
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function buildSubcontractHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'subcontracts';
		}

		ajaxQueryString = '';

		if (!optionsObjectIsEmpty && options.includeId) {
			var subcontract_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_id--' + uniqueId;
			if ($("#" + subcontract_id_element_id).length) {
				var subcontract_id = $("#" + subcontract_id_element_id).val();
				if (!optionsObjectIsEmpty && options.filterId) {
					subcontract_id = parseInputToMySQLUnsignedInt(subcontract_id);
				}
				ajaxQueryString = ajaxQueryString + '&subcontract_id=' + encodeURIComponent(subcontract_id);
			}
		}

		var gc_budget_line_item_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--gc_budget_line_item_id--' + uniqueId;
		if ($("#" + gc_budget_line_item_id_element_id).length) {
			var gc_budget_line_item_id = $("#" + gc_budget_line_item_id_element_id).val();
			gc_budget_line_item_id = parseInputToInt(gc_budget_line_item_id);
			ajaxQueryString = ajaxQueryString + '&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id);
		}

		var subcontract_sequence_number_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_sequence_number--' + uniqueId;
		if ($("#" + subcontract_sequence_number_element_id).length) {
			var subcontract_sequence_number = $("#" + subcontract_sequence_number_element_id).val();
			subcontract_sequence_number = parseInputToInt(subcontract_sequence_number);
			ajaxQueryString = ajaxQueryString + '&subcontract_sequence_number=' + encodeURIComponent(subcontract_sequence_number);
		}
		var subcontractor_bid_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontractor_bid_id--' + uniqueId;
		if ($("#" + subcontractor_bid_id_element_id).length) {
			var subcontractor_bid_id = $("#" + subcontractor_bid_id_element_id).val();
			subcontractor_bid_id = parseInputToInt(subcontractor_bid_id);
			ajaxQueryString = ajaxQueryString + '&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id);
		}

		var subcontract_template_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_template_id--' + uniqueId;
		if ($("#" + subcontract_template_id_element_id).length) {
			var subcontract_template_id = $("#" + subcontract_template_id_element_id).val();
			subcontract_template_id = parseInputToInt(subcontract_template_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_template_id=' + encodeURIComponent(subcontract_template_id);
		}

		var subcontract_gc_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_gc_contact_company_office_id--' + uniqueId;
		if ($("#" + subcontract_gc_contact_company_office_id_element_id).length) {
			var subcontract_gc_contact_company_office_id = $("#" + subcontract_gc_contact_company_office_id_element_id).val();
			subcontract_gc_contact_company_office_id = parseInputToInt(subcontract_gc_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_gc_contact_company_office_id=' + encodeURIComponent(subcontract_gc_contact_company_office_id);
		}

		var subcontract_gc_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_gc_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + subcontract_gc_phone_contact_company_office_phone_number_id_element_id).length) {
			var subcontract_gc_phone_contact_company_office_phone_number_id = $("#" + subcontract_gc_phone_contact_company_office_phone_number_id_element_id).val();
			subcontract_gc_phone_contact_company_office_phone_number_id = parseInputToInt(subcontract_gc_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_gc_phone_contact_company_office_phone_number_id=' + encodeURIComponent(subcontract_gc_phone_contact_company_office_phone_number_id);
		}

		var subcontract_gc_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_gc_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + subcontract_gc_fax_contact_company_office_phone_number_id_element_id).length) {
			var subcontract_gc_fax_contact_company_office_phone_number_id = $("#" + subcontract_gc_fax_contact_company_office_phone_number_id_element_id).val();
			subcontract_gc_fax_contact_company_office_phone_number_id = parseInputToInt(subcontract_gc_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_gc_fax_contact_company_office_phone_number_id=' + encodeURIComponent(subcontract_gc_fax_contact_company_office_phone_number_id);
		}

		var subcontract_gc_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_gc_contact_id--' + uniqueId;
		if ($("#" + subcontract_gc_contact_id_element_id).length) {
			var subcontract_gc_contact_id = $("#" + subcontract_gc_contact_id_element_id).val();
			subcontract_gc_contact_id = parseInputToInt(subcontract_gc_contact_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_gc_contact_id=' + encodeURIComponent(subcontract_gc_contact_id);
		}

		var subcontract_gc_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_gc_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + subcontract_gc_contact_mobile_phone_number_id_element_id).length) {
			var subcontract_gc_contact_mobile_phone_number_id = $("#" + subcontract_gc_contact_mobile_phone_number_id_element_id).val();
			subcontract_gc_contact_mobile_phone_number_id = parseInputToInt(subcontract_gc_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_gc_contact_mobile_phone_number_id=' + encodeURIComponent(subcontract_gc_contact_mobile_phone_number_id);
		}

		var vendor_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--vendor_id--' + uniqueId;
		if ($("#" + vendor_id_element_id).length) {
			var vendor_id = $("#" + vendor_id_element_id).val();
			vendor_id = parseInputToInt(vendor_id);
			ajaxQueryString = ajaxQueryString + '&vendor_id=' + encodeURIComponent(vendor_id);
		}

		var subcontract_vendor_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_vendor_contact_company_office_id--' + uniqueId;
		if ($("#" + subcontract_vendor_contact_company_office_id_element_id).length) {
			var subcontract_vendor_contact_company_office_id = $("#" + subcontract_vendor_contact_company_office_id_element_id).val();
			subcontract_vendor_contact_company_office_id = parseInputToInt(subcontract_vendor_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_vendor_contact_company_office_id=' + encodeURIComponent(subcontract_vendor_contact_company_office_id);
		}

		var subcontract_vendor_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_vendor_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + subcontract_vendor_phone_contact_company_office_phone_number_id_element_id).length) {
			var subcontract_vendor_phone_contact_company_office_phone_number_id = $("#" + subcontract_vendor_phone_contact_company_office_phone_number_id_element_id).val();
			subcontract_vendor_phone_contact_company_office_phone_number_id = parseInputToInt(subcontract_vendor_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_vendor_phone_contact_company_office_phone_number_id=' + encodeURIComponent(subcontract_vendor_phone_contact_company_office_phone_number_id);
		}

		var subcontract_vendor_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_vendor_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + subcontract_vendor_fax_contact_company_office_phone_number_id_element_id).length) {
			var subcontract_vendor_fax_contact_company_office_phone_number_id = $("#" + subcontract_vendor_fax_contact_company_office_phone_number_id_element_id).val();
			subcontract_vendor_fax_contact_company_office_phone_number_id = parseInputToInt(subcontract_vendor_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_vendor_fax_contact_company_office_phone_number_id=' + encodeURIComponent(subcontract_vendor_fax_contact_company_office_phone_number_id);
		}

		var subcontract_vendor_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_vendor_contact_id--' + uniqueId;
		if ($("#" + subcontract_vendor_contact_id_element_id).length) {
			var subcontract_vendor_contact_id = $("#" + subcontract_vendor_contact_id_element_id).val();
			subcontract_vendor_contact_id = parseInputToInt(subcontract_vendor_contact_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_vendor_contact_id=' + encodeURIComponent(subcontract_vendor_contact_id);
		}

		var subcontract_vendor_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_vendor_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + subcontract_vendor_contact_mobile_phone_number_id_element_id).length) {
			var subcontract_vendor_contact_mobile_phone_number_id = $("#" + subcontract_vendor_contact_mobile_phone_number_id_element_id).val();
			subcontract_vendor_contact_mobile_phone_number_id = parseInputToInt(subcontract_vendor_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_vendor_contact_mobile_phone_number_id=' + encodeURIComponent(subcontract_vendor_contact_mobile_phone_number_id);
		}

		var unsigned_subcontract_file_manager_file_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--unsigned_subcontract_file_manager_file_id--' + uniqueId;
		if ($("#" + unsigned_subcontract_file_manager_file_id_element_id).length) {
			var unsigned_subcontract_file_manager_file_id = $("#" + unsigned_subcontract_file_manager_file_id_element_id).val();
			unsigned_subcontract_file_manager_file_id = parseInputToInt(unsigned_subcontract_file_manager_file_id);
			ajaxQueryString = ajaxQueryString + '&unsigned_subcontract_file_manager_file_id=' + encodeURIComponent(unsigned_subcontract_file_manager_file_id);
		}

		var signed_subcontract_file_manager_file_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--signed_subcontract_file_manager_file_id--' + uniqueId;
		if ($("#" + signed_subcontract_file_manager_file_id_element_id).length) {
			var signed_subcontract_file_manager_file_id = $("#" + signed_subcontract_file_manager_file_id_element_id).val();
			signed_subcontract_file_manager_file_id = parseInputToInt(signed_subcontract_file_manager_file_id);
			ajaxQueryString = ajaxQueryString + '&signed_subcontract_file_manager_file_id=' + encodeURIComponent(signed_subcontract_file_manager_file_id);
		}

		var subcontract_forecasted_value_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_forecasted_value--' + uniqueId;
		if ($("#" + subcontract_forecasted_value_element_id).length) {
			var subcontract_forecasted_value = $("#" + subcontract_forecasted_value_element_id).val();
			subcontract_forecasted_value = parseInputToCurrency(subcontract_forecasted_value);
			ajaxQueryString = ajaxQueryString + '&subcontract_forecasted_value=' + encodeURIComponent(subcontract_forecasted_value);
		}
		var subcontract_actual_value_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_actual_value--' + uniqueId;
		if ($("#" + subcontract_actual_value_element_id).length) {
			var subcontract_actual_value = $("#" + subcontract_actual_value_element_id).val();
			subcontract_actual_value = parseInputToCurrency(subcontract_actual_value);
			ajaxQueryString = ajaxQueryString + '&subcontract_actual_value=' + encodeURIComponent(subcontract_actual_value);
		}
		var subcontract_retention_percentage_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_retention_percentage--' + uniqueId;
		if ($("#" + subcontract_retention_percentage_element_id).length) {
			var subcontract_retention_percentage = $("#" + subcontract_retention_percentage_element_id).val();
			subcontract_retention_percentage = parseInputToCurrency(subcontract_retention_percentage);
			ajaxQueryString = ajaxQueryString + '&subcontract_retention_percentage=' + encodeURIComponent(subcontract_retention_percentage);
		}
		var subcontract_issued_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_issued_date--' + uniqueId;
		if ($("#" + subcontract_issued_date_element_id).length) {
			var subcontract_issued_date = $("#" + subcontract_issued_date_element_id).val();
			subcontract_issued_date = convertDateToMySQLFormat(subcontract_issued_date);
			ajaxQueryString = ajaxQueryString + '&subcontract_issued_date=' + encodeURIComponent(subcontract_issued_date);
		}
		var subcontract_target_execution_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_target_execution_date--' + uniqueId;
		if ($("#" + subcontract_target_execution_date_element_id).length) {
			var subcontract_target_execution_date = $("#" + subcontract_target_execution_date_element_id).val();
			subcontract_target_execution_date = convertDateToMySQLFormat(subcontract_target_execution_date);
			ajaxQueryString = ajaxQueryString + '&subcontract_target_execution_date=' + encodeURIComponent(subcontract_target_execution_date);
		}
		var subcontract_execution_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_execution_date--' + uniqueId;
		if ($("#" + subcontract_execution_date_element_id).length) {
			var subcontract_execution_date = $("#" + subcontract_execution_date_element_id).val();
			subcontract_execution_date = convertDateToMySQLFormat(subcontract_execution_date);
			ajaxQueryString = ajaxQueryString + '&subcontract_execution_date=' + encodeURIComponent(subcontract_execution_date);
		}
		var active_flag_element_id = attributeGroupName + '--' + attributeSubgroupName + '--active_flag--' + uniqueId;
		if ($("#" + active_flag_element_id).length) {
			var active_flag = $("#" + active_flag_element_id).val();
			if ($("#" + active_flag_element_id).is(':checkbox')) {
				if ($("#" + active_flag_element_id).is(':checked')) {
					active_flag = 'Y';
				} else {
					active_flag = 'N';
				}
			}
			ajaxQueryString = ajaxQueryString + '&active_flag=' + encodeURIComponent(active_flag);
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

function filterSubcontractHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue)
{
	inputDataFiltered = false;

	switch (attributeName) {
		case 'subcontract_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'gc_budget_line_item_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_sequence_number':
			var newValue = parseInputToMySQLUnsignedSmallInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontractor_bid_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_template_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_gc_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_gc_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_gc_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_gc_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_gc_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'vendor_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_vendor_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_vendor_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_vendor_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_vendor_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_vendor_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'unsigned_subcontract_file_manager_file_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'signed_subcontract_file_manager_file_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_forecasted_value':
			var newValue = parseInputToCurrency(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_actual_value':
			var newValue = parseInputToCurrency(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_retention_percentage':
			var newValue = parseInputToCurrency(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_issued_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_target_execution_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_execution_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		default:
			var newValue = tmpValue;
	}

	var objReturn = { inputDataFiltered: inputDataFiltered, newValue: newValue };
	return objReturn;
}

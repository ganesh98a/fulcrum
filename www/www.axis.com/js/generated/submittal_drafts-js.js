
/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function createSubmittalDraft(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Draft';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Drafts';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-submittal_draft-record';
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
			var attributeSubgroupName = 'submittal_drafts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_drafts-ajax.php?method=createSubmittalDraft';
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
			var htmlRecordAttributesAsAjaxQueryString = buildSubmittalDraftHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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
			type: 'POST',
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

function loadSubmittalDraft(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var attributeSubgroupName = 'submittal_drafts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_drafts-ajax.php?method=loadSubmittalDraft';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		var submittal_draft_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_draft_id--' + uniqueId;
		if ($("#" + submittal_draft_id_element_id).length) {
			var submittal_draft_id = $("#" + submittal_draft_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&submittal_draft_id=' + encodeURIComponent(submittal_draft_id);
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
			type: 'POST',
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

function loadAllSubmittalDraftRecords(recordListContainerElementId, attributeGroupName, options)
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
			var attributeSubgroupName = 'submittal_drafts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_drafts-ajax.php?method=loadAllSubmittalDraftRecords';
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
			type: 'POST',
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
function updateSubmittalDraft(element, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Draft';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Drafts';
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
			var attributeSubgroupName = 'submittal_drafts';
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
			var objReturn = filterSubmittalDraftHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
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
			var ajaxHandlerScript = 'submittal_drafts-ajax.php?method=updateSubmittalDraft';
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
			type: 'POST',
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
 * uniqueId is a pk/uk to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function updateAllSubmittalDraftAttributes(attributeGroupName, uniqueId, options)
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
		var attributeSubgroupName = 'submittal_drafts';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Draft';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Drafts';
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
			var attributeSubgroupName = 'submittal_drafts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_drafts-ajax.php?method=updateAllSubmittalDraftAttributes';
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
			var htmlRecordAttributesAsAjaxQueryString = buildSubmittalDraftHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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
			type: 'POST',
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
function deleteSubmittalDraft(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var confirmDeleteAnswer = window.confirm('Are You Sure That You Want To Delete This Submittal Draft?');
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
		var attributeSubgroupName = 'submittal_drafts';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Draft';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Drafts';
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
			var attributeSubgroupName = 'submittal_drafts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_drafts-ajax.php?method=deleteSubmittalDraft';
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
			type: 'POST',
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
function saveSubmittalDraft(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Draft';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Drafts';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-submittal_draft-record';
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
			var attributeSubgroupName = 'submittal_drafts';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_drafts-ajax.php?method=saveSubmittalDraft';
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
			var htmlRecordAttributesAsAjaxQueryString = buildSubmittalDraftHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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
			type: 'POST',
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

function buildSubmittalDraftHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'submittal_drafts';
		}

		ajaxQueryString = '';

		if (!optionsObjectIsEmpty && options.includeId) {
			var submittal_draft_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_draft_id--' + uniqueId;
			if ($("#" + submittal_draft_id_element_id).length) {
				var submittal_draft_id = $("#" + submittal_draft_id_element_id).val();
				if (!optionsObjectIsEmpty && options.filterId) {
					submittal_draft_id = parseInputToMySQLUnsignedInt(submittal_draft_id);
				}
				ajaxQueryString = ajaxQueryString + '&submittal_draft_id=' + encodeURIComponent(submittal_draft_id);
			}
		}

		var project_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_id--' + uniqueId;
		if ($("#" + project_id_element_id).length) {
			var project_id = $("#" + project_id_element_id).val();
			project_id = parseInputToInt(project_id);
			ajaxQueryString = ajaxQueryString + '&project_id=' + encodeURIComponent(project_id);
		}

		var submittal_type_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_type_id--' + uniqueId;
		if ($("#" + submittal_type_id_element_id).length) {
			var submittal_type_id = $("#" + submittal_type_id_element_id).val();
			submittal_type_id = parseInputToInt(submittal_type_id);
			ajaxQueryString = ajaxQueryString + '&submittal_type_id=' + encodeURIComponent(submittal_type_id);
		}

		var submittal_priority_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_priority_id--' + uniqueId;
		if ($("#" + submittal_priority_id_element_id).length) {
			var submittal_priority_id = $("#" + submittal_priority_id_element_id).val();
			submittal_priority_id = parseInputToInt(submittal_priority_id);
			ajaxQueryString = ajaxQueryString + '&submittal_priority_id=' + encodeURIComponent(submittal_priority_id);
		}

		var submittal_distribution_method_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_distribution_method_id--' + uniqueId;
		if ($("#" + submittal_distribution_method_id_element_id).length) {
			var submittal_distribution_method_id = $("#" + submittal_distribution_method_id_element_id).val();
			submittal_distribution_method_id = parseInputToInt(submittal_distribution_method_id);
			ajaxQueryString = ajaxQueryString + '&submittal_distribution_method_id=' + encodeURIComponent(submittal_distribution_method_id);
		}

		var su_file_manager_file_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_file_manager_file_id--' + uniqueId;
		if ($("#" + su_file_manager_file_id_element_id).length) {
			var su_file_manager_file_id = $("#" + su_file_manager_file_id_element_id).val();
			su_file_manager_file_id = parseInputToInt(su_file_manager_file_id);
			ajaxQueryString = ajaxQueryString + '&su_file_manager_file_id=' + encodeURIComponent(su_file_manager_file_id);
		}

		var su_cost_code_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_cost_code_id--' + uniqueId;
		if ($("#" + su_cost_code_id_element_id).length) {
			var su_cost_code_id = $("#" + su_cost_code_id_element_id).val();
			su_cost_code_id = parseInputToInt(su_cost_code_id);
			ajaxQueryString = ajaxQueryString + '&su_cost_code_id=' + encodeURIComponent(su_cost_code_id);
		}

		var su_creator_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_creator_contact_id--' + uniqueId;
		if ($("#" + su_creator_contact_id_element_id).length) {
			var su_creator_contact_id = $("#" + su_creator_contact_id_element_id).val();
			su_creator_contact_id = parseInputToInt(su_creator_contact_id);
			ajaxQueryString = ajaxQueryString + '&su_creator_contact_id=' + encodeURIComponent(su_creator_contact_id);
		}

		var su_creator_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_creator_contact_company_office_id--' + uniqueId;
		if ($("#" + su_creator_contact_company_office_id_element_id).length) {
			var su_creator_contact_company_office_id = $("#" + su_creator_contact_company_office_id_element_id).val();
			su_creator_contact_company_office_id = parseInputToInt(su_creator_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&su_creator_contact_company_office_id=' + encodeURIComponent(su_creator_contact_company_office_id);
		}

		var su_creator_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_creator_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + su_creator_phone_contact_company_office_phone_number_id_element_id).length) {
			var su_creator_phone_contact_company_office_phone_number_id = $("#" + su_creator_phone_contact_company_office_phone_number_id_element_id).val();
			su_creator_phone_contact_company_office_phone_number_id = parseInputToInt(su_creator_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_creator_phone_contact_company_office_phone_number_id=' + encodeURIComponent(su_creator_phone_contact_company_office_phone_number_id);
		}

		var su_creator_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_creator_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + su_creator_fax_contact_company_office_phone_number_id_element_id).length) {
			var su_creator_fax_contact_company_office_phone_number_id = $("#" + su_creator_fax_contact_company_office_phone_number_id_element_id).val();
			su_creator_fax_contact_company_office_phone_number_id = parseInputToInt(su_creator_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_creator_fax_contact_company_office_phone_number_id=' + encodeURIComponent(su_creator_fax_contact_company_office_phone_number_id);
		}

		var su_creator_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_creator_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + su_creator_contact_mobile_phone_number_id_element_id).length) {
			var su_creator_contact_mobile_phone_number_id = $("#" + su_creator_contact_mobile_phone_number_id_element_id).val();
			su_creator_contact_mobile_phone_number_id = parseInputToInt(su_creator_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_creator_contact_mobile_phone_number_id=' + encodeURIComponent(su_creator_contact_mobile_phone_number_id);
		}

		var su_recipient_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_recipient_contact_id--' + uniqueId;
		if ($("#" + su_recipient_contact_id_element_id).length) {
			var su_recipient_contact_id = $("#" + su_recipient_contact_id_element_id).val();
			su_recipient_contact_id = parseInputToInt(su_recipient_contact_id);
			ajaxQueryString = ajaxQueryString + '&su_recipient_contact_id=' + encodeURIComponent(su_recipient_contact_id);
		}

		var su_recipient_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_recipient_contact_company_office_id--' + uniqueId;
		if ($("#" + su_recipient_contact_company_office_id_element_id).length) {
			var su_recipient_contact_company_office_id = $("#" + su_recipient_contact_company_office_id_element_id).val();
			su_recipient_contact_company_office_id = parseInputToInt(su_recipient_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&su_recipient_contact_company_office_id=' + encodeURIComponent(su_recipient_contact_company_office_id);
		}

		var su_recipient_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_recipient_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + su_recipient_phone_contact_company_office_phone_number_id_element_id).length) {
			var su_recipient_phone_contact_company_office_phone_number_id = $("#" + su_recipient_phone_contact_company_office_phone_number_id_element_id).val();
			su_recipient_phone_contact_company_office_phone_number_id = parseInputToInt(su_recipient_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_recipient_phone_contact_company_office_phone_number_id=' + encodeURIComponent(su_recipient_phone_contact_company_office_phone_number_id);
		}

		var su_recipient_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_recipient_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + su_recipient_fax_contact_company_office_phone_number_id_element_id).length) {
			var su_recipient_fax_contact_company_office_phone_number_id = $("#" + su_recipient_fax_contact_company_office_phone_number_id_element_id).val();
			su_recipient_fax_contact_company_office_phone_number_id = parseInputToInt(su_recipient_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_recipient_fax_contact_company_office_phone_number_id=' + encodeURIComponent(su_recipient_fax_contact_company_office_phone_number_id);
		}

		var su_recipient_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_recipient_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + su_recipient_contact_mobile_phone_number_id_element_id).length) {
			var su_recipient_contact_mobile_phone_number_id = $("#" + su_recipient_contact_mobile_phone_number_id_element_id).val();
			su_recipient_contact_mobile_phone_number_id = parseInputToInt(su_recipient_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_recipient_contact_mobile_phone_number_id=' + encodeURIComponent(su_recipient_contact_mobile_phone_number_id);
		}

		var su_initiator_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_initiator_contact_id--' + uniqueId;
		if ($("#" + su_initiator_contact_id_element_id).length) {
			var su_initiator_contact_id = $("#" + su_initiator_contact_id_element_id).val();
			su_initiator_contact_id = parseInputToInt(su_initiator_contact_id);
			ajaxQueryString = ajaxQueryString + '&su_initiator_contact_id=' + encodeURIComponent(su_initiator_contact_id);
		}

		var su_initiator_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_initiator_contact_company_office_id--' + uniqueId;
		if ($("#" + su_initiator_contact_company_office_id_element_id).length) {
			var su_initiator_contact_company_office_id = $("#" + su_initiator_contact_company_office_id_element_id).val();
			su_initiator_contact_company_office_id = parseInputToInt(su_initiator_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&su_initiator_contact_company_office_id=' + encodeURIComponent(su_initiator_contact_company_office_id);
		}

		var su_initiator_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_initiator_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + su_initiator_phone_contact_company_office_phone_number_id_element_id).length) {
			var su_initiator_phone_contact_company_office_phone_number_id = $("#" + su_initiator_phone_contact_company_office_phone_number_id_element_id).val();
			su_initiator_phone_contact_company_office_phone_number_id = parseInputToInt(su_initiator_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_initiator_phone_contact_company_office_phone_number_id=' + encodeURIComponent(su_initiator_phone_contact_company_office_phone_number_id);
		}

		var su_initiator_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_initiator_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + su_initiator_fax_contact_company_office_phone_number_id_element_id).length) {
			var su_initiator_fax_contact_company_office_phone_number_id = $("#" + su_initiator_fax_contact_company_office_phone_number_id_element_id).val();
			su_initiator_fax_contact_company_office_phone_number_id = parseInputToInt(su_initiator_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_initiator_fax_contact_company_office_phone_number_id=' + encodeURIComponent(su_initiator_fax_contact_company_office_phone_number_id);
		}

		var su_initiator_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_initiator_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + su_initiator_contact_mobile_phone_number_id_element_id).length) {
			var su_initiator_contact_mobile_phone_number_id = $("#" + su_initiator_contact_mobile_phone_number_id_element_id).val();
			su_initiator_contact_mobile_phone_number_id = parseInputToInt(su_initiator_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&su_initiator_contact_mobile_phone_number_id=' + encodeURIComponent(su_initiator_contact_mobile_phone_number_id);
		}

		var su_title_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_title--' + uniqueId;
		if ($("#" + su_title_element_id).length) {
			var su_title = $("#" + su_title_element_id).val();
			ajaxQueryString = ajaxQueryString + '&su_title=' + encodeURIComponent(su_title);
		}
		var su_su_spec_no_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_spec_no--' + uniqueId;
		if ($("#" + su_su_spec_no_element_id).length) {
			var su_spec_no = $("#" + su_su_spec_no_element_id).val();
			ajaxQueryString = ajaxQueryString + '&su_spec_no=' + encodeURIComponent(su_spec_no);
		}
		var su_plan_page_reference_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_plan_page_reference--' + uniqueId;
		if ($("#" + su_plan_page_reference_element_id).length) {
			var su_plan_page_reference = $("#" + su_plan_page_reference_element_id).val();
			ajaxQueryString = ajaxQueryString + '&su_plan_page_reference=' + encodeURIComponent(su_plan_page_reference);
		}
		var su_statement_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_statement--' + uniqueId;
		if ($("#" + su_statement_element_id).length) {
			var su_statement = $("#" + su_statement_element_id).val();
			ajaxQueryString = ajaxQueryString + '&su_statement=' + encodeURIComponent(su_statement);
		}
		var su_due_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--su_due_date--' + uniqueId;
		if ($("#" + su_due_date_element_id).length) {
			var su_due_date = $("#" + su_due_date_element_id).val();
			su_due_date = convertDateToMySQLFormat(su_due_date);
			ajaxQueryString = ajaxQueryString + '&su_due_date=' + encodeURIComponent(su_due_date);
		}

		// Cc recipients.
		// var arrSuCcRecipientIds = [];
	 //    $("#record_container--submittal_recipients--Cc li input").each(function(i) {
		//  arrSuCcRecipientIds.push($(this).val());
		// });
		// var su_cc_recipient_contact_ids = '';

		// if (arrSuCcRecipientIds.length) {
		// 	su_cc_recipient_contact_ids = arrSuCcRecipientIds.join(',');
	 //    }
	 // to
	 var su_to_recipient_contact_ids = $("#submittalToId").val();
	    ajaxQueryString = ajaxQueryString + '&su_to_recipient_contact_ids=' + encodeURIComponent(su_to_recipient_contact_ids);
	 // cc
			var su_cc_recipient_contact_ids = $("#submittalccId").val();
	    ajaxQueryString = ajaxQueryString + '&su_cc_recipient_contact_ids=' + encodeURIComponent(su_cc_recipient_contact_ids);
	    // Bcc recipients.
		// var arrSuBccRecipientIds = [];
		// $("#record_container--submittal_recipients--Bcc li input").each(function(i) {
		// 	arrSuBccRecipientIds.push($(this).val());
		// });

		// var su_bcc_recipient_contact_ids = '';
		// if (arrSuBccRecipientIds.length) {
		// 	su_bcc_recipient_contact_ids = arrSuBccRecipientIds.join(',');
		// }
		// bcc
		var su_bcc_recipient_contact_ids = $("#submittalbccId").val();
		ajaxQueryString = ajaxQueryString + '&su_bcc_recipient_contact_ids=' + encodeURIComponent(su_bcc_recipient_contact_ids);

		// For Tag
		var sub_Tags = $("#search_data").val();
		ajaxQueryString = ajaxQueryString + '&sub_Tags=' + encodeURIComponent(sub_Tags);
		return ajaxQueryString;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function filterSubmittalDraftHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue)
{
	inputDataFiltered = false;

	switch (attributeName) {
		case 'submittal_draft_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'project_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'submittal_type_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'submittal_priority_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'submittal_distribution_method_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_file_manager_file_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_cost_code_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_creator_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_creator_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_creator_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_creator_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_creator_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_recipient_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_recipient_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_recipient_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_recipient_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_recipient_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_initiator_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_initiator_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_initiator_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_initiator_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_initiator_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'su_due_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		default:
			var newValue = tmpValue;
	}

	var objReturn = { inputDataFiltered: inputDataFiltered, newValue: newValue };
	return objReturn;
}

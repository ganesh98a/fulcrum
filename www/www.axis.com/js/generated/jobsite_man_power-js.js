
/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function createJobsiteManPower(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Jobsite Man Power';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Jobsite Man Power';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-jobsite_man_power-record';
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
			var attributeSubgroupName = 'jobsite_man_power';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'jobsite_man_power-ajax.php?method=createJobsiteManPower';
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
			var htmlRecordAttributesAsAjaxQueryString = buildJobsiteManPowerHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function loadJobsiteManPower(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var attributeSubgroupName = 'jobsite_man_power';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'jobsite_man_power-ajax.php?method=loadJobsiteManPower';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		var jobsite_man_power_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--jobsite_man_power_id--' + uniqueId;
		if ($("#" + jobsite_man_power_id_element_id).length) {
			var jobsite_man_power_id = $("#" + jobsite_man_power_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&jobsite_man_power_id=' + encodeURIComponent(jobsite_man_power_id);
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

function loadAllJobsiteManPowerRecords(recordListContainerElementId, attributeGroupName, options)
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
			var attributeSubgroupName = 'jobsite_man_power';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'jobsite_man_power-ajax.php?method=loadAllJobsiteManPowerRecords';
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
function updateJobsiteManPower(element, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Jobsite Man Power';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Jobsite Man Power';
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
			var attributeSubgroupName = 'jobsite_man_power';
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
			var objReturn = filterJobsiteManPowerHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
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
			var ajaxHandlerScript = 'jobsite_man_power-ajax.php?method=updateJobsiteManPower';
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
function updateAllJobsiteManPowerAttributes(attributeGroupName, uniqueId, options)
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
		var attributeSubgroupName = 'jobsite_man_power';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Jobsite Man Power';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Jobsite Man Power';
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
			var attributeSubgroupName = 'jobsite_man_power';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'jobsite_man_power-ajax.php?method=updateAllJobsiteManPowerAttributes';
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
			var htmlRecordAttributesAsAjaxQueryString = buildJobsiteManPowerHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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
function deleteJobsiteManPower(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var confirmDeleteAnswer = window.confirm('Are You Sure That You Want To Delete This Jobsite Man Power?');
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
		var attributeSubgroupName = 'jobsite_man_power';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Jobsite Man Power';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Jobsite Man Power';
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
			var attributeSubgroupName = 'jobsite_man_power';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'jobsite_man_power-ajax.php?method=deleteJobsiteManPower';
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
function saveJobsiteManPower(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Jobsite Man Power';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Jobsite Man Power';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-jobsite_man_power-record';
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
			var attributeSubgroupName = 'jobsite_man_power';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'jobsite_man_power-ajax.php?method=saveJobsiteManPower';
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
			var htmlRecordAttributesAsAjaxQueryString = buildJobsiteManPowerHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function buildJobsiteManPowerHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'jobsite_man_power';
		}

		ajaxQueryString = '';

		if (!optionsObjectIsEmpty && options.includeId) {
			var jobsite_man_power_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--jobsite_man_power_id--' + uniqueId;
			if ($("#" + jobsite_man_power_id_element_id).length) {
				var jobsite_man_power_id = $("#" + jobsite_man_power_id_element_id).val();
				if (!optionsObjectIsEmpty && options.filterId) {
					jobsite_man_power_id = parseInputToMySQLUnsignedInt(jobsite_man_power_id);
				}
				ajaxQueryString = ajaxQueryString + '&jobsite_man_power_id=' + encodeURIComponent(jobsite_man_power_id);
			}
		}

		var jobsite_daily_log_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--jobsite_daily_log_id--' + uniqueId;
		if ($("#" + jobsite_daily_log_id_element_id).length) {
			var jobsite_daily_log_id = $("#" + jobsite_daily_log_id_element_id).val();
			jobsite_daily_log_id = parseInputToInt(jobsite_daily_log_id);
			ajaxQueryString = ajaxQueryString + '&jobsite_daily_log_id=' + encodeURIComponent(jobsite_daily_log_id);
		}

		var subcontract_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--subcontract_id--' + uniqueId;
		if ($("#" + subcontract_id_element_id).length) {
			var subcontract_id = $("#" + subcontract_id_element_id).val();
			subcontract_id = parseInputToInt(subcontract_id);
			ajaxQueryString = ajaxQueryString + '&subcontract_id=' + encodeURIComponent(subcontract_id);
		}

		var number_of_people_element_id = attributeGroupName + '--' + attributeSubgroupName + '--number_of_people--' + uniqueId;
		if ($("#" + number_of_people_element_id).length) {
			var number_of_people = $("#" + number_of_people_element_id).val();
			number_of_people = parseInputToInt(number_of_people);
			ajaxQueryString = ajaxQueryString + '&number_of_people=' + encodeURIComponent(number_of_people);
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

function filterJobsiteManPowerHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue)
{
	inputDataFiltered = false;

	switch (attributeName) {
		case 'jobsite_man_power_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'jobsite_daily_log_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'subcontract_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'number_of_people':
			var newValue = parseInputToMySQLUnsignedSmallInt(tmpValue);
			inputDataFiltered = true;
			break;
		default:
			var newValue = tmpValue;
	}

	var objReturn = { inputDataFiltered: inputDataFiltered, newValue: newValue };
	return objReturn;
}

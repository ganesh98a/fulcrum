
/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function createSubmittalNotification(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Notification';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Notifications';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-submittal_notification-record';
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
			var attributeSubgroupName = 'submittal_notifications';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_notifications-ajax.php?method=createSubmittalNotification';
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
			var htmlRecordAttributesAsAjaxQueryString = buildSubmittalNotificationHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function loadSubmittalNotification(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var attributeSubgroupName = 'submittal_notifications';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_notifications-ajax.php?method=loadSubmittalNotification';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		var submittal_notification_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_notification_id--' + uniqueId;
		if ($("#" + submittal_notification_id_element_id).length) {
			var submittal_notification_id = $("#" + submittal_notification_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&submittal_notification_id=' + encodeURIComponent(submittal_notification_id);
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

function loadAllSubmittalNotificationRecords(recordListContainerElementId, attributeGroupName, options)
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
			var attributeSubgroupName = 'submittal_notifications';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_notifications-ajax.php?method=loadAllSubmittalNotificationRecords';
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
function updateSubmittalNotification(element, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Notification';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Notifications';
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
			var attributeSubgroupName = 'submittal_notifications';
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
			var objReturn = filterSubmittalNotificationHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
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
			var ajaxHandlerScript = 'submittal_notifications-ajax.php?method=updateSubmittalNotification';
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
function updateAllSubmittalNotificationAttributes(attributeGroupName, uniqueId, options)
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
		var attributeSubgroupName = 'submittal_notifications';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Notification';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Notifications';
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
			var attributeSubgroupName = 'submittal_notifications';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_notifications-ajax.php?method=updateAllSubmittalNotificationAttributes';
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
			var htmlRecordAttributesAsAjaxQueryString = buildSubmittalNotificationHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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
function deleteSubmittalNotification(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var confirmDeleteAnswer = window.confirm('Are You Sure That You Want To Delete This Submittal Notification?');
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
		var attributeSubgroupName = 'submittal_notifications';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Notification';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Notifications';
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
			var attributeSubgroupName = 'submittal_notifications';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_notifications-ajax.php?method=deleteSubmittalNotification';
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
function saveSubmittalNotification(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal Notification';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittal Notifications';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-submittal_notification-record';
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
			var attributeSubgroupName = 'submittal_notifications';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'submittal_notifications-ajax.php?method=saveSubmittalNotification';
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
			var htmlRecordAttributesAsAjaxQueryString = buildSubmittalNotificationHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function buildSubmittalNotificationHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'submittal_notifications';
		}

		ajaxQueryString = '';

		if (!optionsObjectIsEmpty && options.includeId) {
			var submittal_notification_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_notification_id--' + uniqueId;
			if ($("#" + submittal_notification_id_element_id).length) {
				var submittal_notification_id = $("#" + submittal_notification_id_element_id).val();
				if (!optionsObjectIsEmpty && options.filterId) {
					submittal_notification_id = parseInputToMySQLUnsignedInt(submittal_notification_id);
				}
				ajaxQueryString = ajaxQueryString + '&submittal_notification_id=' + encodeURIComponent(submittal_notification_id);
			}
		}

		var submittal_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_id--' + uniqueId;
		if ($("#" + submittal_id_element_id).length) {
			var submittal_id = $("#" + submittal_id_element_id).val();
			submittal_id = parseInputToInt(submittal_id);
			ajaxQueryString = ajaxQueryString + '&submittal_id=' + encodeURIComponent(submittal_id);
		}

		var submittal_notification_timestamp_element_id = attributeGroupName + '--' + attributeSubgroupName + '--submittal_notification_timestamp--' + uniqueId;
		if ($("#" + submittal_notification_timestamp_element_id).length) {
			var submittal_notification_timestamp = $("#" + submittal_notification_timestamp_element_id).val();
			submittal_notification_timestamp = convertTimestampToMySQLFormat(submittal_notification_timestamp);
			ajaxQueryString = ajaxQueryString + '&submittal_notification_timestamp=' + encodeURIComponent(submittal_notification_timestamp);
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

function filterSubmittalNotificationHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue)
{
	inputDataFiltered = false;

	switch (attributeName) {
		case 'submittal_notification_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'submittal_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'submittal_notification_timestamp':
			var newValue = convertTimestampToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		default:
			var newValue = tmpValue;
	}

	var objReturn = { inputDataFiltered: inputDataFiltered, newValue: newValue };
	return objReturn;
}

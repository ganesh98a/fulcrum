
/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function createChangeOrder(attributeGroupName, uniqueId, options)
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

		// validate costcode
		var ccIncValue = $('#cocode-inc-value').val(); 
		var taxCCIncValue = $('#taxcode-inc-value').val(); 
		ccIncValue = Number(ccIncValue);
		taxCCIncValue = Number(taxCCIncValue);
		var ic = icfirst = 1;
		var itc = itcfirst = 1;
		var requiredInc = 0;
		var requiredTaxInc = 0;
		for (ic; ic <= ccIncValue; ic++) {
			if ($('#costcode'+ic).val() == '' || Number($('#costcode'+ic).val()) == 0) {
				$('.costcode-select'+ic).addClass('redBorderThick');
				if (icfirst == 1 && valid) {
					$('.costcode-select'+ic).focus();
					messageAlert('Please select the cost code.', 'errorMessage');
					icfirst++;
				}
				requiredInc++;
			}
		}
		
		for (itc; itc <= taxCCIncValue; itc++) {
			if (($('#taxcode'+itc).val() == '' || Number($('#taxcode'+itc).val()) == 0) && $('#content'+itc).val() != '') {
				$('.taxcode-select'+itc).addClass('redBorderThick');
				if (itcfirst == 1 && requiredInc == 0 && valid) {
					$('.taxcode-select'+itc).focus();
					messageAlert('Please select the cost code.', 'errorMessage');
					itcfirst++;
				}
				requiredTaxInc++;
			}
		}

		if(requiredInc != 0) {
			return;
		}

		if(requiredTaxInc != 0) {
			return;
		}

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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Change Order';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Change Orders';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-change_order-record';
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
			var attributeSubgroupName = 'change_orders';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'change_orders-ajax.php?method=createChangeOrder';
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
			var htmlRecordAttributesAsAjaxQueryString = buildChangeOrderHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function loadChangeOrder(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var attributeSubgroupName = 'change_orders';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'change_orders-ajax.php?method=loadChangeOrder';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		var change_order_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--change_order_id--' + uniqueId;
		if ($("#" + change_order_id_element_id).length) {
			var change_order_id = $("#" + change_order_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&change_order_id=' + encodeURIComponent(change_order_id);
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

function loadAllChangeOrderRecords(recordListContainerElementId, attributeGroupName, options)
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
			var attributeSubgroupName = 'change_orders';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'change_orders-ajax.php?method=loadAllChangeOrderRecords';
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
function updateChangeOrder(element, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Change Order';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Change Orders';
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
			var attributeSubgroupName = 'change_orders';
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
			var objReturn = filterChangeOrderHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
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
			var ajaxHandlerScript = 'change_orders-ajax.php?method=updateChangeOrder';
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
function updateAllChangeOrderAttributes(attributeGroupName, uniqueId, options)
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
		var attributeSubgroupName = 'change_orders';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Change Order';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Change Orders';
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
			var attributeSubgroupName = 'change_orders';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'change_orders-ajax.php?method=updateAllChangeOrderAttributes';
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
			var htmlRecordAttributesAsAjaxQueryString = buildChangeOrderHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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
function deleteChangeOrder(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var confirmDeleteAnswer = window.confirm('Are You Sure That You Want To Delete This Change Order?');
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
		var attributeSubgroupName = 'change_orders';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Change Order';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Change Orders';
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
			var attributeSubgroupName = 'change_orders';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'change_orders-ajax.php?method=deleteChangeOrder';
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
function saveChangeOrder(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Change Order';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Change Orders';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-change_order-record';
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
			var attributeSubgroupName = 'change_orders';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'change_orders-ajax.php?method=saveChangeOrder';
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
			var htmlRecordAttributesAsAjaxQueryString = buildChangeOrderHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function buildChangeOrderHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'change_orders';
		}

		ajaxQueryString = '';

		if (!optionsObjectIsEmpty && options.includeId) {
			var change_order_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--change_order_id--' + uniqueId;
			if ($("#" + change_order_id_element_id).length) {
				var change_order_id = $("#" + change_order_id_element_id).val();
				if (!optionsObjectIsEmpty && options.filterId) {
					change_order_id = parseInputToMySQLUnsignedInt(change_order_id);
				}
				ajaxQueryString = ajaxQueryString + '&change_order_id=' + encodeURIComponent(change_order_id);
			}
		}

		var project_id_element_id = 'currentlySelectedProjectId';
		if ($("#" + project_id_element_id).length) {
			var project_id = $("#" + project_id_element_id).val();
			project_id = parseInputToInt(project_id);
			ajaxQueryString = ajaxQueryString + '&project_id=' + encodeURIComponent(project_id);
		}

		var co_sequence_number_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_sequence_number--' + uniqueId;
		if ($("#" + co_sequence_number_element_id).length) {
			var co_sequence_number = $("#" + co_sequence_number_element_id).val();
			co_sequence_number = parseInputToInt(co_sequence_number);
			ajaxQueryString = ajaxQueryString + '&co_sequence_number=' + encodeURIComponent(co_sequence_number);
		}
		var co_custom_sequence_number_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_custom_sequence_number--' + uniqueId;
		if ($("#" + co_custom_sequence_number_element_id).length) {
			var co_custom_sequence_number = $("#" + co_custom_sequence_number_element_id).val();
			ajaxQueryString = ajaxQueryString + '&co_custom_sequence_number=' + encodeURIComponent(co_custom_sequence_number);
		}
		// var co_scheduled_value_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_scheduled_value--' + uniqueId;
		// if ($("#" + co_scheduled_value_element_id).length) {
		// 	var co_scheduled_value = $("#" + co_scheduled_value_element_id).val();
		// 	co_scheduled_value = parseInputToCurrency(co_scheduled_value);
		// 	ajaxQueryString = ajaxQueryString + '&co_scheduled_value=' + encodeURIComponent(co_scheduled_value);
		// }
		var co_delay_days_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_delay_days--' + uniqueId;
		if ($("#" + co_delay_days_element_id).length) {
			var co_delay_days = $("#" + co_delay_days_element_id).val();
			// co_delay_days = parseInputToInt(co_delay_days);
			ajaxQueryString = ajaxQueryString + '&co_delay_days=' + encodeURIComponent(co_delay_days);
		}
		var change_order_type_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--change_order_type_id--' + uniqueId;
		if ($("#" + change_order_type_id_element_id).length) {
			var change_order_type_id = $("#" + change_order_type_id_element_id).val();
			change_order_type_id = parseInputToInt(change_order_type_id);
			ajaxQueryString = ajaxQueryString + '&change_order_type_id=' + encodeURIComponent(change_order_type_id);
		}

		var change_order_status_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--change_order_status_id--' + uniqueId;
		if ($("#" + change_order_status_id_element_id).length) {
			var change_order_status_id = $("#" + change_order_status_id_element_id).val();
			change_order_status_id = parseInputToInt(change_order_status_id);
			ajaxQueryString = ajaxQueryString + '&change_order_status_id=' + encodeURIComponent(change_order_status_id);
		}

		var change_order_priority_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--change_order_priority_id--' + uniqueId;
		if ($("#" + change_order_priority_id_element_id).length) {
			var change_order_priority_id = $("#" + change_order_priority_id_element_id).val();
			change_order_priority_id = parseInputToInt(change_order_priority_id);
			if(change_order_priority_id !='')
			{
			ajaxQueryString = ajaxQueryString + '&change_order_priority_id=' + encodeURIComponent(change_order_priority_id);
				
			}
			
		}

		var co_file_manager_file_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_file_manager_file_id--' + uniqueId;
		if ($("#" + co_file_manager_file_id_element_id).length) {
			var co_file_manager_file_id = $("#" + co_file_manager_file_id_element_id).val();
			co_file_manager_file_id = parseInputToInt(co_file_manager_file_id);
			ajaxQueryString = ajaxQueryString + '&co_file_manager_file_id=' + encodeURIComponent(co_file_manager_file_id);
		}

		var co_cost_code_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_cost_code_id--' + uniqueId;
		if ($("#" + co_cost_code_id_element_id).length) {
			var co_cost_code_id = $("#" + co_cost_code_id_element_id).val();
			co_cost_code_id = parseInputToInt(co_cost_code_id);
			if(co_cost_code_id !='')
			{
			ajaxQueryString = ajaxQueryString + '&co_cost_code_id=' + encodeURIComponent(co_cost_code_id);
				
			}
			
		}

		var co_creator_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_creator_contact_id--' + uniqueId;
		if ($("#" + co_creator_contact_id_element_id).length) {
			var co_creator_contact_id = $("#" + co_creator_contact_id_element_id).val();
			co_creator_contact_id = parseInputToInt(co_creator_contact_id);
			ajaxQueryString = ajaxQueryString + '&co_creator_contact_id=' + encodeURIComponent(co_creator_contact_id);
		}

		var co_type_prefix_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_type_prefix--' + uniqueId;
		if ($("#" + co_type_prefix_element_id).length) {
			var co_type_prefix = $("#" + co_type_prefix_element_id).val();
			ajaxQueryString = ajaxQueryString + '&co_type_prefix=' + encodeURIComponent(co_type_prefix);
		}

		var co_creator_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_creator_contact_company_office_id--' + uniqueId;
		if ($("#" + co_creator_contact_company_office_id_element_id).length) {
			var co_creator_contact_company_office_id = $("#" + co_creator_contact_company_office_id_element_id).val();
			co_creator_contact_company_office_id = parseInputToInt(co_creator_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&co_creator_contact_company_office_id=' + encodeURIComponent(co_creator_contact_company_office_id);
		}

		var co_creator_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_creator_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + co_creator_phone_contact_company_office_phone_number_id_element_id).length) {
			var co_creator_phone_contact_company_office_phone_number_id = $("#" + co_creator_phone_contact_company_office_phone_number_id_element_id).val();
			co_creator_phone_contact_company_office_phone_number_id = parseInputToInt(co_creator_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_creator_phone_contact_company_office_phone_number_id=' + encodeURIComponent(co_creator_phone_contact_company_office_phone_number_id);
		}

		var co_creator_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_creator_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + co_creator_fax_contact_company_office_phone_number_id_element_id).length) {
			var co_creator_fax_contact_company_office_phone_number_id = $("#" + co_creator_fax_contact_company_office_phone_number_id_element_id).val();
			co_creator_fax_contact_company_office_phone_number_id = parseInputToInt(co_creator_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_creator_fax_contact_company_office_phone_number_id=' + encodeURIComponent(co_creator_fax_contact_company_office_phone_number_id);
		}

		var co_creator_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_creator_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + co_creator_contact_mobile_phone_number_id_element_id).length) {
			var co_creator_contact_mobile_phone_number_id = $("#" + co_creator_contact_mobile_phone_number_id_element_id).val();
			co_creator_contact_mobile_phone_number_id = parseInputToInt(co_creator_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_creator_contact_mobile_phone_number_id=' + encodeURIComponent(co_creator_contact_mobile_phone_number_id);
		}

		var co_recipient_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_recipient_contact_id--' + uniqueId;
		if ($("#" + co_recipient_contact_id_element_id).length) {
			var co_recipient_contact_id = $("#" + co_recipient_contact_id_element_id).val();
			co_recipient_contact_id = parseInputToInt(co_recipient_contact_id);
			ajaxQueryString = ajaxQueryString + '&co_recipient_contact_id=' + encodeURIComponent(co_recipient_contact_id);
		}

		var co_recipient_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_recipient_contact_company_office_id--' + uniqueId;
		if ($("#" + co_recipient_contact_company_office_id_element_id).length) {
			var co_recipient_contact_company_office_id = $("#" + co_recipient_contact_company_office_id_element_id).val();
			co_recipient_contact_company_office_id = parseInputToInt(co_recipient_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&co_recipient_contact_company_office_id=' + encodeURIComponent(co_recipient_contact_company_office_id);
		}

		var co_recipient_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_recipient_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + co_recipient_phone_contact_company_office_phone_number_id_element_id).length) {
			var co_recipient_phone_contact_company_office_phone_number_id = $("#" + co_recipient_phone_contact_company_office_phone_number_id_element_id).val();
			co_recipient_phone_contact_company_office_phone_number_id = parseInputToInt(co_recipient_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_recipient_phone_contact_company_office_phone_number_id=' + encodeURIComponent(co_recipient_phone_contact_company_office_phone_number_id);
		}

		var co_recipient_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_recipient_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + co_recipient_fax_contact_company_office_phone_number_id_element_id).length) {
			var co_recipient_fax_contact_company_office_phone_number_id = $("#" + co_recipient_fax_contact_company_office_phone_number_id_element_id).val();
			co_recipient_fax_contact_company_office_phone_number_id = parseInputToInt(co_recipient_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_recipient_fax_contact_company_office_phone_number_id=' + encodeURIComponent(co_recipient_fax_contact_company_office_phone_number_id);
		}

		var co_recipient_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_recipient_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + co_recipient_contact_mobile_phone_number_id_element_id).length) {
			var co_recipient_contact_mobile_phone_number_id = $("#" + co_recipient_contact_mobile_phone_number_id_element_id).val();
			co_recipient_contact_mobile_phone_number_id = parseInputToInt(co_recipient_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_recipient_contact_mobile_phone_number_id=' + encodeURIComponent(co_recipient_contact_mobile_phone_number_id);
		}

		var co_initiator_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_initiator_contact_id--' + uniqueId;
		if ($("#" + co_initiator_contact_id_element_id).length) {
			var co_initiator_contact_id = $("#" + co_initiator_contact_id_element_id).val();
			co_initiator_contact_id = parseInputToInt(co_initiator_contact_id);
			if(co_initiator_contact_id !='0')
			{
				ajaxQueryString = ajaxQueryString + '&co_initiator_contact_id=' + encodeURIComponent(co_initiator_contact_id);
				
			}
			
		}

		var co_initiator_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_initiator_contact_company_office_id--' + uniqueId;
		if ($("#" + co_initiator_contact_company_office_id_element_id).length) {
			var co_initiator_contact_company_office_id = $("#" + co_initiator_contact_company_office_id_element_id).val();
			co_initiator_contact_company_office_id = parseInputToInt(co_initiator_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&co_initiator_contact_company_office_id=' + encodeURIComponent(co_initiator_contact_company_office_id);
		}

		var co_initiator_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_initiator_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + co_initiator_phone_contact_company_office_phone_number_id_element_id).length) {
			var co_initiator_phone_contact_company_office_phone_number_id = $("#" + co_initiator_phone_contact_company_office_phone_number_id_element_id).val();
			co_initiator_phone_contact_company_office_phone_number_id = parseInputToInt(co_initiator_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_initiator_phone_contact_company_office_phone_number_id=' + encodeURIComponent(co_initiator_phone_contact_company_office_phone_number_id);
		}

		var co_initiator_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_initiator_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + co_initiator_fax_contact_company_office_phone_number_id_element_id).length) {
			var co_initiator_fax_contact_company_office_phone_number_id = $("#" + co_initiator_fax_contact_company_office_phone_number_id_element_id).val();
			co_initiator_fax_contact_company_office_phone_number_id = parseInputToInt(co_initiator_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_initiator_fax_contact_company_office_phone_number_id=' + encodeURIComponent(co_initiator_fax_contact_company_office_phone_number_id);
		}

		var co_initiator_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_initiator_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + co_initiator_contact_mobile_phone_number_id_element_id).length) {
			var co_initiator_contact_mobile_phone_number_id = $("#" + co_initiator_contact_mobile_phone_number_id_element_id).val();
			co_initiator_contact_mobile_phone_number_id = parseInputToInt(co_initiator_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&co_initiator_contact_mobile_phone_number_id=' + encodeURIComponent(co_initiator_contact_mobile_phone_number_id);
		}

		var co_title_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_title--' + uniqueId;
		if ($("#" + co_title_element_id).length) {
			var co_title = $("#" + co_title_element_id).val();
			ajaxQueryString = ajaxQueryString + '&co_title=' + encodeURIComponent(co_title);
		}
		var co_plan_page_reference_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_plan_page_reference--' + uniqueId;
		if ($("#" + co_plan_page_reference_element_id).length) {
			var co_plan_page_reference = $("#" + co_plan_page_reference_element_id).val();
			ajaxQueryString = ajaxQueryString + '&co_plan_page_reference=' + encodeURIComponent(co_plan_page_reference);
		}
		var co_statement_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_statement--' + uniqueId;
		if ($("#" + co_statement_element_id).length) {
			var co_statement = $("#" + co_statement_element_id).val();
			ajaxQueryString = ajaxQueryString + '&co_statement=' + encodeURIComponent(co_statement);
		}
		var created_element_id = attributeGroupName + '--' + attributeSubgroupName + '--created--' + uniqueId;
		if ($("#" + created_element_id).length) {
			var created = $("#" + created_element_id).val();
			created = convertTimestampToMySQLFormat(created);
			ajaxQueryString = ajaxQueryString + '&created=' + encodeURIComponent(created);
		}
		var co_revised_project_completion_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_revised_project_completion_date--' + uniqueId;
		if ($("#" + co_revised_project_completion_date_element_id).length) {
			var co_revised_project_completion_date = $("#" + co_revised_project_completion_date_element_id).val();
			co_revised_project_completion_date = convertDateToMySQLFormat(co_revised_project_completion_date);
			ajaxQueryString = ajaxQueryString + '&co_revised_project_completion_date=' + encodeURIComponent(co_revised_project_completion_date);
		}
		var co_closed_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_closed_date--' + uniqueId;
		if ($("#" + co_closed_date_element_id).length) {
			var co_closed_date = $("#" + co_closed_date_element_id).val();
			co_closed_date = convertDateToMySQLFormat(co_closed_date);
			ajaxQueryString = ajaxQueryString + '&co_closed_date=' + encodeURIComponent(co_closed_date);
		}
		var co_submitted_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_submitted_date--' + uniqueId;
		if ($("#" + co_submitted_date_element_id).length) {
			var co_submitted_date = $("#" + co_submitted_date_element_id).val();
			co_submitted_date = convertTimestampToMySQLFormat(co_submitted_date);
			ajaxQueryString = ajaxQueryString + '&co_submitted_date=' + encodeURIComponent(co_submitted_date);
		}
		var co_approved_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_approved_date--' + uniqueId;
		if ($("#" + co_approved_date_element_id).length) {
			var co_approved_date = $("#" + co_approved_date_element_id).val();
			co_approved_date = convertDateToMySQLFormat(co_approved_date);
			ajaxQueryString = ajaxQueryString + '&co_approved_date=' + encodeURIComponent(co_approved_date);
		}
		var co_signator_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--co_signator_contact_id--' + uniqueId;
		if ($("#" + co_signator_contact_id_element_id).length) {
			var co_signator_contact_id = $("#" + co_signator_contact_id_element_id).val();
			co_signator_contact_id = parseInputToInt(co_signator_contact_id);
			ajaxQueryString = ajaxQueryString + '&co_signator_contact_id=' + encodeURIComponent(co_signator_contact_id);
		}

		//For cost breakdown structure
		//For costcode
		var costcode = []; 
        $("input[name='costcode[]']").each(function(){
        	var ccData = $(this).val();
            costcode.push(ccData);
        });
		ajaxQueryString = ajaxQueryString + '&costcode=' + encodeURIComponent(costcode);
		//For tax cost breakdown structure
		//For tax costcode
		var taxcode = []; 
        $("input[name='taxcode[]']").each(function(){
        	var ccData = $(this).val();
            taxcode.push(ccData);
        });
        ajaxQueryString = ajaxQueryString + '&taxcode=' + encodeURIComponent(taxcode);
		//For description
		var description = []; 
        $("input[name='descript[]']").each(function(){
        	var desData = $(this).val();
	       	desData = desData.replace(/\,/g, '&comma;');
			desData = desData.replace(/\'/g, '&apos;');
            description.push(desData);

        });
        ajaxQueryString = ajaxQueryString + '&description=' + encodeURIComponent(description);
        //For sub data
         var subdata = []; 
        $("input[name='sub[]']").each(function(){
        	var subData = $(this).val();
        	subData = subData.replace(/\,/g, '&comma;');
			subData = subData.replace(/\'/g, '&apos;');
            subdata.push(subData);

        });
        ajaxQueryString = ajaxQueryString + '&subdata=' + encodeURIComponent(subdata);
        //For Reference
        var Reference = []; 
        $("input[name='ref[]']").each(function(){
        	var refData = $(this).val();
        	refData = refData.replace(/\,/g, '&comma;');
			refData = refData.replace(/\'/g, '&apos;');
            Reference.push(refData);

        });
        ajaxQueryString = ajaxQueryString + '&Reference=' + encodeURIComponent(Reference);
         //For Cost
        var cost = []; 
        $("input[name='cost[]']").each(function(){

                cost.push($(this).val());

        });
        ajaxQueryString = ajaxQueryString + '&cost=' + encodeURIComponent(cost);


        var subtotal =$('#subtotal').val();
        ajaxQueryString = ajaxQueryString + '&co_subtotal=' + encodeURIComponent(subtotal);

        //For userdefined content
         var content = []; 
        $("input[name='content[]']").each(function(){
        	var contentData = $(this).val();
			contentData = contentData.replace(/\,/g, '&comma;');
			contentData = contentData.replace(/\'/g, '&apos;');
            content.push(contentData);

        });
        ajaxQueryString = ajaxQueryString + '&content=' + encodeURIComponent(content);

         //For Percentage 
         var percentage = []; 
        $("input[name='percentage[]']").each(function(){
        	 percentage.push($(this).val());
        });
        ajaxQueryString = ajaxQueryString + '&percentage=' + encodeURIComponent(percentage);

         //For content total 
         var contotal = []; 
        $("input[name='contotal[]']").each(function(){
        	 contotal.push($(this).val());
        });
        ajaxQueryString = ajaxQueryString + '&contotal=' + encodeURIComponent(contotal);

        

        //For total
        var total =$('#total').val();
        ajaxQueryString = ajaxQueryString + '&co_total=' + encodeURIComponent(total);
		return ajaxQueryString;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function filterChangeOrderHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue)
{
	inputDataFiltered = false;

	switch (attributeName) {
		case 'change_order_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'project_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_sequence_number':
			var newValue = parseInputToMySQLUnsignedSmallInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_scheduled_value':
			var newValue = parseInputToCurrency(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_delay_days':
			var newValue = parseInputToMySQLUnsignedSmallInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'change_order_type_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'change_order_status_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'change_order_priority_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_file_manager_file_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_cost_code_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_creator_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_creator_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_creator_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_creator_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_creator_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_recipient_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_recipient_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_recipient_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_recipient_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_recipient_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_initiator_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_initiator_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_initiator_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_initiator_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_initiator_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'created':
			var newValue = convertTimestampToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_revised_project_completion_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_closed_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_submitted_date':
			var newValue = convertTimestampToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'co_approved_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break; 
		default:
			var newValue = tmpValue;
	}

	var objReturn = { inputDataFiltered: inputDataFiltered, newValue: newValue };
	return objReturn;
}

function editChangeOrder(attributeGroupName, uniqueId, options,change_order_id)
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
		
		var ccIncValue = $('#cocode-inc-value').val();
		var taxCCIncValue = $('#taxcode-inc-value').val(); 
		ccIncValue = Number(ccIncValue);	
		taxCCIncValue = Number(taxCCIncValue);	
		var ic = icFirst = 1;
		var itc = itcFirst = 1;
		var requiredInc = 0;
		var requiredTaxInc = 0;
		for (ic; ic <= ccIncValue; ic++) {
			if ($('#costcode'+ic).val() == '' || Number($('#costcode'+ic).val()) == 0) {
				$('.costcode-select'+ic).addClass('redBorderThick');
				if (icFirst == 1) {
					$('.costcode-select'+ic).focus();
					messageAlert('Please select the cost code.', 'errorMessage');
					icFirst++;
				}
				requiredInc++;
			}
		}

		for (itc; itc <= taxCCIncValue; itc++) {
			if (($('#taxcode'+itc).val() == '' || Number($('#taxcode'+itc).val()) == 0) && $('#content'+itc).val() != '') {
				$('.taxcode-select'+itc).addClass('redBorderThick');
				if (itcFirst == 1 && requiredInc == 0) {
					$('.taxcode-select'+itc).focus();
					messageAlert('Please select the cost code.', 'errorMessage');
					itcFirst++;
				}
				requiredTaxInc++;
			}
		}
	
		if(requiredInc != 0) {
			return;
		}

		if(requiredTaxInc != 0) {
			return;
		}

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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Change Order';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Change Orders';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-change_order-record';
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
			var attributeSubgroupName = 'change_orders';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'change_orders-ajax.php?method=EditChangeOrder';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newAttributeGroupName=' + encodeURIComponent(newAttributeGroupName) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&change_order_id=' + encodeURIComponent(change_order_id)
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName);

		if (!optionsObjectIsEmpty && options.skipBuildHtmlRecordAttributesAsAjaxQueryString) {
			var htmlRecordAttributesAsAjaxQueryString = '';
		} else {
			if (!optionsObjectIsEmpty && options.htmlRecordAttributeOptions) {
				htmlRecordAttributeOptions = options.htmlRecordAttributeOptions;
			} else {
				htmlRecordAttributeOptions = { };
			}
			var htmlRecordAttributesAsAjaxQueryString = buildChangeOrderHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

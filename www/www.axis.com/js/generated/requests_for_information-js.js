
/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function createRequestForInformation(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Request For Information';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Requests For Information';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-request_for_information-record';
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
			var attributeSubgroupName = 'requests_for_information';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'requests_for_information-ajax.php?method=createRequestForInformation';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var currentlySelectedProjectId = $('#currentlySelectedProjectId').val();
		var user_company_id = $('#currentlySelectedProjectUserCompanyId').val();
		var currentlyActiveContactId = $('#currentlyActiveContactId').val();
		var primary_contact_id = $('#primary_contact_id').val();
		var primary_contact_name = $('#primary_contact_name').val();
		var ajaxQueryString =
			'currentlySelectedProjectId=' + encodeURIComponent(currentlySelectedProjectId) +
			'&user_company_id=' + encodeURIComponent(user_company_id) +
			'&currentlyActiveContactId=' + encodeURIComponent(currentlyActiveContactId) +
			'&primary_contact_id=' + encodeURIComponent(primary_contact_id) +
			'&primary_contact_name=' + encodeURIComponent(primary_contact_name) +
			'&attributeGroupName=' + encodeURIComponent(attributeGroupName) +
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
			var htmlRecordAttributesAsAjaxQueryString = buildRequestForInformationHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function loadRequestForInformation(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var attributeSubgroupName = 'requests_for_information';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'requests_for_information-ajax.php?method=loadRequestForInformation';
		}

		var currentlySelectedProjectId = $('#currentlySelectedProjectId').val();
		var user_company_id = $('#currentlySelectedProjectUserCompanyId').val();
		var currentlyActiveContactId = $('#currentlyActiveContactId').val();
		var primary_contact_id = $('#primary_contact_id').val();
		var primary_contact_name = $('#primary_contact_name').val();
		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'currentlySelectedProjectId=' + encodeURIComponent(currentlySelectedProjectId) +
			'&user_company_id=' + encodeURIComponent(user_company_id) +
			'&currentlyActiveContactId=' + encodeURIComponent(currentlyActiveContactId) +
			'&primary_contact_id=' + encodeURIComponent(primary_contact_id) +
			'&primary_contact_name=' + encodeURIComponent(primary_contact_name) +
			'&attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		var request_for_information_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--request_for_information_id--' + uniqueId;
		if ($("#" + request_for_information_id_element_id).length) {
			var request_for_information_id = $("#" + request_for_information_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&request_for_information_id=' + encodeURIComponent(request_for_information_id);
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
			type:'POST',
			data: ajaxQueryString,
			success: arrSuccessCallbacks,
			error: errorHandler
		});
		setTimeout(function(){
		$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
		$(".bs-tooltip").tooltip();
		$('.emailGroup').fSelect();
		$(".ToRfiupdate").on("change", function(event) { 
			RFIs__createRequestForInformationRecipientHelper();
		});
		// To sort the attchment
			$( "#attachsort" ).sortable({
				change:function()
				{
						setTimeout(function(){ 
							reArrangeSortOrder(request_for_information_id); }, 3000);
		
				}
			});
				// for autocomplete
				$("#search_data").tokenfield({
				autocomplete :{
					source: function(request, response)
					{
						jQuery.post('requests_for_information-ajax.php?method=fetchtags', {
							query : request.term
						}, function(data){
							if(data != null){
								$("#search_null").css('display','none');
							data = JSON.parse(data);
							response(data);
						}else{
							$("#search_null").css('display','block');
						}
						});
					},
					delay: 100
				}
			});

	},1500);

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

function loadAllRequestForInformationRecords(recordListContainerElementId, attributeGroupName, options)
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
			var attributeSubgroupName = 'requests_for_information';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'requests_for_information-ajax.php?method=loadAllRequestForInformationRecords';
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
			type:'POST',
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
function updateRequestForInformation(element, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Request For Information';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Requests For Information';
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
			var attributeSubgroupName = 'requests_for_information';
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
			var objReturn = filterRequestForInformationHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
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
			var ajaxHandlerScript = 'requests_for_information-ajax.php?method=updateRequestForInformation';
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
function updateAllRequestForInformationAttributes(attributeGroupName, uniqueId, options)
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
		var attributeSubgroupName = 'requests_for_information';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Request For Information';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Requests For Information';
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
			var attributeSubgroupName = 'requests_for_information';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'requests_for_information-ajax.php?method=updateAllRequestForInformationAttributes';
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
			var htmlRecordAttributesAsAjaxQueryString = buildRequestForInformationHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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
function deleteRequestForInformation(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var confirmDeleteAnswer = window.confirm('Are You Sure That You Want To Delete This Request For Information?');
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
		var attributeSubgroupName = 'requests_for_information';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Request For Information';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Requests For Information';
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
			var attributeSubgroupName = 'requests_for_information';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'requests_for_information-ajax.php?method=deleteRequestForInformation';
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
function saveRequestForInformation(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Request For Information';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Requests For Information';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-request_for_information-record';
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
			var attributeSubgroupName = 'requests_for_information';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'requests_for_information-ajax.php?method=saveRequestForInformation';
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
			var htmlRecordAttributesAsAjaxQueryString = buildRequestForInformationHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function buildRequestForInformationHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'requests_for_information';
		}

		ajaxQueryString = '';

		if (!optionsObjectIsEmpty && options.includeId) {
			var request_for_information_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--request_for_information_id--' + uniqueId;
			if ($("#" + request_for_information_id_element_id).length) {
				var request_for_information_id = $("#" + request_for_information_id_element_id).val();
				if (!optionsObjectIsEmpty && options.filterId) {
					request_for_information_id = parseInputToMySQLUnsignedInt(request_for_information_id);
				}
				ajaxQueryString = ajaxQueryString + '&request_for_information_id=' + encodeURIComponent(request_for_information_id);
			}
		}

		var project_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_id--' + uniqueId;
		if ($("#" + project_id_element_id).length) {
			var project_id = $("#" + project_id_element_id).val();
			project_id = parseInputToInt(project_id);
			ajaxQueryString = ajaxQueryString + '&project_id=' + encodeURIComponent(project_id);
		}

		var rfi_sequence_number_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_sequence_number--' + uniqueId;
		if ($("#" + rfi_sequence_number_element_id).length) {
			var rfi_sequence_number = $("#" + rfi_sequence_number_element_id).val();
			rfi_sequence_number = parseInputToInt(rfi_sequence_number);
			ajaxQueryString = ajaxQueryString + '&rfi_sequence_number=' + encodeURIComponent(rfi_sequence_number);
		}
		var request_for_information_type_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--request_for_information_type_id--' + uniqueId;
		if ($("#" + request_for_information_type_id_element_id).length) {
			var request_for_information_type_id = $("#" + request_for_information_type_id_element_id).val();
			request_for_information_type_id = parseInputToInt(request_for_information_type_id);
			ajaxQueryString = ajaxQueryString + '&request_for_information_type_id=' + encodeURIComponent(request_for_information_type_id);
		}

		var request_for_information_status_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--request_for_information_status_id--' + uniqueId;
		if ($("#" + request_for_information_status_id_element_id).length) {
			var request_for_information_status_id = $("#" + request_for_information_status_id_element_id).val();
			request_for_information_status_id = parseInputToInt(request_for_information_status_id);
			ajaxQueryString = ajaxQueryString + '&request_for_information_status_id=' + encodeURIComponent(request_for_information_status_id);
		}

		var request_for_information_priority_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--request_for_information_priority_id--' + uniqueId;
		if ($("#" + request_for_information_priority_id_element_id).length) {
			var request_for_information_priority_id = $("#" + request_for_information_priority_id_element_id).val();
			request_for_information_priority_id = parseInputToInt(request_for_information_priority_id);
			ajaxQueryString = ajaxQueryString + '&request_for_information_priority_id=' + encodeURIComponent(request_for_information_priority_id);
		}

		var rfi_file_manager_file_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_file_manager_file_id--' + uniqueId;
		if ($("#" + rfi_file_manager_file_id_element_id).length) {
			var rfi_file_manager_file_id = $("#" + rfi_file_manager_file_id_element_id).val();
			rfi_file_manager_file_id = parseInputToInt(rfi_file_manager_file_id);
			ajaxQueryString = ajaxQueryString + '&rfi_file_manager_file_id=' + encodeURIComponent(rfi_file_manager_file_id);
		}

		var rfi_cost_code_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_cost_code_id--' + uniqueId;
		if ($("#" + rfi_cost_code_id_element_id).length) {
			var rfi_cost_code_id = $("#" + rfi_cost_code_id_element_id).val();
			rfi_cost_code_id = parseInputToInt(rfi_cost_code_id);
			ajaxQueryString = ajaxQueryString + '&rfi_cost_code_id=' + encodeURIComponent(rfi_cost_code_id);
		}

		var rfi_creator_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_creator_contact_id--' + uniqueId;
		if ($("#" + rfi_creator_contact_id_element_id).length) {
			var rfi_creator_contact_id = $("#" + rfi_creator_contact_id_element_id).val();
			rfi_creator_contact_id = parseInputToInt(rfi_creator_contact_id);
			ajaxQueryString = ajaxQueryString + '&rfi_creator_contact_id=' + encodeURIComponent(rfi_creator_contact_id);
		}

		var rfi_creator_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_creator_contact_company_office_id--' + uniqueId;
		if ($("#" + rfi_creator_contact_company_office_id_element_id).length) {
			var rfi_creator_contact_company_office_id = $("#" + rfi_creator_contact_company_office_id_element_id).val();
			rfi_creator_contact_company_office_id = parseInputToInt(rfi_creator_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&rfi_creator_contact_company_office_id=' + encodeURIComponent(rfi_creator_contact_company_office_id);
		}

		var rfi_creator_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_creator_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + rfi_creator_phone_contact_company_office_phone_number_id_element_id).length) {
			var rfi_creator_phone_contact_company_office_phone_number_id = $("#" + rfi_creator_phone_contact_company_office_phone_number_id_element_id).val();
			rfi_creator_phone_contact_company_office_phone_number_id = parseInputToInt(rfi_creator_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_creator_phone_contact_company_office_phone_number_id=' + encodeURIComponent(rfi_creator_phone_contact_company_office_phone_number_id);
		}

		var rfi_creator_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_creator_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + rfi_creator_fax_contact_company_office_phone_number_id_element_id).length) {
			var rfi_creator_fax_contact_company_office_phone_number_id = $("#" + rfi_creator_fax_contact_company_office_phone_number_id_element_id).val();
			rfi_creator_fax_contact_company_office_phone_number_id = parseInputToInt(rfi_creator_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_creator_fax_contact_company_office_phone_number_id=' + encodeURIComponent(rfi_creator_fax_contact_company_office_phone_number_id);
		}

		var rfi_creator_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_creator_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + rfi_creator_contact_mobile_phone_number_id_element_id).length) {
			var rfi_creator_contact_mobile_phone_number_id = $("#" + rfi_creator_contact_mobile_phone_number_id_element_id).val();
			rfi_creator_contact_mobile_phone_number_id = parseInputToInt(rfi_creator_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_creator_contact_mobile_phone_number_id=' + encodeURIComponent(rfi_creator_contact_mobile_phone_number_id);
		}

		var rfi_recipient_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_recipient_contact_id--' + uniqueId;
		if ($("#RFIToId").val()!="") {
			var rfi_recipient_contact_id = $("#RFIToId").val();
			ajaxQueryString = ajaxQueryString + '&rfi_recipient_contact_id=' + encodeURIComponent(rfi_recipient_contact_id);
		}
		// if ($("#" + rfi_recipient_contact_id_element_id).length) {
		// 	var rfi_recipient_contact_id = $("#" + rfi_recipient_contact_id_element_id).val();
		// 	rfi_recipient_contact_id = parseInputToInt(rfi_recipient_contact_id);
		// 	ajaxQueryString = ajaxQueryString + '&rfi_recipient_contact_id=' + encodeURIComponent(rfi_recipient_contact_id);
		// }

		var rfi_recipient_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_recipient_contact_company_office_id--' + uniqueId;
		if ($("#" + rfi_recipient_contact_company_office_id_element_id).length) {
			var rfi_recipient_contact_company_office_id = $("#" + rfi_recipient_contact_company_office_id_element_id).val();
			rfi_recipient_contact_company_office_id = parseInputToInt(rfi_recipient_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&rfi_recipient_contact_company_office_id=' + encodeURIComponent(rfi_recipient_contact_company_office_id);
		}

		var rfi_recipient_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_recipient_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + rfi_recipient_phone_contact_company_office_phone_number_id_element_id).length) {
			var rfi_recipient_phone_contact_company_office_phone_number_id = $("#" + rfi_recipient_phone_contact_company_office_phone_number_id_element_id).val();
			rfi_recipient_phone_contact_company_office_phone_number_id = parseInputToInt(rfi_recipient_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_recipient_phone_contact_company_office_phone_number_id=' + encodeURIComponent(rfi_recipient_phone_contact_company_office_phone_number_id);
		}

		var rfi_recipient_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_recipient_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + rfi_recipient_fax_contact_company_office_phone_number_id_element_id).length) {
			var rfi_recipient_fax_contact_company_office_phone_number_id = $("#" + rfi_recipient_fax_contact_company_office_phone_number_id_element_id).val();
			rfi_recipient_fax_contact_company_office_phone_number_id = parseInputToInt(rfi_recipient_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_recipient_fax_contact_company_office_phone_number_id=' + encodeURIComponent(rfi_recipient_fax_contact_company_office_phone_number_id);
		}

		var rfi_recipient_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_recipient_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + rfi_recipient_contact_mobile_phone_number_id_element_id).length) {
			var rfi_recipient_contact_mobile_phone_number_id = $("#" + rfi_recipient_contact_mobile_phone_number_id_element_id).val();
			rfi_recipient_contact_mobile_phone_number_id = parseInputToInt(rfi_recipient_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_recipient_contact_mobile_phone_number_id=' + encodeURIComponent(rfi_recipient_contact_mobile_phone_number_id);
		}

		var rfi_initiator_contact_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_initiator_contact_id--' + uniqueId;
		if ($("#" + rfi_initiator_contact_id_element_id).length) {
			var rfi_initiator_contact_id = $("#" + rfi_initiator_contact_id_element_id).val();
			rfi_initiator_contact_id = parseInputToInt(rfi_initiator_contact_id);
			ajaxQueryString = ajaxQueryString + '&rfi_initiator_contact_id=' + encodeURIComponent(rfi_initiator_contact_id);
		}

		var rfi_initiator_contact_company_office_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_initiator_contact_company_office_id--' + uniqueId;
		if ($("#" + rfi_initiator_contact_company_office_id_element_id).length) {
			var rfi_initiator_contact_company_office_id = $("#" + rfi_initiator_contact_company_office_id_element_id).val();
			rfi_initiator_contact_company_office_id = parseInputToInt(rfi_initiator_contact_company_office_id);
			ajaxQueryString = ajaxQueryString + '&rfi_initiator_contact_company_office_id=' + encodeURIComponent(rfi_initiator_contact_company_office_id);
		}

		var rfi_initiator_phone_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_initiator_phone_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + rfi_initiator_phone_contact_company_office_phone_number_id_element_id).length) {
			var rfi_initiator_phone_contact_company_office_phone_number_id = $("#" + rfi_initiator_phone_contact_company_office_phone_number_id_element_id).val();
			rfi_initiator_phone_contact_company_office_phone_number_id = parseInputToInt(rfi_initiator_phone_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_initiator_phone_contact_company_office_phone_number_id=' + encodeURIComponent(rfi_initiator_phone_contact_company_office_phone_number_id);
		}

		var rfi_initiator_fax_contact_company_office_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_initiator_fax_contact_company_office_phone_number_id--' + uniqueId;
		if ($("#" + rfi_initiator_fax_contact_company_office_phone_number_id_element_id).length) {
			var rfi_initiator_fax_contact_company_office_phone_number_id = $("#" + rfi_initiator_fax_contact_company_office_phone_number_id_element_id).val();
			rfi_initiator_fax_contact_company_office_phone_number_id = parseInputToInt(rfi_initiator_fax_contact_company_office_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_initiator_fax_contact_company_office_phone_number_id=' + encodeURIComponent(rfi_initiator_fax_contact_company_office_phone_number_id);
		}

		var rfi_initiator_contact_mobile_phone_number_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_initiator_contact_mobile_phone_number_id--' + uniqueId;
		if ($("#" + rfi_initiator_contact_mobile_phone_number_id_element_id).length) {
			var rfi_initiator_contact_mobile_phone_number_id = $("#" + rfi_initiator_contact_mobile_phone_number_id_element_id).val();
			rfi_initiator_contact_mobile_phone_number_id = parseInputToInt(rfi_initiator_contact_mobile_phone_number_id);
			ajaxQueryString = ajaxQueryString + '&rfi_initiator_contact_mobile_phone_number_id=' + encodeURIComponent(rfi_initiator_contact_mobile_phone_number_id);
		}

		var rfi_title_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_title--' + uniqueId;
		if ($("#" + rfi_title_element_id).length) {
			var rfi_title = $("#" + rfi_title_element_id).val();
			ajaxQueryString = ajaxQueryString + '&rfi_title=' + encodeURIComponent(rfi_title);
		}
		var rfi_plan_page_reference_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_plan_page_reference--' + uniqueId;
		if ($("#" + rfi_plan_page_reference_element_id).length) {
			var rfi_plan_page_reference = $("#" + rfi_plan_page_reference_element_id).val();
			ajaxQueryString = ajaxQueryString + '&rfi_plan_page_reference=' + encodeURIComponent(rfi_plan_page_reference);
		}
		var rfi_statement_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_statement--' + uniqueId;
		if ($("#" + rfi_statement_element_id).length) {
			var rfi_statement = $("#" + rfi_statement_element_id).val();
			ajaxQueryString = ajaxQueryString + '&rfi_statement=' + encodeURIComponent(rfi_statement);
		}
		var created_element_id = attributeGroupName + '--' + attributeSubgroupName + '--created--' + uniqueId;
		if ($("#" + created_element_id).length) {
			var created = $("#" + created_element_id).val();
			created = convertTimestampToMySQLFormat(created);
			ajaxQueryString = ajaxQueryString + '&created=' + encodeURIComponent(created);
		}
		var rfi_due_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_due_date--' + uniqueId;
		if ($("#" + rfi_due_date_element_id).length) {
			var rfi_due_date = $("#" + rfi_due_date_element_id).val();
			rfi_due_date = convertDateToMySQLFormat(rfi_due_date);
			ajaxQueryString = ajaxQueryString + '&rfi_due_date=' + encodeURIComponent(rfi_due_date);
		}
		var rfi_closed_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--rfi_closed_date--' + uniqueId;
		if ($("#" + rfi_closed_date_element_id).length) {
			var rfi_closed_date = $("#" + rfi_closed_date_element_id).val();
			rfi_closed_date = convertDateToMySQLFormat(rfi_closed_date);
			ajaxQueryString = ajaxQueryString + '&rfi_closed_date=' + encodeURIComponent(rfi_closed_date);
		}

		// For Tag
			var rfi_Tags = $("#search_data").val();
			ajaxQueryString = ajaxQueryString + '&rfi_Tags=' + encodeURIComponent(rfi_Tags);


		return ajaxQueryString;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function filterRequestForInformationHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue)
{
	inputDataFiltered = false;

	switch (attributeName) {
		case 'request_for_information_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'project_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_sequence_number':
			var newValue = parseInputToMySQLUnsignedSmallInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'request_for_information_type_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'request_for_information_status_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'request_for_information_priority_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_file_manager_file_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_cost_code_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_creator_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_creator_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_creator_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_creator_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_creator_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_recipient_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_recipient_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_recipient_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_recipient_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_recipient_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_initiator_contact_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_initiator_contact_company_office_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_initiator_phone_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_initiator_fax_contact_company_office_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_initiator_contact_mobile_phone_number_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'created':
			var newValue = convertTimestampToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_due_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'rfi_closed_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		default:
			var newValue = tmpValue;
	}

	var objReturn = { inputDataFiltered: inputDataFiltered, newValue: newValue };
	return objReturn;
}

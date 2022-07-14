
/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a dummy id placeholder to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function createProject(attributeGroupName, uniqueId, options,project_name,project_type)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Project';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Projects';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-project-record';
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
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'projects';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'projects-ajax.php?method=createProject';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName) +
			'&sortOrderFlag=' + encodeURIComponent(sortOrderFlag) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newAttributeGroupName=' + encodeURIComponent(newAttributeGroupName) +
			'&formattedAttributeGroupName=' + encodeURIComponent(formattedAttributeGroupName) +
			'&formattedAttributeSubgroupName=' + encodeURIComponent(formattedAttributeSubgroupName)+
			'&project_name=' + encodeURIComponent(project_name)+
			'&project_type=' + encodeURIComponent(project_type);

		if (!optionsObjectIsEmpty && options.skipBuildHtmlRecordAttributesAsAjaxQueryString) {
			var htmlRecordAttributesAsAjaxQueryString = '';
		} else {
			if (!optionsObjectIsEmpty && options.htmlRecordAttributeOptions) {
				htmlRecordAttributeOptions = options.htmlRecordAttributeOptions;
			} else {
				htmlRecordAttributeOptions = { };
			}
			var htmlRecordAttributesAsAjaxQueryString = buildProjectHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function loadProject(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var attributeSubgroupName = 'projects';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'projects-ajax.php?method=loadProject';
		}

		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
			'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		var project_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_id--' + uniqueId;
		if ($("#" + project_id_element_id).length) {
			var project_id = $("#" + project_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&project_id=' + encodeURIComponent(project_id);
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

function loadAllProjectRecords(recordListContainerElementId, attributeGroupName, options)
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
			var attributeSubgroupName = 'projects';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'projects-ajax.php?method=loadAllProjectRecords';
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
function updateProject(element, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Project';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Projects';
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
			var attributeSubgroupName = 'projects';
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
			var objReturn = filterProjectHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
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
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'projects-ajax.php?method=updateProject';
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
			complete: function(xhr,status){
				if($.trim(attributeName) == 'project_owner_name'){
					var project_id  = uniqueId;
					var ownername = newValue;
					checkAndInsertCustomerQB(project_id, ownername);
				}
			},
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

function checkAndInsertCustomerQB(project_id, ownername){
	$.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
        {'action': 'checkQBAndCustomer','ownername':ownername}, function(data){
    	if($.trim(data) === 'nocustomerinQB'){ // There is an accounting Portal
    		$("#dialog-confirm").html("Are you sure to Sync <b>"+ownername+"</b> to Quickbooks?");
            // Define the Dialog and its properties.
            $("#dialog-confirm").dialog({
              resizable: false,
              modal: true,
              title: "Confirmation",
              open: function() {
                $("#dialog-confirm").parent().addClass("jqueryPopupHead");
                $("body").addClass('noscroll');
              },
              close: function() {
                $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                $("body").removeClass('noscroll');
              },
              buttons: {
                "No": function () {
                  $(this).dialog('close');
                  $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                  $("body").removeClass('noscroll');
                },
                "Yes": function () {
                  $(this).dialog('close');
                  $("#dialog-confirm").parent().removeClass("jqueryPopupHead");
                  $("body").removeClass('noscroll');
                  $.get(
                  	window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
                  	{'action':'insertQBCustomer','ownername':ownername,'project_id':project_id},
                  	function(data){

                  })

                }
              }
            });


    	}
    });

}

/**
 * attributeGroupName or htmlRecordName is the name of the attributes group
 * uniqueId is a pk/uk to allow auto-sniffing the attributes out of the HTML form code
 * options is an object with a collection of optional directives
 */
function updateAllProjectAttributes(attributeGroupName, uniqueId, options)
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

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		// HTML Element id Format: id="attributeGroupName--attributeSubgroupName--attributeName--uniqueId"
		//var arrParts = recordContainerElementId.split('--');
		//var attributeGroupName = arrParts[1];
		var attributeSubgroupName = 'projects';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Project';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Projects';
			htmlRecordMetaAttributesOptions.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributesOptions.uniqueId = uniqueId;
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('updateAll', htmlRecordMetaAttributesOptions);
		}

		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'projects';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'projects-ajax.php?method=updateAllProjectAttributes';
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
			var htmlRecordAttributesAsAjaxQueryString = buildProjectHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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
function deleteProject(recordContainerElementId, attributeGroupName, uniqueId, options)
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
			var confirmDeleteAnswer = window.confirm('Are You Sure That You Want To Delete This Project?');
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

		// HTML Record Container Element id Format: id="record_container--attributeGroupName--attributeSubgroupName--sort_order--uniqueId"
		//var arrParts = recordContainerElementId.split('--');
		//var attributeGroupName = arrParts[1];
		var attributeSubgroupName = 'projects';
		//var uniqueId = arrParts[3];

		if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
			var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
		} else {
			var htmlRecordMetaAttributesOptions = {};
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Project';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Projects';
			htmlRecordMetaAttributesOptions.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributesOptions.uniqueId = uniqueId;
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('delete', htmlRecordMetaAttributesOptions);
		}

		var formattedAttributeGroupName 	= htmlRecordMetaAttributes.formattedAttributeGroupName;
		var formattedAttributeSubgroupName	= htmlRecordMetaAttributes.formattedAttributeSubgroupName;

		if (!optionsObjectIsEmpty && options.sortOrderFlag) {
			var sortOrderFlag = options.sortOrderFlag;
		} else {
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'projects';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'projects-ajax.php?method=deleteProject';
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
function saveProject(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Project';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Projects';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'manage-project-record';
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
			var sortOrderFlag = 'Y';
		}

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'projects';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'projects-ajax.php?method=saveProject';
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
			var htmlRecordAttributesAsAjaxQueryString = buildProjectHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, htmlRecordAttributeOptions);
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

function buildProjectHtmlRecordAttributesAsAjaxQueryString(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'projects';
		}

		ajaxQueryString = '';

		if (!optionsObjectIsEmpty && options.includeId) {
			var project_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_id--' + uniqueId;
			if ($("#" + project_id_element_id).length) {
				var project_id = $("#" + project_id_element_id).val();
				if (!optionsObjectIsEmpty && options.filterId) {
					project_id = parseInputToMySQLUnsignedInt(project_id);
				}
				ajaxQueryString = ajaxQueryString + '&project_id=' + encodeURIComponent(project_id);
			}
		}

		var project_type_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_type_id--' + uniqueId;
		if ($("#" + project_type_id_element_id).length) {
			var project_type_id = $("#" + project_type_id_element_id).val();
			project_type_id = parseInputToInt(project_type_id);
			ajaxQueryString = ajaxQueryString + '&project_type_id=' + encodeURIComponent(project_type_id);
		}

		var user_company_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--user_company_id--' + uniqueId;
		if ($("#" + user_company_id_element_id).length) {
			var user_company_id = $("#" + user_company_id_element_id).val();
			user_company_id = parseInputToInt(user_company_id);
			ajaxQueryString = ajaxQueryString + '&user_company_id=' + encodeURIComponent(user_company_id);
		}

		var user_custom_project_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--user_custom_project_id--' + uniqueId;
		if ($("#" + user_custom_project_id_element_id).length) {
			var user_custom_project_id = $("#" + user_custom_project_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&user_custom_project_id=' + encodeURIComponent(user_custom_project_id);
		}

		var project_name_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_name--' + uniqueId;
		if ($("#" + project_name_element_id).length) {
			var project_name = $("#" + project_name_element_id).val();
			ajaxQueryString = ajaxQueryString + '&project_name=' + encodeURIComponent(project_name);
		}
		var project_owner_name_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_owner_name--' + uniqueId;
		if ($("#" + project_owner_name_element_id).length) {
			var project_owner_name = $("#" + project_owner_name_element_id).val();
			ajaxQueryString = ajaxQueryString + '&project_owner_name=' + encodeURIComponent(project_owner_name);
		}
		var latitude_element_id = attributeGroupName + '--' + attributeSubgroupName + '--latitude--' + uniqueId;
		if ($("#" + latitude_element_id).length) {
			var latitude = $("#" + latitude_element_id).val();
			ajaxQueryString = ajaxQueryString + '&latitude=' + encodeURIComponent(latitude);
		}
		var longitude_element_id = attributeGroupName + '--' + attributeSubgroupName + '--longitude--' + uniqueId;
		if ($("#" + longitude_element_id).length) {
			var longitude = $("#" + longitude_element_id).val();
			ajaxQueryString = ajaxQueryString + '&longitude=' + encodeURIComponent(longitude);
		}
		var address_line_1_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_line_1--' + uniqueId;
		if ($("#" + address_line_1_element_id).length) {
			var address_line_1 = $("#" + address_line_1_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_line_1=' + encodeURIComponent(address_line_1);
		}
		var address_line_2_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_line_2--' + uniqueId;
		if ($("#" + address_line_2_element_id).length) {
			var address_line_2 = $("#" + address_line_2_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_line_2=' + encodeURIComponent(address_line_2);
		}
		var address_line_3_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_line_3--' + uniqueId;
		if ($("#" + address_line_3_element_id).length) {
			var address_line_3 = $("#" + address_line_3_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_line_3=' + encodeURIComponent(address_line_3);
		}
		var address_line_4_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_line_4--' + uniqueId;
		if ($("#" + address_line_4_element_id).length) {
			var address_line_4 = $("#" + address_line_4_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_line_4=' + encodeURIComponent(address_line_4);
		}
		var address_city_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_city--' + uniqueId;
		if ($("#" + address_city_element_id).length) {
			var address_city = $("#" + address_city_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_city=' + encodeURIComponent(address_city);
		}
		var address_county_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_county--' + uniqueId;
		if ($("#" + address_county_element_id).length) {
			var address_county = $("#" + address_county_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_county=' + encodeURIComponent(address_county);
		}
		var address_state_or_region_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_state_or_region--' + uniqueId;
		if ($("#" + address_state_or_region_element_id).length) {
			var address_state_or_region = $("#" + address_state_or_region_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_state_or_region=' + encodeURIComponent(address_state_or_region);
		}
		var address_postal_code_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_postal_code--' + uniqueId;
		if ($("#" + address_postal_code_element_id).length) {
			var address_postal_code = $("#" + address_postal_code_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_postal_code=' + encodeURIComponent(address_postal_code);
		}
		var address_postal_code_extension_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_postal_code_extension--' + uniqueId;
		if ($("#" + address_postal_code_extension_element_id).length) {
			var address_postal_code_extension = $("#" + address_postal_code_extension_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_postal_code_extension=' + encodeURIComponent(address_postal_code_extension);
		}
		var address_country_element_id = attributeGroupName + '--' + attributeSubgroupName + '--address_country--' + uniqueId;
		if ($("#" + address_country_element_id).length) {
			var address_country = $("#" + address_country_element_id).val();
			ajaxQueryString = ajaxQueryString + '&address_country=' + encodeURIComponent(address_country);
		}
		var building_count_element_id = attributeGroupName + '--' + attributeSubgroupName + '--building_count--' + uniqueId;
		if ($("#" + building_count_element_id).length) {
			var building_count = $("#" + building_count_element_id).val();
			building_count = parseInputToInt(building_count);
			ajaxQueryString = ajaxQueryString + '&building_count=' + encodeURIComponent(building_count);
		}
		var unit_count_element_id = attributeGroupName + '--' + attributeSubgroupName + '--unit_count--' + uniqueId;
		if ($("#" + unit_count_element_id).length) {
			var unit_count = $("#" + unit_count_element_id).val();
			unit_count = parseInputToInt(unit_count);
			ajaxQueryString = ajaxQueryString + '&unit_count=' + encodeURIComponent(unit_count);
		}
		var gross_square_footage_element_id = attributeGroupName + '--' + attributeSubgroupName + '--gross_square_footage--' + uniqueId;
		if ($("#" + gross_square_footage_element_id).length) {
			var gross_square_footage = $("#" + gross_square_footage_element_id).val();
			gross_square_footage = parseInputToInt(gross_square_footage);
			ajaxQueryString = ajaxQueryString + '&gross_square_footage=' + encodeURIComponent(gross_square_footage);
		}
		var net_rentable_square_footage_element_id = attributeGroupName + '--' + attributeSubgroupName + '--net_rentable_square_footage--' + uniqueId;
		if ($("#" + net_rentable_square_footage_element_id).length) {
			var net_rentable_square_footage = $("#" + net_rentable_square_footage_element_id).val();
			net_rentable_square_footage = parseInputToInt(net_rentable_square_footage);
			ajaxQueryString = ajaxQueryString + '&net_rentable_square_footage=' + encodeURIComponent(net_rentable_square_footage);
		}
		var is_active_flag_element_id = attributeGroupName + '--' + attributeSubgroupName + '--is_active_flag--' + uniqueId;
		if ($("#" + is_active_flag_element_id).length) {
			var is_active_flag = $("#" + is_active_flag_element_id).val();
			if ($("#" + is_active_flag_element_id).is(':checkbox')) {
				if ($("#" + is_active_flag_element_id).is(':checked')) {
					is_active_flag = 'Y';
				} else {
					is_active_flag = 'N';
				}
			}
			ajaxQueryString = ajaxQueryString + '&is_active_flag=' + encodeURIComponent(is_active_flag);
		}
		var public_plans_flag_element_id = attributeGroupName + '--' + attributeSubgroupName + '--public_plans_flag--' + uniqueId;
		if ($("#" + public_plans_flag_element_id).length) {
			var public_plans_flag = $("#" + public_plans_flag_element_id).val();
			if ($("#" + public_plans_flag_element_id).is(':checkbox')) {
				if ($("#" + public_plans_flag_element_id).is(':checked')) {
					public_plans_flag = 'Y';
				} else {
					public_plans_flag = 'N';
				}
			}
			ajaxQueryString = ajaxQueryString + '&public_plans_flag=' + encodeURIComponent(public_plans_flag);
		}
		var prevailing_wage_flag_element_id = attributeGroupName + '--' + attributeSubgroupName + '--prevailing_wage_flag--' + uniqueId;
		if ($("#" + prevailing_wage_flag_element_id).length) {
			var prevailing_wage_flag = $("#" + prevailing_wage_flag_element_id).val();
			if ($("#" + prevailing_wage_flag_element_id).is(':checkbox')) {
				if ($("#" + prevailing_wage_flag_element_id).is(':checked')) {
					prevailing_wage_flag = 'Y';
				} else {
					prevailing_wage_flag = 'N';
				}
			}
			ajaxQueryString = ajaxQueryString + '&prevailing_wage_flag=' + encodeURIComponent(prevailing_wage_flag);
		}
		var city_business_license_required_flag_element_id = attributeGroupName + '--' + attributeSubgroupName + '--city_business_license_required_flag--' + uniqueId;
		if ($("#" + city_business_license_required_flag_element_id).length) {
			var city_business_license_required_flag = $("#" + city_business_license_required_flag_element_id).val();
			if ($("#" + city_business_license_required_flag_element_id).is(':checkbox')) {
				if ($("#" + city_business_license_required_flag_element_id).is(':checked')) {
					city_business_license_required_flag = 'Y';
				} else {
					city_business_license_required_flag = 'N';
				}
			}
			ajaxQueryString = ajaxQueryString + '&city_business_license_required_flag=' + encodeURIComponent(city_business_license_required_flag);
		}
		var is_internal_flag_element_id = attributeGroupName + '--' + attributeSubgroupName + '--is_internal_flag--' + uniqueId;
		if ($("#" + is_internal_flag_element_id).length) {
			var is_internal_flag = $("#" + is_internal_flag_element_id).val();
			if ($("#" + is_internal_flag_element_id).is(':checkbox')) {
				if ($("#" + is_internal_flag_element_id).is(':checked')) {
					is_internal_flag = 'Y';
				} else {
					is_internal_flag = 'N';
				}
			}
			ajaxQueryString = ajaxQueryString + '&is_internal_flag=' + encodeURIComponent(is_internal_flag);
		}
		var project_contract_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_contract_date--' + uniqueId;
		if ($("#" + project_contract_date_element_id).length) {
			var project_contract_date = $("#" + project_contract_date_element_id).val();
			project_contract_date = convertDateToMySQLFormat(project_contract_date);
			ajaxQueryString = ajaxQueryString + '&project_contract_date=' + encodeURIComponent(project_contract_date);
		}
		var project_start_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_start_date--' + uniqueId;
		if ($("#" + project_start_date_element_id).length) {
			var project_start_date = $("#" + project_start_date_element_id).val();
			project_start_date = convertDateToMySQLFormat(project_start_date);
			ajaxQueryString = ajaxQueryString + '&project_start_date=' + encodeURIComponent(project_start_date);
		}
		var project_completed_date_element_id = attributeGroupName + '--' + attributeSubgroupName + '--project_completed_date--' + uniqueId;
		if ($("#" + project_completed_date_element_id).length) {
			var project_completed_date = $("#" + project_completed_date_element_id).val();
			project_completed_date = convertDateToMySQLFormat(project_completed_date);
			ajaxQueryString = ajaxQueryString + '&project_completed_date=' + encodeURIComponent(project_completed_date);
		}
		var sort_order_element_id = attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
		if ($("#" + sort_order_element_id).length) {
			var sort_order = $("#" + sort_order_element_id).val();
			sort_order = parseInputToInt(sort_order);
			ajaxQueryString = ajaxQueryString + '&sort_order=' + encodeURIComponent(sort_order);
		}
	    var retainer_rate_element_id = attributeGroupName + '--' + attributeSubgroupName + '--retainer_rate--' + uniqueId;
	    if ($("#" + retainer_rate_element_id).length) {
	      var retainer_rate = $("#" + retainer_rate_element_id).val();
	      retainer_rate = retainer_rate;
	      ajaxQueryString = ajaxQueryString + '&retainer_rate=' + encodeURIComponent(retainer_rate);
	    }
	    var draw_template_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--draw_template_id--' + uniqueId;
	    if ($("#" + draw_template_id_element_id).length) {
	      var draw_template_id = $("#" + draw_template_id_element_id).val();
	      draw_template_id = draw_template_id;
	      ajaxQueryString = ajaxQueryString + '&draw_template_id=' + encodeURIComponent(draw_template_id);
	    }
	    var contracting_entity_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--contracting_entity_id--' + uniqueId;
	    if ($("#" + contracting_entity_id_element_id).length) {
	      var contracting_entity_id = $("#" + contracting_entity_id_element_id).val();
	      contracting_entity_id = contracting_entity_id;
	      ajaxQueryString = ajaxQueryString + '&contracting_entity_id=' + encodeURIComponent(contracting_entity_id);
	    }
	    var time_zone_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--time_zone_id--' + uniqueId;
		if ($("#" + time_zone_id_element_id).length) {
			var time_zone_id = $("#" + time_zone_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&time_zone_id=' + encodeURIComponent(time_zone_id);
		}
		var delivery_time_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--delivery_time_id--' + uniqueId;
		if ($("#" + delivery_time_id_element_id).length) {
			var delivery_time_id = $("#" + delivery_time_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&delivery_time_id=' + encodeURIComponent(delivery_time_id);
		}
		var delivery_time_element_id = attributeGroupName + '--' + attributeSubgroupName + '--delivery_time--' + uniqueId;
		if ($("#" + delivery_time_element_id).length) {
			var delivery_time = $("#" + delivery_time_element_id).val();
			ajaxQueryString = ajaxQueryString + '&delivery_time=' + encodeURIComponent(delivery_time);
		}
		var architect_cmpy_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--architect_cmpy_id--' + uniqueId;
		if ($("#" + architect_cmpy_id_element_id).length) {
			var architect_cmpy_id = $("#" + architect_cmpy_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&architect_cmpy_id=' + encodeURIComponent(architect_cmpy_id);
		}
		var architect_cont_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--architect_cont_id--' + uniqueId;
		if ($("#" + architect_cont_id_element_id).length) {
			var architect_cont_id = $("#" + architect_cont_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&architect_cont_id=' + encodeURIComponent(architect_cont_id);
		}
		var max_photos_displayed_element_id = attributeGroupName + '--' + attributeSubgroupName + '--max_photos_displayed--' + uniqueId;
		if ($("#" + max_photos_displayed_element_id).length) {
			var max_photos_displayed = $("#" + max_photos_displayed_element_id).val();
			ajaxQueryString = ajaxQueryString + '&max_photos_displayed=' + encodeURIComponent(max_photos_displayed);
		}
		var photos_displayed_per_page_element_id = attributeGroupName + '--' + attributeSubgroupName + '--photos_displayed_per_page--' + uniqueId;
		if ($("#" + photos_displayed_per_page_element_id).length) {
			var photos_displayed_per_page = $("#" + photos_displayed_per_page_element_id).val();
			ajaxQueryString = ajaxQueryString + '&photos_displayed_per_page=' + encodeURIComponent(photos_displayed_per_page);
		}
		var owner_address_element_id = attributeGroupName + '--' + attributeSubgroupName + '--owner_address--' + uniqueId;
		if ($("#" + owner_address_element_id).length) {
			var owner_address = $("#" + owner_address_element_id).val();
			ajaxQueryString = ajaxQueryString + '&owner_address=' + encodeURIComponent(owner_address);
		}
		var owner_city_element_id = attributeGroupName + '--' + attributeSubgroupName + '--owner_city--' + uniqueId;
		if ($("#" + owner_city_element_id).length) {
			var owner_city = $("#" + owner_city_element_id).val();
			ajaxQueryString = ajaxQueryString + '&owner_city=' + encodeURIComponent(owner_city);
		}
		var owner_state_or_region_element_id = attributeGroupName + '--' + attributeSubgroupName + '--owner_state_or_region--' + uniqueId;
		if ($("#" + owner_state_or_region_element_id).length) {
			var owner_state_or_region = $("#" + owner_state_or_region_element_id).val();
			ajaxQueryString = ajaxQueryString + '&owner_state_or_region=' + encodeURIComponent(owner_state_or_region);
		}
		var owner_postal_code_element_id = attributeGroupName + '--' + attributeSubgroupName + '--owner_postal_code--' + uniqueId;
		if ($("#" + owner_postal_code_element_id).length) {
			var owner_postal_code = $("#" + owner_postal_code_element_id).val();
			ajaxQueryString = ajaxQueryString + '&owner_postal_code=' + encodeURIComponent(owner_postal_code);
		}
		var construction_license_number_element_id = attributeGroupName + '--' + attributeSubgroupName + '--construction_license_number--' + uniqueId;
		if ($("#" + construction_license_number_element_id).length) {
			var construction_license_number = $("#" + construction_license_number_element_id).val();
			ajaxQueryString = ajaxQueryString + '&construction_license_number=' + encodeURIComponent(construction_license_number);
		}
		var qb_customer_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--qb_customer_id--' + uniqueId;
		if ($("#" + qb_customer_id_element_id).length) {
			var qb_customer_id = $("#" + qb_customer_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&qb_customer_id=' + encodeURIComponent(qb_customer_id);
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

function filterProjectHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue)
{
	inputDataFiltered = false;

	switch (attributeName) {
		case 'project_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'project_type_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'user_company_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'building_count':
			var newValue = parseInputToMySQLUnsignedSmallInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'unit_count':
			var newValue = parseInputToMySQLUnsignedSmallInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'gross_square_footage':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'net_rentable_square_footage':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		case 'project_contract_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'project_start_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'project_completed_date':
			var newValue = convertDateToMySQLFormat(tmpValue);
			inputDataFiltered = true;
			break;
		case 'sort_order':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
    case 'draw_template_id':
			var newValue = parseInputToMySQLUnsignedInt(tmpValue);
			inputDataFiltered = true;
			break;
		default:
			var newValue = tmpValue;
	}

	var objReturn = { inputDataFiltered: inputDataFiltered, newValue: newValue };
	return objReturn;
}

/* Contracting Entity - Start */

function addContractEntity(){
	var project_id = $('#currentlySelectedProjectId').val();
	var contract_entity = $('#contract_entity_val').val();
	var user_company_id = $('#user_company_id').val();
	var construction_license_number = $("#construction_license_number").val();
	var entity_state =$("#entity_state").val();
	if($.trim(user_company_id) == ''){
		messageAlert('User Company is required.', 'errorMessage');
		return false;
	}

	if($.trim(contract_entity) == ''){
		messageAlert('Contracting Entity is required.', 'errorMessage');
		$('#contract_entity_val').addClass('redBorderThick');
		return false;	
	}else{
		$('#contract_entity_val').removeClass('redBorderThick');
	}

	if($.trim(entity_state) == ''){
		messageAlert('License Number is required.', 'errorMessage');
		$('#entity_state').addClass('redBorderThick');
		return false;	
	}else{
		$('#entity_state').removeClass('redBorderThick');
	}

	if($.trim(construction_license_number) == ''){
		messageAlert('License Number is required.', 'errorMessage');
		$('#construction_license_number').addClass('redBorderThick');
		return false;	
	}else{
		$('#construction_license_number').removeClass('redBorderThick');
	}


	var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-ajax.php';
	$.get(ajaxHandler,{'method':'addContractEntityData','user_company_id':user_company_id,
		'entity':contract_entity,'construction_license_number':construction_license_number,'entity_state':entity_state},
		function(data){
			if($.trim(data) =='EntityExist'){
				messageAlert('Contracting Entity Already Exists.', 'errorMessage');
			}else if($.trim(data) =='1'){
				messageAlert('Contracting Entity Creation Error.', 'errorMessage');
			}else {
				var arrdata = data.split('~');
				var EntityId = arrdata[1];	
				//To select the entity that created currently			
				var optiondata = "<option value='"+EntityId+"'>"+contract_entity+", "+construction_license_number+"</option>";
				$("#manage-project-record--projects--contracting_entity_id--"+project_id).append(optiondata);
				$("#manage-project-record--projects--contracting_entity_id--"+project_id).prop('selectedIndex', -1);
				$("#manage-project-record--projects--contracting_entity_id--"+project_id+" option[value="+EntityId+"]").attr('selected', 'selected');
				//To change the contract license that currently created
				var licdata = '<input id="manage-project-record--contracting_entities--construction_license_number--'+EntityId+'" type="text" tabindex="508" value="'+construction_license_number+'" onchange="ContractingEntityUpdate(this)">';
				$('#span_contract_license').empty().append(licdata);

				var statedata = '<input id="manage-project-record--contracting_entities--state--'+EntityId+'" type="text" tabindex="509" value="'+entity_state+'" onchange="ContractingEntityUpdate(this)">';
				$('#span_contract_state').empty().append(statedata);
				
				//To close the popover
				$(".btnAddContractEntityPopover").next( "div" ).css('display',"none");
				//Can edit the entity
				$('.Contracting_Entity').attr('disabled',false);
				messageAlert('Contracting Entity Created.', 'successMessage');

			}
	});



}
//Can't edit the entity
$(document).on('click','#btnAddContractEntityPopover', function(){
	$('.Contracting_Entity').attr('disabled',true);
})
//Can edit the entity
$(document).on('click','.close-button', function(){
	$('.Contracting_Entity').attr('disabled',false);
})


/* Contracting Entity - End */

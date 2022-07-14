jQuery(document).ready(function($) {

	// @todo Add sortable column to subcontract_templates
	// @todo Refactor to pass container id via interface?
	Subcontracts__Admin__addSortableTo__SubcontractTemplates();
	Subcontracts__Admin__addSortableTo__SubcontractItemTemplates();
	$("#softwareModuleHeadline").html('Subcontracts Admin');
	$("#softwareModuleHeadline").css('display','block');

});

function Subcontracts__Admin__addSortableTo__SubcontractTemplates()
{
	var sortableContainerElementId = "#record_list_container--view-subcontract_template-record";
	$(sortableContainerElementId + " tbody").sortable({
		axis: 'y',
		distance: 10,
		//containment: sortableContainerElementId,
		helper: sortHelper,
		update: function(event, ui) {
			var element = $(ui.item)[0];
			var endIndex = $(element).index();
			endIndex = endIndex.toString();
			var options = { endIndex: endIndex };
			updateSubcontractTemplate(element, options);
		}
	});
}

function Subcontracts__Admin__addSortableTo__SubcontractItemTemplates()
{
	var sortableContainerElementId = "#record_list_container--subcontract_item_templates";
	$(sortableContainerElementId + " tbody").sortable({
		axis: 'y',
		distance: 10,
		//containment: sortableContainerElementId,
		helper: sortHelper,
		update: function(event, ui) {
			var element = $(ui.item)[0];
			var endIndex = $(element).index();
			endIndex = endIndex.toString();
			var options = { endIndex: endIndex };
			updateSubcontractItemTemplate(element, options);
		}
	});
}

function Subcontracts__Admin__addSortableTo__SubcontractTemplatesToSubcontractItemTemplates(subcontract_template_id)
{
	var sortableContainerElementId = "#record_list_container--manage-subcontract_template_to_subcontract_item_template-record--" + subcontract_template_id;
	$(sortableContainerElementId + " tbody").sortable({
		axis: 'y',
		distance: 10,
		//containment: sortableContainerElementId,
		helper: sortHelper,
		update: function(event, ui) {
			var element = $(ui.item)[0];
			var endIndex = $(element).index();
			endIndex = endIndex.toString();
			var options = { endIndex: endIndex };
			updateSubcontractTemplateToSubcontractItemTemplate(element, options);
		}
	});
}

/*
// @todo Is this in use here?
var fixHelper = function(e, tr)
{
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function(index)
    {
      $(this).width($originals.eq(index).width() + 1);
      $(this).css("border-top", "solid 1px black");
      if (index == 0) {
      	$(this).css("border-left", "solid 1px black");
      }
    });
    return $helper;
};
*/

function Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Template(element, javaScriptEvent)
{
	try {

		trapJavaScriptEvent(javaScriptEvent);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Template';
		var ajaxQueryString = '';
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
			success: Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Template_Success,
			error: errorHandler
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Template_Success(data, textStatus, jqXHR)
{
	try {

		$("#divModalWindow").html(data);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			height: 350,
			width: 550,
			modal: true,
			title: 'Create Subcontract Template',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$("#divModalWindow").addClass('hidden');
				$("#divModalWindow").html('');
			},
			buttons: {
				'Create Subcontract Template': function() {
					try {
						var options = { promiseChain: true, responseDataType: 'json' };
						var promise = createSubcontractTemplate('create-subcontract_template-record', 'dummy', options);
						promise.then(function(json) {

							errorNumber = json.errorNumber;
							if (errorNumber == 0) {
								Subcontracts__Admin__loadSubcontractTemplateRecords();
								var dummyId = json.dummyId;
								$("#record_creation_form_container--create-subcontract_template-record--"+dummyId)[0].reset();
								$("#divModalWindow").dialog('close');
							}

						});
					} catch (error) {
						$(this).dialog('close');
					}
				},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template(subcontract_template_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template';
		var ajaxQueryString =
			'subcontract_template_id=' + encodeURIComponent(subcontract_template_id);
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
			success: Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template_Success,
			error: errorHandler
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template_Success(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var html = json.html;
		var subcontract_template_id = json.subcontract_template_id;

		$("#divModalWindow").html(html);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			height: $(window).height() * 0.99,
			width: 1050,
			modal: true,
			title: 'Subcontract Template Details',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$( this ).dialog('destroy');
				$("#divModalWindow").addClass('hidden');
				$("#divModalWindow").html('');
			},
			buttons: {
				'Close': function() {
					$("#divModalWindow").dialog('close');
				}
			}
		});

		createUploaders();
		Subcontracts__Admin__addSortableTo__SubcontractTemplatesToSubcontractItemTemplates(subcontract_template_id);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Item_Template(element, javaScriptEvent)
{
	try {

		trapJavaScriptEvent(javaScriptEvent);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Item_Template';
		var ajaxQueryString = '';
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
			success: Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Item_Template_Success,
			error: errorHandler
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__Modal_Dialog__Create_Subcontract_Item_Template_Success(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var content = json.content;
		var subcontract_item_template_id = json.subcontract_item_template_id;
		var attributeGroupName = json.attributeGroupName;

		$("#divModalWindow").html(content);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			height: 600,
			width: 600,
			modal: true,
			title: 'Create Subcontract Item Template',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$("#divModalWindow").addClass('hidden');
				$("#divModalWindow").html('');
			},
			buttons: {
				'Create Subcontract Item Template': function() {
					try {
						var options = { performRefreshOperation: 'N', promiseChain: true, responseDataType: 'json' };
						var promise = createSubcontractItemTemplate(attributeGroupName, subcontract_item_template_id, options);
						promise.then(function(json) {

							errorNumber = json.errorNumber;
							if (errorNumber == 0) {
								Subcontracts__Admin__loadSubcontractItemTemplateRecords();
								$("#divModalWindow").dialog('close');
							}

						});
					} catch (error) {
						$(this).dialog('close');
					}
				},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

		createUploaders();
		toggleSubcontractItemTemplateFormRows();

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Item_Template(subcontract_item_template_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Item_Template';
		var ajaxQueryString =
			'subcontract_item_template_id=' + encodeURIComponent(subcontract_item_template_id);
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
			success: Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Item_Template_Success,
			error: errorHandler
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Item_Template_Success(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var content = json.content;
		var attributeGroupName = json.attributeGroupName;
		var subcontract_item_template_id = json.subcontract_item_template_id;

		$("#divModalWindow").html(content);
		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").dialog({
			height: 600,
			width: 600,
			modal: true,
			title: 'Subcontract Item Template Details',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).dialog('destroy');
				$("#divModalWindow").addClass('hidden');
				$("#divModalWindow").html('');
			},
			buttons: {
				'Save Changes': function() {
					try {
						var options = { performRefreshOperation: 'N', promiseChain: true, responseDataType: 'json' };
						var promise = updateAllSubcontractItemTemplateAttributes(attributeGroupName, subcontract_item_template_id, options);
						promise.then(function(json) {

							errorNumber = json.errorNumber;
							if (errorNumber == 0) {
								Subcontracts__Admin__loadSubcontractItemTemplateRecords();
								$("#divModalWindow").dialog('close');
							}

						});
					} catch (error) {
						$(this).dialog('close');
					}
				},
				'Cancel': function() {
					$(this).dialog('close');
				}
			}
		});

		createUploaders();
		toggleSubcontractItemTemplateFormRows();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__loadSubcontractTemplateRecords()
{
	try {

		var options = options || {};
		options.responseDataType = 'json';

		var attributeGroupName = 'manage-subcontract_templates-record';

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=Subcontracts__Admin__loadSubcontractTemplateRecords';
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var optionsObjectIsEmpty = $.isEmptyObject(options);
		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options){
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

		// Optional additional attribute values passed in via the options object
		//var optional_attribute = options.optional_attribute;
		//if (optional_attribute) {
		//	ajaxQueryString = ajaxQueryString + '&optional_attribute=' + encodeURIComponent(optional_attribute);
		//}

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: Subcontracts__Admin__loadSubcontractTemplateRecords_Success,
			error: errorHandler
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__loadSubcontractTemplateRecords_Success(data, textStatus, jqXHR)
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

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var htmlRecordList = json.htmlRecordList;
				$("#record_list_container--view-subcontract_template-record tbody").html(htmlRecordList);
				//Subcontracts__Admin__addSortableTo__SubcontractTemplates();
			}

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__loadSubcontractItemTemplateRecords()
{
	try {

		var options = options || {};
		options.responseDataType = 'json';

		var attributeGroupName = 'manage-subcontract_templates-record';

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=Subcontracts__Admin__loadSubcontractItemTemplateRecords';
		var ajaxQueryString =
			'attributeGroupName=' + encodeURIComponent(attributeGroupName);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var optionsObjectIsEmpty = $.isEmptyObject(options);
		if (optionsObjectIsEmpty) {
			var skipDefaultSuccessCallback = false;
		} else {
			if ('skipDefaultSuccessCallback' in options){
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

		// Optional additional attribute values passed in via the options object
		//var optional_attribute = options.optional_attribute;
		//if (optional_attribute) {
		//	ajaxQueryString = ajaxQueryString + '&optional_attribute=' + encodeURIComponent(optional_attribute);
		//}

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: Subcontracts__Admin__loadSubcontractItemTemplateRecords_Success,
			error: errorHandler
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Subcontracts__Admin__loadSubcontractItemTemplateRecords_Success(data, textStatus, jqXHR)
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

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var htmlRecordList = json.htmlRecordList;
				$('#divSubcontractItemTemplates').html(htmlRecordList);
				Subcontracts__Admin__addSortableTo__SubcontractItemTemplates();
			}

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleFileSource()
{
	var selSource = $(".ddlFileSource").val();
	if (selSource == 0 || selSource == 2) {
		$("#rowAddFile").addClass('hidden');
		$("#rowAddTemplate").addClass('hidden');
	}else if (selSource == 1) {
		$("#rowAddFile").removeClass('hidden');
		$("#rowAddTemplate").addClass('hidden');
	} else {
		$("#rowAddFile").addClass('hidden');
		$("#rowAddTemplate").removeClass('hidden');
	}
}

function TrackSubcontractitemTemplate(subcontract_template_id, subcontract_item_template_id)
{
	var track;
	if($("#track-"+subcontract_template_id+'-'+subcontract_item_template_id).prop('checked') == true)
	{
		track = 'Y';
	}else{
		track = 'N';
	}
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=trackItemTemplate';
	var ajaxQueryString =
	'subcontract_template_id=' + encodeURIComponent(subcontract_template_id) +
	'&subcontract_item_template_id=' + encodeURIComponent(subcontract_item_template_id)+ '&track=' + encodeURIComponent(track);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function()
		{
			if(track == 'Y')
			{
				messageAlert("Successfully Tracked this Item Template", 'successMessage');
			}else
			{
				messageAlert("Successfully UnTracked this Item Template", 'successMessage');
			}
		}
	});
}

// Note: This functions is not in active use.
function toggleSubcontractTemplateToSubcontractItemTemplate(subcontract_template_id, subcontract_item_template_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=toggleSubcontractTemplateToSubcontractItemTemplate';
		var ajaxQueryString =
			'subcontract_template_id=' + encodeURIComponent(subcontract_template_id) +
			'&subcontract_item_template_id=' + encodeURIComponent(subcontract_item_template_id);
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
			success: toggleSubcontractTemplateToSubcontractItemTemplateSuccess,
			error: errorHandler
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// Note: This functions is not in active use.
function toggleSubcontractTemplateToSubcontractItemTemplateSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var subcontract_template_id = json.subcontract_template_id;


			// Put this into a separate JS function pair
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-subcontracts-ajax.php?method=loadSubcontractTemplateSummary';
			var ajaxQueryString =
				'subcontract_template_id=' + encodeURIComponent(subcontract_template_id);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			$('#record--subcontract_template_summary--subcontract_templates--' + subcontract_template_id).load(ajaxUrl);


			Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template(subcontract_template_id);
		}



	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function fileUploadedForNewSubcontractItemTemplate(arrFileManagerFiles)
{
	for (var i = 0; i < arrFileManagerFiles.length; i++) {
		var fileManagerFile = arrFileManagerFiles[i];

		var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
		var virtual_file_path      = fileManagerFile.virtual_file_path;
		var file_manager_file_id   = fileManagerFile.file_manager_file_id;
		var virtual_file_name      = fileManagerFile.virtual_file_name;
		var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
		var fileUrl                = fileManagerFile.fileUrl;

		var uniqueId = $("#subcontract_item_template_id").val();

		var file_manager_file_id_element_id = 'create-subcontract_item_template-record--subcontract_item_templates--file_manager_file_id--' + uniqueId;
		var file_manager_file_id_element = $("#" + file_manager_file_id_element_id);
		file_manager_file_id_element.val(file_manager_file_id);

		var file_manager_file_element_id = 'create-subcontract_item_template-record--subcontract_item_templates--file_manager_file--' + uniqueId;
		var file_manager_file_element = $("#" + file_manager_file_element_id)
		file_manager_file_element.html(virtual_file_name);
		file_manager_file_element.prop('href', fileUrl);
	}
}

function fileUploadedForExistingSubcontractItemTemplate(arrFileManagerFiles)
{
	for (var i = 0; i < arrFileManagerFiles.length; i++) {
		var fileManagerFile = arrFileManagerFiles[i];

		var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
		var virtual_file_path      = fileManagerFile.virtual_file_path;
		var file_manager_file_id   = fileManagerFile.file_manager_file_id;
		var virtual_file_name      = fileManagerFile.virtual_file_name;
		var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
		var fileUrl                = fileManagerFile.fileUrl;

		var uniqueId = $("#subcontract_item_template_id").val();
		var file_manager_file_id_element_id = 'manage-subcontract_item_template-record--subcontract_item_templates--file_manager_file_id--' + uniqueId;
		var file_manager_file_id_element = $("#" + file_manager_file_id_element_id);
		file_manager_file_id_element.val(file_manager_file_id);

		var file_manager_file_element_id = 'manage-subcontract_item_template-record--subcontract_item_templates--file_manager_file--' + uniqueId;
		var file_manager_file_element = $("#" + file_manager_file_element_id);
		file_manager_file_element.html(virtual_file_name);
		file_manager_file_element.prop('href', fileUrl);

		// Commented out for now because this dialog currently isn't doing autosave.
		//var element = file_manager_file_element[0];
		//updateSubcontractItemTemplate(element);
	}
}

function toggleSubcontractItemTemplateFormRows()
{
	var subcontract_item_template_type = $(".ddl--subcontract_item_template_type_id").val();
	switch (subcontract_item_template_type) {
		case '':
		case 'File Uploaded During Subcontract Creation':
			$("#trFileUploader, #trUserCompanyFileTemplates").addClass('hidden');
		break;
		case 'Immutable Static Subcontract Document':
			$("#trFileUploader").removeClass('hidden');
			$("#trUserCompanyFileTemplates").addClass('hidden');
			break;
		case 'By Project Static Subcontract Document':
			$("#trFileUploader, #trUserCompanyFileTemplates").addClass('hidden');
		break;
		case 'Dynamic Template File':
			$("#trFileUploader").addClass('hidden');
			$("#trUserCompanyFileTemplates").removeClass('hidden');
		break;
	}
}

function Subcontracts__Admin__deleteSubcontractTemplate(element, javaScriptEvent, subcontract_template_id,allow)
{
	try {
		if(allow =='1')
		{
		trapJavaScriptEvent(javaScriptEvent);

		var parentTrElement = $(element).closest('tr');

		var recordContainerElementId = $(parentTrElement).attr('id');
		var attributeGroupName = recordContainerElementId.split('--')[1];
		var uniqueId = subcontract_template_id;

		var options = { responseDataType: 'json', successCallback: Subcontracts__Admin__deleteSubcontractTemplateSuccess };
		deleteSubcontractTemplate(recordContainerElementId, attributeGroupName, uniqueId, options);
	
	}else
	{
		$("#dialog-confirm").html("Templates cannot be deleted as they are used in active subcontracts.");
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			height: 200,
			width:500,
			title: "Warning",
			buttons: {
				"close": function () {
					$(this).dialog('close');

				}
			}
		});
		return;
	}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__deleteSubcontractTemplateSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			// Reload even though DOM delete works since data shows in top and bottom depending.
			// Reload Modal Dialog
			//var uniqueId = json.uniqueId;
			//var subcontract_template_id = uniqueId;

			//Subcontracts__Admin__loadSubcontractTemplateRecords();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__deleteSubcontractItemTemplate(element, javaScriptEvent, subcontract_item_template_id)
{
	try {

		trapJavaScriptEvent(javaScriptEvent);

		var parentTrElement = $(element).closest('tr');

		var recordContainerElementId = $(parentTrElement).attr('id');
		var attributeGroupName = recordContainerElementId.split('--')[1];
		var uniqueId = subcontract_item_template_id;

		var options = { responseDataType: 'json', successCallback: Subcontracts__Admin__deleteSubcontractItemTemplateSuccess };
		deleteSubcontractItemTemplate(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__deleteSubcontractItemTemplateSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			// Reload even though DOM delete works since data shows in top and bottom depending.
			// Reload Modal Dialog
			//var uniqueId = json.uniqueId;
			//var subcontract_item_template_id = uniqueId;

			//Subcontracts__Admin__loadSubcontractItemTemplateRecords();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__updateSubcontractTemplate(element)
{
	try {

		var options = { responseDataType: 'json', successCallback: Subcontracts__Admin__updateSubcontractTemplateSuccess };
		updateSubcontractTemplate(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__updateSubcontractTemplateSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var attributeName = json.attributeName;
			var newValue = json.newValue;
			var newValueText = json.newValueText;

			if (newValueText) {
				var newValueToDisplay = newValueText;
			} else {
				var newValueToDisplay = newValue;
			}

			$("#view-subcontract_template-record--subcontract_templates--" + attributeName + '--' + uniqueId).html(newValueToDisplay);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__createSubcontractTemplateToSubcontractItemTemplate(attributeGroupName, uniqueId)
{
	try {

		var options = { responseDataType: 'json', successCallback: Subcontracts__Admin__createSubcontractTemplateToSubcontractItemTemplateSuccess };

		// Composite primary key with no auto int
		if ((typeof uniqueId !== typeof undefined) && (uniqueId !== false) && (uniqueId.indexOf('-') > 0)) {

			var uniqueIdTokens = uniqueId.split('-');
			ajaxQueryString = '';

			var subcontract_template_id = uniqueIdTokens[0];
			ajaxQueryString = ajaxQueryString + '&subcontract_template_id=' + encodeURIComponent(subcontract_template_id);

			var subcontract_item_template_id = uniqueIdTokens[1];
			ajaxQueryString = ajaxQueryString + '&subcontract_item_template_id=' + encodeURIComponent(subcontract_item_template_id);

			options.adHocQueryParameters = ajaxQueryString;

		}

		createSubcontractTemplateToSubcontractItemTemplate(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__createSubcontractTemplateToSubcontractItemTemplateSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;

			// Reload Modal Dialog
			var subcontract_template_id = uniqueId.split('-')[0];
			Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template(subcontract_template_id);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__deleteSubcontractTemplateToSubcontractItemTemplate(recordContainerElementId, attributeGroupName, uniqueId)
{
	try {

		var options = { responseDataType: 'json', successCallback: Subcontracts__Admin__deleteSubcontractTemplateToSubcontractItemTemplateSuccess };
		deleteSubcontractTemplateToSubcontractItemTemplate(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Subcontracts__Admin__deleteSubcontractTemplateToSubcontractItemTemplateSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;

			// Reload even though DOM delete works since data shows in top and bottom depending.
			// Reload Modal Dialog
			var subcontract_template_id = uniqueId.split('-')[0];
			Subcontracts__Admin__Modal_Dialog__Manage_Subcontract_Template(subcontract_template_id);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

/*Initialize the database onload using ready function*/
$(document).ready(function() {
	$("#softwareModuleHeadline").html('Transmittal Admin');
	$("#softwareModuleHeadline").css('display','block');
	$("#transmittal_tmeplates-record").DataTable({
		'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		'order': [[ 0, 'desc' ]],
		'pageLength': 50,
		'pagingType': 'full_numbers',
		dom: 'Blftip',
		buttons: [
		{
			extend: 'pdfHtml5',
			download: 'open',
			exportOptions: {
				columns: [0,1,2,3,4]
			}
		},
		]
	});
});
/**
new ajax call modal dialog function for TAM
It will call the new success function to call modal dialog upon success
**/
function TAMs__loadTransmittalTemplateDialog(transmittal_admin_template_id, row_id,options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = true;
		options.successCallback = TAMs__loadTransmittalTemplateModalDialogSuccess;
		options.adHocQueryParameters = '&transmittal_admin_template_id=' + encodeURIComponent(transmittal_admin_template_id)+"&tam_sequence_id="+row_id;
		var recordContainerElementId = '';
		var attributeGroupName = 'manage-transmittal_admin_template-record';
		var uniqueId = transmittal_admin_template_id ;
		/*Load dialog content*/
		loadTransmittalAdminTemplate(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
new ajax call modal dialog sucess function for TAM
upon success: modal dialog for TAM will be displayed
**/
function TAMs__loadTransmittalTemplateModalDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var transmittal_admin_template_id = json.transmittal_admin_template_id;
			var htmlContent = json.htmlContent;
			var modalTitle = json.formattedAttributeGroupName + ' -- Details/Edit';

			UrlVars.set('transmittal_admin_template_id', transmittal_admin_template_id);
			$("#TAMsDetails").html(htmlContent);
			var template_type = $('#update-transmittal_admin-record--transmittal_admin--template_type--'+transmittal_admin_template_id).val();
			var timeout = null;

			if($("#TAMsDetails").hasClass('hidden')) {
				$("#TAMsDetails").removeClass('hidden');
			}

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.99;
			var dialogHeight = windowHeight * 0.98;

			// createUploaders();
			$("#TAMsDetails").dialog({
				height: dialogHeight,
				width: dialogWidth,
				modal: true,
				title: modalTitle,
				open: function() {
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#TAMsDetails").dialog('destroy');
					$("#TAMsDetails").html('');
					$("#TAMsDetails").addClass('hidden');
				},
				buttons: {
					'Close': function() {
						$(this).dialog('close');
					}
				}
			});
			$('.ui-dialog').removeAttr('tabindex');
			/*Initialize CKEditor using custome functions*/
			var editor = CKEDITOR.replace('TAMeditor',{ toolbar : [
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Preview', 'Print' ] },
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
				{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
				{ name: 'insert', items: [ 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak'] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
				{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
				{ name: 'styles', items: [ 'Styles', 'Format'] },
				{ name: 'styles', items: [ 'Font', 'FontSize' ] },
				{ name: 'others', items: [ '-' ] }
				], toolbarCanCollapse:false, height: '300px', scayt_sLang: 'pt_PT', uiColor : '#EBEBEB',allowedContent: true }
				);
			/*Set the default font as Helvatica*/
			CKEDITOR.config.font_defaultLabel = 'Helvetica;';
			/*Set the font list as dropdown*/
			CKEDITOR.config.font_names = 'Helvetica;'+
			'Arial, sans-serif;' +
			'Times New Roman/Times New Roman, Times, serif;' +
			'Courier New/Courier New, Courier, monospace;'+
			'Georgia/Georgia, serif;'+
			'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;'+
			'Tahoma/Tahoma, Geneva, sans-serif;'+
			'Trebuchet MS/Trebuchet MS;'+
			'Verdana, Geneva, sans-serif';
			/*Call if any changes for preview only autorefresh is enabled*/
			CKEDITOR.instances['TAMeditor'].on('change', function() {
				clearTimeout(timeout);
				timeout = setTimeout(function () {
					var value = $('#autorefresh').is(':checked');
					if(value)
					{
						LoadTAMSPDF(editor.getData(),transmittal_admin_template_id,template_type);
					}
				}, 1000);
			});
			/*load on dialog display*/
			LoadTAMSPDF(editor.getData(),transmittal_admin_template_id,template_type);
			/*click the refresh button to load pdf*/
			$('#refreshPreview').click(function(){
				LoadTAMSPDF(editor.getData(),transmittal_admin_template_id,template_type);
			});
			/*if enabled auto refresh load pdf*/
			$('#autorefresh').change(function(){
				var value = $('#autorefresh').is(':checked');
				if(value)
				{
					LoadTAMSPDF(editor.getData(),transmittal_admin_template_id,template_type);
				}
			});
			var helpHintVisible = false;
			var helpDialog = $("#dialogHelp").dialog({
				autoOpen: false,
				draggable: true,
				resizeable: true,
				resize: 'auto',
				open: function() {
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					helpHintVisible = false;
				}
			});
			// Build and open the help dialog
			$(".help-hint").on('click', function() {
				if (helpHintVisible) {
					helpHintVisible = false;
					helpDialog.dialog("close");
				} else {
					helpHintVisible = true;
					var hint = "<table><tr><td>1</td><td>.</td><td><span>Do not change or overwrite the word with in astrix(*) symbol. Ex word (*COMPANY*,*TITLE*,etc..)<span></td></tr></table>";

					$("#dialogHelp").html(hint);
					helpDialog.dialog('option', 'title', 'Notes');
					helpDialog.dialog('open');
					helpDialog.dialog('option', 'position', {
						my: 'left top',
						at: 'right bottom',
						of: this
					//of: event,
					//offset: '10 10'
				});
				}
				return false;
			});
		}
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
/*load dialog content transmittal template*/
function loadTransmittalAdminTemplate(recordContainerElementId, attributeGroupName, uniqueId, options)
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
		/*trim unwanted entites*/
		recordContainerElementId = $.trim(recordContainerElementId);
		attributeGroupName = $.trim(attributeGroupName);
		uniqueId = $.trim(uniqueId);

		if (!optionsObjectIsEmpty && options.attributeSubgroupName) {
			var attributeSubgroupName = options.attributeSubgroupName;
		} else {
			var attributeSubgroupName = 'transmittal_admin_template';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'transmittal_admin-ajax.php?method=loadTransmittalAdminTemplates';
		}
		/*Encode the data as URI*/
		var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
		var ajaxQueryString =
		'attributeGroupName=' + encodeURIComponent(attributeGroupName) +
		'&attributeSubgroupName=' + encodeURIComponent(attributeSubgroupName);

		var transmittal_admin_template_id_element_id = attributeGroupName + '--' + attributeSubgroupName + '--transmittal_admin_template--' + uniqueId;
		if ($("#" + transmittal_admin_template_id_element_id).length) {
			var transmittal_admin_template_id = $("#" + transmittal_admin_template_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&transmittal_admin_template_id=' + encodeURIComponent(transmittal_admin_template_id);
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
/*load transmittal template preview*/
function LoadTAMSPDF(editorData,transmittal_admin_template_id,template_type){
	var ajaxHandlerScript = 'transmittal_admin-PDF.php?method=loadTransmittalAdminTemplatesPDF';
	/*assign the template content*/
	var ajaxQueryString = ((editorData));
	
	$.ajax({
		url: ajaxHandlerScript,
		data: {Content : ajaxQueryString},
		type : 'POST',
		success: function (pdf) {
			$( "#contentPreview").html('<iframe width="100%" height="500px" src="data:application/pdf;base64,' + pdf + '"></object>');
			/*onclick to open the new tab template preview*/
			$('#OpenTab').click(function(){
				// window.open("data:application/pdf;base64," + pdf,'_blank');
				var html = '<iframe frameborder="0" width="100%" height="95%" allowfullscreen src="data:application/pdf;base64,' + pdf + '"></object>';
				a = window.open('data:application/pdf;base64,' + pdf);
				a.document.write(html);
				a.document.title= 'TAT #'+transmittal_admin_template_id+'--'+template_type;
				title= 'TAT #'+transmittal_admin_template_id+'--'+template_type;
				// setTimeout(function () {
				// 	a.window.stop();
				// }, 5000);
			});
		},
	});
}
(function(window){
	window.htmlentities = {
		/**
		 * Converts a string to its html characters completely.
		 *
		 * @param {String} str String with unescaped HTML characters
		 **/
		 encode : function(str) {
		 	var buf = [];

		 	for (var i=str.length-1;i>=0;i--) {
		 		buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
		 	}

		 	return buf.join('');
		 },
		/**
		 * Converts an html characterSet into its original character.
		 *
		 * @param {String} str htmlSet entities
		 **/
		 decode : function(str) {
		 	return str.replace(/&#(\d+);/g, function(match, dec) {
		 		return String.fromCharCode(dec);
		 	});
		 }
		};
	})(window);
	/*update the template*/
	function TAMs__updateTransmittalAdminTemplateViaPromiseChain(attributeGroupName, uniqueId)
	{
		try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.successCallback = RFIs__createRequestForInformationSuccess;
		// showSpinner();

		var promise = updateTransmittalAdminTemplate(attributeGroupName, uniqueId, options);

		var promiseChain = options.promiseChain;
		if (promiseChain) {
			return promise;
		}
	}
	catch (error) {
		hideSpinner();
	}
}
/**/
function updateTransmittalAdminTemplate(attributeGroupName, uniqueId, options)
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
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Transmittal Admin Template';
			htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Transmittal Admin Template';
			htmlRecordMetaAttributesOptions.defaultNewAttributeGroupName			= 'update-transmittal_admin-record';
			htmlRecordMetaAttributesOptions.attributeGroupName = attributeGroupName;
			htmlRecordMetaAttributesOptions.uniqueId = uniqueId;
			var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('update', htmlRecordMetaAttributesOptions);
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
			var attributeSubgroupName = 'transmittal_admin';
		}

		if (!optionsObjectIsEmpty && options.ajaxHandlerScript) {
			var ajaxHandlerScript = options.ajaxHandlerScript;
		} else {
			var ajaxHandlerScript = 'transmittal_admin-ajax.php?method=updateTransmittalAdmin';
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

			var typeName = escape($("#update-transmittal_admin-record--transmittal_admin--template_type--"+uniqueId).val());
			var templateContent =CKEDITOR.instances['TAMeditor'].getData();
			templateContent = escape(templateContent);
			var ajaxQueryString = ajaxQueryString + '&typeName='+typeName+'&templateContent='+templateContent;
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
			type:'POST',
			success: arrSuccessCallbacks,
			error: errorHandler,
			async:true
		});
		setTimeout(function () {
			$("#TAMsDetails").dialog('close');
			$("#TAMsDetails").dialog('destroy');
		}, 1000);


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
orig_allowInteraction = $.ui.dialog.prototype._allowInteraction;
$.ui.dialog.prototype._allowInteraction = function(event) {
	if ($(event.target).closest('.cke_dialog_background_cover').length) {
		return true;
	}
	return orig_allowInteraction.apply(this, arguments);
};

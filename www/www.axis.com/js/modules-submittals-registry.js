var suTableTrActive;

$(document).ready(function() {

	createUploaders();
	$('[data-toggle="tooltip"]').tooltip(); 
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	Submittals__addSuTableClickHandlers();
	Submittals__addDataTablesToSubmittalsListView();
	var search=window.location.search;
	if(search!='')
	{
		var id = search.split('=');
		var sub_id=id[1];
		// Submittals__loadSubmittalModalDialog(sub_id);
	}
});

function Submittals__addSuTableClickHandlers()
{
	$("#suTable tbody tr").click(function() {
		$("#suTable tbody tr").each(function(i) {
			$(this).removeClass('trActive');
		});
		$(this).addClass('trActive');
		suTableTrActive = this;
	});

	if (suTableTrActive) {
		$("#"+suTableTrActive.id).addClass('trActive');
	}
}

function Submittals__addDataTablesToSubmittalsListView()
{
	$("#record_list_container--manage-submittal-record").DataTable({
		'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		'order': [[ 0, 'desc' ]],
		'pageLength': 50,
		'pagingType': 'full_numbers'
	});
}

function Submittalsregistry__loadCreateSuDialog(element, options,id = '')
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var submittal_draft_id = '';
		if(id==''){
			if (element) {
				submittal_draft_id = $(element).val();
				if (submittal_draft_id == '-1') {
					return;
				}
				$(element).val(-1);
			}
		}else{
			submittal_draft_id = id;
		}
		

		var currentlySelectedProjectId = $('#currentlySelectedProjectId').val();
		var user_company_id = $('#currentlySelectedProjectUserCompanyId').val();
		var currentlyActiveContactId = $('#currentlyActiveContactId').val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-registry-ajax.php?method=Submittals__loadCreateSuDialog';
		var ajaxQueryString =
			'currentlySelectedProjectId=' + encodeURIComponent(currentlySelectedProjectId) +
			'&user_company_id=' + encodeURIComponent(user_company_id) +
			'&currentlyActiveContactId=' + encodeURIComponent(currentlyActiveContactId) +
			'&submittal_draft_id=' + encodeURIComponent(submittal_draft_id) +
			'&attributeGroupName=create-submittal-record' +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var arrSuccessCallbacks = [ Submittals__loadCreateSuDialogSuccess ];
		var successCallback = options.successCallback;
		if (successCallback) {
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

function Submittals__loadCreateSuDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.99;
			var dialogHeight = windowHeight * 0.98;

			$("#divCreateSuRe").html(htmlContent);
			$("#divCreateSuRe").removeClass('hidden');
			$("#divCreateSuRe").dialog({
				modal: true,
				title: 'Create A New Submittal Registry — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
				},
				close: function() {
					// $("body").removeClass('noscroll');
					// $("#divCreateSuRe").addClass('hidden');
					// $("#divCreateSuRe").dialog('destroy');
					// $("#divCreateSuRe").empty().html('');
					// window.location.reload();
				},
				buttons: {
					'Close': function() {
						window.location.reload();
						// $("#divCreateSuRe").dialog('close');
						// $("#divCreateSuRe").empty().html('');
					},
					'Reset': function() {
						$("#formCreateSu")[0].reset();
						$('.emailGroup').fSelect();
					}
				}
			});

			createUploaders();
			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
			// To sort the attachments
			$(".divslides").sortable({
				placeholder: 'divdrag-placeholder',
				axis: "y",
				revert: 150,
				start: function(e, ui){
					
					placeholderHeight = ui.item.outerHeight();
					ui.placeholder.height(placeholderHeight + 15);
					$('<div class="divdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
					
				},
				change: function(event, ui) {
					
					ui.placeholder.stop().height(0).animate({
						height: ui.item.outerHeight() + 15
					}, 300);
					
					placeholderAnimatorHeight = parseInt($(".divdrag-placeholder-animator").attr("data-height"));
					
					$(".divdrag-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
						height: 0
					}, 300, function() {
						$(this).remove();
						placeholderHeight = ui.item.outerHeight();
						$('<div class="divdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
					});
					
				},
				stop: function(e, ui) {
					
					$(".divdrag-placeholder-animator").remove();
					
				},
			});
			// for autocomplete
			$("#search_data").tokenfield({
				autocomplete :{
					source: function(request, response)
					{
						jQuery.get('submittals-ajax.php?method=fetchtags', {
							query : request.term
						}, function(data){
							if(data != 'null'){
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


		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__loadSubmittal(submittal_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = true;
		options.successCallback = Submittals__loadSubmittalSuccess;
		options.adHocQueryParameters = '&submittal_id=' + encodeURIComponent(submittal_id);

		var recordContainerElementId = '';
		var attributeGroupName = 'manage-submittal-record';
		var uniqueId = submittal_id;

		loadSubmittal(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
 * This may not be used if direct element load is used instead.
 */
function Submittals__loadSubmittalSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var submittal_id = json.submittal_id;
			var htmlContent = json.htmlContent;

			UrlVars.set('submittal_id', submittal_id);

			$("#suDetails").html(htmlContent);
			var len = $("#tableSubmittals tbody").children().length;
			if (len) {
				$("#tableSubmittals").removeClass('hidden');
			}
			createUploaders();
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
new ajax call modal dialog function for Submittal
It will call the new success function to call modal dialog upon success
**/
function Submittals__loadSubmittalModalDialog(submittal_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = true;
		options.successCallback = Submittals__loadSubmittalModalDialogSuccess;
		options.adHocQueryParameters = '&submittal_id=' + encodeURIComponent(submittal_id);

		var recordContainerElementId = '';
		var attributeGroupName = 'manage-submittal-record';
		var uniqueId = submittal_id;

		loadSubmittal(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
new ajax call modal dialog sucess function for Submittal
upon success: modal dialog for Submittal will be displayed
**/
function Submittals__loadSubmittalModalDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var submittal_id = json.submittal_id;
			var notificationId = json.notificationId;
			var htmlContent = json.htmlContent;
			var project_name = json.project_name;
			var company = json.company;
			// If the user is not having the Access then the Submittal model popup will not open
			if(htmlContent ==null) 
			{
				return;
			}
			var modalTitle = json.formattedAttributeGroupName + ' -- Details/Edit';

			UrlVars.set('submittal_id', submittal_id);

			$("#suDetails").html(htmlContent);
			if($("#suDetails").hasClass('hidden')) {
				$("#suDetails").removeClass('hidden');
			}

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.99;
			var dialogHeight = windowHeight * 0.98;

			createUploaders();
			//$("#suDetails").removeClass('hidden');
			$("#suDetails").dialog({
				height: dialogHeight,
				width: dialogWidth,
				modal: true,
				title: modalTitle+' — '+company+' — '+project_name,
				open: function() {
					$("body").addClass('noscroll');
					$(".subcont").fSelect();
					$(".subcont").on("change", function(event) { 
						Submittals__updateSuViaPromiseChain(this);
					} );
					$('.emailGroup').fSelect();
					// To update email contacts on changing it
					$(".Tosubmittalupdate").on("change", function(event) { 
						Submittals__createSubmittalRecipientHelper();
					});

				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#suDetails").dialog('destroy');
					$("#suDetails").html('');
					$("#suDetails").addClass('hidden');
					deleteTempNotes()
					deleteTempEmailBody()
		        },
		        buttons: {
		        	'Close': function() {
						$(this).dialog('close');
						deleteTempNotes()
						deleteTempEmailBody()
		        	}
		        }
			});

			//To set the notification id on load
			$("#active_submittal_notification_id").val(notificationId);
			$("#active_submittal_id").val(submittal_id);

			var len = $("#tableSubmittals tbody").children().length;
			if (len) {
				$("#tableSubmittals").removeClass('hidden');
			}
			$(".bs-tooltip").tooltip();

			//createUploaders();
			// To sort the attchment
			$( "#attachsort" ).sortable({
				change:function()
				{
						setTimeout(function(){ 
							SubmittalreArrangeSortOrder(submittal_id); }, 3000);
		
				}
			});

			// for autocomplete
			$("#search_data").tokenfield({
				autocomplete :{
					source: function(request, response)
					{
						jQuery.get('submittals-ajax.php?method=fetchtags', {
							query : request.term
						}, function(data){
							if(data != 'null'){
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

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// To reaarrange the sort order
function SubmittalreArrangeSortOrder(submittal_id)
{
	if(submittal_id == "undefined" || submittal_id==undefined){
		submittal_id = $("#active_submittal_id").val();
	}
	var attarr ={};
	var i=0;
	$( ".attachdrag" ).each(function( index ) {
		var id = this.id;
		var attchid = id.split('_');
		attarr[i] = attchid[1];
		i++;
	});
		var attacharr = JSON.stringify(attarr);

	$.ajax({
			url: window.ajaxUrlPrefix + 'modules-submittals-ajax.php',
			data:'method=reArrangeAttachment&attchment='+attacharr+'&subid='+submittal_id,
			method:'GET',
			success: function(res)
			{
				var options = options || {};
				options.promiseChain = true;
				options.responseDataType = 'json';
				
				setTimeout(function() { 
					showSpinner();
					var promise1 = Submittals__saveSuAsPdf(submittal_id,options);
					promise1.fail(function() {
						hideSpinner();
					});
					var promise2 = promise1.then(function() {
						var innerPromise = Submittals__loadSubmittalModalDialog(submittal_id);
						return innerPromise;
					});
					promise2.always(function() {
						hideSpinner();
					});					
				}, 3000);
			},
			});
	
}

function Submittals__createSuResponseViaPromiseChain(attributeGroupName, uniqueId)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#Submittals__createSuResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#Submittals__createSuResponseViaPromiseChain").attr('disabled',true);
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json' };

		showSpinner();
		var promise1 = createSubmittalResponse(attributeGroupName, uniqueId, options);

		promise1.fail(function() {
			// Debug
			//alert('promise1.fail');

			hideSpinner();
		});

		// promise2 is instantiated as a promise object via .then
		// this occurs before the promise1 ajax calls even fires since everything is asynchronous
		var promise2 = promise1.then(function(json) {
			var submittal_id = json.submittal_id;
			$("#active_submittal_id").val(submittal_id);
			// Debug
			//alert('promise1.then');

			// Inner Promise Only:
			// Any returned value other than a rejected promise will continue with subsequent .then calls
			// .fail will only be invoked if a rejected promise is returned
			var innerPromise = Submittals__saveSuAsPdfHelper(options);
			return innerPromise;
		});

		var promise3 = promise2.then(function() {
			var innerPromise = Submittals__createSubmittalNotificationHelper(options);
			return innerPromise;
		});
		var promise4 = promise3.then(function() {
			var innerPromise = Submittals__createSubmittalRecipientHelper(options);
			return innerPromise;
		});

		var promise5 = promise4.then(function() {
			var submittal_id = $("#active_submittal_id").val();
			var innerPromise = Submittals__loadSubmittal(submittal_id, options);
			return innerPromise;
		});

		// Always executes via existence of promise2 by .then returning a promise or inner function returning a promise that replaces the .then promise instance
		promise5.always(function() {
			// Debug
			//alert('promise2.always');
			hideSpinner();
		});

	} catch (error) {

		hideSpinner();

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__createSuResponseAndSendEmailViaPromiseChain(attributeGroupName, uniqueId)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#Submittals__createSuResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#Submittals__createSuResponseViaPromiseChain").attr('disabled',true);
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json', uniqueId: uniqueId };

		showSpinner();
		var promise1 = createSubmittalResponse(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function(json) {
			var submittal_id = json.submittal_id;
			$("#active_submittal_id").val(submittal_id);
			options.mail_message = $("#edit_textareaEmailBody--"+uniqueId).val();
			var innerPromise = Submittals__createSubmittalNotificationHelper(options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = Submittals__createSubmittalRecipientHelper(options);
	      	return innerPromise;
		});
		var promise4 = promise3.then(function() {
	      	var innerPromise = Submittals__saveSuAsPdfHelper(options);
			return innerPromise;
	    });
		var promise5 = promise4.then(function() {
			var innerPromise = Submittals__sendSuEmail(options);
			return innerPromise;
		});
		promise5.always(function() {
			hideSpinner();
		});

		// This function is outside of the rest of the promise chain. The loadSubmittal
		// operation is only dependent on the success of promise2. It isn't related to promise3 or promise4.
		promise4.then(function() {
			var submittal_id = $("#active_submittal_id").val();
			Submittals__loadSubmittal(submittal_id, options);
		});

	} catch (error) {

		hideSpinner();

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function fileUploader_DragEnter()
{
	//$(".boxViewUploader").show();
	//showDrag = false;
	$(".boxViewUploader").find('.qq-upload-drop-area').show();
}

function fileUploader_DragLeave()
{
	//$(".boxViewUploader").hide();
	//showDrag = true;
	$(".boxViewUploader").find('.qq-upload-drop-area').hide();
}

function Submittals__suDraftAttachmentUploaded(arrFileManagerFiles, containerElementId)
{
	try {

		var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];
			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			var csvSuFileManagerFileIds = $("#create-submittal_attachment-record--submittal_attachments--csvSuFileManagerFileIds--" + suDummyId).val();
			var arrSuFileManagerFileIds = csvSuFileManagerFileIds.split(',');
			arrSuFileManagerFileIds.push(file_manager_file_id);
			csvSuFileManagerFileIds = arrSuFileManagerFileIds.join(',');
			$("#create-submittal_attachment-record--submittal_attachments--csvSuFileManagerFileIds--" + suDummyId).val(csvSuFileManagerFileIds);

			// Remove the placeholder li.
			$("#" + containerElementId).children().each(function(i) {
				if ($(this).hasClass('placeholder')) {
					$(this).remove();
				}
			});

			var elementId = 'record_container--manage-file_manager_file-record--file_manager_files--' + file_manager_file_id;
			var htmlRecord = '' +
			'<li id="' + elementId + '"><img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">' +
			'<a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;' +
			'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a> <input class="upfileidSu" value="' + file_manager_file_id +'" type="hidden">' +
			'</li>';

			// Append the file manager file element.
			$("#" + containerElementId).append(htmlRecord);
			$(".bs-tooltip").tooltip();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// @todo Update this to support a list of files
function Submittals__postProcessSuAttachmentsViaPromiseChain(arrFileManagerFiles, containerElementId)
{
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json' };
		var attributeGroupName = 'create-submittal_attachment-record';

		if (containerElementId) {
			var ajaxQueryString = '&containerElementId=' + encodeURIComponent(containerElementId);
		} else {
			var ajaxQueryString = '';
		}

		// These are constant for the files list, so place outside the for loop
		var submittal_id = $("#submittal_id").val();
		var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();
		var su_attachment_source_contact_id = $("#create-submittal-record--submittals--su_attachment_source_contact_id--" + suDummyId).val();

		showSpinner();
		var arrPromises = [];
		var arrFileManagerFileIds = [];
		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			/*
			var dummyId = generateDummyElementId();
			var recordContainerElementId = 'record_container--create-submittal_attachment-record--submittal_attachments--sort_order--' + dummyId;
			var input1 = '<input id="create-submittal_attachment-record--submittal_attachments--submittal_id--' + dummyId + '" type="hidden" value="' + submittal_id + '">';
			var input2 = '<input id="create-submittal_attachment-record--submittal_attachments--su_attachment_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
			var input3 = '<input id="create-submittal_attachment-record--submittal_attachments--su_attachment_source_contact_id--' + dummyId + '" type="hidden" value="' + su_attachment_source_contact_id + '">';
			var li = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + input3 + '</li>';
			$("#" + containerElementId).append(li);
			*/

			arrFileManagerFileIds.push(file_manager_file_id);

			/*
			var csvSuFileManagerFileIdsElementId = attributeGroupName + '--submittal_attachments--csvSuFileManagerFileIds--' + dummyId;
			if ($("#" + csvSuFileManagerFileIdsElementId).length) {
				var csvSuFileManagerFileIds = $("#" + csvSuFileManagerFileIdsElementId).val();
				if (csvSuFileManagerFileIds.length == 0) {
					// No attachments to create.
					return;
				}
				ajaxQueryString = ajaxQueryString + '&csvSuFileManagerFileIds=' + encodeURIComponent(csvSuFileManagerFileIds);
			}
			*/
		}
		var csvSuFileManagerFileIds = arrFileManagerFileIds.join(',');
		if (csvSuFileManagerFileIds.length == 0) {
			// No attachments to create.
			return;
		} else {
			ajaxQueryString = ajaxQueryString + '&csvSuFileManagerFileIds=' + encodeURIComponent(csvSuFileManagerFileIds);
		}


		var dummyId = generateDummyElementId();
		var recordContainerElementId = 'record_container--create-submittal_attachment-record--submittal_attachments--sort_order--' + dummyId;

		var input1 = '<input id="create-submittal_attachment-record--submittal_attachments--submittal_id--' + dummyId + '" type="hidden" value="' + submittal_id + '">';
		// We are building a files list in case the uploader supports multiple concurrent file uploads in the future
		var input2 = ''; //'<input id="create-submittal_attachment-record--submittal_attachments--su_attachment_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
		var input3 = '<input id="create-submittal_attachment-record--submittal_attachments--su_attachment_source_contact_id--' + dummyId + '" type="hidden" value="' + su_attachment_source_contact_id + '">';
		var li = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + input3 + '</li>';

		$("#" + containerElementId).append(li);


		options.adHocQueryParameters = ajaxQueryString;
		//options.successCallback = Submittals__createSubmittalAttachmentSuccess;
		var promise = createSubmittalAttachment('create-submittal_attachment-record', dummyId, options);
		arrPromises.push(promise);

		var promise1 = $.when.apply($, arrPromises);
		var promise2 = promise1.then(function() {
			var innerPromise = Submittals__saveSuAsPdf(submittal_id, options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = Submittals__loadSubmittal(submittal_id, options);
			return innerPromise;
		});
		promise3.always(function() {
			hideSpinner();
		});

	} catch(error) {

		hideSpinner();
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// This function may not be in active use.
function Submittals__createSubmittalAttachmentSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			// @todo Update this to support a list of files
			var htmlRecord = json.htmlRecord;
			var containerElementId = json.containerElementId;

			$("#" + containerElementId).append(htmlRecord);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__createSuDraftViaPromiseChain(attributeGroupName, uniqueId, options)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#SuResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#SuResponseViaPromiseChain").attr('disabled',true);
	$("#createSubmittaldraft").attr('disabled',true);
	try {

		var options = options || {};
		var isErr = false;
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = 'Y';

 		showSpinner();

 		
// Submittals__createSubmittal(attributeGroupName, uniqueId, options);
 	// 	var isEmail = $("#ddl--create-submittal-record--submittals--su_recipient_contact_id--"+uniqueId).val();
		// var isNotes = $("#create-submittal-record--submittals--su_statement--"+uniqueId).val();
		// var isTitle = $("#create-submittal-record--submittals--su_title--"+uniqueId).val();
		var isEmail = $("#submittalToId").val();
		var isNotes = $("#create-submittal-record--submittals--su_statement--"+uniqueId).val();
		var isTitle = $("#create-submittal-record--submittals--su_title--"+uniqueId).val();
		var subStatus = false;
		if (isEmail == 0 && (isNotes == '' || isTitle == '') ) {
			$("#ddl--create-submittal-record--submittals--su_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
			var subStatus = true;
			isErr = true;
		}else if (isEmail == 0) {
			$("#ddl--create-submittal-record--submittals--su_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			isErr = true;
		}else if (isNotes == '' || isTitle == ''){
			isErr = true;
		}else{
			$("#ddl--create-submittal-record--submittals--su_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
			var subStatus = true;
		}
		if(isErr){  //To enable the Action button on validation error 
			$("#SuResponseAndSendEmailViaPromiseChain").removeAttr('disabled');
			$("#SuResponseViaPromiseChain").removeAttr('disabled');
			$("#createSubmittaldraft").removeAttr('disabled');
		}

		// Update case
		if (!optionsObjectIsEmpty && (options.crudOperation == 'update') && subStatus == true) {

			var crudOperation = 'update';
			var submittal_draft_id = options.submittal_draft_id;
			//options.htmlRecordMetaAttributes
			options.adHocQueryParameters = '&uniqueId=' + submittal_draft_id;
			options.htmlRecordAttributeOptions = { attributeSubgroupName: 'submittals' };
			var promise1 = updateAllSubmittalDraftAttributes(attributeGroupName, uniqueId, options);

		} else {

			// Create case
			// submittal_drafts is a clone of submittals
			var crudOperation = 'create';
			options.htmlRecordAttributeOptions = { attributeSubgroupName: 'submittals' };
			if (subStatus == true) {
				var promise1 = createSubmittalDraft(attributeGroupName, uniqueId, options);
			}

		}

		// Recreate options
		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json', skipDefaultSuccessCallback: 'Y' };

		// promise1 gets two .then success callbacks. The first one is for doing custom DOM manipulations.
		// The second one is for the ajax call that needs to be made in sequence. I separated them
		// into different callbacks because they each perform individual, disjoint actions.
		promise1.then(function(json) {
			try {

				var errorNumber = json.errorNumber;
				// 0 is okay, 2 is data already saved on server
				if ((errorNumber == 0) || (errorNumber == 2)) {
					var uniqueId = json.uniqueId;
					var htmlRecord = json.htmlRecord;
					var buttonDeleteSuDraft = json.buttonDeleteSuDraft;

					if (crudOperation == 'create') {
						// Add the Draft to DDL
						var ddlSuDrafts = $("#ddl--manage-submittal_draft-record--submittal_drafts--submittal_draft_id--dummy");
						ddlSuDrafts.append(htmlRecord);
						$("#spanDeleteSuDraft").html(buttonDeleteSuDraft);
					}

					$("#formCreateSu .redBorder").removeClass('redBorder');
					$("#active_submittal_draft_id").val(uniqueId);

					successMessage = 'Submittal Draft Successfully saved.';
					messageAlert(successMessage, 'successMessage');

				} else if (errorNumber == 1) {
					// Error
				}

			} catch (error) {

				if (window.showJSExceptions) {
					var errorMessage = error.message;
					alert('Exception Thrown: ' + errorMessage);
					return;
				}

			}
		});
		var promise2 = promise1.then(function() {
			var innerPromise = Submittals__createSubmittalDraftAttachmentHelper(options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = Submittals__reset_subDropDown();
			return innerPromise;
		});
		promise3.then(function() {
			// Close the modal dialog
			closeCreateSuDialog();
		})
		promise3.fail(function() {
		});
		promise3.always(function() {
			hideSpinner();
		});

	} catch (error) {

		hideSpinner();
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__reset_subDropDown() {

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=submittal__reset_subDropDown';

	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		success: function(data){
			$('#subDraftDropDown').empty().append(data);			
		}
	});
}

function Submittals__createSubmittalDraftAttachmentHelper(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		// submittal_draft_attachments is a clone of submittal_attachments
		options.htmlRecordAttributeOptions = { attributeSubgroupName: 'submittal_attachments' };

		var attributeGroupName = 'create-submittal_attachment-record';
		var active_submittal_draft_id = $("#active_submittal_draft_id").val();
		var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();
		$("#create-submittal_attachment-record--submittal_attachments--submittal_draft_id--" + suDummyId).val(active_submittal_draft_id);

		ajaxQueryString = '';
		var attachmentsArr = [];
		var i =0;
		$( ".upfileidSu" ).each(function( index ) {
			var upfileval = $(this).val();
	  		attachmentsArr.push(upfileval);
	  		i++;
		});
		if (attachmentsArr.length == 0) {
			// No attachments to create.
			return;
		}
		ajaxQueryString = ajaxQueryString + '&csvSuFileManagerFileIds=' + encodeURIComponent(attachmentsArr);
		options.adHocQueryParameters = ajaxQueryString;

		var promise = createSubmittalDraftAttachment(attributeGroupName, suDummyId, options);

		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__createSuReViaPromiseChain(attributeGroupName, uniqueId)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#SuResponseViaPromiseChain").attr('disabled',true);
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.successCallback = Submittals__createSubmittalSuccess;
 		showSpinner();
		var promise1 = Submittals__createSubmittal(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = Submittals__createSubmittalAttachmentHelper(options);
			return innerPromise;
		})
		var promise3 = promise2.then(function() {
			var innerPromise = Submittals__createSubmittalNotificationHelper(options);
			return innerPromise;
		})
		var promise7 = promise6.then(function() {
			closeCreateSuDialog();
		})
		promise7.fail(function() {
		})
		promise7.always(function() {
			hideSpinner();
		});
	} catch (error) {
		hideSpinner();
	}
}

function Submittals__createSuAndSendEmailViaPromiseChain(attributeGroupName, uniqueId)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#SuResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#SuResponseViaPromiseChain").attr('disabled',true);
	$("#createSubmittaldraft").attr('disabled',true);
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.uniqueId = uniqueId;
		//options.successCallback = Submittals__createSubmittalSuccess;

		showSpinner();
		var promise1 = Submittals__createSubmittal(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = Submittals__createSubmittalAttachmentHelper(options);
			return innerPromise;
		});
		
		var promise3 = promise2.then(function() {
			var innerPromise = Submittals__createSubmittalNotificationHelper(options);
			return innerPromise;
		});
		var promise4 = promise3.then(function() {
			var innerPromise = Submittals__createSubmittalRecipientHelper(options);
			return innerPromise;
		});
		var promise5 = promise4.then(function() {
			var innerPromise = Submittals__saveSuAsPdfHelper(options);
			return innerPromise;
		});
		var promise6 = promise5.then(function() {
			var innerPromise = Submittals__sendSuEmail(options);
			return innerPromise;
		});
		var promise7 = promise6.then(function() {
			var innerPromise = Submittals__deleteSubmittalDraftHelper(options);
			options.successCallback = '';
			return innerPromise;
		});
		var promise8 = promise7.then(function() {
			closeCreateSuDialog();
		});
		promise8.fail(function() {
			// Debug
			//alert('promise8.fail');
		});
		promise8.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function Submittals__createSubmittalAttachmentHelper(options)
{
	try {

		var active_submittal_id = $("#active_submittal_id").val();
		var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();
		$("#create-submittal_attachment-record--submittal_attachments--submittal_id--" + suDummyId).val(active_submittal_id);
		var ajaxQueryString = '';

		// Build the URL with a files list
		var arrFileManagerFileIds = [];
		$("#container--submittal_attachments--create-submittal-record li").each(function() {
			var elementId = this.id;
			var arrParts = elementId.split('--');
			var attributeGroupName = arrParts[0];
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];

			var file_manager_file_id = uniqueId;
			arrFileManagerFileIds.push(file_manager_file_id);
		});
		var csvSuFileManagerFileIds = arrFileManagerFileIds.join(',');
		//var csvSuFileManagerFileIds = $("#create-submittal_attachment-record--submittal_attachments--csvSuFileManagerFileIds--" + suDummyId).val();
		if (csvSuFileManagerFileIds.length == 0) {
			// No attachments to create.
			var promise = getDummyResolvedPromise();
			return promise;
		} else {
			ajaxQueryString = ajaxQueryString + '&csvSuFileManagerFileIds=' + encodeURIComponent(csvSuFileManagerFileIds);
		}
		options.adHocQueryParameters = ajaxQueryString;

		var promise = createSubmittalAttachment('create-submittal_attachment-record', suDummyId, options);

		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__saveSuAsPdfHelper(options)
{
	var active_submittal_id = $("#active_submittal_id").val();
	var promise = Submittals__saveSuAsPdf(active_submittal_id, options);

	return promise;
}

function Submittals__createSubmittalNotificationHelper(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var active_submittal_id = $("#active_submittal_id").val();
		var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();
		$("#create-submittal_notification-record--submittal_notifications--submittal_id--" + suDummyId).val(active_submittal_id);

		var promise1 = createSubmittalNotification('create-submittal_notification-record', suDummyId, options);

		promise1.then(function(json) {
			var uniqueId = json.uniqueId;
			$("#active_submittal_notification_id").val(uniqueId);
		});

		return promise1;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__createSubmittalRecipientHelper(options)
{
	var options = options || {};
	var promiseChain = options.promiseChain;

	var active_submittal_notification_id = $("#active_submittal_notification_id").val();
	var active_submittal_id = $("#active_submittal_id").val();
	var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();
	$("#create-submittal_recipient-record--submittal_recipients--submittal_notification_id--" + suDummyId).val(active_submittal_notification_id);
	var attributeGroupName = 'create-submittal_recipient-record';
	var smtp_recipient_header_type_element_id = attributeGroupName + '--submittal_recipients--smtp_recipient_header_type--' + suDummyId;
	var arrPromises = [];

	// To recipients.
        //  $("#" + smtp_recipient_header_type_element_id).val('To');
	// var to_id = $("#ddl--create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--To :selected").val();
	
	// if(to_id){
		
	// 	$.get('submittals-ajax.php',{'method':'saveAdditionalRecipient','to_id':to_id,'notification_id':active_submittal_notification_id,'submittal_id':active_submittal_id},function(data){
	// 		//console.log(data);
	// 	});
	// }
	// to recipient
	$("#" + smtp_recipient_header_type_element_id).val('To');
	
	 var arrSuRecipientIds = $("#submittalToId").val();
		if (arrSuRecipientIds !="") {
		// var csvSuRecipientIds = arrSuRecipientIds.join(',');
		// new submittal bcc recipient
		 var csvSuRecipientIds = $("#submittalToId").val();
		options.adHocQueryParameters = '&csvSuRecipientIds=' + encodeURIComponent(csvSuRecipientIds)+'&smtp_recipient_header_type='+'To';
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createSubmittalRecipient(attributeGroupName, suDummyId, options);
		arrPromises.push(promise);
	}

	// Cc recipients.
	$("#" + smtp_recipient_header_type_element_id).val('Cc');
	// var arrSuRecipientIds = [];
	// $("#record_container--submittal_recipients--Cc li input").each(function(){
	// 	arrSuRecipientIds.push($(this).val());
	// });
	 arrSuRecipientIds = $("#submittalccId").val();
	if (arrSuRecipientIds !="") {
		// old submittal cc recipients
		// var csvSuRecipientIds = arrSuRecipientIds.join(',');
		// new submittal cc recipient
		 var csvSuRecipientIds = $("#submittalccId").val();
		options.adHocQueryParameters = '&csvSuRecipientIds=' + encodeURIComponent(csvSuRecipientIds)+'&smtp_recipient_header_type='+'Cc';
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createSubmittalRecipient(attributeGroupName, suDummyId, options);
		arrPromises.push(promise);
	}

	// Bcc recipients.
	$("#" + smtp_recipient_header_type_element_id).val('Bcc');
	// arrSuRecipientIds = [];
	// $(".submittal--bcc input").each(function(){
	// 	arrSuRecipientIds.push($(this).val());
	// });
	 arrSuRecipientIds = $("#submittalbccId").val();
		if (arrSuRecipientIds !="") {
		// var csvSuRecipientIds = arrSuRecipientIds.join(',');
		// new submittal bcc recipient
		 var csvSuRecipientIds = $("#submittalbccId").val();
		options.adHocQueryParameters = '&csvSuRecipientIds=' + encodeURIComponent(csvSuRecipientIds)+'&smtp_recipient_header_type='+'Bcc';
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createSubmittalRecipient(attributeGroupName, suDummyId, options);
		arrPromises.push(promise);
	}

	options.adHocQueryParameters = '';

	if (promiseChain) {
		var promise = $.when.apply($, arrPromises);
		return promise.then(function() {
			var promise = getDummyResolvedPromise();
			return promise;
		});
	}

}

function Submittals__sendSuEmail(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		/*
		var valid = validateForm(attributeGroupName, uniqueId);
		if (!valid) {
			if (promiseChain) {
				var promise = getDummyRejectedPromise();
				return promise;
			} else {
				return;
			}
		}
		*/

		var active_submittal_notification_id = $("#active_submittal_notification_id").val();
		var dummyId = options.uniqueId;
		var emailBody = $("#textareaEmailBody--"+dummyId).val();
		if(emailBody === undefined){
			emailBody = '';
		}
		if(options.mail_message){
			emailBody = options.mail_message;
		}
		if($('#su-edit').length){
			var update=$('#su-edit').val();
		}else{
			var update='no';
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=Submittals__sendSuEmail';
		var ajaxQueryString =
			'submittal_notification_id=' + encodeURIComponent(active_submittal_notification_id) +
			'&emailBody=' + encodeURIComponent(emailBody) +
			'&updatedsubmittal=' + encodeURIComponent(update);
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
			success: Submittals__sendSuEmailSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch (error) {
		var responseText = 'An error occurred while sending the email.';
		var promise = getDummyRejectedPromise(responseText);
		return promise;
	}
}

function Submittals__sendSuEmailSuccess(data, textStatus, jqXHR)
{
	try {

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

		/*
		// @todo Make this section work for true error handling
		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			messageAlert('Email Sent', 'successMessage');
		} else {
			messageAlert(data, 'errorMessage');
		}
		*/

		messageAlert('Email Sent', 'successMessage');
		return;

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__deleteSubmittalDraftHelper(options)
{
	try {

		// @todo Verify this top code section
		var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();
		var submittal_draft_id = $("#create-submittal-record--submittals--submittal_draft_id--" + suDummyId).val();
		if (!submittal_draft_id) {
			var promise = getDummyResolvedPromise();
			return promise;
		}

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = Submittals__deleteSubmittalDraftSuccess;

		var promise = deleteSubmittalDraft('', '', submittal_draft_id, options);
		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__deleteSubmittalDraft(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = Submittals__deleteSubmittalDraftSuccess;

		var promise = deleteSubmittalDraft(recordContainerElementId, attributeGroupName, uniqueId, options);
		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__deleteSubmittalDraftSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var uniqueId = json.uniqueId;
			$("#spanDeleteSuDraft").html('');
			var form = $("#formCreateSu")[0];
			form.manualReset();
			$("#container--submittal_attachments--create-submittal-record").html('');
			$('#submittalDraftSaveBefore').empty();
			$('#submittalDraftSaveAfter').css('display','block');
			$('.fs-search').empty();
			$('.emailGroup').fSelect('reload');
			$('#record_container--submittal_recipients--Bcc').empty();
			$('#record_container--submittal_recipients--Cc').empty();

			$("#ddl--manage-submittal_draft-record--submittal_drafts--submittal_draft_id--dummy option").each(function(i) {
				var val = $(this).val();
				if (val == uniqueId) {
					$(this).remove();
				}
			});

		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function Submittals__automaticRecipient(element,html)
{
	try {

		var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();

		var ul = $('#record_container--submittal_recipients--Cc');
		var a = '<a href="#" onclick="Submittals__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id_span--' + suDummyId + '">' + html + '</span>';
		var input = '<input id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--' + suDummyId + '" type="hidden" value="' + element + '">';
		var li = '<li id="' + element + '">' + a + '&nbsp;&nbsp;' + span + input + '</li>';
		var found = ul.find('li[id='+element+']').length > 0;
		if (!found) {
			ul.append(li);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__addRecipient(element,type)
{
try {

		var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();

		// Get ul.
		var val = $("#" + element.id + " option:selected").val();
		if (val == '' || val == 0) {
			return;
		}
		var html = $("#" + element.id + " option:selected").html();
		var div = $(element).closest('div').parent().parent();
		var ul = div.find('ul');
		var a = '<a href="#" onclick="Submittals__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id_span--' + suDummyId + '">' + html + '</span>';
		var input = '<input id="create-submittal_recipient-record--submittal_recipients--su_additional_recipient_contact_id--' + suDummyId + '" type="hidden" value="' + val + '">';
		var li = '<li id="' + val + '" class="submittal--'+type+'">' + a + '&nbsp;&nbsp;' + span + input + '</li>';

		var found = ul.find('li[id='+val+']').length > 0;
		if (!found) {
			ul.append(li);
			Submittals__createSubmittalRecipientHelper();
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function submittals_isMailToError(element){
	var suDummyId = $("#create-submittal-record--submittals--dummy_id").val();
	$("#ddl--create-submittal-record--submittals--su_recipient_contact_id--"+suDummyId).parent().children(':first-child').removeClass('redBorderThick');
}

function su_isTitleError(id){
	$(".su_title_"+id).removeClass('redBorderThick');
}

function Submittals__removeRecipient(element, mail_type)
{
	try {
		if(mail_type && element.id){
			var reciptent_id = element.id;
        	$("#dialog-confirmation").html("Are you sure to delete this Recipient?");
      

			// Define the Dialog and its properties.
			$("#dialog-confirmation").dialog({
			resizable: false,
			modal: true,
			title: "Confirmation",
			width: "500",
			height: "200",
			buttons: {
			  "No": function () {
			    $(this).dialog('close');
			    $("#dialog-confirmation").html("");
			    return false;
			  },
			  "Yes": function () {
			    $(this).dialog('close');
			    var ajaxurl = window.ajaxUrlPrefix + 'submittals-ajax.php';
			    $.get(ajaxurl,{method:'delete_reciptents','reciptent_id':reciptent_id,'mail_type':mail_type},function(data){
			    	//console.log(data);
			    	$(element).parent().remove();
			    });
			  },
			}
			});

    
			
		}else{
			$(element).parent().remove();
		}
		


	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__saveSuAsPdf(submittal_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var submittal_id = parseInputToInt(submittal_id);
		if (!submittal_id) {
			submittal_id = $("#submittal_id").val();
		}
		if($('#su-edit').length)
		{
			var update=$('#su-edit').val();
		}else{
			var update='no';
		}
		// @todo Parse temp files out of a list of hidden input elements


		var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=Submittals__saveSuAsPdf';
		var ajaxQueryString =
			'submittal_id=' + encodeURIComponent(submittal_id)+
			'&updatedsubmittal=' + encodeURIComponent(update);
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
			success: Submittals__saveSuAsPdfSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__saveSuAsPdfSuccess(data, textStatus, jqXHR)
{
	try {

		messageAlert('Submittal PDF saved.', 'successMessage');
		checkSubclosedDate();

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function checkSubclosedDate(){
	var submittal_id = $("#submittal_id").val();
	var ajaxHandlerScript = 'submittals-ajax.php?method=getClosedDate';
	var ajaxQueryString =
			'&SubmittalId=' + submittal_id+
			'&attributeName=su_closed_date';
			
	var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
	var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res)
			{
				$('#manage-submittal-record--submittals--su_closed_date--'+submittal_id).html(res);
			},
		});

}

function Submittals__openSuPdfInNewTab(url)
{
	window.open(url, '_blank');
}

function Submittals__showEditSuStatement(element)
{
	$("#divEditSuStatement").removeClass('hidden');
	$("#divShowSuStatement").addClass('hidden');
}

function Submittals__cancelEditSuStatement(element)
{
	$("#divEditSuStatement").addClass('hidden');
	$("#divShowSuStatement").removeClass('hidden');
}

function Submittals__showEditSuTitle(element)
{
	$("#divEditSuTitle").removeClass('hidden');
	$("#divShowSuTitle").addClass('hidden');
}

function Submittals__cancelEditSuTitle(element)
{
	$("#divEditSuTitle").addClass('hidden');
	$("#divShowSuTitle").removeClass('hidden');
}

function Submittals__deleteSubmittalAttachmentViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var submittal_id = $("#submittal_id").val();
		showSpinner();
		var promise1 = deleteSubmittalAttachment(recordContainerElementId, attributeGroupName, uniqueId, options)
		// var promise2 = promise1.then(function() {
		// 	var innerPromise = Submittals__saveSuAsPdf(submittal_id, options);
		// 	return innerPromise;
		// });
		// var promise3 = promise2.then(function() {
		// 	var innerPromise = Submittals__loadSubmittal(submittal_id, options);
		// 	return innerPromise;
		// });
		promise1.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

// To delete attached file in draft submittal

function deleteFileManagerFileDraftAttachSubmittal(recordContainerElementId, attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var submittal_id = $("#submittal_id").val();
		showSpinner();
		var promise1 = deleteSubmittalAttachmentDraft(recordContainerElementId, attributeGroupName, uniqueId, options);
		promise1.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function closeCreateSuDialog()
{
	if ($("#divCreateSu").hasClass('ui-dialog-content')) {
		$("#divCreateSu").dialog('close');
	}
}

function Submittals__updateSuViaPromiseChain(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		if (options.submittal_status_id) {
			var submittal_status_id = options.submittal_status_id;
			if (submittal_status_id) {
				options.adHocQueryParameters = '&attributeName=submittal_status_id&newValue=' + encodeURIComponent(submittal_status_id);
			}
		}

		var uniqueId = $('#submittal_id').val();		
		var suTitle = $('.su_title_'+uniqueId).val();
		suTitle = suTitle.trim();

		if (suTitle == '') {
			$('.su_title_'+uniqueId).addClass('redBorderThick');
			return;
		}

		showSpinner();
		var promise1 = updateSubmittal(element, options);
		var promise2 = promise1.then(function(json) {
			updateSuMeetingActionItem(element, options);
			options.adHocQueryParameters = '';
			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var uniqueId = json.uniqueId;
				$("#active_submittal_id").val(uniqueId);

				var attributeGroupName = json.attributeGroupName;
				var attributeSubgroupName = json.attributeSubgroupName;
				var attributeName = json.attributeName;
				var newLabel = json.newLabel;

				var attributeLabelName = attributeName.replace('_id', '');
				var elementLabelId = attributeGroupName + '--' + attributeSubgroupName + '--' + attributeLabelName + '--' + uniqueId;
				$("#" + elementLabelId).html(newLabel);

				var innerPromise = Submittals__saveSuAsPdfHelper(options);
				return innerPromise;
			}

		});
		var promise3 = promise2.then(function() {
			var submittal_id = $("#active_submittal_id").val();
			var innerPromise = Submittals__loadSubmittal(submittal_id, options);
			return innerPromise;
		});
		promise3.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function appendSuTempFileIds(arrFileManagerFiles, options)
{
	try {

		var options = options || {};
		//options.promiseChain = true;

		$("#file-uploader-container--temp-files").show();

		var htmlAttributeGroup = options.htmlAttributeGroup;
		var tempFileUploaderElementId = options.tempFileUploaderElementId;
		var uploadedTempFilesContainerElementId = options.uploadedTempFilesContainerElementId;

		var tempFileUploadPosition = $("#temp-files-next-position--submittal_attachments").val();

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var tempFileName = fileManagerFile.tempFileName;
			var tempFileSha1 = fileManagerFile.tempFileSha1;
			var tempFilePath = fileManagerFile.tempFilePath;
			//var tempFileUploadPosition = fileManagerFile.tempFileUploadPosition;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var suAttachmentSourceContactFullName = fileManagerFile.suAttachmentSourceContactFullName;

			// Encode for HTML
			var urlEncodedTempFileName = encodeURIComponent(tempFileName);
			var encodedTempFileName = htmlEncode(tempFileName);
			var encoded_virtual_file_mime_type = htmlEncode(virtual_file_mime_type);
			var encodedSuAttachmentSourceContactFullName = htmlEncode(suAttachmentSourceContactFullName);

			/*
			var hiddenLiElement =
			' \
			<li id="' + htmlAttributeGroup + '--position--' + tempFileUploadPosition + '" \
				class="hidden" \
				tempFileName="' + encodedTempFileName + '" \
				tempFileUploadPosition="' + tempFileUploadPosition + '" \
				virtual_file_mime_type="' + encoded_virtual_file_mime_type + '"></li>';

			$("#" + uploadedTempFilesContainerElementId).append(hiddenLiElement);
			*/

			var fileUrl = '/__temp_file__?tempFileSha1=' + tempFileSha1 + '&tempFilePath=' + tempFilePath + '&tempFileName=' + urlEncodedTempFileName + '&tempFileMimeType=' + encoded_virtual_file_mime_type;
			var trElementId = 'record_container--' + htmlAttributeGroup + '--submittal_attachments--position--' + tempFileUploadPosition;

			var trElement =
			' \
			<tr id="' + trElementId + '" \
				class="record_container--uploaded-temp-file--submittal_attachments" \
				tempFileName="' + encodedTempFileName + '" \
				tempFileUploadPosition="' + tempFileUploadPosition + '" \
				virtual_file_mime_type="' + encoded_virtual_file_mime_type + '"> \
				<td width="60%"> \
					<a href="javascript:removeDomElement(\'' + trElementId + '\');">X</a> \
					<a href="' + fileUrl + '" target="_blank">' + tempFileName + '</a> \
				</td> \
				<td width="40%">' + encodedSuAttachmentSourceContactFullName + '</td> \
			</tr>';

			if (tempFileUploadPosition == 1) {
				$("#" + uploadedTempFilesContainerElementId).append(trElement);
			} else {
				$("#" + uploadedTempFilesContainerElementId + ' tr:last').after(trElement);
			}
		}

		// Update position
		var nextTempFileUploadPosition = parseInt(tempFileUploadPosition) + 1;
		$("#temp-files-next-position--submittal_attachments").val(nextTempFileUploadPosition);
		//$("#" + tempFileUploaderElementId).attr('file_upload_position', nextTempFileUploadPosition);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__generateSuTempFileListAsJsonEncodedString(htmlAttributeGroup, options)
{
	try {

		var options = options || {};
		//options.promiseChain = true;


		var arrTempFileLiElements = $("#record_container--uploaded-temp-file--submittal_attachments");

		var arrTempFileObjects = [];
		$(arrTempFileLiElements).each ( function( tmpIndex, tmpElement ) {
			var encodedTempFileName = $(tmpElement).attr('tempFileName');
			var encodedTempFileUploadPosition = $(tmpElement).attr('tempFileUploadPosition');
			var encoded_virtual_file_mime_type = $(tmpElement).attr('virtual_file_mime_type');

			// Decode for HTML
			var tempFileName = htmlDecode(tempFileName);
			var tempFileUploadPosition = htmlDecode(tempFileUploadPosition);
			var virtual_file_mime_type = htmlDecode(virtual_file_mime_type);

			// Create javascript object
			var tempFileObject = { 'tempFileName': tempFileName, 'tempFileUploadPosition': tempFileUploadPosition, 'virtual_file_mime_type': virtual_file_mime_type };

			arrTempFileObjects.push(tempFileObject);
		});

		var tempFileListAsJsonEncodedString = JSON.stringify(arrTempFileObjects);

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(tempFileListAsJsonEncodedString);
			if (continueDebug != true) {
				return;
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

function Submittals__createSubmittal(attributeGroupName, uniqueId, options)
{
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Submittals__createSubmittalSuccess;

		
		var isErr;
		var isEmail = $("#submittalToId").val();
		var isNotes = $("#create-submittal-record--submittals--su_statement--"+uniqueId).val();
		var isTitle = $("#create-submittal-record--submittals--su_title--"+uniqueId).val();
		if (isNotes == '' || isTitle == '') {
			$("#create-submittal-record--submittals--su_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
			var promise = createSubmittalRegistry(attributeGroupName, uniqueId, options);
			$isErr = 1;
		}else{
			$("#create-submittal-record--submittals--su_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
			var promise = createSubmittalRegistry(attributeGroupName, uniqueId, options);
			$isErr = 0;
		}
		if($isErr ==1)
		{
			//To enable the submit button 
		$("#SuResponseViaPromiseChain").removeAttr('disabled');
		}
		$("#SuResponseViaPromiseChain").attr('disabled',false);
		var promiseChain = options.promiseChain;
		if (promiseChain) {
			return promise;
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__createSubmittalSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var suTable = json.suTable;

			if (suTable) {
				$("#suTable").html(suTable);
			}

			Submittals__addSuTableClickHandlers();
			$("#active_submittal_id").val(uniqueId);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Submittals__performAction(element)
{
	var action = $(element).val();

	if (action == 'print_list_view_pdf') {

		// Reset the <select>
		$(element).val(-1);

		//var options = { element: element };
		//Submittals__generateSubmittalsListViewPdf(options);

		Submittals__generateSubmittalsListViewPdf();

	}

}

function Submittals__generateSubmittalsListViewPdf(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		//options.responseDataType = 'json';

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=Submittals__generateSubmittalsListViewPdf';
		var ajaxQueryString =
			'responseDataType=json';
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
			success: Submittals__generateSubmittalsListViewPdfSuccess,
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

function Submittals__generateSubmittalsListViewPdfSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var url = json.url;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(url);
				if (continueDebug != true) {
					return;
				}
			}

			document.location = url;

		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function updatecostcodeusers(val,dummy,company_id,project_id)
{
	var ajaxUrl = window.ajaxUrlPrefix + 'submittal-operations.php';
$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=costcodeusers&costcode_id='+val+'&dummy='+dummy+'&company_id='+company_id+'&project_id='+project_id,
		success:function(res)
		{
			$('#emailarea').empty().append(res);
		    $('.NotifySub').fSelect();
		}

	});
}
function Submittals__DeleteAnswer(subdeleteid,subID)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'submittals-ajax.php?method=deleteSubmittalsAnswer';
		var ajaxQueryString =
			'subdeleteid=' + encodeURIComponent(subdeleteid);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		showSpinner();
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			type: 'POST',
			data: ajaxQueryString,
			success: function(data){
				if(data){
					var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		var promise1 = Submittals__saveSuAsPdf(subID,options);
			promise1.fail(function() {
			hideSpinner();
			});
			var promise2 = promise1.then(function() {
			var innerPromise = Submittals__loadSubmittalModalDialog(subID);
			return innerPromise;
		});

		hideSpinner();
			}

				
			},
			error: errorHandler
		});
}
//To update the attachment 
function updateSubmittalAttachment(attachId){
	var attchIds=attachId.split('-');
	var subId=attchIds[0];
	var attchmentId=attchIds[1];
	var updateData='';
	if($("#attach_"+attachId).prop('checked') == true){
		updateData='y';
	}else{
		updateData='n';
	}

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=updateSubmittalAttachements';
		var ajaxQueryString =
			'submittal_id=' + encodeURIComponent(subId)+
			'&updateData=' + encodeURIComponent(updateData)+
			'&attchmentId=' + encodeURIComponent(attchmentId);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(){
				var options = options || {};
				options.promiseChain = true;
				options.responseDataType = 'json';
				
				setTimeout(function() { 
					showSpinner();
					var promise1 = Submittals__saveSuAsPdf(subId,options);
					promise1.fail(function() {
						hideSpinner();
					});
					var promise2 = promise1.then(function() {
						var innerPromise = Submittals__loadSubmittalModalDialog(subId);
						return innerPromise;
					});
					promise2.always(function() {
						hideSpinner();
					});					
				}, 3000);
			},
			error: errorHandler
		});


}
//To update the All attachment 
function selectAllSubmittal(subId){
	var updateData;
	if($("#allAttach_"+subId).prop('checked') == true){
		$(".actselect").prop('checked',true);
		updateData='y';
	}else{
		$('.actselect').removeProp('checked');
		updateData='n';
	}

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=updateAllSubmittalAttachements';
		var ajaxQueryString =
			'submittal_id=' + encodeURIComponent(subId)+
			'&updateData=' + encodeURIComponent(updateData);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(){
				var options = options || {};
				options.promiseChain = true;
				options.responseDataType = 'json';
				
				setTimeout(function() { 
					showSpinner();
					var promise1 = Submittals__saveSuAsPdf(subId,options);
					promise1.fail(function() {
						hideSpinner();
					});
					var promise2 = promise1.then(function() {
						var innerPromise = Submittals__loadSubmittalModalDialog(subId);
						return innerPromise;
					});
					promise2.always(function() {
						hideSpinner();
					});				
				}, 3000);
			},
			error: errorHandler
		});
}

/* Function to update submittal details to meeting */

function updateSuMeetingActionItem(element, options){

	var options = options || {};
	var optionsObjectIsEmpty = $.isEmptyObject(options);

	if (!optionsObjectIsEmpty && options.htmlRecordMetaAttributes) {
		var htmlRecordMetaAttributes = options.htmlRecordMetaAttributes;
	} else {
		var htmlRecordMetaAttributesOptions = {};
		htmlRecordMetaAttributesOptions.element									= element;
		htmlRecordMetaAttributesOptions.defaultFormattedAttributeGroupName		= 'Submittal';
		htmlRecordMetaAttributesOptions.defaultFormattedAttributeSubgroupName	= 'Submittals';
		htmlRecordMetaAttributesOptions.formattedAttributeName					= '';
		var htmlRecordMetaAttributes = deriveHtmlRecordMetaAttributes('update', htmlRecordMetaAttributesOptions);
	}

	var attributeName 					= htmlRecordMetaAttributes.attributeName;
	var uniqueId 						= htmlRecordMetaAttributes.uniqueId;

	var tmpValue = $(element).val();
	var objReturn = filterSubmittalHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
	var newValue = objReturn.newValue;

	var updateActionItem = false;
	var su_status_id = '';

	if (attributeName == 'su_due_date') {
		var attName = 'action_item_due_date';
		updateActionItem = true;
	}else if(attributeName == 'submittal_status_id'){
		var attName = 'action_item_completed_timestamp';
		su_status_id = newValue;
		updateActionItem = true;
	}else if(attributeName == 'su_title'){
		var attName = 'action_item';
		updateActionItem = true;
	}else{
		updateActionItem = false;
	}

	if (updateActionItem == true) {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=updateActionItemSu';
		var ajaxQueryString =
			'su_id=' + encodeURIComponent(uniqueId)+
			'&su_field_value=' + encodeURIComponent(newValue)+
			'&su_field_name=' + encodeURIComponent(attName)+
			'&su_status_id=' + encodeURIComponent(su_status_id);

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString
		});
	}
}

// Setting cookie to prevent notes section on refresh or reload
function setTempNotes(notes){
	document.cookie = "tempNotes=''";
	document.cookie = "tempNotes="+notes;
}
// Removing cookie of notes while closing modal
function deleteTempNotes(){ 
	setCookie('tempNotes', '', -1); 
}
// Setting cookie to prevent email section on refresh or reload
function setTempEmailBody(email){
	document.cookie = "tempEmailBody=''";
	document.cookie = "tempEmailBody="+email;
}
// Removing cookie of email while closing modal
function deleteTempEmailBody(){ 
	setCookie('tempEmailBody', '', -1); 
}


// to load currently selected list
function loademailcurrentlist()
{
	// To list
	var to_list = $('#submittalToId').val();
	var to_arr = to_list.split(',');
	var toid;
	for (i = 0; i < to_arr.length; i++) {
		$("#toindiv_"+to_arr[i]).prop('checked',true);
		toid +=','+to_arr[i];		
	}
	// cc list
	var cc_list = $('#submittalccId').val();
	var cc_arr = cc_list.split(',');
	var ccid;
	for (i = 0; i < cc_arr.length; i++) {
		$("#ccindiv_"+cc_arr[i]).prop('checked',true);
		ccid +=','+cc_arr[i];
	}
	// bcc list
	var bcc_list = $('#submittalbccId').val();
	var bcc_arr = bcc_list.split(',');
	var bccid;
	for (i = 0; i < bcc_arr.length; i++) {
		$("#bccindiv_"+bcc_arr[i]).prop('checked',true);
		bccid +=','+bcc_arr[i];		
	}
	$("#emailTo").val(toid);
	$("#emailCc").val(ccid);
	$("#emailBcc").val(bccid);
}

function EmailAppendList(){
	var moduleName =$('#moduleName').val();
	var arr_list = $("#submittalToId").val();
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-service-ajax.php?method=EmailListSet';
		var ajaxQueryString ='arr_list=' + arr_list +
		'&moduleName=' + moduleName +
		'&header=To';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res)
			{
				$("#toemailist").empty().append(res);
			},
		});

		arr_list = $("#submittalccId").val();
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-service-ajax.php?method=EmailListSet';
		var ajaxQueryString ='arr_list=' + arr_list +
		'&moduleName=' + moduleName +
		'&header=Cc';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res)
			{
				$("#ccemailist").empty().append(res);
			},
		});

		arr_list = $("#submittalbccId").val();
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-service-ajax.php?method=EmailListSet';
		var ajaxQueryString ='arr_list=' + arr_list +
		'&moduleName=' + moduleName +
		'&header=Bcc';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res)
			{
				$("#bccemailist").empty().append(res);
			},
		});

	
}


function AddEmailtoRespectArea()
{
	// $(".toindiv").val();
	var ToArr ="";
	var ccArr = ""
	var bccArr = "";
	$.each($(".toindiv"), function(){ 
		var toid = $('#'+this.id).is(':checked');
		if(toid == true)
		{
			var toval = this.id.split('_');
			ToArr +=  parseInt(toval[1])+"," ;
		}
  		
	});
	   ToArr= ToArr.replace(/,(\s+)?$/, ''); 
	$("#submittalToId").val(ToArr);

	$.each($(".ccindiv"), function(){ 
		var ccid = $('#'+this.id).is(':checked');
		if(ccid == true)
		{
			var ccval = this.id.split('_');
		ccArr +=  parseInt(ccval[1])+"," ;
		}
	});
	ccArr= ccArr.replace(/,(\s+)?$/, '');
	$("#submittalccId").val(ccArr);

	$.each($(".bccindiv"), function(){ 
		var bccid = $('#'+this.id).is(':checked');
		if(bccid == true)
		{
			var bccval = this.id.split('_');
		bccArr +=  parseInt(bccval[1])+"," ;
		}
	});
	bccArr= bccArr.replace(/,(\s+)?$/, '');
	$("#submittalbccId").val(bccArr);
	EmailAppendList();

}

// to save the tags alone
function Submittal__updateTag(sub_id)
{
	var sub_Tags = $("#search_data").val();
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-ajax.php?method=SubmittalUpdateTag';
	var ajaxQueryString ='sub_id=' + sub_id +
	'&sub_Tags=' + encodeURIComponent(sub_Tags) ;

	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		success: function(res)
		{
			if(res=='1')
			{
				messageAlert('Tag added successfully', 'successMessage');	
				$("#search_data-tokenfield").val('');
			}else{
				messageAlert('Tag are not added', 'errorMessage');
			}
		},
	});


}


function loadImportCostCodesIntoBudgetDialog(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var importFromProjectId = -1;
		if ($("#ddlImportProjectList").length) {
			importFromProjectId = $("#ddlImportProjectList").val();
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=loadUploadCostCode';
		var ajaxQueryString =
		'importFromProjectId=' + encodeURIComponent(importFromProjectId);
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
			success: loadImportCostCodesIntoBudgetDialogSuccess,
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


function loadImportCostCodesIntoBudgetDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divModalWindow").removeClass('hidden');
		$("#divModalWindow").html(data);
		$("#divModalWindow").dialog({
			height: 600,
			width: 1000,
			modal: true,
			title: 'Import Cost Codes',
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divModalWindow").dialog('destroy');
				$("#divModalWindow").html('');
				$("#divModalWindow").addClass('hidden');
				deleteCostCodeFile();
				$("#costCodeTemplate").val('');
        $("#costCodeTemplateErrorValid").val('');
			}
		});
		createUploaders();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}



function importCostCodesIntoBudget(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var arrCostCodeIds = [];
		$(".input-import-checkbox:checkbox:checked").each(function(i) {
			var cost_code_id = $(this).val();
			arrCostCodeIds.push(cost_code_id);
		});
		var csvCostCodeIds = arrCostCodeIds.join(',');
		var selectedCostCodeType = $("#ddlImportProjectList").val();
		selectedCostCodeType = selectedCostCodeType.split(':')[0];
		var ajaxHandler = '';
		if(selectedCostCodeType == 't_cct_id'){
			ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=importCostCodesTemplatesIntoBudget';
		}else{
			ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=importCostCodesIntoBudget';
		}

		var ajaxQueryString =
		'csvCostCodeIds=' + encodeURIComponent(csvCostCodeIds);
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
			success: importCostCodesIntoBudgetSuccess,
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

function importCostCodesIntoBudgetSuccess(data, textStatus, jqXHR)
{
	messageText = 'Items successfully imported';
	messageAlert(messageText, 'successMessage');
	window.location.reload(false);
}


//To edit the subcontract change order
function subRegistryEdit(id,stst)
{
	
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var request_for_information_draft_id = '';
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-registry-ajax.php?method=subRegistryEditDialog';
		var ajaxQueryString ='attributeGroupName=create-request-for-information-record' + '&responseDataType=json&suborderId=' + id;
			 
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// var arrSuccessCallbacks = [ suborder__editDialogSuccess ];
		// var successCallback = options.successCallback;
		// if (successCallback) {
		// 		if (typeof successCallback == 'function') {
		// 			arrSuccessCallbacks.push(successCallback);
		// 		}
		// }

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data, textStatus, jqXHR)
			{
				suborder__editDialogSuccess(data, textStatus, jqXHR,id,stst);
			},
			error: errorHandler
		});


		if (promiseChain) {
			return returnedJqXHR;
		}

	} catch(error) {
		alert(error)
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
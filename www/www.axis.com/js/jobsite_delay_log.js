var delayTableTrActive;

$(document).ready(function() {
	
	createUploaders();
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	Delays__addDelayTableClickHandlers();
	Delays__addDataTablesToDelayListView();
	$('#rfiTable').show();

});
//To  call delay grid
function load_delayGrid()
{
	var ManageDelays=$('#ManageDelays').val();
	$.ajax({
		type : "post",
		url	 :  window.ajaxUrlPrefix+"modules-jobsite-delay-logs-functions.php",
		data : "Method=loadDelay&ManageDelays="+ManageDelays,
		// cache :false,
		success :function(html)
		{
			$('#rfiTable').empty().append(html);
			createUploaders();
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	Delays__addDelayTableClickHandlers();
	Delays__addDataTablesToDelayListView();
		}
	});
	
}
//Method To generate Delays List
function Delays__addDelayTableClickHandlers()
{
	$("#rfiTable tbody tr").click(function() {
		$("#rfiTable tbody tr").each(function(i) {
			$(this).removeClass('trActive');
		});
		$(this).addClass('trActive');
		delayTableTrActive = this;
	});

	if (delayTableTrActive) {
		$("#"+delayTableTrActive.id).addClass('trActive');
	}
}
// Method to generate url for uploading files
function convertFileToDataURLviaFileReader(url,callback) {
	
  var xhr = new XMLHttpRequest();
  xhr.onload = function() {
    var reader = new FileReader();
    reader.onloadend = function() {
    	
    	callback(reader.result);
    }
    reader.readAsDataURL(xhr.response);
  };
  xhr.open('GET', url);
  xhr.responseType = 'blob';
  xhr.send();
}

//Method To generate Delays List
function Delays__addDataTablesToDelayListView()
{
var url = window.ajaxUrlPrefix +"images/logos/pdf_logo.jpg";
convertFileToDataURLviaFileReader(url,function(base64Image){
 
  console.log(base64Image);
  var table = $("#delay_list_container--manage-request_for_information-record").DataTable({
  	"initComplete": function(settings, json) {
    $(".pod_loader_img").hide();
  },
		'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		'order': [[ 0, 'desc' ]],
		'pageLength': 50,
		'pagingType': 'full_numbers',
		dom: 'Blftip',
        buttons: [
            {
                extend: 'pdfHtml5',
              
					customize: function ( doc ) {
						var cols = [];
   cols[0] = {text: 'Left part', alignment: 'left', margin:[20] };
   cols[1] = {text: 'Right part', alignment: 'right', margin:[0,0,20] };

					doc.defaultStyle.alignment = 'left',
					doc.styles.tableHeader.alignment = 'left',
					doc.defaultStyle.noWrap = false;
					doc.defaultStyle.width = '100px';
					doc.styles.title = {
					color: '#4e4e4e',
					fontSize: '16',     
					alignment: 'left'
					},   
                    doc.content.splice( 0, 0, {
                        margin: [ 0, 0, 0, 15 ],
                        alignment: 'right',
                       image:base64Image
                    } );
               },
                download: 'open',
                exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9],
            },
            orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
        columnDefs: [
   { orderable: false, targets: -1 },
   {
        targets: 7,
        render: $.fn.dataTable.render.ellipsis( 10 )
    }
],
drawCallback: function () {
                    $('[data-toggle="tooltip"]').tooltip(); 
                  $('[data-toggle="tooltip"]').hover(function(){
    $('.tooltip-inner').css('width', 'auto');
    $('.tooltip-inner').css('max-width', '250px');
}); 
                }
	});
  table.on( 'buttons-action', function ( e, buttonApi, dataTable, node, config ) {
    $(".pod_loader_img").hide();
    
} );
  // Then you'll be able to handle the myimage.png file as base64
});

	$("#record_list_container--manage-request_for_information-record").DataTable({
		'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		'order': [[ 0, 'desc' ]],
		'pageLength': 50,
		'pagingType': 'full_numbers',
		
	});
	
}
//Method will show confirm alert box
function Delays__Admin__deleteDelayTemplate(id) {
     $("#dialog-confirm").html("Are you sure want to delete?");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation",
        buttons: {
            "Yes": function () {
                $(this).dialog('close');
                callback(true,id);
            },
                "No": function () {
                $(this).dialog('close');
              
            }
        }
    });
  //   return false;
}
// Common Callback Method
function callback(value,id) {
    if (value) {
    	$(".pod_loader_img").show();
       var ajaxUrl = window.ajaxUrlPrefix + 'module-jobsite-delete-delay-data.php';
      
		
	$.ajax({
			url: ajaxUrl,
			method:'POST',
			data : {id:id},
			success: function(data){

				if (data == 1) { 
					$(".row_"+id).hide();
				messageAlert('Deleted successfully', 'successMessage');	
				$(".pod_loader_img").hide();
				setTimeout(function(){
				window.location.reload(true);
				},1000);
				}
			},
			error: errorDelaySaveHandler
		});
    } 
}

//Method For Select type in Edit Dialog Box
function select_type1(element){
	
	$.ajax({
		type : "post",
		url	 :  window.ajaxUrlPrefix+"module-jobsite-edit-delay-subcategory.php",
		data : {id:element.value},
		cache :false,
		success :function(html)
		{
			$('#subuser_type_select').html(html);
			var subcat = $("#sub_cat_id").val();
			if(subcat!='')
			$("#subuser_type_select").val(subcat);
			$("#sub_cat_id").val('');
		}
	});
}
//Method For Edit Delays
function Delays__Edit($delid){
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var request_for_information_draft_id = '';
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=Delays__editDialog';
		var ajaxQueryString =
			'request_for_information_draft_id=' + encodeURIComponent(request_for_information_draft_id) +
			'&attributeGroupName=create-request-for-information-record' +
			'&responseDataType=json&delayId=' + $delid;
			 
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var arrSuccessCallbacks = [ Delays__loadCreateDialogSuccess ];
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
		alert(error)
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// Method for Edit Delays sucess
function Delays__loadCreateDialogSuccess(data, textStatus, jqXHR)
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
			$("#divCreateRfi").html(htmlContent);
			$("#divCreateRfi").removeClass('hidden');
			$("#divCreateRfi").dialog({ 
				modal: true,
				title: 'Edit Delay Log — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateRfi").addClass('hidden');
					$("#divCreateRfi").dialog('destroy');
				},
				buttons: {
					'View Delay Log PDF': function() {
						$(".viewpdf").click();
					},
					'Close': function() {
						$("#divCreateRfi").dialog('close');
					},
					'Reset': function() {
						$("#formCreateRfi")[0].reset();
						$('.emailGroup').fSelect();
					}
				}
			});
			createUploaders();
			$("#edate").datepicker({
		minDate: 0,
		dateFormat: 'mm/dd/yy', 
		onSelect: function(selected) {
           $("#bdate").datepicker("option","maxDate", selected);
           $("#edate").removeClass('redBorderThick');
           $(".hidedays").hide();
		   $(".hide_or").hide();
		   $("#days").val('');
        }
	});

	$("#bdate").datepicker({
		minDate: 0,
		dateFormat: 'mm/dd/yy', 
		onSelect: function(selected) {
          $("#edate").datepicker("option","minDate", selected);
          $("#bdate").removeClass('redBorderThick');
        }
	});
	$('.bs-tooltip').tooltip();
			$("#user_type_select").trigger('change');
			var sta = $("#stas").val();
			$("#status").val(sta);
			var notif = $("#noti").val();
			$("#notified").val(notif);
			
			if($('.uploadedfile').length > 0){
				$('.placeholder').hide();
			}
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
		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}
// Method to display the PDF
function DelayLog__openDelayPdfInNewTab(url)
{
	if(url){
		window.open(url, '_blank');	
	}else{
		messageAlert('No PDF exists. You can generate a PDF on saving Delay.', 'errorMessage');
	}
	
}
// Method for oprn Create Delay Dialog box
function Delays__loadCreateDelayDialog(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var request_for_information_draft_id = '';
		if (element) {
			request_for_information_draft_id = $(element).val();
			if (request_for_information_draft_id == '-1') {
				return;
			}
			$(element).val(-1);
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=Delays__loadCreateRfiDialog';
		var ajaxQueryString =
			'request_for_information_draft_id=' + encodeURIComponent(request_for_information_draft_id) +
			'&attributeGroupName=create-request-for-information-record' +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var arrSuccessCallbacks = [ arrDelaySuccessCallbacks ];
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
};

// Method call when a delays function return sucess
function arrDelaySuccessCallbacks(data, textStatus, jqXHR)
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

			$("#divCreateRfi").html(htmlContent);
			$("#divCreateRfi").removeClass('hidden');
			$("#divCreateRfi").dialog({
				modal: true,
				title: 'Create A New Delay Log — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateRfi").addClass('hidden');
					$("#divCreateRfi").dialog('destroy');
				},
				buttons: {
					'Close': function() {
						$("#divCreateRfi").dialog('close');
					},
					'Reset': function() {
						$("#formCreateDelay")[0].reset();
						$('.emailGroup').fSelect();
					}
				}
			});
			createUploaders();
			$("#edate").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 ,onSelect: function(selected) {
		$("#bdate").datepicker("option","maxDate", selected);
		$("#edate").removeClass('redBorderThick');
           // hidedelay();
           $(".hidedays").hide();
           $(".hide_or").hide();
           $("#days").val('');
       }
   });
	$("#bdate").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1,onSelect: function(selected) {
		$("#edate").datepicker("option","minDate", selected);
		$("#bdate").removeClass('redBorderThick');
	} });

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
	
	
		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}
// Method calls during error 
function errorDelayHandler(err) {
	alert(err)
};

//Method to select the Type in create Dialog box
function select_type(element){
	
	$.ajax({
		type : "post",
		url	 :  window.ajaxUrlPrefix+"module-jobsite-delay-subcategory.php",
		data : {id:element.value},
		cache :false,
		success :function(html)
		{
			$('#subuser_type_select').html(html);
		}
	});
}

//Method to generate PDF in Delays Module
function pdf_generationdelay(element){
	$(".pod_loader_img").show();
	setTimeout(function(){
  $('.buttons-pdf').trigger('click');
}, 200);
}

// Method For trigger calender
function triggerCalendar(){	
	$("#bdate").datepicker("show");
}
// Method For trigger calender
function triggerEdateCalendar(){
	$("#edate").datepicker('show');
}

// Method for Uploading File through drag option
function fileUploader_DragEnter()
{
	$(".boxViewUploader").find('.qq-upload-drop-area').show();
}
// Method for Uploading File through drag option
function fileUploader_DragLeave()
{
	$(".boxViewUploader").find('.qq-upload-drop-area').hide();
}
//Method for Uploading Attachement File
function RFIs__rfiDraftAttachmentUploaded(arrFileManagerFiles, containerElementId)
{
	
	try {

		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];
			var file_manager_folder_id = fileManagerFile.file_manager_folder_id;
			var file_manager_file_id   = fileManagerFile.file_manager_file_id;
			var virtual_file_path      = fileManagerFile.virtual_file_path;
			var virtual_file_name      = fileManagerFile.virtual_file_name;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var fileUrl                = fileManagerFile.fileUrl;

			var csvRfiFileManagerFileIds = $("#create-request_for_information_attachment-record--request_for_information_attachments--csvRfiFileManagerFileIds--" + rfiDummyId).val();
			var arrRfiFileManagerFileIds = csvRfiFileManagerFileIds.split(',');
			arrRfiFileManagerFileIds.push(file_manager_file_id);
			csvRfiFileManagerFileIds = arrRfiFileManagerFileIds.join(',');
			$("#create-request_for_information_attachment-record--request_for_information_attachments--csvRfiFileManagerFileIds--" + rfiDummyId).val(csvRfiFileManagerFileIds);

			// Remove the placeholder li.
			$("#" + containerElementId).children().each(function(i) {
				if ($(this).hasClass('placeholder')) {
					$(this).remove();
				}
			});

			var elementId = 'record_container--manage-file_manager_file-record--file_manager_files--' + file_manager_file_id;
			var htmlRecord = '' +
			'<li id="' + elementId + '"><img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order">' +
				'<input type="hidden" class="upfileid" value="'+ file_manager_file_id +'" ><a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;' +
				'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>' +
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

// Method for create delay through chain
function Delays__createDelayDraftViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = 'Y';

 		showSpinner();

		// Update case
		if (!optionsObjectIsEmpty && (options.crudOperation == 'update')) {

			var crudOperation = 'update';
			var request_for_information_draft_id = options.request_for_information_draft_id;
			//options.htmlRecordMetaAttributes
			options.adHocQueryParameters = '&uniqueId=' + request_for_information_draft_id;
			options.htmlRecordAttributeOptions = { attributeSubgroupName: 'requests_for_information' };
			var promise1 = updateAllRequestForInformationDraftAttributes(attributeGroupName, uniqueId, options);

		} else {

			// Create case
			// request_for_information_drafts is a clone of requests_for_information
			var crudOperation = 'create';
			options.htmlRecordAttributeOptions = { attributeSubgroupName: 'requests_for_information' };
			var promise1 = createRequestForInformationDraft(attributeGroupName, uniqueId, options);

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
					var buttonDeleteRfiDraft = json.buttonDeleteRfiDraft;

					if (crudOperation == 'create') {
						// Add the Draft to DDL
						var ddlRfiDrafts = $("#ddl--manage-request_for_information_draft-record--request_for_information_drafts--request_for_information_draft_id--dummy");
						ddlRfiDrafts.append(htmlRecord);
						$("#spanDeleteRfiDraft").html(buttonDeleteRfiDraft);
					}

					$("#formCreateRfi .redBorder").removeClass('redBorder');
					$("#active_request_for_information_draft_id").val(uniqueId);

					successMessage = 'RFI Draft Successfully saved.';
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
			var innerPromise = Delays__createDelayDraftAttachmentHelper(options);
			return innerPromise;
		});
		promise2.then(function() {
			// Close the modal dialog
			closeCreateDelaysDialog();
		})
		promise2.fail(function() {
		});
		promise2.always(function() {
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
// Method For Delay attachment Helper
function Delays__createDelayDraftAttachmentHelper(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		// request_for_information_draft_attachments is a clone of request_for_information_attachments
		options.htmlRecordAttributeOptions = { attributeSubgroupName: 'request_for_information_attachments' };

		var attributeGroupName = 'create-request_for_information_attachment-record';
		var active_request_for_information_draft_id = $("#active_request_for_information_draft_id").val();
		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
		$("#create-request_for_information_attachment-record--request_for_information_attachments--request_for_information_draft_id--" + rfiDummyId).val(active_request_for_information_draft_id);

		ajaxQueryString = '';
		var uniqueId = rfiDummyId;
		var csvRfiFileManagerFileIdsElementId = attributeGroupName + '--request_for_information_attachments--csvRfiFileManagerFileIds--' + uniqueId;
		if ($("#" + csvRfiFileManagerFileIdsElementId).length) {
			var csvRfiFileManagerFileIds = $("#" + csvRfiFileManagerFileIdsElementId).val();
			if (csvRfiFileManagerFileIds.length == 0) {
				// No attachments to create.
				return;
			}
			ajaxQueryString = ajaxQueryString + '&csvRfiFileManagerFileIds=' + encodeURIComponent(csvRfiFileManagerFileIds);
		}
		options.adHocQueryParameters = ajaxQueryString;

		var promise = createRequestForInformationDraftAttachment(attributeGroupName, rfiDummyId, options);

		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//method to hide datepicker
function hidedelay() {
		$( ".hidedate" ).change(function() {
		$(".hidedays").hide();
		$(".hide_or").hide();
	});
	
} 
//method to hide datepicker
function hidedelay1(){
	$(".hidedays").keypress(function(){
		$(".hidedate").hide();
		$(".hide_or").hide();
		$( "#edate" ).datepicker('setDate','');

	});
}
//Method For Creating delay 
function Delays__createRfiViaPromiseChain(uniqueId,methodType){
	var element = document.getElementById("formCreateDelay");
	var formValues = {};
	var source    = $("#source_id").val();
	var category  = $("#user_type_select").val();
	var scategory = $("#subuser_type_select").val();
	var begindate = $("#bdate").val();
	var enddate   = $("#edate").val();
	var days      = $("#days").val();
	var notes     = $("#notes").val();
	var status    = $("#status").val();
	var notified  = $("#notified").val();
	var mailText = $("#textareaEmailBody").val();
	

	var emailTo = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();

	
	var attachmentsArr = {};
	var i =0;
	$( ".upfileid" ).each(function( index ) {
		var upfileval = $(this).val();
  		
  		attachmentsArr[i] =  parseInt(upfileval) ;
  		i++;
	});
	var attachments = JSON.stringify(attachmentsArr);

	var emailCcArr = {};
	var ccCount = 0;
	$( ".cc_recipients" ).each(function( index ) {
		var cc = $(this).val();
  		emailCcArr[ccCount] =  parseInt(cc) ;
  		ccCount++;
	});
	var emailCc = JSON.stringify(emailCcArr);

	var emailBCcArr = {};
	var bccCount = 0;
	$( ".bcc_recipients" ).each(function( index ) {
		var bcc = $(this).val();
  		emailBCcArr[bccCount] =  parseInt(bcc) ;
  		bccCount++;
	});
	var emailBCc = JSON.stringify(emailBCcArr);

	
	var err = false;
	if(category == '')
	{
		$("#user_type_select").addClass('redBorderThick');
		err = true;
	}
	if(scategory == ''){
		$("#subuser_type_select").addClass('redBorderThick');
		err = true;
	}else{
		$("#subuser_type_select").removeClass('redBorderThick');
		err = false;
	} 

	if(scategory == '12' || scategory == '13' || scategory == '14' ){
		if(notes == ''){
			$("#notes").addClass('redBorderThick');
			err = true;
		}
	}else{
		$("#notes").removeClass('redBorderThick');
	}

	
	if(begindate == ''){
		$("#bdate").addClass('redBorderThick');
		err = true;
	}
	var dateerr = '';
	if(enddate == '' && days == ''){
		$("#edate").addClass('redBorderThick');
		$("#days").addClass('redBorderThick');
		err = true;
		dateerr =true;
	}



	if((emailTo == '' || emailTo == 0) && ((methodType == '1') ||(methodType == '3'))){
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
		err = true;	
	}


	$( "#user_type_select" ).change(function() {
  		$("#notes").removeClass('redBorderThick');		
	});

		$( ".target" ).change(function() {
  		$("#user_type_select").removeClass('redBorderThick');		
	});
	$( ".target1" ).change(function() {
		$("#subuser_type_select").removeClass('redBorderThick');
	});
	$( "#bdate" ).change(function() {
		$("#bdate").removeClass('redBorderThick');
		
	});
	$( ".target3" ).change(function() {
		$("#edate").removeClass('redBorderThick');
		
	});

	$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).change(function(){
		var emailVal = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		if(emailVal)
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
	});
	
	$( "#notes" ).change(function() {
		$("#notes").removeClass('redBorderThick');
	});

	$( "#days" ).change(function() {
		$("#days").removeClass('redBorderThick');
	});


		
	if(err){
		

		if(dateerr){
			messageAlert('Please fill in the highlighted areas and Either fill end date or days.', 'errorMessage');
		}
		else{
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
		}
		
		
		return false;
	}else 
	{
		formValues.sourceid = element.source_id.value;
		formValues.userTypeSelectId = element.user_type_select.value;
		formValues.subuserTypeSelectId = element.subuser_type_select.value;
		formValues.bdateId=element.bdate.value;
		formValues.edateId=element.edate.value;
		formValues.daysId=element.days.value;
		formValues.notesId=element.notes.value;
		formValues.statusId=element.status.value;
		formValues.notifiedId=element.notified.value;
		formValues.delayid = element.delay_id.value;
		formValues.attachments= attachments;
		formValues.emailTo = emailTo;
		formValues.emailCc = emailCc;
		formValues.emailBCc = emailBCc;
		formValues.methodType = methodType;
		formValues.mailText = mailText;

	}
	//Confirmation box that the notice already had yes
	if(notified =='1')
	{
		$("#dialog-confirm").html("Notice of this delay has previously been sent, would you like to continue?");
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        width: "360px",
        title: "Confirmation",
        buttons: {
            "Continue": function () {
                $(this).dialog('close');
                savedelaydata(formValues);
            },
                "Cancel": function () {
                $(this).dialog('close');
              
            }
        }
    });
	}else
	{
		savedelaydata(formValues);
	}

};
function savedelaydata(formValues)
{
	$(".pod_loader_img").show();
	var ajaxUrl = window.ajaxUrlPrefix + 'modules-delay-save-ajax.php';
	$.ajax({
			url: ajaxUrl,
			data:{formValues:formValues},
			method:'POST',
			success: arrDelaySaveSuccessCallbacks,
			error: errorDelaySaveHandler
		});
}
// Method call after ajax return sucess
function arrDelaySaveSuccessCallbacks(data){
	
	if (data == 1) { 
		$(".pod_loader_img").hide();
		messageAlert('Successfully saved the record', 'successMessage');	
		setTimeout(function(){
		
		window.location.reload(true);
	},1000);
	}
	else if(data == 2){
		$(".pod_loader_img").hide();
		messageAlert('Successfully updated the record', 'successMessage');	
		setTimeout(function(){
		window.location.reload(true);
	},1000);
	} 
	else {
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');
	}
};	
// Method When ajax return Error 
function errorDelaySaveHandler(data) {
	
	 
};
// Method For Create Delay
function Delays__createDelayViaPromiseChain(attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		
 		showSpinner();

		var promise1 = Delays__createDelay(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = Delays__createDelayAttachmentHelper(options);
			return innerPromise;
		})

		var promise3 = promise2.then(function() {
			var innerPromise = Delays__saveDelayAsPdfHelper(options);
			return innerPromise;
		})

		var promise4 = promise3.then(function() {
			var innerPromise = Delays__deleteDelayDraftHelper(options);
			options.successCallback = '';
			return innerPromise;
		})
		var promise5 = promise4.then(function() {
			closeCreateDelaysDialog();
		})
		promise5.fail(function() {
		})
		promise5.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}
// Method For Delays Email
function Delays__createDelayAndSendEmailViaPromiseChain(attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		

		showSpinner();
		var promise1 = Delays__createDelay(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = Delays__createDelayAttachmentHelper(options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = Delays__saveDelayAsPdfHelper(options);
			return innerPromise;
		});
		var promise4 = promise3.then(function() {
			var innerPromise = Delays__createDelayNotificationHelper(options);
			return innerPromise;
		});
		var promise5 = promise4.then(function() {
			var innerPromise = Delays__createDelayRecipientHelper(options);
			return innerPromise;
		});
		var promise6 = promise5.then(function() {
			var innerPromise = Delays__sendDelaysEmail(options);
			return innerPromise;
		});
		var promise7 = promise6.then(function() {
			var innerPromise = Delays__deleteDelayDraftHelper(options);
			options.successCallback = '';
			return innerPromise;
		});
		var promise8 = promise7.then(function() {
			closeCreateDelaysDialog();
		});
		promise8.fail(function() {
			
		});
		promise8.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}
// Method For Delays attachment Helper
function Delays__createDelayAttachmentHelper(options)
{
	try {

		var active_request_for_information_id = $("#active_request_for_information_id").val();
		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
		$("#create-request_for_information_attachment-record--request_for_information_attachments--request_for_information_id--" + rfiDummyId).val(active_request_for_information_id);
		var ajaxQueryString = '';

		// Build the URL with a files list
		var arrFileManagerFileIds = [];
		$("#container--request_for_information_attachments--create-request_for_information-record li").each(function() {
			var elementId = this.id;
			var arrParts = elementId.split('--');
			var attributeGroupName = arrParts[0];
			var attributeSubgroupName = arrParts[1];
			var attributeName = arrParts[2];
			var uniqueId = arrParts[3];

			var file_manager_file_id = uniqueId;
			arrFileManagerFileIds.push(file_manager_file_id);
		});
		var csvRfiFileManagerFileIds = arrFileManagerFileIds.join(',');
		
		if (csvRfiFileManagerFileIds.length == 0) {
			// No attachments to create.
			var promise = getDummyResolvedPromise();
			return promise;
		} else {
			ajaxQueryString = ajaxQueryString + '&csvRfiFileManagerFileIds=' + encodeURIComponent(csvRfiFileManagerFileIds);
		}
		options.adHocQueryParameters = ajaxQueryString;

		var promise = createRequestForInformationAttachment('create-request_for_information_attachment-record', rfiDummyId, options);

		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//Method For Pdf Helper
function Delays__saveDelayAsPdfHelper(options)
{
	var active_request_for_information_id = $("#active_request_for_information_id").val();
	var promise = Delays__saveRfiAsPdf(active_request_for_information_id, options);

	return promise;
}
//Method for Notification Helper
function Delays__createDelayNotificationHelper(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var active_request_for_information_id = $("#active_request_for_information_id").val();
		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
		$("#create-request_for_information_notification-record--request_for_information_notifications--request_for_information_id--" + rfiDummyId).val(active_request_for_information_id);

		var promise1 = createRequestForInformationNotification('create-request_for_information_notification-record', rfiDummyId, options);

		promise1.then(function(json) {
			var uniqueId = json.uniqueId;
			$("#active_request_for_information_notification_id").val(uniqueId);
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
// For Delay helper method
function Delays__createDelayRecipientHelper(options)
{
	var options = options || {};
	var promiseChain = options.promiseChain;

	var active_request_for_information_notification_id = $("#active_request_for_information_notification_id").val();
	var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
	$("#create-request_for_information_recipient-record--request_for_information_recipients--request_for_information_notification_id--" + rfiDummyId).val(active_request_for_information_notification_id);
	var attributeGroupName = 'create-request_for_information_recipient-record';
	var smtp_recipient_header_type_element_id = attributeGroupName + '--request_for_information_recipients--smtp_recipient_header_type--' + rfiDummyId;
	var arrPromises = [];

	// Cc recipients.
	$("#" + smtp_recipient_header_type_element_id).val('Cc');
	var arrRfiRecipientIds = [];
	$("#record_container--request_for_information_recipients--Cc li input").each(function(i) {
		arrRfiRecipientIds.push($(this).val());
	});
	if (arrRfiRecipientIds.length) {
		var csvRfiRecipientIds = arrRfiRecipientIds.join(',');
		options.adHocQueryParameters = '&csvRfiRecipientIds=' + encodeURIComponent(csvRfiRecipientIds);
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createRequestForInformationRecipient(attributeGroupName, rfiDummyId, options);
		arrPromises.push(promise);
	}

	// Bcc recipients.
	$("#" + smtp_recipient_header_type_element_id).val('Bcc');
	arrRfiRecipientIds = [];
	$("#record_container--request_for_information_recipients--Bcc li input").each(function(i) {
		arrRfiRecipientIds.push($(this).val());
	});
	if (arrRfiRecipientIds.length) {
		var csvRfiRecipientIds = arrRfiRecipientIds.join(',');
		options.adHocQueryParameters = '&csvRfiRecipientIds=' + encodeURIComponent(csvRfiRecipientIds);
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createRequestForInformationRecipient(attributeGroupName, rfiDummyId, options);
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
//Method to send Email
function Delays__sendDelaysEmail(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var active_request_for_information_notification_id = $("#active_request_for_information_notification_id").val();
		var emailBody = $("#textareaEmailBody").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=RFIs__sendRfiEmail';
		var ajaxQueryString =
			'request_for_information_notification_id=' + encodeURIComponent(active_request_for_information_notification_id) +
			'&emailBody=' + encodeURIComponent(emailBody);
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
			success: Delays__sendDelaysEmailSuccess,
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
// Sucess function For Delays email
function Delays__sendDelaysEmailSuccess(data, textStatus, jqXHR)
{
	try {

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(data);
			if (continueDebug != true) {
				return;
			}
		}

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
//Method For Delete Delays Helper
function Delays__deleteDelayDraftHelper(options)
{
	try {

		// @todo Verify this top code section
		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
		var request_for_information_draft_id = $("#create-request_for_information-record--requests_for_information--request_for_information_draft_id--" + rfiDummyId).val();
		if (!request_for_information_draft_id) {
			var promise = getDummyResolvedPromise();
			return promise;
		}

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = Delays__deleteDelayDraftSuccess;

		var promise = deleteRequestForInformationDraft('', '', request_for_information_draft_id, options);
		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//Method For Delay draft
function Delays__deleteDelayDraft(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = Delays__deleteDelayDraftSuccess;

		var promise = deleteRequestForInformationDraft(recordContainerElementId, attributeGroupName, uniqueId, options);
		return promise;

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//Method For Delays Delete Success
function Delays__deleteDelayDraftSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var uniqueId = json.uniqueId;
			$("#spanDeleteRfiDraft").html('');
			var form = $("#formCreateRfi")[0];
			form.manualReset();
			$("#container--request_for_information_attachments--create-request_for_information-record").html('');
			$("#ddl--manage-request_for_information_draft-record--request_for_information_drafts--request_for_information_draft_id--dummy option").each(function(i) {
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
// Method To add Delays Recipient
function RFIs__addRecipient(element)
{
	try {

		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();

		// Get ul.
		var val = $("#" + element.id + " option:selected").val();
		if (val == '' || val == 0) {
			return;
		}
		var html = $("#" + element.id + " option:selected").html();
		var div = $(element).closest('div').parent().parent();
		var ul = div.find('ul');
		var ulId = $(ul).attr('id');
		var a = '<a href="#" onclick="Delays__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id_span--' + rfiDummyId + '">' + html + '</span>';
		
		if(ulId == 'record_container--request_for_information_recipients--Cc')
			var input = '<input class="cc_recipients" id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';
		else if(ulId == 'record_container--request_for_information_recipients--Bcc')
			var input = '<input class="bcc_recipients" id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';
		else
			var input = '<input id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';


		var li = '<li id="' + val + '">' + a + '&nbsp;&nbsp;' + span + input + '</li>';

		var found = ul.find('li[id='+val+']').length > 0;
		if (!found) {
			ul.append(li);
			$("#" + element.id + " option:selected").attr('disabled',true);
			$("#" + element.id).val('');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// Method To Remove Delays Recipient
function Delays__removeRecipient(element)
{
	try {

		var dummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
		var cc_dropdownId = "#ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Cc-"+dummyId;
		var bcc_dropdownId = "#ddl--create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--Bcc-"+dummyId;

		
		var ul_id = $(element).parent().parent().attr('id');
		var id = $(element).parent().attr('id');
		if(ul_id == 'record_container--request_for_information_recipients--Cc'){
			$(cc_dropdownId).find("option[value=" + id +"]").attr('disabled', false);

		}else if(ul_id == 'record_container--request_for_information_recipients--Bcc'){
			$(bcc_dropdownId).find("option[value=" + id +"]").attr('disabled', false);
		}
	    $(element).parent().remove();
	            

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// Method For save PFD in Delays 
function Delays__saveRfiAsPdf(request_for_information_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var request_for_information_id = parseInputToInt(request_for_information_id);
		if (!request_for_information_id) {
			request_for_information_id = $("#request_for_information_id").val();
		}

		// @todo Parse temp files out of a list of hidden input elements


		var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=RFIs__saveRfiAsPdf';
		var ajaxQueryString =
			'request_for_information_id=' + encodeURIComponent(request_for_information_id);
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
			success: Delays__saveDelayAsPdfSuccess,
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
// Method For sucess return in save PFD Delays 
function Delays__saveDelayAsPdfSuccess(data, textStatus, jqXHR)
{
	try {

		messageAlert('Delays PDF saved.', 'successMessage');

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//Method to close Delay Dialog Box
function closeCreateDelaysDialog()
{
	if ($("#divCreateRfi").hasClass('ui-dialog-content')) {
		$("#divCreateRfi").dialog('close');
	}
}

//Method For  create Delay
function Delays__createDelay(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Delays__createDelaySuccess;

		var promise = createRequestForInformation(attributeGroupName, uniqueId, options);

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
//Method For Delay Success
function Delays__createDelaySuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var rfiTable = json.rfiTable;

			if (rfiTable) {
				$("#rfiTable").html(rfiTable);
			}

			Delays__addDelayTableClickHandlers();
			$("#active_request_for_information_id").val(uniqueId);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

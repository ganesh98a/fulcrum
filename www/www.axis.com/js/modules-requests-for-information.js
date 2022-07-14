var rfiTableTrActive;

$(document).ready(function() {

	createUploaders();
	$('[data-toggle="tooltip"]').tooltip(); 
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	RFIs__addRfiTableClickHandlers();
	RFIs__addDataTablesToRFIListView();
	var search=window.location.search;
	if(search!='')
	{
		var id = search.split('=');
		var Rfi_id=id[1];
		RFIs__loadRequestForInformationModalDialog(Rfi_id);
	}
	

});
//To get automatic recipient
function RFIs__automaticRecipient(element,html)
{
	try {

		var suDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();

		var ul = $('#record_container--request_for_information_recipients--Cc');
		var a = '<a href="#" onclick="RFIs__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id_span--dummy_id_' + suDummyId + '">' + html + '</span>';
		var input = '<input id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--dummy_id_' + suDummyId + '" class="cc_recipients" type="hidden" value="' + element + '">';
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
function RFIs__automaticNotifySubcontractorRecipient(element,html){
	try {
		var ul = $('#cc').find('ul');
		var suDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();

		// var ul = $('#record_container--request_for_information_recipients--Cc');
		var a = '<a href="#" onclick="RFIs__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id_span--dummy_id_' + suDummyId + '">' + html + '</span>';
		var input = '<input id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--dummy_id_' + suDummyId + '" class="cc_recipients" type="hidden" value="' + element + '">';
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
function RFIs__addRfiTableClickHandlers()
{
	$("#rfiTable tbody tr").click(function() {
		$("#rfiTable tbody tr").each(function(i) {
			$(this).removeClass('trActive');
		});
		$(this).addClass('trActive');
		rfiTableTrActive = this;
	});

	if (rfiTableTrActive) {
		$("#"+rfiTableTrActive.id).addClass('trActive');
	}
}

function RFIs__addDataTablesToRFIListView()
{
	$("#record_list_container--manage-request_for_information-record").DataTable({
		'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		'order': [[ 0, 'desc' ]],
		'pageLength': 50,
		'pagingType': 'full_numbers',
		
	});
	$("#delay_list_container--manage-request_for_information-record").DataTable({
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
                columns: [0,1,2,3,4,5,6,7,8,9]
            }
            },
        ]
	});
}
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
function callback(value,id) {
    if (value) {
    	
       var ajaxUrl = window.ajaxUrlPrefix + 'module-jobsite-delete-delay-data.php';
      
		
	$.ajax({
			url: ajaxUrl,
			method:'POST',
			data : {id:id},
			success: deleteCallback,
			error: errorDelaySaveHandler
		});
    } 
}

function deleteCallback(data){
	//alert(data);
	if (data == 1) { 
		messageAlert('Deleted successfully', 'successMessage');	
		setTimeout(function(){
		//$(".ui-dialog-titlebar-close").trigger('click');
		window.location.reload(true);
	},1000);
	}
};	


function select_type1(element){
	//$("#subuser_type_select").val('');
	$.ajax({
		type : "post",
		url	 :  window.ajaxUrlPrefix+"module-jobsite-edit-delay-subcategory.php",
		data : {id:element.value},
		cache :false,
		success :function(html)
		{
			$('#subuser_type_select').html(html);
			// $("#user_type_select").trigger('change');
			var subcat = $("#sub_cat_id").val();
			if(subcat!='')
			$("#subuser_type_select").val(subcat);
			$("#sub_cat_id").val('');
		}
	});
}
function Delays__Edit($delid){
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var request_for_information_draft_id = '';
		// if (element) {
		// 	request_for_information_draft_id = $(element).val();
		// 	if (request_for_information_draft_id == '-1') {
		// 		return;
		// 	}
		// 	$(element).val(-1);
		// }

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
						$("#formCreateRfi")[0].reset();
					}
				}
			});
			createUploaders();
			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
			$("#user_type_select").trigger('change');
			var sta = $("#stas").val();
			$("#status").val(sta);
			var notif = $("#noti").val();
			$("#notified").val(notif);
			
			if($('.uploadedfile').length > 0){
				$('.placeholder').hide();
			}
		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

function Delays__loadCreateRfiDialog(element, options)
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

function RFIs__loadCreateRfiDialog(element, options,val)
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
		if(val)
		{
			request_for_information_draft_id = val;
		}
		var currentlySelectedProjectId = $('#currentlySelectedProjectId').val();
		var user_company_id = $('#currentlySelectedProjectUserCompanyId').val();
		var currentlyActiveContactId = $('#currentlyActiveContactId').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=RFIs__loadCreateRfiDialog';
		var ajaxQueryString =
			'currentlySelectedProjectId=' + encodeURIComponent(currentlySelectedProjectId) +
			'&user_company_id=' + encodeURIComponent(user_company_id) +
			'&currentlyActiveContactId=' + encodeURIComponent(currentlyActiveContactId) +
			'&request_for_information_draft_id=' + encodeURIComponent(request_for_information_draft_id) +
			'&attributeGroupName=create-request-for-information-record' +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var arrSuccessCallbacks = [ RFIs__loadCreateRfiDialogSuccess ];
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

function arrDelaySuccessCallbacks(data, textStatus, jqXHR)
{
	try {
//alert('test');
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
					}
				}
			});
			createUploaders();
		//	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
		$("#edate").datepicker({
		minDate: 0,
		dateFormat: 'mm/dd/yy', 
		onSelect: function(selected) {
           $("#bdate").datepicker("option","maxDate", selected)
        }
	});

	$("#bdate").datepicker({
		minDate: 0,
		dateFormat: 'mm/dd/yy', 
		onSelect: function(selected) {
          $("#edate").datepicker("option","minDate", selected)
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

function errorDelayHandler(err) {
	alert(err)
};
function Delays__loadCreateDelaysDialog(element){
	var ajaxUrl = window.ajaxUrlPrefix + 'modules-requests-for-information-delay-ajax.php';
	//alert("hello");
	
	$.ajax({
			url: ajaxUrl,
			success: arrDelaySuccessCallbacks,
			error: errorDelayHandler
		});
	
};
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


function pdf_generationdelay(element){

	$('.buttons-pdf').trigger('click');
}

function RFIs__loadCreateRfiDialogSuccess(data, textStatus, jqXHR)
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
				title: 'Create A New RFI — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
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
					$("#divCreateRfi").empty().html('');
				},
				buttons: {
					'Close': function() {
						$("#divCreateRfi").dialog('close');
						$("#divCreateRfi").empty().html('');
					},
					'Reset': function() {
						$("#formCreateRfi")[0].reset();
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
						jQuery.get('requests_for_information-ajax.php?method=fetchtags', {
							query : request.term
						}, function(data){
							if(data != 'null' && data != ''){
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

function triggerCalendar(){	
	$("#bdate").datepicker("show");
}
function triggerEdateCalendar(){
	$("#edate").datepicker('show');
}

function RFIs__loadRequestForInformation(request_for_information_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = true;
		options.successCallback = RFIs__loadRequestForInformationSuccess;
		options.adHocQueryParameters = '&request_for_information_id=' + encodeURIComponent(request_for_information_id);

		var recordContainerElementId = '';
		var attributeGroupName = 'manage-request_for_information-record';
		var uniqueId = request_for_information_id;

		loadRequestForInformation(recordContainerElementId, attributeGroupName, uniqueId, options);

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
function RFIs__loadRequestForInformationSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var request_for_information_id = json.request_for_information_id;
			var htmlContent = json.htmlContent;

			UrlVars.set('request_for_information_id', request_for_information_id);

			$("#rfiDetails").html(htmlContent);
			var len = $("#tableRequestsForInformation tbody").children().length;
			if (len) {
				$("#tableRequestsForInformation").removeClass('hidden');
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
new ajax call modal dialog function for RFI
It will call the new success function to call modal dialog upon success
**/
function RFIs__loadRequestForInformationModalDialog(request_for_information_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = true;
		options.successCallback = RFIs__loadRequestForInformationModalDialogSuccess;
		options.adHocQueryParameters = '&request_for_information_id=' + encodeURIComponent(request_for_information_id);

		var recordContainerElementId = '';
		var attributeGroupName = 'manage-request_for_information-record';
		var uniqueId = request_for_information_id;

		loadRequestForInformation(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/**
new ajax call modal dialog sucess function for RFI
upon success: modal dialog for RFI will be displayed
**/
function RFIs__loadRequestForInformationModalDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var request_for_information_id = json.request_for_information_id;
			var notificationId = json.notificationId;
			var htmlContent = json.htmlContent;
			var project_name = json.project_name;
			var company = json.company;
			// If the user is not having the Access then the RFI model popup will not open
			if(htmlContent ==null) 
			{
				return;
			}
			var modalTitle = json.formattedAttributeGroupName + ' -- Details/Edit';

			UrlVars.set('request_for_information_id', request_for_information_id);

			$("#rfiDetails").html(htmlContent);
			if($("#rfiDetails").hasClass('hidden')) {
				$("#rfiDetails").removeClass('hidden');
			}

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			var dialogWidth = windowWidth * 0.99;
			var dialogHeight = windowHeight * 0.98;

			createUploaders();
			//$("#rfiDetails").removeClass('hidden');
			$("#rfiDetails").dialog({
				height: dialogHeight,
				width: dialogWidth,
				modal: true,
				title: modalTitle+' — '+company+' — '+project_name,
				// title: modalTitle+' — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
					$(".ToRfiupdate").on("change", function(event) { 
						RFIs__createRequestForInformationRecipientHelper();
					});
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#rfiDetails").dialog('destroy');
					$("#rfiDetails").html('');
					$("#rfiDetails").addClass('hidden');
					Rfi_close(request_for_information_id);
					deleteTempAnswer()
					deleteTempRfiEmail()
		        },
		        buttons: {
		        	'Close': function() {
						$(this).dialog('close');
						deleteTempAnswer()
						deleteTempRfiEmail()
		        	}
		        }
			});

			//To set the notification id on load
			$("#active_request_for_information_notification_id").val(notificationId);
			$("#active_request_for_information_id").val(request_for_information_id);

			var len = $("#tableRequestsForInformation tbody").children().length;
			if (len) {
				$("#tableRequestsForInformation").removeClass('hidden');
			}
			//createUploaders();
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
						jQuery.get('requests_for_information-ajax.php?method=fetchtags', {
							query : request.term
						}, function(data){
							if(data == 'null' || data == ''){
							$("#search_null").css('display','block');	
						}else{
							$("#search_null").css('display','none');
							data = JSON.parse(data);
							response(data);
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
function reArrangeSortOrder(request_for_information_id)
{
	if(request_for_information_id == "undefined" || request_for_information_id==undefined){
		request_for_information_id = $("#active_request_for_information_id").val();
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
			url: window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php',
			data:'method=reArrangeAttachment&attchment='+attacharr+'&RFIid='+request_for_information_id,
			method:'GET',
			success: function(res)
			{
				var options = options || {};
				options.promiseChain = true;
				options.responseDataType = 'json';

				
				setTimeout(function() { 
					showSpinner();
					var promise1 =RFIs__saveRfiAsPdf(request_for_information_id, options);
							
					var promise2 = promise1.then(function() {
						var innerPromise = RFIs__loadRequestForInformation(request_for_information_id, options);
						return innerPromise;
					});
					promise2.always(function() {
						hideSpinner();
					});
				}, 3000);
			},
			});
	
}
function Rfi_close(request_for_information_id)
{
	var uri = window.location.toString();
	var clean_uri = uri.substring(0, uri.indexOf("?"))+'#';
    window.history.replaceState({}, document.title, clean_uri);
    // To get the current url and for dashboard alone need to redirect to dashboard
    var pathname = window.location.pathname.split('/');
	var pathname = pathname[1];
	if (pathname == 'dashboard.php') {
	$.ajax({
			url: window.ajaxUrlPrefix + 'dashboard-ajax.php',
			data:'method=rfichecks&rfi_id='+request_for_information_id,
			method:'POST',
			success: function(res)
			{
				var result=res.split('~');
				var prj=$("#actcurprj").val();
				if(prj != result[0])
				{

 		 navigationProjectSelected('0',result[1],result[0]); 					
				}
			},
			});
		}
}

function RFIs__createRfiResponseViaPromiseChain(attributeGroupName, uniqueId)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#RFIs__createRfiResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#RFIs__createRfiResponseViaPromiseChain").attr('disabled',true);
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json' };

		showSpinner();
		var promise1 = createRequestForInformationResponse(attributeGroupName, uniqueId, options);

		promise1.fail(function() {
			// Debug
			//alert('promise1.fail');

			hideSpinner();
		});

		// promise2 is instantiated as a promise object via .then
		// this occurs before the promise1 ajax calls even fires since everything is asynchronous
		var promise2 = promise1.then(function(json) {
			var request_for_information_id = json.request_for_information_id;
			$("#active_request_for_information_id").val(request_for_information_id);
			// Debug
			//alert('promise1.then');

			// Inner Promise Only:
			// Any returned value other than a rejected promise will continue with subsequent .then calls
			// .fail will only be invoked if a rejected promise is returned
			var innerPromise = RFIs__saveRfiAsPdfHelper(options);
			return innerPromise;
		});

		var promise3 = promise2.then(function() {
			var innerPromise = RFIs__createRequestForInformationNotificationHelper(options);
			return innerPromise;
		})
		var promise4 = promise3.then(function() {
			var innerPromise = RFIs__createRequestForInformationRecipientHelper(options);
			return innerPromise;
		})

		var promise5 = promise4.then(function() {
			var request_for_information_id = $("#active_request_for_information_id").val();
			var innerPromise = RFIs__loadRequestForInformation(request_for_information_id, options);
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

function RFIs__createRfiResponseAndSendEmailViaPromiseChain(attributeGroupName, uniqueId)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#RFIs__createRfiResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#RFIs__createRfiResponseViaPromiseChain").attr('disabled',true);
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json', uniqueId: uniqueId };

		showSpinner();
		var promise1 = createRequestForInformationResponse(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function(json) {
			var request_for_information_id = json.request_for_information_id;
			$("#active_request_for_information_id").val(request_for_information_id);
			options.mail_message = $("#edit_textareaEmailBody--"+uniqueId).val();
			var innerPromise = RFIs__createRequestForInformationNotificationHelper(options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			
			var innerPromise = RFIs__createRequestForInformationRecipientHelper(options);
			return innerPromise;
		});
		var promise4 = promise3.then(function() {
			var innerPromise = RFIs__saveRfiAsPdfHelper(options);
			return innerPromise;
		});
		var promise5 = promise4.then(function() {
			
			var innerPromise = RFIs__sendRfiEmail(options);
			return innerPromise;
		});
		promise5.always(function() {
			hideSpinner();
		});

		// This function is outside of the rest of the promise chain. The loadRequestForInformation
		// operation is only dependent on the success of promise2. It isn't related to promise3 or promise4.
		promise4.then(function() {
			var request_for_information_id = $("#active_request_for_information_id").val();
			RFIs__loadRequestForInformation(request_for_information_id, options);
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

// @todo Update this to support a list of files
function RFIs__postProcessRfiAttachmentsViaPromiseChain(arrFileManagerFiles, containerElementId)
{
	try {

		// instantiate options object via object initializer (create object using literal notation)
		var options = { promiseChain: true, responseDataType: 'json' };
		var attributeGroupName = 'create-request_for_information_attachment-record';

		if (containerElementId) {
			var ajaxQueryString = '&containerElementId=' + encodeURIComponent(containerElementId);
		} else {
			var ajaxQueryString = '';
		}

		// These are constant for the files list, so place outside the for loop
		var request_for_information_id = $("#request_for_information_id").val();
		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
		var rfi_attachment_source_contact_id = $("#create-request_for_information-record--requests_for_information--rfi_attachment_source_contact_id--" + rfiDummyId).val();

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
			var recordContainerElementId = 'record_container--create-request_for_information_attachment-record--request_for_information_attachments--sort_order--' + dummyId;
			var input1 = '<input id="create-request_for_information_attachment-record--request_for_information_attachments--request_for_information_id--' + dummyId + '" type="hidden" value="' + request_for_information_id + '">';
			var input2 = '<input id="create-request_for_information_attachment-record--request_for_information_attachments--rfi_attachment_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
			var input3 = '<input id="create-request_for_information_attachment-record--request_for_information_attachments--rfi_attachment_source_contact_id--' + dummyId + '" type="hidden" value="' + rfi_attachment_source_contact_id + '">';
			var li = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + input3 + '</li>';
			$("#" + containerElementId).append(li);
			*/

			arrFileManagerFileIds.push(file_manager_file_id);

			/*
			var csvRfiFileManagerFileIdsElementId = attributeGroupName + '--request_for_information_attachments--csvRfiFileManagerFileIds--' + dummyId;
			if ($("#" + csvRfiFileManagerFileIdsElementId).length) {
				var csvRfiFileManagerFileIds = $("#" + csvRfiFileManagerFileIdsElementId).val();
				if (csvRfiFileManagerFileIds.length == 0) {
					// No attachments to create.
					return;
				}
				ajaxQueryString = ajaxQueryString + '&csvRfiFileManagerFileIds=' + encodeURIComponent(csvRfiFileManagerFileIds);
			}
			*/
		}
		var csvRfiFileManagerFileIds = arrFileManagerFileIds.join(',');
		if (csvRfiFileManagerFileIds.length == 0) {
			// No attachments to create.
			return;
		} else {
			ajaxQueryString = ajaxQueryString + '&csvRfiFileManagerFileIds=' + encodeURIComponent(csvRfiFileManagerFileIds);
		}


		var dummyId = generateDummyElementId();
		var recordContainerElementId = 'record_container--create-request_for_information_attachment-record--request_for_information_attachments--sort_order--' + dummyId;

		var input1 = '<input id="create-request_for_information_attachment-record--request_for_information_attachments--request_for_information_id--' + dummyId + '" type="hidden" value="' + request_for_information_id + '">';
		// We are building a files list in case the uploader supports multiple concurrent file uploads in the future
		var input2 = ''; //'<input id="create-request_for_information_attachment-record--request_for_information_attachments--rfi_attachment_file_manager_file_id--' + dummyId + '" type="hidden" value="' + file_manager_file_id + '">';
		var input3 = '<input id="create-request_for_information_attachment-record--request_for_information_attachments--rfi_attachment_source_contact_id--' + dummyId + '" type="hidden" value="' + rfi_attachment_source_contact_id + '">';
		var li = '<li id="' + recordContainerElementId + '" class="hidden">' + input1 + input2 + input3 + '</li>';

		$("#" + containerElementId).append(li);


		options.adHocQueryParameters = ajaxQueryString;
		//options.successCallback = RFIs__createRequestForInformationAttachmentSuccess;
		var promise = createRequestForInformationAttachment('create-request_for_information_attachment-record', dummyId, options);
		arrPromises.push(promise);

		var promise1 = $.when.apply($, arrPromises);
		var promise2 = promise1.then(function() {
			var innerPromise = RFIs__saveRfiAsPdf(request_for_information_id, options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = RFIs__loadRequestForInformation(request_for_information_id, options);
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
function RFIs__createRequestForInformationAttachmentSuccess(data, textStatus, jqXHR)
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

function RFIs__createRfiDraftViaPromiseChain(attributeGroupName, uniqueId, options)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#RFIs__create__RfiResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#RFIs__create__RfiResponseViaPromiseChain").attr('disabled',true);
	$("#createRFidraft").attr('disabled',true);
	try {

		var options = options || {};
		var optionsObjectIsEmpty = $.isEmptyObject(options);
		var isErr = false;
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.skipDefaultSuccessCallback = 'Y';

 		showSpinner(); 		

 		var isEmail = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		var isTitle = $("#create-request_for_information-record--requests_for_information--rfi_title--"+uniqueId).val();
		var isRfiType = $("#ddl--create-request_for_information-record--requests_for_information--request_for_information_type_id--"+uniqueId).val(); 
		var isQue = $("#create-request_for_information-record--requests_for_information--rfi_statement--"+uniqueId).val();
		var rfiStatus = false;

		if (isEmail == 0 && (isTitle == '' || isRfiType == '' || isQue == '')) {
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
			var rfiStatus = true;
			isErr = true;
		}else if (isEmail == 0) {
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');
			isErr = true;
		}else if (isTitle == '' || isRfiType == '' || isQue == '') {
			isErr = true;
			var rfiStatus = true;
		}else{
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
			var rfiStatus = true;
		}

		if(isErr){ //To enable the Action button on validation error 
			$("#RFIs__create__RfiResponseAndSendEmailViaPromiseChain").removeAttr('disabled');
			$("#RFIs__create__RfiResponseViaPromiseChain").removeAttr('disabled');
			$("#createRFidraft").removeAttr('disabled');
		}

		// Update case
		if (!optionsObjectIsEmpty && (options.crudOperation == 'update') && rfiStatus == true) {

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
			if(rfiStatus == true){
				var promise1 = createRequestForInformationDraft(attributeGroupName, uniqueId, options);
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
			var innerPromise = RFIs__createRequestForInformationDraftAttachmentHelper(options);
			return innerPromise;
		});
		var promise3 = promise2.then(function() {
			var innerPromise = RFIs__reset_rfiDropDown();
			return innerPromise;
		});
		promise3.then(function() {
			// Close the modal dialog
			closeCreateRfiDialog();
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

function RFIs__reset_rfiDropDown() {

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=RFIs__reset_rfiDropDown';

	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		success: function(data){
			$('#rfiDraftDropDown').empty().append(data);			
		}
	});
}

function RFIs__createRequestForInformationDraftAttachmentHelper(options)
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
		var attachmentsArr = [];
		var i =0;
		$( ".upfileid" ).each(function( index ) {
			var upfileval = $(this).val();
	  		attachmentsArr.push(upfileval);
	  		i++;
		});
		if (attachmentsArr.length == 0) {
			// No attachments to create.
			return;
		}
		ajaxQueryString = ajaxQueryString + '&csvRfiFileManagerFileIds=' + encodeURIComponent(attachmentsArr);
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
function hidedelay() {
	$( ".hidedate" ).change(function() {
		$(".hidedays").hide();
		$(".hide_or").hide();
	});
	
} 
function hidedelay1(){
	$(".hidedays").keypress(function(){
		$(".hidedate").hide();
		$(".hide_or").hide();
	});
}

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
  		// attachmentsArr.push(upfileval);
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
	} 
	if(status == ''){
		$("#status").addClass('redBorderThick');
		err = true;
	} 
	if(notified == ''){
		$("#notified").addClass('redBorderThick');
		err = true;
	}
	
	if(begindate == '' && enddate == '' && days == ''){
		$("#bdate").addClass('redBorderThick');
		$("#edate").addClass('redBorderThick');
		err = true;
	}
	if(begindate != '' && enddate == ''){
		$("#edate").addClass('redBorderThick');
		err = true;	
	}
	if(enddate != '' && begindate == ''){
		$("#bdate").addClass('redBorderThick');
		err = true;	
	}

	if(emailTo == ''){
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).addClass('redBorderThick');
		err = true;	
	}

			
		/*$("#days").addClass('redBorderThick');
		$("#notes").addClass('redBorderThick');*/
		
	if(err){
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');
	
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
	$( ".target" ).change(function() {
  		$("#user_type_select").removeClass('redBorderThick');		
	});
	$( ".target1" ).change(function() {
		$("#subuser_type_select").removeClass('redBorderThick');
	});
	$( ".target2" ).change(function() {
		$("#bdate").removeClass('redBorderThick');
		//$("#days").hide();
		//$("$days").hide();
	});
	$( ".target3" ).change(function() {
		$("#edate").removeClass('redBorderThick');
		// $("#days").hide();
	});

	$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).change(function(){
		var emailVal = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		if(emailVal)
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).removeClass('redBorderThick');
	});
	/*$( ".target4" ).change(function() {
		$("#days").removeClass('redBorderThick');
	});
	$( ".target5" ).change(function() {
		$("#notes").removeClass('redBorderThick');
	});*/
	$( ".target6" ).change(function() {
		$("#status").removeClass('redBorderThick');
	});
	$( ".target7" ).change(function() {
		$("#notified").removeClass('redBorderThick');
	});
	
	var ajaxUrl = window.ajaxUrlPrefix + 'modules-requests-for-information-delay-save-ajax.php';
	$.ajax({
			url: ajaxUrl,
			data:{formValues:formValues},
			method:'POST',
			success: arrDelaySaveSuccessCallbacks,
			error: errorDelaySaveHandler
		});
};
function arrDelaySaveSuccessCallbacks(data){
	//alert(data);
	if (data == 1) { 
		messageAlert('Successfully saved the record', 'successMessage');	
		setTimeout(function(){
		//$(".ui-dialog-titlebar-close").trigger('click');
		window.location.reload(true);
	},1000);
	}
	else if(data == 2){
		messageAlert('Successfully updated the record', 'successMessage');	
		setTimeout(function(){
		window.location.reload(true);
	},1000);
	} 
	else {
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');
	}
};	
function errorDelaySaveHandler(data) {
	
	 
};
function RFIs__createRfiViaPromiseChain(attributeGroupName, uniqueId)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#RFIs__create__RfiResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#RFIs__create__RfiResponseViaPromiseChain").attr('disabled',true);
	$("#createRFidraft").attr('disabled',true);
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		//options.successCallback = RFIs__createRequestForInformationSuccess;

 		showSpinner();
		var promise1 = RFIs__createRequestForInformation(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = RFIs__createRequestForInformationAttachmentHelper(options);
			return innerPromise;
		})
		var promise3 = promise2.then(function() {
			var innerPromise = RFIs__createRequestForInformationNotificationHelper(options);
			return innerPromise;
		})
		var promise4 = promise3.then(function() {
			var innerPromise = RFIs__createRequestForInformationRecipientHelper(options);
			return innerPromise;
		})
		var promise5 = promise2.then(function() {
			var innerPromise = RFIs__saveRfiAsPdfHelper(options);
			return innerPromise;
		})
		var promise6 = promise5.then(function() {
			var innerPromise = RFIs__deleteRequestForInformationDraftHelper(options);
			options.successCallback = '';
			return innerPromise;
		})
		var promise7 = promise6.then(function() {
			closeCreateRfiDialog();
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

function RFIs__createRfiAndSendEmailViaPromiseChain(attributeGroupName, uniqueId)
{
	//To Hide the submit button once it is trigged to restrict double entries
	$("#RFIs__create__RfiResponseAndSendEmailViaPromiseChain").attr('disabled',true);
	$("#RFIs__create__RfiResponseViaPromiseChain").attr('disabled',true);
	$("#createRFidraft").attr('disabled',true);

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.uniqueId = uniqueId;
		
		//options.successCallback = RFIs__createRequestForInformationSuccess;

		showSpinner();
		var promise1 = RFIs__createRequestForInformation(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function() {
			options.successCallback = '';
			var innerPromise = RFIs__createRequestForInformationAttachmentHelper(options);
			return innerPromise;
		});
		
		var promise3 = promise2.then(function() {
			var innerPromise = RFIs__createRequestForInformationNotificationHelper(options);
			return innerPromise;
		});
		var promise4 = promise3.then(function() {
			var innerPromise = RFIs__createRequestForInformationRecipientHelper(options);
			return innerPromise;
		});
		var promise5 = promise4.then(function() {
			var innerPromise = RFIs__saveRfiAsPdfHelper(options);
			return innerPromise;
		});
		var promise6 = promise5.then(function() {
			var innerPromise = RFIs__sendRfiEmail(options);
			return innerPromise;
		});
		var promise7 = promise6.then(function() {
			var innerPromise = RFIs__deleteRequestForInformationDraftHelper(options);
			options.successCallback = '';
			return innerPromise;
		});
		var promise8 = promise7.then(function() {
			closeCreateRfiDialog();
		});
		promise8.fail(function() {
			// Debug
		});
		promise8.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function RFIs__createRequestForInformationAttachmentHelper(options)
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
		//var csvRfiFileManagerFileIds = $("#create-request_for_information_attachment-record--request_for_information_attachments--csvRfiFileManagerFileIds--" + rfiDummyId).val();
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

function RFIs__saveRfiAsPdfHelper(options)
{
	var active_request_for_information_id = $("#active_request_for_information_id").val();
	var promise = RFIs__saveRfiAsPdf(active_request_for_information_id, options);

	return promise;
}

function RFIs__createRequestForInformationNotificationHelper(options)
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

function RFIs__createRequestForInformationRecipientHelper(options)
{
	var options = options || {};
	var promiseChain = options.promiseChain;

	var active_request_for_information_notification_id = $("#active_request_for_information_notification_id").val();
	var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
	$("#create-request_for_information_recipient-record--request_for_information_recipients--request_for_information_notification_id--" + rfiDummyId).val(active_request_for_information_notification_id);
	var attributeGroupName = 'create-request_for_information_recipient-record';
	var smtp_recipient_header_type_element_id = attributeGroupName + '--request_for_information_recipients--smtp_recipient_header_type--' + rfiDummyId;
	var arrPromises = [];
	var active_request_for_information_id = $("#active_request_for_information_id").val();

	//To recipients.
	// $("#" + smtp_recipient_header_type_element_id).val('To');
	
	// var to_id = $("#ddl--edit-request_for_information-record--requests_for_information--rfi_recipient_contact_id-To :selected").val();
	// if(to_id){

	// 	$.get('request_for_information_recipients-ajax.php',{'method':'saveAdditionalRecipient','to_id':to_id,'notification_id':active_request_for_information_notification_id,'rfi_id':active_request_for_information_id},function(data){
	// 		//console.log(data);
	// 	});
	// }
	// to recipient
	$("#" + smtp_recipient_header_type_element_id).val('To');
	
	 var arrRfiRecipientIds = $("#RFIToId").val();
		if (arrRfiRecipientIds !="") {
		 var csvRfiRecipientIds = $("#RFIToId").val();
		options.adHocQueryParameters = '&csvRfiRecipientIds=' + encodeURIComponent(csvRfiRecipientIds)+'&smtp_recipient_header_type='+'To';
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createRequestForInformationRecipient(attributeGroupName, rfiDummyId, options);
		arrPromises.push(promise);
	}
	// Cc recipients.
	$("#" + smtp_recipient_header_type_element_id).val('Cc');
	// var arrRfiRecipientIds = [];
	// $("#record_container--request_for_information_recipients--Cc li input").each(function(i) {
	// 	arrRfiRecipientIds.push($(this).val());
	// });
	 arrRfiRecipientIds = $("#RFIccId").val();
	if (arrRfiRecipientIds !="") {
		var csvRfiRecipientIds = $("#RFIccId").val();
		options.adHocQueryParameters = '&csvRfiRecipientIds=' + encodeURIComponent(csvRfiRecipientIds)+'&smtp_recipient_header_type='+'Cc';
		options.promiseChain = true;
		options.responseDataType = 'json';

		var promise = createRequestForInformationRecipient(attributeGroupName, rfiDummyId, options);
		arrPromises.push(promise);
	}

	// Bcc recipients.
	$("#" + smtp_recipient_header_type_element_id).val('Bcc');
	// arrRfiRecipientIds = [];
	// $("#record_container--request_for_information_recipients--Bcc li input").each(function(i) {
	// 	arrRfiRecipientIds.push($(this).val());
	// });
	 arrRfiRecipientIds = $("#RFIbccId").val();
	if (arrRfiRecipientIds !="") {
		var csvRfiRecipientIds =  $("#RFIbccId").val();
		options.adHocQueryParameters = '&csvRfiRecipientIds=' + encodeURIComponent(csvRfiRecipientIds)+'&smtp_recipient_header_type='+'BCc';
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

function RFIs__sendRfiEmail(options)
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
   if($('#rfi-edit').length){
 		 var update=$('#rfi-edit').val();
 	 }else{
 		 var update='no';
 	 }
		var active_request_for_information_notification_id = $("#active_request_for_information_notification_id").val();
		var dummyId = options.uniqueId;
		var emailBody = $("#textareaEmailBody--"+dummyId).val();
    if(emailBody === undefined){
			emailBody = '';
		}
		if(options.mail_message){
			emailBody = options.mail_message;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=RFIs__sendRfiEmail';
		var ajaxQueryString =
			'request_for_information_notification_id=' + encodeURIComponent(active_request_for_information_notification_id) +
			'&emailBody=' + encodeURIComponent(emailBody) +
			'&updateRfi=' + encodeURIComponent(update);
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
			success: RFIs__sendRfiEmailSuccess,
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

function RFIs__sendRfiEmailSuccess(data, textStatus, jqXHR)
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

function RFIs__deleteRequestForInformationDraftHelper(options)
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
		options.successCallback = RFIs__deleteRequestForInformationDraftSuccess;

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

function RFIs__deleteRequestForInformationDraft(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';
		options.successCallback = RFIs__deleteRequestForInformationDraftSuccess;

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

function RFIs__deleteRequestForInformationDraftSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var uniqueId = json.uniqueId;
			//RFIs__loadCreateRfiDialog();
			$("#spanDeleteRfiDraft").html('');
			var form = $("#formCreateRfi")[0];
			form.manualReset();
			$("#container--request_for_information_attachments--create-request_for_information-record").html('');
			$('#saveRfiDraftBefore').empty();
			$('#saveRfiDraftAfter').css('display','block');
			$('.fs-search').empty();
			$('.emailGroup').fSelect('reload');
			$('#record_container--request_for_information_recipients--Cc').empty();
			$('#record_container--request_for_information_recipients--Bcc').empty();
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

function RFIs__addRecipient(element,option)
{
	try {

		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();

		// Get ul.
		var val = $("#" + element.id + " option:selected").val();
		if (val == '' || val == 0) {
			return;
		}
		var html = $("#" + element.id + " option:selected").html();
		if(option != "" && option !=undefined)
		{
		var ul = $('#'+option).find('ul');
		var ulId = $(ul).attr('id');
			
		}else{
		var div = $(element).closest('div').parent().parent();
		var ul = div.find('ul');
		var ulId = $(ul).attr('id');
		}
		var a = '<a href="#" onclick="RFIs__removeRecipient(this); return false;">X</a>';
		var span = '<span id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id_span--' + rfiDummyId + '">' + html + '</span>';
		
		if(ulId == 'record_container--request_for_information_recipients--Cc')
			var input = '<input class="cc_recipients" id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';
		else if(ulId == 'record_container--request_for_information_recipients--Bcc')
			var input = '<input class="bcc_recipients" id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';
		else if(ulId == 'record_container--request_for_information_recipients--To')
			var input = '<input class="to_recipients" id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';
		else
			var input = '<input id="create-request_for_information_recipient-record--request_for_information_recipients--rfi_additional_recipient_contact_id--' + rfiDummyId + '" type="hidden" value="' + val + '">';


		var li = '<li id="' + val + '">' + a + '&nbsp;&nbsp;' + span + input + '</li>';

		var found = ul.find('li[id='+val+']').length > 0;
		if (!found) {
			ul.append(li);
			RFIs__createRequestForInformationRecipientHelper();			
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function rfi_isMailToError(element){

	var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();
	$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+rfiDummyId).parent().children(':first-child').removeClass('redBorderThick');
}

function rfi_isTitleError(id){
	$(".rfi_title_"+id).removeClass('redBorderThick');
}

function RFIs__removeRecipient(element, mail_type)
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
			    var ajaxurl = window.ajaxUrlPrefix + 'request_for_information_recipients-ajax.php';
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

function RFIs__saveRfiAsPdf(request_for_information_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var request_for_information_id = parseInputToInt(request_for_information_id);
		if (!request_for_information_id) {
			request_for_information_id = $("#request_for_information_id").val();
		}
		if($('#rfi-edit').length)
		{
			var update=$('#rfi-edit').val();

		}else{
			var update='no';
		}

		// @todo Parse temp files out of a list of hidden input elements


		var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=RFIs__saveRfiAsPdf';
		var ajaxQueryString =
			'request_for_information_id=' + encodeURIComponent(request_for_information_id)+
			'&updatedRfi=' + encodeURIComponent(update);
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
			success: RFIs__saveRfiAsPdfSuccess,
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

function RFIs__saveRfiAsPdfSuccess(data, textStatus, jqXHR)
{
	try {

		messageAlert('RFI PDF saved.', 'successMessage');
		checkRFIclosedDate();

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function checkRFIclosedDate(){
	var request_for_information_id = $("#request_for_information_id").val();
	var ajaxHandlerScript = 'modules-requests-for-information-ajax.php?method=getClosedDate';
	var ajaxQueryString =
			'&request_for_information_id=' + request_for_information_id+
			'&attributeName=rfi_closed_date';
			
	var ajaxHandler = window.ajaxUrlPrefix + ajaxHandlerScript;
	var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res)
			{
				$('#manage-request_for_information-record--requests_for_information--rfi_closed_date--'+request_for_information_id).html(res);
			},
		});

}

function RFIs__openRfiPdfInNewTab(url)
{
	window.open(url, '_blank');
}

function RFIs__showEditRfiStatement(element)
{
	$("#divEditRfiStatement").removeClass('hidden');
	$("#divShowRfiStatement").addClass('hidden');
}

function RFIs__cancelEditRfiStatement(element)
{
	$("#divEditRfiStatement").addClass('hidden');
	$("#divShowRfiStatement").removeClass('hidden');
}

function RFIs__showEditRfiTitle(element)
{
	$("#divEditRfiTitle").removeClass('hidden');
	$("#divShowRfiTitle").addClass('hidden');
}

function RFIs__cancelEditRfiTitle(element)
{
	$("#divShowRfiTitle").removeClass('hidden');
	$("#divEditRfiTitle").addClass('hidden');
}
function RFIs__DeleteRfiAnswer(RFIdeleteid,RFIID)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'requests_for_information-ajax.php?method=deleteRFIAnswer';
		var ajaxQueryString =
			'RFIdeleteid=' + encodeURIComponent(RFIdeleteid);

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
			data: ajaxQueryString,
			type: 'POST',
			success: function(data){
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		if (options.request_for_information_status_id) {
			var request_for_information_status_id = options.request_for_information_status_id;
			if (request_for_information_status_id) {
				options.adHocQueryParameters = '&attributeName=request_for_information_status_id&newValue=' + encodeURIComponent(request_for_information_status_id);
			}
		}
		if(data){

			var promise1 = RFIs__saveRfiAsPdfHelper(options);
			promise1.fail(function() {
			hideSpinner();
		});

		// promise2 is instantiated as a promise object via .then
		// this occurs before the promise1 ajax calls even fires since everything is asynchronous
		var promise2 = promise1.then(function() {
			var innerPromise = RFIs__loadRequestForInformationModalDialog(RFIID);
			return innerPromise;
		});
		hideSpinner();
	}
			},
			error: errorHandler
		});
}

function RFIs__deleteRequestForInformationAttachmentViaPromiseChain(recordContainerElementId, attributeGroupName, uniqueId)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var request_for_information_id = $("#request_for_information_id").val();
		showSpinner();
		var promise1 = deleteRequestForInformationAttachment(recordContainerElementId, attributeGroupName, uniqueId, options);
		// var promise2 = promise1.always(function() {
		// 	var innerPromise = RFIs__saveRfiAsPdf(request_for_information_id, options);
		// 	return innerPromise;
		// });
		// var promise3 = promise2.then(function() {
		// 	var innerPromise = RFIs__loadRequestForInformation(request_for_information_id, options);
		// 	return innerPromise;
		// });
		promise1.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

// To delete the attachement from the draft

function deleteFileManagerFileDraftAttach(recordContainerElementId, attributeGroupName, uniqueId)
{

	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		var request_for_information_id = $("#request_for_information_id").val();
		showSpinner();
		var promise1 = deleteRequestForInformationAttachmentDraft(recordContainerElementId, attributeGroupName, uniqueId, options);		
		promise1.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function closeCreateRfiDialog()
{
	if ($("#divCreateRfi").hasClass('ui-dialog-content')) {
		$("#divCreateRfi").dialog('close');
	}
}

function RFIs__updateRfiViaPromiseChain(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		if (options.request_for_information_status_id) {
			var request_for_information_status_id = options.request_for_information_status_id;
			if (request_for_information_status_id) {
				options.adHocQueryParameters = '&attributeName=request_for_information_status_id&newValue=' + encodeURIComponent(request_for_information_status_id);
			}
		}

		var uniqueId = $('#request_for_information_id').val();		
		var rfiTitle = $('.rfi_title_'+uniqueId).val();
		rfiTitle = rfiTitle.trim();

		if (rfiTitle == '') {
			$('.rfi_title_'+uniqueId).addClass('redBorderThick');
			return;
		}

		showSpinner();
		var promise1 = updateRequestForInformation(element, options);
		var promise2 = promise1.then(function(json) {
			updateRfiMeetingActionItem(element, options);
			options.adHocQueryParameters = '';
			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var uniqueId = json.uniqueId;
				$("#active_request_for_information_id").val(uniqueId);

				var attributeGroupName = json.attributeGroupName;
				var attributeSubgroupName = json.attributeSubgroupName;
				var attributeName = json.attributeName;
				var newLabel = json.newLabel;

				var attributeLabelName = attributeName.replace('_id', '');
				var elementLabelId = attributeGroupName + '--' + attributeSubgroupName + '--' + attributeLabelName + '--' + uniqueId;
				$("#" + elementLabelId).html(newLabel);

				var innerPromise = RFIs__saveRfiAsPdfHelper(options);
				return innerPromise;
			}

		});
		var promise3 = promise2.then(function() {
			var request_for_information_id = $("#active_request_for_information_id").val();
			var innerPromise = RFIs__loadRequestForInformation(request_for_information_id, options);
			return innerPromise;
		});
		promise3.always(function() {
			hideSpinner();
		});

	} catch (error) {
		hideSpinner();
	}
}

function appendRfiTempFileIds(arrFileManagerFiles, options)
{
	try {

		var options = options || {};
		//options.promiseChain = true;

		$("#file-uploader-container--temp-files").show();

		var htmlAttributeGroup = options.htmlAttributeGroup;
		var tempFileUploaderElementId = options.tempFileUploaderElementId;
		var uploadedTempFilesContainerElementId = options.uploadedTempFilesContainerElementId;

		var tempFileUploadPosition = $("#temp-files-next-position--request_for_information_attachments").val();

		for (var i = 0; i < arrFileManagerFiles.length; i++) {
			var fileManagerFile = arrFileManagerFiles[i];

			var tempFileName = fileManagerFile.tempFileName;
			var tempFileSha1 = fileManagerFile.tempFileSha1;
			var tempFilePath = fileManagerFile.tempFilePath;
			//var tempFileUploadPosition = fileManagerFile.tempFileUploadPosition;
			var virtual_file_mime_type = fileManagerFile.virtual_file_mime_type;
			var rfiAttachmentSourceContactFullName = fileManagerFile.rfiAttachmentSourceContactFullName;

			// Encode for HTML
			var urlEncodedTempFileName = encodeURIComponent(tempFileName);
			var encodedTempFileName = htmlEncode(tempFileName);
			var encoded_virtual_file_mime_type = htmlEncode(virtual_file_mime_type);
			var encodedRfiAttachmentSourceContactFullName = htmlEncode(rfiAttachmentSourceContactFullName);

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
			var trElementId = 'record_container--' + htmlAttributeGroup + '--request_for_information_attachments--position--' + tempFileUploadPosition;

			var trElement =
			' \
			<tr id="' + trElementId + '" \
				class="record_container--uploaded-temp-file--request_for_information_attachments" \
				tempFileName="' + encodedTempFileName + '" \
				tempFileUploadPosition="' + tempFileUploadPosition + '" \
				virtual_file_mime_type="' + encoded_virtual_file_mime_type + '"> \
				<td width="60%"> \
					<a href="javascript:removeDomElement(\'' + trElementId + '\');">X</a> \
					<a href="' + fileUrl + '" target="_blank">' + tempFileName + '</a> \
				</td> \
				<td width="40%">' + encodedRfiAttachmentSourceContactFullName + '</td> \
			</tr>';

			if (tempFileUploadPosition == 1) {
				$("#" + uploadedTempFilesContainerElementId).append(trElement);
			} else {
				$("#" + uploadedTempFilesContainerElementId + ' tr:last').after(trElement);
			}
		}

		// Update position
		var nextTempFileUploadPosition = parseInt(tempFileUploadPosition) + 1;
		$("#temp-files-next-position--request_for_information_attachments").val(nextTempFileUploadPosition);
		//$("#" + tempFileUploaderElementId).attr('file_upload_position', nextTempFileUploadPosition);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function RFIs__generateRfiTempFileListAsJsonEncodedString(htmlAttributeGroup, options)
{
	try {

		var options = options || {};
		//options.promiseChain = true;


		var arrTempFileLiElements = $("#record_container--uploaded-temp-file--request_for_information_attachments");

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

function RFIs__createRequestForInformation(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = RFIs__createRequestForInformationSuccess;

		

		var isErr;
		var isEmail =$("#RFIToId").val();
		// var isEmail = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		var isTitle = $("#create-request_for_information-record--requests_for_information--rfi_title--"+uniqueId).val();
		var isRfiType = $("#ddl--create-request_for_information-record--requests_for_information--request_for_information_type_id--"+uniqueId).val(); 
		var isQue = $("#create-request_for_information-record--requests_for_information--rfi_statement--"+uniqueId).val();

		if (isEmail == 0 && (isTitle == '' || isRfiType == '' || isQue == '')) {
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
			var promise = createRequestForInformation(attributeGroupName, uniqueId, options);
			$isErr = 1;
		}else if (isEmail == 0) {
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
			messageAlert('Please Select atleast one To field .', 'errorMessage');
			$isErr = 1;
		}else if (isTitle == '' || isRfiType == '' || isQue == '') {
			$isErr = 1;
			var promise = createRequestForInformation(attributeGroupName, uniqueId, options);
		}else{
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
			var promise = createRequestForInformation(attributeGroupName, uniqueId, options);
			$isErr = 0;
		}	

		if($isErr ==1)
		{
		//To enable the submit button 
		$("#RFIs__create__RfiResponseAndSendEmailViaPromiseChain").removeAttr('disabled');
		$("#RFIs__create__RfiResponseViaPromiseChain").removeAttr('disabled');
		$("#createRFidraft").removeAttr('disabled');	
		}

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

function RFIs__createRequestForInformationSuccess(data, textStatus, jqXHR)
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

			RFIs__addRfiTableClickHandlers();
			$("#active_request_for_information_id").val(uniqueId);

			RFIs__addDataTablesToRFIListView();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function RFIs__notifysubcontractor(primary_contact_id, primary_contact_name)
{
	var ajaxUrl = window.ajaxUrlPrefix + 'Request-for-information-operations.php';
	var request_id=$('#request_for_information_id').val();
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=NotifySubcontractor&request_id='+request_id,
		success:function(res)
		{
			$('#Viewsubcontractor').empty().html(res);
		    $('#Viewsubcontractor').css('display','block');
		    $('.NotifySub').fSelect();
		    RFIs__automaticNotifySubcontractorRecipient(primary_contact_id, primary_contact_name);
		    createUploaders();
		}

	});

}
function modalClose() {
	 $('#Viewsubcontractor').css('display','none');
}
function Email_notififysubcontractor(uniqueId)
{
	
	var element = document.getElementById("formCreateRfinotification");
	var formValues = {};
	var request_for_information_id=$('#request_for_information_id').val();
	var mailText = $("#textareaBody").val();
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
	var err;
	if(emailTo == '' || emailTo=='0'){
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).prev().prev().addClass('redBorderThick');
		err = true;	
	}

	
	$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).change(function(){
		var emailVal = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		if(emailVal){
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).prev().prev().removeClass('redBorderThick')
		}
		err = false;	
	});

	if(err){
			messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
		return false;
	}else 
	{
		formValues.rfiId = request_for_information_id;
		formValues.attachments= attachments;
		formValues.emailTo = emailTo;
		formValues.emailCc = emailCc;
		formValues.emailBCc = emailBCc;
		formValues.mailText = mailText;
		formValues.method = "EmailSubcontractorandTransmittal";

	}
	showSpinner();
	$(".pod_loader_img").show();
	var ajaxUrl = window.ajaxUrlPrefix + 'Request-for-information-operations.php';
	$.ajax({
		url: ajaxUrl,
		data:{formValues:formValues},
		method:'POST',
		success: function(data){
			hideSpinner();
			if(data=="1")
			{
				messageAlert('Successfully Sent the Mail', 'successMessage');
				$('#Viewsubcontractor').css('display','none');
			}
		},

	});

}
//To update the attachment 
function updateRFIAttachment(attachId){
	var attchIds=attachId.split('-');
	var rfiId=attchIds[0];
	var attchmentId=attchIds[1];
	var updateData='';
	if($("#attach_"+attachId).prop('checked') == true){
		updateData='y';
	}else{
		updateData='n';
	}

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=updateRFIAttachements';
		var ajaxQueryString =
			'request_for_information_id=' + encodeURIComponent(rfiId)+
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
					var promise1 =RFIs__saveRfiAsPdf(rfiId, options);
							
					var promise2 = promise1.then(function() {
						var innerPromise = RFIs__loadRequestForInformation(rfiId, options);
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
function selectAllRFI(rfiId){
	var updateData;
	if($("#allAttach_"+rfiId).prop('checked') == true){
		$(".actselect").prop('checked',true);
		updateData='y';
	}else{
		$('.actselect').removeProp('checked');
		updateData='n';
	}

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=updateAllRFIAttachements';
		var ajaxQueryString =
			'request_for_information_id=' + encodeURIComponent(rfiId)+
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
					var promise1 =RFIs__saveRfiAsPdf(rfiId, options);
							
					var promise2 = promise1.then(function() {
						var innerPromise = RFIs__loadRequestForInformation(rfiId, options);
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

/* Function to update rfi details to meeting */

function updateRfiMeetingActionItem(element, options){

	var options = options || {};
	var optionsObjectIsEmpty = $.isEmptyObject(options);

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

	var attributeName 	= htmlRecordMetaAttributes.attributeName;
	var uniqueId 		= htmlRecordMetaAttributes.uniqueId;

	var tmpValue 		= $(element).val();
	var objReturn 		= filterRequestForInformationHtmlRecordAttributeValueByAttributeName(attributeName, tmpValue);
	var newValue 		= objReturn.newValue;
	
	var rfi_status_id 	= options.request_for_information_status_id;

	var updateActionItem = false;

	if (attributeName == 'rfi_due_date') {
		var attName = 'action_item_due_date';
		updateActionItem = true;
	}else if(attributeName == 'request_for_information_status_id'){
		var attName = 'action_item_completed_timestamp';
		updateActionItem = true;
	}else if(attributeName == 'rfi_title'){
		var attName = 'action_item';
		updateActionItem = true;
	}else{
		updateActionItem = false;
	}

	if (updateActionItem == true) {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=updateActionItemRfi';
		var ajaxQueryString =
			'rfi_id=' + encodeURIComponent(uniqueId)+
			'&rfi_field_value=' + encodeURIComponent(newValue)+
			'&rfi_field_name=' + encodeURIComponent(attName)+
			'&rfi_status_id=' + encodeURIComponent(rfi_status_id);

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString
		});
	}	
}


// Setting cookie to prevent answer section on refresh or reload
function setTempAnswer(answer){
    document.cookie = "tempAnswer=''";
    document.cookie = "tempAnswer="+answer;
}
// Removing cookie of notes while closing modal
function deleteTempAnswer(){
       setCookie('tempAnswer', '', -1);
}

// Setting cookie to prevent answer section on refresh or reload
function setTempRfiEmail(rfiemail){
    document.cookie = "tempRfiEmail=''";
    document.cookie = "tempRfiEmail="+rfiemail;
}
// Removing cookie of notes while closing modal
function deleteTempRfiEmail(){
       setCookie('tempRfiEmail', '', -1);
}
// email popup starts
function loademailcurrentlist()
{
	// To list
	var to_list = $('#RFIToId').val();
	var to_arr = to_list.split(',');
	var toid;
	
	for (i = 0; i < to_arr.length; i++) {
		$("#toindiv_"+to_arr[i]).prop('checked',true);
		toid +=','+to_arr[i];
	}
	// cc list
	var cc_list = $('#RFIccId').val();
	var cc_arr = cc_list.split(',');
	var ccid;

	for (i = 0; i < cc_arr.length; i++) {
		$("#ccindiv_"+cc_arr[i]).prop('checked',true);
		ccid +=','+cc_arr[i];
	}
	// bcc list
	var bcc_list = $('#RFIbccId').val();
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
	var arr_list = $("#RFIToId").val();
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

		arr_list = $("#RFIccId").val();
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

		arr_list = $("#RFIbccId").val();
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
	$("#RFIToId").val(ToArr);

	$.each($(".ccindiv"), function(){ 
		var ccid = $('#'+this.id).is(':checked');
		if(ccid == true)
		{
			var ccval = this.id.split('_');
		ccArr +=  parseInt(ccval[1])+"," ;
		}
	});
	ccArr= ccArr.replace(/,(\s+)?$/, '');
	$("#RFIccId").val(ccArr);

	$.each($(".bccindiv"), function(){ 
		var bccid = $('#'+this.id).is(':checked');
		if(bccid == true)
		{
			var bccval = this.id.split('_');
		bccArr +=  parseInt(bccval[1])+"," ;
		}
	});
	bccArr= bccArr.replace(/,(\s+)?$/, '');
	$("#RFIbccId").val(bccArr);
	EmailAppendList();

}
// end of email popup

// to save the tags alone
function RFIs__updateTag(rfi_id)
{
	var rfi_Tags = $("#search_data").val();
	var ajaxHandler = window.ajaxUrlPrefix + 'modules-requests-for-information-ajax.php?method=RFIUpdateTag';
	var ajaxQueryString ='rfi_id=' + rfi_id +
		'&rfi_Tags=' + encodeURIComponent(rfi_Tags) ;

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

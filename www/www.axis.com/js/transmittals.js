$(document).ready(function() {
	
	Transmittal__addDataTablesToTransmittalListView();
});
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
//Method To generate Transmittal List
function Transmittal__addDataTablesToTransmittalListView()
{
var url = window.ajaxUrlPrefix +"images/logos/pdf_logo.jpg";
convertFileToDataURLviaFileReader(url,function(base64Image){
 
  console.log(base64Image);
  var table = $("#Transmittal_list_container--manage-Transmittal_data-record").DataTable({
  	"initComplete": function(settings, json) {
    // $(".pod_loader_img").hide();
    hideSpinner();
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
        targets: [2,4,5],
        render: $.fn.dataTable.render.ellipsis_trans( 10 )
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
    // $(".pod_loader_img").hide();
    hideSpinner();
    
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

// Method for open Create Transmittal Dialog box
function CreateTransmittalsDialog(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var transmittal_id = '';
		if (element) {
			transmittal_id = $(element).val();
			if (transmittal_id == '-1') {
				return;
			}
			$(element).val(-1);
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'transmittal-ajax.php?method=CreateTransmittalsDialog';
		var ajaxQueryString =
			'transmittal_id=' + encodeURIComponent(transmittal_id) +
			'&attributeGroupName=create-transmittal-record' +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		var arrSuccessCallbacks = [ arrTransmittalSuccessCallbacks ];
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

// Method called when a Create Transmittal function return sucess
function arrTransmittalSuccessCallbacks(data, textStatus, jqXHR)
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

			$("#divCreateTransmittal").html(htmlContent);
			$("#divCreateTransmittal").removeClass('hidden');
			$("#divCreateTransmittal").dialog({
				modal: true,
				title: 'Create Transmittal — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateTransmittal").addClass('hidden');
					$("#divCreateTransmittal").dialog('destroy');
				},
				buttons: {
					'Close': function() {
						$("#divCreateTransmittal").dialog('close');
					},
					'Reset': function() {
						$("#formCreateTransmittal")[0].reset();
						$('.emailGroup').fSelect();
					}
				}
			});
			createUploaders();
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

// Method To add Transmittal Recipient
function Transmittals__addRecipient(element)
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
		var a = '<a href="#" onclick="Transmittals__removeRecipient(this); return false;">X</a>';
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
// Method To Remove Transmittal Recipient
function Transmittals__removeRecipient(element)
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

//Method For Creating Transmittals 
function Transmittals__createTransmittalsViaPromiseChain(uniqueId,methodType){
	var element = document.getElementById("formCreateTransmittal");
	var formValues = {};
	var source    = $("#source_id").val();
	var transmital_type  = $("#transmital_type").val();
	var comments     = $("#comments").val();
	var mailText = $("#textareaEmailBody").val();
	var file_attachement_id=$("#file_attachement_id").val();
	var subject=$("#subject").val();
	var transmital_text=$('#transmital_type option:selected').text();

	

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
	if(transmital_type == '')
	{
		$("#transmital_type").addClass('redBorderThick');
		err = true;
	}
	else{
		$("#transmital_type").removeClass('redBorderThick');
		err = false;
	} 

	if(comments == ''){
			$("#comments").addClass('redBorderThick');
			err = true;
		}
	else{
		$("#comments").removeClass('redBorderThick');
	}

	if(transmital_text=="Standard Letter")
	{
		if(subject==''||subject==null)
		{
			err = true;
			$("#subject").addClass('redBorderThick');
		}else{
			$("#subject").removeClass('redBorderThick');
		}

	}
	
	var dateerr = '';

	if((emailTo == '' || emailTo == 0) && methodType == '1'){
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
		err = true;	
	}

	
	$( "#transmital_type" ).change(function() {
  		$("#transmital_type").removeClass('redBorderThick');		
	});

	$( "#comments" ).keyup(function() {
		$("#comments").removeClass('redBorderThick');		
	});
	$( "#subject" ).keyup(function() {
		$("#subject").removeClass('redBorderThick');		
	});
	

	$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).change(function(){
		var emailVal = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		if(emailVal)
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
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
		formValues.transmitalTypeId = element.transmital_type.value;
		formValues.commentsId=element.comments.value;
		formValues.TransmittalId = element.Transmittal_id.value;
		formValues.attachments= attachments;
		formValues.file_attachement_id= file_attachement_id;
		formValues.emailTo = emailTo;
		formValues.emailCc = emailCc;
		formValues.emailBCc = emailBCc;
		formValues.methodType = methodType;
		formValues.mailText = mailText;
		formValues.subject = element.subject.value;
		

	}
	

	// $(".pod_loader_img").show();
	showSpinner();
	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-save-ajax.php';
	$.ajax({
			url: ajaxUrl,
			data:{formValues:formValues},
			method:'POST',
			success: arrTransmittalSaveSuccessCallbacks,
			error: errorTransmittalSaveHandler
		});
}

// Method call after ajax return sucess
function arrTransmittalSaveSuccessCalls(data){
	if (data == 1) { 
		// $(".pod_loader_img").hide();
		hideSpinner();
		messageAlert('Successfully saved the record', 'successMessage');	
		setTimeout(function(){
		
		window.location.reload(true);
	},1000);
	}
	else {
		// $(".pod_loader_img").hide();
		hideSpinner();
		messageAlert('Successfully updated the record', 'successMessage');	
		setTimeout(function(){
		window.location.reload(true);
	},1000);
	} 
	
};	
// Method When ajax return Error 
function errorTransmittalSaveHandler(data) {
	
	 
};

//Method called After Uploading Attachement File
function RFIs__rfiDraftAttachmentUploaded(arrFileManagerFiles, containerElementId)
{
	var filedata='';
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
				'<input type="hidden" class="upfileid" value="'+ file_manager_file_id +'" ><a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');update_file_data(\''+virtual_file_name+'\');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;' +
				'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>' +
			'</li>';

			// Append the file manager file element.
			$("#" + containerElementId).append(htmlRecord);
			$(".bs-tooltip").tooltip();
			 
			filedata += $("#file_attachement_id").val()+','+virtual_file_name;
			filedata=filedata.replace(/^\,/, "");
			$('#file_attachement_id').val(filedata);
			
			
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//To update the deleted file
function update_file_data(file,element_val)
{
	var filedata=$("#file_attachement_id").val();
	file_cont=filedata.split(',');
	for (i = 0; i < file_cont.length; i++) {
		if(file_cont[i]==file)
		{
			delete file_cont[i];
			break;
		}
	}
	file_cont=file_cont.toString();
	file_cont=file_cont.replace(/^\,/, "");//to trim in start
	file_cont = file_cont.replace(/\,$/, ''); // to trim at the end
	$('#file_attachement_id').val(file_cont);
	// To delete the  file in db
	var transmittalid=$('#TransmittalId').val();
	if(element_val!=''&& element_val != undefined)
	{	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=deletefile&val='+element_val+'&transmittalid='+transmittalid,
		success:function(data)
		{
			
		}

	});
}
			

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

//Method For Edit Transmittal
function Transmittal__Edit($transid){
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var request_for_information_draft_id = '';
		var ajaxHandler = window.ajaxUrlPrefix + 'transmittal-ajax.php?method=Transmittal__editDialog';
		var ajaxQueryString =
			'request_for_information_draft_id=' + encodeURIComponent(request_for_information_draft_id) +
			'&attributeGroupName=create-request-for-information-record' +
			'&responseDataType=json&transId=' + $transid;
			 
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var arrSuccessCallbacks = [ Transmittals__loadCreateDialogSuccess ];
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

// Method for Edit Transmittals sucess
function Transmittals__loadCreateDialogSuccess(data, textStatus, jqXHR)
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

			$("#divCreateTransmittal").html(htmlContent);
			$("#divCreateTransmittal").removeClass('hidden');
			$("#divCreateTransmittal").dialog({
				modal: true,
				title: 'Edit Transmittal',
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateTransmittal").addClass('hidden');
					$("#divCreateTransmittal").dialog('destroy');
				},
				buttons: {
					'Close': function() {
						$("#divCreateTransmittal").dialog('close');
					},
					'Reset': function() {
						$("#formCreateTransmittal")[0].reset();
					}
				}
			});
			createUploaders();
			

			// $("#user_type_select").trigger('change');
			// var sta = $("#stas").val();
			// $("#status").val(sta);
			// var notif = $("#noti").val();
			// $("#notified").val(notif);
			
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

//Method For Edit Transmittal save 
function Transmittal__createTransmittalViaPromiseChain(uniqueId,methodType){
	var element = document.getElementById("formCreateTransmittal");
	var formValues = {};
	var type  = $("#transmital_type").val();
	var comments     = $("#comments").val();
	var mailText = $("#textareaEmailBody").val();
	var TransmittalId=$("#TransmittalId").val();
	var file_attachement_id=$("#file_attachement_id").val();
	var previous_attachment=$("#previous_attachment").val();
	

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
	if(type == '')
	{
		$("#transmital_type").addClass('redBorderThick');
		err = true;
	}
	else{
		$("#transmital_type").removeClass('redBorderThick');
		err = false;
	} 

	
		if(comments == ''){
			$("#comments").addClass('redBorderThick');
			err = true;
		
	}else{
		$("#comments").removeClass('redBorderThick');
	}

	
	var dateerr = '';
	
	if(emailTo == '' && methodType == '1'){
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).addClass('redBorderThick');
		err = true;	
	}

	
	$( "#transmital_type" ).change(function() {
  		$("#transmital_type").removeClass('redBorderThick');		
	});
	$( "#comments" ).keyup(function() {
  		$("#comments").removeClass('redBorderThick');		
	});
	
	$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).change(function(){
		var emailVal = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		if(emailVal)
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).removeClass('redBorderThick');
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
		formValues.transmitalTypeId = element.transmital_type.value;
		formValues.commentsId=element.comments.value;
		formValues.attachments= attachments;
		formValues.file_attachement_id= file_attachement_id;
		formValues.previous_attachment= previous_attachment;	
		formValues.emailTo = emailTo;
		formValues.emailCc = emailCc;
		formValues.emailBCc = emailBCc;
		formValues.methodType = methodType;
		formValues.mailText = mailText;
		formValues.TransmittalId = element.TransmittalId.value;

	}
	

	// $(".pod_loader_img").show();
	showSpinner();
	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-save-ajax.php';
	$.ajax({
			url: ajaxUrl,
			data:{formValues:formValues},
			method:'POST',
			success: arrTransmittalSaveSuccessCalls,
			error: errorTransmittalSaveHandler
		});
}

// Method call after ajax return sucess while Edit
function arrTransmittalSaveSuccessCallbacks(data){
	if (data == 1) { 
		// $(".pod_loader_img").hide();
		hideSpinner();
		messageAlert('Successfully saved the record', 'successMessage');	
		setTimeout(function(){
		
		window.location.reload(true);
	},1000);
	}
	if(data == 2){
		// $(".pod_loader_img").hide();
		hideSpinner();
		messageAlert('Successfully updated the record', 'successMessage');	
		setTimeout(function(){
		window.location.reload(true);
	},1000);
	} 
	else if(data == 0) {
		// alert(data.status);
		// obj = JSON.parse(data);
  //   alert(obj.status);
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');
	}
	else{
		// $(".pod_loader_img").hide();
		hideSpinner();
		messageAlert('Successfully saved the record', 'successMessage');	
		setTimeout(function(){
		
	window.location.reload(true);
	},1000);
	}
};	
// Method When ajax return Error while Edit
function errorTransmittalSaveHandler(data) {
	
	 
};

//Method will show confirm alert box while deleting the transmittal
function deleteTransmittalTemplate(id) {
     $("#dialog-confirm").html("Are you sure want to delete?");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation",
        buttons: {
            "Yes": function () {
                $(this).dialog('close');
                callback_delete(true,id);
            },
                "No": function () {
                $(this).dialog('close');
              
            }
        }
    });
  //   return false;
}
// Method to delete the transmittal
function callback_delete(value,id) {
    if (value) {
    	// $(".pod_loader_img").show();
    	showSpinner();
       var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-delete-data.php';
      
		
	$.ajax({
			url: ajaxUrl,
			method:'POST',
			data : {id:id},
			success: function(data){

				if (data == 1) { 
					$(".row_"+id).hide();
				messageAlert('Deleted successfully', 'successMessage');	
				// $(".pod_loader_img").hide();
				hideSpinner();
				setTimeout(function(){
				window.location.reload(true);
				},1000);
				}
			},
			error: errorTransmittalSaveHandler
		});
    } 
}
function emailfilters(id,val)
{
	var text=$('#'+id+' option:selected').text();
	if(text=='Roles')
	{
		$('#project_role').show();
		$('#projectCompany').hide();
		$('#project_role').prop('selectedIndex',0);
	}else if(text=='Company')
	{
		$('#projectCompany').show();
		$('#project_role').hide();
		$('#projectCompany').prop('selectedIndex',0);
	}
	else if(text=='All')
	{
		$('#projectCompany').hide();
		$('#project_role').hide();
		var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=allemail&software_module=Transmittal',
		success:function(data)
		{
			$('.to_contact').empty().append(data);
			$('.cc_contact').empty().append(data);
			$('.fs-search').empty();
			$('.emailGroup').fSelect('reload');
		}

	});
	}

}
function emailroles(val)
{
	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=rolesemail&val='+val+'&software_module=Transmittal',
		success:function(data)
		{
			$('.to_contact').empty().append(data);
			$('.cc_contact').empty().append(data);
			$('.fs-search').empty();
			$('.emailGroup').fSelect('reload');
		}

	});
}
function emailcompany(val)
{
	var ajaxUrl = window.ajaxUrlPrefix + 'transmittal-operations.php';
	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:'method=projectsemail&val='+val+'&software_module=Transmittal',
		success:function(data)
		{
			$('.to_contact').empty().append(data);
			$('.cc_contact').empty().append(data);
			$('.fs-search').empty();
			$('.emailGroup').fSelect('reload');
		}

	});
}
function change_transmittal(val)
{
	var data=$('#transmital_type option:selected').text();
	if(data=="Standard Letter")
	{
		$('.sub_field').show();
	}else{
	$('.sub_field').hide();	
	}
}

// Method to show transmittal attachment Dialog
function showTransmittalitem(trans_id,transmittal_type,element, options)
{
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		// modules_punch_list_ajax.php
		var ajaxHandler = window.ajaxUrlPrefix + 'transmittal-ajax.php?method=showTransmittalAttach';
		var ajaxQueryString =
		'trans_id=' + encodeURIComponent(trans_id) +
		'&attributeGroupName=show-transmittal-record' +
		'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		// var arrSuccessCallbacks = [ showTransmittalitemSuccessCallbacks ];
		
		// var successCallback = options.successCallback;
		// if (successCallback) {
		// 	if (typeof successCallback == 'function') {
		// 		arrSuccessCallbacks.push(successCallback);
		// 	}
		// }

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data, textStatus, jqXHR)
			{
				showTransmittalitemSuccessCallbacks(data, textStatus, jqXHR, transmittal_type);
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

// Method for open Create buildings Dialog
function showTransmittalitemSuccessCallbacks(data, textStatus, jqXHR, transmittal_type)
{
	try {
		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {

			var htmlContent = json.htmlContent;

			var windowWidth = $(window).width();
			var windowHeight = $(window).height();

			// var dialogWidth = windowWidth * 0.99;
			// var dialogHeight = windowHeight * 0.98;
			var dialogWidth ='500';
			var dialogHeight = '350';

			if (transmittal_type == 'Email To Contact') {
				var buttons = {
					'Close': function() {
						$("#divCreateTransmittal").dialog('close');
					}				
				};
			}else{
				var buttons = {
					'Close': function() {
						$("#divCreateTransmittal").dialog('close');
					},
					'View Transmittal PDF':function()
					{
						$(".transpdf").click();
					}					
				};
			}

			$("#divCreateTransmittal").html(htmlContent);
			$("#divCreateTransmittal").removeClass('hidden');
			$("#divCreateTransmittal").dialog({
				modal: true,
				title: 'Attachements',
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateTransmittal").addClass('hidden');
					$("#divCreateTransmittal").dialog('destroy');

				},
				buttons: buttons,
			});
			createUploaders();
	
		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			console.log('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

//To open the pdf

function transmittal__openpdfInNewTab(url)
{
	window.open(url, '_blank');
}


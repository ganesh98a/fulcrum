$(document).ready(function() {
var orderTableTrActive;

$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

//Active the selected Rows
$("#OrderTable tbody tr").click(function() {
		$("#OrderTable tbody tr").each(function(i) {
			$(this).removeClass('trActive');
		});
		$(this).addClass('trActive');
		orderTableTrActive = this;
	});

	if (orderTableTrActive) {
		$("#"+orderTableTrActive.id).addClass('trActive');
	}
});
     $('[data-toggle="tooltip"]').tooltip(); 

// Method for Create subcontract change Dialog box ajax
function CreateSubChangeOrderDialog(element, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var subChange_id = '';
		if (element) {
			subChange_id = $(element).val();
			if (subChange_id == '-1') {
				return;
			}
			$(element).val(-1);
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php?method=CreateSubOrderDialog';
		var ajaxQueryString =
			'subChange_id=' + encodeURIComponent(subChange_id) +
			'&attributeGroupName=create-subChange-record' +
			'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		var arrSuccessCallbacks = [ arrSubOrderSuccessCallbacks ];
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


//To add Sco breakdown
function addscobreakdown()
{	
		var ccIncValue = $('#cocode-inc-value').val();
		ccIncValue = Number(ccIncValue) + 1;
		$('#cocode-inc-value').val(ccIncValue);
		//New input field html 
		
    	var fieldHTML ="<div class='cost_div divdrag trow'><div class='tcol' style='width: 0.5%;'><img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'></div><div class='tcol' style='width: 27%;'><input type='text' name='descript[]' id='descript[]' class='required' value=''/></div><div class='tcol'><input type='text' class='' name='sub[]' id='sub[]' value=''/></div><div class='tcol'><input type='text' class='Number required sub_input_value' name='cost[]' id='cost[]' value='' onkeyup='setTimeout(calcScoSubtotal(),2000)'/></div><div class='tcol'><a href='javascript:void(0);' class='remove_button entypo-minus-circled ' title='Remove field' ></a></div></div>";
    	$(".field_wrapper").append(fieldHTML); //Add field html
    	$('.Number').keyup(function(e)
		    {
		    	setTimeout(function(){
		    	var input = this.value;
		    	var tmpValue = input.replace(/[^-0-9\.]+/g, '');
				tmpValue = tmpValue.replace(/[-]+/g, '-');
				this.value = tmpValue.replace(/[^0-9]+$/g, '');
			},1000);
		    	
			});
		
}

//To add sco description breakdown
function addscocostbreakdown()
{	
		var ccIncValue = $('#taxcode-inc-value').val();
		ccIncValue = Number(ccIncValue) + 1;
		$('#taxcode-inc-value').val(ccIncValue);
		console.log(ccIncValue,'ccIncValue')
		//New input field html 
    	var fieldHTML ="<div class='cont_div trow contdrag '><div class='tcol' style='width: 0.5%;'><img src='/images/sortbars.png' style='cursor: pointer;' rel='tooltip' title='' data-original-title='Drag bars to change sort order'></div><div class='tcol' style='width: 7%;'><input type='text' class='required' name='content[]' id='content"+ccIncValue+"' class='' value=''/></div><div class='tcol' style='width: 1%;'>%</div><div class='tcol' style='width: 7%;'> <input type='text' class='Number sub_input_value' name='percentage[]' id='percentage[]' value='' onkeyup='calcScoSubtotal()'/></div> <div class='tcol' style='width: 1%; text-align: center;'><b>OR</b></div><div class='tcol' style='width: 1%;'>$</div><div class='tcol' style='width: 9%;'> <input type='text' class='Number sub_input_value' name='contotal[]' id='contotal[]' value='' onkeyup=setTimeout(&apos;calcScoSubtotal()&apos;,2000)></div><div class='tcol' style='vertical-align: bottom;padding-bottom: 12px;width: 2%;'><a href='javascript:void(0);' class='remove_button entypo-minus-circled ' title='Remove field' ></a></div></div>";
    	$(".cont_wrapper").append(fieldHTML); //Add field html
    	$('.Number').keyup(function(e)
		    {
		    	setTimeout(function(){
		    	var input = this.value;
		    	var tmpValue = input.replace(/[^-0-9\.]+/g, '');
				tmpValue = tmpValue.replace(/[-]+/g, '-');
				this.value = tmpValue.replace(/[^0-9]+$/g, '');
			},1000);
		    	
			});
		
}

// Method for open Create Subcontract change Dialog
function arrSubOrderSuccessCallbacks(data, textStatus, jqXHR)
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

			$("#divCreateOrder").html(htmlContent);
			$("#divCreateOrder").removeClass('hidden');
			$("#divCreateOrder").dialog({
				modal: true,
				title: 'Create Subcontract Change Order — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateOrder").addClass('hidden');
					$("#divCreateOrder").dialog('destroy');
				},
				buttons: {
					'Save as SCO and Notify team': function() {
						$(".savemail").click();
					},
					'Save as SCO no email': function() {
						$(".savenoemail").click();
					},
					'Close': function() {
						$("#divCreateOrder").dialog('close');
					},
					'Reset': function() {
						$("#formCreatesuborder")[0].reset();
						$("#vendorCostCode").prop('selectedIndex',-1);
						$('#vendorCostCode').val('');
						$('.subcontractor_attachments').empty().append('<li class="placeholder">No Files Attached</li>');
						$('.emailGroup').fSelect();
					}
				}
			});
			createUploaders();
			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });

			 //for cost breakdown
	   
		    //Once remove button is clicked
		    $('.field_wrapper').on('click', '.remove_button', function(e){
				console.log('working');
		    	e.preventDefault();
		        $(this).closest('.cost_div').remove(); //Remove field html
		        calcScoSubtotal();
		        var ccIncValue = $('#cocode-inc-value').val();
				ccIncValue = Number(ccIncValue) - 1;
				$('#cocode-inc-value').val(ccIncValue);
		       
		    });

		    $('.cont_wrapper').on('click', '.remove_button', function(e){
		    	e.preventDefault();
		        $(this).closest('.cont_div').remove(); //Remove field html
		        calcScoSubtotal();
		        var ccIncValue = $('#taxcode-inc-value').val();
				ccIncValue = Number(ccIncValue) - 1;
				$('#taxcode-inc-value').val(ccIncValue);
		       
			});
			
			$('.placw').focus(function(){
  			 $(this).data('placeholder',$(this).attr('placeholder'))
          .attr('placeholder','');
			}).blur(function(){
   				$(this).attr('placeholder',$(this).data('placeholder'));
			});
			// for cost analysis
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

		//for taxcost analysis sortable
		$(".contslides").sortable({
			placeholder: 'contdrag-placeholder',
			axis: "y",
			revert: 150,
			start: function(e, ui){
				
				placeholderHeight = ui.item.outerHeight();
				ui.placeholder.height(placeholderHeight + 15);
				$('<div class="contdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				
			},
			change: function(event, ui) {
				
				ui.placeholder.stop().height(0).animate({
					height: ui.item.outerHeight() + 15
				}, 300);
				
				placeholderAnimatorHeight = parseInt($(".contdrag-placeholder-animator").attr("data-height"));
				
				$(".contdrag-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
					height: 0
				}, 300, function() {
					$(this).remove();
					placeholderHeight = ui.item.outerHeight();
					$('<div class="contdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				});
				
			},
			stop: function(e, ui) {
				
				$(".contdrag-placeholder-animator").remove();
				
			},
		});

		}
	} catch(error) {
		if (window.showJSExceptions) {
			var errorMessage = error.message;
			console.log('Exception Thrown: ' + errorMessage);
			return;
		}
	}
}

// To get the subcontractor list
function updateSubcontract(val,user_company,project_id)
{
	//To change the attachment folder name to selected cost code
		var costcode_text=$('#subcontract_costcode option:selected').text();
		var selector = document.getElementById('uploader--request_for_information_attachments--create-request_for_information-record');
		if(selector)
		{
			var filePath ='/Subcontract Change Order/'+costcode_text+'/Attachments/' ;
			selector.setAttribute('virtual_file_path',filePath);
		}
		var exeselector = document.getElementById('uploader--request_for_information_attachments--create-executed_records');
		if(exeselector)
		{
			var filePath ='/Subcontract Change Order/'+costcode_text+'/Attachments/' ;
			exeselector.setAttribute('virtual_file_path',filePath);
		}
		
		var ajaxHandler = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php?method=SubcontractData';
		var ajaxQueryString =
			'cost_code=' + encodeURIComponent(val) +
			'&user_company='+encodeURIComponent(user_company)  +
			'&project_id='+encodeURIComponent(project_id) ;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			dataType: 'Json',
			success: function(res)
			{
				$('#vendorCostCode').empty().append(res.option);
				
			},
		});
}

//To make the amount as dollar
function formatCurValue(element)
{
	try {

		var amount = $(element).val();

		var formattedAmount = parseInputToCurrency(amount);
		var formattedAmount = formatDollar(amount);
		if(formattedAmount=="$0.00")
		{
			$(element).val('');
		}else{
			$(element).val(formattedAmount);
		}

		

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//to add forecast amount
function addForecast()
{
	var check=$('#forecheck').prop('checked');
	var estamount=$('#estamount').val();
	var estnumber = Number(estamount.replace(/[^0-9\.-]+/g,""));
	var forecastamt=$('#forecastamt').val();
	if(check)
	var total = Number(forecastamt)+Number(estnumber);
	else
	var total = Number(forecastamt);	
	var formattedAmount = parseInputToCurrency(total);
	var formattedAmount = formatDollar(total);
	$('#foramount').val(formattedAmount);
}
//Method called After Uploading Attachement File
function SubcontractChangeOrderDraftAttachmentUploaded(arrFileManagerFiles, containerElementId,execute)
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
			if(execute == 'Y')
			{
				// To create the uploader again according to the count
				var executecount = $('#executeval').val();
				var executefolder = $('#executefolder').val();
				executecount = Number(executecount)+1;
				virtual_file_namearr = virtual_file_name.split('_');
				virtual_file_namearr1 = virtual_file_namearr[1].split('.');
				prefixdatarr = virtual_file_namearr[0].split('M -');
				prefixdata =prefixdatarr[1].slice(1);
				var next_file_name = prefixdatarr[1]+'_'+executecount+'.'+virtual_file_namearr1[1];
				
				$("#executive_uploads").empty();
				var project_id =$('#currentlySelectedProjectId').val();
				

			var upload="<div id='uploader--request_for_information_attachments--create-executed_records'  	class='boxViewUploader'	folder_id='"+executefolder+"'  project_id='"+project_id+"' virtual_file_path='"+virtual_file_path+"' virtual_file_name='"+next_file_name+"'	prepend_date_to_filename='1' append_date_to_filename='0'action='/modules-file-manager-file-uploader-ajax.php' method='uploadRequestForInformationAttachment' drop_text_prefix=''	allowed_extensions='pdf,jpg,jpeg,doc,docx,png,gif,xlsx,csv,xls,rtf' post_upload_js_callback='SubcontractChangeOrderDraftAttachmentUploaded(arrFileManagerFiles,&apos;container--executed_records&apos;,&apos;Y&apos;)' ></div>";
			$("#executive_uploads").empty().append(upload);


				$("#uploader--request_for_information_attachments--create-executed_records").attr('virtual_file_name',next_file_name);
				$('#executeval').val(executecount);

				
				
				var htmlRecord = '<li id="' + elementId + '">' +
				'<input type="hidden" class="exefileid" value="'+ file_manager_file_id +'" ><img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order"><a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;' +
				'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>' +
				'</li>';
				createUploaders();
			}else{
			var htmlRecord = '' +
			'<li id="' + elementId + '">' +
				'<input type="hidden" class="upfileid" value="'+ file_manager_file_id +'" ><img src="/images/sortbars.png" style="cursor: pointer;" rel="tooltip" title="" data-original-title="Drag bars to change sort order"><a href="javascript:deleteFileManagerFile(\'' + elementId + '\', \'manage-file_manager_file-record\', \'' + file_manager_file_id + '\');" class="bs-tooltip entypo-cancel-circled" data-original-title="Delete this attachment"></a>&nbsp;' +
				'<a href="' + fileUrl + '" target="_blank">' + virtual_file_name + '</a>' +
			'</li>';
			}

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
//Method For Creating Transmittals 
function SubcontractChangeOrderViaPromiseChain(uniqueId,methodType,emailsend){

	var element = document.getElementById("formCreatesuborder");
	var formValues = {};
	var title    = $("#title").val();
	var subcontract_costcode  = $("#subcontract_costcode").val();
	var vendorCostCode     = $("#vendorCostCode").val();
	var estamount = $("#estamount").val();
	var su_status = $("#su_status").val();
	var description = $("#description").val();
	var status_notes = $("#status_notes").val();

	var su_status = $("#su_status").val();
	var expo_type = $("#expo_reference").val();
	var rfi_reference = $("#rfi_reference").val();
	var sub_create_date = $("#sub_create_date").val();
	var sub_executed_date = $("#sub_executed_date").val();
	var subChange_id=$('#subChange_id').val();

	var file_attachement_id=$("#file_attachement_id").val();
	var costcode_text=$('#subcontract_costcode option:selected').text();

	var mailText = $("#textareaEmailBody").val();

	
	
	var attachmentsArr = {};
	var i =0;
	$( ".upfileid" ).each(function( index ) {
		var upfileval = $(this).val();
  		
  		attachmentsArr[i] =  parseInt(upfileval) ;
  		i++;
	});
	var attachments = JSON.stringify(attachmentsArr);

	var exeattachmentsArr = {};
	var j =0;
	$( ".exefileid" ).each(function( index ) {
		var eupfileval = $(this).val();
  		
  		exeattachmentsArr[j] =  parseInt(eupfileval) ;
  		j++;
	});
	var executeattachments = JSON.stringify(exeattachmentsArr);

	//email 

	var emailTo = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
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
	//End of email 
	

	//For cost breakdown structure

	//For description
	var breakDownDescription = {};
	var breakCount = 0; 
	$("input[name='descript[]']").each(function(){
		var desData = $(this).val();
		desData = desData.replace(/\,/g, '&comma; ');
		desData = desData.replace(/\'/g, '&apos; ');
		breakDownDescription[breakCount] = desData;
		breakCount++;
	});
	var breakDownDescription = JSON.stringify(breakDownDescription);
	
	//For sub data
	var subdata = {};
	var subCount =0; 
	$("input[name='sub[]']").each(function(){
		var subData = $(this).val();
		subData = subData.replace(/\,/g, '&comma; ');
		subData = subData.replace(/\'/g, '&apos; ');
		subdata[subCount] = subData;
		subCount++;
	});
	var subdata = JSON.stringify(subdata);
	
	//For Cost
	var cost = {}; 
	$("input[name='cost[]']").each(function(index){
			cost[index] =$(this).val();
	});
	var cost = JSON.stringify(cost);

	var subtotal =$('#subtotal').val();
	
	//For userdefined content
	var content = {};
	var contentCount = 0; 
	$("input[name='content[]']").each(function(){
		var contentData = $(this).val();
		contentData = contentData.replace(/\,/g, '&comma; ');
		contentData = contentData.replace(/\'/g, '&apos; ');
		content[contentCount] = contentData;
		contentCount++;
	});
	var content = JSON.stringify(content);

	//For Percentage 
	var percentage = {};
	var percentageCount = 0; 
	$("input[name='percentage[]']").each(function(){
		percentage[percentageCount] = $(this).val();
		percentageCount++;
	});
	var percentage = JSON.stringify(percentage);

	//For content total 
	var contotal = {};
	var contotalCount = 0; 
	$("input[name='contotal[]']").each(function(){
		contotal[contotalCount] = $(this).val();
		contotalCount++;
	});
	var contotal = JSON.stringify(contotal);
	
	//For total
	var total =$('#estamount').val();

	var err = false;
	var valPair =[];
	var j='0';
	if(subcontract_costcode == '')
	{
		$("#subcontract_costcode").addClass('redBorderThick');
		err = true;
		valPair[j]='0';
		j++;
	}
	else{
		$("#subcontract_costcode").removeClass('redBorderThick');
		err = false;
		valPair[j]='1';
		j++;
	} 
	if(title == ''){
		$("#title").addClass('redBorderThick');
		err = true;
		valPair[j]='0';
		j++;
	}
	else{
		$("#title").removeClass('redBorderThick');
		err = false;
		valPair[j]='1';
		j++;
	}
	if(estamount == ''){
		$("#estamount").addClass('redBorderThick');
		err = true;
		valPair[j]='0';
		j++;
	}
	else{
		$("#estamount").removeClass('redBorderThick');
		err = false;
		valPair[j]='1';
		j++;
	}
	if($(".required").val() =="")
	{
		$(".required").addClass('redBorderThick');
		err = true;
		valPair[j]='0';
		j++;
	}else{
		$(".required").removeClass('redBorderThick');
		err = false;
		valPair[j]='1';
		j++;
	}
	// if(su_status == ''){
	// 	$("#su_status").addClass('redBorderThick');
	// 	err = true;
	// }
	// else{
	// 	$("#su_status").removeClass('redBorderThick');
	// }
	if(vendorCostCode == ''){
		$("#vendorCostCode").addClass('redBorderThick');
		err = true;
		valPair[j]='0';
		j++;
	}
	else{
		$("#vendorCostCode").removeClass('redBorderThick');
		err = false;
		valPair[j]='1';
		j++;
	}
	
	// if(status_notes == ''){
	// 	$("#status_notes").addClass('redBorderThick');
	// 	err = true;
	// 	valPair[j]='0';
	// 	j++;
	// }
	// else{
	// 	$("#status_notes").removeClass('redBorderThick');
	// 	err = false;
	// 	valPair[j]='1';
	// 	j++;
	// }
	if(description == ''){
		$("#description").addClass('redBorderThick');
		err = true;
		valPair[j]='0';
		j++;
	}
	else{
		$("#description").removeClass('redBorderThick');
		err = false;
		valPair[j]='1';
		j++;
	}

	if((emailTo == '' || emailTo == 0) && emailsend == '1'){
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').addClass('redBorderThick');
		err = true;	
		valPair[j]='0';
		j++;
	}else{
		
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
		err = false;
		valPair[j]='1';
		j++;
	}

	

	var dateerr = '';
	$( "#title" ).keyup(function() {
  		$("#title").removeClass('redBorderThick');		
	});
	$( "#subcontract_costcode" ).change(function() {
  		$("#subcontract_costcode").removeClass('redBorderThick');
		$("#vendorCostCode").removeClass('redBorderThick');	
	});
	$( "#estamount" ).keyup(function() {
  		$("#estamount").removeClass('redBorderThick');		
	});
	$( "#su_status" ).change(function() {
  		$("#su_status").removeClass('redBorderThick');		
	});
	// $( "#rfi_reference" ).change(function() {
 //  		$("#rfi_reference").removeClass('redBorderThick');		
	// });
	$( "#sub_create_date" ).change(function() {
  		$("#sub_create_date").removeClass('redBorderThick');		
	});
	
	// $( "#sub_executed_date" ).change(function() {
 //  		$("#sub_executed_date").removeClass('redBorderThick');		
	// });
	$( "#description" ).keyup(function() {
		$("#description").removeClass('redBorderThick');		
	});
	$( "#status_notes" ).keyup(function() {
		$("#status_notes").removeClass('redBorderThick');		
	});
	$( "#vendorCostCode" ).change(function() {
		$("#vendorCostCode").removeClass('redBorderThick');		
	});

	$( "#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId ).change(function() {
  		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).parent().children(':first-child').removeClass('redBorderThick');
	});
	

		
	if(valPair.indexOf('0') !='-1'){
				messageAlert('Please fill in the highlighted areas.', 'errorMessage');	
				return false;
	}else if(valPair.indexOf('0')=='-1')
	{
		formValues.title = element.title.value;
		formValues.subcontract_costcode = element.subcontract_costcode.value;
		formValues.vendorCostCode=element.vendorCostCode.value;
		formValues.estamount = element.estamount.value;
		formValues.su_status = element.su_status.value;
		formValues.description = element.description.value;
		formValues.sub_create_date = element.sub_create_date.value;
		formValues.expo_type = element.expo_reference.value;
		formValues.rfi_reference = element.rfi_reference.value;
		formValues.costcode_text=costcode_text;
		formValues.attachments= attachments;
		formValues.file_attachement_id= file_attachement_id;
		formValues.executeattachments= executeattachments;
		
		formValues.status_notes= status_notes;
		formValues.sub_executed_date= sub_executed_date;
		formValues.subChange_id= subChange_id;
		formValues.methodType= methodType;
		formValues.emailsend= emailsend;

		formValues.emailTo = emailTo;
		formValues.emailCc = emailCc;
		formValues.emailBCc = emailBCc;
		formValues.mailText = mailText;
		
		//COST BREAKDOWN ANALYSIS

		/**
		 * COST BREAK
		 */
		formValues.breakDownDescription = breakDownDescription;
		formValues.subdata = subdata;
		formValues.cost = cost;
		/**
		 * TAX BREAK
		 */
		formValues.content = content;
		formValues.percentage = percentage;
		formValues.contotal = contotal;

	}
	

	// $(".pod_loader_img").show();
	showSpinner();
	var ajaxUrl = window.ajaxUrlPrefix + 'subcontract-change-order-save.php';
	$.ajax({
			url: ajaxUrl,
			data:{formValues:formValues},
			method:'POST',
			success: arrpotentailSuccessCallbacks
		});
}
// Method call after ajax return s
function arrpotentailSuccessCallbacks(data){
	if (data == 1) { 
		// $(".pod_loader_img").hide();
		hideSpinner();
		//To close the dialog
		$("body").removeClass('noscroll');
		$("#divCreateOrder").addClass('hidden');
		$("#divCreateOrder").dialog('destroy');
		// End To close the dialog

		messageAlert('Successfully saved the record', 'successMessage');	
		setTimeout(function(){
		 gridViewChange();
		// window.location.reload(true);
	},1000);
	}
	if(data == 2){
		// $(".pod_loader_img").hide();
		hideSpinner();
		//To close the dialog
		$("body").removeClass('noscroll');
		$("#divCreateOrder").addClass('hidden');
		$("#divCreateOrder").dialog('destroy');
		// End To close the dialog
		messageAlert('Successfully updated the record', 'successMessage');	
		setTimeout(function(){
		gridViewChange();
		// window.location.reload(true);
	},1000);
	} 
	if(data == 0) {
	
		messageAlert('Please fill in the highlighted areas.', 'errorMessage');
	}
	
}

// To get the subcontractor list
function emailSubChangeOrder(subid,user_company_id,project_id,contact_id)
{
	var modal = document.getElementById('viewsubchange');
	var ajaxHandler = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php?method=emailSubcontractchangeOrder';
		var ajaxQueryString =
			'subid=' + encodeURIComponent(subid) +
			'&user_company_id='+encodeURIComponent(user_company_id)+
			'&contact_id='+encodeURIComponent(contact_id)+
			'&project_id='+encodeURIComponent(project_id) ;
	    showSpinner();

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			dataType: 'Json',
			success: function(res)
			{
				$("#viewsubchange").empty().append(res.dialog);
			    modal.style.display = "block";
			    hideSpinner();

			},
		});
}

// When the user clicks on <span> (x), close the modal
function modalClose() {
	var modal = document.getElementById('viewsubchange');
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
var modal = document.getElementById('viewsubchange');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Method To add  Recipient
function subchangeOrder__addRecipient(element)
{
	try {

		var rfiDummyId = $("#create-request_for_information-record--requests_for_information--dummy_id").val();

		// Get ul.
		var val = $("#" + element.id + " option:selected").val();
		if (val == '') {
			return;
		}
		var html = $("#" + element.id + " option:selected").html();
		var div = $(element).closest('div');
		var ul = div.find('ul');
		var ulId = $(ul).attr('id');
		var a = '<a href="#" onclick="subchangeOrder__removeRecipient(this); return false;">X</a>';
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
// Method To Remove  Recipient
function subchangeOrder__removeRecipient(element)
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
		data:'method=allemail&software_module=subcontract_change_order',
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
		data:'method=rolesemail&val='+val+'&software_module=subcontract_change_order',
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
		data:'method=projectsemail&val='+val+'&software_module=subcontract_change_order',
		success:function(data)
		{
			$('.to_contact').empty().append(data);
			$('.cc_contact').empty().append(data);
			$('.fs-search').empty();
			$('.emailGroup').fSelect('reload');			
		}

	});
}
function email_PotentialOrder(subid,uniqueId)
{

	var emailTo = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
	var mailText =$("#textareaBody").val();
	

	var err=false;
	if(emailTo == ''){
		$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).addClass('redBorderThick');
		err = true;	
	}

	$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).change(function(){
		var emailVal = $("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).val();
		if(emailVal)
			$("#ddl--create-request_for_information-record--requests_for_information--rfi_recipient_contact_id--"+uniqueId).removeClass('redBorderThick');
	});
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
	var upfileval=$('#upfile').val();
	var i =0;
	var attachmentsArr = {};
	attachmentsArr[i] =  parseInt(upfileval) ;
		
	var attachments = JSON.stringify(attachmentsArr);
	var ajaxUrl = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php';
	if(err){
			
			messageAlert('Please fill in the highlighted areas .', 'errorMessage');
		}else{
			showSpinner();
	$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=email_PotentialOrder&emailTo='+emailTo+"&emailCc="+emailCc+"&emailBCc="+emailBCc+"&attachments="+attachments+"&mailContent="+mailText,
		success:function(data)
		{
			if(data=='1')
			{
				hideSpinner();
				modalClose();
			}
		}

	});
	}

}
//To change the view
function gridViewChange()
{
	var value=$("#view_status").val();
	var filteropt=$("#sco_filter").val();
	var inc_pot = $("#in_potential").prop("checked");
	var ch_potential;
	if(inc_pot)
	{
		ch_potential ="Y";
	}else
	{
      		ch_potential ="N";
	}
		showSpinner();
		var ajaxUrl = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php';
		$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=gridViewChange&viewState='+value+'&filteropt='+filteropt+'&checkpotential='+ch_potential,
		success:function(data)
		{
				$('#OrderTable').empty().append(data);
				hideSpinner();
                $('[data-toggle="tooltip"]').tooltip(); 

			
		}

	});
}
//To change the view
function gridViewChangeRegistry()
{
	var value='costcode';
	var filteropt='all';
	var inc_pot = $("#in_potential").prop("checked");
	var ch_potential;
	if(inc_pot)
	{
		ch_potential ="Y";
	}else
	{
      	ch_potential ="N";
	}
		showSpinner();
		var ajaxUrl = window.ajaxUrlPrefix + 'modules-submittals-registry-ajax.php';
		$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=gridViewChange&viewState='+value+'&filteropt='+filteropt+'&checkpotential='+ch_potential,
		success:function(data)
		{
				$('#OrderTable').empty().append(data);
				hideSpinner();
                $('[data-toggle="tooltip"]').tooltip(); 

			
		}

	});
}
function subchange__updateViaPromiseChain(element)
{
	showSpinner();
	var id=element.id;
	var new_val=element.value;
	var id_data=id.split('--');
	var ajaxUrl = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php';
		$.ajax({
		method:'GET',
		url:ajaxUrl,
		data:'method=autoUpdate&table='+id_data[1]+'&column='+id_data[2]+'&primary_id='+id_data[3]+'&new_val='+new_val,
		success:function(data)
		{
			gridViewChange();
			hideSpinner();

		}

	});
}
//To display the data in Change order module
function OwnerChangeOrder(subid,user_company_id,project_id,contact_id)
{
	ChangeOrders__loadCreateCoDialog(null,null,subid);
			
}

// To show the document upload is a popup
function showFileDropdownSub(changeOrder){
	$('.holdSubConChangeOrder').removeClass("show_cont_change_order");
	document.getElementById("fileLinkShow_"+changeOrder).classList.toggle("show_cont_change_order");
	window.onclick = function(event) {
    	if (!event.target.matches('.subConchangeOrderbtn_'+changeOrder)) {

    		var dropdowns = document.getElementsByClassName("dropdown-content-change-order");
    		var i;
    		for (i = 0; i < dropdowns.length; i++) {
    			var openDropdown = dropdowns[i];
    			if (openDropdown.classList.contains('show_cont_change_order')) {
    				openDropdown.classList.remove('show_cont_change_order');
    			}
    		}
    	}
    }
}

//To edit the subcontract change order
function subChangeOrderEdit(id,stst)
{
	
	try {
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var request_for_information_draft_id = '';
		var ajaxHandler = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php?method=subChangeOrderEditDialog';
		var ajaxQueryString =
			
			'attributeGroupName=create-request-for-information-record' +
			'&responseDataType=json&suborderId=' + id;
			 
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
		// 	if (typeof successCallback == 'function') {
		// 		arrSuccessCallbacks.push(successCallback);
		// 	}
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
//To delete the attachement
function deletesubcontractattachment(fileid,suborderId)
{

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php?method=DeleteSubcontractAttachment';
		var ajaxQueryString =			
			'fileid=' +fileid+
			'&suborderId=' + suborderId;
			 
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

				
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){				
			},
		});
		
}

// Method for Edit SubOrder sucess
function suborder__editDialogSuccess(data, textStatus, jqXHR,id,stst)
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

			//For buttons in dialog
			var buttons ={
				'Save as SCO and Notify team': function() {
						$(".savemail").click();
					},
					'Save as SCO no email': function() {
						$(".savenoemail").click();
					},
					'View SCO PDF': function() {
						$(".viewpdf").click();
					},					
					'Close': function() {
						$("#divCreateOrder").dialog('close');
					},
					'Reset': function() {
						$("#formCreatesuborder")[0].reset();
					}
				};

			//Add another button to that object if some condition is true
			if(stst =='1') {
				buttons['Delete'] = function() {
					subChangeOrderDelete(id);
					$("#divCreateOrder").dialog('close');
				};
			}

			
			$("#divCreateOrder").html(htmlContent);
			$("#divCreateOrder").removeClass('hidden');
			$("#divCreateOrder").dialog({
				modal: true,
				title: 'Edit Subcontract Change Order — '+$("#currentlySelectedUserCompanyName").val()+' — '+$("#currentlySelectedProjectName").val(),
				width: dialogWidth,
				height: dialogHeight,
				open: function() {
					$("body").addClass('noscroll');
					$('.emailGroup').fSelect();
				},
				close: function() {
					$("body").removeClass('noscroll');
					$("#divCreateOrder").addClass('hidden');
					$("#divCreateOrder").dialog('destroy');
				},
				buttons: buttons,
			});
			createUploaders();
			$(".bs-tooltip").tooltip();
			$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
			$('.placw').focus(function(){
  			 $(this).data('placeholder',$(this).attr('placeholder'))
          .attr('placeholder','');
			}).blur(function(){
   				$(this).attr('placeholder',$(this).data('placeholder'));
			});

			//for cost breakdown
	   
		    //Once remove button is clicked
		    $('.field_wrapper').on('click', '.remove_button', function(e){
				console.log('working');
		    	e.preventDefault();
		        $(this).closest('.cost_div').remove(); //Remove field html
		        calcScoSubtotal();
		        var ccIncValue = $('#cocode-inc-value').val();
				ccIncValue = Number(ccIncValue) - 1;
				$('#cocode-inc-value').val(ccIncValue);
		       
		    });

		    $('.cont_wrapper').on('click', '.remove_button', function(e){
		    	e.preventDefault();
		        $(this).closest('.cont_div').remove(); //Remove field html
		        calcScoSubtotal();
		        var ccIncValue = $('#taxcode-inc-value').val();
				ccIncValue = Number(ccIncValue) - 1;
				$('#taxcode-inc-value').val(ccIncValue);
		       
			});
			// sortable
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

		// tag sortable
		$(".contslides").sortable({
			placeholder: 'contdrag-placeholder',
			axis: "y",
			revert: 150,
			start: function(e, ui){
				
				placeholderHeight = ui.item.outerHeight();
				ui.placeholder.height(placeholderHeight + 15);
				$('<div class="contdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				
			},
			change: function(event, ui) {
				
				ui.placeholder.stop().height(0).animate({
					height: ui.item.outerHeight() + 15
				}, 300);
				
				placeholderAnimatorHeight = parseInt($(".contdrag-placeholder-animator").attr("data-height"));
				
				$(".contdrag-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
					height: 0
				}, 300, function() {
					$(this).remove();
					placeholderHeight = ui.item.outerHeight();
					$('<div class="contdrag-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
				});
				
			},
			stop: function(e, ui) {
				
				$(".contdrag-placeholder-animator").remove();
				
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


// Method To add Subchnage Recipient
function Subchange__addRecipient(element)
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
		var a = '<a href="#" onclick="Subchange__removeRecipient(this); return false;">X</a>';
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

// Method To Remove sub change Recipient
function Subchange__removeRecipient(element)
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

//To download the current view as PDF

function downloadSubcontractPDF()
{
	var options = options || {};
	var promiseChain = options.promiseChain;
	
	var view_option = $("#view_status").val();
	var filteropt = $("#sco_filter").val();
	var inc_pot = $("#in_potential").prop("checked");
	var ch_potential;
	if(inc_pot)
	{
		ch_potential ="Y";
	}else
	{
      		ch_potential ="N";
	}
	
	showSpinner();
	var ajaxHandler = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php?method=SubcontractListViewAsPdf';
		var ajaxQueryString =
			'responseDataType=json&view_option='+view_option+'&filteropt='+filteropt+'&checkpotential='+ch_potential;
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
			success: downloadSubcontractPDFSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

	
}

function downloadSubcontractPDFSuccess(data, textStatus, jqXHR)
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
			hideSpinner();
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

//To open the file manager file
function SubChangeOrders__openCoPdfInNewTab(url)
{
	window.open(url, '_blank');
}
//To delete the SCO
function subChangeOrderDelete(id)
{
	$("#dialog-confirm").html("Are you sure you want to delete this SCO?");
	$("#dialog-confirm").dialog({
		resizable: false,
		modal: true,
		title: "Confirmation",
		buttons: {

			"No": function () {
				$(this).dialog('close');
				$("body").removeClass('noscroll');

			},
			"Yes": function () {
				$(this).dialog('close');
				$("body").removeClass('noscroll');
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		var ajaxHandler = window.ajaxUrlPrefix + 'subcontract-change-order-ajax.php?method=DeleteSCO';
		var ajaxQueryString = 'suborderId=' + id;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
				gridViewChange();
			},
		});
	}
	}
	});

}
//To delete the SCO
function submittalRegistryDelete(id)
{
	$("#dialog-confirm").html("Are you sure you want to delete this Submittal Registry?");
	$("#dialog-confirm").dialog({
		resizable: false,
		modal: true,
		title: "Confirmation",
		buttons: {

			"No": function () {
				$(this).dialog('close');
				$("body").removeClass('noscroll');

			},
			"Yes": function () {
				$(this).dialog('close');
				$("body").removeClass('noscroll');
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-submittals-registry-ajax.php?method=DeleteSCO';
		var ajaxQueryString = 'subRegId=' + id;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
				gridViewChangeRegistry();
			},
		});
	}
	}
	});

}


function calcScoSubtotal()
{
	initDecimalValue();
	setTimeout(function(){

	var stotal =0;
	$("input[name^='cost']").each(function (index, elem) {
		
		if($(this).attr('id')=="cost[]")
		{
			var val=parseFloat($(this).val());
		}
		if(!isNaN(val))
		{
			stotal += val;
		}
		
	});
	$("#subtotal").val(stotal.toFixed(2));
	$("#subhidden").val(stotal.toFixed(2));

	var k=0;
	var genperval=0;

	$("input[name^='percentage']").each(function () {
		var perval=parseFloat($(this).val());
		if(!isNaN(perval)  && perval!='')
		{
			genperval = stotal*(perval/100);
			genperval= genperval.toFixed(2);
			$('input[name="contotal[]"]').eq(k).val(genperval);
			
		}
		k++;
	});
	var genpertotal=0;
	$("input[name^='contotal']").each(function () {
		var totval=parseFloat($(this).val());
		if(!isNaN(totval))
		{
			genpertotal += totval;
		}
		
	});

	//To generate the grand Total
	var grandTotal=stotal+genpertotal;
	grandTotal=grandTotal.toFixed(2); 
	$('#estamount').val(grandTotal);
	$('#maintotal').val(grandTotal);
	var formattedAmount = grandTotal;
	$('.inputDollarAmount ').val(formattedAmount);
	},1000);

}

 function initDecimalValue(){
    $('.sub_input_value').on('input',function() {

    	var amount = this.value;
    	var amount = amount.replace(/[^-0-9\.]+/g, '');
input.replace(/[^-0-9\.]+/g, '');
	// Replace repeating - with just one -
	amount = amount.replace(/[-]+/g, '-');

	// Replace everything at the end of the input with just numbers 0-9: this removes a single "-" that was at the end of the input
	this.value = amount.replace(/[^0-9\.]+$/g, '');

    });
  };

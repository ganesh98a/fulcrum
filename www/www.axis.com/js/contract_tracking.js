$(document).ready(function() {

	createUploaders();
	$(".picker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/y', numberOfMonths: 1 });
	$(".inputDateTrack").change(function(){
		expiredOrNot(this.value,this.id);
});
});

//To check  a date expired or not in ajax
function expiredOrNot(data,id,test)
{
	var date = new Date();
	var minDate =(date.getDate()) < 9 ? '0': '';
	var mdate = minDate+ (date.getDate()) ;

	var minMonth = (date.getMonth() + 1 ) < 9 ? '0': '';
	var Month = minMonth+ (date.getMonth()+1) ;

  	var minYear = date.getFullYear();
  	var Year = minYear.toString().substr(2, 2);

	var current=Month+'/'+mdate+'/'+Year;
	
	if(Date.parse(data)-Date.parse(new Date()) <= 0)
	{
		$('#'+id).css('color', 'red');
	} else {
		if(test)
		{
			$('#'+id).css('color', '#06c');
		}else{
			$('#'+id).css('color', 'black');
		}
	}
	if(data == current)
	{
		if(test)
		{
			$('#'+id).css('color', '#06c');
		}else
		{
		$('#'+id).css('color', 'black');
		}
	}

  
} 
//To upload a signed document in contract tracking Page
function signed(gc_budget_line_item_id,subcontractor_bid_id,code_name){
try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);
		var project_id=$('#project_id').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=signed';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&project_id='+encodeURIComponent(project_id) +
			'&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id);
			//'&companyName=' + encodeURIComponent(companyName);
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
			success:function(data)
			{
				renderSubcontractorsignedSuccess(data,subcontractor_bid_id,code_name);
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
//Success function for  upload a signed document in contract tracking Page

function renderSubcontractorsignedSuccess(data,subcontractor_bid_id,code_name)
{
	try {
		var dialogContainer = $("#divModalWindow").parent();
		$("#divModalWindow2").removeClass('hidden');
		$("#divModalWindow2").empty().html(data);
		$(".bs-tooltip").tooltip();
		var companyName = $("#titleCompanyName").val();

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		//var dialogWidth = windowWidth * 0.99;
		//var dialogHeight = windowHeight * 0.99;
		var dialogWidth = windowWidth * 0.7;
		var dialogHeight = windowHeight * 0.7;
		$("#divModalWindow2").dialog({
			height: '200',
			width: '500',
			modal: true,
			title: 'Signed '+code_name,
			open: function() {
				$("body").addClass('noscroll');
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.hide();
				}
			},
			close: function() {
				$("body").removeClass('noscroll');
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.show();
				}
				$("#divModalWindow2").empty();
				$("#divModalWindow2").dialog('destroy');
				signedDocData(subcontractor_bid_id);
			}
			// , buttons: {
	  //       	'Close': function() {
	  //       		$(this).dialog('close');
	  //       	}
			// } 
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
//To fecth the date for the document
function signedDocData(subcontractor_bid_id)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=signedDocumentsDate';
		var ajaxQueryString =
			'subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) ;
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
			success: function(data){
				var valData=data.split('~');
				$('#signeddocument_'+subcontractor_bid_id).html(valData[0]);
				if(valData[1]=='1')
				{
					$('#signeddocument_'+subcontractor_bid_id).css('color','');
				}
			},
			
			error: errorHandler
		});
}
// To upload a defalut document in contract tracking Page
function defaultDocuments(gc_budget_line_item_id,subcontractor_bid_id,companyName,subcontract_template_id,id,template_id){
		try{
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);
		//var companyName = $.trim($("#bidderCompany_" + subcontractor_bid_id).html());
		var project_id=$('#project_id').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=defaultDocuments';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&project_id='+encodeURIComponent(project_id) +
			'&companyName='+encodeURIComponent(companyName) +
			'&subcontractor_bid_id=' + encodeURIComponent(subcontractor_bid_id) +
			'&subcontract_template_id=' + encodeURIComponent(subcontract_template_id);
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
			success: function(data){
				renderSubcontractorDefaultSuccess(data,subcontractor_bid_id,subcontract_template_id);
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

//Success function for  upload a Default document in contract tracking Page
function renderSubcontractorDefaultSuccess(data,subcontractor_bid_id,subcontract_template_id)
{
	
	try {
		var dialogContainer = $("#divModalWindow").parent();
		$("#divModalWindow2").removeClass('hidden');
		$("#divModalWindow2").empty().html(data);
		$(".bs-tooltip").tooltip();
		var Cname= $(".gc_budget_line_items--vendorList-"+subcontractor_bid_id).html();
		var companyName = $("#titleCompanyName").val()+Cname;

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		
		var dialogWidth = windowWidth * 0.99;
		var dialogHeight = windowHeight * 0.99;
		$("#divModalWindow2").dialog({
			height: dialogHeight,
			width: "1000px",
			modal: true,
			title: companyName,
			open: function() {
				$("body").addClass('noscroll');
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.hide();
				}
			},
			close: function() {
				$("body").removeClass('noscroll');
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.show();
				}
				$("#divModalWindow2").empty();
				$("#divModalWindow2").dialog('destroy');
				trackDynamicDocData(subcontractor_bid_id,subcontract_template_id);
			}
			, buttons: {
	        	'Close': function() {
	        		$(this).dialog('close');
	        	}
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
//To fecth the date for the document
function trackDynamicDocData(subcontractor_bid_id, subcontract_template_id)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=templateDocumentsDate&subcontractor_bid_id='+encodeURIComponent(subcontractor_bid_id)+'&subcontract_template_id='+subcontract_template_id;
		var ajaxUrl = ajaxHandler ;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: '',
			type:'JSON',
			success: function(data){
			var Count=$('#dynamicHeadCount').val();
			var json = $.parseJSON(data);
              for (var i=1; i<= Count; i++)
        {
        	$("#updateDocument_"+subcontractor_bid_id+"-"+i).html(json[i]);
        	if(json[i]=='ADD')
        	{
        		$("#updateDocument_"+subcontractor_bid_id+"-"+i).css('color','red');
        	}else if(json[i]==' - ')
        	{
        		$("#updateDocument_"+subcontractor_bid_id+"-"+i).css('color','');
        	}else
        	{
        		$("#updateDocument_"+subcontractor_bid_id+"-"+i).css('color','');
        	}
        }
				
			},
			
			error: errorHandler
		});
}
//To upload a Additional Documents
function AdditionalDocumentUploaded(arrFileManagerFiles, containerElementId,subcontract_id,gc_budget_line_item_id,type)
{
	var fileManagerFile = arrFileManagerFiles[0];
	var virtual_file_name = fileManagerFile.virtual_file_name;
	var fileUrl = fileManagerFile.fileUrl;
	var file_id =fileManagerFile.file_manager_file_id;
	var list_id='';
	$('#fileManagerFile').val(fileManagerFile);
	$('#virtual_file_name').val(virtual_file_name);
	$('#fileUrl').val(fileUrl);
	$('#file_id').val(file_id);
	$('#list_id').val(list_id);

	if(type == '1')
	{
		list_id='record_additional_container_';
		var a = '<li id="'+list_id+file_id+'"><a class="bs-tooltip  fakeHref" data-toggle="tooltip" data-placement="top" target="_blank" href="' + fileUrl + '" title="' + virtual_file_name + '">'+virtual_file_name+'</a><a class="trackDocumentClose bs-tooltip smallerFont entypo-cancel-circled" title="" href="javascript:DeletesubcontactorAdditionalDocument('+subcontract_id+','+gc_budget_line_item_id+','+file_id+',&apos;'+list_id+file_id+'&apos;,'+type+');" data-original-title="Delete This document"></a></li>';
	}else
	{
		list_id='record_prelim_container_';
		var char = virtual_file_name.length;
		if(char > 25){
			var text = virtual_file_name.substring(0, 25);
			text = text+'....';
		}else{
			var text = virtual_file_name;
		}
		var a = '<li id="'+list_id+file_id+'"><a class="bs-tooltip  fakeHref" data-toggle="tooltip" data-placement="top" target="_blank" href="' + fileUrl + '" title="' + virtual_file_name + '">'+text+'</a><a class="trackDocumentClose bs-tooltip smallerFont entypo-cancel-circled" title="" href="javascript:DeletesubcontactorAdditionalDocument('+subcontract_id+','+gc_budget_line_item_id+','+file_id+',&apos;'+list_id+file_id+'&apos;,'+type+');" data-original-title="Delete This document"></a></li>';
	}
	
	$(".No_data_"+containerElementId).remove();
	if(type == '1')
	{
		$("#" + containerElementId).append(a);
	}else{
		var checkExists = 0;
		
		$("#" + containerElementId).children().each(function(i) {
			if ($(this).hasClass('placeholder')) {
				$(this).remove();
			}else{
				checkExists++;
			}
		});
		var datGet = $('#prelims_documents_upload_file_manager_folder_id').val();
		if(checkExists!=0 && datGet!=''){			
			var dataSplit = datGet.split(',');
			DeletesubcontactorAdditionalDocument(dataSplit[0],dataSplit[1],dataSplit[2],'',3);
		}
		var data = subcontract_id+','+gc_budget_line_item_id+','+file_id+',&apos;'+list_id+file_id+'&apos;,'+type;
		$('#prelims_documents_upload_file_manager_folder_id').val(data);
		$("#" +containerElementId).empty().append(a);
	// $("#record_additional_container").remove();
	}
	$('.bs-tooltip').tooltip();

	// var element = $("#" + containerElementId)[0];
	// flashHighlightElement(element);
}

//To Delete the Additional Documents
function DeletesubcontactorAdditionalDocument(subcontract_id,gc_budget_line_item_id,file_id,ElementId,type)
{

	if(type =='1')
	{
		$("#dialog-confirm").html("Are you sure you want to delete this Additional Document?");
	}
	else if(type =='3')
	{
		$("#dialog-confirm").html("Prelims Document exist previously Are you sure to delete that Notice?");
	}else
	{
		$("#dialog-confirm").html("Are you sure you want to delete this Prelim Notice?");
	}
    $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	title: "Warning",
    	buttons: {

    		"No": function () {
    			$(this).dialog('close');
    			$("body").removeClass('noscroll');

    		},
    		"Yes": function () {
    			$(this).dialog('close');
    			$("body").removeClass('noscroll');

    			if(Number(type) == 2){
    				$('#prelims_documents_upload_file_manager_folder_id').val('');
    			}
    			var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=deleteAdditionalDocuments';
    			var ajaxQueryString =
    			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
    			'&file_id='+encodeURIComponent(file_id)+
    			'&subcontract_id='+encodeURIComponent(subcontract_id);
    			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
    			var returnedJqXHR = $.ajax({
    				url: ajaxHandler,
    				data: ajaxQueryString,
    				success: function(){
    					$("#"+ElementId).remove();
    				}
    			});
    		}
    	}
    });

	
}
//To Delete the Additional Documents
function DeletesubcontactorAdditionalDocumentWithPrelim(subcontract_id,gc_budget_line_item_id,file_id,ElementId,type,prelim_id)
{
	$("#dialog-confirm").html("Are you sure you want to delete this Prelim Notice?");
	$("#dialog-confirm").dialog({
		resizable: false,
		modal: true,
		title: "Warning",
		buttons: {

			"No": function () {
				$(this).dialog('close');
				$("body").removeClass('noscroll');

			},
			"Yes": function () {
				$(this).dialog('close');
				$("body").removeClass('noscroll');

				if(Number(type) == 2){
					$('#prelims_documents_upload_file_manager_folder_id').val('');
				}

				var nodataLi = "<li class='No_data_prelims_documents_"+subcontract_id+"'>No Data Found</li>";
				var nodatatr = "<tr class='nodatafounttr'><td colspan='4'>No Data Found</td></tr>";
				var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=deleteAdditionalDocumentsWithPrelim';
				var ajaxQueryString =
				'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
				'&file_id='+encodeURIComponent(file_id)+
				'&prelim_id='+encodeURIComponent(prelim_id)+
				'&subcontract_id='+encodeURIComponent(subcontract_id);
				var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
				var returnedJqXHR = $.ajax({
					url: ajaxHandler,
					data: ajaxQueryString,
					success: function(){
						$("#"+ElementId).remove();
						$("#record_prelim_container_"+prelim_id).remove();
						var ulLength = $('#prelims_documents_'+subcontract_id).children().length;
						var trLength = $('#preliminaryTableDataTbody').children().length;
						if(ulLength == 0){
							$('#prelims_documents_'+subcontract_id).empty().append(nodataLi);
						}
						if(trLength == 0){
							$('#preliminaryTableDataTbody').empty().append(nodatatr);
						}
					}
				});
			}
		}
	});

	
}

//To add a subcontractor Notice
function subcontractorNotice(subcontract_id,ContactId)
{
	
	var notes=$('#notes_'+subcontract_id).val();
	if(notes=='')
	{
		$('#notes_'+subcontract_id).addClass('redBorderThick');
	}else
	{
		$('#notes_'+subcontract_id).removeClass('redBorderThick');
		$('#save').attr("disabled",true);
	var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=AddNotes';
	var ajaxQueryString =
			'&ContactId='+encodeURIComponent(ContactId)+
			'&subcontract_id='+encodeURIComponent(subcontract_id)+
			'&notes='+encodeURIComponent(notes);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data){
				$('#notes_'+subcontract_id).val('');
				$('#save').removeAttr('disabled');
				$('#notes_item_'+subcontract_id).prepend(data);

			}
		});
	}
}
// When the user clicks on <span> (x), close the modal
function modalClose() {
	var modal = document.getElementById('sendpopup');
    modal.style.display = "none";
}
// All documnet present
function Chkdocument(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,costCodeLabel)
{
	var allDoc=$('#allDoc_'+subcontract_id).val();
	if(allDoc == 'N')
	{
	var modal = document.getElementById('sendpopup');
	var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=documentmodal';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id) +
		'&execution_date=' + encodeURIComponent(execution_date) +
		'&mailed_date=' + encodeURIComponent(mailed_date) +
		'&costCodeLabel=' + encodeURIComponent(costCodeLabel) +
		'&subcontract_id=' + encodeURIComponent(subcontract_id) ;

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
			$('#sendpopup').empty().html(res);
		    modal.style.display = "block";
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
			}
		});

	}else
	{
		sendBackModal(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,costCodeLabel);
	}
	}

// To generate final subcontractor
function sendBackModal(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,costCodeLabel)
{
	try {
		window.savePending = true;
		var send_back=$('#sendBack_'+subcontract_id).val();

		if(send_back !='0'){
				var modal = document.getElementById('sendpopup');

			var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=sendbackmodal';
		var ajaxQueryString =
		'send_back=' + encodeURIComponent(send_back) +
		'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id) +
		'&execution_date=' + encodeURIComponent(execution_date) +
		'&mailed_date=' + encodeURIComponent(mailed_date) +
		'&costCodeLabel=' + encodeURIComponent(costCodeLabel) +
		'&subcontract_id=' + encodeURIComponent(subcontract_id) ;

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
			$('#sendpopup').empty().html(res);
		    modal.style.display = "block";
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
			}
		});
			

		}else
		{
			ContractgenerateFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,costCodeLabel);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// To generate final subcontractor
function ContractgenerateFinalSubcontract(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,costCodeLabel)
{
	try {
		window.savePending = true;
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-gc-budget-ajax.php?method=generateFinalSubcontract';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id) +
		'&subcontract_id=' + encodeURIComponent(subcontract_id) +
		'&execution_date=' + encodeURIComponent(execution_date) +
		'&mailed_date=' + encodeURIComponent(mailed_date) ;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		showSpinner();

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(){
				modalClose();
				updateSendBack(subcontract_id,gc_budget_line_item_id,costCodeLabel);
		

			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
				hideSpinner();
			}
		});
	

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
// To update the send back data
function updateSendBack(subcontract_id,gc_budget_line_item_id,costCodeLabel)
{
	// update send back date
	var send_back=$('#sendBack_'+subcontract_id).val();
		var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=updateSendBackData';
		var ajaxQueryString =
		'send_back=' + encodeURIComponent(send_back) +
		'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id)+
		'&costCodeLabel=' + encodeURIComponent(costCodeLabel)+
		'&subcontract_id=' + encodeURIComponent(subcontract_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
		var ary = res.split("~");
		var sendbackcount = ary[0];
		var updateDate = ary[1];
			$('#sendBack_'+subcontract_id).val(sendbackcount);
			$('#updatedateforsendBack_'+subcontract_id).html(updateDate);
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
			}
		});
		// update send back date
}
/*Prelims create section start here*/
function uploadPrelimsClose(){
	$('#createPrelims').hide();
}
function uploadPrelims(subcontract_id){
		var gc_budget_line_item_id = $("#gc_budget_line_item_id").val();
		var fileUploadDirectoryprelims = $("#fileUploadDirectoryprelims").val();
		var encoded_virtual_file_name = $("#encoded_virtual_file_name").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=uploadPrelims';
		var ajaxQueryString =
		'&subcontract_id=' + encodeURIComponent(subcontract_id)+
		'&gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id)+
		'&encoded_virtual_file_name=' + encodeURIComponent(encoded_virtual_file_name)+
		'&fileUploadDirectoryprelims=' + encodeURIComponent(fileUploadDirectoryprelims);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.99;
		var dialogHeight = windowHeight * 0.99;

		var dialogContainer = $("#createPrelims").parent();
		$("#createPrelims").removeClass('hidden');
		$(".bs-tooltip").tooltip();

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
				$('#createPrelims').empty().html(res);
				$(".picker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
				 $("#createPrelims").dialog({
				 	height: "360",
				 	width: "490",
				 	modal: true,
				 	title: 'Create Prelims',
				 	open: function() {
				 		$("body").addClass('noscroll');
				 		if (dialogContainer.hasClass('ui-dialog')) {
				 			dialogContainer.hide();
				 		}
				 	},
				 	close: function() {
				 		// $("body").removeClass('noscroll');
				 		if (dialogContainer.hasClass('ui-dialog')) {
				 			dialogContainer.show();
				 		}
				 		$("#createPrelims").empty();
				 		$("#createPrelims").dialog('destroy');
				 	}
				 	,buttons: {
				 		'Create': function() {
				 			saveCreatePrelimsDocument(subcontract_id);
				 		},
				 		'Close': function() {
				 			$(this).dialog('close');
				 		}
				 	} 
				 });
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
			}
		});
}
/*update prelim item*/
function updatePrelims(prelim_id){
		var fileUploadDirectoryprelims = $("#fileUploadDirectoryprelims").val();
		var encoded_virtual_file_name = $("#encoded_virtual_file_name").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=updatePrelims';
		var ajaxQueryString =
		'&prelim_id=' + encodeURIComponent(prelim_id)+
		'&encoded_virtual_file_name=' + encodeURIComponent(encoded_virtual_file_name)+
		'&fileUploadDirectoryprelims=' + encodeURIComponent(fileUploadDirectoryprelims);

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		var dialogWidth = windowWidth * 0.99;
		var dialogHeight = windowHeight * 0.99;

		var dialogContainer = $("#createPrelims").parent();
		$("#createPrelims").removeClass('hidden');
		$(".bs-tooltip").tooltip();

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
				$('#createPrelims').empty().html(res);
				createUploaders();
				$(".bs-tooltip").tooltip();
				$(".picker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
				 $("#createPrelims").dialog({
				 	height: "360",
				 	width: "490",
				 	modal: true,
				 	title: 'Update Prelims',
				 	open: function() {
				 		$("body").addClass('noscroll');
				 		if (dialogContainer.hasClass('ui-dialog')) {
				 			dialogContainer.hide();
				 		}
				 	},
				 	
				 	buttons: {
				 		'Save': function() {
				 			var subcontract_id = $("#subcontract_id").val();
				 			var subcontract_template_id = $("#subcontract_template_id").val();
				 			saveUpdatePrelimsDocument(prelim_id, subcontract_id, subcontract_template_id);
				 		},
				 		'Close': function() {
				 			closeUpdateCheck();
				 			// $(this).dialog('close');
				 		}
				 	} 
				 });
				 $('.ui-dialog-titlebar-close').css('display','none');
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
			}
		});
}
function closeUpdateCheckCommon(){
	$('#createPrelims').dialog('close');
		var dialogContainer = $("#createPrelims").parent();
		if (dialogContainer.hasClass('ui-dialog')) {
			dialogContainer.show();
		}
		$("#createPrelims").empty();
		$("#createPrelims").dialog('destroy');
}
function closeUpdateCheck(){
	var jsonOld = JSON.parse($("#json_old").val());
	var create_prelims_supplier = $('#create_prelims_supplier').val();
	var create_prelims_amount = $('#create_prelims_amount').val();
	var create_prelims_receive_date = $('#create_prelims_receive_date').val();
	var create_prelims_released_date = $('#create_prelims_released_date').val();
	var checkUpload = $('#prelims_documents_upload_file_manager_folder_id').val();
	var jsonNew = [];
	var i = 0;
	if(jsonOld.supplier != create_prelims_supplier){
		jsonNew[i] = 1;
		// alert(jsonOld.supplier+' !='+ create_prelims_supplier);
	}else{
		jsonNew[i] = 0;
	}
	i++;
	if(jsonOld.amount != create_prelims_amount){
		jsonNew[i] = 1;
		// alert(jsonOld.amount+' !='+ create_prelims_amount);
	}else{
		jsonNew[i] = 0;
	}
	i++;
	if(jsonOld.received_date != create_prelims_receive_date){
		jsonNew[i] = 1;
		// alert(jsonOld.received_date+' !='+ create_prelims_receive_date);
	}else{
		jsonNew[i] = 0;
	}
	i++;
	if(jsonOld.released_date != create_prelims_released_date){
		jsonNew[i] = 1;
		// alert(jsonOld.released_date+' !='+ create_prelims_released_date);
	}else{
		jsonNew[i] = 0;
	}
	i++;
	if(jsonOld.prelims_documents_upload_file_manager_folder_id != checkUpload){
		jsonNew[i] = 1;
		// alert(jsonOld.prelims_documents_upload_file_manager_folder_id+' !='+ checkUpload);
	}else{
		jsonNew[i] = 0;
	}
	var jsonEncodeNew = JSON.stringify(jsonNew);
	var checkvalidate = $.inArray(1, jsonNew) > -1;
	if(checkvalidate){
		messageAlert('Please save your changes', 'errorMessage');
		return false;
	}else{
		$('#divAjaxLoading').css('display','none');
		$('#createPrelims').dialog('close');
		var dialogContainer = $("#createPrelims").parent();
		if (dialogContainer.hasClass('ui-dialog')) {
			dialogContainer.show();
		}
		$("#createPrelims").empty();
		$("#createPrelims").dialog('destroy');
	}
}
/*update prelims data in db*/
function saveUpdatePrelimsDocument(prelim_id, subcontractor_bid_id, subcontract_template_id){
	var create_prelims_supplier = $('#create_prelims_supplier').val();
	var create_prelims_amount = $('#create_prelims_amount').val();
	var create_prelims_receive_date = $('#create_prelims_receive_date').val();
	var create_prelims_released_date = $('#create_prelims_released_date').val();
	var errecheck = false;
	$( "#create_prelims_supplier" ).keyup(function() {
		$("#create_prelims_supplier").removeClass('redBorderThick');
	});
	$( "#create_prelims_amount" ).keyup(function() {
		if(!isNaN(create_prelims_amount)){
			$("#create_prelims_amount").removeClass('redBorderThick');
		}
	});
	$( "#create_prelims_receive_date" ).change(function() {
		$("#create_prelims_receive_date").removeClass('redBorderThick');
	});
	
	if(create_prelims_supplier == ''){
		$('#create_prelims_supplier').addClass('redBorderThick');
		errecheck = true;
	}
	if(create_prelims_amount == ''){
		$('#create_prelims_amount').addClass('redBorderThick');
		errecheck = true;
	}
	if(create_prelims_amount != '' && isNaN(create_prelims_amount) == true){
			$('#create_prelims_amount').addClass('redBorderThick');
			errecheck = true;
			messageAlert('Numeric values only allowed', 'errorMessage');
			return false;
	}
	if(create_prelims_receive_date == ''){
		$('#create_prelims_receive_date').addClass('redBorderThick');
		errecheck = true;
	}
	
	var checkUpload = $('#prelims_documents_upload_file_manager_folder_id').val();
	if(checkUpload == '' && errecheck != true){
		messageAlert('Please attach a preliminary notice document', 'errorMessage');
		return false;
	}
	if(errecheck == true){
		messageAlert('Please fill in the highlighted areas .', 'errorMessage');
		return false;
	}else{
		var checkUpload = $('#prelims_documents_upload_file_manager_folder_id').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=saveupdatePrelims';
		
		var fileManagerFile = $('#fileManagerFile').val();
		var virtual_file_name = $('#virtual_file_name').val();
		var fileUrl = $('#fileUrl').val();
		var subcontract_id = $('#subcontract_id').val();
		var file_id = $('#file_id').val();
		var old_file_id = $('#old_file_id').val();
		var list_id = "record_prelim_container_";
		var gc_budget_line_item_id = $('#gc_budget_line_item_id').val();
		var a = '<a class="bs-tooltip  fakeHref" data-toggle="tooltip" data-placement="top" target="_blank" href="' + fileUrl + '" title="' + virtual_file_name + '">'+virtual_file_name+'</a><a class="trackDocumentClose bs-tooltip smallerFont entypo-cancel-circled" title="" href="javascript:DeletesubcontactorAdditionalDocumentWithPrelim('+subcontract_id+','+gc_budget_line_item_id+','+file_id+',&apos;'+list_id+file_id+'&apos;,2,'+prelim_id+');" data-original-title="Delete This document"></a>';
		var ajaxQueryString =
		'upload_document=' + encodeURIComponent(checkUpload) +
		'&prelim_id=' + encodeURIComponent(prelim_id) +
		'&create_prelims_supplier=' + encodeURIComponent(create_prelims_supplier) +
		'&create_prelims_amount=' + encodeURIComponent(create_prelims_amount)+
		'&create_prelims_receive_date=' + encodeURIComponent(create_prelims_receive_date)+
		'&create_prelims_released_date=' + encodeURIComponent(create_prelims_released_date)+
		'&document_url=' + encodeURIComponent(fileUrl);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
				$("#prelims_documents_"+subcontract_id).children().each(function(i) {
					if ($(this).hasClass('placeholder')) {
						$(this).remove();
					}
				});
				if(file_id!=''){
					$("#"+list_id+old_file_id).empty().html(a);
				}
				// alert("#"+list_id+old_file_id+'  =  '+a);
				var json = JSON.parse(res);
				$("#preliminaryTableDataTbody").children().each(function(i) {
					if ($(this).hasClass('nodatafounttr')) {
						$(this).remove();
					}
				});
				$("#record_prelim_container_"+prelim_id).empty().html(json.data);
				$(".bs-tooltip").tooltip();
				messageAlert('Preliminary notice successfully updated', 'successMessage');
				updatePrelimDataAttachment(subcontract_id, subcontract_template_id);
				$('#createPrelims').dialog('close');
				var dialogContainer = $("#createPrelims").parent();
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.show();
				}
				$("#createPrelims").empty();
				$("#createPrelims").dialog('destroy');
				
				$('#divAjaxLoading').css('display','none');
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
			}
		});
	}
}

/*
 * Update the prelims data attachment after user save the prelims
 * param {int} subcontract_id
 * param {int} subcontract_template_id
 */
function updatePrelimDataAttachment(subcontract_id, subcontract_template_id) {
	var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=prelimAttachment';
	var ajaxQueryString =
		'subcontract_id=' + encodeURIComponent(subcontract_id) +
		'&subcontract_template_id=' + encodeURIComponent(subcontract_template_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
				var json = JSON.parse(res);
				$('#prelims_documents_'+subcontract_id).empty().html(json.data);
			},
		error: errorHandler,
		complete: function(jqXHR, textStatus) {
		}
	});
}

/*save prelims data in db*/
function saveCreatePrelimsDocument(subcontract_id){
	var create_prelims_supplier = $('#create_prelims_supplier').val();
	var create_prelims_amount = $('#create_prelims_amount').val();
	var create_prelims_receive_date = $('#create_prelims_receive_date').val();
	var create_prelims_released_date = $('#create_prelims_released_date').val();
	var errecheck = false;
	$( "#create_prelims_supplier" ).keyup(function() {
		$("#create_prelims_supplier").removeClass('redBorderThick');
	});
	$( "#create_prelims_amount" ).keyup(function() {
		if(!isNaN(create_prelims_amount)){
			$("#create_prelims_amount").removeClass('redBorderThick');
		}
	});
	$( "#create_prelims_receive_date" ).change(function() {
		$("#create_prelims_receive_date").removeClass('redBorderThick');
	});
	
	if(create_prelims_supplier == ''){
		$('#create_prelims_supplier').addClass('redBorderThick');
		errecheck = true;
	}
	if(create_prelims_amount == ''){
		$('#create_prelims_amount').addClass('redBorderThick');
		errecheck = true;
	}
	if(create_prelims_amount != '' && isNaN(create_prelims_amount) == true){
			$('#create_prelims_amount').addClass('redBorderThick');
			errecheck = true;
			messageAlert('Numeric values only allowed', 'errorMessage');
			return false;
	}
	if(create_prelims_receive_date == ''){
		$('#create_prelims_receive_date').addClass('redBorderThick');
		errecheck = true;
	}
	
	var checkUpload = $('#prelims_documents_upload_file_manager_folder_id').val();
	if(checkUpload == '' && errecheck != true){
		messageAlert('Please attach a preliminary notice document', 'errorMessage');
		return false;
	}
	if(errecheck == true){
		messageAlert('Please fill in the highlighted areas .', 'errorMessage');
		return false;
	}else{
		$(".ui-button").attr("disabled","disabled");
		var checkUpload = $('#prelims_documents_upload_file_manager_folder_id').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=savePrelims';
		
		var fileManagerFile = $('#fileManagerFile').val();
		var virtual_file_name = $('#virtual_file_name').val();
		var fileUrl = $('#fileUrl').val();
		var file_id = $('#file_id').val();
		var list_id = "record_prelim_container_";
		var gc_budget_line_item_id = $('#gc_budget_line_item_id').val();
		$("#prelims_documents_"+subcontract_id).children().each(function(i) {
					if ($(this).hasClass('placeholder')) {
						$(this).remove();
					}
				});

		var ajaxQueryString =
		'upload_document=' + encodeURIComponent(checkUpload) +
		'&create_prelims_supplier=' + encodeURIComponent(create_prelims_supplier) +
		'&create_prelims_amount=' + encodeURIComponent(create_prelims_amount)+
		'&create_prelims_receive_date=' + encodeURIComponent(create_prelims_receive_date)+
		'&create_prelims_released_date=' + encodeURIComponent(create_prelims_released_date)+
		'&document_url=' + encodeURIComponent(fileUrl);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
				$(".ui-button").removeAttr("disabled");
				$("#prelims_documents_"+subcontract_id).children().each(function(i) {
					if ($(this).hasClass('No_data_prelims_documents_'+subcontract_id)) {
						$(this).remove();
					}
				});
				
				var json = JSON.parse(res);
				$("#preliminaryTableDataTbody").children().each(function(i) {
					if ($(this).hasClass('nodatafounttr')) {
						$(this).remove();
					}
				});
				var a = '<li id="'+list_id+file_id+'"><a class="bs-tooltip  fakeHref" data-toggle="tooltip" data-placement="top" target="_blank" href="' + fileUrl + '" title="' + virtual_file_name + '">'+virtual_file_name+'</a><a class="trackDocumentClose bs-tooltip smallerFont entypo-cancel-circled" title="" href="javascript:DeletesubcontactorAdditionalDocumentWithPrelim('+subcontract_id+','+gc_budget_line_item_id+','+file_id+',&apos;'+list_id+file_id+'&apos;, 2,'+json.preliminary_id+');" data-original-title="Delete This document"></a></li>';
				$("#prelims_documents_"+subcontract_id).append(a);
				$("#preliminaryTableDataTbody").append(json.data);
				$(".bs-tooltip").tooltip();
				messageAlert('Preliminary notice successfully created', 'successMessage');
				$('#createPrelims').dialog('close');
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
			}
		});
	}
}
/*Prelims create section end here*/
// To manually send data
function ManualNotifyPop(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,costCodeLabel,company,ven_mail)
{
	var allDoc=$('#allDoc_'+subcontract_id).val();
	if(allDoc == 'Y')
	{
	var modal = document.getElementById('sendpopup');
	var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=ManualNotify';
		var ajaxQueryString =
		'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
		'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
		'&cost_code_id=' + encodeURIComponent(cost_code_id) +
		'&execution_date=' + encodeURIComponent(execution_date) +
		'&mailed_date=' + encodeURIComponent(mailed_date) +
		'&costCodeLabel=' + encodeURIComponent(costCodeLabel) +
		'&subcompany=' + encodeURIComponent(company) +
		'&ven_mail=' + encodeURIComponent(ven_mail) +
		'&subcontract_id=' + encodeURIComponent(subcontract_id) ;

		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		$.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(res){
			$('#sendpopup').empty().html(res);
		    modal.style.display = "block";
			},
			error: errorHandler,
			complete: function(jqXHR, textStatus) {
			}
		});

}else
{
	ManualNotify(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,costCodeLabel,company,ven_mail);
}
}
// To manually send data
function ManualNotify(gc_budget_line_item_id, cost_code_division_id, cost_code_id, subcontract_id, execution_date, mailed_date,costCodeLabel,company,ven_mail)
{
	modalClose();
	//notification to set the email
	if(ven_mail==undefined ||ven_mail=='')
	{
	
	$("#dialog-confirm").html("Vendor contact mail ID is not set in your contract. Kindly set the vendor contact and initiate the email.");
	 $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	height: 200,
    	width:500,
    	title: "Confirmation",
    	
    	buttons: {
	   		"close": function () {
    			$(this).dialog('close');

    		}
    	}
    });
	 return;
	}
	 //to send the email


	$("#dialog-confirm").html("You are about to send a notice of missing contract documents to '"+company+ "' - '"+ven_mail+"'. Would you like to proceed? ");
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
    	resizable: false,
    	modal: true,
    	height: 200,
    	width:500,
    	title: "Confirmation",
    	open: function() {
					
				},
				close: function() {
			
				},
    	buttons: {

    		
    		"Yes": function () {
    			$(this).dialog('close');
    			var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=MailandNotesNotify';
    			var ajaxQueryString =
    			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
    			'&cost_code_division_id=' + encodeURIComponent(cost_code_division_id) +
    			'&cost_code_id=' + encodeURIComponent(cost_code_id) +
    			'&execution_date=' + encodeURIComponent(execution_date) +
    			'&mailed_date=' + encodeURIComponent(mailed_date) +
    			'&costCodeLabel=' + encodeURIComponent(costCodeLabel) +
    			'&subcontract_id=' + encodeURIComponent(subcontract_id) ;

    			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

    			$.ajax({
    				url: ajaxHandler,
    				data: ajaxQueryString,
    				success: function(res){
    					messageAlert("Notification Sent Successfully", 'successMessage');
    				},
    				error: errorHandler,
    				complete: function(jqXHR, textStatus) {
    				}
    			});
    		},
    		"Cancel": function () {
    			$(this).dialog('close');

    		}
    	}
    });

	
}


// To upload a Insurance document in contract tracking Page
function insuranceDocuments(gc_budget_line_item_id,subcontractor_id,companyName){
		try{
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		$("#currentlySelectedGcBudgetLineItemId").val(gc_budget_line_item_id);
		//var companyName = $.trim($("#bidderCompany_" + subcontractor_bid_id).html());
		var project_id=$('#project_id').val();
		var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=InsuranceDocuments';
		var ajaxQueryString =
			'gc_budget_line_item_id=' + encodeURIComponent(gc_budget_line_item_id) +
			'&project_id='+encodeURIComponent(project_id) +
			'&companyName='+encodeURIComponent(companyName) +
			'&subcontractor_id=' + encodeURIComponent(subcontractor_id);
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
			success: function(data){
				renderinsuranceDocumentsSuccess(data,subcontractor_id,companyName);
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

//Success function for  upload a Insurance document in contract tracking Page
function renderinsuranceDocumentsSuccess(data,subcontractor_id,companyName)
{
	try {
		var dialogContainer = $("#divModalWindow").parent();
		$("#divModalWindow2").removeClass('hidden');
		$("#divModalWindow2").empty().html(data);
		$(".bs-tooltip").tooltip();
		
		var windowWidth = $(window).width();
		var windowHeight = $(window).height();

		
		var dialogWidth = windowWidth * 0.99;
		var dialogHeight = windowHeight * 0.99;
		$("#divModalWindow2").dialog({
			height: "360",
			width: "1000px",
			modal: true,
			title: "Insurance and License Documents - "+companyName,
			open: function() {
				$("body").addClass('noscroll');
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.hide();
				}
			},
			close: function() {
				$("body").removeClass('noscroll');
				if (dialogContainer.hasClass('ui-dialog')) {
					dialogContainer.show();
				}
				$("#divModalWindow2").empty();
				$("#divModalWindow2").dialog('destroy');
				trackInsuranceData(subcontractor_id);
			}
			, buttons: {
	        	'Close': function() {
	        		$(this).dialog('close');
	        	}
			} 
		});
		$(".picker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/y', numberOfMonths: 1 });
		$(".inputDateTrack").change(function(){
		expiredOrNot(this.value,this.id);
});
		$(".bs-tooltip").tooltip();
		createUploaders();


	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//To upload a Insurance Documents
function InsuranceDocumentUploaded(arrFileManagerFiles, containerElementId,subcontract_id,gc_budget_line_item_id,type)
{
	var fileManagerFile = arrFileManagerFiles[0];
	var virtual_file_name = fileManagerFile.virtual_file_name;
	var fileUrl = fileManagerFile.fileUrl;
	var file_id =fileManagerFile.file_manager_file_id;
	var list_id='';
	$('#fileManagerFile').val(fileManagerFile);
	$('#virtual_file_name').val(virtual_file_name);
	$('#fileUrl').val(fileUrl);
	$('#file_id').val(file_id);
	$('#list_id').val(list_id);

	
	var a = '<a class="bs-tooltip  fakeHref" data-toggle="tooltip" data-placement="top" data-original-title="'+virtual_file_name+'" target="_blank" href="' + fileUrl + '" title="' + virtual_file_name + '">'+virtual_file_name+'</a>';

	
	$("#" + containerElementId).empty().append(a);
	$('.bs-tooltip').tooltip();


}

//To fecth the data for the Insurance document
function trackInsuranceData(subcontractor_id)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=InstemplateDocuments&subcontractor_id='+encodeURIComponent(subcontractor_id);
		var ajaxUrl = ajaxHandler ;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: '',
			type:'JSON',
			success: function(data){
				
			var json = $.parseJSON(data);
			// alert('js'+json.file);
				
              for (var i=1; i<= 4; i++)
        {
        	// alert('arr'+json['file'][i]);
        	$("#insDocument_"+subcontractor_id+"-"+i).html(json['file'][i]);
        	$("#insDate_"+subcontractor_id+"-"+i).html(json['date'][i]);
        	if(json['file'][i]=='ADD')
        	{
        		$("#insDocument_"+subcontractor_id+"-"+i).css('color','red');
        	}else
        	{
        		$("#insDocument_"+subcontractor_id+"-"+i).css('color','');
        	}
        	expiredOrNot(json['date'][i],"insDate_"+subcontractor_id+"-"+i,'1');
        	
        }
				
			},
			
			error: errorHandler
		});
}

function printPrelimesPDF(){
	var protocol = window.location.protocol; // Returns path protocol
	// alert(protocol);
	var pathname = window.location.host; // Returns path only
	var include_path='/';
	var full_path=protocol+pathname+include_path;
	var date=new Date();
	// return;
	var linktogenerate='download-prelims-report.php';
	document.location = linktogenerate;
}

function printContractTracking(){
	var headdata =$("#trackingheader").val();
	var headcount = headdata.toString().split(','); 
	if(headcount.length >16)
	{
		$("#dialog-confirm").html("Please select only 16 or less than 16 headers for PDF");
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "Warning",
			buttons: {
				"close": function () {
					$(this).dialog('close');

				},

				}
			});
	}else
	{
	var protocol = window.location.protocol; // Returns path protocol
	// alert(protocol);
	var pathname = window.location.host; // Returns path only
	var include_path='/';
	var full_path=protocol+pathname+include_path;
	var date=new Date();
	// return;
	var linktogenerate='download-contract-tracking.php'+"?header="+encodeURIComponent(headdata);
	document.location = linktogenerate;
	}
}

function exportContractTracking(){

	var ajaxHandler = window.ajaxUrlPrefix + 'contract_tracking_ajax.php?method=exportFile';
	var ajaxUrl = ajaxHandler ;

	if (window.ajaxUrlDebugMode) {
		var continueDebug = window.confirm(ajaxUrl);
		if (continueDebug != true) {
			return;
		}
	}

	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: '',
		success: function(data){
			document.location = ajaxUrl;			
		},
		
		error: errorHandler
	});
}

//To change the prelims document name to supplier and received date
function updatePrelimDocument(subcontractor_id,fileUploadDirectoryprelims,gc_budget_line_item_id,action)
{
	var supplier =$('#create_prelims_supplier').val();
	var receive =$('#create_prelims_receive_date').val();
	var receiveArr = receive.split('/'); 
	var receive_date = receiveArr[2]+'-'+receiveArr[1]+'-'+receiveArr[0];
	var fileName = supplier+"-"+receive_date;
	var selector = document.getElementById('prelims_subcontract_document_upload_'+subcontractor_id);
	selector.setAttribute('virtual_file_name',fileName);
	if(supplier!="" && receive !="")
	{
		$('.perlim_doc_'+subcontractor_id).css('visibility',"");
		if(action =='1')//for edit prelims
		{
			
			var project_id =$('#project_id').val();
			$("#upload_prelimdoc_"+subcontractor_id).empty();
			var upload="<div id='prelims_subcontract_document_upload_"+subcontractor_id+"'    	class='boxViewUploader prelim-col ajaxcreateprelim'	folder_id=''    	project_id='"+project_id+"' virtual_file_path='"+fileUploadDirectoryprelims+"' virtual_file_name='"+fileName+"'	action='/modules-gc-budget-file-uploader-ajax.php?&gc_budget_line_item_id="+gc_budget_line_item_id+"&subcontractid="+subcontractor_id+"'	method=AdditionalSubcontractDocument sub_id="+subcontractor_id+" type_val='2' 	allowed_extensions='pdf' drop_text_prefix='' custom_label='Upload Prelim Notice' post_upload_js_callback='AdditionalDocumentUploaded(arrFileManagerFiles, &apos;prelims_documents_upload_"+subcontractor_id+"&apos;, "+subcontractor_id+", "+gc_budget_line_item_id+", 2)' style=''> </div>";
			$("#upload_prelimdoc_"+subcontractor_id).empty().append(upload);
		}

		createUploaders();
	}
	
}

(function($) {

	createUploaders();

    $(document).ready(function() {
        $("#softwareModuleHeadline").html('Export / Import Contact');
        $(".export_button").prop('disabled', true);
        $("#import_companies").on('change',function(){
        	var theCompanies = $("#import_companies").val();
			if (theCompanies == null) {
				theCompanies = '';
			}

			if(theCompanies){
				$(".export_button").prop('disabled', false);
			}else{
				$(".export_button").prop('disabled', true);
			}
		});

		$(".download_template").on('click',function(){
			var theCompanies = $("#import_companies").val();
			if (theCompanies == null) {
				theCompanies = '';
			}
			if(theCompanies){
				var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/export_import_contact_cntrl.php?action=export_contact';
				var ajaxQueryString = 'selected_companies='+encodeURIComponent(theCompanies)+
										'&type=import_template';
				var linktogenerate=ajaxHandler+'&'+ajaxQueryString;
				document.location = linktogenerate;
			}
		});

		$(".download_report").on('click',function(){
			var theCompanies = $("#import_companies").val();
			if (theCompanies == null) {
				theCompanies = '';
			}
			if(theCompanies){
				var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/export_import_contact_cntrl.php?action=export_contact';
				var ajaxQueryString = 'selected_companies='+encodeURIComponent(theCompanies)+
										'&type=export_report';
				var linktogenerate=ajaxHandler+'&'+ajaxQueryString;
				document.location = linktogenerate;
			}
		});

		$('input:radio[name="importOption"]').change(function(){
		    if ($(this).is(':checked') && $(this).val() == 'useMyTemplate') {
		    	$('.custom_template').show();
		    	$('.default_template').hide();
		    	$('#customTemplateUpload').show();
		    	$('#defaultTemplateError').hide();
		    }else{
		    	$('.custom_template').hide();
		    	$('.default_template').show();
		    	$('#customTemplateUpload').hide();
		    	$('#defaultTemplateError').show();
		    }
		});
		$("#importSubmit").click(processImportDefault);
    });
    var file_input = $("#excelupload")[0];

	file_input.onclick = function () {
	    this.value = null;
	};

	file_input.onchange = function () {
	    uploadexcel(this.id,this.value)
	};
})(jQuery);


function uploadexcel(id,value)
{
	var ext = value.split(".");
    ext = ext[ext.length-1].toLowerCase(); 
	var arrayExtensions = ["xlsx" , "xlsm", "xltx", "xltx", "xltm","csv"];
	if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert("Wrong extension type.");
        $("#"+id).val("");
        return false;
    }
    var ajaxUrl = window.ajaxUrlPrefix + 'contact-manager-excel-upload.php';
    var file_data = $('#'+id).prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('method', "fetchdata");
    $.ajax({
		method:'POST',
		url:ajaxUrl,
		data:form_data,
		cache: false,
        contentType: false,
        processData: false,
		success:function(data)
		{
			if(data == "error")
			{
			messageAlert('Please Upload the Excel as per the Instruction','errorMessage');
			}else{
			$('#customTemplateUpload').empty().append(data);
			}
		}
	});
}

function checkandproceed(){
	var ajaxUrl = window.ajaxUrlPrefix + 'contact-manager-excel-upload.php';
	//To get the match values
	
	var companycount = $('#companycount').val();
	var officecount = $('#officecount').val();
	var contactcount = $('#contactcount').val();


	var err='0';
	var k='1';
	//To count company
	var companyArr = {};
	var companycheck = Array();

	for (var i = 0; i <= companycount; i++){
		var colname=$('#colname_0_'+i).val();
	 	companyArr[i] =$('#colname_0_'+i).val();
	 	companycheck.push($('#colname_0_'+i).val());
	}
	var err1=jQuery.inArray ("company", companycheck );
	if(err1== "-1")
	{
	 	messageAlert('Please select company section for company','errorMessage');
	 	return false;
	}
	var company = JSON.stringify(companyArr);
	//To count office
	var officeArr = {};
	var officecheck = Array();
	for (var i = 0; i <= officecount; i++){
	 	var colname=$('#colname_1_'+i).val();
	 	officeArr[i] =$('#colname_1_'+i).val();
	 	officecheck.push($('#colname_1_'+i).val());
	}
	var err2=jQuery.inArray ("company", officecheck );
	if(err2 == "-1")
	{
	 	messageAlert('Please select company section for office','errorMessage');
		return false;
	}
	var office = JSON.stringify(officeArr);
	//To count contact
	var contactArr = {};
	var contactcheck = Array();
	for (var i = 0; i <= contactcount; i++){
	 	var colname=$('#colname_2_'+i).val();
	 	contactArr[i] =$('#colname_2_'+i).val();
	 	contactcheck.push($('#colname_2_'+i).val());
	}
	var err3 = jQuery.inArray("company", contactcheck );
	var err4 = jQuery.inArray("email", contactcheck );
	if(err3 == "-1" || err4 == "-1")
	{
	 	messageAlert('Please select company or email sections for contacts','errorMessage');
	 	return false;
	}
	var contact = JSON.stringify(contactArr);
	var file_data = $('#excelupload').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('method', "checkinsertdata");
    form_data.append('company', company);
    form_data.append('office', office);
    form_data.append('contact', contact);

    $.ajax({
		method:'POST',
		url:ajaxUrl,
		data:form_data,
		cache: false,
        contentType: false,
        processData: false,
		success:function(html)
		{
			var JsonData = $.parseJSON(html);
			var data = JsonData.data;
			data = $.trim(data);
			var invalid = JsonData.invalid;
			$("#customTemplateErrorValid").val(invalid);
			$('#customTemplateUpload').html(data);
		}
	});
}

function proceed()
{
	var ajaxUrl = window.ajaxUrlPrefix + 'contact-manager-excel-upload.php';

	var company = $('#company_json').val();
	var office = $('#office_json').val();
	var contact = $('#contact_json').val();
	var file_data = $('#excelupload').prop('files')[0];   

    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('method', "insertdata");
    form_data.append('company', company);
    form_data.append('office', office);
    form_data.append('contact', contact);

	$.ajax({
		method:'POST',
		url:ajaxUrl,
		data:form_data,
		cache: false,
        contentType: false,
        processData: false,
		success:function(data)
		{
			if(data == ''){
				messageAlert('Successfully Imported','successMessage');
				window.location.reload();
			}else{
				messageAlert('You have errors in Excel or may skip mandatory Fields.. ','errorMessage');
			}
		}
	});
}

function showHideHelp(helpid){
	var modal = document.getElementById('Instructions');
	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/export_import_contact_cntrl.php';
	$.get(ajaxHandler,{'action':'hintContent','type':helpid},function(data){
		$('#Instructions').empty().html(data);
		modal.style.display = "block";
		$("body").addClass('noscroll');
	});
}
// When the user clicks on <span> (x), close the modal
function instructionmodalClose() {
	var modal = document.getElementById('Instructions');
	modal.style.display = "none";
	$("body").removeClass('noscroll');
}
// When the user clicks anywhere outside of the modal, close it
var modal = document.getElementById('Instructions');
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

/*
After submit validate the data's and insert the data's into database
if any issue it's through error msg
*/

var processImportDefault = function(){
	var defaultTemplate = $("#defaultTemplate").val();
	var invalid = $("#defaultTemplateErrorValid").val();
	if(invalid!=0){
		messageAlert('Please upload excel, valid data with mandatory field','errorMessage');
		return false;
	}
	if(defaultTemplate == '' || defaultTemplate == null)
	{
		messageAlert('Please select excel(.xlsx) file','errorMessage');
		return false;
	}
	var ajaxQueryString = "action=confirmDefaultTemplate&filePath="+defaultTemplate;
	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/export_import_contact_cntrl.php';

	var returnedJqXHR = $.ajax({
		url: ajaxHandler,
		data: ajaxQueryString,
		async:true,
		success: function(html){
			console.log(html);
			$('#defaultTemplateError').empty();
			$("#defaultTemplate").val('');
			$("#record_list_container--manage-file-import-record").empty();	
			messageAlert('Imported Successfully','successMessage');
		},
		error: errorHandler
	});
}
/*append upload file name*/
var fileRefresh = function(arrFileManagerFiles){
	$("#defaultTemplateErrorValid").val('');
	var filePath = arrFileManagerFiles['virtualFilePath'];
	var filename = arrFileManagerFiles['virutalFileName'];
	var liData = arrFileManagerFiles['liData'];
	var ExistfilePath = $("#defaultTemplate").val();
	if(ExistfilePath!=''){
		deleteFile();
	}
	$("#defaultTemplate").val(filePath);
	// $("input[name=file]").attr('disabled','disabled');
	$("#record_list_container--manage-file-import-record").empty().append(liData);
	var defaultTemplate = $("#defaultTemplate").val();
	var Reportoption=$("input[name='importOption']:checked").val();
	if(defaultTemplate == '' || defaultTemplate == null)
	{
		messageAlert('Please select excel(.xlsx) file','errorMessage');
		return false;
	}
 	var filePath = $("#defaultTemplate").val();
 	var ajaxQueryString = "action=checkDataAnyExist&filePath="+defaultTemplate;
 	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/export_import_contact_cntrl.php';
	var returnedJqXHR = $.ajax({
							url: ajaxHandler,
							data: ajaxQueryString,
							success: function(html){
								var JsonData = $.parseJSON(html);
								var data = JsonData.data;
								data = $.trim(data);
								var invalid = JsonData.invalid;
								$("#defaultTemplateErrorValid").val(invalid);
								$('#defaultTemplateError').html(data);
							},
							async:true,
							error: errorHandler
						});
}

/*Delete temp file*/
var deleteFile = function(){
	$("#record_list_container--manage-file-import-record").empty();	
	var filePath = $("#defaultTemplate").val();
	var ajaxQueryString = "method=deleteFile&filePath="+filePath+"&deleteFlag=Y";
	var ajaxHandler = "/modules-import-admin-contact-uploader-ajax.php";
	var returnedJqXHR = $.ajax({
							url: ajaxHandler,
							data: ajaxQueryString,
							success: function(html){
								$("#defaultTemplate").val('');
								$('#defaultTemplateError').empty();
								$("#defaultTemplateErrorValid").val('');
							},
							async:true,
							error: errorHandler
						});
}
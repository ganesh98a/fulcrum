var userCanManageContacts = 0;
var setFocusToElement = '';
var arrCompanies = [];
var contactCompanyTimer;
var userCanExportContacts;
var userCanImportContacts

(function($) {
	$(document).ready(function() {
		var pathname = window.location.pathname;
		if(pathname == '/modules-contacts-manager-form.php'){
			$("#softwareModuleHeadline").html('Contacts Manager');
			$("#softwareModuleHeadline").css('display','block');
		}
		
		createUploaders();
		activateHelpHints();
		initializeAutoHintFields();

		//$('#help-hint-help-company-name').accordion();
		//$('#help-hint-help-company-name').accordion().dialog();

		$("#company").keypress(function() {
			//alert("Handler for .keypress() called.");
			//window.supressAjaxLoadingMessage = true;

			killAllActiveAJAXRequests();
		});

		userCanManageContacts = $("#userCanManageContacts").val();
		userCanExportContacts = $("#userCanExportContacts").val();
		userCanImportContacts = $("#userCanImportContacts").val();
		// Load the autocomplete input box for the company
		//TODO Production: Change Min length back to 2

		initializeContactCompanyAutocompleteWidget();

		//initializeContactCompanyTradesAutocompleteWidget();

		/*
		$("#companyNameModal").autocomplete({
			source: arrCompanies
			select: function(event, ui) {
				var companyName = ui.item.label;
				$('#company').val(companyName);
				for (var i = 0; i < arrCompanies.length; i++) {
					var company = arrCompanies[i];
					if (company.name == companyName) {
						var companyId = company.id;
						$("#contact_company_id").val(companyId);
						break;
					}
				}
			}
		});


		$('#company').autocomplete({
			autoFocus: false,
			delay: 500,
			focus: listItemFocus,
			minLength: 1,
			select: companySelected,
			source: '/modules-contacts-manager-ajax.php?method=searchForCompanyReturnSuggestions'
		});

		.data( "autocomplete" )._response = function( content ) {
			if (content.length == 0) {
				if (userCanManageContacts == 1) {
					$('#btnManageCompany').val("Create New Company");
				}
			} else {
				var currentSearch = $('#company').val().toLowerCase();
				var myCompanyName = $('#myCompanyName').val().toLowerCase();
				var matches = false;
				var buttonLabel = '';
				$.each(content, function(key, value) {
					var itemId = content[key]['value'];
					var itemLabel = content[key]['label'];
					if (itemLabel.toLowerCase() == currentSearch || currentSearch == myCompanyName) {
						matches = true;
						buttonLabel = itemLabel;
						$('#contact_company_id').val(itemId);
						$('#company').val(itemLabel);
						return false;
					 }
				});

				if (userCanManageContacts == 1) {
					if (matches) {
						$('#btnManageCompany').val('Manage ' + buttonLabel);
					} else {
						$('#btnManageCompany').val('Create New Company');
						$('#contact_company_id').val(0);
					}
				} else {
					if (matches) {
						$('#btnManageCompany').val('View ' + buttonLabel);
					}
				}
			}

			if ( !this.options.disabled && content && content.length ) {
				content = this._normalize( content );
				this._suggest( content );
				this._trigger( "open" );
			} else {
				this.close();
			}
			this.pending--;
			if ( !this.pending ) {
				this.element.removeClass( "ui-autocomplete-loading" );
			}
		};
		*/

		// Set the focus on the company input box so the user can begin typing
		$("#company").focus();

		$("#company").keypress(function(event) {
			if (event.keyCode == 13) {
				$(".ui-autocomplete").hide();
				 //checkSelection();
				 return false;
				}
			});

		// Setup the Next button to handle the Company search
		$("#btnManageCompany").click(checkSelection);

		// $("#btnExportContact").css('display','black');

		$("#btnExportContact").click(contactExportData);
		$("#UseMyTemplateSH").hide();
		$("#btnCompanySearch").click(function() {
			$("#company").autocomplete('search');

		});
		$("#importSubmit").click(processImportDefault);
		// Load contact list
		/*
		getCompaniesListByCompany('divCompaniesList');
		$('#divCompaniesList').load
		*/

	});
})(jQuery);
/*Import Contact*/
var contactImportData = function ()
{
	var Reportoption=$("input[name='importOption']:checked").val().trim();
	if(Reportoption == "useDefaultTemplate"){
		// $("#UseMyTemplateSH").css('display','none');
		// $("#UseDefaultTemplateSH").css('display','black');
		$("#UseDefaultTemplateSH").show();
		$("#UseMyTemplateSH").hide();
	}
	if(Reportoption == "useMyTemplate")
	{
		// $("#UseMyTemplateSH").css('display','black');
		// $("#UseDefaultTemplateSH").css('display','none');
		$("#UseMyTemplateSH").show();
		$("#UseDefaultTemplateSH").hide();
	}
}
/*Import Contact div show and hide*/
var contactImportDiv = function ()
{
	$(".importContacts").show();
	 $('html, body').animate({
        scrollTop: $(".importContacts").offset().top
    }, 1000);
	$("#btnImportContact").val("Import Contacts - Close");
	$("#btnImportContact").removeAttr("onclick");
	$("#btnImportContact").attr("onclick","contactImportDivClose()");
}
var contactImportDivClose = function ()
{
	$(".importContacts").hide();
	$("#btnImportContact").val("Import Contacts");
	$("#btnImportContact").removeAttr("onclick");
	$("#btnImportContact").attr("onclick","contactImportDiv()");
}
/*Export Contact*/
var contactExportData = function ()
{
	try {
		if (userCanExportContacts == 1) {

		} else {
			messageAlert('Permission Denied', 'errorMessage');
		}
		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		var contact_company_name = $("#company").val();
		contact_company_name = $.trim(contact_company_name);

		if (contact_company_name.length > 0) {
			if (contact_company_id == '') {
				contact_company_id = -1;
			}

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-export.php?method=checkIfCompanyExists';
			var ajaxQueryString =
			'contact_company_id=' + encodeURIComponent(contact_company_id) +
			'&contact_company_name=' + encodeURIComponent(contact_company_name);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			// $("#btnManageCompany").prop('disabled', true);
			// $("#refreshCompanyDataId").prop('disabled', true);
			// $.ajaxq.clear('contact_companies');
			var pathname = window.location.host; // Returns path only
			var http="https://";
			var include_path='/';
			var full_path=http+pathname+include_path;
			var date=new Date();
			var linktogenerate=ajaxHandler+'&'+ajaxQueryString;
			document.location = linktogenerate;

			/*$.ajaxq('contact_companies', {
				url: ajaxHandler,
				data: ajaxQueryString,
				success: contactExportSuccess,
				error: errorHandler
			});*/
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
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
	if(Reportoption == 'useDefaultTemplate'){
		var filePath = $("#defaultTemplate").val();
		var ajaxQueryString = "method=checkDataAnyExist&filePath="+defaultTemplate;
		var ajaxHandler = "modules-import-admin-contact-uploader-ajax.php";
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(html){
				// html = JSON.stringify(html);
				var JsonData = $.parseJSON(html);
				var data = JsonData.data;
				var invalid = JsonData.invalid;
				$("#defaultTemplateErrorValid").val(invalid);
				$('#defaultTemplateError').empty().html(data);
			},
			async:true,
			error: errorHandler
		});
	}	
}
/*Delete temp file*/
var deleteFile = function(){
	// $("input[name=file]").removeAttr('disabled');
	$("#record_list_container--manage-file-import-record").empty();	
	var filePath = $("#defaultTemplate").val();
	var ajaxQueryString = "method=deleteFile&filePath="+filePath+"&deleteFlag=Y";
	var ajaxHandler = "modules-import-admin-contact-uploader-ajax.php";
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
/*Download excel file for reference import default template*/
var downlaodRef = function(){
	// var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-export-sample.php';
	// var ajaxUrl = ajaxHandler;
	var defaultTemplatePath = $("#defaultTemplatePath").val();
	var pathname = window.location.host; 
	var http="https://";
	var include_path='/';
	var full_path = http+pathname+include_path;
	var date = new Date();
	var linktogenerate = defaultTemplatePath;
	document.location = linktogenerate;
}
/*
After submit validate the data's and insert the data's into database
if any issue it's through error msg
*/
var processImportDefault = function(){
	var defaultTemplate = $("#defaultTemplate").val();
	var Reportoption=$("input[name='importOption']:checked").val();
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
	if(Reportoption == 'useDefaultTemplate'){
		var filePath = $("#defaultTemplate").val();
		var ajaxQueryString = "method=confirmDefaultTemplate&filePath="+defaultTemplate;
		var ajaxHandler = "modules-import-admin-contact-uploader-ajax.php";
		var returnedJqXHR = $.ajax({
			url: ajaxHandler,
			data: ajaxQueryString,
			async:true,
			success: function(html){
				// $('#defaultTemplateError').empty().html(html);
				$('#defaultTemplateError').empty();
				$("#defaultTemplate").val('');
				$("#record_list_container--manage-file-import-record").empty();	
				messageAlert('Imported Successfully','successMessage');
				// window.location.reload();
			},
			error: errorHandler
		});
	}

}
function uploadexcel(id,value)
{
	 var ext = value.split(".");
    ext = ext[ext.length-1].toLowerCase(); 

    var arrayExtensions = ["xlsx" , "xlsm", "xltx", "xltx", "xltm","csv"];

    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert("Wrong extension type.");
        $("#"+id).val("");
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
			messageAlert('Please Upload the Excel  as per the Instruction','errorMessage');
			}else{
			$('#excelval').empty().append(data);}
			
		}

	});
}
function proceed()
{
	 var ajaxUrl = window.ajaxUrlPrefix + 'contact-manager-excel-upload.php';
	 var contCompanyValue=$('#ddlContactCompanies').val();
	 //To get the match values
	
	 var companycount=$('#companycount').val();
	 var officecount=$('#officecount').val();
	 var contactcount=$('#contactcount').val();
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
	 var err3=jQuery.inArray ("company", contactcheck );
	  var err4=jQuery.inArray ("email", contactcheck );
	 if(err3== "-1" || err4== "-1")
	 {
	 	messageAlert('Please select company or email sections for contacts','errorMessage');
	 	return false;
	}
	var contact = JSON.stringify(contactArr);
	var file_data = $('#excelupload').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('method', "insertdata");
    form_data.append('contactcompany', contCompanyValue);
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
			if(data == '')
			{
				messageAlert('Successfully Imported','successMessage');
			window.location.reload();
		}
			else
			{
				messageAlert('You have errors in Excel or may skip mandatory Fields.. ','errorMessage');
			}
		}
	});
	
}


function initializeContactCompanyAutocompleteWidget()
{
	var ddlContactCompanies = $("#ddlContactCompanies");
	var ddlContactCompaniesElement = ddlContactCompanies[0];
	arrCompanies = getArrCompaniesFromDropdown(ddlContactCompaniesElement);

	$("#company").autocomplete({
		source: arrCompanies,
		select: companySelected
	});
}

function companySelected(event, ui)
{
	$("#btnExportContact").prop('disabled', false);
	var companyName = ui.item.label;
	$("#company").val(companyName);
	for (var i = 0; i < arrCompanies.length; i++) {
		var company = arrCompanies[i];
		if (company.name == companyName) {
			var companyId = company.id;
			$("#contact_company_id").val(companyId);
			checkSelection();
			break;
		}
	}
	if (userCanManageContacts == 1) {
		$("#btnManageCompany").val('Manage ' + ui.item.label);
	} else {
		$("#btnManageCompany").val('View ' + ui.item.label);
	}
}

function listItemFocus(event, ui)
{
	$("#contact_company_id").val(ui.item.value);
	$("#company").val(ui.item.label);
	return false;
}

function companySelected_old(event, ui)
{
	var companyName = ui.item.label;
	$("#company").val(companyName);

	for (var i = 0; i < arrCompanies.length; i++) {
		var company = arrCompanies[i];
		if (company.name == companyName) {
			var companyId = company.id;
			$("#contact_company_id").val(companyId);
			break;
		}
	}

	if (userCanManageContacts == 1) {
		$("#btnManageCompany").val('Manage ' + ui.item.label);
	} else {
		$("#btnManageCompany").val('View ' + ui.item.label);
	}
	return false;
}

function ddlContactCompanyChanged()
{
	$("#complist").css('display','block');
	$("#contact_list").hide();
	$("#non_contact_list").hide();
	clearTimeout(contactCompanyTimer);
	contactCompanyTimer = setTimeout(contactCompanyChanged, 500);
	$("#btnExportContact").prop('disabled', false);

}

function contactCompanyChanged()
{
	var selectedContactCompanyId = $("#ddlContactCompanies").val();
	if (selectedContactCompanyId != 0) {
		$("#contact_company_id").val(selectedContactCompanyId);
		var selectedCompanyName = $("#ddlContactCompanies option:selected").text();
		$("#company").val(selectedCompanyName);
		checkSelection();
	}
	$("#refreshCompanyDataId").show();
}

function contactEmailChanged()
{
	var selectedContactCompanyId = $("#ddlEmail").val();

	if (selectedContactCompanyId != 0) {
		$("#contact_company_id").val(selectedContactCompanyId);
		var selectedCompanyName = $("#ddlEmail").find(':selected').attr('name');
		$("#company").val(selectedCompanyName);
		checkSelection();
	}
	$("#refreshCompanyDataId").show();
}

// This function checks to see if the company in the input box exists currently
function resetUserPassword(user_id, email)
{
	try {

		user_id = $.trim(user_id);
		email = $.trim(email);

		var ajaxHandler = window.ajaxUrlPrefix + 'admin-user-password-reset.php?ajax=1';
		var ajaxQueryString =
		'user_id=' + encodeURIComponent(user_id) +
		'&email=' + encodeURIComponent(email);
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
			success: resetUserPasswordSuccess,
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

// Handles the result of the Check Selection ajax function
function resetUserPasswordSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var customSuccessMessage = json.customSuccessMessage;
		messageAlert(customSuccessMessage, 'successMessage');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

// This function checks to see if the company in the input box exists in the DB.
function checkSelection()
{
	try {

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		var contact_company_name = $("#company").val();
		contact_company_name = $.trim(contact_company_name);

		if (contact_company_name.length > 0) {
			if (contact_company_id == '') {
				contact_company_id = -1;
			}

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=checkIfCompanyExists';
			var ajaxQueryString =
			'contact_company_id=' + encodeURIComponent(contact_company_id) +
			'&contact_company_name=' + encodeURIComponent(contact_company_name);
			var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

			if (window.ajaxUrlDebugMode) {
				var continueDebug = window.confirm(ajaxUrl);
				if (continueDebug != true) {
					return;
				}
			}

			$("#btnManageCompany").prop('disabled', true);
			$("#refreshCompanyDataId").prop('disabled', true);
			$.ajaxq.clear('contact_companies');
			$.ajaxq('contact_companies', {
				url: ajaxHandler,
				data: ajaxQueryString,
				success: checkSelectionSuccess,
				error: errorHandler
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

// Handles the result of the Check Selection ajax function
function checkSelectionSuccess(data, textStatus, jqXHR)
{
	try {

		var contact_company_id = data;

		//window.supressAjaxLoadingMessage = false;
		// Set the hidden contact_company_id to what the DB found
		$("#contact_company_id").val(contact_company_id);
		// Hide the different page components
		$("#refreshCompanyDataId").show();
		//$("#officeInformation").hide();
		$("#divOfficesList").hide();
		$("#divOfficeDetails").hide();
		$("#divEmployees").hide();
		$("#divCompanyInfo").hide();
		$("#divContactInformation").hide();
		$("#divContactPermissions").hide();

		if (contact_company_id != 0) {
			$("#ddlContactCompanies").val(contact_company_id);
			var companyName = $("#company").val();
			getCompanyInfoByCompany('divCompanyInfo', contact_company_id, companyName);
			getOfficesByCompany('divOfficesList', contact_company_id);
			getEmployeesByCompany('divEmployees', contact_company_id, companyName);
			getArchivedEmployeesByCompany('divArchivedEmployees', contact_company_id, companyName);
			//$('#officeInformation').show();
		} else {
			var companyName = $("#company").val();
			getCompanyInfoByCompany('divCompanyInfo', contact_company_id, companyName);
			$("#btnManageCompany").prop('disabled', false);
			$("#refreshCompanyDataId").prop('disabled', false);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

/*
function getCompaniesListByCompany(elementId)
{
	$("#" + elementId).load('modules-contacts-manager-ajax.php?method=getCompaniesListByUserCompany');
	$("#" + elementId).show();
}
*/

function getCompanyInfoByCompany(elementId, contact_company_id, contact_company_name)
{
	try {

		contact_company_id = $.trim(contact_company_id);
		contact_company_name = $.trim(contact_company_name);

//		if (contact_company_name.length > 0) {
	if (contact_company_id == '') {
		contact_company_id = -1;
	}

	var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadContactCompany';
	var ajaxQueryString =
	'contact_company_id=' + encodeURIComponent(contact_company_id) +
	'&contact_company_name=' + encodeURIComponent(contact_company_name);
	var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

	if (window.ajaxUrlDebugMode) {
		var continueDebug = window.confirm(ajaxUrl);
		if (continueDebug != true) {
			return;
		}
	}

			//$("#" + elementId).load(ajaxUrl, ajaxModulesLoaded);
			//$("#" + elementId).show();

			//$.ajaxq.clear('contact_companies');
			$.ajaxq('contact_companies', {
				url: ajaxHandler,
				data: ajaxQueryString,
				success: ajaxModulesLoaded,
				error: errorHandler
			}).done(function(html) {
				$("#" + elementId).html(html);
				$("#" + elementId).show();
			});
//		}

} catch(error) {

	if (window.showJSExceptions) {
		var errorMessage = error.message;
		alert('Exception Thrown: ' + errorMessage);
		return;
	}

}
}

function getOfficesByCompany(elementId, contact_company_id)
{
	try {

		contact_company_id = $.trim(contact_company_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=getOfficesByCompany';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		//$("#" + elementId).load(ajaxUrl, ajaxModulesLoaded);
		//$("#" + elementId).show();

		//$.ajaxq.clear('contact_companies');
		$.ajaxq('contact_companies', {
			url: ajaxHandler,
			data: ajaxQueryString,
			success: ajaxModulesLoaded,
			error: errorHandler
		}).done(function(html) {
			$("#" + elementId).html(html);
			$("#" + elementId).show();
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadContactCompanyOfficeDetails(elementId, contact_company_office_id)
{
	try {

		contact_company_office_id = $.trim(contact_company_office_id);

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadContactCompanyOfficeDetails';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&contact_company_office_id=' + encodeURIComponent(contact_company_office_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		//$("#" + elementId).load(ajaxUrl, ajaxModulesLoaded);
		//$("#" + elementId).show();

		//$.ajaxq.clear('contact_companies');
		$.ajaxq('contact_companies', {
			url: ajaxHandler,
			data: ajaxQueryString,
			success: function(data, textStatus, jqXHR) {
				$("#" + elementId).html(data);
				$("#" + elementId).show();
				if (contact_company_office_id == 0) {
					$("#btnNewOffice").hide();
				} else {
					$("#btnNewOffice").show();
				}
				ajaxModulesLoaded(data, textStatus, jqXHR);
			},
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

function getEmployeesByCompany(elementId, contact_company_id, contact_company_name)
{
	try {

		contact_company_id = $.trim(contact_company_id);
		contact_company_name = $.trim(contact_company_name);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=getEmployeesByCompany';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&companyName=' + encodeURIComponent(contact_company_name);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		//$("#" + elementId).load(ajaxUrl, ajaxModulesLoaded);
		//$("#" + elementId).show();

		//$.ajaxq.clear('contact_companies');
		$.ajaxq('contact_companies', {
			url: ajaxHandler,
			data: ajaxQueryString,
			success: ajaxModulesLoaded,
			error: errorHandler
		}).done(function(html) {
			$("#" + elementId).html(html);
			$("#" + elementId).show();
			$("#btnManageCompany").prop('disabled', false);
			$("#refreshCompanyDataId").prop('disabled', false);
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function getArchivedEmployeesByCompany(elementId, contact_company_id, contact_company_name)
{
	try {

		contact_company_id = $.trim(contact_company_id);
		contact_company_name = $.trim(contact_company_name);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=getArchivedEmployeesByCompany';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&companyName=' + encodeURIComponent(contact_company_name);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		//$("#" + elementId).load(ajaxUrl, ajaxModulesLoaded);
		//$("#" + elementId).show();

		//$.ajaxq.clear('contact_companies');
		$.ajaxq('contact_companies', {
			url: ajaxHandler,
			data: ajaxQueryString,
			success: ajaxModulesLoaded,
			error: errorHandler
		}).done(function(html) {
			$("#" + elementId).html(html);
			$("#" + elementId).show();
			$("#btnManageCompany").prop('disabled', false);
			$("#refreshCompanyDataId").prop('disabled', false);
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function saveCompany(attributeGroupName, uniqueId)
{
	try {

		var valid = validateForm(attributeGroupName, uniqueId);
		if (!valid) {
			var promise = getDummyRejectedPromise();
			return promise;
		}

		// Debug
		var contact_company_id = 0;

		//var contact_company_id = $('#contact_company_id').val();
		contact_company_id = $.trim(contact_company_id);
		window.savePending = true;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=saveCompany';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&' + $("#frmCompanyInfoModal").serialize();
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
			success: saveCompanySuccess,
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

function saveCompanySuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var json = data;

		var contact_company_id = json.contact_company_id;
		var customSuccessMessage = json.customSuccessMessage;
		var displayCustomSuccessMessage = json.displayCustomSuccessMessage;
		var performRefreshOperation = json.performRefreshOperation;

		if (displayCustomSuccessMessage && (displayCustomSuccessMessage == 'Y')) {
			messageAlert(customSuccessMessage, 'successMessage');
		}

		$("#contact_company_id").val(contact_company_id);

		if (performRefreshOperation == 'Y') {
			window.location.reload(true);
		} else {
			// Add company to dropdown.
			var ddl = document.getElementById('ddlContactCompanies');
			var option = document.createElement('option');
			var companyName = $("#companyNameModal").val();
			option.setAttribute('value', contact_company_id)
			option.text = companyName;
			ddl.add(option);
			$("#company").val(companyName);
			checkSelection();
		}

		$("#divCompanyInfoModal").dialog('close');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__updateAllContactCompanyAttributes(attributeGroupName, uniqueId, options)
{
	// Debug
	//return;

	try {

		ajaxQueryString = '';
		var primary_phone_number_element_id = attributeGroupName + '--contact_companies--primary_phone_number--' + uniqueId;
		if ($("#" + primary_phone_number_element_id).length) {
			var primary_phone_number = $("#" + primary_phone_number_element_id).val();
			primary_phone_number = parseInputToDigits(primary_phone_number);
			ajaxQueryString = ajaxQueryString + '&primary_phone_number=' + encodeURIComponent(primary_phone_number);
		}

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.adHocQueryParameters = ajaxQueryString;

		updateAllContactCompanyAttributes(attributeGroupName, uniqueId, options);


	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showOfficeDetails(contact_company_office_id)
{
	try {

		contact_company_office_id = $.trim(contact_company_office_id);
		loadContactCompanyOfficeDetails('divOfficeDetails', contact_company_office_id);
//		$('#divOfficesList').hide();

} catch(error) {

	if (window.showJSExceptions) {
		var errorMessage = error.message;
		alert('Exception Thrown: ' + errorMessage);
		return;
	}

}
}

function cancelOfficeDetails(contact_company_id)
{
	if (contact_company_id == '') {
		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);
	}

	$("#divOfficeDetails").hide();
	$("#btnNewOffice").show();
	getOfficesByCompany('divOfficesList', contact_company_id);
	//$('#divOfficesList').show();
}

function saveOfficeDetails(contact_company_office_id)
{
	try {

		window.savePending = true;

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);
		contact_company_office_id = $.trim(contact_company_office_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=saveOffice';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&contact_company_office_id=' + encodeURIComponent(contact_company_office_id) +
		'&' + $('#frmOfficeDetails--'+contact_company_office_id).serialize();
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
			success: saveOfficeSuccess,
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

function saveOfficeSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var json = data;

		var customSuccessMessage = json.customSuccessMessage;
		messageAlert(customSuccessMessage, 'successMessage');

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		$("#divOfficeDetails").hide();
		$("#btnNewOffice").show();
		getOfficesByCompany('divOfficesList', contact_company_id);
		updateDropDownOfficeList(contact_company_id);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateDropDownOfficeList(contact_company_id)
{
	try {

		contact_company_id = $.trim(contact_company_id);

		var contact_id = 0;
		var selectedContactId = $("#selectedContactId").val();
		selectedContactId = $.trim(selectedContactId);
		if (selectedContactId) {
			contact_id = selectedContactId;
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=updateOfficeDDL';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&contact_id=' + encodeURIComponent(contact_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#ddlOfficesDiv").load(ajaxUrl);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showContactInfo(contact_id, user_id)
{
	try {

		killAllActiveAJAXRequests();

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		contact_id = $.trim(contact_id);
		user_id = $.trim(user_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadContactInfo';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&contact_id=' + encodeURIComponent(contact_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divContactInformation").load(ajaxUrl, ajaxModulesLoaded);
		$("#divContactInformation").show();
		if (contact_id != '0') {
			loadContactPermissions(contact_company_id, contact_id);
		} else {
			$("#divContactPermissions").hide();
			setFocusToElement = 'first_name';
		}
		//$('#contact_id').val(contact_id);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showArchivedContactInfo(contact_id, user_id)
{
	try {

		killAllActiveAJAXRequests();

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		contact_id = $.trim(contact_id);
		user_id = $.trim(user_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadArchivedContactInfo';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&contact_id=' + encodeURIComponent(contact_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divArchivedContactInformation").load(ajaxUrl, ajaxModulesLoaded);
		$("#divArchivedContactInformation").show();
		if (contact_id != '0') {
			loadArchivedContactPermissions(contact_company_id, contact_id);
		} 
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadToReArchiveContactDialog(id) {
    
	$("#dialog-confirm").html("Are you sure you want to unarchive the contact?");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation",
        buttons: {
            "Cancel": function () {
                $(this).dialog('close');              
            },
            "Ok": function () {
                $(this).dialog('close');
                callbackToReArchive(true,id);
            }
        }
    });
	
}

function callbackToReArchive(value,id) {
    if (value) {
    	var ajaxUrl = window.ajaxUrlPrefix + 'modules-archive-contact.php'; 		
		$.ajax({
			url: ajaxUrl,
			method:'POST',
			data : {id:id, is_archive:'false'},
			success: reArchiveContactCallback
		});
	} 
}

function reArchiveContactCallback(data){
	if (data == 1) { 
		messageAlert('Contact Re-Archived successfully', 'successMessage');	
		setTimeout(function(){
			var contact_company_id = $("#contact_company_id").val();
			var companyName = $("#companyName").val();
			getArchivedEmployeesByCompany('divArchivedEmployees', contact_company_id, companyName);
			$("#divArchivedContactInformation").hide();
			$("#divArchivedContactPermissions").hide();
		},1000);
	}
};

function loadContactPermissions(contact_company_id, contact_id)
{
	try {

		contact_company_id = $.trim(contact_company_id);
		contact_id = $.trim(contact_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadContactPermissions';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&contact_id=' + encodeURIComponent(contact_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divContactPermissions").load(ajaxUrl, ajaxModulesLoaded);
		$("#divContactPermissions").show();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadArchivedContactPermissions(contact_company_id, contact_id)
{
	try {

		contact_company_id = $.trim(contact_company_id);
		contact_id = $.trim(contact_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadArchivedContactPermissions';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&contact_id=' + encodeURIComponent(contact_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divArchivedContactPermissions").load(ajaxUrl, ajaxModulesLoaded);
		$("#divArchivedContactPermissions").show();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function cancelNewContact()
{
	$("#divContactInformation").hide();
}

function ddlOfficesChanged(elementId, contact_id)
{
	var selectedValue = $("#" + elementId).val();
	if (contact_id > 0) {
		if (selectedValue > 0) {
			saveContactOfficeChange(contact_id, selectedValue);
		} else {
			showOfficeDetails(0);
		}
	}
}

function saveContactOfficeChange(contact_id, contact_company_office_id)
{
	try {

		window.savePending = true;

		contact_id = $.trim(contact_id);
		contact_company_office_id = $.trim(contact_company_office_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=saveContactOffice';
		var ajaxQueryString =
		'contact_id=' + encodeURIComponent(contact_id) +
		'&contact_company_office_id=' + encodeURIComponent(contact_company_office_id);
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
			success: saveContactOfficeChangeSuccess,
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

function saveContactOfficeChangeSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;
		// messageAlert(data, 'successMessage', 'successMessageLabel', 'ddlOffices');
		messageAlert(data, 'successMessage');

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function deleteOffice(elementId, contact_company_office_id)
{
	try {

		// Ask the user to confirm
		var userMessage = 'Warning: This will delete this office (address) and any phone numbers for this office. Click OK to continue with deletion of the office and its phone numbers.';
		var continueWithDelete = window.confirm(userMessage);
		if (continueWithDelete != true) {
			return;
		}

		window.savePending = true;

		contact_company_office_id = $.trim(contact_company_office_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=deleteOffice';
		var ajaxQueryString =
		'contact_company_office_id=' + encodeURIComponent(contact_company_office_id) +
		'&elementId=' + encodeURIComponent(elementId);
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
			success: deleteOfficeSuccess,
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

function deleteOfficeSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;
		// Do better error handling on this one. I am getting lazy. . . or I just want to move forward.
		if (data.length > 1) {
			//$("#" + data).remove();
			$("#divOfficeDetails").hide();
			var contact_company_id = $("#contact_company_id").val();
			getOfficesByCompany('divOfficesList', contact_company_id);
			updateDropDownOfficeList(contact_company_id);
		} else {
			alert(data);
			// It didn't work
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function saveNewContact()
{
	try {

		window.savePending = true;

		var contact_company_id = $("#contact_company_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=saveNewContact';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&' + $('#frmContactInfo').serialize();
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
			success: saveNewContactSuccess,
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

function saveNewContactSuccess(data, textStatus, jqXHR) {
	try {

		window.savePending = false;

		var json = data;

		var user_id = json.user_id;
		var contact_id = json.contact_id;
		var customSuccessMessage = json.customSuccessMessage;

		var contact_company_id = $("#contact_company_id").val();
		var companyName = $("#companyName").val();

		messageAlert(messageText, 'successMessage');
		getEmployeesByCompany('divEmployees', contact_company_id, companyName);
		showContactInfo(contact_id, user_id);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function updateContactField(contact_id, attributeName)
{
	try {

		if (contact_id != 0) {
			window.savePending = true;

			uniqueId = $.trim(contact_id);
			attributeName = $.trim(attributeName);

			var elementId = attributeName;

			var newValue = $("#" + elementId).val();
			newValue = $.trim(newValue);

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=updateContactField';
			var ajaxQueryString =
			'attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(newValue);
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
				success: updateFieldSuccess,
				error: errorHandler
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

function updateMobileNetworkCarrier(contact_id, contact_phone_number_id)
{
	var elem = $("#mobilephone");
	var mobilephoneValue = elem.val();
	if (mobilephoneValue != '') {
		updateContactPhoneNumber(contact_id, contact_phone_number_id, 'mobilephone', '3');
	}
}
/*update the contact details in bidders*/
function updateMobileNetworkCarrierBidders(contact_id, contact_phone_number_id)
{
	var elem = $("#mobilephone_"+contact_id);
	var mobilephoneValue = elem.val();
	if (mobilephoneValue != '') {
		updateContactPhoneNumberBidders(contact_id, contact_phone_number_id, 'mobilephone', '3');
	}
}
function updateContactPhoneNumberBidders(contact_id, contact_phone_number_id, attributeName, phone_number_type_id)
{
	try {

		if (contact_id != 0) {
			window.savePending = true;

			var uniqueId = contact_id;

			var elem = $("#" + attributeName+"_"+contact_id);
			var newValue = elem.val();
			newValue = $.trim(newValue);

			if (phone_number_type_id == 3) {
				var mobile_network_carrier_id = $("#mobile_network_carrier_id_"+contact_id).val();
				if (mobile_network_carrier_id == '') {
					alert('Please select a Mobile Network Carrier from the above list');
					$("#mobile_network_carrier_id_"+contact_id).focus();
					return;
				}
			} else {
				var mobile_network_carrier_id = '';
			}

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=updateContactField';
			var ajaxQueryString =
			'attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(newValue) +
			'&contact_phone_number_id=' + encodeURIComponent(contact_phone_number_id) +
			'&phone_number_type_id=' + encodeURIComponent(phone_number_type_id) +
			'&mobile_network_carrier_id=' + encodeURIComponent(mobile_network_carrier_id);
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
				success: updateFieldSuccess,
				error: errorHandler
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

function updateContactPhoneNumber(contact_id, contact_phone_number_id, attributeName, phone_number_type_id)
{
	try {

		if (contact_id != 0) {
			window.savePending = true;

			var uniqueId = contact_id;

			var elem = $("#" + attributeName);
			var newValue = elem.val();
			newValue = $.trim(newValue);

			if (phone_number_type_id == 3) {
				var mobile_network_carrier_id = '';	
				/*var mobile_network_carrier_id = $("#mobile_network_carrier_id_"+contact_id).val();*/
				if (mobile_network_carrier_id == '') {
					/*Mobile Carrier has hide*/
					/*alert('Please select a Mobile Network Carrier from the above list');
					$("#mobile_network_carrier_id_"+contact_id).focus();
					return;*/
				}
			} else {
				var mobile_network_carrier_id = '';
			}

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=updateContactField';
			var ajaxQueryString =
			'attributeName=' + encodeURIComponent(attributeName) +
			'&uniqueId=' + encodeURIComponent(uniqueId) +
			'&newValue=' + encodeURIComponent(newValue) +
			'&contact_phone_number_id=' + encodeURIComponent(contact_phone_number_id) +
			'&phone_number_type_id=' + encodeURIComponent(phone_number_type_id) +
			'&mobile_network_carrier_id=' + encodeURIComponent(mobile_network_carrier_id);
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
				success: updateFieldSuccess,
				error: errorHandler
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

function updateOfficePhoneField(contact_company_office_id, contact_company_office_phone_number_id, elementId, phone_number_type_id)
{
	try {

		if (contact_company_office_id == 0) {
			return;
		}

		window.savePending = true;
		var elem = $("#" + elementId);
		var newValue = elem.val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=updateOfficePhoneNumber';
		var ajaxQueryString =
		'elementId=' + encodeURIComponent(elementId) +
		'&newValue=' + encodeURIComponent(newValue) +
		'&contact_company_office_id=' + encodeURIComponent(contact_company_office_id) +
		'&contact_company_office_phone_number_id=' + encodeURIComponent(contact_company_office_phone_number_id) +
		'&phone_number_type_id=' + encodeURIComponent(phone_number_type_id);
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
			success: updateFieldSuccess,
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

function updateCompanyField(contact_company_id, elementId, newId, incrementIndex)
{
	try {
		if(incrementIndex || incrementIndex==undefined){
			incrementIndex = '';
		}else{
			incrementIndex = incrementIndex+'-';
		}
		var newValue = $("#" + newId+'--'+incrementIndex+contact_company_id).val();
		newValue = $.trim(newValue);
		var newValueLength = newValue.length;

		if ((elementId == 'companyName') && (newValueLength == 0)) {
			var messageText = 'Company Name Cannot Be Empty';
			messageAlert(messageText, 'errorMessage', 'errorMessageLabel', elementId);
			return false;
		}

		if (contact_company_id != 0) {
			window.savePending = true;

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=updateCompanyField';
			var ajaxQueryString =
			'elementId=' + encodeURIComponent(elementId) +
			'&newValue=' + encodeURIComponent(newValue) +
			'&contact_company_id=' + encodeURIComponent(contact_company_id);
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
				success: updateFieldSuccess,
				error: errorHandler
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

function updateFieldSuccess(data, textStatus, jqXHR)
{
	try {

		window.savePending = false;

		var json = data;

		var attributeName = json.attributeName;
		var customSuccessMessage = json.customSuccessMessage;
		var errorMessage = json.errorMessage;
		var errorNumber = json.errorNumber;
		var newValue = json.newValue;
		var contact_company_id = $("#contact_company_id").val();
		var companyName = $("#companyName").val();
		var selectedContactId = $("#selectedContactId").val();
		var selectedUserId = $("#selectedUserId").val();
		var fullName = $("#first_name").val() + ' ' + $("#last_name").val();

		//messageAlert(customSuccessMessage, 'successMessage', 'successMessageLabel', attributeName);
		if(errorNumber == 0){
			messageAlert(errorMessage, 'successMessage');
		}
		else{
			if(newValue!='' && newValue!='null')
				messageAlert(errorMessage, 'errorMessage');
		}
		if (attributeName == 'companyName') {
			//getCompanyInfoByCompany('divCompanyInfo', contact_company_id, companyName);
			$('#company').val(companyName);
			checkSelection();
		}
		if (attributeName == 'first_name' || attributeName == 'last_name') {
			getEmployeesByCompany('divEmployees', contact_company_id, companyName);
			//loadContactPermissions(contact_company_id, selectedContactId);
			$("#contactInfoHeaderContactName").html(fullName);
			$("#contactRolesHeaderContactName").html(fullName);
			$("#contactProjectAccessHeaderContactName").html(fullName);
		}
		if (attributeName == 'mobilephone') {
			showContactInfo(selectedContactId, selectedUserId);
		}
		if (attributeName == 'email') {
			getEmployeesByCompany('divEmployees', contact_company_id, companyName);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function addContactToProject(contact_id)
{
	try {

		window.savePending = true;

		var project_id = $("#ddlUserCompanyProjects").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=addContactToProject';
		var ajaxQueryString =
		'contact_id=' + encodeURIComponent(contact_id) +
		'&project_id=' + encodeURIComponent(project_id);
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
			success: rolesUpdateSuccess,
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

function removeContactFromProject(project_id, contact_id)
{
	try {

		window.savePending = true;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=removeContactFromProject';
		var ajaxQueryString =
		'contact_id=' + encodeURIComponent(contact_id) +
		'&project_id=' + encodeURIComponent(project_id);
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
			success: rolesUpdateSuccess,
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

function addRoleToContactOnProject(project_id, contact_id)
{
	try {

		window.savePending = true;

		var role_id = $("#ddlRoleOptions_" + project_id).val();
		role_id = $.trim(role_id);

		project_id = $.trim(project_id);
		contact_id = $.trim(contact_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=addRoleToContactOnProject';
		var ajaxQueryString =
		'project_id=' + encodeURIComponent(project_id) +
		'&contact_id=' + encodeURIComponent(contact_id) +
		'&role_id=' + encodeURIComponent(role_id);
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
			success: rolesUpdateSuccess,
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

function removeRoleFromContactOnProject(project_id, contact_id, role_id)
{
	try {

		window.savePending = true;

		project_id = $.trim(project_id);
		contact_id = $.trim(contact_id);
		role_id = $.trim(role_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=removeRoleFromContactOnProject';
		var ajaxQueryString =
		'project_id=' + encodeURIComponent(project_id) +
		'&contact_id=' + encodeURIComponent(contact_id) +
		'&role_id=' + encodeURIComponent(role_id);
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
			success: rolesUpdateSuccess,
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

function removeRoleFromContact(contact_id, role_id)
{
	try {

		window.savePending = true;

		contact_id = $.trim(contact_id);
		role_id = $.trim(role_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=removeRoleFromContact';
		var ajaxQueryString =
		'contact_id=' + encodeURIComponent(contact_id) +
		'&role_id=' + encodeURIComponent(role_id);
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
			success: rolesUpdateSuccess,
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

function rolesUpdateSuccess(data, textStatus, jqXHR)
{
	//alert(data);
	window.savePending = false;
	var contact_id = data;
	var contact_company_id = $("#contact_company_id").val();
	loadContactPermissions(contact_company_id, contact_id);
}

function processUserInvitations()
{
	try {

		var selectedBoxes = new Array();
		$("input[name='inviteCheckbox']:checked").each(function() {
			selectedBoxes.push($(this).val());
		});

		if (selectedBoxes.length > 0) {
			window.savePending = true;

			var ajaxHandler = window.ajaxUrlPrefix + 'user-invitations-ajax.php?method=sendInvitationsToJoin';
			var ajaxQueryString =
			'csvContactIds=' + encodeURIComponent(selectedBoxes);
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
				success: processUserInvitationsSuccess,
				error: errorHandler
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

function processUserInvitationsSuccess(data, textStatus, jqXHR)
{
	window.savePending = false;
	var messageText = data + ' Invitation(s) successfully sent';
	messageAlert(messageText, 'successMessage');

	var contact_company_id = $("#contact_company_id").val();
	var companyName = $("#companyName").val();
	getEmployeesByCompany('divEmployees', contact_company_id, companyName);
}

function toggleAdministrator(contact_id)
{
	try {

		window.savePending = true;

		contact_id = $.trim(contact_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=toggleAdministrator';
		var ajaxQueryString =
		'contact_id=' + encodeURIComponent(contact_id);
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
			success: rolesUpdateSuccess,
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

function addTradeToCompany(cost_code_id)
{
	try {

		window.savePending = true;

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		if (typeof cost_code_id == 'undefined') {
			var cost_code_id = $("#ddlCompanyTrade").val();
			cost_code_id = $.trim(cost_code_id);
		}

		if (cost_code_id != 'null') {
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=addTradeToContactCompany';
			var ajaxQueryString =
			'contact_company_id=' + encodeURIComponent(contact_company_id) +
			'&cost_code_id=' + encodeURIComponent(cost_code_id);
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
				success: addOrRemoveTradeFromCompanySuccess,
				error: errorHandler
			});
		} else {
			messageText = 'Please select a trade from the drop down list of trades.';
			messageAlert(messageText, 'infoMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function removeTradeFromCompany(contact_company_id, cost_code_id)
{
	try {

		window.savePending = true;

		if (cost_code_id != 'null') {
			var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=removeTradeFromContactCompany';
			var ajaxQueryString =
			'contact_company_id=' + encodeURIComponent(contact_company_id) +
			'&cost_code_id=' + encodeURIComponent(cost_code_id);
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
				success: addOrRemoveTradeFromCompanySuccess,
				error: errorHandler
			});
		} else {
			messageText = 'Please select a trade from the drop down list of trades.';
			messageAlert(messageText, 'infoMessage');
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function addOrRemoveTradeFromCompanySuccess(data, textStatus, jqXHR)
{
	window.savePending = false;
	//alert(data);
	$("#divCompanyTrade").html(data);

	//$("#search--contact_company_trades").val('');
}
/** Page Functions ********************************************************/

function ajaxModulesLoaded(data, textStatus, XMLHttpRequest)
{
	//$(".listTable tr:odd").addClass('oddRow');
	//$(".listTable tr:even").addClass('evenRow');
	initializeAutoHintFields();
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	$(".phoneNumber").mask('?(999) 999-9999');
	$(".phoneExtension").mask('?(999) 999-9999 ext.9999');
	//$(".phoneNumber").mask('99/99/9999', {placeholder:' '});
	$("#" + setFocusToElement).focus();

	if ($("#phoneAutocompleteOptions").length) {
		$(function() {
			var autoCompleteList = $("#phoneAutocompleteOptions").val();
			var arrAutoCompleteList = jQuery.parseJSON(autoCompleteList);
			$("#phone").autocomplete({
				source: arrAutoCompleteList
			});

			autoCompleteList = $("#faxAutocompleteOptions").val();
			arrAutoCompleteList = jQuery.parseJSON(autoCompleteList);
			$("#fax").autocomplete({
				source: arrAutoCompleteList
			});
		});

		$("#phone").keyup(function(e) {
			var keyCode = (e.keyCode) ? e.keyCode : e.which;
			if (keyCode == 40 || keyCode == 38) {
				//alert('here');
			} else {
				var currentValue = $("#phone").val();
				currentValue = currentValue.replace(/\D/g, '');
				$("#phone").autocomplete('search', currentValue);
			}
		});

		$("#fax").keyup(function(e) {
			var keyCode = (e.keyCode) ? e.keyCode : e.which;
			if (keyCode == 40 || keyCode == 38) {
				//alert('here');
			} else {
				var currentValue = $("#fax").val();
				currentValue = currentValue.replace(/\D/g, '');
				$("#fax").autocomplete('search', currentValue);
			}
		});
	}

	//$(".phoneNumber").mask("?(999) 999-9999");'
}

function checkForSimilarCompanyNames(element)
{
	var elementId = element.id;
	var companyName = $("#" + elementId).val();
	companyName = companyName.trim();
	if (companyName.length == 0) {
		$("#divSimilarCompanyNamesContainer").hide();
	} else {

		var similarNames = [];
		var similarCompanies = [];

		// Look for exact match of the whole string.
		for (var i = 0; i < arrCompanies.length; i++) {
			var tempCompany = arrCompanies[i];
			var tempName = tempCompany.name;
			if (tempName === companyName) {
				if (similarNames.indexOf(tempName) === -1) {
					similarNames.push(tempName);
				}
				if (similarCompanies.indexOf(tempCompany) === -1) {
					similarCompanies.push(tempCompany);
				}
			}
		}

		// Look for exact match of the tokens.
		var tokens = companyName.split(/\s+/g);
		for (var i = 0; i < tokens.length; i++) {
			var token = tokens[i];
			for (var j = 0; j < arrCompanies.length; j++) {
				var tempCompany = arrCompanies[j];
				var tempName = tempCompany.name;
				var match = checkToken(token, tempName, 0);
				if (match) {
					if (similarNames.indexOf(tempName) === -1) {
						similarNames.push(tempName);
					}
					if (similarCompanies.indexOf(tempCompany) === -1) {
						similarCompanies.push(tempCompany);
					}
				}
			}
		}

		// Helper function that checks to see if strings s1 & s2 are equal.
		function checkToken(s1, s2, i) {
			s1 = s1.toLowerCase();
			s2 = s2.toLowerCase();
			if (s1[i] === s2[i] && typeof s1 !== 'undefined') {
				if (i < s1.length-1) {
					return checkToken(s1, s2, i+1);
				} else {
					return true;
				}
			} else {
				return false;
			}
		}

		/*
		var companyNameLowercase = companyName.toLowerCase();
		var companyNameStripWhitespace = companyName.replace(/\s/g, '');
		var companyNameStripDots = companyName.replace('.', '');
		var companyNameReplaceDotsWithSpaces = companyName.replace('.', ' ');
		var patterns = [ companyNameLowercase,
						 companyNameStripWhitespace,
						 companyNameStripDots,
						 companyNameReplaceDotsWithSpaces ];

		var similarNames = [];
		var similarCompanies = [];

		for (var i = 0; i < arrCompanies.length; i++) {
			var tempCompany = arrCompanies[i];
			var tempName = tempCompany.name;
			// Iterate over the above patterns, looking for a match.
			for (var j = 0; j < patterns.length; j++) {
				var pattern = patterns[j];
				var same = tempName === pattern;
				var alreadyAdded = similarNames.indexOf(tempName) != -1;
				if (same && !alreadyAdded) {
					similarNames.push(tempName);
					similarCompanies.push(tempCompany);
				}
			}
			// Iterate over tokenized companyName, looking for a match.
			var tokens = companyName.split(/\s/);
			for (var j = 0; j < tokens.length; j++) {
				var token = tokens[j];
				var tokenIsString = typeof token === 'string';
				var tempNameIsString = typeof tempName === 'string';
				if (tokenIsString && tempNameIsString) {
					var tempNameContainsToken = tempName.toLowerCase().indexOf(token.toLowerCase()) != -1;
					if (tempNameContainsToken) {
						similarNames.push(tempName);
						similarCompanies.push(tempCompany);
					}
				}
			}
		}
		*/

		if (similarNames.length == 0) {
			$("#divSimilarCompanyNamesContainer").hide();
		} else {
			$("#divSimilarCompanyNamesContainer").show();
			var html = '<ul>';
			for (var i = 0; i < similarNames.length; i++) {
				var similarName = similarNames[i];
				html += '<li><a onclick="similarNameSelected(\'' + similarCompanies[i].id + '\')">' + similarName + '</a></li>';
			}
			html += '</ul>';
			$("#divSimilarCompanyNamesList").html(html);
		}
	}
}

function similarNameSelected(companyId)
{
	for (var i = 0; i < arrCompanies.length; i++) {
		if (arrCompanies[i].id == companyId) {
			$("#company").val(arrCompanies[i].name);
			$("#contact_company_id").val(arrCompanies[i].id);
			break;
		}
	}
	$("#divCompanyInfoModal").dialog('close');
	checkSelection();
}

function rendorCreateContactForm(contact_company_id)
{
	try {

		var contact_company_id = $("#contact_company_id").val();
		contact_company_id = $.trim(contact_company_id);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=rendorCreateContactForm';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divContactPermissions").hide();
		$("#divContactPermissions").html('');

		$("#divContactInformation").load(ajaxUrl, ajaxModulesLoaded);
		// $("#divContactInformation").load(ajaxUrl);
		$("#divContactInformation").show();

		/*
		if (contact_id != '0') {
			$("#divContactPermissions").hide();
			setFocusToElement = 'first_name';
		}
		*/

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadContactDialog()
{
	$("#complist").css('display','none');
	$("#contact_list").show();
	$("#non_contact_list").hide();
	$("#divContactInformation").hide();
	$("#divContactPermissions").hide();
}

function loadArchivedContactDialog()
{
	$("#complist").css('display','none');
	$("#non_contact_list").show();
	$("#contact_list").hide();
	$("#divArchivedContactInformation").hide();
	$("#divArchivedContactPermissions").hide();
}

function loadToArchiveContactDialog(id) {

	$("#dialog-confirm").html("Are you sure want to delete? You will be able to view the history of this contact, but you can no longer assign tasks to them within this company");

    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Confirmation",
        buttons: {
            "Cancel": function () {
                $(this).dialog('close');              
            },
            "Ok": function () {
                $(this).dialog('close');
                callbackToArchive(true,id);
            }
        }
    });
}
function callbackToArchive(value,id) {
    if (value) {
    	var ajaxUrl = window.ajaxUrlPrefix + 'modules-archive-contact.php'; 		
		$.ajax({
			url: ajaxUrl,
			method:'POST',
			data : {id:id, is_archive:'true'},
			success: archiveContactCallback
		});
	} 
}

function archiveContactCallback(data){
	if (data == 1) { 
		messageAlert('Contact archived successfully', 'successMessage');	
		setTimeout(function(){
			var contact_company_id = $("#contact_company_id").val();
			var companyName = $("#companyName").val();
			getEmployeesByCompany('divEmployees', contact_company_id, companyName);
			$("#divContactInformation").hide();
			$("#divContactPermissions").hide();
		},1000);
	}
};

function loadCreateContactCompanyDialog()
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadCreateContactCompanyDialog';
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
			success: loadCreateContactCompanyDialogSuccess,
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

function loadCreateContactCompanyDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divCreateContactCompanyDialog").html(data);
		$("#divCreateContactCompanyDialog").removeClass('hidden');
		$("#divCreateContactCompanyDialog").dialog({
			title: 'Create New Company',
			modal: true,
			height: 450,
			width: 600,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divCreateContactCompanyDialog").addClass('hidden');
				$("#divCreateContactCompanyDialog").html('');
				$("#divCreateContactCompanyDialog").dialog('destroy');
			}
		});

		var dummyId = $("#divCreateContactCompanyDialogDummyId").val();
		$("#create-contact_company-record--contact_companies--company--" + dummyId).autocomplete({
			source: arrCompanies,
			select: function(event, ui) {
				$("#divCreateContactCompanyDialog").dialog('close');
				companySelected(event, ui);
			},
			position: {
				of: $("#divSimilarCompanyNamesContainer")
			}
		});

		ajaxModulesLoaded(data, textStatus, jqXHR);

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadCreateContactCompanyOfficeDialog()
{
	try {

		var contact_company_id = $("#contact_company_id").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=loadCreateContactCompanyOfficeDialog';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id);
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
			success: loadCreateContactCompanyOfficeDialogSuccess,
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

function loadCreateContactCompanyOfficeDialogSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divCreateContactCompanyOfficeDialog").html(data);
		$("#divCreateContactCompanyOfficeDialog").removeClass('hidden');
		$("#divCreateContactCompanyOfficeDialog").dialog({
			title: 'Create New Contact Company Office',
			modal: true,
			height: 600,
			width: 600,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$(this).addClass('hidden');
				$(this).html('');
				$(this).dialog('destroy');
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

function createContactCompanyAndReloadDdlContactCompaniesViaPromiseChain(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.promiseChain = true;
		options.responseDataType = 'json';

		showSpinner();
		var contact_company_id = 0;
		var promise1 = createContactCompany(attributeGroupName, uniqueId, options);
		var promise2 = promise1.then(function(json) {

			var errorNumber = json.errorNumber;
			if (errorNumber == 0) {
				var uniqueId = json.uniqueId;
				contact_company_id = uniqueId;
				var innerPromise = reloadDllContactCompanies(options);
				return innerPromise;
			}

		});
		promise2.then(function() {
			$("#divCreateContactCompanyDialog").dialog('close');
			$("#ddlContactCompanies").val(contact_company_id);
			ddlContactCompanyChanged();
		});
		promise2.always(function() {
			hideSpinner();
		});
		promise2.fail(function() {
			// window.location.reload();
		});

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function reloadDllContactCompanies(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=reloadDllContactCompanies';
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
			success: reloadDllContactCompaniesSuccess,
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

function reloadDllContactCompaniesSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var htmlContent = json.htmlContent;
		$("#ddlContactCompanies").html(htmlContent);
		initializeContactCompanyAutocompleteWidget();

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__createContactToRole(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Contacts_Manager__createContactToRoleSuccess;

		createContactToRole(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__createContactToRoleSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;

			//var contact_id = json.contact_id;
			//var contact_company_id = json.contact_company_id;

			var arrPrimaryKey = uniqueId.split('-');
			var contact_id = arrPrimaryKey[0];
			var contact_company_id = $("#contact_company_id").val();
			loadContactPermissions(contact_company_id, contact_id);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function postContactCreation()
{
	try {

		var elementId = 'divEmployees';

		var contact_company_id = $("#contact_company_id").val();
		var contact_company_name = $("#company").val();
		contact_company_id = $.trim(contact_company_id);
		contact_company_name = $.trim(contact_company_name);

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-contacts-manager-ajax.php?method=getEmployeesByCompany';
		var ajaxQueryString =
		'contact_company_id=' + encodeURIComponent(contact_company_id) +
		'&companyName=' + encodeURIComponent(contact_company_name);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		//$("#" + elementId).load(ajaxUrl, ajaxModulesLoaded);
		//$("#" + elementId).show();

		//$.ajaxq.clear('contact_companies');
		$.ajaxq('contact_companies', {
			url: ajaxHandler,
			data: ajaxQueryString,
			//success: ajaxModulesLoaded,
			error: errorHandler
		}).done(function(html) {
			$("#" + elementId).html(html);
			$("#" + elementId).show();
			$("#btnManageCompany").prop('disabled', false);
			$("#refreshCompanyDataId").prop('disabled', false);
		});

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__createContactCompanyOffice(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Contacts_Manager__createContactCompanyOfficeSuccess;

		createContactCompanyOffice(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__createContactCompanyOfficeSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var contact_company_id = json.contact_company_id;

			$("#divCreateContactCompanyOfficeDialog").dialog('close');
			getOfficesByCompany('divOfficesList', contact_company_id);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__updateAllContactCompanyOfficeAttributes(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Contacts_Manager__updateAllContactCompanyOfficeAttributesSuccess;

		updateAllContactCompanyOfficeAttributes(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__updateAllContactCompanyOfficeAttributesSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			cancelOfficeDetails('');
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__createContact(attributeGroupName, uniqueId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		options.responseDataType = 'json';
		options.successCallback = Contacts_Manager__createContactSuccess;

		ajaxQueryString = '';
		// mobile_network_carrier_id
		var mobile_network_carrier_id_element_id = 'ddl--' + attributeGroupName + '--mobile_network_carriers--mobile_network_carrier_id--' + uniqueId;
		if ($("#" + mobile_network_carrier_id_element_id).length) {
			var mobile_network_carrier_id = $("#" + mobile_network_carrier_id_element_id).val();
			ajaxQueryString = ajaxQueryString + '&mobile_network_carrier_id=' + encodeURIComponent(mobile_network_carrier_id);
		}
		options.adHocQueryParameters = ajaxQueryString;

		createContact(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__createContactSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			$("#divContactInformation").hide();
			$("#divContactInformation").html('');
			postContactCreation();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Contacts_Manager__attachSearchTradesAutoComplete()
{
	var searchToken = $(searchTextElement).val();
	searchToken = searchToken.toLowerCase();

	var searchTokenLength = searchToken.length;
	if (searchTokenLength < 2) {
		return;
	}

	$("#" + selectElementId + " option").each( function() {

		//var optionText = this.text;
		//var optionValue = this.value;

		var optionText = $(this).text();
		optionText = optionText.toLowerCase();

		var optionValue = $(this).val();

		var matchedIndex = optionText.indexOf(searchToken);
		if (matchedIndex > -1 ) {
			$("#" + selectElementId).val(optionValue);
			//return;
		}

	});

	/*
	if (searchToken == '') {
		arrOptions[0].selected = true;
	}
	*/
}

function initializeContactCompanyTradesAutocompleteWidget()
{
	var ddlContactCompanyTrades = $("#ddlCompanyTrade");
	var ddlContactCompanyTradesElement = ddlContactCompanyTrades[0];

	if (typeof ddlContactCompanyTradesElement == 'undefined') {
		return;
	}

	arrContactCompanyTrades = getArrContactCompanyTradesFromDropdown(ddlContactCompanyTradesElement);

	$("#search--contact_company_trades").autocomplete({
		appendTo: "#search--contact_company_trades--results",
		open: function( event, ui ) {
			$("#search--contact_company_trades--close_button").show();

		},
		source: arrContactCompanyTrades,
		select: contactCompanyTradeSelected,

		close : function (event, ui) {
			event.preventDefault();

			if ( event.which == 1 ) {
				$("#search--contact_company_trades--results ul.ui-autocomplete").show();
				$("#search--contact_company_trades--results ul.ui-autocomplete").data('keep-open', 1);
			}
			else if ( $("#search--contact_company_trades--results ul.ui-autocomplete").data('keep-open') == 1) {
				$("#search--contact_company_trades--results ul.ui-autocomplete").show();
				$("#search--contact_company_trades--results ul.ui-autocomplete").data('keep-open', 0);
			}

			return false;
		}

	});
}

function closeContactCompanyTradesAutocompleteWidget()
{
	$("#search--contact_company_trades").autocomplete('close');
	$("#search--contact_company_trades--close_button").hide();
}

function contactCompanyTradeSelected(event, ui)
{
	var contactCompanyTrade = ui.item.label;
	var cost_code_id = ui.item.id;

	addTradeToCompany(cost_code_id);

	// Debug
	//alert(contactCompanyTrade + ': ' + cost_code_id);
}

function getArrContactCompanyTradesFromDropdown(ddlElement)
{
	var arrContactCompanyTrades = [];
	var options = ddlElement.options;
	for (var i = 1; i < options.length; i++) {
		var id = decode(options[i].getAttribute('value'));
		var name = decode(options[i].innerHTML);
		var company = {
			id: id,     // Fill arrCompanies with 'company' objects.
			name: name, // We use the id and name properties.
			value: name // jQuery uses the value property for autocomplete.
		};
		arrContactCompanyTrades.push(company);
	}

	return arrContactCompanyTrades;
}

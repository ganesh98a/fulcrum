$(function() {
	if ($("#from_creation_menu").val() == 1) {
		$("#softwareModuleHeadline").html('Create New Project');
	}
	loadProjectInfo();
});

function loadProjectInfo()
{
	try {

		var project_id = $("#the_project_id").val();
		var fromCreateLink = $("#from_creation_menu").val();

		var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-ajax.php?method=loadProjectInfo';
		var ajaxQueryString =
		'project_id=' + encodeURIComponent(project_id) +
		'&fromCreateLink=' + fromCreateLink;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divProjectInfo").load(ajaxUrl, ajaxModulesLoaded);
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function importcostcodeForProject(project_id)
{

	var ajaxHandler = window.ajaxUrlPrefix + 'importCostCode.php?project_id='+project_id;

	$.ajax({
		url: ajaxHandler,
		success: function(data)
		{

		}

	});
}
function ajaxModulesLoaded(responseText, textStatus, XMLHttpRequest)
{
	$(".datepicker").datepicker({ changeMonth: true, changeYear: true, dateFormat: 'mm/dd/yy', numberOfMonths: 1 });
	
	$(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert('Positive integers only'); this.value = ''; this.focus(); });
	$('.retainer_rate_value').on('input',function() {
		var	match = (/(\d{0,3})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
		this.value = match[1] + match[2];
	});
	var project_id = $("#the_project_id").val();
	var defaultTemplateId = $("#manage-project-record--projects--draw_template_id--"+project_id).val();
	if(defaultTemplateId){
		$("#viewTemplate").show();
	}else{
		$("#viewTemplate").hide();
	}

}

function showNewProject()
{
	$("#softwareModuleHeadline").html('Create New Project');
	$("#the_project_id").val(1);
	loadProjectInfo();
}

function cancelNewProject()
{
	window.location.reload(false);
}

function loadManageProjectTypesDialog()
{
	try {
		var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-ajax.php?method=loadManageProjectTypesDialog';
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
			success: loadManageProjectTypesDialogSuccess,
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

function loadManageProjectTypesDialogSuccess(data, textStatus, jqXHR)
{
	try {

		var windowWidth = $(window).width();
		var windowHeight = $(window).height();
		var modalDialogWidth = 700;
		var modalDialogHeight = windowHeight * 0.98;

		$("#divProjectTypesDialog").html(data);
		$("#divProjectTypesDialog").removeClass('hidden');
		$("#divProjectTypesDialog").dialog({
			modal: true,
			title: 'Manage Project Types',
			width: modalDialogWidth,
			height: modalDialogHeight,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("#divProjectTypesDialog").addClass('hidden');
				$("#divProjectTypesDialog").dialog('destroy');
				$("body").removeClass('noscroll');
			}
		});

		var startIndex;
		$("#tableProjectTypes tbody").sortable({
			axis: 'y',
			distance: 10,
			helper: sortHelper,
			start: function(event, ui) {
				startIndex = $(ui.item).index();
			},
			stop: function(event, ui) {
				var element = ui.item[0];
				var endIndex = $(ui.item).index();
				if (startIndex != endIndex) {
					endIndex = endIndex.toString();
					var options = { endIndex: endIndex, responseDataType: 'json' };
					updateProjectType(element, options);
				}
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

function Projects_Admin__Manage_Project_Types__createProjectType(attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.promiseChain = false;
		options.responseDataType = 'json';
		options.successCallback = Projects_Admin__Manage_Project_Types__createProjectTypeSuccess;

		createProjectType(attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Projects_Admin__Manage_Project_Types__createProjectTypeSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var attributeGroupName = json.attributeGroupName; // E.g. "manage-project-record"
			var attributeSubgroupName = json.attributeSubgroupName; // E.g. "projects"
			var uniqueId = json.uniqueId; // New Id, E.g. "--1234"
			var previousAttributeGroupName = json.previousAttributeGroupName; // E.g. "create-project-record"
			var dummyId = json.dummyId; // Old pk/uk dummy placeholder

			var htmlRecordTr = json.htmlRecordTr;
			var htmlRecordOption = json.htmlRecordOption;
			var project_id = json.project_id;

			var trRecordContainerElementId = 'record_container--' + attributeGroupName + '--' + attributeSubgroupName + '--sort_order--' + uniqueId;
			var optionRecordContainerElementId = 'manage-project-record--projects--project_type_id--' + project_id;

			$("#record_creation_form_container--create-project_type-record")[0].reset();
			$("#tableProjectTypes tbody").prepend(htmlRecordTr);
			$("#" + optionRecordContainerElementId).prepend(htmlRecordOption);
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Projects_Admin__Manage_Project_Types__deleteProjectType(recordContainerElementId, attributeGroupName, uniqueId, options)
{
	try {

		var options = options || {};

		options.responseDataType = 'json';
		options.successCallback = Projects_Admin__Manage_Project_Types__deleteProjectTypeSuccess;

		deleteProjectType(recordContainerElementId, attributeGroupName, uniqueId, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Projects_Admin__Manage_Project_Types__deleteProjectTypeSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			var uniqueId = json.uniqueId;
			var project_id = json.project_id;

			// Note: the standard <tr> record is DOM deleted by the default ajax delete callback

			// Remove <option>
			var ddlRecordContainerId = 'manage-project-record--projects--project_type_id--' + project_id;
			$("#" + ddlRecordContainerId + " option[value="+uniqueId+"]").remove();
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Projects_Admin__createProject(attributeGroupName, uniqueId)
{
	try {

		var project_name = $("#create-project-record--projects--project_name--" + uniqueId).val();
		project_name = $.trim(project_name);
		if (project_name.length < 2) {
			var messageText = 'Project name must be at least 2 characters';
			messageAlert(messageText,'errorMessage','errorMessageLabel','projectName');
			return;
		}
		var project_type = $("#create-project-record--projects--project_type_id--" + uniqueId).val();

		var options = { promiseChain: false, responseDataType: 'json', successCallback: Projects_Admin__createProjectSuccess };

		ajaxQueryString = '';

		// Different attributeSubgroupName.
		var default_project_id_element_id = attributeGroupName + '--users--default_project_id--' + uniqueId;
		if ($("#" + default_project_id_element_id).length) {

			var defaultProjectIdChecked = $("#" + default_project_id_element_id).prop('checked');
			if (defaultProjectIdChecked) {
				default_project_id = 'Y';
			} else {
				default_project_id = 'N';
			}

			ajaxQueryString = ajaxQueryString + '&default_project_id=' + encodeURIComponent(default_project_id);
			options.adHocQueryParameters = ajaxQueryString;

		}
		createProject(attributeGroupName, uniqueId, options, project_name,project_type);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Projects_Admin__createProjectSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;
		var errorNumber = json.errorNumber;

		if (errorNumber == 0) {
			// Refresh page to update session and switch over to the new project, etc.
			window.location = '/admin-projects.php';
		}

	} catch (error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function Projects_Admin__contactEntity(element)
{
	try {
		var entity = element.value;
		var project_id = $(element).data("project_id");

		if(entity){
			$.get('projects-ajax.php',{'method':'updateProjectEntity','company_entity_id':entity,'project_id':project_id},
				function(data){
					var json = data.split('|');
					var errorNumber = json[0];
					var license = json[1];
					if(errorNumber == 0)
					{
						var licdata = '<input id="manage-project-record--contracting_entities--construction_license_number--'+entity+'" type="text" tabindex="508" value="'+license+'" onchange="ContractingEntityUpdate(this)">';
						$('#span_contract_license').empty().append(licdata);
						
					}
				console.log(data);

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
function ContractingEntityUpdate(element)
{
	var elementId = $(element).attr('id');
	var arrParts = elementId.split('--');
	var attributeGroupName = arrParts[0];
	var attributeSubgroupName = arrParts[1];
	var attributeName = arrParts[2];
	var uniqueId = arrParts[3];
	var newValue = $(element).val();
	$.get('projects-ajax.php',{'method':'updatecontractEntity','entity_id':uniqueId,'newValue':newValue,'attributeName':attributeName,'table':attributeSubgroupName},
				function(data){
				//console.log(data);
			});
}

function Projects_Admin__updateProject(element)
{
	try {

		var options = { responseDataType: 'json' };

		ajaxQueryString = '';

		// Test for ddl-- prepended to the element id
		var elementId = $(element).attr('id');
		// Get the first five characters of the element id string
		var elementIdSubstring = elementId.substring(0, 5);
		if (elementIdSubstring == 'ddl--') {
			var originalElementId = elementId;
			// Strip off "ddl--" from the element id
			elementId = elementId.substring(5);
		}

		// Test for record_container-- prepended to the element id for sort_order case
		var index = elementId.indexOf('sort_order');
		if (index > -1) {
			var elementIdSubstring = elementId.substring(0, 18);
			if (elementIdSubstring == 'record_container--') {
				elementId = elementId.substring(18);
			}
		}

		var arrParts = elementId.split('--');
		var attributeGroupName = arrParts[0];
		var attributeSubgroupName = arrParts[1];
		var attributeName = arrParts[2];
		var uniqueId = arrParts[3];

		if (attributeName == 'project_name') {

			var newValue = $(element).val();
			var project_name = $.trim(newValue);
			if (project_name.length < 2) {

				var messageText = "Project name must be at least 2 characters.";
				messageAlert(messageText,'errorMessage');
				// @todo Update form validation functions to support min length

				$(element).addClass('redBorderThick');
				$(element).focus();
				$(element).on('blur', function(event) {
					var val = $(element).val();
					val = $.trim(val);
					if (val.length >= 2) {
						$(element).removeClass('redBorderThick');
					}
				});
				return false;

			} else {
				options.performRefreshOperation = 'Y';
			}

		} else if (attributeName == 'default_project_id') {

			newValue = 'N';
			if ($(element).is(':checked')) {
				newValue = 'Y';
			}

			options.attributeSubgroupName = 'users';
			options.adHocQueryParameters = '&newValue=' + newValue;

		} else if (attributeName == 'retainer_rate'){
			$('#'+attributeGroupName+'--projects--retainer_rate_hidden--'+uniqueId).val(element.value);
		}

		updateProject(element, options);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
function updateRetainerRate(element,attributeGroupName,projectId){
	Projects_Admin__updateProject(element);
	//update retainer rate in hidden field
	$('#'+attributeGroupName+'--projects--retainer_rate_hidden--'+projectId).val(element.value);
};
//show warning on retainer rate edit
function showRetainerRateWarning(element,attributeGroupName,projectId){
	var existingRetainerRate = $('#'+attributeGroupName+'--projects--retainer_rate_hidden--'+projectId).val();
	var newRetainerRate = element.value ? (parseFloat(element.value)).toFixed(2) : '';
	//update retainer value as decimal value
	$('#'+attributeGroupName+'--projects--retainer_rate--'+projectId).val(newRetainerRate);
	if(existingRetainerRate == newRetainerRate){
		return false;
	}
	var updateValue = existingRetainerRate;

	if(existingRetainerRate){
		$("#divRetainerRateDialog").html("All the upcoming Draws will use the updated retention rate. Would you still like to proceed further?");
		// Define the Dialog and its properties.
		$("#divRetainerRateDialog").dialog({
			resizable: false,
			modal: true,
			title: "Confirmation",
			buttons: {
				"No": function () {
					$(this).dialog('close');
				},
				"Yes": function () {
					updateValue = newRetainerRate;
					$(this).dialog('close');
					updateRetainerRate(element,attributeGroupName,projectId);
				}
			},
			close : function(){
		  	$('#'+attributeGroupName+'--projects--retainer_rate--'+projectId).val(updateValue);
			}
		});
	}else{
		updateRetainerRate(element,attributeGroupName,projectId);
	}
};

function viewDefaultDrawTemplate(element){
	if(element && element.value){
		var templateId = element.value;
		if(templateId){
			var redirectUrl = "/draw-templates.php?templateId="+templateId;
			$("#viewTemplate").show();
			$("#viewTemplate").attr('href',redirectUrl);
		}else{
			$("#viewTemplate").hide();
		}
	}else{
		$("#viewTemplate").hide();
	}
};
function setDeliveryTime(attributeGroupName,project_id){

	var time_zone_id = $('#'+attributeGroupName+'--projects--time_zone_id--'+project_id).val();
	var delivery_time_id = $('#'+attributeGroupName+'--projects--delivery_time_id--'+project_id).val();

	var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-ajax.php?method=setDeliveryTime&project_id='+project_id+'&time_zone_id='+time_zone_id+'&delivery_time_id='+delivery_time_id;

	$.ajax({
		url: ajaxHandler,
		success: function(data)
		{
			$('#'+attributeGroupName+'--projects--delivery_time--'+project_id).val(data);
		}

	});

};
function renderCmpyContact(element,user_company_id,project_id){
	var elementId = $(element).attr('id');
	var architect_cmpy_id = $(element).val();

	var arrParts = elementId.split('--');
	var attributeGroupName = arrParts[0];

	var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-ajax.php?method=renderCmpyContact&project_id='+project_id+'&user_company_id='+user_company_id+'&architect_cmpy_id='+architect_cmpy_id+'&attributeGroupName='+attributeGroupName;

	$.ajax({
		url: ajaxHandler,
		success: function(data)
		{
			$('#architect_cont_'+project_id).html(data);
		}

	});

}
var owner_name = $('.qb_customer_edit').val();
$.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
		{'action':'checkprojectcustomerexist','owner_name':owner_name}, function(data){
	if($.trim(data) =='exists'){
		$('.current_indicator').addClass('green-text');
		$('.current_indicator').removeClass('red-text');
	}else{
		$('.current_indicator').addClass('red-text');
		$('.current_indicator').removeClass('green-text');
	}
});
function refreshProjectCustomer(){
	$.get(window.ajaxUrlPrefix+'app/controllers/accounting_cntrl.php',
		{'action':'getAllProjectCustomer'},function(data){
			location.reload();
	});
};

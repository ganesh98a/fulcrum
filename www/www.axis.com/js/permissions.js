var tabName;
function getTabId(){	
	var search=window.location.search;	
	var pathname = window.location.pathname.split('/');
	var pathname = pathname[1];	

	if (pathname == 'admin-projects-team-management.php' || pathname == 'modules-permissions-form.php' || pathname == 'app') {
		if(search!=''){
			var id = search.split('=');
			tabId=id[1];
		}else{
			tabId = 1;
		}

		if (tabId == 1) {
			tabName = 'team';
		}else if (tabId == 2) {
			tabName = 'subcontractor';
		}else{
			tabName = 'bidder';
		}
	}else{
		tabName = 'all';
	}
}
function projectChanged()
{		
	var project_id = $("#project_id").val();
	$("#currentlySelectedProjectId").val(project_id);
	getTabId();
	loadProjectContactList('company ASC, first_name ASC, last_name ASC', '',tabName);
	softwareModuleChanged();
}

function softwareModuleChanged(filter_by_recommended_roles_flag)
{
	if (filter_by_recommended_roles_flag == undefined) {
		filter_by_recommended_roles_flag = 0;
	}

	var software_module_id = $("#ddl_software_module_id").val();
	var project_id = $("#project_id").val();
	var ary = software_module_id.split('_');
	software_module_id = ary[0];
	if (ary[1] == 'Y') {
		$("#project_id").show();
		$(".divTabs").show();
		$("#divProjectContactList").show();
		$("#divAddTeamMembers").show();
		loadTeamMembers(project_id);
	} else {
		project_id = 0;
		$("#divProjectContactList").hide();
		$("#divAddTeamMembers").hide();
		$("#project_id").hide();
		$(".divTabs").hide();
	}
	if($('#unique_team_mem').length)
		{
			filter_by_recommended_roles_flag='1';
		}else
		{
			filter_by_recommended_roles_flag='0';
		}

	loadPermissionDetails(software_module_id, project_id, filter_by_recommended_roles_flag);
	loadPermissionsAssignmentsByRole(software_module_id, project_id,filter_by_recommended_roles_flag);
}

function loadTeamMembers(project_id)
{
	//$("#divProjectTeamMembers").load();
	// This is a call to the admin-projects-team-management.js file
	getTabId();
	
	loadProjectContactList('company ASC, first_name ASC, last_name ASC', '',tabName);
}

function loadPermissionDetails(software_module_id, project_id, filter_by_recommended_roles_flag, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		if (filter_by_recommended_roles_flag == undefined) {
			var isChecked = $("#checkboxFilterRoles").prop('checked');
			if (isChecked) {
				filter_by_recommended_roles_flag = 1;
			} else {
				filter_by_recommended_roles_flag = 0;
			}
		}
		var team_category;
		if($('#unique_team_mem').length)
		{
			team_category='1';
		}else
		{
			team_category='0';
		}

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=loadPermissionsConfigurationMatrixByRole';
		var ajaxQueryString =
			'software_module_id=' + encodeURIComponent(software_module_id) +
			'&project_id=' + encodeURIComponent(project_id) +
			'&team_category=' + encodeURIComponent(team_category) +
			'&filter_by_recommended_roles_flag=' + encodeURIComponent(filter_by_recommended_roles_flag);
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
			success: loadPermissionDetailsSuccess,
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

function loadPermissionDetailsSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divPermissionsMatrix").html(data);
		$(".bs-tooltip").tooltip({
			container: 'body',
			customX: -5,
			delay: {
				show: 500,
				hide: 0
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

function loadPermissionsAssignmentsByRole(software_module_id, project_id, filterval, options)
{
	try {
		if(filterval == '' || filterval == 'null' || filterval == undefined){
			filterval = 0;
		}
		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		//var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-project-based-permissions-matrix.php?method=dummy';
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=loadPermissionsAssignmentsByRole';
		var ajaxQueryString =
			'software_module_id=' + encodeURIComponent(software_module_id) +
			'&project_id=' + encodeURIComponent(project_id)+
			'&filterval=' + encodeURIComponent(filterval);
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
			success: loadPermissionsAssignmentsByRoleSuccess,
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

function loadPermissionsAssignmentsByRoleSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divPermissionsAssignmentsByContact").html(data);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadPermissionModal(software_module_id, project_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// @todo Convert "#_Y/N" to separate variables with separate values
		software_module_id = $.trim(software_module_id);
		project_id = $.trim(project_id);

		//var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-list-by-project-module.php?method=dummy';
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=loadPermissionModal';
		var ajaxQueryString =
			'software_module_id=' + encodeURIComponent(software_module_id) +
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
			success: loadPermissionModalSuccess,
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

function loadPermissionModalSuccess(data, textStatus, jqXHR)
{
	try {

		$("#divPermissionModal").empty().html(data);
		softwareModuleChanged('1');
		$("#divPermissionModal").dialog({
			width: 950,
			height: 600,
			modal: true,
			open: function() {
				$("body").addClass('noscroll');
			},
			close: function() {
				$("body").removeClass('noscroll');
				$("#divPermissionModal").dialog('destroy');
				$("#divPermissionModal").empty().html();
				permissionModalClosed();
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

function permissionContactsLoaded()
{
	$(".permissionContactRoleRow").hide();
}

function togglePermission(inputId, prereqs, dependents, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// InputID = user_company_id _ contact_id _ software_module_id _ project_id _ role_id _ software_module_function_id
		var isChecked = $("#" + inputId).is(':checked');

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=updateRoleFunctionPermission';
		var ajaxQueryString =
			'inputID=' + encodeURIComponent(inputId) +
			'&isChecked=' + encodeURIComponent(isChecked);
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
			success: togglePermissionSuccess,
			error: errorHandler
		});

		if (promiseChain) {
			return returnedJqXHR;
		}

		if (isChecked && prereqs.length > 0) {
			togglePrerequisitePermissions(inputId, prereqs);
		}

		if (isChecked == false && dependents.length > 0) {
			toggleDependentPermissions(inputId, dependents);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function togglePermissionSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var elementId = json.elementId;
		var project_id = json.project_id;
		var contact_id = json.contact_id;
		var role_id = json.role_id;
		var software_module_id = json.software_module_id;
		var software_module_function_id = json.software_module_function_id;
		var customSuccessMessage = json.customSuccessMessage;

		elementId = 'td_' + elementId;

		messageAlert(customSuccessMessage, 'successMessage');

		// Reload Contacts Permission Matrix
		//var software_module_id = $("#ddl_software_module_id").val();
		//var project_id = $("#project_id").val();
		//var ary = software_module_id.split('_');
		//software_module_id = ary[0];
		if($('#unique_team_mem').length)
		{
			team_category='1';
		}else
		{
			team_category='0';
		}
		loadPermissionsAssignmentsByRole(software_module_id, project_id,team_category);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function togglePrerequisitePermissions(inputId, prereqs, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var baseInputId = inputId.substr(0, inputId.lastIndexOf('_') + 1);
		$(prereqs.split(',')).each(function () {
			var prereqInputId = baseInputId + this.toString();
			var isPrereqChecked = $("#" + prereqInputId).is(':checked');
			if (isPrereqChecked == false) {
				$("#" + prereqInputId).prop('checked', true);
				var element = $("#" + prereqInputId)[0];
				if (element) {
					element.onclick();
					return;
				}

				isPrereqChecked = true;

				var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=updateRoleFunctionPermission';
				var ajaxQueryString =
					'inputID=' + encodeURIComponent(prereqInputId) +
					'&isChecked=' + encodeURIComponent(isPrereqChecked);
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
					success: togglePermissionSuccess,
					error: errorHandler
				});

				if (promiseChain) {
					return returnedJqXHR;
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

function toggleDependentPermissions(inputId, dependents, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var baseInputId = inputId.substr(0, inputId.lastIndexOf('_') + 1);
		$(dependents.split(',')).each(function () {
			var dependentInputId = baseInputId + this.toString();
			var isDependentChecked = $("#" + dependentInputId).is(':checked');
			if (isDependentChecked == true) {
				$("#" + dependentInputId).prop('checked', false);
				var element = $("#" + dependentInputId)[0];
				if (element) {
					element.onclick();
					return;
				}

				isDependentChecked = false;

				var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=updateRoleFunctionPermission';
				var ajaxQueryString =
					'inputID=' + encodeURIComponent(dependentInputId) +
					'&isChecked=' + encodeURIComponent(isDependentChecked);
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
					success: togglePermissionSuccess,
					error: errorHandler
				});

				if (promiseChain) {
					return returnedJqXHR;
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

function ddlContactChanged()
{
	var contact_id = $("#ddlContact").val();
	if (contact_id == 0) {
		$('input[name="newContactPermissionCheckbox"]').hide();
	} else {
		$('input[name="newContactPermissionCheckbox"]').show();
	}
}

function toggleAllCheckboxesInRowCus(element)
{
	var toggleAllChecked = $(element).prop('checked');
	var arrCheckboxes = $(element).closest('tr').find('input[type=checkbox]');
	var arrInputIds = [];
	var contact_id = $("#ddlContact").val();
	var csvInputIds=''
	$.each(arrCheckboxes, function(i) {
		var checked = $(this).prop('checked');
		if (checked != toggleAllChecked) {
			$(this).prop('checked', toggleAllChecked);
			csvInputIds=this.id;
			csvInputIds = csvInputIds.replace('_X_','_' + contact_id.toString() + '_');
			arrInputIds.push(csvInputIds);
		}
	});
	if (arrInputIds.length > 0) {
		var csvInputIds = arrInputIds.join(',');
			toggleAllPermissionsInRowCus(csvInputIds, toggleAllChecked);
		//alert(csvInputIds+'=='+toggleAllChecked);
	}
}
function toggleAllPermissionsInRowCus(csvInputIds, isChecked, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;
		
		var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=updateRoleFunctionPermission';
		
		var ajaxQueryString =
			'csvInputIds=' + encodeURIComponent(csvInputIds) +
			'&isChecked=' + encodeURIComponent(isChecked);
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
			success: newContactPermissionClickedSuccess,
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

function newContactPermissionClicked(inputId, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		// InputID = user_company_id _X_ software_module_id _ project_id _ role_id _ software_module_function_id
		var isChecked = $("#" + inputId).is(':checked');
		//alert(isChecked);

		var contact_id = $("#ddlContact").val();
		if (contact_id != 0) {
			inputId = inputId.replace('_X_','_' + contact_id.toString() + '_');

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=updateRoleFunctionPermission';
			var ajaxQueryString =
				'inputID=' + encodeURIComponent(inputId) +
				'&isChecked=' + encodeURIComponent(isChecked);
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
				success: newContactPermissionClickedSuccess,
				error: errorHandler
			});

			if (promiseChain) {
				return returnedJqXHR;
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

function newContactPermissionClickedSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var elementId = json.elementId;
		var project_id = json.project_id;
		var contact_id = json.contact_id;
		var role_id = json.role_id;
		var software_module_id = json.software_module_id;
		var software_module_function_id = json.software_module_function_id;
		var customSuccessMessage = json.customSuccessMessage;

		elementId = 'td_' + elementId;

		messageAlert(customSuccessMessage, 'successMessage');
		softwareModuleChanged();

		//messageAlert(messageText, 'successMessage', 'successMessageLabel', elementId);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function removeContactFromModule(contact_id, csvSoftwareModuleFunctionIds, project_id, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=removeContactFromFunctions';
		var ajaxQueryString =
			'contact_id=' + encodeURIComponent(contact_id) +
			'&csvSoftwareModuleFunctionIds=' + encodeURIComponent(csvSoftwareModuleFunctionIds) +
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
			success: removeContactFromFunctionsSuccess,
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

function removeContactFromFunctionsSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var elementId = json.elementId;
		var project_id = json.project_id;
		var contact_id = json.contact_id;
		var csvSoftwareModuleFunctionIds = json.csvSoftwareModuleFunctionIds;
		var customSuccessMessage = json.customSuccessMessage;

		messageAlert(customSuccessMessage, 'successMessage');

		$("#" + elementId).hide();

		// Reload Contacts Permission Matrix
		//var project_id = $("#project_id").val();

		var software_module_id = $("#ddl_software_module_id").val();
		var ary = software_module_id.split('_');
		software_module_id = ary[0];
		if($('#unique_team_mem').length)
		{
			team_category='1';
		}else
		{
			team_category='0';
		}
		loadPermissionsAssignmentsByRole(software_module_id, project_id,team_category);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function resetDefaultPermissions(options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var answer = confirm('Are you sure you want to reset this module\'s permissions to the system defaults?');
		if (answer) {
			var project_id = $("#project_id").val();

			// <option> value is in the format: {software_module_id}_{project_specific_flag}
			var ddl_software_module_id = $("#ddl_software_module_id").val();
			var arrTemp = ddl_software_module_id.split('_');
			var software_module_id = arrTemp[0];
			var project_specific_flag = arrTemp[1];

			var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=resetToDefaultPermissions';
			var ajaxQueryString =
				'project_id=' + encodeURIComponent(project_id) +
				'&software_module_id=' + encodeURIComponent(software_module_id) +
				'&project_specific_flag=' + encodeURIComponent(project_specific_flag);
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
				success: resetDefaultPermissionsSuccess,
				error: errorHandler
			});

			if (promiseChain) {
				return returnedJqXHR;
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

function resetDefaultPermissionsSuccess(data, textStatus, jqXHR)
{
	try {

		softwareModuleChanged();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function showAdHocRow()
{
	$("#addHocRow").show();
}

function showContactsRoles(contact_id)
{
	$(".contact_" + contact_id).toggleClass('hidden');
}

function toggleAllCheckboxesInRow(element)
{
	var toggleAllChecked = $(element).prop('checked');
	var arrCheckboxes = $(element).closest('tr').find('input[type=checkbox]');
	var arrInputIds = [];
	$.each(arrCheckboxes, function(i) {
		var checked = $(this).prop('checked');
		if (checked != toggleAllChecked) {
			$(this).prop('checked', toggleAllChecked);
			arrInputIds.push(this.id);
		}
	});
	if (arrInputIds.length > 0) {
		var csvInputIds = arrInputIds.join(',');
		toggleAllPermissionsInRow(csvInputIds, toggleAllChecked);
	}
}

function toggleAllPermissionsInRow(csvInputIds, isChecked, options)
{
	try {

		// If the options object was not passed as an argument, create it here.
		var options = options || {};
		var promiseChain = options.promiseChain;

		var ajaxHandler = window.ajaxUrlPrefix + 'modules-permissions-ajax.php?method=updateRoleFunctionPermission';
		var ajaxQueryString =
			'csvInputIds=' + encodeURIComponent(csvInputIds) +
			'&isChecked=' + encodeURIComponent(isChecked);
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
			success: toggleAllPermissionsInRowSuccess,
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

function toggleAllPermissionsInRowSuccess(data, textStatus, jqXHR)
{
	try {

		var json = data;

		var elementId = json.elementId;
		var project_id = json.project_id;
		var contact_id = json.contact_id;
		var role_id = json.role_id;
		var software_module_id = json.software_module_id;
		var software_module_function_id = json.software_module_function_id;
		var customSuccessMessage = json.customSuccessMessage;

		elementId = 'td_' + elementId;

		messageAlert(customSuccessMessage, 'successMessage');

		// Reload Contacts Permission Matrix
		//var software_module_id = $("#ddl_software_module_id").val();
		//var project_id = $("#project_id").val();
		//var ary = software_module_id.split('_');
		//software_module_id = ary[0];
		if($('#unique_team_mem').length)
		{
			team_category='1';
		}else
		{
			team_category='0';
		}

		loadPermissionsAssignmentsByRole(software_module_id, project_id,team_category);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleFilterByRecommendedRoles()
{
	$('tr.nonRecommendedRole').toggleClass('hidden');
}

function tabClicked(element, tab)
{
	try {

		
		var options = options || {};
		var promiseChain = options.promiseChain;		

		$("#activeTab").val(tab);	

		var tabName = 'team';
		if (tab == 1) {
			var tabName = 'team';
		}else if (tab == 2) {
			var tabName = 'subcontractor';
		}else{
			var tabName = 'bidder';
		}

		loadProjectContactList('company ASC, first_name ASC, last_name ASC', '',tabName);

		if (element) {
			$(".tab").removeClass('activeTabGreen');
			$(element).addClass('activeTabGreen');
			activeTab = tab;
		}

		UrlVars.set('tab', tab);

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

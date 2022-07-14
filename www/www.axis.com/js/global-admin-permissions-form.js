$(function() {
	softwareModuleChanged();
});

function softwareModuleChanged()
{
	var software_module_id = $("#ddl_software_module_id").val();
	var project_id = $("#project_id").val();
	var ary = software_module_id.split('_');
	software_module_id = ary[0];
	if (ary[1] == 'Y') {
		$("#project_id").show();
	} else {
		project_id = 0;
		$("#project_id").hide();
	}
	loadPermissionDetails(software_module_id, project_id);
}

function loadPermissionDetails(software_module_id, project_id)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'global-admin-permissions-ajax-details.php?software_module_id=' + software_module_id;
		var ajaxQueryString =
			'project_id=' + project_id;
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divPermissionsMatrix").load(ajaxUrl);
		//$("#divPermissionsMatrix").load("/global-admin-permissions-ajax-details.php?software_module_id=" + software_module_id + "&project_id=" + project_id);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function toggleSMFFlag(inputID)
{
	try {

		// InputID = software_module_function_id _ softwareModuleFunctionFlag _ softwareModuleFunctionFlagValue
		var isChecked = $("#" + inputID).is(':checked');

		var ajaxHandler = window.ajaxUrlPrefix + 'global-admin-permissions-ajax.php?method=updateSMFFlag';
		var ajaxQueryString =
			'inputID=' + encodeURIComponent(inputID) +
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

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function togglePermission(inputID)
{
	try {

		// InputID = user_company_id _ contact_id _ software_module_id _ project_id _ role_id _ software_module_function_id
		var isChecked = $("#" + inputID).is(':checked');

		var ajaxHandler = window.ajaxUrlPrefix + 'global-admin-permissions-ajax.php?method=updateRoleFunctionPermission';
		var ajaxQueryString =
			'inputID=' + encodeURIComponent(inputID) +
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

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function togglePermissionSuccess(response, textStatus, jqXHR)
{
	try {

		var ary = response.split('|');
		var elementId = 'td_' + ary[0];
		var messageText = ary[1];
		messageAlert(messageText, 'successMessage', 'successMessageLabel', elementId);

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
		$("input[name='newContactPermissionCheckbox']").hide();
	} else {
		$("input[name='newContactPermissionCheckbox']").show();
	}
}

function newContactPermissionClicked(inputID)
{
	try {

		// InputID = user_company_id _X_ software_module_id _ project_id _ role_id _ software_module_function_id
		var isChecked = $("#" + inputID).is(':checked');

		var contact_id = $("#ddlContact").val();
		if (contact_id != 0) {
			inputID = inputID.replace('_X_','_' + contact_id.toString() + '_')

			var ajaxHandler = window.ajaxUrlPrefix + 'global-admin-permissions-ajax.php?method=updateRoleFunctionPermission';
			var ajaxQueryString =
				'inputID=' + encodeURIComponent(inputID) +
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
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function newContactPermissionClickedSuccess(response, textStatus, jqXHR)
{
	var ary = response.split('|');
	var elementId = 'td_' + ary[0];
	var messageText = ary[1];
	softwareModuleChanged();
    messageAlert(messageText, 'successMessage', 'successMessageLabel', elementId);
}

function removeContactFromModule(contact_id, csvSoftwareModuleFunctionIds)
{
	try {

		var ajaxHandler = window.ajaxUrlPrefix + 'global-admin-permissions-ajax.php?method=removeContactFromFunctions';
		var ajaxQueryString =
			'contact_id=' + encodeURIComponent(contact_id) +
			'&csvSoftwareModuleFunctionIds=' + encodeURIComponent(csvSoftwareModuleFunctionIds);
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

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function removeContactFromFunctionsSuccess(response, textStatus, jqXHR)
{
	try {

		var ary = response.split('|');
		var elementId = ary[0];
		var messageText = ary[1];
		messageAlert(messageText, 'successMessage', 'successMessageLabel', elementId);
		$("#" + elementId).hide();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function resetDefaultPermissions()
{
	try {

		var answer = confirm('Are you sure you want to reset this module\'s permissions to the system defaults?');
		if (answer) {
			var project_id = $("#project_id").val();

			// <option> value is in the format: {software_module_id}_{project_specific_flag}
			var ddl_software_module_id = $("#ddl_software_module_id").val();
			var arrTemp = ddl_software_module_id.split('_');
			var software_module_id = arrTemp[0];
			var project_specific_flag = arrTemp[1];

			var ajaxHandler = window.ajaxUrlPrefix + 'global-admin-permissions-ajax.php?method=resetToDefaultPermissions';
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
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function resetDefaultPermissionsSuccess(response, textStatus, jqXHR)
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

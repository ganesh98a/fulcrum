$(function() {

	var divProjectContactListLength = $("#divProjectContactList").length;
	if (divProjectContactListLength) {
		// loadProjectTeamMembers('company ASC, first_name ASC, last_name ASC', '');
		//To list the project member with roles assigned
		loadProjectContactList('company ASC, first_name ASC, last_name ASC', '');
	}

	initializeAutoHintFields();
});

var tabName,tabId;
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

function loadProjectTeamMembers(newSortBy, previousSortBy)
{
	try {

		var project_id = '';
		if ($("#currentlySelectedProjectId").length) {
			project_id = $("#currentlySelectedProjectId").val();
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=loadProjectTeamMembers';
		var ajaxQueryString =
			'newSort=' + encodeURIComponent(newSortBy) +
			'&prevSort=' + encodeURIComponent(previousSortBy) +
			'&project_id=' + encodeURIComponent(project_id);
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;

		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}

		$("#divProjectContactList").load(ajaxUrl);

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function loadProjectContactList(newSortBy, previousSortBy,tabNameclick)
{
	try {		

		var project_id = '';
		if ($("#currentlySelectedProjectId").length) {
			project_id = $("#currentlySelectedProjectId").val();
		}

		getTabId();

		if (tabNameclick) {
			tabName = tabNameclick;
		}

		if (tabName == 'all') {
			var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=loadProjectContactList';
		}else if (tabName == 'team') {
			var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=loadProjectContactListforteam';
		}else if (tabName == 'subcontractor') {
			var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=loadProjectContactListforsubcontractor';
		}else{
			var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=loadProjectContactListforbidder';
		}
		
		var ajaxQueryString =
			'newSort=' + encodeURIComponent(newSortBy) +
			'&prevSort=' + encodeURIComponent(previousSortBy) +
			'&project_id=' + encodeURIComponent(project_id) +
			'&tabName=' + encodeURIComponent(tabName);
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
			success: loadProjectContactListSuccess,
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

function loadProjectContactListSuccess(data, textStatus, jqXHR)
{
	$("#divProjectContactList").html(data);
	$('[rel=tooltip]').tooltip({
		placement: 'right'
	});
}

function searchContactSelected_teamManagement(element, contact_id, company, contactName, contactEmail)
{
	try {

		contact_id = $.trim(contact_id);
		company = $.trim(company);
		contactName = $.trim(contactName);
		contactEmail = $.trim(contactEmail);

		var project_id = '';
		if ($("#currentlySelectedProjectId").length) {
			project_id = $("#currentlySelectedProjectId").val();
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=addContactToProject';
		var ajaxQueryString =
			'contact_id=' + encodeURIComponent(contact_id) +
			'&project_id=' + encodeURIComponent(project_id) +
			'&tabName=' + encodeURIComponent(tabName);
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
			success: projectListChangedSuccess,
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

function projectListChangedSuccess(data, textStatus, jqXHR)
{
	try {

		var sortBy = $("#hiddenSortBy").val();
		getTabId();		

		loadProjectContactList(sortBy,'',tabName);

		if ($("#ddl_software_module_id").length && $("#project_id").length) {
		    //Reload permissionContacts
			var software_module_id = $("#ddl_software_module_id").val();
			var project_id = $("#project_id").val();
			var ary = software_module_id.split('_');
			software_module_id = ary[0];
			loadPermissionsAssignmentsByRole(software_module_id, project_id);
		}
		projectpermissionlist();

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

function removeContactFromProject(contact_id)
{
	try {

		contact_id = $.trim(contact_id);
		var project_id = '';
		if ($("#currentlySelectedProjectId").length) {
			project_id = $("#currentlySelectedProjectId").val();
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=removeContactFromProject';
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
			success: projectListChangedSuccess,
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

function removeRoleFromContactOnProject(contact_id, role_id)
{
	try {

		contact_id = $.trim(contact_id);
		role_id = $.trim(role_id);
		var project_id = '';
		if ($("#currentlySelectedProjectId").length) {
			project_id = $("#currentlySelectedProjectId").val();
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=removeRoleFromContactOnProject';
		var ajaxQueryString =
			'contact_id=' + encodeURIComponent(contact_id) +
			'&role_id=' + encodeURIComponent(role_id) +
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
			success: projectListChangedSuccess,
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

function removeRoleFromContactOnProjectHavingTab(contact_id, role_id)
{
	try {

		contact_id = $.trim(contact_id);
		role_id = $.trim(role_id);
		var project_id = '';
		if ($("#currentlySelectedProjectId").length) {
			project_id = $("#currentlySelectedProjectId").val();
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=removeRoleFromContactOnProjectHavingTab';
		var ajaxQueryString =
			'contact_id=' + encodeURIComponent(contact_id) +
			'&role_id=' + encodeURIComponent(role_id) +
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
			success: projectListChangedSuccess,
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

function addRoleToContact(contact_id)
{
	try {

		var role_id = $("#ddlRole_" + contact_id).val();
		if (role_id > 0) {
			var project_id = '';
			if ($("#currentlySelectedProjectId").length) {
				project_id = $("#currentlySelectedProjectId").val();
			}
			var ajaxHandler = window.ajaxUrlPrefix + 'admin-projects-team-management-ajax.php?method=addRoleToContactOnProject';
			var ajaxQueryString =
				'contact_id=' + encodeURIComponent(contact_id) +
				'&role_id=' + encodeURIComponent(role_id) +
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
				success: projectListChangedSuccess,
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

	projectListChangedSuccess(data, textStatus, jqXHR);
}

function tabClickedteam(element, tab)
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

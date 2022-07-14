/*ready function*/
$( document ).ready(function() {

// var userRole = $('#userRole').val();
// var software_module_id = $('#ddl_software_module_id').val();
// var res;
// if(userRole=="global_admin")
// {
// 	res= 'Y';
// }else
// {
// 	res= 'N';
// }
projectpermissionlist();

});


//To list the roles and permission based on the letters
function projectpermissionlist(role)
{
	
	var software_module_id = $('#ddl_software_module_id').val();
	var ary = software_module_id.split('_');
	letter= ary[0];
	
		$.each($(".perseleted"), function(){ 
			role = this.id;
			if($('#'+role).hasClass('perseleted'))
			{
				role = role.replace("per", "");
			}

		});
	// //to filter the alphabetic rolewise
	if(role==undefined ||role=="undefined" || role=="all")
	{
		role ="";
	}else
	{
		$("#per"+role).addClass('perseleted');
	}

	var specify_flag = $('#specify_sel').val();
	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=projectspecificpermission';
	var ajaxQueryString =
	'letter=' + letter +
	'&specify_flag='+specify_flag +
	'&role='+role+
	'&responseDataType=json';
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
		success: function(data)
		{
			$("#mainlist").empty().append(data);
			softwareModuleChanged();
			gridforprojectspecific();

		}
	});
}

function showHideprojectRoles()
{
	projectpermissionlist();
}

function filterprojectroles(data)
{
	$('.filrol').removeClass('perseleted');
	$("#per"+data).addClass('perseleted');
	projectpermissionlist(data);
}

//ajax Function for implementation of grid for project specific modules
function gridforprojectspecific()
{
	var software_module_id = $('#ddl_software_module_id').val();
	var ary = software_module_id.split('_');
	var module_id = ary[0];

	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=gridforprojectspecifymodule';
		var ajaxQueryString =
		'softmodid=' + encodeURIComponent(module_id);
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
				$('#PermissionsBasedonContact').empty().append(data);
			},
			error: errorHandler
		});

}

function removeContact(conid)
{
	$('.con_'+conid).remove();
	setTimeout(function(){ gridforprojectspecific(); }, 1000);
	
}


//To select all roles for user category
function userupdateAllRolesforPrjspec(softid,role_id)
{
	var lastroleid = $("#lastroleid").val();
	var isChecked = $("#editrolep-"+softid+"-"+role_id).is(':checked');
	if(isChecked)
	{
	for (i = 1; i <= lastroleid; i++) {
	if(i==1 || i==2 || i==3) //for ga, admin, user it should not select
	{
		continue;
	}else
	{
		var element = $("#editrolep-" + softid+'-'+i);
		if (element) {
			var elecheck = element.is(':checked');
			if(!elecheck)
			{
				element.click();
			}

			
		}
	}
	} 
	}
}

//Edit option for role and permission
function toggleRoleprojectspec(inputId,prereqs, dependents,role_id)
{
	
	try {
		// InputID = software_module_function id , role_id 
		var isChecked = $("#" + inputId).is(':checked');
		var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=updateprojectspecificRoles';
		var ajaxQueryString =
		'inputId=' + encodeURIComponent(inputId) +
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
			success: function(){
				if (isChecked == true) {
					messageAlert('Permission Applied Successfully','successMessage');
				}else
				{
					messageAlert('Permission Removed Successfully','successMessage');
				}
				gridforprojectspecific();
			},
			error: errorHandler
		});

		if (isChecked && prereqs.length > 0) {
			projectspecificRolePrerequisite(prereqs, role_id);
		}

		if (isChecked == false && dependents.length > 0) {
			Dependentprojectspecific(dependents , role_id);
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

	//To enable the view when manage is enabled
function projectspecificRolePrerequisite( prereqs,role_id)
{
	
	try {
		prereqsarr = prereqs.split(',');
		prereqsarr.forEach(function(softid) {
			// editrolep-68-4
		var element = $("#editrolep-"+softid+"-"+role_id);
		if (element) {
			var isChecked = $("#editrolep-"+softid+"-"+role_id).is(':checked');
			if (isChecked == false) {
			element.click();
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
function Dependentprojectspecific( dependents,role_id )
{
	try {
		dependentsarr = dependents.split(',');
		dependentsarr.forEach(function(softid) {
			// editrolep-68-4
		var element = $("#editrolep-"+softid+"-"+role_id);
		if (element) {
			var isChecked = $("#editrolep-"+softid+"-"+role_id).is(':checked');
			if (isChecked == true) {
			element.click();
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

function rarecasemoduleper()
{
	var contact_id = $("#ddlContact").val();
	if (contact_id == 0) {
		$(".contactrarecase").hide();
	} else {
		$(".contactrarecase").show();
	}
}

function togglecontactFunc(element,prereqs, dependents)
{
	
		
		try {
			inputId = element.id;
		// InputID = softfunname-prjspec-contactid
		var isChecked = $("#" + inputId).is(':checked');
		var inarr = inputId.split('-');
		var softmodid  = inarr[1];
		var prjspec  = inarr[2];
		var conid  = inarr[3];
		var contactid;
		if(conid == 'x')
		{
			contactid = $("#ddlContact").val();;
		}else
		{
			contactid =conid;
		}
		var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=Rarecasepermission';
		var ajaxQueryString =
		'prjspec=' + encodeURIComponent(prjspec) +
		'&softmodid=' + encodeURIComponent(softmodid)+
		'&conid=' + encodeURIComponent(contactid)+
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
			success: function(){
				if (isChecked == true) {
					messageAlert('Permission Applied Successfully','successMessage');
				}else
				{
					messageAlert('Permission Removed Successfully','successMessage');
				}
				rarescenarioUpdation(prjspec);
				gridforprojectspecific();
			},
			error: errorHandler
		});

		if (isChecked && prereqs.length > 0) {
			rarePrerequisitePermissions( prereqs,prjspec,conid);
		}

		if (isChecked == false && dependents.length > 0) {
			rareDependentPermissions( dependents,prjspec,conid );
		}

	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}


	//To enable the view when manage is enabled
function rarePrerequisitePermissions( prereqs,prjspec, conid)
{
	
	try {
		prereqsarr = prereqs.split(',');
		prereqsarr.forEach(function(softid) {
			// contact-22-N-x
		var element = $("#contact-"+softid+"-"+prjspec+"-"+conid);
		if (element) {
			var isChecked = $("#contact-"+softid+"-"+prjspec+"-"+conid).is(':checked');
			if (isChecked == false) {
			element.click();
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
function rareDependentPermissions( dependents,prjspec,conid )
{
	try {
		dependentsarr = dependents.split(',');
		dependentsarr.forEach(function(softid) {
			// contact-22-N-x
		var element = $("#contact-"+softid+"-"+prjspec+"-"+conid);
		if (element) {
			var isChecked = $("#contact-"+softid+"-"+prjspec+"-"+conid).is(':checked');
			if (isChecked == true) {
			element.click();
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
//Ajax to update rare case scenario
function rarescenarioUpdation(prjspec)
{
	var software_module_id = $('#ddl_software_module_id').val();
	var ary = software_module_id.split('_');
	softmodid= ary[0];
	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=rarescenariopermissionajax';
		var ajaxQueryString =
		'prjspec=' + encodeURIComponent(prjspec) +
		'&softmodid=' + encodeURIComponent(softmodid);
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
				$('#rarepermission').empty().append(data);
				
			},
			error: errorHandler
		});
}

function showContactsRoles(contact_id)
{
	$(".contact_" + contact_id).toggleClass('hidden');
}

function projectSpecificResetDefaultPermissions() {

	var answer = confirm('Are you sure you want to reset this module\'s permissions to the system defaults?');

	if (answer) {
		var software_module_id = $('#ddl_software_module_id').val();
		var ary = software_module_id.split('_');
		var module_id = ary[0];

		var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=projectSpecificResetDefaultPermissionsAjax';
		var ajaxQueryString =
		'softmodid=' + encodeURIComponent(module_id);
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
				messageAlert('Reset success','successMessage');
				projectpermissionlist();	
			},
			error: errorHandler
		});
	}
}

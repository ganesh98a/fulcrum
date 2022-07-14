/*ready function*/
$( document ).ready(function() {

var userRole = $('#userRole').val();
var software_module_id = $('#ddl_software_module_id').val();
var res;
if(userRole=="global_admin")
{
	res= 'Y';
}else
{
	res= 'N';
}
permissionlist(software_module_id,res);

});

//To show the selected roles
function selected_role()
{
	if($("#role_list option:selected").val() !=undefined)
	{
		$(".roleSet").css('display','');
	}
	var rolarr = [];
	//To add the items
	$.each($("#role_list option:selected"), function(){   
		var role_value = $(this).val();
		var selected_rolevalue=$(this).text();
		var arrselected_roleitem =selected_rolevalue.split('-');
		var selected_roleitem = arrselected_roleitem[0];
		rolarr.push($(this).val());

		var span = '<span id="sprole_'+role_value+'" class="role_head"> <input type="checkbox" name="role_'+role_value+'" id="role_'+role_value+'" class="roles_title" value="'+role_value+'" checked="true">&nbsp;'+selected_roleitem+'&nbsp;</span>';
		var found = $('#sprole_'+role_value).length > 0;
		if (!found) {
			$("#role_items").append(span);
		}
	});
	//To remove the added items
	var rolval;
	var rolvalarr;
	var rolvalid;
	var sear;
	$.each($(".role_head"), function(){ 
		rolvalid = this.id;
		rolvalarr= rolvalid.split('_');
		rolval = rolvalarr[1];
		if(jQuery.inArray(rolval,rolarr) == -1){
			$( "#sprole_"+rolval).remove();
		}
	});

}

//To load the software module functions
function selected_modulerole()
{
	var modarr = [];
	//To add the items
	$.each($("#role_for_software_module option:selected"), function(){ 
		modarr.push($(this).val());

		var role_for_software_module = $(this).val();
		var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=softwarefunctionformodule';
		var ajaxQueryString =
		'module_id=' + encodeURIComponent(role_for_software_module) +
		'&responseDataType=json';
		var ajaxUrl = ajaxHandler + '&' + ajaxQueryString;
		if (window.ajaxUrlDebugMode) {
			var continueDebug = window.confirm(ajaxUrl);
			if (continueDebug != true) {
				return;
			}
		}
		
		var found = $('#softmodules_'+role_for_software_module).length > 0;
		if (!found) {
			var returnedJqXHR = $.ajax({
				url: ajaxHandler,
				data: ajaxQueryString,
				success: function(data)
				{
					if (!found) {
						$("#mod_role").append(data);
					}
				},
				error: errorHandler
			});
		}
	});
	//To remove the added items
	var modval;
	var modvalarr;
	var modvalid;
	var sear;
	$.each($(".softmod"), function(){ 
		modvalid = this.id;
		modvalarr= modvalid.split('_');
		modval = modvalarr[1];
		if(jQuery.inArray(modval,modarr) == -1){
			$( "#softmodules_"+modval).remove();
		}
	});
}

//To save the role and software module functions
function saveRoleAndPermission(allow)
{
	
	var role_list = $("#role_list").val();
	var software_modules = $("#role_for_software_module").val();
	if(role_list ==null)
	{
		messageAlert('Please Select atleast one Role.', 'errorMessage');
		$("#role_list").addClass('redBorderThick');
		return false;
	}else
	{
		$("#role_list").removeClass('redBorderThick');
	}

	if(software_modules ==null)
	{
		messageAlert('Please Select atleast one Modules.', 'errorMessage');
		$("#role_for_software_module").addClass('redBorderThick');
		return false;
	}else
	{
		$("#role_for_software_module").removeClass('redBorderThick');
	}

	$( "#role_list" ).change(function() {
		$("#role_list").removeClass('redBorderThick');		
	});

	$( "#role_for_software_module" ).change(function() {
		$("#role_for_software_module").removeClass('redBorderThick');		
	});

	$(".persave").attr('disabled',true);
	//To get all the role ids
	var attachmentsArr = {};
	var i =0;
	$(".roles_title").each(function(){
		
		var roleId = this.id;
		var rolecheck = $('#'+roleId).is(':checked');
		if(rolecheck)
		{
			var roleval = $(this).val();
			attachmentsArr[i] =  parseInt(roleval);
			i++;
		}
	});
	var role_ids = JSON.stringify(attachmentsArr);

	//To get all the software function ids
	var functionArr = {};
	var j =0;
	$(".softfunction").each(function(){
		var funId = this.id;
		var funcheck = $('#'+funId).is(':checked');
		if(funcheck)
		{
			var funval = $(this).val();
			functionArr[j] =  parseInt(funval);
			j++;
		}
	});
	var function_ids = JSON.stringify(functionArr);

	var allcompany ="N";

	if(allow =='1')
	{
		showSpinner();
		allcompany ="Y";
		callbackinsertroles(role_ids,function_ids,allcompany);
	// //To get the list of the companies
	//  var compy_list  = $("#all_companies").val();

	// $("#dialog-confirm").html("Roles and permission will applied to all GC and it will overwriter the permission set by the admin");
 //    // Define the Dialog and its properties.
 //    $("#dialog-confirm").dialog({
 //    	resizable: false,
 //    	modal: true,
 //    	title: "Confirmation",
 //    	open: function() {
 //    	},
 //    	close: function() {
 //    	},
 //    	buttons: {
 //   			"No": function () {
 //    			$(this).dialog('close');
 //    			allcompany ="N";
 //    			callbackinsertroles(role_ids,function_ids,allcompany,compy_list);
 
 //    		},
 //    		"Yes": function () {
 //    			$(this).dialog('close');
 //    			allcompany ="Y";
 //    			callbackinsertroles(role_ids,function_ids,allcompany,compy_list);
 
 //    		}
 //    	}
 //    });
}else
{
	showSpinner();
	callbackinsertroles(role_ids,function_ids,allcompany);
}
}

//To insert the roles and functions
function callbackinsertroles(role_ids,function_ids,allcompany,compy_list)
{
	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=Insertsoftwarefunctionformodule';
	var ajaxQueryString =
	'role_ids=' + role_ids +'&function_ids=' + function_ids + '&allcompany=' +allcompany+
	'&compy_list=' +compy_list +
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
			hideSpinner();
			$(".persave").removeAttr('disabled');
			showback();
		},
		error: errorHandler
	});

}


//To show the manage role div
function ManageRoles()
{
	$(".manageRole").css('display','block');
	$(".perlist").css('display','none');
	// $("#backrol").css('display','block');
	$(".addpermission").css('display','none');
	//To reset the role and permission
	$('#role_for_software_module').prop('selectedIndex',0);
	$('#role_list').prop('selectedIndex',0);

	$("#role_items").empty().html('');
	$("#mod_role").empty().html('');

	//To deselect the multi select for Roles
	$('#role_list option:selected').removeAttr('selected');
	$('#role_list').prev(".fs-dropdown").find(".fs-options .fs-option").each(function() {
		$(this).removeClass('selected', false);
	});
	$('.fs-label').html('Select options');

	//To deselect the multi select for company
	$('#role_for_software_module option:selected').removeAttr('selected');
	$('#role_for_software_module').prev(".fs-dropdown").find(".fs-options .fs-option").each(function() {
		$(this).removeClass('selected', false);
	});
	$('.fs-label').html('Select options');
	
}

function showback()
{
	$(".manageRole").css('display','none');
	$(".perlist").css('display','block');
	// $("#backrol").css('display','none');
	$(".addpermission").css('display','');
	permissionlist('','');
}

//To create a new Role
function showcreateRoleDialog()
{
	showSpinner();
	var modal = document.getElementById('divCreateRole');
	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=showNewRolesDialog';
	var ajaxQueryString =
	'responseDataType=json';
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
			
			$('#divCreateRole').empty().html(data);
			modal.style.display = "block";
			$("body").addClass('noscroll');
			hideSpinner();			
		},
		error: errorHandler
	});

}


//To close the modal
function permodalClose()
{
	var modal = document.getElementById('divCreateRole');
	modal.style.display = "none";
	$("body").removeClass('noscroll');
}

//To add the role
function createRole()
{
	
	
	var role_name = $("#role_name").val();
	var role_desp = $("#role_desp").val();
	var prj_specfic = $('input[name=prj_specfic]:checked').val();

	$( "#role_name" ).keyup(function() {
		$("#role_name").removeClass('redBorderThick');		
	});
	$( "#role_desp" ).keyup(function() {
		$("#role_desp").removeClass('redBorderThick');		
	});

	if(role_name == "")
	{
		$("#role_name").addClass('redBorderThick');	
		return false;
	}else
	{
		$("#role_name").removeClass('redBorderThick');	
	}

	if(role_desp == "")
	{
		$("#role_desp").addClass('redBorderThick');	
		return false;
	}else
	{
		$("#role_desp").removeClass('redBorderThick');	
	}

	

	$("#rolesave").attr('disabled');
	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=InsertNewRoles';
	var ajaxQueryString =
	'role_name=' + role_name  +'&role_desp='+role_desp+'&prj_specfic='+prj_specfic+
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
			if(data == '1')
			{
				$("#rolesave").removeAttr('disabled');
				messageAlert('Role Already Exist.', 'errorMessage');
				$("#role_name").addClass('redBorderThick');
			}else
			{
				messageAlert('Role Added Successfullly.', 'successMessage');
				permodalClose();
			}
			
		},
		error: errorHandler
	});
}

function filterroles(data)
{
	$('.filrol').removeClass('perseleted');
	$("#per"+data).addClass('perseleted');
	permissionlist('','',data);
}

//To list the roles and permission based on the letters
function permissionlist(software_module_id,res,role)
{
	if(software_module_id=="" || software_module_id==undefined)
	{
		var software_module_id = $('#ddl_software_module_id').val();
	}
	var ary = software_module_id.split('_');
	letter= ary[0];
	
		$.each($(".perseleted"), function(){ 
			role = this.id;
			if($('#'+role).hasClass('perseleted'))
			{
				role = role.replace("per", "");
			}

		});
	//to filter the alphabetic rolewise
	if(role==undefined ||role=="undefined" || role=="all")
	{
		role ="";
	}else
	{
		$("#per"+role).addClass('perseleted');
	}

	var specify_flag = $('#specify_sel').val();
	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=permissionlist';
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
			gridfornonproject();

		}
	});
}


//Edit option for role and permission
function toggleRolePerFunc(inputId,global_flag,prereqs, dependents, role_id)
{
	
	try {
		// InputID = software_module_function id , role_id 
		var isChecked = $("#" + inputId).is(':checked');
		var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=updateRolePerFunc';
		var ajaxQueryString =
		'inputId=' + encodeURIComponent(inputId) +
		'&isChecked=' + encodeURIComponent(isChecked)+
		'&global_flag=' + encodeURIComponent(global_flag);
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
				gridfornonproject();
			},
			error: errorHandler
		});

		if (isChecked && prereqs.length > 0) {
			toggleRolePrerequisitePermissions(global_flag, prereqs, role_id);
		}

		if (isChecked == false && dependents.length > 0) {
			toggleRoleDependentPermissions(global_flag, dependents , role_id);
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
function toggleRolePrerequisitePermissions(global_flag, prereqs, role_id)
{
	
	try {
		prereqsarr = prereqs.split(',');
		prereqsarr.forEach(function(softid) {
		$("#editrolep-"+softid+"-"+role_id).prop('checked', true);
		var isChecked = $("#editrolep-"+softid+"-"+role_id).is(':checked');
		var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=updateRoleprereqsanddependent';
		var ajaxQueryString =
		'software_module_function_id=' + encodeURIComponent(softid) +
		'&RoleId=' + encodeURIComponent(role_id)+
		'&isChecked=' + encodeURIComponent(isChecked)+
		'&global_flag=' + encodeURIComponent(global_flag);
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
			},
			error: errorHandler
		});
	});
		
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}

//To disable the manage when view is disabled
function toggleRoleDependentPermissions(global_flag, dependents , role_id)
{
	
	try {

		depentarr = dependents.split(',');
		depentarr.forEach(function(softid) {
		$("#editrolep-"+softid+"-"+role_id).prop('checked', false);
		var isChecked = $("#editrolep-"+softid+"-"+role_id).is(':checked');
		var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=updateRoleprereqsanddependent';
		var ajaxQueryString =
		'software_module_function_id=' + encodeURIComponent(softid) +
		'&RoleId=' + encodeURIComponent(role_id)+
		'&isChecked=' + encodeURIComponent(isChecked)+
		'&global_flag=' + encodeURIComponent(global_flag);
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
			},
			error: errorHandler
		});
		});
		
	} catch(error) {

		if (window.showJSExceptions) {
			var errorMessage = error.message;
			alert('Exception Thrown: ' + errorMessage);
			return;
		}

	}
}
//Hide and show project specify and not project specific roles

function showHideprojectRoles()
{
	permissionlist();
}

//To select all roles for user category
function userupdateAllRoles(softid,role_id)
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
function rarecasemoduleper()
{
	var contact_id = $("#ddlContact").val();
	if (contact_id == 0) {
		$(".contactrarecase").hide();
	} else {
		$(".contactrarecase").show();
	}
}

//ajax Function for implementation of grid for project non specific modules
function gridfornonproject()
{
	var software_module_id = $('#ddl_software_module_id').val();
	var ary = software_module_id.split('_');
	var module_id = ary[0];

	var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=gridfornonprojectspecify';
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
	 setTimeout(function(){ gridfornonproject(); }, 1000);
	
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
				gridfornonproject();
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


function projectNonSpecificResetDefaultPermissions() {
	var answer = confirm('Are you sure you want to reset this module\'s permissions to the system defaults?');

	if (answer) {
		var software_module_id = $('#ddl_software_module_id').val();
		var ary = software_module_id.split('_');
		var module_id = ary[0];

		var ajaxHandler = window.ajaxUrlPrefix + 'app/controllers/permission_ajax.php?method=projectNonSpecificResetDefaultPermissionsAjax';
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
				permissionlist();
			},
			error: errorHandler
		});
	}
}

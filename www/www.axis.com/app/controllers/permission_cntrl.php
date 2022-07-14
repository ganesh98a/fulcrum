<?php

require_once('../models/permission_mdl.php');
require_once('../templates/dropdown_tmp.php');
require_once('lib/common/Contact.php');

// SESSSION VARIABLES
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$primary_contact_id = $session->getPrimaryContactId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlySelectedProjectId = $session->getCurrentlySelectedProjectId();

function SoftwaremoduleforpermissionASList($database)
{
	$session = Zend_Registry::get('session');
	$userRole = $session->getUserRole();
	if($userRole == "global_admin")
	{
	    $arr_module_result = SoftwareModulesListforgroup($database);
	}else {
		$arr_module_result = SoftwareModulesListprojectspecific($database,'N');
	}
	

	$listId="ddl_software_module_id";
	$listClass="";
	$listjs="onchange=permissionlist(this.value,'Y')";
	$liststyle="";
	$res_drop=selectGroupDropDown($database,$listId,$listClass,$listjs,$liststyle,"",$arr_module_result,"");
	$permissionTableTbody = <<<END_PER_TABLE_TBODY
	$res_drop
END_PER_TABLE_TBODY;

	return $res_drop;
}

function RolesASList($database)
{
	$arr_module_result = RoleList($database);
	
	$listId="role_list";
	$listClass="demo mutipleselect";
	$listjs="onchange='selected_role()'";
	$liststyle="";
	$listDefault="Select A Role";
	$listselected = "";
	$listMultiple=true;

	$res_drop=selectGroupDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$arr_module_result,$listselected,$listMultiple);
	$permissionTableTbody = <<<END_PER_TABLE_TBODY
	$res_drop
END_PER_TABLE_TBODY;

	return $res_drop;

}

function SoftwaremoduleforRoleASList($database)
{
	$prj_flag = 0;
	$arr_module_result = SoftwareModulesListforgroup($database);
	
	$listId="role_for_software_module";
	$listClass="demo mutipleselect";
	$listjs="onchange='selected_modulerole()'";
	$liststyle="";
	$listDefault="Select A Module";
	$listselected = "";
	$listMultiple=true;

	$res_drop=selectGroupDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$arr_module_result,$listselected,$listMultiple);
	$permissionTableTbody = <<<END_PER_TABLE_TBODY
	$res_drop
END_PER_TABLE_TBODY;

	return $res_drop;
}

//To display the roles in alphabetic order
function roleAlphabetic($database,$show)
{
	if ($show == 'Y') {
		$selected = 'selected';
	}else{
		$selected = '';
	}

	$alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	
	$permissionTableTbody = <<<END_PER_TABLE_TBODY
	<span id="perall" class="filrol" onclick="filterroles('all')">Role(s)</span>
	<span class="filrol">
		<select id="specify_sel" class="addpermission" onchange="showHideprojectRoles()" style="margin-left:5px;margin-right:5px;font-size:14px;">
			<option value='all'>Both roles</option>
			<option value='Y'>Proj Spec</option>
			<option value='N' $selected>Not Proj Spec</option>
		</select>
	</span>
END_PER_TABLE_TBODY;

	foreach ($alpha as  $Alpvalue) {
	$permissionTableTbody .= <<<END_PER_TABLE_TBODY
	<span id="per$Alpvalue" class="filrol" onclick="filterroles('$Alpvalue')">$Alpvalue</span>
END_PER_TABLE_TBODY;

}
	
return $permissionTableTbody;

}

function FetchsoftwaremoduleFucntion($database,$module_id)
{
	$mod_id = $module_id;
	$arr_module_result = SoftwareModulesfunctionformodule($database,$mod_id);
	$module_name = $arr_module_result['module_name'];
	$function_arr = $arr_module_result['function_arr'];
	$functionTableTbody .= <<<END_PER_TABLE_TBODY
		<div id="softmodules_$mod_id" class="block-section m-b-0 softmod" style="padding-right: 15px;width:98%;"><p class="main-head" style="font-weight:normal;">$module_name</p><div class="panel m-t-10">
END_PER_TABLE_TBODY;

	foreach ($function_arr as $key => $funcvalue) {
		$function_id = $funcvalue['function_id'];
		$funlabel = $funcvalue['label'];
		$functionTableTbody .= <<<END_PER_TABLE_TBODY
		<span class="sfunction_$function_id"> <input type="checkbox" name="fucntion_$function_id" id="fucntion_$function_id" class="softfunction" value="$function_id" checked="true">&nbsp;$funlabel&nbsp;</span>
END_PER_TABLE_TBODY;
	}

	$functionTableTbody .= <<<END_PER_TABLE_TBODY
		</div></div>
END_PER_TABLE_TBODY;
	if(empty($function_arr))
	{
		$functionTableTbody ="";
	}
	return $functionTableTbody;

}

//To list all companies
function listAllCompany($database)
{
	 $arrcompany =  ListofallCompanies($database);
	 $listId="all_companies";
	 $listClass="demo mutipleselect";
	 $listjs="";
	 $liststyle="width:250px;";
	 $listDefault="Select companies";
	 $listselected = "";
	 $listMultiple=true;

	 $res_drop=selectDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$arrcompany,$listselected,$listMultiple);
	 $permissionTableTbody = <<<END_PER_TABLE_TBODY
		$res_drop
END_PER_TABLE_TBODY;

	return $res_drop;


}

//To load create role dialog
function loadNewRolesDialog($database)
{
	$modalContent=<<<modalContent
	<div class="modal-content">
    <div class="modal-header">
      <span class="close" onclick="permodalClose();">&times;</span>
      <h3>Create Role</h3>
    </div>
    <div class="modal-body">
    <div class="tableview" >
     <table class="UserViews" width="100%" cellpadding="10" cellspacing="10">
     <thead>
     <tr>
     <td>Role Name</td>
     <td><input type="text" id="role_name" name="role_name" class="" value="" style="width:98%"></td>
     </tr>
     <tr>
     <td>Role Description</td>
     <td><input type="text" id="role_desp" name="role_desp" class="" value="" style="width:98%"></td>
     </tr>
     <tr>
     <td>Project Specific</td>
     <td><input type="radio" id="prj_specfic" name="prj_specfic" class="" value="Y"> Yes
     <input type="radio" id="prj_specfic" name="prj_specfic" class="" value="N" checked> No
     </td>
     </tr>
     </thead>
     </table>
     </div>
    </div>
    <div class="modal-footer">
    <table width="100%"><tr><td align="right">
     	   <button class="punchbtnClose" id="rolesave" onclick="createRole();">Add Role</button>
    	   <button class="punchbtnClose" onclick="permodalClose();">Close</button>
    	   </td></tr>
    	   </table>
    </div>
  </div>
modalContent;
echo $modalContent;

}

//to get all the modules associated with roles
// function rolesAssociatedWithPermission($database,$user_company_id,$userRole,$filter='all',$role_spec="",$rolefilter="")
// {

// 	if($userRole =="global_admin")
// 	{
// 		$non_exist_comp  ='1';
// 		$is_global = 'Y';
// 	}else
// 	{
// 		$non_exist_comp  = $user_company_id;
// 		$is_global = 'N';
// 	}
	
// 	$permisionarr = listRoleswithPermission($database,$non_exist_comp,$filter);
// 	$rolesarr = getAllRoles($database,'all',$role_spec,$rolefilter);
// 	$roleidarr = getAllRoles($database,'id',$role_spec,$rolefilter);

// 	$permissionTbody = <<<END_PER_TABLE_TBODY
// 	<div class="nonProSpecTable">
// 		<div class="nonProSpecTableOne">
// 			<table style="width: 100%;border-right: none;" border='1' class="table-theme">
// 				<thead>
// 					<tr>
// 						<th style="border-right: none;">MODULE FUNCTIONs</th>
// 					</tr>
// 				</thead>
// END_PER_TABLE_TBODY;

// 	$prj_head="";
// 	foreach ($permisionarr as $key1 => $pervalue) {
// 		$software_mod_label = $pervalue['sm__software_module_label'];
// 		$function_label =$pervalue['sf__software_module_function_label'];
// 		$proj_spec =$pervalue['sm__project_specific_flag'];
// 		$software_mod_funid = $pervalue['sf__software_module_function_id'];
// 		$arrlinkedrole_id = rolesToSoftwareModules($database,$non_exist_comp,$software_mod_funid);

// 		if($proj_spec == 'N'){
// 			$proj_specTag =$software_mod_label." - Not Project Specific";
// 		}else{
// 			$proj_specTag =$software_mod_label." - Project Specific";
// 		}
// 		if($prj_head != $proj_specTag){
// 			$prj_head = $proj_specTag;
// 		}else{
// 			$proj_specTag ="";
// 		}
// 		$permissionTbody .= <<<END_PER_TABLE_TBODY
// 		<tr>
// 			<td style="border-right: none;">$function_label</td>
// 		</tr>
// END_PER_TABLE_TBODY;
// 	}

// 	$permissionTbody .= <<<END_PER_TABLE_TBODY
// 			</table>
// 		</div>
// 		<div class="nonProSpecTableTwo">
// 			<table style="width: 100%;" border='1' class="table-theme">
// 				<thead>
// 					<tr>
// END_PER_TABLE_TBODY;

// 	//To list all the role names
// 	foreach ($rolesarr as $key => $rolevalue) {
// 		$role_name = $rolevalue['role'];
// 		$role_pst = $rolevalue['project_specific_flag'];
// 		if($role_pst == 'Y')
// 		{
// 			$prclass = "pspecify";
// 		}else
// 		{
// 			$prclass = "nonspecify";
// 		}

// 		$permissionTbody .= <<<END_PER_TABLE_TBODY
// 		<th class="$prclass">$role_name</th>
// END_PER_TABLE_TBODY;
// 	}

// 	$permissionTbody .= <<<END_PER_TABLE_TBODY
// 	</tr>
// 	</thead>
// 	<tbody>
// END_PER_TABLE_TBODY;
	
// 	foreach ($permisionarr as $key1 => $pervalue) {		
// 		$software_mod_funid = $pervalue['sf__software_module_function_id'];
// 		$arrlinkedrole_id = rolesToSoftwareModules($database,$non_exist_comp,$software_mod_funid);

// 		//To load the prerequist of software function
// 		$prerequistlist = loadPrerequisitesForPermission($database,$software_mod_funid);

// 		//To load the dependencies 
// 		$dependencylist = loadDependenciesForPermission($database,$software_mod_funid);

// 		$permissionTbody .= <<<END_PER_TABLE_TBODY
// 		<tr>
// END_PER_TABLE_TBODY;

// 		foreach ($rolesarr as $keyr => $roleid) {
// 			if((isset($arrlinkedrole_id[$keyr]))&&($arrlinkedrole_id[$keyr] == $keyr))
// 			{
// 				$pertag = "checked";
// 			}else
// 			{
// 				$pertag = "";
// 			}
// 			//For user role it shouls select every other role
// 			if($keyr == AXIS_USER_ROLE_ID_USER)
// 			{
// 				$userupdatefunction = ",userupdateAllRoles(&apos;$software_mod_funid&apos;, &apos;$keyr&apos;)";
// 			}else
// 			{
// 				$userupdatefunction ="";
// 			}

// 			//id contains software_module_function id , role_id
// 			$permissionTbody .= <<<END_PER_TABLE_TBODY
// 			<td class="textAlignCenter gaVerPerTd">
// 			<label class="control control--checkbox col-sm-12 p-0 m-b-15">
// 			<input id="editrolep-$software_mod_funid-$keyr" type="checkbox" onclick="toggleRolePerFunc(this.id,'$is_global','$prerequistlist','$dependencylist','$keyr') $userupdatefunction;" $pertag>
// 			<div class="control__indicator"></div>
// 			 </label>
// 			</td>
// END_PER_TABLE_TBODY;
// 		}

// 		$permissionTbody .= <<<END_PER_TABLE_TBODY
// 		</tr>
// END_PER_TABLE_TBODY;
// 	}


// 	$permissionTbody .= <<<END_PER_TABLE_TBODY
// 	</tbody>
// 	</table>
// 	</div>
// 	</div>
// END_PER_TABLE_TBODY;

// 	return $permissionTbody;

// }

//to get all the modules associated with roles
function rolesAssociatedWithPermission($database,$user_company_id,$userRole,$filter='all',$role_spec="",$rolefilter="")
{

	if($userRole =="global_admin")
	{
		$non_exist_comp  ='1';
		$is_global = 'Y';
	}else
	{
		$non_exist_comp  = $user_company_id;
		$is_global = 'N';
	}
	
	$permisionarr = listRoleswithPermission($database,$non_exist_comp,$filter);
	$rolesarr = getAllRoles($database,'all',$role_spec,$rolefilter);
	$roleidarr = getAllRoles($database,'id',$role_spec,$rolefilter);
	$permissionTbody = '';

	$permissionTbody .= <<<END_PER_TABLE_TBODY
	<table width="100%" border="1" class="table-theme">
		<thead>
			<tr>
				<th>MODULE FUNCTIONs</th>
END_PER_TABLE_TBODY;

	$curcompany='';
	$permissionAbbre = "";
	foreach ($permisionarr as $key1 => $pervalue) {
		$function_arr =$pervalue['sf__software_module_function_abbreviation'];
		$function_label_arr =$pervalue['sf__software_module_function_label_abbreviation'];
		$count = array_count_values(array_column($permisionarr, 'sf__software_module_function_abbreviation'))[$function_arr];
		if ($curcompany <> $function_arr) {
			$curcompany=$function_arr;
			$permissionTbody .= <<<END_PER_TABLE_TBODY
				<th colspan='$count'>$function_arr</th>
END_PER_TABLE_TBODY;
		}
		$permissionAbbre .=<<<END_PER_TABLE_TBODY
		<th>$function_label_arr</th>
END_PER_TABLE_TBODY;

	}

	$permissionTbody .= <<<END_PER_TABLE_TBODY
		</tr>
		<tr>
		<th></th>
		$permissionAbbre
		</tr>
		</thead>
		<tbody>
END_PER_TABLE_TBODY;

foreach ($rolesarr as $key => $rolevalue) {
	$role_name = $rolevalue['role'];
	$role_pst = $rolevalue['project_specific_flag'];
		if($role_pst == 'Y')
		{
			$prclass = "pspecify";
		}else
		{
			$prclass = "nonspecify";
		}
	$permissionTbody .= <<<END_PER_TABLE_TBODY
		<tr><td class="$prclass">$role_name</td>
END_PER_TABLE_TBODY;

foreach ($permisionarr as $key1 => $pervalue) {		
	$software_mod_funid = $pervalue['sf__software_module_function_id'];
	$arrlinkedrole_id = rolesToSoftwareModules($database,$non_exist_comp,$software_mod_funid);
	//To load the prerequist of software function
	$prerequistlist = loadPrerequisitesForPermission($database,$software_mod_funid);
	//To load the dependencies 
	$dependencylist = loadDependenciesForPermission($database,$software_mod_funid);

	if((isset($arrlinkedrole_id[$key]))&&($arrlinkedrole_id[$key] == $key)) {
			$pertag = "checked";
		}else {
			$pertag = "";
		}
		//For user role it shouls select every other role
		if($key == AXIS_USER_ROLE_ID_USER) {
			$userupdatefunction = ",userupdateAllRoles(&apos;$software_mod_funid&apos;, &apos;$key&apos;)";
		}else {
			$userupdatefunction ="";
		}
	//id contains software_module_function id , role_id
	$permissionTbody .= <<<END_PER_TABLE_TBODY
		<td class="textAlignCenter gaVerPerTd">
			<label class="control control--checkbox col-sm-12 p-0 m-b-15">
			<input id="editrolep-$software_mod_funid-$key" type="checkbox" onclick="toggleRolePerFunc(this.id,'$is_global','$prerequistlist','$dependencylist','$key') $userupdatefunction;" $pertag>
			<div class="control__indicator"></div>
			 </label>
			</td>
END_PER_TABLE_TBODY;
}

$permissionTbody .= <<<END_PER_TABLE_TBODY
		</tr>
END_PER_TABLE_TBODY;
}
$permissionTbody .= <<<END_PER_TABLE_TBODY
		</tbody>
		</table>
END_PER_TABLE_TBODY;

return $permissionTbody;

}

//To get all the modules associated with roles For admin
function rolesAssociatedWithPermissionforAdmin($database,$user_company_id,$userRole,$filter='all',$role_spec="",$rolefilter="")
{

	$is_global = 'N';
	$userCanManagepermission  = checkPermissionForAllModuleAndRole($database,'manage_system_permission');
	$userCanViewpermission = checkPermissionForAllModuleAndRole($database,'view_system_permission');
	$session = Zend_Registry::get('session');
	$project_id = $session->getCurrentlySelectedProjectId();
	
	$permisionarr = listRoleswithPermission($database,$user_company_id,$filter);
	$rolesarr = getAllRoles($database,'all',$role_spec,$rolefilter);
	$roleidarr = getAllRoles($database,'id',$role_spec,$rolefilter);
	
	$permissionTbodyadmin = <<<END_PER_TABLE_TBODY
	<div class="nonProSpecTable">
			<table style="width: 100%;" border='1' class="table-theme">
				<thead>
					<tr>
						<th style="border-right: none;">MODULE FUNCTIONs</th>
					
END_PER_TABLE_TBODY;

	$prj_head="";
	$curcompany='';
	$permissionabbreLine = "";
	foreach ($permisionarr as $key1 => $pervalue) {
		$function_arr =$pervalue['sf__software_module_function_abbreviation'];
		$software_mod_label = $pervalue['sm__software_module_label'];
		$function_label =$pervalue['sf__software_module_function_label'];
		$proj_spec =$pervalue['sm__project_specific_flag'];
		$function_label_arr =$pervalue['sf__software_module_function_label_abbreviation'];

		if($proj_spec == 'N')
		{
			$proj_specTag =$software_mod_label;
		}else
		{
			$proj_specTag =$software_mod_label;
			//Prj specify alone getting project_id
			
		}
		if($prj_head != $proj_specTag)
		{
			$prj_head = $proj_specTag;

		}else
		{
			$proj_specTag ="";
		}

		$count = array_count_values(array_column($permisionarr, 'sf__software_module_function_abbreviation'))[$function_arr];
		if ($curcompany <> $function_arr) {
			$curcompany=$function_arr;
			$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
				<th colspan='$count'>$function_arr</th>
END_PER_TABLE_TBODY;
		}
		$permissionabbreLine .= <<<END_PER_TABLE_TBODY
		<th>$function_label_arr</th>
END_PER_TABLE_TBODY;


	}

	$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
		</tr>
		<tr>
		<th></th>
		$permissionabbreLine
		</tr>
		</thead>
		<tbody>
END_PER_TABLE_TBODY;
	//To list all the role names
	foreach ($rolesarr as $key => $rolevalue) {
		if(!empty($userRole) && $userRole =='admin' && $rolevalue['role'] =='Global Admin'){
			continue;
		}
		$role_name = $rolevalue['role'];
		$role_pst = $rolevalue['project_specific_flag'];
		if($role_pst == 'Y')
		{
			$prclass = "pspecify";
		}else
		{
			$prclass = "nonspecify";
		}

		$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
		<tr><td class="$prclass">$role_name</td>
END_PER_TABLE_TBODY;

	
	foreach ($permisionarr as $key1 => $pervalue) {
		$software_mod_funid = $pervalue['sf__software_module_function_id'];
		$arrlinkedrole_id = rolesToSoftwareModules($database,$user_company_id,$software_mod_funid);

		//To load the prerequist of software function
		$prerequistlist = loadPrerequisitesForPermission($database,$software_mod_funid);

		//To load the dependencies 
		$dependencylist = loadDependenciesForPermission($database,$software_mod_funid);


		
			if(!empty($userRole) && $userRole =='admin' && $rolevalue['role'] =='Global Admin'){
				continue;
			}
			if((isset($arrlinkedrole_id[$key]))&&($arrlinkedrole_id[$key] == $key))
			{
				$pertag = "checked";
				$viewper = "Yes"; //For view
			}else
			{
				$pertag = "";
				$viewper = "No"; //For view
			}
			//For user role it shouls select every other role
			if($key == AXIS_USER_ROLE_ID_USER)
			{
				$userupdatefunction = ",userupdateAllRoles(&apos;$software_mod_funid&apos;, &apos;$key&apos;)";
			}else
			{
				$userupdatefunction ="";
			}
			if($userCanManagepermission){
			//id contains software_module_function id , role_id
			$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
			<td class="textAlignCenter">
			<label class="control control--checkbox col-sm-12 p-0 m-b-15">
			<input id="editrolep-$software_mod_funid-$key" type="checkbox" onclick="toggleRolePerFunc(this.id,'$is_global','$prerequistlist','$dependencylist','$key') $userupdatefunction;" $pertag>
			<div class="control__indicator"></div>
			 </label>
			</td>
END_PER_TABLE_TBODY;
			}else
			{
				//id contains software_module_function id , role_id
			$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
			<td class="textAlignCenter">
			$viewper
			</td>
END_PER_TABLE_TBODY;
			}
		}

		$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
		</tr>
END_PER_TABLE_TBODY;
}


	$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
	</tbody>
	</table>
	</div>
	</div>
END_PER_TABLE_TBODY;

	$Rarecaseadmin = permissionRareCaseScenario($database,$filter,$user_company_id,$project_id);

	// $permissionContact = permissionForContacts($database,$filter,$user_company_id);

	$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
	<div id ="rarepermission">$Rarecaseadmin</div>
END_PER_TABLE_TBODY;

	return $permissionTbodyadmin;
}
//rare case scenario data's
function permissionRareCaseScenario($database,$software_module_id,$user_company_id,$project_id)
{
		$project_id = ($project_id=="")?"0":$project_id;
		$permisionarr = listRoleswithPermission($database,$user_company_id,$software_module_id);
		$rolesarr = getAllRoles($database,'all');

		$softwareModuleFunctionCount = count($permisionarr)+1;
		$arrCustomizedPermissionsByContact  = moduleBasedrarecases($database,$software_module_id,$user_company_id,$project_id);
		// DDL of contacts
		$input = new Input();
		$input->database = $database;
		$input->user_company_id = $user_company_id;
		$input->csvContactIdExclusionList = $arrCustomizedPermissionsByContact;
		$input->selected_contact_id = '';
		$input->htmlElementId = 'ddlContact';
		$input->js = 'onchange="rarecasemoduleper();"';
		$input->firstOption = 'Add Specific Contact';
		$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildContactsForPermissionFullNameWithEmailByUserCompanyIdDropDownList($input);
		$permissionRarecaseadmin = <<<END_RARE_TABLE_TBODY
		<table class="table-theme" style="width: 1000px;margin-top:10px;" border='1'>
		<thead>
		<tr><th>Rare Case</th>
		
END_RARE_TABLE_TBODY;
		$modFunctionRare="";
		$csvSoftwareModuleFunctionIds ="";
		foreach ($permisionarr as $key1 => $pervalue) {
		$software_mod_label = $pervalue['sm__software_module_label'];
		$function_label =$pervalue['sf__software_module_function_label'];
		$proj_spec =$pervalue['sm__project_specific_flag'];
		$software_mod_funid = $pervalue['sf__software_module_function_id'];

		$csvSoftwareModuleFunctionIds .= $software_mod_funid.',';
	
		//To load the prerequist of software function
		$prerequistlist = loadPrerequisitesForPermission($database,$software_mod_funid);

		//To load the dependencies 
		$dependencylist = loadDependenciesForPermission($database,$software_mod_funid);


		$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		
		<th>$function_label</th>
END_RARE_TABLE_TBODY;
		
		$modFunctionRare .= <<<END_RARE_FUN_TBODY
		
		<td class="textAlignCenter"><label class="control control--checkbox col-sm-12 p-0 m-b-15 contactrarecase" style="display:none;">
			<input id="contact-$software_mod_funid-$proj_spec-x" class="" type="checkbox" onclick="togglecontactFunc(this,'$prerequistlist','$dependencylist')">
			<div class="control__indicator"></div>
			 </label></td>
END_RARE_FUN_TBODY;

}
		$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		</tr>
		</thead>
		<tr>
		<td colspan="$softwareModuleFunctionCount">
		<a href="javascript:showAdHocRow();">In rare cases you may want to give a contact more permission than what their roles permit</a>
		</td>
		</tr>
		<tr id="addHocRow" style="display:none;">
		<td>
			$contactsFullNameWithEmailByUserCompanyIdDropDownList
			<br>
		</td>
		$modFunctionRare
		</tr>
		
END_RARE_TABLE_TBODY;

$csvSoftwareModuleFunctionIds = rtrim($csvSoftwareModuleFunctionIds,',');
foreach ($arrCustomizedPermissionsByContact as $tmpContactId => $null) {

	$contactNameEmail = ContactEmailWithNameandCompany($database,$tmpContactId);

	$removeContact="<a href='javascript:removeContactFromModule(&apos;".$tmpContactId."&apos;,&apos;".$csvSoftwareModuleFunctionIds."&apos;,&apos;".$project_id."&apos;);removeContact(&apos;$tmpContactId&apos;)'>x</a>";

	$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		
		<tr class="con_$tmpContactId">
		<td style="padding: 5px;">$removeContact $contactNameEmail</td>
		
END_RARE_TABLE_TBODY;
$submodFunctionRare="";
foreach ($permisionarr as $key1 => $pervalue) {
		$software_mod_label = $pervalue['sm__software_module_label'];
		$function_label =$pervalue['sf__software_module_function_label'];
		$proj_spec =$pervalue['sm__project_specific_flag'];
		$software_mod_funid = $pervalue['sf__software_module_function_id'];
		
		//To load the prerequist of software function
		$prerequistlist = loadPrerequisitesForPermission($database,$software_mod_funid);

		//To load the dependencies 
		$dependencylist = loadDependenciesForPermission($database,$software_mod_funid);

		if($arrCustomizedPermissionsByContact[$tmpContactId]["functions"][$software_mod_funid]=='1')
		{
			$funcheck ="checked";
		}else
		{
			$funcheck ="";
		}
		$submodFunctionRare .= <<<END_RARE_FUN_TBODY
		
		<td class="textAlignCenter" style="padding: 5px;"><label class="control control--checkbox col-sm-12 p-0 m-b-15 contactrarecase" >
			<input id="contact-$software_mod_funid-$proj_spec-$tmpContactId" class="" type="checkbox" onclick="togglecontactFunc(this,'$prerequistlist','$dependencylist')" $funcheck>
			<div class="control__indicator"></div>
			 </label></td>
END_RARE_FUN_TBODY;

}

$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		$submodFunctionRare
		</tr>
END_RARE_TABLE_TBODY;

}

	$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		
		</table>
END_RARE_TABLE_TBODY;
return $permissionRarecaseadmin;

	}

	function permissionForContacts($database,$software_module_id,$user_company_id, $module_type=''){

		$session = Zend_Registry::get('session');
			$project_id = $session->getCurrentlySelectedProjectId();
		$permisionarr = listRoleswithPermission($database,$user_company_id,$software_module_id);
		$role_spec="";
		
		$rolesarr = getAllRoles($database,'all',$role_spec);

		$softwareModuleFunctionCount = count($permisionarr)+1;

	
		$modFunction ="";
		$contactFunction ="";
		$modFunIds ="";

		foreach ($permisionarr as $key1 => $pervalue) {
		$software_mod_label = $pervalue['sm__software_module_label'];
		$function_label =$pervalue['sf__software_module_function_label'];
		$proj_spec =$pervalue['sm__project_specific_flag'];
		$software_mod_funid = $pervalue['sf__software_module_function_id'];
		$modFunIds .= $software_mod_funid."," ;
		$modFunction .= <<<END_RARE_TABLE_TBODY
		<td class="prewrap">$function_label</td>
END_RARE_TABLE_TBODY;
	
		
	}
	$modFunIds = rtrim($modFunIds,",");
	if(!empty($module_type)){
		$contactAssigntoRole = contactPermissionForSoftwareModulesProjSpecific($database,$user_company_id,$modFunIds,$proj_spec,$project_id);
	}else{
		$contactAssigntoRole = contactPermissionForSoftwareModules($database,$user_company_id,$modFunIds,$proj_spec,$project_id);
	}

	
		if(!empty($contactAssigntoRole)){
		foreach ($contactAssigntoRole as $ckey => $contact) {
			if($contact['contacts']['full_name'] !="")
			{
				$contname = $contact['contacts']['full_name'].' &lt; '.$contact['contacts']['email'].' &gt; - '.$contact['contacts']['company'];
			}else
			{
				$contname =$contact['contacts']['email'].' - '.$contact['contacts']['company'];
			}

		$contactFunction .= <<<END_RARE_TABLE_TBODY
		<tr><td><a href="javascript:showContactsRoles('$ckey')">$contname</a></td>
END_RARE_TABLE_TBODY;
		
		$roleFunction="";
		$rolecat=array();		
		foreach ($rolesarr as $rolid => $rolval) {
			// To check whether the array is present or not
			$perRolfun = (isset($contact['roles'][$rolid]))?$contact['roles'][$rolid]:array();
			$rolecat = (isset($contact['roles'][$rolid]['rol_name']))?$contact['roles'][$rolid]['rol_name']:array();
			if($perRolfun)
			{
			$roleFunction .= "<tr class='perm contact_".$ckey." hidden'><td>$rolecat</td>";
			
			foreach ($permisionarr as $funt => $pervalue) {
				$modulefunction = (isset($contact['roles'][$rolid]['modules'][$funt]))?$contact['roles'][$rolid]['modules'][$funt]:array();
				if($modulefunction)
				{
					$roleFunction .= "<td class='textAlignCenter'> YES </td>";
				}else
				{
					$roleFunction .= "<td class='textAlignCenter'>&nbsp</td>";
				}

			}
		}
			$roleFunction .= "</tr>";

		}
		foreach ($permisionarr as $cfun => $convalue) {
				$contmod = (isset($contact['modules'][$cfun]))?$contact['modules'][$cfun]:array();
				if($contmod)
				{
					$contactFunction .= <<<END_RARE_TABLE_TBODY
		<td class='textAlignCenter'>YES</td>
END_RARE_TABLE_TBODY;
				}else
				{
					$contactFunction .= <<<END_RARE_TABLE_TBODY
		<td class='textAlignCenter'> &nbsp</td>
END_RARE_TABLE_TBODY;
				}
				

			}
			$contactFunction .= <<<END_RARE_TABLE_TBODY
		</tr>
		$roleFunction
END_RARE_TABLE_TBODY;
		
	}
	}

	$permissioncontactGrid = <<<END_CONTACT_TABLE_TBODY
		<table class="table-theme" style="width: 1000px;margin-top:10px;" border='1'>
		<thead>
		<tr><th colspan="$softwareModuleFunctionCount">"$software_mod_label" System Permission by Role</th></tr></thead>
		<tbody>
		<tr><td class="prewrap">Contact</td>
		$modFunction</tr>
		$contactFunction
END_CONTACT_TABLE_TBODY;



$permissioncontactGrid .= <<<END_CONTACT_TABLE_TBODY
		</tbody>
		</table>
END_CONTACT_TABLE_TBODY;

return $permissioncontactGrid;

	}

	


/* Start of project specific permission */

function SoftwaremoduleProjectspecific($database)
{
	
	$arr_module_result = SoftwareModulesListprojectspecific($database,'Y');
	
	$listId="ddl_software_module_id";
	$listClass="";
	$listjs="onchange=projectpermissionlist()";
	$liststyle="";
	$listDefault="";
	$listselected="";
	// $listDefault="Select A Module";
	$res_drop=selectGroupDropDown($database,$listId,$listClass,$listjs,$liststyle,$listDefault,$arr_module_result,$listselected);
	$permissionTableTbody = <<<END_PER_TABLE_TBODY
	$res_drop
END_PER_TABLE_TBODY;

	return $res_drop;
}

//To display the roles in alphabetic order
function roleprojectAlphabetic($database)
{
	$alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$permissionTableTbody = <<<END_PER_TABLE_TBODY
	<span id="perall" class="filrol" onclick="filterprojectroles('all')">Role(s)</span>
	<span class="filrol">
		<select id="specify_sel" class="addpermission" onchange="showHideprojectRoles()"  style="margin-left:5px;margin-right:5px;font-size:14px;">
			<option value='all'>Both roles</option>
			<option value='Y' selected>Proj Spec</option>
			<option value='N'>Not Proj Spec</option>
		</select>
	</span>
END_PER_TABLE_TBODY;

foreach ($alpha as  $Alpvalue) {
	$permissionTableTbody .= <<<END_PER_TABLE_TBODY
	<span id="per$Alpvalue" class="filrol" onclick="filterprojectroles('$Alpvalue')">$Alpvalue</span>
END_PER_TABLE_TBODY;

}
return $permissionTableTbody;

}

//To get all the modules associated with roles For admin
function rolesprojectAssociatedWithPermission($database,$user_company_id,$userRole,$filter='all',$role_spec,$rolefilter,$project_id)
{
	$userCanManagepermission  = checkPermissionForAllModuleAndRole($database,'admin_permissions_manage');
	$userCanViewpermission = checkPermissionForAllModuleAndRole($database,'admin_permissions_view');
	
	$permisionarr = listRoleswithPermission($database,$user_company_id,$filter);
	$rolesarr = getAllRoles($database,'all',$role_spec,$rolefilter);

	$permissionTbodyadmin = <<<END_PER_TABLE_TBODY
	<div class="nonProSpecTable">
			<table style="width: 100%;" border="1" class="table-theme">
				<thead>
					<tr>
						<th style="vertical-align: bottom;">MODULE FUNCTIONs</th>
END_PER_TABLE_TBODY;

$prj_head="";
	$curcompany='';
	$permissionabbreLine = "";
	foreach ($permisionarr as $key1 => $pervalue) {
		$function_arr =$pervalue['sf__software_module_function_abbreviation'];
		$software_mod_label = $pervalue['sm__software_module_label'];
		$function_label =$pervalue['sf__software_module_function_label'];
		$proj_spec =$pervalue['sm__project_specific_flag'];
		$function_label_arr =$pervalue['sf__software_module_function_label_abbreviation'];

		if($proj_spec == 'N')
		{
			$proj_specTag =$software_mod_label;
		}else
		{
			$proj_specTag =$software_mod_label;
			//Prj specify alone getting project_id
			
		}
		if($prj_head != $proj_specTag)
		{
			$prj_head = $proj_specTag;

		}else
		{
			$proj_specTag ="";
		}

		$count = array_count_values(array_column($permisionarr, 'sf__software_module_function_abbreviation'))[$function_arr];
		if ($curcompany <> $function_arr) {
			$curcompany=$function_arr;
			$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
				<th colspan='$count'>$function_arr</th>
END_PER_TABLE_TBODY;
		}
		// To generate the Label row
		$permissionabbreLine .= <<<END_PER_TABLE_TBODY
			<th>$function_label_arr</th>
END_PER_TABLE_TBODY;
	}
$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
		</tr>
		<tr>
		<th></th>
		$permissionabbreLine
		</tr>
		</thead>
		<tbody>
END_PER_TABLE_TBODY;

	//To list all the role names
	foreach ($rolesarr as $key => $rolevalue) {
		
		if(!empty($userRole) && $userRole =='admin' && $rolevalue['role'] =='Global Admin'){
			continue;
		}
		$role_name = $rolevalue['role'];
		$role_pst = $rolevalue['project_specific_flag'];
		if($role_pst == 'Y')
		{
			$prclass = "pspecify";
		}else
		{
			$prclass = "nonspecify";
		}

		$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
		<tr><td class="$prclass">$role_name</td>
END_PER_TABLE_TBODY;

	

	foreach ($permisionarr as $key1 => $pervalue) {
		$software_mod_label = $pervalue['sm__software_module_label'];
		$function_label =$pervalue['sf__software_module_function_label'];
		$proj_spec =$pervalue['sm__project_specific_flag'];

		if($proj_spec == 'N'){
			$proj_specTag =$software_mod_label." - Not Project Specific";
		}else{
			$proj_specTag =$software_mod_label." - Project Specific";
			//Prj specify alone getting project_id
			$session = Zend_Registry::get('session');
			$project_id = $session->getCurrentlySelectedProjectId();
		}
		if($prj_head != $proj_specTag){
			$prj_head = $proj_specTag;
		}else{
			$proj_specTag ="";
		}


		$software_mod_funid = $pervalue['sf__software_module_function_id'];
		$arrlinkedrole_id = projectrolesToSoftwarefunction($database,$project_id,$software_mod_funid);

		//To load the prerequist of software function
		$prerequistlist = loadPrerequisitesForPermission($database,$software_mod_funid);

		//To load the dependencies 
		$dependencylist = loadDependenciesForPermission($database,$software_mod_funid);



			
			if(!empty($userRole) && $userRole =='admin' && $rolevalue['role'] =='Global Admin'){
				continue;
			}
			if((isset($arrlinkedrole_id[$key]))&&($arrlinkedrole_id[$key] == $key))
			{
				$pertag = "checked";
				$viewper = "Yes"; //For view
			}else
			{
				$pertag = "";
				$viewper = "No"; //For view
			}
			//For user role it shouls select every other role
			if($key == AXIS_USER_ROLE_ID_USER)
			{
				$userupdatefunction = ",userupdateAllRolesforPrjspec(&apos;$software_mod_funid&apos;, &apos;$key&apos;)";
				// $userupdatefunction ="";
			}else
			{
				$userupdatefunction ="";
			}
			if($userCanManagepermission){
			//id contains software_module_function id , role_id
			$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
			<td class="textAlignCenter">
			<label class="control control--checkbox col-sm-12 p-0 m-b-15">
			<input id="editrolep-$software_mod_funid-$key" type="checkbox" onclick="toggleRoleprojectspec(this.id,'$prerequistlist','$dependencylist','$key') $userupdatefunction;" $pertag>
			<div class="control__indicator"></div>
			 </label>
			</td>
END_PER_TABLE_TBODY;
			}else
			{
				//id contains software_module_function id , role_id
			$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
			<td class="textAlignCenter">
			$viewper
			</td>
END_PER_TABLE_TBODY;
			}
		}

		$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
		</tr>
END_PER_TABLE_TBODY;
	}


	$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
	</tbody>
	</table>
	</div>
	</div>
END_PER_TABLE_TBODY;

	$Rarecaseadmin = permissionProjectRareCaseScenario($database,$filter,$user_company_id,$project_id);
	// $permissionContact = permissionForContacts($database,$filter,$user_company_id,'project_specific');

	$permissionTbodyadmin .= <<<END_PER_TABLE_TBODY
	<div id ="rarepermission">$Rarecaseadmin</div>
END_PER_TABLE_TBODY;

	return $permissionTbodyadmin;
}
//rare case scenario data's
function permissionProjectRareCaseScenario($database,$software_module_id,$user_company_id,$project_id)
{
		$project_id = ($project_id=="")?"0":$project_id;
		$permisionarr = listRoleswithPermission($database,$user_company_id,$software_module_id);
		$rolesarr = getAllRoles($database,'all');

		$softwareModuleFunctionCount = count($permisionarr)+1;
		$arrCustomizedPermissionsByContact  = moduleBasedrarecases($database,$software_module_id,$user_company_id,$project_id);
		// DDL of contacts
		$input = new Input();
		$input->database = $database;
		$input->user_company_id = $user_company_id;
		$input->csvContactIdExclusionList = $arrCustomizedPermissionsByContact;
		$input->selected_contact_id = '';
		$input->htmlElementId = 'ddlContact';
		$input->js = 'onchange="rarecasemoduleper();"';
		$input->firstOption = 'Add Specific Contact';
		$contactsFullNameWithEmailByUserCompanyIdDropDownList = buildContactsForPermissionFullNameWithEmailByUserCompanyIdDropDownList($input);
		$permissionRarecaseadmin="";
		$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		<table class="table-theme" style="width: 1000px;margin-top:10px;" border='1'>
		<thead>
		<tr><th>Rare Case</th>
		
END_RARE_TABLE_TBODY;
		$modFunctionRare="";
		$csvSoftwareModuleFunctionIds ="";
		foreach ($permisionarr as $key1 => $pervalue) {
		$software_mod_label = $pervalue['sm__software_module_label'];
		$function_label =$pervalue['sf__software_module_function_label'];
		$proj_spec =$pervalue['sm__project_specific_flag'];
		$software_mod_funid = $pervalue['sf__software_module_function_id'];

		$csvSoftwareModuleFunctionIds .= $software_mod_funid.',';
	
		//To load the prerequist of software function
		$prerequistlist = loadPrerequisitesForPermission($database,$software_mod_funid);

		//To load the dependencies 
		$dependencylist = loadDependenciesForPermission($database,$software_mod_funid);


		$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		
		<th>$function_label</th>
END_RARE_TABLE_TBODY;
		
		$modFunctionRare .= <<<END_RARE_FUN_TBODY
		
		<td class="textAlignCenter"><label class="control control--checkbox col-sm-12 p-0 m-b-15 contactrarecase" style="display:none;">
			<input id="contact-$software_mod_funid-$proj_spec-x" class="" type="checkbox" onclick="togglecontactFunc(this,'$prerequistlist','$dependencylist')">
			<div class="control__indicator"></div>
			 </label></td>
END_RARE_FUN_TBODY;

}
		$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		</tr>
		</thead>
		<tr>
		<td colspan="$softwareModuleFunctionCount">
		<a href="javascript:showAdHocRow();">In rare cases you may want to give a contact more permission than what their roles permit</a>
		</td>
		</tr>
		<tr id="addHocRow" style="display:none;">
		<td>
			$contactsFullNameWithEmailByUserCompanyIdDropDownList
			<br>
		</td>
		$modFunctionRare
		</tr>
		
END_RARE_TABLE_TBODY;

$csvSoftwareModuleFunctionIds = rtrim($csvSoftwareModuleFunctionIds,',');
foreach ($arrCustomizedPermissionsByContact as $tmpContactId => $null) {

	$contactNameEmail = ContactEmailWithNameandCompany($database,$tmpContactId);

	$removeContact="<a href='javascript:removeContactFromModule(&apos;".$tmpContactId."&apos;,&apos;".$csvSoftwareModuleFunctionIds."&apos;,&apos;".$project_id."&apos;);removeContact(&apos;$tmpContactId&apos;)'>x</a>";

	$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		
		<tr class="con_$tmpContactId">
		<td style="padding: 5px;">$removeContact $contactNameEmail</td>
		
END_RARE_TABLE_TBODY;
$submodFunctionRare="";
foreach ($permisionarr as $key1 => $pervalue) {
		$software_mod_label = $pervalue['sm__software_module_label'];
		$function_label =$pervalue['sf__software_module_function_label'];
		$proj_spec =$pervalue['sm__project_specific_flag'];
		$software_mod_funid = $pervalue['sf__software_module_function_id'];
		
		//To load the prerequist of software function
		$prerequistlist = loadPrerequisitesForPermission($database,$software_mod_funid);

		//To load the dependencies 
		$dependencylist = loadDependenciesForPermission($database,$software_mod_funid);

		if($arrCustomizedPermissionsByContact[$tmpContactId]["functions"][$software_mod_funid]=='1')
		{
			$funcheck ="checked";
		}else
		{
			$funcheck ="";
		}
		$submodFunctionRare .= <<<END_RARE_FUN_TBODY
		
		<td class="textAlignCenter" style="padding: 5px;"><label class="control control--checkbox col-sm-12 p-0 m-b-15 contactrarecase" >
			<input id="contact-$software_mod_funid-$proj_spec-$tmpContactId" class="" type="checkbox" onclick="togglecontactFunc(this,'$prerequistlist','$dependencylist')" $funcheck>
			<div class="control__indicator"></div>
			 </label></td>
END_RARE_FUN_TBODY;

}

$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		$submodFunctionRare
		</tr>
END_RARE_TABLE_TBODY;

}

	$permissionRarecaseadmin .= <<<END_RARE_TABLE_TBODY
		
		</table>
END_RARE_TABLE_TBODY;
return $permissionRarecaseadmin;

	}


/* End of project specific permission */

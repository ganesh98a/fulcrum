<?php 
require_once('lib/common/SoftwareModuleFunction.php');

//software module list
function SoftwareModulesListforgroup($database,$prj_flag='1')
{
	$db = DBI::getInstance($database);
	$query ="SELECT sm.* FROM `software_modules` sm ORDER BY `sm`.`software_module_label` ASC ";
	// `sm`.`project_specific_flag` DESC,`software_module_category_id` ASC";
	$arrSoftwareModuleOptions = array();
	// $db->execute($query);
	$arrValues = array();
	$db->execute($query, $arrValues);

	while ($row = $db->fetch()) {
		$software_module_id = $row['id'];
		$software_module = $row['software_module'];
		$software_module_label = $row['software_module_label'];

		if ($row['project_specific_flag'] == 'Y') {
			$prjtg = 'Project Specific';
			if($prj_flag =='1')
			{
				$newValue = $software_module_label . " &mdash; Project Specific";
			}else
			{
				$newValue = $software_module_label ;
			}
			$software_module_value = $software_module_id.'_'.'Y';
		} else {
			$prjtg = 'Not Project Specific';
			if($prj_flag =='1')
			{
				$newValue = $software_module_label . " &mdash; Not Project Specific";
			}else
			{
				$newValue = $software_module_label;
			}
			$software_module_value = $software_module_id.'_'.'N';
		}
		$arrSoftwareModuleOptions[$prjtg][$software_module_value] = $newValue;
	}
	$db->free_result();
	return $arrSoftwareModuleOptions;
}

function RoleList($database)
{
	$db = DBI::getInstance($database);
	$query ="SELECT r.* FROM `roles` r ORDER BY `id` ASC";
	$arrRolesOptions = array();
	$db->execute($query);

	while ($row = $db->fetch()) {
		$role_id = $row['id'];
		$role = $row['role'];
		$role_value = $role_id;
		if ($row['project_specific_flag'] == 'Y') {
			$newValue = $role . " - Project Specific";
			$prjtg = 'Project Specific';
		} else {
			$newValue = $role . " - Not Project Specific";
			$prjtg = 'Not Project Specific';
		}
		$arrRolesOptions[$prjtg][$role_value] = $newValue;
	}
	$db->free_result();
	return $arrRolesOptions;
}
//To get the latest role id
function getlastroleid($database)
{
	$db = DBI::getInstance($database);
	$query ="SELECT id FROM `roles` order by id desc limit 1 ";
	$db->execute($query);
	$row = $db->fetch();
	$id = $row['id'];
	$db->free_result();
	return $id;

}

function SoftwareModulesfunctionformodule($database,$module_id)
{
	$db = DBI::getInstance($database);
	$query ="SELECT s.* FROM `software_module_functions` s where software_module_id =?";
	$arrValues = array($module_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$arrmodulefunction = array();
	$arrfunction = array();
	$navigation_label= "";
	while ($row = $db->fetch()) {
		$function_id = $row['id'];
		$function_label = $row['software_module_function_label'];
		$navigation_label = $row['software_module_function_navigation_label'];
		$arrmodulefunction[$function_id]['label'] = $function_label;
		$arrmodulefunction[$function_id]['navigation'] = $navigation_label;
		$arrmodulefunction[$function_id]['function_id'] = $function_id;
	}
	$db->free_result();
	$arrfunction = array('module_name' => $navigation_label,'function_arr' =>$arrmodulefunction );
	return $arrfunction;
}

/**
	$user_company_id - company id
	$arr_role_ids - role 
	$arr_function_ids - software module function id
	$is_global - whether set by global admin or not
	**/
	function InsertRoletosoftwarefunctionformodule($database,$user_company_id,$arr_role_ids,$arr_function_ids,$is_global)
	{
		$db = DBI::getInstance($database);
		$db->free_result();
		foreach ($arr_role_ids as $key => $role_id) {
			foreach ($arr_function_ids as $key => $function_id) {
				$query ="INSERT into roles_to_software_module_function_templates (`user_company_id`, `role_id`, `software_module_function_id`,`is_global_admin`)  Values (?, ?, ?, ?)";
				$arrValues = array($user_company_id,$role_id,$function_id,$is_global);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$db->free_result();
			}
		}

	}

//To insert the Roles
	function InsertSystemRoles($database,$role_name,$role_desp,$prj_specfic)
	{
		$sort ="10000";
		$db = DBI::getInstance($database);
		$query ="SELECT count(*) as count FROM `roles` where role =?";
		$arrValues = array($role_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row1 = $db->fetch();
		$count = $row1['count'];
		$db->free_result();

		

		if($count == 0)
		{
		//Insert
			$query1 ="INSERT into `roles` ( `role`, `role_description`, `project_specific_flag`, `sort_order`) VALUES (? ,? ,? ,? )";
			$arrValues = array($role_name,$role_desp,$prj_specfic,$sort);
			if($db->execute($query1, $arrValues, MYSQLI_USE_RESULT))
			{
				$role_id = $db->insertId;
				InsertSystemRolesGroup($database, $prj_specfic, $role_id);
				return 0;
			}else
			{
				return 1;
			}
			
		}else
		{
			return 1;
		}

	}

// To Group the Roles

	function InsertSystemRolesGroup($database, $prj_specfic, $role_id ){
		$db = DBI::getInstance($database);
		$sort = '1000';
		$role_group = 'contact_roles';
		if(!empty($prj_specfic) && $prj_specfic =='Y'){
			$role_group = 'project_roles';
		}

	//print_r($role_group);
		$query = "SELECT * FROM `role_groups` WHERE `role_group` = '".$role_group."'";
		$db->execute($query);
		$row_group = $db->fetch();
		$db->free_result();

	//print_r($row_group);

		if(!empty($row_group['id'])){
		//print_r($role_id);

			$insertGrp = "INSERT INTO `role_groups_to_roles` (`role_group_id`, `role_id`, `role_alias`, `sort_order`) VALUES (?, ?, '', ?)";

			$arrValues = array($row_group['id'],$role_id,$sort);
			if($db->execute($insertGrp, $arrValues, MYSQLI_USE_RESULT)){
				$db->free_result();
				return true;
			}
		}
		$db->free_result();
	}

//To get the roles associated with the modules
	function listRoleswithPermission($database,$user_company_id,$filter)
	{
		if(is_numeric($filter))
		{
			$wheredata= "where sm.id='$filter' ";
		}
		else if($filter=='all')
		{
			$wheredata= "";
		}else
		{
			$wheredata= "where sm.`software_module_label` LIKE  '$filter%' ";
		}
		$db = DBI::getInstance($database);
		$query = "SELECT sm.`id` as sm__software_module_id,
		sm.`software_module_category_id` as sm__software_module_category_id,
		sm.`software_module` as sm__software_module, 
		sm.`software_module_label` as sm__software_module_label,
		sm.`software_module_description` as sm__software_module_description,
		sm.`default_software_module_url` as sm__default_software_module_url,
		sm.`hard_coded_flag` as sm__hard_coded_flag,
		sm.`web_view_flag` as sm__web_view_flag, 
		sm.`mobile_view_flag` as sm__mobile_view_flag, 
		sm.`global_admin_only_flag` as sm__global_admin_only_flag, 
		sm.`purchased_module_flag` as sm__purchased_module_flag, 
		sm.`customer_configurable_flag` as sm__customer_configurable_flag, 
		sm.`allow_ad_hoc_contact_permissions_flag` as sm__allow_ad_hoc_contact_permissions_flag, 
		sm.`project_specific_flag` as sm__project_specific_flag, 
		sm.`disabled_flag` as sm__disabled_flag, 
		sm.`sort_order` as sm__sort_order,

		sf.`id` as sf__software_module_function_id, 
		sf.`software_module_id` as sf__software_module_id, 
		sf.`software_module_function` as sf__software_module_function, 
		sf.`software_module_function_abbreviation` as sf__software_module_function_abbreviation,
		sf.`software_module_function_label` as sf__software_module_function_label, 
		sf.`software_module_function_label_abbreviation` as sf__software_module_function_label_abbreviation,
		sf.`software_module_function_navigation_label` as sf__software_module_function_navigation_label,
		sf. `software_module_function_description` as sf__software_module_function_description,
		sf. `default_software_module_function_url` as sf__default_software_module_function_url,
		sf. `show_in_navigation_flag` as sf__show_in_navigation_flag,
		sf. `available_to_all_users_flag` as sf__available_to_all_users_flag,
		sf. `global_admin_only_flag` as sf__global_admin_only_flag, 
		sf.`purchased_function_flag` as sf__purchased_function_flag, 
		sf.`customer_configurable_permissions_by_role_flag` as sf__customer_configurable_permissions_by_role_flag,
		sf. `customer_configurable_permissions_by_project_by_role_flag` as sf__customer_configurable_permissions_by_project_by_role_flag,
		sf. `customer_configurable_permissions_by_contact_flag` as sf__customer_configurable_permissions_by_contact_flag,
		sf. `project_specific_flag` as sf__project_specific_flag,
		sf. `disabled_flag` as sf__disabled_flag,
		sf. `sort_order` as sf__sort_order 

		FROM `software_modules` as sm 
		inner join `software_module_functions` as sf on sf.software_module_id = sm.id
		$wheredata 
		ORDER BY sf. `sort_order` ASC,`software_module_label` ASC,`sm__software_module_category_id`  ASC, `sm__software_module_id` ASC ,`sf__software_module_function_abbreviation` ASC,`sf__software_module_function_label_abbreviation` DESC";
		$db->execute($query);
		$permissionRolearr=array();
		$sm_def="";
		while($row1 = $db->fetch())
		{
			$sm_id = $row1['sm__software_module_id'];
			$module_id = $row1['sf__software_module_function_id'];
			$permissionRolearr[$module_id] = $row1;
		}
		$db->free_result();
		
		return $permissionRolearr;

	}

//To list the roles associated with the modules
	function rolesToSoftwareModules($database,$user_company_id,$function_id)
	{
		$db = DBI::getInstance($database);
		$query = "SELECT 
		rsf.`user_company_id` as rsf__user_company_id, 
		rsf.`role_id` as rsf__role_id,
		rsf.`software_module_function_id` as rsf__software_module_function_id,

		r.* 

		FROM `roles_to_software_module_function_templates` as rsf 
		LEFT join `roles` as r on r.id = rsf.role_id 
		where rsf.`user_company_id` = '$user_company_id' and rsf.`software_module_function_id` = '$function_id'";
		
		$db->execute($query);
		$Rolearr=array();
		while($row1 = $db->fetch())
		{
			$role_id = $row1['rsf__role_id'];
			$Rolearr[$role_id]=$role_id;
		}
		$db->free_result();
		return $Rolearr;
	}

//To get all the roles
	function getAllRoles($database,$filter='all',$role_spec='all',$rolefilter="")
	{
		if($role_spec=='Y')
		{
			$whereclass= "WHERE project_specific_flag ='Y'";
		}else if($role_spec == 'N')
		{
			$whereclass= "WHERE project_specific_flag ='N'";
		}else
		{
			$whereclass= "WHERE project_specific_flag IN ('N','Y')";
		}

		if($rolefilter !="")
		{
			$whereclass .= "and role LIKE  '$rolefilter%'";
		}

		$db = DBI::getInstance($database);
		$query ="SELECT * FROM `roles` $whereclass ";
		$db->execute($query);
		$rolesarr =array();
		while($row1 = $db->fetch())
		{
			if($filter=='all')
			{
				$role_id  = $row1['id'];
				$rolesarr[$role_id]['role'] =$row1['role'];
				$rolesarr[$role_id]['project_specific_flag'] =$row1['project_specific_flag'];
			}
			else
			{
				$rolesarr[$row1[$filter]] =$row1[$filter];
			}
		}
		return $rolesarr;
	}

//To get all the companies
	function ListofallCompanies($database)
	{
		$db = DBI::getInstance($database);
		$query ="SELECT * FROM `user_companies` ";
		$db->execute($query);
		$companyarr =array();
		while($row1 = $db->fetch())
		{
			$comp_id = $row1['id'];
			$companyarr[$comp_id] = $row1['company'];
		// $companyarr[$comp_id]['company_name'] = $row1['company'];
		}
		return $companyarr;
	}

//To get all project list
	function ListofallProjects($database)
	{
		$db = DBI::getInstance($database);
		$query ="SELECT * FROM `projects` ";
		$db->execute($query);
		$projectarr =array();
		while($row1 = $db->fetch())
		{
			$prj_id = $row1['id'];
			$projectarr[$prj_id] = $row1['project_name'];
		}
		return $projectarr;
	}

/**
$software_module_function_id  - Software module function id, 
$RoleId - Role id ,
$insertFlagValue - whether to insert data (Y)or delete the data(N),
$global_flag - Is it a global admin(Y)  or admin (N)
$user_company_id - Current user company id 

**/

function  UpdateRolePermissionSoftwareFunctionAsAdmin($database,$software_module_function_id,$RoleId,$insertFlagValue,$global_flag,$user_company_id)
{

	if($insertFlagValue == 'Y')
	{
		//Insert
		$db = DBI::getInstance($database);
		$query1 ="INSERT into `roles_to_software_module_function_templates` ( `user_company_id`, `role_id`, `software_module_function_id`, `is_global_admin`) VALUES (? ,? ,? ,? )";
		$arrValues = array($user_company_id,$RoleId,$software_module_function_id,$global_flag);
		$db->execute($query1, $arrValues);
		$db->free_result();

	}else
	{
		//Delete
		$db = DBI::getInstance($database);
		$query1 ="DELETE FROM `roles_to_software_module_function_templates` WHERE `role_id`=? and `software_module_function_id`=? and `user_company_id`=?  ";
		$arrValues = array($RoleId,$software_module_function_id,$user_company_id);
		$db->execute($query1, $arrValues);
		$db->free_result();
	}
}

/**
$software_module_function_id  - Software module function id, 
$RoleId - Role id ,
$insertFlagValue - whether to insert data (Y)or delete the data(N),
$global_flag - Is it a global admin(Y)  or admin (N)
$user_company_id - Current user company id 

**/

function  UpdateRolePermissionSoftwareFunctionAsGlobalAdmin($database,$software_module_function_id,$RoleId,$insertFlagValue,$global_flag,$user_company_id)
{

	if($insertFlagValue == 'Y')
	{
		//Insert for all the companies
		$arrcompany =  ListofallCompanies($database);
		foreach ($arrcompany as $key => $com_id) {
			$db = DBI::getInstance($database);
			$query1 ="INSERT into `roles_to_software_module_function_templates` ( `user_company_id`, `role_id`, `software_module_function_id`, `is_global_admin`) VALUES ('$key','$RoleId','$software_module_function_id','$global_flag')";
		// $arrValues = array($key,$RoleId,$software_module_function_id,$global_flag);
			$db->execute($query1);
			$db->free_result();
		}

	}else
	{
		//Delete for all the company except the company that admin has modified
		$db = DBI::getInstance($database);
		$query1 ="DELETE FROM `roles_to_software_module_function_templates` WHERE `role_id`=? and `software_module_function_id`=? and `is_global_admin`=?  ";
		$arrValues = array($RoleId,$software_module_function_id,$global_flag);
		$db->execute($query1, $arrValues);
		$db->free_result();
	}

	//For prject specific module
	$prj_specify = softwareFunctionIsGpecificOrNot($database,$software_module_function_id);
	if($prj_specify == 'Y')
	{
		//Insert for all the companies
		$arrproject =  ListofallProjects($database);
		foreach ($arrproject as $pro_id => $pro_value) {
			UpdateProjectSpecificSoftwareFunction($database,$software_module_function_id,$RoleId,$insertFlagValue,$pro_id,$global_flag);
		}
	}


}

//To check whether a software module function is project specific or not
function softwareFunctionIsGpecificOrNot($database,$softwarefuncId)
{
	$db = DBI::getInstance($database);
	$query1 ="SELECT s.project_specific_flag FROM `software_module_functions` as sf inner join software_modules as s on sf.software_module_id = s.id WHERE sf.id =?";
	$arrValues = array($softwarefuncId);
	$db->execute($query1, $arrValues);
	$row1 = $db->fetch();
	$specify =$row1['project_specific_flag'];
	$db->free_result();
	return $specify;
}

// To get all contact using software_module_function_id for project using user_company_id

function toGetAllUserForSoftwareModuele($database,$user_company_id, $project_id, $software_module_function_id){

	$db = DBI::getInstance($database);
// Query to fetch specific contact for the project 
	$query =
"
SELECT
	c.*,smf.`id` 'software_module_function_id',p2c2r.`role_id`,c.`id` 'contact_id'
FROM
	`contacts` c,
	`projects_to_contacts_to_roles` p2c2r,
	`projects_to_roles_to_software_module_functions` p2r2smf,
	`software_module_functions` smf,
	`user_companies_to_software_modules` uc2sm
WHERE c.`user_company_id` = ?
	AND c.`id` = p2c2r.`contact_id`
	AND p2c2r.`project_id` = ?
	AND p2c2r.`role_id` = p2r2smf.`role_id`
	AND p2c2r.`project_id` = p2r2smf.`project_id`
	AND p2r2smf.`software_module_function_id` = smf.`id`
	AND smf.`id` = ?
	AND c.`user_company_id` = uc2sm.`user_company_id`
	AND smf.`global_admin_only_flag` = 'N'
	AND smf.`disabled_flag` = 'N'
";
	$arrValues = array($user_company_id,$project_id,$software_module_function_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$arrContacts = array();
	while ($row = $db->fetch()) {
		$contact_id = $row['contact_id'];
		$arrContacts[$contact_id] = $row;
	}
	$db->free_result();

// Query to fetch non-specific contact for specific module for the project 
	$query2 =
"
SELECT
	c.*,p2r2smf.`software_module_function_id`,ctr.`role_id`,c.`id` 'contact_id'
FROM
	`contacts` c,
	`projects_to_roles_to_software_module_functions` p2r2smf,
	`contacts_to_roles` ctr
WHERE c.`id` = ctr.`contact_id`
	AND c.`user_company_id` = ?
	AND ctr.`role_id` = p2r2smf.`role_id`
	AND p2r2smf.`project_id` = ?
	AND p2r2smf.`software_module_function_id` = ?
";
	$arrValues2 = array($user_company_id,$project_id,$software_module_function_id);
	$db->execute($query2, $arrValues2, MYSQLI_USE_RESULT);
	while ($row = $db->fetch()) {
		$contact_id = $row['contact_id'];
		$arrContacts[$contact_id] = $row;
	}
	$db->free_result();

// Query to fetch rare case contact for the project 
	$query3 = 
"
SELECT
	c.*,p2c2s.`software_module_function_id`,p2c2r.`role_id`,c.`id` 'contact_id'

FROM `contacts` c,
	`user_companies` c_fk_uc,
	`users` c_fk_u,
	`contact_companies` c_fk_cc,
	`projects_to_contacts_to_roles` p2c2r,
	`projects_to_contacts_to_software_module_functions` p2c2s
WHERE p2c2s.`project_id` = ? 
	AND c.`user_company_id` = c_fk_uc.`id`
	AND c.`user_id` = c_fk_u.`id`
	AND c.`id` = p2c2r.`contact_id`
	AND c.`contact_company_id` = c_fk_cc.`id`
	AND p2c2s.`contact_id` = c.`id`
	AND p2c2s.`software_module_function_id` = ?
";
	$arrValues3 = array($project_id,$software_module_function_id);
	$db->execute($query3, $arrValues3, MYSQLI_USE_RESULT);
	while ($row = $db->fetch()) {
		$contact_id = $row['contact_id'];
		$arrContacts[$contact_id] = $row;
	}
	$db->free_result();

	$arrContactIds = array_keys($arrContacts);
	$arrContacts = Contact::loadContactsByArrContactIds($database, $arrContactIds);

	return $arrContacts;
}

//To check whether the module has access based on both the project specific and non specific roles
function checkPermissionForAllModuleAndRole($database,$software_module_function,$project_id = '')
{
	if ($project_id) {
		$resResonse = checkPermissionUsingProjectId($database, $software_module_function, $project_id);
	}else{
		$database = DBI::getInstance($database);	
		/* To get session variables */
		$session = Zend_Registry::get('session');
		$primary_contact_id = $session->getPrimaryContactId();
		$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
		$user_company_id = $session->getUserCompanyId();
		$currentlySelectedProjectId = (int)$session->getCurrentlySelectedProjectId();
		$currentlySelectedProjectUserCompanyId = (int)$session->getCurrentlySelectedProjectUserCompanyId();
		$project_id = $session->getCurrentlySelectedProjectId();
		$userRole = $session->getUserRole();

		/* End To get session variables */

		/* To get the software module function id */
		$software_module_functionId  = SoftwareModuleFunction::getIdbyfunctionName($software_module_function,$database);
		$project_specific_flag = SoftwareModuleFunction::getprojectspecificflagbyfunctionId($database,$software_module_functionId);
		/* To get the software module  id */
		$software_module_functionModel = SoftwareModuleFunction::findById($database,$software_module_functionId);
		$software_module_id = $software_module_functionModel->software_module_id;
		/*End  To get the software module  id */

		$raredata = rarecaseContactToModuleAccess($database,$software_module_functionId,$project_id,$currentlyActiveContactId,$project_specific_flag);
		if(!$raredata)
		{
			
			$resResonse = checkContactHasAccesstoModules($database,$software_module_id,$software_module_functionId,$user_company_id,$project_id,$currentlyActiveContactId,$project_specific_flag);
		}else
		{
			$resResonse = $raredata;
		}
		if($userRole =="global_admin")
		{
			$resResonse = true;
		}
	}
	return $resResonse;
}
	//To check rare case for modules
function rarecaseContactToModuleAccess($database,$software_module_functionId,$project_id,$primary_contact_id,$project_specific_flag)
{
	$db = DBI::getInstance($database);
	if($project_specific_flag == 'Y')
	{
		$query ="SELECT * FROM `projects_to_contacts_to_software_module_functions` where `contact_id` = ? and `software_module_function_id` =? and `project_id` =?";
		$arrValues = array($primary_contact_id,$software_module_functionId,$project_id);
		
	}else
	{
		$query ="SELECT * FROM `contacts_to_software_module_functions` where `contact_id` = ? and `software_module_function_id` =?";
		$arrValues = array($primary_contact_id,$software_module_functionId);
	}
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();
	if (!isset($row) || empty($row)) {
		$rarespecific= false;
	} else {
		$rarespecific= true;
	}
	return $rarespecific;
}

	//To check whether a contact has access to the module
function checkContactHasAccesstoModules($database,$software_module_id,$software_module_functionId,$user_company_id,$project_id,$primary_contact_id,$project_specific_flag)
{
	$db = DBI::getInstance($database);
	if($project_specific_flag =='Y')
	{

		//For project specific roles  and should not consider user access		
		$query1 ="SELECT * FROM `projects_to_roles_to_software_module_functions` as prsmf INNER join projects_to_contacts_to_roles as ptcr on ptcr.role_id = prsmf.role_id and ptcr.project_id = prsmf.project_id WHERE prsmf.software_module_function_id ='$software_module_functionId' and ptcr.contact_id = '$primary_contact_id' and ptcr.project_id ='$project_id' and prsmf.role_id <> 3 ";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id,$project_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->execute($query1);
		$row1 = $db->fetch();
		$db->free_result();
		if (!isset($row1) || empty($row1)) {
			/* Check the Non Project Specific roles in project Specific */
			
			$query3 = 	"SELECT * FROM `projects_to_roles_to_software_module_functions` as prsmf 
			INNER JOIN contacts_to_roles as ctr ON ctr.role_id = prsmf.role_id 
			WHERE prsmf.software_module_function_id ='$software_module_functionId' and ctr.contact_id = '$primary_contact_id' and prsmf.project_id ='$project_id'";

			$db->execute($query3);
			$row3 = $db->fetch();
			$db->free_result();
			if (!isset($row3) || empty($row3)) {
				return false;
			}else{
				return true;

			}
			/* Check the Non Project Specific roles in project Specific */		
			return false;
		} else {
			return true;
		}

	}else
	{
	//For  non specific roles and should not consider user access
		$query ="SELECT * FROM `user_companies_to_software_modules` as ucsm 
		INNER join roles_to_software_module_function_templates as rsmf on rsmf.user_company_id = ucsm.user_company_id 
		INNER join contacts_to_roles as cr on cr.role_id = rsmf.role_id 
		WHERE ucsm.user_company_id = '$user_company_id' and ucsm.software_module_id ='$software_module_id' and rsmf.software_module_function_id ='$software_module_functionId' and cr.contact_id = '$primary_contact_id' and rsmf.role_id <> 3 ";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		$prjnonspecific = "";
		if (!isset($row) || empty($row)) {
			$prjnonspecific= false;
		} else {
			$prjnonspecific= true;
		}

	//For project specific roles  and should not consider user access		
		$query1 ="SELECT * FROM `user_companies_to_software_modules` as ucsm 
		INNER join roles_to_software_module_function_templates as rsmf on rsmf.user_company_id = ucsm.user_company_id 
		INNER join projects_to_contacts_to_roles as ptcr on ptcr.role_id = rsmf.role_id 
		WHERE ucsm.user_company_id = '$user_company_id' and ucsm.software_module_id ='$software_module_id' and rsmf.software_module_function_id ='$software_module_functionId' and ptcr.contact_id = '$primary_contact_id' and ptcr.project_id ='$project_id' and rsmf.role_id <> 3";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id,$project_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->execute($query1);
		$row1 = $db->fetch();
		$db->free_result();
		$prjspecific ="";
		if (!isset($row1) || empty($row1)) {
			$prjspecific = false;
		} else {
			$prjspecific  = true;
		}
	// echo "prjnonspecific : ".$prjnonspecific;
	// echo "prjspecific : ".$prjspecific;
		if($prjnonspecific== true && $prjspecific==true)
		{
			return true;
		}else if ($prjnonspecific== false && $prjspecific==true)
		{
			return true;
		}else if ($prjnonspecific== true && $prjspecific==false)
		{
			return true;
		}else{
			return false;
		}	
	}
	
}

//To check whether a contact has access to the module
function checkContactHasAccesstoModules_old($database,$software_module_id,$software_module_functionId,$user_company_id,$project_id,$primary_contact_id)
{
	$db = DBI::getInstance($database);
	//For  non specific roles and should not consider user access
	$query ="SELECT * FROM `user_companies_to_software_modules` as ucsm 
	INNER join roles_to_software_module_function_templates as rsmf on rsmf.user_company_id = ucsm.user_company_id 
	INNER join contacts_to_roles as cr on cr.role_id = rsmf.role_id 
	WHERE ucsm.user_company_id = '$user_company_id' and ucsm.software_module_id ='$software_module_id' and rsmf.software_module_function_id ='$software_module_functionId' and cr.contact_id = '$primary_contact_id' and rsmf.role_id <> 3 ";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->execute($query);
	$row = $db->fetch();
	$db->free_result();
	$prjnonspecific = "";
	if (!isset($row) || empty($row)) {
		$prjnonspecific= false;
	} else {
		$prjnonspecific= true;
	}

	//For project specific roles  and should not consider user access		
	$query1 ="SELECT * FROM `user_companies_to_software_modules` as ucsm 
	INNER join roles_to_software_module_function_templates as rsmf on rsmf.user_company_id = ucsm.user_company_id 
	INNER join projects_to_contacts_to_roles as ptcr on ptcr.role_id = rsmf.role_id 
	WHERE ucsm.user_company_id = '$user_company_id' and ucsm.software_module_id ='$software_module_id' and rsmf.software_module_function_id ='$software_module_functionId' and ptcr.contact_id = '$primary_contact_id' and ptcr.project_id ='$project_id' and rsmf.role_id <> 3";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id,$project_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->execute($query1);
	$row1 = $db->fetch();
	$db->free_result();
	$prjspecific ="";
	if (!isset($row1) || empty($row1)) {
		$prjspecific = false;
	} else {
		$prjspecific  = true;
	}
	// echo "prjnonspecific : ".$prjnonspecific;
	// echo "prjspecific : ".$prjspecific;
	if($prjnonspecific== true && $prjspecific==true)
	{
		return true;
	}else if ($prjnonspecific== false && $prjspecific==true)
	{
		return true;
	}else if ($prjnonspecific== true && $prjspecific==false)
	{
		return true;
	}else{
		return false;
	}	
	
}

//To inherit the permission that has set by the Global Admin for new company
function InheritPermissionForNewCompany($database,$user_company_id)
{
	
	$db = DBI::getInstance($database);
	$default_company ='1';
	//To set the permission set by the global admin
	$query ="INSERT INTO `roles_to_software_module_function_templates`(`user_company_id`, `role_id`, `software_module_function_id`, `is_global_admin`) SELECT ?, `role_id`, `software_module_function_id`, `is_global_admin` FROM `roles_to_software_module_function_templates` WHERE `user_company_id` = ?  ";
	$arrValues = array($user_company_id,$default_company);
	$db->execute($query, $arrValues);
	$db->free_result();
	
}

//To load the prerequist
function loadPrerequisitesForPermission($database,$software_module_function_id)
{
	$db = DBI::getInstance($database);
	$query ="SELECT * FROM `software_module_function_relationships` smfr WHERE `software_module_function_id` = ?";
	$arrValues = array($software_module_function_id);
	$db->execute($query,$arrValues, MYSQLI_USE_RESULT);
	$prearr=array();
	while ($row = $db->fetch()) {
		$prearr[] = $row['prerequisite_software_module_function_id'];

	}
	$prerequisitesList = join(",", $prearr);
	$db->free_result();

	return $prerequisitesList;

}

//To load the dependencies 
function loadDependenciesForPermission($database,$software_module_function_id)
{
	$db = DBI::getInstance($database);
	$query ="SELECT * FROM `software_module_function_relationships` smfr WHERE `prerequisite_software_module_function_id` = ?";
	$arrValues = array($software_module_function_id);
	$db->execute($query,$arrValues, MYSQLI_USE_RESULT);
	$dependencyarr=array();
	while ($row = $db->fetch()) {
		$dependencyarr[] = $row['software_module_function_id'];

	}
	$dependenciesList = join(",", $dependencyarr);
	$db->free_result();

	return $dependenciesList;

}

//To load the rarecase scenaio
function moduleBasedrarecases($database,$software_module_id,$user_company_id,$project_id)
{
	$db = DBI::getInstance($database);
	// 4. Get all this user_company's contacts
	$loadContactsByUserCompanyIdOptions = new Input();
	$loadContactsByUserCompanyIdOptions->forceLoadFlag = false;
	$arrContactsByUserCompanyId = Contact::loadContactsByUserCompanyId($database, $user_company_id, $loadContactsByUserCompanyIdOptions);


	// Get any contacts that have been assigned access to any of this modules' functions
// first, determine which table to use: contacts_to_software_module_functions or projects_to_contacts_to_software_module_functions
	if ($project_id == 0 || $project_id=="") {
		$query =
		"
		SELECT
		c2smf.*
		FROM `contacts` c
		INNER JOIN `contacts_to_software_module_functions` c2smf ON c.`id` = c2smf.`contact_id`
		INNER JOIN `software_module_functions` smf ON c2smf.`software_module_function_id` = smf.`id`
		WHERE c.`user_company_id` = ?
		AND smf.`software_module_id` = ?
		AND c.`is_archive`='N'
		ORDER BY c.`first_name` ASC, c.`last_name` ASC
		";
		$arrValues = array($user_company_id, $software_module_id);
	} elseif ($project_id <> 0) {
		$query =
		"
		SELECT
		p2c2smf.*
		FROM `contacts` c
		INNER JOIN `projects_to_contacts_to_software_module_functions` p2c2smf ON c.`id` = p2c2smf.`contact_id`
		INNER JOIN `software_module_functions` smf ON p2c2smf.`software_module_function_id` = smf.`id`
		WHERE p2c2smf.`project_id` = ?
		and c.`user_company_id` = ?
		AND smf.`software_module_id` = ?
		AND c.`is_archive`='N'
		ORDER BY c.`first_name` ASC, c.`last_name` ASC
		";
		$arrValues = array($project_id, $user_company_id, $software_module_id);
	}
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrCustomizedPermissionsByContact = array();
	while ($row = $db->fetch()) {
		$contact_id = $row['contact_id'];
		$software_module_function_id = $row['software_module_function_id'];

		$contact = $arrContactsByUserCompanyId[$contact_id];
		$arrCustomizedPermissionsByContact[$contact_id]['contacts'] = $contact;
		$arrCustomizedPermissionsByContact[$contact_id]['functions'][$software_module_function_id] = 1;
	}
	$db->free_result();
	
	return $arrCustomizedPermissionsByContact;

}

function ContactEmailWithNameandCompany($database,$tmpContactId)
{
	$db = DBI::getInstance($database);
	$query ="SELECT * FROM `contacts` c inner join contact_companies cc on c.contact_company_id = cc.id where c.id = ?	";
	$arrValues = array($tmpContactId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$mail = "&lt;".$row['email']."&gt;";
	$name = $row['first_name'].' '.$row['last_name'].' ';
	$company =$row['company'];
	$email =$name.' '.$mail.' ('.$company.')';
	return $email;

}

function  RarecasePermissionUpdation($database,$softmodid,$prjspec,$conid,$project_id,$ischecked)
{
	$db = DBI::getInstance($database);
	if($ischecked == 'true')
	{
		//insertion
		if($prjspec =='Y')
		{

			$query1 ="INSERT INTO `projects_to_contacts_to_software_module_functions`(`project_id`, `contact_id`, `software_module_function_id`) VALUES (? ,? ,?)";
			$arrValues = array($project_id,$conid,$softmodid);
			$db->execute($query1, $arrValues);
			$db->free_result();
		}else
		{
			$query2 ="INSERT INTO `contacts_to_software_module_functions`(`contact_id`, `software_module_function_id`) VALUES (? ,?)";
			$arrValues = array($conid,$softmodid);
			$db->execute($query2, $arrValues);
			$db->free_result();
		}
	}else
	{
		//deletion
		if($prjspec =='Y')
		{
			$query1 ="DELETE FROM `projects_to_contacts_to_software_module_functions` where project_id =? and contact_id =? and software_module_function_id =? ";
			$arrValues = array($project_id,$conid,$softmodid);
			$db->execute($query1, $arrValues);
			$db->free_result();
		}else
		{
			$query2 ="DELETE FROM `contacts_to_software_module_functions` WHERE contact_id =? and software_module_function_id=?";
			$arrValues = array($conid,$softmodid);
			$db->execute($query2, $arrValues);
			$db->free_result();
		}
	}
}

function contactPermissionForSoftwareModulesProjSpecific($database,$user_company_id,$software_module_functionId,$project_specific,$project_id)
{
	//For  non specific roles and should not consider user access
	$db = DBI::getInstance($database);
	$contactRolearray =array();
	$query = "SELECT 
	prsmf.`project_id` AS  prsmf__project_id, 
	prsmf.`role_id` AS  prsmf__role_id,
	prsmf.`software_module_function_id` AS  prsmf__software_module_function_id,
	cr.`contact_id` AS cr__contact_id, 
	cr.`role_id` AS cr__role_id, r.`id` AS r__id, 
	r.`role` AS r__role, 
	r.`role_description` AS r__role_description, 
	r.`project_specific_flag` AS r__project_specific_flag, 
	r.`sort_order` AS r__sort_order, 
	cc.`id` AS cc__id, 
	cc.`user_user_company_id` AS cc__user_user_company_id, 
	cc.`contact_user_company_id` AS cc__contact_user_company_id, 
	cc.`company` AS cc__company, 
	cc.`primary_phone_number` AS cc__primary_phone_number, 
	cc.`employer_identification_number` AS cc__employer_identification_number, 
	cc.`construction_license_number` AS cc__construction_license_number, 
	cc.`construction_license_number_expiration_date` AS cc__construction_license_number_expiration_date, 
	cc.`vendor_flag` AS cc__vendor_flag , 
	c.* 
	FROM `projects_to_roles_to_software_module_functions` AS prsmf 
	INNER JOIN `contacts_to_roles` AS cr ON prsmf.`role_id` = cr.`role_id` 
	INNER JOIN `contacts` AS c ON cr.`contact_id` =c.`id` 
	INNER JOIN `roles` AS r ON cr.`role_id` = r.`id` 
	INNER JOIN `contact_companies` AS cc ON c.`contact_company_id` =cc.`id` 
	WHERE prsmf.`software_module_function_id` IN ($software_module_functionId) 
	AND prsmf.`project_id` = '$project_id' AND c.`user_company_id`='$user_company_id' AND c.`is_archive`='N'";
	// $arrValues = array($software_module_functionId, $user_company_id,$user_company_id);
	// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->execute($query);
	
	while($row = $db->fetch())
	{
		$contact_id = $row['cr__contact_id'];
		$role_id = $row['r__id'];
		$fun_id = $row['prsmf__software_module_function_id'];

		$contactRolearray[$contact_id]['modules'][$fun_id][$role_id]= $row['r__role'];
		$contactRolearray[$contact_id]['roles'][$role_id]['rol_name']=$row['r__role'];
		$contactRolearray[$contact_id]['roles'][$role_id]['modules'][$fun_id]= $fun_id;

		$contactRolearray[$contact_id]['contacts']['email']= $row['email'];
		$contactRolearray[$contact_id]['contacts']['first_name']= $row['first_name'];
		$contactRolearray[$contact_id]['contacts']['last_name']= $row['last_name'];
		$contactRolearray[$contact_id]['contacts']['company']= $row['cc__company'];

		
		
		if($row['first_name']!=="" && $row['last_name']!="")
		{
			$contactRolearray[$contact_id]['contacts']['full_name']=$row['first_name'].' '.$row['last_name'];
		}else
		{
			$contactRolearray[$contact_id]['contacts']['full_name']= '';
		}
		
	} 
	

	$db->free_result();

	//For project specific roles  and should not consider user access		
	$query1 ="SELECT 
	
	prsmf.`project_id` AS  prsmf__project_id, 
	prsmf.`role_id` AS  prsmf__role_id,
	prsmf.`software_module_function_id` AS  prsmf__software_module_function_id,

	pr.`project_id` AS pr__project_id,
	pr.`contact_id` AS pr__contact_id, 
	pr.`role_id` AS pr__role_id,

	r.`id` AS r__id, 
	r.`role` AS r__role, 
	r.`role_description` AS r__role_description, 
	r.`project_specific_flag` AS r__project_specific_flag, 
	r.`sort_order` AS r__sort_order,

	cc.`id` AS cc__id, 
	cc.`user_user_company_id` AS cc__user_user_company_id, 
	cc.`contact_user_company_id` AS cc__contact_user_company_id, 
	cc.`company` AS cc__company, 
	cc.`primary_phone_number` AS cc__primary_phone_number, 
	cc.`employer_identification_number` AS cc__employer_identification_number, 
	cc.`construction_license_number` AS cc__construction_license_number, 
	cc.`construction_license_number_expiration_date` AS cc__construction_license_number_expiration_date, 
	cc.`vendor_flag` AS cc__vendor_flag ,

	c.* 

	FROM `projects_to_roles_to_software_module_functions` AS prsmf 
	INNER JOIN `projects_to_contacts_to_roles` AS pr ON prsmf.`role_id` = pr.`role_id` and prsmf.`project_id` = pr.`project_id`
	INNER JOIN `contacts` AS c ON pr.`contact_id` =c.`id` 
	INNER JOIN `roles` AS r ON pr.`role_id` = r.`id` 
	INNER JOIN `contact_companies` AS cc ON c.`contact_company_id` =cc.`id` 
	WHERE prsmf.`software_module_function_id` IN ($software_module_functionId) 
	AND prsmf.`project_id` = '$project_id' 
	AND c.`user_company_id`='$user_company_id'
	AND c.`is_archive` = 'N'";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id,$project_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->execute($query1);
	while($row = $db->fetch())
	{
		$contact_id = $row['pr__contact_id'];
		$role_id = $row['r__id'];
		$fun_id = $row['prsmf__software_module_function_id'];

		$contactRolearray[$contact_id]['modules'][$fun_id][$role_id]= $row['r__role'];
		$contactRolearray[$contact_id]['roles'][$role_id]['modules'][$fun_id]=$fun_id;
		$contactRolearray[$contact_id]['roles'][$role_id]['rol_name']=$row['r__role'];

		$contactRolearray[$contact_id]['contacts']['email']= $row['email'];
		$contactRolearray[$contact_id]['contacts']['first_name']= $row['first_name'];
		$contactRolearray[$contact_id]['contacts']['last_name']= $row['last_name'];
		$contactRolearray[$contact_id]['contacts']['company']= $row['cc__company'];
		if($row['first_name']!=="" && $row['last_name']!="")
		{
			$contactRolearray[$contact_id]['contacts']['full_name']=$row['first_name'].' '.$row['last_name'];
		}else
		{
			$contactRolearray[$contact_id]['contacts']['full_name']= '';
		}
	}

	//rarecase
	if($project_specific == 'Y')
	{
		$query ="SELECT
		pcsmf.`project_id` as pcsmf__project_id,
		pcsmf.`contact_id` as pcsmf__contact_id,
		pcsmf.`software_module_function_id` as pcsmf__software_module_function_id,


		cc.`id` as cc__id, 
		cc.`user_user_company_id` as cc__user_user_company_id, 
		cc.`contact_user_company_id` as cc__contact_user_company_id, 
		cc.`company` as cc__company, 
		cc.`primary_phone_number` as cc__primary_phone_number, 
		cc.`employer_identification_number` as cc__employer_identification_number, 
		cc.`construction_license_number` as cc__construction_license_number, 
		cc.`construction_license_number_expiration_date` as cc__construction_license_number_expiration_date, 
		cc.`vendor_flag` as cc__vendor_flag ,

		c.* 

		from  `projects_to_contacts_to_software_module_functions` as pcsmf  inner join `contacts` as c on pcsmf.contact_id =c.id 
		inner join `contact_companies` as cc on c.contact_company_id =cc.id where pcsmf.`software_module_function_id` IN ($software_module_functionId)  and c.`user_company_id`='$user_company_id' and pcsmf.project_id='$project_id' and c.`is_archive` = 'N'";
			// $arrValues = array($software_module_functionId,$user_company_id,$project_id);
		
	}else
	{
		$query ="SELECT
		
		pcsmf.`contact_id` as pcsmf__contact_id,
		pcsmf.`software_module_function_id` as pcsmf__software_module_function_id,


		cc.`id` as cc__id, 
		cc.`user_user_company_id` as cc__user_user_company_id, 
		cc.`contact_user_company_id` as cc__contact_user_company_id, 
		cc.`company` as cc__company, 
		cc.`primary_phone_number` as cc__primary_phone_number, 
		cc.`employer_identification_number` as cc__employer_identification_number, 
		cc.`construction_license_number` as cc__construction_license_number, 
		cc.`construction_license_number_expiration_date` as cc__construction_license_number_expiration_date, 
		cc.`vendor_flag` as cc__vendor_flag ,

		c.* 

		from  `contacts_to_software_module_functions` as pcsmf  inner join `contacts` as c on pcsmf.contact_id =c.id 
		inner join `contact_companies` as cc on c.contact_company_id =cc.id where pcsmf.`software_module_function_id` IN ($software_module_functionId)  and c.`user_company_id`='$user_company_id' and c.`is_archive` = 'N'";
	}

	$db->execute($query);
	while($row = $db->fetch())
	{
		$contact_id = $row['id'];

		$contactRolearray[$contact_id]['contacts']['email']= $row['email'];
		$contactRolearray[$contact_id]['contacts']['first_name']= $row['first_name'];
		$contactRolearray[$contact_id]['contacts']['last_name']= $row['last_name'];
		$contactRolearray[$contact_id]['contacts']['company']= $row['cc__company'];
		$fun_id = $row['pcsmf__software_module_function_id'];

		$contactRolearray[$contact_id]['modules'][$fun_id]= $fun_id;
		$contactRolearray[$contact_id]['roles']="";
		
		if($row['first_name']!=="" && $row['last_name']!="")
		{
			$contactRolearray[$contact_id]['contacts']['full_name']=$row['first_name'].' '.$row['last_name'];
		}else
		{
			$contactRolearray[$contact_id]['contacts']['full_name']= '';
		}
	}
	$db->free_result();

	return $contactRolearray;

}

function contactPermissionForSoftwareModules($database,$user_company_id,$software_module_functionId,$project_specific,$project_id)
{
	//For  non specific roles and should not consider user access

	$db = DBI::getInstance($database);
	$query ="SELECT rsmf.`user_company_id` as  rsmf__user_company_id, 
	rsmf.`role_id` as  rsmf__role_id, 
	rsmf.`software_module_function_id` as  rsmf__software_module_function_id, 
	rsmf.`is_global_admin`as  rsmf__is_global_admin,

	cr.`contact_id` as cr__contact_id, 
	cr.`role_id` as cr__role_id,

	r.`id` as r__id, 
	r.`role` as r__role, 
	r.`role_description` as r__role_description, 
	r.`project_specific_flag` as r__project_specific_flag, 
	r.`sort_order` as r__sort_order,

	cc.`id` as cc__id, 
	cc.`user_user_company_id` as cc__user_user_company_id, 
	cc.`contact_user_company_id` as cc__contact_user_company_id, 
	cc.`company` as cc__company, 
	cc.`primary_phone_number` as cc__primary_phone_number, 
	cc.`employer_identification_number` as cc__employer_identification_number, 
	cc.`construction_license_number` as cc__construction_license_number, 
	cc.`construction_license_number_expiration_date` as cc__construction_license_number_expiration_date, 
	cc.`vendor_flag` as cc__vendor_flag ,

	c.* 

	from `roles_to_software_module_function_templates` as rsmf 
	INNER JOIN `contacts_to_roles` as cr on rsmf.`role_id` = cr.`role_id` inner join `contacts` as c on cr.contact_id =c.id 
	inner join `roles` as r on cr.`role_id` = r.id 
	inner join `contact_companies` as cc on c.contact_company_id =cc.id where rsmf.`software_module_function_id` IN ($software_module_functionId) and rsmf.`user_company_id` = '$user_company_id' and c.`user_company_id`='$user_company_id' and c.`is_archive` = 'N'  ";
	// $arrValues = array($software_module_functionId, $user_company_id,$user_company_id);
	// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->execute($query);
	
	

	while($row = $db->fetch())
	{
		
		
		$contact_id = $row['cr__contact_id'];
		$role_id = $row['r__id'];
		$fun_id = $row['rsmf__software_module_function_id'];

		$contactRolearray[$contact_id]['modules'][$fun_id][$role_id]= $row['r__role'];
		$contactRolearray[$contact_id]['roles'][$role_id]['rol_name']=$row['r__role'];
		$contactRolearray[$contact_id]['roles'][$role_id]['modules'][$fun_id]= $fun_id;

		$contactRolearray[$contact_id]['contacts']['email']= $row['email'];
		$contactRolearray[$contact_id]['contacts']['first_name']= $row['first_name'];
		$contactRolearray[$contact_id]['contacts']['last_name']= $row['last_name'];
		$contactRolearray[$contact_id]['contacts']['company']= $row['cc__company'];

		
		
		if($row['first_name']!=="" && $row['last_name']!="")
		{
			$contactRolearray[$contact_id]['contacts']['full_name']=$row['first_name'].' '.$row['last_name'];
		}else
		{
			$contactRolearray[$contact_id]['contacts']['full_name']= '';
		}
		
	} 
	

	$db->free_result();

	//For project specific roles  and should not consider user access		
	$query1 ="SELECT rsmf.`user_company_id` as  rsmf__user_company_id, 
	rsmf.`role_id` as  rsmf__role_id, 
	rsmf.`software_module_function_id` as  rsmf__software_module_function_id, 
	rsmf.`is_global_admin`as  rsmf__is_global_admin,

	
	pr.`project_id` as pr__project_id,
	pr.`contact_id` as pr__contact_id, 
	pr.`role_id` as pr__role_id,

	r.`id` as r__id, 
	r.`role` as r__role, 
	r.`role_description` as r__role_description, 
	r.`project_specific_flag` as r__project_specific_flag, 
	r.`sort_order` as r__sort_order,

	cc.`id` as cc__id, 
	cc.`user_user_company_id` as cc__user_user_company_id, 
	cc.`contact_user_company_id` as cc__contact_user_company_id, 
	cc.`company` as cc__company, 
	cc.`primary_phone_number` as cc__primary_phone_number, 
	cc.`employer_identification_number` as cc__employer_identification_number, 
	cc.`construction_license_number` as cc__construction_license_number, 
	cc.`construction_license_number_expiration_date` as cc__construction_license_number_expiration_date, 
	cc.`vendor_flag` as cc__vendor_flag ,

	c.* 

	from `roles_to_software_module_function_templates` as rsmf 
	INNER JOIN `projects_to_contacts_to_roles` as pr on rsmf.`role_id` = pr.`role_id` inner join `contacts` as c on pr.contact_id =c.id 
	inner join `roles` as r on pr.`role_id` = r.id 
	inner join `contact_companies` as cc on c.contact_company_id =cc.id where rsmf.`software_module_function_id` IN ($software_module_functionId) and rsmf.`user_company_id` = '$user_company_id' and c.`user_company_id`='$user_company_id' and c.`is_archive` = 'N'";
	// $arrValues = array($user_company_id, $software_module_id,$software_module_functionId,$primary_contact_id,$project_id);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$db->execute($query1);
	while($row = $db->fetch())
	{
		$contact_id = $row['pr__contact_id'];
		$role_id = $row['r__id'];
		$fun_id = $row['rsmf__software_module_function_id'];

		$contactRolearray[$contact_id]['modules'][$fun_id][$role_id]= $row['r__role'];
		$contactRolearray[$contact_id]['roles'][$role_id]['modules'][$fun_id]=$fun_id;
		$contactRolearray[$contact_id]['roles'][$role_id]['rol_name']=$row['r__role'];

		$contactRolearray[$contact_id]['contacts']['email']= $row['email'];
		$contactRolearray[$contact_id]['contacts']['first_name']= $row['first_name'];
		$contactRolearray[$contact_id]['contacts']['last_name']= $row['last_name'];
		$contactRolearray[$contact_id]['contacts']['company']= $row['cc__company'];
		if($row['first_name']!=="" && $row['last_name']!="")
		{
			$contactRolearray[$contact_id]['contacts']['full_name']=$row['first_name'].' '.$row['last_name'];
		}else
		{
			$contactRolearray[$contact_id]['contacts']['full_name']= '';
		}
	}

	//rarecase
	if($project_specific == 'Y')
	{
		$query ="SELECT
		pcsmf.`project_id` as pcsmf__project_id,
		pcsmf.`contact_id` as pcsmf__contact_id,
		pcsmf.`software_module_function_id` as pcsmf__software_module_function_id,


		cc.`id` as cc__id, 
		cc.`user_user_company_id` as cc__user_user_company_id, 
		cc.`contact_user_company_id` as cc__contact_user_company_id, 
		cc.`company` as cc__company, 
		cc.`primary_phone_number` as cc__primary_phone_number, 
		cc.`employer_identification_number` as cc__employer_identification_number, 
		cc.`construction_license_number` as cc__construction_license_number, 
		cc.`construction_license_number_expiration_date` as cc__construction_license_number_expiration_date, 
		cc.`vendor_flag` as cc__vendor_flag ,

		c.* 

		from  `projects_to_contacts_to_software_module_functions` as pcsmf  inner join `contacts` as c on pcsmf.contact_id =c.id 
		inner join `contact_companies` as cc on c.contact_company_id =cc.id where pcsmf.`software_module_function_id` IN ($software_module_functionId)  and c.`user_company_id`='$user_company_id' and pcsmf.project_id='$project_id' and c.`is_archive` = 'N'";
			// $arrValues = array($software_module_functionId,$user_company_id,$project_id);
		
	}else
	{
		$query ="SELECT
		
		pcsmf.`contact_id` as pcsmf__contact_id,
		pcsmf.`software_module_function_id` as pcsmf__software_module_function_id,


		cc.`id` as cc__id, 
		cc.`user_user_company_id` as cc__user_user_company_id, 
		cc.`contact_user_company_id` as cc__contact_user_company_id, 
		cc.`company` as cc__company, 
		cc.`primary_phone_number` as cc__primary_phone_number, 
		cc.`employer_identification_number` as cc__employer_identification_number, 
		cc.`construction_license_number` as cc__construction_license_number, 
		cc.`construction_license_number_expiration_date` as cc__construction_license_number_expiration_date, 
		cc.`vendor_flag` as cc__vendor_flag ,

		c.* 

		from  `contacts_to_software_module_functions` as pcsmf  inner join `contacts` as c on pcsmf.contact_id =c.id 
		inner join `contact_companies` as cc on c.contact_company_id =cc.id where pcsmf.`software_module_function_id` IN ($software_module_functionId)  and c.`user_company_id`='$user_company_id' and c.`is_archive` = 'N'";
	}

	$db->execute($query);
	while($row = $db->fetch())
	{
		$contact_id = $row['id'];

		$contactRolearray[$contact_id]['contacts']['email']= $row['email'];
		$contactRolearray[$contact_id]['contacts']['first_name']= $row['first_name'];
		$contactRolearray[$contact_id]['contacts']['last_name']= $row['last_name'];
		$contactRolearray[$contact_id]['contacts']['company']= $row['cc__company'];
		$fun_id = $row['pcsmf__software_module_function_id'];

		$contactRolearray[$contact_id]['modules'][$fun_id]= $fun_id;
		$contactRolearray[$contact_id]['roles']="";
		
		if($row['first_name']!=="" && $row['last_name']!="")
		{
			$contactRolearray[$contact_id]['contacts']['full_name']=$row['first_name'].' '.$row['last_name'];
		}else
		{
			$contactRolearray[$contact_id]['contacts']['full_name']= '';
		}
	}
	$db->free_result();
	// echo "<pre>";
	// print_r($contactRolearray);
	return $contactRolearray;

}




/*start of project specific modules*/
function SoftwareModulesListprojectspecific($database,$prj_spec,$prj_flag='1')
{
	$db = DBI::getInstance($database);
	$query ="SELECT sm.* FROM `software_modules` sm where `sm`.`project_specific_flag`=?ORDER BY `sm`.`software_module_label` ASC ";
	// `sm`.`project_specific_flag` DESC,`software_module_category_id` ASC";
	$arrSoftwareModuleOptions = array();
	// $db->execute($query);
	$arrValues = array($prj_spec);
	$db->execute($query, $arrValues);

	while ($row = $db->fetch()) {
		$software_module_id = $row['id'];
		$software_module = $row['software_module'];
		$software_module_label = $row['software_module_label'];

		if ($row['project_specific_flag'] == 'Y') {
			$prjtg = 'Project Specific';
			if($prj_flag =='1')
			{
				$newValue = $software_module_label . " &mdash; Project Specific";
			}else
			{
				$newValue = $software_module_label ;
			}
			$software_module_value = $software_module_id.'_'.'Y';
		} else {
			$prjtg = 'Not Project Specific';
			if($prj_flag =='1')
			{
				$newValue = $software_module_label . " &mdash; Not Project Specific";
			}else
			{
				$newValue = $software_module_label;
			}
			$software_module_value = $software_module_id.'_'.'N';
		}
		$arrSoftwareModuleOptions[$prjtg][$software_module_value] = $newValue;
	}
	$db->free_result();
	return $arrSoftwareModuleOptions;
}

//To list the roles associated with the modules
function projectrolesToSoftwarefunction($database,$project_id,$function_id)
{
	$db = DBI::getInstance($database);
	$query = "SELECT 

	psf.`project_id`as psf__project_id, 
	psf.`role_id`as psf__role_id, 
	psf.`software_module_function_id` as psf__software_module_function_id,
	

	r.* 

	FROM `projects_to_roles_to_software_module_functions` as psf 
	LEFT join `roles` as r on r.id = psf.role_id 
	where psf.`project_id` = '$project_id' and psf.`software_module_function_id` = '$function_id'";
	// $arrValues = array($project_id,$function_id);
	// $db->execute($query, $arrValues,MYSQLI_USE_RESULT);
	$db->execute($query);
	$Rolearr=array();
	while($row1 = $db->fetch())
	{
		$role_id = $row1['psf__role_id'];
		$Rolearr[$role_id]=$role_id;
	}
	$db->free_result();
	return $Rolearr;
}

/**
$software_module_function_id  - Software module function id, 
$RoleId - Role id ,
$insertFlagValue - whether to insert data (Y)or delete the data(N),
$project_id - Current user project id 

**/

function  UpdateProjectSpecificSoftwareFunction($database,$software_module_function_id,$RoleId,$insertFlagValue,$project_id,$is_global='N')
{

	if($insertFlagValue == 'Y')
	{
		//Insert
		$db = DBI::getInstance($database);
		$query1 ="INSERT into `projects_to_roles_to_software_module_functions` (`project_id`, `role_id`, `software_module_function_id`,`is_global_admin`) VALUES ('$project_id' ,'$RoleId' ,'$software_module_function_id' ,'$is_global')";
		// $arrValues = array($project_id,$RoleId,$software_module_function_id,$is_global);
		$db->execute($query1);
		$db->free_result();

	}else
	{
		//Delete
		$db = DBI::getInstance($database);
		//For admin
		if($is_global == 'N')
		{
			$query1 ="DELETE FROM `projects_to_roles_to_software_module_functions` WHERE `role_id`='$RoleId' and `software_module_function_id`='$software_module_function_id' and `project_id`='$project_id'  ";
			// $arrValues = array($RoleId,$software_module_function_id,$project_id);

		}else
		{
			//For Global admin
			$query1 ="DELETE FROM `projects_to_roles_to_software_module_functions` WHERE `role_id`='$RoleId' and `software_module_function_id`='$software_module_function_id' and `project_id`='$project_id' and `is_global_admin`='$is_global'  ";
			// $arrValues = array($RoleId,$software_module_function_id,$project_id,$is_global);
		}
		$db->execute($query1, $arrValues);
		$db->free_result();
	}
}

// reset project specific permission function
function projSpecificResetDefaultPermissions($database,$software_module_id,$project_id){

	$db = DBI::getInstance($database);

	$query1 ="DELETE FROM `projects_to_roles_to_software_module_functions` WHERE `software_module_function_id` IN ($software_module_id) and `project_id`= ? ";
	$arrMoudle1 = array($project_id);
	$db->execute($query1, $arrMoudle1);
	$db->free_result();

	$query2 = "
INSERT INTO `projects_to_roles_to_software_module_functions` (`project_id`, `role_id`, `software_module_function_id`, `is_global_admin`)
SELECT $project_id, role_id, software_module_function_id, is_global_admin
FROM `projects_to_roles_to_software_module_functions`
WHERE `software_module_function_id` IN ($software_module_id) AND `project_id`= ?";
	$arrMoudle2 = array(1);
	$db->execute($query2,$arrMoudle2);
	$db->free_result();
}

// reset Non project specific permission function
function projNonSpecificResetDefaultPermissions($database,$software_module_id,$user_company_id){
	
	$db = DBI::getInstance($database);	

	$query1 ="DELETE FROM `roles_to_software_module_function_templates` WHERE `software_module_function_id` IN ($software_module_id) and `user_company_id`= ? ";
	$arrMoudle1 = array($user_company_id);
	$db->execute($query1, $arrMoudle1);
	$db->free_result();

	$query2 = "
INSERT INTO `roles_to_software_module_function_templates` (`user_company_id`, `role_id`, `software_module_function_id`, `is_global_admin`)
SELECT $user_company_id, role_id, software_module_function_id, is_global_admin
FROM `roles_to_software_module_function_templates`
WHERE `software_module_function_id` IN ($software_module_id) AND `user_company_id`= ?";
	$arrMoudle2 = array(1);
	$db->execute($query2,$arrMoudle2);
	$db->free_result();		
}
/* End of project spefic modules*/
// to check whether the user has the project access
	 function projectAccessForUser($database,$project_id,$contact_id)
	{
		$db = DBI::getInstance($database);
		// to get the userid of the contact id
		 $query ="SELECT user_id FROM `contacts` WHERE `id` = ? ";
		 $arrValues = array($contact_id);
		 $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			
		$row = $db->fetch();
		$user_id = $row['user_id'];
		$db->free_result();
		//to get all the contact id of the userid
		 $query ="SELECT group_concat(id) as new_contact FROM `contacts` WHERE `user_id` = ? ";
		 $arrValues = array($user_id);
		 $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			
		$row = $db->fetch();
		$new_contact = $row['new_contact'];
		$db->free_result();

                 //check whether the contact has the access
		$query ="SELECT * FROM `projects_to_contacts_to_roles` WHERE `contact_id` in ($new_contact) and project_id=? ";
			$arrValues = array($project_id);
			
		
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row) {
			return true;
		}else{
			return false;
		}

	}

/**
* Check Permission for Module using project id by currently active user
* @param software_module_function
* @param project_id
* @return boolean
*/

function checkPermissionUsingProjectId($database, $software_module_function, $project_id){
	$database = DBI::getInstance($database);	
	$session = Zend_Registry::get('session');
	$userRole = $session->getUserRole();
	// if($userRole =="global_admin")
	// {
	// 	return true;
	// }
	$primary_contact_id = $session->getPrimaryContactId();
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
	$user_company_id = $session->getUserCompanyId();
	$currentlySelectedProjectId = (int)$session->getCurrentlySelectedProjectId();
	$currentlySelectedProjectUserCompanyId = (int)$session->getCurrentlySelectedProjectUserCompanyId();
	$software_module_functionId  = SoftwareModuleFunction::getIdbyfunctionName($software_module_function,$database);

	$db = DBI::getInstance($database);
	$query =
"
SELECT p2r2smf.`project_id`,p2r2smf.`role_id`,p2r2smf.`software_module_function_id` 
FROM `projects_to_contacts_to_roles` as p2c2r, 
	 `projects_to_roles_to_software_module_functions` p2r2smf
WHERE p2c2r.`project_id` = ?
		AND p2c2r.`contact_id` = ?
		AND p2r2smf.`project_id` = p2c2r.`project_id`
		AND p2r2smf.`role_id` = p2c2r.`role_id`
		AND p2r2smf.`software_module_function_id` = ?
";
	$arrValues = array($project_id,$currentlyActiveContactId,$software_module_functionId);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();
	if ($row) {
		return true;
	}else{
		return false;
	}
}

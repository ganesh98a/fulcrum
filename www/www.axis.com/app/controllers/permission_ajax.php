<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');


// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

require_once('lib/common/Message.php');
require_once('lib/common/Contact.php');
require_once('lib/common/SoftwareModuleFunction.php');

$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);
require_once('../models/permission_mdl.php');
require_once('../controllers/permission_cntrl.php');

$timer->startTimer();
$_SESSION['timer'] = $timer;
// SESSION VARIABLES
/* @var $session Session */
$userRole = $session->getUserRole();
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern`

switch ($methodCall) {

	case 'softwarefunctionformodule':

	$module_id=(int)$get->module_id;
    $res_function = FetchsoftwaremoduleFucntion($database,$module_id);
    echo $res_function;
	break;

    case 'Insertsoftwarefunctionformodule':

    $role_ids=$get->role_ids;
    $function_ids = $get->function_ids;
    $allcompany = $get->allcompany;
    $compy_list = $get->compy_list;
    $compy_list_arr =array();
    if($compy_list !="undefined"){
    $compy_list_arr  = explode(',', $compy_list);
    }
 
    $arr_role_ids = json_decode($role_ids, TRUE);
    $arr_function_ids = json_decode($function_ids, TRUE);
    //To give access for only the selected companies
     if(!empty($compy_list_arr))
        {
           foreach ($compy_list_arr as $key1 => $list) {
              InsertRoletosoftwarefunctionformodule($database,$list,$arr_role_ids,$arr_function_ids,$allcompany);
            }
        }else if($allcompany == 'Y')
        {
       
         //To give access for  all the companies (GA)   
        $arrcompany =  ListofallCompanies($database);
        foreach ($arrcompany as $key => $com_id) {
    
        InsertRoletosoftwarefunctionformodule($database,$key,$arr_role_ids,$arr_function_ids,$allcompany);
        }
    }else
    {
        //To give acces only for the current company
         InsertRoletosoftwarefunctionformodule($database,$user_company_id,$arr_role_ids,$arr_function_ids,$allcompany);
      
    }

    break;

    case 'showNewRolesDialog':

    $defDialog = loadNewRolesDialog($database);
    echo $defDialog;
    break;

    case 'InsertNewRoles':
    $role_name = $get->role_name;
    $role_desp = $get->role_desp;
    $prj_specfic = $get->prj_specfic;
    $res_function = InsertSystemRoles($database,$role_name,$role_desp,$prj_specfic);
    echo $res_function;
    break;

    case 'permissionlist':
       $letter = $get->letter;
       $specify_flag = $get->specify_flag;
       $rolespec = $get->role;
       
       if($userRole == 'global_admin')
       {
            $resultroles =  rolesAssociatedWithPermission($database,$user_company_id,$userRole,$letter,$specify_flag,$rolespec);
        }else 
        {
            $resultroles = rolesAssociatedWithPermissionforAdmin($database,$user_company_id,$userRole,$letter,$specify_flag,$rolespec);
        }
       echo $resultroles;

    break;

    case 'updateRolePerFunc':
    $input_id = $get->inputId;
    $isChecked = $get->isChecked;
    $global_flag = $get->global_flag;
    $arrInput = explode('-', $input_id);
    $software_module_function_id = $arrInput[1];
    $RoleId = $arrInput[2];

    if ($isChecked == 'true') {
        $insertFlagValue = 'Y';
    } else {
        $insertFlagValue = 'N';
    }

    if($global_flag == 'Y')
    {
        $updatestatus = UpdateRolePermissionSoftwareFunctionAsGlobalAdmin($database,$software_module_function_id,$RoleId,$insertFlagValue,$global_flag,$user_company_id);
    }else
    {
    $updatestatus = UpdateRolePermissionSoftwareFunctionAsAdmin($database,$software_module_function_id,$RoleId,$insertFlagValue,$global_flag,$user_company_id);
    }

    break;

    case 'updateRoleprereqsanddependent':

    $isChecked = $get->isChecked;
    $global_flag = $get->global_flag;
    $software_module_function_id = $get->software_module_function_id;
    $RoleId = $get->RoleId;

    if ($isChecked == 'true') {
        $insertFlagValue = 'Y';
    } else {
        $insertFlagValue = 'N';
    }

    if($global_flag == 'Y')
    {
        $updatestatus = UpdateRolePermissionSoftwareFunctionAsGlobalAdmin($database,$software_module_function_id,$RoleId,$insertFlagValue,$global_flag,$user_company_id);
    }else
    {
    $updatestatus = UpdateRolePermissionSoftwareFunctionAsAdmin($database,$software_module_function_id,$RoleId,$insertFlagValue,$global_flag,$user_company_id);
    }
    break;

    case 'Rarecasepermission':

    $isChecked = $get->isChecked;
    $prjspec = $get->prjspec;
    $softmodid = $get->softmodid;
    $conid = $get->conid;

    RarecasePermissionUpdation($database,$softmodid,$prjspec,$conid,$project_id,$isChecked);
  
    break;

    case 'rarescenariopermissionajax':

    $prjspec = $get->prjspec;
    $softmodid = $get->softmodid;
    if($prjspec =='N')
    {
        $project_id='0';
    }

    $res_permission = permissionRareCaseScenario($database,$softmodid,$user_company_id,$project_id);
    echo $res_permission;
    break;

    case 'gridfornonprojectspecify':
    $softmodid = $get->softmodid;
    $permissionContact = permissionForContacts($database,$softmodid,$user_company_id);    
    echo $permissionContact;
    break;

    /*start of project specific */
    case 'projectspecificpermission':

        $letter = $get->letter;
        $rolespec = $get->role; 
        $specify_flag = $get->specify_flag;

    
        $resultroles = rolesprojectAssociatedWithPermission($database,$user_company_id,$userRole,$letter,$specify_flag,$rolespec,$project_id);
        echo $resultroles;
    break;

    case 'updateprojectspecificRoles':
    $input_id = $get->inputId;
    $isChecked = $get->isChecked;
    $arrInput = explode('-', $input_id);
    $software_module_function_id = $arrInput[1];
    $RoleId = $arrInput[2];

    if ($isChecked == 'true') {
        $insertFlagValue = 'Y';
    } else {
        $insertFlagValue = 'N';
    }
    
    $updatestatus = UpdateProjectSpecificSoftwareFunction($database,$software_module_function_id,$RoleId,$insertFlagValue,$project_id);
    break;
   

    case 'gridforprojectspecifymodule':
    $softmodid = $get->softmodid;
    $permissionContact = permissionForContacts($database,$softmodid,$user_company_id,'project_specific');    
    echo $permissionContact;
    break;

    // reset project specific permission ajax
    case 'projectSpecificResetDefaultPermissionsAjax':
        $softmodid = SoftwareModuleFunction::getSoftwareModuleFunctionId($database,$get->softmodid);
        $permissionContact = projSpecificResetDefaultPermissions($database,$softmodid,$project_id);
    break;

    // reset Non project specific permission ajax
    case 'projectNonSpecificResetDefaultPermissionsAjax':
        $softmodid = SoftwareModuleFunction::getSoftwareModuleFunctionId($database,$get->softmodid);
        $permissionContact = projNonSpecificResetDefaultPermissions($database,$softmodid,$user_company_id);
    break;

    /*End of project specific*/


		
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}

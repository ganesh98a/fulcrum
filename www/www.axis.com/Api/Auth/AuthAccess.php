<?php
require_once('lib/common/User.php');
require_once('lib/common/Project.php');
require_once('lib/common/UserCompany.php');
require_once('lib/common/Authorization.php');
$HTTP_HEADERSCUS = getallheaders();
// respond to preflights
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  // return only the headers and not the content
  // only allow CORS if we're doing a GET - i.e. no saving for now.
  /*if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) &&
  $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {*/
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS");
    header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
  // }
  // print_r($HTTP_HEADERSCUS);
    exit;
  }

  /** 
 * Get header Authorization
 * */
  function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
      $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
      $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
      $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
      $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
      if (isset($requestHeaders['Authorization'])) {
        $headers = trim($requestHeaders['Authorization']);
      }
    }
    return $headers;
  }
/**
 * get access token from header
 * */
$headers = getAuthorizationHeader();
  // HEADER: Get the access token from the header
if (!empty($headers)) {
  if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
    $RN_token =  $matches[1];
  } else {
    // $RN_token = null;
  }
} else {
  // $RN_token = null;
}

/*if (isset($HTTP_HEADERSCUS["Authorization"])) {
 list($type, $data) = explode(" ", $HTTP_HEADERSCUS["Authorization"], 2);
 if (strcasecmp($type, "Bearer") == 0) {
   $RN_token = $data;
 } else {
   $RN_token = null;
 }
} else {
 $RN_token = null;
}*/

if($RN_token == null || $RN_token == ''){
 header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
 $RN_jsonEC['err_message'] = 'Token value is Null';
 /*encode the array*/
 $RN_jsonEC = json_encode($RN_jsonEC);
 /*echo the json response*/
 echo $RN_jsonEC;
 exit(0);
}
else
{ 
 $user = User::findUserByPWDGuidAuthentication($database, $RN_token, true);
}

if($user){
 if(isset($RN_params['impersonate_user_id']) && $RN_params['impersonate_user_id']!=null) {
  $RN_impersonated_user_id = $RN_params['impersonate_user_id'];
}else{
  $RN_impersonated_user_id = null;
}

$RN_jsonEC['status'] = 200;
  // $RN_jsonEC['access_token'] = $user->password_guid;
$RN_jsonEC['message'] = "Token is valid";
/*Project details*/
  // $RN_jsonEC['data']['projects'] = array_values($user->getArrOwnedProjects());
/*user details*/
$RN_arrayTemp = array();
$RN_arrayTempVal = 0;
/*actual data*/
$RN_arrayTemp[$RN_arrayTempVal]['actual_company_id'] = $user->user_company_id;
$RN_arrayTemp[$RN_arrayTempVal]['actual_user_id'] = $user->user_id;
$RN_arrayTemp[$RN_arrayTempVal]['actual_role_id'] = $user->role_id;
$RN_arrayTemp[$RN_arrayTempVal]['actual_primary_contact_id'] = (int) $user->primary_contact_id;
$RN_arrayTemp[$RN_arrayTempVal]['actual_user_role'] = $user->getUserRole();
$RN_actualUserRole = $user->getUserRole();
$RN_arrayTemp[$RN_arrayTempVal]['actual_login_name'] = $user->email;
$RN_arrayTemp[$RN_arrayTempVal]['actualCurrentlySelectedProjectUserCompanyId'] = $user->currentlySelectedProjectUserCompanyId;
$RN_arrayTemp[$RN_arrayTempVal]['actualCurrentlySelectedProjectId'] = $user->currentlySelectedProjectId;
$RN_arrayTemp[$RN_arrayTempVal]['actualCurrentlySelectedProjectName'] = $user->currentlySelectedProjectName;
$RN_arrayTemp[$RN_arrayTempVal]['actualCurrentlyActiveContactId'] = $user->currentlyActiveContactId;
$RN_arrayTemp[$RN_arrayTempVal]['actualCurrentlyActiveTemplateTheme'] = $user->currentlyActiveTemplateTheme;

if(isset($RN_impersonated_user_id) && $RN_impersonated_user_id!=null && $RN_impersonated_user_id !=''){
    // $user = User::recordUserLogin($database, $RN_impersonate_user_id);
  $RN_impersonatedUser = User::findUserById($database, $RN_impersonated_user_id, true);
  $RN_impersonatedLoginName = $RN_impersonatedUser->email;
  $RN_impersonated_role_id = $RN_impersonatedUser->role_id;
  $RN_impersonated_user_company_id = $RN_impersonatedUser->user_company_id;
    // Get the userRole for the user being impersonated
  $RN_auth = Authorization::authorizeUser($database, $RN_impersonated_user_id, $RN_impersonated_user_company_id);
  /* @var $auth Authorization */
  $impersonatedUserRole = $RN_auth->getUserRole();
  $user = $RN_impersonatedUser;
}
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user->user_company_id);
$RN_arrayTemp[$RN_arrayTempVal]['user_company_id'] = $user->user_company_id;
$RN_arrayTemp[$RN_arrayTempVal]['user_company_name'] = $userCompany->user_company_name;
$RN_arrayTemp[$RN_arrayTempVal]['user_id'] = $user->user_id;  
$RN_arrayTemp[$RN_arrayTempVal]['role_id'] = $user->role_id;  
$RN_arrayTemp[$RN_arrayTempVal]['user_role'] = $user->getUserRole();  
$RN_arrayTemp[$RN_arrayTempVal]['primary_contact_id'] = (int) $user->primary_contact_id;
$RN_arrayTemp[$RN_arrayTempVal]['active_contact_id'] = (int) $user->currentlyActiveContactId;
$RN_arrayTemp[$RN_arrayTempVal]['default_project_id'] = $user->default_project_id;
$RN_arrayTemp[$RN_arrayTempVal]['screen_name'] = $user->screen_name;
$RN_arrayTemp[$RN_arrayTempVal]['mobile_phone_number'] = $user->mobile_phone_number;
$RN_arrayTemp[$RN_arrayTempVal]['email'] = $user->email;  
$RN_arrayTemp[$RN_arrayTempVal]['login_name'] = $user->email;
$RN_arrayTemp[$RN_arrayTempVal]['password_hash'] = $user->password_hash;
$RN_arrayTemp[$RN_arrayTempVal]['password_guid'] = $user->password_guid;
$RN_arrayTemp[$RN_arrayTempVal]['change_password_flag'] = $user->change_password_flag;
$RN_arrayTemp[$RN_arrayTempVal]['security_phrase'] = $user->security_phrase;
$RN_arrayTemp[$RN_arrayTempVal]['modified'] = $user->modified;
$RN_arrayTemp[$RN_arrayTempVal]['accessed'] = $user->accessed;
$RN_arrayTemp[$RN_arrayTempVal]['created'] = $user->created;
$RN_arrayTemp[$RN_arrayTempVal]['tc_accepted_flag'] = $user->tc_accepted_flag;
$RN_arrayTemp[$RN_arrayTempVal]['remember_me_flag'] = $user->remember_me_flag;
$RN_arrayTemp[$RN_arrayTempVal]['disabled_flag'] = $user->disabled_flag;
$RN_arrayTemp[$RN_arrayTempVal]['deleted_flag'] = $user->deleted_flag;
$RN_arrayTemp[$RN_arrayTempVal]['currentlySelectedProjectUserCompanyId'] = $user->currentlySelectedProjectUserCompanyId;
if($RN_project_id){
    // Something went wrong, but load the project record anyway
  $project = Project::findProjectById($database, $RN_project_id);
  /* @var $project Project */
      // print_r($project);
      // $arrProject = $project->getData();
  $arrProject = $project;
  $currentlySelectedProjectUserCompanyId = $arrProject['user_company_id'];
  $currentlySelectedProjectName = $arrProject['project_name'];
  $currentlySelectedProjectId = $arrProject['id'];

  require_once('lib/common/Contact.php');
  $contact = Contact::findContactByUserCompanyIdAndUserId($database, $currentlySelectedProjectUserCompanyId, $user->user_id);
  /* @var $contact Contact */
  $currentlyActiveContactId = '';
  if (isset($contact) && !empty($contact)) {
    $currentlyActiveContactId = $contact->contact_id;  
  }
  

  /*inject $user*/
  $user->currentlySelectedProjectId = $currentlySelectedProjectId;
  $user->currentlySelectedProjectName = $currentlySelectedProjectName;
  $user->currentlyActiveContactId = $currentlyActiveContactId;

}
$RN_arrayTemp[$RN_arrayTempVal]['currentlySelectedProjectId'] = $user->currentlySelectedProjectId;
$RN_arrayTemp[$RN_arrayTempVal]['currentlySelectedProjectName'] = $user->currentlySelectedProjectName;
$RN_arrayTemp[$RN_arrayTempVal]['currentlyActiveContactId'] = $user->currentlyActiveContactId;
$RN_arrayTemp[$RN_arrayTempVal]['currentlyActiveTemplateTheme'] = $user->currentlyActiveTemplateTheme;


  // $RN_arrayTemp[$RN_arrayTempVal]['projects'] = array_values($user->getArrOwnedProjects());
/*projects*/
$RN_user_company_id = $user->user_company_id;
$RN_user_id = $user->user_id;
$RN_primary_contact_id = (int)$user->primary_contact_id;
$RN_userRole = $user->getUserRole();
$RN_currentlySelectedProjectId='';
$RN_currentlySelectedProjectName='';
    // $RN_currentlySelectedProjectId = $user->currentlySelectedProjectId;
    // $RN_currentlyActiveContactId = $user->currentlyActiveContactId;

$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

$RN_arrActiveProjects = array();
$RN_arrBiddingProjects = array();
$RN_arrCompletedProjects = array();
$RN_arrOtherProjects = array();
$RN_currentlySelectedProjectTypeIndex = -1;
$RN_arrProjectsArray = array();
  // We always attempt to load projects that are "Owned Projects" if the users' company is a paying customer
$RN_userCompany = new UserCompany($database);
$RN_key = array('id' => $RN_user_company_id);
$RN_userCompany->setKey($RN_key);
$RN_userCompany->load();
$RN_userCompany->convertDataToProperties();
$RN_paying_customer_flag = $RN_userCompany->paying_customer_flag;

$RN_arrOwnedProjects = Project::loadOwnedProjects($database, $RN_userRole, $RN_user_company_id, $RN_user_id, $RN_primary_contact_id);

foreach ($RN_arrOwnedProjects as $RN_arrProjectData) {
  $RN_tmpProjectId = $RN_arrProjectData['id'];
  $RN_project_name = $RN_arrProjectData['project_name'];
  $RN_is_active = $RN_arrProjectData['is_active_flag'];
  $RN_is_internal = $RN_arrProjectData['is_internal_flag'];
  $RN_project_completed_date = $RN_arrProjectData['project_completed_date'];
  $RN_arrProjectsArray[] = $RN_tmpProjectId;
  if ($RN_is_active == 'Y') {
   $RN_arrActiveProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name;
   $RN_arrActiveProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;
   $RN_projectTypeIndex = 0;

 } elseif ($RN_is_internal == 'Y') {
   $RN_arrBiddingProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name;
   $RN_arrBiddingProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;
   $RN_projectTypeIndex = 1;

 } elseif ($RN_project_completed_date != '0000-00-00') {
   $RN_arrCompletedProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name;
   $RN_arrCompletedProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;
   $RN_projectTypeIndex = 2;

 } else {
   $RN_arrOtherProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name;
   $RN_arrOtherProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;
   $RN_projectTypeIndex = 3;
 }

 if ($RN_tmpProjectId == $RN_currentlySelectedProjectId) {
   $RN_currentlySelectedProjectTypeIndex = $RN_projectTypeIndex;
   $RN_currentlySelectedProjectName = $RN_project_name;
 }
}


// Load "Guest Projects" where the user_id is linked to a contact_id in a third-party contacts list
$RN_arrGuestProjects = Project::loadGuestProjects($database, $RN_user_company_id, $RN_user_id, $RN_primary_contact_id);

foreach ($RN_arrGuestProjects as $RN_arrProjectData) {
  $RN_tmpProjectId = $RN_arrProjectData['id'];
  $RN_project_name = $RN_arrProjectData['project_name'];
  $RN_is_active = $RN_arrProjectData['is_active_flag'];
  $RN_is_internal = $RN_arrProjectData['is_internal_flag'];
  $RN_project_completed_date = $RN_arrProjectData['project_completed_date'];
  $RN_arrProjectsArray[] = $RN_tmpProjectId;
  if ($RN_debugMode) {
   $RN_project_name = "($RN_tmpProjectId) $RN_project_name";
 }

 if ($RN_is_active == 'Y') {
   $RN_arrActiveProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name. " ***";
   $RN_arrActiveProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;
   $RN_projectTypeIndex = 0;

 } elseif ($RN_is_internal == 'Y') {
   $RN_arrBiddingProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name. " ***";
   $RN_arrBiddingProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;
   $RN_projectTypeIndex = 1;

 } elseif ($RN_project_completed_date != '0000-00-00') {
   $RN_arrCompletedProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name. " ***";
   $RN_arrCompletedProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;
   $RN_projectTypeIndex = 2;

 } else {
   $RN_arrOtherProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name. " ***";
   $RN_arrOtherProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;

   $RN_projectTypeIndex = 3;
 }

 if ($RN_tmpProjectId == $RN_currentlySelectedProjectId) {
   $RN_currentlySelectedProjectTypeIndex = $RN_projectTypeIndex;
   $RN_currentlySelectedProjectName = $RN_project_name . " ***";
 }
}

  // Load "Guest Projects" that the user has been invited to bid through the purchasing module
$RN_arrGuestProjects = Project::loadGuestProjectsWhereContactHasBeenInvitedToBidThroughThePurchasingModule($database, $RN_user_company_id, $RN_user_id, $RN_primary_contact_id);

foreach ($RN_arrGuestProjects as $RN_arrProjectData) {
  $RN_tmpProjectId = $RN_arrProjectData['id'];
  $RN_project_name = $RN_arrProjectData['project_name'];
  $RN_is_active = $RN_arrProjectData['is_active_flag'];
  $RN_is_internal = $RN_arrProjectData['is_internal_flag'];
  $RN_project_completed_date = $RN_arrProjectData['project_completed_date'];
  $RN_arrProjectsArray[] = $RN_tmpProjectId;
  unset($RN_arrActiveProjects[$RN_tmpProjectId]);
  $RN_arrBiddingProjects[$RN_tmpProjectId]['project_name'] = $RN_project_name. " ***";
  $RN_arrBiddingProjects[$RN_tmpProjectId]['project_id'] = $RN_tmpProjectId;
  $RN_projectTypeIndex = 1;

  if ($RN_tmpProjectId == $RN_currentlySelectedProjectId) {
   $RN_currentlySelectedProjectTypeIndex = $RN_projectTypeIndex;
   $RN_currentlySelectedProjectName = $RN_project_name . " ***";
 }
}

  // If they have a project set in the session then load it.
if (($RN_currentlySelectedProjectId != $AXIS_NON_EXISTENT_PROJECT_ID) || $RN_userRole == "global_admin") {
  $RN_showProjectNavBox = true;
} else {
  // If they don't have a default project then load to the one at the top of the list.
  $RN_showProjectNavBox = false;

  if ($RN_currentlySelectedProjectTypeIndex == -1) {
   if (!empty($RN_arrActiveProjects)) {
    $RN_showProjectNavBox = true;
    $RN_currentlySelectedProjectTypeIndex = 0;
    foreach ($RN_arrActiveProjects AS $RN_project_id => $RN_projectName) {
     $RN_currentlySelectedProjectName = $RN_projectName;
     $RN_currentlySelectedProjectId = $RN_project_id;
     break;
   }
 } elseif (!empty($RN_arrBiddingProjects)) {
  $RN_showProjectNavBox = true;
  $RN_currentlySelectedProjectTypeIndex = 1;
  foreach ($RN_arrBiddingProjects AS $RN_project_id => $RN_projectName) {
   $RN_currentlySelectedProjectName = $RN_projectName;
   $RN_currentlySelectedProjectId = $RN_project_id;
   break;
 }
} elseif (!empty($RN_arrCompletedProjects)) {
  $RN_showProjectNavBox = true;
  $RN_currentlySelectedProjectTypeIndex = 2;
  foreach ($RN_arrCompletedProjects AS $RN_project_id => $RN_projectName) {
   $RN_currentlySelectedProjectName = $RN_projectName;
   $RN_currentlySelectedProjectId = $RN_project_id;
   break;
 }
} elseif (!empty($RN_arrOtherProjects)) {
  $RN_showProjectNavBox = true;
  $RN_currentlySelectedProjectTypeIndex = 3;
  foreach ($RN_arrOtherProjects AS $RN_project_id => $RN_projectName) {
   $RN_currentlySelectedProjectName = $RN_projectName;
   $RN_currentlySelectedProjectId = $RN_project_id;
   break;
 }
}
}
}
$RN_arrayTemp[$RN_arrayTempVal]['projects'] = null;
if ($RN_showProjectNavBox) {
  $RN_arrayTemp[$RN_arrayTempVal]['projects']["currentlySelectedProjectTypeIndex"] = $RN_currentlySelectedProjectTypeIndex;
  $RN_arrayTemp[$RN_arrayTempVal]['projects']["currentlySelectedProjectName"] = $RN_currentlySelectedProjectName;
  $RN_arrayTemp[$RN_arrayTempVal]['projects']["currentlySelectedProjectId"] = $RN_currentlySelectedProjectId;
  $RN_arrayTemp[$RN_arrayTempVal]['projects']['active_projects'] = array_values($RN_arrActiveProjects);
  if(empty($RN_arrActiveProjects)){
   $RN_arrayTemp[$RN_arrayTempVal]['projects']['active_projects'] = null;
 }
 $RN_arrayTemp[$RN_arrayTempVal]['projects']['bidding_projects'] = array_values($RN_arrBiddingProjects);
 if(empty($RN_arrBiddingProjects)){
   $RN_arrayTemp[$RN_arrayTempVal]['projects']['bidding_projects'] = null;
 }
 $RN_arrayTemp[$RN_arrayTempVal]['projects']['completed_projects'] = array_values($RN_arrCompletedProjects);
 if(empty($RN_arrCompletedProjects)){
   $RN_arrayTemp[$RN_arrayTempVal]['projects']['completed_projects'] = null;
 }
 $RN_arrayTemp[$RN_arrayTempVal]['projects']['other_projects'] = array_values($RN_arrOtherProjects);
 if(empty($RN_arrOtherProjects)){
   $RN_arrayTemp[$RN_arrayTempVal]['projects']['other_projects'] = null;
 }
}
$RN_user = $RN_arrayTemp[$RN_arrayTempVal];
if(isset($RN_viewImpersonate)){
  $RN_jsonEC['data']['user_data'] = $RN_arrayTemp[$RN_arrayTempVal];
}
if($RN_project_id != '' && $RN_project_id != null && $RN_project_id != 1){
  if(!in_array($RN_project_id, $RN_arrProjectsArray)){
   $RN_jsonEC['status'] = 403;
   header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
   $RN_jsonEC['message'] = null;
   $RN_jsonEC['data'] = null;
   $RN_jsonEC['err_message'] = "You don't have a permission to access this project";
   /*encode the array*/
   $RN_jsonEC = json_encode($RN_jsonEC);
   /*echo the json response*/
   echo $RN_jsonEC;
   exit(0);  
 }
}
}else{
 header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
 $RN_jsonEC['status'] = 401;
 $RN_jsonEC['err_message'] = "Invalid Token information";  
 /*encode the array*/
 $RN_jsonEC = json_encode($RN_jsonEC);
 /*echo the json response*/
 echo $RN_jsonEC;
 exit(0);
}
?>

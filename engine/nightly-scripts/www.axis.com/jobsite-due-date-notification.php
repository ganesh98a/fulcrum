<?php
/**
 * cron job to generate jobsite daily log dcr report
 */

// Secret key via url allows access to this script
try {
  $init['access_level'] = 'anon';
  $init['application'] = 'www.axis.com';
  $init['cache_control'] = 'nocache';
  $init['debugging_mode'] = true;
  $init['display'] = false;
  $init['https'] = false;
  $init['https_admin'] = true;
  $init['https_auth'] = true;
  $init['no_db_init'] = false;
  $init['override_php_ini'] = false;
  $init['sapi'] = 'cli';
  $init['skip_always_include'] = true;
  $init['timer'] = true;
  $init['timer_start'] = false;

  require_once('lib/common/init.php');
  require_once('lib/common/ActionItem.php');
  require_once('lib/common/ActionItemType.php');
  require_once('lib/common/ActionItemAssignment.php');
  require_once('lib/common/Contact.php');
  require_once('lib/common/Project.php');
  require_once('lib/common/User.php');
  require_once('lib/common/Data.php');

  require_once('lib/common/Role.php');
  require_once('lib/common/UserCompany.php');
  require_once('lib/common/MobileNetworkCarrier.php');
  require_once('lib/common/ContactCompany.php');
  require_once('lib/common/ContactCompanyOffice.php');
  require_once('lib/common/ContactAddress.php');

  require_once('lib/common/SoftwareModule.php');
  require_once('lib/common/SoftwareModuleFunction.php');
  require_once('lib/common/Api/RN_Permissions.php');
  require_once('lib/common/Api/UsersNotifications.php');
  require_once('lib/common/Api/UsersDeviceInfo.php');
  // require_once('../../firebase-push-notification.php');
  require_once('lib/common/ContactToRole.php');
  require_once('lib/common/ProjectToContactToRole.php');
  /*
  * Send notification to user logged device
  */
  function send_notification($database, $fcmToken, $title, $bodyContent, $options)
  {
    $config = Zend_Registry::get('config');
    $fcm_key = $config->firebase->fcm_api_key;
  //   $registrationIds = ;
  #prep the bundle
    $notification = array
    (
      'body'  => $bodyContent,
      'title' => $title,
      'priority' => "high",
      'color' => '#0177c1'
    );
    $message = $options;
    $fields = array
    (
      'registration_ids' => $fcmToken,
      'notification'  => $notification,
      'data'  => $options
    );
    $headers = array
    (
      'Authorization: key=' . $fcm_key,
      'Content-Type: application/json'
    );
    #Send Reponse To FireBase Server
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
    return $result;
  }
  /* 
  * Check the user have permission to view
  */
  function checkPermissionTaskSummary($database, $user, $RN_project_id) {
    // custom menu dashboard - Task Summery
    $RN_softwareModuleCategoryId = '';
    $RN_softwareModuleId = '';
    $RN_softwareModuleFunctionId = '';
    // software module
    $RN_softwareModuleName = 'Dashboard';
    $db = DBI::getInstance($database);
    $db->free_result();
    $RN_arrayTempEx = array();
    $RN_softwareModule = SoftwareModule::findBySoftwareModule($database, $RN_softwareModuleName);
    if (isset($RN_softwareModule)) {
      $RN_softwareModuleCategoryId = $RN_softwareModule->software_module_category_id;
      $RN_softwareModuleId = $RN_softwareModule->software_module_id;
      // software module function 
      $db->free_result();
      $RN_softwareModuleFunctionName = 'view_task_summary';
      $RN_softwareModuleFunction = SoftwareModuleFunction::findBySoftwareModuleIdAndSoftwareModuleFunction($database, $RN_softwareModuleId, $RN_softwareModuleFunctionName);
      if (isset($RN_softwareModuleFunction)) {
        $RN_softwareModuleFunctionId = $RN_softwareModuleFunction->software_module_function_id;
      }
      // check permission
      $db->free_result();
      $RN_Permissions = new RN_Permissions();
      $RN_task_summery_permission = $RN_Permissions->checkDelayPermission($database, $RN_softwareModuleFunctionName, $user, $RN_softwareModuleFunctionId, $RN_softwareModuleId, $RN_project_id);  

      // check the reole if bidder or subcontract restrict the permission
      $RN_currentlyActiveContactId = $user->currentlyActiveContactId;
      $RN_checkRestriction = $RN_Permissions->checkProjectManagerORBidder($database, $RN_project_id, $RN_currentlyActiveContactId);

      if($RN_task_summery_permission && (isset($RN_checkRestriction) && !$RN_checkRestriction['bidder_subcontract'])) {
        $RN_task_summery_permission = true;
      } else {
        $RN_task_summery_permission = false;
      }
    } else {
      $RN_task_summery_permission = false;
    }

    return $RN_task_summery_permission;
  }

  // today date
  $today_date = date('Y-m-d');
  // get all action item by due date 
  $tempOptions = array();
  $actionItems = ActionItem::loadActionItemsDetailByDueDateApi($database, $today_date);
  foreach($actionItems as $actionItemId => $actionItem) {
    /* @var $actionItem ActionItem */
    $action_item_type_id = $actionItem->action_item_type_id;
    $project_id = $actionItem->project_id;

    /* @var $project Project */
    $project = Project::findById($database, $project_id);
    $project_name = '';
    $currentlySelectedProjectUserCompanyId = '';
    $currentlySelectedProjectName = '';
    $currentlySelectedProjectId = '';
    if(isset($project) && !empty($project)) {
      $project_name = $project->project_name;
      $currentlySelectedProjectUserCompanyId = $project->user_company_id;
      $currentlySelectedProjectName = $project->project_name;
      $currentlySelectedProjectId = $project->id;
    }
    // Get Action Item Type
    $actionItemType = ActionItemType::findById($database, $action_item_type_id);
    $action_item_type = 'Meeting Minutes';
    if(isset($actionItemType) && !empty($actionItemType)) {
      $action_item_type = $actionItemType->action_item_type;
    }

    // Get Action Item Assignees  
    $actionItemAssignees = ActionItemAssignment::loadAllActionItemAssignmentsByActionItemId($database, $actionItemId);
    foreach($actionItemAssignees as $actionItemAssigneeId => $actionItemAssignees) {
      // Get the details of contact assignees
      $contact = Contact::findById($database, $actionItemAssigneeId);
      /* @var $contact Contact */
      $user_id = null;
      $currentlyActiveContactId = '';
      if(isset($contact) && !empty($contact)) {
       $user_id = $contact->user_id;
       $currentlyActiveContactId = $contact->contact_id;
     }

     /* @var $user User */
     $user = User::findUserByIdExtended($database, $user_id);
     /*inject $user*/
     $user->convertPropertiesToData();
     $RN_data = $user->getData();
     $RN_data['currentlySelectedProjectId'] = $currentlySelectedProjectId;
     $RN_data['currentlySelectedProjectName'] = $currentlySelectedProjectName;
     $RN_data['currentlyActiveContactId'] = $currentlyActiveContactId;

     $user->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
     $user->currentlyActiveContactId = $currentlyActiveContactId;
     $user->currentlySelectedProjectId = $currentlySelectedProjectId;
     $user->currentlySelectedProjectName = $currentlySelectedProjectName;

      // $user = $RN_data;
      //  Notification
     $userNotification = new UsersNotifications($database);
     $arrNotification = array();
     $arrNotification['user_id'] = $user_id;
     $arrNotification['project_id'] = $project_id;
     $arrNotification['user_notification_type_id'] = $action_item_type_id;
     $arrNotification['user_notification_type_reference_id'] = $actionItemId;
     $userNotification->setData($arrNotification);
     $userNotification->convertDataToProperties();
     $user_notification_id = $userNotification->save();

      // get the device Token using ids
     $userDeviceInfoFcmToken = UsersDeviceInfo::findByIdUsingUserId($database, $user_id);
     if($userDeviceInfoFcmToken != null) {
      $arrFcmToken  = $userDeviceInfoFcmToken;
    }
    if(isset($arrFcmToken) && !empty($arrFcmToken)){
        // $user = User::findById($database, $user_id);
        // $user->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
        // $user->currentlyActiveContactId = $currentlyActiveContactId;

      /* @var $contact User */
      $checkPermissionTaskSummary = checkPermissionTaskSummary($database, $user, $project_id);
      /* check permission to view tasksummary */
      $title = 'Meeting Minutes';
        // $bodyContent = 'You have new task to visit';
      $bodyContent = $actionItem->action_item;
      $bodyContent = strlen($bodyContent) > 50 ? substr($bodyContent,0,50)."... Read More" : $bodyContent;
      $options = array();
      $options['task'] = $title;
      $options['project_id'] = $project_id;
      $options['project_name'] = $project_name;
      $options['task_id'] = $actionItemId;
      $options['task_title'] = $actionItem->action_item;
      $options['navigate'] = $checkPermissionTaskSummary;
      $options['body_content'] = 'You have due task';
      $fcm_notification = send_notification($database, $arrFcmToken, $title, $bodyContent, $options);
      $options['user_id'] = $user_id;
      $tempOptions[] = $options;        
    }
    break;
  }
}
$RN_jsonEC['status'] = 200;
$RN_jsonEC['error'] = null;
$RN_jsonEC['err_message'] = null;
$RN_jsonEC['message'] = 'Cron Job Run Successfully';
$RN_jsonEC['data'] = $tempOptions;
} catch(Exception $e) {  
  $RN_jsonEC['status'] = 400;
  $RN_jsonEC['error'] = $e;
  $RN_jsonEC['err_message'] = 'Something else. please try again';
  $RN_jsonEC['data'] = null;
}
header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
/*encode the array*/
$RN_jsonEC = json_encode($RN_jsonEC);
/*echo the json response*/
echo $RN_jsonEC;
exit(0);
?>

<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/Contact.php');
require_once('lib/common/SoftwareModule.php');
require_once('lib/common/Role.php');
require_once('lib/common/SoftwareModuleFunction.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
function send_notification($database, $fcmToken, $title, $bodyContent, $options)
{
	$config = Zend_Registry::get('config');
	$fcm_key = $config->firebase->fcm_api_key;
 	//   $registrationIds = ;
	#prep the bundle
	$notification = array
	(
		'body' 	=> $bodyContent,
		'title'	=> $title,
		'priority' => "high",
		'color' => '#0177c1'
	);
	$message = $options;
	$fields = array
	(
		'registration_ids' => $fcmToken,
		'notification'	=> $notification,
		'data'	=> $options
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

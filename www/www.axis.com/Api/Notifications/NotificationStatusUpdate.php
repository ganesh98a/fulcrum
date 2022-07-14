<?php
try {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['err_message'] = "";
    $RN_jsonEC['data']['notificationData'] = "";
    if(!isset($RN_params['notification_id']) && $RN_params['notification_id']==null){
		$RN_errorMessage = "Notification id is required";		
		$RN_status = 400;
	} else {
		$RN_notification_id = $RN_params['notification_id'];
		$RN_status = 200;
	}

	if($RN_status == 400){
		$RN_jsonEC['status'] = $RN_status;
		$RN_jsonEC['data'] = null;
		header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
		$RN_jsonEC['err_message'] = $RN_errorMessage;
		/*encode the array*/
		$RN_jsonEC = json_encode($RN_jsonEC);
		/*echo the json response*/
		echo $RN_jsonEC;
		exit(0);
	}
	//  get the user notification list count un read
    $RN_notification = UsersNotifications::findById($database, $RN_notification_id);
    if (isset($RN_notification) && !empty($RN_notification)) {
        $RN_status = 200;
        $RN_data = array('is_read' => 'Y');
        $RN_notification->setData($RN_data);
        $RN_notification->save();
        $RN_message = 'Updated Successfully';
        $RN_errorMessage = '';
    } else {
        $RN_errorMessage = 'record does not exist.';
		$RN_status = 400;
    }
    $RN_jsonEC['status'] = $RN_status;
    $RN_jsonEC['message'] = $RN_message;
    $RN_jsonEC['err_message'] = $RN_errorMessage;
    $RN_jsonEC['data']['notificationData'] = ($RN_notification);
	// print_r($RN_notificationListData);
	//  get the user notification list count un read
	$RN_loadUsersNotificationByProjectIdOptions = new Input();
	$RN_loadUsersNotificationByProjectIdOptions->forceLoadFlag = true;
	// filter based on 
	$RN_loadUsersNotificationByProjectIdOptions->whereIsRead = 'N';
    $RN_notificationUnReadCount = UsersNotifications::loadAllUnReadNotificationListByUserAndProjectIds($database, $RN_user_id, $RN_project_id, $RN_loadUsersNotificationByProjectIdOptions);
    
    $RN_jsonEC['data']['notificationUnReadCount'] = $RN_notificationUnReadCount;
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}

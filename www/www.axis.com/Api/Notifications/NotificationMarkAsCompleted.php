<?php
try {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['err_message'] = "";
	$RN_jsonEC['data']['notificationList'] = "";
	// update the status as read of all unreaded notification
	$RN_notificationUpdate = UsersNotifications::markAsAllReadedByUserId($databse, $RN_user_id, $RN_project_id);
	//  get the user notification list count un read
	$RN_loadUsersNotificationByProjectIdOptions = new Input();
	$RN_loadUsersNotificationByProjectIdOptions->forceLoadFlag = true;
	// filter based on 
	$RN_loadUsersNotificationByProjectIdOptions->whereIsRead = 'N';
    $RN_notificationUnReadCount = UsersNotifications::loadAllUnReadNotificationListByUserAndProjectIds($databse, $RN_user_id, $RN_project_id, $RN_loadUsersNotificationByProjectIdOptions);
    
    $RN_jsonEC['data']['notificationUnReadCount'] = $RN_notificationUnReadCount;
	// print_r($RN_notificationListData);
	
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
?>

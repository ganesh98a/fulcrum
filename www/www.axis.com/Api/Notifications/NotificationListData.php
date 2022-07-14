<?php
try {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['err_message'] = "";
	$RN_jsonEC['data']['notificationList'] = "";
	//  get the user notification list
	$RN_loadUsersNotificationByProjectIdOptions = new Input();
	$RN_loadUsersNotificationByProjectIdOptions->forceLoadFlag = true;
	// filter based on 
	switch($RN_filterValue) {
		case 'Y':
		$RN_loadUsersNotificationByProjectIdOptions->whereIsRead = 'Y';
		break;
		case 'N':
		$RN_loadUsersNotificationByProjectIdOptions->whereIsRead = 'N';
		break;
		default:
		break;
	}	
	$RN_notificationListData = UsersNotifications::loadAllNotificationListByUserAndProjectIds($database, $RN_user_id, $RN_project_id, $RN_loadUsersNotificationByProjectIdOptions);
	// lazy load calculation
	$RN_per_page = $RN_per_page;
	$RN_total_rows = count($RN_notificationListData);
	$RN_pages = ceil($RN_total_rows / $RN_per_page);
	$RN_current_page = isset($RN_page) ? $RN_page : 1;
	$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
	$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
	$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
	$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);
	if (isset($RN_notificationListData) && !empty($RN_notificationListData)) {
		$RN_notificationListData = array_slice($RN_notificationListData, $RN_start, $RN_per_page); 
	} else {
		$RN_notificationListData = [];
	}
	
	$RN_jsonEC['data']['total_row'] = $RN_total_rows;
	$RN_jsonEC['data']['total_pages'] = $RN_pages;
	$RN_jsonEC['data']['per_pages'] = $RN_per_page;
	$RN_jsonEC['data']['from'] = ($RN_start+1);
	$RN_jsonEC['data']['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
	$RN_jsonEC['data']['prev_page'] = $RN_prev_page;
	$RN_jsonEC['data']['current_page'] = $RN_current_page;
	$RN_jsonEC['data']['next_page'] = $RN_next_page;

	$arrayStoreIndex = array();
	foreach ($RN_notificationListData as $RN_index => $RN_usersNotification) {
		
		$arrayTemp = array();
		$RN_user_notification_id = $RN_usersNotification->id;
		$is_read = $RN_usersNotification->is_read;
		$created_date = $RN_usersNotification->created_date;
		$created_date = date('M d Y, h:i A', strtotime($created_date));
		$user_notification_type_id = $RN_usersNotification->user_notification_type_id;
		$user_notification_type_reference_id = $RN_usersNotification->user_notification_type_reference_id;
		$title = '';
		$type = '';
		$msg = '';
		$discussion_item_id = '';
		$meeting_id = '';
		$meeting_type_id = '';
		$actionItemType = ActionItemType::findById($database, $user_notification_type_id);
		if(isset($actionItemType) && !empty($actionItemType)) {
			$type = $actionItemType->action_item_type;
		}
		switch($user_notification_type_id) {
			case 1:
				$actionItem = ActionItem::findById($database, $user_notification_type_reference_id);
				$actionItemDetail = ActionItem::loadActionItemsDetailById($database, $user_notification_type_reference_id);
				if(isset($actionItemDetail) && !empty($actionItemDetail)) {
					$discussion_item_id = $actionItemDetail['discussion_item_id'];
					$meeting_id = $actionItemDetail['meeting_id'];
					$meeting_type_id = $actionItemDetail['meeting_type_id'];
				}
				if(isset($actionItem) && !empty($actionItem)) {
					$title = $actionItem->action_item;
				}
			break;
			case 5:
				$requestForInformation = RequestForInformation::findById($database, $user_notification_type_reference_id);
				if(isset($requestForInformation) && !empty($requestForInformation)) {
					$title = $requestForInformation->rfi_title;
					$msg = $requestForInformation->rfi_statement;
				}
			break;
			case 7:
				$submittal = Submittal::findById($database, $user_notification_type_reference_id);
				if(isset($submittal) && !empty($submittal)) {
					$title = $submittal->su_title;
					$msg = $submittal->su_statement;
				}
			break;
			default:
			break;
		}
		
		$arrayTemp['id'] = $RN_user_notification_id;
		$arrayTemp['discussion_item_id'] = $discussion_item_id;
		$arrayTemp['meeting_id'] = $meeting_id;
		$arrayTemp['meeting_type_id'] = $meeting_type_id;
		$arrayTemp['type'] = $type;
		$arrayTemp['title'] = $title;
		$arrayTemp['statement'] = $msg;
		$arrayTemp['date'] = $created_date;
		$arrayTemp['reference_type_id'] = $user_notification_type_id;
		$arrayTemp['reference_id'] = $user_notification_type_reference_id;
		$arrayTemp['is_read'] = $is_read == 'Y' ? true : false;

		$arrayStoreIndex[] = $arrayTemp;
	}
	//  get the user notification list count un read
	$RN_loadUsersNotificationByProjectIdOptions = new Input();
	$RN_loadUsersNotificationByProjectIdOptions->forceLoadFlag = true;
	// filter based on 
	$RN_loadUsersNotificationByProjectIdOptions->whereIsRead = 'N';
    $RN_notificationUnReadCount = UsersNotifications::loadAllUnReadNotificationListByUserAndProjectIds($database, $RN_user_id, $RN_project_id, $RN_loadUsersNotificationByProjectIdOptions);
    
    $RN_jsonEC['data']['notificationUnReadCount'] = $RN_notificationUnReadCount;
	$RN_jsonEC['data']['notificationList'] = array_values($arrayStoreIndex);
	// Filter
	$arrayTemp = array('id'=> 'All', 'value' => 'All');
	$RN_jsonEC['data']['filter'][] = $arrayTemp;
	$arrayTemp = array('id'=> 'Y', 'value' => 'Readed');
	$RN_jsonEC['data']['filter'][] = $arrayTemp;
	$arrayTemp = array('id'=> 'N', 'value' => 'UnReaded');
	$RN_jsonEC['data']['filter'][] = $arrayTemp;
	// print_r($RN_notificationListData);
	
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
?>

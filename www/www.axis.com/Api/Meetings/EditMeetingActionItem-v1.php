<?php
try {
	$RN_status = 200;
	/*
	* Mandatory params & values
	*/
	if(!isset($RN_params['action_item_id']) || $RN_params['action_item_id']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Action item id is required';
	}else
	if(!isset($RN_params['action_item']) || $RN_params['action_item']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Action item title is required';
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
	$action_item_id = null;
	if(isset($RN_params['action_item_id']) && $RN_params['action_item_id']!=null){
		$action_item_id = $RN_params['action_item_id'];
	}

	$action_item_assignees = null;
	if(isset($RN_params['action_item_assignees']) && $RN_params['action_item_assignees']!=null){
		$action_item_assignees = $RN_params['action_item_assignees'];
	}
	
	$RN_httpGetInputData = $RN_params;

	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */
	// Retrieve all of the $RN__GET inputs automatically for the Submittal record
	foreach ($RN_httpGetInputData as $RN_k => $RN_v) {
		if (empty($RN_v)) {
			unset($RN_httpGetInputData[$RN_k]);
		}
	}	
	$actionItem = ActionItem::findById($database, $action_item_id);
	if(!isset($actionItem) || empty($actionItem)) {
		$RN_errorMessage = 'Error updateing: Action item not exist';
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['data'] = null;
		header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
		$RN_jsonEC['err_message'] = $RN_errorMessage;
		/*encode the array*/
		$RN_jsonEC = json_encode($RN_jsonEC);
		/*echo the json response*/
		echo $RN_jsonEC;
		exit(0);
	}

	$actionItem->setData($RN_httpGetInputData);
	$actionItem->convertDataToProperties();

	$actionItem->convertPropertiesToData();
	$data = $actionItem->getData();
	// $data['sort_order'] = 0;
	// $data['created_by_contact_id'] = $RN_currentlyActiveContactId;
	if(isset($data['action_item_due_date']) && !empty($data['action_item_due_date'])) {
		$due_date = DateTime::createFromFormat("m/d/Y" , $data['action_item_due_date']);
        $convertedDate =  $due_date->format('Y-m-d');
		$data['action_item_due_date'] = $convertedDate;
	}
	if(isset($data['action_item_completed_timestamp']) && !empty($data['action_item_completed_timestamp'])) {
		$due_date = DateTime::createFromFormat("m/d/Y" , $data['action_item_completed_timestamp']);
        $convertedDate =  $due_date->format('Y-m-d 00:00:00');
		$data['action_item_completed_timestamp'] = $convertedDate;
	}

	// Test for existence via standard findByUniqueIndex method
	if (!$actionItem) {
		// Error code here
		$RN_errorMessage = 'Action item not exists.';
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['data'] = null;
		header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
		$RN_jsonEC['err_message'] = $RN_errorMessage;
		/*encode the array*/
		$RN_jsonEC = json_encode($RN_jsonEC);
		/*echo the json response*/
		echo $RN_jsonEC;
		exit(0);
	}
	$actionItem->setData($data);
	$actionItem->convertDataToProperties();
	$actionItem->save();
	if (isset($action_item_id) && !empty($action_item_id)) {
		$actionItem->action_item_id = $action_item_id;
		$actionItem->setId($action_item_id);
	}

	$actionItem->convertDataToProperties();
	$primaryKeyAsString = $actionItem->getPrimaryKeyAsString();

	if($action_item_assignees) {
		$arrContactIds = explode(',', $action_item_assignees);
		$getAllAssigneAssined = ActionItemAssignment::loadAllActionItemAssignmentsByActionItemId($database, $action_item_id);
		$deleteExistContact = ActionItemAssignment::deleteActionItemAssigneeByActionItemId($database, $action_item_id);
		// $deleteExistContact = ActionItemAssignment::deleteActionItemAssigneeByActionItemAssigneeId($database, $action_item_id, $action_item_assignee_contact_id);	
		foreach ($arrContactIds as $action_item_assignee_contact_id) {
			$sendNotification = true;
			if(isset($getAllAssigneAssined) && isset($getAllAssigneAssined[$action_item_assignee_contact_id])){
				$sendNotification = false;
			}
			$actionItemAssignment = ActionItemAssignment::findByActionItemIdAndActionItemAssigneeContactId($database, $action_item_id, $action_item_assignee_contact_id);
			if(!$actionItemAssignment) {
				$actionItemAssignment = new ActionItemAssignment($database);
				$httpGetInputData = array();
				$httpGetInputData['action_item_id'] = $action_item_id;
				// $httpGetInputData['action_item_assignee_contact_id'] = $action_item_assignee_contact_id;
				$actionItemAssignment->setData($httpGetInputData);
				$actionItemAssignment->convertDataToProperties();

				// Customization: Allow multiple contact_id values at one time.
				// foreach loop - assign each contact_id value
				$actionItemAssignment->action_item_assignee_contact_id = (int) $action_item_assignee_contact_id;

				$actionItemAssignment->convertPropertiesToData();
				$data = $actionItemAssignment->getData();

				// Test for existence via standard findByUniqueIndex method
				$actionItemAssignment->findByUniqueIndex();
				if ($actionItemAssignment->isDataLoaded()) {
				// Error code here
					$errorMessage = 'Action Item Assignment already exists.';
				} else {
					$actionItemAssignment->setKey(null);
					$actionItemAssignment->setData($data);
				}

				$actionItemAssignment->save();

				$actionItemAssignment->convertDataToProperties();
				$primaryKeyAsString = $actionItemAssignment->getPrimaryKeyAsString();

				// Output standard formatted error or success message
				if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
					// Success
					$errorNumber = 0;
					if($sendNotification) {
						$contact = Contact::findById($database, $action_item_assignee_contact_id);
						/* @var $contact Contact */
						$user_id = $contact->user_id;
						// save notification
						// get ActionItemType 
						$action_item_type = 'Meeting Minutes';
						$actionItemType = ActionItemType::findByActionItemType($database, $action_item_type);
						$action_item_type_id = NULL;
						if (isset($actionItemType) && !empty($actionItemType)) {
							$action_item_type_id = $actionItemType->action_item_type_id;
						}
						//  Notification
						$userNotification = new UsersNotifications($database);
						$arrNotification = array();
						$arrNotification['user_id'] = $user_id;
						$arrNotification['project_id'] = $RN_project_id;
						$arrNotification['user_notification_type_id'] = $action_item_type_id;
						$arrNotification['user_notification_type_reference_id'] = $action_item_id;
						$userNotification->setData($arrNotification);
						$userNotification->convertDataToProperties();
						$user_notification_id = $userNotification->save();
						
						// get the device Token using ids
						$userDeviceInfoFcmToken = UsersDeviceInfo::findByIdUsingUserId($database, $user_id);
						if($userDeviceInfoFcmToken != null) {
							$arrFcmToken  = $userDeviceInfoFcmToken;
						}
						if(isset($arrFcmToken) && !empty($arrFcmToken)){
							$user = User::findById($database, $user_id);
							$user->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
							$user->currentlyActiveContactId = $action_item_assignee_contact_id;
							
							/* @var $contact User */
							
							$checkPermissionTaskSummary = checkPermissionTaskSummary($database, $user, $RN_project_id);
							/* check permission to view tasksummary */
							$actionItem = ActionItem::findById($database, $action_item_id);
							/* get action item*/
							$title = 'Meeting Minutes';
							$bodyContent = 'You have new task to visit';
							$options = array();
							$options['task'] = $title;
							$options['project_id'] = $RN_project_id;
							$options['project_name'] = $RN_project_name;
							$options['task_id'] = $action_item_id;
							$options['task_title'] = $actionItem->action_item;
							$options['navigate'] = $checkPermissionTaskSummary;
							$fcm_notification = send_notification($database, $arrFcmToken, $title, $bodyContent, $options);
						}

						$contactFullNameHtmlEscaped = $contact->getContactFullNameHtmlEscaped();
					}
				} else {
					// Error code here
					$errorNumber = 1;
					$errorMessage = 'Error creating: Action Item Assignment.';
				}
			}
		// Customization: Allow multiple contact_id values at one time.
		} // end foreach loop - indentation for diff of code gen
	}
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['error'] = null;
	$RN_jsonEC['err_message'] = null;
	$RN_jsonEC['message'] = 'ActionItem created successfully';

} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}

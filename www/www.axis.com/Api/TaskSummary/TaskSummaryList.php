<?php
try{
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['err_message'] = "";
	$RN_jsonEC['data']['taskList'] = "";

	if(!isset($RN_params['date_format_type']) && $RN_params['date_format_type']==null){
		$RN_errorMessage = "Date format type is required";		
		$RN_status = 400;
	} else if(!isset($RN_params['action_item_type_id']) && $RN_params['action_item_type_id']==null){
		$RN_errorMessage = "Action item type id is required";
		$RN_status = 400;
	} else if(isset($RN_params['filter_by_date']) && $RN_params['filter_by_date']==null){
		$RN_errorMessage = "Filter date should not be null";
		$RN_status = 400;
	} 
	else {
		if(isset($RN_params['filter_by_date']) && $RN_params['filter_by_date']!=null){
			$RN_filter_by_date = date ('Y-m-d', strtotime($RN_params['filter_by_date']));	
		}
		$RN_action_item_type_id = intVal($RN_params['action_item_type_id']);
		$RN_date_format_type = $RN_params['date_format_type'];
		
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
	// get project manager 
	$RN_task_summery_userBased = true;
	$RN_checkRestriction = RN_Permissions::checkProjectManagerORBidder($database, $RN_project_id, $RN_currentlyActiveContactId);
	if(isset($RN_checkRestriction) && $RN_checkRestriction['project_manager']) {
		$RN_task_summery_userBased = false;
	}
	// get discusstion item id by user
	$RN_projManager = "";
	$RN_arrDiscussionItemsByProjectUserId = null;
	/* Meetings */
	//  Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = $RN_date_format_type;
	$RN_loadDIToAIByOptions->returnType = '';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_action_item_type_id;
	if($RN_filter_by_date) {
		$RN_loadDIToAIByOptions->filter_completed_date = $RN_filter_by_date;
	}	

	switch($RN_action_item_type_id) {
		case 1:
		$RN_arrDiscussionItemsByProjectUserId = ActionItem::loadAllActionItemsTotalApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
		break;
		case 5:
		$RN_arrDiscussionItemsByProjectUserId = RequestForInformation::loadAllRequestsForInformationForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
		break;
		case 7:
		$RN_arrDiscussionItemsByProjectUserId = Submittal::loadAllSubmittalsForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
		break;
		default:
		break;
	}

	$RN_arrDiscussionItemsByProjectUserId = array_values($RN_arrDiscussionItemsByProjectUserId);

	// lazy load calculation
	$RN_per_page = $RN_per_page;
	$RN_total_rows = count($RN_arrDiscussionItemsByProjectUserId);
	$RN_pages = ceil($RN_total_rows / $RN_per_page);
	$RN_current_page = isset($RN_page) ? $RN_page : 1;
	$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
	$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
	$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
	$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);

	$RN_arrDiscussionItemsByProjectUserId = array_slice($RN_arrDiscussionItemsByProjectUserId, $RN_start, $RN_per_page);
	if(!$RN_task_summery_userBased && $RN_action_item_type_id == 1){
		foreach($RN_arrDiscussionItemsByProjectUserId as $indexKey => $actionItem) {
			$RN_actionItemId = $actionItem['item_id'];
			/*Get the Assignee's name*/
	        $RN_loadActionItemAssignmentsByActionItemIdOptions = new Input();
	        $RN_loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
	        $RN_arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $RN_actionItemId, $RN_loadActionItemAssignmentsByActionItemIdOptions);
	        $RN_actionItemAssArr = array();
	        foreach ($RN_arrActionItemAssignmentsByActionItemId as $actionItemAssignment) {
	        	 /* @var $actionItemAssignment ActionItemAssignment */
		        $actionItemAssigneeContact = $actionItemAssignment->getActionItemAssigneeContact();
		        /* @var $actionItemAssigneeContact Contact */
		        $actionItemAssigneeFullName = $actionItemAssigneeContact->getContactFullNameHtmlEscaped();
	        	$RN_actionItemAssArr[] = $actionItemAssigneeFullName;
	        }
	        $RN_arrDiscussionItemsByProjectUserId[$indexKey]['item_assignees'] = $RN_actionItemAssArr;
		}
	}
	
	$RN_jsonEC['data']['total_row'] = $RN_total_rows;
	$RN_jsonEC['data']['total_pages'] = $RN_pages;
	$RN_jsonEC['data']['per_pages'] = $RN_per_page;
	$RN_jsonEC['data']['from'] = ($RN_start+1);
	$RN_jsonEC['data']['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
	$RN_jsonEC['data']['prev_page'] = $RN_prev_page;
	$RN_jsonEC['data']['current_page'] = $RN_current_page;
	$RN_jsonEC['data']['next_page'] = $RN_next_page;

	$RN_jsonEC['data']['taskList'] = $RN_arrDiscussionItemsByProjectUserId;
	$RN_jsonEC['data']['status'] = null;
	$RN_jsonEC['data']['status_raw'] = null;

	if ($RN_action_item_type_id == 7) {
		// submittal status list
		$RN_loadAllSubmittalsStatusOptions = new Input();
		$RN_loadAllSubmittalsStatusOptions->forceLoadFlag = true;
		$loadAllSubmittals = SubmittalStatus::loadAllSubmittalStatuses($database, $RN_loadAllSubmittalsStatusOptions);
		$RN_submittalStatus = array();
		$RN_submittalStatus_raw = array();
		$status_temp = array();
		$status_temp_raw = array();
		foreach($loadAllSubmittals as $statusId => $submittalStatus) {
			$status_id = $submittalStatus->id;
			$status = $submittalStatus->submittal_status;
			$status_temp[$statusId]['id'] = $status_id;
			$status_temp[$statusId]['value'] = $status;
			$status_temp_raw[$statusId] = $status;
		}
		if (isset($status_temp) && !empty($status_temp))
		{
			$RN_submittalStatus = array_values($status_temp);
			$RN_submittalStatus_raw = array_values($status_temp_raw);	
		}

		$RN_jsonEC['data']['status'] = $RN_submittalStatus;
		$RN_jsonEC['data']['status_raw'] = $RN_submittalStatus_raw;
	}
	// print_r($RN_arrDiscussionItemsByProjectUserId);
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
?>

<?php
try{
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['err_message'] = "";
	$RN_jsonEC['data']['taskList'] = "";
	// get discusstion item id by user
	$RN_projManager = '';
	$RN_task_summery_userBased = true;
	$RN_checkRestriction = RN_Permissions::checkProjectManagerORBidder($database, $RN_project_id, $RN_currentlyActiveContactId);
	if(isset($RN_checkRestriction) && $RN_checkRestriction['project_manager']) {
		$RN_task_summery_userBased = false;
	}
	/* Meetings */
	// get the action item type id by type - Meeting Minutes
	$RN_action_item_type = 'Meeting Minutes';
	$RN_getActionItemType = ActionItemType::findByActionItemType($database, $RN_action_item_type);
	$RN_actionItemTypeId = null;
	if (isset($RN_getActionItemType)) {		
		$RN_actionItemTypeId = $RN_getActionItemType->action_item_type_id;
	}
	//  Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 0;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = ActionItem::loadAllActionItemsTotalApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_meetingTotalCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  0- 7 days Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 1;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = ActionItem::loadAllActionItemsTotalApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_meetingTotalSevendaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  7 - 15 days Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 2;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = ActionItem::loadAllActionItemsTotalApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_meetingTotalFifteendaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  over due Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 3;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = ActionItem::loadAllActionItemsTotalApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_meetingTotalOverdaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	// to be determind Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 4;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = ActionItem::loadAllActionItemsTotalApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_meetingTotalTBDCount = $RN_arrDiscussionItemsByProjectUserId['total'];

	// completed task Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 5;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = ActionItem::loadAllActionItemsTotalApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_meetingTotalComCount = $RN_arrDiscussionItemsByProjectUserId['total'];

	$RN_meetings = array();
	$RN_meetings['total_count'] = $RN_meetingTotalCount;
	$RN_meetings['seven_days_count'] = $RN_meetingTotalSevendaysCount;
	$RN_meetings['fifteen_days_count'] = $RN_meetingTotalFifteendaysCount;
	$RN_meetings['over_due_count'] = $RN_meetingTotalOverdaysCount;
	$RN_meetings['tbd_count'] = $RN_meetingTotalTBDCount;
	$RN_meetings['completed_count'] = $RN_meetingTotalComCount;
	$RN_meetings['action_item_type_id'] = $RN_actionItemTypeId;

	// rfis
	$RN_rfis = array();
	// get the action item type id by type - RFI
	$RN_action_item_type = 'RFI';
	$RN_getActionItemType = ActionItemType::findByActionItemType($database, $RN_action_item_type);
	$RN_actionItemTypeId = null;
	if (isset($RN_getActionItemType)) {		
		$RN_actionItemTypeId = $RN_getActionItemType->action_item_type_id;
	}
	//  Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 0;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	// $RN_arrDiscussionItemsByProjectUserId = ActionItem::loadAllActionItemsTotalApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_arrDiscussionItemsByProjectUserId = RequestForInformation::loadAllRequestsForInformationForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_rfiTotalCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  0- 7 days Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 1;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = RequestForInformation::loadAllRequestsForInformationForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_rfiTotalSevendaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  7 - 15 days Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 2;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = RequestForInformation::loadAllRequestsForInformationForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_rfiTotalFifteendaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  over due Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 3;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_arrDiscussionItemsByProjectUserId = RequestForInformation::loadAllRequestsForInformationForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_rfiTotalOverdaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	// to be determind Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 4;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = RequestForInformation::loadAllRequestsForInformationForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_rfiTotalTBDCount = $RN_arrDiscussionItemsByProjectUserId['total'];

	// completed task Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 5;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = RequestForInformation::loadAllRequestsForInformationForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_rfiTotalComCount = $RN_arrDiscussionItemsByProjectUserId['total'];

	$RN_rfis['total_count'] = $RN_rfiTotalCount;
	$RN_rfis['seven_days_count'] = $RN_rfiTotalSevendaysCount;
	$RN_rfis['fifteen_days_count'] = $RN_rfiTotalFifteendaysCount;
	$RN_rfis['over_due_count'] = $RN_rfiTotalOverdaysCount;
	$RN_rfis['tbd_count'] = $RN_rfiTotalTBDCount;
	$RN_rfis['completed_count'] = $RN_rfiTotalComCount;
	$RN_rfis['action_item_type_id'] = $RN_actionItemTypeId;

	// rfis
	$RN_submittal = array();
	// get the action item type id by type - RFI
	$RN_action_item_type = 'Submittal';
	$RN_getActionItemType = ActionItemType::findByActionItemType($database, $RN_action_item_type);
	$RN_actionItemTypeId = null;
	if (isset($RN_getActionItemType)) {		
		$RN_actionItemTypeId = $RN_getActionItemType->action_item_type_id;
	}
	//  Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 0;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = Submittal::loadAllSubmittalsForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_submittalTotalCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  0- 7 days Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 1;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = Submittal::loadAllSubmittalsForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_submittalTotalSevendaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  7 - 15 days Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 2;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = Submittal::loadAllSubmittalsForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_submittalTotalFifteendaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	//  over due Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 3;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = Submittal::loadAllSubmittalsForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_submittalTotalOverdaysCount = $RN_arrDiscussionItemsByProjectUserId['total'];
	// to be determind Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 4;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = Submittal::loadAllSubmittalsForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_submittalTotalTBDCount = $RN_arrDiscussionItemsByProjectUserId['total'];

	// completed task Total Count
	$RN_loadDIToAIByOptions = new Input();
	$RN_loadDIToAIByOptions->forceLoadFlag = true;
	$RN_loadDIToAIByOptions->userBased = $RN_task_summery_userBased;
	$RN_loadDIToAIByOptions->dateDifferBW = true;
	$RN_loadDIToAIByOptions->dateDifferFormatType = 5;
	$RN_loadDIToAIByOptions->returnType = 'Count';
	$RN_loadDIToAIByOptions->action_item_type_id = $RN_actionItemTypeId;
	$RN_arrDiscussionItemsByProjectUserId = Submittal::loadAllSubmittalsForTaskSummaryApi($database, $RN_project_id, $RN_user_id, $RN_userRole, $RN_projManager, $RN_loadDIToAIByOptions);
	$RN_submittalTotalComCount = $RN_arrDiscussionItemsByProjectUserId['total'];

	$RN_submittal['total_count'] = $RN_submittalTotalCount;
	$RN_submittal['seven_days_count'] = $RN_submittalTotalSevendaysCount;
	$RN_submittal['fifteen_days_count'] = $RN_submittalTotalFifteendaysCount;
	$RN_submittal['over_due_count'] = $RN_submittalTotalOverdaysCount;
	$RN_submittal['tbd_count'] = $RN_submittalTotalTBDCount;
	$RN_submittal['completed_count'] = $RN_submittalTotalComCount;
	$RN_submittal['action_item_type_id'] = $RN_actionItemTypeId;

	// date format type
	$RN_dateFormatType = array();
	$RN_dateFormatType[] = 'Open Tasks';
	$RN_dateFormatType[] = '0 - 7 days';
	$RN_dateFormatType[] = '7 - 15 days';
	$RN_dateFormatType[] = 'Over due';
	$RN_dateFormatType[] = 'TBD';
	$RN_dateFormatType[] = 'Completed Tasks';

	$RN_jsonEC['data']['taskList']['date_format_type'] = $RN_dateFormatType;
	$RN_jsonEC['data']['taskList']['meetings'] = $RN_meetings;
	$RN_jsonEC['data']['taskList']['rfis'] = $RN_rfis;
	$RN_jsonEC['data']['taskList']['submittals'] = $RN_submittal;
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
?>

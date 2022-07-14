<?php
try {
	$RN_status = 200;
	/*
	* Mandatory params & values
	*/
	if(!isset($RN_params['meeting_id']) || $RN_params['meeting_id']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Meeting id is required';
	}else
	if(!isset($RN_params['discussion_item_title']) || $RN_params['discussion_item_title']==null){
		$RN_status = 400;
		$RN_errorMessage = 'Discussion item title is required';
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

	$RN_httpGetInputData = $RN_params;

	$RN_db = DBI::getInstance($database);
	/* @var $RN_db DBI_mysqli */
	// Retrieve all of the $RN__GET inputs automatically for the Submittal record
	foreach ($RN_httpGetInputData as $RN_k => $RN_v) {
		if (empty($RN_v)) {
			unset($RN_httpGetInputData[$RN_k]);
		}
	}

	$discussionItem = new DiscussionItem($database);

	$discussionItem->setData($RN_httpGetInputData);
	$discussionItem->convertDataToProperties();
	$discussionItem->convertPropertiesToData();
	$data = $discussionItem->getData();
	/*crack the sort_order*/
	$data['sort_order'] = 0;
	$data['created_by_contact_id'] = $RN_currentlyActiveContactId;
	
			// Test for existence via standard findByUniqueIndex method
	$discussionItem->findByUniqueIndex();
	if ($discussionItem->isDataLoaded()) {
				// Error code here
		$RN_errorMessage = 'Discussion Item already exists.';
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['data'] = null;
		header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
		$RN_jsonEC['err_message'] = $RN_errorMessage;
		/*encode the array*/
		$RN_jsonEC = json_encode($RN_jsonEC);
		/*echo the json response*/
		echo $RN_jsonEC;
		exit(0);
	} else {
		$discussionItem->setKey(null);
		$data['created'] = null;
		$discussionItem->setData($data);
	}

	$discussion_item_id = $discussionItem->save();
	if (isset($discussion_item_id) && !empty($discussion_item_id)) {
		$discussionItem->discussion_item_id = $discussion_item_id;
		$discussionItem->setId($discussion_item_id);
		/*crack the sort_order*/
		$newValue = 0;
		$discussionItem->updateSortOrder($database, $newValue, $discussion_item_id);
	}

	$discussionItem->convertDataToProperties();
	$primaryKeyAsString = $discussionItem->getPrimaryKeyAsString();
	// Output standard formatted error or success message
	$primaryKeyAsString = 1;
	if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
		$errorNumber = 0;
		//If the discussion contains RFI and submittals
		if(isset($RN_httpGetInputData['rfi_element']) && !empty($RN_httpGetInputData['rfi_element'])) {
			$rfi_element = $RN_httpGetInputData['rfi_element'];
			$rfi_element_data = explode(',', $rfi_element);
			foreach ($rfi_element_data as $key => $rfi_value) {
				
				$RFInformation = RequestForInformation::findById($database, $rfi_value);
				if(isset($RFInformation) && !empty($RFInformation)) {
					$RN_httpGetInputData['action_item_type_id'] = 5;
					$RN_httpGetInputData['action_item_type_reference_id'] = $rfi_value;
					$RN_httpGetInputData['action_item'] = $RFInformation->rfi_title;
					if ($RFInformation->rfi_due_date != NULL && $RFInformation->rfi_due_date != 'Null') {
						$RN_httpGetInputData['action_item_due_date'] = $RFInformation->rfi_due_date;
					}

					if ($RFInformation->rfi_closed_date != NULL && $RFInformation->rfi_closed_date != 'Null') {
						$RN_httpGetInputData['action_item_completed_timestamp'] = $RFInformation->rfi_closed_date;
					}
					$RN_httpGetInputData['created_by_contact_id'] = $RN_currentlyActiveContactId;
				}
				$actionItem = new ActionItem($database);
				$actionItem->setData($RN_httpGetInputData);
				$actionItem->convertDataToProperties();
				$actionItem->convertPropertiesToData();
				$data = $actionItem->getData();

				// Test for existence via standard findByUniqueIndex method
				$actionItem->findByUniqueIndex();
				if ($actionItem->isDataLoaded()) {
				// Error code here
					$errorMessage = 'Action Item already exists.';
				} else {
					$actionItem->setKey(null);
					$data['created'] = null;
					$actionItem->setData($data);
				}

				$action_item_id = $actionItem->save();
				if (isset($action_item_id) && !empty($action_item_id)) {
					$actionItem->action_item_id = $action_item_id;
					$actionItem->setId($action_item_id);
				}

				$actionItem->convertDataToProperties();
				$primaryKeyAsString = $actionItem->getPrimaryKeyAsString();
				// $action_item_id = $primaryKeyAsString;
				// Output standard formatted error or success message
				if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
					// Success
					$errorNumber = 0;
					$httpGetInputData = array();
					$httpGetInputData['discussion_item_id'] = $discussion_item_id;
					$httpGetInputData['action_item_id'] = $action_item_id;
					// DiscussiontItem to ActionItem Link
					$discussionItemToActionItem = new DiscussionItemToActionItem($database);

					$discussionItemToActionItem->setData($httpGetInputData);
					$discussionItemToActionItem->convertDataToProperties();

					$discussionItemToActionItem->convertPropertiesToData();
					$data = $discussionItemToActionItem->getData();

					// Test for existence via standard findByUniqueIndex method
					$discussionItemToActionItem->findByUniqueIndex();
					if ($discussionItemToActionItem->isDataLoaded()) {
						// Error code here
						$errorMessage = 'Discussion Item To Action Item already exists.';
					} else {
						$discussionItemToActionItem->setKey(null);
						$discussionItemToActionItem->setData($data);
					}

					$discussionItemToActionItem->save();

					$discussionItemToActionItem->convertDataToProperties();
					$primaryKeyAsString = $discussionItemToActionItem->getPrimaryKeyAsString();
				} else {
				// Error code here
					$errorNumber = 1;
					$errorMessage = 'Error creating: Action Item.';
				}
			} // loop
		} // RFI Add Action Item
		if(isset($RN_httpGetInputData['submittal_element']) && !empty($RN_httpGetInputData['submittal_element'])) {
			$su_element = $RN_httpGetInputData['submittal_element'];
			$su_element_data = explode(',', $su_element);
			foreach ($su_element_data as $key => $su_value) {
				
				$submittal = Submittal::findById($database, $su_value);
				if(isset($submittal) && !empty($submittal)) {
					$RN_httpGetInputData['action_item_type_id'] = 7;
					$RN_httpGetInputData['action_item_type_reference_id'] = $su_value;
					$RN_httpGetInputData['action_item'] = $submittal->su_title;
					if ($submittal->su_due_date != NULL && $submittal->su_due_date != 'Null') {
						$RN_httpGetInputData['action_item_due_date'] = $submittal->su_due_date;
					}

					if ($submittal->su_closed_date != NULL && $submittal->su_closed_date != 'Null') {
						$RN_httpGetInputData['action_item_completed_timestamp'] = $submittal->su_closed_date;
					}
					$RN_httpGetInputData['created_by_contact_id'] = $RN_currentlyActiveContactId;
				}
				$actionItem = new ActionItem($database);
				$actionItem->setData($RN_httpGetInputData);
				$actionItem->convertDataToProperties();
				$actionItem->convertPropertiesToData();
				$data = $actionItem->getData();

				// Test for existence via standard findByUniqueIndex method
				$actionItem->findByUniqueIndex();
				if ($actionItem->isDataLoaded()) {
				// Error code here
					$errorMessage = 'Action Item already exists.';
				} else {
					$actionItem->setKey(null);
					$data['created'] = null;
					$actionItem->setData($data);
				}

				$action_item_id = $actionItem->save();
				if (isset($action_item_id) && !empty($action_item_id)) {
					$actionItem->action_item_id = $action_item_id;
					$actionItem->setId($action_item_id);
				}

				$actionItem->convertDataToProperties();
				$primaryKeyAsString = $actionItem->getPrimaryKeyAsString();

				// Output standard formatted error or success message
				if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
					// Success
					$errorNumber = 0;
					$httpGetInputData = array();
					$httpGetInputData['discussion_item_id'] = $discussion_item_id;
					$httpGetInputData['action_item_id'] = $action_item_id;
					// DiscussiontItem to ActionItem Link
					$discussionItemToActionItem = new DiscussionItemToActionItem($database);

					$discussionItemToActionItem->setData($httpGetInputData);
					$discussionItemToActionItem->convertDataToProperties();

					$discussionItemToActionItem->convertPropertiesToData();
					$data = $discussionItemToActionItem->getData();

					// Test for existence via standard findByUniqueIndex method
					$discussionItemToActionItem->findByUniqueIndex();
					if ($discussionItemToActionItem->isDataLoaded()) {
						// Error code here
						$errorMessage = 'Discussion Item To Action Item already exists.';
					} else {
						$discussionItemToActionItem->setKey(null);
						$discussionItemToActionItem->setData($data);
					}

					$discussionItemToActionItem->save();

					$discussionItemToActionItem->convertDataToProperties();
					$primaryKeyAsString = $discussionItemToActionItem->getPrimaryKeyAsString();
				} else {
					// Error code here
					$errorNumber = 1;
					$errorMessage = 'Error creating: Action Item.';
				}
			} // loop
		} // Submittals Add Action Item
	} else {
				// Error code here
		$errorNumber = 1;
		$RN_errorMessage = 'Error creating: Discussion Item.';
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
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['error'] = null;
	$RN_jsonEC['err_message'] = null;
	$RN_jsonEC['message'] = 'DiscusstionItem created successfully';

} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}

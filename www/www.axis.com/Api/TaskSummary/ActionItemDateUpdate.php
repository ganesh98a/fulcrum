<?php
require_once('SavePdfContent.php');
try{
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['err_message'] = "";
	$RN_jsonEC['data']['taskList'] = "";

	if(!isset($RN_params['action_item_id']) && $RN_params['action_item_id']==null){
		$RN_errorMessage = "Item id is required";		
		$RN_status = 400;
	} else if(!isset($RN_params['completed_date']) && $RN_params['completed_date']==null){
		$RN_errorMessage = "Item completed date is required";
		$RN_status = 400;
	}  else if(!isset($RN_params['action_item_type_id']) && $RN_params['action_item_type_id']==null){
		$RN_errorMessage = "Item type id is required";
		$RN_status = 400;
	} 
	else {
		$RN_action_item_type_id = $RN_params['action_item_type_id'];
		$RN_action_item_id = $RN_params['action_item_id'];
		$RN_action_item_completed_date = $RN_params['completed_date'];		
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
	// get discusstion item id by user
	$RN_projManager = "";
	$RN_itemList = null;
	$RN_action_item_id = intVal($RN_action_item_id);
	switch($RN_action_item_type_id) {
		case 1:
		// Put in findById() or findByUniqueKey() as appropriate
		$RN_actionItem = ActionItem::findById($database, $RN_action_item_id);
		if ($RN_actionItem) {
			$RN_action_item_completed_date = date('Y-m-d', strtotime($RN_action_item_completed_date));
			$RN_data = array('action_item_completed_timestamp' => $RN_action_item_completed_date);
			$RN_actionItem->setData($RN_data);
			$RN_actionItem->save();
			$RN_status = 200;
			$RN_message = 'Updated Successfully';
			$RN_errorMessage = '';
			$RN_itemList = ActionItem::findById($database, $RN_action_item_id);
		} else {
			// Perhaps trigger an error
			$RN_status = 400;
			$RN_errorMessage = 'record does not exist.';
		}
		break;
		case 5:
			$RN_requestForInformation = RequestForInformation::findById($database, $RN_action_item_id);
			if ($RN_requestForInformation) {
				$RN_rfi_status = 'Closed';
				$RN_rfiStatus = RequestForInformationStatus::findByRequestForInformationStatus($database, $RN_rfi_status);
				$RN_status_id = '';
				if (isset($RN_rfiStatus) && !empty($RN_rfiStatus))  {
					$RN_status_id = $RN_rfiStatus->request_for_information_status_id;
				}
				if (!$RN_status_id) {
					$RN_status = 400;
					$RN_errorMessage = "Status $RN_submittal_status does not exist.";
					break;
				}
				$RN_closed_date = date('Y-m-d');
				$RN_data = array(
					'rfi_closed_date' => $RN_closed_date,
					'request_for_information_status_id' => $RN_status_id
				);
				$RN_requestForInformation->setData($RN_data);
				$RN_requestForInformation->save();
				$RN_status = 200;
				$RN_message = 'Updated Successfully';
				$RN_errorMessage = '';
				// Update Action Item completed date
				$RN_actionItem = ActionItem::UpdateDateByReferenceTypeId($database, $RN_action_item_type_id, $RN_action_item_id, $RN_closed_date);
				// update and generate pdf
				if($RN_status == 200) {
					include_once('RfiSaveAsPdf.php');
				}
				$RN_itemList = RequestForInformation::findById($database, $RN_action_item_id);
				$RN_suPdfUrl = null;
				$accessFiles = null;
				if(isset($RN_itemList->rfi_file_manager_file_id) && $RN_itemList->rfi_file_manager_file_id != null)  {
					$RN_suFileManagerFile = FileManagerFile::findById($database, $RN_itemList->rfi_file_manager_file_id);
					if(isset($RN_suFileManagerFile) && !empty($RN_suFileManagerFile)){
						$RN_suPdfUrl = $RN_suFileManagerFile->generateUrl(true);

						$RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

						$RN_explodeValue = explode('?', $RN_suPdfUrl);
						if(isset($RN_explodeValue[1])){
							$RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
						}
						$RN_suPdfUrl = $RN_suPdfUrl.$RN_id;

						$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_suFileManagerFile->file_manager_file_id);
						$accessFiles = false;
						if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
							if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
								$accessFiles = false;
							} else {
								$accessFiles = true;
							}
						}
					}
				}
				$RN_itemList = array();
				$RN_itemList['action_item_id'] = $RN_action_item_id;
				$RN_itemList['file_url'] = $RN_suPdfUrl;
				$RN_itemList['file_access'] = $accessFiles;
			} else {
				// Perhaps trigger an error
				$RN_status = 400;
				$RN_errorMessage = 'record does not exist.';
			}
		break;
		case 7:
			$RN_submittal = Submittal::findById($database, $RN_action_item_id);
			if ($RN_submittal) {
				$RN_submittal_status = 'Reviewed';
				$RN_submittalStatus = SubmittalStatus::findBySubmittalStatus($database, $RN_submittal_status);
				$RN_status_id = '';
				if (isset($RN_submittalStatus) && !empty($RN_submittalStatus))  {
					$RN_status_id = $RN_submittalStatus->submittal_status_id;
				}
				switch($RN_version) {
					case 'v1':
						if ($RN_statusId != '' && $RN_statusId!= null) {
							$RN_status_id = intVal($RN_statusId);
						}
					break;
					default:
					break;
				}
				if (!$RN_status_id) {
					$RN_status = 400;
					$RN_errorMessage = "Status $RN_submittal_status does not exist.";
					break;
				}
				$RN_closed_date = date('Y-m-d');
				$RN_ai_closed_date = date('Y-m-d');
				switch($RN_version) {
					case 'v1':
						if ($RN_statusId != 2 && $RN_statusId != 3 && $RN_statusId!= null) {
							$RN_closed_date = NULL;
							$RN_ai_closed_date = '0000-00-00 00:00:00';
						}
					break;
					default:
					break;
				}
				$RN_data = array(
					'su_closed_date' => $RN_closed_date,
					'submittal_status_id' => $RN_status_id
				);
				$RN_submittal->setData($RN_data);
				$RN_submittal->save();
				$RN_status = 200;
				$RN_message = 'Updated Successfully';
				$RN_errorMessage = '';
			} else {
				// Perhaps trigger an error
				$RN_status = 400;
				$RN_errorMessage = 'record does not exist.';
			}

			// Update Action Item completed date
			$RN_actionItem = ActionItem::UpdateDateByReferenceTypeId($database, $RN_action_item_type_id, $RN_action_item_id, $RN_ai_closed_date);
			// update and generate pdf
			if($RN_status == 200) {
				include_once('SubmittalSaveAsPdf.php');
			}
			$RN_itemList = Submittal::findById($database, $RN_action_item_id);
			$RN_suPdfUrl = null;
			$accessFiles = null;
			if(isset($RN_itemList->su_file_manager_file_id) && $RN_itemList->su_file_manager_file_id != null)  {
				$RN_suFileManagerFile = FileManagerFile::findById($database, $RN_itemList->su_file_manager_file_id);
				if(isset($RN_suFileManagerFile) && !empty($RN_suFileManagerFile)){
					$RN_suPdfUrl = $RN_suFileManagerFile->generateUrl(true);

					$RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

					$RN_explodeValue = explode('?', $RN_suPdfUrl);
					if(isset($RN_explodeValue[1])){
						$RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
					}
					$RN_suPdfUrl = $RN_suPdfUrl.$RN_id;

					$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_suFileManagerFile->file_manager_file_id);
					$accessFiles = false;
					if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
						if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
							$accessFiles = false;
						} else {
							$accessFiles = true;
						}
					}
				}
			}
			$RN_itemList = array();
			$RN_itemList['action_item_id'] = $RN_action_item_id;
			$RN_itemList['file_url'] = $RN_suPdfUrl;
			$RN_itemList['file_access'] = $accessFiles;
		break;
		default:
		break;
	}
	
	$RN_jsonEC['err_message'] = $RN_errorMessage;
	$RN_jsonEC['message'] = $RN_message;
	$RN_jsonEC['data']['taskList'] = $RN_itemList;
	// print_r($RN_arrDiscussionItemsByProjectUserId);
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
?>

<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');

$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['punch_item_list'] = null;
try{
	// Filter by cost code
	$RN_where = null;
	$RN_orderBy = null;
	$RN_groupByBuilding = false;
	if($RN_filterType == 'by_subcontractor'){
		if($RN_filterValue == 'All'){
			$RN_where = '';
		}
		else{		
			$RN_where = "\nAND pi.`recipient_contact_id` = $RN_filterValue";
		}
	}
	if($RN_filterType == 'by_building'){
		$RN_groupByBuilding = true;
		$RN_orderBy = 'by_building';
		if($RN_filterValue == 'All'){
			$RN_where = '';
		}
		else{		
			$RN_where = "\nAND pi.`location_id` = $RN_filterValue";
		}
	}
	if($RN_filterType == 'by_room'){
		if($RN_filterValue == 'All'){
			$RN_where = '';
		}
		else{		
			$RN_where = "\nAND pi.`room_id` = $RN_filterValue";
		}
	}
	if($RN_by_status){
		$RN_where .= "\nAND pi.`status_id` = $RN_by_status";
	}
	if($RN_filterType == 'by_draft'){
		$RN_draft_flag = $RN_filterValue;
	}
	// Load All RN_punchItemList
	$RN_arrPunchItems = PunchItem::loadPunchItemByProjectId($database, $RN_project_id, $RN_draft_flag, $RN_currentlyActiveContactId, false, null, null, $RN_where, $RN_orderBy);

	// Load All for filter type
	$RN_arrPunchItemsFilter = PunchItem::loadPunchItemByProjectIdForFilter($database, $RN_project_id);

	$RN_arrPunchItemListTmp = array();
	$RN_arrayFilterTemp = array();
	$RN_arrSubContractor = array();
	$RN_arrSubContractor[0]['id'] = "All";
	$RN_arrSubContractor[0]['name'] = "All";

	$RN_arrSubContractorSec[0]['id'] = "All";
	$RN_arrSubContractorSec[0]['name'] = "All";
	$RN_arrSubContractorSec[0]['list'][0]['id'] = "All";
	$RN_arrSubContractorSec[0]['list'][0]['name'] = "All";
	$RN_arrBuilding = array();
	$RN_arrBuilding[0]['id'] = "All";
	$RN_arrBuilding[0]['name'] = "All";
	$RN_arrBuildingRoom = array();
	$RN_arrBuildingRoom[0]['id'] = "All";
	$RN_arrBuildingRoom[0]['name'] = "All";
	foreach($RN_arrPunchItemsFilter as $RN_punch_item_id => $RN_punchItemList){
		$RN_recipient_contact_id = $RN_punchItemList->recipient_contact_id;
		$RN_location_id = $RN_punchItemList->location_id;
		$RN_room_id = $RN_punchItemList->room_id;
		
		/* @var $RN_location Location */
		$RN_punchItemListLocation = $RN_punchItemList->getPiBuilding();
		$RN_punchItemListLocation->htmlEntityEscapeProperties();
		$RN_pilocation = $RN_punchItemListLocation->building_name;
		$RN_arrBuilding[$RN_location_id]['id'] = $RN_location_id;
		$RN_arrBuilding[$RN_location_id]['name'] = $RN_pilocation;

		/* @var $RN_location Location */
		$RN_punchItemListLocationRoom = $RN_punchItemList->getPiBuildingRoom();
		$RN_punchItemListLocationRoom->htmlEntityEscapeProperties();
		$RN_piLocationRoom = $RN_punchItemListLocationRoom->room_name;
		$RN_arrBuildingRoom[$RN_room_id]['id'] = $RN_room_id;
		$RN_arrBuildingRoom[$RN_room_id]['name'] = $RN_piLocationRoom;

		/* @var $RN_recipientContact Contact */
		$RN_piRecipientContact = $RN_punchItemList->getPiRecipientContact();
		$RN_piRecipientContact->htmlEntityEscapeProperties();
		$RN_piRecipientContactFullNameHtmlEscaped = $RN_piRecipientContact->getContactFullNameHtmlEscaped();
		

		if(isset($RN_piRecipientContact) && !empty($RN_piRecipientContact)){
			$RN_piRecipientContactCompanyId = $RN_piRecipientContact->contact_company_id;
			$RN_piRecipientContactCompany = ContactCompany::findById($database, $RN_piRecipientContactCompanyId);
			// contact company name
			$RN_piRecipientContactCompanyName = $RN_piRecipientContactCompany->contact_company_name;
		} else {
			// contact company name
			$RN_piRecipientContactCompanyId = null;
			$RN_piRecipientContactCompanyName = null;
		}
		$RN_arrSubContractor[$RN_recipient_contact_id]['id'] = $RN_recipient_contact_id;
		$RN_arrSubContractor[$RN_recipient_contact_id]['name'] = $RN_piRecipientContactFullNameHtmlEscaped;

		$RN_arrSubContractorSec[$RN_piRecipientContactCompanyId]['id'] = $RN_piRecipientContactCompanyName;
		$RN_arrSubContractorSec[$RN_piRecipientContactCompanyId]['name'] = $RN_piRecipientContactCompanyName;

		$RN_arrSubContractorSec[$RN_piRecipientContactCompanyId]['list'][$RN_recipient_contact_id]['id'] = $RN_recipient_contact_id;
		$RN_arrSubContractorSec[$RN_piRecipientContactCompanyId]['list'][$RN_recipient_contact_id]['name'] = $RN_piRecipientContactFullNameHtmlEscaped;

	}
	// Cost code sort
	foreach($RN_arrSubContractorSec as $RN_k => $RN_sortValues){
		$RN_arrSubContractorSec[$RN_k]['list'] = array_values($RN_sortValues['list']);
	}
	$RN_jsonEC['data']['filter_type']['by_subcontractor_sec'] = array_values($RN_arrSubContractorSec);
	$RN_jsonEC['data']['filter_type']['by_subcontractor'] = array_values($RN_arrSubContractor);
	
	$RN_jsonEC['data']['filter_type']['by_room'] = array_values($RN_arrBuildingRoom);
	$RN_jsonEC['data']['filter_type']['by_building'] = array_values($RN_arrBuilding);
	// lazy load calculation
	$RN_per_page = $RN_per_page;
	$RN_total_rows = count($RN_arrPunchItems);
	$RN_pages = ceil($RN_total_rows / $RN_per_page);
	$RN_current_page = isset($RN_page) ? $RN_page : 1;
	$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
	$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
	$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
	$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);

	$RN_arrPunchItems = array_slice($RN_arrPunchItems, $RN_start, $RN_per_page); 
	$RN_jsonEC['data']['total_row'] = $RN_total_rows;
	$RN_jsonEC['data']['total_pages'] = $RN_pages;
	$RN_jsonEC['data']['per_pages'] = $RN_per_page;
	$RN_jsonEC['data']['from'] = ($RN_start+1);
	$RN_jsonEC['data']['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
	$RN_jsonEC['data']['prev_page'] = $RN_prev_page;
	$RN_jsonEC['data']['current_page'] = $RN_current_page;
	$RN_jsonEC['data']['next_page'] = $RN_next_page;
	$RN_arrayStoreIndex = array();
	$RN_index = 0;
	foreach($RN_arrPunchItems as $RN_punch_item_id => $RN_punchItemList){
		$RN_arrayTemp = array();

		/* @var $RN_submittal Submittal */
		$RN_id = $RN_punchItemList->id;
		$punch_item_id = $RN_id;
		$RN_project_id = $RN_punchItemList->project_id;
		$RN_cost_code_id_rw = $RN_punchItemList->cost_code_id;
		$RN_sequence_number = $RN_punchItemList->sequence_number;
		$RN_initiator_contact_id = $RN_punchItemList->initiator_contact_id;
		$RN_initiator_contact_company_id = $RN_punchItemList->initiator_contact_company_id;
		$RN_location_id = $RN_punchItemList->location_id;
		$RN_room_id = $RN_punchItemList->room_id;
		$RN_description_id = $RN_punchItemList->description_id;
		$RN_status_id = $RN_punchItemList->status_id;
		$RN_creator_contact_id = $RN_punchItemList->creator_contact_id;
		$RN_creator_contact_company_id = $RN_punchItemList->creator_contact_company_id;
		$RN_recipient_contact_id = $RN_punchItemList->recipient_contact_id;
		$RN_recipient_contact_company_id = $RN_punchItemList->recipient_contact_company_id;
		$RN_description_txt = $RN_punchItemList->description_txt;
		$RN_description = $RN_punchItemList->description;
		$RN_due_date = $RN_punchItemList->due_date;
		$RN_draft_flag_raw = $RN_punchItemList->draft_flag;
		$RN_piDueDate = $RN_createdDatepid = date('m/d/Y',strtotime($RN_due_date));

		// HTML Entity Escaped Data
		$RN_punchItemList->htmlEntityEscapeProperties();

		$RN_project = $RN_punchItemList->getProject();
		/* @var $RN_project Project */
		$RN_project->htmlEntityEscapeProperties();
		$RN_escaped_project_name = $RN_project->escaped_project_name;

		/* @var $RN_location Location */
		$RN_punchItemListLocation = $RN_punchItemList->getPiBuilding();
		$RN_punchItemListLocation->htmlEntityEscapeProperties();
		$RN_pilocation = $RN_punchItemListLocation->building_name;

		/* @var $RN_location Location */
		$RN_punchItemListLocationRoom = $RN_punchItemList->getPiBuildingRoom();
		$RN_punchItemListLocationRoom->htmlEntityEscapeProperties();
		$RN_piLocationRoom = $RN_punchItemListLocationRoom->room_name;

		/* @var $RN_location Location */
		$RN_punchItemListStatus = $RN_punchItemList->getPunchItemStatus();
		$RN_punchItemListStatus->htmlEntityEscapeProperties();
		$RN_pistatus = $RN_punchItemListStatus->punch_item_status;

		/* @var $RN_creatorContact Contact */
		$RN_piCreatorContact = $RN_punchItemList->getPiCreatorContact();
		$RN_piCreatorContact->htmlEntityEscapeProperties();
		$RN_piCreatorContactFullNameHtmlEscaped = $RN_piCreatorContact->getContactFullNameHtmlEscaped();

		/* @var $RN_initiatorContact Contact */
		$RN_piInitiatorContact = $RN_punchItemList->getPiInitiatorContact();
		if($RN_piInitiatorContact){
			$RN_piInitiatorContact->htmlEntityEscapeProperties();
			$RN_piInitiatorContactFullNameHtmlEscaped = $RN_piInitiatorContact->getContactFullNameHtmlEscaped();
		} else {
			$RN_piInitiatorContactFullNameHtmlEscaped = '';
		}
		

		/* @var $RN_recipientContact Contact */
		$RN_piRecipientContact = $RN_punchItemList->getPiRecipientContact();
		$RN_piRecipientContact->htmlEntityEscapeProperties();
		$RN_piRecipientContactFullNameHtmlEscaped = $RN_piRecipientContact->getContactFullNameHtmlEscaped();

		$RN_piFileManagerFile = $RN_punchItemList->getPiFileManagerFile();
		/* @var $RN_piFileManagerFile FileManagerFile */

		$RN_piCostCode = $RN_punchItemList->getPiCostCode();
		/* @var $RN_piCostCode CostCode */

		if ($RN_piCostCode) {
			// Extra: PunchItem Cost Code - Cost Code Division
			$RN_piCostCodeDivision = $RN_piCostCode->getCostCodeDivision();
			/* @var $RN_piCostCodeDivision CostCodeDivision */

			$RN_formattedPiCostCode = $RN_piCostCode->getFormattedCostCodeApi($database, false, $RN_user_company_id);

			//$RN_htmlEntityEscapedFormattedSuCostCodeLabel = $RN_piCostCode->getHtmlEntityEscapedFormattedCostCodeApi($database);
		} else {
			$RN_formattedPiCostCode = null;
		}

	// contact initiator
		$RN_piRecipientContact = $RN_punchItemList->getPiRecipientContact();
		if(isset($RN_piRecipientContact) && !empty($RN_piRecipientContact)){
			$RN_piRecipientContactCompanyId = $RN_piRecipientContact->contact_company_id;
			$RN_piRecipientContactCompany = ContactCompany::findById($database, $RN_piRecipientContactCompanyId);
		// contact company name
			$RN_piRecipientContactCompanyName = $RN_piRecipientContactCompany->contact_company_name;
		} else {
		// contact company name
			$RN_piRecipientContactCompanyName = null;
		}
		$RN_piPdfUrl = null;
		$RN_accessFiles = false;
		if(!empty($RN_piFileManagerFile) && $RN_piFileManagerFile->file_manager_file_id != null){
			$RN_piFileManagerFile = FileManagerFile::findById($database, $RN_piFileManagerFile->file_manager_file_id);
			if(isset($RN_piFileManagerFile) && !empty($RN_piFileManagerFile)){
				$RN_piPdfUrl = $RN_piFileManagerFile->generateUrl(true);

				$RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

				$RN_explodeValue = explode('?', $RN_piPdfUrl);
				if(isset($RN_explodeValue[1])){
					$RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
				}
				$RN_piPdfUrl = $RN_piPdfUrl.$RN_id;
				$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_piFileManagerFile->file_manager_file_id);
				$RN_accessFiles = false;
				if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
					if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
						$RN_accessFiles = false;
					} else {
						$RN_accessFiles = true;
					}
				}
			}
		}
		$RN_accessFiles = true;
		if($RN_piRecipientContactCompanyName == null) {
			$RN_piRecipientContactCompanyName = 'No Trade';
		}
		if($RN_formattedPiCostCode == null) {
			$RN_formattedPiCostCode = '';
		}
		$RN_arrayTemp['id'] = $RN_sequence_number;
		$RN_arrayTemp['title'] = null;
		$RN_arrayTemp['subcontractor'] = $RN_piRecipientContactCompanyName;
		$RN_arrayTemp['cost_code'] = $RN_formattedPiCostCode;
		$RN_arrayTemp['file_url'] = $RN_piPdfUrl;
		$RN_arrayTemp['file_access'] = $RN_accessFiles;
		$RN_arrayTemp['draft_flag'] = $RN_draft_flag_raw;
		$RN_arrayTemp['id'] = $punch_item_id;
		$RN_arrayTemp['project_id'] = $RN_project_id;
		$RN_arrayTemp['cost_code_id'] = $RN_cost_code_id_rw;		
		$RN_arrayTemp['sequence_number'] = $RN_sequence_number;
		$RN_arrayTemp['status_id'] = $RN_status_id;
		$RN_arrayTemp['status'] = $RN_pistatus;
		$RN_arrayTemp['due_date'] = $RN_piDueDate;
		$RN_arrayTemp['expand'] = false;
		$RN_arrayTemp['initiator']['initiator_contact_id'] = $RN_initiator_contact_id;
		$RN_arrayTemp['initiator']['initiator_contact_company_id'] = $RN_initiator_contact_company_id;
		$RN_arrayTemp['location']['location_id'] = $RN_location_id;
		$RN_arrayTemp['room']['room_id'] = $RN_room_id;	
		$RN_arrayTemp['creator']['creator_contact_id'] = $RN_creator_contact_id;
		$RN_arrayTemp['creator']['creator_contact_company_id'] = $RN_creator_contact_company_id;
		$RN_arrayTemp['recipient']['recipient_contact_id_raw'] = $RN_recipient_contact_id;
		$RN_arrayTemp['recipient']['recipient_contact_id'] = $RN_recipient_contact_company_id.'-'.$RN_recipient_contact_id;
		$RN_arrayTemp['recipient']['recipient_contact_company_id'] = $RN_recipient_contact_company_id;
		$RN_arrayTemp['description']['description_id'] = $RN_description_id;
		$RN_arrayTemp['description']['description_txt'] = $RN_description_txt;
		$RN_arrayTemp['description']['description'] = $RN_description;
		// punchItem Attachments
		$RN_listAttachment = array();
		$RN_arrAttachments = PunchItemAttachment::findPunchItemAttachmentByPunchItemId($database, $punch_item_id);
		foreach($RN_arrAttachments as $attachmentId => $punchItemAttachmentList){

			$RN_piPhotoFileManagerFileId = $punchItemAttachmentList;

			$db = DBI::getInstance($database);
			$db->free_result();
			/* @var $RN_piPhotoFileManagerFileId FileManagerFile */
			$RN_piFileManagerFileAttach = FileManagerFile::findById($database, $RN_piPhotoFileManagerFileId);
			if(isset($RN_piFileManagerFileAttach) && !empty($RN_piFileManagerFileAttach)){
				$RN_virtual_file_name = $RN_piFileManagerFileAttach->virtual_file_name;
				$RN_fileUrl = $RN_piFileManagerFileAttach->generateUrl(true);

				$RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

				$RN_explodeValue = explode('?', $RN_fileUrl);
				if(isset($RN_explodeValue[1])){
					$RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
				}
				$RN_fileUrl = $RN_fileUrl;
				$RN_fileUrlWId = $RN_fileUrl.$RN_id;

				$RN_virtual_file_mime_type = $RN_piFileManagerFileAttach->virtual_file_mime_type;
				$RN_explode = explode('/', $RN_virtual_file_mime_type);
				$RN_virtual_file_mime_type = $RN_explode[1];
				/* file permissions */
				$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_piFileManagerFileAttach->file_manager_file_id);
				$accessFiles = false;
				if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
					if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
						$accessFiles = false;
					} else {
						$accessFiles = true;
					}
				}

				$RN_listAttachment[$RN_piPhotoFileManagerFileId]['file_access'] = $accessFiles;
				$RN_listAttachment[$RN_piPhotoFileManagerFileId]['virtual_file_type'] = $RN_virtual_file_mime_type;
				$RN_listAttachment[$RN_piPhotoFileManagerFileId]['virtual_file_name'] = $RN_virtual_file_name;	
				$RN_listAttachment[$RN_piPhotoFileManagerFileId]['virtual_file_path'] = $RN_fileUrlWId;
				$RN_listAttachment[$RN_piPhotoFileManagerFileId]['virtual_file_path_w_id'] = $RN_fileUrlWId;
				$RN_listAttachment[$RN_piPhotoFileManagerFileId]['id'] = $RN_piPhotoFileManagerFileId;
			}
		}
		$RN_arrayTemp['images'] = array_values($RN_listAttachment);
		// Defects
		if(intVal($RN_description_id) != 0) {
			$piDefect = $RN_punchItemList->getPiDefect();
			// $piDefect->htmlEntityEscapeProperties();
			$piDefectHtmlEscaped = $piDefect->defect_name;
		} else {
			$piDefectHtmlEscaped = $RN_description;
		}
		$RN_arrayTemp['description']['description'] = $piDefectHtmlEscaped;
		$RN_arrayTemp['location']['location_name'] = $RN_pilocation;
		$RN_arrayTemp['room']['room_name'] = $RN_piLocationRoom;	
		$RN_arrayTemp['creator']['creator_name'] = $RN_piCreatorContactFullNameHtmlEscaped;
		$RN_arrayTemp['initiator']['initiator_name'] = $RN_piInitiatorContactFullNameHtmlEscaped;
		$RN_arrayTemp['recipient']['recipient_name'] = $RN_piRecipientContactFullNameHtmlEscaped;
		if($RN_draft_flag != 'All' && $RN_filterType != 'by_draft') {
			if($RN_draft_flag == 'N') {
			$RN_prefixArrrId = $RN_piRecipientContactCompanyName;
			$RN_title = $RN_piRecipientContactCompanyName;
			} else {
				$RN_prefixArrrId = $RN_piRecipientContactFullNameHtmlEscaped;
				$RN_title = $RN_piRecipientContactFullNameHtmlEscaped;
			}
		} else {
			$RN_prefixArrrId = $RN_piRecipientContactCompanyName;
			$RN_title = $RN_piRecipientContactCompanyName;
		}
		
		// group by id
		if ($RN_groupByBuilding && $RN_version != null && $RN_version != 'v1') {
			$group_by_id = $RN_location_id;
			$group_by_name = $RN_pilocation;
		} else {
			$group_by_id = $RN_prefixArrrId;
			$group_by_name = $RN_title;
		}

		$RN_arrayStoreIndex[$group_by_id]['title'] = $group_by_name;
		$RN_arrayStoreIndex[$group_by_id]['subcontractor_contact_id'] = $RN_recipient_contact_id;
		$RN_arrayStoreIndex[$group_by_id]['expand'] = true;
		if(!isset($RN_arrayStoreIndex[$group_by_id]['index'])) {
			$RN_arrayStoreIndex[$group_by_id]['index'] = $RN_index;
			$RN_index++;
		}		
		// $RN_arrayStoreIndex[$group_by_id]['code'] = $RN_formattedPiCostCode;
		$RN_arrayStoreIndex[$group_by_id]['data'][] = $RN_arrayTemp;
	}

	$RN_jsonEC['data']['punch_item_list'] = array_values($RN_arrayStoreIndex);

	// create items requirements
	$RN_arrCreateItemList = array();
	// cost code list
	$RN_costCodeTmp = array();
	$RN_costCodeSubcontractorTmp = array();
	// $RN_costCodeTmp[] = 'Select A Cost Code';
		// subcontractor by project
	$RN_loadContactsByUserCompanyIdOptions = new Input();
	$RN_loadContactsByUserCompanyIdOptions->forceLoadFlag = false;
	// $RN_arrContactsByRoles = Contact::loadContactsByProjectId($database, $RN_project_id, $RN_loadContactsByUserCompanyIdOptions);
	$RN_arrContactsByRoles = Contact::loadContactsByRoleForeman($database, $RN_project_id, $RN_loadContactsByUserCompanyIdOptions);
	
	foreach ($RN_arrContactsByRoles as $id => $RN_contact_company) {
		/* @var $contact Contact */

		/* @var $contactCompany ContactCompany */
		$RN_subContractCCId = $RN_contact_company['contact_company_id'];
		$RN_escaped_contact_company_name = $RN_contact_company['company'];
		// $RN_cost_code_id = $RN_contact_company['cost_code_id'];
		$RN_contact_id = $RN_contact_company['contact_id'];
		$RN_cost_code_id = false;

		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['id'] = htmlspecialchars_decode($id).'***'.$RN_subContractCCId;
		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['name'] = htmlspecialchars_decode($RN_escaped_contact_company_name);
		// contact 
		$RN_contact = Contact::findById($database, $RN_contact_id);
		$RN_encodedContactFullNameWithEmail = null;
		if($RN_contact) {
			$RN_contactFullNameWithEmail = $RN_contact->getContactFullNameWithEmail(false, '<', '-');
			$RN_contactFullName = $RN_contact->getContactFullNameHtmlEscaped(false, '<', '-');

			$RN_encodedContactFullNameWithEmail = Data::entity_encode($RN_contactFullNameWithEmail);	
		}		

		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['id'] = $RN_subContractCCId.'-'.$RN_contact_id;
		$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['name'] = htmlspecialchars_decode($RN_encodedContactFullNameWithEmail);

		/* $RN_loadContactsByUserCompanyIdOptions = new Input();
		$RN_loadContactsByUserCompanyIdOptions->forceLoadFlag = false;
		$RN_arrContactsByCCId = Contact::loadContactsByContactCompanyId($database, $RN_subContractCCId, $RN_loadContactsByUserCompanyIdOptions);
		foreach ($RN_arrContactsByCCId as $RN_contact_id => $RN_contact){
			$RN_contactFullNameWithEmail = $RN_contact->getContactFullNameWithEmail(false, '<', '-');
			$RN_contactFullName = $RN_contact->getContactFullNameHtmlEscaped(false, '<', '-');
			
			$RN_encodedContactFullNameWithEmail = Data::entity_encode($RN_contactFullNameWithEmail);

			$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['id'] = $RN_subContractCCId.'-'.$RN_contact_id;
			$RN_costCodeSubcontractorTmp[$RN_subContractCCId]['list'][$RN_contact_id]['name'] = htmlspecialchars_decode($RN_encodedContactFullNameWithEmail);
		} */

		//  Cost Code
		if($RN_cost_code_id) {

			$RN_costCode = CostCode::findById($database, $RN_cost_code_id);
			/* @var $costCode CostCode */

				// This below method call will lazy load $costCodeDivision
			$RN_formattedCostCode = $RN_costCode->getFormattedCostCodeApi($database, true, $RN_user_company_id);
			$RN_htmlEntityEscapedFormattedCostCodeLabel = $RN_costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$RN_user_company_id);

			$RN_costCodeDivision = $RN_costCode->getCostCodeDivision();
			/* @var $costCodeDivision CostCodeDivision */

			$RN_cost_code_division_id = $RN_costCodeDivision->cost_code_division_id;

			$RN_division_number = $RN_costCodeDivision->division_number;
			$RN_cost_code = $RN_costCode->cost_code;
			$RN_cost_code_description =$RN_costCode->cost_code_description;

			$RN_division_code_heading = $RN_costCodeDivision->division_code_heading;
			$RN_division = $RN_costCodeDivision->division;

				// HTML Entity escaped versions
			$RN_escaped_division_number = $RN_costCodeDivision->escaped_division_number;
			$RN_escaped_cost_code = $RN_costCode->escaped_cost_code;
			$RN_escaped_cost_code_description = htmlspecialchars_decode($RN_costCode->escaped_cost_code_description);

			$RN_escaped_division_code_heading = $RN_costCodeDivision->escaped_division_code_heading;
			$RN_escaped_division = $RN_costCodeDivision->escaped_division;

			$RN_costCodeTmp[$RN_subContractCCId][$RN_escaped_division_number]['id'] = htmlspecialchars_decode($RN_escaped_division.'('.$RN_escaped_division_number.'-'.$RN_escaped_division_code_heading.')');
			$RN_costCodeTmp[$RN_subContractCCId][$RN_escaped_division_number]['name'] = htmlspecialchars_decode($RN_escaped_division.'('.$RN_escaped_division_number.'-'.$RN_escaped_division_code_heading.')');
				// cost code name
			$RN_costCodeTmp[$RN_subContractCCId][$RN_escaped_division_number]['list'][$RN_cost_code_id]['id'] = $RN_cost_code_id;
			$RN_costCodeTmp[$RN_subContractCCId][$RN_escaped_division_number]['list'][$RN_cost_code_id]['name'] = $RN_escaped_division_number.'-'.$RN_escaped_cost_code.' '.$RN_escaped_cost_code_description;
		}
	}
	ksort($RN_costCodeTmp);
	$RN_costCodeDefaultId = null;
	$RN_kIn = 0;
	foreach($RN_costCodeTmp as $RN_k => $RN_sortValues){
		foreach($RN_sortValues as $RN_sub_k => $RN_sortValuesKey){
			$RN_costCodeTmp[$RN_k][$RN_sub_k]['list'] = array_values($RN_sortValuesKey['list']);
			if($RN_kIn == 0){
				$RN_costCodeDefaultId = $RN_costCodeTmp[$RN_k][$RN_sub_k]['list'][0]['id'];
			}
			$RN_kIn++;
		}
		$RN_costCodeTmp[$RN_k] = array_values($RN_costCodeTmp[$RN_k]);
	}
	$RN_jsonEC['data']['CreatePunchListData']['cost_code_default_id'] = $RN_costCodeDefaultId;
	$RN_jsonEC['data']['CreatePunchListData']['cost_code'] = ($RN_costCodeTmp);
	// s subcontractor
	$RN_initiatorDefaultId = null;
	$RN_kInc = 0;
	foreach($RN_costCodeSubcontractorTmp as $RN_k => $RN_sortValues){
		$RN_costCodeSubcontractorTmp[$RN_k]['list'] = array_values($RN_sortValues['list']);
		if($RN_kInc == 0){
			$RN_initiatorDefaultId = $RN_costCodeSubcontractorTmp[$RN_k]['list'][0]['id'];
		}
		$RN_kInc++;
	}
	if(empty($RN_costCodeSubcontractorTmp)) {
		$tmpSubConArr = array();
		$tmpSubConArr[0]['id'] = "";
		$tmpSubConArr[0]['name'] = "No contacts with foreman role";
		$nodataArr = array();
		$nodataArr[0]['id'] = '';
		$nodataArr[0]['name'] = '';
		$tmpSubConArr[0]['list'] = $nodataArr;
		$RN_costCodeSubcontractorTmp = $tmpSubConArr;
	}
	$RN_jsonEC['data']['CreatePunchListData']['recipient'] = array_values($RN_costCodeSubcontractorTmp);
	$RN_jsonEC['data']['CreatePunchListData']['recipient_default_id'] = $RN_initiatorDefaultId;
	// Building & Rooms Content

	$RN_arrBuldingTmp = array();

	$RN_arrBuildings = PunchItemBuilding::findPunchItemBuildingByProjectIdExtended($database, $RN_project_id);
	$RN_buildingDefaultId = null;
	$RN_kIncb = 0;
	foreach($RN_arrBuildings as $RN_pibk => $RN_piBuilding){
		$RN_arrBuldingTmp[$RN_pibk]['id'] = $RN_piBuilding->id;
		$RN_arrBuldingTmp[$RN_pibk]['name'] = $RN_piBuilding->building_name;
		$RN_arrBuldingTmp[$RN_pibk]['location'] = $RN_piBuilding->location;
		if($RN_kIncb == 0){
			$RN_buildingDefaultId = $RN_pibk;
		}
		$RN_kIncb++;
	}
	// $RN_jsonEC['data'] = null;
	$RN_jsonEC['data']['CreatePunchListData']['building'] = array_values($RN_arrBuldingTmp);

	$RN_buildingDefaultId = PunchItem::findLastPunchItemBuildingAndRoomByContactId($database, $RN_project_id, $RN_currentlyActiveContactId, 'location_id');

	$RN_jsonEC['data']['CreatePunchListData']['building_default_id'] = $RN_buildingDefaultId;
	// Rooms default
	$RN_arrBuldingRoomTmp = array();
	$RN_buildingRoomDefaultId = null;
	$RN_kIncbr = 0;
	if($RN_buildingDefaultId!=null){
		$RN_arrPiBuildingRooms = PunchItemBuildingRoom::findByPunchItemRoomByBuildingId($database, $RN_buildingDefaultId);
		foreach($RN_arrPiBuildingRooms as $RN_kibr => $RN_buildinRoom){
			$RN_arrBuldingRoomTmp[$RN_kibr]['id'] = $RN_kibr;
			$RN_arrBuldingRoomTmp[$RN_kibr]['name'] = $RN_buildinRoom->room_name;
			if($RN_kIncbr == 0){
				$RN_buildingRoomDefaultId = $RN_kibr;
			}
			$RN_kIncbr++;
		}
	}
	$RN_jsonEC['data']['CreatePunchListData']['room'] = array_values($RN_arrBuldingRoomTmp);

	$RN_buildingRoomDefaultId = PunchItem::findLastPunchItemBuildingAndRoomByContactId($database, $RN_project_id, $RN_currentlyActiveContactId, 'room_id');

	$RN_jsonEC['data']['CreatePunchListData']['room_default_id'] = $RN_buildingRoomDefaultId;
	// due date default 2 days without weekends
	$RN_today = date('Y-m-d');
	$RN_next2WD = date('Y-m-d', strtotime($RN_today.'+3 weekday'));
	$RN_next2WDDate = date('m/d/Y', strtotime($RN_today.'+2 weekday'));
	$RN_jsonEC['data']['CreatePunchListData']['due_date'] = $RN_next2WDDate;
	// Defects
	$RN_arraPiDefect = array();
	$RN_arrPiDefects = PunchItemDefect::loadAllPunchItemDefect($database, $RN_user_company_id);
	$RN_defectDefaultId = null;
	$RN_kInPiD = 0;
	foreach($RN_arrPiDefects as $RN_kPik => $RN_piDefect){
		$RN_arraPiDefect[$RN_kPik]['id'] = $RN_kPik;
		$RN_arraPiDefect[$RN_kPik]['defect_name'] = $RN_piDefect->defect_name;
		if($RN_kInPiD == 0){
			$RN_defectDefaultId = $RN_kPik;
		}
		$RN_kInPiD++;
	}
	$RN_jsonEC['data']['CreatePunchListData']['defect'] = array_values($RN_arraPiDefect);
	$RN_jsonEC['data']['CreatePunchListData']['defect_default_id'] = $RN_defectDefaultId;
	// recipient
	// $RN_jsonEC['data'] = null;
	$RN_arrRecipient = array();
	$RN_arrProjectTeamMembers = Contact::loadProjectTeamMembers($database, $RN_project_id);
	$RN_recipientDefaultId = null;
	$RN_kInPir = 0;
	foreach($RN_arrProjectTeamMembers as $RN_kcri => $RN_recipient){
		$RN_arrRecipient[$RN_kcri]['contact_id'] = $RN_kcri;
		$RN_arrRecipient[$RN_kcri]['name'] = $RN_recipient->getContactFullName();
		$RN_arrRecipient[$RN_kcri]['email'] = $RN_recipient->email;
		$RN_arrRecipient[$RN_kcri]['contact_company_id'] = $RN_recipient->contact_company_id;
		if($RN_kInPir == 0){
			$RN_recipientDefaultId = $RN_kcri;
		}
		$RN_kInPir++;
	}
	$RN_jsonEC['data']['CreatePunchListData']['initiator'] = array_values($RN_arrRecipient);
	$RN_jsonEC['data']['CreatePunchListData']['default_initiator_id'] = $RN_recipientDefaultId;
	//  last selected recipient id 
	$RN_lastRecipientContactId = PunchItem::findLastPunchItemRecipientByContactId($database, $RN_project_id, $RN_currentlyActiveContactId);
	if($RN_lastRecipientContactId){
		$RN_jsonEC['data']['CreatePunchListData']['defect_recipient_id'] = $RN_lastRecipientContactId;
	}
	// Status
	$RN_arraPiStatus = array();
	$RN_arrPiStatus = PunchItemStatus::loadAllPunchItemStatus($database, $RN_user_company_id);
	$RN_defectDefaultId = null;
	$RN_kInPiD = 0;
	foreach($RN_arrPiStatus as $RN_kPik => $RN_piStatus){
		$RN_arraPiStatus[$RN_kPik]['id'] = $RN_kPik;
		$RN_arraPiStatus[$RN_kPik]['name'] = $RN_piStatus->punch_item_status;
		if($RN_kInPiD == 0){
			$RN_statusDefaultId = $RN_kPik;
		}
		$RN_kInPiD++;
	}
	$RN_jsonEC['data']['filter_type']['by_status'] = array_values($RN_arraPiStatus);
	$RN_jsonEC['data']['filter_type']['defect_status_id'] = $RN_statusDefaultId;
	// $RN_jsonEC['data']['CreatePunchListData'] = null;
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;	
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}

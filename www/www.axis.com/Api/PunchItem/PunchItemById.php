<?php

	$arrPiDetailListTmp = array();
	$punchItem = PunchItem::findPunchItemByIdExtended($database, $punch_item_id);

	/* @var $submittal Submittal */
	$id = $punchItem->id;
	$project_id = $punchItem->project_id;
	$sequence_number = $punchItem->sequence_number;
	$initiator_contact_id = $punchItem->initiator_contact_idid;
	$initiator_contact_company_id = $punchItem->initiator_contact_company_id;
	$location_id = $punchItem->location_id;
	$room_id = $punchItem->room_id;
	$description_id = $punchItem->description_id;
	$status_id = $punchItem->status_id;
	$creator_contact_id = $punchItem->creator_contact_id;
	$creator_contact_company_id = $punchItem->creator_contact_company_id;
	$recipient_contact_id = $punchItem->recipient_contact_id;
	$recipient_contact_company_id = $punchItem->recipient_contact_company_id;
	$description_txt = $punchItem->description_txt;
	$description = $punchItem->description;
	$due_date = $punchItem->due_date;
	$piDueDate = $createdDatepid = date('m/d/Y',strtotime($due_date));

	$arrPiDetailListTmp['id'] = $id;
	$arrPiDetailListTmp['project_id'] = $project_id;
	$arrPiDetailListTmp['sequence_number'] = $sequence_number;
	$arrPiDetailListTmp['initiator']['initiator_contact_id'] = $initiator_contact_id;
	$arrPiDetailListTmp['initiator']['initiator_contact_company_id'] = $id;
	$arrPiDetailListTmp['location_id'] = $location_id;
	$arrPiDetailListTmp['room_id'] = $room_id;
	$arrPiDetailListTmp['status_id'] = $status_id;
	$arrPiDetailListTmp['creator']['creator_contact_id'] = $creator_contact_id;
	$arrPiDetailListTmp['creator']['creator_contact_company_id'] = $creator_contact_company_id;
	$arrPiDetailListTmp['recipient']['recipient_contact_id'] = $recipient_contact_id;
	$arrPiDetailListTmp['recipient']['recipient_contact_company_id'] = $recipient_contact_company_id;
	$arrPiDetailListTmp['description_id'] = $description_id;
	$arrPiDetailListTmp['description_txt'] = $description_txt;
	$arrPiDetailListTmp['description'] = $description;
	$arrPiDetailListTmp['due_date'] = $piDueDate;


	// HTML Entity Escaped Data
	$punchItem->htmlEntityEscapeProperties();
	
	$project = $punchItem->getProject();
	/* @var $project Project */
	$project->htmlEntityEscapeProperties();
	$escaped_project_name = $project->escaped_project_name;
	$arrPiDetailListTmp['project_name'] = $escaped_project_name;

	/* @var $location Location */
	$punchItemLocation = $punchItem->getPiBuilding();
	$punchItemLocation->htmlEntityEscapeProperties();
	$pilocation = $punchItemLocation->building_name;
	$arrPiDetailListTmp['location_name'] = $pilocation;

	/* @var $location Location */
	$punchItemLocationRoom = $punchItem->getPiBuildingRoom();
	$punchItemLocationRoom->htmlEntityEscapeProperties();
	$piLocationRoom = $punchItemLocationRoom->room_name;
	$arrPiDetailListTmp['room_name'] = $room_name;

	/* @var $location Location */
	$punchItemStatus = $punchItem->getPunchItemStatus();
	$punchItemStatus->htmlEntityEscapeProperties();
	$pistatus = $punchItemStatus->punch_item_status;
	$arrPiDetailListTmp['status'] = $pistatus;

	/* @var $creatorContact Contact */
	$piCreatorContact = $punchItem->getPiCreatorContact();
	$piCreatorContact->htmlEntityEscapeProperties();
	$piCreatorContactFullNameHtmlEscaped = $piCreatorContact->getContactFullNameHtmlEscaped();
	$arrPiDetailListTmp['creator']['creator_name'] = $piCreatorContactFullNameHtmlEscaped;

	/* @var $initiatorContact Contact */
	$piInitiatorContact = $punchItem->getPiInitiatorContact();
	$piInitiatorContact->htmlEntityEscapeProperties();
	$piInitiatorContactFullNameHtmlEscaped = $piInitiatorContact->getContactFullNameHtmlEscaped();
	$arrPiDetailListTmp['initiator']['initiator_name'] = $piInitiatorContactFullNameHtmlEscaped;
	/* @var $recipientContact Contact */
	$piRecipientContact = $punchItem->getPiRecipientContact();
	$piRecipientContact->htmlEntityEscapeProperties();
	$piRecipientContactFullNameHtmlEscaped = $piRecipientContact->getContactFullNameHtmlEscaped();
	$arrPiDetailListTmp['recipient']['recipient_name'] = $piRecipientContactFullNameHtmlEscaped;

	// creator contact office id
	$RN_arrPiCreatorContactCompanyOfficesOptions = new Input();
	$RN_arrPiCreatorContactCompanyOfficesOptions->forceLoadFlag = true;
	$arrPiCreatorContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $creator_contact_company_id, $RN_arrPiCreatorContactCompanyOfficesOptions);
	$hqFlagIndex = 0;
	foreach ($arrPiCreatorContactCompanyOffices as $i => $piCreatorContactCompanyOffice) {
		/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
		$head_quarters_flag = $piCreatorContactCompanyOffice->head_quarters_flag;
		if ($head_quarters_flag == 'Y') {
			$hqFlagIndex = $i;
			continue;
		}
	}
	
	if ($arrPiCreatorContactCompanyOffices) {
		$pi_creator_contact_company_office = $arrPiCreatorContactCompanyOffices[$hqFlagIndex];
		$twoLines = true;
		$piCreatorContactCompanyOfficeAddressHtmlEscaped = $pi_creator_contact_company_office->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$piCreatorContactCompanyOfficeAddressHtmlEscaped = '';
	}
	$arrPiDetailListTmp['creator']['creator_company_office'] = $piCreatorContactCompanyOfficeAddressHtmlEscaped;

	// initiator contact office id
	$RN_arrPiInitiatorContactCompanyOfficesOptions = new Input();
	$RN_arrPiInitiatorContactCompanyOfficesOptions->forceLoadFlag = true;
	$arrPiInitiatorContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $initiator_contact_company_id, $RN_arrPiInitiatorContactCompanyOfficesOptions);
	$hqFlagIndex = 0;
	foreach ($arrPiInitiatorContactCompanyOffices as $i => $piInitiatorContactCompanyOffice) {
		/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
		$head_quarters_flag = $piInitiatorContactCompanyOffice->head_quarters_flag;
		if ($head_quarters_flag == 'Y') {
			$hqFlagIndex = $i;
			continue;
		}
	}
	// print_r($arrPiInitiatorContactCompanyOffices);
	if ($arrPiInitiatorContactCompanyOffices) {
		$pi_initiator_contact_company_office = $arrPiInitiatorContactCompanyOffices[$hqFlagIndex];
		$twoLines = true;
		$piInitiatorContactCompanyOfficeAddressHtmlEscaped = $pi_initiator_contact_company_office->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$piInitiatorContactCompanyOfficeAddressHtmlEscaped = '';
	}
	$arrPiDetailListTmp['initiator']['initiator_company_office'] = $piInitiatorContactCompanyOfficeAddressHtmlEscaped;

	// recipient contact office id
	$RN_arrPiRecipientContactCompanyOfficesOptions = new Input();
	$RN_arrPiRecipientContactCompanyOfficesOptions->forceLoadFlag = true;
	$arrPiRecipientContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $recipient_contact_company_id, $RN_arrPiRecipientContactCompanyOfficesOptions);
	$hqFlagIndex = 0;
	foreach ($arrPiRecipientContactCompanyOffices as $i => $piRecipientContactCompanyOffice) {
		/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
		$head_quarters_flag = $piRecipientContactCompanyOffice->head_quarters_flag;
		if ($head_quarters_flag == 'Y') {
			$hqFlagIndex = $i;
			continue;
		}
	}
	// print_r($arrPiInitiatorContactCompanyOffices);
	if ($arrPiRecipientContactCompanyOffices) {
		$pi_recipient_contact_company_office = $arrPiRecipientContactCompanyOffices[$hqFlagIndex];
		$twoLines = true;
		$piRecipientContactCompanyOfficeAddressHtmlEscaped = $pi_recipient_contact_company_office->getFormattedOfficeAddressHtmlEscaped($twoLines);
	} else {
		$piRecipientContactCompanyOfficeAddressHtmlEscaped = '';
	}
	$arrPiDetailListTmp['recipient']['recipient_company_office'] = $piRecipientContactCompanyOfficeAddressHtmlEscaped;
	// print_r($piCreatorContactCompanyOfficeAddressHtmlEscaped);

	// Defects
	if(intVal($description_id) != 0) {
		$piDefect = $punchItem->getPiDefect();
		$piDefect->htmlEntityEscapeProperties();
		$piDefectHtmlEscaped = $piDefect->defect_name;
	} else {
		$piDefectHtmlEscaped = $punchItem->description_txt;
	}
	$arrPiDetailListTmp['description'] = $piDefectHtmlEscaped;
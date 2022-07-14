<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');

$RN_jsonEC['data'] = null;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['RfiData'] = null;
$RN_orderBy = '';
$RN_where = '';
if($RN_sort != '' && $RN_sort != null){
	$RN_orderBy = $RN_sort;	
}

if($RN_filterValue == 'All'){
	$RN_filterValue = '';
}
$RN_where = $RN_filterValue;
// load Rfi
$RN_loadRequestsForInformationByProjectIdOptions = new Input();
$RN_loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
$RN_arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByProjectIdLoadAPI($database, $RN_project_id, $RN_loadRequestsForInformationByProjectIdOptions, $RN_orderBy, $RN_where);
// lazy load calculation
$RN_per_page = $RN_per_page;
$RN_total_rows = count($RN_arrRequestsForInformation);
if($RN_listAll) {
	$RN_per_page = $RN_total_rows;
}
$RN_pages = ceil($RN_total_rows / $RN_per_page);
$RN_current_page = isset($RN_page) ? $RN_page : 1;
$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);

$RN_arrRequestsForInformation = array_slice($RN_arrRequestsForInformation, $RN_start, $RN_per_page); 
$RN_jsonEC['data']['total_row'] = $RN_total_rows;
$RN_jsonEC['data']['total_pages'] = $RN_pages;
$RN_jsonEC['data']['per_pages'] = $RN_per_page;
$RN_jsonEC['data']['from'] = ($RN_start+1);
$RN_jsonEC['data']['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
$RN_jsonEC['data']['prev_page'] = $RN_prev_page;
$RN_jsonEC['data']['current_page'] = $RN_current_page;
$RN_jsonEC['data']['next_page'] = $RN_next_page;
$arrayStoreIndex = array();
foreach ($RN_arrRequestsForInformation as $RN_request_for_information_id => $RN_requestForInformation) {
	$arrayTemp = array();
	$RN_rfi_id = $RN_requestForInformation->request_for_information_id;
	$RN_requestForInformationStatus = $RN_requestForInformation->getRequestForInformationStatus();
	$RN_request_for_information_status = $RN_requestForInformationStatus->request_for_information_status;
	/* @var $submittalStatus SubmittalStatus */

	$RN_requestForInformationPriority = $RN_requestForInformation->getRequestForInformationPriority();
	/* @var $requestForInformationPriority RequestForInformationPriority */
	$RN_request_for_information_priority = $RN_requestForInformationPriority->request_for_information_priority;

	$RN_rfi_closed_date = $RN_requestForInformationPriority->rfi_closed_date;
	$RN_rfi_created_date = $RN_requestForInformation->created;

	$RN_rfiFileManagerFile = $RN_requestForInformation->getRfiFileManagerFile();
	/* @var $rfiFileManagerFile FileManagerFile */

	$RN_rfiCostCode = $RN_requestForInformation->getRfiCostCode();
	/* @var $rfiCostCode CostCode */

	$RN_request_for_information_priority_id = $RN_requestForInformation->request_for_information_priority_id;
	/* @var $request_for_information_priority_id Prority */

	$RN_rfiRecipientContact = $RN_requestForInformation->getRfiRecipientContact();
		/* @var $rfiRecipientContact Contact */

	if ($RN_rfiCostCode) {

		$RN_rfiCostCodeDivision = $RN_rfiCostCode->getCostCodeDivision();
		/* @var $rfiCostCodeDivision CostCodeDivision */

		$RN_formattedRfiCostCode = $RN_rfiCostCode->getFormattedCostCodeApi($database, true, $RN_user_company_id);

			//$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCodeApi($database);
	} else {
		$RN_formattedRfiCostCode = null;
	}
	// contact initiator
	$RN_rfiCreatorContact = $RN_requestForInformation->getRfiCreatorContact();
	if(isset($RN_rfiCreatorContact) && !empty($RN_rfiCreatorContact)){

		$RN_rfiCreatorContactCompanyId = $RN_rfiCreatorContact->contact_company_id;
		$RN_rfiCreatorContactCompany = ContactCompany::findById($database, $RN_rfiCreatorContactCompanyId);
		// contact company name
		$RN_rfi_creator_contact_company_name = $RN_rfiCreatorContactCompany->contact_company_name;
	} else {
		// contact company name
		$RN_rfi_creator_contact_company_name = null;
	}
	$RN_requestForInformation->htmlEntityEscapeProperties();
	// submittal title
	$RN_escaped_rfi_title = $RN_requestForInformation->escaped_rfi_title;
	$RN_rfi_sequence_number = $RN_requestForInformation->rfi_sequence_number;
	$RN_request_for_information_type_id = $RN_requestForInformation->request_for_information_type_id;
	$RN_escaped_rfi_plan_page_reference = $RN_requestForInformation->escaped_rfi_plan_page_reference;
	$RN_rfi_created = $RN_requestForInformation->created;
	$RN_rfiPdfUrl = null;
	$accessFiles = false;
	if(isset($RN_rfiFileManagerFile->file_manager_file_id) && $RN_rfiFileManagerFile->file_manager_file_id != null){
		$RN_rfiFileManagerFile = FileManagerFile::findById($database, $RN_rfiFileManagerFile->file_manager_file_id);
		if(isset($RN_rfiFileManagerFile) && !empty($RN_rfiFileManagerFile)){
			$RN_rfiPdfUrl = $RN_rfiFileManagerFile->generateUrl(true);

			$RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

			$RN_explodeValue = explode('?', $RN_rfiPdfUrl);
			if(isset($RN_explodeValue[1])){
				$RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
			}
			$RN_rfiPdfUrl = $RN_rfiPdfUrl.$RN_id;
			$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_rfiFileManagerFile->file_manager_file_id);
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


	if($RN_rfi_creator_contact_company_name == null) {
		$RN_rfi_creator_contact_company_name = 'No Trade';
	}
	if($RN_formattedRfiCostCode == null) {
		$RN_formattedRfiCostCode = '-';
	}
	/* @var $recipient Contact */
	if ($RN_rfiRecipientContact) {
		$RN_rfiRecipientContactFullName = $RN_rfiRecipientContact->getContactFullName();
		$RN_rfiRecipientContactFullNameHtmlEscaped = $RN_rfiRecipientContact->getContactFullNameHtmlEscaped();
	} else {
		$RN_rfiRecipientContactFullName = '';
		$RN_rfiRecipientContactFullNameHtmlEscaped = '&nbsp;';
	}

	// Convert rfi_created to a Unix timestamp
	$RN_openDateUnixTimestamp = strtotime($RN_rfi_created);
		//$openDateDisplayString = date('n/j/Y g:ma');
	$RN_oneDayInSeconds = 86400;
	$RN_daysOpen = '';

	$RN_formattedRfiCreatedDate = date("m/d/Y - g:i a", $RN_openDateUnixTimestamp);

	// if RFI status is "closed"
	if (!$RN_rfi_closed_date) {
		$RN_rfi_closed_date = '0000-00-00';
	}
	// if (($RN_request_for_information_status == 'Closed') && ($RN_rfi_closed_date <> '0000-00-00')) {
	// 	$RN_closedDateUnixTimestamp = strtotime($RN_rfi_closed_date);
	// 	if ($RN_rfi_closed_date <> '0000-00-00') {

	// 		$RN_daysOpenNumerator = $RN_closedDateUnixTimestamp - $RN_openDateUnixTimestamp;
	// 		$RN_daysOpenDenominator = $RN_oneDayInSeconds;
	// 		$RN_daysOpen = $RN_daysOpenNumerator / $RN_daysOpenDenominator;
	// 		$RN_daysOpen = ceil($RN_daysOpen);

	// 	}
	// } else {

	// 	$RN_nowDate = date('Y-m-d');
	// 	$RN_nowDateUnixTimestamp = strtotime($RN_nowDate);
	// 	$RN_daysOpenNumerator = $RN_nowDateUnixTimestamp - $RN_openDateUnixTimestamp;
	// 	$RN_daysOpenDenominator = $RN_oneDayInSeconds;
	// 	$RN_daysOpen = $RN_daysOpenNumerator / $RN_daysOpenDenominator;
	// 	$RN_daysOpen = ceil($RN_daysOpen);

	// }

	// start of days calculation
		$rficlosedLog = RequestForInformationStatus::getClosedDateDetails($database,$RN_rfi_id);
		$rfiopenarr = $rficlosedLog['open'];
		$rficlosedarr = $rficlosedLog['closed'];

		$openingdate = explode(' ', $RN_rfi_created_date);
		// adding the open date
		array_unshift($rfiopenarr , $openingdate[0]);
		$RN_daysOpen =0;
		if(!empty($rficlosedLog))
		{

		foreach ($rfiopenarr as $key => $cdate) {
			$date1=date_create($cdate);
			$date2=date_create($rficlosedarr[$key]);
			$diff=date_diff($date1,$date2);
 			$diff3= $diff->format("%a");
			$RN_daysOpen =$RN_daysOpen + intval($diff3);
		}
		}
		// End of days calculation

		// There was an instance of $daysOpen showing as "-0"
	if (($RN_daysOpen == 0) || ($RN_daysOpen == '-0')) {
		$RN_daysOpen = 0;
	}
	
	$arrayTemp['id'] = $RN_rfi_id;
	$arrayTemp['sequence_no'] = $RN_rfi_sequence_number;
	$arrayTemp['title'] = $RN_escaped_rfi_title;
	$arrayTemp['status'] = $RN_request_for_information_status;
	// $arrayTemp['subcontractor'] = $RN_suInitiatorContactCompanyName;
	$arrayTemp['cost_code'] = $RN_formattedRfiCostCode;
	$arrayTemp['days_open'] = $RN_daysOpen;
	$arrayTemp['priority'] = $RN_request_for_information_priority;
	$arrayTemp['recipient'] = $RN_rfiRecipientContactFullNameHtmlEscaped;
	$arrayTemp['created_date'] = $RN_formattedRfiCreatedDate;	
	$arrayTemp['reference'] = $RN_escaped_rfi_plan_page_reference;	
	$arrayTemp['file_url'] = $RN_rfiPdfUrl;
	$arrayTemp['file_access'] = $accessFiles;

	$arrayStoreIndex[] = $arrayTemp;
}

$RN_jsonEC['data']['RfiData'] = array_values($arrayStoreIndex);
// Filter
$RN_jsonEC['data']['filter'][] = 'All';
$RN_jsonEC['data']['filter'][] = 'Sort By';
$RN_jsonEC['data']['filter'][] = 'Filter By';

// Filter By
$RN_jsonEC['data']['filter_by'][] = array();
$RN_jsonEC['data']['filter_by'][1][] = 'ASC';
$RN_jsonEC['data']['filter_by'][1][] = 'DESC';
$RN_jsonEC['data']['filter_by'][2][] = 'All';
$RN_jsonEC['data']['filter_by'][2][] = 'Open';
$RN_jsonEC['data']['filter_by'][2][] = 'Closed';

<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('lib/common/SubmittalStatus.php');

$RN_jsonEC['data'] = null;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['SubmittalData'] = null;
// order by
$RN_orderby = '';
if($RN_sort !='' && $RN_sort != null && $RN_sort != 'Latest' ){
	$RN_orderby = "\nORDER BY su_fk_initiator_ccs.`company` IS NULL $RN_sort, su_fk_initiator_ccs.`company` $RN_sort, concat_costcode IS NULL $RN_sort, concat_costcode $RN_sort, su_fk_initiator_ccs.`company` $RN_sort";
} else if($RN_sort == 'Latest') {
	$RN_orderby = "\nORDER BY su.`id` DESC";
}
$RN_where = '';
// Filter by cost code
if($RN_filterType == 'cost_code'){
	if($RN_filterValue != 'No Trade' && $RN_filterValue != 'All'){
		$RN_filterValueEx = explode('-', $RN_filterValue);
		$RN_divisionWhere = $RN_filterValueEx[0];
		$RN_costCodeWhere = $RN_filterValueEx[1];
		$RN_where = "AND su_fk_code_division.`division_number` = '$RN_divisionWhere' AND su_fk_codes.`cost_code` = '$RN_costCodeWhere'";
	}else if($RN_filterValue == 'All'){
		$RN_where = '';
	}
	else{
		$RN_divisionWhere = '';
		$RN_costCodeWhere = '';
		$RN_where = "AND su_fk_code_division.`division_number` IS NULL AND su_fk_codes.`cost_code` IS NULL";
	}
}
// Filter by subcontractor
if($RN_filterType == 'contractor'){
	if($RN_filterValue == 'All'){
		$RN_where = '';
	}else if($RN_filterValue == 'No Trade'){
		$RN_where = "AND su_fk_initiator_ccs.`company` IS NULL";
	}
	else{
		$RN_where = "AND su_fk_initiator_ccs.`company` = '$RN_filterValue'";
	}	
}

// load submittals
$RN_loadSubmittalsByProjectIdOptions = new Input();
$RN_loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
$RN_arrSubmittals = Submittal::loadSubmittalsByProjectIdUsingApi($database, $RN_project_id, $RN_loadSubmittalsByProjectIdOptions, $RN_orderby, $RN_where);
//  For Filter
$RN_arrCostCode = array(-1 => 'All');
$RN_arrCostCodeTmp = array();
$RN_arrSubcontractor = array(-1 => 'All');
$RN_arrSubcontractorTmp = array();
$noTradeYes = false;
$noTradeYesContractor = false;
if($RN_page == 1)
{
	foreach ($RN_arrSubmittals as $RN_submittal_id => $RN_submittal) {
		$arrayTemp = array();

		$RN_submittalStatus = $RN_submittal->getSubmittalStatus();
		$RN_submittal_status = $RN_submittalStatus->submittal_status;
		/* @var $submittalStatus SubmittalStatus */

		$RN_suFileManagerFile = $RN_submittal->getSuFileManagerFile();
		/* @var $suFileManagerFile FileManagerFile */

		$RN_suCostCode = $RN_submittal->getSuCostCode();
		/* @var $suCostCode CostCode */

		if ($RN_suCostCode) {
			// Extra: Submittal Cost Code - Cost Code Division
			$RN_suCostCodeDivision = $RN_suCostCode->getCostCodeDivision();
			/* @var $suCostCodeDivision CostCodeDivision */

			$RN_formattedSuCostCode = $RN_suCostCode->getFormattedCostCodeApi($database, false, $RN_user_company_id);

			//$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCodeApi($database);
		} else {
			$RN_formattedSuCostCode = null;
		}
	// contact initiator
		$RN_suInitiatorContact = $RN_submittal->getSuInitiatorContact();
		if(isset($RN_suInitiatorContact) && !empty($RN_suInitiatorContact)){
			$RN_suInitiatorContactCompanyId = $RN_suInitiatorContact->contact_company_id;
			$RN_suInitiatorContactCompany = ContactCompany::findById($database, $RN_suInitiatorContactCompanyId);
		// contact company name
			$RN_suInitiatorContactCompanyName = $RN_suInitiatorContactCompany->contact_company_name;
		} else {
		// contact company name
			$RN_suInitiatorContactCompanyName = null;
		}

		// submittal title
		$RN_escaped_su_title = $RN_submittal->su_title;
		$RN_su_sequence_number = $RN_submittal->su_sequence_number;
		$RN_submittal_type_id = $RN_submittal->submittal_type_id;

		// Subcontractor 
		$subcontractorFormatFilter = $RN_suInitiatorContactCompanyName;		

		if($RN_suInitiatorContactCompanyName == null) {
			$RN_suInitiatorContactCompanyName = 'No Trade';
			$noTradeYesContractor = true;
		}else{
			$RN_arrSubcontractorTmp[$subcontractorFormatFilter] = $subcontractorFormatFilter;
		}
		// cost code for filter
		if($RN_formattedSuCostCode == null) {
			$costCodeFormatFilter = $RN_suInitiatorContactCompanyName;	
			$noTradeYes = true;
			$costCodeInteger = '';
		} else {
			$costCodeFormatFilter = $RN_formattedSuCostCode;
			$costCodeIntegerEX = explode('-',$costCodeFormatFilter);
			$costCodeInteger = join('', $costCodeIntegerEX);
			$costCodeInteger = intVal($costCodeInteger);
		}
		if($costCodeInteger != null){
			$RN_arrCostCodeTmp[$costCodeInteger] = $costCodeFormatFilter;
		}		

	}
}
// Cost code sort
ksort($RN_arrCostCodeTmp);
if(!empty($RN_arrCostCodeTmp)){
	if($noTradeYes){
		array_push($RN_arrCostCodeTmp, 'No Trade');
	}
	$RN_arrCostCode = array_merge($RN_arrCostCode, $RN_arrCostCodeTmp);
}
// subcontract sort
ksort($RN_arrSubcontractorTmp);
if(!empty($RN_arrSubcontractorTmp)){
	if($noTradeYesContractor){
		array_push($RN_arrSubcontractorTmp, 'No Trade');
	}
	$RN_arrSubcontractor = array_merge($RN_arrSubcontractor, $RN_arrSubcontractorTmp);
}
// lazy load calculation
$RN_per_page = $RN_per_page;
$RN_total_rows = count($RN_arrSubmittals);
if($RN_listAll) {
	$RN_per_page = $RN_total_rows;
}
$RN_pages = ceil($RN_total_rows / $RN_per_page);
$RN_current_page = isset($RN_page) ? $RN_page : 1;
$RN_current_page = ($RN_total_rows > 0) ? min($RN_page, $RN_current_page) : 1;
$RN_start = $RN_current_page * $RN_per_page - $RN_per_page;
$RN_prev_page = ($RN_current_page > 1) ? ($RN_current_page-1) : null;
$RN_next_page = ($RN_current_page > ($RN_pages-1)) ? null : ($RN_current_page+1);

$RN_arrSubmittals = array_slice($RN_arrSubmittals, $RN_start, $RN_per_page); 
$RN_jsonEC['data']['total_row'] = $RN_total_rows;
$RN_jsonEC['data']['total_pages'] = $RN_pages;
$RN_jsonEC['data']['per_pages'] = $RN_per_page;
$RN_jsonEC['data']['from'] = ($RN_start+1);
$RN_jsonEC['data']['to'] = ((($RN_start+$RN_per_page)-1) > $RN_total_rows-1) ? $RN_total_rows : ($RN_start+$RN_per_page);
$RN_jsonEC['data']['prev_page'] = $RN_prev_page;
$RN_jsonEC['data']['current_page'] = $RN_current_page;
$RN_jsonEC['data']['next_page'] = $RN_next_page;
$arrayStoreIndex = array();
foreach ($RN_arrSubmittals as $RN_submittal_id => $RN_submittal) {
	$arrayTemp = array();
	$RN_su_id = $RN_submittal->submittal_id;
	$RN_submittalStatus = $RN_submittal->getSubmittalStatus();
	$RN_submittal_status = $RN_submittalStatus->submittal_status;
	/* @var $submittalStatus SubmittalStatus */

	$RN_suFileManagerFileRaw = $RN_submittal->getSuFileManagerFile();
	/* @var $suFileManagerFile FileManagerFile */

	$RN_suCostCode = $RN_submittal->getSuCostCode();
	/* @var $suCostCode CostCode */

	if ($RN_suCostCode) {
			// Extra: Submittal Cost Code - Cost Code Division
		$RN_suCostCodeDivision = $RN_suCostCode->getCostCodeDivision();
		/* @var $suCostCodeDivision CostCodeDivision */

		$RN_formattedSuCostCode = $RN_suCostCode->getFormattedCostCodeApi($database, false, $RN_user_company_id);

			//$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCodeApi($database);
	} else {
		$RN_formattedSuCostCode = null;
	}
	// contact initiator
	$RN_suInitiatorContact = $RN_submittal->getSuInitiatorContact();
	if(isset($RN_suInitiatorContact) && !empty($RN_suInitiatorContact)){
		$RN_suInitiatorContactCompanyId = $RN_suInitiatorContact->contact_company_id;
		$RN_suInitiatorContactCompany = ContactCompany::findById($database, $RN_suInitiatorContactCompanyId);
		// contact company name
		$RN_suInitiatorContactCompanyName = $RN_suInitiatorContactCompany->contact_company_name;
	} else {
		// contact company name
		$RN_suInitiatorContactCompanyName = null;
	}
	
	// submittal title
	$RN_escaped_su_title = $RN_submittal->su_title;
	$RN_su_sequence_number = $RN_submittal->su_sequence_number;
	$RN_submittal_type_id = $RN_submittal->submittal_type_id;
	$RN_suPdfUrl = null;
	$accessFiles = null;
	if(isset($RN_suFileManagerFileRaw->file_manager_file_id) && $RN_suFileManagerFileRaw->file_manager_file_id != null)  {
		$RN_suFileManagerFile = FileManagerFile::findById($database, $RN_suFileManagerFileRaw->file_manager_file_id);
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
	

	if($RN_suInitiatorContactCompanyName == null) {
		$RN_suInitiatorContactCompanyName = 'No Trade';
	}
	if($RN_formattedSuCostCode == null) {
		$RN_formattedSuCostCode = '-';
	}
	
	$arrayTemp['su_id'] = $RN_su_id;
	$arrayTemp['id'] = $RN_su_sequence_number;
	$arrayTemp['title'] = $RN_escaped_su_title;
	$arrayTemp['status'] = $RN_submittal_status;
	$arrayTemp['subcontractor'] = $RN_suInitiatorContactCompanyName;
	$arrayTemp['cost_code'] = $RN_formattedSuCostCode;
	$arrayTemp['file_url'] = $RN_suPdfUrl;
	$arrayTemp['file_access'] = $accessFiles;

	$arrayStoreIndex[$RN_suInitiatorContactCompanyName.'-'.$RN_formattedSuCostCode]['title'] = $RN_suInitiatorContactCompanyName;
	$arrayStoreIndex[$RN_suInitiatorContactCompanyName.'-'.$RN_formattedSuCostCode]['expand'] = true;
	$arrayStoreIndex[$RN_suInitiatorContactCompanyName.'-'.$RN_formattedSuCostCode]['code'] = $RN_formattedSuCostCode;
	$arrayStoreIndex[$RN_suInitiatorContactCompanyName.'-'.$RN_formattedSuCostCode]['data'][] = $arrayTemp;
}

$RN_jsonEC['data']['SubmittalData'] = array_values($arrayStoreIndex);
// $RN_jsonEC['data']['filter'][0] = 'All';
// $RN_jsonEC['data']['filter'][1] = 'Sort By Cost Code';
// // $RN_jsonEC['data']['filter'][2] = 'Sort By Subcontractors';
// $RN_jsonEC['data']['filter'][2] = 'Filter By Cost Code';
// $RN_jsonEC['data']['filter'][3] = 'Filter By Subcontractor';

// $RN_jsonEC['data']['filter_by'][0] = array();
// // Sort By Cost Code
// $RN_jsonEC['data']['filter_by'][1][] = 'ASC';
// $RN_jsonEC['data']['filter_by'][1][] = 'DESC';
// Sort By Subcontractors
// $RN_jsonEC['data']['filter_by'][2][] = 'ASC';
// $RN_jsonEC['data']['filter_by'][2][] = 'DESC';
// Filter By Cost Code
$RN_jsonEC['data']['filter_cost_code'] = array_values($RN_arrCostCode);
// Filter By Subcontractors
$RN_jsonEC['data']['filter_contractor'] = array_values($RN_arrSubcontractor);

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

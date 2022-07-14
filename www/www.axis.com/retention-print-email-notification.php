<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['display'] = false;
$init['application'] = 'www.axis.com';

require_once('lib/common/init.php');
require_once("dompdf/dompdf_config.inc.php");
require_once('lib/common/Pdf.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/Project.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/UserCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/Logo.php');
require_once('lib/common/ImageManagerImage.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
require_once('lib/common/Format.php');
require_once('lib/common/ContractingEntities.php');
require_once('lib/common/RetentionDraws.php');
require_once('lib/common/RetentionSignatureBlocks.php');
require_once('lib/common/RetentionSignatureBlocksConstructionLender.php');
require_once('modules-draw-signature-block-functions.php');
require_once('modules-draw-list-function.php');
require_once('lib/common/RetentionDrawFileManagerFiles.php');

$user_company_id = $session->getUserCompanyId();
$currently_active_contact_id = $session->getCurrentlyActiveContactId();

$ret_id = intVal($get->ret_id);
$application_number = intVal($get->ret_app_id);
$draw_action_type_id = intVal($get->draw_action_type_id);
$draw_action_type_option_id = intVal($get->draw_action_type_option_id);
$architectureBlock = $get->architectureBlock;
$narrative_flag = $get->narrative_flag;
$general_condition_flag = $get->general_condition_flag;
$cost_code_alias = $get->cost_code_alias;

$last_draw_id = RetentionDraws::findLastDrawIdforRetention($database,$ret_id);
$draw_application_number = DrawItems::getDrawApplicationNumber($database,$last_draw_id);

/* get Draws*/
$getDrawArr = RetentionDraws::findById($database, $ret_id);
$drawThroughDate = $getDrawArr->through_date;
$drawInvoiceDate = $getDrawArr->invoice_date;
$drawThroughDate_form = date('m/d/Y', strtotime($drawThroughDate));
$drawThroughDateFormat = date('m-d-Y', strtotime($drawThroughDate));
$drawInvoiceDate = date('m/d/Y', strtotime($drawInvoiceDate));
$drawStatus = $getDrawArr->status;
$drawIsDeletedFlag = $getDrawArr->is_deleted_flag;
$drawEntityId = $getDrawArr->contracting_entity_id;

$postedAt = $getDrawArr->posted_at;
$drawPostedAt = '';
if($postedAt != '0000-00-00' && $postedAt != ''){
$drawPostedAt = date('m/d/Y', strtotime($postedAt));
} else {
$drawPostedAt = '';
}

$drawPostedDate = $drawStatus == 2 ? $drawPostedAt : $drawThroughDate_form;

$project_id = $session->getCurrentlySelectedProjectId();
$project = Project::findProjectByIdExtended($database, $project_id);
$corDisplay = $project->COR_type;

$ownerAddressHtml = Project::getOwnerAddress($database,$project_id);
$projectOwner_address = $ownerAddressHtml['address'];
$projectOwner_address = $projectOwner_address ? $projectOwner_address.' <br/>' : '';
$ownerAddress  = $ownerAddressHtml['address1'];
$ownerAddressHtml = <<<OWNERADDRESS
$ownerAddress
OWNERADDRESS;

$projectOwnerName = $project->project_owner_name;
$projectContractDate = $project->project_contract_date;

if($projectContractDate != '0000-00-00' && $projectContractDate != ''){
	$projectContractDate = date('m/d/Y', strtotime($projectContractDate));
} else {
	$projectContractDate = '';
}

$periodTo = $drawPostedDate;
$projectName = $project->project_name;
$project_address_line_1 = $project->address_line_1;
$project_address_city = $project->address_city;
$project_address_state_or_region = $project->address_state_or_region;
$project_address_county = $project->address_county;
$project_address_postal_code = $project->address_postal_code;
$project_address_postal_code_extension = $project->address_postal_code_extension;
$addressArr = array();
if($project_address_line_1 != '') {
	$addressArr[] = $project_address_line_1;
}
if($project_address_city != '') {
	$addressArr[] = $project_address_city;
}
if($project_address_state_or_region != '') {
	$addressArr[] = $project_address_state_or_region;
}
// $addressArr[] = $project_address_postal_code;
$arrImplode = implode(', ', $addressArr);
$projectAddressHtml = <<<PROJECTADDRESS
$arrImplode $project_address_postal_code
PROJECTADDRESS;
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $project->user_company_id);
$userCompanyName = $userCompany->user_company_name;

$loadContactCompanyOfficesByContactCompanyIdOptions = new Input();
$loadContactCompanyOfficesByContactCompanyIdOptions->forceLoadFlag = true;
$arrGCContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $project->user_company_id, $loadContactCompanyOfficesByContactCompanyIdOptions);
$officeAddressHtml = '';
$i = 0;
foreach($arrGCContactCompanyOffices as $officeId => $officeAddress) {
	if($i > 0){
		break;
	}
	$office_address_line_1 = $officeAddress->address_line_1;
	$office_address_line_2 = $officeAddress->address_line_2;
	$office_address_city = $officeAddress->address_city;
	$office_address_state_or_region = $officeAddress->address_state_or_region;
	$office_address_country = $officeAddress->address_country;
	$office_address_postal_code = $officeAddress->address_postal_code;
	$addressOfficeArr = array();
	if($office_address_line_1 != '') {
		$addressOfficeArr[] = $office_address_line_1;
	}
	if($office_address_line_2 != '') {
		$addressOfficeArr[] = $office_address_line_2;
	}
	if($office_address_city != '') {
		$addressOfficeArr[] = $office_address_city;
	}
	if($office_address_state_or_region != '') {
		$addressOfficeArr[] = $office_address_state_or_region;
	}
	$arrImplodeOff = implode(', ', $addressOfficeArr);
	$officeAddressHtml = <<<PROJECTADDRESS
	$arrImplodeOff $office_address_postal_code
PROJECTADDRESS;
	$i++;
}
$uri = Zend_Registry::get('uri');

$htmlContentCss = <<<HTMLCONTENT
<link href="{$uri->http}css/draw-print-pdf.css" rel="stylesheet" type="text/css">
HTMLCONTENT;

// get Signature Blocks
$loadSignatureBlockOptions = new Input();
$loadSignatureBlockOptions->forceLoadFlag = true;
$getAllDrawSignatureBlockArr = RetentionSignatureBlocks::loadAllRetentionSignatureBlocks($database, $ret_id, $loadSignatureBlockOptions);

$arrSignatureBlockList = array();
$contractorName = "";
$ownerName = "";
$architectName = "";

foreach($getAllDrawSignatureBlockArr as $signatureBlockId => $signatureBlock) {
	$signature_type_id = $signatureBlock->signature_type_id;
	$arrSignatureBlockList[$signature_type_id]['signature_block_description'] = $signatureBlock->signature_block_description;
	if($signature_type_id == 1 && $signatureBlock->signature_block_description == 'N') {
		$arrSignatureBlockList[$signature_type_id]['signature_block_description'] = $userCompanyName;
	}
	if($signature_type_id == 2 && $signatureBlock->signature_block_description == 'N') {
		$arrSignatureBlockList[$signature_type_id]['signature_block_description'] = $projectOwnerName;
	}
	$arrSignatureBlockList[$signature_type_id]['signature_block_id'] = $signatureBlock->signature_block_id;
	$arrSignatureBlockList[$signature_type_id]['signature_type_id'] = $signatureBlock->signature_type_id;

	$arrSignatureBlockList[$signature_type_id]['enable_flag'] = $signatureBlock->enable_flag;
	$arrSignatureBlockList[$signature_type_id]['signature_block_desc_update_flag'] = $signatureBlock->signature_block_desc_update_flag;
	$signBlockConstructionLender = $signatureBlock->getSignatureBlockConstructionLender();

	if($signature_type_id == 5 && isset($signBlockConstructionLender) && !empty($signBlockConstructionLender)) {
		$arrSignatureBlockList[$signature_type_id]['address_1'] = $signBlockConstructionLender->signature_block_construction_lender_address_1;
		$arrSignatureBlockList[$signature_type_id]['address_2'] = $signBlockConstructionLender->signature_block_construction_lender_address_2;
		$arrSignatureBlockList[$signature_type_id]['city_state_zip'] = $signBlockConstructionLender->signature_block_construction_lender_city_state_zip;
	}
}

//  Contractor Name
$entityName = ContractingEntities::getcontractEntityNameforProject($database,$drawEntityId);
$contractorName = $entityName;

// Owner Name
$ownerEnableFalg = false;
if(isset($arrSignatureBlockList[2]) && !empty($arrSignatureBlockList[2])){
	if($arrSignatureBlockList[2]['enable_flag'] == 'Y' && $arrSignatureBlockList[2]['signature_block_desc_update_flag'] == 'Y') {
		$ownerName = $arrSignatureBlockList[2]['signature_block_description'];
		$ownerEnableFalg = true;
	} else if($arrSignatureBlockList[2]['enable_flag'] == 'Y' && $arrSignatureBlockList[2]['signature_block_desc_update_flag'] == 'N') {
		$ownerName = $projectOwnerName;
		$ownerEnableFalg = true;
	} else {
		$ownerName = "";
		$ownerEnableFalg = false;
	}
} else {
	$ownerEnableFalg = false;
}
$ownerHtml = '';
$ownerNameHtml = '';
$ownerTdHtml = '';
if($ownerEnableFalg) {
	$ownerHtml = <<<OWNERHTML
	<td class="fontSize11 width10per">TO (OWNER):</td>
OWNERHTML;
	$ownerNameHtml = <<<OWNERHTML
	<td rowspan="3" class="fontSize11">$ownerName <br/> $projectOwner_address  $ownerAddressHtml </td>
OWNERHTML;

}

//  Architect Name
if(isset($arrSignatureBlockList[3]) && !empty($arrSignatureBlockList[3])){
	if($arrSignatureBlockList[3]['enable_flag'] == 'Y' && $arrSignatureBlockList[3]['signature_block_desc_update_flag'] == 'Y') {
		$architectName = $arrSignatureBlockList[3]['signature_block_description'];
	} else {
		$architectName = "";
	}
}

// Notary Block Enable
if(isset($arrSignatureBlockList[4]) && !empty($arrSignatureBlockList[4])){
	if($arrSignatureBlockList[4]['enable_flag'] == 'Y' ) {
		$notaryBlock = true;
	} else {
		$notaryBlock = false;
	}
} else {
	$notaryBlock = false;
}

$notaryBlockHtml = "";
if($notaryBlock) {
	$notaryBlockHtml = <<<NOTARYBLOCK
	<div class="width40per paddingRight10" style="page-break-before: always !important;">
		<div class="notaryBlock">
			<p class="paragraphTemp">State Of:&nbsp;&nbsp; <span class="textBold fontSize13">_____________</span>&nbsp;&nbsp;&nbsp;&nbsp;Country Of: &nbsp; <span class="textBold fontSize13">_____________</span> Subscribed and sworn to (or affirmed)before me on this <span class="textBold fontSize13">_______</span> day of <span class="textBold fontSize13">_____________</span> , 20 <span class="textBold fontSize13">____</span> , by <span class="textBold fontSize13">_____________</span> proved to me on the basis of satisfactory evidence to be the person(s) who appeared before me.</p>
			<table class="appNotaryBlockTable" cellpadding="5">
				<tr>
					<td class="fontSize11">
						Notary Public: <span class="textBold fontSize13">__________________________________</span>
					</td>
				</tr>
				<tr>
					<td class="fontSize11">
						My Commission expires: <span class="textBold fontSize13">________________________</span>
					</td>
				</tr>
			</table>
		</div>
	</div>
NOTARYBLOCK;
}

// Construction Lender Block Enable
if(isset($arrSignatureBlockList[5]) && !empty($arrSignatureBlockList[5])){
	if($arrSignatureBlockList[5]['enable_flag'] == 'Y' ) {
		$clBlock = true;
		$clName = $arrSignatureBlockList[5]['signature_block_description'];
		// print_r($arrSignatureBlockList[5]);
		$address_1 = $arrSignatureBlockList[5]['address_1'];
		$address_2 = $arrSignatureBlockList[5]['address_2'];
		$city_state_zip = $arrSignatureBlockList[5]['city_state_zip'];
		$arrayClAddress = array();
		if($address_1!= '' && $address_1 != Null && $address_1 !=NULL){
			$arrayClAddress[] = $address_1;
		}
		if($address_2!= '' && $address_2 != Null && $address_2 !=NULL){
			$arrayClAddress[] = $address_2;
		}
		if($city_state_zip!= '' && $city_state_zip != Null && $city_state_zip !=NULL){
			$arrayClAddress[] = $city_state_zip;
		}
		$arrImplodeCl = implode(', ', $arrayClAddress);
		$clAddressHtml = <<<CLHTML
	<span>
		$arrImplodeCl
	</span>
CLHTML;
	} else {
		$clBlock = false;
		$clName = '';
		$clAddressHtml = '';
	}

} else {
	$clBlock = false;
	$clName = '';
	$clAddressHtml = '';
}

$clHeaderHtml = '';
$clNameHtml = '';
$clAddressTdHtml = '';
if($clBlock) {
	$clHeaderHtml = <<<CLHTML
	<td class="fontSize11">CONSTRUCTION LENDER:</td>
CLHTML;
	$clNameHtml = <<<CLHTML
	<td class="fontSize11" rowspan="3">$clName <br> $clAddressHtml</td>
CLHTML;
}

$options_draw = '';
$overallnarrativeHtml = '';
$OverAllTotalTr="";
if(!empty($general_condition_flag) && $general_condition_flag =='true' && $narrative_flag =='true'){
	$options_draw = 3;
	$overallnarrativeHtml = '<td></td>';
}else if(!empty($narrative_flag) && $narrative_flag =='true'){
    $options_draw = 1;
    $overallnarrativeHtml = '<td></td>';
}else if(!empty($general_condition_flag) && $general_condition_flag =='true'){
	$options_draw = 2;
}

/** Draw Grid Html Content Starts **/

	$drawGridRawContent = renderRetentionDrawGridHtmlForPDF($database,$project_id, $last_draw_id, $draw_application_number,false,$options_draw,$corDisplay,$cost_code_alias,$ret_id);

	$drawCOGridRawContent = renderRetentionChangeOrderGridHtmlForPDF($database,$project_id, $last_draw_id, $draw_application_number,false,$options_draw,$corDisplay,$cost_code_alias,$ret_id);

	$drawContentTableData = $drawGridRawContent['budgetListTableBody'];

	$drawCOContentTableData = '';
	if ($corDisplay == 1) {
		$drawCOContentTableData = $drawCOGridRawContent['orderTableBody'];
	}
	
/** Draw Grid Html Content Ends **/

/** Change Order Summary Calculation Starts **/

	$drawCOGridValues = renderChangeOrderValuesForPDF($database,$project_id, $last_draw_id, $draw_application_number);	
	
	// Prev Positive OCO
	$prevPositiveOCO = $drawCOGridValues['prevtotalAdditionValue'];
	$prevPositiveOCOFormatted = $prevPositiveOCO ? formatNegativeValues($prevPositiveOCO) : '$0.00';

	// Prev Negative OCO
	$prevNegativeOCO = $drawCOGridValues['prevtotalDeductionValue'];
	$prevNegativeOCOFormatted = $prevNegativeOCO ? formatNegativeValues($prevNegativeOCO) : '$0.00';

	// Current Positive OCO
	$currentPositiveOCO = $drawCOGridValues['totalAdditionValue'];
	$currentPositiveOCOFormatted = $currentPositiveOCO ? formatNegativeValues($currentPositiveOCO) : '$0.00';

	// Current Negative OCO
	$currentNegativeOCO = $drawCOGridValues['totalDeductionValue'];
	$currentNegativeOCOFormatted = $currentNegativeOCO ? formatNegativeValues($currentNegativeOCO) : '$0.00';

	// Total Positive OCO 
	$totalPositiveOCO = $prevPositiveOCO + $currentPositiveOCO;
	$totalPositiveOCOFormatted = $totalPositiveOCO ? formatNegativeValues($totalPositiveOCO): '$0.00';

	// Total Negative OCO 
	$totalNegativeOCO = $prevNegativeOCO + $currentNegativeOCO;
	$totalNegativeOCOFormatted = $totalNegativeOCO ? formatNegativeValues($totalNegativeOCO): '$0.00';

	// Net Change Order
	$netOwnerChangeOrder = $totalPositiveOCO + $totalNegativeOCO;

/** Change Order Summary Calculation Ends **/

/** Overall Total Starts **/
	
	// Total SCHEDULED VALUE
	$totalOriginalScheduledValue = $drawGridRawContent['totalOriginalScheduledValue'];	
	$totalScheduledValueFormatted = $totalOriginalScheduledValue ? formatNegativeValues($totalOriginalScheduledValue) : '$0.00';

	// Total PRIOR REALLOCATION
	$totalPriorReallocation = $drawGridRawContent['totalPrevRealocation'];
	$totalPriorReallocationFormatted = $totalPriorReallocation ? formatNegativeValues($totalPriorReallocation) : '$0.00';

	// Total OWNER CHANGE ORDER
	$totalOwnerChangeOrder = $drawGridRawContent['totalChangeOrderCostCodeVal'];
	$totalOwnerChangeOrderFormatted = $totalOwnerChangeOrder ? formatNegativeValues($totalOwnerChangeOrder) : '$0.00';

	// Total REVISED SCHEDULED VALUE
	$totalRevisedSchVal = $drawGridRawContent['totalrevisedScheduledValue'] + $drawCOGridRawContent['totalScheduleValue'];
	$totalRevisedSchValFormatted = $totalRevisedSchVal ? formatNegativeValues($totalRevisedSchVal) : '$0.00';

	// Total FROM PREVIOUS APPLICATION
	$totalFromPrevApp = $drawGridRawContent['totalCoPreviousAppValule'] + $drawCOGridRawContent['totalCoPreviousAppValule'];
	$totalFromPrevAppFormatted =  $totalFromPrevApp ? formatNegativeValues($totalFromPrevApp) : '$0.00';

	// Total THIS PERIOD
	$totalThisPeriod = $drawGridRawContent['totalCoCurrentAppValue'] + $drawCOGridRawContent['totalCoCurrentAppValue'];
	$totalThisPeriodFormatted =  $totalThisPeriod ? formatNegativeValues($totalThisPeriod) : '$0.00';

	// Total TOTAL COMPLETED AND STORED TO DATE
	$totalCompAndStoredToDate = $drawGridRawContent['totalCoCompletedAppValue'] + $drawCOGridRawContent['totalCoCompletedAppValue'];
	$totalCompAndStoredToDateFormatted = $totalCompAndStoredToDate ? formatNegativeValues($totalCompAndStoredToDate) : '$0.00';

	// Total % (G/ C)
	$totalGByC = ($totalCompAndStoredToDate / $totalRevisedSchVal) * 100;
	$totalGByCFomatted = $totalGByC ? formatNegativeValuesWithoutSymbol($totalGByC) : '0.00';

	// Total BALANCE TO FINISH (C- G)
	$totalBalanceToFinish = $drawGridRawContent['totalBalanceValue'] + $drawCOGridRawContent['totalBalanceValue'];
	$totalBalanceToFinishFormatted = $totalBalanceToFinish ? formatNegativeValues($totalBalanceToFinish) : '$0.00';

	// Total RETENTION
	$totalRetention = $drawGridRawContent['totalCoRetainageValue'] + $drawCOGridRawContent['totalCoRetainageValue'];
	$totalRetentionFormatted = $totalRetention ? formatNegativeValues($totalRetention) : '$0.00';

	// Total RETENTION BILLING
	$totalRetentionBilling = $drawGridRawContent['totalRetBillAmt'] + $drawCOGridRawContent['totalCoRetBillAmt'];
	$totalRetentionBillingFormatted = $totalRetentionBilling ? formatNegativeValues($totalRetentionBilling) : '$0.00';	

/** Overall Total Ends **/


/** First Page calulation Starts **/

	// ORIGINAL CONTRACT VALUE
	$originalContractValueFormatted = $totalOriginalScheduledValue ? formatNegativeValues($totalOriginalScheduledValue) : '$0.00';

	// NET CHANGE ORDERS
	$netChangeOrdersFormatted = $netOwnerChangeOrder ? formatNegativeValues($netOwnerChangeOrder) : '$0.00';

	// CONTRACT SUM TO DATE (Line 1 +/- Line 2)
	$contractSumToDate = $totalOriginalScheduledValue + $netOwnerChangeOrder;
	$contractSumToDateFormatted = $contractSumToDate ? formatNegativeValues($contractSumToDate) : '$0.00';

	// TOTAL COMPLETED & STORED TO DATE (Column G)
	$totalCompAndStoredToDateColGFormatted =  $totalCompAndStoredToDate ? formatNegativeValues($totalCompAndStoredToDate) : '$0.00';

	// LESS RETENTION
	$lessRetentionFormatted =  $totalRetention ? formatNegativeValues($totalRetention) : '$0.00';

	// TOTAL EARNED LESS RETENTION (Line 4 Less Line 5 Total)
	$contractApTotalEarnedValue = $totalCompAndStoredToDate - $totalRetention;
	$totalEarnedLessRetentionFormatted =  $contractApTotalEarnedValue ? formatNegativeValues($contractApTotalEarnedValue) : '$0.00';

	// LESS PREVIOUS CERTIFICATES FOR PAYMENT (Line 6 From Prior Application)
	$prevDrawRetention = $drawGridRawContent['totalPrevRetainerValue'] + $drawCOGridRawContent['totalPrevRetainerValue'];
	$lessPrevCertForPayment = $totalCompAndStoredToDate - $prevDrawRetention;
	$lessPrevCertForPaymentFormatted = $lessPrevCertForPayment ? formatNegativeValues($lessPrevCertForPayment) : '$0.00';

	// CURRENT PAYMENT DUE (Line 6 Less Line 7)
	$currentPaymentDue = $contractApTotalEarnedValue - $lessPrevCertForPayment;
	$currentPaymentDueFormatted = $currentPaymentDue ? formatNegativeValues($currentPaymentDue) : '$0.00';

	// BALANCE TO FINISH, PLUS RETENTION (Line 3 Less Line 6)
	$contractApBalanceValue = $contractSumToDate - $contractApTotalEarnedValue;
	$balanceToFinishFomatted =  $contractApBalanceValue ? formatNegativeValues($contractApBalanceValue) : '$0.00';

/** First Page calulation Ends **/

$totalChangeOrderHtml = '';
if ($corDisplay == 2) { 
	$totalChangeOrderHtml = '<td class="textBold textAlignRight" nowrap>'.$totalOwnerChangeOrderFormatted.'</td>';
}

if ($corDisplay == 1) {
	$OverAllTotalTr .= <<<END_DRAW_TABLE_TBODY
	<tr class="change_orders_row">
	  <td class="textBold textAlignRight" colspan="2">OVERALL TOTAL</td>
	  <td class="textBold textAlignRight" nowrap>$totalScheduledValueFormatted</td>
	  <td class="textBold textAlignRight" nowrap>$totalPriorReallocationFormatted</td>
	  $totalChangeOrderHtml
	  <td class="textBold textAlignRight" nowrap>$totalRevisedSchValFormatted</td>
	  <td class="textBold textAlignRight" nowrap>$totalFromPrevAppFormatted</td>
	  <td class="textBold textAlignRight" nowrap>$totalThisPeriodFormatted</td>
	  <td class="textBold textAlignRight" nowrap>$0.00</td>
	  <td class="textBold textAlignRight" nowrap>$totalCompAndStoredToDateFormatted</td>
	  <td class="textBold textAlignRight" nowrap>$totalGByCFomatted</td>
	  <td class="textBold textAlignRight" nowrap>$totalBalanceToFinishFormatted</td>
	  <td class="textBold textAlignRight" nowrap>$totalRetentionFormatted</td>
	  <td class="textBold textAlignRight" nowrap>$totalRetentionBillingFormatted</td>
	  $overallnarrativeHtml
	</tr>
END_DRAW_TABLE_TBODY;
}

/* Html Content */
//Fulcrum logo and footer content
$fulcrum = Logo::fulcrumlogoforfooterByBasePath(true);
$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database, $user_company_id);

$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
	<tr>
	<td>$gcLogo</td>
	</tr>
	</table>
headerLogo;

$architectureBlockHtml = '';
if(!empty($architectureBlock) && $architectureBlock =='true'){
	$architectureBlockHtml =<<<ARCHITECTBLOCK
				<hr />
				<h6 class="bottom0 paddingLeft5">ARCHITECT'S CERTIFICATE FOR PAYMENT</h6>
				<p class="paragraphTemp marBottom0 lineHeight15">In accordance with the Contract Documents, based on on-site observations and the data comprising this application, the Architect
				certifies to the Owner that to the best of the Architect's knowledge, information and belief the Work has progressed as indicated, the
				quality of the Work is in accordance with the Contract Documents, and the Contractor is entitled to payment of the AMOUNT CERTIFIED.</p>
				<table class="certifiedAmountTable" cellpadding="5">
					<tr>
						<td></td>
						<td class="textAlignRight fontSize11"><span class="textBold fontSize11">AMOUNT CERTIFIED:</span></td>
						<td class="tdBottomBorder1 textAlignRight fontSize11 width100px"><span class="textBold fontSize11">$currentPaymentDueFormatted</span></td>
					</tr>
				</table>
				<table class="appArchitectTable" cellpadding="5">
					<tr>
						<td class="textBold fontSize11" colspan="3">ARCHITECT : $architectName</td>
					</tr>
					<tr>
						<td class="fontSize12" colspan="3">
							<div class="floatLeft">Sign:</div>
							<div class="floatLeft width175px tdBottomBorder1 marginRight5 marginLeft5">&nbsp;</div>
							<div class="floatLeft" >Print:</div>
							<div class="floatLeft width175px tdBottomBorder1 marginRight5 marginLeft5">&nbsp;</div>
							<div class="floatRight tdBottomBorder1 width75px">&nbsp;</div>
							<div class="floatRight" >Date:</div>
						</td>
					</tr>
				</table>
				<p class="paragraphTemp marBottom0 lineHeight15">This Certificate is not negotiable. The AMOUNT CERTIFIED is payable only to the Contractor named herein. Issuance, payment
				and acceptance of payment are without prejudice to any rights of the Owner or Contractor under this Contract. </p>
ARCHITECTBLOCK;

}
$narrativeHtml = '';
$changeorder_colspan = 13;
$ownerChnageOrderHtml = '';

if(!empty($narrative_flag) && $narrative_flag =='true'){
	$narrativeHtml = '<td rowspan="2" style="width:80px;">NARRATIVE</td>';
	$changeorder_colspan = 14;
}
if ($corDisplay == 2) {
	$ownerChnageOrderHtml = '<td rowspan="2" style="width:80px;">OWNER CHANGE ORDER</td>';
	$changeorder_colspan = 15;
}
$ocoTitleHtml = '';
if ($corDisplay == 1) {
	$ocoTitleHtml = '<tr>
		<td class="textBold textAlignLeft" colspan="'.$changeorder_colspan.'">
			<span class="textColorBlue">CHANGE ORDER SUMMARY</span>
		</td>
	</tr>';
}

$htmlContentFirstPage = <<<END_HTML_CONTENT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link href="{$uri->http}css/draw-print-pdf.css" rel="stylesheet" type="text/css">
	</head>
	<body id="templateBody">
		$headerLogo
		<div style="float:right;display:none;"><img src='$fulcrum'></div>
		<div class="print_draw">
		<h6 class="textAlignCenter headerBackground">APPLICATION AND CERTIFICATE FOR PAYMENT</h6>
		<hr />
		<div class="headerSection">
			<table class="headerSectionTable">
				<tr class="headerSectionTableTh">
					$ownerHtml
					$clHeaderHtml
					<td class="fontSize11">PROJECT:</td>
					<td class="fontSize11">FROM (CONTRACTOR):</td>
					<td class="textAlignRight fontSize11 width10per">INVOICE DATE:</td>
					<td class="textNormal textAlignCenter fontSize11">$drawInvoiceDate</td>
				</tr>
				<tr>
					$ownerNameHtml
					$clNameHtml
					<td rowspan="3" class="fontSize11">$projectName <br/> $projectAddressHtml</td>
					<td rowspan="3" class="fontSize11">$contractorName <br/> $officeAddressHtml</td>
					<td class="textBold textAlignRight fontSize11">PERIOD TO:</td>
					<td class="textAlignCenter fontSize11">$periodTo</td>
				</tr>
				<tr>
					<td class="textBold textAlignRight fontSize11">CONTRACT DATE:</td>
					<td class="textAlignCenter fontSize11">$projectContractDate</td>
				</tr>
				<tr>
					<td class="textBold textAlignRight fontSize11">APPLICATION NO:</td>
					<td class="textAlignCenter fontSize11">$application_number</td>
				</tr>
			</table>
			<hr class="marBottom0"/>
		</div>
		<div class="mainContractTable width100per">
			<div class="width40per floatLeft paddingRight10">
				<h6 class="textAlignLeft bottom0 textColorBlue">CONTRACTOR'S APPLICATION FOR PAYMENT </h6>
				<table class="appContractPayment" border="0" cellpadding="5" cellspacing="5">
					<tr>
						<td class="fontSize10" colspan="3">
							Application is made for Payment, as shown below, in connection with the Contract.
						</td>
					</tr>
					<tr>
						<td>1. </td>
						<th class="textAlignLeft fontSize10 width80per">ORIGINAL CONTRACT VALUE</th>
						<td class="tdBottomBorder1 textAlignRight fontSize11 width10per appContractPayment">$originalContractValueFormatted</td>
					</tr>
					<tr>
						<td>2. </td>
						<th class="textAlignLeft fontSize10">NET CHANGE ORDERS</th>
						<td class="tdBottomBorder1 width10per appContractPayment textAlignRight fontSize11">$netChangeOrdersFormatted</td>
					</tr>
					<tr>
						<td>3. </td>
						<th class="textAlignLeft fontSize10">CONTRACT SUM TO DATE (Line 1 +/- Line 2)</th>
						<td class="tdBottomBorder1 width10per appContractPayment textAlignRight fontSize11">$contractSumToDateFormatted</td>
					</tr>
					<tr>
						<td>4. </td>
						<th class="textAlignLeft fontSize10">TOTAL COMPLETED & STORED TO DATE (Column G)</th>
						<td class="tdBottomBorder1 width10per appContractPayment textAlignRight">$totalCompAndStoredToDateColGFormatted</td>
					</tr>
					<tr>
						<td>5. </td>
						<th class="textAlignLeft fontSize10">LESS RETENTION:</th>
						<td class="tdBottomBorder1 width10per textAlignRight fontSize11">$lessRetentionFormatted</td>
					</tr>
					<tr>
						<td>6. </td>
						<th class="textAlignLeft fontSize10">TOTAL EARNED LESS RETENTION (Line 4 Less Line 5 Total)</th>
						<td class="tdBottomBorder1 width10per appContractPayment textAlignRight fontSize11">$totalEarnedLessRetentionFormatted</td>
					</tr>
					<tr>
						<td>7. </td>
						<th class="textAlignLeft fontSize10">LESS PREVIOUS CERTIFICATES FOR PAYMENT <br>
						(Line 6 From Prior Application)
						</th>
						<td class="tdBottomBorder1 width10per appContractPayment textAlignRight fontSize11">$lessPrevCertForPaymentFormatted</td>
					</tr>
					<tr>
						<td>8. </td>
						<th class="textAlignLeft fontSize10">CURRENT PAYMENT DUE (Line 6 Less Line 7)</th>
						<td class="textBold tdBottomBorder1 appContractPayment width10per textAlignRight fontSize11">$currentPaymentDueFormatted</td>
					</tr>
					<tr>
						<td>9. </td>
						<th class="textAlignLeft fontSize10">BALANCE TO FINISH, PLUS RETENTION (Line 3 Less Line 6)</th>
						<td class="tdBottomBorder1 width10per appContractPayment textAlignRight fontSize11">$balanceToFinishFomatted</td>
					</tr>
				</table>
				<br/>
				<table class="appChangeOrderTable" border="0" style="border: 1px solid #adadad;">
					<tr>
						<td class="textBold fontSize10">CHANGE ORDER SUMMARY</td>
						<td class="textBold fontSize10">ADDITIONS</td>
						<td class="textBold fontSize10">DEDUCTIONS</td>
					</tr>
					<tr>
						<td class="fontSize10" nowrap="true">Total Changes approved in previous months by Owner</td>
						<td class="textAlignRight fontSize10">$prevPositiveOCOFormatted</td>
						<td class="textAlignRight fontSize10">$prevNegativeOCOFormatted</td>
					</tr>
					<tr>
						<td class="fontSize10">Total approved this Month</td>
						<td class="textAlignRight fontSize10">$currentPositiveOCOFormatted</td>
						<td class="textAlignRight fontSize10">$currentNegativeOCOFormatted</td>
					</tr>
					<tr>
						<td class="textAlignRight textBold">TOTAL</td>
						<td class="textAlignRight textBold">$totalPositiveOCOFormatted</td>
						<td class="textAlignRight textBold">$totalNegativeOCOFormatted</td>
					</tr>
					<tr>
						<td class="fontSize10">NET CHANGES by Change Orders</td>
						<td class="textAlignRight  fontSize11" colspan="2">$netChangeOrdersFormatted</td>
					</tr>
				</table>

			</div>
			<div class="width60per floatLeft">
				<p class="paragraphTemp lineHeight15">The undersigned Contractor certifies that to the best of the Contractor's knowledge, information and belief the Work covered by this
				Application for Payment has been completed in accordance with the Contract Documents, that all amounts have been paid by the
				Contractor for Work for which previous Applications for Payment were issued and payment received from the Owner, and that
				current payment shown herein is now due.</p>
				<table class="appContractorTable" cellpadding="5">
					<tr>
						<td class="textBold fontSize11" colspan="3">CONTRACTOR: $contractorName</td>
					</tr>
					<tr>
						<td class="fontSize12" colspan="3">
							<div class="floatLeft">Sign:</div>
							<div class="floatLeft width175px tdBottomBorder1 marginRight5 marginLeft5">&nbsp;</div>
							<div class="floatLeft" >Print:</div>
							<div class="floatLeft width175px tdBottomBorder1 marginRight5 marginLeft5">&nbsp;</div>
							<div class="floatRight tdBottomBorder1 width75px">&nbsp;</div>
							<div class="floatRight" >Date:</div>
						</td>
					</tr>
				</table>
				$architectureBlockHtml
				<hr />
				<table class="appArchitectTable" cellpadding="5">
					<tr>
						<td class="textBold fontSize11" colspan="3">OWNER : $ownerName</td>
					</tr>
					<tr>
						<td class="fontSize12" colspan="3">
							<div class="floatLeft">Sign:</div>
							<div class="floatLeft width175px tdBottomBorder1 marginRight5 marginLeft5">&nbsp;</div>
							<div class="floatLeft" >Print:</div>
							<div class="floatLeft width175px tdBottomBorder1 marginRight5 marginLeft5">&nbsp;</div>
							<div class="floatRight tdBottomBorder1 width75px">&nbsp;</div>
							<div class="floatRight" >Date:</div>
						</td>
					</tr>
					
				</table>
			</div>
		</div>			
		</div>
		$notaryBlockHtml
	</body>
</html>
END_HTML_CONTENT;


$htmlContentSecondPage = <<<END_HTML_CONTENT
<html>
	<head>
		<meta charset="UTF-8">
		<link href="{$uri->http}css/draw-print-pdf.css" rel="stylesheet" type="text/css">
	</head>
	<body id="templateBody">
		<div style="float:right;display:none;"><img src='$fulcrum'></div>
		<table id="drawTemp1" border="0" style="border: 1px solid #adadad;" cellpadding="5" cellspacing="0" width="100%">
			<thead style="font-weight: bold;text-align: center;color: #fff;background: #3b90ce;">
				<tr>
					<td rowspan="2" style="width:80px;">COST CODE</td>
					<td rowspan="2" style="width:200px;">DESCRIPTION OF WORK</td>
					<td rowspan="2" style="width:80px;">SCHEDULED VALUE</td>
					<td rowspan="2" style="width:80px;">PRIOR REALLOCATION</td>
					$ownerChnageOrderHtml
					<td rowspan="2" style="width:80px;">REVISED SCHEDULED VALUE</td>
					<td colspan="2" style="width:80px;">WORK COMPLETED</td>
					<td rowspan="2" style="width:80px;">MATERIALS PRESENTLY STORED<br>(NOT IN D OR E)</td>
					<td rowspan="2" style="width:80px;">TOTAL COMPLETED AND STORED TO DATE<br>(D + E + F)</td>
					<td rowspan="2" style="width:80px;">%<br>(G / C)</td>
					<td rowspan="2" style="width:80px;">BALANCE TO FINISH<br>(C - G)</td>
					<td rowspan="2" style="width:80px;">RETENTION</td>
					<td rowspan="2" style="width:80px;">RETENTION BILLING</td>
					$narrativeHtml
				</tr>
				<tr>
					<td style="width:80px;">FROM PREVIOUS APPLICATION<br>(D+E)</td>
					<td style="width:80px;">THIS PERIOD</td>
				</tr>
			</thead>
			<tbody>
				$drawContentTableData
				$ocoTitleHtml
				$drawCOContentTableData
				$OverAllTotalTr
			</tbody>
		</table>
	</body>
</html>
END_HTML_CONTENT;
 // echo $htmlContent;
 // exit;
$config = Zend_Registry::get('config');
$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
$baseDirectory = $config->system->base_directory;
$fileManagerBasePath = $config->system->file_manager_base_path;
$tempFileName = File::getTempFileName();
$tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
$removetempDir = $fileManagerBasePath.'temp/'.$tempFileName;
$fileObject = new File();
$fileObject->mkdir($tempDir, 0777);
$tempPdfFile = File::getTempFileName().'.pdf';

$bid_spreadsheet_data_sha1 = sha1($htmlContentFirstPage);
$bid_spreadsheet_data_sha2 = sha1($htmlContentSecondPage);

$usePhantomJS = true;
if ($usePhantomJS) {
    $pdfPhantomJS = new PdfPhantomJS();
    $pdfPhantomJS->setPdfPaperSize('11in', '8.5in');
  	$pdfPhantomJS->setMargin('50px', '50px', '50px', '10px');
  	$pdfPhantomJS->setPdffooter('', $fulcrum);
    $pdfPhantomJS->writeTempFileContentsToDisk($htmlContentFirstPage, $bid_spreadsheet_data_sha1);
    $pdfTempFileUrl1 = $pdfPhantomJS->getTempFileUrl();
    $pdfPhantomJS->setTempFileUrl($pdfTempFileUrl1);
	$htmlTempFileBasePath1 = $pdfPhantomJS->getTempFileBasePath();
	$htmlTempFileSha1 = $pdfPhantomJS->getTempFileSha1();
	$pdfTempFileFullPath1 = $tempDir . $htmlTempFileSha1 . '.pdf';
	$pdfPhantomJS->setCompletePdfFilePath($pdfTempFileFullPath1);
	$result1 = $pdfPhantomJS->execute();
    $pdfPhantomJS->deleteTempFile();

    $pdfPhantomJS = new PdfPhantomJS();
    $pdfPhantomJS->setPdfPaperSize('17in', '11in');
  	$pdfPhantomJS->setMargin('50px', '50px', '50px', '10px');
  	$pdfPhantomJS->setPdffooter('', $fulcrum);
    $pdfPhantomJS->writeTempFileContentsToDisk($htmlContentSecondPage, $bid_spreadsheet_data_sha2);
    $pdfTempFileUrl2 = $pdfPhantomJS->getTempFileUrl();
    $pdfPhantomJS->setTempFileUrl($pdfTempFileUrl2);
	$htmlTempFileBasePath2 = $pdfPhantomJS->getTempFileBasePath();
	$htmlTempFileSha2 = $pdfPhantomJS->getTempFileSha1();
	$pdfTempFileFullPath2 = $tempDir . $htmlTempFileSha2 . '.pdf';
	$pdfPhantomJS->setCompletePdfFilePath($pdfTempFileFullPath2);
	$result2 = $pdfPhantomJS->execute();
    $pdfPhantomJS->deleteTempFile();
}

$pdf1 = $htmlTempFileSha1 . '.pdf';
$pdf2 = $htmlTempFileSha2 . '.pdf';
$pdfarray = array($pdf1,$pdf2);

$finalRfiTempFileName = $tempFileName . '.pdf';
$tempFilePath = $tempDir.$finalRfiTempFileName;

// Merge the pdf
Pdf::merge($pdfarray, $tempDir, $finalRfiTempFileName);

/* Get Action type */
$loadActionTypeOptions = new Input();
$loadActionTypeOptions->forceLoadFlag = true;
$arrActionType = DrawActionTypes::findById($database, $draw_action_type_id);

$actionTypeName = '';
if(isset($arrActionType->action_name) && !empty($arrActionType->action_name) && $arrActionType->action_name != 'Print Draw') {
	$actionTypeName = $arrActionType->action_name;
}
if(isset($arrActionType->action_name) && !empty($arrActionType->action_name) && $arrActionType->action_name == 'Print Draw') {
	$drawThroughDateFormat = date('m-d-Y');
}
/* Get Action type options */
$actionTypeOptionName = '';
if($draw_action_type_option_id != '') {
	$loadActionTypeOptions = new Input();
	$loadActionTypeOptions->forceLoadFlag = true;
	$arrActionTypeOption = DrawActionTypeOptions::findById($database, $draw_action_type_option_id);
	$actionTypeOptionName = '';
	if(isset($arrActionType) && !empty($arrActionType)) {
		$actionTypeOptionName = $arrActionTypeOption->option_name;
	}
}
$fileNameAdd = array();
if($actionTypeName != ''){
	$fileNameAdd[] = $actionTypeName;
}
if($actionTypeOptionName != ''){
	// $fileNameAdd[] = $actionTypeOptionName;
}
$fileNameAddString = '';
if(isset($fileNameAdd) && !empty($fileNameAdd)){
	$fileNameAddString = implode(' - ', $fileNameAdd);
	$fileNameAddString = $fileNameAddString.' - ';
}

$typeName = DrawActionTypes::getTypeName($database,$draw_action_type_id);
$typeOptionName = DrawActionTypeOptions::getDrawActionOptionName($database,$draw_action_type_option_id);

// To open the created File path
$timezone = date_default_timezone_get();
$dates = date('d-m-Y h', time());
$date = date('d-m-Y', time());
$i=date('i', time());
$s=date('s a', time());
$a=date('a', time());
$downloadFilename = 'Retention #'.$application_number.' - '.$typeName.' - '.$typeOptionName." - ".$drawThroughDateFormat.".pdf";

$filename = 'Retention #'.$application_number.' - '.$typeName.' - '.$typeOptionName." - ".$drawThroughDateFormat.".pdf";
// Overrite the virtual file name when through date change
$drawFileMangerFileOptions = new Input();
$drawFileMangerFileOptions->forceLoadFlag = true;
$drawFileMangerFile = RetentionDrawFileManagerFiles::findByIdsRetentionFileManagerFile($database, $ret_id, $draw_action_type_id, $draw_action_type_option_id, $drawFileMangerFileOptions);
if(isset($drawFileMangerFile) && !empty($drawFileMangerFile)){
	$file_manager_file_id = $drawFileMangerFile->file_manager_file_id;
	$drawFileMangerFile->convertPropertiesToData();
	// $data = $drawFileMangerFile->getData();
	// update filemanager file name
	$getFileManagerFileUpdate = FileManagerFile::findById($database, $file_manager_file_id);
	if(isset($getFileManagerFileUpdate) && !empty($getFileManagerFileUpdate)) {
		$virtual_file_name_update = $getFileManagerFileUpdate->virtual_file_name;
		$getFileManagerFileUpdate->convertPropertiesToData();
		$updateData = $getFileManagerFileUpdate->getData();
		FileManagerFile::restoreFromTrash($database,$file_manager_file_id);
		if ($virtual_file_name_update != $filename) {
			$updateData['virtual_file_name'] = $filename;
			$getFileManagerFileUpdate->setData($updateData);
			$getFileManagerFileUpdate->save();
		}
	}
}

$draw_virtual_file_path = "/Retention/";
$drawUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currently_active_contact_id, $project_id, $draw_virtual_file_path);

$arrVirtualPath = array(1 => "In Draft", 2 => "Post Draw");
$curVirtualPath = $arrVirtualPath[$drawStatus];
// $virtual_file_path = '/Retention/'.$curVirtualPath.'/Draw #'. $application_number.'/';
$virtual_file_path = '/Retention/Retention #'. $application_number.'/';

// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
$currentVirtualFilePath = '/';
foreach ($arrFolders as $folder) {
	$tmpVirtualFilePath = array_shift($arrFolders);
	$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
	// Save the file_manager_folders record (virtual_file_path) to the db and get the id
	$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currently_active_contact_id, $project_id, $currentVirtualFilePath);
}
$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

$sha1 = sha1_file($tempFilePath);
$size = filesize($tempFilePath);
$fileExtension = 'pdf';
$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

// Final pdf document
$virtual_file_name_tmp = $filename;
$tmpFileManagerFile = new FileManagerFile($database);
$tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
$virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

// Convert file content to File object
$error = null;

$file = new File();
$file->sha1 = $sha1;
//$file->form_input_name = $formFileInputName;
//$file->error = $error;
$file->name = $virtual_file_name;
$file->size = $size;
//$file->tmp_name = $tmp_name;
$file->type = $virtual_file_mime_type;
$file->tempFilePath = $tempFilePath;
$file->fileExtension = $fileExtension;

//$arrFiles = File::parseUploadedFiles();
$file_location_id = FileManager::saveUploadedFileToCloud($database, $file, false);

// save the file information to the file_manager_files db table
$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $currently_active_contact_id, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
/* @var $fileManagerFile FileManagerFile */

$file_manager_file_id = $fileManagerFile->file_manager_file_id;
$fileDownloadPath = $fileManagerFile->generateUrlBasePath(true);
// Potentially update file_location_id
if ($file_location_id <> $fileManagerFile->file_location_id) {
	$fileManagerFile->file_location_id = $file_location_id;
	$data = array('file_location_id' => $file_location_id);
	$fileManagerFile->setData($data);
	$fileManagerFile->save();
}

// Set Permissions of the file to match the parent folder.
$parent_file_manager_folder_id = $fileManagerFolder->getParentFolderId();
FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);

// Update $punchItem->su_file_manager_file_id
$data = array(
	'file_manager_file_id' => $file_manager_file_id
);
// echo $file_manager_file_id;
/* draw file manage file save */
if($draw_action_type_option_id == ''){
	$draw_action_type_option_id = NULL;
}
$data = array();
$data['ret_id'] = $ret_id;
$data['ret_action_type_id'] = $draw_action_type_id;
$data['ret_action_type_option_id'] = $draw_action_type_option_id;
$data['file_manager_file_id'] = $file_manager_file_id;
$data['file_manager_folder_id'] = $file_manager_folder_id;
$data['created_contact_id'] = $currently_active_contact_id;
$data['updated_contact_id'] = $currently_active_contact_id;

/* find by ids */
$drawFileMangerFileOptions = new Input();
$drawFileMangerFileOptions->forceLoadFlag = true;
$drawFileMangerFile = RetentionDrawFileManagerFiles::findByIdsRetentionFileManagerFile($database, $ret_id, $draw_action_type_id, $draw_action_type_option_id, $drawFileMangerFileOptions);
if(isset($drawFileMangerFile) && !empty($drawFileMangerFile)){
	$drawFileMangerFile->convertPropertiesToData();
	$data = $drawFileMangerFile->getData();
	$data['updated_date'] = date('Y-m-d h:i:s');
	$data['file_manager_file_id'] = $file_manager_file_id;
	$data['file_manager_folder_id'] = $file_manager_folder_id;
	$drawFileMangerFile->setData($data);
	$drawFileMangerFile->convertDataToProperties();
} else {
	$drawFileMangerFile = new RetentionDrawFileManagerFiles($database);
	$drawFileMangerFile->setData($data);
	$drawFileMangerFile->convertDataToProperties();
}
$drawFileMangerFile->save();
// Delete temp files
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header("Content-Disposition: attachment; filename=\"" . $downloadFilename . "\";");
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($fileDownloadPath));
ob_clean();
flush();
readfile($fileDownloadPath); //showing the path to the server where the file is to be download

rmdir($removetempDir); //To remove temp folder
$fileObject->rrmdir($tempDir);

exit;
} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}

<?php

$cssDebugMode = false;
$javaScriptDebugMode = false;

// Display html as usual.
$bidSpreadHtml = '';


$htmlHead = <<<END_HTML_HEAD
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Bid Spread">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="imagetoolbar" content="false">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
END_HTML_HEAD;


if ($cssDebugMode) {

	$htmlHead .= <<<END_HTML_HEAD

	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/library-user_messages.css">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/jquery-ui-1.10.0.custom.css">
	<link rel="stylesheet" href="/css/modules-purchasing-bid-spread.css">
	<link rel="stylesheet" href="/css/modules-permissions.css">
	<link rel="stylesheet" href="/css/fileuploader.css">
	<link rel="stylesheet" href="/css/bootstrap-popover.css">
	<link rel="stylesheet" href="/css/bootstrap-dropdown.css">
	<link rel="stylesheet" href="/css/entypo.css">
	<link rel="stylesheet" href="../../css/fSelect.css">
END_HTML_HEAD;

} else {
	$styleUrl= 'css/styles.css.php';
	$purchasingBidUrl= 'css/modules-purchasing-bid-spread.css';
	$fselectUrl= 'css/fSelect.css';
	
	$htmlHead .= <<<END_HTML_HEAD

	<link rel="stylesheet" href="$uri->https$styleUrl">
	<link rel="stylesheet" href="$uri->https$purchasingBidUrl">
	<link rel="stylesheet" href="$uri->https$fselectUrl">
END_HTML_HEAD;

}

if ($excel == true) {
	$htmlHead .= <<<END_HTML_HEAD
	<style>
		body {
			border:0.5px solid #ccc !important;
		}
		.excelHeader td {
			background: #3b90ce;
			color: #ffffff !important;
		}
		.budgetName{
			background: #c5c5c5 !important;
		} 
		.linkedHeader {
			font-weight: bold !important;
		}
		#spreadTable{
			border:0.5px solid #000000 !important;
		}
		#spreadTable th, #spreadTable td {
			border:0.5px solid #000000 !important;
		}
		#blueHeader{
			background: #3b90ce !important;
    		color: #ffffff !important;
    		font-weight: bold !important;
		}	
		#boldTitle{
			font-weight: bold !important;
		}
		#tblBudgetAmounts{
			border-bottom: 0.5px solid #000000 !important;
		}
		#borderRightLeft{
			border-bottom: 0.5px solid #000000 !important;
		}
		#boldLinked{
			font-weight: bold !important;
		}
		.alignCenterName{
			text-align: center !important;
		}
	</style>	
END_HTML_HEAD;
}

$htmlHead .= <<<END_HTML_HEAD

	<style>
		body {
			/**display: none;**/
		}
	</style>
	<script>
		var arrBidSpreadStatuses = $jsonBidSpreadStatuses;
	</script>
</head>
<body>
<div id="modalDialogContainer" class="hidden"></div>
END_HTML_HEAD;

//echo $htmlHead;
$bidSpreadHtml .= $htmlHead;

// Debug.
$subcontractor_view = $get->sub;
if ($subcontractor_view == '1') {
	$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

	$contact = Contact::findContactByIdExtended($database, $currentlyActiveContactId);
	/* @var $contact Contact */

	$contactCompany = $contact->getContactCompany();
	/* @var $contactCompany ContactCompany */

	$contact_company_name = $contactCompany->contact_company_name;
	foreach ($arrSubcontractorBidsByGcBudgetLineItemId as $subcontractor_bid_id => $subcontractorBid) {
		$subcontractor_contact_id = $subcontractorBid->subcontractor_contact_id;
		if ($subcontractor_contact_id == $currentlyActiveContactId) {
			$arrBidItemsBySubcontractorBid = $arrBidItemsToSubcontractorBidsByGcBudgetLineItemId[$subcontractor_bid_id];
			require_once('/modules-purchasing-bid-spread-subcontractor-form.php');
			break;
		}
	}

	// @todo Refactor this whole section to use views/templates/ajax calls, etc.
	$htmlContent = ob_get_clean();
	echo $htmlHead;
	echo $htmlContent;
	exit;
}
require_once('lib/common/SubcontractorBidDocument.php');
require_once('lib/common/SubcontractorBidDocumentType.php');
require_once('lib/common/SubcontractorBidNote.php');
require_once('lib/common/SubcontractorBidStatus.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
// pdf or html
	if(isset($get->pdf) && $get->pdf == 1) {
		$pdfGet = true;
	} else {
		$pdfGet = false;
	}
	/*GC logo*/
	$main_company = Project::ProjectsMainCompany($database,$currentlySelectedProjectId);
	require_once('lib/common/Logo.php');
	$database = DBI::getInstance($database);
	// $gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id, true);
	$gcLogo= Logo::logoByUserCompanyIDforExcel($database,$main_company,true);
	$fulcrum = Logo::fulcrumlogoforfooterByBasePath(true);
	if($gcLogo !="")
	{
	$headerLogo=<<<headerLogo
	<div>
	<table width="100%" class="table-header">
 	<tr>
 	<td align='left' colspan="5" style="height:60px;"><div><img src='$gcLogo' ></div></td>
 	</tr>
 	</table>
 	</div>
 	<br>
headerLogo;
}else
{
	$headerLogo=<<<headerLogo
	<table width="100%" class="table-header">
 	<tr>
 	<td style="font-size:25px;padding:18px;" colspan="5">$project_name : $division_number - $cost_code $cost_code_description </td>
 	</tr>
 	</table>
headerLogo;
}

if($pdfGet){
	$bidSpreadHtml .= <<<BID_SPREAD_HTML
	$headerLogo
BID_SPREAD_HTML;
	}

// @todo Figure Out Subtotals
$bidSpreadHtml .= <<<BID_SPREAD_HTML

<div id="purchasingBidSpreadContainer--$gc_budget_line_item_id" style="margin:20px;">
BID_SPREAD_HTML;

if(!$pdfGet){
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

	<div id="divSpreadButtons">
		<input type="button" onclick="Subcontractor_Bid_Spreadsheet__displayHelpModal();" value="Bid Spread Help">
		<input id="activeGcBudgetLineItem" type="hidden" value="">
		<input type="button" value="Save and Exit" onclick="printPdf($gc_budget_line_item_id, $cost_code_division_id, $cost_code_id,1,$project_id);">
		<input id="btnImportBidItems" type="hidden" value="Import Bid Items" onclick="importBidItems('$gc_budget_line_item_id');">
		<input id="btnSortBiddersByPrice" type="button" value="Sort Bidders By Price" onclick="Subcontractor_Bid_Spreadsheet__sortBiddersByPrice('$gc_budget_line_item_id');">
		<input type="button" value="Bid Spread Approval Process" onclick="loadBidSpreadApprovalProcessDialog();">
		<input type="button" value="Print PDF" onclick="printPdf($gc_budget_line_item_id, $cost_code_division_id, $cost_code_id,0,$project_id);">
		<input type="button" value="Export Bid Spread" onclick="exportbidspread($gc_budget_line_item_id, $cost_code_division_id, $cost_code_id);">
	</div>
BID_SPREAD_HTML;
}
$bidSpreadHtml .= <<<BID_SPREAD_HTML


	<table id="spreadTable" class="border-2" border="1" cellspacing="0">
		<tbody class="tbodyBidItemRows">
			<tr class="notSortable" id="boldTitle">
				<td colspan="3" class="rightBorder" style="text-align: left;">$project_name</td>
BID_SPREAD_HTML;

$arrTotalsBySubcontractorBidId = array();
$sort_order = 0;
$cur_order=0;
$arrPreferredSubcontractorBidIds = array();
$countTotalrow = count($arrSubcontractorBidsByGcBudgetLineItemId);
$bid_ids="";
foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
	/* @var $subcontractorBid SubcontractorBid */
	$bid_ids .= $subcontractor_bid_id."-";
	$subcontractorContact = $subcontractorBid->getSubcontractorContact();
	/* @var $subcontractorContact Contact */

	$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
	/* @var $subcontractorBidStatus SubcontractorBidStatus */

	$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
	/* @var $subcontractorContactCompany ContactCompany */

	$subcontractorContactCompany->htmlEntityEscapeProperties();
	$escaped_contact_company_name = $subcontractorContactCompany->escaped_contact_company_name;

	if ($subcontractorBidStatus->subcontractor_bid_status == 'Preferred Subcontractor Bid') {
		$arrPreferredSubcontractorBidIds[] = $subcontractor_bid_id;
	}

	$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'] = 0;
	$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['subtotal'] = 0;

	if (isset($subcontractorBid->sort_order) && !empty($subcontractorBid->sort_order) && ($subcontractorBid->sort_order > 0)) {
	$sort_order = $subcontractorBid->sort_order;
	} else {
		$sort_order = $subcontractorBid->sort_order;
	// $sort_order++;
	}
	/* left swap check not equal 0*/
	$leftMoveShift = '';
	$leftMoveShiftNxt = '';
	$styleLeft=<<<LEFTSTYLE
	style="color: #000;"
LEFTSTYLE;
	if($cur_order != 0) {
		$styleLeft="";
		$leftMoveShiftNxt = <<<LEFTSHIFT
		href="javascript:Subcontractor_Bid_Spreadsheet__moveBidderLeft('$gc_budget_line_item_id', '$sort_order');"
LEFTSHIFT;
		$leftMoveShift = <<<LEFTSHIFT
		href="javascript:Subcontractor_Bid_Spreadsheet__moveBidderFarLeft('$gc_budget_line_item_id', '$sort_order');"
LEFTSHIFT;
	}
	/* right swap check not equal */
	$styleRight=<<<RIGHTSTYLE
	style="color: #000;"
RIGHTSTYLE;
	$rightMoveShift = '';
	$rightMoveShiftNxt = '';
	if($cur_order != ($countTotalrow-1)) {
		$styleRight="";
		$rightMoveShiftNxt = <<<RIGHTSHIFT
		href="javascript:Subcontractor_Bid_Spreadsheet__moveBidderRight('$gc_budget_line_item_id', '$sort_order');"
RIGHTSHIFT;
		$rightMoveShift = <<<RIGHTSHIFT
		href="javascript:Subcontractor_Bid_Spreadsheet__moveBidderFarRight('$gc_budget_line_item_id', '$sort_order');"
RIGHTSHIFT;
	}
	// data-placement="bottom" rel="tooltip" title="Shift bidder to the far left column"
	// data-placement="top" rel="tooltip" title="Shift bidder to the right 1 column" 
	$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="rightBorder" colspan="5" align="center" nowrap>
					<a style="margin-right:15px;" $leftMoveShift><span  $styleLeft class="entypo entypo-click entypo-fast-backward"></span></a>
					<a style="margin-right:5px;" $leftMoveShiftNxt $styleLeft><span $styleLeft class="entypo entypo-click entypo-left-dir" ></span></a>
					<span id="manage-subcontractor_bid-record--subcontractor_bids--company--$subcontractor_bid_id">$escaped_contact_company_name</span>
					<a style="margin-left:5px;" $rightMoveShiftNxt><span class="entypo entypo-click entypo-right-dir" $styleRight></span></a>
					<a style="margin-left:15px;" $rightMoveShift><span class="entypo entypo-click entypo-fast-forward" $styleRight></span></a>
				</td>
BID_SPREAD_HTML;
$cur_order++;
}

$csvPreferredSubcontractorBidIds = join(',', $arrPreferredSubcontractorBidIds);

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;

/*
$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="notSortable">
				<td colspan="3" class="rightBorder">$division_number-$cost_code $cost_code_description</td>
BID_SPREAD_HTML;
*/

$formatted_prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
$formatted_forecasted_expenses = Format::formatCurrency($forecasted_expenses);
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="notSortable">
				<td class="rightBorder" colspan="3" style="vertical-align: top;">
					<table id="tblBudgetAmounts">
						<tr class="notSortable">
							<td class="budgetName" colspan="3"><span id="gc_budget_line_items--cost_code_divisions--division_number--$cost_code_division_id">$division_number</span>$costCodeDividerType<span id="gc_budget_line_items--cost_codes--cost_code--$cost_code_id">$cost_code</span> <span id="gc_budget_line_items--cost_codes--cost_code_description--$cost_code_id">$cost_code_description</span></td>
						</tr>
						<tr class="notSortable">
							<td colspan="2">Prime Contract Scheduled Value:</td>
							<td align="right"><span id="prime_contract_scheduled_value">$formatted_prime_contract_scheduled_value</span></td>
						</tr>
						<tr class="notSortable">
							<td colspan="2">Forecasted Expenses:</td>
							<td align="right"><span id="forecasted_expenses">$formatted_forecasted_expenses</span></td>
						</tr>
BID_SPREAD_HTML;


						if(!$pdfGet){
							$bidSpreadHtml .= <<<BID_SPREAD_HTML


						<tr class="notSortable">
							<td colspan="2" style="text-align: right;">
								<input id="btnLinkScheduledValues" rel="tooltip" title="Click to manage linked scheduled values" type="button" value="Link Multiple Cost Codes" onclick="loadLinkedGcBudgetLineItems('$gc_budget_line_item_id');">
							</td>
						</tr>
BID_SPREAD_HTML;
}

$linkedPrimeContractScheduledValuesTotal = $prime_contract_scheduled_value;
$linkedForecastedExpensesTotal = $forecasted_expenses;

$loadLinkedGcBudgetLineItemsOptions = new Input();
$loadLinkedGcBudgetLineItemsOptions->forceLoadFlag = true;
$arrLinkedGcBudgetLineItems = GcBudgetLineItemRelationship::loadLinkedGcBudgetLineItems($database, $gc_budget_line_item_id, $loadLinkedGcBudgetLineItemsOptions);
//$arrLinkedBudgetItems = getLinkedScheduledValues($database, $gc_budget_line_item_id);
if (count($arrLinkedGcBudgetLineItems) > 0) {
	$showLinkedScheduledValuesStyle = '';
	if ($showLinkedScheduledValues == 0) {
		$showLinkedScheduledValuesStyle = ' style="display:none;"';
	}

	if(!$pdfGet)
	{
		$showhidelinkcost = "(show/hide)";
	}else{
		$showLinkedScheduledValuesStyle = '';
	}
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

						<tr class="notSortable">
							<td colspan="3" id="boldLinked" class="linkedHeader evenRow" onclick="toggleDisplayLinkedCostCodes('$bid_spread_id');">Linked Scheduled Values <a class="showHideLink" href="#">$showhidelinkcost</a></td>
						</tr>
BID_SPREAD_HTML;

	foreach ($arrLinkedGcBudgetLineItems AS $linked_gc_budget_line_item_id => $linkedGcBudgetLineItem) {
		/* @var $linkedGcBudgetLineItem GcBudgetLineItem */

		$linkedCostCode = $linkedGcBudgetLineItem->getCostCode();
		/* @var $linkedCostCode CostCode */

		//$linkedCostCodeDivision = $linkedGcBudgetLineItem->getCostCodeDivision();
		$linkedCostCodeDivision = $linkedCostCode->getCostCodeDivision();
		/* @var $linkedCostCodeDivision CostCodeDivision */

		$formattedLinkedCostCode = $linkedCostCode->getFormattedCostCode($database);

		$linked_prime_contract_scheduled_value = $linkedGcBudgetLineItem->prime_contract_scheduled_value;
		$linked_forecasted_expenses = $linkedGcBudgetLineItem->forecasted_expenses;
		$formatted_linked_prime_contract_scheduled_value = Format::formatCurrency($linked_prime_contract_scheduled_value);
		$formatted_linked_forecasted_expenses = Format::formatCurrency($linked_forecasted_expenses);

		$linkedPrimeContractScheduledValuesTotal = $linkedPrimeContractScheduledValuesTotal + $linked_prime_contract_scheduled_value;
		$linkedForecastedExpensesTotal = $linkedForecastedExpensesTotal + $linked_forecasted_expenses;

		$bidSpreadHtml .= <<<BID_SPREAD_HTML

						<tr class="notSortable linkedRow"$showLinkedScheduledValuesStyle>
							<td colspan="3" class="budgetName">$formattedLinkedCostCode</td>
						</tr>
						<tr class="notSortable linkedRow"$showLinkedScheduledValuesStyle>
							<td colspan="2">Prime Contract Scheduled Value:</td>
							<td align="right">$formatted_linked_prime_contract_scheduled_value</td>
						</tr>
						<tr class="notSortable linkedRow"$showLinkedScheduledValuesStyle>
							<td colspan="2">Forecasted Expenses:</td>
							<td align="right">$formatted_linked_forecasted_expenses</td>
						</tr>
BID_SPREAD_HTML;

	}

	$formattedLinkedPrimeContractScheduledValuesTotal = Format::formatCurrency($linkedPrimeContractScheduledValuesTotal);
	$formattedLinkedForecastedExpensesTotal = Format::formatCurrency($linkedForecastedExpensesTotal);

	$bidSpreadHtml .= <<<BID_SPREAD_HTML

								<tr class="notSortable linkedRow"$showLinkedScheduledValuesStyle>
									<td colspan="3" class="linkedHeader">Totals</td>
								</tr>
								<tr class="notSortable">
									<td colspan="2">Prime Contract Scheduled Value:</td>
									<td id="totalPrimeContractScheduledValue" align="right" style="font-weight: bold;">$formattedLinkedPrimeContractScheduledValuesTotal</td>
								</tr>
								<tr class="notSortable">
									<td colspan="2">Forecasted Expenses:</td>
									<td id="totalForecastedExpenses" align="right" style="font-weight: bold;">$formattedLinkedForecastedExpensesTotal</td>
								</tr>
BID_SPREAD_HTML;


}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

					</table>
					<input id="linkedScheduledTotal" type="hidden" value="$linkedPrimeContractScheduledValuesTotal">
				</td>
BID_SPREAD_HTML;


foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
	/* @var $subcontractorBid SubcontractorBid */

	$subcontractorContact = $subcontractorBid->getSubcontractorContact();
	/* @var $subcontractorContact Contact */

	$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
	/* @var $subcontractorBidStatus SubcontractorBidStatus */

	$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
	/* @var $subcontractorContactCompany ContactCompany */

	$contactFullName = $subcontractorContact->getContactFullName();
	$noteicon = "";
	if(!$pdfGet)
	{

	$subBidHtml = ListSubcontractorBidNotesData($database, $subcontractor_bid_id);
	if($subBidHtml != "")
	{
		$noteicon = "<span class='entypo-doc-text dropbtn".$subcontractor_bid_id." tooltip-user hyperdown' onclick='load_bids(".$subcontractor_bid_id.")'  ></span></div><div id='bidddernotes_".$subcontractor_bid_id."' class='dropdown-content'>".$subBidHtml."</div>";
	}else{
		$noteicon = "</div>";
	}
	}else{
		$noteicon = "</div>";
	}

	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td id="manage-subcontractor_bid-record--subcontractor_bids--contactfullName--$subcontractor_bid_id" colspan="5" class="rightBorder bidderHeaderDetails" style="position:relative;vertical-align:top;" align="center">
					<div style="border-bottom:1px solid black;height: 40px;padding-top:20px;">$contactFullName $noteicon
BID_SPREAD_HTML;

	if ($subcontractorContact) {
		$contact_email = $subcontractorContact->email;
	} else {
		$contact_email = '';
	}
	
	// Bid 
	$subcontractor_bid_document_type_id = 1;
			$arrReturn = renderSubcontractorBidDocumentFilesAsUrlList($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, true,'1', $pdfGet);
	$subcontractorBidsCount = $arrReturn['file_count'];
	$subcontractorBidsAsUrlList = $arrReturn['html'];
	if($subcontractorBidsAsUrlList=='')
	{
		$subcontractorBidsAsUrlList=' - ';
	}
	// Bid Invites - Bidder Specific		
	$subcontractor_bid_document_type_id = 4;
	$arrReturn = renderSubcontractorBidDocumentFilesAsUrlList($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, true,'1', $pdfGet);
	$bidderSpecificBidInvitationsCount = $arrReturn['file_count'];
	$bidderSpecificBidInvitationsAsUrlList = $arrReturn['html'];

	//$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
	/* @var $subcontractorBidStatus SubcontractorBidStatus */

	//$subcontractorContactCompany = $subcontractorBid->getSubcontractorContactCompany();
	/* @var $subcontractorContactCompany ContactCompany */

	$arrPhoneNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $subcontractorContact->contact_id);

	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				
					<table border="0" style="margin: 0 auto;" id="borderRightLeft">
BID_SPREAD_HTML;

	foreach ($arrPhoneNumbers AS $contactPhoneNumber) {
		if($contactPhoneNumber->phone_number_type =='Business')
		{
			$number=substr($contactPhoneNumber->number,0,4);
			$ext=substr($contactPhoneNumber->number,4,4);
			 $mobilenumber='('.$contactPhoneNumber->area_code.') '.$contactPhoneNumber->prefix.'-'.$number.' ext.'.$ext;

		}else{
		 $mobilenumber='('.$contactPhoneNumber->area_code.') '.$contactPhoneNumber->prefix.'-'.$contactPhoneNumber->number;
		}
		$bidSpreadHtml .= <<<BID_SPREAD_HTML

						<tr class="notSortable">
							<td id="manage-subcontractor_bid-record--subcontractor_bids--contactPhoneNumberType--$subcontractor_bid_id" align="right" colspan="2">$contactPhoneNumber->phone_number_type</td>
							<td id="manage-subcontractor_bid-record--subcontractor_bids--contactFormattedPhoneNumber--$subcontractor_bid_id" align="left" colspan="3">$mobilenumber</td>
						</tr>
BID_SPREAD_HTML;

	}
	if($pdfGet){
		$contactEmailPdfOrHtml = <<<CONTACT_EMAIL_PDF_OR_HTML
		$contact_email
CONTACT_EMAIL_PDF_OR_HTML;
	}else{
		$contactEmailPdfOrHtml = <<<CONTACT_EMAIL_PDF_OR_HTML
		<a id="manage-subcontractor_bid-record--subcontractor_bids--contact_email--$subcontractor_bid_id" href="mailto:$contact_email">$contact_email</a>
CONTACT_EMAIL_PDF_OR_HTML;
	}
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

						<tr class="notSortable">
							<td align="right" colspan="2">Email</td>
							<td align="left" colspan="3">$contactEmailPdfOrHtml</td>
						</tr>
						<tr class="notSortable"><td align="right" colspan="2">Latest Bid</td>
						<td align="left" colspan="3">$subcontractorBidsAsUrlList </td></tr>
					</table>
				</td>
BID_SPREAD_HTML;

}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;

/*
$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="notSortable">
				<td colspan="3" class="rightBorder" style="vertical-align: top;">
					<table id="tblBudgetAmounts">
						<tr class="notSortable">
							<td>Prime Contract Scheduled Value:</td>
							<td align="right">Format::formatCurrency($prime_contract_scheduled_value)</td>
						</tr>
						<tr class="notSortable">
							<td>Forecasted Expenses:</td>
							<td align="right">Format::formatCurrency($forecasted_expenses)</td>
						</tr>
BID_SPREAD_HTML;

$arrLinkedBudgetItems = getLinkedScheduledValues($database, $gc_budget_line_item_id);
if (count($arrLinkedBudgetItems) > 0) {
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

								<tr class="notSortable">
									<td colspan="2" style="text-align: left;">Linked Scheduled Values</td>
								</tr>
BID_SPREAD_HTML;

	foreach ($arrLinkedBudgetItems AS $linked_gc_budget_line_item_id => $null) {

		$bidSpreadHtml .= <<<BID_SPREAD_HTML

									<tr class="notSortable">
										<td>Prime Contract Scheduled Value:</td>
										<td align="right">Format::formatCurrency($prime_contract_scheduled_value)</td>
									</tr>
									<tr class="notSortable">
										<td>Forecasted Expenses:</td>
										<td align="right">Format::formatCurrency($forecasted_expenses)</td>
									</tr>
BID_SPREAD_HTML;

	}
}

$bidSpreadHtml .= <<<BID_SPREAD_HTML
					</table>
				</td>
BID_SPREAD_HTML;
*/



$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="notSortable border-top-dark excelHeader" id="blueHeader">
BID_SPREAD_HTML;
$colscount ='3';


			if(!$pdfGet){
				$colscount ='1';

			$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="permissionTableMainHeader">&nbsp;</td>
				<td colspan="$colscount" class="permissionTableMainHeader" style="text-align: left;">
					Bid Spread Items
					<span class="entypo entypo-click entypo-plus-circled" onclick="renderEmptyBidItemRowOnBidSpread();" title="Create Bid Item"></span>
				</td>
BID_SPREAD_HTML;
}else
{
	$bidSpreadHtml .= <<<BID_SPREAD_HTML
	<td colspan="$colscount" class="permissionTableMainHeader rightBorder" style="text-align: left;">
					Bid Spread Items</td>
BID_SPREAD_HTML;
}



				if(!$pdfGet){
			$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="rightBorder permissionTableMainHeader">&nbsp;</td>
BID_SPREAD_HTML;
}

foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td class="permissionTableMainHeader">Qty</td>
				<td class="permissionTableMainHeader">Unit</td>
				<td class="permissionTableMainHeader">Unit Price</td>
				
BID_SPREAD_HTML;

				if(!$pdfGet){
				$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td class="permissionTableMainHeader" >Total</td>
BID_SPREAD_HTML;
				}else
				{
					$bidSpreadHtml .= <<<BID_SPREAD_HTML
					<td class="permissionTableMainHeader rightBorder" colspan='2'>Total</td>
BID_SPREAD_HTML;

				}

				if(!$pdfGet){
				$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td class="rightBorder permissionTableMainHeader"><input type="checkbox" rel="tooltip" title="Toggle all" onclick="toggleAllExcludeCheckboxesInColumn(this, '$subcontractor_bid_id');"></td>
BID_SPREAD_HTML;
				}

}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;

$tabIndex = 0;
$subtotal = 0;
$total = 0;
// Important to iterate over bid_items as there may be no associations to subcontractor_bids via bid_items_to_subcontractor_bids
foreach ($arrBidItemsByGcBudgetLineItemId AS $bid_item_id => $bidItem) {
	/* @var $bidItem BidItem */

	$bid_item = $bidItem->bid_item;
	$sort_order = $bidItem->sort_order;
	$subtotalRow = '';
	$subtotalInput = '';
	$hidden = '';
	if (stristr($bid_item, 'subtotal') || stristr($bid_item, 'sub total')) {
		$subtotalRow = ' subtotal-row';
		$subtotalInput = 'subtotal-input';
		$hidden = 'hidden';
	}
	if($pdfGet)
	{
		$bid_item = str_replace('\'', '&apos;',$bid_item);
	}else {
		$bid_item = str_replace("<br />", "\r", $bid_item);
	}


	$bidItemElementId = "record_container--manage-bid_item-record--bid_items--sort_order--$bid_item_id";

	$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr id="$bidItemElementId" class="rowBidItems$subtotalRow">
BID_SPREAD_HTML;
// <input id="manage-bid_item-record--bid_items--bid_item--$bid_item_id" type="text" tabIndex="$tabIndex" class="bid_item" value='$bid_item' onchange="Subcontractor_Bid_Spreadsheet__updateBidItem(this, { bid_item_id : $bid_item_id});">

			if(!$pdfGet){
			$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="spread-td tdSortBars textAlignCenter">
					<img src="/images/sortbars.png" rel="tooltip" title="Drag bars to change sort order">
				</td>
				<td class="spread-td" colspan="$colscount">
				<textarea id="manage-bid_item-record--bid_items--bid_item--$bid_item_id" type="text" tabIndex="$tabIndex" class="bid_item bidarea" onchange="Subcontractor_Bid_Spreadsheet__updateBidItem(this, { bid_item_id : $bid_item_id});">$bid_item</textarea>
					<input id="manage-bid_item-record--bid_items--gc_budget_line_item_id--$bid_item_id" type="hidden" value="$gc_budget_line_item_id">
					<!--onkeydown="return keyCheck(event, 'itemArray', 'desc-$bid_item_id');"-->
				</td>
BID_SPREAD_HTML;

			}
			else
			{
				$bid_item= ($bid_item !='')?$bid_item :"";
				$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="spread-td rightBorder pdfwidth" colspan="$colscount">$bid_item</td>
BID_SPREAD_HTML;
			}

				if(!$pdfGet){
			$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="spread-td rightBorder textAlignCenter">
					<a href="javascript:Subcontractor_Bid_Spreadsheet__deleteBidItem('$bid_item_id');" rel="tooltip" title="Delete This Bid Item Row" tabIndex="-1">X</a>
				</td>
BID_SPREAD_HTML;
}

	if (isset($arrBidItemsToSubcontractorBidsByGcBudgetLineItemId[$bid_item_id])) {
		$arrBidItemsToSubcontractorBidsByBidItemId = $arrBidItemsToSubcontractorBidsByGcBudgetLineItemId[$bid_item_id];
	} else {
		$arrBidItemsToSubcontractorBidsByBidItemId = array();
	}
	foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
		$item_quantity = '';
		$unit = '';
		$unit_price = '';
		$unitTotal = '';
		$exclude_bid_item_flag = 'N';
		if (isset($arrBidItemsToSubcontractorBidsByBidItemId[$subcontractor_bid_id])) {
			$bidItemToSubcontractorBid = $arrBidItemsToSubcontractorBidsByBidItemId[$subcontractor_bid_id];
			/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */

			$item_quantity = $bidItemToSubcontractorBid->item_quantity;
			$unit = $bidItemToSubcontractorBid->unit;
			$unit = str_replace('\'', '&apos;',$unit);

			$unit_price = $bidItemToSubcontractorBid->unit_price;
			$unitTotal = $item_quantity * $unit_price;
			$exclude_bid_item_flag = $bidItemToSubcontractorBid->exclude_bid_item_flag;
		}

		if ($exclude_bid_item_flag == 'Y') {
			$excludeBidItemFlagChecked = 'checked';
			$exclude = 'exclude';
			$noedit ='readonly';
		} else {
			$excludeBidItemFlagChecked = '';
			$exclude = '';
			$noedit ='';

			$subtotal = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['subtotal'];
			$subtotal = $subtotal + $unitTotal;
			$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['subtotal'] = $subtotal;

			$total = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
			$total = $total + $unitTotal;
			$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'] = $total;
		}

		if ($subtotalRow != '') {
			$unitTotal = $subtotal;
			$arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['subtotal'] = 0;
		}

		if ($item_quantity < 0) {
			$itemQuantityColorClass = ' red';
		} else {
			$itemQuantityColorClass = '';
		}
		if ($item_quantity == 0) {
			$item_quantity = '';
		}

		if ($unit_price < 0) {
			$unitPriceColorClass = ' red';
		} else {
			$unitPriceColorClass = '';
		}
		if ($unit_price != '' && $unit_price != 0) {
			$unit_price = Format::formatCurrency($unit_price);
		} else {
			$unit_price = '';
		}

		if ($unitTotal < 0) {
			$unitTotalColorClass = ' red';
		} else {
			$unitTotalColorClass = '';
		}
		if ($unitTotal != '' && $unitTotal != 0) {
			$unitTotal = Format::formatCurrency($unitTotal);
		} else {
			$unitTotal = '';
		}

		$attributeGroupName = 'manage-bid_item_to_subcontractor_bid-record';
		$uniqueId = "{$bid_item_id}-{$subcontractor_bid_id}";

		//<input id="$attributeGroupName--bid_items_to_subcontractor_bids--item_quantity--$uniqueId" type="text" tabIndex="$tabIndex" class="item_quantity number-only $hidden{$itemQuantityColorClass}" value="$item_quantity" onchange="saveBidItemToSubcontractorBid('$attributeGroupName', '$uniqueId', { element: this });">
		//<input id="$attributeGroupName--bid_items_to_subcontractor_bids--unit--$uniqueId" type="text" tabIndex="$tabIndex" class="unit $hidden" value="$unit" onchange="saveBidItemToSubcontractorBid('$attributeGroupName', '$uniqueId', { domElement: this, jsEvent: event });">
		//<input id="$attributeGroupName--bid_items_to_subcontractor_bids--unit_price--$uniqueId" type="text" tabIndex="$tabIndex" class="unit_price number-only $hidden{$unitPriceColorClass}" value="$unit_price" onchange="saveBidItemToSubcontractorBid('$attributeGroupName', '$uniqueId', { element: this });">
		//<input id="$attributeGroupName--bid_items_to_subcontractor_bids--exclude_bid_item_flag--$uniqueId" type="checkbox" tabIndex="$tabIndex" class="exclude_bid_item_flag exclude_bid_item_flag--$subcontractor_bid_id $subtotalInput $hidden" $excludeBidItemFlagChecked onclick="saveBidItemToSubcontractorBid('$attributeGroupName', '$uniqueId', { element: this, jsEvent: event });" rel="tooltip" title="Exclude This Item From Totals">
		//Unit total should not be shown for exclude item
		if($noedit !="")
		{
			$unitTotal="";
		}
		if(!$pdfGet){
		$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td class="spread-td">
					<input id="$attributeGroupName--bid_items_to_subcontractor_bids--item_quantity--$uniqueId" type="text" tabIndex="$tabIndex" class="item_quantity number-only $hidden{$itemQuantityColorClass} keymove" value="$item_quantity" $noedit onchange="Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid(this, event, '$attributeGroupName', '$uniqueId');">
				</td>
				<td class="spread-td">
					<input id="$attributeGroupName--bid_items_to_subcontractor_bids--unit--$uniqueId" type="text" tabIndex="$tabIndex" class="unit $hidden keymove" $noedit value='$unit' onchange="Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid(this, event, '$attributeGroupName', '$uniqueId');">
				</td>
				<td class="spread-td">
					<input id="$attributeGroupName--bid_items_to_subcontractor_bids--unit_price--$uniqueId" type="text" tabIndex="$tabIndex" class="unit_price number-only $hidden{$unitPriceColorClass} keymove" value="$unit_price" $noedit onchange="Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid(this, event, '$attributeGroupName', '$uniqueId');">
				</td>
				<td class="spread-td">
					<input id="$attributeGroupName--bid_items_to_subcontractor_bids--unitTotal--$uniqueId" type="text" class="unitTotal unitTotal--$subcontractor_bid_id $exclude $subtotalInput{$unitTotalColorClass}" value="$unitTotal" $noedit onchange="Subcontractor_Bid_Spreadsheet__updateBidTotalSummarySection('$subcontractor_bid_id');"  tabIndex = '-1' readonly>
				</td>
BID_SPREAD_HTML;
				}else
				{
					$item_quantity = ($item_quantity != "")?$item_quantity:"&nbsp;";
					$unit = ($unit != "")?$unit:"&nbsp;";
					$unit_price = ($unit_price != "")?$unit_price : "&nbsp;";
					$unitTotal = ($unitTotal != "")?$unitTotal :"&nbsp;";
					$bidSpreadHtml .= <<<BID_SPREAD_HTML
					<td class="spread-td">$item_quantity</td>
					<td class="spread-td">$unit</td>
					<td class="spread-td">$unit_price</td>
					<td class="spread-td rightBorder" colspan='2'>$unitTotal</td>
BID_SPREAD_HTML;

				}

				if(!$pdfGet){
				$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="spread-td rightBorder">
					<input id="$attributeGroupName--bid_items_to_subcontractor_bids--exclude_bid_item_flag--$uniqueId" type="checkbox" tabIndex = '-1' class="exclude_bid_item_flag exclude_bid_item_flag--$subcontractor_bid_id $subtotalInput $hidden" $excludeBidItemFlagChecked onclick="Subcontractor_Bid_Spreadsheet__saveBidItemToSubcontractorBid(this, event, '$attributeGroupName', '$uniqueId');" rel="tooltip" title="Exclude This Item From Totals" >
				</td>
BID_SPREAD_HTML;
				}

	}

	$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;

}

/*
$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="rowBidItems">
				<td class="spread-td">
					<img src="/images/sortbars.png">
				</td>
				<td class="spread-td">
					<input id="newDesc" type="text" tabIndex="$tabIndex" class="input-item" onchange="newDescription('$bid_item_id');" onkeydown="return keyCheck(event,'itemArray','desc-$bid_item_id');">
				</td>
				<td>&nbsp;</td>
BID_SPREAD_HTML;

foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
	if (isset($arrBidItemsToSubcontractorBidsByGcBudgetLineItemId[$subcontractor_bid_id])) {
		$arrBidItemsBySubcontractorBid = $arrBidItemsToSubcontractorBidsByGcBudgetLineItemId[$subcontractor_bid_id];
	} else {
		$arrBidItemsBySubcontractorBid = array();
	}
	$item_quantity = '';
	$unit = '';
	$unit_price = '';
	$unitTotal = '';
	$exclude_bid_item_flag = 'N';
	if (isset($arrBidItemsBySubcontractorBid[$bid_item_id])) {
		$bidItemToSubcontractorBid = $arrBidItemsBySubcontractorBid[$bid_item_id];

		$item_quantity = $bidItemToSubcontractorBid->item_quantity;
		$unit = $bidItemToSubcontractorBid->unit;
		$unit_price = $bidItemToSubcontractorBid->unit_price;
		$unitTotal = $item_quantity * $unit_price;
		$exclude_bid_item_flag = $bidItemToSubcontractorBid->exclude_bid_item_flag;
	}

	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td class="spread-td">
					<input id="newQty-$subcontractor_bid_id" type="text" tabIndex="$tabIndex" style="width:35px; text-align: right;" onchange="newQty('$bid_item_id', '$subcontractor_bid_id');" onkeydown="return keyCheck(event,'qty$subcontractor_bid_id','newQty-{$bid_item_id}-{$subcontractor_bid_id}');">
				</td>
				<td class="spread-td">
					<input id="newUnt-$subcontractor_bid_id" type="text" tabIndex="$tabIndex" class="input-unit" onchange="changeUnt('$bid_item_id', '$subcontractor_bid_id');" onkeydown="return keyCheck(event,'unt$subcontractor_bid_id','unt-{$bid_item_id}-{$subcontractor_bid_id}');">
				</td>
				<td class="spread-td">
					<input id="newAmt-$subcontractor_bid_id" type="text" tabIndex="$tabIndex" class="input-unit-price" onchange="changeAmt('$bid_item_id', '$subcontractor_bid_id');" onkeydown="return keyCheck(event,'amt$subcontractor_bid_id','amt-{$bid_item_id}-{$subcontractor_bid_id}');">
				</td>
				<td class="spread-td">
					<input id="newTtl-$subcontractor_bid_id" type="text" class="input-unit-total" readonly>
				</td>
				<td class="spread-td">
					<input name="newExc-$subcontractor_bid_id" type="checkbox" tabIndex="$tabIndex" onclick="changeExc('$bid_item_id', '$subcontractor_bid_id','exc-{$bid_item_id}-{$subcontractor_bid_id}');" onkeydown="return keyCheck(event,'exc$subcontractor_bid_id','exc-{$bid_item_id}-{$subcontractor_bid_id}');">
				</td>
BID_SPREAD_HTML;

}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;
*/

$bidSpreadHtml .= <<<BID_SPREAD_HTML
			<tr class="notSortable addPrependRow border-top-dark">
				<td colspan="3" class="rightBorder" style="text-align: left;">Subcontractor Bid Total</td>
BID_SPREAD_HTML;

foreach ($arrSubcontractorBidsByGcBudgetLineItemId AS $subcontractor_bid_id => $subcontractorBid) {
	/* @var $subcontractorBid SubcontractorBid */

	$subcontractorBidStatus = $subcontractorBid->getSubcontractorBidStatus();
	/* @var $subcontractorBidStatus SubcontractorBidStatus */

	//$subcontractorBid = $arrSubcontractorBidsByGcBudgetLineItemId[$subcontractor_bid_id];
	$subcontractorBidTotal = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
	$formattedSubcontractorBidTotal = Format::formatCurrency($subcontractorBidTotal);
	$checkboxPreferredSubElementId = 'manage-subcontractor_bid-record--subcontractor_bids--subcontractor_bid_status_id--' . $subcontractor_bid_id;

	if ($subcontractorBidStatus->subcontractor_bid_status == 'Preferred Subcontractor Bid') {
		$checked = ' checked';
		$checkboxClass = '';
		$preferredSubCheckboxClass = ' preferredSub';
		$preferredSubTdClass = ' preferredSub';
		$openSubcontractsDialogLinkStyle = '';
		$hidden = '';
	} else {
		$checked = '';
		$checkboxClass = '';
		$preferredSubTdClass = '';
		$openSubcontractsDialogLinkStyle = ' style="display:none;"';
		$hidden = 'hidden';
	}

	if ($subcontractorBidTotal < 0) {
		$subcontractorBidTotalColorClass = ' red';
	} else {
		$subcontractorBidTotalColorClass = '';
	}

if(!$pdfGet){
				$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="thPreferredSubcontractor--$subcontractor_bid_id $preferredSubTdClass" colspan="3" style="text-align: right;">
					<label for="$checkboxPreferredSubElementId" class="labelPreferedSubcontractor">Preferred Subcontractor</label>
					<input id="$checkboxPreferredSubElementId" type="checkbox" name="preferredSubcontractor" class="input-preferred-sub$checkboxClass" onchange="Subcontractor_Bid_Spreadsheet__updateSubcontractorBid(this, event, { updateCase: 'togglePreferredSubcontractorBidStatus' });"$checked>
					<a id="preferredSubcontractorLink--subcontractor_bid_id--$subcontractor_bid_id" class="preferred-sub-link $hidden" href="javascript:openSubcontractsDialog('$gc_budget_line_item_id', '$cost_code_division_id', '$cost_code_id', '$subcontractor_bid_id');">Subcontract</a>
				</td>
				<td class="thPreferredSubcontractor--$subcontractor_bid_id{$preferredSubTdClass}">
					<input id="derived_values-subcontractor_bid-record--subcontractor_bids--derived_bid_total--$subcontractor_bid_id" class="input-unit-total bidder-total$subcontractorBidTotalColorClass" readonly type="text" value="$formattedSubcontractorBidTotal">
				</td>
BID_SPREAD_HTML;
}
else
{
		$formattedSubcontractorBidTotal = ($formattedSubcontractorBidTotal != "") ? $formattedSubcontractorBidTotal : "&nbsp;";
			$bidSpreadHtml .= <<<BID_SPREAD_HTML
			<td class="thPreferredSubcontractor--$subcontractor_bid_id $preferredSubTdClass" colspan="3" style="text-align: right;">
					<label for="$checkboxPreferredSubElementId" class="labelPreferedSubcontractor">Preferred Subcontractor</label>
			</td>
			<td class="thPreferredSubcontractor--$subcontractor_bid_id{$preferredSubTdClass} rightBorder" colspan='2'>$formattedSubcontractorBidTotal</td>
BID_SPREAD_HTML;
}

				if(!$pdfGet){
					$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="thPreferredSubcontractor--$subcontractor_bid_id rightBorder$preferredSubTdClass">&nbsp;</td>
BID_SPREAD_HTML;
				}

}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;
$incFe = GcBudgetLineItemRelationship::getbudgetvarianceRecord($database, $gc_budget_line_item_id,'include_expense');
$bid_ids =rtrim($bid_ids,'-');
if($incFe=='Y')
{
	$vartext="Variance [PCSV - (FE + Bid)]";
	$itemvariance ="checked=true";
}else
{
	$vartext="Variance [PCSV - Bid]";
	$itemvariance ="";
}
if(!$pdfGet){
	$varcheck .= <<<BID_SPREAD_HTML
	<input type="checkbox" id="manage-gc_budget_line_items-record--gc_budget_line_items--include_expense--$gc_budget_line_item_id" rel="tooltip" title="" data-original-title="Include FE" $itemvariance onclick='subcontract__updateViaPromiseChain(this,&apos;$bid_ids&apos;);'>
BID_SPREAD_HTML;

	}else
	{
		$varcheck="";
	}
$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="notSortable">
				<td colspan="3" class="rightBorder" style="text-align: left;"><span id="varspan">$vartext</span>
				<input type="hidden" id="invariance" value="$incFe">
				$varcheck
				
				</td>
BID_SPREAD_HTML;

foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
	$subcontractorBidTotal = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
	if($incFe =='Y'){
	$variance = $linkedPrimeContractScheduledValuesTotal - ($subcontractorBidTotal + $linkedForecastedExpensesTotal);
	}else
	{
		$variance = $linkedPrimeContractScheduledValuesTotal - $subcontractorBidTotal;
	}
	$formattedVariance = Format::formatCurrency($variance);
	$varianceStyle = '';
	if ($variance < 0) {
		$varianceStyle = ' red';
	}
	if(!$pdfGet){
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td colspan="3" style="text-align: right;">&nbsp;</td>
				<td>
					<input id="variance_ttl-$subcontractor_bid_id" type="text" class="input-unit-total bidder-total$varianceStyle" value="$formattedVariance" readonly>
				</td>
BID_SPREAD_HTML;
}else
{
	$formattedVariance =($formattedVariance != "") ?$formattedVariance :"&nbsp;";
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td colspan="3" style="text-align: right;">&nbsp;</td>
				<td colspan="2" class="rightBorder">$formattedVariance</td>
BID_SPREAD_HTML;
}

				if(!$pdfGet){
				$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="rightBorder">&nbsp;</td>
BID_SPREAD_HTML;
				}

}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;

//<img src="/images/icons/square_foot.gif" width="25" height="25">
$formatted_gross_square_footage = number_format($gross_square_footage, 0);

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="notSortable">
				<td colspan="3" class="rightBorder" style="text-align: left;" nowrap>Cost Per Gross Sq. Ft ($formatted_gross_square_footage sf)</td>
BID_SPREAD_HTML;

foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
	$total = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
	if (isset($gross_square_footage) && !empty($gross_square_footage)) {
		$totalPerGrossSquareFoot = $total / $gross_square_footage;
		$formattedTotalPerGrossSquareFoot = Format::formatCurrency($totalPerGrossSquareFoot);
	} else {
		$formattedTotalPerGrossSquareFoot = '';
	}
if(!$pdfGet){
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td colspan="4" align="right"><input id="subcontractorBidTotalCostPerGrossSquareFoot--$subcontractor_bid_id" type="text" class="input-unit-total bidder-total" value="$formattedTotalPerGrossSquareFoot" readonly></td>
BID_SPREAD_HTML;
}else
{
	$formattedTotalPerGrossSquareFoot = ($formattedTotalPerGrossSquareFoot !="")?$formattedTotalPerGrossSquareFoot:"&nbsp;";
	$bidSpreadHtml .= <<<BID_SPREAD_HTML
	<td colspan="5" class="rightBorder" align="right">$formattedTotalPerGrossSquareFoot</td>
BID_SPREAD_HTML;

}

				if(!$pdfGet){
				$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="rightBorder">&nbsp;</td>
BID_SPREAD_HTML;
				}

}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;


$formatted_net_rentable_square_footage = number_format($net_rentable_square_footage, 0);

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="notSortable">
				<td colspan="3" class="rightBorder" style="text-align: left;" nowrap>Cost Per Net Rentable Sq. Ft ($formatted_net_rentable_square_footage sf)</td>
BID_SPREAD_HTML;

foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
	$total = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
	if (isset($net_rentable_square_footage) && !empty($net_rentable_square_footage)) {
		$totalPerNetRentableSquareFoot = $total / $net_rentable_square_footage;
		$formattedTotalPerNetRentableSquareFoot = Format::formatCurrency($totalPerNetRentableSquareFoot);
	} else {
		$formattedTotalPerNetRentableSquareFoot = '';
	}
if(!$pdfGet){
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td colspan="4" align="right"><input id="subcontractorBidTotalCostPerNetRentableSquareFoot--$subcontractor_bid_id" type="text" class="input-unit-total bidder-total" value="$formattedTotalPerNetRentableSquareFoot" readonly></td>
BID_SPREAD_HTML;
}else
{
	$formattedTotalPerNetRentableSquareFoot =($formattedTotalPerNetRentableSquareFoot != "")?$formattedTotalPerNetRentableSquareFoot : "&nbsp;";
	$bidSpreadHtml .= <<<BID_SPREAD_HTML
	<td colspan="5" class="rightBorder" align="right">$formattedTotalPerNetRentableSquareFoot</td>
BID_SPREAD_HTML;

}

				if(!$pdfGet){
				$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="rightBorder">&nbsp;</td>
BID_SPREAD_HTML;
				}

}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
BID_SPREAD_HTML;


if (($project_unit_count == 0) || ($project_unit_count > 1)) {
	$unitsLabel = ' Units';
} elseif (($project_unit_count == 1)) {
	$unitsLabel = ' Unit';
} else {
	$unitsLabel = '';
}
$formatted_project_unit_count = number_format($project_unit_count, 0);

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			<tr class="notSortable">
				<td colspan="3" class="rightBorder" style="text-align: left;" nowrap>Cost Per Unit ($formatted_project_unit_count $unitsLabel)</td>
BID_SPREAD_HTML;

foreach ($arrSubcontractorBidIds AS $subcontractor_bid_id) {
	$total = $arrTotalsBySubcontractorBidId[$subcontractor_bid_id]['derivedSubcontractorBidTotal'];
	if (isset($project_unit_count) && !empty($project_unit_count)) {
		$totalPerUnit = $total / $project_unit_count;
		$formattedTotalPerPerUnit = Format::formatCurrency($totalPerUnit);
	} else {
		$formattedTotalPerPerUnit = '';
	}
	if(!$pdfGet){
	$bidSpreadHtml .= <<<BID_SPREAD_HTML

				<td colspan="4" align="right"><input id="subcontractorBidTotalCostPerUnit--$subcontractor_bid_id" type="text" class="input-unit-total bidder-total" value="$formattedTotalPerPerUnit" readonly></td>
BID_SPREAD_HTML;
}else
{
	$formattedTotalPerPerUnit=($formattedTotalPerPerUnit !="")?$formattedTotalPerPerUnit:"&nbsp;";
	$bidSpreadHtml .= <<<BID_SPREAD_HTML
	<td colspan="5" class="rightBorder" align="right">$formattedTotalPerPerUnit</td>
BID_SPREAD_HTML;

}

				if(!$pdfGet){
				$bidSpreadHtml .= <<<BID_SPREAD_HTML
				<td class="rightBorder">&nbsp;</td>
BID_SPREAD_HTML;
				}

}

$bidSpreadHtml .= <<<BID_SPREAD_HTML

			</tr>
		</tbody>
	</table>
</div>
BID_SPREAD_HTML;


//$bidSpreadApprovalProcessDialog = buildBidSpreadApprovalProcessDialog($database, $gc_budget_line_item_id);


$bidSpreadHtml .= <<<END_BID_SPREAD_HTML


	<input id="project_id" type="hidden" value="$currentlySelectedProjectId">
	<input id="gc_budget_line_item_id" type="hidden" value="$gc_budget_line_item_id">
	<input id="cost_code_division_id" type="hidden" value="$cost_code_division_id">
	<input id="cost_code_id" type="hidden" value="$cost_code_id">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--gross_square_footage--$currentlySelectedProjectId" type="hidden" value="$gross_square_footage">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--net_rentable_square_footage--$currentlySelectedProjectId" type="hidden" value="$net_rentable_square_footage">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--unit_count--$currentlySelectedProjectId" type="hidden" value="$project_unit_count">
	<input id="csvPreferredSubcontractorBidIds" type="hidden" value="$csvPreferredSubcontractorBidIds">

	<input id="openModal" type="hidden" value="$openModal">
	<input id="bid_spread_id" type="hidden" value="$bid_spread_id">
	<input id="active_bid_spread_id" type="hidden" value="$active_bid_spread_id">
	<input id="selected_bid_spread_id" type="hidden" value="-1">
	<input id="selected_bid_spread_status_id" type="hidden" value="-1">
	<input id="modal_bid_spread_sequence_number" type="hidden" value="$bidSpread->bid_spread_sequence_number">
	<input id="bid_spread_sequence_number" type="hidden" value="$bidSpread->bid_spread_sequence_number">
	<input id="csvSubcontractorBidIds" type="hidden" value="$csvSubcontractorBidIds">
END_BID_SPREAD_HTML;

if(!$pdfGet){
$bidSpreadHtml .= <<<END_BID_SPREAD_HTML

	<div id="messageDiv" class="userMessage"></div>
	<div id="divModalWindow" class="hidden" rel="tooltip" title="">&nbsp;</div>
	<div id="divAjaxLoading">Loading . . . <img alt="Loading..." src="/images/ajax-loader.gif"></div>
	<div id="divBidSpreadApprovalProcessDialog" class="hidden"></div>
END_BID_SPREAD_HTML;
}

	//$javaScriptDebugMode = true;
if ($javaScriptDebugMode) {
	$htmlBodyFooter = <<<END_HTML_BODY_FOOTER


	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
	<script src="/js/ddaccordion.js"></script>
	<script src="/js/library-main.js"></script>

	<script src="/js/permissions.js"></script>
	<script src="/js/admin-projects-team-management.js"></script>

	<!--[if lt IE 8]>
	<script src="/js/json2.js"></script>
	<![endif]-->

	<script src="/js/accounting.js"></script>
	<script src="/js/library-data_types.js"></script>
	<script src="/js/library-tabular_data.js"></script>

	<script src="/js/fileuploader.js"></script>
	<script src="/js/bootstrap-dropdown.js"></script>
	<script src="/js/bootstrap-popover.js"></script>
	<script src="/js/bootstrap-tooltip.js"></script>

	<script src="/js/library-code-generator.js"></script>

	<script src="/js/generated/bid_items-js.js"></script>
	<script src="/js/generated/bid_items_to_subcontractor_bids-js.js"></script>
	<script src="/js/generated/subcontracts-js.js"></script>
	<script src="/js/generated/subcontractor_bids-js.js"></script>

	<script src="/js/modules-gc-budget.js"></script>
	<script src="/js/modules-purchasing-bid-spread.js"></script>
	<script src="/js/fSelect.js"></script>
END_HTML_BODY_FOOTER;

} else {

		$htmlBodyFooter = <<<END_HTML_BODY_FOOTER


	<script src="/js/scripts.js.php"></script>

	<script src="/js/generated/bid_items-js.js"></script>
	<script src="/js/generated/bid_items_to_subcontractor_bids-js.js"></script>
	<script src="/js/generated/bid_spread_notes-js.js"></script>
	<script src="/js/generated/subcontracts-js.js"></script>
	<script src="/js/generated/subcontractor_bids-js.js"></script>
	<script src="/js/generated/contact_companies-js.js"></script>
	<script src="/js/generated/contact_company_offices-js.js"></script>
	<script src="/js/generated/contact_company_office_phone_numbers-js.js"></script>
	<script src="/js/generated/contact_phone_numbers-js.js"></script>
	<script src="/js/modules-gc-budget.js"></script>
	<script src="/js/modules-purchasing-bid-spread.js"></script>
	<script src="/js/fSelect.js"></script>
END_HTML_BODY_FOOTER;

}

$htmlBodyFooter .= <<<END_HTML_BODY_FOOTER

	<script>
		window.debugMode = false;
		window.showJSExceptions = true;
		window.modalDialogUrlDebugMode = false;
		window.ajaxUrlDebugMode = false;
	</script>
</body>
</html>
END_HTML_BODY_FOOTER;


$bidSpreadHtml .= $htmlBodyFooter;

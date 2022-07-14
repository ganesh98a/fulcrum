<?php

$cssDebugMode = false;
$javaScriptDebugMode = false;

// Display html as usual.
$bidSpreadHtml = '';
$contractheader = '';
$htmlHead = '';
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
if ($isExcel != 'true') {
$htmlHead = <<<END_HTML_HEAD
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title>Contract Tracking -$project_name</title>
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
END_HTML_HEAD;

} else {
	$htmlHead .= <<<END_HTML_HEAD

	<link rel="stylesheet" href="/css/styles.css.php">
	<link rel="stylesheet" href="/css/modules-purchasing-bid-spread.css">
END_HTML_HEAD;

}

$htmlHead .= <<<END_HTML_HEAD

	<style>
		body {
			/**/display: none;/**/
		}
	</style>
	<script>
		var arrBidSpreadStatuses = '';
	</script>
</head>
<body>
<div id="modalDialogContainer" class="hidden"></div>
END_HTML_HEAD;
}else{

$htmlHead .= <<<END_HTML_HEAD

	<style>
		body {
			border:0.5px solid #ccc !important;
		}
		a {
		    text-decoration: none !important;
			color : #000000 !important; 
		}
		#ContractTrackingtblTabularData .permissionTableMainHeader td {
            color: #fff !important;  
        }
        #ContractTrackingtblTabularData .permissionTableMainHeader div {
            color: #fff !important;  
        }
        .permissionTableMainHeader{
          background: #3b90ce !important;
          color: #fff !important;  
        }
        .purStyle{
            background: #dfdfdf !important;
        }
	</style>
	<script>
		var arrBidSpreadStatuses = '';
	</script>
</head>
<body>
END_HTML_HEAD;
}
$bidSpreadHtml .= $htmlHead;

if ($isExcel != 'true') {
// @todo Figure Out Subtotals  // overlay-table
$gc_budget_line_item_id = '';
$bidSpreadHtml .= <<<BID_SPREAD_HTML
<div class="">
<div id="purchasingBidSpreadContainer--$gc_budget_line_item_id">
	<div id="divSpreadButtons" style="float:left;">
		$headerlist
		<input type="button" value="Print PDF - Subcontracts Manager" onclick="printContractTracking();">
		<input type="button" value="Export Excel - Subcontracts Manager" onclick="exportContractTracking();">
	</div>
	<div id="sendpopup" class="modal"></div>
	<div id="createPrelims" class="modal"></div>
	
<div id="dialog-confirm" ></div>
	
BID_SPREAD_HTML;
}
$arrSubcontractItemTemplates = SubcontractItemTemplate::loadSubcontractItemTemplatesDefault($database, $user_company_id);
$dynamicHeadCount=Count($arrSubcontractItemTemplates);

if ($isExcel == 'true') {
$contractheader .= <<<BID_SPREAD_HTML
<table width="100%" class="table-header">
 	<tr>
 	<td style="font-size:25px;padding:18px;" colspan="12">$currentlySelectedProjectName : Subcontracts Manager</td>
 	</tr>
 	</table>
BID_SPREAD_HTML;
}else{
$contractheader .= <<<BID_SPREAD_HTML
<input type="hidden" id="dynamicHeadCount" value="$dynamicHeadCount">
BID_SPREAD_HTML;
}


$contractheader .= <<<BID_SPREAD_HTML
<table id="ContractTrackingtblTabularData" width="100%">
<tbody>
<tr class="permissionTableMainHeader">
	<td>Code</td>
	<td class="NameMinWid">Name</td>
	<td class="CNameMinWid">Company</td>
	<td>Amount</td>
	<td>Mailed </td>
	<td>Gen Con</td>
BID_SPREAD_HTML;
$dynamicHeader = <<<dynamicHeader
<tr class="permissionTableMainHeader">
	<td>Code</td>
	<td class="NameMinWid">Name</td>
	<td class="CNameMinWid">Company</td>
	<td>Amount</td>
	<td>Mailed </td>
	<td>Gen Con</td>
dynamicHeader;
foreach ($arrSubcontractItemTemplates as $subcontractItemTemplate) {
	$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
	$subcontract_item_abbreviation = (string) $subcontractItemTemplate->subcontract_item_abbreviation;
	if($subcontract_item_abbreviation=="")
	{
		$subcontractheader=$subcontract_item;
		$subheadclass="class='contract_header bs-tooltip' data-toggle='tooltip' title='' data-original-title='".$subcontract_item."'";
		$tdclass="tracking-gridtooltip";
	}else
	{
		$subcontractheader=$subcontract_item_abbreviation;
		$subheadclass="";
		$tdclass="";
	}
	
// To generated dynamic headers
$contractheader .= <<<BID_SPREAD_HTML
	<td class='$tdclass'><div $subheadclass>$subcontractheader</div> </td>
BID_SPREAD_HTML;
$dynamicHeader .= <<<dynamicHeader
	<td class='$tdclass'><div $subheadclass> $subcontractheader </div></td>
dynamicHeader;
// End of generate dynamic header
}
$contractheader .= <<<BID_SPREAD_HTML
	<td class='tracking-gridtooltip'><div class='bs-tooltip' data-toggle='tooltip' title='' data-original-title='Subcontract Target Execution Date'>Target</div></td>
	<td>Executed </td>
	<td>SNDBCK Executed </td>
	<td>CSLB LIC</td>
	<td>CSLB EXP</td>
	<td>GL INS</td>
	<td>GL INS EXP</td>
	<td>WC INS</td>
	<td>WC INS EXP</td>
	<td>Auto INS</td>
	<td>Auto INS EXP</td>
	<td>BUS LIC </td>
	<td>BUS LIC EXP</td>
	<td>NTCE</td>
</tr>

BID_SPREAD_HTML;
$dynamicHeader .= <<<dynamicHeader
	<td class='tracking-gridtooltip'><div class='bs-tooltip' data-toggle='tooltip' title='' data-original-title='Subcontract Target Execution Date'>Target</div></td>
	<td>Executed </td>
	<td>SNDBCK Executed </td>
	<td>CSLB LIC</td>
	<td>CSLB EXP</td>
	<td>GL INS</td>
	<td>GL INS EXP</td>
	<td>WC INS</td>
	<td>WC INS EXP</td>
	<td>Auto INS</td>
	<td>Auto INS EXP</td>
	<td>BUS LIC </td>
	<td>BUS LIC EXP</td>
	<td>NTCE</td>
</tr>
dynamicHeader;



$bidSpreadHtml .= $contractheader;

//Body content
$loadGcBudgetLineItemsByProjectIdOptions = new Input();
	$loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
	if (!empty($order_by_attribute)) {
		if (!$order_by_direction) {
			$order_by_direction = 'ASC';
		}
		if ($order_by_attribute == 'cost_code') {
			$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
				'gbli_fk_codes__fk_ccd.`division_number`' => $order_by_direction,
				'gbli_fk_codes.`cost_code`' => $order_by_direction
			);

		} else {
			$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
				$order_by_attribute => $order_by_direction
			);
		}
	}
	
	$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions,'');
	$gcBudgetLineItemsTbody = '';

	$primeContractScheduledValueTotal = 0.00;
	$forecastedExpensesTotal = 0.00;
	$subcontractActualValueTotal = 0.00;
	$varianceTotal = 0.00;
	$loopCounter = 1;
	$tabindex = 100;
	$tabindex2 = 200;
	$pcsvcs = 0;
	$fecs = 0;
	$savcs = 0;
	$vcs = 0;
	$ioput = 1;
	$ioputIn = 1;
	$countArray = count($arrGcBudgetLineItemsByProjectId);
	$incrementIndex = 0;
	$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

	foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
		/* @var $gcBudgetLineItem GcBudgetLineItem */

		if (!empty($scheduledValuesOnly)) {
			$prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
			if (!$prime_contract_scheduled_value) {
				continue;
			}
		}

		$costCode = $gcBudgetLineItem->getCostCode();
		/* @var $costCode CostCode */
		$cost_code_id = $costCode->cost_code_id;


		$costCode->htmlEntityEscapeProperties();

		$costCodeDivision = $costCode->getCostCodeDivision();
		/* @var $costCodeDivision CostCodeDivision */

		$costCodeDivision->htmlEntityEscapeProperties();

		$cost_code_division_id = $costCodeDivision->cost_code_division_id;
		$division_number = $costCodeDivision->division_number;
		$cost_code = $costCode->cost_code;
		$cost_code_description = $costCode->cost_code_description;
		$costCodeLabel = $division_number.$costCodeDividerType.$cost_code.' '.$cost_code_description;

		if (isset($cost_code_division_id_filter)) {
			if ($cost_code_division_id_filter != $cost_code_division_id) {
				continue;
			}
		}

		$contactCompany = $gcBudgetLineItem->getContactCompany();
		/* @var $contactCompany ContactCompany */

		$costCodeDivisionAlias = $gcBudgetLineItem->getCostCodeDivisionAlias();
		/* @var $costCodeDivisionAlias CostCodeDivisionAlias */

		$costCodeAlias = $gcBudgetLineItem->getCostCodeAlias();
		/* @var $costCodeAlias CostCodeAlias */

		$subcontractorBid = $gcBudgetLineItem->getSubcontractorBid();
		/* @var $subcontractorBid SubcontractorBid */

		$invitedBiddersCount = 0;
		$activeBiddersCount = 0;
		if (isset($arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id])) {
			$arrBidderStatusCounts = $arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id];
			$code_insert='';
			$head_insert='';
			foreach ($arrBidderStatusCounts as $subcontractor_bid_status_id => $total) {
				if ($subcontractor_bid_status_id <> 1) {
					$invitedBiddersCount += $total;
				}
			}

			// Active Bidders - Actively Bidding
			if (isset($arrBidderStatusCounts[4])) {
				$activelyBiddingCount = $arrBidderStatusCounts[4];
				$activeBiddersCount += $activelyBiddingCount;
			}

			// Active Bidders - Bid Received
			if (isset($arrBidderStatusCounts[5])) {
				$bidReceivedCount = $arrBidderStatusCounts[5];
				$activeBiddersCount += $bidReceivedCount;
			}
		}

		if ($invitedBiddersCount == 0) {
			$invitedBiddersCount = '';
		}

		if ($activeBiddersCount == 0) {
			$activeBiddersCount = '';
		}

		if (isset($subcontractorBid) && ($subcontractorBid instanceof SubcontractorBid)) {
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractor_bid_id = $subcontractorBid->subcontractor_bid_id;
		} else {
			$subcontractor_bid_id = '';
		}
		$Fullcode=$costCodeDivision->escaped_division_number .'-'.$costCode->escaped_cost_code;
		$Headcode=$costCodeDivision->escaped_division_number;
		
		// prime_contract_scheduled_value
		$prime_contract_scheduled_value_raw = $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
		$primeContractScheduledValueClass = '';
		if (isset($prime_contract_scheduled_value) && !empty($prime_contract_scheduled_value)) {
			$primeContractScheduledValueTotal += $prime_contract_scheduled_value;
			if ($prime_contract_scheduled_value < 0) {
				$primeContractScheduledValueClass = ' red';
			}
			$prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
		} else {
			$prime_contract_scheduled_value = '&nbsp;';
		}

		// forecasted_expenses
		$forecasted_expenses_raw = $forecasted_expenses = $gcBudgetLineItem->forecasted_expenses;
		$forecastedExpensesClass = '';
		
		if (isset($forecasted_expenses) && !empty($forecasted_expenses)) {
			$forecastedExpensesTotal += $forecasted_expenses;
			if ($forecasted_expenses < 0) {
				$forecastedExpensesClass = ' red';
			}
			$forecasted_expenses = Format::formatCurrency($forecasted_expenses);
		} else {
			$forecasted_expenses = '&nbsp;';
		}

		$loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
		$loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
		$arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
		if (isset($arrSubcontracts) && !empty($arrSubcontracts)) {
			$subcontractCount = count($arrSubcontracts);
		} else {
			$subcontractCount = 0;
		}
		$subcontract_actual_value_raw = $subcontract_actual_value = null;
		$vendorList = '';
		$target_date = '';
		$arrSubcontractActualValueHtml = array();
		$arrSubcontractVendorHtml = array();
		$tmpSubcontractVendorHtmlInputs='';
		$SubcontractlicenseHtmlInputs='';
		$SubcontractExpDateHtmlInputs='';

		foreach ($arrSubcontracts as $subcontract) {
			/* @var $subcontract Subcontract */

			$tmp_subcontract_id = $subcontract->subcontract_id;
			$tmp_subcontract_sequence_number = $subcontract->subcontract_sequence_number;
			$tmp_subcontract_template_id = $subcontract->subcontract_template_id;
			$tmp_vendor_id = $subcontract->vendor_id;
			$tmp_unsigned_subcontract_file_manager_file_id = $subcontract->unsigned_subcontract_file_manager_file_id;
			$tmp_signed_subcontract_file_manager_file_id = $subcontract->signed_subcontract_file_manager_file_id;
			$tmp_subcontract_forecasted_value = $subcontract->subcontract_forecasted_value;
			$tmp_subcontract_actual_value = $subcontract->subcontract_actual_value;
			$tmp_subcontract_retention_percentage = $subcontract->subcontract_retention_percentage;
			$tmp_subcontract_issued_date = $subcontract->subcontract_issued_date;
			$tmp_subcontract_target_execution_date = $subcontract->subcontract_target_execution_date;
			$tmp_subcontract_execution_date = $subcontract->subcontract_execution_date;
			$tmp_active_flag = $subcontract->active_flag;
			$tmp_subcontract_vendor_contact_id = $subcontract->subcontract_vendor_contact_id;
			$ven_mail=Contact::ContactEmailById($database,$tmp_subcontract_vendor_contact_id,'email');


			// Subcontract Actual Value list
			$subcontract_actual_value_raw += $tmp_subcontract_actual_value;
			$subcontract_actual_value += $tmp_subcontract_actual_value;
			$formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
		if(!empty($head_insert) && $head_insert != $Headcode)
		{
			$head_insert=$costCodeDivision->escaped_division_number;
			$code_insert_header='border-top:3px solid #888888;';
			if($loopCounter == 1){
				$trRepeatHeader = '';
			}else{
				$trRepeatHeader = $dynamicHeader;
			}
		}else
		{
			$code_insert_header='';
			$trRepeatHeader = '';
		}

			// To get the signed date
			$gencon=getsignedUpdateDate($database, $tmp_signed_subcontract_file_manager_file_id);
			if($gencon!='ADD' && $gencon!= " - "){
				$gencon = date('m/d/y',strtotime($gencon)); 
				if($isExcel=="true")
				{
				$gencon ="&nbsp;".$gencon;
				}
			}
			//End of obtainening date
			if ($subcontractCount == 1) {
				$tmpSubcontractActualValueHtml = $formattedSubcontractActualValue;
			} elseif ($subcontractCount > 1) {
				$tmpSubcontractActualValueHtml = <<<END_HTML_CONTENT

				<div class="textAlignLeft">
						$formattedSubcontractActualValue
					</div>
END_HTML_CONTENT;

			}
			$arrSubcontractActualValueHtml[] = $tmpSubcontractActualValueHtml;

			// Vendor list
			$vendor = $subcontract->getVendor();

			if ($vendor) {
				//To get contact company id 
				$vendorlicense=getCompanydatas($database, $vendor->vendor_contact_company_id,'construction_license_number');
				$vendorlicenseexpDate=getCompanydatas($database, $vendor->vendor_contact_company_id,'construction_license_number_expiration_date');
				$linexpdate = checkdateexpired($vendorlicenseexpDate);
				if($vendorlicenseexpDate=='00/00/00')
				{
					$vendorlicenseexpDate='';
				}

				$vendorContactCompany = $vendor->getVendorContactCompany();
				/* @var $vendorContactCompany ContactCompany */

				$vendorContactCompany->htmlEntityEscapeProperties();

				$vendorList = $vendorContactCompany->escaped_contact_company_name ;
				if ($subcontractCount == 1) {

					$tmpSubcontractVendorHtmlInputs = $vendorContactCompany->escaped_contact_company_name;

					$SubcontractlicenseHtmlInputs = '<input id="manage-contact_company-record--contact_companies--construction_license_number--'.$incrementIndex.'-'.$vendor->vendor_contact_company_id.'" class="wideInput inputLicenseTrack" maxlength="9" value="'.$vendorlicense.'" onchange="updateCompanyField(&apos;'.$vendor->vendor_contact_company_id.'&apos;,&apos;license&apos;,&apos;manage-contact_company-record--contact_companies--construction_license_number&apos;, '.$incrementIndex.');">';

					$SubcontractExpDateHtmlInputs = '

					<input id="manage-contact_company-record--contact_companies--construction_license_number_expiration_date--'.$incrementIndex.'-'.$vendor->vendor_contact_company_id.'" style="'.$linexpdate.'" class=" picker inputDateTrack inputDateTrack" value="'.$vendorlicenseexpDate.'" onchange="updateCompanyField( &apos;'.$vendor->vendor_contact_company_id.'&apos;,&apos;licenseDate&apos;,&apos;manage-contact_company-record--contact_companies--construction_license_number_expiration_date&apos;, '.$incrementIndex.');" title="MM/DD/YYYY">';


				} elseif ($subcontractCount > 1) {

					$tmpSubcontractVendorHtmlInputs .= <<<END_HTML_CONTENT
					<div class="textAlignLeft">$tmp_subcontract_sequence_number)$vendorContactCompany->escaped_contact_company_name</div>

				
END_HTML_CONTENT;
$SubcontractlicenseHtmlInputs = <<<END_HTML_CONTENT
					<div class="textAlignLeft">
					<input id="manage-contact_company-record--contact_companies--construction_license_number--$incrementIndex-$vendor->vendor_contact_company_id" maxlength="9" class="wideInput inputLicenseTrack" value="$vendorlicense" onchange="updateCompanyField(&apos;$vendor->vendor_contact_company_id&apos;,&apos;license&apos;,&apos;manage-contact_company-record--contact_companies--construction_license_number&apos;, $incrementIndex);">
</div>
			
END_HTML_CONTENT;

$SubcontractExpDateHtmlInputs = <<<END_HTML_CONTENT
					<div class="textAlignLeft">
					<input id="manage-contact_company-record--contact_companies--construction_license_number_expiration_date--$incrementIndex-$vendor->vendor_contact_company_id" style="$linexpdate" class="picker inputDateTrack" value="$vendorlicenseexpDate" onchange="updateCompanyField('$vendor->vendor_contact_company_id', 'licenseDate','manage-contact_company-record--contact_companies--construction_license_number_expiration_date', $incrementIndex);" >

</div>

				
END_HTML_CONTENT;

				}
				$arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;
				

			}

			// subcontract_target_execution_date
			$formattedSubcontractTargetExecutionDate = $subcontract->deriveFormattedSubcontractTargetDate();
			$formattedSubcontractmailedDate = $subcontract->deriveFormattedSubcontractMailedDate();
			$formattedSubcontractExecutionDate = $subcontract->deriveFormattedSubcontractExecutionDate();
			$formattedGeneralInsuranceDate = $subcontract->deriveFormattedgeneralinsurancedate();
			$formattedworkerdate = $subcontract->deriveFormattedworkerdate();
			$formattedcarinsurancedate = $subcontract->deriveFormattedcarinsurancedate();
			$formattedcitylicensedate = $subcontract->deriveFormattedcitylicensedate();
			$Formattedsendbackdate = $subcontract->deriveFormattedsendbackdate();
			$send_back=$subcontract->send_back;

			$formattedGeneralInsuranceDateExp = $subcontract->deriveFormattedgeneralinsurancedateEXP();
			$formattedworkerdateEXP = $subcontract->deriveFormattedworkerdateEXP();
			$formattedcarinsurancedateEXP = $subcontract->deriveFormattedcarinsurancedateEXP();
			$formattedcitylicensedateEXP = $subcontract->deriveFormattedcitylicensedateEXP();
			if ($isExcel == 'true') {
			$formattedGeneralInsuranceDateExp = "&nbsp;".$formattedGeneralInsuranceDateExp;
			$formattedworkerdateEXP = "&nbsp;".$formattedworkerdateEXP;
			$formattedcarinsurancedateEXP = "&nbsp;".$formattedcarinsurancedateEXP;
			$formattedcitylicensedateEXP = "&nbsp;".$formattedcitylicensedateEXP;
			}


			if($Formattedsendbackdate=='')
			{
				$sendbackdata='<button class="send-tracking-button-mt"><span>Send</span></button>';
			}else{
				$sendbackdata=$Formattedsendbackdate;
			}
			if ($isExcel != 'true') {
				$maildate = checkdateexpired($formattedSubcontractmailedDate);
				$exedate = checkdateexpired($formattedSubcontractExecutionDate);

				$insdateexp = checkdateexpired($formattedGeneralInsuranceDateExp,'1');
				$workdateEXP = checkdateexpired($formattedworkerdateEXP,'1');
				$cardateexp = checkdateexpired($formattedcarinsurancedateEXP,'1');
				$citydateexp = checkdateexpired($formattedcitylicensedateEXP,'1');

				$targetExecuted = checkdateexpired($formattedSubcontractTargetExecutionDate);
			}else{
				$maildate = '';
				$exedate = '';
				$insdateexp = '';
				$workdateEXP = '';
				$cardateexp = '';
				$citydateexp = '';
				$targetExecuted = '';
			}

			//To check Purchase order or not
			$purchase_temps=PurchasedTemplateOrNot($database, $tmp_subcontract_id);			


			//subcontractor documents
			$loadSubcontractDocumentsBySubcontractIdOptions = new Input();
			$loadSubcontractDocumentsBySubcontractIdOptions->forceLoadFlag = true;
			$arrSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentsBySubcontractId($database, $tmp_subcontract_id, $loadSubcontractDocumentsBySubcontractIdOptions);
			$ExistDocument='';
			$counter = 0;
			foreach ($arrSubcontractDocuments as $subcontract_document_id => $subcontractDocument) {
				/* @var $subcontractDocument SubcontractDocument */
				$subcontractItemTemplate = $subcontractDocument->getSubcontractItemTemplate();
				$subcontract_item_template_id = $subcontractDocument->subcontract_item_template_id;
				$unsigned_subcontract_document_file_manager_file_id = $subcontractDocument->unsigned_subcontract_document_file_manager_file_id;
				$signed_subcontract_document_file_manager_file_id = $subcontractDocument->signed_subcontract_document_file_manager_file_id;
				$auto_generated_flag = $subcontractDocument->auto_generated_flag;
				$disabled_flag = $subcontractDocument->disabled_flag;
				$sort_order = $subcontractDocument->sort_order;

				$signedSubcontractDocumentFileManagerFile = $subcontractDocument->getSignedSubcontractDocumentFileManagerFile();
				/* @var $signedSubcontractDocumentFileManagerFile FileManagerFile */

				if ($signedSubcontractDocumentFileManagerFile) {
				

					$signed_version_number = !empty($unsignedSubcontractDocumentFileManagerFile) ? $unsignedSubcontractDocumentFileManagerFile->version_number:'';

					if (!isset($signed_version_number) || ($signed_version_number == 1)) {
						$signedSubcontractDocumentUrl = $uri->cdn . '_' . $signedSubcontractDocumentFileManagerFile->file_manager_file_id;
					} else {
						$signedSubcontractDocumentUrl = $uri->cdn . '_' . $signedSubcontractDocumentFileManagerFile->file_manager_file_id . '?v=' . $signed_version_number;
					}
					$signedSubcontractDocumentFilename = $signedSubcontractDocumentFileManagerFile->virtual_file_name;
					$signedSubcontractDocumentFileManagerFileLink =
						'<a class="underline bs-tooltip" data-toggle="tooltip" data-placement="bottom" target="_blank" href="'.$signedSubcontractDocumentUrl.'" title="'.$signedSubcontractDocumentFilename.'">Link To Document</a>';
					$ExistDocument .='1~';

				} else {
					$signedSubcontractDocumentFileManagerFileLink = '';
					$ExistDocument .='0~';

				}
			}
			$chkAllDocuments='';
			if( strpos( $ExistDocument, '0' ) !== false ) {
			   $chkAllDocuments='N';
			   $sendTxtcol='color:red';
			}else
			{
				$chkAllDocuments='Y';
				$sendTxtcol='';
			}
			//end of subcontrator documents
			//For license doc
			$general_insurance_file_id = $subcontract->general_insurance_file_id;
			if($general_insurance_file_id == '0')
			{
				$instxt ="ADD";
				$insdate ="color:red;";

			}else {
				$instxt ="VIEW";
				$insdate ="";
			}
			$worker_file_id = $subcontract->worker_file_id;
			if($worker_file_id == '0')
			{
				$worktxt ="ADD";
				$workdate ="color:red;";
			}else {
				$worktxt ="VIEW";
				$workdate ="";
			}
			$car_insurance_file_id = $subcontract->car_insurance_file_id;
			if($car_insurance_file_id == '0')
			{
				$cartxt ="ADD";
				$cardate ="color:red;";
			}else {
				$cartxt ="VIEW";
				$cardate ="";
			}
			$city_license_file_id = $subcontract->city_license_file_id;
			if($city_license_file_id == '0')
			{
				$citytxt ="ADD";
				$citydate ="color:red;";
			}else {
				$citytxt ="VIEW";
				$citydate ="";
			}
			//end For license doc

	$dialogfullHead=$costCodeDivision->escaped_division_number.$costCodeDividerType.$costCode->escaped_cost_code." ".$costCode->escaped_cost_code_description." - ";

			if ($subcontractCount == 1) {

				$tmpSubcontractTargetExecutionDateHtmlInput = <<<END_HTML_CONTENT

				<input id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="picker contractinputDate" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, '', 0, '', false);" style="" value="$formattedSubcontractTargetExecutionDate"/> 
END_HTML_CONTENT;

$tmpSubcontractMailedDateHtmlInput = <<<END_HTML_CONTENT

				<input id="manage-subcontract-record--subcontracts--subcontract_mailed_date--$tmp_subcontract_id" class="picker inputDateTrack" data-format="00/00/00" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, '', '', '', false);" style="$maildate;" value="$formattedSubcontractmailedDate"/> 
END_HTML_CONTENT;

$tmpSubcontractExecutionDateHtmlInput = <<<END_HTML_CONTENT

				<input id="manage-subcontract-record--subcontracts--subcontract_execution_date--$tmp_subcontract_id" class="picker contractinputDate" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, '', '', '', false);" style="" value="$formattedSubcontractExecutionDate"/> 
END_HTML_CONTENT;

$tmpGENLIB = <<<END_HTML_CONTENT
				<a href="javascript:insuranceDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');" style="$insdate" id="insDocument_$tmp_subcontract_id-1">$instxt</a>
				
END_HTML_CONTENT;

$tmpGENLIBEXP = <<<END_HTML_CONTENT
				<span style="$insdateexp" id="insDate_$tmp_subcontract_id-1">$formattedGeneralInsuranceDateExp</span>
				
END_HTML_CONTENT;

$tmpCARINS  = <<<END_HTML_CONTENT
	<a href="javascript:insuranceDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');" style="$cardate" id="insDocument_$tmp_subcontract_id-3">$cartxt</a>
				
END_HTML_CONTENT;
$tmpCARINSEXP  = <<<END_HTML_CONTENT
				<span style="$cardateexp" id="insDate_$tmp_subcontract_id-3">$formattedcarinsurancedateEXP</span>

END_HTML_CONTENT;

$tmpWRKCHP = <<<END_HTML_CONTENT
	<a href="javascript:insuranceDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');" style="$workdate" id="insDocument_$tmp_subcontract_id-2">$worktxt</a>
				 
END_HTML_CONTENT;

$tmpWRKCHPEXP = <<<END_HTML_CONTENT
				<span style="$workdateEXP" id="insDate_$tmp_subcontract_id-2">$formattedworkerdateEXP</span>				
END_HTML_CONTENT;

$tmpCTYBUS  = <<<END_HTML_CONTENT
			<a href="javascript:insuranceDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');" style="$citydate" id="insDocument_$tmp_subcontract_id-4">$citytxt</a>

END_HTML_CONTENT;

$tmpCTYBUSEXP  = <<<END_HTML_CONTENT
				<span style="$citydateexp" id="insDate_$tmp_subcontract_id-4">$formattedcitylicensedateEXP</span>

END_HTML_CONTENT;

$tmpRAISE  = <<<END_HTML_CONTENT

 <a id="updatedateforsendBack_$tmp_subcontract_id" href="javascript:ManualNotifyPop('$gc_budget_line_item_id', '$cost_code_division_id', '$cost_code_id', '$tmp_subcontract_id', '$subcontract->subcontract_execution_date', '$subcontract->subcontract_mailed_date','$costCodeLabel','$vendorList','$ven_mail');" style="$sendTxtcol"> Send </a>

END_HTML_CONTENT;
if($gencon=='ADD')
	$style="color:red;";
else
	$style="";
$tmpsigned = <<<END_HTML_CONTENT
<label class="trackAddLabel"><a id="signeddocument_$tmp_subcontract_id" style="$style" href="javascript:signed($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');">$gencon </a>
					</label>
END_HTML_CONTENT;

if($isExcel == 'true'){
	$tmpSubcontractMailedDateHtmlInput ='&nbsp;'.$formattedSubcontractmailedDate;
	$tmpSubcontractTargetExecutionDateHtmlInput ='&nbsp;'. $formattedSubcontractTargetExecutionDate;
	$tmpSubcontractExecutionDateHtmlInput = '&nbsp;'.$formattedSubcontractExecutionDate;
	$SubcontractlicenseHtmlInputs = $vendorlicense;
	$SubcontractExpDateHtmlInputs ='&nbsp;'. $vendorlicenseexpDate;
}


if($isExcel == 'true'){
$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
			$trRepeatHeader
			<tr class="$purchase_temps">
			<td class="">
				<span>$costCodeDivision->escaped_division_number</span>
				<span>$costCodeDividerType</span>
				<span>$costCode->escaped_cost_code</span>
			</td>
END_GC_BUDGET_LINE_ITEMS_TBODY;
}else{
$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
				$trRepeatHeader
				<tr class="$purchase_temps">
				<td class="">
					<span id="gc_budget_line_items--cost_code_divisions--division_number--$cost_code_division_id" data-origin-id="cost_code_divisions--division_number--$cost_code_division_id">$costCodeDivision->escaped_division_number</span><span>$costCodeDividerType</span><span id="gc_budget_line_items--cost_codes--cost_code--$cost_code_id" data-origin-id="cost_codes--cost_code--$cost_code_id">$costCode->escaped_cost_code</span>
				</td>
END_GC_BUDGET_LINE_ITEMS_TBODY;
}

$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
					<td id="gc_budget_line_items--cost_codes--cost_code_description--$cost_code_id" data-origin-id="cost_codes--cost_code_description--$cost_code_id" class="" >
						$costCode->escaped_cost_code_description
					</td>
					<td align="left"$vendorListTdClass id="gc_budget_line_items--vendorList--$gc_budget_line_item_id"  ><a href="javascript:defaultDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead',$tmp_subcontract_template_id);" class="gc_budget_line_items--vendorList-$tmp_subcontract_id">$vendorList</a></td>
					<td>
						$tmpSubcontractActualValueHtml
					</td>
					<td align="center" class=""> $tmpSubcontractMailedDateHtmlInput</td>
					<td align="center">$tmpsigned</td>
END_GC_BUDGET_LINE_ITEMS_TBODY;


//For dynamic header content
$dy_inc='1';

foreach ($arrSubcontractItemTemplates as $subcontractItemTemplate) {
	$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
	$subcontract_item_template_id = (string) $subcontractItemTemplate->subcontract_item_template_id;
	$defaultTracking = SubcontractItemTemplate::loadSubcontractItemTrackTemplates($database, $user_company_id, $tmp_subcontract_template_id, $subcontract_item_template_id);
	$contractTrack = $defaultTracking['contract_track'];
	$resSignDate = DefaultDocumentSignedDate($database, $tmp_subcontract_id,$subcontract_item_template_id);
	if($contractTrack == 'Y'){
		if($resSignDate == 'ADD'){
			$styleDate="color:red;";
		}else{
			$styleDate="";
			if($resSignDate!= " - "){
				$resSignDate = date('m/d/y',strtotime($resSignDate));
				if($isExcel=="true")
				{
				$resSignDate ="&nbsp;".$resSignDate;
				}
			}
		}
	}else{
		$resSignDate = '-';
	}

	$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
	<td align="center">
	 <label class="trackAddLabel">
	  <a id="updateDocument_$tmp_subcontract_id-$dy_inc" style="$styleDate" href="javascript:defaultDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead',$tmp_subcontract_template_id,'updateDocument_$tmp_subcontract_id-$dy_inc','$subcontract_item_template_id');">
		 $resSignDate
		</a>
	 </label>
	</td>
END_GC_BUDGET_LINE_ITEMS_TBODY;
	$dy_inc++;
				}
		//Fetching Count in other column
		$loadSubcontractDocumentsBySubcontractIdOptions = new Input();
		$loadSubcontractDocumentsBySubcontractIdOptions->forceLoadFlag = true;

		$totalSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentsBySubcontractId($database, $tmp_subcontract_id, $loadSubcontractDocumentsBySubcontractIdOptions);
		$subDocCount=0;
		$DocumenthasnoData=0;
		foreach ($totalSubcontractDocuments as $subcontract_document_id => $subcontractDocuments) {
			$subcontractItemTemplates = $subcontractDocuments->getSubcontractItemTemplate();
			$is_trackable = (string) $subcontractItemTemplates->is_trackable;
			$existsignedDoc=(int) $subcontractDocuments->signed_subcontract_document_file_manager_file_id;
			// is_trackable
			if($is_trackable =='N')
			{
			$subDocCount++;
			if($existsignedDoc =='0')
			{
				$DocumenthasnoData++;
			}
		}

		}
		if($DocumenthasnoData == 0)
		{
			$DocumenthasnoData ='';
		}else
		{
			$DocumenthasnoData .='/';
		}
		

	
		//End of Count in other column

				$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
					<td align="center" class="">$tmpSubcontractTargetExecutionDateHtmlInput</td>

					<td align="center" class="">$tmpSubcontractExecutionDateHtmlInput</td>
					<td style="cursor:pointer;" align="center"> <a id="updatedateforsendBack_$tmp_subcontract_id" href="javascript:Chkdocument('$gc_budget_line_item_id', '$cost_code_division_id', '$cost_code_id', '$tmp_subcontract_id', '$subcontract->subcontract_execution_date', '$subcontract->subcontract_mailed_date','$costCodeLabel');" style="$sendTxtcol">$sendbackdata</a>
					<input type="hidden" id="sendBack_$tmp_subcontract_id" value="$send_back">
					<input type="hidden" id="allDoc_$tmp_subcontract_id" value="$chkAllDocuments"> 
					</td>
					<td> $SubcontractlicenseHtmlInputs</td>
					<td> $SubcontractExpDateHtmlInputs</td>
					<td>$tmpGENLIB</td>
					<td>$tmpGENLIBEXP</td>
					<td>$tmpWRKCHP</td>
					<td>$tmpWRKCHPEXP</td>
					<td>$tmpCARINS</td>
					<td>$tmpCARINSEXP</td>
					<td>$tmpCTYBUS</td>
					<td>$tmpCTYBUSEXP</td>
					<td>$tmpRAISE</td>
				</tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;



			} elseif ($subcontractCount > 1) {

				$tmpSubcontractTargetExecutionDateHtmlInput = <<<END_HTML_CONTENT

				<input id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="picker contractinputDate" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, '', 0, '', false);" style='' value="$formattedSubcontractTargetExecutionDate"/> 
				
END_HTML_CONTENT;
$tmpSubcontractMailedDateHtmlInput = <<<END_HTML_CONTENT

				<div class="textAlignLeft">
					
					<input id="manage-subcontract-record--subcontracts--subcontract_mailed_date--$tmp_subcontract_id" class="picker inputDateTrack" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, '', '', '', false);" data-format="00/00/00" style="$maildate;" value="$formattedSubcontractmailedDate" />
				</div>
END_HTML_CONTENT;
$tmpSubcontractExecutionDateHtmlInput = <<<END_HTML_CONTENT

				<div class="textAlignLeft">
					<input id="manage-subcontract-record--subcontracts--subcontract_execution_date--$tmp_subcontract_id" class="picker contractinputDate" onchange="updateSubcontractAndReloadSubcontractDetailsWidgetViaPromiseChain(this, '', '', '', false);" value="$formattedSubcontractExecutionDate"/> 
				</div>
END_HTML_CONTENT;

$tmpGENLIB = <<<END_HTML_CONTENT

				<div class="textAlignLeft">
				<a href="javascript:insuranceDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');" style="$insdate" id="insDocument_$tmp_subcontract_id-1">$instxt</a>
				</div>
END_HTML_CONTENT;
$tmpGENLIBEXP = <<<END_HTML_CONTENT
				<span style="$insdateexp" id="insDate_$tmp_subcontract_id-1">$formattedGeneralInsuranceDateExp</span>

END_HTML_CONTENT;

$tmpWRKCHP= <<<END_HTML_CONTENT

				<div class="textAlignLeft">
				<a href="javascript:insuranceDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');" style="$workdate" id="insDocument_$tmp_subcontract_id-2">$worktxt</a>
				</div>
END_HTML_CONTENT;

$tmpWRKCHPEXP= <<<END_HTML_CONTENT

				<div class="textAlignLeft">
				<span style="$workdateEXP" id="insDate_$tmp_subcontract_id-2">$formattedworkerdateEXP</span>
				</div>
END_HTML_CONTENT;

$tmpCARINS= <<<END_HTML_CONTENT

				<div class="textAlignLeft">
				<a href="javascript:insuranceDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');" style="$cardate" id="insDocument_$tmp_subcontract_id-3">$cartxt</a>
				</div>
END_HTML_CONTENT;
$tmpCARINSEXP= <<<END_HTML_CONTENT

				<div class="textAlignLeft">
				<span style="$cardateexp" id="insDate_$tmp_subcontract_id-3">$formattedcarinsurancedateEXP </span>
				
				</div>
END_HTML_CONTENT;

$tmpCTYBUS = <<<END_HTML_CONTENT

				<div class="textAlignLeft">
				<a href="javascript:insuranceDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead');" style="$citydate" id="insDocument_$tmp_subcontract_id-4">$citytxt</a>
				</div>
END_HTML_CONTENT;
$tmpCTYBUSEXP = <<<END_HTML_CONTENT

				<div class="textAlignLeft">
				<span style="$citydateexp" id="insDate_$tmp_subcontract_id-4">$formattedcitylicensedateEXP</span>
				</div>
END_HTML_CONTENT;
$tmpRAISE = <<<END_HTML_CONTENT

				<div class="textAlignLeft">
				<a id="updatedateforsendBack_$tmp_subcontract_id" href="javascript:ManualNotifyPop('$gc_budget_line_item_id', '$cost_code_division_id', '$cost_code_id', '$tmp_subcontract_id', '$subcontract->subcontract_execution_date', '$subcontract->subcontract_mailed_date','$costCodeLabel','$vendorList','$ven_mail');" style="$sendTxtcol"> Send</a>

				
END_HTML_CONTENT;
if($gencon=='ADD')
	$style="color:red;";
else
	$style="";
$tmpsigned = <<<END_HTML_CONTENT

				<div>
				<label class="trackAddLabel"><a id="signeddocument_$tmp_subcontract_id" style="$style" href="javascript:signed($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead')">$gencon</a>
					</label>
				</div>
END_HTML_CONTENT;

if($isExcel == 'true'){
	$tmpSubcontractMailedDateHtmlInput = '&nbsp;'.$formattedSubcontractmailedDate;
	$tmpSubcontractTargetExecutionDateHtmlInput = '&nbsp;'.$formattedSubcontractTargetExecutionDate;
	$tmpSubcontractExecutionDateHtmlInput = '&nbsp;'.$formattedSubcontractExecutionDate;
	$SubcontractlicenseHtmlInputs = $vendorlicense;
	$SubcontractExpDateHtmlInputs = '&nbsp;'.$vendorlicenseexpDate;
}

if($isExcel == 'true'){
$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
			$trRepeatHeader
			<tr class="$purchase_temps">
			<td class="">
				<span>$costCodeDivision->escaped_division_number</span>
				<span>$costCodeDividerType</span>
				<span>$costCode->escaped_cost_code</span>
			</td>
END_GC_BUDGET_LINE_ITEMS_TBODY;
}else{
$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
				$trRepeatHeader
				<tr class="$purchase_temps">
				<td class="">
					<span id="gc_budget_line_items--cost_code_divisions--division_number--$cost_code_division_id" data-origin-id="cost_code_divisions--division_number--$cost_code_division_id">$costCodeDivision->escaped_division_number</span><span>$costCodeDividerType</span><span id="gc_budget_line_items--cost_codes--cost_code--$cost_code_id" data-origin-id="cost_codes--cost_code--$cost_code_id">$costCode->escaped_cost_code</span>
				</td>
END_GC_BUDGET_LINE_ITEMS_TBODY;
}


$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
					<td id="gc_budget_line_items--cost_codes--cost_code_description--$cost_code_id" data-origin-id="cost_codes--cost_code_description--$cost_code_id" class="" onclick="loadGcBudgetLineItemSubcontractorBidManagementModalDialog('$gc_budget_line_item_id');">
						$costCode->escaped_cost_code_description
					</td>
					<td align="left" id="gc_budget_line_items--vendorList--$gc_budget_line_item_id" ><a href="javascript:defaultDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead',$tmp_subcontract_template_id);" class="gc_budget_line_items--vendorList-$tmp_subcontract_id">$vendorList</a></td>
					<td>
						$tmpSubcontractActualValueHtml
					</td>
					<td align="center" class=""> $tmpSubcontractMailedDateHtmlInput</td>
					<td align="center">$tmpsigned</td>
END_GC_BUDGET_LINE_ITEMS_TBODY;

//For dynamic count column
$dy_inc='1';
	foreach ($arrSubcontractItemTemplates as $subcontractItemTemplate) {
	$subcontract_item = (string) $subcontractItemTemplate->subcontract_item;
	$subcontract_item_template_id = (string) $subcontractItemTemplate->subcontract_item_template_id;
	$defaultTracking = SubcontractItemTemplate::loadSubcontractItemTrackTemplates($database, $user_company_id, $tmp_subcontract_template_id, $subcontract_item_template_id);
	$contractTrack = $defaultTracking['contract_track'];
	$resDate= DefaultDocumentSignedDate($database, $tmp_subcontract_id,$subcontract_item_template_id);
	$styleDate="";
	if($contractTrack == 'Y'){
		if($resDate=='ADD'){
			$styleDate="color:red;";
		}
		else{
			$styleDate="";
			if($resDate!= " - "){
				$resDate = date('m/d/y', strtotime($resDate));
				if($isExcel=='true')
				{
					$resDate ="&nbsp;".$resDate;
				}
			}
		}
  }else{
	  $resDate = '-';
  }
	$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
				<td align="center">
				 <label class="trackAddLabel">
				  <a style="$styleDate" id="updateDocument_$tmp_subcontract_id-$dy_inc" href="javascript:defaultDocuments($gc_budget_line_item_id,$tmp_subcontract_id,'$dialogfullHead',$tmp_subcontract_template_id,'updateDocument_$tmp_subcontract_id-$dy_inc','$subcontract_item_template_id');">
				   $resDate
					</a>
			   </label>
				</td>
END_GC_BUDGET_LINE_ITEMS_TBODY;
$dy_inc++;

}
//End of dynamic count column

				//Count in other column
		$loadSubcontractDocumentsBySubcontractIdOptions = new Input();
		$loadSubcontractDocumentsBySubcontractIdOptions->forceLoadFlag = true;

		$totalSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentsBySubcontractId($database, $tmp_subcontract_id, $loadSubcontractDocumentsBySubcontractIdOptions);
		$subDocCount=0;
		$DocumenthasnoData=0;
		foreach ($totalSubcontractDocuments as $subcontract_document_id => $subcontractDocuments) {
			$subcontractItemTemplates = $subcontractDocuments->getSubcontractItemTemplate();
			$subcontract_item = (string) $subcontractItemTemplates->subcontract_item;
			$is_trackable = (string) $subcontractItemTemplates->is_trackable;
			$existsignedDoc=(int) $subcontractDocuments->signed_subcontract_document_file_manager_file_id;
			// is_trackable
			if($is_trackable =='N')
			{
			$subDocCount++;
			if($existsignedDoc =='0')
			{
				$DocumenthasnoData++;
			}
		}

		}
		if($DocumenthasnoData == 0)
		{
			$DocumenthasnoData ='';
		}else
		{
			$DocumenthasnoData .='/';
		}
	
		//End of Count in other column
				$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
					<td align="center" class=""> $tmpSubcontractTargetExecutionDateHtmlInput</td>
					<td align="center" class="">$tmpSubcontractExecutionDateHtmlInput</td>
					<td style="cursor:pointer;" align="center"> <a id="updatedateforsendBack_$tmp_subcontract_id" href="javascript:Chkdocument('$gc_budget_line_item_id', '$cost_code_division_id', '$cost_code_id', '$tmp_subcontract_id', '$subcontract->subcontract_execution_date', '$subcontract->subcontract_mailed_date','$costCodeLabel');" style="$sendTxtcol">$sendbackdata</a>
					<input type="hidden" id="sendBack_$tmp_subcontract_id" value="$send_back">
					<input type="hidden" id="allDoc_$tmp_subcontract_id" value="$chkAllDocuments"> 
					</td>
					<td> $SubcontractlicenseHtmlInputs</td>
					<td> $SubcontractExpDateHtmlInputs</td>
					<td>$tmpGENLIB</td>
					<td>$tmpGENLIBEXP</td>
					<td>$tmpWRKCHP</td>
					<td>$tmpWRKCHPEXP</td>
					<td>$tmpCARINS</td>
					<td>$tmpCARINSEXP</td>
					<td>$tmpCTYBUS</td>
					<td>$tmpCTYBUSEXP</td>
					<td>$tmpRAISE</td>
				</tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;

			}
			$incrementIndex++;
		}

		// subcontract actual values
		if ($subcontractCount > 1) {
		
			$subcontractActualValueHtml = join('', $arrSubcontractActualValueHtml);
			$subcontractActualValueHtml = "\n\t\t\t\t\t$subcontractActualValueHtml";
		} else {
			$subcontractActualValueHtml = '';
		}

		// vendors
		$vendorList = $tmpSubcontractVendorHtmlInputs;
		if ($subcontractCount > 1) {
			$vendorListTdClass = ' class=""';
		} else {
			$vendorListTdClass = '';
		}
		if(!empty($arrSubcontracts))
		{
		$loopCounter++;
		}
		$tabindex++;
		$tabindex2++;
		$ioputIn++;
		$incrementIndex++;
	}

if($gcBudgetLineItemsTbody !='')
{
$bidSpreadHtml .=$gcBudgetLineItemsTbody;
}
else
{
	$dynamicHeadCount=$dynamicHeadCount+20;
$bidSpreadHtml .= "<tr><td colspan =$dynamicHeadCount align=center>No Data Exists</td></tr>";
}

$bidSpreadHtml .= <<<BID_SPREAD_HTML
</tbody>
</table>
</div>

BID_SPREAD_HTML;
$bid_spread_sequence_number = '';
if(!empty($bidSpread->bid_spread_sequence_number)){
	$bid_spread_sequence_number = $bidSpread->bid_spread_sequence_number;
}

if ($isExcel != 'true') {

$bidSpreadHtml .= <<<END_BID_SPREAD_HTML


	<input id="project_id" type="hidden" value="$currentlySelectedProjectId">
	<input id="gc_budget_line_item_id" type="hidden" value="$gc_budget_line_item_id">
	<input id="cost_code_division_id" type="hidden" value="$cost_code_division_id">
	<input id="cost_code_id" type="hidden" value="$cost_code_id">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--gross_square_footage--$currentlySelectedProjectId" type="hidden" value="">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--net_rentable_square_footage--$currentlySelectedProjectId" type="hidden" value="">
	<input id="subcontrator_bid_spread_reference_data-project-record--projects--unit_count--$currentlySelectedProjectId" type="hidden" value="">
	<input id="csvPreferredSubcontractorBidIds" type="hidden" value="">

	<input id="openModal" type="hidden" value="">
	<input id="bid_spread_id" type="hidden" value="">
	<input id="active_bid_spread_id" type="hidden" value="">
	<input id="selected_bid_spread_id" type="hidden" value="-1">
	<input id="selected_bid_spread_status_id" type="hidden" value="-1">
	<input id="modal_bid_spread_sequence_number" type="hidden" value="">
	<input id="bid_spread_sequence_number" type="hidden" value="$bid_spread_sequence_number">
	<input id="csvSubcontractorBidIds" type="hidden" value="">

	<div id="messageDiv" class="userMessage"></div>
	<div id="divModalWindow" class="hidden" rel="tooltip" title="">&nbsp;</div>
	<div id="divModalWindow2" class="hidden divModalWindow2Tracking" rel="tooltip" title="">&nbsp;</div>
	<div id="divAjaxLoading">Loading . . . <img alt="Loading..." src="/images/ajax-loader.gif"></div>
	<div id="divBidSpreadApprovalProcessDialog" class="hidden"></div>
END_BID_SPREAD_HTML;
}


/* To fetch the company Datas*/
function getCompanydatas($database, $companyId,$columnVal){
	$db = DBI::getInstance($database);
	if($columnVal=='construction_license_number_expiration_date')
	{
		$columnName="DATE_FORMAT(construction_license_number_expiration_date, '%m/%d/%y') as construction_license_number_expiration_date";
	}else
	{
		$columnName=$columnVal;
	}
		$query ="SELECT	$columnName FROM `contact_companies` WHERE id=$companyId";
		$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		return $row[$columnVal];
}
function getsignedUpdateDate($database, $file_id)
{
	$db = DBI::getInstance($database);
	$query = "SELECT DATE_FORMAT(modified, '%m/%d/%Y') as modified from file_manager_files where id='".$file_id."' ";
	$db->execute($query);
	$row = $db->fetch();
	if($row)
	{
		$gencon=$row['modified'];
	}else
	{
		$gencon="ADD";
	}
	$db->free_result();	
		return $gencon;
}
function DefaultDocumentSignedDate($database, $subcontract_id,$subcontract_item_template_id){
	$db = DBI::getInstance($database);
	 $query = "SELECT signed_subcontract_document_file_manager_file_id from subcontract_documents where subcontract_id='".$subcontract_id."' and subcontract_item_template_id='".$subcontract_item_template_id."' ";
	$db->execute($query);
	$row = $db->fetch();
	if($row)
	{
		$docfile_id=$row['signed_subcontract_document_file_manager_file_id'];
		$docdate=getsignedUpdateDate($database, $docfile_id);
	}else
	{
		$docdate=" - ";
	}
	$db->free_result();
	return $docdate;


}
function checkdateexpired($itemdate,$test='')
{
	$itemdate_val=strtotime($itemdate);
	$today=strtotime(date('m/d/y'));
	if($today >= $itemdate_val){
		return "color:red;";
	} else {
		if($test)
		{
			return "color:#06c;";
		}else
		{
			return "color:black;";
		}
	   
	}

}
function PurchasedTemplateOrNot($database, $subcontractor)
{
	$db = DBI::getInstance($database);
	$query = "SELECT s.subcontract_template_id,st.subcontract_template_name from subcontracts as s
	 inner join subcontract_templates as st on s.subcontract_template_id=st.id where s.id='$subcontractor' and st.subcontract_type_id = '4'";
	 // and st.is_trackable='Y' and st.is_purchased='Y' "; //old
	$db->execute($query);
	$row = $db->fetch();
	if($row)
	{
		$result= "purStyle";
	}else
	{
		$result= "";
	}
	$db->free_result();
	return $result;

}

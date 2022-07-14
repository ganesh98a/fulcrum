<?php
require_once('lib/common/BidList.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/GcBudgetLineItem.php');


function renderVectorReportHtml($database, $project_id, $user_company_id, $includegrp,$includegrprowval,$inotes,$subtotal,$costCodeAlias,$reportType){

	$textAlign = 'class="textAlignRight"';

	$groupdivision_completed = BidList::findBidlistByCompanyProjectId($database, $project_id, $user_company_id);
	//$includegrp  =='true'
	if($groupdivision_completed && ($includegrp  ==2 || $includegrp  ==3)){
		exit('groupdivnotmap');
	}

	$vectorreportbody = renderVectorReportTbody($database, $user_company_id, $project_id, null, false, false, false, false,$includegrp,$includegrprowval,$inotes,$subtotal,$costCodeAlias);

	$project = Project::findProjectByIdExtended($database, $project_id);
	$OCODisplay = $project->COR_type;	

	/* @var $project Project */
	$unit_count = $project->unit_count;
	$net_rentable_square_footage = $project->net_rentable_square_footage;

	$nospan = 10;
	$ocoCol = '';
	if ($OCODisplay == 2) {
		$ocoCol = '<th nowrap width="60px">OCO</th>';
		$nospan = 11;
	}

	// vector report header title
	if($reportType == 'pdf'){
		$htmlContent = <<<END_HTML_CONTENT
<table id="vectorReportBudgetTable" border="0" style="border-collapse:collapse;border: 1px solid #adadad;" cellpadding="2" cellspacing="0" width="100%">
	<thead>
		<tr style="vertical-align: center;background: #0e6db6;color: #ffffff;">
			<th nowrap width="60px">Cost Code</th>
			<th nowrap width="120px">Cost Code Description</th>
			<th nowrap width="60px">Org. PSCV</th>
			<th nowrap width="60px">Reallocation</th>
			$ocoCol
			<th nowrap width="60px">Cur. Budget</th>
			<th nowrap width="60px">SCO</th>
        	<th nowrap width="60px">Cur. Sub. Value</th>
          	<th nowrap width="60px">Variance</th>
        	<th nowrap width="60px">Cost / Sq. Ft</th>
        	<th nowrap width="60px">Cost / Unit</th>
        </tr>  
    </thead>
END_HTML_CONTENT;

	}else{
		$htmlContent = <<<END_HTML_CONTENT
<table id="vectorReportBudgetTable" border="0" style="border-collapse:collapse;border: 1px solid #adadad;" cellpadding="2" cellspacing="0" width="100%">
	<tr class="table-headerinner">
    	<th colspan="$nospan" class="textAlignLeft">Vector Report</th>
	</tr>
	<tr style="vertical-align: center;">
		<th nowrap width="60px">Cost Code</th>
		<th nowrap width="120px">Cost Code Description</th>
		<th nowrap width="60px">Original PSCV</th>
		<th nowrap width="60px">Reallocation</th>
		$ocoCol
		<th nowrap width="60px">Current Budget</th>
		<th nowrap width="60px">SCO</th>
    	<th nowrap width="60px">Current Subcontract Value</th>
      	<th nowrap width="60px">Variance</th>
    	<th nowrap width="60px">Cost Per Sq. Ft. <br> ($net_rentable_square_footage)</th>
		<th nowrap width="60px">Cost Per Unit <br> ($unit_count)</th>
    </tr>	  		
END_HTML_CONTENT;
	}

	$htmlContent .= <<<END_HTML_CONTENT
		<tbody>
			{$vectorreportbody}
END_HTML_CONTENT;

	return $htmlContent;
}



function renderVectorReportTbody($database, $user_company_id, $project_id, $cost_code_division_id_filter=null, $order_by_attribute=false, $order_by_direction=false, $scheduledValuesOnly=false, $needsBuyOutOnly=false,$includegrp,$includegrprowval,$inotes,$subtotal,$costCodeAlias)
{
	$loadGcBudgetLineItemsByProjectIdOptions = new Input();
	$loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
	if ($order_by_attribute) {
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

	$costCodeDivider = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

	
	$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions,'');
	$costCodeDivisionCnt = GcBudgetLineItem::costCodeDivisionCountByProjectId($database, $project_id);
	$main_company = Project::ProjectsMainCompany($database,$project_id);
	$arrSubcontractorBidStatusCountsByProjectId = SubcontractorBid::loadSubcontractorBidStatusCountsByProjectId($database, $main_company, $project_id, $cost_code_division_id_filter);

	

	$session = Zend_Registry::get('session');
	/* @var $session Session */
	$debugMode = $session->getDebugMode();

	if ($debugMode) {

		$fillerColumns = <<<END_FILLER_COLUMNS

				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
END_FILLER_COLUMNS;

	} else {
		$fillerColumns = '';
	}
	$gcBudgetLineItemsTbody = '';

	$primeContractScheduledValueTotal = 0.00;
	$loopCounter = 1;
	$tabindex = 100;
	$tabindex2 = 200;
	$sub_tot_ori_pscv = 0;
	$sub_tot_reallocation = 0;
	$sub_tot_oco = 0;
	$sub_tot_pscv = 0;
	$sub_tot_sco = 0;
	$sub_tot_crt_subcon = 0;
	$sub_tot_variance = 0;
	$sub_tot_cost_per_sq_ft = 0;
	$sub_tot_cost_per_unit = 0;
	$ioputIn = 1;
	$countArray = count($arrGcBudgetLineItemsByProjectId);
	// Cost per SF/Unit
	$project = Project::findProjectByIdExtended($database, $project_id);
	$OCODisplay = $project->COR_type;
	$alias_type = $project->alias_type;

	$nospan = 10;
	if ($OCODisplay == 2) {
		$nospan = 11;
	}
	$notesSpan = $nospan - 2;	

	/* @var $project Project */
	$unit_count = $project->unit_count;
	$net_rentable_square_footage = $project->net_rentable_square_footage;
	// vector report subtitle
	if($includegrp  ==2 || $includegrp  == 3){
	 	$gcBudgetLineGeneralcond = '<tr style="font-weight: bold; text-transform: uppercase;"><td colspan="'.$nospan.'" class="table-headerinner"><b>GENERAL CONDITIONS</b></td>
				</tr>';

		$gcBudgetLineSiteworks = '<tr style="font-weight: bold; text-transform: uppercase;"><td colspan="'.$nospan.'" class="table-headerinner"><b>SITEWORK COSTS</b></td>
				</tr>';
		$gcBudgetLinebuildingcost = '<tr style="font-weight: bold; text-transform: uppercase;"><td colspan="'.$nospan.'" class="table-headerinner"><b>BUILDING COSTS</b></td>
				</tr>';
		$gcBudgetLinesoftcost = '<tr style="font-weight: bold; text-transform: uppercase;"><td colspan="'.$nospan.'" class="table-headerinner"><b>SOFT COSTS</b></td>
				</tr>';
	}else{
		$gcBudgetLineGeneralcond = $gcBudgetLineSiteworks = $gcBudgetLinebuildingcost = $gcBudgetLinesoftcost = '';
	} 
	$gcBudgetLineSiteworksVar = $gcBudgetLinebuildingcostVar = $gcBudgetLinesoftcostVar =$gcBudgetLineGeneralcondVar = 	$gcBudgetLineSiteworksOrg = $gcBudgetLinebuildingcostOrg = $gcBudgetLinesoftcostOrg =$gcBudgetLineGeneralcondOrg = $csfunit_GeneralcondVar = $csfunit_SiteworksVar = $csfunit_buildingcostVar  = $csfunit_softcostVar =  $sav_GeneralcondVar = $sav_SiteworksVar = $sav_buildingcostVar  = $sav_softcostVar = $OverallOrg  = $overall_sav = $overall_var = $overall_csfunit = $overall_cpsfunit = $cpsfunit_GeneralcondVar = $cpsfunit_SiteworksVar = $cpsfunit_buildingcostVar  = $cpsfunit_softcostVar = 0;

	$gcBudget_OriginalPSCV_GeneralcondVar = $gcBudget_OCO_GeneralcondVar = $gcBudget_reallocation_GeneralcondVar = $gcBudget_OriginalPSCV_SiteworksVar = $gcBudget_OCO_SiteworksVar = $gcBudget_reallocation_SiteworksVar = $gcBudget_OriginalPSCV_buildingcostVar = $gcBudget_OCO_buildingcostVar = $gcBudget_reallocation_buildingcostVar = $gcBudget_OriginalPSCV_softcostVar = $gcBudget_OCO_softcostVar = $gcBudget_reallocation_softcostVar = $overall_Original_PSCV = $overall_OCO_Val = $overall_Reallocation_Val = $overall_Sco_amount = $gcBudget_SCO_GeneralcondVar = $gcBudget_SCO_SiteworksVar = $gcBudget_SCO_buildingcostVar = $gcBudget_SCO_softcostVar = $total_buyout_forcast = $total_forcast = 0;

	foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
		/* @var $gcBudgetLineItem GcBudgetLineItem */
		$gcBudgetsubLineItemsTbody = '';
		$cc_per_sf_unit_value = 0;
		$costrowcount = 0;
		$cc_per_sf_ft_value = 0;
		if ($scheduledValuesOnly) {
			$prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
			if (!$prime_contract_scheduled_value || $prime_contract_scheduled_value == null || $prime_contract_scheduled_value == 0) {
				continue;
			}
		}

		$notes = $gcBudgetLineItem->notes;

		$costCode = $gcBudgetLineItem->getCostCode();
		/* @var $costCode CostCode */

		$costCode->htmlEntityEscapeProperties();
		$cost_code_id = $costCode->cost_code_id;

		$costCodeDivision = $costCode->getCostCodeDivision();
		/* @var $costCodeDivision CostCodeDivision */

		$costCodeDivision->htmlEntityEscapeProperties();
		$cost_code_division_id = $costCodeDivision->cost_code_division_id;

		
		if (isset($cost_code_division_id_filter) && $cost_code_division_id_filter != $cost_code_division_id) {
			continue;
		}		

		/* @var $subcontractorBid SubcontractorBid */

		$invitedBiddersCount = 0;
		$activeBiddersCount = 0;
		if (isset($arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id])) {
			$arrBidderStatusCounts = $arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id];

			// Invited Bidders - Include all
			
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

		
		// prime_contract_scheduled_value
		$reallocated_amt = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$cost_code_id,$project_id);
		$prime_contract_scheduled_value_raw = $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value+$reallocated_amt;
		
		if (isset($prime_contract_scheduled_value) && !empty($prime_contract_scheduled_value)) {
			$primeContractScheduledValueTotal += $prime_contract_scheduled_value;
			$prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
		} else {
			$prime_contract_scheduled_value = '$0.00';
		}

		// original PSCV value
		$originalPSCV = $gcBudgetLineItem->prime_contract_scheduled_value;
		$originalPSCVFormatted = $originalPSCV ? Format::formatCurrency($originalPSCV) : '$0.00';

		// Owner Change order value
		$ocoVal = ChangeOrder::loadSumOfCostCodeBreakDownByProjectIdAndCostCodeId($database, $cost_code_id,$project_id);
		$oco_value = $ocoVal['totalBreakdownAmount'];
		$ocoValFormatted = $oco_value ? Format::formatCurrency($oco_value) : '$0.00';

		// Reallocation value
		$reallocationVal = DrawItems::costcodeReallocated($database, $cost_code_id,$project_id);
		$reallocation_Val = round($reallocationVal['total'],2);
		$reallocationValFormatted = $reallocation_Val ? Format::formatCurrency($reallocation_Val) : '$0.00';

		if ($OCODisplay == 1) {
			$prime_contract_scheduled_value_raw = $prime_contract_scheduled_value = $originalPSCV + $reallocation_Val;
			$primeContractScheduledValueTotal += $prime_contract_scheduled_value;
			$prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
		}

		// forecasted_expenses
		$forecasted_expenses_raw = $forecasted_expenses = $gcBudgetLineItem->forecasted_expenses;
		$total_forcast += $forecasted_expenses_raw;
		
		$costrowcount=2; //To combine the notes column

		$forecasted_expenses = floatval($forecasted_expenses);
		if (isset($forecasted_expenses) && !empty($forecasted_expenses)) {
			$forecasted_expenses = Format::formatCurrency($forecasted_expenses);
			$costrowcount++;
		} else {
			$forecasted_expenses = '$0.00';
		}

		// buyout forecasted
		$Buyout_forecasted__raw = $buyout_forecasted = $gcBudgetLineItem->buyout_forecasted_expenses;
		$total_buyout_forcast += $Buyout_forecasted__raw;

		$buyout_forecasted = floatval($buyout_forecasted);
		if (isset($buyout_forecasted) && !empty($buyout_forecasted)) {
			$buyout_forecasted = Format::formatCurrency($buyout_forecasted);
			$costrowcount++;
		} else {
			$buyout_forecasted = '$0.00';
		}

		$loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
		$loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
		$arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
		if (isset($arrSubcontracts) && !empty($arrSubcontracts)) {
			$subcontractCount = count($arrSubcontracts);
		} else {
			$subcontractCount = 0;
		}
				
		$subcontract_actual_value = null;
		$total_Sco_amount = 0;
		$vendorList = '';
		$arrSubcontractVendorHtml = array();

		$subcontractCount = $subcontractCount+1;

		$isSubcontractValue = 'false';
		foreach ($arrSubcontracts as $subcontract) {
			/* @var $subcontract Subcontract */

			$tmp_subcontract_id = $subcontract->subcontract_id;
			$tmp_subcontract_actual_value = $subcontract->subcontract_actual_value;
						
			//To check the SCO Exists for the subcontarctor
			$resdataarr =SubcontractChangeOrderDataAjax($database, $costCode->cost_code_id,$project_id,"all",$gc_budget_line_item_id,$tmp_subcontract_id);
			$resdata = $resdataarr['data'];
			$totalSCOAmount = $resdataarr['total'];
			
			// Subcontract Actual Value list
			$subcontract_actual_value += $tmp_subcontract_actual_value;
			
			if($tmp_subcontract_actual_value > 0)
			{
				$isSubcontractValue = 'true';
			}
			
			$formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);	

			// Vendor list
			$vendor = $subcontract->getVendor();
			if ($vendor) {

				$vendorContactCompany = $vendor->getVendorContactCompany();
				/* @var $vendorContactCompany ContactCompany */

				$vendorContactCompany->htmlEntityEscapeProperties();

				$ocoSubcontractTd = '';
				if ($OCODisplay == 2) {
					$ocoSubcontractTd = '<td></td>';
				}

				if ($subcontractCount >= 1) {
					// vector report subcontract row
                    $tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT
                    <tr>
                        <td>
                             <span style="display: inline-block; font-weight: bold;">$vendorContactCompany->escaped_contact_company_name </span>
                        </td>
                        <td></td>
                        <td></td>
                        $ocoSubcontractTd
                        <td></td>
                        <td></td>
                        <td class="textAlignRight">$formattedSubcontractActualValue</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
END_HTML_CONTENT;
$costrowcount++;
                    $arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;
                    if(!empty($resdata)){
                        foreach($resdata as $eachresdata){
                        $sequencenumber = $eachresdata['sequence_number'];
                        $SCOTitle ='<span class="SCOtitData" style="display: inline-block;
    width: 180px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"><span style="color:#06c !important;">'.$sequencenumber.'</span> | '.$eachresdata['title'].'</span>';

                        if(empty($sav_raw)) {$sav_raw = 0;}
                        $sav_raw += $eachresdata['estimated_amount_raw'];
                        $subcontract_actual_value += $eachresdata['estimated_amount_raw'];
                        $tmp_subcontract_actual_value += $eachresdata['estimated_amount_raw'];
                        $app_amount = $eachresdata['estimated_amount'];
						$total_Sco_amount += $eachresdata['estimated_amount_raw'];
						if($subcontract_actual_value > 0)
						{
							$isSubcontractValue = 'true';
						}
                        // vector report SCO row
                        $tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT
                        <tr>
                            <td class="textAlignRight">$SCOTitle </td>
                            <td></td>
                            <td></td>
                            $ocoSubcontractTd
                            <td></td>
                            <td class="textAlignRight">$app_amount</td>                            
                            <td class="textAlignRight">$app_amount</td> 
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
END_HTML_CONTENT;
                        $arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;
                        $costrowcount++;
                        }
                    }
                }

			}
			$CCPSFValue = $tmp_subcontract_actual_value/$unit_count;
			$cc_per_sf_unit_value += $CCPSFValue;


			$CPSFValue = $tmp_subcontract_actual_value/$net_rentable_square_footage;
			$cc_per_sf_ft_value += $CPSFValue;

			// @todo...this parts
			// Foreign key objects
			
		}

		// vendors
		$vendorList = join('', $arrSubcontractVendorHtml);
		if ($subcontractCount > 1) {
			$vendorList = "\n\t\t\t\t\t$vendorList";
		} 

		if ($needsBuyOutOnly && $subcontract_actual_value) {
			continue;
		}

		// subcontract_actual_value
		$subcontractActualValueClass = '';
		$sav_raw = $subcontract_actual_value;
		if (isset($subcontract_actual_value) && !empty($subcontract_actual_value)) {
			$subcontract_actual_value = Format::formatCurrency($subcontract_actual_value);
		} 

		// Cost per sf/unit actual values
		$CCPSFClass = '';
		$csfunit_raw = $cc_per_sf_unit_value;
		

		$cpsfunit_raw = $cc_per_sf_ft_value;
		
		// variance
		$pcsv = Data::parseFloat($prime_contract_scheduled_value_raw);
		$forecast = Data::parseFloat($forecasted_expenses_raw);
		$buyforecast = Data::parseFloat($Buyout_forecasted__raw);
		$sav_raw = Data::parseFloat($sav_raw);

		
		if(empty($vendorList) ){
			$v_raw = $gcBudgetLineItemVariance = $pcsv - ($forecast + $buyforecast + $sav_raw);
		}else{
			$v_raw = $gcBudgetLineItemVariance = $pcsv - ($forecast + $sav_raw);
		}
		
	
		$gcBudgetLineItemVarianceNum = $gcBudgetLineItemVariance;
		$gcBudgetLineItemVariance = Format::formatCurrency($gcBudgetLineItemVariance);

		$isRowVisible = 'true';
		if($isSubcontractValue == 'false' && $originalPSCV == 0 && $forecasted_expenses_raw == 0)
		{
			$isRowVisible = 'false';
		}
		if($v_raw != 0)
		{
			$isRowVisible = 'true';
		}

		$valueCheck = $costCodeDivisionCnt[$costCodeDivision->escaped_division_number]['division_number'];

		if($loopCounter==1){
			$costCodeDivisionCount = 1;
		}

		if($countArray == $loopCounter-1){
			echo $loopCounter;
		}

		if ($costCodeDivisionCount == $costCodeDivisionCnt[$costCodeDivision->escaped_division_number]['count']) {
			$costCodeDivisionCount = 0;
		}

		$ocoCostCodeTd = '';
		if ($OCODisplay == 2) {
			$ocoCostCodeTd = '<td></td>';
			// For oco
			unset($ocoVal['totalCount']);
			unset($ocoVal['totalBreakdownAmount']);

			if (count($ocoVal)>=1)
			{
				$costrowcount= $costrowcount+count($ocoVal);
			}
		}

		if ($inotes == "true" && $notes != '') { $costrowcount++; }

		$costCodeData = $costCodeDivision->escaped_division_number.$costCodeDivider.$costCode->escaped_cost_code;
		$getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_division_id);
		$getCostCodeAliasRe = str_replace(',', ',<br />', $getCostCodeAlias);
	    if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
	      $costCodeData = $costCodeData.'<br /> '.$getCostCodeAliasRe;
	    }	    

		if(($includegrprowval == 'true' && $isRowVisible == 'true') || ($includegrprowval == 'false')){
		// vector report costcode row
		$gcBudgetsubLineItemsTbody .= <<<GC_BUDGET_LINE_ITEMS_TBODY
            <tr>
                <td style="font-weight: bold;vertical-align: top;" rowspan="$costrowcount">&nbsp;$costCodeData</td>
                <td style="text-transform: uppercase; font-weight: bold;">$costCode->escaped_cost_code_description</td>
                <td class="textAlignRight">$originalPSCVFormatted</td>
                <td class="textAlignRight">$reallocationValFormatted</td>
                $ocoCostCodeTd               
                <td class="textAlignRight">$prime_contract_scheduled_value</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
GC_BUDGET_LINE_ITEMS_TBODY;
		}
		if ($OCODisplay == 2) {
			unset($ocoVal['totalCount']);
			unset($ocoVal['totalBreakdownAmount']);
			foreach ($ocoVal as $key => $value) {
				$coName = $value['co_title'];
				$coCustom = $value['co_custom_sequence_number'];
				if ($coCustom) {
					$ocoName = '<span style="color:#06c !important;">'.$coCustom.'</span> | '.$coName;
				}else{
					$ocoName = $coName;
				}
				$coValue = $value['cocb_cost'];
				$coValueFormatted = $coValue ? Format::formatCurrency($coValue) : '$0.00';
				// Owner change order row
				$gcBudgetsubLineItemsTbody .= <<<GC_BUDGET_LINE_ITEMS_TBODY
		            <tr>
		                <td class="textAlignRight">$ocoName</td>
		                <td></td>
		                <td></td>
		                <td class="textAlignRight">$coValueFormatted</td>              
		                <td></td>
		                <td></td>
		                <td></td>
		                <td></td>
		                <td></td>
		                <td></td>
		            </tr>
GC_BUDGET_LINE_ITEMS_TBODY;
			$costrowcount++;
			}
		}

		$deleteGcBudgetLineItemDesc = $costCode->escaped_cost_code.' / '.$costCode->escaped_cost_code_description;
		$deleteGcBudgetLineItemDesc = <<<HTMLENTITYMSG
		<span style="color:#3b90ce;">$deleteGcBudgetLineItemDesc</span>
HTMLENTITYMSG;
		$deleteGcBudgetLineItemDesc = htmlspecialchars($deleteGcBudgetLineItemDesc);

	if(!empty($vendorList) ){
		$gcBudgetsubLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
				$vendorList
END_GC_BUDGET_LINE_ITEMS_TBODY;
		$costrowcount++;
	}
	if(($includegrprowval == 'true' && $isRowVisible == 'true') || ($includegrprowval == 'false')){
		if(empty($vendorList) ){
				$sav_raw = $forecasted_expenses_raw + $Buyout_forecasted__raw +  $sav_raw;

		}else
		{
				$sav_raw = $forecasted_expenses_raw +  $sav_raw;

		}
	}

	$subcontract_actual_value = Format::formatCurrency($sav_raw);

	$forecastcpsfvalue = $forecasted_expenses_raw  / $net_rentable_square_footage;
	$forecastccpsfvalue = $forecasted_expenses_raw  / $unit_count;

	$cpsfunit_raw = $forecastcpsfvalue + $cpsfunit_raw;
	$cpsfunit_tot_format = Format::formatCurrency($cpsfunit_raw);


	$csfunit_raw =  $forecastccpsfvalue + $csfunit_raw;
	$csfunit_tot_format = Format::formatCurrency($csfunit_raw);

	if(($includegrprowval == 'true' && $isRowVisible == 'true') || ($includegrprowval == 'false')){
		$sub_tot_ori_pscv = $sub_tot_ori_pscv + $originalPSCV;
		$sub_tot_oco = $sub_tot_oco + $oco_value;
		$sub_tot_reallocation = round(($sub_tot_reallocation + $reallocation_Val),2);
		$sub_tot_sco = $sub_tot_sco + $total_Sco_amount;
		$sub_tot_crt_subcon = $sub_tot_crt_subcon + $sav_raw;
		$sub_tot_pscv = $sub_tot_pscv + $prime_contract_scheduled_value_raw;
		$sub_tot_variance = $sub_tot_variance + $v_raw;
		$sub_tot_cost_per_sq_ft = $sub_tot_cost_per_sq_ft + $cpsfunit_raw;
		$sub_tot_cost_per_unit = $sub_tot_cost_per_unit + $csfunit_raw;
	}


	$format_forecastcpsfvalue = Format::formatCurrency($forecastcpsfvalue);
	$format_forecastccpsfvalue = Format::formatCurrency($forecastccpsfvalue);

	$totalSCOAmountFormatted = $total_Sco_amount ? Format::formatCurrency($total_Sco_amount) : '$0.00';

	$ocoForecastTd = '';
	$ocoSubTotalTd = '';
	if ($OCODisplay == 2) {
		$ocoForecastTd = '<td></td>';
		$ocoSubTotalTd = '<td class="textAlignRight">'.$ocoValFormatted.'</td>';
	}


	$forecastedExpenseRow = <<<END_OF_FORECAST_EXPENSE_ROW
	<tr>
	<td>Forecast</td>
	<td></td>
	<td></td>
	$ocoForecastTd
	<td></td>
	<td></td>
	<td class="textAlignRight">
		<span style="float: right;">$forecasted_expenses</span>
	</td>
	<td class="textAlignRight"></td>
	<td class="textAlignRight">
		<span style="float: right;">$format_forecastcpsfvalue</span>
	</td>
	<td class="textAlignRight">
		<span style="float: right;">$format_forecastccpsfvalue</span>
	</td>
	</tr>
END_OF_FORECAST_EXPENSE_ROW;


	$buyoutForecastRow = <<<END_OF_BUYOUT_FORECAST_ROW
	<tr>
	<td>Buyout Forecast</td>
	<td></td>
	<td></td>
	$ocoForecastTd
	<td></td>
	<td></td>
	<td class="textAlignRight">$buyout_forecasted</td>
	<td class="textAlignRight"></td>
	<td class="textAlignRight">
	   
	</td>
	<td class="textAlignRight">
	</td>
</tr>
END_OF_BUYOUT_FORECAST_ROW;

// Here we are filtering zero values
$forecastedExpenseRow = $includegrprowval == 'true' ? ($forecasted_expenses != '$0.00' ? $forecastedExpenseRow : '') : $forecastedExpenseRow;
$buyoutForecastRow = $includegrprowval == 'true' ? ($buyout_forecasted != '$0.00' ? $buyoutForecastRow : '') : $buyoutForecastRow;

if(($includegrprowval == 'true' && $isRowVisible == 'true') || ($includegrprowval == 'false')){
	// vector report forecast and subtotal row   
$gcBudgetsubLineItemsTbody.=  <<<GC_BUDGET_LINE_ITEMS_TBODY
			$forecastedExpenseRow
            $buyoutForecastRow
            <tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
                <td>SubTotal</td>
                <td class="textAlignRight">$originalPSCVFormatted</td>
                <td class="textAlignRight">$reallocationValFormatted</td>
                $ocoSubTotalTd
                <td class="textAlignRight">$prime_contract_scheduled_value</td>
                <td class="textAlignRight">$totalSCOAmountFormatted</td>
                <td class="textAlignRight">
                    <div style="clear: right;" class="$subcontractActualValueClass">$subcontract_actual_value</div>
                </td>
                <td class="textAlignRight">$gcBudgetLineItemVariance</td>
                <td class="textAlignRight">
                    <div style="clear: right;" class="$CCPSFClass">$cpsfunit_tot_format</div>
                </td>
                <td class="textAlignRight">
                    <div style="border: 0px solid black; clear: right;" class="$CCPSFClass">$csfunit_tot_format</div>
                </td>
            </tr>
GC_BUDGET_LINE_ITEMS_TBODY;
}

if(($includegrprowval == 'true' && $isRowVisible == 'true') || ($includegrprowval == 'false')){
	if ($inotes == "true" && $notes != '' ) {
		$notes = nl2br($notes);
		$gcBudgetsubLineItemsTbody.=  <<<GC_BUDGET_LINE_ITEMS_TBODY
			<tr>
				<td style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">Notes :</td>
				<td colspan='$notesSpan'>$notes</td>
			</tr>
GC_BUDGET_LINE_ITEMS_TBODY;
	}
}

		$isSubtotalRowVisible = 'true';
		if($sub_tot_ori_pscv == 0 && $sub_tot_crt_subcon == 0)
		{
			$isSubtotalRowVisible = 'false';
		}

if(($includegrprowval == 'true' && $isSubtotalRowVisible == 'true') || ($includegrprowval == 'false')){
	if($costCodeDivisionCount == 0 && $subtotal == "true"){

			$sub_tot_ori_pscv = Format::formatCurrency($sub_tot_ori_pscv);
			$sub_tot_reallocation = Format::formatCurrency($sub_tot_reallocation);
			$sub_tot_oco = Format::formatCurrency($sub_tot_oco);
			$sub_tot_pscv = Format::formatCurrency($sub_tot_pscv);
			$sub_tot_sco = Format::formatCurrency($sub_tot_sco);
			$sub_tot_crt_subcon = Format::formatCurrency($sub_tot_crt_subcon);
			$sub_tot_variance = Format::formatCurrency($sub_tot_variance);
			$sub_tot_cost_per_sq_ft = Format::formatCurrency($sub_tot_cost_per_sq_ft);
			$sub_tot_cost_per_unit = Format::formatCurrency($sub_tot_cost_per_unit);

			$ocoCostCodeSubTd = '';
			if ($OCODisplay == 2) {
				$ocoCostCodeSubTd = '<td class="textAlignRight">'.$sub_tot_oco.'</td>';
			}

			$subTotalNumericWise = <<<Table_subtotal
			<tr style="background: #9f9e9e;text-transform: uppercase;font-weight:bold;">
				<td class="textAlignCenter">$valueCheck</td>
				<td>Subtotal</td>
                <td class="textAlignRight">$sub_tot_ori_pscv</td>
                <td class="textAlignRight">$sub_tot_reallocation</td>
				$ocoCostCodeSubTd
				<td class="textAlignRight">$sub_tot_pscv</td>
                <td class="textAlignRight">$sub_tot_sco</td>
                <td class="textAlignRight">$sub_tot_crt_subcon</td>
                <td class="textAlignRight">$sub_tot_variance</td>
                <td class="textAlignRight">$sub_tot_cost_per_sq_ft</td>
                <td class="textAlignRight">$sub_tot_cost_per_unit</td>
			</tr>
Table_subtotal;
			$gcBudgetsubLineItemsTbody .= $subTotalNumericWise;
			$subTotalNumericWise;
			$sub_tot_ori_pscv = 0;
			$sub_tot_reallocation = 0;
			$sub_tot_oco = 0;
			$sub_tot_pscv = 0;
			$sub_tot_sco = 0;
			$sub_tot_crt_subcon = 0;
			$sub_tot_variance = 0;
			$sub_tot_cost_per_sq_ft = 0;
			$sub_tot_cost_per_unit = 0;
			$ioputIn = 1;
		}
	}
		 $OverallOrg += $prime_contract_scheduled_value_raw;
		 $overall_sav += $sav_raw;
		 $overall_var += $gcBudgetLineItemVarianceNum;
		 $overall_csfunit += $csfunit_raw;
		 $overall_cpsfunit += $cpsfunit_raw; 
		 $overall_Original_PSCV += $originalPSCV;
		 $overall_OCO_Val += $oco_value;
		 $overall_Reallocation_Val = round(($overall_Reallocation_Val + $reallocation_Val),2);
		 $overall_Sco_amount += $total_Sco_amount;
		if($includegrp == 2 || $includegrp == 3 ){
			if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='1'){
				if($includegrp == 3){
					$gcBudgetsubLineItemsTbody = '';
				}
				$gcBudgetLineGeneralcond .= $gcBudgetsubLineItemsTbody; 
				$gcBudgetLineGeneralcondVar += $gcBudgetLineItemVarianceNum;
				$gcBudgetLineGeneralcondOrg += $prime_contract_scheduled_value_raw;
				$csfunit_GeneralcondVar += $csfunit_raw;
				$cpsfunit_GeneralcondVar += $cpsfunit_raw;
				$sav_GeneralcondVar += $sav_raw;
				$gcBudget_OriginalPSCV_GeneralcondVar += $originalPSCV;
				$gcBudget_OCO_GeneralcondVar += $oco_value;
				$gcBudget_reallocation_GeneralcondVar = round(($gcBudget_reallocation_GeneralcondVar + $reallocation_Val),2);
				$gcBudget_SCO_GeneralcondVar += $total_Sco_amount;
					
			}else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='2'){
				$gcBudgetLineSiteworks .= $gcBudgetsubLineItemsTbody; 
				$gcBudgetLineSiteworksVar += $gcBudgetLineItemVarianceNum;
				$gcBudgetLineSiteworksOrg += $prime_contract_scheduled_value_raw;
				$csfunit_SiteworksVar += $csfunit_raw;
				$cpsfunit_SiteworksVar += $cpsfunit_raw;
				$sav_SiteworksVar += $sav_raw;
				$gcBudget_OriginalPSCV_SiteworksVar += $originalPSCV;
				$gcBudget_OCO_SiteworksVar += $oco_value;
				$gcBudget_reallocation_SiteworksVar = round(($gcBudget_reallocation_SiteworksVar + $reallocation_Val),2);
				$gcBudget_SCO_SiteworksVar += $total_Sco_amount;
			}else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='3'){
				$gcBudgetLinebuildingcost .= $gcBudgetsubLineItemsTbody; 
				$gcBudgetLinebuildingcostVar += $gcBudgetLineItemVarianceNum;
				$gcBudgetLinebuildingcostOrg += $prime_contract_scheduled_value_raw;
				$csfunit_buildingcostVar += $csfunit_raw;
				$cpsfunit_buildingcostVar += $cpsfunit_raw;
				$sav_buildingcostVar += $sav_raw;
				$gcBudget_OriginalPSCV_buildingcostVar += $originalPSCV;
				$gcBudget_OCO_buildingcostVar += $oco_value;
				$gcBudget_reallocation_buildingcostVar = round(($gcBudget_reallocation_buildingcostVar + $reallocation_Val),2);
				$gcBudget_SCO_buildingcostVar += $total_Sco_amount;
			}else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='4'){
				$gcBudgetLinesoftcost .= $gcBudgetsubLineItemsTbody; 
				$gcBudgetLinesoftcostVar += $gcBudgetLineItemVarianceNum;
				$gcBudgetLinesoftcostOrg += $prime_contract_scheduled_value_raw;
				$csfunit_softcostVar += $csfunit_raw;
				$sav_softcostVar += $sav_raw;
				$cpsfunit_softcostVar += $cpsfunit_raw;
				$gcBudget_OriginalPSCV_softcostVar += $originalPSCV;
				$gcBudget_OCO_softcostVar += $oco_value;
				$gcBudget_reallocation_softcostVar = round(($gcBudget_reallocation_softcostVar+$reallocation_Val),2);
				$gcBudget_SCO_softcostVar += $total_Sco_amount;
			}
		}else{
			$gcBudgetLineGeneralcond .= $gcBudgetsubLineItemsTbody; 
			$gcBudgetLineGeneralcondVar += $gcBudgetLineItemVarianceNum;
			$gcBudgetLineGeneralcondOrg += $prime_contract_scheduled_value_raw;
			$csfunit_GeneralcondVar += $csfunit_raw;
			$cpsfunit_GeneralcondVar += $cpsfunit_raw;
			$sav_GeneralcondVar += $sav_raw;
			$gcBudget_OriginalPSCV_GeneralcondVar += $originalPSCV;
			$gcBudget_OCO_GeneralcondVar += $oco_value;
			$gcBudget_reallocation_GeneralcondVar = round(($gcBudget_reallocation_GeneralcondVar + $reallocation_Val),2);
			$gcBudget_SCO_GeneralcondVar += $total_Sco_amount;
		}

		$loopCounter++;
		$tabindex++;
		$costCodeDivisionCount++;
		$tabindex2++;
		$ioputIn++;
	}
	
	$gcBudgetLineGeneralcondVar = Format::formatCurrency($gcBudgetLineGeneralcondVar);
	$gcBudgetLineSiteworksVar = Format::formatCurrency($gcBudgetLineSiteworksVar);
	$gcBudgetLinebuildingcostVar = Format::formatCurrency($gcBudgetLinebuildingcostVar);
	$gcBudgetLinesoftcostVar = Format::formatCurrency($gcBudgetLinesoftcostVar);


	$gcBudgetLineSiteworksOrg = Format::formatCurrency($gcBudgetLineSiteworksOrg);
	$gcBudgetLinebuildingcostOrg = Format::formatCurrency($gcBudgetLinebuildingcostOrg);
	$gcBudgetLinesoftcostOrg = Format::formatCurrency($gcBudgetLinesoftcostOrg);
	$gcBudgetLineGeneralcondOrg = Format::formatCurrency($gcBudgetLineGeneralcondOrg);

	$csfunit_GeneralcondVar = Format::formatCurrency($csfunit_GeneralcondVar);
	$csfunit_SiteworksVar = Format::formatCurrency($csfunit_SiteworksVar);
	$csfunit_buildingcostVar = Format::formatCurrency($csfunit_buildingcostVar);
	$csfunit_softcostVar = Format::formatCurrency($csfunit_softcostVar);


	$cpsfunit_GeneralcondVar = Format::formatCurrency($cpsfunit_GeneralcondVar);
	$cpsfunit_SiteworksVar = Format::formatCurrency($cpsfunit_SiteworksVar);
	$cpsfunit_buildingcostVar = Format::formatCurrency($cpsfunit_buildingcostVar);
	$cpsfunit_softcostVar = Format::formatCurrency($cpsfunit_softcostVar);

	$sav_GeneralcondVar = Format::formatCurrency($sav_GeneralcondVar);
	$sav_SiteworksVar = Format::formatCurrency($sav_SiteworksVar);
	$sav_buildingcostVar  = Format::formatCurrency($sav_buildingcostVar);
	$sav_softcostVar = Format::formatCurrency($sav_softcostVar);

	$gcBudget_OriginalPSCV_GeneralcondVar = Format::formatCurrency($gcBudget_OriginalPSCV_GeneralcondVar);
	$gcBudget_OCO_GeneralcondVar = Format::formatCurrency($gcBudget_OCO_GeneralcondVar);
	$gcBudget_reallocation_GeneralcondVar = Format::formatCurrency($gcBudget_reallocation_GeneralcondVar);
	$gcBudget_SCO_GeneralcondVar = Format::formatCurrency($gcBudget_SCO_GeneralcondVar);

	$gcBudget_OriginalPSCV_SiteworksVar = Format::formatCurrency($gcBudget_OriginalPSCV_SiteworksVar);
	$gcBudget_OCO_SiteworksVar = Format::formatCurrency($gcBudget_OCO_SiteworksVar);
	$gcBudget_reallocation_SiteworksVar = Format::formatCurrency($gcBudget_reallocation_SiteworksVar);
	$gcBudget_SCO_SiteworksVar = Format::formatCurrency($gcBudget_SCO_SiteworksVar);

	$gcBudget_OriginalPSCV_buildingcostVar = Format::formatCurrency($gcBudget_OriginalPSCV_buildingcostVar);
	$gcBudget_OCO_buildingcostVar = Format::formatCurrency($gcBudget_OCO_buildingcostVar);
	$gcBudget_reallocation_buildingcostVar = Format::formatCurrency($gcBudget_reallocation_buildingcostVar);
	$gcBudget_SCO_buildingcostVar = Format::formatCurrency($gcBudget_SCO_buildingcostVar);

	$gcBudget_OriginalPSCV_softcostVar = Format::formatCurrency($gcBudget_OriginalPSCV_softcostVar);
	$gcBudget_OCO_softcostVar = Format::formatCurrency($gcBudget_OCO_softcostVar);
	$gcBudget_reallocation_softcostVar = Format::formatCurrency($gcBudget_reallocation_softcostVar);
	$gcBudget_SCO_softcostVar = Format::formatCurrency($gcBudget_SCO_softcostVar);

	$ocoGeneralcondVarTd = '';
	$ocoSiteworksVarTd = '';
	$ocobuildingcostVarTd = '';
	$ocosoftcostVarTd = '';
	if ($OCODisplay == 2) {
		$ocoGeneralcondVarTd = '<td align="right">'.$gcBudget_OCO_GeneralcondVar.'</td>';
		$ocoSiteworksVarTd = '<td align="right">'.$gcBudget_OCO_SiteworksVar.'</td>';
		$ocobuildingcostVarTd = '<td align="right">'.$gcBudget_OCO_buildingcostVar.'</td>';
		$ocosoftcostVarTd = '<td align="right">'.$gcBudget_OCO_softcostVar.'</td>';
	}


if($includegrp == 2 || $includegrp == 3){
	 $gcBudgetLineGeneraltot = <<<GC_BUDGET_LINE_ITEMS_TBODY
	 			<tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
					<td colspan="2" align="right">TOTAL GENERAL CONDITIONS</td>
					<td align="right">$gcBudget_OriginalPSCV_GeneralcondVar</td>
					<td align="right">$gcBudget_reallocation_GeneralcondVar</td>
					$ocoGeneralcondVarTd
					<td align="right">$gcBudgetLineGeneralcondOrg</td>
					<td align="right">$gcBudget_SCO_GeneralcondVar</td>
					<td align="right">$sav_GeneralcondVar</td>
					<td align="right">$gcBudgetLineGeneralcondVar</td>
					<td align="right">$cpsfunit_GeneralcondVar</td>
					<td align="right">$csfunit_GeneralcondVar</td>				
				</tr>				
GC_BUDGET_LINE_ITEMS_TBODY;
}else{
	$gcBudgetLineGeneraltot = '';
}
if($includegrp == 2 || $includegrp == 3){
 $gcBudgetLineSiteworkstot = <<<GC_BUDGET_LINE_ITEMS_TBODY
				<tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
					<td colspan="2" align="right">TOTAL SITEWORK COSTS</td>
					<td align="right">$gcBudget_OriginalPSCV_SiteworksVar</td>
					<td align="right">$gcBudget_reallocation_SiteworksVar</td>
					$ocoSiteworksVarTd
					<td align="right">$gcBudgetLineSiteworksOrg</td>
					<td align="right">$gcBudget_SCO_SiteworksVar</td>
					<td align="right">$sav_SiteworksVar</td>
					<td align="right">$gcBudgetLineSiteworksVar</td>
					<td align="right">$cpsfunit_SiteworksVar</td>
					<td align="right">$csfunit_SiteworksVar</td>
				</tr>				
GC_BUDGET_LINE_ITEMS_TBODY;

 $gcBudgetLinebuildingcosttot = <<<GC_BUDGET_LINE_ITEMS_TBODY
 				<tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
					<td colspan="2" align="right">TOTAL BUILDING COSTS</td>
					<td align="right">$gcBudget_OriginalPSCV_buildingcostVar</td>
					<td align="right">$gcBudget_reallocation_buildingcostVar</td>
					$ocobuildingcostVarTd
					<td align="right">$gcBudgetLinebuildingcostOrg</td>
					<td align="right">$gcBudget_SCO_buildingcostVar</td>
					<td align="right">$sav_buildingcostVar</td>
					<td align="right">$gcBudgetLinebuildingcostVar</td>
					<td align="right">$cpsfunit_buildingcostVar</td>
					<td align="right">$csfunit_buildingcostVar</td>
				</tr>				
GC_BUDGET_LINE_ITEMS_TBODY;
$gcBudgetLinesoftcosttot  = <<<GC_BUDGET_LINE_ITEMS_TBODY
				<tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
					<td colspan="2" align="right">TOTAL SOFT COSTS</td>
					<td align="right">$gcBudget_OriginalPSCV_softcostVar</td>
					<td align="right">$gcBudget_reallocation_softcostVar</td>
					$ocosoftcostVarTd 
					<td align="right">$gcBudgetLinesoftcostOrg</td>
					<td align="right">$gcBudget_SCO_softcostVar</td>
					<td align="right">$sav_softcostVar</td>
					<td align="right">$gcBudgetLinesoftcostVar</td>
					<td align="right">$cpsfunit_softcostVar</td>
					<td align="right">$csfunit_softcostVar</td>
				</tr>				
GC_BUDGET_LINE_ITEMS_TBODY;

$stylefix = $stylefix1 = '';
// $stylefix = <<<GC_BUDGET_LINE_ITEMS_TBODY
// 				<tr>
// 	 				<td colspan="7" style="border-bottom: 1px solid black;"></td>
// 	 			</tr>
// GC_BUDGET_LINE_ITEMS_TBODY;

// $stylefix1 = <<<GC_BUDGET_LINE_ITEMS_TBODY
// 				<tr>
// 	 				<td colspan="7" style="border-top: 1px solid black;"></td>
// 	 			</tr>
// GC_BUDGET_LINE_ITEMS_TBODY;

}else{
	$stylefix = $gcBudgetLineSiteworkstot = $gcBudgetLinebuildingcosttot  = $gcBudgetLinesoftcosttot = $stylefix1 = '';
}

	$gcBudgetLineItemsTbody = $gcBudgetLineGeneralcond.$stylefix.$gcBudgetLineGeneraltot.$stylefix1.$gcBudgetLineSiteworks.$stylefix.$gcBudgetLineSiteworkstot.$stylefix1.$gcBudgetLinebuildingcost.$stylefix.$gcBudgetLinebuildingcosttot.$stylefix1.$gcBudgetLinesoftcost.$stylefix.$gcBudgetLinesoftcosttot.$stylefix1;

	$totalPrimeSchedule = $OverallOrg;

	$OverallOrg = Format::formatCurrency($OverallOrg);
	$overall_sav = Format::formatCurrency($overall_sav);
	$overall_var  = Format::formatCurrency($overall_var);
	$overall_csfunit = Format::formatCurrency($overall_csfunit);
	$overall_cpsfunit = Format::formatCurrency($overall_cpsfunit);
	$overall_Original_PSCV = Format::formatCurrency($overall_Original_PSCV);
	$overall_OCO_Val = Format::formatCurrency($overall_OCO_Val);
	$overall_Reallocation_Val = Format::formatCurrency($overall_Reallocation_Val);
	$overall_Sco_amount = Format::formatCurrency($overall_Sco_amount);

	$ocoOverallTd = '';
	if ($OCODisplay == 2) {
		$ocoOverallTd = '<td align="right">'.$overall_OCO_Val.'</td>';
	}

	$projectSumarry = <<<GC_BUDGET_LINE_ITEMS_TBODY
			<tr style="font-weight: bold; text-transform: uppercase;"><td colspan="$nospan" class="table-headerinner" ><b>Project Summary</b></td>
			</tr>
				$gcBudgetLineGeneraltot	
				$gcBudgetLineSiteworkstot
				$gcBudgetLinebuildingcosttot
				$gcBudgetLinesoftcosttot
			<tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
				<td colspan="2" align="right">Total Project Costs</td>
				<td align="right">$overall_Original_PSCV</td>
				<td align="right">$overall_Reallocation_Val</td>
				$ocoOverallTd
				<td align="right">$OverallOrg</td>
				<td align="right">$overall_Sco_amount</td>
				<td align="right">$overall_sav</td>
				<td align="right">$overall_var</td>
				<td align="right">$overall_cpsfunit</td>
				<td align="right">$overall_csfunit</td>			
			</tr>
			$stylefix1
GC_BUDGET_LINE_ITEMS_TBODY;

$gcBudgetLineItemsTbody .= $projectSumarry;
		

	
	$primeContractScheduledValueTotal = Format::formatCurrency($primeContractScheduledValueTotal);

if ($OCODisplay == 2) {
$tablesub = <<<Table_subtotal
		</tbody>
	</table>
Table_subtotal;
$gcBudgetLineItemsTbody .= $tablesub;
$gcBudgetLineItemsTbody .= buyoutTotalTable($total_buyout_forcast,$total_forcast);
}

if ($OCODisplay == 1) {
	$gcBudgetLineItemsTbody .= renderCORforBudgetListVector($database, $project_id,$totalPrimeSchedule,$fillerColumns,$inotes);
	$gcBudgetLineItemsTbody .= buyoutTotalTable($total_buyout_forcast,$total_forcast);
}


	return $gcBudgetLineItemsTbody;
}

function buyoutTotalTable($total_buyout_forcast,$total_forcast){

	$total_buyout_forcast = Format::formatCurrency($total_buyout_forcast);
	$total_forcast = Format::formatCurrency($total_forcast);

	$htmlContent = <<<END_HTML_CONTENT
		<br>
		<table>
			<tr>
				<td>
					<table border="0" style="border-collapse:collapse;border: 1px solid #adadad;" cellpadding="2" cellspacing="0" width="100%">
						<thead>
							<tr style="vertical-align: center;background: #0e6db6;color: #ffffff;">
								<td colspan="2">Forecast Totals:</td>
							</tr>
						</thead>
						<tbody>
							<tr style="border-top: 1px solid #adadad;">
								<td style="font-weight: bold;border-right: 1px solid #adadad;">Forecast</td>
								<td align="right">$total_forcast</td>
							</tr>
							<tr style="border-top: 1px solid #adadad;">
								<td style="font-weight: bold;border-right: 1px solid #adadad;">Buyout Forecast</td>
								<td align="right">$total_buyout_forcast</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td style="vertical-align: bottom;padding-left: 10px;">
					* Buyout forecast is not included in subtotal for rows with a subcontract in place.
				</td>
			</tr>
		</table>
END_HTML_CONTENT;

return $htmlContent;
}

function renderCORforBudgetListVector($database, $project_id,$primeContractScheduledValueTotal,$fillerColumns,$inotes)
{
	$loadChangeOrdersByProjectIdOptions = new Input();
	$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
	$loadChangeOrdersByProjectIdOptions->change_order_type_id = 2;
	$loadChangeOrdersByProjectIdOptions->change_order_status_id = 2; //For approved 
	$totalCORs = ChangeOrder::loadChangeOrdersCountByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

	$arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

	$nospan=2;
	$totalspan = 10;

	$coTableTbody = '
			<tr class="table-headerinner" style="vertical-align: center;">
				<th>Custom</th>
				<th>COR</th>
				<th colspan="3">Title</th>
				<th>Amount</th>
				<th>Created Date</th>
				<th>Days</th>
				<th colspan='.$nospan.'>Reason</th>
			</tr>
  		';
	$sum_co_total =0;

	if ($totalCORs == 0) {
		$coTableTbody .= '<tr><td colspan="'.$totalspan.'">No Data Available</td></tr>';
		return $coTableTbody;
	}

	foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
		/* @var $changeOrder ChangeOrder */
		$changeOrderStatus = $changeOrder->getChangeOrderStatus();
		/* @var $changeOrderStatus ChangeOrderStatus */

		$changeOrderPriority = $changeOrder->getChangeOrderPriority();
		/* @var $changeOrderPriority ChangeOrderPriority */

		$coCostCode = $changeOrder->getCoCostCode();
		/* @var $coCostCode CostCode */

		$co_delay_days = $changeOrder->co_delay_days;
		
		$co_created = $changeOrder->created;
		$co_closed_date = $changeOrder->co_closed_date;
		$co_total =$changeOrder->co_total;
		$co_type_prefix= $changeOrder->co_type_prefix;
		$co_custom_sequence_number= $changeOrder->co_custom_sequence_number;

		// HTML Entity Escaped Data
		$changeOrder->htmlEntityEscapeProperties();
		$escaped_co_title = $changeOrder->escaped_co_title;

		if ($changeOrderPriority) {
			$change_order_priority = $changeOrderPriority->change_order_priority;
		} else {
			$change_order_priority = '&nbsp;';
		}

		if ($coCostCode) {
			// Extra: Change Order Cost Code - Cost Code Division

			/* @var $coCostCodeDivision CostCodeDivision */


			$coCostCode->htmlEntityEscapeProperties();

		}

		// Convert co_created to a Unix timestamp
		$openDateUnixTimestamp = strtotime($co_created);
		$oneDayInSeconds = 86400;
		$daysOpen = '';

		$formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

		// change_order_statuses:
		$change_order_status = $changeOrderStatus->change_order_status;
		// if Change Order status is "closed"
		if (!$co_closed_date) {
			$co_closed_date = '0000-00-00';
		}
		if (($change_order_status == 'Approved') && ($co_closed_date <> '0000-00-00')) {
			$closedDateUnixTimestamp = strtotime($co_closed_date);
			if ($co_closed_date <> '0000-00-00') {

				$daysOpenNumerator = $closedDateUnixTimestamp - $openDateUnixTimestamp;
				$daysOpenDenominator = $oneDayInSeconds;
				$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
				$daysOpen = ceil($daysOpen);

			}
		} else {

			$nowDate = date('Y-m-d');
			$nowDateUnixTimestamp = strtotime($nowDate);
			$daysOpenNumerator = $nowDateUnixTimestamp - $openDateUnixTimestamp;
			$daysOpenDenominator = $oneDayInSeconds;
			$daysOpen = $daysOpenNumerator / $daysOpenDenominator;
			$daysOpen = ceil($daysOpen);

		}

		// There was an instance of $daysOpen showing as "-0"
		if (($daysOpen == 0) || ($daysOpen == '-0')) {
			$daysOpen = 0;
		}
		$sum_co_total=$sum_co_total+$co_total;

		$co_total = Format::formatCurrency($co_total);

		$rspan =4;

		$coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY

		<tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="">
			<td nowrap align="left">$co_custom_sequence_number</td>
			<td nowrap >$co_type_prefix</td>
			<td colspan="3">$escaped_co_title</td>
			<td class="autosum-cosv" align="right">$co_total</td>
			<td align="right">$formattedCoCreatedDate</td>
			<td align="right">$co_delay_days</td>
			<td colspan="2">$change_order_priority</td>
		</tr>
END_CHANGE_ORDER_TABLE_TBODY;

	}
	$budget_total =$primeContractScheduledValueTotal+$sum_co_total;
	$sum_co_total =Format::formatCurrency($sum_co_total);
	$budget_total =Format::formatCurrency($budget_total);

	$coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
	<tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="bottom-content" style="border-top: 1px solid black;">
		<td colspan='5' align='right'><b>Approved Change Orders Total</b> </td>
		<td  align='right'><b>$sum_co_total</b> </td>
		<td colspan='$rspan'> </td>
	</tr>
	<tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="bottom-content"  style="border-top: 1px solid black;background: #d9d9d9;font-weight:bold;">
		<td colspan='5' align='right'><b>Revised budget Total</b></td>
		<td align='right' ><b>$budget_total</b></td>
		<td colspan='$rspan'> </td>
	</tr>
	</tbody>
	</table>
END_CHANGE_ORDER_TABLE_TBODY;

	

	return $coTableTbody;

}

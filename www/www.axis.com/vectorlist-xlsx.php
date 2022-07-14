<?php
	require_once('lib/common/init.php');
	require_once('lib/common/BidList.php');
	require_once('lib/common/CostCode.php');
	require_once('lib/common/CostCodeDivision.php');
	require_once('lib/common/GcBudgetLineItem.php');
	require_once('lib/common/ChangeOrder.php');
	require_once('lib/common/ChangeOrderType.php');
	require_once('lib/common/ChangeOrderStatus.php');
	require_once('lib/common/ChangeOrderPriority.php');
	require_once('lib/common/DrawItems.php');





	$init['application'] = 'www.axis.com';
	$init['timer'] = false;
	$init['timer_start'] = false;

	$groupdivision_completed = BidList::findBidlistByCompanyProjectId($database, $project_id, $user_company_id);
	if($groupdivision_completed && ($checkboxcond  ==2 || $checkboxcond  ==3)){
		exit('groupdivnotmap');
	}

	/*Initialize PHPExcel Class*/
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica')->setSize(12);
	$objPHPExcel->getProperties()->setCreator("Creator");
	$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
	$objPHPExcel->getProperties()->setTitle("Office 2007 Xlsx Test Document");
	$objPHPExcel->getProperties()->setSubject("Office 2007 Xlsx Test Document");
	$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 Xlsx, generated using PHP classes.");

	$objPHPExcel->setActiveSheetIndex(0);
	$index=1;
	$signature=$fulcrum;
	if (file_exists($signature)) {
	    $objDrawing = new PHPExcel_Worksheet_Drawing();
	    $objDrawing->setName('Customer Signature');
	    $objDrawing->setDescription('Customer Signature');
	    //Path to signature .jpg file
	    $objDrawing->setPath($signature);
	    $objDrawing->setCoordinates('A'.$index);             //set image to cell
	    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save
	} else {
	    $objPHPExcel->getActiveSheet()->setCellValue('A'.$index, "Image not found" );
	}
	/*cell text alignment*/
	$styleRight = array(
	   'alignment' => array(
	    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	    )
	   ); 
	$styleLeft = array(
	   'alignment' => array(
	    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	    )
	   ); 
	$BStyle = array(
	  	'borders' => array(
		    'outline' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		)
	);
	$verticalCenter = array(
	    'alignment' => array(
	      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	    )
	);

	// Cost per SF/Unit
	$project = Project::findProjectByIdExtended($database, $project_id);		
	$OCODisplay = $project->COR_type;
	$alias_type = $project->alias_type;
	/* @var $project Project */
	$unit_count = $project->unit_count;
	$net_rentable_square_footage = $project->net_rentable_square_footage;

	if ($OCODisplay == 1 && $inotes == 'false') {
	  $lastCol = 'J';
	}
	if ($OCODisplay == 1 && $inotes == 'true') {
	  $lastCol = 'K';
	} 
	if ($OCODisplay == 2 && $inotes == 'false') {
	  $lastCol = 'K';
	}
	if ($OCODisplay == 2 && $inotes == 'true') {
	  $lastCol = 'L';
	}	

	$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleRight);
	/*cell merge*/
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':'.$lastCol.($index));
	$height = $height +10;
	$points = PHPExcel_Shared_Drawing::pixelsToPoints($height);
	$objPHPExcel->getActiveSheet()->getRowDimension($index)->setRowHeight($points);
	/*cell font style*/
	$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getFont()->setSize(21);
	/*cell padding*/
	$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
	/*cell content*/
	$objPHPExcel->getActiveSheet()->setCellValue('A'.($index),$type_mention);

	$index++;
	//Fetch the Data's
	$alphas = range('A', 'Z');
	$alphaCharIn = 0;

	$numrow = 2;
  	$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight($numrow== 1 ? $numrow * 12.75 + 2.25 : $numrow * 14.75 + 5);
  	// Title Cost code
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;
	// Title Cost code Description
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code Description"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;
	// Title Original PSCV
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Original PSCV"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;
	// Title Reallocation
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Reallocation"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;

	if ($OCODisplay == 2) {
		// Title OCO
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"OCO"); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
		$alphaCharIn++;
	}
	// Title Current Budget
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Current Budget"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;
	// Title SCO
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SCO"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;
	// Title Current Subcontract Value
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Current Subcontract Value"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;
	// Title Variance
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Variance"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;
	// Title Cost Per Sq. Ft.
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Per Sq. Ft. \r (".$net_rentable_square_footage.")"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$alphaCharIn++;
	// Title Cost Per Unit
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Per Unit \r (".$unit_count.")"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);

	if($inotes=='true')
	{
	$alphaCharIn++;
	// Notes 
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Notes"); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	}

	$lastAlphaIn = $alphaCharIn;
	$alphaCharIn=0;
	
	/*cell font color*/
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setSize(11)->setBold(true);
	$index++;

	$cost_code_division_id_filter = null;
	$order_by_attribute = false;
	$order_by_direction = false;
	$scheduledValuesOnly = false;
	$needsBuyOutOnly = false;

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
	$arrAllSubcontractorBidStatuses = SubcontractorBidStatus::loadAllSubcontractorBidStatuses($database);

	$main_company = Project::ProjectsMainCompany($database,$project_id);

	$arrSubcontractorBidStatusCountsByProjectId = SubcontractorBid::loadSubcontractorBidStatusCountsByProjectId($database, $main_company, $project_id, $cost_code_division_id_filter);

	$primeContractScheduledValueTotal = 0.00;
	$forecastedExpensesTotal = 0.00;
	$buyoutforecastedExpensesTotal = 0.00;
	$buyoutforecastedTotal = 0.00;
	$buyout_forecasted_raw = '';
	$subcontractActualValueTotal = 0.00;
	$varianceTotal = 0.00;
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
	$ioput = 1;
	$ioputIn = 1;
	$countArray = count($arrGcBudgetLineItemsByProjectId);
	$costCodePSFValueTotal = $costCodePerSFValueTotal =	$gcBudgetLineSiteworksVar = $gcBudgetLinebuildingcostVar = $gcBudgetLinesoftcostVar =$gcBudgetLineGeneralcondVar = 	$gcBudgetLineSiteworksOrg = $gcBudgetLinebuildingcostOrg = $gcBudgetLinesoftcostOrg =$gcBudgetLineGeneralcondOrg = $csfunit_GeneralcondVar = $csfunit_SiteworksVar = $csfunit_buildingcostVar  = $csfunit_softcostVar =  $sav_GeneralcondVar = $sav_SiteworksVar = $sav_buildingcostVar  = $sav_softcostVar = $OverallOrg  = $overall_sav = $overall_var = $overall_csfunit = $overall_cpsfunit = $cpsfunit_GeneralcondVar = $cpsfunit_SiteworksVar = $cpsfunit_buildingcostVar  = $cpsfunit_softcostVar =0;
	$gcBudget_OriginalPSCV_GeneralcondVar = $gcBudget_OCO_GeneralcondVar = $gcBudget_reallocation_GeneralcondVar = $gcBudget_OriginalPSCV_SiteworksVar = $gcBudget_OCO_SiteworksVar = $gcBudget_reallocation_SiteworksVar = $gcBudget_OriginalPSCV_buildingcostVar = $gcBudget_OCO_buildingcostVar = $gcBudget_reallocation_buildingcostVar = $gcBudget_OriginalPSCV_softcostVar = $gcBudget_OCO_softcostVar = $gcBudget_reallocation_softcostVar = $overall_Original_PSCV = $overall_OCO_Val = $overall_Reallocation_Val = $overall_Sco_amount = $gcBudget_SCO_GeneralcondVar = $gcBudget_SCO_SiteworksVar = $gcBudget_SCO_buildingcostVar = $gcBudget_SCO_softcostVar = 0;

	$gcBudgetLineGeneralcond = $gcBudgetLineSiteworks = $gcBudgetLinebuildingcost = $gcBudgetLinesoftcost = array();

	foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
		/* @var $gcBudgetLineItem GcBudgetLineItem */
		$gcBudgetsubLineItems_arr = array();
		$cc_per_sf_unit_value = 0;
		$cc_per_sf_ft_value = 0;
		if ($scheduledValuesOnly) {
			$prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
			if (!$prime_contract_scheduled_value || $prime_contract_scheduled_value == null || $prime_contract_scheduled_value == 0) {
				continue;
			}
		}
		$gcBudgetsubLineItems_arr['notes']=$gcBudgetLineItem->notes;

		$costCode = $gcBudgetLineItem->getCostCode();
		/* @var $costCode CostCode */

		$costCode->htmlEntityEscapeProperties();

		$costCodeDivision = $costCode->getCostCodeDivision();
		/* @var $costCodeDivision CostCodeDivision */

		$costCodeDivision->htmlEntityEscapeProperties();
		$cost_code_division_id = $costCodeDivision->cost_code_division_id;
		$notes = $gcBudgetLineItem->notes;
		
		if (isset($cost_code_division_id_filter)) {
			if ($cost_code_division_id_filter != $cost_code_division_id) {
				continue;
			}
		}

		$contactCompany = $gcBudgetLineItem->getContactCompany();
		/* @var $contactCompany ContactCompany */

		$costCodeDivisionAlias = $gcBudgetLineItem->getCostCodeDivisionAlias();
		/* @var $costCodeDivisionAlias CostCodeDivisionAlias */

		// $costCodeAlias = $gcBudgetLineItem->getCostCodeAlias();
		/* @var $costCodeAlias CostCodeAlias */

		$subcontractorBid = $gcBudgetLineItem->getSubcontractorBid();
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

		if (isset($subcontractorBid) && ($subcontractorBid instanceof SubcontractorBid)) {
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractor_bid_id = $subcontractorBid->subcontractor_bid_id;
		} else {
			$subcontractor_bid_id = '';
		}

		$cost_code_id = $costCode->cost_code_id;
		

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

		unset($ocoVal['totalCount']);
		unset($ocoVal['totalBreakdownAmount']);
		$ocoArray = array();
		foreach ($ocoVal as $key => $value) {
			$coId = $value['id'];
			$coName = $value['co_title'];
			$coCustom = $value['co_custom_sequence_number'];
			$coValue = $value['cocb_cost'];
			$coValueFormatted = $coValue ? Format::formatCurrency($coValue) : '$0.00';
			$ocoArray[$coId]['oco_custom'] = $coCustom;
			$ocoArray[$coId]['oco_name'] = $coName;
			$ocoArray[$coId]['oco_cost'] = $coValueFormatted;
		}

		$gcBudgetsubLineItems_arr['oco_list'] = $ocoArray;

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
		$forecastedExpensesClass = '';
		$forecastedExpensesTotal += $forecasted_expenses;
		
		if (isset($forecasted_expenses) && !empty($forecasted_expenses)) {			
			if ($forecasted_expenses < 0) {
				$forecastedExpensesClass = ' red';
			}
			$forecasted_expenses = Format::formatCurrency($forecasted_expenses);
		} else {
			$forecasted_expenses = '$0.00';
		}
		// Buyout forecasted 
		$buyout_forecasted__raw = $buyout_forecasted = $gcBudgetLineItem->buyout_forecasted_expenses;
		$buyoutExpensesClass = '';
		$buyoutforecastedExpensesTotal += $buyout_forecasted__raw;
		
		if (isset($buyout_forecasted) && !empty($buyout_forecasted)) {
			$buyoutforecastedTotal += $buyout_forecasted;
			if ($buyout_forecasted < 0) {
				$buyoutExpensesClass = ' red';
			}
			$buyout_forecasted = Format::formatCurrency($buyout_forecasted);
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
		
		$subcontract_actual_value_raw = $subcontract_actual_value = null;
		$vendorList = '';
		$target_date = '';
		$arrSubcontractActualValueHtml = array();
		$arrCCPSFValueHtml = array();
		$arrCPSFValueHtml = array();
		$arrSubcontractVendorHtml = array();
		$arrPurchasingTargetDateHtmlInputs = array();
		$total_Sco_amount = 0;
		$isSubcontractValue = 'false';

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

			// Subcontract Actual Value list
			$subcontract_actual_value_raw += $tmp_subcontract_actual_value;
			$subcontract_actual_value += $tmp_subcontract_actual_value;

			if($tmp_subcontract_actual_value > 0){
				$isSubcontractValue = 'true';
			}

			//To add  SCO approved amt

			//To check the SCO Exists for the subcontarctor
			$resdataarr =SubcontractChangeOrderDataAjax($database, $costCode->cost_code_id,$project_id,"all",$gc_budget_line_item_id,$tmp_subcontract_id);
			$resdata = $resdataarr['data'];


			$formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
			if ($subcontractCount >= 1) {
				$tmpSubcontractActualValueHtml = $formattedSubcontractActualValue;
				$arrSubcontractActualValueHtml[] = $tmpSubcontractActualValueHtml;
				if(!empty($resdata)){
					foreach($resdata as $eachresdata){
						if(empty($sav_raw)){ $sav_raw = 0; }
						$sav_raw += $eachresdata['estimated_amount_raw'];
						$subcontract_actual_value += $eachresdata['estimated_amount_raw'];
						$tmp_subcontract_actual_value += $eachresdata['estimated_amount_raw'];
						$app_amount = $eachresdata['estimated_amount'];
						$total_Sco_amount += $eachresdata['estimated_amount_raw'];
						if($subcontract_actual_value > 0){
							$isSubcontractValue = 'true';
						}
				
						$arrSubcontractActualValueHtml[] = $app_amount;
					}
				}
			} 
			

			$CCPSFValue = $tmp_subcontract_actual_value/$unit_count;
			$cc_per_sf_unit_value += $CCPSFValue;
			$formattedCCPSFValue = Format::formatCurrency($CCPSFValue);

			if ($subcontractCount >= 1) {
				$tmpCCPSFValueHtml = $formattedCCPSFValue;
				$arrCCPSFValueHtml[] = '';
				if(!empty($resdata)){
					foreach($resdata as $eachresdata){
						$arrCCPSFValueHtml[] = '';
					}
				}
			} 			


			$CPSFValue = $tmp_subcontract_actual_value/$net_rentable_square_footage;
			$cc_per_sf_ft_value += $CPSFValue;
			$formattedCPSFValue = Format::formatCurrency($CPSFValue);
			if ($subcontractCount >= 1) {
				$tmpCPSFValueHtml = $formattedCPSFValue;
				$arrCPSFValueHtml[] = '';
				if(!empty($resdata)){
					foreach($resdata as $eachresdata){
						$arrCPSFValueHtml[] = '';
					}
				}
			} 

			// Vendor list
			$vendor = $subcontract->getVendor();
			if ($vendor) {

				$vendorContactCompany = $vendor->getVendorContactCompany();
				/* @var $vendorContactCompany ContactCompany */

				$vendorContactCompany->htmlEntityEscapeProperties();

				if ($subcontractCount >= 1) {
					
					$tmpSubcontractVendorHtmlInputs = $vendorContactCompany->escaped_contact_company_name;
					

				} 
				$arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;
				if(!empty($resdata)){
					foreach($resdata as $eachresdata){
						$sequencenumber = $eachresdata['sequence_number'];
						$SCOtitle = $eachresdata['title'];

					
						$arrSubcontractVendorHtml[] = $sequencenumber ." | ".$SCOtitle;
					}			
					
				}

			}

			// @todo...this parts
			// Foreign key objects
			
		}

		if($includegrprowval == 'true' && $forecasted_expenses != '$0.00')
		{
		$arrSubcontractVendorHtml[] = 'Forecast';
		$arrSubcontractActualValueHtml[] = $forecasted_expenses;
		}else if($includegrprowval == 'false'){
		$arrSubcontractVendorHtml[] = 'Forecast';
		$arrSubcontractActualValueHtml[] = $forecasted_expenses;
		}

		if($includegrprowval == 'true' && $buyout_forecasted != '$0.00')
		{
		$arrSubcontractVendorHtml[] = 'Buyout Forecast';
		$arrSubcontractActualValueHtml[] = $buyout_forecasted;
		}else if ($includegrprowval == 'false') {
		$arrSubcontractVendorHtml[] = 'Buyout Forecast';
		$arrSubcontractActualValueHtml[] = $buyout_forecasted;
		}
		

		
		if ($needsBuyOutOnly) {
			if ($subcontract_actual_value) {
				continue;
			}
		}

		// subcontract_actual_value
		$sav_raw = $subcontract_actual_value;
		if (isset($subcontract_actual_value) && !empty($subcontract_actual_value)) {
			$subcontractActualValueTotal += $subcontract_actual_value;
			$subcontract_actual_value = Format::formatCurrency($subcontract_actual_value);
		} else {
			$subcontract_actual_value = '$0.00';
		}

		// Cost per sf/unit actual values
		$csfunit_raw = $cc_per_sf_unit_value;
		if (isset($cc_per_sf_unit_value) && !empty($cc_per_sf_unit_value)) {
			$costCodePSFValueTotal += $cc_per_sf_unit_value;
			$cc_per_sf_unit_value_html = Format::formatCurrency($cc_per_sf_unit_value);
		} else {
			$cc_per_sf_unit_value_html = '$0.00';
		}

		$cpsfunit_raw = $cc_per_sf_ft_value;
		if (isset($cc_per_sf_ft_value) && !empty($cc_per_sf_ft_value)) {
			$costCodePerSFValueTotal += $cc_per_sf_ft_value;
			$cc_per_sf_ft_value_html = Format::formatCurrency($cc_per_sf_ft_value);
		} else {
			$cc_per_sf_ft_value_html = '$0.00';
		}

		// variance
		$pcsv = Data::parseFloat($prime_contract_scheduled_value_raw);
		$forecast = Data::parseFloat($forecasted_expenses_raw);
		$buyforecast = Data::parseFloat($buyout_forecasted__raw);
		$sav = Data::parseFloat($subcontract_actual_value_raw);
		$sav_raw = Data::parseFloat($sav_raw);

		
		if ($subcontractCount >= 1) {
			$v_raw = $gcBudgetLineItemVariance = $pcsv - ($forecast + $sav_raw);
		}else{
			$v_raw = $gcBudgetLineItemVariance = $pcsv - ($forecast + $buyforecast + $sav_raw);
		}
		
		$varianceTotal += $gcBudgetLineItemVariance;
		
		$gcBudgetLineItemVarianceNum = $gcBudgetLineItemVariance;
		$gcBudgetLineItemVariance = Format::formatCurrency($gcBudgetLineItemVariance);

		$isRowVisible = 'true';
		if($isSubcontractValue == 'false' && $originalPSCV == 0 && $forecasted_expenses_raw == 0 && $buyout_forecasted_raw == 0){
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

	$totalSCOAmountFormatted = $total_Sco_amount ? Format::formatCurrency($total_Sco_amount) : '$0.00';

	$costCodeData = ' '.$costCodeDivision->escaped_division_number.$costCodeDivider.$costCode->escaped_cost_code;
	$getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_division_id);
    if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
      $costCodeData = $costCodeData.' '.$getCostCodeAlias;
    }	

	$gcBudgetsubLineItems_arr['isRowVisible'] = $isRowVisible;
	$gcBudgetsubLineItems_arr['cost_code_division'] = $costCodeDivision->escaped_division_number;
	$gcBudgetsubLineItems_arr['cost_code'] = $costCodeData;
	$gcBudgetsubLineItems_arr['cost_code_description'] = $costCode->cost_code_description;
	$gcBudgetsubLineItems_arr['original_Pscv_Formatted'] = $originalPSCVFormatted;
	$gcBudgetsubLineItems_arr['oco_val_Formatted'] = $ocoValFormatted;
	$gcBudgetsubLineItems_arr['reallocation_Formatted'] = $reallocationValFormatted;
	$gcBudgetsubLineItems_arr['prime_contract_scheduled_value'] = $prime_contract_scheduled_value;
	$gcBudgetsubLineItems_arr['totalSCOAmountFormatted'] = $totalSCOAmountFormatted;
	

	$forecastcpsfvalue = $forecasted_expenses_raw  / $net_rentable_square_footage;
	$forecastccpsfvalue = $forecasted_expenses_raw / $unit_count;

	$format_forecastcpsfvalue = Format::formatCurrency($forecastcpsfvalue);
	$format_forecastccpsfvalue = Format::formatCurrency($forecastccpsfvalue);
	
	$arrCPSFValueHtml[] = $format_forecastcpsfvalue;
	$arrCCPSFValueHtml[]  = $format_forecastccpsfvalue;

	if(($includegrprowval == 'true' && $isRowVisible == 'true') || ($includegrprowval == 'false')){
		if ($subcontractCount >= 1) {
			$sav_raw = $forecasted_expenses_raw + $sav_raw;
		}else
		{
			$sav_raw = $forecasted_expenses_raw + $buyout_forecasted__raw  + $sav_raw;
		}
	}

	$subcontract_actual_value = Format::formatCurrency($sav_raw);

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

		
	if(!empty($arrSubcontractVendorHtml) ){
		$gcBudgetsubLineItems_arr['subcontract_vendor'] = $arrSubcontractVendorHtml;
		$gcBudgetsubLineItems_arr['subcontract_actualvalue'] = $arrSubcontractActualValueHtml;
		$gcBudgetsubLineItems_arr['subcontract_CPSFValue'] = $arrCPSFValueHtml;
		$gcBudgetsubLineItems_arr['subcontract_CCPSFValue'] = $arrCCPSFValueHtml;
		
	}

	$gcBudgetsubLineItems_arr['total_subcontract_actual_value'] = $subcontract_actual_value;
	$gcBudgetsubLineItems_arr['total_gcBudgetLineItemVariance'] = $gcBudgetLineItemVariance;
	$gcBudgetsubLineItems_arr['total_cc_per_sf_ft_value_html'] = $cpsfunit_tot_format;
	$gcBudgetsubLineItems_arr['total_cc_per_sf_unit_value_html'] = $csfunit_tot_format;

	$isSubtotalRowVisible = 'true';
	if($sub_tot_ori_pscv == 0 && $sub_tot_crt_subcon == 0){
		$isSubtotalRowVisible = 'false';
	}
	
	if($costCodeDivisionCount == 0){
		$subtotalArray = array();
		$subtotalArray['isRowVisible'] = $isSubtotalRowVisible;
		$subtotalArray['sub_tot_ori_pscv'] = Format::formatCurrency($sub_tot_ori_pscv);
		$subtotalArray['sub_tot_reallocation'] = Format::formatCurrency($sub_tot_reallocation);
		$subtotalArray['sub_tot_oco'] = Format::formatCurrency($sub_tot_oco);
		$subtotalArray['sub_tot_pscv'] = Format::formatCurrency($sub_tot_pscv);
		$subtotalArray['sub_tot_sco'] = Format::formatCurrency($sub_tot_sco);
		$subtotalArray['sub_tot_crt_subcon'] = Format::formatCurrency($sub_tot_crt_subcon);
		$subtotalArray['sub_tot_variance'] = Format::formatCurrency($sub_tot_variance);
		$subtotalArray['sub_tot_cost_per_sq_ft'] = Format::formatCurrency($sub_tot_cost_per_sq_ft);
		$subtotalArray['sub_tot_cost_per_unit'] = Format::formatCurrency($sub_tot_cost_per_unit);
		$gcBudgetsubLineItems_arr['subtotal_array'] = $subtotalArray;
		$subtotalArray;
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

		$OverallOrg += $prime_contract_scheduled_value_raw;
		$overall_sav += $sav_raw;
		$overall_var += $gcBudgetLineItemVarianceNum;
		$overall_csfunit += $csfunit_raw;
		$overall_cpsfunit += $cpsfunit_raw; 
		$overall_Original_PSCV += $originalPSCV;
		$overall_OCO_Val += $oco_value;
		$overall_Reallocation_Val = round(($overall_Reallocation_Val+$reallocation_Val),2);
		$overall_Sco_amount += $total_Sco_amount;
		if($checkboxcond == 2 || $checkboxcond == 3 ){
			if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='1'){
				if($checkboxcond  ==3){
					$gcBudgetsubLineItems_arr = array();
				}

				$gcBudgetLineGeneralcond[] = $gcBudgetsubLineItems_arr; 
				$gcBudgetLineGeneralcondVar += $gcBudgetLineItemVarianceNum;
				$gcBudgetLineGeneralcondOrg += $prime_contract_scheduled_value_raw;
				$csfunit_GeneralcondVar += $csfunit_raw;
				$cpsfunit_GeneralcondVar += $cpsfunit_raw;
				$sav_GeneralcondVar += $sav_raw;
				$gcBudget_OriginalPSCV_GeneralcondVar += $originalPSCV;
				$gcBudget_OCO_GeneralcondVar += $oco_value;
				$gcBudget_reallocation_GeneralcondVar = round(($gcBudget_reallocation_GeneralcondVar+$reallocation_Val),2);
				$gcBudget_SCO_GeneralcondVar += $total_Sco_amount;					
			}else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='2'){
				$gcBudgetLineSiteworks[] = $gcBudgetsubLineItems_arr;
				$gcBudgetLineSiteworksVar += $gcBudgetLineItemVarianceNum;
				$gcBudgetLineSiteworksOrg += $prime_contract_scheduled_value_raw;
				$csfunit_SiteworksVar += $csfunit_raw;
				$cpsfunit_SiteworksVar += $cpsfunit_raw;
				$sav_SiteworksVar += $sav_raw;
				$gcBudget_OriginalPSCV_SiteworksVar += $originalPSCV;
				$gcBudget_OCO_SiteworksVar += $oco_value;
				$gcBudget_reallocation_SiteworksVar = round(($gcBudget_reallocation_SiteworksVar+$reallocation_Val),2);
				$gcBudget_SCO_SiteworksVar += $total_Sco_amount;
			}else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='3'){
				$gcBudgetLinebuildingcost[] = $gcBudgetsubLineItems_arr;
				$gcBudgetLinebuildingcostVar += $gcBudgetLineItemVarianceNum;
				$gcBudgetLinebuildingcostOrg += $prime_contract_scheduled_value_raw;
				$csfunit_buildingcostVar += $csfunit_raw;
				$cpsfunit_buildingcostVar += $cpsfunit_raw;
				$sav_buildingcostVar += $sav_raw;
				$gcBudget_OriginalPSCV_buildingcostVar += $originalPSCV;
				$gcBudget_OCO_buildingcostVar += $oco_value;
				$gcBudget_reallocation_buildingcostVar = round(($gcBudget_reallocation_buildingcostVar+$reallocation_Val),2);
				$gcBudget_SCO_buildingcostVar += $total_Sco_amount;
			}else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='4'){

				$gcBudgetLinesoftcost[] = $gcBudgetsubLineItems_arr; 
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
			$gcBudgetLineGeneralcond[] = $gcBudgetsubLineItems_arr; 
			$gcBudgetLineGeneralcondVar += $gcBudgetLineItemVarianceNum;
			$gcBudgetLineGeneralcondOrg += $prime_contract_scheduled_value_raw;
			$csfunit_GeneralcondVar += $csfunit_raw;
			$cpsfunit_GeneralcondVar += $cpsfunit_raw;
			$sav_GeneralcondVar += $sav_raw;
			$gcBudget_OriginalPSCV_GeneralcondVar += $originalPSCV;
			$gcBudget_OCO_GeneralcondVar += $oco_value;
			$gcBudget_reallocation_GeneralcondVar = round(($gcBudget_reallocation_GeneralcondVar+$reallocation_Val),2);
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

	

if($checkboxcond  == 2 || $checkboxcond  == 3){

	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$lastCol.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"GENERAL CONDITIONS");
    
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
    /*cell font color*/
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true)->getColor()->setRGB('FFFF');
	$index++;
	$alphaCharIn=0;
}

if($checkboxcond != 3){
	foreach($gcBudgetLineGeneralcond as $eachlineitem){
		if(($includegrprowval == 'true' && $eachlineitem['isRowVisible'] == 'true') || $includegrprowval == 'false'){
			// GC Costcoderow Cost code
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			if ($costCodeAlias == 'false') {
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
			}else{
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->getAlignment()->setWrapText(true); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(10);
			}
			$alphaCharIn++;
			// GC Costcoderow Cost code Description
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code_description']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$alphaCharIn++;
			// GC Costcoderow Original PSCV
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['original_Pscv_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			// GC Costcoderow Reallocation
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['reallocation_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			if ($OCODisplay == 2) {
				// GC Costcoderow OCO
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,''); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}
			// GC Costcoderow Current Budget
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['prime_contract_scheduled_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if($inotes=='true')
			{
				$alphaCharIn =$alphaCharIn+5; //to make the notes colum display at the end
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['notes']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
				$alphaCharIn++;
			}
			$index++;
			
			if ($OCODisplay == 2) {
				$alphaCharIn = 0;
				foreach ($eachlineitem['oco_list'] as $value) {

					$alphaCharIn = 1;
					if ($value['oco_custom'] != '') {
						$objRichText = new PHPExcel_RichText();
						$objPayable = $objRichText->createTextRun($value['oco_custom']);
						$objPayable->getFont()->setName('Helvetica')->setSize(12)->getColor()->setRGB('2481c3');
						$objPayable = $objRichText->createTextRun(' | '.$value['oco_name']);
						$objPayable->getFont()->setName('Helvetica')->setSize(12)->getColor()->setRGB('000000');
						$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$objRichText);
					}else{
						$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$value['oco_name']); 				
					}
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

					$alphaCharIn = 4;
					$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$value['oco_cost']); 
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
					
					$alphaCharIn = 0;
					$index++;
			 	} 
			}	

			/* First Row - End */
			$subcontindex = 0;
			foreach($eachlineitem['subcontract_vendor'] as $eachvendor){
				$alphaCharIn = 1;
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachvendor); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				if (strpos($eachvendor, 'SCO-') !== false) {
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				}else if($eachvendor == 'Buyout Forecast'){
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(false);
				}else if($eachvendor != 'Forecast'){
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				}	

				$alphaCharIn = 5; 
				if ($OCODisplay == 2) { 
					$alphaCharIn = 6; 
				}	

				if (strpos($eachvendor, 'SCO-') !== false) {
					$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_actualvalue'][$subcontindex]); 
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				}

				$alphaCharIn = 6; 
				if ($OCODisplay == 2) { 
					$alphaCharIn = 7; 
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_actualvalue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

				$alphaCharIn = 8;
				if ($OCODisplay == 2) { 
					$alphaCharIn = 9; 
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_CPSFValue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_CCPSFValue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

				$alphaCharIn = 0;
				$subcontindex++;
				$index++;

			}

			
			/* Sub Total - Start */
			$alphaCharIn = 1;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'SUBTOTAL');
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['original_Pscv_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['reallocation_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if ($OCODisplay == 2) {
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['oco_val_Formatted']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['prime_contract_scheduled_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['totalSCOAmountFormatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_subcontract_actual_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_gcBudgetLineItemVariance']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_cc_per_sf_ft_value_html']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_cc_per_sf_unit_value_html']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			if($inotes=='true')
			{
			$alphaCharIn++;

			}
			$lastAlphaIn = $alphaCharIn;
			$alphaCharIn= 0;
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
			$index++;
			/* Sub Total - End */
		}
		if(($includegrprowval == 'true' && $eachlineitem['subtotal_array']['isRowVisible'] == 'true') || $includegrprowval == 'false'){
		if(isset($eachlineitem['subtotal_array']) && $subtotal == "true"){

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code_division']);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'SUBTOTAL');
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_ori_pscv']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_reallocation']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if ($OCODisplay == 2) {
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_oco']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_pscv']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_sco']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_crt_subcon']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_variance']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_cost_per_sq_ft']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_cost_per_unit']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
			if($inotes=='true'){
				$alphaCharIn++;
			}
			$lastAlphaIn = $alphaCharIn;
			$alphaCharIn= 0;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('9f9e9e');
			$index++;
		}	
		}		
		$alphaCharIn= 0;
	}
}

if($checkboxcond == 2 || $checkboxcond == 3){
	$alphaCharIn = 0;

	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL GENERAL CONDITIONS'); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
	$alphaCharIn = 2;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OriginalPSCV_GeneralcondVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_reallocation_GeneralcondVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	if ($OCODisplay == 2) {
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OCO_GeneralcondVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
	}

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLineGeneralcondOrg); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_SCO_GeneralcondVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sav_GeneralcondVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;
	
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLineGeneralcondVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cpsfunit_GeneralcondVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$csfunit_GeneralcondVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
	if($inotes=='true')
	{
		$alphaCharIn++;
			
	}
	$lastAlphaIn = $alphaCharIn;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
	$alphaCharIn++;

	$index++;
	$alphaCharIn = 0;
	
}

if($checkboxcond  == 2 || $checkboxcond == 3){
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$lastCol.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SITEWORK COSTS");
    
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
    /*cell font color*/
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true)->getColor()->setRGB('FFFF');

	$index++;
	$alphaCharIn=0;

	foreach($gcBudgetLineSiteworks as $eachlineitem){
		if(($includegrprowval == 'true' && $eachlineitem['isRowVisible'] == 'true') || $includegrprowval == 'false'){
			// SWC Costcoderow Cost code
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			if ($costCodeAlias == 'false') {
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
			}else{
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->getAlignment()->setWrapText(true); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(10);
			}
			$alphaCharIn++;
			// SWC Costcoderow Cost code Description
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code_description']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$alphaCharIn++;
			// SWC Costcoderow Original PSCV
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['original_Pscv_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			// SWC Costcoderow Reallocation
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['reallocation_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			if ($OCODisplay == 2) {
				// SWC Costcoderow OCO
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['oco_val_Formatted']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}
			// SWC Costcoderow Current Budget
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['prime_contract_scheduled_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if($inotes=='true')
			{
				$alphaCharIn =$alphaCharIn+5; //to make the notes colum display at the end
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['notes']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;
			}
			$index++;
			/* First Row - End */
			$subcontindex = 0;
			foreach($eachlineitem['subcontract_vendor'] as $eachvendor){
				$alphaCharIn = 1;
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachvendor); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				if (strpos($eachvendor, 'SCO-') !== false) {
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				}else if($eachvendor == 'Buyout Forecast'){
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(false);
				}else if($eachvendor != 'Forecast'){
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				}

				$alphaCharIn = 5; 
				if ($OCODisplay == 2) { 
					$alphaCharIn = 6; 
				}

				if (strpos($eachvendor, 'SCO-') !== false) {
					$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_actualvalue'][$subcontindex]); 
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				}

				$alphaCharIn = 6; 
				if ($OCODisplay == 2) { 
					$alphaCharIn = 7; 
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_actualvalue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

				$alphaCharIn = 8;
				if ($OCODisplay == 2) { 
					$alphaCharIn = 9; 
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_CPSFValue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_CCPSFValue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

				$alphaCharIn = 0;
				$subcontindex++;
				$index++;

			}
			
			/* Sub Total - Start */
			$alphaCharIn = 1;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'SUBTOTAL'); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['original_Pscv_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['reallocation_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if ($OCODisplay == 2) {
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['oco_val_Formatted']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['prime_contract_scheduled_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['totalSCOAmountFormatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_subcontract_actual_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_gcBudgetLineItemVariance']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_cc_per_sf_ft_value_html']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_cc_per_sf_unit_value_html']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			if($inotes=='true')
			{
				$alphaCharIn++;

			}
			$lastAlphaIn = $alphaCharIn;
			$alphaCharIn= 0;
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
			$index++;
			/* Sub Total - End */
		}
		if(($includegrprowval == 'true' && $eachlineitem['subtotal_array']['isRowVisible'] == 'true') || $includegrprowval == 'false'){
		if(isset($eachlineitem['subtotal_array']) && $subtotal == "true"){
			
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code_division']);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'SUBTOTAL');
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_ori_pscv']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_reallocation']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if ($OCODisplay == 2) {
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_oco']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_pscv']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_sco']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_crt_subcon']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_variance']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_cost_per_sq_ft']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_cost_per_unit']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
			if($inotes=='true'){
				$alphaCharIn++;
			}
			$lastAlphaIn = $alphaCharIn;
			$alphaCharIn= 0;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('9f9e9e');
			$index++;
		}	
		}
		$alphaCharIn= 0;
	}
}
/* Total Sitework - Start */
if($checkboxcond == 2 || $checkboxcond == 3){
	$alphaCharIn = 0;
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL SITEWORK COSTS'); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
	$alphaCharIn = 2;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OriginalPSCV_SiteworksVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_reallocation_SiteworksVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	if ($OCODisplay == 2) {
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OCO_SiteworksVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
	}

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLineSiteworksOrg); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_SCO_SiteworksVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sav_SiteworksVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLineSiteworksVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cpsfunit_SiteworksVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$csfunit_SiteworksVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
	if($inotes=='true')
	{
	$alphaCharIn++;

	}
	$lastAlphaIn = $alphaCharIn;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
	$alphaCharIn++;

	$index++;
	$alphaCharIn = 0;	
}

/* Total Sitework -End */
if($checkboxcond  == 2 || $checkboxcond == 3){
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$lastCol.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"BUILDING COSTS");
    
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
    /*cell font color*/
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true)->getColor()->setRGB('FFFF');

	$index++;
	$alphaCharIn=0;

	foreach($gcBudgetLinebuildingcost as $eachlineitem){
		if(($includegrprowval == 'true' && $eachlineitem['isRowVisible'] == 'true') || $includegrprowval == 'false'){
			// BC Costcoderow Cost code
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			if ($costCodeAlias == 'false') {
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
			}else{
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->getAlignment()->setWrapText(true); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(10);
			}
			$alphaCharIn++;
			// BC Costcoderow Cost code Description
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code_description']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$alphaCharIn++;
			// BC Costcoderow Original PSCV
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['original_Pscv_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			// BC Costcoderow Reallocation
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['reallocation_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			if ($OCODisplay == 2) {
				// BC Costcoderow OCO
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['oco_val_Formatted']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}
			// BC Costcoderow Current Budget
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['prime_contract_scheduled_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if($inotes=='true')
			{
				$alphaCharIn =$alphaCharIn+5; //to make the notes colum display at the end
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['notes']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;
			}
			$index++;
			/* First Row - End */
			$subcontindex = 0;
			foreach($eachlineitem['subcontract_vendor'] as $eachvendor){
				$alphaCharIn = 1;
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachvendor); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				if (strpos($eachvendor, 'SCO-') !== false) {
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				}else if($eachvendor == 'Buyout Forecast'){
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(false);
				}else if($eachvendor != 'Forecast'){
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				}	

				$alphaCharIn = 5; 
				if ($OCODisplay == 2) { 
					$alphaCharIn = 6; 
				}	

				if (strpos($eachvendor, 'SCO-') !== false) {
					$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_actualvalue'][$subcontindex]); 
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				}

				$alphaCharIn = 6; 
				if ($OCODisplay == 2) { 
					$alphaCharIn = 7; 
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_actualvalue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

				$alphaCharIn = 8;
				if ($OCODisplay == 2) { 
					$alphaCharIn = 9; 
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_CPSFValue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_CCPSFValue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

				$alphaCharIn = 0;
				$subcontindex++;
				$index++;

			}	
			/* Sub Total - Start */
			$alphaCharIn = 1;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'SUBTOTAL'); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['original_Pscv_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['reallocation_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if ($OCODisplay == 2) {
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['oco_val_Formatted']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['prime_contract_scheduled_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['totalSCOAmountFormatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_subcontract_actual_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_gcBudgetLineItemVariance']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_cc_per_sf_ft_value_html']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_cc_per_sf_unit_value_html']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			if($inotes=='true')
			{
				$alphaCharIn++;

			}
			$lastAlphaIn = $alphaCharIn;
			$alphaCharIn= 0;
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
			$index++;
			/* Sub Total - End */
		}
		if(($includegrprowval == 'true' && $eachlineitem['subtotal_array']['isRowVisible'] == 'true') || $includegrprowval == 'false'){
		if(isset($eachlineitem['subtotal_array']) && $subtotal == "true"){

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code_division']);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'SUBTOTAL');
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_ori_pscv']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_reallocation']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if ($OCODisplay == 2) {
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_oco']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_pscv']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_sco']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_crt_subcon']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_variance']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_cost_per_sq_ft']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_cost_per_unit']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
			if($inotes=='true'){
				$alphaCharIn++;
			}
			$lastAlphaIn = $alphaCharIn;
			$alphaCharIn= 0;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('9f9e9e');
			$index++;
		}	
		}
		$alphaCharIn= 0;
	}
}
	/* Total Building cost - Start */
if($checkboxcond == 2 || $checkboxcond == 3){
	$alphaCharIn = 0;
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL BUILDING COSTS'); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
	$alphaCharIn = 2;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OriginalPSCV_buildingcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_reallocation_buildingcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	if ($OCODisplay == 2) {
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OCO_buildingcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
	}

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLinebuildingcostOrg); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_SCO_buildingcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sav_buildingcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLinebuildingcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cpsfunit_buildingcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$csfunit_buildingcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
	if($inotes=='true')
	{
		$alphaCharIn++;

	}
	$lastAlphaIn = $alphaCharIn;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
	$alphaCharIn++;

	$index++;
	$alphaCharIn = 0;
}
	/* Total Building cost - End */
if($checkboxcond  == 2 || $checkboxcond == 3){
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$lastCol.$index);

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SOFT COSTS");
    
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
    /*cell font color*/
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true)->getColor()->setRGB('FFFF');

	$index++;
	$alphaCharIn=0;


	foreach($gcBudgetLinesoftcost as $eachlineitem){
		if(($includegrprowval == 'true' && $eachlineitem['isRowVisible'] == 'true') || $includegrprowval == 'false'){
			// SC Costcoderow Cost code
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			if ($costCodeAlias == 'false') {
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
			}else{
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->getAlignment()->setWrapText(true); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(10);
			}
			$alphaCharIn++;
			// SC Costcoderow Cost code Description
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code_description']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$alphaCharIn++;
			// SC Costcoderow Original PSCV
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['original_Pscv_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			// SC Costcoderow Reallocation
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['reallocation_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			if ($OCODisplay == 2) {
				// SC Costcoderow OCO
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['oco_val_Formatted']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}
			// SC Costcoderow Current Budget
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['prime_contract_scheduled_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if($inotes=='true')
			{

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'checking78'.$eachlineitem['notes']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;
			}
			$index++;
			/* First Row - End */
			$subcontindex = 0;
			foreach($eachlineitem['subcontract_vendor'] as $eachvendor){
				$alphaCharIn = 1;
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachvendor); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				if (strpos($eachvendor, 'SCO-') !== false) {
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				}else if($eachvendor == 'Buyout Forecast'){
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(false);
				}else if($eachvendor != 'Forecast'){
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				}	

				$alphaCharIn = 5; 
				if ($OCODisplay == 2) { 
					$alphaCharIn = 6; 
				}	

				if (strpos($eachvendor, 'SCO-') !== false) {
					$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_actualvalue'][$subcontindex]); 
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				}

				$alphaCharIn = 6; 
				if ($OCODisplay == 2) { 
					$alphaCharIn = 7; 
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_actualvalue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

				$alphaCharIn = 8;
				if ($OCODisplay == 2) { 
					$alphaCharIn = 9; 
				}

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_CPSFValue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;

				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subcontract_CCPSFValue'][$subcontindex]); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

				$alphaCharIn = 0;
				$subcontindex++;
				$index++;

			}

			
			/* Sub Total - Start */
			$alphaCharIn = 1;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'SUBTOTAL'); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['original_Pscv_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['reallocation_Formatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if ($OCODisplay == 2) {
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['oco_val_Formatted']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['prime_contract_scheduled_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['totalSCOAmountFormatted']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_subcontract_actual_value']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_gcBudgetLineItemVariance']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_cc_per_sf_ft_value_html']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['total_cc_per_sf_unit_value_html']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			if($inotes=='true')
			{
				$alphaCharIn++;

			}
			$lastAlphaIn = $alphaCharIn;
			$alphaCharIn= 0;
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
			$index++;
			/* Sub Total - End */
		}
		if(($includegrprowval == 'true' && $eachlineitem['subtotal_array']['isRowVisible'] == 'true') || $includegrprowval == 'false'){
		if(isset($eachlineitem['subtotal_array']) && $subtotal == "true"){

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['cost_code_division']);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'SUBTOTAL');
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_ori_pscv']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_reallocation']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			if ($OCODisplay == 2) {
				$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_oco']); 
				$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
				$alphaCharIn++;
			}

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_pscv']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_sco']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_crt_subcon']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_variance']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_cost_per_sq_ft']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$eachlineitem['subtotal_array']['sub_tot_cost_per_unit']); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
			if($inotes=='true'){
				$alphaCharIn++;
			}
			$lastAlphaIn = $alphaCharIn;
			$alphaCharIn= 0;
			$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('9f9e9e');
			$index++;
		}
		}
		$alphaCharIn= 0;
	}
}
/* Total Soft cost - Start */
if($checkboxcond == 2 || $checkboxcond == 3){
	$alphaCharIn = 0;
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL SOFT COSTS'); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
	$alphaCharIn = 2;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OriginalPSCV_softcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_reallocation_softcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	if ($OCODisplay == 2) {
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OCO_softcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
	}

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLinesoftcostOrg); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_SCO_softcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sav_softcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLinesoftcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cpsfunit_softcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$alphaCharIn++;
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$csfunit_softcostVar); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
	if($inotes=='true')
	{
		$alphaCharIn++;

	}
	$lastAlphaIn = $alphaCharIn;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
	$alphaCharIn++;

	$index++;
	$alphaCharIn = 0;
}
	/* Total Soft cost - End */
	/* Project Summary - Start */
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
	$alphaCharIn=0;
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$lastCol.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"PROJECT SUMMARY");
    
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
    /*cell font color*/
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true)->getColor()->setRGB('FFFF');

	$index++;
	$alphaCharIn=0;
	if($checkboxcond == 2 || $checkboxcond == 3){
		$alphaCharIn = 0;
		$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL GENERAL CONDITIONS'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
		$alphaCharIn = 2;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OriginalPSCV_GeneralcondVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_reallocation_GeneralcondVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		if ($OCODisplay == 2) {
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OCO_GeneralcondVar); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
		}

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLineGeneralcondOrg); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_SCO_GeneralcondVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sav_GeneralcondVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLineGeneralcondVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cpsfunit_GeneralcondVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$csfunit_GeneralcondVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		if($inotes=='true')
		{
			$alphaCharIn++;

		}
		$lastAlphaIn = $alphaCharIn;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
		$alphaCharIn++;
		$index++;
		$alphaCharIn = 0;
		
	}
	/* Total Sitework - Start */
	if($checkboxcond == 2  || $checkboxcond == 3){
		$alphaCharIn = 0;
		$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL SITEWORK COSTS'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
		$alphaCharIn = 2;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OriginalPSCV_SiteworksVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_reallocation_SiteworksVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		if ($OCODisplay == 2) {
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OCO_SiteworksVar); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
		}

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLineSiteworksOrg); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_SCO_SiteworksVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sav_SiteworksVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLineSiteworksVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cpsfunit_SiteworksVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$csfunit_SiteworksVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		if($inotes=='true')
		{
			$alphaCharIn++;

		}
		$lastAlphaIn = $alphaCharIn;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
		$alphaCharIn++;

		$index++;
		$alphaCharIn = 0;
		
	}

	/* Total Sitework -End */

	/* Total Building cost - Start */
	if($checkboxcond == 2  || $checkboxcond == 3){
		$alphaCharIn = 0;
		$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL BUILDING COSTS'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
		$alphaCharIn = 2;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OriginalPSCV_buildingcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_reallocation_buildingcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		if ($OCODisplay == 2) {
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OCO_buildingcostVar); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
		}

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLinebuildingcostOrg); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_SCO_buildingcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sav_buildingcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLinebuildingcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cpsfunit_buildingcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$csfunit_buildingcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		if($inotes=='true')
		{
			$alphaCharIn++;

		}
		$lastAlphaIn = $alphaCharIn;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
		$alphaCharIn++;

		$index++;
		$alphaCharIn = 0;
		
	}
	/* Total Building cost - End */

	/* Total Soft cost - Start */
	if($checkboxcond == 2  || $checkboxcond == 3){
		$alphaCharIn = 0;
		$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL SOFT COSTS'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
		$alphaCharIn = 2;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OriginalPSCV_softcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_reallocation_softcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		if ($OCODisplay == 2) {
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_OCO_softcostVar); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
		}

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLinesoftcostOrg); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudget_SCO_softcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sav_softcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$gcBudgetLinesoftcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cpsfunit_softcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$csfunit_softcostVar); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		if($inotes=='true')
		{
			$alphaCharIn++;

		}
		$lastAlphaIn = $alphaCharIn;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');		
		$alphaCharIn++;

		$index++;
		$alphaCharIn = 0;
		
	}
	/* Total Soft cost - End */

	/* Total Project cost - Start */
		$alphaCharIn = 0;
		$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'TOTAL PROJECT COSTS'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
		$alphaCharIn = 2;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$overall_Original_PSCV); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$overall_Reallocation_Val); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		if ($OCODisplay == 2) {
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$overall_OCO_Val); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
		}

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$OverallOrg); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$overall_Sco_amount); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$overall_sav); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$overall_var); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$overall_cpsfunit); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn++;
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$overall_csfunit); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
		if($inotes=='true')
		{
			$alphaCharIn++;

		}
		$lastAlphaIn = $alphaCharIn;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
		$alphaCharIn++;

		$index++;
		$alphaCharIn = 0;
		
	/* Total Project cost - End */

	/* Project Summary - End */
	/*COR - Start */
	if ($OCODisplay == 1) {
		$alphaCharIn = 0;
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'CUSTOM'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'COR'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Title'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
		$objPHPExcel->setActiveSheetIndex()->mergeCells('C'.$index.':E'.$index);

		$alphaCharIn = 5;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Amount'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
		$alphaCharIn++;

		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Created Date'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
		$alphaCharIn++;


		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Days'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);
		$alphaCharIn++;

		$objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].($index).':'.$lastCol.($index));
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Reason'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($verticalCenter);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
	    /*cell font color*/
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true)->getColor()->setRGB('FFFF');



		$index++;
		$alphaCharIn = 0;
		/* COR function - start */

		$loadChangeOrdersByProjectIdOptions = new Input();
		$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
		$loadChangeOrdersByProjectIdOptions->change_order_type_id = 2;
		$loadChangeOrdersByProjectIdOptions->change_order_status_id = 2; //For approved 
		$totalCORs = ChangeOrder::loadChangeOrdersCountByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

		if ($totalCORs == 0) {
			return '';
		}

		$arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);
	  		 
		
		$sum_co_total =0;
		foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
			/* @var $changeOrder ChangeOrder */

			$project = $changeOrder->getProject();
			/* @var $project Project */

			$changeOrderType = $changeOrder->getChangeOrderType();
			/* @var $changeOrderType ChangeOrderType */
			$change_order_type = $changeOrderType->change_order_type;

			$changeOrderStatus = $changeOrder->getChangeOrderStatus();
			/* @var $changeOrderStatus ChangeOrderStatus */

			$changeOrderPriority = $changeOrder->getChangeOrderPriority();
			/* @var $changeOrderPriority ChangeOrderPriority */

			$changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
			/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
			$change_order_distribution_method = '';

			$coFileManagerFile = $changeOrder->getCoFileManagerFile();
			/* @var $coFileManagerFile FileManagerFile */

			$coCostCode = $changeOrder->getCoCostCode();
			/* @var $coCostCode CostCode */

			$coCreatorContact = $changeOrder->getCoCreatorContact();
			/* @var $coCreatorContact Contact */

			$coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
			/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

			$coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
			/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
			/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
			/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

			$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
			/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

			$coRecipientContact = $changeOrder->getCoRecipientContact();
			/* @var $coRecipientContact Contact */

			$coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
			/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

			$coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
			/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
			/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
			/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

			$coInitiatorContact = $changeOrder->getCoInitiatorContact();
			/* @var $coInitiatorContact Contact */

			$coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
			/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

			$coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
			/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
			/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
			/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */

			$co_sequence_number = $changeOrder->co_sequence_number;
			$co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
			$co_scheduled_value = $changeOrder->co_scheduled_value;
			$co_delay_days = $changeOrder->co_delay_days;
			$change_order_type_id = $changeOrder->change_order_type_id;
			$change_order_status_id = $changeOrder->change_order_status_id;
			$change_order_priority_id = $changeOrder->change_order_priority_id;
			$change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
			$co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
			$co_cost_code_id = $changeOrder->co_cost_code_id;
			$co_creator_contact_id = $changeOrder->co_creator_contact_id;
			$co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
			$co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
			$co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
			$co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
			$co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
			$co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
			$co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
			$co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
			$co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
			$co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
			$co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
			$co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
			$co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
			$co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
			$co_title = $changeOrder->co_title;
			$co_plan_page_reference = $changeOrder->co_plan_page_reference;
			$co_statement = $changeOrder->co_statement;
			$co_created = $changeOrder->created;
			$co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
			$co_closed_date = $changeOrder->co_closed_date;
			$co_total =$changeOrder->co_total;
			$co_type_prefix= $changeOrder->co_type_prefix;
			$co_custom_sequence_number= $changeOrder->co_custom_sequence_number;

			// HTML Entity Escaped Data
			$changeOrder->htmlEntityEscapeProperties();
			$escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
			$escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
			$escaped_co_statement = $changeOrder->escaped_co_statement;
			$escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
			$escaped_co_title = $changeOrder->escaped_co_title;

			if (empty($escaped_co_custom_sequence_number)) {
				$escaped_co_custom_sequence_number = $co_sequence_number;
			}

			if (empty($co_revised_project_completion_date)) {
				$co_revised_project_completion_date = '';
			}

			if (empty($escaped_co_plan_page_reference)) {
				$escaped_co_plan_page_reference = '';
			}

			if ($changeOrderPriority) {
				$change_order_priority = $changeOrderPriority->change_order_priority;
			} else {
				$change_order_priority = '';
			}

			if ($coCostCode) {
				// Extra: Change Order Cost Code - Cost Code Division
				$coCostCodeDivision = $coCostCode->getCostCodeDivision();
				/* @var $coCostCodeDivision CostCodeDivision */

				$formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false);

				$coCostCode->htmlEntityEscapeProperties();
				$escaped_cost_code_description = $coCostCode->escaped_cost_code_description;

			} else {
				$formattedCoCostCode = '';
				$escaped_cost_code_description = '';
			}

			/* @var $recipient Contact */

			if ($coRecipientContact) {
				$coRecipientContactFullName = $coRecipientContact->getContactFullName();
				$coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
			} else {
				$coRecipientContactFullName = '';
				$coRecipientContactFullNameHtmlEscaped = '';
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
			
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_custom_sequence_number); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_type_prefix); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleLeft);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_title); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->setActiveSheetIndex()->mergeCells('C'.$index.':E'.$index);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->getAlignment()->setWrapText(true); 
			$objPHPExcel->getActiveSheet()->getRowDimension($index)->setRowHeight(-1); 
			$alphaCharIn = 5;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_total); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;

			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCreatedDate); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;


			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_delay_days); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
			$alphaCharIn++;
			$objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].($index).':'.$lastCol.($index));
			$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_priority); 
			$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);


			$index++;
			$alphaCharIn = 0;
		}
		$budget_total =$totalPrimeSchedule+$sum_co_total;
		$sum_co_total =Format::formatCurrency($sum_co_total);
		$budget_total =Format::formatCurrency($budget_total);

		$alphaCharIn = 0;
		$objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].($index).':E'.($index));
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Approved Change Orders Total'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn = 5;
		
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$sum_co_total); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true);
		$index++;
		$alphaCharIn = 0;
		$objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].($index).':E'.($index));
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Revised budget Total'); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$alphaCharIn = 5;
		
		$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$budget_total); 
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true);
		$lastAlphaIn = $alphaCharIn;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$lastCol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('d9d9d9');
		$index++;
	}
	
	$alphaCharIn = 0;
	$index++;

	$forecastedExpensesTotal = Format::formatCurrency($forecastedExpensesTotal);
	$buyoutforecastedExpensesTotal = Format::formatCurrency($buyoutforecastedExpensesTotal);

	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Forecast Totals:");    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.'B'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->setBold(true)->getColor()->setRGB('FFFF');

	$index++;
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Forecast'); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$forecastedExpensesTotal); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

	$index++;
	$alphaCharIn = 0;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Buyout Forecast'); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
	$alphaCharIn++;

	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$buyoutforecastedExpensesTotal); 
	$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);

	$index++;
	$index++;
	$alphaCharIn = 0;
	$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'* Buyout forecast is not included in subtotal for rows with a subcontract in place.'); 
	$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$lastCol.$index);
	/*COR - End */
?>

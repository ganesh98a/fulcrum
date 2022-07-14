<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Project.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/ChangeOrder.php');
require_once('lib/common/ChangeOrderType.php');
require_once('lib/common/ChangeOrderStatus.php');
require_once('lib/common/ChangeOrderPriority.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
include_once('./Reports/GeneratePdfData.php');
/*Initialize PHPExcel Class*/
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica')->setSize(12);
$objPHPExcel->getProperties()->setCreator("A.Ganeshkumar");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 Xlsx Fulcrum Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 Xlsx Fulcrum Document");
$objPHPExcel->getProperties()->setDescription("Fulcrum document for Office 2007 Xlsx, generated using PHP classes.");

$objPHPExcel->setActiveSheetIndex(0);
$db = DBI::getInstance($database);
$db->free_result();
$project = Project::findById($database, $RN_project_id);
$unitCount = $project->unit_count;
$netRentableSqFt = $project->net_rentable_square_footage;
$index = 1;
$signature=$fulcrum;

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
$styleCenter = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  )
);
$styleVerticalCenter = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
  )
);

$styleArray = array(
  'font'  => array(
    'color' => array('rgb' => 'FFFFFF')
  )
);

if (file_exists($signature)) {
  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('Customer Signature');
  $objDrawing->setDescription('Customer Signature');
  //Path to signature .jpg file
  $objDrawing->setPath($signature);
  $objDrawing->setCoordinates('A'.$index);             //set image to cell
  $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save
  $height = $height +10;
  $points = PHPExcel_Shared_Drawing::pixelsToPoints($height);
  $objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleRight);
  $objPHPExcel->getActiveSheet()->getRowDimension($index)->setRowHeight($points);
  /*cell merge*/
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':H'.($index));
} else {
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':H'.$index);
  $objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleCenter);
}
/*cell content*/
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index),$type_mention);

/*cell font style*/
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getFont()->setSize(21);

$index++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"PROJECT : ");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,$project_name);
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':B'.$index)->applyFromArray($styleArray);
if($add_val!=''){
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$index,"ADDRESS : ".$add_val);
}else{
  $objPHPExcel->getActiveSheet()->setCellValue('D'.$index,"");
}
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('B'.$index.':H'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':H'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('E'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':H'.$index);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);

$index = $index + 2;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Units");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(10);

$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,$unitCount);
$objPHPExcel->getActiveSheet()->getStyle('B'.$index)->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('B'.($index))->applyFromArray($styleLeft);
$index++;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"SF");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(10);

$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,$netRentableSqFt);
$objPHPExcel->getActiveSheet()->getStyle('B'.$index)->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('B'.($index))->applyFromArray($styleLeft);
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(10);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(15);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Prime Contract");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(15);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Subcontracted Vendor");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(23);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SCO's");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(9);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Subcontract + SCO's");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(18);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Variance");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(9);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Per Unit");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setWidth(11);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
$lastAlphaIn = $alphaCharIn;
$alphaCharIn=0;
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->getColor()->setRGB('FFFF');

$alphaCharIn=0;
$index++;

$loadCurrentGcBudgetLineItemIdOptions = new Input();
$loadCurrentGcBudgetLineItemIdOptions->forceLoadFlag = true;

$arrGcBudgetLineItems = GcBudgetLineItem::loadCurrentGcBudgetLineItems($database, $RN_project_id, $RN_reportsStartDate, $RN_reportsEndDate, $loadCurrentGcBudgetLineItemIdOptions);
$totalPrimeScheduleValue = 0;
$totalEstimatedSubcontractValue = 0;
$totalVariance = 0;
foreach ($arrGcBudgetLineItems as $gc_budget_line_item_id => $budgetLineItem) {
  $estimatedSubcontractorAmount = 0;
  $alphaCharIn = 0;

  $costCode = $budgetLineItem->getCostCode();
  $costCodeId = $budgetLineItem->cost_code_id;
  $costCodeStart = $alphas[0].$index;
  $formattedCostCode = $costCode->getFormattedCostCodeApi($database, false, $RN_user_company_id);
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCostCode);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
  $alphaCharIn++;

  $costCodeDescStart = $alphas[1].$index;
  $costCodeDescription = $costCode->cost_code_description;
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costCodeDescription);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
  $alphaCharIn++;

  $scheduledValueStart = $alphas[2].$index;
  $scheduledValue = $budgetLineItem->prime_contract_scheduled_value;
  $totalPrimeScheduleValue += $scheduledValue;
  $scheduledValueFormatted = Format::formatCurrency(abs($scheduledValue));
  if($scheduledValue < 0){
    $scheduledValueFormatted = '('.$scheduledValueFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$scheduledValueFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
  $alphaCharIn++;

  $totalAmount = 0;
  $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
  $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
  $arrSubcontracts = Subcontract::loadCurrentSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
  if(count($arrSubcontracts) > 0){
    foreach ($arrSubcontracts as $subcontract) {
      $subcontractAmount = 0;
      $subContractId = $subcontract->subcontract_id;

      $arrSubcontractChangeOrder = getApprovedSubcontractChangeOrder($database, $costCodeId, $RN_project_id, $subContractId);

      // Vendor list
      $alphaCharIn = 3;
      $vendor = $subcontract->getVendor();
      $vendorContactCompany = $vendor->getVendorContactCompany();
      /* @var $vendorContactCompany ContactCompany */
      $vendorContactCompany->htmlEntityEscapeProperties();
      $vendorCompany = $vendorContactCompany->escaped_contact_company_name;
      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorCompany);
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
      $alphaCharIn = $alphaCharIn+2;

      $subcontractActualValue = $subcontract->subcontract_actual_value;
      $totalAmount += $subcontractActualValue;
      $subcontractAmount += $subcontractActualValue;
      $estimatedSubcontractorAmount += $subcontractActualValue;
      $subcontractActualValueFormatted = Format::formatCurrency(abs($subcontractActualValue));
      if($subcontractActualValue < 0 ){
        $subcontractActualValueFormatted = '('.$subcontractActualValueFormatted.')';
      }
      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subcontractActualValueFormatted);
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleRight);
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
      $talphaCharIn = $alphaCharIn+2;
      $index++;
      if(count($arrSubcontractChangeOrder) > 0){
        foreach ($arrSubcontractChangeOrder as $subcontractChangeOrder) {
          $alphaCharIn = 4;
          $approvePrefix = $subcontractChangeOrder['approve_prefix'];
          $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$approvePrefix);
          $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
          $alphaCharIn++;

          $estimatedAmount = $subcontractChangeOrder['estimated_amount'];
          $totalAmount += $estimatedAmount;
          $subcontractAmount += $estimatedAmount;
          $estimatedSubcontractorAmount += $estimatedAmount;
          $estimatedAmountFormatted = Format::formatCurrency(abs($estimatedAmount));
          if($estimatedAmount < 0 ){
            $estimatedAmountFormatted = '('.$estimatedAmountFormatted.')';
          }
          $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$estimatedAmountFormatted);
          $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleRight);
          $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
          $alphaCharIn++;
          $alphaSFCharIn = $alphaCharIn+1;
          $alphaSFIndex = $alphas[$alphaSFCharIn].$index;
          $index++;
        }
      }else{
        $alphaSFIndex = $alphas[$alphaCharIn].$index;
      }
      $costPerSqFt = $subcontractAmount/$unitCount;
      $costPerSqFtFormatted = Format::formatCurrency(abs($costPerSqFt));
      if($costPerSqFt < 0){
        $costPerSqFtFormatted = '('.$costPerSqFtFormatted.')';
      }
      $objPHPExcel->getActiveSheet()->setCellValue($alphaSFIndex,$costPerSqFtFormatted);
      $objPHPExcel->getActiveSheet()->getStyle($alphaSFIndex)->applyFromArray($styleRight);
      $objPHPExcel->getActiveSheet()->getStyle($alphaSFIndex)->getFont()->setSize(10);
    }

    $forecastedExpenses = $budgetLineItem->forecasted_expenses;
    $totalAmount += $forecastedExpenses;
    $totalEstimatedSubcontractValue += $totalAmount;
    $forecastedExpensesFormatted = Format::formatCurrency(abs($forecastedExpenses));
    if($forecastedExpenses < 0 ){
      $forecastedExpensesFormatted = '('.$forecastedExpensesFormatted.')';
    }
    $forecaseAlphaCharIn = 4;

    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$forecaseAlphaCharIn].$index,"Forecasted");
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$forecaseAlphaCharIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C0C0C0');
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$forecaseAlphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
    $forecaseAlphaCharIn++;

    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$forecaseAlphaCharIn].$index,$forecastedExpensesFormatted);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$forecaseAlphaCharIn].$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$forecaseAlphaCharIn].$index)->getFont()->setSize(10);
    $index++;

    $totalAlphaCharIn = 4;
    $costCodeEnd = $alphas[0].$index;
    $costCodeDescEnd = $alphas[1].$index;
    $scheduledValueEnd = $alphas[2].$index;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$totalAlphaCharIn].$index,"Total");
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$totalAlphaCharIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C0C0C0');
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$totalAlphaCharIn].$index)->getFont()->setBold(true)->setSize(10);
    $totalAlphaCharIn++;
    $totalAmountFormatted = Format::formatCurrency(abs($totalAmount));
    if($totalAmount < 0 ){
      $totalAmountFormatted = '('.$totalAmountFormatted.')';
    }
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$totalAlphaCharIn].$index,$totalAmountFormatted);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$totalAlphaCharIn].$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$totalAlphaCharIn].$index)->getFont()->setSize(10);
    $totalAlphaCharIn++;

    $variance = $scheduledValue - $totalAmount;
    $totalVariance += $variance;
    $varianceFormatted = Format::formatCurrency(abs($variance));
    if($variance < 0){
      $varianceFormatted = '('.$varianceFormatted.')';
    }
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$totalAlphaCharIn].$index,$varianceFormatted);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$totalAlphaCharIn].$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$totalAlphaCharIn].$index)->getFont()->setSize(10);
    $totalAlphaCharIn++;

    $totalCostPerSqFt = $estimatedSubcontractorAmount/$unitCount;
    $totalCostPerSqFtFormatted = Format::formatCurrency(abs($totalCostPerSqFt));
    if($totalCostPerSqFt < 0){
      $totalCostPerSqFtFormatted = '('.$totalCostPerSqFtFormatted.')';
    }
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$totalAlphaCharIn].$index,$totalCostPerSqFtFormatted);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$totalAlphaCharIn].$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$totalAlphaCharIn].$index)->getFont()->setSize(10);
    $totalAlphaCharIn++;

    $index++;

    // $objPHPExcel->setActiveSheetIndex()->mergeCells($costCodeStart.':'.$costCodeEnd);
    // $objPHPExcel->getActiveSheet()->getStyle($costCodeStart)->applyFromArray($styleVerticalCenter);
    // $objPHPExcel->setActiveSheetIndex()->mergeCells($costCodeDescStart.':'.$costCodeDescEnd);
    // $objPHPExcel->getActiveSheet()->getStyle($costCodeDescStart)->applyFromArray($styleVerticalCenter);
    // $objPHPExcel->setActiveSheetIndex()->mergeCells($scheduledValueStart.':'.$scheduledValueEnd);
    // $objPHPExcel->getActiveSheet()->getStyle($scheduledValueStart)->applyFromArray($styleVerticalCenter);

  }else{
    $index++;
  }
}

//Fetch the change order data
$loadChangeOrdersByProjectIdOptions = new Input();
$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
$loadChangeOrdersByProjectIdOptions->change_order_type_id = 2;
$loadChangeOrdersByProjectIdOptions->change_order_status_id = 2; //For approved
$arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $RN_project_id, $loadChangeOrdersByProjectIdOptions);

if(count($arrGcBudgetLineItems) > 0){
  $alphas = range('A', 'Z');
  $alphaCharIn = 0;
  $totalTitle = count($arrChangeOrders) > 0 ? "Sub Totals" : "Project Totals";
  if($totalTitle == 'Sub Totals'){
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':H'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C0C0C0');
  }else{
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':H'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('3366FF');
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$totalTitle);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $alphaCharIn = $alphaCharIn + 2;

  $totalPrimeScheduleValueFormatted = Format::formatCurrency(abs($totalPrimeScheduleValue));
  if($totalPrimeScheduleValue < 0){
    $totalPrimeScheduleValueFormatted = '('.$totalPrimeScheduleValueFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index, $totalPrimeScheduleValueFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
  $alphaCharIn = $alphaCharIn + 3;

  $totalEstimatedSubcontractValueFormatted = Format::formatCurrency(abs($totalEstimatedSubcontractValue));
  if($totalEstimatedSubcontractValue < 0 ){
    $totalEstimatedSubcontractValueFormatted = '('.$totalEstimatedSubcontractValueFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index, $totalEstimatedSubcontractValueFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleRight);
  $alphaCharIn++;

  $totalVarianceFormatted = Format::formatCurrency(abs($totalVariance));
  if($totalVariance < 0 ){
    $totalVarianceFormatted = '('.$totalVarianceFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index, $totalVarianceFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleRight);
  $index = $index + 2;
}
$alphas = range('A', 'Z');
$alphaCharIn = 0;

$totalCoTotalValue = 0;
foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
  $coTypePrefix = $changeOrder->co_type_prefix;
  $alphaCharIn = 0;
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$coTypePrefix);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
  $alphaCharIn++;
  // HTML Entity Escaped Data
  $changeOrder->htmlEntityEscapeProperties();
  $escapedCoTitle = $changeOrder->escaped_co_title;
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escapedCoTitle);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
  $alphaCharIn++;

  $coTotal = $changeOrder->co_total;
  $totalCoTotalValue += $coTotal;
  $coTotalFormatted = Format::formatCurrency(abs($coTotal));
  if($coTotal < 0){
    $coTotalFormatted = '('.$coTotalFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$coTotalFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
  $alphaCharIn++;

  $index++;
}

if(count($arrChangeOrders) > 0){
  $alphas = range('A', 'Z');
  $alphaCharIn = 0;
  $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':H'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C0C0C0');
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'Approved Change Orders Total');
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $alphaCharIn = $alphaCharIn + 2;

  $totalCoTotalValueFormatted = Format::formatCurrency(abs($totalCoTotalValue));
  if($totalCoTotalValue < 0){
    $totalCoTotalValueFormatted = '('.$totalCoTotalValueFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index, $totalCoTotalValueFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
  $index++;

  $alphas = range('A', 'Z');
  $alphaCharIn = 0;
  $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':H'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('3366FF');
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Project Totals");
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $alphaCharIn = $alphaCharIn + 2;

  $projectTotal = $totalPrimeScheduleValue + $totalCoTotalValue;
  $projectTotalFormatted = Format::formatCurrency(abs($projectTotal));
  if($projectTotal < 0){
    $projectTotalFormatted = '('.$projectTotalFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index, $projectTotalFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
  $alphaCharIn = $alphaCharIn + 3;

  $totalEstimatedSubcontractValueFormatted = Format::formatCurrency(abs($totalEstimatedSubcontractValue));
  if($totalEstimatedSubcontractValue < 0 ){
    $totalEstimatedSubcontractValueFormatted = '('.$totalEstimatedSubcontractValueFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index, $totalEstimatedSubcontractValueFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleRight);
  $alphaCharIn++;

  $totalVarianceFormatted = Format::formatCurrency(abs($totalVariance));
  if($totalVariance < 0 ){
    $totalVarianceFormatted = '('.$totalVarianceFormatted.')';
  }
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index, $totalVarianceFormatted);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10)->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleRight);
}
if(count($arrChangeOrders) == 0 && count($arrGcBudgetLineItems) == 0){
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':H'.$index);
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available");
  $objPHPExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray($styleCenter);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(10);
}
/*$filename = urlencode($type_mention)."-".$dates.":".$i.":".$s.".xlsx";
$filenameSheet = $type_mention;
$objPHPExcel->getActiveSheet()->setTitle($filenameSheet);
// Redirect output to a client?s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel,'Excel5');
$objWriter->save('php://output');*/
?>

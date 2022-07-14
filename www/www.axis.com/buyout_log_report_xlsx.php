<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/GcBudgetLineItem.php');

/*Initialize PHPExcel Class*/
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica')->setSize(12);
$objPHPExcel->getProperties()->setCreator("K.C.Bathirinath");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setDescription("Buyout Log.");

$objPHPExcel->setActiveSheetIndex(0);
$index=1;
$signature=$fulcrum;

/*cell text alignment*/
$styleRight = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
$styleLeft = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
$styleCenter = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
$verticalCenter = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
$verCenterRight = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT));
$verCenterLeft = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
$styleArray = array('font'  => array('color' => array('rgb' => 'FFFFFF')));

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
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':F'.($index));

} else {
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':F'.$index);
  $objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleCenter);
}

$project = Project::findProjectByIdExtended($database, $project_id);    
$alias_type = $project->alias_type;

$sheet = $objPHPExcel->getActiveSheet();
$merge = $objPHPExcel->setActiveSheetIndex();

// Excel title
$sheet->setCellValue('A'.($index),$type_mention);
$sheet->getStyle('A'.($index))->getFont()->setSize(21);
$sheet->getStyle('A'.($index))->getAlignment()->setIndent(1);
$index++;


if ($hasSubContAmt == 'true') {
  $heChar = 'D'; $hsChar = 'E'; $eChar = 'H';
}else{
  $heChar = 'C'; $hsChar = 'D'; $eChar = 'F';
}

// Project Details
$sheet->setCellValue('A'.$index,"PROJECT : ".$project_name);
$merge->mergeCells('A'.$index.':'.$heChar.$index);
$sheet->setCellValue($hsChar.$index,"ADDRESS : ".$add_val);
$merge->mergeCells($hsChar.$index.':'.$eChar.$index);
$sheet->getStyle('A'.$index.':'.$eChar.$index)->applyFromArray($styleArray);
$sheet->getStyle('A'.$index.':'.$eChar.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$sheet->getRowDimension(($index))->setRowHeight(20);
$index++;

$sheet->setCellValue('A'.$index,"DATE : ".$date .' To '.$date1);
$merge->mergeCells('A'.$index.':'.$eChar.$index);
$sheet->getStyle('A'.$index)->applyFromArray($styleArray);
$sheet->getStyle('A'.$index.':F'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$sheet->getRowDimension(($index))->setRowHeight(20);
$index++;

$merge->mergeCells('A'.$index.':'.$eChar.$index);
$index++;

// Headers
$alphas = range('A', 'Z');
$cnt = 0;

$sheet->setCellValue($alphas[$cnt].$index,"Cost Code");
$sheet->getColumnDimension($alphas[$cnt])->setAutoSize(true);$cnt++;

$sheet->setCellValue($alphas[$cnt].$index,"Description");
$sheet->getColumnDimension($alphas[$cnt])->setAutoSize(true);$cnt++;

$sheet->setCellValue($alphas[$cnt].$index,"Contract Value");
$sheet->getColumnDimension($alphas[$cnt])->setAutoSize(true);$cnt++;

$sheet->setCellValue($alphas[$cnt].$index,"Bids Received");
$sheet->getColumnDimension($alphas[$cnt])->setAutoSize(true);$cnt++;

$sheet->setCellValue($alphas[$cnt].$index,"Contracted");
$sheet->getColumnDimension($alphas[$cnt])->setAutoSize(true);$cnt++;

$sheet->setCellValue($alphas[$cnt].$index,"Awarded Subcontracts");
$sheet->getColumnDimension($alphas[$cnt])->setAutoSize(true);$cnt++;

if ($hasSubContAmt == 'true') {
  $sheet->setCellValue($alphas[$cnt].$index,"Subcontract Amount");
  $sheet->getColumnDimension($alphas[$cnt])->setAutoSize(true);$cnt++;

  $sheet->setCellValue($alphas[$cnt].$index,"Buyout Savings/Hit");
  $sheet->getColumnDimension($alphas[$cnt])->setAutoSize(true);$cnt++;
}

$sheet->getStyle('A'.$index.':'.$eChar.$index)->applyFromArray($verticalCenter);
$sheet->getStyle('A'.$index.':'.$eChar.$index)->getFont()->setBold(true);
$sheet->getStyle('A'.$index.':'.$eChar.$index)->getFont()->setSize(10);
$sheet->getStyle('A'.$index.':'.$eChar.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$sheet->getStyle('A'.$index.':'.$eChar.$index)->getFont()->getColor()->setRGB('FFFF');
$index++;

$index++;

//Fetch contracts Data
$arrbuyout = GcBudgetLineItem::loadBuyoutLogData($database, $project_id);
$buyoutLogBody = $hasSubContAmtTd = $hasSubContAmtTotTd = '';
$totalPSCV = $overAlltotSubContActVal = $totbuyoutSavingHit = $hasSubContPSCV = $bidRecivedPSCV = 0;
if(count($arrbuyout) > 0){

  foreach ($arrbuyout as $gc_budget_line_item_id => $budgetLineItem) {

    $cnt = 0;

    $costCode = $budgetLineItem->getCostCode();
    $cost_code_id = $costCode->cost_code_id;
    $costCodeDivision = $costCode->getCostCodeDivision();
    $costCodeDivision->htmlEntityEscapeProperties();
    $cost_code_division_id = $costCodeDivision->cost_code_division_id;
    $formattedCostCode = $costCode->getFormattedCostCode($database,false, $user_company_id);
    $costCodeDescription = $costCode->cost_code_description;
    $pscv = $budgetLineItem->prime_contract_scheduled_value;
    $pscvFormatted = Format::formatCurrency($pscv);
    $totalPSCV = $totalPSCV + $pscv;

    $getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_division_id);
    if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
      $getCostCodeAliasRe = str_replace(',', ",\r", $getCostCodeAlias);
      $formattedCostCode = $formattedCostCode."\r".$getCostCodeAliasRe;
    }

    $countBids = SubcontractorBid::loadCountOfBids($database, $gc_budget_line_item_id);

    if (isset($countBids['active']) && $countBids['active'] > 0) {
      $bidRecived = '✓';
      $bidRecivedPSCV = $bidRecivedPSCV + $pscv;
    }else{
      $bidRecived = '';
    }

    $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
        $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
    $arrSubcontracts = Subcontract::loadCommittedSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $new_begindate, $enddate, $loadSubcontractsByGcBudgetLineItemIdOptions);

    if (count($arrSubcontracts) > 0) {
      $hasSubcontracts = 'C';
      $hasSubContPSCV = $hasSubContPSCV + $pscv;
      $totSubContActVal = 0;
      $vendorCmy = '';
      $count = 1;
      foreach ($arrSubcontracts as $subcontract){
        $vendor = $subcontract->getVendor();
            $vendorContactCompany = $vendor->getVendorContactCompany();
            $vendorContactCompany->htmlEntityEscapeProperties();
            $vendorCompany = $vendorContactCompany->escaped_contact_company_name;

            if(count($arrSubcontracts) == 1){
              $vendorCmy .= $vendorCompany;
            }else{
              $vendorCmy .= $count.') '.$vendorCompany;
              if(count($arrSubcontracts) != $count){
                $vendorCmy .= "\n";
              }
            }             

        $subContActVal = $subcontract->subcontract_actual_value;
        $totSubContActVal = $totSubContActVal + $subContActVal;

        $count++;
      }
      $totSubContActValFormatted = Format::formatCurrency($totSubContActVal);
      if($totSubContActVal < 0){
        $totSubContActValFormatted = Format::formatCurrency(abs($totSubContActVal));
        $totSubContActValFormatted = '('.$totSubContActValFormatted.')';
      }
      $overAlltotSubContActVal = $overAlltotSubContActVal + $totSubContActVal;

      $buyoutSavingHit = $pscv - $totSubContActVal;
      $buyoutSavingHitFormatted = Format::formatCurrency($buyoutSavingHit);
      if($buyoutSavingHit < 0){
        $buyoutSavingHitFormatted = Format::formatCurrency(abs($buyoutSavingHit));
        $buyoutSavingHitFormatted = '('.$buyoutSavingHitFormatted.')';
      }
      $totbuyoutSavingHit = $totbuyoutSavingHit + $buyoutSavingHit;
    }else{
      $hasSubcontracts = '';
      $totSubContActValFormatted = '';
      $buyoutSavingHitFormatted = '';
      $vendorCmy = '';
    }

    $sheet->setCellValue($alphas[$cnt].$index,' '.$formattedCostCode);
    if ($costCodeAlias == 'true') {
      $sheet->getStyle($alphas[$cnt].($index))->getAlignment()->setWrapText(true);
    }
    $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($verticalCenter);$cnt++;

    $sheet->setCellValue($alphas[$cnt].$index,$costCodeDescription);
    $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($verCenterLeft);$cnt++;

    $sheet->setCellValue($alphas[$cnt].$index,$pscvFormatted);
    $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($verCenterRight);$cnt++;

    $sheet->setCellValue($alphas[$cnt].$index,$bidRecived);
    $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($verticalCenter);
    $sheet->getStyle($alphas[$cnt].$index)->getFont()->setBold(true);$cnt++;

    $sheet->setCellValue($alphas[$cnt].$index,$hasSubcontracts);
    $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($verticalCenter);$cnt++;

    $sheet->setCellValue($alphas[$cnt].$index,$vendorCmy);
    $sheet->getStyle($alphas[$cnt].($index))->getAlignment()->setWrapText(true);$cnt++;

    if ($hasSubContAmt == 'true') {
      $sheet->setCellValue($alphas[$cnt].$index,$totSubContActValFormatted);
      $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($verCenterRight);$cnt++;

      $sheet->setCellValue($alphas[$cnt].$index,$buyoutSavingHitFormatted);
      $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($verCenterRight);$cnt++;
    }

    $index++;
  }

  $totalPSCVFormatted = Format::formatCurrency($totalPSCV);
  $overAlltotSubContActValFormatted = Format::formatCurrency($overAlltotSubContActVal);
  $totbuyoutSavingHitFormatted = Format::formatCurrency($totbuyoutSavingHit);

  $bidRecivedPercentage = round((($bidRecivedPSCV / $totalPSCV) * 100),2).'%';
  $contractedPercentage = round((($hasSubContPSCV / $totalPSCV) * 100),2).'%';

  $sheet->setCellValue('D6',$bidRecivedPercentage);
  $sheet->getStyle('D6')->applyFromArray($styleCenter);
  $sheet->getStyle('D6')->getFont()->setBold(true);

  $sheet->setCellValue('E6',$contractedPercentage);
  $sheet->getStyle('E6')->applyFromArray($styleCenter);
  $sheet->getStyle('E6')->getFont()->setBold(true);

  $cnt = 0;

  $sheet->setCellValue($alphas[$cnt].$index,'TOTAL'); 
  $merge->mergeCells('A'.$index.':B'.$index);
  $sheet->getStyle($alphas[$cnt].($index))->applyFromArray($styleRight);
  $sheet->getStyle($alphas[$cnt].($index))->getFont()->setBold(true);
  $cnt = $cnt + 2;

  $sheet->setCellValue($alphas[$cnt].$index,$totalPSCVFormatted);
  $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($styleRight);
  $sheet->getStyle($alphas[$cnt].($index))->getFont()->setBold(true);
  $cnt = $cnt + 3;

  if ($hasSubContAmt == 'true') {
    $cnt++;
    $sheet->setCellValue($alphas[$cnt].$index,$overAlltotSubContActValFormatted);
    $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($styleRight);
    $sheet->getStyle($alphas[$cnt].($index))->getFont()->setBold(true);$cnt++;

    $sheet->setCellValue($alphas[$cnt].$index,$totbuyoutSavingHitFormatted);
    $sheet->getStyle($alphas[$cnt].$index)->applyFromArray($styleRight);
    $sheet->getStyle($alphas[$cnt].($index))->getFont()->setBold(true);
  }

  $sheet->getStyle("A6:".$alphas[$cnt].$index)->applyFromArray($BStyle);

}else{
  $merge->mergeCells('A'.$index.':'.$eChar.$index);
  $sheet->setCellValue('A'.$index,"No Data Available");
  $sheet->getRowDimension($index)->setRowHeight(40);
  $sheet->getStyle('A'.$index)->applyFromArray($verticalCenter);
  $sheet->getStyle('A'.$index.':'.$eChar.$index)->applyFromArray($BStyle);
  $sheet->getStyle('A'.$index)->applyFromArray($styleCenter);
}
?>

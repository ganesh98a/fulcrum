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
$objPHPExcel->getProperties()->setCreator("A.Ganeshkumar");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 Xlsx, generated using PHP classes.");

$objPHPExcel->setActiveSheetIndex(0);
$index=1;
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
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':F'.($index));

} else {
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':F'.$index);
  $objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleCenter);
}
/*cell content*/
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index),$type_mention);

/*cell font style*/
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getFont()->setSize(21);
/*cell padding*/
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);

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
$objPHPExcel->setActiveSheetIndex()->mergeCells('B'.$index.':F'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':F'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('F'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':F'.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : ".$date .' To '.$date1);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':F'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('F'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index = $index + 2;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':F'.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Committed Contracts");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setBold(true);
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Budget");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Contracted Vendor");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Subcontract Actual Value");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Execution Date");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$lastAlphaIn = $alphaCharIn;
$alphaCharIn=0;
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->getColor()->setRGB('FFFF');

$alphaCharIn=0;
$index++;
//Fetch committed contracts Data
$db = DBI::getInstance($database);
$db->free_result();
$loadCommittedContractsByProjectIdOptions = new Input();
$loadCommittedContractsByProjectIdOptions->forceLoadFlag = true;

$project = Project::findProjectByIdExtended($database, $project_id);    
$alias_type = $project->alias_type;

$arrCommittedContracts = GcBudgetLineItem::loadCommittedContractsByProjectId($database, $project_id, $new_begindate, $enddate ,$loadCommittedContractsByProjectIdOptions);
if(count($arrCommittedContracts) > 0){
  foreach ($arrCommittedContracts as $gc_budget_line_item_id => $budgetLineItem) {
    $costCode = $budgetLineItem->getCostCode();
    $cost_code_id = $costCode->cost_code_id;
    $costCodeDivision = $costCode->getCostCodeDivision();
    $costCodeDivision->htmlEntityEscapeProperties();
    $cost_code_division_id = $costCodeDivision->cost_code_division_id;
    $formattedCostCode = $costCode->getFormattedCostCode($database,false, $user_company_id);

    $getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_division_id);
    if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
      $getCostCodeAliasRe = str_replace(',', ",\r", $getCostCodeAlias);
      $formattedCostCode = $formattedCostCode."\r".$getCostCodeAliasRe;
    }

    $costCodeDescription = $costCode->cost_code_description;

    $scheduledValue = Format::formatCurrency($budgetLineItem->prime_contract_scheduled_value);

    $alphaCharIn = 0;
    $costCodeStart = $alphas[0].$index;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,' '.$formattedCostCode);
    if ($costCodeAlias == 'true') {
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
    }
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
    $alphaCharIn++;

    $costCodeDescStart = $alphas[1].$index;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costCodeDescription);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
    $alphaCharIn++;

    $scheduledValueStart = $alphas[2].$index;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$scheduledValue);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
    $alphaCharIn++;

    $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
    $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
    $arrSubcontracts = Subcontract::loadCommittedSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $new_begindate, $enddate, $loadSubcontractsByGcBudgetLineItemIdOptions);
    foreach ($arrSubcontracts as $subcontract) {
      // Vendor list
      $alphaCharIn = 3;
      $vendor = $subcontract->getVendor();
      $vendorContactCompany = $vendor->getVendorContactCompany();
      /* @var $vendorContactCompany ContactCompany */
      $vendorContactCompany->htmlEntityEscapeProperties();
      $vendorCompany = $vendorContactCompany->escaped_contact_company_name;
      $subcontractActualValue = $subcontract->subcontract_actual_value;
      $subcontractActualValueFormatted = Format::formatCurrency(abs($subcontractActualValue));
      if($subcontractActualValue < 0){
        $subcontractActualValueFormatted = '('.$subcontractActualValueFormatted.')';
      }
      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorCompany);
      $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
      $alphaCharIn++;

      $costCodeEnd = $alphas[0].$index;
      $costCodeDescEnd = $alphas[1].$index;
      $scheduledValueEnd = $alphas[2].$index;
      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subcontractActualValueFormatted);
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleRight);
      $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
      $alphaCharIn++;

      $executionDate = $subcontract->subcontract_execution_date;
      if ($executionDate != '0000-00-00') {
        $execution_date = date("m/d/Y", strtotime($executionDate));
      }else{
        $execution_date = '';
      }

      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$execution_date);
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleRight);
      $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);

      $index++;
    }
    if ($costCodeAlias == 'false') {
      $objPHPExcel->setActiveSheetIndex()->mergeCells($costCodeStart.':'.$costCodeEnd);
    }
    $objPHPExcel->getActiveSheet()->getStyle($costCodeStart)->applyFromArray($styleVerticalCenter);
    $objPHPExcel->setActiveSheetIndex()->mergeCells($costCodeDescStart.':'.$costCodeDescEnd);
    $objPHPExcel->getActiveSheet()->getStyle($costCodeDescStart)->applyFromArray($styleVerticalCenter);
    $objPHPExcel->setActiveSheetIndex()->mergeCells($scheduledValueStart.':'.$scheduledValueEnd);
    $objPHPExcel->getActiveSheet()->getStyle($scheduledValueStart)->applyFromArray($styleVerticalCenter);
  }
}else{
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':F'.$index);
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available");
  $objPHPExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray($styleCenter);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(10);
}
// exit;
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':F'.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Uncommitted Contracts");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setBold(true);
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Budget");
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
$lastAlphaIn = $alphaCharIn;
$alphaCharIn=0;
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->getColor()->setRGB('FFFF');

$alphaCharIn=0;
$index++;
//Fetch uncommitted contracts Data
$loadUncommittedContractsByProjectIdOptions = new Input();
$loadUncommittedContractsByProjectIdOptions->forceLoadFlag = true;

$arrUncommittedContracts = GcBudgetLineItem::loadUnCommittedContractsByProjectId($database, $project_id, $loadUncommittedContractsByProjectIdOptions);
if(count($arrUncommittedContracts) > 0){
  foreach ($arrUncommittedContracts as $gc_budget_line_item_id => $budgetLineItem) {
    $costCode = $budgetLineItem->getCostCode();
    $cost_code_id = $costCode->cost_code_id;
    $costCodeDivision = $costCode->getCostCodeDivision();
    $costCodeDivision->htmlEntityEscapeProperties();
    $cost_code_division_id = $costCodeDivision->cost_code_division_id;
    $formattedCostCode = $costCode->getFormattedCostCode($database,false, $user_company_id);

    $getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_division_id);
    if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAlias == 'true') {
      $getCostCodeAliasRe = str_replace(',', ",\r", $getCostCodeAlias);
      $formattedCostCode = $formattedCostCode."\r".$getCostCodeAliasRe;
    }

    $costCodeDescription = $costCode->cost_code_description;

    $scheduledValue = $budgetLineItem->prime_contract_scheduled_value;
    $scheduledValueFormatted = Format::formatCurrency(abs($scheduledValue));
    if($scheduledValue < 0){
      $scheduledValueFormatted = '('.$scheduledValueFormatted.')';
    }
    $alphaCharIn = 0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,' '.$formattedCostCode);
    if ($costCodeAlias == 'true') {
      $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
    }
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
    $alphaCharIn++;

    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costCodeDescription);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
    $alphaCharIn++;

    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$scheduledValueFormatted);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setSize(10);
    $alphaCharIn++;

    $index++;
  }
}else{
  $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':F'.$index);
  $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available");
  $objPHPExcel->getActiveSheet()->getStyle('A'.$index)->applyFromArray($styleCenter);
  $objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getFont()->setSize(10);
}

?>

<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');




//Get the session projectid & company id
$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$user_company_id = $session->getUserCompanyId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$db = DBI::getInstance($database);
$db->free_result();
$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdReport($database, $project_id);
$gcBudgetLineItemsTbody='';
$loopCounter=1;
$tabindex=0;
$tabindex2=0;


/*Initialize PHPExcel Class*/
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica')->setSize(12);
$objPHPExcel->getProperties()->setCreator("Suganthidevi . N");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 Xlsx, generated using PHP classes.");

$objPHPExcel->setActiveSheetIndex(0);
$index=1;
$signature=$fulcrum;
// $objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(30);
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
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleRight);
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':D'.($index));
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
// $index = $index + 2;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"PROJECT : ".$project_name);
if($add_val!=''){
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$index,"ADDRESS : ".$add_val); 
}else{
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$index,""); 
}
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('C'.$index.':D'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('D'.($index))->applyFromArray($styleRight);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':D'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('D'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':D'.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : ".$date .' To '.$date1);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':D'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;
/*content*/
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"CostCode");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Subcontractor");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Supplier");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Received Date");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

$lastAlphaIn = $alphaCharIn;
$alphaCharIn = 0;
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':D'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':D'.$index)->getFont()->getColor()->setRGB('FFFF');
$index++;
//cost code divider
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
$budget = GcBudgetLineItem::getprelimbudget($database, $project_id);

foreach ($budget as $key => $bval) {

  $costcodeabb = $bval['division_number'].$costCodeDividerType.$bval['cost_code'];
  $cost_code_description = $bval['cost_code_description'];
  $subcontractor_id = rtrim($bval['subcontractor_id'],',');
  $alphaCharIn = 0;

  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costcodeabb);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->getColor()->setRGB('2481c3');
  $alphaCharIn++;
  $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cost_code_description);
  $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->getColor()->setRGB('2481c3');
  $alphaCharIn++;
  $index++;


  $subcontract = GcBudgetLineItem::getprelimsubcontractor($database,$subcontractor_id);

  foreach ($subcontract as $key => $sval) {
    $company = $sval['company'];
    $sub_id = $sval['sub_id'];
    $alphaCharIn =1;

    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$company);

    $prelim = GcBudgetLineItem::getprelimDataforsubcontractor($database,$sub_id);

    foreach ($prelim as $key => $pvalue) {

      $supplier = $pvalue['supplier'];
      $received_date = strtotime($pvalue['received_date']);
       $formattedreceived_date = date("m/d/Y", $received_date);
      $alphaCharIn =2;

      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$supplier);
      $alphaCharIn++;
      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedreceived_date);
      $alphaCharIn++;
      $index++;
    }

  }
}

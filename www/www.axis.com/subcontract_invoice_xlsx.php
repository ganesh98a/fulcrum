<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('app/models/subcontract_invoice_model.php');
require_once('module-report-ajax.php');


// require_once('lib/common/WeatherUndergroundConditionLabel.php');
// require_once('lib/common/WeatherUndergroundMeasurement.php');
// require_once('lib/common/WeatherUndergroundReportingStation.php');
// require_once('lib/common/JobsiteDailyLog.php');
// require_once('lib/common/JobsiteManPower.php');
// require_once('lib/common/JobsiteNote.php');
// require_once('lib/common/JobsiteNoteType.php');
// require_once('lib/common/JobsiteInspection.php');
// require_once('lib/common/Subcontract.php');
// require_once('lib/common/FileManager.php');
// require_once('lib/common/JobsiteSignInSheet.php');
// require_once('lib/common/JobsiteFieldReport.php');
// require_once('lib/common/JobsitePhoto.php');
// require_once('lib/common/ContactToRole.php');
// require_once('lib/common/ProjectToContactToRole.php');
// require_once('lib/common/Role.php');
// require_once('lib/common/GcBudgetLineItem.php');
// require_once('lib/common/ContactCompanyOffice.php');
// /*RFI Functions*/
// require_once('lib/common/RequestForInformationPriority.php');
// require_once('lib/common/RequestForInformationRecipient.php');
// require_once('lib/common/RequestForInformationResponse.php');
// require_once('lib/common/RequestForInformationResponseType.php');
// require_once('lib/common/RequestForInformationStatus.php');
// require_once('lib/common/RequestForInformationType.php');
// require_once('lib/common/RequestForInformation.php');
// /*Submittal Functions*/
// require_once('lib/common/Submittal.php');
// require_once('lib/common/SubmittalDistributionMethod.php');
// require_once('lib/common/SubmittalDraftAttachment.php');
// require_once('lib/common/SubmittalPriority.php');
// require_once('lib/common/SubmittalRecipient.php');
// require_once('lib/common/SubmittalStatus.php');
// require_once('lib/common/SubmittalType.php');
// /*Open track function*/
// require_once('lib/common/ActionItem.php');
// require_once('lib/common/ActionItemAssignment.php');
// require_once('lib/common/ActionItemPriority.php');
// require_once('lib/common/ActionItemStatus.php');
// require_once('lib/common/ActionItemType.php');
// /*job status function include*/
// require_once('module-report-jobstatus-functions.php');
// /*changeorder function include*/
// require_once('lib/common/ChangeOrderAttachment.php');
// require_once('lib/common/ChangeOrderDistributionMethod.php');
// require_once('lib/common/ChangeOrderDraft.php');
// require_once('lib/common/ChangeOrderDraftAttachment.php');
// require_once('lib/common/ChangeOrderNotification.php');
// require_once('lib/common/ChangeOrderPriority.php');
// require_once('lib/common/ChangeOrderRecipient.php');
// require_once('lib/common/ChangeOrderResponse.php');
// require_once('lib/common/ChangeOrderResponseType.php');
// require_once('lib/common/ChangeOrderStatus.php');
// require_once('lib/common/ChangeOrderType.php');
// require_once('lib/common/ChangeOrder.php');


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
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':Q'.($index));
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
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$index,"ADDRESS : ".$add_val); 
}else{
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$index,""); 
}
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':D'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('E'.$index.':Q'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('E'.($index))->applyFromArray($styleRight);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':Q'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('E'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':Q'.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : ".$date .' To '.$date1);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':H'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;
/*content*/
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code Description");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Company");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Contract Value");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Template Name");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Rec'd");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"App#");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Period To");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Sc Amount");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Retiontion");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Invoice Total");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Supplier");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Supplier Amount");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Supplier Balance");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Contract Remaining");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Notes");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"PM Approved");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Status");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$lastAlphaIn = $alphaCharIn;
$alphaCharIn = 0;
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':Q'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':Q'.$index)->getFont()->getColor()->setRGB('FFFF');
$index++;
//Fetch the Data
        $arrSubInv = SubcontractInvoiceData($database,$project_id,$user_company_id,$filterstatus);
       
        foreach ($arrSubInv as $key => $subval) {
            $recDate=$period_to=$pm_approved="";
            if($subval['recieved_date']!="0000-00-00")
            {

                $recDateTimestamp = strtotime($subval['recieved_date']);
                $recDate = date("m/d/Y ", $recDateTimestamp);
            }
           if($subval['period_to']!="0000-00-00")
            {

                $periodToTimestamp = strtotime($subval['period_to']);
                $period_to = date("m/d/Y ", $periodToTimestamp);
            }
            if($subval['pm_approved']!="0000-00-00")
            {

                $pm_approvedTimestamp = strtotime($subval['pm_approved']);
                $pm_approved = date("m/d/Y ", $pm_approvedTimestamp);
            }
              $supparr =getPrelimsByInvoiceId($database, $key);
           
               $supplierdata ="";
               $supplierAmt ="";
         if (!empty($supparr)) {
            $supbal =0;
              foreach ($supparr as $key => $supval) {
                  $supplierdata .=$supval['supplier'].PHP_EOL ;
                  $supplierAmt .=Format::formatCurrency($supval['Amount']).PHP_EOL ;
                $supbal +=$supval['Amount'];
              }
         }
               // $supplierdata .="</table> </td>";
               // $supplierAmt.=" </td>";
               $Balance = ($subval['total'] -($subval['amount'] -$subval['retention']))-$supbal;
        $alphaCharIn = 0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subval['cost_code_abb']);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subval['company']);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,Format::formatCurrency($subval['s_subcontract_actual_value']));
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subval['subcontract_template_name']);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$recDate);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subval['application_number']);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$period_to);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,Format::formatCurrency($subval['amount']));
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,Format::formatCurrency($subval['retention']));
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,Format::formatCurrency($subval['total']));
    $alphaCharIn++;

    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)
    ->getAlignment()->setWrapText(true); 
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$supplierdata);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)
    ->getAlignment()->setWrapText(true); 
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$supplierAmt);
    $alphaCharIn++;
    
// $supplierdata;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,Format::formatCurrency($Balance));
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,Format::formatCurrency($subval['contract_remaining']));
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subval['notes']);
    $alphaCharIn++;$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$pm_approved);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subval['status']);
    $alphaCharIn++;
    $index++;
 }
if(empty($arrSubInv)){
   $alphaCharIn=0;
   $objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index);
   $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
}

<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');

require_once('lib/common/WeatherUndergroundConditionLabel.php');
require_once('lib/common/WeatherUndergroundMeasurement.php');
require_once('lib/common/WeatherUndergroundReportingStation.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once('lib/common/JobsiteManPower.php');
require_once('lib/common/JobsiteNote.php');
require_once('lib/common/JobsiteNoteType.php');
require_once('lib/common/JobsiteInspection.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/JobsiteSignInSheet.php');
require_once('lib/common/JobsiteFieldReport.php');
require_once('lib/common/JobsitePhoto.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/Role.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/ContactCompanyOffice.php');
/*RFI Functions*/
require_once('lib/common/RequestForInformationPriority.php');
require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/RequestForInformationResponse.php');
require_once('lib/common/RequestForInformationResponseType.php');
require_once('lib/common/RequestForInformationStatus.php');
require_once('lib/common/RequestForInformationType.php');
require_once('lib/common/RequestForInformation.php');
/*Submittal Functions*/
require_once('lib/common/Submittal.php');
require_once('lib/common/SubmittalDistributionMethod.php');
require_once('lib/common/SubmittalDraftAttachment.php');
require_once('lib/common/SubmittalPriority.php');
require_once('lib/common/SubmittalRecipient.php');
require_once('lib/common/SubmittalStatus.php');
require_once('lib/common/SubmittalType.php');
/*Open track function*/
require_once('lib/common/ActionItem.php');
require_once('lib/common/ActionItemAssignment.php');
require_once('lib/common/ActionItemPriority.php');
require_once('lib/common/ActionItemStatus.php');
require_once('lib/common/ActionItemType.php');
/*job status function include*/
require_once('../module-report-jobstatus-functions.php');
/*changeorder function include*/
require_once('lib/common/ChangeOrderAttachment.php');
require_once('lib/common/ChangeOrderDistributionMethod.php');
require_once('lib/common/ChangeOrderDraft.php');
require_once('lib/common/ChangeOrderDraftAttachment.php');
require_once('lib/common/ChangeOrderNotification.php');
require_once('lib/common/ChangeOrderPriority.php');
require_once('lib/common/ChangeOrderRecipient.php');
require_once('lib/common/ChangeOrderResponse.php');
require_once('lib/common/ChangeOrderResponseType.php');
require_once('lib/common/ChangeOrderStatus.php');
require_once('lib/common/ChangeOrderType.php');
require_once('lib/common/ChangeOrder.php');

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
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':I'.($index));
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
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"PROJECT : ".$project_name);
if($add_val!=''){
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$index,"ADDRESS : ".$add_val); 
}else{
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$index,""); 
}
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':E'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('F'.$index.':I'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('F'.($index))->applyFromArray($styleRight);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('F'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':I'.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : ".$date .' To '.$date1);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"#");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Source"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Type"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Category"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Begin"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"End"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Days"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Status");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Notified");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$lastAlphaIn = $alphaCharIn;
$alphaCharIn=0;
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->getColor()->setRGB('FFFF');
$index++;
//Fetch the Delay's Data
$incre_id=1;
$db = DBI::getInstance($database);
    if($RN_reportType=='Project Delay Log')
    {
        $RN_reportType="Delaylog";
        $filter= "";
    }
    else
    {
           $filter= "and source='".$RN_reportType."' ";
    }

$query = "SELECT * FROM jobsite_delay_data where is_deleted = '0' and project_id='".$RN_project_id."' and begindate between '".$RN_reportsStartDate."' and '".$RN_reportsEndDate."' $filter ";

$db->execute($query);
$records = array();
while($row = $db->fetch())
{
    $records[] = $row;
}

foreach($records as $row)
{
    $delid      = $row['id'];
    $source     = $row['source'];
    $type       = $row['type'];
    $scategory  = $row['subcategory'];
    $bdate      = $row['begindate'];
    $edate      = $row['enddate'];
    $days       = $row['days'];
    $notes      = $row['notes'];
    $status     = $row['status'];
    $notified   = $row['notified'];
    $action     = $row['action'];

    $db1 = DBI::getInstance($database);
    $query1 = "SELECT * FROM jobsite_delay_category_templates WHERE id='$type'";
    $query2 = "SELECT * FROM jobsite_delay_subcategory_templates WHERE id='$scategory'";
    $query3 = "SELECT * FROM jobsite_delay_logs_status WHERE id='$status'"; 
    $query4 = "SELECT * FROM jobsite_delay_logs_notified WHERE id='$notified'"; 

    $db1->execute($query1);
    while ($row1 = $db1->fetch()) 
    {
        $cattype = $row1['jobsite_delay_category'];
    }
    $db1->execute($query2);
    while ($row1 = $db1->fetch()) 
    {
        $subact = $row1['jobsite_delay_subcategory'];
    }
    if($status == '1'){
        $delayStaus = 'Pending';
    }else if($status == '2'){
        $delayStaus =   'Notify';
    }else if($status == '3'){
        $delayStaus = 'Claim';
    }else{
        $delayStaus = '';
    }

    if($notified == '1'){
        $delayNotify = 'Yes';
    }else if($notified == '2'){
        $delayNotify =  'No';
    }else{
        $delayNotify = '';
    }

    if($days == ''){
        $fromDate = strtotime($bdate);
        $toDate = strtotime($edate);
        $dateDiff = ($toDate - $fromDate) +1;
        $days =  floor($dateDiff / (60 * 60 * 24));

    }



    if($bdate == '0000-00-00')
    {
        $formattedDelaybdate = '';
    }else{
        $formattedDelaybdate = date("m/d/Y", strtotime($bdate));
    }
    if($edate == '0000-00-00')
    {
        $formattedDelayedate = '';
    }
    else{
        $formattedDelayedate = date("m/d/Y", strtotime($edate));
    }
    $alphaCharIn=0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$incre_id); 
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$source); 
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$cattype); 
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subact); 
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedDelaybdate); 
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedDelayedate); 
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$days); 
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$delayStaus);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$delayNotify);
    $alphaCharIn=0;
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('CBCBCB');
    $alphaCharIn = 2;
    $index++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Notes :");
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setBold(true);
    $alphaCharIn = 3;
    $objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index);
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$notes);
    $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
    $incre_id++;
    $index++;
}

if($incre_id == 1){
   $alphaCharIn=0;
   $objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index);
   $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's not Available");
}


/*$filename = urlencode($type_mention)."-".$dates.":".$i.":".$s.".xlsx";
$filenameSheet = $type_mention;
$objPHPExcel->getActiveSheet()->setTitle($filenameSheet);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel,'Excel5');
$objWriter->save('php://output');*/
?>

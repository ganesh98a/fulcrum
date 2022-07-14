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
require_once('module-report-jobstatus-functions.php');
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
$objPHPExcel->getProperties()->setCreator("A.Ganeshkumar");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 CSV Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 CSV Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 CSV, generated using PHP classes.");

$objPHPExcel->setActiveSheetIndex(0);
$index=1;
/*$signature= 'images/logos/axis-green-white-background1.png';
if (file_exists($signature)) {
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Customer Signature');
$objDrawing->setDescription('Customer Signature');
//Path to signature .jpg file
// $signature = $reportdetails[$rowCount][$value];    
$objDrawing->setPath($signature);
$objDrawing->setOffsetX(25);                     //setOffsetX works properly
$objDrawing->setOffsetY(10);                     //setOffsetY works properly
$objDrawing->setCoordinates('B10');             //set image to cell
$objDrawing->setWidth(32);  
$objDrawing->setHeight(32);                     //signature height  
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save
} else {
$objPHPExcel->getActiveSheet()->setCellValue('B10', "Image not found" );
}*/
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Report : "); 
$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,$type_mention); 
$objPHPExcel->getActiveSheet()->setCellValue('E'.$index,"Project : "); 
$objPHPExcel->getActiveSheet()->setCellValue('F'.$index,$project_name); 
$objPHPExcel->getActiveSheet()->setCellValue('I'.$index,"Address : "); 
$objPHPExcel->getActiveSheet()->setCellValue('J'.$index,$add_val); 

$index++;
$index++;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"#"); 
$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,"Source"); 
$objPHPExcel->getActiveSheet()->setCellValue('C'.$index,"Type"); 
$objPHPExcel->getActiveSheet()->setCellValue('D'.$index,"Category"); 
$objPHPExcel->getActiveSheet()->setCellValue('E'.$index,"Begin"); 
$objPHPExcel->getActiveSheet()->setCellValue('F'.$index,"End"); 
$objPHPExcel->getActiveSheet()->setCellValue('G'.$index,"Days"); 
$objPHPExcel->getActiveSheet()->setCellValue('H'.$index,"Notes");
$objPHPExcel->getActiveSheet()->setCellValue('I'.$index,"Status");
$objPHPExcel->getActiveSheet()->setCellValue('J'.$index,"Notified");

$index++;
//Fetch the Delay's Data
    $incre_id=1;
    $db = DBI::getInstance($database);
    
    $query = "SELECT * FROM jobsite_delay_data where is_deleted = '0' and project_id='".$projectId."' and begindate between '".$new_begindate."' and '".$enddate."' and source='".$type_mention."' ";
    
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
        	$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,$incre_id); 
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,$source); 
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$index,$cattype); 
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$index,$subact); 
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$index,$formattedDelaybdate); 
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$index,$formattedDelayedate); 
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$index,$days); 
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$index,$notes);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$index,$delayStaus);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$index,$delayNotify);
		
		    $incre_id++;
	        $index++;
}

    if($incre_id == 1){
  		$objPHPExcel->getActiveSheet()->setCellValue('D'.$index,"Data's Not Available"); 
	 }

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

$objWriter->save('php://output');
?>
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
require_once('module-report-ajax.php');


/*Initialize PHPExcel Class*/
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("A.Ganeshkumar");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 CSV Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 CSV Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 CSV, generated using PHP classes.");

$objPHPExcel->setActiveSheetIndex(0);
$index=1;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Report : "); 
$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,$type_mention); 
$objPHPExcel->getActiveSheet()->setCellValue('D'.$index,"Project : "); 
$objPHPExcel->getActiveSheet()->setCellValue('E'.$index,$project_name); 
$objPHPExcel->getActiveSheet()->setCellValue('H'.$index,"Address : "); 
$objPHPExcel->getActiveSheet()->setCellValue('I'.$index,$add_val); 

$index++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : "); 
$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,  $date .' To '.$date1); 
$index++;
$index++;
/*Alphabets A to Z*/
$alphas = range('A', 'Z');
$alphaCharIn = 0;


    // to get the project start date
    $db = DBI::getInstance($database);
    $query ="Select * from projects where id='".$project_id."'";
    $db->execute($query);
    $start_date='';
    while($row = $db->fetch())
    {
        $start_date_full= $row['project_start_date'];
        $start_date_arr=explode(' ', $start_date_full);
        $start_date=$start_date_arr[0];
    }
    $dateObj1 = DateTime::createFromFormat('Y-m-d', $start_date);
    $date = $dateObj1->format('m/d/Y');
    
    $today=date('Y-m-d');
    $date1=date('m/d/Y');

    //To get the total number of days
    $tdate1 = new DateTime($start_date);
    $tdate2 = new DateTime($today);
    $diff = $tdate2->diff($tdate1)->format("%a");
    $query ="SELECT jdl.* FROM `jobsite_daily_logs` jdl WHERE jdl.`project_id` = '".$project_id."' AND jdl.`jobsite_daily_log_created_date` between '".$start_date."' and '".$today."'";
    $db->execute($query);
    $jobsite_daily_log_id=array();
    while ($row = $db->fetch()) {
     $jobsite_daily_log_id[] = $row['id'];
    }
    // To get the name of the company
       $query_comp ="SELECT `company` FROM `contact_companies` WHERE contact_user_company_id = '".$user_company_id."' ";
    $db->execute($query_comp);
    $company=array();
    
    while($row = $db->fetch()){
     $company = $row['company'];
    }
    $man_power_Excluding_adv=buildManpowerSectionCountExcluding($database, $user_company_id, $project_id, $jobsite_daily_log_id,$company);
    $man_power_count=$man_power_Excluding_adv['TotalManPower'];
    if($man_power_count=='')
    {
        $man_power_count='0';
    }
    $man_days=$man_power_count*8;
    $manPowerExcludingAdvent=$man_power_Excluding_adv['otherCompanyManPower'];
    $manPowerExcludingAdventDays=$manPowerExcludingAdvent*8;

    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date :");
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$date.' To '. $date1);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Total Days : ");
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$diff);
    $alphaCharIn=0;
    $index++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"TOTAL MAN DAYS");
     $index++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Total Man Days (Including ".$company." employees)");
     $alphaCharIn++;
     $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$man_power_count);
     $index++;
     $alphaCharIn=0;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Total Man Days (Excluding ".$company." employees)");
     $alphaCharIn++;
     $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$manPowerExcludingAdventDays);
// exit;
// $objPHPExcel->getActiveSheet()->setTitle('Simplesfs');    
// Save Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

$objWriter->save('php://output');
?>
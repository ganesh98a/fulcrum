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
/*Weather section*/
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"WEATHER");
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index+2),"AM Temperature");
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index+3),"AM Condition");
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index+4),"PM Temperature");
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index+5),"PM Condition");

$alphaCharIn++;
$index++;
$begin=new DateTime($date);
$end=new DateTime($date1);
$end = $end->modify( '+1 day' ); 

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ( $period as $dt )
{

    $display_date = $dt->format("m/d/Y");
    $created_date = $dt->format("Y-m-d");
    $WeekDay=date('l', strtotime($created_date));

    $arrReturn = getAmPmWeatherTemperaturesAndConditions($database, $project_id, $created_date);
    $amTemperature = $arrReturn['amTemperature'];
    $amCondition   = $arrReturn['amCondition'];
    $pmTemperature = $arrReturn['pmTemperature'];
    $pmCondition   = $arrReturn['pmCondition'];
    /*Date of weather*/
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$WeekDay.'- '.$display_date);
    /*AM Temperature of weather*/
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index+1),$amTemperature);
    /*AM condition of weather*/
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index+2),$amCondition);
    /*PM Temperature of weather*/
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index+3),$pmTemperature);
    /*PM condition of weather*/
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index+4),$pmCondition);

$alphaCharIn++;
}
$index = $index + 7;
$alphaCharIn = 0;

/*Schedule Delays*/ 
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"SCHEDULE DELAYS");
$index = $index + 2;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Date");
$objPHPExcel->getActiveSheet()->setCellValue('B'.$index,"Category");
$objPHPExcel->getActiveSheet()->setCellValue('C'.$index,"Type");
$objPHPExcel->getActiveSheet()->setCellValue('D'.$index,"Description");
$index++;
$incre_id=1;
$db = DBI::getInstance($database);
$query = "SELECT * FROM jobsite_delay_data where is_deleted = '0' and project_id='".$projectId."' and begindate between '".$new_begindate."' and '".$enddate."'";
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
        $beginWeekDay='';
    }else{
        $formattedDelaybdate = date("m/d/Y", strtotime($bdate));
        $beginWeekDay=date('l', strtotime($bdate));

    }
    if($edate == '0000-00-00')
    {
        $formattedDelayedate = '';
    }
    else{
        $formattedDelayedate = date("m/d/Y", strtotime($edate));
    }
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,$beginWeekDay.",".   
    $formattedDelaybdate);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$index,$cattype);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$index,$subact);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$index,$notes);
    $index++;
    $incre_id++;
}
if(empty($records)){
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Data's not Available");
}
$index = $index + 2;
/*Manpower Activity*/
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"MANPOWER ACTIVITY");
$index = $index + 2;
$maxDays=7;
$arrayManValue=array();
$arrayManDate=array();
$arrayManComp=array();
$count='1';
$session = Zend_Registry::get('session');
/* @var $session Session */
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
for($inday=0;$inday<$maxDays;$inday++){
     $sub_count='1';
    $datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
    $jobsite_daily_log_id = '';
    $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);
    if ($jobsiteDailyLog) {
       $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    }
     // echo '<br>'.$jobsite_daily_log_id.' - '.$datestep;
    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
    //$arrVendorIds = $arrReturn['vendor_ids'];
    $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
    $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
    $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];

    $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);
    $totalnumber_of_people=0;
    // echo '<pre>';
    // print_r($arrSubcontractsByProjectId);
    foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        /* @var $subcontract Subcontract */

        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        $costCode = $gcBudgetLineItem->getCostCode();
        /* @var $costCode CostCode */

        $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode();

        $vendor = $subcontract->getVendor();
        /* @var $vendor Vendor */

        $vendor_id = $vendor->vendor_id;

        $contactCompany = $vendor->getVendorContactCompany();
        /* @var $contactCompany ContactCompany */

        $contact_company_name = $contactCompany->contact_company_name;
        if(empty($arrReturn))
        $number_of_people = '';
        else
        $number_of_people = 0;
        if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {
            $jobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];
            /* @var $jobsiteManPower JobsiteManPower */
            $number_of_people = $jobsiteManPower->number_of_people;
            $uniqueId = $jobsiteManPower->jobsite_man_power_id;

            $attributeGroupName = 'manage-jobsite_man_power-record';
            $onchange = 'Daily_Log__ManPower__updateJobsiteManPower(this);';
        } else {
            $jobsiteManPower = JobsiteManPower::findByJobsiteDailyLogIdAndSubcontractId($database, $jobsite_daily_log_id, $subcontract_id);
            /* @var $jobsiteManPower JobsiteManPower */

            if ($jobsiteManPower) {
                $number_of_people = $jobsiteManPower->number_of_people;
                $uniqueId = $jobsiteManPower->jobsite_man_power_id;
            } else {
                $number_of_people = '';
                $uniqueId = $jobsite_daily_log_id.'-'.$subcontract_id;
            }

            $attributeGroupName = 'create-jobsite_man_power-record';
            $onchange = "Daily_Log__ManPower__createJobsiteManPower('$attributeGroupName', '$uniqueId');";
        }

        $totalnumber_of_people +=$number_of_people;
       
    $WeekDay=date('l', strtotime($datestep));
    $begindate = DateTime::createFromFormat('Y-m-d', $datestep);
    $manDate = $begindate->format('m/d/Y');
 if($number_of_people==0)
    $number_of_people='';
    if($typemention=="PDF"){
    $WeekDay=date('D', strtotime($datestep));
    $begindate = DateTime::createFromFormat('Y-m-d', $datestep);
    $manDate = $begindate->format('m/d');
    }
$arrayManComp[$sub_count][0]=$contact_company_name.'-'.$htmlEntityEscapedFormattedCostCode;
$arrayManValue[$sub_count][0]='';
$arrayManValue[$sub_count][$count]=$number_of_people;
$arrayManDate[$count]=$WeekDay.','.$manDate;

$sub_count++;
    }
 $count++;

 }
 $array_count=count($arrayManValue);
 $date_count=count($arrayManDate);
 $CheckTableValue=1;
 $arrayChek=array();
$checkNull='';
foreach($arrayManValue as $indexs=>$value)
{
    $value=array_filter($arrayManValue[$indexs]);
    foreach($arrayManValue[$indexs] as $index1 => $value1)
    {
        $JoinArray='';
        $JoinArray .=$arrayChek[$index1];
        $JoinArray .=$arrayManValue[$indexs][$index1];
        $arrayChek[$index1]=$JoinArray;
        $checkNull .= $arrayManValue[$indexs][$index1];
    }
}


$alphas = range('A', 'Z');

$alphaCharIn = 0;
$valueCheck = $alphaCharIn / 25;
if($checkNull!=''){
for($datei=1;$datei<=$date_count;$datei++)
{
    if($datei==1)
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Company"); 

    $value_explode=explode(',',$arrayManDate[$datei]);
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn+1].$index,$value_explode[0]." - ".$value_explode[1]); 

    if($datei==$date_count)
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn+2].$index,"WEEK TOTAL"); 

$alphaCharIn++;
}
$index++;
$weekTotalcol=0;
$colTotal=0;
$coltotalarray=array();
$colcount=1;
for($valuei=1;$valuei<=$array_count;$valuei++){
$row_total='';
$alphaCharIn=0;
$valueinarraycount=count($arrayManValue[$valuei]);
for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
    if($invaluei!=0){
        if($arrayChek[$invaluei]==''){
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"");
        }else{
            if($arrayManValue[$valuei][$invaluei]=='')
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,""); 
            else
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$arrayManValue[$valuei][$invaluei]);
        }
    }else{
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$arrayManComp[$valuei][$invaluei]); 
    }

    if($invaluei!=0){
        $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
        if($arrayManValue[$valuei][$invaluei]!='')
        $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
    }
    $alphaCharIn++;
}
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$row_total);
$weekTotalcol=$weekTotalcol+$row_total;
$coltotalarray[$invaluei]=$weekTotalcol;
$index++;
}
$counttotalValue=count($coltotalarray);
$alphaCharIn=0;
for($invaluet=1;$invaluet<=$counttotalValue;$invaluet++){
    if($invaluet==1)
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DAY TOTAL"); 
    if($arrayChek[$invaluet]!='')    
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn+1].$index,$coltotalarray[$invaluet]); 
    else{
        if($invaluet==$counttotalValue)
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn+1].$index,$coltotalarray[$invaluet]); 
        else
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn+1].$index,"");
    }
$alphaCharIn++;
}

}
$alphaCharIn=0;
if($counttotalValue==0){
 $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Manpower efforts involved");
$CheckTableValue=0;
}
$alphaCharIn=0;
$index = $index + 2;
/*SITEWork Activity*/
//get the data's from table for sitework section
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SITEWORK ACTIVITY");
$index++;
$jobsiteDailyLog = findByProjectIdAndJobsiteDailyLogModifiedSite($database, $project_id, $new_begindate, $enddate);
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$jobsiteDailyLog);

$alphaCharIn=0;
$index = $index + 2;
/*Building Activity */
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"BUILDING ACTIVITY");
$index++;
//get the data's from table for building section
$jobsiteDailyBuild = findByProjectIdAndJobsiteDailyLogModifiedBuild($database, $project_id, $new_begindate, $enddate);
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$jobsiteDailyBuild);

$alphaCharIn=0;
$index = $index + 2;
/*Inspection*/
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"INSPECTIONS");
$alphaCharIn=0;
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Type");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$alphaCharIn=0;
$index++;
$db = DBI::getInstance($database);
    $query ="SELECT jdl.*,jdoal_fk_joa.*,jdty.*,jdtno.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_inspections` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_inspection_types` jdty ON jdty.id = jdoal_fk_joa.jobsite_inspection_type_id INNER JOIN `jobsite_inspection_notes` jdtno ON jdtno.jobsite_inspection_id = jdoal_fk_joa.id WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$new_begindate' AND '$enddate'";
    
    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        $alphaCharIn=0;
        // $records[] = $row;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $type=$row['jobsite_inspection_type'];
        $desc=$row['jobsite_inspection_note'];
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$type);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
        $index++;
    }
    $alphaCharIn=0;
    $db->free_result();
    if(empty($records)){
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
   }
$index = $index + 2;

/*SWPPP NOTES */
$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SWPPP NOTES");
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$alphaCharIn=0;
$index++;

$type_id = 4;

 $db = DBI::getInstance($database);
 $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.jobsite_note_type_id = jbta.id WHERE jdl.`project_id` = $project_id AND jbta.id = $type_id AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        $alphaCharIn=0;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $desc=$row['jobsite_note'];
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
        $index++;
    }
    $db->free_result();
    $alphaCharIn=0;
    if(empty($records)){
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
   }
$index = $index + 2;
$alphaCharIn=0;
/*Other NOTES */
$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"OTHER NOTES");
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$alphaCharIn=0;
$index++;

$type_id = 1;

 $db = DBI::getInstance($database);
 $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.jobsite_note_type_id = jbta.id WHERE jdl.`project_id` = $project_id AND jbta.id = $type_id AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        $alphaCharIn=0;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $desc=$row['jobsite_note'];
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
        $index++;
    }
    $db->free_result();
    $alphaCharIn=0;
    if(empty($records)){
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
   }
$index = $index + 2;
$alphaCharIn=0;
/*Visitors NOTES */
$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Visitors");
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$alphaCharIn=0;
$index++;

$type_id = 3;

 $db = DBI::getInstance($database);
 $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.jobsite_note_type_id = jbta.id WHERE jdl.`project_id` = $project_id AND jbta.id = $type_id AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        $alphaCharIn=0;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $desc=$row['jobsite_note'];
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
        $index++;
    }
    $db->free_result();
    $alphaCharIn=0;
    if(empty($records)){
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
   }
$index = $index + 2;
$alphaCharIn=0;
/*Delivery NOTES */
$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DELIVERIES");
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$alphaCharIn=0;
$index++;

$type_id = 5;

 $db = DBI::getInstance($database);
 $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.jobsite_note_type_id = jbta.id WHERE jdl.`project_id` = $project_id AND jbta.id = $type_id AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        $alphaCharIn=0;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $desc=$row['jobsite_note'];
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
        $index++;
    }
    $db->free_result();
    $alphaCharIn=0;
    if(empty($records)){
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
   }
$index = $index + 2;
$alphaCharIn=0;
/*Safety issues */
$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SAFETY ISSUES");
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$alphaCharIn=0;
$index++;

$type_id = 2;

 $db = DBI::getInstance($database);
 $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.jobsite_note_type_id = jbta.id WHERE jdl.`project_id` = $project_id AND jbta.id = $type_id AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        $alphaCharIn=0;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $desc=$row['jobsite_note'];
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
        $index++;
    }
    $db->free_result();
    $alphaCharIn=0;
    if(empty($records)){
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
   }
$index = $index + 2;
$alphaCharIn=0;
/*extra work */
$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"EXTRA WORK");
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$alphaCharIn=0;
$index++;

$type_id = 6;

 $db = DBI::getInstance($database);
 $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.jobsite_note_type_id = jbta.id WHERE jdl.`project_id` = $project_id AND jbta.id = $type_id AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        $alphaCharIn=0;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $desc=$row['jobsite_note'];
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
        $index++;
    }
    $db->free_result();
    $alphaCharIn=0;
    if(empty($records)){
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
   }
$index = $index + 2;
$alphaCharIn=0;
// exit;
// $objPHPExcel->getActiveSheet()->setTitle('Simplesfs');    
// Save Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

$objWriter->save('php://output');
?>
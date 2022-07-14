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
$maxDays=date('t',strtotime($new_begindate));
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

        //$onchange = "setTimeoutForSaveJobsiteManPower('manage-jobsite_man_power-record', '$uniqueId');";
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
/*Store the value as view the data in format*/
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

// echo ceil($valueCheck);
$valvalueCheck = 0;
if($checkNull!=''){
for($datei=1;$datei<=$date_count;$datei++)
{
    $valueCheck = $alphaCharIn / 25;
    $valueCheck = ceil($valueCheck);
    if($valueCheck > 1){
        $valvalueCheck = $valueCheck;
        if($alphaCharIn!=0)
        $alphaCharIn=0;
    }
    if($valvalueCheck > 1){        
        $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn].$index;
    }else{
        $indexVal = $alphas[$alphaCharIn].$index;
    }
    if($datei==1){
	$objPHPExcel->getActiveSheet()->setCellValue($indexVal,"Company"); 
    $alphaCharIn++;
    }
    if($valvalueCheck > 1){        
        $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn].$index;
    }else{
        $indexVal = $alphas[$alphaCharIn].$index;
    }
    $value_explode=explode(',',$arrayManDate[$datei]);
   	$objPHPExcel->getActiveSheet()->setCellValue($indexVal,$value_explode[0]." - ".$value_explode[1]); 

    if($datei==$date_count)
    	$objPHPExcel->getActiveSheet()->setCellValue($indexVal,"Month TOTAL"); 

$alphaCharIn++;
}
$index++;
$weekTotalcol=0;
$colTotal=0;
$coltotalarray=array();
$colcount=1;
for($valuei=1;$valuei<=$array_count;$valuei++){
$valueCheck=0;
$row_total='';
$alphaCharIn=0;
$valvalueCheck=0;
$valueinarraycount=count($arrayManValue[$valuei]);
for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
    $valueCheck = $alphaCharIn / 25;
    $valueCheck = ceil($valueCheck);
    if($valueCheck > 1){
        $valvalueCheck = $valueCheck;
        if($alphaCharIn!=0)
        $alphaCharIn=0;
    }
    if($valvalueCheck > 1){        
        $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn].$index;
    }else{
        $indexVal = $alphas[$alphaCharIn].$index;
    }
     if($invaluei!=0){
        if($arrayChek[$invaluei]==''){
            $objPHPExcel->getActiveSheet()->setCellValue($indexVal,"");
        }else{
            if($arrayManValue[$valuei][$invaluei]=='')
        	$objPHPExcel->getActiveSheet()->setCellValue($indexVal,""); 
            else
            	$objPHPExcel->getActiveSheet()->setCellValue($indexVal,$arrayManValue[$valuei][$invaluei]);
        }
    }else{
        $objPHPExcel->getActiveSheet()->setCellValue($indexVal,$arrayManComp[$valuei][$invaluei]); 
    }

    if($invaluei!=0){
        $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
        if($arrayManValue[$valuei][$invaluei]!='')
        $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
    }
    $alphaCharIn++;
}
if($valvalueCheck > 1){        
        $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn-1].$index;
    }else{
        $indexVal = $alphas[$alphaCharIn-1].$index;
    }
$objPHPExcel->getActiveSheet()->setCellValue($indexVal,$row_total);
$weekTotalcol=$weekTotalcol+$row_total;
$coltotalarray[$invaluei]=$weekTotalcol;
$index++;
}
$counttotalValue=count($coltotalarray);
$valueCheck=0;
$alphaCharIn=0;
$valvalueCheck=0;
for($invaluet=1;$invaluet<=$counttotalValue;$invaluet++){
    $valueCheck = $alphaCharIn / 25;
    $valueCheck = ceil($valueCheck);
    if($valueCheck > 1){
        $valvalueCheck = $valueCheck;
        if($alphaCharIn!=0)
        $alphaCharIn=0;
    }
    if($valvalueCheck > 1){        
        $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn].$index;
    }else{
        $indexVal = $alphas[$alphaCharIn].$index;
    }
    if($invaluet==1){
    $objPHPExcel->getActiveSheet()->setCellValue($indexVal,"DAY TOTAL");
    $alphaCharIn++;
    }
    if($valvalueCheck > 1){        
        $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn].$index;
    }else{
        $indexVal = $alphas[$alphaCharIn].$index;
    }
    if($arrayChek[$invaluet]!='')    
    $objPHPExcel->getActiveSheet()->setCellValue($indexVal,$coltotalarray[$invaluet]);
    else{
        if($invaluet==$counttotalValue){
             if($valvalueCheck > 1){        
                $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn-1].$index;
             }else{
                 $indexVal = $alphas[$alphaCharIn-1].$index;
            }
         	$objPHPExcel->getActiveSheet()->setCellValue($indexVal,$coltotalarray[$invaluet]); 
        }
        else
            $objPHPExcel->getActiveSheet()->setCellValue($indexVal,"");
    }
$alphaCharIn++;
}
}
$alphaCharIn=0;
if($counttotalValue==0){
 $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Manpower efforts involved");
// $valuehtml.="<tr><td colspan=".($maxDays+2).">No Manpower efforts involved</td>";
$CheckTableValue=0;
}
$objPHPExcel->getActiveSheet()->setTitle('Simplesfs');    
// Save Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

$objWriter->save('php://output');
?>
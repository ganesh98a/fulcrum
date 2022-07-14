<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('module-report-ajax.php');



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
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':D'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('E'.$index.':I'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('I'.($index))->applyFromArray($styleRight);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('I'.($index))->getAlignment()->setIndent(1);
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
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"WEATHER");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index+2),"AM Temperature");
$objPHPExcel->getActiveSheet()->getColumnDimension('A'.($index+2))->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index+3),"AM Condition");
$objPHPExcel->getActiveSheet()->getColumnDimension('A'.($index+3))->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index+4),"PM Temperature");
$objPHPExcel->getActiveSheet()->getColumnDimension('A'.($index+4))->setAutoSize(true);
$objPHPExcel->getActiveSheet()->setCellValue('A'.($index+5),"PM Condition");
$objPHPExcel->getActiveSheet()->getColumnDimension('A'.($index+5))->setAutoSize(true);


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
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

    /*AM Temperature of weather*/
    $amTemperature =html_entity_decode($amTemperature,ENT_QUOTES,'UTF-8');
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index+1),$amTemperature);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

    /*AM condition of weather*/
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index+2),$amCondition);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

    /*PM Temperature of weather*/
    $pmTemperature =html_entity_decode($pmTemperature,ENT_QUOTES,'UTF-8');
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index+3),$pmTemperature);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

    /*PM condition of weather*/
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index+4),$pmCondition);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);


    $alphaCharIn++;
}
$index = $index + 7;
$alphaCharIn = 0;

/*Schedule Delays*/ 
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"SCHEDULE DELAYS");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
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
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
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
        $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn].$index)->setAutoSize(true);

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
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,""); 
                    }
                    else
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$arrayManValue[$valuei][$invaluei]);
                        $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn].$index)->setAutoSize(true);
                    }
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
        $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn].$index)->setAutoSize(true);
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
            {
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn+1].$index,$coltotalarray[$invaluet]); 
                $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
            }
            else
            {
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn+1].$index,"");
            }
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
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index++;
$jobsiteDailyLog = findByProjectIdAndJobsiteDailyLogModifiedSite($database, $project_id, $new_begindate, $enddate);
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$jobsiteDailyLog);

$alphaCharIn=0;
$index = $index + 2;
/*Building Activity */
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"BUILDING ACTIVITY");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index++;
//get the data's from table for building section
$jobsiteDailyBuild = findByProjectIdAndJobsiteDailyLogModifiedBuild($database, $project_id, $new_begindate, $enddate);
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$jobsiteDailyBuild);

$alphaCharIn=0;
$index = $index + 2;
/*Inspection*/
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"INSPECTIONS");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$alphaCharIn=0;
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DATE");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"INSPECTION");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DESCRIPTION");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"PASSED");
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
    $passFlag=$row['jobsite_inspection_passed_flag'];
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$type);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$passFlag);
    $index++;
}
$alphaCharIn=0;
$db->free_result();
if(empty($records)){
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
}

/*SWAPP NOTES*/
$alphaCharIn=0;
$index = $index + 1;

//get the data's from table for sitework section
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SWAPP NOTES");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$alphaCharIn=0;
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DATE");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DESCRIPTION");

$alphaCharIn=0;
$index++;
$db = DBI::getInstance($database);
$query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.`jobsite_note_type_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jbta.`id` = '4' AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

$db->execute($query);
$records = array();
$recordsite = array();
$htmlInspectionData='0';
while($row = $db->fetch()){
    $records[] = $row;
    $date=$row['jobsite_daily_log_created_date'];       
    $date = DateTime::createFromFormat('Y-m-d', $date);
    $date = $date->format('m/d/Y');
    $day = date('l',strtotime($date));
    $desc=$row['jobsite_note'];
    $alphaCharIn=0;
    
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc );
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $index++;
    $htmlInspectionData="1";
}
$db->free_result();
if($htmlInspectionData=='0'){
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Data Available for Selected Dates");
    $alphaCharIn++;

}

/*Other NOTES*/
$alphaCharIn=0;
$index = $index + 1;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"OTHER NOTES");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$alphaCharIn=0;
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DATE");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"NOTE");

$alphaCharIn=0;
$index++;
$db = DBI::getInstance($database);
$query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.`jobsite_note_type_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jbta.`id` = '1' AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

$db->execute($query);
$records = array();
$recordsite = array();
$htmlInspectionData='0';
while($row = $db->fetch()){
    $records[] = $row;
    $date=$row['jobsite_daily_log_created_date'];       
    $date = DateTime::createFromFormat('Y-m-d', $date);
    $date = $date->format('m/d/Y');
    $day = date('l',strtotime($date));
    $desc=$row['jobsite_note'];
    $alphaCharIn=0;
    
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc );
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $index++;
    $htmlInspectionData="1";
    
}
$db->free_result();
if($htmlInspectionData=='0' ){
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Data Available for Selected Dates");
    $alphaCharIn++;
    
}

/*VISITORS*/
$alphaCharIn=0;
$index = $index + 1;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"VISITORS");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$alphaCharIn=0;
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DATE");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"COMMENT");

$alphaCharIn=0;
$index++;
$db = DBI::getInstance($database);
$query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.`jobsite_note_type_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jbta.`id` = '3' AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

$db->execute($query);
$records = array();
$recordsite = array();
$htmlInspectionData='';
while($row = $db->fetch()){
    $records[] = $row;
    $date=$row['jobsite_daily_log_created_date'];       
    $date = DateTime::createFromFormat('Y-m-d', $date);
    $date = $date->format('m/d/Y');
    $day = date('l',strtotime($date));
    $desc=$row['jobsite_note'];
    $alphaCharIn=0;
    
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc );
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $index++;
    $htmlInspectionData="1";
    
}
$db->free_result();
if($htmlInspectionData=='0' ){
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Data Available for Selected Dates");
    $alphaCharIn++;
    
}

/*DELIVERIES*/
$alphaCharIn=0;
$index = $index + 1;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DELIVERIES");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$alphaCharIn=0;
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DATE");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DESCRIPTION");

$alphaCharIn=0;
$index++;

$db = DBI::getInstance($database);
$query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.`jobsite_note_type_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jbta.`id` = '5' AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

$db->execute($query);
$records = array();
$recordsite = array();
$htmlInspectionData='';
while($row = $db->fetch()){
    $records[] = $row;
    $date=$row['jobsite_daily_log_created_date'];       
    $date = DateTime::createFromFormat('Y-m-d', $date);
    $date = $date->format('m/d/Y');
    $day = date('l',strtotime($date));
    $desc=$row['jobsite_note'];
    $alphaCharIn=0;
    
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc );
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $index++;
    $htmlInspectionData="1";
}
$db->free_result();
if($htmlInspectionData=='0' ){
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Data Available for Selected Dates");
    $alphaCharIn++;
    
}

/*SAFETY ISSUES*/
$alphaCharIn=0;
$index = $index + 1;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"SAFETY ISSUES");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$alphaCharIn=0;
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DATE");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DESCRIPTION");

$alphaCharIn=0;
$index++;
$db = DBI::getInstance($database);
$query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.`jobsite_note_type_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jbta.`id` = '2' AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

$db->execute($query);
$records = array();
$recordsite = array();
$htmlInspectionData='';
while($row = $db->fetch()){
    $records[] = $row;
    $date=$row['jobsite_daily_log_created_date'];       
    $date = DateTime::createFromFormat('Y-m-d', $date);
    $date = $date->format('m/d/Y');
    $day = date('l',strtotime($date));
    $desc=$row['jobsite_note'];
    $alphaCharIn=0;
    
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc );
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $index++;
    $htmlInspectionData="1";
    
}
$db->free_result();
$db->free_result();
if($htmlInspectionData=='0' ){
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Data Available for Selected Dates");
    $alphaCharIn++;
    
}

/*EXTRA WORK*/
$alphaCharIn=0;
$index = $index + 1;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"EXTRA WORK");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$alphaCharIn=0;
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DATE");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DESCRIPTION");

$alphaCharIn=0;
$index++;
$db = DBI::getInstance($database);
$query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.`jobsite_note_type_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jbta.`id` = '6' AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

$db->execute($query);
$records = array();
$recordsite = array();
$htmlInspectionData='';
while($row = $db->fetch()){
    $records[] = $row;
    $date=$row['jobsite_daily_log_created_date'];       
    $date = DateTime::createFromFormat('Y-m-d', $date);
    $date = $date->format('m/d/Y');
    $day = date('l',strtotime($date));
    $desc=$row['jobsite_note'];
    $alphaCharIn=0;
    
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc );
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn+1].$index)->setAutoSize(true);
    $index++;
    $htmlInspectionData="1";
    
}
$db->free_result();
$db->free_result();
if($htmlInspectionData=='0' ){
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Data Available for Selected Dates");
    $alphaCharIn++;
    
}






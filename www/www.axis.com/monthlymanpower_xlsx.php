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
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$index,"ADDRESS : ".$add_val); 
}else{
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$index,""); 
}
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':D'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('E'.$index.':J'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('P'.($index))->applyFromArray($styleRight);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':P'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('P'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':P'.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : ".$date .' To '.$date1);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':P'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;
/*content*/
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
 $count++;
 $arrayManDate[$count] ="Month TOTAL";
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
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(55);

    $alphaCharIn++;
    }
    if($valvalueCheck > 1){        
        $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn].$index;
    }else{
        $indexVal = $alphas[$alphaCharIn].$index;
    }
    $value_explode=explode(',',$arrayManDate[$datei]);
    $objPHPExcel->getActiveSheet()->setCellValue($indexVal,$value_explode[0]." - ".$value_explode[1]); 
     $objPHPExcel->getActiveSheet()->getColumnDimension("$indexVal")->setWidth(55);
     $objPHPExcel->getActiveSheet()->getColumnDimension($indexVal)->setAutoSize(true);


    if($datei==$date_count)
      $objPHPExcel->getActiveSheet()->setCellValue($indexVal,"Month TOTAL"); 
     $objPHPExcel->getActiveSheet()->getColumnDimension($indexVal)->setAutoSize(true);

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
            // $objPHPExcel->getActiveSheet()->getColumnDimension($indexVal)->setAutoSize(true);
        }
    }else{
        $objPHPExcel->getActiveSheet()->setCellValue($indexVal,$arrayManComp[$valuei][$invaluei]); 
        // $objPHPExcel->getActiveSheet()->getColumnDimension($indexVal)->setAutoSize(true);
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
// $objPHPExcel->getActiveSheet()->setCellValue($indexVal,'dsds'.$row_total);
$objPHPExcel->getActiveSheet()->setCellValue('AF'.$index,$row_total);
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
    // $objPHPExcel->getActiveSheet()->getColumnDimension($indexVal)->setAutoSize(true);
    $alphaCharIn++;
    }
    if($valvalueCheck > 1){        
        $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn].$index;
    }else{
        $indexVal = $alphas[$alphaCharIn].$index;
    }
    if($arrayChek[$invaluet]!='')    
    {
    $objPHPExcel->getActiveSheet()->setCellValue($indexVal,$coltotalarray[$invaluet]);
  // $objPHPExcel->getActiveSheet()->getColumnDimension($indexVal)->setAutoSize(true);
  }
    else{
        if($invaluet==$counttotalValue){
             if($valvalueCheck > 1){        
                $indexVal = $alphas[$valvalueCheck-2].$alphas[$alphaCharIn-1].$index;
             }else{
                 $indexVal = $alphas[$alphaCharIn-1].$index;
            }
            // $alphas[$valvalueCheck-2].$alphas[$alphaCharIn-1].$index;
            $objPHPExcel->getActiveSheet()->setCellValue('AF'.$index,$coltotalarray[$invaluet]);
          // $objPHPExcel->getActiveSheet()->setCellValue($indexVal,$coltotalarray[$invaluet]);
          // $objPHPExcel->getActiveSheet()->getColumnDimension('AF'.$index)->setAutoSize(true); 
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
$CheckTableValue=0;
}

?>

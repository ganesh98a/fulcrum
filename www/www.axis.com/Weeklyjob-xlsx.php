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
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index," DALIY WEATHER AND MANPOWER");
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

$man_power=buildManpowerWeeklyJob($database, $user_company_id, $project_id,$date);


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
$index = $index + 5;
/* week Total */
$alphaCharIn = 0;


        $maxDays=7;
        $arrayManValue=array();
        $arrayManDate=array();
        $arrayManComp=array();
        $count='1';
        $htmlContent="";
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
            $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
            $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
            $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
            $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];

            $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);
            $totalnumber_of_people=0;

            foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
                /* @var $subcontract Subcontract */

                $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
                /* @var $gcBudgetLineItem GcBudgetLineItem */

                $costCode = $gcBudgetLineItem->getCostCode();
                /* @var $costCode CostCode */

                $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode($user_company_id);

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
        foreach($arrayManValue as $ind=>$value){
            $value=array_filter($arrayManValue[$ind]);
            foreach($arrayManValue[$ind] as $index1 => $value1){
                $JoinArray='';
                $JoinArray .=(!empty($arrayChek[$index1]))?$arrayChek[$index1]:"";
                $JoinArray .=$arrayManValue[$ind][$index1];
                $arrayChek[$index1]=$JoinArray;
                $checkNull .= $arrayManValue[$ind][$index1];
            }
        }

        $weekTotalcol=0;
        $colTotal=0;
        $coltotalarray=array();
        $colcount=1;
        $valuehtml ="";
        for($valuei=1;$valuei<=$array_count;$valuei++){
            $row_total=0;
            $valueinarraycount=count($arrayManValue[$valuei]);
            for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
                if($invaluei!=0){
                    if(empty($coltotalarray[$invaluei]))
                    {
                        $coltotalarray[$invaluei] = 0;
                    }
                    $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
                    $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
                }
            }
            $weekTotalcol=$weekTotalcol+$row_total;
            $coltotalarray[$invaluei]=$weekTotalcol;
        }
        
        $counttotalValue=count($coltotalarray);
        $valuehtml.="<tr class='total_bold center-align'>";
        for($invaluet=1;$invaluet<$counttotalValue;$invaluet++){
            if($invaluet==1)
            {
                $alphaCharIn =0;
                $index++;
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'DAY TOTAL');
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;

            }
             $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$coltotalarray[$invaluet]);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
         
        }
       

/* WEEK'S ACTIVITY  */
$alphaCharIn =0;
$index+7;

$index = $index + 2;

$Inspection=TotalManPowerAndInspection($database,$project_id,$new_begindate,$enddate);
$manPowerWholeWeek=$Inspection['manpowerActivityThisWeek'];
$InspectionWholeWeek=$Inspection['numInspectionsThisWeek'];

/* CONTRACT STATUS */
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"WEEK'S ACTIVITY");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index = $index + 2;



$alphaCharIn = 0;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index),'TOTAL MANPOWER');
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn ++;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index),$manPowerWholeWeek);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$index++;

$alphaCharIn = 0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index),'PASSED INSPECTIONS');
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index),$InspectionWholeWeek);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

$index = $index + 2;

/* CONTRACT STATUS */
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"CONTRACT STATUS");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index = $index + 2;

$alphaCharIn = 0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index),'Code');
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index),'Cost Name');
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index),'Mailed Date');
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].($index),'Execution Date');
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;




 $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

    $arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdReport($database, $project_id);
    $gcBudgetLineItemsTbody='';
    $loopCounter=1;
    $tabindex=1;
    $tabindex2 =1;
    
    foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
        

        if (!empty($scheduledValuesOnly)) {
            $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
            if (!$prime_contract_scheduled_value) {
                continue;
            }
        }

        $costCode = $gcBudgetLineItem->getCostCode();

        $costCode->htmlEntityEscapeProperties();

        $costCodeDivision = $costCode->getCostCodeDivision();

        $costCodeDivision->htmlEntityEscapeProperties();

        $cost_code_division_id = $costCodeDivision->cost_code_division_id;
        if (isset($cost_code_division_id_filter)) {
            if ($cost_code_division_id_filter != $cost_code_division_id) {
                continue;
            }
        }

        $contactCompany = $gcBudgetLineItem->getContactCompany();

        $costCodeDivisionAlias = $gcBudgetLineItem->getCostCodeDivisionAlias();

        $costCodeAlias = $gcBudgetLineItem->getCostCodeAlias();

        $subcontractorBid = $gcBudgetLineItem->getSubcontractorBid();
        $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
        $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
        $arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemIdWithDate($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions,$new_begindate,$enddate, true);
        
        if (isset($arrSubcontracts) && !empty($arrSubcontracts)) {
            $subcontractCount = count($arrSubcontracts);
        } else {
            $subcontractCount = 0;
        }
        $subcontract_actual_value_raw = $subcontract_actual_value = null;
        $vendorList = '';
        $target_date = '';
        $arrSubcontractActualValueHtml = array();
        $arrSubcontractVendorHtml = array();
        $arrSubcontractTargetExecutionDateHtmlInputs = array();
        $formattedSubcontractMailedDate='';
        $formattedSubcontractTargetExecutionDate='';
        // subcontract_mailed_date
            $arrSubcontractMailedDateHtmlInputs=array();
            $arrSubcontractTargetExecutionDateHtmlInputs=array();
        foreach ($arrSubcontracts as $subcontract) {

            $tmp_subcontract_id = $subcontract->subcontract_id;
            $tmp_subcontract_sequence_number = $subcontract->subcontract_sequence_number;
            $tmp_subcontract_template_id = $subcontract->subcontract_template_id;
            $tmp_vendor_id = $subcontract->vendor_id;
            $tmp_unsigned_subcontract_file_manager_file_id = $subcontract->unsigned_subcontract_file_manager_file_id;
            $tmp_signed_subcontract_file_manager_file_id = $subcontract->signed_subcontract_file_manager_file_id;
            $tmp_subcontract_forecasted_value = $subcontract->subcontract_forecasted_value;
            $tmp_subcontract_actual_value = $subcontract->subcontract_actual_value;
            $tmp_subcontract_retention_percentage = $subcontract->subcontract_retention_percentage;
            $tmp_subcontract_issued_date = $subcontract->subcontract_issued_date;
            $tmp_subcontract_target_execution_date = $subcontract->subcontract_target_execution_date;
            $tmp_subcontract_execution_date = $subcontract->subcontract_execution_date;
            $tmp_active_flag = $subcontract->active_flag;
            $tmpSubcontractTargetExecutionDateHtmlInput = '';
            $tmpSubcontractMailedDateHtmlInput = '';
            // Subcontract Actual Value list
            $subcontract_actual_value_raw += $tmp_subcontract_actual_value;
            $subcontract_actual_value += $tmp_subcontract_actual_value;
            $formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
            // Vendor list
            $vendor = $subcontract->getVendor();
            if ($vendor) {

                $vendorContactCompany = $vendor->getVendorContactCompany();

                $vendorContactCompany->htmlEntityEscapeProperties();

                $vendorList .= $vendorContactCompany->escaped_contact_company_name . ', ';
                if ($subcontractCount == 1) {

                    $tmpSubcontractVendorHtmlInputs = $vendorContactCompany->escaped_contact_company_name;

                } elseif ($subcontractCount > 1) {

                    $tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT

                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$vendorContactCompany->escaped_contact_company_name
END_HTML_CONTENT;

                }
                $arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;

            }

            // subcontract_target_execution_date
            $formattedSubcontractMailedDate = $subcontract->deriveFormattedSubcontractMailedDate();
            $formattedSubcontractTargetExecutionDate = $subcontract->deriveFormattedSubcontractExecutionDate();
            if ($subcontractCount == 1) {
                if($formattedSubcontractTargetExecutionDate!='' && $formattedSubcontractTargetExecutionDate!=null){
                $tmpSubcontractTargetExecutionDateHtmlInput = $formattedSubcontractTargetExecutionDate;
                }
                if($formattedSubcontractMailedDate!='' && $formattedSubcontractMailedDate!=null){
$tmpSubcontractMailedDateHtmlInput =$formattedSubcontractMailedDate;
                }
            } elseif ($subcontractCount > 1) {
                if($formattedSubcontractTargetExecutionDate!='' && $formattedSubcontractTargetExecutionDate!=null){
                $tmpSubcontractTargetExecutionDateHtmlInput = "#$tmp_subcontract_sequence_number)$formattedSubcontractTargetExecutionDate".PHP_EOL;

                }
                if($formattedSubcontractMailedDate!='' && $formattedSubcontractMailedDate!=null){
 $tmpSubcontractMailedDateHtmlInput = "#$tmp_subcontract_sequence_number)$formattedSubcontractMailedDate".PHP_EOL ;
                }
            }
            
            $arrSubcontractTargetExecutionDateHtmlInputs[] = $tmpSubcontractTargetExecutionDateHtmlInput;
            $arrSubcontractMailedDateHtmlInputs[]=$tmpSubcontractMailedDateHtmlInput;
            // @todo...this parts
            // Foreign key objects
        }
        // subcontract_target_execution_date
        $subcontractTargetExecutionDateHtmlInputs = join('', $arrSubcontractTargetExecutionDateHtmlInputs);
        $subcontractMailedDateHtmlInputs = join('', $arrSubcontractMailedDateHtmlInputs);

        $invitedBiddersCount = 0;
        $activeBiddersCount = 0;

        $cost_code_id = $costCode->cost_code_id;
       

       $costCodeDetail = $costCodeDivision->escaped_division_number.$costCodeDividerType.$costCode->escaped_cost_code;
     if($subcontractMailedDateHtmlInputs!='' || $subcontractTargetExecutionDateHtmlInputs!='')
     {
    $alphaCharIn=0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costCodeDetail);
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costCode->escaped_cost_code_description);
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subcontractMailedDateHtmlInputs);
     $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subcontractTargetExecutionDateHtmlInputs);
     $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
    $alphaCharIn++;
    $index++;
    $gcBudgetLineItemsTbody = 'true';
    }
   
    }
    
if($gcBudgetLineItemsTbody==null){
    $index++;
    $alphaCharIn=0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Data Available for Selected Dates");
    $index++;
   
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
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':I'.$index);


$alphaCharIn=0;
$index = $index + 2;
/*Building Activity */
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"BUILDING ACTIVITY");

$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index++;
$alphaCharIn =0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"ACTIVITY");
$index++;
//get the data's from table for building section
$jobsiteDailyBuild = findByProjectIdAndJobsiteDailyLogModifiedBuild($database, $project_id, $new_begindate, $enddate);
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$jobsiteDailyBuild);
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':I'.$index);


/*Other Notes */
$alphaCharIn=0;
$index = $index + 2;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"OTHER NOTES");
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index++;
$alphaCharIn =0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"DATE");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"NOTE");
$alphaCharIn++;
$index++;

 $db = DBI::getInstance($database);
        $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.`jobsite_note_type_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jbta.`id` = '1' AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$new_begindate' AND '$enddate'";

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

            $alphaCharIn =0;
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$day.' , '.$date);
            $alphaCharIn++;
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$desc);
            $alphaCharIn++;
            $index++;
        }
        $db->free_result();
        if(empty(!$row)){
            $alphaCharIn =0;
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,'No Data Available for Selected Dates');
            $alphaCharIn++;

        }
/*open RFI*/
$alphaCharIn=0;
$index = $index + 2;
$loadRequestsForInformationByProjectIdOptions = new Input();
    $loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;

    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"RFI #");
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Open");
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Due By");
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Response");
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Recipient");
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Priority");
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Days Open");
    $alphaCharIn++;

    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
    $index++;
    $alphaCharIn =0;

    $arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByDate($database, $project_id, $loadRequestsForInformationByProjectIdOptions,$new_begindate, $enddate);

    $rfiTableTbody = '';
    $GetCount=count($arrRequestsForInformation);
    if($GetCount == '0')
    {
         $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Data Available for Selected Dates");
    $alphaCharIn++;
    }
    foreach ($arrRequestsForInformation as $request_for_information_id => $requestForInformation) {
        /* @var $requestForInformation RequestForInformation */

        $project = $requestForInformation->getProject();
        /* @var $project Project */

        $requestForInformationType = $requestForInformation->getRequestForInformationType();
        /* @var $requestForInformationType RequestForInformationType */

        $requestForInformationStatus = $requestForInformation->getRequestForInformationStatus();
        /* @var $requestForInformationStatus RequestForInformationStatus */

        $requestForInformationPriority = $requestForInformation->getRequestForInformationPriority();
        /* @var $requestForInformationPriority RequestForInformationPriority */
        $request_for_information_priority = $requestForInformationPriority->request_for_information_priority;

        $rfiFileManagerFile = $requestForInformation->getRfiFileManagerFile();
        /* @var $rfiFileManagerFile FileManagerFile */

        $rfiCostCode = $requestForInformation->getRfiCostCode();
        /* @var $rfiCostCode CostCode */

        $rfiCreatorContact = $requestForInformation->getRfiCreatorContact();
        /* @var $rfiCreatorContact Contact */

        $rfiCreatorContactCompanyOffice = $requestForInformation->getRfiCreatorContactCompanyOffice();
        /* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */

        $rfiCreatorPhoneContactCompanyOfficePhoneNumber = $requestForInformation->getRfiCreatorPhoneContactCompanyOfficePhoneNumber();
        /* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $rfiCreatorFaxContactCompanyOfficePhoneNumber = $requestForInformation->getRfiCreatorFaxContactCompanyOfficePhoneNumber();
        /* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $rfiCreatorContactMobilePhoneNumber = $requestForInformation->getRfiCreatorContactMobilePhoneNumber();
        /* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */

        $rfiCreatorContactMobilePhoneNumber = $requestForInformation->getRfiCreatorContactMobilePhoneNumber();
        /* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */

        $rfiRecipientContact = $requestForInformation->getRfiRecipientContact();
        /* @var $rfiRecipientContact Contact */

        $rfiRecipientContactCompanyOffice = $requestForInformation->getRfiRecipientContactCompanyOffice();
        /* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */

        $rfiRecipientPhoneContactCompanyOfficePhoneNumber = $requestForInformation->getRfiRecipientPhoneContactCompanyOfficePhoneNumber();
        /* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $rfiRecipientFaxContactCompanyOfficePhoneNumber = $requestForInformation->getRfiRecipientFaxContactCompanyOfficePhoneNumber();
        /* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $rfiRecipientContactMobilePhoneNumber = $requestForInformation->getRfiRecipientContactMobilePhoneNumber();
        /* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */

        $rfiInitiatorContact = $requestForInformation->getRfiInitiatorContact();
        /* @var $rfiInitiatorContact Contact */

        $rfiInitiatorContactCompanyOffice = $requestForInformation->getRfiInitiatorContactCompanyOffice();
        /* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */

        $rfiInitiatorPhoneContactCompanyOfficePhoneNumber = $requestForInformation->getRfiInitiatorPhoneContactCompanyOfficePhoneNumber();
        /* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $rfiInitiatorFaxContactCompanyOfficePhoneNumber = $requestForInformation->getRfiInitiatorFaxContactCompanyOfficePhoneNumber();
        /* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $rfiInitiatorContactMobilePhoneNumber = $requestForInformation->getRfiInitiatorContactMobilePhoneNumber();
        /* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */

        $rfi_sequence_number = $requestForInformation->rfi_sequence_number;
        $request_for_information_type_id = $requestForInformation->request_for_information_type_id;
        $request_for_information_status_id = $requestForInformation->request_for_information_status_id;
        $request_for_information_priority_id = $requestForInformation->request_for_information_priority_id;
        $rfi_file_manager_file_id = $requestForInformation->rfi_file_manager_file_id;
        $rfi_cost_code_id = $requestForInformation->rfi_cost_code_id;
        $rfi_creator_contact_id = $requestForInformation->rfi_creator_contact_id;
        $rfi_creator_contact_company_office_id = $requestForInformation->rfi_creator_contact_company_office_id;
        $rfi_creator_phone_contact_company_office_phone_number_id = $requestForInformation->rfi_creator_phone_contact_company_office_phone_number_id;
        $rfi_creator_fax_contact_company_office_phone_number_id = $requestForInformation->rfi_creator_fax_contact_company_office_phone_number_id;
        $rfi_creator_contact_mobile_phone_number_id = $requestForInformation->rfi_creator_contact_mobile_phone_number_id;
        $rfi_recipient_contact_id = $requestForInformation->rfi_recipient_contact_id;
        $rfi_recipient_contact_company_office_id = $requestForInformation->rfi_recipient_contact_company_office_id;
        $rfi_recipient_phone_contact_company_office_phone_number_id = $requestForInformation->rfi_recipient_phone_contact_company_office_phone_number_id;
        $rfi_recipient_fax_contact_company_office_phone_number_id = $requestForInformation->rfi_recipient_fax_contact_company_office_phone_number_id;
        $rfi_recipient_contact_mobile_phone_number_id = $requestForInformation->rfi_recipient_contact_mobile_phone_number_id;
        $rfi_initiator_contact_id = $requestForInformation->rfi_initiator_contact_id;
        $rfi_initiator_contact_company_office_id = $requestForInformation->rfi_initiator_contact_company_office_id;
        $rfi_initiator_phone_contact_company_office_phone_number_id = $requestForInformation->rfi_initiator_phone_contact_company_office_phone_number_id;
        $rfi_initiator_fax_contact_company_office_phone_number_id = $requestForInformation->rfi_initiator_fax_contact_company_office_phone_number_id;
        $rfi_initiator_contact_mobile_phone_number_id = $requestForInformation->rfi_initiator_contact_mobile_phone_number_id;
        $rfi_title = $requestForInformation->rfi_title;
        $rfi_plan_page_reference = $requestForInformation->rfi_plan_page_reference;
        $rfi_statement = $requestForInformation->rfi_statement;
        $rfi_created = $requestForInformation->created;
        $rfi_due_date = $requestForInformation->rfi_due_date;
        $rfi_closed_date = $requestForInformation->rfi_closed_date;

        // HTML Entity Escaped Data
        $requestForInformation->htmlEntityEscapeProperties();
        $escaped_rfi_plan_page_reference = $requestForInformation->escaped_rfi_plan_page_reference;
        $escaped_rfi_statement = $requestForInformation->escaped_rfi_statement;
        $escaped_rfi_statement_nl2br = $requestForInformation->escaped_rfi_statement_nl2br;
        $escaped_rfi_title = $requestForInformation->escaped_rfi_title;

    

        if (empty($escaped_rfi_plan_page_reference)) {
            $escaped_rfi_plan_page_reference = '&nbsp;';
        }

        //$recipient = Contact::findContactByIdExtended($database, $rfi_recipient_contact_id);
        /* @var $recipient Contact */

        if ($rfiRecipientContact) {
            $rfiRecipientContactFullName = $rfiRecipientContact->getContactFullName();
            $rfiRecipientContactFullNameHtmlEscaped = $rfiRecipientContact->getContactFullNameHtmlEscaped();
        } else {
            $rfiRecipientContactFullName = '';
            $rfiRecipientContactFullNameHtmlEscaped = '&nbsp;';
        }

        // Convert rfi_created to a Unix timestamp
        $openDateUnixTimestamp = strtotime($rfi_created);
        //$openDateDisplayString = date('n/j/Y g:ma');
        $oneDayInSeconds = 86400;
        $daysOpen = '';

        $formattedRfiCreatedDate = date("m/d/Y ", $openDateUnixTimestamp);
        // To get the Rfi Due Date
        // echo "rfi_due_date : ".$rfi_due_date;
        $formattedRfiDueDate='';
        if(!empty($rfi_due_date))
        {
           
        $dueDateUnixTimestamp = strtotime($rfi_due_date);
        $formattedRfiDueDate = date("m/d/Y ", $dueDateUnixTimestamp);
    }else
    {
        $formattedRfiDueDate = '';
    }
        

        // request_for_information_statuses:
        // 1 - Draft
        // 2 - Open
        // 3 - In Progress
        // 4 - Closed

        $request_for_information_status = $requestForInformationStatus->request_for_information_status;
        // if RFI status is "closed"
        if (!$rfi_closed_date) {
            $rfi_closed_date = '0000-00-00';
        }
        if (($request_for_information_status == 'Closed') && ($rfi_closed_date <> '0000-00-00')) {
            $closedDateUnixTimestamp = strtotime($rfi_closed_date);
            if ($rfi_closed_date <> '0000-00-00') {

                $daysOpenNumerator = $closedDateUnixTimestamp - $openDateUnixTimestamp;
                $daysOpenDenominator = $oneDayInSeconds;
                $daysOpen = $daysOpenNumerator / $daysOpenDenominator;
                $daysOpen = ceil($daysOpen);

            }
        } else {

            $nowDate = date('Y-m-d');
            $nowDateUnixTimestamp = strtotime($nowDate);
            $daysOpenNumerator = $nowDateUnixTimestamp - $openDateUnixTimestamp;
            $daysOpenDenominator = $oneDayInSeconds;
            $daysOpen = $daysOpenNumerator / $daysOpenDenominator;
            $daysOpen = ceil($daysOpen);

        }

        // There was an instance of $daysOpen showing as "-0"
        if (($daysOpen == 0) || ($daysOpen == '-0')) {
            $daysOpen = 0;
        }
        $countDays=strlen($daysOpen);
        if($countDays=='1')
        {
            $daysOpen='00'.$daysOpen;
        }else if($countDays=='2')
        {
            $daysOpen='0'.$daysOpen;
        }
        
        //to get the response Date 
        $db = DBI::getInstance($database);
                $query_res = "SELECT * FROM request_for_information_responses where request_for_information_id = $request_for_information_id limit 1";
                $db->execute($query_res);
                $ResponseDate ='';
                 while($row = $db->fetch())
                {
                     $ResponseDateUnixTimestamp = strtotime($row['modified']);
                     $formattedRfiResponseDate = date("m/d/Y ", $ResponseDateUnixTimestamp);
                    $ResponseDate = $formattedRfiResponseDate;
                }      
           
    
if($request_for_information_status_id=='2') //To get the open RFI
{
    $alphaCharIn=0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$rfi_sequence_number);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_rfi_title);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedRfiCreatedDate);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;

      $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedRfiDueDate);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$ResponseDate);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$rfiRecipientContactFullNameHtmlEscaped);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;

    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$request_for_information_priority);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$daysOpen);
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
    $index++;
}
    }

  

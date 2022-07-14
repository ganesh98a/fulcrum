<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Subcontract.php');

/*Initialize PHPExcel Class*/
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica')->setSize(12);
$objPHPExcel->getProperties()->setCreator("A.Ganeshkumar");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setDescription("Reallocation History Report.");

$objPHPExcel->setActiveSheetIndex(0);
$ind=1;
$signature=$fulcrum;
if (file_exists($signature)) {
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Customer Signature');
    $objDrawing->setDescription('Customer Signature');
    //Path to signature .jpg file
    $objDrawing->setPath($signature);
    $objDrawing->setCoordinates('A'.$ind);             //set image to cell
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());  //save
} else {
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$ind, "Image not found" );
}
/*cell text alignment*/
$styleRight = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)); 
$styleLeft = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)); 
$styleCenter = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
$verticalCenter = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

$sheet = $objPHPExcel->getActiveSheet();
$merge = $objPHPExcel->setActiveSheetIndex();

$sheet->getStyle('A'.($ind))->applyFromArray($styleRight);
$merge->mergeCells('A'.($ind).':I'.($ind));
$height = $height +10;

$points = PHPExcel_Shared_Drawing::pixelsToPoints($height);
$sheet->getRowDimension($ind)->setRowHeight($points);

$sheet->getStyle('A'.($ind))->getFont()->setSize(21);
$sheet->getStyle('A'.($ind))->getAlignment()->setIndent(1);
$sheet->setCellValue('A'.($ind),$type_mention);
$ind++;

$merge->mergeCells('A'.$ind.':I'.$ind);
$ind++;

$alpha = range('A', 'Z');
$cnt = 0;

$sheet->setCellValue($alpha[$cnt].$ind,"Company"); 
$sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

for($inday = 0; $inday < 7; $inday++){
	$weekDate=date('m/d/Y',strtotime($weekSelDate.'+'.$inday.' days'));
	$weekDay= date('l', strtotime($weekDate));

	$sheet->setCellValue($alpha[$cnt].$ind,$weekDay."\r".$weekDate); 
	$sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
	$cnt++;
}

$sheet->setCellValue($alpha[$cnt].$ind,"WEEK \r TOTAL"); 
$sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter)->getAlignment()->setWrapText(true);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);

$ind++;

$arrayManComp = array();
$count = 1;
$totalCnt = 0;
for($inday = 0; $inday < 7; $inday++){

	$sub_count = 1;

	$datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
    $jobsite_daily_log_id = '';

    $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);

    if ($jobsiteDailyLog) {
       $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    }

    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);

    $arrJobsiteManPowerIds = $arrJobsiteManPowerByJobsiteDailyLogId = $arrJobsiteManPowerBySubcontractId = '';

    if(!empty($arrReturn['jobsite_man_power_ids'])){
        $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
    }
    if(!empty($arrReturn['objects'])){
       $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects']; 
    }
    if(!empty($arrReturn['jobsite_man_power_by_subcontract_id'])){
        $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];   
    }    
    
    $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);

	foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        
        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        $costCode = $gcBudgetLineItem->getCostCode();
        $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode($user_company_id);

        $vendor = $subcontract->getVendor();
        $vendor_id = $vendor->vendor_id;
        $contactCompany = $vendor->getVendorContactCompany();

        $contact_company_name = $contactCompany->contact_company_name; 

        $number_of_people = 0;

        if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {
            $jobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];
            $number_of_people = $jobsiteManPower->number_of_people;
        } else {
            $jobsiteManPower = JobsiteManPower::findByJobsiteDailyLogIdAndSubcontractId($database, $jobsite_daily_log_id, $subcontract_id);
            if ($jobsiteManPower) {
                $number_of_people = $jobsiteManPower->number_of_people;       
            }          
        }       

        $totalCnt = $totalCnt + $number_of_people;
        
        $arrayManComp[$sub_count]['name'] = $contact_company_name.'-'.$htmlEntityEscapedFormattedCostCode;   
        $arrayManComp[$sub_count][$count]=$number_of_people;
        $sub_count++;     
    }
    $count++;
}

$monTot = $tueTot = $wedTot = $thrTot = $friTot = $satTot = $sunTot = $total = 0;

if ($totalCnt != 0) {

	foreach ($arrayManComp as $key => $value) {
		$alpha = range('A', 'Z');
		$cnt = 0;

		$name = $value['name'];
		$monday = ($value['1'] == 0) ? '' : $value['1'];
		$tuesday = ($value['2'] == 0) ? '' : $value['2'];
		$wednesday = ($value['3'] == 0) ? '' : $value['3'];
		$thursday = ($value['4'] == 0) ? '' : $value['4'];
		$friday = ($value['5'] == 0) ? '' : $value['5'];
		$saturday = ($value['6'] == 0) ? '' : $value['6'];
		$sunday = ($value['7'] == 0) ? '' : $value['7'];

		$weekTotal = $monday+$tuesday+$wednesday+$thursday+$friday+$saturday+$sunday;
		$total = $total + $weekTotal;
		$weekTotal = ($weekTotal == 0) ? '' : $weekTotal;

		$monTot = $monTot + $monday;
		$tueTot = $tueTot + $tuesday;
		$wedTot = $wedTot + $wednesday;
		$thrTot = $thrTot + $thursday;
		$friTot = $friTot + $friday;
		$satTot = $satTot + $saturday;
		$sunTot = $sunTot + $sunday;

		$sheet->setCellValue($alpha[$cnt].$ind,$name); $cnt++;

		$sheet->setCellValue($alpha[$cnt].$ind,$monday); 
		$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);$cnt++;

		$sheet->setCellValue($alpha[$cnt].$ind,$tuesday); 
		$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);$cnt++;

		$sheet->setCellValue($alpha[$cnt].$ind,$wednesday); 
		$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);	$cnt++;

		$sheet->setCellValue($alpha[$cnt].$ind,$thursday); 
		$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);	$cnt++;

		$sheet->setCellValue($alpha[$cnt].$ind,$friday); 
		$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);$cnt++;

		$sheet->setCellValue($alpha[$cnt].$ind,$saturday); 
		$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);	$cnt++;

		$sheet->setCellValue($alpha[$cnt].$ind,$sunday); 
		$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);	$cnt++;

		$sheet->setCellValue($alpha[$cnt].$ind,$weekTotal); 
		$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
		$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

		$ind++;
	}

	$alpha = range('A', 'Z');
	$cnt = 0;

	$sheet->setCellValue($alpha[$cnt].$ind,'DAY TOTAL'); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

	$monTot = ($monTot == 0) ? '' : $monTot;
	$sheet->setCellValue($alpha[$cnt].$ind,$monTot); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

	$tueTot = ($tueTot == 0) ? '' : $tueTot;
	$sheet->setCellValue($alpha[$cnt].$ind,$tueTot); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

	$wedTot = ($wedTot == 0) ? '' : $wedTot;
	$sheet->setCellValue($alpha[$cnt].$ind,$wedTot); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

	$thrTot = ($thrTot == 0) ? '' : $thrTot;
	$sheet->setCellValue($alpha[$cnt].$ind,$thrTot); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

	$friTot = ($friTot == 0) ? '' : $friTot;
	$sheet->setCellValue($alpha[$cnt].$ind,$friTot); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

	$satTot = ($satTot == 0) ? '' : $satTot;
	$sheet->setCellValue($alpha[$cnt].$ind,$satTot); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

	$sunTot = ($sunTot == 0) ? '' : $sunTot;
	$sheet->setCellValue($alpha[$cnt].$ind,$sunTot); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);$cnt++;

	$total = ($total == 0) ? '' : $total;
	$sheet->setCellValue($alpha[$cnt].$ind,$total); 
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);

	$sheet->getStyle("A3:".$alpha[$cnt].$ind)->applyFromArray($BStyle);
}else{
	
	$alpha = range('A', 'Z');
	$cnt = 0;
	$sheet->setCellValue($alpha[$cnt].$ind,'No Manpower Efforts Involved For Selected Dates'); 
	$sheet->getRowDimension($ind)->setRowHeight(40);
	$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
	$sheet->getStyle('A3:I3')->applyFromArray($BStyle);
	$sheet->getStyle('A'.$ind.':I'.$ind)->applyFromArray($BStyle);
	$merge->mergeCells('A'.$ind.':I'.$ind);
}

?>
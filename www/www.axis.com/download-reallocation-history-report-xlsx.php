<?php
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/Draws.php');

function getRowcount($text, $width=100) {
    $rc = 0;
    $line = explode("\r", $text);
    foreach($line as $source) {
        $rc += intval((strlen($source) / $width) + 1);
    }
    return $rc;
}

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
$merge->mergeCells('A'.($ind).':H'.($ind));
$height = $height +10;

$points = PHPExcel_Shared_Drawing::pixelsToPoints($height);
$sheet->getRowDimension($ind)->setRowHeight($points);

$sheet->getStyle('A'.($ind))->getFont()->setSize(21);
$sheet->getStyle('A'.($ind))->getAlignment()->setIndent(1);
$sheet->setCellValue('A'.($ind),$type_mention);
$ind++;

$projectData = Project::findProjectById($database,$project_id);
$alias_type = $projectData['alias_type'];

$contract_date = ($projectData['project_contract_date'] && $projectData['project_contract_date'] != '0000-00-00') ? date('m/d/Y', strtotime($projectData['project_contract_date'])) : '';
// Owner Details
$owner_name = $projectData['project_owner_name'] ? $projectData['project_owner_name'] : '';
$owner_add1 = $projectData['owner_address'] ? $projectData['owner_address'] : '';
$owner_city = $projectData['owner_city'] ? $projectData['owner_city'].',' : '';
$owner_state = $projectData['owner_state_or_region'] ? ' '.$projectData['owner_state_or_region'] : '';
$owner_zip = $projectData['owner_postal_code'] ? $projectData['owner_postal_code'] : '';
$owner_add2 = $owner_city.$owner_state.' '.$owner_zip;
// Project details
$project_name = $projectData['project_name'] ? $projectData['project_name'] : '';
$project_add1 = $projectData['address_line_1'] ? $projectData['address_line_1'] : '';
$prj_city = $projectData['address_city'] ? $projectData['address_city'].',' : '';
$prj_state = $projectData['address_state_or_region'] ? ' '.$projectData['address_state_or_region'] : '';
$prj_zip = $projectData['address_postal_code'] ? $projectData['address_postal_code'] : '';
$project_add2 = $prj_city.$prj_state.' '.$prj_zip;

// Contractor details
$entityName = ContractingEntities::getcontractEntityNameforProject($database,$projectData['contracting_entity_id']);
$contractor_name = $entityName ? $entityName : '';
$arrGCContactCompanyOffices = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyId($database, $projectData['user_company_id']);
$i = 0;
foreach($arrGCContactCompanyOffices as $officeId => $officeAddress) {
    if($i > 0){
        break;
    }
    $contractor_line_1 = $officeAddress->address_line_1 ? $officeAddress->address_line_1 : '';
    $contractor_line_2 = $officeAddress->address_line_2 ? ', '.$officeAddress->address_line_2 : '';
    $contractor_add1 = $contractor_line_1.$contractor_line_2;

    $contractor_city = $officeAddress->address_city ? $officeAddress->address_city : '';
    $contractor_state = $officeAddress->address_state_or_region ? $officeAddress->address_state_or_region.' ' : '';
    $contractor_postal_code = $officeAddress->address_postal_code ? $officeAddress->address_postal_code : '';
    $contractor_add2 = $contractor_city.', '.$contractor_state.$contractor_postal_code;
    $i++;
}

$drawData = Draws::getDrawDataUsingId($database,$project_id,$drawId);
$period_to = $drawData['through_date'] ? date('m/d/Y', strtotime($drawData['through_date'])) : '';
$app_no = $drawData['application_number'] ? '#'.$drawData['application_number'] : '';

$sheet->setCellValue('A'.$ind,"BUDGET REALLOCATION REQUEST");
$merge->mergeCells('A'.$ind.':H'.$ind);
$sheet->getStyle('A'.($ind))->applyFromArray($styleCenter);
$sheet->getStyle('A'.($ind))->getFont()->setBold(true);
$sheet->getStyle('A'.($ind))->getFont()->getColor()->setRGB('2481c3');
$ind++;

$merge->mergeCells('A'.$ind.':H'.$ind);
$ind++;

$alpha = range('A', 'Z');
$cnt = 0;

$sheet->setCellValue($alpha[$cnt].$ind,"TO (OWNER): "); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(15);
$sheet->getColumnDimension($alpha[$cnt+1])->setWidth(25);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"PROJECT: "); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(23);
$sheet->getColumnDimension($alpha[$cnt+1])->setWidth(17);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"FROM (CONTRACTOR): "); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(15);
$sheet->getColumnDimension($alpha[$cnt+1])->setWidth(20);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"PERIOD TO: "); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(20);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$period_to); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(25);

$ind++;
$alpha = range('A', 'Z');
$cnt = 0;

$sheet->setCellValue($alpha[$cnt].$ind,$owner_name); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$project_name); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$contractor_name); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"APPLICATION NO: "); 
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$app_no); 

$ind++;
$alpha = range('A', 'Z');
$cnt = 0;

$sheet->setCellValue($alpha[$cnt].$ind,$owner_add1); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$project_add1); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$contractor_add1); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"CONTRACT DATE: "); 
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$contract_date);

$ind++;
$alpha = range('A', 'Z');
$cnt = 0;

$sheet->setCellValue($alpha[$cnt].$ind,$owner_add2); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$project_add2); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$contractor_add2); 
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;$cnt++;

$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));

$ind++;

$merge->mergeCells('A'.$ind.':H'.$ind);
$ind++;

$alpha = range('A', 'Z');
$cnt = 0;

$sheet->setCellValue($alpha[$cnt].$ind," COST CODE ");
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind," DESCRIPTION OF WORK ");
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind," SCHEDULED VALUES ");
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind," AMOUNT FROM ");
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind," AMOUNT TO ");
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind," REVISED BUDGET ");
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind," EXPLANATION ");
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;

$lastAlphaIn = $cnt;

$sheet->getStyle('A'.$ind.':H'.$ind)->applyFromArray($styleCenter);
$sheet->getStyle('A'.$ind.':H'.$ind)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('bbbbbb');
$sheet->getStyle('A'.$ind.':'.$alpha[$lastAlphaIn].$ind)->applyFromArray($BStyle);

$ind++;

$alpha = range('A', 'Z');
$cnt = 0;

$scheduledValueTotal = $reallocationFromTotal = $reallocationToTotal = $revisedBudjectTotal = 0;
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
$cor_type = Project::CORAboveOrBelow($database,$project_id);
$budgetList = DrawItems::getBudgetDrawItems($database, $drawId, '', $cor_type);

foreach ($budgetList as $key => $value) {
    $drawItemId = $value['id'];
    $costCode = $value['cost_code'];
    $costCodeDivision = $value['division_number'];
    $costCodeDesc = $value['cost_code_description'];
    $realocationValue = $value['realocation'];
    $scheduledValue = $value['scheduled_value'];
    $revisedBudject = $scheduledValue + $realocationValue;
    $renotes = $value['renotes'];
    $cost_code_id = $value['cost_code_id'];
    $cost_code_divison_id = $value['cost_code_divison_id'];
    $getCostCodeAlias = DrawItems::getCostCodeAlias($database, $alias_type,$cost_code_id,$cost_code_divison_id);
    $reallocationFrom = 0;
    $reallocationTo = 0;
    if ($realocationValue > 0) {
        $reallocationFrom = 0;
        $reallocationTo = $realocationValue;
    }else if ($realocationValue < 0) {
        $reallocationFrom = $realocationValue;
        $reallocationTo = 0;
    }else{
        $reallocationFrom = 0;
        $reallocationTo = 0;
    }

    $scheduledValueTotal += $scheduledValue;
    $reallocationFromTotal += $reallocationFrom;
    $reallocationToTotal += $reallocationTo;
    $revisedBudjectTotal += $revisedBudject;

    $scheduledValueFormatted = Format::formatCurrency($scheduledValue);
    $revisedBudjectFormatted = Format::formatCurrency($revisedBudject);
    $reallocationFrom = $reallocationFrom ? Format::formatCurrency($reallocationFrom) : '';
    $reallocationTo = $reallocationTo ? Format::formatCurrency($reallocationTo) : '';

    $costCodeData = ' '.$costCodeDivision.$costCodeDividerType.$costCode.' ';
    if ($getCostCodeAlias != '' && $alias_type != 0 && $costCodeAliasStatus == 'true') {
      $costCodeData = $costCodeData.$getCostCodeAlias;
    }

    $cnt = 0;

    $sheet->setCellValue($alpha[$cnt].$ind,$costCodeData);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    if ($costCodeAliasStatus != 'true') {
        $sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($verticalCenter);
    }    
    $cnt++;

    $sheet->setCellValue($alpha[$cnt].$ind,$costCodeDesc);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;

    $sheet->setCellValue($alpha[$cnt].$ind,$scheduledValueFormatted);
    $sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;

    $sheet->setCellValue($alpha[$cnt].$ind,$reallocationFrom);
    $sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;

    $sheet->setCellValue($alpha[$cnt].$ind,$reallocationTo);
    $sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;

    $sheet->setCellValue($alpha[$cnt].$ind,$revisedBudjectFormatted);
    $sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;

    $renotes = str_replace("<br />","\r",$renotes);
    $numrows = getRowcount($renotes);    

    $sheet->setCellValue($alpha[$cnt].$ind,$renotes);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
    if ($renotes) {
        $sheet->getRowDimension($ind)->setRowHeight($numrows== 1 ? $numrows * 12.75 + 2.25 : $numrows * 14.75 + 5);  
    }  
    $sheet->getStyle($alpha[$cnt].($ind))->getAlignment()->setWrapText(true);   
    $cnt++;

    $lastAlphaIn = $cnt;

    $sheet->getStyle('A'.$ind.':'.$alpha[$lastAlphaIn].$ind)->applyFromArray($BStyle);

    $ind++;
}

$alpha = range('A', 'Z');
$cnt = 0;

$scheduledValueTotal = Format::formatCurrency($scheduledValueTotal);
$reallocationFromTotal = Format::formatCurrency($reallocationFromTotal);
$reallocationToTotal = Format::formatCurrency($reallocationToTotal);
$revisedBudjectTotal = Format::formatCurrency($revisedBudjectTotal);

$sheet->setCellValue($alpha[$cnt].$ind,"ORIGINAL BUDGET TOTALS");
$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
$cnt++;$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$scheduledValueTotal);
$sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$reallocationFromTotal);
$sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$reallocationToTotal);
$sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$revisedBudjectTotal);
$sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$sheet->getStyle($alpha[$cnt].($ind))->applyFromArray($styleRight);
$cnt++;

$merge->mergeCells($alpha[$cnt].($ind).':'.$alpha[$cnt+1].($ind));
$cnt++;
$lastAlphaIn = $cnt;
$sheet->getStyle('A'.$ind.':H'.$ind)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('bbbbbb');
$sheet->getStyle('A'.$ind.':'.$alpha[$lastAlphaIn].$ind)->applyFromArray($BStyle);

$ind++;

$merge->mergeCells('A'.$ind.':H'.$ind);
$ind++;

$contractor_name = strtoupper($contractor_name);

$sheet->setCellValue('B'.$ind,"CONTRACTOR: ".$contractor_name); 
$sheet->getStyle('B'.($ind))->getFont()->setBold(true);
$merge->mergeCells('B'.($ind).':G'.($ind));
$ind++;

$sheet->setCellValue('B'.$ind,"Sign:"); 
$merge->mergeCells('B'.($ind).':C'.($ind));
$sheet->setCellValue('D'.$ind,"Print:"); 
$merge->mergeCells('D'.($ind).':E'.($ind));
$sheet->setCellValue('F'.$ind,"Date:"); 
$merge->mergeCells('F'.($ind).':G'.($ind));
$sheet->getRowDimension($ind)->setRowHeight(40);
$ind++;

$owner_name = strtoupper($owner_name);

$sheet->setCellValue('B'.$ind,"OWNER: ".$owner_name); 
$sheet->getStyle('B'.($ind))->getFont()->setBold(true);
$merge->mergeCells('B'.($ind).':G'.($ind));
$ind++;

$sheet->setCellValue('B'.$ind,"Sign:"); 
$merge->mergeCells('B'.($ind).':C'.($ind));
$sheet->setCellValue('D'.$ind,"Print:"); 
$merge->mergeCells('D'.($ind).':E'.($ind));
$sheet->setCellValue('F'.$ind,"Date:"); 
$merge->mergeCells('F'.($ind).':G'.($ind));
$sheet->getRowDimension($ind)->setRowHeight(40);
$ind++;
?>

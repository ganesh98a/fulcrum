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

/*cell text alignment*/
$styleRight = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)); 
$styleLeft = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)); 
$styleCenter = array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
$verticalCenter = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
$BStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

$sheet = $objPHPExcel->getActiveSheet();
$merge = $objPHPExcel->setActiveSheetIndex();

$sheet->getStyle('A'.($ind))->applyFromArray($styleCenter);
$merge->mergeCells('A'.($ind).':E'.($ind));
$height = $height +10;

$points = PHPExcel_Shared_Drawing::pixelsToPoints($height);
$sheet->getRowDimension($ind)->setRowHeight($points);

$sheet->setCellValue('A'.$ind,"Subcontract Audit Report");
$merge->mergeCells('A'.$ind.':H'.$ind);
$sheet->getStyle('A'.($ind))->applyFromArray($styleCenter);
$sheet->getStyle('A'.($ind))->getFont()->setBold(true);
// $sheet->getStyle('A'.($ind))->getFont()->getColor()->setRGB('2481c3');
$ind++;

$sheet->setCellValue('E'.$ind,date('m/d/Y'));
$sheet->getStyle('E'.($ind))->applyFromArray($styleLeft);
// $sheet->getStyle('E'.($ind))->getFont()->setBold(true);
$ind++;




$project = Project::findProjectByIdExtended($database, $project_id);
    /* @var $project Project */
    $project->htmlEntityEscapeProperties();
    $escaped_project_name = $project->escaped_project_name;

    $s_id=explode("-", $subcontructor_id)[0];
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
    $filterby=" and sd.status IN ('approved')";
    // ,'potential'
    $db = DBI::getInstance($database);
    $query = "
    SELECT concat(ccd.`division_number`,'$costCodeDividerType',cs.cost_code,' ',cs.cost_code_description) as cost_code_abb, sd.*,cc.company, cs.id as cc_id FROM `subcontract_change_order_data` as sd
    inner join `contact_companies` as cc on cc.`id` = sd.subcontract_vendor_id 
    inner join `cost_codes` as cs on cs.id = sd.costcode_id
    inner join `cost_code_divisions` as ccd on ccd.id = cs.cost_code_division_id
    where `project_id` = $project_id and cc.id=$s_id and cs.id=$cc_id  $filterby ORDER BY cc.company ASC,cost_code_abb ASC , sd.status Asc, CAST(SUBSTR(approve_prefix , 5, LENGTH(approve_prefix)) AS UNSIGNED) ASC ";
    $db->execute($query);
    $records = array();
    while($row = $db->fetch())
    {
        $records[] = $row;
    }

$sub_val=explode("-", $subcontructor_id)[1];

$sheet->setCellValue('A'.$ind,'Project:');
$sheet->getStyle('A'.($ind))->applyFromArray($styleLeft);
$sheet->getStyle('A'.($ind))->getFont()->setBold(true);

$sheet->setCellValue('B'.$ind,$escaped_project_name);
$sheet->getStyle('B'.($ind))->applyFromArray($styleLeft);
$ind++;

$sheet->setCellValue('A'.$ind,'Subcontractor:');
$sheet->getStyle('A'.($ind))->applyFromArray($styleLeft);
$sheet->getStyle('A'.($ind))->getFont()->setBold(true);

$sheet->setCellValue('B'.$ind,$vendor);
$sheet->getStyle('B'.($ind))->applyFromArray($styleLeft);
$ind++;
$ind++;

$sheet->setCellValue('A'.$ind,'Subcontract Value:');
$sheet->getStyle('A'.($ind))->applyFromArray($styleLeft);
$sheet->getStyle('A'.($ind))->getFont()->setBold(true);

$sheet->setCellValue('B'.$ind,Format::formatCurrency($sub_val));
$sheet->getStyle('B'.($ind))->applyFromArray($styleLeft);
$ind++;
$ind++;

$sheet->setCellValue('A'.$ind,'Change Orders:');
$sheet->getStyle('A'.($ind))->applyFromArray($styleLeft);
$sheet->getStyle('A'.($ind))->getFont()->setBold(true);

$ind++;
$alpha = range('A', 'Z');
$cnt = 0;

$sheet->setCellValue($alpha[$cnt].$ind,"CO#"); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(15);
$sheet->getColumnDimension($alpha[$cnt+1])->setWidth(25);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"Date:"); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(23);
$sheet->getColumnDimension($alpha[$cnt+1])->setWidth(17);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"Description:"); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(15);
$sheet->getColumnDimension($alpha[$cnt+1])->setWidth(20);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"Cost Code:"); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(20);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,"Amount of CO:"); 
$sheet->getColumnDimension($alpha[$cnt])->setWidth(20);
$sheet->getStyle($alpha[$cnt].($ind))->getFont()->setBold(true);
$cnt++;


$ind++;
$total_c=0;
$ind++;
$alpha = range('A', 'Z');
foreach ($records as $key => $value) {

    $cnt = 0;

    $sheet->setCellValue($alpha[$cnt].$ind,$value['approve_prefix']);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);    
    $cnt++;

    $sheet->setCellValue($alpha[$cnt].$ind,$value['created_at']);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;

$sheet->setCellValue($alpha[$cnt].$ind,$value['description']);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;
$sheet->setCellValue($alpha[$cnt].$ind,$value['cost_code_abb']);
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;
$sheet->setCellValue($alpha[$cnt].$ind,Format::formatCurrency($value['estimated_amount']));
    $sheet->getColumnDimension($alpha[$cnt])->setAutoSize(true);
    $cnt++;


    $total_c+=$value['estimated_amount'];
    $ind++;
}

?>

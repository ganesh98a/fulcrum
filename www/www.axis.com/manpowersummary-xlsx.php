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
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':B'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('C'.$index.':D'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('D'.($index))->applyFromArray($styleRight);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':D'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('D'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':D'.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : ".$date .' To '.$date1);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':E'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;
/*content*/
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
$alphaCharIn=0;   
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date :".$date.' To '. $date1);
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Total Days : ".$diff);
$alphaCharIn++;
$index++;

$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"TOTAL MAN DAYS");
$index++;



$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Total Man Days (Including ".$company." employees)");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

$alphaCharIn++;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$man_power_count);
$index++;

$alphaCharIn=0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Total Man Hours (Days * 8 hrs)");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

$alphaCharIn++;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$man_days);
$index++;
$alphaCharIn =0;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Total Man Days (Excluding ".$company." employees)");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

$alphaCharIn++;



$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$manPowerExcludingAdvent);
$index++;
$alphaCharIn =0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Total Man Hours (Days * 8 hrs)");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);

$alphaCharIn++;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$manPowerExcludingAdventDays);


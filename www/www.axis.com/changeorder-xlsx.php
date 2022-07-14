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
$objPHPExcel->getDefaultStyle()->getFont()->setName('Helvetica')->setSize(12);
$objPHPExcel->getProperties()->setCreator("A.Ganeshkumar");
$objPHPExcel->getProperties()->setLastModifiedBy("Optisol Business Solution & Services");
$objPHPExcel->getProperties()->setTitle("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 Xlsx Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 Xlsx, generated using PHP classes.");

$objPHPExcel->setActiveSheetIndex(0);
$index=1;
$signature=$fulcrum;
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
$styleCenter = array(
 'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
 ); 
$styleLeft = array(
 'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    )
 ); 

//merge cell data
if($codesp =='true' && $coshowcostcode =='true'){  
    $halfstartPrev=$totalAlpha='H';  
    $halfstart=$amountAlpha='I';    
    $halfstartNext=$daysAlpha='J';
    $endcol='O';
}elseif($coshowcostcode == 'true')
{
    $halfstartPrev=$totalAlpha='G';
    $halfstart=$amountAlpha='H';
    $halfstartNext=$daysAlpha='I';
    $endcol='N';   
}elseif($codesp =='true'){  
    $halfstartPrev=$totalAlpha='F';  
    $halfstart=$amountAlpha='G';    
    $halfstartNext=$daysAlpha='H';
    $endcol='M';
}else
{
    $halfstartPrev=$totalAlpha='E';
    $halfstart=$amountAlpha='F';
    $halfstartNext=$daysAlpha='G';
    $endcol='L';   
}
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleRight);
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':'.$endcol.($index));
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
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"PROJECT : ".$project_name);
if($add_val!=''){
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$index,"ADDRESS : ".$add_val); 
}else{
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$index,""); 
}
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':E'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('F'.$index.':'.$endcol.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('F'.($index))->applyFromArray($styleRight);


/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('F'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index++;
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : ".$date .' To '.$date1);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Custom #");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"CO #");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Type"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Title"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Reason"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;

if($codesp =='true'){
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
}

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Amount"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Days"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Date"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Status"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"References"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Executed"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
if($coshowcostcode =='true'){
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code"); 
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code Amount"); 
    $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
    $alphaCharIn++;
}
// $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code");
// $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$lastAlphaIn = $alphaCharIn; 
$alphaCharIn=0;
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*Cell center*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->applyFromArray($styleCenter);
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->getColor()->setRGB('FFFF');
$index++;

//Fetch the Delay's Data
$incre_id=1;
$checkRtype='CO';
$db = DBI::getInstance($database);
$db->free_result();
$change_order_type_id=$_GET['cot'];

$loadChangeOrdersByPCO = new Input();
$loadChangeOrdersByPCO->forceLoadFlag = true;
$loadChangeOrdersByPCO->change_order_type_id = '1';
$loadChangeOrdersByPCO->coshowreject = $coshowreject;
$loadChangeOrdersByPCO->arrOrderByAttributes = "
       co.`change_order_type_id` ASC,CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC,co.`co_sequence_number` DESC ";
$arrForPCO = ChangeOrder::loadPotentialChangeOrdersByProjectId($database, $project_id, $new_begindate, $enddate,$loadChangeOrdersByPCO, $checkRtype);

$parent_costcodes = array();
if($view_option == 'subcontractor')
{
    foreach ($arrForPCO as $change_order_id => $changeOrder) {
        if($checkRtype == 'CO') 
        {
            $arrCostCodeCOview = ChangeOrder::getcostBreakCostCodeId($database,$change_order_id);
            $inc =1;
            foreach ($arrCostCodeCOview as $key => $costvalue) {
                $OCOcost_code_id = $costvalue['cost_code_reference_id'];
                $OCOcost_code_amount = floatVal($costvalue['cost']);
                $OCOcost_code_amount = Format::formatCurrency($OCOcost_code_amount);
                if($OCOcost_code_id !="")
                {
                $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
                $costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$OCOcost_code_id,$costCodeDividerType);
                $formatCoViewCode = $costcodedata['cost_code_abb'];
                $parent_costcodes[$incKey.'~'.$change_order_id.'~'.$OCOcost_code_amount] = $formatCoViewCode;
                $incKey++;
                }
            }
        }
    }
    asort($parent_costcodes);
    $parent_costcodes = array_filter($parent_costcodes);
    $parent_data =array();
    $sortInc =0;
    foreach($parent_costcodes as $akey => $avalue)
    {
        $akey = explode("~",$akey);
        $costCodeamt= $akey[2];
        $akey = $akey[1];
        if(isset($arrForPCO[$akey]))
        {
            $parent_data[$sortInc.'~'.$akey.'~'.$costCodeamt.'~'.$avalue]=$arrForPCO[$akey];
            $sortInc++;
        }
    }
    $arrForPCO = $parent_data;
}
$CORNotApprove = array(1,3);
$loadChangeOrdersByCORNotApprove = new Input();
$loadChangeOrdersByCORNotApprove->forceLoadFlag = true;
$loadChangeOrdersByCORNotApprove->change_order_type_id = '2';
$loadChangeOrdersByCORNotApprove->coshowreject = $coshowreject;
$loadChangeOrdersByCORNotApprove->change_order_status_id = $CORNotApprove;
$loadChangeOrdersByCORNotApprove->arrOrderByAttributes = "
       co.`change_order_type_id` ASC,CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC,co.`co_sequence_number` DESC ";
$arrForCORNotApprove = ChangeOrder::loadPotentialChangeOrdersByProjectId($database, $project_id, $new_begindate, $enddate,$loadChangeOrdersByCORNotApprove, $checkRtype);
if($view_option == 'subcontractor')
{
    $parent_costcodes= array();
    foreach ($arrForCORNotApprove as $change_order_id => $changeOrder) {
        if($checkRtype == 'CO') 
        {
            
            $arrCostCodeCOview = ChangeOrder::getcostBreakCostCodeId($database,$change_order_id);
            $inc =1;
            foreach ($arrCostCodeCOview as $key => $costvalue) {
                $OCOcost_code_id = $costvalue['cost_code_reference_id'];
                $OCOcost_code_amount = floatVal($costvalue['cost']);
                $OCOcost_code_amount = Format::formatCurrency($OCOcost_code_amount);
                if($OCOcost_code_id !="")
                {
                $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
                $costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$OCOcost_code_id,$costCodeDividerType);
                $formatCoViewCode = $costcodedata['cost_code_abb'];
                $parent_costcodes[$incKey.'~'.$change_order_id.'~'.$OCOcost_code_amount] = $formatCoViewCode;
                $incKey++;
                }
            }
        }
    }
    asort($parent_costcodes);
    $parent_costcodes = array_filter($parent_costcodes);
    $parent_data =array();
    $sortInc =0;
    foreach($parent_costcodes as $akey => $avalue)
    {
        $akey = explode("~",$akey);
        $costCodeamt= $akey[2];
        $akey = $akey[1];
        if(isset($arrForCORNotApprove[$akey]))
        {
            $parent_data[$sortInc.'~'.$akey.'~'.$costCodeamt.'~'.$avalue]=$arrForCORNotApprove[$akey];
            $sortInc++;
        }
    }
    $arrForCORNotApprove = $parent_data;
}
$CORApprove = array(2);
$loadChangeOrdersByCORApprove = new Input();
$loadChangeOrdersByCORApprove->forceLoadFlag = true;
$loadChangeOrdersByCORApprove->change_order_type_id = '2';
$loadChangeOrdersByCORApprove->coshowreject = $coshowreject;
$loadChangeOrdersByCORApprove->change_order_status_id = $CORApprove;
$loadChangeOrdersByCORApprove->arrOrderByAttributes = " boolnull ASC , boolDash DESC, boolZero DESC, boolNum DESC, (co.`co_custom_sequence_number`+0), co.`co_custom_sequence_number`, CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC";
$arrForCORApprove = ChangeOrder::loadPotentialChangeOrdersByProjectId($database, $project_id, $new_begindate, $enddate,$loadChangeOrdersByCORApprove, $checkRtype);
if($view_option == 'subcontractor')
{
    $parent_costcodes= array();
    foreach ($arrForCORApprove as $change_order_id => $changeOrder) {
        if($checkRtype == 'CO') 
        {
            
            $arrCostCodeCOview = ChangeOrder::getcostBreakCostCodeId($database,$change_order_id);
            $inc =1;
            foreach ($arrCostCodeCOview as $key => $costvalue) {
                $OCOcost_code_id = $costvalue['cost_code_reference_id'];
                $OCOcost_code_amount = floatVal($costvalue['cost']);
                $OCOcost_code_amount = Format::formatCurrency($OCOcost_code_amount);
                if($OCOcost_code_id !="")
                {
                $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
                $costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$OCOcost_code_id,$costCodeDividerType);
                $formatCoViewCode = $costcodedata['cost_code_abb'];
                $parent_costcodes[$incKey.'~'.$change_order_id.'~'.$OCOcost_code_amount] = $formatCoViewCode;
                $incKey++;
                }
            }
        }
    }
    asort($parent_costcodes);
    $parent_costcodes = array_filter($parent_costcodes);
    $parent_data =array();
    $sortInc =0;
    foreach($parent_costcodes as $akey => $avalue)
    {
        $akey = explode("~",$akey);
        $costCodeamt= $akey[2];
        $akey = $akey[1];
        if(isset($arrForCORApprove[$akey]))
        {
            $parent_data[$sortInc.'~'.$akey.'~'.$costCodeamt.'~'.$avalue]=$arrForCORApprove[$akey];
            $sortInc++;
        }
    }
    $arrForCORApprove = $parent_data;
}
$arrForCOR = array_merge($arrForCORNotApprove,$arrForCORApprove);


$orderTypeIdForPCO = 1;
$statusIdForPCO = array(1,2);
$potentialPCO = ReportchangeOrderTotalAndDelay($project_id,$orderTypeIdForPCO,$new_begindate, $enddate, $statusIdForPCO, $database);
$potentialPCOTotalAmt = $potentialPCO['total'];
$potentialPCOTotalAmt = Format::formatCurrency($potentialPCOTotalAmt);
$potentialPCODays = $potentialPCO['days']." day(s)";


$orderTypeIdForCORNotApprove = 2;
$statusIdForCORNotApprove = array(1);
$potentialCORNotApprove = ReportchangeOrderTotalAndDelay($project_id,$orderTypeIdForCORNotApprove,$new_begindate, $enddate, $statusIdForCORNotApprove, $database);
$potentialCORNotApproveTotalAmt = $potentialCORNotApprove['total'];
$potentialCORNotApproveTotalAmt = Format::formatCurrency($potentialCORNotApproveTotalAmt);
$potentialCORNotApproveDays = $potentialCORNotApprove['days']." day(s)";


$orderTypeIdForCORApprove = 2;
$statusIdForCORApprove = array(2);
$potentialCORApprove = ReportchangeOrderTotalAndDelay($project_id,$orderTypeIdForCORApprove,$new_begindate, $enddate, $statusIdForCORApprove, $database);

$potentialCORApproveTotalAmt = $potentialCORApprove['total'];
$potentialCORApproveTotalAmt = Format::formatCurrency($potentialCORApproveTotalAmt);
$potentialCORApproveDays = $potentialCORApprove['days']." day(s)";


$totalcoschudlevalue=0;
$totaldays=0;
$coTableTbody = '';
$pcoStart = 1;
$corStartNotApprove = 1;
$corStartApprove = 1;
$totalAmt = 0;


if ($_GET['cot'] == '1' || $_GET['cot'] == '1,2' || $_GET['cot'] == '') {
    $arrChangeOrders = $arrForPCO;    
    $totalAmt += $potentialPCO['total'];
    $pcoCount = count($arrForPCO);

    // Potential Change Order Heading
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"PCO Created");
    $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$halfstartPrev.$index);
    $objPHPExcel->getActiveSheet()->setCellValue($halfstart.$index,"Est.Amount");
    $objPHPExcel->getActiveSheet()->setCellValue($halfstartNext.$index,"");
    $objPHPExcel->setActiveSheetIndex()->mergeCells($halfstartNext.$index.':'.$endcol.$index);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b7b7b7');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;

     
$totalcovalue = 0;
    if ($pcoCount == 0) {
        $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available for Selected Dates"); 
        $objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setIndent(1);
        $index++;
    }else{
        
        $test_head = '';
        $FCostCodeAbb = '';
        foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
            
            if($view_option == 'subcontractor')
            {
                $tempHeadArr = $arrChangeOrders;
                $change_order_id = explode("~",$change_order_id);
                $FCostCodeAbb = $change_order_id[3];
                $OCOcost_code_amount = $change_order_id[2];
                $change_order_id = $change_order_id[1];
                if($test_head != $FCostCodeAbb)
                {
                    $test_head = $FCostCodeAbb;
                    $showHeader = 'true';
                }else{
                    $showHeader = 'false';
                }
            }else{
                $OCOcost_code_amount =$changeOrder->co_total;
            } 

            $project = $changeOrder->getProject();
            $changeOrderType = $changeOrder->getChangeOrderType();
            $change_order_type = $changeOrderType->change_order_type;
            $changeOrderStatus = $changeOrder->getChangeOrderStatus();
            $changeOrderPriority = $changeOrder->getChangeOrderPriority();
            $changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
            $change_order_distribution_method = '';
            $coFileManagerFile = $changeOrder->getCoFileManagerFile();
            $coCostCode = $changeOrder->getCoCostCode();
            $coCreatorContact = $changeOrder->getCoCreatorContact();
            $coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
            $coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
            $coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
            $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
            $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
            $coRecipientContact = $changeOrder->getCoRecipientContact();
            $coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
            $coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
            $coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
            $coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
            $coInitiatorContact = $changeOrder->getCoInitiatorContact();
            $coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
            $coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
            $coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
            $coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
            $coChangeId = $changeOrder->change_order_id;
            $changeTypeid = $changeOrder->change_order_type_id;
            $co_type_prefix =$changeOrder->co_type_prefix;
            $co_sequence_number = $changeOrder->co_sequence_number;
            $co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
            $co_scheduled_value = $changeOrder->co_scheduled_value;
            $totalcoschudlevalue=$co_scheduled_value+$totalcoschudlevalue;
            $co_delay_days = $changeOrder->co_delay_days;
            $change_order_type_id = $changeOrder->change_order_type_id;
            $change_order_status_id = $changeOrder->change_order_status_id;
            $change_order_priority_id = $changeOrder->change_order_priority_id;
            $change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
            $co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
            $co_cost_code_id = $changeOrder->co_cost_code_id;
            $co_creator_contact_id = $changeOrder->co_creator_contact_id;
            $co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
            $co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
            $co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
            $co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
            $co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
            $co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
            $co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
            $co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
            $co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
            $co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
            $co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
            $co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
            $co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
            $co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
            $co_title = $changeOrder->co_title;
            $co_plan_page_reference = $changeOrder->co_plan_page_reference;
            $co_statement = $changeOrder->co_statement;
            $co_created = $changeOrder->created;
            $co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
            $co_closed_date = $changeOrder->co_closed_date;
            $co_total = /*$changeOrder->co_total*/$OCOcost_code_amount;
             if(substr($OCOcost_code_amount,0,1)=='-'){
                $totalcovalue=$totalcovalue-floatval(str_replace([',','$','-'], "",$OCOcost_code_amount));
            }else{
                $totalcovalue+=floatval(str_replace([',','$','-'], "",$OCOcost_code_amount));
            }
            
            $co_total = Format::formatCurrency($co_total);

            // HTML Entity Escaped Data
            $changeOrder->htmlEntityEscapeProperties();
            $escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
            $escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
            $escaped_co_statement = $changeOrder->escaped_co_statement;
            $escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
            $escaped_co_title = $changeOrder->escaped_co_title;

            if (empty($escaped_co_custom_sequence_number)) {
                $escaped_co_custom_sequence_number = '';
            }
            if (empty($co_revised_project_completion_date)) {
                $co_revised_project_completion_date = '';
            }
            if (empty($escaped_co_plan_page_reference)) {
                $escaped_co_plan_page_reference = '';
            }
            if ($changeOrderPriority) {
                $change_order_priority = $changeOrderPriority->change_order_priority;
            } else {
                $change_order_priority = '';
            }

            $subAttach=attachDocumentLink($change_order_id, $database);
            $subAttachCount = $subAttach['count'];
            if ($subAttachCount > 0) {
                $linkDocument = "Link";
            }else{
                $linkDocument = "";
            }

            if ($coCostCode) {
                // Extra: Change Order Cost Code - Cost Code Division
                $coCostCodeDivision = $coCostCode->getCostCodeDivision();
                /* @var $coCostCodeDivision CostCodeDivision */
                $formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false, $user_company_id);
            } else {
                $formattedCoCostCode = '';
            }

            // To get all the cost break down cost codes
            $costdata = getCOCostcodeFromCostBreakDown($database, $user_company_id,$coChangeId,'1');
            $costamountdata = getCOCostcodeFromCostBreakDown($database, $user_company_id,$coChangeId,'2');
            $costamountdata = str_replace("<br>", "\r", $costamountdata);
            $costdata = str_replace("<br>", "\r", $costdata);
            /* @var $recipient Contact */
            if ($coRecipientContact) {
                $coRecipientContactFullName = $coRecipientContact->getContactFullName();
                $coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
            } else {
                $coRecipientContactFullName = '';
                $coRecipientContactFullNameHtmlEscaped = '';
            }
            // Convert co_created to a Unix timestamp
            $openDateUnixTimestamp = strtotime($co_created);
            $oneDayInSeconds = 86400;
            $daysOpen = '';

            $formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);
            $change_order_status = $changeOrderStatus->change_order_status;
            // if Change Order status is "closed"
            if (!$co_closed_date) {
                $co_closed_date = '0000-00-00';
            }
            if (($change_order_status == 'Closed') && ($co_closed_date <> '0000-00-00')) {
                $closedDateUnixTimestamp = strtotime($co_closed_date);
                if ($co_closed_date <> '0000-00-00') {
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
            $co_scheduled_value = Format::FormatCurrency($co_scheduled_value);

            if ($change_order_type == 'Potential Change Order') {
                $change_order_type_abbreviated = 'PCO';
                $headAmt="Est.Amount";
            } elseif ($change_order_type == 'Change Order Request') {
                $change_order_type_abbreviated = 'COR';
                $co_sequence_number= $co_type_prefix;
                $headAmt="Amount";
            } elseif ($change_order_type == 'Owner Change Order') {
                $change_order_type_abbreviated = 'OCO';
            }

            $totaldays=$totaldays+$co_delay_days;
            $bodytype='';
            $alphaCharIn=0;
            
            if($showHeader =='true')
            {
            //FORMATTED COST CODE
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,$FCostCodeAbb);
            $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
            $index++;
            }
            
            // Custom#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_custom_sequence_number); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;
            
            // CO#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_sequence_number);
            if ($change_order_status_id == 3) {                
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setStrikethrough(true);
            }
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);     
            $alphaCharIn++;    

            // Type
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_type_abbreviated);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;    

            // Title
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_title); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft); 
            $alphaCharIn++;

            // Reason
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_priority); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft); 
            $alphaCharIn++;

            if($codesp =='true'){
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_statement); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft);
            $alphaCharIn++;
            }

            // Amount
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_total); 
            if ($change_order_status_id == 3) {                
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setStrikethrough(true);
            }
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
            $alphaCharIn++;

            // Days
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_delay_days); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Date
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCreatedDate); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Status
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_status);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;

            // References 
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_plan_page_reference); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Executed
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$linkDocument); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setUnderline(true)->getColor()->setRGB('0368ce');
            $alphaCharIn++;
            
            // Cost Code and amount
            if($coshowcostcode =='true'){
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costdata); 
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
                $alphaCharIn++;
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costamountdata); 
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
                $alphaCharIn++;
            }
            // Cost Code
            // $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCostCode);
            // $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            // $alphaCharIn++;

            $incre_id++;
            $index++;
        }
    }
    // if($view_option == 'costcode')
    // {
    $objPHPExcel->getActiveSheet()->setCellValue($totalAlpha.$index,"Total Amount");
    $objPHPExcel->getActiveSheet()->getStyle($totalAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($amountAlpha.$index,Format::formatCurrency($totalcovalue));
    $objPHPExcel->getActiveSheet()->getStyle($amountAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($daysAlpha.$index,$totaldays.' Day(s)');
    $objPHPExcel->getActiveSheet()->getStyle($daysAlpha.$index)->applyFromArray($styleCenter);    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('dfdfdf');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;
    // }
}

if ($_GET['cot'] == '2' || $_GET['cot'] == '1,2' || $_GET['cot'] == '') {
    $totaldays=0;
    $totalAmt += $potentialCORNotApprove['total'];    
    $totalAmt += $potentialCORApprove['total'];
    $pcoCount = 1;
    $corCount = count($arrForCORNotApprove);
    $corAppCount = count($arrForCORApprove);

    // Open Change Orders Request
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"COR Submitted");
    $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$halfstartPrev.$index);
    $objPHPExcel->getActiveSheet()->setCellValue($halfstart.$index,"Amount");
    $objPHPExcel->getActiveSheet()->setCellValue($halfstartNext.$index,"");
    $objPHPExcel->setActiveSheetIndex()->mergeCells($halfstartNext.$index.':'.$endcol.$index);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b7b7b7');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;
    $totalcovalue=0;
    if ($corCount == 0) {
        $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available for Selected Dates"); 
        $index++;
    }else{
        $test_head = '';
        $FCostCodeAbb = '';
        foreach ($arrForCORNotApprove as $change_order_id => $changeOrder) {
            if($view_option == 'subcontractor')
            {
                $tempHeadArr = $arrForCORNotApprove;
                $change_order_id = explode("~",$change_order_id);
                $FCostCodeAbb = $change_order_id[3];
                $OCOcost_code_amount = $change_order_id[2];
                $change_order_id = $change_order_id[1];
                if($test_head != $FCostCodeAbb)
                {
                    $test_head = $FCostCodeAbb;
                    $showHeader = 'true';
                }else{
                    $showHeader = 'false';
                }
            } else{
                $OCOcost_code_amount =$changeOrder->co_total;
            }        
            $project = $changeOrder->getProject();
            $changeOrderType = $changeOrder->getChangeOrderType();
            $change_order_type = $changeOrderType->change_order_type;
            $changeOrderStatus = $changeOrder->getChangeOrderStatus();
            $changeOrderPriority = $changeOrder->getChangeOrderPriority();
            $changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
            $change_order_distribution_method = '';
            $coFileManagerFile = $changeOrder->getCoFileManagerFile();
            $coCostCode = $changeOrder->getCoCostCode();
            $coCreatorContact = $changeOrder->getCoCreatorContact();
            $coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
            $coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
            $coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
            $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
            $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
            $coRecipientContact = $changeOrder->getCoRecipientContact();
            $coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
            $coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
            $coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
            $coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
            $coInitiatorContact = $changeOrder->getCoInitiatorContact();
            $coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
            $coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
            $coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
            $coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();

            $changeTypeid = $changeOrder->change_order_type_id;
            $co_type_prefix =$changeOrder->co_type_prefix;
            $co_sequence_number = $changeOrder->co_sequence_number;
            $co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
            $co_scheduled_value = $changeOrder->co_scheduled_value;
            $totalcoschudlevalue=$co_scheduled_value+$totalcoschudlevalue;
            $co_delay_days = $changeOrder->co_delay_days;
            $change_order_type_id = $changeOrder->change_order_type_id;
            $change_order_status_id = $changeOrder->change_order_status_id;
            $change_order_priority_id = $changeOrder->change_order_priority_id;
            $change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
            $co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
            $co_cost_code_id = $changeOrder->co_cost_code_id;
            $co_creator_contact_id = $changeOrder->co_creator_contact_id;
            $co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
            $co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
            $co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
            $co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
            $co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
            $co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
            $co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
            $co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
            $co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
            $co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
            $co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
            $co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
            $co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
            $co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
            $co_title = $changeOrder->co_title;
            $co_plan_page_reference = $changeOrder->co_plan_page_reference;
            $co_statement = $changeOrder->co_statement;
            $co_created = $changeOrder->created;
            $co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
            $co_closed_date = $changeOrder->co_closed_date;
            $co_total = $OCOcost_code_amount;
             if(substr($OCOcost_code_amount,0,1)=='-'){
                $totalcovalue=$totalcovalue-floatval(str_replace([',','$','-'], "",$OCOcost_code_amount));
            }else{
                $totalcovalue+=floatval(str_replace([',','$','-'], "",$OCOcost_code_amount));
            }
            $co_total = Format::formatCurrency($co_total);

            // HTML Entity Escaped Data
            $changeOrder->htmlEntityEscapeProperties();
            $escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
            $escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
            $escaped_co_statement = $changeOrder->escaped_co_statement;
            $escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
            $escaped_co_title = $changeOrder->escaped_co_title;

            if (empty($escaped_co_custom_sequence_number)) {
                $escaped_co_custom_sequence_number = '';
            }
            if (empty($co_revised_project_completion_date)) {
                $co_revised_project_completion_date = '';
            }
            if (empty($escaped_co_plan_page_reference)) {
                $escaped_co_plan_page_reference = '';
            }
            if ($changeOrderPriority) {
                $change_order_priority = $changeOrderPriority->change_order_priority;
            } else {
                $change_order_priority = '';
            }

            $subAttach=attachDocumentLink($change_order_id, $database);
            $subAttachCount = $subAttach['count'];
            if ($subAttachCount > 0) {
                $linkDocument = "Link";
            }else{
                $linkDocument = "";
            }

            if ($coCostCode) {
                // Extra: Change Order Cost Code - Cost Code Division
                $coCostCodeDivision = $coCostCode->getCostCodeDivision();
                /* @var $coCostCodeDivision CostCodeDivision */
                $formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false, $user_company_id);
            } else {
                $formattedCoCostCode = '';
            }

            /* @var $recipient Contact */
            if ($coRecipientContact) {
                $coRecipientContactFullName = $coRecipientContact->getContactFullName();
                $coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
            } else {
                $coRecipientContactFullName = '';
                $coRecipientContactFullNameHtmlEscaped = '';
            }
            // Convert co_created to a Unix timestamp
            $openDateUnixTimestamp = strtotime($co_created);
            $oneDayInSeconds = 86400;
            $daysOpen = '';

            $formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);
            $change_order_status = $changeOrderStatus->change_order_status;
            // if Change Order status is "closed"
            if (!$co_closed_date) {
                $co_closed_date = '0000-00-00';
            }
            if (($change_order_status == 'Closed') && ($co_closed_date <> '0000-00-00')) {
                $closedDateUnixTimestamp = strtotime($co_closed_date);
                if ($co_closed_date <> '0000-00-00') {
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
            $co_scheduled_value = Format::FormatCurrency($co_scheduled_value);

            if ($change_order_type == 'Potential Change Order') {
                $change_order_type_abbreviated = 'PCO';
                $headAmt="Est.Amount";
            } elseif ($change_order_type == 'Change Order Request') {
                $change_order_type_abbreviated = 'COR';
                $co_sequence_number= $co_type_prefix;
                $headAmt="Amount";
            } elseif ($change_order_type == 'Owner Change Order') {
                $change_order_type_abbreviated = 'OCO';
            }

            $totaldays=$totaldays+$co_delay_days;
            $bodytype='';
            $alphaCharIn=0;

            if($showHeader =='true')
            {
            //FORMATTED COST CODE
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,$FCostCodeAbb);
            $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
            $index++;
            }

            // Custom#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_custom_sequence_number); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++; 
            
            // CO#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_sequence_number); 
            if ($change_order_status_id == 3) {                
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setStrikethrough(true);
            }            
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);     
            $alphaCharIn++;   

            // Type
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_type_abbreviated);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;    

            // Title
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_title); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft); 
            $alphaCharIn++;

            // Reason
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_priority); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft); 
            $alphaCharIn++;

            if($codesp =='true'){
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_statement); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft);
            $alphaCharIn++;
            }

            // Amount
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_total);
            if ($change_order_status_id == 3) {                
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setStrikethrough(true);
            } 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
            $alphaCharIn++;

            // Days
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_delay_days); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Date
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCreatedDate); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Status
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_status);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;

            // References 
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_plan_page_reference); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Executed
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$linkDocument); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setUnderline(true)->getColor()->setRGB('0368ce');
            $alphaCharIn++;

             // Cost Code and amount
             if($coshowcostcode =='true'){
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costdata); 
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
                $alphaCharIn++;
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costamountdata); 
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
                $alphaCharIn++;
            }
            // Cost Code
            // $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCostCode);
            // $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            // $alphaCharIn++;

            $incre_id++;
            $index++;
        }
    }
    // if($view_option == 'costcode')
    // {
    $objPHPExcel->getActiveSheet()->setCellValue($totalAlpha.$index,"Total Amount");
    $objPHPExcel->getActiveSheet()->getStyle($totalAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($amountAlpha.$index,Format::formatCurrency($totalcovalue));
    $objPHPExcel->getActiveSheet()->getStyle($amountAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($daysAlpha.$index,$totaldays.' Day(s)');
    $objPHPExcel->getActiveSheet()->getStyle($daysAlpha.$index)->applyFromArray($styleCenter);    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('dfdfdf');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;
    // }
    // Open Change Orders Request
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Approved");
    $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$halfstartPrev.$index);
    $objPHPExcel->getActiveSheet()->setCellValue($halfstart.$index,"Amount");
    $objPHPExcel->getActiveSheet()->setCellValue($halfstartNext.$index,"");
    $objPHPExcel->setActiveSheetIndex()->mergeCells($halfstartNext.$index.':'.$endcol.$index);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b7b7b7');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;
$totalcovalue=0;
$totaldays=0;
    if ($corAppCount == 0) {
        $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available for Selected Dates"); 
        $index++;
    }else{
        $test_head = '';
        $FCostCodeAbb='';
        foreach ($arrForCORApprove as $change_order_id => $changeOrder) {
            if($view_option == 'subcontractor')
            {
                $tempHeadArr = $arrForCORApprove;
                $change_order_id = explode("~",$change_order_id);
                $FCostCodeAbb = $change_order_id[3];
                $OCOcost_code_amount = $change_order_id[2];
                $change_order_id = $change_order_id[1];
                if($test_head != $FCostCodeAbb)
                {
                    $test_head = $FCostCodeAbb;
                    $showHeader = 'true';
                }else{
                    $showHeader = 'false';
                }
            } else{
                $OCOcost_code_amount =$changeOrder->co_total;
            }        
            $project = $changeOrder->getProject();
            $changeOrderType = $changeOrder->getChangeOrderType();
            $change_order_type = $changeOrderType->change_order_type;
            $changeOrderStatus = $changeOrder->getChangeOrderStatus();
            $changeOrderPriority = $changeOrder->getChangeOrderPriority();
            $changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
            $change_order_distribution_method = '';
            $coFileManagerFile = $changeOrder->getCoFileManagerFile();
            $coCostCode = $changeOrder->getCoCostCode();
            $coCreatorContact = $changeOrder->getCoCreatorContact();
            $coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
            $coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
            $coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
            $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
            $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
            $coRecipientContact = $changeOrder->getCoRecipientContact();
            $coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
            $coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
            $coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
            $coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
            $coInitiatorContact = $changeOrder->getCoInitiatorContact();
            $coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
            $coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
            $coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
            $coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();

            $changeTypeid = $changeOrder->change_order_type_id;
            $co_type_prefix =$changeOrder->co_type_prefix;
            $co_sequence_number = $changeOrder->co_sequence_number;
            $co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
            $co_scheduled_value = $changeOrder->co_scheduled_value;
            $totalcoschudlevalue=$co_scheduled_value+$totalcoschudlevalue;
            $co_delay_days = $changeOrder->co_delay_days;
            $change_order_type_id = $changeOrder->change_order_type_id;
            $change_order_status_id = $changeOrder->change_order_status_id;
            $change_order_priority_id = $changeOrder->change_order_priority_id;
            $change_order_distribution_method_id = $changeOrder->change_order_distribution_method_id;
            $co_file_manager_file_id = $changeOrder->co_file_manager_file_id;
            $co_cost_code_id = $changeOrder->co_cost_code_id;
            $co_creator_contact_id = $changeOrder->co_creator_contact_id;
            $co_creator_contact_company_office_id = $changeOrder->co_creator_contact_company_office_id;
            $co_creator_phone_contact_company_office_phone_number_id = $changeOrder->co_creator_phone_contact_company_office_phone_number_id;
            $co_creator_fax_contact_company_office_phone_number_id = $changeOrder->co_creator_fax_contact_company_office_phone_number_id;
            $co_creator_contact_mobile_phone_number_id = $changeOrder->co_creator_contact_mobile_phone_number_id;
            $co_recipient_contact_id = $changeOrder->co_recipient_contact_id;
            $co_recipient_contact_company_office_id = $changeOrder->co_recipient_contact_company_office_id;
            $co_recipient_phone_contact_company_office_phone_number_id = $changeOrder->co_recipient_phone_contact_company_office_phone_number_id;
            $co_recipient_fax_contact_company_office_phone_number_id = $changeOrder->co_recipient_fax_contact_company_office_phone_number_id;
            $co_recipient_contact_mobile_phone_number_id = $changeOrder->co_recipient_contact_mobile_phone_number_id;
            $co_initiator_contact_id = $changeOrder->co_initiator_contact_id;
            $co_initiator_contact_company_office_id = $changeOrder->co_initiator_contact_company_office_id;
            $co_initiator_phone_contact_company_office_phone_number_id = $changeOrder->co_initiator_phone_contact_company_office_phone_number_id;
            $co_initiator_fax_contact_company_office_phone_number_id = $changeOrder->co_initiator_fax_contact_company_office_phone_number_id;
            $co_initiator_contact_mobile_phone_number_id = $changeOrder->co_initiator_contact_mobile_phone_number_id;
            $co_title = $changeOrder->co_title;
            $co_plan_page_reference = $changeOrder->co_plan_page_reference;
            $co_statement = $changeOrder->co_statement;
            $co_created = $changeOrder->created;
            $co_revised_project_completion_date = $changeOrder->co_revised_project_completion_date;
            $co_closed_date = $changeOrder->co_closed_date;
            $co_total = /*$changeOrder->co_total*/$OCOcost_code_amount;
            if(substr($OCOcost_code_amount,0,1)=='-'){
                $totalcovalue=$totalcovalue-floatval(str_replace([',','$','-'], "",$OCOcost_code_amount));
            }else{
                $totalcovalue+=floatval(str_replace([',','$','-'], "",$OCOcost_code_amount));
            }
            $co_total = Format::formatCurrency($co_total);

            // HTML Entity Escaped Data
            $changeOrder->htmlEntityEscapeProperties();
            $escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
            $escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
            $escaped_co_statement = $changeOrder->escaped_co_statement;
            $escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
            $escaped_co_title = $changeOrder->escaped_co_title;

            if (empty($escaped_co_custom_sequence_number)) {
                $escaped_co_custom_sequence_number = '';
            }
            if (empty($co_revised_project_completion_date)) {
                $co_revised_project_completion_date = '';
            }
            if (empty($escaped_co_plan_page_reference)) {
                $escaped_co_plan_page_reference = '';
            }
            if ($changeOrderPriority) {
                $change_order_priority = $changeOrderPriority->change_order_priority;
            } else {
                $change_order_priority = '';
            }

            $subAttach=attachDocumentLink($change_order_id, $database);
            $subAttachCount = $subAttach['count'];
            if ($subAttachCount > 0) {
                $linkDocument = "Link";
            }else{
                $linkDocument = "";
            }

            if ($coCostCode) {
                // Extra: Change Order Cost Code - Cost Code Division
                $coCostCodeDivision = $coCostCode->getCostCodeDivision();
                /* @var $coCostCodeDivision CostCodeDivision */
                $formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false, $user_company_id);
            } else {
                $formattedCoCostCode = '';
            }

            /* @var $recipient Contact */
            if ($coRecipientContact) {
                $coRecipientContactFullName = $coRecipientContact->getContactFullName();
                $coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
            } else {
                $coRecipientContactFullName = '';
                $coRecipientContactFullNameHtmlEscaped = '';
            }
            // Convert co_created to a Unix timestamp
            $openDateUnixTimestamp = strtotime($co_created);
            $oneDayInSeconds = 86400;
            $daysOpen = '';

            $formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);
            $change_order_status = $changeOrderStatus->change_order_status;
            // if Change Order status is "closed"
            if (!$co_closed_date) {
                $co_closed_date = '0000-00-00';
            }
            if (($change_order_status == 'Closed') && ($co_closed_date <> '0000-00-00')) {
                $closedDateUnixTimestamp = strtotime($co_closed_date);
                if ($co_closed_date <> '0000-00-00') {
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
            $co_scheduled_value = Format::FormatCurrency($co_scheduled_value);

            if ($change_order_type == 'Potential Change Order') {
                $change_order_type_abbreviated = 'PCO';
                $headAmt="Est.Amount";
            } elseif ($change_order_type == 'Change Order Request') {
                $change_order_type_abbreviated = 'COR';
                $co_sequence_number= $co_type_prefix;
                $headAmt="Amount";
            } elseif ($change_order_type == 'Owner Change Order') {
                $change_order_type_abbreviated = 'OCO';
            }

            $totaldays=$totaldays+$co_delay_days;
            $bodytype='';
            $alphaCharIn=0;

            if($showHeader =='true')
            {
            //FORMATTED COST CODE
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,$FCostCodeAbb);
            $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
            $index++;
            }
            
            // Custom#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_custom_sequence_number); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;  

            // CO#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_sequence_number); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);     
            $alphaCharIn++;
  

            // Type
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_type_abbreviated);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;    

            // Title
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_title); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft); 
            $alphaCharIn++;

            // Reason
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_priority); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft); 
            $alphaCharIn++;

            if($codesp =='true'){
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_statement); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleLeft);
            $alphaCharIn++;
            }

            // Amount
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_total); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].($index))->applyFromArray($styleRight);
            $alphaCharIn++;

            // Days
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_delay_days); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Date
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCreatedDate); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Status
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_status);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;

            // References 
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_plan_page_reference); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;

            // Executed
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$linkDocument); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setUnderline(true)->getColor()->setRGB('0368ce');
            $alphaCharIn++;

             // Cost Code and amount
             if($coshowcostcode =='true'){
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costdata); 
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
                $alphaCharIn++;
                $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costamountdata); 
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
                $alphaCharIn++;
            }
            // Cost Code
            // $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCostCode);
            // $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            // $alphaCharIn++;

            $incre_id++;
            $index++;
        }
    }
    // if($view_option == 'costcode')
    // {
    $objPHPExcel->getActiveSheet()->setCellValue($totalAlpha.$index,"Total Amount");
    $objPHPExcel->getActiveSheet()->getStyle($totalAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($amountAlpha.$index,Format::formatCurrency($totalcovalue));
    $objPHPExcel->getActiveSheet()->getStyle($amountAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($daysAlpha.$index,$totaldays.' Day(s)');
    $objPHPExcel->getActiveSheet()->getStyle($daysAlpha.$index)->applyFromArray($styleCenter);    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('dfdfdf');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;
    // }
}
if($view_option == 'costcode')
{
// Total Amount
$totalAmt = Format::FormatCurrency($totalAmt);  

$objPHPExcel->getActiveSheet()->setCellValue($totalAlpha.$index,"Total");
$objPHPExcel->getActiveSheet()->getStyle($totalAlpha.$index)->applyFromArray($styleRight);
$objPHPExcel->getActiveSheet()->setCellValue($amountAlpha.$index,$totalAmt);
$objPHPExcel->getActiveSheet()->getStyle($amountAlpha.$index)->applyFromArray($styleRight);    
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b7b7b7');
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
}
?>

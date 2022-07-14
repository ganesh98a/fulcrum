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
require_once('../module-report-jobstatus-functions.php');
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
require_once('lib/common/Format.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');

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
if($codesp =='true'){  
    $halfstartPrev=$totalAlpha='F';  
    $halfstart=$amountAlpha='G';    
    $halfstartNext=$daysAlpha='H';
    $endcol='L';
}else
{
    $halfstartPrev=$totalAlpha='E';
    $halfstart=$amountAlpha='F';
    $halfstartNext=$daysAlpha='G';
    $endcol='K';   
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

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"CO #");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Custom #");
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
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
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
$change_order_type_id=$cot;

$loadChangeOrdersByPCO = new Input();
$loadChangeOrdersByPCO->forceLoadFlag = true;
$loadChangeOrdersByPCO->change_order_type_id = '1';
$loadChangeOrdersByPCO->coshowreject = $coShowRejected;
$loadChangeOrdersByPCO->arrOrderByAttributes = "
       co.`change_order_type_id` ASC,CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC,co.`co_sequence_number` DESC ";
$arrForPCO = ChangeOrder::loadPotentialChangeOrdersByProjectId($database, $RN_project_id, $RN_reportsStartDate, $RN_reportsEndDate,$loadChangeOrdersByPCO, $checkRtype);

$CORNotApprove = array(1,3);
$loadChangeOrdersByCORNotApprove = new Input();
$loadChangeOrdersByCORNotApprove->forceLoadFlag = true;
$loadChangeOrdersByCORNotApprove->change_order_type_id = '2';
$loadChangeOrdersByPCO->coshowreject = $coShowRejected;
$loadChangeOrdersByCORNotApprove->change_order_status_id = $CORNotApprove;
$loadChangeOrdersByCORNotApprove->arrOrderByAttributes = "
       co.`change_order_type_id` ASC,CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC,co.`co_sequence_number` DESC ";
$arrForCORNotApprove = ChangeOrder::loadPotentialChangeOrdersByProjectId($database, $RN_project_id, $RN_reportsStartDate, $RN_reportsEndDate,$loadChangeOrdersByCORNotApprove, $checkRtype);

$CORApprove = array(2);
$loadChangeOrdersByCORApprove = new Input();
$loadChangeOrdersByCORApprove->forceLoadFlag = true;
$loadChangeOrdersByCORApprove->change_order_type_id = '2';
$loadChangeOrdersByPCO->coshowreject = $coShowRejected;
$loadChangeOrdersByCORApprove->change_order_status_id = $CORApprove;
$loadChangeOrdersByCORApprove->arrOrderByAttributes = " boolnull ASC , boolDash DESC, boolZero DESC, boolNum DESC, (co.`co_custom_sequence_number`+0), co.`co_custom_sequence_number`, CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC";
$arrForCORApprove = ChangeOrder::loadPotentialChangeOrdersByProjectId($database, $RN_project_id, $RN_reportsStartDate, $RN_reportsEndDate,$loadChangeOrdersByCORApprove, $checkRtype);

$arrForCOR = array_merge($arrForCORNotApprove,$arrForCORApprove);


$orderTypeIdForPCO = 1;
$statusIdForPCO = array(1,2);
$potentialPCO = ReportchangeOrderTotalAndDelay($RN_project_id,$orderTypeIdForPCO,$RN_reportsStartDate, $RN_reportsEndDate, $statusIdForPCO, $database);
$potentialPCOTotalAmt = $potentialPCO['total'];
$potentialPCOTotalAmt = Format::formatCurrency($potentialPCOTotalAmt);
$potentialPCODays = $potentialPCO['days']." day(s)";


$orderTypeIdForCORNotApprove = 2;
$statusIdForCORNotApprove = array(1);
$potentialCORNotApprove = ReportchangeOrderTotalAndDelay($RN_project_id,$orderTypeIdForCORNotApprove,$RN_reportsStartDate, $RN_reportsEndDate, $statusIdForCORNotApprove, $database);
$potentialCORNotApproveTotalAmt = $potentialCORNotApprove['total'];
$potentialCORNotApproveTotalAmt = Format::formatCurrency($potentialCORNotApproveTotalAmt);
$potentialCORNotApproveDays = $potentialCORNotApprove['days']." day(s)";


$orderTypeIdForCORApprove = 2;
$statusIdForCORApprove = array(2);
$potentialCORApprove = ReportchangeOrderTotalAndDelay($RN_project_id,$orderTypeIdForCORApprove,$RN_reportsStartDate, $RN_reportsEndDate, $statusIdForCORApprove, $database);

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

if ($cot == '1' || $cot == '1,2' || $cot == '') {
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

    if ($pcoCount == 0) {
        $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available for Selected Dates"); 
        $objPHPExcel->getActiveSheet()->getStyle('A'.$index)->getAlignment()->setIndent(1);
        $index++;
    }else{
        foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
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
            $co_total = $changeOrder->co_total;
            // $totalcovalue=$co_total+$totalcovalue;

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

            if ($coCostCode) {
                // Extra: Change Order Cost Code - Cost Code Division
                $coCostCodeDivision = $coCostCode->getCostCodeDivision();
                /* @var $coCostCodeDivision CostCodeDivision */
                $formattedCoCostCode = $coCostCode->getFormattedCostCodeApi($database, false, $RN_user_company_id);
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
            
            // CO#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_sequence_number);
            if ($change_order_status_id == 3) {                
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setStrikethrough(true);
            }
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);     
            $alphaCharIn++;

            // Custom#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_custom_sequence_number); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;    

            // Type
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_type_abbreviated);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;    

            // Title
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_title); 
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

            // Cost Code
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCostCode);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;

            $incre_id++;
            $index++;
        }
    }
    $objPHPExcel->getActiveSheet()->setCellValue($totalAlpha.$index,"Total Amount");
    $objPHPExcel->getActiveSheet()->getStyle($totalAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($amountAlpha.$index,$potentialPCOTotalAmt);
    $objPHPExcel->getActiveSheet()->getStyle($amountAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($daysAlpha.$index,$potentialPCODays);
    $objPHPExcel->getActiveSheet()->getStyle($daysAlpha.$index)->applyFromArray($styleCenter);    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('dfdfdf');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;
}
if ($cot == '2' || $cot == '1,2' || $cot == '') {
    
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

    if ($corCount == 0) {
        $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available for Selected Dates"); 
        $index++;
    }else{
        foreach ($arrForCORNotApprove as $change_order_id => $changeOrder) {    
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
            $co_total = $changeOrder->co_total;
            // $totalcovalue=$co_total+$totalcovalue;

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

            if ($coCostCode) {
                // Extra: Change Order Cost Code - Cost Code Division
                $coCostCodeDivision = $coCostCode->getCostCodeDivision();
                /* @var $coCostCodeDivision CostCodeDivision */
                $formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false, $RN_user_company_id);
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
            
            // CO#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_sequence_number); 
            if ($change_order_status_id == 3) {                
                $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getFont()->setStrikethrough(true);
            }            
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);     
            $alphaCharIn++;

            // Custom#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_custom_sequence_number); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;    

            // Type
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_type_abbreviated);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;    

            // Title
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_title); 
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

            // Cost Code
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCostCode);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;

            $incre_id++;
            $index++;
        }
    }
    $objPHPExcel->getActiveSheet()->setCellValue($totalAlpha.$index,"Total Amount");
    $objPHPExcel->getActiveSheet()->getStyle($totalAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($amountAlpha.$index,$potentialCORNotApproveTotalAmt);
    $objPHPExcel->getActiveSheet()->getStyle($amountAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($daysAlpha.$index,$potentialCORNotApproveDays);
    $objPHPExcel->getActiveSheet()->getStyle($daysAlpha.$index)->applyFromArray($styleCenter);    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('dfdfdf');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;


    // Open Change Orders Request
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"Approved");
    $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$halfstartPrev.$index);
    $objPHPExcel->getActiveSheet()->setCellValue($halfstart.$index,"Amount");
    $objPHPExcel->getActiveSheet()->setCellValue($halfstartNext.$index,"");
    $objPHPExcel->setActiveSheetIndex()->mergeCells($halfstartNext.$index.':'.$endcol.$index);
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b7b7b7');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;

    if ($corAppCount == 0) {
        $objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':'.$endcol.$index);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"No Data Available for Selected Dates"); 
        $index++;
    }else{
        foreach ($arrForCORApprove as $change_order_id => $changeOrder) {    
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
            $co_total = $changeOrder->co_total;
            // $totalcovalue=$co_total+$totalcovalue;

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

            if ($coCostCode) {
                // Extra: Change Order Cost Code - Cost Code Division
                $coCostCodeDivision = $coCostCode->getCostCodeDivision();
                /* @var $coCostCodeDivision CostCodeDivision */
                $formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false, $RN_user_company_id);
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
            
            // CO#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$co_sequence_number); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);     
            $alphaCharIn++;

            // Custom#
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_custom_sequence_number); 
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter);
            $alphaCharIn++;    

            // Type
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$change_order_type_abbreviated);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;    

            // Title
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_co_title); 
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

            // Cost Code
            $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedCoCostCode);
            $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->applyFromArray($styleCenter); 
            $alphaCharIn++;

            $incre_id++;
            $index++;
        }
    }
    $objPHPExcel->getActiveSheet()->setCellValue($totalAlpha.$index,"Total Amount");
    $objPHPExcel->getActiveSheet()->getStyle($totalAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($amountAlpha.$index,$potentialCORApproveTotalAmt);
    $objPHPExcel->getActiveSheet()->getStyle($amountAlpha.$index)->applyFromArray($styleRight);
    $objPHPExcel->getActiveSheet()->setCellValue($daysAlpha.$index,$potentialCORApproveDays);
    $objPHPExcel->getActiveSheet()->getStyle($daysAlpha.$index)->applyFromArray($styleCenter);    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('dfdfdf');
    $objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);
    $index++;
}

// Total Amount
$totalAmt = Format::FormatCurrency($totalAmt);  

$objPHPExcel->getActiveSheet()->setCellValue($totalAlpha.$index,"Total");
$objPHPExcel->getActiveSheet()->getStyle($totalAlpha.$index)->applyFromArray($styleRight);
$objPHPExcel->getActiveSheet()->setCellValue($amountAlpha.$index,$totalAmt);
$objPHPExcel->getActiveSheet()->getStyle($amountAlpha.$index)->applyFromArray($styleRight);    
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('b7b7b7');
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':'.$endcol.$index)->getFont()->setBold(true);

/*
$filename = urlencode($type_mention)."-".$dates.":".$i.":".$s.".xlsx";
$filenameSheet = $type_mention;
$objPHPExcel->getActiveSheet()->setTitle($filenameSheet);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel,'Excel5');
$objWriter->save('php://output');
?>
*/

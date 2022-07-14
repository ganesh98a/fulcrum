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
require_once('module-report-ajax.php');


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
$index++;
// $objPHPExcel->getActiveSheet()->setCellValue('A'.$index,"DATE : "); 
// $objPHPExcel->getActiveSheet()->setCellValue('B'.$index,  $date .' To '.$date1); 
// $index++;
// $index++;
/*Alphabets A to Z*/
$alphas = range('A', 'Z');

/*content*/
$alphaCharIn = 0;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Request For Information");
$index++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"RFI #");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Description");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Open Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Response Date");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Recipient");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Priority");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Status");
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Days Open");
$alphaCharIn++;
$index++;
$db = DBI::getInstance($database);
$db->free_result();
$loadRequestsForInformationByProjectIdOptions = new Input();
$loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
$arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByProjectIdReport($database, $project_id, $loadRequestsForInformationByProjectIdOptions,$new_begindate, $enddate, $type_mention);
$rfiTableTbody = '';

$Arrayindex=1;
$daysopenArray = array();
foreach ($arrRequestsForInformation as $request_for_information_id => $requestForInformation) {
    /* @var $requestForInformation RequestForInformation */
    $requestForInformationStatus = $requestForInformation->getRequestForInformationStatus();
    $request_for_information_status = $requestForInformationStatus->request_for_information_status;
    $rfi_closed_date = $requestForInformation->rfi_closed_date;
    $rfi_created = $requestForInformation->created;

        // Convert rfi_created to a Unix timestamp
    $openDateUnixTimestamp = strtotime($rfi_created);
        //$openDateDisplayString = date('n/j/Y g:ma');
    $oneDayInSeconds = 86400;
    $daysOpen = '';

    $formattedRfiCreatedDate = date("m/d/Y", $openDateUnixTimestamp);
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
    if (($daysOpenDenominator == 0) || ($daysOpen == '-0')) {
        $daysOpen = 0;
    }
    $daysopenArray[]=$daysOpen;

}
if(isset($daysopenArray[0])){
    rsort($daysopenArray);
    $strlen=strlen($daysopenArray[0]);
}else{
    $strlen=0;
}

foreach ($arrRequestsForInformation as $request_for_information_id => $requestForInformation) {/* @var $requestForInformation RequestForInformation */

    $project = $requestForInformation->getProject();
    /* @var $project Project */
    $responsetext = $requestForInformation->response_text;


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
    $response_text = $requestForInformation->response_text;
    $response_date = $requestForInformation->response_Date;

    if (empty($rfi_due_date)) {
        $rfi_due_date = '&nbsp;';
    }

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

    $formattedRfiCreatedDate = date("m/d/Y", $openDateUnixTimestamp);
    if($response_date!='')
        $formattedRfiResponseDate = date("m/d/Y", strtotime($response_date));
    else
        $formattedRfiResponseDate ='';

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
    if (($daysOpenDenominator == 0) || ($daysOpen < 1)) {
        $daysOpen = 0;
    }
    $daysOpen = str_pad($daysOpen, $strlen, 0, STR_PAD_LEFT);

    $alphaCharIn = 0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$rfi_sequence_number);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_rfi_title);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedRfiCreatedDate);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedRfiResponseDate);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$rfiRecipientContactFullNameHtmlEscaped);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$request_for_information_priority);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$request_for_information_status);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$daysOpen);
    $alphaCharIn++;
    $index++;
}
if(empty($arrRequestsForInformation)){
 $alphaCharIn=0;
 $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available");
}

ob_end_clean();
ob_start();  
// $objPHPExcel->getActiveSheet()->setTitle('Simplesfs');    
// Save Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
$objWriter->setUseBOM(true);
$objWriter->save('php://output');
?>
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

$alphaCharIn = 0;

$db = DBI::getInstance($database);
$db->free_result();

$arrBidders = getBidderArray($database, $user_company_id, $project_id, $sort_by_status, $sort_by_order);

    if (!isset($sort_by_order) || empty($sort_by_order)) {
        $sort_by_order = "company, division_number, cost_code";
    }

    $subcontractorBidderCount = count($arrBidders);

    if (strpos($sort_by_order, 'cost_code') == 0) {
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code");
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Division"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Company"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Contact"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Status"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Phone"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Fax");
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Email"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Bid Amount"); 
        $index++;
        $alphaCharIn=0;
    } else {
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Cost Code");
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Company"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Contact"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Division"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Status"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Phone"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Fax");
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Email"); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Bid Amount"); 
        $index++;
        $alphaCharIn=0;
    }

    $lastCode = '';
    $lastCompany = '';
    foreach ($arrBidders AS $subcontractor_bid_id => $dummy) {
        $alphaCharIn=0;
        $division_number = $arrBidders[$subcontractor_bid_id]['division_number'];
        $division = $arrBidders[$subcontractor_bid_id]['division'];
        $cost_code = $arrBidders[$subcontractor_bid_id]['cost_code'];
        $cost_code_description = $arrBidders[$subcontractor_bid_id]['cost_code_description'];
        $gbli_id = $arrBidders[$subcontractor_bid_id]['gc_budget_line_item_id'];
        $contact_id = $arrBidders[$subcontractor_bid_id]['contact_id'];
        $subcontractor_bid_status_id = $arrBidders[$subcontractor_bid_id]['subcontractor_bid_status_id'];
        $bid_total = $arrBidders[$subcontractor_bid_id]['bid_total'];
        $subcontractor_bid_sort_order = $arrBidders[$subcontractor_bid_id]['subcontractor_bid_sort_order'];
        $subcontractor_bid_status_sort_order = $arrBidders[$subcontractor_bid_id]['subcontractor_bid_status_sort_order'];
        $subcontractor_bid_status = $arrBidders[$subcontractor_bid_id]['subcontractor_bid_status'];
        $contactFullName = $arrBidders[$subcontractor_bid_id]['full_name'];
        $email = $arrBidders[$subcontractor_bid_id]['email'];
        $company = $arrBidders[$subcontractor_bid_id]['company'];
        $formatted_cost_code = "$division_number-$cost_code";
        $escaped_cost_code_description = Data::entity_encode($arrBidders[$subcontractor_bid_id]['cost_code_description']);
        $chkboxEmail = '&nbsp;';
        /*mobile Phone no*/
        $arrContactPhoneNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $contact_id, PhoneNumberType::MOBILE);
            //$arrContactPhoneNumbers = $contact->getPhoneNumberList();
            if (isset($arrContactPhoneNumbers[0]) && !empty($arrContactPhoneNumbers[0])) {
                $contactPhoneNumber = $arrContactPhoneNumbers[0];
                /* @var $contactPhoneNumber ContactPhoneNumber */
                $formattedMobilePhoneNumber = $contactPhoneNumber->getFormattedNumber();
                $contact_mobile_phone_number_id = $contactPhoneNumber->contact_phone_number_id;
                $mobile_network_carrier_id = $contactPhoneNumber->mobile_network_carrier_id;
            } else {
                $formattedMobilePhoneNumber = '';
                $contact_mobile_phone_number_id = 0;
                $mobile_network_carrier_id = '';
            }
            // Fax...needs some refactoring all around...quick and dirty for now...
            $arrContactFaxNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $contact_id, PhoneNumberType::BUSINESS_FAX);
            if (isset($arrContactFaxNumbers[0]) && !empty($arrContactFaxNumbers[0])) {
                $contactFaxNumber = $arrContactFaxNumbers[0];
                /* @var $contactFaxNumber ContactPhoneNumber */
                $formattedFaxNumber = $contactFaxNumber->getFormattedNumber();
                $contact_fax_number_id = $contactFaxNumber->contact_phone_number_id;
            } else {
                $formattedFaxNumber = '';
                $contact_fax_number_id = 0;
            }
        if (isset($email) && !empty($email)) {

            $chkboxEmail = <<<END_HTML_CONTENT
<input id="chk_$subcontractor_bid_id" type="checkbox" value="$email">
END_HTML_CONTENT;

        }
        if ($lastCode != $formatted_cost_code) {
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formatted_cost_code.' - '.$escaped_cost_code_description); 
        }
        $alphaCharIn++;
        if (strpos($sort_by_order, 'cost_code') == 0) {

            $formatted_bid_total = money_format('%!i', $bid_total);
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$division);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$company);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$contactFullName);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subcontractor_bid_status);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedMobilePhoneNumber);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedFaxNumber);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$email); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formatted_bid_total);
        $index++;
        } else {

            $formatted_bid_total = money_format('%!i', $bid_total);
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$company); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$contactFullName); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$division); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$subcontractor_bid_status); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedMobilePhoneNumber); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedFaxNumber);
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$email); 
        $alphaCharIn++;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formatted_bid_total); 
        $index++;
        }

        /*$lastCode = $cost_code;*/
        /*$lastCompany = $company;*/
        $lastCode = $formatted_cost_code;
        $lastCompany = $escaped_company;

    }
    if(empty($arrBidders)){
        $alphaCharIn=0;
        $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's not Available");
    }
ob_end_clean();
ob_start();  
// $objPHPExcel->getActiveSheet()->setTitle('Simplesfs');    
// Save Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
$objWriter->setUseBOM(true);
$objWriter->save('php://output');
?>
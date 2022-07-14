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
$styleLeft = array(
   'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    )
   ); 
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleRight);
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':I'.($index));
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
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':D'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('E'.$index.':I'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('E'.($index))->applyFromArray($styleRight);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':I'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('E'.($index))->getAlignment()->setIndent(1);
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

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Number");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Name");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Recipient");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Submitted");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Target");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Priority");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Approved Date");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Days Open");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Status");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$lastAlphaIn = $alphaCharIn;
$alphaCharIn=0;
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->getColor()->setRGB('FFFF');
$index++;


$db = DBI::GetInstance($database);
$db->free_result();
$loadSubmittalsByProjectIdOptions = new Input();
$loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
$arrSubmittals = Submittal::loadSubmittalsByProjectIdAndStatus($database, $project_id, null,$new_begindate,$enddate);

$suTableTbody = '';
$GetCount=count($arrSubmittals);
if($GetCount == '0')
{
   $alphaCharIn=0;
   $objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index);
   $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"No Submittals Exist.");
}

foreach ($arrSubmittals as $submittal_id => $submittal) {
    /* @var $submittal Submittal */
    $submittalStatus = $submittal->getSubmittalStatus();
    $submittal_status = $submittalStatus->submittal_status;
    $submittalId = $submittalStatus->id;
    $status_type = $_GET['cot'];
    $statusArr = explode(',', $status_type);
    if ($status_type != 'null' && !in_array($submittalId, $statusArr)) {
        continue;
    }

    $project = $submittal->getProject();
    /* @var $project Project */

    $submittalType = $submittal->getSubmittalType();
    /* @var $submittalType SubmittalType */

    $submittalPriority = $submittal->getSubmittalPriority();
    /* @var $submittalPriority SubmittalPriority */
    $submittal_priority = $submittalPriority->submittal_priority;

    $submittalDistributionMethod = $submittal->getSubmittalDistributionMethod();
    /* @var $submittalDistributionMethod SubmittalDistributionMethod */
    $submittal_distribution_method = $submittalDistributionMethod->submittal_distribution_method;

    $suFileManagerFile = $submittal->getSuFileManagerFile();
    /* @var $suFileManagerFile FileManagerFile */

    $suCostCode = $submittal->getSuCostCode();
    /* @var $suCostCode CostCode */

    $suCreatorContact = $submittal->getSuCreatorContact();
    /* @var $suCreatorContact Contact */

    $suCreatorContactCompanyOffice = $submittal->getSuCreatorContactCompanyOffice();
    /* @var $suCreatorContactCompanyOffice ContactCompanyOffice */

    $suCreatorPhoneContactCompanyOfficePhoneNumber = $submittal->getSuCreatorPhoneContactCompanyOfficePhoneNumber();
    /* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

    $suCreatorFaxContactCompanyOfficePhoneNumber = $submittal->getSuCreatorFaxContactCompanyOfficePhoneNumber();
    /* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

    $suCreatorContactMobilePhoneNumber = $submittal->getSuCreatorContactMobilePhoneNumber();
    /* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */

    $suCreatorContactMobilePhoneNumber = $submittal->getSuCreatorContactMobilePhoneNumber();
    /* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */

    $suRecipientContact = $submittal->getSuRecipientContact();
    /* @var $suRecipientContact Contact */

    $suRecipientContactCompanyOffice = $submittal->getSuRecipientContactCompanyOffice();
    /* @var $suRecipientContactCompanyOffice ContactCompanyOffice */

    $suRecipientPhoneContactCompanyOfficePhoneNumber = $submittal->getSuRecipientPhoneContactCompanyOfficePhoneNumber();
    /* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

    $suRecipientFaxContactCompanyOfficePhoneNumber = $submittal->getSuRecipientFaxContactCompanyOfficePhoneNumber();
    /* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

    $suRecipientContactMobilePhoneNumber = $submittal->getSuRecipientContactMobilePhoneNumber();
    /* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */

    $suInitiatorContact = $submittal->getSuInitiatorContact();
    /* @var $suInitiatorContact Contact */

    $suInitiatorContactCompanyOffice = $submittal->getSuInitiatorContactCompanyOffice();
    /* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */

    $suInitiatorPhoneContactCompanyOfficePhoneNumber = $submittal->getSuInitiatorPhoneContactCompanyOfficePhoneNumber();
    /* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

    $suInitiatorFaxContactCompanyOfficePhoneNumber = $submittal->getSuInitiatorFaxContactCompanyOfficePhoneNumber();
    /* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

    $suInitiatorContactMobilePhoneNumber = $submittal->getSuInitiatorContactMobilePhoneNumber();
    /* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */

    $su_sequence_number = $submittal->su_sequence_number;
    $submittal_type_id = $submittal->submittal_type_id;
    $submittal_status_id = $submittal->submittal_status_id;
    $submittal_priority_id = $submittal->submittal_priority_id;
    $submittal_distribution_method_id = $submittal->submittal_distribution_method_id;
    $su_file_manager_file_id = $submittal->su_file_manager_file_id;
    $su_cost_code_id = $submittal->su_cost_code_id;
    $su_creator_contact_id = $submittal->su_creator_contact_id;
    $su_creator_contact_company_office_id = $submittal->su_creator_contact_company_office_id;
    $su_creator_phone_contact_company_office_phone_number_id = $submittal->su_creator_phone_contact_company_office_phone_number_id;
    $su_creator_fax_contact_company_office_phone_number_id = $submittal->su_creator_fax_contact_company_office_phone_number_id;
    $su_creator_contact_mobile_phone_number_id = $submittal->su_creator_contact_mobile_phone_number_id;
    $su_recipient_contact_id = $submittal->su_recipient_contact_id;
    $su_recipient_contact_company_office_id = $submittal->su_recipient_contact_company_office_id;
    $su_recipient_phone_contact_company_office_phone_number_id = $submittal->su_recipient_phone_contact_company_office_phone_number_id;
    $su_recipient_fax_contact_company_office_phone_number_id = $submittal->su_recipient_fax_contact_company_office_phone_number_id;
    $su_recipient_contact_mobile_phone_number_id = $submittal->su_recipient_contact_mobile_phone_number_id;
    $su_initiator_contact_id = $submittal->su_initiator_contact_id;
    $su_initiator_contact_company_office_id = $submittal->su_initiator_contact_company_office_id;
    $su_initiator_phone_contact_company_office_phone_number_id = $submittal->su_initiator_phone_contact_company_office_phone_number_id;
    $su_initiator_fax_contact_company_office_phone_number_id = $submittal->su_initiator_fax_contact_company_office_phone_number_id;
    $su_initiator_contact_mobile_phone_number_id = $submittal->su_initiator_contact_mobile_phone_number_id;
    $su_title = $submittal->su_title;
    $su_plan_page_reference = $submittal->su_plan_page_reference;
    $su_statement = $submittal->su_statement;
    $su_created = $submittal->created;
    $su_due_date = $submittal->su_due_date;
    $su_closed_date = $submittal->su_closed_date;

        // HTML Entity Escaped Data
    $submittal->htmlEntityEscapeProperties();
    $escaped_su_plan_page_reference = $submittal->escaped_su_plan_page_reference;
    $escaped_su_statement = $submittal->escaped_su_statement;
    $escaped_su_statement_nl2br = $submittal->escaped_su_statement_nl2br;
    $escaped_su_title = $submittal->escaped_su_title;

    if (empty($su_due_date)) {
        $su_due_date = '';
    }

    if (empty($escaped_su_plan_page_reference)) {
        $escaped_su_plan_page_reference = '';
    }

    if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
        $suCostCodeDivision = $suCostCode->getCostCodeDivision();
        /* @var $suCostCodeDivision CostCodeDivision */

        $formattedSuCostCode = $suCostCode->getFormattedCostCode($database,false);

    } else {
        $formattedSuCostCode = '';
    }

        //$recipient = Contact::findContactByIdExtended($database, $su_recipient_contact_id);
    /* @var $recipient Contact */

    if ($suRecipientContact) {
        $suRecipientContactFullName = $suRecipientContact->getContactFullName();
        $suRecipientContactFullNameHtmlEscaped = $suRecipientContact->getContactFullNameHtmlEscaped();
    } else {
        $suRecipientContactFullName = '';
        $suRecipientContactFullNameHtmlEscaped = '';
    }

        // Convert su_created to a Unix timestamp
    $openDateUnixTimestamp = strtotime($su_created);
        //$openDateDisplayString = date('n/j/Y g:ma');
    $oneDayInSeconds = 86400;
    $daysOpen = '';

    $formattedSuCreatedDate = date("m/d/Y", $openDateUnixTimestamp);
    $su_due_date=date("m/d/Y",strtotime($su_due_date));
        
    // if Submittal status is "closed"
    if (!$su_closed_date) {
        $su_closed_date = '0000-00-00';
    }
     if($su_closed_date !="0000-00-00")
        {
            $formattedsu_closed_date=date("m/d/Y",strtotime($su_closed_date));
        }else
        {
            $formattedsu_closed_date="";
        }
    
        // start of days calculation

        $subclosedLog = SubmittalStatus::getClosedDateDetails($database,$submittal_id);
        $subopenarr = $subclosedLog['open'];
        $subclosedarr = $subclosedLog['closed'];

        $openingdate = explode(' ', $su_created);
        // adding the open date
        array_unshift($subopenarr , $openingdate[0]);

        // if the submittal is not closed then push the current date for calculation
        if($su_closed_date !="")
        {
            $assumingAs = date('Y-m-d');
            array_push($subclosedarr , $assumingAs);
        }

        $daysOpen =0;
        if(!empty($subclosedLog))
        {

        foreach ($subopenarr as $key => $cdate) {
            $date1=date_create($cdate);
            // if the status has changed to open continuously to avoid adding as many time breaking the loop
            if($subclosedarr[$key] == ''){
                break;
            }
            $date2=date_create($subclosedarr[$key]);
            $diff=date_diff($date1,$date2);
            $diff3= $diff->format("%a");
            $daysOpen =$daysOpen + intval($diff3);
        }
        }
        // End of days calculation
    
        // There was an instance of $daysOpen showing as "-0"
    if (($daysOpen == 0) || ($daysOpen == '-0')) {
        $daysOpen = 0;
    }
    $count_days=strlen($daysOpen);
    if($count_days=='1')
    {
        $daysOpen='00'.$daysOpen;
    }else if($count_days=='2')
    {
        $daysOpen='0'.$daysOpen;
    }
    $count_seq=strlen($su_sequence_number);
    if($count_seq=='1')
    {
        $su_sequence_number='00'.$su_sequence_number;
    }else if($count_seq=='2')
    {
        $su_sequence_number='0'.$su_sequence_number;
    }

    $alphaCharIn=0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$su_sequence_number);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$escaped_su_title);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$suRecipientContactFullNameHtmlEscaped);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedSuCreatedDate);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$su_due_date);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$submittal_priority);
    $alphaCharIn++;
     $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$formattedsu_closed_date);
    $alphaCharIn++;    
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$daysOpen);
    $alphaCharIn++;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$submittal_status);
    $alphaCharIn++;
    $index++;
}



?>

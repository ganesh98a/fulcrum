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
$companyName = $userCompanyName;

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



$session = Zend_Registry::get('session');
/* @var $session Session */
$debugMode = $session->getDebugMode();

$project = Project::findProjectByIdExtended($database, $project_id);
/* @var $project Project */

    // $project->htmlEntityEscapeProperties();
$escaped_project_name = $project->escaped_project_name;

$loadGcBudgetLineItemsByProjectIdOptions = new Input();
$loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
    'gbli_fk_codes__fk_ccd.`division_number`' => 'ASC',
    'gbli_fk_codes.`cost_code`' => 'ASC'
    );
    //$loadGcBudgetLineItemsByProjectIdOptions->offset = 0;
    //$loadGcBudgetLineItemsByProjectIdOptions->limit = 10;
    //$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions);
$gcBudgetForm = '';

    // project_bid_invitations - PDF Urls
$arrReturn = renderProjectBidInvitationFilesAsUrlList($database, $project_id);
$projectBidInvitationFilesCount = $arrReturn['file_count'];
$projectBidInvitationFilesAsUrlList = $arrReturn['html'];

   // Configure the project_bid_invitation file uploader.
$virtual_file_path = '/Bidding & Purchasing/Project Bid Invitations/';
$projectBidInvitationsFileManagerFolder =
FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $virtual_file_path);
/* @var $projectBidInvitationsFileManagerFolder FileManagerFolder */
$project_bid_invitation_file_manager_folder_id = $projectBidInvitationsFileManagerFolder->file_manager_folder_id;

$input = new Input();
$input->id = "budgetFileUploader_projectBidInvitations_{$project_id}";
$input->folder_id = $project_bid_invitation_file_manager_folder_id;
$input->project_id = $project_id;
$input->virtual_file_path = $virtual_file_path;
$input->virtual_file_name = '';
$input->action = '/modules-purchasing-file-uploader-ajax.php';
$input->method = 'projectBidInvitations';
$input->allowed_extensions = 'pdf';
$input->append_date_to_filename = 1;
    //$input->post_upload_js_callback = "projectBidInvitationFileUploaded(arrFileManagerFiles, 'projectBidInvitationFile')";
$input->custom_label = 'Drop/Click';
$input->style = 'vertical-align: middle;';

$projectBidInvitationsFileUploader = buildFileUploader($input);

    // Table sort/filter section copied from Purchasing.
$arrCostCodeDivisionsByUserCompanyIdAndProjectId = CostCodeDivision::loadCostCodeDivisionsByUserCompanyIdAndProjectId($database, $user_company_id, $project_id);

$costCodeDivisionOptions = '';

foreach ($arrCostCodeDivisionsByUserCompanyIdAndProjectId AS $cost_code_division_id => $costCodeDivision) {
    /* @var $costCodeDivision CostCodeDivision*/

    $costCodeDivision->htmlEntityEscapeProperties();

    $escaped_division_number = $costCodeDivision->escaped_division_number;
    $escaped_division_code_heading = $costCodeDivision->escaped_division_code_heading;
    $escaped_division = $costCodeDivision->escaped_division;
    $divisionHeadline = "$escaped_division_number $escaped_division";
        //$divisionHeadline = "$escaped_division_number-$escaped_division_code_heading $escaped_division";
        //$divisionHeadline = "$escaped_division ($escaped_division_number-$escaped_division_code_heading)";

}
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Trade"); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Company"); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Contact"); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Phone"); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Fax"); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Address"); 
$index++;
$alphaCharIn=0;




    //$loadGcBudgetLineItemsByProjectIdOptions->offset = 0;
    //$loadGcBudgetLineItemsByProjectIdOptions->limit = 10;
$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions);
$arrAllSubcontractorBidStatuses = SubcontractorBidStatus::loadAllSubcontractorBidStatuses($database);
$arrSubcontractorBidStatusCountsByProjectId = SubcontractorBid::loadSubcontractorBidStatusCountsByProjectId($database, $user_company_id, $project_id, $cost_code_division_id_filter);

$session = Zend_Registry::get('session');
/* @var $session Session */
$debugMode = $session->getDebugMode();
$gcBudgetLineItemsTbody = '';
$primeContractScheduledValueTotal = 0.00;
$forecastedExpensesTotal = 0.00;
$subcontractActualValueTotal = 0.00;
$varianceTotal = 0.00;
$loopCounter = 1;
$tabindex = 100;
$tabindex2 = 200;
foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
    $alphaCharIn=0;
    $costCode = $gcBudgetLineItem->getCostCode();
    /* @var $costCode CostCode */
    $costCode->htmlEntityEscapeProperties();
    $costCodeDivision = $costCode->getCostCodeDivision();
    /* @var $costCodeDivision CostCodeDivision */
    $costCodeDivision->htmlEntityEscapeProperties();
    $contactCompany = $gcBudgetLineItem->getContactCompany();
    /* @var $contactCompany ContactCompany */
    $costCodeDivisionAlias = $gcBudgetLineItem->getCostCodeDivisionAlias();
    /* @var $costCodeDivisionAlias CostCodeDivisionAlias */
    $costCodeAlias = $gcBudgetLineItem->getCostCodeAlias();
    /* @var $costCodeAlias CostCodeAlias */
    $subcontractorBid = $gcBudgetLineItem->getSubcontractorBid();
    $cost_code_id = $costCode->cost_code_id;
    $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
    $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
    $arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
    if (isset($arrSubcontracts) && !empty($arrSubcontracts)) {
        $subcontractCount = count($arrSubcontracts);
    } else {
        $subcontractCount = 0;
    }
    $subcontractCountview=$subcontractCount;
    $subcontract_actual_value_raw = $subcontract_actual_value = null;
    $vendorList = '';
    $target_date = '';
    $arrSubcontractActualValueHtml = array();
    $arrSubcontractVendorHtml = array();
    $arrSubcontractTargetExecutionDateHtmlInputs = array();
    $arrSubcontractVendorNameHtml= array();
    $arrSubcontractVendorfaxHtml= array();
    $arrSubcontractVendorMobileHtml= array();
    $arrSubcontractVendorAddressHtml = array();
        //vendor list loop/
    foreach ($arrSubcontracts as $subcontract) {
        $tmp_subcontract_sequence_number = $subcontract->subcontract_sequence_number;
        $tmp_contact_company_id = $subcontract->subcontract_vendor_contact_id;
        $tmp_subcontract_id = $subcontract->subcontract_id;
        $vendor = $subcontract->getVendor();
        $vendor_contact_company_id = null;
        $subcontract_vendor_contact_id = null;
        $address=null;
        $tmpSubcontractVendorNameHtmlInputs='';
        $tmpSubcontractVendorfaxHtmlInputs='';
        $tmpSubcontractVendorMobileHtmlInputs='';
        $address='';
        $formattedBusinessPhoneNumber='';
        $tmpSubcontractVendorAddressHtmlInputs='';
        //vendor list
        if ($vendor) {
           $vendor_contact_company_id = $vendor->vendor_contact_company_id;
           $vendorContactCompany = $vendor->getVendorContactCompany();
           /* @var $vendorContactCompany ContactCompany */
           $vendorContactCompany->htmlEntityEscapeProperties();
           $vendorList .= $vendorContactCompany->escaped_contact_company_name . ', ';
           if ($subcontractCount == 1) {
               $tmpSubcontractVendorHtmlInputs = $vendorContactCompany->escaped_contact_company_name;
           } elseif ($subcontractCount > 1) {
            $tmpSubcontractVendorHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$vendorContactCompany->escaped_contact_company_name;
        }
        $arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;
            //Get vendor contact
        $vendorContact = $vendor->getVendorContact();
        if (isset($vendorContact) && $vendorContact && ($vendorContact instanceof Contact)) {
            if (!isset($subcontract_vendor_contact_id) || empty($subcontract_vendor_contact_id)) {
               $subcontract_vendor_contact_id = $vendorContact->contact_id;
           } else {
                    //$subcontract_vendor_contact_id = false;
           }
       }
       
       if($subcontract_vendor_contact_id){
        $conuser_id=null;
        $conemail_id=null;
        $contactFullName=null;
        $concontact_id=null;
               //if Vendor contact present.then get the name of contact person
               // if (isset($vendor_contact_company_id) && !empty($vendor_contact_company_id)) {
        $loadContactsByContactCompanyIdOptions = new Input();
        $loadContactsByContactCompanyIdOptions->forceLoadFlag = true;
        $arrVendorContacts = Contact::loadContactsByContactCompanyId($database, $vendor_contact_company_id, $loadContactsByContactCompanyIdOptions);
        foreach ($arrVendorContacts as $object) {
            $k=$object->contact_id;
            if($k==$subcontract_vendor_contact_id){
                $concontact_id=$k;
                $conuser_id=$object->user_id;
                $conemail_id=$object->email;
                $contactFullName = $object->getContactFullName();
            }
        }
                //store the contact person name
        if ($subcontractCount == 1) {
            $tmpSubcontractVendorNameHtmlInputs = $contactFullName;
        } elseif ($subcontractCount > 1) {
            if($contactFullName!=''){
                $tmpSubcontractVendorNameHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$contactFullName;
            }else{
                $tmpSubcontractVendorNameHtmlInputs = <<<END_HTML_CONTENT
END_HTML_CONTENT;
            }
        }
                //Get the Contact person fax No
        $arrContactFaxNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $concontact_id, PhoneNumberType::BUSINESS_FAX);
        if (isset($arrContactFaxNumbers[0]) && !empty($arrContactFaxNumbers[0])) {
            $contactFaxNumber = $arrContactFaxNumbers[0];
            /* @var $contactFaxNumber ContactPhoneNumber */
            $formattedFaxNumber = $contactFaxNumber->getFormattedNumber();
            $contact_fax_number_id = $contactFaxNumber->contact_phone_number_id;
        } else {
            $formattedFaxNumber = '';
            $contact_fax_number_id = 0;
        }
                //store the fax no 
        if ($subcontractCount == 1) {
            $tmpSubcontractVendorfaxHtmlInputs = $formattedFaxNumber;
        } elseif ($subcontractCount > 1) {
            if($formattedFaxNumber!=''){
                $tmpSubcontractVendorfaxHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$formattedFaxNumber;
            }else{
                $tmpSubcontractVendorfaxHtmlInputs = <<<END_HTML_CONTENT
END_HTML_CONTENT;
            }
        }
             //Get the contact person Mobile No
        $arrContactPhoneNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $concontact_id, PhoneNumberType::MOBILE);
              //if Mobile no Not mention check the bussines no
        if(empty($arrContactPhoneNumbers)){
            $arrContactPhoneNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $concontact_id, PhoneNumberType::BUSINESS);
        }
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

     if ($subcontractCount == 1) {
        $tmpSubcontractVendorMobileHtmlInputs = $formattedMobilePhoneNumber;
    } elseif ($subcontractCount > 1) {
        if($formattedMobilePhoneNumber!=''){
           $tmpSubcontractVendorMobileHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$formattedMobilePhoneNumber;
       }else{
        $tmpSubcontractVendorMobileHtmlInputs = <<<END_HTML_CONTENT
END_HTML_CONTENT;
    }
}
$arrContactCompanyOfficesByContactCompanyId = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyIdReport($database, $vendor_contact_company_id);
                // print_r($arrContactCompanyOfficesByContactCompanyId);
                //echo $concontact_id."<br>";
$db = DBI::getInstance($database);
$query = "SELECT * FROM contacts_to_contact_company_offices where contact_id = $concontact_id ";
$db->execute($query);
$records = array();
$records=array();
while($row = $db->fetch())
{
    $records['contact_company_office_id'] = $row['contact_company_office_id'];
}      
$db->free_result(); 

$selected_id = $records['contact_company_office_id'];
                 // echo "<pre>";
                 // print_r($arrContactCompanyOfficesByContactCompanyId);
foreach ($arrContactCompanyOfficesByContactCompanyId as $contact_company_office_id => $contactCompanyOffice) {
   $contact_company_office_id = $contactCompanyOffice->contact_company_office_id;
   $address_line_1 = $contactCompanyOffice->address_line_1;
   $address_line_2 = $contactCompanyOffice->address_line_2;
   $address_line_3 = $contactCompanyOffice->address_line_3;
   $address_line_4 = $contactCompanyOffice->address_line_4;
   $office_nickname = $contactCompanyOffice->office_nickname;
   $address_city = $contactCompanyOffice->address_city;
   $address_county = $contactCompanyOffice->address_county;
   $address_state_or_region = $contactCompanyOffice->address_state_or_region;
   $address_country = $contactCompanyOffice->address_country;
   if($selected_id==$contact_company_office_id){
    $address = $address_line_1 . ' ' . $address_line_2 . ' ' . $address_line_3 . ' ' . $address_line_4;
}

}
if ($subcontractCount == 1) {
    $tmpSubcontractVendorAddressHtmlInputs = $address;
} elseif ($subcontractCount > 1) {
    if($address!=''){
        $tmpSubcontractVendorAddressHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address;
    }
}                
             //}
}else{
                //Vendor Details
   $tmpSubcontractVendorAddressHtmlInputs=null;
   $tmpSubcontractVendorfaxHtmlInputs=null;
   $arrContactCompanyOffices=null;
   $formattedBusinessPhoneNumber=null;
   $contactCompanyOffice=null;
   $businessFaxNumber=null;
   $arrContactCompanyOfficess = ContactCompanyOffice::loadContactCompanyOfficesByContactCompanyIdReport($database, $vendor_contact_company_id, null);
   /*Fetch the vendor office details*/
   if(!empty($arrContactCompanyOfficess)){
       foreach ($arrContactCompanyOfficess as $key => $contactCompanyOfficesc) {
        $address_line_1 = $contactCompanyOfficesc->address_line_1;
        $address_line_2 = $contactCompanyOfficesc->address_line_2;
        $address_line_3 = $contactCompanyOfficesc->address_line_3;
        $address_line_4 = $contactCompanyOfficesc->address_line_4;
        $address = $address_line_1.' '.$address_line_2.' '.$address_line_3.' '.$address_line_4;
        $businessPhoneNumber = $contactCompanyOfficesc->getBusinessPhoneNumber();
        /* @var $businessPhoneNumber ContactCompanyOfficePhoneNumber */
        if ($businessPhoneNumber) {
            $formattedBusinessPhoneNumber = $businessPhoneNumber->getFormattedPhoneNumber();
        } else {
            $formattedBusinessPhoneNumber = '';
        }
        $businessFaxNumber = $contactCompanyOfficesc->getBusinessFaxNumber();
        /* @var $businessFaxNumber ContactCompanyOfficePhoneNumber */
        if ($businessFaxNumber) {
         $formattedBusinessFaxNumber = $businessFaxNumber->getFormattedPhoneNumber();
     } else {
        $formattedBusinessFaxNumber = '';
    }
}
             //store office business no
if ($subcontractCount == 1) {
    $tmpSubcontractVendorMobileHtmlInputs = $formattedBusinessPhoneNumber;
} elseif ($subcontractCount > 1) {
    if($formattedBusinessPhoneNumber!=''){
        $tmpSubcontractVendorMobileHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$formattedBusinessPhoneNumber;
    }
}
               //store office fax no
if ($subcontractCount == 1) {
    $tmpSubcontractVendorfaxHtmlInputs = $formattedBusinessFaxNumber;
} elseif ($subcontractCount > 1) {
    if($formattedBusinessFaxNumber!=''){
        $tmpSubcontractVendorfaxHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$formattedBusinessFaxNumber;
    }
}
                //store office address
if ($subcontractCount == 1) {
    $tmpSubcontractVendorAddressHtmlInputs = $address;
} elseif ($subcontractCount > 1) {
    if($address!=''){
        $tmpSubcontractVendorAddressHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address;
    }
}
}
}
            //contact person end
}//vendor list end
/*Variables stored into array*/
$arrSubcontractVendorMobileHtml[] = $tmpSubcontractVendorMobileHtmlInputs;
$arrSubcontractVendorfaxHtml[] = $tmpSubcontractVendorfaxHtmlInputs;
$arrSubcontractVendorNameHtml[] = $tmpSubcontractVendorNameHtmlInputs;
$arrSubcontractVendorAddressHtml[] = $tmpSubcontractVendorAddressHtmlInputs;
}
        //vendor loop end/
$vendorNameList = implode("\n", $arrSubcontractVendorNameHtml);
$vendorFaxList = implode("\n", $arrSubcontractVendorfaxHtml);
$vendorPhoneList = implode("\n", $arrSubcontractVendorMobileHtml);
$vendorAddressList = implode("\n", $arrSubcontractVendorAddressHtml);
        //$vendorList = trim($vendorList, ' ,');
$vendorList = implode("\n", $arrSubcontractVendorHtml);

if ($loopCounter%2) {
    $rowStyle = 'oddRow';
} else {
    $rowStyle = 'evenRow';
}
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costCodeDivision->escaped_division_number." - ". $costCode->escaped_cost_code." - ".$costCode->escaped_cost_code_description ); 
        // $alphaCharIn++;
        // $stre= "$costCode->escaped_cost_code_description";
        // $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$stre); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorList); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorNameList); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorPhoneList); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorFaxList); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorAddressList); 
$index++;
$loopCounter++;
}
if(empty($arrGcBudgetLineItemsByProjectId)){
    $alphaCharIn=0;
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available"); 
}
ob_end_clean();
ob_start();
$objPHPExcel->getActiveSheet()->setTitle('Simplesfs');    
// Save Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

$objWriter->save('php://output');
?>
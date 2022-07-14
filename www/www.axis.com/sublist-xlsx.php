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
/**Cost code divider*/
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
$styleLeft = array(
   'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    )
   ); 
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleRight);
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.($index).':H'.($index));
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
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$index,"ADDRESS : ".$add_val); 
}else{
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$index,""); 
}
/*cell merge*/
$objPHPExcel->setActiveSheetIndex()->mergeCells('A'.$index.':C'.$index);
$objPHPExcel->setActiveSheetIndex()->mergeCells('D'.$index.':H'.$index);
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->applyFromArray($styleLeft);
$objPHPExcel->getActiveSheet()->getStyle('D'.($index))->applyFromArray($styleRight);
/*cell background color*/
$objPHPExcel->getActiveSheet()->getStyle('A'.$index.':H'.$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
$objPHPExcel->getActiveSheet()->getStyle('A'.($index))->getAlignment()->setIndent(1);
$objPHPExcel->getActiveSheet()->getStyle('D'.($index))->getAlignment()->setIndent(1);
/*cell height*/
$objPHPExcel->getActiveSheet()->getRowDimension(($index))->setRowHeight(20);
$index = $index + 2;
//Fetch the Data's
$alphas = range('A', 'Z');
$alphaCharIn = 0;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Trade"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn  = $alphaCharIn + 1;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Company"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn  = $alphaCharIn + 1;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Contact"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn  = $alphaCharIn + 1;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Email"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn  = $alphaCharIn + 1;

$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Phone"); 
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
// $alphaCharIn  = $alphaCharIn + 1;
// $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Fax"); 
// $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true);
$alphaCharIn  = $alphaCharIn + 1;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Address");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true); 

$alphaCharIn  = $alphaCharIn + 1;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"City");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true); 
$alphaCharIn  = $alphaCharIn + 1;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"State");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true); 
$alphaCharIn  = $alphaCharIn + 1;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Zip");
$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$alphaCharIn])->setAutoSize(true); 
$lastAlphaIn = $alphaCharIn;
$alphaCharIn = 0;
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('2481c3');
/*cell font color*/
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index)->getFont()->getColor()->setRGB('FFFF');

$index++;

$session = Zend_Registry::get('session');
/* @var $session Session */
$debugMode = $session->getDebugMode();

$project = Project::findProjectByIdExtended($database, $project_id);
/* @var $project Project */
$escaped_project_name = $project->escaped_project_name;

$loadGcBudgetLineItemsByProjectIdOptions = new Input();
$loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
    'gbli_fk_codes__fk_ccd.`division_number`' => 'ASC',
    'gbli_fk_codes.`cost_code`' => 'ASC'
    );
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

}
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
    $arrSubcontractVendorEmailHtml= array();
    $arrSubcontractVendorfaxHtml= array();
    $arrSubcontractVendorMobileHtml= array();
    $arrSubcontractVendorAddressHtml = array();
    $arrSubcontractVendorCityHtml = array();
    $arrSubcontractVendorStateHtml = array();
    $arrSubcontractVendorZipHtml = array();
        //vendor list loop/
     $vendorNameList ="";
    foreach ($arrSubcontracts as $subcontract) {
        $tmp_subcontract_sequence_number = $subcontract->subcontract_sequence_number;
        $tmp_contact_company_id = $subcontract->subcontract_vendor_contact_id;
        $tmp_subcontract_id = $subcontract->subcontract_id;
        $vendor = $subcontract->getVendor();
        $vendor_contact_company_id = null;
        $subcontract_vendor_contact_id = null;
        $address=null;
        $tmpSubcontractVendorNameHtmlInputs='';
        $tmpSubcontractVendorEmailHtmlInputs='';
        $tmpSubcontractVendorfaxHtmlInputs='';
        $tmpSubcontractVendorMobileHtmlInputs='';
        $address='';
        $formattedBusinessPhoneNumber='';
        $tmpSubcontractVendorAddressHtmlInputs='';
        $tmpSubcontractVendorCityHtmlInputs='';
        $tmpSubcontractVendorStateHtmlInputs='';
        $tmpSubcontractVendorZipHtmlInputs='';
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
        $contactEmail=null;
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
                $contactEmail =$object->email;
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

              //store the contact email
        if ($subcontractCount == 1) {
            $tmpSubcontractVendorEmailHtmlInputs = $contactEmail;
        } elseif ($subcontractCount > 1) {
            if($contactEmail!=''){
                $tmpSubcontractVendorEmailHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$contactEmail;
            }else{
                $tmpSubcontractVendorEmailHtmlInputs = <<<END_HTML_CONTENT
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
 $address_postal_code = $contactCompanyOffice->address_postal_code;
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

if ($subcontractCount == 1) {
    $tmpSubcontractVendorCityHtmlInputs = $address_city;
} elseif ($subcontractCount > 1) {
    if($address_city!=''){
        $tmpSubcontractVendorCityHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address_city;
    }
} 
if ($subcontractCount == 1) {
    $tmpSubcontractVendorStateHtmlInputs = $address_state_or_region;
} elseif ($subcontractCount > 1) {
    if($address_state_or_region!=''){
        $tmpSubcontractVendorStateHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address_state_or_region;
    }
} 
if ($subcontractCount == 1) {
    $tmpSubcontractVendorZipHtmlInputs = $address_postal_code;
} elseif ($subcontractCount > 1) {
    if($address_postal_code!=''){
        $tmpSubcontractVendorZipHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address_postal_code;
    }
}              
             //}
}else{
                //Vendor Details
 $tmpSubcontractVendorAddressHtmlInputs=null;
 $tmpSubcontractVendorfaxHtmlInputs=null;
 $tmpSubcontractVendorCityHtmlInputs=null;
 $tmpSubcontractVendorStateHtmlInputs=null;
 $tmpSubcontractVendorZipHtmlInputs=null;
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
        $address_city = $contactCompanyOfficesc->address_city;
        $address_state_or_region = $contactCompanyOfficesc->address_state_or_region;
        $address_postal_code = $contactCompanyOfficesc->address_postal_code;
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
           //store office city
if ($subcontractCount == 1) {
    $tmpSubcontractVendorCityHtmlInputs = $address_city;
} elseif ($subcontractCount > 1) {
    if($address_city!=''){
        $tmpSubcontractVendorCityHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address_city;
    }
}                //store office state
if ($subcontractCount == 1) {
    $tmpSubcontractVendorStateHtmlInputs = $address_state_or_region;
} elseif ($subcontractCount > 1) {
    if($address_state_or_region!=''){
        $tmpSubcontractVendorStateHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address_state_or_region;
    }
}                //store office zip
if ($subcontractCount == 1) {
    $tmpSubcontractVendorZipHtmlInputs = $address_postal_code;
} elseif ($subcontractCount > 1) {
    if($address_postal_code!=''){
        $tmpSubcontractVendorZipHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address_postal_code;
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
$arrSubcontractVendorEmailHtml[] = $tmpSubcontractVendorEmailHtmlInputs;
$arrSubcontractVendorAddressHtml[] = $tmpSubcontractVendorAddressHtmlInputs;
$arrSubcontractVendorCityHtml[] = $tmpSubcontractVendorCityHtmlInputs;
$arrSubcontractVendorStateHtml[] = $tmpSubcontractVendorStateHtmlInputs;
$arrSubcontractVendorZipHtml[] = $tmpSubcontractVendorZipHtmlInputs;
// } //subcontract end
        //vendor loop end/
$vendorNameList = implode("\n", $arrSubcontractVendorNameHtml);
$vendorEmailList = implode("\n", $arrSubcontractVendorEmailHtml);
$vendorFaxList = implode("\n", $arrSubcontractVendorfaxHtml);
$vendorPhoneList = implode("\n", $arrSubcontractVendorMobileHtml);
$vendorAddressList = implode("\n", $arrSubcontractVendorAddressHtml);
$vendorCityList = implode("\n", $arrSubcontractVendorCityHtml);
$vendorStateList = implode("\n", $arrSubcontractVendorStateHtml);
$vendorZipList = implode("\n", $arrSubcontractVendorZipHtml);
        //$vendorList = trim($vendorList, ' ,');
$vendorList = implode("\n", $arrSubcontractVendorHtml);

if ($loopCounter%2) {
    $rowStyle = 'oddRow';
} else {
    $rowStyle = 'evenRow';
}

$loopCounter++;
}
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
if($arrSubcontracts)
{
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$costCodeDivision->escaped_division_number.$costCodeDividerType. $costCode->escaped_cost_code." - ".$costCode->escaped_cost_code_description );
        // $alphaCharIn++;
        // $stre= "$costCode->escaped_cost_code_description";
        // $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$stre); 
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->getRowDimension($index)->setRowHeight(); 
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorList); 
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorNameList); 
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorEmailList); 
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorPhoneList);
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
// $alphaCharIn++;
// $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorFaxList); 
// $objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorAddressList); 
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorCityList); 
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorStateList); 
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
$alphaCharIn++;
$objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,$vendorZipList); 
$objPHPExcel->getActiveSheet()->getStyle($alphas[$alphaCharIn].$index)->getAlignment()->setWrapText(true);
$index++;
}
}
if(empty($arrGcBudgetLineItemsByProjectId)){
    $alphaCharIn=0;
    $objPHPExcel->setActiveSheetIndex()->mergeCells($alphas[$alphaCharIn].$index.':'.$alphas[$lastAlphaIn].$index);
    $objPHPExcel->getActiveSheet()->setCellValue($alphas[$alphaCharIn].$index,"Data's Not Available"); 
}

?>

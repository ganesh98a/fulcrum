<?php

function buildManpowerYesterDay($database, $user_company_id, $project_id, $jobsite_daily_log_id, $new_begindate)
{
$maxDays=1;
$arrayManValue=array();
$arrayManDate=array();
$arrayManComp=array();
$count='1';
$session = Zend_Registry::get('session');
/* @var $session Session */
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

    $sub_count='1';
    /*$datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));*/
    $datestep = $new_begindate;
    $jobsite_daily_log_id = '';
    $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);
    if ($jobsiteDailyLog) {
       $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    }
    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
    $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
    $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
    $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];

    $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);
    $totalnumber_of_people=0;

    foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        /* @var $subcontract Subcontract */

        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        $costCode = $gcBudgetLineItem->getCostCode();
        /* @var $costCode CostCode */

        $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode($user_company_id);

        $vendor = $subcontract->getVendor();
        /* @var $vendor Vendor */

        $vendor_id = $vendor->vendor_id;

        $contactCompany = $vendor->getVendorContactCompany();
        /* @var $contactCompany ContactCompany */

        $contact_company_name = $contactCompany->contact_company_name;
        if(empty($arrReturn))
            $number_of_people = '';
        else
            $number_of_people = 0;
        if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {
            $jobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];
            /* @var $jobsiteManPower JobsiteManPower */
            $number_of_people = $jobsiteManPower->number_of_people;
            $uniqueId = $jobsiteManPower->jobsite_man_power_id;

            $attributeGroupName = 'manage-jobsite_man_power-record';
            $onchange = 'Daily_Log__ManPower__updateJobsiteManPower(this);';
        } else {
            $jobsiteManPower = JobsiteManPower::findByJobsiteDailyLogIdAndSubcontractId($database, $jobsite_daily_log_id, $subcontract_id);
            /* @var $jobsiteManPower JobsiteManPower */

            if ($jobsiteManPower) {
                $number_of_people = $jobsiteManPower->number_of_people;
                $uniqueId = $jobsiteManPower->jobsite_man_power_id;
            } else {
                $number_of_people = '';
                $uniqueId = $jobsite_daily_log_id.'-'.$subcontract_id;
            }

            $attributeGroupName = 'create-jobsite_man_power-record';
            $onchange = "Daily_Log__ManPower__createJobsiteManPower('$attributeGroupName', '$uniqueId');";
        }
 

        $totalnumber_of_people +=$number_of_people;
        $htmlContent .= <<<END_HTML_CONTENT

                <tr>
                    <td>$contact_company_name &mdash; $htmlEntityEscapedFormattedCostCode</td>
                    <td class="columnLight">
                    $number_of_people
                    </td>
                </tr>
END_HTML_CONTENT;
    $WeekDay=date('l', strtotime($datestep));
    $begindate = DateTime::createFromFormat('Y-m-d', $datestep);
    $manDate = $begindate->format('m/d/Y');
    
    
$arrayManComp[$sub_count][0]=$contact_company_name.'-'.$htmlEntityEscapedFormattedCostCode;
$arrayManValue[$sub_count][0]='';
$arrayManValue[$sub_count][$count]=$number_of_people;
$arrayManDate[$count]=$WeekDay.','.$manDate;

$sub_count++;
    }
 $count++;

 
$array_count=count($arrayManValue);
$date_count=count($arrayManDate);
$CheckTableValue=1;


 
 
$arrayChek=array();
$checkNull='';
foreach($arrayManValue as $index=>$value)
{
    $value=array_filter($arrayManValue[$index]);
    foreach($arrayManValue[$index] as $index1 => $value1)
    {
        $JoinArray='';
        $JoinArray .=$arrayChek[$index1];
        $JoinArray .=$arrayManValue[$index][$index1];
        $arrayChek[$index1]=$JoinArray;
        $checkNull .= $arrayManValue[$index][$index1];
    }
}

$weekTotalcol=0;
$colTotal=0;
$coltotalarray=array();
$colcount=1;
for($valuei=1;$valuei<=$array_count;$valuei++){
$valuehtml.="<tr>";
$row_total='';
$valueinarraycount=count($arrayManValue[$valuei]);
for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
    if($invaluei!=0){
        $class="class='total_bold align-left'";
        if($arrayChek[$invaluei]==''){
            $valuehtml.="<td $class></td>";
        }else{
            if($arrayManValue[$valuei][$invaluei]=='')
            $valuehtml.="<td $class></td>";
            else
                $valuehtml.="<td $class>".$arrayManValue[$valuei][$invaluei]."</td>";
        }
    }else{
        $class="class='align-left'";
        $valuehtml.="<td $class style='white-space:nowrap;'>".$arrayManComp[$valuei][$invaluei]."</td>";
    }

    if($invaluei!=0){
        $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
        if($arrayManValue[$valuei][$invaluei]!='')
        $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
    }
}
$valuehtml.="</tr>";
$weekTotalcol=$weekTotalcol+$row_total;
$coltotalarray[$invaluei]=$weekTotalcol;
}
$counttotalValue=count($coltotalarray);
if($counttotalValue!=0)
    $valuehtml.="<tr class='total_bold center-align'>";
for($invaluet=1;$invaluet<$counttotalValue;$invaluet++){
    if($invaluet==1)
    $valuehtml.="<td class='align-left'>DAY TOTAL</td>";
    $valuehtml.="<td class='align-left'>$coltotalarray[$invaluet]</td>";
}
if($counttotalValue==0){
$valuehtml.="<tr><td colspan=".($maxDays+1).">No Manpower efforts involved</td>";
}
$valuehtml.="</tr>";
return $valuehtml;

}

//Get the Open RFI data All for job status Report
function RFIReportbyIDOpen($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $typepost, $cost_code_division_id_filter=null){

    $loadRequestsForInformationByProjectIdOptions = new Input();
    $loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
    $arrRequestsForInformation = RequestForInformation::loadOpenRequestsForInformationByProjectIdReport($database, $project_id, $loadRequestsForInformationByProjectIdOptions,$new_begindate, $enddate, $typepost);
$rfiTableTbody = '';
$index=1;
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
        }else{
            $rfi_due_date = date('m/d/Y',strtotime($rfi_due_date)); 
        }

        if (empty($escaped_rfi_plan_page_reference)) {
            $escaped_rfi_plan_page_reference = '&nbsp;';
        }

       
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
        if (($daysOpenDenominator == 0) || ($daysOpen == '-0')) {
            $daysOpen = 0;
        }
        $daysOpen = str_pad($daysOpen, $strlen, 0, STR_PAD_LEFT);
        $rfiTableTbody .= <<<END_RFI_TABLE_TBODY

        <tr>
            <td class="textAlignCenter">$rfi_sequence_number</td>
            <td class="align-left">$escaped_rfi_title</td>
            <td class="align-left">$formattedRfiCreatedDate</td>
            <td class="align-left">$rfi_due_date</td>
            <td class="align-left">$formattedRfiResponseDate</td>
            <td class="align-left">$rfiRecipientContactFullNameHtmlEscaped</td>
            <td class="align-left">$request_for_information_priority</td>
            
        </tr>

END_RFI_TABLE_TBODY;
$index++;
    }
    if($rfiTableTbody=='')
        $rfiTableTbody="<tr><td colspan='7'>No Data Available for Selected Dates</td></tr>";
    $htmlContent = <<<END_HTML_CONTENT

<table id="RFiReportOpen" class="tableborder content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
    <tr class="table-headerinner">
            <th colspan="7" class="textAlignLeft">Open Request For Information</th>
            </tr>            
        <tr style="padding-bottom:30px;">
        <td  class="textAlignCenter">RFI #</td>
        <td  class="align-left">Description</td>
        <td  class="align-left">Open</td>
        <td  class="align-left">Due By</td>
        <td  class="align-left">Response</td>
        <td  class="align-left">Recipient</td>
        <td  class="align-left">Priority</td>        
        </tr>
    <tbody class="altColors">
        $rfiTableTbody
    </tbody>
</table>
END_HTML_CONTENT;

    return $htmlContent;

}
//change order function
function renderCoListView_AsHtmlJobstatus($database, $project_id, $new_begindate, $enddate, $change_order_type_id=false, $pdfFlag=false)
{
	$loadChangeOrdersByProjectIdOptions = new Input();
	$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
	$loadChangeOrdersByProjectIdOptions->change_order_type_id = $change_order_type_id;
	$loadChangeOrdersByProjectIdOptions->arrOrderByAttributes = 'co.`co_sequence_number` DESC';
	$arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectIdPotential($database, $project_id, $new_begindate, $enddate,$loadChangeOrdersByProjectIdOptions);
	$totalcoschudlevalue=0;
	$totaldays=0;
	$coTableTbody = '';
	foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
		/* @var $changeOrder ChangeOrder */

		$project = $changeOrder->getProject();
		/* @var $project Project */

		$changeOrderType = $changeOrder->getChangeOrderType();
		/* @var $changeOrderType ChangeOrderType */
		$change_order_type = $changeOrderType->change_order_type;

		$changeOrderStatus = $changeOrder->getChangeOrderStatus();
		/* @var $changeOrderStatus ChangeOrderStatus */

		$changeOrderPriority = $changeOrder->getChangeOrderPriority();
		/* @var $changeOrderPriority ChangeOrderPriority */

		$changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
		/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
		//$change_order_distribution_method = $changeOrderDistributionMethod->change_order_distribution_method;
		$change_order_distribution_method = '';

		$coFileManagerFile = $changeOrder->getCoFileManagerFile();
		/* @var $coFileManagerFile FileManagerFile */

		$coCostCode = $changeOrder->getCoCostCode();
		/* @var $coCostCode CostCode */

		$coCreatorContact = $changeOrder->getCoCreatorContact();
		/* @var $coCreatorContact Contact */

		$coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
		/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

		$coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
		/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
		/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
		/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

		$coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
		/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

		$coRecipientContact = $changeOrder->getCoRecipientContact();
		/* @var $coRecipientContact Contact */

		$coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
		/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

		$coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
		/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
		/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
		/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

		$coInitiatorContact = $changeOrder->getCoInitiatorContact();
		/* @var $coInitiatorContact Contact */

		$coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
		/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

		$coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
		/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
		/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

		$coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
		/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */

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

		// HTML Entity Escaped Data
		$changeOrder->htmlEntityEscapeProperties();
		$escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
		$escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
		$escaped_co_statement = $changeOrder->escaped_co_statement;
		$escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
		$escaped_co_title = $changeOrder->escaped_co_title;

		if (empty($escaped_co_custom_sequence_number)) {
			$escaped_co_custom_sequence_number = '&nbsp;';
		}

		if (empty($co_revised_project_completion_date)) {
			$co_revised_project_completion_date = '&nbsp;';
		}

		if (empty($escaped_co_plan_page_reference)) {
			$escaped_co_plan_page_reference = '&nbsp;';
		}

		if ($changeOrderPriority) {
			$change_order_priority = $changeOrderPriority->change_order_priority;
		} else {
			$change_order_priority = '&nbsp;';
		}

		if ($coCostCode) {
			// Extra: Change Order Cost Code - Cost Code Division
			$coCostCodeDivision = $coCostCode->getCostCodeDivision();
			/* @var $coCostCodeDivision CostCodeDivision */

			$formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false);

			
		} else {
			$formattedCoCostCode = '&nbsp;';
		}

		
		/* @var $recipient Contact */

		if ($coRecipientContact) {
			$coRecipientContactFullName = $coRecipientContact->getContactFullName();
			$coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
		} else {
			$coRecipientContactFullName = '';
			$coRecipientContactFullNameHtmlEscaped = '&nbsp;';
		}

		// Convert co_created to a Unix timestamp
		$openDateUnixTimestamp = strtotime($co_created);
		$oneDayInSeconds = 86400;
		$daysOpen = '';

		//$formattedCoCreatedDate = date("m/d/Y g:i a", $openDateUnixTimestamp);
		$formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

		// change_order_statuses:
		// 1 - Draft
		// 2 - Open
		// 3 - In Progress
		// 4 - Closed

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

		$co_scheduled_value = Format::formatCurrency($co_scheduled_value);

		if ($change_order_type == 'Potential Change Order') {
			$change_order_type_abbreviated = 'PCO';
		} elseif ($change_order_type == 'Change Order Request') {
			$change_order_type_abbreviated = 'COR';
		} elseif ($change_order_type == 'Owner Change Order') {
			$change_order_type_abbreviated = 'OCO';
		}

		
		$totaldays=$totaldays+$co_delay_days;
		$coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY

		<tr>
			<td class="align-left">$co_sequence_number</td>
			<td class="align-left">$escaped_co_title</td>
			<td class="align-left">$formattedCoCreatedDate</td>
			<td align="right">$co_scheduled_value</td>
			<td align="center">$co_delay_days</td>
			<td class="align-left">$change_order_status</td>
			<td class="align-left">$escaped_co_plan_page_reference</td>
			<td class="align-left">$escaped_co_statement</td>
		</tr>

END_CHANGE_ORDER_TABLE_TBODY;
	}

	if ($pdfFlag) {
		$textAlign = 'align="left"';
	} else {
		$textAlign = 'align="left"';
	}
	if($coTableTbody!=''){
		// let's print the international format for the en_US locale
		setlocale(LC_MONETARY, 'en_US');
		$totalcoschudlevalue = money_format('%i', $totalcoschudlevalue);
		$totalcoschudlevalue = Format::formatCurrency($totalcoschudlevalue);
		$coTableTbody .=<<<END_CHANGE_ORDER_TABLE_TBODYS
		<tr><th colspan="3" align="left">Open PCO Total</th><th align="right">$totalcoschudlevalue</th><th align="center">$totaldays</th><th colspan="3"></th></tr>
END_CHANGE_ORDER_TABLE_TBODYS;
	}else{
		$coTableTbody .=<<<END_CHANGE_ORDER_TABLE_TBODYS
		<tr><td colspan="8">No Data Available for Selected Dates</th></tr>
END_CHANGE_ORDER_TABLE_TBODYS;
	}
	$htmlContent = <<<END_HTML_CONTENT

<table id="PotentialChnageOrder" class="tableborder content" border="0" cellpadding="5" cellspacing="0" width="100%">
	<tr class="table-headerinner">
            <th colspan="8" class="textAlignLeft">PCO Created</th>
            </tr>
		<tr>
			<td $textAlign nowrap>CO #</td>
			<td $textAlign nowrap>Name</td>
			<td $textAlign nowrap>Date</td>
			<td $textAlign nowrap width="10%">EST.Amount</td>
			<td align="center" nowrap>Days</td>
			<td $textAlign nowrap>Status</td>
			<td $textAlign nowrap>References</td>
			<td $textAlign nowrap>Notes</td>
		</tr>
	<tbody class="altColors">
		$coTableTbody
	</tbody>
</table>

END_HTML_CONTENT;

	return $htmlContent;
}
/*change order common*/
//change order function
function renderCoListView_AsHtmlJobstatusAll($database, $project_id, $new_begindate, $enddate, $change_order_type_id=false, $pdfFlag=false, $checkRtype,$codesp, $user_company_id, $coshowreject,$coshowcostcode,$view_option){
  if($codesp =='true' && $coshowcostcode=='true')
  {
    $type_title ='9';
    $totspan ='8';
    $nospan= '15';
    $totAmountSpan ='2';
  }elseif($coshowcostcode =='true'){
     $type_title ='8';
     $totspan ='7';
     $nospan= '14';
     $totAmountSpan ='2';
  }elseif($codesp =='true'){
    $type_title ='6';
    $totspan ='5';
    $nospan= '13';
    $totAmountSpan ='4';
  }else{
     $type_title ='5';
     $totspan ='4';
     $nospan= '12';
     $totAmountSpan ='4';
  }
  
  $totalAmt = 0;
  $totalCostCodeAmount = 0;
  if($change_order_type_id == '' || $change_order_type_id == 1 || $change_order_type_id == '1,2'){
    //categoryType
    $categoryType =1;
    //Potential change order
    $order_type_id = 1;
    $sort_approved = false; //Variable to sort the approved section
    if($view_option=="costcode"){
        $potentialCoContent = getChangeOrdersList($database, $project_id, $new_begindate, $enddate, $order_type_id, $pdfFlag=false, $checkRtype,$codesp, $coshowreject, $user_company_id, null,$sort_approved,$coshowcostcode,$categoryType);
        $pcoTotalCostCodeAmount = $potentialCoContent['total'];
        $potentialCoContentBody = $potentialCoContent['coTableTbody'];
        $potentialCoContentTotalDays = $potentialCoContent['days'];
    }else{
        $potentialCoContentCoView = getChangeOrdersListCoView($database, $project_id, $new_begindate, $enddate, $order_type_id, $pdfFlag=false, $checkRtype,$codesp, $coshowreject, $user_company_id, null,$sort_approved,$coshowcostcode,$categoryType);
        $pcoTotalCostCodeAmountCoView = $potentialCoContentCoView['total'];
        $potentialCoContentCoViewBody = $potentialCoContentCoView['coTableTbody'];
        $pcoTotalCostCodeAmountCoView = Format::formatCurrency($pcoTotalCostCodeAmountCoView);

        $pcoTotalCostCodeDaysCoView = $potentialCoContentCoView['days'];
    }
    $statusIds = array(1,2);
    $potentialCORData = ReportchangeOrderTotalAndDelay($project_id,$order_type_id,$new_begindate, $enddate, $statusIds, $database);

    $potentialCORTotalAmt = $potentialCORData['total'];
    $potentialCORTotalAmt = Format::formatCurrency($potentialCORTotalAmt);
    $potentialCORDays = $potentialCORData['days'];
    $totalAmt += $potentialCORData['total'];

    if($view_option=="costcode"){
        $potentialCOHtmlContent = <<<END_HTML_CONTENT
    <tr class='purStyle'>
        <td colspan='$type_title'><b>PCO Created</b></td>
        <td><b>Est.Amount</b></td>
        <td colspan='5'></td>
    </tr>
    $potentialCoContentBody
    <tr class='purStyle'>
        <td colspan='$totspan'></td>
        <td align='right'><b>Total Amount</b></td>
        <td align='right'><b>$pcoTotalCostCodeAmount</b></td>
        <td align='center'><b>$potentialCoContentTotalDays day(s)</b></td>
        <td colspan='$totAmountSpan'></td>
END_HTML_CONTENT;
    }

    if($view_option=="subcontractor"){
        $potentialCOHtmlContent = <<<END_HTML_CONTENT
    <tr class='purStyle'>
        <td colspan='$type_title'><b>PCO Created</b></td>
        <td><b>Est.Amount</b></td>
        <td colspan='5'></td>
    </tr>
    $potentialCoContentCoViewBody
    <tr class='purStyle'>
        <td colspan='$totspan'></td>
        <td align='right'><b>Total Amount</b></td>
        <td align='right'><b>$pcoTotalCostCodeAmountCoView</b></td>
        <td align='center'><b>$pcoTotalCostCodeDaysCoView day(s)</b></td>
        <td colspan='$totAmountSpan'></td>
END_HTML_CONTENT;
    }
    
    if($coshowcostcode=='true')
    {
        $potentialCOHtmlContent .=<<<END_HTML_CONTENT
        <td align='left'><b>$pcoTotalCostCodeAmount</b></td>
        </tr>
END_HTML_CONTENT;
    }else {
        $potentialCOHtmlContent .=<<<END_HTML_CONTENT
        </tr>
END_HTML_CONTENT;
    }
  }

  if($change_order_type_id == '' || $change_order_type_id == 2 || $change_order_type_id == '1,2'){
    //categoryType
    $categoryType =2;
    //open change order request
    $order_type_id = 2;
    $change_order_status_id = array(1,3);
    $sort_approved = false; //Variable to sort the approved section
    if($view_option=="costcode"){
        $corCoContent = getChangeOrdersList($database, $project_id, $new_begindate, $enddate, $order_type_id, $pdfFlag=false, $checkRtype,$codesp, $coshowreject, $user_company_id, $change_order_status_id,$sort_approved,$coshowcostcode,$categoryType);
        $corCoContentBody = $corCoContent['coTableTbody'];
        $corTotalCostCodeAmount = $corCoContent['total'];
        $corTotalCostCodeDays = $corCoContent['days'];
    }else{
        $corTotalCostCodeAmount = Format::formatCurrency($corTotalCostCodeAmount);
        $corCoContentCoView = getChangeOrdersListCoView($database, $project_id, $new_begindate, $enddate, $order_type_id, $pdfFlag=false, $checkRtype,$codesp, $coshowreject, $user_company_id, $change_order_status_id,$sort_approved,$coshowcostcode,$categoryType);
        $corCoContentCoViewBody = $corCoContentCoView['coTableTbody'];
        $corTotalCostCodeAmountCoView = $corCoContentCoView['total'];
        $corTotalCostCodeAmountCoView = Format::formatCurrency($corTotalCostCodeAmountCoView);
        $corTotalCostCodeDaysCoView = $corCoContentCoView['days'];
    }
    $statusIds = array(1);
    $openCORData = ReportchangeOrderTotalAndDelay($project_id,$order_type_id,$new_begindate, $enddate, $statusIds, $database);

    $openCORTotalAmt = $openCORData['total'];
    $openCORTotalAmt = Format::formatCurrency($openCORTotalAmt);
    $openCORDays = $openCORData['days'];
    $totalAmt += $openCORData['total'];
    
    if($view_option=="costcode"){
        $openCOHtmlContent = <<<END_HTML_CONTENT
        <tr class='purStyle'>
            <td colspan='$type_title'><b>COR Submitted</b></td>
            <td><b>Amount</b></td>
            <td colspan='5'></td>
        </tr>
        $corCoContentBody
        <tr class='purStyle'>
            <td colspan='$totspan'></td>
            <td align='right'><b>Total Amount</b></td>
            <td align='right'><b>$corTotalCostCodeAmount</b></td>
            <td align='center'><b>$corTotalCostCodeDays day(s)</b></td>
            <td colspan='$totAmountSpan'></td>
END_HTML_CONTENT;
    }

    if($view_option=="subcontractor"){
        $openCOHtmlContent = <<<END_HTML_CONTENT
        <tr class='purStyle'>
            <td colspan='$type_title'><b>COR Submitted</b></td>
            <td><b>Amount</b></td>
            <td colspan='5'></td>
        </tr>
        $corCoContentCoViewBody
        <tr class='purStyle'>
            <td colspan='$totspan'></td>
            <td align='right'><b>Total Amount</b></td>
            <td align='right'><b>$corTotalCostCodeAmountCoView</b></td>
            <td align='center'><b>$corTotalCostCodeDaysCoView day(s)</b></td>
            <td colspan='$totAmountSpan'></td>
END_HTML_CONTENT;
    }


if($coshowcostcode=='true')
    {
        $openCOHtmlContent .=<<<END_HTML_CONTENT
        <td align='left'><b>$corTotalCostCodeAmount</b></td>
        </tr>
END_HTML_CONTENT;
    }else {
        $openCOHtmlContent .=<<<END_HTML_CONTENT
        </tr>
END_HTML_CONTENT;
    }
    //categoryType
    $categoryType =3;
    //approved change order request
    $change_order_status_id = array(2);
    $sort_approved = true; //Variable to sort the approved section
    if($view_option=="costcode"){
        $approvedCor = getChangeOrdersList($database, $project_id, $new_begindate, $enddate, $order_type_id, $pdfFlag=false, $checkRtype, $codesp, $coshowreject, $user_company_id, $change_order_status_id,$sort_approved,$coshowcostcode,$categoryType);
        $approvedcorCoContent = $approvedCor['coTableTbody'];
        $approvedTotalCostCodeAmount = $approvedCor['total'];
        $approvedTotalCostCodeDays = $approvedCor['days'];
        $approvedTotalCostCodeAmount = Format::formatCurrency($approvedTotalCostCodeAmount);
    }else{
       $approvedCorCoView = getChangeOrdersListCoView($database, $project_id, $new_begindate, $enddate, $order_type_id, $pdfFlag=false, $checkRtype, $codesp, $coshowreject, $user_company_id, $change_order_status_id,$sort_approved,$coshowcostcode,$categoryType);
       $approvedcorCoContentCoView = $approvedCorCoView['coTableTbody'];
       $approvedTotalCostCodeAmountCoView = $approvedCorCoView['total'];
       $approvedTotalCostCodeAmountCoView = Format::formatCurrency($approvedTotalCostCodeAmountCoView);

       $approvedTotalCostCodeDaysCoView = $approvedCorCoView['days'];
   }
   
    $statusIds = array(2);
    $approvedCORData = ReportchangeOrderTotalAndDelay($project_id,$order_type_id,$new_begindate, $enddate, $statusIds, $database);

    $approvedCORTotalAmt = $approvedCORData['total'];
    $approvedCORTotalAmt = Format::formatCurrency($approvedCORTotalAmt);
    $approvedCORDays = $approvedCORData['days'];
    $totalAmt += $approvedCORData['total'];

    if($view_option=="costcode"){
        $approvedCOHtmlContent = <<<END_HTML_CONTENT
        <tr class='purStyle'>
            <td colspan='$type_title'><b>Approved</b></td>
            <!-- <td><b>Amount</b></td> -->
            <td colspan='6'></td>
        </tr>
        $approvedcorCoContent
        <tr class='purStyle'>
            <td colspan='$totspan'></td>
            <td align='right'><b>Total Amount</b></td>
            <td align='right'><b>$approvedTotalCostCodeAmount</b></td>
            <td align='center'><b>$approvedTotalCostCodeDays day(s)</b></td>
            <td colspan='$totAmountSpan'></td>
END_HTML_CONTENT;
    }
    if($view_option=="subcontractor"){
        $approvedCOHtmlContent = <<<END_HTML_CONTENT
        <tr class='purStyle'>
            <td colspan='$type_title'><b>Approved</b></td>
            <!-- <td><b>Amount</b></td> -->
            <td colspan='6'></td>
        </tr>
        $approvedcorCoContentCoView
        <tr class='purStyle'>
             <td colspan='$totspan'></td>
            <td align='right'><b>Total Amount</b></td>
            <td align='right'><b>$approvedTotalCostCodeAmountCoView</b></td>
            <td align='center'><b>$approvedTotalCostCodeDaysCoView day(s)</b></td>
            <td colspan='$totAmountSpan'></td> 
END_HTML_CONTENT;
    }
    
if($coshowcostcode=='true')
    {
        $approvedCOHtmlContent .=<<<END_HTML_CONTENT
        <td align='left'><b>$approvedTotalCostCodeAmount</b></td>
        </tr>
END_HTML_CONTENT;
    }else {
        $approvedCOHtmlContent .=<<<END_HTML_CONTENT
        </tr>
END_HTML_CONTENT;
    }
 }

  $totalAmt = Format::formatCurrency($totalAmt);
  $headTypeName='Potential Change Order';
  if($checkRtype == 'CO'){
      $headType="<th nowrap style=border:none; >Type</th>";
      $headTypeName='Change Order';
      $colspan = 11;
  }


  $tableHeader =<<<END_HTML_TABLE
  <tr>
  <th nowrap style="border:none;">Custom #</th>
  <th nowrap style="border:none;">CO #</th>
  $headType
  <th nowrap width="15%" style="border:none;">Title</th>
  <th nowrap style="border:none;">Reason</th>
END_HTML_TABLE;
  
  if($codesp =='true'){
   $tableHeader .= <<<END_HTML_TABLE
   <th  nowrap style="border:none;">Description</th>
END_HTML_TABLE;
  }
  
  $tableHeader .= <<<END_HTML_TABLE
  <th nowrap width="10%" style="border:none;">Amount</th>
  <th nowrap style="border:none;">Days</th>
  <th align="center" nowrap style="border:none;">Date</th>
  <th nowrap style="border:none;">Status</th>
  <th nowrap style="border:none;">References</th>
  <!--<th nowrap style="border:none;">Cost Code</th>-->
END_HTML_TABLE;

  if($coshowcostcode == 'true'){
    $tableHeader .= <<<END_HTML_TABLE
    <th nowrap style="border:none;">Executed</th>
    <th nowrap style="border:none;">Cost Code</th>
    <th nowrap style="border-right:1px solid #bbb;border-left:none;">Cost Code Amount</th>
    </tr>
END_HTML_TABLE;
  }else{
    $tableHeader .= <<<END_HTML_TABLE
<th nowrap style="border-right:1px solid #bbb;border-left:none;">Executed</th>
</tr>
END_HTML_TABLE;
}
    if($view_option == "costcode")
    {
  $htmlContent = <<<END_HTML_CONTENT
<table id="ChangeOrdertblTabularData" class="content c-order" border="1" style="border-collapse:collapse;border: 1px solid #adadad;" cellpadding="5" cellspacing="0" width="100%">
  <thead class="borderBottom">
    <tr class="table-headerinner" style="border:none">
          <th colspan="$nospan" class="textAlignLeft">Change Order</th>
    </tr>
    $tableHeader
  </thead>
  <tbody class="">
      $potentialCOHtmlContent
      $openCOHtmlContent
      $approvedCOHtmlContent
      <tr class='purStyle'><td colspan='$totspan'></td><td align="right"><b>Total</b></td><td align="right"><b>$totalAmt</b><td colspan="5"></td></tr>
  </tbody>
</table>

END_HTML_CONTENT;
    }
    if($view_option == "subcontractor")
    {
  $htmlContent = <<<END_HTML_CONTENT
<table id="ChangeOrdertblTabularData" class="content c-order" border="1" style="border-collapse:collapse;border: 1px solid #adadad;" cellpadding="5" cellspacing="0" width="100%">
  <thead class="borderBottom">
    <tr class="table-headerinner" style="border:none">
          <th colspan="$nospan" class="textAlignLeft">Change Order</th>
    </tr>
    $tableHeader
  </thead>
  <tbody class="">
      $potentialCOHtmlContent
      $openCOHtmlContent
      $approvedCOHtmlContent
      <!-- <tr class='purStyle'><td colspan='$totspan'></td><td align="right"><b>Total</b></td><td align="right"><b>$totalAmt</b><td colspan="5"></td></tr> -->
  </tbody>
</table>

END_HTML_CONTENT;
    }
  return $htmlContent;
}
function getChangeOrdersList($database, $project_id, $new_begindate, $enddate, $change_order_type_id, $pdfFlag=false, $checkRtype,$codesp, $coshowreject, $user_company_id, $change_order_status_id,$sort_approved,$coshowcostcode,$categoryType){
  $loadChangeOrdersByProjectIdOptions = new Input();
  $loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
  $loadChangeOrdersByProjectIdOptions->change_order_type_id = $change_order_type_id;
  $loadChangeOrdersByProjectIdOptions->coshowreject = $coshowreject;
  if(isset($change_order_status_id)) {
    $loadChangeOrdersByProjectIdOptions->change_order_status_id = $change_order_status_id;
  }  
    if ($sort_approved == true) {
        $loadChangeOrdersByProjectIdOptions->arrOrderByAttributes = " boolnull ASC , boolDash DESC, boolZero DESC, boolNum DESC, (co.`co_custom_sequence_number`+0), co.`co_custom_sequence_number`, CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC";
    }else{
        $loadChangeOrdersByProjectIdOptions->arrOrderByAttributes = "co.`change_order_type_id` ASC,CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC,co.`co_sequence_number` DESC ";
    }

  $arrChangeOrders = ChangeOrder::loadPotentialChangeOrdersByProjectId($database, $project_id, $new_begindate, $enddate,$loadChangeOrdersByProjectIdOptions, $checkRtype);
  //Colspan count
   if($codesp =='true' && $coshowcostcode =='true'){
      $nospan= '15';
   }elseif ($coshowcostcode == 'true'){
      $nospan= '14'; 
   }elseif ($codesp =='true'){
       $nospan ='12';
   }else{
    $nospan= '11';
   }
    
  $totalcovalue = 0;
  $totaldays = 0;
  $coTableTbody = '';
  $coCostTotal = 0;
  $totalCoAmount = 0;
  // $pcoCoTotal =0;
  // $corCoTotal =0;
  // $approvedCoTotal =0;
  foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
      /* @var $changeOrder ChangeOrder */

        $project = $changeOrder->getProject();
        /* @var $project Project */

        $changeOrderType = $changeOrder->getChangeOrderType();
        /* @var $changeOrderType ChangeOrderType */
        $change_order_type = $changeOrderType->change_order_type;

        $changeOrderStatus = $changeOrder->getChangeOrderStatus();
        /* @var $changeOrderStatus ChangeOrderStatus */

        $changeOrderPriority = $changeOrder->getChangeOrderPriority();
        /* @var $changeOrderPriority ChangeOrderPriority */

        $changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
        /* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
        //$change_order_distribution_method = $changeOrderDistributionMethod->change_order_distribution_method;
        $change_order_distribution_method = '';

        $coFileManagerFile = $changeOrder->getCoFileManagerFile();
        /* @var $coFileManagerFile FileManagerFile */

        $coCostCode = $changeOrder->getCoCostCode();
        /* @var $coCostCode CostCode */

        $coCreatorContact = $changeOrder->getCoCreatorContact();
        /* @var $coCreatorContact Contact */

        $coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
        /* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

        $coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
        /* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
        /* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
        /* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

        $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
        /* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

        $coRecipientContact = $changeOrder->getCoRecipientContact();
        /* @var $coRecipientContact Contact */

        $coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
        /* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

        $coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
        /* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
        /* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
        /* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

        $coInitiatorContact = $changeOrder->getCoInitiatorContact();
        /* @var $coInitiatorContact Contact */

        $coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
        /* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

        $coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
        /* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
        /* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
        /* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */

        $coChangeId = $changeOrder->change_order_id;
        $co_sequence_number = $changeOrder->co_sequence_number;
        $changeTypeid = $changeOrder->change_order_type_id;
        $co_type_prefix =$changeOrder->co_type_prefix;
        $co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
        $co_scheduled_value = $changeOrder->co_scheduled_value;
        if($changeOrder->co_delay_days>0){
            $co_delay_days = $changeOrder->co_delay_days;
        }else{
            $co_delay_days =0;
        }
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
        $totalCoAmount+=floatVal($changeOrder->co_total);
      //exclude rejected CO
      if($change_order_status_id != 3){
        $totalcovalue=$co_total+$totalcovalue;
      }

     
        // HTML Entity Escaped Data
        $changeOrder->htmlEntityEscapeProperties();
        $escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
        $escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
        $escaped_co_statement = $changeOrder->escaped_co_statement;
        $escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
        $escaped_co_title = $changeOrder->escaped_co_title;

        if (empty($escaped_co_custom_sequence_number)) {
            $escaped_co_custom_sequence_number = '&nbsp;';
        }

        if (empty($co_revised_project_completion_date)) {
            $co_revised_project_completion_date = '&nbsp;';
        }

        if (empty($escaped_co_plan_page_reference)) {
            $escaped_co_plan_page_reference = '&nbsp;';
        }

        if ($changeOrderPriority) {
            $change_order_priority = $changeOrderPriority->change_order_priority;
        } else {
            $change_order_priority = '&nbsp;';
        }

        // To get all the cost break down cost codes and amounts
		$costdata = getCOCostcodeFromCostBreakDown($database, $user_company_id,$coChangeId,'1');
        $costamountdata = getCOCostcodeFromCostBreakDown($database, $user_company_id,$coChangeId,'2');
        // $costamountdata = Format::formatCurrency($costamountdata);
        // To get the total amount according to the corresponding category
        // $totalCoAmount = getCOCostcodeFromCostBreakDownAmount($database, $user_company_id,$coChangeId);

        if($categoryType==1)//PCO
        { 
            $pcoCoTotal = $totalCoAmount;
        }elseif($categoryType==2)//COR
        {           
            $corCoTotal = $totalCoAmount;            
        }else//Approved
        {
            $approvedCoTotal = $totalCoAmount;
        }

        
      if ($coCostCode) {
          // Extra: Change Order Cost Code - Cost Code Division
          $coCostCodeDivision = $coCostCode->getCostCodeDivision();
          /* @var $coCostCodeDivision CostCodeDivision */
          $formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false, $user_company_id);
      } else {
          $formattedCoCostCode = '&nbsp;';
      }

      /* @var $recipient Contact */

      if ($coRecipientContact) {
          $coRecipientContactFullName = $coRecipientContact->getContactFullName();
          $coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
      } else {
          $coRecipientContactFullName = '';
          $coRecipientContactFullNameHtmlEscaped = '&nbsp;';
      }

      // Convert co_created to a Unix timestamp
      $openDateUnixTimestamp = strtotime($co_created);
      $oneDayInSeconds = 86400;
      $daysOpen = '';

      $formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

        // change_order_statuses:
        // 1 - Draft
        // 2 - Open
        // 3 - In Progress
        // 4 - Closed

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

      $co_scheduled_value = Format::formatCurrency($co_scheduled_value);

      if ($change_order_type == 'Potential Change Order') {
          $change_order_type_abbreviated = 'PCO';
      } elseif ($change_order_type == 'Change Order Request') {
          $change_order_type_abbreviated = 'COR';
          $co_sequence_number = $co_type_prefix;
      } elseif ($change_order_type == 'Owner Change Order') {
          $change_order_type_abbreviated = 'OCO';
      }

      $co_total = Format::formatCurrency($co_total);

      if(trim($change_order_status) == 'Rejected'){
         $coTotal = '<s>'.$co_total.'</s>';
         $coSeqNumber = '<s>'.$co_sequence_number.'</s>';
      }else{
         $coTotal = $co_total;
         $coSeqNumber = $co_sequence_number;
      }

        $subAttach=attachDocumentLink($change_order_id, $database);
        $subAttachCount = $subAttach['count'];
        if ($subAttachCount > 0) {
            $linkDocument = "
            <span style='color:#06c;text-decoration:underline;' >Link</span>
            ";            
        }else{
            $linkDocument = "";
        }

      $textAlign = 'align="center"';

      $bodytype='';
      if($checkRtype == 'CO')
          $bodytype='<td class="align-center">'.$change_order_type_abbreviated.'</td>';

        $totaldays=$totaldays+$co_delay_days;
        $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY

      <tr>
      <td class="align-center">$escaped_co_custom_sequence_number</td>
          <td class="align-center">$coSeqNumber</td>
          $bodytype
          <td class="align-left">$escaped_co_title</td>
          <td class="align-left">$change_order_priority</td>
END_CHANGE_ORDER_TABLE_TBODY;

        if($codesp =='true'){
        $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
        <td class="align-left">$co_statement</td>
END_CHANGE_ORDER_TABLE_TBODY;
            }
      
          $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
          <td align="right">$coTotal</td>
          <td align="center">$co_delay_days</td>
          <td align="center">$formattedCoCreatedDate</td>
          <td class="align-center">$change_order_status</td>
          <td align="center">$escaped_co_plan_page_reference</td>
          <td class="align-center">$linkDocument</td>
          <!-- <td class="align-center">$costdata</td> -->
END_CHANGE_ORDER_TABLE_TBODY;

if($coshowcostcode =='true'){
    $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
    <td class="align-left">$costdata</td>
    <td class="align-left">$costamountdata</td>
    </tr>
END_CHANGE_ORDER_TABLE_TBODY;
        }else {
            $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
            </tr>
END_CHANGE_ORDER_TABLE_TBODY;
        }
  }

  if($coTableTbody!=''){
      // let's print the international format for the en_US locale
      setlocale(LC_MONETARY, 'en_US');
      $totalcovalue = money_format('%i', $totalcovalue);
      $totalcovalue = Format::formatCurrency($totalcovalue);
  }else{
      if($checkRtype == 'CO')
      $coTableTbody .=<<<END_CHANGE_ORDER_TABLE_TBODYS
      <tr><td colspan="$nospan">No Data Available for Selected Dates</th></tr>
END_CHANGE_ORDER_TABLE_TBODYS;
else
        $coTableTbody .=<<<END_CHANGE_ORDER_TABLE_TBODYS
        <tr><td colspan="10">No Data Available for Selected Dates</th></tr>
END_CHANGE_ORDER_TABLE_TBODYS;

  }
//   $tabData = array();
  $tabData['coTableTbody'] = $coTableTbody;
  if($categoryType==1)
  {
    $tabData['total'] = $pcoCoTotal;
  }elseif($categoryType==2)
  {
    $tabData['total'] = $corCoTotal;
  }else{
    $tabData['total'] = $approvedCoTotal;
  }
  $tabData['days'] = $totaldays;
//   echo "<pre>";
//   print_r($tabData['pcoCoTotal']);
//   echo "</pre>";
  return $tabData;
}

function getChangeOrdersListCoView($database, $project_id, $new_begindate, $enddate, $change_order_type_id, $pdfFlag=false, $checkRtype,$codesp, $coshowreject, $user_company_id, $change_order_status_id,$sort_approved,$coshowcostcode,$categoryType){
$loadChangeOrdersByProjectIdOptions = new Input();
$loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
$loadChangeOrdersByProjectIdOptions->change_order_type_id = $change_order_type_id;
$loadChangeOrdersByProjectIdOptions->coshowreject = $coshowreject;
if(isset($change_order_status_id)) {
    $loadChangeOrdersByProjectIdOptions->change_order_status_id = $change_order_status_id;
}  
    if ($sort_approved == true) {
        $loadChangeOrdersByProjectIdOptions->arrOrderByAttributes = " boolnull ASC , boolDash DESC, boolZero DESC, boolNum DESC, (co.`co_custom_sequence_number`+0), co.`co_custom_sequence_number`, CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC";
    }else{
        $loadChangeOrdersByProjectIdOptions->arrOrderByAttributes = "co.`change_order_type_id` ASC,CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC,co.`co_sequence_number` DESC ";
    }

$arrChangeOrders = ChangeOrder::loadPotentialChangeOrdersByProjectId($database, $project_id, $new_begindate, $enddate,$loadChangeOrdersByProjectIdOptions, $checkRtype);
$parent_costcodes = array();
$incKey =0;
$totalCoAmount=0;
foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
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
                $totalCoAmount+=floatVal($costvalue['cost']);
            $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
            $costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$OCOcost_code_id,$costCodeDividerType);
            $formatCoViewCode = $costcodedata['cost_code_abb'];
            $parent_costcodes[$incKey.'~'.$change_order_id.'~'.$OCOcost_code_amount] = $formatCoViewCode;
            $incKey++;
            }
        }
    }
}

 if($categoryType==1)//PCO
        { 
          $pcoCoTotal = $totalCoAmount;
        }elseif($categoryType==2)//COR
        {           
            $corCoTotal = $totalCoAmount;            
        }else//Approved
        {
            $approvedCoTotal = $totalCoAmount;
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
    if(isset($arrChangeOrders[$akey]))
    {
        $parent_data[$sortInc.'~'.$akey.'~'.$costCodeamt.'~'.$avalue]=$arrChangeOrders[$akey];
        $sortInc++;
    }
}
$arrChangeOrders = $parent_data;

    if($codesp =='true' && $coshowcostcode =='true'){
    $nospan= '15';
    }elseif ($coshowcostcode == 'true'){
    $nospan= '14'; 
    }elseif ($codesp =='true'){
        $nospan ='12';
    }else{
    $nospan= '11';
    }
    
$totalcovalue = 0;
$coTableTbody = '';
$coCostTotal = 0;
$totaldays = 0;
// $pcoCoTotal =0;
// $corCoTotal =0;
// $approvedCoTotal =0;
$temp_head = array();
$test_head = '';
$FCostCodeAbb = '';
foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
    // $showHeader = 'false';
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
    /* @var $changeOrder ChangeOrder */
        $project = $changeOrder->getProject();
        /* @var $project Project */

        $changeOrderType = $changeOrder->getChangeOrderType();
        /* @var $changeOrderType ChangeOrderType */
        $change_order_type = $changeOrderType->change_order_type;

        $changeOrderStatus = $changeOrder->getChangeOrderStatus();
        /* @var $changeOrderStatus ChangeOrderStatus */

        $changeOrderPriority = $changeOrder->getChangeOrderPriority();
        /* @var $changeOrderPriority ChangeOrderPriority */

        $changeOrderDistributionMethod = $changeOrder->getChangeOrderDistributionMethod();
        /* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
        //$change_order_distribution_method = $changeOrderDistributionMethod->change_order_distribution_method;
        $change_order_distribution_method = '';

        $coFileManagerFile = $changeOrder->getCoFileManagerFile();
        /* @var $coFileManagerFile FileManagerFile */

        $coCostCode = $changeOrder->getCoCostCode();
        /* @var $coCostCode CostCode */

        $coCreatorContact = $changeOrder->getCoCreatorContact();
        /* @var $coCreatorContact Contact */

        $coCreatorContactCompanyOffice = $changeOrder->getCoCreatorContactCompanyOffice();
        /* @var $coCreatorContactCompanyOffice ContactCompanyOffice */

        $coCreatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorPhoneContactCompanyOfficePhoneNumber();
        /* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coCreatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoCreatorFaxContactCompanyOfficePhoneNumber();
        /* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
        /* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

        $coCreatorContactMobilePhoneNumber = $changeOrder->getCoCreatorContactMobilePhoneNumber();
        /* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */

        $coRecipientContact = $changeOrder->getCoRecipientContact();
        /* @var $coRecipientContact Contact */

        $coRecipientContactCompanyOffice = $changeOrder->getCoRecipientContactCompanyOffice();
        /* @var $coRecipientContactCompanyOffice ContactCompanyOffice */

        $coRecipientPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientPhoneContactCompanyOfficePhoneNumber();
        /* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coRecipientFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoRecipientFaxContactCompanyOfficePhoneNumber();
        /* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coRecipientContactMobilePhoneNumber = $changeOrder->getCoRecipientContactMobilePhoneNumber();
        /* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */

        $coInitiatorContact = $changeOrder->getCoInitiatorContact();
        /* @var $coInitiatorContact Contact */

        $coInitiatorContactCompanyOffice = $changeOrder->getCoInitiatorContactCompanyOffice();
        /* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */

        $coInitiatorPhoneContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorPhoneContactCompanyOfficePhoneNumber();
        /* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coInitiatorFaxContactCompanyOfficePhoneNumber = $changeOrder->getCoInitiatorFaxContactCompanyOfficePhoneNumber();
        /* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

        $coInitiatorContactMobilePhoneNumber = $changeOrder->getCoInitiatorContactMobilePhoneNumber();
        /* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */

        $coChangeId = $changeOrder->change_order_id;
        $co_sequence_number = $changeOrder->co_sequence_number;
        $changeTypeid = $changeOrder->change_order_type_id;
        $co_type_prefix =$changeOrder->co_type_prefix;
        $co_custom_sequence_number = $changeOrder->co_custom_sequence_number;
        $co_scheduled_value = $changeOrder->co_scheduled_value;
        if($changeOrder->co_delay_days>0){
            $co_delay_days = $changeOrder->co_delay_days;
        }else{
            $co_delay_days =0;
        }
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
    //exclude rejected CO
    if($change_order_status_id != 3){
        $totalcovalue=$co_total+$totalcovalue;
    }

    
        // HTML Entity Escaped Data
        $changeOrder->htmlEntityEscapeProperties();
        $escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
        $escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
        $escaped_co_statement = $changeOrder->escaped_co_statement;
        $escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
        $escaped_co_title = $changeOrder->escaped_co_title;

        if (empty($escaped_co_custom_sequence_number)) {
            $escaped_co_custom_sequence_number = '&nbsp;';
        }

        if (empty($co_revised_project_completion_date)) {
            $co_revised_project_completion_date = '&nbsp;';
        }

        if (empty($escaped_co_plan_page_reference)) {
            $escaped_co_plan_page_reference = '&nbsp;';
        }

        if ($changeOrderPriority) {
            $change_order_priority = $changeOrderPriority->change_order_priority;
        } else {
            $change_order_priority = '&nbsp;';
        }

        // To get all the cost break down cost codes and amounts
        $costdata = getCOCostcodeFromCostBreakDown($database, $user_company_id,$coChangeId,'1');
        $costamountdata = getCOCostcodeFromCostBreakDown($database, $user_company_id,$coChangeId,'2');
        // $costamountdata = Format::formatCurrency($costamountdata);
        // To get the total amount according to the corresponding category
        // $totalCoAmount = getCOCostcodeFromCostBreakDownAmount($database, $user_company_id,$coChangeId);

       

        
    if ($coCostCode) {
        // Extra: Change Order Cost Code - Cost Code Division
        $coCostCodeDivision = $coCostCode->getCostCodeDivision();
        /* @var $coCostCodeDivision CostCodeDivision */
        $formattedCoCostCode = $coCostCode->getFormattedCostCode($database,false, $user_company_id);
    } else {
        $formattedCoCostCode = '&nbsp;';
    }

    /* @var $recipient Contact */

    if ($coRecipientContact) {
        $coRecipientContactFullName = $coRecipientContact->getContactFullName();
        $coRecipientContactFullNameHtmlEscaped = $coRecipientContact->getContactFullNameHtmlEscaped();
    } else {
        $coRecipientContactFullName = '';
        $coRecipientContactFullNameHtmlEscaped = '&nbsp;';
    }

    // Convert co_created to a Unix timestamp
    $openDateUnixTimestamp = strtotime($co_created);
    $oneDayInSeconds = 86400;
    $daysOpen = '';

    $formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

        // change_order_statuses:
        // 1 - Draft
        // 2 - Open
        // 3 - In Progress
        // 4 - Closed

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

    $co_scheduled_value = Format::formatCurrency($co_scheduled_value);

    if ($change_order_type == 'Potential Change Order') {
        $change_order_type_abbreviated = 'PCO';
    } elseif ($change_order_type == 'Change Order Request') {
        $change_order_type_abbreviated = 'COR';
        $co_sequence_number = $co_type_prefix;
    } elseif ($change_order_type == 'Owner Change Order') {
        $change_order_type_abbreviated = 'OCO';
    }

    $co_total = Format::formatCurrency($co_total);

    if(trim($change_order_status) == 'Rejected'){
        $coTotal = '<s>'.$co_total.'</s>';
        $coSeqNumber = '<s>'.$co_sequence_number.'</s>';
    }else{
        $coTotal = $co_total;
        $coSeqNumber = $co_sequence_number;
    }

        $subAttach=attachDocumentLink($change_order_id, $database);
        $subAttachCount = $subAttach['count'];
        if ($subAttachCount > 0) {
            $linkDocument = "
            <span style='color:#06c;text-decoration:underline;' >Link</span>
            ";            
        }else{
            $linkDocument = "";
        }

    $textAlign = 'align="center"';

    $bodytype='';
    if($checkRtype == 'CO')
        $bodytype='<td class="align-center">'.$change_order_type_abbreviated.'</td>';

        $totaldays=$totaldays+$co_delay_days;
        // $arrCostCodeCOview = ChangeOrder::getcostBreakCostCodeId($database,$change_order_id);
        // $inc =1;
        // foreach ($arrCostCodeCOview as $key => $costvalue) {
        //     $OCOcost_code_id = $costvalue['cost_code_reference_id'];
        //     $OCOcost_code_amount = floatVal($costvalue['cost']);
        //     $OCOcost_code_amount = Format::formatCurrency($OCOcost_code_amount);
        //     if($OCOcost_code_id !="")
        //     {
        //     $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
        //     $costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$OCOcost_code_id,$costCodeDividerType);
        //     $formatCoViewCode = $costcodedata['cost_code_abb'];
        if($showHeader == 'true')
        {
            $headerTr = <<<END_OF_HEADER_COST_CODE
            <tr>
    <td class="align-left" colspan="12">$FCostCodeAbb</td>
    </tr>
END_OF_HEADER_COST_CODE;
        }else{
            $headerTr = "";
        }
            $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
    $headerTr
    <tr>
    <td class="align-center">$escaped_co_custom_sequence_number</td>
        <td class="align-center">$coSeqNumber</td>
        $bodytype
        <td class="align-left">$escaped_co_title</td>
        <td class="align-left">$change_order_priority</td>
END_CHANGE_ORDER_TABLE_TBODY;

        if($codesp =='true'){
        $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
        <td class="align-left">$co_statement</td>
END_CHANGE_ORDER_TABLE_TBODY;
            }
    
        $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
        <td align="right">$OCOcost_code_amount</td>
        <td align="center">$co_delay_days</td>
        <td align="center">$formattedCoCreatedDate</td>
        <td class="align-center">$change_order_status</td>
        <td align="center">$escaped_co_plan_page_reference</td>
        <td class="align-center">$linkDocument</td>
        <!-- <td class="align-center">$costdata</td> -->
END_CHANGE_ORDER_TABLE_TBODY;

if($coshowcostcode =='true'){
    $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
    <td class="align-left">$costdata</td>
    <td class="align-left">$costamountdata</td>
    </tr>
END_CHANGE_ORDER_TABLE_TBODY;
        }else {
            $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
            </tr>
END_CHANGE_ORDER_TABLE_TBODY;
        }
            $formattedSuCostCode .= $inc .") ".$costcodedata['short_cost_code']."<br>";
            $formattedSuCostCodeAmount .= $OCOcost_code_amount."<br>";
            $inc ++;
            }

if($coTableTbody!=''){
    // let's print the international format for the en_US locale
    setlocale(LC_MONETARY, 'en_US');
    $totalcovalue = money_format('%i', $totalcovalue);
    $totalcovalue = Format::formatCurrency($totalcovalue);
}else{
    if($checkRtype == 'CO')
    $coTableTbody .=<<<END_CHANGE_ORDER_TABLE_TBODYS
    <tr><td colspan="$nospan">No Data Available for Selected Dates</th></tr>
END_CHANGE_ORDER_TABLE_TBODYS;
else
        $coTableTbody .=<<<END_CHANGE_ORDER_TABLE_TBODYS
        <tr><td colspan="10">No Data Available for Selected Dates</th></tr>
END_CHANGE_ORDER_TABLE_TBODYS;

}
//   $tabData = array();
$tabData['coTableTbody'] = $coTableTbody;
if($categoryType==1)
{
    $tabData['total'] = $pcoCoTotal;
}elseif($categoryType==2)
{
    $tabData['total'] = $corCoTotal;
}else{
    $tabData['total'] = $approvedCoTotal;
}
$tabData['days'] = $totaldays;
  // echo "<pre>";
  // print_r($tabData);die();
//   echo "</pre>";
return $tabData;
}

function attachDocumentLink($changeOrderId, $database)
{
    
    $db = DBI::getInstance($database);
    $attachmentQuery = "SELECT s.co_attachment_file_manager_file_id, f.virtual_file_name , s.upload_execute FROM file_manager_files as  f JOIN change_order_attachments s  ON f.id = s.co_attachment_file_manager_file_id  WHERE s.change_order_id='$changeOrderId' and s.upload_execute='Y'";
    $db->query($attachmentQuery);
    $attachmentRecords = array();
    while($attachmentRow = $db->fetch())
    {
        $attachmentRecords[] = $attachmentRow;
    }
    $db->free_result();
    $attach = [];
    $count = count($attachmentRecords);
    $attach['count'] = $count;
    return $attach;
}

function PurchaseAndForcastReport($database, $user_company_id, $currentlyActiveContactId, $project_id, $companyName, $projectName, $cost_code_division_id_filter=null, $order_by_attribute=false, $order_by_direction=false, $scheduledValuesOnly=false, $needsBuyOutOnly=false)
{
	$loadGcBudgetLineItemsByProjectIdOptions = new Input();
	$loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
	if ($order_by_attribute) {
		if (!$order_by_direction) {
			$order_by_direction = 'ASC';
		}
		if ($order_by_attribute == 'cost_code') {
			$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
				'gbli_fk_codes__fk_ccd.`division_number`' => $order_by_direction,
				'gbli_fk_codes.`cost_code`' => $order_by_direction
			);

		} else {
			$loadGcBudgetLineItemsByProjectIdOptions->arrOrderByAttributes = array(
				//'gbli_fk_codes__fk_ccd.`division_number`' => 'ASC',
				//'gbli_fk_codes.`cost_code`' => 'ASC'
				$order_by_attribute => $order_by_direction
			);
		}
	}
	//$loadGcBudgetLineItemsByProjectIdOptions->offset = 0;
	//$loadGcBudgetLineItemsByProjectIdOptions->limit = 10;
	$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions);
	
	$arrSubcontractorBidStatusCountsByProjectId = SubcontractorBid::loadSubcontractorBidStatusCountsByProjectId($database, $user_company_id, $project_id, $cost_code_division_id_filter);

	$gcBudgetLineItemsTbody = '';

	$primeContractScheduledValueTotal = 0.00;
	$primeContractScheduledValueTotalcus = 0.00;
	$forecastedExpensesTotal = 0.00;
	$subcontractActualValueTotal = 0.00;
	$varianceTotal = 0.00;
	$loopCounter = 1;
	$tabindex = 100;
	$tabindex2 = 200;
	$totalicount=0;
	$totalbcount=0;
	$ForcastTbody='';
	foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
		/* @var $gcBudgetLineItem GcBudgetLineItem */

		if ($scheduledValuesOnly) {
			$prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
			if (!$prime_contract_scheduled_value) {
				continue;
			}
		}

		 $costCode = $gcBudgetLineItem->getCostCode();
		/* @var $costCode CostCode */

		$costCode->htmlEntityEscapeProperties();

		$costCodeDivision = $costCode->getCostCodeDivision();
		/* @var $costCodeDivision CostCodeDivision */

		$costCodeDivision->htmlEntityEscapeProperties();

		$cost_code_division_id = $costCodeDivision->cost_code_division_id;
		if (isset($cost_code_division_id_filter)) {
			if ($cost_code_division_id_filter != $cost_code_division_id) {
				continue;
			}
		}

		$contactCompany = $gcBudgetLineItem->getContactCompany();
		/* @var $contactCompany ContactCompany */

		$costCodeDivisionAlias = $gcBudgetLineItem->getCostCodeDivisionAlias();
		/* @var $costCodeDivisionAlias CostCodeDivisionAlias */

		$costCodeAlias = $gcBudgetLineItem->getCostCodeAlias();
		/* @var $costCodeAlias CostCodeAlias */

		$subcontractorBid = $gcBudgetLineItem->getSubcontractorBid();
		/* @var $subcontractorBid SubcontractorBid */

		$invitedBiddersCount = 0;
		$activeBiddersCount = 0;
		if (isset($arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id])) {
			$arrBidderStatusCounts = $arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id];

			// Invited Bidders - Include all
			/*
			if (isset($arrBidderStatusCounts[2])) {
				$invitedBiddersCount = $arrBidderStatusCounts[2];
			}
			*/
			foreach ($arrBidderStatusCounts as $subcontractor_bid_status_id => $total) {
				if ($subcontractor_bid_status_id <> 1) {
					$invitedBiddersCount += $total;
				}
			}

			// Active Bidders - Actively Bidding
			if (isset($arrBidderStatusCounts[4])) {
				$activelyBiddingCount = $arrBidderStatusCounts[4];
				$activeBiddersCount += $activelyBiddingCount;
			}

			// Active Bidders - Bid Received
			if (isset($arrBidderStatusCounts[5])) {
				$bidReceivedCount = $arrBidderStatusCounts[5];
				$activeBiddersCount += $bidReceivedCount;
			}
		}

		if ($invitedBiddersCount == 0) {
			$invitedBiddersCount = '';
		}

		if ($activeBiddersCount == 0) {
			$activeBiddersCount = '';
		}

		if (isset($subcontractorBid) && ($subcontractorBid instanceof SubcontractorBid)) {
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractor_bid_id = $subcontractorBid->subcontractor_bid_id;
		} else {
			$subcontractor_bid_id = '';
		}

		$cost_code_id = $costCode->cost_code_id;
		//$cost_code_division_alias_id = $costCodeDivisionAlias->cost_code_division_alias_id;
		//$cost_code_alias_id = $costCodeAlias->cost_code_alias_id;

		// prime_contract_scheduled_value
		$prime_contract_scheduled_value_raw = $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
		$primeContractScheduledValueClass = '';
		if (isset($prime_contract_scheduled_value) && !empty($prime_contract_scheduled_value)) {
			$primeContractScheduledValueTotal += $prime_contract_scheduled_value;
			if ($prime_contract_scheduled_value < 0) {
				$primeContractScheduledValueClass = ' red';
			}
			
		} else {
			$prime_contract_scheduled_value = '';
		}

		// forecasted_expenses
		$forecasted_expenses_raw = $forecasted_expenses = $gcBudgetLineItem->forecasted_expenses;
		$forecastedExpensesClass = '';
		if (isset($forecasted_expenses) && !empty($forecasted_expenses)) {
			$forecastedExpensesTotal += $forecasted_expenses;
			if ($forecasted_expenses < 0) {
				$forecastedExpensesClass = ' red';
			}
			$forecasted_expenses = Format::formatCurrency($forecasted_expenses);
		} else {
			$forecasted_expenses = '';
		}

		if($forecasted_expenses!='')
			// echo $prime_contract_scheduled_value;
			$primeContractScheduledValueTotalcus += $prime_contract_scheduled_value;
		if (isset($prime_contract_scheduled_value) && !empty($prime_contract_scheduled_value)) {
		$prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
		}
		$loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
		$loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
		$arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
		if (isset($arrSubcontracts) && !empty($arrSubcontracts)) {
			$subcontractCount = count($arrSubcontracts);
		} else {
			$subcontractCount = 0;
		}
		$subcontract_actual_value_raw = $subcontract_actual_value = null;
		$vendorList = '';
		$target_date = '';
		$arrSubcontractActualValueHtml = array();
		$arrSubcontractVendorHtml = array();
		$arrSubcontractTargetExecutionDateHtmlInputs = array();
		foreach ($arrSubcontracts as $subcontract) {
			/* @var $subcontract Subcontract */

			$tmp_subcontract_id = $subcontract->subcontract_id;
			//$tmp_gc_budget_line_item_id = $subcontract->gc_budget_line_item_id;
			$tmp_subcontract_sequence_number = $subcontract->subcontract_sequence_number;
			$tmp_subcontract_template_id = $subcontract->subcontract_template_id;
			$tmp_vendor_id = $subcontract->vendor_id;
			$tmp_unsigned_subcontract_file_manager_file_id = $subcontract->unsigned_subcontract_file_manager_file_id;
			$tmp_signed_subcontract_file_manager_file_id = $subcontract->signed_subcontract_file_manager_file_id;
			$tmp_subcontract_forecasted_value = $subcontract->subcontract_forecasted_value;
			$tmp_subcontract_actual_value = $subcontract->subcontract_actual_value;
			$tmp_subcontract_retention_percentage = $subcontract->subcontract_retention_percentage;
			$tmp_subcontract_issued_date = $subcontract->subcontract_issued_date;
			$tmp_subcontract_target_execution_date = $subcontract->subcontract_target_execution_date;
			$tmp_subcontract_execution_date = $subcontract->subcontract_execution_date;
			$tmp_active_flag = $subcontract->active_flag;

			// Subcontract Actual Value list
			$subcontract_actual_value_raw += $tmp_subcontract_actual_value;
			$subcontract_actual_value += $tmp_subcontract_actual_value;
			$formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
			if ($subcontractCount == 1) {
				$tmpSubcontractActualValueHtml = $formattedSubcontractActualValue;
			} elseif ($subcontractCount > 1) {
				$tmpSubcontractActualValueHtml = <<<END_HTML_CONTENT

				<tr>
					<td>
						<span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span> <span style="border: 0px solid red; display: inline-block; text-align: right; float: right;">$formattedSubcontractActualValue</span>
					</td>
				</tr>
END_HTML_CONTENT;

			}
			$arrSubcontractActualValueHtml[] = $tmpSubcontractActualValueHtml;

			// Vendor list
			$vendor = $subcontract->getVendor();
			if ($vendor) {

				$vendorContactCompany = $vendor->getVendorContactCompany();
				/* @var $vendorContactCompany ContactCompany */

				$vendorContactCompany->htmlEntityEscapeProperties();

				$vendorList .= $vendorContactCompany->escaped_contact_company_name . ', ';
				if ($subcontractCount == 1) {

					$tmpSubcontractVendorHtmlInputs = $vendorContactCompany->escaped_contact_company_name;

				} elseif ($subcontractCount > 1) {

					$tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT

				<span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$vendorContactCompany->escaped_contact_company_name
END_HTML_CONTENT;

				}
				$arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;

			}

			// subcontract_target_execution_date
			$formattedSubcontractTargetExecutionDate = $subcontract->getFormattedSubcontractTargetExecutionDate();
			if ($subcontractCount == 1) {
				$tmpSubcontractTargetExecutionDateHtmlInput = <<<END_HTML_CONTENT
				<div class="align-left">
					$formattedSubcontractTargetExecutionDate
				</div>
END_HTML_CONTENT;

			} elseif ($subcontractCount > 1) {

				$tmpSubcontractTargetExecutionDateHtmlInput = <<<END_HTML_CONTENT

				<div class="align-left">
					<span style="border: 0px solid red; display: inline-block; width: 30px;">$tmp_subcontract_sequence_number)</span> $formattedSubcontractTargetExecutionDate
				</div>
END_HTML_CONTENT;

			}

			$arrSubcontractTargetExecutionDateHtmlInputs[] = $tmpSubcontractTargetExecutionDateHtmlInput;

			// @todo...this parts
			// Foreign key objects
			//$subcontractTemplate = $subcontract->getSubcontractTemplate();
			/* @var $subcontractTemplate SubcontractTemplate */
			//$subcontract_template_id = $subcontractTemplate->subcontract_template_id;
		}

		// subcontract actual values
		if ($subcontractCount > 1) {
			//$subcontractActualValueHtml = join('<br>', $arrSubcontractActualValueHtml);
			$subcontractActualValueHtml = join('', $arrSubcontractActualValueHtml);
			$subcontractActualValueHtml = "\n\t\t\t\t\t$subcontractActualValueHtml";
		} else {
			$subcontractActualValueHtml = '';
		}

		// vendors
		//$vendorList = trim($vendorList, ' ,');
		$vendorList = join('<br>', $arrSubcontractVendorHtml);
		if ($subcontractCount > 1) {
			$vendorListTdClass = ' class="verticalAlignTopImportant"';
		} else {
			$vendorListTdClass = '';
		}

		// subcontract_target_execution_date
		$subcontractTargetExecutionDateHtmlInputs = join('', $arrSubcontractTargetExecutionDateHtmlInputs);

		if ($needsBuyOutOnly) {
			if ($subcontract_actual_value) {
				continue;
			}
		}

		// subcontract_actual_value
		$subcontractActualValueClass = '';
		if (isset($subcontract_actual_value) && !empty($subcontract_actual_value)) {
			$subcontractActualValueTotal += $subcontract_actual_value;
			if ($subcontract_actual_value < 0) {
				$subcontractActualValueClass = ' red';
			}
			$subcontract_actual_value = Format::formatCurrency($subcontract_actual_value);
		} else {
			$subcontract_actual_value = '&nbsp;';
		}


		// variance
		$pcsv = Data::parseFloat($prime_contract_scheduled_value_raw);
		$forecast = Data::parseFloat($forecasted_expenses_raw);
		$sav = Data::parseFloat($subcontract_actual_value_raw);
		$gcBudgetLineItemVariance = $pcsv - ($forecast + $sav);
		$varianceTotal += $gcBudgetLineItemVariance;
		if ($gcBudgetLineItemVariance < 0) {
			$gcBudgetLineItemVarianceClass = ' red';
		} else {
			$gcBudgetLineItemVarianceClass = '';
		}
		$gcBudgetLineItemVariance = Format::formatCurrency($gcBudgetLineItemVariance);

		if ($loopCounter%2) {
			$rowStyle = 'oddRow';
		} else {
			$rowStyle = 'evenRow';
		}
	if($prime_contract_scheduled_value!=''){
		$totalicount=$invitedBiddersCount+$totalicount;
		$totalbcount=$activeBiddersCount+$totalbcount;
		$gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
					<tr>
					<td align="left">
						$costCode->escaped_cost_code_description
					</td>
					<td align="right">
						$prime_contract_scheduled_value
					</td>
					<td align="center">$invitedBiddersCount</td>
					<td align="center">$activeBiddersCount</td>
					<td align="center" class="">$subcontractTargetExecutionDateHtmlInputs</td>
				</tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
}
if($prime_contract_scheduled_value!='' && $forecasted_expenses!=''){
$ForcastTbody.=<<<END_GC_BUDGET_LINE_ITEMS_TBODY
					<tr>
					<td>
						$costCode->escaped_cost_code_description
					</td>
					<td align="right">
						$prime_contract_scheduled_value
					</td>
					<td align="right">$forecasted_expenses</td>
					<td align="center"></td>
END_GC_BUDGET_LINE_ITEMS_TBODY;
}

		$loopCounter++;
		$tabindex++;
		$tabindex2++;

	}

	if ($primeContractScheduledValueTotal < 0) {
		$primeContractScheduledValueTotalClass = ' red';
	} else {
		$primeContractScheduledValueTotalClass = '';
	}
	$primeContractScheduledValueTotal = Format::formatCurrency($primeContractScheduledValueTotal);
	$primeContractScheduledValueTotalcus = Format::formatCurrency($primeContractScheduledValueTotalcus);
	if ($primeContractScheduledValueTotal < 0) {
		$forecastedExpensesTotalClass = ' red';
	} else {
		$forecastedExpensesTotalClass = '';
	}
	$forecastedExpensesTotal = Format::formatCurrency($forecastedExpensesTotal);

	if ($primeContractScheduledValueTotal < 0) {
		$subcontractActualValueTotalClass = ' red';
	} else {
		$subcontractActualValueTotalClass = '';
	}
	$subcontractActualValueTotal = Format::formatCurrency($subcontractActualValueTotal);

	if ($varianceTotal < 0) {
		$varianceTotalClass = ' red';
	} else {
		$varianceTotalClass = '';
	}
	$varianceTotal = Format::formatCurrency($varianceTotal);

	if($ForcastTbody!=''){
$ForcastTbody .= <<<END_FORM

				<tr>
					<th class="input-total align-left">Total</th>
					<th align="right"> $primeContractScheduledValueTotalcus</th>
					<th align="right">$forecastedExpensesTotal</th>
					<th></th>
				</tr>

END_FORM;
}else{
	$ForcastTbody .= <<<END_FORM

				<tr>
					<td class="input-total align-left" colspan="4">No Data Available for Selected Dates</td>
				</tr>

END_FORM;
}

if($gcBudgetLineItemsTbody!=''){
$gcBudgetLineItemsTbody .= <<<END_FORM

				<tr>
					<th class="input-total align-left">Total</th>
					<th align="right"> $primeContractScheduledValueTotal</th>
					<th class="center-align">$totalicount</th>
					<th class="center-align">$totalbcount</th>
					<th></th>
				</tr>

END_FORM;
}else{
	$gcBudgetLineItemsTbody .= <<<END_FORM

				<tr>
					<td class="input-total align-left" colspan="5">No Data Available for Selected Dates</td>
				</tr>

END_FORM;
}

	$gcBudgetForm = <<<END_FORM
		<table id="PurchaseingLog" class="tableborder content cell-border" cellpadding="5" cellspacing="0" width="49%" border="0">
		    <tr class="table-headerinner">
			<th colspan="5" class="textAlignLeft">Purchasing Log</th>
            </tr>
				<tr>
					<td align="left">Description</td>
					<td align="right">Schd Value</td>
					<td align="center">I</td>
					<td align="center">B</td>
					<td>Target Date</td>
				</tr>
			<tbody class="altColors">
			$gcBudgetLineItemsTbody
			</tbody>
		</table>
END_FORM;
$gcBudgetForm .= <<<END_FORM
		<table id="ForecastLog" class="tableborder content cell-border" cellpadding="5" cellspacing="0" width="49%" border="0">
			<thead class="borderBottom">
		    <tr class="table-headerinner">
			<th colspan="4" class="textAlignLeft">Forecast Value</th>
            </tr>
				<tr>
					<th align="left">Description</th>
					<th align="right">Schd Value</th>
					<th align="right">Forecast</th>
					<th align="right">Other</th>
				</tr>
			</thead>
			<tbody class="altColors">
			$ForcastTbody
			</tbody>
		</table>
END_FORM;
return $gcBudgetForm;
}	

function ReportchangeOrderTotalAndDelay($project_id, $change_order_type_id, $new_begindate, $enddate, $statusIds, $database){
  $db = DBI::getInstance($database);
  if($statusIds){
    $change_order_status_id = implode(',',$statusIds);
		$whereStatusIn = "and change_order_status_id IN(".$change_order_status_id.")";
  }else{
    $whereStatusIn = '';
  }
    $query1 ="
    SELECT  count(*) as count,change_order_type_id,sum(co_total) as total,sum(co_delay_days) as days FROM `change_orders`
    WHERE `project_id` = $project_id and `change_order_type_id` = $change_order_type_id $whereStatusIn and date(created)
    BETWEEN '$new_begindate' AND '$enddate' group by change_order_type_id";
    $db->execute($query1);
    $row1 = $db->fetch();
    $change_order_type_id = $row1['change_order_type_id'];

    $totalQuery ="
    SELECT sum(co_total) as total FROM `change_orders`
    WHERE `project_id` = $project_id and `change_order_type_id` =$change_order_type_id
    $whereStatusIn and date(created)
    BETWEEN '$new_begindate' AND '$enddate' group by change_order_type_id";
    $db->execute($totalQuery);
    $totalRow = $db->fetch();
    $total = $totalRow['total']; //$row1['total'];
    $days = $row1['days'];
    $count = $row1['count'];
    $db->free_result();
    $COData=array("count"=> $count,"days"=> $days,"total" =>$total,"type_id"=> $change_order_type_id);

        return $COData;
    }
    function getCOCostcodeFromCostBreakDown($database, $user_company_id,$change_order_id,$coType)
    {
        
    
        $arrCostCode = ChangeOrder::getcostBreakCostCodeId($database,$change_order_id);
        $inc =1;
        foreach ($arrCostCode as $key => $costvalue) {
        $OCOcost_code_id = $costvalue['cost_code_reference_id'];
        $OCOcost_code_amount = floatVal($costvalue['cost']);
        $OCOcost_code_amount = Format::formatCurrency($OCOcost_code_amount);
        if($OCOcost_code_id !="")
        {
        $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
        $costcodedata = CostCodeDivision::getcostCodeDivisionByCostcodeId($database,$OCOcost_code_id,$costCodeDividerType);
        $formattedSuCostCode .= $inc .") ".$costcodedata['short_cost_code']."<br>";
        $formattedSuCostCodeAmount .= $OCOcost_code_amount."<br>";
        $inc ++;
        }
        
        }
        if($coType== '1')
        {
            return  $formattedSuCostCode;
        }else {
            return $formattedSuCostCodeAmount;
        }
        
    }
    function getCOCostcodeFromCostBreakDownAmount($database, $user_company_id,$change_order_id)
    {
        $sum = 0;
        $arrAmt =[];
        $arrCostCode = ChangeOrder::getcostBreakCostCodeId($database,$change_order_id);
   
        foreach ($arrCostCode  as $costvalue) {        
        // echo $costvalue['cost'];
        // echo "<br/>";
        if($costvalue['cost_code_reference_id'] != '')
        {
            
            $testCost = floatVal($costvalue['cost']);     
            $sum = $sum + $testCost;            
        }
        }
        return $sum;

        // var_dump($sum);
    }
?>

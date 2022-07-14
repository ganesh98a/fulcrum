<?php
include_once('lib/common/GcBudgetLineItem.php');
include_once('lib/common/Subcontract.php');
include_once('lib/common/SubcontractTemplate.php');
include_once('lib/common/Vendor.php');
include_once('lib/common/SubcontractorBid.php');
include_once('lib/common/Format.php');
include_once('lib/common/ContactCompanyOffice.php');
include_once('lib/common/JobsiteDailyLog.php');
include_once('lib/common/JobsiteManPower.php');
include_once('lib/common/OpenWeatherAmPmLogs.php');
include_once('lib/common/ContactCompanyOfficePhoneNumber.php');
include_once('lib/common/WeatherUndergroundMeasurement.php');
include_once('lib/common/RequestForInformation.php');
include_once('lib/common/RequestForInformationType.php');
include_once('lib/common/RequestForInformationStatus.php');
include_once('lib/common/RequestForInformationPriority.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('lib/common/PhoneNumberType.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/SubcontractorBidStatus.php');

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

/*Meeting data requires*/
require_once('lib/common/Meeting.php');
require_once('lib/common/MeetingAttendee.php');
require_once('lib/common/MeetingLocation.php');
require_once('lib/common/MeetingLocationTemplate.php');
require_once('lib/common/MeetingType.php');
require_once('lib/common/MeetingTypeTemplate.php');
require_once('lib/common/DiscussionItem.php');
require_once('lib/common/DiscussionItemComment.php');
require_once('lib/common/DiscussionItemPriority.php');
require_once('lib/common/DiscussionItemRelationship.php');
require_once('lib/common/DiscussionItemStatus.php');
require_once('lib/common/DiscussionItemToActionItem.php');
require_once('lib/common/DiscussionItemToDiscussionItemComment.php');
require_once('lib/common/Contact.php');
require_once('lib/common/ContactAddress.php');
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
require_once('lib/common/Project.php');
require_once('lib/common/ProjectType.php');
require_once('lib/common/ProjectBidInvitation.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
// require_once('lib/common/UserComapny.php');

require_once('lib/common/BidList.php');
require_once('lib/common/CostCode.php');
require_once('lib/common/CostCodeDivision.php');
require_once('lib/common/DrawItems.php');

require_once('../subcontract-change-order-functions.php');
/** Get delay log and daily log data for report generation */
function DelayLog($database, $RN_project_id,$RN_reportType,$RN_reportsStartDate,$RN_reportsEndDate,$type_mention){
	 $db = DBI::getInstance($database);
$incre_id=1;
  
     if($RN_reportType=="Project Delay Log")
    {
         $filter= "";
    }
    else
    {
       $filter= "and source='".$RN_reportType."' ";
    }
    
    $query = "SELECT * FROM jobsite_delay_data where is_deleted = '0' and project_id='".$RN_project_id."' and begindate between '".$RN_reportsStartDate."' and '".$RN_reportsEndDate."' $filter";
    $db->execute($query);
    $records = array();

    while($row = $db->fetch())
    {
        $records[] = $row;
    }
    $delayTableTbody='';
    foreach($records as $row)
    {
        $delid      = $row['id'];
        $source     = $row['source'];
        $type       = $row['type'];
        $scategory  = $row['subcategory'];
        $bdate      = $row['begindate'];
        $edate      = $row['enddate'];
        $days       = $row['days'];
        $notes      = $row['notes'];
        $status     = $row['status'];
        $notified   = $row['notified'];
        $action     = $row['action'];
        
        $db1 = DBI::getInstance($database);
        $query1 = "SELECT * FROM jobsite_delay_category_templates WHERE id='$type'";
        $query2 = "SELECT * FROM jobsite_delay_subcategory_templates WHERE id='$scategory'";
        $query3 = "SELECT * FROM jobsite_delay_logs_status WHERE id='$status'"; 
        $query4 = "SELECT * FROM jobsite_delay_logs_notified WHERE id='$notified'"; 

        $db1->execute($query1);
        while ($row1 = $db1->fetch()) 
        {
            $cattype = $row1['jobsite_delay_category'];
        }
        $db1->execute($query2);
        while ($row1 = $db1->fetch()) 
        {
            $subact = $row1['jobsite_delay_subcategory'];
        }
        if($status == '1'){
            $delayStaus = 'Pending';
        }else if($status == '2'){
            $delayStaus =   'Notify';
        }else if($status == '3'){
            $delayStaus = 'Claim';
        }else{
            $delayStaus = '';
        }

        if($notified == '1'){
            $delayNotify = 'Yes';
        }else if($notified == '2'){
            $delayNotify =  'No';
        }else{
            $delayNotify = '';
        }

        if($days == ''){
            $fromDate = strtotime($bdate);
            $toDate = strtotime($edate);
            $dateDiff = ($toDate - $fromDate) +1;
            $days =  floor($dateDiff / (60 * 60 * 24));

        }

        

        if($bdate == '0000-00-00')
            {
                $formattedDelaybdate = '';
            }else{
                $formattedDelaybdate = date("m/d/Y", strtotime($bdate));
            }
            if($edate == '0000-00-00')
            {
                $formattedDelayedate = '';
            }
            else{
                $formattedDelayedate = date("m/d/Y", strtotime($edate));
            }
        
            $delayTableTbody .= <<<END_DELAYS_TABLE_TBODY
        <tr id="record_container--manage-request_for_information-record--" class="row_$delid">
            <td class="textAlignCenter" id="manage-request_for_information-record--">$incre_id</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $source</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $cattype</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $subact</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $formattedDelaybdate</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $formattedDelayedate</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $days</td>
            <td class="textAlignLeft text-justify"  id="manage-request_for_information-record--" >$notes</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $delayStaus</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $delayNotify</td>
            
        </tr>

END_DELAYS_TABLE_TBODY;

        
        $incre_id++;
}

    if($delayTableTbody==''){
     $delayTableTbody=<<<Table_Data
    <tr><td colspan="10">No Data Available for Selected Dates</td></tr>
Table_Data;
}
if($RN_reportType == 'Daily Construction Report (DCR)')
$headerIndex= "Daily Log";
else
$headerIndex= "Delay Log";

  $delayTableTbody = mb_convert_encoding($delayTableTbody, "HTML-ENTITIES", "UTF-8");

    $htmlContent = <<<END_HTML_CONTENT
    <div class="custom_datatable_style">
<table id="delay_list_container--manage-request_for_information-record" class="content cell-border tableborder" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom">
    <tr class="table-headerinner">
    <th colspan="10" class="textAlignLeft">$headerIndex</th>
    </tr>
        <tr>
        <th class="textAlignCenter">#</th>
        <th class="textAlignLeft">Source</th>
        <th class="textAlignLeft">Type</th>
        <th class="textAlignLeft">Category</th>
        <th class="textAlignLeft">Begin</th>
        <th class="textAlignLeft">End</th>
        <th class="textAlignLeft">Days</th>
        <th class="textAlignLeft" width="30%">Notes</th>
        <th class="textAlignLeft">Status</th>
        <th class="textAlignLeft">Notified</th>
        
        </tr>
    </thead>
    <tbody class="altColors">
        $delayTableTbody
    </tbody>
</table>
</div>

END_HTML_CONTENT;
return $htmlContent;
}

//Get  Contract log data for pdf generation
function ContractLog($database, $user_company_id,$project_id,$new_begindate,$enddate){
    $db = DBI::getInstance($database);
    $db->free_result();
    //cost code divider
    $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

    $arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdReport($database, $project_id);
    $gcBudgetLineItemsTbody='';
    $loopCounter=1;

    foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
        /* @var $gcBudgetLineItem GcBudgetLineItem */

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




        $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
        $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
        $arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemIdWithDate($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions,$new_begindate,$enddate);
        
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
        $formattedSubcontractMailedDate='';
        $formattedSubcontractTargetExecutionDate='';
        // subcontract_mailed_date
            $arrSubcontractMailedDateHtmlInputs=array();
            $arrSubcontractTargetExecutionDateHtmlInputs=array();
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
            $tmpSubcontractTargetExecutionDateHtmlInput = '';
            $tmpSubcontractMailedDateHtmlInput = '';
            // Subcontract Actual Value list
            $subcontract_actual_value_raw += $tmp_subcontract_actual_value;
            $subcontract_actual_value += $tmp_subcontract_actual_value;
            $formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
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
            $formattedSubcontractMailedDate = $subcontract->deriveFormattedSubcontractMailedDate();
            $formattedSubcontractTargetExecutionDate = $subcontract->deriveFormattedSubcontractExecutionDate();
            if ($subcontractCount == 1) {
                if($formattedSubcontractTargetExecutionDate!='' && $formattedSubcontractTargetExecutionDate!=null){
                $tmpSubcontractTargetExecutionDateHtmlInput = <<<END_HTML_CONTENT

                <span id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="datepicker" value="$formattedSubcontractTargetExecutionDate" style="margin-top: 1px; text-align: center; width:80px;">$formattedSubcontractTargetExecutionDate</span>
END_HTML_CONTENT;
                }
                if($formattedSubcontractMailedDate!='' && $formattedSubcontractMailedDate!=null){
$tmpSubcontractMailedDateHtmlInput = <<<END_HTML_CONTENT

                <span id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="datepicker" value="$formattedSubcontractMailedDate" style="margin-top: 1px; text-align: center; width:80px;">$formattedSubcontractMailedDate</span>
END_HTML_CONTENT;
                }
            } elseif ($subcontractCount > 1) {
                if($formattedSubcontractTargetExecutionDate!='' && $formattedSubcontractTargetExecutionDate!=null){
                $tmpSubcontractTargetExecutionDateHtmlInput = <<<END_HTML_CONTENT
                <div class="textAlignLeft">
                    <span id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="datepicker" value="$formattedSubcontractTargetExecutionDate" style="margin-top: 1px; text-align: center; width:80px;"><span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$formattedSubcontractTargetExecutionDate</span>
                </div>
END_HTML_CONTENT;
                }
                if($formattedSubcontractMailedDate!='' && $formattedSubcontractMailedDate!=null){
 $tmpSubcontractMailedDateHtmlInput = <<<END_HTML_CONTENT

                <div class="textAlignLeft">
                    <span id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="datepicker" value="$formattedSubcontractMailedDate" style="margin-top: 1px; text-align: center; width:80px;"><span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$formattedSubcontractMailedDate</span>
                </div>
END_HTML_CONTENT;
                }
            }
            
            $arrSubcontractTargetExecutionDateHtmlInputs[] = $tmpSubcontractTargetExecutionDateHtmlInput;
            $arrSubcontractMailedDateHtmlInputs[]=$tmpSubcontractMailedDateHtmlInput;
            // @todo...this parts
            // Foreign key objects
        }

        // vendors
        $vendorList = join('<br>', $arrSubcontractVendorHtml);
        if ($subcontractCount > 1) {
            $vendorListTdClass = ' class="verticalAlignTopImportant"';
        } else {
            $vendorListTdClass = '';
        }

        // subcontract_target_execution_date
        $subcontractTargetExecutionDateHtmlInputs = join('', $arrSubcontractTargetExecutionDateHtmlInputs);
        $subcontractMailedDateHtmlInputs = join('', $arrSubcontractMailedDateHtmlInputs);

        if ($loopCounter%2) {
            $rowStyle = 'oddRow';
        } else {
            $rowStyle = 'evenRow';
        }

        $costCodeData = $costCodeDivision->escaped_division_number.$costCodeDividerType.$costCode->escaped_cost_code;
        $gcBudgetLineItemsTbody .= <<<GC_BUDGET_LINE_ITEMS_TBODY
                <tr id="record_container--manage-request_for_information-record--" class="$rowStyle">

GC_BUDGET_LINE_ITEMS_TBODY;

        $gcBudgetLineItemsTbody.=<<<END_GC_BUDGET_LINE_ITEMS_TBODY
        <td class="textAlignCenter">$loopCounter</td>
        <td class="textAlignLeft">$costCodeData</td>
        <td class="textAlignLeft">$costCode->escaped_cost_code_description</td>
        <td class="textAlignLeft">$vendorList</td>
        <td class="textAlignLeft">$subcontractMailedDateHtmlInputs</td>
        <td class="textAlignLeft">$subcontractTargetExecutionDateHtmlInputs</td>        
        </tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
        $loopCounter++;
      

    }
$gcBudgetLineItemsTbody = mb_convert_encoding($gcBudgetLineItemsTbody, "HTML-ENTITIES", "UTF-8");
if($gcBudgetLineItemsTbody==''){
$gcBudgetLineItemsTbody="<tr><td colspan='6'>No Data Available for Selected Dates</td></tr>";
}
    $htmlContent = <<<END_HTML_CONTENT
    <div class="custom_datatable_style">
    <table id="delay_list_container--manage-request_for_information-record" class="content cell-border tableborder" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom">
    <tr class="table-headerinner">
    <th colspan="6" class="textAlignLeft">Contract Log</th>
    </tr>
        <tr>
        <th class="textAlignCenter">#</th>
        <th class="textAlignLeft">Code</th>
        <th class="textAlignLeft">Name</th>
        <th class="textAlignLeft">Company</th>
        <th class="textAlignLeft">Mailed</th>
        <th class="textAlignLeft">Execution</th>       
        </tr>
    </thead>
    <tbody class="">
        $gcBudgetLineItemsTbody
    </tbody>
</table>
</div>

END_HTML_CONTENT;
return $htmlContent;
}


//To get the man power Data

function ManPowerData($database, $user_company_id, $project_id,  $new_begindate, $enddate, $typemention=null)
{

$maxDays=7;
$arrayManValue=array();
$arrayManDate=array();
$arrayManComp=array();
$count='1';

$htmlContent = '';
for($inday=0;$inday<$maxDays;$inday++){
     $sub_count='1';
    $datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
    $jobsite_daily_log_id = '';
    $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);
    if ($jobsiteDailyLog) {
       $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    }
    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
    $arrJobsiteManPowerIds = '';
    $arrJobsiteManPowerByJobsiteDailyLogId = '';
    $arrJobsiteManPowerBySubcontractId = '';
    if(isset($arrReturn['jobsite_man_power_ids'])) {
        $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
    }
    if(isset($arrReturn['objects'])) {
        $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
    }
    if(isset($arrReturn['jobsite_man_power_by_subcontract_id'])) {
        $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];
    }    

    $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);
    $totalnumber_of_people=0;
    foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        /* @var $subcontract Subcontract */

        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        $costCode = $gcBudgetLineItem->getCostCode();
        /* @var $costCode CostCode */

        $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$user_company_id);

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

        //$onchange = "setTimeoutForSaveJobsiteManPower('manage-jobsite_man_power-record', '$uniqueId');";
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
 if($number_of_people==0)
    $number_of_people='';
    if($typemention=="PDF"){
    $WeekDay=date('D', strtotime($datestep));
    $begindate = DateTime::createFromFormat('Y-m-d', $datestep);
    $manDate = $begindate->format('m/d');
    }
$arrayManComp[$sub_count][0]=$contact_company_name.'-'.$htmlEntityEscapedFormattedCostCode;
$arrayManValue[$sub_count][0]='';
$arrayManValue[$sub_count][$count]=$number_of_people;
$arrayManDate[$count]=$WeekDay.','.$manDate;

$sub_count++;
    }
 $count++;

 }
 $array_count=count($arrayManValue);
 $date_count=count($arrayManDate);
 $CheckTableValue=1;
 $valuehtml='<table id="manpower_activity" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">';
 $valuehtml.='';
$valuehtml.='<tr class="table-headerinner">
        <td colspan="'.($date_count+2).'" class="align-left">MANPOWER ACTIVITY </td>
        </tr>';
 
 
$arrayChek=array();
$checkNull='';
foreach($arrayManValue as $index=>$value)
{
    $value=array_filter($arrayManValue[$index]);
    foreach($arrayManValue[$index] as $index1 => $value1)
    {
        $JoinArray='';
        if(isset($arrayChek[$index1])){
            $JoinArray .=$arrayChek[$index1];    
        }
        $JoinArray .=$arrayManValue[$index][$index1];
        $arrayChek[$index1]=$JoinArray;
        $checkNull .= $arrayManValue[$index][$index1];
    }
}
$counttotalValue = 0;
if($checkNull!=''){
for($datei=1;$datei<=$date_count;$datei++)
{
    if($datei==1)
    $valuehtml.='<tr><td>Company</td>';
    $value_explode=explode(',',$arrayManDate[$datei]);
    $valuehtml.='<td>'.$value_explode[0]."\n".$value_explode[1].'</td>';
    if($datei==$date_count)
    $valuehtml.="<td>WEEK TOTAL</td></tr>";

}
$valuehtml.="";
$valuehtml.='<tbody class="">';
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
        $class="class='center-align'";
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
        if(isset($coltotalarray[$invaluei])) {
            $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
        } else {
            $coltotalarray[$invaluei]=$arrayManValue[$valuei][$invaluei];
        }
        if($arrayManValue[$valuei][$invaluei]!='')
        $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
    }
}
$valuehtml.="<td class='total_bold center-align'>$row_total</td>";
$valuehtml.="</tr>";
$weekTotalcol=$weekTotalcol+$row_total;
$coltotalarray[$invaluei]=$weekTotalcol;
}
$counttotalValue=count($coltotalarray);
$valuehtml.="<tr class='total_bold center-align'>";
for($invaluet=1;$invaluet<=$counttotalValue;$invaluet++){
    if($invaluet==1)
    $valuehtml.="<td>DAY TOTAL</td>";
    if(isset($arrayChek[$invaluet]) && $arrayChek[$invaluet]!='')
        $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
    else{
        if($invaluet==$counttotalValue)
            $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
        else
            $valuehtml.="<td></td>";
    }

}
}
if($counttotalValue==0){
$valuehtml.="<tr><td colspan=".($maxDays+2).">No Manpower Efforts Involved For Selected Dates</td>";
$CheckTableValue=0;
}
$valuehtml.="</tr>";
$valuehtml.="</tbody>";
$valuehtml.='</table><input type="hidden" id="CheckTableValue" name="CheckTableValue" value="'.$CheckTableValue.'">';
    return $valuehtml;
}

//To get the weather condition and Temperature
function getAmPmWeatherTemperaturesAndConditions($database, $project_id, $created)
{
    $created_arr = explode('-', $created);
    $year=$created_arr[0];

    //Before 2019 weather api record
    if($year < '2019')
    {
    $arrWeatherUndergroundMeasurements = WeatherUndergroundMeasurement::loadAmPmWeatherUndergroundMeasurementsByProjectId($database, $project_id, $created);
    }else
    {
    $arrWeatherUndergroundMeasurements = OpenWeatherAmPmLogs::loadAmPmOpenWeatherByProjectId($database, $project_id, $created);
    }

    $amWeatherUndergroundMeasurement = $arrWeatherUndergroundMeasurements['am'];
    $pmWeatherUndergroundMeasurement = $arrWeatherUndergroundMeasurements['pm'];

    // Sanity check to see if this report is for the present or a past date
    $todayAsMysqlDate = $created;
    $createdAsUnixTimestamp = strtotime($created);
    $createdAsMysqlDate = date('Y-m-d', $createdAsUnixTimestamp);
    if ($todayAsMysqlDate == $createdAsMysqlDate) {
        $reportIsForToday = true;
    } else {
        $reportIsForToday = false;
    }

    if ($amWeatherUndergroundMeasurement) {
        /* @var $amWeatherUndergroundMeasurement WeatherUndergroundMeasurement */
         //Before 2019 weather api record
        if($year < '2019'){
        $amTemperature = $amWeatherUndergroundMeasurement->temperature . '&deg; F';

        $amWeatherUndergroundConditionLabel = $amWeatherUndergroundMeasurement->getWeatherUndergroundConditionLabel();
        /* @var $amWeatherUndergroundConditionLabel WeatherUndergroundConditionLabel */

        $amCondition = $amWeatherUndergroundConditionLabel->weather_condition_label;
    }else
    {
        $amTemperature = $amWeatherUndergroundMeasurement['temperature'] . '&deg; F';
        $amCondition = $amWeatherUndergroundMeasurement['condition'];
    }
    } else {
        if ($reportIsForToday) {

            $nowAsUnixTimestamp = time();
            $eightAm = $createdAsUnixTimestamp + 28800;
            // Past and Present Weather Measurements
            if ($createdAsUnixTimestamp <= $nowAsUnixTimestamp) {
                // Today, but earlier than 5:00am when the first measurement is recorded
                if ($nowAsUnixTimestamp < $eightAm) {
                    $amTemperature = 'TBD';
                    $amCondition = 'TBD';
                } else {
                    // Past Date: either no measurement was recorded, or weather data is unavailable
                    $amTemperature = 'Unavailable';
                    $amCondition = 'Unavailable';
                }
            } else {
                // Future Weather Measurements
                $amTemperature = 'TBD';
                $amCondition = 'TBD';
            }

        } else {
            // Past Date: either no measurement was recorded, or weather data is unavailable
            $amTemperature = 'Unavailable';
            $amCondition = 'Unavailable';
        }
    }

    if ($pmWeatherUndergroundMeasurement) {
         //Before 2019 weather api record
        if($year < '2019'){
        /* @var $pmWeatherUndergroundMeasurement WeatherUndergroundMeasurement */
        $pmTemperature = $pmWeatherUndergroundMeasurement->temperature . '&deg; F';

        $pmWeatherUndergroundConditionLabel = $pmWeatherUndergroundMeasurement->getWeatherUndergroundConditionLabel();
        /* @var $pmWeatherUndergroundConditionLabel WeatherUndergroundConditionLabel */

        $pmCondition = $pmWeatherUndergroundConditionLabel->weather_condition_label;
    }else
    {
        $pmTemperature = $pmWeatherUndergroundMeasurement['temperature'] . '&deg; F';
        $pmCondition = $pmWeatherUndergroundMeasurement['condition'];
    }
    } else {
        if ($reportIsForToday) {

            $todayAsMysqlDate = $created;
            if ($created == $todayAsMysqlDate) {
                $pmTemperature = 'TBD';
                $pmCondition = 'TBD';
            } else {
                $createdAsUnixTimestamp = strtotime($created);
                $todayAsUnixTimestamp = strtotime($todayAsMysqlDate);
                if ($createdAsUnixTimestamp < $todayAsUnixTimestamp) {
                    $pmTemperature = 'Unavailable';
                    $pmCondition = 'Unavailable';
                } else {
                    $pmTemperature = 'TBD';
                    $pmCondition = 'TBD';
                }
            }

        } else {
            // Past Date: either no measurement was recorded, or weather data is unavailable
            $pmTemperature = 'Unavailable';
            $pmCondition = 'Unavailable';
        }
    }

    $arrReturn = array(
        'amTemperature' => $amTemperature,
        'amCondition'   => $amCondition,
        'pmTemperature' => $pmTemperature,
        'pmCondition'   => $pmCondition
    );
    return $arrReturn;
}
// Get detailed weekly report 
function DetailedWeeklyReport($database, $user_company_id,$project_id,$date,$date1,$new_begindate,$enddate,$begindate,  $typemention=null){ 
// To get the all date between the specified dates
$man_power=ManPowerData($database, $user_company_id, $project_id, $new_begindate, $enddate, $typemention);

$begin=new DateTime($date);
$end=new DateTime($date1);
$end = $end->modify( '+1 day' ); 

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$days = '';
$amTemperatures = '';
$amConditions = '';
$pmTemperatures = '';
$pmConditions = '';
foreach ( $period as $dt )
{

    $display_date = $dt->format("m/d/Y");
    $created_date = $dt->format("Y-m-d");
     $WeekDay=date('l', strtotime($created_date));

    $arrReturn = getAmPmWeatherTemperaturesAndConditions($database, $project_id, $created_date);
    $amTemperature = $arrReturn['amTemperature'];
    $amCondition   = $arrReturn['amCondition'];
    $pmTemperature = $arrReturn['pmTemperature'];
    $pmCondition   = $arrReturn['pmCondition'];
    
    $days.=<<<Days_View
    <th align="left" class="align-left">$WeekDay\n$display_date</th>
Days_View;
    $amTemperatures.=<<<amTemperature
    <td>$amTemperature</td>
amTemperature;
$amConditions.=<<<amCondition
    <td>$amCondition</td>
amCondition;
$pmTemperatures.=<<<pmTemperature
    <td>$pmTemperature</td>
pmTemperature;
$pmConditions.=<<<pmCondition
    <td>$pmCondition</td>
pmCondition;
}
$weather=<<<CONDITION_TEMP
    <tr><td rowspan="2">AM Temp / Condition</td>$amTemperatures</tr>
    <tr>$amConditions</tr>
    <tr><td rowspan="2">PM Temp / Condition</td>$pmTemperatures</tr>
    <tr>$pmConditions</tr>
CONDITION_TEMP;
//get the data's from table for daily schedule log
$scheduledalys=DelayView_AsHtml($database, $project_id,$new_begindate,$enddate);
$jobsite_daily_log_id = null;
$filterByManpowerFlag = false;
//get the data's from table for Man Power 
/*$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdForJobsiteDailyLogDate($database, $project_id, $new_begindate,$enddate);
$jobsiteDailyDate = JobsiteDailyLog::findByProjectIdForJobsiteDailyDateValues($database, $project_id, $new_begindate,$enddate);
$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdForJobsiteDailyLogDate($database, $project_id, $new_begindate,$enddate);*/

$man_powers=ManPowerData($database, $user_company_id, $project_id, $new_begindate, $enddate);

//get the data's from table for sitework section
$jobsiteDailyLog = findByProjectIdAndJobsiteDailyLogModifiedSite($database, $project_id, $new_begindate, $enddate);
//Sitework activity table data
$siteworkact=<<<SITEWORKACT_TABLE_DATA
<tr>
<td class="con_jus">$jobsiteDailyLog</td>
</tr>
SITEWORKACT_TABLE_DATA;
//get the data's from table for building section
$jobsiteDailyBuild = findByProjectIdAndJobsiteDailyLogModifiedBuild($database, $project_id, $new_begindate, $enddate);
//BUILDING activity table data
$buildingact=<<<BUILDINGACT_TABLE_DATA
<tr>
<td class="con_jus">$jobsiteDailyBuild</td>
</tr>
BUILDINGACT_TABLE_DATA;
//get the data's from table for inspection section
$jobsiteDailyInspect = findByProjectIdAndJobsiteDailyLogModifiedInspection($database, $project_id, $new_begindate, $enddate);
$inspections=$jobsiteDailyInspect;
//get the data's from table for Other Notes section
$othernotes=findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $new_begindate, $enddate, '1');
//get the data's from table for SWPP Notes section
$swpppnotes=findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $new_begindate, $enddate, '4');
//get the data's from table for Deliveries Notes section
$deliveries=findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $new_begindate, $enddate, '5');
//get the data's from table for visitors Notes section
$visitors=findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $new_begindate, $enddate, '3');
//get the data's from table for Extra Work section
$extrawork=findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $new_begindate, $enddate, '6');
//get the data's from table for Safety section
$safetyissues=findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $new_begindate, $enddate, '2');
$htmlContent = <<<END_HTML_CONTENT
<table id="weather" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom">
        <tr class="table-headerinner">
        <th colspan="8" class="align-left">WEATHER</th>
        </tr>
        <tr>
        <th width="20%"></th>
        $days
        </tr>
    </thead>
    <tbody class="altColors">
        $weather
    </tbody>
</table>
<table id="schedule_daelay" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="4" class="align-left">SCHEDULE DELAYS </td>
        </tr>
        <tr class="boldTD">
        <td class="align-left">Date</td>
        <td class="align-left">Category</td>
        <td class="align-left">Type</td>
        <td class="align-left">Description</td>
        </tr>
    <tbody class="altColors">
        $scheduledalys
    </tbody>
</table>
$man_power
<table id="sitework_activity" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="1" class="align-left">SITEWORK ACTIVITY </td>
        </tr>
    <tbody class="altColors">
        $siteworkact
    </tbody>
</table>
<table id="building_activity" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="1" class="align-left">BUILDING ACTIVITY </td>
        </tr>
    <tbody class="altColors">
        $buildingact
    </tbody>
</table>
<table id="inspections" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="4" class="align-left">INSPECTIONS </td>
        </tr>
        <tr class="boldTD">
        <td class="align-left" width="30%">DATE</td>
        <td class="align-left">INSPECTION</td>
        <td class="align-left">DESCRIPTION</td>
        <td class="align-left">PASSED</td>
        </tr>
    <tbody class="altColors">
        $inspections
    </tbody>
</table>
<table id="swppp_notes" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="2" class="align-left">SWPPP NOTES </td>
        </tr>
        <tr class="boldTD">
        <td class="align-left" width="30%">DATE</td>
        <td class="align-left">DESCRIPTION</td>
        </tr>

    <tbody class="altColors">
        $swpppnotes
    </tbody>
</table>
<table id="other_notes" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="2" class="align-left">OTHER NOTES </td>
        </tr>
        <tr class="boldTD">
        <td class="align-left" width="30%">DATE</td>
        <td class="align-left">NOTE</td>
        </tr>
    <tbody class="altColors">
        $othernotes
    </tbody>
</table>
<table id="visitors" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="2" class="align-left">VISITORS</td>
        </tr>
        <tr class="boldTD">
        <td class="align-left" width="30%">DATE</td>
        <td class="align-left">COMMENT</td>
        </tr>
    <tbody class="altColors">
        $visitors
    </tbody>
</table>
<table id="deliveries" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="2" class="align-left">DELIVERIES</td>
        </tr>
        <tr class="boldTD">
        <td class="align-left" width="30%">DATE</td>
        <td class="align-left">DESCRIPTION</td>
        </tr>
    <tbody class="altColors">
        $deliveries
    </tbody>
</table>
<table id="safetyissues" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="2" class="align-left">SAFETY ISSUES</td>
        </tr>
        <tr class="boldTD">
        <td class="align-left" width="30%">DATE</td>
        <td class="align-left">DESCRIPTION</td>
        </tr>
    <tbody class="altColors">
        $safetyissues
    </tbody>
</table>
<table id="extrawork" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">

        <td colspan="2" class="align-left">EXTRA WORK</td>
        </tr>
        <tr class="boldTD">
        <td class="align-left" width="30%">DATE</td>
        <td class="align-left">DESCRIPTION</td>
        </tr>
    <tbody class="altColors">
        $extrawork
    </tbody>
</table>
END_HTML_CONTENT;
    return $htmlContent;

    
}
/**
* Display the Delay Grid
* @param project id
* @return html
*/
function DelayView_AsHtml($database, $projectId,$new_begindate,$enddate)
{   
    
    $delayTableTbody = '';
    $delayTableTbody1 = '';
    $incre_id=1;
    $db = DBI::getInstance($database);
    $query = "SELECT * FROM jobsite_delay_data where is_deleted = '0' and project_id='".$projectId."' and begindate between '".$new_begindate."' and '".$enddate."'";
    $db->execute($query);
    $records = array();
    while($row = $db->fetch())
    {
        $records[] = $row;
    }
    foreach($records as $row)
    {
        $delid      = $row['id'];
        $source     = $row['source'];
        $type       = $row['type'];
        $scategory  = $row['subcategory'];
        $bdate      = $row['begindate'];
        $edate      = $row['enddate'];
        $days       = $row['days'];
        $notes      = $row['notes'];
        $status     = $row['status'];
        $notified   = $row['notified'];
        $action     = $row['action'];
        
        $db1 = DBI::getInstance($database);
        $query1 = "SELECT * FROM jobsite_delay_category_templates WHERE id='$type'";
        $query2 = "SELECT * FROM jobsite_delay_subcategory_templates WHERE id='$scategory'";
        $query3 = "SELECT * FROM jobsite_delay_logs_status WHERE id='$status'"; 
        $query4 = "SELECT * FROM jobsite_delay_logs_notified WHERE id='$notified'"; 

        $db1->execute($query1);
        while ($row1 = $db1->fetch()) 
        {
            $cattype = $row1['jobsite_delay_category'];
        }
        $db1->execute($query2);
        while ($row1 = $db1->fetch()) 
        {
            $subact = $row1['jobsite_delay_subcategory'];
        }
        if($status == '1'){
            $delayStaus = 'Pending';
        }else if($status == '2'){
            $delayStaus =   'Notify';
        }else if($status == '3'){
            $delayStaus = 'Claim';
        }else{
            $delayStaus = '';
        }

        if($notified == '1'){
            $delayNotify = 'Yes';
        }else if($notified == '2'){
            $delayNotify =  'No';
        }else{
            $delayNotify = '';
        }

        if($days == ''){
            $fromDate = strtotime($bdate);
            $toDate = strtotime($edate);
            $dateDiff = ($toDate - $fromDate) +1;
            $days =  floor($dateDiff / (60 * 60 * 24));

        }

        

        if($bdate == '0000-00-00')
            {
                $formattedDelaybdate = '';
                $beginWeekDay='';
            }else{
                $formattedDelaybdate = date("m/d/Y", strtotime($bdate));
                $beginWeekDay=date('l', strtotime($bdate));

            }
            if($edate == '0000-00-00')
            {
                $formattedDelayedate = '';
            }
            else{
                $formattedDelayedate = date("m/d/Y", strtotime($edate));
            }
        
            $delayTableTbody .= <<<END_DELAYS_TABLE_TBODY
        <tr id="record_container--manage-request_for_information-record--" class="row_$delid">
            <td class="textAlignLeft" id="manage-request_for_information-record--" >$beginWeekDay ,   
            $formattedDelaybdate</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $cattype</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >
            $subact</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--" >$notes</td>
                        
        </tr>

END_DELAYS_TABLE_TBODY;

            
        
        $incre_id++;
}
if($delayTableTbody==''){
    $delayTableTbody="<tr><td colspan='4'>No Data Available for Selected Dates</td></tr>";
}

$htmlContent = <<<END_HTML_CONTENT
<table id="delay_list_container--manage-request_for_information-record" class="content cell-border detailed-weekly" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom">
    <tr ><th class="tablehead-in-week" colspan="4">SCHEDULE DELAYS</th></tr>
        <tr>
        <th class="textAlignLeft">Date</th>
        <th class="textAlignLeft">Category</th>
        <th class="textAlignLeft">Type</th>
        <th class="textAlignLeft">Description</th>

        </tr>
    </thead>
    <tbody class="altColors">
        $delayTableTbody
    </tbody>
</table>

END_HTML_CONTENT;

    

    return $delayTableTbody;
}

//Fetch date wise Sitework Activity Log
function findByProjectIdAndJobsiteDailyLogModifiedSite($database, $project_id, $jobsite_daily_log_created_date,$check_date)
    {
    $db = DBI::getInstance($database);
    $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_daily_sitework_activity_logs` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_sitework_activities` jbta ON jdoal_fk_joa.jobsite_sitework_activity_id = jbta.id WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$jobsite_daily_log_created_date' AND '$check_date' GROUP BY jbta.id";

    
    $db->execute($query);
    $records = array();
    $recordsite = array();
    while($row = $db->fetch())
    {
        // $records[] = $row;
        $records[] = $row['jobsite_sitework_activity_label'];
    }
    $db->free_result();
    if(!empty($records)){
        $recordslabel=implode(',',$records);
    }else{
        $recordslabel='';
    }
    if($recordslabel==null || $recordslabel==''){
        $recordslabel=<<<Table_view_date
No Data Available for Selected Dates
Table_view_date;
    }
    return $recordslabel;
    }
//Fetch date wise Building Activity Log
function findByProjectIdAndJobsiteDailyLogModifiedBuild($database, $project_id, $jobsite_daily_log_created_date,$check_date)
    {
    $db = DBI::getInstance($database);
    $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_daily_building_activity_logs` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_building_activities` jbta ON jdoal_fk_joa.jobsite_building_activity_id = jbta.id WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$jobsite_daily_log_created_date' AND '$check_date' GROUP BY jbta.id";

    
    $db->execute($query);
    $records = array();
    $recordsite = array();
    while($row = $db->fetch())
    {
        // $records[] = $row;
        $records[] = $row['jobsite_building_activity_label'];
    }
    $db->free_result();
    if(!empty($records)){
        $recordslabel=implode(',',$records);
    }else{
        $recordslabel='';
    }
    $db->free_result();
    if($recordslabel==null || $recordslabel==''){
        $recordslabel=<<<Table_view_date
No Data Available for Selected Dates
Table_view_date;
    }
    return $recordslabel;
    }
    //Fetch date wise Inspection Activity Log
function findByProjectIdAndJobsiteDailyLogModifiedInspection($database, $project_id, $jobsite_daily_log_created_date,$check_date)
    {
    $db = DBI::getInstance($database);
    $query ="SELECT jdl.*,jdoal_fk_joa.*,jdty.*,jdtno.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_inspections` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_inspection_types` jdty ON jdty.id = jdoal_fk_joa.jobsite_inspection_type_id INNER JOIN `jobsite_inspection_notes` jdtno ON jdtno.jobsite_inspection_id = jdoal_fk_joa.id WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$jobsite_daily_log_created_date' AND '$check_date'";
    
    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        // $records[] = $row;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $type=$row['jobsite_inspection_type'];
        $desc=$row['jobsite_inspection_note'];
        $passFlag=$row['jobsite_inspection_passed_flag'];
        $htmlInspectionData.=<<<Table_view_date
        <tr>
<td>$day , $date</td>
<td>$type</td>
<td>$desc</td>
<td>$passFlag</td>
</tr>
Table_view_date;
    }
    $db->free_result();
    if($htmlInspectionData==null || $htmlInspectionData==''){
        $htmlInspectionData=<<<Table_view_date
        <tr>
<td colspan="4">No Data Available for Selected Dates</td>
</tr>
Table_view_date;
    }
    return $htmlInspectionData;
    }
    //to get total passed Inspection
    function findByProjectIdInspectionPassed($database, $project_id, $jobsite_daily_log_created_date,$check_date)
    {
    $db = DBI::getInstance($database);
    $query ="SELECT jdl.*,jdoal_fk_joa.*,jdty.*,jdtno.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_inspections` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_inspection_types` jdty ON jdty.id = jdoal_fk_joa.jobsite_inspection_type_id INNER JOIN `jobsite_inspection_notes` jdtno ON jdtno.jobsite_inspection_id = jdoal_fk_joa.id WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$jobsite_daily_log_created_date' AND '$check_date' AND jdoal_fk_joa.`jobsite_inspection_passed_flag` = 'Y' ";
    
    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
       
        $records[] = $row['jobsite_inspection_passed_flag'];
        
        }
        $Inspectioncount=count($records);
        return $Inspectioncount;
    }
    //fetch data's Common for notes (General,deliveries,deliveries,safety,extrawork,swppp,visitors)
    function findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $jobsite_daily_log_created_date,$check_date ,$type_id)
    {
    $db = DBI::getInstance($database);
    $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.jobsite_note_type_id = jbta.id WHERE jdl.`project_id` = $project_id AND jbta.id = $type_id AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$jobsite_daily_log_created_date' AND '$check_date'";

    $db->execute($query);
    $records = array();
    $recordsite = array();
    $htmlInspectionData='';
    while($row = $db->fetch())
    {
        // $records[] = $row;
        $records[] = $row;
        // $date=substr($row['modified'],0,10);
        $date=$row['jobsite_daily_log_created_date'];       
        $date = DateTime::createFromFormat('Y-m-d', $date);
        $date = $date->format('m/d/Y');
        $day = date('l',strtotime($date));
        $desc=$row['jobsite_note'];
        $htmlInspectionData.=<<<Table_view_date
        <tr>
<td>$day , $date</td>
<td>$desc</td>
</tr>
Table_view_date;
    }
    $db->free_result();
    if($htmlInspectionData==null || $htmlInspectionData==''){
        $htmlInspectionData=<<<Table_view_date
        <tr>
<td colspan="2">No Data Available for Selected Dates</td>
</tr>
Table_view_date;
    }
    return $htmlInspectionData;
    }


    
//To get the man power Data Monthly
function buildManpowerSectionMonthly($database, $user_company_id, $project_id,  $new_begindate,$enddate)
{
$maxDays=date('t',strtotime($new_begindate));
$arrayManValue=array();
$arrayManDate=array();
$arrayManComp=array();
$count='1';


$htmlContent = '';
for($inday=0;$inday<$maxDays;$inday++){
     $sub_count='1';
    $datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
    $jobsite_daily_log_id = '';
    $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);
    if ($jobsiteDailyLog) {
       $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    }
    // echo '<br>'.$jobsite_daily_log_id.' - '.$datestep;
    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
    //$arrVendorIds = $arrReturn['vendor_ids'];
    $arrJobsiteManPowerIds = '';
    $arrJobsiteManPowerByJobsiteDailyLogId = '';
    $arrJobsiteManPowerBySubcontractId = '';
    if(isset($arrReturn['jobsite_man_power_ids'])) {
        $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
    }
    if(isset($arrReturn['objects'])) {
        $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
    }
    if(isset($arrReturn['jobsite_man_power_by_subcontract_id'])) {
        $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];
    }

    $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);
    $totalnumber_of_people=0;
    // echo '<pre>';
    // print_r($arrSubcontractsByProjectId);
    foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        /* @var $subcontract Subcontract */
        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        $costCode = $gcBudgetLineItem->getCostCode();
        /* @var $costCode CostCode */

        $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$user_company_id);

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

        //$onchange = "setTimeoutForSaveJobsiteManPower('manage-jobsite_man_power-record', '$uniqueId');";
        $totalnumber_of_people +=$number_of_people;
        $htmlContent .= <<<END_HTML_CONTENT

                <tr>
                    <td>$contact_company_name &mdash; $htmlEntityEscapedFormattedCostCode</td>
                    <td class="columnLight">
                    $number_of_people
                    </td>
                </tr>
END_HTML_CONTENT;
    $WeekDay=date('D', strtotime($datestep));
    $begindate = DateTime::createFromFormat('Y-m-d', $datestep);
    $manDate = $begindate->format('m/d');
     if($number_of_people==0)
    $number_of_people='';
$arrayManComp[$sub_count][0]=$contact_company_name.'-'.$htmlEntityEscapedFormattedCostCode;
$arrayManValue[$sub_count][0]='';
$arrayManValue[$sub_count][$count]=$number_of_people;
$arrayManDate[$count]=$WeekDay.','.$manDate;

$sub_count++;

    }
 $count++;

 }
// echo '<pre>';
// print_r($arrayManValue);
 $array_count=count($arrayManValue);
 $date_count=count($arrayManDate);
 $CheckTableValue=1;
 $valuehtml='<table id="manpower_activity_monthly" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">';
 $valuehtml.='<thead class="borderBottom">';
$valuehtml.='<tr class="table-headerinner">
        <th colspan="'.($date_count+2).'" class="align-left">MANPOWER ACTIVITY </th>
        </tr>';
 
 
$arrayChek=array();
$checkNull='';
foreach($arrayManValue as $index=>$value)
{
    $value=array_filter($arrayManValue[$index]);
    foreach($arrayManValue[$index] as $index1 => $value1)
    {
        $JoinArray='';
        if(isset($arrayChek[$index1])){
            $JoinArray .=$arrayChek[$index1];    
        }        
        $JoinArray .=$arrayManValue[$index][$index1];
        $arrayChek[$index1]=$JoinArray;
        $checkNull .= $arrayManValue[$index][$index1];
    }
}
$counttotalValue = 0;
if($checkNull!=''){
for($datei=1;$datei<=$date_count;$datei++)
{
    if($datei==1)
    $valuehtml.='<tr><th>Company</th>';
    $value_explode=explode(',',$arrayManDate[$datei]);
    $valuehtml.='<th>'.$value_explode[0]."\n".$value_explode[1].'</th>';
    if($datei==$date_count)
    $valuehtml.="<th>MONTH TOTAL</th></tr>";

}
$valuehtml.="</thead>";
$valuehtml.='<tbody class="">';
$weekTotalcol=0;
$colTotal=0;
$coltotalarray=array();
$colcount=1;
for($valuei=1;$valuei<=$array_count;$valuei++){
$valuehtml.="<tr id='month_td'>";
$row_total='';
$valueinarraycount=count($arrayManValue[$valuei]);
for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
    if($invaluei!=0){
        $class="class='center-align'";
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
        if(isset($coltotalarray[$invaluei])) {
            $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
        } else {
            $coltotalarray[$invaluei]=$arrayManValue[$valuei][$invaluei];
        }
        if($arrayManValue[$valuei][$invaluei]!='')
        $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
    }
}
$valuehtml.="<td class='total_bold center-align'>$row_total</td>";
$valuehtml.="</tr>";
$weekTotalcol=$weekTotalcol+$row_total;
$coltotalarray[$invaluei]=$weekTotalcol;
}
$counttotalValue=count($coltotalarray);
$valuehtml.="<tr class='total_bold center-align'>";
for($invaluet=1;$invaluet<=$counttotalValue;$invaluet++){
    if($invaluet==1)
    $valuehtml.="<td>DAY TOTAL</td>";
    if(isset($arrayChek[$invaluet]) && $arrayChek[$invaluet]!='')
        $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
    else{
        if($invaluet==$counttotalValue)
            $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
        else
            $valuehtml.="<td></td>";
    }

}
}
if($counttotalValue==0){
$valuehtml.="<tr><td colspan=".($maxDays+2).">No Manpower Efforts Involved For Selected Dates</td>";
$CheckTableValue=0;
}
$valuehtml.="</tr>";
$valuehtml.="</tbody>";
$valuehtml.='</table><input type="hidden" id="CheckTableValue" name="CheckTableValue" value="'.$CheckTableValue.'">';
    return $valuehtml;


}

function manPowerSummary($database,$user_company_id,$project_id,$start_date){
    // to get the project start date
    $db = DBI::getInstance($database);
    $query ="Select * from projects where id='".$project_id."'";
    $db->execute($query);
    while($row = $db->fetch())
    {
        $start_date_full= $start_date;
        $start_date_arr=explode(' ', $start_date_full);
        $start_date=$start_date_arr[0];
    }

    $date=date("m/d/Y", strtotime($start_date));
   
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
    $htmlContent = <<<END_HTML_CONTENT

<table id="ManPowercount" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom">
        <tr class="table-headerinner">
        <th colspan="2" class="align-left">TOTAL MAN DAYS</th>
        </tr>
        
    </thead>
    <tbody class="altColors">
        <tr><td>Total Man Days (Including $company employees)</td><td>$man_power_count</td></tr>
        <tr><td>Total Man Hours (Days * 8 hrs)</td><td>$man_days</td></tr>
        <tr ><td colspan="2"></td></tr>
        <tr><td>Total Man Days (Excluding $company employees)</td><td>$manPowerExcludingAdvent</td></tr>
        <tr><td>Total Man Hours (Days * 8 hrs)</td><td>$manPowerExcludingAdventDays</td></tr>
    </tbody>
</table>
END_HTML_CONTENT;
return $htmlContent;
}


//to get man Power Excluding advent
function buildManpowerSectionCountExcluding($database, $user_company_id, $project_id, $jobsite_daily_log_id,$company)
{
    
    $arrayManValue=array();
    // $arrayManDate=array();
    
    
    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
    $count='1';
     $adventCompanyManPower=0;
 $otherCompanyManPower=0;
foreach ($jobsite_daily_log_id as $Key =>  $jobsite_daily_log) {
  $jobsite_daily_id=$jobsite_daily_log;
   
$arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);
 $number_of_people = 0;
 $sub_count='1';


    foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        /* @var $subcontract Subcontract */
        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        $costCode = $gcBudgetLineItem->getCostCode();
        /* @var $costCode CostCode */


         $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$user_company_id);

        $vendor = $subcontract->getVendor();
        /* @var $vendor Vendor */

        $vendor_id = $vendor->vendor_id;

        $contactCompany = $vendor->getVendorContactCompany();
        /* @var $contactCompany ContactCompany */

        $contact_company_name = $contactCompany->contact_company_name;
       
        if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {
            $jobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];
            /* @var $jobsiteManPower JobsiteManPower */
            $number_of_people = $jobsiteManPower->number_of_people;
            $uniqueId = $jobsiteManPower->jobsite_man_power_id;

            $attributeGroupName = 'manage-jobsite_man_power-record';
            $onchange = 'Daily_Log__ManPower__updateJobsiteManPower(this);';
        } else {

            $jobsiteManPower = JobsiteManPower::findByJobsiteDailyLogIdAndSubcontractId($database, $jobsite_daily_id, $subcontract_id);
            /* @var $jobsiteManPower JobsiteManPower */

            if ($jobsiteManPower) {
                $number_of_people = $jobsiteManPower->number_of_people;
                $uniqueId = $jobsiteManPower->jobsite_man_power_id;
            } else {
                $number_of_people = 0;
                $uniqueId = $jobsite_daily_id.'-'.$subcontract_id;
            }

            $attributeGroupName = 'create-jobsite_man_power-record';
            $onchange = "Daily_Log__ManPower__createJobsiteManPower('$attributeGroupName', '$uniqueId');";
        }
         if($company==$contact_company_name)
        {
            $adventCompanyManPower=$adventCompanyManPower+$number_of_people;
            
        }else
        {
            $otherCompanyManPower=$otherCompanyManPower+$number_of_people;
            
        }
    $id_val=$count.'_'.$sub_count;
    $arrayManValue[$sub_count][0]=$contact_company_name.'-'.$htmlEntityEscapedFormattedCostCode;
    $arrayManValue[$sub_count][$count]=$number_of_people;
    $sub_count++;

    }


    $count++;

// echo "<br>adventCompanyManPower  : ".$adventCompanyManPower;
// echo "<br>otherCompanyManPower  : ".$otherCompanyManPower;
}//Subcontract End
 $array_count=count($arrayManValue);
 $valuehtml='<table id="manpower_activity" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">';
 $valuehtml.='<thead class="borderBottom">';

 $valuehtml.='<tr><th>Company</th>';
 
 

 $valuehtml.="<th>WEEK TOTAL</th></tr></thead>";
$valuehtml.='<tbody class="altColors">';
$weekTotalcol=0;
$colTotal=0;
$coltotalarray=array();
$colcount=1;
for($valuei=1;$valuei<=$array_count;$valuei++){
$valuehtml.="<tr>";
$row_total=0;
$valueinarraycount=count($arrayManValue[$valuei]);
for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
    if($invaluei!=0){
        $class="class='center-align'";
    }else{
        $class="class='align-left'";
    }
$valuehtml.="<td $class>".$arrayManValue[$valuei][$invaluei]."</td>";
    if($invaluei!=0){
        if(isset($coltotalarray[$invaluei])) {
            $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
        } else {
            $coltotalarray[$invaluei]=$arrayManValue[$valuei][$invaluei];
        }
        $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
    }
}
$valuehtml.="<td class='total_bold center-align'>$row_total</td>";
$valuehtml.="</tr>";
$weekTotalcol=$weekTotalcol+$row_total;
$coltotalarray[$invaluei]=$weekTotalcol;
}

$counttotalValue=count($coltotalarray);

$valuehtml.="<tr class='total_bold center-align'><td>DAY TOTAL</td>";
for($invaluet=1;$invaluet<=$counttotalValue;$invaluet++){
$valuehtml.="<td>$coltotalarray[$invaluet]</td>";
}
$valuehtml.="</tr>";
$valuehtml.="</tbody>";
$valuehtml.="</table>";
$arrayRet=array('adventCompanyManPower'=>$adventCompanyManPower,'otherCompanyManPower'=>$otherCompanyManPower,'TotalManPower'=>$coltotalarray[$counttotalValue]);
    return $arrayRet;
}

// to get all the data's for weekly job
function WeeklyJob($database, $project_id, $startDate, $endDate, $user_company_id)
{
$man_power=buildManpowerWeeklyJob($database, $user_company_id, $project_id, $startDate);
    // To get the all date between the specified dates
$begin=new DateTime($startDate);
$end=new DateTime($endDate);
$end = $end->modify( '+1 day' ); 

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$days = '';
$amTemperatures = '';
$amConditions = '';
$pmTemperatures = '';
$pmConditions = '';
foreach ( $period as $dt )
{

    $display_date = $dt->format("m/d/Y");
    $created_date = $dt->format("Y-m-d");
     $WeekDay=date('l', strtotime($created_date));

    $arrReturn = getAmPmWeatherTemperaturesAndConditions($database, $project_id, $created_date);
    $amTemperature = $arrReturn['amTemperature'];
    $amCondition   = $arrReturn['amCondition'];
    $pmTemperature = $arrReturn['pmTemperature'];
    $pmCondition   = $arrReturn['pmCondition'];
    
    $days.=<<<Days_View
    <th align="left" class="align-left">$WeekDay\n$display_date</th>
Days_View;
    $amTemperatures.=<<<amTemperature
    <td>$amTemperature</td>
amTemperature;
$amConditions.=<<<amCondition
    <td>$amCondition</td>
amCondition;
$pmTemperatures.=<<<pmTemperature
    <td>$pmTemperature</td>
pmTemperature;
$pmConditions.=<<<pmCondition
    <td>$pmCondition</td>
pmCondition;
}
//get the data's from table for Man Power 
$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdForJobsiteDailyLogDate($database, $project_id, $startDate, $endDate);
$jobsiteDailyDate = JobsiteDailyLog::findByProjectIdForJobsiteDailyDateValues($database, $project_id, $startDate, $endDate);

$weekTotal=$man_power;// echo "man ".$man_power;
// $dayList=$man_power['dayList'];// echo "man ".$man_power;
$CostCode=CostCodeData($database, $user_company_id, $project_id, $startDate, $endDate);


$weather=<<<CONDITION_TEMP
    <tr><td rowspan="2">AM Temp / Condition</td>$amTemperatures</tr>
    <tr>$amConditions</tr>
    <tr><td rowspan="2">PM Temp / Condition</td>$pmTemperatures</tr>
    <tr>$pmConditions</tr>
    $weekTotal
CONDITION_TEMP;

$Inspection=TotalManPowerAndInspection($database, $project_id, $startDate, $endDate);
$manPowerWholeWeek=$Inspection['manpowerActivityThisWeek'];
$InspectionWholeWeek=$Inspection['numInspectionsThisWeek'];

//get the data's from table for sitework section
$jobsiteDailyLog = findByProjectIdAndJobsiteDailyLogModifiedSite($database, $project_id, $startDate, $endDate);
//Sitework activity table data
$siteworkact_job=<<<SITEWORKACT_TABLE_DATA
<tr>
<td class="con_jus">$jobsiteDailyLog</td>
</tr>
SITEWORKACT_TABLE_DATA;
//get the data's from table for building section
$jobsiteDailyBuild = findByProjectIdAndJobsiteDailyLogModifiedBuild($database, $project_id, $startDate, $endDate);
//BUILDING activity table data
$buildingact=<<<BUILDINGACT_TABLE_DATA
<tr>
<td class="con_jus">$jobsiteDailyBuild</td>
</tr>
BUILDINGACT_TABLE_DATA;
//get the data's from table for Other Notes section
$othernotes=findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $startDate, $endDate, '1');
//to get the Rfi Data
$RfiResponseData=RfiListViewWithResponse($database, $project_id,$startDate, $endDate);

$htmlContent = <<<END_HTML_CONTENT
<table id="weather" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="8" class="align-left">DALIY WEATHER AND MANPOWER</td>
        </tr>
        <tr>
        <td width="20%"></td>
        $days
        </tr>
    <tbody >
        $weather
    </tbody>
</table>
<table id="ManPowerandInspection" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="2" class="align-left">WEEK'S ACTIVITY </td>
        </tr>
        
    <tbody class="altColors">
    <tr><td class='align-left'>TOTAL MANPOWER</td><td>$manPowerWholeWeek</td></tr>
    <tr><td class='align-left'>PASSED INSPECTIONS</td><td>$InspectionWholeWeek</td></tr>
    </tbody>
</table>
$CostCode
<table id="sitework" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td class="align-left">SITEWORK</td>
        </tr>
    <tbody class="altColors">
        $siteworkact_job
    </tbody>
</table>
<table id="building_activity" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="1" class="align-left">BUILDING ACTIVITY </td>
        </tr>
        <tr>
        <td colspan="1" class="align-left">ACTIVITY </td>
        </tr>
    <tbody class="altColors">
        $buildingact
    </tbody>
</table>
<table id="other_notes" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
        <tr class="table-headerinner">
        <td colspan="2" class="align-left">OTHER NOTES </td>
        </tr>
        <tr >
        <td class="align-left" width="30%">DATE</td>
        <td class="align-left">NOTE</td>
        </tr>
    <tbody class="altColors">
        $othernotes
    </tbody>
</table>
$RfiResponseData
END_HTML_CONTENT;
return $htmlContent;

}
function buildManpowerWeeklyJob($database, $user_company_id, $project_id,$new_begindate)
{


$maxDays=7;
$arrayManValue=array();
$arrayManDate=array();
$arrayManComp=array();
$count='1';
$htmlContent = '';

for($inday=0;$inday<$maxDays;$inday++){
     $sub_count='1';
    $datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
    $jobsite_daily_log_id = '';
    $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);
    if ($jobsiteDailyLog) {
       $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    }
    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
    //$arrVendorIds = $arrReturn['vendor_ids'];
    $arrJobsiteManPowerIds = '';
    $arrJobsiteManPowerByJobsiteDailyLogId = '';
    $arrJobsiteManPowerBySubcontractId = '';
    if(isset($arrReturn['jobsite_man_power_ids'])) {
        $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
    }
    if(isset($arrReturn['objects'])) {
        $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
    }
    if(isset($arrReturn['jobsite_man_power_by_subcontract_id'])) {
        $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];
    }

    $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);
    $totalnumber_of_people=0;
    // echo '<pre>';
    // print_r($arrSubcontractsByProjectId);
    foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        /* @var $subcontract Subcontract */

        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        $costCode = $gcBudgetLineItem->getCostCode();
        /* @var $costCode CostCode */

        $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$user_company_id);

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
 
        //$onchange = "setTimeoutForSaveJobsiteManPower('manage-jobsite_man_power-record', '$uniqueId');";
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

 }
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
        if(isset($arrayChek[$index1])){
            $JoinArray .=$arrayChek[$index1];    
        }        
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
$row_total=0;
$valueinarraycount=count($arrayManValue[$valuei]);
for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
    if($invaluei!=0){
        if(isset($coltotalarray[$invaluei])) {
            $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
        } else {
            $coltotalarray[$invaluei]=$arrayManValue[$valuei][$invaluei];
        }
        $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
    }
}
$weekTotalcol=$weekTotalcol+$row_total;
$coltotalarray[$invaluei]=$weekTotalcol;
}
$counttotalValue=count($coltotalarray);
$valuehtml="<tr class='total_bold center-align'>";
for($invaluet=1;$invaluet<$counttotalValue;$invaluet++){
    if($invaluet==1)
    $valuehtml.="<td class='align-left'>DAY TOTAL</td>";
        $valuehtml.="<td class='align-left'>$coltotalarray[$invaluet]</td>";
  

}

$valuehtml.="</tr>";
return $valuehtml;


}
//Get the Contract log for project list
function CostCodeData($database, $user_company_id, $project_id, $startDate, $endDate)
{
    $loadGcBudgetLineItemsByProjectIdOptions = new Input();
    $loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
    $arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdReport($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions);
    $gcBudgetLineItemsTbody='';
    $loopCounter=1;
    // echo "<pre>";
    // print_r($arrGcBudgetLineItemsByProjectId);
foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
        /* @var $gcBudgetLineItem GcBudgetLineItem */

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
        $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
        $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
        $arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemIdWithDate($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions, $startDate, $endDate, true);
        
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
        $formattedSubcontractMailedDate='';
        $formattedSubcontractTargetExecutionDate='';
        // subcontract_mailed_date
            $arrSubcontractMailedDateHtmlInputs=array();
            $arrSubcontractTargetExecutionDateHtmlInputs=array();
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
            $tmpSubcontractTargetExecutionDateHtmlInput = '';
            $tmpSubcontractMailedDateHtmlInput = '';
            // Subcontract Actual Value list
            $subcontract_actual_value_raw += $tmp_subcontract_actual_value;
            $subcontract_actual_value += $tmp_subcontract_actual_value;
            $formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
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
            $formattedSubcontractMailedDate = $subcontract->deriveFormattedSubcontractMailedDate();
            $formattedSubcontractTargetExecutionDate = $subcontract->deriveFormattedSubcontractExecutionDate();
            if ($subcontractCount == 1) {
                if($formattedSubcontractTargetExecutionDate!='' && $formattedSubcontractTargetExecutionDate!=null){
                $tmpSubcontractTargetExecutionDateHtmlInput = <<<END_HTML_CONTENT

                <span id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="datepicker" value="$formattedSubcontractTargetExecutionDate" style="margin-top: 1px; text-align: center; width:80px;">$formattedSubcontractTargetExecutionDate</span>
END_HTML_CONTENT;
                }
                if($formattedSubcontractMailedDate!='' && $formattedSubcontractMailedDate!=null){
$tmpSubcontractMailedDateHtmlInput = <<<END_HTML_CONTENT

                <span id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="datepicker" value="$formattedSubcontractMailedDate" style="margin-top: 1px; text-align: center; width:80px;">$formattedSubcontractMailedDate</span>
END_HTML_CONTENT;
                }
            } elseif ($subcontractCount > 1) {
                if($formattedSubcontractTargetExecutionDate!='' && $formattedSubcontractTargetExecutionDate!=null){
                $tmpSubcontractTargetExecutionDateHtmlInput = <<<END_HTML_CONTENT
                <div class="textAlignLeft">
                    <span id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="datepicker" value="$formattedSubcontractTargetExecutionDate" style="margin-top: 1px; text-align: center; width:80px;"><span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$formattedSubcontractTargetExecutionDate</span>
                </div>
END_HTML_CONTENT;
                }
                if($formattedSubcontractMailedDate!='' && $formattedSubcontractMailedDate!=null){
 $tmpSubcontractMailedDateHtmlInput = <<<END_HTML_CONTENT

                <div class="textAlignLeft">
                    <span id="manage-subcontract-record--subcontracts--subcontract_target_execution_date--$tmp_subcontract_id" class="datepicker" value="$formattedSubcontractMailedDate" style="margin-top: 1px; text-align: center; width:80px;"><span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$formattedSubcontractMailedDate</span>
                </div>
END_HTML_CONTENT;
                }
            }
            
            $arrSubcontractTargetExecutionDateHtmlInputs[] = $tmpSubcontractTargetExecutionDateHtmlInput;
            $arrSubcontractMailedDateHtmlInputs[]=$tmpSubcontractMailedDateHtmlInput;
            // @todo...this parts
            // Foreign key objects
        }
        // subcontract_target_execution_date
        $subcontractTargetExecutionDateHtmlInputs = join('', $arrSubcontractTargetExecutionDateHtmlInputs);
        $subcontractMailedDateHtmlInputs = join('', $arrSubcontractMailedDateHtmlInputs);

        $invitedBiddersCount = 0;
        $activeBiddersCount = 0;

        $cost_code_id = $costCode->cost_code_id;
        if ($loopCounter%2) {
            $rowStyle = 'oddRow';
        } else {
            $rowStyle = 'evenRow';
        }


    if($subcontractMailedDateHtmlInputs!='' || $subcontractTargetExecutionDateHtmlInputs!='')
        $gcBudgetLineItemsTbody.=<<<END_GC_BUDGET_LINE_ITEMS_TBODY
        <tr id="record_container--manage-request_for_information-record--" class="$rowStyle">
        <td class="textAlignLeft">$costCodeDivision->escaped_division_number-$costCode->escaped_cost_code</td>
        <td class="textAlignLeft">$costCode->escaped_cost_code_description</td>
        <td class="textAlignLeft">$subcontractMailedDateHtmlInputs</td>
        <td class="textAlignLeft">$subcontractTargetExecutionDateHtmlInputs</td>
        </tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
        $loopCounter++;
    
    }
if($gcBudgetLineItemsTbody==null)
    $gcBudgetLineItemsTbody = "<tr><td colspan='4'>No Data Available for Selected Dates</td></tr>";

    $htmlContent = <<<END_HTML_CONTENT
<table id="sdelay_list_container--manage-request_for_information-record" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">
    <tr class="table-headerinner"><th colspan="4" class='align-left'>CONTRACT STATUS</th></tr>
        <tr>
        <th class="textAlignLeft">Code</th>
        <th class="textAlignLeft">Cost Name</th>
        <th class="textAlignLeft">Mailed Date</th>
        <th class="textAlignLeft">Execution Date</th>
        </tr>
    <tbody class="altColors">
        $gcBudgetLineItemsTbody
    </tbody>
</table>

END_HTML_CONTENT;
return $htmlContent;
}

// To get the man power activity
function TotalManPowerAndInspection($database,$project_id,$new_begindate,$jobsite_daily_log_End_date)
{
    // echo "jobsite_daily_log_End_date ".$jobsite_daily_log_End_date;
    // Manpower - this week.
    $jdlCreatedUnixTimestamp = strtotime($jobsite_daily_log_End_date);
    $dayOfWeek = date('N', $jdlCreatedUnixTimestamp);  // This format returns 1 for Monday, 2 for Tuesday, etc.

    $manpowerActivityThisWeek = 0;
    $format = 'Y-m-d';
    $interval = 0;
    $loadJobsiteManPowerByJobsiteDailyLogIdOptions = new Input();
    $loadJobsiteManPowerByJobsiteDailyLogIdOptions->forceLoadFlag = true;
    $tmpDayOfWeek = $dayOfWeek;
    while ($tmpDayOfWeek > 0) {
        $tmp_jobsite_daily_log_created_date = date($format, $jdlCreatedUnixTimestamp - $interval);
        $tmpJobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $tmp_jobsite_daily_log_created_date);
        /* @var $tmpJobsiteDailyLog JobsiteDailyLog */

        if ($tmpJobsiteDailyLog) {
            $temp_jobsite_daily_log_id = $tmpJobsiteDailyLog->jobsite_daily_log_id;
            $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $temp_jobsite_daily_log_id, $loadJobsiteManPowerByJobsiteDailyLogIdOptions);
            $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
            foreach ($arrJobsiteManPowerByJobsiteDailyLogId as $tmpJobsiteManPower) {
                /* @var $tmpJobsiteManPower JobsiteManPower */
                $number_of_people = $tmpJobsiteManPower->number_of_people;
                $manpowerActivityThisWeek = $manpowerActivityThisWeek + $number_of_people;
            }
        }

        // 60 * 60 * 24 = 86400 (1 day in seconds)
        $interval = $interval + 86400;
        $tmpDayOfWeek--;
    }
   
    //get the data's from table for inspection section
$jobsiteDailyInspect = findByProjectIdInspectionPassed($database, $project_id, $new_begindate, $jobsite_daily_log_End_date);
    
    $retRes=array('manpowerActivityThisWeek'=>$manpowerActivityThisWeek,'numInspectionsThisWeek'=>$jobsiteDailyInspect);
  
    return $retRes;
}
// to get RFi Data
function RfiListViewWithResponse($database, $project_id,$new_begindate, $enddate)
{
    $loadRequestsForInformationByProjectIdOptions = new Input();
    $loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;

    $arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByDate($database, $project_id, $loadRequestsForInformationByProjectIdOptions,$new_begindate, $enddate);

    $rfiTableTbody = '';
    $GetCount=count($arrRequestsForInformation);
    if($GetCount == '0')
    {
        $rfiTableTbody="<tr><td colspan='8'>No Data Available for Selected Dates</td></tr>";
    }
    foreach ($arrRequestsForInformation as $request_for_information_id => $requestForInformation) {
        /* @var $requestForInformation RequestForInformation */

        $project = $requestForInformation->getProject();
        /* @var $project Project */

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

        $formattedRfiCreatedDate = date("m/d/Y ", $openDateUnixTimestamp);
        // To get the Rfi Due Date
        // echo "rfi_due_date : ".$rfi_due_date;
        $formattedRfiDueDate='';
        if(!empty($rfi_due_date))
        {
           
        $dueDateUnixTimestamp = strtotime($rfi_due_date);
        $formattedRfiDueDate = date("m/d/Y ", $dueDateUnixTimestamp);
    }else
    {
        $formattedRfiDueDate = '';
    }
        

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
        if (($daysOpen == 0) || ($daysOpen == '-0')) {
            $daysOpen = 0;
        }
        $countDays=strlen($daysOpen);
        if($countDays=='1')
        {
            $daysOpen='00'.$daysOpen;
        }else if($countDays=='2')
        {
            $daysOpen='0'.$daysOpen;
        }
        
        //to get the response Date 
        $db = DBI::getInstance($database);
                $query_res = "SELECT * FROM request_for_information_responses where request_for_information_id = $request_for_information_id limit 1";
                $db->execute($query_res);
                $ResponseDate ='';
                 while($row = $db->fetch())
                {
                     $ResponseDateUnixTimestamp = strtotime($row['modified']);
                     $formattedRfiResponseDate = date("m/d/Y ", $ResponseDateUnixTimestamp);
                    $ResponseDate = $formattedRfiResponseDate;
                }      
           
    
if($request_for_information_status_id=='2') //To get the open RFI
{
   
        $rfiTableTbody .= <<<END_RFI_TABLE_TBODY

        <tr id="record_container--manage-request_for_information-record--requests_for_information--$request_for_information_id" >
            <td class="textAlignCenter" id="manage-request_for_information-record--requests_for_information--rfi_sequence_number--$request_for_information_id">$rfi_sequence_number</td>
            <td class="textAlignLeft" id="manage-request_for_information-record--requests_for_information--rfi_title--$request_for_information_id" >$escaped_rfi_title</td>
           
            <td class="textAlignLeft" id="manage-request_for_information-record--requests_for_information--rfi_created--$request_for_information_id">$formattedRfiCreatedDate</td>
              <td class="textAlignLeft" id="manage-request_for_information-record--requests_for_information--rfi_created--$request_for_information_id">$formattedRfiDueDate</td>
               <td class="textAlignLeft" id="manage-request_for_information-record--requests_for_information--rfi_Response--$request_for_information_id">$ResponseDate</td>
            
            <td class="textAlignLeft" id="manage-request_for_information-record--requests_for_information--recipientFullName--$request_for_information_id">$rfiRecipientContactFullNameHtmlEscaped<input type="hidden" id="manage-request_for_information-record--requests_for_information--rfi_recipient_contact_id--$request_for_information_id" value="$rfi_recipient_contact_id"></td>
            <td class="textAlignLeft" id="manage-request_for_information-record--requests_for_information--request_for_information_priority--$request_for_information_id">$request_for_information_priority<input type="hidden" id="manage-request_for_information-record--requests_for_information--request_for_information_priority_id--$request_for_information_id" value="$request_for_information_priority_id"></td>
            <td class="textAlignCenter" id="manage-request_for_information-record--requests_for_information--daysOpen--$request_for_information_id">$daysOpen</td>
        </tr>

END_RFI_TABLE_TBODY;
}
    }

    $htmlContent = <<<END_HTML_CONTENT

<table id="record_list_container--manage-request_for_information-record" class="detailed_week content" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom ">
    <tr class="table-headerinner"><td colspan='8' class='align-left'>OPEN REQUESTS FOR INFORMATION</td></tr>
        <tr>
        <th class="textAlignCenter">RFI #</th>
        <th class="textAlignLeft">Description</th>
        <th class="textAlignLeft">Open</th>
        <th class="textAlignLeft">Due By</th>
        <th class="textAlignLeft">Response</th>
        <th class="textAlignLeft">Recipient</th>
        <th class="textAlignLeft">Priority</th>
        <th class="textAlignCenter">Days Open</th>
        </tr>
    </thead>
    <tbody class="altColors">
        $rfiTableTbody
    </tbody>
</table>

END_HTML_CONTENT;

    return $htmlContent;
}
 //Get the RFI data All
function RFIReportbyID($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $typepost, $cost_code_division_id_filter=null, $statusTypeId){
    $whereStatusCause = '';
    $whereFlag = false;
    if ($statusTypeId != null && $statusTypeId !='') {
        $whereStatusCause = ' AND rfi.`request_for_information_status_id` = '.$statusTypeId;
        $whereFlag = true;
    }
    $loadRequestsForInformationByProjectIdOptions = new Input();
    $loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
    $loadRequestsForInformationByProjectIdOptions->whereFlag = $whereFlag;
    $loadRequestsForInformationByProjectIdOptions->whereStatusCause = $whereStatusCause;
    $arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByProjectIdReport($database, $project_id, $loadRequestsForInformationByProjectIdOptions,$new_begindate, $enddate, $typepost);
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
       

         // start of days calculation

        $rficlosedLog = RequestForInformationStatus::getClosedDateDetails($database,$request_for_information_id);
        $rfiopenarr = $rficlosedLog['open'];
        $rficlosedarr = $rficlosedLog['closed'];

        $openingdate = explode(' ', $rfi_created);
        // adding the open date
        array_unshift($rfiopenarr , $openingdate[0]);
        $daysOpen =0;
        if(!empty($rficlosedLog))
        {

        foreach ($rfiopenarr as $key => $cdate) {
            $date1=date_create($cdate);
            $date2=date_create($rficlosedarr[$key]);
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

         if($rfi_closed_date!='')
        $formattedRficlosedDate = date("m/d/Y", strtotime($rfi_closed_date));
        else
        $formattedRficlosedDate ='';

        // request_for_information_statuses:
        // 1 - Draft
        // 2 - Open
        // 3 - In Progress
        // 4 - Closed

        $request_for_information_status = $requestForInformationStatus->request_for_information_status;
        
         // start of days calculation

        $rficlosedLog = RequestForInformationStatus::getClosedDateDetails($database,$request_for_information_id);
        $rfiopenarr = $rficlosedLog['open'];
        $rficlosedarr = $rficlosedLog['closed'];

        $openingdate = explode(' ', $rfi_created);
        // adding the open date
        array_unshift($rfiopenarr , $openingdate[0]);
        $daysOpen =0;
        if(!empty($rficlosedLog))
        {

        foreach ($rfiopenarr as $key => $cdate) {
            $date1=date_create($cdate);
            $date2=date_create($rficlosedarr[$key]);
            $diff=date_diff($date1,$date2);
            $diff3= $diff->format("%a");
            $daysOpen =$daysOpen + intval($diff3);
        }
        }
        // End of days calculation
        // There was an instance of $daysOpen showing as "-0"
        if (($daysOpen == 0) || ($daysOpen < 1)) {
            $daysOpen = 0;
        }
        $daysOpen = str_pad($daysOpen, $strlen, 0, STR_PAD_LEFT);
        $rfiTableTbody .= <<<END_RFI_TABLE_TBODY

        <tr>
            <td class="textAlignCenter">$rfi_sequence_number</td>
            <td class="align-left">$escaped_rfi_title</td>
            <td class="align-left">$formattedRfiCreatedDate</td>
            <td class="align-left">$formattedRfiResponseDate</td>
            <td class="align-left">$rfiRecipientContactFullNameHtmlEscaped</td>
            <td class="align-left">$request_for_information_priority</td>
            <td class="align-left">$formattedRficlosedDate</td>
            <td class="align-left" >$request_for_information_status</td>
            <td class="textAlignCenter">$daysOpen</td>
        </tr>

END_RFI_TABLE_TBODY;
$index++;
    }
    if($rfiTableTbody=='')
        $rfiTableTbody="<tr><td colspan='9'>No Data Available for Selected Dates</td></tr>";
    $htmlContent = <<<END_HTML_CONTENT

<table id="RFiReportbyID" class="tableborder content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom">
    <tr class="table-headerinner">
            <th colspan="9" class="textAlignLeft">Request For Information</th>
            </tr>
        <tr>
        <th class="textAlignCenter">RFI #</th>
        <th class="align-left">Description</th>
        <th class="align-left">Open Date</th>
        <th class="align-left">Response Date</th>
        <th class="align-left">Recipient</th>
        <th class="align-left">Priority</th>
        <th class="align-left">Closed Date</th>
        <th class="align-left">Status</th>
        <th class="textAlignCenter">Days Open</th>
        </tr>
    </thead>
    <tbody class="altColors">
        $rfiTableTbody
    </tbody>
</table>
END_HTML_CONTENT;

    return $htmlContent;
}
//Get the RFI data Question & Answer
function RFIReportQA($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $typepost, $cost_code_division_id_filter=null, $statusTypeId){

    $whereStatusCause = '';
    $whereFlag = false;
    if ($statusTypeId != null && $statusTypeId !='') {
        $whereStatusCause = ' AND rfi.`request_for_information_status_id` = '.$statusTypeId;
        $whereFlag = true;
    }
    $loadRequestsForInformationByProjectIdOptions = new Input();
    $loadRequestsForInformationByProjectIdOptions->whereFlag = $whereFlag;
    $loadRequestsForInformationByProjectIdOptions->whereStatusCause = $whereStatusCause;
    $loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
    $arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByProjectIdReport($database, $project_id, $loadRequestsForInformationByProjectIdOptions,$new_begindate, $enddate, $typepost);
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
       
        // start of days calculation

        $rficlosedLog = RequestForInformationStatus::getClosedDateDetails($database,$request_for_information_id);
        $rfiopenarr = $rficlosedLog['open'];
        $rficlosedarr = $rficlosedLog['closed'];

        $openingdate = explode(' ', $rfi_created);
        // adding the open date
        array_unshift($rfiopenarr , $openingdate[0]);
        $daysOpen =0;
        if(!empty($rficlosedLog))
        {

        foreach ($rfiopenarr as $key => $cdate) {
            $date1=date_create($cdate);
            $date2=date_create($rficlosedarr[$key]);
            $diff=date_diff($date1,$date2);
            $diff3= $diff->format("%a");
            $daysOpen =$daysOpen + intval($diff3);
        }
        }
        // End of days calculation

        // There was an instance of $daysOpen showing as "-0"
        if (($daysOpen == 0) || ($daysOpen < 1)) {
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
    $rfidArray = array();
    $dateArray = array();
    $checkid = 0;
    foreach ($arrRequestsForInformation as $request_for_information_id => $requestForInformation) {/* @var $requestForInformation RequestForInformation */
        $request_for_information_id=$requestForInformation->request_for_information_id;

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

      if($rfi_closed_date!='')
        $formattedRficlosedDate = date("m/d/Y", strtotime($rfi_closed_date));
        else
        $formattedRficlosedDate =''; 

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
       
         // start of days calculation

        $rficlosedLog = RequestForInformationStatus::getClosedDateDetails($database,$request_for_information_id);
        $rfiopenarr = $rficlosedLog['open'];
        $rficlosedarr = $rficlosedLog['closed'];

        $openingdate = explode(' ', $rfi_created);
        // adding the open date
        array_unshift($rfiopenarr , $openingdate[0]);
        $daysOpen =0;
        if(!empty($rficlosedLog))
        {

        foreach ($rfiopenarr as $key => $cdate) {
            $date1=date_create($cdate);
            $date2=date_create($rficlosedarr[$key]);
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
        $daysOpen = str_pad($daysOpen, $strlen, 0, STR_PAD_LEFT);
        $rfidArray[$checkid] = $request_for_information_id;
        $dateArray[$checkid] = $formattedRfiResponseDate;
        $formattedRfiResponseDate = mb_convert_encoding($formattedRfiResponseDate, "HTML-ENTITIES", "UTF-8");
        $rfi_statement = mb_convert_encoding($rfi_statement, "HTML-ENTITIES", "UTF-8");
        if($checkid==0){
        $rfiTableTbody .= <<<END_RFI_TABLE_TBODY
        <tr class="backwhite">
            <td class="textAlignCenter marginTopborder">$rfi_sequence_number</td>
            <td class="align-left marginTopborder">$escaped_rfi_title</td>
            <td class="align-left marginTopborder">$formattedRfiCreatedDate</td>
            <td class="align-left marginTopborder">$rfiRecipientContactFullNameHtmlEscaped</td>
            <td class="align-left marginTopborder">$request_for_information_priority</td>            
            <td class="align-left marginTopborder">$formattedRficlosedDate</td>
            <td class="align-left marginTopborder" >$request_for_information_status</td>
            <td class="align-left marginTopborder">$daysOpen</td>
        </tr>
        <tr><td></td><td colspan="3" class="align-left bold" style="padding-bottom:20px;"><u>Question</u></td><td class="align-left bold" colspan="3"><u>Answer</u></td></tr>
        <tr><td></td><td colspan="3" class="text-justify">$rfi_statement</td><td colspan="3" class="text-justify">
END_RFI_TABLE_TBODY;
if($formattedRfiResponseDate!='')
        $rfiTableTbody.=<<<response_text
        <span class="bold">Response Date : $formattedRfiResponseDate</span> <br>
        $response_text
response_text;
}
             if(isset($rfidArray[$checkid-1]) && $request_for_information_id == $rfidArray[$checkid-1] ){
                if($dateArray[$checkid-1] == $formattedRfiResponseDate){
                    $rfiTableTbody .= <<<END_RFI_TABLE_TBODY
                    \n<br> $response_text
END_RFI_TABLE_TBODY;
                }else{
                    if($formattedRfiResponseDate!='')
                     $rfiTableTbody .= <<<END_RFI_TABLE_TBODY
                     <br><br><span class="bold">Response Date : $formattedRfiResponseDate</span> <br> $response_text
END_RFI_TABLE_TBODY;
                }

             }else{
                if($checkid!=0){
        $rfiTableTbody .= <<<END_RFI_TABLE_TBODY
        </td></tr><tr class="backwhite">
            <td class="textAlignCenter marginTopborder">$rfi_sequence_number</td>
            <td class="align-left marginTopborder">$escaped_rfi_title</td>
            <td class="align-left marginTopborder">$formattedRfiCreatedDate</td>
            <td class="align-left marginTopborder">$rfiRecipientContactFullNameHtmlEscaped</td>
            <td class="align-left marginTopborder">$request_for_information_priority</td>
            <td class="align-left marginTopborder">$formattedRficlosedDate</td>
            <td class="align-left marginTopborder" >$request_for_information_status</td>
            <td class="align-left marginTopborder">$daysOpen</td>
        </tr>
        <tr><td></td><td colspan="3" class="align-left bold" style="padding-bottom:20px;"><u>Question</u></td><td class="align-left bold" colspan="3"><u>Answer</u></td></tr>
        <tr><td></td><td colspan="3" class="text-justify">$rfi_statement</td><td colspan="3" class="text-justify">
END_RFI_TABLE_TBODY;
 if($formattedRfiResponseDate!='')
 $rfiTableTbody .= <<<END_RFI_TABLE_TBODY
                     <span class="bold">Response Date : $formattedRfiResponseDate</span> <br> $response_text
END_RFI_TABLE_TBODY;
             }
             }

       
$index++;
$checkid++;
    }
    if($rfiTableTbody=='')
        $rfiTableTbody="<tr><td colspan='8'>No Data Available for Selected Dates</td></tr>";

  $rfiTableTbody = mb_convert_encoding($rfiTableTbody, "HTML-ENTITIES", "UTF-8");

    $htmlContent = <<<END_HTML_CONTENT
<table id="RFiReportQA" class="tableborder content cell-border"  cellpadding="5" cellspacing="0" width="100%" border="0">
    <thead class="borderBottom">
    <tr class="table-headerinner">
            <th colspan="8" class="textAlignLeft">Request For Information</th>
            </tr>
        <tr>
        <th class="textAlignCenter" width="10%" style="padding-bottom:20px;">RFI #</th>
        <th class="align-left" width="15%" style="padding-bottom:20px;">Description</th>
        <th class="align-left" width="5%" style="padding-bottom:20px;">Open Date</th>
        <th class="align-left" width="20%" style="padding-bottom:20px;">Recipient</th>
        <th class="align-left" width="15%" style="padding-bottom:20px;">Priority</th>
         <th class="align-left" width="15%" style="padding-bottom:20px;">Completed Date</th>
        <th class="align-left" width="15%" style="padding-bottom:20px;">Status</th>
        <th class="align-left" width="15%" style="padding-bottom:20px;">Days Open</th>
        </tr>
    </thead>
    <tbody class="">
        $rfiTableTbody
    </tbody>
</table>
END_HTML_CONTENT;

    return $htmlContent;
}
//Method To get the Submittal by Id
function SubmittalLog($database, $project_id,$new_begindate,$enddate, $user_company_id, $filter_status )
{
    $SubmittalsData=renderSuListView($database, $project_id,$new_begindate,$enddate, '', $user_company_id, $filter_status);
   $htmlContent = <<<END_HTML_CONTENT
   $SubmittalsData
END_HTML_CONTENT;
return $htmlContent;
}
//Method To get the Submittal by notes
function SubmittalLogNotes($database, $project_id, $new_begindate, $enddate, $user_company_id, $filter_status )
{
    $SubmittalsData=renderSuListViewNotes($database, $project_id,$new_begindate,$enddate, $user_company_id, $filter_status);
   $htmlContent = <<<END_HTML_CONTENT
   $SubmittalsData
END_HTML_CONTENT;
return $htmlContent;
}
//Method To get the Submittal by status
function SubmittalLogStatus($database, $project_id, $new_begindate, $enddate, $user_company_id, $filter_status )
{
    $stateSubmittalsData=renderSuListViewStatus($database, $project_id,$new_begindate,$enddate, $user_company_id, $filter_status);
   $htmlContent = <<<END_HTML_CONTENT
   $stateSubmittalsData
END_HTML_CONTENT;
return $htmlContent;
}
//Method To get the Submittal by Cost Code
function SubmittalLogCostCode($database, $project_id, $new_begindate, $enddate, $user_company_id, $filter_status )
{
    $SubmittalsData=renderSuListViewCostCode($database, $project_id,$new_begindate,$enddate,  $user_company_id, $filter_status);
   $htmlContent = <<<END_HTML_CONTENT
   $SubmittalsData
END_HTML_CONTENT;
return $htmlContent;
}
//To fetch Submittal by Id
function renderSuListView($database, $project_id,$new_begindate, $enddate, $typecall = null, $user_company_id, $filter_status)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    $whereFlag = false;
    $whereQuery = '';
    if(!empty($filter_status) && $filter_status == 'outstanding'){
        $whereQuery = 'AND su_fk_sus.`id` NOT IN (2,3)';
        $whereFlag = true;
    }
    if(!empty($filter_status) && $filter_status != 'outstanding'){
        $whereQuery = 'AND su_fk_sus.`id` = '.$filter_status;
        $whereFlag = true;
    }

    $loadSubmittalsByProjectIdOptions->whereFlag = $whereFlag;
    $loadSubmittalsByProjectIdOptions->whereQuery = $whereQuery;

    if($typecall == null || $typecall == '')
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndDate($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);
    else
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndDateOpen($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);
    $suTableTbody = '';

    $suTableTbody = '';
    $GetCount=count($arrSubmittals);
    if($GetCount == '0')
    {
        $suTableTbody="<tr><td colspan='8'>No Data Available for Selected Dates</td></tr>";
    }
    foreach ($arrSubmittals as $submittal_id => $submittal) {
        /* @var $submittal Submittal */

        $project = $submittal->getProject();
        /* @var $project Project */

        $submittalType = $submittal->getSubmittalType();
        /* @var $submittalType SubmittalType */

        $submittalStatus = $submittal->getSubmittalStatus();
        /* @var $submittalStatus SubmittalStatus */

        $submittalId = $submittalStatus->id;

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

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */

            $formattedSuCostCode = $suCostCode->getFormattedCostCodeApi($database, false, $user_company_id);

            //$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCodeApi($database,);
        } else {
            $formattedSuCostCode = '&nbsp;';
        }

        //$recipient = Contact::findContactByIdExtended($database, $su_recipient_contact_id);
        /* @var $recipient Contact */

        if ($suRecipientContact) {
            $suRecipientContactFullName = $suRecipientContact->getContactFullName();
            $suRecipientContactFullNameHtmlEscaped = $suRecipientContact->getContactFullNameHtmlEscaped();
        } else {
            $suRecipientContactFullName = '';
            $suRecipientContactFullNameHtmlEscaped = '&nbsp;';
        }

        // Convert su_created to a Unix timestamp
        $openDateUnixTimestamp = strtotime($su_created);
        //$openDateDisplayString = date('n/j/Y g:ma');
        $oneDayInSeconds = 86400;
        $daysOpen = '';

        $formattedSuCreatedDate = date("m/d/Y", $openDateUnixTimestamp);
        if ($su_due_date == NULL || $su_due_date == '') {
            $su_due_date = '-';
        } else {
            $su_due_date=date("m/d/Y",strtotime($su_due_date));    
        }
        
        // submittal_statuses:
      
        $submittal_status = $submittalStatus->submittal_status;
        $submittalId = $submittalStatus->id;

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

        $suTableTbody .= <<<END_SUBMITTAL_TABLE_TBODY

        <tr id="record_container--manage-submittal-record--submittals--$submittal_id" onclick="Submittals__loadSubmittalModalDialog('$submittal_id');">
            <td class="textAlignCenter" id="manage-submittal-record--submittals--su_sequence_number--$submittal_id" nowrap>$su_sequence_number</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_title--$submittal_id">$escaped_su_title</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--recipientFullName--$submittal_id" nowrap>$suRecipientContactFullNameHtmlEscaped<input type="hidden" id="manage-submittal-record--submittals--su_recipient_contact_id--$submittal_id" value="$su_recipient_contact_id"></td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_created--$submittal_id" nowrap>$formattedSuCreatedDate</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_due_date--$submittal_id" nowrap>$su_due_date</td>
            
            <td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_priority--$submittal_id" nowrap>$submittal_priority<input type="hidden" id="manage-submittal-record--submittals--submittal_priority_id--$submittal_id" value="$submittal_priority_id"></td>
             <td class="textAlignLeft" id="manage-submittal-record--submittals--su_closed_date--$submittal_id" nowrap>$formattedsu_closed_date</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--status--$submittal_id" >$submittal_status</td>
            <td class="textAlignCenter" id="manage-submittal-record--submittals--daysOpen--$submittal_id" nowrap>$daysOpen</td>
        </tr>

END_SUBMITTAL_TABLE_TBODY;
    }
$suTableTbody = mb_convert_encoding($suTableTbody, "HTML-ENTITIES", "UTF-8");

    $htmlContent = <<<END_HTML_CONTENT

<table id="record_list_container--manage-submittal-record" class="detailed_week content" border="0" cellpadding="5" cellspacing="0" width="100%">

    <tr class=" table-headerinner"><td colspan="8">Open Submittal Log</td></tr>
        <tr >
        <td class="textAlignCenter" nowrap>Number</td>
        <td class="textAlignLeft" nowrap>Name</td>
        <td class="textAlignLeft" nowrap>Recipient</td>
        <td class="textAlignLeft" nowrap>Submitted</td>
        <td class="textAlignLeft" nowrap>Target</td>
        <td class="textAlignLeft" nowrap>Priority</td>
        <td class="textAlignLeft" >Approved Date</td>
        <td class="textAlignLeft" >Status</td>
        <td class="textAlignCenter" nowrap>Days Open</td>
        </tr>
   
    <tbody class="altColors">
        $suTableTbody
    </tbody>
</table>

END_HTML_CONTENT;

    return $htmlContent;
}
//To fetch Submittal by Notes
function renderSuListViewNotes($database, $project_id,$new_begindate,$enddate, $user_company_id, $filter_status)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    $whereFlag = false;
    $whereQuery = '';
    if(!empty($filter_status) && $filter_status == 'outstanding'){
        $whereQuery = 'AND su_fk_sus.`id` NOT IN (2,3)';
        $whereFlag = true;
    }
    if(!empty($filter_status) && $filter_status != 'outstanding'){
        $whereQuery = 'AND su_fk_sus.`id` = '.$filter_status;
        $whereFlag = true;
    }

    $loadSubmittalsByProjectIdOptions->whereFlag = $whereFlag;
    $loadSubmittalsByProjectIdOptions->whereQuery = $whereQuery;
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndDate($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);

    $suTableTbody = '';
    $GetCount=count($arrSubmittals);
    if($GetCount == '0')
    {
        $suTableTbody="<tr><td colspan='10'>No Data Available for Selected Dates</td></tr>";
    }
    $loopCounter = 1;
    foreach ($arrSubmittals as $submittal_id => $submittal) {
        /* @var $submittal Submittal */

        $project = $submittal->getProject();
        /* @var $project Project */

        $submittalType = $submittal->getSubmittalType();
        /* @var $submittalType SubmittalType */

        $submittalStatus = $submittal->getSubmittalStatus();
        /* @var $submittalStatus SubmittalStatus */

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

        // if (empty($su_due_date)) {
        //     $su_due_date = '&nbsp;';
        // }

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */

            $formattedSuCostCode = $suCostCode->getFormattedCostCodeApi($database, false, $user_company_id);

            //$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCodeApi($database,);
        } else {
            $formattedSuCostCode = '&nbsp;';
        }

        //$recipient = Contact::findContactByIdExtended($database, $su_recipient_contact_id);
        /* @var $recipient Contact */

        if ($suRecipientContact) {
            $suRecipientContactFullName = $suRecipientContact->getContactFullName();
            $suRecipientContactFullNameHtmlEscaped = $suRecipientContact->getContactFullNameHtmlEscaped();
        } else {
            $suRecipientContactFullName = '';
            $suRecipientContactFullNameHtmlEscaped = '&nbsp;';
        }

        // Convert su_created to a Unix timestamp
        $openDateUnixTimestamp = strtotime($su_created);
        //$openDateDisplayString = date('n/j/Y g:ma');
        $oneDayInSeconds = 86400;
        $daysOpen = '';

        $formattedSuCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

        if ($su_due_date == NULL || $su_due_date == '') {
            $su_due_date = '-';
        } else {
            $su_due_date=date("m/d/Y",strtotime($su_due_date));    
        }
        // submittal_statuses:
        

        $submittal_status = $submittalStatus->submittal_status;
        $submittalId = $submittalStatus->id;
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

        
        // To get the submittal Notes
       $submittal_id_notes= $submittal->submittal_id;
       $db = DBI::getInstance($database);
       $query_notes="Select * from submittal_responses where submittal_id='".$submittal_id_notes."'";
        $db->execute($query_notes);
        $record_notes = array();
    while($row = $db->fetch())
    {
        $record_notes[] = $row;
    }
   
    $NotesValue='<table width="100%" class="submittalNotes" cellpadding="5">';
    $responseDate='';
    $ivalue='1';
    foreach ($record_notes as $key => $notes) {
        $NotesValue.='<tr><td>'.$ivalue.')'.$notes['submittal_response'].'</td></tr>';
        $resdate = DateTime::createFromFormat('Y-m-d H:i:s', $notes['created']);
        $Respdate = $resdate->format('m/d/Y g:i a');
        $responseDate.=$ivalue.')'.$Respdate.'<br>';
        $ivalue++;
    }
    $NotesValue.="</table>";
   // $NotesValue=rtrim($NotesValue,'<br>');
   $responseDate=rtrim($responseDate,'<br>');
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
         if ($loopCounter%2) {
            $rowStyle = 'odd';
        } else {
            $rowStyle = 'even';
        }


        $suTableTbody .= <<<END_SUBMITTAL_TABLE_TBODY

        <tr class="$rowStyle">
            <td class="textAlignCenter" id="manage-submittal-record--submittals--su_sequence_number--$submittal_id" nowrap>$su_sequence_number</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_title--$submittal_id">$escaped_su_title</td>
            <td class="text-justify" id="manage-submittal-record--submittals--recipientFullName--$submittal_id" >$suRecipientContactFullNameHtmlEscaped<input type="hidden" id="manage-submittal-record--submittals--su_recipient_contact_id--$submittal_id" value="$su_recipient_contact_id"></td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_created--$submittal_id" nowrap>$formattedSuCreatedDate</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_due_date--$submittal_id" nowrap>$su_due_date</td>
            
            <td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_priority--$submittal_id" nowrap>$submittal_priority<input type="hidden" id="manage-submittal-record--submittals--submittal_priority_id--$submittal_id" value="$submittal_priority_id"></td>
             <td class="textAlignLeft" id="manage-submittal-record--submittals--su_closed_date--$submittal_id" nowrap>$formattedsu_closed_date</td>            
            <td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_status--$submittal_id" nowrap>$submittal_status<input type="hidden" id="manage-submittal-record--submittals--submittal_status_id--$submittal_id" value="$submittal_status_id"></td>
            <td class="textAlignCenter" id="manage-submittal-record--submittals--daysOpen--$submittal_id" nowrap>$daysOpen</td>
            <td class="text-justify" id="manage-submittal-record--submittals--notes--$submittal_id" >$NotesValue</td>
            
            
        </tr>

END_SUBMITTAL_TABLE_TBODY;
$loopCounter++;
//<td class="text-justify" id="manage-submittal-record--submittals--responseDate--$submittal_id" nowrap>$responseDate</td>
    }
    //<th class="textAlignCenter" nowrap>Response Date</th>
$suTableTbody = mb_convert_encoding($suTableTbody, "HTML-ENTITIES", "UTF-8");
    $htmlContent = <<<END_HTML_CONTENT

<table id="record_list_container--manage-submittal-record" class="detailed_week content" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom ">
     <tr class=" table-headerinner"><td colspan="10">Submittal Log</td></tr>
        <tr>
        <th class="textAlignCenter" nowrap>No</th>
        <th class="textAlignLeft" nowrap>Name</th>
        <th class="textAlignLeft" >Recipient</th>
        <th class="textAlignLeft" nowrap>Submitted</th>
        <th class="textAlignLeft" nowrap>Target</th>
        <th class="textAlignLeft" nowrap>Priority</th>
        <th class="textAlignLeft" >Approved Date</th>
        <th class="textAlignLeft" >Status</th>
        <th class="textAlignCenter" >Days</th>
        <th class="textAlignCenter" nowrap>Notes</th>
        </tr>
    </thead>
    <tbody class="">
        $suTableTbody
    </tbody>
</table>

END_HTML_CONTENT;

    return $htmlContent;
}
//To fetch Submittal by Status
function renderSuListViewStatus($database, $project_id, $new_begindate, $enddate, $user_company_id, $filter_status)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    $whereFlag = false;
    $whereQuery = '';
    if(!empty($filter_status) && $filter_status == 'outstanding'){
        $whereQuery = 'AND su_fk_sus.`id` NOT IN (2,3)';
        $whereFlag = true;
    }
    if(!empty($filter_status) && $filter_status != 'outstanding'){
        $whereQuery = 'AND su_fk_sus.`id` = '.$filter_status;
        $whereFlag = true;
    }

    $loadSubmittalsByProjectIdOptions->whereFlag = $whereFlag;
    $loadSubmittalsByProjectIdOptions->whereQuery = $whereQuery;
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndStatus($database, $project_id, $loadSubmittalsByProjectIdOptions, $new_begindate, $enddate);

    $suTableTbody = '';
    $GetCount=count($arrSubmittals);
    if($GetCount == '0')
    {
        $suTableTbody="<tr><td colspan='9'>No Data Available for Selected Dates</td></tr>";
    }

    foreach ($arrSubmittals as $submittal_id => $submittal) {
        /* @var $submittal Submittal */

        $project = $submittal->getProject();
        /* @var $project Project */

        $submittalType = $submittal->getSubmittalType();
        /* @var $submittalType SubmittalType */

        $submittalStatus = $submittal->getSubmittalStatus();
        /* @var $submittalStatus SubmittalStatus */

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

        // if (empty($su_due_date)) {
        //     $su_due_date = '&nbsp;';
        // }

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */

            $formattedSuCostCode = $suCostCode->getFormattedCostCodeApi($database, false, $user_company_id);

            //$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCodeApi($database,);
        } else {
            $formattedSuCostCode = '&nbsp;';
        }

        //$recipient = Contact::findContactByIdExtended($database, $su_recipient_contact_id);
        /* @var $recipient Contact */

        if ($suRecipientContact) {
            $suRecipientContactFullName = $suRecipientContact->getContactFullName();
            $suRecipientContactFullNameHtmlEscaped = $suRecipientContact->getContactFullNameHtmlEscaped();
        } else {
            $suRecipientContactFullName = '';
            $suRecipientContactFullNameHtmlEscaped = '&nbsp;';
        }

        // Convert su_created to a Unix timestamp
        $openDateUnixTimestamp = strtotime($su_created);
        //$openDateDisplayString = date('n/j/Y g:ma');
        $oneDayInSeconds = 86400;
        $daysOpen = '';

        $formattedSuCreatedDate = date("m/d/Y", $openDateUnixTimestamp);
        
        if ($su_due_date == NULL || $su_due_date == '') {
            $su_due_date = '-';
        } else {
            $su_due_date=date("m/d/Y",strtotime($su_due_date));    
        }
        // submittal_statuses:
       
        $submittal_status = $submittalStatus->submittal_status;
        $submittalId = $submittalStatus->id;
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

        $suTableTbody .= <<<END_SUBMITTAL_TABLE_TBODY

        <tr id="record_container--manage-submittal-record--submittals--$submittal_id" onclick="Submittals__loadSubmittalModalDialog('$submittal_id');">
            <td class="textAlignCenter" id="manage-submittal-record--submittals--su_sequence_number--$submittal_id" nowrap>$su_sequence_number</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_title--$submittal_id">$escaped_su_title</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--recipientFullName--$submittal_id" nowrap>$suRecipientContactFullNameHtmlEscaped<input type="hidden" id="manage-submittal-record--submittals--su_recipient_contact_id--$submittal_id" value="$su_recipient_contact_id"></td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_created--$submittal_id" nowrap>$formattedSuCreatedDate</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_due_date--$submittal_id" nowrap>$su_due_date</td>
            
            <td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_priority--$submittal_id" nowrap>$submittal_priority<input type="hidden" id="manage-submittal-record--submittals--submittal_priority_id--$submittal_id" value="$submittal_priority_id"></td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_closed_date--$submittal_id" nowrap>$formattedsu_closed_date</td>            
            <td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_status--$submittal_id" nowrap>$submittal_status<input type="hidden" id="manage-submittal-record--submittals--submittal_status_id--$submittal_id" value="$submittal_status_id"></td>
            <td class="textAlignCenter" id="manage-submittal-record--submittals--daysOpen--$submittal_id" nowrap>$daysOpen</td>
            
            
        </tr>

END_SUBMITTAL_TABLE_TBODY;
    }
$suTableTbody = mb_convert_encoding($suTableTbody, "HTML-ENTITIES", "UTF-8");
    $htmlContent = <<<END_HTML_CONTENT

<table id="record_list_container--manage-submittal-record" class="detailed_week content" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom ">
     <tr class=" table-headerinner"><td colspan="9">Submittal Log</td></tr>
        <tr>
        <th class="textAlignCenter" nowrap>Number</th>
        <th class="textAlignLeft" nowrap>Name</th>
        <th class="textAlignLeft" nowrap>Recipient</th>
        <th class="textAlignLeft" nowrap>Submitted</th>
        <th class="textAlignLeft" nowrap>Target</th>
        <th class="textAlignLeft" nowrap>Priority</th>
         <th class="textAlignLeft" nowrap>Completed Date</th>
        <th class="textAlignLeft" nowrap>Status</th>
        <th class="textAlignCenter" nowrap>Days Open</th>
        
        </tr>
    </thead>
    <tbody class="altColors">
        $suTableTbody
    </tbody>
</table>

END_HTML_CONTENT;

    return $htmlContent;
}
//To fetch Submittal by Cost Code
function renderSuListViewCostCode($database, $project_id, $new_begindate, $enddate,  $user_company_id, $filter_status)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    $whereFlag = false;
    $whereQuery = '';
    if(!empty($filter_status) && $filter_status == 'outstanding'){
        $whereQuery = 'AND su_fk_sus.`id` NOT IN (2,3)';
        $whereFlag = true;
    }
    if(!empty($filter_status) && $filter_status != 'outstanding'){
        $whereQuery = 'AND su_fk_sus.`id` = '.$filter_status;
        $whereFlag = true;
    }

    $loadSubmittalsByProjectIdOptions->whereFlag = $whereFlag;
    $loadSubmittalsByProjectIdOptions->whereQuery = $whereQuery;
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndCostCode($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);

    $suTableTbody = '';
    $GetCount=count($arrSubmittals);
    if($GetCount == '0')
    {
        $suTableTbody="<tr><td colspan='9'>No Data Available for Selected Dates</td></tr>";
    }
    foreach ($arrSubmittals as $submittal_id => $submittal) {
        /* @var $submittal Submittal */

        $project = $submittal->getProject();
        /* @var $project Project */

        $submittalType = $submittal->getSubmittalType();
        /* @var $submittalType SubmittalType */

        $submittalStatus = $submittal->getSubmittalStatus();
        /* @var $submittalStatus SubmittalStatus */

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

        // if (empty($su_due_date)) {
        //     $su_due_date = '&nbsp;';
        // }

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */

            $formattedSuCostCode = $suCostCode->getFormattedCostCodeApi($database, false, $user_company_id);

            //$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCodeApi($database,);
        } else {
            $formattedSuCostCode = '&nbsp;';
        }
        //$recipient = Contact::findContactByIdExtended($database, $su_recipient_contact_id);
        /* @var $recipient Contact */

        if ($suRecipientContact) {
            $suRecipientContactFullName = $suRecipientContact->getContactFullName();
            $suRecipientContactFullNameHtmlEscaped = $suRecipientContact->getContactFullNameHtmlEscaped();
        } else {
            $suRecipientContactFullName = '';
            $suRecipientContactFullNameHtmlEscaped = '&nbsp;';
        }

        // Convert su_created to a Unix timestamp
        $openDateUnixTimestamp = strtotime($su_created);
        //$openDateDisplayString = date('n/j/Y g:ma');
        $oneDayInSeconds = 86400;
        $daysOpen = '';

        $formattedSuCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

        if ($su_due_date == NULL || $su_due_date == '') {
            $su_due_date = '-';
        } else {
            $su_due_date=date("m/d/Y",strtotime($su_due_date));    
        }
        // submittal_statuses:
        $submittal_status = $submittalStatus->submittal_status;
        $submittalId = $submittalStatus->id;
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

        $suTableTbody .= <<<END_SUBMITTAL_TABLE_TBODY

        <tr id="record_container--manage-submittal-record--submittals--$submittal_id" onclick="Submittals__loadSubmittalModalDialog('$submittal_id');">
            <td class="textAlignCenter" id="manage-submittal-record--submittals--su_sequence_number--$submittal_id" nowrap>$su_sequence_number</td>
             <td class="textAlignCenter" id="manage-submittal-record--submittals--costCode--$submittal_id" nowrap>$formattedSuCostCode</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_title--$submittal_id">$escaped_su_title</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--recipientFullName--$submittal_id" nowrap>$suRecipientContactFullNameHtmlEscaped<input type="hidden" id="manage-submittal-record--submittals--su_recipient_contact_id--$submittal_id" value="$su_recipient_contact_id"></td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_created--$submittal_id" nowrap>$formattedSuCreatedDate</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_due_date--$submittal_id" nowrap>$su_due_date</td>
            
            <td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_priority--$submittal_id" nowrap>$submittal_priority<input type="hidden" id="manage-submittal-record--submittals--submittal_priority_id--$submittal_id" value="$submittal_priority_id"></td>
             <td class="textAlignLeft" id="manage-submittal-record--submittals--su_closed_date--$submittal_id" nowrap>$formattedsu_closed_date</td>     
            <td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_status--$submittal_id" nowrap>$submittal_status<input type="hidden" id="manage-submittal-record--submittals--submittal_status_id--$submittal_id" value="$submittal_status_id"></td>
            <td class="textAlignCenter" id="manage-submittal-record--submittals--daysOpen--$submittal_id" nowrap>$daysOpen</td>
        </tr>

END_SUBMITTAL_TABLE_TBODY;
    }
    $suTableTbody = mb_convert_encoding($suTableTbody, "HTML-ENTITIES", "UTF-8");
    $htmlContent = <<<END_HTML_CONTENT

<table id="record_list_container--manage-submittal-record" class="detailed_week content" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom ">
    <tr class=" table-headerinner"><td colspan="10">Submittal Log</td></tr>
        <tr >
        <th class="textAlignCenter" nowrap>Number</th>
        <th class="textAlignLeft" nowrap>Cost Code</th>
        <th class="textAlignLeft" nowrap>Name</th>
        <th class="textAlignLeft" nowrap>Recipient</th>
        <th class="textAlignLeft" nowrap>Submitted</th>
        <th class="textAlignLeft" nowrap>Target</th>
        <th class="textAlignLeft" nowrap>Priority</th>
        <th class="textAlignLeft" nowrap>Approved Date</th>
        <th class="textAlignLeft" nowrap>Status</th>
        <th class="textAlignCenter" nowrap>Days Open</th>
        </tr>
    </thead>
    <tbody class="altColors">
        $suTableTbody
    </tbody>
</table>

END_HTML_CONTENT;

    return $htmlContent;
}
//  Bidder list array get
function getBidderArray($database, $user_company_id, $project_id, $csvFilterBySubcontractorBidStatusIds = "1,2,3,4,5,6,7", $sort_by_order = "cost_code_division_id,company,cost_code,division_number")
{

    if (!isset($csvFilterBySubcontractorBidStatusIds) || empty($csvFilterBySubcontractorBidStatusIds)) {
        $csvFilterBySubcontractorBidStatusIds = "1,2,3,4,5,6,7";
    }

    if (!isset($sort_by_order) || empty($sort_by_order)) {
        $sort_by_order = "cost_code_division_id,cost_code,division_number";
    }else{
        $sort_by_order .= ",division_number";
    }

    $arrSubcontractorBidStatusesWithTotals = array(
        5 => 1,
        7 => 1,
        10 => 1,
        12 => 1,
        13 => 1,
    );
    $arrFilterBySubcontractorBidStatusIds = explode(',', $csvFilterBySubcontractorBidStatusIds);
    $loadBidTotals = false;
    foreach ($arrFilterBySubcontractorBidStatusIds AS $subcontractor_bid_status_id) {
        $subcontractor_bid_status_id = (int) $subcontractor_bid_status_id;

        if (is_int($subcontractor_bid_status_id) && ($subcontractor_bid_status_id > 0)) {

            if (isset($arrSubcontractorBidStatusesWithTotals[$subcontractor_bid_status_id])) {
                $loadBidTotals = true;
            }

        } else {
            return 'Invalid Sort Parameters';
        }
    }

    if (!$loadBidTotals && is_int(strpos($sort_by_order, 'bid_total'))) {
        if (is_int(strpos($sort_by_order, ',bid_total'))) {
            $sort_by_order = str_replace(',bid_total', '', $sort_by_order);
        } elseif (is_int(strpos($sort_by_order, 'bid_total,'))) {
            $sort_by_order = str_replace('bid_total,', '', $sort_by_order);
        }
    }

    $arrSortValues = explode(',',$sort_by_order);
    foreach ($arrSortValues AS $sortItem) {
        if ($sortItem == 'company' || $sortItem == 'cost_code' || $sortItem == 'bid_total' || $sortItem == 'email' || $sortItem == 'first_name' || $sortItem == 'last_name' || $sortItem =='cost_code_division_id' || $sortItem =='division_number') {
            continue;
        } else {
            return 'Invalid Sort Parameters';
        }
    }

    if ($loadBidTotals) {
        $bidTotalSelect = ",SUM(bi2sb.`item_quantity` * bi2sb.`unit_price`) AS 'bid_total'";
        $bidTotalFrom = 'LEFT OUTER JOIN `bid_items_to_subcontractor_bids` bi2sb ON sb.`id` = bi2sb.`subcontractor_bid_id`';
        $bidTotalGroupBy = 'GROUP by sb.`id`';
    } else{
        $bidTotalSelect = '';
        $bidTotalFrom = '';
        $bidTotalGroupBy = '';
    }

    $db = DBI::getInstance($database);

    $statusLoop = 1;
    $query =
"
SELECT
    gbli.*,
    #sb.*,
    codes.*,
    ccd.*,
    sb.`sort_order` as 'subcontractor_bid_sort_order',
    sbs.`sort_order` as 'subcontractor_bid_status_sort_order',
    sbs.`subcontractor_bid_status`,
    c.`id` AS 'contact_id',
    concat(c.`first_name`, ' ', c.`last_name`) AS 'contact_full_name',
    c.`email`,
    cc.`company`,
    sb.*
    $bidTotalSelect
FROM `gc_budget_line_items` gbli
    INNER JOIN `subcontractor_bids` sb ON gbli.`id` = sb.`gc_budget_line_item_id`
    INNER JOIN `subcontractor_bid_statuses` sbs ON sb.`subcontractor_bid_status_id` = sbs.`id`
    INNER JOIN `contacts` c ON sb.`subcontractor_contact_id` = c.`id`
    INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
    INNER JOIN `cost_codes` codes ON gbli.`cost_code_id` = codes.`id`
    INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
    $bidTotalFrom
WHERE gbli.`user_company_id` = ?
AND gbli.`project_id` = ?
AND sb.`subcontractor_bid_status_id` IN($csvFilterBySubcontractorBidStatusIds)
$bidTotalGroupBy
ORDER BY $sort_by_order ASC
";
    $arrValues = array($user_company_id, $project_id);
    $db->execute($query, $arrValues, MYSQLI_USE_RESULT);

    $arrBidders = array();
    while ($row = $db->fetch()) {
        $division_number = $row['division_number'];
        $division = $row['division'];
        $cost_code = $row['cost_code'];
        $cost_code_description = $row['cost_code_description'];

        $subcontractor_bid_id = $row['id'];
        $gbli_id = $row['gc_budget_line_item_id'];
        $contact_id = $row['contact_id'];
        $subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
        if (isset($row['bid_total'])) {
            $bid_total = $row['bid_total'];
        } else {
            $bid_total = '';
        }
        $subcontractor_bid_sort_order = $row['subcontractor_bid_sort_order'];
        $subcontractor_bid_status_sort_order = $row['subcontractor_bid_status_sort_order'];
        $subcontractor_bid_status = $row['subcontractor_bid_status'];
        $contactFullName = $row['contact_full_name'];
        $email = $row['email'];
        $company = $row['company'];



        //echo '<pre>' . print_r($row,true) . '</pre>';

        $arrBidders[$subcontractor_bid_id]['division_number'] = $division_number;
        $arrBidders[$subcontractor_bid_id]['division'] = $division;
        $arrBidders[$subcontractor_bid_id]['cost_code'] = $cost_code;
        $arrBidders[$subcontractor_bid_id]['cost_code_description'] = $cost_code_description;
        $arrBidders[$subcontractor_bid_id]['gc_budget_line_item_id'] = $gbli_id;
        $arrBidders[$subcontractor_bid_id]['contact_id'] = $contact_id;
        $arrBidders[$subcontractor_bid_id]['subcontractor_bid_status_id'] = $subcontractor_bid_status_id;
        $arrBidders[$subcontractor_bid_id]['bid_total'] = $bid_total;
        $arrBidders[$subcontractor_bid_id]['subcontractor_bid_sort_order'] = $subcontractor_bid_sort_order;
        $arrBidders[$subcontractor_bid_id]['subcontractor_bid_status_sort_order'] = $subcontractor_bid_status_sort_order;
        $arrBidders[$subcontractor_bid_id]['subcontractor_bid_status'] = $subcontractor_bid_status;
        $arrBidders[$subcontractor_bid_id]['full_name'] = $contactFullName;
        $arrBidders[$subcontractor_bid_id]['email'] = $email;
        $arrBidders[$subcontractor_bid_id]['company'] = $company;
    }
    $db->free_result();

    return $arrBidders;
}
/*Bidder List Report table content*/
function loadPurchasingBidderListReportSpr($database, $arrBidders, $sort_by_order, $user_company_id)
{

    if (!isset($sort_by_order) || empty($sort_by_order)) {
        $sort_by_order = "company, division_number, cost_code";
    }

    $subcontractorBidderCount = count($arrBidders);

    if (strpos($sort_by_order, 'cost_code') == 0) {

        $headRow = <<<END_HTML_CONTENT

            <tr class="">
                <th style="padding-bottom:20px;" class="align-left">Division</th>
                <th style="padding-bottom:20px;" class="align-left">Company</th>
                <th style="padding-bottom:20px;" class="align-left">Contact</th>
                <th style="padding-bottom:20px;" class="align-left">Status</th>
                <th style="padding-bottom:20px;" class="align-left">Phone</th>
                <th style="padding-bottom:20px;" class="align-left">Fax</th>
                <th style="padding-bottom:20px;" class="align-left">Email</th>
                <th style="padding-bottom:20px;" class="align-left">Bid Amount</th>
            </tr>
END_HTML_CONTENT;

    } else {

        $headRow = <<<END_HTML_CONTENT

            <tr class="">
                <th style="padding-bottom:20px;" class="align-left">Company</th>
                <th style="padding-bottom:20px;" class="align-left">Contact</th>
                <th style="padding-bottom:20px;" class="align-left">Division</th>
                <th style="padding-bottom:20px;" class="align-left">Status</th>
                <th style="padding-bottom:20px;" class="align-left">Phone</th>
                <th style="padding-bottom:20px;" class="align-left">Fax</th>
                <th style="padding-bottom:20px;" class="align-left">Email</th>
                <th style="padding-bottom:20px;" class="align-left">Bid Amount</th>
            </tr>
END_HTML_CONTENT;

    }

    $lastCode = '';
    $lastCompany = '';
    $htmlContent = '';
    foreach ($arrBidders AS $subcontractor_bid_id => $dummy) {

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
        if($user_company_id){
            $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
        }else{
            $costCodeDividerType = '-';
        }
        $formatted_cost_code = $division_number.$costCodeDividerType.$cost_code;
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

            $htmlContent .= <<<END_HTML_CONTENT

                <tr class="oddRow">
                    <td>Cost Code</td>
                    <td nowrap>$formatted_cost_code</td>
                    <td nowrap>$escaped_cost_code_description</td>
                    <td colspan="5" >&nbsp;</td>
                </tr>
END_HTML_CONTENT;
        }

        if (strpos($sort_by_order, 'cost_code') == 0) {

            $formatted_bid_total = money_format('%!i', $bid_total);
            $htmlContent .= <<<END_HTML_CONTENT

                <tr class="borederRowBid">
                    <td>$division</td>
                    <td>$company</td>
                    <td>$contactFullName</td>
                    <td>$subcontractor_bid_status</td>
                    <td>$formattedMobilePhoneNumber</td>
                    <td>$formattedFaxNumber</td>
                    <td>$email</td>
                    <td align="right">$formatted_bid_total</td>
                </tr>
END_HTML_CONTENT;

        } else {

            $formatted_bid_total = money_format('%!i', $bid_total);
            $htmlContent .= <<<END_HTML_CONTENT

                <tr class="borederRowBid">
                    <td>$company</td>
                    <td>$contactFullName</td>
                    <td>$division</td>
                    <td>$subcontractor_bid_status</td>
                    <td>$formattedMobilePhoneNumber</td>
                    <td>$formattedFaxNumber</td>
                    <td>$email</td>
                    <td align="right">$formatted_bid_total</td>
                </tr>
END_HTML_CONTENT;

        }

        /*$lastCode = $cost_code;*/
        /*$lastCompany = $company;*/
        $lastCode = $formatted_cost_code;
        // $lastCompany = $escaped_company;

    }
    if($htmlContent == ''){
        $htmlContent= <<<END_HTML_CONTENT
        <tr>
        <td colspan="8" class="textAlignLeft">No Data Available for Selected Dates</td>
        </tr>
END_HTML_CONTENT;
    }
    $htmlContent = <<<END_HTML_CONTENT
    <table id="BidderList" class="tableborder content cell-border"  cellpadding="5" cellspacing="0" width="100%" border="0">
    <thead class="borderBottom">
       <tr class="table-headerinner">
            <th colspan="8" class="textAlignLeft">Bid List Report</th>
            </tr>
       $headRow
    </thead>
    <tbody class="">
        $htmlContent
    </tbody>
</table>
END_HTML_CONTENT;
    return $htmlContent;
}
//Jobstatus Function
function JobStatus($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $typepost){
    $db = DBI::getInstance($database);

    $arrActionItemsByDiscussionItemIds = ActionItem::loadActionItemsByProjectReport($database, $project_id, $new_begindate, $enddate);
    // echo "<pre>";
    // print_r($arrActionItemsByDiscussionItemIds);
    $opentrackitemcontent='';
    foreach($arrActionItemsByDiscussionItemIds as $opentrack => $opentrackitem){
        /*Assign a Variable*/
        $action_item_id=$opentrackitem->action_item_id;
        $project_id=$opentrackitem->project_id;
        $action_item_type_id=$opentrackitem->action_item_type_id;
        $action_item_status_id=$opentrackitem->action_item_status_id;
        $action_item_priority_id=$opentrackitem->action_item_priority_id;
        $created_by_contact_id=$opentrackitem->created_by_contact_id;
        $action_item_title=$opentrackitem->action_item_title;
        $action_item=$opentrackitem->action_item;
        $created=$opentrackitem->created;
        $action_item_due_date=$opentrackitem->action_item_due_date;
        $action_item_completed_timestamp=$opentrackitem->action_item_completed_timestamp;
        $sort_order=$opentrackitem->sort_order;
        if($action_item_due_date!='')
        $duedate=date('m/d/Y',strtotime($action_item_due_date));
        $createdcus=date('m/d/Y',strtotime($created));
        /*Get the Assignee's name*/
        $loadActionItemAssignmentsByActionItemIdOptions = new Input();
        $loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
        $arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $action_item_id, $loadActionItemAssignmentsByActionItemIdOptions);
    $ulActionItemAssigneesUneditable = '';
    $ulActionItemAssigneesEditable = '';
    foreach ($arrActionItemAssignmentsByActionItemId as $actionItemAssignment) {
        /* @var $actionItemAssignment ActionItemAssignment */

        $actionItemAssigneeContact = $actionItemAssignment->getActionItemAssigneeContact();
        /* @var $actionItemAssigneeContact Contact */

        $actionItemAssigneeFullName = $actionItemAssigneeContact->getContactFullNameHtmlEscaped();
        $action_item_assignee_contact_id = $actionItemAssigneeContact->contact_id;

        $uniqueId = $action_item_id.'-'.$action_item_assignee_contact_id;
        
        $ulActionItemAssigneesUneditable .= '<li>'.$actionItemAssigneeFullName.'</li>';
    }
    $AssignTo=$ulActionItemAssigneesUneditable;
    if($ulActionItemAssigneesUneditable=='')
        $AssignTo='Unassigned Task';
        //store the data's into variables
       $opentrackitemcontent.=<<<TableBodyTrackItem
       <tr>
       <td class="align-left"><ul style="list-style:none;margin:0px; padding:0px;">$AssignTo</ul></td>
       <td class="align-left">$action_item</td>
       <td class="align-left">$createdcus</td>
       <td class="align-left">$duedate</td>
       </tr>
TableBodyTrackItem;
    }
    if($opentrackitemcontent==''){
        $opentrackitemcontent=<<<TableBodyTrackItem
       <tr>
       <td class="align-left" colspan="4">No Data Available for Selected Dates</td>
       </tr>
TableBodyTrackItem;
    }

    $OpenRFITable=RFIReportbyIDOpen($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $typepost);
    $jobsite_daily_log_id = '';
    $jobsite_daily_log_created_date = date('Y-m-d');
    $lastdate='0000-00-00';
    $con_query="SELECT jb.*,dl.*,date(dl.jobsite_daily_log_created_date) as lastdate FROM `jobsite_man_power` jb LEFT JOIN jobsite_daily_logs dl on dl.id = jb.jobsite_daily_log_id WHERE date(dl.jobsite_daily_log_created_date)!='$jobsite_daily_log_created_date' ORDER BY dl.id DESC ";
    $db->execute($con_query);
    $row=$db->fetch();

    if(isset($row)){
    $jobsite_daily_log_id=$row['jobsite_daily_log_id'];
    $lastdate=$row['lastdate'];
    }
    
    $man_begindate_arr=explode(' ', $new_begindate);
    $man_begindate=$man_begindate_arr[0];
  
    $yesdayManPower = buildManpowerSectionProject($database, $user_company_id, $project_id, $man_begindate,$enddate);
    
    $SubmittalsData=renderSuListView($database, $project_id,$new_begindate,$enddate ,$type='jobstatus', $user_company_id);
    $db = DBI::getInstance($database);
    $db->free_result();
    
    $changeorder=renderCoListView_AsHtmlJobstatus($database, $project_id, $new_begindate, $enddate);

    $purchaseingorder=PurchaseAndForcastReport($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName);
    $htmlContent = <<<END_HTML_CONTENT
<table id="OpenTrackItem" class="tableborder content cell-border"  cellpadding="5" cellspacing="0" width="100%" border="0">
    <tr class="table-headerinner">
            <td colspan="4" class="textAlignLeft">Open Track Items</td>
            </tr>
       <tr>
       <td class="align-left">Individual</td>       
       <td class="align-left">Description</td>
       <td class="align-left">Date Created</td>
       <td class="align-left">Due Date</td>
        </tr>
    <tbody class="altColors">
        $opentrackitemcontent
    </tbody>
</table>
$OpenRFITable
$yesdayManPower
$SubmittalsData
$changeorder
$purchaseingorder
END_HTML_CONTENT;
return $htmlContent;
}
//To get the man power Data Whole project
function buildManpowerSectionProject($database, $user_company_id, $project_id,  $new_begindate,$enddate)
{
    $date1 = new DateTime($new_begindate);
$date2 = new DateTime($enddate);
$maxDays = $date2->diff($date1)->format("%a");
$arrayManValue=array();
$arrayManDate=array();
$arrayManComp=array();
$count='1';

$htmlContent='';
// $currentlyActiveContactId = $session->getCurrentlyActiveContactId();
for($inday=0;$inday<$maxDays;$inday++){
     $sub_count='1';
    $datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
    $jobsite_daily_log_id = '';
    $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);
    if ($jobsiteDailyLog) {
       $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    }
    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
    $arrJobsiteManPowerIds = '';
    $arrJobsiteManPowerByJobsiteDailyLogId = '';
    $arrJobsiteManPowerBySubcontractId = '';
    if(isset($arrReturn['jobsite_man_power_ids'])) {
        $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
    }
    if(isset($arrReturn['objects'])) {
        $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
    }
    if(isset($arrReturn['jobsite_man_power_by_subcontract_id'])) {
        $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];
    }

    $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id);
    $totalnumber_of_people=0;

    foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        /* @var $subcontract Subcontract */
        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        $costCode = $gcBudgetLineItem->getCostCode();
        /* @var $costCode CostCode */

        $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCodeApi($database,$user_company_id);

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
    $WeekDay=date('D', strtotime($datestep));
    $begindate = DateTime::createFromFormat('Y-m-d', $datestep);
    $manDate = $begindate->format('m/d');
     if($number_of_people==0)
    $number_of_people='';
$arrayManComp[$sub_count][0]=$contact_company_name.'-'.$htmlEntityEscapedFormattedCostCode;
$arrayManValue[$sub_count][0]='';
$arrayManValue[$sub_count][$count]=$number_of_people;
$arrayManDate[$count]=$WeekDay.','.$manDate;

$sub_count++;
    }
 $count++;
 }

 $array_count=count($arrayManValue);
 $date_count=count($arrayManDate);
 $CheckTableValue=1;
 $valuehtml='<table id="manpower_activity_monthly1" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">';
 $valuehtml.='';
$valuehtml.='<tr class="table-headerinner">
        <th colspan="2" class="align-left">Manpower Report </th>
        </tr>';
 
 
$arrayChek=array();
$checkNull='';
foreach($arrayManValue as $index=>$value)
{
    $value=array_filter($arrayManValue[$index]);
    foreach($arrayManValue[$index] as $index1 => $value1)
    {
        $JoinArray='';
        if(isset($arrayChek[$index1])){
            $JoinArray .=$arrayChek[$index1];    
        }        
        $JoinArray .=$arrayManValue[$index][$index1];
        $arrayChek[$index1]=$JoinArray;
        $checkNull .= $arrayManValue[$index][$index1];
    }
}
 if($checkNull!=''){
for($datei=1;$datei<=$date_count;$datei++)
{
    if($datei==1)
    $valuehtml.='<tr><td class="align-left">Company</td>';
    $value_explode=explode(',',$arrayManDate[$datei]);
    
    if($datei==$date_count)
    $valuehtml.="<td># Of Men</td></tr>";

}
$valuehtml.="";
$valuehtml.='<tbody class="altColors">';
$weekTotalcol=0;
$colTotal=0;
$coltotalarray=array();
$colcount=1;
for($valuei=1;$valuei<=$array_count;$valuei++){
$valuehtml.="<tr id='month_td'>";
$row_total='';
$valueinarraycount=count($arrayManValue[$valuei]);
for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
    if($invaluei!=0){
        $class="class='center-align'";
        
    }else{
        $class="class='align-left'";
        $valuehtml.="<td $class style='white-space:nowrap;'>".$arrayManComp[$valuei][$invaluei]."</td>";
    }

    if($invaluei!=0){
        if(isset($coltotalarray[$invaluei])) {
            $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
        } else {
            $coltotalarray[$invaluei]=$arrayManValue[$valuei][$invaluei];
        }
        if($arrayManValue[$valuei][$invaluei]!='')
        $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
    }
}
$valuehtml.="<td class='total_bold center-align'>$row_total</td>";
$valuehtml.="</tr>";
$weekTotalcol=$weekTotalcol+$row_total;
$coltotalarray[$invaluei]=$weekTotalcol;
}
$counttotalValue=count($coltotalarray);
$valuehtml.="<tr class='total_bold center-align'>";
for($invaluet=1;$invaluet<=$counttotalValue;$invaluet++){
    if($invaluet==1)
    $valuehtml.="<td class='align-left'>DAY TOTAL</td>";
   
        if($invaluet==$counttotalValue)
            $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
       

}
}
if($counttotalValue==0){
$valuehtml.="<tr><td colspan=".($maxDays+2).">No Manpower Efforts Involved For Selected Dates</td>";
$CheckTableValue=0;
}
$valuehtml.="</tr>";
$valuehtml.="</tbody>";
$valuehtml.='</table><input type="hidden" id="CheckTableValue" name="CheckTableValue" value="'.$CheckTableValue.'">';
    return $valuehtml;

}
//Fetch the Sub List (subcontract) from budget
function BudgetList($database, $user_company_id, $currentlyActiveContactId, $project_id, $companyName, $projectName, $cost_code_division_id_filter=null){

    // $project->htmlEntityEscapeProperties();
    $escaped_project_name = $projectName;

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

$gcBudgetForm = <<<END_FORM
        <table id="sublist" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">
            <thead class="borderBottom">
            <tr class="table-headerinner">
            <th colspan="6" class="textAlignLeft">Sub List</th>
            </tr>
                <tr class="">
                    <th class="textAlignLeft" width="20%">Trade</th>
                    <th class="textAlignLeft" width="20%">Company</th>
                    <th class="textAlignLeft" width="15%">Contact</th>
                    <th class="textAlignLeft" width="15%">Phone</th>
                    <!-- <th class="textAlignLeft" width="15%">Fax</th> -->
                    <th class="textAlignLeft" width="15%">Address</th>
                    <th class="textAlignLeft" width="15%">City</th>
                    <th class="textAlignLeft" width="15%">State</th>
                    <th class="textAlignLeft" width="15%">Zip</th>
                </tr>
            </thead>
            <tbody class="altColors">
END_FORM;
    $renderGcBudgetLineItemsTbody = renderGcBudgetLineItemsTbodySub($database, $user_company_id, $project_id, $cost_code_division_id_filter);
    $gcBudgetForm .= $renderGcBudgetLineItemsTbody;


$gcBudgetForm .= <<<END_FORM
            </tbody>
        </table>
    </div>
END_FORM;

 return $gcBudgetForm;

}
// Budget Version
function renderProjectBidInvitationFilesAsUrlList($database, $project_id)
{
    // project_bid_invitations

    $uri = Zend_Registry::get('uri');
    /* @var $uri Uri */

    $loadProjectBidInvitationsByProjectIdOptions = new Input();
    //$loadProjectBidInvitationsByProjectIdOptions->forceLoadFlag = true;
    $loadProjectBidInvitationsByProjectIdOptions->arrOrderByAttributes = array(
        'project_bid_invitation_sequence_number' => 'DESC'
    );
    $arrProjectBidInvitationsByProjectId = ProjectBidInvitation::loadProjectBidInvitationsByProjectId($database, $project_id, $loadProjectBidInvitationsByProjectIdOptions);

    if (isset($arrProjectBidInvitationsByProjectId) && !empty($arrProjectBidInvitationsByProjectId)) {
        $fileCount = count($arrProjectBidInvitationsByProjectId);

        $html =
'
<table border="0">';
        $arrProjectBidInvitationUrls = array();
        foreach ($arrProjectBidInvitationsByProjectId as $project_bid_invitation_id => $projectBidInvitation) {
            /* @var $projectBidInvitation ProjectBidInvitation */

            $project = $projectBidInvitation->getProject();
            /* @var $project Project */

            $projectBidInvitationFileManagerFile = $projectBidInvitation->getProjectBidInvitationFileManagerFile();
            /* @var $projectBidInvitationFileManagerFile FileManagerFile */
            $project_bid_invitation_id=$projectBidInvitation->project_bid_invitation_id();
            $file_manager_file_id = $projectBidInvitationFileManagerFile->file_manager_file_id;
            $virtual_file_name = $projectBidInvitationFileManagerFile->virtual_file_name;
            //$projectBidInvitationUrl = '<a href="' . $uri->cdn . '_' . $file_manager_file_id . '" target="_blank">' . $virtual_file_name . '</a>';
            $cdnFileUrl = $projectBidInvitationFileManagerFile->generateUrl();

            $projectBidInvitationLink = <<<END_PROJECT_BID_INVITATION_LINK

    <tr id="project_container--manage-file_manager_file-record--file_manager_files--$file_manager_file_id">
        <td class="textAlignCenter verticalAlignBottom" width="1%">
            <input style="margin: 5px 0;" class="project_bid_invitation_id" type="checkbox" value="$project_bid_invitation_id">
        </td>
        <td class="textAlignLeft verticalAlignMiddle">
            <a class="textAlignLeft verticalAlignMiddle bs-tooltip" style="margin: 5px 0 6px 5px;" href="$cdnFileUrl" target="_blank" title="Select this project bid invitation to include it with correspondance.">$virtual_file_name</a>
            <a class="bs-tooltip smallerFont entypo-cancel-circled" title="Delete This Project Bid Invitation" href="javascript:deleteProjectBidInvitation(&apos;$file_manager_file_id&apos;,&apos;project_container--manage-file_manager_file-record--file_manager_files--$file_manager_file_id&apos;,&apos;manage-file_manager_file-record &apos;,'project_bid');"></a>
        </td>
    </tr>
END_PROJECT_BID_INVITATION_LINK;

            $html .= $projectBidInvitationLink;
        }

        $html .=
'
</table>';

    } else {
        $fileCount = 0;
        $html = 'No Project Bid Invitations On File';
    }

    $arrReturn = array(
        'file_count'    => $fileCount,
        'html'          => $html
    );

    return $arrReturn;
}
//renderGcBudgetLineItemsTbody
function renderGcBudgetLineItemsTbodySub($database, $user_company_id, $project_id, $cost_code_division_id_filter=null, $order_by_attribute=false, $order_by_direction=false, $scheduledValuesOnly=false, $needsBuyOutOnly=false)
{
   
    //$loadGcBudgetLineItemsByProjectIdOptions->offset = 0;
    //$loadGcBudgetLineItemsByProjectIdOptions->limit = 10;
    $loadGcBudgetLineItemsByProjectIdOptions = new Input();
    $loadGcBudgetLineItemsByProjectIdOptions->forceLoadFlag = true;
    $arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions);
    $arrAllSubcontractorBidStatuses = SubcontractorBidStatus::loadAllSubcontractorBidStatuses($database);
    $arrSubcontractorBidStatusCountsByProjectId = SubcontractorBid::loadSubcontractorBidStatusCountsByProjectId($database, $user_company_id, $project_id, $cost_code_division_id_filter);

    $gcBudgetLineItemsTbody = '';
    $primeContractScheduledValueTotal = 0.00;
    $forecastedExpensesTotal = 0.00;
    $subcontractActualValueTotal = 0.00;
    $varianceTotal = 0.00;
    $loopCounter = 1;
    $tabindex = 100;
    $tabindex2 = 200;
    foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
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
                $tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$vendorContactCompany->escaped_contact_company_name
END_HTML_CONTENT;
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
                    $tmpSubcontractVendorNameHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$contactFullName
END_HTML_CONTENT;
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
                    $tmpSubcontractVendorfaxHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$formattedFaxNumber
END_HTML_CONTENT;
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
                    $tmpSubcontractVendorMobileHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$formattedMobilePhoneNumber
END_HTML_CONTENT;
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
                if(isset($records['contact_company_office_id'])) {
                    $selected_id = $records['contact_company_office_id'];
                } else {
                    $selected_id = '';
                }
                
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
                    $tmpSubcontractVendorAddressHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address
END_HTML_CONTENT;
                }
               }

               if ($subcontractCount == 1) {
                $tmpSubcontractVendorCityHtmlInputs = $address_city;
            } elseif ($subcontractCount > 1) {
                if($address!=''){
                    $tmpSubcontractVendorCityHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address_city;
                }
            } 
            if ($subcontractCount == 1) {
                $tmpSubcontractVendorStateHtmlInputs = $address_state_or_region;
            } elseif ($subcontractCount > 1) {
                if($address!=''){
                    $tmpSubcontractVendorStateHtmlInputs = "#".$tmp_subcontract_sequence_number.')'.$address_state_or_region;
                }
            } 
            if ($subcontractCount == 1) {
                $tmpSubcontractVendorZipHtmlInputs = $address_postal_code;
            } elseif ($subcontractCount > 1) {
                if($address!=''){
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
                    $tmpSubcontractVendorMobileHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$formattedBusinessPhoneNumber
END_HTML_CONTENT;
                }
               }
               //store office fax no
                if ($subcontractCount == 1) {
                    $tmpSubcontractVendorfaxHtmlInputs = $formattedBusinessFaxNumber;
                } elseif ($subcontractCount > 1) {
                    if($formattedBusinessFaxNumber!=''){
                    $tmpSubcontractVendorfaxHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$formattedBusinessFaxNumber
END_HTML_CONTENT;
                }
               }
                //store office address
             if ($subcontractCount == 1) {
                    $tmpSubcontractVendorAddressHtmlInputs = $address;
                } elseif ($subcontractCount > 1) {
                    if($address!=''){
                    $tmpSubcontractVendorAddressHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address
END_HTML_CONTENT;
                }
               }
            }

                       //store office city
            if ($subcontractCount == 1) {
                $tmpSubcontractVendorCityHtmlInputs = $address_city;
            } elseif ($subcontractCount > 1) {
                if($address_city!=''){
                    $tmpSubcontractVendorCityHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address_city
END_HTML_CONTENT;
                }
}                //store office state
if ($subcontractCount == 1) {
    $tmpSubcontractVendorStateHtmlInputs = $address_state_or_region;
} elseif ($subcontractCount > 1) {
    if($address_state_or_region!=''){
        $tmpSubcontractVendorStateHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address_state_or_region
END_HTML_CONTENT;
    }
}                //store office zip
if ($subcontractCount == 1) {
    $tmpSubcontractVendorZipHtmlInputs = $address_postal_code;
} elseif ($subcontractCount > 1) {
    if($address_postal_code!=''){
        $tmpSubcontractVendorZipHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address_postal_code
END_HTML_CONTENT;
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
        // } //subcontract
        //vendor loop end/
        $vendorNameList = join('<br>', $arrSubcontractVendorNameHtml);
        $vendorFaxList = join('<br>', $arrSubcontractVendorfaxHtml);
        $vendorPhoneList = join('<br>', $arrSubcontractVendorMobileHtml);
        $vendorAddressList = join('<br>', $arrSubcontractVendorAddressHtml);
        //$vendorList = trim($vendorList, ' ,');
        $vendorList = join('<br>', $arrSubcontractVendorHtml);

        if ($loopCounter%2) {
            $rowStyle = 'oddRow';
        } else {
            $rowStyle = 'evenRow';
        }

        $loopCounter++;
    }
    if($arrSubcontracts)
    {
    $gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
         <tr id="record_container--manage-gc_budget_line_item-record--gc_budget_line_items--sort_order--$gc_budget_line_item_id" class="">
        <td class="textAlignLeft">
           <span style="text-transform:capitalize;">$costCodeDivision->escaped_division_number-$costCode->escaped_cost_code-$costCode->escaped_cost_code_description</span>
        </td>
        <td class="textAlignLeft">$vendorList</td>
        <td class="textAlignLeft">$vendorNameList</td>
        <td class="textAlignLeft">$vendorPhoneList</td>
        <td class="textAlignLeft">$vendorFaxList</td>
        <td class="textAlignLeft">$vendorAddressList</td>
        </tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
    }
    }
    if($gcBudgetLineItemsTbody==''){
        $gcBudgetLineItemsTbody="<tr><td colspan='6'>No Data Available for Selected Dates</td></tr>";
    }

    return $gcBudgetLineItemsTbody;
}
//current budget report
function renderCurrentBudgetReportHtml($database, $project_id, $new_begindate, $enddate, $reportType, $user_company_id){
    $project = Project::findProjectByIdExtended($database, $project_id);
    $unitCount = $project->unit_count;
    $netRentableSqFt = $project->net_rentable_square_footage;
    $loadCurrentGcBudgetLineItemIdOptions = new Input();
    $loadCurrentGcBudgetLineItemIdOptions->forceLoadFlag = true;

    $arrGcBudgetLineItems = GcBudgetLineItem::loadCurrentGcBudgetLineItems($database, $project_id, $new_begindate, $enddate, $loadCurrentGcBudgetLineItemIdOptions);
    $totalPrimeScheduleValue = 0;
    $totalEstimatedSubcontractValue = 0;
    $totalVariance = 0;
    $gcCurrentBudgetItemBody = '';
    foreach ($arrGcBudgetLineItems as $gc_budget_line_item_id => $budgetLineItem) {
      $estimatedSubcontractorAmount = 0;
      $notes = $budgetLineItem->notes;
      $costCode = $budgetLineItem->getCostCode();
      $costCodeId = $budgetLineItem->cost_code_id;
      $formattedCostCode = $costCode->getFormattedCostCodeApi($database, false, $user_company_id);

      $costCodeDescription = $costCode->cost_code_description;
      $reallocated_amt = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$costCodeId,$project_id);
      $scheduledValue = $budgetLineItem->prime_contract_scheduled_value+$reallocated_amt;
      $totalPrimeScheduleValue += $scheduledValue;
      $scheduledValueFormatted = Format::formatCurrency($scheduledValue);
        if($reportType == 'pdf' && $scheduledValue < 0){
      $scheduledValueFormatted = Format::formatCurrency(abs($scheduledValue));
            $scheduledValueFormatted = '('.$scheduledValueFormatted.')';
        }
      $totalAmount = 0;
      $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
      $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
      
      $arrSubcontracts = Subcontract::loadCurrentSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
      if(count($arrSubcontracts) > 0){
            $vendorContent = '';
            $actualValueContent = '';
            $varianceHtml = '';
            $scoHtml = '';
            $forecastedHtml = '';
            $forecastedValueHtml = '';
            $totalHtml = '';
            $totalValueHtml = '';
            $costHtml = '';
            $forecastedExpenses = $budgetLineItem->forecasted_expenses;
        $totalAmount += $forecastedExpenses;
        $forecastedExpensesFormatted = Format::formatCurrency($forecastedExpenses);
            if($reportType == 'pdf' && $forecastedExpenses < 0){
          $forecastedExpensesFormatted = Format::formatCurrency(abs($forecastedExpenses));
                $forecastedExpensesFormatted = '('.$forecastedExpensesFormatted.')';
            }
            $forecastedHtml .= <<<END_FORECAST_CONTENT
             <tr class="purStyle"><td><b>Forecasted</b></td></tr>
END_FORECAST_CONTENT;

            $forecastedValueHtml .= <<<END_FORECAST_VALUE_CONTENT
              <tr><td align="right">$forecastedExpensesFormatted</td></tr>
END_FORECAST_VALUE_CONTENT;

            $totalHtml .= <<<END_TOTAL_CONTENT
             <tr class="purStyle"><td style="border: none !important;"><b>Total</b></td></tr>
END_TOTAL_CONTENT;

        foreach ($arrSubcontracts as $subcontract) {
                $scHtml = '';
                $emptyVendorContentHtml = '';
              $subcontractAmount = 0;
          $subContractId = $subcontract->subcontract_id;
          $arrSubcontractChangeOrder = getApprovedSubcontractChangeOrder($database, $costCodeId, $project_id, $subContractId);

                $emptyCostContentHtml = '';
                if(count($arrSubcontractChangeOrder) > 0){
                    $emptyCostContentHtml .= <<<END_EMPTY_CONTENT
                    <tr><td>&nbsp;</td></tr>
END_EMPTY_CONTENT;
                }

                $emptyScoHtml = <<<END_EMPTY_CONTENT
                <tr><td>&nbsp;</td></tr>
END_EMPTY_CONTENT;
          // Vendor list
          $vendor = $subcontract->getVendor();
          $vendorContactCompany = $vendor->getVendorContactCompany();
          /* @var $vendorContactCompany ContactCompany */
          $vendorContactCompany->htmlEntityEscapeProperties();
          $vendorCompany = $vendorContactCompany->escaped_contact_company_name;

          $subcontractActualValue = $subcontract->subcontract_actual_value;
          $totalAmount += $subcontractActualValue;
          $subcontractAmount += $subcontractActualValue;
          $estimatedSubcontractorAmount += $subcontractActualValue;
          $subcontractActualValueFormatted = Format::formatCurrency($subcontractActualValue);
                if($reportType == 'pdf' && $subcontractActualValue < 0){
              $subcontractActualValueFormatted = Format::formatCurrency(abs($subcontractActualValue));
                    $subcontractActualValueFormatted = '('.$subcontractActualValueFormatted.')';
                }
                if(count($arrSubcontractChangeOrder) > 0){
                    $scoHtml .= $emptyScoHtml;
                }
                $subcontractIndexValue = 1;
        foreach ($arrSubcontractChangeOrder as $subcontractChangeOrder) {
          $approvePrefix = $subcontractChangeOrder['approve_prefix'];
          $estimatedAmount = $subcontractChangeOrder['estimated_amount'];
          $totalAmount += $estimatedAmount;
          $subcontractAmount += $estimatedAmount;
          $estimatedSubcontractorAmount += $estimatedAmount;
          $estimatedAmountFormatted = Format::formatCurrency($estimatedAmount);
                    if($reportType == 'pdf' && $estimatedAmount < 0){
                  $estimatedAmountFormatted = Format::formatCurrency(abs($estimatedAmount));
                        $estimatedAmountFormatted = '('.$estimatedAmountFormatted.')';
                    }
                    $emptyVendorContentHtml .= <<<END_EMPTY_CONTENT
                        <tr><td  style="border-bottom: none !important;">&nbsp;</td></tr>
END_EMPTY_CONTENT;

                if($subcontractIndexValue < count($arrSubcontractChangeOrder)){
                    $emptyCostContentHtml .= <<<END_EMPTY_CONTENT
                    <tr><td>&nbsp;</td></tr>
END_EMPTY_CONTENT;
        }

                $scoHtml .= <<<END_SCO_CONTENT
                    <tr><td>$approvePrefix</td></tr>
END_SCO_CONTENT;
                    $scHtml .= <<<END_SCO_CONTENT
                     <tr><td align="right">$estimatedAmountFormatted</td></tr>
END_SCO_CONTENT;
          $subcontractIndexValue++;
        }
                if(count($arrSubcontractChangeOrder) == 0){
                    $scoHtml .= <<<END_SCO_CONTENT
                    <tr><td>&nbsp;</td></tr>
END_SCO_CONTENT;
                    $scHtml .= <<<END_SCO_CONTENT
                     <!--<tr><td>&nbsp;</td></tr>-->
END_SCO_CONTENT;
                }
          $costPerSqFt = $subcontractAmount/$unitCount;
          $costPerSqFtFormatted = Format::formatCurrency($costPerSqFt);
                if($reportType == 'pdf' && $costPerSqFt < 0){
                    $costPerSqFtFormatted = Format::formatCurrency(abs($costPerSqFt));
                    $costPerSqFtFormatted = '('.$costPerSqFtFormatted.')';
                }
                $costHtml .= <<<END_COST_CONTENT
                  $emptyCostContentHtml
                 <tr><td align="right">$costPerSqFtFormatted</td></tr>
END_COST_CONTENT;

                $vendorContent .= <<<END_VENDOR_CONTENT
                  <tr><td align="left">$vendorCompany</td></tr>
                      $emptyVendorContentHtml
END_VENDOR_CONTENT;
                $actualValueContent .= <<<END_ACTUAL_VALUE_CONTENT
                 <tr><td align="right">$subcontractActualValueFormatted</td></tr>
END_ACTUAL_VALUE_CONTENT;
        if($scHtml != ''){
                    $actualValueContent .= $scHtml;
                }else{
                    $actualValueContent .= <<<END_EMPTY_CONTENT
                    <tr><td>&nbsp;</td></tr>
END_EMPTY_CONTENT;
                }
        }
            $scoHtml .= $forecastedHtml;
            $scoHtml .= $totalHtml;
            $actualValueContent .= $forecastedValueHtml;
            $totalEstimatedSubcontractValue += $totalAmount;
        $totalAmountFormatted = Format::formatCurrency($totalAmount);
            if($reportType == 'pdf' && $totalAmount < 0){
                $totalAmountFormatted = Format::formatCurrency(abs($totalAmount));
                $totalAmountFormatted = '('.$totalAmountFormatted.')';
            }
            $totalValueHtml .= <<<END_TOTAL_VALUE_CONTENT
             <tr><td align="right" style="border: none !important;">$totalAmountFormatted</td></tr>
END_TOTAL_VALUE_CONTENT;
      $actualValueContent .= $totalValueHtml;
        $variance = $scheduledValue - $totalAmount;
        $totalVariance += $variance;
        $varianceFormatted = Format::formatCurrency($variance);
            if($reportType == 'pdf' && $variance < 0){
                $varianceFormatted = Format::formatCurrency(abs($variance));
                $varianceFormatted = '('.$varianceFormatted.')';
            }
            $varianceHtml .= <<<END_VARIANCE_VALUE_CONTENT
            <div style="clear: both;overflow: hidden;">
                        <span style="border: 0px solid red; display: inline-block; text-align: right; float: right;">$varianceFormatted</span>
            </div>
END_VARIANCE_VALUE_CONTENT;
        $totalCostPerSqFt = $estimatedSubcontractorAmount/$unitCount;
        $totalCostPerSqFtFormatted = Format::formatCurrency($totalCostPerSqFt);
            if($reportType == 'pdf' && $totalCostPerSqFt < 0){
                $totalCostPerSqFtFormatted = Format::formatCurrency(abs($totalCostPerSqFt));
                $totalCostPerSqFtFormatted = '('.$totalCostPerSqFtFormatted.')';
            }
            $costHtml .= <<<END_COST_CONTENT
             <tr><td>&nbsp;</td></tr>
             <tr><td align="right" style="border: none !important;">$totalCostPerSqFtFormatted</td></tr>
END_COST_CONTENT;
        $bottomborder = '';
      } else {
        $vendorContent = '';
        $scoHtml = '';
        $actualValueContent ='';
        $costHtml='';
        $varianceHtml = '';
        $bottomborder = 'border-bottom:0 !important';
      }
    $valusse = count($arrSubcontracts);
    $styleVerticalTop = 'style="vertical-align: top"';
        $gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
        <tr>
            <td class="align-center" $styleVerticalTop>$formattedCostCode</td>
            <td class="align-left" $styleVerticalTop>$costCodeDescription</td>
            <td align="right" $styleVerticalTop>$scheduledValueFormatted</td>
            <td align="left" style="vertical-align: top;padding: 0;">
                <table class="currentBudgetNestedTable" width="100%">
                 <tbody>
                   $vendorContent
                     <tr><td style="$bottomborder border-right: none !important;border-bottom: none !important;">&nbsp;</td></tr>
                 </tbody>
                </table>
            </td>
            <td align="left" style="vertical-align: top;padding: 0">
             <table class="currentBudgetNestedTable" width="100%">
              <tbody>$scoHtml</tbody>
             </table>
          </td>
            <td align="right" style="vertical-align: top;padding: 0">
                <table class="currentBudgetNestedTable" width="100%">
                 <tbody>$actualValueContent</tbody>
                </table>
            </td>
            <td align="right">$varianceHtml</td>
            <td align="right" style="vertical-align: top;padding: 0">
                <table class="currentBudgetNestedTable" width="100%">
                 <tbody>$costHtml</tbody>
                </table>
            </td>
        </tr>
END_BUDGET_HTML_CONTENT;

    }
    $totalPrimeScheduleValueFormatted = Format::formatCurrency($totalPrimeScheduleValue);
    if($reportType == 'pdf' && $totalPrimeScheduleValue < 0){
        $totalPrimeScheduleValueFormatted = Format::formatCurrency(abs($totalPrimeScheduleValue));
        $totalPrimeScheduleValueFormatted = '('.$totalPrimeScheduleValueFormatted.')';
    }
    $totalEstimatedSubcontractValueFormatted = Format::formatCurrency($totalEstimatedSubcontractValue);
    if($reportType == 'pdf' && $totalEstimatedSubcontractValue < 0){
        $totalEstimatedSubcontractValueFormatted = Format::formatCurrency(abs($totalEstimatedSubcontractValue));
        $totalEstimatedSubcontractValueFormatted = '('.$totalEstimatedSubcontractValueFormatted.')';
    }
    $totalVarianceFormatted = Format::formatCurrency($totalVariance);
    if($reportType == 'pdf' && $totalVariance < 0){
        $totalVarianceFormatted = Format::formatCurrency(abs($totalVariance));
        $totalVarianceFormatted = '('.$totalVarianceFormatted.')';
    }

    //Fetch the change order data
    $loadChangeOrdersByProjectIdOptions = new Input();
    $loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
    $loadChangeOrdersByProjectIdOptions->change_order_type_id = 2;
    $loadChangeOrdersByProjectIdOptions->change_order_status_id = 2; //For approved
    $arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);
  if(count($arrGcBudgetLineItems) > 0){
        $title = count($arrChangeOrders) == 0 ? 'Project Totals' : 'Sub Totals';
      if($title == 'Sub Totals'){
            $titleClass = 'purStyle';
        }else{
            $titleClass = 'permissionTableMainHeader';
        }
        $gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
        <tr class="$titleClass">
            <td class="align-center"><b>$title</b></td>
            <td>&nbsp;</td>
            <td align="right"><b>$totalPrimeScheduleValueFormatted</b></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><b>$totalEstimatedSubcontractValueFormatted</b></td>
            <td align="right"><b>$totalVarianceFormatted</b></td>
            <td>&nbsp;</td>
        </tr>
END_BUDGET_HTML_CONTENT;
}
$totalCoTotalValue = 0;
$htmlContent = '';
foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
  $coTypePrefix = $changeOrder->co_type_prefix;
  // HTML Entity Escaped Data
  $changeOrder->htmlEntityEscapeProperties();
  $escapedCoTitle = $changeOrder->escaped_co_title;

  $coTotal = $changeOrder->co_total;
  $totalCoTotalValue += $coTotal;
  $coTotalFormatted = Format::formatCurrency($coTotal);
    if($reportType == 'pdf' && $coTotal < 0){
        $coTotalFormatted = Format::formatCurrency(abs($coTotal));
        $coTotalFormatted = '('.$coTotalFormatted.')';
    }
    $gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
    <tr>
        <td class="align-center">$coTypePrefix</td>
        <td class="align-left">$escapedCoTitle</td>
        <td align="right">$coTotalFormatted</td>
        <td colspan="5"></td>
    </tr>
END_BUDGET_HTML_CONTENT;
}
if(count($arrChangeOrders) > 0){
//change orders total
$coTotalValueFormatted = Format::formatCurrency($totalCoTotalValue);
if($reportType == 'pdf' && $totalCoTotalValue < 0){
    $coTotalValueFormatted = Format::formatCurrency(abs($totalCoTotalValue));
    $coTotalValueFormatted = '('.$coTotalValueFormatted.')';
}
$gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
<tr class="purStyle">
    <td class="align-left" colspan='2'><b>Approved Change Orders Total</b></td>
    <td align="right"><b>$coTotalValueFormatted</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
END_BUDGET_HTML_CONTENT;
    $projectTotal = $totalPrimeScheduleValue + $totalCoTotalValue;
    $projectTotalFormatted = Format::formatCurrency($projectTotal);
    if($reportType == 'pdf' && $projectTotal < 0){
        $projectTotalFormatted = Format::formatCurrency(abs($projectTotal));
        $projectTotalFormatted = '('.$projectTotalFormatted.')';
    }
    $gcCurrentBudgetItemBody .= <<<END_BUDGET_HTML_CONTENT
    <tr class="permissionTableMainHeader">
        <td class="align-center"><b>Project Totals</b></td>
        <td>&nbsp;</td>
        <td align="right"><b>$projectTotalFormatted</b></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><b>$totalEstimatedSubcontractValueFormatted</b></td>
        <td align="right"><b>$totalVarianceFormatted</b></td>
        <td>&nbsp;</td>
    </tr>
END_BUDGET_HTML_CONTENT;
}
 if(count($arrGcBudgetLineItems) == 0 && count($arrChangeOrders) == 0){
     $gcCurrentBudgetItemBody = <<<END_BUDGET_HTML_CONTENT
      <tr><td colspan="8">No Data Available</td></tr>
END_BUDGET_HTML_CONTENT;
 }

    $htmlContent .= <<<END_HTML_CONTENT
    <table id="currentBudgetReportUnits" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="15%">
     <tr>
      <td class="align-left"><b>Units</b></td>
        <td class="align-left">$unitCount</td>
     </tr>
     <tr>
      <td class="align-left"><b>SF</b></td>
        <td class="align-left">$netRentableSqFt</td>
     </tr>
    </table>
    <table id="currentBudgetTblTabularData" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="100%">
            <tr class="permissionTableMainHeaderTd">
        <td class="align-center" style="width:10%">Cost Code</td>
        <td class="align-center" style="width:20%;">Description</td>
        <td class="align-center" style="width:10%;">Prime Contract</td>
                <td class="align-center" style="width:20%;">Subcontracted Vendor</td>
                <td class="align-center" style="width:10%;">SCO's</td>
        <td class="align-center" style="width:10%;">Subcontract + SCO's</td>
                <td class="align-center" style="width:10%;">Variance</td>
                <td class="align-center" style="width:10%;">Cost Per Unit</td>
      </tr>
       $gcCurrentBudgetItemBody
 </table>
END_HTML_CONTENT;

  return $htmlContent;

}
// approved subcontractor
function getApprovedSubcontractChangeOrder($database, $costCodeId, $projectId, $subContractId){
 $db = DBI::getInstance($database);
 $query =
 "
 SELECT sd.*,cc.company FROM `subcontract_change_order_data` AS sd
 INNER JOIN `contact_companies` AS cc ON cc.`id` = sd.subcontract_vendor_id
 WHERE sd.`costcode_id` = ? AND sd. `project_id`= ? AND subcontractor_id=?
 AND sd.status IN ('approved')
 ";
 $arrValues = array($costCodeId, $projectId, $subContractId);
 // echo '<pre>';print_r($query);print_r($arrValues);exit;
 $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
 $arrApprovedSubcontractChangeOrder = array();
 while ($row = $db->fetch()) {
     $subcontractChangeOrder = $row['id'];
     $arrApprovedSubcontractChangeOrder[$subcontractChangeOrder] = $row;
 }
 $db->free_result();
 return $arrApprovedSubcontractChangeOrder;
}
//buyout report
function renderBuyoutReportHtml($database, $project_id, $new_begindate, $enddate, $reportType, $user_company_id){

    $loadCommittedContractsByProjectIdOptions = new Input();
    $loadCommittedContractsByProjectIdOptions->forceLoadFlag = true;

    $arrCommittedContracts = GcBudgetLineItem::loadCommittedContractsByProjectId($database, $project_id, $new_begindate, $enddate ,$loadCommittedContractsByProjectIdOptions);
    $committedTableBody = '';

    if(count($arrCommittedContracts) > 0){

        foreach ($arrCommittedContracts as $gc_budget_line_item_id => $budgetLineItem) {

            $costCode = $budgetLineItem->getCostCode();
            /* @var $costCode CostCode */
            $formattedCostCode = $costCode->getFormattedCostCodeApi($database, false, $user_company_id);
            $costCodeDescription = $costCode->cost_code_description;
            $scheduledValue = Format::formatCurrency($budgetLineItem->prime_contract_scheduled_value);

            $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
            $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
            $arrSubcontracts = Subcontract::loadCommittedSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $new_begindate, $enddate, $loadSubcontractsByGcBudgetLineItemIdOptions);
            $subContractCount = count($arrSubcontracts);
    
            $subcontractIndex = 1;

            foreach ($arrSubcontracts as $subcontract) {
                // Vendor list
                $vendor = $subcontract->getVendor();
                $vendorContactCompany = $vendor->getVendorContactCompany();
                /* @var $vendorContactCompany ContactCompany */
                $vendorContactCompany->htmlEntityEscapeProperties();
                $vendorCompany = $vendorContactCompany->escaped_contact_company_name;
                $subcontractActualValue = $subcontract->subcontract_actual_value;
                $subcontractActualValueFormatted = Format::formatCurrency($subcontractActualValue);
                if($reportType == 'pdf' && $subcontractActualValue < 0){
                    $subcontractActualValueFormatted = Format::formatCurrency(abs($subcontractActualValue));
                    $subcontractActualValueFormatted = '('.$subcontractActualValueFormatted.')';
                }

                $executionDate = $subcontract->subcontract_execution_date;
                if ($executionDate != '0000-00-00') {
                    $execution_date = date("m/d/Y", strtotime($executionDate));
                }else{
                    $execution_date = '&nbsp';
                }

                if ($subcontractIndex != $subContractCount) {
                    $committedTableBody .= <<<END_COMMITTED_TABLE_TBODY
                    <tr>
                        <td style="border-bottom: none;"></td>
                        <td style="border-bottom: none;"></td>
                        <td style="border-bottom: none;"></td>  
                        <td align="left">$vendorCompany</td>
                        <td align="right">$subcontractActualValueFormatted</td>
                        <td align="center">$execution_date</td>                         
                    </tr>
END_COMMITTED_TABLE_TBODY;
                }

                if ($subcontractIndex == $subContractCount) {
                    $committedTableBody .= <<<END_COMMITTED_TABLE_TBODY
                        <tr>
                            <td class="align-center">$formattedCostCode</td>
                            <td class="align-left">$costCodeDescription</td>
                            <td align="center">$scheduledValue</td>
                            <td align="left">$vendorCompany</td>
                            <td align="right">$subcontractActualValueFormatted</td>
                            <td align="center">$execution_date</td>
                        </tr>
END_COMMITTED_TABLE_TBODY;
                }

                $subcontractIndex++;
            }
        }
    }else{
        $committedTableBody .= <<<END_COMMITTED_TABLE_TBODY
            <tr>
                <td class="align-center" colspan='6'>No Data Available</td>
            </tr>
END_COMMITTED_TABLE_TBODY;
    }


    //Fetch uncommitted contracts Data
    $loadUncommittedContractsByProjectIdOptions = new Input();
    $loadUncommittedContractsByProjectIdOptions->forceLoadFlag = true;

    $arrUncommittedContracts = GcBudgetLineItem::loadUnCommittedContractsByProjectId($database, $project_id, $loadUncommittedContractsByProjectIdOptions);
    $uncommittedTableBody = '';

    if(count($arrUncommittedContracts) > 0){

        foreach ($arrUncommittedContracts as $gc_budget_line_item_id => $budgetLineItem) {

            $costCode = $budgetLineItem->getCostCode();
            /* @var $costCode CostCode */
            $formattedCostCode = $costCode->getFormattedCostCodeApi($database, false, $user_company_id);
            $costCodeDescription = $costCode->cost_code_description;
            $scheduledValue = $budgetLineItem->prime_contract_scheduled_value;
            $scheduledValueFormatted = Format::formatCurrency($scheduledValue);
            if($reportType == 'pdf' && $scheduledValue < 0){
                $scheduledValueFormatted = Format::formatCurrency(abs($scheduledValue));
                $scheduledValueFormatted = '('.$scheduledValueFormatted.')';
            }
            $uncommittedTableBody .= <<<END_COMMITTED_TABLE_TBODY
                <tr>
                    <td class="align-center">$formattedCostCode</td>
                    <td class="align-left">$costCodeDescription</td>
                    <td class="align-center">$scheduledValueFormatted</td>
                </tr>
END_COMMITTED_TABLE_TBODY;
        }
    }else{
        $uncommittedTableBody .= <<<END_COMMITTED_TABLE_TBODY
            <tr>
                <td class="align-center" colspan="3">No Data Available</td>
            </tr>
END_COMMITTED_TABLE_TBODY;
    }

$htmlContent .= <<<END_HTML_CONTENT
    <table id="committed_contracts_table" class="detailed_week content cell-border" border="0" cellpadding="5" cellspacing="0" width="80%">

        <tr class="permissionTableMainHeaderTd">
            <td class="align-center" style="width:10%">Cost Code</td>
            <td class="align-center" style="width:20%;">Description</td>
            <td class="align-center" style="width:10%;">Budget</td>
            <td class="align-center" style="width:20%;">Subcontract Vendor</td>
            <td class="align-center" style="width:20%;">Subcontract Actual Value</td>
            <td class="align-center" style="width:20%;">Execution Date</td>
        </tr>
        <tr>
          <td colspan="6"><b class="headsle">Committed Contracts</b></td>
        </tr>
        $committedTableBody
    </table>

    <table id="uncommitted_contracts_table" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="50%">

        <tr class="permissionTableMainHeaderTd">
            <td class="align-center" style="width:10%">Cost Code</td>
            <td class="align-center" style="width:20%;">Description</td>
            <td class="align-center" style="width:20%;">Budget</td>
        </tr>
        <tr>
            <td colspan="5"><b class="headsle">Uncommitted Contracts</b></td>
        </tr>
        $uncommittedTableBody
    </table>
END_HTML_CONTENT;

return $htmlContent;

}
// Vector report functions
function renderVectorReportHtml($database, $project_id, $user_company_id, $includegrp, $includeNotes, $includesubTotal){

    $textAlign = 'class="textAlignRight"';

    $groupdivision_completed = BidList::findBidlistByCompanyProjectId($database, $project_id, $user_company_id);
    //$includegrp  =='true'
    if($groupdivision_completed && ($includegrp  ==2 || $includegrp  ==3)){
        return 'groupdivnotmap';
    }

    $vectorreportbody = renderVectorReportTbody($database, $user_company_id, $project_id, $cost_code_division_id_filter=null, $order_by_attribute=false, $order_by_direction=false, $scheduledValuesOnly=false, $needsBuyOutOnly=false,$includegrp,$includeNotes,$includesubTotal);

    $project = Project::findProjectByIdExtended($database, $project_id);
    $OCODisplay = $project->COR_type;

    $nospan = 10;
    $ocoCol = '';
    if ($OCODisplay == 2) {
        $ocoCol = '<th nowrap width="60px">OCO</th>';
        $nospan = 11;
    }    

    /* @var $project Project */
    $unit_count = $project->unit_count;
    $net_rentable_square_footage = $project->net_rentable_square_footage;

    // <th nowrap width="60px">Cost Per Sq. Ft. <br> ($net_rentable_square_footage)</th>
    // <th nowrap width="60px">Cost Per Unit <br> ($unit_count)</th>

    $htmlContent = <<<END_HTML_CONTENT
<table id="vectorReportBudgetTable" border="0" style="border-collapse:collapse;border: 1px solid #adadad;" cellpadding="2" cellspacing="0" width="100%">
    <thead>
        <tr style="vertical-align: center;background: #0e6db6;color: #ffffff;">
            <th nowrap width="60px">Cost Code</th>
            <th nowrap width="120px">Cost Code Description</th>
            <th nowrap width="60px">Org. PSCV</th>
            <th nowrap width="60px">Reallocation</th>
            $ocoCol
            <th nowrap width="60px">Cur. Budget</th>
            <th nowrap width="60px">SCO</th>
            <th nowrap width="60px">Cur. Sub. Value</th>
            <th nowrap width="60px">Variance</th>
            <th nowrap width="60px">Cost / Sq. Ft</th>
            <th nowrap width="60px">Cost / Unit</th>
        </tr>
    </thead>
END_HTML_CONTENT;

    $htmlContent .= <<<END_HTML_CONTENT
        <tbody>               
            {$vectorreportbody}
END_HTML_CONTENT;
    return $htmlContent;
}

function renderVectorReportTbody($database, $user_company_id, $project_id, $cost_code_division_id_filter=null, $order_by_attribute=false, $order_by_direction=false, $scheduledValuesOnly=false, $needsBuyOutOnly=false,$includegrp,$includeNotes,$includesubTotal)
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
                $order_by_attribute => $order_by_direction
            );
        }
    }
    // CostCode Divider
    $costCodeDivider = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
    // Get gc budget line item
    $arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions);
    // Get cost code division count
    $costCodeDivisionCnt = GcBudgetLineItem::costCodeDivisionCountByProjectId($database, $project_id);
    // Subcontractor status
    $arrAllSubcontractorBidStatuses = SubcontractorBidStatus::loadAllSubcontractorBidStatuses($database);
    // Project primary company
    $main_company = Project::ProjectsMainCompanyApi($database, $project_id);
    // Subcontractor Bid
    $arrSubcontractorBidStatusCountsByProjectId = SubcontractorBid::loadSubcontractorBidStatusCountsByProjectId($database, $main_company, $project_id, $cost_code_division_id_filter);
    //  Inital variables
    $gcBudgetLineItemsTbody = '';
    $primeContractScheduledValueTotal = 0.00;
    $forecastedExpensesTotal = 0.00;
    $subcontractActualValueTotal = 0.00;
    $varianceTotal = 0.00;
    $loopCounter = 1;
    $tabindex = 100;
    $tabindex2 = 200;
    $sub_tot_ori_pscv = 0;
    $sub_tot_reallocation = 0;
    $sub_tot_oco = 0;
    $sub_tot_pscv = 0;
    $sub_tot_sco = 0;
    $sub_tot_crt_subcon = 0;
    $sub_tot_variance = 0;
    $sub_tot_cost_per_sq_ft = 0;
    $sub_tot_cost_per_unit = 0;
    $ioput = 1;
    $ioputIn = 1;
    $sav_raw = 0;
    $countArray = count($arrGcBudgetLineItemsByProjectId);
    $costCodePSFValueTotal = 0;
    // Cost per SF/Unit
    $project = Project::findProjectByIdExtended($database, $project_id);
    $OCODisplay = $project->COR_type;

    $nospan = "10";
    if ($OCODisplay == 2) {
        $nospan = "11";
    }
    $notesSpan = $nospan - 2;
    /* @var $project Project */
    $unit_count = $project->unit_count;
    $net_rentable_square_footage = $project->net_rentable_square_footage;
    
    if($includegrp == 2 || $includegrp  == 3){
        $gcBudgetLineGeneralcond = '<tr style="font-weight: bold; text-transform: uppercase;"><td colspan='.$nospan.' class="table-headerinner"><b>GENERAL CONDITIONS</b></td>
                </tr>';

        $gcBudgetLineSiteworks = '<tr style="font-weight: bold; text-transform: uppercase;"><td colspan='.$nospan.' class="table-headerinner"><b>SITEWORK COSTS</b></td>
                </tr>';
        $gcBudgetLinebuildingcost = '<tr style="font-weight: bold; text-transform: uppercase;"><td colspan='.$nospan.' class="table-headerinner"><b>BUILDING COSTS</b></td>
                </tr>';
        $gcBudgetLinesoftcost = '<tr style="font-weight: bold; text-transform: uppercase;"><td colspan='.$nospan.' class="table-headerinner"><b>SOFT COSTS</b></td>
                </tr>';
    } else {
        $gcBudgetLineGeneralcond = $gcBudgetLineSiteworks = $gcBudgetLinebuildingcost = $gcBudgetLinesoftcost = '';
    } 
    $gcBudgetLineSiteworksVar = $gcBudgetLinebuildingcostVar = $gcBudgetLinesoftcostVar =$gcBudgetLineGeneralcondVar =  $gcBudgetLineSiteworksOrg = $gcBudgetLinebuildingcostOrg = $gcBudgetLinesoftcostOrg =$gcBudgetLineGeneralcondOrg = $csfunit_GeneralcondVar = $csfunit_SiteworksVar = $csfunit_buildingcostVar  = $csfunit_softcostVar =  $sav_GeneralcondVar = $sav_SiteworksVar = $sav_buildingcostVar  = $sav_softcostVar = $OverallOrg  = $overall_sav = $overall_var = $overall_csfunit = $overall_cpsfunit = $cpsfunit_GeneralcondVar = $cpsfunit_SiteworksVar = $cpsfunit_buildingcostVar  = $cpsfunit_softcostVar = 0;

    $gcBudget_OriginalPSCV_GeneralcondVar = $gcBudget_OCO_GeneralcondVar = $gcBudget_reallocation_GeneralcondVar = $gcBudget_OriginalPSCV_SiteworksVar = $gcBudget_OCO_SiteworksVar = $gcBudget_reallocation_SiteworksVar = $gcBudget_OriginalPSCV_buildingcostVar = $gcBudget_OCO_buildingcostVar = $gcBudget_reallocation_buildingcostVar = $gcBudget_OriginalPSCV_softcostVar = $gcBudget_OCO_softcostVar = $gcBudget_reallocation_softcostVar = $overall_Original_PSCV = $overall_OCO_Val = $overall_Reallocation_Val = $overall_Sco_amount = $gcBudget_SCO_GeneralcondVar = $gcBudget_SCO_SiteworksVar = $gcBudget_SCO_buildingcostVar = $gcBudget_SCO_softcostVar = 0;

    foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem)
    {
        $gcBudgetsubLineItemsTbody = '';
        $cc_per_sf_unit_value = 0;
        $cc_per_sf_ft_value = 0;
        if ($scheduledValuesOnly) {
            $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
            if (!$prime_contract_scheduled_value || $prime_contract_scheduled_value == null || $prime_contract_scheduled_value == 0) {
                continue;
            }
        }
        $notes = $gcBudgetLineItem->notes;
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
        

        // prime_contract_scheduled_value
        $reallocated_amt = ChangeOrder::ReallocationInDrawsAndCOByCostCode($database,$cost_code_id,$project_id);
        $prime_contract_scheduled_value_raw = $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value+$reallocated_amt;
        
        if (isset($prime_contract_scheduled_value) && !empty($prime_contract_scheduled_value)) {
            $primeContractScheduledValueTotal += $prime_contract_scheduled_value;
            
            $prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
        } else {
            $prime_contract_scheduled_value = '$0.00';
        }

        // original PSCV value
        $originalPSCV = $gcBudgetLineItem->prime_contract_scheduled_value;
        $originalPSCVFormatted = $originalPSCV ? Format::formatCurrency($originalPSCV) : '$0.00';

        // Owner Change order value
        $ocoVal = ChangeOrder::loadSumOfCostCodeBreakDownByProjectIdAndCostCodeId($database, $cost_code_id,$project_id);
        $oco_value = $ocoVal['totalBreakdownAmount'];
        $ocoValFormatted = $oco_value ? Format::formatCurrency($oco_value) : '$0.00';

        // Reallocation value
        $reallocationVal = DrawItems::costcodeReallocated($database, $cost_code_id,$project_id);
        $reallocation_Val = round($reallocationVal['total'],2);
        $reallocationValFormatted = $reallocation_Val ? Format::formatCurrency($reallocation_Val) : '$0.00';

        if ($OCODisplay == 1) {
            $prime_contract_scheduled_value_raw = $prime_contract_scheduled_value = $originalPSCV + $reallocation_Val;
            $primeContractScheduledValueTotal += $prime_contract_scheduled_value;
            $prime_contract_scheduled_value = Format::formatCurrency($prime_contract_scheduled_value);
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
            $forecasted_expenses = '$0.00';
        }

        // buyout forecasted
        $Buyout_forecasted__raw = $buyout_forecasted = $gcBudgetLineItem->buyout_forecasted_expenses;
        
        
        if (isset($buyout_forecasted) && !empty($buyout_forecasted)) {
            $buyout_forecasted = Format::formatCurrency($buyout_forecasted);
        } else {
            $buyout_forecasted = '$0.00';
        }

        $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
        $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
        $db = DBI::getInstance($database);
        $db->free_result();
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
        $arrCCPSFValueHtml = array();
        $arrCPSFValueHtml = array();
        $arrSubcontractVendorHtml = array();
        $arrPurchasingTargetDateHtmlInputs = array();
        $total_Sco_amount = 0;

        $costrowcount=1; //To combine the notes column

        // subcontract count
        $subcontractCount = $subcontractCount+1;
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

            //To check the SCO Exists for the subcontarctor
            $resdata = SubcontractChangeOrderDataAjaxApi($database, $cost_code_id, $project_id, "all", $gc_budget_line_item_id, $tmp_subcontract_id);

           


            // Vendor list
            $vendor = $subcontract->getVendor();
            if ($vendor) {

                $vendorContactCompany = $vendor->getVendorContactCompany();
                /* @var $vendorContactCompany ContactCompany */

                $vendorContactCompany->htmlEntityEscapeProperties();

                $ocoSubcontractTd = '';
                if ($OCODisplay == 2) {
                    $ocoSubcontractTd = '<td></td>';
                }

                // $vendorList .= $vendorContactCompany->escaped_contact_company_name . ', ';
                if ($subcontractCount >= 1) {
                    $tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT
                    <tr>
                        <td style="border-top:none !important;border-bottom:none !important;"></td>
                        <td>
                             <span style="display: inline-block; font-weight: bold;">$vendorContactCompany->escaped_contact_company_name </span>
                        </td>
                        <td></td>
                        <td></td>
                        $ocoSubcontractTd
                        <td></td>
                        <td></td>
                        <td class="textAlignRight">$formattedSubcontractActualValue</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
END_HTML_CONTENT;
$costrowcount++;
                    $arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;
                    if(!empty($resdata)){
                        foreach($resdata as $eachresdata){
                        $sequencenumber = $eachresdata['sequence_number'];
                        $SCOTitle ='<span class="SCOtitData" style="display: inline-block;
    width: 180px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">'.$sequencenumber.' | '.$eachresdata['title'].'</span>';

                        $sav_raw += $eachresdata['estimated_amount_raw'];
                        $subcontract_actual_value += $eachresdata['estimated_amount_raw'];
                        $app_amount = $eachresdata['estimated_amount'];
                        $tmp_subcontract_actual_value += $eachresdata['estimated_amount_raw'];
                        $app_amount = $eachresdata['estimated_amount'];
                        $total_Sco_amount += $eachresdata['estimated_amount_raw'];
                        $tmpSubcontractVendorHtmlInputs = <<<END_HTML_CONTENT
                        <tr>
                            <td style="border-top:none !important;border-bottom:none !important;"></td>
                            <td class="textAlignRight">$SCOTitle</td>
                            <td></td>
                            <td></td>
                            $ocoSubcontractTd
                            <td></td>
                            <td class="textAlignRight">$app_amount</td>                            
                            <td class="textAlignRight">$app_amount</td> 
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
END_HTML_CONTENT;
                        $arrSubcontractVendorHtml[] = $tmpSubcontractVendorHtmlInputs;
                        $costrowcount++;
                        }
                    }

                }

            }
            $CCPSFValue = $tmp_subcontract_actual_value/$unit_count;
            $cc_per_sf_unit_value += $CCPSFValue;
            $formattedCCPSFValue = Format::formatCurrency($CCPSFValue);
           
            $CPSFValue = $tmp_subcontract_actual_value/$net_rentable_square_footage;
            $cc_per_sf_ft_value += $CPSFValue;
            $formattedCPSFValue = Format::formatCurrency($CPSFValue);
            // subcontractor loop
        }

        // subcontract actual values
        if ($subcontractCount > 1) {
            //$subcontractActualValueHtml = join('<br>', $arrSubcontractActualValueHtml);
            $subcontractActualValueHtml = join('', $arrSubcontractActualValueHtml);
            $subcontractActualValueHtml = "\n\t\t\t\t\t$subcontractActualValueHtml";
        } else {
            $subcontractActualValueHtml = '';
            if(isset($arrSubcontractActualValueHtml['0'])) {
                $subcontractActualValueHtml = $arrSubcontractActualValueHtml['0'];
            }            
        }

        // vendors
        //$vendorList = trim($vendorList, ' ,');
        $vendorList = join('', $arrSubcontractVendorHtml);
        if ($subcontractCount > 1) {
            $vendorListTdClass = ' class="verticalAlignTopImportant"';
            $vendorList = "\n\t\t\t\t\t$vendorList";
        } else {
            $vendorListTdClass = '';
        }

        if ($needsBuyOutOnly) {
            if ($subcontract_actual_value) {
                continue;
            }
        }
        // subcontract_actual_value
        $subcontractActualValueClass = '';
        $sav_raw = $subcontract_actual_value;
        if (isset($subcontract_actual_value) && !empty($subcontract_actual_value)) {
            $subcontractActualValueTotal += $subcontract_actual_value;
            $subcontract_actual_value = Format::formatCurrency($subcontract_actual_value);
        } else {
            $subcontract_actual_value = '&nbsp;';
        }
        // Cost per sf/unit actual values
        $CCPSFClass = '';
        $csfunit_raw = $cc_per_sf_unit_value;
        if (isset($cc_per_sf_unit_value) && !empty($cc_per_sf_unit_value)) {
            $costCodePSFValueTotal += $cc_per_sf_unit_value;
            $cc_per_sf_unit_value_html = Format::formatCurrency($cc_per_sf_unit_value);
        } else {
            $cc_per_sf_unit_value_html = '&nbsp;';
        }

        $cpsfunit_raw = $cc_per_sf_ft_value;
        if (isset($cc_per_sf_ft_value) && !empty($cc_per_sf_ft_value)) {
            // $costCodePerSFValueTotal += $cc_per_sf_ft_value;
            $cc_per_sf_ft_value_html = Format::formatCurrency($cc_per_sf_ft_value);
        } else {
            $cc_per_sf_ft_value_html = '&nbsp;';
        }
        // variance
        $pcsv = Data::parseFloat($prime_contract_scheduled_value_raw);
        $forecast = Data::parseFloat($forecasted_expenses_raw);
        $sav = Data::parseFloat($subcontract_actual_value_raw);
        $sav_raw = Data::parseFloat($sav_raw);
        $v_raw = $gcBudgetLineItemVariance = $pcsv - ($forecast + $sav_raw);

        $varianceTotal += $gcBudgetLineItemVariance;        
        $gcBudgetLineItemVarianceNum = $gcBudgetLineItemVariance;
        $gcBudgetLineItemVariance = Format::formatCurrency($gcBudgetLineItemVariance);

        $valueCheck = $costCodeDivisionCnt[$costCodeDivision->escaped_division_number]['division_number'];

        if($loopCounter==1) {
            $costCodeDivisionCount = 1;
        }

        if($countArray == $loopCounter-1){
            echo $loopCounter;
        }

        if ($costCodeDivisionCount == $costCodeDivisionCnt[$costCodeDivision->escaped_division_number]['count']) {
            $costCodeDivisionCount = 0;
        }

        $ocoCostCodeTd = '';
        if ($OCODisplay == 2) {
            $ocoCostCodeTd = '<td></td>';
        }
    
        $gcBudgetsubLineItemsTbody .= <<<GC_BUDGET_LINE_ITEMS_TBODY
            <tr>
                <td nowrap style="font-weight: bold;border-bottom:none !important;">&nbsp;$costCodeDivision->escaped_division_number$costCodeDivider$costCode->escaped_cost_code</td>
                <td style="text-transform: uppercase; font-weight: bold;">$costCode->escaped_cost_code_description</td>
                <td class="textAlignRight">$originalPSCVFormatted</td>
                <td class="textAlignRight">$reallocationValFormatted</td>
                $ocoCostCodeTd               
                <td class="textAlignRight">$prime_contract_scheduled_value</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
GC_BUDGET_LINE_ITEMS_TBODY;

            if ($OCODisplay == 2) {
            unset($ocoVal['totalCount']);
            unset($ocoVal['totalBreakdownAmount']);
            if (count($ocoVal)>=1)
            {
                $costrowcount= $costrowcount+count($ocoVal);
            }
            foreach ($ocoVal as $key => $value) {
                $coName = $value['co_title'];
                $coCustom = $value['co_custom_sequence_number'];
                if ($coCustom) {
                    $ocoName = '<span style="color:#06c !important;">'.$coCustom.'</span> | '.$coName;
                }else{
                    $ocoName = $coName;
                }
                $coValue = $value['cocb_cost'];
                $coValueFormatted = $coValue ? Format::formatCurrency($coValue) : '$0.00';
                // Owner change order row
                $gcBudgetsubLineItemsTbody .= <<<GC_BUDGET_LINE_ITEMS_TBODY
                    <tr>
                        <td nowrap style="border-bottom:none !important;border-top:none !important;"></td>
                        <td class="textAlignRight">$ocoName</td>
                        <td></td>
                        <td></td>
                        <td class="textAlignRight">$coValueFormatted</td>              
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
GC_BUDGET_LINE_ITEMS_TBODY;
            }
        }

        // $forecastcpsfvalue = ($forecasted_expenses_raw + $sav_raw) / $net_rentable_square_footage;
        // $forecastccpsfvalue = ($forecasted_expenses_raw + $sav_raw) / $unit_count;
        if(!empty($vendorList) ){
       
            $gcBudgetsubLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
                $vendorList
END_GC_BUDGET_LINE_ITEMS_TBODY;
        }
        if(empty($vendorList) ){
            $sav_raw = $forecasted_expenses_raw + $Buyout_forecasted__raw +  $sav_raw;

    }else
    {
            $sav_raw = $forecasted_expenses_raw +  $sav_raw;

    }
        $subcontract_actual_value = Format::formatCurrency($sav_raw);
        /*$cpsfunit_tot = $forecastcpsfvalue + $cpsfunit_raw;*/
        $forecastcpsfvalue = $forecasted_expenses_raw  / $net_rentable_square_footage;
        $forecastccpsfvalue = $forecasted_expenses_raw  / $unit_count;

        $cpsfunit_raw = $forecastcpsfvalue + $cpsfunit_raw;
        $cpsfunit_tot_format = Format::formatCurrency($cpsfunit_raw);
        /*$csfunit_tot = $forecastccpsfvalue + $csfunit_raw;
        */
        $csfunit_raw =  $forecastccpsfvalue + $csfunit_raw;
        $csfunit_tot_format = Format::formatCurrency($csfunit_raw);

        $sub_tot_ori_pscv = $sub_tot_ori_pscv + $originalPSCV;
        $sub_tot_oco = $sub_tot_oco + $oco_value;
        $sub_tot_reallocation = round(($sub_tot_reallocation + $reallocation_Val),2);
        $sub_tot_sco = $sub_tot_sco + $total_Sco_amount;
        $sub_tot_crt_subcon = $sub_tot_crt_subcon + $sav_raw;
        $sub_tot_pscv = $sub_tot_pscv + $prime_contract_scheduled_value_raw;
        $sub_tot_variance = $sub_tot_variance + $v_raw;
        $sub_tot_cost_per_sq_ft = $sub_tot_cost_per_sq_ft + $cpsfunit_raw;
        $sub_tot_cost_per_unit = $sub_tot_cost_per_unit + $csfunit_raw;

        $format_forecastcpsfvalue = Format::formatCurrency($forecastcpsfvalue);
        $format_forecastccpsfvalue = Format::formatCurrency($forecastccpsfvalue);

        $totalSCOAmountFormatted = $total_Sco_amount ? Format::formatCurrency($total_Sco_amount) : '$0.00';

        $ocoForecastTd = '';
        $ocoSubTotalTd = '';
        if ($OCODisplay == 2) {
            $ocoForecastTd = '<td></td>';
            $ocoSubTotalTd = '<td class="textAlignRight">'.$ocoValFormatted.'</td>';
        }
if($buyout_forecasted != '$0.00')
{
    $buyoutForecastRow = <<<END_OF_BUYOUT_FORECAST_ROW
    <tr>
    <td style="border-top:none !important;border-bottom:none !important;"></td>
    <td>Buyout Forecast</td>
    <td></td>
    <td></td>
    $ocoForecastTd
    <td></td>
    <td></td>
    <td class="textAlignRight">$buyout_forecasted
                    </td>
    <td class="textAlignRight"></td>
    <td class="textAlignRight">
       
    </td>
    <td class="textAlignRight">
    </td>
</tr>
END_OF_BUYOUT_FORECAST_ROW;
}else{
    $buyoutForecastRow = '';
}

        $gcBudgetsubLineItemsTbody.=  <<<GC_BUDGET_LINE_ITEMS_TBODY
            <tr>
                <td style="border-top:none !important;border-bottom:none !important;"></td>
                <td>Forecast</td>
                <td></td>
                <td></td>
                $ocoForecastTd
                <td></td>
                <td></td>
                <td class="textAlignRight">
                    <span style="float: right;">$forecasted_expenses</span>
                </td>
                <td class="textAlignRight"></td>
                <td class="textAlignRight">
                    <span style="float: right;">$format_forecastcpsfvalue</span>
                </td>
                <td class="textAlignRight">
                    <span style="float: right;">$format_forecastccpsfvalue</span>
                </td>
            </tr>
            $buyoutForecastRow
            <tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
                <td style="border-top:none !important;border-bottom:none !important;background: #ffffff;"></td>
                <td>SubTotal</td>
                <td class="textAlignRight">$originalPSCVFormatted</td>
                <td class="textAlignRight">$reallocationValFormatted</td>
                $ocoSubTotalTd
                <td class="textAlignRight">$prime_contract_scheduled_value</td>
                <td class="textAlignRight">$totalSCOAmountFormatted</td>
                <td class="textAlignRight">
                    <div style="clear: right;" class="$subcontractActualValueClass">$subcontract_actual_value</div>
                </td>
                <td class="textAlignRight">$gcBudgetLineItemVariance</td>
                <td class="textAlignRight">
                    <div style="clear: right;" class="$CCPSFClass">$cpsfunit_tot_format</div>
                </td>
                <td class="textAlignRight">
                    <div style="border: 0px solid black; clear: right;" class="$CCPSFClass">$csfunit_tot_format</div>
                </td>
            </tr>
GC_BUDGET_LINE_ITEMS_TBODY;

    if ($includeNotes == "true" && $notes != '') {
        $notes = nl2br($notes);
        $gcBudgetsubLineItemsTbody.=  <<<GC_BUDGET_LINE_ITEMS_TBODY
            <tr>
                <td style="border-top:none !important;"></td>
                <td style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">Notes :</td>
                <td colspan='$notesSpan'>$notes</td>
            </tr>
GC_BUDGET_LINE_ITEMS_TBODY;
    }

        if($costCodeDivisionCount == 0 && $includesubTotal == "true"){

            $sub_tot_ori_pscv = Format::formatCurrency($sub_tot_ori_pscv);
            $sub_tot_reallocation = Format::formatCurrency($sub_tot_reallocation);
            $sub_tot_oco = Format::formatCurrency($sub_tot_oco);
            $sub_tot_pscv = Format::formatCurrency($sub_tot_pscv);
            $sub_tot_sco = Format::formatCurrency($sub_tot_sco);
            $sub_tot_crt_subcon = Format::formatCurrency($sub_tot_crt_subcon);
            $sub_tot_variance = Format::formatCurrency($sub_tot_variance);
            $sub_tot_cost_per_sq_ft = Format::formatCurrency($sub_tot_cost_per_sq_ft);
            $sub_tot_cost_per_unit = Format::formatCurrency($sub_tot_cost_per_unit);

            $ocoCostCodeSubTd = '';
            if ($OCODisplay == 2) {
                $ocoCostCodeSubTd = '<td class="textAlignRight">'.$sub_tot_oco.'</td>';
            }

            $subTotalNumericWise = <<<Table_subtotal
            <tr style="background: #9f9e9e;text-transform: uppercase;font-weight:bold;">
                <td class="textAlignCenter">$valueCheck</td>
                <td>Subtotal</td>
                <td class="textAlignRight">$sub_tot_ori_pscv</td>
                <td class="textAlignRight">$sub_tot_reallocation</td>
                $ocoCostCodeSubTd
                <td class="textAlignRight">$sub_tot_pscv</td>
                <td class="textAlignRight">$sub_tot_sco</td>
                <td class="textAlignRight">$sub_tot_crt_subcon</td>
                <td class="textAlignRight">$sub_tot_variance</td>
                <td class="textAlignRight">$sub_tot_cost_per_sq_ft</td>
                <td class="textAlignRight">$sub_tot_cost_per_unit</td>
            </tr>
Table_subtotal;
            $gcBudgetsubLineItemsTbody .= $subTotalNumericWise;
            $subTotalNumericWise;
            $sub_tot_ori_pscv = 0;
            $sub_tot_reallocation = 0;
            $sub_tot_oco = 0;
            $sub_tot_pscv = 0;
            $sub_tot_sco = 0;
            $sub_tot_crt_subcon = 0;
            $sub_tot_variance = 0;
            $sub_tot_cost_per_sq_ft = 0;
            $sub_tot_cost_per_unit = 0;
            $ioputIn = 1;
        }

        $OverallOrg += $prime_contract_scheduled_value_raw;
        $overall_sav += $sav_raw;
        $overall_var += $gcBudgetLineItemVarianceNum;
        $overall_csfunit += $csfunit_raw;
        $overall_cpsfunit += $cpsfunit_raw;
        $overall_Original_PSCV += $originalPSCV;
        $overall_OCO_Val += $oco_value;
        $overall_Reallocation_Val = round(($overall_Reallocation_Val + $reallocation_Val),2);
        $overall_Sco_amount += $total_Sco_amount;
        if($includegrp == 2 || $includegrp == 3 ){
            if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='1'){
                if($includegrp == 3){
                    $gcBudgetsubLineItemsTbody = '';
                }
                $gcBudgetLineGeneralcond .= $gcBudgetsubLineItemsTbody; 
                $gcBudgetLineGeneralcondVar += $gcBudgetLineItemVarianceNum;
                $gcBudgetLineGeneralcondOrg += $prime_contract_scheduled_value_raw;
                $csfunit_GeneralcondVar += $csfunit_raw;
                $cpsfunit_GeneralcondVar += $cpsfunit_raw;
                $sav_GeneralcondVar += $sav_raw;
                $gcBudget_OriginalPSCV_GeneralcondVar += $originalPSCV;
                $gcBudget_OCO_GeneralcondVar += $oco_value;
                $gcBudget_reallocation_GeneralcondVar = round(($gcBudget_reallocation_GeneralcondVar + $reallocation_Val),2);
                $gcBudget_SCO_GeneralcondVar += $total_Sco_amount;
                    
            }else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='2'){
                $gcBudgetLineSiteworks .= $gcBudgetsubLineItemsTbody; 
                $gcBudgetLineSiteworksVar += $gcBudgetLineItemVarianceNum;
                $gcBudgetLineSiteworksOrg += $prime_contract_scheduled_value_raw;
                $csfunit_SiteworksVar += $csfunit_raw;
                $cpsfunit_SiteworksVar += $cpsfunit_raw;
                $sav_SiteworksVar += $sav_raw;
                $gcBudget_OriginalPSCV_SiteworksVar += $originalPSCV;
                $gcBudget_OCO_SiteworksVar += $oco_value;
                $gcBudget_reallocation_SiteworksVar = round(($gcBudget_reallocation_SiteworksVar + $reallocation_Val),2);
                $gcBudget_SCO_SiteworksVar += $total_Sco_amount;
            }else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='3'){
                $gcBudgetLinebuildingcost .= $gcBudgetsubLineItemsTbody; 
                $gcBudgetLinebuildingcostVar += $gcBudgetLineItemVarianceNum;
                $gcBudgetLinebuildingcostOrg += $prime_contract_scheduled_value_raw;
                $csfunit_buildingcostVar += $csfunit_raw;
                $cpsfunit_buildingcostVar += $cpsfunit_raw;
                $sav_buildingcostVar += $sav_raw;
                $gcBudget_OriginalPSCV_buildingcostVar += $originalPSCV;
                $gcBudget_OCO_buildingcostVar += $oco_value;
                $gcBudget_reallocation_buildingcostVar = round(($gcBudget_reallocation_buildingcostVar + $reallocation_Val),2);
                $gcBudget_SCO_buildingcostVar += $total_Sco_amount;
            }else if(!empty($costCodeDivision->division_number_group_id) && $costCodeDivision->division_number_group_id =='4'){
                $gcBudgetLinesoftcost .= $gcBudgetsubLineItemsTbody; 
                $gcBudgetLinesoftcostVar += $gcBudgetLineItemVarianceNum;
                $gcBudgetLinesoftcostOrg += $prime_contract_scheduled_value_raw;
                $csfunit_softcostVar += $csfunit_raw;
                $sav_softcostVar += $sav_raw;
                $cpsfunit_softcostVar += $cpsfunit_raw;
                $gcBudget_OriginalPSCV_softcostVar += $originalPSCV;
                $gcBudget_OCO_softcostVar += $oco_value;
                $gcBudget_reallocation_softcostVar = round(($gcBudget_reallocation_softcostVar+$reallocation_Val),2);
                $gcBudget_SCO_softcostVar += $total_Sco_amount;
            }
        }else{
            $gcBudgetLineGeneralcond .= $gcBudgetsubLineItemsTbody; 
            $gcBudgetLineGeneralcondVar += $gcBudgetLineItemVarianceNum;
            $gcBudgetLineGeneralcondOrg += $prime_contract_scheduled_value_raw;
            $csfunit_GeneralcondVar += $csfunit_raw;
            $cpsfunit_GeneralcondVar += $cpsfunit_raw;
            $sav_GeneralcondVar += $sav_raw;
            $gcBudget_OriginalPSCV_GeneralcondVar += $originalPSCV;
            $gcBudget_OCO_GeneralcondVar += $oco_value;
            $gcBudget_reallocation_GeneralcondVar = round(($gcBudget_reallocation_GeneralcondVar + $reallocation_Val),2);
            $gcBudget_SCO_GeneralcondVar += $total_Sco_amount;
        }
        $loopCounter++;
        $tabindex++;
        $costCodeDivisionCount++;
        $tabindex2++;
        $ioputIn++;
        // end loop
    }
    $gcBudgetLineGeneralcondVar = Format::formatCurrency($gcBudgetLineGeneralcondVar);
    $gcBudgetLineSiteworksVar = Format::formatCurrency($gcBudgetLineSiteworksVar);
    $gcBudgetLinebuildingcostVar = Format::formatCurrency($gcBudgetLinebuildingcostVar);
    $gcBudgetLinesoftcostVar = Format::formatCurrency($gcBudgetLinesoftcostVar);


    $gcBudgetLineSiteworksOrg = Format::formatCurrency($gcBudgetLineSiteworksOrg);
    $gcBudgetLinebuildingcostOrg = Format::formatCurrency($gcBudgetLinebuildingcostOrg);
    $gcBudgetLinesoftcostOrg = Format::formatCurrency($gcBudgetLinesoftcostOrg);
    $gcBudgetLineGeneralcondOrg = Format::formatCurrency($gcBudgetLineGeneralcondOrg);

    $csfunit_GeneralcondVar = Format::formatCurrency($csfunit_GeneralcondVar);
    $csfunit_SiteworksVar = Format::formatCurrency($csfunit_SiteworksVar);
    $csfunit_buildingcostVar = Format::formatCurrency($csfunit_buildingcostVar);
    $csfunit_softcostVar = Format::formatCurrency($csfunit_softcostVar);


    $cpsfunit_GeneralcondVar = Format::formatCurrency($cpsfunit_GeneralcondVar);
    $cpsfunit_SiteworksVar = Format::formatCurrency($cpsfunit_SiteworksVar);
    $cpsfunit_buildingcostVar = Format::formatCurrency($cpsfunit_buildingcostVar);
    $cpsfunit_softcostVar = Format::formatCurrency($cpsfunit_softcostVar);

    $sav_GeneralcondVar = Format::formatCurrency($sav_GeneralcondVar);
    $sav_SiteworksVar = Format::formatCurrency($sav_SiteworksVar);
    $sav_buildingcostVar  = Format::formatCurrency($sav_buildingcostVar);
    $sav_softcostVar = Format::formatCurrency($sav_softcostVar);

    $gcBudget_OriginalPSCV_GeneralcondVar = Format::formatCurrency($gcBudget_OriginalPSCV_GeneralcondVar);
    $gcBudget_OCO_GeneralcondVar = Format::formatCurrency($gcBudget_OCO_GeneralcondVar);
    $gcBudget_reallocation_GeneralcondVar = Format::formatCurrency($gcBudget_reallocation_GeneralcondVar);
    $gcBudget_SCO_GeneralcondVar = Format::formatCurrency($gcBudget_SCO_GeneralcondVar);

    $gcBudget_OriginalPSCV_SiteworksVar = Format::formatCurrency($gcBudget_OriginalPSCV_SiteworksVar);
    $gcBudget_OCO_SiteworksVar = Format::formatCurrency($gcBudget_OCO_SiteworksVar);
    $gcBudget_reallocation_SiteworksVar = Format::formatCurrency($gcBudget_reallocation_SiteworksVar);
    $gcBudget_SCO_SiteworksVar = Format::formatCurrency($gcBudget_SCO_SiteworksVar);

    $gcBudget_OriginalPSCV_buildingcostVar = Format::formatCurrency($gcBudget_OriginalPSCV_buildingcostVar);
    $gcBudget_OCO_buildingcostVar = Format::formatCurrency($gcBudget_OCO_buildingcostVar);
    $gcBudget_reallocation_buildingcostVar = Format::formatCurrency($gcBudget_reallocation_buildingcostVar);
    $gcBudget_SCO_buildingcostVar = Format::formatCurrency($gcBudget_SCO_buildingcostVar);

    $gcBudget_OriginalPSCV_softcostVar = Format::formatCurrency($gcBudget_OriginalPSCV_softcostVar);
    $gcBudget_OCO_softcostVar = Format::formatCurrency($gcBudget_OCO_softcostVar);
    $gcBudget_reallocation_softcostVar = Format::formatCurrency($gcBudget_reallocation_softcostVar);
    $gcBudget_SCO_softcostVar = Format::formatCurrency($gcBudget_SCO_softcostVar);

    $ocoGeneralcondVarTd = '';
    $ocoSiteworksVarTd = '';
    $ocobuildingcostVarTd = '';
    $ocosoftcostVarTd = '';
    if ($OCODisplay == 2) {
        $ocoGeneralcondVarTd = '<td align="right">'.$gcBudget_OCO_GeneralcondVar.'</td>';
        $ocoSiteworksVarTd = '<td align="right">'.$gcBudget_OCO_SiteworksVar.'</td>';
        $ocobuildingcostVarTd = '<td align="right">'.$gcBudget_OCO_buildingcostVar.'</td>';
        $ocosoftcostVarTd = '<td align="right">'.$gcBudget_OCO_softcostVar.'</td>';
    }

    if($includegrp == 2 || $includegrp == 3){
     $gcBudgetLineGeneraltot = <<<GC_BUDGET_LINE_ITEMS_TBODY
        <tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
            <td colspan="2" align="right">TOTAL GENERAL CONDITIONS</td>
            <td align="right">$gcBudget_OriginalPSCV_GeneralcondVar</td>
            <td align="right">$gcBudget_reallocation_GeneralcondVar</td>
            $ocoGeneralcondVarTd
            <td align="right">$gcBudgetLineGeneralcondOrg</td>
            <td align="right">$gcBudget_SCO_GeneralcondVar</td>
            <td align="right">$sav_GeneralcondVar</td>
            <td align="right">$gcBudgetLineGeneralcondVar</td>
            <td align="right">$cpsfunit_GeneralcondVar</td>
            <td align="right">$csfunit_GeneralcondVar</td>               
        </tr>              
GC_BUDGET_LINE_ITEMS_TBODY;
    } else {
        $gcBudgetLineGeneraltot = '';
    }
    if($includegrp == 2 || $includegrp == 3){
        $gcBudgetLineSiteworkstot = <<<GC_BUDGET_LINE_ITEMS_TBODY
        <tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
            <td colspan="2" align="right">TOTAL SITEWORK COSTS</td>
            <td align="right">$gcBudget_OriginalPSCV_SiteworksVar</td>
            <td align="right">$gcBudget_reallocation_SiteworksVar</td>
            $ocoSiteworksVarTd
            <td align="right">$gcBudgetLineSiteworksOrg</td>
            <td align="right">$gcBudget_SCO_SiteworksVar</td>
            <td align="right">$sav_SiteworksVar</td>
            <td align="right">$gcBudgetLineSiteworksVar</td>
            <td align="right">$cpsfunit_SiteworksVar</td>
            <td align="right">$csfunit_SiteworksVar</td>
        </tr>              
GC_BUDGET_LINE_ITEMS_TBODY;
        $gcBudgetLinebuildingcosttot = <<<GC_BUDGET_LINE_ITEMS_TBODY
        <tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
            <td colspan="2" align="right">TOTAL BUILDING COSTS</td>
            <td align="right">$gcBudget_OriginalPSCV_buildingcostVar</td>
            <td align="right">$gcBudget_reallocation_buildingcostVar</td>
            $ocobuildingcostVarTd
            <td align="right">$gcBudgetLinebuildingcostOrg</td>
            <td align="right">$gcBudget_SCO_buildingcostVar</td>
            <td align="right">$sav_buildingcostVar</td>
            <td align="right">$gcBudgetLinebuildingcostVar</td>
            <td align="right">$cpsfunit_buildingcostVar</td>
            <td align="right">$csfunit_buildingcostVar</td>
        </tr>              
GC_BUDGET_LINE_ITEMS_TBODY;
        $gcBudgetLinesoftcosttot  = <<<GC_BUDGET_LINE_ITEMS_TBODY
        <tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
            <td colspan="2" align="right">TOTAL SOFT COSTS</td>
            <td align="right">$gcBudget_OriginalPSCV_softcostVar</td>
            <td align="right">$gcBudget_reallocation_softcostVar</td>
            $ocosoftcostVarTd 
            <td align="right">$gcBudgetLinesoftcostOrg</td>
            <td align="right">$gcBudget_SCO_softcostVar</td>
            <td align="right">$sav_softcostVar</td>
            <td align="right">$gcBudgetLinesoftcostVar</td>
            <td align="right">$cpsfunit_softcostVar</td>
            <td align="right">$csfunit_softcostVar</td>
        </tr>             
GC_BUDGET_LINE_ITEMS_TBODY;

$stylefix = $stylefix1 = '';

// $stylefix = <<<GC_BUDGET_LINE_ITEMS_TBODY
//             <tr>
//                 <td colspan="7" style="border-bottom: 1px solid black;"></td>
//             </tr>
// GC_BUDGET_LINE_ITEMS_TBODY;
// $stylefix1 = <<<GC_BUDGET_LINE_ITEMS_TBODY
//             <tr>
//                 <td colspan="7" style="border-top: 1px solid black;"></td>
//             </tr>
// GC_BUDGET_LINE_ITEMS_TBODY;
    } else {
        $stylefix = $gcBudgetLineSiteworkstot = $gcBudgetLinebuildingcosttot  = $gcBudgetLinesoftcosttot = $stylefix1 = '';
    }
    $gcBudgetLineItemsTbody = $gcBudgetLineGeneralcond.$stylefix.$gcBudgetLineGeneraltot.$stylefix1.$gcBudgetLineSiteworks.$stylefix.$gcBudgetLineSiteworkstot.$stylefix1.$gcBudgetLinebuildingcost.$stylefix.$gcBudgetLinebuildingcosttot.$stylefix1.$gcBudgetLinesoftcost.$stylefix.$gcBudgetLinesoftcosttot.$stylefix1;

    $totalPrimeSchedule = $OverallOrg;

    $OverallOrg = Format::formatCurrency($OverallOrg);
    $overall_sav = Format::formatCurrency($overall_sav);
    $overall_var  = Format::formatCurrency($overall_var);
    $overall_csfunit = Format::formatCurrency($overall_csfunit);
    $overall_cpsfunit = Format::formatCurrency($overall_cpsfunit);
    $overall_Original_PSCV = Format::formatCurrency($overall_Original_PSCV);
    $overall_OCO_Val = Format::formatCurrency($overall_OCO_Val);
    $overall_Reallocation_Val = Format::formatCurrency($overall_Reallocation_Val);
    $overall_Sco_amount = Format::formatCurrency($overall_Sco_amount);

    $ocoOverallTd = '';
    if ($OCODisplay == 2) {
        $ocoOverallTd = '<td align="right">'.$overall_OCO_Val.'</td>';
    }

    $projectSumarry = <<<GC_BUDGET_LINE_ITEMS_TBODY
        <tr style="font-weight: bold; text-transform: uppercase;"><td colspan="$nospan" class="table-headerinner" ><b>Project Summary</b></td>
        </tr>
            $gcBudgetLineGeneraltot 
            $gcBudgetLineSiteworkstot
            $gcBudgetLinebuildingcosttot
            $gcBudgetLinesoftcosttot
        <tr style="background: #d9d9d9;text-transform: uppercase;font-weight:bold;">
            <td colspan="2" align="right">Total Project Costs</td>
            <td align="right">$overall_Original_PSCV</td>
            <td align="right">$overall_Reallocation_Val</td>
            $ocoOverallTd
            <td align="right">$OverallOrg</td>
            <td align="right">$overall_Sco_amount</td>
            <td align="right">$overall_sav</td>
            <td align="right">$overall_var</td>
            <td align="right">$overall_cpsfunit</td>
            <td align="right">$overall_csfunit</td>          
        </tr>
        $stylefix1
GC_BUDGET_LINE_ITEMS_TBODY;

$gcBudgetLineItemsTbody .= $projectSumarry;

    
    $primeContractScheduledValueTotal = Format::formatCurrency($primeContractScheduledValueTotal);
    
if ($OCODisplay == 2) {
$tablesub = <<<Table_subtotal
        </tbody>
    </table>
Table_subtotal;
$gcBudgetLineItemsTbody .= $tablesub;
}

if ($OCODisplay == 1) {
    $fillerColumns = '';
    $gcBudgetCORTbody = renderCORforBudgetListVector($database, $project_id, $totalPrimeSchedule, $fillerColumns, $user_company_id,$includeNotes);
    $gcBudgetLineItemsTbody .= $gcBudgetCORTbody;
}
    return $gcBudgetLineItemsTbody;
}
// COR list
function renderCORforBudgetListVector($database, $project_id, $primeContractScheduledValueTotal, $fillerColumns, $user_company_id,$includeNotes)
{
    $db = DBI::getInstance($database);
    $db->free_result();
    $loadChangeOrdersByProjectIdOptions = new Input();
    $loadChangeOrdersByProjectIdOptions->forceLoadFlag = true;
    $loadChangeOrdersByProjectIdOptions->change_order_type_id = 2;
    $loadChangeOrdersByProjectIdOptions->change_order_status_id = 2; //For approved 
    $totalCORs = ChangeOrder::loadChangeOrdersCountByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);

    if ($totalCORs == 0) {
        return '';
    }
    $arrChangeOrders = ChangeOrder::loadChangeOrdersByProjectId($database, $project_id, $loadChangeOrdersByProjectIdOptions);
    $nospan=2;
    $coTableTbody = '
            <tr class="table-headerinner" style="vertical-align: center;">
                <th>Custom</th>
                <th>COR</th>
                <th colspan="3">Title</th>
                <th>Amount</th>
                <th>Created Date</th>
                <th>Days</th>
                <th colspan='.$nospan.'>Reason</th>
            </tr>
        ';
    $sum_co_total =0;
    foreach ($arrChangeOrders as $change_order_id => $changeOrder) {
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
        $co_total =$changeOrder->co_total;
        $co_type_prefix= $changeOrder->co_type_prefix;
        $co_custom_sequence_number= $changeOrder->co_custom_sequence_number;

        // HTML Entity Escaped Data
        $changeOrder->htmlEntityEscapeProperties();
        $escaped_co_custom_sequence_number = $changeOrder->escaped_co_custom_sequence_number;
        $escaped_co_plan_page_reference = $changeOrder->escaped_co_plan_page_reference;
        $escaped_co_statement = $changeOrder->escaped_co_statement;
        $escaped_co_statement_nl2br = $changeOrder->escaped_co_statement_nl2br;
        $escaped_co_title = $changeOrder->escaped_co_title;

        if (empty($escaped_co_custom_sequence_number)) {
            $escaped_co_custom_sequence_number = $co_sequence_number;
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

            $formattedCoCostCode = $coCostCode->getFormattedCostCodeApi($database, false, $user_company_id);

            $coCostCode->htmlEntityEscapeProperties();
            $escaped_cost_code_description = $coCostCode->escaped_cost_code_description;

            //$htmlEntityEscapedFormattedCoCostCodeLabel = $coCostCode->getHtmlEntityEscapedFormattedCostCode();
        } else {
            $formattedCoCostCode = '&nbsp;';
            $escaped_cost_code_description = '';
        }

        //$recipient = Contact::findContactByIdExtended($database, $co_recipient_contact_id);
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
        //$openDateDisplayString = date('n/j/Y g:ma');
        $oneDayInSeconds = 86400;
        $daysOpen = '';

        //$formattedCoCreatedDate = date("m/d/Y g:i a", $openDateUnixTimestamp);
        $formattedCoCreatedDate = date("m/d/Y", $openDateUnixTimestamp);

        // change_order_statuses:
        $change_order_status = $changeOrderStatus->change_order_status;
        // if Change Order status is "closed"
        if (!$co_closed_date) {
            $co_closed_date = '0000-00-00';
        }
        if (($change_order_status == 'Approved') && ($co_closed_date <> '0000-00-00')) {
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
        $sum_co_total=$sum_co_total+$co_total;

        $co_total = Format::formatCurrency($co_total);
        $rspan =4;
        $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY

        <tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="">
            <td nowrap align="left">$co_custom_sequence_number</td>  
            <td nowrap >$co_type_prefix</td> 
            <td colspan="3">$escaped_co_title</td>
            <td class="autosum-cosv" align="right">$co_total</td>
            <td align="right">$formattedCoCreatedDate</td>
            <td align="right">$co_delay_days</td>
            <td colspan="2">$change_order_priority</td>         
        </tr>
END_CHANGE_ORDER_TABLE_TBODY;

    }
    $budget_total =$primeContractScheduledValueTotal+$sum_co_total;
    $sum_co_total =Format::formatCurrency($sum_co_total);
    $budget_total =Format::formatCurrency($budget_total);

    $coTableTbody .= <<<END_CHANGE_ORDER_TABLE_TBODY
        <tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="bottom-content" style="border-top: 1px solid black;">
            <td colspan='5' align='right'><b>Approved Change Orders Total</b> </td>
            <td  align='right'><b>$sum_co_total</b> </td>
            <td colspan='$rspan' ></td>
        </tr>
        <tr id="record_container--manage-change_order-record--change_orders--$change_order_id" class="bottom-content"  style="border-top: 1px solid black;background: #d9d9d9;font-weight:bold;">
            <td colspan='5' align='right'><b>Revised budget Total</b></td>
            <td align='right' ><b>$budget_total</b></td>
            <td colspan='$rspan' > </td>
        </tr>
        </tbody>
        </table>
END_CHANGE_ORDER_TABLE_TBODY;
    return $coTableTbody;
}
//To check the subcontract change order data exist for a cost code
 function SubcontractChangeOrderDataApi($database, $cost_code_id,$project_id,$filter='all',$gc_budget_line_item_id=null,$subcontract_id)
 {
    $db = DBI::getInstance($database);
    $query1 = "SELECT sd.*,cc.company FROM `subcontract_change_order_data` as sd inner join `contact_companies` as cc on cc.`id` = sd.subcontract_vendor_id WHERE sd.`costcode_id` = '$cost_code_id' and sd. `project_id`= '$project_id' and subcontractor_id='$subcontract_id' and sd.status IN ('approved','potential') order by sd.status ASC, CAST(SUBSTR(approve_prefix , 5, LENGTH(approve_prefix)) AS UNSIGNED) ASC";
 
    $db->execute($query1);
    $subOrderData=array();
    $poptitle = '';
    while ($row1 = $db->fetch()){
        $subOrderData[]=$row1;
        $poptitle = $row1['costcode_data'];
    }
    $totcount=count($subOrderData);

    //Subcontractor budget module data
    $db = DBI::getInstance($database);
    $query2 = "SELECT * FROM `gc_budget_line_items` WHERE `project_id` = '$project_id' AND `cost_code_id` = $cost_code_id ";
    $db->execute($query2);
        $row2 = $db->fetch();
        $scheduled_value=Format::formatCurrency($row2['prime_contract_scheduled_value']);
        $foreExp = Format::formatCurrency($row2['forecasted_expenses']);
        $db->free_result();


    $db = DBI::getInstance($database);
    $query3 = "SELECT cc.company,s.subcontract_actual_value ,s.* FROM `subcontracts` as s INNER Join vendors as v on s.vendor_id= v.id Inner JOIN contact_companies as cc ON v.vendor_contact_company_id =cc.id WHERE `gc_budget_line_item_id` = '$gc_budget_line_item_id' and s.id='$subcontract_id' ";
    $db->execute($query3);
    $budgetsubData=array();

        while ($row3 = $db->fetch()){
            $budgetsubData[] = $row3;
        }
    $db->free_result();
    $subActual = '';
    $subconData='';
    $subActtotal=0;
    $k=1;
    foreach ($budgetsubData as $budgetData) {
        $subid = $budgetData['id'];
        $subtable = GenActualOriginalValueApi($database,$cost_code_id,$project_id,$subid);
        $subAmt =$budgetData['subcontract_actual_value'] ;
        $subActtotal +=$subAmt; //Total

        $subAmt = Format::formatCurrency($subAmt);

        $subActual .= "<p class='textAlignLeft'><span>$k)</span><span style='float:right;'> ".$subAmt."</span></p>";
        $subconData .= "<p>$k) ".$budgetData['company']."</p>";
        $k++;

    }
    // variance
        $pcsv = Data::parseFloat($scheduled_value);
        $forecast = Data::parseFloat($foreExp);
        $sav = Data::parseFloat($subActtotal);
        $gcBudgetLineItemVariance=$v_raw =  $pcsv - ($forecast + $sav);
        if ($gcBudgetLineItemVariance < 0) {
            $VarianceClass = 'color: red;';
        } else {
            $VarianceClass = '';
        }
   $v_raw = Format::formatCurrency($v_raw);
   $subActtotal = Format::formatCurrency($subActtotal);
   // $subActual .="<p>".$subActtotal."</p>";


    $resTable="<div class=''> 
    <div class='modal-header'><b>$poptitle</b><span style='line-height: 17px;' class='close' onclick='closePopover($subcontract_id);'>×</span></div>
    <table width='650' border='0' class='drop-inner'>
    <tr><th colspan='2' width='50%'>Cost Code & Description</th>
    <th>Prime Contract <br>Schedule Value</th>
    <th>Forecasted <br> Expenses</th>
    <th>Subcontractor <br>Actual Value</th>

    <tr><td class='cosmalink_section' colspan='2'>$poptitle</td>
    <td class='textAlignRight'>$scheduled_value</td>
    <td class='textAlignRight'>$foreExp</td>
    <td class='textAlignRight'>$subActual</td>

   
    <tr><th width='10%'>SCO</th>
    <th width='40%'>Title</th>
    <th>Description</th>
    <th>Potential CO</th>
    <th>SCO Approved Value</th>
    
   
    </tr>";
    foreach ($subOrderData as $dataVal) {
        $sequence_number    =$dataVal['sequence_number'];
        $title              =$dataVal['title'];
        $description        =$dataVal['description'];
        $estimated_amount   = Format::formatCurrency($dataVal['estimated_amount']);
        $status_notes       =$dataVal['status_notes'];
        $company            =$dataVal['company'];
        $status             =$dataVal['status'];
        if($status=='approved')
        {
            $sequence_number    =$dataVal['approve_prefix'];
            $appAmt=$estimated_amount;
            $otherAmt='';
        }else
        {
            $otherAmt=$estimated_amount;
            $appAmt='';
        }



        $resTable .="<tr><td class=textAlignCenter>$sequence_number</td>
                <td>$title</td>
                <td>$description</td>
                <td class='textAlignRight' style='color:#009DD9;'>$otherAmt</td>
                <td class='textAlignRight' style='color:#009DD9;'>$appAmt</td>
                </tr>";
    }
    //for approved
        $arrReturn=subcontractTotagainstCostCodePositionApi($database, $cost_code_id,$project_id,$subcontract_id,"'approved'"); 
        $statePos =$arrReturn['count'];
        $tot_estimate  =$arrReturn['estimated_amount'];
        //for potential
        $arrReturnpot=subcontractTotagainstCostCodePositionApi($database, $cost_code_id,$project_id,$subcontract_id,"'potential'"); 
        $statePospot =$arrReturnpot['count'];
        $pot_estimate  =$arrReturnpot['estimated_amount'];
     $resTable .="<tr><td colspan='2'></td><td ><b> SCO Total</b> </td><td class='textAlignRight' style='color:#009DD9;'> $pot_estimate </td><td class='textAlignRight' style='color:#009DD9;'> $tot_estimate </td><td></td></tr>";
   $resTable .= "</table></div>";
    if($filter == "count")
    {
        return $totcount;
    }else
    {

    return $resTable;
    }
 }
// To Get the SubContract Change Order Data 
function SubcontractChangeOrderDataAjaxApi($database, $cost_code_id,$project_id,$filter='all',$gc_budget_line_item_id=null,$subcontract_id)
 {
    $db = DBI::getInstance($database);
    $query1 = "SELECT sd.*,cc.company FROM `subcontract_change_order_data` as sd inner join `contact_companies` as cc on cc.`id` = sd.subcontract_vendor_id WHERE sd.`costcode_id` = '$cost_code_id' and sd. `project_id`= '$project_id' and subcontractor_id='$subcontract_id' and sd.status IN ('approved') order by sd.status ASC, CAST(SUBSTR(approve_prefix , 5, LENGTH(approve_prefix)) AS UNSIGNED) ASC";
 
    $db->execute($query1);
    $scoArr =array();
    while ($row1 = $db->fetch()){
        
        $eachscoarr['sequence_number']    =$row1['sequence_number'];
        $eachscoarr['title']                =$row1['title'];
        $eachscoarr['description']      =$row1['description'];
        $eachscoarr['estimated_amount_raw'] = $row1['estimated_amount'];
        $eachscoarr['estimated_amount']     = Format::formatCurrency($row1['estimated_amount']);
        $estimated_amount = Format::formatCurrency($row1['estimated_amount']);
        $eachscoarr['status_notes']         =$row1['status_notes'];
        $eachscoarr['company']          =$row1['company'];
        $status             =$row1['status'];
        $eachscoarr['status'] = $row1['status'];
        if($status=='approved')
        {
            $eachscoarr['sequence_number']    =$row1['approve_prefix'];
            $eachscoarr['appAmt'] =$estimated_amount;
            $eachscoarr['otherAmt'] ='';
        }else
        {
            $eachscoarr['otherAmt'] = $estimated_amount;
            $eachscoarr['appAmt'] = '';
        }

        $scoArr[] = $eachscoarr;
    }
    
    return $scoArr;
 }

// To get the prelims data
function renderPrelimsReportHtml($database, $project_id, $user_company_id) {
    $db = DBI::getInstance($database);
    $db->free_result();
    $arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdReport($database, $project_id);
    $gcBudgetLineItemsTbody='';
    $loopCounter=1;
    $tabindex=0;
    $tabindex2=0;
    //cost code divider
    $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
    foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
    /* @var $gcBudgetLineItem GcBudgetLineItem */

        $prime_contract_scheduled_value = $gcBudgetLineItem->prime_contract_scheduled_value;
        if (!$prime_contract_scheduled_value) {
            continue;
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

        $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
        $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
        $arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemIdWithDate($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions, '', '');
        
        if (isset($arrSubcontracts) && !empty($arrSubcontracts)) {
            $subcontractCount = count($arrSubcontracts);
        } else {
            $subcontractCount = 0;
        }

        $prelimesTbody = '';
        $nxtCountSub = 0;
        $arrSubcontractVendorHtml = array();
        $subcontract_actual_value_raw = 0;
        $subcontract_actual_value =0;
        foreach ($arrSubcontracts as $subcontract) {
            $prelimesTbodyTD = '';
            /* @var $subcontract Subcontract */

            $tmp_subcontract_id = $subcontract->subcontract_id;
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
            $tmpSubcontractTargetExecutionDateHtmlInput = '';
            $tmpSubcontractMailedDateHtmlInput = '';
            // Subcontract Actual Value list
            $subcontract_actual_value_raw += $tmp_subcontract_actual_value;
            $subcontract_actual_value += $tmp_subcontract_actual_value;
            $formattedSubcontractActualValue = Format::formatCurrency($tmp_subcontract_actual_value);
            // Vendor list

            $vendor = $subcontract->getVendor();
            if ($vendor) {

                $vendorContactCompany = $vendor->getVendorContactCompany();
                /* @var $vendorContactCompany ContactCompany */

                $vendorContactCompany->htmlEntityEscapeProperties();
                $arrSubcontractVendorHtml[] = $vendorContactCompany->escaped_contact_company_name;
            } else {
                continue;
            }

            // For the Prelims document
            //To fetch the uploaded prelims document
            $db = DBI::getInstance($database);
            $query1 ="
                SELECT *, pi.id as prelim_id FROM `subcontractor_additional_documents` AS s
                INNER JOIN file_manager_files AS f ON s.attachment_file_manager_file_id = f.id
                LEFT JOIN preliminary_items AS pi ON pi.additional_doc_id =  s.id
                WHERE s.subcontractor_id = $tmp_subcontract_id AND type = '2' ";
            $db->execute($query1);
            $uploadedPrelimFileId=array();
            $uploadedPrelimfileName=array();
            $uploadedPrelimFileIdData = array();
            $i = 0;
            //  loop
            $inTdPr = 0 ;
            while($row1=$db->fetch()){
                $pretdBorderBottomStyle = '';
                if(($db->rowCount-1) != $inTdPr){
                    $pretdBorderBottomStyle = 'td';
                }
                $supplier = $row1['supplier'];
                $received_date = date('m/d/Y',strtotime($row1['received_date']));
                $prelimesTbodyTD .= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
                <tr class="subcontractorRow">
                    <td class="textAlignLeft $pretdBorderBottomStyle">$supplier</td>
                    <td class="textAlignLeft $pretdBorderBottomStyle" width="42%">$received_date</td>
                <tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
                $inTdPr++;
            }
            $db->free_result();
            $tdBorderBottomStyle = '';
            if(($subcontractCount-1) != $nxtCountSub){
                $tdBorderBottomStyle = 'td';
            }
            if($prelimesTbodyTD!="")
            {
            $prelimesTbody .= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
            <tr class="subcontractorRow">
                <td class="textAlignCenter"></td>
                <td class="textAlignLeft $tdBorderBottomStyle">$vendorContactCompany->escaped_contact_company_name</td>
                <td class="textAlignLeft $tdBorderBottomStyle" colspan="2">
                    <table width="100%">
                    $prelimesTbodyTD
                    </table>
                </td>
            </tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
            $nxtCountSub++;
            }
           
        }

        if ($loopCounter%2) {
            $rowStyle = 'oddRow';
        } else {
            $rowStyle = 'evenRow';
        }
        if(empty($arrSubcontractVendorHtml)){
            continue;
        }
        $costCodeData = $costCodeDivision->escaped_division_number.$costCodeDividerType.$costCode->escaped_cost_code;
        if($prelimesTbody!="")
        {

       $gcBudgetLineItemsTbody .= <<<GC_BUDGET_LINE_ITEMS_TBODY
        <tr class="costCodeTr oddRow">
            <td class="textAlignCenter costCodeTxt">$costCodeData</td>
            <td class="textAlignLeft costCodeTxt" colspan="3">$costCode->escaped_cost_code_description</td>
        </tr>
        $prelimesTbody
GC_BUDGET_LINE_ITEMS_TBODY;
        
        $loopCounter++;
        $tabindex++;
        $tabindex2++;
    }
    }
    $gcBudgetLineItemsTbody = mb_convert_encoding($gcBudgetLineItemsTbody, "HTML-ENTITIES", "UTF-8");
    if($gcBudgetLineItemsTbody==''){
        $gcBudgetLineItemsTbody="<tr><td colspan='6'>No prelims recorded.</td></tr>";
    }
    $htmlContent = <<<END_HTML_CONTENT
    <div class="custom_datatable_style">
        <table class="content" border="0" cellpadding="5" cellspacing="0" width="100%">
            <tr class="table-headerinner">
                <td colspan="6" class="textAlignLeft">PRELIM NOTICE REPORT</td>
            </tr>
        </table>
        <table id="delay_list_container--manage-request_for_information-record" class="content cell-border tableborder" border="0" cellpadding="5" cellspacing="0" width="100%">
            <thead class="borderBottom">
                <tr class="table-header">
                    <th class="textAlignCenter">CostCode</th>
                    <th class="textAlignLeft" width="40%">Subcontractor</th>
                    <th class="textAlignLeft" width="25%">Supplier</th>
                    <th class="textAlignLeft" width="20%">Received Date</th>       
                </tr>
            </thead>
            <tbody class="">
                $gcBudgetLineItemsTbody
            </tbody>
        </table>
    </div>
END_HTML_CONTENT;
    return $htmlContent;
}

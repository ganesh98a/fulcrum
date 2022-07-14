<?php 
$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;


require_once('lib/common/init.php');
require_once('lib/common/WeatherUndergroundConditionLabel.php');
require_once('lib/common/WeatherUndergroundMeasurement.php');
require_once('lib/common/WeatherUndergroundReportingStation.php');
require_once('lib/common/OpenWeatherAmPmLogs.php');
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
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContactCompanyOffice.php');
require_once('lib/common/ContactCompanyOfficePhoneNumber.php');
require_once('lib/common/ContactPhoneNumber.php');
require_once('page-components/dropDownListWidgets.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('app/models/subcontract_invoice_model.php');

//Fetch the Delay's Data
    function DelayLog($database,$projectId,$new_begindate,$enddate,$type_mention,$filterstatus){
        $incre_id=1;
        $db = DBI::getInstance($database);
        if($type_mention=="Delaylog"){
            $filter= "";
        }else{
           $filter= "AND `source`='".$type_mention."' ";
        }
        
        if($filterstatus !="")
        {
            $status = "AND `status` = '".$filterstatus."' and `notified` = '1'";
        }else
        {
             $status = "";
        }
        
        $query = "SELECT * FROM `jobsite_delay_data` where `is_deleted` = '0' AND `project_id`='".$projectId."' AND `begindate` between '".$new_begindate."' AND '".$enddate."' $filter $status";
    
        $db->execute($query);
        $records = array();
        while($row = $db->fetch()){
            $records[] = $row;
        }
        $delayTableTbody = '';
        foreach($records as $row){
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
            while ($row1 = $db1->fetch()){
                $cattype = $row1['jobsite_delay_category'];
            }
            $db1->execute($query2);
            while ($row1 = $db1->fetch()){
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

            if($bdate == '0000-00-00'){
                $formattedDelaybdate = '';
            }else{
                $formattedDelaybdate = date("m/d/Y", strtotime($bdate));
            }
            if($edate == '0000-00-00'){
                $formattedDelayedate = '';
            }else{
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

        if(empty($delayTableTbody)){
            $delayTableTbody=<<<Table_Data
        <tr><td colspan="10">No Data Available for Selected Dates</td></tr>
Table_Data;
        }
        if($type_mention == 'DCR')
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
    //To get the weather condition and Temperature
    function getAmPmWeatherTemperaturesAndConditions($database, $project_id, $created){
        $created_arr = explode('-', $created);
        $year=$created_arr[0];

        //Before 2019 weather api record
        if($year < '2019'){
            $arrWeatherUndergroundMeasurements = WeatherUndergroundMeasurement::loadAmPmWeatherUndergroundMeasurementsByProjectId($database, $project_id, $created);
        }else{
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
            }else{
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
            }else{
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
/**
* Display the Delay Grid
* @param project id
* @return html
*/
    function DelayView_AsHtml($database, $projectId,$new_begindate,$enddate){   
    
        $delayTableTbody = '';
        $delayTableTbody1 = '';
        $incre_id=1;
        $db = DBI::getInstance($database);
        $query = "SELECT * FROM jobsite_delay_data where is_deleted = '0' and project_id='".$projectId."' and begindate between '".$new_begindate."' and '".$enddate."'";
        $db->execute($query);
        $records = array();
        while($row = $db->fetch()){
            $records[] = $row;
        }
        foreach($records as $row){
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
            while ($row1 = $db1->fetch()) {
                $cattype = $row1['jobsite_delay_category'];
            }
            $db1->execute($query2);
            while ($row1 = $db1->fetch()) {
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

        

            if($bdate == '0000-00-00'){
                $formattedDelaybdate = '';
                $beginWeekDay='';
            }else{
                $formattedDelaybdate = date("m/d/Y", strtotime($bdate));
                $beginWeekDay=date('l', strtotime($bdate));

            }
            if($edate == '0000-00-00')
            {
                $formattedDelayedate = '';
            }else{
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
    function findByProjectIdAndJobsiteDailyLogModifiedSite($database, $project_id, $jobsite_daily_log_created_date,$check_date){
        $db = DBI::getInstance($database);
        $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_daily_sitework_activity_logs` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_sitework_activities` jbta ON jdoal_fk_joa.`jobsite_sitework_activity_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$jobsite_daily_log_created_date' AND '$check_date' GROUP BY jbta.`id`";

    
        $db->execute($query);
        $records = array();
        $recordsite = array();
        while($row = $db->fetch()){
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
    function findByProjectIdAndJobsiteDailyLogModifiedBuild($database, $project_id, $jobsite_daily_log_created_date,$check_date){
        $db = DBI::getInstance($database);
        $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_daily_building_activity_logs` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_building_activities` jbta ON jdoal_fk_joa.`jobsite_building_activity_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$jobsite_daily_log_created_date' AND '$check_date' GROUP BY jbta.`id`";

        
        $db->execute($query);
        $records = array();
        $recordsite = array();
        while($row = $db->fetch()){
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
    function findByProjectIdAndJobsiteDailyLogModifiedInspection($database, $project_id, $jobsite_daily_log_created_date,$check_date){
        $db = DBI::getInstance($database);
        $query ="SELECT jdl.*,jdoal_fk_joa.*,jdty.*,jdtno.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_inspections` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_inspection_types` jdty ON jdty.id = jdoal_fk_joa.`jobsite_inspection_type_id` INNER JOIN `jobsite_inspection_notes` jdtno ON jdtno.`jobsite_inspection_id` = jdoal_fk_joa.`id` WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$jobsite_daily_log_created_date' AND '$check_date'";
        
        $db->execute($query);
        $records = array();
        $recordsite = array();
        $htmlInspectionData='';
        while($row = $db->fetch()){
            $records[] = $row;
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
    function findByProjectIdInspectionPassed($database, $project_id, $jobsite_daily_log_created_date,$check_date){
        $db = DBI::getInstance($database);
        $query ="SELECT jdl.*,jdoal_fk_joa.*,jdty.*,jdtno.* FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_inspections` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_inspection_types` jdty ON jdty.id = jdoal_fk_joa.`jobsite_inspection_type_id` INNER JOIN `jobsite_inspection_notes` jdtno ON jdtno.`jobsite_inspection_id` = jdoal_fk_joa.`id` WHERE jdl.`project_id` = $project_id AND jdl.`jobsite_daily_log_created_date` BETWEEN '$jobsite_daily_log_created_date' AND '$check_date' AND jdoal_fk_joa.`jobsite_inspection_passed_flag` = 'Y' ";
        
        $db->execute($query);
        $records = array();
        $recordsite = array();
        $htmlInspectionData='';
        while($row = $db->fetch()){
           $records[] = $row['jobsite_inspection_passed_flag'];
        }
        $Inspectioncount=count($records);
        return $Inspectioncount;
    }
    //fetch data's Common for notes (General,deliveries,deliveries,safety,extrawork,swppp,visitors)
    function findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $jobsite_daily_log_created_date,$check_date ,$type_id){
        $db = DBI::getInstance($database);
        $query ="SELECT jdl.*,jdoal_fk_joa.*,jbta.*,jdoal_fk_joa.jobsite_note as visitors FROM `jobsite_daily_logs` jdl INNER JOIN `jobsite_notes` jdoal_fk_joa ON jdl.`id` = jdoal_fk_joa.`jobsite_daily_log_id` INNER JOIN `jobsite_note_types` jbta ON jdoal_fk_joa.`jobsite_note_type_id` = jbta.`id` WHERE jdl.`project_id` = $project_id AND jbta.`id` = $type_id AND date(jdl.`jobsite_daily_log_created_date`) BETWEEN '$jobsite_daily_log_created_date' AND '$check_date'";

        $db->execute($query);
        $records = array();
        $recordsite = array();
        $htmlInspectionData='';
        while($row = $db->fetch()){
            $records[] = $row;
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
/**
 * Takes an array of <td> tags as input and returns a string of <tr> tags,
 * each filled with $numColumns <td> tags.
 *
 * @param array $cells an array of strings, each containing <td> tags.
 * @param int $numColumns the desired number of columns
 * @return string $htmlContent a string of <tr> tags each filled with $numColumns <td> tags.
 */
    function columnifyTableCells($cells, $numColumns=4){
        $count = count($cells);
        $interval = ceil($count / $numColumns);
        $htmlContent = '';
        for ($i = 0; $i < $interval; $i++) {
            $index = $i;
            $column = 1;
            $htmlContent .= '<tr>';
            while ($index < $count) {
                $cell = $cells[$index];
                $htmlContent .= $cell;
                $index = $index + $interval;
                $column++;
            }
            $htmlContent .= '</tr>';
        }

        return $htmlContent;
    }

//To get the man power Data

    function buildManpowerSection($database, $user_company_id, $project_id,  $new_begindate, $enddate, $typemention=null){

        $maxDays=7;
        $arrayManValue=array();
        $arrayManDate=array();
        $arrayManComp=array();
        $count='1';
        $session = Zend_Registry::get('session');
/* @var $session Session */
        $currentlyActiveContactId = $session->getCurrentlyActiveContactId();
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
            $arrJobsiteManPowerIds = $arrJobsiteManPowerByJobsiteDailyLogId = $arrJobsiteManPowerBySubcontractId = '';
            if(!empty($arrReturn['jobsite_man_power_ids'])){
                $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
            }
            if(!empty($arrReturn['objects'])){
               $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects']; 
            }
            if(!empty($arrReturn['jobsite_man_power_by_subcontract_id'])){
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
        foreach($arrayManValue as $index=>$value){
            $value=array_filter($arrayManValue[$index]);
            foreach($arrayManValue[$index] as $index1 => $value1){
                $JoinArray='';
                if(!empty($arrayChek[$index1])){
                   $JoinArray .=$arrayChek[$index1]; 
                }
                
                $JoinArray .=$arrayManValue[$index][$index1];
                $arrayChek[$index1]=$JoinArray;
                $checkNull .= $arrayManValue[$index][$index1];
            }
        }
        if($checkNull!=''){
            for($datei=1;$datei<=$date_count;$datei++){
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
                        if(empty($coltotalarray[$invaluei])){
                            $coltotalarray[$invaluei] = 0;
                        }
                        if(!empty($arrayManValue[$valuei][$invaluei])){
                          $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei]; 
                           $row_total=$row_total+$arrayManValue[$valuei][$invaluei]; 
                        }
                        
                       
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
                if(!empty($arrayChek[$invaluet])){
                    $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
                }else{
                    if($invaluet==$counttotalValue)
                        $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
                    else
                        $valuehtml.="<td></td>";
                }

            }
        }
        if(empty($counttotalValue)){
            $valuehtml.="<tr><td colspan=".($maxDays+2).">No Manpower Efforts Involved For Selected Dates</td>";
            $CheckTableValue=0;
        }
        $valuehtml.="</tr>";
        $valuehtml.="</tbody>";
        $valuehtml.='</table><input type="hidden" id="CheckTableValue" name="CheckTableValue" value="'.$CheckTableValue.'">';
        return $valuehtml;
    }

//To get the man power Data Monthly
    function buildManpowerSectionMonthly($database, $user_company_id, $project_id,  $new_begindate,$enddate){
        $maxDays=date('t',strtotime($new_begindate));
        $arrayManValue=array();
        $arrayManDate=array();
        $arrayManComp=array();
        $htmlContent = '';
        $count='1';
        $session = Zend_Registry::get('session');
/* @var $session Session */
        $currentlyActiveContactId = $session->getCurrentlyActiveContactId();
        for($inday=0;$inday<$maxDays;$inday++){
             $sub_count='1';
            $datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
            $jobsite_daily_log_id = '';
            $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);
            if ($jobsiteDailyLog) {
               $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
            }

            $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
            $arrJobsiteManPowerIds = $arrJobsiteManPowerByJobsiteDailyLogId =  $arrJobsiteManPowerBySubcontractId = '';
            if(!empty($arrReturn['jobsite_man_power_ids'])){
                $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
            }
            if(!empty($arrReturn['objects'])){
                $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
            }
            if(!empty($arrReturn['jobsite_man_power_by_subcontract_id'])){
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
        $valuehtml='<table id="manpower_activity_monthly" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">';
        $valuehtml.='<thead class="borderBottom">';
        $valuehtml.='<tr class="table-headerinner">
            <th colspan="'.($date_count+2).'" class="align-left">MANPOWER ACTIVITY </th>
            </tr>';
        $arrayChek=array();
        $checkNull='';
        foreach($arrayManValue as $index=>$value){
            $value=array_filter($arrayManValue[$index]);
            foreach($arrayManValue[$index] as $index1 => $value1){
                $JoinArray='';
                if(!empty($arrayChek[$index1])){
                    $JoinArray .=$arrayChek[$index1];
                }
                
                $JoinArray .=$arrayManValue[$index][$index1];
                $arrayChek[$index1]=$JoinArray;
                $checkNull .= $arrayManValue[$index][$index1];
            }
        }
        if($checkNull!=''){
            for($datei=1;$datei<=$date_count;$datei++){
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
                        if(empty($coltotalarray[$invaluei])){
                            $coltotalarray[$invaluei] = 0;
                        }
                        $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
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
                if(!empty($arrayChek[$invaluet])){
                    $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
                }else{
                    if($invaluet==$counttotalValue)
                        $valuehtml.="<td>$coltotalarray[$invaluet]</td>";
                    else
                        $valuehtml.="<td></td>";
                }

            }
        }
        if(empty($counttotalValue)){
            $valuehtml.="<tr><td colspan=".($maxDays+2).">No Manpower Efforts Involved For Selected Dates</td>";
            $CheckTableValue=0;
        }
        $valuehtml.="</tr>";
        $valuehtml.="</tbody>";
        $valuehtml.='</table><input type="hidden" id="CheckTableValue" name="CheckTableValue" value="'.$CheckTableValue.'">';
        return $valuehtml;
    }
//To get the man power Data Whole project
    function buildManpowerSectionProject($database, $user_company_id, $project_id,  $new_begindate,$enddate){
        $date1 = new DateTime($new_begindate);
        $date2 = new DateTime($enddate);
        $maxDays = $date2->diff($date1)->format("%a");
        $arrayManValue=array();
        $arrayManDate=array();
        $arrayManComp=array();
        $count='1';
        $session = Zend_Registry::get('session');
        $htmlContent = '';
        /* @var $session Session */
        $currentlyActiveContactId = $session->getCurrentlyActiveContactId();
        for($inday=0;$inday<$maxDays;$inday++){
            $sub_count='1';
            $datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
            $jobsite_daily_log_id = '';
            $jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $datestep);
            if ($jobsiteDailyLog) {
               $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
            }
            $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
            $arrJobsiteManPowerIds = $arrJobsiteManPowerByJobsiteDailyLogId = $arrJobsiteManPowerBySubcontractId = '';
            if(!empty($arrReturn['jobsite_man_power_ids'])){
                $arrJobsiteManPowerIds = $arrReturn['jobsite_man_power_ids'];
            }
            
            if(!empty($arrReturn['objects'])){
                $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
            }
            if(!empty($arrReturn['jobsite_man_power_by_subcontract_id'])){
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
        foreach($arrayManValue as $index=>$value){
            $value=array_filter($arrayManValue[$index]);
            foreach($arrayManValue[$index] as $index1 => $value1)
            {
                $JoinArray='';
                if(!empty($arrayChek[$index1])){
                    $JoinArray .=$arrayChek[$index1];    
                }
                
                $JoinArray .=$arrayManValue[$index][$index1];
                $arrayChek[$index1]=$JoinArray;
                $checkNull .= $arrayManValue[$index][$index1];
            }
        }
        if($checkNull!=''){
            for($datei=1;$datei<=$date_count;$datei++){
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
                $valueinarraycount = $row_total = 0;
                if(!empty($arrayManValue[$valuei])){
                    $valueinarraycount=count($arrayManValue[$valuei]);
                }
                
                for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
                    if($invaluei!=0){
                        $class="class='center-align'";
                        
                    }else{
                        $class="class='align-left'";
                        $valuehtml.="<td $class style='white-space:nowrap;'>".$arrayManComp[$valuei][$invaluei]."</td>";
                    }

                    if($invaluei!=0){
                        if(empty($coltotalarray[$invaluei])){
                            $coltotalarray[$invaluei] = 0;
                        }
                        $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
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

//to get man Power Excluding advent
    function buildManpowerSectionCountExcluding($database, $user_company_id, $project_id, $jobsite_daily_log_id,$company){
    
        $arrayManValue=array();
        // $arrayManDate=array();
        $session = Zend_Registry::get('session');
        /* @var $session Session */
        $currentlyActiveContactId = $session->getCurrentlyActiveContactId();
        $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id);
        $count='1';
        $adventCompanyManPower=0;
        $otherCompanyManPower=0;
        $htmlContent = '';
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


                $htmlEntityEscapedFormattedCostCode = $costCode->getHtmlEntityEscapedFormattedCostCode($user_company_id);

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
                if($company==$contact_company_name){
                    $adventCompanyManPower=$adventCompanyManPower+$number_of_people;
                }else{
                    $otherCompanyManPower=$otherCompanyManPower+$number_of_people;
                    
                }
                $id_val=$count.'_'.$sub_count;
                $arrayManValue[$sub_count][0]=$contact_company_name.'-'.$htmlEntityEscapedFormattedCostCode;
                $arrayManValue[$sub_count][$count]=$number_of_people;
                $sub_count++;

            }
            $count++;
            $htmlContent .=<<<END_CONT
</table>
END_CONT;
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
            $valueinarraycount = $row_total = 0;
            if(!empty($arrayManValue[$valuei])){
              $valueinarraycount = count($arrayManValue[$valuei]);  
            }
            
            for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
                if($invaluei!=0){
                    $class="class='center-align'";
                }else{
                    $class="class='align-left'";
                }
                $valuehtml.="<td $class>".$arrayManValue[$valuei][$invaluei]."</td>";
                if($invaluei!=0){
                    if(empty($coltotalarray[$invaluei])){
                        $coltotalarray[$invaluei] = 0;
                    }
                    $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
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
    function buildManpowerWeeklyJob($database, $user_company_id, $project_id,$new_begindate){


        $maxDays=7;
        $arrayManValue=array();
        $arrayManDate=array();
        $arrayManComp=array();
        $count='1';
        $htmlContent="";
        $session = Zend_Registry::get('session');
        /* @var $session Session */
        $currentlyActiveContactId = $session->getCurrentlyActiveContactId();
        for($inday=0;$inday<$maxDays;$inday++){
            $sub_count='1';
            $datestep=date('Y-m-d',strtotime($new_begindate.'+'.$inday.' days'));
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
        }

        $array_count=count($arrayManValue);
        $date_count=count($arrayManDate);
        $CheckTableValue=1;
        $arrayChek=array();
        $checkNull='';
        foreach($arrayManValue as $index=>$value){
            $value=array_filter($arrayManValue[$index]);
            foreach($arrayManValue[$index] as $index1 => $value1){
                $JoinArray='';
                $JoinArray .=(!empty($arrayChek[$index1]))?$arrayChek[$index1]:"";
                $JoinArray .=$arrayManValue[$index][$index1];
                $arrayChek[$index1]=$JoinArray;
                $checkNull .= $arrayManValue[$index][$index1];
            }
        }

        $weekTotalcol=0;
        $colTotal=0;
        $coltotalarray=array();
        $colcount=1;
        $valuehtml ="";
        for($valuei=1;$valuei<=$array_count;$valuei++){
            $row_total=0;
            $valueinarraycount=count($arrayManValue[$valuei]);
            for($invaluei=0;$invaluei<$valueinarraycount;$invaluei++){
                if($invaluei!=0){
                    if(empty($coltotalarray[$invaluei]))
                    {
                        $coltotalarray[$invaluei] = 0;
                    }
                    $coltotalarray[$invaluei]=$coltotalarray[$invaluei]+$arrayManValue[$valuei][$invaluei];
                    $row_total=$row_total+$arrayManValue[$valuei][$invaluei];
                }
            }
            $weekTotalcol=$weekTotalcol+$row_total;
            $coltotalarray[$invaluei]=$weekTotalcol;
        }
        $counttotalValue=count($coltotalarray);
        $valuehtml.="<tr class='total_bold center-align'>";
        for($invaluet=1;$invaluet<$counttotalValue;$invaluet++){
            if($invaluet==1)
            $valuehtml.="<td class='align-left'>DAY TOTAL</td>";
            
            $valuehtml.="<td class='align-left'>$coltotalarray[$invaluet]</td>";
        }
        $valuehtml.="</tr>";
        return $valuehtml;
    }
//Get the Contract log for project list
function CostCodeData($database, $user_company_id,$project_id,$date,$date1,$new_begindate,$enddate,$Endate){
    //cost code divider
    $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

    $arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectIdReport($database, $project_id);
    $gcBudgetLineItemsTbody='';
    $loopCounter=1;
    $tabindex=1;
    $tabindex2 =1;
    
    foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        if (!empty($scheduledValuesOnly)) {
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
        $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
        $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;
        $arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemIdWithDate($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions,$new_begindate,$enddate, true);
        
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

       $costCodeDetail = $costCodeDivision->escaped_division_number.$costCodeDividerType.$costCode->escaped_cost_code;
    if($subcontractMailedDateHtmlInputs!='' || $subcontractTargetExecutionDateHtmlInputs!='')
        $gcBudgetLineItemsTbody.=<<<END_GC_BUDGET_LINE_ITEMS_TBODY
        <tr id="record_container--manage-request_for_information-record--" class="$rowStyle">
        <td class="textAlignLeft">$costCodeDetail</td>
        <td class="textAlignLeft">$costCode->escaped_cost_code_description</td>
        <td class="textAlignLeft">$subcontractMailedDateHtmlInputs</td>
        <td class="textAlignLeft">$subcontractTargetExecutionDateHtmlInputs</td>
        </tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
        $loopCounter++;
        $tabindex++;
        $tabindex2++;
    
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
// to get all the data's for weekly job
function WeeklyJob($database, $project_id,$startDate,$enddate1,$Endate,$new_begindate,$enddate,$user_company_id)
{
$man_power=buildManpowerWeeklyJob($database, $user_company_id, $project_id,$new_begindate);
    // To get the all date between the specified dates
$begin=new DateTime( $startDate);
$end=new DateTime( $enddate1);
$end = $end->modify( '+1 day' ); 

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$days="";
$amTemperatures="";
$amConditions="";
$pmTemperatures = $pmConditions="";

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
$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdForJobsiteDailyLogDate($database, $project_id, $new_begindate,$enddate);
$jobsiteDailyDate = JobsiteDailyLog::findByProjectIdForJobsiteDailyDateValues($database, $project_id, $new_begindate,$enddate);

$weekTotal=$man_power;// echo "man ".$man_power;
// $dayList=$man_power['dayList'];// echo "man ".$man_power;
$CostCode=CostCodeData($database, $user_company_id,$project_id,$startDate,$enddate1,$new_begindate,$enddate,$Endate);


$weather=<<<CONDITION_TEMP
    <tr><td rowspan="2">AM Temp / Condition</td>$amTemperatures</tr>
    <tr>$amConditions</tr>
    <tr><td rowspan="2">PM Temp / Condition</td>$pmTemperatures</tr>
    <tr>$pmConditions</tr>
    $weekTotal
CONDITION_TEMP;

$Inspection=TotalManPowerAndInspection($database,$project_id,$new_begindate,$enddate);
$manPowerWholeWeek=$Inspection['manpowerActivityThisWeek'];
$InspectionWholeWeek=$Inspection['numInspectionsThisWeek'];

//get the data's from table for sitework section
$jobsiteDailyLog = findByProjectIdAndJobsiteDailyLogModifiedSite($database, $project_id, $new_begindate, $enddate);
//Sitework activity table data
$siteworkact_job=<<<SITEWORKACT_TABLE_DATA
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
//get the data's from table for Other Notes section
$othernotes=findByProjectIdAndJobsiteDailyLogModifiedNotes($database, $project_id, $new_begindate, $enddate, '1');
//to get the Rfi Data
$RfiResponseData=RfiListViewWithResponse($database, $project_id,$new_begindate, $enddate);

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
//Contact list for the project
function TeamMemeberList($database, $currentlySelectedProjectId,$currentlySelectedProjectName){
    $db = DBI::getInstance($database);
    $db->free_result();
    $new_sort_by = 'company ASC, first_name ASC, last_name ASC';
        // Contact Roles (role_id > 3)
        // Get list of roles that can be modified (role_id > 3)
        // WHERE r.`id` NOT IN ($AXIS_USER_ROLE_ID_GLOBAL_ADMIN, $AXIS_USER_ROLE_ID_ADMIN, $AXIS_USER_ROLE_ID_USER)
    $arrAllRoles = Role::loadAllRoles($database);

        // Load all Project Roles (less User)
        // Use the role_alias values for "Project Roles"
        // Skip the "User" role
    $loadRolesByRoleGroupOptions = new Input();
    $loadRolesByRoleGroupOptions->role_group = 'project_roles';
    $loadRolesByRoleGroupOptions->useRoleAliasesFlag = true;
    $loadRolesByRoleGroupOptions->skipUserRoleFlag = true;
    $arrProjectRoles = Role::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);

        // Get a list of contacts associated with this project by role via projects_to_contacts_to_roles
    $project_id = (int) $currentlySelectedProjectId;
    $orderBy = $new_sort_by;

    $arrContactsWithRolesByProjectId = ProjectToContactToRole::loadContactsWithRolesByProjectIdReport($database, $project_id, $orderBy, true);


    $colspanCount = 4;
    
        $tablebody='';
        $tablehead='';
        if (count($arrContactsWithRolesByProjectId) > 0) {
            $tablehead='<tr>
            <th class="align-left">Company</th>
            <th class="align-left">Name</th>
            <th class="align-left">Email</th>
            <th class="align-left">Phone</th>
            <th class="align-left">Fax</th>
            </tr>';
         
            foreach ($arrContactsWithRolesByProjectId AS $contact_id => $contact) {
                /* @var $contact Contact */
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

                $contact->htmlEntityEscapeProperties();

                $contactCompany = $contact->getContactCompany();
                /* @var $contactCompany ContactCompany */

                $userInvitation = $contact->getUserInvitation();
                /* @var $userInvitation UserInvitation */

                if ($userInvitation) {
                    $invitationDate = $userInvitation->created;
                } else {
                    $invitationDate = '';
                }

                $arrRoleIdsByProjectId = $contact->getArrRoleIdsByProjectId();
                $arrContactRolesByProject = $arrRoleIdsByProjectId[$currentlySelectedProjectId];

                $contact_user_id = $contact->user_id;

                $company = $contactCompany->contact_company_name;
                $encodedCompanyName = Data::entity_encode($company);

                $contactFullName = $contact->getContactFullName();
                $encodedContactFullName = Data::entity_encode($contactFullName);

                $email = $contact->email;
                 $mobileno = $contact->mobile_phone_number;
                $escaped_email = $contact->escaped_email;
                $encodedEmail = Data::entity_encode($email);
                $tablebody.='
                    <tr id="projectListRow_'.$contact_id.'" valign="top">
                    <td nowrap>'.$encodedCompanyName.'</td>
                    <td nowrap>'.$encodedContactFullName.'</td>
                    <td nowrap>'.$email.'</td>
                    <td nowrap>'.$mobileno.'</td>
                    <td nowrap>'.$formattedFaxNumber.'</td>
                    </tr>
                ';
            }
        } else {
            $tablebody="<tr><td colspan='5'>No Contacts Exist For This Project</td></tr>";
        }
        $htmlContent = <<<END_HTML_CONTENT
<table id="contactlist" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom">
        <tr class="table-headerinner">
        <th colspan="5" class="align-left">$currentlySelectedProjectName Team Members</th>
        </tr>
        $tablehead
    </thead>
    <tbody class="altColors">
        $tablebody
    </tbody>
</table>
END_HTML_CONTENT;
        return $htmlContent;
}
function DetailedWeeklyReport($database, $user_company_id,$project_id,$date,$date1,$new_begindate,$enddate, $typemention=null){ 
// To get the all date between the specified dates
$man_power=buildManpowerSection($database, $user_company_id, $project_id, $new_begindate, $enddate, $typemention);

$begin=new DateTime($date);
$end=new DateTime($date1);
$end = $end->modify( '+1 day' ); 

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$amTemperatures = $pmTemperatures = $pmConditions = $amConditions = $days = '';

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


$man_powers=buildManpowerSection($database, $user_company_id, $project_id, $new_begindate, $enddate);

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
        <tr>
        <td class="align-left">Date</td>
        <th class="align-left">Category</td>
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
        <tr>
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
        <tr class="">
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
        <tr >
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
        <tr >
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
        <tr >
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
        <tr >
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
        <tr >
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
//Get the Contract log for project list
function ContractLog($database, $user_company_id,$project_id,$date,$date1,$new_begindate,$enddate,$Endate,$begindate){
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
//Fetch the Sub List (subcontract) from budget
function BudgetList($database, $user_company_id, $currentlyActiveContactId, $project_id, $companyName, $projectName, $cost_code_division_id_filter=null){

    $session = Zend_Registry::get('session');
    /* @var $session Session */
    $debugMode = $session->getDebugMode();

    $project = Project::findProjectByIdExtended($database, $project_id);
    /* @var $project Project */

    $project->htmlEntityEscapeProperties();
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

    

$gcBudgetForm = <<<END_FORM
        <table id="sublist" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">
            <thead class="borderBottom">
            <tr class="table-headerinner">
            <th colspan="8" class="textAlignLeft">Sub List</th>
            </tr>
                <tr class="">
                    <th class="textAlignLeft" width="20%">Trade</th>
                    <th class="textAlignLeft" width="20%">Company</th>
                    <th class="textAlignLeft" width="15%">Contact</th>
                    <th class="textAlignLeft" width="15%">email</th>
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
//renderGcBudgetLineItemsTbody
function renderGcBudgetLineItemsTbodySub($database, $user_company_id, $project_id, $cost_code_division_id_filter=null, $order_by_attribute=false, $order_by_direction=false, $scheduledValuesOnly=false, $needsBuyOutOnly=false)
{
   
    
    $arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id);
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
        $arrSubcontractVendorEmailHtml = array();
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
        $address_city=null;
        $address_state_or_region=null;
        $address_postal_code=null;
        $tmpSubcontractVendorNameHtmlInputs='';
        $tmpSubcontractVendorEmailHtmlInputs='';
        $tmpSubcontractVendorfaxHtmlInputs='';
        $tmpSubcontractVendorMobileHtmlInputs='';
        $address='';
        $address_city='';
        $address_state_or_region='';
        $address_postal_code='';
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
                        $contactEmail=$object->email;
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

                //store the contact person email
                if ($subcontractCount == 1) {
                    $tmpSubcontractVendorEmailHtmlInputs = $contactEmail;
                } elseif ($subcontractCount > 1) {
                    if($contactEmail!=''){
                    $tmpSubcontractVendorEmailHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$contactEmail
END_HTML_CONTENT;
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
                $selected_id = '';
                if(!empty($records['contact_company_office_id'])){
                  $selected_id = $records['contact_company_office_id'];  
                }
                
 
                foreach ($arrContactCompanyOfficesByContactCompanyId as $contact_company_office_id => $contactCompanyOffice) {
                     $contact_company_office_id = $contactCompanyOffice->contact_company_office_id;
                    $address_line_1 = $contactCompanyOffice->address_line_1;
                     $address_line_2 = $contactCompanyOffice->address_line_2;
                     $address_line_3 = $contactCompanyOffice->address_line_3;
                     $address_line_4 = $contactCompanyOffice->address_line_4;
                     $office_nickname = $contactCompanyOffice->office_nickname;
                    $address_county = $contactCompanyOffice->address_county;
                    $address_country = $contactCompanyOffice->address_country;
                    if($selected_id==$contact_company_office_id){
                    $address = $address_line_1 . ' ' . $address_line_2 . ' ' . $address_line_3 . ' ' . $address_line_4;
                    $address_city = $contactCompanyOffice->address_city;
                    $address_state_or_region = $contactCompanyOffice->address_state_or_region;
                    $address_postal_code = $contactCompanyOffice->address_postal_code;
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

               //store office city
               if ($subcontractCount == 1) {
                    $tmpSubcontractVendorCityHtmlInputs = $address_city;
                } elseif ($subcontractCount > 1) {
                    if($address_city!=''){
                    $tmpSubcontractVendorCityHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address_city
END_HTML_CONTENT;
                }
               } 

               //store office state
               if ($subcontractCount == 1) {
                    $tmpSubcontractVendorStateHtmlInputs = $address_state_or_region;
                } elseif ($subcontractCount > 1) {
                    if($address_state_or_region!=''){
                    $tmpSubcontractVendorStateHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address_state_or_region
END_HTML_CONTENT;
                }
               } 

               //store office zip
               if ($subcontractCount == 1) {
                    $tmpSubcontractVendorZipHtmlInputs = $address_postal_code;
                } elseif ($subcontractCount > 1) {
                    if($address_postal_code!=''){
                    $tmpSubcontractVendorZipHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address_postal_code
END_HTML_CONTENT;
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

             $tmpSubcontractVendorCityHtmlInputs=null;
             $tmpSubcontractVendorStateHtmlInputs=null;
             $tmpSubcontractVendorZipHtmlInputs=null;

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

               //store office city
               if ($subcontractCount == 1) {
                    $tmpSubcontractVendorCityHtmlInputs = $address_city;
                } elseif ($subcontractCount > 1) {
                    if($address_city!=''){
                    $tmpSubcontractVendorCityHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address_city
END_HTML_CONTENT;
                }
               } 

               //store office state
               if ($subcontractCount == 1) {
                    $tmpSubcontractVendorStateHtmlInputs = $address_state_or_region;
                } elseif ($subcontractCount > 1) {
                    if($address_state_or_region!=''){
                    $tmpSubcontractVendorStateHtmlInputs = <<<END_HTML_CONTENT
                <span style="border: 0px solid red; display: inline-block; width: 30px;">#$tmp_subcontract_sequence_number)</span>$address_state_or_region
END_HTML_CONTENT;
                }
               } 

               //store office zip
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
         $arrSubcontractVendorEmailHtml[] = $tmpSubcontractVendorEmailHtmlInputs;
         $arrSubcontractVendorAddressHtml[] = $tmpSubcontractVendorAddressHtmlInputs;
         $arrSubcontractVendorCityHtml[] = $tmpSubcontractVendorCityHtmlInputs;
         $arrSubcontractVendorStateHtml[] = $tmpSubcontractVendorStateHtmlInputs;
         $arrSubcontractVendorZipHtml[] = $tmpSubcontractVendorZipHtmlInputs;

         
        // } //subcontract
        //vendor loop end/
        $vendorNameList = join('<br>', $arrSubcontractVendorNameHtml);
        $vendorEmailList = join('<br>', $arrSubcontractVendorEmailHtml);
        $vendorFaxList = join('<br>', $arrSubcontractVendorfaxHtml);
        $vendorPhoneList = join('<br>', $arrSubcontractVendorMobileHtml);
        $vendorAddressList = join('<br>', $arrSubcontractVendorAddressHtml);

        $vendorCityList = join('<br>', $arrSubcontractVendorCityHtml);
        $vendorStateList = join('<br>', $arrSubcontractVendorStateHtml);
        $vendorZipList = join('<br>', $arrSubcontractVendorZipHtml);
        //$vendorList = trim($vendorList, ' ,');
        $vendorList = join('<br>', $arrSubcontractVendorHtml);

        if ($loopCounter%2) {
            $rowStyle = 'oddRow';
        } else {
            $rowStyle = 'evenRow';
        }

        $loopCounter++;
    }
    //cost code divider
    $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
    $costCodeDetail = $costCodeDivision->escaped_division_number.$costCodeDividerType.$costCode->escaped_cost_code.'-'.$costCode->escaped_cost_code_description;
    if($arrSubcontracts)
    {
    $gcBudgetLineItemsTbody.= <<<END_GC_BUDGET_LINE_ITEMS_TBODY
         <tr id="record_container--manage-gc_budget_line_item-record--gc_budget_line_items--sort_order--$gc_budget_line_item_id" class="">
        <td class="textAlignLeft">
           <span style="text-transform:capitalize;">$costCodeDetail</span>
        </td>
        <td class="textAlignLeft">$vendorList</td>
        <td class="textAlignLeft">$vendorNameList</td>
        <td class="textAlignLeft">$vendorEmailList</td>
        <td class="textAlignLeft">$vendorPhoneList</td>
        <!-- <td class="textAlignLeft">$vendorFaxList</td> -->
        <td class="textAlignLeft">$vendorAddressList</td>
        <td class="textAlignLeft">$vendorCityList</td>
        <td class="textAlignLeft">$vendorStateList</td>
        <td class="textAlignLeft">$vendorZipList</td>
        </tr>
END_GC_BUDGET_LINE_ITEMS_TBODY;
    }
    }
    if($gcBudgetLineItemsTbody==''){
        $gcBudgetLineItemsTbody="<tr><td colspan='6'>No Data Available for Selected Dates</td></tr>";
    }

    return $gcBudgetLineItemsTbody;
}
//To fetch Submittal by Id
function renderSuListView($database, $project_id,$new_begindate,$enddate,$typecall = null, $status_type)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    if($typecall == null || $typecall == '')
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndDate($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);
    else
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndDateOpen($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);
    $suTableTbody = '';

    $suTableTbody = '';
    $GetCount=count($arrSubmittals);
    $empty_row = "<tr><td colspan='8' style='text-align:center;'>No Data Available for Selected Dates</td></tr>";
    if($GetCount == '0'){
        $suTableTbody = $empty_row;
    }
    $counter = 0;
    foreach ($arrSubmittals as $submittal_id => $submittal) {
        /* @var $submittal Submittal */
        $submittalStatus = $submittal->getSubmittalStatus();
        // submittal_statuses:

        $submittal_status = $submittalStatus->submittal_status;
        $submittalId = $submittalStatus->id;

        /* @var $submittalStatus SubmittalStatus */
        $statusArr = explode(',', $status_type);
        if ($status_type != '' && !in_array($submittalId, $statusArr)) {
            continue;
        }
        
        $counter++;

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
            $su_due_date = '&nbsp;';
        }

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */

            $formattedSuCostCode = $suCostCode->getFormattedCostCode($database,false);

            
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
    if(empty($counter)){
        $suTableTbody = $empty_row;;
    }
$suTableTbody = mb_convert_encoding($suTableTbody, "HTML-ENTITIES", "UTF-8");

    $htmlContent = <<<END_HTML_CONTENT

<table id="record_list_container--manage-submittal-record" class="detailed_week content" border="0" cellpadding="5" cellspacing="0" width="100%">

    <tr class=" table-headerinner"><td colspan="9">Open Submittal Log</td></tr>
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
function renderSuListViewNotes($database, $project_id,$new_begindate,$enddate, $status_type)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndDate($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);

    $suTableTbody = '';
    $empty_row = "<tr><td colspan='11' style='text-align:center;'>No Data Available for Selected Dates</td></tr>";
    $GetCount=count($arrSubmittals);
    if($GetCount == '0')
    {
        $suTableTbody = $empty_row;
    }
    $loopCounter = 1;
    $counter = 0;
    foreach ($arrSubmittals as $submittal_id => $submittal) {
        $submittalStatus = $submittal->getSubmittalStatus();
        $submittal_status = $submittalStatus->submittal_status;
        $submittalId = $submittalStatus->id;

        $statusArr = explode(',', $status_type);
        if ($status_type != '' && !in_array($submittalId, $statusArr)) {
            continue;
        }
        
        $counter++;
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

        if (empty($su_due_date)) {
            $su_due_date = '&nbsp;';
        }

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */
            $formattedSuCostCode = $suCostCode->getFormattedCostCode($database,false);
        } else {
            $formattedSuCostCode = '&nbsp;';
        }

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

        
        // To get the submittal Notes
        $submittal_id_notes= $submittal->submittal_id;
        $db = DBI::getInstance($database);
        $query_notes="Select * from submittal_responses where submittal_id='".$submittal_id_notes."'";
        $db->execute($query_notes);
        $record_notes = array();
        while($row = $db->fetch()){
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
    }
    if(empty($counter)){
        $suTableTbody = $empty_row;
    }

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
function renderSuListViewStatus($database, $project_id,$new_begindate,$enddate, $status_type)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndStatus($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);

    $suTableTbody = '';
    $GetCount=count($arrSubmittals);
    $empty_row = "<tr><td colspan='8' style='text-align:center;'>No Data Available for Selected Dates</td></tr>";
    if($GetCount == '0')
    {
        $suTableTbody = $empty_row;
    }
    $counter = 0;
    foreach ($arrSubmittals as $submittal_id => $submittal) {
        /* @var $submittal Submittal */

        $submittalStatus = $submittal->getSubmittalStatus();
        $submittal_status = $submittalStatus->submittal_status;
        $submittalId = $submittalStatus->id;

        $statusArr = explode(',', $status_type);
        if ($status_type != '' && !in_array($submittalId, $statusArr)) {
            continue;
        }
        
        $counter++;

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
            $su_due_date = '&nbsp;';
        }

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */

            $formattedSuCostCode = $suCostCode->getFormattedCostCode($database,false);

           
        } else {
            $formattedSuCostCode = '&nbsp;';
        }


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
    if(empty($counter))
    {
        $suTableTbody = $empty_row;
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
//To fetch Submittal by Cost Code
function renderSuListViewCostCode($database, $project_id,$new_begindate,$enddate, $user_company_id, $status_type)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndCostCode($database, $project_id, $loadSubmittalsByProjectIdOptions,$new_begindate,$enddate);
    $suTableTbody = '';
    $GetCount=count($arrSubmittals);
    $empty_row = "<tr><td colspan='9' style='text-align:center;'>No Data Available for Selected Dates</td></tr>";
    if($GetCount == '0')
    {
        $suTableTbody = $empty_row;
    }
    
    $counter = 0;
    foreach ($arrSubmittals as $submittal_id => $submittal) {
        /* @var $submittal Submittal */
        $submittalStatus = $submittal->getSubmittalStatus();
        $submittal_status = $submittalStatus->submittal_status;
        $submittalId = $submittalStatus->id;

        $statusArr = explode(',', $status_type);
        if ($status_type != '' && !in_array($submittalId, $statusArr)) {
            continue;
        }
        $counter++;

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
            $su_due_date = '&nbsp;';
        }

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */

            $formattedSuCostCode = $suCostCode->getFormattedCostCode($database,false,$user_company_id);


        } else {
            $formattedSuCostCode = '&nbsp;';
        }

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
        if($count_days=='1'){
            $daysOpen='00'.$daysOpen;
        }else if($count_days=='2'){
            $daysOpen='0'.$daysOpen;
        }
        $count_seq=strlen($su_sequence_number);
        if($count_seq=='1'){
            $su_sequence_number='00'.$su_sequence_number;
        }else if($count_seq=='2'){
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
    if(empty($counter)){
        $suTableTbody = $empty_row;
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
//Method To get the Submittal by Id
function SubmittalLog($database, $project_id,$new_begindate,$enddate, $status_type)
{
    $SubmittalsData=renderSuListView($database, $project_id,$new_begindate,$enddate,'', $status_type);
   $htmlContent = <<<END_HTML_CONTENT
   $SubmittalsData
END_HTML_CONTENT;
return $htmlContent;
}
//Method To get the Submittal by notes
function SubmittalLogNotes($database, $project_id,$new_begindate,$enddate, $status_type)
{
    $SubmittalsData=renderSuListViewNotes($database, $project_id,$new_begindate,$enddate, $status_type);
   $htmlContent = <<<END_HTML_CONTENT
   $SubmittalsData
END_HTML_CONTENT;
return $htmlContent;
}
//Method To get the Submittal by status
function SubmittalLogStatus($database, $project_id,$new_begindate,$enddate, $status_type)
{
    $stateSubmittalsData=renderSuListViewStatus($database, $project_id,$new_begindate,$enddate, $status_type);
   $htmlContent = <<<END_HTML_CONTENT
   $stateSubmittalsData
END_HTML_CONTENT;
return $htmlContent;
}
//Method To get the Submittal by Cost Code
function SubmittalLogCostCode($database, $project_id,$new_begindate,$enddate, $user_company_id, $status_type)
{
    $SubmittalsData=renderSuListViewCostCode($database, $project_id,$new_begindate,$enddate, $user_company_id, $status_type);
   $htmlContent = <<<END_HTML_CONTENT
   $SubmittalsData
END_HTML_CONTENT;
return $htmlContent;
}
//Get the RFI data All
function RFIReportbyID($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $typepost, $cost_code_division_id_filter=null,$status_type = ''){

    $loadRequestsForInformationByProjectIdOptions = new Input();
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
        if(!empty($status_type) && $requestForInformation->request_for_information_status_id != $status_type){
            continue;
        }

        $rfi_closed_date = $requestForInformation->rfi_closed_date;
        $rfi_created = $requestForInformation->created;

        // Convert rfi_created to a Unix timestamp
        $openDateUnixTimestamp = strtotime($rfi_created);
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
        if(!empty($status_type) && $requestForInformation->request_for_information_status_id != $status_type){
            continue;
        }

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
        $rfiTableTbody="<tr><td colspan='8'>No Data Available for Selected Dates</td></tr>";
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
function RFIReportQA($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $typepost, $cost_code_division_id_filter=null, $status_type = ''){

    $loadRequestsForInformationByProjectIdOptions = new Input();
    $loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
    $arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByProjectIdReport($database, $project_id, $loadRequestsForInformationByProjectIdOptions,$new_begindate, $enddate, $typepost);
    $rfiTableTbody = '';
    $index=1;
    $Arrayindex=1;
    $daysopenArray = array();
    foreach ($arrRequestsForInformation as $request_for_information_id => $requestForInformation) {
    /* @var $requestForInformation RequestForInformation */
        if(!empty($status_type) && $requestForInformation->request_for_information_status_id != $status_type){
            continue;
        }
        $requestForInformationStatus = $requestForInformation->getRequestForInformationStatus();
        $request_for_information_status = $requestForInformationStatus->request_for_information_status;
        $rfi_closed_date = $requestForInformation->rfi_closed_date;
        $rfi_created = $requestForInformation->created;

        // Convert rfi_created to a Unix timestamp
        $openDateUnixTimestamp = strtotime($rfi_created);
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
        if(!empty($status_type) && $requestForInformation->request_for_information_status_id != $status_type){
            continue;
        }
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
        <tr><th></th><th colspan="3" class="align-left" style="padding-bottom:20px;"><u>Question</u></th><th class="align-left" colspan="4"><u>Answer</u></th></tr>
        <tr><td></td><td colspan="3" class="text-justify">$rfi_statement</td><td colspan="4" class="text-justify">
END_RFI_TABLE_TBODY;
if($formattedRfiResponseDate!='')
        $rfiTableTbody.=<<<response_text
        <span class="bold">Response Date : $formattedRfiResponseDate</span> <br>
        $response_text
response_text;
}
             if(!empty($rfidArray[$checkid-1]) &&$request_for_information_id == $rfidArray[$checkid-1] ){
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
        <tr><th></th><th colspan="3" class="align-left" style="padding-bottom:20px;"><u>Question</u></th><th class="align-left" colspan="4"><u>Answer</u></th></tr>
        <tr><td></td><td colspan="4" class="text-justify">$rfi_statement</td><td colspan="3" class="text-justify">
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
        $rfiTableTbody="<tr><td colspan='9'>No Data Available for Selected Dates</td></tr>";
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
        <th class="align-left" width="15%" style="padding-bottom:20px;">Completed date</th>
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
//Jobstatus Function
function JobStatus($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $typepost){
    $db = DBI::getInstance($database);

    $arrActionItemsByDiscussionItemIds = ActionItem::loadActionItemsByProjectReport($database, $project_id, $new_begindate, $enddate);
    $opentrackitemcontent = '';
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
    $con_query="SELECT jb.*,dl.*,date(dl.`jobsite_daily_log_created_date`) AS lastdate FROM `jobsite_man_power` jb LEFT JOIN jobsite_daily_logs dl ON dl.`id` = jb.`jobsite_daily_log_id` WHERE date(dl.`jobsite_daily_log_created_date`)!='$jobsite_daily_log_created_date' ORDER BY dl.`id` DESC ";
    $db->execute($con_query);
    $row=$db->fetch();

    if(isset($row)){
        $jobsite_daily_log_id=$row['jobsite_daily_log_id'];
        $lastdate=$row['lastdate'];
    }
    
    $man_begindate_arr=explode(' ', $new_begindate);
    $man_begindate=$man_begindate_arr[0];
  
    $yesdayManPower = buildManpowerSectionProject($database, $user_company_id, $project_id, $man_begindate,$enddate);
    
    $SubmittalsData=renderSuListView($database, $project_id,$new_begindate,$enddate ,$type='jobstatus');
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
/*Bidder List Report table content*/
function loadPurchasingBidderListReportSpr($database, $arrBidders, $sort_by_order, $user_company_id)
{
   $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

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
            $formatted_bid_total = '';
            if(!empty($bid_total)){
                $formatted_bid_total =Format::formatCurrency($bid_total);     
            }
            
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
            $formatted_bid_total = '';
            if(!empty($bid_total)){
                $formatted_bid_total =Format::formatCurrency($bid_total);    
            }
            
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
        $lastCompany = $company;
        $lastCode = $formatted_cost_code;
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



    function report_footer($database, $user_company_id){
        $db = DBI::getInstance($database);
        //To get the contact company_id
         $query1="SELECT id FROM `contact_companies` WHERE `user_user_company_id` = $user_company_id AND `contact_user_company_id` = $user_company_id ";
        $db->execute($query1);
        $row1=$db->fetch();
        $ContactCompId=$row1['id'];
        //To get the compant address
        $Footeraddress='';
        $query2="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId and `head_quarters_flag`='Y'  order by id desc limit 1";
        $db->execute($query2);
        $row2=$db->fetch();
        if($row2){
            $CompanyOfficeId=$row2['id'];
            if($row2['address_line_1']!=''){
                $Footeraddress.=$row2['address_line_1'];
            }
            if($row2['address_city']!=''){
                $Footeraddress.=' | '.$row2['address_city'];
            }
            if($row2['address_state_or_region']!=''){
                $Footeraddress.=' , '.$row2['address_state_or_region'];
            }
            if($row2['address_postal_code']!=''){
                $Footeraddress.='  '.$row2['address_postal_code'];
            }
        }else{
            $query4="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId   order by id desc limit 1";
            $db->execute($query4);
            $row4=$db->fetch();
            
            $CompanyOfficeId=$row4['id'];
            if($row4['address_line_1']!=''){
                $Footeraddress.=$row4['address_line_1'];
            }
            if($row4['address_city']!=''){
                $Footeraddress.=' | '.$row4['address_city'];
            }
            if($row4['address_state_or_region']!=''){
                $Footeraddress.=' , '.$row4['address_state_or_region'];
            }
            if($row4['address_postal_code']!=''){
                $Footeraddress.='  '.$row4['address_postal_code'];
            }
        }
    
        $query3="SELECT * FROM `contact_company_office_phone_numbers` WHERE `contact_company_office_id` = $CompanyOfficeId";
        $db->execute($query3);
        $business='';
        $fax='';
        while ($row3 = $db->fetch()) {
            if($row3['phone_number_type_id']=='1'){
                $business = $row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
            } 
            if($row3['phone_number_type_id']=='2'){
                $fax = ' | (F)'.$row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
            }   
        }
        $Footeraddress=trim($Footeraddress,'| ');
        $faxPhone =$business.$fax;
        return array('address'=>strtoupper($Footeraddress),'number'=>$faxPhone);
    }
    function SubcontractInvoiceData($database, $project_id,$user_company_id,$status)
    {
        $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
        if($status !="" && $status != 'null')
        {
            $filtstatus = "and si.subcontract_invoice_status_id IN ($status)";
        }else
        {
             $filtstatus = "";
        }
        $db = DBI::getInstance($database);
        $query1="SELECT s.`id` as s_id, s.`gc_budget_line_item_id` as s_gc_budget_line_item_id, s.`subcontract_template_id` as s_subcontract_template_id,s.`subcontract_actual_value` as s_subcontract_actual_value,
        cc.`company`,ss.`status`,
        si.*
         FROM `subcontract_invoices` as si 
         inner join subcontracts as s on si.subcontract_id = s. id 
         inner join contact_companies as cc on cc.id = si.vendor_id
         inner join subcontract_invoice_status as ss on ss.id = si.subcontract_invoice_status_id
         where si.project_id =? $filtstatus";
        $arrValues = array($project_id);
        $db->execute($query1,$arrValues,MYSQLI_USE_RESULT);
        $subincvoiceArray = array();
        while($row = $db->fetch())
        {
            $subid =$row['id'];
            $subincvoiceArray[$subid] = $row;
        }
        foreach ($subincvoiceArray as $key => $svalue) {

         $cost_code_id = $svalue['cost_code_id'];
         $subcontract_template_id = $svalue['s_subcontract_template_id'];
         // To get the updated contarct Amount
         $SCOAmt = SCOAmountAginstSubcontractor($database,$svalue['subcontract_id']);
         $contract_amount = $svalue['s_subcontract_actual_value'] + $SCOAmt;

         $subincvoiceArray[$key]['s_subcontract_actual_value'] =$contract_amount;
         // To get the cost code
         $db = DBI::getInstance($database);
         $query2="SELECT concat(ccd.`division_number`,'$costCodeDividerType',cs.cost_code,' ',cs.cost_code_description) as cost_code_abb  FROM 
         `cost_codes` as cs inner join `cost_code_divisions` as ccd on ccd.id = cs.cost_code_division_id
         where `user_company_id` = ? and cs.id= ?";
         $arrValues = array($user_company_id,$cost_code_id);
         $db->execute($query2,$arrValues,MYSQLI_USE_RESULT);
         $row2= $db->fetch();
         $subincvoiceArray[$key]['cost_code_abb'] = $row2['cost_code_abb'];
         $db->free_result();
         // to get the subcontract Tmeplate
         $query3="SELECT subcontract_template_name FROM `subcontract_templates` where id = ?";
         $arrValues = array($subcontract_template_id);
         $db->execute($query3,$arrValues,MYSQLI_USE_RESULT);
         $row3= $db->fetch();
         $subincvoiceArray[$key]['subcontract_template_name'] = $row3['subcontract_template_name'];
         $db->free_result();
     }
     $db->free_result();
        return $subincvoiceArray;

         
    }



    function renderSubcontractInvoiceHtml($database, $project_id,$user_company_id,$status){

        $arrSubInv = SubcontractInvoiceData($database,$project_id,$user_company_id,$status);
       if(!empty($arrSubInv)){
        foreach ($arrSubInv as $key => $subval) {
            $recDate=$period_to=$pm_approved="";
            if($subval['recieved_date']!="0000-00-00")
            {

                $recDateTimestamp = strtotime($subval['recieved_date']);
                $recDate = date("m/d/Y ", $recDateTimestamp);
            }
           if($subval['period_to']!="0000-00-00")
            {

                $periodToTimestamp = strtotime($subval['period_to']);
                $period_to = date("m/d/Y ", $periodToTimestamp);
            }
            if($subval['pm_approved']!="0000-00-00")
            {

                $pm_approvedTimestamp = strtotime($subval['pm_approved']);
                $pm_approved = date("m/d/Y ", $pm_approvedTimestamp);
            }

            $supplierdata="";
              $supparr =getPrelimsByInvoiceId($database, $key);
               $supplierdata =" <td colspan ='2' ><table  width='100%'>";

         if (!empty($supparr)) {
            $supbal =0;
              foreach ($supparr as $key => $supval) {
                  $supplierdata .=" <tr><td id='supname' width='50%'>".$supval['supplier']."</td>";
                  $supplierdata .=" <td id='supamt' width='50%' class='textAlignRight'>".Format::formatCurrency($supval['Amount'])."</td></tr>";
        $supbal +=$supval['Amount'];
              }
         }
               $supplierdata .="</table> </td>";

               $Balance = ($subval['total'] -($subval['amount'] -$subval['retention']))-$supbal;
      

        $subContent .= "
        <tr>

        <td>".$subval['cost_code_abb']."</td>
        <td>".$subval['company']."</td>
        <td>".Format::formatCurrency($subval['s_subcontract_actual_value'])."</td>
        <td>".$subval['subcontract_template_name']."</td>
        <td>".$recDate."</td>
        <td>".$subval['application_number']."</td>
         <td>".$period_to."</td>
        <td>".Format::formatCurrency($subval['amount'])."</td>
        <td>".Format::formatCurrency($subval['retention'])."</td>
        <td>".Format::formatCurrency($subval['total'])."</td>
        $supplierdata
         <td>".Format::formatCurrency($Balance)."</td>
        <td>".Format::formatCurrency($subval['contract_remaining'])."</td>
        <td>".$subval['notes']."</td>
        <td>".$pm_approved."</td>
        <td>".$subval['status']."</td>
        </tr>";

}
}else
{
     $subContent = "<tr><td colspan='17'>No Data Available</td></tr>";
}
         $htmlContent = <<<END_HTML_CONTENT
    <table id="subinvoiceList" class="tableborder content cell-border"  cellpadding="5" cellspacing="0" width="100%" border="0">
    <thead class="borderBottom">
       <tr class="table-headerinner">
            <th colspan="17" class="textAlignLeft">Subcontractor Invoice Report</th>
            </tr>
      <tr>
      <th>Cost Code Description</th>
      <th>Company</th>
      <th>Contract Value</th>
      <th>Template Name</th>
      <th>Rec'd</th>
      <th>App#</th>
      <th>Period To</th>
      <th>Sc Amount</th>
      <th>Retiontion</th>
      <th>Invoice Total</th>
      <th>Supplier</th>
      <th>Supplier Amount</th>
      <th>Supplier Balance</th>
      <th>Contract Remaining</th>
      <th>Notes</th>
      <th>PM Approved</th>
      <th>Status</th>
      </tr>
    </thead>
    <tbody class="">
        $subContent
    </tbody>
</table>
END_HTML_CONTENT;
    return $htmlContent;
        // return "good";
    }

    function renderPrelimsHtml($database, $project_id,$user_company_id)
    {

        //cost code divider
        $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
        $budget = GcBudgetLineItem::getprelimbudget($database, $project_id);
        $gcBudgetLineItemsTbody="";

        foreach ($budget as $key => $bval) {

          $costcodeabb = $bval['division_number'].$costCodeDividerType.$bval['cost_code'];
          $cost_code_description = $bval['cost_code_description'];
          $subcontractor_id = rtrim($bval['subcontractor_id'],',');
          $alphaCharIn = 0;

          $gcBudgetLineItemsTbody .= <<<END_BUDGET
          <tr class="costCodeTr oddRow"><td class=" costCodeTxt textAlignCenter">$costcodeabb</td>
          <td class=" costCodeTxt">$cost_code_description</td>
          <td class="" colspan='2'></td>
END_BUDGET;





          $subcontract = GcBudgetLineItem::getprelimsubcontractor($database,$subcontractor_id);

          foreach ($subcontract as $key => $sval) {
            $company = $sval['company'];
            $sub_id = $sval['sub_id'];
            // $alphaCharIn =1;
            $company = <<<END_BUDGET
            <td class="textAlignCenter"></td>
            <td class="">$company</td>
END_BUDGET;


            $prelim = GcBudgetLineItem::getprelimDataforsubcontractor($database,$sub_id);
            $i=0;

            foreach ($prelim as $key => $pvalue) {

              $supplier = $pvalue['supplier'];
              $received_date = strtotime($pvalue['received_date']);
              $formattedreceived_date = date("m/d/Y", $received_date);

              $gcBudgetLineItemsTbody .= <<<END_BUDGET
              <tr>
END_BUDGET;
              if($i==0)
              {
                $gcBudgetLineItemsTbody .= <<<END_BUDGET
                $company
END_BUDGET;
            }
            else
            {
                $gcBudgetLineItemsTbody .= <<<END_BUDGET
                <td class="" colspan='2'></td>
END_BUDGET;

            }

            $gcBudgetLineItemsTbody .= <<<END_BUDGET
            <td class="">$supplier</td>
            <td class="">$formattedreceived_date</td></tr>
END_BUDGET;
            $i++;


        }


    }
    $gcBudgetLineItemsTbody .= <<<END_BUDGET
    </tr>
END_BUDGET;
}
    $htmlContent = <<<END_HTML_CONTENT
    <html>
    <head>
    <style>
    @font-face {
        font-family: 'Calibri';
        font-style: normal;
        font-weight: normal;
        src: url($basefont) format('truetype');
    }
    @font-face {
        font-family: 'Calibri-bold';
        font-style: normal;
        font-weight: normal;
        src: url($baseinnerfont) format('truetype');
    }
    .CellBorderTop{
        border-top:1px solid #CBC8C8;
    }
    .costCodeTxt {
        color: #2481c3;
    }
    .costCodeTr td{
        border-top: 1px solid #CBC8C8;
        border-bottom: 1px solid #CBC8C8;
    }
    .fontSize16{
        font-size:16pts;
        /*text-decoration:underline;*/
        font-family: 'Calibri-bold';
        text-transform:uppercase;
        border-bottom:1px solid #3487c7;
    }
    .cellRTNotWback
    {
        border-top:none !important;
        background: #fff;
    }
    .comment-table tr .BotBord {
        border-bottom: 1px solid #CBC8C8;
    }
    .comment-table tr{
        vertical-align:top;
    }
    .project_name{
        text-align:center;
        text-decoration:underline;
        font-size:18pts;
        text-weight:Bold;
        text-transform : uppercase;
    }
    
    /*Bid list css*/
    .oddRow, .oddRowNotClickable {
        background-color: #efefef;
    }
    
    .detailed_week,.tableborder{
            border:1px solid ;
    }

    .align-left,.textAlignLeft{
        text-align:left;
    }
    .align-right{
        text-align:right;
    }
    .align-center{
        text-align:center;
    }
    .table-header{
        margin:0;
        padding:0;
    }

    .line-break{
        border:0.5px solid;
    }
    .repot-inform{
        background-color:#2481c3;
        color:#fff;
        padding:5px;
        margin-bottom:5px;
    }
    .table-headerinner{
        background-color:#2481c3;
        color:#fff;
        font-weight:lighter;
    }
    #report_html{
    /*border:1px solid;*/
    font-size:18px;
    }
    .total_bold{
        font-weight:bold;
    }
    .center-align,.textAlignCenter{
        text-align:center;
    }
    .table_header_td{
        font-size:20px !important;
        color:#000;
    }
    .marginTopborderMT
    {
        border-top: 1px solid #cbc8c8;
    }
    .marginrightborderMT
    {
        border-right: 1px solid #cbc8c8;
    }
</style>
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
END_HTML_CONTENT;

      return $htmlContent;   
    }
 function make_subcontruct_audit_report($database, $user_company_id,$project_id, $subcontructor_id,$vendor,$cc_id){
    $project = Project::findProjectByIdExtended($database, $project_id);
    /* @var $project Project */
    $project->htmlEntityEscapeProperties();
    $escaped_project_name = $project->escaped_project_name;

    $s_id=explode("-", $subcontructor_id)[0];
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
    $filterby=" and sd.status IN ('approved')";
    // ,'potential'
    $db = DBI::getInstance($database);
    $query = "
    SELECT concat(ccd.`division_number`,'$costCodeDividerType',cs.cost_code,' ',cs.cost_code_description) as cost_code_abb, sd.*,cc.company, cs.id as cc_id FROM `subcontract_change_order_data` as sd
    inner join `contact_companies` as cc on cc.`id` = sd.subcontract_vendor_id 
    inner join `cost_codes` as cs on cs.id = sd.costcode_id
    inner join `cost_code_divisions` as ccd on ccd.id = cs.cost_code_division_id
    where `project_id` = $project_id and cc.id=$s_id and cs.id=$cc_id  $filterby ORDER BY cc.company ASC,cost_code_abb ASC , sd.status Asc, CAST(SUBSTR(approve_prefix , 5, LENGTH(approve_prefix)) AS UNSIGNED) ASC ";
    $db->execute($query);
    $records = array();
    while($row = $db->fetch())
    {
        $records[] = $row;
    }
$sub_val=explode("-", $subcontructor_id)[1];
    $html='<table width="100%" class="tableborder content cell-border ">
                <thead class="borderBottom">
                    <tr class="table-headerinner">
                        <th colspan="5" class="textAlignCenter">Subcontract Audit</th>
                    </tr>
                    <tr class="borederRowBid">
                        <td colspan="4" class="textAlignCenter">&nbsp;</td>
                        <td  class="textAlignCenter">'.date('m/d/Y').'</td>
                    </tr>
                    <tr></tr>
                    <tr class="borederRowBid">
                        <td>Project:</td>
                        <td>'.$escaped_project_name.'</td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="borederRowBid">
                        <td>Subcontractor:</td>
                        <td>'.$vendor.'</td>
                        <td colspan="3"></td>
                    </tr>
                    <tr></tr>
                    <tr class="borederRowBid">
                        <td>Subcontract Value:</td>
                        <td>'.Format::formatCurrency($sub_val).'</td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="borederRowBid">
                        <td><h3>Change Orders:</h3></td>
                        <td></td>
                    </tr>
                    <tr class="borederRowBid">
                        <th style="padding-bottom:20px;" class="align-left">CO#</th>
                        <th style="padding-bottom:20px;" class="align-left">Date:</th>
                        <th style="padding-bottom:20px;" class="align-left">Description:</th>
                        <th style="padding-bottom:20px;" class="align-left">Cost Code:</th>
                        <th style="padding-bottom:20px;" class="align-left">Amount of CO:</th>                        
                    </tr>
                </thead>
                <tbody>
                    ';
                    $total_c=0;
                    foreach ($records as $key => $value) {
                      
                    $html.='<tr  class="borederRowBid">
                        <td>'.$value['approve_prefix'].'</td>
                        <td>'.$value['created_at'].'</td>
                        <td>'.$value['description'].'</td>
                        <td>'.$value['cost_code_abb'].'</td>
                        <td>'.Format::formatCurrency($value['estimated_amount']).'</td>                        
                    </tr>';
                    $total_c+=$value['estimated_amount'];
                }
                $html.='
                <tr  class="borederRowBid">
                    <td colspan="3"></td>
                    <td>Total Change Orders:</td>
                    <td>'.Format::formatCurrency($total_c).'</td>
                </tr>
                 <tr  class="borederRowBid">
                    <td colspan="3"></td>
                    <td>Revised Subcontract Total:</td>
                    <td>'.Format::formatCurrency($sub_val+$total_c).'</td>
                </tr>

                </tbody>
    </table>
    <table width="100%" class="tableborder content cell-border " id="QB_html"></table>
    '."~".($sub_val+$total_c);
    return $html;
 }
function loadSelectedReportCompany($database, $vendor_id, $project_id)
{

$costCodeDesc = '<select id="selectCostCode" name="selectCostCode" style="width: 100%;">';
    // if($arrCostCode=="") {
        // $costCodeDesc .= '<option value="">No Data</option>';
    // } else {
        $costCodeDesc .= '<option value="">Select Options</option>';
    // }
$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);
$arrGcBudgetLineItemsByProjectId = GcBudgetLineItem::loadGcBudgetLineItemsByProjectId($database, $project_id, $loadGcBudgetLineItemsByProjectIdOptions,'');
$gcBudgetLineItemsTbody = '';

$costCodeDesc = '<select name="cc_id"  id="cc_id" style="width: 100%;">
                <option value="">Select Options</option>';
$vendorCompany = '<select name="vendor_id"  id="vendor_id" style="width: 100%;">
                <option value="">Select Options</option>';

$comID=[];
foreach ($arrGcBudgetLineItemsByProjectId as $gc_budget_line_item_id => $gcBudgetLineItem) {
    

    /* @var $gcBudgetLineItem GcBudgetLineItem */
    $costCode = $gcBudgetLineItem->getCostCode();
    $costCode->htmlEntityEscapeProperties();

    $costCodeDivision = $costCode->getCostCodeDivision();
    /* @var $costCodeDivision CostCodeDivision */

    $costCodeDivision->htmlEntityEscapeProperties();
    /* @var $costCode CostCode */
    $costCoDesc     = $costCodeDivision->escaped_division_number.$costCodeDividerType.$costCode->escaped_cost_code.' [ '.$costCode->cost_code_description.' ]';
    // $costCodeDesc .= '<option value="'.$costCode->id.'">'.$costCoDesc.'</option>';

    $subcontractorBid = $gcBudgetLineItem->getSubcontractorBid();
    if (isset($subcontractorBid) && ($subcontractorBid instanceof SubcontractorBid)) {
        
        $subcontractor_bid_id = $subcontractorBid->subcontractor_bid_id;
    } else {
        $subcontractor_bid_id = '';
    }

    $loadSubcontractsByGcBudgetLineItemIdOptions = new Input();
    $loadSubcontractsByGcBudgetLineItemIdOptions->forceLoadFlag = true;

    $arrSubcontracts = Subcontract::loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadSubcontractsByGcBudgetLineItemIdOptions);
    
    foreach ($arrSubcontracts as $subcontract) { 
        $vendor = $subcontract->getVendor();
        $vendorContactCompany = $vendor->getVendorContactCompany();
        /* @var $vendorContactCompany ContactCompany */

        $vendorContactCompany->htmlEntityEscapeProperties();

        $vendorList = $vendorContactCompany->company;
        // if(!in_array($vendor->id,$comID)){
            if(explode("-", $vendor_id)[0]==$vendorContactCompany->id){
                 $costCodeDesc  .= '<option value="'.$costCode->id.'">'.$costCoDesc.'</option>';
            }
         
        $comID[]=$vendor->id;       
        // }
        
    }

}



    // $arrCostCode = GcBudgetLineItem::getCompanyBaseCostCode($database, $vendor_id, $project_id);
    
    // foreach ($arrCostCode as $gc_budget_line_item_id => $costCode) {
    //     $costCoDesc    = $costCode["cost_code"].' - '.$costCode["cost_code_description"];
    //     $costCodeDesc  .= '<option value=""'.$costCode->cost_code.'">'.$costCoDesc.'</option>';
    // }
    $costCodeDesc      .= '</select>';
    return $costCodeDesc;   
    
}

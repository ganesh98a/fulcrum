<?php

require_once('lib/common/Service/TableService.php');
function meetingDataPreview($database, $project_id, $meeting_type_id, $meeting_id, $project_name, $show_all_flag = '')
{



$arrContactOptions = array();

$meetingShowElement = '';
$meetingEditElement = '';
$discussionShowElement = '';
$discussionEditElement = '';
$actionShowElement = '';
$actionEditElement = '';

$isPrintView = true;

$meeting_id = $meeting_id;

$meeting = Meeting::findMeetingByIdExtended($database, $meeting_id);
/* @var $meeting Meeting */

if (!$meeting) {
    exit;
}

$project_id = $meeting->project_id;
$meeting_type_id = $meeting->meeting_type_id;
$previous_meeting_id = $meeting->previous_meeting_id;
$meeting_location_id = $meeting->meeting_location_id;
$meeting_chair_contact_id = $meeting->meeting_chair_contact_id;
$modified_by_contact_id = $meeting->modified_by_contact_id;
$meeting_sequence_number = $meeting->meeting_sequence_number;
$meeting_start_date = $meeting->meeting_start_date;
$meeting_start_time = $meeting->meeting_start_time;
$meeting_end_date = $meeting->meeting_end_date;
$meeting_end_time = $meeting->meeting_end_time;
$modified = $meeting->modified;
$created = $meeting->created;

$project = $meeting->getProject();
/* @var $project Project */

$meetingType = $meeting->getMeetingType();
/* @var $meetingType MeetingType */

$meetingLocation = $meeting->getMeetingLocation();
/* @var $meetingLocation MeetingLocation */

$meetingChairContact = $meeting->getMeetingChairContact();
/* @var $meetingChairContact Contact */

$modifiedByContact = $meeting->getModifiedByContact();
/* @var $modifiedByContact Contact */

$loadMeetingsByPreviousMeetingIdOptions = new Input();
$loadMeetingsByPreviousMeetingIdOptions->forceLoadFlag = true;
$arrMeetings = Meeting::loadMeetingsByPreviousMeetingId($database, $meeting_id, $loadMeetingsByPreviousMeetingIdOptions);
if (count($arrMeetings) == 0) {
    $nextMeeting = false;
} else {
    $nextMeeting = array_shift($arrMeetings);
}
/* @var $nextMeeting Meeting */

$all_day_event_flag = $meeting->all_day_event_flag;
$isAllDayEvent = 'No';
if ($all_day_event_flag == 'Y') {
    $isAllDayEvent = 'Yes';
}

$meeting_start_date = $meeting->meeting_start_date;
if (isset($meeting_start_date) && ($meeting_start_date != '0000-00-00')) {
    $meetingStartDateAsUnixTimestamp = strtotime($meeting_start_date);
    $meetingStartDateDisplay = date('m/d/Y', $meetingStartDateAsUnixTimestamp);
} else {
    $meetingStartDateDisplay = '';
    $meeting_start_date = '';
}

$meeting_start_time = $meeting->meeting_start_time;
if (isset($meeting_start_time) && ($meeting_start_time != '00:00:00')) {
    $meetingStartTimeDisplay = date('g:i a', strtotime($meeting_start_time));
} else {
    $meeting_start_time = '';
    $meetingStartTimeDisplay = '';
}

$meeting_end_date = $meeting->meeting_end_date;
if (isset($meeting_end_date) && ($meeting_end_date != '0000-00-00')) {
    $meetingEndDateAsUnixTimestamp = strtotime($meeting_end_date);
    $meetingEndDateDisplay = date('m/d/Y', $meetingEndDateAsUnixTimestamp);
} else {
    $meetingEndDateDisplay = '';
    $meeting_end_date = '';
}

$meeting_end_time = $meeting->meeting_end_time;
if (isset($meeting_end_time) && ($meeting_end_time != '00:00:00')) {
    $meetingEndTimeDisplay = date('g:i a', strtotime($meeting_end_time));
} else {
    $meeting_end_time = '';
    $meetingEndTimeDisplay = '';
}

$nextMeetingStartDateDisplay = '';
$nextMeetingStartTimeDisplay = '';
$nextMeetingEndDateDisplay = '';
$nextMeetingEndTimeDisplay = '';
$isNextMeetingAllDayEvent = '';
$next_meeting_location = '';
if ($nextMeeting) {

    $next_meeting_location_id = $nextMeeting->meeting_location_id;
    $nextMeetingLocation = MeetingLocation::findById($database, $next_meeting_location_id);
    /* @var $nextMeetingLocation MeetingLocation */

    if ($nextMeetingLocation) {
        $next_meeting_location = $nextMeetingLocation->meeting_location;
    }
    $next_meeting_start_date = $nextMeeting->meeting_start_date;
    if (isset($next_meeting_start_date) && ($next_meeting_start_date != '0000-00-00')) {
        $nextMeetingStartDateAsUnixTimestamp = strtotime($next_meeting_start_date);
        $nextMeetingStartDateDisplay = date('m/d/Y', $nextMeetingStartDateAsUnixTimestamp);
    }
    $next_meeting_start_time = $nextMeeting->meeting_start_time;
    if (isset($next_meeting_start_time) && ($next_meeting_start_time != '00:00:00')) {
        $nextMeetingStartTimeDisplay = date('g:i a', strtotime($next_meeting_start_time));
    }
    $next_meeting_end_date = $nextMeeting->meeting_end_date;
    if (isset($next_meeting_end_date) && ($next_meeting_end_date != '0000-00-00')) {
        $nextMeetingEndDateAsUnixTimestamp = strtotime($next_meeting_end_date);
        $nextMeetingEndDateDisplay = date('m/d/Y', $nextMeetingEndDateAsUnixTimestamp);
    }
    $next_meeting_end_time = $nextMeeting->meeting_end_time;
    if (isset($next_meeting_end_time) && ($next_meeting_end_time != '00:00:00')) {
        $nextMeetingEndTimeDisplay = date('g:i a', strtotime($next_meeting_end_time));
    }
    $next_meeting_all_day_event_flag = $nextMeeting->all_day_event_flag;
    $isNextMeetingAllDayEvent = 'No';
    if ($next_meeting_all_day_event_flag == 'Y') {
        $isNextMeetingAllDayEvent = 'Yes';
    }

}


// Check if user has permission to view this meeting
$varString = 'userCanViewMeetingsType';
$userCanViewMeetingsType = $varString . $meeting_type_id;
$proceedToProcess = 0;
if ( isset($userCanViewMeetingsType) && $userCanViewMeetingsType || $projectOwnerAdmin ) {
    $proceedToProcess = 1;
}

if ($proceedToProcess == 0) {
    echo 'You do not have permission to view this meeting!';
    exit;
}

$meeting_type = $meetingType->meeting_type;
$meeting_location = $meetingLocation->meeting_location;

$meetingHeaderText = $meeting_type . ' ' . $meeting_sequence_number;

$loadMeetingAttendeesByMeetingIdOptions = new Input();
$loadMeetingAttendeesByMeetingIdOptions->forceLoadFlag = true;
$arrMeetingAttendeesByMeetingId = MeetingAttendee::loadMeetingAttendeesByMeetingId($database, $meeting_id, $loadMeetingAttendeesByMeetingIdOptions);

// $baseUrl = $uri->http;
$currentDate = date("m/d/y h:i A", time());

// <!DOCTYPE html>
// <link rel="stylesheet" type="text/css" href="{$baseUrl}css/styles.css">

$htmlContent = <<<END_HTML_CONTENT
<table border="0" class="fontSize12" width="100%" id="table-cellborder">
    <tr valign="top">
        <td width="35%" align="left">
            <table class="nowrapCells fontSize12 marginRight" width="100%">
                <tr class="tableHeaderInnerMeeting">
                    <td colspan="3" class="textAlignLeft paddingTh"><span class="fontSize14 tableHeaderInnerMeeting">$meetingHeaderText</span></td>
                </tr>
                <tr>
                    <td width="30%" class="textAlignLeft paragraphBoldCal">Start</td>
                    <td width="1%">:</td>
                    <td class="nowrapspace">$meetingStartDateDisplay $meetingStartTimeDisplay</td>
                </tr>
                <tr>
                    <td width="30%" class="textAlignLeft paragraphBoldCal">End</td>
                    <td width="1%">:</td>
                    <td class="nowrapspace">$meetingEndDateDisplay $meetingEndTimeDisplay</td>
                </tr>
                <tr>
                    <td width="30%" class="textAlignLeft paragraphBoldCal">Location</td>
                    <td width="1%">:</td>
                    <td>$meeting_location</td>
                </tr>
            </table>
        </td>
        <td width="35%" align="center">
            <table class="nowrapCells marginleft20 fontSize12" width="100%">
                <tr class="tableHeaderInnerMeeting">
                    <td class="textAlignLeft paddingTh" colspan="2"><span class="fontSize14 tableHeaderInnerMeeting">Next Meeting</span></td>
                </tr>
                <tr>
                    <td><span class="nowrapspace">$nextMeetingStartDateDisplay $nextMeetingStartTimeDisplay</span></td>
                </tr>
                <tr>
                    <td><span class="nowrapspace">$nextMeetingEndDateDisplay $nextMeetingEndTimeDisplay</span></td>
                </tr>
                <tr>
                    <td><span>$next_meeting_location</span></td>
                </tr>
            </table>
        </td>
        <td width="30%" align="right">
                <table width="100%" class="fontSize12">
                    <tr class="tableHeaderInnerMeeting">
                        <td class="textAlignLeft paddingTh"><span class="fontSize14 tableHeaderInnerMeeting">Attendees</span></td>
                    </tr>
END_HTML_CONTENT;
                    $attendeesArray = array();
                    foreach ($arrMeetingAttendeesByMeetingId as $contact_id => $meetingAttendee) {
                        /* @var $meetingAttendee MeetingAttendee */

                        $meetingAttendeeContact = $meetingAttendee->getContact();
                        /* @var $meetingAttendeeContact Contact */

                        $meetingAttendeeContactFullNameHtmlEscaped = $meetingAttendeeContact->getContactFullNameHtmlEscaped();
                        $attendeesArray[] = $meetingAttendeeContactFullNameHtmlEscaped;
                    }
                    if(count($attendeesArray) > 1){
                        $attendandeesTd = implode(', ',$attendeesArray);
                    }else if(count($attendeesArray) == 1){
                        $attendandeesTd = $attendeesArray[0];
                    }else{
                        $attendandeesTd = '';
                    }
$htmlContent .= <<<END_HTML_CONTENT
                    <tr><td>$attendandeesTd</td></tr>
               </table>
        </td>
    </tr>
</table>
END_HTML_CONTENT;

// Get all discussion items for this project
$arrDiscussionItemsByMeetingId = DiscussionItem::loadDiscussionItemsByMeetingId($database, $meeting_id);

// If there are discussion items
if (count($arrDiscussionItemsByMeetingId) > 0) {

    $arrContactOptions[0] = 'Select Assignee';
    $arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId = MeetingAttendee::loadEligibleMeetingAttendeesByProjectIdAndMeetingTypeId($database, $project_id, $meeting_type_id);
    foreach ($arrEligibleMeetingAttendeesByProjectIdAndMeetingTypeId AS $contact_id => $contact) {
        /* @var $contact Contact */
        $contactFullName = $contact->getContactFullName();
        $arrContactOptions[$contact_id] = $contactFullName;
    }

    $arrDiscussionItemIds = array_keys($arrDiscussionItemsByMeetingId);
    $csvDiscussionItemIds = join(',', $arrDiscussionItemIds);

    // Get any action items associated with any of these discussion items
    $arrActionItemsByDiscussionItemIds = ActionItem::loadActionItemsByArrDiscussionItemIds($database, $arrDiscussionItemIds);
    // Get any comments associated with any of these discussion items
    $loadDiscussionItemCommentsByDiscussionItemIdsOptions = new Input();
    $loadDiscussionItemCommentsByDiscussionItemIdsOptions->forceLoadFlag = true;
    $arrDiscussionItemCommentsByDiscussionItemIds = DiscussionItemComment::loadDiscussionItemCommentsByDiscussionItemIds($database, $arrDiscussionItemIds, $loadDiscussionItemCommentsByDiscussionItemIdsOptions);
    $indexCount = 1;
    $rfiDataTableOpenID = array();
    $subDataTableOpenID = array();    
    $discussionHtmlContent = '';
    // Display for each discussion
    foreach ($arrDiscussionItemsByMeetingId AS $discussion_item_id => $discussionItem) {
        /* @var $discussionItem DiscussionItem */

        $discussionItemStatus = $discussionItem->getDiscussionItemStatus();
        /* @var $discussionItemStatus DiscussionItemStatus */

        // Discussion Item Data
        $discussionItem->htmlEntityEscapeProperties();
        $escaped_discussion_item_title = $discussionItem->escaped_discussion_item_title;
        $escaped_discussion_item = $discussionItem->escaped_discussion_item;
        $escaped_discussion_item_nl2br = $discussionItem->escaped_discussion_item_nl2br;

        // Discussion Item Status Data
        $discussionItemStatus->htmlEntityEscapeProperties();
        $discussion_item_status_id = $discussionItemStatus->discussion_item_status_id;
        $escaped_discussion_item_status = $discussionItemStatus->escaped_discussion_item_status;

        // Build the action table and assign it to a variable
        $isPrintView = true;
        $meetingInput = new Input();
        $meetingInput->database = $database;
        $meetingInput->arrContactOptions = $arrContactOptions;
        // $meetingInput->userCanCreateActionItems = $userCanCreateActionItems;
        // $meetingInput->userCanManageMeetings = $userCanManageMeetings;
        // $meetingInput->actionShowElement = $actionShowElement;
        // $meetingInput->actionEditElement = $actionEditElement;
        $meetingInput->isPrintView = $isPrintView;
        //$meetingInput->filterByIsVisibleFlag = true;

        $actionItemsTableByDiscussionItemId = buildMeetingActionItemsTableByDiscussionItemIdPdfReport($arrActionItemsByDiscussionItemIds, $discussion_item_id, $meetingInput);

        if (isset($arrActionItemsByDiscussionItemIds[$discussion_item_id])) {
            $arrActionItemsByDiscussionItemId = $arrActionItemsByDiscussionItemIds[$discussion_item_id];
            $actionItemCount = count($arrActionItemsByDiscussionItemId);
        } else {
            $arrActionItemsByDiscussionItemId = array();
            $actionItemCount = 0;
        }
        foreach ($arrActionItemsByDiscussionItemId AS $action_item_id => $actionItem) {
            $action_item_type_id = $actionItem->action_item_type_id;
            $action_item_type_reference_id = $actionItem->action_item_type_reference_id;           
            if($action_item_type_id == 5){
                if(!in_array($action_item_type_reference_id, $rfiDataTableOpenID))
                    $rfiDataTableOpenID[]= $action_item_type_reference_id;        
            }else if($action_item_type_id == 7){
                if(!in_array($action_item_type_reference_id, $subDataTableOpenID))
                    $subDataTableOpenID[]= $action_item_type_reference_id;
            }
        }

        // Build discussion_item_comment section and assign it to a variable
        $discussionItemCommentsTableByDiscussionItemId = buildDiscussionItemCommentsTableByDiscussionItemIdPdfReport($arrDiscussionItemCommentsByDiscussionItemIds, $discussion_item_id, $meetingInput);

        // Output the discussion table
        // $actionItemsTableByDiscussionItemId
        // $actionItemsTableByDiscussionItemId = str_replace("*SNO*",$escaped_discussion_item_title,$actionItemsTableByDiscussionItemId);

        $discussionHtmlContent .= <<<END_HTML_OUTPUT
        <tr class="fontSize12">
            <td valign="center" style="border-left:none;border-bottom:none !important;" class="paragraphBoldCal cellBorder borderDownNot CellBorderTop" rowspan="1">$escaped_discussion_item_title</td>
            <td class=" borderDownNot CellBorderTop text-justify" style="border-bottom:none !important;"><span class="marginDiscussionitem"></span></td>
            <td class="cellBorder borderDownNot CellBorderTop text-justify" colspan="3" style="border-bottom:none !important;"><span class="marginDiscussionitem">$escaped_discussion_item_nl2br</span>
END_HTML_OUTPUT;
if(($discussionItemCommentsTableByDiscussionItemId == '' && $discussionItemCommentsTableByDiscussionItemId == null) || ($escaped_discussion_item_nl2br=='' && $escaped_discussion_item_nl2br == null)){
$discussionHtmlContent .= <<<END_HTML_OUTPUT
            </td>
            <td class="cellBorder borderDownNot CellBorderTop align-center" style="border-bottom:none !important;">$escaped_discussion_item_status</td>
        </tr>
        $discussionItemCommentsTableByDiscussionItemId
END_HTML_OUTPUT;
}else{
    $discussionHtmlContent .= <<<END_HTML_OUTPUT
            </td>
            <td class="cellBorder borderDownNot CellBorderTop align-center" style="border-bottom:none !important;">$escaped_discussion_item_status</td>
        </tr>
END_HTML_OUTPUT;
}
if(($escaped_discussion_item_nl2br!='' && $escaped_discussion_item_nl2br != null) && ($discussionItemCommentsTableByDiscussionItemId !='' && $discussionItemCommentsTableByDiscussionItemId != null)){
$discussionHtmlContent .= <<<END_HTML_OUTPUT
        $discussionItemCommentsTableByDiscussionItemId
END_HTML_OUTPUT;
}

if($actionItemsTableByDiscussionItemId !='')
{
    $actionItemsTableByDiscussionItemId;
$discussionHtmlContent .= <<<END_HTML_OUTPUT
            $actionItemsTableByDiscussionItemId
END_HTML_OUTPUT;
}else{
    $actionItemsTableByDiscussionItemId;
    $discussionHtmlContent .= <<<END_HTML_OUTPUT
END_HTML_OUTPUT;
}
$indexCount++;
    }
    $disussionColspan =6;
    $rfiDataTableOpenIDStr = implode(',',$rfiDataTableOpenID);
    $subDataTableOpenIDStr = implode(',',$subDataTableOpenID);
    $rfiDataViewDisplay = RfiListViewWithResponseMeetingData($database, $project_id, $rfiDataTableOpenIDStr);
    $subDataViewDisplay = renderSuListViewForMeeting($database, $project_id, $subDataTableOpenIDStr);
    /*<thead class="borderBottom">
    <th class="textAlignLeft marginTopborderMT" width="20%">Action</th>
                <th class="textAlignLeft marginTopborderMT" width="20%">Responsible</th>
                <th class="textAlignLeft marginTopborderMT" width="12%">Due Date</th>
                <th class="textAlignLeft marginTopborderMT" width="12%">Completed Date</th>
                */
    $htmlContent .= <<<END_HTML_OUTPUT
    <br>
    $subDataViewDisplay
    $rfiDataViewDisplay
        <table id="MeetingTableWithDiscussion" class="content cell-border tableborder fontSize12" border="0" cellpadding="5" cellspacing="0" width="100%">           
                <tr class="table-headerinner">
                <td class="fontSize14 paragraphBoldCal marginrightborderMT" colspan="$disussionColspan" style="text-decoration:none;">Discussion Item</td>
                </tr>
                <tr>
                <td align="center" class="fontSize12 marginrightborderMT paragraphBoldCal" width="15%">Title</td>
                <td align="center" class="fontSize12 marginrightborderMT paragraphBoldCal"  colspan="4">Description</td>
                <td align="center" class="fontSize12 marginrightborderMT paragraphBoldCal" width="8%">Status</td>
                </tr>
            <tbody class="">
            $discussionHtmlContent
            </tbody>
        </table>
END_HTML_OUTPUT;
    // End if there are discussion items
} else {
    if (empty($show_all_flag)) {
        // There are no discussion items
        $NoData = 'This project does not have any open discussion items for this meeting';
    } else {
        $NoData = 'This project does not have any discussion items for this meeting';
    }
    $disussionColspan =7;
    $htmlContent .= <<<END_HTML_OUTPUT
    <br>
      <table id="MeetingTableWithDiscussion" class="content cell-border tableborder" border="0" cellpadding="5" cellspacing="0" width="100%">
      		<thead class="borderBottom">
                <tr class="table-headerinner"><th class="textAlignLeft" colspan="$disussionColspan">Disscussion Item</th></tr>
               </thead>
            <tbody class="altColors">
            <tr>
            	<td colspan="$disussionColspan">$NoData</td>
            </tr>
            </tbody>
        </table>
END_HTML_OUTPUT;
}
return $htmlContent;
}

//To generate transmittal
function meetingDataHeaderfortransmittal($database, $user_company_id, $project_name, $type_mention, $htmlContent)
{
    /*GC logo*/
require_once('lib/common/Logo.php');
// $gcLogo = Logo::logoByUserCompanyIDUsingSoftlink($database,$user_company_id);
$gcLogo = Logo::logoByUserCompanyIDforemail($database,$user_company_id);
$fulcrum = Logo::logoByFulcrum();
 //To generate logo
            $uri = Zend_Registry::get('uri');
            if ($uri->sslFlag) {
                $cdn = 'https:' . $uri->cdn;
            } else {
                $cdn = 'http:' . $uri->cdn;
            }

    $gclogo_image="<img alt='Logo' style='margin-left:0px;' src='".$cdn.$gcLogo."'>";
/*GC logo end*/
/*footer data*/
$data = reportFooterMeeting($database, $user_company_id);
$address = $data['address'];
$number = $data['number'];
$config = Zend_Registry::get('config');
$basefont = $config->system->file_manager_url .'fonts/calibri/calibri.ttf' ;
$baseinnerfont = $config->system->file_manager_url .'fonts/calibri/calibri-bold.ttf' ;
//Store the html data's
$html = <<<ENDHTML
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
.celborderleftright {
    border-left:1px solid #CBC8C8;
    border-right:1px solid #CBC8C8;
}
table tr th,table tr td{
    font-family : Calibri;
}
.marginleftMet{
    margin-left:60px;
}
.detailed_week tr th{
    text-transform:uppercase;
}
body{
    /*font-size : 15pts;*/
    font-family : Calibri;
}
.headerSize18{
    /*font-size:16pts;*/
    text-transform : uppercase;
}
/*meeting report css*/
.ActionItemAssigneesTable tr td{
border:0 !important;
}
.marginDiscussionitem{
    margin:10px;
}
.borderDownNot{
    border-bottom: none !important;
}
.textUdCal{
/*text-decoration:underline;*/
border-bottom:1px solid #CBC8C8;
color:#000;
}
.textUd{
text-decoration:underline;
color:#000;
}
.tableHeaderInnerMeeting{
        color:#3487c7;
        font-weight:semi-bold;
}
.paragraphMargin{
    margin:0;
    font-weight:normal;
}
.paragraphBoldCal{
    font-family: 'Calibri-bold';
}
.paragraphBold{
    font-weight:bold;
}
.CellBorderTop{
        border-top:1px solid #CBC8C8;
}
#MeetingTableWithDiscussion tr .TDBorderTop{
    border-top:1px solid #CBC8C8;
    border-bottom:1px solid #CBC8C8;
}
#MeetingTableWithDiscussion tr .TDBorder{
    border-bottom:1px solid #CBC8C8;
}
#MeetingTableWithDiscussion tr .cellBorder, #MeetingTableWithDiscussion tr th{
    border-right:1px solid #CBC8C8;
    border-bottom:1px solid #CBC8C8;
}
#MeetingTableWithDiscussion tr .tdBold {
    font-weight : bold;
}
.MeetingTableWithInfo tr td, .MeetingTableWithInfo tr th{
    border-right:1px solid #CBC8C8;
}

.fontSize16{
    font-size:16pts;
    /*text-decoration:underline;*/
    font-family: 'Calibri-bold';
    text-transform:uppercase;
    border-bottom:1px solid #CBC8C8;
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
.project_nameCal{
    text-align:center;
    font-size:18pts;
    font-family:'Calibri-bold';
    text-transform : uppercase;
    border-bottom: 1px solid #cbc8c8;
}
/*Bid list css*/
.oddRow, .oddRowNotClickable {
    background-color: #efefef;
}
.borederRowBid td{
    border-bottom: 1px solid #cbc8c8;
    border-top: 1px solid #cbc8c8;
}
/*Manpower css*/
#manpower_activity_monthly tr td,#manpower_activity tr td,#manpower_activity tr th{
border:1px solid #8E8787;
}
#manpower_activity_monthly{
font-size:7px;
}
/*Manpower css end*/
#RFiReportQA .marginTopborder{
border-top:1px solid #CBC8C8;border-bottom:1px solid #CBC8C8;
}
#PurchaseingLog,#ForecastLog{
width:100%;
}
.backwhite{
    background-color: whitesmoke;
}
.bold{
font-weight:bold;
}
.align-center{
    text-align:center;
}
.borderBottom {
    border-bottom: 1px solid #CBC8C8;
}
.altColors tr:nth-child(2n+1) {
    background-color: #fff;
}
.altColors tr:nth-child(2n) {
    background-color: whitesmoke;
}

.detailed_week,.tableborder{
    margin-bottom:2%;
    border:1px;
}
.even{
    background-color:#f5f5f5;
}
.odd{
    /*background-color:#E4E2E0;*/
}
td p, .con_jus,.text-justify{
    text-align:justify;
    text-wordwrap:wordbreak;
}
.align-left,.textAlignLeft{
    text-align:left;
}
.align-right{
    text-align:right;
}
.table-header{
    margin:0;
    padding:0;
}
.report-name{
    font-size:16px;
    font-weight:bold;
    text-transform: uppercase;
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
    font-size:18px !important;
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
@page { margin: 30px 50px 80px 50px; }
// .header{position: fixed; top:-100px;}
#footer { position: fixed; left: 0px; bottom: -25px; right: 0px; height: 30px; }
.footer { position: fixed;  bottom: -60px; right: 80px; height: 30px;font-size:10px;left:130px;color: #aaa;
}
.cellRTNot
{
    border-right:1px solid #CBC8C8;
    border-top:1px solid #CBC8C8;
    border-bottom:1px solid #CBC8C8;
}
.textUpper{
    text-transform : uppercase;
}
.nowrapspace{
    word-wrap:nowrap;white-space:nowrap;
}
</style>

</head>
 <body>
 <div class="header">
 <table width="100%" class="">
 <tr>
 <td>$gclogo_image</td>
 <td class="align-right">$fulcrum</td>
 </tr>
 </table>
 </div>
 <div class="footer">
 <table width="100%" >
 <tr>
 <td class="align-center">$address $number</td>
 </tr>
 </table>
 </div>
  <table width="100%">
 <tr>
 <td align="center"><span class="project_nameCal">$project_name</span></td>
 </tr>
 </table>
 
 <span class="report-name">$type_mention</span>
 $htmlContent
 </body>
</html>
ENDHTML;
return $html;
}

function meetingDataPreviewWithHeader($database, $user_company_id, $project_name, $type_mention, $htmlContent, $fulcrumlogo = false)
{
    /*GC logo*/
require_once('lib/common/Logo.php');
// $gcLogo = Logo::logoByUserCompanyIDUsingSoftlink($database,$user_company_id);
$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id, true);
// if true load by base path
if($fulcrumlogo){
    $fulcrum = Logo::logoByFulcrumByBasePath(true);
}else{
    $fulcrum = Logo::logoByFulcrum();    
}

/*GC logo end*/
/*footer data*/
$data = reportFooterMeeting($database, $user_company_id);
$address = $data['address'];
$number = $data['number'];
$config = Zend_Registry::get('config');
$basefont = $config->system->file_manager_url .'fonts/calibri/calibri.ttf' ;
$baseinnerfont = $config->system->file_manager_url .'fonts/calibri/calibri-bold.ttf' ;
//Store the html data's
$html = <<<ENDHTML
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
.celborderleftright {
    border-left:1px solid #cbc8c8;
    border-right:1px solid #cbc8c8;
}
table tr th,table tr td{
    font-family : Calibri;
}
.marginleftMet{
    margin-left:60px;
}
.marginleft40{
    margin-left:40px;
}
.marginleft20{
    margin-left:20px;
}
.detailed_week tr th{
    text-transform:uppercase;
}
body{
    /*font-size : 15pts;*/
    font-family : Calibri;
}
.headerSize18{
    /*font-size:16pts;*/
    text-transform : uppercase;
}
/*meeting report css*/
.ActionItemAssigneesTable tr td{
border:0 !important;
}
.marginDiscussionitem{
    margin:10px;
}
.borderDownNot{
    border-bottom: none !important;
}
.textUdCal{
/*text-decoration:underline;*/
border-bottom:1px solid #CBC8C8;
color:#000;
}
.textUd{
text-decoration:underline;
color:#000;
}
#record_list_container--manage-request_for_information-record,
#record_list_container--manage-submittal-record,
#MeetingTableWithDiscussion  {
   border:1px solid #CBC8C8 !important;
}
.tableHeaderInnerMeeting{
        color:#3487c7;
        font-weight:semi-bold;
}
.paragraphMargin{
    margin:0;
    font-weight:normal;
}
.paragraphBoldCal{
    font-family: 'Calibri-bold';
}
.paragraphBold{
    font-weight:bold;
}
.CellBorderTop{
        border-top:1px solid #CBC8C8;
}
#MeetingTableWithDiscussion tr .TDBorderTop{
    border-top:1px solid #CBC8C8;
    border-bottom:1px solid #CBC8C8;
}
#MeetingTableWithDiscussion tr .TDBorder{
    border-bottom:1px solid #CBC8C8;
}
#MeetingTableWithDiscussion tr .cellBorder, #MeetingTableWithDiscussion tr th{
    border-right:1px solid #CBC8C8;
    border-bottom:1px solid #CBC8C8;
}
#MeetingTableWithDiscussion tr .tdBold {
    font-weight : bold;
}
.MeetingTableWithInfo tr td, .MeetingTableWithInfo tr th{
    border-right:1px solid #CBC8C8;
}

.fontSize16{
    /*font-size:16pts;*/
    font-size:16px;
    /*text-decoration:underline;*/
    font-family: 'Calibri-bold';
    text-transform:uppercase;
    border-bottom:1px solid #CBC8C8;
}
.fontSize14{
    font-size:14px;
    font-family: 'Calibri-bold';
    text-transform:uppercase;
    border-bottom:1px solid #CBC8C8;
}
.fontSize12{
    font-size:12px;
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
.project_nameCal{
    text-align:center;
    /*font-size:18pts;*/
    font-size:18px;
    font-family:'Calibri-bold';
    text-transform : uppercase;
    border-bottom: 1px solid #cbc8c8;
}
/*Bid list css*/
.oddRow, .oddRowNotClickable {
    background-color: #efefef;
}
#record_list_container--manage-request_for_information-record td,
#record_list_container--manage-submittal-record td,
#MeetingTableWithDiscussion td {
   border-color: #cbc8c8;
}
#record_list_container--manage-request_for_information-record thead,
#record_list_container--manage-submittal-record thead,
#MeetingTableWithDiscussion thead {
   border-right: 1px solid #cbc8c8 !important;
}
.borederRowBid td{
    border-bottom: 1px solid #cbc8c8;
    border-top: 1px solid #cbc8c8;
}
/*Manpower css*/
#manpower_activity_monthly tr td,#manpower_activity tr td,#manpower_activity tr th{
border:1px solid #CBC8C8;
}
#manpower_activity_monthly{
font-size:7px;
}
/*Manpower css end*/
#RFiReportQA .marginTopborder{
border-top:1px solid #CBC8C8;
border-bottom:1px solid #CBC8C8;
}
#PurchaseingLog,#ForecastLog{
width:100%;
}
.backwhite{
    background-color: whitesmoke;
}
.bold{
font-weight:bold;
}
.align-center{
    text-align:center;
}
.borderBottom {
    border-bottom: 1px solid #CBC8C8;
}
.altColors tr:nth-child(2n+1) {
    background-color: #fff;
}
.altColors tr:nth-child(2n) {
    background-color: whitesmoke;
}
.altColors tr td:first-child {
    border-left: 1px solid #cbc8c8;
}
.altColors tr td:last-child {
    border-right: 1px solid #cbc8c8;
}
.detailed_week,.tableborder{
    margin-bottom:2%;
    border:1px;
}
.even{
    background-color:#f5f5f5;
}
.odd{
    /*background-color:#E4E2E0;*/
}
td p, .con_jus,.text-justify{
    text-align:justify;
    text-wordwrap:wordbreak;
}
.align-left,.textAlignLeft{
    text-align:left;
}
.align-right{
    text-align:right;
}
.table-header{
    margin:0;
    padding:0;
}
.report-name{
    font-size:16px;
    font-weight:bold;
    text-transform: uppercase;
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
    font-size:18px !important;
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
@page { margin: 30px 50px 80px 50px; }
// .header{position: fixed; top:-100px;}
#footer { position: fixed; left: 0px; bottom: -25px; right: 0px; height: 30px; }
.footer { position: fixed;  bottom: -60px; right: 80px; height: 30px;font-size:10px;left:130px;color: #aaa;
}
.cellRTNot
{
    border-right:1px solid #CBC8C8;
    border-top:1px solid #CBC8C8;
    border-bottom:1px solid #CBC8C8;
}
.textUpper{
    text-transform : uppercase;
}
.nowrapspace{
    word-wrap:nowrap;white-space:nowrap;
}
</style>

</head>
 <body>
 <div class="header">
 <table width="100%" class="">
 <tr>
 <td>$gcLogo</td>
 <td class="align-right">$fulcrum</td>
 </tr>
 </table>
 </div>
 <div class="footer">
 <table width="100%" >
 <tr>
 <td class="align-center">$address $number</td>
 </tr>
 </table>
 </div>
  <table width="100%">
 <tr>
 <td align="center"><span class="project_nameCal">$project_name</span></td>
 </tr>
 </table>
 
 <span class="report-name">$type_mention</span>
 $htmlContent
 </body>
</html>
ENDHTML;
return $html;
}
/*Gc company address*/
 function reportFooterMeeting($database, $user_company_id)
{
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
    if($row2)
    {
        $CompanyOfficeId=$row2['id'];
        if($row2['address_line_1']!='')
        {
            $Footeraddress.=$row2['address_line_1'];
        }
        if($row2['address_city']!='')
        {
            $Footeraddress.=' | '.$row2['address_city'];
        }
        if($row2['address_state_or_region']!='')
        {
            $Footeraddress.=' , '.$row2['address_state_or_region'];
        }
        if($row2['address_postal_code']!='')
        {
            $Footeraddress.='  '.$row2['address_postal_code'];
        }
    }else{
        $query4="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId   order by id desc limit 1";
        $db->execute($query4);
        $row4=$db->fetch();

        $CompanyOfficeId=$row4['id'];
        if($row4['address_line_1']!='')
        {
            $Footeraddress.=$row4['address_line_1'];
        }
        if($row4['address_city']!='')
        {
            $Footeraddress.=' | '.$row4['address_city'];
        }
        if($row4['address_state_or_region']!='')
        {
            $Footeraddress.=' , '.$row4['address_state_or_region'];
        }
        if($row4['address_postal_code']!='')
        {
            $Footeraddress.='  '.$row4['address_postal_code'];
        }
    }
    
    $query3="SELECT * FROM `contact_company_office_phone_numbers` WHERE `contact_company_office_id` = $CompanyOfficeId";
    $db->execute($query3);
    $business='';
    $fax='';
    while ($row3 = $db->fetch()) 
    {
     if($row3['phone_number_type_id']=='1')
     {
        $business = $row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
    } 
    if($row3['phone_number_type_id']=='2')
    {
        $fax = ' | (F)'.$row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
    }   
}
$Footeraddress=trim($Footeraddress,'| ');
$faxPhone =$business.$fax;
$db->free_result();
return array('address'=>strtoupper($Footeraddress),'number'=>$faxPhone);
 
}
function buildMeetingActionItemsTableByDiscussionItemIdPdfReport($arrActionItemsByDiscussionItemIds, $discussion_item_id, Input $input)
{

    $database = $input->database;
    $arrContactOptions = $input->arrContactOptions;
    $isPrintView = $input->isPrintView;
    $rfiDatas = array();
    $submittalDatas = array();
    $generalDatas = array();
    //$filterByIsVisibleFlag = $meetingInput->filterByIsVisibleFlag;

    /*
    if (!isset($filterByIsVisibleFlag)) {
        $filterByIsVisibleFlag = false;
    }
    */

    if (isset($arrActionItemsByDiscussionItemIds[$discussion_item_id])) {
        $arrActionItemsByDiscussionItemId = $arrActionItemsByDiscussionItemIds[$discussion_item_id];
        $actionItemCount = count($arrActionItemsByDiscussionItemId);
    } else {
        $arrActionItemsByDiscussionItemId = array();
        $actionItemCount = 0;
    }

    $actionItemsTableByDiscussionItemIdTdAssignmentStyle = 'action-table-td-assignment';
    $actionItemsTableByDiscussionItemIdTdDescriptionStyle = 'action-table-td-description';
    if (isset($isPrintView) && $isPrintView) {
        $actionItemsTableByDiscussionItemIdTdAssignmentStyle = 'action-table-td-assignment printView';
        $actionItemsTableByDiscussionItemIdTdDescriptionStyle = 'action-table-td-description printView';
    }
    $structureValues = 0;
    if (!empty($arrActionItemsByDiscussionItemId)) {
        /*$actionItemsTableByDiscussionItemId = <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;

        $actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;*/
        $structureValues = 0;
        $structureItem = 1;
        $structureItemrfi = 1;
        $structureItemsub = 1;
        $actionItemDetails = '';
        $first = 'false';
        $curcompany = '';
        $oddMTEven = 1;
        foreach ($arrActionItemsByDiscussionItemId AS $action_item_id => $actionItem) {
            /* @var $actionItem ActionItem */

            $project = $actionItem->getProject();
            /* @var $project Project */

            $actionItemType = $actionItem->getActionItemType();
            /* @var $actionItemType ActionItemType */

            $actionItemStatus = $actionItem->getActionItemStatus();
            /* @var $actionItemStatus ActionItemStatus */

            $actionItemPriority = $actionItem->getActionItemPriority();
            /* @var $actionItemPriority ActionItemPriority */

            $actionItemCostCode = $actionItem->getActionItemCostCode();
            /* @var $actionItemCostCode CostCode */

            $createdByContact = $actionItem->getCreatedByContact();
            /* @var $createdByContact Contact */

            //$created_by = $arrActions[$discussion_item_id][$action_item_id]['creatorName'];
            $created_by = $createdByContact->getContactFullName();

            $created = $actionItem->created;

            // Encoded Action Item Data
            $actionItem->htmlEntityEscapeProperties();
            $action_item_title = $actionItem->action_item_title;
            $escaped_action_item_title = $actionItem->escaped_action_item_title;
            $action_item = $actionItem->action_item;
            $action_item_type_id = $actionItem->action_item_type_id;
            $escaped_action_item = $actionItem->escaped_action_item;
            $action_item_type_reference_id = $actionItem->action_item_type_reference_id;
            
            //$arrAssignees = $arrActions[$discussion_item_id][$action_item_id]['assignees'];
            $loadActionItemAssignmentsByActionItemIdOptions = new Input();
            $loadActionItemAssignmentsByActionItemIdOptions->forceLoadFlag = true;
            $arrActionItemAssignmentsByActionItemId = ActionItemAssignment::loadActionItemAssignmentsByActionItemId($database, $action_item_id, $loadActionItemAssignmentsByActionItemIdOptions);

            $action_item_due_date = $actionItem->action_item_due_date;
            $action_item_completed_timestamp = $actionItem->action_item_completed_timestamp;

            if (!isset($created_date) || $created_date == '0000-00-00') {
                $created_date = '';
            } else {
                $createdUnixTimestamp = strtotime($created);
                $created_date = date('m/d/Y g:ia', $createdUnixTimestamp);
                //$created_date = date("m/d/Y",strtotime($created_date));
            }
            if (!isset($action_item_due_date) || $action_item_due_date == '0000-00-00') {
                $action_item_due_date = 'N/A';
            } else {
                $action_item_due_date = date('m/d/Y', strtotime($action_item_due_date));
            }
            if (!isset($action_item_completed_timestamp) || $action_item_completed_timestamp == '0000-00-00 00:00:00') {
                $action_item_completed_timestamp = 'N/A';
            } else {
                $action_item_completed_timestamp = date('m/d/Y',strtotime($action_item_completed_timestamp));
            }
            $actionItemAssigneesTableByActionItemId = buildAssigneeListItemsForActionItemReport($arrActionItemAssignmentsByActionItemId, $action_item_id, $input);
            if($action_item_type_reference_id == 0 || $action_item_type_reference_id == '' || $action_item_type_reference_id == null){
                $action_item_type_reference_id = '';
            }
            $options = array();  
            if($action_item_type_id == 5){
                $options['table'] = 'requests_for_information';
                $options['filter'] = array('id = ?'=> $action_item_type_reference_id);
                $options['fields'] = array('rfi_sequence_number as reference');
                $headername = 'Open RFIs';
                $actionItemsTableByDiscussionItemId = <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
$escaped_action_item
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
                $rfiDatas[$structureItemrfi][0] = $actionItemsTableByDiscussionItemId;
                $rfiDatas[$structureItemrfi][1] = $actionItemAssigneesTableByActionItemId;
                $rfiDatas[$structureItemrfi][2] = $action_item_due_date;
                $rfiDatas[$structureItemrfi][3] = $action_item_completed_timestamp;
                $structureItemrfi++;
            }else if($action_item_type_id == 7){
                $options['table'] = 'submittals';
                $options['filter'] = array('id = ?'=> $action_item_type_reference_id);
                $options['fields'] = array('su_sequence_number as reference');
                $headername = 'Open Submittals';
                $actionItemsTableByDiscussionItemId = <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
$escaped_action_item
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
                $submittalDatas[$structureItemsub][0] = $actionItemsTableByDiscussionItemId;
                $submittalDatas[$structureItemsub][1] = $actionItemAssigneesTableByActionItemId;
                $submittalDatas[$structureItemsub][2] = $action_item_due_date;
                $submittalDatas[$structureItemsub][3] = $action_item_completed_timestamp;
                $structureItemsub++;
            }else{
                $actionItemsTableByDiscussionItemId = <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
$escaped_action_item
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
                    $generalDatas[$structureItem][0] = $actionItemsTableByDiscussionItemId;
                    $generalDatas[$structureItem][1] = $actionItemAssigneesTableByActionItemId;
                    $generalDatas[$structureItem][2] = $action_item_due_date;
                    $generalDatas[$structureItem][3] = $action_item_completed_timestamp;
                    $structureItem++;
                }
                $structureValues++;

    if($oddMTEven%2){
        $styleMt = 'style="background-color: whitesmoke;"';
    }else{
        $styleMt = '';
    }
    $oddMTEven++;    

    if($action_item_type_id == 5 || $action_item_type_id == 7){
        $referenceOutput = TableService::GetTabularData($database,$options);
        $referenceName = $referenceOutput['reference'];
    }else{
        $referenceName = $structureValues;
    }

    if($curcompany <> $action_item_type_id){
        $curcompany=$action_item_type_id;
        if ($first) {
            $first = 'true';
        }
    }else{
        $first = 'false';
    }

    if (($action_item_type_id == 5 || $action_item_type_id == 7) && $first == 'true'){   

    $actionItemDetails.= <<<actionTemDetailsRows
    <tr>
        <td class="celborderleftright cellRTNotWback" style="border-left:none;border-bottom:none;"></td>
        <td colspan="4" style="font-size:14px;border-bottom:1px solid #CBC8C8;border-top:1px solid #CBC8C8;border-right:none;">
            <span class="paragraphBoldCal tableHeaderInnerMeeting">$headername</span>
        </td>
        <td style="border-left:none !important;border-bottom:1px solid #CBC8C8;border-top:1px solid #CBC8C8;"></td>
    </tr>
actionTemDetailsRows;
}

                $actionItemDetails.=<<<actionTemDetailsRows
<tr class="fontSize12" id="table-inside-bordernone" $styleMt>
    <td class="celborderleftright cellRTNotWback" style="border-left:none;" id="border-0"></td>
    <td class="commnetdNoBorder border-right-none" style="border:none !important;">$referenceName</td>
    <td class="commnetdNoBorder border-right-none" style="border:none !important;">$actionItemsTableByDiscussionItemId</td>
    <td class="commnetdNoBorder border-right-none" style="border:none !important;">$actionItemAssigneesTableByActionItemId</td>
    <td class="align-center commnetdNoBorder border-right-none" style="border:none !important;">$action_item_due_date</td>
    <td class="align-center commnetdNoBorder border-right-none" style="border:none !important;">$action_item_completed_timestamp</td>
</tr>
actionTemDetailsRows;
            }
            
        /*$actionItemsTableByDiscussionItemId .= <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;*/

    } else {
/*        $actionItemsTableByDiscussionItemId = <<<END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID
        <div class="headerActions" style="display: none;">
            <a href="#">Action Items (0)</a>
        </div>
END_ACTION_ITEMS_TABLE_BY_DISCUSSION_ITEM_ID;
*/    }
$count = 1;
$rfiDatastr = '';
$submittalDatastr = '';
$generalDatastr='';
$rfiDatastrres = '';
$submittalDatastrres = '';
$generalDatastrres='';
$rfiDatastrdue = '';
$submittalDatastrdue = '';
$generalDatastrdue='';
$rfiDatastrcmd = '';
$submittalDatastrcmd = '';
$generalDatastrcmd='';
/*if(!empty($generalDatas)){
    foreach($generalDatas as $data => $viewData){
        $generalDatastr .=<<<GeneralDatas
<span class="paragraphMargin">$count) $viewData[0]</span><br>
GeneralDatas;
$generalDatastrres .=<<<GeneralDatas
<tr valign="top"><td>$count)</td><td><span class="paragraphMargin"> $viewData[1]</span></td></tr>
GeneralDatas;
$generalDatastrdue .=<<<GeneralDatas
<span class="paragraphMargin">$count) $viewData[2]</span><br>
GeneralDatas;
$generalDatastrcmd .=<<<GeneralDatas
<span class="paragraphMargin">$count) $viewData[3]</span><br>
GeneralDatas;
    $count++;
    }
}
if(!empty($rfiDatas)){
    $rfiDatastr =<<<RFIData
<span class="paragraphMargin paragraphBold">RFI's :</span><br>
RFIData;
    foreach($rfiDatas as $data => $viewData){
        $rfiDatastr .=<<<RFIData
<span class="paragraphMargin">$count) $viewData[0]</span><br>
RFIData;
$rfiDatastrres .=<<<RFIData
<tr valign="top"><td>$count)</td><td><span class="paragraphMargin"> $viewData[1]</span></td></tr>
RFIData;
$rfiDatastrdue .=<<<GeneralDatas
<span class="paragraphMargin">$count) $viewData[2]</span><br>
GeneralDatas;
$rfiDatastrcmd .=<<<GeneralDatas
<span class="paragraphMargin">$count) $viewData[3]</span><br>
GeneralDatas;
    $count++;
    }
}
if(!empty($submittalDatas)){
    $submittalDatastr =<<<SUBData
<span class="paragraphMargin paragraphBold">Submittal's :</span><br>
SUBData;
    foreach($submittalDatas as $data => $viewData){
        $submittalDatastr.=<<<SUBData
<span class="paragraphMargin">$count) $viewData[0]</span><br>
SUBData;
        $submittalDatastrres.=<<<SUBData
<tr valign="top"><td>$count)</td><td><span class="paragraphMargin"> $viewData[1]</span></td></tr>
SUBData;
$submittalDatastrdue .=<<<GeneralDatas
<span class="paragraphMargin">$count) $viewData[2]</span><br>
GeneralDatas;
$submittalDatastrcmd .=<<<GeneralDatas
<span class="paragraphMargin">$count) $viewData[3]</span><br>
GeneralDatas;
    $count++;
    }
}*/
if($structureValues!=0){
$actionItemsTableByDiscussionItemId =<<<AllCombinedData
    <tr class="backwhite fontSize14" style="border-bottom:none !important;">
        <td class="celborderleftright cellRTNotWback" id="border-0" style="border-left:none;"></td>
        <td colspan="4" class="CellBorderTop border-right-0" style="border-right:none;" id="border-0">
            <span class="paragraphMargin paragraphBoldCal tableHeaderInnerMeeting">ACTION ITEMS ($actionItemCount)</span><br>
        </td>
        <td class="CellBorderTop celborderleftright border-left-0" style="border-left:none !important;" id="border-0"></td>
    </tr>
    <tr class="fontSize12">
        <td class="celborderleftright cellRTNotWback" style="border-left:none;" id="border-0"></td>
        <td style="border:none !important;border-bottom:1px solid #CBC8C8 !important;border-top:1px solid #CBC8C8 !important;" width="3%" class="commnetdNoBorder"><span class="paragraphMargin paragraphBoldCal">#</span></td>
        <td style="border:none !important;border-bottom:1px solid #CBC8C8 !important;border-top:1px solid #CBC8C8 !important;" width="" class="commnetdNoBorder"><span class="paragraphMargin paragraphBoldCal">Tasks</span></td>
        <td style="border:none !important;border-bottom:1px solid #CBC8C8 !important;border-top:1px solid #CBC8C8 !important;" width="20%" class="commnetdNoBorder"><span class="paragraphMargin paragraphBoldCal">Assignee(s)</span></td>
        <td style="border:none !important;border-bottom:1px solid #CBC8C8 !important;border-top:1px solid #CBC8C8 !important;border-right:none !important;" width="15%" class="align-center commnetdNoBorder"><span class="paragraphMargin paragraphBoldCal">Due</span></td>
        <td width="13%" style="border-bottom:1px solid #CBC8C8 !important;border-top:1px solid #CBC8C8 !important;border-left:none !important;" class="align-center commnetdNoBorder"><span class="paragraphMargin paragraphBoldCal">Completed</span></td>
    </tr>
    $actionItemDetails
AllCombinedData;
}else{
    // <span class="paragraphMargin paragraphBoldCal">Action Item</span><br>
//     <td class="cellRTNot cellRTNotWback"></td>
// <td class="cellRTNot" colspan="2">
// <span class="paragraphMargin paragraphBoldCal tableHeaderInnerMeeting">ACTION ITEM</span> : No Action Item
// </td>
    $actionItemsTableByDiscussionItemId =<<<AllCombinedData
AllCombinedData;
}
return $actionItemsTableByDiscussionItemId;
}
function buildAssigneeListItemsForActionItemReport($arrActionItemAssignmentsByActionItemId, $action_item_id, Input $input)
{

    $database = $input->database;
    $arrContactOptions = $input->arrContactOptions;

    $isPrintView = $input->isPrintView;

    // Remove any assignees that had a contact_id value of 0
    //unset($arrAssignees[0]);

    $actionAssigneesListItems = '';
    if (count($arrActionItemAssignmentsByActionItemId) > 0) {

        foreach ($arrActionItemAssignmentsByActionItemId AS $actionItemAssignment) {
            /* @var $actionItemAssignment ActionItemAssignment */

            $action_item_id = $actionItemAssignment->action_item_id;
            $action_item_assignee_contact_id = $actionItemAssignment->action_item_assignee_contact_id;

            $actionItem = $actionItemAssignment->getActionItem();
            /* @var $actionItem ActionItem */

            $actionItemAssigneeContact = $actionItemAssignment->getActionItemAssigneeContact();
            /* @var $actionItemAssigneeContact Contact */

            $actionItemAssigneeContactId = $actionItemAssigneeContact->contact_id;

            $actionItemAssigneeContactFullNameHtmlEscaped = $actionItemAssigneeContact->getContactFullNameHtmlEscaped();
            $actionAssigneesListItems .= <<<END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS

                                $actionItemAssigneeContactFullNameHtmlEscaped <br>
END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS;
        }

    } else {
            $actionAssigneesListItems .= <<<END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS
                            N/A <br>
END_ACTION_ITEM_ASSIGNEES_LIST_ITEMS;
    }

    return $actionAssigneesListItems;
}
// to get RFi Data
function RfiListViewWithResponseMeetingData($database, $project_id, $WhereIn)
{
    $loadRequestsForInformationByProjectIdOptions = new Input();
    $loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
    if($WhereIn != '' && $WhereIn != null) {
        $arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByIdIn($database, $project_id, $loadRequestsForInformationByProjectIdOptions, $WhereIn);
    } else {
        $arrRequestsForInformation =array();
    }
    

    $rfiTableTbody = '';
    $GetCount=count($arrRequestsForInformation);
    if($GetCount == '0')
    {
        $rfiTableTbody="<tr><td colspan='8'>No Data Available for Selected Meeting</td></tr>";
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

<table id="record_list_container--manage-request_for_information-record" class="detailed_week content fontSize12" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom ">
    <tr class="table-headerinner fontSize14" style="text-decoration:none;"><td colspan='8' class='align-left textUpper paragraphBoldCal'>Open Request For Information</td></tr>
        <tr>
        <td class="textAlignCenter paragraphBoldCal textUpper">RFI #</td>
        <td class="textAlignLeft paragraphBoldCal textUpper">Description</td>
        <td class="textAlignLeft paragraphBoldCal textUpper">Open</td>
        <td class="textAlignLeft paragraphBoldCal textUpper">Due By</td>
        <td class="textAlignLeft paragraphBoldCal textUpper">Response</td>
        <td class="textAlignLeft paragraphBoldCal textUpper">Recipient</td>
        <td class="textAlignLeft paragraphBoldCal textUpper">Priority</td>
        <td class="textAlignCenter paragraphBoldCal textUpper">Days Open</td>
        </tr>
    </thead>
    <tbody class="altColors">
        $rfiTableTbody
    </tbody>
</table>

END_HTML_CONTENT;
if($GetCount == '0')
{
    return '';
}else{
    return $htmlContent;
}
}
//To fetch Submittal by Id
function renderSuListViewForMeeting($database, $project_id, $WhereIn)
{
   
    $loadSubmittalsByProjectIdOptions = new Input();
    $loadSubmittalsByProjectIdOptions->forceLoadFlag = true;
    if($WhereIn != '' && $WhereIn != null) {
        $arrSubmittals = Submittal::loadSubmittalsByProjectIdAndIdIn($database, $project_id, $loadSubmittalsByProjectIdOptions, $WhereIn);
    } else {
        $arrSubmittals = array();
    }
    
    $suTableTbody = '';

    $suTableTbody = '';
    $GetCount=count($arrSubmittals);
    if($GetCount == '0')
    {
        $suTableTbody="<tr><td colspan='7'>No Data Available for Selected Meeting</td></tr>";
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

        if (empty($escaped_su_plan_page_reference)) {
            $escaped_su_plan_page_reference = '&nbsp;';
        }

        if ($suCostCode) {
            // Extra: Submittal Cost Code - Cost Code Division
            $suCostCodeDivision = $suCostCode->getCostCodeDivision();
            /* @var $suCostCodeDivision CostCodeDivision */

            $formattedSuCostCode = $suCostCode->getFormattedCostCode($database,false);

            //$htmlEntityEscapedFormattedSuCostCodeLabel = $suCostCode->getHtmlEntityEscapedFormattedCostCode();
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
        if ($su_due_date == '') {
            $su_due_date = '';
        }else{
            $su_due_date=date("m/d/Y",strtotime($su_due_date));
        }
        // submittal_statuses:
        // 1 - Draft
        // 2 - Open
        // 3 - In Progress
        // 4 - Closed

        $submittal_status = $submittalStatus->submittal_status;
        // if Submittal status is "closed"
        if (!$su_closed_date) {
            $su_closed_date = '0000-00-00';
        }
        if (($submittal_status == 'Closed') && ($su_closed_date <> '0000-00-00')) {
            $closedDateUnixTimestamp = strtotime($su_closed_date);
            if ($su_closed_date <> '0000-00-00') {

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
        $count_days=strlen($daysOpen);
        if($count_days=='1')
        {
            $daysOpen='00'.$daysOpen;
        }else if($count_days=='2')
        {
            $daysOpen='0'.$daysOpen;
        }

        $suTableTbody .= <<<END_SUBMITTAL_TABLE_TBODY

        <tr id="record_container--manage-submittal-record--submittals--$submittal_id" onclick="Submittals__loadSubmittalModalDialog('$submittal_id');">
            <td class="textAlignCenter" id="manage-submittal-record--submittals--su_sequence_number--$submittal_id" nowrap>$su_sequence_number</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_title--$submittal_id">$escaped_su_title</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--recipientFullName--$submittal_id" nowrap>$suRecipientContactFullNameHtmlEscaped<input type="hidden" id="manage-submittal-record--submittals--su_recipient_contact_id--$submittal_id" value="$su_recipient_contact_id"></td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_created--$submittal_id" nowrap>$formattedSuCreatedDate</td>
            <td class="textAlignLeft" id="manage-submittal-record--submittals--su_due_date--$submittal_id" nowrap>$su_due_date</td>
            
            <td class="textAlignLeft" id="manage-submittal-record--submittals--submittal_priority--$submittal_id" nowrap>$submittal_priority<input type="hidden" id="manage-submittal-record--submittals--submittal_priority_id--$submittal_id" value="$submittal_priority_id"></td>
            <td class="textAlignCenter" id="manage-submittal-record--submittals--daysOpen--$submittal_id" nowrap>$daysOpen</td>
        </tr>

END_SUBMITTAL_TABLE_TBODY;
    }
$suTableTbody = mb_convert_encoding($suTableTbody, "HTML-ENTITIES", "UTF-8");

    $htmlContent = <<<END_HTML_CONTENT

<table id="record_list_container--manage-submittal-record" class="detailed_week content fontSize12" border="0" cellpadding="5" cellspacing="0" width="100%">
    <thead class="borderBottom ">
    <tr class="table-headerinner fontSize14" style="text-decoration:none;"><td colspan="7" class='align-left textUpper paragraphBoldCal'>Open Submittal Log</td></tr>
        <tr >
        <td class="textAlignCenter paragraphBoldCal textUpper" nowrap>Number</td>
        <td class="textAlignLeft paragraphBoldCal textUpper" nowrap>Name</td>
        <td class="textAlignLeft paragraphBoldCal textUpper" nowrap>Recipient</td>
        <td class="textAlignLeft paragraphBoldCal textUpper" nowrap>Submitted</td>
        <td class="textAlignLeft paragraphBoldCal textUpper" nowrap>Target</td>
        <td class="textAlignLeft paragraphBoldCal textUpper" nowrap>Priority</td>
        <td class="textAlignCenter paragraphBoldCal textUpper" nowrap>Days Open</td>
        </tr>
    </thead>
    <tbody class="altColors">
        $suTableTbody
    </tbody>
</table>

END_HTML_CONTENT;
if($GetCount == '0')
{
    return '';
}else{
    return $htmlContent;
}
}
function buildDiscussionItemCommentsTableByDiscussionItemIdPdfReport($arrDiscussionItemCommentsByDiscussionItemIds, $discussion_item_id, Input $input)
{

    $database = $input->database;
    $arrContactOptions = $input->arrContactOptions;
    $isPrintView = $input->isPrintView;

    $discussionItemCommentsTable = <<<END_DISCUSSION_ITEM_COMMENTS_TABLE
END_DISCUSSION_ITEM_COMMENTS_TABLE;

    if (isset($arrDiscussionItemCommentsByDiscussionItemIds[$discussion_item_id])) {
        $arrDiscussionItemCommentsByDiscussionItemId = $arrDiscussionItemCommentsByDiscussionItemIds[$discussion_item_id];
        $arrDiscussionItemCommentsByDiscussionItemIdCount = count($arrDiscussionItemCommentsByDiscussionItemId);

        /*$discussionItemCommentsTable = <<<END_DISCUSSION_ITEM_COMMENTS_TABLE
            <table class="comment-table" width="100%" cellspacing="10px">
END_DISCUSSION_ITEM_COMMENTS_TABLE;*/
        $i=1;
        foreach ($arrDiscussionItemCommentsByDiscussionItemId AS $discussion_item_comment_id => $discussionItemComment) {
            /* @var $discussionItemComment DiscussionItemComment */
            if($arrDiscussionItemCommentsByDiscussionItemIdCount == $i){
                $class = "BotBordNot";
            }else{
                $class = "BotBord";
            }
            $discussionItem = $discussionItemComment->getDiscussionItem();
            /* @var $discussionItem DiscussionItem */

            $createdByContact = $discussionItemComment->getCreatedByContact();
            /* @var $createdByContact Contact */

            $commentCreatorContactFullNameHtmlEscaped = $createdByContact->getContactFullNameHtmlEscaped();

            $created = $discussionItemComment->created;
            if (!isset($created) || $created == '0000-00-00 00:00:00') {
                $commentCreated = '';
            } else {
                $createdUnixTimestamp = strtotime($created);
                $commentCreated = date('m/d/Y  g:i a', $createdUnixTimestamp);
            }

            $is_visible_flag = $discussionItemComment->is_visible_flag;

            $checkboxChecked = '';
            if ($is_visible_flag == 'Y') {
                $checkboxChecked = ' checked';
            }

            $discussionItemComment->htmlEntityEscapeProperties();

            $escaped_discussion_item_comment = $discussionItemComment->escaped_discussion_item_comment;
            $escaped_discussion_item_comment_nl2br = $discussionItemComment->escaped_discussion_item_comment_nl2br;
         
                $discussion_item_comment_arr = preg_split('/<br[^>]*>/i', $escaped_discussion_item_comment_nl2br);
                $discussion_item_comment_arr = array_map('ltrim', $discussion_item_comment_arr);
                $escaped_discussion_item_comment_sect = "";
                foreach ($discussion_item_comment_arr as $key => $value) {
                    $date = '';
                    if($key==0){
                        $date = $commentCreatorContactFullNameHtmlEscaped."<br>".$commentCreated;
                    }
                    if(!empty($value))
                    {
                       
                   $escaped_discussion_item_comment_sect .= "<tr>
 <td class='paragraphBoldCal cellBorder borderDownNot' style='border-bottom:none !important;border-top:none !important;'></td>
 <td class='comment-table-commentor' style='border-bottom:none !important;border-top:none !important;width:140px'>".$date."</td>
                   <td style='border-left:none;border-bottom:none !important;border-top:none !important;' class='celborderleftright' colspan='3'>".$value."</td>
                    <td class='paragraphBoldCal cellBorder borderDownNot' style='border-bottom:none !important;border-top:none !important;'></td>
                    </tr>";
                   
                }
            }
          

            if (isset($isPrintView) && $isPrintView) {
                if ($is_visible_flag == 'Y') {

                    $discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE
$escaped_discussion_item_comment_sect    
END_DISCUSSION_ITEM_COMMENTS_TABLE;

                }
            } else {
               $discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE
               <tr class="fontSize12">
               <td class="paragraphBoldCal cellBorder borderDownNot CellBorderTop" style="border-bottom:none !important;"></td>
               <td style="border-left:none;border-bottom:none !important;border-top:none !important;" class="celborderleftright" colspan="4">
                    <span class="paragraphBoldCal">$commentCreatorContactFullNameHtmlEscaped</span>&nbsp; $commentCreated<br>$escaped_discussion_item_comment_nl2br
                    </td><td class="paragraphBoldCal cellBorder borderDownNot" style="border-bottom:none !important;border-top:none !important;"></td>
                </tr>
END_DISCUSSION_ITEM_COMMENTS_TABLE;

            }
            $i++;
        }

       /* $discussionItemCommentsTable .= <<<END_DISCUSSION_ITEM_COMMENTS_TABLE
</table>
END_DISCUSSION_ITEM_COMMENTS_TABLE;*/

    }

    return $discussionItemCommentsTable;
}

<?php
require_once('lib/common/ContactCompany.php');
require_once('lib/common/Contact.php');
require_once('lib/common/SoftwareModule.php');
require_once('lib/common/Role.php');
require_once('lib/common/SoftwareModuleFunction.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/MeetingType.php');
require_once('lib/common/Meeting.php');
require_once('lib/common/ChangeOrderType.php');
require_once('lib/common/SubcontractorBidStatus.php');
require_once('lib/common/Input.php');
require_once('lib/common/MeetingLocation.php');
require_once('lib/common/Contact.php');
require_once('lib/common/SubmittalStatus.php');
require_once('lib/common/RequestForInformationStatus.php');

$RN_permissions = RN_Permissions::loadPermissions($database, $user, $RN_project_id);
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['ReportsList'] = array();
$RN_jsonEC['data']['ProjectData'] = null;
try {
    $RN_arrReports = array();
    $db = DBI::getInstance($database);
    $fetchvalue=array();
    /** to get report list */
    $query = "SELECT * FROM reports_list ORDER BY report_list ASC";
    $db->execute($query);
    $key=0;
    while ($row = $db->fetch()) {
        $RN_arrReports[] = $row;
    }
    $RN_arrReportsArr = array();
    foreach ($RN_arrReports as $report => $row) {
        $userCanSeeReport=true;
        if(isset($row['software_function']) && !empty($row['software_function'])){
            /** to get software modules */ 
            $softQuery="SELECT * FROM `software_module_functions` where `software_module_function`='".$row['software_function']."'";
            $db->execute($softQuery);
            $fetchvalue=$db->fetch();
            $userCanSeeReport = RN_Permissions::checkDelayPermission($database, $fetchvalue['software_module_function'], $user, $fetchvalue['id'], $fetchvalue['software_module_id'], $RN_project_id);
        }
        $reports_list = $row['report_list'];
        $reports_value = $row['report_value'];
      
        switch($reports_value) {
            case 'Daily Construction Report (DCR)':
            case 'Project Delay Log':
            case 'ContractLog':
            case 'Detailed Weekly':
            case 'Weekly Manpower':
            case 'Monthly Manpower':
            case 'Weekly Job':
            case 'Job Status':
            case 'Buyout':
            case 'Submittal Log - by ID':
            case 'Submittal Log - by Notes':
            case 'Submittal Log - by status':
            case 'Submittal log - by Cost Code':
            case 'RFI Report - by ID':
            case 'RFI Report - QA - Open':
            case 'RFI Report - QA':
                if($RN_version && $RN_version == '1.0') {
                    $row['calendar_flag'] = 'Y';
                } else {
                    $row['calendar_flag'] = 'N';
                }
                break;
            case 'Change Order':
                if($RN_version && $RN_version == '1.0') {
                    $row['calendar_flag'] = 'N';
                } else {
                    $row['calendar_flag'] = 'Y';
                }
                break;
            default:
                $row['calendar_flag'] = 'N';
            break;
        }
        /* Filter Types & data's */       
        switch($reports_value) {
            case 'SCO':
            case 'Meetings - Tasks':
            case 'Bidder List':
            case 'Change Order':
                $row['filter_flag'] = 'Y';
                break;
            case 'Submittal Log - by ID':
            case 'Submittal Log - by Notes':
            case 'Submittal Log - by status':
            case 'Submittal log - by Cost Code':
            case 'RFI Report - by ID':
            case 'RFI Report - QA':                
                if($RN_version && $RN_version == '1.0') {
                    $row['filter_flag'] = 'Y';
                } else {
                    $row['filter_flag'] = 'N';
                }
                break;
            case 'RFI Report - QA - Open':
                $row['filter_flag'] = 'N';
                break;
            default:
                $row['filter_flag'] = 'N';
            break;
        }
        $row['filter_data'] = array();
        //  Bidder List Filter
        if($reports_value == 'Bidder List') {
            $loadAllSubcontractorBidStatusesOptions = new Input();
            $loadAllSubcontractorBidStatusesOptions->forceLoadFlag = true;
            $arrSubcontractorBidStatuses = SubcontractorBidStatus::loadAllSubcontractorBidStatuses($database, $loadAllSubcontractorBidStatusesOptions);

            $mkey=0;
            $SubcontractorBidStatusesArray = array();
            foreach ($arrSubcontractorBidStatuses as $key => $value) {
              $SubcontractorBidStatusesArray[$mkey]['name'] = $value->subcontractor_bid_status;
              $SubcontractorBidStatusesArray[$mkey]['value'] = $value->subcontractor_bid_status_id;
              $SubcontractorBidStatusesArray[$mkey]['id'] = $value->subcontractor_bid_status_id;
              $mkey++;
            }
            $row['filter_data'][0]['label'] = 'Filter On Status';
            $row['filter_data'][0]['list'] = $SubcontractorBidStatusesArray;
            // sort by bid list
            $bidsortarray = array(
                array(
                    'value'=> 'cost_code_division_id,company,cost_code',
                    'label'=>'Company, Cost Code'
                ),
                array(
                    'value'=> 'cost_code_division_id,cost_code,company',
                    'label'=>'Cost Code, Company'
                ),
                array(
                    'value'=> 'cost_code_division_id,cost_code,bid_total',
                    'label'=>'Cost Code, Bid Amount'
                ),
                array(
                    'value'=> 'cost_code_division_id,cost_code,email',
                    'label'=>'Email'
                ));
            $row['filter_data'][1]['label'] = 'Sort By';
            $row['filter_data'][1]['list'] = $bidsortarray;
        }
        //  Meeting Types Filter
        if($reports_value == 'Meetings - Tasks') {
            $loadAllMeetingTypesOptions = new Input();
            $loadAllMeetingTypesOptions->forceLoadFlag = true;
            $arrMeetingTypes= array();
            $meetingArray = array();
            $arrMeetingTypes = MeetingType::loadMeetingTypesByProjectId($database, $RN_project_id, $loadAllMeetingTypesOptions);
            $mkey=0;
            $RN_tmpDropDown = array();
            foreach ($arrMeetingTypes as $key => $value) {
              $meetingArray[$mkey]['label'] = $value->meeting_type;
              $meetingArray[$mkey]['value'] = $value->meeting_type_id;
              $meetingArray[$mkey]['label_abbr'] = $value->meeting_type_abbreviation;
              $mkey++;
              // meetings
              $RN_meeting_type_id = $value->meeting_type_id;
              $RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions = new Input();
              $RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions->forceLoadFlag = true;
              $RN_arrMeetingsByProjectIdAndMeetingTypeId = Meeting::loadMeetingsByProjectIdAndMeetingTypeId($database, $RN_project_id, $RN_meeting_type_id, $RN_loadMeetingsByProjectIdAndMeetingTypeIdOptions);
              $RN_default_meeting_id = null;
              $mkeyIn=0;
              foreach ($RN_arrMeetingsByProjectIdAndMeetingTypeId as $RN_mId => $RN_meeting) {
                /* @var $meeting Meeting */
                $RN_meeting_sequence_number = $RN_meeting->meeting_sequence_number;
                $options = 'Meeting '.$RN_meeting_sequence_number;
                $RN_tmpDropDown[$RN_meeting_type_id][$mkeyIn]['type'] = $options;
                $RN_tmpDropDown[$RN_meeting_type_id][$mkeyIn]['id'] = $RN_mId;
                $mkeyIn++;
                }
            }
            $row['filter_data'][0]['label'] = 'Meeting Type';
            $row['filter_data'][0]['list'] = $meetingArray;

            $row['filter_data'][1]['label'] = 'Meetings';
            $row['filter_data'][1]['list'] = $RN_tmpDropDown;
        }
        //  Change Order Filter
        if($reports_value == 'Change Order') {
            $loadAllChangeOrderTypesOptions = new Input();
            $loadAllChangeOrderTypesOptions->forceLoadFlag = true;
            $arrChangeOrderTypes = ChangeOrderType::loadAllChangeOrderTypes($database, $loadAllChangeOrderTypesOptions);
            $mkey=0;
            $ChangeOrderArray = array();
            foreach ($arrChangeOrderTypes as $key => $value) {
              $ChangeOrderArray[$mkey]['id']=$value->change_order_type_id;
              $ChangeOrderArray[$mkey]['name']=$value->change_order_type;
              $mkey++;
            }
            $row['filter_data'][0]['label'] = 'Filter On type';
            $row['filter_data'][0]['list'] = $ChangeOrderArray;
        }
        //  SCO Filter
        if($reports_value == 'SCO') {
            $scoView = array();
            $scoView[0]['value'] = "costcode";
            $scoView[0]['label'] = "costcode view";
            $scoView[1]['value'] = "subcontractor";
            $scoView[1]['label'] = "subcontractor view";
            $row['filter_data'][0]['label'] = 'SCO View';
            $row['filter_data'][0]['list'] = $scoView;
            $scoViewFilter = array();
            $scoViewFilter[0]['value'] = "all";
            $scoViewFilter[0]['label'] = "All";
            $scoViewFilter[1]['value'] = "potential";
            $scoViewFilter[1]['label'] = "Potential";
            $scoViewFilter[2]['value'] = "approved";
            $scoViewFilter[2]['label'] = "Approved";
            $row['filter_data'][1]['label'] = 'SCO Filter';
            $row['filter_data'][1]['list'] = $scoViewFilter;
        }
        //  Submittals Filter
        if(strpos($reports_value, 'Submittal log') === 0 || strpos($reports_value, 'Submittal Log') === 0) {
            $suView = array();
            $reviewedId = 2;
            $submittalStatus = SubmittalStatus::findById($database, $reviewedId);
            $reviewed = 'Reviewed';
            if (isset($submittalStatus) && $submittalStatus->submittal_status) {
                $reviewed = $submittalStatus->submittal_status;
            }
            $reviewedWNotesId = 3;
            $submittalStatus = SubmittalStatus::findById($database, $reviewedWNotesId);
            $reviewedWNotes = 'Reviewed';
            if (isset($submittalStatus) && $submittalStatus->submittal_status) {
                $reviewedWNotes = $submittalStatus->submittal_status;
            }
            $suView[0]['value'] = strVal($reviewedId);
            $suView[0]['label'] = $reviewed;
            $suView[1]['value'] = strVal($reviewedWNotesId);
            $suView[1]['label'] = $reviewedWNotes;
            $suView[2]['value'] = 'outstanding';
            $suView[2]['label'] = 'Outstanding';
            $row['filter_data'][0]['label'] = 'Filter On Status';
            $row['filter_data'][0]['list'] = $suView;
        }
        if(strpos($reports_value, 'RFI') === 0) {
            $loadAllRfiStatusesOptions = new Input();
            $loadAllRfiStatusesOptions->forceLoadFlag = true;
            $rfiStatus = RequestForInformationStatus::loadAllRequestForInformationStatuses($database, $loadAllRfiStatusesOptions);
            $arrRfiStatus = array();
            $arrRfiStatusCheck = array('Open', 'Closed');
          foreach($rfiStatus as $rfiStatusId => $status) {
            $request_for_information_status_id = $status->request_for_information_status_id;
            $request_for_information_status = $status->request_for_information_status;
            if (in_array($request_for_information_status, $arrRfiStatusCheck)) {
                $arrRfiStatus[$request_for_information_status_id]['label'] = $request_for_information_status;
                $arrRfiStatus[$request_for_information_status_id]['value'] = $request_for_information_status_id; 
            }
            // $arrRfiStatus[$rfiStatusId]['label'] = 
          }
          $row['filter_data'][0]['label'] = 'Filter On Status';
          $row['filter_data'][0]['list'] = array_values($arrRfiStatus);
        }

        if($userCanSeeReport && $reports_value != 'Contact List'){
            array_push($RN_arrReportsArr,$row);
        }
        
    }
    $db->free_result();
    /** to get project start date */
    $con_querys="SELECT * from projects where id = $RN_project_id";
    $db->execute($con_querys);
    $rowvalue=$db->fetch();
    $db->free_result();
    $createdDatepid='';
    if(isset($rowvalue)){
        if($rowvalue['project_start_date'] != '0000-00-00 00:00:00')
            $createdDatepid = date('m/d/Y',strtotime($rowvalue['project_start_date']));
        else
            $createdDatepid = '01/01/1970';

    }
   
   $meetings = array();
   $RN_jsonEC['data']['ProjectData']['startDate'] = $createdDatepid;
   $RN_jsonEC['data']['ReportsList'] = $RN_arrReportsArr;
}
catch(Exception $e){
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}

<?php
/*Manually increase the execution time for pdf generation*/
ini_set('max_execution_time', 300);
ini_set("memory_limit", "1000M");
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$timezone = date_default_timezone_get();
$dates = date('d-m-Y h', time());
$dateWithDay = date('l, M d, Y ');
$i=date('i', time());
$s=date('s a', time());
$a=date('a', time());
$timedate=date('d/m/Y h:i a', time());
$currentdate=date('m/d/Y', time());
require_once('lib/common/init.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once("dompdf/dompdf_config.inc.php");
require_once('lib/common/GcBudgetLineItem.php');
require_once('modules-gc-budget-functions.php');
require_once('lib/common/Subcontract.php');
require_once('lib/common/File.php');
require_once('lib/common/Logo.php');
require_once('lib/common/ContactCompany.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('lib/common/CostCodeDividerForUserCompany.php');
require_once('lib/common/PdfTools.php');
require_once('lib/common/JobsiteActivityLabel.php');
require_once('lib/common/JobsiteActivityListTemplate.php');
require_once('lib/common/JobsiteBuilding.php');
require_once('lib/common/JobsiteBuildingActivity.php');
require_once('lib/common/JobsiteBuildingActivityTemplate.php');
require_once('lib/common/JobsiteBuildingActivityTemplateToCostCode.php');
require_once('lib/common/JobsiteBuildingActivityToCostCode.php');
require_once('lib/common/JobsiteDailyBuildingActivityLog.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once('lib/common/JobsiteDailyOffsiteworkActivityLog.php');
require_once('lib/common/JobsiteDailySiteworkActivityLog.php');
require_once('lib/common/JobsiteDelay.php');
require_once('lib/common/JobsiteDelayCategory.php');
require_once('lib/common/JobsiteDelayNote.php');
require_once('lib/common/JobsiteDelaySubcategory.php');
require_once('lib/common/JobsiteFieldReport.php');
require_once('lib/common/JobsiteInspection.php');
require_once('lib/common/JobsiteInspectionNote.php');
require_once('lib/common/JobsiteInspectionType.php');
require_once('lib/common/JobsiteManPower.php');
require_once('lib/common/JobsiteNote.php');
require_once('lib/common/JobsiteNoteType.php');
require_once('lib/common/JobsiteOffsiteworkActivity.php');
require_once('lib/common/JobsiteOffsiteworkActivityTemplate.php');
require_once('lib/common/JobsiteOffsiteworkActivityTemplateToCostCode.php');
require_once('lib/common/JobsiteOffsiteworkActivityToCostCode.php');
require_once('lib/common/JobsiteOffsiteworkRegion.php');
require_once('lib/common/JobsitePhoto.php');
require_once('lib/common/JobsiteSignInSheet.php');
require_once('lib/common/JobsiteSiteworkActivity.php');
require_once('lib/common/JobsiteSiteworkActivityTemplate.php');
require_once('lib/common/JobsiteSiteworkActivityTemplateToCostCode.php');
require_once('lib/common/JobsiteSiteworkActivityToCostCode.php');
require_once('lib/common/JobsiteSiteworkRegion.php');

//Get the session projectid & company id
$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$user_company_id = $session->getUserCompanyId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$db = DBI::getInstance($database);
$db->free_result();

// $queryStringDateCreated = (string) $_POST['dateDCR'];
$jobsite_daily_log_created_date = date('Y-m-d');
$queryStringDateCreated = $dateDCR;

$queryStringDateCreated = date('Y-m-d', strtotime($queryStringDateCreated));
$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $queryStringDateCreated);
/* @var $jobsiteDailyLog JobsiteDailyLog */
if ($jobsiteDailyLog) {
    $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    $created_by_contact_id = $jobsiteDailyLog->created_by_contact_id;
    if (!isset($created_by_contact_id) || empty($created_by_contact_id)) {
        $data = array(
            'created_by_contact_id' => $currentlyActiveContactId
        );
        $jobsiteDailyLog->setData();
        $jobsiteDailyLog->save();
        $jobsiteDailyLog->created_by_contact_id = $currentlyActiveContactId;
        $jobsiteDailyLog->convertPropertiesToData();
    }
} else {
    if($currentlyActiveContactId && $project_id && $jobsite_daily_log_created_date){
        $created_by_contact_id = $currentlyActiveContactId;
        $jobsiteDailyLog = new JobsiteDailyLog($database);
        $jobsiteDailyLog->project_id = $project_id;
        $jobsiteDailyLog->jobsite_daily_log_created_date = $queryStringDateCreated;
        $jobsiteDailyLog->modified_by_contact_id = $currentlyActiveContactId;
        $jobsiteDailyLog->created_by_contact_id = $created_by_contact_id;
        $jobsiteDailyLog->convertPropertiesToData();
        $jobsite_daily_log_id = $jobsiteDailyLog->save();
    }
}

if ($jobsite_daily_log_id != '') {
    $jobsiteDailyLog = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $jobsite_daily_log_id);
}



    $uri = Zend_Registry::get('uri');
    /* @var $uri Uri */

    $jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
    $project_id = $jobsiteDailyLog->project_id;
    $jobsite_daily_log_created_date = $jobsiteDailyLog->jobsite_daily_log_created_date;

    $project = $jobsiteDailyLog->getProject();
    /* @var $project Project */

    $user_company_id = $project->user_company_id;

    // Project info.
    $project_name = $project->project_name;

    $project->htmlEntityEscapeProperties();
    $project_escaped_address_line_1 = $project->escaped_address_line_1;
    $project_escaped_address_city = ($project->escaped_address_city)?$project->escaped_address_city.', ':'';
    $project_escaped_address_state_or_region = $project->escaped_address_state_or_region;
    $project_escaped_address_postal_code = $project->escaped_address_postal_code;

    $max_photos_displayed = $project->max_photos_displayed;
    $numberofphotos = '2';
    // if(!empty($project->photos_displayed_per_page)){
    //  $numberofphotos = $project->photos_displayed_per_page;  
    // }
    

    //cost code divider
    $costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

    // Photo.
    $loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput = new Input();
    $loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput->forceLoadFlag = true;
    if(!empty($max_photos_displayed)){
        $loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput->limit = $max_photos_displayed;     
    }
    
    $jobsitePhotos = JobsitePhoto::loadMostRecentJobsitePhotoByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadMostRecentJobsitePhotoByJobsiteDailyLogIdInput);
    /* @var $jobsitePhoto JobsitePhoto */

    // Debug

    $count = count($jobsitePhotos);
    $jobsitePhotoHtmlContents='';
    $checkInx = $counter = 0;
    foreach($jobsitePhotos as $jobsite_photo_id => $jobsitePhoto){
    if ($jobsitePhoto) {

        $jobsitePhotoFileManagerFile = $jobsitePhoto->getJobsitePhotoFileManagerFile();
        /* @var $jobsitePhotoFileManagerFile FileManagerFile */

        $jobsitePhotoCreated = $jobsitePhotoFileManagerFile->created;
        $jobsitePhotoCreatedUnixTimestamp = strtotime($jobsitePhotoCreated);
        $jobsitePhotoCreatedHtml = 'Photo uploaded ' . date('M d, Y g:ia', $jobsitePhotoCreatedUnixTimestamp);
        /*custome url change for imagick*/
        $jobsitePhotoUrl = $jobsitePhotoFileManagerFile->generateUrl();
    
        $virtual_file_mime_type = $jobsitePhotoFileManagerFile->virtual_file_mime_type;
        if ($virtual_file_mime_type == 'application/pdf') {
            $jobsitePhotoHtml = '<embed src='.$jobsitePhotoUrl.' width="100%" height="100%">';
        } else {
            if($jobsitePhotoUrl !=''){
                list($imageWidth, $imageHeight) = PdfTools::renderDomPDFSaveImageSize($jobsitePhotoUrl);
            }
            $file_name = $jobsitePhotoFileManagerFile->file_location_id;
            $file_location_id = Data::parseInt($jobsitePhotoFileManagerFile->file_location_id);
            $arrPath = str_split($file_location_id, 2);
            $fileName = array_pop($arrPath);
            $shortFilePath = '';
            $path='';
            foreach ($arrPath as $pathChunk) {
                $path .= $pathChunk.'/';
                $shortFilePath .= $pathChunk.'/';
            }
            $config = Zend_Registry::get('config');
            $file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
            $basedircs = $config->system->file_manager_base_path;
            $basepathcs = $config->system->file_manager_backend_storage_path ;
            $filename=$basedircs.$basepathcs.$shortFilePath.$file_manager_file_name_prefix.$fileName;
            $pdfPhantomJS = new PdfPhantomJS();
            $target = $pdfPhantomJS->getTempFileBasePath();
            /*Resize image start*/
            $jobsitePhotoUrlsize = $filename;
            $path= realpath($jobsitePhotoUrlsize);
            $destination = $target.'_temp'.round(microtime(true)*1000);
             // Change the desired "WIDTH" and "HEIGHT"
            $newWidth = 800; // Desired WIDTH
            $newHeight = 800; // Desired HEIGHT
            $info   = getimagesize($path);
            $mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
            $width  = $info[0]; // width as integer for ex. 512
            $height = $info[1]; // height as integer for ex. 384
            $type   = $info[2];      // same as exif_imagetype
            if(intval($width) > 800 || intval($height) > 800){
                resize($path,$destination,$newWidth,$newHeight);
                $data = file_get_contents($destination);
                $base64 = 'data:image;base64,' . base64_encode($data);  
                $jobsitePhotoHtml = '<img alt="Jobsite Photo" style="max-height: 100mm; max-width: 100%;" src="'.$base64.'">';
                unlink($destination);
            }else{
                $file_manager_file_id = $jobsitePhotoFileManagerFile->file_manager_file_id;
                //To get base path
                $fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
                $cdnFileUrl = $fileManagerFile->generateUrlBasePath(true);
                $jobsitePhotoUrl = $jobsitePhotoFileManagerFile->generateUrlBasePath();
                //End to get base path

                $path= realpath($jobsitePhotoUrl);
                $data = file_get_contents($jobsitePhotoUrl);
                $base64 = 'data:image;base64,' . base64_encode($data);
                $jobsitePhotoHtml = '<img alt="Jobsite Photo" style="max-height: 100mm; max-width: 100%;" src="'.$base64.'">';

            }   
        }
        if($count > 0 && $checkInx == 0){
            $counthead="<h4 style='margin:5px 0;'>Attached Photos($count)</h4>";
        }else{
            $counthead='';
        }
        if(empty($numberofphotos) || $numberofphotos == '1'){
            $jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
        <div style="page-break-before: always;">
            $counthead
            <table class="dcrPreviewTable" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td style="padding: 0;" class="dcrPreviewImagecenter">
                    <section style="margin: 5px 0;" class="dcrPreviewTableHeader">$jobsitePhotoCreatedHtml</section>
                    $jobsitePhotoHtml</td>
                </tr>
            </table>
        </div>
END_HTML_CONTENT;
        }else if(!empty($numberofphotos) && $numberofphotos == '2'){
            
            if ($counter  == 0) {
                $jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
                
        <div style="page-break-before: always; display: block;">
            $counthead
            <table class="dcrPreviewTable" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-height: 256mm;">
END_HTML_CONTENT;
            }
            $jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
                <tr>
                    <td  class="dcrPreviewImagecenter" style="padding: 0;">
                    <section style="margin: 5px 0;" class="dcrPreviewTableHeader">$jobsitePhotoCreatedHtml</section> 
                    $jobsitePhotoHtml</td>
                </tr>
            
END_HTML_CONTENT;

            if ($counter == 1) {
                $jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
                </table>
        </div>
END_HTML_CONTENT;
             $counter = 0;
            }else if(($checkInx+1) ==  $count){
                $jobsitePhotoHtmlContents .= <<<END_HTML_CONTENT
                </table>
        </div>
END_HTML_CONTENT;
            }else{
                $counter++; 
            }

        }
        

    } else {
        $jobsitePhotoUrl = '';
        $jobsitePhotoHtmlContents = '';
    }
    $checkInx++;
    }
    if($jobsitePhotoHtmlContents!='')
    {
        
    $jobsitePhotoHtmlContent = <<<HtmlPhos
        $jobsitePhotoHtmlContents
HtmlPhos;
    }else{
        $jobsitePhotoHtmlContent='';
    }

    // Debug to test performance of Dompdf without image rendering portion
    

    $jdlCreatedUnixTimestamp = strtotime($jobsite_daily_log_created_date);
    $jdlCreatedDate = date('F j, Y', $jdlCreatedUnixTimestamp);
    $dayOfWeek = date('N', $jdlCreatedUnixTimestamp);  // This format returns 1 for Monday, 2 for Tuesday, etc.

    // Weather info.
    $amTemperature = '';
    $amCondition = '';
    $pmTemperature = '';
    $pmCondition = '';


    // Manpower - today.
    // $manpowerActivityToday = 0;
    $loadJobsiteManPowerByJobsiteDailyLogIdOptions = new Input();
    $loadJobsiteManPowerByJobsiteDailyLogIdOptions->forceLoadFlag = true;
    $arrReturn = JobsiteManPower::loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteManPowerByJobsiteDailyLogIdOptions);
    $arrJobsiteManPowerByJobsiteDailyLogId = $arrReturn['objects'];
    $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];

    foreach ($arrJobsiteManPowerByJobsiteDailyLogId as $tmpJobsiteManPower) {
        /* @var $tmpJobsiteManPower JobsiteManPower */
        $number_of_people = $tmpJobsiteManPower->number_of_people;
        // $manpowerActivityToday = $manpowerActivityToday + $number_of_people;
    }

    $manpowerActivitySummaryByTrade = '';
    $loadSubcontractsByProjectIdInput = new Input();
    $loadSubcontractsByProjectIdInput->forceLoadFlag = true;
    $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id, $loadSubcontractsByProjectIdInput, 1);
    $inTr = 0;
    $loopInTr = 0;
    $manpowerActivityToday = 0;
    $manPowerActArray = array();
    $countRfi = RequestForInformation::countOpenRfi($database, $project_id);
    foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
        /* @var $subcontract Subcontract */

        $gcBudgetLineItem = $subcontract->getGcBudgetLineItem();
        /* @var $gcBudgetLineItem GcBudgetLineItem */

        $costCode = $gcBudgetLineItem->getCostCode();
        /* @var $costCode CostCode */

        $costCodeDivision = $costCode->getCostCodeDivision();
        /* @var $costCodeDivision CostCodeDivision */

        $costCode->htmlEntityEscapeProperties();
        $costCodeDivision->htmlEntityEscapeProperties();
        $htmlEntityEscapedFormattedCostCode = $costCodeDivision->escaped_division_number . $costCodeDividerType . $costCode->escaped_cost_code;

        $vendor = $subcontract->getVendor();
        /* @var $vendor Vendor */


        $contactCompany = $vendor->getVendorContactCompany();
        /* @var $contactCompany ContactCompany */

        $contactCompany->htmlEntityEscapeProperties();
        $escaped_contact_company_name = $contactCompany->escaped_contact_company_name;
        
        $number_of_people = 0;
        if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {

            $tmpJobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];
            /* @var $tmpJobsiteManPower JobsiteManPower */

            $number_of_people = $tmpJobsiteManPower->number_of_people;
            $manpowerActivityToday += $number_of_people;
            if($inTr != 0){
                $trClose="</tr>";
                $trOpen="<tr><td></td>";
            }else{
                $trClose="</tr>";
                $trOpen='<td class="thHeadtd">TODAY&nbsp;</td>';
            }           

            $manPowerActArray[$loopInTr]['col1'] = $escaped_contact_company_name." ".$htmlEntityEscapedFormattedCostCode;
            $manPowerActArray[$loopInTr]['col2'] = $number_of_people;

            $inTr++;
            $manpowerActivitySummaryByTrade .= <<<END_MANPOWER_ACTIVITY_SUMMARY_BY_TRADE
            $trOpen<td class="alignTDMan btBtTr">$escaped_contact_company_name $htmlEntityEscapedFormattedCostCode: </td><td class="valignTd" align="right">
            <span class="tdManspan">$number_of_people</span>
            </td>
            $trClose
END_MANPOWER_ACTIVITY_SUMMARY_BY_TRADE;
        $loopInTr++;
        }
            
    }
    if($manpowerActivitySummaryByTrade == '' || $loopInTr== 0){
        if($inTr != 0){
                $trClose="</tr>";
                $trOpen="<tr><td></td>";
            }else{
                $trClose="</tr>";
                $trOpen='<td class="thHeadtd">TODAY&nbsp;</td>';
            }

            $manPowerActArray[$loopInTr]['col1'] = '';
            $manPowerActArray[$loopInTr]['col2'] = $number_of_people;

            $inTr++;
            $manpowerActivitySummaryByTrade = <<<END_MANPOWER_ACTIVITY_SUMMARY_BY_TRADE
            $trOpen<td class="alignTDMan"></td><td class="valignTd" align="right">
            <span class="tdManspan">$number_of_people</span>
            </td>
            $trClose
END_MANPOWER_ACTIVITY_SUMMARY_BY_TRADE;
    }

    $todayManPowArr = array("col1"=>"TOTAL","col2"=>"");
    array_push($manPowerActArray,$todayManPowArr);

    $totalManPowArr = array("col1"=>"TODAY","col2"=>$manpowerActivityToday);
    array_push($manPowerActArray,$totalManPowArr);

    // Manpower - this week.
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
            $arrJobsiteManPowerBySubcontractId = $arrReturn['jobsite_man_power_by_subcontract_id'];

            $arrSubcontractsByProjectId = Subcontract::loadSubcontractsByProjectId($database, $project_id, $loadSubcontractsByProjectIdInput, 1);

            foreach ($arrSubcontractsByProjectId as $subcontract_id => $subcontract) {
                $number_of_people = 0;
                if (isset($arrJobsiteManPowerBySubcontractId[$subcontract_id])) {
                    $tmpJobsiteManPower = $arrJobsiteManPowerBySubcontractId[$subcontract_id];  
                    $number_of_people = $tmpJobsiteManPower->number_of_people;
                    $manpowerActivityThisWeek += $number_of_people;
                }
            }
        }

        // 60 * 60 * 24 = 86400 (1 day in seconds)
        $interval = $interval + 86400;
        $tmpDayOfWeek--;
    }

    $totWeekManPowArr = array("col1"=>"CURRENT WEEK","col2"=>$manpowerActivityThisWeek);
    array_push($manPowerActArray,$totWeekManPowArr);

    // Inspections - today.
    $loadJobsiteInspectionsByJobsiteDailyLogIdOptions = new Input();
    $loadJobsiteInspectionsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
    $arrJobsiteInspectionsByJobsiteDailyLogId = JobsiteInspection::loadJobsiteInspectionsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteInspectionsByJobsiteDailyLogIdOptions);
    $numInspectionsToday = count($arrJobsiteInspectionsByJobsiteDailyLogId);
    $inspectiondataArray = array();
    $inspectionCt = 0;
    $inspectiondata="<tr>
    <td class='thHeadtdNr'>INSPECTION TYPE</td>
    <td class='thHeadtdNr'>INSPECTION NOTES</td>
    <td class='thHeadtdNr textAlignCenter'>PASSED </td>
    </tr>";
    foreach ($arrJobsiteInspectionsByJobsiteDailyLogId as $key => $Inspections) {

        $inspectiondataArray[$inspectionCt]['col1'] = $Inspections['jobsite_inspection_type'];
        $inspectiondataArray[$inspectionCt]['col2'] = $Inspections['jobsite_inspection_note'];
        if ($Inspections['jobsite_inspection_passed_flag'] == 'Y') {
            $jobsite_inspection_passed_flag = "Yes";
        }else{
            $jobsite_inspection_passed_flag = "No";
        }
        $inspectiondataArray[$inspectionCt]['col3'] = $jobsite_inspection_passed_flag;

        $inspectiondata .="<tr class=''><td>".$Inspections['jobsite_inspection_type']."</td>
        <td>".$Inspections['jobsite_inspection_note']."</td><td class='textAlignCenter' >".$Inspections['jobsite_inspection_passed_flag']."</td></tr>";
        $inspectionCt++;
    }
    if($numInspectionsToday=='0')
    {
        $inspectiondata .="<tr><td colspan='3' class='textAlignCenter'>No Inspections Recorded</td></tr>" ;
        $inspectionEmptyArr = array("col1"=>"","col2"=>"","col3"=>"");
        array_push($inspectiondataArray,$inspectionEmptyArr);
    }
    
    // Inspections - this week.
    $numInspectionsThisWeek = 0;
    $format = 'Y-m-d';
    $interval = 0;
    $loadJobsiteInspectionsByJobsiteDailyLogIdOptions = new Input();
    $loadJobsiteInspectionsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
    $tmpDayOfWeek = $dayOfWeek;
    while ($tmpDayOfWeek > 0) {
        $tmp_jobsite_daily_log_created_date = date($format, $jdlCreatedUnixTimestamp - $interval);

        $tmpJobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $tmp_jobsite_daily_log_created_date);
        /* @var $tmpJobsiteDailyLog JobsiteDailyLog */

        if ($tmpJobsiteDailyLog) {
            $temp_jobsite_daily_log_id = $tmpJobsiteDailyLog->jobsite_daily_log_id;
            $arrJobsiteInspectionsByJobsiteDailyLogId = JobsiteInspection::loadJobsiteInspectionsByJobsiteDailyLogId($database, $temp_jobsite_daily_log_id, $loadJobsiteInspectionsByJobsiteDailyLogIdOptions);
            $numInspectionsThisWeek = $numInspectionsThisWeek + count($arrJobsiteInspectionsByJobsiteDailyLogId);
        }
        // 60 * 60 * 24 = 86400 (1 day in seconds)
        $interval = $interval + 86400;
        $tmpDayOfWeek--;
    }

    $countManPowerArray = count($manPowerActArray);
    $extraManPower = $countManPowerArray-$countRfi;
    if ($extraManPower < 0) {
        for ($x = 0; $x <= abs($extraManPower); $x++) {
            $emptyWeekManPowArr = array("col1"=>"","col2"=>"");
            array_push($manPowerActArray,$emptyWeekManPowArr);
        }
    }
    if ($extraManPower == 0) {
        $emptyWeekManPowArr = array("col1"=>"","col2"=>"");
        array_push($manPowerActArray,$emptyWeekManPowArr);
    }

    // RFIs.
    $loadRequestsForInformationByProjectIdOptions = new Input();
    $loadRequestsForInformationByProjectIdOptions->forceLoadFlag = true;
    $arrRequestsForInformation = RequestForInformation::loadRequestsForInformationByProjectId($database, $project_id, $loadRequestsForInformationByProjectIdOptions);
    $tableRequestsForInformationTbody = ''; 
    $inRfi = 0;
    $rfiArray = array();
    foreach ($arrRequestsForInformation as $request_for_information_id => $requestForInformation) {
        /* @var $requestForInformation RequestForInformation */

        $requestForInformation->htmlEntityEscapeProperties();

        $requestForInformationStatus = $requestForInformation->getRequestForInformationStatus();
        $request_for_information_status = $requestForInformationStatus->request_for_information_status;
        if ($request_for_information_status == 'Open') {
            $rfi_sequence_number = $requestForInformation->rfi_sequence_number;
            $escaped_rfi_title = $requestForInformation->escaped_rfi_title;
            $rfi_created_timestamp = $requestForInformation->created;

            $rfiCreatedUnixTimestamp = strtotime($rfi_created_timestamp);
            $nowUnixTimestamp = strtotime(date('Y-m-d', $jdlCreatedUnixTimestamp));

            $difference = $nowUnixTimestamp - $rfiCreatedUnixTimestamp;
            $daysOpen = ceil($difference / 86400);

            $rfiArray[$inRfi]['col3'] = $rfi_sequence_number;
            $rfiArray[$inRfi]['col4'] = $escaped_rfi_title;
            $rfiArray[$inRfi]['col5'] = $daysOpen;

            $inRfi++;
            $tableRequestsForInformationTbody .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY

            <tr>
                <td>$rfi_sequence_number</td>
                <td>$escaped_rfi_title</td>
                <td align="center">$daysOpen</td>
            </tr>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;

        }

    }

    $countRfiArray = count($manPowerActArray)-count($rfiArray);
    if ($countRfiArray > 0) {
        for ($x = 0; $x <= abs($extraManPower); $x++) {
            $emptyRfiArr = array("col3"=>"","col4"=>"","col5"=>"");
            array_push($rfiArray,$emptyRfiArr);
        }
    }


    if ($countRfi == 0) {
        $tableRequestsForInformationTbody = '<tr><td colspan="3" class="textAlignCenter">No Data Found.</td></tr>';

        for ($x = 0; $x <= ($countManPowerArray-1); $x++) {
            $emptyRfiArr = array("col3"=>"","col4"=>"","col5"=>"");
            array_push($rfiArray,$emptyRfiArr);
        }
    }

    $combineManPowerRfiArr = array();
    foreach($manPowerActArray as $key=>$val){ 
        $val2 = $rfiArray[$key]; 
        $combineManPowerRfiArr[$key] = $val + $val2;
    }
    
    $tableCombineManPowerRfi = '';  
    foreach ($combineManPowerRfiArr as $key => $value) {
        $col1 = $combineManPowerRfiArr[$key]['col1'];
        if ($col1 == '' || $col1 == 'TOTAL' || $col1 == 'CURRENT WEEK' || $col1 == 'TODAY') {
            $col1Class = '';
        }else{
            $col1Class = 'btBtTr';
        }
        $col2 = $combineManPowerRfiArr[$key]['col2'];       
        if ($col1 == 'TOTAL' && $col2 == '') {
            $col1Class = 'thHeadtdNr';
        }
        $col3 = $combineManPowerRfiArr[$key]['col3'];
        $col4 = $combineManPowerRfiArr[$key]['col4'];
        $col5 = $combineManPowerRfiArr[$key]['col5'];
        $col4Class = '';
        if ($col4 == '' && $key == 0) {
            $col4 = "No Data Found.";
            $col4Class = 'alignCenter';
        }
        $tableCombineManPowerRfi .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
            <tr>
                <td width="42%" class="paddingLeft textTop"><p style="font-size:12px;" class="$col1Class">$col1</p></td>
                <td width="8%" class="alignCenter textTop">$col2</td>
                <td width="8%" class="leftBorder paddingLeft textTop">$col3</td>
                <td width="32%" class="$col4Class textTop">$col4</td>
                <td width="10%" class="alignCenter textTop">$col5</td>
            </tr>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
    }

    // Notes.
    $loadJobsiteNotesByJobsiteDailyLogIdOptions = new Input();
    $loadJobsiteNotesByJobsiteDailyLogIdOptions->forceLoadFlag = true;
    $arrJobsiteNotesByJobsiteDailyLogId = JobsiteNote::loadJobsiteNotesByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteNotesByJobsiteDailyLogIdOptions);
    $tableJobsiteNotesTbody = '';
    foreach ($arrJobsiteNotesByJobsiteDailyLogId as $jobsite_note_id => $jobsiteNote) {
        /* @var $jobsiteNote JobsiteNote */

        $jobsite_note_type_id = $jobsiteNote->jobsite_note_type_id;

        $jobsiteNote->htmlEntityEscapeProperties();
        $escaped_jobsite_note_nl2br = $jobsiteNote->escaped_jobsite_note_nl2br;

        $jobsiteNoteType = JobsiteNoteType::findById($database, $jobsite_note_type_id);
        /* @var $jobsiteNoteType JobsiteNoteType */

        $jobsiteNoteType->htmlEntityEscapeProperties();
        $escaped_jobsite_note_type_label = $jobsiteNoteType->escaped_jobsite_note_type_label;

        $tableJobsiteNotesTbody .= <<<END_TABLE_JOBSITE_NOTES_TBODY

        <tr>
            <td style="vertical-align:top">$escaped_jobsite_note_type_label: </td>
            <td style="vertical-align:top">$escaped_jobsite_note_nl2br</td>
        </tr>
END_TABLE_JOBSITE_NOTES_TBODY;

        $tableJobsiteNotesTbodyNew .= <<<END_TABLE_JOBSITE_NOTES_TBODY
        <tr><td class="thHeadtdNr paddingLeft">$escaped_jobsite_note_type_label</td></tr>
        <tr><td class="paddingLeft textJustify">$escaped_jobsite_note_nl2br</td></tr>
        <tr><td></td></tr>
END_TABLE_JOBSITE_NOTES_TBODY;

    }

    if (count($arrJobsiteNotesByJobsiteDailyLogId) == 0) {

        $tableJobsiteNotesTbody = <<<END_TABLE_JOBSITE_NOTES_TBODY

        <tr>
            <td colspan="2" class="" align="left">No Data Found</td>
        </tr>
END_TABLE_JOBSITE_NOTES_TBODY;

        $tableJobsiteNotesTbodyNew = <<<END_TABLE_JOBSITE_NOTES_TBODY
        <tr><td class="paddingLeft" align="left">No Jobsite Recorded.</td></tr>
END_TABLE_JOBSITE_NOTES_TBODY;

    }



    // SCHEDULE DELAYS.
    // jobsite_delays
    $loadJobsiteDelaysByJobsiteDailyLogIdOptions = new Input();
    $loadJobsiteDelaysByJobsiteDailyLogIdOptions->forceLoadFlag = true;
    $arrJobsiteDelays = JobsiteDelay::loadJobsiteDelaysByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDelaysByJobsiteDailyLogIdOptions);

    $delayCount = count($arrJobsiteDelays);
    $inspectionCount = count($inspectiondataArray);
    $extraDelay = $delayCount - $inspectionCount;
    if ($extraDelay > 0) {
        for ($x = 0; $x < $extraDelay; $x++) {
            $emptyInspecArr = array("col1"=>"","col2"=>"","col3"=>"");
            array_push($inspectiondataArray,$emptyInspecArr);
        }
    }



    $tableJobsiteScheduleDelaysTbody = '';
    $delayCnt = 0;
    $delayArray = array();
    foreach ($arrJobsiteDelays as $jobsiteDelay) {
        /* @var $jobsiteDelay JobsiteDelay */


        $jobsiteDelayCategory = $jobsiteDelay->getJobsiteDelayCategory();
        /* @var $jobsiteDelayCategory JobsiteDelayCategory */

        if ($jobsiteDelayCategory) {
            $jobsiteDelayCategory->htmlEntityEscapeProperties();
            $escaped_jobsite_delay_category = $jobsiteDelayCategory->escaped_jobsite_delay_category;
        }

        $jobsiteDelaySubcategory = $jobsiteDelay->getJobsiteDelaySubcategory();
        /* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */

        if ($jobsiteDelaySubcategory) {
            $jobsiteDelaySubcategory->htmlEntityEscapeProperties();
            $escaped_jobsite_delay_subcategory = $jobsiteDelaySubcategory->escaped_jobsite_delay_subcategory;
        }

        $jobsiteDelayNote = $jobsiteDelay->getJobsiteDelayNote();
        /* @var $jobsiteDelayNote JobsiteDelayNote */

        if ($jobsiteDelayNote && ($jobsiteDelayNote instanceof JobsiteDelayNote)) {
            $jobsiteDelayNote->htmlEntityEscapeProperties();

            $escaped_jobsite_delay_note_nl2br = $jobsiteDelayNote->escaped_jobsite_delay_note_nl2br;
        } else {
            $escaped_jobsite_delay_note_nl2br = '';
        }

        $delayArray[$delayCnt]['col4'] = $escaped_jobsite_delay_category;
        $delayArray[$delayCnt]['col5'] = $escaped_jobsite_delay_subcategory;
        $delayArray[$delayCnt]['col6'] = $escaped_jobsite_delay_note_nl2br;

        $tableJobsiteScheduleDelaysTbody .= <<<END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY

        <tr>
            <td style="vertical-align:top">$escaped_jobsite_delay_category &mdash; $escaped_jobsite_delay_subcategory: </td>
            <td style="vertical-align:top">$escaped_jobsite_delay_note_nl2br</td>
        </tr>
END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY;
    $delayCnt++;
    }

    if (count($arrJobsiteDelays) == 0) {

        $delayEmptArr = array("col4"=>"","col5"=>"","col6"=>"");
        array_push($delayArray,$delayEmptArr);

        $tableJobsiteScheduleDelaysTbody = <<<END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY
        <table class="dcrPreviewTable" border="0" cellpadding="4" cellspacing="0" width="100%">
        <tr>
        <td colspan="2" class="dcrPreviewTableHeader">SCHEDULE DELAYS</td>
        </tr>
        <tr>
            <td class="thHeadtdNr" width="25%">DELAY TYPE</td>
            <td class="thHeadtdNr">DELAY</td>
        </tr>
        <tr>
            <td colspan="2" class="" align="left">No Data Found.</td>
        </tr>
        </table>
        
END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY;

    }else{
        $tableJobsiteScheduleDelaysTbody = <<<END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY
        <table class="dcrPreviewTable" border="0" cellpadding="4" cellspacing="0" width="100%">
        <tr>
        <td colspan="2" class="dcrPreviewTableHeader">SCHEDULE DELAYS</td>
        </tr>
        <tr>
            <td class="thHeadtdNr" width="50%">DELAY TYPE</td>
            <td class="thHeadtdNr">DELAY</td>
        </tr>
            $tableJobsiteScheduleDelaysTbody
        </table>        
END_TABLE_JOBSITE_SCHEDULE_DELAYS_TBODY;
    }

    $totalDelayArrCnt = count($delayArray);
    $extraDelayCnt = $totalDelayArrCnt - $inspectionCount;
    if ($extraDelayCnt < 0) {
        for ($x = 0; $x < abs($extraDelayCnt); $x++) {
            $emptyDelayArr = array("col4"=>"","col5"=>"","col6"=>"");
            array_push($delayArray,$emptyDelayArr);
        }
    }
    

    $combineInspectionDelayArr = array();
    foreach($inspectiondataArray as $key=>$val){ 
        $val2 = $delayArray[$key]; 
        $combineInspectionDelayArr[$key] = $val + $val2;
    }

    // echo "<pre>";
    // print_r($inspectiondataArray);
    // print_r($delayArray);
    // print_r($combineInspectionDelayArr);
    // echo "</pre>";


    $tablecombineInspectionDelay = '';  
    foreach ($combineInspectionDelayArr as $key => $value) {
        $col1 = $combineInspectionDelayArr[$key]['col1'];
        $col2 = $combineInspectionDelayArr[$key]['col2'];
        $col3 = $combineInspectionDelayArr[$key]['col3'];
        if ($key == 0 && $col1 == '') {
            $tablecombineInspectionDelay .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
            <tr class="btBtTr">
                <td width="50%" class="alignCenter" colspan="3">No Inspections Recorded.</td>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
        }else{
            $tablecombineInspectionDelay .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
            <tr class="btBtTr">
                <td width="10%" class="textTop paddingLeft">$col1</td>
                <td width="32%" class="textTop textJustify">$col2</td>
                <td width="8%" class="textTop alignCenter">$col3</td>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
        }       
        $col4 = $combineInspectionDelayArr[$key]['col4'];
        $col5 = $combineInspectionDelayArr[$key]['col5'];
        $col6 = $combineInspectionDelayArr[$key]['col6'];
        if ($key == 0 && $col4 == '') {
            $tablecombineInspectionDelay .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
                <td width="50%" class="alignCenter leftBorder" colspan="3">No Schedule Delays Recorded.</td>
            </tr>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
        }else{
        $tablecombineInspectionDelay .= <<<END_TABLE_REQUESTS_FOR_INFORMATION_TBODY
                <td width="10%" class="textTop paddingLeft leftBorder">$col4</td>
                <td width="10%" class="textTop">$col5</td>
                <td width="30%" class="textTop textJustify">$col6</td>
            </tr>
END_TABLE_REQUESTS_FOR_INFORMATION_TBODY;
        }
    }



    // Sitework Activities.
    $loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions = new Input();
    $loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
    $arrReturn = JobsiteDailySiteworkActivityLog::loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogIdOptions);
    $arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = $arrReturn['objects'];
    $tableJobsiteSiteworkActivitiesTbody = '';
    $jobsiteSiteWorkData = '';
    foreach ($arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId as $jobsite_daily_sitework_activity_log_id => $jobsiteDailySiteworkActivityLog) {
        /* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */

        $jobsite_sitework_region_id = $jobsiteDailySiteworkActivityLog->jobsite_sitework_region_id;
        $jobsiteSiteworkRegion = JobsiteSiteworkRegion::findById($database, $jobsite_sitework_region_id);
        /* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */

        $jobsiteSiteworkRegion->htmlEntityEscapeProperties();

        $jobsite_sitework_activity_id = $jobsiteDailySiteworkActivityLog->jobsite_sitework_activity_id;
        $jobsiteSiteworkActivity = JobsiteSiteworkActivity::findById($database, $jobsite_sitework_activity_id);
        /* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */

        $jobsiteSiteworkActivity->htmlEntityEscapeProperties();

        $escaped_jobsite_sitework_activity_label = $jobsiteSiteworkActivity->jobsite_sitework_activity_label;

        $tableJobsiteSiteworkActivitiesTbody .= <<<END_TABLE_JOBSITE_SITEWORK_ACTIVITIES_TBODY

        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;$escaped_jobsite_sitework_activity_label</td>
        </tr>
END_TABLE_JOBSITE_SITEWORK_ACTIVITIES_TBODY;

        $jobsiteSiteWorkData .=  $escaped_jobsite_sitework_activity_label." | ";
    }

    $jobsiteSiteWorkData =  rtrim($jobsiteSiteWorkData, " | ");

    if (count($arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId) == 0) {

        $tableJobsiteSiteworkActivitiesTbody = <<<END_TABLE_JOBSITE_SITEWORK_ACTIVITIES_TBODY

        <tr>
            <td class="textAlignCenter">No Sitework Activities Recorded</td>
        </tr>
END_TABLE_JOBSITE_SITEWORK_ACTIVITIES_TBODY;

        $jobsiteSiteWorkData .= "No Sitework Activities Recorded.";
    }

    // Building Activities.
    $loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions = new Input();
    $loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions->forceLoadFlag = true;
    $arrReturn = JobsiteDailyBuildingActivityLog::loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, $loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogIdOptions);
    $arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = $arrReturn['objects'];
    $tableJobsiteBuildingActivitiesTbody = '';
    $jobsiteBuildingData = '';
    foreach ($arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId as $jobsite_daily_building_activity_log_id => $jobsiteDailyBuildingActivityLog) {
        /* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */

        /* @var $jobsiteBuilding JobsiteBuilding */

        $jobsite_building_activity_id = $jobsiteDailyBuildingActivityLog->jobsite_building_activity_id;
        $jobsiteBuildingActivity = JobsiteBuildingActivity::findById($database, $jobsite_building_activity_id);
        /* @var $jobsiteBuildingActivity JobsiteBuildingActivity */

        $jobsiteBuildingActivity->htmlEntityEscapeProperties();

        $escaped_jobsite_building_activity_label = $jobsiteBuildingActivity->escaped_jobsite_building_activity_label;

        $tableJobsiteBuildingActivitiesTbody .= <<<END_TABLE_JOBSITE_BUILDING_ACTIVITIES_TBODY

        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;$escaped_jobsite_building_activity_label</td>
        </tr>
END_TABLE_JOBSITE_BUILDING_ACTIVITIES_TBODY;

        $jobsiteBuildingData .= $escaped_jobsite_building_activity_label." | ";
    }

    $jobsiteBuildingData =  rtrim($jobsiteBuildingData, " | ");

    if (count($arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId) == 0) {

        $tableJobsiteBuildingActivitiesTbody = <<<END_TABLE_JOBSITE_BUILDING_ACTIVITIES_TBODY

        <tr>
            <td class="textAlignCenter">No Building Activities Recorded</td>
        </tr>
END_TABLE_JOBSITE_BUILDING_ACTIVITIES_TBODY;

        $jobsiteBuildingData .= "No Building Activities Recorded.";
    }

    // Weather.
    /* @var $jobsiteDailyLog JobsiteDailyLog */

    $arrReturn = getAmPmWeatherTemperaturesAndConditions($database, $project_id, $jobsite_daily_log_created_date);
    $amTemperature = $arrReturn['amTemperature'];
    $amCondition   = $arrReturn['amCondition'];
    $pmTemperature = $arrReturn['pmTemperature'];
    $pmCondition   = $arrReturn['pmCondition'];


    /*GC logo*/
    require_once('lib/common/Logo.php');
    $gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user_company_id);
    $fulcrum = Logo::logoByFulcrumByBasePath();
    $headerLogo=<<<headerLogo
    <table width="100%" class="table-header">
    <tr>
    <td>$gcLogo</td>
    <td align="right"><span style="margin-top:10px;">$fulcrum</span></td>
    </tr>
    </table>
    <hr>
headerLogo;
    $projectAddress = '';
    if(!empty($project_escaped_address_line_1)){
        $projectAddress .= $project_escaped_address_line_1."<br>";
    }
    $projectAddress .= $project_escaped_address_city." ".$project_escaped_address_state_or_region." ".$project_escaped_address_postal_code;
    /*GC logo end*/
    $htmlContent = <<<END_HTML_CONTENT

<div id="dcrPreview">
$headerLogo
    <div>
        <center style="font-size: 200%;">JOBSITE DAILY LOG</center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="50%">
                    <table cellpadding="3">
                        <tr>
                            <td class="textAlignRight">PROJECT:</td>
                            <td><b>$project_name</b></td>
                        </tr>
                        <tr>
                            <td class="textAlignRight">ADDRESS:</td>
                            <td>
                                $projectAddress
                            </td>
                        </tr>
                        <tr>
                            <td class="textAlignRight">DATE:</td>
                            <td>$jdlCreatedDate</td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table cellpadding="3">
                        <tr>
                            <td class="textAlignRight" nowrap>AM Temp:</td>
                            <td nowrap>$amTemperature</td>
                            <td class="textAlignRight" nowrap>AM Condition:</td>
                            <td nowrap>$amCondition</td>
                        </tr>
                        <tr>
                            <td class="textAlignRight">PM Temp:</td>
                            <td>$pmTemperature</td>
                            <td class="textAlignRight">PM Condition:</td>
                            <td>$pmCondition</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="4" cellspacing="0" width="100%" class="dcrPreviewTable" style="border:1px solid black;">
            <tr class="bottomBorder">
                <td colspan="2" class="dcrPreviewTableHeader" width="50%">MANPOWER ACTIVITY</td>
                <td colspan="3" class="leftBorder dcrPreviewTableHeader" width="50%">OUTSTANDING RFIs</td>
            </tr>
            <tr>
                <td class="paddingLeft thHeadtdNr">TODAY</td>
                <td class="thHeadtdNr alignCenter">COUNT</td>
                <td class="leftBorder paddingLeft thHeadtdNr">RFI #</td>
                <td class="thHeadtdNr">RFI TITLE</td>
                <td class="thHeadtdNr">DAYS OPEN</td>
            </tr>
            $tableCombineManPowerRfi
        </table>
        <br>
        <table border="0" cellpadding="4" cellspacing="0" width="100%" class="dcrPreviewTable" style="border:1px solid black;">
            <tr class="bottomBorder">
                <td colspan="3" width="50%" class="dcrPreviewTableHeader">INSPECTIONS</td>
                <td colspan="3" class="leftBorder dcrPreviewTableHeader" width="50%">SCHEDULE DELAYS</td>
            </tr>
            <tr class="btBtTr">
                <td class="thHeadtdNr paddingLeft">TYPE</td>
                <td class="thHeadtdNr">INSPECTION NOTES</td>
                <td class="thHeadtdNr alignCenter">PASSED</td>
                <td class="thHeadtdNr leftBorder paddingLeft">CATEGORY</td>
                <td class="thHeadtdNr">SUBCATEGORY</td>
                <td class="thHeadtdNr">DELAY NOTES</td>
            </tr>
            $tablecombineInspectionDelay
            <tr>
                <td class="thHeadtdNr paddingLeft" colspan="3">TOTAL</td>
                <td colspan="3" class="leftBorder"></td>
            </tr>
            <tr>
                <td class="paddingLeft" colspan="2">TODAY</td>
                <td class="alignCenter">$numInspectionsToday</td>
                <td colspan="3" class="leftBorder"></td>
            </tr>
            <tr>
                <td class="paddingLeft" colspan="2">CURRENT WEEK</td>
                <td class="alignCenter">$numInspectionsThisWeek</td>
                <td colspan="3" class="leftBorder"></td>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="4" cellspacing="0" width="100%" class="dcrPreviewTable" style="border:1px solid black;">
            <tr class="bottomBorder">
                <td class="dcrPreviewTableHeader">CONSTRUCTION ACTIVITY</td>
            </tr>
            <tr>
                <td class="thHeadtdNr paddingLeft">SITEWORK ACTIVITY</td>
            </tr>
            <tr>
                <td class="paddingLeft textJustify">$jobsiteSiteWorkData</td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td class="thHeadtdNr paddingLeft">BUILDING ACTIVITY</td>
            </tr>
            <tr>
                <td class="paddingLeft textJustify">$jobsiteBuildingData</td>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="4" cellspacing="0" width="100%" class="dcrPreviewTable" style="border:1px solid black;">
            <tr class="bottomBorder">
                <td class="dcrPreviewTableHeader">JOBSITE NOTES</td>
            </tr>   
            $tableJobsiteNotesTbodyNew
        </table>
    </div>
    $jobsitePhotoHtmlContent
</div>
END_HTML_CONTENT;

$dompdf = new DOMPDF(); 
$basefont = $config->system->file_manager_url .'fonts/calibri/calibri.ttf' ;
$baseinnerfont = $config->system->file_manager_url .'fonts/calibri/calibri-bold.ttf' ;
//Store the html data's
$http = $uri->http;
$htmlContent = <<<END_HTML_CONTENT

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{$http}css/styles.css">
    <link rel="stylesheet" type="text/css" href="{$http}css/modules-jobsite-daily-logs.css">
    <link rel="stylesheet" type="text/css" href="{$http}css/modules-daily-construction-report.css">
</head>
<body style="font-size: 90%;">
        $htmlContent               
</body>
</html>

END_HTML_CONTENT;
$data=ContactCompany::GenerateFooterData($user_company_id,$database);
$address=$data['address'];
$number=$data['number'];
$footer_cont=$address.' '.$number;
// Place the PDF file in a download directory and output the download link.
if (isset($isHtml) && $isHtml == true) {
    $htmlContent = $htmlContent;
    return $htmlContent;
    exit;
}


<?php
include_once('./Reports/GeneratePdfData.php');
require_once('../module-report-meeting-functions.php');
require_once('../module-report-jobstatus-functions.php');

try {
    $db = DBI::getInstance($database);
    $fromToDate=<<<Table_Date_Through_End
<td  class="table_header_td" width="5%">DATE</td><td width="1%">:</td><td> From  $displayStartDate To  $displayEndDate</td>
Table_Date_Through_End;
    switch($RN_reportType) {
    case 'Project Delay Log':
        $type_mention="Project Delay Log";
        $htmlContent=DelayLog($database, $RN_project_id,$RN_reportType,$RN_reportsStartDate,$RN_reportsEndDate,$type_mention);
        break;

    case 'ContractLog':
        $type_mention="Contract Log";
        $htmlContent=ContractLog($database, $user->user_company_id,$RN_project_id,$RN_reportsStartDate,$RN_reportsEndDate);
        break;

    case 'Detailed Weekly':
        $htmlContent=DetailedWeeklyReport($database, $user->user_company_id,$RN_project_id,$RN_reportsStartDate,$RN_reportsEndDate,$RN_reportsStartDate,$RN_reportsEndDate,$RN_reportsStartDate, "PDF");
        break;

    case 'Weekly Manpower':
        $htmlContent=ManPowerData($database, $user->user_company_id, $RN_project_id, $RN_reportsStartDate,$RN_reportsEndDate, "PDF");
        break;

    case 'Monthly Manpower':
        $man_power=buildManpowerSectionMonthly($database, $user->user_company_id, $RN_project_id, $RN_reportsStartDate,$RN_reportsEndDate);
        $htmlContent=$man_power;
        break;

    case 'Manpower summary':
        $db = DBI::getInstance($database);
        $query ="Select * from projects where id='".$RN_project_id."'";
        $db->execute($query);
        while($row = $db->fetch())
        {
            $start_date_full= $row['project_start_date'];
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
        //get the data's from table for Man Power 
        $man_power=manPowerSummary($database, $user->user_company_id, $RN_project_id, $RN_reportsStartDate,$RN_reportsEndDate);
        $htmlContent=$man_power;
        $fromToDate=<<<Table_Date_Through_End
        <td  class="table_header_td" width="5%">DATE</td><td width="1%">:</td><td> From  $date To  $date1</td><td class="align-right table_header_td">Total Days : $diff </td>
Table_Date_Through_End;
        break;
    
    case 'Weekly Job':
        $htmlContent=WeeklyJob($database,  $RN_project_id, $RN_reportsStartDate,$RN_reportsEndDate, $user->user_company_id );
        break;

    case 'RFI Report - by ID':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $htmlContent=RFIReportbyID($database, $user->user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $userCompanyName, $RN_project_name, $RN_reportsStartDate, $RN_reportsEndDate, $type_mention, '', $RN_filter_type);
        break;

    case 'RFI Report - QA - Open':
        $htmlContent=RFIReportQA($database, $user->user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $userCompanyName, $RN_project_name, $RN_reportsStartDate, $RN_reportsEndDate, $type_mention);
        break;

    case 'RFI Report - QA':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $htmlContent=RFIReportQA($database, $user->user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $userCompanyName, $RN_project_name, $RN_reportsStartDate, $RN_reportsEndDate, $type_mention, '', $RN_filter_type);
        break;
    //Submittal Log
    case 'Submittal Log - by ID':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $tablebody=SubmittalLog($database, $RN_project_id ,$RN_reportsStartDate,$RN_reportsEndDate, $user->user_company_id, $RN_filter_type);
        $htmlContent= $tablebody;
        break;
    //Submittal Log by Notes
    case 'Submittal Log - by Notes':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }

        $tablebody=SubmittalLogNotes($database, $RN_project_id ,$RN_reportsStartDate,$RN_reportsEndDate, $user->user_company_id, $RN_filter_type);
        $htmlContent= $tablebody;
        break;
    //Submittal Log by Notes
    case 'Submittal Log - by status':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $tablebody=SubmittalLogStatus($database, $RN_project_id ,$RN_reportsStartDate,$RN_reportsEndDate, $user->user_company_id, $RN_filter_type);
        $htmlContent= $tablebody;
        break;
    //Submittal Log by Cost Code
    case 'Submittal log - by Cost Code':
        switch ($RN_version) {
        case '1.0':
            break;
        default:
            $RN_filter_type = null;
            break;
        }
        $tablebody=SubmittalLogCostCode($database, $RN_project_id ,$RN_reportsStartDate,$RN_reportsEndDate, $user->user_company_id, $RN_filter_type);
        $htmlContent= $tablebody;
        break;
    //Bidder List Report
    case 'Bidder List':
        $sort_by_status = $RN_filter_type;
        $sort_by_order = $RN_filter_by;

        $arrBidders = getBidderArray($database, $user->user_company_id, $RN_project_id, $sort_by_status, $sort_by_order);
        $bidderListReport = loadPurchasingBidderListReportSpr($database, $arrBidders, $sort_by_order, $user->user_company_id);
        $htmlContent = $bidderListReport;
        $fromToDate='';
        break;
    //Meeting Discussion Report
    case 'Meetings - Tasks':
        $meeting_type_id = $RN_filter_type;
        $meeting_id = $RN_filter_by;
        $meetingData = meetingDataPreview($database, $RN_project_id, $meeting_type_id, $meeting_id, $RN_currentlySelectedProjectName, null);
        $htmlContent = $meetingData;
        $fromToDate='';
        break;
    //SCO
    case 'SCO':
        $view_option = $RN_filter_type;
        $filteropt = $RN_filter_by;

        $htmlContent =  renderSubcontractChangeOrderListView($RN_project_id,$user->user_company_id,$RN_currentlyActiveContactId,$view_option,'1',$filteropt, $database);
        $fromToDate='';
        break;
    //Job Status
    case 'Job Status':
        $db = DBI::getInstance($database);
        $con_querys="SELECT * from projects where id = $RN_project_id";
        $db->execute($con_querys);
        $rowvalue=$db->fetch();
        $db->free_result();
        if(isset($rowvalue))
            $RN_reportsStartDate=$rowvalue['project_start_date'];
        $tablebody=JobStatus($database, $user->user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $userCompanyName, $RN_currentlySelectedProjectName, $RN_reportsStartDate,$RN_reportsEndDate, $RN_reportType);
        $htmlContent = $tablebody;
        break;
    //Change order Report
    case 'Change Order':
        switch ($RN_version) {
        case '1.0':
            $db = DBI::getInstance($database);
            $con_querys="SELECT * from projects where id = $RN_project_id";
            $db->execute($con_querys);
            $rowvalue=$db->fetch();
            $db->free_result();
            if(isset($rowvalue))
                $RN_reportsStartDate=$rowvalue['project_start_date'];

            $currentdate = date('Y-m-d');
            if($RN_reportsStartDate == '' || $RN_reportsStartDate == 'null'){
                $RN_reportsStartDate = $currentdate;
            }
            if($RN_reportsEndDate == '' || $RN_reportsEndDate == 'null'){
                $RN_reportsEndDate = $currentdate;
            }
            break;
        default:
            break;
        }        
        $cot = $RN_filter_type;
        $coShowRejected = $RN_show_rejected;
        //$codesp = false;
        $codesp = $RN_reportsDescription;
        $changeorder=renderCoListView_AsHtmlJobstatusAll($database, $RN_project_id, $RN_reportsStartDate,$RN_reportsEndDate, $cot, '', 'CO', $codesp, $user->user_company_id, $coShowRejected);
        $htmlContent = $changeorder;
        $displayStartDate=date("m/d/Y", strtotime($RN_reportsStartDate));
        $displayEndDate=date("m/d/Y", strtotime($RN_reportsEndDate));
        $fromToDate=<<<Table_Date_Through_End
<td  class="table_header_td" width="5%">DATE</td><td width="1%">:</td><td> From  $displayStartDate To  $displayEndDate</td>
Table_Date_Through_End;
        break;
    //Change order Report
    case 'Sub List':
        $tablebody=BudgetList($database, $user->user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $userCompanyName, $RN_currentlySelectedProjectName);
        $htmlContent = $tablebody;
        break;
    //Current Budget
    case 'Current Budget':
        $reportType = 'pdf';
        $currentBudgetReport = renderCurrentBudgetReportHtml($database, $RN_project_id, $RN_reportsStartDate, $RN_reportsEndDate, $reportType, $user->user_company_id);
        $htmlContent = $currentBudgetReport;
        break;
    //Buyout
    case 'Buyout':
        $reportType = 'pdf';
        $subcontractsContract = renderBuyoutReportHtml($database, $RN_project_id, $RN_reportsStartDate, $RN_reportsEndDate, $reportType, $user->user_company_id);
        $htmlContent = $subcontractsContract;
        break;
    //Vector Report
    case 'Vector Report':
        $includegrp = filter_var($RN_groupco, FILTER_VALIDATE_BOOLEAN);
        $includegeneral = filter_var($RN_generalco, FILTER_VALIDATE_BOOLEAN);
        $includeNotes = filter_var($RN_includeNotes, FILTER_VALIDATE_BOOLEAN);
        $includesubTotal = filter_var($RN_subTotal, FILTER_VALIDATE_BOOLEAN);

        if($includegrp == true && $includegeneral == false){
            $checkboxcond = 2;
        }else if($includegrp == true && $includegeneral == true){
            $checkboxcond = 3;
        }else{
            $checkboxcond = 1;
        }
        $vectorReport =  renderVectorReportHtml($database, $RN_project_id, $user->user_company_id, $checkboxcond, $includeNotes, $includesubTotal);
        $htmlContent = $vectorReport;
        $fromToDate='';
        if ($htmlContent == 'groupdivnotmap') {
            $RN_jsonEC['status'] = 400;
            $RN_jsonEC['err_message']='Please group all the divisions in the Master Cost Codes list in Budget.';
            $RN_jsonEC['data']['reportResponse'] = null;
            return false;
        }
        break;
    //Buyout
    case 'Prelim Report':
        $reportType = 'pdf';
        $subcontractsContract = renderPrelimsReportHtml($database, $RN_project_id, $user->user_company_id);
        $htmlContent = $subcontractsContract;
        break;
    default:
        $RN_jsonEC['message']='No data found!';
        $RN_jsonEC['data']['reportResponse'] = null;
        return false;
        break;
    }    

$db_add = DBI::getInstance($database);
     $address = "SELECT address_line_1,address_city,address_state_or_region,address_postal_code,project_name FROM projects where  id='".$RN_project_id."'  ";
    $db_add->execute($address);
    $row_add = $db_add->fetch();
    $add_val = $row_add['address_line_1'].','.$row_add['address_city'].','.$row_add['address_postal_code'];
    $add_val=trim($add_val,',');
$projectName=$row_add['project_name'];
if($add_val!=''){
    $addContent = <<<END_HTML_CONTENT
 <td class="align-right table_header_td" >ADDRESS : $add_val</td>
END_HTML_CONTENT;
    $addContent;
}
/*GC logo*/
require_once('lib/common/Logo.php');
$gcLogo = Logo::logoByUserCompanyIDUsingBasePath($database,$user->user_company_id);
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
    /*GC logo end*/
$data=report_footer($database, $user->user_company_id);
$address=$data['address'];
$number=$data['number'];
$footer_cont=$address.' '.$number;
//$dompdf = new DOMPDF(); 
$basefont = $config->system->file_manager_url .'fonts/calibri/calibri.ttf' ;
$baseinnerfont = $config->system->file_manager_url .'fonts/calibri/calibri-bold.ttf' ;

$uri = Zend_Registry::get('uri');

if($uri->sslFlag){
    $baseUrl = $uri->https;
}else{
    $baseUrl = $uri->http;   
}

if (isset($RN_reportType) && ($RN_reportType=="Meetings - Tasks")) {
    $link = '<link rel="stylesheet" type="text/css" href="'.$baseUrl.'css/Api/download-report-meeting.css">';
}else{
    $link = '<link rel="stylesheet" type="text/css" href="'.$baseUrl.'css/Api/download-report-except-meeting.css">';
}
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
</style>
    $link
</head>
 <body>
 <div class="">
 <table width="100%" class="">
 <tr>
 <td>$gcLogo</td>
 <td class="align-right">$fulcrum</td>
 </tr>
 </table>
  </div>
 <div class="repot-inform">
 <table width="100%">
 <tr>
 <td  class="table_header_td" width="5%">PROJECT </td><td width="1%">:</td><td> $projectName </td>
 $addContent
  </tr>
 <tr>
 $fromToDate
 </tr>  
 </table>
 </div>
 <span class="report-name">$type_mention</span>
 $htmlContent
 </body>
</html>
ENDHTML;

// Place the PDF file in a download directory and output the download link.
$htmlContent = $html;
 // Copy all pdf files to the server's local disk
$config = Zend_Registry::get('config');
$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
$baseDirectory = $config->system->base_directory;
$fileManagerBasePath = $config->system->file_manager_base_path;
$tempFileName = File::getTempFileName();
$tempDir = $fileManagerBasePath.'temp/reports/'.$tempFileName.'/';
$removetempDir = $fileManagerBasePath.'temp/reports/'.$tempFileName;
$fileObject = new File();
$fileObject->mkdir($tempDir, 0777);
$tempPdfFile = File::getTempFileName().'.pdf';
            // Files come from the autogen pdf
$tempFilePath = $tempDir.$tempPdfFile;
$bid_spreadsheet_data_sha1 = sha1($htmlContent);
$usePhantomJS = true;
if ($usePhantomJS) {
    $pdfPhantomJS = new PdfPhantomJS();
        switch($RN_reportType){
            case 'Monthly Manpower':
            case 'Bidder List':
            case 'Meetings - Tasks':
              $pdfPhantomJS->setPdfPaperSize('17in', '11in');
            break;
            
            default:
              $pdfPhantomJS->setPdfPaperSize('8.5in', '11in');
            break;
        }
    $pdfPhantomJS->setPdffooter($footer_cont, null);
        $pdfPhantomJS->setMargin('50px', '50px', '50px', '10px');
    $pdfPhantomJS->writeTempFileContentsToDisk($htmlContent, $bid_spreadsheet_data_sha1);
    $pdfPhantomJS->setCompletePdfFilePath($tempFilePath);
    $result = $pdfPhantomJS->execute();
    $pdfPhantomJS->deleteTempFile();
}
$RN_sha1 = sha1_file($tempFilePath);
$RN_size = filesize($tempFilePath);
$RN_fileExtension = 'pdf';
$RN_virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($RN_fileExtension);

$tempFileNameDirNameOnly = 'reports/'.$tempFileName.'/'.$tempPdfFile;
$url = '__temp_file__?tempFileSha1='.$RN_sha1.'&tempFilePath='.$tempFileNameDirNameOnly.'&tempFileName='.$tempFileName.'&tempFileMimeType='.$RN_virtual_file_mime_type.'&tempFileDir=reports&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
$uri = Zend_Registry::get('uri');
/* @var $uri Uri */
if($uri->sslFlag){
    $baseCdnUrl = $uri->https;
}else{
    $baseCdnUrl = $uri->cdn_absolute_url;   
}
    $RN_fileUrl = $baseCdnUrl.$url;
    $RN_jsonEC['data']['reportResponse']['tempFilePath'] = $tempFilePath;
    $RN_jsonEC['data']['reportResponse']['filename'] = $tempPdfFile;
    $RN_jsonEC['data']['reportResponse']['fileUrl'] = $RN_fileUrl;
    $RN_jsonEC['data']['reportResponse']['fileSize'] = $RN_size;

}
catch(Exception $e){
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}

?>

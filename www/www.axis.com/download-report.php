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
require_once('module-report-ajax.php');
require_once('module-report-meeting-functions.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('module-report-vector-functions.php');
require_once('lib/common/DrawFileManagerFiles.php');
require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/FileManagerFile.php');
require_once('lib/common/FileManagerFolder.php');
//Get the session projectid & company id
if(isset($_GET['project_id']) && $_GET['project_id']!=''){
	$currentlySelectedProjectId = $project_id  = $_GET['project_id'];
}else{
	$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();

}


$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;
$user_company_id = $session->getUserCompanyId();
$project_name=$projectName=$_GET['projectName'];
$type_mention=$header_type_mention=$_GET['report_view'];

if(empty($_GET['date'])){
$date=$currentdate;
}else{
	$date=$_GET['date'];
}
if(empty($_GET['date1'])){
	$date1=$currentdate;
}else{
	$date1=$_GET['date1'];
}
	$dateObj = DateTime::createFromFormat('m/d/Y', $date);
	$new_date_format = $dateObj->format('Y-m-d');
	$enddate = DateTime::createFromFormat('m/d/Y', $date1);
	$EndDate = $enddate->format('Y-m-d');
	$new_begindate = $dateObj->format('Y-m-d');
	$enddate = $enddate->format('Y-m-d');
	$projectId=$_GET['project_id'];
if($_GET['report_view']=='Project Delay Log'){
	
	$projectId=$_GET['project_id'];
	$filterstatus=$_GET['cot'];
	$managePermission=$_GET['permission'];
	$delayTableTbody = '';
	$delayTableTbody1 = '';
	$incre_id=1;
	if($type_mention=='Project Delay Log')
	{
    	$type_mention="Delaylog";
	}
	$htmlContent = DelayLog($database,$projectId,$new_begindate,$enddate,$type_mention,$filterstatus);
	$htmlContent;

	//This is to display as header
	if($type_mention=='Delaylog')
	{
    	$type_mention="Delay log";
	}

}
if(isset($_GET['report_view']) && ($_GET['report_view']=="ContractLog"))
{
	$type_mention="Contract Log";
	$begindate = $dateObj;
	$Endate = DateTime::createFromFormat('m/d/Y', $date1);
 $htmlContent=ContractLog($database,$user_company_id,$project_id,$_GET['date'],$_GET['date1'],$new_begindate,$enddate,$Endate,$begindate);
}

if($_GET['report_view']=='Detailed Weekly'){

 $htmlContent=DetailedWeeklyReport($database, $user_company_id,$project_id,$_GET['date'],$_GET['date1'],$new_begindate,$enddate, "PDF");
}
if($_GET['report_view']=='Weekly Manpower'){
//get the data's from table for Man Power 
$man_power=buildManpowerSection($database, $user_company_id, $project_id, $new_begindate,$enddate, "PDF");
$htmlContent=$man_power;
}

if($_GET['report_view']=='Monthly Manpower'){
//get the data's from table for Man Power 
$man_power=buildManpowerSectionMonthly($database, $user_company_id, $project_id, $new_begindate,$enddate);
$htmlContent=$man_power;
}
//if the report is n't contact list should be view the date
$fromToDate=<<<Table_Date_Through_End
<td width="5%">DATE</td><td width="1%">:</td><td> From  $date To  $date1</td>
Table_Date_Through_End;
if($_GET['report_view']=='Manpower summary'){
	// to get the project start date
	$db = DBI::getInstance($database);
	$query ="Select * from projects where id='".$project_id."'";
	$db->execute($query);
	$start_date='';
	while($row = $db->fetch())
	{
		$start_date_full= $row['project_start_date'];
		$start_date_arr=explode(' ', $start_date_full);
		$start_date=$start_date_arr[0];
	}
	$dateObj1 = DateTime::createFromFormat('Y-m-d', $start_date);
	$date = $dateObj1->format('m/d/Y');
	
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
$fromToDate=<<<Table_Date_Through_End
<td width="5%">DATE</td><td width="1%">:</td><td> From  $date To  $date1</td><td class="align-right table_header_td">Total Days : $diff </td>
Table_Date_Through_End;
}
//Contact list report
if($_GET['report_view']=='Contact List'){
//get the data's from table for contact list 
$tablebody=TeamMemeberList($database,$project_id,$project_name);
$htmlContent=$tablebody;
//if the report is contact list should n't view the date
$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}
//Sub list Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Sub List"))
{	
$tablebody=BudgetList($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName);
$htmlContent=$tablebody;
//if the report is sub list should n't view the date
$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}
//Weekly Job
if(isset($_GET['report_view']) && ($_GET['report_view']=="Weekly Job"))
{	
	
	$tablebody=WeeklyJob($database, $project_id,$date,$date1,$enddate,$new_date_format,$EndDate,$user_company_id);
	$htmlContent= $tablebody;
}
//Submittal Log
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by ID"))
{
	if($_GET['cot']==null || $_GET['cot']=='null')
	{
		$cot = '';
	}else
	{
		$cot = $_GET['cot'];
	}
	$tablebody=SubmittalLog($database, $project_id ,$new_begindate,$enddate,$cot);
	$htmlContent= $tablebody;
}
//Submittal Log by Notes
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by Notes"))
{
	if($_GET['cot']==null || $_GET['cot']=='null')
	{
		$cot = '';
	}else
	{
		$cot = $_GET['cot'];
	}
	$tablebody=SubmittalLogNotes($database, $project_id ,$new_begindate,$enddate,$cot);
	$htmlContent= $tablebody;

}
//Submittal Log by Status
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by status"))
{
	if($_GET['cot']==null || $_GET['cot']=='null')
	{
		$cot = '';
	}else
	{
		$cot = $_GET['cot'];
	}
	$tablebody=SubmittalLogStatus($database, $project_id ,$new_begindate,$enddate,$cot);
	$htmlContent= $tablebody;

}
//Submittal Log by Cost Code
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal log - by Cost Code"))
{
	if($_GET['cot']=='null' || $_GET['cot']==null)
	{
		$cot = '';
	}else
	{
		$cot = $_GET['cot'];
	}
	$tablebody=SubmittalLogCostCode($database, $project_id ,$new_begindate,$enddate, $user_company_id,$cot);
	$htmlContent= $tablebody;

}
//RFI Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - by ID"))
{	
$tablebody=RFIReportbyID($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $_GET['report_view'],'',$_GET['cot']);
$htmlContent=$tablebody;

}
//RFI Q&A Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - QA"))
{	
$htmlContent=RFIReportQA($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $_GET['report_view'],'',$_GET['cot']);
}

//RFI Q&A Open Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - QA - Open"))
{	
$htmlContent=RFIReportQA($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $_GET['report_view']);
}
//Job status report function 
if(isset($_GET['report_view']) && ($_GET['report_view']=="Job Status"))
{	
	$db = DBI::getInstance($database);
    $con_querys="SELECT * from projects where id = $project_id";
    $db->execute($con_querys);
    $rowvalue=$db->fetch();
    $db->free_result();
    if(isset($rowvalue))
    	$new_begindate=$rowvalue['project_start_date'];
$tablebody=JobStatus($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $projectName, $new_begindate, $enddate, $_GET['report_view']);
$htmlContent = $tablebody;
}
//Bidder List report function 
if(isset($_GET['report_view']) && ($_GET['report_view']=="Bidder List"))
{
	$sort_by_status = $get->sbs;
	$sort_by_order = $get->sbo;

	$arrBidders = getBidderArray($database, $user_company_id, $project_id, $sort_by_status, $sort_by_order);
	$bidderListReport = loadPurchasingBidderListReportSpr($database, $arrBidders, $sort_by_order, $user_company_id);
	$htmlContent = $bidderListReport;
	//if the report is bid list should n't view the date
$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}
/* Vector Report */
if(isset($_GET['report_view']) && ($_GET['report_view']=="Vector Report"))
{
	$includegrprowval = $_GET['grouprowval'];
	$includegrp = $_GET['groupco'];
	$includegeneral = $_GET['generalco'];
	$inotes = $_GET['inotes'];
	$subtotal = $_GET['subtotal'];
	$costCodeAlias = $_GET['costCodeAlias'];
	$reportType = 'pdf';

	
	if($includegrp  =='true' && $includegeneral  =='false'){ // group enabled & general cond disabled
		$checkboxcond = 2;
	}else if($includegrp  =='true' && $includegeneral  =='true'){ // group and general cond enabled
		$checkboxcond = 3;
	}else{ // group & general disabled
		$checkboxcond = 1;
	}
	$vectorReport =  renderVectorReportHtml($database, $project_id, $user_company_id, $checkboxcond,$includegrprowval, $inotes, $subtotal, $costCodeAlias, $reportType);
	$htmlContent = $vectorReport;
	
	//if the report is bid list should n't view the date
$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}

/* Vector Report */
/*Change order Report */
if(isset($_GET['report_view']) && ($_GET['report_view']=="Change Order"))
{
	$cot = $_GET['cot'];
	$codesp = $_GET['codesp'];
	$coshowreject = $_GET['coshowreject'];
	$coshowcostcode = $_GET['coshowcostcode'];
	$view_option = $_GET['view_option'];
	$type_mention=''.'<br>';
	$changeorder=renderCoListView_AsHtmlJobstatusAll($database, $project_id, $new_begindate, $enddate, $cot, '', 'CO',$codesp, $user_company_id, $coshowreject,$coshowcostcode,$view_option);
	 $htmlContent = $changeorder;
}
if(isset($_GET['report_view']) && ($_GET['report_view']=="Buyout Summary")){
	$reportType = 'pdf';
	$costCodeAlias = $_GET['cot'];
	$subcontractsContract = renderBuyoutReportHtml($database, $project_id, $new_begindate, $enddate, $reportType, $user_company_id, $costCodeAlias);
	$htmlContent = $subcontractsContract;
}
if(isset($_GET['report_view']) && ($_GET['report_view']=="Buyout Log")){
	$reportType = 'pdf';
	$hasSubContAmt = $_GET['cot'];
	$costCodeAlias = $_GET['codesp'];
	$subcontractsContract = renderBuyoutLogReportHtml($database, $project_id, $new_begindate, $enddate, $reportType, $user_company_id, $hasSubContAmt, $costCodeAlias);
	$htmlContent = $subcontractsContract;
}
if(isset($_GET['report_view']) && ($_GET['report_view']=="Current Budget")){
	$crntNotes = $_GET['crntNotes'];
	$crntSubtotal = $_GET['crntSubtotal'];
	$crntValOnly = $_GET['crntBgt_val_only'];
	$costCodeAlias = $_GET['costCodeAlias'];
	$reportType = 'pdf';
	$currentBudgetReport = renderCurrentBudgetReportHtml($database, $project_id, $new_begindate, $enddate, $user_company_id, $reportType, $crntNotes, $crntSubtotal, $crntValOnly, $costCodeAlias);
	$htmlContent = $currentBudgetReport;
}
/*Meeting report function */
if(isset($_GET['report_view']) && ($_GET['report_view']=="Meetings - Tasks"))
{
	$meeting_type_id = $_GET['meeting_type_id'];
	$meeting_id = $_GET['meeting_id'];
	$meetingData = meetingDataPreview($database, $project_id, $meeting_type_id, $meeting_id, $currentlySelectedProjectName);
	$htmlContent = $meetingData;
	// $meetingCss = 'font-family: calibri;';
	$meetingCss = '';
	//Date's not needed 
$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}
/*Meeting report function */
if(isset($_GET['report_view']) && ($_GET['report_view']=="SCO"))
{

	$view_option = $_GET['view_option'];
	$filteropt = $_GET['filteropt'];
	$project_id= $_GET['project_id'];
	$checkpotential = $_GET['checkpotential'];
	
	 $htmlContent =  renderSubcontractChangeOrderListView($project_id,$user_company_id,$currentlyActiveContactId,$view_option,'1',$filteropt, $database,$checkpotential);

	
 	//Date's not needed 
$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}
if(isset($_GET['report_view']) && ($_GET['report_view']=="Subcontract Invoice"))
{

	$project_id= $_GET['project_id'];
	$status=$_GET['cot'];
	$status = trim($status,",");
	$htmlContent = renderSubcontractInvoiceHtml($database, $project_id,$user_company_id,$status);
 	//Date's not needed 
$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}
/*Prelim report function */
if(isset($_GET['report_view']) && ($_GET['report_view']=="Prelim Report"))
{
	$htmlContent = renderPrelimsHtml($database, $project_id,$user_company_id);

	
}
//Reallocation Report List call function
if(isset($_GET['report_view']) && ($_GET['report_view']=="Reallocation"))
{
	$isHtml = true;
	$drawId = $_GET['cot'];
	$costCodeAliasStatus = $_GET['codesp'];
	$type_mention=''.'<br>';
	require_once('download-reallocation-history-report.php');
	$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}

//Daily Construction Report (DCR) Report List call function
if(isset($_GET['report_view']) && ($_GET['report_view']=="Daily Construction Report (DCR)"))
{
	if(empty($_GET['dateDCR'])){
		$dateDCR= $currentdate;
	}else{
		$dateDCR=$_GET['dateDCR'];
	}
	$isHtml = true;
	require_once('download-dcr-report.php');
	$fromToDate=<<<Table_Date_Through_End
Table_Date_Through_End;
}

$db_add = DBI::getInstance($database);
	 $address = "SELECT address_line_1,address_city,address_state_or_region,address_postal_code FROM projects where  id='".$projectId."'  ";
	$db_add->execute($address);
	$row_add = $db_add->fetch();
	$add_val = $row_add['address_line_1'].','.$row_add['address_city'].','.$row_add['address_postal_code'];
	$add_val=trim($add_val,',');
	$prjAddress = '';

if($add_val!=''){
	$addContent = <<<END_HTML_CONTENT
 <td class="align-right" >ADDRESS : $add_val</td>
END_HTML_CONTENT;
	$addContent;
}

$prjAddress .= <<<END_HTML_CONTENT
	<div class="repot-inform">
 		<table width="100%">
 			<tr class="table_header_td">
	 			<td width="5%">PROJECT </td><td width="1%">:</td><td> $projectName</td>
	 			$addContent
			</tr>
 			<tr class="table_header_td">
 				$fromToDate
 			</tr>	
 		</table>
 	</div>
END_HTML_CONTENT;

if (isset($_GET['report_view']) && ($_GET['report_view']=="Reallocation")) {
	$prjAddress = '';
}
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
	/*GC logo end*/
$data=report_footer($database, $user_company_id);
$address=$data['address'];
$number=$data['number'];
$footer_cont=$address.' '.$number;
$dompdf = new DOMPDF(); 
$basefont = $config->system->file_manager_url .'fonts/calibri/calibri.ttf' ;
$baseinnerfont = $config->system->file_manager_url .'fonts/calibri/calibri-bold.ttf' ;

$uri = Zend_Registry::get('uri');
if ($uri->sslFlag) {
    $cdn = 'https:' . $uri->cdn;
} else {
    $cdn = 'http:' . $uri->cdn;
}
$baseUrl = $uri->http;

if (isset($_GET['report_view']) && ($_GET['report_view']=="Meetings - Tasks")) {
	$link = '<link rel="stylesheet" type="text/css" href="'.$baseUrl.'css/download-report-meeting.css">';
}else{
	$link = '<link rel="stylesheet" type="text/css" href="'.$baseUrl.'css/download-report-except-meeting.css">';
}

//Store the html data's
$html = <<<ENDHTML
<html>
<head>
	<style>
		@charset "UTF-8";
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
  	$prjAddress
 	<span class="report-name">$type_mention</span>
 	$htmlContent
</body>
</html>
ENDHTML;

// Place the PDF file in a download directory and output the download link.
if(isset($_GET['report_view']) && ($_GET['report_view']=="Daily Construction Report (DCR)"))
{
	$htmlContent = $htmlContent;
} else {
	$htmlContent = $html;
}

 // Copy all pdf files to the server's local disk
$config = Zend_Registry::get('config');
$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
$baseDirectory = $config->system->base_directory;
$fileManagerBasePath = $config->system->file_manager_base_path;
$tempFileName = File::getTempFileName();
$tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
$removetempDir = $fileManagerBasePath.'temp/'.$tempFileName;
$fileObject = new File();
$fileObject->mkdir($tempDir, 0777);
$tempPdfFile = File::getTempFileName().'.pdf';
            // Files come from the autogen pdf
$tempFilePath = $tempDir.$tempPdfFile;
$bid_spreadsheet_data_sha1 = sha1($htmlContent);
$usePhantomJS = true;
if ($usePhantomJS) {
    $pdfPhantomJS = new PdfPhantomJS();
		switch($_GET['report_view']){
			case 'Monthly Manpower':
			case 'Bidder List':
			  $pdfPhantomJS->setPdfPaperSize('17in', '11in');
			break;

			case 'Meetings - Tasks':
			case 'Reallocation':
			case 'Vector Report':	
			  $pdfPhantomJS->setPdfPaperSize('11in', '8.5in');	
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

// To open the created File path 
$header_type_mention=str_replace(' ', "-", $header_type_mention);
$filename = urlencode($header_type_mention)."-".$dates.":".$i.":".$s.".pdf";

if (isset($_GET['report_view']) && ($_GET['report_view']=="Vector Report") && ($_GET['is_draw_posted']=="true")) {

	$postedDate = date('m-d-Y');
    $filename = 'Vector Report #'.$applicationNumber.' '.$projectName."-".$postedDate.".pdf";

	$draw_action_type_id = intVal(TableService::getSingleField($database,'draw_action_types','id','action_name','Vector Report'));
	$draw_action_type_option_id = '';
	$drawId = $_GET['drawId'];
	$applicationNumber = $_GET['applicationNumber'];

    // Overrite the virtual file name when through date change 
    $drawFileMangerFileOptions = new Input();
    $drawFileMangerFileOptions->forceLoadFlag = true;
    $drawFileMangerFile = DrawFileManagerFiles::findByIdsDrawFileManagerFile($database, $drawId, $draw_action_type_id, $draw_action_type_option_id, $drawFileMangerFileOptions);

    if(isset($drawFileMangerFile) && !empty($drawFileMangerFile)){
      $file_manager_file_id = $drawFileMangerFile->file_manager_file_id;
      $drawFileMangerFile->convertPropertiesToData();
      // $data = $drawFileMangerFile->getData();
      // update filemanager file name
      $getFileManagerFileUpdate = FileManagerFile::findById($database, $file_manager_file_id);
      if(isset($getFileManagerFileUpdate) && !empty($getFileManagerFileUpdate)) {
        $virtual_file_name_update = $getFileManagerFileUpdate->virtual_file_name;
        $getFileManagerFileUpdate->convertPropertiesToData();
        $updateData = $getFileManagerFileUpdate->getData();
        FileManagerFile::restoreFromTrash($database,$file_manager_file_id);
        if ($virtual_file_name_update != $filename) {
          $updateData['virtual_file_name'] = $filename;
          $getFileManagerFileUpdate->setData($updateData);
          $getFileManagerFileUpdate->save();
        }
      }
    }

    $draw_virtual_file_path = "/Draws/";
    $drawUploadFileManagerFolder = FileManagerFolder::findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $currentlyActiveContactId, $project_id, $draw_virtual_file_path);

    $addFolder = '';
    if($draw_action_type_id == 1){
      $addFolder = $actionTypeName.'/';
    }
    $virtual_file_path = '/Draws/Draw #'. $applicationNumber.'/Fulcrum Generated Files/'.$addFolder;
    // Convert a nested folder path to each path portion and create a file_manager_folders record for each one
    $arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
    $currentVirtualFilePath = '/';
    foreach ($arrFolders as $folder) {
      $tmpVirtualFilePath = array_shift($arrFolders);
      $currentVirtualFilePath .= $tmpVirtualFilePath.'/';
      // Save the file_manager_folders record (virtual_file_path) to the db and get the id
      $fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $project_id, $currentVirtualFilePath);
    }
    $file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

    $sha1 = sha1_file($tempFilePath);
    $size = filesize($tempFilePath);
    $fileExtension = 'pdf';
    $virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

    // Final pdf document
    $virtual_file_name_tmp = $filename;
    $tmpFileManagerFile = new FileManagerFile($database);
    $tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
    $virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

    // Convert file content to File object
    $error = null;

    $file = new File();
    $file->sha1 = $sha1;
    $file->name = $virtual_file_name;
    $file->size = $size;
    $file->type = $virtual_file_mime_type;
    $file->tempFilePath = $tempFilePath;
    $file->fileExtension = $fileExtension;
    $file_location_id = FileManager::saveUploadedFileToCloud($database, $file, false);
    // save the file information to the file_manager_files db table
    $fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $currentlyActiveContactId, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);

    $file_manager_file_id = $fileManagerFile->file_manager_file_id;
    $fileDownloadPath = $fileManagerFile->generateUrlBasePath(true);

    // Potentially update file_location_id
    if ($file_location_id <> $fileManagerFile->file_location_id) {
      $fileManagerFile->file_location_id = $file_location_id;
      $data = array('file_location_id' => $file_location_id);
      $fileManagerFile->setData($data);
      $fileManagerFile->save();
    }

    // Set Permissions of the file to match the parent folder.
    $parent_file_manager_folder_id = $fileManagerFolder->getParentFolderId();
    FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
    FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);
	echo "success";
	exit;
}else{

    header('Content-Description: File Transfer');
    header('Content-Type: application/force-download');
    header("Content-Disposition: attachment; filename=\"" . $filename . "\";");
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($tempFilePath));
    ob_clean();
    flush();
    readfile($tempFilePath); //showing the path to the server where the file is to be download
    unlink($tempFilePath); //To remove temp file
    rmdir($removetempDir); //To remove temp folder
    exit;
}

<?php

/**
 * Report  Module.
 */

$init['application'] = 'www.axis.com';
$init['timer'] = false;
$init['timer_start'] = false;

require_once('lib/common/init.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once('lib/common/GcBudgetLineItem.php');
require_once('lib/common/BidList.php');
require_once('modules-gc-budget-functions.php');
require_once('module-report-ajax.php');
require_once('module-report-meeting-functions.php');
require_once('module-report-vector-functions.php');
require_once('subcontract-change-order-functions.php');


// DATABASE VARIABLES
$db = DBI::getInstance($database);
$db->free_result();
if(isset($_POST['project_id']) && $_POST['project_id']!=''){
		$currentlySelectedProjectId = $project_id = $_POST['project_id'];
	}elseif(isset($_POST['projectId']) && $_POST['projectId']!=''){
		$currentlySelectedProjectId = $project_id = $_POST['projectId'];
	}else{
		$currentlySelectedProjectId = $project_id = $session->getCurrentlySelectedProjectId();
	}

$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
$user_company_id = $session->getUserCompanyId();
$project_name = $session->getCurrentlySelectedProjectName();
$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $session->getUserCompanyId());
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

if(isset($_POST['date']) && $_POST['date']!='')	{
/*Date format for sql comparision*/
$begindate = DateTime::createFromFormat('m/d/Y', $_POST['date']);
$new_begindate = $begindate->format('Y-m-d');
}if(isset($_POST['date1']) && $_POST['date1']!='')	{

$Endate = DateTime::createFromFormat('m/d/Y', $_POST['date1']);
$enddate = $Endate->format('Y-m-d');
}
/*Delay Log Report */
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Project Delay Log" ))
{

	$filterstatus=$_POST['cot'];
	if($_POST['report_view']=='Project Delay Log')
	{
		$type_mention='Delaylog';
	}else
	{
	$type_mention=$_POST['report_view'];
	}
	$delayTableTbody = '';
	$delayTableTbody1 = '';
	
	$htmlContent = DelayLog($database,$projectId,$new_begindate,$enddate,$type_mention,$filterstatus);
	
	echo $htmlContent;
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="ContractLog"))
{
	$htmlContent=ContractLog($database, $user_company_id,$project_id,$_POST['date'],$_POST['date1'],$new_begindate,$enddate,$Endate,$begindate);
	echo $htmlContent;
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Detailed Weekly"))
{
	echo $htmlContent=DetailedWeeklyReport($database, $user_company_id,$project_id,$_POST['date'],$_POST['date1'],$new_begindate,$enddate,$Endate,$begindate);
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Weekly Manpower"))
{
	//get the data's from table for Man Power 
	$man_power=buildManpowerSection($database, $user_company_id, $project_id, $new_begindate,$enddate);
	echo $man_power;
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Monthly Manpower"))
{
	//get the data's from table for Man Power 
	$man_power=buildManpowerSectionMonthly($database, $user_company_id, $project_id, $new_begindate,$enddate);
	echo $man_power;
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Subcontractor Audit List"))
{
	//get the data's from table for subcontruct audit report

	$subcontructor_id=isset($_POST['vendor_id']) ? $_POST['vendor_id'] : '';
	$vendor=isset($_POST['vendor']) ? $_POST['vendor'] : '';
	$cc_id=isset($_POST['cc_id']) ? $_POST['cc_id'] : '';
	$subcontruct_audit=make_subcontruct_audit_report($database, $user_company_id, $project_id, $subcontructor_id, $vendor, $cc_id);
	echo $subcontruct_audit;
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Manpower summary"))
{
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
	$today=date('Y-m-d');

	$dateObj1 = DateTime::createFromFormat('Y-m-d', $start_date);
	
	$date_st = $dateObj1->format('m/d/Y');
	$dateObj2 = DateTime::createFromFormat('Y-m-d', $today);
	$date_end = $dateObj2->format('m/d/Y');

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

	<table id="safetyissues" class="detailed_week content cell-border " border="0" cellpadding="5" cellspacing="0" width="100%">
		<thead class="borderBottom">
			<tr><td>Date : From $date_st To $date_end</td>
				<td>Total Days : $diff</td></tr>
				<tr class="table-headerinner">
					<th colspan="2" class="align-left">TOTAL MAN DAYS</th>
				</tr>
				<tr >

				</tr>
			</thead>
			<tbody class="altColors">
				<tr><td>Total Man Days (Including $company employees)</td><td>$man_power_count</td></tr>
				<tr><td>Total Man Hours (Days * 8 hrs)</td><td>$man_days</td></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr><td>Total Man Days (Excluding $company employees)</td><td>$manPowerExcludingAdvent</td></tr>
				<tr><td>Total Man Hours (Days * 8 hrs)</td><td>$manPowerExcludingAdventDays</td></tr>
			</tbody>
		</table>
END_HTML_CONTENT;

		echo $htmlContent;
	}
//Contact List report call function
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Contact List"))
	{
		$tablebody=TeamMemeberList($database, $currentlySelectedProjectId,$currentlySelectedProjectName);

		echo $tablebody;
	}
//sub List report function call
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Sub List"))
	{	
		$tablebody=BudgetList($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $currentlySelectedProjectName);
		echo $tablebody;
	}
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Weekly Job"))
	{

		$tablebody=WeeklyJob($database, $project_id,$_POST['date'],$_POST['date1'],$Endate,$new_begindate,$enddate,$user_company_id );
		echo $tablebody;

	}
//Submittal Log by ID Main 

	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Submittal Log - by ID"))
	{

		$tablebody = SubmittalLog($database, $project_id, $new_begindate, $enddate, $_POST['cot']);
		echo $tablebody;

	}
//Submittal Log by Notes Main
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Submittal Log - by Notes"))
	{

		$tablebody=SubmittalLogNotes($database, $project_id, $new_begindate, $enddate, $_POST['cot']);
		echo $tablebody;

	}
//Submittal Log by status Main
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Submittal Log - by status"))
	{
		$tablebody=SubmittalLogStatus($database, $project_id, $new_begindate, $enddate, $_POST['cot']);
		echo $tablebody;
	}
//Submittal Log by Cost Code
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Submittal log - by Cost Code"))
	{	
		$tablebody=SubmittalLogCostCode($database, $project_id, $new_begindate, $enddate, $user_company_id, $_POST['cot']);
		echo $tablebody;
	}
//RFI Report - by ID function call
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="RFI Report - by ID"))
	{	
		$tablebody=RFIReportbyID($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $currentlySelectedProjectName, $new_begindate, $enddate, $_POST['ReportType'],'',$_POST['cot']);
		echo $tablebody;
	}
//RFI Report -QA function call

	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="RFI Report - QA"))
	{	
		$tablebody=RFIReportQA($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $currentlySelectedProjectName, $new_begindate, $enddate, $_POST['ReportType'],'',$_POST['cot']);
		echo $tablebody;
	}
//RFI Report -QA Open function call
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="RFI Report - QA - Open"))
	{	
		$tablebody=RFIReportQA($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $currentlySelectedProjectName, $new_begindate, $enddate, $_POST['ReportType']);
		echo $tablebody;
	}
//Job status report function 
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Job Status"))
	{	
		$db = DBI::getInstance($database);
		$con_querys="SELECT * from projects where id = $project_id";
		$db->execute($con_querys);
		$rowvalue=$db->fetch();
		$db->free_result();
		if(isset($rowvalue))
			$new_begindate=$rowvalue['project_start_date'];
		$tablebody=JobStatus($database, $user_company_id, $currentlyActiveContactId, $project_id, $userCompanyName, $project_name, $new_begindate, $enddate, $_POST['ReportType']);
		echo $tablebody;
	}
	/*Bidder List Report */
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Bidder List"))
	{
		$sort_by_status = $post->sbs;
		$sort_by_order = $post->sbo;

		$arrBidders = getBidderArray($database, $user_company_id, $project_id, $sort_by_status, $sort_by_order);
		$bidderListReport = loadPurchasingBidderListReportSpr($database, $arrBidders, $sort_by_order, $user_company_id);
		echo $htmlContent = $bidderListReport;
	}
	/*Change order Report */
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Change Order"))
	{
		$cot = $_POST['cot'];
		$codesp = $_POST['codesp'];
		$coshowreject = $_POST['coshowreject'];
		$coshowcostcode = $_POST['coshowcostcode'];
		$view_option = $_POST['view_option'];
		$changeorder=renderCoListView_AsHtmlJobstatusAll($database, $project_id, $new_begindate, $enddate, $cot, '', 'CO',$codesp, $user_company_id, $coshowreject,$coshowcostcode,$view_option);
		echo $changeorder;
	}
	/*Meeting Discussion Report */
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Meetings - Tasks"))
	{
		$meeting_type_id = $_POST['meeting_type_id'];
		$meeting_id = $_POST['meeting_id'];
		echo $meetingData = meetingDataPreview($database, $project_id, $meeting_type_id, $meeting_id, $currentlySelectedProjectName);
	}
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="SCO"))
	{
		$view_option = $_POST['view_option'];
		$filteropt = $_POST['filteropt'];
		$project_id= $_POST['project_id'];
		$checkpotential = $_POST['checkpotential'];

	$htmlContent =  renderSubcontractChangeOrderListView($project_id,$user_company_id,$currentlyActiveContactId,$view_option,'1',$filteropt, $database,$checkpotential);
	
	echo $htmlContent;
	}
	//To get the emails of the Bidderlist
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Bidder Email"))
	{
		
		$sort_by_status = $_POST['sbs'];
		$sort_by_order =  $_POST['sbo'];
		$project_id =  $_POST['project_id'];
		$arrBidders = getBidderArray($database, $user_company_id, $project_id, $sort_by_status, $sort_by_order);
		$retEmail="<div class='emailid--list'><table>";
		$emailarr=array();
		foreach ($arrBidders AS $subcontractor_bid_id => $dummy) {
        $contact_id = $arrBidders[$subcontractor_bid_id]['contact_id'];
        $email = $arrBidders[$subcontractor_bid_id]['email'];
        if($email !='')
        {
        $emailarr[$contact_id]=$email;
   	}
    }

    foreach ($emailarr as $key => $evalue) {
    	
        $retEmail .="<tr><td><input class='actselect'  id='conemail_$key'  value='$evalue'  type='checkbox'> $evalue</td><tr>";
    	}
    	$retEmail .= "</table></div>";
    	
    	$resCon = <<<END_HTML_CONTENT
			Copy/Paste recipients into your email client of choice from the recipient list below:<br>
			<div class="">
			<input name="emcom" value="," checked="" type="radio">&nbsp;Comma(",")&nbsp; delimited</div>
			<div class="">
			<input name="emcom" value=";"  type="radio">&nbsp;Semicolon(";") &nbsp; delimited
			</div>
			$retEmail
			<div id="copyemail"></div>
			<input onclick="SelectallEmail();" value="Select All" type="button">
			<input onclick="copycontent();" value="Done" type="button">

END_HTML_CONTENT;
	echo $resCon;

	}
	//To get the emails of the Bidderlist
	if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Contact Email"))
	{
        $orderBy = 'company ASC, first_name ASC, last_name ASC';

        $arrContactsWithRolesByProjectId = ProjectToContactToRole::loadContactsWithRolesByProjectIdReport($database, $project_id, $orderBy, true);
        $emailarr=array();
  		$retEmail="<div class='emailid--list'><table>";

        foreach ($arrContactsWithRolesByProjectId AS $contact_id => $contact) {
                $contact->htmlEntityEscapeProperties();
                $email = $contact->email;
                if($email !='')
                {
                $emailarr[$contact_id]=$email;
            	}
            }
             foreach ($emailarr as $key => $evalue) {
    	
        $retEmail .="<tr><td><input class='actselect'  id='conemail_$key'  value='$evalue'  type='checkbox'> $evalue</td></tr>";
    	}
    	$retEmail .= "</table></div>";
    	
    	$resCon = <<<END_HTML_CONTENT
			Copy/Paste recipients into your email client of choice from the recipient list below:<br>
			<div class="">
			<input name="emcom" value="," checked="" type="radio">&nbsp;Comma(",")&nbsp; delimited</div>
			<div class="">
			<input name="emcom" value=";"  type="radio">&nbsp;Semicolon(";") &nbsp; delimited</div>
			$retEmail
			<div id="copyemail"></div>
			<input onclick="SelectallEmail();" value="Select All" type="button">
			<input onclick="copycontent();" value="Done" type="button">

END_HTML_CONTENT;
	echo $resCon;
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Buyout Summary")){
	$reportType = 'html';
	$costCodeAlias = $_POST['cot'];	
	$subcontractsContract = renderBuyoutReportHtml($database, $project_id, $new_begindate, $enddate, $reportType, $user_company_id, $costCodeAlias);
	echo $subcontractsContract;
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Buyout Log")){
	$reportType = 'html';
	$hasSubContAmt = $_POST['cot'];
	$costCodeAlias = $_POST['codesp'];	
	$subcontractsContract = renderBuyoutLogReportHtml($database, $project_id, $new_begindate, $enddate, $reportType, $user_company_id, $hasSubContAmt, $costCodeAlias);
	echo $subcontractsContract;
}
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Current Budget")){
	$crntNotes = $_POST['crntNotes'];
	$crntSubtotal = $_POST['crntSubtotal'];
	$crntValOnly = $_POST['crntBgt_val_only'];
	$costCodeAlias = $_POST['costCodeAlias'];	

	$currentBudgetReport = renderCurrentBudgetReportHtml($database, $project_id, $new_begindate, $enddate, $user_company_id,'', $crntNotes, $crntSubtotal, $crntValOnly, $costCodeAlias);
	echo $currentBudgetReport;
}

if(!empty($_POST['ReportType']) && $_POST['ReportType']=="Vector Report"){
	$includegrprowval = $_POST['grouprowval'];
	$includegrp = $_POST['groupco'];
	$includegeneral = $_POST['generalco'];
	$inotes = $_POST['inotes'];
	$subtotal = $_POST['subtotal'];
	$costCodeAlias = $_POST['costCodeAlias'];

	if($includegrp  =='true' && $includegeneral  =='false'){ // group enabled & general cond disabled
		$checkboxcond = 2;
	}else if($includegrp  =='true' && $includegeneral  =='true'){ // group and general cond enabled
		$checkboxcond = 3;
	}else{ // group & general disabled
		$checkboxcond = 1;
	}

	$currentBudgetReport = renderVectorReportHtml($database, $project_id,
	$user_company_id, $checkboxcond,$includegrprowval,$inotes,$subtotal,$costCodeAlias,'');

	echo $currentBudgetReport;
}
//Prelims Report List call function
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Prelim Report"))
{
	
	$htmlContent = renderPrelimsHtml($database, $project_id,$user_company_id);
	echo $htmlContent;
}

//Reallocation Report List call function
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Reallocation"))
{
	$isHtml = true;
	$drawId = $_POST['cot'];
	$costCodeAliasStatus = $_POST['codesp'];
	require_once('download-reallocation-history-report.php');
	echo $htmlContent;
}

//Daily Construction Report (DCR) Report List call function
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Daily Construction Report (DCR)"))
{
	if(empty($_POST['dateDCR'])){
		$dateDCR= $currentdate;
	}else{
		$dateDCR=$_POST['dateDCR'];
	}
	$isHtml = true;
	require_once('download-dcr-report.php');
	echo $htmlContent;
}
// subcontract invoice report
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Subcontract Invoice" ))
{
	$project_id= $_POST['projectId'];
	$filterstatus=$_POST['cot'];
	$status = implode(',', $filterstatus);
	$status = trim($status,",");
	$subinvoiceReport = renderSubcontractInvoiceHtml($database, $project_id,$user_company_id,$status);
	echo $subinvoiceReport;
	}

// Get Cose code for company id based
if(isset($_POST['ReportType']) && ($_POST['ReportType']=="Company" ))
{
	$vendor_id= $_POST['vendor_id'];
	$costCodeList = loadSelectedReportCompany($database, $vendor_id, $project_id);
	echo $costCodeList;
}
// Get Cose code for company id based

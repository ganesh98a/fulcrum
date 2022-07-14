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
// date_default_timezone_set('Asian/kolkata');
$timezone = date_default_timezone_get();
$dates = date('d-m-Y:h', time());
$i=date('i', time());
$s=date('s:a', time());
$a=date('a', time());
$timedate=date('d/m/Y h:i a', time());
$currentdate=date('m/d/Y', time());
require_once('lib/common/init.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once("dompdf/dompdf_config.inc.php");
require_once('lib/common/GcBudgetLineItem.php');
require_once('modules-gc-budget-functions.php');
/*PHPExcel files*/
require_once 'PHPClasses/PHPExcel/IOFactory.php';
require_once 'PHPClasses/PHPExcel.php';
require_once 'PHPClasses/PHPExcel/Writer/Excel2007.php';
// /home/sathish/Downloads/PHPExcel-1.8/PHPClasses/PHPExcel/Writer/Excel2007.php

// require_once('module-report-ajax.php');
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
$type_mention=$_GET['report_view'];
if($_GET['date']=='' || $_GET['date']=='null'){
	$date=$currentdate;
}else{
	$date=$_GET['date'];
}
if($_GET['date1']=='' || $_GET['date1']=='null'){
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

$db_add = DBI::getInstance($database);
	 $address = "SELECT address_line_1,address_city,address_state_or_region,address_postal_code FROM projects where  id='".$projectId."'  ";
	$db_add->execute($address);
	$row_add = $db_add->fetch();
	$add_val = $row_add['address_line_1'].','.$row_add['address_city'].','.$row_add['address_postal_code'];
	$add_val=trim($add_val,',');

if($_GET['report_view']=='Delaylog' || $_GET['report_view']=='DCR'){
	
	$delayTableTbody = '';
	$delayTableTbody1 = '';
	$incre_id=1;
	include_once('delaylog-csv.php');
}
if($_GET['report_view']=='Weekly Manpower'){

	include_once('weeklyManpower-csv.php');
}
if($_GET['report_view']=='Monthly Manpower'){
	
	include_once('monthlyManpower-csv.php');
}
if($_GET['report_view']=='Detailed Weekly'){
	include_once('detailedweekly-csv.php');
}
if($_GET['report_view']=='Manpower summary'){
	include_once('manpowersummary-csv.php');
}
if($_GET['report_view']=='Contact List'){
	include_once('contactlist-csv.php');
}
if($_GET['report_view']=='Sub List'){
	include_once('sublist-csv.php');
}
//Bidder List report function 
if(isset($_GET['report_view']) && ($_GET['report_view']=="Bidder List"))
{
	$sort_by_status = $get->sbs;
	$sort_by_order = $get->sbo;
	include_once('bidlist-csv.php');
}
//Submittal Log
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by ID"))
{
	include_once('submittal_by_id-csv.php');
}
//Submittal Log by Notes
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by Notes"))
{
	include_once('submittal_by_notes-csv.php');
}
//Submittal Log by Status
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by status"))
{
	include_once('submittal_by_status-csv.php');
}
//Submittal Log by Cost Code
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal log - by Cost Code"))
{
	include_once('submittal_by_costcode-csv.php');
}
//RFI Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - by ID"))
{	
	include_once('request_for_information_by_id-csv.php');
}
//RFI Q&A Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - QA"))
{	
	include_once('request_for_information_by_qa-csv.php');
}
//RFI Q&A Open Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - QA - Open"))
{	
	include_once('request_for_information_by_qa-csv.php');
}

$filename = urlencode($type_mention)."-".$dates.":".$i.":".$s.".csv";
// Redirect output to a client’s web browser (Excel5)
header('Content-type: text/csv');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
exit;
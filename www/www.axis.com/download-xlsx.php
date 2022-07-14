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
$datessheet = date('d-m-Y_h', time());
$i=date('i', time());
$s=date('s:a', time());
$ssheet=date('s_a', time());
$a=date('a', time());
$timedate=date('d/m/Y h:i a', time());
$currentdate=date('m/d/Y', time());
require_once('lib/common/init.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once("dompdf/dompdf_config.inc.php");
require_once('lib/common/GcBudgetLineItem.php');
require_once('modules-gc-budget-functions.php');
require_once('image-resize-functions.php');
require_once('lib/common/ImageManagerImage.php');
require_once('lib/common/PdfPhantomJS.php');
require_once('module-report-ajax.php');
require_once('module-report-vector-functions.php');
/*PHPExcel files*/
require_once 'PHPClasses/PHPExcel/IOFactory.php';
require_once 'PHPClasses/PHPExcel.php';
require_once 'PHPClasses/PHPExcel/Writer/Excel2007.php';
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
if(empty($_GET['date'])){
	$date = $currentdate;
}else{
	$date = $_GET['date'];
}
if(empty($_GET['date1'])){
	$date1 = $currentdate;
}else{
	$date1 = $_GET['date1'];
}
$dateObj = DateTime::createFromFormat('m/d/Y', $date);
$new_date_format = $dateObj->format('Y-m-d');
$enddate = DateTime::createFromFormat('m/d/Y', $date1);
$EndDate = $enddate->format('Y-m-d');
$new_begindate = $dateObj->format('Y-m-d');
$enddate = $enddate->format('Y-m-d');
$projectId=$_GET['project_id'];
/*GC logo*/
require_once('lib/common/Logo.php');
$gcLogo = Logo::logoByUserCompanyIDUsingSoftlinkPath($database,$user_company_id, true);
$fulcrumLogo = Logo::logoByFulcrumByBasePathOnly();
$gcLogoReal = Logo::logoByUserCompanyIDUsingSoftlinkPath($database,$user_company_id);

/*get the image property*/
$path= realpath($gcLogoReal);
$mime = $type = '';
$height = $width = 0;
if(file_exists($path) && !empty($gcLogoReal)){
	$info   = getimagesize($path);
	$mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
	$width  = $info[0]; // width as integer for ex. 512
	$height = $info[1]; // height as integer for ex. 384
	$type   = $info[2]; // same as exif_imagetype
}


$fulcrum = $gcLogo;
/*GC logo*/
$db_add = DBI::getInstance($database);
$address = "SELECT address_line_1,address_city,address_state_or_region,address_postal_code FROM projects where  id='".$projectId."'  ";
$db_add->execute($address);
$row_add = $db_add->fetch();
$add_val = $row_add['address_line_1'].','.$row_add['address_city'].','.$row_add['address_postal_code'];
$add_val=trim($add_val,',');

if($_GET['report_view']=='Project Delay Log'){	
	$delayTableTbody = '';
	$delayTableTbody1 = '';
	$incre_id=1;
	include_once('delaylog-xlsx.php');
}
if($_GET['report_view']=='Weekly Manpower'){
	$project_id= $_GET['project_id'];
	$weekSelDate = $new_date_format;
	include_once('weeklyManpower-xlsx.php');
}
if($_GET['report_view']=='Monthly Manpower'){
	
	include_once('monthlyManpower-xlsx.php');
}
if($_GET['report_view']=='Detailed Weekly'){
	include_once('detailedweekly-xlsx.php');
}
if($_GET['report_view']=='Manpower summary'){
	include_once('manpowersummary-xlsx.php');
}
if($_GET['report_view']=='Weekly Job'){
	include_once('Weeklyjob-xlsx.php');
}
/*Contact report*/
if($_GET['report_view']=='Contact List'){
	include_once('contactlist-xlsx.php');
}
/*Sublist report*/
if($_GET['report_view']=='Sub List'){
	include_once('sublist-xlsx.php');
}
//Bidder List report function 
if(isset($_GET['report_view']) && ($_GET['report_view']=="Bidder List")){
	$sort_by_status = $get->sbs;
	$sort_by_order = $get->sbo;
	include_once('bidlist-xlsx.php');
}
//Submittal Log
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by ID")){
	include_once('submittal_by_id-xlsx.php');
}
//Submittal Log by Notes
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by Notes")){
	include_once('submittal_by_notes-xlsx.php');
}
//Submittal Log by Status
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal Log - by status")){
	include_once('submittal_by_status-xlsx.php');
}
//Submittal Log by Cost Code
if(isset($_GET['report_view']) && ($_GET['report_view']=="Submittal log - by Cost Code")){
	include_once('submittal_by_costcode-xlsx.php');
}
//RFI Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - by ID")){	
	include_once('request_for_information_by_id-xlsx.php');
}
//RFI Q&A Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - QA")){
	include_once('request_for_information_by_qa-xlsx.php');
}
//RFI Q&A Open Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="RFI Report - QA - Open")){	
	include_once('request_for_information_by_qa-xlsx.php');
}
//Change order Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Change Order")){
	$codesp = $_GET['codesp'];
	$coshowreject = $_GET['coshowreject'];
	$coshowcostcode = $_GET['coshowcostcode'];
	$view_option = $_GET['view_option'];
	include_once('changeorder-xlsx.php');
}
//SCO Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="SCO")){
	
		$viewState = $_GET['view_option'];
		$filteropt = $_GET['filteropt'];
		$project_id= $_GET['project_id'];
		$checkpotential = $_GET['checkpotential'];
	include_once('SCO-xlsx.php');
}
//Buyout Summary Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Buyout Summary")){
	$costCodeAlias = $get->cot;
	include_once('buyout_report-xlsx.php');
}
//Buyout Log Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Buyout Log")){
	$hasSubContAmt = $get->cot;
	$costCodeAlias = $get->codesp;
	include_once('buyout_log_report_xlsx.php');
}
//Current Budget Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Current Budget")){
	$crntNotes = $get->crntNotes;
	$crntSubtotal = $get->crntSubtotal;
	$crntValOnly = $get->crntBgt_val_only;
	$costCodeAlias = $get->costCodeAlias;
	include_once('current_budget_report-xlsx.php');
}
//Subcontract Invoice Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Subcontract Invoice")){
	$project_id= $get->project_id;
	$filterstatus= $get->cot;
	$filterstatus = trim($filterstatus,",");
	include_once('subcontract_invoice_xlsx.php');
}
//Prelims Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Prelim Report")){
	
	include_once('Prelim_xlsx.php');
}
//Monthly man power Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Monthly Manpower")){
	include_once('monthlymanpower_xlsx.php');
}
// Vector List Report
if(isset($_GET['report_view']) && ($_GET['report_view']=="Vector Report")){
	$includegrprowval = $get->grouprowval;
	$includegrp = $get->groupco;
	$includegeneral = $get->generalco;
	$inotes = $get->inotes;
	$subtotal = $get->subtotal;
	$costCodeAlias = $get->costCodeAlias;
	
	if($includegrp  =='true' && $includegeneral  =='false'){ // group enabled & general cond disabled
		$checkboxcond = 2;
	}else if($includegrp  =='true' && $includegeneral  =='true'){ // group and general cond enabled
		$checkboxcond = 3;
	}else{ // group & general disabled
		$checkboxcond = 1;
	}

	include_once('vectorlist-xlsx.php');
}
// manpower summary
if($_GET['report_view']=='Manpower summary'){
	$project_id = $get->project_id;
	include_once('manpowersummary-xlsx.php');
}
// Reallocation Report
if($_GET['report_view']=='Reallocation'){
	$drawId = $get->cot;
	$costCodeAliasStatus = $get->codesp;
	include_once('download-reallocation-history-report-xlsx.php');
}
// Subcontractor Audit List
if($_GET['report_view']=='Subcontractor Audit List'){
	$vendor_id = $get->vendor_id;
	$vendor = $get->vendor;
	$cc_id=$get->cc_id;
	include_once('subcontractor-audit-list-xlsx.php');
}
$filename = urlencode($type_mention)."-".$dates.":".$i.":".$s.".xlsx";
$filenameSheet = $type_mention;
$objPHPExcel->getActiveSheet()->setTitle($filenameSheet);
if (!file_exists($fulcrum)) {
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(-1);
}
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel,'Excel5');
$objWriter->save('php://output');
exit;

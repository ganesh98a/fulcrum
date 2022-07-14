<?php
include_once('./Reports/ReportFooter.php');
include_once("../dompdf/dompdf_config.inc.php");

$RN_jsonEC['status'] = 200;
$type_mention=$RN_reportType;
$timezone = date_default_timezone_get();
$dates = date('d-m-Y h', time());
$i=date('i', time());
$s=date('s a', time());
$a=date('a', time());
$timedate=date('d/m/Y h:i a', time());
$currentdate=date('m/d/Y', time());
$displayStartDate=date("m/d/Y", strtotime($RN_reportsStartDate));
$displayEndDate=date("m/d/Y", strtotime($RN_reportsEndDate));
$RN_currentlyActiveContactId = $user->currentlyActiveContactId;

if($RN_downloadType==='pdf'){
	if($RN_reportType === 'DCR')
    {
        $type_mention="Daily Log";
        include_once('./Reports/GenerateDailyLogPdfReports.php');
    } else {
    	include_once('./Reports/GeneratePdfReports.php');
    }    
}else{
     // include_once('./Reports/GenerateExcelData.php');
	include_once('./Reports/GenerateExcelReports.php');
}

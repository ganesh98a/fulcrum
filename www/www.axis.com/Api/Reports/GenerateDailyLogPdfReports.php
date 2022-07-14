<?php
$RN_jsonEC['data'] = null;
$RN_jsonEC['message'] = null;
$RN_jsonEC['status'] = 200;
require_once('../modules-jobsite-daily-logs-functions.php');
try {
	$jobsiteDailyLog = JobsiteDailyLog::findByProjectIdAndJobsiteDailyLogCreatedDate($database, $RN_project_id, $RN_reportsStartDate);
	
	/* @var $jobsiteDailyLog JobsiteDailyLog */
	if ($jobsiteDailyLog) {
		$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
		$created_by_contact_id = $jobsiteDailyLog->created_by_contact_id;

		$jobsiteDailyLog = JobsiteDailyLog::findJobsiteDailyLogByIdExtended($database, $jobsite_daily_log_id);

		$PDFOrHTML = true;
		$apiTimer = false;
		// $fileManagerFile = generateDailyConstructionReport($database, $jobsiteDailyLog, true);

		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */

		$jobsite_daily_log_id = $jobsiteDailyLog->jobsite_daily_log_id;
		$project_id = $jobsiteDailyLog->project_id;
		$modified_by_contact_id = $jobsiteDailyLog->modified_by_contact_id;
		$created_by_contact_id = $jobsiteDailyLog->created_by_contact_id;
		$jobsite_daily_log_created_date = $jobsiteDailyLog->jobsite_daily_log_created_date;

		$project = $jobsiteDailyLog->getProject();
		/* @var $project Project */

		$user_company_id = $project->user_company_id;
		$project_name = $project->project_name;

		// $project->htmlEntityEscapeProperties();
		$escaped_project_name = $project->escaped_project_name;

		$userCompany = $project->getUserCompany();
		/* @var $userCompany UserCompany */

		// $userCompany->htmlEntityEscapeProperties();
		$escaped_user_company_name = $userCompany->escaped_user_company_name;

		$jobsiteDailyLogModifiedByContact = $jobsiteDailyLog->getModifiedByContact();
		/* @var $jobsiteDailyLogModifiedByContact Contact */

		$jobsiteDailyLogCreatedByContact = $jobsiteDailyLog->getCreatedByContact();
		/* @var $jobsiteDailyLogModifiedByContact Contact */

		$header = $escaped_user_company_name . ' | Daily Construction Report';
	// @todo Have a footer that's different than the header?
		$footer = $header;

		$DCRPreviewSectionHtmlContent = buildDCRPreviewSection($database, $jobsiteDailyLog, $PDFOrHTML);

		$http = $uri->http;

	// <link rel="stylesheet" type="text/css" href="{$http}css/pdf-us-letter.css">
	// <div style="width: 612pt; height: 792pt;">

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
		$DCRPreviewSectionHtmlContent				
		</body>
		</html>
END_HTML_CONTENT;
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
			$pdfPhantomJS->setPdffooter($footer, null, 'DailyLog');
  			$pdfPhantomJS->setPdfPaperSize('11in', '11in');
		  	$pdfPhantomJS->setMargin('50px', '50px', '50px', '0px');

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

	} else {
		$RN_jsonEC['data'] = null;
		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['err_message'] = 'No contect available to generate pdf';
	}
} catch(Exception $e){
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = 'Something else. please try again';	
}
?>
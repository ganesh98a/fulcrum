<?php

$fileManagerFile = FileManagerFile::findById($database, $jobsiteFieldReport->jobsite_field_report_file_manager_file_id);
/* @var $fileManagerFile FileManagerFile */

$fileManagerFile->htmlEntityEscapeProperties();
$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
$fileUrl = $fileManagerFile->generateUrl();

$elementId = "record_container--manage-jobsite_field_report-record--jobsite_field_reports--$primaryKeyAsString";
$htmlRecordLi = <<<END_HTML_RECORD_LI

<li id="$elementId">
	<a href="javascript:deleteJobsiteFieldReport('$elementId', 'manage-jobsite_field_report-record', '$jobsite_field_report_id');" class="bs-tooltip  entypo-cancel-circled" data-original-title="Delete this attachment"></a>
	<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
</li>
END_HTML_RECORD_LI;

<?php

$fileManagerFile = FileManagerFile::findById($database, $jobsiteSignInSheet->jobsite_sign_in_sheet_file_manager_file_id);
/* @var $fileManagerFile FileManagerFile */

$fileManagerFile->htmlEntityEscapeProperties();
$escaped_virtual_file_name = $fileManagerFile->escaped_virtual_file_name;
$fileUrl = $fileManagerFile->generateUrl();

$elementId = "record_container--manage-jobsite_sign_in_sheet-record--jobsite_sign_in_sheets--$primaryKeyAsString";
$htmlRecordLi = <<<END_HTML_RECORD_LI

<li id="$elementId">
	<a href="javascript:deleteJobsiteSignInSheet('$elementId', 'manage-jobsite_sign_in_sheet-record', '$jobsite_sign_in_sheet_id');" class="bs-tooltip  entypo-cancel-circled " data-original-title="Delete this attachment"></a>
	<a href="$fileUrl" target="_blank">$escaped_virtual_file_name</a>
</li>
END_HTML_RECORD_LI;

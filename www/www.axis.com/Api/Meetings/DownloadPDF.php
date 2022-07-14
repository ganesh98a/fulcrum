<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');

$RN_jsonEC['data'] = null;
$RN_jsonEC['status'] = 200;
$RN_jsonEC['data']['MeetingData'] = null;
$RN_discussion_item_id = null;

if($RN_meeting_type_id == null || $RN_meeting_type_id == ''){
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Meeting Type Id is Required";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
if($RN_meeting_id == null || $RN_meeting_id == ''){
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Meeting Id is Required";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}

// Get Meeting Type.
$RN_arrMeetingTypes = MeetingType::findById($database, $RN_meeting_type_id);
if(isset($RN_arrMeetingTypes) && !empty($RN_arrMeetingTypes)){
	$RN_meeting_type = (string) $RN_arrMeetingTypes->meeting_type;	
}else{
	$RN_meeting_type = null;
	$RN_jsonEC['status'] = 400;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['err_message'] = "Something went wrong...";
	/*encode the array*/
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}

// DATABASE VARIABLES
$RN_db = DBI::getInstance($database);

// date_default_timezone_set('Asian/kolkata');
$RN_timezone = date_default_timezone_get();
$RN_dates = date('d-m-Y h', time());
$RN_i=date('i', time());
$RN_s=date('s a', time());
$RN_a=date('a', time());
$RN_timedate=date('d/m/Y h:i a', time());
// SESSSION VARIABLES
/* @var $RN_session Session */
$RN_userCompany = UserCompany::findById($database, $RN_currentlySelectedProjectUserCompanyId);
$RN_user_company_name = $RN_userCompany->user_company_name;
// require_once('module-report-ajax.php');
require_once('../module-report-meeting-functions.php');
/*RFI Functions*/
require_once('lib/common/RequestForInformationPriority.php');
require_once('lib/common/RequestForInformationRecipient.php');
require_once('lib/common/RequestForInformationResponse.php');
require_once('lib/common/RequestForInformationResponseType.php');
require_once('lib/common/RequestForInformationStatus.php');
require_once('lib/common/RequestForInformationType.php');
require_once('lib/common/RequestForInformation.php');
/*Submittal Functions*/
require_once('lib/common/Submittal.php');
require_once('lib/common/SubmittalDistributionMethod.php');
require_once('lib/common/SubmittalDraftAttachment.php');
require_once('lib/common/SubmittalPriority.php');
require_once('lib/common/SubmittalRecipient.php');
require_once('lib/common/SubmittalStatus.php');
require_once('lib/common/SubmittalType.php');
/*dompdf*/
require_once('../dompdf/dompdf_config.inc.php');

$RN_meetingData = meetingDataPreview($database, $RN_project_id, '', $RN_meeting_id, $RN_currentlySelectedProjectName, '');
$RN_htmlContent = $RN_meetingData;
/*html content with header*/
$RN_htmlContentWHeader = meetingDataPreviewWithHeader($database, $RN_user_company_id, $RN_project_name, '', $RN_htmlContent, true);
// Save the file_manager_folders record (virtual_file_path) to the db and get the id
// $RN_virtual_file_path = '/Meetings/Meeting #' . $RN_meeting_id . '/';
$RN_virtual_file_path = '/Meetings/'. $RN_meeting_type . '/';			
$RN_arrFolders = preg_split('#/#', $RN_virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
$RN_currentVirtualFilePath = '/';
foreach ($RN_arrFolders as $RN_folder) {
	$RN_tmpVirtualFilePath = array_shift($RN_arrFolders);
	$RN_currentVirtualFilePath .= $RN_tmpVirtualFilePath.'/';
	// Save the file_manager_folders record (virtual_file_path) to the db and get the id
	$RN_fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_currentVirtualFilePath);
}
/* @var $RN_fileManagerFolder FileManagerFolder */

// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
$RN_file_manager_folder_id = $RN_fileManagerFolder->file_manager_folder_id;
// Copy all pdf files to the server's local disk
$RN_config = Zend_Registry::get('config');
$RN_file_manager_front_end_node_file_copy_protocol = $RN_config->system->file_manager_front_end_node_file_copy_protocol;
$RN_baseDirectory = $RN_config->system->base_directory;
$RN_fileManagerBasePath = $RN_config->system->file_manager_base_path;
$RN_fileManagerFileNamePrefix = $RN_config->system->file_manager_file_name_prefix;
$RN_basePath = $RN_fileManagerBasePath.'frontend/'.$RN_user_company_id;
$RN_compressToDir = $RN_fileManagerBasePath.'temp/'.$RN_user_company_id.'/'.$RN_project_id.'/';
$RN_urlDirectory = 'downloads/'.'temp/'.$RN_user_company_id.'/'.$RN_project_id.'/';
$RN_outputDirectory = $RN_baseDirectory.'www/www.axis.com/'.$RN_urlDirectory;

$RN_tempFileName = File::getTempFileName();
$RN_tempDir = $RN_fileManagerBasePath.'temp/'.$RN_tempFileName.'/';
$RN_fileObject = new File();
$RN_fileObject->mkdir($RN_tempDir, 0777);
// Build the HTML for the RFI pdf document (html to pdf via DOMPDF)
$RN_htmlContent = html_entity_decode($RN_htmlContentWHeader);
$RN_htmlContent = mb_convert_encoding($RN_htmlContent, "HTML-ENTITIES", "UTF-8");
// Write RFI to temp folder as a pdf document
$RN_dompdf = new DOMPDF();
$RN_dompdf->load_html($RN_htmlContent);
$RN_dompdf->set_paper("letter", "landscape");
// $RN_dompdf->set_paper('A3','landscape');
$RN_dompdf->render();
$RN_canvas = $RN_dompdf->get_canvas();
$RN_font = Font_Metrics::get_font("helvetica", "6");
$RN_canvas->page_text(1000, 805, "Page {PAGE_NUM} of {PAGE_COUNT}", $RN_font, 8, array(.66,.66,.66));
// $RN_canvas->page_text(270, 550, "33302 VALLE ROAD, SUITE 125 | SAN JUAN CAPISTRANO, CA 92675", $RN_font, 8, array(0,0,0) );
// $RN_canvas->page_text(250, 565, "949.582.2044 | (F)949.582.2041 | WWW.ADVENTCOMPANIES.COM | LIC# 922928", $RN_font, 8, array(0,0,0) );
$RN_canvas->page_text(35, 805, "Printed : ".$RN_timedate, $RN_font, 8, array(.66,.66,.66));
$RN_pdf_content = $RN_dompdf->output();

// Filename of temporary rfi pdf file
// pdf file gets 1 in the list
$RN_tempPdfFile = '00001' . '.' . $RN_tempFileName . '.pdf';
$RN_tempFilePath = $RN_tempDir . $RN_tempPdfFile;
file_put_contents ($RN_tempFilePath, $RN_pdf_content);

$RN_sha1 = sha1_file($RN_tempFilePath);
$RN_size = filesize($RN_tempFilePath);
$RN_fileExtension = 'pdf';
$RN_virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($RN_fileExtension);
/*Meeting info*/
$RN_meeting = Meeting::findMeetingByIdExtended($database, $RN_meeting_id);
$RN_created = $RN_meeting->created;
$RN_meeting_sequence_number = $RN_meeting->meeting_sequence_number;
// $RN_created = DateTime::createFromFormat('Y-m-d H:i:s', $RN_created);
// $RN_createdDate = $RN_created->format('m-d-Y');
// Final RFI pdf document
$RN_virtual_file_name_tmp = 'Meeting '.$RN_meeting_sequence_number.'.pdf';
$RN_tmpFileManagerFile = new FileManagerFile($database);
$RN_tmpFileManagerFile->virtual_file_name = $RN_virtual_file_name_tmp;
$RN_virtual_file_name = $RN_tmpFileManagerFile->getFilteredVirtualFileName();
// Convert file content to File object
$RN_error = null;

$RN_file = new File();
$RN_file->sha1 = $RN_sha1;
$RN_file->name = $RN_virtual_file_name;
$RN_file->size = $RN_size;
$RN_file->type = $RN_virtual_file_mime_type;
$RN_file->tempFilePath = $RN_tempFilePath;
$RN_file->fileExtension = $RN_fileExtension;
$RN_file_location_id = FileManager::saveUploadedFileToCloud($database, $RN_file, false);
// save the file information to the file_manager_files db table
$RN_fileManagerFile = FileManagerFile::findByVirtualFileName($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_file_manager_folder_id, $RN_file_location_id, $RN_virtual_file_name, $RN_virtual_file_mime_type);
/* @var $RN_fileManagerFile FileManagerFile */

$RN_file_manager_file_id = $RN_fileManagerFile->file_manager_file_id;

// Potentially update file_location_id
if ($RN_file_location_id <> $RN_fileManagerFile->file_location_id) {
	$RN_fileManagerFile->file_location_id = $RN_file_location_id;
	$RN_data = array('file_location_id' => $RN_file_location_id);
	$RN_fileManagerFile->setData($RN_data);
	$RN_fileManagerFile->save();
}

// Set Permissions of the file to match the parent folder.
$RN_parent_file_manager_folder_id = $RN_fileManagerFolder->getParentFolderId();
FileManagerFolder::setPermissionsToMatchParentFolder($database, $RN_file_manager_folder_id, $RN_parent_file_manager_folder_id);
FileManagerFile::setPermissionsToMatchParentFolder($database, $RN_file_manager_file_id, $RN_file_manager_folder_id);
// Delete temp files
$RN_fileObject->rrmdir($RN_tempDir);

// Load PDF files list
//$RN_arrBidSpreadPdfFilenames =

// $RN_virtual_file_name_url = $RN_uri->cdn . '_' . $RN_file_manager_file_id;
// $RN_virtual_file_name_url_encoded = urlencode($RN_virtual_file_name_url);
// Debug
$RN_primaryKeyAsString = $RN_meeting_id;

// Output standard formatted error or success message
if (isset($RN_primaryKeyAsString) && (!empty($RN_primaryKeyAsString))) {
	// Success
	$RN_meetinPdfUrl = $RN_fileManagerFile->generateUrl(true);

	$RN_id = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';

	$RN_explodeValue = explode('?', $RN_meetinPdfUrl);
	if(isset($RN_explodeValue[1])){
		$RN_id = '&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
	}
	$RN_meetinPdfUrl = $RN_meetinPdfUrl.$RN_id;

	$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_file_manager_file_id);
	$accessFiles = false;
	if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
		if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
			$accessFiles = false;
		} else {
			$accessFiles = true;
		}
	}
	$tmpFile = array();
	$tmpFile['file']['file_url'] = $RN_meetinPdfUrl;
	$tmpFile['file']['file_access'] = $accessFiles;
	$RN_jsonEC['data']['MeetingData'] = $tmpFile;
} else {
	// Error code here
	$RN_errorNumber = 1;
	$RN_errorMessage = 'Error rendering:'.$RN_meeting_type. $RN_meeting_sequence_number .' PDF.';
	
	$RN_jsonEC['data']['err_message'] = $RN_errorMessage;
	//$RN_error->outputErrorMessages();
	//exit;
}

?>

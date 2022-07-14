<?php
// Temp files
$RN_arrTempFiles = array();

$RN_punch_item_id = intVal($RN_punch_item_id);

$RN_punchItem = PunchItem::findById($database, $RN_punch_item_id);
$RN_project_id = $RN_punchItem->project_id;
/* @var $RN_punchItem */
if ($RN_punchItem->recipient_contact_company_id) {
	$RN_piRecipientContactCompanyId = $RN_punchItem->recipient_contact_company_id;
	$RN_piRecipientContactCompany = ContactCompany::findById($database, $RN_piRecipientContactCompanyId);
	// contact company name
	$RN_piRecipientContactCompanyName = $RN_piRecipientContactCompany->contact_company_name;
} else {
	$RN_piRecipientContactCompanyName = '';
}
// PunchItem Attachments
// The PunchItem document is the PunchItem pdf with all attachment appended into it.
$RN_loadPunchItemAttachmentsByPunchItemIdOptions = new Input();
$RN_loadPunchItemAttachmentsByPunchItemIdOptions->forceLoadFlag = true;

$RN_arrPunchItemAttachmentsByPunchItemId = PunchItemAttachment::loadPunchItemAttachmentsByPunchItemId($database, $RN_punch_item_id, $RN_loadPunchItemAttachmentsByPunchItemIdOptions,'1');

// Folder
// Save the file_manager_folders record (virtual_file_path) to the db and get the id
$RN_virtual_file_path = '/Punch Lists/'.$RN_piRecipientContactCompanyName.'/Punch List #' . $RN_punchItem->sequence_number . '/';
//To get the project Company Id
$RN_db = DBI::getInstance($database);
$RN_query ="SELECT * FROM `projects` WHERE `id` = '$RN_project_id' ORDER BY `id` DESC ";
$RN_db->execute($RN_query);
$RN_row=$RN_db->fetch();

$RN_main_company=$RN_row['user_company_id'];
$RN_db->free_result();

			// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
$RN_arrFolders = preg_split('#/#', $RN_virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
$RN_currentVirtualFilePath = '/';
foreach ($RN_arrFolders as $RN_folder) {
	$RN_tmpVirtualFilePath = array_shift($RN_arrFolders);
	$RN_currentVirtualFilePath .= $RN_tmpVirtualFilePath.'/';
				// Save the file_manager_folders record (virtual_file_path) to the db and get the id
	$RN_fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $RN_main_company, $RN_currentlyActiveContactId, $RN_project_id, $RN_currentVirtualFilePath);
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

// Copy over the Submittal Attachment files
// Start with offset 2 to save 1 for the Submittal pdf itself
$RN_counter = 2;
$RN_skipOne = false;
$RN_arrPdfFiles = array();
$RN_pdfPageCount = 0;
$RN_arrPiAttachmentFileLocationIds = array();
$RN_arrImageFiles = array();
foreach ($RN_arrPunchItemAttachmentsByPunchItemId as $RN_punchItemAttachment) {
	/* @var $RN_punchItemAttachment PunchItemAttachment */

	// Debug
	//continue;

	// Start with offset 2 to save 1 for the cover sheet
	if ($RN_skipOne) {
		$RN_skipOne = false;
		continue;
	}
	$RN_piAttachmentFileManagerFile = $RN_punchItemAttachment->getPiAttachmentFileManagerFile();
	/* @var $RN_piAttachmentFileManagerFile FileManagerFile */

	// Move the file to the Submittal # subfolder
	$RN_oldData = $RN_piAttachmentFileManagerFile->getData();
	$RN_data = array(
		'file_manager_folder_id' => $RN_file_manager_folder_id
	);
	$RN_piAttachmentFileManagerFile->setData($RN_data);
	$RN_piAttachmentFileManagerFile->save();
	$RN_oldData['file_manager_folder_id'] = $RN_file_manager_folder_id;
	$RN_piAttachmentFileManagerFile->setData($RN_oldData);
	$RN_piAttachmentFileManagerFile->file_manager_folder_id = $RN_file_manager_folder_id;

	// Filename extension
	$RN_tempSuAttachmentFileExtension = $RN_piAttachmentFileManagerFile->getFileExtension();
	$RN_tempSuAttachmentFileExtension = strtolower($RN_tempSuAttachmentFileExtension);
// echo $RN_piAttachmentFileManagerFile->getArrFileManagerFilesByVirtualFileMimeType();
	// Skip all but pdf for now
	if ($RN_tempSuAttachmentFileExtension <> 'pdf') {
		// if ($RN_tempSuAttachmentFileExtension <> 'image') {
			$RN_arrImageFiles[$RN_piAttachmentFileManagerFile->file_manager_file_id] = $RN_oldData;
		// }
		continue;
	}

	$RN_fileNamePrefix = str_pad($RN_counter, 5, '0', STR_PAD_LEFT);
	$RN_tempSuAttachmentFileName = $RN_fileNamePrefix . '.' . $RN_piAttachmentFileManagerFile->file_manager_file_id . '.' . $RN_tempSuAttachmentFileExtension;
	$RN_tempFilePath = $RN_tempDir.$RN_tempSuAttachmentFileName;

	// @todo Add png / image to pdf functionality
	$RN_tempPdfFile = $RN_tempSuAttachmentFileName;

	// Copy the file from the backend to the physical temp folder
	//@todo Remove the portion of the $RN_virtual_file_path that is the starting relative directory
	$RN_file_location_id = $RN_piAttachmentFileManagerFile->file_location_id;
	$RN_arrPiAttachmentFileLocationIds[] = $RN_file_location_id;
	$RN_statusFlag = false;
	if (isset($RN_file_location_id) && !empty($RN_file_location_id)) {
		if ($RN_file_manager_front_end_node_file_copy_protocol == 'FTP') {
			$RN_statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($RN_piAttachmentFileManagerFile, $RN_tempFilePath, $RN_file_location_id);
		} elseif ($RN_file_manager_front_end_node_file_copy_protocol == 'LocalFileSystem') {
			$RN_statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($RN_piAttachmentFileManagerFile, $RN_tempFilePath, $RN_file_location_id);
		}
	}
	FileManagerFile::restoreFromTrash($database,$RN_piAttachmentFileManagerFile->file_manager_file_id);
	if ($RN_statusFlag) {
		$RN_arrPdfFiles[] = $RN_tempPdfFile;

					// Track page count
		$RN_arrPdfMetadata = Pdf::getPdfMetadata($RN_tempDir, $RN_tempPdfFile);
		if (isset($RN_arrPdfMetadata['page_count'])) {
			$RN_page_count = $RN_arrPdfMetadata['page_count'];
			$RN_pdfPageCount += $RN_page_count;
		}
	}

	$RN_counter++;
}
// print_r($RN_arrPdfFiles);
// Build the HTML for the Submittal pdf document (html to pdf via DOMPDF)
$RN_htmlContent = buildPiAsHtmlForPdfConversion($database, $RN_main_company, $RN_punch_item_id,$RN_currentlyActiveContactId,$RN_user_company_id, $RN_arrImageFiles);
$RN_htmlContent = html_entity_decode($RN_htmlContent);
$RN_htmlContent = mb_convert_encoding($RN_htmlContent, "HTML-ENTITIES", "UTF-8");

// Take the sha1 of the Punch Item pdf with the attachments appended

// Write Submittal to temp folder as a pdf document
/*$RN_dompdf = new DOMPDF();
$RN_dompdf->load_html($RN_htmlContent);
//$RN_dompdf->set_paper("letter", "landscape");
$RN_dompdf->set_paper("letter", "portrait");
$RN_dompdf->render();
$RN_pdf_content = $RN_dompdf->output();*/

	

// Filename of temporary su pdf file
// su pdf file gets 1 in the list
$RN_tempPdfFile = '00001' . '.' . $RN_tempFileName . '.pdf';
$RN_tempFilePath = $RN_tempDir . $RN_tempPdfFile;

// Debug
// copy the file to a temp file just like a standard file upload
if (!isset($RN_tempFilePath) || empty($RN_tempFilePath)) {
	$RN_tempFilePath = 'C:/dev/build/advent-sites/branches/development/www/www.axis.com/downloads/temp/su.pdf';
}
	$pdfPhantomJS = new PdfPhantomJS();
  	// $pdfPhantomJS->setPdffooter($footer);
  	$pdfPhantomJS->setPdfPaperSize('8.5in', '11in');
	$pdfPhantomJS->writeTempFileContentsToDisk($RN_htmlContent);
	// generate url with query_string for phontomJS to read the file with contents from $htmlOutput
	$pdfTempFileUrl = $pdfPhantomJS->getTempFileUrl();
	$pdfPhantomJS->setTempFileUrl($pdfTempFileUrl);
	$htmlTempFileBasePath = $pdfPhantomJS->getTempFileBasePath();
	$htmlTempFileSha1 = $pdfPhantomJS->getTempFileSha1();	
	$pdfPhantomJS->setCompletePdfFilePath($RN_tempFilePath);
	$result = $pdfPhantomJS->execute();
	// delete the html temp file
	$pdfPhantomJS->deleteTempFile();
// file_put_contents ($RN_tempFilePath, $RN_pdf_content);

if (!empty($RN_arrPdfFiles)) {

	// Put the cover sheet first in the list
	array_unshift($RN_arrPdfFiles, $RN_tempPdfFile);

	$RN_finalSuTempFileName = $RN_tempFileName . '.pdf';
	$RN_finalSuTempFilepath = $RN_tempDir.$RN_finalSuTempFileName;

	// Merge the PunchItem pdf and all PunchItem attachments into a single PunchItem pdf document
	Pdf::merge($RN_arrPdfFiles, $RN_tempDir, $RN_finalSuTempFileName);

	$RN_tempFilePath = $RN_finalSuTempFilepath;

}

$RN_sha1 = sha1_file($RN_tempFilePath);
$RN_size = filesize($RN_tempFilePath);
$RN_fileExtension = 'pdf';
$RN_virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($RN_fileExtension);

// Final Submittal pdf document
$RN_virtual_file_name_tmp = 'Punch List #' . $RN_punchItem->sequence_number . '.pdf';
$RN_tmpFileManagerFile = new FileManagerFile($database);
$RN_tmpFileManagerFile->virtual_file_name = $RN_virtual_file_name_tmp;
$RN_virtual_file_name = $RN_tmpFileManagerFile->getFilteredVirtualFileName();

// Convert file content to File object
$RN_error = null;

$RN_file = new File();
$RN_file->sha1 = $RN_sha1;
//$RN_file->form_input_name = $RN_formFileInputName;
//$RN_file->error = $RN_error;
$RN_file->name = $RN_virtual_file_name;
$RN_file->size = $RN_size;
//$RN_file->tmp_name = $RN_tmp_name;
$RN_file->type = $RN_virtual_file_mime_type;
$RN_file->tempFilePath = $RN_tempFilePath;
$RN_file->fileExtension = $RN_fileExtension;

//$RN_arrFiles = File::parseUploadedFiles();
$RN_file_location_id = FileManager::saveUploadedFileToCloud($database, $RN_file, false);

// save the file information to the file_manager_files db table
$RN_fileManagerFile = FileManagerFile::findByVirtualFileName($database, $RN_main_company, $RN_currentlyActiveContactId, $RN_project_id, $RN_file_manager_folder_id, $RN_file_location_id, $RN_virtual_file_name, $RN_virtual_file_mime_type);
/* @var $RN_fileManagerFile FileManagerFile */

$RN_file_manager_file_id = $RN_fileManagerFile->file_manager_file_id;

FileManagerFile::restoreFromTrash($database,$RN_file_manager_file_id);
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

// Update $RN_punchItem->su_file_manager_file_id
$RN_tmpData = $RN_punchItem->getData();
$RN_data = array(
	'file_manager_file_id' => $RN_file_manager_file_id
);
$RN_punchItem->setData($RN_data);
$RN_punchItem->save();
$RN_tmpData['file_manager_file_id'] = $RN_file_manager_file_id;
$RN_punchItem->setData($RN_tmpData);
$RN_punchItem->su_file_manager_file_id = $RN_file_manager_file_id;

// Delete temp files
$RN_fileObject->rrmdir($RN_tempDir);

// Debug
$RN_primaryKeyAsString = $RN_punch_item_id;

// Output standard formatted error or success message
if (isset($RN_primaryKeyAsString) && (!empty($RN_primaryKeyAsString))) {
	// Success
	$RN_errorNumber = 0;
	$RN_errorMessage = '';
} else {
	// Error code here
	$RN_errorNumber = 1;
	$RN_errorMessage = 'Error creating: Punch List.';
	//$RN_error->outputErrorMessages();
	//exit;
}

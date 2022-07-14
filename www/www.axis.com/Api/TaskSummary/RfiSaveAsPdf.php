<?php
include_once('Service/RN_ImageService.php');
try {
	$request_for_information_id = $RN_action_item_id;
	$updatedRfi = 'yes';
	$requestForInformation = RequestForInformation::findById($database, $request_for_information_id);

	// RFI Attachments
	// The RFI document is the RFI pdf with all attachment appended into it.
	$loadRequestForInformationAttachmentsByRequestForInformationIdOptions = new Input();
	$loadRequestForInformationAttachmentsByRequestForInformationIdOptions->forceLoadFlag = true;
	$arrRequestForInformationAttachmentsByRequestForInformationId = RequestForInformationAttachment::loadRequestForInformationAttachmentsByRequestForInformationId($database, $request_for_information_id, $loadRequestForInformationAttachmentsByRequestForInformationIdOptions,'1');
	// get propject details
	$RN_project = Project::findById($database, $RN_project_id);
	$RN_user_company_id = $RN_project->user_company_id;

	$virtual_file_path = '/RFIs/RFI #' . $requestForInformation->rfi_sequence_number . '/';
	// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
	$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
	$currentVirtualFilePath = '/';
	foreach ($arrFolders as $folder) {
		$tmpVirtualFilePath = array_shift($arrFolders);
		$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
		// Save the file_manager_folders record (virtual_file_path) to the db and get the id
		$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $currentVirtualFilePath);
	}
	// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
	$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

	// Copy all pdf files to the server's local disk
	$config = Zend_Registry::get('config');
	$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
	$baseDirectory = $config->system->base_directory;
	$fileManagerBasePath = $config->system->file_manager_base_path;
	$fileManagerFileNamePrefix = $config->system->file_manager_file_name_prefix;
	$basePath = $fileManagerBasePath.'frontend/'.$RN_user_company_id;
	$compressToDir = $fileManagerBasePath.'temp/'.$RN_user_company_id.'/'.$RN_project_id.'/';
	$urlDirectory = 'downloads/'.'temp/'.$RN_user_company_id.'/'.$RN_project_id.'/';
	$outputDirectory = $baseDirectory.'www/www.axis.com/'.$urlDirectory;

	$tempFileName = File::getTempFileName();
	$tempDir = $fileManagerBasePath.'temp/'.$tempFileName.'/';
	$fileObject = new File();
	$fileObject->mkdir($tempDir, 0777);
	// Copy over the RFI Attachment files
	$pthotoAddFormatArray = array('0'=>'jpg','1'=>'jpeg','2'=>'png','3'=>'gif');
	$photoAddPdf = array();
    $indexVal=0;
	// Start with offset 2 to save 1 for the RFI pdf itself
	$counter = 2;
	$skipOne = false;
	$arrPdfFiles = array();
	$pdfPageCount = 0;
	$arrRfiAttachmentFileLocationIds = array();
	foreach ($arrRequestForInformationAttachmentsByRequestForInformationId as $requestForInformationAttachment) {
		/* @var $requestForInformationAttachment RequestForInformationAttachment */

		$rfiAttachmentFileManagerFile = $requestForInformationAttachment->getRfiAttachmentFileManagerFile();
		/* @var $rfiAttachmentFileManagerFile FileManagerFile */

		// Move the file to the RFI # subfolder
		$oldData = $rfiAttachmentFileManagerFile->getData();
		$data = array(
			'file_manager_folder_id' => $file_manager_folder_id
		);
		$rfiAttachmentFileManagerFile->setData($data);
		$rfiAttachmentFileManagerFile->save();
		$oldData['file_manager_folder_id'] = $file_manager_folder_id;
		$rfiAttachmentFileManagerFile->setData($oldData);
		$rfiAttachmentFileManagerFile->file_manager_folder_id = $file_manager_folder_id;

		// Filename extension
		$tempRfiAttachmentFileExtension = $rfiAttachmentFileManagerFile->getFileExtension();
		$tempRfiAttachmentFileExtension=strtolower($tempRfiAttachmentFileExtension);

		// Skip all but pdf for now
		// if ($tempRfiAttachmentFileExtension <> 'pdf') {
			// continue;
		// }

		$fileNamePrefix = str_pad($counter, 5, '0', STR_PAD_LEFT);
		$tempRfiAttachmentFileName = $fileNamePrefix . '.' . $rfiAttachmentFileManagerFile->file_manager_file_id . '.' . $tempRfiAttachmentFileExtension;
		$tempFilePath = $tempDir.$tempRfiAttachmentFileName;

		// @todo Add png / image to pdf functionality
		$tempPdfFile = $tempRfiAttachmentFileName;

		// Copy the file from the backend to the physical temp folder
		//@todo Remove the portion of the $virtual_file_path that is the starting relative directory
		FileManagerFile::restoreFromTrash($database,$rfiAttachmentFileManagerFile->file_manager_file_id);
		$file_location_id = $rfiAttachmentFileManagerFile->file_location_id;
		$arrRfiAttachmentFileLocationIds[] = $file_location_id;
		$statusFlag = false;
		if (isset($file_location_id) && !empty($file_location_id)) {
			if ($file_manager_front_end_node_file_copy_protocol == 'FTP') {
				$statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($rfiAttachmentFileManagerFile, $tempFilePath, $file_location_id);
			} elseif ($file_manager_front_end_node_file_copy_protocol == 'LocalFileSystem') {
				$statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($rfiAttachmentFileManagerFile, $tempFilePath, $file_location_id);
			}
		}

		if ($statusFlag) {
			$arrPdfFiles[] = $tempPdfFile;
			// Track page count
			$arrPdfMetadata = Pdf::getPdfMetadata($tempDir, $tempPdfFile);
			if (isset($arrPdfMetadata['page_count'])) {
				$page_count = $arrPdfMetadata['page_count'];
				$pdfPageCount += $page_count;
			}
		}
		// RFI image Attachment
		if(in_array($tempRfiAttachmentFileExtension,$pthotoAddFormatArray))
		{
			$photoAddPdf[$indexVal]['file_manager_file_id'] = $rfiAttachmentFileManagerFile->file_manager_file_id;
			$photoAddPdf[$indexVal]['virtual_file_name'] = $rfiAttachmentFileManagerFile->virtual_file_name;
			$indexVal++;
		}
		$counter++;
	}
	//To get the list of photos to be attached to the PDF
	$photoContents = ImageAttachmentToPDF($database,$photoAddPdf,$urlDirectory,$outputDirectory);
	// Build the HTML for the RFI pdf document (html to pdf via DOMPDF)
	$htmlContent = buildRfiAsHtmlForPdfConversion($database, $RN_user_company_id, $request_for_information_id, $RN_currentlyActiveContactId, $updatedRfi,$RN_user_company_id, $photoContents);
	$htmlContent = html_entity_decode($htmlContent);
	$htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
	// Write RFI to temp folder as a pdf document
	$dompdf = new DOMPDF();
	$dompdf->load_html($htmlContent);
	//$dompdf->set_paper("letter", "landscape");
	$dompdf->set_paper("letter", "portrait");
	$dompdf->render();
	$pdf_content = $dompdf->output();

	// Filename of temporary rfi pdf file
	// rfi pdf file gets 1 in the list
	$tempPdfFile = '_temp'.round(microtime(true)*1000). '.' . $tempFileName . '.pdf';
	$tempFilePath = $tempDir . $tempPdfFile;

	// Debug
	// copy the file to a temp file just like a standard file upload
	if (!isset($tempFilePath) || empty($tempFilePath)) {
		$tempFilePath = 'C:/dev/build/advent-sites/branches/development/www/www.axis.com/downloads/temp/rfi.pdf';
	}
	//$tempFileName = File::getTempFileName();
	//$tempFilePath = $tempDir.$tempFileName;
	file_put_contents ($tempFilePath, $pdf_content);
	if (!empty($arrPdfFiles)) {
		// Put the cover sheet first in the list
		array_unshift($arrPdfFiles, $tempPdfFile);
		$finalRfiTempFileName = $tempFileName . '.pdf';
		$finalRfiTempFilepath = $tempDir.$finalRfiTempFileName;
		// Merge the RFI pdf and all RFI attachments into a single RFI pdf document
		Pdf::merge($arrPdfFiles, $tempDir, $finalRfiTempFileName);
		$tempFilePath = $finalRfiTempFilepath;
	}
	$sha1 = sha1_file($tempFilePath);
	$size = filesize($tempFilePath);
	$fileExtension = 'pdf';
	$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

	// Final RFI pdf document
	$virtual_file_name_tmp = 'RFI #' . $requestForInformation->rfi_sequence_number . ' - ' . $requestForInformation->rfi_title . '.pdf';
	$tmpFileManagerFile = new FileManagerFile($database);
	$tmpFileManagerFile->virtual_file_name = $virtual_file_name_tmp;
	$virtual_file_name = $tmpFileManagerFile->getFilteredVirtualFileName();

	// Convert file content to File object
	$error = null;

	$file = new File();
	$file->sha1 = $sha1;
	//$file->form_input_name = $formFileInputName;
	//$file->error = $error;
	$file->name = $virtual_file_name;
	$file->size = $size;
	//$file->tmp_name = $tmp_name;
	$file->type = $virtual_file_mime_type;
	$file->tempFilePath = $tempFilePath;
	$file->fileExtension = $fileExtension;

	//$arrFiles = File::parseUploadedFiles();
	$file_location_id = FileManager::saveUploadedFileToCloud($database, $file, false);

	// Rename file...for replace case???
	//$virtual_file_name = $file_type_name . " - Old (Uploaded " .$previous_date_added. ").pdf";

	// save the file information to the file_manager_files db table
	$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
	/* @var $fileManagerFile FileManagerFile */

	$file_manager_file_id = $fileManagerFile->file_manager_file_id;

	FileManagerFile::restoreFromTrash($database,$file_manager_file_id);
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
	

	/*// Set Permissions of the file to match the parent folder.
	FileManagerFile::setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id);*/

	// Update $requestForInformation->rfi_file_manager_file_id
	$tmpData = $requestForInformation->getData();
	$data = array(
		'rfi_file_manager_file_id' => $file_manager_file_id
	);
	$requestForInformation->setData($data);
	$requestForInformation->save();
	$tmpData['rfi_file_manager_file_id'] = $file_manager_file_id;
	$requestForInformation->setData($tmpData);
	$requestForInformation->rfi_file_manager_file_id = $file_manager_file_id;
	// Delete temp files
	$fileObject->rrmdir($tempDir);

	// Load PDF files list
	//$arrBidSpreadPdfFilenames =

	$virtual_file_name_url = $uri->cdn . '_' . $file_manager_file_id;
	$virtual_file_name_url_encoded = urlencode($virtual_file_name_url);

	// Debug
	$primaryKeyAsString = $request_for_information_id;
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}

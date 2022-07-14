<?php
try {
	$submittal_id = $RN_action_item_id;
	$updatedsubmittal = 'yes';
	$submittal = Submittal::findById($database, $submittal_id);
	// attachments
	$loadSubmittalAttachmentsBySubmittalIdOptions = new Input();
	$loadSubmittalAttachmentsBySubmittalIdOptions->forceLoadFlag = true;
	$arrSubmittalAttachmentsBySubmittalId = SubmittalAttachment::loadSubmittalAttachmentsBySubmittalId($database, $submittal_id, $loadSubmittalAttachmentsBySubmittalIdOptions,'1');
	// get propject details
	$RN_project = Project::findById($database, $RN_project_id);
	$RN_user_company_id = $RN_project->user_company_id;
	// Save the file_manager_folders record (virtual_file_path) to the db and get the id
	$virtual_file_path = '/Submittals/Submittal #' . $submittal->su_sequence_number . '/';
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

	// Copy over the Submittal Attachment files
	// Start with offset 2 to save 1 for the Submittal pdf itself
	$counter = 2;
	$skipOne = false;
	$arrPdfFiles = array();
	$pdfPageCount = 0;
	$arrSuAttachmentFileLocationIds = array();
	foreach ($arrSubmittalAttachmentsBySubmittalId as $submittalAttachment) {
		$suAttachmentFileManagerFile = $submittalAttachment->getSuAttachmentFileManagerFile();
		// Move the file to the Submittal # subfolder
		$oldData = $suAttachmentFileManagerFile->getData();
		$data = array(
			'file_manager_folder_id' => $file_manager_folder_id
		);
		$suAttachmentFileManagerFile->setData($data);
		$suAttachmentFileManagerFile->save();
		$oldData['file_manager_folder_id'] = $file_manager_folder_id;
		$suAttachmentFileManagerFile->setData($oldData);
		$suAttachmentFileManagerFile->file_manager_folder_id = $file_manager_folder_id;

		// Filename extension
		$tempSuAttachmentFileExtension = $suAttachmentFileManagerFile->getFileExtension();
		$tempSuAttachmentFileExtension = strtolower($tempSuAttachmentFileExtension);

		// Skip all but pdf for now
		if ($tempSuAttachmentFileExtension <> 'pdf') {
			continue;
		}

		$fileNamePrefix = str_pad($counter, 5, '0', STR_PAD_LEFT);
		$tempSuAttachmentFileName = $fileNamePrefix . '.' . $suAttachmentFileManagerFile->file_manager_file_id . '.' . $tempSuAttachmentFileExtension;
		$tempFilePath = $tempDir.$tempSuAttachmentFileName;

		// @todo Add png / image to pdf functionality
		$tempPdfFile = $tempSuAttachmentFileName;

		// Copy the file from the backend to the physical temp folder
		//@todo Remove the portion of the $virtual_file_path that is the starting relative directory
		FileManagerFile::restoreFromTrash($database, $suAttachmentFileManagerFile->file_manager_file_id);
		$file_location_id = $suAttachmentFileManagerFile->file_location_id;
		$arrSuAttachmentFileLocationIds[] = $file_location_id;
		$statusFlag = false;
		if (isset($file_location_id) && !empty($file_location_id)) {
			if ($file_manager_front_end_node_file_copy_protocol == 'FTP') {
				$statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($suAttachmentFileManagerFile, $tempFilePath, $file_location_id);
			} elseif ($file_manager_front_end_node_file_copy_protocol == 'LocalFileSystem') {
				$statusFlag = FileManager::copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($suAttachmentFileManagerFile, $tempFilePath, $file_location_id);
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
		$counter++;
	}
	// Build the HTML for the Submittal pdf document (html to pdf via DOMPDF)
	$htmlContent = buildSuAsHtmlForPdfConversion($database, $RN_user_company_id, $submittal_id,$RN_currentlyActiveContactId,$updatedsubmittal,$RN_user_company_id);
	$htmlContent = html_entity_decode($htmlContent);
	$htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");

	$dompdf = new DOMPDF();
	$dompdf->load_html($htmlContent);
	//$dompdf->set_paper("letter", "landscape");
	$dompdf->set_paper("letter", "portrait");
	$dompdf->render();
	$pdf_content = $dompdf->output();

	// Filename of temporary su pdf file
	// su pdf file gets 1 in the list
	$tempPdfFile = '00001' . '.' . $tempFileName . '.pdf';
	$tempFilePath = $tempDir . $tempPdfFile;

	file_put_contents ($tempFilePath, $pdf_content);
	if (!empty($arrPdfFiles)) {
		// Put the cover sheet first in the list
		array_unshift($arrPdfFiles, $tempPdfFile);
		$finalSuTempFileName = $tempFileName . '.pdf';
		$finalSuTempFilepath = $tempDir.$finalSuTempFileName;
		// Merge the Submittal pdf and all Submittal attachments into a single Submittal pdf document
		Pdf::merge($arrPdfFiles, $tempDir, $finalSuTempFileName);
		$tempFilePath = $finalSuTempFilepath;
	}
	$sha1 = sha1_file($tempFilePath);
	$size = filesize($tempFilePath);
	$fileExtension = 'pdf';
	$virtual_file_mime_type = File::deriveMimeTypeFromFileExtension($fileExtension);

	// Final Submittal pdf document
	$virtual_file_name_tmp = 'Submittal #' . $submittal->su_sequence_number . ' - ' . $submittal->su_title . '.pdf';
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
	

	// Update $submittal->su_file_manager_file_id
	$tmpData = $submittal->getData();
	$data = array(
		'su_file_manager_file_id' => $file_manager_file_id
	);
	$submittal->setData($data);
	$submittal->save();
	$tmpData['su_file_manager_file_id'] = $file_manager_file_id;
	$submittal->setData($tmpData);
	$submittal->su_file_manager_file_id = $file_manager_file_id;

	$fileObject->rrmdir($tempDir);
	// Load PDF files list
	//$arrBidSpreadPdfFilenames =

	$virtual_file_name_url = $uri->cdn . '_' . $file_manager_file_id;
	$virtual_file_name_url_encoded = urlencode($virtual_file_name_url);
	// Debug
	$primaryKeyAsString = $submittal_id;
} catch(Exception $e) {
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['error'] = $e;
	$RN_jsonEC['err_message'] = 'Something else. please try again';
}

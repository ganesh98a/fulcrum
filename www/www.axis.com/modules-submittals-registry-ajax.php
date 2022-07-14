<?php
try {

$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = true;
$init['geo'] = false;
$init['get_maxlength'] = 2048;
$init['get_required'] = true;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
//$init['post_required'] = true;
//$init['sapi'] = 'cli';
//$init['skip_always_include'] = true;
//$init['skip_session'] = true;
//$init['skip_templating'] = true;
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');
$timer->startTimer();
$_SESSION['timer'] = $timer;

// Method Call is our switch variable
if (isset($get)) {
	$methodCall = $get->method;
	if (empty($methodCall)) {
		echo '';
		exit;
	}
} else {
	echo '';
	exit;
}

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);

require_once('modules-submittals-registry-functions.php');
require_once('modules-submittals-functions.php');
require_once('lib/common/Module.php');
require_once('lib/common/Service/TableService.php');
require_once('lib/common/Tagging.php');
require_once('lib/common/SubmittalRegistry.php');



// SESSION VARIABLES
/* @var $session Session */
$project_id = $session->getCurrentlySelectedProjectId();
$project_name = $session->getCurrentlySelectedProjectName();
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();

$userCompany = UserCompany::findUserCompanyByUserCompanyId($database, $user_company_id);
/* @var $userCompany UserCompany */
$userCompanyName = $userCompany->user_company_name;

$db = DBI::getInstance($database);

ob_start();

// C.R.U.D. Pattern

switch ($methodCall) {
	case 'Submittals__loadCreateSuDialog':

		$crudOperation = 'load';
		$errorNumber = 0;
		$errorMessage = '';
		$primaryKeyAsString = '';
		$htmlContent = '';

		try {

			// Ajax Handler Inputs
			require('code-generator/ajax-get-inputs.php');

			$submittal_draft_id = (int) $get->submittal_draft_id;
			$project_id = (int) $get->currentlySelectedProjectId;
			$user_company_id = (int) $get->user_company_id;
			$currentlyActiveContactId = (int) $get->currentlyActiveContactId;

			if ($submittal_draft_id) {
				$findSubmittalDraftByIdExtendedOptions = new Input();
				$findSubmittalDraftByIdExtendedOptions->forceLoadFlag = true;
				$submittalDraft = SubmittalRegistry::findById($database, $submittal_draft_id);
				$htmlContent = buildCreateSuReDialog($database, $user_company_id, $project_id, $currentlyActiveContactId, null, $submittalDraft);
			} else {
				$htmlContent = buildCreateSuReDialog($database, $user_company_id, $project_id, $currentlyActiveContactId);
			}

		} catch(Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error loading: Creation Form';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (!isset($primaryKeyAsString)) {
			$primaryKeyAsString = '';
			if (isset($submittalDraft) && $submittalDraft instanceof SubmittalDraft) {
				$primaryKeyAsString = $submittalDraft->getPrimaryKeyAsString();
			}
		}

		$jsonFlag = false;
		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		}

		if ($jsonFlag) {
			// Send HTTP Content-Type header to alert client of JSON output
			header('Content-Type: application/json');
		}
		echo $output;

	break;
	case 'DeleteSCO':

        $subRegId = (int) $get->subRegId;
        $db = DBI::getInstance($database);
        $query ="DELETE From `submittal_registry` where `id`=$subRegId";
        $db->execute($query);
        $db->free_result();
        echo "1";

    break;
    case 'gridViewChange':
	
	$viewState = (string) $get->viewState;
   	$filteropt = (string) $get->filteropt;
    	$checkpotential = (string) $get->checkpotential;
	$OrderTable= renderSubcontractChangeOrderListViewRegistry($project_id,$user_company_id,$currentlyActiveContactId,$viewState,null,$filteropt,$database,$checkpotential);
	echo $OrderTable;

	break;
	case 'updateSubmittalAttachements':

			$submittal_id=(int)$get->submittal_id;
			$attchmentId=(int)$get->attchmentId;
			$updateData=(string)$get->updateData;

	$db = DBI::getInstance($database);
	$query ="UPDATE `submittal_attachments` SET `is_added`='$updateData' WHERE submittal_id ='$submittal_id' and su_attachment_file_manager_file_id='$attchmentId'";
	$db->execute($query);
	echo "success";

	break;
	case 'updateAllSubmittalAttachements':

			$submittal_id=(int)$get->submittal_id;
			$updateData=(string)$get->updateData;

	$db = DBI::getInstance($database);
	echo $query ="UPDATE `submittal_attachments` SET `is_added`='$updateData' WHERE submittal_id ='$submittal_id'";
	$db->execute($query);
	echo "success";

	break;

	case 'Submittals__saveSuAsPdf':

		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Check permissions - manage
			/*
			$userCanManageSubmittals = $permissions->determineAccessToSoftwareModuleFunction('submittals_manage');
			if (!$userCanManageSubmittals) {
				// Error and exit
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Submittal data values.';
				$errorMessage = 'Error creating: Submittal.<br>Permission Denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
			*/

			// Temp files
			$arrGetData = $get->getData();
			$arrTempFiles = array();
			foreach ($arrGetData as $key => $value) {

				if (is_int(strpos($key, 'tempFileSha1'))) {

					$arrTmp = explode('_', $key);
					$tempFilePosition = $arrTmp[1];
					$tempFileSha1 = $value;
					$arrTempFiles[$tempFilePosition]['tempFileSha1'] = $tempFileSha1;

				} elseif (is_int(strpos($key, 'tempFilePath'))) {

					$arrTmp = explode('_', $key);
					$tempFilePosition = $arrTmp[1];
					$tempFilePath = $value;
					$arrTempFiles[$tempFilePosition]['tempFilePath'] = $tempFilePath;

				} elseif (is_int(strpos($key, 'tempFileName'))) {

					$arrTmp = explode('_', $key);
					$tempFilePosition = $arrTmp[1];
					$tempFileName = $value;
					$arrTempFiles[$tempFilePosition]['tempFileName'] = $tempFileName;

				} elseif (is_int(strpos($key, 'virtual_file_mime_type'))) {

					$arrTmp = explode('_', $key);
					$tempFilePosition = $arrTmp[4];
					$virtual_file_mime_type = $value;
					$arrTempFiles[$tempFilePosition]['virtual_file_mime_type'] = $virtual_file_mime_type;

				}

			}

			$submittal_id = Data::parseInt($get->submittal_id);
			$updatedsubmittal =(string)$get->updatedsubmittal;

			// Sort files and save to cloud
			if (!empty($arrTempFiles)) {
				ksort($arrTempFiles);

				$datePrefix = date('Y-m-d H:i A');
				$datePrefix = "$datePrefix - ";

				$su_attachment_source_contact_id = $currentlyActiveContactId;

				$nextSuAttachmentSequenceNumber = SubmittalAttachment::findNextSubmittalAttachmentSequenceNumber($database, $submittal_id);
				foreach ($arrTempFiles as $k => $tempFile) {
					$tempFileSha1 = $tempFile['tempFileSha1'];
					$tempFilePath = $tempFile['tempFilePath'];
					$tempFileName = $tempFile['tempFileName'];
					$virtual_file_mime_type = $tempFile['virtual_file_mime_type'];

					$virtual_file_name = $datePrefix . $virtual_file_name;


				}
			}

			$submittal = Submittal::findById($database, $submittal_id);
			$project_id =$submittal->project_id;
			/* @var $submittal Submittal */

			// Submittal Attachments
			// The Submittal document is the Submittal pdf with all attachment appended into it.
			$loadSubmittalAttachmentsBySubmittalIdOptions = new Input();
			$loadSubmittalAttachmentsBySubmittalIdOptions->forceLoadFlag = true;
			$loadSubmittalAttachmentsBySubmittalIdOptions->arrOrderByAttributes = 'sort_order';
			$arrSubmittalAttachmentsBySubmittalId = SubmittalAttachment::loadSubmittalAttachmentsBySubmittalId($database, $submittal_id, $loadSubmittalAttachmentsBySubmittalIdOptions,'1');

			// Folder
			// Save the file_manager_folders record (virtual_file_path) to the db and get the id
			$virtual_file_path = '/Submittals/Submittal #' . $submittal->su_sequence_number . '/';
			//To get the project Company Id
			$db = DBI::getInstance($database);
			$query ="SELECT * FROM `projects` WHERE `id` = '$project_id' ORDER BY `id` DESC ";
			$db->execute($query);
			$row=$db->fetch();

			$main_company=$row['user_company_id'];
			$db->free_result();

			// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$currentVirtualFilePath = '/';
			foreach ($arrFolders as $folder) {
				$tmpVirtualFilePath = array_shift($arrFolders);
				$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
				// Save the file_manager_folders record (virtual_file_path) to the db and get the id
				$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $main_company, $currentlyActiveContactId, $project_id, $currentVirtualFilePath);
			}
			/* @var $fileManagerFolder FileManagerFolder */

			// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
			$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

			// Copy all pdf files to the server's local disk
			$config = Zend_Registry::get('config');
			$file_manager_front_end_node_file_copy_protocol = $config->system->file_manager_front_end_node_file_copy_protocol;
			$baseDirectory = $config->system->base_directory;
			$fileManagerBasePath = $config->system->file_manager_base_path;
			$fileManagerFileNamePrefix = $config->system->file_manager_file_name_prefix;
			$basePath = $fileManagerBasePath.'frontend/'.$user_company_id;
			$compressToDir = $fileManagerBasePath.'temp/'.$user_company_id.'/'.$project_id.'/';
			$urlDirectory = 'downloads/'.'temp/'.$user_company_id.'/'.$project_id.'/';
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
				/* @var $submittalAttachment SubmittalAttachment */

				// Debug
				//continue;

				// Start with offset 2 to save 1 for the cover sheet
				if ($skipOne) {
					$skipOne = false;
					continue;
				}

				$suAttachmentFileManagerFile = $submittalAttachment->getSuAttachmentFileManagerFile();
				/* @var $suAttachmentFileManagerFile FileManagerFile */

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
				FileManagerFile::restoreFromTrash($database,$suAttachmentFileManagerFile->file_manager_file_id);
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

				/*
				// Track progress in the database
				if ($workflowProgressIndicator) {
					$workflowProgressIndicator->progress = $counter;
					$workflowProgressIndicator->convertPropertiesToData();
					$workflowProgressIndicator->save();
				}
				*/

				$counter++;
			}

			// Build the HTML for the Submittal pdf document (html to pdf via DOMPDF)
			$htmlContent = buildSuAsHtmlForPdfConversion($database, $main_company, $submittal_id,$currentlyActiveContactId,$updatedsubmittal,$user_company_id);
			$htmlContent = html_entity_decode($htmlContent);
			$htmlContent = mb_convert_encoding($htmlContent, "HTML-ENTITIES", "UTF-8");
			// sha1 of: su html + file_location_id list from su attachments
			// Generate sha1 hash of html to see if a new spread has been created
			// $csvSuAttachmentFileLocationIds = join(',', $arrSuAttachmentFileLocationIds);
			//$submittal_sha1 = sha1($htmlContent);

			// Take the sha1 of the Submittal pdf with the attachments appended
			// Check for existence of $bid_spreadsheet_data_sha1
			//$potentialDuplicateSubmittal = Submittal::findBySubmittalSha1($database, $submittal_sha1);

			// @todo Finish sha1 at File Manager File level to support this
			$potentialDuplicateSubmittal = false;

			// Check for data-level change via sha1 hash
			if ($potentialDuplicateSubmittal) {
				// Use existing file_manager_file_id
				$su_file_manager_file_id = $potentialDuplicateSubmittal->su_file_manager_file_id;
			}

			/**/
			// Write Submittal to temp folder as a pdf document
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

			// Debug
			// copy the file to a temp file just like a standard file upload
			if (!isset($tempFilePath) || empty($tempFilePath)) {
				$tempFilePath = 'C:/dev/build/advent-sites/branches/development/www/www.axis.com/downloads/temp/su.pdf';
			}

			//$tempFileName = File::getTempFileName();
			//$tempFilePath = $tempDir.$tempFileName;
			file_put_contents ($tempFilePath, $pdf_content);
			/**/

			// Debug
			// Simulate having written the pdf to disk via dompdf
			//$tempPath = 'C:/dev/build/advent-sites/branches/development/www/www.axis.com/downloads/temp/su.pdf';
			//$pdf_content = file_get_contents($tempPath);

			if (!empty($arrPdfFiles)) {

				// Put the cover sheet first in the list
				array_unshift($arrPdfFiles, $tempPdfFile);

				$finalSuTempFileName = $tempFileName . '.pdf';
				$finalSuTempFilepath = $tempDir.$finalSuTempFileName;

				// Merge the Submittal pdf and all Submittal attachments into a single Submittal pdf document
				Pdf::merge($arrPdfFiles, $tempDir, $finalSuTempFileName);

				$tempFilePath = $finalSuTempFilepath;

			}

			// Debug.
			//exit;

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
			$file_location_id = FileManager::saveUploadedFileToCloud($database, $file);

			// Rename file...for replace case???
			//$virtual_file_name = $file_type_name . " - Old (Uploaded " .$previous_date_added. ").pdf";

			// save the file information to the file_manager_files db table
			$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $main_company, $currentlyActiveContactId, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
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
			// Submittal Attachments Set Permission 
			$loadSubmittalAttachmentsBySubmittalIdOptions = new Input();
			$loadSubmittalAttachmentsBySubmittalIdOptions->forceLoadFlag = true;
			$arrSubmittalAttachmentsBySubmittalId = SubmittalAttachment::loadSubmittalAttachmentsBySubmittalId($database, $submittal_id, $loadSubmittalAttachmentsBySubmittalIdOptions,'1');
			foreach ($arrSubmittalAttachmentsBySubmittalId as $submittalAttachment) {
				$su_attachment_file_manager_file_id = (int) $submittalAttachment->file_manager_file_id;
				$fileManagerFile = FileManagerFile::findById($database, $su_attachment_file_manager_file_id);
				if (isset($fileManagerFile) && !empty($fileManagerFile)) {
					$fileUserCompanyId = $fileManagerFile->user_company_id;
					$file_manager_folder_id = $fileManagerFile->file_manager_folder_id;
					$fileManagerFileSetPermission = FileManagerFile::setPermissionsToMatchParentFolder($database, $su_attachment_file_manager_file_id, $file_manager_folder_id);
				}
			}

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

			/*
			$existingData = $bidSpread->getData();
			if ($nextBidSpreadSequenceNumber > 1) {

				$bidSpread = new BidSpread($database);
				$bidSpread->gc_budget_line_item_id = $gc_budget_line_item_id;
				$bidSpread->bid_spread_sequence_number = $nextBidSpreadSequenceNumber;
				$bidSpread->bid_spreadsheet_data_sha1 = $bid_spreadsheet_data_sha1;
				$bidSpread->bid_spread_status_id = 1;
				if (isset($bid_spread_preferred_subcontractor_bid_id)) {
					$bidSpread->bid_spread_preferred_subcontractor_bid_id = $bid_spread_preferred_subcontractor_bid_id;
				}
				if (isset($bid_spread_preferred_subcontractor_contact_id)) {
					$bidSpread->bid_spread_preferred_subcontractor_contact_id = $bid_spread_preferred_subcontractor_contact_id;
				}
				$bidSpread->bid_spread_bid_total = $bid_spread_bid_total;
				$bidSpread->unsigned_bid_spread_pdf_file_manager_file_id = $file_manager_file_id;
				$bidSpread->convertPropertiesToData();
				$bidSpread['created'] = null;
				$bid_spread_id = $bidSpread->save();

			} else {

				$newData = array(
					'bid_spread_sequence_number' => $nextBidSpreadSequenceNumber,
					'bid_spreadsheet_data_sha1' => $bid_spreadsheet_data_sha1,
					'bid_spread_bid_total' => $bid_spread_bid_total,
					'unsigned_bid_spread_pdf_file_manager_file_id' => $file_manager_file_id,
				);
				if (isset($bid_spread_preferred_subcontractor_bid_id)) {
					$newData['bid_spread_preferred_subcontractor_bid_id'] = $bid_spread_preferred_subcontractor_bid_id;
				}
				if (isset($bid_spread_preferred_subcontractor_contact_id)) {
					$newData['bid_spread_preferred_subcontractor_contact_id'] = $bid_spread_preferred_subcontractor_contact_id;
				}
				$bidSpread->setData($newData);
				$bidSpread->save();

			}
			*/

			// Debug
			//exit;

			// Delete temp files
			$fileObject->rrmdir($tempDir);

			// Load PDF files list
			//$arrBidSpreadPdfFilenames =

			$virtual_file_name_url = $uri->cdn . '_' . $file_manager_file_id;
			$virtual_file_name_url_encoded = urlencode($virtual_file_name_url);

			// Debug
			$primaryKeyAsString = $submittal_id;

			// Output standard formatted error or success message
			if (isset($primaryKeyAsString) && (!empty($primaryKeyAsString))) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error creating: Bid Spread.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();

			$errorNumber = 1;
			//$errorMessage = 'Error creating: Bid Spread.';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			$primaryKeyAsString = '';

			// Delete temp files
			if (isset($tempDir) && !empty($tempDir) && is_dir($tempDir)) {
				$fileObject->rrmdir($tempDir);
			}
		}

	break;

	case 'Submittals__sendSuEmail':

		// This assumes that all Submittal data is captured in the database and Cloud Filesystem
		$errorNumber = 0;
		$errorMessage = '';

		try {

			// Check permissions - manage
			/*
			$userCanManageSubmittals = $permissions->determineAccessToSoftwareModuleFunction('submittals_manage');
			if (!$userCanManageSubmittals) {
				// Error and exit
				//$errorMessage = 'Permission denied.';
				//$errorMessage = 'Permission denied: cannot create new Submittal data values.';
				$errorMessage = 'Error creating: Submittal.<br>Permission Denied.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
			*/

			// Get primary key / unique key via get input
			$attributeGroupName = (string) $get->attributeGroupName;
			$formattedAttributeGroupName = (string) $get->formattedAttributeGroupName;
			$attributeSubgroupName = (string) $get->attributeSubgroupName;
			$formattedAttributeSubgroupName = (string) $get->formattedAttributeSubgroupName;
			$submittal_id = (int) $get->submittal_id;
			$submittal_notification_id = (int) $get->submittal_notification_id;
			$emailBody = (string) $get->emailBody;
			$updatedsubmittal = (string) $get->updatedsubmittal;

			if($updatedsubmittal == 'yes'){
				$emailLine = 'updated';
			}else{
				$emailLine = 'created';
			}

			// Use the active contact_id from the session as the current Submittal "Sendor" or SMTP "From"
			$sendor_contact_id = $currentlyActiveContactId;

			if (!isset($formattedAttributeGroupName) || empty($formattedAttributeGroupName)) {
				$formattedAttributeGroupName = 'Submittal';
			}
			if (!isset($formattedAttributeSubgroupName) || empty($formattedAttributeSubgroupName)) {
				$formattedAttributeSubgroupName = 'Submittal';
			}

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$db->throwExceptionOnDbError = true;

			$submittalNotification = SubmittalNotification::findSubmittalNotificationByIdExtended($database, $submittal_notification_id);
			/* @var $submittalNotification SubmittalNotification */

			$submittal_id = $submittalNotification->submittal_id;
			if (!isset($submittal_id)) {
				$submittal_id = (int) $get->submittal_id;
			}

			$submittal = Submittal::findSubmittalByIdExtended($database, $submittal_id);
			//$submittal = $submittalNotification->getSubmittal();
			/* @var $submittal Submittal */
			$submittal->htmlEntityEscapeProperties();
			$main_project_id=$submittal->project_id;
			$project = $submittal->getProject();
			/* @var $project Project */
			$project->htmlEntityEscapeProperties();
			$formattedProjectName = $project->project_name . ' (' . $project->user_custom_project_id . ')';
			$formattedProjectNameHtmlEscaped = $project->escaped_project_name . ' (' . $project->escaped_user_custom_project_id . ')';

			$submittalType = $submittal->getSubmittalType();
			/* @var $submittalType SubmittalType */

			$submittalStatus = $submittal->getSubmittalStatus();
			/* @var $submittalStatus SubmittalStatus */

			$submittalPriority = $submittal->getSubmittalPriority();
			/* @var $submittalPriority SubmittalPriority */

			// Cloud Filesystem File
			$suFileManagerFile = $submittal->getSuFileManagerFile();
			/* @var $suFileManagerFile FileManagerFile */
			$suFileManagerFile->htmlEntityEscapeProperties();

			$suCostCode = $submittal->getSuCostCode();
			/* @var $suCostCode CostCode */

			// Cost Code
			if ($suCostCode) {
				$formattedSuCostCode = $suCostCode->getFormattedCostCode($database,true, $user_company_id);
			} else {
				$formattedSuCostCode = '';
			}

			// Toggles back and forth
			// From:
			// To:
			$suCreatorContact = $submittal->getSuCreatorContact();
			/* @var $suCreatorContact Contact */

			$suCreatorContactCompanyOffice = $submittal->getSuCreatorContactCompanyOffice();
			/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */

			$suCreatorPhoneContactCompanyOfficePhoneNumber = $submittal->getSuCreatorPhoneContactCompanyOfficePhoneNumber();
			/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$suCreatorFaxContactCompanyOfficePhoneNumber = $submittal->getSuCreatorFaxContactCompanyOfficePhoneNumber();
			/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$suCreatorContactMobilePhoneNumber = $submittal->getSuCreatorContactMobilePhoneNumber();
			/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */

			// Toggles back and forth
			// From:
			// To:
			$suRecipientContact = $submittal->getSuRecipientContact();
			/* @var $suRecipientContact Contact */

			$suRecipientContactCompanyOffice = $submittal->getSuRecipientContactCompanyOffice();
			/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */

			$suRecipientPhoneContactCompanyOfficePhoneNumber = $submittal->getSuRecipientPhoneContactCompanyOfficePhoneNumber();
			/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$suRecipientFaxContactCompanyOfficePhoneNumber = $submittal->getSuRecipientFaxContactCompanyOfficePhoneNumber();
			/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$suRecipientContactMobilePhoneNumber = $submittal->getSuRecipientContactMobilePhoneNumber();
			/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */

			$suInitiatorContact = $submittal->getSuInitiatorContact();
			/* @var $suInitiatorContact Contact */

			$suInitiatorContactCompanyOffice = $submittal->getSuInitiatorContactCompanyOffice();
			/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */

			$suInitiatorPhoneContactCompanyOfficePhoneNumber = $submittal->getSuInitiatorPhoneContactCompanyOfficePhoneNumber();
			/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$suInitiatorFaxContactCompanyOfficePhoneNumber = $submittal->getSuInitiatorFaxContactCompanyOfficePhoneNumber();
			/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */

			$suInitiatorContactMobilePhoneNumber = $submittal->getSuInitiatorContactMobilePhoneNumber();
			/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
      $submittalCreatedAt = $submittal->created;
			// List of additional Submittal Recipients
			$loadSubmittalRecipientsBySubmittalNotificationIdOptions = new Input();
			$loadSubmittalRecipientsBySubmittalNotificationIdOptions->forceLoadFlag = true;
			$arrSubmittalRecipientsBySubmittalNotificationId = SubmittalRecipient::loadSubmittalRecipientsBySubmittalNotificationId($database, $submittal_notification_id, $loadSubmittalRecipientsBySubmittalNotificationIdOptions);

			// Submittal Attachments
			$loadSubmittalAttachmentsBySubmittalIdOptions = new Input();
			$loadSubmittalAttachmentsBySubmittalIdOptions->forceLoadFlag = true;
			$arrSubmittalAttachmentsBySubmittalId = SubmittalAttachment::loadSubmittalAttachmentsBySubmittalId($database, $submittal_id, $loadSubmittalAttachmentsBySubmittalIdOptions);

			// Timestamp
			$timestamp = date("D, M j g:i A", time());

			$uri = Zend_Registry::get('uri');
			//$url = $uri->https.'account-registration-form-step1.php?guid='.$guid;
			//$smsUrl = $uri->https.'r.php?guid='.$guid;

			// Cloud Filesystem URL & Filename
			$virtual_file_name = $suFileManagerFile->virtual_file_name;
			$escaped_virtual_file_name = $suFileManagerFile->escaped_virtual_file_name;
			//$virtual_file_name_url = $uri->cdn . '_' . $suFileManagerFile->file_manager_file_id;
			$virtual_file_name_url = $suFileManagerFile->generateUrl(true);
			if (strpos($virtual_file_name_url,"?"))
			{
				$virtual_file_name_url = $virtual_file_name_url."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
			}else
			{
				$virtual_file_name_url = $virtual_file_name_url."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
			}

			$suUrl =
				$uri->http . 'modules-submittals-form.php' .
					'?submittal_id='.$submittal_id;

			// Send out a SMS or Email
			// Determine if SMS, Email, or Both
			$emailFlag = true;
			$smsFlag = false;

			// Invitation Initiator/Sender/Inviter's Information
			$inviteFromName = '';

			// @todo Refactor this to inlcude the below HTML template section and SMS
			// Derived above - first in Project Executive list
			// Toggles back and forth
			// From:
			// To:
			if ($sendor_contact_id == $suCreatorContact->contact_id) {
				$toContact = $suRecipientContact;
				$fromContact = $suCreatorContact;
			} else {
				$toContact = $suRecipientContact;
				$fromContact = $suCreatorContact ;
			}
			$toContact->htmlEntityEscapeProperties();
			$fromContact->htmlEntityEscapeProperties();
			$senderName = Contact::ContactNameById($database, $sendor_contact_id);

			// From:
			$fromName = $fromContact->getContactFullName();
			$fromEmail = $fromContact->email;
			$fromNameHtmlEscaped = $fromContact->getContactFullNameHtmlEscaped();
			$fromEmailHtmlEscaped = $fromContact->escaped_email;

			$smsFromName = $fromContact->getContactFullName();
			$smsFromEmail = $fromContact->email;
			$fromContactTitle = $fromContact->title;
			$fromContactTitleHtmlEscaped = $fromContact->escaped_title;

			// To:
			$toName = $toContact->getContactFullName();
			$toEmail = $toContact->email;
			$toNameHtmlEscaped = $toContact->getContactFullNameHtmlEscaped();
			$toEmailHtmlEscaped = $toContact->escaped_email;

			$smsToName = $toContact->getContactFullName();
			$smsToEmail = $toContact->email;
			$toContactTitle = $toContact->title;
			$toContactTitleHtmlEscaped = $toContact->escaped_title;

			// Return-To
			$returnName = $fromName;
			$returnEmail = $fromEmail;
			$smsReturnName = $fromName;
			$smsReturnEmail = $fromEmail;
			$returnContactTitle = $fromContactTitle;

			$alertMessageSubject =$project->project_name." Submittal #$submittal->su_sequence_number". " - ".$submittal->su_title;
			$smsAlertMessageSubject = "Submittal #$submittal->su_sequence_number";

			$systemMessage = '';
			$systemMessage2 = '';
			$alertHeadline = '';
			$alertBody = '';

			//$smsAlertMessageBody = "Register: $smsUrl";
			$alertHeadline = $project->project_name.' Submittal #' . $submittal->su_sequence_number . '.';
			$systemMessage = $project->project_name.' Submittal #' . $submittal->su_sequence_number . '.';
			$bodyHtml = 'Submittal #' . $submittal->su_sequence_number ;

			// Subject line has the project name in it
			//$smsAlertMessageBody = "Submittal #$submittal->su_sequence_number: $smsUrl";
			//$alertHeadline = 'Please <a href="'.$url.'">Register or Sign In</a> to Bid on '.$inviterUserCompany->company.'&#39;s '.$project->project_name.' project.';
			$systemMessage =
				'The attached Submittal has been '.$emailLine.', please review the attached documents: <br>';
				//'Project Name: ' . $project->project_name . '<br>' .$costCode
				//' <a href="'.$virtual_file_name_url.'">' . $virtual_file_name . '</a><br>' .
				//'PDF: (<a href="'.$virtual_file_name_url.'">' . $virtual_file_name . '</a>)<br><br>';


			$systemMessage2 = '';

			// Invitation Initiator/Sender/Inviter's Information
			$submitFromSignature = '<div style="font-weight:bold; text-decoration: underline;">Submittal Created  By</div>';
			// Full Name
			if (isset($fromName) && !empty($fromName)) {
				$submitFromSignature .= $fromNameHtmlEscaped . '<br>';
			}
			// Title
			if (isset($fromContactTitle)) {
				$submitFromSignature .= $fromContactTitleHtmlEscaped . '<br>';
			}
			// Company
			if ($fromContact->contact_company_id) {
				$fromContactCompany = ContactCompany::findById($database, $fromContact->contact_company_id);
				/* @var $fromContactCompany ContactCompany */
				if ($fromContactCompany) {
					$fromContactCompany->htmlEntityEscapeProperties();
					$submitFromSignature .= $fromContactCompany->escaped_contact_company_name . '<br>';
				}
			}

			// Email
			$submitFromSignature .= $fromContact->escaped_email . '<br>';
			if(isset($submittalCreatedAt)){
				$submittalCreatedAt = new DateTime($submittalCreatedAt);
				$submittalCreatedAt = $submittalCreatedAt->format('D, M j, Y');
				$submitFromSignature .= 'Submittal Created on '. $submittalCreatedAt. '<br>';
			}
			$submitFromSignature .='<br><div style="font-weight:bold; text-decoration: underline;">Submittal Message Updated By<br></div>'.$senderName.'<br><br>';
			$submitFromSignature .= "Submittal Message Sent: $timestamp" . '<br>';

			$includeAttachment = true;

			$customEmailMessageFromSubmitter = '';
			$htmlAlertHeadline = '';

			// Send email to primary To:
			$toName = trim($toName);
			$greetingLine = '';
			if (isset($toName) && !empty($toName)) {
				$greetingLine = $toNameHtmlEscaped.',<br>';
			}

			// Optional Email Body
			if (!isset($emailBody) || empty($emailBody)) {
				$emailBody = '';
			} else {
				$emailBody = Data::entity_encode($emailBody);
				$emailBody = nl2br($emailBody);
				$emailBody .= '<br><br>';
			}

			$suPageLinkText = "Submittal #$submittal->su_sequence_number - $submittal->escaped_su_title";
			$headline = 'Submittal ';
				//To get the project Company Id
			$main_company = Project::ProjectsMainCompany($database,$main_project_id);
			require_once('lib/common/Logo.php');
		 	$mail_image = Logo::logoByUserCompanyIDforemail($database,$main_company);

		 	$sufilelocationId=$suFileManagerFile->file_location_id;
			$filemaxSize=Module::getfilemanagerfilesize($sufilelocationId,$database);
			if(!$filemaxSize)
			{
				$subPDF="<tr>
<td style='padding:7px;border: 1px solid #333333;'>Submittal PDF File:</td>
<td style='padding:7px;border: 1px solid #333333;'><a href='".$virtual_file_name_url."'>$escaped_virtual_file_name</a></td>
</tr>";
	}else
	{
		$subPDF="";
	}

	/*To Name Change - Start*/
						//To
					$greetingLine = $greetingName= '';
					foreach ($arrSubmittalRecipientsBySubmittalNotificationId as $submittalRecipient) {
					
						$smtp_recipient_header_type = $submittalRecipient->smtp_recipient_header_type;
						$suAdditionalRecipientContact = $submittalRecipient->getSuAdditionalRecipientContact();
						// To
						// To
					if($smtp_recipient_header_type =="To")
					{
						if ($suAdditionalRecipientContact) {
							$additionalTo = $suAdditionalRecipientContact->getContactFullName();
							$additionalEmail = $suAdditionalRecipientContact->email;
						} 
						if (isset($additionalTo) && !empty($additionalTo)) {
						$greetingName .=$additionalTo.', ';
						}else
						{
							$greetingName .=$additionalEmail.', ';
						}
					}
				}
					if (isset($greetingName) && !empty($greetingName)) {
				$greetingLine = '<b>'.$greetingName.'</b>';
			}
	/* To Name Change - End */
 


// HTML Email output for Email clients that support HTML
$htmlAlertMessageBody = <<<END_HTML_MESSAGE

<table style="border-collapse: separate !important; border-spacing: 0;width:100%;padding-top: 15px;" align="left" border="0" cellpadding="0" cellspacing="0">
<tr>
<td style=""><h2 style="color: #3b90ce; font-size: 15px; margin: 5px 0 10px; padding: 0;">$headline</h2>
<div style="">
<table style="width:100%;">
<tbody>
 <td style="width:100%;">
	<h2 style="margin: 0 0 10px 0; padding: 0; white-space: nowrap;"></h2>
	<h4 style="text-transform:capitalize;">$greetingLine</h4>
	<h4>$emailBody</h4>
	$systemMessage
 </td>
</tbody>
</table>
<table style="width:100%;">
<thead>
<tr>
<th align="left" colspan="2" style="font-weight:bold; text-decoration: underline;padding: 15px 0;">Submittal Summary</th>
</tr>
</thead>

<tbody>
<tr>
<td style="padding:7px;border: 1px solid #333333;">Project:</td>
<td style="padding:7px;border: 1px solid #333333;">$formattedProjectNameHtmlEscaped</td>
</tr>
<tr>
<td style="padding:7px;border: 1px solid #333333;">Cost Code:</td>
<td style="padding:7px;border: 1px solid #333333;">$formattedSuCostCode</td>
</tr>
<tr>
<td style="padding:7px;border: 1px solid #333333;">Submittal Web Page URL:</td>
<td style="padding:7px;border: 1px solid #333333;"><a href="$suUrl">$suPageLinkText</a></td>
</tr>
$subPDF

</tbody>
</table>
<br>
$submitFromSignature
<br>
<br>
</div>
</td></tr></table>
END_HTML_MESSAGE;

			ob_start();
			//$formattedType = ucfirst($type);
			$headline = 'Submittal ';
			$mail_image=$mail_image;
			//include('templates/mail-template-bid-spread-approval-request.php');
			include('templates/mail-template.php');
			$bodyHtml = ob_get_clean();
			$rlpEmail = Contact::ContactEmailById($database,$currentlyActiveContactId,'email'); 
			$rlpName = Contact::ContactEmailById($database,$currentlyActiveContactId,'name');

			
			

			try {
				//$var1 = $var2;
				// Debug
				/*
				if (strstr($toEmail, 'precision')) {
					throw new Exception('');
				}
				*/
				//throw new Exception('');
				if ($emailFlag) {
					//$toEmail = $email;
				$sendEmail = 'Alert@MyFulcrum.com';
    				$sendName = ($rlpName !=" ") ? $rlpName : "Fulcrum Message";

					$mail = new Mail();
					$mail->setReturnPath($returnEmail);
					//$mail->setBodyText($alertMessageBody);
					//$mail->setBodyText($bodyHtml);
					// $mail->setBodyHtml($htmlAlertMessageBody);
					$mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
					$mail->setFrom($sendEmail, $sendName);
					
					
			        $mail->addHeader('Reply-To',$rlpEmail);


					// Cc / Bcc
					foreach ($arrSubmittalRecipientsBySubmittalNotificationId as $submittalRecipient) {
						$submittal_notification_id = $submittalRecipient->submittal_notification_id;
						$su_additional_recipient_contact_id = $submittalRecipient->su_additional_recipient_contact_id;
						$su_additional_recipient_contact_mobile_phone_number_id = $submittalRecipient->su_additional_recipient_contact_mobile_phone_number_id;
						$smtp_recipient_header_type = $submittalRecipient->smtp_recipient_header_type;

						$submittalNotification = $submittalRecipient->getSubmittalNotification();
						/* @var $submittalNotification SubmittalNotification */

						$suAdditionalRecipientContact = $submittalRecipient->getSuAdditionalRecipientContact();
						/* @var $suAdditionalRecipientContact Contact */

						$suAdditionalRecipientContactMobilePhoneNumber = $submittalRecipient->getSuAdditionalRecipientContactMobilePhoneNumber();
						/* @var $suAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */

						// Cc or Bcc
						if ($suAdditionalRecipientContact) {
							$additionalTo = $suAdditionalRecipientContact->getContactFullName();
							$additionalEmail = $suAdditionalRecipientContact->email;
						} else {
							continue;
						}

						if (isset($smtp_recipient_header_type)) {
							$isToContactArchive = Contact::isUserArchive($database,$additionalTo);
							if ($isToContactArchive) {
							if ($smtp_recipient_header_type == 'Bcc') {
								$mail->addBcc($additionalEmail, $additionalTo);
							} else if($smtp_recipient_header_type == 'Cc'){
								$mail->addCc($additionalEmail, $additionalTo);
							} else if($smtp_recipient_header_type == 'To'){
								$mail->addTo($additionalEmail, $additionalTo);
							} else {
								$mail->addCc($additionalEmail, $additionalTo);
							}
						} 
					}else {
							// Defaul to Cc for bad data case
							$mail->addCc($additionalEmail, $additionalTo);
						}
					
				}
					// To replace the em dash with normal dash
					$alertMessageSubject = str_replace('–', '-', $alertMessageSubject);
					$mail->setSubject($alertMessageSubject);
					if($filemaxSize){
					if ($includeAttachment && isset($suFileManagerFile) && $suFileManagerFile) {
						// Attach Submittal itself
						$cdnFileUrl = $suFileManagerFile->generateUrl();
						$attachmentFileName = $suFileManagerFile->virtual_file_name;

						$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
						if (strpos($cdnFileUrl, '?')) {
							$separator = '&';
						} else {
							$separator = '?';
						}
						$finalCdnFileUrl = 'http:' . $cdnFileUrl . $separator . 'id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
						$fileContents = file_get_contents($finalCdnFileUrl);
						$mail->createAttachment($attachmentFileName, $fileContents);

						//$file = $mail->createAttachment($fileContents);
						//$file->filename = $attachmentFileName;

						//foreach ($arrSubmittalAttachmentsBySubmittalId as $submittalAttachment) {
						//	$suAttachmentFileManagerFile = $submittalAttachment->getSuAttachmentFileManagerFile();
						//	/* @var $suAttachmentFileManagerFile FileManagerFile */
						//
						//	$suAttachmentSourceContact = $submittalAttachment->getSuAttachmentSourceContact();
						//	/* @var $suAttachmentSourceContact Contact */
						//
						//	//$cdnFileUrl = $arrAttachments[$file_manager_file_id]['cdnFileUrl'];
						//	//$attachmentFileName = $arrAttachments[$file_manager_file_id]['fileName'];
						//	$cdnFileUrl = $suAttachmentFileManagerFile->generateUrl();
						//	$attachmentFileName = $suAttachmentFileManagerFile->virtual_file_name;
						//
						//	$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
						//	$finalCdnFileUrl = 'http:' . $cdnFileUrl . '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
						//	$fileContents = file_get_contents($finalCdnFileUrl);
						//	$mail->createAttachment($attachmentFileName, $fileContents);
						//
						//	//$file = $mail->createAttachment($fileContents);
						//	//$file->filename = $attachmentFileName;
						//}

					}
				}
					$mail->send();
					//To delete the img
				    $config = Zend_Registry::get('config');
				    $file_manager_back = $config->system->base_directory;
				    $file_manager_back =$file_manager_back.'www/www.axis.com/';
				    $path=$file_manager_back.$mail_image;
				    unlink($path);
				}

				if ($smsFlag) {
					// MessageGateway_Sms
					MessageGateway_Sms::sendSmsMessage($mobile_phone_number, $mobile_network_carrier_id, $smsToName, $smsFromEmail, $smsFromName, $smsAlertMessageSubject, $smsAlertMessageBody);
				}
			} catch(Exception $e) {
				// Mail/SMS failed to send
				$errorMessage = $e->getMessage();
				throw new Exception($errorMessage);
			}

			// Debug
			//exit;

			$customEmailMessageFromSubmitter = '';

			foreach ($arrSubmittalRecipientsBySubmittalNotificationId as $submittalRecipient) {

				// SKIP THIS SECTION
				continue;

				$submittal_notification_id = $submittalRecipient->submittal_notification_id;
				$su_additional_recipient_contact_id = $submittalRecipient->su_additional_recipient_contact_id;
				$su_additional_recipient_contact_mobile_phone_number_id = $submittalRecipient->su_additional_recipient_contact_mobile_phone_number_id;
				$smtp_recipient_header_type = $submittalRecipient->smtp_recipient_header_type;

				$submittalNotification = $submittalRecipient->getSubmittalNotification();
				/* @var $submittalNotification SubmittalNotification */

				$suAdditionalRecipientContact = $submittalRecipient->getSuAdditionalRecipientContact();
				/* @var $suAdditionalRecipientContact Contact */

				$suAdditionalRecipientContactMobilePhoneNumber = $submittalRecipient->getSuAdditionalRecipientContactMobilePhoneNumber();
				/* @var $suAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */

				// Email/SMS Details
				// To Name
				$toName = $suAdditionalRecipientContact->getContactFullName();
				$smsToName = $toName;
				$toEmail = $suAdditionalRecipientContact->email;
				$toName = trim($toName);
				$greetingLine = '';
				if (isset($toName) && !empty($toName)) {
					$greetingLine = $toName.',<br><br>';
				}

// HTML Email output for Email clients that support HTML
$htmlAlertMessageBody = <<<END_HTML_MESSAGE
$greetingLine$emailBody$systemMessage
<br>
<table>
<thead>
<tr>
<th align="left" colspan="2" style="font-weight: bold; text-decoration: underline;">Submittal Summary</th>
</tr>
</thead>

<tbody>
<tr>
<td>Project:</td>
<td>$formattedProjectNameHtmlEscaped</td>
</tr>
<tr>
<td>Cost Code:</td>
<td>$formattedSuCostCode</td>
</tr>
<tr>
<td>Submittal Web Page URL:</td>
<td><a href="$suUrl">$suPageLinkText</a></td>
</tr>
<tr>
<td>Submittal PDF File:</td>
<td><a href="$virtual_file_name_url">$escaped_virtual_file_name</a></td>
</tr>
</tbody>
</table>
$systemMessage2
$customEmailMessageFromSubmitter
<br>
$submitFromSignature
<br>
END_HTML_MESSAGE;

				ob_start();
				//$formattedType = ucfirst($type);
				$headline = 'Submittal ';
				//include('templates/mail-template-bid-spread-approval-request.php');
				include('templates/mail-template.php');
				$bodyHtml = ob_get_clean();

				try {
					//$var1 = $var2;
					// Debug
					/*
					if (strstr($toEmail, 'precision')) {
						throw new Exception('');
					}
					*/
					//throw new Exception('');
					if ($emailFlag) {
						//$toEmail = $email;
					$sendEmail = 'Alert@MyFulcrum.com';
    				$sendName = ($fromName !=" ") ? $fromName : "Fulcrum Message";
						$mail = new Mail();
						$mail->setReturnPath($returnEmail);
						//$mail->setBodyText($alertMessageBody);
						//$mail->setBodyText($bodyHtml);
						$mail->setBodyHtml($htmlAlertMessageBody);
						//$mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED, false);
					$mail->setFrom($sendEmail, $sendName);
				        $mail->addHeader('Reply-To',$fromEmail);


						// Cc or Bcc
						if (isset($smtp_recipient_header_type)) {
							if ($smtp_recipient_header_type == 'Bcc') {
								$mail->addBcc($toEmail, $toName);
							} else {
								$mail->addCc($toEmail, $toName);
							}
						}

						$mail->setSubject($alertMessageSubject);
						if ($includeAttachment) {
							// Attach Submittal itself
							$cdnFileUrl = $suFileManagerFile->generateUrl();
							$attachmentFileName = $suFileManagerFile->virtual_file_name;

							$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
							$finalCdnFileUrl = 'http:' . $cdnFileUrl . '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
							$fileContents = file_get_contents($finalCdnFileUrl);
							$mail->createAttachment($attachmentFileName, $fileContents);

							//$file = $mail->createAttachment($fileContents);
							//$file->filename = $attachmentFileName;

							//foreach ($arrSubmittalAttachmentsBySubmittalId as $submittalAttachment) {
							//	$suAttachmentFileManagerFile = $submittalAttachment->getSuAttachmentFileManagerFile();
							//	/* @var $suAttachmentFileManagerFile FileManagerFile */
							//
							//	$suAttachmentSourceContact = $submittalAttachment->getSuAttachmentSourceContact();
							//	/* @var $suAttachmentSourceContact Contact */
							//
							//	//$cdnFileUrl = $arrAttachments[$file_manager_file_id]['cdnFileUrl'];
							//	//$attachmentFileName = $arrAttachments[$file_manager_file_id]['fileName'];
							//	$cdnFileUrl = $suAttachmentFileManagerFile->generateUrl();
							//	$attachmentFileName = $suAttachmentFileManagerFile->virtual_file_name;
							//
							//	$cdnFileUrl = str_replace("http:", '', $cdnFileUrl);
							//	$finalCdnFileUrl = 'http:' . $cdnFileUrl . '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
							//	$fileContents = file_get_contents($finalCdnFileUrl);
							//	$mail->createAttachment($attachmentFileName, $fileContents);
							//
							//	//$file = $mail->createAttachment($fileContents);
							//	//$file->filename = $attachmentFileName;
							//}

						}
						$mail->send();
						//To delete the img
						$config = Zend_Registry::get('config');
						$file_manager_back = $config->system->base_directory;
						$file_manager_back =$file_manager_back.'www/www.axis.com/';
						$path=$file_manager_back.$mail_image;
						unlink($path);
					}

					if ($smsFlag) {
						// MessageGateway_Sms
						MessageGateway_Sms::sendSmsMessage($mobile_phone_number, $mobile_network_carrier_id, $smsToName, $smsFromEmail, $smsFromName, $smsAlertMessageSubject, $smsAlertMessageBody);
					}
				} catch(Exception $e) {
					// Mail/SMS failed to send
					$errorMessage = $e->getMessage();
					throw new Exception($errorMessage);
				}
			}

			$message->reset($currentPhpScript);

			$emailSent = true;


			// Output standard formatted error or success message
			if ($emailSent) {
				// Success
				$errorNumber = 0;
				$errorMessage = '';
				$message->reset($currentPhpScript);
			} else {
				// Error code here
				$errorNumber = 1;
				$errorMessage = 'Error sending email: Submittal.';
				$message->enqueueError($errorMessage, $currentPhpScript);
				throw new Exception($errorMessage);
				//$error->outputErrorMessages();
				//exit;
			}
		} catch (Exception $e) {
			$db->rollback();
			$db->free_result();

			$errorNumber = 1;

			//$primaryKeyAsString = '';
			//$errorMessage = 'Error creating: Submittal';
			//$message->enqueueError($errorMessage, $currentPhpScript);
			//$backTrace = getExceptionTraceAsString($e);
			//$error->setBackTrace($backTrace);
			//$error->outputErrorMessages();
			//exit;
		}

		$db->throwExceptionOnDbError = false;

		$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
		if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {
			$errorNumber = 1;
			$errorMessage = join('<br>', $arrErrorMessages);

			//$errorMessage = $message->getFormattedHtmlMessages($currentPhpScript);
			//$error->outputErrorMessages();
			//exit;
		}

		if (isset($responseDataType) && ($responseDataType == 'json')) {
			require('code-generator/json-response.php');
		} elseif (isset($responseDataType) && ($responseDataType == 'html')) {
			$output = $htmlContent;
		} else {
			// Default to pipe-delimited values
			$output = "$errorNumber|$errorMessage|$attributeGroupName|$attributeSubgroupName|$emailSent|$formattedAttributeGroupName|$formattedAttributeSubgroupName";
		}

		echo $output;

	break;

	case 'Submittals__generateSubmittalsListViewPdf':

		$errorNumber = 0;
		$errorMessage = '';
		$attributeGroupName = '';
		$primaryKeyAsString = '';
		$htmlContent = '';

		// @todo Add sorting paramaters on the query string

		$suTable = renderSuListView_AsHtml($database, $project_id, $user_company_id);
		$htmlContent = $suTable;

		// Place the PDF file in a download directory and output the download link.
		$config = Zend_Registry::get('config');
		$baseDirectory = $config->system->base_directory;
		$fileManagerBasePath = $config->system->file_manager_base_path;

		//$version4_uuid = UniversallyUniqueIdentifier::version4();
		//$tempFolder = $version4_uuid . '/';
		$tempFolder = '';

		$fileDownloadUrlDirectory = '/downloads/temp/'.$user_company_id.'/'.$project_id.'/'.$tempFolder;
		$fileDownloadTempDir = $baseDirectory.'www/www.axis.com'.$fileDownloadUrlDirectory;
		$fileObject = new File();
		$fileObject->mkdir($fileDownloadTempDir, 0777);

		$pdfPhantomJS = new PdfPhantomJS();
		$pdfPhantomJS->writeTempFileContentsToDisk($htmlContent);

		// generate url with query_string for phontomJS to read the file with contents from $htmlOutput
		$pdfTempFileUrl = $pdfPhantomJS->getTempFileUrl();

		$pdfPhantomJS->setTempFileUrl($pdfTempFileUrl);
		$htmlTempFileBasePath = $pdfPhantomJS->getTempFileBasePath();
		$htmlTempFileSha1 = $pdfPhantomJS->getTempFileSha1();
		$pdfTempFileFullPath = $htmlTempFileBasePath . $htmlTempFileSha1 . '.pdf';
		$pdfPhantomJS->setCompletePdfFilePath($pdfTempFileFullPath);

		$result = $pdfPhantomJS->execute();

		// delete the html temp file
		$pdfPhantomJS->deleteTempFile();

		$finalFilePath = $fileDownloadTempDir .  $htmlTempFileSha1 . '.pdf';

		rename($pdfTempFileFullPath, $finalFilePath);

		$nowDate = date('m/d/Y');
		$filename = "$userCompanyName - $project_name - $nowDate Submittals.pdf";
		$encodedFilename = rawurlencode($filename);
		$url = $fileDownloadUrlDirectory . $htmlTempFileSha1 . '.pdf?filename=' . $encodedFilename;

		$arrOutput = array(
			'errorNumber' => $errorNumber,
			'errorMessage' => $errorMessage,
			'url' => $url
		);

		$jsonOutput = json_encode($arrOutput);

		// Send HTTP Content-Type header to alert client of JSON output
		header('Content-Type: application/json');
		echo $jsonOutput;

	break;

	case 'submittal__reset_subDropDown':
		$drop = submittalDraftDropDown($database, $project_id);
		echo $drop;
	break;

	/* Function to update submittal details to meeting */

	case 'updateActionItemSu':

		$su_id 			= $get->su_id;
		$su_field_value = $get->su_field_value;
		$su_field_name 	= $get->su_field_name;
		$su_status_id 	= $get->su_status_id;

		$status_id = array(1,4,5,6,7);
		
		if (!in_array($su_status_id, $status_id) && $su_status_id != '') {
			$su_field_value = date('Y-m-d');
			$SubmittalStatusClosed = SubmittalStatus::insertClosedDate($database,$su_id,$su_field_value,'closed' );
		}else if(in_array($su_status_id, $status_id) && $su_status_id != ''){
			$su_field_value = '0000-00-00 00:00:00';
			$su_date = date('Y-m-d');
			$SubmittalStatusClosed = SubmittalStatus::insertClosedDate($database,$su_id,$su_date,'open' );
		}	

		$options = array();
		$options['table'] = 'action_items';
		$options['update'] = array( $su_field_name.' = ?'=> $su_field_value);	
		$options['filter'] = array('action_item_type_id = ?'=> '7', 'action_item_type_reference_id = ?'=> $su_id);	

		$updateOption = TableService::UpdateMultipleTabularData($database,$options);

		echo $updateOption;

	break;

	case 'reArrangeAttachment':
		$attchment = json_decode($get->attchment,true);
		$subid = $get->subid;
		$db = DBI::getInstance($database);
		$subsort_order=0;
		foreach ($attchment as $key => $fileid) {
			   $query = "UPDATE submittal_attachments SET sort_order = ? WHERE su_attachment_file_manager_file_id = ?  and submittal_id = ? ";
			   $arrValues = array($subsort_order,$fileid,$subid);
			   $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			   $db->free_result();
			   $subsort_order++;
		}
		
	break;

	case 'SubmittalUpdateTag':
	
		$sub_id 		= $get->sub_id;
		$sub_Tags 		=(string) $get->sub_Tags;
		$arr_sub_Tags = explode(',', $sub_Tags);
		$arrtag ='';
			foreach ($arr_sub_Tags as $key => $sval) {
				$tagid = Tagging::searchAndInsertTag($database,$sval,$project_id);
				$arrtag .= $tagid.',';
			}
			$arrtag = rtrim($arrtag,',');
			$res = TableService::UpdateTabularData($database,'submittals','tag_ids',$sub_id,$arrtag);
			echo $res;		
	break;
}

$htmlOutput = ob_get_clean();
echo $htmlOutput;

while (@ob_end_flush());

exit; // End of PHP Ajax Handler Code

} catch (Exception $e) {
	// Be sure to get the exception error message when Global Admin debug mode.
	$error->outputErrorMessages();
	exit;
}

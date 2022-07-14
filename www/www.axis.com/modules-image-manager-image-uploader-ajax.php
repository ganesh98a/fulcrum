<?php
/**
 * Ajax file uploader.
 */
$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/File.php');
require_once('lib/common/FileManager.php');
require_once('lib/common/ImageManagerFolder.php');
require_once('lib/common/ImageManagerImage.php');
require_once('lib/common/Log.php');

// LOGGING UPLOAD TIME TO THE BACKEND FILE DATABASE
$timer->startTimer();
$_SESSION['timer'] = $timer;

// MESSAGING VARIABLES
require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */
$message->reset($currentPhpScript);
/* @var $get Egpcs */
$get->sessionClear();
ob_start();
// SESSION VARIABLES
/* @var $session Session */
$session->setFormSubmitted(true);
$user_company_id = $session->getUserCompanyId();
$user_id = $session->getUserId();
$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
// $project_id = $session->getCurrentlySelectedProjectId();
$currentlySelectedProjectName = $session->getCurrentlySelectedProjectName();

$methodCall = $get->method;

// Temp files directive to allow the upload of temp files, but not inject them into the cloud
// $get->method=uploadTempFilesOnly
if (isset($methodCall) && !empty($methodCall) && ($methodCall == 'uploadTempFilesOnly')) {

	$uploadTempFilesOnly = true;

	// Temp directory prefix to help have a balanced filesystem on the server
	$tempDirectoryPrefix = "$user_company_id/$user_id/$currentlyActiveContactId/";

} else {

	$uploadTempFilesOnly = false;
	$tempDirectoryPrefix = '';

}


if ($get->folder_id) {

	$file_manager_folder_id = $get->folder_id;
	$fileManagerFolder = ImageManagerFolder::findById($database, $file_manager_folder_id);
	/* @var $fileManagerFolder FileManagerFolder */

	// $project_id = $fileManagerFolder->project_id;

} else {

	// Missing folder_id in the GET input so output an error
	$errorMessage = "An error occurred while uploading the file.\nMissing parent folder.";
	$arrJsonOutput = array(
		'error'=> $errorMessage
	);
	$ajaxError = json_encode($arrJsonOutput);
	exit($ajaxError);

	
}
$config = Zend_Registry::get('config');
/* @var $config Config */
$file_manager_base_path = $config->system->file_manager_base_path;
$tmpFileDirectory = $file_manager_base_path . 'temp/' . $tempDirectoryPrefix;
$objFileOperation = new File();
if (!is_dir($tmpFileDirectory)) {
	$directoryCreatedFlag = $objFileOperation->mkdir($tmpFileDirectory);
}

$arrFiles = File::parseUploadedFiles($tempDirectoryPrefix);
if (empty($arrFiles)) {

	// @todo Test workflow and errors placed into 'modules-file-manager-file-browser.php' scope vs $currentPhpScript
	//$message->enqueueError($errorMessage, $currentPhpScript);
	$message->enqueueError('Please upload a valid file.', 'modules-file-manager-file-browser.php');

}


// Debug

$arrErrorMessages = $message->getQueue($currentPhpScript, 'error');
if (isset($arrErrorMessages) && !empty($arrErrorMessages)) {

	if ($debugMode) {
		$errorMessage = "Please upload a valid file.\n\n" . '$get:' . "\n" . print_r($get, true) . "\n\n" . '$_SERVER:' . "\n" . print_r($_SERVER, true);
	} else {
		$errorMessage = 'Please upload a valid file.';
	}

	$arrJsonOutput = array(
		'error' => $errorMessage
	);

	$ajaxError = json_encode($arrJsonOutput);
	exit($ajaxError);

} else {


	if (!empty($arrFiles)) {

		if (count($arrFiles) == 1) {
			$provided_virtual_file_name = (string) $get->virtual_file_name;
		} else {
			$provided_virtual_file_name = '';
		}

		$arrFilesMetaData = array();
		// print_r($arrFiles);
		foreach ($arrFiles as $file) {
			$fileSizePath = $file->tempFilePath;
			$path= realpath($fileSizePath);
			$info   = getimagesize($path);
        	$mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
        	$width  = $info[0]; // width as integer for ex. 512
        	$height = $info[1]; // height as integer for ex. 384
        	$type   = $info[2];      // same as exif_imagetype
        	$checkDeleteFlag = 'N';
        	// print_r($info);
        	if($width < 150 || $width > 500){
        		$checkDeleteFlag = 'Y';
        	}
        	if($height < 40 || $height > 100){
        		$checkDeleteFlag = 'Y';
        	}
        	if($checkDeleteFlag == 'Y'){
        		$errorMessage = 'Size is '.$width.'x'.$height.', upload valid image size. Image size allowed from 150x40 to 500x100';
        		unlink($fileSizePath);
        		$message->enqueueError($errorMessage, $currentPhpScript);
        		$arrJsonOutput = array(
        			'error' => $errorMessage
        		);
        		$ajaxError = json_encode($arrJsonOutput);
        		exit($ajaxError);
        	}
        	$virtual_file_path = $get->virtual_file_path;
        	if (empty($provided_virtual_file_name)) {
        		$virtual_file_name = rawurldecode($file->name);
        	} else {
        		$virtual_file_name = $provided_virtual_file_name;
        	}
        	$virtual_file_mime_type = $file->type;
        	$post_upload_js_callback = $get->post_upload_js_callback;

        	$prependDateToFilename = $get->prepend_date_to_filename;
        	if (isset($prependDateToFilename) && !empty($prependDateToFilename)) {
        		$datePrefix = date('Y-m-d H:i A');
        		$datePrefix = "$datePrefix - ";
        		$virtual_file_name = $datePrefix . $virtual_file_name;
        	}

        	$appendDateToFilename = $get->append_date_to_filename;
        	if (isset($appendDateToFilename) && !empty($appendDateToFilename)) {
        		$dateSuffix = date('Y-m-d H:i A');
        		$dateSuffix = " - $dateSuffix";
        		$virtual_file_name = $virtual_file_name . $dateSuffix;
        	}

			// Debug
        	$file_location_id = FileManager::saveUploadedFileToCloud($database, $file);

        	if ($file_location_id == -1) {

        		$errorMessage = "File upload failed.\nFile could not be saved to the cloud.";
        		$arrJsonOutput = array(
        			'error'=> $errorMessage
        		);
        		$ajaxError = json_encode($arrJsonOutput);
        		exit($ajaxError);

        	}

			// Debug
			/*
			$errorMessage = "file_location_id: $file_location_id";
			$arrJsonOutput = array(
				'error'=> $errorMessage
			);
			$ajaxError = json_encode($arrJsonOutput);
			exit($ajaxError);
			*/


			if ($virtual_file_path == '/') {
				$fileManagerFolder = ImageManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $virtual_file_path);
			} else {
				// Save the root folder "/" to the database (if not done so already)
				$fileManagerFolder = ImageManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, '/');

				// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
				$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
				$currentVirtualFilePath = '/';
				foreach ($arrFolders as $folder) {
					$tmpVirtualFilePath = array_shift($arrFolders);
					$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
					// Save the file_manager_folders record (virtual_file_path) to the db and get the id
					$fileManagerFolder = ImageManagerFolder::findByVirtualFilePath($database, $user_company_id, $currentlyActiveContactId, $currentVirtualFilePath);
				}
			}

			// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
			/* @var $fileManagerFolder FileManagerFolder */
			$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

			// save the file information to the file_manager_files db table
			$fileManagerFile = ImageManagerImage::findByVirtualFileName($database, $user_company_id, $currentlyActiveContactId, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
			/* @var $fileManagerFolder FileManagerFolder */
			$file_manager_file_id = $fileManagerFile->file_manager_file_id;
			$fileUrl = $fileManagerFile->generateUrl();

			$arrIndividualFileMetaData = array(
				'file_manager_folder_id' => $file_manager_folder_id,
				'virtual_file_path' => $fileManagerFolder->virtual_file_path,
				'file_manager_file_id' => $file_manager_file_id,
				'virtual_file_name' => $virtual_file_name,
				'virtual_file_mime_type' => $virtual_file_mime_type,
				'fileUrl' => $fileUrl
				//'virtual_file_path_sha1' => $fileManagerFolder->virtual_file_path_sha1,
				//'virtual_file_name_sha1' => $virtual_file_name_sha1,
			);
			$arrFilesMetaData[] = $arrIndividualFileMetaData;
		}

	} else {

		$errorMessage = "File upload(s) failed.\nNo Files were uploaded to the server.";
		$arrJsonOutput = array(
			'error'=> $errorMessage
		);
		$ajaxError = json_encode($arrJsonOutput);
		exit($ajaxError);

	}

	// output a json_encoded() success message
	$arrJsonOutput = array(
		'success' => 'File upload successful.',
		'fileMetadata' => $arrFilesMetaData
	);
	$ajaxMessage = json_encode($arrJsonOutput);
	echo $ajaxMessage;

	// Debug
	//$timer->stopTimer();
	//$totalTime = $timer->fetchFormattedTimerOutput();
	//echo "Total Time: $totalTime\n\n";

	exit(0);

	/*
	$message->resetAll();
	$message->enqueueConfirm('File uploaded successfully.', 'modules-file-manager-form.php');
	$message->sessionPut();

	$get->sessionClear();
	$session->setFormSubmitted(false);

	$url = '/modules-file-manager-form.php';
	header('Location: '.$url);
	exit;
	*/
}
exit(0);

<?php
require_once('lib/common/Api/RN_Permissions.php');
require_once('lib/common/ContactToRole.php');
require_once('lib/common/ProjectToContactToRole.php');
require_once('lib/common/File.php');

$RN_virtual_file_name = '';
if (isset($RN_params['virtual_file_name']) && !empty($RN_params['virtual_file_name'])) {
	$RN_virtual_file_name = $RN_params['virtual_file_name'];
}
$RN_virtual_file_path = $RN_params['virtual_file_path'];
$RN_prepend_date_to_filename = $RN_params['prepend_date_to_filename'];
$RN_append_date_to_filename = $RN_params['append_date_to_filename'];
/* @var $RN_session Session */
$RN_methodCall = $RN_params['method'];
$RN_allowed_extensions = $RN_params['allowed_extensions'];
$RN_jsonEC['err_message'] = null;
$RN_folder_id = $RN_params['folder_id'];
$RN_id = $RN_params['id'];
if($RN_folder_id == null && $RN_folder_id == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Folder id is Required";
}else
if($RN_methodCall == null && $RN_methodCall == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Method is Required";
}else
if($RN_virtual_file_path == null && $RN_virtual_file_path == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Virtual file path is Required";
}else
if($RN_methodCall == null && $RN_methodCall == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Method is Required";
}else
if($RN_allowed_extensions == null && $RN_allowed_extensions == ''){
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['err_message'] = "Allowed extensions is Required";
}
else{
	$RN_jsonEC['status'] = 200;
}

if($RN_jsonEC['status'] == 400){
	/*encode the array*/
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC['data'] = null;
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_jsonEC = json_encode($RN_jsonEC);
	/*echo the json response*/
	echo $RN_jsonEC;
	exit(0);
}
$RN_fileid = '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
// Temp files directive to allow the upload of temp files, but not inject them into the cloud

if (isset($RN_methodCall) && !empty($RN_methodCall) && ($RN_methodCall == 'uploadTempFilesOnly')) {

	$RN_uploadTempFilesOnly = true;

	// Temp directory prefix to help have a balanced filesystem on the server
	$RN_tempDirectoryPrefix = "$RN_user_company_id/$RN_user_id/$RN_currentlyActiveContactId/$RN_project_id/";

} else {

	$RN_uploadTempFilesOnly = false;
	$RN_tempDirectoryPrefix = '';

}


if ($RN_folder_id) {

	$RN_file_manager_folder_id = $RN_folder_id;
	$RN_fileManagerFolder = FileManagerFolder::findById($database, $RN_file_manager_folder_id);
	/* @var $RN_fileManagerFolder FileManagerFolder */

	$RN_project_id = $RN_fileManagerFolder->project_id;

} else {

	// Missing folder_id in the GET input so output an error
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['message'] = null;
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['err_message'] = "An error occurred while uploading the file.\nMissing parent folder.";
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_ajaxError = json_encode($RN_jsonEC);
	exit($RN_ajaxError);

}
$RN_arrFiles = File::parseUploadedFiles($RN_tempDirectoryPrefix);
$RN_dataType = null;
$RN_EA = explode(',', $RN_allowed_extensions);
array_push($RN_EA, 'octet-stream');
if (empty($RN_arrFiles)) {

	// @todo Test workflow and errors placed into 'modules-file-manager-file-browser.php' scope vs $RN_currentPhpScript
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['message'] = null;
	$RN_jsonEC['data'] = null;
	$RN_jsonEC['err_message'] = "Upload only ($RN_allowed_extensions)";
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_ajaxError = json_encode($RN_jsonEC);
	exit($RN_ajaxError);

}else{
	$RN_mime = $RN_arrFiles[0]['type'];
	list($type, $RN_dataType) = explode("/", $RN_mime, 2);
}

if(in_array($RN_dataType, $RN_EA)){
	$RN_debugMode = 0;
}else{
	$RN_debugMode = 1;
}

if ($RN_debugMode) {

	$RN_jsonEC['err_message'] = "Upload only ($RN_allowed_extensions)";
	
	$RN_jsonEC['status'] = 400;
	$RN_jsonEC['message'] = null;
	$RN_jsonEC['data'] = null;	
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_ajaxError = json_encode($RN_jsonEC);
	exit($RN_ajaxError);

} else {

	// Temp files case - files are uploaded to a temp directory, but injected into the cloud filesystem
	if ($RN_uploadTempFilesOnly && !empty($RN_arrFiles)) {

		// Return an ajax encoded files list
		$RN_rfiAttachmentSourceContact = Contact::findContactByIdExtended($database, $RN_currentlyActiveContactId);
		/* @var $RN_rfiAttachmentSourceContact Contact */
		$RN_rfiAttachmentSourceContactFullName = $RN_rfiAttachmentSourceContact->getContactFullName();

		$RN_tempFileUploadPosition = $RN_get->tempFileUploadPosition;
		if (!isset($RN_tempFileUploadPosition) || empty($RN_tempFileUploadPosition)) {
			$RN_tempFileUploadPosition = 1;
		}

		$RN_arrFilesMetaData = array();
		foreach ($RN_arrFiles as $RN_file) {
			$RN_tmpFileError = $RN_file->error;
			$RN_fileExtension = $RN_file->fileExtension;
			$RN_actualFileName = rawurldecode($RN_file->name);
			$RN_fileSha1 = $RN_file->sha1;
			$RN_tmpFileSize = $RN_file->size;
			$RN_tmpFilePath = $RN_file->tempFilePath;
			$RN_tmpFileName = $RN_file->tmp_name;
			$RN_fileType = $RN_file->type;

			$RN_config = Zend_Registry::get('config');
			/* @var $RN_config Config */
			$RN_file_manager_base_path = $RN_config->system->file_manager_base_path;
			$RN_tmpFileDirectory = $RN_file_manager_base_path . 'temp/' . $RN_tempDirectoryPrefix;
			$RN_objFileOperation = new File();
			if (!is_dir($RN_tmpFileDirectory)) {
				$RN_directoryCreatedFlag = $RN_objFileOperation->mkdir($RN_tmpFileDirectory);
			}
			$RN_tmpFileSha1Path = $RN_tmpFileDirectory . $RN_fileSha1;
			if (!is_file($RN_tmpFileSha1Path)) {
				$RN_fileMovedFlag = rename($RN_tmpFilePath, $RN_tmpFileSha1Path);
			}

			// Delete temp file if it is still present
			if (is_file($RN_tmpFilePath)) {
				//
				$RN_fileDeletedFlag = unlink($RN_tmpFilePath);
			}

			$RN_arrIndividualFileMetaData = array(
				'tempFileName' => $RN_actualFileName,
				'tempFileSha1' => $RN_fileSha1,
				'tempFilePath' => $RN_tempDirectoryPrefix,
				'tempFileUploadPosition' => $RN_tempFileUploadPosition,
				'virtual_file_mime_type' => $RN_fileType,
				'rfiAttachmentSourceContactFullName' => $RN_rfiAttachmentSourceContactFullName,
			);
			$RN_arrFilesMetaData[] = $RN_arrIndividualFileMetaData;

			$RN_tempFileUploadPosition++;
		}

		// output a json_encoded() success message
		$RN_jsonEC['status'] = 200;
		$RN_jsonEC['message'] = 'File upload successful.';
		$RN_jsonEC['data']['file_data'] = $RN_arrFilesMetaData;
		$RN_jsonEC['err_message'] = null;
		// include('./UploadDocSave.php');
		header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
		$RN_ajaxMessage = json_encode($RN_jsonEC);
		echo $RN_ajaxMessage;
		exit(0);

	}

	/**
	 * $RN_FILES uploaded via forms
	 *
	 * <form enctype="multipart/form-data" name="frm_name" action="form-submit.php" method="post">
	 * <input type="hidden" name="MAX_FILE_SIZE" value="2147483647">
	 * <input type="file" name="picture" tabindex="123">
	 */
	if (!empty($RN_arrFiles)) {

		if (count($RN_arrFiles) == 1) {
			$RN_provided_virtual_file_name = (string) $RN_virtual_file_name;
		} else {
			$RN_provided_virtual_file_name = '';
		}

		$RN_arrFilesMetaData = array();
		foreach ($RN_arrFiles as $RN_file) {
			$RN_virtual_file_path = $RN_virtual_file_path;
			if (empty($RN_provided_virtual_file_name)) {
				$RN_virtual_file_name = rawurldecode($RN_file->name);
			} else {
				$RN_virtual_file_name = $RN_provided_virtual_file_name;
			}
			$RN_virtual_file_mime_type = $RN_file->type;
			if(!empty($RN_file->fileExtension) && $RN_file->fileExtension == 'heic'){
				
				// $heicfile  = file_get_contents($RN_file['tmp_name']);
				$heicfile  = ($RN_file['tmp_name']);
				$RN_config = Zend_Registry::get('config');
				/* @var $RN_config Config */
				$RN_file_manager_base_path = $RN_config->system->file_manager_base_path;
				$RN_tmpFileDirectory = $RN_file_manager_base_path . 'temp/' . $RN_tempDirectoryPrefix;
				$filename = $RN_file['name'];
				$RN_tmpFileDirectoryWName = $RN_tmpFileDirectory.$filename;
				// die();
				$fileMovedFlag = copy($heicfile, $RN_tmpFileDirectoryWName);
				/*print_r($heicfile);die;*/
				$im = new imagick($RN_tmpFileDirectoryWName); 
			    $im->setImageFormat('jpeg');
			    $downloadfile = $RN_tmpFileDirectory."thumb.jpg";
    			$im->writeImage($downloadfile);
    			// print_r($RN_file);
    			$im = new imagick($downloadfile); 
    			$getImageSize = $im->getImageSize();
    			// echo $getImageName = $im->getImageFilename(); 
    			$info   = getimagesize($downloadfile);
	        	$mime   = $info['mime']; // mime-type as string for ex. "image/jpeg" etc.
	        	$width  = $info[0]; // width as integer for ex. 512
	        	$height = $info[1]; // height as integer for ex. 384
	        	$type   = $info[2];      // same as exif_imagetype
    			/* Overwrite File*/
    			$RN_file = new File();
    			$RN_file->sha1 = sha1_file($downloadfile); 
    			$RN_file->size = $getImageSize;
    			$RN_file->tmp_name = $downloadfile;
    			$RN_file->type = $mime;
    			$RN_file->fileExtension = 'jpg';
    			$RN_file->tempFilePath = $downloadfile;
    			$RN_file->name = 'thumb.jpg';
    			// replace heic format
    			$filenameex = pathinfo($RN_tmpFileDirectoryWName);
    			$implodeNameArr = $filenameex['filename'];
    			$RN_virtual_file_name = $implodeNameArr.'.jpg';
				$RN_virtual_file_mime_type = $mime;
				unlink($RN_tmpFileDirectoryWName);
    			// print_r($RN_file);
    			// die();
			}

			$exif = exif_read_data($RN_file->tempFilePath);
			// print_r($exif);
			$orientation = $exif['Orientation'];
			if($orientation <> 1) {
				$height = $exif['COMPUTED']['Height'];
				$width = $exif['COMPUTED']['Width'];
				if( $width > $height ) {
					$mode = 'landscape';
				} else if ( $width < $height ) {
					$mode = 'portrait';
				} else {
					$mode = 'even';
				}
				// $mode;
				$img = imagecreatefromjpeg($RN_file->tempFilePath);
				// $exif = @read_exif_data($RN_file->tempFilePath, 'IFD0');
				$orientation = $exif['Orientation'];
				switch($orientation) {    
				  // Standard/Normal Orientation (no need to do anything, we'll return true as in theory, it was successful)
				  case 1:
				  return true;
				    
				  // Flipped on the horizontal axis (might do it at some point in the future)
				  case 2:
				    //By @kormanowsky: imageflip() returns TRUE or FALSE so it's wrong to assign its return value to $final_img
				  imageflip($img, IMG_FLIP_HORIZONTAL);
				  $img = imagerotate($img, 0, 0);
				  break;
				  
				  // Turned 180 deg
				  case 3:
				    // imageflip($img, IMG_FLIP_BOTH);
				    $img = imagerotate($img, 180, 0);
				    // $img = imagerotate($img, 90, 0);
				  break;
				  
				  // Upside-Down
				  case 4:
				    imageflip($img, IMG_FLIP_HORIZONTAL);
				    $img = imagerotate($img, 180, 0);
				  break;
				  
				  // Turned 90 deg to the left and flipped
				  case 5:
				   imageflip($img, IMG_FLIP_VERTICAL);
				   // if($mode != 'landscape'){
					  // $img = imagerotate($img, 270, 0);
				   // }			   
				  // Turned 90 deg to the left
				  case 6:
				    $img = imagerotate($img, 270, 0);
				  break;
				  
				  // Turned 90 deg to the right and flipped
				  case 7:
				    imageflip($img, IMG_FLIP_HORIZONTAL);
				    $img = imagerotate($img, 180, 0);
				  // Turned 90 deg to the right
				  case 8:
				    $img = imagerotate($img, 90, 0); 
				  break;
				 }
				imagejpeg($img, $RN_file->tempFilePath, 95);
			}
			$RN_prependDateToFilename = $RN_prepend_date_to_filename;
			if (isset($RN_prependDateToFilename) && !empty($RN_prependDateToFilename)) {
				$RN_datePrefix = date('Y-m-d H:i A');
				$RN_datePrefix = "$RN_datePrefix - ";
				$RN_virtual_file_name = $RN_datePrefix . $RN_virtual_file_name;
			}

			$RN_appendDateToFilename = $RN_append_date_to_filename;
			if (isset($RN_appendDateToFilename) && !empty($RN_appendDateToFilename)) {
				$RN_dateSuffix = date('Y-m-d H:i A');
				$RN_dateSuffix = " - $RN_dateSuffix";
				$RN_virtual_file_name = $RN_virtual_file_name . $RN_dateSuffix;
			}

			$RN_file_location_id = FileManager::saveUploadedFileToCloud($database, $RN_file, false);
			if($RN_file->tempFilePath && file_exists($RN_file->tempFilePath)) {
				unlink($RN_file->tempFilePath);
			}

			if ($RN_file_location_id == -1) {

				$RN_jsonEC['status'] = 400;
				$RN_jsonEC['message'] = null;
				$RN_jsonEC['data'] = null;
				$RN_jsonEC['err_message'] = "File upload failed.\nFile could not be saved to the cloud.";
				header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
				$RN_ajaxError = json_encode($RN_jsonEC);
				exit($RN_ajaxError);
			}

			if ($RN_virtual_file_path == '/') {
				$RN_fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_virtual_file_path);
			} else {
				// Save the root folder "/" to the database (if not done so already)
				$RN_fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, '/');

				// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
				$RN_arrFolders = preg_split('#/#', $RN_virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
				$RN_currentVirtualFilePath = '/';
				foreach ($RN_arrFolders as $RN_folder) {
					$RN_tmpVirtualFilePath = array_shift($RN_arrFolders);
					$RN_currentVirtualFilePath .= $RN_tmpVirtualFilePath.'/';
					// Save the file_manager_folders record (virtual_file_path) to the db and get the id
					$RN_fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_currentVirtualFilePath);
				}
			}

			// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
			/* @var $RN_fileManagerFolder FileManagerFolder */
			$RN_file_manager_folder_id = $RN_fileManagerFolder->file_manager_folder_id;

			// save the file information to the file_manager_files db table
			$RN_fileManagerFile = FileManagerFile::findByVirtualFileName($database, $RN_user_company_id, $RN_currentlyActiveContactId, $RN_project_id, $RN_file_manager_folder_id, $RN_file_location_id, $RN_virtual_file_name, $RN_virtual_file_mime_type);
			/* @var $RN_fileManagerFolder FileManagerFolder */
			$RN_file_manager_file_id = $RN_fileManagerFile->file_manager_file_id;
			$RN_fileUrl = $RN_fileManagerFile->generateUrl(true);
			FileManagerFile::restoreFromTrash($database,$RN_file_manager_file_id);
			$RN_arrIndividualFileMetaData = array(
				'file_manager_folder_id' => $RN_file_manager_folder_id,
				'virtual_file_path' => $RN_fileManagerFolder->virtual_file_path,
				'file_manager_file_id' => $RN_file_manager_file_id,
				'virtual_file_name' => $RN_virtual_file_name,
				'virtual_file_mime_type' => $RN_virtual_file_mime_type,
				'fileUrl' => $RN_fileUrl,
				'fileUrlWId' => $RN_fileUrl.$RN_fileid,
			);

			$RN_explode = explode('/', $RN_virtual_file_mime_type);
			$RN_virtual_file_mime_type = $RN_explode[1];

			$RN_arrIndividualFileMetaDataTemp = array(
				'virtual_file_name' => $RN_virtual_file_name,
				'virtual_file_path' => $RN_fileUrl,
				'virtual_file_path_w_id' => $RN_fileUrl.$RN_fileid,
				'virtual_file_type' => $RN_virtual_file_mime_type
			);
			$RN_arrFilesMetaData = $RN_arrIndividualFileMetaData;
			$RN_arrFilesMetaDataTemp = $RN_arrIndividualFileMetaDataTemp;

			// Set Permissions of the file to match the parent folder.
			FileManagerFile::setPermissionsToMatchParentFolder($database, $RN_file_manager_file_id, $RN_file_manager_folder_id);
			
			/* file permission*/
			$RN_arrRolesToFileAccess = RN_Permissions::loadRolesToFilesPermission($database, $user, $RN_project_id, $RN_file_manager_file_id);
			$accessFiles = false;
			if(isset($RN_arrRolesToFileAccess) && !empty($RN_arrRolesToFileAccess)) {
				if($RN_arrRolesToFileAccess['view_privilege'] == "N"){
					$accessFiles = false;
				} else {
					$accessFiles = true;
				}
			}
			$RN_arrFilesMetaData['file_access'] = $accessFiles;
			$RN_arrFilesMetaDataTemp['file_access'] = $accessFiles;

		}

	} else {

		$RN_jsonEC['status'] = 400;
		$RN_jsonEC['message'] = null;
		$RN_jsonEC['data'] = null;
		$RN_jsonEC['err_message'] = "File upload(s) failed.\nNo Files were uploaded to the server.";
		header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
		$RN_ajaxError = json_encode($RN_jsonEC);
		exit($RN_ajaxError);
	}

	// output a json_encoded() success message
	$RN_jsonEC['status'] = 200;
	$RN_jsonEC['message'] = 'File upload successful.';
	$RN_jsonEC['data']['file_data'] = $RN_arrFilesMetaData;
	$RN_jsonEC['data']['raw_file_data'] = $RN_arrFilesMetaDataTemp;	
	$RN_jsonEC['err_message'] = null;
	// include_once('RN_methodCall.php');
	header('X-PHP-Response-Code: '.$RN_jsonEC['status'], true, $RN_jsonEC['status']);
	$RN_ajaxMessage = json_encode($RN_jsonEC);
	echo $RN_ajaxMessage;
	exit(0);
}
exit(0);

?>

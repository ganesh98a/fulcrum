<?php
/**
 * Framework standard header comments.
 *
 * “UTF-8” Encoding Check - Smart quotes instead of three bogus characters.
 * Smart quotes may show as a single bogus character if the font
 * does not support the smart quote character.
 *
 * Goal: efficient, debugger friendly code.
 *
 * Conservation of keystrokes is acheived by using tabs.
 * Tabs and indentation are rendered and inserted as 4 columns, not spaces.
 * Using actual tabs, not spaces in place of tabs. This conserves keystrokes.
 *
 * [vim]
 * VIM directives below to match the default setup for visual studio.
 * The directives are explained below followed by a vim modeline.
 * The modeline causes vim to render and manipulate the file as described.
 * noexpandtab - When the tab key is depressed, use actual tabs, not spaces.
 * tabstop=4 - Tabs are rendered as four columns.
 * shiftwidth=4 - Indentation is inserted and rendered as four columns.
 * softtabstop=4 - A typed tab in insert mode equates to four columns.
 *
 * vim: set noexpandtab tabstop=4 shiftwidth=4 softtabstop=4:
 *
 * [emacs]
 * Emacs directives below to match the default setup for visual studio.
 *
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * c-indent-level: 4
 * indent-tabs-mode: t
 * tab-stop-list: '(4 8 12 16 20 24 28 32 36 40 44 48 52 56 60)
 * End:
 */

/**
 * CDN controller script.
 */
// Slow connections may take a long time to load the file.
// Allow the script to never timeout.
ini_set('max_execution_time', 0);

// Secret key via url allows access to this script
if (isset($_GET['id']) && !empty($_GET['id'])) {
	$id = $_GET['id'];
	if ($id == '76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C') {
		$init['access_level'] = 'anon';
	} else {
		$init['access_level'] = 'auth';
	}
} else {
	$init['access_level'] = 'auth';
}
if(isset($_GET['logo']) && !empty($_GET['logo'])){
	$logo = true;
}else{
	$logo = false;
}
if(isset($_GET['thumbnail']) && !empty($_GET['thumbnail'])){
	$thumbnail = true;
}else{
	$thumbnail = false;
}
//$init['access_level'] = 'auth'; // anon, auth, admin, global_admin
//$init['ajax'] = true;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = false;
// Re-enable geo ip-delivery for production
//$init['geo'] = true;
$init['get_maxlength'] = 2048;
$init['get_required'] = false;
$init['https'] = true;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
//$init['output_buffering'] = true;
$init['override_php_ini'] = false;
//$init['post_maxlength'] = 100000;
$init['post_required'] = false;
//$init['sapi'] = 'cli'; // Omit or use "cli"
//$init['skip_always_include'] = true; //Skip include libraries defined in the application ini file.
$init['skip_session'] = false;
$init['skip_templating'] = true;
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');


if (isset($get->id) && !empty($get->id)) {
	$id = $get->id;
	if ($id == '76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C') {
		$requirePermissionsToViewCdnObject = false;
	} else {
		$requirePermissionsToViewCdnObject = true;
	}
} else {
	$requirePermissionsToViewCdnObject = true;
	echo "<span style='color:red;'>You don't have permission to access this file , please contact admin or project manager.</span>";
}

if(isset($get->logo) && !empty($get->logo)){
	$logo = true;
}else{
	$logo = false;
}
if(isset($get->thumbnail) && !empty($get->thumbnail)){
	$thumbnail = true;
}else{
	$thumbnail = false;
}

if (isset($get->download) && ($get->download == 1)) {
	$outputDownloadHeaders = true;
} else {
	$outputDownloadHeaders = false;
}


require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */

require_once('lib/common/FileManagerFile.php');

require_once('lib/common/ImageManagerImage.php');

// Check for temp file case
$url = $uri->current;
if (is_int(strpos($url, '__temp_file__'))) {

	// Parse temp file url
	$tempFileSha1 = $get->tempFileSha1;
	$tempFileName = $get->tempFileName;
	$tempFilePath = $get->tempFilePath;
	$tempFileMimeType = $get->tempFileMimeType;

	// @todo Revisit permissions for temp files
	$requirePermissionsToViewCdnObject = false;

	$fileManagerFile = new FileManagerFile($database);
	$fileManagerFile->virtual_file_name = $tempFileName;
	$fileManagerFile->virtual_file_mime_type = $tempFileMimeType;

	$config = Zend_Registry::get('config');
	/* @var $config Config */

	// E.g. "/var/ftp/file_manager_backend/"
	$file_manager_base_path = $config->system->file_manager_base_path;

	// $fullBackendFilePath = $file_manager_base_path . 'temp/' . $tempFilePath . $tempFileSha1;
	$fullBackendFilePath = $file_manager_base_path . 'temp/' . $tempFilePath;
} else {

	// Debug
	// http://localdev-cdn1.axis.com/18/_4
	// file_manager_backend/backend/data/18/_4

	$file_manager_file_id = $uri->current;
	//$file_manager_file_id = preg_replace('/^([^\?]+)\?id\=.+$/', '$1', $file_manager_file_id);
	$arrTemp = explode('?',$file_manager_file_id);
	$file_manager_file_id = array_shift($arrTemp);
	$file_manager_file_id = (int) preg_replace('/[^0-9]+/', '', $file_manager_file_id);

	if(!$logo){
	$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
	/* @var $fileManagerFile FileManagerFile */
	}else{
	$fileManagerFile = false;
	}
	if (!$fileManagerFile) {
		$debugMode = false;
		if (isset($session) && ($session instanceof Session)) {
			$debugMode = $session->getDebugMode();
		} elseif (isset($init['debugging_mode'])) {
			$debugMode = (bool) $init['debugging_mode'];
		}
		if ($debugMode) {
			echo 'File id does not exist in keyspace.';
		} else {
			// 404 Error message?
			echo '';
			$fileManagerFile = ImageManagerImage::findById($database, $file_manager_file_id);
			$requirePermissionsToViewCdnObject = false;
		}
		// exit;
	}

	if ($requirePermissionsToViewCdnObject) {
		require_once('lib/common/RoleToFile.php');
		$fileManagerFile->loadPermissions();
	}

	$file_location_id = $fileManagerFile->file_location_id;

	require_once('lib/common/FileLocation.php');
	//$fileLocation = FileLocation::findById($database, $file_location_id);
	/* @var $fileLocation FileLocation */

	$arrCdnFilePath = FileLocation::createFilePathFromId($file_location_id);
	$path = $arrCdnFilePath['file_path'];
	$fileName = $arrCdnFilePath['file_name'];

	$fullBackendFilePath = $path.$fileName;
}
// to view the thumbnail image
if($thumbnail) {
	$fullBackendFilePath .= '_thumbnail';
	$fileManagerFile->virtual_file_mime_type = 'image/png';
}

// Verify file exists in the specified CDN bucket
if (!empty($fullBackendFilePath) && is_file($fullBackendFilePath)) {
	// Verify permissions
	if ( !$requirePermissionsToViewCdnObject || ($fileManagerFile->view_privilege == 'Y') ) {
		$virtual_file_mime_type = $fileManagerFile->virtual_file_mime_type;
		$virtual_file_name = $fileManagerFile->virtual_file_name;
		// Load file_size from the file_locations table
		$file_size = filesize($fullBackendFilePath);

		// Set HTTP and Cache-Control headers for CDN values
		//$arrHeaders = headers_list();
		header("X-Robots-Tag: noindex,noarchive");

		header("Content-Length: $file_size");
		header("Expires: Thu, 15 Apr 2020 20:00:00 GMT");
		header("Cache-Control: max-age=315360000");
		header("Pragma: Public");

		if ($outputDownloadHeaders) {
			$contentDispositionHeader = 'Content-Disposition: attachment; filename="'.$virtual_file_name.'"';
			header($contentDispositionHeader);
			header('Content-Type: application/force-download');
			header('Content-Type: application/octet-stream');
			header('Content-Type: application/download');
			header('Content-Description: File Transfer');
		} else {
			// Browser "Save As" Dialog
			// E.g. instead of "_123.pdf" being downloaded we want "Project Name - Plans Name.pdf".
			// Filename will match the virtual_file_name stored in file_manager_files for the given file.
			$contentDispositionHeader = 'Content-Disposition: inline; filename="'.$virtual_file_name.'"';
			header($contentDispositionHeader);
			header("Content-Type: $virtual_file_mime_type");
		}
		//header('Content-Description: File Transfer');
		//header('Content-Disposition: attachment; filename='.basename($file));
		//header('Content-Transfer-Encoding: binary');

		ob_clean();
		flush();
		readfile($fullBackendFilePath);

		/*
		$handle = fopen($fullBackendFilePath, "rb");
		while (!feof($handle)) {
			$contents = fread($handle, 8192);
			echo $contents;
		}
		*/

		//$fileContents = file_get_contents($fullBackendFilePath);
		//echo $fileContents;
	}
} else {
	$debugMode = false;
	if (isset($session) && ($session instanceof Session)) {
		$debugMode = $session->getDebugMode();
	} elseif (isset($init['debugging_mode'])) {
		$debugMode = (bool) $init['debugging_mode'];
	}
	if ($debugMode) {
		// Output a file not found image...
		echo 'Filepath does not exist in cloud backend file system.';
	} else {
		// 404 Error message?
		echo '';
	}
	exit;
}

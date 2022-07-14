<?php
/**
 * File manager file download.
 *
 */

/**
 * Software header for:
 * 1) Session
 * 		-Standardization
 * 		-Fixation prevention
 * 		-Hijacking prevention
 * 		-Cross site scripting prevention
 * 2) Data input sanitization
 * 3) SQL injection prevention
 * 4) Standard framework variables and includes
 *
 */
$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['ajax'] = false;
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');

$config = Zend_Registry::get('config');
/* @var $config Config */

$file_manager_base_path = $config->system->file_manager_base_path;
$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;

function customErrorHandler($errno, $errstr, $errfile, $errline)
{
	$output = "Error #: $errno\nError: $errstr\nFile: $errfile\nLine: $errline";

	switch ($errno) {
		// Do the same action for all types of errors
		case E_USER_ERROR:
		case E_USER_WARNING:
		case E_USER_NOTICE:
		default:
			echo $output;
			exit;
			break;
	}

	/* Don't execute PHP internal error handler */
	return true;
}

// Set a custom user defined PHP error handler for use with Ajax requests
// Save the previous error hander function name into the variable "$existingErrorHandler" in case we want to set it back after our Ajax code block
$existingErrorHandler = set_error_handler("customErrorHandler", E_ALL);


$url = $get->file;
header("Content-type: application/octet-stream");
header("Location: $url");
exit;



/**
 * $_FILES uploaded via forms
 *
 * <form enctype="multipart/form-data" name="frm_name" action="form-submit.php" method="post">
 * <input type="hidden" name="MAX_FILE_SIZE" value="2147483647">
 * <input type="file" name="uploaded_file" tabindex="123">
 */
if (isset($_FILES['uploaded_file']['name']) && !empty($_FILES['uploaded_file']['name'])) {
	require_once('lib/common/AbstractWebToolkit.php');
	require_once('lib/common/Model.php');
	require_once('lib/common/DBI.php');
	require_once('lib/common/DBI/mysqli.php');
	require_once('lib/common/IntegratedMapper.php');
	require_once('lib/common/Data.php');
	require_once('lib/common/File.php');
	require_once('lib/common/FileManager.php');
	require_once('lib/common/FileManagerFolder.php');
	require_once('lib/common/FileManagerFile.php');

	$arrFiles = File::parseUploadedFiles();
	foreach ($arrFiles as $file) {
		$file_location_id = $_GET['id'];
		$virtual_file_name = $file->name;
		$virtual_file_mime_type = $file->type;

		$arrFilePath = FileLocation::createFilePathFromId($file_location_id);
		$filePath = $arrFilePath['file_path'];
		$fileName = $arrFilePath['file_name'];

		// Will be eventually copying over to cloud vendor here...
		$successFlag = FileManager::moveUploadedFile($file, $filePath, $fileName);

		if ($successFlag) {
			echo 'Success';
		} else {
			echo 'Fail';
		}

		// Log values to ensure proper inputs
		$logFilePath = $basePath.'file_manager/temp/error_log.txt';
		require_once('Zend/Log.php');
		require_once('Zend/Log/Writer/Stream.php');
		$logger = new Zend_Log();
		$writer = new Zend_Log_Writer_Stream($logFilePath);
		$logger->addWriter($writer);
		$logOutput = "\nfile_location_id: $file_location_id\nSuccess Flag: $successFlag\nVirtual File Name: $virtual_file_name\nBackend File Path: $filePath\nBackend File Name: $fileName\nMime Type: $virtual_file_mime_type\n\n"; //GET:\n".print_r($get, true);
		$logger->log($logOutput, Zend_Log::NOTICE);
		// Destroy Zend logger object.
		$logger = null;

		exit;
	}
}

<?php
/**
 * File download controller script.
 */
// Slow connections take a long time to load the file.
ignore_user_abort(true);
ini_set('max_execution_time', 0);

$init['access_level'] = 'anon'; // anon, auth, admin, global_admin
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['display'] = false;
$init['https'] = true;
$init['https_auth'] = true;
$init['https_admin'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['timer'] = true;
$init['timer_start'] = true;
require_once('lib/common/init.php');

require_once('lib/common/Message.php');
$message = Message::getInstance();
/* @var $message Message */

// Debug
// http://localdev-cdn1.axis.com/downloads/temp/4/15/sub_.zip
// /downloads/temp/4/15/sub_.zip

$fileDownloadUrl = $uri->current;
$fileDownloadUrl = urldecode($fileDownloadUrl);

if (!empty($get->filename)) {

	$filenameFlag = true;
	$filename = $get->filename;

	// @todo Make this more robust using the Uri class.
	if (is_int(strpos($fileDownloadUrl, '?filename='))) {
		$find = '?filename='.$filename;
		$fileDownloadUrl = str_replace($find, '', $fileDownloadUrl);
	} else {
		$find = '&filename='.$filename;
		$fileDownloadUrl = str_replace($find, '', $fileDownloadUrl);
	}

} else {
	$filenameFlag = false;
}

$base_directory = $config->system->base_directory;
$fileDownloadPath = $base_directory.'www/www.axis.com'.$fileDownloadUrl;

// Verify file exists in the specified CDN bucket
if (!empty($fileDownloadPath) && is_file($fileDownloadPath)) {

	if ($filenameFlag) {
		$virtual_file_name = $filename;
	} else {
		$arrTmp = explode('/', $fileDownloadPath);
		$virtual_file_name = array_pop($arrTmp);
	}

	$file_size = filesize($fileDownloadPath);
	$fileDownloadParentPath = dirname($fileDownloadPath);

	

	/**
	 * File Download headers and settings.
	 * @see http://www.richnetapps.com/the-right-way-to-handle-file-downloads-in-php/
	 */

	// @todo Implement range-based downloads
	if (isset($_SERVER['HTTP_RANGE'])) {
		$range = $_SERVER['HTTP_RANGE'];
	}
	

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	// Non-standard HTTP header, but supported by some browswers
	header("Content-Description: File Transfer");
	// Double quotes around the filename are required in case it contains spaces
	$contentDispositionHeader = 'Content-Disposition: attachment; filename="'.$virtual_file_name.'"';
	header($contentDispositionHeader);
	header("Content-Length: $file_size");
	// Non-standard HTTP header, but supported by some browswers
	header("Content-Transfer-Encoding: binary");
	header("Content-Type: application/download", false);
	header("Content-Type: application/force-download", false);
	header("Content-Type: application/octet-stream", false);
	header("Expires: 0");
	header("Pragma: public");
	header("X-Robots-Tag: noindex,noarchive");

	if (ob_get_level()) {
		ob_clean();
	}
	readfile($fileDownloadPath);
	if (connection_aborted()) {
		if (is_file($fileDownloadPath)) {
			$deletedFlag = unlink($fileDownloadPath);
		}
	}
	if (is_file($fileDownloadPath)) {
		$deletedFlag = unlink($fileDownloadPath);
	}

	// Flush all content
	while(ob_get_level()) {
		ob_end_flush();
	}
	
	$operatingSystem = Application::getOperatingSystem();
	if ($operatingSystem == 'Windows') {
		// windows
		$handle = opendir($fileDownloadParentPath);
		closedir($handle);
		if (is_file($fileDownloadPath)) {
			$deletedFlag = unlink($fileDownloadPath);
			if (!$deletedFlag) {
				trigger_error("Failed to delete file: $fileDownloadPath");
			}
		}
	} else {
		$cmd = "cd $fileDownloadParentPath; /bin/rm -f $virtual_file_name";
		shell_exec($cmd);
	}
}

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
 * Manage binary and text files on disk in the cloud.
 *
 * @category   FileManager
 * @package    FileManager
 */

/**
 * File
 */
require_once('lib/common/File.php');

/**
 * FileLocation
 */
require_once('lib/common/FileLocation.php');

/**
 * Log_FileManagerBackend
 */
require_once('lib/common/Log/FileManagerBackend.php');

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class FileManager extends IntegratedMapper
{
	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_className = 'FileManagerFiles';

	protected $_table = 'file_manager_files';

	/**
	 * Standard attributes list.
	 *
	 * Metadata mapper pattern maps db attributes to object properties.
	 *
	 * Key - database attribute/field
	 * Value - object property
	 *
	 * @var array
	 */
	protected $arrAttributesMap = array(
		'id' => 'file_manager_file_id',

		'file_location_id' => 'file_location_id',
		'user_company_id' => 'user_company_id',
		'contact_id' => 'contact_id',
		'project_id' => 'project_id',

		'virtual_file_name' => 'virtual_file_name',
		'virtual_file_path' => 'virtual_file_path',
		'virtual_file_mime_type' => 'virtual_file_mime_type',

		'modified' => 'modified',
		'created' => 'created',
	);

	// Database Fields
	public $file_manager_file_id;

	public $file_location_id;
	public $user_company_id;
	public $contact_id;
	public $project_id;

	public $virtual_file_name;
	public $virtual_file_path;
	public $virtual_file_mime_type;

	public $modified;
	public $created;

	// Other properties
	protected $file;

	protected $compressed = false;

	protected $compressionLevel = 9;

	/**
	 * This is a temp location for the content while it is being saved.
	 * The content is saved in a compressed format.
	 *
	 * $_data holds the values that are INSERTED/UPDATED so this value
	 * is ignored during the save() operation.
	 *
	 * @var string
	 */
	protected $uncompressed_content;

	/**
	 * Constructor.
	 */
	public function __construct($database, $table='file_manager_files')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	/**
	 * Filter out bad filename/filepath chars \ / : * ? " < > |
	 *
	 * @param unknown_type $filepath
	 */
	public static function getFilteredVirtualFilePath($virtual_file_path)
	{
		$tempFilepath = str_replace('\\', '/', $virtual_file_path);
		$arrTempFilepath = preg_split('#[\/]+#', $tempFilepath, -1, PREG_SPLIT_NO_EMPTY);

		$arrFilteredFilepath = array();
		foreach ($arrTempFilepath as $tmpNode) {
			$pathNode = preg_replace('#[\/\\\:\*\?\"\>\<]#', '', $tmpNode);
			$arrFilteredFilepath[] = $pathNode;
		}

		if (count($arrFilteredFilepath) > 1) {
			$filteredVirtualFilePath = join('/', $arrFilteredFilepath);
		} else {
			$filteredVirtualFilePath = array_pop($arrFilteredFilepath);
		}
		$filteredVirtualFilePath = '/'.$filteredVirtualFilePath.'/';

		return $filteredVirtualFilePath;
	}

	public function setFile($file)
	{
		$this->file = $file;
	}

	public function getFile()
	{
		$file = $this->file;

		return $file;
	}

	public static function frontEndWrite($filePath, $fileName, $fileId)
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$basePath = $config->system->file_manager_base_path;

		$session = Zend_Registry::get('session');
		/* @var $session Session */

		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();

		$frontEndPath = $basePath.'frontend/'.$user_company_id.$filePath;

		// file is stored as a text file with its id value embedded
		$fileContents = $fileId;

		$file = new File();
		$file->fwrite($frontEndPath, $fileName, $fileContents);
	}

	public static function frontEndMove($oldPath, $newPath, $fileName)
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$basePath = $config->system->file_manager_base_path;

		$session = Zend_Registry::get('session');
		/* @var $session Session */

		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();

		$oldName = $basePath.'frontend/'.$user_company_id.'/'.$oldPath.$fileName;
		$newName = $basePath.'frontend/'.$user_company_id.'/'.$newPath.$fileName;

		$successFlag = rename($oldName, $newName);

		return $successFlag;
	}

	public static function frontEndRename($filePath, $existingFileName, $newFileName)
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$basePath = $config->system->file_manager_base_path;

		$session = Zend_Registry::get('session');
		/* @var $session Session */

		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();

		$oldName = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$existingFileName;
		$newName = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$newFileName;

		$successFlag = rename($oldName, $newName);

		return $successFlag;
	}

	public static function frontEndCopy($filePath, $existingFileName, $newFileName)
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$basePath = $config->system->file_manager_base_path;

		$session = Zend_Registry::get('session');
		/* @var $session Session */

		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();

		$existingName = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$existingFileName;
		$newName = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$newFileName;

		$successFlag = copy($existingName, $newName);

		return $successFlag;
	}

	public static function frontEndDelete($filePath, $fileName)
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$basePath = $config->system->file_manager_base_path;

		$session = Zend_Registry::get('session');
		/* @var $session Session */

		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();

		$file = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$fileName;

		$successFlag = unlink($file);

		return $successFlag;
	}

	public static function saveFileToCloud($database, $fileUploadName, File $file)
	{
		// Get sha1 of the file as a binary string
		$file_sha1 = sha1_file($_FILES[$fileUploadName]['tmp_name']);

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `id`
FROM `file_locations`
WHERE `file_sha1` = '$file_sha1'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['id']) && !empty($row['id'])) {
			$file_location_id = $row['id'];
		} else {
			// Save file into the CAS and inert into db
			// Simulate CAS storage using a local file store for now
			/**
			 * @todo ADD CAS FILE STORAGE VIA S3 OR LINODE
			 */
			$fileLocation = new FileLocation($database);
			$fileLocation->file_sha1 = $file_sha1;
			$fileLocation->convertPropertiesToData();
			$fileLocation['created'] = null;
			$file_location_id = $fileLocation->save();

			$config = Zend_Registry::get('config');
			/* @var $config Config */

			$file_manager_base_path = $config->system->file_manager_base_path;
			$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

			$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;

			//$this->file_location_id = $file_location_id;
			$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
			$filePath = $arrFilePath['file_path'];
			$fileName = $arrFilePath['file_name'];

			// Will be eventually copying over to cloud vendor here...
			$successFlag = FileManager::moveUploadedFile($file, $filePath, $fileName);
		}

		return $file_location_id;
	}

	public static function saveUploadedFileToCloud($database, File $file, $checkNot = true)
	{
		// Debug
		//$ajaxError = json_encode(array('error'=> "Temp File Path: $tempFilePath\nTemp File Sha1 Hash: $file_sha1"));
		//exit($ajaxError);

		$file_sha1 = $file->sha1;
		$tempFilePath = $file->tempFilePath;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `id`
FROM `file_locations`
WHERE `file_sha1` = '$file_sha1'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['id']) && !empty($row['id'])) {
			$file_location_id = $row['id'];
		} else {
			// Save file into the CAS and inert into db
			// Simulate CAS storage using a local file store for now
			/**
			 * @todo ADD CAS FILE STORAGE VIA S3 OR LINODE
			 */
			//record should not be inerted if sha1 or filesize is zero
			if(($file_sha1=="")||($file->size==0) ||($file->size==""))
			{
				//File Location should not insert for these Record
				$file_location_id="0";
				$ajaxError = json_encode(array('error'=> 'File upload failed.'));
				exit($ajaxError);
			}else{
		
			$fileLocation = new FileLocation($database);
			$fileLocation->file_sha1 = $file_sha1;
			$fileLocation->file_size = $file->size;
			$fileLocation->convertPropertiesToData();
			$fileLocation['created'] = null;
			$file_location_id = $fileLocation->save();

			$config = Zend_Registry::get('config');
			/* @var $config Config */

			$file_manager_backend_storage_protocol = $config->system->file_manager_backend_storage_protocol;
			$file_manager_backend_timer_benchmark = $config->system->file_manager_backend_timer_benchmark;
			$file_manager_backend_sync_to_all_nodes = $config->system->file_manager_backend_sync_to_all_nodes;

			if ($file_manager_backend_timer_benchmark == 'Y' && $checkNot) {
				$timer = $_SESSION['timer'];
				$timer->stopTimer();
				$totalTime = $timer->fetchFormattedTimerOutput();
				$timeMessage = "Total Time: $totalTime\n\n";
				//echo $timeMessage;
				//Log::write($timeMessage);
				$timer->startTimer();
			}

			switch ($file_manager_backend_storage_protocol) {
				case 'cURL':
					// copy file to the cloud via cURL
					$successFlag = self::copyUploadedFileToBackendStorageManagerViaCurl($file, $tempFilePath, $file_location_id);
					break;

				case 'FTP':
					// copy file to the cloud via FTP
					$successFlag = self::copyUploadedFileToBackendStorageManagerViaFtp($file, $tempFilePath, $file_location_id);
					break;

				case 'LocalFileSystem':
					// copy file to the cloud via the filesystem (assumes app server is the backend storage server too)
					$successFlag = self::copyUploadedFileToBackendStorageManagerViaLocalFileSystem($file, $tempFilePath, $file_location_id);
					break;

				case 'NFS':
					// copy file to the cloud via NFS
					//$successFlag = self::copyUploadedFileToBackendStorageManagerViaNFS($file, $tempFilePath, $file_location_id);
					break;

				case 'RSync':
					// copy file to the cloud via RSync
					//$successFlag = self::copyUploadedFileToBackendStorageManagerViaRSync($file, $tempFilePath, $file_location_id);
					break;

				default:
					break;
			}

			if (isset($file_manager_backend_sync_to_all_nodes) && $file_manager_backend_sync_to_all_nodes && $file_manager_backend_storage_protocol == 'LocalFileSystem') {
				// copy file to the cloud via Ftp
				$successFlag = self::copyUploadedFileToBackendStorageManagerViaFtp($file, $tempFilePath, $file_location_id);
			}

			if ($file_manager_backend_timer_benchmark == 'Y' && $checkNot) {
				$timer->stopTimer();
				$totalTime = $timer->fetchFormattedTimerOutput();
				$timeMessage = "Total Time: $totalTime\n\n";
				//echo $timeMessage;
				//Log::write($timeMessage);

				$startTime = $timer->getStartTime();
				$endTime = $timer->getStopTime();

				Log_FileManagerBackend::recordTimeForFileManagerSaveFileToCloudOperation($database, $file_location_id, $file_manager_backend_storage_protocol, $startTime, $endTime);
				// @todo Potentially store these log files in a separate Database
				// Would need to eliminate foreign key references
				//Log_FileManagerBackend::recordTimeForFileManagerSaveFileToCloudOperation('log', $file_location_id, $file_manager_backend_storage_protocol, $startTime, $endTime);
			}
		}

		// Delete the temp file - a sha1 file match may have occurred so put outside the if/else block
		// It may not always get moved to the backend file location for various reasons
		if (is_file($tempFilePath)) {
			$tempFileDeletedFlag = unlink($tempFilePath);
		} else {
			$tempFileDeletedFlag = true;
		}
	}

		return $file_location_id;
	}

	public static function copyUploadedFileToBackendStorageManagerViaLocalFileSystem($file, $tempFilePath, $file_location_id)
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$file_manager_base_path = $config->system->file_manager_base_path;
		$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
		$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

		$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;

		$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
		$filePath = $arrFilePath['file_path'];
		$fileName = $arrFilePath['file_name'];
		$backendFilePath = $filePath.$fileName;

		// Copy over temp file to backend storage manager location
		// Recursively make directory if it doesn't exist.
		if (!is_dir($filePath)) {
			$filePermissions = $file->getPermissions();
			$flag = $file->mkdir($filePath, $filePermissions);
		} else {
			$flag = true;
		}
		if (!is_file($backendFilePath)) {
			$fileMovedFlag = copy($tempFilePath, $backendFilePath);
		} else {
			$fileMovedFlag = false;
		}

		return $fileMovedFlag;
	}

	public static function copyUploadedFileToBackendStorageManagerViaCurl($file, $tempFilePath, $file_location_id)
	{
		$fileSize = filesize($tempFilePath);

		// Use cURL to copy the file to beta server for now
		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */
		if($uri->sslFlag){
			$baseCdnUrl = $uri->https;
		}else{
			$baseCdnUrl = $uri->http;	
		}
		$url = $baseCdnUrl . "modules-file-manager-storage-manager.php?id=$file_location_id";

		/*
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		// same as <input type="file" name="uploaded_file">
		$post = array(
			"uploaded_file" => "@$tempFilePath"
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($ch);
		*/

		$ch = curl_init();
		$post = array('uploaded_file' => "@$tempFilePath");
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$response = curl_exec($ch);

		return $response;
	}

	/**
	 * This method assumes FTP.
	 *
	 * @param File $file
	 * @param string $tempFilePath
	 * @param int $file_location_id
	 * @return string
	 */
	public static function copyUploadedFileToBackendStorageManagerViaFtp($file, $tempFilePath, $file_location_id)
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$file_manager_base_path = $config->system->file_manager_base_path;
		$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
		$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

		$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;

		// FTP
		// E.g. "ftp://anonymous:password@beta.axisitonline.com/"
		// FTP starts at: "/var/ftp/"
		$ftp = $config->system->file_manager_backend_ftp;

		// FTP Path
		// E.g. "file_manager_backend/backend/data/"
		$file_manager_backend_ftp_storage_path = $config->system->file_manager_backend_ftp_storage_path;

		$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
		$shortFilePath = $arrFilePath['short_file_path'];
		$filePath = $arrFilePath['file_path'];
		$fileName = $arrFilePath['file_name'];


		/**
		 * @todo move file to temp location on storage node's disk
		 * @todo php exec ssh command to mv file to its actual location for CDN to prevent rogue uploads
		 */


		// FTP wrapper via ftp://
		// E.g. "ftp://anonymous:password@beta.axisitonline.com/file_manager_backend/backend/data/$shortFilePath"
		$ftpFolderPath = $ftp.$file_manager_backend_ftp_storage_path.$shortFilePath;

		$isDirFlag = is_dir($ftpFolderPath);
		if (!$isDirFlag) {
			// bool mkdir ( string $pathname [, int $mode = 0777 [, bool $recursive = false [, resource $context ]]] )
			$mkdirFlag = mkdir($ftpFolderPath, 0777, true);
		}

		$handleLocalRead = fopen($tempFilePath, "rb");
		$fullFtpFilePath = $ftp.$file_manager_backend_ftp_storage_path.$shortFilePath.$fileName;
		$handleRemoteFtpWrite = fopen($fullFtpFilePath, 'wb');

		if ($handleLocalRead && $handleRemoteFtpWrite) {
		    while (($buffer = fgets($handleLocalRead, 4096)) !== false) {
		        fwrite($handleRemoteFtpWrite, $buffer);
		    }
		    if (!feof($handleLocalRead)) {
		        $response = false;
		    } else {
		    	$response = true;
		    }
		    fclose($handleLocalRead);
			fclose($handleRemoteFtpWrite);
		}

		return $response;
	}

	public static function copyFileFromBackendStorageManagerToFENodeTempDirViaFtp($file, $tempFilePath, $file_location_id)
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$file_manager_base_path = $config->system->file_manager_base_path;
		$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
		$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

		$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;

		// FTP
		// E.g. "ftp://anonymous:password@beta.axisitonline.com/"
		// FTP starts at: "/var/ftp/"
		$file_manager_backend_ftp = $config->system->file_manager_backend_ftp;

		// FTP Path
		// E.g. "file_manager_backend/backend/data/"
		$file_manager_backend_ftp_storage_path = $config->system->file_manager_backend_ftp_storage_path;

		// Derive path the file in the cloud backend.
		$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
		$shortFilePath = $arrFilePath['short_file_path'];
		$filePath = $arrFilePath['file_path'];
		$fileName = $arrFilePath['file_name'];

		// Get the complete FTP path to the file.
		// E.g. "ftp://anonymous:password@beta.axisitonline.com/file_manager_backend/backend/data/37/_8"
		$fullFtpFilePath = $file_manager_backend_ftp.$file_manager_backend_ftp_storage_path.$shortFilePath.$fileName;
		$fileExistsFlag = is_file($fullFtpFilePath);
		if (!$fileExistsFlag) {
			return false;
		}
		$handleRemoteFtpRead = fopen($fullFtpFilePath, 'rb');
		$handleLocalWrite = fopen($tempFilePath, "wb");

		if ($handleRemoteFtpRead && $handleLocalWrite) {
		    while (($buffer = fgets($handleRemoteFtpRead, 4096)) !== false) {
		        fwrite($handleLocalWrite, $buffer);
		    }
		    if (!feof($handleRemoteFtpRead)) {
		        $response = false;
		    } else {
		    	$response = true;
		    }
		    fclose($handleRemoteFtpRead);
			fclose($handleLocalWrite);
		}

		return $response;
	}

	public static function copyFileFromBackendStorageManagerToFENodeTempDirViaLocalFileSystem($file, $tempFilePath, $file_location_id)
	{
		$arrFilePath = FileLocation::createFilePathFromId($file_location_id);
		$filePath = $arrFilePath['file_path'];
		$fileName = $arrFilePath['file_name'];
		$backendFilePath = $filePath.$fileName;

		if (is_file($backendFilePath)) {
			$fileMovedFlag = copy($backendFilePath, $tempFilePath);
		} else {
			$fileMovedFlag = false;
		}

		return $fileMovedFlag;
	}

	/**
	 * full_content is saved as a compressed string so restore the
	 * uncompressed full_content back after a save operation.
	 *
	 */
	public function save()
	{
		// Don't write file contents to the database...it chokes after 6GB+
		// not an issue here...
		//$full_content = $this->full_content;
		//unset($this->full_content);
		$id = parent::save();

		// Save file contents to disk
		if (!isset($id)) {
			$id = $this->id;
		}

		return $id;
	}

	/**
	 * Form a file path with a folder path and a filename from the db primary key "id"
	 *
	 * e.g. 498847 -> J:/X/49/88/_47
	 *
	 * @param int $id
	 * @return string
	 */
	public static function createFilePathFromId($id, $fileManagerBackendFolderPath, $fileManagerFileNamePrefix)
	{
		if (!isset($id)) {
			// bad input
			echo "Bad input: $id";
			throw new Exception('Bad file input');
		}

		$arrPath = str_split($id, 2);
		$fileName = array_pop($arrPath);
		$fileName = $fileManagerFileNamePrefix.$fileName;
		$path = $fileManagerBackendFolderPath;
		$shortFilePath = '';
		foreach ($arrPath as $pathChunk) {
			$path .= $pathChunk.'/';
			$shortFilePath .= $pathChunk.'/';
		}

		$arrReturn = array(
			'short_file_path' => $shortFilePath,
			'file_path' => $path,
			'file_name' => $fileName
		);

		return $arrReturn;
	}

	public static function moveUploadedFile($file, $filePath, $fileName=false)
	{
		$name = $file->name;
		$tmp_name = $file->tmp_name;
		$finalPath = $filePath.$fileName;

		// Copy over temp file to backend storage manager location
		// Recursively make directory if it doesn't exist.
		if (!is_dir($filePath)) {
			$filePermissions = $file->getPermissions();
			$flag = $file->mkdir($filePath, $filePermissions);
		} else {
			$flag = true;
		}

		$fileMovedFlag = move_uploaded_file($tmp_name, $finalPath);

		return $fileMovedFlag;
	}

	public static function moveAjaxUploadedFile($file, $filePath, $fileName=false)
	{
		$tempFilePath = $file->tempFilePath;
		$backendFilePath = $filePath.$fileName;

		// Debug
		//$ajaxError = json_encode(array('error'=> "File Path: $filePath\nFile Name: $fileName\nBackend File Path: $backendFilePath\nTemp File Path: $tempFilePath"));
		//exit($ajaxError);

		// Copy over temp file to backend storage manager location
		// Recursively make directory if it doesn't exist.
		if (!is_dir($filePath)) {
			$filePermissions = $file->getPermissions();
			$flag = $file->mkdir($filePath, $filePermissions);
		} else {
			$flag = true;
		}
		$fileMovedFlag = rename($tempFilePath, $backendFilePath);

		// Debug
		//$ajaxError = json_encode(array('error'=> "File Moved Flag: $fileMovedFlag"));
		//exit($ajaxError);

		// delete temp file if it wasn't moved to the backend file location for some reason
		if (is_file($tempFilePath)) {
			$tempFileDeletedFlag = unlink($tempFilePath);
		} else {
			$tempFileDeletedFlag = true;
		}

		// Debug
		//$ajaxError = json_encode(array('error'=> "Temp File Deleted Flag: $tempFileDeletedFlag"));
		//exit($ajaxError);

		return $fileMovedFlag;
	}

	public function moveUploadedFile2($fileUploadDirectory, $fileName=false)
	{
		$this->fileUploadDirectory = $fileUploadDirectory;

		$name = $this->name;
		$tmp_name = $this->tmp_name;

		if ($fileName) {
			$this->fileName = $fileName;
			$fileExtension = File::extractFileExtension($fileName);
			$this->fileExtension = $fileExtension;
		} else {
			// derive the fileName value from an MD5 hash of the file binary
			$md5 = md5_file($tmp_name);
			$fileExtension = File::extractFileExtension($name);
			$this->fileExtension = $fileExtension;
			$fileName = $md5.'.'.$fileExtension;
			$this->fileName = $fileName;
		}

		// could add a check to see if the file already exists
		$filePath = $fileUploadDirectory.$fileName;
		$this->filePath = $filePath;
		$filePathExists = is_file($filePath);
		if ($filePathExists) {
			$existingMd5 = md5_file($filePath);
			if ($md5 == $existingMd5) {
				unlink($tmp_name);
				return $filePath;
			}
		}
		if (move_uploaded_file($tmp_name, $filePath)) {
			return $filePath;
		} else {
			return false;
		}
	}

	public function setCompressed($boolean)
	{
		$boolean = (bool) $boolean;
		$this->compressed = $boolean;
	}

	public static function compressFullContentField()
	{
		$document = new Web_Robot_Documents();
		$db = $document->getDb();

		$query = 'SELECT d.`url`, d.`full_content`, d.`modified` '.
				 'FROM web_robot_documents d ';
				 //"WHERE `url`='http://shop.kingston.com/memtype_parts.asp?type=DIMM%2C3%2C%2C&SUBMIT1=Find'";
		$db->query($query);
		$arrRecords = array();
		while($row = $db->fetch()) {
			$arrRecords[] = $row;
		}
		$db->free_result();
		$db->reset();

		$counter = 0;
		foreach ($arrRecords as $record) {
			$url = $record['url'];
			//Don't need to update the url value
			unset($record['url']);

			$d = new Web_Robot_Documents();
			$d->setData($record);
			unset($record);
			$d->setCompressed(false);

			//Compression
			$full_content = $d->full_content;
			$d->compress($full_content);
			$d->full_content = $full_content;
			unset($full_content);

			$key = array('url' => $url);
			$d->setKey($key);
			$d->save();
			$counter++;
		}

		return $counter;
	}

	public static function findById( $id,$database, $table='file_manager_files', $class='FileManagerFiles' )
	{
		$document = new Web_Robot_Documents();
		$db = $document->getDb();

		$query = 'SELECT d.* '.
				 'FROM web_robot_documents d '.
				 'WHERE d.`id` = ? ';
		$arrValues = array($id);
		$db->execute($query, $arrValues);
		$row = $db->fetch();
		$db->free_result();
		$db->reset();
		unset($db);
		unset($query);
		unset($arrValues);

		if (isset($row) && !empty($row)) {
			$id = $row['id'];
			$url = $row['url'];
			$document->setData($row);
			$key = array('id' => $id);
			$document->setKey($key);
			unset($row);

			// Load file from file system
			$arrFilePath = Web_Robot_Documents::createFilePathFromId($id);
			$path = $arrFilePath['path'];
			$filename = $arrFilePath['filename'];
			$fullPath = $path.$filename;
			$full_content = File::fread($fullPath);
			$document->full_content = $full_content;
			unset($full_content);

			// Uncompress content
			$document->uncompress($document->full_content);
			$document->compressed = false;
		}

		return $document;
	}

	/**
	 * Load a record from its URL.
	 *
	 * @param Zend_Uri $uri
	 * @return Web_Robot_Documents object
	 */
	public static function findByUrl(Zend_Uri $uri)
	{
		if (!isset($uri)|| !($uri instanceof Zend_Uri)) {
			throw new Exception('Missing param');
		}

		/**
		 * Extract URL string.
		 */
		$url = $uri->getUri();

		$document = new Web_Robot_Documents();
		$db = $document->getDb();

		$query = 'SELECT d.* '.
				 'FROM web_robot_documents d '.
				 'WHERE d.url = ? ';
		$arrValues = array($url);
		$db->execute($query, $arrValues);
		$row = $db->fetch();
		$db->free_result();
		$db->reset();
		unset($db);
		unset($query);
		unset($arrValues);

		if (isset($row) && !empty($row)) {
			$id = $row['id'];
			$url = $row['url'];
			$document->setData($row);
			$key = array('url' => $url);
			$document->setKey($key);
			unset($row);

			// Load file from file system
			$arrFilePath = Web_Robot_Documents::createFilePathFromId($id);
			$path = $arrFilePath['path'];
			$filename = $arrFilePath['filename'];
			$fullPath = $path.$filename;
			$full_content = File::fread($fullPath);
			$document->full_content = $full_content;
			unset($full_content);

			// Uncompress content
			$document->uncompress($document->full_content);
			$document->compressed = false;
		}

		return $document;
	}

	/**
	 * Compression of full_content is transparently handled in the following methods:
	 *
	 * 1) public function prepareDocumentForSave(Web_Robot $bot)
	 * 2) public function save()
	 * 3) public static function findByUrl(Zend_Uri $uri) methods.
	 *
	 * @param Web_Robot $bot
	 */
	public function prepareDocumentForSave(Web_Robot $bot)
	{
		// Extract needed objects and data.
		$uri = $bot->getUri();
		$referer = $bot->getReferer();
		$fullContent = $bot->getFullContent();

		$client = $bot->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		$request = $client->getLastRequest();
		$response = $client->getLastResponse();
		/* @var $response Zend_Http_Response */

		// Prepare variables.
		$url = $uri->getUri();
		$url = str_replace(':80', '', $url);
		$parentUrl = $referer->getUri();
		$parentUrl = str_replace(':80', '', $parentUrl);
		$webRobotName = $bot->getRobotName();
		$type = $bot->getType();
		$date = (string) $response->getHeader('date');
		$lastModified = (string) $response->getHeader('last-modified');
		$expires = (string) $response->getHeader('expires');
//		$fullContent = $response->getBody();
		$sha1 = sha1($fullContent);
		$size = strlen($fullContent);
		$etag = (string) $response->getHeader('etag');
		$contentEncoding = (string) $response->getHeader('content-encoding');
		$contentType = (string) $response->getHeader('content-type');

		// Perform insert/update operation via save() method
		$this->url = $url;
		$this->parent_url = $parentUrl;
		$this->web_robot_name = $webRobotName;
		$this->type = $type;

		// Compress content
		// Want to retain uncompressed content for processing
		$this->uncompressed_content = $fullContent;
		$this->compress($fullContent);

		$this->full_content = $fullContent;
		$this->server_response_date = $date;
		$this->last_modified = $lastModified;
		$this->expires = $expires;
		$this->sha1 = $sha1;
		$this->file_size = $size;
		$this->e_tag = $etag;
		$this->content_encoding = $contentEncoding;
		$this->content_type = $contentType;
	}

	/**
	 * Compress content using GZIP OR ZLIB compression.
	 *
	 * @param string $content
	 */
	public function compress(& $content)
	{
		if (!$this->compressed) {
			$content = gzdeflate($content, $this->compressionLevel);
			$this->compressed = true;
		}

		//Test Cases: gzdeflate barely edged out the others on average.
		//$deflate = gzdeflate($content, 9);
		//$encode = gzencode($content, 9);
		//$compress = gzcompress($content, 9);
	}

	/**
	 * Decompress content using GZIP OR ZLIB compression.
	 *
	 * @param string $content
	 */
	public function uncompress(& $content)
	{
		$tmp = $content;
		$tmp = gzinflate($tmp);

		// gzinflate() returns false upon failure...file might not have been
		// compressed to begin with.
		if ($tmp) {
			$content = $tmp;
		}
	}

	public static function createCompressedArchive($pathToFolderToCompress, $outputDirectory, $archiveName)
	{
		// #zip -r archive_name ./path/to/folders
		// Check if $outputDirectory exists
		if (!is_dir($outputDirectory)) {
			$fTmp = new File();
			$fTmp->mkdir($outputDirectory);
		}

		// Zip input folder
		// windows or linux determines what method to use for unzipping
		// Debug
		//$os = 'Linux';
		$operatingSystem = Application::getOperatingSystem();
		if ($operatingSystem == 'Windows') {
			// windows
			$config = Zend_Registry::get('config');
			/* @var $config Config */

			$fileManagerBasePath = $config->system->file_manager_base_path;
			$zipBatFilePath = $fileManagerBasePath.'temp/'.'zip.bat';
			//$cmd = $zipBatFilePath.' '.$outputDirectory.' '.$archiveName;

			$pathToFolderToCompress = str_replace('/', '\\', $pathToFolderToCompress);
			$outputDirectory = str_replace('/', '\\', $outputDirectory);
			$archivePath = $outputDirectory.$archiveName;
			//$cmd = '"C:\Program Files\PowerArchiver\POWERARC" -a -s '."$archivePath $pathToFolderToCompress ";
			$cmd = '"C:\Program Files\PowerArchiver\POWERARC" -a '."$archivePath $pathToFolderToCompress ";
			// "C:\Program Files\PowerArchiver\POWERARC" -a -s %fullfilepath% %p%
			$WshShell = new COM("WScript.Shell");
			$oExec = $WshShell->Run("cmd /C $cmd ", 3, true);
		} else {
			$archiveName = str_replace('.zip', '', $archiveName);
			$archivePath = $outputDirectory.$archiveName;
			$arrPathToFolderToCompress = explode('/', $pathToFolderToCompress);
			$folderToCompress = array_pop($arrPathToFolderToCompress);
			$folderToCompress = './'.$folderToCompress.'/';
			$pathToFolderToCompress = join('/', $arrPathToFolderToCompress);
			$pathToFolderToCompress = '/'.$pathToFolderToCompress.'/';
			$cmd = "cd $pathToFolderToCompress; /usr/bin/zip -r $archivePath $folderToCompress";
			shell_exec($cmd);
		}

		return;
	}

	public static function extractCompressedArchive($database, $user_company_id, $contact_id, $project_id, $virtual_file_name, $virtual_file_path, $path, $file, $outputDirectory='')
	{
		// Check if $outputDirectory exists
		if (!is_dir($outputDirectory)) {
			$fTmp = new File();
			$fTmp->mkdir($outputDirectory);
		}

		// Unzip file
		// windows or linux determines what method to use for unzipping
		// Debug
		//$os = 'Linux';
		$operatingSystem = Application::getOperatingSystem();
		if ($operatingSystem == 'Windows') {
			// windows
			$config = Zend_Registry::get('config');
			/* @var $config Config */

			$fileManagerBasePath = $config->system->file_manager_base_path;
			$unzipBatFilePath = $fileManagerBasePath.'temp/'.'unzip.bat';
			$cmd = $unzipBatFilePath.' '.$outputDirectory.' '.$file;
			// Debug -- temp commented out
			/**/
			$WshShell = new COM("WScript.Shell");
			// Temporary hack ... move the file
			copy($path.$file, $outputDirectory.$file);
			$oExec = $WshShell->Run("cmd /C $cmd ", 3, true);
			// Delete the zip file itself
			unlink($outputDirectory.$file);
			/**/
		} else {
			// Parse file type based upon extension
			$arrFileType = explode('.', $virtual_file_name);
			$fileExtension = array_pop($arrFileType);
			switch ($fileExtension) {
				case 'zip':
					$cmd = '/usr/bin/unzip -d '.$outputDirectory.' '.$path.$file;
					break;
				case 'gz':
					$cmd = '/usr/bin/gunzip '.$path.$file;
					break;
				default:
					$cmd = '/usr/bin/gunzip '.$path.$file;
					break;
			}

			/*
			// gunzip has issues with files not having the .gz extension...
			// Execute command to unzip the file
			$tmpGz = uniqid().'.gz';
			copy($path.$file, $tmpGz);
			$cdCmd = "cd $outputDirectory";
			shell_exec($cdCmd);
			*/
			shell_exec($cmd);
		}

		// Iterate over the extracted files and folders and inject into the database
		/**
		 * @todo DELETE FILES FROM THE EXTRACT_TO FOLDER AFTER INSERT INTO DB
		 */
		if (is_dir($outputDirectory)) {
			// Recursively delete hidden MACOSX and .svn files and folders, etc. before our other operations
			self::deleteHiddenFiles($outputDirectory);

			self::copyDirectoryContentsIntoVirtualFileSystem($database, $user_company_id, $contact_id, $project_id, $virtual_file_path, $outputDirectory);

			// Recursively delete the temp folders and files
			self::recursivelyDeleteDirectory($outputDirectory);
		}

		/*
		if (!empty($outputDirectory)) {
			$d = dir($outputDirectory);
			while (false !== ($entry = $d->read())) {
				if (($entry != '.') && ($entry != '..')) {
					$existingFileName = $full_path.$entry;
					$newFileName = $dataFeedFilePath;
					if (is_file($newFileName)) {
						$flag = unlink($newFileName);
					}
					$flag = rename($existingFileName, $newFileName);
				}
			}
			$d->close();
		}
		*/

		return;
	}

	public static function copyDirectoryContentsIntoVirtualFileSystem($database, $user_company_id, $contact_id, $project_id, $virtual_file_path, $folderPath)
	{
		// Insert all records from the $folderPath and recurse over each folder found
		if (is_dir($folderPath)) {
			$arrFilesAndFolders = scandir($folderPath);
		} else {
			return;
		}

		$fileAndFoldersCount = count($arrFilesAndFolders);
		if ($fileAndFoldersCount == 2) {
			// save empty folder to file_manager_folders table
			$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $virtual_file_path);

			return;
		}

		foreach ($arrFilesAndFolders as $f) {
			if (($f == '.') || ($f == '..')) {
				continue;
			}

			$tmpPath = $folderPath.$f;
			if (is_file($tmpPath)) {
				$filePath = $tmpPath;
				// Copy file into file_manager_folders table
				$fileExtension = File::extractFileExtension($f);
				$mimeType = File::deriveMimeTypeFromFileExtension($fileExtension);

				$file = new File();
				$file->tempFilePath = $tmpPath;
				$file->type = $mimeType;

				// Get sha1 of the file as a binary string
				$tempFilePath = $file->tempFilePath;
				$file_sha1 = sha1_file($tempFilePath);

				//$virtual_file_path = $folderPath;
				$virtual_file_name = $f;
				$virtual_file_mime_type = $file->type;

				// Get a file_location_id and save the actual file to the cloud backend
				$file_location_id = self::saveUploadedFileToCloud($database, $file);

				if ($virtual_file_path == '/') {
					$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $virtual_file_path);
				} else {
					// Save the root folder "/" to the database (if not done so already)
					$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, '/');

					// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
					$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
					$currentVirtualFilePath = '/';
					foreach ($arrFolders as $folder) {
						$tmpVirtualFilePath = array_shift($arrFolders);
						$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
						// Save the file_manager_folders record (virtual_file_path) to the db and get the id
						$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $currentVirtualFilePath);
					}
				}

				// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
				/* @var $fileManagerFolder FileManagerFolder */
				$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;

				// save the file information to the file_manager_files db table
				$fileManagerFile = FileManagerFile::findByVirtualFileName($database, $user_company_id, $contact_id, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type);
				/* @var $fileManagerFolder FileManagerFolder */
				$file_manager_file_id = $fileManagerFile->file_manager_file_id;

				continue;
			}

			$tmpPath = $folderPath.$f.'/';
			if (is_dir($tmpPath)) {
				// Copy folder into file_manager_folders table and backend storage

				if ($virtual_file_path == '/') {
					$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $virtual_file_path);
				} else {
					// Save the root folder "/" to the database (if not done so already)
					$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, '/');

					// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
					$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
					$currentVirtualFilePath = '/';
					foreach ($arrFolders as $folder) {
						$tmpVirtualFilePath = array_shift($arrFolders);
						$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
						// Save the file_manager_folders record (virtual_file_path) to the db and get the id
						$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $currentVirtualFilePath);
					}
				}

				// Recurse over folder contents
				$sub_virtual_file_path = $virtual_file_path.$f.'/';
				$subFolderPath = $tmpPath;
				self::copyDirectoryContentsIntoVirtualFileSystem($database, $user_company_id, $contact_id, $project_id, $sub_virtual_file_path, $subFolderPath);
			}
		}

		return;
	}

	public static function deleteHiddenFiles($path)
	{
		// Get a list of all files and folders
		if (is_dir($path)) {
			$arrFilesAndFolders = scandir($path);
		} else {
			return;
		}

		foreach ($arrFilesAndFolders as $file) {
			if (($file == '.') || ($file == '..')) {
				continue;
			}

			$fullPath = $path.$file;
			if (is_dir($fullPath)) {
				// Check if the directory is a "hidden directory" such as "__MACOSX"
				if (($file == '__MACOSX') || ($file == '.svn')) {
					$tmpDir = $fullPath.'/';
					self::recursivelyDeleteDirectory($tmpDir);
					continue;
				} else {
					$tmpDir = $fullPath.'/';
					self::deleteHiddenFiles($tmpDir);
				}
			} elseif (is_file($fullPath)) {
				$hiddenFileFlag = false;
				$pos = strpos($file, '._', 0);
				if (is_int($pos) && $pos == 0) {
					$hiddenFileFlag = true;
				}
				if (($file == '.DS_Store') || ($file == 'Thumbs.db') || $hiddenFileFlag) {
					// delete the hidden OS specific file
					unlink($fullPath);
				}
			}
		}
	}

	public static function recursivelyDeleteDirectory($path)
	{
		//$tmpPath = $path . '*';
		$arrFilesAndFolders = scandir($path);
		foreach ($arrFilesAndFolders as $file) {
			if (($file == '.') || ($file == '..')) {
				continue;
			}

			$filePath = $path.$file;
			if (is_dir($filePath)) {
				$tmpDir = $filePath.'/';
				self::recursivelyDeleteDirectory($tmpDir);
			} elseif (is_file($filePath)) {
				// delete the temp file
				chmod($filePath, 0777);
				unlink($filePath);
			}
		}

		chmod($path, 0777);
		rmdir($path);
	}

	public static function hasChildFiles($path)
	{
		$arrFilesAndFolders = scandir($path);
		foreach ($arrFilesAndFolders as $file) {
			if (($file == '.') || ($file == '..')) {
				continue;
			}

			$filePath = $path.$file;
			if (is_file($filePath)) {
				return true;
			}
		}

		return false;
	}

	public static function getFolderContentsByType($path)
	{
		$arrFilesAndFolders = scandir($path);
		$arrFiles = array();
		$arrFolders = array();
		foreach ($arrFilesAndFolders as $file) {
			if (($file == '.') || ($file == '..')) {
				continue;
			}

			$filePath = $path.$file;
			if (is_file($filePath)) {
				$arrFiles[] = $file;
			} elseif (is_dir($filePath)) {
				$arrFolders[] = $file;
			}
		}

		$arrReturn = array(
			'files' => $arrFiles,
			'folders' => $arrFolders
		);

		return $arrReturn;
	}

	public static function recursivleyCrunchDownDirectory($path)
	{
		$fileObject = new File();

		$arrContents = self::getFolderContentsByType($path);
		$arrChildFiles = $arrContents['files'];
		$arrChildFolders = $arrContents['folders'];

		//$hasChildFiles = self::hasChildFiles($path);
		if (count($arrChildFiles) > 0) {
			$hasChildFiles = true;
		} else {
			$hasChildFiles = false;
		}
		if (count($arrChildFolders) > 0) {
			$hasChildFolders = true;
		} else {
			$hasChildFolders = false;
		}

		if ($hasChildFolders) {
			// recurse over child folders
			foreach ($arrChildFolders as $childFolder) {
				$childFolderPath = $path.$childFolder.'/';
				self::recursivleyCrunchDownDirectory($childFolderPath);
			}
		}

		if (!$hasChildFiles) {
			// move all subdirectories up a level
			$arrTmp = preg_split('#[/]+#', $path, -1, PREG_SPLIT_NO_EMPTY);
			array_pop($arrTmp);
			$parentFolder = join('/', $arrTmp);
			$parentFolder = '/'.$parentFolder.'/';

			// windows or linux determines what command to use
			// Debug
			//$os = 'Linux';
			$operatingSystem = Application::getOperatingSystem();
			if ($operatingSystem == 'Windows') {
				// windows
				$path = str_replace('/', '\\', $path);
				$parentFolder = str_replace('/', '\\', $parentFolder);
				$cmd = 'move '.$path.'* '.$parentFolder;
				$WshShell = new COM("WScript.Shell");
				$oExec = $WshShell->Run("cmd /C $cmd ", 3, true);
				rmdir($path);

				return;
			} else {
				$cmd = "mv $path/* $parentFolder/";
				shell_exec($cmd);
				rmdir($path);
			}


			// recurse over new paths?
		}

		return;

		//$tmpPath = $path . '*';
		$arrFilesAndFolders = scandir($path);
		foreach ($arrFilesAndFolders as $file) {
			if (($file == '.') || ($file == '..')) {
				continue;
			}

			$filePath = $path.$file;
			if (is_dir($filePath)) {
				$tmpDir = $filePath.'/';
				$arrSubFilesAndFolders = scandir($tmpDir);
				// Check file count and move subfolder up a level if file count is 0
				$fileCount = 0;
				$arrSubFolders = array();
				foreach ($arrSubFilesAndFolders as $tmpFile) {
					if (($tmpFile == '.') || ($tmpFile == '..')) {
						continue;
					}
					$tmpPath = $tmpDir.$tmpFile;
					if (is_file($tmpPath)) {
						$fileCount++;
					} elseif (is_dir($tmpPath)) {
						$tmpSubfolderPath = $tmpPath.'/';
						$arrSubFolders[] = $tmpSubfolderPath;
					}
				}

				if ($fileCount > 0) {
					self::recursivleyCrunchDownDirectory($tmpDir);
				} elseif ($fileCount == 0) {
					// move subfolders up one and delete current folder
					/*
					$arrTmp = preg_split('#[/]+#', $filePath, -1, PREG_SPLIT_NO_EMPTY);
					array_pop($arrTmp);
					$newFilePath = join('/', $arrTmp);
					$newFilePath = '/'.$newFilePath.'/';
					*/
					$arrNewSubfolders = array();
					foreach ($arrSubFolders as $subFolderPath) {
						$arrSubSubFilesAndFolders = scandir($subFolderPath);
						$arrTmp = preg_split('#[/]+#', $subFolderPath, -1, PREG_SPLIT_NO_EMPTY);
						$subFolder = array_pop($arrTmp);
						$newSubFolderPath = $path.$subFolder.'/';
						foreach ($arrSubSubFilesAndFolders as $tmpSubFile) {
							if (($tmpSubFile == '.') || ($tmpSubFile == '..')) {
								continue;
							}

							$oldSubFilePath = $subFolderPath.$tmpSubFile;
							$newSubFilePath = $newSubFolderPath.$tmpSubFile;
							$fileObject->mkdir($newSubFolderPath);
							chmod($newSubFolderPath, 0777);
							rename($oldSubFilePath, $newSubFilePath);
							//self::recursivleyCrunchDownDirectory($tmpDir);
						}
						$arrNewSubfolders[] = $newSubFolderPath;
					}
					chmod($filePath, 0777);
					self::recursivelyDeleteDirectory($tmpDir);
					foreach ($arrNewSubfolders as $newSubFolderPath) {
						// recurse
						self::recursivleyCrunchDownDirectory($newSubFolderPath);
					}
				}
			} elseif (is_file($filePath)) {
				//
			}
		}


		//chmod($path, 0777);
		//rmdir($path);
	}

	public static function recursivelyBuildFileSystemTree($path)
	{
		//$tmpPath = $path . '*';
		$arrFilesAndFolders = scandir($path);
		foreach ($arrFilesAndFolders as $file) {
			if (($file == '.') || ($file == '..')) {
				continue;
			}

			$filePath = $path.$file;
			if (is_dir($filePath)) {
				$tmpDir = $filePath.'/';
				self::recursivelyBuildFileSystemTree($tmpDir);
			} elseif (is_file($filePath)) {
				// delete the temp file
//				chmod($filePath, 0777);
//				unlink($filePath);
			}
		}

//		chmod($path, 0777);
//		rmdir($path);
	}

	/**
	 * Load parent documents.
	 *
	 */
	public function loadParents()
	{
	}

	/**
	 * Load child documents.
	 *
	 */
	public function loadChildren()
	{
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

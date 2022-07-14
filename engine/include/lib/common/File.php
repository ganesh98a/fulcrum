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
 * File and filesystem manipulation class.
 *
 * @category	File System
 * @package		File
 *
 */

class File extends AbstractWebToolkit {
	/**
	 * File handle.
	 *
	 * @var resource
	 */
	protected $_handle = null;

	/**
	 * File contents.
	 *
	 * @var string
	 */
	protected $_buffer = null;

	/**
	 * File permissions.
	 *
	 * @var string
	 */
	protected $_permissions = 0775;

	/**
	 * File umask.
	 *
	 * @var string
	 */
	protected $_umask = 0222;

	/**
	 * fopen read mode
	 *
	 * @var string
	 */
	protected $_read_mode = 'r';

	/**
	 * fopen write mode
	 *
	 * @var string
	 */
	protected $_write_mode = 'wb';

	/**
	 * File block size.
	 *
	 * @var string
	 */
	protected $_blockSize = null;

	/**
	 * Static Singleton instance variable
	 *
	 * @var File object
	 */
	protected static $_instance;

	protected static $_tempDir;

	protected static $_tempFileName;

	/**
	 * $_tempDir.$_tempFile
	 *
	 * @var unknown_type
	 */
	protected static $_tempFilePath;

	public $ajaxUploadFlag = false;

	protected static $arrMimeTypes = array(
		'ai'      => 'application/postscript',
		'aif'     => 'audio/x-aiff',
		'aifc'    => 'audio/x-aiff',
		'aiff'    => 'audio/x-aiff',
		'asc'     => 'text/plain',
		'asf'     => 'video/x-ms-asf',
		'asx'     => 'video/x-ms-asf',
		'au'      => 'audio/basic',
		'avi'     => 'video/x-msvideo',
		'bcpio'   => 'application/x-bcpio',
		'bin'     => 'application/octet-stream',
		'bmp'     => 'image/bmp',
		'bz2'     => 'application/x-bzip2',
		'cdf'     => 'application/x-netcdf',
		'chrt'    => 'application/x-kchart',
		'class'   => 'application/octet-stream',
		'cpio'    => 'application/x-cpio',
		'cpt'     => 'application/mac-compactpro',
		'csh'     => 'application/x-csh',
		'css'     => 'text/css',
		'dcr'     => 'application/x-director',
		'dir'     => 'application/x-director',
		'djv'     => 'image/vnd.djvu',
		'djvu'    => 'image/vnd.djvu',
		'dll'     => 'application/octet-stream',
		'dms'     => 'application/octet-stream',
		'doc'     => 'application/msword',
		'dvi'     => 'application/x-dvi',
		'dxr'     => 'application/x-director',
		'eps'     => 'application/postscript',
		'etx'     => 'text/x-setext',
		'exe'     => 'application/octet-stream',
		'ez'      => 'application/andrew-inset',
		'flv'     => 'video/x-flv',
		'gif'     => 'image/gif',
		'gtar'    => 'application/x-gtar',
		'gz'      => 'application/x-gzip',
		'hdf'     => 'application/x-hdf',
		'hqx'     => 'application/mac-binhex40',
		'htm'     => 'text/html',
		'html'    => 'text/html',
		'ice'     => 'x-conference/x-cooltalk',
		'ief'     => 'image/ief',
		'iges'    => 'model/iges',
		'igs'     => 'model/iges',
		'img'     => 'application/octet-stream',
		'iso'     => 'application/octet-stream',
		'jad'     => 'text/vnd.sun.j2me.app-descriptor',
		'jar'     => 'application/x-java-archive',
		'jnlp'    => 'application/x-java-jnlp-file',
		'jpe'     => 'image/jpeg',
		'jpeg'    => 'image/jpeg',
		'jpg'     => 'image/jpeg',
		'js'      => 'application/x-javascript',
		'kar'     => 'audio/midi',
		'kil'     => 'application/x-killustrator',
		'kpr'     => 'application/x-kpresenter',
		'kpt'     => 'application/x-kpresenter',
		'ksp'     => 'application/x-kspread',
		'kwd'     => 'application/x-kword',
		'kwt'     => 'application/x-kword',
		'latex'   => 'application/x-latex',
		'lha'     => 'application/octet-stream',
		'lzh'     => 'application/octet-stream',
		'm3u'     => 'audio/x-mpegurl',
		'man'     => 'application/x-troff-man',
		'me'      => 'application/x-troff-me',
		'mesh'    => 'model/mesh',
		'mid'     => 'audio/midi',
		'midi'    => 'audio/midi',
		'mif'     => 'application/vnd.mif',
		'mov'     => 'video/quicktime',
		'movie'   => 'video/x-sgi-movie',
		'mp2'     => 'audio/mpeg',
		'mp3'     => 'audio/mpeg',
		'mpe'     => 'video/mpeg',
		'mpeg'    => 'video/mpeg',
		'mpg'     => 'video/mpeg',
		'mpga'    => 'audio/mpeg',
		'ms'      => 'application/x-troff-ms',
		'msh'     => 'model/mesh',
		'mxu'     => 'video/vnd.mpegurl',
		'nc'      => 'application/x-netcdf',
		'odb'     => 'application/vnd.oasis.opendocument.database',
		'odc'     => 'application/vnd.oasis.opendocument.chart',
		'odf'     => 'application/vnd.oasis.opendocument.formula',
		'odg'     => 'application/vnd.oasis.opendocument.graphics',
		'odi'     => 'application/vnd.oasis.opendocument.image',
		'odm'     => 'application/vnd.oasis.opendocument.text-master',
		'odp'     => 'application/vnd.oasis.opendocument.presentation',
		'ods'     => 'application/vnd.oasis.opendocument.spreadsheet',
		'odt'     => 'application/vnd.oasis.opendocument.text',
		'ogg'     => 'application/ogg',
		'otg'     => 'application/vnd.oasis.opendocument.graphics-template',
		'oth'     => 'application/vnd.oasis.opendocument.text-web',
		'otp'     => 'application/vnd.oasis.opendocument.presentation-template',
		'ots'     => 'application/vnd.oasis.opendocument.spreadsheet-template',
		'ott'     => 'application/vnd.oasis.opendocument.text-template',
		'pbm'     => 'image/x-portable-bitmap',
		'pdb'     => 'chemical/x-pdb',
		'pdf'     => 'application/pdf',
		'pgm'     => 'image/x-portable-graymap',
		'pgn'     => 'application/x-chess-pgn',
		'php'     => 'text/plain',
		'png'     => 'image/png',
		'pnm'     => 'image/x-portable-anymap',
		'ppm'     => 'image/x-portable-pixmap',
		'ppt'     => 'application/vnd.ms-powerpoint',
		'ps'      => 'application/postscript',
		'qt'      => 'video/quicktime',
		'ra'      => 'audio/x-realaudio',
		'ram'     => 'audio/x-pn-realaudio',
		'ras'     => 'image/x-cmu-raster',
		'rgb'     => 'image/x-rgb',
		'rm'      => 'audio/x-pn-realaudio',
		'roff'    => 'application/x-troff',
		'rpm'     => 'application/x-rpm',
		'rtf'     => 'text/rtf',
		'rtx'     => 'text/richtext',
		'sgm'     => 'text/sgml',
		'sgml'    => 'text/sgml',
		'sh'      => 'application/x-sh',
		'shar'    => 'application/x-shar',
		'silo'    => 'model/mesh',
		'sis'     => 'application/vnd.symbian.install',
		'sit'     => 'application/x-stuffit',
		'skd'     => 'application/x-koan',
		'skm'     => 'application/x-koan',
		'skp'     => 'application/x-koan',
		'skt'     => 'application/x-koan',
		'smi'     => 'application/smil',
		'smil'    => 'application/smil',
		'snd'     => 'audio/basic',
		'so'      => 'application/octet-stream',
		'spl'     => 'application/x-futuresplash',
		'src'     => 'application/x-wais-source',
		'stc'     => 'application/vnd.sun.xml.calc.template',
		'std'     => 'application/vnd.sun.xml.draw.template',
		'sti'     => 'application/vnd.sun.xml.impress.template',
		'stw'     => 'application/vnd.sun.xml.writer.template',
		'sv4cpio' => 'application/x-sv4cpio',
		'sv4crc'  => 'application/x-sv4crc',
		'swf'     => 'application/x-shockwave-flash',
		'sxc'     => 'application/vnd.sun.xml.calc',
		'sxd'     => 'application/vnd.sun.xml.draw',
		'sxg'     => 'application/vnd.sun.xml.writer.global',
		'sxi'     => 'application/vnd.sun.xml.impress',
		'sxm'     => 'application/vnd.sun.xml.math',
		'sxw'     => 'application/vnd.sun.xml.writer',
		't'       => 'application/x-troff',
		'tar'     => 'application/x-tar',
		'tcl'     => 'application/x-tcl',
		'tex'     => 'application/x-tex',
		'texi'    => 'application/x-texinfo',
		'texinfo' => 'application/x-texinfo',
		'tgz'     => 'application/x-gzip',
		'tif'     => 'image/tiff',
		'tiff'    => 'image/tiff',
		'torrent' => 'application/x-bittorrent',
		'tr'      => 'application/x-troff',
		'tsv'     => 'text/tab-separated-values',
		'txt'     => 'text/plain',
		'ustar'   => 'application/x-ustar',
		'vcd'     => 'application/x-cdlink',
		'vrml'    => 'model/vrml',
		'wav'     => 'audio/x-wav',
		'wax'     => 'audio/x-ms-wax',
		'wbmp'    => 'image/vnd.wap.wbmp',
		'wbxml'   => 'application/vnd.wap.wbxml',
		'wm'      => 'video/x-ms-wm',
		'wma'     => 'audio/x-ms-wma',
		'wml'     => 'text/vnd.wap.wml',
		'wmlc'    => 'application/vnd.wap.wmlc',
		'wmls'    => 'text/vnd.wap.wmlscript',
		'wmlsc'   => 'application/vnd.wap.wmlscriptc',
		'wmv'     => 'video/x-ms-wmv',
		'wmx'     => 'video/x-ms-wmx',
		'wrl'     => 'model/vrml',
		'wvx'     => 'video/x-ms-wvx',
		'xbm'     => 'image/x-xbitmap',
		'xht'     => 'application/xhtml+xml',
		'xhtml'   => 'application/xhtml+xml',
		'xls'     => 'application/vnd.ms-excel',
		'xlsx'    => 'application/vnd.ms-excel',
		'xer'    => 'application/vnd.ms-excel',
		'xml'     => 'text/xml',
		'xpm'     => 'image/x-xpixmap',
		'xsl'     => 'text/xml',
		'xwd'     => 'image/x-xwindowdump',
		'xyz'     => 'chemical/x-xyz',
		'zip'     => 'application/zip'
	);

	/**
	 * Static factory method to return an instance of the object.
	 *
	 * @return Singleton object reference
	 */
	public static function getInstance()
	{
		$instance = self::$_instance;

		if (!isset($instance)) {
			$instance = new File();
			self::$_instance = $instance;
		}

		return $instance;
	}

	public static function getTempDirectory()
	{
		$tempDir = self::$_tempDir;

		if (!isset($tempDir)) {
			$config = Zend_Registry::get('config');
			$tempDir = $config->system->file_manager_base_path.'temp/';
			self::$_tempDir = $tempDir;
		}

		return $tempDir;
	}

	public static function setTempDirectory($tempDir)
	{
		self::$_tempDir = $tempDir;
	}

	public static function getTempFileName($newTempFile=false)
	{
		$tempFileName = self::$_tempFileName;

		if ($newTempFile) {
			$tempFileName = null;
		}

		if (!isset($tempFileName)) {
			$tempFileName = uniqid();
			self::$_tempFileName = $tempFileName;
		}

		return $tempFileName;
	}

	public static function setTempFileName($tempFileName)
	{
		self::$_tempFileName = $tempFileName;
	}

	public static function getTempFilePath($newTempFile=false)
	{
		$tempFilePath = self::$_tempFilePath;

		if ($newTempFile || !isset($tempFilePath)) {
			$tempDir = self::getTempDirectory();
			$tempFileName = self::getTempFileName($newTempFile);
			$tempFilePath = $tempDir.$tempFileName;
			self::$_tempFilePath = $tempFilePath;
		}

		return $tempFilePath;
	}

	public static function setTempFilePath($tempFilePath)
	{
		self::$_tempFilePath = $tempFilePath;
	}

	public function getPermissions()
	{
		$permissions = $this->_permissions;

		return $permissions;
	}

	/**
	 * Write a file to disk.
	 *
	 * Attempt to be use a transaction safe technique.
	 *
	 */
	public function fwrite($path, $fileName, $contents)
	{
		$flag = false;
		if (isset($path) && isset($fileName) && isset($contents)) {
			// Recursively make directory if it doesn't exist.
			if (!is_dir($path)) {
				$flag = $this->mkdir($path, $this->_permissions);
			}
			$tmpPath = $path.$fileName.'.tmp';
			$fullPath = $path.$fileName;
			$handle = fopen($tmpPath, $this->_write_mode);
			fwrite($handle, $contents);
			unset($contents);
			fclose($handle);
			unset($handle);
			if (file_exists($fullPath)) {
				$flag = unlink($fullPath);
			}
			$flag = rename($tmpPath, $fullPath);
			unset($tmpPath);
			unset($fullPath);
			unset($path);
			unset($fileName);
		}

		return $flag;
	}

	/**
	 * Make a directory recursively.
	 *
	 * @param string $path
	 * @param int $permissions
	 * @return boolean
	 */
	public function mkdir($path, $permissions = 0775)
	{
		$flag = false;
		if (!file_exists($path)) {
			$this->mkdir(dirname($path), $permissions);
			$flag = mkdir($path, $permissions);
		} else {
			$flag = true;
		}

		return $flag;
	}

	// recursive make directory function for ftp
	public function mkdirFTP($ftp_stream, $dir)
	{
		// if directory already exists or can be immediately created return true
		if ($this->is_dirFTP($ftp_stream, $dir) || @ftp_mkdir($ftp_stream, $dir)) {
			return true;
		}

		// otherwise recursively try to make the directory
		if (!$this->mkdirFTP($ftp_stream, dirname($dir))) {
			return false;
		}

		// final step to create the directory
		$flag = ftp_mkdir($ftp_stream, $dir);
		return $flag;
	}

	public function is_dirFTP($ftp_stream, $dir)
	{
		// get current directory
		$original_directory = ftp_pwd($ftp_stream);
		// test if you can change directory to $dir

		// suppress errors in case $dir is not a file or not a directory
		if ( @ftp_chdir( $ftp_stream, $dir ) ) {
			// If it is a directory, then change the directory back to the original directory
			ftp_chdir( $ftp_stream, $original_directory );
			return true;
		} else {
			return false;
		}
	}

	public static function fread($path)
	{
		if (empty($path)) {
			return;
		}

		// get contents of a file into a string
		$handle = fopen($path, "rb");
		$contents = fread($handle, filesize($path));
		fclose($handle);

		return $contents;
	}

	public static function generateSha1Checksum($filePath)
	{
		// windows or linux/mac determines what method to use

		// Debug
		//$os = 'Linux';

		$operatingSystem = Application::getOperatingSystem();
		if ($operatingSystem == 'Windows') {
			// windows
			$outputFilePath = self::getTempFilePath(true);
			$cmd = "sha1sum $filePath > $outputFilePath";
			$WshShell = new COM("WScript.Shell");
			$oExec = $WshShell->Run("cmd /C $cmd ", 3, true);
			$commandOutput = file_get_contents($outputFilePath);
			if (is_file($outputFilePath)) {
				unlink($outputFilePath);
			}
		} else {
			$cmd = "/usr/bin/sha1sum $filePath";

			// Execute command to unzip the file
			$commandOutput = shell_exec($cmd);
		}

		if (!empty($commandOutput)) {
			$arrTmp = explode(' ', $commandOutput);
			$sha1Hash = trim($arrTmp[0]);
		} else {
			$sha1Hash = '';
		}

		return $sha1Hash;
	}

	public static function extractFileExtension($filename)
	{
		$fileExtension = strrchr($filename, '.');
		$fileExtension = substr($fileExtension, 1);
		$fileExtension = strtolower($fileExtension);

		switch ($fileExtension) {
			case 'jpeg':
			case 'jpg':
				$fileExtension = 'jpg';
				break;

			case 'gif':
			case 'giff':
				$fileExtension = 'gif';
				break;

			default:
				break;
		}

		return $fileExtension;
	}

	public static function deriveMimeTypeFromFileExtension($fileExtension)
	{
		$arrMimeTypes = self::$arrMimeTypes;
		if (isset($arrMimeTypes[$fileExtension])) {
			$mimeType = $arrMimeTypes[$fileExtension];
		} else {
			$mimeType = '';
		}

		return $mimeType;
	}

	function rrmdir($directory, $empty = false) {
	    if (substr($directory,-1) == "/") {
	        $directory = substr($directory,0,-1);
	    }

	    if (!file_exists($directory) || !is_dir($directory)) {
	        return false;
	    } elseif (!is_readable($directory)) {
	        return false;
	    } else {
	        $directoryHandle = opendir($directory);

	        while ($contents = readdir($directoryHandle)) {
	            if ($contents != '.' && $contents != '..') {
	                $path = $directory . "/" . $contents;

	                if (is_dir($path)) {
	                    $this->rrmdir($path);
	                } else {
	                    unlink($path);
	                }
	            }
	        }

	        closedir($directoryHandle);

	        if ($empty == false) {
	            if (!rmdir($directory)) {
	                return false;
	            }
	        }

	        return true;
	    }
	}

	public function delete2($path) {
		if (!file_exists($path)) {
			return;
		}

		$directoryIterator = new DirectoryIterator($path);

		foreach ($directoryIterator as $fileInfo) {
			$filePath = $fileInfo->getPathname();
			if (!$fileInfo->isDot()) {
				if ($fileInfo->isFile()) {
					unlink($filePath);
				} elseif ($fileInfo->isDir()) {
					if ($this->emptyDirectory($filePath)) {
						// Close the handle

						rmdir($filePath);
					} else {
						$this->delete($filePath);
					}
				}
			}
		}

		if (is_dir($path)) {
			// Close the handle
			$path = str_replace('\\', '/', $path);
			closedir(opendir($path));
			rmdir($path);
		} elseif (is_file($path)) {
			unlink($path);
		}
	}

	public static function parseUploadedFilesToBeDeleted()
	{
		if (!isset($_FILES) || empty($_FILES)) {
			return array();
		}

		$arrUploadedFiles = $_FILES;
		$arrFiles = array();
		foreach ($arrUploadedFiles as $formFileInputName => $uploadedFile) {
			// Uploaded file attributes
			$error = $uploadedFile['error'];
			$name = $uploadedFile['name'];
			$size = $uploadedFile['size'];
			$tmp_name = $uploadedFile['tmp_name'];
			$type = $uploadedFile['type'];
			$valid = is_uploaded_file($tmp_name);

			if ($valid) {
				// Put each file into a File object
				$f = new File();
				$f->form_input_name = $formFileInputName;
				$f->error = $error;
				$f->name = $name;
				$f->size = $size;
				$f->tmp_name = $tmp_name;
				$f->type = $type;

				$arrFiles[] = $f;
			} else {
				// delete the file
				unlink($tmp_name);
			}
		}

		return $arrFiles;
	}

	// @todo Refactor File to use $tempDirectoryPrefix here???
	public static function parseUploadedFiles($tempDirectoryPrefix='')
	{
		$ajaxBasedFileUpload = false;
		$formBasedFileUpload = false;

		if (isset($_SERVER['HTTP_X_FILE_NAME']) && !empty($_SERVER['HTTP_X_FILE_NAME'])) {
			$uploadedFileName = $_SERVER['HTTP_X_FILE_NAME'];
		} else {
			$uploadedFileName = false;
		}
		if (isset($_SERVER['CONTENT_LENGTH']) && !empty($_SERVER['CONTENT_LENGTH'])) {
			$uploadedFileSize = $_SERVER['CONTENT_LENGTH'];
		} else {
			$uploadedFileSize = false;
		}

		// Debug
		//$ajaxError = json_encode(array('error'=> "Uploaded File Name: $uploadedFileName\nUploaded File Size: $uploadedFileSize"));
		//exit($ajaxError);

		// Verify that a file was uploaded via ajax RAW HTTP POST or HTTP PUT
		if (isset($uploadedFileName) && !empty($uploadedFileName) && isset($uploadedFileSize) && !empty($uploadedFileSize)) {
			$ajaxBasedFileUpload = true;
			$formBasedFileUpload = false;
		} elseif (isset($_FILES) & !empty($_FILES)) {
			$ajaxBasedFileUpload = false;
			$formBasedFileUpload = true;
		}

		// Debug - Simulate file update for testing - Set to true to test.
		$simulateFileUploadFlag = false;
		//$simulateFileUploadFlag = true;
		if ($simulateFileUploadFlag) {
			$ajaxBasedFileUpload = true;
			$uploadedFileName = 'Sunset.jpg';
			$uploadedFileSize = 71189;
		}

		if (!$ajaxBasedFileUpload && !$formBasedFileUpload) {
			return array();
		}

		$arrFiles = array();

		if ($formBasedFileUpload) {
			$arrUploadedFiles = $_FILES;
			foreach ($arrUploadedFiles as $formFileInputName => $uploadedFile) {
				// Uploaded file attributes
				$error = $uploadedFile['error'];
				$name = $uploadedFile['name'];
				$size = $uploadedFile['size'];
				$tmp_name = $uploadedFile['tmp_name'];
				$type = $uploadedFile['type'];
				$valid = is_uploaded_file($tmp_name);

				if ($valid) {
					$tempFilePath = $tmp_name;
					$uploadedFileName = $name;
					// Mime Type
					$fileExtension = self::extractFileExtension($uploadedFileName);
					$mimeType = self::deriveMimeTypeFromFileExtension($fileExtension);
					if (isset($mimeType) && !empty($mimeType)) {
						$type = $mimeType;
					}

					// Get sha1 of the file as a binary string
					//$tempFilePath = $file->tempFilePath;
					$file_sha1 = sha1_file($tempFilePath);

					// Put each file into a File object
					$f = new File();
					$f->sha1 = $file_sha1;
					$f->form_input_name = $formFileInputName;
					$f->error = $error;
					$f->name = $name;
					$f->size = $size;
					$f->tmp_name = $tmp_name;
					$f->type = $type;
					$f->tempFilePath = $tempFilePath;
					$f->fileExtension = $fileExtension;

					$arrFiles[] = $f;
				} else {
					// delete the file
					unlink($tmp_name);
				}
			}

		} elseif ($ajaxBasedFileUpload) {

			// copy the byte stream from php://input to a temp file just like a standard file upload
			$tempFilePath = self::getTempFilePath();
			$tempFileName = self::getTempFileName();

			// Debug
			//$ajaxError = json_encode(array('error'=> "Temp Folder: $tempFolder\nTemp File Name: $tempFileName\nTemp File Path: $tempFilePath"));
			//exit($ajaxError);

			// PUT data comes in on the stdin stream
			// Debug
			if ($simulateFileUploadFlag) {
				$putdata = fopen('C:/Documents and Settings/All Users/Documents/My Pictures/Sample Pictures/Sunset.jpg', 'r');
				//$putdata = fopen('C:/Documents and Settings/All Users/Documents/My Pictures/Sample Pictures/Winter.jpg', 'r');
			} else {
				$putdata = fopen("php://input", "r");
			}

			// Open a file for writing
			$fp = fopen($tempFilePath, "wb");

			// Read the data 1 KB at a time and write to the file
			while ($data = fread($putdata, 1024)) {
				fwrite($fp, $data);
				fflush($fp);
			}

			// Close the streams
			fclose($fp);
			fclose($putdata);

			// Mime Type
			//$type = mime_content_type($tempFilePath);
			$fileExtension = self::extractFileExtension($uploadedFileName);
			$mimeType = self::deriveMimeTypeFromFileExtension($fileExtension);

			// Debug
			//$ajaxError = json_encode(array('error'=> "File Extension: $fileExtension\nMime Type: $mimeType"));
			//exit($ajaxError);

			// Uploaded file attributes in $_FILES keys format
			$error = false;
			$name = $uploadedFileName;
			$size = $uploadedFileSize;
			$tmp_name = $tempFileName;
			$type = $mimeType;
			$valid = true;

			// Get sha1 of the file as a binary string
			//$tempFilePath = $file->tempFilePath;
			$file_sha1 = sha1_file($tempFilePath);

			// Place values into a File object
			$f = new File();
			$f->sha1 = $file_sha1;
			$f->ajaxUploadFlag = true;
			//$f->form_input_name = $formFileInputName;
			$f->error = $error;
			$f->name = $name;
			$f->size = $size;
			$f->tmp_name = $tmp_name;
			$f->type = $type;
			$f->tempFilePath = $tempFilePath;
			$f->fileExtension = $fileExtension;

			$arrFiles[] = $f;

		}

		// Debug
		//$ajaxError = json_encode(array('error'=> '$f: '."\n".print_r($f, true)."\n".'$arrFiles:'."\n".print_r($arrFiles, true)));
		//exit($ajaxError);

		return $arrFiles;
	}

	public function moveUploadedFile($fileUploadDirectory, $fileName=false)
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

	public function cropImage($newWidth, $newHeight)
	{
		$filePath = $this->filePath;
		$fileExtension = $this->fileExtension;

		switch ($fileExtension) {
			case 'jpg':
				$srcImage = imagecreatefromjpeg($filePath);
				break;

			case 'png':
				$srcImage = imagecreatefrompng($filePath);
				break;

			case 'gif':
				$srcImage = imagecreatefromgif($filePath);
				break;

			default:
				$srcImage = imagecreatefromjpeg($filePath);
				break;
		}

		// crop the image to the imput dimensions
		// Get new dimensions
		list($width, $height) = getimagesize($filePath);
		$ratio_orig = $width/$height;
		if ($newWidth/$newHeight > $ratio_orig) {
			$newWidth = $newHeight*$ratio_orig;
		} else {
			$newHeight = $newWidth/$ratio_orig;
		}

		$tmpImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($tmpImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		$newFileName = 'thumb-'.$this->fileName;
		$newFileName = str_replace('.jpg', '.png', $newFileName);
		$fileUploadDirectory = $this->fileUploadDirectory;
		$newFilePath = $fileUploadDirectory.$newFileName;

		//imagejpeg($tmpImage, $newFilePath, 100);
		imagepng($tmpImage, $newFilePath);

		imagedestroy($srcImage);
		imagedestroy($tmpImage);

		// overlay the original image on top of the drop shadow
		//imagecopymerge($shadow_image, $newFilePath, 0,0, 0,0, $newWidth, $newHeight, 100);


		// add chmod to image file...

		// create and return a new file object with the cropped images information
		$newFile = new File();
		$newFile->fileExtension = 'jpg';
		$newFile->fileName = $newFileName;
		$newFile->filePath = $newFilePath;
		$newFile->fileUploadDirectory = $fileUploadDirectory;

		$this->croppedImage = $newFile;
	}

	/**
	 * Format a capacity for MB or GB
	 *
	 * @param int $capacity
	 * @return string
	 */
	public static function formatFileSize($file_size)
	{
		if (isset($file_size) && !empty($file_size)) {
			$formattedFileSize = $file_size;
			if ($file_size >= 1000000000) {
				$formattedFileSize = ($file_size / (1024*1024*1024));
				$formattedFileSize = floor($formattedFileSize);
				$formattedFileSize .= ' GB';
			} elseif ($file_size >= 1000000) {
				$formattedFileSize = ($file_size / (1024*1024));
				$formattedFileSize = floor($formattedFileSize);
				$formattedFileSize .= ' MB';
			} elseif ($file_size >= 1000) {
				$formattedFileSize = ($file_size / 1024);
				$formattedFileSize = floor($formattedFileSize);
				$formattedFileSize .= ' KB';
			} else {
				$formattedFileSize = $file_size . ' B';
			}
		} else {
			$formattedFileSize = 'N/A';
		}

		return $formattedFileSize;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

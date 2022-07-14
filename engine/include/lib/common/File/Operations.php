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
 * @category	Framework
 * @package		File
 *
 */

class File_Operations extends File
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'File_Operations';

	/**
	 * Default temp directory as defined in config.ini
	 *
	 * @var string
	 */
	protected static $_systemTempDirectoryBasePath;

	public static function getSystemTempDirectoryBasePath()
	{
		$_systemTempDirectoryBasePath = self::$_systemTempDirectoryBasePath;

		if (!isset($_systemTempDirectoryBasePath) || empty($_systemTempDirectoryBasePath)) {
			$config = Zend_Registry::get('config');
			$_systemTempDirectoryBasePath = $config->system->file_manager_base_path . 'temp/';
			self::$_systemTempDirectoryBasePath = $_systemTempDirectoryBasePath;
		}

		return $_systemTempDirectoryBasePath;
	}

	public static function setSystemTempDirectoryBasePath($_systemTempDirectoryBasePath)
	{
		self::$_systemTempDirectoryBasePath = $_systemTempDirectoryBasePath;
	}

	protected $_tempDirectory;

	public function getTempDirectory($appendRandomSubdirectory=false, $tempDirectoryAdditionalSubdirectory='', $forceNewTempDirectory=false)
	{
		$_tempDirectory = $this->_tempDirectory;

		$newTempDirectoryFlag = false;
		if (!isset($_tempDirectory) || empty($_tempDirectory)) {
			$newTempDirectoryFlag = true;
		}
		if ($forceNewTempDirectory) {
			$newTempDirectoryFlag = true;
		}

		if ($newTempDirectoryFlag) {
			$_systemTempDirectoryBasePath = self::getSystemTempDirectoryBasePath();

			if ($appendRandomSubdirectory) {
				$randomSubdirectory = uniqid();
			} else {
				$randomSubdirectory = '';
			}

			$_tempDirectory = $_systemTempDirectoryBasePath . 'temp/' . $randomSubdirectory . $tempDirectoryAdditionalSubdirectory;

			// Create the temp directory
			if (!is_dir($_tempDirectory)) {
				$flag = self::recursivelyCreateDirectory($_tempDirectory);
			} else {
				$flag = true;
			}
		}

		return $_tempDirectory;
	}

	public function setTempDirectory($_tempDirectory)
	{
		$this->_tempDirectory = $_tempDirectory;
	}

	protected $_tempFileName;

	public function getTempFileName($forceNewTempFileName=false, $more_entropy=false)
	{
		$_tempFileName = $this->_tempFileName;

		$newTempFileNameFlag = false;
		if (!isset($_tempFileName) || empty($_tempFileName)) {
			$newTempFileNameFlag = true;
		}
		if ($forceNewTempFileName) {
			$newTempFileNameFlag = true;
		}

		if ($newTempFileNameFlag) {
			$_tempFileName = uniqid('', $more_entropy);
		}

		return $_tempFileName;
	}

	public function setTempFileName($tempFileName)
	{
		self::$_tempFileName = $tempFileName;
	}

	/**
	 * $_tempDirectory . $_tempFileName
	 *
	 * @var unknown_type
	 */
	protected $_tempFilePath;

	public static function getTempFilePath()
	{

		return $this->_tempFilePath;
	}

	public static function setTempFilePath($_tempFilePath)
	{
		self::$_tempFilePath = $_tempFilePath;
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

	public function rrmdir($directory, $empty = false) {
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

	public static function recursivelyCreateDirectory($path, $permissions = 0775)
	{
		$fileOperations = File_Operations::getInstance();
		/* @var $fileOperations File_Operations*/

		$flag = $fileOperations->mkdir($path, $permissions);

		return $flag;
	}

	public static function recursivelyDeleteDirectory($directory, $empty = false)
	{
		$fileOperations = File_Operations::getInstance();
		/* @var $fileOperations File_Operations*/

		$flag = $fileOperations->rrmdir($directory, $empty);

		return $flag;
	}

	public static function recursivelyCreateFtpDirectory($ftp_stream, $directoryPath)
	{
		$fileOperations = File_Operations::getInstance();
		/* @var $fileOperations File_Operations*/

		$flag = $fileOperations->mkdirFTP($ftp_stream, $directoryPath);

		return $flag;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

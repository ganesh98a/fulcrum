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
 * Programmatically load, manipulate, and render PDF documents.
 *
 * @category   Framework
 * @package    PdfPhantomJS
 *
 */

/**
 * PhantomJS setup instructions on Windows:
 *
 * 1) Download phantomjs-1.9.2-windows binary and unzip.
 * 2) Place phantomjs.exe in a folder within the Windows PATH.
 * 		or
 * 3) Update the PATH on Windows to include phantomjs.exe binary.
 *
 * PhantomJS setup instructions on Linux:
 *
 * 1) Download phantomjs 2.* linux binary and unpack.
 * 2) Place phantomjs binary in a folder within the Linux PATH.
 *
 */

/**
 * Pdf_Abstract
 */
//require_once('lib/common/Pdf/Abstract.php');

/**
 * File
 */
require_once('lib/common/File.php');

/**
 * UniversallyUniqueIdentifier
 */
require_once('lib/common/UniversallyUniqueIdentifier.php');

//class PdfPhantomJS extends Pdf_Abstract
class PdfPhantomJS
{
	const LINUX_OS = 'Linux';
	const WINDOWS_OS = 'Windows';
	const PHANTOM_JS_REQUEST = 'request';

	protected static $_id = '76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
	protected static $_initializedFlag = false;
	protected static $_operatingSystem;
	protected static $_phantomJSBinary;
	protected static $_phantomJSBinaryIgnoreSsl = '--ssl-protocol=any --ignore-ssl-errors=true --web-security=false';
	protected static $_phantomJSJavaScriptController;
	protected static $_tempFilePathBaseDirectory;
	protected static $_pdfFilePathDefaultBaseDirectory;
	protected static $_http;
	protected static $_https;

	protected $_useSsl = false;

	protected $_arrPdfDocumentProperties = array(
		'_tempFileUrl' => 'url',
		'_completePdfFilePath' => 'completePdfFilePath',
		'_tempFileName' => 'tempFileName',

		'paperSize__width' => 'paperSize__width',
		'paperSize__height' => 'paperSize__height',
		'margin__top' => 'margin__top',
		'margin__left' => 'margin__left',
		'margin__right' => 'margin__right',
		'margin__bottom' => 'margin__bottom',
		'dynamicContent'=> 'dynamicContent',
		'logoContent' =>'logoContent',
		'pdfModule' => 'pdfModule',
	);

	protected $_debugMode = false;

	protected $_tempFileBasePath;
	protected $_tempFileName;
	protected $_tempFileSha1;
	protected $_tempFileUrl;
	protected $_completeTempFilePath;

	protected $_pdfBaseFilePath;
	protected $_pdfFileName;
	protected $_completePdfFilePath;

	protected $paperSize__width; // no need to send default = '8.5in'; we will use Letter
	protected $paperSize__height; // no need to send default = '11in'; we will use Letter
	protected $margin__top;
	protected $margin__right;
	protected $margin__bottom;
	protected $margin__left;
	protected $dynamicContent;
	protected $logoContent;
	protected $pdfModule;

	/**
	 * Set the js file that phantomJS will use on the command line.
	 *
	 * @param String $phantomJSJavaScriptController
	 */
	public static function setPhantomJSJavaScriptController($phantomJSJavaScriptController)
	{
		$initializedFlag = self::$_initializedFlag;
		if (!$initializedFlag) {
			self::init();
		}

		self::$_phantomJSJavaScriptController = $phantomJSJavaScriptController;
	}

	protected static function init()
	{
		$config = Zend_Registry::get('config');
		/* @var $config Config */

		$tempFilePathBaseDirectory = $config->system->file_manager_base_path . 'temp/pdf-temp-files/';
		self::$_tempFilePathBaseDirectory = $tempFilePathBaseDirectory;

		$pdfFilePathDefaultBaseDirectory = $config->system->base_directory . 'www/www.axis.com/downloads/temp/pdf-files/';
		self::$_pdfFilePathDefaultBaseDirectory = $pdfFilePathDefaultBaseDirectory;

		if (!is_dir($tempFilePathBaseDirectory)) {
			$file = new File();
			$file->mkdir($tempFilePathBaseDirectory);
		}

		if (!is_dir($pdfFilePathDefaultBaseDirectory)) {
			$file = new File();
			$file->mkdir($pdfFilePathDefaultBaseDirectory);
		}

		$http = $config->uri->http;
		$https = $config->uri->https;
		self::$_http = $http;
		self::$_https = $https;

		$operatingSystem = Application::getOperatingSystem();
		if ($operatingSystem == 'Windows') {

			$phantom_js_windows_binary = $config->pdf->phantomjs->phantom_js_windows_binary;
			$phantom_js_windows_javascript_controller = $config->pdf->phantomjs->phantom_js_windows_javascript_controller;

			self::$_operatingSystem = 'Windows';
			self::$_phantomJSBinary = $phantom_js_windows_binary;
			self::$_phantomJSJavaScriptController = $phantom_js_windows_javascript_controller;

		} else {

			$phantom_js_linux_binary = $config->pdf->phantomjs->phantom_js_linux_binary;
			$phantom_js_linux_javascript_controller = $config->pdf->phantomjs->phantom_js_linux_javascript_controller;

			self::$_operatingSystem = 'Linux';
			self::$_phantomJSBinary = $phantom_js_linux_binary;
			self::$_phantomJSJavaScriptController = $phantom_js_linux_javascript_controller;

		}

		self::$_initializedFlag = true;
	}

	public function __construct($useSsl=false)
	{
		// Create URL to image or pdf on the CDN
		$uri = Zend_Registry::get('uri');

		$this->_useSsl = $uri->sslFlag;

		$initializedFlag = self::$_initializedFlag;
		if (!$initializedFlag) {
			self::init();
		}
	}

	public function setDebugMode($booleanDebugMode)
	{
		$this->_debugMode = $booleanDebugMode;
	}

	public function getDebugMode()
	{
		$booleanDebugMode = $this->_debugMode;
		return $booleanDebugMode;
	}

	/*
	public function setProperties($properties) {
		$this->_properties = $properties;
	}
	*/

	public function setTempFileBasePath($tempFileBasePath)
	{
		$this->_tempFileBasePath = $tempFileBasePath;
	}

	public function getTempFileBasePath()
	{
		if (!isset($this->_tempFileBasePath)) {
			$this->_tempFileBasePath = self::$_tempFilePathBaseDirectory;
		}
		return $this->_tempFileBasePath;
	}

	/**
	 * save file contents to a template file on disk for
	 * phantomJS to read
	 *
	 */
	public function writeTempFileContentsToDisk($htmlContents, $file_sha1=null)
	{
		$tempFileBasePath = $this->getTempFileBasePath();

		if (!isset($file_sha1)) {
			$file_sha1 = sha1($htmlContents);
		}
		$tempFileName = $file_sha1 . '.html';
		$this->_tempFileName = $tempFileName;
		$this->_tempFileSha1 = $file_sha1;

		$completeTempFilePath = $tempFileBasePath . $tempFileName;
		$this->_completeTempFilePath = $completeTempFilePath;

		if (!is_file($completeTempFilePath)) {
			$file = new File();
			$flag = $file->fwrite($tempFileBasePath, $tempFileName, $htmlContents);
		} else {
			$flag = true;
		}

		return $flag;
	}

	/**
	 * delete the file with $htmlOutput
	 */
	public function deleteTempFile()
	{
		if (is_file($this->_completeTempFilePath)) {
			unlink($this->_completeTempFilePath);
		}
	}

	public function getCompleteTempFilePath()
	{
		return $this->_completeTempFilePath;
	}

	public function setTempFileName($tempFileName)
	{
		$this->_tempFileName = $tempFileName;
	}

	public function getTempFileName()
	{
		$tempFileName = $this->_tempFileName;
		return $tempFileName;
	}

	public function setTempFileSha1($tempFileSha1)
	{
		$this->_tempFileSha1 = $tempFileSha1;
	}

	public function getTempFileSha1()
	{
		$tempFileSha1 = $this->_tempFileSha1;
		return $tempFileSha1;
	}

	public function setTempFileUrl($tempFileUrl)
	{
		$this->_tempFileUrl = $tempFileUrl;
	}

	public function deriveTempFileUrl()
	{
		$urlAccessToken = self::$_id;

		$useSsl = $this->_useSsl;

		if ($useSsl) {
			$httpBase = self::$_https;
		} else {
			$httpBase = self::$_http;
		}

		$tempFileUrl = $httpBase . 'controllers/pdf-temp-file-reader.php?id=' . $urlAccessToken . '&tempFileName=' . $this->_tempFileName;

		$this->_tempFileUrl = $tempFileUrl;

		return $tempFileUrl;
	}

	public function getTempFileUrl()
	{
		if (isset($this->_tempFileUrl)) {
			$tempFileUrl = $this->_tempFileUrl;
		} else {
			$tempFileUrl = $this->deriveTempFileUrl();
		}

		return $tempFileUrl;
	}

	public function setPdfBaseFilePath($pdfBaseFilePath)
	{
		$this->_pdfBaseFilePath = $pdfBaseFilePath;
	}

	public function getPdfBaseFilePath()
	{
		$pdfBaseFilePath = $this->_pdfBaseFilePath;
		return $pdfBaseFilePath;
	}

	public function setPdfFileName($pdfFileName)
	{
		$this->_pdfFileName = $pdfFileName;
	}

	public function getPdfFileName()
	{
		$pdfFileName = $this->_pdfFileName;
		return $pdfFileName;
	}

	public function setCompletePdfFilePath($completePdfFilePath)
	{
		$this->_completePdfFilePath = $completePdfFilePath;
	}

	public function getCompletePdfFilePath()
	{
		$completePdfFilePath = $this->completePdfFilePath;
		return $completePdfFilePath;
	}

	public function setPdfPaperSize($documentWidth, $documentHeight)
	{
		if (!isset($documentWidth) && !isset($documentHeight)) {
			throw new Exception("Either required parameter width or height is missing");
		}
		$this->paperSize__width = $documentWidth;
		$this->paperSize__height = $documentHeight;

	}
	public function setPdffooter($val, $fulogo, $module = null)
	{
		$this->dynamicContent=$val;
		$this->logoContent =$fulogo;
		$this->pdfModule = $module;
	}

	public function setMargin($marginTop, $marginLeft, $marginRight, $marginBottom)
	{
		$this->margin__top = $marginTop;
		$this->margin__left = $marginLeft;
		$this->margin__right = $marginRight;
		$this->margin__bottom = $marginBottom;
	}

	public function setViewportDimension($viewportWidth, $viewportHeight)
	{
		if (!isset($viewportWidth) && !isset($viewportHeight)) {
			throw new Exception('Either required parameter width or height is missing.');
		}

		$this->viewportWidth = $viewportWidth;
		$this->viewportHeight = $viewportHeight;
	}

	public function getPhantomJSCommandLineCommand()
	{
		$useSsl = $this->_useSsl;

		$phantomJsBinary = self::$_phantomJSBinary;
		$phantomJSJavaScriptController = self::$_phantomJSJavaScriptController;
		if($useSsl)
		{
			$phantomJSBinaryIgnoreSsl = self::$_phantomJSBinaryIgnoreSsl;
			$command = $phantomJsBinary . ' ' . $phantomJSBinaryIgnoreSsl. ' '. $phantomJSJavaScriptController;
		}else{
			$command = $phantomJsBinary . ' ' . $phantomJSJavaScriptController;
		}
		
		return $command;
	}

	public function generateProperties()
	{
		$jsonParameterOptions = array();
		$jsonArrayKey = self::PHANTOM_JS_REQUEST;
		$arrPdfDocumentProperties = $this->_arrPdfDocumentProperties;

		foreach($arrPdfDocumentProperties as $documentProperty => $jsProperty) {
			if (isset($this->$documentProperty)) {
				$value = $this->$documentProperty;

				if (is_int(strpos($documentProperty, '__'))) {

					// e.g Pagesize__width into pagesize width in json
					list($parentElement, $childElement) = explode('__', $documentProperty);
					$jsonParameterOptions[$jsonArrayKey][$parentElement][$childElement] = $value;

				} else {
					$jsonParameterOptions[$jsonArrayKey][$jsProperty] = $value;
				}
			}
		}

		if ($this->_debugMode) {
			$jsonParameterOptions[$jsonArrayKey]['debugMode'] = 1;
		}

		return($jsonParameterOptions);
	}

	/**
	 * Render the PDF document via the PhantomJS command line tool.
	 *
	 * @return stdObject
	 */
	public function execute()
	{
		if (!isset($this->_tempFileUrl)) {
			$this->getTempFileUrl();

			if (!isset($this->_tempFileUrl)) {
				throw new Exception("Missing minimal required parameter: (1) url");
			}
		}

		$jsonParameterOptions = $this->generateProperties();
		$jsonEncodedParamaterOptions = json_encode($jsonParameterOptions);
		$osCommand = $this->getPhantomJSCommandLineCommand();

		$cmd = "$osCommand '$jsonEncodedParamaterOptions'";
		
		// you can run the program on command line:
		// just echo the $cmd and run it in shell
		// it is way faster to run it in shell
		if ($this->_debugMode) {
			echo "js command and parameters that send to the phantomJS. In case we need to run in command line to debug issue.\n";
			echo $cmd . "\n";
		}

		// Debug
		//exit;

		$commandExecutionResult = `$cmd`;

		if ($this->_debugMode) {
			$outputMessage = print_r($commandExecutionResult, true);
			echo "\n$outputMessage\n";
		}

		// return whether the command is success
		$jsonDecodedOutput = json_decode($commandExecutionResult);

		return $jsonDecodedOutput;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

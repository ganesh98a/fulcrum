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
 * Log errors to an error log file.
 *
 * @category	Log
 * @package		Log
 *
 */

/**
 * AbstractWebToolkit
 */
//require_once('lib/common/AbstractWebToolkit.php');

class Log extends AbstractWebToolkit {

	/**
	 * Static class instance variable for singleton pattern.
	 *
	 * @var Object Reference
	 */
	private static $_instance;
	protected $_errorLogPath;
	protected $_logger;
	protected $_zendLogWriterStream;
	protected $_arrErrorMessages;
	protected $_instanceName;

	public function getLogger()
	{
		if (isset($this->_logger)) {
			return $this->_logger;
		} else {
			return null;
		}
	}

	public function enqueueErrorMessage($message)
	{
		$this->_arrErrorMessages[] = $message;
	}

	public function dequeueErrorMessage($message)
	{
		array_pop($this->_arrErrorMessages);
	}

	public function getErrorLogPath()
	{
		if (isset($this->_errorLogPath)) {
			return $this->_errorLogPath;
		} else {
			return null;
		}
	}

	public function setErrorLogPath($path)
	{
		if (isset($path) && !empty($path)) {
			$this->_errorLogPath = $path;
		}
	}

	public static function getInstance($instanceName)
	{
		if (!isset(self::$_instance[$instanceName])) {
			self::$_instance[$instanceName] = new Log($instanceName);
		}
		return self::$_instance[$instanceName];
	}

	protected function __construct($instanceName)
	{
		$this->_instanceName = $instanceName;
		/**
		 * Zend_Log
		 */
		require_once('Zend/Log.php');

		/**
		 * Zend_Log_Writer_Stream
		 */
		require_once('Zend/Log/Writer/Stream.php');

		$config = Zend_Registry::get('config');
		if ($this->_instanceName == 'default') {
			$errorLogPath = $config->system->error_log;
		} else {
			$errorLogPath = $config->system->$instanceName;
		}
		$this->setErrorLogPath($errorLogPath);

		$logger = new Zend_Log();
		$writer = new Zend_Log_Writer_Stream($errorLogPath);
		$logger->addWriter($writer);

		$this->_logger = $logger;
	}

	public function __destruct()
	{
		$log = Log::getInstance($this->_instanceName);
		$log->close();
	}

	public function close()
	{
		$this->_logger = null;
	}

	/**
	 * Log a message to disk.
	 *
	 * $priority of 5 is Zend_Log::NOTICE
	 *
	 * @param string $errorMessage
	 * @param int $priority
	 */
	public static function write($errorMessage, $priority = 5, $instanceName = 'default')
	{
		$log = self::getInstance($instanceName);
		/* @var $log Log */

		$logger = $log->getLogger();
		//$errorMessage = $errorMessage . PHP_EOL;
		$errorMessage = $errorMessage . "\n";
		$logger->log($errorMessage, $priority);
		return;
	}

	public static function writeToDbLog($errorMessage)
	{
		$orm = new IntegratedMapper('log_application_errors');
		$orm->setDatabase('log');
		$sha1 = sha1($errorMessage);
		$key = array(
			'error_message_sha1' => $sha1
		);
		$orm->setKey($key);
		$orm->load();

		if ($orm->isDataLoaded()) {
			$occurrences = $orm->occurrences;
			$occurrences++;
			$data = array(
				'occurrences' => $occurrences
			);
		} else {
			$orm->setKey(null);
			$data = array(
				'error_message_sha1' => $sha1,
				'error_message' => $errorMessage,
				'created' => null,
			);
		}
		$orm->setData($data);
		$orm->save();
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

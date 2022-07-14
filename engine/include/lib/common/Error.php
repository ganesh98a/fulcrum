<?php
ini_set('MAX_EXECUTION_TIME', '-1');
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
 * Keep track of errors for:
 * Application errors.
 *
 *
 * Log all errors to disk or the database including 404 errors.
 *
 * @category	Error
 * @package		Error
 *
 */

/**
 * ErrorMessage
 */
require_once('lib/common/ErrorDetails.php');

class Error
{
	private static $_arrErrorTypesByErrorNumber = array(
		1 => array(
			'type' => 'E_ERROR',
			'priority' => 3
		),
		2 => array(
			'type' => 'E_WARNING',
			'priority' => 4
		),
		4 => array(
			'type' => 'E_PARSE',
			'priority' => 0
		),
		8 => array(
			'type' => 'E_NOTICE',
			'priority' => 5
		),
		16 => array(
			'type' => 'E_CORE_ERROR',
			'priority' => 0
		),
		32 => array(
			'type' => 'E_CORE_WARNING',
			'priority' => 1
		),
		64 => array(
			'type' => 'E_COMPILE_ERROR',
			'priority' => 0
		),
		128 => array(
			'type' => 'E_COMPILE_WARNING',
			'priority' => 4
		),
		256 => array(
			'type' => 'E_USER_ERROR',
			'priority' => 3
		),
		512 => array(
			'type' => 'E_USER_WARNING',
			'priority' => 4
		),
		1024 => array(
			'type' => 'E_USER_NOTICE',
			'priority' => 5
		),
		2048 => array(
			'type' => 'E_STRICT',
			'priority' => 3
		),
		4096 => array(
			'type' => 'E_RECOVERABLE_ERROR',
			'priority' => 3
		),
		8192 => array(
			'type' => 'E_DEPRECATED',
			'priority' => 4
		),
	);

	/**
	 * Static Singleton instance variable with class scope
	 *
	 * @var object reference
	 */
	private static $_instance;

	protected $_logAllErrors = false;

	protected $_logApplicationErrors = true;

	protected $_logUserErrors = false;

	protected $_logUserErrorsWhenApplicationErrorOccurs = false;

	protected $_trackSuppressedErrors = false;

	protected $_logSuppressedErrors = false;

	protected $_errorCount = 0;

	protected $_exitAfterErrorNumber;

	protected $_parseHtmlIds = true;

	protected $_outputAllErrors = false;

	protected $_debugMode = false;

	protected $_output_error_immediately_and_exit = false;

	protected $_output_backtrace = false;

	protected $_ajaxMode = false;

	protected $_backTrace = '';

	/**
	 * Ajax specific errors.
	 *
	 * May be JSON encoded or part of an HTTP 500 HTTP header.
	 *
	 * header('HTTP/1.1 500 AJAX_ERROR_MESSAGE_HERE', true, 500);
	 *
	 * @var string
	 */
	protected $_ajaxErrorMessage;

	public function getLogSuppressedErrors()
	{
		return $this->_logSuppressedErrors;
	}

	public function setLogSuppressedErrors($logSuppressedErrorsFlag)
	{
		$this->_logSuppressedErrors = $logSuppressedErrorsFlag;
	}

	public function getBackTrace()
	{
		return $this->_backTrace;
	}

	public function setBackTrace($backTrace)
	{
		$this->_backTrace = $backTrace;
	}

	/**
	 * Trap all application and script errors and store them here.
	 *
	 * @var array
	 */
	protected $_arrErrorsByType;

	public static function getArrErrorTypesByErrorNumber()
	{
		$arrErrorTypesByErrorNumber = self::$_arrErrorTypesByErrorNumber;
		return $arrErrorTypesByErrorNumber;
	}

	public static function getInstance()
	{
		// Check if a Singleton exists for this class
		$instance = self::$_instance;

		if (!isset($instance) || !($instance instanceof Error)) {
			$instance = new Error();
			self::$_instance = $instance;
		}

		return $instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct()
	{
		try {
			// Get object handle to the Session singleton object.
			$session = Zend_Registry::get('session');
			$debugMode = $session->getDebugMode();
		} catch(Exception $e) {
			$debugMode = false;
		}

		try {
			// Get object handle to the Config singleton object.
			$config = Zend_Registry::get('config');

			$ajaxMode = $config->script->ajax;

			// Operational mode of site.
			$operational_mode = $config->system->operational_mode;

			// Log mode of site.
			$log_mode = $config->system->log_mode;

			// Whether to immediately output and error and exit the script.
			$output_error_immediately_and_exit = (bool) $config->system->output_error_immediately_and_exit;

			$output_backtrace = (bool) $config->system->output_backtrace;

			// Error logging - always log script errors
			$log_errors_to_disk = $config->system->log_errors_to_disk;

			// Command line interface flag.
			$cli = $config->script->cli;
		} catch(Exception $e) {
			$ajaxMode = false;
			$operational_mode = 'production';
			$log_mode = 'log_application_errors_only';
			$output_error_immediately_and_exit = false;
			$cli = false;
		}

		if ((isset($operational_mode) && ($operational_mode == 'debug')) || $debugMode) {
			$debugFlag = true;
		} else {
			$debugFlag = false;
		}

		// logging modes: "log_all_errors", "log_application_errors_only", "log_user_errors_when_application_errors_occur"
		if ($log_mode == 'log_all_errors') {
			$this->_logAllErrors = true;
			$this->_logApplicationErrors = true;
			$this->_logUserErrors = true;
			$this->_logUserErrorsWhenApplicationErrorOccurs = true;
		} elseif ($log_mode == 'log_application_errors_only') {
			$this->_logAllErrors = false;
			$this->_logApplicationErrors = true;
			$this->_logUserErrors = false;
			$this->_logUserErrorsWhenApplicationErrorOccurs = false;
		} elseif ($log_mode == 'log_user_errors_when_application_errors_occur') {
			$this->_logAllErrors = false;
			$this->_logApplicationErrors = true;
			$this->_logUserErrors = false;
			$this->_logUserErrorsWhenApplicationErrorOccurs = true;
		}

		// (Session debugMode == true) or (operational_mode == debug) affects this
		$this->_debugMode = $debugFlag;

		$this->_output_backtrace = $output_backtrace;

		$this->_output_error_immediately_and_exit = $output_error_immediately_and_exit;

		$this->_ajaxMode = $ajaxMode;
	}

	public function storeError(ErrorDetails $errorDetails)
	{
		/* $errorDetails ErrorDetails */
		$errorType = $errorDetails->getErrorType();
		$this->_arrErrorsByType[$errorType][] = $errorDetails;
	}

	//$errorNumber, $errorMessage, $errorFile, $errorLine
	public function handleError($errorNumber, $errorMessage, $errorFile, $errorLine)
	{
		$this->_errorCount++;

		// @ suppresses an error so check if error_reporting() === 0
		$errorReporting = error_reporting();
		if ($errorReporting === 0) {
			$suppressedErrorFlag = true;
		} else {
			$suppressedErrorFlag = false;
		}

		$errorDetails = new ErrorDetails($errorNumber, $errorMessage, $errorFile, $errorLine, $suppressedErrorFlag);

		// @ suppresses an error so check if error_reporting() === 0
		//$errorReporting = error_reporting();
		if ($errorReporting === 0) {
			if ($this->_trackSuppressedErrors) {
				$this->storeError($errorDetails);
			}
			if ($this->_logSuppressedErrors) {
				$this->logError($errorDetails);
			}
			if ($this->_output_error_immediately_and_exit) {
				$this->outputErrorMessages();
				exit;
			}
			return;
		}

		$this->storeError($errorDetails);
		$this->logError($errorDetails);

		$errorReportingAndErrorNumber = ($errorReporting & $errorNumber);
		if (!$errorReportingAndErrorNumber) {
			// This error code is not included in error_reporting
			return;
		}

		if (isset($this->_exitAfterErrorNumber) && ($this->_exitAfterErrorNumber == $this->_errorCount)) {
			$this->outputErrorMessages();
			exit;
		}

		if ($this->_output_error_immediately_and_exit) {
			$this->outputErrorMessages();
			exit;
		}

		switch ($errorNumber) {
			// skip trigger_error()
			case E_USER_ERROR:
			case E_USER_WARNING:
			case E_USER_NOTICE:
				break;
			default:
				//$this->logError($errorDetails);
				break;
		}
	}

	/*
	public function __destruct()
	{

	}
	*/

	public function getAjaxErrorMessage()
	{

	}

	public function outputErrorMessages()
	{
		// Wipe the output buffer
		/**/
		while(ob_get_level()) {
			ob_end_clean();
		}
		/**/

		// Debug
		//$this->_debugMode = true;

		$message = Message::getInstance();
		/* @var $message Message */

		$backTraceErrorMessage = '';
		if ($this->_debugMode && $this->_output_backtrace) {
			$backTrace = $this->getBackTrace();

			if (!isset($backTrace) || empty($backTrace)) {
				try {
					throw New Exception('');
				} catch(Exception $e) {
					$backTrace = getExceptionTraceAsString($e);
				}
				//ob_start();
				//debug_print_backtrace();
				//$backTrace = ob_get_clean();
				$backTraceErrorMessage .= '[Back Trace]'.PHP_EOL;
				$backTraceErrorMessage .= print_r($backTrace, true);
				$backTraceErrorMessage .= PHP_EOL;
			}

			$backTraceErrorMessage = "[Back Trace]" . PHP_EOL . PHP_EOL . $backTrace;
		}

		$finalErrorMessage = '';
		if ($this->_debugMode || $this->_outputAllErrors) {
			$arrErrorMessages = $this->_arrErrorsByType;

			foreach ($arrErrorMessages as $errorType => $arrErrorDetails) {
				foreach ($arrErrorDetails as $errorDetails) {
					/* @var $errorDetails ErrorDetails */
					$errorMessage = $errorDetails->getFormattedErrorMessage();

					$finalErrorMessage .= PHP_EOL. "$errorMessage";
				}
			}
		}

		if ($this->_ajaxMode) {
			// Derive the $message queue "scope"
			try {
				// Get object handle to the URI singleton object.
				$uri = Zend_Registry::get('uri');
				$ajaxErrorScope = $uri->currentPhpScript;
			} catch(Exception $e) {
				$ajaxErrorScope = 'ajax-errors';
			}

			//global $message;
			//$message->sessionPut();
			$arrAjaxErrorMessages = array();
			$firstAjaxErrorMessage = '';
			while($ajaxErrorMessage = $message->dequeueError($ajaxErrorScope)) {
				$matchedFlag = false;
				if (is_int(strpos($ajaxErrorMessage, '|'))) {
					// This should be a field name corresponding to the DOM node "id", not the database id
					//$matchedFlag = preg_match('/^[0-9]+[|]{1}/', $ajaxErrorMessage);
					$matchedFlag = preg_match('/^.+[|]{1}/', $ajaxErrorMessage);
					if ($matchedFlag) {
						$firstAjaxErrorMessage = $ajaxErrorMessage;
					} else {
						$ajaxErrorMessage = str_replace('|', '', $ajaxErrorMessage);
					}
				}
				if (!$matchedFlag) {
					$arrAjaxErrorMessages[] = $ajaxErrorMessage;
				}
			}
			if (!empty($firstAjaxErrorMessage)) {
				array_unshift($arrAjaxErrorMessages, $firstAjaxErrorMessage);
			}
			// A php syntax error will commonly cause the the ajax error to be ""
			if (!empty($arrAjaxErrorMessages)) {
				$ajaxFinalErrorMessage = join('<br>', $arrAjaxErrorMessages);
				if (!is_int(strpos($ajaxFinalErrorMessage, '|'))) {
					//$ajaxFinalErrorMessage = "|$ajaxFinalErrorMessage";
				}
			} else {
				$ajaxFinalErrorMessage = '|An unknown error has occurred.';
			}

			if (isset($finalErrorMessage) && !empty($finalErrorMessage)) {
				$ajaxFormattedFinalErrorMessage = nl2br($finalErrorMessage);
				$ajaxFormattedFinalErrorMessage = str_replace('<br />', '<br>', $ajaxFormattedFinalErrorMessage);
				$ajaxFinalErrorMessage .= "$ajaxFormattedFinalErrorMessage";
			}

			if (isset($backTraceErrorMessage) && !empty($backTraceErrorMessage)) {
				$ajaxFormattedBackTraceErrorMessage = $backTraceErrorMessage;
				//$ajaxFormattedBackTraceErrorMessage = nl2br($backTraceErrorMessage);
				//$ajaxFormattedBackTraceErrorMessage = str_replace('<br />', '<br>', $ajaxFormattedBackTraceErrorMessage);
				$ajaxFinalErrorMessage .= "<br><br><textarea rows=\"20\" cols=\"240\">$ajaxFormattedBackTraceErrorMessage</textarea>";
			}

			// Send an HTTP 500 Internal Server Error header back to the Ajax JavaScript calling function
			header('HTTP/1.1 500 Internal Server Error', true, 500);
			echo $ajaxFinalErrorMessage;
		} else {
			echo $finalErrorMessage;
		}

		return;
	}

	public function outputAjaxErrorMessages()
	{
		// Wipe the output buffer
		while(ob_get_level()) {
			ob_end_clean();
		}

		// Update this to use a database logging system which increments a "unique log message"
		// Always log script errors to disk
		if ($phpScriptError || ($logError && $log_errors_to_disk)) {
			if ($ajaxFinalErrorMessage <> '|An unknown error has occurred.') {
				//$arrTmp = explode('|', $ajaxFinalErrorMessage);
				//$ajaxFinalErrorMessage = array_pop($arrTmp);
				//$logFileFormattedAjaxErrorMessage = str_replace('|', '', $ajaxFinalErrorMessage);
				$logFileFormattedAjaxErrorMessage = str_replace('<br>', PHP_EOL, $ajaxFinalErrorMessage);
				$errorMessage .=
					" Ajax Error Messages: $logFileFormattedAjaxErrorMessage".PHP_EOL;
			}
		}

		// Display error to ajax if in debug mode.
		if ( $debugFlag && ($errorNumber <> $E_USER_NOTICE) ) {
			$errorMessageHTML = nl2br($errorMessage);
			$ajaxFinalErrorMessage .= "<br>".$errorMessageHTML;
		}

		// Catch PHP script errors - always log them to disk or the db
		if ($errorNumber < 256) {
			$phpScriptErrorMessage =
				PHP_EOL.
				"PHP script error caught by ajax error handler.".PHP_EOL.
				" Error Code: $errorNumber".PHP_EOL.
				" File Path: $errorFile".PHP_EOL.
				" Line in File: $errorLine".PHP_EOL.
				" Error Messages: $errorMessage".PHP_EOL;

			try {
				$database = Zend_Registry::get('database');
				$db = DBI::getInstance($database);
				/* @var $db DBI_mysqli */
			} catch(Exception $e) {
				// continue
			}

			if (isset($db->throwExceptionOnDbError) && $db->throwExceptionOnDbError) {
				if ($debugFlag) {
					// Output the error message via ajax messaging
					$phpScriptErrorMessage = nl2br($phpScriptErrorMessage);
					$message->enqueueError($phpScriptErrorMessage . '', $ajaxErrorScope);
				}
				// Place the message back into the message queue since we are not outputting the message via HTTP 500 here.
				if (isset($arrAjaxErrorMessages) && !empty($arrAjaxErrorMessages)) {
					foreach ($arrAjaxErrorMessages as $tmpErrorMessage) {
						$message->enqueueError($tmpErrorMessage, $ajaxErrorScope);
					}
				}
				throw new Exception($errorMessage);
			}
		}

		header('HTTP/1.1 500 Internal Server Error', true, 500);
		echo $ajaxFinalErrorMessage;
		exit;
	}

	public function haltSystem()
	{
		echo 'System unavailable.';
		exit;
	}

	public function logError(ErrorDetails $errorDetails)
	{
		/*
		// Log errors to disk
		$E_USER_NOTICE = E_USER_NOTICE;
		if ($errorNumber == $E_USER_NOTICE) {
			$logError = false;
		} else {
			$logError = true;
		}
		*/

		try {
			$errorMessage = $errorDetails->getFormattedErrorMessage();
			$priority = $errorDetails->getPriority();
			require_once('lib/common/Log.php');
			Log::write($errorMessage, $priority);
		} catch (Exception $e) {
			// continue
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

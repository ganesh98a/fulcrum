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
 * Keep track of errors for:
 * Application errors.
 *
 *
 * Log all errors to disk or the database including 404 errors.
 *
 * @category	ErrorDetails
 * @package		ErrorDetails
 *
 */

class ErrorDetails
{
	protected $_errorNumber;
	protected $_errorMessage;
	protected $_errorFile;
	protected $_errorLine;
	protected $_phpScriptError;
	protected $_suppressedErrorFlag;
	protected $_errorType;
	protected $_priority;
	protected $_formattedErrorMessage;
	protected $_rawErrorMessage;

	/**
	 * A list of HTML id="" values for use with ajax, getback, and postback error messages.
	 *
	 * @var array
	 */
	protected $_arrHtmlElementIds;

	/**
	 * Constructor.
	 *
	 */
	public function __construct($errorNumber, $errorMessage, $errorFile, $errorLine, $suppressedErrorFlag=false)
	{
		//$error = Error::getInstance();
		/* @var $error Error */

		$this->_errorNumber = $errorNumber;
		$this->_errorMessage = $errorMessage;
		$this->_errorFile = $errorFile;
		$this->_errorLine = $errorLine;
		$this->_suppressedErrorFlag = $suppressedErrorFlag;

		// Parse out HTML element ids and create the formattedErrorMessage
		$this->parseHtmlElementIds();

		// Derive the error code from the $errorNumber
		$phpScriptError = true;
		$arrErrorTypesByErrorNumber = Error::getArrErrorTypesByErrorNumber();
		$arrErrorTypeDetails = $arrErrorTypesByErrorNumber[$errorNumber];
		$errorPriority = $arrErrorTypeDetails['priority'];
		$errorType = $arrErrorTypeDetails['type'];
		if ($errorType == 'E_USER_ERROR' || $errorType == 'E_USER_WARNING' || $errorType == 'E_USER_NOTICE') {
			$phpScriptError = false;
		}

		$this->_phpScriptError = $phpScriptError;
		$this->_errorType = $errorType;
		$this->_priority = $errorPriority;

		$this->deriveFormattedErrorMessage();
	}

	public function deriveFormattedErrorMessage()
	{
		// Log or display error message.
		$formattedErrorMessage =
			PHP_EOL.
			"[User Defined Error Handler Output]".PHP_EOL.
			" Error Type: $this->_errorType ($this->_errorNumber)".PHP_EOL.
			//" Error Code: $this->_errorNumber".PHP_EOL.
			" File Path: $this->_errorFile".PHP_EOL.
			" Line in File: $this->_errorLine".PHP_EOL.
			" Error Messages: $this->_errorMessage";

		$this->_formattedErrorMessage = $formattedErrorMessage;
	}

	public function getFormattedErrorMessage()
	{
		if (!isset($this->_formattedErrorMessage) || empty($this->_formattedErrorMessage)) {
			$this->deriveFormattedErrorMessage();
		}

		return $this->_formattedErrorMessage;
	}

	/*
	public function deriveErrorTypeAndPriority()
	{

	}
	*/

	public function getErrorType()
	{
		if (isset($this->_errorType)) {
			return $this->_errorType;
		} else {
			return null;
		}
	}

	public function getPriority()
	{
		if (isset($this->_priority)) {
			return $this->_priority;
		} else {
			return 5;
		}
	}

	public function parseHtmlElementIds()
	{
		if (!empty($this->_errorMessage)) {
			$this->_rawErrorMessage = $this->_errorMessage;
			$arrTmp = explode('|', $this->_errorMessage);
			$errorMessage = array_pop($arrTmp);
			$this->_errorMessage = $errorMessage;

			if (!empty($arrTmp)) {
				$this->addHtmlElementIds($arrTmp);
			}

		} else {
			$this->_formattedErrorMessage = '';
		}
	}

	public function addHtmlElementIds($arrIds)
	{
		$arrHtmlElementIds = $this->_arrHtmlElementIds;
		$arrHtmlElementIds = array_merge($arrHtmlElementIds, $arrIds);
		$this->_arrHtmlElementIds = $arrHtmlElementIds;
	}

	/*
	public function __destruct()
	{

	}
	*/
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * Globaly used functions for callbacks (including error handler "errorHandler").
 *
 * Global include for error handler, and exception handler.
 *
 * @category   Functions
 * @package    Error
 *
 *
 *
 */

//require_once('lib/common/Error.php');
//require_once('lib/common/ErrorDetails.php');

/**
 * Pass in an error message with "\n" EOL characters.
 *
 * @param string $msg
 * @param boolean $cliMode
 */
function formatErrorMessage($errorMessage='', $cliFlag=false)
{
	// Use <br> instead of "\n" when not in cli mode
	// EOL comes from PHP_EOL
	if (!$cliFlag) {
		// Use html5 <br>, not xhtml <br />
		// PHP 5.3.0+ nl2br($input, false);
		//$errorMessage = nl2br($errorMessage, false);
		$errorMessage = '<font color="#f71324"><pre>'.$errorMessage.'</pre></font>';
	}

	return $errorMessage;
}

function getExceptionTraceAsString($exception)
{
    $rtn = "";
    $count = 0;
    foreach ($exception->getTrace() as $frame) {
        $args = "";
        if (isset($frame['args'])) {
            $args = array();
            foreach ($frame['args'] as $arg) {
                if (is_string($arg)) {
                    $args[] = "'" . $arg . "'";
                } elseif (is_array($arg)) {
                    $args[] = "Array";
                } elseif (is_null($arg)) {
                    $args[] = 'NULL';
                } elseif (is_bool($arg)) {
                    $args[] = ($arg) ? "true" : "false";
                } elseif (is_object($arg)) {
                    $args[] = get_class($arg);
                } elseif (is_resource($arg)) {
                    $args[] = get_resource_type($arg);
                } else {
                    $args[] = $arg;
                }
            }
            $args = join(", ", $args);
        }
        $rtn .= sprintf( "#%s %s(%s): %s(%s)\n",
                                 $count,
                                 $frame['file'],
                                 $frame['line'],
                                 $frame['function'],
                                 $args );
        $count++;
    }
    return $rtn;
}

// Custom user defined PHP error handler for use with all requests including Ajax
function masterErrorHandler($errorNumber, $errorMessage, $errorFile, $errorLine)
{
	// Debug
	//return false;

	$error = Error::getInstance();
	$error->handleError($errorNumber, $errorMessage, $errorFile, $errorLine);

	/* Don't execute PHP internal error handler */
	return true;
}

// Set a custom user defined PHP error handler for use with Ajax requests
// Save the previous error hander function name into the variable "$existingErrorHandler" in case we want to set it back after our Ajax code block
// $existingErrorHandler = set_error_handler("ajaxErrorHandler", E_ALL);
function masterAjaxErrorHandler($errno, $errstr, $errfile, $errline)
{
	// @ suppresses an error so check if error_reporting() === 0
	$errorReporting = error_reporting();
	if ($errorReporting === 0) {
		return;
	}
	$errorReportingAndErrorNumber = ($errorReporting & $errno);
	if (!$errorReportingAndErrorNumber) {
		// This error code is not included in error_reporting
		return;
	}

	// Derive the error code from the errno
	$phpScriptError = true;
	switch ($errno) {
		case E_ERROR:
			$errorType = 'E_ERROR'; // 1
			$priority = 3;
			break;
		case E_WARNING:
			$errorType = 'E_WARNING'; // 2
			$priority = 4;
			break;
		case E_PARSE:
			$errorType = 'E_PARSE'; // 4
			$priority = 0;
			break;
		case E_NOTICE:
			$errorType = 'E_NOTICE'; // 8
			$priority = 5;
			break;
		case E_CORE_ERROR:
			$errorType = 'E_CORE_ERROR'; // 16
			$priority = 0;
			break;
		case E_CORE_WARNING:
			$errorType = 'E_CORE_WARNING'; // 32
			$priority = 1;
			break;
		case E_COMPILE_ERROR:
			$errorType = 'E_COMPILE_ERROR'; // 64
			$priority = 0;
			break;
		case E_COMPILE_WARNING:
			$errorType = 'E_COMPILE_WARNING'; // 128
			$priority = 4;
			break;
		case E_USER_ERROR:
			$errorType = 'E_USER_ERROR'; // 256
			$priority = 3;
			$phpScriptError = false;
			break;
		case E_USER_WARNING:
			$errorType = 'E_USER_WARNING'; // 512
			$priority = 4;
			$phpScriptError = false;
			break;
		case E_USER_NOTICE:
			$errorType = 'E_USER_NOTICE'; // 1024
			$priority = 5;
			$phpScriptError = false;
			break;
		case E_STRICT:
			$errorType = 'E_STRICT'; // 2048
			$priority = 3;
			break;
		case E_RECOVERABLE_ERROR:
			$errorType = 'E_RECOVERABLE_ERROR'; // 4096
			$priority = 3;
			break;
		case E_DEPRECATED:
			$errorType = 'E_DEPRECATED'; // 8192
			$priority = 4;
			break;
		default:
			$errorType = 'Unknown';
			$priority = 6;
			break;
	}

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

		// Operational mode of site.
		$mode = $config->system->operational_mode;

		// Error logging - always log script errors
		$log_errors_to_disk = $config->system->log_errors_to_disk;

		// Command line interface flag.
		$cli = $config->script->cli;
	} catch(Exception $e) {
		$mode = 'production';
		$debugMode = false;
		$cli = false;
	}

	$debugFlag = false;
	if ((isset($mode) && ($mode == 'debug')) || $debugMode) {
		$debugFlag = true;
	}

	// Log or display error message.
	$errorMessage =
		PHP_EOL.
		"[User Defined Error Handler Output]".PHP_EOL.
		" Error Type: $errorType ($errno)".PHP_EOL.
		//" Error Code: $errno".PHP_EOL.
		" File Path: $errfile".PHP_EOL.
		" Line in File: $errline".PHP_EOL.
		" Error Messages: $errstr".PHP_EOL;

	// Derive the $message queue "scope"
	// e.g. scope:modules-bid-list-manager-ajax.php:removeCompanyFromBidList
	if (is_int(strpos($errstr, 'scope:'))) {
		$arrTmp = explode(':', $errstr);
		if (isset($arrTmp[1]) && !empty($arrTmp[1])) {
			$ajaxErrorScope = trim($arrTmp[1]);
		} else {
			$ajaxErrorScope = 'ajax-errors';
		}
		if (isset($arrTmp[2]) && !empty($arrTmp[2])) {
			$ajaxMethodCall = trim($arrTmp[2]);
		} else {
			$ajaxMethodCall = null;
		}
		if (isset($arrTmp[3]) && !empty($arrTmp[3])) {
			$ajaxAdditionalErrorMessage = trim($arrTmp[3]);
		} else {
			$ajaxAdditionalErrorMessage = null;
		}
	} else {
		try {
			// Get object handle to the URI singleton object.
			$uri = Zend_Registry::get('uri');
			$ajaxErrorScope = $uri->currentPhpScript;
		} catch(Exception $e) {
			$ajaxErrorScope = 'ajax-errors';
		}

		/*
		// This does not work...e.g. "mysqli.php" for Database errors
		if (isset($errfile) && !empty($errfile)) {
			$tmp = str_replace('\\', '/', $errfile);
			$arrTmp = explode('/', $tmp);
			$ajaxErrorScope = array_pop($arrTmp);
			$ajaxErrorScope = trim($ajaxErrorScope);
		} else {
			$ajaxErrorScope = 'ajax-errors';
		}
		*/
		$ajaxMethodCall = null;
	}

	// Log errors to disk
	$E_USER_NOTICE = E_USER_NOTICE;
	if ($errno == $E_USER_NOTICE) {
		$logError = false;
	} else {
		$logError = true;
	}

	$message = Message::getInstance();
	/* @var $message Message */

	switch ($errno) {
		// Do the same action for all types of errors
		case E_USER_ERROR:
		case E_USER_WARNING:
		case E_USER_NOTICE:
		default:
			// Wipe the output buffer
			while(ob_get_level()) {
				ob_end_clean();
			}

			// Send an HTTP 500 Internal Server Error header back to the Ajax JavaScript calling function
			//header('HTTP/1.1 500 Internal Server Error', true, 500);
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
					$ajaxFinalErrorMessage = "|$ajaxFinalErrorMessage";
				}
			} else {
				$ajaxFinalErrorMessage = '|An unknown error has occurred.';
			}
			break;
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
		//if ($debugFlag || (!$debugFlag && ($priority <= 4))) {

		try {
			require_once('lib/common/Log.php');
			Log::write($errorMessage, $priority);
		} catch (Exception $e) {
			// continue
		}

		//}
	}

	// Display error to ajax if in debug mode.
	if ( $debugFlag && ($errno <> $E_USER_NOTICE) ) {
		$errorMessageHTML = nl2br($errorMessage);
		$ajaxFinalErrorMessage .= "<br>".$errorMessageHTML;
	}

	// Catch PHP script errors - always log them to disk or the db
	if ($errno < 256) {
		$phpScriptErrorMessage =
			PHP_EOL.
			"PHP script error caught by ajax error handler.".PHP_EOL.
			" Error Code: $errno".PHP_EOL.
			" File Path: $errfile".PHP_EOL.
			" Line in File: $errline".PHP_EOL.
			" Error Messages: $errstr".PHP_EOL;

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
	//exit;

	/* Don't execute PHP internal error handler */
	return true;
}

/**
 * Default site-wide error handler to display a friendly error page.
 *
 * This should be invoked only upon catastrophic error such as database
 * connection failure and should support graceful degradation.
 *
 */
function errorHandler($errno, $errstr, $errfile, $errline)
{
	// @ suppresses an error so check if error_reporting() === 0
	$errorReporting = error_reporting();
	if ($errorReporting === 0) {
		return;
	}

	// Derive the error code from the errno
	switch ($errno) {
		case E_ERROR:
			$errorType = 'E_ERROR'; // 1
			$priority = 3;
			break;
		case E_WARNING:
			$errorType = 'E_WARNING'; // 2
			$priority = 4;
			break;
		case E_PARSE:
			$errorType = 'E_PARSE'; // 4
			$priority = 0;
			break;
		case E_NOTICE:
			$errorType = 'E_NOTICE'; // 8
			$priority = 5;
			break;
		case E_CORE_ERROR:
			$errorType = 'E_CORE_ERROR'; // 16
			$priority = 0;
			break;
		case E_CORE_WARNING:
			$errorType = 'E_CORE_WARNING'; // 32
			$priority = 1;
			break;
		case E_COMPILE_ERROR:
			$errorType = 'E_COMPILE_ERROR'; // 64
			$priority = 0;
			break;
		case E_COMPILE_WARNING:
			$errorType = 'E_COMPILE_WARNING'; // 128
			$priority = 4;
			break;
		case E_USER_ERROR:
			$errorType = 'E_USER_ERROR'; // 256
			$priority = 3;
			break;
		case E_USER_WARNING:
			$errorType = 'E_USER_WARNING'; // 512
			$priority = 4;
			break;
		case E_USER_NOTICE:
			$errorType = 'E_USER_NOTICE'; // 1024
			$priority = 5;
			break;
		case E_STRICT:
			$errorType = 'E_STRICT'; // 2048
			$priority = 3;
			break;
		case E_RECOVERABLE_ERROR:
			$errorType = 'E_RECOVERABLE_ERROR'; // 4096
			$priority = 3;
			break;
		case E_DEPRECATED:
			$errorType = 'E_DEPRECATED'; // 8192
			$priority = 4;
			break;
		default:
			$errorType = 'Unknown';
			$priority = 6;
			break;
	}

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

		// Operational mode of site.
		$mode = $config->system->operational_mode;

		// Error logging - always log script errors
		$log_errors_to_disk = $config->system->log_errors_to_disk;

		// Command line interface flag.
		$cli = $config->script->cli;
	} catch(Exception $e) {
		$mode = 'production';
		$log_errors_to_disk = true;
		$debugMode = false;
		$cli = false;
	}

	if ((isset($mode) && ($mode == 'debug')) || $debugMode) {
		$debugFlag = true;
	} else {
		$debugFlag = false;
	}

	// Log or display error message.
	$errorMessage =
		PHP_EOL.
		"[User Defined Error Handler Output]".PHP_EOL.
		" Error Type: $errorType ($errno)".PHP_EOL.
		//" Error Code: $errno".PHP_EOL.
		" File Path: $errfile".PHP_EOL.
		" Line in File: $errline".PHP_EOL.
		" Error Messages: $errstr".PHP_EOL;

	// Log errors to disk
	if ($log_errors_to_disk) {
		// always log PHP script errors
		if ($debugFlag || (!$debugFlag && ($errno < 256))) {
			try {
				require_once('lib/common/Log.php');
				Log::write($errorMessage, $priority);
			} catch (Exception $e) {
				// continue
			}
		}
	}

	// Command line interface flag.
	if (isset($cli) && $cli) {
		$cliFlag = true;
		$nl = PHP_EOL;
		$preStart = '';
		$preEnd = '';
	} else {
		$cliFlag = false;
		$nl = '<br>';
		//$preStart = '<pre>';
		//$preEnd = '</pre>';
		$preStart = '';
		$preEnd = '';
	}

	// Catch PHP script errors - always log them to disk or the db
	if ($errno < 256) {
		$phpScriptErrorMessage =
			PHP_EOL.
			"PHP script error caught by ajax error handler.".PHP_EOL.
			" Error Code: $errno".PHP_EOL.
			" File Path: $errfile".PHP_EOL.
			" Line in File: $errline".PHP_EOL.
			" Error Messages: $errstr".PHP_EOL;

		try {
			$database = Zend_Registry::get('database');
			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */
		} catch(Exception $e) {
			// continue
		}

		if (isset($db->throwExceptionOnDbError) && $db->throwExceptionOnDbError) {
			if ($debugFlag) {
				// Output the error message to stdout
				if (!$cliFlag) {
					$phpScriptErrorMessage = nl2br($phpScriptErrorMessage);
				}

				echo $phpScriptErrorMessage;
			}

			throw new Exception($errorMessage);
		}
	}

	if ($debugFlag) {
		switch ($errno) {
			// Show all notices and warnings.
			case E_STRICT:
			case E_NOTICE:
			case E_USER_NOTICE:
			case E_USER_WARNING:
			case E_WARNING:
				$formattedErrorMessage = formatErrorMessage($errorMessage, $cliFlag);
				echo $formattedErrorMessage;
				break;

			// Show the error and superglobal values for an actual error.
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_USER_ERROR:
			case E_ERROR:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
				// Output server superglobals.
				$errorMessageSuperGlobals = $preStart.'[SUPERGLOBALS]'.PHP_EOL;
				// Post
				if (isset($_POST) && !empty($_POST)) {
					$errorMessageSuperGlobals .= '$_POST ='.PHP_EOL.print_r($_POST, true).PHP_EOL.PHP_EOL;
				}
				// Get
				if (isset($_GET) && !empty($_GET)) {
					$errorMessageSuperGlobals .= '$_GET ='.PHP_EOL.print_r($_GET, true).PHP_EOL.PHP_EOL;
				}
				// Cookie
				if (isset($_COOKIE) && !empty($_COOKIE)) {
					$errorMessageSuperGlobals .= '$_COOKIE ='.PHP_EOL.print_r($_COOKIE, true).PHP_EOL.PHP_EOL;
				}
				// Session
				if (isset($_SESSION) && !empty($_SESSION)) {
					$errorMessageSuperGlobals .= '$_SESSION ='.PHP_EOL.print_r($_SESSION, true).PHP_EOL.PHP_EOL;
				}
				// Server
				if (isset($_SERVER) && !empty($_SERVER)) {
					$errorMessageSuperGlobals .= '$_SERVER ='.PHP_EOL.print_r($_SERVER, true).PHP_EOL.PHP_EOL;
				}
				$errorMessageSuperGlobals .= $preEnd;

				$errorMessage .= $errorMessageSuperGlobals;
				$formattedErrorMessage = formatErrorMessage($errorMessage, $cliFlag);
				//$formattedErrorMessage .= $errorMessageSuperGlobals;
				echo $formattedErrorMessage;
				break;

			default:
				$formattedErrorMessage = formatErrorMessage($errorMessage, $cliFlag);
				echo $formattedErrorMessage;
				break;
		}
	} else {
		// Logging is handled above so do nothing here for the production case.
		return;
	}
}

function exceptionHandler($exception)
{
	try {
		$database = Zend_Registry::get('database');
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// The script will halt right after so prevent an exception loop since there is an error condition.
		$db->throwExceptionOnDbError = false;

		// Rollback any transactions since an exception was thrown, but not caught
		$db->rollback();
	} catch(Exception $e) {
		// continue
	}

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

		// Operational mode of site.
		$mode = $config->system->operational_mode;

		// Error logging - always log script errors
		$log_errors_to_disk = $config->system->log_errors_to_disk;

		// Command line interface flag.
		$cli = $config->script->cli;
	} catch(Exception $e) {
		$mode = 'production';
		$log_errors_to_disk = true;
		$debugMode = false;
		$cli = false;
	}

	$debugFlag = false;
	if ((isset($mode) && ($mode == 'debug')) || $debugMode) {
		$debugFlag = true;
	}

	$cliFlag = false;
	if ($cli) {
		$cliFlag = true;
	}

	// Error message.
	$exceptionErrorMessage = $exception->getMessage();
	//$exceptionBackTrace = $exception->getTrace();
	$errorMessage =
		'[User Defined Exception Handler Output]'.PHP_EOL.
		' Uncaught Exception:'.PHP_EOL.
		' Message: '.$exceptionErrorMessage.PHP_EOL.PHP_EOL.
		' Exception: '.print_r($exception, true).PHP_EOL;
		//'Trace: '.$exceptionBackTrace.PHP_EOL;

	// Log all errors for later cleanup.
	if ($log_errors_to_disk) {
		try {
			require_once('lib/common/Log.php');
			Log::write($errorMessage, 5);
		} catch (Exception $e) {
			// continue
		}
	}

	if ($debugFlag) {
		$formattedErrorMessage = formatErrorMessage($errorMessage, $cliFlag);
		echo $formattedErrorMessage;
	}

	// Effectively ignore the exception
	// Execution of the script will now halt
	return;
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

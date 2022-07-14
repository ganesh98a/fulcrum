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
 * User defined MySQL session handler callback functions.
 *
 * This code is completely self contained with no inter-dependencies to any other framework code.
 * Unexplainable session-related problems typically means there is a bug in this code.
 * Set up database session storage for $_SESSION via MySQL storage backend.
 * Register user-defined session call back functions.
 *
 * The functions defined here replace PHP's session functions via session_set_save_handler().
 *
 * @category	Framework
 * @package		Session
 * @version		PHP 5
 * @see 		http://www.php.net/manual/en/ref.session.php
 * @see 		http://www.php.net/manual/en/function.session-set-save-handler.php
 *
 */

/**
 * User defined MySQL session handler callback functions.
 *
 * open(string $savePath, string $sessionName)
 * close()
 * read(string $sessionId)
 * write(string $sessionId, string $data)
 * destroy($sessionId)
 * gc($lifetime)
 *
 *
 * Required php session settings set in php.ini or config-php.ini:
 *
 * session.hash_function = "1"
 * session.hash_bits_per_character = "4"
 * session.name = "oatmealraisin"
 * session.gc_maxlifetime = "31536000"
 * session.gc_probability = "1"
 * session.gc_divisor = "100"
 * session.use_cookies = "1"
 * session.use_only_cookies = "1"
 * session.use_trans_sid = "0"
 *
 *
 * Meaningless php session settings since we are using session_set_save_handler():
 *
 * session.save_handler = "user"
 * session.save_path = ""
 *
 */

class CustomDbSession
{
	/**
	 * PRODUCTION SETTINGS
	 * operatingMode	= 'production'
	 *
	 * DEBUG SETTINGS
	 * operatingMode	= 'debug'
	 *
	 */
	const operatingMode	= 'production';
	const logFilePath	= '/log/application/php_session_error_log.txt';
	const hostname		= '127.0.0.1';
	const port			= 3306;
	const username		= 'root';
	const password		= '';
	const database		= 'php_session';

	private $user_id;

	public function getUserId()
	{
		if (isset($this->user_id)) {
			return $this->user_id;
		} else {
			return null;
		}
	}

	public function setUserId($user_id)
	{
		if (isset($user_id)) {
			$this->user_id = $user_id;
		} else {
			$this->user_id = null;
		}
	}

	private static $_instance;

	public static function getInstance()
	{
		$instance = self::$_instance;

		if (!isset($instance)) {
			$instance = new CustomDbSession();
			self::$_instance = $instance;
		}

		return $instance;
	}

	private static $mysqli = null;

	public static function getMysqli()
	{
		$mysqli = self::$mysqli;

		if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
			// The config variables should be apache env vars in memory
			$hostname =			self::hostname;
			$port =				self::port;
			$username =			self::username;
			$password =			self::password;
			$database =			self::database;
			$mysqli = new mysqli($hostname, $username, $password, $database, $port);
			$connect_errno = $mysqli->connect_errno;
			if ($connect_errno) {
				$errorMessage =
					"Failed to connect to MySQL\n" .
					"Error #: $mysqli->connect_errno \n" .
					"Error Message: $mysqli->connect_error \n" .
					"Host Info: $mysqli->host_info \n";
				self::outputFormattedErrorMessage($errorMessage);
			}

			self::$mysqli = $mysqli;
		}

		return $mysqli;
	}

	public function getAutoCommitSetting()
	{
		$mysqli = CustomDbSession::getMysqli();
		/* @var $mysqli mysqli */

		$query =
"
SELECT @@autocommit
";
		$result = $mysqli->query($query, MYSQLI_USE_RESULT);

		if ($result) {
			$row = $result->fetch_row();
			$result->free();
			$autoCommitSetting = $row[0];
			echo "\nAutocommit is: $autoCommitSetting\n";
		} else {
			$errorMessage =
				"getAutoCommitSetting() failed to query the @@autocommit setting.\n" .
				"Error #: $mysqli->errno \n" .
				"Error Message: $mysqli->error \n" .
				"Host Info: $mysqli->host_info \n";
			CustomDbSession::outputFormattedErrorMessage($errorMessage);
		}

		return;
	}

	/**
	 * This is an ad hoc function that is not needed if the standard DBI error() method is used.
	 *
	 * Output MySQL error type and number for debug, test cases or log for production.
	 *
	 * @param resource $link
	 */
	public static function outputFormattedErrorMessage($errorMessage)
	{
		// Output errors for debug mode, log to disk for production mode
		$operatingMode = self::operatingMode;
		if ($operatingMode == 'debug') {
			$debugFlag = true;
		} else {
			$debugFlag = false;
		}

		// dynamically detect OS
		$operatingSystem = PHP_OS;

		// dynamically detect SAPI
		$sapi = php_sapi_name();
		if ($sapi == 'cli') {
			$cliFlag = true;
		} else {
			$cliFlag = false;
		}

		// Log or display error message.
		$date = date(DATE_RFC822);
		$errorMessage =
			"[User Defined Error Handler Output]\n".
			"Timestamp: $date\n".
			$errorMessage;

		if ($debugFlag) {
			if ($cliFlag) {
				echo $errorMessage;
			} else {
				//$errorMessage = nl2br($errorMessage);
				$errorMessage =
					'<font color="#f71324">'.
					'<pre>'.
					$errorMessage.
					'</pre>'.
					'</font>';
				echo $errorMessage;
				// Only close and exit when in debug mode
				$mysqli = CustomDbSession::getMysqli();
				$mysqli->close();
				exit;
			}
		} else {
			// Log error to disk
			$logFilePath = self::logFilePath;
			$streamResource = fopen($logFilePath, 'ab', false);
			if (is_resource($streamResource)) {
				$bytesWritten = fwrite($streamResource, $errorMessage);
				$fcloseFlag = fclose($streamResource);
			}
		}

		return;
	}

	private $scriptStartTime;

	public function getScriptStartTime()
	{
		if (isset($this->scriptStartTime)) {
			$scriptStartTime = (float) $this->scriptStartTime;
			return $scriptStartTime;
		} else {
			return null;
		}
	}

	public function setScriptStartTime($scriptStartTime=null)
	{
		if (isset($scriptStartTime)) {
			$this->scriptStartTime = (float) $scriptStartTime;
		} else {
			$this->scriptStartTime = microtime(true);
		}
	}

	private $scriptEndTime;

	public function getScriptEndTime()
	{
		if (isset($this->scriptEndTime)) {
			$scriptEndTime = (float) $this->scriptEndTime;
			return $scriptEndTime;
		} else {
			return null;
		}
	}

	public function setScriptEndTime($scriptEndTime=null)
	{
		if (isset($scriptEndTime)) {
			$this->scriptEndTime = (float) $scriptEndTime;
		} else {
			$this->scriptEndTime = microtime(true);
		}
	}

	private $scriptTotalRunTime;

	public function getScriptTotalRunTime()
	{
		if (isset($this->scriptTotalRunTime)) {
			return $this->scriptTotalRunTime;
		}

		$scriptEndTime = $this->getScriptEndTime();
		$scriptStartTime = $this->getScriptStartTime();;
		if (isset($scriptEndTime) && isset($scriptStartTime)) {
			$scriptTotalRunTime = (float) ($scriptEndTime - $scriptStartTime);
		} else {
			$scriptTotalRunTime = null;
		}

		$this->scriptTotalRunTime = $scriptTotalRunTime;

		return $scriptTotalRunTime;
	}
}

/**
 * Session call back to open a new session or reinitialize an existing one.
 *
 * The open callback works like a constructor in classes and is executed when the session is being opened.
 * It is the first callback function executed when the session is started automatically or manually with session_start().
 * Return value is TRUE for success, FALSE for failure.
 *
 * The paramaters are ignored, but needed to comply with session_set_save_handler()
 *
 * @param string $savePath
 * @param string $sessionName
 * @return bool true
 */
function sessionOpen($savePath, $sessionName)
{
	$db = CustomDbSession::getInstance();
	/* @var $db CustomDbSession */

	// Track the microtime stamp for the script..."session total time"
	$db->setScriptStartTime();

	$mysqli = CustomDbSession::getMysqli();
	/* @var $mysqli mysqli */

	// Ensure that the session charset is UTF-8
	/*
	$charsetSuccessFlag = $mysqli->set_charset('utf8');
	if (!$charsetSuccessFlag) {
		$errorMessage =
			"Failed to set mysqli charset to UTF-8.\n" .
			"Current character set: {$mysqli->character_set_name()}\n" .
			"Error #: $mysqli->errno \n" .
			"Error Message: $mysqli->error \n" .
			"Host Info: $mysqli->host_info \n";
		CustomDbSession::outputFormattedErrorMessage($errorMessage);
	}
	*/

	$autocommitSuccessFlag = $mysqli->autocommit(false);
	if (!$autocommitSuccessFlag) {
		$errorMessage =
			"Failed to set mysqli autocommit to false.\n" .
			"Error #: $mysqli->errno \n" .
			"Error Message: $mysqli->error \n" .
			"Host Info: $mysqli->host_info \n";
		CustomDbSession::outputFormattedErrorMessage($errorMessage);
	}

	/**
	 * mysqli error levels:
	 * MYSQLI_REPORT_OFF		Turns reporting off
	 * MYSQLI_REPORT_ERROR		Report errors from mysqli function calls
	 * MYSQLI_REPORT_STRICT		Throw mysqli_sql_exception for errors instead of warnings
	 * MYSQLI_REPORT_INDEX		Report if no index or bad index was used in a query
	 * MYSQLI_REPORT_ALL		Set all options (report all)
	 */
	$driver = new mysqli_driver();
	$operatingMode = CustomDbSession::operatingMode;
	if ($operatingMode == 'debug') {
		//$driver->report_mode = MYSQLI_REPORT_ALL;
		$driver->report_mode = MYSQLI_REPORT_ERROR;
	} else {
		// Production setting
		//$driver->report_mode = MYSQLI_REPORT_OFF;
		$driver->report_mode = MYSQLI_REPORT_ERROR;
	}

	return;
}

/**
 * Session call back to close a session.
 *
 * The close callback works like a destructor in classes and is executed after the session write callback has been called.
 * It is also invoked when session_write_close() is called.
 * Return value should be TRUE for success, FALSE for failure.
 *
 * @return bool true
 */
function sessionClose()
{
	return true;
}

/**
 * Read from the session store.  Returns an empty string or a the payload for a sess_id.
 *
 * Called after open above due to the session starting or session_start() being called explicitly.
 *
 * The read callback must always return a session encoded (serialized) string, or an empty string if there is no data to read.
 * This callback is called internally by PHP when the session starts or when session_start() is called.
 * Before this callback is invoked PHP will invoke the open callback.
 * The value this callback returns must be in exactly the same serialized format that was originally passed for storage to the write callback.
 * The value returned will be unserialized automatically by PHP and used to populate the $_SESSION superglobal.
 * While the data looks similar to serialize() please note it is a different format which is speficied in the session.serialize_handler ini setting.
 *
 * @param string $sessionId
 * @return string
 */
function sessionRead($sessionId)
{
	$db = CustomDbSession::getInstance();
	/* @var $db CustomDbSession */
	$mysqli = CustomDbSession::getMysqli();
	/* @var $mysqli mysqli */

	// Load the session data
	$escapedSessionId = $mysqli->real_escape_string($sessionId);
	$query =
"
SELECT `data`
FROM `php_sessions`
WHERE `session_id` = '$escapedSessionId'
";
//WHERE `session_id` = '$escapedSessionId' FOR UPDATE
	$querySuccessFlag = $mysqli->real_query($query);
	if (!$querySuccessFlag) {
		$errorMessage =
			"sessionRead() failed to read session data from session table.\n" .
			"Error #: $mysqli->errno \n" .
			"Error Message: $mysqli->error \n" .
			"Host Info: $mysqli->host_info \n";
		CustomDbSession::outputFormattedErrorMessage($errorMessage);
	}
	$result = $mysqli->use_result();
	if ($result) {
		$row = $result->fetch_assoc();
		$result->close();
		if (isset($row) && !empty($row)) {
			$sessionData = $row['data'];
		} else {
			$sessionData = '';
		}
	} else {
		$sessionData = '';
	}

	return $sessionData;
}

/**
 * Write to the session store.  Inserts or updates for new or existing sessions.
 *
 * The write callback is called when the session needs to be saved and closed.
 * This callback receives the current session ID a serialized version the $_SESSION superglobal.
 * The serialization method used internally by PHP is specified in the session.serialize_handler ini setting.
 * The serialized session data passed to this callback should be stored against the passed session ID.
 * When retrieving this data, the read callback must return the exact value that was originally passed to the write callback.
 * This callback is invoked when PHP shuts down or explicitly when session_write_close() is called.
 * Note that after executing this function PHP will internally execute the close callback.
 *
 * Note: The "write" handler is not executed until after the output stream is closed.
 * Thus, output from debugging statements in the "write" handler will never be seen in the browser.
 * If debugging output is necessary, it is suggested that the debug output be written to a file instead.
 *
 * @param string $sessionId
 * @param string $data
 */
function sessionWrite($sessionId, $data)
{
	$db = CustomDbSession::getInstance();
	/* @var $db CustomDbSession */
	$mysqli = CustomDbSession::getMysqli();
	$db->setScriptEndTime();
	$scriptTotalRunTime = $db->getScriptTotalRunTime();


	// $active_page - this code copied over from lib/common/URI.php
	// Normalize HTTP URI Request into parts
	// scheme://domain:port/path?query_string#fragment_id
	// scheme://domain/path?query_string
	if (isset($_SERVER['SERVER_PORT']) && !empty($_SERVER['SERVER_PORT'])) {
		$port = (int) $_SERVER['SERVER_PORT'];
	} else {
		// Set sensible default for CLI scripts
		$port = null;
	}

	if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] <> 'off') && ($port === 443)) {
		$scheme = 'https';
	} elseif (isset($port)) {
		if ($port === 443) {
			$scheme = 'https';
		} elseif ($port === 80) {
			$scheme = 'http';
		}
	} else {
		$scheme = 'http';
	}

	if (isset($_SERVER['SCRIPT_URI']) && !empty($_SERVER['SCRIPT_URI'])) {
		$SCRIPT_URI = $_SERVER['SCRIPT_URI'];
	} else {
		$SCRIPT_URI = null;
	}

	// $_SERVER['SERVER_NAME'] and $_SERVER['REQUEST_URI'] are not available from CLI
	if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
		$domain = $_SERVER['HTTP_HOST'];
	} elseif (isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME'])) {
		$domain = $_SERVER['SERVER_NAME'];
	} else {
		$domain = null;
	}

	// $currentPhpScript e.g. "/path/to/script.php" -> "script.php"
	if (isset($_SERVER['PHP_SELF']) && !empty($_SERVER['PHP_SELF'])) {
		$tmpPath = $_SERVER['PHP_SELF'];
		$arrTmpPath = explode('/', $tmpPath);
		$currentPhpScript = array_pop($arrTmpPath);
	} else {
		$currentPhpScript = '';
	}

	// $path e.g. "/path/to/script.php?a=1&b=2" -> "/path/to/script.php"
	if (isset($_SERVER['PHP_SELF']) && !empty($_SERVER['PHP_SELF'])) {
		$path = $_SERVER['PHP_SELF'];
	} else {
		$path = null;
	}

	// Query string
	// NOTE: we may want to remove the debug and decloak URL tokens...
	$queryString = (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');

	// $_SERVER['SERVER_NAME'] and $_SERVER['REQUEST_URI'] are not available from CLI
	if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
		$REQUEST_URI = $_SERVER['REQUEST_URI'];
	} else {
		$REQUEST_URI = null;
	}

	// Form the final $url and $base_href URL values
	// Explicitly check for each available URL component as we may be running PHP CLI or as a service
	// scheme://domain/path?query_string
	if (isset($scheme) && isset($domain) && isset($REQUEST_URI)) {
		$requestedUrl = "$scheme://$domain$REQUEST_URI";
	} else {
		$requestedUrl = null;
	}
	if (isset($scheme) && isset($domain) && isset($path)) {
		$base_href = "$scheme://$domain$path";
	} else {
		$base_href = null;
	}

	if (isset($requestedUrl)) {
		$active_page = $requestedUrl;
	} elseif (isset($base_href)) {
		$active_page = $base_href;
	} else {
		$active_page = '';
	}


	$user_id = $db->getUserId();

	// If no session found, insert a new one, otherwise update.
	$escapedSessionId = $mysqli->real_escape_string($sessionId);
	$escapedSessionData = $mysqli->real_escape_string($data);
	$escapedActivePage = $mysqli->real_escape_string($active_page);
	$query =
"
INSERT INTO `php_sessions`
(`session_id`, `user_id`, `data`, `active_page`, `accessed`, `created`)
VALUES ('$escapedSessionId',$user_id,'$escapedSessionData','$escapedActivePage',null,null)
ON DUPLICATE KEY UPDATE `user_id`=$user_id, `data`='$escapedSessionData', `active_page`='$escapedActivePage', `accessed`=null
";
	$querySuccessFlag = $mysqli->real_query($query);
	if ($querySuccessFlag) {
		$mysqli->commit();
	} else {
		$mysqli->rollback();
		$errorMessage =
			"sessionWrite() failed to write session data to the session table.\n" .
			"Error #: $mysqli->errno \n" .
			"Error Message: $mysqli->error \n" .
			"Host Info: $mysqli->host_info \n";
		CustomDbSession::outputFormattedErrorMessage($errorMessage);
	}

	$mysqli->close();
}

/**
 * Destroy a session by deleting its entry from the session store.
 *
 * Invoked from php session_destroy() function.
 *
 * This callback is executed when a session is destroyed with session_destroy() or with session_regenerate_id() with the destroy parameter set to TRUE.
 * Return value should be TRUE for success, FALSE for failure.
 *
 * @param string $sessionId
 * @return bool true
 */
function sessionDestroy($sessionId)
{
	$db = CustomDbSession::getInstance();
	/* @var $db CustomDbSession */
	$mysqli = CustomDbSession::getMysqli();

	$escapedSessionId = $mysqli->real_escape_string($sessionId);
	$query =
"
DELETE FROM `php_sessions`
WHERE `session_id` = '$escapedSessionId'
";
	//$autocommitSuccessFlag = $mysqli->autocommit(false);
	$querySuccessFlag = $mysqli->real_query($query);
	if ($querySuccessFlag) {
		$mysqli->commit();
	} else {
		$mysqli->rollback();
		$errorMessage =
			"sessionDestroy($sessionId) failed to delete the session from the session table.\n" .
			"Error #: $mysqli->errno \n" .
			"Error Message: $mysqli->error \n" .
			"Host Info: $mysqli->host_info \n";
		CustomDbSession::outputFormattedErrorMessage($errorMessage);
	}

	return true;
}

/**
 * Garbage collect (DELETE) stale sessions that are older than the time to live (ttl).
 * The session lifespan (ttl) is defined in the php.ini file: in session.gc_maxlifetime.
 *
 * The garbage collector callback is invoked internally by PHP periodically in order to purge old session data.
 * The frequency is controlled by session.gc_probability and session.gc_divisor.
 * The value of lifetime which is passed to this callback can be set in session.gc_maxlifetime.
 * Return value should be TRUE for success, FALSE for failure.
 *
 * @param int $lifetime (session.gc_maxlifetime via php.ini)
 * @return bool
 */
function sessionGC($lifetime)
{
	$db = CustomDbSession::getInstance();
	/* @var $db CustomDbSession */
	$mysqli = CustomDbSession::getMysqli();

	$query =
"
DELETE FROM
`php_sessions`
WHERE UNIX_TIMESTAMP(`accessed`) < (UNIX_TIMESTAMP() - $lifetime)
";
	//$autocommitSuccessFlag = $mysqli->autocommit(false);
	$querySuccessFlag = $mysqli->real_query($query);
	if ($querySuccessFlag) {
		$mysqli->commit();
	} else {
		$mysqli->rollback();
		$errorMessage =
			"sessionGC() failed to delete session data from session table.\n" .
			"Error #: $mysqli->errno \n" .
			"Error Message: $mysqli->error \n" .
			"Host Info: $mysqli->host_info \n";
		CustomDbSession::outputFormattedErrorMessage($errorMessage);
	}

	return true;
}

// Register user-defined session call back functions.
session_set_save_handler("sessionOpen", "sessionClose", "sessionRead", "sessionWrite", "sessionDestroy", "sessionGC");

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

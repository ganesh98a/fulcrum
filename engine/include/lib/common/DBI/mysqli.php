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
 * Contains the mysqli driver for the database abstraction layer DBI class.
 *
 * PHP version 5
 *
 *
 * @category   Database
 * @package    DBI
 */

class DBI_mysqli extends DBI
{
	public $mysql_ssl;

	protected $fetchModes = array(
		'array'		=> 1,
		'row'		=> 1,
		'object'	=> 1,
		'both'		=> 1
	);

	/**
	 * Use an IP address for $host for better performance.
	 *
	 * @param string $host
	 * @param int $port
	 * @param string $database
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($host, $port, $database, $username, $password, $socket=null)
	{
		parent::__construct($host, $port, $database, $username, $password, $socket);
	}

	public function __destruct()
	{
		//parent::__destruct();
		$this->disconnect();
		return true;
	}

	public function setQuery($query)
	{
		if (!isset($query)) {
			return false;
		} else {
			$this->query = $query;
			$this->queryPrepared = false;
		}
	}

	public function setDelimiter($delimiter)
	{
		if (!isset($delimiter)) {
			return false;
		} else {
			$this->delimiter = $delimiter;
		}
	}

	public function getQuoteFunction()
	{
		if (!isset($this->quoteFunction)) {
			$this->quoteFunction = function_exists('mysqli_real_escape_string') ? 'mysqli_real_escape_string' : 'addslashes';
			return $this->quoteFunction;
		} else {
			return $this->quoteFunction;
		}
	}

	/**
	 * Ping mysqld to see if it is up.
	 *
	 * @return bool
	 */
	public function ping($db = 'default')
	{
		if (isset($this->link_id) && ($this->link_id instanceof mysqli)) {
			return true;
		}

		// Try to explicitly connect.
		DBI::getInstance($db);
		$this->connect();
		if (isset($this->link_id) && ($this->link_id instanceof mysqli)) {
			return true;
		}

		return false;
	}

	public function connect()
	{
		$link = $this->link_id;

		if (isset($link) && ($link instanceof mysqli)) {
			$this->dbConnectionFlag = true;
		} else {
			// Refactored to support sockets as well
			$host = $this->host;
			$user = $this->user;
			$pass = $this->pass;
			$db = $this->db;
			$port = $this->port;
			$socket = $this->socket;
			$link = @mysqli_connect($host, $user, $pass, $db, $port, $socket);
			if (isset($link) && ($link instanceof mysqli)) {
				$this->dbConnectionFlag = true;

				// reset connection-related error messages
				$this->connectionErrorNumber = null;
				$this->connectionErrorMessage = null;
			} else {
				$this->dbConnectionFlag = false;

				// Check for MySQL errno and errmsg
				$connectionErrorNumber = mysqli_connect_errno();
				$connectionErrorMessage = mysqli_connect_error();

				if (isset($connectionErrorNumber) || isset($connectionErrorMessage)) {
					$applicationErrorMessage = __CLASS__."::connect - mysqli_connect failed for host: $host, db: $db, user: $user, pass: $pass";
				} else {
					$connectionErrorNumber = -1;
					$connectionErrorMessage = '';
					$applicationErrorMessage = __CLASS__."::connect - mysqli_connect failed, MySQL error unknown for host: $host, db: $db, user: $user, pass: $pass";
				}

				// Keep track of connection-related error messages
				$this->connectionErrorNumber = $connectionErrorNumber;
				$this->connectionErrorMessage = $connectionErrorMessage;
				$scriptError = (isset($php_errormsg) ? $php_errormsg : '');

				$this->error($applicationErrorMessage, $scriptError);

				return false;
			}

			// Change charset to utf8 or whatever it is set to
			$characterSet = $this->characterSet;
			mysqli_set_charset($link, $characterSet);

			// Check charset
			//$charset = mysqli_character_set_name($link);
			//echo $charset;
			//exit;

			$this->link_id = $link;
		}

		return $link;
	}

	public function disconnect()
	{
		$link = $this->link_id;
		if (isset($link) && ($link instanceof mysqli)) {
			mysqli_close($link);
		}

		$this->link_id = null;
		$this->dbConnectionFlag = false;

		return true;
	}

	public function prepare($query = null)
	{
		$this->queryPrepared = false;

		// Pull delimiter into scope
		$delimiter = $this->delimiter;

		// Pull query into scope
		if (isset($query)) {
			$this->query = $query;
		} else {
			$query = $this->query;
		}

		// Verify $query and $delimiter
		if (!isset($query) || !isset($delimiter)) {
			return false;
		}

		$arrQueryPieces = explode($delimiter, $query);
		$this->queryPieces = $arrQueryPieces;

		if (count($arrQueryPieces) == 1) {
			$this->queryPieces = null;
		}

		$this->queryPrepared = true;
		return true;
	}

	public function escape($input)
	{
		if (!isset($input)) {
			return null;
		} else {
			$output = null;

			// Get a connection
			if (!$this->dbConnectionFlag) {
				$link = $this->connect();
			} else {
				$link = $this->link_id;
			}
			if (is_array($input)) {
				foreach ($input as $k => $v) {
					if (isset($v)) {
						$escapedValue = mysqli_real_escape_string($link, $v);
						$output[$k] = $escapedValue;
					} else {
						$output[$k] = null;
					}
				}
			} else {
				if (isset($input)) {
					$escapedInput = mysqli_real_escape_string($link, $input);
					$output = $escapedInput;
				} else {
					$output = null;
				}
			}

			return $output;
		}
	}

	public function quote($input)
	{
		if (!isset($input)) {
			return null;
		} else {
			// Get a connection
			if (!$this->dbConnectionFlag) {
				$link = $this->connect();
			} else {
				$link = $this->link_id;
			}
			//$function = $this->getQuoteFunction();
			if (is_array($input)) {
				foreach ($input as $k => $v) {
					if (isset($v)) {
						$escapedValue = mysqli_real_escape_string($link, $v);
						if (is_int($v)) {
							$input[$k] = $escapedValue;
						} else {
							$input[$k] = "'".$escapedValue."'";
						}
					} else {
						$input[$k] = null;
					}
				}
			} else {
				if (isset($input)) {
					$escapedInput = mysqli_real_escape_string($link, $input);
					$input = "'$escapedInput'";
				} else {
					$input = null;
				}
			}

			//return true;
			return $input;
		}
	}

	public function bind_param()
	{
		if (!$this->queryPrepared) {
			return false;
		} else {
			$arrArgs = func_get_args();
			$types = array_shift($arrArgs);
			$arrParameterValues = & $arrArgs;
			$this->quote($arrParameterValues);
			$this->query = array_shift($this->queryPieces);
			$i = 0;
			foreach ($this->queryPieces as $value) {
				$this->query .= $arrParameterValues[$i] . $this->queryPieces[$i+1];
				$i++;
			}
			return true;
		}
	}

	public function bindQueryParameters($arrParameterValues)
	{
		$this->queryBound = false;

		if (!$this->queryPrepared) {
			return false;
		} elseif (count($arrParameterValues) != (count($this->queryPieces)-1)) {
			$this->errorNumber = -1;
			$this->errorMessage = '';
			$queryWithPlaceholders = join('?', $this->queryPieces);
			$applicationErrorMessage =
				__CLASS__."::bindQueryParameters($arrParameterValues) ".
				'failed to bind query parameters due to placeholder to parameter value count mismatch.'.PHP_EOL.PHP_EOL.
				'[Paramaterized Query]'.PHP_EOL.
				$queryWithPlaceholders.PHP_EOL.PHP_EOL.
				'[Query Paramater Values]'.PHP_EOL.
				print_r($arrParameterValues, true);
			$this->error($applicationErrorMessage);
		} else {
			//$this->quote($arrParameterValues);
			$arrParameterValues = $this->quote($arrParameterValues);

			// Keep $this->queryPieces intact for next potential execute() iteration
			$arrQueryPieces = $this->queryPieces;
			$query = array_shift($arrQueryPieces);
			//$this->query = array_shift($this->queryPieces);
			$i = 0;
			foreach ($arrQueryPieces as $value) {
				if (isset($arrParameterValues[$i])) {
					$appendedValue = $arrParameterValues[$i];
					if (isset($arrQueryPieces[$i])) {
						$appendedValue .= $arrQueryPieces[$i];
					}
				} else {
					$appendedValue = 'null';
					if (isset($arrQueryPieces[$i])) {
						$appendedValue .= $arrQueryPieces[$i];
					}
				}
				$query .= $appendedValue;
				$i++;
			}

			$this->query = $query;
			$this->queryBound = true;
			return true;
		}
	}

	public function query($query=null, $resultMode=MYSQLI_STORE_RESULT)
	{
		// Sanity check for an empty or missing SQL query string
		if (isset($query) && !empty($query)) {
			// Keep track of the latest query
			$this->query = $query;
		} else {
			return false;
		}

		// Get a connection
		if (!$this->dbConnectionFlag) {
			$link = $this->connect();
		} else {
			$link = $this->link_id;
		}

		// Run the query and get back the result set
		$result = @mysqli_query($link, $query, $resultMode);

		// Check for errors
		if ($result) {
			// Store the latest result for processing
			$this->result = $result;
		} else {
			$errorNumber = mysqli_errno($link);
			$errorMessage = mysqli_error($link);

			// Debug
			//echo 'Error #: '.$errorNumber.PHP_EOL;
			//echo 'Error: '.$errorMessage.PHP_EOL.PHP_EOL;
			//exit;

			if ($errorNumber || $errorMessage) {
				$applicationErrorMessage = __CLASS__.'::query failed.';
			} else {
				$errorNumber = -1;
				$errorMessage = '';
				$applicationErrorMessage = __CLASS__.'::query failed, MySQL error unknown.';
			}

			// Invoke custom error() method
			$this->errorNumber = $errorNumber;
			$this->errorMessage = $errorMessage;
			$scriptError = (isset($php_errormsg) ? $php_errormsg : '');
			$this->error($applicationErrorMessage, $scriptError);

			return;
		}

		return $result;
	}

	/**
	 * Execute a query with placeholders and values passed in.
	 *
	 * Allow client-side and server-side prepared statements.
	 * Client-side are for convenience and security.
	 * Server-side prepared statements are for performance.
	 *
	 * @param string $query
	 * @param array $arrParameterValues
	 * @param int $resultMode MYSQLI_STORE_RESULT or MYSQLI_USE_RESULT
	 * @return mixed
	 *
	 */
	public function execute($query=null, $arrParameterValues=null, $resultMode=MYSQLI_STORE_RESULT, $serverSidePreparedStatement=false)
	{
		// Get a connection
		if (!$this->dbConnectionFlag) {
			$link = $this->connect();
		} else {
			$link = $this->link_id;
		}

		// Potentially set query or bring it into scope
		if (isset($query) && !empty($query)) {
			$this->query = $query;
		} else {
			$query = $this->query;
		}

		// Prepare query if needed
		if (!$this->queryPrepared) {
			$this->prepare($query);
		}

		// Bind parameter values
		if (isset($arrParameterValues) && !empty($arrParameterValues)) {
			$this->bindQueryParameters($arrParameterValues);
		} else {
			// Allow empty parameter lists for queries that don't need them
			$this->queryBound = true;
		}

		// Check for query prepared
		if ($this->queryPrepared && $this->queryBound) {
			$query = $this->query;
		} else {
			$query = null;
		}

		// The query may be empty after preparation due to illegal characters.
		if ((!isset($query)) || (!$this->queryPrepared) || (!$this->dbConnectionFlag)) {
			return false;
		} else {
			// Reset error messages and state variables before attempting the query
			$this->errorNumber = null;
			$this->errorMessage = null;
			$this->rowCount = null;
			$this->rowsAffected = null;
			$this->rowsSelected = null;
			$this->insertId = null;

			$result = @mysqli_query($link, $query, $resultMode);
			if ($result) {
				$this->result = $result;
			} else {
				$errorNumber = mysqli_errno($link);
				$errorMessage = mysqli_error($link);

				// Debug
				//echo PHP_EOL.'Error #: '.$errorNumber.PHP_EOL;
				//echo 'Error: '.$errorMessage.PHP_EOL.PHP_EOL;
				//echo $query;
				//exit;

				if ($errorNumber || $errorMessage) {
					$applicationErrorMessage = __CLASS__.'::execute failed.';
				} else {
					$errorNumber = -1;
					$errorMessage = '';
					$applicationErrorMessage = __CLASS__.'::execute failed, MySQL error unknown.';
				}

				// Invoke custom error() method
				$this->errorNumber = $errorNumber;
				$this->errorMessage = $errorMessage;
				$scriptError = (isset($php_errormsg) ? $php_errormsg : '');
				$this->error($applicationErrorMessage, $scriptError);

				return false;
			}

			//return $this->result;
			/**
			 * Need to refactor the below code because of:
			 *
			 * INSERT INTO table (a,b,c) VALUES (1,2,3)
			 * ON DUPLICATE KEY UPDATE c=c+1;
			 *
			 * http://dev.mysql.com/doc/refman/5.0/en/insert-on-duplicate.html
			 *
			 * What about MYSQLI_USE_RESULT case???
			 * It breaks on Linux, but not Windows...go figure
			 */
			if (preg_match('/^[\s]*(select|insert|update)/i', $query, $arrMatch)) {
				$choice = strtolower($arrMatch[1]);
				switch ($choice) {
					case 'select':
						if ($resultMode == MYSQLI_STORE_RESULT) {
							$this->rowsSelected = mysqli_num_rows($result);
							$this->rowCount = &$this->rowsSelected;
						}
						break;
					case 'insert':
						$this->insertId = mysqli_insert_id($link);
						//if ($resultMode == MYSQLI_STORE_RESULT) {
							$this->rowsAffected = mysqli_affected_rows($link);
							$this->rowCount = &$this->rowsAffected;
						//}
						break;
					case 'update':
						$this->insertId = mysqli_insert_id($link);
						//if ($resultMode == MYSQLI_STORE_RESULT) {
							$this->rowsAffected = mysqli_affected_rows($link);
							$this->rowCount = &$this->rowsAffected;
						//}
						break;
				}
			}

			return $result;
		}
	}

	public function fetch()
	{
		$result = $this->result;

		// Check for valid result
		if (!isset($result) || !($result instanceof mysqli_result)) {

			// -1 represents a custom application errno
			$errorNumber = -1;
			$errorMessage = __METHOD__.' - Invalid result resource. Last Query: '.$query;
			$this->errorNumber = $errorNumber;
			$this->errorMessage = $errorMessage;

			$query = $this->query;
			$applicationErrorMessage = __CLASS__.'::fetch failed'.PHP_EOL.PHP_EOL.$errorMessage;
			$scriptError = (isset($php_errormsg) ? $php_errormsg : '');

			$this->error($applicationErrorMessage, $scriptError);

			$this->free_result();
			return false;
		}

		$row = @mysqli_fetch_assoc($result);

		if (isset($row) && is_array($row)) {
			$this->row = $row;
			return $row;
		} else {
			$errorNumber = mysqli_errno($this->link_id);
			if ($errorNumber) {
				$errorMessage = mysqli_error($this->link_id);
				// keep track of errors
				$this->errorNumber = $errorNumber;
				$this->errorMessage = $errorMessage;
				$applicationErrorMessage = __CLASS__.'::fetch failed';
				$scriptError = (isset($php_errormsg) ? $php_errormsg : '');
				$this->error($applicationErrorMessage, $scriptError);
				return false;
			}
			mysqli_free_result($result);
			unset($result);
			$this->result = null;
			//$this->free_result();
		}

		return false;
	}

	/**
	 * Fetch a row using 'array', 'row', 'object', or 'both' (to get both array and row formats).
	 *
	 * @param string $fetchmode
	 */
	public function fetch1($fetchmode = 'array')
	{
		$this->errorNumber = null;
		$this->errorMessage = null;

		if (!isset($this->fetchModes[$fetchmode])) {
			$errorMessage = __CLASS__.'::fetch() Invalid fetchmode: '.$fetchmode;
			$this->error($errorMessage);
		} else {
			$function = 'mysqli_fetch_'.$fetchmode;
		}

		if ((!isset($this->result)) || (!is_resource($this->result))) {
			$this->error(__CLASS__.'::fetch() No Resource Handle Available');
		} else {
			switch ($fetchmode) {
			case 'array':
				$this->row = $function($this->result, MYSQL_ASSOC);
				break;
			case 'row':
				$this->row = $function($this->result);
				break;
			case 'object':
				$this->row = $function($this->result);
				break;
			case 'both':
				$this->row = $function($this->result, MYSQL_BOTH);
				break;
			case 'default':
				$this->row = $function($this->result, MYSQL_ASSOC);
				break;
			}

			if (!$this->row) {
				$this->errorNumber = mysqli_errno($this->link_id);
				$this->errorMessage = mysqli_error($this->link_id);
			}

			if ($this->errorNumber) {
				if (isset($this->errorNumber) || isset($this->errorMessage)) {
					$applicationErrorMessage = __CLASS__.'::'.$function.' failed';
					$script_error = (isset($php_errormsg) ? $php_errormsg : '');
					$this->error($applicationErrorMessage, $script_error);
					return false;
				} else {
					$applicationErrorMessage = __CLASS__.'::'.$function.' failed - MySQL error unknown for query: '.$this->query.
						', host: '.$this->host.', db: '.$this->db.', user: '.$this->user.', pass: '.$this->pass;
					$script_error = (isset($php_errormsg) ? $php_errormsg : '');
					$this->error($applicationErrorMessage, $script_error);
					return false;
				}
			}
		}

		if (isset($this->row)) {
			return $this->row;
		} else {
			$this->free_result();
		}

		return false;
	}

	public function free_result()
	{
		$result = $this->result;

		if (isset($result) && ($result instanceof mysqli_result)) {
			mysqli_free_result($result);
		}

		$this->result = null;
		$this->queryPrepared = false;
		$this->queryBound = false;

		return true;
	}

	public function error($applicationErrorMessage = 'No error message.', $phpTrackedErrorMessage = 'No PHP error message.')
	{
		if (empty($phpTrackedErrorMessage)) {
			$phpTrackedErrorMessage = 'N/A';
		}

		$errorLevel = $this->errorLevel;
		$haltOnError = $this->systemHaltOnDbError;
		$errorNumber = $this->errorNumber;
		$errorMessage = $this->errorMessage;
		$connectionErrorNumber = $this->connectionErrorNumber;
		$connectionErrorMessage = $this->connectionErrorMessage;
		$query = $this->query;

		$completeErrorMessage =
			"[Error Messages]".PHP_EOL.
			"Application Error Message: $applicationErrorMessage".PHP_EOL;
		if (isset($errorNumber)) {
			if ($errorNumber == -1) {
				$errorNumberLine = "MySQL Error Number: N/A";
				$errorStringLine = "MySQL Error String: N/A";
			} else {
				$errorNumberLine = "MySQL Error Number: $errorNumber";
				$errorStringLine = "MySQL Error String: $errorMessage";
			}
			$completeErrorMessage .=
				$errorNumberLine.PHP_EOL.
				$errorStringLine.PHP_EOL.
				"PHP Error: $phpTrackedErrorMessage".PHP_EOL.
				"[Last Query]".PHP_EOL.
				$query.PHP_EOL;
		} elseif (isset($connectionErrorNumber)) {
			if ($connectionErrorNumber == -1) {
				$errorNumberLine = "MySQL Connection Error Number: N/A";
				$errorStringLine = "MySQL Connection Error String: N/A";
			} else {
				$errorNumberLine = "MySQL Connection Error Number: $connectionErrorNumber";
				$errorStringLine = "MySQL Connection Error String: $connectionErrorMessage";
			}
			$completeErrorMessage .=
				$errorNumberLine.PHP_EOL.
				$errorStringLine.PHP_EOL.
				"PHP Error: $phpTrackedErrorMessage".PHP_EOL;
		}

		// appropriately format error message according to SAPI
		// use <br> for non-cli sapi execution
		$sapi = $this->sapi;
		if ($sapi == 'cli') {
			$nl = PHP_EOL;
			$preStart = '';
			$preEnd = ''; //<font color="#f71324"><pre>'.$errorMessage.'</pre></font>';
		} else {
			$nl = '<br>';
			$preStart = '<pre>';
			$preEnd = '</pre>';
			$formattedErrorMessage = nl2br($completeErrorMessage);
			//$formattedErrorMessage = $completeErrorMessage;
		}

		// Store error message no matter what
		$error = Error::getInstance();
		/* @var $error Error */
		$error->handleError(E_USER_ERROR, $completeErrorMessage, __FILE__, __LINE__);

		/*
		// error handling for production run level
		if ($errorLevel == 'production') {
			if ($haltOnError) {
				if (!$this->throwExceptionOnDbError) {
					// halt system on error
					trigger_error($completeErrorMessage, E_USER_ERROR);
				}
			} else {
				// do not halt system on error
				return;
			}
		}

		// error handling for debug run level
		if ($errorLevel == 'debug') {
			echo '<font color="#f71324">';
			echo $formattedErrorMessage;
			echo '</font>';

			echo $nl;

			// backtrace
			echo $preStart;
			echo '[Back Trace]'.$nl;
			//echo $preStart;
			debug_print_backtrace();
			echo $preEnd.$nl;

			// possibly halt on error - useful only if an errorHandler is defined
			if ($haltOnError) {
				if (!$this->throwExceptionOnDbError) {
					// halt system on error
					trigger_error($completeErrorMessage, E_USER_ERROR);
				}
			}
		}
		*/

		// Reset error variables
		$this->errorNumber = null;
		$this->errorMessage = null;
		$this->connectionErrorNumber = null;
		$this->connectionErrorMessage = null;

		// Throw an exception if DBI::$throwExceptionOnDbError == true
		if ($this->throwExceptionOnDbError) {
			throw new Exception($completeErrorMessage);
		}

		return;
	}

	public function lock_tables($arrTableLockList)
	{
		if (!isset($arrTableLockList)) {
			return false;
		} else {
			$query = 'LOCK TABLES ';

			$first = true;
			foreach ($arrTableLockList as $key => $value) {
				if ($first) {
					$query .= ' ' . $key . ' ' . $value;
					$first = false;
				} else {
					$query .= ', ' . $key . ' ' . $value;
				}
			}
			if ($this->query($query)) {
				return true;
			} else {
				return false;
			}
		}
		return true;
	}

	public function unlock_tables()
	{
		$query = 'UNLOCK TABLES';
		if ($this->query($query)) {
			return true;
		} else {
			return false;
		}
	}

	public function begin()
	{
		//debug
		//return;

		//$query = 'START TRANSACTION';
		$query = 'BEGIN';
		if ($this->query($query)) {
			return true;
		} else {
			return false;
		}
	}

	public function commit()
	{
		//debug
		//return;

		$query = 'COMMIT';
		if ($this->query($query)) {
			return true;
		} else {
			return false;
		}
	}

	public function rollback()
	{
		$query = 'ROLLBACK';
		$this->query($query);
		return true;
	}

	public function debug()
	{
		echo '<pre>';
		print_r($this);
		echo '</pre>';
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

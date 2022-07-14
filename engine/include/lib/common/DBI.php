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
 * Generic wrapper class for database abstraction.
 *
 * This class uses a driver class for the specific database being used.
 *
 * PHP version 5
 *
 *
 * @category   Database
 * @package    DBI
 *
 */

/**
 * DBI_mysqli
 */
//Already Included...commented out for performance gain
//require_once('lib/common/DBI/mysqli.php');

class DBI
{
	/**
	 * Singleton.
	 *
	 * @var DBI Object Reference
	 */
	private static $_instance;

	/**
	 * apache vs CLI.
	 *
	 * mysqli and other drivers behave differently for CLI.
	 *
	 * @var string
	 */
	public $sapi = 'apache';

	/**
	 * Database transport layer connection properties.
	 */
    public $host;
    public $port;
    public $db;
    public $user;
    public $pass;
    protected $socket;

    /**
     * Database error properties.
     */
	public $errorLevel = 'production';
	public $systemHaltOnDbError = false;
	public $throwExceptionOnDbError = false;
	protected $errorNumber;
	protected $errorMessage;
	protected $connectionErrorNumber;
	protected $connectionErrorMessage;

	/**
	 * Database connection properties
	 */
	public $link_id;
	public $characterSet = 'utf8';
	public $dbConnectionFlag = false;

	/**
	 * Database query properties
	 */
	public $query;
	public $delimiter = '?';
	public $quoteFunction;
	public $queryPieces;
	public $queryPrepared = false;
	public $queryBound = false;

	/**
	 * Database result-set properties
	 */
	public $result;
	public $tableName;
	public $row;
	protected $fetchModes;
	public $fetchmode = 'array';
	public $rowCount;
	public $rowsAffected;
	public $rowsSelected;
	public $insertId;

	/**
	 * The configuration paramaters should be hard coded for opcode speed optimization.
	 *
	 * @param string $db
	 * @return DBI Object Reference
	 */
	public static function getInstance($db = 'default')
	{
		$instance = self::$_instance;
		$instance = is_array($instance)?$instance:array();

		// if (!isset($instance[$db])) {
		if (!array_key_exists("db",$instance)) { //To solve the offset error issue
			$application = Application::getInstance();

			switch ($db) {
				case 'axis':
					$arrDbParams = $application->getConfig()->database->axis->toArray();
					break;
				case 'axis1':
					$arrDbParams = $application->getConfig()->database->axis->toArray();
					break;
				case 'axis2':
					$arrDbParams = $application->getConfig()->database->axis2->toArray();
					break;
				case 'engine':
					$arrDbParams = $application->getConfig()->database->engine->toArray();
					break;
				case 'location':
					$arrDbParams = $application->getConfig()->database->location->toArray();
					break;
				case 'log':
					$arrDbParams = $application->getConfig()->database->log->toArray();
					break;
				case 'search':
					$arrDbParams = $application->getConfig()->database->search->toArray();
					break;
				case 'session':
					$arrDbParams = $application->getConfig()->database->session->toArray();
					break;
				case 'session_gc':
					$arrDbParams = $application->getConfig()->database->session->toArray();
					break;
				default:
					$arrDbParams = $application->getConfig()->database->axis->toArray();
					break;
			}

			//Set global run type (cli or web)
			$sapi = $application->getSapi();

			// Allow socket or named-pipe connections
			if (isset($arrDbParams['socket'])) {
				$socket = $arrDbParams['socket'];
			} else {
				$socket = false;
			}
			$driverName = $arrDbParams['driver'];
			$host = $arrDbParams['host'];
			$port = $arrDbParams['port'];
			$username = $arrDbParams['username'];
			$password = $arrDbParams['password'];
			$db_name = $arrDbParams['dbname'];
			$halt_on_db_error = $arrDbParams['halt_on_error'];
			$errorLevel = $arrDbParams['error_level'];

			if (isset($arrDbParams['table'])) {
				$table = $arrDbParams['table'];
			} else {
				$table = null;
			}

			// Commented out for performance gain since only using one driver/class for this application
			//$includeFile = 'DBI/'.$driverName.'.php';
			//require_once($includeFile);
			//$class = 'DBI_'.$driverName;
			//$dbi = new $class($host, $port, $db_name, $username, $password);
			$dbi = new DBI_mysqli($host, $port, $db_name, $username, $password);

			//Set errorLevel and error behaviour
			$dbi->sapi = $sapi;
			$dbi->errorLevel = $errorLevel;
			$dbi->systemHaltOnDbError = (bool) $halt_on_db_error;

			/**
			 * Set table on object if passed in.
			 */
			if (isset($table) && !empty($table)) {
				$dbi->tableName = $table;
			}

			$db="";
			$instance[$db] = $dbi;
			self::$_instance = $instance;

			return $dbi;
		}

		$dbi = $instance[$db];
		return $dbi;
	}

	/**
	 * Set connection values for a given singleton db connection object.
	 *
	 * @param string $host
	 * @param int $port
	 * @param string $database
	 * @param string $username
	 * @param string $password
	 * @param string $socket
	 * @return DBI Object Reference
	 */
	protected function __construct($host=null, $port=null, $database=null, $username=null, $password=null, $socket=null)
	{
		$this->host 	= $host;
		$this->port		= $port;
		$this->db		= $database;
		$this->user		= $username;
		$this->pass		= $password;
		$this->socket	= $socket;
	}

	public static function destroy($db = 'default')
	{
		if (isset(self::$_instance[$db])) {
			$dbi = self::$_instance[$db];
			/* @var $dbi DBI_mysqli */
			$dbi->disconnect();
			unset(self::$_instance[$db]);
		}
	}

	/*
	public function __destruct()
	{
		return true;
	}
	*/

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
	}

	public function reset()
	{
		// Reset error properties
		$this->connectionErrorNumber = null;
		$this->connectionErrorMessage = null;
		$this->errorNumber = null;
		$this->errorMessage = null;

		// Reset query properties
		$this->quoteFunction = null;
		$this->query = null;
		$this->queryPieces = null;
		$this->queryPrepared = false;
		$this->tableName = null;

		// Reset result-set properties
		$this->result = null;
		$this->rowCount = null;
		$this->rowsAffected = null;
		$this->rowsSelected = null;
		$this->insertId = null;
		$this->row = null;
	}

	public function connect()
	{
	}

	public function disconnect()
	{
	}

	public function prepare($query = null)
	{
	}

	public function quote($input)
	{
	}

	public function bind_param()
	{
	}

	public function bind_params(&$query_values)
	{
	}

	public function query($query = null)
	{
	}

	public function execute($query, $query_values)
	{
	}

	public function fetch()
	{
	}

	public function free_result()
	{
	}

	public function error($msg = 'No error message.', $phpmsg = 'No PHP error message.')
	{
	}

	public function lock_tables($strTableLockList)
	{
	}

	public function unlock_tables()
	{
	}

	public function begin()
	{
	}

	public function commit()
	{
	}

	public function rollback()
	{
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

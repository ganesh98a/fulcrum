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
 * Log404Referer.
 *
 * @category   Framework
 * @package    Log404Referer
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Log404Referer extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Log404Referer';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'log_404_referers';

	/**
	 * primary key (`id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'id' => 'int'
	);

	/**
	 * unique index `unique_log_404_referer` (`log_404_referer_url_sha1`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_log_404_referer' => array(
			'log_404_referer_url_sha1' => 'string'
		)
	);

	/**
	 * Standard attributes list.
	 *
	 * Metadata mapper pattern maps db attributes to object properties.
	 *
	 * Key - database attribute/field
	 * Value - object property
	 *
	 * @var array
	 */
	protected $arrAttributesMap = array(
		'id' => 'log_404_referer_id',

		'log_404_referer_url_sha1' => 'log_404_referer_url_sha1',

		'log_404_referer_url' => 'log_404_referer_url',
		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $log_404_referer_id;

	public $log_404_referer_url_sha1;

	public $log_404_referer_url;
	public $created;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_log_404_referer_url_sha1;
	public $escaped_log_404_referer_url;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrLog404ReferersByCreated;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllLog404Referers;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='log_404_referers')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrLog404ReferersByCreated()
	{
		if (isset(self::$_arrLog404ReferersByCreated)) {
			return self::$_arrLog404ReferersByCreated;
		} else {
			return null;
		}
	}

	public static function setArrLog404ReferersByCreated($arrLog404ReferersByCreated)
	{
		self::$_arrLog404ReferersByCreated = $arrLog404ReferersByCreated;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllLog404Referers()
	{
		if (isset(self::$_arrAllLog404Referers)) {
			return self::$_arrAllLog404Referers;
		} else {
			return null;
		}
	}

	public static function setArrAllLog404Referers($arrAllLog404Referers)
	{
		self::$_arrAllLog404Referers = $arrAllLog404Referers;
	}

	/*
	public function getOtherProperty()
	{
		if (isset($this->_otherPropertyHere)) {
			return $this->_otherPropertyHere;
		} else {
			return null;
		}
	}
	*/

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $log_404_referer_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $log_404_referer_id,$table='log_404_referers', $module='Log404Referer')
	{
		$log404Referer = parent::findById($database, $log_404_referer_id, $table, $module);

		return $log404Referer;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $log_404_referer_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findLog404RefererByIdExtended($database, $log_404_referer_id)
	{
		$log_404_referer_id = (int) $log_404_referer_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	l4r.*

FROM `log_404_referers` l4r
WHERE l4r.`id` = ?
";
		$arrValues = array($log_404_referer_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$log_404_referer_id = $row['id'];
			$log404Referer = self::instantiateOrm($database, 'Log404Referer', $row, null, $log_404_referer_id);
			/* @var $log404Referer Log404Referer */
			$log404Referer->convertPropertiesToData();

			return $log404Referer;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_log_404_referer` (`log_404_referer_url_sha1`).
	 *
	 * @param string $database
	 * @param string $log_404_referer_url_sha1
	 * @return mixed (single ORM object | false)
	 */
	public static function findByLog404RefererUrlSha1($database, $log_404_referer_url_sha1)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	l4r.*

FROM `log_404_referers` l4r
WHERE l4r.`log_404_referer_url_sha1` = ?
";
		$arrValues = array($log_404_referer_url_sha1);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$log_404_referer_id = $row['id'];
			$log404Referer = self::instantiateOrm($database, 'Log404Referer', $row, null, $log_404_referer_id);
			/* @var $log404Referer Log404Referer */
			return $log404Referer;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrLog404RefererIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadLog404ReferersByArrLog404RefererIds($database, $arrLog404RefererIds, Input $options=null)
	{
		if (empty($arrLog404RefererIds)) {
			return array();
		}

		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `log_404_referer_url_sha1` ASC, `log_404_referer_url` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404Referer = new Log404Referer($database);
			$sqlOrderByColumns = $tmpLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		foreach ($arrLog404RefererIds as $k => $log_404_referer_id) {
			$log_404_referer_id = (int) $log_404_referer_id;
			$arrLog404RefererIds[$k] = $db->escape($log_404_referer_id);
		}
		$csvLog404RefererIds = join(',', $arrLog404RefererIds);

		$query =
"
SELECT

	l4r.*

FROM `log_404_referers` l4r
WHERE l4r.`id` IN ($csvLog404RefererIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrLog404ReferersByCsvLog404RefererIds = array();
		while ($row = $db->fetch()) {
			$log_404_referer_id = $row['id'];
			$log404Referer = self::instantiateOrm($database, 'Log404Referer', $row, null, $log_404_referer_id);
			/* @var $log404Referer Log404Referer */
			$log404Referer->convertPropertiesToData();

			$arrLog404ReferersByCsvLog404RefererIds[$log_404_referer_id] = $log404Referer;
		}

		$db->free_result();

		return $arrLog404ReferersByCsvLog404RefererIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index
	/**
	 * Load by key `created` (`created`).
	 *
	 * @param string $database
	 * @param string $created
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadLog404ReferersByCreated($database, $created, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrLog404ReferersByCreated = null;
		}

		$arrLog404ReferersByCreated = self::$_arrLog404ReferersByCreated;
		if (isset($arrLog404ReferersByCreated) && !empty($arrLog404ReferersByCreated)) {
			return $arrLog404ReferersByCreated;
		}

		$created = (string) $created;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `log_404_referer_url_sha1` ASC, `log_404_referer_url` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404Referer = new Log404Referer($database);
			$sqlOrderByColumns = $tmpLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$query =
"
SELECT
	l4r.*

FROM `log_404_referers` l4r
WHERE l4r.`created` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `log_404_referer_url_sha1` ASC, `log_404_referer_url` ASC, `created` ASC
		$arrValues = array($created);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrLog404ReferersByCreated = array();
		while ($row = $db->fetch()) {
			$log_404_referer_id = $row['id'];
			$log404Referer = self::instantiateOrm($database, 'Log404Referer', $row, null, $log_404_referer_id);
			/* @var $log404Referer Log404Referer */
			$arrLog404ReferersByCreated[$log_404_referer_id] = $log404Referer;
		}

		$db->free_result();

		self::$_arrLog404ReferersByCreated = $arrLog404ReferersByCreated;

		return $arrLog404ReferersByCreated;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all log_404_referers records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllLog404Referers($database, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrAllLog404Referers = null;
		}

		$arrAllLog404Referers = self::$_arrAllLog404Referers;
		if (isset($arrAllLog404Referers) && !empty($arrAllLog404Referers)) {
			return $arrAllLog404Referers;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `log_404_referer_url_sha1` ASC, `log_404_referer_url` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404Referer = new Log404Referer($database);
			$sqlOrderByColumns = $tmpLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$query =
"
SELECT
	l4r.*

FROM `log_404_referers` l4r{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `log_404_referer_url_sha1` ASC, `log_404_referer_url` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllLog404Referers = array();
		while ($row = $db->fetch()) {
			$log_404_referer_id = $row['id'];
			$log404Referer = self::instantiateOrm($database, 'Log404Referer', $row, null, $log_404_referer_id);
			/* @var $log404Referer Log404Referer */
			$arrAllLog404Referers[$log_404_referer_id] = $log404Referer;
		}

		$db->free_result();

		self::$_arrAllLog404Referers = $arrAllLog404Referers;

		return $arrAllLog404Referers;
	}

	// Save: insert on duplicate key update
	public function insertOnDuplicateKeyUpdate()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT
INTO `log_404_referers`
(`log_404_referer_url_sha1`, `log_404_referer_url`, `created`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `log_404_referer_url` = ?, `created` = ?
";
		$arrValues = array($this->log_404_referer_url_sha1, $this->log_404_referer_url, $this->created, $this->log_404_referer_url, $this->created);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$log_404_referer_id = $db->insertId;
		$db->free_result();

		return $log_404_referer_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

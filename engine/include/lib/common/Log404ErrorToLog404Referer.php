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
 * Log404ErrorToLog404Referer.
 *
 * @category   Framework
 * @package    Log404ErrorToLog404Referer
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Log404ErrorToLog404Referer extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Log404ErrorToLog404Referer';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'log_404_errors_to_log_404_referers';

	/**
	 * primary key (`log_404_error_id`,`log_404_referer_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'log_404_error_id' => 'int',
		'log_404_referer_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_log_404_error_to_log_404_referer_via_primary_key' => array(
			'log_404_error_id' => 'int',
			'log_404_referer_id' => 'int'
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
		'log_404_error_id' => 'log_404_error_id',
		'log_404_referer_id' => 'log_404_referer_id',

		'occurrences' => 'occurrences',
		'modified' => 'modified'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $log_404_error_id;
	public $log_404_referer_id;

	public $occurrences;
	public $modified;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrLog404ErrorsToLog404ReferersByLog404ErrorId;
	protected static $_arrLog404ErrorsToLog404ReferersByLog404RefererId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrLog404ErrorsToLog404ReferersByOccurrences;
	protected static $_arrLog404ErrorsToLog404ReferersByModified;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllLog404ErrorsToLog404Referers;

	// Foreign Key Objects
	private $_log404Error;
	private $_log404Referer;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='log_404_errors_to_log_404_referers')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getLog404Error()
	{
		if (isset($this->_log404Error)) {
			return $this->_log404Error;
		} else {
			return null;
		}
	}

	public function setLog404Error($log404Error)
	{
		$this->_log404Error = $log404Error;
	}

	public function getLog404Referer()
	{
		if (isset($this->_log404Referer)) {
			return $this->_log404Referer;
		} else {
			return null;
		}
	}

	public function setLog404Referer($log404Referer)
	{
		$this->_log404Referer = $log404Referer;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrLog404ErrorsToLog404ReferersByLog404ErrorId()
	{
		if (isset(self::$_arrLog404ErrorsToLog404ReferersByLog404ErrorId)) {
			return self::$_arrLog404ErrorsToLog404ReferersByLog404ErrorId;
		} else {
			return null;
		}
	}

	public static function setArrLog404ErrorsToLog404ReferersByLog404ErrorId($arrLog404ErrorsToLog404ReferersByLog404ErrorId)
	{
		self::$_arrLog404ErrorsToLog404ReferersByLog404ErrorId = $arrLog404ErrorsToLog404ReferersByLog404ErrorId;
	}

	public static function getArrLog404ErrorsToLog404ReferersByLog404RefererId()
	{
		if (isset(self::$_arrLog404ErrorsToLog404ReferersByLog404RefererId)) {
			return self::$_arrLog404ErrorsToLog404ReferersByLog404RefererId;
		} else {
			return null;
		}
	}

	public static function setArrLog404ErrorsToLog404ReferersByLog404RefererId($arrLog404ErrorsToLog404ReferersByLog404RefererId)
	{
		self::$_arrLog404ErrorsToLog404ReferersByLog404RefererId = $arrLog404ErrorsToLog404ReferersByLog404RefererId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrLog404ErrorsToLog404ReferersByOccurrences()
	{
		if (isset(self::$_arrLog404ErrorsToLog404ReferersByOccurrences)) {
			return self::$_arrLog404ErrorsToLog404ReferersByOccurrences;
		} else {
			return null;
		}
	}

	public static function setArrLog404ErrorsToLog404ReferersByOccurrences($arrLog404ErrorsToLog404ReferersByOccurrences)
	{
		self::$_arrLog404ErrorsToLog404ReferersByOccurrences = $arrLog404ErrorsToLog404ReferersByOccurrences;
	}

	public static function getArrLog404ErrorsToLog404ReferersByModified()
	{
		if (isset(self::$_arrLog404ErrorsToLog404ReferersByModified)) {
			return self::$_arrLog404ErrorsToLog404ReferersByModified;
		} else {
			return null;
		}
	}

	public static function setArrLog404ErrorsToLog404ReferersByModified($arrLog404ErrorsToLog404ReferersByModified)
	{
		self::$_arrLog404ErrorsToLog404ReferersByModified = $arrLog404ErrorsToLog404ReferersByModified;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllLog404ErrorsToLog404Referers()
	{
		if (isset(self::$_arrAllLog404ErrorsToLog404Referers)) {
			return self::$_arrAllLog404ErrorsToLog404Referers;
		} else {
			return null;
		}
	}

	public static function setArrAllLog404ErrorsToLog404Referers($arrAllLog404ErrorsToLog404Referers)
	{
		self::$_arrAllLog404ErrorsToLog404Referers = $arrAllLog404ErrorsToLog404Referers;
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
	 * Find by primary key (`log_404_error_id`,`log_404_referer_id`).
	 *
	 * @param string $database
	 * @param int $log_404_error_id
	 * @param int $log_404_referer_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByLog404ErrorIdAndLog404RefererId($database, $log_404_error_id, $log_404_referer_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	l4e2l4r.*

FROM `log_404_errors_to_log_404_referers` l4e2l4r
WHERE l4e2l4r.`log_404_error_id` = ?
AND l4e2l4r.`log_404_referer_id` = ?
";
		$arrValues = array($log_404_error_id, $log_404_referer_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$log404ErrorToLog404Referer = self::instantiateOrm($database, 'Log404ErrorToLog404Referer', $row);
			/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */
			return $log404ErrorToLog404Referer;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`log_404_error_id`,`log_404_referer_id`) Extended.
	 *
	 * @param string $database
	 * @param int $log_404_error_id
	 * @param int $log_404_referer_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByLog404ErrorIdAndLog404RefererIdExtended($database, $log_404_error_id, $log_404_referer_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	l4e2l4r_fk_l4e.`id` AS 'l4e2l4r_fk_l4e__log_404_error_id',
	l4e2l4r_fk_l4e.`log_404_url_sha1` AS 'l4e2l4r_fk_l4e__log_404_url_sha1',
	l4e2l4r_fk_l4e.`log_404_url` AS 'l4e2l4r_fk_l4e__log_404_url',
	l4e2l4r_fk_l4e.`created` AS 'l4e2l4r_fk_l4e__created',

	l4e2l4r_fk_l4r.`id` AS 'l4e2l4r_fk_l4r__log_404_referer_id',
	l4e2l4r_fk_l4r.`log_404_referer_url_sha1` AS 'l4e2l4r_fk_l4r__log_404_referer_url_sha1',
	l4e2l4r_fk_l4r.`log_404_referer_url` AS 'l4e2l4r_fk_l4r__log_404_referer_url',
	l4e2l4r_fk_l4r.`created` AS 'l4e2l4r_fk_l4r__created',

	l4e2l4r.*

FROM `log_404_errors_to_log_404_referers` l4e2l4r
	INNER JOIN `log_404_errors` l4e2l4r_fk_l4e ON l4e2l4r.`log_404_error_id` = l4e2l4r_fk_l4e.`id`
	INNER JOIN `log_404_referers` l4e2l4r_fk_l4r ON l4e2l4r.`log_404_referer_id` = l4e2l4r_fk_l4r.`id`
WHERE l4e2l4r.`log_404_error_id` = ?
AND l4e2l4r.`log_404_referer_id` = ?
";
		$arrValues = array($log_404_error_id, $log_404_referer_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$log404ErrorToLog404Referer = self::instantiateOrm($database, 'Log404ErrorToLog404Referer', $row);
			/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */
			$log404ErrorToLog404Referer->convertPropertiesToData();

			if (isset($row['log_404_error_id'])) {
				$log_404_error_id = $row['log_404_error_id'];
				$row['l4e2l4r_fk_l4e__id'] = $log_404_error_id;
				$log404Error = self::instantiateOrm($database, 'Log404Error', $row, null, $log_404_error_id, 'l4e2l4r_fk_l4e__');
				/* @var $log404Error Log404Error */
				$log404Error->convertPropertiesToData();
			} else {
				$log404Error = false;
			}
			$log404ErrorToLog404Referer->setLog404Error($log404Error);

			if (isset($row['log_404_referer_id'])) {
				$log_404_referer_id = $row['log_404_referer_id'];
				$row['l4e2l4r_fk_l4r__id'] = $log_404_referer_id;
				$log404Referer = self::instantiateOrm($database, 'Log404Referer', $row, null, $log_404_referer_id, 'l4e2l4r_fk_l4r__');
				/* @var $log404Referer Log404Referer */
				$log404Referer->convertPropertiesToData();
			} else {
				$log404Referer = false;
			}
			$log404ErrorToLog404Referer->setLog404Referer($log404Referer);

			return $log404ErrorToLog404Referer;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by a list of non auto int primary keys (array of primary keys).
	 *
	 * @param string $database
	 * @param array $arrLog404ErrorIdAndLog404RefererIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadLog404ErrorsToLog404ReferersByArrLog404ErrorIdAndLog404RefererIdList($database, $arrLog404ErrorIdAndLog404RefererIdList, Input $options=null)
	{
		if (empty($arrLog404ErrorIdAndLog404RefererIdList)) {
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
		// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404ErrorToLog404Referer = new Log404ErrorToLog404Referer($database);
			$sqlOrderByColumns = $tmpLog404ErrorToLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$arrSqlWhere = array();
		foreach ($arrLog404ErrorIdAndLog404RefererIdList as $k => $arrTmp) {
			$tmpInnerAnd = '';
			$first = true;
			foreach ($arrTmp as $tmpPrimaryKeyAttribute => $tmpPrimaryKeyValue) {
				$tmpPrimaryKeyAttributeEscaped = $db->escape($tmpPrimaryKeyAttribute);
				$tmpPrimaryKeyValueEscaped = $db->escape($tmpPrimaryKeyValue);
				if ($first) {
					$first = false;
					$tmpInnerAnd = "`$tmpPrimaryKeyAttribute` = '$tmpPrimaryKeyValueEscaped'";
				} else {
					$tmpInnerAnd .= " AND `$tmpPrimaryKeyAttribute` = '$tmpPrimaryKeyValueEscaped'";
				}
			}
			$tmpInnerAnd = "($tmpInnerAnd)";
			$arrSqlWhere[] = $tmpInnerAnd;
		}
		if (count($arrLog404ErrorIdAndLog404RefererIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	l4e2l4r.*

FROM `log_404_errors_to_log_404_referers` l4e2l4r
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrLog404ErrorsToLog404ReferersByArrLog404ErrorIdAndLog404RefererIdList = array();
		while ($row = $db->fetch()) {
			$log404ErrorToLog404Referer = self::instantiateOrm($database, 'Log404ErrorToLog404Referer', $row);
			/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */
			$arrLog404ErrorsToLog404ReferersByArrLog404ErrorIdAndLog404RefererIdList[] = $log404ErrorToLog404Referer;
		}

		$db->free_result();

		return $arrLog404ErrorsToLog404ReferersByArrLog404ErrorIdAndLog404RefererIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `log_404_errors_to_log_404_referers_fk_l4e` foreign key (`log_404_error_id`) references `log_404_errors` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $log_404_error_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadLog404ErrorsToLog404ReferersByLog404ErrorId($database, $log_404_error_id, Input $options=null)
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
			self::$_arrLog404ErrorsToLog404ReferersByLog404ErrorId = null;
		}

		$arrLog404ErrorsToLog404ReferersByLog404ErrorId = self::$_arrLog404ErrorsToLog404ReferersByLog404ErrorId;
		if (isset($arrLog404ErrorsToLog404ReferersByLog404ErrorId) && !empty($arrLog404ErrorsToLog404ReferersByLog404ErrorId)) {
			return $arrLog404ErrorsToLog404ReferersByLog404ErrorId;
		}

		$log_404_error_id = (int) $log_404_error_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404ErrorToLog404Referer = new Log404ErrorToLog404Referer($database);
			$sqlOrderByColumns = $tmpLog404ErrorToLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

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
	l4e2l4r.*

FROM `log_404_errors_to_log_404_referers` l4e2l4r
WHERE l4e2l4r.`log_404_error_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$arrValues = array($log_404_error_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrLog404ErrorsToLog404ReferersByLog404ErrorId = array();
		while ($row = $db->fetch()) {
			$log404ErrorToLog404Referer = self::instantiateOrm($database, 'Log404ErrorToLog404Referer', $row);
			/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */
			$arrLog404ErrorsToLog404ReferersByLog404ErrorId[] = $log404ErrorToLog404Referer;
		}

		$db->free_result();

		self::$_arrLog404ErrorsToLog404ReferersByLog404ErrorId = $arrLog404ErrorsToLog404ReferersByLog404ErrorId;

		return $arrLog404ErrorsToLog404ReferersByLog404ErrorId;
	}

	/**
	 * Load by constraint `log_404_errors_to_log_404_referers_fk_l4r` foreign key (`log_404_referer_id`) references `log_404_referers` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $log_404_referer_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadLog404ErrorsToLog404ReferersByLog404RefererId($database, $log_404_referer_id, Input $options=null)
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
			self::$_arrLog404ErrorsToLog404ReferersByLog404RefererId = null;
		}

		$arrLog404ErrorsToLog404ReferersByLog404RefererId = self::$_arrLog404ErrorsToLog404ReferersByLog404RefererId;
		if (isset($arrLog404ErrorsToLog404ReferersByLog404RefererId) && !empty($arrLog404ErrorsToLog404ReferersByLog404RefererId)) {
			return $arrLog404ErrorsToLog404ReferersByLog404RefererId;
		}

		$log_404_referer_id = (int) $log_404_referer_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404ErrorToLog404Referer = new Log404ErrorToLog404Referer($database);
			$sqlOrderByColumns = $tmpLog404ErrorToLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

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
	l4e2l4r.*

FROM `log_404_errors_to_log_404_referers` l4e2l4r
WHERE l4e2l4r.`log_404_referer_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$arrValues = array($log_404_referer_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrLog404ErrorsToLog404ReferersByLog404RefererId = array();
		while ($row = $db->fetch()) {
			$log404ErrorToLog404Referer = self::instantiateOrm($database, 'Log404ErrorToLog404Referer', $row);
			/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */
			$arrLog404ErrorsToLog404ReferersByLog404RefererId[] = $log404ErrorToLog404Referer;
		}

		$db->free_result();

		self::$_arrLog404ErrorsToLog404ReferersByLog404RefererId = $arrLog404ErrorsToLog404ReferersByLog404RefererId;

		return $arrLog404ErrorsToLog404ReferersByLog404RefererId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `occurrences` (`occurrences`).
	 *
	 * @param string $database
	 * @param int $occurrences
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadLog404ErrorsToLog404ReferersByOccurrences($database, $occurrences, Input $options=null)
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
			self::$_arrLog404ErrorsToLog404ReferersByOccurrences = null;
		}

		$arrLog404ErrorsToLog404ReferersByOccurrences = self::$_arrLog404ErrorsToLog404ReferersByOccurrences;
		if (isset($arrLog404ErrorsToLog404ReferersByOccurrences) && !empty($arrLog404ErrorsToLog404ReferersByOccurrences)) {
			return $arrLog404ErrorsToLog404ReferersByOccurrences;
		}

		$occurrences = (int) $occurrences;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404ErrorToLog404Referer = new Log404ErrorToLog404Referer($database);
			$sqlOrderByColumns = $tmpLog404ErrorToLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

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
	l4e2l4r.*

FROM `log_404_errors_to_log_404_referers` l4e2l4r
WHERE l4e2l4r.`occurrences` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$arrValues = array($occurrences);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrLog404ErrorsToLog404ReferersByOccurrences = array();
		while ($row = $db->fetch()) {
			$log404ErrorToLog404Referer = self::instantiateOrm($database, 'Log404ErrorToLog404Referer', $row);
			/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */
			$arrLog404ErrorsToLog404ReferersByOccurrences[] = $log404ErrorToLog404Referer;
		}

		$db->free_result();

		self::$_arrLog404ErrorsToLog404ReferersByOccurrences = $arrLog404ErrorsToLog404ReferersByOccurrences;

		return $arrLog404ErrorsToLog404ReferersByOccurrences;
	}

	/**
	 * Load by key `modified` (`modified`).
	 *
	 * @param string $database
	 * @param string $modified
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadLog404ErrorsToLog404ReferersByModified($database, $modified, Input $options=null)
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
			self::$_arrLog404ErrorsToLog404ReferersByModified = null;
		}

		$arrLog404ErrorsToLog404ReferersByModified = self::$_arrLog404ErrorsToLog404ReferersByModified;
		if (isset($arrLog404ErrorsToLog404ReferersByModified) && !empty($arrLog404ErrorsToLog404ReferersByModified)) {
			return $arrLog404ErrorsToLog404ReferersByModified;
		}

		$modified = (string) $modified;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404ErrorToLog404Referer = new Log404ErrorToLog404Referer($database);
			$sqlOrderByColumns = $tmpLog404ErrorToLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

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
	l4e2l4r.*

FROM `log_404_errors_to_log_404_referers` l4e2l4r
WHERE l4e2l4r.`modified` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$arrValues = array($modified);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrLog404ErrorsToLog404ReferersByModified = array();
		while ($row = $db->fetch()) {
			$log404ErrorToLog404Referer = self::instantiateOrm($database, 'Log404ErrorToLog404Referer', $row);
			/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */
			$arrLog404ErrorsToLog404ReferersByModified[] = $log404ErrorToLog404Referer;
		}

		$db->free_result();

		self::$_arrLog404ErrorsToLog404ReferersByModified = $arrLog404ErrorsToLog404ReferersByModified;

		return $arrLog404ErrorsToLog404ReferersByModified;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all log_404_errors_to_log_404_referers records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllLog404ErrorsToLog404Referers($database, Input $options=null)
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
			self::$_arrAllLog404ErrorsToLog404Referers = null;
		}

		$arrAllLog404ErrorsToLog404Referers = self::$_arrAllLog404ErrorsToLog404Referers;
		if (isset($arrAllLog404ErrorsToLog404Referers) && !empty($arrAllLog404ErrorsToLog404Referers)) {
			return $arrAllLog404ErrorsToLog404Referers;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpLog404ErrorToLog404Referer = new Log404ErrorToLog404Referer($database);
			$sqlOrderByColumns = $tmpLog404ErrorToLog404Referer->constructSqlOrderByColumns($arrOrderByAttributes);

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
	l4e2l4r.*

FROM `log_404_errors_to_log_404_referers` l4e2l4r{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `log_404_error_id` ASC, `log_404_referer_id` ASC, `occurrences` ASC, `modified` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllLog404ErrorsToLog404Referers = array();
		while ($row = $db->fetch()) {
			$log404ErrorToLog404Referer = self::instantiateOrm($database, 'Log404ErrorToLog404Referer', $row);
			/* @var $log404ErrorToLog404Referer Log404ErrorToLog404Referer */
			$arrAllLog404ErrorsToLog404Referers[] = $log404ErrorToLog404Referer;
		}

		$db->free_result();

		self::$_arrAllLog404ErrorsToLog404Referers = $arrAllLog404ErrorsToLog404Referers;

		return $arrAllLog404ErrorsToLog404Referers;
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
INTO `log_404_errors_to_log_404_referers`
(`log_404_error_id`, `log_404_referer_id`, `occurrences`, `modified`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `occurrences` = ?, `modified` = ?
";
		$arrValues = array($this->log_404_error_id, $this->log_404_referer_id, $this->occurrences, $this->modified, $this->occurrences, $this->modified);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$log_404_error_to_log_404_referer_id = $db->insertId;
		$db->free_result();

		return $log_404_error_to_log_404_referer_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

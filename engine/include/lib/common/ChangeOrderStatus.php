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
 * ChangeOrderStatus.
 *
 * @category   Framework
 * @package    ChangeOrderStatus
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ChangeOrderStatus extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrderStatus';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_order_statuses';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order_status';

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
	 * unique index `unique_change_order_status` (`change_order_status`) comment 'CO Statuses transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_change_order_status' => array(
			'change_order_status' => 'string'
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
		'id' => 'change_order_status_id',

		'change_order_status' => 'change_order_status',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_status_id;

	public $change_order_status;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_change_order_status;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_change_order_status_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrderStatuses;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='change_order_statuses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrderStatuses()
	{
		if (isset(self::$_arrAllChangeOrderStatuses)) {
			return self::$_arrAllChangeOrderStatuses;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrderStatuses($arrAllChangeOrderStatuses)
	{
		self::$_arrAllChangeOrderStatuses = $arrAllChangeOrderStatuses;
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
	 * @param int $change_order_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $change_order_status_id, $table='change_order_statuses', $module='ChangeOrderStatus')
	{
		$changeOrderStatus = parent::findById($database, $change_order_status_id, $table, $module);

		return $changeOrderStatus;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $change_order_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findChangeOrderStatusByIdExtended($database, $change_order_status_id)
	{
		$change_order_status_id = (int) $change_order_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cos.*

FROM `change_order_statuses` cos
WHERE cos.`id` = ?
";
		$arrValues = array($change_order_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$change_order_status_id = $row['id'];
			$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id);
			/* @var $changeOrderStatus ChangeOrderStatus */
			$changeOrderStatus->convertPropertiesToData();

			return $changeOrderStatus;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_change_order_status` (`change_order_status`) comment 'CO Statuses transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $change_order_status
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderStatus($database, $change_order_status)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cos.*

FROM `change_order_statuses` cos
WHERE cos.`change_order_status` = ?
";
		$arrValues = array($change_order_status);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$change_order_status_id = $row['id'];
			$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id);
			/* @var $changeOrderStatus ChangeOrderStatus */
			return $changeOrderStatus;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrChangeOrderStatusIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderStatusesByArrChangeOrderStatusIds($database, $arrChangeOrderStatusIds, Input $options=null)
	{
		if (empty($arrChangeOrderStatusIds)) {
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
		// ORDER BY `id` ASC, `change_order_status` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderStatus = new ChangeOrderStatus($database);
			$sqlOrderByColumns = $tmpChangeOrderStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrChangeOrderStatusIds as $k => $change_order_status_id) {
			$change_order_status_id = (int) $change_order_status_id;
			$arrChangeOrderStatusIds[$k] = $db->escape($change_order_status_id);
		}
		$csvChangeOrderStatusIds = join(',', $arrChangeOrderStatusIds);

		$query =
"
SELECT

	cos.*

FROM `change_order_statuses` cos
WHERE cos.`id` IN ($csvChangeOrderStatusIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrChangeOrderStatusesByCsvChangeOrderStatusIds = array();
		while ($row = $db->fetch()) {
			$change_order_status_id = $row['id'];
			$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id);
			/* @var $changeOrderStatus ChangeOrderStatus */
			$changeOrderStatus->convertPropertiesToData();

			$arrChangeOrderStatusesByCsvChangeOrderStatusIds[$change_order_status_id] = $changeOrderStatus;
		}

		$db->free_result();

		return $arrChangeOrderStatusesByCsvChangeOrderStatusIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_order_statuses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrderStatuses($database, Input $options=null)
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
			self::$_arrAllChangeOrderStatuses = null;
		}

		$arrAllChangeOrderStatuses = self::$_arrAllChangeOrderStatuses;
		if (isset($arrAllChangeOrderStatuses) && !empty($arrAllChangeOrderStatuses)) {
			return $arrAllChangeOrderStatuses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_status` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderStatus = new ChangeOrderStatus($database);
			$sqlOrderByColumns = $tmpChangeOrderStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cos.*

FROM `change_order_statuses` cos{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_status` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrderStatuses = array();
		while ($row = $db->fetch()) {
			$change_order_status_id = $row['id'];
			$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id);
			/* @var $changeOrderStatus ChangeOrderStatus */
			$arrAllChangeOrderStatuses[$change_order_status_id] = $changeOrderStatus;
		}

		$db->free_result();

		self::$_arrAllChangeOrderStatuses = $arrAllChangeOrderStatuses;

		return $arrAllChangeOrderStatuses;
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
INTO `change_order_statuses`
(`change_order_status`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->change_order_status, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$change_order_status_id = $db->insertId;
		$db->free_result();

		return $change_order_status_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * ActionItemPriority.
 *
 * @category   Framework
 * @package    ActionItemPriority
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ActionItemPriority extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ActionItemPriority';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'action_item_priorities';

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
	 * unique index `unique_action_item_priority` (`action_item_priority`) comment 'Action Item Priorities transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_action_item_priority' => array(
			'action_item_priority' => 'string'
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
		'id' => 'action_item_priority_id',

		'action_item_priority' => 'action_item_priority',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $action_item_priority_id;

	public $action_item_priority;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_action_item_priority;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_action_item_priority_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllActionItemPriorities;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='action_item_priorities')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllActionItemPriorities()
	{
		if (isset(self::$_arrAllActionItemPriorities)) {
			return self::$_arrAllActionItemPriorities;
		} else {
			return null;
		}
	}

	public static function setArrAllActionItemPriorities($arrAllActionItemPriorities)
	{
		self::$_arrAllActionItemPriorities = $arrAllActionItemPriorities;
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
	 * @param int $action_item_priority_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $action_item_priority_id, $table='action_item_priorities', $module='ActionItemPriority')
	{
		$actionItemPriority = parent::findById($database, $action_item_priority_id, $table, $module);

		return $actionItemPriority;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $action_item_priority_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findActionItemPriorityByIdExtended($database, $action_item_priority_id)
	{
		$action_item_priority_id = (int) $action_item_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	aip.*

FROM `action_item_priorities` aip
WHERE aip.`id` = ?
";
		$arrValues = array($action_item_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$action_item_priority_id = $row['id'];
			$actionItemPriority = self::instantiateOrm($database, 'ActionItemPriority', $row, null, $action_item_priority_id);
			/* @var $actionItemPriority ActionItemPriority */
			$actionItemPriority->convertPropertiesToData();

			return $actionItemPriority;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_action_item_priority` (`action_item_priority`) comment 'Action Item Priorities transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $action_item_priority
	 * @return mixed (single ORM object | false)
	 */
	public static function findByActionItemPriority($database, $action_item_priority)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	aip.*

FROM `action_item_priorities` aip
WHERE aip.`action_item_priority` = ?
";
		$arrValues = array($action_item_priority);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$action_item_priority_id = $row['id'];
			$actionItemPriority = self::instantiateOrm($database, 'ActionItemPriority', $row, null, $action_item_priority_id);
			/* @var $actionItemPriority ActionItemPriority */
			return $actionItemPriority;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrActionItemPriorityIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemPrioritiesByArrActionItemPriorityIds($database, $arrActionItemPriorityIds, Input $options=null)
	{
		if (empty($arrActionItemPriorityIds)) {
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
		// ORDER BY `id` ASC, `action_item_priority` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemPriority = new ActionItemPriority($database);
			$sqlOrderByColumns = $tmpActionItemPriority->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrActionItemPriorityIds as $k => $action_item_priority_id) {
			$action_item_priority_id = (int) $action_item_priority_id;
			$arrActionItemPriorityIds[$k] = $db->escape($action_item_priority_id);
		}
		$csvActionItemPriorityIds = join(',', $arrActionItemPriorityIds);

		$query =
"
SELECT

	aip.*

FROM `action_item_priorities` aip
WHERE aip.`id` IN ($csvActionItemPriorityIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrActionItemPrioritiesByCsvActionItemPriorityIds = array();
		while ($row = $db->fetch()) {
			$action_item_priority_id = $row['id'];
			$actionItemPriority = self::instantiateOrm($database, 'ActionItemPriority', $row, null, $action_item_priority_id);
			/* @var $actionItemPriority ActionItemPriority */
			$actionItemPriority->convertPropertiesToData();

			$arrActionItemPrioritiesByCsvActionItemPriorityIds[$action_item_priority_id] = $actionItemPriority;
		}

		$db->free_result();

		return $arrActionItemPrioritiesByCsvActionItemPriorityIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all action_item_priorities records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllActionItemPriorities($database, Input $options=null)
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
			self::$_arrAllActionItemPriorities = null;
		}

		$arrAllActionItemPriorities = self::$_arrAllActionItemPriorities;
		if (isset($arrAllActionItemPriorities) && !empty($arrAllActionItemPriorities)) {
			return $arrAllActionItemPriorities;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `action_item_priority` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemPriority = new ActionItemPriority($database);
			$sqlOrderByColumns = $tmpActionItemPriority->constructSqlOrderByColumns($arrOrderByAttributes);

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
	aip.*

FROM `action_item_priorities` aip{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `action_item_priority` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllActionItemPriorities = array();
		while ($row = $db->fetch()) {
			$action_item_priority_id = $row['id'];
			$actionItemPriority = self::instantiateOrm($database, 'ActionItemPriority', $row, null, $action_item_priority_id);
			/* @var $actionItemPriority ActionItemPriority */
			$arrAllActionItemPriorities[$action_item_priority_id] = $actionItemPriority;
		}

		$db->free_result();

		self::$_arrAllActionItemPriorities = $arrAllActionItemPriorities;

		return $arrAllActionItemPriorities;
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
INTO `action_item_priorities`
(`action_item_priority`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->action_item_priority, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$action_item_priority_id = $db->insertId;
		$db->free_result();

		return $action_item_priority_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

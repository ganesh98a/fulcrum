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
 * ActionItemType.
 *
 * @category   Framework
 * @package    ActionItemType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ActionItemType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ActionItemType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'action_item_types';

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
	 * unique index `unique_action_item_type` (`action_item_type`) comment 'Action Item Types transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_action_item_type' => array(
			'action_item_type' => 'string'
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
		'id' => 'action_item_type_id',

		'action_item_type' => 'action_item_type',

		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $action_item_type_id;

	public $action_item_type;

	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_action_item_type;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_action_item_type_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllActionItemTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='action_item_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllActionItemTypes()
	{
		if (isset(self::$_arrAllActionItemTypes)) {
			return self::$_arrAllActionItemTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllActionItemTypes($arrAllActionItemTypes)
	{
		self::$_arrAllActionItemTypes = $arrAllActionItemTypes;
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
	 * @param int $action_item_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $action_item_type_id, $table='action_item_types', $module='ActionItemType')
	{
		$actionItemType = parent::findById($database, $action_item_type_id, $table, $module);

		return $actionItemType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $action_item_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findActionItemTypeByIdExtended($database, $action_item_type_id)
	{
		$action_item_type_id = (int) $action_item_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ait.*

FROM `action_item_types` ait
WHERE ait.`id` = ?
";
		$arrValues = array($action_item_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$action_item_type_id = $row['id'];
			$actionItemType = self::instantiateOrm($database, 'ActionItemType', $row, null, $action_item_type_id);
			/* @var $actionItemType ActionItemType */
			$actionItemType->convertPropertiesToData();

			return $actionItemType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_action_item_type` (`action_item_type`) comment 'Action Item Types transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $action_item_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByActionItemType($database, $action_item_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
"
SELECT
	ait.*

FROM `action_item_types` ait
WHERE ait.`action_item_type` = ?
";
		$arrValues = array($action_item_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$action_item_type_id = $row['id'];
			$actionItemType = self::instantiateOrm($database, 'ActionItemType', $row, null, $action_item_type_id);
			/* @var $actionItemType ActionItemType */
			return $actionItemType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrActionItemTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemTypesByArrActionItemTypeIds($database, $arrActionItemTypeIds, Input $options=null)
	{
		if (empty($arrActionItemTypeIds)) {
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
		// ORDER BY `id` ASC, `action_item_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ait.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemType = new ActionItemType($database);
			$sqlOrderByColumns = $tmpActionItemType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrActionItemTypeIds as $k => $action_item_type_id) {
			$action_item_type_id = (int) $action_item_type_id;
			$arrActionItemTypeIds[$k] = $db->escape($action_item_type_id);
		}
		$csvActionItemTypeIds = join(',', $arrActionItemTypeIds);

		$query =
"
SELECT

	ait.*

FROM `action_item_types` ait
WHERE ait.`id` IN ($csvActionItemTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrActionItemTypesByCsvActionItemTypeIds = array();
		while ($row = $db->fetch()) {
			$action_item_type_id = $row['id'];
			$actionItemType = self::instantiateOrm($database, 'ActionItemType', $row, null, $action_item_type_id);
			/* @var $actionItemType ActionItemType */
			$actionItemType->convertPropertiesToData();

			$arrActionItemTypesByCsvActionItemTypeIds[$action_item_type_id] = $actionItemType;
		}

		$db->free_result();

		return $arrActionItemTypesByCsvActionItemTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all action_item_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllActionItemTypes($database, Input $options=null)
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
			self::$_arrAllActionItemTypes = null;
		}

		$arrAllActionItemTypes = self::$_arrAllActionItemTypes;
		if (isset($arrAllActionItemTypes) && !empty($arrAllActionItemTypes)) {
			return $arrAllActionItemTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `action_item_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ait.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemType = new ActionItemType($database);
			$sqlOrderByColumns = $tmpActionItemType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ait.*

FROM `action_item_types` ait{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `action_item_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllActionItemTypes = array();
		while ($row = $db->fetch()) {
			$action_item_type_id = $row['id'];
			$actionItemType = self::instantiateOrm($database, 'ActionItemType', $row, null, $action_item_type_id);
			/* @var $actionItemType ActionItemType */
			$arrAllActionItemTypes[$action_item_type_id] = $actionItemType;
		}

		$db->free_result();

		self::$_arrAllActionItemTypes = $arrAllActionItemTypes;

		return $arrAllActionItemTypes;
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
INTO `action_item_types`
(`action_item_type`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->action_item_type, $this->sort_order, $this->disabled_flag, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$action_item_type_id = $db->insertId;
		$db->free_result();

		return $action_item_type_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * GcBudgetLineItemRelationship.
 *
 * @category   Framework
 * @package    GcBudgetLineItemRelationship
 */

/**
 * @see GcBudgetLineItem
 */
require_once('lib/common/GcBudgetLineItem.php');

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class GcBudgetLineItemRelationship extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'GcBudgetLineItemRelationship';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'gc_budget_line_item_relationships';

	/**
	 * primary key (`gc_budget_line_item_id`,`linked_gc_budget_line_item_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'gc_budget_line_item_id' => 'int',
		'linked_gc_budget_line_item_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_gc_budget_line_item_relationship_via_primary_key' => array(
			'gc_budget_line_item_id' => 'int',
			'linked_gc_budget_line_item_id' => 'int'
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
		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'linked_gc_budget_line_item_id' => 'linked_gc_budget_line_item_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $gc_budget_line_item_id;
	public $linked_gc_budget_line_item_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId;
	protected static $_arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllGcBudgetLineItemRelationships;

	protected static $_arrLinkedGcBudgetLineItems;

	// Foreign Key Objects
	private $_gcBudgetLineItem;
	private $_linkedGcBudgetLineItem;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='gc_budget_line_item_relationships')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getGcBudgetLineItem()
	{
		if (isset($this->_gcBudgetLineItem)) {
			return $this->_gcBudgetLineItem;
		} else {
			return null;
		}
	}

	public function setGcBudgetLineItem($gcBudgetLineItem)
	{
		$this->_gcBudgetLineItem = $gcBudgetLineItem;
	}

	public function getLinkedGcBudgetLineItem()
	{
		if (isset($this->_linkedGcBudgetLineItem)) {
			return $this->_linkedGcBudgetLineItem;
		} else {
			return null;
		}
	}

	public function setLinkedGcBudgetLineItem($linkedGcBudgetLineItem)
	{
		$this->_linkedGcBudgetLineItem = $linkedGcBudgetLineItem;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrGcBudgetLineItemRelationshipsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId)) {
			return self::$_arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemRelationshipsByGcBudgetLineItemId($arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId)
	{
		self::$_arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId = $arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId;
	}

	public static function getArrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId()
	{
		if (isset(self::$_arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId)) {
			return self::$_arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId($arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId)
	{
		self::$_arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId = $arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllGcBudgetLineItemRelationships()
	{
		if (isset(self::$_arrAllGcBudgetLineItemRelationships)) {
			return self::$_arrAllGcBudgetLineItemRelationships;
		} else {
			return null;
		}
	}

	public static function setArrAllGcBudgetLineItemRelationships($arrAllGcBudgetLineItemRelationships)
	{
		self::$_arrAllGcBudgetLineItemRelationships = $arrAllGcBudgetLineItemRelationships;
	}

	public static function getArrLinkedGcBudgetLineItems()
	{
		if (isset(self::$_arrLinkedGcBudgetLineItems)) {
			return self::$_arrLinkedGcBudgetLineItems;
		} else {
			return null;
		}
	}

	public static function setArrLinkedGcBudgetLineItems($arrLinkedGcBudgetLineItems)
	{
		self::$_arrLinkedGcBudgetLineItems = $arrLinkedGcBudgetLineItems;
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
	 * Find by primary key (`gc_budget_line_item_id`,`linked_gc_budget_line_item_id`).
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $linked_gc_budget_line_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByGcBudgetLineItemIdAndLinkedGcBudgetLineItemId($database, $gc_budget_line_item_id, $linked_gc_budget_line_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	gblir.*

FROM `gc_budget_line_item_relationships` gblir
WHERE gblir.`gc_budget_line_item_id` = ?
AND gblir.`linked_gc_budget_line_item_id` = ?
";
		$arrValues = array($gc_budget_line_item_id, $linked_gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$gcBudgetLineItemRelationship = self::instantiateOrm($database, 'GcBudgetLineItemRelationship', $row);
			/* @var $gcBudgetLineItemRelationship GcBudgetLineItemRelationship */
			return $gcBudgetLineItemRelationship;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`gc_budget_line_item_id`,`linked_gc_budget_line_item_id`) Extended.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $linked_gc_budget_line_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdExtended($database, $gc_budget_line_item_id, $linked_gc_budget_line_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	gblir_fk_gbli.`id` AS 'gblir_fk_gbli__gc_budget_line_item_id',
	gblir_fk_gbli.`user_company_id` AS 'gblir_fk_gbli__user_company_id',
	gblir_fk_gbli.`project_id` AS 'gblir_fk_gbli__project_id',
	gblir_fk_gbli.`cost_code_id` AS 'gblir_fk_gbli__cost_code_id',
	gblir_fk_gbli.`modified` AS 'gblir_fk_gbli__modified',
	gblir_fk_gbli.`prime_contract_scheduled_value` AS 'gblir_fk_gbli__prime_contract_scheduled_value',
	gblir_fk_gbli.`forecasted_expenses` AS 'gblir_fk_gbli__forecasted_expenses',
	gblir_fk_gbli.`created` AS 'gblir_fk_gbli__created',
	gblir_fk_gbli.`sort_order` AS 'gblir_fk_gbli__sort_order',
	gblir_fk_gbli.`disabled_flag` AS 'gblir_fk_gbli__disabled_flag',

	gblir_fk_linked_gbli.`id` AS 'gblir_fk_linked_gbli__gc_budget_line_item_id',
	gblir_fk_linked_gbli.`user_company_id` AS 'gblir_fk_linked_gbli__user_company_id',
	gblir_fk_linked_gbli.`project_id` AS 'gblir_fk_linked_gbli__project_id',
	gblir_fk_linked_gbli.`cost_code_id` AS 'gblir_fk_linked_gbli__cost_code_id',
	gblir_fk_linked_gbli.`modified` AS 'gblir_fk_linked_gbli__modified',
	gblir_fk_linked_gbli.`prime_contract_scheduled_value` AS 'gblir_fk_linked_gbli__prime_contract_scheduled_value',
	gblir_fk_linked_gbli.`forecasted_expenses` AS 'gblir_fk_linked_gbli__forecasted_expenses',
	gblir_fk_linked_gbli.`created` AS 'gblir_fk_linked_gbli__created',
	gblir_fk_linked_gbli.`sort_order` AS 'gblir_fk_linked_gbli__sort_order',
	gblir_fk_linked_gbli.`disabled_flag` AS 'gblir_fk_linked_gbli__disabled_flag',

	gblir.*

FROM `gc_budget_line_item_relationships` gblir
	INNER JOIN `gc_budget_line_items` gblir_fk_gbli ON gblir.`gc_budget_line_item_id` = gblir_fk_gbli.`id`
	INNER JOIN `gc_budget_line_items` gblir_fk_linked_gbli ON gblir.`linked_gc_budget_line_item_id` = gblir_fk_linked_gbli.`id`
WHERE gblir.`gc_budget_line_item_id` = ?
AND gblir.`linked_gc_budget_line_item_id` = ?
";
		$arrValues = array($gc_budget_line_item_id, $linked_gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$gcBudgetLineItemRelationship = self::instantiateOrm($database, 'GcBudgetLineItemRelationship', $row);
			/* @var $gcBudgetLineItemRelationship GcBudgetLineItemRelationship */
			$gcBudgetLineItemRelationship->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['gblir_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'gblir_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$gcBudgetLineItemRelationship->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['linked_gc_budget_line_item_id'])) {
				$linked_gc_budget_line_item_id = $row['linked_gc_budget_line_item_id'];
				$row['gblir_fk_linked_gbli__id'] = $linked_gc_budget_line_item_id;
				$linkedGcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $linked_gc_budget_line_item_id, 'gblir_fk_linked_gbli__');
				/* @var $linkedGcBudgetLineItem GcBudgetLineItem */
				$linkedGcBudgetLineItem->convertPropertiesToData();
			} else {
				$linkedGcBudgetLineItem = false;
			}
			$gcBudgetLineItemRelationship->setLinkedGcBudgetLineItem($linkedGcBudgetLineItem);

			return $gcBudgetLineItemRelationship;
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
	 * @param array $arrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemRelationshipsByArrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList($database, $arrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList, Input $options=null)
	{
		if (empty($arrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList)) {
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
		// ORDER BY `gc_budget_line_item_id` ASC, `linked_gc_budget_line_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemRelationship = new GcBudgetLineItemRelationship($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList as $k => $arrTmp) {
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
		if (count($arrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	gblir.*

FROM `gc_budget_line_item_relationships` gblir
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemRelationshipsByArrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList = array();
		while ($row = $db->fetch()) {
			$gcBudgetLineItemRelationship = self::instantiateOrm($database, 'GcBudgetLineItemRelationship', $row);
			/* @var $gcBudgetLineItemRelationship GcBudgetLineItemRelationship */
			$arrGcBudgetLineItemRelationshipsByArrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList[] = $gcBudgetLineItemRelationship;
		}

		$db->free_result();

		return $arrGcBudgetLineItemRelationshipsByArrGcBudgetLineItemIdAndLinkedGcBudgetLineItemIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `gc_budget_line_item_relationships_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemRelationshipsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId = null;
		}

		$arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId = self::$_arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId;
		if (isset($arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId) && !empty($arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId)) {
			return $arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `gc_budget_line_item_id` ASC, `linked_gc_budget_line_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemRelationship = new GcBudgetLineItemRelationship($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gblir.*

FROM `gc_budget_line_item_relationships` gblir
WHERE gblir.`gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `gc_budget_line_item_id` ASC, `linked_gc_budget_line_item_id` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$gcBudgetLineItemRelationship = self::instantiateOrm($database, 'GcBudgetLineItemRelationship', $row);
			/* @var $gcBudgetLineItemRelationship GcBudgetLineItemRelationship */
			$arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId[] = $gcBudgetLineItemRelationship;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId = $arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId;

		return $arrGcBudgetLineItemRelationshipsByGcBudgetLineItemId;
	}

	/**
	 * Load by constraint `gc_budget_line_item_relationships_fk_linked_gbli` foreign key (`linked_gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $linked_gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId($database, $linked_gc_budget_line_item_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId = null;
		}

		$arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId = self::$_arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId;
		if (isset($arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId) && !empty($arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId)) {
			return $arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId;
		}

		$linked_gc_budget_line_item_id = (int) $linked_gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `gc_budget_line_item_id` ASC, `linked_gc_budget_line_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemRelationship = new GcBudgetLineItemRelationship($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gblir.*

FROM `gc_budget_line_item_relationships` gblir
WHERE gblir.`linked_gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `gc_budget_line_item_id` ASC, `linked_gc_budget_line_item_id` ASC
		$arrValues = array($linked_gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$gcBudgetLineItemRelationship = self::instantiateOrm($database, 'GcBudgetLineItemRelationship', $row);
			/* @var $gcBudgetLineItemRelationship GcBudgetLineItemRelationship */
			$arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId[] = $gcBudgetLineItemRelationship;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId = $arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId;

		return $arrGcBudgetLineItemRelationshipsByLinkedGcBudgetLineItemId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all gc_budget_line_item_relationships records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllGcBudgetLineItemRelationships($database, Input $options=null)
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
			self::$_arrAllGcBudgetLineItemRelationships = null;
		}

		$arrAllGcBudgetLineItemRelationships = self::$_arrAllGcBudgetLineItemRelationships;
		if (isset($arrAllGcBudgetLineItemRelationships) && !empty($arrAllGcBudgetLineItemRelationships)) {
			return $arrAllGcBudgetLineItemRelationships;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `gc_budget_line_item_id` ASC, `linked_gc_budget_line_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemRelationship = new GcBudgetLineItemRelationship($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gblir.*

FROM `gc_budget_line_item_relationships` gblir{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `gc_budget_line_item_id` ASC, `linked_gc_budget_line_item_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllGcBudgetLineItemRelationships = array();
		while ($row = $db->fetch()) {
			$gcBudgetLineItemRelationship = self::instantiateOrm($database, 'GcBudgetLineItemRelationship', $row);
			/* @var $gcBudgetLineItemRelationship GcBudgetLineItemRelationship */
			$arrAllGcBudgetLineItemRelationships[] = $gcBudgetLineItemRelationship;
		}

		$db->free_result();

		self::$_arrAllGcBudgetLineItemRelationships = $arrAllGcBudgetLineItemRelationships;

		return $arrAllGcBudgetLineItemRelationships;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
	public function insertIgnore()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT IGNORE
INTO `gc_budget_line_item_relationships`
(`gc_budget_line_item_id`, `linked_gc_budget_line_item_id`)
VALUES (?, ?)
";
		$arrValues = array($this->gc_budget_line_item_id, $this->linked_gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}

	public static function getbudgetvarianceRecord($database, $gc_budget_line_item_id,$fieldname)
	{
		$db = DBI::getInstance($database);
		$query ="SELECT $fieldname  FROM `gc_budget_line_items`  WHERE `id` = $gc_budget_line_item_id " ;
		$db->execute($query);
		$row=$db->fetch();
		$fievalue = $row[$fieldname];
		$db->free_result();
		return $fievalue;
	}

	/**
	 * Load by constraint `gc_budget_line_item_relationships_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadLinkedGcBudgetLineItems($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrLinkedGcBudgetLineItems = null;
		}

		$arrLinkedGcBudgetLineItems = self::$_arrLinkedGcBudgetLineItems;
		if (isset($arrLinkedGcBudgetLineItems) && !empty($arrLinkedGcBudgetLineItems)) {
			return $arrLinkedGcBudgetLineItems;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `gc_budget_line_item_id` ASC, `linked_gc_budget_line_item_id` ASC
		$sqlOrderBy = "\nORDER BY gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

		// Note that we are loading gc_budget_line_items objects via a relationships table (gc_budget_line_item_relationships)
		$query =
"
SELECT

	gbli_fk_uc.`id` AS 'gbli_fk_uc__user_company_id',
	gbli_fk_uc.`company` AS 'gbli_fk_uc__company',
	gbli_fk_uc.`primary_phone_number` AS 'gbli_fk_uc__primary_phone_number',
	gbli_fk_uc.`employer_identification_number` AS 'gbli_fk_uc__employer_identification_number',
	gbli_fk_uc.`construction_license_number` AS 'gbli_fk_uc__construction_license_number',
	gbli_fk_uc.`construction_license_number_expiration_date` AS 'gbli_fk_uc__construction_license_number_expiration_date',
	gbli_fk_uc.`paying_customer_flag` AS 'gbli_fk_uc__paying_customer_flag',

	gbli_fk_p.`id` AS 'gbli_fk_p__project_id',
	gbli_fk_p.`project_type_id` AS 'gbli_fk_p__project_type_id',
	gbli_fk_p.`user_company_id` AS 'gbli_fk_p__user_company_id',
	gbli_fk_p.`user_custom_project_id` AS 'gbli_fk_p__user_custom_project_id',
	gbli_fk_p.`project_name` AS 'gbli_fk_p__project_name',
	gbli_fk_p.`project_owner_name` AS 'gbli_fk_p__project_owner_name',
	gbli_fk_p.`latitude` AS 'gbli_fk_p__latitude',
	gbli_fk_p.`longitude` AS 'gbli_fk_p__longitude',
	gbli_fk_p.`address_line_1` AS 'gbli_fk_p__address_line_1',
	gbli_fk_p.`address_line_2` AS 'gbli_fk_p__address_line_2',
	gbli_fk_p.`address_line_3` AS 'gbli_fk_p__address_line_3',
	gbli_fk_p.`address_line_4` AS 'gbli_fk_p__address_line_4',
	gbli_fk_p.`address_city` AS 'gbli_fk_p__address_city',
	gbli_fk_p.`address_county` AS 'gbli_fk_p__address_county',
	gbli_fk_p.`address_state_or_region` AS 'gbli_fk_p__address_state_or_region',
	gbli_fk_p.`address_postal_code` AS 'gbli_fk_p__address_postal_code',
	gbli_fk_p.`address_postal_code_extension` AS 'gbli_fk_p__address_postal_code_extension',
	gbli_fk_p.`address_country` AS 'gbli_fk_p__address_country',
	gbli_fk_p.`building_count` AS 'gbli_fk_p__building_count',
	gbli_fk_p.`unit_count` AS 'gbli_fk_p__unit_count',
	gbli_fk_p.`gross_square_footage` AS 'gbli_fk_p__gross_square_footage',
	gbli_fk_p.`net_rentable_square_footage` AS 'gbli_fk_p__net_rentable_square_footage',
	gbli_fk_p.`is_active_flag` AS 'gbli_fk_p__is_active_flag',
	gbli_fk_p.`public_plans_flag` AS 'gbli_fk_p__public_plans_flag',
	gbli_fk_p.`prevailing_wage_flag` AS 'gbli_fk_p__prevailing_wage_flag',
	gbli_fk_p.`city_business_license_required_flag` AS 'gbli_fk_p__city_business_license_required_flag',
	gbli_fk_p.`is_internal_flag` AS 'gbli_fk_p__is_internal_flag',
	gbli_fk_p.`project_contract_date` AS 'gbli_fk_p__project_contract_date',
	gbli_fk_p.`project_start_date` AS 'gbli_fk_p__project_start_date',
	gbli_fk_p.`project_completed_date` AS 'gbli_fk_p__project_completed_date',

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	cca.`id` AS 'cca__cost_code_alias_id',
	cca.`user_company_id` AS 'cca__user_company_id',
	cca.`project_id` AS 'cca__project_id',
	cca.`cost_code_id` AS 'cca__cost_code_id',
	cca.`contact_company_id` AS 'cca__contact_company_id',
	cca.`cost_code_division_alias_id` AS 'cca__cost_code_division_alias_id',
	cca.`cost_code_alias` AS 'cca__cost_code_alias',
	cca.`cost_code_description_alias` AS 'cca__cost_code_description_alias',
	cca.`cost_code_description_abbreviation_alias` AS 'cca__cost_code_description_abbreviation_alias',

	ccda.`id` AS 'ccda__cost_code_division_alias_id',
	ccda.`user_company_id` AS 'ccda__user_company_id',
	ccda.`project_id` AS 'ccda__project_id',
	ccda.`cost_code_division_id` AS 'ccda__cost_code_division_id',
	ccda.`contact_company_id` AS 'ccda__contact_company_id',
	ccda.`division_number_alias` AS 'ccda__division_number_alias',
	ccda.`division_code_heading_alias` AS 'ccda__division_code_heading_alias',
	ccda.`division_alias` AS 'ccda__division_alias',
	ccda.`division_abbreviation_alias` AS 'ccda__division_abbreviation_alias',

	gbli.*

FROM `gc_budget_line_item_relationships` gblir
	INNER JOIN `gc_budget_line_items` gbli ON gblir.`linked_gc_budget_line_item_id` = gbli.`id`

	INNER JOIN `user_companies` gbli_fk_uc ON gbli.`user_company_id` = gbli_fk_uc.`id`
	INNER JOIN `projects` gbli_fk_p ON gbli.`project_id` = gbli_fk_p.`id`
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`
	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
	LEFT OUTER JOIN cost_code_aliases cca ON
		(gbli.user_company_id = cca.user_company_id AND gbli.project_id = cca.project_id AND gbli_fk_codes.`id` = cca.cost_code_id)
	LEFT OUTER JOIN cost_code_division_aliases ccda ON
		(gbli.user_company_id = ccda.user_company_id AND gbli.project_id = ccda.project_id AND gbli_fk_codes__fk_ccd.`id` = ccda.cost_code_division_id)
WHERE gblir.gc_budget_line_item_id = ?{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrLinkedGcBudgetLineItems = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$gcBudgetLineItem->convertPropertiesToData();
			$linked_gc_budget_line_item_id = $gc_budget_line_item_id;

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['gbli_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'gbli_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$gcBudgetLineItem->setUserCompany($userCompany);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['gbli_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'gbli_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$gcBudgetLineItem->setProject($project);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['gbli_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$gcBudgetLineItem->setCostCode($costCode);

			if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
				$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);
			$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

			// LEFT OUTER JOIN cost_code_aliases cca ON
			//	 (gbli.user_company_id = cca.user_company_id AND gbli.project_id = cca.project_id AND gbli_fk_codes.`id` = cca.cost_code_id)
			if (isset($row['cca__cost_code_alias_id'])) {
				$cost_code_alias_id = $row['cca__cost_code_alias_id'];
				$row['cca__id'] = $cost_code_alias_id;
				$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id, 'cca__');
				/* @var $costCodeAlias CostCodeAlias */
				$costCodeAlias->convertPropertiesToData();
			} else {
				$costCodeAlias = false;
			}
			$gcBudgetLineItem->setCostCodeAlias($costCodeAlias);

			// LEFT OUTER JOIN cost_code_division_aliases ccda ON
			//	 (gbli.user_company_id = ccda.user_company_id AND gbli.project_id = ccda.project_id AND gbli_fk_codes__fk_ccd.`id` = ccda.cost_code_division_id)
			if (isset($row['ccda__cost_code_division_alias_id'])) {
				$cost_code_division_alias_id = $row['ccda__cost_code_division_alias_id'];
				$row['ccda__id'] = $cost_code_division_alias_id;
				$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id, 'ccda__');
				/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
				$costCodeDivisionAlias->convertPropertiesToData();
			} else {
				$costCodeDivisionAlias = false;
			}
			$gcBudgetLineItem->setCostCodeDivisionAlias($costCodeDivisionAlias);

			$arrLinkedGcBudgetLineItems[$linked_gc_budget_line_item_id] = $gcBudgetLineItem;
		}

		$db->free_result();

		self::$_arrLinkedGcBudgetLineItems = $arrLinkedGcBudgetLineItems;

		return $arrLinkedGcBudgetLineItems;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

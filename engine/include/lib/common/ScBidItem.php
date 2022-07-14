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
 * ScBidItem.
 *
 * @category   Framework
 * @package    ScBidItem
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ScBidItem extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ScBidItem';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'sc_bid_items';

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
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_sc_bid_item_via_primary_key' => array(
			'sc_bid_item_id' => 'int'
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
		'id' => 'sc_bid_item_id',

		'gc_budget_line_item_id' => 'gc_budget_line_item_id',

		'sc_bid_item' => 'sc_bid_item',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $sc_bid_item_id;

	public $gc_budget_line_item_id;

	public $sc_bid_item;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_sc_bid_item;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_sc_bid_item_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrScBidItemsByGcBudgetLineItemId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllScBidItems;

	// Foreign Key Objects
	private $_gcBudgetLineItem;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='sc_bid_items')
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrScBidItemsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrScBidItemsByGcBudgetLineItemId)) {
			return self::$_arrScBidItemsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrScBidItemsByGcBudgetLineItemId($arrScBidItemsByGcBudgetLineItemId)
	{
		self::$_arrScBidItemsByGcBudgetLineItemId = $arrScBidItemsByGcBudgetLineItemId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllScBidItems()
	{
		if (isset(self::$_arrAllScBidItems)) {
			return self::$_arrAllScBidItems;
		} else {
			return null;
		}
	}

	public static function setArrAllScBidItems($arrAllScBidItems)
	{
		self::$_arrAllScBidItems = $arrAllScBidItems;
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
	 * @param int $sc_bid_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $sc_bid_item_id,$table='sc_bid_items', $module='ScBidItem')
	{
		$scBidItem = parent::findById($database, $sc_bid_item_id, $table, $module);

		return $scBidItem;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $sc_bid_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findScBidItemByIdExtended($database, $sc_bid_item_id)
	{
		$sc_bid_item_id = (int) $sc_bid_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sbi_fk_gbli.`id` AS 'sbi_fk_gbli__gc_budget_line_item_id',
	sbi_fk_gbli.`user_company_id` AS 'sbi_fk_gbli__user_company_id',
	sbi_fk_gbli.`project_id` AS 'sbi_fk_gbli__project_id',
	sbi_fk_gbli.`cost_code_id` AS 'sbi_fk_gbli__cost_code_id',
	sbi_fk_gbli.`modified` AS 'sbi_fk_gbli__modified',
	sbi_fk_gbli.`prime_contract_scheduled_value` AS 'sbi_fk_gbli__prime_contract_scheduled_value',
	sbi_fk_gbli.`forecasted_expenses` AS 'sbi_fk_gbli__forecasted_expenses',
	sbi_fk_gbli.`created` AS 'sbi_fk_gbli__created',
	sbi_fk_gbli.`sort_order` AS 'sbi_fk_gbli__sort_order',
	sbi_fk_gbli.`disabled_flag` AS 'sbi_fk_gbli__disabled_flag',

	sbi.*

FROM `sc_bid_items` sbi
	LEFT OUTER JOIN `gc_budget_line_items` sbi_fk_gbli ON sbi.`gc_budget_line_item_id` = sbi_fk_gbli.`id`
WHERE sbi.`id` = ?
";
		$arrValues = array($sc_bid_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$sc_bid_item_id = $row['id'];
			$scBidItem = self::instantiateOrm($database, 'ScBidItem', $row, null, $sc_bid_item_id);
			/* @var $scBidItem ScBidItem */
			$scBidItem->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sbi_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sbi_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$scBidItem->setGcBudgetLineItem($gcBudgetLineItem);

			return $scBidItem;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrScBidItemIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadScBidItemsByArrScBidItemIds($database, $arrScBidItemIds, Input $options=null)
	{
		if (empty($arrScBidItemIds)) {
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
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `sc_bid_item` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpScBidItem = new ScBidItem($database);
			$sqlOrderByColumns = $tmpScBidItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrScBidItemIds as $k => $sc_bid_item_id) {
			$sc_bid_item_id = (int) $sc_bid_item_id;
			$arrScBidItemIds[$k] = $db->escape($sc_bid_item_id);
		}
		$csvScBidItemIds = join(',', $arrScBidItemIds);

		$query =
"
SELECT

	sbi.*

FROM `sc_bid_items` sbi
WHERE sbi.`id` IN ($csvScBidItemIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrScBidItemsByCsvScBidItemIds = array();
		while ($row = $db->fetch()) {
			$sc_bid_item_id = $row['id'];
			$scBidItem = self::instantiateOrm($database, 'ScBidItem', $row, null, $sc_bid_item_id);
			/* @var $scBidItem ScBidItem */
			$scBidItem->convertPropertiesToData();

			$arrScBidItemsByCsvScBidItemIds[$sc_bid_item_id] = $scBidItem;
		}

		$db->free_result();

		return $arrScBidItemsByCsvScBidItemIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `sc_bid_items_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadScBidItemsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrScBidItemsByGcBudgetLineItemId = null;
		}

		$arrScBidItemsByGcBudgetLineItemId = self::$_arrScBidItemsByGcBudgetLineItemId;
		if (isset($arrScBidItemsByGcBudgetLineItemId) && !empty($arrScBidItemsByGcBudgetLineItemId)) {
			return $arrScBidItemsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `sc_bid_item` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpScBidItem = new ScBidItem($database);
			$sqlOrderByColumns = $tmpScBidItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbi.*

FROM `sc_bid_items` sbi
WHERE sbi.`gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `sc_bid_item` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrScBidItemsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$sc_bid_item_id = $row['id'];
			$scBidItem = self::instantiateOrm($database, 'ScBidItem', $row, null, $sc_bid_item_id);
			/* @var $scBidItem ScBidItem */
			$arrScBidItemsByGcBudgetLineItemId[$sc_bid_item_id] = $scBidItem;
		}

		$db->free_result();

		self::$_arrScBidItemsByGcBudgetLineItemId = $arrScBidItemsByGcBudgetLineItemId;

		return $arrScBidItemsByGcBudgetLineItemId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all sc_bid_items records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllScBidItems($database, Input $options=null)
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
			self::$_arrAllScBidItems = null;
		}

		$arrAllScBidItems = self::$_arrAllScBidItems;
		if (isset($arrAllScBidItems) && !empty($arrAllScBidItems)) {
			return $arrAllScBidItems;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `sc_bid_item` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpScBidItem = new ScBidItem($database);
			$sqlOrderByColumns = $tmpScBidItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbi.*

FROM `sc_bid_items` sbi{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `sc_bid_item` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllScBidItems = array();
		while ($row = $db->fetch()) {
			$sc_bid_item_id = $row['id'];
			$scBidItem = self::instantiateOrm($database, 'ScBidItem', $row, null, $sc_bid_item_id);
			/* @var $scBidItem ScBidItem */
			$arrAllScBidItems[$sc_bid_item_id] = $scBidItem;
		}

		$db->free_result();

		self::$_arrAllScBidItems = $arrAllScBidItems;

		return $arrAllScBidItems;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

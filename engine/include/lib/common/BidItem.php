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
 * BidItem.
 *
 * @category   Framework
 * @package    BidItem
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class BidItem extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidItem';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_items';

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
		'unique_bid_item_via_primary_key' => array(
			'bid_item_id' => 'int'
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
		'id' => 'bid_item_id',

		'gc_budget_line_item_id' => 'gc_budget_line_item_id',

		'bid_item' => 'bid_item',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_item_id;

	public $gc_budget_line_item_id;

	public $bid_item;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_bid_item;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_bid_item_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrBidItemsByGcBudgetLineItemId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllBidItems;

	// Foreign Key Objects
	private $_gcBudgetLineItem;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_items')
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
	public static function getArrBidItemsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrBidItemsByGcBudgetLineItemId)) {
			return self::$_arrBidItemsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrBidItemsByGcBudgetLineItemId($arrBidItemsByGcBudgetLineItemId)
	{
		self::$_arrBidItemsByGcBudgetLineItemId = $arrBidItemsByGcBudgetLineItemId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllBidItems()
	{
		if (isset(self::$_arrAllBidItems)) {
			return self::$_arrAllBidItems;
		} else {
			return null;
		}
	}

	public static function setArrAllBidItems($arrAllBidItems)
	{
		self::$_arrAllBidItems = $arrAllBidItems;
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
	 * @param int $bid_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $bid_item_id, $table='bid_items', $module='BidItem')
	{
		$bidItem = parent::findById($database, $bid_item_id, 'bid_items', 'BidItem');

		return $bidItem;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $bid_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBidItemByIdExtended($database, $bid_item_id)
	{
		$bid_item_id = (int) $bid_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	bi_fk_gbli.`id` AS 'bi_fk_gbli__gc_budget_line_item_id',
	bi_fk_gbli.`user_company_id` AS 'bi_fk_gbli__user_company_id',
	bi_fk_gbli.`project_id` AS 'bi_fk_gbli__project_id',
	bi_fk_gbli.`cost_code_id` AS 'bi_fk_gbli__cost_code_id',
	bi_fk_gbli.`modified` AS 'bi_fk_gbli__modified',
	bi_fk_gbli.`prime_contract_scheduled_value` AS 'bi_fk_gbli__prime_contract_scheduled_value',
	bi_fk_gbli.`forecasted_expenses` AS 'bi_fk_gbli__forecasted_expenses',
	bi_fk_gbli.`created` AS 'bi_fk_gbli__created',
	bi_fk_gbli.`sort_order` AS 'bi_fk_gbli__sort_order',
	bi_fk_gbli.`disabled_flag` AS 'bi_fk_gbli__disabled_flag',

	bi.*

FROM `bid_items` bi
	LEFT OUTER JOIN `gc_budget_line_items` bi_fk_gbli ON bi.`gc_budget_line_item_id` = bi_fk_gbli.`id`
WHERE bi.`id` = ?
";
		$arrValues = array($bid_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$bid_item_id = $row['id'];
			$bidItem = self::instantiateOrm($database, 'BidItem', $row, null, $bid_item_id);
			/* @var $bidItem BidItem */
			$bidItem->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['bi_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'bi_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$bidItem->setGcBudgetLineItem($gcBudgetLineItem);

			return $bidItem;
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
	 * @param array $arrBidItemIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidItemsByArrBidItemIds($database, $arrBidItemIds, Input $options=null)
	{
		if (empty($arrBidItemIds)) {
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
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_item` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidItem = new BidItem($database);
			$sqlOrderByColumns = $tmpBidItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrBidItemIds as $k => $bid_item_id) {
			$bid_item_id = (int) $bid_item_id;
			$arrBidItemIds[$k] = $db->escape($bid_item_id);
		}
		$csvBidItemIds = join(',', $arrBidItemIds);

		$query =
"
SELECT

	bi.*

FROM `bid_items` bi
WHERE bi.`id` IN ($csvBidItemIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrBidItemsByCsvBidItemIds = array();
		while ($row = $db->fetch()) {
			$bid_item_id = $row['id'];
			$bidItem = self::instantiateOrm($database, 'BidItem', $row, null, $bid_item_id);
			/* @var $bidItem BidItem */
			$bidItem->convertPropertiesToData();

			$arrBidItemsByCsvBidItemIds[$bid_item_id] = $bidItem;
		}

		$db->free_result();

		return $arrBidItemsByCsvBidItemIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `bid_items_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidItemsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrBidItemsByGcBudgetLineItemId = null;
		}

		$arrBidItemsByGcBudgetLineItemId = self::$_arrBidItemsByGcBudgetLineItemId;
		if (isset($arrBidItemsByGcBudgetLineItemId) && !empty($arrBidItemsByGcBudgetLineItemId)) {
			return $arrBidItemsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_item` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidItem = new BidItem($database);
			$sqlOrderByColumns = $tmpBidItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bi.*

FROM `bid_items` bi
WHERE bi.`gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_item` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidItemsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$bid_item_id = $row['id'];
			$bidItem = self::instantiateOrm($database, 'BidItem', $row, null, $bid_item_id);
			/* @var $bidItem BidItem */
			$arrBidItemsByGcBudgetLineItemId[$bid_item_id] = $bidItem;
		}

		$db->free_result();

		self::$_arrBidItemsByGcBudgetLineItemId = $arrBidItemsByGcBudgetLineItemId;

		return $arrBidItemsByGcBudgetLineItemId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all bid_items records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllBidItems($database, Input $options=null)
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
			self::$_arrAllBidItems = null;
		}

		$arrAllBidItems = self::$_arrAllBidItems;
		if (isset($arrAllBidItems) && !empty($arrAllBidItems)) {
			return $arrAllBidItems;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_item` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidItem = new BidItem($database);
			$sqlOrderByColumns = $tmpBidItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bi.*

FROM `bid_items` bi{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_item` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllBidItems = array();
		while ($row = $db->fetch()) {
			$bid_item_id = $row['id'];
			$bidItem = self::instantiateOrm($database, 'BidItem', $row, null, $bid_item_id);
			/* @var $bidItem BidItem */
			$arrAllBidItems[$bid_item_id] = $bidItem;
		}

		$db->free_result();

		self::$_arrAllBidItems = $arrAllBidItems;

		return $arrAllBidItems;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public static function loadBidItemsByGcBudgetLineItemIdInSortOrderRange($database, $gc_budget_line_item_id, $low_sort_order, $high_sort_order, $sortOrder)
	{

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;
		$low_sort_order = (int) $low_sort_order;
		$high_sort_order = (int) $high_sort_order;
		if ($sortOrder != 'DESC') {
			$sortOrder = 'ASC';
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	bi.*
FROM `bid_items` bi
WHERE bi.`gc_budget_line_item_id` = ?
AND bi.`sort_order` >= ?
AND bi.`sort_order` <= ?
ORDER BY bi.`sort_order` $sortOrder
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_item` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id, $low_sort_order, $high_sort_order);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidItemsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$bid_item_id = $row['id'];
			$bidItem = self::instantiateOrm($database, 'BidItem', $row, null, $bid_item_id);
			/* @var $bidItem BidItem */
			$arrBidItemsByGcBudgetLineItemId[$bid_item_id] = $bidItem;
		}

		$db->free_result();

		return $arrBidItemsByGcBudgetLineItemId;
	}

	/**
	 * Maintain an empty bid_items record with no entries for any bidder.
	 *
	 * Rules:
	 * Bid item must equal "" (empty string).
	 * No bid_items_to_subcontractor_bids entries for the bid_item row.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $numberOfConvenienceRowsToMaintain {1 - 3}
	 * @return bool
	 */
	public static function maintainEmptyBidItemConvenienceRow($database, $gc_budget_line_item_id, $numberOfConvenienceRowsToMaintain=null)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;
		$numberOfConvenienceRowsToMaintain = (int) $numberOfConvenienceRowsToMaintain;

		// Allow 1 to 3 empty convenience rows
		if ($numberOfConvenienceRowsToMaintain <= 0) {
			$numberOfConvenienceRowsToMaintain = 0;
		} elseif ($numberOfConvenienceRowsToMaintain > 3) {
			$numberOfConvenienceRowsToMaintain = 3;
		}

		// Get the bid_items record with the highest sort_order value.
		$query =
"
SELECT bi.*
FROM `bid_items` bi
WHERE bi.`gc_budget_line_item_id` = ?
ORDER BY bi.`sort_order` DESC
LIMIT ?;
";
		// TODO: Add more variables like user_company_id, session->project_id to increase security to make sure
		// someone is only looking at a spread that they have access to
		$arrValues = array($gc_budget_line_item_id, $numberOfConvenienceRowsToMaintain);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$insertBidItemConvenienceRecordsFlag = true;
		$continueVerification = false;

		$max_sort_order = 0;
		$blankRowCount = 0;
		$first = true;
		$counter = $numberOfConvenienceRowsToMaintain;
		$rowOneBlank = false;
		$rowTwoBlank = false;
		$rowThreeBlank = false;
		$arrBidItemIds = array();
		while ($row = $db->fetch()) {

			$bid_item_id = $row['id'];
			$bid_item = $row['bid_item'];
			$sort_order = $row['sort_order'];

			if ($first) {
				$max_sort_order = $sort_order;
				$first = false;
			}

			if ($bid_item <> '') {
				// bid_item is not "" so insert convenience row
			} else {

				$arrBidItemIds[$bid_item_id] = $counter;

				if ($counter == 1) {
					$rowOneBlank = true;
				} elseif ($counter == 2) {
					$rowTwoBlank = true;
				} elseif ($counter == 3) {
					$rowThreeBlank = true;
				}

			}
			$counter--;

		}
		$db->free_result();

		if ($numberOfConvenienceRowsToMaintain == 1) {
			if ($rowOneBlank) {
				$continueVerification = true;
			} else {
				$continueVerification = false;
			}
		} elseif ($numberOfConvenienceRowsToMaintain == 2) {
			if ($rowOneBlank && $rowTwoBlank) {
				$continueVerification = true;
			} else {
				$continueVerification = false;
			}
		} elseif ($numberOfConvenienceRowsToMaintain == 3) {
			if ($rowOneBlank && $rowTwoBlank && $rowThreeBlank) {
				$continueVerification = true;
			} else {
				$continueVerification = false;
			}
		}

		if ($continueVerification) {

			// Check to make sure that there are no bidders that have content for this item even though it's blank.
			$arrTemp = array_keys($arrBidItemIds);
			$in = join(',', $arrTemp);
			$query =
"
SELECT bi2sb.`bid_item_id`
FROM bid_items_to_subcontractor_bids bi2sb
WHERE bi2sb.bid_item_id IN($in)
";
			$db->query($query, MYSQLI_USE_RESULT);

			while ($row = $db->fetch()) {
				$bid_item_id = $row['bid_item_id'];
				$counter = $arrBidItemIds[$bid_item_id];

				if ($counter == 1) {
					$rowOneBlank = false;
				} elseif ($counter == 2) {
					$rowTwoBlank = false;
				} elseif ($counter == 3) {
					$rowThreeBlank = false;
				}
			}
			$db->free_result();

		}

		$rowsToInsert = $numberOfConvenienceRowsToMaintain;
		if ($numberOfConvenienceRowsToMaintain == 1) {
			if ($rowOneBlank) {
				$insertBidItemConvenienceRecordsFlag = false;
			} else {
				$insertBidItemConvenienceRecordsFlag = true;
			}
		} elseif ($numberOfConvenienceRowsToMaintain == 2) {
			if ($rowOneBlank && $rowTwoBlank) {
				$insertBidItemConvenienceRecordsFlag = false;
			} else {
				$insertBidItemConvenienceRecordsFlag = true;
				if ($rowTwoBlank) {
					$rowsToInsert = 1;
				} else {
					$rowsToInsert = 2;
				}
			}
		} elseif ($numberOfConvenienceRowsToMaintain == 3) {
			if ($rowOneBlank && $rowTwoBlank && $rowThreeBlank) {
				$insertBidItemConvenienceRecordsFlag = false;
			} else {
				$insertBidItemConvenienceRecordsFlag = true;
				if ($rowTwoBlank && $rowThreeBlank) {
					$rowsToInsert = 1;
				} elseif ($rowThreeBlank) {
					$rowsToInsert = 2;
				} else {
					$rowsToInsert = 3;
				}
			}
		}

		if ($insertBidItemConvenienceRecordsFlag) {
			// INSERT INTO tbl_name (a,b,c) VALUES(1,2,3),(4,5,6),(7,8,9);

			$arrValues = array();
			for ($i=0; $i<$rowsToInsert; $i++) {
				$max_sort_order++;
				$arrValueStatements[] = "($gc_budget_line_item_id,'',$max_sort_order)";
			}

			$valueStatement = join(',', $arrValueStatements);
			$valueStatement = "VALUES $valueStatement";
			$query =
"
INSERT
INTO `bid_items`
(`gc_budget_line_item_id`, `bid_item`, `sort_order`)
$valueStatement
";
			$db->query($query, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		return $insertBidItemConvenienceRecordsFlag;
	}

	public static function setNaturalSortOrderOnBidItemsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $original_bid_item_id)
	{
		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;
		$original_bid_item_id = (int) $original_bid_item_id;

		$loadBidItemsByGcBudgetLineItemIdOptions = new Input();
		$loadBidItemsByGcBudgetLineItemIdOptions->forceLoadFlag = true;

		// Set natural sort order on all records first
		$arrBidItemsByGcBudgetLineItemId = BidItem::loadBidItemsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $loadBidItemsByGcBudgetLineItemIdOptions);
		$i = 0;
		foreach ($arrBidItemsByGcBudgetLineItemId as $bid_item_id => $bidItem) {
			/* @var $bidItem BidItem */

			$sort_order = $bidItem->sort_order;
			if ($sort_order != $i) {
				$data = array('sort_order' => $i);
				$bidItem->setData($data);
				$bidItem->save();
			}

			// Get the original sort_order value after updating to sane values
			if ($bidItem->bid_item_id == $original_bid_item_id) {
				$original_sort_order = $i;
			}

			$i++;
		}

		return $original_sort_order;
	}

	public function updateSortOrder($database, $new_sort_order)
	{
		$gc_budget_line_item_id = $this->gc_budget_line_item_id;
		$new_sort_order = (int) $new_sort_order;

		// @todo Conditionally update sort_order based on table meta-data
		$original_sort_order = BidItem::setNaturalSortOrderOnBidItemsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $this->bid_item_id);

		if ($new_sort_order > $original_sort_order) {
			$movedDown = true;
			$movedUp = false;
		} elseif ($new_sort_order < $original_sort_order) {
			$movedDown = false;
			$movedUp = true;
		} else {
			// Same sort_order
			// Default to Moved Down
			$movedDown = true;
			$movedUp = false;
		}

		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$db->begin();
		if ($movedDown) {
			$query =
"
UPDATE `bid_items`
SET `sort_order` = (`sort_order`-1)
WHERE `gc_budget_line_item_id` = ?
AND `sort_order` > ?
AND `sort_order` <= ?
";
			$arrValues = array($gc_budget_line_item_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} elseif ($movedUp) {
			$query =
"
UPDATE `bid_items`
SET `sort_order` = (`sort_order`+1)
WHERE `gc_budget_line_item_id` = ?
AND `sort_order` < ?
AND `sort_order` >= ?
";
			$arrValues = array($gc_budget_line_item_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
	}

	/**
	 * Find next_bid_spread_sequence_number value.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextBidItemSortOrder($database, $gc_budget_line_item_id)
	{
		$next_sort_order = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	MAX(bi.`sort_order`) AS 'max_sort_order'
FROM `bid_items` bi
WHERE bi.`gc_budget_line_item_id` = ?
";
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_sort_order = $row['max_sort_order'];
			$next_sort_order = $max_sort_order + 1;
		}

		return $next_sort_order;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

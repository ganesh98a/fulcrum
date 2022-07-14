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
 * BidItemToSubcontractorBid.
 *
 * @category   Framework
 * @package    BidItemToSubcontractorBid
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class BidItemToSubcontractorBid extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidItemToSubcontractorBid';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_items_to_subcontractor_bids';

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
	 * unique index `unique_bid_item_to_subcontractor_bid` (`bid_item_id`,`subcontractor_bid_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_bid_item_to_subcontractor_bid' => array(
			'bid_item_id' => 'int',
			'subcontractor_bid_id' => 'int'
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
		'id' => 'bid_item_to_subcontractor_bid_id',

		'bid_item_id' => 'bid_item_id',
		'subcontractor_bid_id' => 'subcontractor_bid_id',

		'item_quantity' => 'item_quantity',
		'unit' => 'unit',
		'unit_price' => 'unit_price',
		'exclude_bid_item_flag' => 'exclude_bid_item_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_item_to_subcontractor_bid_id;

	public $bid_item_id;
	public $subcontractor_bid_id;

	public $item_quantity;
	public $unit;
	public $unit_price;
	public $exclude_bid_item_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_unit;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_unit_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrBidItemsToSubcontractorBidsByBidItemId;
	protected static $_arrBidItemsToSubcontractorBidsBySubcontractorBidId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllBidItemsToSubcontractorBids;
	protected static $_arrBidItemsToSubcontractorBidsByGcBudgetLineItemId;

	// Foreign Key Objects
	private $_bidItem;
	private $_subcontractorBid;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_items_to_subcontractor_bids')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getBidItem()
	{
		if (isset($this->_bidItem)) {
			return $this->_bidItem;
		} else {
			return null;
		}
	}

	public function setBidItem($bidItem)
	{
		$this->_bidItem = $bidItem;
	}

	public function getSubcontractorBid()
	{
		if (isset($this->_subcontractorBid)) {
			return $this->_subcontractorBid;
		} else {
			return null;
		}
	}

	public function setSubcontractorBid($subcontractorBid)
	{
		$this->_subcontractorBid = $subcontractorBid;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrBidItemsToSubcontractorBidsByBidItemId()
	{
		if (isset(self::$_arrBidItemsToSubcontractorBidsByBidItemId)) {
			return self::$_arrBidItemsToSubcontractorBidsByBidItemId;
		} else {
			return null;
		}
	}

	public static function setArrBidItemsToSubcontractorBidsByBidItemId($arrBidItemsToSubcontractorBidsByBidItemId)
	{
		self::$_arrBidItemsToSubcontractorBidsByBidItemId = $arrBidItemsToSubcontractorBidsByBidItemId;
	}

	public static function getArrBidItemsToSubcontractorBidsBySubcontractorBidId()
	{
		if (isset(self::$_arrBidItemsToSubcontractorBidsBySubcontractorBidId)) {
			return self::$_arrBidItemsToSubcontractorBidsBySubcontractorBidId;
		} else {
			return null;
		}
	}

	public static function setArrBidItemsToSubcontractorBidsBySubcontractorBidId($arrBidItemsToSubcontractorBidsBySubcontractorBidId)
	{
		self::$_arrBidItemsToSubcontractorBidsBySubcontractorBidId = $arrBidItemsToSubcontractorBidsBySubcontractorBidId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllBidItemsToSubcontractorBids()
	{
		if (isset(self::$_arrAllBidItemsToSubcontractorBids)) {
			return self::$_arrAllBidItemsToSubcontractorBids;
		} else {
			return null;
		}
	}

	public static function setArrAllBidItemsToSubcontractorBids($arrAllBidItemsToSubcontractorBids)
	{
		self::$_arrAllBidItemsToSubcontractorBids = $arrAllBidItemsToSubcontractorBids;
	}

	public static function getArrBidItemsToSubcontractorBidsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrBidItemsToSubcontractorBidsByGcBudgetLineItemId)) {
			return self::$_arrBidItemsToSubcontractorBidsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrBidItemsToSubcontractorBidsByGcBudgetLineItemId($arrBidItemsToSubcontractorBidsByGcBudgetLineItemId)
	{
		self::$_arrBidItemsToSubcontractorBidsByGcBudgetLineItemId = $arrAllSubcontractorBidStatuses;
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
	 * @param int $bid_item_to_subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $bid_item_to_subcontractor_bid_id, $table='bid_items_to_subcontractor_bids', $module='BidItemToSubcontractorBid')
	{
		$bidItemToSubcontractorBid = parent::findById($database, $bid_item_to_subcontractor_bid_id, $table, $module);

		return $bidItemToSubcontractorBid;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $bid_item_to_subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBidItemToSubcontractorBidByIdExtended($database, $bid_item_to_subcontractor_bid_id)
	{
		$bid_item_to_subcontractor_bid_id = (int) $bid_item_to_subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	bi2sb_fk_bi.`id` AS 'bi2sb_fk_bi__bid_item_id',
	bi2sb_fk_bi.`gc_budget_line_item_id` AS 'bi2sb_fk_bi__gc_budget_line_item_id',
	bi2sb_fk_bi.`bid_item` AS 'bi2sb_fk_bi__bid_item',
	bi2sb_fk_bi.`sort_order` AS 'bi2sb_fk_bi__sort_order',

	bi2sb_fk_sb.`id` AS 'bi2sb_fk_sb__subcontractor_bid_id',
	bi2sb_fk_sb.`gc_budget_line_item_id` AS 'bi2sb_fk_sb__gc_budget_line_item_id',
	bi2sb_fk_sb.`subcontractor_contact_id` AS 'bi2sb_fk_sb__subcontractor_contact_id',
	bi2sb_fk_sb.`subcontractor_bid_status_id` AS 'bi2sb_fk_sb__subcontractor_bid_status_id',
	bi2sb_fk_sb.`sort_order` AS 'bi2sb_fk_sb__sort_order',

	bi2sb.*

FROM `bid_items_to_subcontractor_bids` bi2sb
	INNER JOIN `bid_items` bi2sb_fk_bi ON bi2sb.`bid_item_id` = bi2sb_fk_bi.`id`
	INNER JOIN `subcontractor_bids` bi2sb_fk_sb ON bi2sb.`subcontractor_bid_id` = bi2sb_fk_sb.`id`
WHERE bi2sb.`id` = ?
";
		$arrValues = array($bid_item_to_subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$bid_item_to_subcontractor_bid_id = $row['id'];
			$bidItemToSubcontractorBid = self::instantiateOrm($database, 'BidItemToSubcontractorBid', $row, null, $bid_item_to_subcontractor_bid_id);
			/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */
			$bidItemToSubcontractorBid->convertPropertiesToData();

			if (isset($row['bid_item_id'])) {
				$bid_item_id = $row['bid_item_id'];
				$row['bi2sb_fk_bi__id'] = $bid_item_id;
				$bidItem = self::instantiateOrm($database, 'BidItem', $row, null, $bid_item_id, 'bi2sb_fk_bi__');
				/* @var $bidItem BidItem */
				$bidItem->convertPropertiesToData();
			} else {
				$bidItem = false;
			}
			$bidItemToSubcontractorBid->setBidItem($bidItem);

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['bi2sb_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'bi2sb_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$bidItemToSubcontractorBid->setSubcontractorBid($subcontractorBid);

			return $bidItemToSubcontractorBid;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_bid_item_to_subcontractor_bid` (`bid_item_id`,`subcontractor_bid_id`).
	 *
	 * @param string $database
	 * @param int $bid_item_id
	 * @param int $subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByBidItemIdAndSubcontractorBidId($database, $bid_item_id, $subcontractor_bid_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	bi2sb.*

FROM `bid_items_to_subcontractor_bids` bi2sb
WHERE bi2sb.`bid_item_id` = ?
AND bi2sb.`subcontractor_bid_id` = ?
";
		$arrValues = array($bid_item_id, $subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$bid_item_to_subcontractor_bid_id = $row['id'];
			$bidItemToSubcontractorBid = self::instantiateOrm($database, 'BidItemToSubcontractorBid', $row, null, $bid_item_to_subcontractor_bid_id);
			/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */
			return $bidItemToSubcontractorBid;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrBidItemToSubcontractorBidIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidItemsToSubcontractorBidsByArrBidItemToSubcontractorBidIds($database, $arrBidItemToSubcontractorBidIds, Input $options=null)
	{
		if (empty($arrBidItemToSubcontractorBidIds)) {
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
		// ORDER BY `id` ASC, `bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidItemToSubcontractorBid = new BidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrBidItemToSubcontractorBidIds as $k => $bid_item_to_subcontractor_bid_id) {
			$bid_item_to_subcontractor_bid_id = (int) $bid_item_to_subcontractor_bid_id;
			$arrBidItemToSubcontractorBidIds[$k] = $db->escape($bid_item_to_subcontractor_bid_id);
		}
		$csvBidItemToSubcontractorBidIds = join(',', $arrBidItemToSubcontractorBidIds);

		$query =
"
SELECT

	bi2sb.*

FROM `bid_items_to_subcontractor_bids` bi2sb
WHERE bi2sb.`id` IN ($csvBidItemToSubcontractorBidIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrBidItemsToSubcontractorBidsByCsvBidItemToSubcontractorBidIds = array();
		while ($row = $db->fetch()) {
			$bid_item_to_subcontractor_bid_id = $row['id'];
			$bidItemToSubcontractorBid = self::instantiateOrm($database, 'BidItemToSubcontractorBid', $row, null, $bid_item_to_subcontractor_bid_id);
			/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */
			$bidItemToSubcontractorBid->convertPropertiesToData();

			$arrBidItemsToSubcontractorBidsByCsvBidItemToSubcontractorBidIds[$bid_item_to_subcontractor_bid_id] = $bidItemToSubcontractorBid;
		}

		$db->free_result();

		return $arrBidItemsToSubcontractorBidsByCsvBidItemToSubcontractorBidIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `bid_items_to_subcontractor_bids_fk_bi` foreign key (`bid_item_id`) references `bid_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidItemsToSubcontractorBidsByBidItemId($database, $bid_item_id, Input $options=null)
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
			self::$_arrBidItemsToSubcontractorBidsByBidItemId = null;
		}

		$arrBidItemsToSubcontractorBidsByBidItemId = self::$_arrBidItemsToSubcontractorBidsByBidItemId;
		if (isset($arrBidItemsToSubcontractorBidsByBidItemId) && !empty($arrBidItemsToSubcontractorBidsByBidItemId)) {
			return $arrBidItemsToSubcontractorBidsByBidItemId;
		}

		$bid_item_id = (int) $bid_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidItemToSubcontractorBid = new BidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bi2sb.*

FROM `bid_items_to_subcontractor_bids` bi2sb
WHERE bi2sb.`bid_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$arrValues = array($bid_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidItemsToSubcontractorBidsByBidItemId = array();
		while ($row = $db->fetch()) {
			$bid_item_to_subcontractor_bid_id = $row['id'];
			$bidItemToSubcontractorBid = self::instantiateOrm($database, 'BidItemToSubcontractorBid', $row, null, $bid_item_to_subcontractor_bid_id);
			/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */
			$arrBidItemsToSubcontractorBidsByBidItemId[$bid_item_to_subcontractor_bid_id] = $bidItemToSubcontractorBid;
		}

		$db->free_result();

		self::$_arrBidItemsToSubcontractorBidsByBidItemId = $arrBidItemsToSubcontractorBidsByBidItemId;

		return $arrBidItemsToSubcontractorBidsByBidItemId;
	}

	/**
	 * Load by constraint `bid_items_to_subcontractor_bids_fk_sb` foreign key (`subcontractor_bid_id`) references `subcontractor_bids` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidItemsToSubcontractorBidsBySubcontractorBidId($database, $subcontractor_bid_id, Input $options=null)
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
			self::$_arrBidItemsToSubcontractorBidsBySubcontractorBidId = null;
		}

		$arrBidItemsToSubcontractorBidsBySubcontractorBidId = self::$_arrBidItemsToSubcontractorBidsBySubcontractorBidId;
		if (isset($arrBidItemsToSubcontractorBidsBySubcontractorBidId) && !empty($arrBidItemsToSubcontractorBidsBySubcontractorBidId)) {
			return $arrBidItemsToSubcontractorBidsBySubcontractorBidId;
		}

		$subcontractor_bid_id = (int) $subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidItemToSubcontractorBid = new BidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bi2sb.*

FROM `bid_items_to_subcontractor_bids` bi2sb
WHERE bi2sb.`subcontractor_bid_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidItemsToSubcontractorBidsBySubcontractorBidId = array();
		while ($row = $db->fetch()) {
			$bid_item_to_subcontractor_bid_id = $row['id'];
			$bidItemToSubcontractorBid = self::instantiateOrm($database, 'BidItemToSubcontractorBid', $row, null, $bid_item_to_subcontractor_bid_id);
			/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */
			$arrBidItemsToSubcontractorBidsBySubcontractorBidId[$bid_item_to_subcontractor_bid_id] = $bidItemToSubcontractorBid;
		}

		$db->free_result();

		self::$_arrBidItemsToSubcontractorBidsBySubcontractorBidId = $arrBidItemsToSubcontractorBidsBySubcontractorBidId;

		return $arrBidItemsToSubcontractorBidsBySubcontractorBidId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all bid_items_to_subcontractor_bids records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllBidItemsToSubcontractorBids($database, Input $options=null)
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
			self::$_arrAllBidItemsToSubcontractorBids = null;
		}

		$arrAllBidItemsToSubcontractorBids = self::$_arrAllBidItemsToSubcontractorBids;
		if (isset($arrAllBidItemsToSubcontractorBids) && !empty($arrAllBidItemsToSubcontractorBids)) {
			return $arrAllBidItemsToSubcontractorBids;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidItemToSubcontractorBid = new BidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bi2sb.*

FROM `bid_items_to_subcontractor_bids` bi2sb{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllBidItemsToSubcontractorBids = array();
		while ($row = $db->fetch()) {
			$bid_item_to_subcontractor_bid_id = $row['id'];
			$bidItemToSubcontractorBid = self::instantiateOrm($database, 'BidItemToSubcontractorBid', $row, null, $bid_item_to_subcontractor_bid_id);
			/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */
			$arrAllBidItemsToSubcontractorBids[$bid_item_to_subcontractor_bid_id] = $bidItemToSubcontractorBid;
		}

		$db->free_result();

		self::$_arrAllBidItemsToSubcontractorBids = $arrAllBidItemsToSubcontractorBids;

		return $arrAllBidItemsToSubcontractorBids;
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
INTO `bid_items_to_subcontractor_bids`
(`bid_item_id`, `subcontractor_bid_id`, `item_quantity`, `unit`, `unit_price`, `exclude_bid_item_flag`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `item_quantity` = ?, `unit` = ?, `unit_price` = ?, `exclude_bid_item_flag` = ?
";
		$arrValues = array($this->bid_item_id, $this->subcontractor_bid_id, $this->item_quantity, $this->unit, $this->unit_price, $this->exclude_bid_item_flag, $this->item_quantity, $this->unit, $this->unit_price, $this->exclude_bid_item_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$bid_item_to_subcontractor_bid_id = $db->insertId;
		$db->free_result();

		return $bid_item_to_subcontractor_bid_id;
	}

	// Save: insert ignore

	/**
	 * Load by derived values via gc_budget_line_items.
	 *
	 * @param string $database
	 * @param int $bid_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadBidItemsToSubcontractorBidsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
			$arrSubcontractorBidStatusIdIn = $options->arrSubcontractorBidStatusIdIn;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrBidItemsToSubcontractorBidsByGcBudgetLineItemId = null;
		}

		$arrBidItemsToSubcontractorBidsByGcBudgetLineItemId = self::$_arrBidItemsToSubcontractorBidsByGcBudgetLineItemId;
		if (isset($arrBidItemsToSubcontractorBidsByGcBudgetLineItemId) && !empty($arrBidItemsToSubcontractorBidsByGcBudgetLineItemId)) {
			return $arrBidItemsToSubcontractorBidsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `bid_item_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = "\nORDER BY bi2sb_fk_sb.`sort_order` ASC, bi2sb_fk_bi.`sort_order` ASC, bi2sb.`subcontractor_bid_id` ASC, bi2sb.`bid_item_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidItemToSubcontractorBid = new BidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$sqlFilter = '';
		if (isset($arrSubcontractorBidStatusIdIn) && !empty($arrSubcontractorBidStatusIdIn)) {
			$in = join(',', $arrSubcontractorBidStatusIdIn);
			$sqlFilter = "\nAND bi2sb_fk_sb.`subcontractor_bid_status_id` IN ($in)";
		} else {
			$sqlFilter = '';
		}

		$query =
"
SELECT

	bi2sb.*
FROM `bid_items_to_subcontractor_bids` bi2sb
	INNER JOIN `bid_items` bi2sb_fk_bi ON bi2sb.`bid_item_id` = bi2sb_fk_bi.`id`
	INNER JOIN `subcontractor_bids` bi2sb_fk_sb ON bi2sb.`subcontractor_bid_id` = bi2sb_fk_sb.`id`

	INNER JOIN `gc_budget_line_items` gbli ON bi2sb_fk_bi.`gc_budget_line_item_id` = gbli.`id`
WHERE gbli.`id` = ?{$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `bid_item_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidItemsToSubcontractorBidsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$subcontractor_bid_id = $row['subcontractor_bid_id'];
			$bid_item_id = $row['bid_item_id'];

			$bidItemToSubcontractorBid = self::instantiateOrm($database, 'BidItemToSubcontractorBid', $row, null, $id);
			/* @var $bidItemToSubcontractorBid BidItemToSubcontractorBid */
			$arrBidItemsToSubcontractorBidsByGcBudgetLineItemId[$bid_item_id][$subcontractor_bid_id] = $bidItemToSubcontractorBid;
		}

		$db->free_result();

		self::$_arrBidItemsToSubcontractorBidsByGcBudgetLineItemId = $arrBidItemsToSubcontractorBidsByGcBudgetLineItemId;

		return $arrBidItemsToSubcontractorBidsByGcBudgetLineItemId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

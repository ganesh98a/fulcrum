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
 * ScBidItemToSubcontractorBid.
 *
 * @category   Framework
 * @package    ScBidItemToSubcontractorBid
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ScBidItemToSubcontractorBid extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ScBidItemToSubcontractorBid';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'sc_bid_items_to_subcontractor_bids';

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
	 * unique index `unique_sc_bid_item_to_subcontractor_bid` (`sc_bid_item_id`,`subcontractor_bid_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_sc_bid_item_to_subcontractor_bid' => array(
			'sc_bid_item_id' => 'int',
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
		'id' => 'sc_bid_item_to_subcontractor_bid_id',

		'sc_bid_item_id' => 'sc_bid_item_id',
		'subcontractor_bid_id' => 'subcontractor_bid_id',

		'item_quantity' => 'item_quantity',
		'unit' => 'unit',
		'unit_price' => 'unit_price',
		'exclude_bid_item_flag' => 'exclude_bid_item_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $sc_bid_item_to_subcontractor_bid_id;

	public $sc_bid_item_id;
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
	protected static $_arrScBidItemsToSubcontractorBidsByScBidItemId;
	protected static $_arrScBidItemsToSubcontractorBidsBySubcontractorBidId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllScBidItemsToSubcontractorBids;

	// Foreign Key Objects
	private $_scBidItem;
	private $_subcontractorBid;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='sc_bid_items_to_subcontractor_bids')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getScBidItem()
	{
		if (isset($this->_scBidItem)) {
			return $this->_scBidItem;
		} else {
			return null;
		}
	}

	public function setScBidItem($scBidItem)
	{
		$this->_scBidItem = $scBidItem;
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
	public static function getArrScBidItemsToSubcontractorBidsByScBidItemId()
	{
		if (isset(self::$_arrScBidItemsToSubcontractorBidsByScBidItemId)) {
			return self::$_arrScBidItemsToSubcontractorBidsByScBidItemId;
		} else {
			return null;
		}
	}

	public static function setArrScBidItemsToSubcontractorBidsByScBidItemId($arrScBidItemsToSubcontractorBidsByScBidItemId)
	{
		self::$_arrScBidItemsToSubcontractorBidsByScBidItemId = $arrScBidItemsToSubcontractorBidsByScBidItemId;
	}

	public static function getArrScBidItemsToSubcontractorBidsBySubcontractorBidId()
	{
		if (isset(self::$_arrScBidItemsToSubcontractorBidsBySubcontractorBidId)) {
			return self::$_arrScBidItemsToSubcontractorBidsBySubcontractorBidId;
		} else {
			return null;
		}
	}

	public static function setArrScBidItemsToSubcontractorBidsBySubcontractorBidId($arrScBidItemsToSubcontractorBidsBySubcontractorBidId)
	{
		self::$_arrScBidItemsToSubcontractorBidsBySubcontractorBidId = $arrScBidItemsToSubcontractorBidsBySubcontractorBidId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllScBidItemsToSubcontractorBids()
	{
		if (isset(self::$_arrAllScBidItemsToSubcontractorBids)) {
			return self::$_arrAllScBidItemsToSubcontractorBids;
		} else {
			return null;
		}
	}

	public static function setArrAllScBidItemsToSubcontractorBids($arrAllScBidItemsToSubcontractorBids)
	{
		self::$_arrAllScBidItemsToSubcontractorBids = $arrAllScBidItemsToSubcontractorBids;
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
	 * @param int $sc_bid_item_to_subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $sc_bid_item_to_subcontractor_bid_id,$table='sc_bid_items_to_subcontractor_bids', $module='ScBidItemToSubcontractorBid')
	{
		$scBidItemToSubcontractorBid = parent::findById($database, $sc_bid_item_to_subcontractor_bid_id,$table, $module);

		return $scBidItemToSubcontractorBid;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $sc_bid_item_to_subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findScBidItemToSubcontractorBidByIdExtended($database, $sc_bid_item_to_subcontractor_bid_id)
	{
		$sc_bid_item_to_subcontractor_bid_id = (int) $sc_bid_item_to_subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sbi2sb_fk_sbi.`id` AS 'sbi2sb_fk_sbi__sc_bid_item_id',
	sbi2sb_fk_sbi.`gc_budget_line_item_id` AS 'sbi2sb_fk_sbi__gc_budget_line_item_id',
	sbi2sb_fk_sbi.`sc_bid_item` AS 'sbi2sb_fk_sbi__sc_bid_item',
	sbi2sb_fk_sbi.`sort_order` AS 'sbi2sb_fk_sbi__sort_order',

	sbi2sb_fk_sb.`id` AS 'sbi2sb_fk_sb__subcontractor_bid_id',
	sbi2sb_fk_sb.`gc_budget_line_item_id` AS 'sbi2sb_fk_sb__gc_budget_line_item_id',
	sbi2sb_fk_sb.`subcontractor_contact_id` AS 'sbi2sb_fk_sb__subcontractor_contact_id',
	sbi2sb_fk_sb.`subcontractor_bid_status_id` AS 'sbi2sb_fk_sb__subcontractor_bid_status_id',
	sbi2sb_fk_sb.`sort_order` AS 'sbi2sb_fk_sb__sort_order',

	sbi2sb.*

FROM `sc_bid_items_to_subcontractor_bids` sbi2sb
	INNER JOIN `sc_bid_items` sbi2sb_fk_sbi ON sbi2sb.`sc_bid_item_id` = sbi2sb_fk_sbi.`id`
	INNER JOIN `subcontractor_bids` sbi2sb_fk_sb ON sbi2sb.`subcontractor_bid_id` = sbi2sb_fk_sb.`id`
WHERE sbi2sb.`id` = ?
";
		$arrValues = array($sc_bid_item_to_subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$sc_bid_item_to_subcontractor_bid_id = $row['id'];
			$scBidItemToSubcontractorBid = self::instantiateOrm($database, 'ScBidItemToSubcontractorBid', $row, null, $sc_bid_item_to_subcontractor_bid_id);
			/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */
			$scBidItemToSubcontractorBid->convertPropertiesToData();

			if (isset($row['sc_bid_item_id'])) {
				$sc_bid_item_id = $row['sc_bid_item_id'];
				$row['sbi2sb_fk_sbi__id'] = $sc_bid_item_id;
				$scBidItem = self::instantiateOrm($database, 'ScBidItem', $row, null, $sc_bid_item_id, 'sbi2sb_fk_sbi__');
				/* @var $scBidItem ScBidItem */
				$scBidItem->convertPropertiesToData();
			} else {
				$scBidItem = false;
			}
			$scBidItemToSubcontractorBid->setScBidItem($scBidItem);

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['sbi2sb_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sbi2sb_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$scBidItemToSubcontractorBid->setSubcontractorBid($subcontractorBid);

			return $scBidItemToSubcontractorBid;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_sc_bid_item_to_subcontractor_bid` (`sc_bid_item_id`,`subcontractor_bid_id`).
	 *
	 * @param string $database
	 * @param int $sc_bid_item_id
	 * @param int $subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByScBidItemIdAndSubcontractorBidId($database, $sc_bid_item_id, $subcontractor_bid_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sbi2sb.*

FROM `sc_bid_items_to_subcontractor_bids` sbi2sb
WHERE sbi2sb.`sc_bid_item_id` = ?
AND sbi2sb.`subcontractor_bid_id` = ?
";
		$arrValues = array($sc_bid_item_id, $subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$sc_bid_item_to_subcontractor_bid_id = $row['id'];
			$scBidItemToSubcontractorBid = self::instantiateOrm($database, 'ScBidItemToSubcontractorBid', $row, null, $sc_bid_item_to_subcontractor_bid_id);
			/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */
			return $scBidItemToSubcontractorBid;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrScBidItemToSubcontractorBidIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadScBidItemsToSubcontractorBidsByArrScBidItemToSubcontractorBidIds($database, $arrScBidItemToSubcontractorBidIds, Input $options=null)
	{
		if (empty($arrScBidItemToSubcontractorBidIds)) {
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
		// ORDER BY `id` ASC, `sc_bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpScBidItemToSubcontractorBid = new ScBidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpScBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrScBidItemToSubcontractorBidIds as $k => $sc_bid_item_to_subcontractor_bid_id) {
			$sc_bid_item_to_subcontractor_bid_id = (int) $sc_bid_item_to_subcontractor_bid_id;
			$arrScBidItemToSubcontractorBidIds[$k] = $db->escape($sc_bid_item_to_subcontractor_bid_id);
		}
		$csvScBidItemToSubcontractorBidIds = join(',', $arrScBidItemToSubcontractorBidIds);

		$query =
"
SELECT

	sbi2sb.*

FROM `sc_bid_items_to_subcontractor_bids` sbi2sb
WHERE sbi2sb.`id` IN ($csvScBidItemToSubcontractorBidIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrScBidItemsToSubcontractorBidsByCsvScBidItemToSubcontractorBidIds = array();
		while ($row = $db->fetch()) {
			$sc_bid_item_to_subcontractor_bid_id = $row['id'];
			$scBidItemToSubcontractorBid = self::instantiateOrm($database, 'ScBidItemToSubcontractorBid', $row, null, $sc_bid_item_to_subcontractor_bid_id);
			/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */
			$scBidItemToSubcontractorBid->convertPropertiesToData();

			$arrScBidItemsToSubcontractorBidsByCsvScBidItemToSubcontractorBidIds[$sc_bid_item_to_subcontractor_bid_id] = $scBidItemToSubcontractorBid;
		}

		$db->free_result();

		return $arrScBidItemsToSubcontractorBidsByCsvScBidItemToSubcontractorBidIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `sc_bid_items_to_subcontractor_bids_fk_sbi` foreign key (`sc_bid_item_id`) references `sc_bid_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $sc_bid_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadScBidItemsToSubcontractorBidsByScBidItemId($database, $sc_bid_item_id, Input $options=null)
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
			self::$_arrScBidItemsToSubcontractorBidsByScBidItemId = null;
		}

		$arrScBidItemsToSubcontractorBidsByScBidItemId = self::$_arrScBidItemsToSubcontractorBidsByScBidItemId;
		if (isset($arrScBidItemsToSubcontractorBidsByScBidItemId) && !empty($arrScBidItemsToSubcontractorBidsByScBidItemId)) {
			return $arrScBidItemsToSubcontractorBidsByScBidItemId;
		}

		$sc_bid_item_id = (int) $sc_bid_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `sc_bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpScBidItemToSubcontractorBid = new ScBidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpScBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbi2sb.*

FROM `sc_bid_items_to_subcontractor_bids` sbi2sb
WHERE sbi2sb.`sc_bid_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `sc_bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$arrValues = array($sc_bid_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrScBidItemsToSubcontractorBidsByScBidItemId = array();
		while ($row = $db->fetch()) {
			$sc_bid_item_to_subcontractor_bid_id = $row['id'];
			$scBidItemToSubcontractorBid = self::instantiateOrm($database, 'ScBidItemToSubcontractorBid', $row, null, $sc_bid_item_to_subcontractor_bid_id);
			/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */
			$arrScBidItemsToSubcontractorBidsByScBidItemId[$sc_bid_item_to_subcontractor_bid_id] = $scBidItemToSubcontractorBid;
		}

		$db->free_result();

		self::$_arrScBidItemsToSubcontractorBidsByScBidItemId = $arrScBidItemsToSubcontractorBidsByScBidItemId;

		return $arrScBidItemsToSubcontractorBidsByScBidItemId;
	}

	/**
	 * Load by constraint `sc_bid_items_to_subcontractor_bids_fk_sb` foreign key (`subcontractor_bid_id`) references `subcontractor_bids` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadScBidItemsToSubcontractorBidsBySubcontractorBidId($database, $subcontractor_bid_id, Input $options=null)
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
			self::$_arrScBidItemsToSubcontractorBidsBySubcontractorBidId = null;
		}

		$arrScBidItemsToSubcontractorBidsBySubcontractorBidId = self::$_arrScBidItemsToSubcontractorBidsBySubcontractorBidId;
		if (isset($arrScBidItemsToSubcontractorBidsBySubcontractorBidId) && !empty($arrScBidItemsToSubcontractorBidsBySubcontractorBidId)) {
			return $arrScBidItemsToSubcontractorBidsBySubcontractorBidId;
		}

		$subcontractor_bid_id = (int) $subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `sc_bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpScBidItemToSubcontractorBid = new ScBidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpScBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbi2sb.*

FROM `sc_bid_items_to_subcontractor_bids` sbi2sb
WHERE sbi2sb.`subcontractor_bid_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `sc_bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrScBidItemsToSubcontractorBidsBySubcontractorBidId = array();
		while ($row = $db->fetch()) {
			$sc_bid_item_to_subcontractor_bid_id = $row['id'];
			$scBidItemToSubcontractorBid = self::instantiateOrm($database, 'ScBidItemToSubcontractorBid', $row, null, $sc_bid_item_to_subcontractor_bid_id);
			/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */
			$arrScBidItemsToSubcontractorBidsBySubcontractorBidId[$sc_bid_item_to_subcontractor_bid_id] = $scBidItemToSubcontractorBid;
		}

		$db->free_result();

		self::$_arrScBidItemsToSubcontractorBidsBySubcontractorBidId = $arrScBidItemsToSubcontractorBidsBySubcontractorBidId;

		return $arrScBidItemsToSubcontractorBidsBySubcontractorBidId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all sc_bid_items_to_subcontractor_bids records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllScBidItemsToSubcontractorBids($database, Input $options=null)
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
			self::$_arrAllScBidItemsToSubcontractorBids = null;
		}

		$arrAllScBidItemsToSubcontractorBids = self::$_arrAllScBidItemsToSubcontractorBids;
		if (isset($arrAllScBidItemsToSubcontractorBids) && !empty($arrAllScBidItemsToSubcontractorBids)) {
			return $arrAllScBidItemsToSubcontractorBids;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `sc_bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpScBidItemToSubcontractorBid = new ScBidItemToSubcontractorBid($database);
			$sqlOrderByColumns = $tmpScBidItemToSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbi2sb.*

FROM `sc_bid_items_to_subcontractor_bids` sbi2sb{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `sc_bid_item_id` ASC, `subcontractor_bid_id` ASC, `item_quantity` ASC, `unit` ASC, `unit_price` ASC, `exclude_bid_item_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllScBidItemsToSubcontractorBids = array();
		while ($row = $db->fetch()) {
			$sc_bid_item_to_subcontractor_bid_id = $row['id'];
			$scBidItemToSubcontractorBid = self::instantiateOrm($database, 'ScBidItemToSubcontractorBid', $row, null, $sc_bid_item_to_subcontractor_bid_id);
			/* @var $scBidItemToSubcontractorBid ScBidItemToSubcontractorBid */
			$arrAllScBidItemsToSubcontractorBids[$sc_bid_item_to_subcontractor_bid_id] = $scBidItemToSubcontractorBid;
		}

		$db->free_result();

		self::$_arrAllScBidItemsToSubcontractorBids = $arrAllScBidItemsToSubcontractorBids;

		return $arrAllScBidItemsToSubcontractorBids;
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
INTO `sc_bid_items_to_subcontractor_bids`
(`sc_bid_item_id`, `subcontractor_bid_id`, `item_quantity`, `unit`, `unit_price`, `exclude_bid_item_flag`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `item_quantity` = ?, `unit` = ?, `unit_price` = ?, `exclude_bid_item_flag` = ?
";
		$arrValues = array($this->sc_bid_item_id, $this->subcontractor_bid_id, $this->item_quantity, $this->unit, $this->unit_price, $this->exclude_bid_item_flag, $this->item_quantity, $this->unit, $this->unit_price, $this->exclude_bid_item_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$sc_bid_item_to_subcontractor_bid_id = $db->insertId;
		$db->free_result();

		return $sc_bid_item_to_subcontractor_bid_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

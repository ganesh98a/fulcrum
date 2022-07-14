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
 * BidSpreadStatus.
 *
 * @category   Framework
 * @package    BidSpreadStatus
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class BidSpreadStatus extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidSpreadStatus';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_spread_statuses';

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
		'unique_bid_spread_status_via_primary_key' => array(
			'bid_spread_status_id' => 'int'
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
		'id' => 'bid_spread_status_id',

		'bid_spread_status' => 'bid_spread_status',
		'bid_spread_status_action_label' => 'bid_spread_status_action_label',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_spread_status_id;

	public $bid_spread_status;
	public $bid_spread_status_action_label;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_bid_spread_status;
	public $escaped_bid_spread_status_action_label;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_bid_spread_status_nl2br;
	public $escaped_bid_spread_status_action_label_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllBidSpreadStatuses;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_spread_statuses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllBidSpreadStatuses()
	{
		if (isset(self::$_arrAllBidSpreadStatuses)) {
			return self::$_arrAllBidSpreadStatuses;
		} else {
			return null;
		}
	}

	public static function setArrAllBidSpreadStatuses($arrAllBidSpreadStatuses)
	{
		self::$_arrAllBidSpreadStatuses = $arrAllBidSpreadStatuses;
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
	 * @param int $bid_spread_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $bid_spread_status_id, $table='bid_spread_statuses', $module='BidSpreadStatus')
	{
		$bidSpreadStatus = parent::findById($database, $bid_spread_status_id, $table, $module);

		return $bidSpreadStatus;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $bid_spread_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBidSpreadStatusByIdExtended($database, $bid_spread_status_id)
	{
		$bid_spread_status_id = (int) $bid_spread_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	bss.*

FROM `bid_spread_statuses` bss
WHERE bss.`id` = ?
";
		$arrValues = array($bid_spread_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$bid_spread_status_id = $row['id'];
			$bidSpreadStatus = self::instantiateOrm($database, 'BidSpreadStatus', $row, null, $bid_spread_status_id);
			/* @var $bidSpreadStatus BidSpreadStatus */
			$bidSpreadStatus->convertPropertiesToData();

			return $bidSpreadStatus;
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
	 * @param array $arrBidSpreadStatusIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadStatusesByArrBidSpreadStatusIds($database, $arrBidSpreadStatusIds, Input $options=null)
	{
		if (empty($arrBidSpreadStatusIds)) {
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
		// ORDER BY `id` ASC, `bid_spread_status` ASC, `bid_spread_status_action_label` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bss.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadStatus = new BidSpreadStatus($database);
			$sqlOrderByColumns = $tmpBidSpreadStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrBidSpreadStatusIds as $k => $bid_spread_status_id) {
			$bid_spread_status_id = (int) $bid_spread_status_id;
			$arrBidSpreadStatusIds[$k] = $db->escape($bid_spread_status_id);
		}
		$csvBidSpreadStatusIds = join(',', $arrBidSpreadStatusIds);

		$query =
"
SELECT

	bss.*

FROM `bid_spread_statuses` bss
WHERE bss.`id` IN ($csvBidSpreadStatusIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrBidSpreadStatusesByCsvBidSpreadStatusIds = array();
		while ($row = $db->fetch()) {
			$bid_spread_status_id = $row['id'];
			$bidSpreadStatus = self::instantiateOrm($database, 'BidSpreadStatus', $row, null, $bid_spread_status_id);
			/* @var $bidSpreadStatus BidSpreadStatus */
			$bidSpreadStatus->convertPropertiesToData();

			$arrBidSpreadStatusesByCsvBidSpreadStatusIds[$bid_spread_status_id] = $bidSpreadStatus;
		}

		$db->free_result();

		return $arrBidSpreadStatusesByCsvBidSpreadStatusIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all bid_spread_statuses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllBidSpreadStatuses($database, Input $options=null)
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
			self::$_arrAllBidSpreadStatuses = null;
		}

		$arrAllBidSpreadStatuses = self::$_arrAllBidSpreadStatuses;
		if (isset($arrAllBidSpreadStatuses) && !empty($arrAllBidSpreadStatuses)) {
			return $arrAllBidSpreadStatuses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `bid_spread_status` ASC, `bid_spread_status_action_label` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bss.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadStatus = new BidSpreadStatus($database);
			$sqlOrderByColumns = $tmpBidSpreadStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bss.*

FROM `bid_spread_statuses` bss{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `bid_spread_status` ASC, `bid_spread_status_action_label` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllBidSpreadStatuses = array();
		while ($row = $db->fetch()) {
			$bid_spread_status_id = $row['id'];
			$bidSpreadStatus = self::instantiateOrm($database, 'BidSpreadStatus', $row, null, $bid_spread_status_id);
			/* @var $bidSpreadStatus BidSpreadStatus */
			$arrAllBidSpreadStatuses[$bid_spread_status_id] = $bidSpreadStatus;
		}

		$db->free_result();

		self::$_arrAllBidSpreadStatuses = $arrAllBidSpreadStatuses;

		return $arrAllBidSpreadStatuses;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

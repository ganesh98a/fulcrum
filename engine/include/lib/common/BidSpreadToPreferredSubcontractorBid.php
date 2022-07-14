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
 * BidSpreadToPreferredSubcontractorBid.
 *
 * @category   Framework
 * @package    BidSpreadToPreferredSubcontractorBid
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class BidSpreadToPreferredSubcontractorBid extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidSpreadToPreferredSubcontractorBid';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_spreads_to_preferred_subcontractor_bids';

	/**
	 * primary key (`bid_spread_id`,`bid_spread_preferred_subcontractor_bid_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'bid_spread_id' => 'int',
		'bid_spread_preferred_subcontractor_bid_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_bid_spread_to_preferred_subcontractor_bid_via_primary_key' => array(
			'bid_spread_id' => 'int',
			'bid_spread_preferred_subcontractor_bid_id' => 'int'
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
		'bid_spread_id' => 'bid_spread_id',
		'bid_spread_preferred_subcontractor_bid_id' => 'bid_spread_preferred_subcontractor_bid_id',

		'bid_spread_preferred_subcontractor_contact_id' => 'bid_spread_preferred_subcontractor_contact_id',

		'preferred_subcontractor_bid_total' => 'preferred_subcontractor_bid_total',
		'preferred_subcontractor_approved_bid_total' => 'preferred_subcontractor_approved_bid_total'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_spread_id;
	public $bid_spread_preferred_subcontractor_bid_id;

	public $bid_spread_preferred_subcontractor_contact_id;

	public $preferred_subcontractor_bid_total;
	public $preferred_subcontractor_approved_bid_total;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId;
	protected static $_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId;
	protected static $_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllBidSpreadsToPreferredSubcontractorBids;

	// Foreign Key Objects
	private $_bidSpread;
	private $_bidSpreadPreferredSubcontractorBid;
	private $_bidSpreadPreferredSubcontractorContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_spreads_to_preferred_subcontractor_bids')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getBidSpread()
	{
		if (isset($this->_bidSpread)) {
			return $this->_bidSpread;
		} else {
			return null;
		}
	}

	public function setBidSpread($bidSpread)
	{
		$this->_bidSpread = $bidSpread;
	}

	public function getBidSpreadPreferredSubcontractorBid()
	{
		if (isset($this->_bidSpreadPreferredSubcontractorBid)) {
			return $this->_bidSpreadPreferredSubcontractorBid;
		} else {
			return null;
		}
	}

	public function setBidSpreadPreferredSubcontractorBid($bidSpreadPreferredSubcontractorBid)
	{
		$this->_bidSpreadPreferredSubcontractorBid = $bidSpreadPreferredSubcontractorBid;
	}

	public function getBidSpreadPreferredSubcontractorContact()
	{
		if (isset($this->_bidSpreadPreferredSubcontractorContact)) {
			return $this->_bidSpreadPreferredSubcontractorContact;
		} else {
			return null;
		}
	}

	public function setBidSpreadPreferredSubcontractorContact($bidSpreadPreferredSubcontractorContact)
	{
		$this->_bidSpreadPreferredSubcontractorContact = $bidSpreadPreferredSubcontractorContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId()
	{
		if (isset(self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId)) {
			return self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId)
	{
		self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId = $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId;
	}

	public static function getArrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId()
	{
		if (isset(self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId)) {
			return self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId)
	{
		self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId = $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId;
	}

	public static function getArrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId()
	{
		if (isset(self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId)) {
			return self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId)
	{
		self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId = $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllBidSpreadsToPreferredSubcontractorBids()
	{
		if (isset(self::$_arrAllBidSpreadsToPreferredSubcontractorBids)) {
			return self::$_arrAllBidSpreadsToPreferredSubcontractorBids;
		} else {
			return null;
		}
	}

	public static function setArrAllBidSpreadsToPreferredSubcontractorBids($arrAllBidSpreadsToPreferredSubcontractorBids)
	{
		self::$_arrAllBidSpreadsToPreferredSubcontractorBids = $arrAllBidSpreadsToPreferredSubcontractorBids;
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
	 * Find by primary key (`bid_spread_id`,`bid_spread_preferred_subcontractor_bid_id`).
	 *
	 * @param string $database
	 * @param int $bid_spread_id
	 * @param int $bid_spread_preferred_subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByBidSpreadIdAndBidSpreadPreferredSubcontractorBidId($database, $bid_spread_id, $bid_spread_preferred_subcontractor_bid_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	bs2psb.*

FROM `bid_spreads_to_preferred_subcontractor_bids` bs2psb
WHERE bs2psb.`bid_spread_id` = ?
AND bs2psb.`bid_spread_preferred_subcontractor_bid_id` = ?
";
		$arrValues = array($bid_spread_id, $bid_spread_preferred_subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$bidSpreadToPreferredSubcontractorBid = self::instantiateOrm($database, 'BidSpreadToPreferredSubcontractorBid', $row);
			/* @var $bidSpreadToPreferredSubcontractorBid BidSpreadToPreferredSubcontractorBid */
			return $bidSpreadToPreferredSubcontractorBid;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`bid_spread_id`,`bid_spread_preferred_subcontractor_bid_id`) Extended.
	 *
	 * @param string $database
	 * @param int $bid_spread_id
	 * @param int $bid_spread_preferred_subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdExtended($database, $bid_spread_id, $bid_spread_preferred_subcontractor_bid_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	bs2psb_fk_bs.`id` AS 'bs2psb_fk_bs__bid_spread_id',
	bs2psb_fk_bs.`gc_budget_line_item_id` AS 'bs2psb_fk_bs__gc_budget_line_item_id',
	bs2psb_fk_bs.`bid_spread_sequence_number` AS 'bs2psb_fk_bs__bid_spread_sequence_number',
	bs2psb_fk_bs.`bid_spread_status_id` AS 'bs2psb_fk_bs__bid_spread_status_id',
	bs2psb_fk_bs.`bid_spreadsheet_data_sha1` AS 'bs2psb_fk_bs__bid_spreadsheet_data_sha1',
	bs2psb_fk_bs.`bid_spread_submitter_gc_project_manager_contact_id` AS 'bs2psb_fk_bs__bid_spread_submitter_gc_project_manager_contact_id',
	bs2psb_fk_bs.`bid_spread_approver_gc_project_executive_contact_id` AS 'bs2psb_fk_bs__bid_spread_approver_gc_project_executive_contact_id',
	bs2psb_fk_bs.`bid_spread_bid_total` AS 'bs2psb_fk_bs__bid_spread_bid_total',
	bs2psb_fk_bs.`bid_spread_approved_value` AS 'bs2psb_fk_bs__bid_spread_approved_value',
	bs2psb_fk_bs.`unsigned_bid_spread_pdf_file_manager_file_id` AS 'bs2psb_fk_bs__unsigned_bid_spread_pdf_file_manager_file_id',
	bs2psb_fk_bs.`signed_bid_spread_pdf_file_manager_file_id` AS 'bs2psb_fk_bs__signed_bid_spread_pdf_file_manager_file_id',
	bs2psb_fk_bs.`unsigned_bid_spread_xls_file_manager_file_id` AS 'bs2psb_fk_bs__unsigned_bid_spread_xls_file_manager_file_id',
	bs2psb_fk_bs.`signed_bid_spread_xls_file_manager_file_id` AS 'bs2psb_fk_bs__signed_bid_spread_xls_file_manager_file_id',
	bs2psb_fk_bs.`modified` AS 'bs2psb_fk_bs__modified',
	bs2psb_fk_bs.`created` AS 'bs2psb_fk_bs__created',
	bs2psb_fk_bs.`display_linked_cost_codes_flag` AS 'bs2psb_fk_bs__display_linked_cost_codes_flag',
	bs2psb_fk_bs.`sort_order` AS 'bs2psb_fk_bs__sort_order',

	bs2psb_fk_preferred_sb.`id` AS 'bs2psb_fk_preferred_sb__subcontractor_bid_id',
	bs2psb_fk_preferred_sb.`gc_budget_line_item_id` AS 'bs2psb_fk_preferred_sb__gc_budget_line_item_id',
	bs2psb_fk_preferred_sb.`subcontractor_contact_id` AS 'bs2psb_fk_preferred_sb__subcontractor_contact_id',
	bs2psb_fk_preferred_sb.`subcontractor_bid_status_id` AS 'bs2psb_fk_preferred_sb__subcontractor_bid_status_id',
	bs2psb_fk_preferred_sb.`sort_order` AS 'bs2psb_fk_preferred_sb__sort_order',

	bs2psb_fk_preferred_sb_c.`id` AS 'bs2psb_fk_preferred_sb_c__contact_id',
	bs2psb_fk_preferred_sb_c.`user_company_id` AS 'bs2psb_fk_preferred_sb_c__user_company_id',
	bs2psb_fk_preferred_sb_c.`user_id` AS 'bs2psb_fk_preferred_sb_c__user_id',
	bs2psb_fk_preferred_sb_c.`contact_company_id` AS 'bs2psb_fk_preferred_sb_c__contact_company_id',
	bs2psb_fk_preferred_sb_c.`email` AS 'bs2psb_fk_preferred_sb_c__email',
	bs2psb_fk_preferred_sb_c.`name_prefix` AS 'bs2psb_fk_preferred_sb_c__name_prefix',
	bs2psb_fk_preferred_sb_c.`first_name` AS 'bs2psb_fk_preferred_sb_c__first_name',
	bs2psb_fk_preferred_sb_c.`additional_name` AS 'bs2psb_fk_preferred_sb_c__additional_name',
	bs2psb_fk_preferred_sb_c.`middle_name` AS 'bs2psb_fk_preferred_sb_c__middle_name',
	bs2psb_fk_preferred_sb_c.`last_name` AS 'bs2psb_fk_preferred_sb_c__last_name',
	bs2psb_fk_preferred_sb_c.`name_suffix` AS 'bs2psb_fk_preferred_sb_c__name_suffix',
	bs2psb_fk_preferred_sb_c.`title` AS 'bs2psb_fk_preferred_sb_c__title',
	bs2psb_fk_preferred_sb_c.`vendor_flag` AS 'bs2psb_fk_preferred_sb_c__vendor_flag',

	bs2psb.*

FROM `bid_spreads_to_preferred_subcontractor_bids` bs2psb
	INNER JOIN `bid_spreads` bs2psb_fk_bs ON bs2psb.`bid_spread_id` = bs2psb_fk_bs.`id`
	INNER JOIN `subcontractor_bids` bs2psb_fk_preferred_sb ON bs2psb.`bid_spread_preferred_subcontractor_bid_id` = bs2psb_fk_preferred_sb.`id`
	INNER JOIN `contacts` bs2psb_fk_preferred_sb_c ON bs2psb.`bid_spread_preferred_subcontractor_contact_id` = bs2psb_fk_preferred_sb_c.`id`
WHERE bs2psb.`bid_spread_id` = ?
AND bs2psb.`bid_spread_preferred_subcontractor_bid_id` = ?
";
		$arrValues = array($bid_spread_id, $bid_spread_preferred_subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$bidSpreadToPreferredSubcontractorBid = self::instantiateOrm($database, 'BidSpreadToPreferredSubcontractorBid', $row);
			/* @var $bidSpreadToPreferredSubcontractorBid BidSpreadToPreferredSubcontractorBid */
			$bidSpreadToPreferredSubcontractorBid->convertPropertiesToData();

			if (isset($row['bid_spread_id'])) {
				$bid_spread_id = $row['bid_spread_id'];
				$row['bs2psb_fk_bs__id'] = $bid_spread_id;
				$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id, 'bs2psb_fk_bs__');
				/* @var $bidSpread BidSpread */
				$bidSpread->convertPropertiesToData();
			} else {
				$bidSpread = false;
			}
			$bidSpreadToPreferredSubcontractorBid->setBidSpread($bidSpread);

			if (isset($row['bid_spread_preferred_subcontractor_bid_id'])) {
				$bid_spread_preferred_subcontractor_bid_id = $row['bid_spread_preferred_subcontractor_bid_id'];
				$row['bs2psb_fk_preferred_sb__id'] = $bid_spread_preferred_subcontractor_bid_id;
				$bidSpreadPreferredSubcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $bid_spread_preferred_subcontractor_bid_id, 'bs2psb_fk_preferred_sb__');
				/* @var $bidSpreadPreferredSubcontractorBid SubcontractorBid */
				$bidSpreadPreferredSubcontractorBid->convertPropertiesToData();
			} else {
				$bidSpreadPreferredSubcontractorBid = false;
			}
			$bidSpreadToPreferredSubcontractorBid->setBidSpreadPreferredSubcontractorBid($bidSpreadPreferredSubcontractorBid);

			if (isset($row['bid_spread_preferred_subcontractor_contact_id'])) {
				$bid_spread_preferred_subcontractor_contact_id = $row['bid_spread_preferred_subcontractor_contact_id'];
				$row['bs2psb_fk_preferred_sb_c__id'] = $bid_spread_preferred_subcontractor_contact_id;
				$bidSpreadPreferredSubcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $bid_spread_preferred_subcontractor_contact_id, 'bs2psb_fk_preferred_sb_c__');
				/* @var $bidSpreadPreferredSubcontractorContact Contact */
				$bidSpreadPreferredSubcontractorContact->convertPropertiesToData();
			} else {
				$bidSpreadPreferredSubcontractorContact = false;
			}
			$bidSpreadToPreferredSubcontractorBid->setBidSpreadPreferredSubcontractorContact($bidSpreadPreferredSubcontractorContact);

			return $bidSpreadToPreferredSubcontractorBid;
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
	 * @param array $arrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsToPreferredSubcontractorBidsByArrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList($database, $arrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList, Input $options=null)
	{
		if (empty($arrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList)) {
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
		// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadToPreferredSubcontractorBid = new BidSpreadToPreferredSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidSpreadToPreferredSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList as $k => $arrTmp) {
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
		if (count($arrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	bs2psb.*

FROM `bid_spreads_to_preferred_subcontractor_bids` bs2psb
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsToPreferredSubcontractorBidsByArrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList = array();
		while ($row = $db->fetch()) {
			$bidSpreadToPreferredSubcontractorBid = self::instantiateOrm($database, 'BidSpreadToPreferredSubcontractorBid', $row);
			/* @var $bidSpreadToPreferredSubcontractorBid BidSpreadToPreferredSubcontractorBid */
			$arrBidSpreadsToPreferredSubcontractorBidsByArrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList[] = $bidSpreadToPreferredSubcontractorBid;
		}

		$db->free_result();

		return $arrBidSpreadsToPreferredSubcontractorBidsByArrBidSpreadIdAndBidSpreadPreferredSubcontractorBidIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `bid_spreads_to_preferred_subcontractor_bids_fk_bs` foreign key (`bid_spread_id`) references `bid_spreads` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_spread_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsToPreferredSubcontractorBidsByBidSpreadId($database, $bid_spread_id, Input $options=null)
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
			self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId = null;
		}

		$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId = self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId;
		if (isset($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId) && !empty($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId)) {
			return $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId;
		}

		$bid_spread_id = (int) $bid_spread_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadToPreferredSubcontractorBid = new BidSpreadToPreferredSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidSpreadToPreferredSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

	bs2psb_fk_bs.`id` AS 'bs2psb_fk_bs__bid_spread_id',
	bs2psb_fk_bs.`gc_budget_line_item_id` AS 'bs2psb_fk_bs__gc_budget_line_item_id',
	bs2psb_fk_bs.`bid_spread_sequence_number` AS 'bs2psb_fk_bs__bid_spread_sequence_number',
	bs2psb_fk_bs.`bid_spread_status_id` AS 'bs2psb_fk_bs__bid_spread_status_id',
	bs2psb_fk_bs.`bid_spreadsheet_data_sha1` AS 'bs2psb_fk_bs__bid_spreadsheet_data_sha1',
	bs2psb_fk_bs.`bid_spread_submitter_gc_project_manager_contact_id` AS 'bs2psb_fk_bs__bid_spread_submitter_gc_project_manager_contact_id',
	bs2psb_fk_bs.`bid_spread_approver_gc_project_executive_contact_id` AS 'bs2psb_fk_bs__bid_spread_approver_gc_project_executive_contact_id',
	bs2psb_fk_bs.`bid_spread_bid_total` AS 'bs2psb_fk_bs__bid_spread_bid_total',
	bs2psb_fk_bs.`bid_spread_approved_value` AS 'bs2psb_fk_bs__bid_spread_approved_value',
	bs2psb_fk_bs.`unsigned_bid_spread_pdf_file_manager_file_id` AS 'bs2psb_fk_bs__unsigned_bid_spread_pdf_file_manager_file_id',
	bs2psb_fk_bs.`signed_bid_spread_pdf_file_manager_file_id` AS 'bs2psb_fk_bs__signed_bid_spread_pdf_file_manager_file_id',
	bs2psb_fk_bs.`unsigned_bid_spread_xls_file_manager_file_id` AS 'bs2psb_fk_bs__unsigned_bid_spread_xls_file_manager_file_id',
	bs2psb_fk_bs.`signed_bid_spread_xls_file_manager_file_id` AS 'bs2psb_fk_bs__signed_bid_spread_xls_file_manager_file_id',
	bs2psb_fk_bs.`modified` AS 'bs2psb_fk_bs__modified',
	bs2psb_fk_bs.`created` AS 'bs2psb_fk_bs__created',
	bs2psb_fk_bs.`display_linked_cost_codes_flag` AS 'bs2psb_fk_bs__display_linked_cost_codes_flag',
	bs2psb_fk_bs.`sort_order` AS 'bs2psb_fk_bs__sort_order',

	bs2psb_fk_preferred_sb.`id` AS 'bs2psb_fk_preferred_sb__subcontractor_bid_id',
	bs2psb_fk_preferred_sb.`gc_budget_line_item_id` AS 'bs2psb_fk_preferred_sb__gc_budget_line_item_id',
	bs2psb_fk_preferred_sb.`subcontractor_contact_id` AS 'bs2psb_fk_preferred_sb__subcontractor_contact_id',
	bs2psb_fk_preferred_sb.`subcontractor_bid_status_id` AS 'bs2psb_fk_preferred_sb__subcontractor_bid_status_id',
	bs2psb_fk_preferred_sb.`sort_order` AS 'bs2psb_fk_preferred_sb__sort_order',

	bs2psb_fk_preferred_sb_c.`id` AS 'bs2psb_fk_preferred_sb_c__contact_id',
	bs2psb_fk_preferred_sb_c.`user_company_id` AS 'bs2psb_fk_preferred_sb_c__user_company_id',
	bs2psb_fk_preferred_sb_c.`user_id` AS 'bs2psb_fk_preferred_sb_c__user_id',
	bs2psb_fk_preferred_sb_c.`contact_company_id` AS 'bs2psb_fk_preferred_sb_c__contact_company_id',
	bs2psb_fk_preferred_sb_c.`email` AS 'bs2psb_fk_preferred_sb_c__email',
	bs2psb_fk_preferred_sb_c.`name_prefix` AS 'bs2psb_fk_preferred_sb_c__name_prefix',
	bs2psb_fk_preferred_sb_c.`first_name` AS 'bs2psb_fk_preferred_sb_c__first_name',
	bs2psb_fk_preferred_sb_c.`additional_name` AS 'bs2psb_fk_preferred_sb_c__additional_name',
	bs2psb_fk_preferred_sb_c.`middle_name` AS 'bs2psb_fk_preferred_sb_c__middle_name',
	bs2psb_fk_preferred_sb_c.`last_name` AS 'bs2psb_fk_preferred_sb_c__last_name',
	bs2psb_fk_preferred_sb_c.`name_suffix` AS 'bs2psb_fk_preferred_sb_c__name_suffix',
	bs2psb_fk_preferred_sb_c.`title` AS 'bs2psb_fk_preferred_sb_c__title',
	bs2psb_fk_preferred_sb_c.`vendor_flag` AS 'bs2psb_fk_preferred_sb_c__vendor_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	bs2psb.*

FROM `bid_spreads_to_preferred_subcontractor_bids` bs2psb
	INNER JOIN `bid_spreads` bs2psb_fk_bs ON bs2psb.`bid_spread_id` = bs2psb_fk_bs.`id`
	INNER JOIN `subcontractor_bids` bs2psb_fk_preferred_sb ON bs2psb.`bid_spread_preferred_subcontractor_bid_id` = bs2psb_fk_preferred_sb.`id`
	INNER JOIN `contacts` bs2psb_fk_preferred_sb_c ON bs2psb.`bid_spread_preferred_subcontractor_contact_id` = bs2psb_fk_preferred_sb_c.`id`

	INNER JOIN `contact_companies` c_fk_cc ON bs2psb_fk_preferred_sb_c.`contact_company_id` = c_fk_cc.`id`
WHERE bs2psb.`bid_spread_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$arrValues = array($bid_spread_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId = array();
		while ($row = $db->fetch()) {
			$bidSpreadToPreferredSubcontractorBid = self::instantiateOrm($database, 'BidSpreadToPreferredSubcontractorBid', $row);
			/* @var $bidSpreadToPreferredSubcontractorBid BidSpreadToPreferredSubcontractorBid */
			$bidSpreadToPreferredSubcontractorBid->convertPropertiesToData();

			if (isset($row['bid_spread_id'])) {
				$bid_spread_id = $row['bid_spread_id'];
				$row['bs2psb_fk_bs__id'] = $bid_spread_id;
				$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id, 'bs2psb_fk_bs__');
				/* @var $bidSpread BidSpread */
				$bidSpread->convertPropertiesToData();
			} else {
				$bidSpread = false;
			}
			$bidSpreadToPreferredSubcontractorBid->setBidSpread($bidSpread);

			if (isset($row['bid_spread_preferred_subcontractor_bid_id'])) {
				$bid_spread_preferred_subcontractor_bid_id = $row['bid_spread_preferred_subcontractor_bid_id'];
				$row['bs2psb_fk_preferred_sb__id'] = $bid_spread_preferred_subcontractor_bid_id;
				$bidSpreadPreferredSubcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $bid_spread_preferred_subcontractor_bid_id, 'bs2psb_fk_preferred_sb__');
				/* @var $bidSpreadPreferredSubcontractorBid SubcontractorBid */
				$bidSpreadPreferredSubcontractorBid->convertPropertiesToData();
			} else {
				$bidSpreadPreferredSubcontractorBid = false;
			}
			$bidSpreadToPreferredSubcontractorBid->setBidSpreadPreferredSubcontractorBid($bidSpreadPreferredSubcontractorBid);

			if (isset($row['bid_spread_preferred_subcontractor_contact_id'])) {
				$bid_spread_preferred_subcontractor_contact_id = $row['bid_spread_preferred_subcontractor_contact_id'];
				$row['bs2psb_fk_preferred_sb_c__id'] = $bid_spread_preferred_subcontractor_contact_id;
				$bidSpreadPreferredSubcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $bid_spread_preferred_subcontractor_contact_id, 'bs2psb_fk_preferred_sb_c__');
				/* @var $bidSpreadPreferredSubcontractorContact Contact */
				$bidSpreadPreferredSubcontractorContact->convertPropertiesToData();
			} else {
				$bidSpreadPreferredSubcontractorContact = false;
			}
			$bidSpreadToPreferredSubcontractorBid->setBidSpreadPreferredSubcontractorContact($bidSpreadPreferredSubcontractorContact);

			if (isset($row['c_fk_cc__contact_company_id'])) {
				$contact_company_id = $row['c_fk_cc__contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$bidSpreadPreferredSubcontractorContact->setContactCompany($contactCompany);

			$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId[] = $bidSpreadToPreferredSubcontractorBid;
		}

		$db->free_result();

		self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId = $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId;

		return $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadId;
	}

	/**
	 * Load by constraint `bid_spreads_to_preferred_subcontractor_bids_fk_preferred_sb` foreign key (`bid_spread_preferred_subcontractor_bid_id`) references `subcontractor_bids` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_spread_preferred_subcontractor_bid_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId($database, $bid_spread_preferred_subcontractor_bid_id, Input $options=null)
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
			self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId = null;
		}

		$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId = self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId;
		if (isset($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId) && !empty($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId)) {
			return $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId;
		}

		$bid_spread_preferred_subcontractor_bid_id = (int) $bid_spread_preferred_subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadToPreferredSubcontractorBid = new BidSpreadToPreferredSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidSpreadToPreferredSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs2psb.*

FROM `bid_spreads_to_preferred_subcontractor_bids` bs2psb
WHERE bs2psb.`bid_spread_preferred_subcontractor_bid_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$arrValues = array($bid_spread_preferred_subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId = array();
		while ($row = $db->fetch()) {
			$bidSpreadToPreferredSubcontractorBid = self::instantiateOrm($database, 'BidSpreadToPreferredSubcontractorBid', $row);
			/* @var $bidSpreadToPreferredSubcontractorBid BidSpreadToPreferredSubcontractorBid */
			$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId[] = $bidSpreadToPreferredSubcontractorBid;
		}

		$db->free_result();

		self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId = $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId;

		return $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorBidId;
	}

	/**
	 * Load by constraint `bid_spreads_to_preferred_subcontractor_bids_fk_preferred_sb_c` foreign key (`bid_spread_preferred_subcontractor_contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_spread_preferred_subcontractor_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId($database, $bid_spread_preferred_subcontractor_contact_id, Input $options=null)
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
			self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId = null;
		}

		$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId = self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId;
		if (isset($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId) && !empty($arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId)) {
			return $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId;
		}

		$bid_spread_preferred_subcontractor_contact_id = (int) $bid_spread_preferred_subcontractor_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadToPreferredSubcontractorBid = new BidSpreadToPreferredSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidSpreadToPreferredSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs2psb.*

FROM `bid_spreads_to_preferred_subcontractor_bids` bs2psb
WHERE bs2psb.`bid_spread_preferred_subcontractor_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$arrValues = array($bid_spread_preferred_subcontractor_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId = array();
		while ($row = $db->fetch()) {
			$bidSpreadToPreferredSubcontractorBid = self::instantiateOrm($database, 'BidSpreadToPreferredSubcontractorBid', $row);
			/* @var $bidSpreadToPreferredSubcontractorBid BidSpreadToPreferredSubcontractorBid */
			$arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId[] = $bidSpreadToPreferredSubcontractorBid;
		}

		$db->free_result();

		self::$_arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId = $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId;

		return $arrBidSpreadsToPreferredSubcontractorBidsByBidSpreadPreferredSubcontractorContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all bid_spreads_to_preferred_subcontractor_bids records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllBidSpreadsToPreferredSubcontractorBids($database, Input $options=null)
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
			self::$_arrAllBidSpreadsToPreferredSubcontractorBids = null;
		}

		$arrAllBidSpreadsToPreferredSubcontractorBids = self::$_arrAllBidSpreadsToPreferredSubcontractorBids;
		if (isset($arrAllBidSpreadsToPreferredSubcontractorBids) && !empty($arrAllBidSpreadsToPreferredSubcontractorBids)) {
			return $arrAllBidSpreadsToPreferredSubcontractorBids;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadToPreferredSubcontractorBid = new BidSpreadToPreferredSubcontractorBid($database);
			$sqlOrderByColumns = $tmpBidSpreadToPreferredSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs2psb.*

FROM `bid_spreads_to_preferred_subcontractor_bids` bs2psb{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `bid_spread_id` ASC, `bid_spread_preferred_subcontractor_bid_id` ASC, `bid_spread_preferred_subcontractor_contact_id` ASC, `preferred_subcontractor_bid_total` ASC, `preferred_subcontractor_approved_bid_total` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllBidSpreadsToPreferredSubcontractorBids = array();
		while ($row = $db->fetch()) {
			$bidSpreadToPreferredSubcontractorBid = self::instantiateOrm($database, 'BidSpreadToPreferredSubcontractorBid', $row);
			/* @var $bidSpreadToPreferredSubcontractorBid BidSpreadToPreferredSubcontractorBid */
			$arrAllBidSpreadsToPreferredSubcontractorBids[] = $bidSpreadToPreferredSubcontractorBid;
		}

		$db->free_result();

		self::$_arrAllBidSpreadsToPreferredSubcontractorBids = $arrAllBidSpreadsToPreferredSubcontractorBids;

		return $arrAllBidSpreadsToPreferredSubcontractorBids;
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
INTO `bid_spreads_to_preferred_subcontractor_bids`
(`bid_spread_id`, `bid_spread_preferred_subcontractor_bid_id`, `bid_spread_preferred_subcontractor_contact_id`, `preferred_subcontractor_bid_total`, `preferred_subcontractor_approved_bid_total`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `bid_spread_preferred_subcontractor_contact_id` = ?, `preferred_subcontractor_bid_total` = ?, `preferred_subcontractor_approved_bid_total` = ?
";
		$arrValues = array($this->bid_spread_id, $this->bid_spread_preferred_subcontractor_bid_id, $this->bid_spread_preferred_subcontractor_contact_id, $this->preferred_subcontractor_bid_total, $this->preferred_subcontractor_approved_bid_total, $this->bid_spread_preferred_subcontractor_contact_id, $this->preferred_subcontractor_bid_total, $this->preferred_subcontractor_approved_bid_total);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$bid_spread_to_preferred_subcontractor_bid_id = $db->insertId;
		$db->free_result();

		return $bid_spread_to_preferred_subcontractor_bid_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * SubcontractorBid.
 *
 * @category   Framework
 * @package    SubcontractorBid
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractorBid extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractorBid';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontractor_bids';

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
	 * unique index `unique_subcontractor_bid` (`gc_budget_line_item_id`,`subcontractor_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontractor_bid' => array(
			'gc_budget_line_item_id' => 'int',
			'subcontractor_contact_id' => 'int'
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
		'id' => 'subcontractor_bid_id',

		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'subcontractor_contact_id' => 'subcontractor_contact_id',

		'subcontractor_bid_status_id' => 'subcontractor_bid_status_id',

		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontractor_bid_id;

	public $gc_budget_line_item_id;
	public $subcontractor_contact_id;

	public $subcontractor_bid_status_id;

	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;
	public $division_number;
	public $cost_code;
	public $cost_code_description;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractorBidsByGcBudgetLineItemId;
	protected static $_arrSubcontractorBidsBySubcontractorContactId;
	protected static $_arrSubcontractorBidsBySubcontractorBidStatusId;
	protected static $_arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId;
	protected static $_arrSubcontractorBidsByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractorBids;

	protected static $_arrPreferredSubcontractorBids;

	// Foreign Key Objects
	private $_gcBudgetLineItem;
	private $_subcontractorContact;
	private $_subcontractorBidStatus;

	// These could exist only in their parent class
	private $_subcontractorContactCompany;
	private $_costCodeDivision;
	private $_costCode;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontractor_bids')
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

	public function getSubcontractorContact()
	{
		if (isset($this->_subcontractorContact)) {
			return $this->_subcontractorContact;
		} else {
			return null;
		}
	}

	public function setSubcontractorContact($subcontractorContact)
	{
		$this->_subcontractorContact = $subcontractorContact;
	}

	public function getSubcontractorBidStatus()
	{
		if (isset($this->_subcontractorBidStatus)) {
			return $this->_subcontractorBidStatus;
		} else {
			return null;
		}
	}

	public function setSubcontractorBidStatus($subcontractorBidStatus)
	{
		$this->_subcontractorBidStatus = $subcontractorBidStatus;
	}

	public function getSubcontractorContactCompany()
	{
		if (isset($this->_subcontractorContactCompany)) {
			return $this->_subcontractorContactCompany;
		} else {
			return null;
		}
	}

	public function setSubcontractorContactCompany($subcontractorContactCompany)
	{
		$this->_subcontractorContactCompany = $subcontractorContactCompany;
	}

	public function getCostCodeDivision()
	{
		if (isset($this->_costCodeDivision)) {
			return $this->_costCodeDivision;
		} else {
			return null;
		}
	}

	public function setCostCodeDivision($costCodeDivision)
	{
		$this->_costCodeDivision = $costCodeDivision;
	}

	public function getCostCode()
	{
		if (isset($this->_costCode)) {
			return $this->_costCode;
		} else {
			return null;
		}
	}

	public function setCostCode($costCode)
	{
		$this->_costCode = $costCode;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractorBidsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrSubcontractorBidsByGcBudgetLineItemId)) {
			return self::$_arrSubcontractorBidsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidsByGcBudgetLineItemId($arrSubcontractorBidsByGcBudgetLineItemId)
	{
		self::$_arrSubcontractorBidsByGcBudgetLineItemId = $arrSubcontractorBidsByGcBudgetLineItemId;
	}

	public static function getArrSubcontractorBidsBySubcontractorContactId()
	{
		if (isset(self::$_arrSubcontractorBidsBySubcontractorContactId)) {
			return self::$_arrSubcontractorBidsBySubcontractorContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidsBySubcontractorContactId($arrSubcontractorBidsBySubcontractorContactId)
	{
		self::$_arrSubcontractorBidsBySubcontractorContactId = $arrSubcontractorBidsBySubcontractorContactId;
	}

	public static function getArrSubcontractorBidsBySubcontractorBidStatusId()
	{
		if (isset(self::$_arrSubcontractorBidsBySubcontractorBidStatusId)) {
			return self::$_arrSubcontractorBidsBySubcontractorBidStatusId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidsBySubcontractorBidStatusId($arrSubcontractorBidsBySubcontractorBidStatusId)
	{
		self::$_arrSubcontractorBidsBySubcontractorBidStatusId = $arrSubcontractorBidsBySubcontractorBidStatusId;
	}

	public static function getArrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId()
	{
		if (isset(self::$_arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId)) {
			return self::$_arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId($arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId)
	{
		self::$_arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId = $arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId;
	}

	public static function getArrSubcontractorBidsByProjectId()
	{
		if (isset(self::$_arrSubcontractorBidsByProjectId)) {
			return self::$_arrSubcontractorBidsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidsByProjectId($arrSubcontractorBidsByProjectId)
	{
		self::$_arrSubcontractorBidsByProjectId = $arrSubcontractorBidsByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractorBids()
	{
		if (isset(self::$_arrAllSubcontractorBids)) {
			return self::$_arrAllSubcontractorBids;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractorBids($arrAllSubcontractorBids)
	{
		self::$_arrAllSubcontractorBids = $arrAllSubcontractorBids;
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
	 * @param int $subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontractor_bid_id,$table='subcontractor_bids', $module='SubcontractorBid')
	{
		$subcontractorBid = parent::findById($database, $subcontractor_bid_id,$table, $module);

		return $subcontractorBid;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractorBidByIdExtended($database, $subcontractor_bid_id)
	{
		$subcontractor_bid_id = (int) $subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sb_fk_gbli.`id` AS 'sb_fk_gbli__gc_budget_line_item_id',
	sb_fk_gbli.`user_company_id` AS 'sb_fk_gbli__user_company_id',
	sb_fk_gbli.`project_id` AS 'sb_fk_gbli__project_id',
	sb_fk_gbli.`cost_code_id` AS 'sb_fk_gbli__cost_code_id',
	sb_fk_gbli.`modified` AS 'sb_fk_gbli__modified',
	sb_fk_gbli.`prime_contract_scheduled_value` AS 'sb_fk_gbli__prime_contract_scheduled_value',
	sb_fk_gbli.`forecasted_expenses` AS 'sb_fk_gbli__forecasted_expenses',
	sb_fk_gbli.`created` AS 'sb_fk_gbli__created',
	sb_fk_gbli.`sort_order` AS 'sb_fk_gbli__sort_order',
	sb_fk_gbli.`disabled_flag` AS 'sb_fk_gbli__disabled_flag',

	sb_fk_subcontractor_c.`id` AS 'sb_fk_subcontractor_c__contact_id',
	sb_fk_subcontractor_c.`user_company_id` AS 'sb_fk_subcontractor_c__user_company_id',
	sb_fk_subcontractor_c.`user_id` AS 'sb_fk_subcontractor_c__user_id',
	sb_fk_subcontractor_c.`contact_company_id` AS 'sb_fk_subcontractor_c__contact_company_id',
	sb_fk_subcontractor_c.`email` AS 'sb_fk_subcontractor_c__email',
	sb_fk_subcontractor_c.`name_prefix` AS 'sb_fk_subcontractor_c__name_prefix',
	sb_fk_subcontractor_c.`first_name` AS 'sb_fk_subcontractor_c__first_name',
	sb_fk_subcontractor_c.`additional_name` AS 'sb_fk_subcontractor_c__additional_name',
	sb_fk_subcontractor_c.`middle_name` AS 'sb_fk_subcontractor_c__middle_name',
	sb_fk_subcontractor_c.`last_name` AS 'sb_fk_subcontractor_c__last_name',
	sb_fk_subcontractor_c.`name_suffix` AS 'sb_fk_subcontractor_c__name_suffix',
	sb_fk_subcontractor_c.`title` AS 'sb_fk_subcontractor_c__title',
	sb_fk_subcontractor_c.`vendor_flag` AS 'sb_fk_subcontractor_c__vendor_flag',

	sb_fk_sbs.`id` AS 'sb_fk_sbs__subcontractor_bid_status_id',
	sb_fk_sbs.`subcontractor_bid_status` AS 'sb_fk_sbs__subcontractor_bid_status',
	sb_fk_sbs.`sort_order` AS 'sb_fk_sbs__sort_order',

	sb_fk_subcontractor_c__fk_cc.`id` AS 'sb_fk_subcontractor_c__fk_cc__contact_company_id',
	sb_fk_subcontractor_c__fk_cc.`user_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__user_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`contact_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__contact_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`company` AS 'sb_fk_subcontractor_c__fk_cc__company',
	sb_fk_subcontractor_c__fk_cc.`primary_phone_number` AS 'sb_fk_subcontractor_c__fk_cc__primary_phone_number',
	sb_fk_subcontractor_c__fk_cc.`employer_identification_number` AS 'sb_fk_subcontractor_c__fk_cc__employer_identification_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number_expiration_date` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number_expiration_date',
	sb_fk_subcontractor_c__fk_cc.`vendor_flag` AS 'sb_fk_subcontractor_c__fk_cc__vendor_flag',

	sb.*

FROM `subcontractor_bids` sb
	INNER JOIN `gc_budget_line_items` sb_fk_gbli ON sb.`gc_budget_line_item_id` = sb_fk_gbli.`id`
	INNER JOIN `contacts` sb_fk_subcontractor_c ON sb.`subcontractor_contact_id` = sb_fk_subcontractor_c.`id`
	INNER JOIN `subcontractor_bid_statuses` sb_fk_sbs ON sb.`subcontractor_bid_status_id` = sb_fk_sbs.`id`

	INNER JOIN `contact_companies` sb_fk_subcontractor_c__fk_cc ON sb_fk_subcontractor_c.`contact_company_id` = sb_fk_subcontractor_c__fk_cc.`id`
WHERE sb.`id` = ?
";
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractorBid->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sb_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sb_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontractorBid->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_contact_id'])) {
				$subcontractor_contact_id = $row['subcontractor_contact_id'];
				$row['sb_fk_subcontractor_c__id'] = $subcontractor_contact_id;
				$subcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontractor_contact_id, 'sb_fk_subcontractor_c__');
				/* @var $subcontractorContact Contact */
				$subcontractorContact->convertPropertiesToData();
			} else {
				$subcontractorContact = false;
			}
			$subcontractorBid->setSubcontractorContact($subcontractorContact);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sb_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sb_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBid->setSubcontractorBidStatus($subcontractorBidStatus);

			if (isset($row['sb_fk_subcontractor_c__fk_cc__contact_company_id'])) {
				$subcontractor_contact_company_id = $row['sb_fk_subcontractor_c__fk_cc__contact_company_id'];
				$row['sb_fk_subcontractor_c__fk_cc__id'] = $subcontractor_contact_company_id;
				$subcontractorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $subcontractor_contact_company_id, 'sb_fk_subcontractor_c__fk_cc__');
				/* @var $subcontractorContactCompany ContactCompany */
				$subcontractorContactCompany->convertPropertiesToData();
			} else {
				$subcontractorContactCompany = false;
			}
			if ($subcontractorContact) {
				$subcontractorContact->setContactCompany($subcontractorContactCompany);
			}
			$subcontractorBid->setSubcontractorContactCompany($subcontractorContactCompany);

			return $subcontractorBid;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_subcontractor_bid` (`gc_budget_line_item_id`,`subcontractor_contact_id`).
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $subcontractor_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByGcBudgetLineItemIdAndSubcontractorContactId($database, $gc_budget_line_item_id, $subcontractor_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sb.*

FROM `subcontractor_bids` sb
WHERE sb.`gc_budget_line_item_id` = ?
AND sb.`subcontractor_contact_id` = ?
";
		$arrValues = array($gc_budget_line_item_id, $subcontractor_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			return $subcontractorBid;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractorBidIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidsByArrSubcontractorBidIds($database, $arrSubcontractorBidIds, Input $options=null)
	{
		if (empty($arrSubcontractorBidIds)) {
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
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractorBidIds as $k => $subcontractor_bid_id) {
			$subcontractor_bid_id = (int) $subcontractor_bid_id;
			$arrSubcontractorBidIds[$k] = $db->escape($subcontractor_bid_id);
		}
		$csvSubcontractorBidIds = join(',', $arrSubcontractorBidIds);

		$query =
"
SELECT

	sb_fk_gbli.`id` AS 'sb_fk_gbli__gc_budget_line_item_id',
	sb_fk_gbli.`user_company_id` AS 'sb_fk_gbli__user_company_id',
	sb_fk_gbli.`project_id` AS 'sb_fk_gbli__project_id',
	sb_fk_gbli.`cost_code_id` AS 'sb_fk_gbli__cost_code_id',
	sb_fk_gbli.`modified` AS 'sb_fk_gbli__modified',
	sb_fk_gbli.`prime_contract_scheduled_value` AS 'sb_fk_gbli__prime_contract_scheduled_value',
	sb_fk_gbli.`forecasted_expenses` AS 'sb_fk_gbli__forecasted_expenses',
	sb_fk_gbli.`created` AS 'sb_fk_gbli__created',
	sb_fk_gbli.`sort_order` AS 'sb_fk_gbli__sort_order',
	sb_fk_gbli.`disabled_flag` AS 'sb_fk_gbli__disabled_flag',

	sb_fk_subcontractor_c.`id` AS 'sb_fk_subcontractor_c__contact_id',
	sb_fk_subcontractor_c.`user_company_id` AS 'sb_fk_subcontractor_c__user_company_id',
	sb_fk_subcontractor_c.`user_id` AS 'sb_fk_subcontractor_c__user_id',
	sb_fk_subcontractor_c.`contact_company_id` AS 'sb_fk_subcontractor_c__contact_company_id',
	sb_fk_subcontractor_c.`email` AS 'sb_fk_subcontractor_c__email',
	sb_fk_subcontractor_c.`name_prefix` AS 'sb_fk_subcontractor_c__name_prefix',
	sb_fk_subcontractor_c.`first_name` AS 'sb_fk_subcontractor_c__first_name',
	sb_fk_subcontractor_c.`additional_name` AS 'sb_fk_subcontractor_c__additional_name',
	sb_fk_subcontractor_c.`middle_name` AS 'sb_fk_subcontractor_c__middle_name',
	sb_fk_subcontractor_c.`last_name` AS 'sb_fk_subcontractor_c__last_name',
	sb_fk_subcontractor_c.`name_suffix` AS 'sb_fk_subcontractor_c__name_suffix',
	sb_fk_subcontractor_c.`title` AS 'sb_fk_subcontractor_c__title',
	sb_fk_subcontractor_c.`vendor_flag` AS 'sb_fk_subcontractor_c__vendor_flag',

	sb_fk_sbs.`id` AS 'sb_fk_sbs__subcontractor_bid_status_id',
	sb_fk_sbs.`subcontractor_bid_status` AS 'sb_fk_sbs__subcontractor_bid_status',
	sb_fk_sbs.`sort_order` AS 'sb_fk_sbs__sort_order',

	sb_fk_subcontractor_c__fk_cc.`id` AS 'sb_fk_subcontractor_c__fk_cc__contact_company_id',
	sb_fk_subcontractor_c__fk_cc.`user_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__user_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`contact_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__contact_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`company` AS 'sb_fk_subcontractor_c__fk_cc__company',
	sb_fk_subcontractor_c__fk_cc.`primary_phone_number` AS 'sb_fk_subcontractor_c__fk_cc__primary_phone_number',
	sb_fk_subcontractor_c__fk_cc.`employer_identification_number` AS 'sb_fk_subcontractor_c__fk_cc__employer_identification_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number_expiration_date` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number_expiration_date',
	sb_fk_subcontractor_c__fk_cc.`vendor_flag` AS 'sb_fk_subcontractor_c__fk_cc__vendor_flag',

	sb_fk_gbli__fk_codes.`id` AS 'sb_fk_gbli__fk_codes__cost_code_id',
	sb_fk_gbli__fk_codes.`cost_code_division_id` AS 'sb_fk_gbli__fk_codes__cost_code_division_id',
	sb_fk_gbli__fk_codes.`cost_code` AS 'sb_fk_gbli__fk_codes__cost_code',
	sb_fk_gbli__fk_codes.`cost_code_description` AS 'sb_fk_gbli__fk_codes__cost_code_description',
	sb_fk_gbli__fk_codes.`cost_code_description_abbreviation` AS 'sb_fk_gbli__fk_codes__cost_code_description_abbreviation',
	sb_fk_gbli__fk_codes.`sort_order` AS 'sb_fk_gbli__fk_codes__sort_order',
	sb_fk_gbli__fk_codes.`disabled_flag` AS 'sb_fk_gbli__fk_codes__disabled_flag',

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	sb.*

FROM `subcontractor_bids` sb
	INNER JOIN `gc_budget_line_items` sb_fk_gbli ON sb.`gc_budget_line_item_id` = sb_fk_gbli.`id`
	INNER JOIN `contacts` sb_fk_subcontractor_c ON sb.`subcontractor_contact_id` = sb_fk_subcontractor_c.`id`
	INNER JOIN `subcontractor_bid_statuses` sb_fk_sbs ON sb.`subcontractor_bid_status_id` = sb_fk_sbs.`id`

	INNER JOIN `contact_companies` sb_fk_subcontractor_c__fk_cc ON sb_fk_subcontractor_c.`contact_company_id` = sb_fk_subcontractor_c__fk_cc.`id`
	INNER JOIN `cost_codes` sb_fk_gbli__fk_codes ON sb_fk_gbli.`cost_code_id` = sb_fk_gbli__fk_codes.`id`
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON sb_fk_gbli__fk_codes.`cost_code_division_id` = codes_fk_ccd.`id`
WHERE sb.`id` IN ($csvSubcontractorBidIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidsByCsvSubcontractorBidIds = array();
		while ($row = $db->fetch()) {
			// Capture this for below return value (associative array)
			$subcontractor_contact_id = $row['subcontractor_contact_id'];

			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractorBid->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sb_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sb_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontractorBid->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_contact_id'])) {
				$subcontractor_contact_id = $row['subcontractor_contact_id'];
				$row['sb_fk_subcontractor_c__id'] = $subcontractor_contact_id;
				$subcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontractor_contact_id, 'sb_fk_subcontractor_c__');
				/* @var $subcontractorContact Contact */
				$subcontractorContact->convertPropertiesToData();
			} else {
				$subcontractorContact = false;
			}
			$subcontractorBid->setSubcontractorContact($subcontractorContact);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sb_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sb_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBid->setSubcontractorBidStatus($subcontractorBidStatus);

			if (isset($row['sb_fk_subcontractor_c__fk_cc__contact_company_id'])) {
				$subcontractor_contact_company_id = $row['sb_fk_subcontractor_c__fk_cc__contact_company_id'];
				$row['sb_fk_subcontractor_c__fk_cc__id'] = $subcontractor_contact_company_id;
				$subcontractorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $subcontractor_contact_company_id, 'sb_fk_subcontractor_c__fk_cc__');
				/* @var $subcontractorContactCompany ContactCompany */
				$subcontractorContactCompany->convertPropertiesToData();
			} else {
				$subcontractorContactCompany = false;
			}
			if ($subcontractorContact) {
				$subcontractorContact->setContactCompany($subcontractorContactCompany);
			}

			if (isset($row['sb_fk_gbli__fk_codes__cost_code_id'])) {
				$cost_code_id = $row['sb_fk_gbli__fk_codes__cost_code_id'];
				$row['sb_fk_gbli__fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'sb_fk_gbli__fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			if ($gcBudgetLineItem) {
				$gcBudgetLineItem->setCostCode($costCode);
			}

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['codes_fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			if ($costCode) {
				$costCode->setCostCodeDivision($costCodeDivision);
			}

			$arrSubcontractorBidsByCsvSubcontractorBidIds[$subcontractor_bid_id] = $subcontractorBid;
		}

		$db->free_result();

		return $arrSubcontractorBidsByCsvSubcontractorBidIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontractor_bids_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidsByGcBudgetLineItemId($database, $gc_budget_line_item_id,$filter='N', Input $options=null)
	{
		$forceLoadFlag = false;
		$arrSubcontractorBidStatusIdIn = null;
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
			self::$_arrSubcontractorBidsByGcBudgetLineItemId = null;
		}

		$arrSubcontractorBidsByGcBudgetLineItemId = self::$_arrSubcontractorBidsByGcBudgetLineItemId;
		if (isset($arrSubcontractorBidsByGcBudgetLineItemId) && !empty($arrSubcontractorBidsByGcBudgetLineItemId)) {
			return $arrSubcontractorBidsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		if($filter=='Y')
		{
			$sqlOrderBy = "\nORDER BY sb_fk_subcontractor_c__fk_cc.`company` Asc,sb.`sort_order` ASC, sb_fk_sbs.`sort_order` ASC";
		}
		else
		{
			$sqlOrderBy = "\nORDER BY sb.`sort_order` ASC, sb_fk_sbs.`sort_order` ASC";
		}
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
			$sqlFilter = "\nAND sb.`subcontractor_bid_status_id` IN ($in)";
		} else {
			$sqlFilter = '';
		}

		$query =
"
SELECT

	sb_fk_gbli.`id` AS 'sb_fk_gbli__gc_budget_line_item_id',
	sb_fk_gbli.`user_company_id` AS 'sb_fk_gbli__user_company_id',
	sb_fk_gbli.`project_id` AS 'sb_fk_gbli__project_id',
	sb_fk_gbli.`cost_code_id` AS 'sb_fk_gbli__cost_code_id',
	sb_fk_gbli.`modified` AS 'sb_fk_gbli__modified',
	sb_fk_gbli.`prime_contract_scheduled_value` AS 'sb_fk_gbli__prime_contract_scheduled_value',
	sb_fk_gbli.`forecasted_expenses` AS 'sb_fk_gbli__forecasted_expenses',
	sb_fk_gbli.`created` AS 'sb_fk_gbli__created',
	sb_fk_gbli.`sort_order` AS 'sb_fk_gbli__sort_order',
	sb_fk_gbli.`disabled_flag` AS 'sb_fk_gbli__disabled_flag',

	sb_fk_subcontractor_c.`id` AS 'sb_fk_subcontractor_c__contact_id',
	sb_fk_subcontractor_c.`user_company_id` AS 'sb_fk_subcontractor_c__user_company_id',
	sb_fk_subcontractor_c.`user_id` AS 'sb_fk_subcontractor_c__user_id',
	sb_fk_subcontractor_c.`contact_company_id` AS 'sb_fk_subcontractor_c__contact_company_id',
	sb_fk_subcontractor_c.`email` AS 'sb_fk_subcontractor_c__email',
	sb_fk_subcontractor_c.`name_prefix` AS 'sb_fk_subcontractor_c__name_prefix',
	sb_fk_subcontractor_c.`first_name` AS 'sb_fk_subcontractor_c__first_name',
	sb_fk_subcontractor_c.`additional_name` AS 'sb_fk_subcontractor_c__additional_name',
	sb_fk_subcontractor_c.`middle_name` AS 'sb_fk_subcontractor_c__middle_name',
	sb_fk_subcontractor_c.`last_name` AS 'sb_fk_subcontractor_c__last_name',
	sb_fk_subcontractor_c.`name_suffix` AS 'sb_fk_subcontractor_c__name_suffix',
	sb_fk_subcontractor_c.`title` AS 'sb_fk_subcontractor_c__title',
	sb_fk_subcontractor_c.`vendor_flag` AS 'sb_fk_subcontractor_c__vendor_flag',
	sb_fk_subcontractor_c.`is_archive` AS 'sb_fk_subcontractor_c__is_archive',

	sb_fk_sbs.`id` AS 'sb_fk_sbs__subcontractor_bid_status_id',
	sb_fk_sbs.`subcontractor_bid_status` AS 'sb_fk_sbs__subcontractor_bid_status',
	sb_fk_sbs.`sort_order` AS 'sb_fk_sbs__sort_order',

	sb_fk_subcontractor_c__fk_cc.`id` AS 'sb_fk_subcontractor_c__fk_cc__contact_company_id',
	sb_fk_subcontractor_c__fk_cc.`user_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__user_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`contact_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__contact_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`company` AS 'sb_fk_subcontractor_c__fk_cc__company',
	sb_fk_subcontractor_c__fk_cc.`primary_phone_number` AS 'sb_fk_subcontractor_c__fk_cc__primary_phone_number',
	sb_fk_subcontractor_c__fk_cc.`employer_identification_number` AS 'sb_fk_subcontractor_c__fk_cc__employer_identification_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number_expiration_date` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number_expiration_date',
	sb_fk_subcontractor_c__fk_cc.`vendor_flag` AS 'sb_fk_subcontractor_c__fk_cc__vendor_flag',

	sb.*

FROM `subcontractor_bids` sb
	INNER JOIN `gc_budget_line_items` sb_fk_gbli ON sb.`gc_budget_line_item_id` = sb_fk_gbli.`id`
	INNER JOIN `contacts` sb_fk_subcontractor_c ON sb.`subcontractor_contact_id` = sb_fk_subcontractor_c.`id`
	INNER JOIN `subcontractor_bid_statuses` sb_fk_sbs ON sb.`subcontractor_bid_status_id` = sb_fk_sbs.`id`

	INNER JOIN `contact_companies` sb_fk_subcontractor_c__fk_cc ON sb_fk_subcontractor_c.`contact_company_id` = sb_fk_subcontractor_c__fk_cc.`id`
WHERE sb.`gc_budget_line_item_id` = ?{$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractorBid->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sb_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sb_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontractorBid->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_contact_id'])) {
				$subcontractor_contact_id = $row['subcontractor_contact_id'];
				$row['sb_fk_subcontractor_c__id'] = $subcontractor_contact_id;
				$subcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontractor_contact_id, 'sb_fk_subcontractor_c__');
				/* @var $subcontractorContact Contact */
				$subcontractorContact->convertPropertiesToData();
			} else {
				$subcontractorContact = false;
			}
			$subcontractorBid->setSubcontractorContact($subcontractorContact);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sb_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sb_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBid->setSubcontractorBidStatus($subcontractorBidStatus);

			if (isset($row['sb_fk_subcontractor_c__fk_cc__contact_company_id'])) {
				$subcontractor_contact_company_id = $row['sb_fk_subcontractor_c__fk_cc__contact_company_id'];
				$row['sb_fk_subcontractor_c__fk_cc__id'] = $subcontractor_contact_company_id;
				$subcontractorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $subcontractor_contact_company_id, 'sb_fk_subcontractor_c__fk_cc__');
				/* @var $subcontractorContactCompany ContactCompany */
				$subcontractorContactCompany->convertPropertiesToData();
			} else {
				$subcontractorContactCompany = false;
			}
			if ($subcontractorContact) {
				$subcontractorContact->setContactCompany($subcontractorContactCompany);
			}
			$subcontractorBid->setSubcontractorContactCompany($subcontractorContactCompany);

			$arrSubcontractorBidsByGcBudgetLineItemId[$subcontractor_bid_id] = $subcontractorBid;
		}

		$db->free_result();

		self::$_arrSubcontractorBidsByGcBudgetLineItemId = $arrSubcontractorBidsByGcBudgetLineItemId;

		return $arrSubcontractorBidsByGcBudgetLineItemId;
	}

	/**
	 * Load by constraint `subcontractor_bids_fk_subcontractor_c` foreign key (`subcontractor_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidsBySubcontractorContactId($database, $subcontractor_contact_id, Input $options=null)
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
			self::$_arrSubcontractorBidsBySubcontractorContactId = null;
		}

		$arrSubcontractorBidsBySubcontractorContactId = self::$_arrSubcontractorBidsBySubcontractorContactId;
		if (isset($arrSubcontractorBidsBySubcontractorContactId) && !empty($arrSubcontractorBidsBySubcontractorContactId)) {
			return $arrSubcontractorBidsBySubcontractorContactId;
		}

		$subcontractor_contact_id = (int) $subcontractor_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sb.*

FROM `subcontractor_bids` sb
WHERE sb.`subcontractor_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidsBySubcontractorContactId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$arrSubcontractorBidsBySubcontractorContactId[$subcontractor_bid_id] = $subcontractorBid;
		}

		$db->free_result();

		self::$_arrSubcontractorBidsBySubcontractorContactId = $arrSubcontractorBidsBySubcontractorContactId;

		return $arrSubcontractorBidsBySubcontractorContactId;
	}

	/**
	 * Load by constraint `subcontractor_bids_fk_sbs` foreign key (`subcontractor_bid_status_id`) references `subcontractor_bid_statuses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidsBySubcontractorBidStatusId($database, $subcontractor_bid_status_id, Input $options=null)
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
			self::$_arrSubcontractorBidsBySubcontractorBidStatusId = null;
		}

		$arrSubcontractorBidsBySubcontractorBidStatusId = self::$_arrSubcontractorBidsBySubcontractorBidStatusId;
		if (isset($arrSubcontractorBidsBySubcontractorBidStatusId) && !empty($arrSubcontractorBidsBySubcontractorBidStatusId)) {
			return $arrSubcontractorBidsBySubcontractorBidStatusId;
		}

		$subcontractor_bid_status_id = (int) $subcontractor_bid_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sb.*

FROM `subcontractor_bids` sb
WHERE sb.`subcontractor_bid_status_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidsBySubcontractorBidStatusId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$arrSubcontractorBidsBySubcontractorBidStatusId[$subcontractor_bid_id] = $subcontractorBid;
		}

		$db->free_result();

		self::$_arrSubcontractorBidsBySubcontractorBidStatusId = $arrSubcontractorBidsBySubcontractorBidStatusId;

		return $arrSubcontractorBidsBySubcontractorBidStatusId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontractor_bids records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractorBids($database, Input $options=null)
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
			self::$_arrAllSubcontractorBids = null;
		}

		$arrAllSubcontractorBids = self::$_arrAllSubcontractorBids;
		if (isset($arrAllSubcontractorBids) && !empty($arrAllSubcontractorBids)) {
			return $arrAllSubcontractorBids;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sb.*

FROM `subcontractor_bids` sb{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractorBids = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$arrAllSubcontractorBids[$subcontractor_bid_id] = $subcontractorBid;
		}

		$db->free_result();

		self::$_arrAllSubcontractorBids = $arrAllSubcontractorBids;

		return $arrAllSubcontractorBids;
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
INTO `subcontractor_bids`
(`gc_budget_line_item_id`, `subcontractor_contact_id`, `subcontractor_bid_status_id`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `subcontractor_bid_status_id` = ?, `sort_order` = ?
";
		$arrValues = array($this->gc_budget_line_item_id, $this->subcontractor_contact_id, $this->subcontractor_bid_status_id, $this->sort_order, $this->subcontractor_bid_status_id, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontractor_bid_id = $db->insertId;
		$db->free_result();

		return $subcontractor_bid_id;
	}

	// Save: insert ignore

	/**
	 * Load by <`gc_budget_line_items`, `subcontractor_bid_status_id`:{12, 13}>
	 *
	 * subcontractor_bid_status_id : 12 : Preferred Subcontractor Bid
	 * subcontractor_bid_status_id : 13 : Subcontract Awarded
	 *
	 * Note: `preferred_subcontractor_bid_flag` and `awarded_subcontract_flag`
	 * have been removed for subcontractor_bid_status_id -> subcontractor_bid_statuses instead.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $subcontractor_bid_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadPreferredSubcontractorBids($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrPreferredSubcontractorBids = null;
		}

		$arrPreferredSubcontractorBids = self::$_arrPreferredSubcontractorBids;
		if (isset($arrPreferredSubcontractorBids) && !empty($arrPreferredSubcontractorBids)) {
			return $arrPreferredSubcontractorBids;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sb_fk_sbs.`sort_order` ASC, sb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sb_fk_gbli.`id` AS 'sb_fk_gbli__gc_budget_line_item_id',
	sb_fk_gbli.`user_company_id` AS 'sb_fk_gbli__user_company_id',
	sb_fk_gbli.`project_id` AS 'sb_fk_gbli__project_id',
	sb_fk_gbli.`cost_code_id` AS 'sb_fk_gbli__cost_code_id',
	sb_fk_gbli.`modified` AS 'sb_fk_gbli__modified',
	sb_fk_gbli.`prime_contract_scheduled_value` AS 'sb_fk_gbli__prime_contract_scheduled_value',
	sb_fk_gbli.`forecasted_expenses` AS 'sb_fk_gbli__forecasted_expenses',
	sb_fk_gbli.`created` AS 'sb_fk_gbli__created',
	sb_fk_gbli.`sort_order` AS 'sb_fk_gbli__sort_order',
	sb_fk_gbli.`disabled_flag` AS 'sb_fk_gbli__disabled_flag',

	sb_fk_subcontractor_c.`id` AS 'sb_fk_subcontractor_c__contact_id',
	sb_fk_subcontractor_c.`user_company_id` AS 'sb_fk_subcontractor_c__user_company_id',
	sb_fk_subcontractor_c.`user_id` AS 'sb_fk_subcontractor_c__user_id',
	sb_fk_subcontractor_c.`contact_company_id` AS 'sb_fk_subcontractor_c__contact_company_id',
	sb_fk_subcontractor_c.`email` AS 'sb_fk_subcontractor_c__email',
	sb_fk_subcontractor_c.`name_prefix` AS 'sb_fk_subcontractor_c__name_prefix',
	sb_fk_subcontractor_c.`first_name` AS 'sb_fk_subcontractor_c__first_name',
	sb_fk_subcontractor_c.`additional_name` AS 'sb_fk_subcontractor_c__additional_name',
	sb_fk_subcontractor_c.`middle_name` AS 'sb_fk_subcontractor_c__middle_name',
	sb_fk_subcontractor_c.`last_name` AS 'sb_fk_subcontractor_c__last_name',
	sb_fk_subcontractor_c.`name_suffix` AS 'sb_fk_subcontractor_c__name_suffix',
	sb_fk_subcontractor_c.`title` AS 'sb_fk_subcontractor_c__title',
	sb_fk_subcontractor_c.`vendor_flag` AS 'sb_fk_subcontractor_c__vendor_flag',

	sb_fk_sbs.`id` AS 'sb_fk_sbs__subcontractor_bid_status_id',
	sb_fk_sbs.`subcontractor_bid_status` AS 'sb_fk_sbs__subcontractor_bid_status',
	sb_fk_sbs.`sort_order` AS 'sb_fk_sbs__sort_order',

	sb_fk_subcontractor_c__fk_cc.`id` AS 'sb_fk_subcontractor_c__fk_cc__contact_company_id',
	sb_fk_subcontractor_c__fk_cc.`user_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__user_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`contact_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__contact_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`company` AS 'sb_fk_subcontractor_c__fk_cc__company',
	sb_fk_subcontractor_c__fk_cc.`primary_phone_number` AS 'sb_fk_subcontractor_c__fk_cc__primary_phone_number',
	sb_fk_subcontractor_c__fk_cc.`employer_identification_number` AS 'sb_fk_subcontractor_c__fk_cc__employer_identification_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number_expiration_date` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number_expiration_date',
	sb_fk_subcontractor_c__fk_cc.`vendor_flag` AS 'sb_fk_subcontractor_c__fk_cc__vendor_flag',

	sb.*

FROM `subcontractor_bids` sb
	INNER JOIN `gc_budget_line_items` sb_fk_gbli ON sb.`gc_budget_line_item_id` = sb_fk_gbli.`id`
	INNER JOIN `contacts` sb_fk_subcontractor_c ON sb.`subcontractor_contact_id` = sb_fk_subcontractor_c.`id`
	INNER JOIN `subcontractor_bid_statuses` sb_fk_sbs ON sb.`subcontractor_bid_status_id` = sb_fk_sbs.`id`

	INNER JOIN `contact_companies` sb_fk_subcontractor_c__fk_cc ON sb_fk_subcontractor_c.`contact_company_id` = sb_fk_subcontractor_c__fk_cc.`id`
WHERE sb.`gc_budget_line_item_id` = ?
AND sb.`subcontractor_bid_status_id` IN (12, 13){$sqlOrderBy}{$sqlLimit}
";
		// LIMIT 10
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrPreferredSubcontractorBids = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractorBid->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sb_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sb_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontractorBid->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_contact_id'])) {
				$subcontractor_contact_id = $row['subcontractor_contact_id'];
				$row['sb_fk_subcontractor_c__id'] = $subcontractor_contact_id;
				$subcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontractor_contact_id, 'sb_fk_subcontractor_c__');
				/* @var $subcontractorContact Contact */
				$subcontractorContact->convertPropertiesToData();
			} else {
				$subcontractorContact = false;
			}
			$subcontractorBid->setSubcontractorContact($subcontractorContact);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sb_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sb_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBid->setSubcontractorBidStatus($subcontractorBidStatus);

			if (isset($row['sb_fk_subcontractor_c__fk_cc__contact_company_id'])) {
				$subcontractor_contact_company_id = $row['sb_fk_subcontractor_c__fk_cc__contact_company_id'];
				$row['sb_fk_subcontractor_c__fk_cc__id'] = $subcontractor_contact_company_id;
				$subcontractorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $subcontractor_contact_company_id, 'sb_fk_subcontractor_c__fk_cc__');
				/* @var $subcontractorContactCompany ContactCompany */
				$subcontractorContactCompany->convertPropertiesToData();
			} else {
				$subcontractorContactCompany = false;
			}
			if ($subcontractorContact) {
				$subcontractorContact->setContactCompany($subcontractorContactCompany);
			}
			$subcontractorBid->setSubcontractorContactCompany($subcontractorContactCompany);

			$arrPreferredSubcontractorBids[$subcontractor_bid_id] = $subcontractorBid;
		}

		$db->free_result();

		self::$_arrPreferredSubcontractorBids = $arrPreferredSubcontractorBids;

		return $arrPreferredSubcontractorBids;
	}

	/**
	 * Load by <`gc_budget_line_items`, `subcontractor_bid_status_id`>
	 *
	 * Note: `preferred_subcontractor_bid_flag` and `awarded_subcontract_flag`
	 * have been removed for subcontractor_bid_status_id -> subcontractor_bid_statuses instead.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $subcontractor_bid_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId($database, $gc_budget_line_item_id, $subcontractor_bid_status_id, Input $options=null)
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
			self::$_arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId = null;
		}

		$arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId = self::$_arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId;
		if (isset($arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId) && !empty($arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId)) {
			return $arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;
		$subcontractor_bid_status_id = (int) $subcontractor_bid_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sb_fk_sbs.`sort_order` ASC, sb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sb_fk_gbli.`id` AS 'sb_fk_gbli__gc_budget_line_item_id',
	sb_fk_gbli.`user_company_id` AS 'sb_fk_gbli__user_company_id',
	sb_fk_gbli.`project_id` AS 'sb_fk_gbli__project_id',
	sb_fk_gbli.`cost_code_id` AS 'sb_fk_gbli__cost_code_id',
	sb_fk_gbli.`modified` AS 'sb_fk_gbli__modified',
	sb_fk_gbli.`prime_contract_scheduled_value` AS 'sb_fk_gbli__prime_contract_scheduled_value',
	sb_fk_gbli.`forecasted_expenses` AS 'sb_fk_gbli__forecasted_expenses',
	sb_fk_gbli.`created` AS 'sb_fk_gbli__created',
	sb_fk_gbli.`sort_order` AS 'sb_fk_gbli__sort_order',
	sb_fk_gbli.`disabled_flag` AS 'sb_fk_gbli__disabled_flag',

	sb_fk_subcontractor_c.`id` AS 'sb_fk_subcontractor_c__contact_id',
	sb_fk_subcontractor_c.`user_company_id` AS 'sb_fk_subcontractor_c__user_company_id',
	sb_fk_subcontractor_c.`user_id` AS 'sb_fk_subcontractor_c__user_id',
	sb_fk_subcontractor_c.`contact_company_id` AS 'sb_fk_subcontractor_c__contact_company_id',
	sb_fk_subcontractor_c.`email` AS 'sb_fk_subcontractor_c__email',
	sb_fk_subcontractor_c.`name_prefix` AS 'sb_fk_subcontractor_c__name_prefix',
	sb_fk_subcontractor_c.`first_name` AS 'sb_fk_subcontractor_c__first_name',
	sb_fk_subcontractor_c.`additional_name` AS 'sb_fk_subcontractor_c__additional_name',
	sb_fk_subcontractor_c.`middle_name` AS 'sb_fk_subcontractor_c__middle_name',
	sb_fk_subcontractor_c.`last_name` AS 'sb_fk_subcontractor_c__last_name',
	sb_fk_subcontractor_c.`name_suffix` AS 'sb_fk_subcontractor_c__name_suffix',
	sb_fk_subcontractor_c.`title` AS 'sb_fk_subcontractor_c__title',
	sb_fk_subcontractor_c.`vendor_flag` AS 'sb_fk_subcontractor_c__vendor_flag',

	sb_fk_sbs.`id` AS 'sb_fk_sbs__subcontractor_bid_status_id',
	sb_fk_sbs.`subcontractor_bid_status` AS 'sb_fk_sbs__subcontractor_bid_status',
	sb_fk_sbs.`sort_order` AS 'sb_fk_sbs__sort_order',

	sb_fk_subcontractor_c__fk_cc.`id` AS 'sb_fk_subcontractor_c__fk_cc__contact_company_id',
	sb_fk_subcontractor_c__fk_cc.`user_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__user_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`contact_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__contact_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`company` AS 'sb_fk_subcontractor_c__fk_cc__company',
	sb_fk_subcontractor_c__fk_cc.`primary_phone_number` AS 'sb_fk_subcontractor_c__fk_cc__primary_phone_number',
	sb_fk_subcontractor_c__fk_cc.`employer_identification_number` AS 'sb_fk_subcontractor_c__fk_cc__employer_identification_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number_expiration_date` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number_expiration_date',
	sb_fk_subcontractor_c__fk_cc.`vendor_flag` AS 'sb_fk_subcontractor_c__fk_cc__vendor_flag',

	sb.*

FROM `subcontractor_bids` sb
	INNER JOIN `gc_budget_line_items` sb_fk_gbli ON sb.`gc_budget_line_item_id` = sb_fk_gbli.`id`
	INNER JOIN `contacts` sb_fk_subcontractor_c ON sb.`subcontractor_contact_id` = sb_fk_subcontractor_c.`id`
	INNER JOIN `subcontractor_bid_statuses` sb_fk_sbs ON sb.`subcontractor_bid_status_id` = sb_fk_sbs.`id`

	INNER JOIN `contact_companies` sb_fk_subcontractor_c__fk_cc ON sb_fk_subcontractor_c.`contact_company_id` = sb_fk_subcontractor_c__fk_cc.`id`
WHERE sb.`gc_budget_line_item_id` = ?
AND sb.`subcontractor_bid_status_id` = ?
";
		// LIMIT 10
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontractor_contact_id` ASC, `subcontractor_bid_status_id` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id, $subcontractor_bid_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractorBid->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sb_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sb_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontractorBid->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_contact_id'])) {
				$subcontractor_contact_id = $row['subcontractor_contact_id'];
				$row['sb_fk_subcontractor_c__id'] = $subcontractor_contact_id;
				$subcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontractor_contact_id, 'sb_fk_subcontractor_c__');
				/* @var $subcontractorContact Contact */
				$subcontractorContact->convertPropertiesToData();
			} else {
				$subcontractorContact = false;
			}
			$subcontractorBid->setSubcontractorContact($subcontractorContact);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sb_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sb_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBid->setSubcontractorBidStatus($subcontractorBidStatus);

			if (isset($row['sb_fk_subcontractor_c__fk_cc__contact_company_id'])) {
				$subcontractor_contact_company_id = $row['sb_fk_subcontractor_c__fk_cc__contact_company_id'];
				$row['sb_fk_subcontractor_c__fk_cc__id'] = $subcontractor_contact_company_id;
				$subcontractorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $subcontractor_contact_company_id, 'sb_fk_subcontractor_c__fk_cc__');
				/* @var $subcontractorContactCompany ContactCompany */
				$subcontractorContactCompany->convertPropertiesToData();
			} else {
				$subcontractorContactCompany = false;
			}
			if ($subcontractorContact) {
				$subcontractorContact->setContactCompany($subcontractorContactCompany);
			}
			$subcontractorBid->setSubcontractorContactCompany($subcontractorContactCompany);

			$arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId[$subcontractor_bid_id] = $subcontractorBid;
		}

		$db->free_result();

		self::$_arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId = $arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId;

		return $arrSubcontractorBidsByGcBudgetLineItemIdAndSubcontractorBidStatusId;
	}

	/**
	 * One subcontractor may perform multiple cost codes that are not bundled.
	 * One unique bid is submitted by a bidder per cost code (gc_budget_line_item_id).
	 * One unique subcontract is awarded to the bidder per cost code (gc_budget_line_item_id).
	 * The bids and subcontracts are NOT BUNDLED.
	 *
	 * Load all the bids for a given subcontractor_contact_id (for all the cost_codes that they bid against).
	 *
	 * @param string $database
	 * @param array $arrSubcontractorBidIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadTradesBidBySubcontractorGroupedBySubcontractorContactIdLoadedBySubcontractorBidIdList($database, array $arrSubcontractorBidIds, Input $options=null)
	{

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		foreach ($arrSubcontractorBidIds as $k => $tmpId) {
			$arrSubcontractorBidIds[$k] = $db->escape($tmpId);
		}
		$in = join(',', $arrSubcontractorBidIds);

		$query =
		"
SELECT

	sb_fk_gbli.`id` AS 'sb_fk_gbli__gc_budget_line_item_id',
	sb_fk_gbli.`user_company_id` AS 'sb_fk_gbli__user_company_id',
	sb_fk_gbli.`project_id` AS 'sb_fk_gbli__project_id',
	sb_fk_gbli.`cost_code_id` AS 'sb_fk_gbli__cost_code_id',
	sb_fk_gbli.`modified` AS 'sb_fk_gbli__modified',
	sb_fk_gbli.`prime_contract_scheduled_value` AS 'sb_fk_gbli__prime_contract_scheduled_value',
	sb_fk_gbli.`forecasted_expenses` AS 'sb_fk_gbli__forecasted_expenses',
	sb_fk_gbli.`created` AS 'sb_fk_gbli__created',
	sb_fk_gbli.`sort_order` AS 'sb_fk_gbli__sort_order',
	sb_fk_gbli.`disabled_flag` AS 'sb_fk_gbli__disabled_flag',

	sb_fk_subcontractor_c.`id` AS 'sb_fk_subcontractor_c__contact_id',
	sb_fk_subcontractor_c.`user_company_id` AS 'sb_fk_subcontractor_c__user_company_id',
	sb_fk_subcontractor_c.`user_id` AS 'sb_fk_subcontractor_c__user_id',
	sb_fk_subcontractor_c.`contact_company_id` AS 'sb_fk_subcontractor_c__contact_company_id',
	sb_fk_subcontractor_c.`email` AS 'sb_fk_subcontractor_c__email',
	sb_fk_subcontractor_c.`name_prefix` AS 'sb_fk_subcontractor_c__name_prefix',
	sb_fk_subcontractor_c.`first_name` AS 'sb_fk_subcontractor_c__first_name',
	sb_fk_subcontractor_c.`additional_name` AS 'sb_fk_subcontractor_c__additional_name',
	sb_fk_subcontractor_c.`middle_name` AS 'sb_fk_subcontractor_c__middle_name',
	sb_fk_subcontractor_c.`last_name` AS 'sb_fk_subcontractor_c__last_name',
	sb_fk_subcontractor_c.`name_suffix` AS 'sb_fk_subcontractor_c__name_suffix',
	sb_fk_subcontractor_c.`title` AS 'sb_fk_subcontractor_c__title',
	sb_fk_subcontractor_c.`vendor_flag` AS 'sb_fk_subcontractor_c__vendor_flag',

	sb_fk_sbs.`id` AS 'sb_fk_sbs__subcontractor_bid_status_id',
	sb_fk_sbs.`subcontractor_bid_status` AS 'sb_fk_sbs__subcontractor_bid_status',
	sb_fk_sbs.`sort_order` AS 'sb_fk_sbs__sort_order',

	sb_fk_subcontractor_c__fk_cc.`id` AS 'sb_fk_subcontractor_c__fk_cc__contact_company_id',
	sb_fk_subcontractor_c__fk_cc.`user_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__user_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`contact_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__contact_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`company` AS 'sb_fk_subcontractor_c__fk_cc__company',
	sb_fk_subcontractor_c__fk_cc.`primary_phone_number` AS 'sb_fk_subcontractor_c__fk_cc__primary_phone_number',
	sb_fk_subcontractor_c__fk_cc.`employer_identification_number` AS 'sb_fk_subcontractor_c__fk_cc__employer_identification_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number_expiration_date` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number_expiration_date',
	sb_fk_subcontractor_c__fk_cc.`vendor_flag` AS 'sb_fk_subcontractor_c__fk_cc__vendor_flag',

	sb_fk_gbli__fk_codes.`id` AS 'sb_fk_gbli__fk_codes__cost_code_id',
	sb_fk_gbli__fk_codes.`cost_code_division_id` AS 'sb_fk_gbli__fk_codes__cost_code_division_id',
	sb_fk_gbli__fk_codes.`cost_code` AS 'sb_fk_gbli__fk_codes__cost_code',
	sb_fk_gbli__fk_codes.`cost_code_description` AS 'sb_fk_gbli__fk_codes__cost_code_description',
	sb_fk_gbli__fk_codes.`cost_code_description_abbreviation` AS 'sb_fk_gbli__fk_codes__cost_code_description_abbreviation',
	sb_fk_gbli__fk_codes.`sort_order` AS 'sb_fk_gbli__fk_codes__sort_order',
	sb_fk_gbli__fk_codes.`disabled_flag` AS 'sb_fk_gbli__fk_codes__disabled_flag',

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	sb.*

FROM `subcontractor_bids` sb
	INNER JOIN `gc_budget_line_items` sb_fk_gbli ON sb.`gc_budget_line_item_id` = sb_fk_gbli.`id`
	INNER JOIN `contacts` sb_fk_subcontractor_c ON sb.`subcontractor_contact_id` = sb_fk_subcontractor_c.`id`
	INNER JOIN `subcontractor_bid_statuses` sb_fk_sbs ON sb.`subcontractor_bid_status_id` = sb_fk_sbs.`id`

	INNER JOIN `contact_companies` sb_fk_subcontractor_c__fk_cc ON sb_fk_subcontractor_c.`contact_company_id` = sb_fk_subcontractor_c__fk_cc.`id`
	INNER JOIN `cost_codes` sb_fk_gbli__fk_codes ON sb_fk_gbli.`cost_code_id` = sb_fk_gbli__fk_codes.`id`
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON sb_fk_gbli__fk_codes.`cost_code_division_id` = codes_fk_ccd.`id`
WHERE sb.`id` IN ($in)
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrTradesBidBySubcontractorGroupedBySubcontractorContactIdLoadedBySubcontractorBidIdList = array();
		while ($row = $db->fetch()) {
			// Capture this for below return value (associative array)
			$subcontractor_contact_id = $row['subcontractor_contact_id'];

			$subcontractor_bid_id = $row['id'];
			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			/* @var $subcontractorBid SubcontractorBid */
			$subcontractorBid->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sb_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sb_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontractorBid->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_contact_id'])) {
				$subcontractor_contact_id = $row['subcontractor_contact_id'];
				$row['sb_fk_subcontractor_c__id'] = $subcontractor_contact_id;
				$subcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontractor_contact_id, 'sb_fk_subcontractor_c__');
				/* @var $subcontractorContact Contact */
				$subcontractorContact->convertPropertiesToData();
			} else {
				$subcontractorContact = false;
			}
			$subcontractorBid->setSubcontractorContact($subcontractorContact);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sb_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sb_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBid->setSubcontractorBidStatus($subcontractorBidStatus);

			if (isset($row['sb_fk_subcontractor_c__fk_cc__contact_company_id'])) {
				$subcontractor_contact_company_id = $row['sb_fk_subcontractor_c__fk_cc__contact_company_id'];
				$row['sb_fk_subcontractor_c__fk_cc__id'] = $subcontractor_contact_company_id;
				$subcontractorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $subcontractor_contact_company_id, 'sb_fk_subcontractor_c__fk_cc__');
				/* @var $subcontractorContactCompany ContactCompany */
				$subcontractorContactCompany->convertPropertiesToData();
			} else {
				$subcontractorContactCompany = false;
			}
			if ($subcontractorContact) {
				$subcontractorContact->setContactCompany($subcontractorContactCompany);
			}
			$subcontractorBid->setSubcontractorContactCompany($subcontractorContactCompany);

			if (isset($row['sb_fk_gbli__fk_codes__cost_code_id'])) {
				$cost_code_id = $row['sb_fk_gbli__fk_codes__cost_code_id'];
				$row['sb_fk_gbli__fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'sb_fk_gbli__fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$gcBudgetLineItem->setCostCode($costCode);

			if (isset($row['codes_fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['codes_fk_ccd__cost_code_division_id'];
				$row['codes_fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			$arrTradesBidBySubcontractorGroupedBySubcontractorContactIdLoadedBySubcontractorBidIdList[$subcontractor_contact_id][$subcontractor_bid_id] = $subcontractorBid;
		}
		$db->free_result();

		return $arrTradesBidBySubcontractorGroupedBySubcontractorContactIdLoadedBySubcontractorBidIdList;
	}

	public function deriveBidTotal()
	{
		$database = $this->getDatabase();
		$subcontractor_bid_id = (int) $this->subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
SELECT SUM(bi2sb.item_quantity * bi2sb.unit_price) AS 'unit_total'
FROM bid_items_to_subcontractor_bids bi2sb
WHERE bi2sb.subcontractor_bid_id = ?
AND bi2sb.exclude_bid_item_flag = 'N'
";
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row['unit_total'])) {
			$total = $row['unit_total'];
			$total = money_format('%!i', $total);
		} else {
			$total = '';
		}

		return $total;
	}

	public static function loadSubcontractorBidStatusCountsByProjectId($database, $user_company_id, $project_id, $cost_code_division_id_filter=null)
	{
		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Get bid invitation status for this project ie. how many have been invited and how many are bidding
		if (isset($cost_code_division_id_filter) && !empty($cost_code_division_id_filter) && ($cost_code_division_id_filter <> -1)) {
			$queryFilter = "AND ccd.`id` = ?";
			$arrValues = array($user_company_id, $project_id, $cost_code_division_id_filter);
		} else {
			$queryFilter = '';
			$arrValues = array($user_company_id, $project_id);
		}

		$query =
		"
SELECT
	gbli.`id` AS 'gc_budget_line_item_id',
	sb.`subcontractor_bid_status_id`,
	#sbs.`subcontractor_bid_status`,
	COUNT(sb.`subcontractor_bid_status_id`) AS 'total'
FROM `gc_budget_line_items` gbli
	INNER JOIN `subcontractor_bids` sb ON  gbli.`id` = sb.`gc_budget_line_item_id`
	INNER JOIN `subcontractor_bid_statuses` sbs ON sb.`subcontractor_bid_status_id` = sbs.`id`
	INNER JOIN `cost_codes` codes ON gbli.`cost_code_id` = codes.`id`
	INNER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE gbli.`user_company_id` = ?
AND gbli.`project_id` = ?
AND sb.`subcontractor_bid_status_id` <> 1
$queryFilter
GROUP BY sb.`gc_budget_line_item_id`, sb.`subcontractor_bid_status_id`
ORDER BY sb.`gc_budget_line_item_id`, sb.`subcontractor_bid_status_id`
";
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		// The below subcontractor_bid_status_id values indicate that a sub is "Actively Bidding" or actively participating in the bidding process
		$arrActivelyBiddingStatuses = array(
			4 => 'Actively Bidding',
			5 => 'Bid Received'
		);

		//$arrAllSubcontractorBidStatuses = SubcontractorBidStatus::loadAllSubcontractorBidStatuses($database);

		$arrSubcontractorBidStatusCountsByProjectId = array();
		$last_gc_budget_line_item_id = '';
		$invited_count = 0;

		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
			$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
			//$subcontractor_bid_status = $row['subcontractor_bid_status'];
			$total = $row['total'];

			$arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id][$subcontractor_bid_status_id] = $total;

			/*
			$arrTemp = array(

			);

			if ($gc_budget_line_item_id != $last_gc_budget_line_item_id && $last_gc_budget_line_item_id != '') {
			$arrSubcontractorBidStatusCountsByProjectId[$last_gc_budget_line_item_id]['invited'] = $invited_count;
			$invited_count = 0;
			}
			$invited_count = $invited_count + $total;
			if (isset($arrActivelyBiddingStatuses[$subcontractor_bid_status_id])) {  // Status 4 = "Bidding"
			$arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id]['bidding'] = $total;
			}
			$arrSubcontractorBidStatusCountsByProjectId[$gc_budget_line_item_id][$subcontractor_bid_status_id] = $total;
			$last_gc_budget_line_item_id = $gc_budget_line_item_id;
			*/
		}

		//$arrSubcontractorBidStatusCountsByProjectId[$last_gc_budget_line_item_id]['invited'] = $invited_count;
		$db->free_result();

		return $arrSubcontractorBidStatusCountsByProjectId;
	}

	public static function loadSubcontractorBidsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrSubcontractorBidsByProjectId = null;
		}

		$arrSubcontractorBidsByProjectId = self::$_arrSubcontractorBidsByProjectId;
		if (isset($arrSubcontractorBidsByProjectId) && !empty($arrSubcontractorBidsByProjectId)) {
			return $arrSubcontractorBidsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		//$sqlOrderBy = "\nORDER BY sb.`subcontractor_bid_status_id` ASC, codes_fk_ccd.`division_number` ASC, sb_fk_gbli__fk_codes.`cost_code` ASC";
		$sqlOrderBy = "\nORDER BY sb.`subcontractor_bid_status_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		//		$potentialBidder
		//		$arrGroupedSubcontractorBidStatuses = array(
		//			1 =>
		//		);

		$query =
		"
SELECT

	sb_fk_gbli.`id` AS 'sb_fk_gbli__gc_budget_line_item_id',
	sb_fk_gbli.`user_company_id` AS 'sb_fk_gbli__user_company_id',
	sb_fk_gbli.`project_id` AS 'sb_fk_gbli__project_id',
	sb_fk_gbli.`cost_code_id` AS 'sb_fk_gbli__cost_code_id',
	sb_fk_gbli.`modified` AS 'sb_fk_gbli__modified',
	sb_fk_gbli.`prime_contract_scheduled_value` AS 'sb_fk_gbli__prime_contract_scheduled_value',
	sb_fk_gbli.`forecasted_expenses` AS 'sb_fk_gbli__forecasted_expenses',
	sb_fk_gbli.`created` AS 'sb_fk_gbli__created',
	sb_fk_gbli.`sort_order` AS 'sb_fk_gbli__sort_order',
	sb_fk_gbli.`disabled_flag` AS 'sb_fk_gbli__disabled_flag',

	sb_fk_subcontractor_c.`id` AS 'sb_fk_subcontractor_c__contact_id',
	sb_fk_subcontractor_c.`user_company_id` AS 'sb_fk_subcontractor_c__user_company_id',
	sb_fk_subcontractor_c.`user_id` AS 'sb_fk_subcontractor_c__user_id',
	sb_fk_subcontractor_c.`contact_company_id` AS 'sb_fk_subcontractor_c__contact_company_id',
	sb_fk_subcontractor_c.`email` AS 'sb_fk_subcontractor_c__email',
	sb_fk_subcontractor_c.`name_prefix` AS 'sb_fk_subcontractor_c__name_prefix',
	sb_fk_subcontractor_c.`first_name` AS 'sb_fk_subcontractor_c__first_name',
	sb_fk_subcontractor_c.`additional_name` AS 'sb_fk_subcontractor_c__additional_name',
	sb_fk_subcontractor_c.`middle_name` AS 'sb_fk_subcontractor_c__middle_name',
	sb_fk_subcontractor_c.`last_name` AS 'sb_fk_subcontractor_c__last_name',
	sb_fk_subcontractor_c.`name_suffix` AS 'sb_fk_subcontractor_c__name_suffix',
	sb_fk_subcontractor_c.`title` AS 'sb_fk_subcontractor_c__title',
	sb_fk_subcontractor_c.`vendor_flag` AS 'sb_fk_subcontractor_c__vendor_flag',

	sb_fk_sbs.`id` AS 'sb_fk_sbs__subcontractor_bid_status_id',
	sb_fk_sbs.`subcontractor_bid_status` AS 'sb_fk_sbs__subcontractor_bid_status',
	sb_fk_sbs.`sort_order` AS 'sb_fk_sbs__sort_order',

	sb_fk_subcontractor_c__fk_cc.`id` AS 'sb_fk_subcontractor_c__fk_cc__contact_company_id',
	sb_fk_subcontractor_c__fk_cc.`user_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__user_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`contact_user_company_id` AS 'sb_fk_subcontractor_c__fk_cc__contact_user_company_id',
	sb_fk_subcontractor_c__fk_cc.`company` AS 'sb_fk_subcontractor_c__fk_cc__company',
	sb_fk_subcontractor_c__fk_cc.`primary_phone_number` AS 'sb_fk_subcontractor_c__fk_cc__primary_phone_number',
	sb_fk_subcontractor_c__fk_cc.`employer_identification_number` AS 'sb_fk_subcontractor_c__fk_cc__employer_identification_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number',
	sb_fk_subcontractor_c__fk_cc.`construction_license_number_expiration_date` AS 'sb_fk_subcontractor_c__fk_cc__construction_license_number_expiration_date',
	sb_fk_subcontractor_c__fk_cc.`vendor_flag` AS 'sb_fk_subcontractor_c__fk_cc__vendor_flag',

	sb.*

FROM `subcontractor_bids` sb
	INNER JOIN `gc_budget_line_items` sb_fk_gbli ON sb.`gc_budget_line_item_id` = sb_fk_gbli.`id`
	INNER JOIN `contacts` sb_fk_subcontractor_c ON sb.`subcontractor_contact_id` = sb_fk_subcontractor_c.`id`
	INNER JOIN `subcontractor_bid_statuses` sb_fk_sbs ON sb.`subcontractor_bid_status_id` = sb_fk_sbs.`id`
	INNER JOIN `contact_companies` sb_fk_subcontractor_c__fk_cc ON sb_fk_subcontractor_c.`contact_company_id` = sb_fk_subcontractor_c__fk_cc.`id`

	INNER JOIN `cost_codes` sb_fk_gbli__fk_codes ON sb_fk_gbli.`cost_code_id` = sb_fk_gbli__fk_codes.`id`
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON sb_fk_gbli__fk_codes.`cost_code_division_id` = codes_fk_ccd.`id`

WHERE sb_fk_gbli.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBids = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_id = $row['id'];
			$cost_code_id = $row['sb_fk_gbli__cost_code_id'];
			$subcontractor_bid_status_id = $row['sb_fk_sbs__subcontractor_bid_status_id'];

			if ($subcontractor_bid_status_id <= 4) {
				//$row['sb_fk_sbs__subcontractor_bid_status'] = 'Bids Outstanding';
			}

			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			$subcontractorBid->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sb_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sb_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontractorBid->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_contact_id'])) {
				$subcontractor_contact_id = $row['subcontractor_contact_id'];
				$row['sb_fk_subcontractor_c__id'] = $subcontractor_contact_id;
				$subcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontractor_contact_id, 'sb_fk_subcontractor_c__');
				/* @var $subcontractorContact Contact */
				$subcontractorContact->convertPropertiesToData();
			} else {
				$subcontractorContact = false;
			}
			$subcontractorBid->setSubcontractorContact($subcontractorContact);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sb_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sb_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBid->setSubcontractorBidStatus($subcontractorBidStatus);

			if (isset($row['sb_fk_subcontractor_c__fk_cc__contact_company_id'])) {
				$subcontractor_contact_company_id = $row['sb_fk_subcontractor_c__fk_cc__contact_company_id'];
				$row['sb_fk_subcontractor_c__fk_cc__id'] = $subcontractor_contact_company_id;
				$subcontractorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $subcontractor_contact_company_id, 'sb_fk_subcontractor_c__fk_cc__');
				/* @var $subcontractorContactCompany ContactCompany */
				$subcontractorContactCompany->convertPropertiesToData();
			} else {
				$subcontractorContactCompany = false;
			}
			if ($subcontractorContact) {
				$subcontractorContact->setContactCompany($subcontractorContactCompany);
			}
			$subcontractorBid->setSubcontractorContactCompany($subcontractorContactCompany);

			$arrSubcontractorBids[$subcontractor_bid_id] = $subcontractorBid;

			//$arrSubcontractorBids['subcontractor_bids_by_subcontractor_bid_status_id_by_cost_code_id'][$subcontractor_bid_status_id][$cost_code_id][$subcontractor_bid_id] = $subcontractorBid;
			//$arrSubcontractorBids['subcontractor_bids_by_id'][$subcontractor_bid_id] = $subcontractorBid;
			//$arrSubcontractorBids['subcontractor_bid_statuses_by_id'][$subcontractor_bid_status_id] = $subcontractorBidStatus;
		}

		$db->free_result();

		return $arrSubcontractorBids;
	}

	public static function loadSubcontractorBidsByProjectIdOrganizedBySubcontractorBidStatusGroupIdByCostCodeId($database, $project_id, Input $options=null)
	{
		//$arrAllSubcontractorBidStatusGroups = SubcontractorBidStatusGroup::loadAllSubcontractorBidStatusGroups($database);
		$arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId = SubcontractorBidStatusGroupToSubcontractorBidStatus::loadAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId($database);

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

		/*
		if ($forceLoadFlag) {
			self::$_arrSubcontractorBidsByProjectId = null;
		}

		$arrSubcontractorBidsByProjectId = self::$_arrSubcontractorBidsByProjectId;
		if (isset($arrSubcontractorBidsByProjectId) && !empty($arrSubcontractorBidsByProjectId)) {
			return $arrSubcontractorBidsByProjectId;
		}
		*/

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY sbsg.`sort_order` ASC, codes_fk_ccd.`division_number` ASC, sb_fk_gbli__fk_codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBid = new SubcontractorBid($database);
			$sqlOrderByColumns = $tmpSubcontractorBid->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sb_fk_gbli.`id` AS 'sb_fk_gbli__gc_budget_line_item_id',
	sb_fk_gbli.`user_company_id` AS 'sb_fk_gbli__user_company_id',
	sb_fk_gbli.`project_id` AS 'sb_fk_gbli__project_id',
	sb_fk_gbli.`cost_code_id` AS 'sb_fk_gbli__cost_code_id',
	sb_fk_gbli.`modified` AS 'sb_fk_gbli__modified',
	sb_fk_gbli.`prime_contract_scheduled_value` AS 'sb_fk_gbli__prime_contract_scheduled_value',
	sb_fk_gbli.`forecasted_expenses` AS 'sb_fk_gbli__forecasted_expenses',
	sb_fk_gbli.`created` AS 'sb_fk_gbli__created',
	sb_fk_gbli.`sort_order` AS 'sb_fk_gbli__sort_order',
	sb_fk_gbli.`disabled_flag` AS 'sb_fk_gbli__disabled_flag',

	sb_fk_c.`id` AS 'sb_fk_c__contact_id',
	sb_fk_c.`user_company_id` AS 'sb_fk_c__user_company_id',
	sb_fk_c.`user_id` AS 'sb_fk_c__user_id',
	sb_fk_c.`contact_company_id` AS 'sb_fk_c__contact_company_id',
	sb_fk_c.`email` AS 'sb_fk_c__email',
	sb_fk_c.`name_prefix` AS 'sb_fk_c__name_prefix',
	sb_fk_c.`first_name` AS 'sb_fk_c__first_name',
	sb_fk_c.`additional_name` AS 'sb_fk_c__additional_name',
	sb_fk_c.`middle_name` AS 'sb_fk_c__middle_name',
	sb_fk_c.`last_name` AS 'sb_fk_c__last_name',
	sb_fk_c.`name_suffix` AS 'sb_fk_c__name_suffix',
	sb_fk_c.`title` AS 'sb_fk_c__title',
	sb_fk_c.`vendor_flag` AS 'sb_fk_c__vendor_flag',

	sb_fk_sbs.`id` AS 'sb_fk_sbs__subcontractor_bid_status_id',
	sb_fk_sbs.`subcontractor_bid_status` AS 'sb_fk_sbs__subcontractor_bid_status',
	sb_fk_sbs.`sort_order` AS 'sb_fk_sbs__sort_order',

	sb_fk_cc.`id` AS 'sb_fk_cc__contact_company_id',
	sb_fk_cc.`user_user_company_id` AS 'sb_fk_cc__user_user_company_id',
	sb_fk_cc.`contact_user_company_id` AS 'sb_fk_cc__contact_user_company_id',
	sb_fk_cc.`company` AS 'sb_fk_cc__company',
	sb_fk_cc.`primary_phone_number` AS 'sb_fk_cc__primary_phone_number',
	sb_fk_cc.`employer_identification_number` AS 'sb_fk_cc__employer_identification_number',
	sb_fk_cc.`construction_license_number` AS 'sb_fk_cc__construction_license_number',
	sb_fk_cc.`construction_license_number_expiration_date` AS 'sb_fk_cc__construction_license_number_expiration_date',
	sb_fk_cc.`vendor_flag` AS 'sb_fk_cc__vendor_flag',

	sb.*

FROM `subcontractor_bids` sb
	INNER JOIN `gc_budget_line_items` sb_fk_gbli ON sb.`gc_budget_line_item_id` = sb_fk_gbli.`id`
	INNER JOIN `contacts` sb_fk_c ON sb.`subcontractor_contact_id` = sb_fk_c.`id`
	INNER JOIN `subcontractor_bid_statuses` sb_fk_sbs ON sb.`subcontractor_bid_status_id` = sb_fk_sbs.`id`
	INNER JOIN `contact_companies` sb_fk_cc ON sb_fk_c.`contact_company_id` = sb_fk_cc.`id`

	INNER JOIN `subcontractor_bid_status_groups_to_subcontractor_bid_statuses` sbsg2sbs ON sb_fk_sbs.`id` = sbsg2sbs.`subcontractor_bid_status_id`
	INNER JOIN `subcontractor_bid_status_groups` sbsg ON sbsg2sbs.`subcontractor_bid_status_group_id` = sbsg.`id`
	INNER JOIN `cost_codes` sb_fk_gbli__fk_codes ON sb_fk_gbli.`cost_code_id` = sb_fk_gbli__fk_codes.`id`
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON sb_fk_gbli__fk_codes.`cost_code_division_id` = codes_fk_ccd.`id`

WHERE sb_fk_gbli.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBids = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_id = $row['id'];
			$cost_code_id = $row['sb_fk_gbli__cost_code_id'];
			$subcontractor_bid_status_id = $row['sb_fk_sbs__subcontractor_bid_status_id'];

			$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id);
			$subcontractorBid->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['sb_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'sb_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontractorBid->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_contact_id'])) {
				$subcontractor_contact_id = $row['subcontractor_contact_id'];
				$row['sb_fk_c__id'] = $subcontractor_contact_id;
				$subcontractorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontractor_contact_id, 'sb_fk_c__');
				/* @var $subcontractorContact Contact */
				$subcontractorContact->convertPropertiesToData();
			} else {
				$subcontractorContact = false;
			}
			$subcontractorBid->setSubcontractorContact($subcontractorContact);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sb_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sb_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBid->setSubcontractorBidStatus($subcontractorBidStatus);

			if (isset($row['sb_fk_cc__contact_company_id'])) {
				$subcontractor_contact_company_id = $row['sb_fk_cc__contact_company_id'];
				$row['sb_fk_cc__id'] = $subcontractor_contact_company_id;
				$subcontractorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $subcontractor_contact_company_id, 'sb_fk_cc__');
				/* @var $subcontractorContactCompany ContactCompany */
				$subcontractorContactCompany->convertPropertiesToData();
			} else {
				$subcontractorContactCompany = false;
			}
			$subcontractorBid->setSubcontractorContactCompany($subcontractorContactCompany);

			//$arrSubcontractorBids[$subcontractor_bid_status_id][$cost_code_id][$subcontractor_bid_id] = $subcontractorBid;

			// Organize the $subcontractor_bid_status_id into its corresponding $subcontractor_bid_status_group_id
			$arrTmpSubcontractorBidStatusGroup = $arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId[$subcontractor_bid_status_id];
			list($subcontractor_bid_status_group_id, $subcontractorBidStatusGroup) = each($arrTmpSubcontractorBidStatusGroup);
			$arrSubcontractorBids[$subcontractor_bid_status_group_id][$cost_code_id][$subcontractor_bid_id] = $subcontractorBid;
		}

		$db->free_result();

		return $arrSubcontractorBids;
	}

	public function loadSubcontractorBidTotalsBySubcontractorBidIdList($database, array $arrSubcontractorBidIds, Input $options=null)
	{
		$database = $this->getDatabase();
		$subcontractor_bid_id = (int) $this->subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
SELECT SUM(bi2sb.item_quantity * bi2sb.unit_price) AS 'unit_total'
FROM bid_items_to_subcontractor_bids bi2sb
WHERE bi2sb.subcontractor_bid_id = ?
AND bi2sb.exclude_bid_item_flag = 'N'
";
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row['unit_total'])) {
			$total = $row['unit_total'];
			$total = money_format('%!i', $total);
		} else {
			$total = '';
		}

		return $total;
	}

	public function loadCountOfBids($database, $gc_budget_line_item_id) {

		$db = DBI::getInstance($database);
		$query ="SELECT *,count(id) as count FROM `subcontractor_bids` WHERE `gc_budget_line_item_id` = ? GROUP BY `subcontractor_bid_status_id`";
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arr = array();
		$activeArr = array(4, 5, 7, 12, 13);
		while ($row = $db->fetch()) {
			$id = $row['subcontractor_bid_status_id'];
			if($id >= 2){
				$arr['invited'] += $row['count'];
			}
			if (in_array($id, $activeArr)) {
				$arr['active'] += $row['count'];
			}
			if($id == 6){
				$arr['declined'] += $row['count'];
			}
			if($id == 7){
				$arr['rejected'] += $row['count'];
			}			
		}
		$db->free_result();
		return $arr;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

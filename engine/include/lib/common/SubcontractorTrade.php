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
 * SubcontractorTrade.
 *
 * @category   Framework
 * @package    SubcontractorTrade
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractorTrade extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractorTrade';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontractor_trades';

	/**
	 * primary key (`contact_company_id`,`cost_code_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'contact_company_id' => 'int',
		'cost_code_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontractor_trade_via_primary_key' => array(
			'contact_company_id' => 'int',
			'cost_code_id' => 'int'
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
		'contact_company_id' => 'contact_company_id',
		'cost_code_id' => 'cost_code_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_company_id;
	public $cost_code_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractorTradesByContactCompanyId;
	protected static $_arrSubcontractorTradesByCostCodeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractorTrades;

	// Foreign Key Objects
	private $_contactCompany;
	private $_costCode;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontractor_trades')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getContactCompany()
	{
		if (isset($this->_contactCompany)) {
			return $this->_contactCompany;
		} else {
			return null;
		}
	}

	public function setContactCompany($contactCompany)
	{
		$this->_contactCompany = $contactCompany;
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
	public static function getArrSubcontractorTradesByContactCompanyId()
	{
		if (isset(self::$_arrSubcontractorTradesByContactCompanyId)) {
			return self::$_arrSubcontractorTradesByContactCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorTradesByContactCompanyId($arrSubcontractorTradesByContactCompanyId)
	{
		self::$_arrSubcontractorTradesByContactCompanyId = $arrSubcontractorTradesByContactCompanyId;
	}

	public static function getArrSubcontractorTradesByCostCodeId()
	{
		if (isset(self::$_arrSubcontractorTradesByCostCodeId)) {
			return self::$_arrSubcontractorTradesByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorTradesByCostCodeId($arrSubcontractorTradesByCostCodeId)
	{
		self::$_arrSubcontractorTradesByCostCodeId = $arrSubcontractorTradesByCostCodeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractorTrades()
	{
		if (isset(self::$_arrAllSubcontractorTrades)) {
			return self::$_arrAllSubcontractorTrades;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractorTrades($arrAllSubcontractorTrades)
	{
		self::$_arrAllSubcontractorTrades = $arrAllSubcontractorTrades;
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
	 * Find by primary key (`contact_company_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactCompanyIdAndCostCodeId($database, $contact_company_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	trades.*

FROM `subcontractor_trades` trades
WHERE trades.`contact_company_id` = ?
AND trades.`cost_code_id` = ?
";
		$arrValues = array($contact_company_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$subcontractorTrade = self::instantiateOrm($database, 'SubcontractorTrade', $row);
			/* @var $subcontractorTrade SubcontractorTrade */
			return $subcontractorTrade;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`contact_company_id`,`cost_code_id`) Extended.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactCompanyIdAndCostCodeIdExtended($database, $contact_company_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	trades_fk_cc.`id` AS 'trades_fk_cc__contact_company_id',
	trades_fk_cc.`user_user_company_id` AS 'trades_fk_cc__user_user_company_id',
	trades_fk_cc.`contact_user_company_id` AS 'trades_fk_cc__contact_user_company_id',
	trades_fk_cc.`company` AS 'trades_fk_cc__company',
	trades_fk_cc.`primary_phone_number` AS 'trades_fk_cc__primary_phone_number',
	trades_fk_cc.`employer_identification_number` AS 'trades_fk_cc__employer_identification_number',
	trades_fk_cc.`construction_license_number` AS 'trades_fk_cc__construction_license_number',
	trades_fk_cc.`construction_license_number_expiration_date` AS 'trades_fk_cc__construction_license_number_expiration_date',
	trades_fk_cc.`vendor_flag` AS 'trades_fk_cc__vendor_flag',

	trades_fk_codes.`id` AS 'trades_fk_codes__cost_code_id',
	trades_fk_codes.`cost_code_division_id` AS 'trades_fk_codes__cost_code_division_id',
	trades_fk_codes.`cost_code` AS 'trades_fk_codes__cost_code',
	trades_fk_codes.`cost_code_description` AS 'trades_fk_codes__cost_code_description',
	trades_fk_codes.`cost_code_description_abbreviation` AS 'trades_fk_codes__cost_code_description_abbreviation',
	trades_fk_codes.`sort_order` AS 'trades_fk_codes__sort_order',
	trades_fk_codes.`disabled_flag` AS 'trades_fk_codes__disabled_flag',

	trades.*

FROM `subcontractor_trades` trades
	INNER JOIN `contact_companies` trades_fk_cc ON trades.`contact_company_id` = trades_fk_cc.`id`
	INNER JOIN `cost_codes` trades_fk_codes ON trades.`cost_code_id` = trades_fk_codes.`id`
WHERE trades.`contact_company_id` = ?
AND trades.`cost_code_id` = ?
";
		$arrValues = array($contact_company_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$subcontractorTrade = self::instantiateOrm($database, 'SubcontractorTrade', $row);
			/* @var $subcontractorTrade SubcontractorTrade */
			$subcontractorTrade->convertPropertiesToData();

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['trades_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'trades_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$subcontractorTrade->setContactCompany($contactCompany);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['trades_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'trades_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$subcontractorTrade->setCostCode($costCode);

			return $subcontractorTrade;
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
	 * @param array $arrContactCompanyIdAndCostCodeIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorTradesByArrContactCompanyIdAndCostCodeIdList($database, $arrContactCompanyIdAndCostCodeIdList, Input $options=null)
	{
		if (empty($arrContactCompanyIdAndCostCodeIdList)) {
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
		// ORDER BY `contact_company_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorTrade = new SubcontractorTrade($database);
			$sqlOrderByColumns = $tmpSubcontractorTrade->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrContactCompanyIdAndCostCodeIdList as $k => $arrTmp) {
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
		if (count($arrContactCompanyIdAndCostCodeIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	trades.*

FROM `subcontractor_trades` trades
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorTradesByArrContactCompanyIdAndCostCodeIdList = array();
		while ($row = $db->fetch()) {
			$subcontractorTrade = self::instantiateOrm($database, 'SubcontractorTrade', $row);
			/* @var $subcontractorTrade SubcontractorTrade */
			$arrSubcontractorTradesByArrContactCompanyIdAndCostCodeIdList[] = $subcontractorTrade;
		}

		$db->free_result();

		return $arrSubcontractorTradesByArrContactCompanyIdAndCostCodeIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontractor_trades_fk_cc` foreign key (`contact_company_id`) references `contact_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorTradesByContactCompanyId($database, $contact_company_id, Input $options=null)
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
			self::$_arrSubcontractorTradesByContactCompanyId = null;
		}

		$arrSubcontractorTradesByContactCompanyId = self::$_arrSubcontractorTradesByContactCompanyId;
		if (isset($arrSubcontractorTradesByContactCompanyId) && !empty($arrSubcontractorTradesByContactCompanyId)) {
			return $arrSubcontractorTradesByContactCompanyId;
		}

		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_company_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorTrade = new SubcontractorTrade($database);
			$sqlOrderByColumns = $tmpSubcontractorTrade->constructSqlOrderByColumns($arrOrderByAttributes);

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
	trades.*

FROM `subcontractor_trades` trades
WHERE trades.`contact_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_company_id` ASC, `cost_code_id` ASC
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorTradesByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$subcontractorTrade = self::instantiateOrm($database, 'SubcontractorTrade', $row);
			/* @var $subcontractorTrade SubcontractorTrade */
			$arrSubcontractorTradesByContactCompanyId[] = $subcontractorTrade;
		}

		$db->free_result();

		self::$_arrSubcontractorTradesByContactCompanyId = $arrSubcontractorTradesByContactCompanyId;

		return $arrSubcontractorTradesByContactCompanyId;
	}

	/**
	 * Load by constraint `subcontractor_trades_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorTradesByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrSubcontractorTradesByCostCodeId = null;
		}

		$arrSubcontractorTradesByCostCodeId = self::$_arrSubcontractorTradesByCostCodeId;
		if (isset($arrSubcontractorTradesByCostCodeId) && !empty($arrSubcontractorTradesByCostCodeId)) {
			return $arrSubcontractorTradesByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_company_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorTrade = new SubcontractorTrade($database);
			$sqlOrderByColumns = $tmpSubcontractorTrade->constructSqlOrderByColumns($arrOrderByAttributes);

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
	trades.*

FROM `subcontractor_trades` trades
WHERE trades.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_company_id` ASC, `cost_code_id` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorTradesByCostCodeId = array();
		while ($row = $db->fetch()) {
			$subcontractorTrade = self::instantiateOrm($database, 'SubcontractorTrade', $row);
			/* @var $subcontractorTrade SubcontractorTrade */
			$arrSubcontractorTradesByCostCodeId[] = $subcontractorTrade;
		}

		$db->free_result();

		self::$_arrSubcontractorTradesByCostCodeId = $arrSubcontractorTradesByCostCodeId;

		return $arrSubcontractorTradesByCostCodeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontractor_trades records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractorTrades($database, Input $options=null)
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
			self::$_arrAllSubcontractorTrades = null;
		}

		$arrAllSubcontractorTrades = self::$_arrAllSubcontractorTrades;
		if (isset($arrAllSubcontractorTrades) && !empty($arrAllSubcontractorTrades)) {
			return $arrAllSubcontractorTrades;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_company_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorTrade = new SubcontractorTrade($database);
			$sqlOrderByColumns = $tmpSubcontractorTrade->constructSqlOrderByColumns($arrOrderByAttributes);

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
	trades.*

FROM `subcontractor_trades` trades{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_company_id` ASC, `cost_code_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractorTrades = array();
		while ($row = $db->fetch()) {
			$subcontractorTrade = self::instantiateOrm($database, 'SubcontractorTrade', $row);
			/* @var $subcontractorTrade SubcontractorTrade */
			$arrAllSubcontractorTrades[] = $subcontractorTrade;
		}

		$db->free_result();

		self::$_arrAllSubcontractorTrades = $arrAllSubcontractorTrades;

		return $arrAllSubcontractorTrades;
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
INTO `subcontractor_trades`
(`contact_company_id`, `cost_code_id`)
VALUES (?, ?)
";
		$arrValues = array($this->contact_company_id, $this->cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * CostCodeDivision.
 *
 * @category   Framework
 * @package    CostCodeDivision
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class CostCodeDivision extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'CostCodeDivision';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'cost_code_divisions';

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
	 * unique index `unique_cost_code_division` (`user_company_id`,`cost_code_type_id`,`division_number`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_cost_code_division' => array(
			'user_company_id' => 'int',
			'cost_code_type_id' => 'int',
			'division_number' => 'string'
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
		'id' => 'cost_code_division_id',

		'user_company_id' => 'user_company_id',
		'cost_code_type_id' => 'cost_code_type_id',

		'division_number' => 'division_number',
		'division_number_group_id' =>'division_number_group_id',
		'division_code_heading' => 'division_code_heading',
		'division' => 'division',
		'division_abbreviation' => 'division_abbreviation',
		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $cost_code_division_id;

	public $user_company_id;
	public $cost_code_type_id;

	public $division_number;
	public $division_number_group_id;

	public $division_code_heading;
	public $division;
	public $division_abbreviation;
	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_division_number;
	public $escaped_division_code_heading;
	public $escaped_division;
	public $escaped_division_abbreviation;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_division_number_nl2br;
	public $escaped_division_code_heading_nl2br;
	public $escaped_division_nl2br;
	public $escaped_division_abbreviation_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrCostCodeDivisionsByUserCompanyId;
	protected static $_arrCostCodeDivisionsByCostCodeTypeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrCostCodeDivisionsByDivisionNumber;
	protected static $_arrCostCodeDivisionsByDivision;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllCostCodeDivisions;

	// Static Class Properties - Data Loaded Via Additional Methods
	protected static $_arrCostCodeDivisionsBySortOrder;
	protected static $_arrCostCodeDivisionsByUserCompanyIdAndProjectId;

	// Foreign Key Objects
	private $_userCompany;
	private $_costCodeType;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='cost_code_divisions')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getUserCompany()
	{
		if (isset($this->_userCompany)) {
			return $this->_userCompany;
		} else {
			return null;
		}
	}

	public function setUserCompany($userCompany)
	{
		$this->_userCompany = $userCompany;
	}

	public function getCostCodeType()
	{
		if (isset($this->_costCodeType)) {
			return $this->_costCodeType;
		} else {
			return null;
		}
	}

	public function setCostCodeType($costCodeType)
	{
		$this->_costCodeType = $costCodeType;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrCostCodeDivisionsByUserCompanyId()
	{
		if (isset(self::$_arrCostCodeDivisionsByUserCompanyId)) {
			return self::$_arrCostCodeDivisionsByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionsByUserCompanyId($arrCostCodeDivisionsByUserCompanyId)
	{
		self::$_arrCostCodeDivisionsByUserCompanyId = $arrCostCodeDivisionsByUserCompanyId;
	}

	public static function getArrCostCodeDivisionsByCostCodeTypeId()
	{
		if (isset(self::$_arrCostCodeDivisionsByCostCodeTypeId)) {
			return self::$_arrCostCodeDivisionsByCostCodeTypeId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionsByCostCodeTypeId($arrCostCodeDivisionsByCostCodeTypeId)
	{
		self::$_arrCostCodeDivisionsByCostCodeTypeId = $arrCostCodeDivisionsByCostCodeTypeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrCostCodeDivisionsByDivisionNumber()
	{
		if (isset(self::$_arrCostCodeDivisionsByDivisionNumber)) {
			return self::$_arrCostCodeDivisionsByDivisionNumber;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionsByDivisionNumber($arrCostCodeDivisionsByDivisionNumber)
	{
		self::$_arrCostCodeDivisionsByDivisionNumber = $arrCostCodeDivisionsByDivisionNumber;
	}

	public static function getArrCostCodeDivisionsByDivision()
	{
		if (isset(self::$_arrCostCodeDivisionsByDivision)) {
			return self::$_arrCostCodeDivisionsByDivision;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionsByDivision($arrCostCodeDivisionsByDivision)
	{
		self::$_arrCostCodeDivisionsByDivision = $arrCostCodeDivisionsByDivision;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllCostCodeDivisions()
	{
		if (isset(self::$_arrAllCostCodeDivisions)) {
			return self::$_arrAllCostCodeDivisions;
		} else {
			return null;
		}
	}

	public static function setArrAllCostCodeDivisions($arrAllCostCodeDivisions)
	{
		self::$_arrAllCostCodeDivisions = $arrAllCostCodeDivisions;
	}

	// Static Class Property Accessor Methods - Data Loaded Via Additional Methods
	public static function getArrCostCodeDivisionsBySortOrder()
	{
		if (isset(self::$_arrCostCodeDivisionsBySortOrder)) {
			return self::$_arrCostCodeDivisionsBySortOrder;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionsBySortOrder($arrCostCodeDivisionsBySortOrder)
	{
		self::$_arrCostCodeDivisionsBySortOrder = $arrCostCodeDivisionsBySortOrder;
	}

	public static function getArrCostCodeDivisionsByUserCompanyIdAndProjectId()
	{
		if (isset(self::$_arrCostCodeDivisionsByUserCompanyIdAndProjectId)) {
			return self::$_arrCostCodeDivisionsByUserCompanyIdAndProjectId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionsByUserCompanyIdAndProjectId($arrCostCodeDivisionsByUserCompanyIdAndProjectId)
	{
		self::$_arrCostCodeDivisionsByUserCompanyIdAndProjectId = $arrCostCodeDivisionsByUserCompanyIdAndProjectId;
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
	 * @param int $cost_code_division_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $cost_code_division_id, $table='cost_code_divisions', $module='CostCodeDivision')
	{
		$costCodeDivision = parent::findById($database, $cost_code_division_id, $table, $module);

		return $costCodeDivision;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $cost_code_division_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findCostCodeDivisionByIdExtended($database, $cost_code_division_id)
	{
		$cost_code_division_id = (int) $cost_code_division_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ccd_fk_uc.`id` AS 'ccd_fk_uc__user_company_id',
	ccd_fk_uc.`company` AS 'ccd_fk_uc__company',
	ccd_fk_uc.`primary_phone_number` AS 'ccd_fk_uc__primary_phone_number',
	ccd_fk_uc.`employer_identification_number` AS 'ccd_fk_uc__employer_identification_number',
	ccd_fk_uc.`construction_license_number` AS 'ccd_fk_uc__construction_license_number',
	ccd_fk_uc.`construction_license_number_expiration_date` AS 'ccd_fk_uc__construction_license_number_expiration_date',
	ccd_fk_uc.`paying_customer_flag` AS 'ccd_fk_uc__paying_customer_flag',

	ccd_fk_cct.`id` AS 'ccd_fk_cct__cost_code_type_id',
	ccd_fk_cct.`cost_code_type` AS 'ccd_fk_cct__cost_code_type',

	ccd.*

FROM `cost_code_divisions` ccd
	INNER JOIN `user_companies` ccd_fk_uc ON ccd.`user_company_id` = ccd_fk_uc.`id`
	INNER JOIN `cost_code_types` ccd_fk_cct ON ccd.`cost_code_type_id` = ccd_fk_cct.`id`
WHERE ccd.`id` = ?
";
		$arrValues = array($cost_code_division_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			$costCodeDivision->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['ccd_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'ccd_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$costCodeDivision->setUserCompany($userCompany);

			if (isset($row['cost_code_type_id'])) {
				$cost_code_type_id = $row['cost_code_type_id'];
				$row['ccd_fk_cct__id'] = $cost_code_type_id;
				$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id, 'ccd_fk_cct__');
				/* @var $costCodeType CostCodeType */
				$costCodeType->convertPropertiesToData();
			} else {
				$costCodeType = false;
			}
			$costCodeDivision->setCostCodeType($costCodeType);

			return $costCodeDivision;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_cost_code_division` (`user_company_id`,`cost_code_type_id`,`division_number`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $cost_code_type_id
	 * @param string $division_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndCostCodeTypeIdAndDivisionNumber($database, $user_company_id, $cost_code_type_id, $division_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ccd.*

FROM `cost_code_divisions` ccd
WHERE ccd.`user_company_id` = ?
AND ccd.`cost_code_type_id` = ?
AND ccd.`division_number` = ?
";
		$arrValues = array($user_company_id, $cost_code_type_id, $division_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			return $costCodeDivision;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrCostCodeDivisionIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDivisionsByArrCostCodeDivisionIds($database, $arrCostCodeDivisionIds, Input $options=null)
	{
		if (empty($arrCostCodeDivisionIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ccd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivision = new CostCodeDivision($database);
			$sqlOrderByColumns = $tmpCostCodeDivision->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrCostCodeDivisionIds as $k => $cost_code_division_id) {
			$cost_code_division_id = (int) $cost_code_division_id;
			$arrCostCodeDivisionIds[$k] = $db->escape($cost_code_division_id);
		}
		$csvCostCodeDivisionIds = join(',', $arrCostCodeDivisionIds);

		$query =
"
SELECT

	ccd.*

FROM `cost_code_divisions` ccd
WHERE ccd.`id` IN ($csvCostCodeDivisionIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrCostCodeDivisionsByCsvCostCodeDivisionIds = array();
		while ($row = $db->fetch()) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			$costCodeDivision->convertPropertiesToData();

			$arrCostCodeDivisionsByCsvCostCodeDivisionIds[$cost_code_division_id] = $costCodeDivision;
		}

		$db->free_result();

		return $arrCostCodeDivisionsByCsvCostCodeDivisionIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `cost_code_divisions_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDivisionsByUserCompanyId($database, $user_company_id, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
			$filter = $options->filterval;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrCostCodeDivisionsByUserCompanyId = null;
		}

		$arrCostCodeDivisionsByUserCompanyId = self::$_arrCostCodeDivisionsByUserCompanyId;
		if (isset($arrCostCodeDivisionsByUserCompanyId) && !empty($arrCostCodeDivisionsByUserCompanyId)) {
			return $arrCostCodeDivisionsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ccd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivision = new CostCodeDivision($database);
			$sqlOrderByColumns = $tmpCostCodeDivision->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$sqlfilter ="";
		if(isset($filter)){
			$sqlfilter ="and ccd.`cost_code_type_id` = $filter ";
		}

		$query =
"
SELECT
	ccd.*

FROM `cost_code_divisions` ccd
WHERE ccd.`user_company_id` = ? {$sqlfilter}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			$arrCostCodeDivisionsByUserCompanyId[$cost_code_division_id] = $costCodeDivision;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionsByUserCompanyId = $arrCostCodeDivisionsByUserCompanyId;

		return $arrCostCodeDivisionsByUserCompanyId;
	}

	/**
	 * Load by constraint `cost_code_divisions_fk_cct` foreign key (`cost_code_type_id`) references `cost_code_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDivisionsByCostCodeTypeId($database, $cost_code_type_id, Input $options=null)
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
			self::$_arrCostCodeDivisionsByCostCodeTypeId = null;
		}

		$arrCostCodeDivisionsByCostCodeTypeId = self::$_arrCostCodeDivisionsByCostCodeTypeId;
		if (isset($arrCostCodeDivisionsByCostCodeTypeId) && !empty($arrCostCodeDivisionsByCostCodeTypeId)) {
			return $arrCostCodeDivisionsByCostCodeTypeId;
		}

		$cost_code_type_id = (int) $cost_code_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ccd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivision = new CostCodeDivision($database);
			$sqlOrderByColumns = $tmpCostCodeDivision->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccd.*

FROM `cost_code_divisions` ccd
WHERE ccd.`cost_code_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($cost_code_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionsByCostCodeTypeId = array();
		while ($row = $db->fetch()) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			$arrCostCodeDivisionsByCostCodeTypeId[$cost_code_division_id] = $costCodeDivision;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionsByCostCodeTypeId = $arrCostCodeDivisionsByCostCodeTypeId;

		return $arrCostCodeDivisionsByCostCodeTypeId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `division_number` (`division_number`).
	 *
	 * @param string $database
	 * @param string $division_number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadCostCodeDivisionsByDivisionNumber($database, $division_number, Input $options=null)
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
			self::$_arrCostCodeDivisionsByDivisionNumber = null;
		}

		$arrCostCodeDivisionsByDivisionNumber = self::$_arrCostCodeDivisionsByDivisionNumber;
		if (isset($arrCostCodeDivisionsByDivisionNumber) && !empty($arrCostCodeDivisionsByDivisionNumber)) {
			return $arrCostCodeDivisionsByDivisionNumber;
		}

		$division_number = (string) $division_number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ccd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivision = new CostCodeDivision($database);
			$sqlOrderByColumns = $tmpCostCodeDivision->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccd.*

FROM `cost_code_divisions` ccd
WHERE ccd.`division_number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($division_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionsByDivisionNumber = array();
		while ($row = $db->fetch()) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			$arrCostCodeDivisionsByDivisionNumber[$cost_code_division_id] = $costCodeDivision;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionsByDivisionNumber = $arrCostCodeDivisionsByDivisionNumber;

		return $arrCostCodeDivisionsByDivisionNumber;
	}

	/**
	 * Load by key `division` (`division`).
	 *
	 * @param string $database
	 * @param string $division
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadCostCodeDivisionsByDivision($database, $division, Input $options=null)
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
			self::$_arrCostCodeDivisionsByDivision = null;
		}

		$arrCostCodeDivisionsByDivision = self::$_arrCostCodeDivisionsByDivision;
		if (isset($arrCostCodeDivisionsByDivision) && !empty($arrCostCodeDivisionsByDivision)) {
			return $arrCostCodeDivisionsByDivision;
		}

		$division = (string) $division;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ccd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivision = new CostCodeDivision($database);
			$sqlOrderByColumns = $tmpCostCodeDivision->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccd.*

FROM `cost_code_divisions` ccd
WHERE ccd.`division` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($division);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionsByDivision = array();
		while ($row = $db->fetch()) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			$arrCostCodeDivisionsByDivision[$cost_code_division_id] = $costCodeDivision;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionsByDivision = $arrCostCodeDivisionsByDivision;

		return $arrCostCodeDivisionsByDivision;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all cost_code_divisions records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllCostCodeDivisions($database, Input $options=null)
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
			self::$_arrAllCostCodeDivisions = null;
		}

		$arrAllCostCodeDivisions = self::$_arrAllCostCodeDivisions;
		if (isset($arrAllCostCodeDivisions) && !empty($arrAllCostCodeDivisions)) {
			return $arrAllCostCodeDivisions;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ccd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivision = new CostCodeDivision($database);
			$sqlOrderByColumns = $tmpCostCodeDivision->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccd.*

FROM `cost_code_divisions` ccd{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllCostCodeDivisions = array();
		while ($row = $db->fetch()) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			$arrAllCostCodeDivisions[$cost_code_division_id] = $costCodeDivision;
		}

		$db->free_result();

		self::$_arrAllCostCodeDivisions = $arrAllCostCodeDivisions;

		return $arrAllCostCodeDivisions;
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
INTO `cost_code_divisions`
(`user_company_id`, `cost_code_type_id`, `division_number`, `division_code_heading`, `division`, `division_abbreviation`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `division_code_heading` = ?, `division` = ?, `division_abbreviation` = ?, `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->user_company_id, $this->cost_code_type_id, $this->division_number, $this->division_code_heading, $this->division, $this->division_abbreviation, $this->sort_order, $this->disabled_flag, $this->division_code_heading, $this->division, $this->division_abbreviation, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$cost_code_division_id = $db->insertId;
		$db->free_result();

		return $cost_code_division_id;
	}

	// Save: insert ignore

	/**
	 * Find sort_order value.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextCostCodeDivisionSortOrder($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(ccd.`sort_order`) AS 'next_sort_order'
FROM `cost_code_divisions` ccd
WHERE ccd.`user_company_id` = ?
";
// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$next_sort_order = $row['next_sort_order'] + 1;
		} else {
			$next_sort_order = 0;
		}

		return $next_sort_order;
	}

	// Loaders: Additional Methods
	/**
	 * Load by user_company_id and project_id via join against cost_codes table.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadCostCodeDivisionsByUserCompanyIdAndProjectId($database, $user_company_id, $project_id, Input $options=null)
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
			self::$_arrCostCodeDivisionsByUserCompanyIdAndProjectId = null;
		}

		$arrCostCodeDivisionsByUserCompanyIdAndProjectId = self::$_arrCostCodeDivisionsByUserCompanyIdAndProjectId;
		if (isset($arrCostCodeDivisionsByUserCompanyIdAndProjectId) && !empty($arrCostCodeDivisionsByUserCompanyIdAndProjectId)) {
			return $arrCostCodeDivisionsByUserCompanyIdAndProjectId;
		}

		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY ccd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivision = new CostCodeDivision($database);
			$sqlOrderByColumns = $tmpCostCodeDivision->constructSqlOrderByColumns($arrOrderByAttributes);

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
SELECT ccd.*

FROM `cost_code_divisions` ccd
	INNER JOIN `cost_codes` codes ON ccd.`id` = codes.`cost_code_division_id`
	INNER JOIN `gc_budget_line_items` gbli ON gbli.`cost_code_id` = codes.`id`
WHERE gbli.`user_company_id` = ?
AND gbli.`project_id` = ?
GROUP by ccd.`id`{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `cost_code_type_id` ASC, `division_number` ASC, `division_code_heading` ASC, `division` ASC, `division_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionsByUserCompanyIdAndProjectId = array();
		while ($row = $db->fetch()) {
			$cost_code_division_id = $row['id'];
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id);
			/* @var $costCodeDivision CostCodeDivision */
			$arrCostCodeDivisionsByUserCompanyIdAndProjectId[$cost_code_division_id] = $costCodeDivision;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionsByUserCompanyIdAndProjectId = $arrCostCodeDivisionsByUserCompanyIdAndProjectId;

		return $arrCostCodeDivisionsByUserCompanyIdAndProjectId;
	}

	public function fetchCostCodeCount()
	{
		$cost_code_division_id = (int) $this->cost_code_division_id;

		$db = $this->getDb();

		$query =
"
SELECT count(*) AS 'total'
FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
WHERE codes_fk_ccd.`id` = ?
";

		$arrValues = array($cost_code_division_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row['total'])) {
			$total = $row['total'];
		} else {
			$total = 0;
		}

		return $total;
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_cost_code_division` (`user_company_id`,`cost_code_type_id`,`division_number`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $cost_code_type_id
	 * @param string $division_number
	 * @return mixed (single ORM object | false)
	 */
	public static function checkDuplicateCostCodeDivision($database, $user_company_id, $cost_code_type_id, $division_number){
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
				"
				SELECT

				ccd.*
				FROM `cost_code_divisions` ccd
				WHERE ccd.`user_company_id` = $user_company_id
				AND ccd.`cost_code_type_id` = $cost_code_type_id
				AND ccd.`division_number` = '$division_number'
				";
		$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		return $row;
	}
	public static function updateCostCodeDivision($database, $divisonNumber, $divisonHeadingNumber, $divisionName, $divisionAbbreviation, $costCodeDivisionId){
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
				"
				UPDATE `cost_code_divisions` SET
				`division_number` = ?,
				`division_code_heading`= ?,
				`division` = ?,
				`division_abbreviation`= ?
				 WHERE `id` = ?
				";
		$arrValues = array($divisonNumber, $divisonHeadingNumber, $divisionName, $divisionAbbreviation, $costCodeDivisionId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
	}
	public static function addCostCodeDivision($database, $user_company_id, $costCodeTypeId, $divisonNumber, $divisonHeadingNumber,
	 $divisionName, $divisionAbbreviation){
		$db = DBI::getInstance($database);
		$nextCostCodeDivisionSortOrder = CostCodeDivision::findNextCostCodeDivisionSortOrder($database, $user_company_id);
		/* @var $db DBI_mysqli */

		$query =
				"
				Insert into cost_code_divisions (`user_company_id`, `cost_code_type_id`, `division_number`, `division_code_heading`, `division`, `division_abbreviation`, `sort_order`, `disabled_flag`)
				values ('$user_company_id','$costCodeTypeId','$divisonNumber','$divisonHeadingNumber',
				'$divisionName','$divisionAbbreviation','$nextCostCodeDivisionSortOrder',
				'N')
				";
		$db->execute($query);
		$costCodeDivisionId = $db->insertId;
		$db->free_result();
		return $costCodeDivisionId;
	}
	//To get the costcode data for the cost cost id
	public static function getcostCodeDivisionByCostcodeId($database,$costcodeid,$costCodeDividerType)
	{
		$db = DBI::getInstance($database);
		$query ="SELECT ccd.`id` as ccd_id, ccd.`user_company_id` as ccd_user_company_id, ccd.`cost_code_type_id` as ccd_cost_code_type_id, ccd.`division_number` as ccd_division_number, ccd.`division_number_group_id` as ccd_division_number_group_id, ccd.`division_code_heading` as ccd_division_code_heading, ccd.`division` as ccd_division, ccd.`division_abbreviation` as ccd_division_abbreviation, ccd.`sort_order` as ccd_sort_order, ccd.`disabled_flag` as ccd_disabled_flag, concat(ccd.`division_number`,'$costCodeDividerType',cc.cost_code,' ',cc.cost_code_description) as cost_code_abb,concat(ccd.`division_number`,'$costCodeDividerType',cc.cost_code) as short_cost_code,
		cc.* from `cost_codes` as cc inner join `cost_code_divisions` as ccd on ccd.id = cc.cost_code_division_id where cc.id=?
				";
		$arrValues = array($costcodeid);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$costcodedata =array();
		$row = $db->fetch();
		$costcodedata = $row;
		$db->free_result();
		return $costcodedata;
		
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

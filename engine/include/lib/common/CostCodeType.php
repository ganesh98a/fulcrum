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
 * CostCodeType.
 *
 * @category   Framework
 * @package    CostCodeType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class CostCodeType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'CostCodeType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'cost_code_types';

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
	 * unique index `unique_cost_code_type` (`cost_code_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_cost_code_type' => array(
			'cost_code_type' => 'string'
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
		'id' => 'cost_code_type_id',

		'cost_code_type' => 'cost_code_type'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $cost_code_type_id;

	public $cost_code_type;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_cost_code_type;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_cost_code_type_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllCostCodeTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='cost_code_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllCostCodeTypes()
	{
		if (isset(self::$_arrAllCostCodeTypes)) {
			return self::$_arrAllCostCodeTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllCostCodeTypes($arrAllCostCodeTypes)
	{
		self::$_arrAllCostCodeTypes = $arrAllCostCodeTypes;
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
	 * @param int $cost_code_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $cost_code_type_id, $table='cost_code_types', $module='CostCodeType')
	{
		$costCodeType = parent::findById($database, $cost_code_type_id, $table, $module);

		return $costCodeType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $cost_code_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findCostCodeTypeByIdExtended($database, $cost_code_type_id)
	{
		$cost_code_type_id = (int) $cost_code_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cct.*

FROM `cost_code_types` cct
WHERE cct.`id` = ?
";
		$arrValues = array($cost_code_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$cost_code_type_id = $row['id'];
			$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id);
			/* @var $costCodeType CostCodeType */
			$costCodeType->convertPropertiesToData();

			return $costCodeType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_cost_code_type` (`cost_code_type`).
	 *
	 * @param string $database
	 * @param string $cost_code_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByCostCodeType($database, $cost_code_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cct.*

FROM `cost_code_types` cct
WHERE cct.`cost_code_type` = ?
";
		$arrValues = array($cost_code_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$cost_code_type_id = $row['id'];
			$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id);
			/* @var $costCodeType CostCodeType */
			return $costCodeType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrCostCodeTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeTypesByArrCostCodeTypeIds($database, $arrCostCodeTypeIds, Input $options=null)
	{
		if (empty($arrCostCodeTypeIds)) {
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
		// ORDER BY `id` ASC, `cost_code_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeType = new CostCodeType($database);
			$sqlOrderByColumns = $tmpCostCodeType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrCostCodeTypeIds as $k => $cost_code_type_id) {
			$cost_code_type_id = (int) $cost_code_type_id;
			$arrCostCodeTypeIds[$k] = $db->escape($cost_code_type_id);
		}
		$csvCostCodeTypeIds = join(',', $arrCostCodeTypeIds);

		$query =
"
SELECT

	cct.*

FROM `cost_code_types` cct
WHERE cct.`id` IN ($csvCostCodeTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrCostCodeTypesByCsvCostCodeTypeIds = array();
		while ($row = $db->fetch()) {
			$cost_code_type_id = $row['id'];
			$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id);
			/* @var $costCodeType CostCodeType */
			$costCodeType->convertPropertiesToData();

			$arrCostCodeTypesByCsvCostCodeTypeIds[$cost_code_type_id] = $costCodeType;
		}

		$db->free_result();

		return $arrCostCodeTypesByCsvCostCodeTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all cost_code_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllCostCodeTypes($database, Input $options=null)
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
			self::$_arrAllCostCodeTypes = null;
		}

		$arrAllCostCodeTypes = self::$_arrAllCostCodeTypes;
		if (isset($arrAllCostCodeTypes) && !empty($arrAllCostCodeTypes)) {
			return $arrAllCostCodeTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeType = new CostCodeType($database);
			$sqlOrderByColumns = $tmpCostCodeType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cct.*

FROM `cost_code_types` cct{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `cost_code_type` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllCostCodeTypes = array();
		while ($row = $db->fetch()) {
			$cost_code_type_id = $row['id'];
			$costCodeType = self::instantiateOrm($database, 'CostCodeType', $row, null, $cost_code_type_id);
			/* @var $costCodeType CostCodeType */
			$arrAllCostCodeTypes[$cost_code_type_id] = $costCodeType;
		}

		$db->free_result();

		self::$_arrAllCostCodeTypes = $arrAllCostCodeTypes;

		return $arrAllCostCodeTypes;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

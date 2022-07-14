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
 * CostCodeDivider.
 *
 * @category   Framework
 * @package    CostCodeDivider
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class CostCodeDivider extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'CostCodeDivider';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'cost_code_divider';

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
	 * unique index `unique_cost_code_divider` (`cost_code_divider`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_cost_code_divider' => array(
			'cost_code_divider' => 'string'
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
		'id' => 'cost_code_divider_id',

		'cost_code_divider' => 'cost_code_divider'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $cost_code_divider_id;

	public $cost_code_divider;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_cost_code_divider;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_cost_code_divider_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllCostCodeDividers;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='cost_code_divider')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllCostCodeDividers()
	{
		if (isset(self::$_arrAllCostCodeDividers)) {
			return self::$_arrAllCostCodeDividers;
		} else {
			return null;
		}
	}

	public static function setArrAllCostCodeDividers($arrAllCostCodeDividers)
	{
		self::$_arrAllCostCodeDividers = $arrAllCostCodeDividers;
	}


	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $cost_code_divider_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $cost_code_divider_id, $table='cost_code_divider', $module='CostCodeDivider')
	{
		$CostCodeDivider = parent::findById($database, $cost_code_divider_id, $table, $module);

		return $CostCodeDivider;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $cost_code_divider_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findCostCodeDividerByIdExtended($database, $cost_code_divider_id)
	{
		$cost_code_divider_id = (int) $cost_code_divider_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ccd.*

FROM `cost_code_divider` ccd
WHERE ccd.`id` = ?
";
		$arrValues = array($cost_code_divider_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$cost_code_divider_id = $row['id'];
			$CostCodeDivider = self::instantiateOrm($database, 'CostCodeDivider', $row, null, $cost_code_divider_id);
			/* @var $CostCodeDivider CostCodeDivider */
			$CostCodeDivider->convertPropertiesToData();

			return $CostCodeDivider;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_cost_code_divider` (`cost_code_divider`).
	 *
	 * @param string $database
	 * @param string $cost_code_divider
	 * @return mixed (single ORM object | false)
	 */
	public static function findByCostCodeDivider($database, $cost_code_divider)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ccd.*

FROM `cost_code_divider` ccd
WHERE ccd.`cost_code_divider` = ?
";
		$arrValues = array($cost_code_divider);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$cost_code_divider_id = $row['id'];
			$CostCodeDivider = self::instantiateOrm($database, 'CostCodeDivider', $row, null, $cost_code_divider_id);
			/* @var $CostCodeDivider CostCodeDivider */
			return $CostCodeDivider;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrCostCodeDividerIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDividersByArrCostCodeDividerIds($database, $arrCostCodeDividerIds, Input $options=null)
	{
		if (empty($arrCostCodeDividerIds)) {
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
		// ORDER BY `id` ASC, `cost_code_divider` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivider = new CostCodeDivider($database);
			$sqlOrderByColumns = $tmpCostCodeDivider->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrCostCodeDividerIds as $k => $cost_code_divider_id) {
			$cost_code_divider_id = (int) $cost_code_divider_id;
			$arrCostCodeDividerIds[$k] = $db->escape($cost_code_divider_id);
		}
		$csvCostCodeDividerIds = join(',', $arrCostCodeDividerIds);

		$query =
"
SELECT

	ccd.*

FROM `cost_code_divider` ccd
WHERE ccd.`id` IN ($csvCostCodeDividerIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrCostCodeDividersByCsvCostCodeDividerIds = array();
		while ($row = $db->fetch()) {
			$cost_code_divider_id = $row['id'];
			$CostCodeDivider = self::instantiateOrm($database, 'CostCodeDivider', $row, null, $cost_code_divider_id);
			/* @var $CostCodeDivider CostCodeDivider */
			$CostCodeDivider->convertPropertiesToData();

			$arrCostCodeDividersByCsvCostCodeDividerIds[$cost_code_divider_id] = $CostCodeDivider;
		}

		$db->free_result();

		return $arrCostCodeDividersByCsvCostCodeDividerIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all cost_code_divider records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllCostCodeDividers($database, Input $options=null)
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
			self::$_arrAllCostCodeDividers = null;
		}

		$arrAllCostCodeDividers = self::$_arrAllCostCodeDividers;
		if (isset($arrAllCostCodeDividers) && !empty($arrAllCostCodeDividers)) {
			return $arrAllCostCodeDividers;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `cost_code_divider` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivider = new CostCodeDivider($database);
			$sqlOrderByColumns = $tmpCostCodeDivider->constructSqlOrderByColumns($arrOrderByAttributes);

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

FROM `cost_code_divider` ccd
";
// LIMIT 10
// ORDER BY `id` ASC, `cost_code_divider` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllCostCodeDividers = array();
		while ($row = $db->fetch()) {
			$cost_code_divider_id = $row['id'];
			$CostCodeDivider = self::instantiateOrm($database, 'CostCodeDivider', $row, null, $cost_code_divider_id);
			/* @var $CostCodeDivider CostCodeDivider */
			$arrAllCostCodeDividers[$cost_code_divider_id] = $CostCodeDivider;
		}

		$db->free_result();

		self::$_arrAllCostCodeDividers = $arrAllCostCodeDividers;

		return $arrAllCostCodeDividers;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

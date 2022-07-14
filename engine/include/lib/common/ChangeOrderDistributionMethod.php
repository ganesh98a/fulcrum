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
 * ChangeOrderDistributionMethod.
 *
 * @category   Framework
 * @package    ChangeOrderDistributionMethod
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ChangeOrderDistributionMethod extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrderDistributionMethod';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_order_distribution_methods';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order_distribution_method';

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
	 * unique index `unique_change_order_distribution_method` (`change_order_distribution_method`) comment 'Change Order Distribution Methods transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_change_order_distribution_method' => array(
			'change_order_distribution_method' => 'string'
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
		'id' => 'change_order_distribution_method_id',

		'change_order_distribution_method' => 'change_order_distribution_method',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_distribution_method_id;

	public $change_order_distribution_method;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_change_order_distribution_method;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_change_order_distribution_method_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrderDistributionMethods;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='change_order_distribution_methods')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrderDistributionMethods()
	{
		if (isset(self::$_arrAllChangeOrderDistributionMethods)) {
			return self::$_arrAllChangeOrderDistributionMethods;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrderDistributionMethods($arrAllChangeOrderDistributionMethods)
	{
		self::$_arrAllChangeOrderDistributionMethods = $arrAllChangeOrderDistributionMethods;
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
	 * @param int $change_order_distribution_method_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $change_order_distribution_method_id, $table='change_order_distribution_methods', $module='ChangeOrderDistributionMethod')
	{
		$changeOrderDistributionMethod = parent::findById($database, $change_order_distribution_method_id, $table, $module);

		return $changeOrderDistributionMethod;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $change_order_distribution_method_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findChangeOrderDistributionMethodByIdExtended($database, $change_order_distribution_method_id)
	{
		$change_order_distribution_method_id = (int) $change_order_distribution_method_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	codm.*

FROM `change_order_distribution_methods` codm
WHERE codm.`id` = ?
";
		$arrValues = array($change_order_distribution_method_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$change_order_distribution_method_id = $row['id'];
			$changeOrderDistributionMethod = self::instantiateOrm($database, 'ChangeOrderDistributionMethod', $row, null, $change_order_distribution_method_id);
			/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
			$changeOrderDistributionMethod->convertPropertiesToData();

			return $changeOrderDistributionMethod;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_change_order_distribution_method` (`change_order_distribution_method`) comment 'Change Order Distribution Methods transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $change_order_distribution_method
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderDistributionMethod($database, $change_order_distribution_method)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	codm.*

FROM `change_order_distribution_methods` codm
WHERE codm.`change_order_distribution_method` = ?
";
		$arrValues = array($change_order_distribution_method);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$change_order_distribution_method_id = $row['id'];
			$changeOrderDistributionMethod = self::instantiateOrm($database, 'ChangeOrderDistributionMethod', $row, null, $change_order_distribution_method_id);
			/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
			return $changeOrderDistributionMethod;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrChangeOrderDistributionMethodIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDistributionMethodsByArrChangeOrderDistributionMethodIds($database, $arrChangeOrderDistributionMethodIds, Input $options=null)
	{
		if (empty($arrChangeOrderDistributionMethodIds)) {
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
		// ORDER BY `id` ASC, `change_order_distribution_method` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDistributionMethod = new ChangeOrderDistributionMethod($database);
			$sqlOrderByColumns = $tmpChangeOrderDistributionMethod->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrChangeOrderDistributionMethodIds as $k => $change_order_distribution_method_id) {
			$change_order_distribution_method_id = (int) $change_order_distribution_method_id;
			$arrChangeOrderDistributionMethodIds[$k] = $db->escape($change_order_distribution_method_id);
		}
		$csvChangeOrderDistributionMethodIds = join(',', $arrChangeOrderDistributionMethodIds);

		$query =
"
SELECT

	codm.*

FROM `change_order_distribution_methods` codm
WHERE codm.`id` IN ($csvChangeOrderDistributionMethodIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrChangeOrderDistributionMethodsByCsvChangeOrderDistributionMethodIds = array();
		while ($row = $db->fetch()) {
			$change_order_distribution_method_id = $row['id'];
			$changeOrderDistributionMethod = self::instantiateOrm($database, 'ChangeOrderDistributionMethod', $row, null, $change_order_distribution_method_id);
			/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
			$changeOrderDistributionMethod->convertPropertiesToData();

			$arrChangeOrderDistributionMethodsByCsvChangeOrderDistributionMethodIds[$change_order_distribution_method_id] = $changeOrderDistributionMethod;
		}

		$db->free_result();

		return $arrChangeOrderDistributionMethodsByCsvChangeOrderDistributionMethodIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_order_distribution_methods records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrderDistributionMethods($database, Input $options=null)
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
			self::$_arrAllChangeOrderDistributionMethods = null;
		}

		$arrAllChangeOrderDistributionMethods = self::$_arrAllChangeOrderDistributionMethods;
		if (isset($arrAllChangeOrderDistributionMethods) && !empty($arrAllChangeOrderDistributionMethods)) {
			return $arrAllChangeOrderDistributionMethods;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_distribution_method` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDistributionMethod = new ChangeOrderDistributionMethod($database);
			$sqlOrderByColumns = $tmpChangeOrderDistributionMethod->constructSqlOrderByColumns($arrOrderByAttributes);

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
	codm.*

FROM `change_order_distribution_methods` codm{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_distribution_method` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrderDistributionMethods = array();
		while ($row = $db->fetch()) {
			$change_order_distribution_method_id = $row['id'];
			$changeOrderDistributionMethod = self::instantiateOrm($database, 'ChangeOrderDistributionMethod', $row, null, $change_order_distribution_method_id);
			/* @var $changeOrderDistributionMethod ChangeOrderDistributionMethod */
			$arrAllChangeOrderDistributionMethods[$change_order_distribution_method_id] = $changeOrderDistributionMethod;
		}

		$db->free_result();

		self::$_arrAllChangeOrderDistributionMethods = $arrAllChangeOrderDistributionMethods;

		return $arrAllChangeOrderDistributionMethods;
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
INTO `change_order_distribution_methods`
(`change_order_distribution_method`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->change_order_distribution_method, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$change_order_distribution_method_id = $db->insertId;
		$db->free_result();

		return $change_order_distribution_method_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

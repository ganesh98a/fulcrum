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
 * SubmittalDistributionMethod.
 *
 * @category   Framework
 * @package    SubmittalDistributionMethod
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalDistributionMethod extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalDistributionMethod';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_distribution_methods';

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
	 * unique index `unique_submittal_distribution_method` (`submittal_distribution_method`) comment 'Submittal Distribution Methods transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_submittal_distribution_method' => array(
			'submittal_distribution_method' => 'string'
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
		'id' => 'submittal_distribution_method_id',

		'submittal_distribution_method' => 'submittal_distribution_method',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_distribution_method_id;

	public $submittal_distribution_method;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_submittal_distribution_method;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_submittal_distribution_method_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalDistributionMethods;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_distribution_methods')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalDistributionMethods()
	{
		if (isset(self::$_arrAllSubmittalDistributionMethods)) {
			return self::$_arrAllSubmittalDistributionMethods;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalDistributionMethods($arrAllSubmittalDistributionMethods)
	{
		self::$_arrAllSubmittalDistributionMethods = $arrAllSubmittalDistributionMethods;
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
	 * @param int $submittal_distribution_method_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $submittal_distribution_method_id,$table='submittal_distribution_methods', $module='SubmittalDistributionMethod')
	{
		$submittalDistributionMethod = parent::findById($database, $submittal_distribution_method_id,$table, $module);

		return $submittalDistributionMethod;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $submittal_distribution_method_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubmittalDistributionMethodByIdExtended($database, $submittal_distribution_method_id)
	{
		$submittal_distribution_method_id = (int) $submittal_distribution_method_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sudm.*

FROM `submittal_distribution_methods` sudm
WHERE sudm.`id` = ?
";
		$arrValues = array($submittal_distribution_method_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$submittal_distribution_method_id = $row['id'];
			$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id);
			/* @var $submittalDistributionMethod SubmittalDistributionMethod */
			$submittalDistributionMethod->convertPropertiesToData();

			return $submittalDistributionMethod;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_submittal_distribution_method` (`submittal_distribution_method`) comment 'Submittal Distribution Methods transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $submittal_distribution_method
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalDistributionMethod($database, $submittal_distribution_method)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sudm.*

FROM `submittal_distribution_methods` sudm
WHERE sudm.`submittal_distribution_method` = ?
";
		$arrValues = array($submittal_distribution_method);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$submittal_distribution_method_id = $row['id'];
			$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id);
			/* @var $submittalDistributionMethod SubmittalDistributionMethod */
			return $submittalDistributionMethod;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubmittalDistributionMethodIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDistributionMethodsByArrSubmittalDistributionMethodIds($database, $arrSubmittalDistributionMethodIds, Input $options=null)
	{
		if (empty($arrSubmittalDistributionMethodIds)) {
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
		// ORDER BY `id` ASC, `submittal_distribution_method` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDistributionMethod = new SubmittalDistributionMethod($database);
			$sqlOrderByColumns = $tmpSubmittalDistributionMethod->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubmittalDistributionMethodIds as $k => $submittal_distribution_method_id) {
			$submittal_distribution_method_id = (int) $submittal_distribution_method_id;
			$arrSubmittalDistributionMethodIds[$k] = $db->escape($submittal_distribution_method_id);
		}
		$csvSubmittalDistributionMethodIds = join(',', $arrSubmittalDistributionMethodIds);

		$query =
"
SELECT

	sudm.*

FROM `submittal_distribution_methods` sudm
WHERE sudm.`id` IN ($csvSubmittalDistributionMethodIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubmittalDistributionMethodsByCsvSubmittalDistributionMethodIds = array();
		while ($row = $db->fetch()) {
			$submittal_distribution_method_id = $row['id'];
			$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id);
			/* @var $submittalDistributionMethod SubmittalDistributionMethod */
			$submittalDistributionMethod->convertPropertiesToData();

			$arrSubmittalDistributionMethodsByCsvSubmittalDistributionMethodIds[$submittal_distribution_method_id] = $submittalDistributionMethod;
		}

		$db->free_result();

		return $arrSubmittalDistributionMethodsByCsvSubmittalDistributionMethodIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittal_distribution_methods records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalDistributionMethods($database, Input $options=null)
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
			self::$_arrAllSubmittalDistributionMethods = null;
		}

		$arrAllSubmittalDistributionMethods = self::$_arrAllSubmittalDistributionMethods;
		if (isset($arrAllSubmittalDistributionMethods) && !empty($arrAllSubmittalDistributionMethods)) {
			return $arrAllSubmittalDistributionMethods;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_distribution_method` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDistributionMethod = new SubmittalDistributionMethod($database);
			$sqlOrderByColumns = $tmpSubmittalDistributionMethod->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sudm.*

FROM `submittal_distribution_methods` sudm{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_distribution_method` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittalDistributionMethods = array();
		while ($row = $db->fetch()) {
			$submittal_distribution_method_id = $row['id'];
			$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id);
			/* @var $submittalDistributionMethod SubmittalDistributionMethod */
			$arrAllSubmittalDistributionMethods[$submittal_distribution_method_id] = $submittalDistributionMethod;
		}

		$db->free_result();

		self::$_arrAllSubmittalDistributionMethods = $arrAllSubmittalDistributionMethods;

		return $arrAllSubmittalDistributionMethods;
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
INTO `submittal_distribution_methods`
(`submittal_distribution_method`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->submittal_distribution_method, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$submittal_distribution_method_id = $db->insertId;
		$db->free_result();

		return $submittal_distribution_method_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

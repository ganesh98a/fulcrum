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
 * JobsiteInspectionType.
 *
 * @category   Framework
 * @package    JobsiteInspectionType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteInspectionType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteInspectionType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_inspection_types';

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
	 * unique index `unique_jobsite_inspection_type` (`jobsite_inspection_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_inspection_type' => array(
			'jobsite_inspection_type' => 'string'
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
		'id' => 'jobsite_inspection_type_id',

		'jobsite_inspection_type' => 'jobsite_inspection_type',

		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_inspection_type_id;

	public $jobsite_inspection_type;

	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_inspection_type;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteInspectionTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_inspection_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteInspectionTypes()
	{
		if (isset(self::$_arrAllJobsiteInspectionTypes)) {
			return self::$_arrAllJobsiteInspectionTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteInspectionTypes($arrAllJobsiteInspectionTypes)
	{
		self::$_arrAllJobsiteInspectionTypes = $arrAllJobsiteInspectionTypes;
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
	 * @param int $jobsite_inspection_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_inspection_type_id, $table='jobsite_inspection_types', $module='JobsiteInspectionType')
	{
		$jobsiteInspectionType = parent::findById($database, $jobsite_inspection_type_id, $table, $module);

		return $jobsiteInspectionType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_inspection_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteInspectionTypeByIdExtended($database, $jobsite_inspection_type_id)
	{
		$jobsite_inspection_type_id = (int) $jobsite_inspection_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jit.*

FROM `jobsite_inspection_types` jit
WHERE jit.`id` = ?
";
		$arrValues = array($jobsite_inspection_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_inspection_type_id = $row['id'];
			$jobsiteInspectionType = self::instantiateOrm($database, 'JobsiteInspectionType', $row, null, $jobsite_inspection_type_id);
			/* @var $jobsiteInspectionType JobsiteInspectionType */
			$jobsiteInspectionType->convertPropertiesToData();

			return $jobsiteInspectionType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_inspection_type` (`jobsite_inspection_type`).
	 *
	 * @param string $database
	 * @param string $jobsite_inspection_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteInspectionType($database, $jobsite_inspection_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jit.*

FROM `jobsite_inspection_types` jit
WHERE jit.`jobsite_inspection_type` = ?
";
		$arrValues = array($jobsite_inspection_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_inspection_type_id = $row['id'];
			$jobsiteInspectionType = self::instantiateOrm($database, 'JobsiteInspectionType', $row, null, $jobsite_inspection_type_id);
			/* @var $jobsiteInspectionType JobsiteInspectionType */
			return $jobsiteInspectionType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteInspectionTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionTypesByArrJobsiteInspectionTypeIds($database, $arrJobsiteInspectionTypeIds, Input $options=null)
	{
		if (empty($arrJobsiteInspectionTypeIds)) {
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
		// ORDER BY `id` ASC, `jobsite_inspection_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspectionType = new JobsiteInspectionType($database);
			$sqlOrderByColumns = $tmpJobsiteInspectionType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteInspectionTypeIds as $k => $jobsite_inspection_type_id) {
			$jobsite_inspection_type_id = (int) $jobsite_inspection_type_id;
			$arrJobsiteInspectionTypeIds[$k] = $db->escape($jobsite_inspection_type_id);
		}
		$csvJobsiteInspectionTypeIds = join(',', $arrJobsiteInspectionTypeIds);

		$query =
"
SELECT

	jit.*

FROM `jobsite_inspection_types` jit
WHERE jit.`id` IN ($csvJobsiteInspectionTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteInspectionTypesByCsvJobsiteInspectionTypeIds = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_type_id = $row['id'];
			$jobsiteInspectionType = self::instantiateOrm($database, 'JobsiteInspectionType', $row, null, $jobsite_inspection_type_id);
			/* @var $jobsiteInspectionType JobsiteInspectionType */
			$jobsiteInspectionType->convertPropertiesToData();

			$arrJobsiteInspectionTypesByCsvJobsiteInspectionTypeIds[$jobsite_inspection_type_id] = $jobsiteInspectionType;
		}

		$db->free_result();

		return $arrJobsiteInspectionTypesByCsvJobsiteInspectionTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_inspection_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteInspectionTypes($database, Input $options=null)
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
			self::$_arrAllJobsiteInspectionTypes = null;
		}

		$arrAllJobsiteInspectionTypes = self::$_arrAllJobsiteInspectionTypes;
		if (isset($arrAllJobsiteInspectionTypes) && !empty($arrAllJobsiteInspectionTypes)) {
			return $arrAllJobsiteInspectionTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_inspection_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspectionType = new JobsiteInspectionType($database);
			$sqlOrderByColumns = $tmpJobsiteInspectionType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jit.*

FROM `jobsite_inspection_types` jit{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_inspection_type` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteInspectionTypes = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_type_id = $row['id'];
			$jobsiteInspectionType = self::instantiateOrm($database, 'JobsiteInspectionType', $row, null, $jobsite_inspection_type_id);
			/* @var $jobsiteInspectionType JobsiteInspectionType */
			$arrAllJobsiteInspectionTypes[$jobsite_inspection_type_id] = $jobsiteInspectionType;
		}

		$db->free_result();

		self::$_arrAllJobsiteInspectionTypes = $arrAllJobsiteInspectionTypes;

		return $arrAllJobsiteInspectionTypes;
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
INTO `jobsite_inspection_types`
(`jobsite_inspection_type`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->jobsite_inspection_type, $this->sort_order, $this->disabled_flag, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_inspection_type_id = $db->insertId;
		$db->free_result();

		return $jobsite_inspection_type_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

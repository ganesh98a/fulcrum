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
 * JobsiteNoteType.
 *
 * @category   Framework
 * @package    JobsiteNoteType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteNoteType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteNoteType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_note_types';

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
	 * unique index `unique_jobsite_note_type` (`jobsite_note_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_note_type' => array(
			'jobsite_note_type' => 'string'
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
		'id' => 'jobsite_note_type_id',

		'jobsite_note_type' => 'jobsite_note_type',

		'jobsite_note_type_label' => 'jobsite_note_type_label',
		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_note_type_id;

	public $jobsite_note_type;

	public $jobsite_note_type_label;
	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_note_type;
	public $escaped_jobsite_note_type_label;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteNoteTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_note_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteNoteTypes()
	{
		if (isset(self::$_arrAllJobsiteNoteTypes)) {
			return self::$_arrAllJobsiteNoteTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteNoteTypes($arrAllJobsiteNoteTypes)
	{
		self::$_arrAllJobsiteNoteTypes = $arrAllJobsiteNoteTypes;
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
	 * @param int $jobsite_note_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_note_type_id, $table='jobsite_note_types', $module='JobsiteNoteType')
	{
		$jobsiteNoteType = parent::findById($database, $jobsite_note_type_id, $table, $module);

		return $jobsiteNoteType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_note_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteNoteTypeByIdExtended($database, $jobsite_note_type_id)
	{
		$jobsite_note_type_id = (int) $jobsite_note_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jnt.*

FROM `jobsite_note_types` jnt
WHERE jnt.`id` = ?
";
		$arrValues = array($jobsite_note_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_note_type_id = $row['id'];
			$jobsiteNoteType = self::instantiateOrm($database, 'JobsiteNoteType', $row, null, $jobsite_note_type_id);
			/* @var $jobsiteNoteType JobsiteNoteType */
			$jobsiteNoteType->convertPropertiesToData();

			return $jobsiteNoteType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_note_type` (`jobsite_note_type`).
	 *
	 * @param string $database
	 * @param string $jobsite_note_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteNoteType($database, $jobsite_note_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jnt.*

FROM `jobsite_note_types` jnt
WHERE jnt.`jobsite_note_type` = ?
";
		$arrValues = array($jobsite_note_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_note_type_id = $row['id'];
			$jobsiteNoteType = self::instantiateOrm($database, 'JobsiteNoteType', $row, null, $jobsite_note_type_id);
			/* @var $jobsiteNoteType JobsiteNoteType */
			return $jobsiteNoteType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteNoteTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteNoteTypesByArrJobsiteNoteTypeIds($database, $arrJobsiteNoteTypeIds, Input $options=null)
	{
		if (empty($arrJobsiteNoteTypeIds)) {
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
		// ORDER BY `id` ASC, `jobsite_note_type` ASC, `jobsite_note_type_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jnt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteNoteType = new JobsiteNoteType($database);
			$sqlOrderByColumns = $tmpJobsiteNoteType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteNoteTypeIds as $k => $jobsite_note_type_id) {
			$jobsite_note_type_id = (int) $jobsite_note_type_id;
			$arrJobsiteNoteTypeIds[$k] = $db->escape($jobsite_note_type_id);
		}
		$csvJobsiteNoteTypeIds = join(',', $arrJobsiteNoteTypeIds);

		$query =
"
SELECT

	jnt.*

FROM `jobsite_note_types` jnt
WHERE jnt.`id` IN ($csvJobsiteNoteTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteNoteTypesByCsvJobsiteNoteTypeIds = array();
		while ($row = $db->fetch()) {
			$jobsite_note_type_id = $row['id'];
			$jobsiteNoteType = self::instantiateOrm($database, 'JobsiteNoteType', $row, null, $jobsite_note_type_id);
			/* @var $jobsiteNoteType JobsiteNoteType */
			$jobsiteNoteType->convertPropertiesToData();

			$arrJobsiteNoteTypesByCsvJobsiteNoteTypeIds[$jobsite_note_type_id] = $jobsiteNoteType;
		}

		$db->free_result();

		return $arrJobsiteNoteTypesByCsvJobsiteNoteTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_note_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteNoteTypes($database, Input $options=null)
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
			self::$_arrAllJobsiteNoteTypes = null;
		}

		$arrAllJobsiteNoteTypes = self::$_arrAllJobsiteNoteTypes;
		if (isset($arrAllJobsiteNoteTypes) && !empty($arrAllJobsiteNoteTypes)) {
			return $arrAllJobsiteNoteTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_note_type` ASC, `jobsite_note_type_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jnt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteNoteType = new JobsiteNoteType($database);
			$sqlOrderByColumns = $tmpJobsiteNoteType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jnt.*

FROM `jobsite_note_types` jnt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_note_type` ASC, `jobsite_note_type_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteNoteTypes = array();
		while ($row = $db->fetch()) {
			$jobsite_note_type_id = $row['id'];
			$jobsiteNoteType = self::instantiateOrm($database, 'JobsiteNoteType', $row, null, $jobsite_note_type_id);
			/* @var $jobsiteNoteType JobsiteNoteType */
			$arrAllJobsiteNoteTypes[$jobsite_note_type_id] = $jobsiteNoteType;
		}

		$db->free_result();

		self::$_arrAllJobsiteNoteTypes = $arrAllJobsiteNoteTypes;

		return $arrAllJobsiteNoteTypes;
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
INTO `jobsite_note_types`
(`jobsite_note_type`, `jobsite_note_type_label`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_note_type_label` = ?, `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->jobsite_note_type, $this->jobsite_note_type_label, $this->sort_order, $this->disabled_flag, $this->jobsite_note_type_label, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_note_type_id = $db->insertId;
		$db->free_result();

		return $jobsite_note_type_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

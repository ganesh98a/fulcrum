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
 * JobsiteInspectionNote.
 *
 * @category   Framework
 * @package    JobsiteInspectionNote
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteInspectionNote extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteInspectionNote';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_inspection_notes';

	/**
	 * primary key (`jobsite_inspection_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'jobsite_inspection_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_inspection_note_via_primary_key' => array(
			'jobsite_inspection_id' => 'int'
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
		'jobsite_inspection_id' => 'jobsite_inspection_id',

		'jobsite_inspection_note' => 'jobsite_inspection_note'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_inspection_id;

	public $jobsite_inspection_note;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_inspection_note;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteInspectionNotesByJobsiteInspectionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteInspectionNotes;

	// Foreign Key Objects
	private $_jobsiteInspection;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_inspection_notes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteInspection()
	{
		if (isset($this->_jobsiteInspection)) {
			return $this->_jobsiteInspection;
		} else {
			return null;
		}
	}

	public function setJobsiteInspection($jobsiteInspection)
	{
		$this->_jobsiteInspection = $jobsiteInspection;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteInspectionNotesByJobsiteInspectionId()
	{
		if (isset(self::$_arrJobsiteInspectionNotesByJobsiteInspectionId)) {
			return self::$_arrJobsiteInspectionNotesByJobsiteInspectionId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteInspectionNotesByJobsiteInspectionId($arrJobsiteInspectionNotesByJobsiteInspectionId)
	{
		self::$_arrJobsiteInspectionNotesByJobsiteInspectionId = $arrJobsiteInspectionNotesByJobsiteInspectionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteInspectionNotes()
	{
		if (isset(self::$_arrAllJobsiteInspectionNotes)) {
			return self::$_arrAllJobsiteInspectionNotes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteInspectionNotes($arrAllJobsiteInspectionNotes)
	{
		self::$_arrAllJobsiteInspectionNotes = $arrAllJobsiteInspectionNotes;
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
	 * Find by primary key (`jobsite_inspection_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_inspection_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteInspectionId($database, $jobsite_inspection_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jin.*

FROM `jobsite_inspection_notes` jin
WHERE jin.`jobsite_inspection_id` = ?
";
		$arrValues = array($jobsite_inspection_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteInspectionNote = self::instantiateOrm($database, 'JobsiteInspectionNote', $row);
			/* @var $jobsiteInspectionNote JobsiteInspectionNote */
			return $jobsiteInspectionNote;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`jobsite_inspection_id`) Extended.
	 *
	 * @param string $database
	 * @param int $jobsite_inspection_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteInspectionIdExtended($database, $jobsite_inspection_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jin_fk_ji.`id` AS 'jin_fk_ji__jobsite_inspection_id',
	jin_fk_ji.`jobsite_daily_log_id` AS 'jin_fk_ji__jobsite_daily_log_id',
	jin_fk_ji.`jobsite_inspection_type_id` AS 'jin_fk_ji__jobsite_inspection_type_id',
	jin_fk_ji.`inspector_contact_id` AS 'jin_fk_ji__inspector_contact_id',
	jin_fk_ji.`jobsite_building_id` AS 'jin_fk_ji__jobsite_building_id',
	jin_fk_ji.`jobsite_sitework_region_id` AS 'jin_fk_ji__jobsite_sitework_region_id',
	jin_fk_ji.`jobsite_inspection_passed_flag` AS 'jin_fk_ji__jobsite_inspection_passed_flag',

	jin.*

FROM `jobsite_inspection_notes` jin
	INNER JOIN `jobsite_inspections` jin_fk_ji ON jin.`jobsite_inspection_id` = jin_fk_ji.`id`
WHERE jin.`jobsite_inspection_id` = ?
";
		$arrValues = array($jobsite_inspection_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteInspectionNote = self::instantiateOrm($database, 'JobsiteInspectionNote', $row);
			/* @var $jobsiteInspectionNote JobsiteInspectionNote */
			$jobsiteInspectionNote->convertPropertiesToData();

			if (isset($row['jobsite_inspection_id'])) {
				$jobsite_inspection_id = $row['jobsite_inspection_id'];
				$row['jin_fk_ji__id'] = $jobsite_inspection_id;
				$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id, 'jin_fk_ji__');
				/* @var $jobsiteInspection JobsiteInspection */
				$jobsiteInspection->convertPropertiesToData();
			} else {
				$jobsiteInspection = false;
			}
			$jobsiteInspectionNote->setJobsiteInspection($jobsiteInspection);

			return $jobsiteInspectionNote;
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
	 * @param array $arrJobsiteInspectionIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionNotesByArrJobsiteInspectionIdList($database, $arrJobsiteInspectionIdList, Input $options=null)
	{
		if (empty($arrJobsiteInspectionIdList)) {
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
		// ORDER BY `jobsite_inspection_id` ASC, `jobsite_inspection_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspectionNote = new JobsiteInspectionNote($database);
			$sqlOrderByColumns = $tmpJobsiteInspectionNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrJobsiteInspectionIdList as $k => $arrTmp) {
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
		if (count($arrJobsiteInspectionIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	jin.*

FROM `jobsite_inspection_notes` jin
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteInspectionNotesByArrJobsiteInspectionIdList = array();
		while ($row = $db->fetch()) {
			$jobsiteInspectionNote = self::instantiateOrm($database, 'JobsiteInspectionNote', $row);
			/* @var $jobsiteInspectionNote JobsiteInspectionNote */
			$arrJobsiteInspectionNotesByArrJobsiteInspectionIdList[] = $jobsiteInspectionNote;
		}

		$db->free_result();

		return $arrJobsiteInspectionNotesByArrJobsiteInspectionIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_inspection_notes_fk_ji` foreign key (`jobsite_inspection_id`) references `jobsite_inspections` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_inspection_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionNotesByJobsiteInspectionId($database, $jobsite_inspection_id, Input $options=null)
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
			self::$_arrJobsiteInspectionNotesByJobsiteInspectionId = null;
		}

		$arrJobsiteInspectionNotesByJobsiteInspectionId = self::$_arrJobsiteInspectionNotesByJobsiteInspectionId;
		if (isset($arrJobsiteInspectionNotesByJobsiteInspectionId) && !empty($arrJobsiteInspectionNotesByJobsiteInspectionId)) {
			return $arrJobsiteInspectionNotesByJobsiteInspectionId;
		}

		$jobsite_inspection_id = (int) $jobsite_inspection_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_inspection_id` ASC, `jobsite_inspection_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspectionNote = new JobsiteInspectionNote($database);
			$sqlOrderByColumns = $tmpJobsiteInspectionNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jin.*

FROM `jobsite_inspection_notes` jin
WHERE jin.`jobsite_inspection_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_inspection_id` ASC, `jobsite_inspection_note` ASC
		$arrValues = array($jobsite_inspection_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteInspectionNotesByJobsiteInspectionId = array();
		while ($row = $db->fetch()) {
			$jobsiteInspectionNote = self::instantiateOrm($database, 'JobsiteInspectionNote', $row);
			/* @var $jobsiteInspectionNote JobsiteInspectionNote */
			$arrJobsiteInspectionNotesByJobsiteInspectionId[] = $jobsiteInspectionNote;
		}

		$db->free_result();

		self::$_arrJobsiteInspectionNotesByJobsiteInspectionId = $arrJobsiteInspectionNotesByJobsiteInspectionId;

		return $arrJobsiteInspectionNotesByJobsiteInspectionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_inspection_notes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteInspectionNotes($database, Input $options=null)
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
			self::$_arrAllJobsiteInspectionNotes = null;
		}

		$arrAllJobsiteInspectionNotes = self::$_arrAllJobsiteInspectionNotes;
		if (isset($arrAllJobsiteInspectionNotes) && !empty($arrAllJobsiteInspectionNotes)) {
			return $arrAllJobsiteInspectionNotes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_inspection_id` ASC, `jobsite_inspection_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspectionNote = new JobsiteInspectionNote($database);
			$sqlOrderByColumns = $tmpJobsiteInspectionNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jin.*

FROM `jobsite_inspection_notes` jin{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_inspection_id` ASC, `jobsite_inspection_note` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteInspectionNotes = array();
		while ($row = $db->fetch()) {
			$jobsiteInspectionNote = self::instantiateOrm($database, 'JobsiteInspectionNote', $row);
			/* @var $jobsiteInspectionNote JobsiteInspectionNote */
			$arrAllJobsiteInspectionNotes[] = $jobsiteInspectionNote;
		}

		$db->free_result();

		self::$_arrAllJobsiteInspectionNotes = $arrAllJobsiteInspectionNotes;

		return $arrAllJobsiteInspectionNotes;
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
INTO `jobsite_inspection_notes`
(`jobsite_inspection_id`, `jobsite_inspection_note`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `jobsite_inspection_note` = ?
";
		$arrValues = array($this->jobsite_inspection_id, $this->jobsite_inspection_note, $this->jobsite_inspection_note);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_inspection_note_id = $db->insertId;
		$db->free_result();

		return $jobsite_inspection_note_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

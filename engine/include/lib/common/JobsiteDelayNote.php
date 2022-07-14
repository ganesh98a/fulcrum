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
 * JobsiteDelayNote.
 *
 * @category   Framework
 * @package    JobsiteDelayNote
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteDelayNote extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteDelayNote';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_delay_notes';

	/**
	 * primary key (`jobsite_delay_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'jobsite_delay_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_delay_note_via_primary_key' => array(
			'jobsite_delay_id' => 'int'
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
		'jobsite_delay_id' => 'jobsite_delay_id',

		'jobsite_delay_note' => 'jobsite_delay_note'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_delay_id;

	public $jobsite_delay_note;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_delay_note;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_delay_note_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteDelayNotesByJobsiteDelayId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteDelayNotes;

	// Foreign Key Objects
	private $_jobsiteDelay;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_delay_notes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteDelay()
	{
		if (isset($this->_jobsiteDelay)) {
			return $this->_jobsiteDelay;
		} else {
			return null;
		}
	}

	public function setJobsiteDelay($jobsiteDelay)
	{
		$this->_jobsiteDelay = $jobsiteDelay;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteDelayNotesByJobsiteDelayId()
	{
		if (isset(self::$_arrJobsiteDelayNotesByJobsiteDelayId)) {
			return self::$_arrJobsiteDelayNotesByJobsiteDelayId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDelayNotesByJobsiteDelayId($arrJobsiteDelayNotesByJobsiteDelayId)
	{
		self::$_arrJobsiteDelayNotesByJobsiteDelayId = $arrJobsiteDelayNotesByJobsiteDelayId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteDelayNotes()
	{
		if (isset(self::$_arrAllJobsiteDelayNotes)) {
			return self::$_arrAllJobsiteDelayNotes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteDelayNotes($arrAllJobsiteDelayNotes)
	{
		self::$_arrAllJobsiteDelayNotes = $arrAllJobsiteDelayNotes;
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
	 * Find by primary key (`jobsite_delay_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_delay_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDelayId($database, $jobsite_delay_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jdn.*

FROM `jobsite_delay_notes` jdn
WHERE jdn.`jobsite_delay_id` = ?
";
		$arrValues = array($jobsite_delay_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteDelayNote = self::instantiateOrm($database, 'JobsiteDelayNote', $row);
			/* @var $jobsiteDelayNote JobsiteDelayNote */
			return $jobsiteDelayNote;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`jobsite_delay_id`) Extended.
	 *
	 * @param string $database
	 * @param int $jobsite_delay_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDelayIdExtended($database, $jobsite_delay_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jdn_fk_jd.`id` AS 'jdn_fk_jd__jobsite_delay_id',
	jdn_fk_jd.`jobsite_daily_log_id` AS 'jdn_fk_jd__jobsite_daily_log_id',
	jdn_fk_jd.`jobsite_delay_subcategory_id` AS 'jdn_fk_jd__jobsite_delay_subcategory_id',
	jdn_fk_jd.`jobsite_building_id` AS 'jdn_fk_jd__jobsite_building_id',
	jdn_fk_jd.`jobsite_sitework_region_id` AS 'jdn_fk_jd__jobsite_sitework_region_id',

	jdn.*

FROM `jobsite_delay_notes` jdn
	INNER JOIN `jobsite_delays` jdn_fk_jd ON jdn.`jobsite_delay_id` = jdn_fk_jd.`id`
WHERE jdn.`jobsite_delay_id` = ?
";
		$arrValues = array($jobsite_delay_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteDelayNote = self::instantiateOrm($database, 'JobsiteDelayNote', $row);
			/* @var $jobsiteDelayNote JobsiteDelayNote */
			$jobsiteDelayNote->convertPropertiesToData();

			if (isset($row['jobsite_delay_id'])) {
				$jobsite_delay_id = $row['jobsite_delay_id'];
				$row['jdn_fk_jd__id'] = $jobsite_delay_id;
				$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id, 'jdn_fk_jd__');
				/* @var $jobsiteDelay JobsiteDelay */
				$jobsiteDelay->convertPropertiesToData();
			} else {
				$jobsiteDelay = false;
			}
			$jobsiteDelayNote->setJobsiteDelay($jobsiteDelay);

			return $jobsiteDelayNote;
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
	 * @param array $arrJobsiteDelayIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelayNotesByArrJobsiteDelayIdList($database, $arrJobsiteDelayIdList, Input $options=null)
	{
		if (empty($arrJobsiteDelayIdList)) {
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
		// ORDER BY `jobsite_delay_id` ASC, `jobsite_delay_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelayNote = new JobsiteDelayNote($database);
			$sqlOrderByColumns = $tmpJobsiteDelayNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrJobsiteDelayIdList as $k => $arrTmp) {
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
		if (count($arrJobsiteDelayIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	jdn.*

FROM `jobsite_delay_notes` jdn
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelayNotesByArrJobsiteDelayIdList = array();
		while ($row = $db->fetch()) {
			$jobsiteDelayNote = self::instantiateOrm($database, 'JobsiteDelayNote', $row);
			/* @var $jobsiteDelayNote JobsiteDelayNote */
			$arrJobsiteDelayNotesByArrJobsiteDelayIdList[] = $jobsiteDelayNote;
		}

		$db->free_result();

		return $arrJobsiteDelayNotesByArrJobsiteDelayIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_delay_notes_fk_jd` foreign key (`jobsite_delay_id`) references `jobsite_delays` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_delay_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelayNotesByJobsiteDelayId($database, $jobsite_delay_id, Input $options=null)
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
			self::$_arrJobsiteDelayNotesByJobsiteDelayId = null;
		}

		$arrJobsiteDelayNotesByJobsiteDelayId = self::$_arrJobsiteDelayNotesByJobsiteDelayId;
		if (isset($arrJobsiteDelayNotesByJobsiteDelayId) && !empty($arrJobsiteDelayNotesByJobsiteDelayId)) {
			return $arrJobsiteDelayNotesByJobsiteDelayId;
		}

		$jobsite_delay_id = (int) $jobsite_delay_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_delay_id` ASC, `jobsite_delay_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelayNote = new JobsiteDelayNote($database);
			$sqlOrderByColumns = $tmpJobsiteDelayNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdn.*

FROM `jobsite_delay_notes` jdn
WHERE jdn.`jobsite_delay_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_delay_id` ASC, `jobsite_delay_note` ASC
		$arrValues = array($jobsite_delay_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelayNotesByJobsiteDelayId = array();
		while ($row = $db->fetch()) {
			$jobsiteDelayNote = self::instantiateOrm($database, 'JobsiteDelayNote', $row);
			/* @var $jobsiteDelayNote JobsiteDelayNote */
			$arrJobsiteDelayNotesByJobsiteDelayId[] = $jobsiteDelayNote;
		}

		$db->free_result();

		self::$_arrJobsiteDelayNotesByJobsiteDelayId = $arrJobsiteDelayNotesByJobsiteDelayId;

		return $arrJobsiteDelayNotesByJobsiteDelayId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_delay_notes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteDelayNotes($database, Input $options=null)
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
			self::$_arrAllJobsiteDelayNotes = null;
		}

		$arrAllJobsiteDelayNotes = self::$_arrAllJobsiteDelayNotes;
		if (isset($arrAllJobsiteDelayNotes) && !empty($arrAllJobsiteDelayNotes)) {
			return $arrAllJobsiteDelayNotes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_delay_id` ASC, `jobsite_delay_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelayNote = new JobsiteDelayNote($database);
			$sqlOrderByColumns = $tmpJobsiteDelayNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdn.*

FROM `jobsite_delay_notes` jdn{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_delay_id` ASC, `jobsite_delay_note` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteDelayNotes = array();
		while ($row = $db->fetch()) {
			$jobsiteDelayNote = self::instantiateOrm($database, 'JobsiteDelayNote', $row);
			/* @var $jobsiteDelayNote JobsiteDelayNote */
			$arrAllJobsiteDelayNotes[] = $jobsiteDelayNote;
		}

		$db->free_result();

		self::$_arrAllJobsiteDelayNotes = $arrAllJobsiteDelayNotes;

		return $arrAllJobsiteDelayNotes;
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
INTO `jobsite_delay_notes`
(`jobsite_delay_id`, `jobsite_delay_note`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `jobsite_delay_note` = ?
";
		$arrValues = array($this->jobsite_delay_id, $this->jobsite_delay_note, $this->jobsite_delay_note);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_delay_note_id = $db->insertId;
		$db->free_result();

		return $jobsite_delay_note_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

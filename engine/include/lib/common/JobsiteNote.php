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
 * JobsiteNote.
 *
 * @category   Framework
 * @package    JobsiteNote
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteNote extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteNote';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_notes';

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
	 * unique index `unique_jobsite_note` (`jobsite_daily_log_id`,`jobsite_note_type_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_note' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_note_type_id' => 'int'
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
		'id' => 'jobsite_note_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_note_type_id' => 'jobsite_note_type_id',

		'jobsite_note' => 'jobsite_note'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_note_id;

	public $jobsite_daily_log_id;
	public $jobsite_note_type_id;

	public $jobsite_note;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_note;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_note_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteNotesByJobsiteDailyLogId;
	protected static $_arrJobsiteNotesByJobsiteNoteTypeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteNotes;

	protected static $_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteNoteType;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_notes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteDailyLog()
	{
		if (isset($this->_jobsiteDailyLog)) {
			return $this->_jobsiteDailyLog;
		} else {
			return null;
		}
	}

	public function setJobsiteDailyLog($jobsiteDailyLog)
	{
		$this->_jobsiteDailyLog = $jobsiteDailyLog;
	}

	public function getJobsiteNoteType()
	{
		if (isset($this->_jobsiteNoteType)) {
			return $this->_jobsiteNoteType;
		} else {
			return null;
		}
	}

	public function setJobsiteNoteType($jobsiteNoteType)
	{
		$this->_jobsiteNoteType = $jobsiteNoteType;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteNotesByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteNotesByJobsiteDailyLogId)) {
			return self::$_arrJobsiteNotesByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteNotesByJobsiteDailyLogId($arrJobsiteNotesByJobsiteDailyLogId)
	{
		self::$_arrJobsiteNotesByJobsiteDailyLogId = $arrJobsiteNotesByJobsiteDailyLogId;
	}

	public static function getArrJobsiteNotesByJobsiteNoteTypeId()
	{
		if (isset(self::$_arrJobsiteNotesByJobsiteNoteTypeId)) {
			return self::$_arrJobsiteNotesByJobsiteNoteTypeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteNotesByJobsiteNoteTypeId($arrJobsiteNotesByJobsiteNoteTypeId)
	{
		self::$_arrJobsiteNotesByJobsiteNoteTypeId = $arrJobsiteNotesByJobsiteNoteTypeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteNotes()
	{
		if (isset(self::$_arrAllJobsiteNotes)) {
			return self::$_arrAllJobsiteNotes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteNotes($arrAllJobsiteNotes)
	{
		self::$_arrAllJobsiteNotes = $arrAllJobsiteNotes;
	}

	public static function getArrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId()
	{
		if (isset(self::$_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId)) {
			return self::$_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId($arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId)
	{
		self::$_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId = $arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId;
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
	 * @param int $jobsite_note_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_note_id, $table='jobsite_notes', $module='JobsiteNote')
	{
		$jobsiteNote = parent::findById($database, $jobsite_note_id, $table, $module);

		return $jobsiteNote;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_note_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteNoteByIdExtended($database, $jobsite_note_id)
	{
		$jobsite_note_id = (int) $jobsite_note_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jn_fk_jdl.`id` AS 'jn_fk_jdl__jobsite_daily_log_id',
	jn_fk_jdl.`project_id` AS 'jn_fk_jdl__project_id',
	jn_fk_jdl.`modified_by_contact_id` AS 'jn_fk_jdl__modified_by_contact_id',
	jn_fk_jdl.`created_by_contact_id` AS 'jn_fk_jdl__created_by_contact_id',
	jn_fk_jdl.`modified` AS 'jn_fk_jdl__modified',
	jn_fk_jdl.`jobsite_daily_log_created_date` AS 'jn_fk_jdl__jobsite_daily_log_created_date',

	jn_fk_jnt.`id` AS 'jn_fk_jnt__jobsite_note_type_id',
	jn_fk_jnt.`jobsite_note_type` AS 'jn_fk_jnt__jobsite_note_type',
	jn_fk_jnt.`jobsite_note_type_label` AS 'jn_fk_jnt__jobsite_note_type_label',
	jn_fk_jnt.`sort_order` AS 'jn_fk_jnt__sort_order',
	jn_fk_jnt.`disabled_flag` AS 'jn_fk_jnt__disabled_flag',

	jn.*

FROM `jobsite_notes` jn
	INNER JOIN `jobsite_daily_logs` jn_fk_jdl ON jn.`jobsite_daily_log_id` = jn_fk_jdl.`id`
	INNER JOIN `jobsite_note_types` jn_fk_jnt ON jn.`jobsite_note_type_id` = jn_fk_jnt.`id`
WHERE jn.`id` = ?
";
		$arrValues = array($jobsite_note_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_note_id = $row['id'];
			$jobsiteNote = self::instantiateOrm($database, 'JobsiteNote', $row, null, $jobsite_note_id);
			/* @var $jobsiteNote JobsiteNote */
			$jobsiteNote->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jn_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jn_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteNote->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_note_type_id'])) {
				$jobsite_note_type_id = $row['jobsite_note_type_id'];
				$row['jn_fk_jnt__id'] = $jobsite_note_type_id;
				$jobsiteNoteType = self::instantiateOrm($database, 'JobsiteNoteType', $row, null, $jobsite_note_type_id, 'jn_fk_jnt__');
				/* @var $jobsiteNoteType JobsiteNoteType */
				$jobsiteNoteType->convertPropertiesToData();
			} else {
				$jobsiteNoteType = false;
			}
			$jobsiteNote->setJobsiteNoteType($jobsiteNoteType);

			return $jobsiteNote;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_note` (`jobsite_daily_log_id`,`jobsite_note_type_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_note_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteNoteTypeId($database, $jobsite_daily_log_id, $jobsite_note_type_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jn.*

FROM `jobsite_notes` jn
WHERE jn.`jobsite_daily_log_id` = ?
AND jn.`jobsite_note_type_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_note_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_note_id = $row['id'];
			$jobsiteNote = self::instantiateOrm($database, 'JobsiteNote', $row, null, $jobsite_note_id);
			/* @var $jobsiteNote JobsiteNote */
			return $jobsiteNote;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteNoteIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteNotesByArrJobsiteNoteIds($database, $arrJobsiteNoteIds, Input $options=null)
	{
		if (empty($arrJobsiteNoteIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteNote = new JobsiteNote($database);
			$sqlOrderByColumns = $tmpJobsiteNote->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteNoteIds as $k => $jobsite_note_id) {
			$jobsite_note_id = (int) $jobsite_note_id;
			$arrJobsiteNoteIds[$k] = $db->escape($jobsite_note_id);
		}
		$csvJobsiteNoteIds = join(',', $arrJobsiteNoteIds);

		$query =
"
SELECT

	jn.*

FROM `jobsite_notes` jn
WHERE jn.`id` IN ($csvJobsiteNoteIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteNotesByCsvJobsiteNoteIds = array();
		while ($row = $db->fetch()) {
			$jobsite_note_id = $row['id'];
			$jobsiteNote = self::instantiateOrm($database, 'JobsiteNote', $row, null, $jobsite_note_id);
			/* @var $jobsiteNote JobsiteNote */
			$jobsiteNote->convertPropertiesToData();

			$arrJobsiteNotesByCsvJobsiteNoteIds[$jobsite_note_id] = $jobsiteNote;
		}

		$db->free_result();

		return $arrJobsiteNotesByCsvJobsiteNoteIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_notes_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteNotesByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteNotesByJobsiteDailyLogId = null;
		}

		$arrJobsiteNotesByJobsiteDailyLogId = self::$_arrJobsiteNotesByJobsiteDailyLogId;
		if (isset($arrJobsiteNotesByJobsiteDailyLogId) && !empty($arrJobsiteNotesByJobsiteDailyLogId)) {
			return $arrJobsiteNotesByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteNote = new JobsiteNote($database);
			$sqlOrderByColumns = $tmpJobsiteNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jn.*

FROM `jobsite_notes` jn
WHERE jn.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteNotesByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_note_id = $row['id'];
			$jobsiteNote = self::instantiateOrm($database, 'JobsiteNote', $row, null, $jobsite_note_id);
			/* @var $jobsiteNote JobsiteNote */
			$arrJobsiteNotesByJobsiteDailyLogId[$jobsite_note_id] = $jobsiteNote;
		}

		$db->free_result();

		self::$_arrJobsiteNotesByJobsiteDailyLogId = $arrJobsiteNotesByJobsiteDailyLogId;

		return $arrJobsiteNotesByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `jobsite_notes_fk_jnt` foreign key (`jobsite_note_type_id`) references `jobsite_note_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_note_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteNotesByJobsiteNoteTypeId($database, $jobsite_note_type_id, Input $options=null)
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
			self::$_arrJobsiteNotesByJobsiteNoteTypeId = null;
		}

		$arrJobsiteNotesByJobsiteNoteTypeId = self::$_arrJobsiteNotesByJobsiteNoteTypeId;
		if (isset($arrJobsiteNotesByJobsiteNoteTypeId) && !empty($arrJobsiteNotesByJobsiteNoteTypeId)) {
			return $arrJobsiteNotesByJobsiteNoteTypeId;
		}

		$jobsite_note_type_id = (int) $jobsite_note_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteNote = new JobsiteNote($database);
			$sqlOrderByColumns = $tmpJobsiteNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jn.*

FROM `jobsite_notes` jn
WHERE jn.`jobsite_note_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$arrValues = array($jobsite_note_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteNotesByJobsiteNoteTypeId = array();
		while ($row = $db->fetch()) {
			$jobsite_note_id = $row['id'];
			$jobsiteNote = self::instantiateOrm($database, 'JobsiteNote', $row, null, $jobsite_note_id);
			/* @var $jobsiteNote JobsiteNote */
			$arrJobsiteNotesByJobsiteNoteTypeId[$jobsite_note_id] = $jobsiteNote;
		}

		$db->free_result();

		self::$_arrJobsiteNotesByJobsiteNoteTypeId = $arrJobsiteNotesByJobsiteNoteTypeId;

		return $arrJobsiteNotesByJobsiteNoteTypeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_notes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteNotes($database, Input $options=null)
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
			self::$_arrAllJobsiteNotes = null;
		}

		$arrAllJobsiteNotes = self::$_arrAllJobsiteNotes;
		if (isset($arrAllJobsiteNotes) && !empty($arrAllJobsiteNotes)) {
			return $arrAllJobsiteNotes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteNote = new JobsiteNote($database);
			$sqlOrderByColumns = $tmpJobsiteNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jn.*

FROM `jobsite_notes` jn{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteNotes = array();
		while ($row = $db->fetch()) {
			$jobsite_note_id = $row['id'];
			$jobsiteNote = self::instantiateOrm($database, 'JobsiteNote', $row, null, $jobsite_note_id);
			/* @var $jobsiteNote JobsiteNote */
			$arrAllJobsiteNotes[$jobsite_note_id] = $jobsiteNote;
		}

		$db->free_result();

		self::$_arrAllJobsiteNotes = $arrAllJobsiteNotes;

		return $arrAllJobsiteNotes;
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
INTO `jobsite_notes`
(`jobsite_daily_log_id`, `jobsite_note_type_id`, `jobsite_note`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_note` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_note_type_id, $this->jobsite_note, $this->jobsite_note);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_note_id = $db->insertId;
		$db->free_result();

		return $jobsite_note_id;
	}

	// Save: insert ignore

	/**
	 * Load by constraint `jobsite_notes_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId = null;
		}

		$arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId = self::$_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId;
		if (isset($arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId) && !empty($arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId)) {
			return $arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteNote = new JobsiteNote($database);
			$sqlOrderByColumns = $tmpJobsiteNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jn.*
FROM `jobsite_notes` jn
WHERE jn.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_note_type_id` ASC, `jobsite_note` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId = array();
		while ($row = $db->fetch()) {
			$jobsite_note_id = $row['id'];
			$jobsite_note_type_id = $row['jobsite_note_type_id'];
			$jobsiteNote = self::instantiateOrm($database, 'JobsiteNote', $row, null, $jobsite_note_id);
			/* @var $jobsiteNote JobsiteNote */
			$arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId[$jobsite_note_type_id][$jobsite_note_id] = $jobsiteNote;
		}

		$db->free_result();

		self::$_arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId = $arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId;

		return $arrJobsiteNotesByJobsiteDailyLogIdGroupedByJobsiteNoteTypeId;
	}

	public function save()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT
INTO `jobsite_notes`
(`jobsite_daily_log_id`, `jobsite_note_type_id`, `jobsite_note`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_note` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_note_type_id, $this->jobsite_note, $this->jobsite_note);
		$db->begin();
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->commit();
		$jobsite_note_id = $db->insertId;
		$db->free_result();

		return $jobsite_note_id;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

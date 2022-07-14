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
 * JobsiteDailyOffsiteworkActivityLog.
 *
 * @category   Framework
 * @package    JobsiteDailyOffsiteworkActivityLog
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteDailyOffsiteworkActivityLog extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteDailyOffsiteworkActivityLog';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_daily_offsitework_activity_logs';

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
	 * unique index `unique_jobsite_daily_offsitework_activity_log` (`jobsite_daily_log_id`,`jobsite_offsitework_activity_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_daily_offsitework_activity_log' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_offsitework_activity_id' => 'int'
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
		'id' => 'jobsite_daily_offsitework_activity_log_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_offsitework_activity_id' => 'jobsite_offsitework_activity_id',

		'jobsite_offsitework_region_id' => 'jobsite_offsitework_region_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_daily_offsitework_activity_log_id;

	public $jobsite_daily_log_id;
	public $jobsite_offsitework_activity_id;

	public $jobsite_offsitework_region_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId;
	protected static $_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId;
	protected static $_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteDailyOffsiteworkActivityLogs;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteOffsiteworkActivity;
	private $_jobsiteOffsiteworkRegion;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_daily_offsitework_activity_logs')
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

	public function getJobsiteOffsiteworkActivity()
	{
		if (isset($this->_jobsiteOffsiteworkActivity)) {
			return $this->_jobsiteOffsiteworkActivity;
		} else {
			return null;
		}
	}

	public function setJobsiteOffsiteworkActivity($jobsiteOffsiteworkActivity)
	{
		$this->_jobsiteOffsiteworkActivity = $jobsiteOffsiteworkActivity;
	}

	public function getJobsiteOffsiteworkRegion()
	{
		if (isset($this->_jobsiteOffsiteworkRegion)) {
			return $this->_jobsiteOffsiteworkRegion;
		} else {
			return null;
		}
	}

	public function setJobsiteOffsiteworkRegion($jobsiteOffsiteworkRegion)
	{
		$this->_jobsiteOffsiteworkRegion = $jobsiteOffsiteworkRegion;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId)) {
			return self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId)
	{
		self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId = $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId;
	}

	public static function getArrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId()
	{
		if (isset(self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId)) {
			return self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId)
	{
		self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId = $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId;
	}

	public static function getArrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId()
	{
		if (isset(self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId)) {
			return self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId)
	{
		self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId = $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteDailyOffsiteworkActivityLogs()
	{
		if (isset(self::$_arrAllJobsiteDailyOffsiteworkActivityLogs)) {
			return self::$_arrAllJobsiteDailyOffsiteworkActivityLogs;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteDailyOffsiteworkActivityLogs($arrAllJobsiteDailyOffsiteworkActivityLogs)
	{
		self::$_arrAllJobsiteDailyOffsiteworkActivityLogs = $arrAllJobsiteDailyOffsiteworkActivityLogs;
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
	 * @param int $jobsite_daily_offsitework_activity_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_daily_offsitework_activity_log_id, $table='jobsite_daily_offsitework_activity_logs', $module='JobsiteDailyOffsiteworkActivityLog')
	{
		$jobsiteDailyOffsiteworkActivityLog = parent::findById($database, $jobsite_daily_offsitework_activity_log_id, $table, $module);

		return $jobsiteDailyOffsiteworkActivityLog;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_offsitework_activity_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteDailyOffsiteworkActivityLogByIdExtended($database, $jobsite_daily_offsitework_activity_log_id)
	{
		$jobsite_daily_offsitework_activity_log_id = (int) $jobsite_daily_offsitework_activity_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jdoal_fk_jdl.`id` AS 'jdoal_fk_jdl__jobsite_daily_log_id',
	jdoal_fk_jdl.`project_id` AS 'jdoal_fk_jdl__project_id',
	jdoal_fk_jdl.`modified_by_contact_id` AS 'jdoal_fk_jdl__modified_by_contact_id',
	jdoal_fk_jdl.`created_by_contact_id` AS 'jdoal_fk_jdl__created_by_contact_id',
	jdoal_fk_jdl.`modified` AS 'jdoal_fk_jdl__modified',
	jdoal_fk_jdl.`jobsite_daily_log_created_date` AS 'jdoal_fk_jdl__jobsite_daily_log_created_date',

	jdoal_fk_joa.`id` AS 'jdoal_fk_joa__jobsite_offsitework_activity_id',
	jdoal_fk_joa.`project_id` AS 'jdoal_fk_joa__project_id',
	jdoal_fk_joa.`jobsite_offsitework_activity_label` AS 'jdoal_fk_joa__jobsite_offsitework_activity_label',
	jdoal_fk_joa.`sort_order` AS 'jdoal_fk_joa__sort_order',
	jdoal_fk_joa.`disabled_flag` AS 'jdoal_fk_joa__disabled_flag',

	jdoal_fk_jor.`id` AS 'jdoal_fk_jor__jobsite_offsitework_region_id',
	jdoal_fk_jor.`project_id` AS 'jdoal_fk_jor__project_id',
	jdoal_fk_jor.`jobsite_offsitework_region` AS 'jdoal_fk_jor__jobsite_offsitework_region',
	jdoal_fk_jor.`jobsite_offsitework_region_description` AS 'jdoal_fk_jor__jobsite_offsitework_region_description',
	jdoal_fk_jor.`sort_order` AS 'jdoal_fk_jor__sort_order',
	jdoal_fk_jor.`disabled_flag` AS 'jdoal_fk_jor__disabled_flag',

	jdoal.*

FROM `jobsite_daily_offsitework_activity_logs` jdoal
	INNER JOIN `jobsite_daily_logs` jdoal_fk_jdl ON jdoal.`jobsite_daily_log_id` = jdoal_fk_jdl.`id`
	INNER JOIN `jobsite_offsitework_activities` jdoal_fk_joa ON jdoal.`jobsite_offsitework_activity_id` = jdoal_fk_joa.`id`
	LEFT OUTER JOIN `jobsite_offsitework_regions` jdoal_fk_jor ON jdoal.`jobsite_offsitework_region_id` = jdoal_fk_jor.`id`
WHERE jdoal.`id` = ?
";
		$arrValues = array($jobsite_daily_offsitework_activity_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_daily_offsitework_activity_log_id = $row['id'];
			$jobsiteDailyOffsiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailyOffsiteworkActivityLog', $row, null, $jobsite_daily_offsitework_activity_log_id);
			/* @var $jobsiteDailyOffsiteworkActivityLog JobsiteDailyOffsiteworkActivityLog */
			$jobsiteDailyOffsiteworkActivityLog->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jdoal_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jdoal_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteDailyOffsiteworkActivityLog->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_offsitework_activity_id'])) {
				$jobsite_offsitework_activity_id = $row['jobsite_offsitework_activity_id'];
				$row['jdoal_fk_joa__id'] = $jobsite_offsitework_activity_id;
				$jobsiteOffsiteworkActivity = self::instantiateOrm($database, 'JobsiteOffsiteworkActivity', $row, null, $jobsite_offsitework_activity_id, 'jdoal_fk_joa__');
				/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */
				$jobsiteOffsiteworkActivity->convertPropertiesToData();
			} else {
				$jobsiteOffsiteworkActivity = false;
			}
			$jobsiteDailyOffsiteworkActivityLog->setJobsiteOffsiteworkActivity($jobsiteOffsiteworkActivity);

			if (isset($row['jobsite_offsitework_region_id'])) {
				$jobsite_offsitework_region_id = $row['jobsite_offsitework_region_id'];
				$row['jdoal_fk_jor__id'] = $jobsite_offsitework_region_id;
				$jobsiteOffsiteworkRegion = self::instantiateOrm($database, 'JobsiteOffsiteworkRegion', $row, null, $jobsite_offsitework_region_id, 'jdoal_fk_jor__');
				/* @var $jobsiteOffsiteworkRegion JobsiteOffsiteworkRegion */
				$jobsiteOffsiteworkRegion->convertPropertiesToData();
			} else {
				$jobsiteOffsiteworkRegion = false;
			}
			$jobsiteDailyOffsiteworkActivityLog->setJobsiteOffsiteworkRegion($jobsiteOffsiteworkRegion);

			return $jobsiteDailyOffsiteworkActivityLog;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_daily_offsitework_activity_log` (`jobsite_daily_log_id`,`jobsite_offsitework_activity_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_offsitework_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteOffsiteworkActivityId($database, $jobsite_daily_log_id, $jobsite_offsitework_activity_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jdoal.*

FROM `jobsite_daily_offsitework_activity_logs` jdoal
WHERE jdoal.`jobsite_daily_log_id` = ?
AND jdoal.`jobsite_offsitework_activity_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_offsitework_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_daily_offsitework_activity_log_id = $row['id'];
			$jobsiteDailyOffsiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailyOffsiteworkActivityLog', $row, null, $jobsite_daily_offsitework_activity_log_id);
			/* @var $jobsiteDailyOffsiteworkActivityLog JobsiteDailyOffsiteworkActivityLog */
			return $jobsiteDailyOffsiteworkActivityLog;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteDailyOffsiteworkActivityLogIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyOffsiteworkActivityLogsByArrJobsiteDailyOffsiteworkActivityLogIds($database, $arrJobsiteDailyOffsiteworkActivityLogIds, Input $options=null)
	{
		if (empty($arrJobsiteDailyOffsiteworkActivityLogIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyOffsiteworkActivityLog = new JobsiteDailyOffsiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyOffsiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteDailyOffsiteworkActivityLogIds as $k => $jobsite_daily_offsitework_activity_log_id) {
			$jobsite_daily_offsitework_activity_log_id = (int) $jobsite_daily_offsitework_activity_log_id;
			$arrJobsiteDailyOffsiteworkActivityLogIds[$k] = $db->escape($jobsite_daily_offsitework_activity_log_id);
		}
		$csvJobsiteDailyOffsiteworkActivityLogIds = join(',', $arrJobsiteDailyOffsiteworkActivityLogIds);

		$query =
"
SELECT

	jdoal.*

FROM `jobsite_daily_offsitework_activity_logs` jdoal
WHERE jdoal.`id` IN ($csvJobsiteDailyOffsiteworkActivityLogIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteDailyOffsiteworkActivityLogsByCsvJobsiteDailyOffsiteworkActivityLogIds = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_offsitework_activity_log_id = $row['id'];
			$jobsiteDailyOffsiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailyOffsiteworkActivityLog', $row, null, $jobsite_daily_offsitework_activity_log_id);
			/* @var $jobsiteDailyOffsiteworkActivityLog JobsiteDailyOffsiteworkActivityLog */
			$jobsiteDailyOffsiteworkActivityLog->convertPropertiesToData();

			$arrJobsiteDailyOffsiteworkActivityLogsByCsvJobsiteDailyOffsiteworkActivityLogIds[$jobsite_daily_offsitework_activity_log_id] = $jobsiteDailyOffsiteworkActivityLog;
		}

		$db->free_result();

		return $arrJobsiteDailyOffsiteworkActivityLogsByCsvJobsiteDailyOffsiteworkActivityLogIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_daily_offsitework_activity_logs_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId = null;
		}

		$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId = self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId;
		if (isset($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId) && !empty($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId)) {
			return $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyOffsiteworkActivityLog = new JobsiteDailyOffsiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyOffsiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdoal.*

FROM `jobsite_daily_offsitework_activity_logs` jdoal
WHERE jdoal.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyOffsiteworkActivityLogIds = array();
		$arrJobsiteOffsiteworkActivityIds = array();
		$arrJobsiteOffsiteworkRegionIds = array();
		$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_offsitework_activity_log_id = $row['id'];
			$jobsite_offsitework_activity_id = $row['jobsite_offsitework_activity_id'];
			$jobsite_offsitework_region_id = $row['jobsite_offsitework_region_id'];

			$jobsiteDailyOffsiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailyOffsiteworkActivityLog', $row, null, $jobsite_daily_offsitework_activity_log_id);
			/* @var $jobsiteDailyOffsiteworkActivityLog JobsiteDailyOffsiteworkActivityLog */
			$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId[$jobsite_daily_offsitework_activity_log_id] = $jobsiteDailyOffsiteworkActivityLog;

			$arrJobsiteDailyOffsiteworkActivityLogIds[$jobsite_daily_offsitework_activity_log_id] = $jobsite_daily_offsitework_activity_log_id;
			$arrJobsiteOffsiteworkActivityIds[$jobsite_offsitework_activity_id] = $jobsite_offsitework_activity_id;
			$arrJobsiteOffsiteworkRegionIds[$jobsite_offsitework_region_id] = $jobsite_offsitework_region_id;
		}

		$db->free_result();

		self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId = $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId;
		//return $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId;

		$arrReturn = array(
			'objects' => $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteDailyLogId,
			'jobsite_daily_offsitework_activity_log_ids' => $arrJobsiteDailyOffsiteworkActivityLogIds,
			'jobsite_offsitework_activity_ids' => $arrJobsiteOffsiteworkActivityIds,
			'jobsite_offsitework_region_ids' => $arrJobsiteOffsiteworkRegionIds,
		);

		return $arrReturn;
	}

	/**
	 * Load by constraint `jobsite_daily_offsitework_activity_logs_fk_joa` foreign key (`jobsite_offsitework_activity_id`) references `jobsite_offsitework_activities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId($database, $jobsite_offsitework_activity_id, Input $options=null)
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
			self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId = null;
		}

		$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId = self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId;
		if (isset($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId) && !empty($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId)) {
			return $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId;
		}

		$jobsite_offsitework_activity_id = (int) $jobsite_offsitework_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyOffsiteworkActivityLog = new JobsiteDailyOffsiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyOffsiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdoal.*

FROM `jobsite_daily_offsitework_activity_logs` jdoal
WHERE jdoal.`jobsite_offsitework_activity_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$arrValues = array($jobsite_offsitework_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_offsitework_activity_log_id = $row['id'];
			$jobsiteDailyOffsiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailyOffsiteworkActivityLog', $row, null, $jobsite_daily_offsitework_activity_log_id);
			/* @var $jobsiteDailyOffsiteworkActivityLog JobsiteDailyOffsiteworkActivityLog */
			$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId[$jobsite_daily_offsitework_activity_log_id] = $jobsiteDailyOffsiteworkActivityLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId = $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId;

		return $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkActivityId;
	}

	/**
	 * Load by constraint `jobsite_daily_offsitework_activity_logs_fk_jor` foreign key (`jobsite_offsitework_region_id`) references `jobsite_offsitework_regions` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_region_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId($database, $jobsite_offsitework_region_id, Input $options=null)
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
			self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId = null;
		}

		$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId = self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId;
		if (isset($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId) && !empty($arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId)) {
			return $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId;
		}

		$jobsite_offsitework_region_id = (int) $jobsite_offsitework_region_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyOffsiteworkActivityLog = new JobsiteDailyOffsiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyOffsiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdoal.*

FROM `jobsite_daily_offsitework_activity_logs` jdoal
WHERE jdoal.`jobsite_offsitework_region_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$arrValues = array($jobsite_offsitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_offsitework_activity_log_id = $row['id'];
			$jobsiteDailyOffsiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailyOffsiteworkActivityLog', $row, null, $jobsite_daily_offsitework_activity_log_id);
			/* @var $jobsiteDailyOffsiteworkActivityLog JobsiteDailyOffsiteworkActivityLog */
			$arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId[$jobsite_daily_offsitework_activity_log_id] = $jobsiteDailyOffsiteworkActivityLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId = $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId;

		return $arrJobsiteDailyOffsiteworkActivityLogsByJobsiteOffsiteworkRegionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_daily_offsitework_activity_logs records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteDailyOffsiteworkActivityLogs($database, Input $options=null)
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
			self::$_arrAllJobsiteDailyOffsiteworkActivityLogs = null;
		}

		$arrAllJobsiteDailyOffsiteworkActivityLogs = self::$_arrAllJobsiteDailyOffsiteworkActivityLogs;
		if (isset($arrAllJobsiteDailyOffsiteworkActivityLogs) && !empty($arrAllJobsiteDailyOffsiteworkActivityLogs)) {
			return $arrAllJobsiteDailyOffsiteworkActivityLogs;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyOffsiteworkActivityLog = new JobsiteDailyOffsiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyOffsiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdoal.*

FROM `jobsite_daily_offsitework_activity_logs` jdoal{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_offsitework_activity_id` ASC, `jobsite_offsitework_region_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteDailyOffsiteworkActivityLogs = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_offsitework_activity_log_id = $row['id'];
			$jobsiteDailyOffsiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailyOffsiteworkActivityLog', $row, null, $jobsite_daily_offsitework_activity_log_id);
			/* @var $jobsiteDailyOffsiteworkActivityLog JobsiteDailyOffsiteworkActivityLog */
			$arrAllJobsiteDailyOffsiteworkActivityLogs[$jobsite_daily_offsitework_activity_log_id] = $jobsiteDailyOffsiteworkActivityLog;
		}

		$db->free_result();

		self::$_arrAllJobsiteDailyOffsiteworkActivityLogs = $arrAllJobsiteDailyOffsiteworkActivityLogs;

		return $arrAllJobsiteDailyOffsiteworkActivityLogs;
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
INTO `jobsite_daily_offsitework_activity_logs`
(`jobsite_daily_log_id`, `jobsite_offsitework_activity_id`, `jobsite_offsitework_region_id`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_offsitework_region_id` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_offsitework_activity_id, $this->jobsite_offsitework_region_id, $this->jobsite_offsitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_daily_offsitework_activity_log_id = $db->insertId;
		$db->free_result();

		return $jobsite_daily_offsitework_activity_log_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

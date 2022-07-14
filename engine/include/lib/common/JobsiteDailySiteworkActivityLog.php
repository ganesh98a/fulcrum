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
 * JobsiteDailySiteworkActivityLog.
 *
 * @category   Framework
 * @package    JobsiteDailySiteworkActivityLog
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteDailySiteworkActivityLog extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteDailySiteworkActivityLog';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_daily_sitework_activity_logs';

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
	 * unique index `unique_jobsite_daily_sitework_activity_log` (`jobsite_daily_log_id`,`jobsite_sitework_activity_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_daily_sitework_activity_log' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_sitework_activity_id' => 'int'
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
		'id' => 'jobsite_daily_sitework_activity_log_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_sitework_activity_id' => 'jobsite_sitework_activity_id',

		'jobsite_sitework_region_id' => 'jobsite_sitework_region_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_daily_sitework_activity_log_id;

	public $jobsite_daily_log_id;
	public $jobsite_sitework_activity_id;

	public $jobsite_sitework_region_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId;
	protected static $_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId;
	protected static $_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteDailySiteworkActivityLogs;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteSiteworkActivity;
	private $_jobsiteSiteworkRegion;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_daily_sitework_activity_logs')
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

	public function getJobsiteSiteworkActivity()
	{
		if (isset($this->_jobsiteSiteworkActivity)) {
			return $this->_jobsiteSiteworkActivity;
		} else {
			return null;
		}
	}

	public function setJobsiteSiteworkActivity($jobsiteSiteworkActivity)
	{
		$this->_jobsiteSiteworkActivity = $jobsiteSiteworkActivity;
	}

	public function getJobsiteSiteworkRegion()
	{
		if (isset($this->_jobsiteSiteworkRegion)) {
			return $this->_jobsiteSiteworkRegion;
		} else {
			return null;
		}
	}

	public function setJobsiteSiteworkRegion($jobsiteSiteworkRegion)
	{
		$this->_jobsiteSiteworkRegion = $jobsiteSiteworkRegion;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId)) {
			return self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId)
	{
		self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = $arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId;
	}

	public static function getArrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId()
	{
		if (isset(self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId)) {
			return self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId($arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId)
	{
		self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId = $arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId;
	}

	public static function getArrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId()
	{
		if (isset(self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId)) {
			return self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId($arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId)
	{
		self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId = $arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteDailySiteworkActivityLogs()
	{
		if (isset(self::$_arrAllJobsiteDailySiteworkActivityLogs)) {
			return self::$_arrAllJobsiteDailySiteworkActivityLogs;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteDailySiteworkActivityLogs($arrAllJobsiteDailySiteworkActivityLogs)
	{
		self::$_arrAllJobsiteDailySiteworkActivityLogs = $arrAllJobsiteDailySiteworkActivityLogs;
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
	 * @param int $jobsite_daily_sitework_activity_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_daily_sitework_activity_log_id, $table='jobsite_daily_sitework_activity_logs', $module='JobsiteDailySiteworkActivityLog')
	{
		$jobsiteDailySiteworkActivityLog = parent::findById($database, $jobsite_daily_sitework_activity_log_id, $table, $module);

		return $jobsiteDailySiteworkActivityLog;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_sitework_activity_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteDailySiteworkActivityLogByIdExtended($database, $jobsite_daily_sitework_activity_log_id)
	{
		$jobsite_daily_sitework_activity_log_id = (int) $jobsite_daily_sitework_activity_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jdsal_fk_jdl.`id` AS 'jdsal_fk_jdl__jobsite_daily_log_id',
	jdsal_fk_jdl.`project_id` AS 'jdsal_fk_jdl__project_id',
	jdsal_fk_jdl.`modified_by_contact_id` AS 'jdsal_fk_jdl__modified_by_contact_id',
	jdsal_fk_jdl.`created_by_contact_id` AS 'jdsal_fk_jdl__created_by_contact_id',
	jdsal_fk_jdl.`modified` AS 'jdsal_fk_jdl__modified',
	jdsal_fk_jdl.`jobsite_daily_log_created_date` AS 'jdsal_fk_jdl__jobsite_daily_log_created_date',

	jdsal_fk_jsa.`id` AS 'jdsal_fk_jsa__jobsite_sitework_activity_id',
	jdsal_fk_jsa.`project_id` AS 'jdsal_fk_jsa__project_id',
	jdsal_fk_jsa.`jobsite_sitework_activity_label` AS 'jdsal_fk_jsa__jobsite_sitework_activity_label',
	jdsal_fk_jsa.`sort_order` AS 'jdsal_fk_jsa__sort_order',
	jdsal_fk_jsa.`disabled_flag` AS 'jdsal_fk_jsa__disabled_flag',

	jdsal_fk_jsr.`id` AS 'jdsal_fk_jsr__jobsite_sitework_region_id',
	jdsal_fk_jsr.`project_id` AS 'jdsal_fk_jsr__project_id',
	jdsal_fk_jsr.`jobsite_sitework_region` AS 'jdsal_fk_jsr__jobsite_sitework_region',
	jdsal_fk_jsr.`jobsite_sitework_region_description` AS 'jdsal_fk_jsr__jobsite_sitework_region_description',
	jdsal_fk_jsr.`sort_order` AS 'jdsal_fk_jsr__sort_order',
	jdsal_fk_jsr.`disabled_flag` AS 'jdsal_fk_jsr__disabled_flag',

	jdsal.*

FROM `jobsite_daily_sitework_activity_logs` jdsal
	INNER JOIN `jobsite_daily_logs` jdsal_fk_jdl ON jdsal.`jobsite_daily_log_id` = jdsal_fk_jdl.`id`
	INNER JOIN `jobsite_sitework_activities` jdsal_fk_jsa ON jdsal.`jobsite_sitework_activity_id` = jdsal_fk_jsa.`id`
	LEFT OUTER JOIN `jobsite_sitework_regions` jdsal_fk_jsr ON jdsal.`jobsite_sitework_region_id` = jdsal_fk_jsr.`id`
WHERE jdsal.`id` = ?
";
		$arrValues = array($jobsite_daily_sitework_activity_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_daily_sitework_activity_log_id = $row['id'];
			$jobsiteDailySiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailySiteworkActivityLog', $row, null, $jobsite_daily_sitework_activity_log_id);
			/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */
			$jobsiteDailySiteworkActivityLog->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jdsal_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jdsal_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteDailySiteworkActivityLog->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_sitework_activity_id'])) {
				$jobsite_sitework_activity_id = $row['jobsite_sitework_activity_id'];
				$row['jdsal_fk_jsa__id'] = $jobsite_sitework_activity_id;
				$jobsiteSiteworkActivity = self::instantiateOrm($database, 'JobsiteSiteworkActivity', $row, null, $jobsite_sitework_activity_id, 'jdsal_fk_jsa__');
				/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */
				$jobsiteSiteworkActivity->convertPropertiesToData();
			} else {
				$jobsiteSiteworkActivity = false;
			}
			$jobsiteDailySiteworkActivityLog->setJobsiteSiteworkActivity($jobsiteSiteworkActivity);

			if (isset($row['jobsite_sitework_region_id'])) {
				$jobsite_sitework_region_id = $row['jobsite_sitework_region_id'];
				$row['jdsal_fk_jsr__id'] = $jobsite_sitework_region_id;
				$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id, 'jdsal_fk_jsr__');
				/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
				$jobsiteSiteworkRegion->convertPropertiesToData();
			} else {
				$jobsiteSiteworkRegion = false;
			}
			$jobsiteDailySiteworkActivityLog->setJobsiteSiteworkRegion($jobsiteSiteworkRegion);

			return $jobsiteDailySiteworkActivityLog;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_daily_sitework_activity_log` (`jobsite_daily_log_id`,`jobsite_sitework_activity_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_sitework_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteSiteworkActivityId($database, $jobsite_daily_log_id, $jobsite_sitework_activity_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jdsal.*

FROM `jobsite_daily_sitework_activity_logs` jdsal
WHERE jdsal.`jobsite_daily_log_id` = ?
AND jdsal.`jobsite_sitework_activity_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_sitework_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_daily_sitework_activity_log_id = $row['id'];
			$jobsiteDailySiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailySiteworkActivityLog', $row, null, $jobsite_daily_sitework_activity_log_id);
			/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */
			return $jobsiteDailySiteworkActivityLog;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteDailySiteworkActivityLogIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailySiteworkActivityLogsByArrJobsiteDailySiteworkActivityLogIds($database, $arrJobsiteDailySiteworkActivityLogIds, Input $options=null)
	{
		if (empty($arrJobsiteDailySiteworkActivityLogIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailySiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteDailySiteworkActivityLogIds as $k => $jobsite_daily_sitework_activity_log_id) {
			$jobsite_daily_sitework_activity_log_id = (int) $jobsite_daily_sitework_activity_log_id;
			$arrJobsiteDailySiteworkActivityLogIds[$k] = $db->escape($jobsite_daily_sitework_activity_log_id);
		}
		$csvJobsiteDailySiteworkActivityLogIds = join(',', $arrJobsiteDailySiteworkActivityLogIds);

		$query =
"
SELECT

	jdsal.*

FROM `jobsite_daily_sitework_activity_logs` jdsal
WHERE jdsal.`id` IN ($csvJobsiteDailySiteworkActivityLogIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteDailySiteworkActivityLogsByCsvJobsiteDailySiteworkActivityLogIds = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_sitework_activity_log_id = $row['id'];
			$jobsiteDailySiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailySiteworkActivityLog', $row, null, $jobsite_daily_sitework_activity_log_id);
			/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */
			$jobsiteDailySiteworkActivityLog->convertPropertiesToData();

			$arrJobsiteDailySiteworkActivityLogsByCsvJobsiteDailySiteworkActivityLogIds[$jobsite_daily_sitework_activity_log_id] = $jobsiteDailySiteworkActivityLog;
		}

		$db->free_result();

		return $arrJobsiteDailySiteworkActivityLogsByCsvJobsiteDailySiteworkActivityLogIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_daily_sitework_activity_logs_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = null;
		}

		$arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId;
		if (isset($arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId) && !empty($arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId)) {
			return $arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailySiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdsal.*

FROM `jobsite_daily_sitework_activity_logs` jdsal
WHERE jdsal.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailySiteworkActivityLogIds = array();
		$arrJobsiteSiteworkActivityIds = array();
		$arrJobsiteSiteworkRegionIds = array();
		$arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_sitework_activity_log_id = $row['id'];
			$jobsite_sitework_activity_id = $row['jobsite_sitework_activity_id'];
			$jobsite_sitework_region_id = $row['jobsite_sitework_region_id'];

			$jobsiteDailySiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailySiteworkActivityLog', $row, null, $jobsite_daily_sitework_activity_log_id);
			/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */
			$arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId[$jobsite_daily_sitework_activity_log_id] = $jobsiteDailySiteworkActivityLog;

			$arrJobsiteDailySiteworkActivityLogIds[$jobsite_daily_sitework_activity_log_id] = $jobsite_daily_sitework_activity_log_id;
			$arrJobsiteSiteworkActivityIds[$jobsite_sitework_activity_id] = $jobsite_sitework_activity_id;
			$arrJobsiteSiteworkRegionIds[$jobsite_sitework_region_id] = $jobsite_sitework_region_id;
		}

		$db->free_result();

		self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId = $arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId;
		//return $arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId;

		$arrReturn = array(
			'objects' => $arrJobsiteDailySiteworkActivityLogsByJobsiteDailyLogId,
			'jobsite_daily_sitework_activity_log_ids' => $arrJobsiteDailySiteworkActivityLogIds,
			'jobsite_sitework_activity_ids' => $arrJobsiteSiteworkActivityIds,
			'jobsite_sitework_region_ids' => $arrJobsiteSiteworkRegionIds,
		);

		return $arrReturn;
	}

	/**
	 * Load by constraint `jobsite_daily_sitework_activity_logs_fk_jsa` foreign key (`jobsite_sitework_activity_id`) references `jobsite_sitework_activities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId($database, $jobsite_sitework_activity_id, Input $options=null)
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
			self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId = null;
		}

		$arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId = self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId;
		if (isset($arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId) && !empty($arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId)) {
			return $arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId;
		}

		$jobsite_sitework_activity_id = (int) $jobsite_sitework_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailySiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdsal.*

FROM `jobsite_daily_sitework_activity_logs` jdsal
WHERE jdsal.`jobsite_sitework_activity_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$arrValues = array($jobsite_sitework_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_sitework_activity_log_id = $row['id'];
			$jobsiteDailySiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailySiteworkActivityLog', $row, null, $jobsite_daily_sitework_activity_log_id);
			/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */
			$arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId[$jobsite_daily_sitework_activity_log_id] = $jobsiteDailySiteworkActivityLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId = $arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId;

		return $arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkActivityId;
	}

	/**
	 * Load by constraint `jobsite_daily_sitework_activity_logs_fk_jsr` foreign key (`jobsite_sitework_region_id`) references `jobsite_sitework_regions` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_region_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId($database, $jobsite_sitework_region_id, Input $options=null)
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
			self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId = null;
		}

		$arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId = self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId;
		if (isset($arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId) && !empty($arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId)) {
			return $arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId;
		}

		$jobsite_sitework_region_id = (int) $jobsite_sitework_region_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailySiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdsal.*

FROM `jobsite_daily_sitework_activity_logs` jdsal
WHERE jdsal.`jobsite_sitework_region_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$arrValues = array($jobsite_sitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_sitework_activity_log_id = $row['id'];
			$jobsiteDailySiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailySiteworkActivityLog', $row, null, $jobsite_daily_sitework_activity_log_id);
			/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */
			$arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId[$jobsite_daily_sitework_activity_log_id] = $jobsiteDailySiteworkActivityLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId = $arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId;

		return $arrJobsiteDailySiteworkActivityLogsByJobsiteSiteworkRegionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_daily_sitework_activity_logs records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteDailySiteworkActivityLogs($database, Input $options=null)
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
			self::$_arrAllJobsiteDailySiteworkActivityLogs = null;
		}

		$arrAllJobsiteDailySiteworkActivityLogs = self::$_arrAllJobsiteDailySiteworkActivityLogs;
		if (isset($arrAllJobsiteDailySiteworkActivityLogs) && !empty($arrAllJobsiteDailySiteworkActivityLogs)) {
			return $arrAllJobsiteDailySiteworkActivityLogs;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailySiteworkActivityLog = new JobsiteDailySiteworkActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailySiteworkActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdsal.*

FROM `jobsite_daily_sitework_activity_logs` jdsal{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sitework_activity_id` ASC, `jobsite_sitework_region_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteDailySiteworkActivityLogs = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_sitework_activity_log_id = $row['id'];
			$jobsiteDailySiteworkActivityLog = self::instantiateOrm($database, 'JobsiteDailySiteworkActivityLog', $row, null, $jobsite_daily_sitework_activity_log_id);
			/* @var $jobsiteDailySiteworkActivityLog JobsiteDailySiteworkActivityLog */
			$arrAllJobsiteDailySiteworkActivityLogs[$jobsite_daily_sitework_activity_log_id] = $jobsiteDailySiteworkActivityLog;
		}

		$db->free_result();

		self::$_arrAllJobsiteDailySiteworkActivityLogs = $arrAllJobsiteDailySiteworkActivityLogs;

		return $arrAllJobsiteDailySiteworkActivityLogs;
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
INTO `jobsite_daily_sitework_activity_logs`
(`jobsite_daily_log_id`, `jobsite_sitework_activity_id`, `jobsite_sitework_region_id`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_sitework_region_id` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_sitework_activity_id, $this->jobsite_sitework_region_id, $this->jobsite_sitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_daily_sitework_activity_log_id = $db->insertId;
		$db->free_result();

		return $jobsite_daily_sitework_activity_log_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

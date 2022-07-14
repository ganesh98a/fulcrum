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
 * JobsiteDailyBuildingActivityLog.
 *
 * @category   Framework
 * @package    JobsiteDailyBuildingActivityLog
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteDailyBuildingActivityLog extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteDailyBuildingActivityLog';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_daily_building_activity_logs';

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
	 * unique index `unique_jobsite_daily_building_activity_log` (`jobsite_daily_log_id`,`jobsite_building_activity_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_daily_building_activity_log' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_building_activity_id' => 'int' ,
			'cost_code_id' => 'int'
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
		'id' => 'jobsite_daily_building_activity_log_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_building_activity_id' => 'jobsite_building_activity_id',

		'jobsite_building_id' => 'jobsite_building_id',
		'cost_code_id' => 'cost_code_id'
		
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_daily_building_activity_log_id;

	public $jobsite_daily_log_id;
	public $jobsite_building_activity_id;

	public $jobsite_building_id;
	public $cost_code_id;
	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId;
	protected static $_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId;
	protected static $_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteDailyBuildingActivityLogs;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteBuildingActivity;
	private $_jobsiteBuilding;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_daily_building_activity_logs')
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

	public function getJobsiteBuildingActivity()
	{
		if (isset($this->_jobsiteBuildingActivity)) {
			return $this->_jobsiteBuildingActivity;
		} else {
			return null;
		}
	}

	public function setJobsiteBuildingActivity($jobsiteBuildingActivity)
	{
		$this->_jobsiteBuildingActivity = $jobsiteBuildingActivity;
	}

	public function getJobsiteBuilding()
	{
		if (isset($this->_jobsiteBuilding)) {
			return $this->_jobsiteBuilding;
		} else {
			return null;
		}
	}

	public function setJobsiteBuilding($jobsiteBuilding)
	{
		$this->_jobsiteBuilding = $jobsiteBuilding;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId)) {
			return self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId($arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId)
	{
		self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = $arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId;
	}

	public static function getArrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId()
	{
		if (isset(self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId)) {
			return self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId($arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId)
	{
		self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId = $arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId;
	}

	public static function getArrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId()
	{
		if (isset(self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId)) {
			return self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId($arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId)
	{
		self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId = $arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteDailyBuildingActivityLogs()
	{
		if (isset(self::$_arrAllJobsiteDailyBuildingActivityLogs)) {
			return self::$_arrAllJobsiteDailyBuildingActivityLogs;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteDailyBuildingActivityLogs($arrAllJobsiteDailyBuildingActivityLogs)
	{
		self::$_arrAllJobsiteDailyBuildingActivityLogs = $arrAllJobsiteDailyBuildingActivityLogs;
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
	 * @param int $jobsite_daily_building_activity_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_daily_building_activity_log_id, $table='jobsite_daily_building_activity_logs', $module='JobsiteDailyBuildingActivityLog')
	{
		$jobsiteDailyBuildingActivityLog = parent::findById($database, $jobsite_daily_building_activity_log_id, $table, $module);

		return $jobsiteDailyBuildingActivityLog;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_building_activity_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteDailyBuildingActivityLogByIdExtended($database, $jobsite_daily_building_activity_log_id)
	{
		$jobsite_daily_building_activity_log_id = (int) $jobsite_daily_building_activity_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jdbal_fk_jdl.`id` AS 'jdbal_fk_jdl__jobsite_daily_log_id',
	jdbal_fk_jdl.`project_id` AS 'jdbal_fk_jdl__project_id',
	jdbal_fk_jdl.`modified_by_contact_id` AS 'jdbal_fk_jdl__modified_by_contact_id',
	jdbal_fk_jdl.`created_by_contact_id` AS 'jdbal_fk_jdl__created_by_contact_id',
	jdbal_fk_jdl.`modified` AS 'jdbal_fk_jdl__modified',
	jdbal_fk_jdl.`jobsite_daily_log_created_date` AS 'jdbal_fk_jdl__jobsite_daily_log_created_date',

	jdbal_fk_jba.`id` AS 'jdbal_fk_jba__jobsite_building_activity_id',
	jdbal_fk_jba.`project_id` AS 'jdbal_fk_jba__project_id',
	jdbal_fk_jba.`jobsite_building_activity_label` AS 'jdbal_fk_jba__jobsite_building_activity_label',
	jdbal_fk_jba.`sort_order` AS 'jdbal_fk_jba__sort_order',
	jdbal_fk_jba.`disabled_flag` AS 'jdbal_fk_jba__disabled_flag',

	jdbal_fk_jb.`id` AS 'jdbal_fk_jb__jobsite_building_id',
	jdbal_fk_jb.`project_id` AS 'jdbal_fk_jb__project_id',
	jdbal_fk_jb.`jobsite_building` AS 'jdbal_fk_jb__jobsite_building',
	jdbal_fk_jb.`jobsite_building_description` AS 'jdbal_fk_jb__jobsite_building_description',
	jdbal_fk_jb.`sort_order` AS 'jdbal_fk_jb__sort_order',
	jdbal_fk_jb.`disabled_flag` AS 'jdbal_fk_jb__disabled_flag',

	jdbal.*

FROM `jobsite_daily_building_activity_logs` jdbal
	INNER JOIN `jobsite_daily_logs` jdbal_fk_jdl ON jdbal.`jobsite_daily_log_id` = jdbal_fk_jdl.`id`
	INNER JOIN `jobsite_building_activities` jdbal_fk_jba ON jdbal.`jobsite_building_activity_id` = jdbal_fk_jba.`id`
	LEFT OUTER JOIN `jobsite_buildings` jdbal_fk_jb ON jdbal.`jobsite_building_id` = jdbal_fk_jb.`id`
WHERE jdbal.`id` = ?
";
		$arrValues = array($jobsite_daily_building_activity_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_daily_building_activity_log_id = $row['id'];
			$jobsiteDailyBuildingActivityLog = self::instantiateOrm($database, 'JobsiteDailyBuildingActivityLog', $row, null, $jobsite_daily_building_activity_log_id);
			/* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */
			$jobsiteDailyBuildingActivityLog->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jdbal_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jdbal_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteDailyBuildingActivityLog->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_building_activity_id'])) {
				$jobsite_building_activity_id = $row['jobsite_building_activity_id'];
				$row['jdbal_fk_jba__id'] = $jobsite_building_activity_id;
				$jobsiteBuildingActivity = self::instantiateOrm($database, 'JobsiteBuildingActivity', $row, null, $jobsite_building_activity_id, 'jdbal_fk_jba__');
				/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
				$jobsiteBuildingActivity->convertPropertiesToData();
			} else {
				$jobsiteBuildingActivity = false;
			}
			$jobsiteDailyBuildingActivityLog->setJobsiteBuildingActivity($jobsiteBuildingActivity);

			if (isset($row['jobsite_building_id'])) {
				$jobsite_building_id = $row['jobsite_building_id'];
				$row['jdbal_fk_jb__id'] = $jobsite_building_id;
				$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id, 'jdbal_fk_jb__');
				/* @var $jobsiteBuilding JobsiteBuilding */
				$jobsiteBuilding->convertPropertiesToData();
			} else {
				$jobsiteBuilding = false;
			}
			$jobsiteDailyBuildingActivityLog->setJobsiteBuilding($jobsiteBuilding);

			return $jobsiteDailyBuildingActivityLog;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_daily_building_activity_log` (`jobsite_daily_log_id`,`jobsite_building_activity_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_building_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteBuildingActivityId($database, $jobsite_daily_log_id, $jobsite_building_activity_id,$cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jdbal.*

FROM `jobsite_daily_building_activity_logs` jdbal
WHERE jdbal.`jobsite_daily_log_id` = ?
AND jdbal.`jobsite_building_activity_id` = ?
AND jdbal.`cost_code_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_building_activity_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_daily_building_activity_log_id = $row['id'];
			$jobsiteDailyBuildingActivityLog = self::instantiateOrm($database, 'JobsiteDailyBuildingActivityLog', $row, null, $jobsite_daily_building_activity_log_id);
			/* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */
			return $jobsiteDailyBuildingActivityLog;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteDailyBuildingActivityLogIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyBuildingActivityLogsByArrJobsiteDailyBuildingActivityLogIds($database, $arrJobsiteDailyBuildingActivityLogIds, Input $options=null)
	{
		if (empty($arrJobsiteDailyBuildingActivityLogIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyBuildingActivityLog = new JobsiteDailyBuildingActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyBuildingActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteDailyBuildingActivityLogIds as $k => $jobsite_daily_building_activity_log_id) {
			$jobsite_daily_building_activity_log_id = (int) $jobsite_daily_building_activity_log_id;
			$arrJobsiteDailyBuildingActivityLogIds[$k] = $db->escape($jobsite_daily_building_activity_log_id);
		}
		$csvJobsiteDailyBuildingActivityLogIds = join(',', $arrJobsiteDailyBuildingActivityLogIds);

		$query =
"
SELECT

	jdbal.*

FROM `jobsite_daily_building_activity_logs` jdbal
WHERE jdbal.`id` IN ($csvJobsiteDailyBuildingActivityLogIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteDailyBuildingActivityLogsByCsvJobsiteDailyBuildingActivityLogIds = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_building_activity_log_id = $row['id'];
			$jobsiteDailyBuildingActivityLog = self::instantiateOrm($database, 'JobsiteDailyBuildingActivityLog', $row, null, $jobsite_daily_building_activity_log_id);
			/* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */
			$jobsiteDailyBuildingActivityLog->convertPropertiesToData();

			$arrJobsiteDailyBuildingActivityLogsByCsvJobsiteDailyBuildingActivityLogIds[$jobsite_daily_building_activity_log_id] = $jobsiteDailyBuildingActivityLog;
		}

		$db->free_result();

		return $arrJobsiteDailyBuildingActivityLogsByCsvJobsiteDailyBuildingActivityLogIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_daily_building_activity_logs_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = null;
		}

		$arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId;
		if (isset($arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId) && !empty($arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId)) {
			return $arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyBuildingActivityLog = new JobsiteDailyBuildingActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyBuildingActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdbal.*

FROM `jobsite_daily_building_activity_logs` jdbal
WHERE jdbal.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyBuildingActivityLogIds = array();
		$arrJobsiteBuildingActivityIds = array();
		$arrJobsiteBuildingIds = array();
		$arrJobsiteBuildingcostcodes = array();
		$arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_building_activity_log_id = $row['id'];
			$jobsite_building_activity_id = $row['jobsite_building_activity_id'];
			$jobsite_building_id = $row['jobsite_building_id'];
			$cost_code_id = $row['cost_code_id'];

			$jobsiteDailyBuildingActivityLog = self::instantiateOrm($database, 'JobsiteDailyBuildingActivityLog', $row, null, $jobsite_daily_building_activity_log_id);
			/* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */
			$arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId[$jobsite_daily_building_activity_log_id] = $jobsiteDailyBuildingActivityLog;

			$arrJobsiteDailyBuildingActivityLogIds[$jobsite_daily_building_activity_log_id] = $jobsite_daily_building_activity_log_id;
			$arrJobsiteBuildingActivityIds[$jobsite_building_activity_id] = $jobsite_building_activity_id;
			$arrJobsiteBuildingIds[$jobsite_building_id] = $jobsite_building_id;
			$arrJobsiteBuildingcostcodes[$jobsite_daily_building_activity_log_id]=$cost_code_id;
		}

		$db->free_result();

		self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId = $arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId;
		//return $arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId;

		$arrReturn = array(
			'objects' => $arrJobsiteDailyBuildingActivityLogsByJobsiteDailyLogId,
			'jobsite_daily_building_activity_log_ids' => $arrJobsiteDailyBuildingActivityLogIds,
			'jobsite_building_activity_ids' => $arrJobsiteBuildingActivityIds,
			'jobsite_building_ids' => $arrJobsiteBuildingIds,
			'cost_code_id' => $arrJobsiteBuildingcostcodes,
		);

		return $arrReturn;
	}

	/**
	 * Load by constraint `jobsite_daily_building_activity_logs_fk_jba` foreign key (`jobsite_building_activity_id`) references `jobsite_building_activities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId($database, $jobsite_building_activity_id, Input $options=null)
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
			self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId = null;
		}

		$arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId = self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId;
		if (isset($arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId) && !empty($arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId)) {
			return $arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId;
		}

		$jobsite_building_activity_id = (int) $jobsite_building_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyBuildingActivityLog = new JobsiteDailyBuildingActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyBuildingActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdbal.*

FROM `jobsite_daily_building_activity_logs` jdbal
WHERE jdbal.`jobsite_building_activity_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$arrValues = array($jobsite_building_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_building_activity_log_id = $row['id'];
			$jobsiteDailyBuildingActivityLog = self::instantiateOrm($database, 'JobsiteDailyBuildingActivityLog', $row, null, $jobsite_daily_building_activity_log_id);
			/* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */
			$arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId[$jobsite_daily_building_activity_log_id] = $jobsiteDailyBuildingActivityLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId = $arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId;

		return $arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingActivityId;
	}

	/**
	 * Load by constraint `jobsite_daily_building_activity_logs_fk_jb` foreign key (`jobsite_building_id`) references `jobsite_buildings` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_building_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyBuildingActivityLogsByJobsiteBuildingId($database, $jobsite_building_id, Input $options=null)
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
			self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId = null;
		}

		$arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId = self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId;
		if (isset($arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId) && !empty($arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId)) {
			return $arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId;
		}

		$jobsite_building_id = (int) $jobsite_building_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyBuildingActivityLog = new JobsiteDailyBuildingActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyBuildingActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdbal.*

FROM `jobsite_daily_building_activity_logs` jdbal
WHERE jdbal.`jobsite_building_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$arrValues = array($jobsite_building_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_building_activity_log_id = $row['id'];
			$jobsiteDailyBuildingActivityLog = self::instantiateOrm($database, 'JobsiteDailyBuildingActivityLog', $row, null, $jobsite_daily_building_activity_log_id);
			/* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */
			$arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId[$jobsite_daily_building_activity_log_id] = $jobsiteDailyBuildingActivityLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId = $arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId;

		return $arrJobsiteDailyBuildingActivityLogsByJobsiteBuildingId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_daily_building_activity_logs records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteDailyBuildingActivityLogs($database, Input $options=null)
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
			self::$_arrAllJobsiteDailyBuildingActivityLogs = null;
		}

		$arrAllJobsiteDailyBuildingActivityLogs = self::$_arrAllJobsiteDailyBuildingActivityLogs;
		if (isset($arrAllJobsiteDailyBuildingActivityLogs) && !empty($arrAllJobsiteDailyBuildingActivityLogs)) {
			return $arrAllJobsiteDailyBuildingActivityLogs;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyBuildingActivityLog = new JobsiteDailyBuildingActivityLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyBuildingActivityLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdbal.*

FROM `jobsite_daily_building_activity_logs` jdbal{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_building_activity_id` ASC, `jobsite_building_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteDailyBuildingActivityLogs = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_building_activity_log_id = $row['id'];
			$jobsiteDailyBuildingActivityLog = self::instantiateOrm($database, 'JobsiteDailyBuildingActivityLog', $row, null, $jobsite_daily_building_activity_log_id);
			/* @var $jobsiteDailyBuildingActivityLog JobsiteDailyBuildingActivityLog */
			$arrAllJobsiteDailyBuildingActivityLogs[$jobsite_daily_building_activity_log_id] = $jobsiteDailyBuildingActivityLog;
		}

		$db->free_result();

		self::$_arrAllJobsiteDailyBuildingActivityLogs = $arrAllJobsiteDailyBuildingActivityLogs;

		return $arrAllJobsiteDailyBuildingActivityLogs;
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
INTO `jobsite_daily_building_activity_logs`
(`jobsite_daily_log_id`, `jobsite_building_activity_id`, `jobsite_building_id` ,`cost_code_id`)
VALUES (?, ?, ? ,? )
ON DUPLICATE KEY UPDATE `jobsite_building_id` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_building_activity_id, $this->jobsite_building_id,$this->cost_code_id, $this->jobsite_building_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_daily_building_activity_log_id = $db->insertId;
		$db->free_result();

		return $jobsite_daily_building_activity_log_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

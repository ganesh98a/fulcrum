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
 * JobsiteFieldReport.
 *
 * @category   Framework
 * @package    JobsiteFieldReport
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteFieldReport extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteFieldReport';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_field_reports';

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
	 * unique index `unique_jobsite_field_report` (`jobsite_daily_log_id`,`jobsite_field_report_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_field_report' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_field_report_file_manager_file_id' => 'int'
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
		'id' => 'jobsite_field_report_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_field_report_file_manager_file_id' => 'jobsite_field_report_file_manager_file_id',

		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_field_report_id;

	public $jobsite_daily_log_id;
	public $jobsite_field_report_file_manager_file_id;

	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteFieldReportsByJobsiteDailyLogId;
	protected static $_arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteFieldReports;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteFieldReportFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_field_reports')
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

	public function getJobsiteFieldReportFileManagerFile()
	{
		if (isset($this->_jobsiteFieldReportFileManagerFile)) {
			return $this->_jobsiteFieldReportFileManagerFile;
		} else {
			return null;
		}
	}

	public function setJobsiteFieldReportFileManagerFile($jobsiteFieldReportFileManagerFile)
	{
		$this->_jobsiteFieldReportFileManagerFile = $jobsiteFieldReportFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteFieldReportsByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteFieldReportsByJobsiteDailyLogId)) {
			return self::$_arrJobsiteFieldReportsByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteFieldReportsByJobsiteDailyLogId($arrJobsiteFieldReportsByJobsiteDailyLogId)
	{
		self::$_arrJobsiteFieldReportsByJobsiteDailyLogId = $arrJobsiteFieldReportsByJobsiteDailyLogId;
	}

	public static function getArrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId()
	{
		if (isset(self::$_arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId)) {
			return self::$_arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId($arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId)
	{
		self::$_arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId = $arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteFieldReports()
	{
		if (isset(self::$_arrAllJobsiteFieldReports)) {
			return self::$_arrAllJobsiteFieldReports;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteFieldReports($arrAllJobsiteFieldReports)
	{
		self::$_arrAllJobsiteFieldReports = $arrAllJobsiteFieldReports;
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
	 * @param int $jobsite_field_report_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_field_report_id, $table='jobsite_field_reports', $module='JobsiteFieldReport')
	{
		$jobsiteFieldReport = parent::findById($database, $jobsite_field_report_id, $table, $module);

		return $jobsiteFieldReport;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_field_report_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteFieldReportByIdExtended($database, $jobsite_field_report_id)
	{
		$jobsite_field_report_id = (int) $jobsite_field_report_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jfr_fk_jdl.`id` AS 'jfr_fk_jdl__jobsite_daily_log_id',
	jfr_fk_jdl.`project_id` AS 'jfr_fk_jdl__project_id',
	jfr_fk_jdl.`modified_by_contact_id` AS 'jfr_fk_jdl__modified_by_contact_id',
	jfr_fk_jdl.`created_by_contact_id` AS 'jfr_fk_jdl__created_by_contact_id',
	jfr_fk_jdl.`modified` AS 'jfr_fk_jdl__modified',
	jfr_fk_jdl.`jobsite_daily_log_created_date` AS 'jfr_fk_jdl__jobsite_daily_log_created_date',

	jfr_fk_fmfiles.`id` AS 'jfr_fk_fmfiles__file_manager_file_id',
	jfr_fk_fmfiles.`user_company_id` AS 'jfr_fk_fmfiles__user_company_id',
	jfr_fk_fmfiles.`contact_id` AS 'jfr_fk_fmfiles__contact_id',
	jfr_fk_fmfiles.`project_id` AS 'jfr_fk_fmfiles__project_id',
	jfr_fk_fmfiles.`file_manager_folder_id` AS 'jfr_fk_fmfiles__file_manager_folder_id',
	jfr_fk_fmfiles.`file_location_id` AS 'jfr_fk_fmfiles__file_location_id',
	jfr_fk_fmfiles.`virtual_file_name` AS 'jfr_fk_fmfiles__virtual_file_name',
	jfr_fk_fmfiles.`version_number` AS 'jfr_fk_fmfiles__version_number',
	jfr_fk_fmfiles.`virtual_file_name_sha1` AS 'jfr_fk_fmfiles__virtual_file_name_sha1',
	jfr_fk_fmfiles.`virtual_file_mime_type` AS 'jfr_fk_fmfiles__virtual_file_mime_type',
	jfr_fk_fmfiles.`modified` AS 'jfr_fk_fmfiles__modified',
	jfr_fk_fmfiles.`created` AS 'jfr_fk_fmfiles__created',
	jfr_fk_fmfiles.`deleted_flag` AS 'jfr_fk_fmfiles__deleted_flag',
	jfr_fk_fmfiles.`directly_deleted_flag` AS 'jfr_fk_fmfiles__directly_deleted_flag',

	jfr.*

FROM `jobsite_field_reports` jfr
	INNER JOIN `jobsite_daily_logs` jfr_fk_jdl ON jfr.`jobsite_daily_log_id` = jfr_fk_jdl.`id`
	INNER JOIN `file_manager_files` jfr_fk_fmfiles ON jfr.`jobsite_field_report_file_manager_file_id` = jfr_fk_fmfiles.`id`
WHERE jfr.`id` = ?
";
		$arrValues = array($jobsite_field_report_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_field_report_id = $row['id'];
			$jobsiteFieldReport = self::instantiateOrm($database, 'JobsiteFieldReport', $row, null, $jobsite_field_report_id);
			/* @var $jobsiteFieldReport JobsiteFieldReport */
			$jobsiteFieldReport->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jfr_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jfr_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteFieldReport->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_field_report_file_manager_file_id'])) {
				$jobsite_field_report_file_manager_file_id = $row['jobsite_field_report_file_manager_file_id'];
				$row['jfr_fk_fmfiles__id'] = $jobsite_field_report_file_manager_file_id;
				$jobsiteFieldReportFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $jobsite_field_report_file_manager_file_id, 'jfr_fk_fmfiles__');
				/* @var $jobsiteFieldReportFileManagerFile FileManagerFile */
				$jobsiteFieldReportFileManagerFile->convertPropertiesToData();
			} else {
				$jobsiteFieldReportFileManagerFile = false;
			}
			$jobsiteFieldReport->setJobsiteFieldReportFileManagerFile($jobsiteFieldReportFileManagerFile);

			return $jobsiteFieldReport;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_field_report` (`jobsite_daily_log_id`,`jobsite_field_report_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_field_report_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteFieldReportFileManagerFileId($database, $jobsite_daily_log_id, $jobsite_field_report_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jfr.*

FROM `jobsite_field_reports` jfr
WHERE jfr.`jobsite_daily_log_id` = ?
AND jfr.`jobsite_field_report_file_manager_file_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_field_report_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_field_report_id = $row['id'];
			$jobsiteFieldReport = self::instantiateOrm($database, 'JobsiteFieldReport', $row, null, $jobsite_field_report_id);
			/* @var $jobsiteFieldReport JobsiteFieldReport */
			return $jobsiteFieldReport;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteFieldReportIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteFieldReportsByArrJobsiteFieldReportIds($database, $arrJobsiteFieldReportIds, Input $options=null)
	{
		if (empty($arrJobsiteFieldReportIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_field_report_file_manager_file_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jfr.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteFieldReport = new JobsiteFieldReport($database);
			$sqlOrderByColumns = $tmpJobsiteFieldReport->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteFieldReportIds as $k => $jobsite_field_report_id) {
			$jobsite_field_report_id = (int) $jobsite_field_report_id;
			$arrJobsiteFieldReportIds[$k] = $db->escape($jobsite_field_report_id);
		}
		$csvJobsiteFieldReportIds = join(',', $arrJobsiteFieldReportIds);

		$query =
"
SELECT

	jfr.*

FROM `jobsite_field_reports` jfr
WHERE jfr.`id` IN ($csvJobsiteFieldReportIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteFieldReportsByCsvJobsiteFieldReportIds = array();
		while ($row = $db->fetch()) {
			$jobsite_field_report_id = $row['id'];
			$jobsiteFieldReport = self::instantiateOrm($database, 'JobsiteFieldReport', $row, null, $jobsite_field_report_id);
			/* @var $jobsiteFieldReport JobsiteFieldReport */
			$jobsiteFieldReport->convertPropertiesToData();

			$arrJobsiteFieldReportsByCsvJobsiteFieldReportIds[$jobsite_field_report_id] = $jobsiteFieldReport;
		}

		$db->free_result();

		return $arrJobsiteFieldReportsByCsvJobsiteFieldReportIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_field_reports_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteFieldReportsByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteFieldReportsByJobsiteDailyLogId = null;
		}

		$arrJobsiteFieldReportsByJobsiteDailyLogId = self::$_arrJobsiteFieldReportsByJobsiteDailyLogId;
		if (isset($arrJobsiteFieldReportsByJobsiteDailyLogId) && !empty($arrJobsiteFieldReportsByJobsiteDailyLogId)) {
			return $arrJobsiteFieldReportsByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_field_report_file_manager_file_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jfr.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteFieldReport = new JobsiteFieldReport($database);
			$sqlOrderByColumns = $tmpJobsiteFieldReport->constructSqlOrderByColumns($arrOrderByAttributes);

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

	jfr_fk_jdl.`id` AS 'jfr_fk_jdl__jobsite_daily_log_id',
	jfr_fk_jdl.`project_id` AS 'jfr_fk_jdl__project_id',
	jfr_fk_jdl.`modified_by_contact_id` AS 'jfr_fk_jdl__modified_by_contact_id',
	jfr_fk_jdl.`created_by_contact_id` AS 'jfr_fk_jdl__created_by_contact_id',
	jfr_fk_jdl.`modified` AS 'jfr_fk_jdl__modified',
	jfr_fk_jdl.`jobsite_daily_log_created_date` AS 'jfr_fk_jdl__jobsite_daily_log_created_date',

	jfr_fk_fmfiles.`id` AS 'jfr_fk_fmfiles__file_manager_file_id',
	jfr_fk_fmfiles.`user_company_id` AS 'jfr_fk_fmfiles__user_company_id',
	jfr_fk_fmfiles.`contact_id` AS 'jfr_fk_fmfiles__contact_id',
	jfr_fk_fmfiles.`project_id` AS 'jfr_fk_fmfiles__project_id',
	jfr_fk_fmfiles.`file_manager_folder_id` AS 'jfr_fk_fmfiles__file_manager_folder_id',
	jfr_fk_fmfiles.`file_location_id` AS 'jfr_fk_fmfiles__file_location_id',
	jfr_fk_fmfiles.`virtual_file_name` AS 'jfr_fk_fmfiles__virtual_file_name',
	jfr_fk_fmfiles.`version_number` AS 'jfr_fk_fmfiles__version_number',
	jfr_fk_fmfiles.`virtual_file_name_sha1` AS 'jfr_fk_fmfiles__virtual_file_name_sha1',
	jfr_fk_fmfiles.`virtual_file_mime_type` AS 'jfr_fk_fmfiles__virtual_file_mime_type',
	jfr_fk_fmfiles.`modified` AS 'jfr_fk_fmfiles__modified',
	jfr_fk_fmfiles.`created` AS 'jfr_fk_fmfiles__created',
	jfr_fk_fmfiles.`deleted_flag` AS 'jfr_fk_fmfiles__deleted_flag',
	jfr_fk_fmfiles.`directly_deleted_flag` AS 'jfr_fk_fmfiles__directly_deleted_flag',

	jfr.*

FROM `jobsite_field_reports` jfr
	INNER JOIN `jobsite_daily_logs` jfr_fk_jdl ON jfr.`jobsite_daily_log_id` = jfr_fk_jdl.`id`
	INNER JOIN `file_manager_files` jfr_fk_fmfiles ON jfr.`jobsite_field_report_file_manager_file_id` = jfr_fk_fmfiles.`id`
WHERE jfr.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_field_report_file_manager_file_id` ASC, `sort_order` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteFieldReportsByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_field_report_id = $row['id'];
			$jobsiteFieldReport = self::instantiateOrm($database, 'JobsiteFieldReport', $row, null, $jobsite_field_report_id);
			/* @var $jobsiteFieldReport JobsiteFieldReport */

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jfr_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jfr_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteFieldReport->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_field_report_file_manager_file_id'])) {
				$jobsite_field_report_file_manager_file_id = $row['jobsite_field_report_file_manager_file_id'];
				$row['jfr_fk_fmfiles__id'] = $jobsite_field_report_file_manager_file_id;
				$jobsiteFieldReportFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $jobsite_field_report_file_manager_file_id, 'jfr_fk_fmfiles__');
				/* @var $jobsiteFieldReportFileManagerFile FileManagerFile */
				$jobsiteFieldReportFileManagerFile->convertPropertiesToData();
			} else {
				$jobsiteFieldReportFileManagerFile = false;
			}
			$jobsiteFieldReport->setJobsiteFieldReportFileManagerFile($jobsiteFieldReportFileManagerFile);

			$arrJobsiteFieldReportsByJobsiteDailyLogId[$jobsite_field_report_id] = $jobsiteFieldReport;
		}

		$db->free_result();

		self::$_arrJobsiteFieldReportsByJobsiteDailyLogId = $arrJobsiteFieldReportsByJobsiteDailyLogId;

		return $arrJobsiteFieldReportsByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `jobsite_field_reports_fk_fmfiles` foreign key (`jobsite_field_report_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_field_report_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId($database, $jobsite_field_report_file_manager_file_id, Input $options=null)
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
			self::$_arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId = null;
		}

		$arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId = self::$_arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId;
		if (isset($arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId) && !empty($arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId)) {
			return $arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId;
		}

		$jobsite_field_report_file_manager_file_id = (int) $jobsite_field_report_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_field_report_file_manager_file_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jfr.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteFieldReport = new JobsiteFieldReport($database);
			$sqlOrderByColumns = $tmpJobsiteFieldReport->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jfr.*

FROM `jobsite_field_reports` jfr
WHERE jfr.`jobsite_field_report_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_field_report_file_manager_file_id` ASC, `sort_order` ASC
		$arrValues = array($jobsite_field_report_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$jobsite_field_report_id = $row['id'];
			$jobsiteFieldReport = self::instantiateOrm($database, 'JobsiteFieldReport', $row, null, $jobsite_field_report_id);
			/* @var $jobsiteFieldReport JobsiteFieldReport */
			$arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId[$jobsite_field_report_id] = $jobsiteFieldReport;
		}

		$db->free_result();

		self::$_arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId = $arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId;

		return $arrJobsiteFieldReportsByJobsiteFieldReportFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_field_reports records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteFieldReports($database, Input $options=null)
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
			self::$_arrAllJobsiteFieldReports = null;
		}

		$arrAllJobsiteFieldReports = self::$_arrAllJobsiteFieldReports;
		if (isset($arrAllJobsiteFieldReports) && !empty($arrAllJobsiteFieldReports)) {
			return $arrAllJobsiteFieldReports;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_field_report_file_manager_file_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jfr.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteFieldReport = new JobsiteFieldReport($database);
			$sqlOrderByColumns = $tmpJobsiteFieldReport->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jfr.*

FROM `jobsite_field_reports` jfr{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_field_report_file_manager_file_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteFieldReports = array();
		while ($row = $db->fetch()) {
			$jobsite_field_report_id = $row['id'];
			$jobsiteFieldReport = self::instantiateOrm($database, 'JobsiteFieldReport', $row, null, $jobsite_field_report_id);
			/* @var $jobsiteFieldReport JobsiteFieldReport */
			$arrAllJobsiteFieldReports[$jobsite_field_report_id] = $jobsiteFieldReport;
		}

		$db->free_result();

		self::$_arrAllJobsiteFieldReports = $arrAllJobsiteFieldReports;

		return $arrAllJobsiteFieldReports;
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
INTO `jobsite_field_reports`
(`jobsite_daily_log_id`, `jobsite_field_report_file_manager_file_id`, `sort_order`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_field_report_file_manager_file_id, $this->sort_order, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_field_report_id = $db->insertId;
		$db->free_result();

		return $jobsite_field_report_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

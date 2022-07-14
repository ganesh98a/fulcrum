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
 * DailyConstructionReport.
 *
 * @category   Framework
 * @package    DailyConstructionReport
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DailyConstructionReport extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DailyConstructionReport';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'daily_construction_reports';

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
	 * unique index `unique_daily_construction_report` (`jobsite_daily_log_id`,`daily_construction_report_type_id`,`daily_construction_report_sequence_number`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_daily_construction_report' => array(
			'jobsite_daily_log_id' => 'int',
			'daily_construction_report_type_id' => 'int',
			'daily_construction_report_sequence_number' => 'int'
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
		'id' => 'daily_construction_report_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'daily_construction_report_type_id' => 'daily_construction_report_type_id',
		'daily_construction_report_file_manager_file_id' => 'daily_construction_report_file_manager_file_id',

		'daily_construction_report_sequence_number' => 'daily_construction_report_sequence_number'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $daily_construction_report_id;

	public $jobsite_daily_log_id;
	public $daily_construction_report_type_id;
	public $daily_construction_report_file_manager_file_id;

	public $daily_construction_report_sequence_number;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrDailyConstructionReportsByJobsiteDailyLogId;
	protected static $_arrDailyConstructionReportsByDailyConstructionReportTypeId;
	protected static $_arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDailyConstructionReports;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_dailyConstructionReportType;
	private $_dailyConstructionReportFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='daily_construction_reports')
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

	public function getDailyConstructionReportType()
	{
		if (isset($this->_dailyConstructionReportType)) {
			return $this->_dailyConstructionReportType;
		} else {
			return null;
		}
	}

	public function setDailyConstructionReportType($dailyConstructionReportType)
	{
		$this->_dailyConstructionReportType = $dailyConstructionReportType;
	}

	public function getDailyConstructionReportFileManagerFile()
	{
		if (isset($this->_dailyConstructionReportFileManagerFile)) {
			return $this->_dailyConstructionReportFileManagerFile;
		} else {
			return null;
		}
	}

	public function setDailyConstructionReportFileManagerFile($dailyConstructionReportFileManagerFile)
	{
		$this->_dailyConstructionReportFileManagerFile = $dailyConstructionReportFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrDailyConstructionReportsByJobsiteDailyLogId()
	{
		if (isset(self::$_arrDailyConstructionReportsByJobsiteDailyLogId)) {
			return self::$_arrDailyConstructionReportsByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrDailyConstructionReportsByJobsiteDailyLogId($arrDailyConstructionReportsByJobsiteDailyLogId)
	{
		self::$_arrDailyConstructionReportsByJobsiteDailyLogId = $arrDailyConstructionReportsByJobsiteDailyLogId;
	}

	public static function getArrDailyConstructionReportsByDailyConstructionReportTypeId()
	{
		if (isset(self::$_arrDailyConstructionReportsByDailyConstructionReportTypeId)) {
			return self::$_arrDailyConstructionReportsByDailyConstructionReportTypeId;
		} else {
			return null;
		}
	}

	public static function setArrDailyConstructionReportsByDailyConstructionReportTypeId($arrDailyConstructionReportsByDailyConstructionReportTypeId)
	{
		self::$_arrDailyConstructionReportsByDailyConstructionReportTypeId = $arrDailyConstructionReportsByDailyConstructionReportTypeId;
	}

	public static function getArrDailyConstructionReportsByDailyConstructionReportFileManagerFileId()
	{
		if (isset(self::$_arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId)) {
			return self::$_arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrDailyConstructionReportsByDailyConstructionReportFileManagerFileId($arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId)
	{
		self::$_arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId = $arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllDailyConstructionReports()
	{
		if (isset(self::$_arrAllDailyConstructionReports)) {
			return self::$_arrAllDailyConstructionReports;
		} else {
			return null;
		}
	}

	public static function setArrAllDailyConstructionReports($arrAllDailyConstructionReports)
	{
		self::$_arrAllDailyConstructionReports = $arrAllDailyConstructionReports;
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
	 * @param int $daily_construction_report_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $daily_construction_report_id, $table='daily_construction_reports', $module='DailyConstructionReport')
	{
		$dailyConstructionReport = parent::findById($database, $daily_construction_report_id, $table, $module);

		return $dailyConstructionReport;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $daily_construction_report_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findDailyConstructionReportByIdExtended($database, $daily_construction_report_id)
	{
		$daily_construction_report_id = (int) $daily_construction_report_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	dcr_fk_jdl.`id` AS 'dcr_fk_jdl__jobsite_daily_log_id',
	dcr_fk_jdl.`project_id` AS 'dcr_fk_jdl__project_id',
	dcr_fk_jdl.`modified_by_contact_id` AS 'dcr_fk_jdl__modified_by_contact_id',
	dcr_fk_jdl.`created_by_contact_id` AS 'dcr_fk_jdl__created_by_contact_id',
	dcr_fk_jdl.`modified` AS 'dcr_fk_jdl__modified',
	dcr_fk_jdl.`jobsite_daily_log_created_date` AS 'dcr_fk_jdl__jobsite_daily_log_created_date',

	dcr_fk_dcrt.`id` AS 'dcr_fk_dcrt__daily_construction_report_type_id',
	dcr_fk_dcrt.`user_company_id` AS 'dcr_fk_dcrt__user_company_id',
	dcr_fk_dcrt.`daily_construction_report_type` AS 'dcr_fk_dcrt__daily_construction_report_type',
	dcr_fk_dcrt.`disabled_flag` AS 'dcr_fk_dcrt__disabled_flag',
	dcr_fk_dcrt.`sort_order` AS 'dcr_fk_dcrt__sort_order',

	dcr_fk_fmfiles.`id` AS 'dcr_fk_fmfiles__file_manager_file_id',
	dcr_fk_fmfiles.`user_company_id` AS 'dcr_fk_fmfiles__user_company_id',
	dcr_fk_fmfiles.`contact_id` AS 'dcr_fk_fmfiles__contact_id',
	dcr_fk_fmfiles.`project_id` AS 'dcr_fk_fmfiles__project_id',
	dcr_fk_fmfiles.`file_manager_folder_id` AS 'dcr_fk_fmfiles__file_manager_folder_id',
	dcr_fk_fmfiles.`file_location_id` AS 'dcr_fk_fmfiles__file_location_id',
	dcr_fk_fmfiles.`virtual_file_name` AS 'dcr_fk_fmfiles__virtual_file_name',
	dcr_fk_fmfiles.`version_number` AS 'dcr_fk_fmfiles__version_number',
	dcr_fk_fmfiles.`virtual_file_name_sha1` AS 'dcr_fk_fmfiles__virtual_file_name_sha1',
	dcr_fk_fmfiles.`virtual_file_mime_type` AS 'dcr_fk_fmfiles__virtual_file_mime_type',
	dcr_fk_fmfiles.`modified` AS 'dcr_fk_fmfiles__modified',
	dcr_fk_fmfiles.`created` AS 'dcr_fk_fmfiles__created',
	dcr_fk_fmfiles.`deleted_flag` AS 'dcr_fk_fmfiles__deleted_flag',
	dcr_fk_fmfiles.`directly_deleted_flag` AS 'dcr_fk_fmfiles__directly_deleted_flag',

	dcr.*

FROM `daily_construction_reports` dcr
	INNER JOIN `jobsite_daily_logs` dcr_fk_jdl ON dcr.`jobsite_daily_log_id` = dcr_fk_jdl.`id`
	INNER JOIN `daily_construction_report_types` dcr_fk_dcrt ON dcr.`daily_construction_report_type_id` = dcr_fk_dcrt.`id`
	INNER JOIN `file_manager_files` dcr_fk_fmfiles ON dcr.`daily_construction_report_file_manager_file_id` = dcr_fk_fmfiles.`id`
WHERE dcr.`id` = ?
";
		$arrValues = array($daily_construction_report_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$daily_construction_report_id = $row['id'];
			$dailyConstructionReport = self::instantiateOrm($database, 'DailyConstructionReport', $row, null, $daily_construction_report_id);
			/* @var $dailyConstructionReport DailyConstructionReport */
			$dailyConstructionReport->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['dcr_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'dcr_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$dailyConstructionReport->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['daily_construction_report_type_id'])) {
				$daily_construction_report_type_id = $row['daily_construction_report_type_id'];
				$row['dcr_fk_dcrt__id'] = $daily_construction_report_type_id;
				$dailyConstructionReportType = self::instantiateOrm($database, 'DailyConstructionReportType', $row, null, $daily_construction_report_type_id, 'dcr_fk_dcrt__');
				/* @var $dailyConstructionReportType DailyConstructionReportType */
				$dailyConstructionReportType->convertPropertiesToData();
			} else {
				$dailyConstructionReportType = false;
			}
			$dailyConstructionReport->setDailyConstructionReportType($dailyConstructionReportType);

			if (isset($row['daily_construction_report_file_manager_file_id'])) {
				$daily_construction_report_file_manager_file_id = $row['daily_construction_report_file_manager_file_id'];
				$row['dcr_fk_fmfiles__id'] = $daily_construction_report_file_manager_file_id;
				$dailyConstructionReportFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $daily_construction_report_file_manager_file_id, 'dcr_fk_fmfiles__');
				/* @var $dailyConstructionReportFileManagerFile FileManagerFile */
				$dailyConstructionReportFileManagerFile->convertPropertiesToData();
			} else {
				$dailyConstructionReportFileManagerFile = false;
			}
			$dailyConstructionReport->setDailyConstructionReportFileManagerFile($dailyConstructionReportFileManagerFile);

			return $dailyConstructionReport;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_daily_construction_report` (`jobsite_daily_log_id`,`daily_construction_report_type_id`,`daily_construction_report_sequence_number`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $daily_construction_report_type_id
	 * @param int $daily_construction_report_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndDailyConstructionReportTypeIdAndDailyConstructionReportSequenceNumber($database, $jobsite_daily_log_id, $daily_construction_report_type_id, $daily_construction_report_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	dcr.*

FROM `daily_construction_reports` dcr
WHERE dcr.`jobsite_daily_log_id` = ?
AND dcr.`daily_construction_report_type_id` = ?
AND dcr.`daily_construction_report_sequence_number` = ?
";
		$arrValues = array($jobsite_daily_log_id, $daily_construction_report_type_id, $daily_construction_report_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$daily_construction_report_id = $row['id'];
			$dailyConstructionReport = self::instantiateOrm($database, 'DailyConstructionReport', $row, null, $daily_construction_report_id);
			/* @var $dailyConstructionReport DailyConstructionReport */
			return $dailyConstructionReport;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrDailyConstructionReportIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDailyConstructionReportsByArrDailyConstructionReportIds($database, $arrDailyConstructionReportIds, Input $options=null)
	{
		if (empty($arrDailyConstructionReportIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDailyConstructionReport = new DailyConstructionReport($database);
			$sqlOrderByColumns = $tmpDailyConstructionReport->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrDailyConstructionReportIds as $k => $daily_construction_report_id) {
			$daily_construction_report_id = (int) $daily_construction_report_id;
			$arrDailyConstructionReportIds[$k] = $db->escape($daily_construction_report_id);
		}
		$csvDailyConstructionReportIds = join(',', $arrDailyConstructionReportIds);

		$query =
"
SELECT

	dcr.*

FROM `daily_construction_reports` dcr
WHERE dcr.`id` IN ($csvDailyConstructionReportIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrDailyConstructionReportsByCsvDailyConstructionReportIds = array();
		while ($row = $db->fetch()) {
			$daily_construction_report_id = $row['id'];
			$dailyConstructionReport = self::instantiateOrm($database, 'DailyConstructionReport', $row, null, $daily_construction_report_id);
			/* @var $dailyConstructionReport DailyConstructionReport */
			$dailyConstructionReport->convertPropertiesToData();

			$arrDailyConstructionReportsByCsvDailyConstructionReportIds[$daily_construction_report_id] = $dailyConstructionReport;
		}

		$db->free_result();

		return $arrDailyConstructionReportsByCsvDailyConstructionReportIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `daily_construction_reports_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDailyConstructionReportsByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrDailyConstructionReportsByJobsiteDailyLogId = null;
		}

		$arrDailyConstructionReportsByJobsiteDailyLogId = self::$_arrDailyConstructionReportsByJobsiteDailyLogId;
		if (isset($arrDailyConstructionReportsByJobsiteDailyLogId) && !empty($arrDailyConstructionReportsByJobsiteDailyLogId)) {
			return $arrDailyConstructionReportsByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDailyConstructionReport = new DailyConstructionReport($database);
			$sqlOrderByColumns = $tmpDailyConstructionReport->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dcr.*

FROM `daily_construction_reports` dcr
WHERE dcr.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDailyConstructionReportsByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$daily_construction_report_id = $row['id'];
			$dailyConstructionReport = self::instantiateOrm($database, 'DailyConstructionReport', $row, null, $daily_construction_report_id);
			/* @var $dailyConstructionReport DailyConstructionReport */
			$arrDailyConstructionReportsByJobsiteDailyLogId[$daily_construction_report_id] = $dailyConstructionReport;
		}

		$db->free_result();

		self::$_arrDailyConstructionReportsByJobsiteDailyLogId = $arrDailyConstructionReportsByJobsiteDailyLogId;

		return $arrDailyConstructionReportsByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `daily_construction_reports_fk_dcrt` foreign key (`daily_construction_report_type_id`) references `daily_construction_report_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $daily_construction_report_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDailyConstructionReportsByDailyConstructionReportTypeId($database, $daily_construction_report_type_id, Input $options=null)
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
			self::$_arrDailyConstructionReportsByDailyConstructionReportTypeId = null;
		}

		$arrDailyConstructionReportsByDailyConstructionReportTypeId = self::$_arrDailyConstructionReportsByDailyConstructionReportTypeId;
		if (isset($arrDailyConstructionReportsByDailyConstructionReportTypeId) && !empty($arrDailyConstructionReportsByDailyConstructionReportTypeId)) {
			return $arrDailyConstructionReportsByDailyConstructionReportTypeId;
		}

		$daily_construction_report_type_id = (int) $daily_construction_report_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDailyConstructionReport = new DailyConstructionReport($database);
			$sqlOrderByColumns = $tmpDailyConstructionReport->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dcr.*

FROM `daily_construction_reports` dcr
WHERE dcr.`daily_construction_report_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$arrValues = array($daily_construction_report_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDailyConstructionReportsByDailyConstructionReportTypeId = array();
		while ($row = $db->fetch()) {
			$daily_construction_report_id = $row['id'];
			$dailyConstructionReport = self::instantiateOrm($database, 'DailyConstructionReport', $row, null, $daily_construction_report_id);
			/* @var $dailyConstructionReport DailyConstructionReport */
			$arrDailyConstructionReportsByDailyConstructionReportTypeId[$daily_construction_report_id] = $dailyConstructionReport;
		}

		$db->free_result();

		self::$_arrDailyConstructionReportsByDailyConstructionReportTypeId = $arrDailyConstructionReportsByDailyConstructionReportTypeId;

		return $arrDailyConstructionReportsByDailyConstructionReportTypeId;
	}

	/**
	 * Load by constraint `daily_construction_reports_fk_fmfiles` foreign key (`daily_construction_report_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $daily_construction_report_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDailyConstructionReportsByDailyConstructionReportFileManagerFileId($database, $daily_construction_report_file_manager_file_id, Input $options=null)
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
			self::$_arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId = null;
		}

		$arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId = self::$_arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId;
		if (isset($arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId) && !empty($arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId)) {
			return $arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId;
		}

		$daily_construction_report_file_manager_file_id = (int) $daily_construction_report_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDailyConstructionReport = new DailyConstructionReport($database);
			$sqlOrderByColumns = $tmpDailyConstructionReport->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dcr.*

FROM `daily_construction_reports` dcr
WHERE dcr.`daily_construction_report_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$arrValues = array($daily_construction_report_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$daily_construction_report_id = $row['id'];
			$dailyConstructionReport = self::instantiateOrm($database, 'DailyConstructionReport', $row, null, $daily_construction_report_id);
			/* @var $dailyConstructionReport DailyConstructionReport */
			$arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId[$daily_construction_report_id] = $dailyConstructionReport;
		}

		$db->free_result();

		self::$_arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId = $arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId;

		return $arrDailyConstructionReportsByDailyConstructionReportFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all daily_construction_reports records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDailyConstructionReports($database, Input $options=null)
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
			self::$_arrAllDailyConstructionReports = null;
		}

		$arrAllDailyConstructionReports = self::$_arrAllDailyConstructionReports;
		if (isset($arrAllDailyConstructionReports) && !empty($arrAllDailyConstructionReports)) {
			return $arrAllDailyConstructionReports;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDailyConstructionReport = new DailyConstructionReport($database);
			$sqlOrderByColumns = $tmpDailyConstructionReport->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dcr.*

FROM `daily_construction_reports` dcr{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `daily_construction_report_type_id` ASC, `daily_construction_report_file_manager_file_id` ASC, `daily_construction_report_sequence_number` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDailyConstructionReports = array();
		while ($row = $db->fetch()) {
			$daily_construction_report_id = $row['id'];
			$dailyConstructionReport = self::instantiateOrm($database, 'DailyConstructionReport', $row, null, $daily_construction_report_id);
			/* @var $dailyConstructionReport DailyConstructionReport */
			$arrAllDailyConstructionReports[$daily_construction_report_id] = $dailyConstructionReport;
		}

		$db->free_result();

		self::$_arrAllDailyConstructionReports = $arrAllDailyConstructionReports;

		return $arrAllDailyConstructionReports;
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
INTO `daily_construction_reports`
(`jobsite_daily_log_id`, `daily_construction_report_type_id`, `daily_construction_report_file_manager_file_id`, `daily_construction_report_sequence_number`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `daily_construction_report_file_manager_file_id` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->daily_construction_report_type_id, $this->daily_construction_report_file_manager_file_id, $this->daily_construction_report_sequence_number, $this->daily_construction_report_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$daily_construction_report_id = $db->insertId;
		$db->free_result();

		return $daily_construction_report_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

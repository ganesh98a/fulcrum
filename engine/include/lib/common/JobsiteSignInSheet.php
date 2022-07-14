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
 * JobsiteSignInSheet.
 *
 * @category   Framework
 * @package    JobsiteSignInSheet
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteSignInSheet extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteSignInSheet';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_sign_in_sheets';

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
	 * unique index `unique_jobsite_sign_in_sheet` (`jobsite_daily_log_id`,`jobsite_sign_in_sheet_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_sign_in_sheet' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_sign_in_sheet_file_manager_file_id' => 'int'
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
		'id' => 'jobsite_sign_in_sheet_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_sign_in_sheet_file_manager_file_id' => 'jobsite_sign_in_sheet_file_manager_file_id',

		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_sign_in_sheet_id;

	public $jobsite_daily_log_id;
	public $jobsite_sign_in_sheet_file_manager_file_id;

	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteSignInSheetsByJobsiteDailyLogId;
	protected static $_arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteSignInSheets;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteSignInSheetFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_sign_in_sheets')
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

	public function getJobsiteSignInSheetFileManagerFile()
	{
		if (isset($this->_jobsiteSignInSheetFileManagerFile)) {
			return $this->_jobsiteSignInSheetFileManagerFile;
		} else {
			return null;
		}
	}

	public function setJobsiteSignInSheetFileManagerFile($jobsiteSignInSheetFileManagerFile)
	{
		$this->_jobsiteSignInSheetFileManagerFile = $jobsiteSignInSheetFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteSignInSheetsByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteSignInSheetsByJobsiteDailyLogId)) {
			return self::$_arrJobsiteSignInSheetsByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSignInSheetsByJobsiteDailyLogId($arrJobsiteSignInSheetsByJobsiteDailyLogId)
	{
		self::$_arrJobsiteSignInSheetsByJobsiteDailyLogId = $arrJobsiteSignInSheetsByJobsiteDailyLogId;
	}

	public static function getArrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId()
	{
		if (isset(self::$_arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId)) {
			return self::$_arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId($arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId)
	{
		self::$_arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId = $arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteSignInSheets()
	{
		if (isset(self::$_arrAllJobsiteSignInSheets)) {
			return self::$_arrAllJobsiteSignInSheets;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteSignInSheets($arrAllJobsiteSignInSheets)
	{
		self::$_arrAllJobsiteSignInSheets = $arrAllJobsiteSignInSheets;
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
	 * @param int $jobsite_sign_in_sheet_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_sign_in_sheet_id, $table='jobsite_sign_in_sheets', $module='JobsiteSignInSheet')
	{
		$jobsiteSignInSheet = parent::findById($database, $jobsite_sign_in_sheet_id, $table, $module);

		return $jobsiteSignInSheet;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_sign_in_sheet_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteSignInSheetByIdExtended($database, $jobsite_sign_in_sheet_id)
	{
		$jobsite_sign_in_sheet_id = (int) $jobsite_sign_in_sheet_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jsis_fk_jdl.`id` AS 'jsis_fk_jdl__jobsite_daily_log_id',
	jsis_fk_jdl.`project_id` AS 'jsis_fk_jdl__project_id',
	jsis_fk_jdl.`modified_by_contact_id` AS 'jsis_fk_jdl__modified_by_contact_id',
	jsis_fk_jdl.`created_by_contact_id` AS 'jsis_fk_jdl__created_by_contact_id',
	jsis_fk_jdl.`modified` AS 'jsis_fk_jdl__modified',
	jsis_fk_jdl.`jobsite_daily_log_created_date` AS 'jsis_fk_jdl__jobsite_daily_log_created_date',

	jsis_fk_fmfiles.`id` AS 'jsis_fk_fmfiles__file_manager_file_id',
	jsis_fk_fmfiles.`user_company_id` AS 'jsis_fk_fmfiles__user_company_id',
	jsis_fk_fmfiles.`contact_id` AS 'jsis_fk_fmfiles__contact_id',
	jsis_fk_fmfiles.`project_id` AS 'jsis_fk_fmfiles__project_id',
	jsis_fk_fmfiles.`file_manager_folder_id` AS 'jsis_fk_fmfiles__file_manager_folder_id',
	jsis_fk_fmfiles.`file_location_id` AS 'jsis_fk_fmfiles__file_location_id',
	jsis_fk_fmfiles.`virtual_file_name` AS 'jsis_fk_fmfiles__virtual_file_name',
	jsis_fk_fmfiles.`version_number` AS 'jsis_fk_fmfiles__version_number',
	jsis_fk_fmfiles.`virtual_file_name_sha1` AS 'jsis_fk_fmfiles__virtual_file_name_sha1',
	jsis_fk_fmfiles.`virtual_file_mime_type` AS 'jsis_fk_fmfiles__virtual_file_mime_type',
	jsis_fk_fmfiles.`modified` AS 'jsis_fk_fmfiles__modified',
	jsis_fk_fmfiles.`created` AS 'jsis_fk_fmfiles__created',
	jsis_fk_fmfiles.`deleted_flag` AS 'jsis_fk_fmfiles__deleted_flag',
	jsis_fk_fmfiles.`directly_deleted_flag` AS 'jsis_fk_fmfiles__directly_deleted_flag',

	jsis.*

FROM `jobsite_sign_in_sheets` jsis
	INNER JOIN `jobsite_daily_logs` jsis_fk_jdl ON jsis.`jobsite_daily_log_id` = jsis_fk_jdl.`id`
	INNER JOIN `file_manager_files` jsis_fk_fmfiles ON jsis.`jobsite_sign_in_sheet_file_manager_file_id` = jsis_fk_fmfiles.`id`
WHERE jsis.`id` = ?
";
		$arrValues = array($jobsite_sign_in_sheet_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_sign_in_sheet_id = $row['id'];
			$jobsiteSignInSheet = self::instantiateOrm($database, 'JobsiteSignInSheet', $row, null, $jobsite_sign_in_sheet_id);
			/* @var $jobsiteSignInSheet JobsiteSignInSheet */
			$jobsiteSignInSheet->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jsis_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jsis_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteSignInSheet->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_sign_in_sheet_file_manager_file_id'])) {
				$jobsite_sign_in_sheet_file_manager_file_id = $row['jobsite_sign_in_sheet_file_manager_file_id'];
				$row['jsis_fk_fmfiles__id'] = $jobsite_sign_in_sheet_file_manager_file_id;
				$jobsiteSignInSheetFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $jobsite_sign_in_sheet_file_manager_file_id, 'jsis_fk_fmfiles__');
				/* @var $jobsiteSignInSheetFileManagerFile FileManagerFile */
				$jobsiteSignInSheetFileManagerFile->convertPropertiesToData();
			} else {
				$jobsiteSignInSheetFileManagerFile = false;
			}
			$jobsiteSignInSheet->setJobsiteSignInSheetFileManagerFile($jobsiteSignInSheetFileManagerFile);

			return $jobsiteSignInSheet;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_sign_in_sheet` (`jobsite_daily_log_id`,`jobsite_sign_in_sheet_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_sign_in_sheet_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteSignInSheetFileManagerFileId($database, $jobsite_daily_log_id, $jobsite_sign_in_sheet_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jsis.*

FROM `jobsite_sign_in_sheets` jsis
WHERE jsis.`jobsite_daily_log_id` = ?
AND jsis.`jobsite_sign_in_sheet_file_manager_file_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_sign_in_sheet_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_sign_in_sheet_id = $row['id'];
			$jobsiteSignInSheet = self::instantiateOrm($database, 'JobsiteSignInSheet', $row, null, $jobsite_sign_in_sheet_id);
			/* @var $jobsiteSignInSheet JobsiteSignInSheet */
			return $jobsiteSignInSheet;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteSignInSheetIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSignInSheetsByArrJobsiteSignInSheetIds($database, $arrJobsiteSignInSheetIds, Input $options=null)
	{
		if (empty($arrJobsiteSignInSheetIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sign_in_sheet_file_manager_file_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jsis.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSignInSheet = new JobsiteSignInSheet($database);
			$sqlOrderByColumns = $tmpJobsiteSignInSheet->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteSignInSheetIds as $k => $jobsite_sign_in_sheet_id) {
			$jobsite_sign_in_sheet_id = (int) $jobsite_sign_in_sheet_id;
			$arrJobsiteSignInSheetIds[$k] = $db->escape($jobsite_sign_in_sheet_id);
		}
		$csvJobsiteSignInSheetIds = join(',', $arrJobsiteSignInSheetIds);

		$query =
"
SELECT

	jsis.*

FROM `jobsite_sign_in_sheets` jsis
WHERE jsis.`id` IN ($csvJobsiteSignInSheetIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteSignInSheetsByCsvJobsiteSignInSheetIds = array();
		while ($row = $db->fetch()) {
			$jobsite_sign_in_sheet_id = $row['id'];
			$jobsiteSignInSheet = self::instantiateOrm($database, 'JobsiteSignInSheet', $row, null, $jobsite_sign_in_sheet_id);
			/* @var $jobsiteSignInSheet JobsiteSignInSheet */
			$jobsiteSignInSheet->convertPropertiesToData();

			$arrJobsiteSignInSheetsByCsvJobsiteSignInSheetIds[$jobsite_sign_in_sheet_id] = $jobsiteSignInSheet;
		}

		$db->free_result();

		return $arrJobsiteSignInSheetsByCsvJobsiteSignInSheetIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_sign_in_sheets_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSignInSheetsByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteSignInSheetsByJobsiteDailyLogId = null;
		}

		$arrJobsiteSignInSheetsByJobsiteDailyLogId = self::$_arrJobsiteSignInSheetsByJobsiteDailyLogId;
		if (isset($arrJobsiteSignInSheetsByJobsiteDailyLogId) && !empty($arrJobsiteSignInSheetsByJobsiteDailyLogId)) {
			return $arrJobsiteSignInSheetsByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sign_in_sheet_file_manager_file_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jsis.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSignInSheet = new JobsiteSignInSheet($database);
			$sqlOrderByColumns = $tmpJobsiteSignInSheet->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		// LIMIT 10
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

	jsis_fk_jdl.`id` AS 'jsis_fk_jdl__jobsite_daily_log_id',
	jsis_fk_jdl.`project_id` AS 'jsis_fk_jdl__project_id',
	jsis_fk_jdl.`modified_by_contact_id` AS 'jsis_fk_jdl__modified_by_contact_id',
	jsis_fk_jdl.`created_by_contact_id` AS 'jsis_fk_jdl__created_by_contact_id',
	jsis_fk_jdl.`modified` AS 'jsis_fk_jdl__modified',
	jsis_fk_jdl.`jobsite_daily_log_created_date` AS 'jsis_fk_jdl__jobsite_daily_log_created_date',

	jsis_fk_fmfiles.`id` AS 'jsis_fk_fmfiles__file_manager_file_id',
	jsis_fk_fmfiles.`user_company_id` AS 'jsis_fk_fmfiles__user_company_id',
	jsis_fk_fmfiles.`contact_id` AS 'jsis_fk_fmfiles__contact_id',
	jsis_fk_fmfiles.`project_id` AS 'jsis_fk_fmfiles__project_id',
	jsis_fk_fmfiles.`file_manager_folder_id` AS 'jsis_fk_fmfiles__file_manager_folder_id',
	jsis_fk_fmfiles.`file_location_id` AS 'jsis_fk_fmfiles__file_location_id',
	jsis_fk_fmfiles.`virtual_file_name` AS 'jsis_fk_fmfiles__virtual_file_name',
	jsis_fk_fmfiles.`version_number` AS 'jsis_fk_fmfiles__version_number',
	jsis_fk_fmfiles.`virtual_file_name_sha1` AS 'jsis_fk_fmfiles__virtual_file_name_sha1',
	jsis_fk_fmfiles.`virtual_file_mime_type` AS 'jsis_fk_fmfiles__virtual_file_mime_type',
	jsis_fk_fmfiles.`modified` AS 'jsis_fk_fmfiles__modified',
	jsis_fk_fmfiles.`created` AS 'jsis_fk_fmfiles__created',
	jsis_fk_fmfiles.`deleted_flag` AS 'jsis_fk_fmfiles__deleted_flag',
	jsis_fk_fmfiles.`directly_deleted_flag` AS 'jsis_fk_fmfiles__directly_deleted_flag',

	jsis.*

FROM `jobsite_sign_in_sheets` jsis
	INNER JOIN `jobsite_daily_logs` jsis_fk_jdl ON jsis.`jobsite_daily_log_id` = jsis_fk_jdl.`id`
	INNER JOIN `file_manager_files` jsis_fk_fmfiles ON jsis.`jobsite_sign_in_sheet_file_manager_file_id` = jsis_fk_fmfiles.`id`
WHERE jsis.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSignInSheetsByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_sign_in_sheet_id = $row['id'];
			$jobsiteSignInSheet = self::instantiateOrm($database, 'JobsiteSignInSheet', $row, null, $jobsite_sign_in_sheet_id);
			/* @var $jobsiteSignInSheet JobsiteSignInSheet */
			$jobsiteSignInSheet->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jsis_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jsis_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteSignInSheet->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_sign_in_sheet_file_manager_file_id'])) {
				$jobsite_sign_in_sheet_file_manager_file_id = $row['jobsite_sign_in_sheet_file_manager_file_id'];
				$row['jsis_fk_fmfiles__id'] = $jobsite_sign_in_sheet_file_manager_file_id;
				$jobsiteSignInSheetFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $jobsite_sign_in_sheet_file_manager_file_id, 'jsis_fk_fmfiles__');
				/* @var $jobsiteSignInSheetFileManagerFile FileManagerFile */
				$jobsiteSignInSheetFileManagerFile->convertPropertiesToData();
			} else {
				$jobsiteSignInSheetFileManagerFile = false;
			}
			$jobsiteSignInSheet->setJobsiteSignInSheetFileManagerFile($jobsiteSignInSheetFileManagerFile);

			$arrJobsiteSignInSheetsByJobsiteDailyLogId[$jobsite_sign_in_sheet_id] = $jobsiteSignInSheet;
		}

		$db->free_result();

		self::$_arrJobsiteSignInSheetsByJobsiteDailyLogId = $arrJobsiteSignInSheetsByJobsiteDailyLogId;

		return $arrJobsiteSignInSheetsByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `jobsite_sign_in_sheets_fk_fmfiles` foreign key (`jobsite_sign_in_sheet_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_sign_in_sheet_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId($database, $jobsite_sign_in_sheet_file_manager_file_id, Input $options=null)
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
			self::$_arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId = null;
		}

		$arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId = self::$_arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId;
		if (isset($arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId) && !empty($arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId)) {
			return $arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId;
		}

		$jobsite_sign_in_sheet_file_manager_file_id = (int) $jobsite_sign_in_sheet_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sign_in_sheet_file_manager_file_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jsis.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSignInSheet = new JobsiteSignInSheet($database);
			$sqlOrderByColumns = $tmpJobsiteSignInSheet->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsis.*

FROM `jobsite_sign_in_sheets` jsis
WHERE jsis.`jobsite_sign_in_sheet_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sign_in_sheet_file_manager_file_id` ASC, `sort_order` ASC
		$arrValues = array($jobsite_sign_in_sheet_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$jobsite_sign_in_sheet_id = $row['id'];
			$jobsiteSignInSheet = self::instantiateOrm($database, 'JobsiteSignInSheet', $row, null, $jobsite_sign_in_sheet_id);
			/* @var $jobsiteSignInSheet JobsiteSignInSheet */
			$arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId[$jobsite_sign_in_sheet_id] = $jobsiteSignInSheet;
		}

		$db->free_result();

		self::$_arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId = $arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId;

		return $arrJobsiteSignInSheetsByJobsiteSignInSheetFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_sign_in_sheets records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteSignInSheets($database, Input $options=null)
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
			self::$_arrAllJobsiteSignInSheets = null;
		}

		$arrAllJobsiteSignInSheets = self::$_arrAllJobsiteSignInSheets;
		if (isset($arrAllJobsiteSignInSheets) && !empty($arrAllJobsiteSignInSheets)) {
			return $arrAllJobsiteSignInSheets;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sign_in_sheet_file_manager_file_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jsis.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSignInSheet = new JobsiteSignInSheet($database);
			$sqlOrderByColumns = $tmpJobsiteSignInSheet->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsis.*

FROM `jobsite_sign_in_sheets` jsis{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_sign_in_sheet_file_manager_file_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteSignInSheets = array();
		while ($row = $db->fetch()) {
			$jobsite_sign_in_sheet_id = $row['id'];
			$jobsiteSignInSheet = self::instantiateOrm($database, 'JobsiteSignInSheet', $row, null, $jobsite_sign_in_sheet_id);
			/* @var $jobsiteSignInSheet JobsiteSignInSheet */
			$arrAllJobsiteSignInSheets[$jobsite_sign_in_sheet_id] = $jobsiteSignInSheet;
		}

		$db->free_result();

		self::$_arrAllJobsiteSignInSheets = $arrAllJobsiteSignInSheets;

		return $arrAllJobsiteSignInSheets;
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
INTO `jobsite_sign_in_sheets`
(`jobsite_daily_log_id`, `jobsite_sign_in_sheet_file_manager_file_id`, `sort_order`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_sign_in_sheet_file_manager_file_id, $this->sort_order, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_sign_in_sheet_id = $db->insertId;
		$db->free_result();

		return $jobsite_sign_in_sheet_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * JobsitePhoto.
 *
 * @category   Framework
 * @package    JobsitePhoto
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsitePhoto extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsitePhoto';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_photos';

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
	 * unique index `unique_jobsite_photo` (`jobsite_daily_log_id`,`jobsite_photo_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_photo' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_photo_file_manager_file_id' => 'int'
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
		'id' => 'jobsite_photo_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_photo_file_manager_file_id' => 'jobsite_photo_file_manager_file_id',
		'caption' => 'caption',
		'internal_use_only_flag' => 'internal_use_only_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_photo_id;

	public $jobsite_daily_log_id;
	public $jobsite_photo_file_manager_file_id;
	public $caption;
	public $internal_use_only_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsitePhotosByJobsiteDailyLogId;
	protected static $_arrJobsitePhotosByJobsitePhotoFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsitePhotos;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsitePhotoFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_photos')
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

	public function getJobsitePhotoFileManagerFile()
	{
		if (isset($this->_jobsitePhotoFileManagerFile)) {
			return $this->_jobsitePhotoFileManagerFile;
		} else {
			return null;
		}
	}

	public function setJobsitePhotoFileManagerFile($jobsitePhotoFileManagerFile)
	{
		$this->_jobsitePhotoFileManagerFile = $jobsitePhotoFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsitePhotosByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsitePhotosByJobsiteDailyLogId)) {
			return self::$_arrJobsitePhotosByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsitePhotosByJobsiteDailyLogId($arrJobsitePhotosByJobsiteDailyLogId)
	{
		self::$_arrJobsitePhotosByJobsiteDailyLogId = $arrJobsitePhotosByJobsiteDailyLogId;
	}

	public static function getArrJobsitePhotosByJobsitePhotoFileManagerFileId()
	{
		if (isset(self::$_arrJobsitePhotosByJobsitePhotoFileManagerFileId)) {
			return self::$_arrJobsitePhotosByJobsitePhotoFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrJobsitePhotosByJobsitePhotoFileManagerFileId($arrJobsitePhotosByJobsitePhotoFileManagerFileId)
	{
		self::$_arrJobsitePhotosByJobsitePhotoFileManagerFileId = $arrJobsitePhotosByJobsitePhotoFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsitePhotos()
	{
		if (isset(self::$_arrAllJobsitePhotos)) {
			return self::$_arrAllJobsitePhotos;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsitePhotos($arrAllJobsitePhotos)
	{
		self::$_arrAllJobsitePhotos = $arrAllJobsitePhotos;
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
	 * @param int $jobsite_photo_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_photo_id, $table='jobsite_photos', $module='JobsitePhoto')
	{
		$jobsitePhoto = parent::findById($database, $jobsite_photo_id, $table, $module);

		return $jobsitePhoto;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_photo_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsitePhotoByIdExtended($database, $jobsite_photo_id)
	{
		$jobsite_photo_id = (int) $jobsite_photo_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jp_fk_jdl.`id` AS 'jp_fk_jdl__jobsite_daily_log_id',
	jp_fk_jdl.`project_id` AS 'jp_fk_jdl__project_id',
	jp_fk_jdl.`modified_by_contact_id` AS 'jp_fk_jdl__modified_by_contact_id',
	jp_fk_jdl.`created_by_contact_id` AS 'jp_fk_jdl__created_by_contact_id',
	jp_fk_jdl.`modified` AS 'jp_fk_jdl__modified',
	jp_fk_jdl.`jobsite_daily_log_created_date` AS 'jp_fk_jdl__jobsite_daily_log_created_date',

	jp_fk_fmfiles.`id` AS 'jp_fk_fmfiles__file_manager_file_id',
	jp_fk_fmfiles.`user_company_id` AS 'jp_fk_fmfiles__user_company_id',
	jp_fk_fmfiles.`contact_id` AS 'jp_fk_fmfiles__contact_id',
	jp_fk_fmfiles.`project_id` AS 'jp_fk_fmfiles__project_id',
	jp_fk_fmfiles.`file_manager_folder_id` AS 'jp_fk_fmfiles__file_manager_folder_id',
	jp_fk_fmfiles.`file_location_id` AS 'jp_fk_fmfiles__file_location_id',
	jp_fk_fmfiles.`virtual_file_name` AS 'jp_fk_fmfiles__virtual_file_name',
	jp_fk_fmfiles.`version_number` AS 'jp_fk_fmfiles__version_number',
	jp_fk_fmfiles.`virtual_file_name_sha1` AS 'jp_fk_fmfiles__virtual_file_name_sha1',
	jp_fk_fmfiles.`virtual_file_mime_type` AS 'jp_fk_fmfiles__virtual_file_mime_type',
	jp_fk_fmfiles.`modified` AS 'jp_fk_fmfiles__modified',
	jp_fk_fmfiles.`created` AS 'jp_fk_fmfiles__created',
	jp_fk_fmfiles.`deleted_flag` AS 'jp_fk_fmfiles__deleted_flag',
	jp_fk_fmfiles.`directly_deleted_flag` AS 'jp_fk_fmfiles__directly_deleted_flag',

	jp.*

FROM `jobsite_photos` jp
	INNER JOIN `jobsite_daily_logs` jp_fk_jdl ON jp.`jobsite_daily_log_id` = jp_fk_jdl.`id`
	INNER JOIN `file_manager_files` jp_fk_fmfiles ON jp.`jobsite_photo_file_manager_file_id` = jp_fk_fmfiles.`id`
WHERE jp.`id` = ?
";
		$arrValues = array($jobsite_photo_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_photo_id = $row['id'];
			$jobsitePhoto = self::instantiateOrm($database, 'JobsitePhoto', $row, null, $jobsite_photo_id);
			/* @var $jobsitePhoto JobsitePhoto */
			$jobsitePhoto->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jp_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jp_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsitePhoto->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_photo_file_manager_file_id'])) {
				$jobsite_photo_file_manager_file_id = $row['jobsite_photo_file_manager_file_id'];
				$row['jp_fk_fmfiles__id'] = $jobsite_photo_file_manager_file_id;
				$jobsitePhotoFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $jobsite_photo_file_manager_file_id, 'jp_fk_fmfiles__');
				/* @var $jobsitePhotoFileManagerFile FileManagerFile */
				$jobsitePhotoFileManagerFile->convertPropertiesToData();
			} else {
				$jobsitePhotoFileManagerFile = false;
			}
			$jobsitePhoto->setJobsitePhotoFileManagerFile($jobsitePhotoFileManagerFile);

			return $jobsitePhoto;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_photo` (`jobsite_daily_log_id`,`jobsite_photo_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_photo_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsitePhotoFileManagerFileId($database, $jobsite_daily_log_id, $jobsite_photo_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jp.*

FROM `jobsite_photos` jp
WHERE jp.`jobsite_daily_log_id` = ?
AND jp.`jobsite_photo_file_manager_file_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_photo_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_photo_id = $row['id'];
			$jobsitePhoto = self::instantiateOrm($database, 'JobsitePhoto', $row, null, $jobsite_photo_id);
			/* @var $jobsitePhoto JobsitePhoto */
			return $jobsitePhoto;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsitePhotoIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsitePhotosByArrJobsitePhotoIds($database, $arrJobsitePhotoIds, Input $options=null)
	{
		if (empty($arrJobsitePhotoIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_photo_file_manager_file_id` ASC, `internal_use_only_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jp.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsitePhoto = new JobsitePhoto($database);
			$sqlOrderByColumns = $tmpJobsitePhoto->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsitePhotoIds as $k => $jobsite_photo_id) {
			$jobsite_photo_id = (int) $jobsite_photo_id;
			$arrJobsitePhotoIds[$k] = $db->escape($jobsite_photo_id);
		}
		$csvJobsitePhotoIds = join(',', $arrJobsitePhotoIds);

		$query =
"
SELECT

	jp.*

FROM `jobsite_photos` jp
WHERE jp.`id` IN ($csvJobsitePhotoIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsitePhotosByCsvJobsitePhotoIds = array();
		while ($row = $db->fetch()) {
			$jobsite_photo_id = $row['id'];
			$jobsitePhoto = self::instantiateOrm($database, 'JobsitePhoto', $row, null, $jobsite_photo_id);
			/* @var $jobsitePhoto JobsitePhoto */
			$jobsitePhoto->convertPropertiesToData();

			$arrJobsitePhotosByCsvJobsitePhotoIds[$jobsite_photo_id] = $jobsitePhoto;
		}

		$db->free_result();

		return $arrJobsitePhotosByCsvJobsitePhotoIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_photos_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsitePhotosByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null,$filter='N')
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
			self::$_arrJobsitePhotosByJobsiteDailyLogId = null;
		}

		$arrJobsitePhotosByJobsiteDailyLogId = self::$_arrJobsitePhotosByJobsiteDailyLogId;
		if (isset($arrJobsitePhotosByJobsiteDailyLogId) && !empty($arrJobsitePhotosByJobsiteDailyLogId)) {
			return $arrJobsitePhotosByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_photo_file_manager_file_id` ASC, `internal_use_only_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jp.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsitePhoto = new JobsitePhoto($database);
			$sqlOrderByColumns = $tmpJobsitePhoto->constructSqlOrderByColumns($arrOrderByAttributes);

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
		$filWhere="and jp.`internal_use_only_flag`='$filter' ";
	$query =
"
SELECT

	jp_fk_jdl.`id` AS 'jp_fk_jdl__jobsite_daily_log_id',
	jp_fk_jdl.`project_id` AS 'jp_fk_jdl__project_id',
	jp_fk_jdl.`modified_by_contact_id` AS 'jp_fk_jdl__modified_by_contact_id',
	jp_fk_jdl.`created_by_contact_id` AS 'jp_fk_jdl__created_by_contact_id',
	jp_fk_jdl.`modified` AS 'jp_fk_jdl__modified',
	jp_fk_jdl.`jobsite_daily_log_created_date` AS 'jp_fk_jdl__jobsite_daily_log_created_date',

	jp_fk_fmfiles.`id` AS 'jp_fk_fmfiles__file_manager_file_id',
	jp_fk_fmfiles.`user_company_id` AS 'jp_fk_fmfiles__user_company_id',
	jp_fk_fmfiles.`contact_id` AS 'jp_fk_fmfiles__contact_id',
	jp_fk_fmfiles.`project_id` AS 'jp_fk_fmfiles__project_id',
	jp_fk_fmfiles.`file_manager_folder_id` AS 'jp_fk_fmfiles__file_manager_folder_id',
	jp_fk_fmfiles.`file_location_id` AS 'jp_fk_fmfiles__file_location_id',
	jp_fk_fmfiles.`virtual_file_name` AS 'jp_fk_fmfiles__virtual_file_name',
	jp_fk_fmfiles.`version_number` AS 'jp_fk_fmfiles__version_number',
	jp_fk_fmfiles.`virtual_file_name_sha1` AS 'jp_fk_fmfiles__virtual_file_name_sha1',
	jp_fk_fmfiles.`virtual_file_mime_type` AS 'jp_fk_fmfiles__virtual_file_mime_type',
	jp_fk_fmfiles.`modified` AS 'jp_fk_fmfiles__modified',
	jp_fk_fmfiles.`created` AS 'jp_fk_fmfiles__created',
	jp_fk_fmfiles.`deleted_flag` AS 'jp_fk_fmfiles__deleted_flag',
	jp_fk_fmfiles.`directly_deleted_flag` AS 'jp_fk_fmfiles__directly_deleted_flag',

	jp.*
FROM `jobsite_photos` jp
	INNER JOIN `jobsite_daily_logs` jp_fk_jdl ON jp.`jobsite_daily_log_id` = jp_fk_jdl.`id`
	INNER JOIN `file_manager_files` jp_fk_fmfiles ON jp.`jobsite_photo_file_manager_file_id` = jp_fk_fmfiles.`id`
WHERE jp.`jobsite_daily_log_id` = ? $filWhere {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_photo_file_manager_file_id` ASC, `internal_use_only_flag` ASC, `sort_order` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsitePhotosByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_photo_id = $row['id'];
			$jobsitePhoto = self::instantiateOrm($database, 'JobsitePhoto', $row, null, $jobsite_photo_id);
			/* @var $jobsitePhoto JobsitePhoto */
			$jobsitePhoto->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jp_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jp_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsitePhoto->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_photo_file_manager_file_id'])) {
				$jobsite_photo_file_manager_file_id = $row['jobsite_photo_file_manager_file_id'];
				$row['jp_fk_fmfiles__id'] = $jobsite_photo_file_manager_file_id;
				$jobsitePhotoFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $jobsite_photo_file_manager_file_id, 'jp_fk_fmfiles__');
				/* @var $jobsitePhotoFileManagerFile FileManagerFile */
				$jobsitePhotoFileManagerFile->convertPropertiesToData();
			} else {
				$jobsitePhotoFileManagerFile = false;
			}
			$jobsitePhoto->setJobsitePhotoFileManagerFile($jobsitePhotoFileManagerFile);

			$arrJobsitePhotosByJobsiteDailyLogId[$jobsite_photo_id] = $jobsitePhoto;
		}

		$db->free_result();

		self::$_arrJobsitePhotosByJobsiteDailyLogId = $arrJobsitePhotosByJobsiteDailyLogId;

		return $arrJobsitePhotosByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `jobsite_photos_fk_fmfiles` foreign key (`jobsite_photo_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_photo_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsitePhotosByJobsitePhotoFileManagerFileId($database, $jobsite_photo_file_manager_file_id, Input $options=null)
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
			self::$_arrJobsitePhotosByJobsitePhotoFileManagerFileId = null;
		}

		$arrJobsitePhotosByJobsitePhotoFileManagerFileId = self::$_arrJobsitePhotosByJobsitePhotoFileManagerFileId;
		if (isset($arrJobsitePhotosByJobsitePhotoFileManagerFileId) && !empty($arrJobsitePhotosByJobsitePhotoFileManagerFileId)) {
			return $arrJobsitePhotosByJobsitePhotoFileManagerFileId;
		}

		$jobsite_photo_file_manager_file_id = (int) $jobsite_photo_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_photo_file_manager_file_id` ASC, `internal_use_only_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jp.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsitePhoto = new JobsitePhoto($database);
			$sqlOrderByColumns = $tmpJobsitePhoto->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jp.*

FROM `jobsite_photos` jp
WHERE jp.`jobsite_photo_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_photo_file_manager_file_id` ASC, `internal_use_only_flag` ASC, `sort_order` ASC
		$arrValues = array($jobsite_photo_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsitePhotosByJobsitePhotoFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$jobsite_photo_id = $row['id'];
			$jobsitePhoto = self::instantiateOrm($database, 'JobsitePhoto', $row, null, $jobsite_photo_id);
			/* @var $jobsitePhoto JobsitePhoto */
			$arrJobsitePhotosByJobsitePhotoFileManagerFileId[$jobsite_photo_id] = $jobsitePhoto;
		}

		$db->free_result();

		self::$_arrJobsitePhotosByJobsitePhotoFileManagerFileId = $arrJobsitePhotosByJobsitePhotoFileManagerFileId;

		return $arrJobsitePhotosByJobsitePhotoFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_photos records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsitePhotos($database, Input $options=null)
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
			self::$_arrAllJobsitePhotos = null;
		}

		$arrAllJobsitePhotos = self::$_arrAllJobsitePhotos;
		if (isset($arrAllJobsitePhotos) && !empty($arrAllJobsitePhotos)) {
			return $arrAllJobsitePhotos;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_photo_file_manager_file_id` ASC, `internal_use_only_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jp.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsitePhoto = new JobsitePhoto($database);
			$sqlOrderByColumns = $tmpJobsitePhoto->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jp.*

FROM `jobsite_photos` jp{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_photo_file_manager_file_id` ASC, `internal_use_only_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsitePhotos = array();
		while ($row = $db->fetch()) {
			$jobsite_photo_id = $row['id'];
			$jobsitePhoto = self::instantiateOrm($database, 'JobsitePhoto', $row, null, $jobsite_photo_id);
			/* @var $jobsitePhoto JobsitePhoto */
			$arrAllJobsitePhotos[$jobsite_photo_id] = $jobsitePhoto;
		}

		$db->free_result();

		self::$_arrAllJobsitePhotos = $arrAllJobsitePhotos;

		return $arrAllJobsitePhotos;
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
INTO `jobsite_photos`
(`jobsite_daily_log_id`, `jobsite_photo_file_manager_file_id`, `internal_use_only_flag`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `internal_use_only_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_photo_file_manager_file_id, $this->internal_use_only_flag, $this->sort_order, $this->internal_use_only_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_photo_id = $db->insertId;
		$db->free_result();

		return $jobsite_photo_id;
	}

	// Save: insert ignore

	public static function loadMostRecentJobsitePhotoByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsitePhotosByJobsiteDailyLogId = null;
		}

		$arrJobsitePhotosByJobsiteDailyLogId = self::$_arrJobsitePhotosByJobsiteDailyLogId;
		if (isset($arrJobsitePhotosByJobsiteDailyLogId) && !empty($arrJobsitePhotosByJobsiteDailyLogId)) {
			return $arrJobsitePhotosByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_photo_file_manager_file_id` ASC, `internal_use_only_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jp.`id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsitePhoto = new JobsitePhoto($database);
			$sqlOrderByColumns = $tmpJobsitePhoto->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}
		/*cutome change 1 to 12*/
		$sqlLimit = "\nLIMIT 12";
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jp_fk_jdl.`id` AS 'jp_fk_jdl__jobsite_daily_log_id',
	jp_fk_jdl.`project_id` AS 'jp_fk_jdl__project_id',
	jp_fk_jdl.`modified_by_contact_id` AS 'jp_fk_jdl__modified_by_contact_id',
	jp_fk_jdl.`created_by_contact_id` AS 'jp_fk_jdl__created_by_contact_id',
	jp_fk_jdl.`modified` AS 'jp_fk_jdl__modified',
	jp_fk_jdl.`jobsite_daily_log_created_date` AS 'jp_fk_jdl__jobsite_daily_log_created_date',

	jp_fk_fmfiles.`id` AS 'jp_fk_fmfiles__file_manager_file_id',
	jp_fk_fmfiles.`user_company_id` AS 'jp_fk_fmfiles__user_company_id',
	jp_fk_fmfiles.`contact_id` AS 'jp_fk_fmfiles__contact_id',
	jp_fk_fmfiles.`project_id` AS 'jp_fk_fmfiles__project_id',
	jp_fk_fmfiles.`file_manager_folder_id` AS 'jp_fk_fmfiles__file_manager_folder_id',
	jp_fk_fmfiles.`file_location_id` AS 'jp_fk_fmfiles__file_location_id',
	jp_fk_fmfiles.`virtual_file_name` AS 'jp_fk_fmfiles__virtual_file_name',
	jp_fk_fmfiles.`version_number` AS 'jp_fk_fmfiles__version_number',
	jp_fk_fmfiles.`virtual_file_name_sha1` AS 'jp_fk_fmfiles__virtual_file_name_sha1',
	jp_fk_fmfiles.`virtual_file_mime_type` AS 'jp_fk_fmfiles__virtual_file_mime_type',
	jp_fk_fmfiles.`modified` AS 'jp_fk_fmfiles__modified',
	jp_fk_fmfiles.`created` AS 'jp_fk_fmfiles__created',
	jp_fk_fmfiles.`deleted_flag` AS 'jp_fk_fmfiles__deleted_flag',
	jp_fk_fmfiles.`directly_deleted_flag` AS 'jp_fk_fmfiles__directly_deleted_flag',

	jp.*

FROM `jobsite_photos` jp
	INNER JOIN `jobsite_daily_logs` jp_fk_jdl ON jp.`jobsite_daily_log_id` = jp_fk_jdl.`id`
	INNER JOIN `file_manager_files` jp_fk_fmfiles ON jp.`jobsite_photo_file_manager_file_id` = jp_fk_fmfiles.`id`
WHERE jp.`jobsite_daily_log_id` = ? and `internal_use_only_flag`='N' {$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		// $row = $db->fetch();
		$jobsitePhotoArray = array();
		while ($row = $db->fetch()) {
			$jobsitePhoto = self::instantiateOrm($database, 'JobsitePhoto', $row);
			/* @var $jobsitePhoto JobsitePhoto */
			$jobsitePhoto->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jp_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jp_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsitePhoto->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_photo_file_manager_file_id'])) {
				$jobsite_photo_file_manager_file_id = $row['jobsite_photo_file_manager_file_id'];
				$row['jp_fk_fmfiles__id'] = $jobsite_photo_file_manager_file_id;
				$jobsitePhotoFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $jobsite_photo_file_manager_file_id, 'jp_fk_fmfiles__');
				/* @var $jobsitePhotoFileManagerFile FileManagerFile */
				$jobsitePhotoFileManagerFile->convertPropertiesToData();
			} else {
				$jobsitePhotoFileManagerFile = false;
			}
			$jobsitePhoto->setJobsitePhotoFileManagerFile($jobsitePhotoFileManagerFile);
			$jobsitePhotoArray[] = $jobsitePhoto;
			// exit;
		}
		$db->free_result();
		return $jobsitePhotoArray;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

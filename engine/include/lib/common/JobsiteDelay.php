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
 * JobsiteDelay.
 *
 * @category   Framework
 * @package    JobsiteDelay
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteDelay extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteDelay';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_delays';

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
	 * unique index `unique_jobsite_delays` (`jobsite_daily_log_id`,`jobsite_delay_subcategory_id`,`jobsite_building_id`,`jobsite_sitework_region_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_delays' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_delay_subcategory_id' => 'int',
			'jobsite_building_id' => 'int',
			'jobsite_sitework_region_id' => 'int'
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
		'id' => 'jobsite_delay_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_delay_subcategory_id' => 'jobsite_delay_subcategory_id',
		'jobsite_building_id' => 'jobsite_building_id',
		'jobsite_sitework_region_id' => 'jobsite_sitework_region_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_delay_id;

	public $jobsite_daily_log_id;
	public $jobsite_delay_subcategory_id;
	public $jobsite_building_id;
	public $jobsite_sitework_region_id;

	// Other Properties
	//protected $_otherPropertyHere;
	public $jobsite_delay_note;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteDelaysByJobsiteDailyLogId;
	protected static $_arrJobsiteDelaysByJobsiteDelaySubcategoryId;
	protected static $_arrJobsiteDelaysByJobsiteBuildingId;
	protected static $_arrJobsiteDelaysByJobsiteSiteworkRegionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteDelays;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteDelaySubcategory;
	private $_jobsiteBuilding;
	private $_jobsiteSiteworkRegion;
	private $_jobsiteDelayCategory;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_delays')
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

	public function getJobsiteDelaySubcategory()
	{
		if (isset($this->_jobsiteDelaySubcategory)) {
			return $this->_jobsiteDelaySubcategory;
		} else {
			return null;
		}
	}

	public function setJobsiteDelaySubcategory($jobsiteDelaySubcategory)
	{
		$this->_jobsiteDelaySubcategory = $jobsiteDelaySubcategory;
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

	public function getJobsiteDelayCategory()
	{
		if (isset($this->_jobsiteDelayCategory)) {
			return $this->_jobsiteDelayCategory;
		} else {
			return null;
		}
	}

	public function setJobsiteDelayCategory($jobsiteDelayCategory)
	{
		$this->_jobsiteDelayCategory = $jobsiteDelayCategory;
	}

	public function getJobsiteDelayNote()
	{
		if (isset($this->_jobsiteDelayNote)) {
			return $this->_jobsiteDelayNote;
		} else {
			return null;
		}
	}

	public function setJobsiteDelayNote($jobsiteDelayNote)
	{
		$this->_jobsiteDelayNote = $jobsiteDelayNote;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteDelaysByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteDelaysByJobsiteDailyLogId)) {
			return self::$_arrJobsiteDelaysByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDelaysByJobsiteDailyLogId($arrJobsiteDelaysByJobsiteDailyLogId)
	{
		self::$_arrJobsiteDelaysByJobsiteDailyLogId = $arrJobsiteDelaysByJobsiteDailyLogId;
	}

	public static function getArrJobsiteDelaysByJobsiteDelaySubcategoryId()
	{
		if (isset(self::$_arrJobsiteDelaysByJobsiteDelaySubcategoryId)) {
			return self::$_arrJobsiteDelaysByJobsiteDelaySubcategoryId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDelaysByJobsiteDelaySubcategoryId($arrJobsiteDelaysByJobsiteDelaySubcategoryId)
	{
		self::$_arrJobsiteDelaysByJobsiteDelaySubcategoryId = $arrJobsiteDelaysByJobsiteDelaySubcategoryId;
	}

	public static function getArrJobsiteDelaysByJobsiteBuildingId()
	{
		if (isset(self::$_arrJobsiteDelaysByJobsiteBuildingId)) {
			return self::$_arrJobsiteDelaysByJobsiteBuildingId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDelaysByJobsiteBuildingId($arrJobsiteDelaysByJobsiteBuildingId)
	{
		self::$_arrJobsiteDelaysByJobsiteBuildingId = $arrJobsiteDelaysByJobsiteBuildingId;
	}

	public static function getArrJobsiteDelaysByJobsiteSiteworkRegionId()
	{
		if (isset(self::$_arrJobsiteDelaysByJobsiteSiteworkRegionId)) {
			return self::$_arrJobsiteDelaysByJobsiteSiteworkRegionId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDelaysByJobsiteSiteworkRegionId($arrJobsiteDelaysByJobsiteSiteworkRegionId)
	{
		self::$_arrJobsiteDelaysByJobsiteSiteworkRegionId = $arrJobsiteDelaysByJobsiteSiteworkRegionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteDelays()
	{
		if (isset(self::$_arrAllJobsiteDelays)) {
			return self::$_arrAllJobsiteDelays;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteDelays($arrAllJobsiteDelays)
	{
		self::$_arrAllJobsiteDelays = $arrAllJobsiteDelays;
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
	 * @param int $jobsite_delay_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_delay_id, $table='jobsite_delays', $module='JobsiteDelay')
	{
		$jobsiteDelay = parent::findById($database, $jobsite_delay_id, $table, $module);

		return $jobsiteDelay;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_delay_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteDelayByIdExtended($database, $jobsite_delay_id)
	{
		$jobsite_delay_id = (int) $jobsite_delay_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jd_fk_jdl.`id` AS 'jd_fk_jdl__jobsite_daily_log_id',
	jd_fk_jdl.`project_id` AS 'jd_fk_jdl__project_id',
	jd_fk_jdl.`modified_by_contact_id` AS 'jd_fk_jdl__modified_by_contact_id',
	jd_fk_jdl.`created_by_contact_id` AS 'jd_fk_jdl__created_by_contact_id',
	jd_fk_jdl.`modified` AS 'jd_fk_jdl__modified',
	jd_fk_jdl.`jobsite_daily_log_created_date` AS 'jd_fk_jdl__jobsite_daily_log_created_date',

	jd_fk_jds.`id` AS 'jd_fk_jds__jobsite_delay_subcategory_id',
	jd_fk_jds.`jobsite_delay_category_id` AS 'jd_fk_jds__jobsite_delay_category_id',
	jd_fk_jds.`jobsite_delay_subcategory` AS 'jd_fk_jds__jobsite_delay_subcategory',
	jd_fk_jds.`disabled_flag` AS 'jd_fk_jds__disabled_flag',

	jd_fk_jb.`id` AS 'jd_fk_jb__jobsite_building_id',
	jd_fk_jb.`project_id` AS 'jd_fk_jb__project_id',
	jd_fk_jb.`jobsite_building` AS 'jd_fk_jb__jobsite_building',
	jd_fk_jb.`jobsite_building_description` AS 'jd_fk_jb__jobsite_building_description',
	jd_fk_jb.`sort_order` AS 'jd_fk_jb__sort_order',
	jd_fk_jb.`disabled_flag` AS 'jd_fk_jb__disabled_flag',

	jd_fk_jsr.`id` AS 'jd_fk_jsr__jobsite_sitework_region_id',
	jd_fk_jsr.`project_id` AS 'jd_fk_jsr__project_id',
	jd_fk_jsr.`jobsite_sitework_region` AS 'jd_fk_jsr__jobsite_sitework_region',
	jd_fk_jsr.`jobsite_sitework_region_description` AS 'jd_fk_jsr__jobsite_sitework_region_description',
	jd_fk_jsr.`sort_order` AS 'jd_fk_jsr__sort_order',
	jd_fk_jsr.`disabled_flag` AS 'jd_fk_jsr__disabled_flag',

	jd.*

FROM `jobsite_delays` jd
	INNER JOIN `jobsite_daily_logs` jd_fk_jdl ON jd.`jobsite_daily_log_id` = jd_fk_jdl.`id`
	INNER JOIN `jobsite_delay_subcategories` jd_fk_jds ON jd.`jobsite_delay_subcategory_id` = jd_fk_jds.`id`
	LEFT OUTER JOIN `jobsite_buildings` jd_fk_jb ON jd.`jobsite_building_id` = jd_fk_jb.`id`
	LEFT OUTER JOIN `jobsite_sitework_regions` jd_fk_jsr ON jd.`jobsite_sitework_region_id` = jd_fk_jsr.`id`
WHERE jd.`id` = ?
";
		$arrValues = array($jobsite_delay_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_delay_id = $row['id'];
			$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id);
			/* @var $jobsiteDelay JobsiteDelay */
			$jobsiteDelay->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jd_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jd_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteDelay->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_delay_subcategory_id'])) {
				$jobsite_delay_subcategory_id = $row['jobsite_delay_subcategory_id'];
				$row['jd_fk_jds__id'] = $jobsite_delay_subcategory_id;
				$jobsiteDelaySubcategory = self::instantiateOrm($database, 'JobsiteDelaySubcategory', $row, null, $jobsite_delay_subcategory_id, 'jd_fk_jds__');
				/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */
				$jobsiteDelaySubcategory->convertPropertiesToData();
			} else {
				$jobsiteDelaySubcategory = false;
			}
			$jobsiteDelay->setJobsiteDelaySubcategory($jobsiteDelaySubcategory);

			if (isset($row['jobsite_building_id'])) {
				$jobsite_building_id = $row['jobsite_building_id'];
				$row['jd_fk_jb__id'] = $jobsite_building_id;
				$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id, 'jd_fk_jb__');
				/* @var $jobsiteBuilding JobsiteBuilding */
				$jobsiteBuilding->convertPropertiesToData();
			} else {
				$jobsiteBuilding = false;
			}
			$jobsiteDelay->setJobsiteBuilding($jobsiteBuilding);

			if (isset($row['jobsite_sitework_region_id'])) {
				$jobsite_sitework_region_id = $row['jobsite_sitework_region_id'];
				$row['jd_fk_jsr__id'] = $jobsite_sitework_region_id;
				$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id, 'jd_fk_jsr__');
				/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
				$jobsiteSiteworkRegion->convertPropertiesToData();
			} else {
				$jobsiteSiteworkRegion = false;
			}
			$jobsiteDelay->setJobsiteSiteworkRegion($jobsiteSiteworkRegion);

			return $jobsiteDelay;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_delays` (`jobsite_daily_log_id`,`jobsite_delay_subcategory_id`,`jobsite_building_id`,`jobsite_sitework_region_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_delay_subcategory_id
	 * @param int $jobsite_building_id
	 * @param int $jobsite_sitework_region_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteDelaySubcategoryIdAndJobsiteBuildingIdAndJobsiteSiteworkRegionId($database, $jobsite_daily_log_id, $jobsite_delay_subcategory_id, $jobsite_building_id, $jobsite_sitework_region_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jd.*

FROM `jobsite_delays` jd
WHERE jd.`jobsite_daily_log_id` = ?
AND jd.`jobsite_delay_subcategory_id` = ?
AND jd.`jobsite_building_id` = ?
AND jd.`jobsite_sitework_region_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_delay_subcategory_id, $jobsite_building_id, $jobsite_sitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_delay_id = $row['id'];
			$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id);
			/* @var $jobsiteDelay JobsiteDelay */
			return $jobsiteDelay;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteDelayIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelaysByArrJobsiteDelayIds($database, $arrJobsiteDelayIds, Input $options=null)
	{
		if (empty($arrJobsiteDelayIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelay = new JobsiteDelay($database);
			$sqlOrderByColumns = $tmpJobsiteDelay->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteDelayIds as $k => $jobsite_delay_id) {
			$jobsite_delay_id = (int) $jobsite_delay_id;
			$arrJobsiteDelayIds[$k] = $db->escape($jobsite_delay_id);
		}
		$csvJobsiteDelayIds = join(',', $arrJobsiteDelayIds);

		$query =
"
SELECT

	jd.*

FROM `jobsite_delays` jd
WHERE jd.`id` IN ($csvJobsiteDelayIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteDelaysByCsvJobsiteDelayIds = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_id = $row['id'];
			$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id);
			/* @var $jobsiteDelay JobsiteDelay */
			$jobsiteDelay->convertPropertiesToData();

			$arrJobsiteDelaysByCsvJobsiteDelayIds[$jobsite_delay_id] = $jobsiteDelay;
		}

		$db->free_result();

		return $arrJobsiteDelaysByCsvJobsiteDelayIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_delays_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelaysByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteDelaysByJobsiteDailyLogId = null;
		}

		$arrJobsiteDelaysByJobsiteDailyLogId = self::$_arrJobsiteDelaysByJobsiteDailyLogId;
		if (isset($arrJobsiteDelaysByJobsiteDailyLogId) && !empty($arrJobsiteDelaysByJobsiteDailyLogId)) {
			return $arrJobsiteDelaysByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = ' ORDER BY `id` ASC';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelay = new JobsiteDelay($database);
			$sqlOrderByColumns = $tmpJobsiteDelay->constructSqlOrderByColumns($arrOrderByAttributes);

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

	jd_fk_jdl.`id` AS 'jd_fk_jdl__jobsite_daily_log_id',
	jd_fk_jdl.`project_id` AS 'jd_fk_jdl__project_id',
	jd_fk_jdl.`modified_by_contact_id` AS 'jd_fk_jdl__modified_by_contact_id',
	jd_fk_jdl.`created_by_contact_id` AS 'jd_fk_jdl__created_by_contact_id',
	jd_fk_jdl.`modified` AS 'jd_fk_jdl__modified',
	jd_fk_jdl.`jobsite_daily_log_created_date` AS 'jd_fk_jdl__jobsite_daily_log_created_date',

	jd_fk_jds.`id` AS 'jd_fk_jds__jobsite_delay_subcategory_id',
	jd_fk_jds.`jobsite_delay_category_id` AS 'jd_fk_jds__jobsite_delay_category_id',
	jd_fk_jds.`jobsite_delay_subcategory` AS 'jd_fk_jds__jobsite_delay_subcategory',
	jd_fk_jds.`disabled_flag` AS 'jd_fk_jds__disabled_flag',

	jd_fk_jb.`id` AS 'jd_fk_jb__jobsite_building_id',
	jd_fk_jb.`project_id` AS 'jd_fk_jb__project_id',
	jd_fk_jb.`jobsite_building` AS 'jd_fk_jb__jobsite_building',
	jd_fk_jb.`jobsite_building_description` AS 'jd_fk_jb__jobsite_building_description',
	jd_fk_jb.`sort_order` AS 'jd_fk_jb__sort_order',
	jd_fk_jb.`disabled_flag` AS 'jd_fk_jb__disabled_flag',

	jd_fk_jsr.`id` AS 'jd_fk_jsr__jobsite_sitework_region_id',
	jd_fk_jsr.`project_id` AS 'jd_fk_jsr__project_id',
	jd_fk_jsr.`jobsite_sitework_region` AS 'jd_fk_jsr__jobsite_sitework_region',
	jd_fk_jsr.`jobsite_sitework_region_description` AS 'jd_fk_jsr__jobsite_sitework_region_description',
	jd_fk_jsr.`sort_order` AS 'jd_fk_jsr__sort_order',
	jd_fk_jsr.`disabled_flag` AS 'jd_fk_jsr__disabled_flag',

	jds_fk_jdc.`id` AS 'jds_fk_jdc__jobsite_delay_category_id',
	jds_fk_jdc.`user_company_id` AS 'jds_fk_jdc__user_company_id',
	jds_fk_jdc.`jobsite_delay_category` AS 'jds_fk_jdc__jobsite_delay_category',
	jds_fk_jdc.`disabled_flag` AS 'jds_fk_jdc__disabled_flag',

	jdn.`jobsite_delay_id` as 'jobsite_delay_id',
	jdn.`jobsite_delay_note` as 'jobsite_delay_note',

	jd.*

FROM `jobsite_delays` jd
	INNER JOIN `jobsite_daily_logs` jd_fk_jdl ON jd.`jobsite_daily_log_id` = jd_fk_jdl.`id`
	INNER JOIN `jobsite_delay_subcategories` jd_fk_jds ON jd.`jobsite_delay_subcategory_id` = jd_fk_jds.`id`
	LEFT OUTER JOIN `jobsite_buildings` jd_fk_jb ON jd.`jobsite_building_id` = jd_fk_jb.`id`
	LEFT OUTER JOIN `jobsite_sitework_regions` jd_fk_jsr ON jd.`jobsite_sitework_region_id` = jd_fk_jsr.`id`

	INNER JOIN `jobsite_delay_categories` jds_fk_jdc ON jd_fk_jds.`jobsite_delay_category_id` = jds_fk_jdc.`id`
	LEFT OUTER JOIN `jobsite_delay_notes` jdn ON jd.`id` = jdn.`jobsite_delay_id`

WHERE jd.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelaysByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_id = $row['id'];
			$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id);
			/* @var $jobsiteDelay JobsiteDelay */
			$jobsiteDelay->jobsite_delay_note = (string) $row['jobsite_delay_note'];

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jd_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jd_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteDelay->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_delay_subcategory_id'])) {
				$jobsite_delay_subcategory_id = $row['jobsite_delay_subcategory_id'];
				$row['jd_fk_jds__id'] = $jobsite_delay_subcategory_id;
				$jobsiteDelaySubcategory = self::instantiateOrm($database, 'JobsiteDelaySubcategory', $row, null, $jobsite_delay_subcategory_id, 'jd_fk_jds__');
				/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */
				$jobsiteDelaySubcategory->convertPropertiesToData();
			} else {
				$jobsiteDelaySubcategory = false;
			}
			$jobsiteDelay->setJobsiteDelaySubcategory($jobsiteDelaySubcategory);

			if (isset($row['jobsite_building_id'])) {
				$jobsite_building_id = $row['jobsite_building_id'];
				$row['jd_fk_jb__id'] = $jobsite_building_id;
				$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id, 'jd_fk_jb__');
				/* @var $jobsiteBuilding JobsiteBuilding */
				$jobsiteBuilding->convertPropertiesToData();
			} else {
				$jobsiteBuilding = false;
			}
			$jobsiteDelay->setJobsiteBuilding($jobsiteBuilding);

			if (isset($row['jobsite_sitework_region_id'])) {
				$jobsite_sitework_region_id = $row['jobsite_sitework_region_id'];
				$row['jd_fk_jsr__id'] = $jobsite_sitework_region_id;
				$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id, 'jd_fk_jsr__');
				/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
				$jobsiteSiteworkRegion->convertPropertiesToData();
			} else {
				$jobsiteSiteworkRegion = false;
			}
			$jobsiteDelay->setJobsiteSiteworkRegion($jobsiteSiteworkRegion);

			if (isset($row['jds_fk_jdc__jobsite_delay_category_id'])) {
				$jobsite_delay_category_id = $row['jds_fk_jdc__jobsite_delay_category_id'];
				$row['jds_fk_jdc__id'] = $jobsite_delay_category_id;
				$jobsiteDelayCategory = self::instantiateOrm($database, 'JobsiteDelayCategory', $row, null, $jobsite_delay_category_id, 'jds_fk_jdc__');
				/* @var $jobsiteDelayCategory JobsiteDelayCategory */
				$jobsiteDelayCategory->convertPropertiesToData();
			} else {
				$jobsiteDelayCategory = false;
			}
			$jobsiteDelay->setJobsiteDelayCategory($jobsiteDelayCategory);

			if (isset($row['jobsite_delay_id'])) {
				$jobsite_delay_id = $row['jobsite_delay_id'];
				$jobsiteDelayNote = self::instantiateOrm($database, 'JobsiteDelayNote', $row, null, $jobsite_delay_id, '');
				/* @var $jobsiteDelayNote JobsiteDelayNote */
				$jobsiteDelayNote->convertPropertiesToData();
			} else {
				$jobsiteDelayNote = false;
			}
			$jobsiteDelay->setJobsiteDelayNote($jobsiteDelayNote);

			$arrJobsiteDelaysByJobsiteDailyLogId[$jobsite_delay_id] = $jobsiteDelay;
		}

		$db->free_result();

		self::$_arrJobsiteDelaysByJobsiteDailyLogId = $arrJobsiteDelaysByJobsiteDailyLogId;

		return $arrJobsiteDelaysByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `jobsite_delays_fk_jds` foreign key (`jobsite_delay_subcategory_id`) references `jobsite_delay_subcategories` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_delay_subcategory_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelaysByJobsiteDelaySubcategoryId($database, $jobsite_delay_subcategory_id, Input $options=null)
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
			self::$_arrJobsiteDelaysByJobsiteDelaySubcategoryId = null;
		}

		$arrJobsiteDelaysByJobsiteDelaySubcategoryId = self::$_arrJobsiteDelaysByJobsiteDelaySubcategoryId;
		if (isset($arrJobsiteDelaysByJobsiteDelaySubcategoryId) && !empty($arrJobsiteDelaysByJobsiteDelaySubcategoryId)) {
			return $arrJobsiteDelaysByJobsiteDelaySubcategoryId;
		}

		$jobsite_delay_subcategory_id = (int) $jobsite_delay_subcategory_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelay = new JobsiteDelay($database);
			$sqlOrderByColumns = $tmpJobsiteDelay->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jd.*

FROM `jobsite_delays` jd
WHERE jd.`jobsite_delay_subcategory_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$arrValues = array($jobsite_delay_subcategory_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelaysByJobsiteDelaySubcategoryId = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_id = $row['id'];
			$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id);
			/* @var $jobsiteDelay JobsiteDelay */
			$arrJobsiteDelaysByJobsiteDelaySubcategoryId[$jobsite_delay_id] = $jobsiteDelay;
		}

		$db->free_result();

		self::$_arrJobsiteDelaysByJobsiteDelaySubcategoryId = $arrJobsiteDelaysByJobsiteDelaySubcategoryId;

		return $arrJobsiteDelaysByJobsiteDelaySubcategoryId;
	}

	/**
	 * Load by constraint `jobsite_delays_fk_jb` foreign key (`jobsite_building_id`) references `jobsite_buildings` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_building_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelaysByJobsiteBuildingId($database, $jobsite_building_id, Input $options=null)
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
			self::$_arrJobsiteDelaysByJobsiteBuildingId = null;
		}

		$arrJobsiteDelaysByJobsiteBuildingId = self::$_arrJobsiteDelaysByJobsiteBuildingId;
		if (isset($arrJobsiteDelaysByJobsiteBuildingId) && !empty($arrJobsiteDelaysByJobsiteBuildingId)) {
			return $arrJobsiteDelaysByJobsiteBuildingId;
		}

		$jobsite_building_id = (int) $jobsite_building_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelay = new JobsiteDelay($database);
			$sqlOrderByColumns = $tmpJobsiteDelay->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jd.*

FROM `jobsite_delays` jd
WHERE jd.`jobsite_building_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$arrValues = array($jobsite_building_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelaysByJobsiteBuildingId = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_id = $row['id'];
			$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id);
			/* @var $jobsiteDelay JobsiteDelay */
			$arrJobsiteDelaysByJobsiteBuildingId[$jobsite_delay_id] = $jobsiteDelay;
		}

		$db->free_result();

		self::$_arrJobsiteDelaysByJobsiteBuildingId = $arrJobsiteDelaysByJobsiteBuildingId;

		return $arrJobsiteDelaysByJobsiteBuildingId;
	}

	/**
	 * Load by constraint `jobsite_delays_fk_jsr` foreign key (`jobsite_sitework_region_id`) references `jobsite_sitework_regions` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_region_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelaysByJobsiteSiteworkRegionId($database, $jobsite_sitework_region_id, Input $options=null)
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
			self::$_arrJobsiteDelaysByJobsiteSiteworkRegionId = null;
		}

		$arrJobsiteDelaysByJobsiteSiteworkRegionId = self::$_arrJobsiteDelaysByJobsiteSiteworkRegionId;
		if (isset($arrJobsiteDelaysByJobsiteSiteworkRegionId) && !empty($arrJobsiteDelaysByJobsiteSiteworkRegionId)) {
			return $arrJobsiteDelaysByJobsiteSiteworkRegionId;
		}

		$jobsite_sitework_region_id = (int) $jobsite_sitework_region_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelay = new JobsiteDelay($database);
			$sqlOrderByColumns = $tmpJobsiteDelay->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jd.*

FROM `jobsite_delays` jd
WHERE jd.`jobsite_sitework_region_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$arrValues = array($jobsite_sitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelaysByJobsiteSiteworkRegionId = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_id = $row['id'];
			$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id);
			/* @var $jobsiteDelay JobsiteDelay */
			$arrJobsiteDelaysByJobsiteSiteworkRegionId[$jobsite_delay_id] = $jobsiteDelay;
		}

		$db->free_result();

		self::$_arrJobsiteDelaysByJobsiteSiteworkRegionId = $arrJobsiteDelaysByJobsiteSiteworkRegionId;

		return $arrJobsiteDelaysByJobsiteSiteworkRegionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_delays records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteDelays($database, Input $options=null)
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
			self::$_arrAllJobsiteDelays = null;
		}

		$arrAllJobsiteDelays = self::$_arrAllJobsiteDelays;
		if (isset($arrAllJobsiteDelays) && !empty($arrAllJobsiteDelays)) {
			return $arrAllJobsiteDelays;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelay = new JobsiteDelay($database);
			$sqlOrderByColumns = $tmpJobsiteDelay->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jd.*

FROM `jobsite_delays` jd{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_delay_subcategory_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteDelays = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_id = $row['id'];
			$jobsiteDelay = self::instantiateOrm($database, 'JobsiteDelay', $row, null, $jobsite_delay_id);
			/* @var $jobsiteDelay JobsiteDelay */
			$arrAllJobsiteDelays[$jobsite_delay_id] = $jobsiteDelay;
		}

		$db->free_result();

		self::$_arrAllJobsiteDelays = $arrAllJobsiteDelays;

		return $arrAllJobsiteDelays;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

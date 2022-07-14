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
 * JobsiteInspection.
 *
 * @category   Framework
 * @package    JobsiteInspection
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteInspection extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteInspection';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_inspections';

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
	 * unique index `unique_jobsite_inspections` (`jobsite_daily_log_id`,`jobsite_inspection_type_id`,`jobsite_building_id`,`jobsite_sitework_region_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_inspections' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_inspection_type_id' => 'int',
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
		'id' => 'jobsite_inspection_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_inspection_type_id' => 'jobsite_inspection_type_id',
		'inspector_contact_id' => 'inspector_contact_id',
		'jobsite_building_id' => 'jobsite_building_id',
		'jobsite_sitework_region_id' => 'jobsite_sitework_region_id',

		'jobsite_inspection_passed_flag' => 'jobsite_inspection_passed_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_inspection_id;

	public $jobsite_daily_log_id;
	public $jobsite_inspection_type_id;
	public $inspector_contact_id;
	public $jobsite_building_id;
	public $jobsite_sitework_region_id;

	public $jobsite_inspection_passed_flag;

	// Other Properties
	//protected $_otherPropertyHere;
	public $jobsite_inspection_note;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteInspectionsByJobsiteDailyLogId;
	protected static $_arrJobsiteInspectionsByJobsiteInspectionTypeId;
	protected static $_arrJobsiteInspectionsByInspectorContactId;
	protected static $_arrJobsiteInspectionsByJobsiteBuildingId;
	protected static $_arrJobsiteInspectionsByJobsiteSiteworkRegionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteInspections;
	protected static $_arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteInspectionType;
	private $_inspectorContact;
	private $_jobsiteBuilding;
	private $_jobsiteSiteworkRegion;
	private $_jobsiteInspectionNote;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_inspections')
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

	public function getJobsiteInspectionType()
	{
		if (isset($this->_jobsiteInspectionType)) {
			return $this->_jobsiteInspectionType;
		} else {
			return null;
		}
	}

	public function setJobsiteInspectionType($jobsiteInspectionType)
	{
		$this->_jobsiteInspectionType = $jobsiteInspectionType;
	}

	public function getInspectorContact()
	{
		if (isset($this->_inspectorContact)) {
			return $this->_inspectorContact;
		} else {
			return null;
		}
	}

	public function setInspectorContact($inspectorContact)
	{
		$this->_inspectorContact = $inspectorContact;
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

	public function getJobsiteInspectionNote()
	{
		if (isset($this->_jobsiteInspectionNote)) {
			return $this->_jobsiteInspectionNote;
		} else {
			return null;
		}
	}

	public function setJobsiteInspectionNote($jobsiteInspectionNote)
	{
		$this->_jobsiteInspectionNote = $jobsiteInspectionNote;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteInspectionsByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteInspectionsByJobsiteDailyLogId)) {
			return self::$_arrJobsiteInspectionsByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteInspectionsByJobsiteDailyLogId($arrJobsiteInspectionsByJobsiteDailyLogId)
	{
		self::$_arrJobsiteInspectionsByJobsiteDailyLogId = $arrJobsiteInspectionsByJobsiteDailyLogId;
	}

	public static function getArrJobsiteInspectionsByJobsiteInspectionTypeId()
	{
		if (isset(self::$_arrJobsiteInspectionsByJobsiteInspectionTypeId)) {
			return self::$_arrJobsiteInspectionsByJobsiteInspectionTypeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteInspectionsByJobsiteInspectionTypeId($arrJobsiteInspectionsByJobsiteInspectionTypeId)
	{
		self::$_arrJobsiteInspectionsByJobsiteInspectionTypeId = $arrJobsiteInspectionsByJobsiteInspectionTypeId;
	}

	public static function getArrJobsiteInspectionsByInspectorContactId()
	{
		if (isset(self::$_arrJobsiteInspectionsByInspectorContactId)) {
			return self::$_arrJobsiteInspectionsByInspectorContactId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteInspectionsByInspectorContactId($arrJobsiteInspectionsByInspectorContactId)
	{
		self::$_arrJobsiteInspectionsByInspectorContactId = $arrJobsiteInspectionsByInspectorContactId;
	}

	public static function getArrJobsiteInspectionsByJobsiteBuildingId()
	{
		if (isset(self::$_arrJobsiteInspectionsByJobsiteBuildingId)) {
			return self::$_arrJobsiteInspectionsByJobsiteBuildingId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteInspectionsByJobsiteBuildingId($arrJobsiteInspectionsByJobsiteBuildingId)
	{
		self::$_arrJobsiteInspectionsByJobsiteBuildingId = $arrJobsiteInspectionsByJobsiteBuildingId;
	}

	public static function getArrJobsiteInspectionsByJobsiteSiteworkRegionId()
	{
		if (isset(self::$_arrJobsiteInspectionsByJobsiteSiteworkRegionId)) {
			return self::$_arrJobsiteInspectionsByJobsiteSiteworkRegionId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteInspectionsByJobsiteSiteworkRegionId($arrJobsiteInspectionsByJobsiteSiteworkRegionId)
	{
		self::$_arrJobsiteInspectionsByJobsiteSiteworkRegionId = $arrJobsiteInspectionsByJobsiteSiteworkRegionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteInspections()
	{
		if (isset(self::$_arrAllJobsiteInspections)) {
			return self::$_arrAllJobsiteInspections;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteInspections($arrAllJobsiteInspections)
	{
		self::$_arrAllJobsiteInspections = $arrAllJobsiteInspections;
	}

	public static function getArrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId()
	{
		if (isset(self::$_arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId)) {
			return self::$_arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId($arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId)
	{
		self::$_arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId = $arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId;
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
	 * @param int $jobsite_inspection_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_inspection_id, $table='jobsite_inspections', $module='JobsiteInspection')
	{
		$jobsiteInspection = parent::findById($database, $jobsite_inspection_id, $table, $module);

		return $jobsiteInspection;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_inspection_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteInspectionByIdExtended($database, $jobsite_inspection_id)
	{
		$jobsite_inspection_id = (int) $jobsite_inspection_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ji_fk_jdl.`id` AS 'ji_fk_jdl__jobsite_daily_log_id',
	ji_fk_jdl.`project_id` AS 'ji_fk_jdl__project_id',
	ji_fk_jdl.`modified_by_contact_id` AS 'ji_fk_jdl__modified_by_contact_id',
	ji_fk_jdl.`created_by_contact_id` AS 'ji_fk_jdl__created_by_contact_id',
	ji_fk_jdl.`modified` AS 'ji_fk_jdl__modified',
	ji_fk_jdl.`jobsite_daily_log_created_date` AS 'ji_fk_jdl__jobsite_daily_log_created_date',

	ji_fk_jit.`id` AS 'ji_fk_jit__jobsite_inspection_type_id',
	ji_fk_jit.`jobsite_inspection_type` AS 'ji_fk_jit__jobsite_inspection_type',
	ji_fk_jit.`sort_order` AS 'ji_fk_jit__sort_order',
	ji_fk_jit.`disabled_flag` AS 'ji_fk_jit__disabled_flag',

	ji_fk_inspector_c.`id` AS 'ji_fk_inspector_c__contact_id',
	ji_fk_inspector_c.`user_company_id` AS 'ji_fk_inspector_c__user_company_id',
	ji_fk_inspector_c.`user_id` AS 'ji_fk_inspector_c__user_id',
	ji_fk_inspector_c.`contact_company_id` AS 'ji_fk_inspector_c__contact_company_id',
	ji_fk_inspector_c.`email` AS 'ji_fk_inspector_c__email',
	ji_fk_inspector_c.`name_prefix` AS 'ji_fk_inspector_c__name_prefix',
	ji_fk_inspector_c.`first_name` AS 'ji_fk_inspector_c__first_name',
	ji_fk_inspector_c.`additional_name` AS 'ji_fk_inspector_c__additional_name',
	ji_fk_inspector_c.`middle_name` AS 'ji_fk_inspector_c__middle_name',
	ji_fk_inspector_c.`last_name` AS 'ji_fk_inspector_c__last_name',
	ji_fk_inspector_c.`name_suffix` AS 'ji_fk_inspector_c__name_suffix',
	ji_fk_inspector_c.`title` AS 'ji_fk_inspector_c__title',
	ji_fk_inspector_c.`vendor_flag` AS 'ji_fk_inspector_c__vendor_flag',

	ji_fk_jb.`id` AS 'ji_fk_jb__jobsite_building_id',
	ji_fk_jb.`project_id` AS 'ji_fk_jb__project_id',
	ji_fk_jb.`jobsite_building` AS 'ji_fk_jb__jobsite_building',
	ji_fk_jb.`jobsite_building_description` AS 'ji_fk_jb__jobsite_building_description',
	ji_fk_jb.`sort_order` AS 'ji_fk_jb__sort_order',
	ji_fk_jb.`disabled_flag` AS 'ji_fk_jb__disabled_flag',

	ji_fk_jsr.`id` AS 'ji_fk_jsr__jobsite_sitework_region_id',
	ji_fk_jsr.`project_id` AS 'ji_fk_jsr__project_id',
	ji_fk_jsr.`jobsite_sitework_region` AS 'ji_fk_jsr__jobsite_sitework_region',
	ji_fk_jsr.`jobsite_sitework_region_description` AS 'ji_fk_jsr__jobsite_sitework_region_description',
	ji_fk_jsr.`sort_order` AS 'ji_fk_jsr__sort_order',
	ji_fk_jsr.`disabled_flag` AS 'ji_fk_jsr__disabled_flag',

	ji.*

FROM `jobsite_inspections` ji
	INNER JOIN `jobsite_daily_logs` ji_fk_jdl ON ji.`jobsite_daily_log_id` = ji_fk_jdl.`id`
	INNER JOIN `jobsite_inspection_types` ji_fk_jit ON ji.`jobsite_inspection_type_id` = ji_fk_jit.`id`
	LEFT OUTER JOIN `contacts` ji_fk_inspector_c ON ji.`inspector_contact_id` = ji_fk_inspector_c.`id`
	LEFT OUTER JOIN `jobsite_buildings` ji_fk_jb ON ji.`jobsite_building_id` = ji_fk_jb.`id`
	LEFT OUTER JOIN `jobsite_sitework_regions` ji_fk_jsr ON ji.`jobsite_sitework_region_id` = ji_fk_jsr.`id`
WHERE ji.`id` = ?
";
		$arrValues = array($jobsite_inspection_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			$jobsiteInspection->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['ji_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'ji_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteInspection->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_inspection_type_id'])) {
				$jobsite_inspection_type_id = $row['jobsite_inspection_type_id'];
				$row['ji_fk_jit__id'] = $jobsite_inspection_type_id;
				$jobsiteInspectionType = self::instantiateOrm($database, 'JobsiteInspectionType', $row, null, $jobsite_inspection_type_id, 'ji_fk_jit__');
				/* @var $jobsiteInspectionType JobsiteInspectionType */
				$jobsiteInspectionType->convertPropertiesToData();
			} else {
				$jobsiteInspectionType = false;
			}
			$jobsiteInspection->setJobsiteInspectionType($jobsiteInspectionType);

			if (isset($row['inspector_contact_id'])) {
				$inspector_contact_id = $row['inspector_contact_id'];
				$row['ji_fk_inspector_c__id'] = $inspector_contact_id;
				$inspectorContact = self::instantiateOrm($database, 'Contact', $row, null, $inspector_contact_id, 'ji_fk_inspector_c__');
				/* @var $inspectorContact Contact */
				$inspectorContact->convertPropertiesToData();
			} else {
				$inspectorContact = false;
			}
			$jobsiteInspection->setInspectorContact($inspectorContact);

			if (isset($row['jobsite_building_id'])) {
				$jobsite_building_id = $row['jobsite_building_id'];
				$row['ji_fk_jb__id'] = $jobsite_building_id;
				$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id, 'ji_fk_jb__');
				/* @var $jobsiteBuilding JobsiteBuilding */
				$jobsiteBuilding->convertPropertiesToData();
			} else {
				$jobsiteBuilding = false;
			}
			$jobsiteInspection->setJobsiteBuilding($jobsiteBuilding);

			if (isset($row['jobsite_sitework_region_id'])) {
				$jobsite_sitework_region_id = $row['jobsite_sitework_region_id'];
				$row['ji_fk_jsr__id'] = $jobsite_sitework_region_id;
				$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id, 'ji_fk_jsr__');
				/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
				$jobsiteSiteworkRegion->convertPropertiesToData();
			} else {
				$jobsiteSiteworkRegion = false;
			}
			$jobsiteInspection->setJobsiteSiteworkRegion($jobsiteSiteworkRegion);

			return $jobsiteInspection;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_inspections` (`jobsite_daily_log_id`,`jobsite_inspection_type_id`,`jobsite_building_id`,`jobsite_sitework_region_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_inspection_type_id
	 * @param int $jobsite_building_id
	 * @param int $jobsite_sitework_region_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteInspectionTypeIdAndJobsiteBuildingIdAndJobsiteSiteworkRegionId($database, $jobsite_daily_log_id, $jobsite_inspection_type_id, $jobsite_building_id, $jobsite_sitework_region_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ji.*

FROM `jobsite_inspections` ji
WHERE ji.`jobsite_daily_log_id` = ?
AND ji.`jobsite_inspection_type_id` = ?
AND ji.`jobsite_building_id` = ?
AND ji.`jobsite_sitework_region_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_inspection_type_id, $jobsite_building_id, $jobsite_sitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			return $jobsiteInspection;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteInspectionIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionsByArrJobsiteInspectionIds($database, $arrJobsiteInspectionIds, Input $options=null)
	{
		if (empty($arrJobsiteInspectionIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspection = new JobsiteInspection($database);
			$sqlOrderByColumns = $tmpJobsiteInspection->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteInspectionIds as $k => $jobsite_inspection_id) {
			$jobsite_inspection_id = (int) $jobsite_inspection_id;
			$arrJobsiteInspectionIds[$k] = $db->escape($jobsite_inspection_id);
		}
		$csvJobsiteInspectionIds = join(',', $arrJobsiteInspectionIds);

		$query =
"
SELECT

	ji.*

FROM `jobsite_inspections` ji
WHERE ji.`id` IN ($csvJobsiteInspectionIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteInspectionsByCsvJobsiteInspectionIds = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			$jobsiteInspection->convertPropertiesToData();

			$arrJobsiteInspectionsByCsvJobsiteInspectionIds[$jobsite_inspection_id] = $jobsiteInspection;
		}

		$db->free_result();

		return $arrJobsiteInspectionsByCsvJobsiteInspectionIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_inspections_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionsByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteInspectionsByJobsiteDailyLogId = null;
		}

		$arrJobsiteInspectionsByJobsiteDailyLogId = self::$_arrJobsiteInspectionsByJobsiteDailyLogId;
		if (isset($arrJobsiteInspectionsByJobsiteDailyLogId) && !empty($arrJobsiteInspectionsByJobsiteDailyLogId)) {
			return $arrJobsiteInspectionsByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspection = new JobsiteInspection($database);
			$sqlOrderByColumns = $tmpJobsiteInspection->constructSqlOrderByColumns($arrOrderByAttributes);

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
SELECT jn.jobsite_inspection_note,jt.jobsite_inspection_type,ji.*

FROM `jobsite_inspections` ji
LEFT Join `jobsite_inspection_notes` jn on ji.id=jn.jobsite_inspection_id
LEFT join `jobsite_inspection_types` jt on jt.id =ji.jobsite_inspection_type_id
WHERE ji.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteInspectionsByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			$arrJobsiteInspectionsByJobsiteDailyLogId[$jobsite_inspection_id] = $jobsiteInspection;
		}

		$db->free_result();

		self::$_arrJobsiteInspectionsByJobsiteDailyLogId = $arrJobsiteInspectionsByJobsiteDailyLogId;

		return $arrJobsiteInspectionsByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `jobsite_inspections_fk_jit` foreign key (`jobsite_inspection_type_id`) references `jobsite_inspection_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_inspection_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionsByJobsiteInspectionTypeId($database, $jobsite_inspection_type_id, Input $options=null)
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
			self::$_arrJobsiteInspectionsByJobsiteInspectionTypeId = null;
		}

		$arrJobsiteInspectionsByJobsiteInspectionTypeId = self::$_arrJobsiteInspectionsByJobsiteInspectionTypeId;
		if (isset($arrJobsiteInspectionsByJobsiteInspectionTypeId) && !empty($arrJobsiteInspectionsByJobsiteInspectionTypeId)) {
			return $arrJobsiteInspectionsByJobsiteInspectionTypeId;
		}

		$jobsite_inspection_type_id = (int) $jobsite_inspection_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspection = new JobsiteInspection($database);
			$sqlOrderByColumns = $tmpJobsiteInspection->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ji.*

FROM `jobsite_inspections` ji
WHERE ji.`jobsite_inspection_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$arrValues = array($jobsite_inspection_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteInspectionsByJobsiteInspectionTypeId = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			$arrJobsiteInspectionsByJobsiteInspectionTypeId[$jobsite_inspection_id] = $jobsiteInspection;
		}

		$db->free_result();

		self::$_arrJobsiteInspectionsByJobsiteInspectionTypeId = $arrJobsiteInspectionsByJobsiteInspectionTypeId;

		return $arrJobsiteInspectionsByJobsiteInspectionTypeId;
	}

	/**
	 * Load by constraint `jobsite_inspections_fk_inspector_c` foreign key (`inspector_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $inspector_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionsByInspectorContactId($database, $inspector_contact_id, Input $options=null)
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
			self::$_arrJobsiteInspectionsByInspectorContactId = null;
		}

		$arrJobsiteInspectionsByInspectorContactId = self::$_arrJobsiteInspectionsByInspectorContactId;
		if (isset($arrJobsiteInspectionsByInspectorContactId) && !empty($arrJobsiteInspectionsByInspectorContactId)) {
			return $arrJobsiteInspectionsByInspectorContactId;
		}

		$inspector_contact_id = (int) $inspector_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspection = new JobsiteInspection($database);
			$sqlOrderByColumns = $tmpJobsiteInspection->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ji.*

FROM `jobsite_inspections` ji
WHERE ji.`inspector_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$arrValues = array($inspector_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteInspectionsByInspectorContactId = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			$arrJobsiteInspectionsByInspectorContactId[$jobsite_inspection_id] = $jobsiteInspection;
		}

		$db->free_result();

		self::$_arrJobsiteInspectionsByInspectorContactId = $arrJobsiteInspectionsByInspectorContactId;

		return $arrJobsiteInspectionsByInspectorContactId;
	}

	/**
	 * Load by constraint `jobsite_inspections_fk_jb` foreign key (`jobsite_building_id`) references `jobsite_buildings` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_building_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionsByJobsiteBuildingId($database, $jobsite_building_id, Input $options=null)
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
			self::$_arrJobsiteInspectionsByJobsiteBuildingId = null;
		}

		$arrJobsiteInspectionsByJobsiteBuildingId = self::$_arrJobsiteInspectionsByJobsiteBuildingId;
		if (isset($arrJobsiteInspectionsByJobsiteBuildingId) && !empty($arrJobsiteInspectionsByJobsiteBuildingId)) {
			return $arrJobsiteInspectionsByJobsiteBuildingId;
		}

		$jobsite_building_id = (int) $jobsite_building_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspection = new JobsiteInspection($database);
			$sqlOrderByColumns = $tmpJobsiteInspection->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ji.*

FROM `jobsite_inspections` ji
WHERE ji.`jobsite_building_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$arrValues = array($jobsite_building_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteInspectionsByJobsiteBuildingId = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			$arrJobsiteInspectionsByJobsiteBuildingId[$jobsite_inspection_id] = $jobsiteInspection;
		}

		$db->free_result();

		self::$_arrJobsiteInspectionsByJobsiteBuildingId = $arrJobsiteInspectionsByJobsiteBuildingId;

		return $arrJobsiteInspectionsByJobsiteBuildingId;
	}

	/**
	 * Load by constraint `jobsite_inspections_fk_jsr` foreign key (`jobsite_sitework_region_id`) references `jobsite_sitework_regions` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_region_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionsByJobsiteSiteworkRegionId($database, $jobsite_sitework_region_id, Input $options=null)
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
			self::$_arrJobsiteInspectionsByJobsiteSiteworkRegionId = null;
		}

		$arrJobsiteInspectionsByJobsiteSiteworkRegionId = self::$_arrJobsiteInspectionsByJobsiteSiteworkRegionId;
		if (isset($arrJobsiteInspectionsByJobsiteSiteworkRegionId) && !empty($arrJobsiteInspectionsByJobsiteSiteworkRegionId)) {
			return $arrJobsiteInspectionsByJobsiteSiteworkRegionId;
		}

		$jobsite_sitework_region_id = (int) $jobsite_sitework_region_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspection = new JobsiteInspection($database);
			$sqlOrderByColumns = $tmpJobsiteInspection->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ji.*

FROM `jobsite_inspections` ji
WHERE ji.`jobsite_sitework_region_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$arrValues = array($jobsite_sitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteInspectionsByJobsiteSiteworkRegionId = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			$arrJobsiteInspectionsByJobsiteSiteworkRegionId[$jobsite_inspection_id] = $jobsiteInspection;
		}

		$db->free_result();

		self::$_arrJobsiteInspectionsByJobsiteSiteworkRegionId = $arrJobsiteInspectionsByJobsiteSiteworkRegionId;

		return $arrJobsiteInspectionsByJobsiteSiteworkRegionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_inspections records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteInspections($database, Input $options=null)
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
			self::$_arrAllJobsiteInspections = null;
		}

		$arrAllJobsiteInspections = self::$_arrAllJobsiteInspections;
		if (isset($arrAllJobsiteInspections) && !empty($arrAllJobsiteInspections)) {
			return $arrAllJobsiteInspections;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspection = new JobsiteInspection($database);
			$sqlOrderByColumns = $tmpJobsiteInspection->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ji.*

FROM `jobsite_inspections` ji{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteInspections = array();
		while ($row = $db->fetch()) {
			$jobsite_inspection_id = $row['id'];
			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row, null, $jobsite_inspection_id);
			/* @var $jobsiteInspection JobsiteInspection */
			$arrAllJobsiteInspections[$jobsite_inspection_id] = $jobsiteInspection;
		}

		$db->free_result();

		self::$_arrAllJobsiteInspections = $arrAllJobsiteInspections;

		return $arrAllJobsiteInspections;
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
INTO `jobsite_inspections`
(`jobsite_daily_log_id`, `jobsite_inspection_type_id`, `inspector_contact_id`, `jobsite_building_id`, `jobsite_sitework_region_id`, `jobsite_inspection_passed_flag`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `inspector_contact_id` = ?, `jobsite_inspection_passed_flag` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->jobsite_inspection_type_id, $this->inspector_contact_id, $this->jobsite_building_id, $this->jobsite_sitework_region_id, $this->jobsite_inspection_passed_flag, $this->inspector_contact_id, $this->jobsite_inspection_passed_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_inspection_id = $db->insertId;
		$db->free_result();

		return $jobsite_inspection_id;
	}

	// Save: insert ignore

	/**
	 * Load by constraint `jobsite_inspections_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId = null;
		}

		$arrJobsiteInspectionsByJobsiteDailyLogId = self::$_arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId;
		if (isset($arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId) && !empty($arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId)) {
			return $arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_inspection_type_id` ASC, `inspector_contact_id` ASC, `jobsite_building_id` ASC, `jobsite_sitework_region_id` ASC, `jobsite_inspection_passed_flag` ASC
		$sqlOrderBy = ' ORDER BY `id` ASC';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteInspection = new JobsiteInspection($database);
			$sqlOrderByColumns = $tmpJobsiteInspection->constructSqlOrderByColumns($arrOrderByAttributes);

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

	ji_fk_jdl.`id` AS 'ji_fk_jdl__jobsite_daily_log_id',
	ji_fk_jdl.`project_id` AS 'ji_fk_jdl__project_id',
	ji_fk_jdl.`modified_by_contact_id` AS 'ji_fk_jdl__modified_by_contact_id',
	ji_fk_jdl.`created_by_contact_id` AS 'ji_fk_jdl__created_by_contact_id',
	ji_fk_jdl.`modified` AS 'ji_fk_jdl__modified',
	ji_fk_jdl.`jobsite_daily_log_created_date` AS 'ji_fk_jdl__jobsite_daily_log_created_date',

	ji_fk_jit.`id` AS 'ji_fk_jit__jobsite_inspection_type_id',
	ji_fk_jit.`jobsite_inspection_type` AS 'ji_fk_jit__jobsite_inspection_type',
	ji_fk_jit.`sort_order` AS 'ji_fk_jit__sort_order',
	ji_fk_jit.`disabled_flag` AS 'ji_fk_jit__disabled_flag',

	ji_fk_inspector_c.`id` AS 'ji_fk_inspector_c__contact_id',
	ji_fk_inspector_c.`user_company_id` AS 'ji_fk_inspector_c__user_company_id',
	ji_fk_inspector_c.`user_id` AS 'ji_fk_inspector_c__user_id',
	ji_fk_inspector_c.`contact_company_id` AS 'ji_fk_inspector_c__contact_company_id',
	ji_fk_inspector_c.`email` AS 'ji_fk_inspector_c__email',
	ji_fk_inspector_c.`name_prefix` AS 'ji_fk_inspector_c__name_prefix',
	ji_fk_inspector_c.`first_name` AS 'ji_fk_inspector_c__first_name',
	ji_fk_inspector_c.`additional_name` AS 'ji_fk_inspector_c__additional_name',
	ji_fk_inspector_c.`middle_name` AS 'ji_fk_inspector_c__middle_name',
	ji_fk_inspector_c.`last_name` AS 'ji_fk_inspector_c__last_name',
	ji_fk_inspector_c.`name_suffix` AS 'ji_fk_inspector_c__name_suffix',
	ji_fk_inspector_c.`title` AS 'ji_fk_inspector_c__title',
	ji_fk_inspector_c.`vendor_flag` AS 'ji_fk_inspector_c__vendor_flag',

	ji_fk_jb.`id` AS 'ji_fk_jb__jobsite_building_id',
	ji_fk_jb.`project_id` AS 'ji_fk_jb__project_id',
	ji_fk_jb.`jobsite_building` AS 'ji_fk_jb__jobsite_building',
	ji_fk_jb.`jobsite_building_description` AS 'ji_fk_jb__jobsite_building_description',
	ji_fk_jb.`sort_order` AS 'ji_fk_jb__sort_order',
	ji_fk_jb.`disabled_flag` AS 'ji_fk_jb__disabled_flag',

	ji_fk_jsr.`id` AS 'ji_fk_jsr__jobsite_sitework_region_id',
	ji_fk_jsr.`project_id` AS 'ji_fk_jsr__project_id',
	ji_fk_jsr.`jobsite_sitework_region` AS 'ji_fk_jsr__jobsite_sitework_region',
	ji_fk_jsr.`jobsite_sitework_region_description` AS 'ji_fk_jsr__jobsite_sitework_region_description',
	ji_fk_jsr.`sort_order` AS 'ji_fk_jsr__sort_order',
	ji_fk_jsr.`disabled_flag` AS 'ji_fk_jsr__disabled_flag',

	jin.`jobsite_inspection_note` as 'jobsite_inspection_note',

	ji.*

FROM `jobsite_inspections` ji
	INNER JOIN `jobsite_daily_logs` ji_fk_jdl ON ji.`jobsite_daily_log_id` = ji_fk_jdl.`id`
	INNER JOIN `jobsite_inspection_types` ji_fk_jit ON ji.`jobsite_inspection_type_id` = ji_fk_jit.`id`
	LEFT OUTER JOIN `contacts` ji_fk_inspector_c ON ji.`inspector_contact_id` = ji_fk_inspector_c.`id`
	LEFT OUTER JOIN `jobsite_buildings` ji_fk_jb ON ji.`jobsite_building_id` = ji_fk_jb.`id`
	LEFT OUTER JOIN `jobsite_sitework_regions` ji_fk_jsr ON ji.`jobsite_sitework_region_id` = ji_fk_jsr.`id`

	LEFT OUTER JOIN `jobsite_inspection_notes` jin ON ji.`id` = jin.`jobsite_inspection_id`
WHERE ji_fk_jdl.`id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteInspections = array();
		$arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId = array();
		$arrInspectorContactIdsByInspectionType = array();
		$arrJobsiteInspectionsByInspectionTypeId = array();
		while ($row = $db->fetch()) {

			$jobsite_inspection_id = $row['id'];

			$jobsiteInspection = self::instantiateOrm($database, 'JobsiteInspection', $row);
			/* @var $jobsiteInspection JobsiteInspection */
			$jobsiteInspection->convertPropertiesToData();
			$jobsiteInspection->jobsite_inspection_note = (string) $row['jobsite_inspection_note'];

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['ji_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'ji_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteInspection->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_inspection_type_id'])) {
				$jobsite_inspection_type_id = $row['jobsite_inspection_type_id'];
				$row['ji_fk_jit__id'] = $jobsite_inspection_type_id;
				$jobsiteInspectionType = self::instantiateOrm($database, 'JobsiteInspectionType', $row, null, $jobsite_inspection_type_id, 'ji_fk_jit__');
				/* @var $jobsiteInspectionType JobsiteInspectionType */
				$jobsiteInspectionType->convertPropertiesToData();
			} else {
				$jobsiteInspectionType = false;
			}
			$jobsiteInspection->setJobsiteInspectionType($jobsiteInspectionType);

			if (isset($row['inspector_contact_id'])) {
				$inspector_contact_id = $row['inspector_contact_id'];
				$row['ji_fk_inspector_c__id'] = $inspector_contact_id;
				$inspectorContact = self::instantiateOrm($database, 'Contact', $row, null, $inspector_contact_id, 'ji_fk_inspector_c__');
				/* @var $inspectorContact Contact */
				$inspectorContact->convertPropertiesToData();
				$arrInspectorContactIdsByInspectionType[$jobsite_inspection_type_id][$inspector_contact_id] = $inspectorContact;
			} else {
				$inspectorContact = false;
			}
			$jobsiteInspection->setInspectorContact($inspectorContact);

			if (isset($row['jobsite_building_id'])) {
				$jobsite_building_id = $row['jobsite_building_id'];
				$row['ji_fk_jb__id'] = $jobsite_building_id;
				$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id, 'ji_fk_jb__');
				/* @var $jobsiteBuilding JobsiteBuilding */
				$jobsiteBuilding->convertPropertiesToData();
			} else {
				$jobsiteBuilding = false;
			}
			$jobsiteInspection->setJobsiteBuilding($jobsiteBuilding);

			if (isset($row['jobsite_sitework_region_id'])) {
				$jobsite_sitework_region_id = $row['jobsite_sitework_region_id'];
				$row['ji_fk_jsr__id'] = $jobsite_sitework_region_id;
				$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id, 'ji_fk_jsr__');
				/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
				$jobsiteSiteworkRegion->convertPropertiesToData();
			} else {
				$jobsiteSiteworkRegion = false;
			}
			$jobsiteInspection->setJobsiteSiteworkRegion($jobsiteSiteworkRegion);

			// jobsite_inspection_note
			if (isset($row['jobsite_inspection_note'])) {
				$jobsiteInspectionNote = new JobsiteInspectionNote($database);
				$jobsiteInspectionNote->jobsite_inspection_id = $jobsite_inspection_id;
				$jobsiteInspectionNote->jobsite_inspection_note = (string) $row['jobsite_inspection_note'];
				$jobsiteInspectionNote->convertPropertiesToData();
				$key = array('jobsite_inspection_id' => $jobsite_inspection_id);
				$jobsiteInspectionNote->setKey($key);
			} else {
				$jobsiteInspectionNote = false;
			}
			$jobsiteInspection->setJobsiteInspectionNote($jobsiteInspectionNote);

			$arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId[$jobsite_inspection_type_id][$jobsite_inspection_id] = $jobsiteInspection;

			$arrJobsiteInspections[$jobsite_inspection_id] = $jobsiteInspection;

		}

		$db->free_result();

		self::$_arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId = $arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId;

		$arrReturn['objects'] = $arrJobsiteInspections;
		$arrReturn['jobsite_inspections_by_jobsite_inspection_types'] = $arrJobsiteInspectionsByJobsiteDailyLogIdGroupedByInspectionTypeId;

		return $arrReturn;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

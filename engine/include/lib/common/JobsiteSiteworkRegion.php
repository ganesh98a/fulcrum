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
 * JobsiteSiteworkRegion.
 *
 * @category   Framework
 * @package    JobsiteSiteworkRegion
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteSiteworkRegion extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteSiteworkRegion';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_sitework_regions';

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
	 * unique index `unique_jobsite_sitework_region` (`project_id`,`jobsite_sitework_region`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_sitework_region' => array(
			'project_id' => 'int',
			'jobsite_sitework_region' => 'string'
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
		'id' => 'jobsite_sitework_region_id',

		'project_id' => 'project_id',

		'jobsite_sitework_region' => 'jobsite_sitework_region',

		'jobsite_sitework_region_description' => 'jobsite_sitework_region_description',
		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_sitework_region_id;

	public $project_id;

	public $jobsite_sitework_region;

	public $jobsite_sitework_region_description;
	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_sitework_region;
	public $escaped_jobsite_sitework_region_description;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteSiteworkRegionsByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteSiteworkRegions;

	// Foreign Key Objects
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_sitework_regions')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getProject()
	{
		if (isset($this->_project)) {
			return $this->_project;
		} else {
			return null;
		}
	}

	public function setProject($project)
	{
		$this->_project = $project;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteSiteworkRegionsByProjectId()
	{
		if (isset(self::$_arrJobsiteSiteworkRegionsByProjectId)) {
			return self::$_arrJobsiteSiteworkRegionsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSiteworkRegionsByProjectId($arrJobsiteSiteworkRegionsByProjectId)
	{
		self::$_arrJobsiteSiteworkRegionsByProjectId = $arrJobsiteSiteworkRegionsByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteSiteworkRegions()
	{
		if (isset(self::$_arrAllJobsiteSiteworkRegions)) {
			return self::$_arrAllJobsiteSiteworkRegions;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteSiteworkRegions($arrAllJobsiteSiteworkRegions)
	{
		self::$_arrAllJobsiteSiteworkRegions = $arrAllJobsiteSiteworkRegions;
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
	 * @param int $jobsite_sitework_region_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_sitework_region_id,$table='jobsite_sitework_regions', $module='JobsiteSiteworkRegion')
	{
		$jobsiteSiteworkRegion = parent::findById($database, $jobsite_sitework_region_id, $table, $module);

		return $jobsiteSiteworkRegion;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_region_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteSiteworkRegionByIdExtended($database, $jobsite_sitework_region_id)
	{
		$jobsite_sitework_region_id = (int) $jobsite_sitework_region_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jsr_fk_p.`id` AS 'jsr_fk_p__project_id',
	jsr_fk_p.`project_type_id` AS 'jsr_fk_p__project_type_id',
	jsr_fk_p.`user_company_id` AS 'jsr_fk_p__user_company_id',
	jsr_fk_p.`user_custom_project_id` AS 'jsr_fk_p__user_custom_project_id',
	jsr_fk_p.`project_name` AS 'jsr_fk_p__project_name',
	jsr_fk_p.`project_owner_name` AS 'jsr_fk_p__project_owner_name',
	jsr_fk_p.`latitude` AS 'jsr_fk_p__latitude',
	jsr_fk_p.`longitude` AS 'jsr_fk_p__longitude',
	jsr_fk_p.`address_line_1` AS 'jsr_fk_p__address_line_1',
	jsr_fk_p.`address_line_2` AS 'jsr_fk_p__address_line_2',
	jsr_fk_p.`address_line_3` AS 'jsr_fk_p__address_line_3',
	jsr_fk_p.`address_line_4` AS 'jsr_fk_p__address_line_4',
	jsr_fk_p.`address_city` AS 'jsr_fk_p__address_city',
	jsr_fk_p.`address_county` AS 'jsr_fk_p__address_county',
	jsr_fk_p.`address_state_or_region` AS 'jsr_fk_p__address_state_or_region',
	jsr_fk_p.`address_postal_code` AS 'jsr_fk_p__address_postal_code',
	jsr_fk_p.`address_postal_code_extension` AS 'jsr_fk_p__address_postal_code_extension',
	jsr_fk_p.`address_country` AS 'jsr_fk_p__address_country',
	jsr_fk_p.`building_count` AS 'jsr_fk_p__building_count',
	jsr_fk_p.`unit_count` AS 'jsr_fk_p__unit_count',
	jsr_fk_p.`gross_square_footage` AS 'jsr_fk_p__gross_square_footage',
	jsr_fk_p.`net_rentable_square_footage` AS 'jsr_fk_p__net_rentable_square_footage',
	jsr_fk_p.`is_active_flag` AS 'jsr_fk_p__is_active_flag',
	jsr_fk_p.`public_plans_flag` AS 'jsr_fk_p__public_plans_flag',
	jsr_fk_p.`prevailing_wage_flag` AS 'jsr_fk_p__prevailing_wage_flag',
	jsr_fk_p.`city_business_license_required_flag` AS 'jsr_fk_p__city_business_license_required_flag',
	jsr_fk_p.`is_internal_flag` AS 'jsr_fk_p__is_internal_flag',
	jsr_fk_p.`project_contract_date` AS 'jsr_fk_p__project_contract_date',
	jsr_fk_p.`project_start_date` AS 'jsr_fk_p__project_start_date',
	jsr_fk_p.`project_completed_date` AS 'jsr_fk_p__project_completed_date',
	jsr_fk_p.`sort_order` AS 'jsr_fk_p__sort_order',

	jsr.*

FROM `jobsite_sitework_regions` jsr
	INNER JOIN `projects` jsr_fk_p ON jsr.`project_id` = jsr_fk_p.`id`
WHERE jsr.`id` = ?
";
		$arrValues = array($jobsite_sitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_sitework_region_id = $row['id'];
			$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id);
			/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
			$jobsiteSiteworkRegion->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['jsr_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'jsr_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$jobsiteSiteworkRegion->setProject($project);

			return $jobsiteSiteworkRegion;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_sitework_region` (`project_id`,`jobsite_sitework_region`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_sitework_region
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndJobsiteSiteworkRegion($database, $project_id, $jobsite_sitework_region)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jsr.*

FROM `jobsite_sitework_regions` jsr
WHERE jsr.`project_id` = ?
AND jsr.`jobsite_sitework_region` = ?
";
		$arrValues = array($project_id, $jobsite_sitework_region);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_sitework_region_id = $row['id'];
			$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id);
			/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
			return $jobsiteSiteworkRegion;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteSiteworkRegionIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkRegionsByArrJobsiteSiteworkRegionIds($database, $arrJobsiteSiteworkRegionIds, Input $options=null)
	{
		if (empty($arrJobsiteSiteworkRegionIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_region` ASC, `jobsite_sitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsr.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkRegion = new JobsiteSiteworkRegion($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkRegion->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteSiteworkRegionIds as $k => $jobsite_sitework_region_id) {
			$jobsite_sitework_region_id = (int) $jobsite_sitework_region_id;
			$arrJobsiteSiteworkRegionIds[$k] = $db->escape($jobsite_sitework_region_id);
		}
		$csvJobsiteSiteworkRegionIds = join(',', $arrJobsiteSiteworkRegionIds);

		$query =
"
SELECT

	jsr.*

FROM `jobsite_sitework_regions` jsr
WHERE jsr.`id` IN ($csvJobsiteSiteworkRegionIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteSiteworkRegionsByCsvJobsiteSiteworkRegionIds = array();
		while ($row = $db->fetch()) {
			$jobsite_sitework_region_id = $row['id'];
			$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id);
			/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
			$jobsiteSiteworkRegion->convertPropertiesToData();

			$arrJobsiteSiteworkRegionsByCsvJobsiteSiteworkRegionIds[$jobsite_sitework_region_id] = $jobsiteSiteworkRegion;
		}

		$db->free_result();

		return $arrJobsiteSiteworkRegionsByCsvJobsiteSiteworkRegionIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_sitework_regions_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkRegionsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrJobsiteSiteworkRegionsByProjectId = null;
		}

		$arrJobsiteSiteworkRegionsByProjectId = self::$_arrJobsiteSiteworkRegionsByProjectId;
		if (isset($arrJobsiteSiteworkRegionsByProjectId) && !empty($arrJobsiteSiteworkRegionsByProjectId)) {
			return $arrJobsiteSiteworkRegionsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_region` ASC, `jobsite_sitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsr.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkRegion = new JobsiteSiteworkRegion($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkRegion->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsr.*

FROM `jobsite_sitework_regions` jsr
WHERE jsr.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_region` ASC, `jobsite_sitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkRegionsByProjectId = array();
		while ($row = $db->fetch()) {
			$jobsite_sitework_region_id = $row['id'];
			$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id);
			/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
			$arrJobsiteSiteworkRegionsByProjectId[$jobsite_sitework_region_id] = $jobsiteSiteworkRegion;
		}

		$db->free_result();

		self::$_arrJobsiteSiteworkRegionsByProjectId = $arrJobsiteSiteworkRegionsByProjectId;

		return $arrJobsiteSiteworkRegionsByProjectId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_sitework_regions records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteSiteworkRegions($database, Input $options=null)
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
			self::$_arrAllJobsiteSiteworkRegions = null;
		}

		$arrAllJobsiteSiteworkRegions = self::$_arrAllJobsiteSiteworkRegions;
		if (isset($arrAllJobsiteSiteworkRegions) && !empty($arrAllJobsiteSiteworkRegions)) {
			return $arrAllJobsiteSiteworkRegions;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_region` ASC, `jobsite_sitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsr.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkRegion = new JobsiteSiteworkRegion($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkRegion->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsr.*

FROM `jobsite_sitework_regions` jsr{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_region` ASC, `jobsite_sitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteSiteworkRegions = array();
		while ($row = $db->fetch()) {
			$jobsite_sitework_region_id = $row['id'];
			$jobsiteSiteworkRegion = self::instantiateOrm($database, 'JobsiteSiteworkRegion', $row, null, $jobsite_sitework_region_id);
			/* @var $jobsiteSiteworkRegion JobsiteSiteworkRegion */
			$arrAllJobsiteSiteworkRegions[$jobsite_sitework_region_id] = $jobsiteSiteworkRegion;
		}

		$db->free_result();

		self::$_arrAllJobsiteSiteworkRegions = $arrAllJobsiteSiteworkRegions;

		return $arrAllJobsiteSiteworkRegions;
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
INTO `jobsite_sitework_regions`
(`project_id`, `jobsite_sitework_region`, `jobsite_sitework_region_description`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_sitework_region_description` = ?, `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->project_id, $this->jobsite_sitework_region, $this->jobsite_sitework_region_description, $this->sort_order, $this->disabled_flag, $this->jobsite_sitework_region_description, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_sitework_region_id = $db->insertId;
		$db->free_result();

		return $jobsite_sitework_region_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

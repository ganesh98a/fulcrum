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
 * JobsiteOffsiteworkRegion.
 *
 * @category   Framework
 * @package    JobsiteOffsiteworkRegion
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteOffsiteworkRegion extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteOffsiteworkRegion';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_offsitework_regions';

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
	 * unique index `unique_jobsite_offsitework_region` (`project_id`,`jobsite_offsitework_region`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_offsitework_region' => array(
			'project_id' => 'int',
			'jobsite_offsitework_region' => 'string'
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
		'id' => 'jobsite_offsitework_region_id',

		'project_id' => 'project_id',

		'jobsite_offsitework_region' => 'jobsite_offsitework_region',

		'jobsite_offsitework_region_description' => 'jobsite_offsitework_region_description',
		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_offsitework_region_id;

	public $project_id;

	public $jobsite_offsitework_region;

	public $jobsite_offsitework_region_description;
	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_offsitework_region;
	public $escaped_jobsite_offsitework_region_description;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteOffsiteworkRegionsByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteOffsiteworkRegions;

	// Foreign Key Objects
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_offsitework_regions')
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
	public static function getArrJobsiteOffsiteworkRegionsByProjectId()
	{
		if (isset(self::$_arrJobsiteOffsiteworkRegionsByProjectId)) {
			return self::$_arrJobsiteOffsiteworkRegionsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteOffsiteworkRegionsByProjectId($arrJobsiteOffsiteworkRegionsByProjectId)
	{
		self::$_arrJobsiteOffsiteworkRegionsByProjectId = $arrJobsiteOffsiteworkRegionsByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteOffsiteworkRegions()
	{
		if (isset(self::$_arrAllJobsiteOffsiteworkRegions)) {
			return self::$_arrAllJobsiteOffsiteworkRegions;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteOffsiteworkRegions($arrAllJobsiteOffsiteworkRegions)
	{
		self::$_arrAllJobsiteOffsiteworkRegions = $arrAllJobsiteOffsiteworkRegions;
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
	 * @param int $jobsite_offsitework_region_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_offsitework_region_id, $table='jobsite_offsitework_regions', $module='JobsiteOffsiteworkRegion')
	{
		$jobsiteOffsiteworkRegion = parent::findById($database, $jobsite_offsitework_region_id, $table, $module);

		return $jobsiteOffsiteworkRegion;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_region_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteOffsiteworkRegionByIdExtended($database, $jobsite_offsitework_region_id)
	{
		$jobsite_offsitework_region_id = (int) $jobsite_offsitework_region_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jor_fk_p.`id` AS 'jor_fk_p__project_id',
	jor_fk_p.`project_type_id` AS 'jor_fk_p__project_type_id',
	jor_fk_p.`user_company_id` AS 'jor_fk_p__user_company_id',
	jor_fk_p.`user_custom_project_id` AS 'jor_fk_p__user_custom_project_id',
	jor_fk_p.`project_name` AS 'jor_fk_p__project_name',
	jor_fk_p.`project_owner_name` AS 'jor_fk_p__project_owner_name',
	jor_fk_p.`latitude` AS 'jor_fk_p__latitude',
	jor_fk_p.`longitude` AS 'jor_fk_p__longitude',
	jor_fk_p.`address_line_1` AS 'jor_fk_p__address_line_1',
	jor_fk_p.`address_line_2` AS 'jor_fk_p__address_line_2',
	jor_fk_p.`address_line_3` AS 'jor_fk_p__address_line_3',
	jor_fk_p.`address_line_4` AS 'jor_fk_p__address_line_4',
	jor_fk_p.`address_city` AS 'jor_fk_p__address_city',
	jor_fk_p.`address_county` AS 'jor_fk_p__address_county',
	jor_fk_p.`address_state_or_region` AS 'jor_fk_p__address_state_or_region',
	jor_fk_p.`address_postal_code` AS 'jor_fk_p__address_postal_code',
	jor_fk_p.`address_postal_code_extension` AS 'jor_fk_p__address_postal_code_extension',
	jor_fk_p.`address_country` AS 'jor_fk_p__address_country',
	jor_fk_p.`building_count` AS 'jor_fk_p__building_count',
	jor_fk_p.`unit_count` AS 'jor_fk_p__unit_count',
	jor_fk_p.`gross_square_footage` AS 'jor_fk_p__gross_square_footage',
	jor_fk_p.`net_rentable_square_footage` AS 'jor_fk_p__net_rentable_square_footage',
	jor_fk_p.`is_active_flag` AS 'jor_fk_p__is_active_flag',
	jor_fk_p.`public_plans_flag` AS 'jor_fk_p__public_plans_flag',
	jor_fk_p.`prevailing_wage_flag` AS 'jor_fk_p__prevailing_wage_flag',
	jor_fk_p.`city_business_license_required_flag` AS 'jor_fk_p__city_business_license_required_flag',
	jor_fk_p.`is_internal_flag` AS 'jor_fk_p__is_internal_flag',
	jor_fk_p.`project_contract_date` AS 'jor_fk_p__project_contract_date',
	jor_fk_p.`project_start_date` AS 'jor_fk_p__project_start_date',
	jor_fk_p.`project_completed_date` AS 'jor_fk_p__project_completed_date',
	jor_fk_p.`sort_order` AS 'jor_fk_p__sort_order',

	jor.*

FROM `jobsite_offsitework_regions` jor
	INNER JOIN `projects` jor_fk_p ON jor.`project_id` = jor_fk_p.`id`
WHERE jor.`id` = ?
";
		$arrValues = array($jobsite_offsitework_region_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_offsitework_region_id = $row['id'];
			$jobsiteOffsiteworkRegion = self::instantiateOrm($database, 'JobsiteOffsiteworkRegion', $row, null, $jobsite_offsitework_region_id);
			/* @var $jobsiteOffsiteworkRegion JobsiteOffsiteworkRegion */
			$jobsiteOffsiteworkRegion->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['jor_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'jor_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$jobsiteOffsiteworkRegion->setProject($project);

			return $jobsiteOffsiteworkRegion;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_offsitework_region` (`project_id`,`jobsite_offsitework_region`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_offsitework_region
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndJobsiteOffsiteworkRegion($database, $project_id, $jobsite_offsitework_region)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jor.*

FROM `jobsite_offsitework_regions` jor
WHERE jor.`project_id` = ?
AND jor.`jobsite_offsitework_region` = ?
";
		$arrValues = array($project_id, $jobsite_offsitework_region);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_offsitework_region_id = $row['id'];
			$jobsiteOffsiteworkRegion = self::instantiateOrm($database, 'JobsiteOffsiteworkRegion', $row, null, $jobsite_offsitework_region_id);
			/* @var $jobsiteOffsiteworkRegion JobsiteOffsiteworkRegion */
			return $jobsiteOffsiteworkRegion;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteOffsiteworkRegionIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkRegionsByArrJobsiteOffsiteworkRegionIds($database, $arrJobsiteOffsiteworkRegionIds, Input $options=null)
	{
		if (empty($arrJobsiteOffsiteworkRegionIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_region` ASC, `jobsite_offsitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jor.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkRegion = new JobsiteOffsiteworkRegion($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkRegion->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteOffsiteworkRegionIds as $k => $jobsite_offsitework_region_id) {
			$jobsite_offsitework_region_id = (int) $jobsite_offsitework_region_id;
			$arrJobsiteOffsiteworkRegionIds[$k] = $db->escape($jobsite_offsitework_region_id);
		}
		$csvJobsiteOffsiteworkRegionIds = join(',', $arrJobsiteOffsiteworkRegionIds);

		$query =
"
SELECT

	jor.*

FROM `jobsite_offsitework_regions` jor
WHERE jor.`id` IN ($csvJobsiteOffsiteworkRegionIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteOffsiteworkRegionsByCsvJobsiteOffsiteworkRegionIds = array();
		while ($row = $db->fetch()) {
			$jobsite_offsitework_region_id = $row['id'];
			$jobsiteOffsiteworkRegion = self::instantiateOrm($database, 'JobsiteOffsiteworkRegion', $row, null, $jobsite_offsitework_region_id);
			/* @var $jobsiteOffsiteworkRegion JobsiteOffsiteworkRegion */
			$jobsiteOffsiteworkRegion->convertPropertiesToData();

			$arrJobsiteOffsiteworkRegionsByCsvJobsiteOffsiteworkRegionIds[$jobsite_offsitework_region_id] = $jobsiteOffsiteworkRegion;
		}

		$db->free_result();

		return $arrJobsiteOffsiteworkRegionsByCsvJobsiteOffsiteworkRegionIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_offsitework_regions_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkRegionsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrJobsiteOffsiteworkRegionsByProjectId = null;
		}

		$arrJobsiteOffsiteworkRegionsByProjectId = self::$_arrJobsiteOffsiteworkRegionsByProjectId;
		if (isset($arrJobsiteOffsiteworkRegionsByProjectId) && !empty($arrJobsiteOffsiteworkRegionsByProjectId)) {
			return $arrJobsiteOffsiteworkRegionsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_region` ASC, `jobsite_offsitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jor.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkRegion = new JobsiteOffsiteworkRegion($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkRegion->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jor.*

FROM `jobsite_offsitework_regions` jor
WHERE jor.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_region` ASC, `jobsite_offsitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkRegionsByProjectId = array();
		while ($row = $db->fetch()) {
			$jobsite_offsitework_region_id = $row['id'];
			$jobsiteOffsiteworkRegion = self::instantiateOrm($database, 'JobsiteOffsiteworkRegion', $row, null, $jobsite_offsitework_region_id);
			/* @var $jobsiteOffsiteworkRegion JobsiteOffsiteworkRegion */
			$arrJobsiteOffsiteworkRegionsByProjectId[$jobsite_offsitework_region_id] = $jobsiteOffsiteworkRegion;
		}

		$db->free_result();

		self::$_arrJobsiteOffsiteworkRegionsByProjectId = $arrJobsiteOffsiteworkRegionsByProjectId;

		return $arrJobsiteOffsiteworkRegionsByProjectId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_offsitework_regions records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteOffsiteworkRegions($database, Input $options=null)
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
			self::$_arrAllJobsiteOffsiteworkRegions = null;
		}

		$arrAllJobsiteOffsiteworkRegions = self::$_arrAllJobsiteOffsiteworkRegions;
		if (isset($arrAllJobsiteOffsiteworkRegions) && !empty($arrAllJobsiteOffsiteworkRegions)) {
			return $arrAllJobsiteOffsiteworkRegions;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_region` ASC, `jobsite_offsitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jor.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkRegion = new JobsiteOffsiteworkRegion($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkRegion->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jor.*

FROM `jobsite_offsitework_regions` jor{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_region` ASC, `jobsite_offsitework_region_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteOffsiteworkRegions = array();
		while ($row = $db->fetch()) {
			$jobsite_offsitework_region_id = $row['id'];
			$jobsiteOffsiteworkRegion = self::instantiateOrm($database, 'JobsiteOffsiteworkRegion', $row, null, $jobsite_offsitework_region_id);
			/* @var $jobsiteOffsiteworkRegion JobsiteOffsiteworkRegion */
			$arrAllJobsiteOffsiteworkRegions[$jobsite_offsitework_region_id] = $jobsiteOffsiteworkRegion;
		}

		$db->free_result();

		self::$_arrAllJobsiteOffsiteworkRegions = $arrAllJobsiteOffsiteworkRegions;

		return $arrAllJobsiteOffsiteworkRegions;
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
INTO `jobsite_offsitework_regions`
(`project_id`, `jobsite_offsitework_region`, `jobsite_offsitework_region_description`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_offsitework_region_description` = ?, `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->project_id, $this->jobsite_offsitework_region, $this->jobsite_offsitework_region_description, $this->sort_order, $this->disabled_flag, $this->jobsite_offsitework_region_description, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_offsitework_region_id = $db->insertId;
		$db->free_result();

		return $jobsite_offsitework_region_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

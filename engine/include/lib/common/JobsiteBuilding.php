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
 * JobsiteBuilding.
 *
 * @category   Framework
 * @package    JobsiteBuilding
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteBuilding extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteBuilding';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_buildings';

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
	 * unique index `unique_jobsite_building` (`project_id`,`jobsite_building`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_building' => array(
			'project_id' => 'int',
			'jobsite_building' => 'string'
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
		'id' => 'jobsite_building_id',

		'project_id' => 'project_id',

		'jobsite_building' => 'jobsite_building',

		'jobsite_building_description' => 'jobsite_building_description',
		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_building_id;

	public $project_id;

	public $jobsite_building;

	public $jobsite_building_description;
	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_building;
	public $escaped_jobsite_building_description;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_building_nl2br;
	public $escaped_jobsite_building_description_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteBuildingsByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteBuildings;

	// Foreign Key Objects
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_buildings')
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
	public static function getArrJobsiteBuildingsByProjectId()
	{
		if (isset(self::$_arrJobsiteBuildingsByProjectId)) {
			return self::$_arrJobsiteBuildingsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteBuildingsByProjectId($arrJobsiteBuildingsByProjectId)
	{
		self::$_arrJobsiteBuildingsByProjectId = $arrJobsiteBuildingsByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteBuildings()
	{
		if (isset(self::$_arrAllJobsiteBuildings)) {
			return self::$_arrAllJobsiteBuildings;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteBuildings($arrAllJobsiteBuildings)
	{
		self::$_arrAllJobsiteBuildings = $arrAllJobsiteBuildings;
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
	 * @param int $jobsite_building_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_building_id, $table='jobsite_buildings', $module='JobsiteBuilding')
	{
		$jobsiteBuilding = parent::findById($database, $jobsite_building_id, $table, $module);

		return $jobsiteBuilding;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_building_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteBuildingByIdExtended($database, $jobsite_building_id)
	{
		$jobsite_building_id = (int) $jobsite_building_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jb_fk_p.`id` AS 'jb_fk_p__project_id',
	jb_fk_p.`project_type_id` AS 'jb_fk_p__project_type_id',
	jb_fk_p.`user_company_id` AS 'jb_fk_p__user_company_id',
	jb_fk_p.`user_custom_project_id` AS 'jb_fk_p__user_custom_project_id',
	jb_fk_p.`project_name` AS 'jb_fk_p__project_name',
	jb_fk_p.`project_owner_name` AS 'jb_fk_p__project_owner_name',
	jb_fk_p.`latitude` AS 'jb_fk_p__latitude',
	jb_fk_p.`longitude` AS 'jb_fk_p__longitude',
	jb_fk_p.`address_line_1` AS 'jb_fk_p__address_line_1',
	jb_fk_p.`address_line_2` AS 'jb_fk_p__address_line_2',
	jb_fk_p.`address_line_3` AS 'jb_fk_p__address_line_3',
	jb_fk_p.`address_line_4` AS 'jb_fk_p__address_line_4',
	jb_fk_p.`address_city` AS 'jb_fk_p__address_city',
	jb_fk_p.`address_county` AS 'jb_fk_p__address_county',
	jb_fk_p.`address_state_or_region` AS 'jb_fk_p__address_state_or_region',
	jb_fk_p.`address_postal_code` AS 'jb_fk_p__address_postal_code',
	jb_fk_p.`address_postal_code_extension` AS 'jb_fk_p__address_postal_code_extension',
	jb_fk_p.`address_country` AS 'jb_fk_p__address_country',
	jb_fk_p.`building_count` AS 'jb_fk_p__building_count',
	jb_fk_p.`unit_count` AS 'jb_fk_p__unit_count',
	jb_fk_p.`gross_square_footage` AS 'jb_fk_p__gross_square_footage',
	jb_fk_p.`net_rentable_square_footage` AS 'jb_fk_p__net_rentable_square_footage',
	jb_fk_p.`is_active_flag` AS 'jb_fk_p__is_active_flag',
	jb_fk_p.`public_plans_flag` AS 'jb_fk_p__public_plans_flag',
	jb_fk_p.`prevailing_wage_flag` AS 'jb_fk_p__prevailing_wage_flag',
	jb_fk_p.`city_business_license_required_flag` AS 'jb_fk_p__city_business_license_required_flag',
	jb_fk_p.`is_internal_flag` AS 'jb_fk_p__is_internal_flag',
	jb_fk_p.`project_contract_date` AS 'jb_fk_p__project_contract_date',
	jb_fk_p.`project_start_date` AS 'jb_fk_p__project_start_date',
	jb_fk_p.`project_completed_date` AS 'jb_fk_p__project_completed_date',
	jb_fk_p.`sort_order` AS 'jb_fk_p__sort_order',

	jb.*

FROM `jobsite_buildings` jb
	INNER JOIN `projects` jb_fk_p ON jb.`project_id` = jb_fk_p.`id`
WHERE jb.`id` = ?
";
		$arrValues = array($jobsite_building_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_building_id = $row['id'];
			$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id);
			/* @var $jobsiteBuilding JobsiteBuilding */
			$jobsiteBuilding->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['jb_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'jb_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$jobsiteBuilding->setProject($project);

			return $jobsiteBuilding;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_building` (`project_id`,`jobsite_building`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_building
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndJobsiteBuilding($database, $project_id, $jobsite_building)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jb.*

FROM `jobsite_buildings` jb
WHERE jb.`project_id` = ?
AND jb.`jobsite_building` = ?
";
		$arrValues = array($project_id, $jobsite_building);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_building_id = $row['id'];
			$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id);
			/* @var $jobsiteBuilding JobsiteBuilding */
			return $jobsiteBuilding;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteBuildingIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingsByArrJobsiteBuildingIds($database, $arrJobsiteBuildingIds, Input $options=null)
	{
		if (empty($arrJobsiteBuildingIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building` ASC, `jobsite_building_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuilding = new JobsiteBuilding($database);
			$sqlOrderByColumns = $tmpJobsiteBuilding->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteBuildingIds as $k => $jobsite_building_id) {
			$jobsite_building_id = (int) $jobsite_building_id;
			$arrJobsiteBuildingIds[$k] = $db->escape($jobsite_building_id);
		}
		$csvJobsiteBuildingIds = join(',', $arrJobsiteBuildingIds);

		$query =
"
SELECT

	jb.*

FROM `jobsite_buildings` jb
WHERE jb.`id` IN ($csvJobsiteBuildingIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteBuildingsByCsvJobsiteBuildingIds = array();
		while ($row = $db->fetch()) {
			$jobsite_building_id = $row['id'];
			$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id);
			/* @var $jobsiteBuilding JobsiteBuilding */
			$jobsiteBuilding->convertPropertiesToData();

			$arrJobsiteBuildingsByCsvJobsiteBuildingIds[$jobsite_building_id] = $jobsiteBuilding;
		}

		$db->free_result();

		return $arrJobsiteBuildingsByCsvJobsiteBuildingIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_buildings_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrJobsiteBuildingsByProjectId = null;
		}

		$arrJobsiteBuildingsByProjectId = self::$_arrJobsiteBuildingsByProjectId;
		if (isset($arrJobsiteBuildingsByProjectId) && !empty($arrJobsiteBuildingsByProjectId)) {
			return $arrJobsiteBuildingsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building` ASC, `jobsite_building_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuilding = new JobsiteBuilding($database);
			$sqlOrderByColumns = $tmpJobsiteBuilding->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jb.*

FROM `jobsite_buildings` jb
WHERE jb.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building` ASC, `jobsite_building_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteBuildingsByProjectId = array();
		while ($row = $db->fetch()) {
			$jobsite_building_id = $row['id'];
			$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id);
			/* @var $jobsiteBuilding JobsiteBuilding */
			$arrJobsiteBuildingsByProjectId[$jobsite_building_id] = $jobsiteBuilding;
		}

		$db->free_result();

		self::$_arrJobsiteBuildingsByProjectId = $arrJobsiteBuildingsByProjectId;

		return $arrJobsiteBuildingsByProjectId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_buildings records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteBuildings($database, Input $options=null)
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
			self::$_arrAllJobsiteBuildings = null;
		}

		$arrAllJobsiteBuildings = self::$_arrAllJobsiteBuildings;
		if (isset($arrAllJobsiteBuildings) && !empty($arrAllJobsiteBuildings)) {
			return $arrAllJobsiteBuildings;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building` ASC, `jobsite_building_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jb.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuilding = new JobsiteBuilding($database);
			$sqlOrderByColumns = $tmpJobsiteBuilding->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jb.*

FROM `jobsite_buildings` jb{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building` ASC, `jobsite_building_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteBuildings = array();
		while ($row = $db->fetch()) {
			$jobsite_building_id = $row['id'];
			$jobsiteBuilding = self::instantiateOrm($database, 'JobsiteBuilding', $row, null, $jobsite_building_id);
			/* @var $jobsiteBuilding JobsiteBuilding */
			$arrAllJobsiteBuildings[$jobsite_building_id] = $jobsiteBuilding;
		}

		$db->free_result();

		self::$_arrAllJobsiteBuildings = $arrAllJobsiteBuildings;

		return $arrAllJobsiteBuildings;
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
INTO `jobsite_buildings`
(`project_id`, `jobsite_building`, `jobsite_building_description`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_building_description` = ?, `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->project_id, $this->jobsite_building, $this->jobsite_building_description, $this->sort_order, $this->disabled_flag, $this->jobsite_building_description, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_building_id = $db->insertId;
		$db->free_result();

		return $jobsite_building_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

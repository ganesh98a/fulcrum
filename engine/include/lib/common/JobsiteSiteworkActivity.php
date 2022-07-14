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
 * JobsiteSiteworkActivity.
 *
 * @category   Framework
 * @package    JobsiteSiteworkActivity
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteSiteworkActivity extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteSiteworkActivity';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_sitework_activities';

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
	 * unique index `unique_jobsite_sitework_activity` (`project_id`,`jobsite_sitework_activity_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_sitework_activity' => array(
			'project_id' => 'int',
			'jobsite_sitework_activity_label' => 'string'
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
		'id' => 'jobsite_sitework_activity_id',

		'project_id' => 'project_id',

		'jobsite_sitework_activity_label' => 'jobsite_sitework_activity_label',

		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_sitework_activity_id;

	public $project_id;

	public $jobsite_sitework_activity_label;

	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_sitework_activity_label;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteSiteworkActivitiesByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteSiteworkActivities;

	// Foreign Key Objects
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_sitework_activities')
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
	public static function getArrJobsiteSiteworkActivitiesByProjectId()
	{
		if (isset(self::$_arrJobsiteSiteworkActivitiesByProjectId)) {
			return self::$_arrJobsiteSiteworkActivitiesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSiteworkActivitiesByProjectId($arrJobsiteSiteworkActivitiesByProjectId)
	{
		self::$_arrJobsiteSiteworkActivitiesByProjectId = $arrJobsiteSiteworkActivitiesByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteSiteworkActivities()
	{
		if (isset(self::$_arrAllJobsiteSiteworkActivities)) {
			return self::$_arrAllJobsiteSiteworkActivities;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteSiteworkActivities($arrAllJobsiteSiteworkActivities)
	{
		self::$_arrAllJobsiteSiteworkActivities = $arrAllJobsiteSiteworkActivities;
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
	 * @param int $jobsite_sitework_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_sitework_activity_id, $table='jobsite_sitework_activities', $module='JobsiteSiteworkActivity')
	{
		$jobsiteSiteworkActivity = parent::findById($database, $jobsite_sitework_activity_id, $table, $module);

		return $jobsiteSiteworkActivity;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteSiteworkActivityByIdExtended($database, $jobsite_sitework_activity_id)
	{
		$jobsite_sitework_activity_id = (int) $jobsite_sitework_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jsa_fk_p.`id` AS 'jsa_fk_p__project_id',
	jsa_fk_p.`project_type_id` AS 'jsa_fk_p__project_type_id',
	jsa_fk_p.`user_company_id` AS 'jsa_fk_p__user_company_id',
	jsa_fk_p.`user_custom_project_id` AS 'jsa_fk_p__user_custom_project_id',
	jsa_fk_p.`project_name` AS 'jsa_fk_p__project_name',
	jsa_fk_p.`project_owner_name` AS 'jsa_fk_p__project_owner_name',
	jsa_fk_p.`latitude` AS 'jsa_fk_p__latitude',
	jsa_fk_p.`longitude` AS 'jsa_fk_p__longitude',
	jsa_fk_p.`address_line_1` AS 'jsa_fk_p__address_line_1',
	jsa_fk_p.`address_line_2` AS 'jsa_fk_p__address_line_2',
	jsa_fk_p.`address_line_3` AS 'jsa_fk_p__address_line_3',
	jsa_fk_p.`address_line_4` AS 'jsa_fk_p__address_line_4',
	jsa_fk_p.`address_city` AS 'jsa_fk_p__address_city',
	jsa_fk_p.`address_county` AS 'jsa_fk_p__address_county',
	jsa_fk_p.`address_state_or_region` AS 'jsa_fk_p__address_state_or_region',
	jsa_fk_p.`address_postal_code` AS 'jsa_fk_p__address_postal_code',
	jsa_fk_p.`address_postal_code_extension` AS 'jsa_fk_p__address_postal_code_extension',
	jsa_fk_p.`address_country` AS 'jsa_fk_p__address_country',
	jsa_fk_p.`building_count` AS 'jsa_fk_p__building_count',
	jsa_fk_p.`unit_count` AS 'jsa_fk_p__unit_count',
	jsa_fk_p.`gross_square_footage` AS 'jsa_fk_p__gross_square_footage',
	jsa_fk_p.`net_rentable_square_footage` AS 'jsa_fk_p__net_rentable_square_footage',
	jsa_fk_p.`is_active_flag` AS 'jsa_fk_p__is_active_flag',
	jsa_fk_p.`public_plans_flag` AS 'jsa_fk_p__public_plans_flag',
	jsa_fk_p.`prevailing_wage_flag` AS 'jsa_fk_p__prevailing_wage_flag',
	jsa_fk_p.`city_business_license_required_flag` AS 'jsa_fk_p__city_business_license_required_flag',
	jsa_fk_p.`is_internal_flag` AS 'jsa_fk_p__is_internal_flag',
	jsa_fk_p.`project_contract_date` AS 'jsa_fk_p__project_contract_date',
	jsa_fk_p.`project_start_date` AS 'jsa_fk_p__project_start_date',
	jsa_fk_p.`project_completed_date` AS 'jsa_fk_p__project_completed_date',
	jsa_fk_p.`sort_order` AS 'jsa_fk_p__sort_order',

	jsa.*

FROM `jobsite_sitework_activities` jsa
	INNER JOIN `projects` jsa_fk_p ON jsa.`project_id` = jsa_fk_p.`id`
WHERE jsa.`id` = ?
";
		$arrValues = array($jobsite_sitework_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_sitework_activity_id = $row['id'];
			$jobsiteSiteworkActivity = self::instantiateOrm($database, 'JobsiteSiteworkActivity', $row, null, $jobsite_sitework_activity_id);
			/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */
			$jobsiteSiteworkActivity->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['jsa_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'jsa_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$jobsiteSiteworkActivity->setProject($project);

			return $jobsiteSiteworkActivity;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_sitework_activity` (`project_id`,`jobsite_sitework_activity_label`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_sitework_activity_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndJobsiteSiteworkActivityLabel($database, $project_id, $jobsite_sitework_activity_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jsa.*

FROM `jobsite_sitework_activities` jsa
WHERE jsa.`project_id` = ?
AND jsa.`jobsite_sitework_activity_label` = ?
";
		$arrValues = array($project_id, $jobsite_sitework_activity_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_sitework_activity_id = $row['id'];
			$jobsiteSiteworkActivity = self::instantiateOrm($database, 'JobsiteSiteworkActivity', $row, null, $jobsite_sitework_activity_id);
			/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */
			return $jobsiteSiteworkActivity;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteSiteworkActivityIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivitiesByArrJobsiteSiteworkActivityIds($database, $arrJobsiteSiteworkActivityIds, Input $options=null)
	{
		if (empty($arrJobsiteSiteworkActivityIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivity = new JobsiteSiteworkActivity($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteSiteworkActivityIds as $k => $jobsite_sitework_activity_id) {
			$jobsite_sitework_activity_id = (int) $jobsite_sitework_activity_id;
			$arrJobsiteSiteworkActivityIds[$k] = $db->escape($jobsite_sitework_activity_id);
		}
		$csvJobsiteSiteworkActivityIds = join(',', $arrJobsiteSiteworkActivityIds);

		$query =
"
SELECT

	jsa.*

FROM `jobsite_sitework_activities` jsa
WHERE jsa.`id` IN ($csvJobsiteSiteworkActivityIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		// $row = $db->fetch();
		// $db->free_result();


		$arrJobsiteSiteworkActivitiesByCsvJobsiteSiteworkActivityIds = array();
		while ($row = $db->fetch()) {
			$jobsite_sitework_activity_id = $row['id'];
			$jobsiteSiteworkActivity = self::instantiateOrm($database, 'JobsiteSiteworkActivity', $row, null, $jobsite_sitework_activity_id);
			/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */
			$jobsiteSiteworkActivity->convertPropertiesToData();

			$arrJobsiteSiteworkActivitiesByCsvJobsiteSiteworkActivityIds[$jobsite_sitework_activity_id] = $jobsiteSiteworkActivity;
		}

		$db->free_result();

		return $arrJobsiteSiteworkActivitiesByCsvJobsiteSiteworkActivityIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_sitework_activities_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivitiesByProjectId($database, $project_id, Input $options=null)
	{
		$forceLoadFlag = false;
		$extendedReturn = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			$filterByCostCode = $options->filterByCostCode;
			$extendedReturn = $options->extendedReturn;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset) || isset($filterByCostCode)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrJobsiteSiteworkActivitiesByProjectId = null;
		}

		$arrJobsiteSiteworkActivitiesByProjectId = self::$_arrJobsiteSiteworkActivitiesByProjectId;
		if (isset($arrJobsiteSiteworkActivitiesByProjectId) && !empty($arrJobsiteSiteworkActivitiesByProjectId)) {
			return $arrJobsiteSiteworkActivitiesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlFilter = '';
		if (isset($filterByCostCode) && !empty($filterByCostCode)) {
			$escapedFilterByCostCode = $db->escape($filterByCostCode);
			$sqlFilter = "\nAND codes.`cost_code` = $escapedFilterByCostCode";
		}

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivity = new JobsiteSiteworkActivity($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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
		$sql_group="group by jsa.`id`";

		$query =
"
SELECT

	codes.`id` AS 'code__cost_code_id',
	codes.`cost_code_division_id` AS 'code__cost_code_division_id',
	codes.`cost_code` AS 'code__cost_code',
	codes.`cost_code_description` AS 'code__cost_code_description',
	codes.`cost_code_description_abbreviation` AS 'code__cost_code_description_abbreviation',
	codes.`sort_order` AS 'code__sort_order',
	codes.`disabled_flag` AS 'code__disabled_flag',

	ccd.`id` AS 'ccd__cost_code_division_id',
	ccd.`user_company_id` AS 'ccd__user_company_id',
	ccd.`cost_code_type_id` AS 'ccd__cost_code_type_id',
	ccd.`division_number` AS 'ccd__division_number',
	ccd.`division_code_heading` AS 'ccd__division_code_heading',
	ccd.`division` AS 'ccd__division',
	ccd.`division_abbreviation` AS 'ccd__division_abbreviation',
	ccd.`sort_order` AS 'ccd__sort_order',
	ccd.`disabled_flag` AS 'ccd__disabled_flag',

	jsa.*

FROM `jobsite_sitework_activities` jsa

	LEFT OUTER JOIN `jobsite_sitework_activities_to_cost_codes` jsatcc ON jsa.`id` = jsatcc.`jobsite_sitework_activity_id`
	LEFT OUTER JOIN `cost_codes` codes ON jsatcc.`cost_code_id` = codes.`id`
	LEFT OUTER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE jsa.`project_id` = ?{$sqlFilter} {$sql_group}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeIds = array();
		$arrJobsiteSiteworkActivityIds = array();
		$arrJobsiteSiteworkActivitiesByProjectId = array();
		$arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId = array();
		$arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel = array();
		$jobsiteSiteworkActivityLabelMaxLength = 0;
		while ($row = $db->fetch()) {
			$jobsite_sitework_activity_id = $row['id'];
			$cost_code_id = $row['code__cost_code_id'];
			$cost_code_division_id = $row['ccd__cost_code_division_id'];
			$jobsite_sitework_activity_label = $row['jobsite_sitework_activity_label'];

			$jobsiteSiteworkActivity = self::instantiateOrm($database, 'JobsiteSiteworkActivity', $row, null, $jobsite_sitework_activity_id);
			/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */
			$jobsiteSiteworkActivity->convertPropertiesToData();
			$arrJobsiteSiteworkActivitiesByProjectId[$jobsite_sitework_activity_id] = $jobsiteSiteworkActivity;

			$jobsiteSiteworkActivityLabelLength = strlen($jobsite_sitework_activity_label);
			if ($jobsiteSiteworkActivityLabelLength > $jobsiteSiteworkActivityLabelMaxLength) {
				$jobsiteSiteworkActivityLabelMaxLength = $jobsiteSiteworkActivityLabelLength;
			}
			$arrJobsiteSiteworkActivityIds[$jobsite_sitework_activity_id] = $jobsiteSiteworkActivityLabelLength;

			$arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel[$jobsite_sitework_activity_label][$jobsite_sitework_activity_id] = $jobsiteSiteworkActivityLabelLength;

			if (isset($cost_code_id) && !empty($cost_code_id)) {
				$arrCostCodeIds[$cost_code_id] = $cost_code_id;
			} else {
				$cost_code_id = 'null';
			}
			// $arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId[$cost_code_id][$jobsite_sitework_activity_id] = $jobsiteSiteworkActivity;
			$arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId[][$jobsite_sitework_activity_id] = $jobsiteSiteworkActivity;
		}

		$db->free_result();

		self::$_arrJobsiteSiteworkActivitiesByProjectId = $arrJobsiteSiteworkActivitiesByProjectId;

		if ($extendedReturn) {

			$arrReturn = array(
				'cost_code_ids' => $arrCostCodeIds,
				'jobsite_sitework_activity_ids' => $arrJobsiteSiteworkActivityIds,
				'jobsite_sitework_activities_by_cost_code_id' => $arrJobsiteSiteworkActivitiesByProjectIdByCostCodeId,
				'jobsite_sitework_activities_by_project_id_by_jobsite_sitework_activity_label' => $arrJobsiteSiteworkActivitiesByProjectIdByJobsiteSiteworkActivityLabel,
				'jobsite_sitework_activities_by_project_id' => $arrJobsiteSiteworkActivitiesByProjectId,
				'jobsite_sitework_activity_label_maxlength' => $jobsiteSiteworkActivityLabelMaxLength
			);

			return $arrReturn;

		} else {

			return $arrJobsiteSiteworkActivitiesByProjectId;

		}
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_sitework_activities records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteSiteworkActivities($database, Input $options=null)
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
			self::$_arrAllJobsiteSiteworkActivities = null;
		}

		$arrAllJobsiteSiteworkActivities = self::$_arrAllJobsiteSiteworkActivities;
		if (isset($arrAllJobsiteSiteworkActivities) && !empty($arrAllJobsiteSiteworkActivities)) {
			return $arrAllJobsiteSiteworkActivities;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivity = new JobsiteSiteworkActivity($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsa.*

FROM `jobsite_sitework_activities` jsa{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteSiteworkActivities = array();
		while ($row = $db->fetch()) {
			$jobsite_sitework_activity_id = $row['id'];
			$jobsiteSiteworkActivity = self::instantiateOrm($database, 'JobsiteSiteworkActivity', $row, null, $jobsite_sitework_activity_id);
			/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */
			$arrAllJobsiteSiteworkActivities[$jobsite_sitework_activity_id] = $jobsiteSiteworkActivity;
		}

		$db->free_result();

		self::$_arrAllJobsiteSiteworkActivities = $arrAllJobsiteSiteworkActivities;

		return $arrAllJobsiteSiteworkActivities;
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
INTO `jobsite_sitework_activities`
(`project_id`, `jobsite_sitework_activity_label`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->project_id, $this->jobsite_sitework_activity_label, $this->sort_order, $this->disabled_flag, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_sitework_activity_id = $db->insertId;
		$db->free_result();

		return $jobsite_sitework_activity_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

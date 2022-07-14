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
 * JobsiteBuildingActivity.
 *
 * @category   Framework
 * @package    JobsiteBuildingActivity
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteBuildingActivity extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteBuildingActivity';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_building_activities';

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
	 * unique index `unique_jobsite_building_activity` (`project_id`,`jobsite_building_activity_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_building_activity' => array(
			'project_id' => 'int',
			'jobsite_building_activity_label' => 'string'
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
		'id' => 'jobsite_building_activity_id',

		'project_id' => 'project_id',

		'jobsite_building_activity_label' => 'jobsite_building_activity_label',

		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_building_activity_id;

	public $project_id;

	public $jobsite_building_activity_label;

	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_building_activity_label;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_building_activity_label_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteBuildingActivitiesByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteBuildingActivities;

	// Foreign Key Objects
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_building_activities')
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
	public static function getArrJobsiteBuildingActivitiesByProjectId()
	{
		if (isset(self::$_arrJobsiteBuildingActivitiesByProjectId)) {
			return self::$_arrJobsiteBuildingActivitiesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteBuildingActivitiesByProjectId($arrJobsiteBuildingActivitiesByProjectId)
	{
		self::$_arrJobsiteBuildingActivitiesByProjectId = $arrJobsiteBuildingActivitiesByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteBuildingActivities()
	{
		if (isset(self::$_arrAllJobsiteBuildingActivities)) {
			return self::$_arrAllJobsiteBuildingActivities;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteBuildingActivities($arrAllJobsiteBuildingActivities)
	{
		self::$_arrAllJobsiteBuildingActivities = $arrAllJobsiteBuildingActivities;
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
	 * @param int $jobsite_building_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_building_activity_id, $table='jobsite_building_activities', $module='JobsiteBuildingActivity')
	{
		$jobsiteBuildingActivity = parent::findById($database, $jobsite_building_activity_id, $table, $module);

		return $jobsiteBuildingActivity;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteBuildingActivityByIdExtended($database, $jobsite_building_activity_id)
	{
		$jobsite_building_activity_id = (int) $jobsite_building_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jba_fk_p.`id` AS 'jba_fk_p__project_id',
	jba_fk_p.`project_type_id` AS 'jba_fk_p__project_type_id',
	jba_fk_p.`user_company_id` AS 'jba_fk_p__user_company_id',
	jba_fk_p.`user_custom_project_id` AS 'jba_fk_p__user_custom_project_id',
	jba_fk_p.`project_name` AS 'jba_fk_p__project_name',
	jba_fk_p.`project_owner_name` AS 'jba_fk_p__project_owner_name',
	jba_fk_p.`latitude` AS 'jba_fk_p__latitude',
	jba_fk_p.`longitude` AS 'jba_fk_p__longitude',
	jba_fk_p.`address_line_1` AS 'jba_fk_p__address_line_1',
	jba_fk_p.`address_line_2` AS 'jba_fk_p__address_line_2',
	jba_fk_p.`address_line_3` AS 'jba_fk_p__address_line_3',
	jba_fk_p.`address_line_4` AS 'jba_fk_p__address_line_4',
	jba_fk_p.`address_city` AS 'jba_fk_p__address_city',
	jba_fk_p.`address_county` AS 'jba_fk_p__address_county',
	jba_fk_p.`address_state_or_region` AS 'jba_fk_p__address_state_or_region',
	jba_fk_p.`address_postal_code` AS 'jba_fk_p__address_postal_code',
	jba_fk_p.`address_postal_code_extension` AS 'jba_fk_p__address_postal_code_extension',
	jba_fk_p.`address_country` AS 'jba_fk_p__address_country',
	jba_fk_p.`building_count` AS 'jba_fk_p__building_count',
	jba_fk_p.`unit_count` AS 'jba_fk_p__unit_count',
	jba_fk_p.`gross_square_footage` AS 'jba_fk_p__gross_square_footage',
	jba_fk_p.`net_rentable_square_footage` AS 'jba_fk_p__net_rentable_square_footage',
	jba_fk_p.`is_active_flag` AS 'jba_fk_p__is_active_flag',
	jba_fk_p.`public_plans_flag` AS 'jba_fk_p__public_plans_flag',
	jba_fk_p.`prevailing_wage_flag` AS 'jba_fk_p__prevailing_wage_flag',
	jba_fk_p.`city_business_license_required_flag` AS 'jba_fk_p__city_business_license_required_flag',
	jba_fk_p.`is_internal_flag` AS 'jba_fk_p__is_internal_flag',
	jba_fk_p.`project_contract_date` AS 'jba_fk_p__project_contract_date',
	jba_fk_p.`project_start_date` AS 'jba_fk_p__project_start_date',
	jba_fk_p.`project_completed_date` AS 'jba_fk_p__project_completed_date',
	jba_fk_p.`sort_order` AS 'jba_fk_p__sort_order',

	jba.*

FROM `jobsite_building_activities` jba
	INNER JOIN `projects` jba_fk_p ON jba.`project_id` = jba_fk_p.`id`
WHERE jba.`id` = ?
";
		$arrValues = array($jobsite_building_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_building_activity_id = $row['id'];
			$jobsiteBuildingActivity = self::instantiateOrm($database, 'JobsiteBuildingActivity', $row, null, $jobsite_building_activity_id);
			/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
			$jobsiteBuildingActivity->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['jba_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'jba_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$jobsiteBuildingActivity->setProject($project);

			return $jobsiteBuildingActivity;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_building_activity` (`project_id`,`jobsite_building_activity_label`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_building_activity_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndJobsiteBuildingActivityLabel($database, $project_id, $jobsite_building_activity_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jba.*

FROM `jobsite_building_activities` jba
WHERE jba.`project_id` = ?
AND jba.`jobsite_building_activity_label` = ?
";
		$arrValues = array($project_id, $jobsite_building_activity_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_building_activity_id = $row['id'];
			$jobsiteBuildingActivity = self::instantiateOrm($database, 'JobsiteBuildingActivity', $row, null, $jobsite_building_activity_id);
			/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
			return $jobsiteBuildingActivity;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteBuildingActivityIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivitiesByArrJobsiteBuildingActivityIds($database, $arrJobsiteBuildingActivityIds, Input $options=null)
	{
		if (empty($arrJobsiteBuildingActivityIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jba.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivity = new JobsiteBuildingActivity($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteBuildingActivityIds as $k => $jobsite_building_activity_id) {
			$jobsite_building_activity_id = (int) $jobsite_building_activity_id;
			$arrJobsiteBuildingActivityIds[$k] = $db->escape($jobsite_building_activity_id);
		}
		$csvJobsiteBuildingActivityIds = join(',', $arrJobsiteBuildingActivityIds);

		$query =
"
SELECT

	jba.*

FROM `jobsite_building_activities` jba
WHERE jba.`id` IN ($csvJobsiteBuildingActivityIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		//$row = $db->fetch();
		//$db->free_result();

		$arrJobsiteBuildingActivitiesByCsvJobsiteBuildingActivityIds = array();
		while ($row = $db->fetch()) {
			$jobsite_building_activity_id = $row['id'];
			$jobsiteBuildingActivity = self::instantiateOrm($database, 'JobsiteBuildingActivity', $row, null, $jobsite_building_activity_id);
			/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
			$jobsiteBuildingActivity->convertPropertiesToData();

			$arrJobsiteBuildingActivitiesByCsvJobsiteBuildingActivityIds[$jobsite_building_activity_id] = $jobsiteBuildingActivity;
		}

		$db->free_result();

		return $arrJobsiteBuildingActivitiesByCsvJobsiteBuildingActivityIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_building_activities_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivitiesByProjectId($database, $project_id, Input $options=null)
	{
		$forceLoadFlag = false;
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
			self::$_arrJobsiteBuildingActivitiesByProjectId = null;
		}

		$arrJobsiteBuildingActivitiesByProjectId = self::$_arrJobsiteBuildingActivitiesByProjectId;
		if (isset($arrJobsiteBuildingActivitiesByProjectId) && !empty($arrJobsiteBuildingActivitiesByProjectId)) {
			return $arrJobsiteBuildingActivitiesByProjectId;
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
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jba.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivity = new JobsiteBuildingActivity($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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

	jba.*

FROM `jobsite_building_activities` jba
	LEFT OUTER JOIN `jobsite_building_activities_to_cost_codes` jba2codes ON jba.`id` = jba2codes.`jobsite_building_activity_id`
	LEFT OUTER JOIN `cost_codes` codes ON jba2codes.`cost_code_id` = codes.`id`
	LEFT OUTER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE jba.`project_id` = ?{$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeIds = array();
		$arrJobsiteBuildingActivityIds = array();
		$arrJobsiteBuildingActivitiesByProjectId = array();
		$arrJobsiteBuildingActivitiesByProjectIdByCostCodeId = array();
		$arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel = array();
		$jobsiteBuildingActivityLabelMaxLength = 0;
		while ($row = $db->fetch()) {
			$jobsite_building_activity_id = $row['id'];
			$cost_code_id = $row['code__cost_code_id'];
			$cost_code_division_id = $row['ccd__cost_code_division_id'];
			$jobsite_building_activity_label = $row['jobsite_building_activity_label'];

			$jobsiteBuildingActivity = self::instantiateOrm($database, 'JobsiteBuildingActivity', $row, null, $jobsite_building_activity_id);
			/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
			$jobsiteBuildingActivity->convertPropertiesToData();
			$arrJobsiteBuildingActivitiesByProjectId[$jobsite_building_activity_id] = $jobsiteBuildingActivity;

			$jobsiteBuildingActivityLabelLength = strlen($jobsite_building_activity_label);
			if ($jobsiteBuildingActivityLabelLength > $jobsiteBuildingActivityLabelMaxLength) {
				$jobsiteBuildingActivityLabelMaxLength = $jobsiteBuildingActivityLabelLength;
			}
			$arrJobsiteBuildingActivityIds[$jobsite_building_activity_id] = $jobsiteBuildingActivityLabelLength;

			$arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel[$jobsite_building_activity_label][$jobsite_building_activity_id] = $jobsiteBuildingActivity;

			if (isset($cost_code_id) && !empty($cost_code_id)) {
				$arrCostCodeIds[$cost_code_id] = $cost_code_id;
			} else {
				$cost_code_id = 'null';
			}
		//To get the current project company 
		$main_company=JobsiteBuildingActivity::prjectCompany($project_id, $database);
		if($row['ccd__user_company_id'] == NULL || $row['ccd__user_company_id'] == $main_company)
			{
			$arrJobsiteBuildingActivitiesByProjectIdByCostCodeId[$cost_code_id][$jobsite_building_activity_id] = $jobsiteBuildingActivity;
		}
		}

		$db->free_result();

		self::$_arrJobsiteBuildingActivitiesByProjectId = $arrJobsiteBuildingActivitiesByProjectId;

		if ($extendedReturn) {

			$arrReturn = array(
				'cost_code_ids' => $arrCostCodeIds,
				'jobsite_building_activity_ids' => $arrJobsiteBuildingActivityIds,
				'jobsite_building_activities_by_cost_code_id' => $arrJobsiteBuildingActivitiesByProjectIdByCostCodeId,
				'jobsite_building_activities_by_project_id_by_jobsite_building_activity_label' => $arrJobsiteBuildingActivitiesByProjectIdByJobsiteBuildingActivityLabel,
				'jobsite_building_activities_by_project_id' => $arrJobsiteBuildingActivitiesByProjectId,
				'jobsite_building_activity_label_maxlength' => $jobsiteBuildingActivityLabelMaxLength
			);

			return $arrReturn;

		} else {

			return $arrJobsiteBuildingActivitiesByProjectId;

		}
	}
	public static function prjectCompany($project_id, $database)
	{
		$db = DBI::getInstance($database);
		$que ="SELECT * FROM `projects` WHERE `id` = '$project_id' ORDER BY `id` DESC ";
		$db->execute($que);
		$row1=$db->fetch();
		$main_company=$row1['user_company_id'];
		$db->free_result();
		return $main_company;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_building_activities records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteBuildingActivities($database, Input $options=null)
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
			self::$_arrAllJobsiteBuildingActivities = null;
		}

		$arrAllJobsiteBuildingActivities = self::$_arrAllJobsiteBuildingActivities;
		if (isset($arrAllJobsiteBuildingActivities) && !empty($arrAllJobsiteBuildingActivities)) {
			return $arrAllJobsiteBuildingActivities;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jba.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivity = new JobsiteBuildingActivity($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jba.*

FROM `jobsite_building_activities` jba{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteBuildingActivities = array();
		while ($row = $db->fetch()) {
			$jobsite_building_activity_id = $row['id'];
			$jobsiteBuildingActivity = self::instantiateOrm($database, 'JobsiteBuildingActivity', $row, null, $jobsite_building_activity_id);
			/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
			$arrAllJobsiteBuildingActivities[$jobsite_building_activity_id] = $jobsiteBuildingActivity;
		}

		$db->free_result();

		self::$_arrAllJobsiteBuildingActivities = $arrAllJobsiteBuildingActivities;

		return $arrAllJobsiteBuildingActivities;
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
INTO `jobsite_building_activities`
(`project_id`, `jobsite_building_activity_label`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->project_id, $this->jobsite_building_activity_label, $this->sort_order, $this->disabled_flag, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_building_activity_id = $db->insertId;
		$db->free_result();

		return $jobsite_building_activity_id;
	}

	// Save: insert ignore

	// Inject jobsite activities
	public static function insertIgnore_JobsiteBuildingActivities_from_JobsiteBuildingActivityTemplateIds($database, $project_id, $arrJobsiteBuildingActivityTemplateIds)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$escaped_project_id = $db->escape($project_id);

		foreach ($arrJobsiteBuildingActivityTemplateIds as $key => $jobsite_building_activity_template_id) {
			$escaped_jobsite_building_activity_template_id = $db->escape($jobsite_building_activity_template_id);
			$arrJobsiteBuildingActivityTemplateIds[$key] = $escaped_jobsite_building_activity_template_id;
		}

		$csvJobsiteBuildingActivityTemplateIds = join(',', $arrJobsiteBuildingActivityTemplateIds);

		$query =
"
INSERT IGNORE
INTO `jobsite_building_activities`
(`project_id`, `jobsite_building_activity_label`, `sort_order`, `disabled_flag`)
SELECT
	'$escaped_project_id' AS 'project_id',
	jbat.`jobsite_building_activity_label` AS 'jobsite_building_activity_label',
	jbat.`sort_order` AS 'sort_order',
	'N' AS 'disabled_flag'
FROM `jobsite_building_activity_templates` jbat
WHERE `id` IN($csvJobsiteBuildingActivityTemplateIds)
ORDER BY jbat.`sort_order` ASC
";
		$db->query($query, MYSQLI_STORE_RESULT);
		$db->free_result();

		/*
		// Cost code associations (if any)
		$query =
"
INSERT IGNORE
INTO `jobsite_building_activities_to_cost_codes`
(`jobsite_building_activity_id`, `cost_code_id`)
SELECT
	'$escaped_project_id' AS 'project_id',
	jbat.`jobsite_building_activity_label` AS 'jobsite_building_activity_label',
	jbat.`sort_order` AS 'sort_order',
	'N' AS 'disabled_flag'
FROM `jobsite_building_activity_templates` jbat
WHERE `id` IN($csvJobsiteBuildingActivityTemplateIds)
ORDER BY jbat.`sort_order` ASC
";
		$db->query($query, MYSQLI_STORE_RESULT);
		$db->free_result();


INSERT
INTO `test`.`jobsite_building_activity_templates_to_cost_codes`
(`jobsite_building_activity_id`, `cost_code_id`)
#SELECT jbat.id AS 'jobsite_building_activity_template_id', code.id AS 'cost_code_id', cc.`id` AS 'cost_code_id', ba.`display_order` AS 'sort_order', ccd.division_number, cc.cost_code, bacc.*
SELECT jbat.id AS 'jobsite_building_activity_template_id', cc.id AS 'cost_code_id'
#SELECT COUNT(*)
FROM `test`.`jobsite_building_activity_templates` jbat
	INNER JOIN `advent_inc`.`building_activity` ba ON jbat.`jobsite_building_activity_label` = ba.`name`
	INNER JOIN `advent_inc`.`building_activity_cost_code` bacc USING(bld_activity_id)
	INNER JOIN `test`.`cost_code_divisions` ccd ON LEFT(TRIM(bacc.`cost_code`), 2) = ccd.`division_number`
	INNER JOIN `test`.`cost_codes` cc ON RIGHT(TRIM(bacc.`cost_code`), 3) = cc.`cost_code`
WHERE ccd.`user_company_id` = 3
	AND cc.`cost_code_division_id` = ccd.`id`
	AND ba.`bld_activity_id` NOT IN(1,45,218,226,232,233,343,411,416)
	AND ba.`bld_activity_id` NOT IN(204,207,208,209,210,211,213,214,306,307)
	AND ba.`is_milestone` <> 1
ORDER BY jbat.`jobsite_building_activity_label` ASC;
		*/

		return;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

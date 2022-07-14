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
 * JobsiteOffsiteworkActivity.
 *
 * @category   Framework
 * @package    JobsiteOffsiteworkActivity
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteOffsiteworkActivity extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteOffsiteworkActivity';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_offsitework_activities';

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
	 * unique index `unique_jobsite_offsitework_activity` (`project_id`,`jobsite_offsitework_activity_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_offsitework_activity' => array(
			'project_id' => 'int',
			'jobsite_offsitework_activity_label' => 'string'
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
		'id' => 'jobsite_offsitework_activity_id',

		'project_id' => 'project_id',

		'jobsite_offsitework_activity_label' => 'jobsite_offsitework_activity_label',

		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_offsitework_activity_id;

	public $project_id;

	public $jobsite_offsitework_activity_label;

	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_offsitework_activity_label;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteOffsiteworkActivitiesByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteOffsiteworkActivities;

	// Foreign Key Objects
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_offsitework_activities')
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
	public static function getArrJobsiteOffsiteworkActivitiesByProjectId()
	{
		if (isset(self::$_arrJobsiteOffsiteworkActivitiesByProjectId)) {
			return self::$_arrJobsiteOffsiteworkActivitiesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteOffsiteworkActivitiesByProjectId($arrJobsiteOffsiteworkActivitiesByProjectId)
	{
		self::$_arrJobsiteOffsiteworkActivitiesByProjectId = $arrJobsiteOffsiteworkActivitiesByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteOffsiteworkActivities()
	{
		if (isset(self::$_arrAllJobsiteOffsiteworkActivities)) {
			return self::$_arrAllJobsiteOffsiteworkActivities;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteOffsiteworkActivities($arrAllJobsiteOffsiteworkActivities)
	{
		self::$_arrAllJobsiteOffsiteworkActivities = $arrAllJobsiteOffsiteworkActivities;
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
	 * @param int $jobsite_offsitework_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_offsitework_activity_id, $table='jobsite_offsitework_activities', $module='JobsiteOffsiteworkActivity')
	{
		$jobsiteOffsiteworkActivity = parent::findById($database, $jobsite_offsitework_activity_id, $table, $module);

		return $jobsiteOffsiteworkActivity;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteOffsiteworkActivityByIdExtended($database, $jobsite_offsitework_activity_id)
	{
		$jobsite_offsitework_activity_id = (int) $jobsite_offsitework_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	joa_fk_p.`id` AS 'joa_fk_p__project_id',
	joa_fk_p.`project_type_id` AS 'joa_fk_p__project_type_id',
	joa_fk_p.`user_company_id` AS 'joa_fk_p__user_company_id',
	joa_fk_p.`user_custom_project_id` AS 'joa_fk_p__user_custom_project_id',
	joa_fk_p.`project_name` AS 'joa_fk_p__project_name',
	joa_fk_p.`project_owner_name` AS 'joa_fk_p__project_owner_name',
	joa_fk_p.`latitude` AS 'joa_fk_p__latitude',
	joa_fk_p.`longitude` AS 'joa_fk_p__longitude',
	joa_fk_p.`address_line_1` AS 'joa_fk_p__address_line_1',
	joa_fk_p.`address_line_2` AS 'joa_fk_p__address_line_2',
	joa_fk_p.`address_line_3` AS 'joa_fk_p__address_line_3',
	joa_fk_p.`address_line_4` AS 'joa_fk_p__address_line_4',
	joa_fk_p.`address_city` AS 'joa_fk_p__address_city',
	joa_fk_p.`address_county` AS 'joa_fk_p__address_county',
	joa_fk_p.`address_state_or_region` AS 'joa_fk_p__address_state_or_region',
	joa_fk_p.`address_postal_code` AS 'joa_fk_p__address_postal_code',
	joa_fk_p.`address_postal_code_extension` AS 'joa_fk_p__address_postal_code_extension',
	joa_fk_p.`address_country` AS 'joa_fk_p__address_country',
	joa_fk_p.`building_count` AS 'joa_fk_p__building_count',
	joa_fk_p.`unit_count` AS 'joa_fk_p__unit_count',
	joa_fk_p.`gross_square_footage` AS 'joa_fk_p__gross_square_footage',
	joa_fk_p.`net_rentable_square_footage` AS 'joa_fk_p__net_rentable_square_footage',
	joa_fk_p.`is_active_flag` AS 'joa_fk_p__is_active_flag',
	joa_fk_p.`public_plans_flag` AS 'joa_fk_p__public_plans_flag',
	joa_fk_p.`prevailing_wage_flag` AS 'joa_fk_p__prevailing_wage_flag',
	joa_fk_p.`city_business_license_required_flag` AS 'joa_fk_p__city_business_license_required_flag',
	joa_fk_p.`is_internal_flag` AS 'joa_fk_p__is_internal_flag',
	joa_fk_p.`project_contract_date` AS 'joa_fk_p__project_contract_date',
	joa_fk_p.`project_start_date` AS 'joa_fk_p__project_start_date',
	joa_fk_p.`project_completed_date` AS 'joa_fk_p__project_completed_date',
	joa_fk_p.`sort_order` AS 'joa_fk_p__sort_order',

	joa.*

FROM `jobsite_offsitework_activities` joa
	INNER JOIN `projects` joa_fk_p ON joa.`project_id` = joa_fk_p.`id`
WHERE joa.`id` = ?
";
		$arrValues = array($jobsite_offsitework_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_offsitework_activity_id = $row['id'];
			$jobsiteOffsiteworkActivity = self::instantiateOrm($database, 'JobsiteOffsiteworkActivity', $row, null, $jobsite_offsitework_activity_id);
			/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */
			$jobsiteOffsiteworkActivity->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['joa_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'joa_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$jobsiteOffsiteworkActivity->setProject($project);

			return $jobsiteOffsiteworkActivity;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_offsitework_activity` (`project_id`,`jobsite_offsitework_activity_label`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_offsitework_activity_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndJobsiteOffsiteworkActivityLabel($database, $project_id, $jobsite_offsitework_activity_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	joa.*

FROM `jobsite_offsitework_activities` joa
WHERE joa.`project_id` = ?
AND joa.`jobsite_offsitework_activity_label` = ?
";
		$arrValues = array($project_id, $jobsite_offsitework_activity_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_offsitework_activity_id = $row['id'];
			$jobsiteOffsiteworkActivity = self::instantiateOrm($database, 'JobsiteOffsiteworkActivity', $row, null, $jobsite_offsitework_activity_id);
			/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */
			return $jobsiteOffsiteworkActivity;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteOffsiteworkActivityIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivitiesByArrJobsiteOffsiteworkActivityIds($database, $arrJobsiteOffsiteworkActivityIds, Input $options=null)
	{
		if (empty($arrJobsiteOffsiteworkActivityIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY joa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivity = new JobsiteOffsiteworkActivity($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteOffsiteworkActivityIds as $k => $jobsite_offsitework_activity_id) {
			$jobsite_offsitework_activity_id = (int) $jobsite_offsitework_activity_id;
			$arrJobsiteOffsiteworkActivityIds[$k] = $db->escape($jobsite_offsitework_activity_id);
		}
		$csvJobsiteOffsiteworkActivityIds = join(',', $arrJobsiteOffsiteworkActivityIds);

		$query =
"
SELECT

	joa.*

FROM `jobsite_offsitework_activities` joa
WHERE joa.`id` IN ($csvJobsiteOffsiteworkActivityIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteOffsiteworkActivitiesByCsvJobsiteOffsiteworkActivityIds = array();
		while ($row = $db->fetch()) {
			$jobsite_offsitework_activity_id = $row['id'];
			$jobsiteOffsiteworkActivity = self::instantiateOrm($database, 'JobsiteOffsiteworkActivity', $row, null, $jobsite_offsitework_activity_id);
			/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */
			$jobsiteOffsiteworkActivity->convertPropertiesToData();

			$arrJobsiteOffsiteworkActivitiesByCsvJobsiteOffsiteworkActivityIds[$jobsite_offsitework_activity_id] = $jobsiteOffsiteworkActivity;
		}

		$db->free_result();

		return $arrJobsiteOffsiteworkActivitiesByCsvJobsiteOffsiteworkActivityIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_offsitework_activities_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivitiesByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrJobsiteOffsiteworkActivitiesByProjectId = null;
		}

		$arrJobsiteOffsiteworkActivitiesByProjectId = self::$_arrJobsiteOffsiteworkActivitiesByProjectId;
		if (isset($arrJobsiteOffsiteworkActivitiesByProjectId) && !empty($arrJobsiteOffsiteworkActivitiesByProjectId)) {
			return $arrJobsiteOffsiteworkActivitiesByProjectId;
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
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY joa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivity = new JobsiteOffsiteworkActivity($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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

	joa.*

FROM `jobsite_offsitework_activities` joa

	LEFT OUTER JOIN `jobsite_offsitework_activities_to_cost_codes` jsatcc ON joa.`id` = jsatcc.`jobsite_offsitework_activity_id`
	LEFT OUTER JOIN `cost_codes` codes ON jsatcc.`cost_code_id` = codes.`id`
	LEFT OUTER JOIN `cost_code_divisions` ccd ON codes.`cost_code_division_id` = ccd.`id`
WHERE joa.`project_id` = ?{$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeIds = array();
		$arrJobsiteOffsiteworkActivityIds = array();
		$arrJobsiteOffsiteworkActivitiesByProjectId = array();
		$arrJobsiteOffsiteworkActivitiesByProjectIdByCostCodeId = array();
		$arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel = array();
		$jobsiteOffsiteworkActivityLabelMaxLength = 0;
		while ($row = $db->fetch()) {
			$jobsite_offsitework_activity_id = $row['id'];
			$cost_code_id = $row['code__cost_code_id'];
			$cost_code_division_id = $row['ccd__cost_code_division_id'];
			$jobsite_offsitework_activity_label = $row['jobsite_offsitework_activity_label'];

			$jobsiteOffsiteworkActivity = self::instantiateOrm($database, 'JobsiteOffsiteworkActivity', $row, null, $jobsite_offsitework_activity_id);
			/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */
			$jobsiteOffsiteworkActivity->convertPropertiesToData();
			$arrJobsiteOffsiteworkActivitiesByProjectId[$jobsite_offsitework_activity_id] = $jobsiteOffsiteworkActivity;

			$jobsiteOffsiteworkActivityLabelLength = strlen($jobsite_offsitework_activity_label);
			if ($jobsiteOffsiteworkActivityLabelLength > $jobsiteOffsiteworkActivityLabelMaxLength) {
				$jobsiteOffsiteworkActivityLabelMaxLength = $jobsiteOffsiteworkActivityLabelLength;
			}
			$arrJobsiteOffsiteworkActivityIds[$jobsite_offsitework_activity_id] = $jobsiteOffsiteworkActivityLabelLength;

			$arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel[$jobsite_offsitework_activity_label][$jobsite_offsitework_activity_id] = $jobsiteOffsiteworkActivity;

			if (isset($cost_code_id) && !empty($cost_code_id)) {
				$arrCostCodeIds[$cost_code_id] = $cost_code_id;
			} else {
				$cost_code_id = 'null';
			}
			$arrJobsiteOffsiteworkActivitiesByProjectIdByCostCodeId[$cost_code_id][$jobsite_offsitework_activity_id] = $jobsiteOffsiteworkActivity;
		}

		$db->free_result();

		self::$_arrJobsiteOffsiteworkActivitiesByProjectId = $arrJobsiteOffsiteworkActivitiesByProjectId;

		if ($extendedReturn) {

			$arrReturn = array(
				'cost_code_ids' => $arrCostCodeIds,
				'jobsite_offsitework_activity_ids' => $arrJobsiteOffsiteworkActivityIds,
				'jobsite_offsitework_activities_by_cost_code_id' => $arrJobsiteOffsiteworkActivitiesByProjectIdByCostCodeId,
				'jobsite_offsitework_activities_by_project_id_by_jobsite_offsitework_activity_label' => $arrJobsiteOffsiteworkActivitiesByProjectIdByJobsiteOffsiteworkActivityLabel,
				'jobsite_offsitework_activities_by_project_id' => $arrJobsiteOffsiteworkActivitiesByProjectId,
				'jobsite_offsitework_activity_label_maxlength' => $jobsiteOffsiteworkActivityLabelMaxLength
			);

			return $arrReturn;

		} else {

			return $arrJobsiteOffsiteworkActivitiesByProjectId;

		}
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_offsitework_activities records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteOffsiteworkActivities($database, Input $options=null)
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
			self::$_arrAllJobsiteOffsiteworkActivities = null;
		}

		$arrAllJobsiteOffsiteworkActivities = self::$_arrAllJobsiteOffsiteworkActivities;
		if (isset($arrAllJobsiteOffsiteworkActivities) && !empty($arrAllJobsiteOffsiteworkActivities)) {
			return $arrAllJobsiteOffsiteworkActivities;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY joa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivity = new JobsiteOffsiteworkActivity($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivity->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joa.*

FROM `jobsite_offsitework_activities` joa{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteOffsiteworkActivities = array();
		while ($row = $db->fetch()) {
			$jobsite_offsitework_activity_id = $row['id'];
			$jobsiteOffsiteworkActivity = self::instantiateOrm($database, 'JobsiteOffsiteworkActivity', $row, null, $jobsite_offsitework_activity_id);
			/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */
			$arrAllJobsiteOffsiteworkActivities[$jobsite_offsitework_activity_id] = $jobsiteOffsiteworkActivity;
		}

		$db->free_result();

		self::$_arrAllJobsiteOffsiteworkActivities = $arrAllJobsiteOffsiteworkActivities;

		return $arrAllJobsiteOffsiteworkActivities;
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
INTO `jobsite_offsitework_activities`
(`project_id`, `jobsite_offsitework_activity_label`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->project_id, $this->jobsite_offsitework_activity_label, $this->sort_order, $this->disabled_flag, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_offsitework_activity_id = $db->insertId;
		$db->free_result();

		return $jobsite_offsitework_activity_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * JobsiteBuildingActivityToCostCode.
 *
 * @category   Framework
 * @package    JobsiteBuildingActivityToCostCode
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteBuildingActivityToCostCode extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteBuildingActivityToCostCode';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_building_activities_to_cost_codes';

	/**
	 * primary key (`jobsite_building_activity_id`,`cost_code_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'jobsite_building_activity_id' => 'int',
		'cost_code_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_building_activity_to_cost_code_via_primary_key' => array(
			'jobsite_building_activity_id' => 'int',
			'cost_code_id' => 'int'
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
		'jobsite_building_activity_id' => 'jobsite_building_activity_id',
		'cost_code_id' => 'cost_code_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_building_activity_id;
	public $cost_code_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId;
	protected static $_arrJobsiteBuildingActivitiesToCostCodesByCostCodeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteBuildingActivitiesToCostCodes;

	// Foreign Key Objects
	private $_jobsiteBuildingActivity;
	private $_costCode;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_building_activities_to_cost_codes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteBuildingActivity()
	{
		if (isset($this->_jobsiteBuildingActivity)) {
			return $this->_jobsiteBuildingActivity;
		} else {
			return null;
		}
	}

	public function setJobsiteBuildingActivity($jobsiteBuildingActivity)
	{
		$this->_jobsiteBuildingActivity = $jobsiteBuildingActivity;
	}

	public function getCostCode()
	{
		if (isset($this->_costCode)) {
			return $this->_costCode;
		} else {
			return null;
		}
	}

	public function setCostCode($costCode)
	{
		$this->_costCode = $costCode;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId()
	{
		if (isset(self::$_arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId)) {
			return self::$_arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId($arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId)
	{
		self::$_arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId = $arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId;
	}

	public static function getArrJobsiteBuildingActivitiesToCostCodesByCostCodeId()
	{
		if (isset(self::$_arrJobsiteBuildingActivitiesToCostCodesByCostCodeId)) {
			return self::$_arrJobsiteBuildingActivitiesToCostCodesByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteBuildingActivitiesToCostCodesByCostCodeId($arrJobsiteBuildingActivitiesToCostCodesByCostCodeId)
	{
		self::$_arrJobsiteBuildingActivitiesToCostCodesByCostCodeId = $arrJobsiteBuildingActivitiesToCostCodesByCostCodeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteBuildingActivitiesToCostCodes()
	{
		if (isset(self::$_arrAllJobsiteBuildingActivitiesToCostCodes)) {
			return self::$_arrAllJobsiteBuildingActivitiesToCostCodes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteBuildingActivitiesToCostCodes($arrAllJobsiteBuildingActivitiesToCostCodes)
	{
		self::$_arrAllJobsiteBuildingActivitiesToCostCodes = $arrAllJobsiteBuildingActivitiesToCostCodes;
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
	 * Find by primary key (`jobsite_building_activity_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteBuildingActivityIdAndCostCodeId($database, $jobsite_building_activity_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jba2codes.*

FROM `jobsite_building_activities_to_cost_codes` jba2codes
WHERE jba2codes.`jobsite_building_activity_id` = ?
AND jba2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_building_activity_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteBuildingActivityToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityToCostCode', $row);
			/* @var $jobsiteBuildingActivityToCostCode JobsiteBuildingActivityToCostCode */
			return $jobsiteBuildingActivityToCostCode;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`jobsite_building_activity_id`,`cost_code_id`) Extended.
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteBuildingActivityIdAndCostCodeIdExtended($database, $jobsite_building_activity_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jba2codes_fk_jba.`id` AS 'jba2codes_fk_jba__jobsite_building_activity_id',
	jba2codes_fk_jba.`project_id` AS 'jba2codes_fk_jba__project_id',
	jba2codes_fk_jba.`jobsite_building_activity_label` AS 'jba2codes_fk_jba__jobsite_building_activity_label',
	jba2codes_fk_jba.`sort_order` AS 'jba2codes_fk_jba__sort_order',
	jba2codes_fk_jba.`disabled_flag` AS 'jba2codes_fk_jba__disabled_flag',

	jba2codes_fk_codes.`id` AS 'jba2codes_fk_codes__cost_code_id',
	jba2codes_fk_codes.`cost_code_division_id` AS 'jba2codes_fk_codes__cost_code_division_id',
	jba2codes_fk_codes.`cost_code` AS 'jba2codes_fk_codes__cost_code',
	jba2codes_fk_codes.`cost_code_description` AS 'jba2codes_fk_codes__cost_code_description',
	jba2codes_fk_codes.`cost_code_description_abbreviation` AS 'jba2codes_fk_codes__cost_code_description_abbreviation',
	jba2codes_fk_codes.`sort_order` AS 'jba2codes_fk_codes__sort_order',
	jba2codes_fk_codes.`disabled_flag` AS 'jba2codes_fk_codes__disabled_flag',

	jba2codes.*

FROM `jobsite_building_activities_to_cost_codes` jba2codes
	INNER JOIN `jobsite_building_activities` jba2codes_fk_jba ON jba2codes.`jobsite_building_activity_id` = jba2codes_fk_jba.`id`
	INNER JOIN `cost_codes` jba2codes_fk_codes ON jba2codes.`cost_code_id` = jba2codes_fk_codes.`id`
WHERE jba2codes.`jobsite_building_activity_id` = ?
AND jba2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_building_activity_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteBuildingActivityToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityToCostCode', $row);
			/* @var $jobsiteBuildingActivityToCostCode JobsiteBuildingActivityToCostCode */
			$jobsiteBuildingActivityToCostCode->convertPropertiesToData();

			if (isset($row['jobsite_building_activity_id'])) {
				$jobsite_building_activity_id = $row['jobsite_building_activity_id'];
				$row['jba2codes_fk_jba__id'] = $jobsite_building_activity_id;
				$jobsiteBuildingActivity = self::instantiateOrm($database, 'JobsiteBuildingActivity', $row, null, $jobsite_building_activity_id, 'jba2codes_fk_jba__');
				/* @var $jobsiteBuildingActivity JobsiteBuildingActivity */
				$jobsiteBuildingActivity->convertPropertiesToData();
			} else {
				$jobsiteBuildingActivity = false;
			}
			$jobsiteBuildingActivityToCostCode->setJobsiteBuildingActivity($jobsiteBuildingActivity);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['jba2codes_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'jba2codes_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$jobsiteBuildingActivityToCostCode->setCostCode($costCode);

			return $jobsiteBuildingActivityToCostCode;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by a list of non auto int primary keys (array of primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteBuildingActivityIdAndCostCodeIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivitiesToCostCodesByArrJobsiteBuildingActivityIdAndCostCodeIdList($database, $arrJobsiteBuildingActivityIdAndCostCodeIdList, Input $options=null)
	{
		if (empty($arrJobsiteBuildingActivityIdAndCostCodeIdList)) {
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
		// ORDER BY `jobsite_building_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityToCostCode = new JobsiteBuildingActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$arrSqlWhere = array();
		foreach ($arrJobsiteBuildingActivityIdAndCostCodeIdList as $k => $arrTmp) {
			$tmpInnerAnd = '';
			$first = true;
			foreach ($arrTmp as $tmpPrimaryKeyAttribute => $tmpPrimaryKeyValue) {
				$tmpPrimaryKeyAttributeEscaped = $db->escape($tmpPrimaryKeyAttribute);
				$tmpPrimaryKeyValueEscaped = $db->escape($tmpPrimaryKeyValue);
				if ($first) {
					$first = false;
					$tmpInnerAnd = "`$tmpPrimaryKeyAttribute` = '$tmpPrimaryKeyValueEscaped'";
				} else {
					$tmpInnerAnd .= " AND `$tmpPrimaryKeyAttribute` = '$tmpPrimaryKeyValueEscaped'";
				}
			}
			$tmpInnerAnd = "($tmpInnerAnd)";
			$arrSqlWhere[] = $tmpInnerAnd;
		}
		if (count($arrJobsiteBuildingActivityIdAndCostCodeIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	jba2codes.*

FROM `jobsite_building_activities_to_cost_codes` jba2codes
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteBuildingActivitiesToCostCodesByArrJobsiteBuildingActivityIdAndCostCodeIdList = array();
		while ($row = $db->fetch()) {
			$jobsiteBuildingActivityToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityToCostCode', $row);
			/* @var $jobsiteBuildingActivityToCostCode JobsiteBuildingActivityToCostCode */
			$arrJobsiteBuildingActivitiesToCostCodesByArrJobsiteBuildingActivityIdAndCostCodeIdList[] = $jobsiteBuildingActivityToCostCode;
		}

		$db->free_result();

		return $arrJobsiteBuildingActivitiesToCostCodesByArrJobsiteBuildingActivityIdAndCostCodeIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_building_activities_to_cost_codes_fk_jba` foreign key (`jobsite_building_activity_id`) references `jobsite_building_activities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId($database, $jobsite_building_activity_id, Input $options=null)
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
			self::$_arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId = null;
		}

		$arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId = self::$_arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId;
		if (isset($arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId) && !empty($arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId)) {
			return $arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId;
		}

		$jobsite_building_activity_id = (int) $jobsite_building_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_building_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityToCostCode = new JobsiteBuildingActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jba2codes.*

FROM `jobsite_building_activities_to_cost_codes` jba2codes
WHERE jba2codes.`jobsite_building_activity_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_building_activity_id` ASC, `cost_code_id` ASC
		$arrValues = array($jobsite_building_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId = array();
		while ($row = $db->fetch()) {
			$jobsiteBuildingActivityToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityToCostCode', $row);
			/* @var $jobsiteBuildingActivityToCostCode JobsiteBuildingActivityToCostCode */

			$cost_code_id = $jobsiteBuildingActivityToCostCode->cost_code_id;
			$arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId[$jobsite_building_activity_id][$cost_code_id] = $jobsiteBuildingActivityToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId = $arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId;

		return $arrJobsiteBuildingActivitiesToCostCodesByJobsiteBuildingActivityId;
	}

	/**
	 * Load by constraint `jobsite_building_activities_to_cost_codes_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivitiesToCostCodesByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrJobsiteBuildingActivitiesToCostCodesByCostCodeId = null;
		}

		$arrJobsiteBuildingActivitiesToCostCodesByCostCodeId = self::$_arrJobsiteBuildingActivitiesToCostCodesByCostCodeId;
		if (isset($arrJobsiteBuildingActivitiesToCostCodesByCostCodeId) && !empty($arrJobsiteBuildingActivitiesToCostCodesByCostCodeId)) {
			return $arrJobsiteBuildingActivitiesToCostCodesByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_building_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityToCostCode = new JobsiteBuildingActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jba2codes.*

FROM `jobsite_building_activities_to_cost_codes` jba2codes
WHERE jba2codes.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_building_activity_id` ASC, `cost_code_id` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteBuildingActivitiesToCostCodesByCostCodeId = array();
		while ($row = $db->fetch()) {
			$jobsiteBuildingActivityToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityToCostCode', $row);
			/* @var $jobsiteBuildingActivityToCostCode JobsiteBuildingActivityToCostCode */
			$arrJobsiteBuildingActivitiesToCostCodesByCostCodeId[] = $jobsiteBuildingActivityToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteBuildingActivitiesToCostCodesByCostCodeId = $arrJobsiteBuildingActivitiesToCostCodesByCostCodeId;

		return $arrJobsiteBuildingActivitiesToCostCodesByCostCodeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_building_activities_to_cost_codes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteBuildingActivitiesToCostCodes($database, Input $options=null)
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
			self::$_arrAllJobsiteBuildingActivitiesToCostCodes = null;
		}

		$arrAllJobsiteBuildingActivitiesToCostCodes = self::$_arrAllJobsiteBuildingActivitiesToCostCodes;
		if (isset($arrAllJobsiteBuildingActivitiesToCostCodes) && !empty($arrAllJobsiteBuildingActivitiesToCostCodes)) {
			return $arrAllJobsiteBuildingActivitiesToCostCodes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_building_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityToCostCode = new JobsiteBuildingActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jba2codes.*

FROM `jobsite_building_activities_to_cost_codes` jba2codes{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_building_activity_id` ASC, `cost_code_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteBuildingActivitiesToCostCodes = array();
		while ($row = $db->fetch()) {
			$jobsiteBuildingActivityToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityToCostCode', $row);
			/* @var $jobsiteBuildingActivityToCostCode JobsiteBuildingActivityToCostCode */
			$arrAllJobsiteBuildingActivitiesToCostCodes[] = $jobsiteBuildingActivityToCostCode;
		}

		$db->free_result();

		self::$_arrAllJobsiteBuildingActivitiesToCostCodes = $arrAllJobsiteBuildingActivitiesToCostCodes;

		return $arrAllJobsiteBuildingActivitiesToCostCodes;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
	public function insertIgnore()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT IGNORE
INTO `jobsite_building_activities_to_cost_codes`
(`jobsite_building_activity_id`, `cost_code_id`)
VALUES (?, ?)
";
		$arrValues = array($this->jobsite_building_activity_id, $this->cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

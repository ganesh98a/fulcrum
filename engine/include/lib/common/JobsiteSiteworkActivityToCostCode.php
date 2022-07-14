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
 * JobsiteSiteworkActivityToCostCode.
 *
 * @category   Framework
 * @package    JobsiteSiteworkActivityToCostCode
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteSiteworkActivityToCostCode extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteSiteworkActivityToCostCode';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_sitework_activities_to_cost_codes';

	/**
	 * primary key (`jobsite_sitework_activity_id`,`cost_code_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'jobsite_sitework_activity_id' => 'int',
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
		'unique_jobsite_sitework_activity_to_cost_code_via_primary_key' => array(
			'jobsite_sitework_activity_id' => 'int',
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
		'jobsite_sitework_activity_id' => 'jobsite_sitework_activity_id',
		'cost_code_id' => 'cost_code_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_sitework_activity_id;
	public $cost_code_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId;
	protected static $_arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteSiteworkActivitiesToCostCodes;

	// Foreign Key Objects
	private $_jobsiteSiteworkActivity;
	private $_costCode;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_sitework_activities_to_cost_codes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteSiteworkActivity()
	{
		if (isset($this->_jobsiteSiteworkActivity)) {
			return $this->_jobsiteSiteworkActivity;
		} else {
			return null;
		}
	}

	public function setJobsiteSiteworkActivity($jobsiteSiteworkActivity)
	{
		$this->_jobsiteSiteworkActivity = $jobsiteSiteworkActivity;
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
	public static function getArrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId()
	{
		if (isset(self::$_arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId)) {
			return self::$_arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId($arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId)
	{
		self::$_arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId = $arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId;
	}

	public static function getArrJobsiteSiteworkActivitiesToCostCodesByCostCodeId()
	{
		if (isset(self::$_arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId)) {
			return self::$_arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSiteworkActivitiesToCostCodesByCostCodeId($arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId)
	{
		self::$_arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId = $arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteSiteworkActivitiesToCostCodes()
	{
		if (isset(self::$_arrAllJobsiteSiteworkActivitiesToCostCodes)) {
			return self::$_arrAllJobsiteSiteworkActivitiesToCostCodes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteSiteworkActivitiesToCostCodes($arrAllJobsiteSiteworkActivitiesToCostCodes)
	{
		self::$_arrAllJobsiteSiteworkActivitiesToCostCodes = $arrAllJobsiteSiteworkActivitiesToCostCodes;
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
	 * Find by primary key (`jobsite_sitework_activity_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteSiteworkActivityIdAndCostCodeId($database, $jobsite_sitework_activity_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jsa2codes.*

FROM `jobsite_sitework_activities_to_cost_codes` jsa2codes
WHERE jsa2codes.`jobsite_sitework_activity_id` = ?
AND jsa2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_sitework_activity_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteSiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityToCostCode', $row);
			/* @var $jobsiteSiteworkActivityToCostCode JobsiteSiteworkActivityToCostCode */
			return $jobsiteSiteworkActivityToCostCode;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`jobsite_sitework_activity_id`,`cost_code_id`) Extended.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteSiteworkActivityIdAndCostCodeIdExtended($database, $jobsite_sitework_activity_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jsa2codes_fk_jsa.`id` AS 'jsa2codes_fk_jsa__jobsite_sitework_activity_id',
	jsa2codes_fk_jsa.`project_id` AS 'jsa2codes_fk_jsa__project_id',
	jsa2codes_fk_jsa.`jobsite_sitework_activity_label` AS 'jsa2codes_fk_jsa__jobsite_sitework_activity_label',
	jsa2codes_fk_jsa.`sort_order` AS 'jsa2codes_fk_jsa__sort_order',
	jsa2codes_fk_jsa.`disabled_flag` AS 'jsa2codes_fk_jsa__disabled_flag',

	jsa2codes_fk_codes.`id` AS 'jsa2codes_fk_codes__cost_code_id',
	jsa2codes_fk_codes.`cost_code_division_id` AS 'jsa2codes_fk_codes__cost_code_division_id',
	jsa2codes_fk_codes.`cost_code` AS 'jsa2codes_fk_codes__cost_code',
	jsa2codes_fk_codes.`cost_code_description` AS 'jsa2codes_fk_codes__cost_code_description',
	jsa2codes_fk_codes.`cost_code_description_abbreviation` AS 'jsa2codes_fk_codes__cost_code_description_abbreviation',
	jsa2codes_fk_codes.`sort_order` AS 'jsa2codes_fk_codes__sort_order',
	jsa2codes_fk_codes.`disabled_flag` AS 'jsa2codes_fk_codes__disabled_flag',

	jsa2codes.*

FROM `jobsite_sitework_activities_to_cost_codes` jsa2codes
	INNER JOIN `jobsite_sitework_activities` jsa2codes_fk_jsa ON jsa2codes.`jobsite_sitework_activity_id` = jsa2codes_fk_jsa.`id`
	INNER JOIN `cost_codes` jsa2codes_fk_codes ON jsa2codes.`cost_code_id` = jsa2codes_fk_codes.`id`
WHERE jsa2codes.`jobsite_sitework_activity_id` = ?
AND jsa2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_sitework_activity_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteSiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityToCostCode', $row);
			/* @var $jobsiteSiteworkActivityToCostCode JobsiteSiteworkActivityToCostCode */
			$jobsiteSiteworkActivityToCostCode->convertPropertiesToData();

			if (isset($row['jobsite_sitework_activity_id'])) {
				$jobsite_sitework_activity_id = $row['jobsite_sitework_activity_id'];
				$row['jsa2codes_fk_jsa__id'] = $jobsite_sitework_activity_id;
				$jobsiteSiteworkActivity = self::instantiateOrm($database, 'JobsiteSiteworkActivity', $row, null, $jobsite_sitework_activity_id, 'jsa2codes_fk_jsa__');
				/* @var $jobsiteSiteworkActivity JobsiteSiteworkActivity */
				$jobsiteSiteworkActivity->convertPropertiesToData();
			} else {
				$jobsiteSiteworkActivity = false;
			}
			$jobsiteSiteworkActivityToCostCode->setJobsiteSiteworkActivity($jobsiteSiteworkActivity);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['jsa2codes_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'jsa2codes_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$jobsiteSiteworkActivityToCostCode->setCostCode($costCode);

			return $jobsiteSiteworkActivityToCostCode;
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
	 * @param array $arrJobsiteSiteworkActivityIdAndCostCodeIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivitiesToCostCodesByArrJobsiteSiteworkActivityIdAndCostCodeIdList($database, $arrJobsiteSiteworkActivityIdAndCostCodeIdList, Input $options=null)
	{
		if (empty($arrJobsiteSiteworkActivityIdAndCostCodeIdList)) {
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
		// ORDER BY `jobsite_sitework_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityToCostCode = new JobsiteSiteworkActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrJobsiteSiteworkActivityIdAndCostCodeIdList as $k => $arrTmp) {
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
		if (count($arrJobsiteSiteworkActivityIdAndCostCodeIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	jsa2codes.*

FROM `jobsite_sitework_activities_to_cost_codes` jsa2codes
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkActivitiesToCostCodesByArrJobsiteSiteworkActivityIdAndCostCodeIdList = array();
		while ($row = $db->fetch()) {
			$jobsiteSiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityToCostCode', $row);
			/* @var $jobsiteSiteworkActivityToCostCode JobsiteSiteworkActivityToCostCode */
			$arrJobsiteSiteworkActivitiesToCostCodesByArrJobsiteSiteworkActivityIdAndCostCodeIdList[] = $jobsiteSiteworkActivityToCostCode;
		}

		$db->free_result();

		return $arrJobsiteSiteworkActivitiesToCostCodesByArrJobsiteSiteworkActivityIdAndCostCodeIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_sitework_activities_to_cost_codes_fk_jsa` foreign key (`jobsite_sitework_activity_id`) references `jobsite_sitework_activities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId($database, $jobsite_sitework_activity_id, Input $options=null)
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
			self::$_arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId = null;
		}

		$arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId = self::$_arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId;
		if (isset($arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId) && !empty($arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId)) {
			return $arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId;
		}

		$jobsite_sitework_activity_id = (int) $jobsite_sitework_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_sitework_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityToCostCode = new JobsiteSiteworkActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsa2codes.*

FROM `jobsite_sitework_activities_to_cost_codes` jsa2codes
WHERE jsa2codes.`jobsite_sitework_activity_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_sitework_activity_id` ASC, `cost_code_id` ASC
		$arrValues = array($jobsite_sitework_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId = array();
		$arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId[$jobsite_sitework_activity_id] = array();
		while ($row = $db->fetch()) {
			$jobsiteSiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityToCostCode', $row);
			/* @var $jobsiteSiteworkActivityToCostCode JobsiteSiteworkActivityToCostCode */

			$cost_code_id = $jobsiteSiteworkActivityToCostCode->cost_code_id;
			$arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId[$jobsite_sitework_activity_id][$cost_code_id] = $jobsiteSiteworkActivityToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId = $arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId;

		return $arrJobsiteSiteworkActivitiesToCostCodesByJobsiteSiteworkActivityId;
	}

	/**
	 * Load by constraint `jobsite_sitework_activities_to_cost_codes_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivitiesToCostCodesByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId = null;
		}

		$arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId = self::$_arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId;
		if (isset($arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId) && !empty($arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId)) {
			return $arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_sitework_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityToCostCode = new JobsiteSiteworkActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsa2codes.*

FROM `jobsite_sitework_activities_to_cost_codes` jsa2codes
WHERE jsa2codes.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_sitework_activity_id` ASC, `cost_code_id` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId = array();
		while ($row = $db->fetch()) {
			$jobsiteSiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityToCostCode', $row);
			/* @var $jobsiteSiteworkActivityToCostCode JobsiteSiteworkActivityToCostCode */
			$arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId[] = $jobsiteSiteworkActivityToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId = $arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId;

		return $arrJobsiteSiteworkActivitiesToCostCodesByCostCodeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_sitework_activities_to_cost_codes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteSiteworkActivitiesToCostCodes($database, Input $options=null)
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
			self::$_arrAllJobsiteSiteworkActivitiesToCostCodes = null;
		}

		$arrAllJobsiteSiteworkActivitiesToCostCodes = self::$_arrAllJobsiteSiteworkActivitiesToCostCodes;
		if (isset($arrAllJobsiteSiteworkActivitiesToCostCodes) && !empty($arrAllJobsiteSiteworkActivitiesToCostCodes)) {
			return $arrAllJobsiteSiteworkActivitiesToCostCodes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_sitework_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityToCostCode = new JobsiteSiteworkActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsa2codes.*

FROM `jobsite_sitework_activities_to_cost_codes` jsa2codes{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_sitework_activity_id` ASC, `cost_code_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteSiteworkActivitiesToCostCodes = array();
		while ($row = $db->fetch()) {
			$jobsiteSiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityToCostCode', $row);
			/* @var $jobsiteSiteworkActivityToCostCode JobsiteSiteworkActivityToCostCode */
			$arrAllJobsiteSiteworkActivitiesToCostCodes[] = $jobsiteSiteworkActivityToCostCode;
		}

		$db->free_result();

		self::$_arrAllJobsiteSiteworkActivitiesToCostCodes = $arrAllJobsiteSiteworkActivitiesToCostCodes;

		return $arrAllJobsiteSiteworkActivitiesToCostCodes;
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
INTO `jobsite_sitework_activities_to_cost_codes`
(`jobsite_sitework_activity_id`, `cost_code_id`)
VALUES (?, ?)
";
		$arrValues = array($this->jobsite_sitework_activity_id, $this->cost_code_id);
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

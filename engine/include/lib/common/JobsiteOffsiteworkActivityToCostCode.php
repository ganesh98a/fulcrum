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
 * JobsiteOffsiteworkActivityToCostCode.
 *
 * @category   Framework
 * @package    JobsiteOffsiteworkActivityToCostCode
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteOffsiteworkActivityToCostCode extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteOffsiteworkActivityToCostCode';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_offsitework_activities_to_cost_codes';

	/**
	 * primary key (`jobsite_offsitework_activity_id`,`cost_code_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'jobsite_offsitework_activity_id' => 'int',
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
		'unique_jobsite_offsitework_activity_to_cost_code_via_primary_key' => array(
			'jobsite_offsitework_activity_id' => 'int',
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
		'jobsite_offsitework_activity_id' => 'jobsite_offsitework_activity_id',
		'cost_code_id' => 'cost_code_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_offsitework_activity_id;
	public $cost_code_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId;
	protected static $_arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteOffsiteworkActivitiesToCostCodes;

	// Foreign Key Objects
	private $_jobsiteOffsiteworkActivity;
	private $_costCode;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_offsitework_activities_to_cost_codes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteOffsiteworkActivity()
	{
		if (isset($this->_jobsiteOffsiteworkActivity)) {
			return $this->_jobsiteOffsiteworkActivity;
		} else {
			return null;
		}
	}

	public function setJobsiteOffsiteworkActivity($jobsiteOffsiteworkActivity)
	{
		$this->_jobsiteOffsiteworkActivity = $jobsiteOffsiteworkActivity;
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
	public static function getArrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId()
	{
		if (isset(self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId)) {
			return self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId($arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId)
	{
		self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId = $arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId;
	}

	public static function getArrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId()
	{
		if (isset(self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId)) {
			return self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId($arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId)
	{
		self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId = $arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteOffsiteworkActivitiesToCostCodes()
	{
		if (isset(self::$_arrAllJobsiteOffsiteworkActivitiesToCostCodes)) {
			return self::$_arrAllJobsiteOffsiteworkActivitiesToCostCodes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteOffsiteworkActivitiesToCostCodes($arrAllJobsiteOffsiteworkActivitiesToCostCodes)
	{
		self::$_arrAllJobsiteOffsiteworkActivitiesToCostCodes = $arrAllJobsiteOffsiteworkActivitiesToCostCodes;
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
	 * Find by primary key (`jobsite_offsitework_activity_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteOffsiteworkActivityIdAndCostCodeId($database, $jobsite_offsitework_activity_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	joa2codes.*

FROM `jobsite_offsitework_activities_to_cost_codes` joa2codes
WHERE joa2codes.`jobsite_offsitework_activity_id` = ?
AND joa2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_offsitework_activity_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteOffsiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityToCostCode JobsiteOffsiteworkActivityToCostCode */
			return $jobsiteOffsiteworkActivityToCostCode;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`jobsite_offsitework_activity_id`,`cost_code_id`) Extended.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteOffsiteworkActivityIdAndCostCodeIdExtended($database, $jobsite_offsitework_activity_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	joa2codes_fk_joa.`id` AS 'joa2codes_fk_joa__jobsite_offsitework_activity_id',
	joa2codes_fk_joa.`project_id` AS 'joa2codes_fk_joa__project_id',
	joa2codes_fk_joa.`jobsite_offsitework_activity_label` AS 'joa2codes_fk_joa__jobsite_offsitework_activity_label',
	joa2codes_fk_joa.`sort_order` AS 'joa2codes_fk_joa__sort_order',
	joa2codes_fk_joa.`disabled_flag` AS 'joa2codes_fk_joa__disabled_flag',

	joa2codes_fk_codes.`id` AS 'joa2codes_fk_codes__cost_code_id',
	joa2codes_fk_codes.`cost_code_division_id` AS 'joa2codes_fk_codes__cost_code_division_id',
	joa2codes_fk_codes.`cost_code` AS 'joa2codes_fk_codes__cost_code',
	joa2codes_fk_codes.`cost_code_description` AS 'joa2codes_fk_codes__cost_code_description',
	joa2codes_fk_codes.`cost_code_description_abbreviation` AS 'joa2codes_fk_codes__cost_code_description_abbreviation',
	joa2codes_fk_codes.`sort_order` AS 'joa2codes_fk_codes__sort_order',
	joa2codes_fk_codes.`disabled_flag` AS 'joa2codes_fk_codes__disabled_flag',

	joa2codes.*

FROM `jobsite_offsitework_activities_to_cost_codes` joa2codes
	INNER JOIN `jobsite_offsitework_activities` joa2codes_fk_joa ON joa2codes.`jobsite_offsitework_activity_id` = joa2codes_fk_joa.`id`
	INNER JOIN `cost_codes` joa2codes_fk_codes ON joa2codes.`cost_code_id` = joa2codes_fk_codes.`id`
WHERE joa2codes.`jobsite_offsitework_activity_id` = ?
AND joa2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_offsitework_activity_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteOffsiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityToCostCode JobsiteOffsiteworkActivityToCostCode */
			$jobsiteOffsiteworkActivityToCostCode->convertPropertiesToData();

			if (isset($row['jobsite_offsitework_activity_id'])) {
				$jobsite_offsitework_activity_id = $row['jobsite_offsitework_activity_id'];
				$row['joa2codes_fk_joa__id'] = $jobsite_offsitework_activity_id;
				$jobsiteOffsiteworkActivity = self::instantiateOrm($database, 'JobsiteOffsiteworkActivity', $row, null, $jobsite_offsitework_activity_id, 'joa2codes_fk_joa__');
				/* @var $jobsiteOffsiteworkActivity JobsiteOffsiteworkActivity */
				$jobsiteOffsiteworkActivity->convertPropertiesToData();
			} else {
				$jobsiteOffsiteworkActivity = false;
			}
			$jobsiteOffsiteworkActivityToCostCode->setJobsiteOffsiteworkActivity($jobsiteOffsiteworkActivity);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['joa2codes_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'joa2codes_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$jobsiteOffsiteworkActivityToCostCode->setCostCode($costCode);

			return $jobsiteOffsiteworkActivityToCostCode;
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
	 * @param array $arrJobsiteOffsiteworkActivityIdAndCostCodeIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivitiesToCostCodesByArrJobsiteOffsiteworkActivityIdAndCostCodeIdList($database, $arrJobsiteOffsiteworkActivityIdAndCostCodeIdList, Input $options=null)
	{
		if (empty($arrJobsiteOffsiteworkActivityIdAndCostCodeIdList)) {
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
		// ORDER BY `jobsite_offsitework_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityToCostCode = new JobsiteOffsiteworkActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrJobsiteOffsiteworkActivityIdAndCostCodeIdList as $k => $arrTmp) {
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
		if (count($arrJobsiteOffsiteworkActivityIdAndCostCodeIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	joa2codes.*

FROM `jobsite_offsitework_activities_to_cost_codes` joa2codes
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkActivitiesToCostCodesByArrJobsiteOffsiteworkActivityIdAndCostCodeIdList = array();
		while ($row = $db->fetch()) {
			$jobsiteOffsiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityToCostCode JobsiteOffsiteworkActivityToCostCode */
			$arrJobsiteOffsiteworkActivitiesToCostCodesByArrJobsiteOffsiteworkActivityIdAndCostCodeIdList[] = $jobsiteOffsiteworkActivityToCostCode;
		}

		$db->free_result();

		return $arrJobsiteOffsiteworkActivitiesToCostCodesByArrJobsiteOffsiteworkActivityIdAndCostCodeIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_offsitework_activities_to_cost_codes_fk_joa` foreign key (`jobsite_offsitework_activity_id`) references `jobsite_offsitework_activities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId($database, $jobsite_offsitework_activity_id, Input $options=null)
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
			self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId = null;
		}

		$arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId = self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId;
		if (isset($arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId) && !empty($arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId)) {
			return $arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId;
		}

		$jobsite_offsitework_activity_id = (int) $jobsite_offsitework_activity_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_offsitework_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityToCostCode = new JobsiteOffsiteworkActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joa2codes.*

FROM `jobsite_offsitework_activities_to_cost_codes` joa2codes
WHERE joa2codes.`jobsite_offsitework_activity_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_offsitework_activity_id` ASC, `cost_code_id` ASC
		$arrValues = array($jobsite_offsitework_activity_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId = array();
		$arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId[$jobsite_offsitework_activity_id] = array();
		while ($row = $db->fetch()) {
			$jobsiteOffsiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityToCostCode JobsiteOffsiteworkActivityToCostCode */

			$cost_code_id = $jobsiteOffsiteworkActivityToCostCode->cost_code_id;
			$arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId[$jobsite_offsitework_activity_id][$cost_code_id] = $jobsiteOffsiteworkActivityToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId = $arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId;

		return $arrJobsiteOffsiteworkActivitiesToCostCodesByJobsiteOffsiteworkActivityId;
	}

	/**
	 * Load by constraint `jobsite_offsitework_activities_to_cost_codes_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId = null;
		}

		$arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId = self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId;
		if (isset($arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId) && !empty($arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId)) {
			return $arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_offsitework_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityToCostCode = new JobsiteOffsiteworkActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joa2codes.*

FROM `jobsite_offsitework_activities_to_cost_codes` joa2codes
WHERE joa2codes.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_offsitework_activity_id` ASC, `cost_code_id` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId = array();
		while ($row = $db->fetch()) {
			$jobsiteOffsiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityToCostCode JobsiteOffsiteworkActivityToCostCode */
			$arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId[] = $jobsiteOffsiteworkActivityToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId = $arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId;

		return $arrJobsiteOffsiteworkActivitiesToCostCodesByCostCodeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_offsitework_activities_to_cost_codes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteOffsiteworkActivitiesToCostCodes($database, Input $options=null)
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
			self::$_arrAllJobsiteOffsiteworkActivitiesToCostCodes = null;
		}

		$arrAllJobsiteOffsiteworkActivitiesToCostCodes = self::$_arrAllJobsiteOffsiteworkActivitiesToCostCodes;
		if (isset($arrAllJobsiteOffsiteworkActivitiesToCostCodes) && !empty($arrAllJobsiteOffsiteworkActivitiesToCostCodes)) {
			return $arrAllJobsiteOffsiteworkActivitiesToCostCodes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_offsitework_activity_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityToCostCode = new JobsiteOffsiteworkActivityToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joa2codes.*

FROM `jobsite_offsitework_activities_to_cost_codes` joa2codes{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_offsitework_activity_id` ASC, `cost_code_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteOffsiteworkActivitiesToCostCodes = array();
		while ($row = $db->fetch()) {
			$jobsiteOffsiteworkActivityToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityToCostCode JobsiteOffsiteworkActivityToCostCode */
			$arrAllJobsiteOffsiteworkActivitiesToCostCodes[] = $jobsiteOffsiteworkActivityToCostCode;
		}

		$db->free_result();

		self::$_arrAllJobsiteOffsiteworkActivitiesToCostCodes = $arrAllJobsiteOffsiteworkActivitiesToCostCodes;

		return $arrAllJobsiteOffsiteworkActivitiesToCostCodes;
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
INTO `jobsite_offsitework_activities_to_cost_codes`
(`jobsite_offsitework_activity_id`, `cost_code_id`)
VALUES (?, ?)
";
		$arrValues = array($this->jobsite_offsitework_activity_id, $this->cost_code_id);
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

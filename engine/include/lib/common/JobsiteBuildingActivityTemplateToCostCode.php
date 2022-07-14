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
 * JobsiteBuildingActivityTemplateToCostCode.
 *
 * @category   Framework
 * @package    JobsiteBuildingActivityTemplateToCostCode
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteBuildingActivityTemplateToCostCode extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteBuildingActivityTemplateToCostCode';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_building_activity_templates_to_cost_codes';

	/**
	 * primary key (`jobsite_building_activity_template_id`,`cost_code_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'jobsite_building_activity_template_id' => 'int',
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
		'unique_jobsite_building_activity_template_to_cost_code_via_primary_key' => array(
			'jobsite_building_activity_template_id' => 'int',
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
		'jobsite_building_activity_template_id' => 'jobsite_building_activity_template_id',
		'cost_code_id' => 'cost_code_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_building_activity_template_id;
	public $cost_code_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId;
	protected static $_arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteBuildingActivityTemplatesToCostCodes;

	// Foreign Key Objects
	private $_jobsiteBuildingActivityTemplate;
	private $_costCode;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_building_activity_templates_to_cost_codes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteBuildingActivityTemplate()
	{
		if (isset($this->_jobsiteBuildingActivityTemplate)) {
			return $this->_jobsiteBuildingActivityTemplate;
		} else {
			return null;
		}
	}

	public function setJobsiteBuildingActivityTemplate($jobsiteBuildingActivityTemplate)
	{
		$this->_jobsiteBuildingActivityTemplate = $jobsiteBuildingActivityTemplate;
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
	public static function getArrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId()
	{
		if (isset(self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId)) {
			return self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId($arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId)
	{
		self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId = $arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId;
	}

	public static function getArrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId()
	{
		if (isset(self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId)) {
			return self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId($arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId)
	{
		self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId = $arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteBuildingActivityTemplatesToCostCodes()
	{
		if (isset(self::$_arrAllJobsiteBuildingActivityTemplatesToCostCodes)) {
			return self::$_arrAllJobsiteBuildingActivityTemplatesToCostCodes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteBuildingActivityTemplatesToCostCodes($arrAllJobsiteBuildingActivityTemplatesToCostCodes)
	{
		self::$_arrAllJobsiteBuildingActivityTemplatesToCostCodes = $arrAllJobsiteBuildingActivityTemplatesToCostCodes;
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
	 * Find by primary key (`jobsite_building_activity_template_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_template_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteBuildingActivityTemplateIdAndCostCodeId($database, $jobsite_building_activity_template_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jbat2codes.*

FROM `jobsite_building_activity_templates_to_cost_codes` jbat2codes
WHERE jbat2codes.`jobsite_building_activity_template_id` = ?
AND jbat2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_building_activity_template_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteBuildingActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplateToCostCode', $row);
			/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */
			return $jobsiteBuildingActivityTemplateToCostCode;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`jobsite_building_activity_template_id`,`cost_code_id`) Extended.
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_template_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteBuildingActivityTemplateIdAndCostCodeIdExtended($database, $jobsite_building_activity_template_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jbat2codes_fk_jbat.`id` AS 'jbat2codes_fk_jbat__jobsite_building_activity_template_id',
	jbat2codes_fk_jbat.`jobsite_activity_list_template_id` AS 'jbat2codes_fk_jbat__jobsite_activity_list_template_id',
	jbat2codes_fk_jbat.`jobsite_building_activity_label` AS 'jbat2codes_fk_jbat__jobsite_building_activity_label',
	jbat2codes_fk_jbat.`sort_order` AS 'jbat2codes_fk_jbat__sort_order',
	jbat2codes_fk_jbat.`disabled_flag` AS 'jbat2codes_fk_jbat__disabled_flag',

	jbat2codes_fk_codes.`id` AS 'jbat2codes_fk_codes__cost_code_id',
	jbat2codes_fk_codes.`cost_code_division_id` AS 'jbat2codes_fk_codes__cost_code_division_id',
	jbat2codes_fk_codes.`cost_code` AS 'jbat2codes_fk_codes__cost_code',
	jbat2codes_fk_codes.`cost_code_description` AS 'jbat2codes_fk_codes__cost_code_description',
	jbat2codes_fk_codes.`cost_code_description_abbreviation` AS 'jbat2codes_fk_codes__cost_code_description_abbreviation',
	jbat2codes_fk_codes.`sort_order` AS 'jbat2codes_fk_codes__sort_order',
	jbat2codes_fk_codes.`disabled_flag` AS 'jbat2codes_fk_codes__disabled_flag',

	jbat2codes.*

FROM `jobsite_building_activity_templates_to_cost_codes` jbat2codes
	INNER JOIN `jobsite_building_activity_templates` jbat2codes_fk_jbat ON jbat2codes.`jobsite_building_activity_template_id` = jbat2codes_fk_jbat.`id`
	INNER JOIN `cost_codes` jbat2codes_fk_codes ON jbat2codes.`cost_code_id` = jbat2codes_fk_codes.`id`
WHERE jbat2codes.`jobsite_building_activity_template_id` = ?
AND jbat2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_building_activity_template_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteBuildingActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplateToCostCode', $row);
			/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */
			$jobsiteBuildingActivityTemplateToCostCode->convertPropertiesToData();

			if (isset($row['jobsite_building_activity_template_id'])) {
				$jobsite_building_activity_template_id = $row['jobsite_building_activity_template_id'];
				$row['jbat2codes_fk_jbat__id'] = $jobsite_building_activity_template_id;
				$jobsiteBuildingActivityTemplate = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplate', $row, null, $jobsite_building_activity_template_id, 'jbat2codes_fk_jbat__');
				/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */
				$jobsiteBuildingActivityTemplate->convertPropertiesToData();
			} else {
				$jobsiteBuildingActivityTemplate = false;
			}
			$jobsiteBuildingActivityTemplateToCostCode->setJobsiteBuildingActivityTemplate($jobsiteBuildingActivityTemplate);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['jbat2codes_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'jbat2codes_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$jobsiteBuildingActivityTemplateToCostCode->setCostCode($costCode);

			return $jobsiteBuildingActivityTemplateToCostCode;
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
	 * @param array $arrJobsiteBuildingActivityTemplateIdAndCostCodeIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivityTemplatesToCostCodesByArrJobsiteBuildingActivityTemplateIdAndCostCodeIdList($database, $arrJobsiteBuildingActivityTemplateIdAndCostCodeIdList, Input $options=null)
	{
		if (empty($arrJobsiteBuildingActivityTemplateIdAndCostCodeIdList)) {
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
		// ORDER BY `jobsite_building_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityTemplateToCostCode = new JobsiteBuildingActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrJobsiteBuildingActivityTemplateIdAndCostCodeIdList as $k => $arrTmp) {
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
		if (count($arrJobsiteBuildingActivityTemplateIdAndCostCodeIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	jbat2codes.*

FROM `jobsite_building_activity_templates_to_cost_codes` jbat2codes
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteBuildingActivityTemplatesToCostCodesByArrJobsiteBuildingActivityTemplateIdAndCostCodeIdList = array();
		while ($row = $db->fetch()) {
			$jobsiteBuildingActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplateToCostCode', $row);
			/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */
			$arrJobsiteBuildingActivityTemplatesToCostCodesByArrJobsiteBuildingActivityTemplateIdAndCostCodeIdList[] = $jobsiteBuildingActivityTemplateToCostCode;
		}

		$db->free_result();

		return $arrJobsiteBuildingActivityTemplatesToCostCodesByArrJobsiteBuildingActivityTemplateIdAndCostCodeIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_building_activity_templates_to_cost_codes_fk_jbat` foreign key (`jobsite_building_activity_template_id`) references `jobsite_building_activity_templates` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId($database, $jobsite_building_activity_template_id, Input $options=null)
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
			self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId = null;
		}

		$arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId = self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId;
		if (isset($arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId) && !empty($arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId)) {
			return $arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId;
		}

		$jobsite_building_activity_template_id = (int) $jobsite_building_activity_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_building_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityTemplateToCostCode = new JobsiteBuildingActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jbat2codes.*

FROM `jobsite_building_activity_templates_to_cost_codes` jbat2codes
WHERE jbat2codes.`jobsite_building_activity_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_building_activity_template_id` ASC, `cost_code_id` ASC
		$arrValues = array($jobsite_building_activity_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId = array();
		while ($row = $db->fetch()) {
			$jobsiteBuildingActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplateToCostCode', $row);
			/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */
			$cost_code_id = $jobsiteBuildingActivityTemplateToCostCode->cost_code_id;
			$arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId[$jobsite_building_activity_template_id][$cost_code_id] = $jobsiteBuildingActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId = $arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId;

		return $arrJobsiteBuildingActivityTemplatesToCostCodesByJobsiteBuildingActivityTemplateId;
	}

	/**
	 * Load by constraint `jobsite_building_activity_templates_to_cost_codes_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId = null;
		}

		$arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId = self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId;
		if (isset($arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId) && !empty($arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId)) {
			return $arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_building_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityTemplateToCostCode = new JobsiteBuildingActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jbat2codes.*

FROM `jobsite_building_activity_templates_to_cost_codes` jbat2codes
WHERE jbat2codes.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_building_activity_template_id` ASC, `cost_code_id` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId = array();
		while ($row = $db->fetch()) {
			$jobsiteBuildingActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplateToCostCode', $row);
			/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */
			$arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId[] = $jobsiteBuildingActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId = $arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId;

		return $arrJobsiteBuildingActivityTemplatesToCostCodesByCostCodeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_building_activity_templates_to_cost_codes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteBuildingActivityTemplatesToCostCodes($database, Input $options=null)
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
			self::$_arrAllJobsiteBuildingActivityTemplatesToCostCodes = null;
		}

		$arrAllJobsiteBuildingActivityTemplatesToCostCodes = self::$_arrAllJobsiteBuildingActivityTemplatesToCostCodes;
		if (isset($arrAllJobsiteBuildingActivityTemplatesToCostCodes) && !empty($arrAllJobsiteBuildingActivityTemplatesToCostCodes)) {
			return $arrAllJobsiteBuildingActivityTemplatesToCostCodes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_building_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityTemplateToCostCode = new JobsiteBuildingActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jbat2codes.*

FROM `jobsite_building_activity_templates_to_cost_codes` jbat2codes{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_building_activity_template_id` ASC, `cost_code_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteBuildingActivityTemplatesToCostCodes = array();
		while ($row = $db->fetch()) {
			$jobsiteBuildingActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplateToCostCode', $row);
			/* @var $jobsiteBuildingActivityTemplateToCostCode JobsiteBuildingActivityTemplateToCostCode */
			$arrAllJobsiteBuildingActivityTemplatesToCostCodes[] = $jobsiteBuildingActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrAllJobsiteBuildingActivityTemplatesToCostCodes = $arrAllJobsiteBuildingActivityTemplatesToCostCodes;

		return $arrAllJobsiteBuildingActivityTemplatesToCostCodes;
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
INTO `jobsite_building_activity_templates_to_cost_codes`
(`jobsite_building_activity_template_id`, `cost_code_id`)
VALUES (?, ?)
";
		$arrValues = array($this->jobsite_building_activity_template_id, $this->cost_code_id);
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

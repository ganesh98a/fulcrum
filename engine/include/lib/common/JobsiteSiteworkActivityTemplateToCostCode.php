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
 * JobsiteSiteworkActivityTemplateToCostCode.
 *
 * @category   Framework
 * @package    JobsiteSiteworkActivityTemplateToCostCode
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteSiteworkActivityTemplateToCostCode extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteSiteworkActivityTemplateToCostCode';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_sitework_activity_templates_to_cost_codes';

	/**
	 * primary key (`jobsite_sitework_activity_template_id`,`cost_code_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'jobsite_sitework_activity_template_id' => 'int',
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
		'unique_jobsite_sitework_activity_template_to_cost_code_via_primary_key' => array(
			'jobsite_sitework_activity_template_id' => 'int',
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
		'jobsite_sitework_activity_template_id' => 'jobsite_sitework_activity_template_id',
		'cost_code_id' => 'cost_code_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_sitework_activity_template_id;
	public $cost_code_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId;
	protected static $_arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteSiteworkActivityTemplatesToCostCodes;

	// Foreign Key Objects
	private $_jobsiteSiteworkActivityTemplate;
	private $_costCode;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_sitework_activity_templates_to_cost_codes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteSiteworkActivityTemplate()
	{
		if (isset($this->_jobsiteSiteworkActivityTemplate)) {
			return $this->_jobsiteSiteworkActivityTemplate;
		} else {
			return null;
		}
	}

	public function setJobsiteSiteworkActivityTemplate($jobsiteSiteworkActivityTemplate)
	{
		$this->_jobsiteSiteworkActivityTemplate = $jobsiteSiteworkActivityTemplate;
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
	public static function getArrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId()
	{
		if (isset(self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId)) {
			return self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId($arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId)
	{
		self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId = $arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId;
	}

	public static function getArrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId()
	{
		if (isset(self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId)) {
			return self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId($arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId)
	{
		self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId = $arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteSiteworkActivityTemplatesToCostCodes()
	{
		if (isset(self::$_arrAllJobsiteSiteworkActivityTemplatesToCostCodes)) {
			return self::$_arrAllJobsiteSiteworkActivityTemplatesToCostCodes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteSiteworkActivityTemplatesToCostCodes($arrAllJobsiteSiteworkActivityTemplatesToCostCodes)
	{
		self::$_arrAllJobsiteSiteworkActivityTemplatesToCostCodes = $arrAllJobsiteSiteworkActivityTemplatesToCostCodes;
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
	 * Find by primary key (`jobsite_sitework_activity_template_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_template_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteSiteworkActivityTemplateIdAndCostCodeId($database, $jobsite_sitework_activity_template_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jsat2codes.*

FROM `jobsite_sitework_activity_templates_to_cost_codes` jsat2codes
WHERE jsat2codes.`jobsite_sitework_activity_template_id` = ?
AND jsat2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_sitework_activity_template_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteSiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteSiteworkActivityTemplateToCostCode JobsiteSiteworkActivityTemplateToCostCode */
			return $jobsiteSiteworkActivityTemplateToCostCode;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`jobsite_sitework_activity_template_id`,`cost_code_id`) Extended.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_template_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteSiteworkActivityTemplateIdAndCostCodeIdExtended($database, $jobsite_sitework_activity_template_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jsat2codes_fk_jsat.`id` AS 'jsat2codes_fk_jsat__jobsite_sitework_activity_template_id',
	jsat2codes_fk_jsat.`jobsite_activity_list_template_id` AS 'jsat2codes_fk_jsat__jobsite_activity_list_template_id',
	jsat2codes_fk_jsat.`jobsite_sitework_activity_label` AS 'jsat2codes_fk_jsat__jobsite_sitework_activity_label',
	jsat2codes_fk_jsat.`sort_order` AS 'jsat2codes_fk_jsat__sort_order',
	jsat2codes_fk_jsat.`disabled_flag` AS 'jsat2codes_fk_jsat__disabled_flag',

	jsat2codes_fk_codes.`id` AS 'jsat2codes_fk_codes__cost_code_id',
	jsat2codes_fk_codes.`cost_code_division_id` AS 'jsat2codes_fk_codes__cost_code_division_id',
	jsat2codes_fk_codes.`cost_code` AS 'jsat2codes_fk_codes__cost_code',
	jsat2codes_fk_codes.`cost_code_description` AS 'jsat2codes_fk_codes__cost_code_description',
	jsat2codes_fk_codes.`cost_code_description_abbreviation` AS 'jsat2codes_fk_codes__cost_code_description_abbreviation',
	jsat2codes_fk_codes.`sort_order` AS 'jsat2codes_fk_codes__sort_order',
	jsat2codes_fk_codes.`disabled_flag` AS 'jsat2codes_fk_codes__disabled_flag',

	jsat2codes.*

FROM `jobsite_sitework_activity_templates_to_cost_codes` jsat2codes
	INNER JOIN `jobsite_sitework_activity_templates` jsat2codes_fk_jsat ON jsat2codes.`jobsite_sitework_activity_template_id` = jsat2codes_fk_jsat.`id`
	INNER JOIN `cost_codes` jsat2codes_fk_codes ON jsat2codes.`cost_code_id` = jsat2codes_fk_codes.`id`
WHERE jsat2codes.`jobsite_sitework_activity_template_id` = ?
AND jsat2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_sitework_activity_template_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteSiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteSiteworkActivityTemplateToCostCode JobsiteSiteworkActivityTemplateToCostCode */
			$jobsiteSiteworkActivityTemplateToCostCode->convertPropertiesToData();

			if (isset($row['jobsite_sitework_activity_template_id'])) {
				$jobsite_sitework_activity_template_id = $row['jobsite_sitework_activity_template_id'];
				$row['jsat2codes_fk_jsat__id'] = $jobsite_sitework_activity_template_id;
				$jobsiteSiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplate', $row, null, $jobsite_sitework_activity_template_id, 'jsat2codes_fk_jsat__');
				/* @var $jobsiteSiteworkActivityTemplate JobsiteSiteworkActivityTemplate */
				$jobsiteSiteworkActivityTemplate->convertPropertiesToData();
			} else {
				$jobsiteSiteworkActivityTemplate = false;
			}
			$jobsiteSiteworkActivityTemplateToCostCode->setJobsiteSiteworkActivityTemplate($jobsiteSiteworkActivityTemplate);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['jsat2codes_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'jsat2codes_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$jobsiteSiteworkActivityTemplateToCostCode->setCostCode($costCode);

			return $jobsiteSiteworkActivityTemplateToCostCode;
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
	 * @param array $arrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivityTemplatesToCostCodesByArrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList($database, $arrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList, Input $options=null)
	{
		if (empty($arrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList)) {
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
		// ORDER BY `jobsite_sitework_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityTemplateToCostCode = new JobsiteSiteworkActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList as $k => $arrTmp) {
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
		if (count($arrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	jsat2codes.*

FROM `jobsite_sitework_activity_templates_to_cost_codes` jsat2codes
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkActivityTemplatesToCostCodesByArrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList = array();
		while ($row = $db->fetch()) {
			$jobsiteSiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteSiteworkActivityTemplateToCostCode JobsiteSiteworkActivityTemplateToCostCode */
			$arrJobsiteSiteworkActivityTemplatesToCostCodesByArrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList[] = $jobsiteSiteworkActivityTemplateToCostCode;
		}

		$db->free_result();

		return $arrJobsiteSiteworkActivityTemplatesToCostCodesByArrJobsiteSiteworkActivityTemplateIdAndCostCodeIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_sitework_activity_templates_to_cost_codes_fk_jsat` foreign key (`jobsite_sitework_activity_template_id`) references `jobsite_sitework_activity_templates` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId($database, $jobsite_sitework_activity_template_id, Input $options=null)
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
			self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId = null;
		}

		$arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId = self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId;
		if (isset($arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId) && !empty($arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId)) {
			return $arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId;
		}

		$jobsite_sitework_activity_template_id = (int) $jobsite_sitework_activity_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_sitework_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityTemplateToCostCode = new JobsiteSiteworkActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsat2codes.*

FROM `jobsite_sitework_activity_templates_to_cost_codes` jsat2codes
WHERE jsat2codes.`jobsite_sitework_activity_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_sitework_activity_template_id` ASC, `cost_code_id` ASC
		$arrValues = array($jobsite_sitework_activity_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId = array();
		$arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId[$jobsite_sitework_activity_template_id] = array();
		while ($row = $db->fetch()) {
			$jobsiteSiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteSiteworkActivityTemplateToCostCode JobsiteSiteworkActivityTemplateToCostCode */
			$cost_code_id = $jobsiteSiteworkActivityTemplateToCostCode->cost_code_id;
			$arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId[$jobsite_sitework_activity_template_id][$cost_code_id] = $jobsiteSiteworkActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId = $arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId;

		return $arrJobsiteSiteworkActivityTemplatesToCostCodesByJobsiteSiteworkActivityTemplateId;
	}

	/**
	 * Load by constraint `jobsite_sitework_activity_templates_to_cost_codes_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId = null;
		}

		$arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId = self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId;
		if (isset($arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId) && !empty($arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId)) {
			return $arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_sitework_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityTemplateToCostCode = new JobsiteSiteworkActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsat2codes.*

FROM `jobsite_sitework_activity_templates_to_cost_codes` jsat2codes
WHERE jsat2codes.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_sitework_activity_template_id` ASC, `cost_code_id` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId = array();
		while ($row = $db->fetch()) {
			$jobsiteSiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteSiteworkActivityTemplateToCostCode JobsiteSiteworkActivityTemplateToCostCode */
			$arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId[] = $jobsiteSiteworkActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId = $arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId;

		return $arrJobsiteSiteworkActivityTemplatesToCostCodesByCostCodeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_sitework_activity_templates_to_cost_codes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteSiteworkActivityTemplatesToCostCodes($database, Input $options=null)
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
			self::$_arrAllJobsiteSiteworkActivityTemplatesToCostCodes = null;
		}

		$arrAllJobsiteSiteworkActivityTemplatesToCostCodes = self::$_arrAllJobsiteSiteworkActivityTemplatesToCostCodes;
		if (isset($arrAllJobsiteSiteworkActivityTemplatesToCostCodes) && !empty($arrAllJobsiteSiteworkActivityTemplatesToCostCodes)) {
			return $arrAllJobsiteSiteworkActivityTemplatesToCostCodes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_sitework_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityTemplateToCostCode = new JobsiteSiteworkActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsat2codes.*

FROM `jobsite_sitework_activity_templates_to_cost_codes` jsat2codes{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_sitework_activity_template_id` ASC, `cost_code_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteSiteworkActivityTemplatesToCostCodes = array();
		while ($row = $db->fetch()) {
			$jobsiteSiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteSiteworkActivityTemplateToCostCode JobsiteSiteworkActivityTemplateToCostCode */
			$arrAllJobsiteSiteworkActivityTemplatesToCostCodes[] = $jobsiteSiteworkActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrAllJobsiteSiteworkActivityTemplatesToCostCodes = $arrAllJobsiteSiteworkActivityTemplatesToCostCodes;

		return $arrAllJobsiteSiteworkActivityTemplatesToCostCodes;
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
INTO `jobsite_sitework_activity_templates_to_cost_codes`
(`jobsite_sitework_activity_template_id`, `cost_code_id`)
VALUES (?, ?)
";
		$arrValues = array($this->jobsite_sitework_activity_template_id, $this->cost_code_id);
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

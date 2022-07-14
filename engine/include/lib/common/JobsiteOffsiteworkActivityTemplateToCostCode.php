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
 * JobsiteOffsiteworkActivityTemplateToCostCode.
 *
 * @category   Framework
 * @package    JobsiteOffsiteworkActivityTemplateToCostCode
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteOffsiteworkActivityTemplateToCostCode extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteOffsiteworkActivityTemplateToCostCode';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_offsitework_activity_templates_to_cost_codes';

	/**
	 * primary key (`jobsite_offsitework_activity_template_id`,`cost_code_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'jobsite_offsitework_activity_template_id' => 'int',
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
		'unique_jobsite_offsitework_activity_template_to_cost_code_via_primary_key' => array(
			'jobsite_offsitework_activity_template_id' => 'int',
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
		'jobsite_offsitework_activity_template_id' => 'jobsite_offsitework_activity_template_id',
		'cost_code_id' => 'cost_code_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_offsitework_activity_template_id;
	public $cost_code_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId;
	protected static $_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes;

	// Foreign Key Objects
	private $_jobsiteOffsiteworkActivityTemplate;
	private $_costCode;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_offsitework_activity_templates_to_cost_codes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteOffsiteworkActivityTemplate()
	{
		if (isset($this->_jobsiteOffsiteworkActivityTemplate)) {
			return $this->_jobsiteOffsiteworkActivityTemplate;
		} else {
			return null;
		}
	}

	public function setJobsiteOffsiteworkActivityTemplate($jobsiteOffsiteworkActivityTemplate)
	{
		$this->_jobsiteOffsiteworkActivityTemplate = $jobsiteOffsiteworkActivityTemplate;
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
	public static function getArrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId()
	{
		if (isset(self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId)) {
			return self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId($arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId)
	{
		self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId = $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId;
	}

	public static function getArrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId()
	{
		if (isset(self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId)) {
			return self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId($arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId)
	{
		self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId = $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteOffsiteworkActivityTemplatesToCostCodes()
	{
		if (isset(self::$_arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes)) {
			return self::$_arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteOffsiteworkActivityTemplatesToCostCodes($arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes)
	{
		self::$_arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes = $arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes;
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
	 * Find by primary key (`jobsite_offsitework_activity_template_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_template_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteOffsiteworkActivityTemplateIdAndCostCodeId($database, $jobsite_offsitework_activity_template_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	joat2codes.*

FROM `jobsite_offsitework_activity_templates_to_cost_codes` joat2codes
WHERE joat2codes.`jobsite_offsitework_activity_template_id` = ?
AND joat2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_offsitework_activity_template_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteOffsiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityTemplateToCostCode JobsiteOffsiteworkActivityTemplateToCostCode */
			return $jobsiteOffsiteworkActivityTemplateToCostCode;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`jobsite_offsitework_activity_template_id`,`cost_code_id`) Extended.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_template_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdExtended($database, $jobsite_offsitework_activity_template_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	joat2codes_fk_joat.`id` AS 'joat2codes_fk_joat__jobsite_offsitework_activity_template_id',
	joat2codes_fk_joat.`jobsite_activity_list_template_id` AS 'joat2codes_fk_joat__jobsite_activity_list_template_id',
	joat2codes_fk_joat.`jobsite_offsitework_activity_label` AS 'joat2codes_fk_joat__jobsite_offsitework_activity_label',
	joat2codes_fk_joat.`sort_order` AS 'joat2codes_fk_joat__sort_order',
	joat2codes_fk_joat.`disabled_flag` AS 'joat2codes_fk_joat__disabled_flag',

	joat2codes_fk_codes.`id` AS 'joat2codes_fk_codes__cost_code_id',
	joat2codes_fk_codes.`cost_code_division_id` AS 'joat2codes_fk_codes__cost_code_division_id',
	joat2codes_fk_codes.`cost_code` AS 'joat2codes_fk_codes__cost_code',
	joat2codes_fk_codes.`cost_code_description` AS 'joat2codes_fk_codes__cost_code_description',
	joat2codes_fk_codes.`cost_code_description_abbreviation` AS 'joat2codes_fk_codes__cost_code_description_abbreviation',
	joat2codes_fk_codes.`sort_order` AS 'joat2codes_fk_codes__sort_order',
	joat2codes_fk_codes.`disabled_flag` AS 'joat2codes_fk_codes__disabled_flag',

	joat2codes.*

FROM `jobsite_offsitework_activity_templates_to_cost_codes` joat2codes
	INNER JOIN `jobsite_offsitework_activity_templates` joat2codes_fk_joat ON joat2codes.`jobsite_offsitework_activity_template_id` = joat2codes_fk_joat.`id`
	INNER JOIN `cost_codes` joat2codes_fk_codes ON joat2codes.`cost_code_id` = joat2codes_fk_codes.`id`
WHERE joat2codes.`jobsite_offsitework_activity_template_id` = ?
AND joat2codes.`cost_code_id` = ?
";
		$arrValues = array($jobsite_offsitework_activity_template_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$jobsiteOffsiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityTemplateToCostCode JobsiteOffsiteworkActivityTemplateToCostCode */
			$jobsiteOffsiteworkActivityTemplateToCostCode->convertPropertiesToData();

			if (isset($row['jobsite_offsitework_activity_template_id'])) {
				$jobsite_offsitework_activity_template_id = $row['jobsite_offsitework_activity_template_id'];
				$row['joat2codes_fk_joat__id'] = $jobsite_offsitework_activity_template_id;
				$jobsiteOffsiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplate', $row, null, $jobsite_offsitework_activity_template_id, 'joat2codes_fk_joat__');
				/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */
				$jobsiteOffsiteworkActivityTemplate->convertPropertiesToData();
			} else {
				$jobsiteOffsiteworkActivityTemplate = false;
			}
			$jobsiteOffsiteworkActivityTemplateToCostCode->setJobsiteOffsiteworkActivityTemplate($jobsiteOffsiteworkActivityTemplate);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['joat2codes_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'joat2codes_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$jobsiteOffsiteworkActivityTemplateToCostCode->setCostCode($costCode);

			return $jobsiteOffsiteworkActivityTemplateToCostCode;
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
	 * @param array $arrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivityTemplatesToCostCodesByArrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList($database, $arrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList, Input $options=null)
	{
		if (empty($arrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList)) {
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
		// ORDER BY `jobsite_offsitework_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityTemplateToCostCode = new JobsiteOffsiteworkActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList as $k => $arrTmp) {
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
		if (count($arrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	joat2codes.*

FROM `jobsite_offsitework_activity_templates_to_cost_codes` joat2codes
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByArrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList = array();
		while ($row = $db->fetch()) {
			$jobsiteOffsiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityTemplateToCostCode JobsiteOffsiteworkActivityTemplateToCostCode */
			$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByArrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList[] = $jobsiteOffsiteworkActivityTemplateToCostCode;
		}

		$db->free_result();

		return $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByArrJobsiteOffsiteworkActivityTemplateIdAndCostCodeIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_offsitework_activity_templates_to_cost_codes_fk_joat` foreign key (`jobsite_offsitework_activity_template_id`) references `jobsite_offsitework_activity_templates` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId($database, $jobsite_offsitework_activity_template_id, Input $options=null)
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
			self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId = null;
		}

		$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId = self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId;
		if (isset($arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId) && !empty($arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId)) {
			return $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId;
		}

		$jobsite_offsitework_activity_template_id = (int) $jobsite_offsitework_activity_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_offsitework_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityTemplateToCostCode = new JobsiteOffsiteworkActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joat2codes.*

FROM `jobsite_offsitework_activity_templates_to_cost_codes` joat2codes
WHERE joat2codes.`jobsite_offsitework_activity_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_offsitework_activity_template_id` ASC, `cost_code_id` ASC
		$arrValues = array($jobsite_offsitework_activity_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId = array();
		$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId[$jobsite_offsitework_activity_template_id] = array();
		while ($row = $db->fetch()) {
			$jobsiteOffsiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityTemplateToCostCode JobsiteOffsiteworkActivityTemplateToCostCode */
			$cost_code_id = $jobsiteOffsiteworkActivityTemplateToCostCode->cost_code_id;
			$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId[$jobsite_offsitework_activity_template_id][$cost_code_id] = $jobsiteOffsiteworkActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId = $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId;

		return $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByJobsiteOffsiteworkActivityTemplateId;
	}

	/**
	 * Load by constraint `jobsite_offsitework_activity_templates_to_cost_codes_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId = null;
		}

		$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId = self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId;
		if (isset($arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId) && !empty($arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId)) {
			return $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_offsitework_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityTemplateToCostCode = new JobsiteOffsiteworkActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joat2codes.*

FROM `jobsite_offsitework_activity_templates_to_cost_codes` joat2codes
WHERE joat2codes.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_offsitework_activity_template_id` ASC, `cost_code_id` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId = array();
		while ($row = $db->fetch()) {
			$jobsiteOffsiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityTemplateToCostCode JobsiteOffsiteworkActivityTemplateToCostCode */
			$arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId[] = $jobsiteOffsiteworkActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId = $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId;

		return $arrJobsiteOffsiteworkActivityTemplatesToCostCodesByCostCodeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_offsitework_activity_templates_to_cost_codes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteOffsiteworkActivityTemplatesToCostCodes($database, Input $options=null)
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
			self::$_arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes = null;
		}

		$arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes = self::$_arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes;
		if (isset($arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes) && !empty($arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes)) {
			return $arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `jobsite_offsitework_activity_template_id` ASC, `cost_code_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityTemplateToCostCode = new JobsiteOffsiteworkActivityTemplateToCostCode($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityTemplateToCostCode->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joat2codes.*

FROM `jobsite_offsitework_activity_templates_to_cost_codes` joat2codes{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `jobsite_offsitework_activity_template_id` ASC, `cost_code_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes = array();
		while ($row = $db->fetch()) {
			$jobsiteOffsiteworkActivityTemplateToCostCode = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplateToCostCode', $row);
			/* @var $jobsiteOffsiteworkActivityTemplateToCostCode JobsiteOffsiteworkActivityTemplateToCostCode */
			$arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes[] = $jobsiteOffsiteworkActivityTemplateToCostCode;
		}

		$db->free_result();

		self::$_arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes = $arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes;

		return $arrAllJobsiteOffsiteworkActivityTemplatesToCostCodes;
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
INTO `jobsite_offsitework_activity_templates_to_cost_codes`
(`jobsite_offsitework_activity_template_id`, `cost_code_id`)
VALUES (?, ?)
";
		$arrValues = array($this->jobsite_offsitework_activity_template_id, $this->cost_code_id);
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

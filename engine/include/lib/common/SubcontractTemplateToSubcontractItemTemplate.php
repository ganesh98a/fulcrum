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
 * SubcontractTemplateToSubcontractItemTemplate.
 *
 * @category   Framework
 * @package    SubcontractTemplateToSubcontractItemTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractTemplateToSubcontractItemTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractTemplateToSubcontractItemTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontract_templates_to_subcontract_item_templates';

	/**
	 * primary key (`subcontract_template_id`,`subcontract_item_template_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'subcontract_template_id' => 'int',
		'subcontract_item_template_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontract_template_to_subcontract_item_template_via_primary_key' => array(
			'subcontract_template_id' => 'int',
			'subcontract_item_template_id' => 'int'
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
		'subcontract_template_id' => 'subcontract_template_id',
		'subcontract_item_template_id' => 'subcontract_item_template_id',

		'sort_order' => 'sort_order',
		'date'=>'date',
		'updated_by'=>'updated_by'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontract_template_id;
	public $subcontract_item_template_id;

	public $sort_order;
	public $date;
	public $updated_by;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId;
	protected static $_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractTemplatesToSubcontractItemTemplates;

	// Foreign Key Objects
	private $_subcontractTemplate;
	private $_subcontractItemTemplate;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontract_templates_to_subcontract_item_templates')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubcontractTemplate()
	{
		if (isset($this->_subcontractTemplate)) {
			return $this->_subcontractTemplate;
		} else {
			return null;
		}
	}

	public function setSubcontractTemplate($subcontractTemplate)
	{
		$this->_subcontractTemplate = $subcontractTemplate;
	}

	public function getSubcontractItemTemplate()
	{
		if (isset($this->_subcontractItemTemplate)) {
			return $this->_subcontractItemTemplate;
		} else {
			return null;
		}
	}

	public function setSubcontractItemTemplate($subcontractItemTemplate)
	{
		$this->_subcontractItemTemplate = $subcontractItemTemplate;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId()
	{
		if (isset(self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId)) {
			return self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId($arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId)
	{
		self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId = $arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId;
	}

	public static function getArrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId()
	{
		if (isset(self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId)) {
			return self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId($arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId)
	{
		self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId = $arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractTemplatesToSubcontractItemTemplates()
	{
		if (isset(self::$_arrAllSubcontractTemplatesToSubcontractItemTemplates)) {
			return self::$_arrAllSubcontractTemplatesToSubcontractItemTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractTemplatesToSubcontractItemTemplates($arrAllSubcontractTemplatesToSubcontractItemTemplates)
	{
		self::$_arrAllSubcontractTemplatesToSubcontractItemTemplates = $arrAllSubcontractTemplatesToSubcontractItemTemplates;
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
	 * Find by primary key (`subcontract_template_id`,`subcontract_item_template_id`).
	 *
	 * @param string $database
	 * @param int $subcontract_template_id
	 * @param int $subcontract_item_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractTemplateIdAndSubcontractItemTemplateId($database, $subcontract_template_id, $subcontract_item_template_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	st2sit.*

FROM `subcontract_templates_to_subcontract_item_templates` st2sit
WHERE st2sit.`subcontract_template_id` = ?
AND st2sit.`subcontract_item_template_id` = ?
";
		$arrValues = array($subcontract_template_id, $subcontract_item_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$subcontractTemplateToSubcontractItemTemplate = self::instantiateOrm($database, 'SubcontractTemplateToSubcontractItemTemplate', $row);
			/* @var $subcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */
			return $subcontractTemplateToSubcontractItemTemplate;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`subcontract_template_id`,`subcontract_item_template_id`) Extended.
	 *
	 * @param string $database
	 * @param int $subcontract_template_id
	 * @param int $subcontract_item_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractTemplateIdAndSubcontractItemTemplateIdExtended($database, $subcontract_template_id, $subcontract_item_template_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	st2sit_fk_st.`id` AS 'st2sit_fk_st__subcontract_template_id',
	st2sit_fk_st.`user_company_id` AS 'st2sit_fk_st__user_company_id',
	st2sit_fk_st.`subcontract_type_id` AS 'st2sit_fk_st__subcontract_type_id',
	st2sit_fk_st.`subcontract_template_name` AS 'st2sit_fk_st__subcontract_template_name',
	st2sit_fk_st.`sort_order` AS 'st2sit_fk_st__sort_order',
	st2sit_fk_st.`disabled_flag` AS 'st2sit_fk_st__disabled_flag',

	st2sit_fk_sit.`id` AS 'st2sit_fk_sit__subcontract_item_template_id',
	st2sit_fk_sit.`user_company_id` AS 'st2sit_fk_sit__user_company_id',
	st2sit_fk_sit.`file_manager_file_id` AS 'st2sit_fk_sit__file_manager_file_id',
	st2sit_fk_sit.`user_company_file_template_id` AS 'st2sit_fk_sit__user_company_file_template_id',
	st2sit_fk_sit.`subcontract_item` AS 'st2sit_fk_sit__subcontract_item',
	st2sit_fk_sit.`subcontract_item_abbreviation` AS 'st2sit_fk_sit__subcontract_item_abbreviation',
	st2sit_fk_sit.`subcontract_item_template_type` AS 'st2sit_fk_sit__subcontract_item_template_type',
	st2sit_fk_sit.`sort_order` AS 'st2sit_fk_sit__sort_order',
	st2sit_fk_sit.`disabled_flag` AS 'st2sit_fk_sit__disabled_flag',

	st2sit.*

FROM `subcontract_templates_to_subcontract_item_templates` st2sit
	INNER JOIN `subcontract_templates` st2sit_fk_st ON st2sit.`subcontract_template_id` = st2sit_fk_st.`id`
	INNER JOIN `subcontract_item_templates` st2sit_fk_sit ON st2sit.`subcontract_item_template_id` = st2sit_fk_sit.`id`
WHERE st2sit.`subcontract_template_id` = ?
AND st2sit.`subcontract_item_template_id` = ?
";
		$arrValues = array($subcontract_template_id, $subcontract_item_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$subcontractTemplateToSubcontractItemTemplate = self::instantiateOrm($database, 'SubcontractTemplateToSubcontractItemTemplate', $row);
			/* @var $subcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */
			$subcontractTemplateToSubcontractItemTemplate->convertPropertiesToData();

			if (isset($row['subcontract_template_id'])) {
				$subcontract_template_id = $row['subcontract_template_id'];
				$row['st2sit_fk_st__id'] = $subcontract_template_id;
				$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id, 'st2sit_fk_st__');
				/* @var $subcontractTemplate SubcontractTemplate */
				$subcontractTemplate->convertPropertiesToData();
			} else {
				$subcontractTemplate = false;
			}
			$subcontractTemplateToSubcontractItemTemplate->setSubcontractTemplate($subcontractTemplate);

			if (isset($row['subcontract_item_template_id'])) {
				$subcontract_item_template_id = $row['subcontract_item_template_id'];
				$row['st2sit_fk_sit__id'] = $subcontract_item_template_id;
				$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id, 'st2sit_fk_sit__');
				/* @var $subcontractItemTemplate SubcontractItemTemplate */
				$subcontractItemTemplate->convertPropertiesToData();
			} else {
				$subcontractItemTemplate = false;
			}
			$subcontractTemplateToSubcontractItemTemplate->setSubcontractItemTemplate($subcontractItemTemplate);

			return $subcontractTemplateToSubcontractItemTemplate;
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
	 * @param array $arrSubcontractTemplateIdAndSubcontractItemTemplateIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractTemplatesToSubcontractItemTemplatesByArrSubcontractTemplateIdAndSubcontractItemTemplateIdList($database, $arrSubcontractTemplateIdAndSubcontractItemTemplateIdList, Input $options=null)
	{
		if (empty($arrSubcontractTemplateIdAndSubcontractItemTemplateIdList)) {
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
		// ORDER BY `subcontract_template_id` ASC, `subcontract_item_template_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY st2sit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplateToSubcontractItemTemplate = new SubcontractTemplateToSubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplateToSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrSubcontractTemplateIdAndSubcontractItemTemplateIdList as $k => $arrTmp) {
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
		if (count($arrSubcontractTemplateIdAndSubcontractItemTemplateIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	st2sit.*

FROM `subcontract_templates_to_subcontract_item_templates` st2sit
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractTemplatesToSubcontractItemTemplatesByArrSubcontractTemplateIdAndSubcontractItemTemplateIdList = array();
		while ($row = $db->fetch()) {
			$subcontractTemplateToSubcontractItemTemplate = self::instantiateOrm($database, 'SubcontractTemplateToSubcontractItemTemplate', $row);
			/* @var $subcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */
			$arrSubcontractTemplatesToSubcontractItemTemplatesByArrSubcontractTemplateIdAndSubcontractItemTemplateIdList[] = $subcontractTemplateToSubcontractItemTemplate;
		}

		$db->free_result();

		return $arrSubcontractTemplatesToSubcontractItemTemplatesByArrSubcontractTemplateIdAndSubcontractItemTemplateIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontract_templates_to_subcontract_item_templates_fk_st` foreign key (`subcontract_template_id`) references `subcontract_templates` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id, Input $options=null)
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
			self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId = null;
		}

		$arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId = self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId;
		if (isset($arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId) && !empty($arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId)) {
			return $arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId;
		}

		$subcontract_template_id = (int) $subcontract_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `subcontract_template_id` ASC, `subcontract_item_template_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY st2sit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplateToSubcontractItemTemplate = new SubcontractTemplateToSubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplateToSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	st2sit.*

FROM `subcontract_templates_to_subcontract_item_templates` st2sit
WHERE st2sit.`subcontract_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `subcontract_template_id` ASC, `subcontract_item_template_id` ASC, `sort_order` ASC
		$arrValues = array($subcontract_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId = array();
		while ($row = $db->fetch()) {
			$subcontractTemplateToSubcontractItemTemplate = self::instantiateOrm($database, 'SubcontractTemplateToSubcontractItemTemplate', $row);
			/* @var $subcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */
			$subcontract_item_template_id = $row['subcontract_item_template_id'];
			$arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId[$subcontract_item_template_id] = $subcontractTemplateToSubcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId = $arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId;

		return $arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId;
	}

	/**
	 * Load by constraint `subcontract_templates_to_subcontract_item_templates_fk_sit` foreign key (`subcontract_item_template_id`) references `subcontract_item_templates` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_item_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId($database, $subcontract_item_template_id, Input $options=null)
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
			self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId = null;
		}

		$arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId = self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId;
		if (isset($arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId) && !empty($arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId)) {
			return $arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId;
		}

		$subcontract_item_template_id = (int) $subcontract_item_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `subcontract_template_id` ASC, `subcontract_item_template_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY st2sit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplateToSubcontractItemTemplate = new SubcontractTemplateToSubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplateToSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	st2sit.*

FROM `subcontract_templates_to_subcontract_item_templates` st2sit
WHERE st2sit.`subcontract_item_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `subcontract_template_id` ASC, `subcontract_item_template_id` ASC, `sort_order` ASC
		$arrValues = array($subcontract_item_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId = array();
		while ($row = $db->fetch()) {
			$subcontractTemplateToSubcontractItemTemplate = self::instantiateOrm($database, 'SubcontractTemplateToSubcontractItemTemplate', $row);
			/* @var $subcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */
			$arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId[] = $subcontractTemplateToSubcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId = $arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId;

		return $arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractItemTemplateId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontract_templates_to_subcontract_item_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractTemplatesToSubcontractItemTemplates($database, Input $options=null)
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
			self::$_arrAllSubcontractTemplatesToSubcontractItemTemplates = null;
		}

		$arrAllSubcontractTemplatesToSubcontractItemTemplates = self::$_arrAllSubcontractTemplatesToSubcontractItemTemplates;
		if (isset($arrAllSubcontractTemplatesToSubcontractItemTemplates) && !empty($arrAllSubcontractTemplatesToSubcontractItemTemplates)) {
			return $arrAllSubcontractTemplatesToSubcontractItemTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `subcontract_template_id` ASC, `subcontract_item_template_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY st2sit.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractTemplateToSubcontractItemTemplate = new SubcontractTemplateToSubcontractItemTemplate($database);
			$sqlOrderByColumns = $tmpSubcontractTemplateToSubcontractItemTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	st2sit.*

FROM `subcontract_templates_to_subcontract_item_templates` st2sit{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `subcontract_template_id` ASC, `subcontract_item_template_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractTemplatesToSubcontractItemTemplates = array();
		while ($row = $db->fetch()) {
			$subcontractTemplateToSubcontractItemTemplate = self::instantiateOrm($database, 'SubcontractTemplateToSubcontractItemTemplate', $row);
			/* @var $subcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */
			$arrAllSubcontractTemplatesToSubcontractItemTemplates[] = $subcontractTemplateToSubcontractItemTemplate;
		}

		$db->free_result();

		self::$_arrAllSubcontractTemplatesToSubcontractItemTemplates = $arrAllSubcontractTemplatesToSubcontractItemTemplates;

		return $arrAllSubcontractTemplatesToSubcontractItemTemplates;
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
INTO `subcontract_templates_to_subcontract_item_templates`
(`subcontract_template_id`, `subcontract_item_template_id`, `sort_order`,`date`,`updated_by`)
VALUES (?, ?, ? ,? ,?)
ON DUPLICATE KEY UPDATE `sort_order` = ?,`date` = ?
";
		$arrValues = array($this->subcontract_template_id, $this->subcontract_item_template_id, $this->sort_order,$this->date,$this->updated_by, $this->sort_order,$this->date);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontract_template_to_subcontract_item_template_id = $db->insertId;
		$db->free_result();

		return $subcontract_template_to_subcontract_item_template_id;
	}

	// Save: insert ignore

	/**
	 * Find sort_order value.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextSortOrder($database, $user_company_id)
	{
		$next_sort_order = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(st2sit.sort_order) AS 'next_sort_order'
FROM `subcontract_templates_to_subcontract_item_templates` st2sit INNER JOIN `subcontract_templates` st ON st2sit.subcontract_template_id = st.`id`
WHERE st.`user_company_id` = ?
";
// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$next_sort_order = $row['next_sort_order'] + 1;
		} else {
			$query =
"
SELECT MAX(st2sit.sort_order) AS 'next_sort_order'
FROM `subcontract_templates_to_subcontract_item_templates` st2sit INNER JOIN `subcontract_item_templates` sit ON st2sit.subcontract_item_template_id = sit.`id`
WHERE sit.`user_company_id` = ?
";
// ORDER BY `id` ASC, `cost_code_division_id` ASC, `cost_code` ASC, `cost_code_description` ASC, `cost_code_description_abbreviation` ASC, `sort_order` ASC, `disabled_flag` ASC
			$arrValues = array($user_company_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$row = $db->fetch();
			$db->free_result();

			if ($row) {
				$next_sort_order = $row['next_sort_order'] + 1;
			} else {
				$next_sort_order = 0;
			}
		}

		return $next_sort_order;
	}

	public static function setNaturalSortOrderOnSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id, $original_subcontract_item_template_id)
	{
		$subcontract_template_id = (int) $subcontract_template_id;

		$loadSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateIdOptions = new Input();
		$loadSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateIdOptions->forceLoadFlag = true;

		$arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId =
			SubcontractTemplateToSubcontractItemTemplate::loadSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId($database, $subcontract_template_id, $loadSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateIdOptions);

		$i = 0;
		foreach ($arrSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId as $subcontract_item_template_id => $subcontractTemplateToSubcontractItemTemplate) {
			/* @var $subcontractTemplateToSubcontractItemTemplate SubcontractTemplateToSubcontractItemTemplate */

			if ($subcontractTemplateToSubcontractItemTemplate->sort_order != $i) {
				$data = array('sort_order' => $i);
				$subcontractTemplateToSubcontractItemTemplate->setData($data);
				$subcontractTemplateToSubcontractItemTemplate->save();
			}

			// Get the original sort_order value after updating to sane values
			if ($subcontractTemplateToSubcontractItemTemplate->subcontract_item_template_id == $original_subcontract_item_template_id) {
				$original_sort_order = $i;
			}

			$i++;
		}

		return $original_sort_order;
	}

	public function getItemTrackable($database, $item_template_id,$template_id)
	{
		$db = DBI::getInstance($database);
		$query =" SELECT `contract_track` FROM `subcontract_templates_to_subcontract_item_templates` WHERE `subcontract_template_id` = $template_id and `subcontract_item_template_id` = $item_template_id ;
		";
		$db->execute($query);
		$row=$db->fetch();
		$contract_track =$row['contract_track'];
		$db->free_result();
		return $contract_track;
	}

	public function updateSortOrder($database, $new_sort_order)
	{
		$new_sort_order = (int) $new_sort_order;

		// @todo Conditionally update sort_order based on table meta-data
		$original_sort_order = SubcontractTemplateToSubcontractItemTemplate::setNaturalSortOrderOnSubcontractTemplatesToSubcontractItemTemplatesBySubcontractTemplateId($database, $this->subcontract_template_id, $this->subcontract_item_template_id);

		if ($new_sort_order > $original_sort_order) {
			$movedDown = true;
			$movedUp = false;
		} elseif ($new_sort_order < $original_sort_order) {
			$movedDown = false;
			$movedUp = true;
		} else {
			// Same sort_order
			// Default to Moved Down
			$movedDown = true;
			$movedUp = false;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		if ($movedDown) {
			$query =
"
UPDATE `subcontract_templates_to_subcontract_item_templates`
SET `sort_order` = (`sort_order`-1)
WHERE `subcontract_template_id` = ?
AND `sort_order` > ?
AND `sort_order` <= ?
";
			$arrValues = array($this->subcontract_template_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} elseif ($movedUp) {
			$query =
"
UPDATE `subcontract_templates_to_subcontract_item_templates`
SET `sort_order` = (`sort_order`+1)
WHERE `subcontract_template_id` = ?
AND `sort_order` < ?
AND `sort_order` >= ?
";
			$arrValues = array($this->subcontract_template_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

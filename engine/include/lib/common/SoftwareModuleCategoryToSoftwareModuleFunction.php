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
 * SoftwareModuleCategoryToSoftwareModuleFunction.
 *
 * @category   Framework
 * @package    SoftwareModuleCategoryToSoftwareModuleFunction
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SoftwareModuleCategoryToSoftwareModuleFunction extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SoftwareModuleCategoryToSoftwareModuleFunction';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'software_module_categories_to_software_module_functions';

	/**
	 * primary key (`software_module_category_id`,`software_module_function_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'software_module_category_id' => 'int',
		'software_module_function_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_software_module_category_to_software_module_function_via_primary_key' => array(
			'software_module_category_id' => 'int',
			'software_module_function_id' => 'int'
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
		'software_module_category_id' => 'software_module_category_id',
		'software_module_function_id' => 'software_module_function_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $software_module_category_id;
	public $software_module_function_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId;
	protected static $_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions;

	// Foreign Key Objects
	private $_softwareModuleCategory;
	private $_softwareModuleFunction;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='software_module_categories_to_software_module_functions')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSoftwareModuleCategory()
	{
		if (isset($this->_softwareModuleCategory)) {
			return $this->_softwareModuleCategory;
		} else {
			return null;
		}
	}

	public function setSoftwareModuleCategory($softwareModuleCategory)
	{
		$this->_softwareModuleCategory = $softwareModuleCategory;
	}

	public function getSoftwareModuleFunction()
	{
		if (isset($this->_softwareModuleFunction)) {
			return $this->_softwareModuleFunction;
		} else {
			return null;
		}
	}

	public function setSoftwareModuleFunction($softwareModuleFunction)
	{
		$this->_softwareModuleFunction = $softwareModuleFunction;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId()
	{
		if (isset(self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId)) {
			return self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId;
		} else {
			return null;
		}
	}

	public static function setArrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId($arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId)
	{
		self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId = $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId;
	}

	public static function getArrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId()
	{
		if (isset(self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId)) {
			return self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		} else {
			return null;
		}
	}

	public static function setArrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId($arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId)
	{
		self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId = $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSoftwareModuleCategoriesToSoftwareModuleFunctions()
	{
		if (isset(self::$_arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions)) {
			return self::$_arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions;
		} else {
			return null;
		}
	}

	public static function setArrAllSoftwareModuleCategoriesToSoftwareModuleFunctions($arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions)
	{
		self::$_arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions = $arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions;
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
	 * Find by primary key (`software_module_category_id`,`software_module_function_id`).
	 *
	 * @param string $database
	 * @param int $software_module_category_id
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySoftwareModuleCategoryIdAndSoftwareModuleFunctionId($database, $software_module_category_id, $software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	smc2smf.*

FROM `software_module_categories_to_software_module_functions` smc2smf
WHERE smc2smf.`software_module_category_id` = ?
AND smc2smf.`software_module_function_id` = ?
";
		$arrValues = array($software_module_category_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$softwareModuleCategoryToSoftwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleCategoryToSoftwareModuleFunction', $row);
			/* @var $softwareModuleCategoryToSoftwareModuleFunction SoftwareModuleCategoryToSoftwareModuleFunction */
			return $softwareModuleCategoryToSoftwareModuleFunction;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`software_module_category_id`,`software_module_function_id`) Extended.
	 *
	 * @param string $database
	 * @param int $software_module_category_id
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySoftwareModuleCategoryIdAndSoftwareModuleFunctionIdExtended($database, $software_module_category_id, $software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	smc2smf_fk_smc.`id` AS 'smc2smf_fk_smc__software_module_category_id',
	smc2smf_fk_smc.`software_module_category` AS 'smc2smf_fk_smc__software_module_category',
	smc2smf_fk_smc.`software_module_category_label` AS 'smc2smf_fk_smc__software_module_category_label',
	smc2smf_fk_smc.`sort_order` AS 'smc2smf_fk_smc__sort_order',

	smc2smf_fk_smf.`id` AS 'smc2smf_fk_smf__software_module_function_id',
	smc2smf_fk_smf.`software_module_id` AS 'smc2smf_fk_smf__software_module_id',
	smc2smf_fk_smf.`software_module_function` AS 'smc2smf_fk_smf__software_module_function',
	smc2smf_fk_smf.`software_module_function_label` AS 'smc2smf_fk_smf__software_module_function_label',
	smc2smf_fk_smf.`software_module_function_navigation_label` AS 'smc2smf_fk_smf__software_module_function_navigation_label',
	smc2smf_fk_smf.`software_module_function_description` AS 'smc2smf_fk_smf__software_module_function_description',
	smc2smf_fk_smf.`default_software_module_function_url` AS 'smc2smf_fk_smf__default_software_module_function_url',
	smc2smf_fk_smf.`show_in_navigation_flag` AS 'smc2smf_fk_smf__show_in_navigation_flag',
	smc2smf_fk_smf.`available_to_all_users_flag` AS 'smc2smf_fk_smf__available_to_all_users_flag',
	smc2smf_fk_smf.`global_admin_only_flag` AS 'smc2smf_fk_smf__global_admin_only_flag',
	smc2smf_fk_smf.`purchased_function_flag` AS 'smc2smf_fk_smf__purchased_function_flag',
	smc2smf_fk_smf.`customer_configurable_permissions_by_role_flag` AS 'smc2smf_fk_smf__customer_configurable_permissions_by_role_flag',
	smc2smf_fk_smf.`customer_configurable_permissions_by_project_by_role_flag` AS 'smc2smf_fk_smf__customer_configurable_permissions_by_project_by_role_flag',
	smc2smf_fk_smf.`customer_configurable_permissions_by_contact_flag` AS 'smc2smf_fk_smf__customer_configurable_permissions_by_contact_flag',
	smc2smf_fk_smf.`project_specific_flag` AS 'smc2smf_fk_smf__project_specific_flag',
	smc2smf_fk_smf.`disabled_flag` AS 'smc2smf_fk_smf__disabled_flag',
	smc2smf_fk_smf.`sort_order` AS 'smc2smf_fk_smf__sort_order',

	smc2smf.*

FROM `software_module_categories_to_software_module_functions` smc2smf
	INNER JOIN `software_module_categories` smc2smf_fk_smc ON smc2smf.`software_module_category_id` = smc2smf_fk_smc.`id`
	INNER JOIN `software_module_functions` smc2smf_fk_smf ON smc2smf.`software_module_function_id` = smc2smf_fk_smf.`id`
WHERE smc2smf.`software_module_category_id` = ?
AND smc2smf.`software_module_function_id` = ?
";
		$arrValues = array($software_module_category_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$softwareModuleCategoryToSoftwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleCategoryToSoftwareModuleFunction', $row);
			/* @var $softwareModuleCategoryToSoftwareModuleFunction SoftwareModuleCategoryToSoftwareModuleFunction */
			$softwareModuleCategoryToSoftwareModuleFunction->convertPropertiesToData();

			if (isset($row['software_module_category_id'])) {
				$software_module_category_id = $row['software_module_category_id'];
				$row['smc2smf_fk_smc__id'] = $software_module_category_id;
				$softwareModuleCategory = self::instantiateOrm($database, 'SoftwareModuleCategory', $row, null, $software_module_category_id, 'smc2smf_fk_smc__');
				/* @var $softwareModuleCategory SoftwareModuleCategory */
				$softwareModuleCategory->convertPropertiesToData();
			} else {
				$softwareModuleCategory = false;
			}
			$softwareModuleCategoryToSoftwareModuleFunction->setSoftwareModuleCategory($softwareModuleCategory);

			if (isset($row['software_module_function_id'])) {
				$software_module_function_id = $row['software_module_function_id'];
				$row['smc2smf_fk_smf__id'] = $software_module_function_id;
				$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id, 'smc2smf_fk_smf__');
				/* @var $softwareModuleFunction SoftwareModuleFunction */
				$softwareModuleFunction->convertPropertiesToData();
			} else {
				$softwareModuleFunction = false;
			}
			$softwareModuleCategoryToSoftwareModuleFunction->setSoftwareModuleFunction($softwareModuleFunction);

			return $softwareModuleCategoryToSoftwareModuleFunction;
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
	 * @param array $arrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleCategoriesToSoftwareModuleFunctionsByArrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList($database, $arrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList, Input $options=null)
	{
		if (empty($arrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList)) {
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
		// ORDER BY `software_module_category_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleCategoryToSoftwareModuleFunction = new SoftwareModuleCategoryToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpSoftwareModuleCategoryToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList as $k => $arrTmp) {
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
		if (count($arrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	smc2smf.*

FROM `software_module_categories_to_software_module_functions` smc2smf
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleCategoriesToSoftwareModuleFunctionsByArrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList = array();
		while ($row = $db->fetch()) {
			$softwareModuleCategoryToSoftwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleCategoryToSoftwareModuleFunction', $row);
			/* @var $softwareModuleCategoryToSoftwareModuleFunction SoftwareModuleCategoryToSoftwareModuleFunction */
			$arrSoftwareModuleCategoriesToSoftwareModuleFunctionsByArrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList[] = $softwareModuleCategoryToSoftwareModuleFunction;
		}

		$db->free_result();

		return $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsByArrSoftwareModuleCategoryIdAndSoftwareModuleFunctionIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `software_module_categories_to_software_module_functions_fk_smc` foreign key (`software_module_category_id`) references `software_module_categories` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $software_module_category_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId($database, $software_module_category_id, Input $options=null)
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
			self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId = null;
		}

		$arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId = self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId;
		if (isset($arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId) && !empty($arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId)) {
			return $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId;
		}

		$software_module_category_id = (int) $software_module_category_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `software_module_category_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleCategoryToSoftwareModuleFunction = new SoftwareModuleCategoryToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpSoftwareModuleCategoryToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smc2smf.*

FROM `software_module_categories_to_software_module_functions` smc2smf
WHERE smc2smf.`software_module_category_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `software_module_category_id` ASC, `software_module_function_id` ASC
		$arrValues = array($software_module_category_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId = array();
		while ($row = $db->fetch()) {
			$softwareModuleCategoryToSoftwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleCategoryToSoftwareModuleFunction', $row);
			/* @var $softwareModuleCategoryToSoftwareModuleFunction SoftwareModuleCategoryToSoftwareModuleFunction */
			$arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId[] = $softwareModuleCategoryToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId = $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId;

		return $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleCategoryId;
	}

	/**
	 * Load by constraint `software_module_categories_to_software_module_functions_fk_smf` foreign key (`software_module_function_id`) references `software_module_functions` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $software_module_function_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId($database, $software_module_function_id, Input $options=null)
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
			self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId = null;
		}

		$arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId = self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		if (isset($arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId) && !empty($arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId)) {
			return $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		}

		$software_module_function_id = (int) $software_module_function_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `software_module_category_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleCategoryToSoftwareModuleFunction = new SoftwareModuleCategoryToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpSoftwareModuleCategoryToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smc2smf.*

FROM `software_module_categories_to_software_module_functions` smc2smf
WHERE smc2smf.`software_module_function_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `software_module_category_id` ASC, `software_module_function_id` ASC
		$arrValues = array($software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId = array();
		while ($row = $db->fetch()) {
			$softwareModuleCategoryToSoftwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleCategoryToSoftwareModuleFunction', $row);
			/* @var $softwareModuleCategoryToSoftwareModuleFunction SoftwareModuleCategoryToSoftwareModuleFunction */
			$arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId[] = $softwareModuleCategoryToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId = $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId;

		return $arrSoftwareModuleCategoriesToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all software_module_categories_to_software_module_functions records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSoftwareModuleCategoriesToSoftwareModuleFunctions($database, Input $options=null)
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
			self::$_arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions = null;
		}

		$arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions = self::$_arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions;
		if (isset($arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions) && !empty($arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions)) {
			return $arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `software_module_category_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleCategoryToSoftwareModuleFunction = new SoftwareModuleCategoryToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpSoftwareModuleCategoryToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smc2smf.*

FROM `software_module_categories_to_software_module_functions` smc2smf{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `software_module_category_id` ASC, `software_module_function_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions = array();
		while ($row = $db->fetch()) {
			$softwareModuleCategoryToSoftwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleCategoryToSoftwareModuleFunction', $row);
			/* @var $softwareModuleCategoryToSoftwareModuleFunction SoftwareModuleCategoryToSoftwareModuleFunction */
			$arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions[] = $softwareModuleCategoryToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions = $arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions;

		return $arrAllSoftwareModuleCategoriesToSoftwareModuleFunctions;
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
INTO `software_module_categories_to_software_module_functions`
(`software_module_category_id`, `software_module_function_id`)
VALUES (?, ?)
";
		$arrValues = array($this->software_module_category_id, $this->software_module_function_id);
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

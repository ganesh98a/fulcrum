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
 * SoftwareModuleFunction class.
 *
 * "Is A":
 * Software Module Function (software_module_functions).
 *
 * "Has A":
 * 1) a
 * 2) b
 * 3) c
 *
 * @category   Framework
 * @package    SoftwareModuleFunction
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SoftwareModuleFunction extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SoftwareModuleFunction';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'software_module_functions';

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
	 * unique index `unique_software_module_function` (`software_module_id`,`software_module_function`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_software_module_function' => array(
			'software_module_id' => 'int',
			'software_module_function' => 'string'
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
		'id' => 'software_module_function_id',

		'software_module_id' => 'software_module_id',
		'software_module_function' => 'software_module_function',

		'software_module_function_label' => 'software_module_function_label',
		'software_module_function_navigation_label' => 'software_module_function_navigation_label',
		'software_module_function_description' => 'software_module_function_description',
		'default_software_module_function_url' => 'default_software_module_function_url',
		'show_in_navigation_flag' => 'show_in_navigation_flag',
		'available_to_all_users_flag' => 'available_to_all_users_flag',
		'global_admin_only_flag' => 'global_admin_only_flag',
		'purchased_function_flag' => 'purchased_function_flag',
		'customer_configurable_permissions_by_role_flag' => 'customer_configurable_permissions_by_role_flag',
		'customer_configurable_permissions_by_project_by_role_flag' => 'customer_configurable_permissions_by_project_by_role_flag',
		'customer_configurable_permissions_by_contact_flag' => 'customer_configurable_permissions_by_contact_flag',
		'project_specific_flag' => 'project_specific_flag',
		'disabled_flag' => 'disabled_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $software_module_function_id;

	public $software_module_id;
	public $software_module_function;

	public $software_module_function_label;
	public $software_module_function_navigation_label;
	public $software_module_function_description;
	public $default_software_module_function_url;
	public $show_in_navigation_flag;
	public $available_to_all_users_flag;
	public $global_admin_only_flag;
	public $purchased_function_flag;
	public $customer_configurable_permissions_by_role_flag;
	public $customer_configurable_permissions_by_project_by_role_flag;
	public $customer_configurable_permissions_by_contact_flag;
	public $project_specific_flag;
	public $disabled_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_software_module_function;
	public $escaped_software_module_function_label;
	public $escaped_software_module_function_navigation_label;
	public $escaped_software_module_function_description;
	public $escaped_default_software_module_function_url;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_software_module_function_nl2br;
	public $escaped_software_module_function_label_nl2br;
	public $escaped_software_module_function_navigation_label_nl2br;
	public $escaped_software_module_function_description_nl2br;
	public $escaped_default_software_module_function_url_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrSoftwareModuleFunctionsBySoftwareModuleId;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSoftwareModuleFunctions;

	protected $arrSoftareModuleFunctionDependencies;
	protected $arrSoftareModuleFunctionPrerequisites;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='software_module_functions')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrSoftwareModuleFunctionsBySoftwareModuleId()
	{
		if (isset(self::$_arrSoftwareModuleFunctionsBySoftwareModuleId)) {
			return self::$_arrSoftwareModuleFunctionsBySoftwareModuleId;
		} else {
			return null;
		}
	}

	public static function setArrSoftwareModuleFunctionsBySoftwareModuleId($arrSoftwareModuleFunctionsBySoftwareModuleId)
	{
		self::$_arrSoftwareModuleFunctionsBySoftwareModuleId = $arrSoftwareModuleFunctionsBySoftwareModuleId;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSoftwareModuleFunctions()
	{
		if (isset(self::$_arrAllSoftwareModuleFunctions)) {
			return self::$_arrAllSoftwareModuleFunctions;
		} else {
			return null;
		}
	}

	public static function setArrAllSoftwareModuleFunctions($arrAllSoftwareModuleFunctions)
	{
		self::$_arrAllSoftwareModuleFunctions = $arrAllSoftwareModuleFunctions;
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
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $software_module_function_id,$table='software_module_functions', $module='SoftwareModuleFunction')
	{
		$softwareModuleFunction = parent::findById($database, $software_module_function_id, $table, $module);

		return $softwareModuleFunction;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSoftwareModuleFunctionByIdExtended($database, $software_module_function_id)
	{
		$software_module_function_id = (int) $software_module_function_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	smf.*

FROM `software_module_functions` smf
WHERE smf.`id` = ?
";
		$arrValues = array($software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$software_module_function_id = $row['id'];
			$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id);
			/* @var $softwareModuleFunction SoftwareModuleFunction */
			$softwareModuleFunction->convertPropertiesToData();

			return $softwareModuleFunction;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_software_module_function` (`software_module_id`,`software_module_function`).
	 *
	 * @param string $database
	 * @param int $software_module_id
	 * @param string $software_module_function
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySoftwareModuleIdAndSoftwareModuleFunction($database, $software_module_id, $software_module_function)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	smf.*

FROM `software_module_functions` smf
WHERE smf.`software_module_id` = ?
AND smf.`software_module_function` = ?
";
		$arrValues = array($software_module_id, $software_module_function);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$software_module_function_id = $row['id'];
			$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id);
			/* @var $softwareModuleFunction SoftwareModuleFunction */
			return $softwareModuleFunction;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSoftwareModuleFunctionIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleFunctionsByArrSoftwareModuleFunctionIds($database, $arrSoftwareModuleFunctionIds, Input $options=null)
	{
		if (empty($arrSoftwareModuleFunctionIds)) {
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
		// ORDER BY `id` ASC, `software_module_id` ASC, `software_module_function` ASC, `software_module_function_label` ASC, `software_module_function_navigation_label` ASC, `software_module_function_description` ASC, `default_software_module_function_url` ASC, `show_in_navigation_flag` ASC, `available_to_all_users_flag` ASC, `global_admin_only_flag` ASC, `purchased_function_flag` ASC, `customer_configurable_permissions_by_role_flag` ASC, `customer_configurable_permissions_by_project_by_role_flag` ASC, `customer_configurable_permissions_by_contact_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY smf.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleFunction = new SoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSoftwareModuleFunctionIds as $k => $software_module_function_id) {
			$software_module_function_id = (int) $software_module_function_id;
			$arrSoftwareModuleFunctionIds[$k] = $db->escape($software_module_function_id);
		}
		$csvSoftwareModuleFunctionIds = join(',', $arrSoftwareModuleFunctionIds);

		$query =
"
SELECT

	smf.*

FROM `software_module_functions` smf
WHERE smf.`id` IN ($csvSoftwareModuleFunctionIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSoftwareModuleFunctionsByCsvSoftwareModuleFunctionIds = array();
		while ($row = $db->fetch()) {
			$software_module_function_id = $row['id'];
			$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id);
			/* @var $softwareModuleFunction SoftwareModuleFunction */
			$softwareModuleFunction->convertPropertiesToData();

			$arrSoftwareModuleFunctionsByCsvSoftwareModuleFunctionIds[$software_module_function_id] = $softwareModuleFunction;
		}

		$db->free_result();

		return $arrSoftwareModuleFunctionsByCsvSoftwareModuleFunctionIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: unique index `unique_software_module_function` (`software_module_id`,`software_module_function`).
	 *
	 * @param string $database
	 * @param int $software_module_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleFunctionsBySoftwareModuleId($database, $software_module_id, Input $options=null)
	{
		$forceLoadFlag = false;
		$global_admin_only_flag = '';
		$disabled_flag = '';
		$filter_by_recommended_roles_flag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
			$global_admin_only_flag = $options->global_admin_only_flag;
			$disabled_flag = $options->disabled_flag;
			$filter_by_recommended_roles_flag = $options->filter_by_recommended_roles_flag;

			if ($global_admin_only_flag <> 'Y') {
				$global_admin_only_flag = 'N';
			}

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrSoftwareModuleFunctionsBySoftwareModuleId = null;
		}

		$arrSoftwareModuleFunctionsBySoftwareModuleId = self::$_arrSoftwareModuleFunctionsBySoftwareModuleId;
		if (isset($arrSoftwareModuleFunctionsBySoftwareModuleId) && !empty($arrSoftwareModuleFunctionsBySoftwareModuleId)) {
			return $arrSoftwareModuleFunctionsBySoftwareModuleId;
		}

		$software_module_id = (int) $software_module_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `software_module_id` ASC, `software_module_function` ASC, `software_module_function_label` ASC, `software_module_function_navigation_label` ASC, `software_module_function_description` ASC, `default_software_module_function_url` ASC, `show_in_navigation_flag` ASC, `available_to_all_users_flag` ASC, `global_admin_only_flag` ASC, `purchased_function_flag` ASC, `customer_configurable_permissions_by_role_flag` ASC, `customer_configurable_permissions_by_project_by_role_flag` ASC, `customer_configurable_permissions_by_contact_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY smf.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleFunction = new SoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$sqlFilter = '';
		if (isset($global_admin_only_flag) && !empty($global_admin_only_flag)) {
			$queryFilter = "\nAND smf.`global_admin_only_flag` = '$global_admin_only_flag'";
		}
		if (isset($disabled_flag) && !empty($disabled_flag)) {
			$queryFilter = "\nAND smf.`disabled_flag` = '$disabled_flag'";
		}

		$query =
"
SELECT
	smf.*

FROM `software_module_functions` smf
WHERE smf.`software_module_id` = ?
AND smf.disabled_flag <> 'Y'{$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `software_module_id` ASC, `software_module_function` ASC, `software_module_function_label` ASC, `software_module_function_navigation_label` ASC, `software_module_function_description` ASC, `default_software_module_function_url` ASC, `show_in_navigation_flag` ASC, `available_to_all_users_flag` ASC, `global_admin_only_flag` ASC, `purchased_function_flag` ASC, `customer_configurable_permissions_by_role_flag` ASC, `customer_configurable_permissions_by_project_by_role_flag` ASC, `customer_configurable_permissions_by_contact_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleFunctionsBySoftwareModuleId = array();
		while ($row = $db->fetch()) {
			$software_module_function_id = $row['id'];
			$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id);
			/* @var $softwareModuleFunction SoftwareModuleFunction */
			$arrSoftwareModuleFunctionsBySoftwareModuleId[$software_module_function_id] = $softwareModuleFunction;
		}

		$db->free_result();

		self::$_arrSoftwareModuleFunctionsBySoftwareModuleId = $arrSoftwareModuleFunctionsBySoftwareModuleId;

		return $arrSoftwareModuleFunctionsBySoftwareModuleId;
	}

	// Loaders: Load All Records
	/**
	 * Load all software_module_functions records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSoftwareModuleFunctions($database, Input $options=null)
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
			self::$_arrAllSoftwareModuleFunctions = null;
		}

		$arrAllSoftwareModuleFunctions = self::$_arrAllSoftwareModuleFunctions;
		if (isset($arrAllSoftwareModuleFunctions) && !empty($arrAllSoftwareModuleFunctions)) {
			return $arrAllSoftwareModuleFunctions;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `software_module_id` ASC, `software_module_function` ASC, `software_module_function_label` ASC, `software_module_function_navigation_label` ASC, `software_module_function_description` ASC, `default_software_module_function_url` ASC, `show_in_navigation_flag` ASC, `available_to_all_users_flag` ASC, `global_admin_only_flag` ASC, `purchased_function_flag` ASC, `customer_configurable_permissions_by_role_flag` ASC, `customer_configurable_permissions_by_project_by_role_flag` ASC, `customer_configurable_permissions_by_contact_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY smf.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleFunction = new SoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smf.*

FROM `software_module_functions` smf{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `software_module_id` ASC, `software_module_function` ASC, `software_module_function_label` ASC, `software_module_function_navigation_label` ASC, `software_module_function_description` ASC, `default_software_module_function_url` ASC, `show_in_navigation_flag` ASC, `available_to_all_users_flag` ASC, `global_admin_only_flag` ASC, `purchased_function_flag` ASC, `customer_configurable_permissions_by_role_flag` ASC, `customer_configurable_permissions_by_project_by_role_flag` ASC, `customer_configurable_permissions_by_contact_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSoftwareModuleFunctions = array();
		while ($row = $db->fetch()) {
			$software_module_function_id = $row['id'];
			$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id);
			/* @var $softwareModuleFunction SoftwareModuleFunction */
			$arrAllSoftwareModuleFunctions[$software_module_function_id] = $softwareModuleFunction;
		}

		$db->free_result();

		self::$_arrAllSoftwareModuleFunctions = $arrAllSoftwareModuleFunctions;

		return $arrAllSoftwareModuleFunctions;
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
INTO `software_module_functions`
(`software_module_id`, `software_module_function`, `software_module_function_label`, `software_module_function_navigation_label`, `software_module_function_description`, `default_software_module_function_url`, `show_in_navigation_flag`, `available_to_all_users_flag`, `global_admin_only_flag`, `purchased_function_flag`, `customer_configurable_permissions_by_role_flag`, `customer_configurable_permissions_by_project_by_role_flag`, `customer_configurable_permissions_by_contact_flag`, `project_specific_flag`, `disabled_flag`, `sort_order`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `software_module_function_label` = ?, `software_module_function_navigation_label` = ?, `software_module_function_description` = ?, `default_software_module_function_url` = ?, `show_in_navigation_flag` = ?, `available_to_all_users_flag` = ?, `global_admin_only_flag` = ?, `purchased_function_flag` = ?, `customer_configurable_permissions_by_role_flag` = ?, `customer_configurable_permissions_by_project_by_role_flag` = ?, `customer_configurable_permissions_by_contact_flag` = ?, `project_specific_flag` = ?, `disabled_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->software_module_id, $this->software_module_function, $this->software_module_function_label, $this->software_module_function_navigation_label, $this->software_module_function_description, $this->default_software_module_function_url, $this->show_in_navigation_flag, $this->available_to_all_users_flag, $this->global_admin_only_flag, $this->purchased_function_flag, $this->customer_configurable_permissions_by_role_flag, $this->customer_configurable_permissions_by_project_by_role_flag, $this->customer_configurable_permissions_by_contact_flag, $this->project_specific_flag, $this->disabled_flag, $this->sort_order, $this->software_module_function_label, $this->software_module_function_navigation_label, $this->software_module_function_description, $this->default_software_module_function_url, $this->show_in_navigation_flag, $this->available_to_all_users_flag, $this->global_admin_only_flag, $this->purchased_function_flag, $this->customer_configurable_permissions_by_role_flag, $this->customer_configurable_permissions_by_project_by_role_flag, $this->customer_configurable_permissions_by_contact_flag, $this->project_specific_flag, $this->disabled_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$software_module_function_id = $db->insertId;
		$db->free_result();

		return $software_module_function_id;
	}

	// Save: insert ignore

	public function getDependencies()
	{
		if (isset($this->arrSoftareModuleFunctionDependencies)) {
			return $this->arrSoftareModuleFunctionDependencies;
		} else {
			return array();
		}
	}

	public function loadDependencies()
	{
		if (!isset($this->software_module_function_id)) {
			return;
		}

		$database = $this->getDatabase();

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT *
FROM `software_module_function_relationships` smfr
WHERE `prerequisite_software_module_function_id` = $this->software_module_function_id
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrSoftwareModuleFunctionDependencies = array();
		while ($row = $db->fetch()) {
			$software_module_function_id = $row['software_module_function_id'];
			$prerequisite_software_module_function_id = $row['prerequisite_software_module_function_id'];
			$arrSoftwareModuleFunctionDependencies[$prerequisite_software_module_function_id][$software_module_function_id] = 1;
		}

		$this->arrSoftareModuleFunctionDependencies = $arrSoftwareModuleFunctionDependencies;
	}

	public function getPrerequisites()
	{
		if (isset($this->arrSoftareModuleFunctionPrerequisites)) {
			return $this->arrSoftareModuleFunctionPrerequisites;
		} else {
			return array();
		}
	}

	public function loadPrerequisites()
	{
		if (!isset($this->software_module_function_id)) {
			return;
		}

		$database = $this->getDatabase();

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT *
FROM `software_module_function_relationships` smfr
WHERE `software_module_function_id` = $this->software_module_function_id
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrSoftareModuleFunctionPrerequisites = array();
		while ($row = $db->fetch()) {
			$software_module_function_id = $row['software_module_function_id'];
			$prerequisite_software_module_function_id = $row['prerequisite_software_module_function_id'];
			$arrSoftareModuleFunctionPrerequisites[$software_module_function_id][$prerequisite_software_module_function_id] = 1;
		}

		$this->arrSoftareModuleFunctionPrerequisites = $arrSoftareModuleFunctionPrerequisites;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		// prevent error messages
		$newRecord = false;

		//load existing

		//deltify

		//save (insert, update, or do nothing)

		$newData = $this->getData();
		$row = $newData;

		// These GUIDs taken as a composite are the primary key of software_modules
		// <software_module>
		$software_module = $this->software_module;

		$key = array(
			'software_module' => $software_module,
		);

		$database = $this->getDatabase();
		$table = $this->getTable();
		$sm = new SoftwareModule($database, $table);
		$sm->setKey($key);
		$sm->load();

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */
		$newData = $row;

		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $sm->isDataLoaded();
		if ($existsFlag) {
			$record_id = $sm->id;

			//Conditionally Update the record
			//Don't compare the key values that loaded the record.
			unset($sm->id);
			unset($sm->modified);
			//unset($sm->created);
			//unset($sm->deleted_flag);

			$existingData = $sm->getData();

			//debug
			/*
			$keyDiffFlag = Data::diffKeys($existingData, $newData);
			if (!$keyDiffFlag) {
				echo "Key:\n".print_r($key, true)."\n\n\n\n";
				echo 'Existing:'."\n";
				ksort($existingData);
				print_r($existingData);
				echo 'New:'."\n";
				ksort($newData);
				print_r($newData);
				$n = array_keys($newData);
				$e = array_keys($existingData);
				$_1 = array_diff_key($n, $e);
				echo 'New:'."\n";
				print_r($_1);
				$_2 = array_diff_key($e, $n);
				echo 'Old:'."\n";
				print_r($_2);
				throw new Exception('Keys mismatch');
			}
			*/

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$sm->setData($data);
				$save = true;
				//$this->updatedRecords++;
			} else {
				$sm->id = $record_id;
				return $sm;
			}
		} else {
			//normalize since record is just being inserted for the first time
			//$this->setData($newData);
			//$this->normalize();
			//$newData = $this->getData();
			//get only the attributes that will go into the details table
			//$newData = array_intersect_key($newData, $arrAttributes);

			//Insert the record
			$sm->setKey(null);
			$sm->setData($newData);
			// Add value for created timestamp.
			$sm->created = null;
			$save = true;
			//$this->insertedRecords++;
		}

		//Save if needed (conditionally Insert/Update)
		if ($save) {
			$id = $sm->save();

			if (isset($id)) {
				$sm->id = $record_id;
			}
		}

		return $sm;
	}


	/**
	* Get Id by function name
	* @param funcition_name
	* @return id
	*/
	public static function getIdbyfunctionName($fnName,$database)
	{
		// if($database=="")
		// {
		// $database = $this->getDatabase();
		// }
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query = "SELECT * FROM `software_module_functions` WHERE 
		`software_module_function` = '$fnName'";
		$db->query($query, MYSQLI_USE_RESULT);
		$fnId = '';
		while ($row = $db->fetch()) {
			$fnId = $row['id'];
		}

		return $fnId;
	}
	/**
	* Get Project specify by function Id
	* @param project_specify
	* @return id
	*/
	public static function getprojectspecificflagbyfunctionId($database,$fnid)
	{
		
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query = "SELECT sm.project_specific_flag FROM `software_module_functions` smf  inner join `software_modules` as sm on smf.`software_module_id` = sm.id where smf.id= '$fnid'";
		// $arrValues = array($fnid);
		// $db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->query($query, MYSQLI_USE_RESULT);
		$prjspc = '';
		while ($row = $db->fetch()) {
			$prjspc = $row['project_specific_flag'];
		}

		return $prjspc;
	}


	/**
	* Get Project specify by function Id
	* @param project_specify
	* @return id
	*/
	public static function getSoftwareModuleFunctionId($database,$software_module_id)
	{
		$db = DBI::getInstance($database);
		$moudleId = "
		SELECT GROUP_CONCAT(smf.`id`) as id FROM `software_modules` s
		INNER JOIN `software_module_functions` smf ON s.`id` = smf.`software_module_id`
		WHERE s.`id` = ? 
		";
		$arrMoudle = array($software_module_id);
		$db->execute($moudleId,$arrMoudle);
		$softModIds = $db->fetch();
		$softModId = $softModIds['id'];

		return $softModId;
	}
}
/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

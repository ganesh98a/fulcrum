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
 * SoftwareModule class.
 *
 * "Is A":
 * Software Module (software_modules).
 *
 * "Has A":
 * 1) a
 * 2) b
 * 3) c
 *
 * @category   Framework
 * @package    SoftwareModule
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SoftwareModule extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SoftwareModule';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'software_modules';

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
	 * unique index `unique_software_module` (`software_module`)
	 * unique index `unique_software_module_via_label` (`software_module_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_software_module' => array(
			'software_module' => 'string'
		),
		'unique_software_module_via_label' => array(
			'software_module_label' => 'string'
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
		'id' => 'software_module_id',

		'software_module_category_id' => 'software_module_category_id',

		'software_module' => 'software_module',
		'software_module_label' => 'software_module_label',

		'software_module_description' => 'software_module_description',
		'default_software_module_url' => 'default_software_module_url',
		'mobile_navigation_id' => 'mobile_navigation_id',
		'hard_coded_flag' => 'hard_coded_flag',
		'global_admin_only_flag' => 'global_admin_only_flag',
		'purchased_module_flag' => 'purchased_module_flag',
		'customer_configurable_flag' => 'customer_configurable_flag',
		'allow_ad_hoc_contact_permissions_flag' => 'allow_ad_hoc_contact_permissions_flag',
		'project_specific_flag' => 'project_specific_flag',
		'disabled_flag' => 'disabled_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $software_module_id;

	public $software_module_category_id;

	public $software_module;
	public $software_module_label;

	public $software_module_description;
	public $default_software_module_url;
	public $mobile_navigation_id;
	public $hard_coded_flag;
	public $global_admin_only_flag;
	public $purchased_module_flag;
	public $customer_configurable_flag;
	public $allow_ad_hoc_contact_permissions_flag;
	public $project_specific_flag;
	public $disabled_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_software_module;
	public $escaped_software_module_label;
	public $escaped_software_module_description;
	public $escaped_default_software_module_url;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_software_module_nl2br;
	public $escaped_software_module_label_nl2br;
	public $escaped_software_module_description_nl2br;
	public $escaped_default_software_module_url_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSoftwareModulesBySoftwareModuleCategoryId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSoftwareModules;

	// Foreign Key Objects
	private $_softwareModuleCategory;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='software_modules')
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSoftwareModulesBySoftwareModuleCategoryId()
	{
		if (isset(self::$_arrSoftwareModulesBySoftwareModuleCategoryId)) {
			return self::$_arrSoftwareModulesBySoftwareModuleCategoryId;
		} else {
			return null;
		}
	}

	public static function setArrSoftwareModulesBySoftwareModuleCategoryId($arrSoftwareModulesBySoftwareModuleCategoryId)
	{
		self::$_arrSoftwareModulesBySoftwareModuleCategoryId = $arrSoftwareModulesBySoftwareModuleCategoryId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSoftwareModules()
	{
		if (isset(self::$_arrAllSoftwareModules)) {
			return self::$_arrAllSoftwareModules;
		} else {
			return null;
		}
	}

	public static function setArrAllSoftwareModules($arrAllSoftwareModules)
	{
		self::$_arrAllSoftwareModules = $arrAllSoftwareModules;
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
	 * @param int $software_module_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $software_module_id,$table='software_modules', $module='SoftwareModule')
	{
		$softwareModule = parent::findById($database, $software_module_id, $table, $module);

		return $softwareModule;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $software_module_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSoftwareModuleByIdExtended($database, $software_module_id)
	{
		$software_module_id = (int) $software_module_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sm_fk_smc.`id` AS 'sm_fk_smc__software_module_category_id',
	sm_fk_smc.`software_module_category` AS 'sm_fk_smc__software_module_category',
	sm_fk_smc.`software_module_category_label` AS 'sm_fk_smc__software_module_category_label',
	sm_fk_smc.`sort_order` AS 'sm_fk_smc__sort_order',

	sm.*

FROM `software_modules` sm
	INNER JOIN `software_module_categories` sm_fk_smc ON sm.`software_module_category_id` = sm_fk_smc.`id`
WHERE sm.`id` = ?
";
		$arrValues = array($software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$software_module_id = $row['id'];
			$softwareModule = self::instantiateOrm($database, 'SoftwareModule', $row, null, $software_module_id);
			/* @var $softwareModule SoftwareModule */
			$softwareModule->convertPropertiesToData();

			if (isset($row['software_module_category_id'])) {
				$software_module_category_id = $row['software_module_category_id'];
				$row['sm_fk_smc__id'] = $software_module_category_id;
				$softwareModuleCategory = self::instantiateOrm($database, 'SoftwareModuleCategory', $row, null, $software_module_category_id, 'sm_fk_smc__');
				/* @var $softwareModuleCategory SoftwareModuleCategory */
				$softwareModuleCategory->convertPropertiesToData();
			} else {
				$softwareModuleCategory = false;
			}
			$softwareModule->setSoftwareModuleCategory($softwareModuleCategory);

			return $softwareModule;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_software_module` (`software_module`).
	 *
	 * @param string $database
	 * @param string $software_module
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySoftwareModule($database, $software_module)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sm.*

FROM `software_modules` sm
WHERE sm.`software_module` = ?
";
		$arrValues = array($software_module);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$software_module_id = $row['id'];
			$softwareModule = self::instantiateOrm($database, 'SoftwareModule', $row, null, $software_module_id);
			/* @var $softwareModule SoftwareModule */
			return $softwareModule;
		} else {
			return false;
		}
	}

	/**
	 * Find by unique index `unique_software_module_via_label` (`software_module_label`).
	 *
	 * @param string $database
	 * @param string $software_module_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySoftwareModuleLabel($database, $software_module_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sm.*

FROM `software_modules` sm
WHERE sm.`software_module_label` = ?
";
		$arrValues = array($software_module_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$software_module_id = $row['id'];
			$softwareModule = self::instantiateOrm($database, 'SoftwareModule', $row, null, $software_module_id);
			/* @var $softwareModule SoftwareModule */
			return $softwareModule;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSoftwareModuleIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModulesByArrSoftwareModuleIds($database, $arrSoftwareModuleIds, Input $options=null)
	{
		if (empty($arrSoftwareModuleIds)) {
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
		// ORDER BY `id` ASC, `software_module_category_id` ASC, `software_module` ASC, `software_module_label` ASC, `software_module_description` ASC, `default_software_module_url` ASC, `hard_coded_flag` ASC, `global_admin_only_flag` ASC, `purchased_module_flag` ASC, `customer_configurable_flag` ASC, `allow_ad_hoc_contact_permissions_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sm.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModule = new SoftwareModule($database);
			$sqlOrderByColumns = $tmpSoftwareModule->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSoftwareModuleIds as $k => $software_module_id) {
			$software_module_id = (int) $software_module_id;
			$arrSoftwareModuleIds[$k] = $db->escape($software_module_id);
		}
		$csvSoftwareModuleIds = join(',', $arrSoftwareModuleIds);

		$query =
"
SELECT

	sm.*

FROM `software_modules` sm
WHERE sm.`id` IN ($csvSoftwareModuleIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSoftwareModulesByCsvSoftwareModuleIds = array();
		while ($row = $db->fetch()) {
			$software_module_id = $row['id'];
			$softwareModule = self::instantiateOrm($database, 'SoftwareModule', $row, null, $software_module_id);
			/* @var $softwareModule SoftwareModule */
			$softwareModule->convertPropertiesToData();

			$arrSoftwareModulesByCsvSoftwareModuleIds[$software_module_id] = $softwareModule;
		}

		$db->free_result();

		return $arrSoftwareModulesByCsvSoftwareModuleIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `software_modules_fk_smc` foreign key (`software_module_category_id`) references `software_module_categories` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $software_module_category_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModulesBySoftwareModuleCategoryId($database, $software_module_category_id, Input $options=null)
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
			self::$_arrSoftwareModulesBySoftwareModuleCategoryId = null;
		}

		$arrSoftwareModulesBySoftwareModuleCategoryId = self::$_arrSoftwareModulesBySoftwareModuleCategoryId;
		if (isset($arrSoftwareModulesBySoftwareModuleCategoryId) && !empty($arrSoftwareModulesBySoftwareModuleCategoryId)) {
			return $arrSoftwareModulesBySoftwareModuleCategoryId;
		}

		$software_module_category_id = (int) $software_module_category_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `software_module_category_id` ASC, `software_module` ASC, `software_module_label` ASC, `software_module_description` ASC, `default_software_module_url` ASC, `hard_coded_flag` ASC, `global_admin_only_flag` ASC, `purchased_module_flag` ASC, `customer_configurable_flag` ASC, `allow_ad_hoc_contact_permissions_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sm.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModule = new SoftwareModule($database);
			$sqlOrderByColumns = $tmpSoftwareModule->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sm.*

FROM `software_modules` sm
WHERE sm.`software_module_category_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `software_module_category_id` ASC, `software_module` ASC, `software_module_label` ASC, `software_module_description` ASC, `default_software_module_url` ASC, `hard_coded_flag` ASC, `global_admin_only_flag` ASC, `purchased_module_flag` ASC, `customer_configurable_flag` ASC, `allow_ad_hoc_contact_permissions_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($software_module_category_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModulesBySoftwareModuleCategoryId = array();
		while ($row = $db->fetch()) {
			$software_module_id = $row['id'];
			$softwareModule = self::instantiateOrm($database, 'SoftwareModule', $row, null, $software_module_id);
			/* @var $softwareModule SoftwareModule */
			$arrSoftwareModulesBySoftwareModuleCategoryId[$software_module_id] = $softwareModule;
		}

		$db->free_result();

		self::$_arrSoftwareModulesBySoftwareModuleCategoryId = $arrSoftwareModulesBySoftwareModuleCategoryId;

		return $arrSoftwareModulesBySoftwareModuleCategoryId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all software_modules records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSoftwareModules($database, Input $options=null)
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
			self::$_arrAllSoftwareModules = null;
		}

		$arrAllSoftwareModules = self::$_arrAllSoftwareModules;
		if (isset($arrAllSoftwareModules) && !empty($arrAllSoftwareModules)) {
			return $arrAllSoftwareModules;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `software_module_category_id` ASC, `software_module` ASC, `software_module_label` ASC, `software_module_description` ASC, `default_software_module_url` ASC, `hard_coded_flag` ASC, `global_admin_only_flag` ASC, `purchased_module_flag` ASC, `customer_configurable_flag` ASC, `allow_ad_hoc_contact_permissions_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sm.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModule = new SoftwareModule($database);
			$sqlOrderByColumns = $tmpSoftwareModule->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sm.*

FROM `software_modules` sm{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `software_module_category_id` ASC, `software_module` ASC, `software_module_label` ASC, `software_module_description` ASC, `default_software_module_url` ASC, `hard_coded_flag` ASC, `global_admin_only_flag` ASC, `purchased_module_flag` ASC, `customer_configurable_flag` ASC, `allow_ad_hoc_contact_permissions_flag` ASC, `project_specific_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSoftwareModules = array();
		while ($row = $db->fetch()) {
			$software_module_id = $row['id'];
			$softwareModule = self::instantiateOrm($database, 'SoftwareModule', $row, null, $software_module_id);
			/* @var $softwareModule SoftwareModule */
			$arrAllSoftwareModules[$software_module_id] = $softwareModule;
		}

		$db->free_result();

		self::$_arrAllSoftwareModules = $arrAllSoftwareModules;

		return $arrAllSoftwareModules;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	/**
	 * Load software_modules as a list of objects and html <options> by:
	 * user_role_id
	 * user_company_id
	 *
	 * for user_role_id = 3 ("User"):
	 * contact_id
	 * project_id
	 *
	 * @param string $database
	 * @param integer $user_role_id
	 * @param integer $user_company_id
	 * @param boolean $loadAllFlag
	 * @return array of objects and HTML options
	 */
	public static function loadSoftwareModulesList($database, $user_role_id=null, $user_company_id=null, $contact_id=null, $project_id=null)
	{
		$db = DBI::getInstance($database);

		if (!isset($user_role_id) && !isset($user_company_id) && !isset($contact_id) && !isset($project_id)) {
			$loadAllFlag = true;
		} else {
			$loadAllFlag = false;
		}

		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
		if ($loadAllFlag || (isset($user_role_id) && !empty($user_role_id) && ($user_role_id == $AXIS_USER_ROLE_ID_GLOBAL_ADMIN))) {

			//Not including the Global admin modules
			$query =
"
SELECT sm.*
FROM `software_modules` sm WHERE `software_module_category_id` <> 1 and sm.`web_view_flag` = 'Y'
ORDER BY `software_module_category_id` ASC
";
			$arrValues = array();
		} else {
			// Determine if the user_company_id is a paying customer
			if ($user_role_id == $AXIS_USER_ROLE_ID_ADMIN && (isset($user_company_id) && !empty($user_company_id))) {
				// Load all of the software_modules that a paying
				$query =
"
SELECT sm.*
FROM `user_companies_to_software_modules` uc2sm, `software_modules` sm
WHERE uc2sm.`user_company_id` = ?
AND uc2sm.`software_module_id` = sm.`id`
AND sm.`global_admin_only_flag` = 'N'
AND sm.`customer_configurable_flag` = 'Y'
AND sm.`web_view_flag` = 'Y'
ORDER BY sm.`software_module` ASC
";
				$arrValues = array($user_company_id);
			}
		}

		$arrSoftwareModulesList = array();
		$arrSoftwareModuleOptions = array();
		if (isset($query) && !empty($query)) {
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			while ($row = $db->fetch()) {
				$software_module_id = $row['id'];
				$software_module = $row['software_module'];
				$software_module_label = $row['software_module_label'];
				$sm = new SoftwareModule($database);
				$sm->setId($software_module_id);
				$sm->setData($row);
				$sm->convertDataToProperties();
				// Object list format
				$arrSoftwareModulesList[$software_module_id] = $sm;

				// Drop down list format
				$arrSoftwareModuleOptions[$software_module_id] = $software_module_label;
			}
			$db->free_result();
		} else {

		}

		$arrReturn = array(
			'objects_list' => $arrSoftwareModulesList,
			'options_list' => $arrSoftwareModuleOptions
		);

		return $arrReturn;
	}

	public static function loadSoftwareModuleIdListByPurchasedModuleFlag($database, $purchased_module_flag, $global_admin_flag='N')
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT sm.`id` 'software_module_id'
FROM `software_modules` sm
WHERE `purchased_module_flag` = ?
AND `global_admin_only_flag` = ?
";
		$arrValues = array($purchased_module_flag, $global_admin_flag);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleIdList = array();
		while ($row = $db->fetch()) {
			$software_module_id = $row['software_module_id'];
			$arrSoftwareModuleIdList[$software_module_id] = 1;
		}
		$db->free_result();

		return $arrSoftwareModuleIdList;
	}

	public static function loadConfigurableSoftwareModulesForCustomer($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT sm.`id` 'software_module_id'
FROM `software_modules` sm
WHERE `purchased_module_flag` = ?
AND `global_admin_only_flag` = ?
";
		$arrValues = array($purchased_module_flag, $global_admin_flag);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleIdList = array();
		while ($row = $db->fetch()) {
			$software_module_id = $row['software_module_id'];
			$arrSoftwareModuleIdList[$software_module_id] = 1;
		}
		$db->free_result();

		return $arrSoftwareModuleIdList;
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
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

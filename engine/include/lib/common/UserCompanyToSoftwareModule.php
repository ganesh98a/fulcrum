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
 * UserCompanyToSoftwareModule.
 *
 * @category   Framework
 * @package    UserCompanyToSoftwareModule
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class UserCompanyToSoftwareModule extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'UserCompanyToSoftwareModule';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'user_companies_to_software_modules';

	/**
	 * primary key (`user_company_id`,`software_module_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'user_company_id' => 'int',
		'software_module_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_user_company_to_software_module_via_primary_key' => array(
			'user_company_id' => 'int',
			'software_module_id' => 'int'
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
		'user_company_id' => 'user_company_id',
		'software_module_id' => 'software_module_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_company_id;
	public $software_module_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrUserCompaniesToSoftwareModulesByUserCompanyId;
	protected static $_arrUserCompaniesToSoftwareModulesBySoftwareModuleId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUserCompaniesToSoftwareModules;

	// Foreign Key Objects
	private $_userCompany;
	private $_softwareModule;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='user_companies_to_software_modules')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getUserCompany()
	{
		if (isset($this->_userCompany)) {
			return $this->_userCompany;
		} else {
			return null;
		}
	}

	public function setUserCompany($userCompany)
	{
		$this->_userCompany = $userCompany;
	}

	public function getSoftwareModule()
	{
		if (isset($this->_softwareModule)) {
			return $this->_softwareModule;
		} else {
			return null;
		}
	}

	public function setSoftwareModule($softwareModule)
	{
		$this->_softwareModule = $softwareModule;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrUserCompaniesToSoftwareModulesByUserCompanyId()
	{
		if (isset(self::$_arrUserCompaniesToSoftwareModulesByUserCompanyId)) {
			return self::$_arrUserCompaniesToSoftwareModulesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrUserCompaniesToSoftwareModulesByUserCompanyId($arrUserCompaniesToSoftwareModulesByUserCompanyId)
	{
		self::$_arrUserCompaniesToSoftwareModulesByUserCompanyId = $arrUserCompaniesToSoftwareModulesByUserCompanyId;
	}

	public static function getArrUserCompaniesToSoftwareModulesBySoftwareModuleId()
	{
		if (isset(self::$_arrUserCompaniesToSoftwareModulesBySoftwareModuleId)) {
			return self::$_arrUserCompaniesToSoftwareModulesBySoftwareModuleId;
		} else {
			return null;
		}
	}

	public static function setArrUserCompaniesToSoftwareModulesBySoftwareModuleId($arrUserCompaniesToSoftwareModulesBySoftwareModuleId)
	{
		self::$_arrUserCompaniesToSoftwareModulesBySoftwareModuleId = $arrUserCompaniesToSoftwareModulesBySoftwareModuleId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllUserCompaniesToSoftwareModules()
	{
		if (isset(self::$_arrAllUserCompaniesToSoftwareModules)) {
			return self::$_arrAllUserCompaniesToSoftwareModules;
		} else {
			return null;
		}
	}

	public static function setArrAllUserCompaniesToSoftwareModules($arrAllUserCompaniesToSoftwareModules)
	{
		self::$_arrAllUserCompaniesToSoftwareModules = $arrAllUserCompaniesToSoftwareModules;
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
	 * Find by primary key (`user_company_id`,`software_module_id`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $software_module_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndSoftwareModuleId($database, $user_company_id, $software_module_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	uc2sm.*

FROM `user_companies_to_software_modules` uc2sm
WHERE uc2sm.`user_company_id` = ?
AND uc2sm.`software_module_id` = ?
";
		$arrValues = array($user_company_id, $software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$userCompanyToSoftwareModule = self::instantiateOrm($database, 'UserCompanyToSoftwareModule', $row);
			/* @var $userCompanyToSoftwareModule UserCompanyToSoftwareModule */
			return $userCompanyToSoftwareModule;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`user_company_id`,`software_module_id`) Extended.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $software_module_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndSoftwareModuleIdExtended($database, $user_company_id, $software_module_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	uc2sm_fk_uc.`id` AS 'uc2sm_fk_uc__user_company_id',
	uc2sm_fk_uc.`company` AS 'uc2sm_fk_uc__company',
	uc2sm_fk_uc.`primary_phone_number` AS 'uc2sm_fk_uc__primary_phone_number',
	uc2sm_fk_uc.`employer_identification_number` AS 'uc2sm_fk_uc__employer_identification_number',
	uc2sm_fk_uc.`construction_license_number` AS 'uc2sm_fk_uc__construction_license_number',
	uc2sm_fk_uc.`construction_license_number_expiration_date` AS 'uc2sm_fk_uc__construction_license_number_expiration_date',
	uc2sm_fk_uc.`paying_customer_flag` AS 'uc2sm_fk_uc__paying_customer_flag',

	uc2sm_fk_sm.`id` AS 'uc2sm_fk_sm__software_module_id',
	uc2sm_fk_sm.`software_module_category_id` AS 'uc2sm_fk_sm__software_module_category_id',
	uc2sm_fk_sm.`software_module` AS 'uc2sm_fk_sm__software_module',
	uc2sm_fk_sm.`software_module_label` AS 'uc2sm_fk_sm__software_module_label',
	uc2sm_fk_sm.`software_module_description` AS 'uc2sm_fk_sm__software_module_description',
	uc2sm_fk_sm.`default_software_module_url` AS 'uc2sm_fk_sm__default_software_module_url',
	uc2sm_fk_sm.`hard_coded_flag` AS 'uc2sm_fk_sm__hard_coded_flag',
	uc2sm_fk_sm.`global_admin_only_flag` AS 'uc2sm_fk_sm__global_admin_only_flag',
	uc2sm_fk_sm.`purchased_module_flag` AS 'uc2sm_fk_sm__purchased_module_flag',
	uc2sm_fk_sm.`customer_configurable_flag` AS 'uc2sm_fk_sm__customer_configurable_flag',
	uc2sm_fk_sm.`allow_ad_hoc_contact_permissions_flag` AS 'uc2sm_fk_sm__allow_ad_hoc_contact_permissions_flag',
	uc2sm_fk_sm.`project_specific_flag` AS 'uc2sm_fk_sm__project_specific_flag',
	uc2sm_fk_sm.`disabled_flag` AS 'uc2sm_fk_sm__disabled_flag',
	uc2sm_fk_sm.`sort_order` AS 'uc2sm_fk_sm__sort_order',

	uc2sm.*

FROM `user_companies_to_software_modules` uc2sm
	INNER JOIN `user_companies` uc2sm_fk_uc ON uc2sm.`user_company_id` = uc2sm_fk_uc.`id`
	INNER JOIN `software_modules` uc2sm_fk_sm ON uc2sm.`software_module_id` = uc2sm_fk_sm.`id`
WHERE uc2sm.`user_company_id` = ?
AND uc2sm.`software_module_id` = ?
";
		$arrValues = array($user_company_id, $software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$userCompanyToSoftwareModule = self::instantiateOrm($database, 'UserCompanyToSoftwareModule', $row);
			/* @var $userCompanyToSoftwareModule UserCompanyToSoftwareModule */
			$userCompanyToSoftwareModule->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['uc2sm_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'uc2sm_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$userCompanyToSoftwareModule->setUserCompany($userCompany);

			if (isset($row['software_module_id'])) {
				$software_module_id = $row['software_module_id'];
				$row['uc2sm_fk_sm__id'] = $software_module_id;
				$softwareModule = self::instantiateOrm($database, 'SoftwareModule', $row, null, $software_module_id, 'uc2sm_fk_sm__');
				/* @var $softwareModule SoftwareModule */
				$softwareModule->convertPropertiesToData();
			} else {
				$softwareModule = false;
			}
			$userCompanyToSoftwareModule->setSoftwareModule($softwareModule);

			return $userCompanyToSoftwareModule;
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
	 * @param array $arrUserCompanyIdAndSoftwareModuleIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserCompaniesToSoftwareModulesByArrUserCompanyIdAndSoftwareModuleIdList($database, $arrUserCompanyIdAndSoftwareModuleIdList, Input $options=null)
	{
		if (empty($arrUserCompanyIdAndSoftwareModuleIdList)) {
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
		// ORDER BY `user_company_id` ASC, `software_module_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompanyToSoftwareModule = new UserCompanyToSoftwareModule($database);
			$sqlOrderByColumns = $tmpUserCompanyToSoftwareModule->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrUserCompanyIdAndSoftwareModuleIdList as $k => $arrTmp) {
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
		if (count($arrUserCompanyIdAndSoftwareModuleIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	uc2sm.*

FROM `user_companies_to_software_modules` uc2sm
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserCompaniesToSoftwareModulesByArrUserCompanyIdAndSoftwareModuleIdList = array();
		while ($row = $db->fetch()) {
			$userCompanyToSoftwareModule = self::instantiateOrm($database, 'UserCompanyToSoftwareModule', $row);
			/* @var $userCompanyToSoftwareModule UserCompanyToSoftwareModule */
			$arrUserCompaniesToSoftwareModulesByArrUserCompanyIdAndSoftwareModuleIdList[] = $userCompanyToSoftwareModule;
		}

		$db->free_result();

		return $arrUserCompaniesToSoftwareModulesByArrUserCompanyIdAndSoftwareModuleIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `user_companies_to_software_modules_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserCompaniesToSoftwareModulesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrUserCompaniesToSoftwareModulesByUserCompanyId = null;
		}

		$arrUserCompaniesToSoftwareModulesByUserCompanyId = self::$_arrUserCompaniesToSoftwareModulesByUserCompanyId;
		if (isset($arrUserCompaniesToSoftwareModulesByUserCompanyId) && !empty($arrUserCompaniesToSoftwareModulesByUserCompanyId)) {
			return $arrUserCompaniesToSoftwareModulesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `user_company_id` ASC, `software_module_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompanyToSoftwareModule = new UserCompanyToSoftwareModule($database);
			$sqlOrderByColumns = $tmpUserCompanyToSoftwareModule->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uc2sm.*

FROM `user_companies_to_software_modules` uc2sm
WHERE uc2sm.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `user_company_id` ASC, `software_module_id` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserCompaniesToSoftwareModulesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$userCompanyToSoftwareModule = self::instantiateOrm($database, 'UserCompanyToSoftwareModule', $row);
			/* @var $userCompanyToSoftwareModule UserCompanyToSoftwareModule */
			$arrUserCompaniesToSoftwareModulesByUserCompanyId[] = $userCompanyToSoftwareModule;
		}

		$db->free_result();

		self::$_arrUserCompaniesToSoftwareModulesByUserCompanyId = $arrUserCompaniesToSoftwareModulesByUserCompanyId;

		return $arrUserCompaniesToSoftwareModulesByUserCompanyId;
	}

	/**
	 * Load by constraint `user_companies_to_software_modules_fk_sm` foreign key (`software_module_id`) references `software_modules` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $software_module_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserCompaniesToSoftwareModulesBySoftwareModuleId($database, $software_module_id, Input $options=null)
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
			self::$_arrUserCompaniesToSoftwareModulesBySoftwareModuleId = null;
		}

		$arrUserCompaniesToSoftwareModulesBySoftwareModuleId = self::$_arrUserCompaniesToSoftwareModulesBySoftwareModuleId;
		if (isset($arrUserCompaniesToSoftwareModulesBySoftwareModuleId) && !empty($arrUserCompaniesToSoftwareModulesBySoftwareModuleId)) {
			return $arrUserCompaniesToSoftwareModulesBySoftwareModuleId;
		}

		$software_module_id = (int) $software_module_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `user_company_id` ASC, `software_module_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompanyToSoftwareModule = new UserCompanyToSoftwareModule($database);
			$sqlOrderByColumns = $tmpUserCompanyToSoftwareModule->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uc2sm.*

FROM `user_companies_to_software_modules` uc2sm
WHERE uc2sm.`software_module_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `user_company_id` ASC, `software_module_id` ASC
		$arrValues = array($software_module_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserCompaniesToSoftwareModulesBySoftwareModuleId = array();
		while ($row = $db->fetch()) {
			$userCompanyToSoftwareModule = self::instantiateOrm($database, 'UserCompanyToSoftwareModule', $row);
			/* @var $userCompanyToSoftwareModule UserCompanyToSoftwareModule */
			$arrUserCompaniesToSoftwareModulesBySoftwareModuleId[] = $userCompanyToSoftwareModule;
		}

		$db->free_result();

		self::$_arrUserCompaniesToSoftwareModulesBySoftwareModuleId = $arrUserCompaniesToSoftwareModulesBySoftwareModuleId;

		return $arrUserCompaniesToSoftwareModulesBySoftwareModuleId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all user_companies_to_software_modules records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllUserCompaniesToSoftwareModules($database, Input $options=null)
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
			self::$_arrAllUserCompaniesToSoftwareModules = null;
		}

		$arrAllUserCompaniesToSoftwareModules = self::$_arrAllUserCompaniesToSoftwareModules;
		if (isset($arrAllUserCompaniesToSoftwareModules) && !empty($arrAllUserCompaniesToSoftwareModules)) {
			return $arrAllUserCompaniesToSoftwareModules;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `user_company_id` ASC, `software_module_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompanyToSoftwareModule = new UserCompanyToSoftwareModule($database);
			$sqlOrderByColumns = $tmpUserCompanyToSoftwareModule->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uc2sm.*

FROM `user_companies_to_software_modules` uc2sm{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `user_company_id` ASC, `software_module_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllUserCompaniesToSoftwareModules = array();
		while ($row = $db->fetch()) {
			$userCompanyToSoftwareModule = self::instantiateOrm($database, 'UserCompanyToSoftwareModule', $row);
			/* @var $userCompanyToSoftwareModule UserCompanyToSoftwareModule */
			$arrAllUserCompaniesToSoftwareModules[] = $userCompanyToSoftwareModule;
		}

		$db->free_result();

		self::$_arrAllUserCompaniesToSoftwareModules = $arrAllUserCompaniesToSoftwareModules;

		return $arrAllUserCompaniesToSoftwareModules;
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
INTO `user_companies_to_software_modules`
(`user_company_id`, `software_module_id`)
VALUES (?, ?)
";
		$arrValues = array($this->user_company_id, $this->software_module_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}

	public static function loadSoftwareModuleIdListByUserCompany($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT uc2sm.`software_module_id`
FROM `user_companies_to_software_modules` uc2sm
WHERE `user_company_id` = ?
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleIdList = array();
		while ($row = $db->fetch()) {
			$software_module_id = $row['software_module_id'];
			$arrSoftwareModuleIdList[$software_module_id] = 1;
		}
		$db->free_result();

		return $arrSoftwareModuleIdList;
	}

	public static function linkUserCompanyToDefaultSoftwareModules($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$escapedUserCompanyId = $db->escape($user_company_id);

		$query =
"
INSERT IGNORE
INTO `user_companies_to_software_modules` (`user_company_id`, `software_module_id`)
SELECT $escapedUserCompanyId as 'user_company_id', sm.`id` AS 'software_module_id'
FROM `software_modules` sm
WHERE sm.`global_admin_only_flag` = 'N'
AND sm.`purchased_module_flag` = 'N'
AND sm.`disabled_flag` = 'N'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$db->free_result();
	}

	public static function insertUserCompanyToSoftwareModuleRecords($database, $user_company_id, $arrSoftwareModuleIds)
	{
		if (!isset($arrSoftwareModuleIds) || empty($arrSoftwareModuleIds)) {
			return;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$insertQuery =
"
INSERT INTO `user_companies_to_software_modules`
(`user_company_id`, `software_module_id`)
VALUES (?, ?)
";

		$selectQuery =
"
SELECT count(*)
FROM `user_companies_to_software_modules`
WHERE `user_company_id` = ?
AND `software_module_id` = ?
";

		$db->begin();

		foreach ($arrSoftwareModuleIds as $software_module_id) {
			$arrValues = array($user_company_id, $software_module_id);

			$db->execute($selectQuery, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			$db->free_result();

			if (isset($row['count(*)'])) {
				$total = $row['count(*)'];
			} else {
				$total = 0;
			}

			if ($total == 0) {
				$db->execute($insertQuery, $arrValues, MYSQLI_USE_RESULT);
				$db->free_result();
			}
		}

		/*
		// This does not work for the update case.  It works just for the initial insert case.
		// All current $arrSoftwareModuleIds values would need to be passed in to support this.
		$in = join(',', $arrSoftwareModuleIds);

		$query =
			"DELETE ".
			"FROM `user_companies_to_software_modules` ".
			"WHERE `user_company_id` = ? ".
			"AND `software_module_id` NOT IN ($in) ";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
		*/

		$db->commit();
		$db->free_result();
	}

	public static function deleteUserCompanyToSoftwareModuleRecords($database, $user_company_id, $arrSoftwareModuleIds)
	{
		if (!isset($arrSoftwareModuleIds) || empty($arrSoftwareModuleIds)) {
			return;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$in = join(',', $arrSoftwareModuleIds);

		$query =
"
DELETE
FROM `user_companies_to_software_modules`
WHERE `user_company_id` = ?
AND `software_module_id` IN ($in)
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * RoleToSoftwareModuleFunctionTemplate.
 *
 * @category   Framework
 * @package    RoleToSoftwareModuleFunctionTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RoleToSoftwareModuleFunctionTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RoleToSoftwareModuleFunctionTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'roles_to_software_module_function_templates';

	/**
	 * primary key (`user_company_id`,`role_id`,`software_module_function_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'user_company_id' => 'int',
		'role_id' => 'int',
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
		'unique_role_to_software_module_function_template_via_primary_key' => array(
			'user_company_id' => 'int',
			'role_id' => 'int',
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
		'user_company_id' => 'user_company_id',
		'role_id' => 'role_id',
		'software_module_function_id' => 'software_module_function_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_company_id;
	public $role_id;
	public $software_module_function_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId;
	protected static $_arrRolesToSoftwareModuleFunctionTemplatesByRoleId;
	protected static $_arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRolesToSoftwareModuleFunctionTemplates;

	// Foreign Key Objects
	private $_userCompany;
	private $_role;
	private $_softwareModuleFunction;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='roles_to_software_module_function_templates')
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

	public function getRole()
	{
		if (isset($this->_role)) {
			return $this->_role;
		} else {
			return null;
		}
	}

	public function setRole($role)
	{
		$this->_role = $role;
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
	public static function getArrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId()
	{
		if (isset(self::$_arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId)) {
			return self::$_arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId($arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId)
	{
		self::$_arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId = $arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId;
	}

	public static function getArrRolesToSoftwareModuleFunctionTemplatesByRoleId()
	{
		if (isset(self::$_arrRolesToSoftwareModuleFunctionTemplatesByRoleId)) {
			return self::$_arrRolesToSoftwareModuleFunctionTemplatesByRoleId;
		} else {
			return null;
		}
	}

	public static function setArrRolesToSoftwareModuleFunctionTemplatesByRoleId($arrRolesToSoftwareModuleFunctionTemplatesByRoleId)
	{
		self::$_arrRolesToSoftwareModuleFunctionTemplatesByRoleId = $arrRolesToSoftwareModuleFunctionTemplatesByRoleId;
	}

	public static function getArrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId()
	{
		if (isset(self::$_arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId)) {
			return self::$_arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId;
		} else {
			return null;
		}
	}

	public static function setArrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId($arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId)
	{
		self::$_arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId = $arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRolesToSoftwareModuleFunctionTemplates()
	{
		if (isset(self::$_arrAllRolesToSoftwareModuleFunctionTemplates)) {
			return self::$_arrAllRolesToSoftwareModuleFunctionTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllRolesToSoftwareModuleFunctionTemplates($arrAllRolesToSoftwareModuleFunctionTemplates)
	{
		self::$_arrAllRolesToSoftwareModuleFunctionTemplates = $arrAllRolesToSoftwareModuleFunctionTemplates;
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
	 * Find by primary key (`user_company_id`,`role_id`,`software_module_function_id`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $role_id
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndRoleIdAndSoftwareModuleFunctionId($database, $user_company_id, $role_id, $software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	r2smft.*

FROM `roles_to_software_module_function_templates` r2smft
WHERE r2smft.`user_company_id` = ?
AND r2smft.`role_id` = ?
AND r2smft.`software_module_function_id` = ?
";
		$arrValues = array($user_company_id, $role_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$roleToSoftwareModuleFunctionTemplate = self::instantiateOrm($database, 'RoleToSoftwareModuleFunctionTemplate', $row);
			/* @var $roleToSoftwareModuleFunctionTemplate RoleToSoftwareModuleFunctionTemplate */
			return $roleToSoftwareModuleFunctionTemplate;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`user_company_id`,`role_id`,`software_module_function_id`) Extended.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $role_id
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdExtended($database, $user_company_id, $role_id, $software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	r2smft_fk_uc.`id` AS 'r2smft_fk_uc__user_company_id',
	r2smft_fk_uc.`company` AS 'r2smft_fk_uc__company',
	r2smft_fk_uc.`primary_phone_number` AS 'r2smft_fk_uc__primary_phone_number',
	r2smft_fk_uc.`employer_identification_number` AS 'r2smft_fk_uc__employer_identification_number',
	r2smft_fk_uc.`construction_license_number` AS 'r2smft_fk_uc__construction_license_number',
	r2smft_fk_uc.`construction_license_number_expiration_date` AS 'r2smft_fk_uc__construction_license_number_expiration_date',
	r2smft_fk_uc.`paying_customer_flag` AS 'r2smft_fk_uc__paying_customer_flag',

	r2smft_fk_r.`id` AS 'r2smft_fk_r__role_id',
	r2smft_fk_r.`role` AS 'r2smft_fk_r__role',
	r2smft_fk_r.`role_description` AS 'r2smft_fk_r__role_description',
	r2smft_fk_r.`project_specific_flag` AS 'r2smft_fk_r__project_specific_flag',
	r2smft_fk_r.`sort_order` AS 'r2smft_fk_r__sort_order',

	r2smft_fk_smf.`id` AS 'r2smft_fk_smf__software_module_function_id',
	r2smft_fk_smf.`software_module_id` AS 'r2smft_fk_smf__software_module_id',
	r2smft_fk_smf.`software_module_function` AS 'r2smft_fk_smf__software_module_function',
	r2smft_fk_smf.`software_module_function_label` AS 'r2smft_fk_smf__software_module_function_label',
	r2smft_fk_smf.`software_module_function_navigation_label` AS 'r2smft_fk_smf__software_module_function_navigation_label',
	r2smft_fk_smf.`software_module_function_description` AS 'r2smft_fk_smf__software_module_function_description',
	r2smft_fk_smf.`default_software_module_function_url` AS 'r2smft_fk_smf__default_software_module_function_url',
	r2smft_fk_smf.`show_in_navigation_flag` AS 'r2smft_fk_smf__show_in_navigation_flag',
	r2smft_fk_smf.`available_to_all_users_flag` AS 'r2smft_fk_smf__available_to_all_users_flag',
	r2smft_fk_smf.`global_admin_only_flag` AS 'r2smft_fk_smf__global_admin_only_flag',
	r2smft_fk_smf.`purchased_function_flag` AS 'r2smft_fk_smf__purchased_function_flag',
	r2smft_fk_smf.`customer_configurable_permissions_by_role_flag` AS 'r2smft_fk_smf__customer_configurable_permissions_by_role_flag',
	r2smft_fk_smf.`customer_configurable_permissions_by_project_by_role_flag` AS 'r2smft_fk_smf__customer_configurable_permissions_by_project_by_role_flag',
	r2smft_fk_smf.`customer_configurable_permissions_by_contact_flag` AS 'r2smft_fk_smf__customer_configurable_permissions_by_contact_flag',
	r2smft_fk_smf.`project_specific_flag` AS 'r2smft_fk_smf__project_specific_flag',
	r2smft_fk_smf.`disabled_flag` AS 'r2smft_fk_smf__disabled_flag',
	r2smft_fk_smf.`sort_order` AS 'r2smft_fk_smf__sort_order',

	r2smft.*

FROM `roles_to_software_module_function_templates` r2smft
	INNER JOIN `user_companies` r2smft_fk_uc ON r2smft.`user_company_id` = r2smft_fk_uc.`id`
	INNER JOIN `roles` r2smft_fk_r ON r2smft.`role_id` = r2smft_fk_r.`id`
	INNER JOIN `software_module_functions` r2smft_fk_smf ON r2smft.`software_module_function_id` = r2smft_fk_smf.`id`
WHERE r2smft.`user_company_id` = ?
AND r2smft.`role_id` = ?
AND r2smft.`software_module_function_id` = ?
";
		$arrValues = array($user_company_id, $role_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$roleToSoftwareModuleFunctionTemplate = self::instantiateOrm($database, 'RoleToSoftwareModuleFunctionTemplate', $row);
			/* @var $roleToSoftwareModuleFunctionTemplate RoleToSoftwareModuleFunctionTemplate */
			$roleToSoftwareModuleFunctionTemplate->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['r2smft_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'r2smft_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$roleToSoftwareModuleFunctionTemplate->setUserCompany($userCompany);

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['r2smft_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'r2smft_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$roleToSoftwareModuleFunctionTemplate->setRole($role);

			if (isset($row['software_module_function_id'])) {
				$software_module_function_id = $row['software_module_function_id'];
				$row['r2smft_fk_smf__id'] = $software_module_function_id;
				$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id, 'r2smft_fk_smf__');
				/* @var $softwareModuleFunction SoftwareModuleFunction */
				$softwareModuleFunction->convertPropertiesToData();
			} else {
				$softwareModuleFunction = false;
			}
			$roleToSoftwareModuleFunctionTemplate->setSoftwareModuleFunction($softwareModuleFunction);

			return $roleToSoftwareModuleFunctionTemplate;
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
	 * @param array $arrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToSoftwareModuleFunctionTemplatesByArrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList($database, $arrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList, Input $options=null)
	{
		if (empty($arrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList)) {
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
		// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToSoftwareModuleFunctionTemplate = new RoleToSoftwareModuleFunctionTemplate($database);
			$sqlOrderByColumns = $tmpRoleToSoftwareModuleFunctionTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList as $k => $arrTmp) {
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
		if (count($arrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	r2smft.*

FROM `roles_to_software_module_function_templates` r2smft
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToSoftwareModuleFunctionTemplatesByArrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList = array();
		while ($row = $db->fetch()) {
			$roleToSoftwareModuleFunctionTemplate = self::instantiateOrm($database, 'RoleToSoftwareModuleFunctionTemplate', $row);
			/* @var $roleToSoftwareModuleFunctionTemplate RoleToSoftwareModuleFunctionTemplate */
			$arrRolesToSoftwareModuleFunctionTemplatesByArrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList[] = $roleToSoftwareModuleFunctionTemplate;
		}

		$db->free_result();

		return $arrRolesToSoftwareModuleFunctionTemplatesByArrUserCompanyIdAndRoleIdAndSoftwareModuleFunctionIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `roles_to_software_module_function_templates_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToSoftwareModuleFunctionTemplatesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId = null;
		}

		$arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId = self::$_arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId;
		if (isset($arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId) && !empty($arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId)) {
			return $arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToSoftwareModuleFunctionTemplate = new RoleToSoftwareModuleFunctionTemplate($database);
			$sqlOrderByColumns = $tmpRoleToSoftwareModuleFunctionTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2smft.*

FROM `roles_to_software_module_function_templates` r2smft
WHERE r2smft.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$roleToSoftwareModuleFunctionTemplate = self::instantiateOrm($database, 'RoleToSoftwareModuleFunctionTemplate', $row);
			/* @var $roleToSoftwareModuleFunctionTemplate RoleToSoftwareModuleFunctionTemplate */
			$arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId[] = $roleToSoftwareModuleFunctionTemplate;
		}

		$db->free_result();

		self::$_arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId = $arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId;

		return $arrRolesToSoftwareModuleFunctionTemplatesByUserCompanyId;
	}

	/**
	 * Load by constraint `roles_to_software_module_function_templates_fk_r` foreign key (`role_id`) references `roles` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToSoftwareModuleFunctionTemplatesByRoleId($database, $role_id, Input $options=null)
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
			self::$_arrRolesToSoftwareModuleFunctionTemplatesByRoleId = null;
		}

		$arrRolesToSoftwareModuleFunctionTemplatesByRoleId = self::$_arrRolesToSoftwareModuleFunctionTemplatesByRoleId;
		if (isset($arrRolesToSoftwareModuleFunctionTemplatesByRoleId) && !empty($arrRolesToSoftwareModuleFunctionTemplatesByRoleId)) {
			return $arrRolesToSoftwareModuleFunctionTemplatesByRoleId;
		}

		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToSoftwareModuleFunctionTemplate = new RoleToSoftwareModuleFunctionTemplate($database);
			$sqlOrderByColumns = $tmpRoleToSoftwareModuleFunctionTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2smft.*

FROM `roles_to_software_module_function_templates` r2smft
WHERE r2smft.`role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToSoftwareModuleFunctionTemplatesByRoleId = array();
		while ($row = $db->fetch()) {
			$roleToSoftwareModuleFunctionTemplate = self::instantiateOrm($database, 'RoleToSoftwareModuleFunctionTemplate', $row);
			/* @var $roleToSoftwareModuleFunctionTemplate RoleToSoftwareModuleFunctionTemplate */
			$arrRolesToSoftwareModuleFunctionTemplatesByRoleId[] = $roleToSoftwareModuleFunctionTemplate;
		}

		$db->free_result();

		self::$_arrRolesToSoftwareModuleFunctionTemplatesByRoleId = $arrRolesToSoftwareModuleFunctionTemplatesByRoleId;

		return $arrRolesToSoftwareModuleFunctionTemplatesByRoleId;
	}

	/**
	 * Load by constraint `roles_to_software_module_function_templates_fk_smf` foreign key (`software_module_function_id`) references `software_module_functions` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $software_module_function_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId($database, $software_module_function_id, Input $options=null)
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
			self::$_arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId = null;
		}

		$arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId = self::$_arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId;
		if (isset($arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId) && !empty($arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId)) {
			return $arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId;
		}

		$software_module_function_id = (int) $software_module_function_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToSoftwareModuleFunctionTemplate = new RoleToSoftwareModuleFunctionTemplate($database);
			$sqlOrderByColumns = $tmpRoleToSoftwareModuleFunctionTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2smft.*

FROM `roles_to_software_module_function_templates` r2smft
WHERE r2smft.`software_module_function_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$arrValues = array($software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId = array();
		while ($row = $db->fetch()) {
			$roleToSoftwareModuleFunctionTemplate = self::instantiateOrm($database, 'RoleToSoftwareModuleFunctionTemplate', $row);
			/* @var $roleToSoftwareModuleFunctionTemplate RoleToSoftwareModuleFunctionTemplate */
			$arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId[] = $roleToSoftwareModuleFunctionTemplate;
		}

		$db->free_result();

		self::$_arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId = $arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId;

		return $arrRolesToSoftwareModuleFunctionTemplatesBySoftwareModuleFunctionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all roles_to_software_module_function_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRolesToSoftwareModuleFunctionTemplates($database, Input $options=null)
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
			self::$_arrAllRolesToSoftwareModuleFunctionTemplates = null;
		}

		$arrAllRolesToSoftwareModuleFunctionTemplates = self::$_arrAllRolesToSoftwareModuleFunctionTemplates;
		if (isset($arrAllRolesToSoftwareModuleFunctionTemplates) && !empty($arrAllRolesToSoftwareModuleFunctionTemplates)) {
			return $arrAllRolesToSoftwareModuleFunctionTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToSoftwareModuleFunctionTemplate = new RoleToSoftwareModuleFunctionTemplate($database);
			$sqlOrderByColumns = $tmpRoleToSoftwareModuleFunctionTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2smft.*

FROM `roles_to_software_module_function_templates` r2smft{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `user_company_id` ASC, `role_id` ASC, `software_module_function_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRolesToSoftwareModuleFunctionTemplates = array();
		while ($row = $db->fetch()) {
			$roleToSoftwareModuleFunctionTemplate = self::instantiateOrm($database, 'RoleToSoftwareModuleFunctionTemplate', $row);
			/* @var $roleToSoftwareModuleFunctionTemplate RoleToSoftwareModuleFunctionTemplate */
			$arrAllRolesToSoftwareModuleFunctionTemplates[] = $roleToSoftwareModuleFunctionTemplate;
		}

		$db->free_result();

		self::$_arrAllRolesToSoftwareModuleFunctionTemplates = $arrAllRolesToSoftwareModuleFunctionTemplates;

		return $arrAllRolesToSoftwareModuleFunctionTemplates;
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
INTO `roles_to_software_module_function_templates`
(`user_company_id`, `role_id`, `software_module_function_id`)
VALUES (?, ?, ?)
";
		$arrValues = array($this->user_company_id, $this->role_id, $this->software_module_function_id);
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

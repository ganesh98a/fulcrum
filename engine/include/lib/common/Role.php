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
 * Role.
 *
 * @category   Framework
 * @package    Role
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Role extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Role';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'roles';

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
	 * unique index `unique_role` (`role`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_role' => array(
			'role' => 'string'
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
		'id' => 'role_id',

		'role' => 'role',

		'role_description' => 'role_description',
		'project_specific_flag' => 'project_specific_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $role_id;

	public $role;

	public $role_description;
	public $project_specific_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_role;
	public $escaped_role_description;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_role_nl2br;
	public $escaped_role_description_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRoles;
	// role_id < 4 (1,2,3)
	protected static $_arrUserRoles;
	// role_id > 3
	protected static $_arrContactRoles;

	// Defined via role_groups_to_roles
	protected static $_arrProjectRoles;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='roles')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRoles()
	{
		if (isset(self::$_arrAllRoles)) {
			return self::$_arrAllRoles;
		} else {
			return null;
		}
	}

	public static function setArrAllRoles($arrAllRoles)
	{
		self::$_arrAllRoles = $arrAllRoles;
	}

	public static function getArrUserRoles()
	{
		if (isset(self::$_arrUserRoles)) {
			return self::$_arrUserRoles;
		} else {
			return null;
		}
	}

	public static function setArrUserRoles($arrUserRoles)
	{
		self::$_arrUserRoles = $arrUserRoles;
	}

	public static function getArrContactRoles()
	{
		if (isset(self::$_arrContactRoles)) {
			return self::$_arrContactRoles;
		} else {
			return null;
		}
	}

	public static function setArrContactRoles($arrContactRoles)
	{
		self::$_arrContactRoles = $arrContactRoles;
	}

	public static function getArrProjectRoles()
	{
		if (isset(self::$_arrProjectRoles)) {
			return self::$_arrProjectRoles;
		} else {
			return null;
		}
	}

	public static function setArrProjectRoles($arrProjectRoles)
	{
		self::$_arrProjectRoles = $arrProjectRoles;
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
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $role_id,$table='roles', $module='Role')
	{
		$role = parent::findById($database, $role_id, $table, $module);

		return $role;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRoleByIdExtended($database, $role_id)
	{
		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	r.*

FROM `roles` r
WHERE r.`id` = ?
";
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$role_id = $row['id'];
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$role->convertPropertiesToData();

			return $role;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_role` (`role`).
	 *
	 * @param string $database
	 * @param string $role
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRole($database, $role)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	r.*

FROM `roles` r
WHERE r.`role` = ?
";
		$arrValues = array($role);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$role_id = $row['id'];
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			return $role;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrRoleIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesByArrRoleIds($database, $arrRoleIds, Input $options=null)
	{
		if (empty($arrRoleIds)) {
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
		// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRole = new Role($database);
			$sqlOrderByColumns = $tmpRole->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrRoleIds as $k => $role_id) {
			$role_id = (int) $role_id;
			$arrRoleIds[$k] = $db->escape($role_id);
		}
		$csvRoleIds = join(',', $arrRoleIds);

		$query =
"
SELECT

	r.*

FROM `roles` r
WHERE r.`id` IN ($csvRoleIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRolesByCsvRoleIds = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$role->convertPropertiesToData();

			$arrRolesByCsvRoleIds[$role_id] = $role;
		}

		$db->free_result();

		return $arrRolesByCsvRoleIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all roles records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRoles($database, Input $options=null)
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
			self::$_arrAllRoles = null;
		}

		$arrAllRoles = self::$_arrAllRoles;
		if (isset($arrAllRoles) && !empty($arrAllRoles)) {
			return $arrAllRoles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRole = new Role($database);
			$sqlOrderByColumns = $tmpRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r.*

FROM `roles` r{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRoles = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$arrAllRoles[$role_id] = $role;
		}

		$db->free_result();

		self::$_arrAllRoles = $arrAllRoles;

		return $arrAllRoles;
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
INTO `roles`
(`role`, `role_description`, `project_specific_flag`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `role_description` = ?, `project_specific_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->role, $this->role_description, $this->project_specific_flag, $this->sort_order, $this->role_description, $this->project_specific_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$role_id = $db->insertId;
		$db->free_result();

		return $role_id;
	}

	// Save: insert ignore

	/**
	 * Load all user roles records (role_id < 4).
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return array
	 */
	public static function loadUserRoles($database, Input $options=null)
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
			self::$_arrUserRoles = null;
		}

		$arrUserRoles = self::$_arrUserRoles;
		if (isset($arrUserRoles) && !empty($arrUserRoles)) {
			return $arrUserRoles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY r.`id` ASC";
		//$sqlOrderBy = "\nORDER BY r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRole = new Role($database);
			$sqlOrderByColumns = $tmpRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r.*
FROM `roles` r
WHERE r.`id` < 4{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrUserRoles = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$arrUserRoles[$role_id] = $role;
		}

		$db->free_result();

		self::$_arrUserRoles = $arrUserRoles;

		return $arrUserRoles;
	}

	/**
	 * Load all contact roles records (role_id > 3).
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return array
	 */
	//public static function loadContactRoles($database, $forceLoadFlag=false, $useRoleAliasesFlag=false, $skipUserRoleFlag=false, $filter_by_recommended_roles_flag=false)
	//public static function loadContactRoles($database, $forceLoadFlag=false, $useRoleAliasesFlag=false, $skipUserRoleFlag=false)
	public static function loadContactRoles($database, Input $options=null, $roleTA='contact_roles')
	{
		$forceLoadFlag = false;
		$useRoleAliasesFlag=false;
		$skipUserRoleFlag=false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
			$useRoleAliasesFlag = $options->useRoleAliasesFlag;
			$skipUserRoleFlag = $options->skipUserRoleFlag;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrContactRoles = null;
		}

		$arrContactRoles = self::$_arrContactRoles;
		if (isset($arrContactRoles) && !empty($arrContactRoles)) {
			return $arrContactRoles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY r.`id` ASC";
		//$sqlOrderBy = "\nORDER BY r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRole = new Role($database);
			$sqlOrderByColumns = $tmpRole->constructSqlOrderByColumns($arrOrderByAttributes);

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

		//$arrContactRoles = self::loadRolesByRoleGroup($database, 'contact_roles', $useRoleAliasesFlag, $skipUserRoleFlag, $filter_by_recommended_roles_flag);
		//$arrContactRoles = self::loadRolesByRoleGroup($database, 'contact_roles', $useRoleAliasesFlag, $skipUserRoleFlag);
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = $roleTA;
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = $useRoleAliasesFlag;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = $skipUserRoleFlag;
		$arrContactRoles = self::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);
		self::$_arrContactRoles = $arrContactRoles;

		return $arrContactRoles;
		
	}

	/**
	 * Load project roles via role_groups_to_roles.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return array
	 */
	//public static function loadProjectRoles($database, $forceLoadFlag=false, $useRoleAliasesFlag=false, $skipUserRoleFlag=false, $filter_by_recommended_roles_flag=false)
	//public static function loadProjectRoles($database, $forceLoadFlag=false, $useRoleAliasesFlag=false, $skipUserRoleFlag=false)
	public static function loadProjectRoles($database, Input $options=null)
	{
		$forceLoadFlag = false;
		$useRoleAliasesFlag=false;
		$skipUserRoleFlag=false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
			$useRoleAliasesFlag = $options->useRoleAliasesFlag;
			$skipUserRoleFlag = $options->skipUserRoleFlag;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrProjectRoles = null;
		}

		$arrProjectRoles = self::$_arrProjectRoles;
		if (isset($arrProjectRoles) && !empty($arrProjectRoles)) {
			return $arrProjectRoles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY r.`id` ASC";
		//$sqlOrderBy = "\nORDER BY r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRole = new Role($database);
			$sqlOrderByColumns = $tmpRole->constructSqlOrderByColumns($arrOrderByAttributes);

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

		//$arrProjectRoles = self::loadRolesByRoleGroup($database, 'project_roles', $useRoleAliasesFlag, $skipUserRoleFlag, $filter_by_recommended_roles_flag);
		//$arrProjectRoles = self::loadRolesByRoleGroup($database, 'project_roles', $useRoleAliasesFlag, $skipUserRoleFlag);
		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'project_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = $useRoleAliasesFlag;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = $skipUserRoleFlag;
		$arrProjectRoles = self::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);
		self::$_arrProjectRoles = $arrProjectRoles;

		return $arrProjectRoles;
	}

	public static function determineProjectSpecificityOfRole($database, $role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$role_id = (int) $role_id;

		$query =
"
SELECT
	r.`project_specific_flag`

FROM `roles` r
WHERE r.`id` = ?
";
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if (isset($row) && !empty($row)) {
			$project_specific_flag = $row['project_specific_flag'];
		} else {
			$project_specific_flag = null;
		}

		return $project_specific_flag;
	}

	//public static function loadRolesByRoleGroup($database, $role_group = 'project_team_members', $useRoleAliasesFlag=false, $skipUserRoleFlag=false, $filter_by_recommended_roles_flag=false)
	//public static function loadRolesByRoleGroup($database, $role_group = 'project_team_members', $useRoleAliasesFlag=false, $skipUserRoleFlag=false)
	public static function loadRolesByRoleGroup($database, Input $options=null, $whereIN='')
	{
		$role_group = 'project_team_members';
		$useRoleAliasesFlag = false;
		$skipUserRoleFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
			$role_group = $options->role_group;
			$useRoleAliasesFlag = $options->useRoleAliasesFlag;
			$skipUserRoleFlag = $options->skipUserRoleFlag;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY r.`sort_order` ASC, r.`role` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRole = new Role($database);
			$sqlOrderByColumns = $tmpRole->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$joinFilter = '';
		/*
		if (isset($filter_by_recommended_roles_flag) && $filter_by_recommended_roles_flag) {
			$joinFilter = "INNER JOIN `software_module_role_recommendations` smrr ON r.`role` = smrr.`recommend_role_id` ";
		} else {

		}
		$joinFilter = '';
		*/

		$query =
"
SELECT
	rg2r.`role_alias`,
	r.*

FROM `roles` r
	INNER JOIN `role_groups_to_roles` rg2r ON r.`id` = rg2r.`role_id`
	INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id`
	$joinFilter
WHERE rg.`role_group` = ?$whereIN{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC
		$arrValues = array($role_group);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesByRoleGroup = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role_alias = trim($row['role_alias']);

			// Potentially skip the "User" role
			if ($role_id == 3) {
				if ($skipUserRoleFlag) {
					continue;
				}
			}

			// Potentially use role aliases
			if ($useRoleAliasesFlag) {
				if (isset($role_alias) && !empty($role_alias)) {
					$row['role'] = $role_alias;
				}
			}

			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$arrRolesByRoleGroup[$role_id] = $role;
		}

		$db->free_result();

		return $arrRolesByRoleGroup;
	}

	public static function loadAssignedRolesByContactId($database, $contact_id, Input $options=null)
	{
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY r.`id` ASC";
		//$sqlOrderBy = "\nORDER BY r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRole = new Role($database);
			$sqlOrderByColumns = $tmpRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r.*

FROM `roles` r
	INNER JOIN `contacts_to_roles` c2r ON r.`id` = c2r.`role_id`
WHERE c2r.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAssignedRolesByContactId = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$arrAssignedRolesByContactId[$role_id] = $role;
		}
		$db->free_result();

		return $arrAssignedRolesByContactId;
	}


	/**
	* Load Delay Roles
	* @param database, options
	* @return 
	*/

	public static function loadDelayRoles($database, Input $options=null)
	{
		$forceLoadFlag = false;
		$useRoleAliasesFlag=false;
		$skipUserRoleFlag=false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
			$useRoleAliasesFlag = $options->useRoleAliasesFlag;
			$skipUserRoleFlag = $options->skipUserRoleFlag;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrProjectRoles = null;
		}

		$arrProjectRoles = self::$_arrProjectRoles;
		if (isset($arrProjectRoles) && !empty($arrProjectRoles)) {
			return $arrProjectRoles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `role` ASC, `role_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY r.`id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRole = new Role($database);
			$sqlOrderByColumns = $tmpRole->constructSqlOrderByColumns($arrOrderByAttributes);
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

		$loadRolesByRoleGroupOptions = new Input();
		$loadRolesByRoleGroupOptions->role_group = 'delay_roles';
		$loadRolesByRoleGroupOptions->useRoleAliasesFlag = $useRoleAliasesFlag;
		$loadRolesByRoleGroupOptions->skipUserRoleFlag = $skipUserRoleFlag;
		$arrProjectRoles = self::loadRolesByRoleGroup($database, $loadRolesByRoleGroupOptions);
		self::$_arrProjectRoles = $arrProjectRoles;

		return $arrProjectRoles;
	}

	//To get all Project Roles
	public static function projectspecificroles($database)
	{
		$db = DBI::getInstance($database);
		$projectroles = array();
        $query = "SELECT rg2r.`role_alias`, r.* FROM `roles` r INNER JOIN `role_groups_to_roles` rg2r ON r.`id` = rg2r.`role_id` INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id` WHERE rg.`role_group` ='project_roles' and r.`id`!='3' ORDER BY r.`sort_order` ASC, r.`role` ASC ";
        $db->execute($query);
		while($row = $db->fetch())
		{
		   	$key = $row['id'];
		   	$val = $row['role'];
		   	$projectroles[$key] = $val;
		}
		return $projectroles;
		

	}

	// To load the roles of a contact_id
	public static function loadContactRolesAgainstContactId($database,$contact_id,$project_id)
	{
		$db = DBI::getInstance($database);
		$projectroles = array();
        $query = "SELECT  p2c2r.contact_id, GROUP_CONCAT(r.role) as role , GROUP_CONCAT(r.id) as role_ids FROM `projects_to_contacts_to_roles` as p2c2r inner join roles as r on r.id=p2c2r.role_id WHERE p2c2r.`project_id` = ? AND p2c2r.`contact_id` = ? and p2c2r.role_id <> 3  ";
        $arrValues = array($project_id,$contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		
		while($row = $db->fetch())
		{
		   	$key = $row['contact_id'];
		   	$val = $row['role'];
		   	$role_ids = $row['role_ids'];
		   	$projectroles[$key]['roles'] = $val;
		   	$projectroles[$key]['roleids'] = $role_ids;
		}
		return $projectroles;
	}



}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

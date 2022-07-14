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
 * RoleGroupToRole.
 *
 * @category   Framework
 * @package    RoleGroupToRole
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RoleGroupToRole extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RoleGroupToRole';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'role_groups_to_roles';

	/**
	 * primary key (`role_group_id`,`role_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'role_group_id' => 'int',
		'role_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_role_group_to_role_via_primary_key' => array(
			'role_group_id' => 'int',
			'role_id' => 'int'
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
		'role_group_id' => 'role_group_id',
		'role_id' => 'role_id',

		'role_alias' => 'role_alias',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $role_group_id;
	public $role_id;

	public $role_alias;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_role_alias;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_role_alias_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRoleGroupsToRolesByRoleGroupId;
	protected static $_arrRoleGroupsToRolesByRoleId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRoleGroupsToRoles;

	// Foreign Key Objects
	private $_roleGroup;
	private $_role;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='role_groups_to_roles')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getRoleGroup()
	{
		if (isset($this->_roleGroup)) {
			return $this->_roleGroup;
		} else {
			return null;
		}
	}

	public function setRoleGroup($roleGroup)
	{
		$this->_roleGroup = $roleGroup;
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrRoleGroupsToRolesByRoleGroupId()
	{
		if (isset(self::$_arrRoleGroupsToRolesByRoleGroupId)) {
			return self::$_arrRoleGroupsToRolesByRoleGroupId;
		} else {
			return null;
		}
	}

	public static function setArrRoleGroupsToRolesByRoleGroupId($arrRoleGroupsToRolesByRoleGroupId)
	{
		self::$_arrRoleGroupsToRolesByRoleGroupId = $arrRoleGroupsToRolesByRoleGroupId;
	}

	public static function getArrRoleGroupsToRolesByRoleId()
	{
		if (isset(self::$_arrRoleGroupsToRolesByRoleId)) {
			return self::$_arrRoleGroupsToRolesByRoleId;
		} else {
			return null;
		}
	}

	public static function setArrRoleGroupsToRolesByRoleId($arrRoleGroupsToRolesByRoleId)
	{
		self::$_arrRoleGroupsToRolesByRoleId = $arrRoleGroupsToRolesByRoleId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRoleGroupsToRoles()
	{
		if (isset(self::$_arrAllRoleGroupsToRoles)) {
			return self::$_arrAllRoleGroupsToRoles;
		} else {
			return null;
		}
	}

	public static function setArrAllRoleGroupsToRoles($arrAllRoleGroupsToRoles)
	{
		self::$_arrAllRoleGroupsToRoles = $arrAllRoleGroupsToRoles;
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
	 * Find by primary key (`role_group_id`,`role_id`).
	 *
	 * @param string $database
	 * @param int $role_group_id
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRoleGroupIdAndRoleId($database, $role_group_id, $role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rg2r.*

FROM `role_groups_to_roles` rg2r
WHERE rg2r.`role_group_id` = ?
AND rg2r.`role_id` = ?
";
		$arrValues = array($role_group_id, $role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$roleGroupToRole = self::instantiateOrm($database, 'RoleGroupToRole', $row);
			/* @var $roleGroupToRole RoleGroupToRole */
			return $roleGroupToRole;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`role_group_id`,`role_id`) Extended.
	 *
	 * @param string $database
	 * @param int $role_group_id
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRoleGroupIdAndRoleIdExtended($database, $role_group_id, $role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	rg2r_fk_rg.`id` AS 'rg2r_fk_rg__role_group_id',
	rg2r_fk_rg.`role_group` AS 'rg2r_fk_rg__role_group',
	rg2r_fk_rg.`role_group_description` AS 'rg2r_fk_rg__role_group_description',
	rg2r_fk_rg.`project_specific_flag` AS 'rg2r_fk_rg__project_specific_flag',
	rg2r_fk_rg.`sort_order` AS 'rg2r_fk_rg__sort_order',

	rg2r_fk_r.`id` AS 'rg2r_fk_r__role_id',
	rg2r_fk_r.`role` AS 'rg2r_fk_r__role',
	rg2r_fk_r.`role_description` AS 'rg2r_fk_r__role_description',
	rg2r_fk_r.`project_specific_flag` AS 'rg2r_fk_r__project_specific_flag',
	rg2r_fk_r.`sort_order` AS 'rg2r_fk_r__sort_order',

	rg2r.*

FROM `role_groups_to_roles` rg2r
	INNER JOIN `role_groups` rg2r_fk_rg ON rg2r.`role_group_id` = rg2r_fk_rg.`id`
	INNER JOIN `roles` rg2r_fk_r ON rg2r.`role_id` = rg2r_fk_r.`id`
WHERE rg2r.`role_group_id` = ?
AND rg2r.`role_id` = ?
";
		$arrValues = array($role_group_id, $role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$roleGroupToRole = self::instantiateOrm($database, 'RoleGroupToRole', $row);
			/* @var $roleGroupToRole RoleGroupToRole */
			$roleGroupToRole->convertPropertiesToData();

			if (isset($row['role_group_id'])) {
				$role_group_id = $row['role_group_id'];
				$row['rg2r_fk_rg__id'] = $role_group_id;
				$roleGroup = self::instantiateOrm($database, 'RoleGroup', $row, null, $role_group_id, 'rg2r_fk_rg__');
				/* @var $roleGroup RoleGroup */
				$roleGroup->convertPropertiesToData();
			} else {
				$roleGroup = false;
			}
			$roleGroupToRole->setRoleGroup($roleGroup);

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['rg2r_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'rg2r_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$roleGroupToRole->setRole($role);

			return $roleGroupToRole;
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
	 * @param array $arrRoleGroupIdAndRoleIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRoleGroupsToRolesByArrRoleGroupIdAndRoleIdList($database, $arrRoleGroupIdAndRoleIdList, Input $options=null)
	{
		if (empty($arrRoleGroupIdAndRoleIdList)) {
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
		// ORDER BY `role_group_id` ASC, `role_id` ASC, `role_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rg2r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleGroupToRole = new RoleGroupToRole($database);
			$sqlOrderByColumns = $tmpRoleGroupToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrRoleGroupIdAndRoleIdList as $k => $arrTmp) {
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
		if (count($arrRoleGroupIdAndRoleIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	rg2r.*

FROM `role_groups_to_roles` rg2r
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRoleGroupsToRolesByArrRoleGroupIdAndRoleIdList = array();
		while ($row = $db->fetch()) {
			$roleGroupToRole = self::instantiateOrm($database, 'RoleGroupToRole', $row);
			/* @var $roleGroupToRole RoleGroupToRole */
			$arrRoleGroupsToRolesByArrRoleGroupIdAndRoleIdList[] = $roleGroupToRole;
		}

		$db->free_result();

		return $arrRoleGroupsToRolesByArrRoleGroupIdAndRoleIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `role_groups_to_roles_fk_rg` foreign key (`role_group_id`) references `role_groups` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $role_group_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRoleGroupsToRolesByRoleGroupId($database, $role_group_id, Input $options=null)
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
			self::$_arrRoleGroupsToRolesByRoleGroupId = null;
		}

		$arrRoleGroupsToRolesByRoleGroupId = self::$_arrRoleGroupsToRolesByRoleGroupId;
		if (isset($arrRoleGroupsToRolesByRoleGroupId) && !empty($arrRoleGroupsToRolesByRoleGroupId)) {
			return $arrRoleGroupsToRolesByRoleGroupId;
		}

		$role_group_id = (int) $role_group_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_group_id` ASC, `role_id` ASC, `role_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rg2r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleGroupToRole = new RoleGroupToRole($database);
			$sqlOrderByColumns = $tmpRoleGroupToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rg2r.*

FROM `role_groups_to_roles` rg2r
WHERE rg2r.`role_group_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_group_id` ASC, `role_id` ASC, `role_alias` ASC, `sort_order` ASC
		$arrValues = array($role_group_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRoleGroupsToRolesByRoleGroupId = array();
		while ($row = $db->fetch()) {
			$roleGroupToRole = self::instantiateOrm($database, 'RoleGroupToRole', $row);
			/* @var $roleGroupToRole RoleGroupToRole */
			$arrRoleGroupsToRolesByRoleGroupId[] = $roleGroupToRole;
		}

		$db->free_result();

		self::$_arrRoleGroupsToRolesByRoleGroupId = $arrRoleGroupsToRolesByRoleGroupId;

		return $arrRoleGroupsToRolesByRoleGroupId;
	}

	/**
	 * Load by constraint `role_groups_to_roles_fk_r` foreign key (`role_id`) references `roles` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRoleGroupsToRolesByRoleId($database, $role_id, Input $options=null)
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
			self::$_arrRoleGroupsToRolesByRoleId = null;
		}

		$arrRoleGroupsToRolesByRoleId = self::$_arrRoleGroupsToRolesByRoleId;
		if (isset($arrRoleGroupsToRolesByRoleId) && !empty($arrRoleGroupsToRolesByRoleId)) {
			return $arrRoleGroupsToRolesByRoleId;
		}

		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_group_id` ASC, `role_id` ASC, `role_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rg2r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleGroupToRole = new RoleGroupToRole($database);
			$sqlOrderByColumns = $tmpRoleGroupToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rg2r.*

FROM `role_groups_to_roles` rg2r
WHERE rg2r.`role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_group_id` ASC, `role_id` ASC, `role_alias` ASC, `sort_order` ASC
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRoleGroupsToRolesByRoleId = array();
		while ($row = $db->fetch()) {
			$roleGroupToRole = self::instantiateOrm($database, 'RoleGroupToRole', $row);
			/* @var $roleGroupToRole RoleGroupToRole */
			$arrRoleGroupsToRolesByRoleId[] = $roleGroupToRole;
		}

		$db->free_result();

		self::$_arrRoleGroupsToRolesByRoleId = $arrRoleGroupsToRolesByRoleId;

		return $arrRoleGroupsToRolesByRoleId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all role_groups_to_roles records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRoleGroupsToRoles($database, Input $options=null)
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
			self::$_arrAllRoleGroupsToRoles = null;
		}

		$arrAllRoleGroupsToRoles = self::$_arrAllRoleGroupsToRoles;
		if (isset($arrAllRoleGroupsToRoles) && !empty($arrAllRoleGroupsToRoles)) {
			return $arrAllRoleGroupsToRoles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_group_id` ASC, `role_id` ASC, `role_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rg2r.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleGroupToRole = new RoleGroupToRole($database);
			$sqlOrderByColumns = $tmpRoleGroupToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rg2r.*

FROM `role_groups_to_roles` rg2r{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_group_id` ASC, `role_id` ASC, `role_alias` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRoleGroupsToRoles = array();
		while ($row = $db->fetch()) {
			$roleGroupToRole = self::instantiateOrm($database, 'RoleGroupToRole', $row);
			/* @var $roleGroupToRole RoleGroupToRole */
			$arrAllRoleGroupsToRoles[] = $roleGroupToRole;
		}

		$db->free_result();

		self::$_arrAllRoleGroupsToRoles = $arrAllRoleGroupsToRoles;

		return $arrAllRoleGroupsToRoles;
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
INTO `role_groups_to_roles`
(`role_group_id`, `role_id`, `role_alias`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `role_alias` = ?, `sort_order` = ?
";
		$arrValues = array($this->role_group_id, $this->role_id, $this->role_alias, $this->sort_order, $this->role_alias, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$role_group_to_role_id = $db->insertId;
		$db->free_result();

		return $role_group_to_role_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

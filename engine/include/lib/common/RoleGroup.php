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
 * RoleGroup.
 *
 * @category   Framework
 * @package    RoleGroup
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RoleGroup extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RoleGroup';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'role_groups';

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
	 * unique index `role_group` (`role_group`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'role_group' => array(
			'role_group' => 'string'
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
		'id' => 'role_group_id',

		'role_group' => 'role_group',

		'role_group_description' => 'role_group_description',
		'project_specific_flag' => 'project_specific_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $role_group_id;

	public $role_group;

	public $role_group_description;
	public $project_specific_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_role_group;
	public $escaped_role_group_description;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_role_group_nl2br;
	public $escaped_role_group_description_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRoleGroups;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='role_groups')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRoleGroups()
	{
		if (isset(self::$_arrAllRoleGroups)) {
			return self::$_arrAllRoleGroups;
		} else {
			return null;
		}
	}

	public static function setArrAllRoleGroups($arrAllRoleGroups)
	{
		self::$_arrAllRoleGroups = $arrAllRoleGroups;
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
	 * @param int $role_group_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $role_group_id,$table='role_groups', $module='RoleGroup')
	{
		$roleGroup = parent::findById($database, $role_group_id,  $table, $module);

		return $roleGroup;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $role_group_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRoleGroupByIdExtended($database, $role_group_id)
	{
		$role_group_id = (int) $role_group_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rg.*

FROM `role_groups` rg
WHERE rg.`id` = ?
";
		$arrValues = array($role_group_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$role_group_id = $row['id'];
			$roleGroup = self::instantiateOrm($database, 'RoleGroup', $row, null, $role_group_id);
			/* @var $roleGroup RoleGroup */
			$roleGroup->convertPropertiesToData();

			return $roleGroup;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `role_group` (`role_group`).
	 *
	 * @param string $database
	 * @param string $role_group
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRoleGroup($database, $role_group)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rg.*

FROM `role_groups` rg
WHERE rg.`role_group` = ?
";
		$arrValues = array($role_group);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$role_group_id = $row['id'];
			$roleGroup = self::instantiateOrm($database, 'RoleGroup', $row, null, $role_group_id);
			/* @var $roleGroup RoleGroup */
			return $roleGroup;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrRoleGroupIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRoleGroupsByArrRoleGroupIds($database, $arrRoleGroupIds, Input $options=null)
	{
		if (empty($arrRoleGroupIds)) {
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
		// ORDER BY `id` ASC, `role_group` ASC, `role_group_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rg.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleGroup = new RoleGroup($database);
			$sqlOrderByColumns = $tmpRoleGroup->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrRoleGroupIds as $k => $role_group_id) {
			$role_group_id = (int) $role_group_id;
			$arrRoleGroupIds[$k] = $db->escape($role_group_id);
		}
		$csvRoleGroupIds = join(',', $arrRoleGroupIds);

		$query =
"
SELECT

	rg.*

FROM `role_groups` rg
WHERE rg.`id` IN ($csvRoleGroupIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRoleGroupsByCsvRoleGroupIds = array();
		while ($row = $db->fetch()) {
			$role_group_id = $row['id'];
			$roleGroup = self::instantiateOrm($database, 'RoleGroup', $row, null, $role_group_id);
			/* @var $roleGroup RoleGroup */
			$roleGroup->convertPropertiesToData();

			$arrRoleGroupsByCsvRoleGroupIds[$role_group_id] = $roleGroup;
		}

		$db->free_result();

		return $arrRoleGroupsByCsvRoleGroupIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all role_groups records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRoleGroups($database, Input $options=null)
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
			self::$_arrAllRoleGroups = null;
		}

		$arrAllRoleGroups = self::$_arrAllRoleGroups;
		if (isset($arrAllRoleGroups) && !empty($arrAllRoleGroups)) {
			return $arrAllRoleGroups;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `role_group` ASC, `role_group_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rg.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleGroup = new RoleGroup($database);
			$sqlOrderByColumns = $tmpRoleGroup->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rg.*

FROM `role_groups` rg{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `role_group` ASC, `role_group_description` ASC, `project_specific_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRoleGroups = array();
		while ($row = $db->fetch()) {
			$role_group_id = $row['id'];
			$roleGroup = self::instantiateOrm($database, 'RoleGroup', $row, null, $role_group_id);
			/* @var $roleGroup RoleGroup */
			$arrAllRoleGroups[$role_group_id] = $roleGroup;
		}

		$db->free_result();

		self::$_arrAllRoleGroups = $arrAllRoleGroups;

		return $arrAllRoleGroups;
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
INTO `role_groups`
(`role_group`, `role_group_description`, `project_specific_flag`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `role_group_description` = ?, `project_specific_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->role_group, $this->role_group_description, $this->project_specific_flag, $this->sort_order, $this->role_group_description, $this->project_specific_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$role_group_id = $db->insertId;
		$db->free_result();

		return $role_group_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

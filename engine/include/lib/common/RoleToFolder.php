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
 * RoleToFolder.
 *
 * @category   Framework
 * @package    RoleToFolder
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RoleToFolder extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RoleToFolder';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'roles_to_folders';

	/**
	 * primary key (`role_id`,`file_manager_folder_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'role_id' => 'int',
		'file_manager_folder_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_role_to_folder_via_primary_key' => array(
			'role_id' => 'int',
			'file_manager_folder_id' => 'int'
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
		'role_id' => 'role_id',
		'file_manager_folder_id' => 'file_manager_folder_id',

		'grant_privileges_privilege' => 'grant_privileges_privilege',
		'rename_privilege' => 'rename_privilege',
		'upload_privilege' => 'upload_privilege',
		'move_privilege' => 'move_privilege',
		'delete_privilege' => 'delete_privilege'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $role_id;
	public $file_manager_folder_id;

	public $grant_privileges_privilege;
	public $rename_privilege;
	public $upload_privilege;
	public $move_privilege;
	public $delete_privilege;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRolesToFoldersByRoleId;
	protected static $_arrRolesToFoldersByFileManagerFolderId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRolesToFolders;

	// Foreign Key Objects
	private $_role;
	private $_fileManagerFolder;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='roles_to_folders')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
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

	public function getFileManagerFolder()
	{
		if (isset($this->_fileManagerFolder)) {
			return $this->_fileManagerFolder;
		} else {
			return null;
		}
	}

	public function setFileManagerFolder($fileManagerFolder)
	{
		$this->_fileManagerFolder = $fileManagerFolder;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrRolesToFoldersByRoleId()
	{
		if (isset(self::$_arrRolesToFoldersByRoleId)) {
			return self::$_arrRolesToFoldersByRoleId;
		} else {
			return null;
		}
	}

	public static function setArrRolesToFoldersByRoleId($arrRolesToFoldersByRoleId)
	{
		self::$_arrRolesToFoldersByRoleId = $arrRolesToFoldersByRoleId;
	}

	public static function getArrRolesToFoldersByFileManagerFolderId()
	{
		if (isset(self::$_arrRolesToFoldersByFileManagerFolderId)) {
			return self::$_arrRolesToFoldersByFileManagerFolderId;
		} else {
			return null;
		}
	}

	public static function setArrRolesToFoldersByFileManagerFolderId($arrRolesToFoldersByFileManagerFolderId)
	{
		self::$_arrRolesToFoldersByFileManagerFolderId = $arrRolesToFoldersByFileManagerFolderId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRolesToFolders()
	{
		if (isset(self::$_arrAllRolesToFolders)) {
			return self::$_arrAllRolesToFolders;
		} else {
			return null;
		}
	}

	public static function setArrAllRolesToFolders($arrAllRolesToFolders)
	{
		self::$_arrAllRolesToFolders = $arrAllRolesToFolders;
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
	 * Find by primary key (`role_id`,`file_manager_folder_id`).
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRoleIdAndFileManagerFolderId($database, $role_id, $file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	r2folders.*

FROM `roles_to_folders` r2folders
WHERE r2folders.`role_id` = ?
AND r2folders.`file_manager_folder_id` = ?
";
		$arrValues = array($role_id, $file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$roleToFolder = self::instantiateOrm($database, 'RoleToFolder', $row);
			/* @var $roleToFolder RoleToFolder */
			return $roleToFolder;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`role_id`,`file_manager_folder_id`) Extended.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRoleIdAndFileManagerFolderIdExtended($database, $role_id, $file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	r2folders_fk_r.`id` AS 'r2folders_fk_r__role_id',
	r2folders_fk_r.`role` AS 'r2folders_fk_r__role',
	r2folders_fk_r.`role_description` AS 'r2folders_fk_r__role_description',
	r2folders_fk_r.`project_specific_flag` AS 'r2folders_fk_r__project_specific_flag',
	r2folders_fk_r.`sort_order` AS 'r2folders_fk_r__sort_order',

	r2folders_fk_fmfolders.`id` AS 'r2folders_fk_fmfolders__file_manager_folder_id',
	r2folders_fk_fmfolders.`user_company_id` AS 'r2folders_fk_fmfolders__user_company_id',
	r2folders_fk_fmfolders.`contact_id` AS 'r2folders_fk_fmfolders__contact_id',
	r2folders_fk_fmfolders.`project_id` AS 'r2folders_fk_fmfolders__project_id',
	r2folders_fk_fmfolders.`virtual_file_path` AS 'r2folders_fk_fmfolders__virtual_file_path',
	r2folders_fk_fmfolders.`virtual_file_path_sha1` AS 'r2folders_fk_fmfolders__virtual_file_path_sha1',
	r2folders_fk_fmfolders.`modified` AS 'r2folders_fk_fmfolders__modified',
	r2folders_fk_fmfolders.`created` AS 'r2folders_fk_fmfolders__created',
	r2folders_fk_fmfolders.`deleted_flag` AS 'r2folders_fk_fmfolders__deleted_flag',
	r2folders_fk_fmfolders.`directly_deleted_flag` AS 'r2folders_fk_fmfolders__directly_deleted_flag',

	r2folders.*

FROM `roles_to_folders` r2folders
	INNER JOIN `roles` r2folders_fk_r ON r2folders.`role_id` = r2folders_fk_r.`id`
	INNER JOIN `file_manager_folders` r2folders_fk_fmfolders ON r2folders.`file_manager_folder_id` = r2folders_fk_fmfolders.`id`
WHERE r2folders.`role_id` = ?
AND r2folders.`file_manager_folder_id` = ?
";
		$arrValues = array($role_id, $file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$roleToFolder = self::instantiateOrm($database, 'RoleToFolder', $row);
			/* @var $roleToFolder RoleToFolder */
			$roleToFolder->convertPropertiesToData();

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['r2folders_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'r2folders_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$roleToFolder->setRole($role);

			if (isset($row['file_manager_folder_id'])) {
				$file_manager_folder_id = $row['file_manager_folder_id'];
				$row['r2folders_fk_fmfolders__id'] = $file_manager_folder_id;
				$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'r2folders_fk_fmfolders__');
				/* @var $fileManagerFolder FileManagerFolder */
				$fileManagerFolder->convertPropertiesToData();
			} else {
				$fileManagerFolder = false;
			}
			$roleToFolder->setFileManagerFolder($fileManagerFolder);

			return $roleToFolder;
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
	 * @param array $arrRoleIdAndFileManagerFolderIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToFoldersByArrRoleIdAndFileManagerFolderIdList($database, $arrRoleIdAndFileManagerFolderIdList, Input $options=null)
	{
		if (empty($arrRoleIdAndFileManagerFolderIdList)) {
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
		// ORDER BY `role_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToFolder = new RoleToFolder($database);
			$sqlOrderByColumns = $tmpRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrRoleIdAndFileManagerFolderIdList as $k => $arrTmp) {
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
		if (count($arrRoleIdAndFileManagerFolderIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	r2folders.*

FROM `roles_to_folders` r2folders
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToFoldersByArrRoleIdAndFileManagerFolderIdList = array();
		while ($row = $db->fetch()) {
			$roleToFolder = self::instantiateOrm($database, 'RoleToFolder', $row);
			/* @var $roleToFolder RoleToFolder */
			$arrRolesToFoldersByArrRoleIdAndFileManagerFolderIdList[] = $roleToFolder;
		}

		$db->free_result();

		return $arrRolesToFoldersByArrRoleIdAndFileManagerFolderIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `roles_to_folders_fk_r` foreign key (`role_id`) references `roles` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToFoldersByRoleId($database, $role_id, Input $options=null)
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
			self::$_arrRolesToFoldersByRoleId = null;
		}

		$arrRolesToFoldersByRoleId = self::$_arrRolesToFoldersByRoleId;
		if (isset($arrRolesToFoldersByRoleId) && !empty($arrRolesToFoldersByRoleId)) {
			return $arrRolesToFoldersByRoleId;
		}

		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToFolder = new RoleToFolder($database);
			$sqlOrderByColumns = $tmpRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2folders.*

FROM `roles_to_folders` r2folders
WHERE r2folders.`role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToFoldersByRoleId = array();
		while ($row = $db->fetch()) {
			$roleToFolder = self::instantiateOrm($database, 'RoleToFolder', $row);
			/* @var $roleToFolder RoleToFolder */
			$arrRolesToFoldersByRoleId[] = $roleToFolder;
		}

		$db->free_result();

		self::$_arrRolesToFoldersByRoleId = $arrRolesToFoldersByRoleId;

		return $arrRolesToFoldersByRoleId;
	}

	/**
	 * Load by constraint `roles_to_folders_fk_fmfolders` foreign key (`file_manager_folder_id`) references `file_manager_folders` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToFoldersByFileManagerFolderId($database, $file_manager_folder_id, Input $options=null)
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
			self::$_arrRolesToFoldersByFileManagerFolderId = null;
		}

		$arrRolesToFoldersByFileManagerFolderId = self::$_arrRolesToFoldersByFileManagerFolderId;
		if (isset($arrRolesToFoldersByFileManagerFolderId) && !empty($arrRolesToFoldersByFileManagerFolderId)) {
			return $arrRolesToFoldersByFileManagerFolderId;
		}

		$file_manager_folder_id = (int) $file_manager_folder_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToFolder = new RoleToFolder($database);
			$sqlOrderByColumns = $tmpRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2folders.*

FROM `roles_to_folders` r2folders
WHERE r2folders.`file_manager_folder_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToFoldersByFileManagerFolderId = array();
		while ($row = $db->fetch()) {
			$roleToFolder = self::instantiateOrm($database, 'RoleToFolder', $row);
			/* @var $roleToFolder RoleToFolder */
			$arrRolesToFoldersByFileManagerFolderId[] = $roleToFolder;
		}

		$db->free_result();

		self::$_arrRolesToFoldersByFileManagerFolderId = $arrRolesToFoldersByFileManagerFolderId;

		return $arrRolesToFoldersByFileManagerFolderId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all roles_to_folders records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRolesToFolders($database, Input $options=null)
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
			self::$_arrAllRolesToFolders = null;
		}

		$arrAllRolesToFolders = self::$_arrAllRolesToFolders;
		if (isset($arrAllRolesToFolders) && !empty($arrAllRolesToFolders)) {
			return $arrAllRolesToFolders;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToFolder = new RoleToFolder($database);
			$sqlOrderByColumns = $tmpRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2folders.*

FROM `roles_to_folders` r2folders{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRolesToFolders = array();
		while ($row = $db->fetch()) {
			$roleToFolder = self::instantiateOrm($database, 'RoleToFolder', $row);
			/* @var $roleToFolder RoleToFolder */
			$arrAllRolesToFolders[] = $roleToFolder;
		}

		$db->free_result();

		self::$_arrAllRolesToFolders = $arrAllRolesToFolders;

		return $arrAllRolesToFolders;
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
INTO `roles_to_folders`
(`role_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `grant_privileges_privilege` = ?, `rename_privilege` = ?, `upload_privilege` = ?, `move_privilege` = ?, `delete_privilege` = ?
";
		$arrValues = array($this->role_id, $this->file_manager_folder_id, $this->grant_privileges_privilege, $this->rename_privilege, $this->upload_privilege, $this->move_privilege, $this->delete_privilege, $this->grant_privileges_privilege, $this->rename_privilege, $this->upload_privilege, $this->move_privilege, $this->delete_privilege);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$role_to_folder_id = $db->insertId;
		$db->free_result();

		return $role_to_folder_id;
	}

	// Save: insert ignore

	public static function loadContactsToRolesByUserId($database, $user_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT r2f.*, r.`role` 'role_name'
FROM `folders` c, `roles_to_folders` r2f, `roles` r,
WHERE c.`user_id` = ?
AND c.`id` = r2f.`file_manager_folder_id`
AND r2f.`role_id = r.`id`
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToRolesList = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['folder_id'];
			$role_id = $row['role_id'];
			$arrContactsToRolesList[$file_manager_folder_id][] = $row;
		}
		$db->free_result();

		return $arrContactsToRolesList;
	}

	public static function loadAssignedRolesByFileManagerFolderId($database, $file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	r.*
FROM `roles_folders` r2f
	INNER JOIN `roles` r ON r2f.`role_id` = r.`id`
WHERE r2f.`file_manager_folder_id` = ?

";
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAssignedRolesByFileManagerFolderId = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];
			$role = self::instantiateOrm($database, 'Role', $row, null, $role_id);
			/* @var $role Role */
			$arrAssignedRolesByFileManagerFolderId[$role_id] = $role;
		}
		$db->free_result();

		return $arrAssignedRolesByFileManagerFolderId;
	}

	/**
	 * INSERT a single record into an "association table" (join-box).
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param int $file_manager_folder_id
	 */
	public static function togglePrivilegesOnFolderByRole($database, $role_id, $file_manager_folder_id, $rename_privilege, $upload_privilege, $move_privilege, $delete_privilege)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `roles_to_folders` (`role_id`, `file_manager_folder_id`)
VALUES (?, ?)
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($role_id, $file_manager_folder_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		if ($role_id <> $AXIS_USER_ROLE_ID_USER) {
			$arrValues = array($file_manager_folder_id, $AXIS_USER_ROLE_ID_USER);
			$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
		$db->free_result();
	}

	/**
	 * INSERT a single record into an "association table" (join-box).
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @param int $role_id
	 */
	public static function removeRoleFromFolder($database, $role_id, $file_manager_folder_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		if ($role_id == $AXIS_USER_ROLE_ID_USER) {
			return;
		}

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `roles_to_folders` (`role_id`, `file_manager_folder_id`)
VALUES (?, $AXIS_USER_ROLE_ID_USER)
";

		$deleteQuery =
"
DELETE FROM `roles_to_folders`
WHERE `file_manager_folder_id` = ?
AND `role_id` = ?
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($role_id, $file_manager_folder_id);
		$db->execute($deleteQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$arrValues = array($file_manager_folder_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	/**
	 * Add a contact to roles_to_folders.
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 */
	public static function addRoleToFolder($database, $file_manager_folder_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `roles_to_folders` (`role_id`, `file_manager_folder_id`)
VALUES (?, $AXIS_USER_ROLE_ID_USER)
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($file_manager_folder_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	public static function deleteFolderPrivileges($database, $file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$deleteQuery =
"
DELETE
FROM `roles_to_folders`
WHERE `file_manager_folder_id` = ?
";

		$db->begin();

		$arrValues = array($file_manager_folder_id);
		$db->execute($deleteQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	public static function clonePrivilegesFromFolder($database, $from_file_manager_folder_id, $arrToFileManagerFolderIds)
	{
		if (empty($arrToFileManagerFolderIds)) {
			return;
		} else {
			$in = join(',', $arrToFileManagerFolderIds);
			// Sanity check to avoid SQL injection
			if (preg_match('/[^0-9,]+/', $in)) {
				return;
			}
		}

		$from_file_manager_folder_id = (int) $from_file_manager_folder_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$deleteQuery =
"
DELETE FROM `roles_to_folders`
WHERE `file_manager_folder_id` IN ($in)
";
		$db->query($deleteQuery, MYSQLI_USE_RESULT);
		$db->free_result();

		/*
		$insertQuery =
			"INSERT ".
			"INTO `roles_to_folders` ".
			"(`role_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`) ".
			"SELECT `role_id`, ? as 'file_manager_folder_id', `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege` ".
			"FROM `roles_to_folders` ".
			"WHERE `file_manager_folder_id` = ? ";
		$arrValues = array($to_file_manager_folder_id, $from_file_manager_folder_id);
		$db->execute($insertQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
		*/

		$insertQuery =
"
INSERT
INTO `roles_to_folders`
(`role_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`)
SELECT r2f.`role_id`, fmf.`id` AS 'file_manager_file_id', r2f.`grant_privileges_privilege`, r2f.`rename_privilege`, r2f.`upload_privilege`, r2f.`move_privilege`, r2f.`delete_privilege`
FROM `roles_to_folders` r2f, `file_manager_folders` fmf
WHERE r2f.`file_manager_folder_id` = ?
AND fmf.`id` IN ($in)
";
		$arrValues = array($from_file_manager_folder_id);
		$db->execute($insertQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

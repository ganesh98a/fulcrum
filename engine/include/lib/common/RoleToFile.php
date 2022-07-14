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
 * RoleToFile.
 *
 * @category   Framework
 * @package    RoleToFile
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RoleToFile extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RoleToFile';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'roles_to_files';

	/**
	 * primary key (`role_id`,`file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'role_id' => 'int',
		'file_manager_file_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_role_to_file_via_primary_key' => array(
			'role_id' => 'int',
			'file_manager_file_id' => 'int'
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
		'file_manager_file_id' => 'file_manager_file_id',

		'grant_privileges_privilege' => 'grant_privileges_privilege',
		'rename_privilege' => 'rename_privilege',
		'move_privilege' => 'move_privilege',
		'delete_privilege' => 'delete_privilege'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $role_id;
	public $file_manager_file_id;

	public $grant_privileges_privilege;
	public $rename_privilege;
	public $move_privilege;
	public $delete_privilege;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRolesToFilesByRoleId;
	protected static $_arrRolesToFilesByFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRolesToFiles;

	// Foreign Key Objects
	private $_role;
	private $_fileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='roles_to_files')
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

	public function getFileManagerFile()
	{
		if (isset($this->_fileManagerFile)) {
			return $this->_fileManagerFile;
		} else {
			return null;
		}
	}

	public function setFileManagerFile($fileManagerFile)
	{
		$this->_fileManagerFile = $fileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrRolesToFilesByRoleId()
	{
		if (isset(self::$_arrRolesToFilesByRoleId)) {
			return self::$_arrRolesToFilesByRoleId;
		} else {
			return null;
		}
	}

	public static function setArrRolesToFilesByRoleId($arrRolesToFilesByRoleId)
	{
		self::$_arrRolesToFilesByRoleId = $arrRolesToFilesByRoleId;
	}

	public static function getArrRolesToFilesByFileManagerFileId()
	{
		if (isset(self::$_arrRolesToFilesByFileManagerFileId)) {
			return self::$_arrRolesToFilesByFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrRolesToFilesByFileManagerFileId($arrRolesToFilesByFileManagerFileId)
	{
		self::$_arrRolesToFilesByFileManagerFileId = $arrRolesToFilesByFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRolesToFiles()
	{
		if (isset(self::$_arrAllRolesToFiles)) {
			return self::$_arrAllRolesToFiles;
		} else {
			return null;
		}
	}

	public static function setArrAllRolesToFiles($arrAllRolesToFiles)
	{
		self::$_arrAllRolesToFiles = $arrAllRolesToFiles;
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
	 * Find by primary key (`role_id`,`file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param int $file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRoleIdAndFileManagerFileId($database, $role_id, $file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	r2files.*

FROM `roles_to_files` r2files
WHERE r2files.`role_id` = ?
AND r2files.`file_manager_file_id` = ?
";
		$arrValues = array($role_id, $file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$roleToFile = self::instantiateOrm($database, 'RoleToFile', $row);
			/* @var $roleToFile RoleToFile */
			return $roleToFile;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`role_id`,`file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param int $file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRoleIdAndFileManagerFileIdExtended($database, $role_id, $file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	r2files_fk_r.`id` AS 'r2files_fk_r__role_id',
	r2files_fk_r.`role` AS 'r2files_fk_r__role',
	r2files_fk_r.`role_description` AS 'r2files_fk_r__role_description',
	r2files_fk_r.`project_specific_flag` AS 'r2files_fk_r__project_specific_flag',
	r2files_fk_r.`sort_order` AS 'r2files_fk_r__sort_order',

	r2files_fk_fmfiles.`id` AS 'r2files_fk_fmfiles__file_manager_file_id',
	r2files_fk_fmfiles.`user_company_id` AS 'r2files_fk_fmfiles__user_company_id',
	r2files_fk_fmfiles.`contact_id` AS 'r2files_fk_fmfiles__contact_id',
	r2files_fk_fmfiles.`project_id` AS 'r2files_fk_fmfiles__project_id',
	r2files_fk_fmfiles.`file_manager_folder_id` AS 'r2files_fk_fmfiles__file_manager_folder_id',
	r2files_fk_fmfiles.`file_location_id` AS 'r2files_fk_fmfiles__file_location_id',
	r2files_fk_fmfiles.`virtual_file_name` AS 'r2files_fk_fmfiles__virtual_file_name',
	r2files_fk_fmfiles.`version_number` AS 'r2files_fk_fmfiles__version_number',
	r2files_fk_fmfiles.`virtual_file_name_sha1` AS 'r2files_fk_fmfiles__virtual_file_name_sha1',
	r2files_fk_fmfiles.`virtual_file_mime_type` AS 'r2files_fk_fmfiles__virtual_file_mime_type',
	r2files_fk_fmfiles.`modified` AS 'r2files_fk_fmfiles__modified',
	r2files_fk_fmfiles.`created` AS 'r2files_fk_fmfiles__created',
	r2files_fk_fmfiles.`deleted_flag` AS 'r2files_fk_fmfiles__deleted_flag',
	r2files_fk_fmfiles.`directly_deleted_flag` AS 'r2files_fk_fmfiles__directly_deleted_flag',

	r2files.*

FROM `roles_to_files` r2files
	INNER JOIN `roles` r2files_fk_r ON r2files.`role_id` = r2files_fk_r.`id`
	INNER JOIN `file_manager_files` r2files_fk_fmfiles ON r2files.`file_manager_file_id` = r2files_fk_fmfiles.`id`
WHERE r2files.`role_id` = ?
AND r2files.`file_manager_file_id` = ?
";
		$arrValues = array($role_id, $file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$roleToFile = self::instantiateOrm($database, 'RoleToFile', $row);
			/* @var $roleToFile RoleToFile */
			$roleToFile->convertPropertiesToData();

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['r2files_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'r2files_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$roleToFile->setRole($role);

			if (isset($row['file_manager_file_id'])) {
				$file_manager_file_id = $row['file_manager_file_id'];
				$row['r2files_fk_fmfiles__id'] = $file_manager_file_id;
				$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id, 'r2files_fk_fmfiles__');
				/* @var $fileManagerFile FileManagerFile */
				$fileManagerFile->convertPropertiesToData();
			} else {
				$fileManagerFile = false;
			}
			$roleToFile->setFileManagerFile($fileManagerFile);

			return $roleToFile;
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
	 * @param array $arrRoleIdAndFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToFilesByArrRoleIdAndFileManagerFileIdList($database, $arrRoleIdAndFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrRoleIdAndFileManagerFileIdList)) {
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
		// ORDER BY `role_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToFile = new RoleToFile($database);
			$sqlOrderByColumns = $tmpRoleToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrRoleIdAndFileManagerFileIdList as $k => $arrTmp) {
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
		if (count($arrRoleIdAndFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	r2files.*

FROM `roles_to_files` r2files
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToFilesByArrRoleIdAndFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$roleToFile = self::instantiateOrm($database, 'RoleToFile', $row);
			/* @var $roleToFile RoleToFile */
			$arrRolesToFilesByArrRoleIdAndFileManagerFileIdList[] = $roleToFile;
		}

		$db->free_result();

		return $arrRolesToFilesByArrRoleIdAndFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `roles_to_files_fk_r` foreign key (`role_id`) references `roles` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToFilesByRoleId($database, $role_id, Input $options=null)
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
			self::$_arrRolesToFilesByRoleId = null;
		}

		$arrRolesToFilesByRoleId = self::$_arrRolesToFilesByRoleId;
		if (isset($arrRolesToFilesByRoleId) && !empty($arrRolesToFilesByRoleId)) {
			return $arrRolesToFilesByRoleId;
		}

		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToFile = new RoleToFile($database);
			$sqlOrderByColumns = $tmpRoleToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2files.*

FROM `roles_to_files` r2files
WHERE r2files.`role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToFilesByRoleId = array();
		while ($row = $db->fetch()) {
			$roleToFile = self::instantiateOrm($database, 'RoleToFile', $row);
			/* @var $roleToFile RoleToFile */
			$arrRolesToFilesByRoleId[] = $roleToFile;
		}

		$db->free_result();

		self::$_arrRolesToFilesByRoleId = $arrRolesToFilesByRoleId;

		return $arrRolesToFilesByRoleId;
	}

	/**
	 * Load by constraint `roles_to_files_fk_fmfiles` foreign key (`file_manager_file_id`) references `file_manager_files` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRolesToFilesByFileManagerFileId($database, $file_manager_file_id, Input $options=null)
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
			self::$_arrRolesToFilesByFileManagerFileId = null;
		}

		$arrRolesToFilesByFileManagerFileId = self::$_arrRolesToFilesByFileManagerFileId;
		if (isset($arrRolesToFilesByFileManagerFileId) && !empty($arrRolesToFilesByFileManagerFileId)) {
			return $arrRolesToFilesByFileManagerFileId;
		}

		$file_manager_file_id = (int) $file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToFile = new RoleToFile($database);
			$sqlOrderByColumns = $tmpRoleToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2files.*

FROM `roles_to_files` r2files
WHERE r2files.`file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesToFilesByFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$roleToFile = self::instantiateOrm($database, 'RoleToFile', $row);
			/* @var $roleToFile RoleToFile */
			$arrRolesToFilesByFileManagerFileId[] = $roleToFile;
		}

		$db->free_result();

		self::$_arrRolesToFilesByFileManagerFileId = $arrRolesToFilesByFileManagerFileId;

		return $arrRolesToFilesByFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all roles_to_files records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRolesToFiles($database, Input $options=null)
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
			self::$_arrAllRolesToFiles = null;
		}

		$arrAllRolesToFiles = self::$_arrAllRolesToFiles;
		if (isset($arrAllRolesToFiles) && !empty($arrAllRolesToFiles)) {
			return $arrAllRolesToFiles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `role_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRoleToFile = new RoleToFile($database);
			$sqlOrderByColumns = $tmpRoleToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	r2files.*

FROM `roles_to_files` r2files{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `role_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRolesToFiles = array();
		while ($row = $db->fetch()) {
			$roleToFile = self::instantiateOrm($database, 'RoleToFile', $row);
			/* @var $roleToFile RoleToFile */
			$arrAllRolesToFiles[] = $roleToFile;
		}

		$db->free_result();

		self::$_arrAllRolesToFiles = $arrAllRolesToFiles;

		return $arrAllRolesToFiles;
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
INTO `roles_to_files`
(`role_id`, `file_manager_file_id`, `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `grant_privileges_privilege` = ?, `rename_privilege` = ?, `move_privilege` = ?, `delete_privilege` = ?
";
		$arrValues = array($this->role_id, $this->file_manager_file_id, $this->grant_privileges_privilege, $this->rename_privilege, $this->move_privilege, $this->delete_privilege, $this->grant_privileges_privilege, $this->rename_privilege, $this->move_privilege, $this->delete_privilege);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$role_to_file_id = $db->insertId;
		$db->free_result();

		return $role_to_file_id;
	}

	// Save: insert ignore

	public static function loadRolesToFilesListByUserId($database, $user_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT r2f.*
FROM `contacts` c, `contacts_to_roles` c2r, `roles_to_files` r2f, `roles` r, `files` f
WHERE c.`user_id` = ?
AND c.`id` = r2f.`file_manager_file_id`
AND r2f.`role_id` = r.`id`
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToRolesList = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['file_id'];
			$role_id = $row['role_id'];
			$arrRolesToFilesList[$role_id][$file_manager_file_id] = $row;
		}
		$db->free_result();

		return $arrContactsToRolesList;
	}

	public static function loadCompanyFileIdListByPrimaryContactId($database, $user_company_id, $primary_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Get a list of role_id values
		$query =
"
SELECT c2r.`role_id`
FROM `contacts_to_roles` c2r
WHERE c2r.`contact_id` = ?
";
		$arrValues = array($primary_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRoleIds = array();
		while ($row = $db->fetch()) {
			$role_id = $row['role_id'];
			$arrRoleIds[$role_id] = 1;
		}
		$db->free_result();

		if (empty($arrRoleIds)) {
			return array();
		}

		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		// Check for admin case
		if (isset($arrRoleIds[$AXIS_USER_ROLE_ID_ADMIN])) {
			$adminFlag = true;
		} else {
			$adminFlag = false;
		}

		if ($adminFlag) {
			$query =
"
SELECT fmf.`id`
FROM `file_manager_files` fmf
WHERE fmf.`user_company_id` = ?
AND fmf.`project_id` = $AXIS_NON_EXISTENT_PROJECT_ID
";
			$arrValues = array($user_company_id);
		} else {
			$arrIn = array_keys($arrRoleIds);
			$in = join(',', $arrIn);
			$query =
"
SELECT fmf.`id`
FROM `file_manager_files` fmf, `roles_to_files` r2f
WHERE fmf.`user_company_id` = ?
AND fmf.`project_id` = $AXIS_NON_EXISTENT_PROJECT_ID
AND fmf.`id` = r2f.`file_manager_file_id`
AND r2f.`role_id` IN ($in)
";
			$arrValues = array($user_company_id);
		}

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFileIds = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];

			$arrFileManagerFileIds[$file_manager_file_id] = 1;
		}
		$db->free_result();

		return $arrFileManagerFileIds;
	}

	/**
	 * INSERT a single record into an "association table" (join-box).
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param int $file_manager_file_id
	 * @param int $rename_privilege
	 * @param int $move_privilege
	 * @param int $delete_privilege
	 */
	public static function togglePrivilegesOnFileByRole($database, $role_id, $file_manager_file_id, $rename_privilege, $move_privilege, $delete_privilege)
	{
		$insertOnDuplicateKeyUpdateQuery =
		"
INSERT
INTO `roles_to_files` (`role_id`, `file_manager_file_id`, `rename_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `rename_privilege`=?, `move_privilege`=?, `delete_privilege`=?
";
		$arrValues = array($role_id, $file_manager_file_id, $rename_privilege, $move_privilege, $delete_privilege, $rename_privilege, $move_privilege, $delete_privilege);

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$db->execute($insertOnDuplicateKeyUpdateQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
	}

	/**
	 * INSERT a single record into an "association table" (join-box).
	 *
	 * @param string $database
	 * @param int $file_manager_file_id
	 * @param int $role_id
	 */
	public static function removeRoleFromFile($database, $role_id, $file_manager_file_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		if ($role_id == $AXIS_USER_ROLE_ID_USER) {
			return;
		}

		$insertIgnoreQuery =
		"
INSERT IGNORE
INTO `roles_to_files` (`file_manager_file_id`, `role_id`)
VALUES (?, $AXIS_USER_ROLE_ID_USER)
";

		$deleteQuery =
		"
DELETE FROM `roles_to_files`
WHERE `file_manager_file_id` = ?
AND `role_id` = ?
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($file_manager_file_id, $role_id);
		$db->execute($deleteQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$arrValues = array($file_manager_file_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	/**
	 * Add a contact to roles_to_files.
	 *
	 * @param string $database
	 * @param int $file_manager_file_id
	 */
	public static function addRoleToFile($database, $role_id, $file_manager_file_id)
	{
		$insertIgnoreQuery =
		"
INSERT IGNORE
INTO `roles_to_files` (`role_id`, `file_manager_file_id`)
VALUES (?, ?)
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($role_id, $file_manager_file_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	public static function removeRoleToFile($database, $role_id, $file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$deleteQuery =
		"
DELETE
FROM `roles_to_files`
WHERE `role_id` = ?
AND `file_manager_file_id` = ?
";

		$db->begin();

		$arrValues = array($role_id, $file_manager_file_id);
		$db->execute($deleteQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	public static function clonePrivilegesFromFolder($database, $from_file_manager_folder_id, array $arrToFileManagerFileIds)
	{
		if (empty($arrToFileManagerFileIds)) {
			return;
		} else {
			$in = join(',', $arrToFileManagerFileIds);
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
DELETE FROM `roles_to_files`
WHERE `file_manager_file_id` IN ($in)
";
		$db->query($deleteQuery, MYSQLI_USE_RESULT);
		$db->free_result();

		$insertQuery =
		"
INSERT
INTO `roles_to_files`
(`role_id`, `file_manager_file_id`, `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`)
SELECT r2f.`role_id`, fmf.`id` AS 'file_manager_file_id', r2f.`grant_privileges_privilege`, r2f.`rename_privilege`, r2f.`move_privilege`, r2f.`delete_privilege`
FROM `roles_to_folders` r2f, `file_manager_files` fmf
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

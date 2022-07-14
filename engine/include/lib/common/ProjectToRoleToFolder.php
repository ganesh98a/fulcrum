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
 * ProjectToRoleToFolder.
 *
 * @category   Framework
 * @package    ProjectToRoleToFolder
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ProjectToRoleToFolder extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ProjectToRoleToFolder';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'projects_to_roles_to_folders';

	/**
	 * primary key (`project_id`,`role_id`,`file_manager_folder_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'project_id' => 'int',
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
		'unique_project_to_role_to_folder_via_primary_key' => array(
			'project_id' => 'int',
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
		'project_id' => 'project_id',
		'role_id' => 'role_id',
		'file_manager_folder_id' => 'file_manager_folder_id',

		'rename_privilege' => 'rename_privilege',
		'upload_privilege' => 'upload_privilege',
		'move_privilege' => 'move_privilege',
		'delete_privilege' => 'delete_privilege'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_id;
	public $role_id;
	public $file_manager_folder_id;

	public $rename_privilege;
	public $upload_privilege;
	public $move_privilege;
	public $delete_privilege;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrProjectsToRolesToFoldersByProjectId;
	protected static $_arrProjectsToRolesToFoldersByRoleId;
	protected static $_arrProjectsToRolesToFoldersByFileManagerFolderId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjectsToRolesToFolders;

	// Foreign Key Objects
	private $_project;
	private $_role;
	private $_fileManagerFolder;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='projects_to_roles_to_folders')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getProject()
	{
		if (isset($this->_project)) {
			return $this->_project;
		} else {
			return null;
		}
	}

	public function setProject($project)
	{
		$this->_project = $project;
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
	public static function getArrProjectsToRolesToFoldersByProjectId()
	{
		if (isset(self::$_arrProjectsToRolesToFoldersByProjectId)) {
			return self::$_arrProjectsToRolesToFoldersByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToRolesToFoldersByProjectId($arrProjectsToRolesToFoldersByProjectId)
	{
		self::$_arrProjectsToRolesToFoldersByProjectId = $arrProjectsToRolesToFoldersByProjectId;
	}

	public static function getArrProjectsToRolesToFoldersByRoleId()
	{
		if (isset(self::$_arrProjectsToRolesToFoldersByRoleId)) {
			return self::$_arrProjectsToRolesToFoldersByRoleId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToRolesToFoldersByRoleId($arrProjectsToRolesToFoldersByRoleId)
	{
		self::$_arrProjectsToRolesToFoldersByRoleId = $arrProjectsToRolesToFoldersByRoleId;
	}

	public static function getArrProjectsToRolesToFoldersByFileManagerFolderId()
	{
		if (isset(self::$_arrProjectsToRolesToFoldersByFileManagerFolderId)) {
			return self::$_arrProjectsToRolesToFoldersByFileManagerFolderId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToRolesToFoldersByFileManagerFolderId($arrProjectsToRolesToFoldersByFileManagerFolderId)
	{
		self::$_arrProjectsToRolesToFoldersByFileManagerFolderId = $arrProjectsToRolesToFoldersByFileManagerFolderId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllProjectsToRolesToFolders()
	{
		if (isset(self::$_arrAllProjectsToRolesToFolders)) {
			return self::$_arrAllProjectsToRolesToFolders;
		} else {
			return null;
		}
	}

	public static function setArrAllProjectsToRolesToFolders($arrAllProjectsToRolesToFolders)
	{
		self::$_arrAllProjectsToRolesToFolders = $arrAllProjectsToRolesToFolders;
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
	 * Find by primary key (`project_id`,`role_id`,`file_manager_folder_id`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $role_id
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndRoleIdAndFileManagerFolderId($database, $project_id, $role_id, $file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	p2r2folders.*

FROM `projects_to_roles_to_folders` p2r2folders
WHERE p2r2folders.`project_id` = ?
AND p2r2folders.`role_id` = ?
AND p2r2folders.`file_manager_folder_id` = ?
";
		$arrValues = array($project_id, $role_id, $file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToRoleToFolder = self::instantiateOrm($database, 'ProjectToRoleToFolder', $row);
			/* @var $projectToRoleToFolder ProjectToRoleToFolder */
			return $projectToRoleToFolder;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`project_id`,`role_id`,`file_manager_folder_id`) Extended.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $role_id
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndRoleIdAndFileManagerFolderIdExtended($database, $project_id, $role_id, $file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	p2r2folders_fk_p.`id` AS 'p2r2folders_fk_p__project_id',
	p2r2folders_fk_p.`project_type_id` AS 'p2r2folders_fk_p__project_type_id',
	p2r2folders_fk_p.`user_company_id` AS 'p2r2folders_fk_p__user_company_id',
	p2r2folders_fk_p.`user_custom_project_id` AS 'p2r2folders_fk_p__user_custom_project_id',
	p2r2folders_fk_p.`project_name` AS 'p2r2folders_fk_p__project_name',
	p2r2folders_fk_p.`project_owner_name` AS 'p2r2folders_fk_p__project_owner_name',
	p2r2folders_fk_p.`latitude` AS 'p2r2folders_fk_p__latitude',
	p2r2folders_fk_p.`longitude` AS 'p2r2folders_fk_p__longitude',
	p2r2folders_fk_p.`address_line_1` AS 'p2r2folders_fk_p__address_line_1',
	p2r2folders_fk_p.`address_line_2` AS 'p2r2folders_fk_p__address_line_2',
	p2r2folders_fk_p.`address_line_3` AS 'p2r2folders_fk_p__address_line_3',
	p2r2folders_fk_p.`address_line_4` AS 'p2r2folders_fk_p__address_line_4',
	p2r2folders_fk_p.`address_city` AS 'p2r2folders_fk_p__address_city',
	p2r2folders_fk_p.`address_county` AS 'p2r2folders_fk_p__address_county',
	p2r2folders_fk_p.`address_state_or_region` AS 'p2r2folders_fk_p__address_state_or_region',
	p2r2folders_fk_p.`address_postal_code` AS 'p2r2folders_fk_p__address_postal_code',
	p2r2folders_fk_p.`address_postal_code_extension` AS 'p2r2folders_fk_p__address_postal_code_extension',
	p2r2folders_fk_p.`address_country` AS 'p2r2folders_fk_p__address_country',
	p2r2folders_fk_p.`building_count` AS 'p2r2folders_fk_p__building_count',
	p2r2folders_fk_p.`unit_count` AS 'p2r2folders_fk_p__unit_count',
	p2r2folders_fk_p.`gross_square_footage` AS 'p2r2folders_fk_p__gross_square_footage',
	p2r2folders_fk_p.`net_rentable_square_footage` AS 'p2r2folders_fk_p__net_rentable_square_footage',
	p2r2folders_fk_p.`is_active_flag` AS 'p2r2folders_fk_p__is_active_flag',
	p2r2folders_fk_p.`public_plans_flag` AS 'p2r2folders_fk_p__public_plans_flag',
	p2r2folders_fk_p.`prevailing_wage_flag` AS 'p2r2folders_fk_p__prevailing_wage_flag',
	p2r2folders_fk_p.`city_business_license_required_flag` AS 'p2r2folders_fk_p__city_business_license_required_flag',
	p2r2folders_fk_p.`is_internal_flag` AS 'p2r2folders_fk_p__is_internal_flag',
	p2r2folders_fk_p.`project_contract_date` AS 'p2r2folders_fk_p__project_contract_date',
	p2r2folders_fk_p.`project_start_date` AS 'p2r2folders_fk_p__project_start_date',
	p2r2folders_fk_p.`project_completed_date` AS 'p2r2folders_fk_p__project_completed_date',
	p2r2folders_fk_p.`sort_order` AS 'p2r2folders_fk_p__sort_order',

	p2r2folders_fk_r.`id` AS 'p2r2folders_fk_r__role_id',
	p2r2folders_fk_r.`role` AS 'p2r2folders_fk_r__role',
	p2r2folders_fk_r.`role_description` AS 'p2r2folders_fk_r__role_description',
	p2r2folders_fk_r.`project_specific_flag` AS 'p2r2folders_fk_r__project_specific_flag',
	p2r2folders_fk_r.`sort_order` AS 'p2r2folders_fk_r__sort_order',

	p2r2folders_fk_fmfolders.`id` AS 'p2r2folders_fk_fmfolders__file_manager_folder_id',
	p2r2folders_fk_fmfolders.`user_company_id` AS 'p2r2folders_fk_fmfolders__user_company_id',
	p2r2folders_fk_fmfolders.`contact_id` AS 'p2r2folders_fk_fmfolders__contact_id',
	p2r2folders_fk_fmfolders.`project_id` AS 'p2r2folders_fk_fmfolders__project_id',
	p2r2folders_fk_fmfolders.`virtual_file_path` AS 'p2r2folders_fk_fmfolders__virtual_file_path',
	p2r2folders_fk_fmfolders.`virtual_file_path_sha1` AS 'p2r2folders_fk_fmfolders__virtual_file_path_sha1',
	p2r2folders_fk_fmfolders.`modified` AS 'p2r2folders_fk_fmfolders__modified',
	p2r2folders_fk_fmfolders.`created` AS 'p2r2folders_fk_fmfolders__created',
	p2r2folders_fk_fmfolders.`deleted_flag` AS 'p2r2folders_fk_fmfolders__deleted_flag',
	p2r2folders_fk_fmfolders.`directly_deleted_flag` AS 'p2r2folders_fk_fmfolders__directly_deleted_flag',

	p2r2folders.*

FROM `projects_to_roles_to_folders` p2r2folders
	INNER JOIN `projects` p2r2folders_fk_p ON p2r2folders.`project_id` = p2r2folders_fk_p.`id`
	INNER JOIN `roles` p2r2folders_fk_r ON p2r2folders.`role_id` = p2r2folders_fk_r.`id`
	INNER JOIN `file_manager_folders` p2r2folders_fk_fmfolders ON p2r2folders.`file_manager_folder_id` = p2r2folders_fk_fmfolders.`id`
WHERE p2r2folders.`project_id` = ?
AND p2r2folders.`role_id` = ?
AND p2r2folders.`file_manager_folder_id` = ?
";
		$arrValues = array($project_id, $role_id, $file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToRoleToFolder = self::instantiateOrm($database, 'ProjectToRoleToFolder', $row);
			/* @var $projectToRoleToFolder ProjectToRoleToFolder */
			$projectToRoleToFolder->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['p2r2folders_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'p2r2folders_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectToRoleToFolder->setProject($project);

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['p2r2folders_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'p2r2folders_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$projectToRoleToFolder->setRole($role);

			if (isset($row['file_manager_folder_id'])) {
				$file_manager_folder_id = $row['file_manager_folder_id'];
				$row['p2r2folders_fk_fmfolders__id'] = $file_manager_folder_id;
				$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'p2r2folders_fk_fmfolders__');
				/* @var $fileManagerFolder FileManagerFolder */
				$fileManagerFolder->convertPropertiesToData();
			} else {
				$fileManagerFolder = false;
			}
			$projectToRoleToFolder->setFileManagerFolder($fileManagerFolder);

			return $projectToRoleToFolder;
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
	 * @param array $arrProjectIdAndRoleIdAndFileManagerFolderIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToRolesToFoldersByArrProjectIdAndRoleIdAndFileManagerFolderIdList($database, $arrProjectIdAndRoleIdAndFileManagerFolderIdList, Input $options=null)
	{
		if (empty($arrProjectIdAndRoleIdAndFileManagerFolderIdList)) {
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
		// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToRoleToFolder = new ProjectToRoleToFolder($database);
			$sqlOrderByColumns = $tmpProjectToRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrProjectIdAndRoleIdAndFileManagerFolderIdList as $k => $arrTmp) {
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
		if (count($arrProjectIdAndRoleIdAndFileManagerFolderIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	p2r2folders.*

FROM `projects_to_roles_to_folders` p2r2folders
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToRolesToFoldersByArrProjectIdAndRoleIdAndFileManagerFolderIdList = array();
		while ($row = $db->fetch()) {
			$projectToRoleToFolder = self::instantiateOrm($database, 'ProjectToRoleToFolder', $row);
			/* @var $projectToRoleToFolder ProjectToRoleToFolder */
			$arrProjectsToRolesToFoldersByArrProjectIdAndRoleIdAndFileManagerFolderIdList[] = $projectToRoleToFolder;
		}

		$db->free_result();

		return $arrProjectsToRolesToFoldersByArrProjectIdAndRoleIdAndFileManagerFolderIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `projects_to_roles_to_folders_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToRolesToFoldersByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrProjectsToRolesToFoldersByProjectId = null;
		}

		$arrProjectsToRolesToFoldersByProjectId = self::$_arrProjectsToRolesToFoldersByProjectId;
		if (isset($arrProjectsToRolesToFoldersByProjectId) && !empty($arrProjectsToRolesToFoldersByProjectId)) {
			return $arrProjectsToRolesToFoldersByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToRoleToFolder = new ProjectToRoleToFolder($database);
			$sqlOrderByColumns = $tmpProjectToRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2r2folders.*

FROM `projects_to_roles_to_folders` p2r2folders
WHERE p2r2folders.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToRolesToFoldersByProjectId = array();
		while ($row = $db->fetch()) {
			$projectToRoleToFolder = self::instantiateOrm($database, 'ProjectToRoleToFolder', $row);
			/* @var $projectToRoleToFolder ProjectToRoleToFolder */
			$arrProjectsToRolesToFoldersByProjectId[] = $projectToRoleToFolder;
		}

		$db->free_result();

		self::$_arrProjectsToRolesToFoldersByProjectId = $arrProjectsToRolesToFoldersByProjectId;

		return $arrProjectsToRolesToFoldersByProjectId;
	}

	/**
	 * Load by constraint `projects_to_roles_to_folders_fk_r` foreign key (`role_id`) references `roles` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToRolesToFoldersByRoleId($database, $role_id, Input $options=null)
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
			self::$_arrProjectsToRolesToFoldersByRoleId = null;
		}

		$arrProjectsToRolesToFoldersByRoleId = self::$_arrProjectsToRolesToFoldersByRoleId;
		if (isset($arrProjectsToRolesToFoldersByRoleId) && !empty($arrProjectsToRolesToFoldersByRoleId)) {
			return $arrProjectsToRolesToFoldersByRoleId;
		}

		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToRoleToFolder = new ProjectToRoleToFolder($database);
			$sqlOrderByColumns = $tmpProjectToRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2r2folders.*

FROM `projects_to_roles_to_folders` p2r2folders
WHERE p2r2folders.`role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToRolesToFoldersByRoleId = array();
		while ($row = $db->fetch()) {
			$projectToRoleToFolder = self::instantiateOrm($database, 'ProjectToRoleToFolder', $row);
			/* @var $projectToRoleToFolder ProjectToRoleToFolder */
			$arrProjectsToRolesToFoldersByRoleId[] = $projectToRoleToFolder;
		}

		$db->free_result();

		self::$_arrProjectsToRolesToFoldersByRoleId = $arrProjectsToRolesToFoldersByRoleId;

		return $arrProjectsToRolesToFoldersByRoleId;
	}

	/**
	 * Load by constraint `projects_to_roles_to_folders_fk_fmfolders` foreign key (`file_manager_folder_id`) references `file_manager_folders` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToRolesToFoldersByFileManagerFolderId($database, $file_manager_folder_id, Input $options=null)
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
			self::$_arrProjectsToRolesToFoldersByFileManagerFolderId = null;
		}

		$arrProjectsToRolesToFoldersByFileManagerFolderId = self::$_arrProjectsToRolesToFoldersByFileManagerFolderId;
		if (isset($arrProjectsToRolesToFoldersByFileManagerFolderId) && !empty($arrProjectsToRolesToFoldersByFileManagerFolderId)) {
			return $arrProjectsToRolesToFoldersByFileManagerFolderId;
		}

		$file_manager_folder_id = (int) $file_manager_folder_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToRoleToFolder = new ProjectToRoleToFolder($database);
			$sqlOrderByColumns = $tmpProjectToRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2r2folders.*

FROM `projects_to_roles_to_folders` p2r2folders
WHERE p2r2folders.`file_manager_folder_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToRolesToFoldersByFileManagerFolderId = array();
		while ($row = $db->fetch()) {
			$projectToRoleToFolder = self::instantiateOrm($database, 'ProjectToRoleToFolder', $row);
			/* @var $projectToRoleToFolder ProjectToRoleToFolder */
			$arrProjectsToRolesToFoldersByFileManagerFolderId[] = $projectToRoleToFolder;
		}

		$db->free_result();

		self::$_arrProjectsToRolesToFoldersByFileManagerFolderId = $arrProjectsToRolesToFoldersByFileManagerFolderId;

		return $arrProjectsToRolesToFoldersByFileManagerFolderId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all projects_to_roles_to_folders records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllProjectsToRolesToFolders($database, Input $options=null)
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
			self::$_arrAllProjectsToRolesToFolders = null;
		}

		$arrAllProjectsToRolesToFolders = self::$_arrAllProjectsToRolesToFolders;
		if (isset($arrAllProjectsToRolesToFolders) && !empty($arrAllProjectsToRolesToFolders)) {
			return $arrAllProjectsToRolesToFolders;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToRoleToFolder = new ProjectToRoleToFolder($database);
			$sqlOrderByColumns = $tmpProjectToRoleToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2r2folders.*

FROM `projects_to_roles_to_folders` p2r2folders{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `role_id` ASC, `file_manager_folder_id` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjectsToRolesToFolders = array();
		while ($row = $db->fetch()) {
			$projectToRoleToFolder = self::instantiateOrm($database, 'ProjectToRoleToFolder', $row);
			/* @var $projectToRoleToFolder ProjectToRoleToFolder */
			$arrAllProjectsToRolesToFolders[] = $projectToRoleToFolder;
		}

		$db->free_result();

		self::$_arrAllProjectsToRolesToFolders = $arrAllProjectsToRolesToFolders;

		return $arrAllProjectsToRolesToFolders;
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
INTO `projects_to_roles_to_folders`
(`project_id`, `role_id`, `file_manager_folder_id`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `rename_privilege` = ?, `upload_privilege` = ?, `move_privilege` = ?, `delete_privilege` = ?
";
		$arrValues = array($this->project_id, $this->role_id, $this->file_manager_folder_id, $this->rename_privilege, $this->upload_privilege, $this->move_privilege, $this->delete_privilege, $this->rename_privilege, $this->upload_privilege, $this->move_privilege, $this->delete_privilege);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$project_to_role_to_folder_id = $db->insertId;
		$db->free_result();

		return $project_to_role_to_folder_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

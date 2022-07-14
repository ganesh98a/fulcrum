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
 * Manage binary and text files on disk in the cloud.
 *
 * @category   Framework
 * @package    FileManagerFolder
 */

/**
 * File
 */
require_once('lib/common/File.php');

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class FileManagerFolder extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'FileManagerFolder';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'file_manager_folders';

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
	 * unique index `unique_file_manager_folder` (`user_company_id`,`project_id`,`virtual_file_path`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_file_manager_folder' => array(
			'user_company_id' => 'int',
			'project_id' => 'int',
			'virtual_file_path' => 'string'
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
		'id' => 'file_manager_folder_id',

		'user_company_id' => 'user_company_id',
		'contact_id' => 'contact_id',
		'project_id' => 'project_id',

		'virtual_file_path' => 'virtual_file_path',

		'virtual_file_path_sha1' => 'virtual_file_path_sha1',
		'modified' => 'modified',
		'created' => 'created',
		'deleted_flag' => 'deleted_flag',
		'directly_deleted_flag' => 'directly_deleted_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $file_manager_folder_id;

	public $user_company_id;
	public $contact_id;
	public $project_id;

	public $virtual_file_path;

	public $virtual_file_path_sha1;
	public $modified;
	public $created;
	public $deleted_flag;
	public $directly_deleted_flag;

	// Other Properties
	protected $file;

	protected $compressed = false;

	protected $compressionLevel = 9;

	/**
	 * This is a temp location for the content while it is being saved.
	 * The content is saved in a compressed format.
	 *
	 * $_data holds the values that are INSERTED/UPDATED so this value
	 * is ignored during the save() operation.
	 *
	 * @var string
	 */
	protected $uncompressed_content;

	/**
	 * Derive the "active folder name" and store it here.
	 * E.g. /a/b/c/ would be "c"
	 *
	 * @var string
	 */
	protected $derivedFolderName;

	/**
	 * Derive the "parent folder name" and store it here.
	 * E.g. /a/b/c/ would be "b"
	 *
	 * @var string
	 */
	protected $derivedParentFolderName;

	/**
	 * Derive the "parent folder path" and store it here.
	 * E.g. /a/b/c/ would be "/a/b/"
	 *
	 * @var string
	 */
	protected $derivedParentFolderPath;

	/**
	 * Derive the parent folder id.
	 *
	 * @var int
	 */
	protected $derivedParentFolderId;

	protected $filteredVirtualFilePath;

	// role_id list from roles_to_folders using <file_manager_folder_id>
	protected $rolesToFolders;

	// contact_id list from contacts_to_folders using <file_manager_folder_id>
	protected $contactsToFolders;

	protected $_parentFileManagerFolder;

	protected $_virtualFilePathDidNotExist = true;

	public $grant_privileges_privilege;
	public $rename_privilege;
	public $upload_privilege;
	public $move_privilege;
	public $delete_privilege;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_virtual_file_path;
	public $escaped_virtual_file_path_sha1;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_virtual_file_path_nl2br;
	public $escaped_virtual_file_path_sha1_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrFileManagerFoldersByUserCompanyId;
	protected static $_arrFileManagerFoldersByContactId;
	protected static $_arrFileManagerFoldersByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag;
	protected static $_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
	protected static $_arrFileManagerFoldersByVirtualFilePath;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllFileManagerFolders;

	// Foreign Key Objects
	private $_userCompany;
	private $_contact;
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='file_manager_folders')
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

	public function getContact()
	{
		if (isset($this->_contact)) {
			return $this->_contact;
		} else {
			return null;
		}
	}

	public function setContact($contact)
	{
		$this->_contact = $contact;
	}

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

	public function getParentFileManagerFolder()
	{
		if (isset($this->_parentFileManagerFolder) && ($this->_parentFileManagerFolder instanceof FileManagerFolder)) {
			return $this->_parentFileManagerFolder;
		} else {
			return false;
		}
	}

	public function setParentFileManagerFolder($parentFileManagerFolder)
	{
		$this->_parentFileManagerFolder = $parentFileManagerFolder;
	}

	public function getVirtualFilePathDidNotExist()
	{
		if ($this->_virtualFilePathDidNotExist) {
			return true;
		} else {
			return false;
		}
	}

	public function setVirtualFilePathDidNotExist($virtualFilePathDidNotExist)
	{
		$this->_virtualFilePathDidNotExist = $virtualFilePathDidNotExist;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrFileManagerFoldersByUserCompanyId()
	{
		if (isset(self::$_arrFileManagerFoldersByUserCompanyId)) {
			return self::$_arrFileManagerFoldersByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFoldersByUserCompanyId($arrFileManagerFoldersByUserCompanyId)
	{
		self::$_arrFileManagerFoldersByUserCompanyId = $arrFileManagerFoldersByUserCompanyId;
	}

	public static function getArrFileManagerFoldersByContactId()
	{
		if (isset(self::$_arrFileManagerFoldersByContactId)) {
			return self::$_arrFileManagerFoldersByContactId;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFoldersByContactId($arrFileManagerFoldersByContactId)
	{
		self::$_arrFileManagerFoldersByContactId = $arrFileManagerFoldersByContactId;
	}

	public static function getArrFileManagerFoldersByProjectId()
	{
		if (isset(self::$_arrFileManagerFoldersByProjectId)) {
			return self::$_arrFileManagerFoldersByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFoldersByProjectId($arrFileManagerFoldersByProjectId)
	{
		self::$_arrFileManagerFoldersByProjectId = $arrFileManagerFoldersByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag()
	{
		if (isset(self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag)) {
			return self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag($arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag)
	{
		self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag = $arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag;
	}

	public static function getArrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag()
	{
		if (isset(self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag)) {
			return self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag($arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag)
	{
		self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = $arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
	}

	public static function getArrFileManagerFoldersByVirtualFilePath()
	{
		if (isset(self::$_arrFileManagerFoldersByVirtualFilePath)) {
			return self::$_arrFileManagerFoldersByVirtualFilePath;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFoldersByVirtualFilePath($arrFileManagerFoldersByVirtualFilePath)
	{
		self::$_arrFileManagerFoldersByVirtualFilePath = $arrFileManagerFoldersByVirtualFilePath;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllFileManagerFolders()
	{
		if (isset(self::$_arrAllFileManagerFolders)) {
			return self::$_arrAllFileManagerFolders;
		} else {
			return null;
		}
	}

	public static function setArrAllFileManagerFolders($arrAllFileManagerFolders)
	{
		self::$_arrAllFileManagerFolders = $arrAllFileManagerFolders;
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
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $file_manager_folder_id, $table='file_manager_folders', $module='FileManagerFolder')
	{
		$fileManagerFolder = parent::findById($database, $file_manager_folder_id, $table, $module);

		return $fileManagerFolder;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findFileManagerFolderByIdExtended($database, $file_manager_folder_id)
	{
		$file_manager_folder_id = (int) $file_manager_folder_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	fmfolders_fk_uc.`id` AS 'fmfolders_fk_uc__user_company_id',
	fmfolders_fk_uc.`company` AS 'fmfolders_fk_uc__company',
	fmfolders_fk_uc.`primary_phone_number` AS 'fmfolders_fk_uc__primary_phone_number',
	fmfolders_fk_uc.`employer_identification_number` AS 'fmfolders_fk_uc__employer_identification_number',
	fmfolders_fk_uc.`construction_license_number` AS 'fmfolders_fk_uc__construction_license_number',
	fmfolders_fk_uc.`construction_license_number_expiration_date` AS 'fmfolders_fk_uc__construction_license_number_expiration_date',
	fmfolders_fk_uc.`paying_customer_flag` AS 'fmfolders_fk_uc__paying_customer_flag',

	fmfolders_fk_c.`id` AS 'fmfolders_fk_c__contact_id',
	fmfolders_fk_c.`user_company_id` AS 'fmfolders_fk_c__user_company_id',
	fmfolders_fk_c.`user_id` AS 'fmfolders_fk_c__user_id',
	fmfolders_fk_c.`contact_company_id` AS 'fmfolders_fk_c__contact_company_id',
	fmfolders_fk_c.`email` AS 'fmfolders_fk_c__email',
	fmfolders_fk_c.`name_prefix` AS 'fmfolders_fk_c__name_prefix',
	fmfolders_fk_c.`first_name` AS 'fmfolders_fk_c__first_name',
	fmfolders_fk_c.`additional_name` AS 'fmfolders_fk_c__additional_name',
	fmfolders_fk_c.`middle_name` AS 'fmfolders_fk_c__middle_name',
	fmfolders_fk_c.`last_name` AS 'fmfolders_fk_c__last_name',
	fmfolders_fk_c.`name_suffix` AS 'fmfolders_fk_c__name_suffix',
	fmfolders_fk_c.`title` AS 'fmfolders_fk_c__title',
	fmfolders_fk_c.`vendor_flag` AS 'fmfolders_fk_c__vendor_flag',

	fmfolders_fk_p.`id` AS 'fmfolders_fk_p__project_id',
	fmfolders_fk_p.`project_type_id` AS 'fmfolders_fk_p__project_type_id',
	fmfolders_fk_p.`user_company_id` AS 'fmfolders_fk_p__user_company_id',
	fmfolders_fk_p.`user_custom_project_id` AS 'fmfolders_fk_p__user_custom_project_id',
	fmfolders_fk_p.`project_name` AS 'fmfolders_fk_p__project_name',
	fmfolders_fk_p.`project_owner_name` AS 'fmfolders_fk_p__project_owner_name',
	fmfolders_fk_p.`latitude` AS 'fmfolders_fk_p__latitude',
	fmfolders_fk_p.`longitude` AS 'fmfolders_fk_p__longitude',
	fmfolders_fk_p.`address_line_1` AS 'fmfolders_fk_p__address_line_1',
	fmfolders_fk_p.`address_line_2` AS 'fmfolders_fk_p__address_line_2',
	fmfolders_fk_p.`address_line_3` AS 'fmfolders_fk_p__address_line_3',
	fmfolders_fk_p.`address_line_4` AS 'fmfolders_fk_p__address_line_4',
	fmfolders_fk_p.`address_city` AS 'fmfolders_fk_p__address_city',
	fmfolders_fk_p.`address_county` AS 'fmfolders_fk_p__address_county',
	fmfolders_fk_p.`address_state_or_region` AS 'fmfolders_fk_p__address_state_or_region',
	fmfolders_fk_p.`address_postal_code` AS 'fmfolders_fk_p__address_postal_code',
	fmfolders_fk_p.`address_postal_code_extension` AS 'fmfolders_fk_p__address_postal_code_extension',
	fmfolders_fk_p.`address_country` AS 'fmfolders_fk_p__address_country',
	fmfolders_fk_p.`building_count` AS 'fmfolders_fk_p__building_count',
	fmfolders_fk_p.`unit_count` AS 'fmfolders_fk_p__unit_count',
	fmfolders_fk_p.`gross_square_footage` AS 'fmfolders_fk_p__gross_square_footage',
	fmfolders_fk_p.`net_rentable_square_footage` AS 'fmfolders_fk_p__net_rentable_square_footage',
	fmfolders_fk_p.`is_active_flag` AS 'fmfolders_fk_p__is_active_flag',
	fmfolders_fk_p.`public_plans_flag` AS 'fmfolders_fk_p__public_plans_flag',
	fmfolders_fk_p.`prevailing_wage_flag` AS 'fmfolders_fk_p__prevailing_wage_flag',
	fmfolders_fk_p.`city_business_license_required_flag` AS 'fmfolders_fk_p__city_business_license_required_flag',
	fmfolders_fk_p.`is_internal_flag` AS 'fmfolders_fk_p__is_internal_flag',
	fmfolders_fk_p.`project_contract_date` AS 'fmfolders_fk_p__project_contract_date',
	fmfolders_fk_p.`project_start_date` AS 'fmfolders_fk_p__project_start_date',
	fmfolders_fk_p.`project_completed_date` AS 'fmfolders_fk_p__project_completed_date',
	fmfolders_fk_p.`sort_order` AS 'fmfolders_fk_p__sort_order',

	fmfolders.*

FROM `file_manager_folders` fmfolders
	INNER JOIN `user_companies` fmfolders_fk_uc ON fmfolders.`user_company_id` = fmfolders_fk_uc.`id`
	INNER JOIN `contacts` fmfolders_fk_c ON fmfolders.`contact_id` = fmfolders_fk_c.`id`
	INNER JOIN `projects` fmfolders_fk_p ON fmfolders.`project_id` = fmfolders_fk_p.`id`
WHERE fmfolders.`id` = ?
";
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$fileManagerFolder->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['fmfolders_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'fmfolders_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$fileManagerFolder->setUserCompany($userCompany);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['fmfolders_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'fmfolders_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$fileManagerFolder->setContact($contact);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['fmfolders_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'fmfolders_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$fileManagerFolder->setProject($project);

			return $fileManagerFolder;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_file_manager_folder` (`user_company_id`,`project_id`,`virtual_file_path`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param string $virtual_file_path
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndProjectIdAndVirtualFilePath($database, $user_company_id, $project_id, $virtual_file_path)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	fmfolders.*

FROM `file_manager_folders` fmfolders
WHERE fmfolders.`user_company_id` = ?
AND fmfolders.`project_id` = ?
AND fmfolders.`virtual_file_path` = ?
";
		$arrValues = array($user_company_id, $project_id, $virtual_file_path);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			return $fileManagerFolder;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrFileManagerFolderIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFoldersByArrFileManagerFolderIds($database, $arrFileManagerFolderIds, Input $options=null)
	{
		if (empty($arrFileManagerFolderIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFolder = new FileManagerFolder($database);
			$sqlOrderByColumns = $tmpFileManagerFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrFileManagerFolderIds as $k => $file_manager_folder_id) {
			$file_manager_folder_id = (int) $file_manager_folder_id;
			$arrFileManagerFolderIds[$k] = $db->escape($file_manager_folder_id);
		}
		$csvFileManagerFolderIds = join(',', $arrFileManagerFolderIds);

		$query =
"
SELECT

	fmfolders.*

FROM `file_manager_folders` fmfolders
WHERE fmfolders.`id` IN ($csvFileManagerFolderIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrFileManagerFoldersByCsvFileManagerFolderIds = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$fileManagerFolder->convertPropertiesToData();

			$arrFileManagerFoldersByCsvFileManagerFolderIds[$file_manager_folder_id] = $fileManagerFolder;
		}

		$db->free_result();

		return $arrFileManagerFoldersByCsvFileManagerFolderIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `file_manager_folders_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFoldersByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrFileManagerFoldersByUserCompanyId = null;
		}

		$arrFileManagerFoldersByUserCompanyId = self::$_arrFileManagerFoldersByUserCompanyId;
		if (isset($arrFileManagerFoldersByUserCompanyId) && !empty($arrFileManagerFoldersByUserCompanyId)) {
			return $arrFileManagerFoldersByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFolder = new FileManagerFolder($database);
			$sqlOrderByColumns = $tmpFileManagerFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfolders.*

FROM `file_manager_folders` fmfolders
WHERE fmfolders.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFoldersByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrFileManagerFoldersByUserCompanyId[$file_manager_folder_id] = $fileManagerFolder;
		}

		$db->free_result();

		self::$_arrFileManagerFoldersByUserCompanyId = $arrFileManagerFoldersByUserCompanyId;

		return $arrFileManagerFoldersByUserCompanyId;
	}

	/**
	 * Load by constraint `file_manager_folders_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFoldersByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrFileManagerFoldersByContactId = null;
		}

		$arrFileManagerFoldersByContactId = self::$_arrFileManagerFoldersByContactId;
		if (isset($arrFileManagerFoldersByContactId) && !empty($arrFileManagerFoldersByContactId)) {
			return $arrFileManagerFoldersByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFolder = new FileManagerFolder($database);
			$sqlOrderByColumns = $tmpFileManagerFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfolders.*

FROM `file_manager_folders` fmfolders
WHERE fmfolders.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFoldersByContactId = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrFileManagerFoldersByContactId[$file_manager_folder_id] = $fileManagerFolder;
		}

		$db->free_result();

		self::$_arrFileManagerFoldersByContactId = $arrFileManagerFoldersByContactId;

		return $arrFileManagerFoldersByContactId;
	}

	/**
	 * Load by constraint `file_manager_folders_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFoldersByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrFileManagerFoldersByProjectId = null;
		}

		$arrFileManagerFoldersByProjectId = self::$_arrFileManagerFoldersByProjectId;
		if (isset($arrFileManagerFoldersByProjectId) && !empty($arrFileManagerFoldersByProjectId)) {
			return $arrFileManagerFoldersByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFolder = new FileManagerFolder($database);
			$sqlOrderByColumns = $tmpFileManagerFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfolders.*

FROM `file_manager_folders` fmfolders
WHERE fmfolders.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFoldersByProjectId = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrFileManagerFoldersByProjectId[$file_manager_folder_id] = $fileManagerFolder;
		}

		$db->free_result();

		self::$_arrFileManagerFoldersByProjectId = $arrFileManagerFoldersByProjectId;

		return $arrFileManagerFoldersByProjectId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `deleted_file_manager_folders` (`user_company_id`,`project_id`,`deleted_flag`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param string $deleted_flag
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag($database, $user_company_id, $project_id, $deleted_flag, Input $options=null)
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
			self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag = null;
		}

		$arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag = self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag;
		if (isset($arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag) && !empty($arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag)) {
			return $arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag;
		}

		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;
		$deleted_flag = (string) $deleted_flag;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFolder = new FileManagerFolder($database);
			$sqlOrderByColumns = $tmpFileManagerFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfolders.*

FROM `file_manager_folders` fmfolders
WHERE fmfolders.`user_company_id` = ?
AND fmfolders.`project_id` = ?
AND fmfolders.`deleted_flag` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($user_company_id, $project_id, $deleted_flag);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag[$file_manager_folder_id] = $fileManagerFolder;
		}

		$db->free_result();

		self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag = $arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag;

		return $arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDeletedFlag;
	}

	/**
	 * Load by key `directly_deleted_file_manager_folders` (`user_company_id`,`project_id`,`directly_deleted_flag`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param string $directly_deleted_flag
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag($database, $user_company_id, $project_id, $directly_deleted_flag, Input $options=null)
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
			self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = null;
		}

		$arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
		if (isset($arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag) && !empty($arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag)) {
			return $arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
		}

		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;
		$directly_deleted_flag = (string) $directly_deleted_flag;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFolder = new FileManagerFolder($database);
			$sqlOrderByColumns = $tmpFileManagerFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfolders.*

FROM `file_manager_folders` fmfolders
WHERE fmfolders.`user_company_id` = ?
AND fmfolders.`project_id` = ?
AND fmfolders.`directly_deleted_flag` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($user_company_id, $project_id, $directly_deleted_flag);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag[$file_manager_folder_id] = $fileManagerFolder;
		}

		$db->free_result();

		self::$_arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = $arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;

		return $arrFileManagerFoldersByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
	}

	/**
	 * Load by key `virtual_file_path` (`virtual_file_path`).
	 *
	 * @param string $database
	 * @param string $virtual_file_path
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileManagerFoldersByVirtualFilePath($database, $virtual_file_path, Input $options=null)
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
			self::$_arrFileManagerFoldersByVirtualFilePath = null;
		}

		$arrFileManagerFoldersByVirtualFilePath = self::$_arrFileManagerFoldersByVirtualFilePath;
		if (isset($arrFileManagerFoldersByVirtualFilePath) && !empty($arrFileManagerFoldersByVirtualFilePath)) {
			return $arrFileManagerFoldersByVirtualFilePath;
		}

		$virtual_file_path = (string) $virtual_file_path;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFolder = new FileManagerFolder($database);
			$sqlOrderByColumns = $tmpFileManagerFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfolders.*

FROM `file_manager_folders` fmfolders
WHERE fmfolders.`virtual_file_path` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($virtual_file_path);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFoldersByVirtualFilePath = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrFileManagerFoldersByVirtualFilePath[$file_manager_folder_id] = $fileManagerFolder;
		}

		$db->free_result();

		self::$_arrFileManagerFoldersByVirtualFilePath = $arrFileManagerFoldersByVirtualFilePath;

		return $arrFileManagerFoldersByVirtualFilePath;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all file_manager_folders records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllFileManagerFolders($database, Input $options=null)
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
			self::$_arrAllFileManagerFolders = null;
		}

		$arrAllFileManagerFolders = self::$_arrAllFileManagerFolders;
		if (isset($arrAllFileManagerFolders) && !empty($arrAllFileManagerFolders)) {
			return $arrAllFileManagerFolders;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFolder = new FileManagerFolder($database);
			$sqlOrderByColumns = $tmpFileManagerFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfolders.*

FROM `file_manager_folders` fmfolders{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `virtual_file_path` ASC, `virtual_file_path_sha1` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllFileManagerFolders = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrAllFileManagerFolders[$file_manager_folder_id] = $fileManagerFolder;
		}

		$db->free_result();

		self::$_arrAllFileManagerFolders = $arrAllFileManagerFolders;

		return $arrAllFileManagerFolders;
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
INTO `file_manager_folders`
(`user_company_id`, `contact_id`, `project_id`, `virtual_file_path`, `virtual_file_path_sha1`, `modified`, `created`, `deleted_flag`, `directly_deleted_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `contact_id` = ?, `virtual_file_path_sha1` = ?, `modified` = ?, `created` = ?, `deleted_flag` = ?, `directly_deleted_flag` = ?
";
		$arrValues = array($this->user_company_id, $this->contact_id, $this->project_id, $this->virtual_file_path, $this->virtual_file_path_sha1, $this->modified, $this->created, $this->deleted_flag, $this->directly_deleted_flag, $this->contact_id, $this->virtual_file_path_sha1, $this->modified, $this->created, $this->deleted_flag, $this->directly_deleted_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$file_manager_folder_id = $db->insertId;
		$db->free_result();

		return $file_manager_folder_id;
	}

	// Save: insert ignore

	/**
	 * Filter out bad filename/filepath chars \ / : * ? " < > |
	 *
	 * @param unknown_type $filepath
	 */
	public function getFilteredVirtualFilePath()
	{
		if (isset($this->filteredVirtualFilePath)) {
			return $this->filteredVirtualFilePath;
		}

		if ($this->virtual_file_path == '/') {
			$this->filteredVirtualFilePath = '/';
			return $this->filteredVirtualFilePath;
		}

		$tempFilepath = str_replace('\\', '/', $this->virtual_file_path);
		$arrTempFilepath = preg_split('#[\/]+#', $tempFilepath, -1, PREG_SPLIT_NO_EMPTY);

		$arrFilteredFilepath = array();
		foreach ($arrTempFilepath as $tmpNode) {
			$pathNode = preg_replace('#[\/\\\:\*\?\"\>\<]#', '', $tmpNode);
			$arrFilteredFilepath[] = $pathNode;
		}

		if (count($arrFilteredFilepath) > 1) {
			$filteredVirtualFilePath = join('/', $arrFilteredFilepath);
		} else {
			$filteredVirtualFilePath = array_pop($arrFilteredFilepath);
		}
		$filteredVirtualFilePath = '/'.$filteredVirtualFilePath.'/';
		$this->filteredVirtualFilePath = $filteredVirtualFilePath;

		return $filteredVirtualFilePath;
	}

	/**
	 * Filter out bad filename/filepath chars \ / : * ? " < > |
	 *
	 * @param string $unfilteredFolderName
	 */
	public static function getFilteredVirtualFolderName($unfilteredFolderName)
	{
		$tempFolderName = str_replace('\\', '/', $unfilteredFolderName);
		$arrTempFilepath = preg_split('#[\/]+#', $tempFolderName, -1, PREG_SPLIT_NO_EMPTY);
		$tempFolderName = array_pop($arrTempFilepath);
		$filteredFolderName = preg_replace('#[\/\\\:\*\?\"\>\<]#', '', $tempFolderName);

		return $filteredFolderName;
	}

	public function loadPermissions($permissions=null)
	{
		if (!isset($this->file_manager_folder_id) || !isset($this->project_id)) {
			return;
		}

		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		if($permissions == null){
			$permissions = Zend_Registry::get('permissions');
		}
		$user_company_id = $permissions->getUserCompanyId();
		$user_id = $permissions->getUserId();
		$user_role_id = $permissions->getUserRoleId();
		$userRole = $permissions->getUserRole();
		$primary_contact_id = $permissions->getPrimaryContactId();
		$currentlySelectedProjectId = $permissions->getCurrentlySelectedProjectId();
		$currentlySelectedProjectUserCompanyId = $permissions->getCurrentlySelectedProjectUserCompanyId();
		$currentlyActiveContactId = $permissions->getCurrentlyActiveContactId();

		$projectOwnerFlag = $permissions->getProjectOwnerFlag();
		$projectOwnerAdminFlag = $permissions->getProjectOwnerAdminFlag();
		$paying_customer_flag = $permissions->getPayingCustomerFlag();

		$arrContactRoles = $permissions->getContactRoles();
		$arrProjectRoles = $permissions->getProjectRoles();

		$database = $this->getDatabase();
		$file_manager_folder_id = $this->file_manager_folder_id;
		//$virtual_file_path = $this->virtual_file_path;
		$project_id = $this->project_id;

		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			if ($userRole == 'user') {
				$arrContactRoleIds = array_keys($arrContactRoles);
				// non-admins must have at least one role
				if (empty($arrContactRoleIds)) {
					return array();
				}
				$in = join(',', $arrContactRoleIds);
				if (isset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$grantAllPermissionsFlag = true;
				} else {
					$grantAllPermissionsFlag = false;
				}
			} else {
				// admin or global_admin case
				$grantAllPermissionsFlag = true;
			}
		} else {
			// Project Files case
			if ($projectOwnerAdminFlag) {
				$grantAllPermissionsFlag = true;
			} elseif (!$projectOwnerFlag || ($projectOwnerFlag && ($userRole == 'user'))) {
				// non-project-owner-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
				// If this person has the "admin" role for the project, then grant all permissions
				// Currently we do no allow "admin" to be assigned by project.
				// Should this be "Project Executive"???
				if (isset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$grantAllPermissionsFlag = true;
				} else {
					$grantAllPermissionsFlag = false;

					$arrProjectRoleIds = array_keys($arrProjectRoles);
					$in = join(',', $arrProjectRoleIds);
				}
			}
		}

		if ($grantAllPermissionsFlag) {
			$this->grant_privileges_privilege = 'Y';
			$this->rename_privilege = 'Y';
			$this->upload_privilege = 'Y';
			$this->move_privilege = 'Y';
			$this->delete_privilege = 'Y';

			return;
		}

		$this->grant_privileges_privilege = 'N';
		$this->rename_privilege = 'N';
		$this->upload_privilege = 'N';
		$this->move_privilege = 'N';
		$this->delete_privilege = 'N';

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		$query =
"
SELECT r2f.*
FROM `roles_to_folders` r2f
WHERE `file_manager_folder_id` = $this->file_manager_folder_id
AND role_id IN ($in)
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrRolesToFolders = array();
		while($row = $db->fetch()) {
			$grant_privileges_privilege = $row['grant_privileges_privilege'];
			$rename_privilege = $row['rename_privilege'];
			$upload_privilege = $row['upload_privilege'];
			$move_privilege = $row['move_privilege'];
			$delete_privilege = $row['delete_privilege'];

			if ($grant_privileges_privilege == 'Y') {
				$this->grant_privileges_privilege = 'Y';
			}

			if ($rename_privilege == 'Y') {
				$this->rename_privilege = 'Y';
			}

			if ($upload_privilege == 'Y') {
				$this->upload_privilege = 'Y';
			}

			if ($move_privilege == 'Y') {
				$this->move_privilege = 'Y';
			}

			if ($delete_privilege == 'Y') {
				$this->delete_privilege = 'Y';
			}

			$role_id = $row['role_id'];
			$roleToFolder = new RoleToFolder($database);
			$key = array(
				'role_id' => $role_id,
				'file_manager_folder_id' => $this->file_manager_folder_id
			);
			$roleToFolder->setKey($key);
			$roleToFolder->setData($row);
			$roleToFolder->convertDataToProperties();

			$arrRolesToFolders[$role_id] = $roleToFolder;
		}

		$this->setRolesToFolders($arrRolesToFolders);

		return;
	}

	public function getRolesToFolders()
	{
		if (isset($this->rolesToFolders)) {
			return $this->rolesToFolders;
		} else {
			return array();
		}
	}

	public function setRolesToFolders($arrRolesToFolders)
	{
		$this->rolesToFolders = $arrRolesToFolders;
	}

	public function loadRolesToFolders()
	{
		if (!isset($this->file_manager_folder_id)) {
			return;
		}

		$db = $this->getDb();

		$query =
"
SELECT *
FROM `roles_to_folders`
WHERE `file_manager_folder_id` = $this->file_manager_folder_id
";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrRolesToFolders = array();
		while($row = $db->fetch()) {
			$role_id = $row['role_id'];
			$roleToFolder = new RoleToFolder($database);
			$key = array(
				'role_id' => $role_id,
				'file_manager_folder_id' => $this->file_manager_folder_id
			);
			$roleToFolder->setKey($key);
			$roleToFolder->setData($row);
			$roleToFolder->convertDataToProperties();

			$arrRolesToFolders[$role_id] = $roleToFolder;
		}

		$this->setRolesToFolders($arrRolesToFolders);
	}

	/*
	public function deriveFolderName()
	{
		$virtual_file_path = $this->virtual_file_path;
		if ($virtual_file_path == '/') {
			$derivedFolderName = '';
		} else {
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$derivedFolderName = array_pop($arrFolders);
		}

		$this->derivedFolderName = $derivedFolderName;
	}
	*/

	public function getRootFolderName()
	{
		$virtual_file_path = $this->virtual_file_path;

		if ($virtual_file_path <> '/') {
			$folderName = $this->getFolderName();
			return $folderName;
		}

		$project_id = $this->project_id;

		$database = $this->getDatabase();
		$project = Project::findProjectById($database, $project_id);
		$folderName = $project->project_name;

		return $folderName;
	}

	public function getFolderName()
	{
		if (!isset($this->derivedFolderName)) {
			$this->deriveFolderNameAndPathInformation();
		}

		return $this->derivedFolderName;
	}

	/*
	public function deriveParentFolderName()
	{
		$virtual_file_path = $this->virtual_file_path;
		if ($virtual_file_path == '/') {
			$derivedParentFolderName = '';
		} else {
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($arrFolders) && !empty($arrFolders)) {
				$count = count($arrFolders);
				if ($count > 1) {
					$arrIndex = $count-2;
					$derivedParentFolderName = $arrFolders[$arrIndex];
				} else {
					$derivedParentFolderName = '';
				}
			} else {
				$derivedParentFolderName = '';
			}
		}

		$this->derivedParentFolderName = $derivedParentFolderName;
	}
	*/

	public function getParentFolderName()
	{
		if (!isset($this->derivedParentFolderName)) {
			$this->deriveFolderNameAndPathInformation();
		}

		return $this->derivedParentFolderName;
	}

	public function deriveFolderNameAndPathInformation()
	{
		$virtual_file_path = $this->virtual_file_path;
		if ($virtual_file_path == '/') {
			$derivedFolderName = '';
			$derivedParentFolderName = '';
			$derivedParentFolderPath = '';
		} else {
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($arrFolders) && !empty($arrFolders)) {
				$count = count($arrFolders);
				if ($count > 1) {
					$derivedFolderName = $arrFolders[$count-1];
					$derivedParentFolderName = $arrFolders[$count-2];
					array_pop($arrFolders);
					$derivedParentFolderPath = join('/', $arrFolders);
					$derivedParentFolderPath = '/'.$derivedParentFolderPath.'/';
				} elseif ($count == 1) {
					$derivedFolderName = $arrFolders[0];
					$derivedParentFolderName = '';
					$derivedParentFolderPath = '/';
				} else {
					$derivedFolderName = '';
					$derivedParentFolderName = '';
					$derivedParentFolderPath = '';
				}
			} else {
				$derivedFolderName = '';
				$derivedParentFolderName = '';
				$derivedParentFolderPath = '';
			}
		}

		$this->derivedFolderName = $derivedFolderName;
		$this->derivedParentFolderName = $derivedParentFolderName;
		$this->derivedParentFolderPath = $derivedParentFolderPath;
	}

	public function deriveParentFolderId()
	{
		$virtual_file_path = $this->virtual_file_path;
		if ($virtual_file_path == '/') {
			$this->derivedParentFolderId = 0;
			return;
		} else {
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($arrFolders) && !empty($arrFolders)) {
				$count = count($arrFolders);
				if ($count > 1) {
					$derivedFolderName = $arrFolders[$count-1];
					$derivedParentFolderName = $arrFolders[$count-2];
					array_pop($arrFolders);
					$derivedParentFolderPath = join('/', $arrFolders);
					$derivedParentFolderPath = '/'.$derivedParentFolderPath.'/';
				} elseif ($count == 1) {
					$derivedFolderName = $arrFolders[0];
					$derivedParentFolderName = '';
					$derivedParentFolderPath = '/';
				} else {
					$derivedFolderName = '';
					$derivedParentFolderName = '';
					$derivedParentFolderPath = '';
				}
			} else {
				$derivedFolderName = '';
				$derivedParentFolderName = '';
				$derivedParentFolderPath = '';
			}
		}

		if (isset($derivedParentFolderPath) && !empty($derivedParentFolderPath)) {
			$database = $this->getDatabase();
			$user_company_id = $this->user_company_id;
			$contact_id = $this->contact_id;
			$project_id = $this->project_id;
			$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $derivedParentFolderPath);
			$dataLoadedFlag = $fileManagerFolder->isDataLoaded();
			if ($dataLoadedFlag) {
				$derivedParentFolderId = $fileManagerFolder->file_manager_folder_id;
				$this->derivedParentFolderId = $derivedParentFolderId;
			} else {
				$this->derivedParentFolderId = 0;
			}
		} else {
			$this->derivedParentFolderId = 0;
		}
	}

	public function getParentFolderId()
	{
		if (!isset($this->derivedParentFolderId)) {
			$this->deriveParentFolderId();
		}

		return $this->derivedParentFolderId;
	}

	public function renameVirtualFilePath($newFolderName)
	{
		if (!isset($newFolderName) || empty($newFolderName)) {
			throw new Exception('Invalid folder name.');
		}

		$virtual_file_path = $this->virtual_file_path;
		if (!isset($virtual_file_path) || empty($virtual_file_path)) {
			throw new Exception('Invalid folder node.');
		}

		if ($virtual_file_path == '/') {
			throw new Exception('Cannot rename root node ("/").');
		} else {
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$count = count($arrFolders);
			$existingFolderName = $arrFolders[$count-1];
			$arrFolders[$count-1] = $newFolderName;
			$newVirtualFilePath = join('/', $arrFolders);
			$newVirtualFilePath = '/'.$newVirtualFilePath.'/';
			$this->virtual_file_path = $newVirtualFilePath;
		}
	}

	public function renameParentVirtualFilePath($newFolderName)
	{
		if (!isset($newFolderName) || empty($newFolderName)) {
			throw new Exception('Invalid folder name.');
		}

		$virtual_file_path = $this->virtual_file_path;
		if (!isset($virtual_file_path) || empty($virtual_file_path)) {
			throw new Exception('Invalid folder node.');
		}

		if ($virtual_file_path == '/') {
			throw new Exception('Cannot rename root node ("/").');
		} else {
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$count = count($arrFolders);
			if ($count > 1) {
				$existingFolderName = $arrFolders[$count-2];
				$arrFolders[$count-2] = $newFolderName;
				$newVirtualFilePath = join('/', $arrFolders);
				$newVirtualFilePath = '/'.$newVirtualFilePath.'/';
				$this->virtual_file_path = $newVirtualFilePath;
			}
		}
	}

	public function renameAncestorVirtualFilePath($newFolderName, $folderPosition)
	{
		if (!isset($newFolderName) || empty($newFolderName)) {
			throw new Exception('Invalid folder name.');
		}

		$virtual_file_path = $this->virtual_file_path;
		if (!isset($virtual_file_path) || empty($virtual_file_path)) {
			throw new Exception('Invalid folder node.');
		}

		if ($virtual_file_path == '/') {
			throw new Exception('Cannot rename root node ("/").');
		} else {
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			if (isset($arrFolders[$folderPosition])) {
				$existingFolderName = $arrFolders[$folderPosition];
				$arrFolders[$folderPosition] = $newFolderName;
				$newVirtualFilePath = join('/', $arrFolders);
				$newVirtualFilePath = '/'.$newVirtualFilePath.'/';
				$this->virtual_file_path = $newVirtualFilePath;
			}

			/*
			$count = count($arrFolders);
			if ($count > 1) {
				$existingFolderName = $arrFolders[$count-2];
				$arrFolders[$count-2] = $newFolderName;
				$newVirtualFilePath = join('/', $arrFolders);
				$newVirtualFilePath = '/'.$newVirtualFilePath.'/';
				$this->virtual_file_path = $newVirtualFilePath;
			}
			*/
		}
	}

	public function rename($newFolderName)
	{
		if (!isset($newFolderName) || empty($newFolderName)) {
			throw new Exception('Invalid folder name.');
		}

		$virtual_file_path = $this->virtual_file_path;
		if (!isset($virtual_file_path) || empty($virtual_file_path)) {
			throw new Exception('Invalid folder node.');
		}

		// Get the position of the folder in the virtual_file_path
		// e.g. /a/b/c/ would be "folder c at position 2 in the array split on '/'"
		$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
		$folderPosition = count($arrFolders) - 1;

		if ($virtual_file_path == '/') {
			throw new Exception('Cannot rename root node ("/").');
		} else {
			$this->renameVirtualFilePath($newFolderName);
			$newVirtualFilePath = $this->virtual_file_path;
			/*
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$count = count($arrFolders);
			$existingFolderName = $arrFolders[$count-1];
			$arrFolders[$count-1] = $newFolderName;
			$newVirtualFilePath = join('/', $arrFolders);
			$newVirtualFilePath = '/'.$newVirtualFilePath.'/';
			$this->virtual_file_path = $newVirtualFilePath;
			*/
		}

		// Check for duplicate folder name case
		$database = $this->getDatabase();
		$db = $this->getDb();
		/* @var $db DBI_mysqli */
		//$db->begin();

		$virtualFilePathExistsFlag = $this->checkIfVirtualFilePathExists($newVirtualFilePath);
		if ($virtualFilePathExistsFlag) {
			throw new Exception('Folder name already exists.');
		}

		// Update the database
		$data = $this->getData();
		unset($data['id']);
		unset($data['created']);
		$data['virtual_file_path'] = $this->virtual_file_path;
		$data['modified'] = null;
		$this->setData($data);
		$key = array('id' => $this->file_manager_folder_id);
		$this->setKey($key);

		$this->save();

		$user_company_id = $this->user_company_id;
		$project_id = $this->project_id;
		$arrSubTreeFolders = self::loadSubTreeFoldersByVirtualFilePath($database, $user_company_id, $project_id, $virtual_file_path);
		foreach ($arrSubTreeFolders as $subTreeFileManagerFolder) {
			/* @var $subTreeFileManagerFolder FileManagerFolder */
			$subTreeFileManagerFolder->renameAncestorVirtualFilePath($newFolderName, $folderPosition);
			$data = $subTreeFileManagerFolder->getData();
			unset($data['id']);
			unset($data['created']);
			$data['virtual_file_path'] = $subTreeFileManagerFolder->virtual_file_path;
			$data['modified'] = null;
			$subTreeFileManagerFolder->setData($data);
			$key = array('id' => $subTreeFileManagerFolder->file_manager_folder_id);
			$subTreeFileManagerFolder->setKey($key);
			$subTreeFileManagerFolder->save();
		}
		//$db->commit();

		$this->load();
		$this->convertDataToProperties();

		return true;
	}

	/**
	 * Pass in the complete virtual_file_path ("folder name" is the last node in the path)
	 * e.g. /a/b/c/ -> "c" is the new folder node
	 *
	 * @param string $virtual_file_path
	 * @return bool
	 */
	public function checkIfVirtualFilePathExists($virtual_file_path)
	{
		$database = $this->getDatabase();
		$db = $this->getDb();
		/* @var $db DBI_mysqli */

		// Check for duplicate name case
		// unique index (`user_company_id`, `project_id`, `virtual_file_path`),
		$query =
"
SELECT `id`
FROM `file_manager_folders`
WHERE `user_company_id` = ?
AND `project_id` = ?
AND BINARY `virtual_file_path` = ?
";
		$arrValues = array($this->user_company_id, $this->project_id, $virtual_file_path);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			return true;
		} else {
			return false;
		}
	}

	public function markAsDirectlyDeleted()
	{
		$id = $this->file_manager_folder_id;
		if (!isset($id) || empty($id)) {
			throw new Exception('Invalid folder node.');
		}

		$virtual_file_path = $this->virtual_file_path;
		if (!isset($virtual_file_path) || empty($virtual_file_path)) {
			throw new Exception('Invalid folder node.');
		}

		// Mark the folder and all child folders and files as deleted
		$database = $this->getDatabase();
		$user_company_id = $this->user_company_id;
		$project_id = $this->project_id;

		// wrap all updates in a single transaction
		$db = $this->getDb();
		$db->begin();

		// The folder that was directly deleted is flagged as such so it will display in the Trash Can directly
		$data = array(
			'directly_deleted_flag' => 'Y',
			'deleted_flag' => 'Y'
		);

		// Mark the folder node itself as deleted unless it is a root node ("/")
		if ($virtual_file_path != '/') {
			$query =
"
UPDATE `file_manager_folders`
SET `directly_deleted_flag` = 'Y',
	`deleted_flag` = 'Y'
WHERE `id` = $id
";
			$db->query($query);
			/*
			$key = array('id' => $id);
			$this->setKey($key);
			$this->setData($data);
			$this->save();
			*/
		}

		// Child folders are not displayed in the Trash Can directly, but are flagged as deleted so they won't show up in the standard Filesystem Tree
		$data = array('deleted_flag' => 'Y');

		// load a list of child files and mark them as deleted
		$arrChildFiles = FileManagerFile::loadChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $id, false);
		foreach ($arrChildFiles as $childFileManagerFile) {
			/* @var $childFileManagerFile FileManagerFile */
			// mark the subtree folder as deleted
			$key = array('id' => $childFileManagerFile->file_manager_file_id);
			$childFileManagerFile->setKey($key);
			$childFileManagerFile->setData($data);
			$childFileManagerFile->save();
		}

		$arrSubTreeFolders = self::loadSubTreeFoldersByVirtualFilePath($database, $user_company_id, $project_id, $virtual_file_path);
		foreach ($arrSubTreeFolders as $subTreeFileManagerFolder) {
			/* @var $subTreeFileManagerFolder FileManagerFolder */

			// load a list of child files and mark them as deleted
			$subTreeFolderId = $subTreeFileManagerFolder->file_manager_folder_id;
			$arrChildFiles = FileManagerFile::loadChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $subTreeFolderId, false);
			foreach ($arrChildFiles as $childFileManagerFile) {
				/* @var $childFileManagerFile FileManagerFile */
				// mark the subtree folder as deleted
				$key = array('id' => $childFileManagerFile->file_manager_file_id);
				$childFileManagerFile->setKey($key);
				$childFileManagerFile->setData($data);
				$childFileManagerFile->save();
			}

			// mark the subtree folder as deleted
			$childTreeFolderId = $subTreeFileManagerFolder->file_manager_folder_id;
			$query =
"
UPDATE `file_manager_folders`
SET
	`deleted_flag` = 'Y'
WHERE `id` = $childTreeFolderId
";
			$db->query($query);
			/*
			$key = array('id' => $subTreeFileManagerFolder->file_manager_folder_id);
			$subTreeFileManagerFolder->setKey($key);
			$subTreeFileManagerFolder->setData($data);
			$subTreeFileManagerFolder->save();
			*/
		}
		$db->commit();

		// load all attributes after the updates
		$this->setData(null);
		$this->load();
		$this->convertDataToProperties();

		return;
	}

	public function markAsNotDirectlyDeleted()
	{
		$id = $this->file_manager_folder_id;
		if (!isset($id) || empty($id)) {
			throw new Exception('Invalid folder node.');
		}

		$virtual_file_path = $this->virtual_file_path;
		if (!isset($virtual_file_path) || empty($virtual_file_path)) {
			throw new Exception('Invalid folder node.');
		}

		// Mark the folder and all child folders and files as deleted
		$database = $this->getDatabase();
		$user_company_id = $this->user_company_id;
		$project_id = $this->project_id;

		// wrap all updates in a single transaction
		$db = $this->getDb();
		$db->begin();

		// The folder that was directly deleted is flagged as such so it will display in the Trash Can directly
		$data = array(
			'directly_deleted_flag' => 'N',
			'deleted_flag' => 'N'
		);

		// /Trash/aa/aaa-2/
		// SUBSTRING('Quadratically',5);
		// Mark the folder node itself as deleted unless it is a root node ("/")
		if ($virtual_file_path != '/') {
			$query =
"
UPDATE `file_manager_folders`
SET
	
	`directly_deleted_flag` = 'N',
	`deleted_flag` = 'N'
WHERE `id` = $id
";
			$db->query($query);
			/*
			$key = array('id' => $id);
			$this->setKey($key);
			$this->setData($data);
			$this->save();
			*/
		}

		// Child folders are not displayed in the Trash Can directly, but are flagged as deleted so they won't show up in the standard Filesystem Tree
		$data = array('deleted_flag' => 'N');

		// load a list of child files and mark them as deleted
		$arrChildFiles = FileManagerFile::loadChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $id, true);
		foreach ($arrChildFiles as $childFileManagerFile) {
			/* @var $childFileManagerFile FileManagerFile */
			// mark the subtree folder as deleted
			$key = array('id' => $childFileManagerFile->file_manager_file_id);
			$childFileManagerFile->setKey($key);
			$childFileManagerFile->setData($data);
			$childFileManagerFile->save();
		}

		$arrSubTreeFolders = self::loadSubTreeFoldersByVirtualFilePath($database, $user_company_id, $project_id, $virtual_file_path);
		foreach ($arrSubTreeFolders as $subTreeFileManagerFolder) {
			/* @var $subTreeFileManagerFolder FileManagerFolder */

			// load a list of child files and mark them as deleted
			$subTreeFolderId = $subTreeFileManagerFolder->file_manager_folder_id;
			$arrChildFiles = FileManagerFile::loadChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $subTreeFolderId, true);
			foreach ($arrChildFiles as $childFileManagerFile) {
				/* @var $childFileManagerFile FileManagerFile */
				// mark the subtree folder as deleted
				$key = array('id' => $childFileManagerFile->file_manager_file_id);
				$childFileManagerFile->setKey($key);
				$childFileManagerFile->setData($data);
				$childFileManagerFile->save();
			}

			// mark the subtree folder as deleted
			$childTreeFolderId = $subTreeFileManagerFolder->file_manager_folder_id;
			$query =
"
UPDATE `file_manager_folders`
SET
	`deleted_flag` = 'N', 
	`directly_deleted_flag` = 'N'
WHERE `id` = $childTreeFolderId
";
			$db->query($query);
			/*
			$key = array('id' => $subTreeFileManagerFolder->file_manager_folder_id);
			$subTreeFileManagerFolder->setKey($key);
			$subTreeFileManagerFolder->setData($data);
			$subTreeFileManagerFolder->save();
			*/
		}
		$db->commit();

		// load all attributes after the updates
		$this->setData(null);
		$this->load();
		$this->convertDataToProperties();

		return;
	}

	public function permanentlyDelete()
	{
		$id = $this->file_manager_folder_id;
		if (!isset($id) || empty($id)) {
			throw new Exception('Invalid folder node.');
		}

		$virtual_file_path = $this->virtual_file_path;
		if (!isset($virtual_file_path) || empty($virtual_file_path)) {
			throw new Exception('Invalid folder node.');
		}

		// Mark the folder and all child folders and files as deleted
		$database = $this->getDatabase();
		$user_company_id = $this->user_company_id;
		$project_id = $this->project_id;

		// wrap all updates in a single transaction
		$db = $this->getDb();
		$db->begin();

		// load a list of child files and mark them as deleted
		$arrChildFiles = FileManagerFile::loadChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $id, true);
		foreach ($arrChildFiles as $childFileManagerFile) {
			/* @var $childFileManagerFile FileManagerFile */

			// delete from contacts_to_files
// 			$query =
// "
// DELETE
// FROM `contacts_to_files`
// WHERE `file_manager_file_id` = $childFileManagerFile->file_manager_file_id
// ";
// 			$db->query($query, MYSQLI_USE_RESULT);
//
// 			// delete from roles_to_files
// 			$query =
// "
// DELETE
// FROM `roles_to_files`
// WHERE `file_manager_file_id` = $childFileManagerFile->file_manager_file_id
// ";
// 			$db->query($query, MYSQLI_USE_RESULT);
			// delete the file
			$key = array('id' => $childFileManagerFile->file_manager_file_id);
			$childFileManagerFile->setKey($key);
			$childFileManagerFile->permanentlyDelete();
			// $childFileManagerFile->delete();
		}

		$arrSubTreeFolders = self::loadSubTreeFoldersByVirtualFilePath($database, $user_company_id, $project_id, $virtual_file_path);
		foreach ($arrSubTreeFolders as $subTreeFileManagerFolder) {
			/* @var $subTreeFileManagerFolder FileManagerFolder */

			// load a list of child files and delete them
			$subTreeFolderId = $subTreeFileManagerFolder->file_manager_folder_id;
			$arrChildFiles = FileManagerFile::loadChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $subTreeFolderId, true);
			foreach ($arrChildFiles as $childFileManagerFile) {
				/* @var $childFileManagerFile FileManagerFile */

				// delete from contacts_to_files
// 				$query =
// "
// DELETE
// FROM `contacts_to_files`
// WHERE `file_manager_file_id` = $childFileManagerFile->file_manager_file_id
// ";
// 				$db->query($query, MYSQLI_USE_RESULT);
//
// 				// delete from roles_to_files
// 				$query =
// "
// DELETE
// FROM `roles_to_files`
// WHERE `file_manager_file_id` = $childFileManagerFile->file_manager_file_id
// ";
// 				$db->query($query, MYSQLI_USE_RESULT);

				// delete the file
				$key = array('id' => $childFileManagerFile->file_manager_file_id);
				$childFileManagerFile->setKey($key);
				$childFileManagerFile->permanentlyDelete();
				// $childFileManagerFile->delete();
			}

			// delete the subtree folder
			$childTreeFolderId = $subTreeFileManagerFolder->file_manager_folder_id;

			// delete from contacts_to_folders
			$query =
"
DELETE
FROM `contacts_to_folders`
WHERE `file_manager_folder_id` = $childTreeFolderId
";
			$db->query($query, MYSQLI_USE_RESULT);

			// delete from roles_to_folders
			$query =
"
DELETE
FROM `roles_to_folders`
WHERE `file_manager_folder_id` = $childTreeFolderId
";
			$db->query($query, MYSQLI_USE_RESULT);

			$query =
"
DELETE
FROM `file_manager_folders`
WHERE `id` = $childTreeFolderId
";
			$db->query($query, MYSQLI_USE_RESULT);
		}

		// Delete the folder node itself unless it is a root node ("/")
		if ($virtual_file_path != '/') {
			// delete from contacts_to_folders
			$query =
"
DELETE
FROM `contacts_to_folders`
WHERE `file_manager_folder_id` = $id
";
			$db->query($query, MYSQLI_USE_RESULT);

			// delete from roles_to_folders
			$query =
"
DELETE
FROM `roles_to_folders`
WHERE `file_manager_folder_id` = $id
";
			$db->query($query, MYSQLI_USE_RESULT);

			$query =
"
DELETE
FROM `file_manager_folders`
WHERE `id` = $id
";
			$db->query($query, MYSQLI_USE_RESULT);
		}

		$db->commit();

		// load all attributes after the updates
		$this->setData(null);
		//$this->setKey(null);
		$this->convertDataToProperties();

		return;
	}

	public function getParentFolderPath()
	{
		if (!isset($this->derivedParentFolderPath)) {
			$this->deriveFolderNameAndPathInformation();
		}

		return $this->derivedParentFolderPath;
	}

	public function setFile($file)
	{
		$this->file = $file;
	}

	public function getFile()
	{
		$file = $this->file;

		return $file;
	}

	public static function frontEndWrite($filePath, $fileName, $fileId)
	{
		$config = Zend_Registry::get('config');
		$basePath = $config->system->file_manager_base_path;
		$session = Zend_Registry::get('session');
		/* @var $session Session */
		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$currentlyActiveContactId = $session->getCurrentlyActiveContactId();
		$project_id = $session->getCurrentlySelectedProjectId();
		$frontEndPath = $basePath.'frontend/'.$user_company_id.$filePath;

		// file is stored as a text file with its id value embedded
		$fileContents = $fileId;

		$file = new File();
		$file->fwrite($frontEndPath, $fileName, $fileContents);
	}

	public static function frontEndMove($oldPath, $newPath, $fileName)
	{
		$config = Zend_Registry::get('config');
		$basePath = $config->system->file_manager_base_path;
		$session = Zend_Registry::get('session');
		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();

		$oldName = $basePath.'frontend/'.$user_company_id.'/'.$oldPath.$fileName;
		$newName = $basePath.'frontend/'.$user_company_id.'/'.$newPath.$fileName;

		$successFlag = rename($oldName, $newName);

		return $successFlag;
	}

	public static function frontEndRename($filePath, $existingFileName, $newFileName)
	{
		$config = Zend_Registry::get('config');
		$basePath = $config->system->file_manager_base_path;
		$session = Zend_Registry::get('session');
		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();

		$oldName = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$existingFileName;
		$newName = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$newFileName;

		$successFlag = rename($oldName, $newName);

		return $successFlag;
	}

	public static function frontEndCopy($filePath, $existingFileName, $newFileName)
	{
		$config = Zend_Registry::get('config');
		$basePath = $config->system->file_manager_base_path;
		$session = Zend_Registry::get('session');
		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();

		$existingName = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$existingFileName;
		$newName = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$newFileName;

		$successFlag = copy($existingName, $newName);

		return $successFlag;
	}

	public static function frontEndDelete($filePath, $fileName)
	{
		$config = Zend_Registry::get('config');
		$basePath = $config->system->file_manager_base_path;
		$session = Zend_Registry::get('session');
		$user_company_id = $session->getUserCompanyId();
		$user_id = $session->getUserId();
		$project_id = $session->getCurrentlySelectedProjectId();
		$file = $basePath.'frontend/'.$user_company_id.'/'.$filePath.$fileName;

		$successFlag = unlink($file);

		return $successFlag;
	}

	public static function loadByIdSetSortedByPathLength($database, $arrId)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$in = join(',', $arrId);

		$query =
"
SELECT *
FROM `file_manager_folders`
WHERE `id` IN($in)
ORDER BY CHAR_LENGTH(`virtual_file_path`) ASC
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrRecords = array();
		while($row = $db->fetch()) {
			$object = new FileManagerFolder($database);
			$id = $row['id'];
			$key = array('id' => $id);
			$object->setId($id);
			$object->setKey($key);
			$object->setData($row);
			$object->convertDataToProperties();
			$arrRecords[$id] = $object;
		}
		$db->free_result();

		return $arrRecords;
	}

	/**
	 * Load a record from its virtual_file_path or save and return data.
	 */
	public static function findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $virtual_file_path)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$query = "SELECT * ".
				 "FROM `file_manager_folders` ".
				 "WHERE `user_company_id` = ? ".
				 "AND `project_id` = ? ".
				 "AND `virtual_file_path` = ? ";
		$arrValues = array($user_company_id, $project_id, $virtual_file_path);
		$db->execute($query, $arrValues);

		$row = $db->fetch();
		$db->free_result();

		$fileManagerFolder = new FileManagerFolder($database);
		if ($row) {
			$file_manager_folder_id = (int) $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$fileManagerFolder->setVirtualFilePathDidNotExist(false);
		} else {
			$fileManagerFolder->user_company_id = $user_company_id;
			$fileManagerFolder->contact_id = $contact_id;
			$fileManagerFolder->project_id = $project_id;
			$fileManagerFolder->virtual_file_path = $virtual_file_path;
			$fileManagerFolder->convertPropertiesToData();
			$fileManagerFolder['created'] = null;
			$file_manager_folder_id = $fileManagerFolder->save();
			$key = array('id' => $file_manager_folder_id);
			$fileManagerFolder->setKey($key);
			$fileManagerFolder->setData(array());
			$fileManagerFolder->load();
			$fileManagerFolder->convertDataToProperties();
			$fileManagerFolder->setId($file_manager_folder_id);
			$fileManagerFolder->setVirtualFilePathDidNotExist(true);
		}

		$db->commit();

		return $fileManagerFolder;
	}

	/**
	 * Load a record(s) from its virtual_file_path.
	 */
	public static function loadByVirtualFilePath($database, $user_company_id, $project_id, $virtual_file_path)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// should we use LIKE here???
		$query = "SELECT * ".
				 "FROM `file_manager_folders` ".
				 "WHERE `user_company_id` = ? ".
				 "AND `project_id` = ? ".
				 "AND `virtual_file_path` = ? ";
		$arrValues = array($user_company_id, $project_id, $virtual_file_path);
		$db->execute($query, $arrValues);

		$arrFileManagerFolders = array();
		while ($row = $db->fetch()) {
			$fmf = new FileManagerFolder($database);
			$fmf->setData($row);
			$fmf->convertDataToProperties();
			$arrFileManagerFolders[] = $fmf;
		}
		$db->free_result();

		return $arrFileManagerFolders;
	}

	/**
	 * Load the immediate child record(s) from a parent node's virtual_file_path.
	 */
	//public static function loadAccessibleChildFoldersByVirtualFilePath($database, $user_company_id, $project_id, $contact_id, $virtual_file_path, $showDeleted = false)
	public static function loadAccessibleChildFoldersByVirtualFilePath($database, $permissions, $parentFileManagerFolder, $showDeleted = false, $project_id='')
	{
		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;


		$user_company_id = $permissions->getUserCompanyId();
		$user_id = $permissions->getUserId();
		$user_role_id = $permissions->getUserRoleId();
		$userRole = $permissions->getUserRole();
		$primary_contact_id = $permissions->getPrimaryContactId();
		if($project_id!=''){
			$currentlySelectedProjectId = $project_id;
		}else{
			$currentlySelectedProjectId = $permissions->getCurrentlySelectedProjectId();
		}
		
		$currentlySelectedProjectUserCompanyId = $permissions->getCurrentlySelectedProjectUserCompanyId();
		$currentlyActiveContactId = $permissions->getCurrentlyActiveContactId();

		$projectOwnerFlag = $permissions->getProjectOwnerFlag();
		$projectOwnerAdminFlag = $permissions->getProjectOwnerAdminFlag();
		$paying_customer_flag = $permissions->getPayingCustomerFlag();

		$arrContactRoles = $permissions->getContactRoles();
		$arrProjectRoles = $permissions->getProjectRoles();


		$file_manager_folder_id = $parentFileManagerFolder->file_manager_folder_id;
		$virtual_file_path = $parentFileManagerFolder->virtual_file_path;
		$project_id = $parentFileManagerFolder->project_id;


		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			if ($userRole == 'user') {
				$arrContactRoleIds = array_keys($arrContactRoles);
				// non-admins must have at least one role
				if (empty($arrContactRoleIds)) {
					return array();
				}
				$in = join(',', $arrContactRoleIds);
				if (isset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$loadAllFilesFlag = true;
				} else {
					$loadAllFilesFlag = false;
				}
			} else {
				// admin or global_admin case
				$loadAllFilesFlag = true;
			}
		} else {
			// Project Files case
			if ($projectOwnerAdminFlag) {
				$loadAllFilesFlag = true;
			} elseif (!$projectOwnerFlag || ($projectOwnerFlag && ($userRole == 'user'))) {
				// non-project-owner-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
				// If this person has the "admin" role for the project, then grant all permissions
				// Currently we do no allow "admin" to be assigned by project.
				// Should this be "Project Executive"???
				if (isset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$loadAllFilesFlag = true;
				} else {
					$loadAllFilesFlag = false;

					$arrProjectRoleIds = array_keys($arrProjectRoles);
					$in = join(',', $arrProjectRoleIds);
				}
			}
		}


		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();


		/*
		// Get a list of role_id values
		$arrRoleIds = array();
		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company File case
			// Treat $contact_id as if it is primary_contact_id
			// contacts_to_roles
			$query =
				"SELECT c2r.`role_id` ".
				"FROM `contacts_to_roles` c2r ".
				"WHERE c2r.`contact_id` = ? ";
			$arrValues = array($contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			while ($row = $db->fetch()) {
				$role_id = $row['role_id'];
				$arrRoleIds[$role_id] = 1;
			}
			$db->free_result();
		} elseif ($project_id <> $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Check if admin and user_company_id is the "project owner"
			$query =
				"SELECT p.`user_company_id` ".
				"FROM `projects` p ".
				"WHERE p.`id` = ? ";
			$arrValues = array($project_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			$db->free_result();

			if ($row && isset($row['user_company_id'])) {
				$projectOwnerUserCompanyId = $row['user_company_id'];
				if ($user_company_id == $projectOwnerUserCompanyId) {
					// Check if this contact is an admin
					$query =
						"SELECT c2r.`role_id` ".
						"FROM `contacts_to_roles` c2r ".
						"WHERE c2r.`contact_id` = ? ".
						"AND c2r.`role_id` = $AXIS_USER_ROLE_ID_ADMIN";
					$arrValues = array($contact_id);
					$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
					while ($row = $db->fetch()) {
						$role_id = $row['role_id'];
						$arrRoleIds[$role_id] = 1;
					}
					$db->free_result();
				}
			}

			if (empty($arrRoleIds)) {
				// Project files case
				$query =
					"SELECT p2c2r.`role_id` ".
					"FROM `projects_to_contacts_to_roles` p2c2r ".
					"WHERE p2c2r.`project_id` = ? ".
					"AND p2c2r.`contact_id` = ? ";
				$arrValues = array($project_id, $contact_id);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				while ($row = $db->fetch()) {
					$role_id = $row['role_id'];
					$arrRoleIds[$role_id] = 1;
				}
				$db->free_result();
			}
		}

		// Check for admin case
		if (isset($arrRoleIds[$AXIS_USER_ROLE_ID_ADMIN])) {
			$adminFlag = true;
		} else {
			$adminFlag = false;

			// non-admins have to have a role
			if (empty($arrRoleIds)) {
				return array();
			}
		}
		*/
		$escaped_virtual_file_path = preg_quote($parentFileManagerFolder->virtual_file_path);
		$escaped_virtual_file_path = mysqli_real_escape_string($db->link_id, $escaped_virtual_file_path);

		// global_admin is just like admin for the file manager - sees all folders for their user_company_id
		// global_admin can use the impersonate user feature to see other files and folders
		// admin sees all folders for their given user_company_id
		$query =
"
SELECT *
FROM `file_manager_folders` fmf
";

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			$query .= ", `roles_to_folders` r2f ";
		}

		$query .=
"
WHERE fmf.`user_company_id` = ?
AND fmf.`project_id` = ?
AND fmf.`virtual_file_path` rlike '^".$escaped_virtual_file_path."[^/]+/$'
";

		if ($showDeleted) {
			$query .=
"
AND fmf.`deleted_flag` = 'Y'
";
		} else {
			$query .=
"
AND fmf.`deleted_flag` = 'N'
";
		}

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			//$arrIn = array_keys($arrRoleIds);
			//$in = join(',', $arrIn);
			$query .=
"
AND fmf.`id` = r2f.`file_manager_folder_id`
AND r2f.`role_id` IN ($in)
GROUP BY fmf.`id`
";
		}

		$query .=
"
ORDER BY fmf.`virtual_file_path`
";

		$arrValues = array($parentFileManagerFolder->user_company_id, $parentFileManagerFolder->project_id);
		$db->execute($query, $arrValues);

		$arrAccessibleChildFoldersByVirtualFilePath = array();
		$arrSort = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrAccessibleChildFoldersByVirtualFilePath[$file_manager_folder_id] = $fileManagerFolder;

			$arrSort[$fileManagerFolder->virtual_file_path] = $file_manager_folder_id;
		}
		$db->free_result();

		uksort($arrSort, 'strnatcasecmp');
		$arrReturn = array();
		foreach ($arrSort as $file_manager_folder_id) {
			$fileManagerFolder = $arrAccessibleChildFoldersByVirtualFilePath[$file_manager_folder_id];
			$arrReturn[$file_manager_folder_id] = $fileManagerFolder;

		}

		//return $arrAccessibleChildFoldersByVirtualFilePath;
		return $arrReturn;
	}

	/**
	 * Load the immediate child record(s) from a parent node's virtual_file_path.
	 */
	public static function loadAccessibleSubTreeFoldersByVirtualFilePath($database, $user_company_id, $project_id, $contact_id, $virtual_file_path, $showDeleted = false)
	{
		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		// Get a list of role_id values
		$arrRoleIds = array();
		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company File case
			// Treat $contact_id as if it is primary_contact_id
			// contacts_to_roles
			$query =
"
SELECT c2r.`role_id`
FROM `contacts_to_roles` c2r
WHERE c2r.`contact_id` = ?
";
			$arrValues = array($contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			while ($row = $db->fetch()) {
				$role_id = $row['role_id'];
				$arrRoleIds[$role_id] = 1;
			}
			$db->free_result();
		} elseif ($project_id <> $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Check if admin and user_company_id is the "project owner"
			$query =
"
SELECT p.`user_company_id`
FROM `projects` p
WHERE p.`id` = ?
";
			$arrValues = array($project_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			$db->free_result();

			if ($row && isset($row['user_company_id'])) {
				$projectOwnerUserCompanyId = $row['user_company_id'];
				if ($user_company_id == $projectOwnerUserCompanyId) {
					// Check if this contact is an admin
					$query =
"
SELECT c2r.`role_id`
FROM `contacts_to_roles` c2r
WHERE c2r.`contact_id` = ?
AND c2r.`role_id` = $AXIS_USER_ROLE_ID_ADMIN
";
					$arrValues = array($contact_id);
					$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
					while ($row = $db->fetch()) {
						$role_id = $row['role_id'];
						$arrRoleIds[$role_id] = 1;
					}
					$db->free_result();
				}
			}

			if (empty($arrRoleIds)) {
				// Project files case
				$query =
"
SELECT p2c2r.`role_id`
FROM `projects_to_contacts_to_roles` p2c2r
WHERE p2c2r.`project_id` = ?
AND p2c2r.`contact_id` = ?
";
				$arrValues = array($project_id, $contact_id);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				while ($row = $db->fetch()) {
					$role_id = $row['role_id'];
					$arrRoleIds[$role_id] = 1;
				}
				$db->free_result();
			}
		}

		// Check for admin case
		if (isset($arrRoleIds[$AXIS_USER_ROLE_ID_ADMIN])) {
			$adminFlag = true;
		} else {
			$adminFlag = false;

			// non-admins have to have a role
			if (empty($arrRoleIds)) {
				return array();
			}
		}

		$escaped_virtual_file_path = preg_quote($virtual_file_path);
		$escaped_virtual_file_path = mysqli_real_escape_string($db->link_id, $escaped_virtual_file_path);

		// global_admin is just like admin for the file manager - sees all folders for their user_company_id
		// global_admin can use the impersonate user feature to see other files and folders
		// admin sees all folders for their given user_company_id
		$query =
"
SELECT *
FROM `file_manager_folders` fmf
";

		// Role-based permissions
		if (!$adminFlag) {
			$query .= ", `roles_to_folders` r2f ";
		}

		$query .=
"
WHERE fmf.`user_company_id` = ?
AND fmf.`project_id` = ?
AND fmf.`virtual_file_path` rlike '^".$escaped_virtual_file_path.".*/$'
";

		if ($showDeleted) {
			$query .=
"
AND fmf.`deleted_flag` = 'Y'
";
		} else {
			$query .=
"
AND fmf.`deleted_flag` = 'N'
";
		}

		// Role-based permissions
		if (!$adminFlag) {
			$arrIn = array_keys($arrRoleIds);
			$in = join(',', $arrIn);
			$query .=
				"AND fmf.`id` = r2f.`file_manager_folder_id` ".
				"AND r2f.`role_id` IN ($in) ".
				"GROUP BY fmf.`id` ";
		}

		$query .=
			"ORDER BY fmf.`virtual_file_path` ";

		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues);

		$arrFileManagerFolders = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = new FileManagerFolder($database);
			$fileManagerFolder->setData($row);
			$fileManagerFolder->convertDataToProperties();
			$arrFileManagerFolders[$file_manager_folder_id] = $fileManagerFolder;
		}
		$db->free_result();

		return $arrFileManagerFolders;
	}

	/**
	 * Load the immediate child record(s) from a parent node's virtual_file_path.
	 */
	public static function loadChildFoldersByVirtualFilePath($database, $user_company_id, $project_id, $virtual_file_path, $showDeleted = false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		if ($showDeleted) {
			$and = "AND deleted_flag = 'Y' ";
		} else {
			$and = "AND deleted_flag = 'N' ";
		}

		$escaped_virtual_file_path = preg_quote($virtual_file_path);
		$escaped_virtual_file_path = mysqli_real_escape_string($db->link_id, $escaped_virtual_file_path);
		$query = "SELECT * ".
				 "FROM `file_manager_folders` ".
				 "WHERE `user_company_id` = ? ".
				 "AND `project_id` = ? ".
				 "AND `virtual_file_path` rlike '^".$escaped_virtual_file_path."[^/]+/$' ".
				 $and.
				 "ORDER BY `virtual_file_path` ";
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues);

		$arrFileManagerFolders = array();
		while ($row = $db->fetch()) {
			$fileManagerFolder = new FileManagerFolder($database);
			$fileManagerFolder->setData($row);
			$fileManagerFolder->convertDataToProperties();
			$arrFileManagerFolders[] = $fileManagerFolder;
		}
		$db->free_result();

		return $arrFileManagerFolders;
	}

	/**
	 * Load the immediate child record(s) from a parent node's virtual_file_path.
	 */
	public static function loadSubTreeFoldersByVirtualFilePath($database, $user_company_id, $project_id, $virtual_file_path)
	{
		$db = DBI::getInstance($database);
		$db->connect();
		/* @var $db DBI_mysqli */
		$virtual_file_path = preg_quote($virtual_file_path);
		$virtual_file_path = mysqli_real_escape_string($db->link_id, $virtual_file_path);

		$query = "SELECT * ".
				 "FROM `file_manager_folders` ".
				 "WHERE `user_company_id` = ? ".
				 "AND `project_id` = ? ".
				 "AND `virtual_file_path` <> '$virtual_file_path' ".
				 "AND `virtual_file_path` like '$virtual_file_path%' ".
				 "ORDER BY `virtual_file_path` ";
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues);

		$arrFileManagerFolders = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = new FileManagerFolder($database);
			$fileManagerFolder->setId($file_manager_folder_id);
			$key = array('id' => $file_manager_folder_id);
			$fileManagerFolder->setKey($key);
			$fileManagerFolder->setData($row);
			$fileManagerFolder->convertDataToProperties();
			$arrFileManagerFolders[$file_manager_folder_id] = $fileManagerFolder;
		}
		$db->free_result();

		return $arrFileManagerFolders;
	}

	/**
	 * Load folders that are in the trash.
	 */
	public static function loadTrashByProjectId($database, $user_company_id, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query = "SELECT * ".
				 "FROM `file_manager_folders` ".
				 "WHERE `user_company_id` = ? ".
				 "AND `project_id` = ? ".
				 "AND `directly_deleted_flag` = 'Y' ".
				 "ORDER BY `virtual_file_path` ";
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues);

		$arrFileManagerFolders = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = new FileManagerFolder($database);
			$fileManagerFolder->setData($row);
			$fileManagerFolder->convertDataToProperties();
			$arrFileManagerFolders[$file_manager_folder_id] = $fileManagerFolder;
		}
		$db->free_result();

		return $arrFileManagerFolders;
	}

	public static function groupFileManagerFolderIdsByProject($database, array $arrFolderIds)
	{
		if (empty($arrFolderIds)) {
			return array();
		}

		$in = join(',', $arrFolderIds);

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query = "SELECT `id`, `project_id` ".
				 "FROM `file_manager_folders` ".
				 "WHERE `id` IN ($in) ".
				 "AND `deleted_flag` = 'N' ".
				 "AND `directly_deleted_flag` = 'N' ";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrFileManagerFolderIdsByProjectId = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$project_id = $row['project_id'];
			$arrFileManagerFolderIdsByProjectId[$project_id][] = $file_manager_folder_id;
		}
		$db->free_result();

		return $arrFileManagerFolderIdsByProjectId;
	}

	public static function loadPermissionsMatrixByIdList($database, $arrFileManagerFolderIds, $project_id, $permissions=null)
	{
		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		if($permissions == null){
			$permissions = Zend_Registry::get('permissions');
		}
		$user_company_id = $permissions->getUserCompanyId();
		$user_id = $permissions->getUserId();
		$user_role_id = $permissions->getUserRoleId();
		$userRole = $permissions->getUserRole();
		$primary_contact_id = $permissions->getPrimaryContactId();
		$currentlySelectedProjectId = $permissions->getCurrentlySelectedProjectId();
		$currentlySelectedProjectUserCompanyId = $permissions->getCurrentlySelectedProjectUserCompanyId();
		$currentlyActiveContactId = $permissions->getCurrentlyActiveContactId();

		$projectOwnerFlag = $permissions->getProjectOwnerFlag();
		$projectOwnerAdminFlag = $permissions->getProjectOwnerAdminFlag();
		$paying_customer_flag = $permissions->getPayingCustomerFlag();

		$arrContactRoles = $permissions->getContactRoles();
		$arrProjectRoles = $permissions->getProjectRoles();

		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			if ($userRole == 'user') {
				$arrContactRoleIds = array_keys($arrContactRoles);
				// non-admins must have at least one role
				if (empty($arrContactRoleIds)) {
					return array();
				}
				$in = join(',', $arrContactRoleIds);
				if (isset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$grantAllPermissionsFlag = true;
				} else {
					$grantAllPermissionsFlag = false;
				}
			} else {
				// admin or global_admin case
				$grantAllPermissionsFlag = true;
			}
		} else {
			// Project Files case
			if ($projectOwnerAdminFlag) {
				$grantAllPermissionsFlag = true;
			} elseif (!$projectOwnerFlag || ($projectOwnerFlag && ($userRole == 'user'))) {
				// non-project-owner-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
				// If this person has the "admin" role for the project, then grant all permissions
				// Currently we do no allow "admin" to be assigned by project.
				// Should this be "Project Executive"???
				if (isset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$grantAllPermissionsFlag = true;
				} else {
					$grantAllPermissionsFlag = false;

					$arrProjectRoleIds = array_keys($arrProjectRoles);
					$in = join(',', $arrProjectRoleIds);
				}
			}
		}

		$arrPermissionsMatrix = array();
		if ($grantAllPermissionsFlag) {
			foreach ($arrFileManagerFolderIds as $file_manager_folder_id) {
				$arrPermissionsMatrix[$file_manager_folder_id]['grant_privileges_privilege'] = 'Y';
				$arrPermissionsMatrix[$file_manager_folder_id]['rename_privilege'] = 'Y';
				$arrPermissionsMatrix[$file_manager_folder_id]['upload_privilege'] = 'Y';
				$arrPermissionsMatrix[$file_manager_folder_id]['move_privilege'] = 'Y';
				$arrPermissionsMatrix[$file_manager_folder_id]['delete_privilege'] = 'Y';
			}

			$arrPermissionsMatrix['grant_privileges_privilege'] = 'Y';
			$arrPermissionsMatrix['rename_privilege'] = 'Y';
			$arrPermissionsMatrix['upload_privilege'] = 'Y';
			$arrPermissionsMatrix['move_privilege'] = 'Y';
			$arrPermissionsMatrix['delete_privilege'] = 'Y';

			return $arrPermissionsMatrix;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		$folderIdIn = join(',', $arrFileManagerFolderIds);

		$query =
"
SELECT r2f.*
FROM `roles_to_folders` r2f
WHERE r2f.`role_id` IN ($in)
AND r2f.`file_manager_folder_id` IN ($folderIdIn)
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrPermissionsMatrix['grant_privileges_privilege'] = 'Y';
		$arrPermissionsMatrix['rename_privilege'] = 'Y';
		$arrPermissionsMatrix['upload_privilege'] = 'Y';
		$arrPermissionsMatrix['move_privilege'] = 'Y';
		$arrPermissionsMatrix['delete_privilege'] = 'Y';

		$counter = 0;
		while($row = $db->fetch()) {
			$counter++;
			$file_manager_folder_id = $row['file_manager_folder_id'];
			$grant_privileges_privilege = $row['grant_privileges_privilege'];
			$rename_privilege = $row['rename_privilege'];
			$upload_privilege = $row['upload_privilege'];
			$move_privilege = $row['move_privilege'];
			$delete_privilege = $row['delete_privilege'];

			$arrPermissionsMatrix[$file_manager_folder_id]['grant_privileges_privilege'] = $grant_privileges_privilege;
			$arrPermissionsMatrix[$file_manager_folder_id]['rename_privilege'] = $rename_privilege;
			$arrPermissionsMatrix[$file_manager_folder_id]['upload_privilege'] = $upload_privilege;
			$arrPermissionsMatrix[$file_manager_folder_id]['move_privilege'] = $move_privilege;
			$arrPermissionsMatrix[$file_manager_folder_id]['delete_privilege'] = $delete_privilege;

			if ($grant_privileges_privilege == 'N') {
				$arrPermissionsMatrix['grant_privileges_privilege'] = 'N';
			}
			if ($rename_privilege == 'N') {
				$arrPermissionsMatrix['rename_privilege'] = 'N';
			}
			if ($upload_privilege == 'N') {
				$arrPermissionsMatrix['upload_privilege'] = 'N';
			}
			if ($move_privilege == 'N') {
				$arrPermissionsMatrix['move_privilege'] = 'N';
			}
			if ($delete_privilege == 'N') {
				$arrPermissionsMatrix['delete_privilege'] = 'N';
			}
		}

		if ($counter == 0) {
			$arrPermissionsMatrix['grant_privileges_privilege'] = 'N';
			$arrPermissionsMatrix['rename_privilege'] = 'N';
			$arrPermissionsMatrix['upload_privilege'] = 'N';
			$arrPermissionsMatrix['move_privilege'] = 'N';
			$arrPermissionsMatrix['delete_privilege'] = 'N';
		}

		if ($counter > 0) {
			$arrPermissionsMatrix[$file_manager_folder_id]['grant_privileges_privilege'] = $grant_privileges_privilege;
			$arrPermissionsMatrix[$file_manager_folder_id]['rename_privilege'] = $rename_privilege;
			$arrPermissionsMatrix[$file_manager_folder_id]['upload_privilege'] = $upload_privilege;
			$arrPermissionsMatrix[$file_manager_folder_id]['move_privilege'] = $move_privilege;
			$arrPermissionsMatrix[$file_manager_folder_id]['delete_privilege'] = $delete_privilege;
		}

		return $arrPermissionsMatrix;
	}

	public static function filterPermissions($database, $arrFileManagerFolderIdsByProjectId, $permissions)
	{

	}

	/**
	 * This will work as long as the parent folder is not "/" for Company Files or project cases
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @param int $parent_file_manager_folder_id
	 */
	public static function setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id)
	{
		$file_manager_folder_id = (int) $file_manager_folder_id;
		$parent_file_manager_folder_id = (int) $parent_file_manager_folder_id;

		// Set Permissions of the folder to match the parent folder.
		$db = DBI::getInstance($database);

		// Role-based permissions
		// Delete Old Records
		$query =
"
DELETE FROM `roles_to_folders`
WHERE `file_manager_folder_id` = ?
";
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		$query =
"
INSERT INTO `roles_to_folders`
(`role_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`)
SELECT `role_id`, ? AS 'file_manager_folder_id', `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`
FROM roles_to_folders
WHERE file_manager_folder_id = ?
";
		$arrValues = array($file_manager_folder_id, $parent_file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		// Contact-based permissions
		// Delete Old Records
		$query =
"
DELETE FROM `contacts_to_folders`
WHERE `file_manager_folder_id` = ?
";
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		$query =
"
INSERT INTO `contacts_to_folders`
(`contact_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`)
SELECT `contact_id`, ? AS 'file_manager_folder_id', `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`
FROM contacts_to_folders
WHERE file_manager_folder_id = ?
";
		$arrValues = array($file_manager_folder_id, $parent_file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		return;
	}

	public static function setSingleUserPermissions($database, $file_manager_folder_id, $project_id, $contact_id)
	{
		// Set Permissions of the foler for a single user.
		$db = DBI::getInstance($database);

		$file_manager_folder_id = (int) $file_manager_folder_id;

		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;

		$permissions = Zend_Registry::get('permissions');
		$user_company_id = $permissions->getUserCompanyId();
		$user_id = $permissions->getUserId();
		$user_role_id = $permissions->getUserRoleId();
		$userRole = $permissions->getUserRole();
		$primary_contact_id = $permissions->getPrimaryContactId();
		$currentlySelectedProjectId = $permissions->getCurrentlySelectedProjectId();
		$currentlySelectedProjectUserCompanyId = $permissions->getCurrentlySelectedProjectUserCompanyId();
		$currentlyActiveContactId = $permissions->getCurrentlyActiveContactId();

		$projectOwnerFlag = $permissions->getProjectOwnerFlag();
		$projectOwnerAdminFlag = $permissions->getProjectOwnerAdminFlag();
		$paying_customer_flag = $permissions->getPayingCustomerFlag();

		$arrContactRoles = $permissions->getContactRoles();
		// Load roles list from projects_to_contacts_to_roles
			$arrProjectRoles = ProjectToContactToRole::loadRolesListByProjectIdAndContactId($database, $currentlySelectedProjectId, $currentlyActiveContactId);
		// $arrProjectRoles = $permissions->getProjectRoles();

		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			// Unset the admin and global_admin role_id values
			unset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN]);
			unset($arrContactRoles[$AXIS_USER_ROLE_ID_GLOBAL_ADMIN]);
			$arrContactRoleIds = array_keys($arrContactRoles);
			$in = join(',', $arrContactRoleIds);
			$arrRoleIds = $arrContactRoleIds;
		} else {
			// Project Files case
			// Unset the admin and global_admin role_id values
			unset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN]);
			unset($arrProjectRoles[$AXIS_USER_ROLE_ID_GLOBAL_ADMIN]);
			$arrProjectRoleIds = array_keys($arrProjectRoles);
			$in = join(',', $arrProjectRoleIds);
			$arrRoleIds = $arrProjectRoleIds;
		}

		// Role-based permissions
		// @todo Decide if want to delete all relationships here
		// Delete Old Records
		$query =
"
DELETE FROM `roles_to_folders`
WHERE `file_manager_folder_id` = ?
";
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		$query =
"
INSERT INTO `roles_to_folders`
(`role_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, 'Y', 'Y', 'Y', 'Y', 'Y')
";
		foreach ($arrRoleIds as $tmpRoleId) {
			$arrValues = array($tmpRoleId, $file_manager_folder_id);
			$db->execute($query, $arrValues);
			$db->free_result();
		}

		// Contact-based permissions
		// @todo Decide if want to delete all relationships here
		// Delete Old Records
		$query =
"
DELETE FROM `contacts_to_folders`
WHERE `file_manager_folder_id` = ?
";
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		// Just the currentlyActiveContactId here
		$query =
"
INSERT INTO `contacts_to_folders`
(`contact_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, 'Y', 'Y', 'Y', 'Y', 'Y')
";
		$arrValues = array($currentlyActiveContactId, $file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		return;
	}

	public static function findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $contact_id, $project_id, $virtual_file_path)
	{
		/* @var $fileManagerFolder FileManagerFolder */

		if ($virtual_file_path == '/') {
			$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $virtual_file_path);
			$fileManagerFolder->setParentFileManagerFolder(false);
		} else {
			// Save the root folder "/" to the database (if not done so already)
			$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, '/');
			$fileManagerFolder->setParentFileManagerFolder(false);

			// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$currentVirtualFilePath = '/';
			$parentFileManagerFolder = $fileManagerFolder;
			foreach ($arrFolders as $folder) {
				$tmpVirtualFilePath = array_shift($arrFolders);
				$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
				// Save the file_manager_folders record (virtual_file_path) to the db and get the id
				$fileManagerFolder = FileManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $project_id, $currentVirtualFilePath);
				$fileManagerFolder->setParentFileManagerFolder($parentFileManagerFolder);

				$virtualFilePathDidNotExist = $fileManagerFolder->getVirtualFilePathDidNotExist();
				if ($virtualFilePathDidNotExist && $parentFileManagerFolder && ($parentFileManagerFolder instanceof FileManagerFolder)) {
					$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
					$parent_file_manager_folder_id = $parentFileManagerFolder->file_manager_folder_id;

					// Set Permissions of the file to match the parent folder.
					FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
				}

				$parentFileManagerFolder = $fileManagerFolder;
			}
		}

		// Get the file_manager_folder_id of the last folder in the list (parent folder of the file uploaded)
		/* @var $fileManagerFolder FileManagerFolder */
		/*
		$parentFileManagerFolder = $fileManagerFolder->getParentFileManagerFolder();
		if ($parentFileManagerFolder && ($parentFileManagerFolder instanceof FileManagerFolder)) {
			$file_manager_folder_id = $fileManagerFolder->file_manager_folder_id;
			$parent_file_manager_folder_id = $parentFileManagerFolder->file_manager_folder_id;

			// Set Permissions of the file to match the parent folder.
			FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);
		}
		*/

		return $fileManagerFolder;
	}

	/**
	 * Load the immediate child record(s) from a parent node's virtual_file_path for Guest.
	 */
	//public static function loadAccessibleChildFoldersByVirtualFilePath($database, $user_company_id, $project_id, $contact_id, $virtual_file_path, $showDeleted = false)
	public static function loadAccessibleChildFoldersByVirtualFilePathForGuest($database, $permissions, $parentFileManagerFolder, $showDeleted = false, $permissions)
	{
		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;


		$user_company_id = $permissions->getUserCompanyId();
		$user_id = $permissions->getUserId();
		$user_role_id = $permissions->getUserRoleId();
		$userRole = $permissions->getUserRole();
		$primary_contact_id = $permissions->getPrimaryContactId();
		$currentlySelectedProjectId = $permissions->getCurrentlySelectedProjectId();
		$currentlySelectedProjectUserCompanyId = $permissions->getCurrentlySelectedProjectUserCompanyId();
		$currentlyActiveContactId = $permissions->getCurrentlyActiveContactId();

		$projectOwnerFlag = $permissions->getProjectOwnerFlag();
		// $projectOwnerAdminFlag = $permissions->getProjectOwnerAdminFlag();
		$projectOwnerAdminFlag = true;//allow guest users to view plan folder
		$paying_customer_flag = $permissions->getPayingCustomerFlag();

		$arrContactRoles = $permissions->getContactRoles();
		$arrProjectRoles = $permissions->getProjectRoles();


		$file_manager_folder_id = $parentFileManagerFolder->file_manager_folder_id;
		$virtual_file_path = $parentFileManagerFolder->virtual_file_path;
		$project_id = $parentFileManagerFolder->project_id;


		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			if ($userRole == 'user') {
				$arrContactRoleIds = array_keys($arrContactRoles);
				// non-admins must have at least one role
				if (empty($arrContactRoleIds)) {
					return array();
				}
				$in = join(',', $arrContactRoleIds);
				if (isset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$loadAllFilesFlag = true;
				} else {
					$loadAllFilesFlag = false;
				}
			} else {
				// admin or global_admin case
				$loadAllFilesFlag = true;
			}
		} else {
			// Project Files case
			if ($projectOwnerAdminFlag) {
				$loadAllFilesFlag = true;
			} elseif (!$projectOwnerFlag || ($projectOwnerFlag && ($userRole == 'user'))) {
				// non-project-owner-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
				// If this person has the "admin" role for the project, then grant all permissions
				// Currently we do no allow "admin" to be assigned by project.
				// Should this be "Project Executive"???
				if (isset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$loadAllFilesFlag = true;
				} else {
					$loadAllFilesFlag = false;

					$arrProjectRoleIds = array_keys($arrProjectRoles);
					$in = join(',', $arrProjectRoleIds);
				}
			}
		}


		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();


		/*
		// Get a list of role_id values
		$arrRoleIds = array();
		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company File case
			// Treat $contact_id as if it is primary_contact_id
			// contacts_to_roles
			$query =
				"SELECT c2r.`role_id` ".
				"FROM `contacts_to_roles` c2r ".
				"WHERE c2r.`contact_id` = ? ";
			$arrValues = array($contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			while ($row = $db->fetch()) {
				$role_id = $row['role_id'];
				$arrRoleIds[$role_id] = 1;
			}
			$db->free_result();
		} elseif ($project_id <> $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Check if admin and user_company_id is the "project owner"
			$query =
				"SELECT p.`user_company_id` ".
				"FROM `projects` p ".
				"WHERE p.`id` = ? ";
			$arrValues = array($project_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			$db->free_result();

			if ($row && isset($row['user_company_id'])) {
				$projectOwnerUserCompanyId = $row['user_company_id'];
				if ($user_company_id == $projectOwnerUserCompanyId) {
					// Check if this contact is an admin
					$query =
						"SELECT c2r.`role_id` ".
						"FROM `contacts_to_roles` c2r ".
						"WHERE c2r.`contact_id` = ? ".
						"AND c2r.`role_id` = $AXIS_USER_ROLE_ID_ADMIN";
					$arrValues = array($contact_id);
					$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
					while ($row = $db->fetch()) {
						$role_id = $row['role_id'];
						$arrRoleIds[$role_id] = 1;
					}
					$db->free_result();
				}
			}

			if (empty($arrRoleIds)) {
				// Project files case
				$query =
					"SELECT p2c2r.`role_id` ".
					"FROM `projects_to_contacts_to_roles` p2c2r ".
					"WHERE p2c2r.`project_id` = ? ".
					"AND p2c2r.`contact_id` = ? ";
				$arrValues = array($project_id, $contact_id);
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				while ($row = $db->fetch()) {
					$role_id = $row['role_id'];
					$arrRoleIds[$role_id] = 1;
				}
				$db->free_result();
			}
		}

		// Check for admin case
		if (isset($arrRoleIds[$AXIS_USER_ROLE_ID_ADMIN])) {
			$adminFlag = true;
		} else {
			$adminFlag = false;

			// non-admins have to have a role
			if (empty($arrRoleIds)) {
				return array();
			}
		}
		*/


		$escaped_virtual_file_path = preg_quote($parentFileManagerFolder->virtual_file_path);
		$escaped_virtual_file_path = mysqli_real_escape_string($db->link_id, $escaped_virtual_file_path);

		// global_admin is just like admin for the file manager - sees all folders for their user_company_id
		// global_admin can use the impersonate user feature to see other files and folders
		// admin sees all folders for their given user_company_id
		$query =
"
SELECT *
FROM `file_manager_folders` fmf
";

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			$query .= ", `roles_to_folders` r2f ";
		}

		$query .=
"
WHERE fmf.`user_company_id` = ?
AND fmf.`project_id` = ?
AND fmf.`virtual_file_path` rlike '^".$escaped_virtual_file_path."[^/]+/$'
";

		if ($showDeleted) {
			$query .=
"
AND fmf.`deleted_flag` = 'Y'
";
		} else {
			$query .=
"
AND fmf.`deleted_flag` = 'N'
";
		}

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			//$arrIn = array_keys($arrRoleIds);
			//$in = join(',', $arrIn);
			$query .=
"
AND fmf.`id` = r2f.`file_manager_folder_id`
AND r2f.`role_id` IN ($in)
GROUP BY fmf.`id`
";
		}

		$query .=
"
ORDER BY fmf.`virtual_file_path`
";

		$arrValues = array($parentFileManagerFolder->user_company_id, $parentFileManagerFolder->project_id);
		$db->execute($query, $arrValues);

		$arrAccessibleChildFoldersByVirtualFilePath = array();
		$arrSort = array();
		while ($row = $db->fetch()) {
			$file_manager_folder_id = $row['id'];
			$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$arrAccessibleChildFoldersByVirtualFilePath[$file_manager_folder_id] = $fileManagerFolder;

			$arrSort[$fileManagerFolder->virtual_file_path] = $file_manager_folder_id;
		}
		$db->free_result();

		uksort($arrSort, 'strnatcasecmp');
		$arrReturn = array();
		foreach ($arrSort as $file_manager_folder_id) {
			$fileManagerFolder = $arrAccessibleChildFoldersByVirtualFilePath[$file_manager_folder_id];
			$arrReturn[$file_manager_folder_id] = $fileManagerFolder;

		}

		//return $arrAccessibleChildFoldersByVirtualFilePath;
		return $arrReturn;
	}

	public function loadPermissionsForGuest($permissions)
	{
		if (!isset($this->file_manager_folder_id) || !isset($this->project_id)) {
			return;
		}

		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		// $permissions = Zend_Registry::get('permissions');
		$user_company_id = $permissions->getUserCompanyId();
		$user_id = $permissions->getUserId();
		$user_role_id = $permissions->getUserRoleId();
		$userRole = $permissions->getUserRole();
		$primary_contact_id = $permissions->getPrimaryContactId();
		$currentlySelectedProjectId = $permissions->getCurrentlySelectedProjectId();
		$currentlySelectedProjectUserCompanyId = $permissions->getCurrentlySelectedProjectUserCompanyId();
		$currentlyActiveContactId = $permissions->getCurrentlyActiveContactId();

		$projectOwnerFlag = $permissions->getProjectOwnerFlag();
		$projectOwnerAdminFlag = $permissions->getProjectOwnerAdminFlag();
		$paying_customer_flag = $permissions->getPayingCustomerFlag();

		$arrContactRoles = $permissions->getContactRoles();
		$arrProjectRoles = $permissions->getProjectRoles();

		$database = $this->getDatabase();
		$file_manager_folder_id = $this->file_manager_folder_id;
		//$virtual_file_path = $this->virtual_file_path;
		$project_id = $this->project_id;

		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			if ($userRole == 'user') {
				$arrContactRoleIds = array_keys($arrContactRoles);
				// non-admins must have at least one role
				if (empty($arrContactRoleIds)) {
					return array();
				}
				$in = join(',', $arrContactRoleIds);
				if (isset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$grantAllPermissionsFlag = true;
				} else {
					$grantAllPermissionsFlag = false;
				}
			} else {
				// admin or global_admin case
				$grantAllPermissionsFlag = true;
			}
		} else {
			// Project Files case
			if ($projectOwnerAdminFlag) {
				$grantAllPermissionsFlag = true;
			} elseif (!$projectOwnerFlag || ($projectOwnerFlag && ($userRole == 'user'))) {
				// non-project-owner-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
				// If this person has the "admin" role for the project, then grant all permissions
				// Currently we do no allow "admin" to be assigned by project.
				// Should this be "Project Executive"???
				if (isset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$grantAllPermissionsFlag = true;
				} else {
					$grantAllPermissionsFlag = false;

					$arrProjectRoleIds = array_keys($arrProjectRoles);
					$in = join(',', $arrProjectRoleIds);
				}
			}
		}

		if ($grantAllPermissionsFlag) {
			$this->grant_privileges_privilege = 'Y';
			$this->rename_privilege = 'Y';
			$this->upload_privilege = 'Y';
			$this->move_privilege = 'Y';
			$this->delete_privilege = 'Y';

			return;
		}

		$this->grant_privileges_privilege = 'N';
		$this->rename_privilege = 'N';
		$this->upload_privilege = 'N';
		$this->move_privilege = 'N';
		$this->delete_privilege = 'N';

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		$query =
"
SELECT r2f.*
FROM `roles_to_folders` r2f
WHERE `file_manager_folder_id` = $this->file_manager_folder_id
AND role_id IN ($in)
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrRolesToFolders = array();
		while($row = $db->fetch()) {
			$grant_privileges_privilege = $row['grant_privileges_privilege'];
			$rename_privilege = $row['rename_privilege'];
			$upload_privilege = $row['upload_privilege'];
			$move_privilege = $row['move_privilege'];
			$delete_privilege = $row['delete_privilege'];

			if ($grant_privileges_privilege == 'Y') {
				$this->grant_privileges_privilege = 'Y';
			}

			if ($rename_privilege == 'Y') {
				$this->rename_privilege = 'Y';
			}

			if ($upload_privilege == 'Y') {
				$this->upload_privilege = 'Y';
			}

			if ($move_privilege == 'Y') {
				$this->move_privilege = 'Y';
			}

			if ($delete_privilege == 'Y') {
				$this->delete_privilege = 'Y';
			}

			$role_id = $row['role_id'];
			$roleToFolder = new RoleToFolder($database);
			$key = array(
				'role_id' => $role_id,
				'file_manager_folder_id' => $this->file_manager_folder_id
			);
			$roleToFolder->setKey($key);
			$roleToFolder->setData($row);
			$roleToFolder->convertDataToProperties();

			$arrRolesToFolders[$role_id] = $roleToFolder;
		}

		$this->setRolesToFolders($arrRolesToFolders);

		return;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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

class ImageManagerFolder extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ImageManagerFolder';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'image_manager_folders';

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
		'unique_image_manager_folder' => array(
			'user_company_id' => 'int',
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

	/**
	 * Constructor
	 */
	public function __construct($database, $table='image_manager_folders')
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

	public function getParentFileManagerFolder()
	{
		if (isset($this->_parentFileManagerFolder) && ($this->_parentFileManagerFolder instanceof ImageManagerFolder)) {
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

	/**
	 * Load a record from its virtual_file_path or save and return data.
	 */
	public static function findByVirtualFilePath($database, $user_company_id, $contact_id, $virtual_file_path)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$query = "SELECT * ".
		"FROM `image_manager_folders` ".
		"WHERE `user_company_id` = ? ".
		"AND `virtual_file_path` = ? ";
		$arrValues = array($user_company_id, $virtual_file_path);
		$db->execute($query, $arrValues);

		$row = $db->fetch();
		$db->free_result();

		$imageManagerFolder = new ImageManagerFolder($database);
		if ($row) {
			$image_manager_folder_id = (int) $row['id'];
			$imageManagerFolder = self::instantiateOrm($database, 'ImageManagerFolder', $row, null, $image_manager_folder_id);
			/* @var $fileManagerFolder FileManagerFolder */
			$imageManagerFolder->setVirtualFilePathDidNotExist(false);
		} else {
			$imageManagerFolder->user_company_id = $user_company_id;
			$imageManagerFolder->contact_id = $contact_id;
			$imageManagerFolder->virtual_file_path = $virtual_file_path;
			$imageManagerFolder->convertPropertiesToData();
			$imageManagerFolder['created'] = null;
			$image_manager_folder_id = $imageManagerFolder->save();
			$key = array('id' => $image_manager_folder_id);
			$imageManagerFolder->setKey($key);
			$imageManagerFolder->setData(array());
			$imageManagerFolder->load();
			$imageManagerFolder->convertDataToProperties();
			$imageManagerFolder->setId($image_manager_folder_id);
			$imageManagerFolder->setVirtualFilePathDidNotExist(true);
		}

		$db->commit();

		return $imageManagerFolder;
	}

	public static function findFolderByVirtualFilePathAndCreateIfNotExistWithPermissions($database, $user_company_id, $contact_id, $virtual_file_path)
	{
		/* @var $fileManagerFolder FileManagerFolder */

		if ($virtual_file_path == '/') {
			$imageManagerFolder = ImageManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $virtual_file_path);
			$imageManagerFolder->setParentFileManagerFolder(false);
		} else {
			// Save the root folder "/" to the database (if not done so already)
			$imageManagerFolder = ImageManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, '/');
			$imageManagerFolder->setParentFileManagerFolder(false);

			// Convert a nested folder path to each path portion and create a file_manager_folders record for each one
			$arrFolders = preg_split('#/#', $virtual_file_path, -1, PREG_SPLIT_NO_EMPTY);
			$currentVirtualFilePath = '/';
			$parentFileManagerFolder = $imageManagerFolder;
			foreach ($arrFolders as $folder) {
				$tmpVirtualFilePath = array_shift($arrFolders);
				$currentVirtualFilePath .= $tmpVirtualFilePath.'/';
				// Save the file_manager_folders record (virtual_file_path) to the db and get the id
				$imageManagerFolder = ImageManagerFolder::findByVirtualFilePath($database, $user_company_id, $contact_id, $currentVirtualFilePath);
				$imageManagerFolder->setParentFileManagerFolder($parentFileManagerFolder);

				$virtualFilePathDidNotExist = $imageManagerFolder->getVirtualFilePathDidNotExist();
				if ($virtualFilePathDidNotExist && $parentFileManagerFolder && ($parentFileManagerFolder instanceof ImageManagerFolder)) {
					$image_manager_folder_id = $imageManagerFolder->image_manager_folder_id;
					$parent_file_manager_folder_id = $parentFileManagerFolder->image_manager_folder_id;

					// Set Permissions of the file to match the parent folder.
					/*FileManagerFolder::setPermissionsToMatchParentFolder($database, $file_manager_folder_id, $parent_file_manager_folder_id);*/
				}

				$parentFileManagerFolder = $imageManagerFolder;
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

		return $imageManagerFolder;
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
		(`user_company_id`, `contact_id`, `virtual_file_path`, `virtual_file_path_sha1`, `modified`, `created`, `deleted_flag`, `directly_deleted_flag`)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?)
		ON DUPLICATE KEY UPDATE `contact_id` = ?, `virtual_file_path_sha1` = ?, `modified` = ?, `created` = ?, `deleted_flag` = ?, `directly_deleted_flag` = ?
		";
		$arrValues = array($this->user_company_id, $this->contact_id, $this->virtual_file_path, $this->virtual_file_path_sha1, $this->modified, $this->created, $this->deleted_flag, $this->directly_deleted_flag, $this->contact_id, $this->virtual_file_path_sha1, $this->modified, $this->created, $this->deleted_flag, $this->directly_deleted_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$image_manager_folder_id = $db->insertId;
		$db->free_result();

		return $image_manager_folder_id;
	}
	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $file_manager_folder_id, $table='image_manager_folders', $module='ImageManagerFolder')
	{
		$imageManagerFolder = parent::findById($database, $file_manager_folder_id, $table, $module);

		return $imageManagerFolder;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

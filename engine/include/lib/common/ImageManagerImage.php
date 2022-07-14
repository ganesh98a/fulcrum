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
 * @package    FileManagerFile
 */

/**
 * File
 */
require_once('lib/common/File.php');

/**
 * FileLocation
 */
require_once('lib/common/FileLocation.php');

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ImageManagerImage extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ImageManagerImage';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'image_manager_images';

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
	 * unique index `unique_file_manager_file` (`user_company_id`,`project_id`,`file_manager_folder_id`,`virtual_file_name`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_file_manager_file' => array(
			'user_company_id' => 'int',
			'image_manager_folder_id' => 'int',
			'virtual_file_name' => 'string'
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
		'id' => 'file_manager_file_id',

		'user_company_id' => 'user_company_id',
		'contact_id' => 'contact_id',

		'image_manager_folder_id' => 'image_manager_folder_id',
		'file_location_id' => 'file_location_id',
		'virtual_file_name' => 'virtual_file_name',

		'version_number' => 'version_number',
		'virtual_file_name_sha1' => 'virtual_file_name_sha1',
		'virtual_file_mime_type' => 'virtual_file_mime_type',
		'modified' => 'modified',
		'created' => 'created',
		'deleted_flag' => 'deleted_flag',
		'directly_deleted_flag' => 'directly_deleted_flag'
		);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $file_manager_file_id;

	public $user_company_id;
	public $contact_id;

	public $image_manager_folder_id;
	public $file_location_id;
	public $virtual_file_name;

	public $version_number;
	public $virtual_file_name_sha1;
	public $virtual_file_mime_type;
	public $modified;
	public $created;
	public $deleted_flag;
	public $directly_deleted_flag;

	// Other Properties
	//protected $_otherPropertyHere;
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

	protected $derivedFileNameWithoutExtension;
	protected $derivedFileExtension;

	protected $filteredVirtualFileName;

	// role_id list from roles_to_files using <file_manager_file_id>
	protected $rolesToFiles;

	// contact_id list from contacts_to_files using <file_manager_file_id>
	protected $contactsToFiles;

	/**
	 * The parent folder of the file.
	 *
	 * Usefull for file search results.
	 *
	 * @var FileManagerFolder
	 */
	protected $fileManagerFolder;

	public $fileUrl;
	public $fileDownloadUrl;

	public $view_privilege;
	public $grant_privileges_privilege;
	public $rename_privilege;
	public $move_privilege;
	public $delete_privilege;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_virtual_file_name;
	public $escaped_virtual_file_name_sha1;
	public $escaped_virtual_file_mime_type;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_virtual_file_name_nl2br;
	public $escaped_virtual_file_name_sha1_nl2br;
	public $escaped_virtual_file_mime_type_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrFileManagerFilesByFileManagerFolderId;
	protected static $_arrFileManagerFilesByFileLocationId;
	protected static $_arrFileManagerFilesByUserCompanyId;
	protected static $_arrFileManagerFilesByContactId;
	protected static $_arrFileManagerFilesByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag;
	protected static $_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
	protected static $_arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName;
	protected static $_arrFileManagerFilesByVirtualFileName;
	protected static $_arrFileManagerFilesByVirtualFileMimeType;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllFileManagerFiles;

	// Foreign Key Objects
	private $_fileManagerFolder;
	private $_fileLocation;
	private $_userCompany;
	private $_contact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='image_manager_images')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
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

	public function getFileLocation()
	{
		if (isset($this->_fileLocation)) {
			return $this->_fileLocation;
		} else {
			return null;
		}
	}

	public function setFileLocation($fileLocation)
	{
		$this->_fileLocation = $fileLocation;
	}

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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrFileManagerFilesByFileManagerFolderId()
	{
		if (isset(self::$_arrFileManagerFilesByFileManagerFolderId)) {
			return self::$_arrFileManagerFilesByFileManagerFolderId;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByFileManagerFolderId($arrFileManagerFilesByFileManagerFolderId)
	{
		self::$_arrFileManagerFilesByFileManagerFolderId = $arrFileManagerFilesByFileManagerFolderId;
	}

	public static function getArrFileManagerFilesByFileLocationId()
	{
		if (isset(self::$_arrFileManagerFilesByFileLocationId)) {
			return self::$_arrFileManagerFilesByFileLocationId;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByFileLocationId($arrFileManagerFilesByFileLocationId)
	{
		self::$_arrFileManagerFilesByFileLocationId = $arrFileManagerFilesByFileLocationId;
	}

	public static function getArrFileManagerFilesByUserCompanyId()
	{
		if (isset(self::$_arrFileManagerFilesByUserCompanyId)) {
			return self::$_arrFileManagerFilesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByUserCompanyId($arrFileManagerFilesByUserCompanyId)
	{
		self::$_arrFileManagerFilesByUserCompanyId = $arrFileManagerFilesByUserCompanyId;
	}

	public static function getArrFileManagerFilesByContactId()
	{
		if (isset(self::$_arrFileManagerFilesByContactId)) {
			return self::$_arrFileManagerFilesByContactId;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByContactId($arrFileManagerFilesByContactId)
	{
		self::$_arrFileManagerFilesByContactId = $arrFileManagerFilesByContactId;
	}

	public static function getArrFileManagerFilesByProjectId()
	{
		if (isset(self::$_arrFileManagerFilesByProjectId)) {
			return self::$_arrFileManagerFilesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByProjectId($arrFileManagerFilesByProjectId)
	{
		self::$_arrFileManagerFilesByProjectId = $arrFileManagerFilesByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag()
	{
		if (isset(self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag)) {
			return self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag($arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag)
	{
		self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag = $arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag;
	}

	public static function getArrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag()
	{
		if (isset(self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag)) {
			return self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag($arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag)
	{
		self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = $arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
	}

	public static function getArrFileManagerFilesByFileManagerFolderIdAndVirtualFileName()
	{
		if (isset(self::$_arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName)) {
			return self::$_arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByFileManagerFolderIdAndVirtualFileName($arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName)
	{
		self::$_arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName = $arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName;
	}

	public static function getArrFileManagerFilesByVirtualFileName()
	{
		if (isset(self::$_arrFileManagerFilesByVirtualFileName)) {
			return self::$_arrFileManagerFilesByVirtualFileName;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByVirtualFileName($arrFileManagerFilesByVirtualFileName)
	{
		self::$_arrFileManagerFilesByVirtualFileName = $arrFileManagerFilesByVirtualFileName;
	}

	public static function getArrFileManagerFilesByVirtualFileMimeType()
	{
		if (isset(self::$_arrFileManagerFilesByVirtualFileMimeType)) {
			return self::$_arrFileManagerFilesByVirtualFileMimeType;
		} else {
			return null;
		}
	}

	public static function setArrFileManagerFilesByVirtualFileMimeType($arrFileManagerFilesByVirtualFileMimeType)
	{
		self::$_arrFileManagerFilesByVirtualFileMimeType = $arrFileManagerFilesByVirtualFileMimeType;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllFileManagerFiles()
	{
		if (isset(self::$_arrAllFileManagerFiles)) {
			return self::$_arrAllFileManagerFiles;
		} else {
			return null;
		}
	}

	public static function setArrAllFileManagerFiles($arrAllFileManagerFiles)
	{
		self::$_arrAllFileManagerFiles = $arrAllFileManagerFiles;
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
	 * @param int $file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $file_manager_file_id, $table='image_manager_images', $module='ImageManagerImage')
	{
		$fileManagerFile = parent::findById($database, $file_manager_file_id, $table, $module);

		return $fileManagerFile;
	}
	/**
	 * Load a record from its virtual_file_name or save and return data.
	 */
	public static function findByVirtualFileName($database, $user_company_id, $contact_id, $image_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		// unique index (`user_company_id`, `project_id`, `file_manager_folder_id`, `virtual_file_name`)
		$query = 'SELECT * '.
		'FROM `image_manager_images` '.
		'WHERE `user_company_id` = ? '.
		'AND `image_manager_folder_id` = ? '.
		'AND `virtual_file_name` = ? ';
		$arrValues = array($user_company_id, $image_manager_folder_id, $virtual_file_name);
		$db->execute($query, $arrValues);

		$row = $db->fetch();
		$db->free_result();

		$fmf = new ImageManagerImage($database);
		if ($row) {
			$image_manager_image_id = $row['id'];
			$fmf->setData($row);
			$fmf->convertDataToProperties();
			$key = array('id' => $image_manager_image_id);
			$fmf->setKey($key);
			$fmf->setId($image_manager_image_id);

			// @todo Decide how this should work.
			// Check for diff based on inputs
			$data = array();
			if ($fmf->contact_id <> $contact_id) {
				$fmf->contact_id = $contact_id;
				$data['contact_id'] = $contact_id;
			}
			if ($fmf->file_location_id <> $file_location_id) {
				$fmf->file_location_id = $file_location_id;
				$data['file_location_id'] = $file_location_id;

				// Increment the version_number
				$version_number  = $row['version_number'];
				$version_number++;
				$fmf->version_number = $version_number;
				$data['version_number'] = $version_number;
			}
			if ($fmf->virtual_file_mime_type <> $virtual_file_mime_type) {
				$fmf->virtual_file_mime_type = $virtual_file_mime_type;
				$data['virtual_file_mime_type'] = $virtual_file_mime_type;
			}
			if (!empty($data)) {
				$fmf->setData($data);
				$fmf->save();
				$fmf->convertPropertiesToData();
			}
		} else {
			$fmf->user_company_id = $user_company_id;
			$fmf->contact_id = $contact_id;
			$fmf->image_manager_folder_id = $image_manager_folder_id;
			$fmf->file_location_id = $file_location_id;
			$fmf->virtual_file_name = $virtual_file_name;
			$fmf->virtual_file_mime_type = $virtual_file_mime_type;
			$fmf->convertPropertiesToData();
			$fmf['created'] = null;
			$image_manager_image_id = $fmf->save();
			// $image_manager_image_id=1;
			$key = array('id' => $image_manager_image_id);
			$fmf->setKey($key);
			$fmf->setData(array());
			$fmf->load();
			$fmf->convertDataToProperties();
			$fmf->setId($image_manager_image_id);
		}

		$db->commit();

		return $fmf;
	}
	public function generateUrl($useAbsoluteCdnUrl=false)
	{
		$useAbsoluteCdnUrl = (bool) $useAbsoluteCdnUrl;

		// Create URL to image or pdf on the CDN
		$uri = Zend_Registry::get('uri');
		/* @var $uri Uri */

		if ($useAbsoluteCdnUrl) {
			if($uri->sslFlag){
				$baseCdnUrl = $uri->https;
			}else{
				$baseCdnUrl = $uri->cdn_absolute_url;	
			}
		} else {
			$baseCdnUrl = $uri->cdn;
		}

		$config = Zend_Registry::get('config');
		/* @var $config Config */
		// E.g. "_"
		$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

		$file_manager_file_id = Data::parseInt($this->file_manager_file_id);
		$cdnFileUrl = $baseCdnUrl . $file_manager_file_name_prefix . $file_manager_file_id;
		$version_number = $this->version_number;
		if (isset($version_number) && $version_number > 1) {
			$cdnFileUrl .= '?v=' . $version_number.'&logo=1';
		}else{
			$cdnFileUrl .= '?logo=1';
		}
		$this->fileUrl = $cdnFileUrl;

		return $cdnFileUrl;
		
		// $config = Zend_Registry::get('config');
		// /* @var $config Config */
		// // E.g. "_"
		// $file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

		// $file_manager_file_id = Data::parseInt($this->file_manager_file_id);


		// $file_manager_base_path = $config->system->file_manager_base_path;
		// $file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
		// $file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

		// $fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;

		// $file_location_id = Data::parseInt($this->file_location_id);

		// $arrPath = str_split($file_location_id, 2);
		// $fileName = array_pop($arrPath);
		// $fileName = $fileManagerFileNamePrefix.$fileName;
		// $path = $fileManagerBackendFolderPath;
		// $shortFilePath = '';
		// foreach ($arrPath as $pathChunk) {
		// 	$path .= $pathChunk.'/';
		// 	$shortFilePath .= $pathChunk.'/';
		// }

		// $cdnFileUrl = $baseCdnUrl. $shortFilePath. $file_manager_file_name_prefix . $fileName;
		// $version_number = $this->version_number;
		// if (isset($version_number) && $version_number > 1) {
		// 	$cdnFileUrl .= '?v=' . $version_number;
		// }
		// $this->fileUrl = $cdnFileUrl;

		// return $cdnFileUrl;
	}
	// Save: insert on duplicate key update
	public function save()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		$db->free_result();

		/* @var $db DBI_mysqli */

		$query =
		"
		INSERT
		INTO `image_manager_images`
		(`user_company_id`, `contact_id`, `image_manager_folder_id`, `file_location_id`, `virtual_file_name`, `version_number`, `virtual_file_name_sha1`, `virtual_file_mime_type`,`deleted_flag`, `directly_deleted_flag`)
		VALUES ($this->user_company_id, $this->contact_id, $this->image_manager_folder_id, $this->file_location_id, '$this->virtual_file_name', '$this->version_number', '$this->virtual_file_name_sha1', '$this->virtual_file_mime_type', '$this->deleted_flag', '$this->directly_deleted_flag') ON DUPLICATE KEY UPDATE `contact_id` = '$this->contact_id', `file_location_id` = $this->file_location_id, `version_number` = '$this->version_number', `virtual_file_name_sha1` = '$this->virtual_file_name', `virtual_file_mime_type` = '$this->virtual_file_mime_type', `deleted_flag` = '$this->deleted_flag', `directly_deleted_flag` = '$this->directly_deleted_flag'
		";
		$arrValues = array($this->user_company_id, $this->contact_id, $this->image_manager_folder_id, $this->file_location_id, $this->virtual_file_name, $this->version_number, $this->virtual_file_name_sha1, $this->virtual_file_mime_type, $this->modified, $this->created, $this->deleted_flag, $this->directly_deleted_flag);
		$db->execute($query,MYSQLI_STORE_RESULT);
		$image_manager_image_id = $db->insertId;
		$db->free_result();
		

		return $image_manager_image_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

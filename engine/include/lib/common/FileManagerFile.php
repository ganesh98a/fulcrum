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
 * FileManager
 */
require_once('lib/common/FileManager.php');
/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class FileManagerFile extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'FileManagerFile';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'file_manager_files';

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
			'project_id' => 'int',
			'file_manager_folder_id' => 'int',
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
		'project_id' => 'project_id',

		'file_manager_folder_id' => 'file_manager_folder_id',
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
	public $project_id;

	public $file_manager_folder_id;
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
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='file_manager_files')
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
	public static function findById($database, $file_manager_file_id, $table='file_manager_files', $module='FileManagerFile')
	{
		$fileManagerFile = parent::findById($database, $file_manager_file_id, $table, $module);

		return $fileManagerFile;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findFileManagerFileByIdExtended($database, $file_manager_file_id)
	{
		$file_manager_file_id = (int) $file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	fmfiles_fk_fmfolders.`id` AS 'fmfiles_fk_fmfolders__file_manager_folder_id',
	fmfiles_fk_fmfolders.`user_company_id` AS 'fmfiles_fk_fmfolders__user_company_id',
	fmfiles_fk_fmfolders.`contact_id` AS 'fmfiles_fk_fmfolders__contact_id',
	fmfiles_fk_fmfolders.`project_id` AS 'fmfiles_fk_fmfolders__project_id',
	fmfiles_fk_fmfolders.`virtual_file_path` AS 'fmfiles_fk_fmfolders__virtual_file_path',
	fmfiles_fk_fmfolders.`virtual_file_path_sha1` AS 'fmfiles_fk_fmfolders__virtual_file_path_sha1',
	fmfiles_fk_fmfolders.`modified` AS 'fmfiles_fk_fmfolders__modified',
	fmfiles_fk_fmfolders.`created` AS 'fmfiles_fk_fmfolders__created',
	fmfiles_fk_fmfolders.`deleted_flag` AS 'fmfiles_fk_fmfolders__deleted_flag',
	fmfiles_fk_fmfolders.`directly_deleted_flag` AS 'fmfiles_fk_fmfolders__directly_deleted_flag',

	fmfiles_fk_fl.`id` AS 'fmfiles_fk_fl__file_location_id',
	fmfiles_fk_fl.`file_sha1` AS 'fmfiles_fk_fl__file_sha1',
	fmfiles_fk_fl.`cloud_vendor` AS 'fmfiles_fk_fl__cloud_vendor',
	fmfiles_fk_fl.`url` AS 'fmfiles_fk_fl__url',
	fmfiles_fk_fl.`file_size` AS 'fmfiles_fk_fl__file_size',
	fmfiles_fk_fl.`file_size_compressed` AS 'fmfiles_fk_fl__file_size_compressed',
	fmfiles_fk_fl.`compression_ratio` AS 'fmfiles_fk_fl__compression_ratio',
	fmfiles_fk_fl.`modified` AS 'fmfiles_fk_fl__modified',
	fmfiles_fk_fl.`created` AS 'fmfiles_fk_fl__created',

	fmfiles_fk_uc.`id` AS 'fmfiles_fk_uc__user_company_id',
	fmfiles_fk_uc.`company` AS 'fmfiles_fk_uc__company',
	fmfiles_fk_uc.`primary_phone_number` AS 'fmfiles_fk_uc__primary_phone_number',
	fmfiles_fk_uc.`employer_identification_number` AS 'fmfiles_fk_uc__employer_identification_number',
	fmfiles_fk_uc.`construction_license_number` AS 'fmfiles_fk_uc__construction_license_number',
	fmfiles_fk_uc.`construction_license_number_expiration_date` AS 'fmfiles_fk_uc__construction_license_number_expiration_date',
	fmfiles_fk_uc.`paying_customer_flag` AS 'fmfiles_fk_uc__paying_customer_flag',

	fmfiles_fk_c.`id` AS 'fmfiles_fk_c__contact_id',
	fmfiles_fk_c.`user_company_id` AS 'fmfiles_fk_c__user_company_id',
	fmfiles_fk_c.`user_id` AS 'fmfiles_fk_c__user_id',
	fmfiles_fk_c.`contact_company_id` AS 'fmfiles_fk_c__contact_company_id',
	fmfiles_fk_c.`email` AS 'fmfiles_fk_c__email',
	fmfiles_fk_c.`name_prefix` AS 'fmfiles_fk_c__name_prefix',
	fmfiles_fk_c.`first_name` AS 'fmfiles_fk_c__first_name',
	fmfiles_fk_c.`additional_name` AS 'fmfiles_fk_c__additional_name',
	fmfiles_fk_c.`middle_name` AS 'fmfiles_fk_c__middle_name',
	fmfiles_fk_c.`last_name` AS 'fmfiles_fk_c__last_name',
	fmfiles_fk_c.`name_suffix` AS 'fmfiles_fk_c__name_suffix',
	fmfiles_fk_c.`title` AS 'fmfiles_fk_c__title',
	fmfiles_fk_c.`vendor_flag` AS 'fmfiles_fk_c__vendor_flag',

	fmfiles_fk_p.`id` AS 'fmfiles_fk_p__project_id',
	fmfiles_fk_p.`project_type_id` AS 'fmfiles_fk_p__project_type_id',
	fmfiles_fk_p.`user_company_id` AS 'fmfiles_fk_p__user_company_id',
	fmfiles_fk_p.`user_custom_project_id` AS 'fmfiles_fk_p__user_custom_project_id',
	fmfiles_fk_p.`project_name` AS 'fmfiles_fk_p__project_name',
	fmfiles_fk_p.`project_owner_name` AS 'fmfiles_fk_p__project_owner_name',
	fmfiles_fk_p.`latitude` AS 'fmfiles_fk_p__latitude',
	fmfiles_fk_p.`longitude` AS 'fmfiles_fk_p__longitude',
	fmfiles_fk_p.`address_line_1` AS 'fmfiles_fk_p__address_line_1',
	fmfiles_fk_p.`address_line_2` AS 'fmfiles_fk_p__address_line_2',
	fmfiles_fk_p.`address_line_3` AS 'fmfiles_fk_p__address_line_3',
	fmfiles_fk_p.`address_line_4` AS 'fmfiles_fk_p__address_line_4',
	fmfiles_fk_p.`address_city` AS 'fmfiles_fk_p__address_city',
	fmfiles_fk_p.`address_county` AS 'fmfiles_fk_p__address_county',
	fmfiles_fk_p.`address_state_or_region` AS 'fmfiles_fk_p__address_state_or_region',
	fmfiles_fk_p.`address_postal_code` AS 'fmfiles_fk_p__address_postal_code',
	fmfiles_fk_p.`address_postal_code_extension` AS 'fmfiles_fk_p__address_postal_code_extension',
	fmfiles_fk_p.`address_country` AS 'fmfiles_fk_p__address_country',
	fmfiles_fk_p.`building_count` AS 'fmfiles_fk_p__building_count',
	fmfiles_fk_p.`unit_count` AS 'fmfiles_fk_p__unit_count',
	fmfiles_fk_p.`gross_square_footage` AS 'fmfiles_fk_p__gross_square_footage',
	fmfiles_fk_p.`net_rentable_square_footage` AS 'fmfiles_fk_p__net_rentable_square_footage',
	fmfiles_fk_p.`is_active_flag` AS 'fmfiles_fk_p__is_active_flag',
	fmfiles_fk_p.`public_plans_flag` AS 'fmfiles_fk_p__public_plans_flag',
	fmfiles_fk_p.`prevailing_wage_flag` AS 'fmfiles_fk_p__prevailing_wage_flag',
	fmfiles_fk_p.`city_business_license_required_flag` AS 'fmfiles_fk_p__city_business_license_required_flag',
	fmfiles_fk_p.`is_internal_flag` AS 'fmfiles_fk_p__is_internal_flag',
	fmfiles_fk_p.`project_contract_date` AS 'fmfiles_fk_p__project_contract_date',
	fmfiles_fk_p.`project_start_date` AS 'fmfiles_fk_p__project_start_date',
	fmfiles_fk_p.`project_completed_date` AS 'fmfiles_fk_p__project_completed_date',
	fmfiles_fk_p.`sort_order` AS 'fmfiles_fk_p__sort_order',

	fmfiles.*

FROM `file_manager_files` fmfiles
	INNER JOIN `file_manager_folders` fmfiles_fk_fmfolders ON fmfiles.`file_manager_folder_id` = fmfiles_fk_fmfolders.`id`
	INNER JOIN `file_locations` fmfiles_fk_fl ON fmfiles.`file_location_id` = fmfiles_fk_fl.`id`
	INNER JOIN `user_companies` fmfiles_fk_uc ON fmfiles.`user_company_id` = fmfiles_fk_uc.`id`
	INNER JOIN `contacts` fmfiles_fk_c ON fmfiles.`contact_id` = fmfiles_fk_c.`id`
	INNER JOIN `projects` fmfiles_fk_p ON fmfiles.`project_id` = fmfiles_fk_p.`id`
WHERE fmfiles.`id` = ?
";
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->convertPropertiesToData();

			if (isset($row['file_manager_folder_id'])) {
				$file_manager_folder_id = $row['file_manager_folder_id'];
				$row['fmfiles_fk_fmfolders__id'] = $file_manager_folder_id;
				$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'fmfiles_fk_fmfolders__');
				/* @var $fileManagerFolder FileManagerFolder */
				$fileManagerFolder->convertPropertiesToData();
			} else {
				$fileManagerFolder = false;
			}
			$fileManagerFile->setFileManagerFolder($fileManagerFolder);

			if (isset($row['file_location_id'])) {
				$file_location_id = $row['file_location_id'];
				$row['fmfiles_fk_fl__id'] = $file_location_id;
				$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id, 'fmfiles_fk_fl__');
				/* @var $fileLocation FileLocation */
				$fileLocation->convertPropertiesToData();
			} else {
				$fileLocation = false;
			}
			$fileManagerFile->setFileLocation($fileLocation);

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['fmfiles_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'fmfiles_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$fileManagerFile->setUserCompany($userCompany);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['fmfiles_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'fmfiles_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$fileManagerFile->setContact($contact);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['fmfiles_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'fmfiles_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$fileManagerFile->setProject($project);

			return $fileManagerFile;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_file_manager_file` (`user_company_id`,`project_id`,`file_manager_folder_id`,`virtual_file_name`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param int $file_manager_folder_id
	 * @param string $virtual_file_name
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndProjectIdAndFileManagerFolderIdAndVirtualFileName($database, $user_company_id, $project_id, $file_manager_folder_id, $virtual_file_name)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`user_company_id` = ?
AND fmfiles.`project_id` = ?
AND fmfiles.`file_manager_folder_id` = ?
AND fmfiles.`virtual_file_name` = ?
";
		$arrValues = array($user_company_id, $project_id, $file_manager_folder_id, $virtual_file_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			return $fileManagerFile;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrFileManagerFileIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFilesByArrFileManagerFileIds($database, $arrFileManagerFileIds, Input $options=null)
	{
		if (empty($arrFileManagerFileIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrFileManagerFileIds as $k => $file_manager_file_id) {
			$file_manager_file_id = (int) $file_manager_file_id;
			$arrFileManagerFileIds[$k] = $db->escape($file_manager_file_id);
		}
		$csvFileManagerFileIds = join(',', $arrFileManagerFileIds);

		$query =
"
SELECT

	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`id` IN ($csvFileManagerFileIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrFileManagerFilesByCsvFileManagerFileIds = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$fileManagerFile->convertPropertiesToData();

			$arrFileManagerFilesByCsvFileManagerFileIds[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		return $arrFileManagerFilesByCsvFileManagerFileIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `file_manager_files_fk_fmfolders` foreign key (`file_manager_folder_id`) references `file_manager_folders` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFilesByFileManagerFolderId($database, $file_manager_folder_id, Input $options=null)
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
			self::$_arrFileManagerFilesByFileManagerFolderId = null;
		}

		$arrFileManagerFilesByFileManagerFolderId = self::$_arrFileManagerFilesByFileManagerFolderId;
		if (isset($arrFileManagerFilesByFileManagerFolderId) && !empty($arrFileManagerFilesByFileManagerFolderId)) {
			return $arrFileManagerFilesByFileManagerFolderId;
		}

		$file_manager_folder_id = (int) $file_manager_folder_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`file_manager_folder_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByFileManagerFolderId = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByFileManagerFolderId[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByFileManagerFolderId = $arrFileManagerFilesByFileManagerFolderId;

		return $arrFileManagerFilesByFileManagerFolderId;
	}

	/**
	 * Load by constraint `file_manager_files_fk_fl` foreign key (`file_location_id`) references `file_locations` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $file_location_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFilesByFileLocationId($database, $file_location_id, Input $options=null)
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
			self::$_arrFileManagerFilesByFileLocationId = null;
		}

		$arrFileManagerFilesByFileLocationId = self::$_arrFileManagerFilesByFileLocationId;
		if (isset($arrFileManagerFilesByFileLocationId) && !empty($arrFileManagerFilesByFileLocationId)) {
			return $arrFileManagerFilesByFileLocationId;
		}

		$file_location_id = (int) $file_location_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`file_location_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($file_location_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByFileLocationId = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByFileLocationId[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByFileLocationId = $arrFileManagerFilesByFileLocationId;

		return $arrFileManagerFilesByFileLocationId;
	}

	/**
	 * Load by constraint `file_manager_files_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFilesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrFileManagerFilesByUserCompanyId = null;
		}

		$arrFileManagerFilesByUserCompanyId = self::$_arrFileManagerFilesByUserCompanyId;
		if (isset($arrFileManagerFilesByUserCompanyId) && !empty($arrFileManagerFilesByUserCompanyId)) {
			return $arrFileManagerFilesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByUserCompanyId[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByUserCompanyId = $arrFileManagerFilesByUserCompanyId;

		return $arrFileManagerFilesByUserCompanyId;
	}

	/**
	 * Load by constraint `file_manager_files_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFilesByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrFileManagerFilesByContactId = null;
		}

		$arrFileManagerFilesByContactId = self::$_arrFileManagerFilesByContactId;
		if (isset($arrFileManagerFilesByContactId) && !empty($arrFileManagerFilesByContactId)) {
			return $arrFileManagerFilesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByContactId = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByContactId[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByContactId = $arrFileManagerFilesByContactId;

		return $arrFileManagerFilesByContactId;
	}

	/**
	 * Load by constraint `file_manager_files_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileManagerFilesByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrFileManagerFilesByProjectId = null;
		}

		$arrFileManagerFilesByProjectId = self::$_arrFileManagerFilesByProjectId;
		if (isset($arrFileManagerFilesByProjectId) && !empty($arrFileManagerFilesByProjectId)) {
			return $arrFileManagerFilesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByProjectId = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByProjectId[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByProjectId = $arrFileManagerFilesByProjectId;

		return $arrFileManagerFilesByProjectId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `deleted_file_manager_files` (`user_company_id`,`project_id`,`deleted_flag`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param string $deleted_flag
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag($database, $user_company_id, $project_id, $deleted_flag, Input $options=null)
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
			self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag = null;
		}

		$arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag = self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag;
		if (isset($arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag) && !empty($arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag)) {
			return $arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag;
		}

		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;
		$deleted_flag = (string) $deleted_flag;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`user_company_id` = ?
AND fmfiles.`project_id` = ?
AND fmfiles.`deleted_flag` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($user_company_id, $project_id, $deleted_flag);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag = $arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag;

		return $arrFileManagerFilesByUserCompanyIdAndProjectIdAndDeletedFlag;
	}

	/**
	 * Load by key `directly_deleted_file_manager_files` (`user_company_id`,`project_id`,`directly_deleted_flag`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param string $directly_deleted_flag
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag($database, $user_company_id, $project_id, $directly_deleted_flag, Input $options=null)
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
			self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = null;
		}

		$arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
		if (isset($arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag) && !empty($arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag)) {
			return $arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
		}

		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;
		$directly_deleted_flag = (string) $directly_deleted_flag;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`user_company_id` = ?
AND fmfiles.`project_id` = ?
AND fmfiles.`directly_deleted_flag` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($user_company_id, $project_id, $directly_deleted_flag);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag = $arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;

		return $arrFileManagerFilesByUserCompanyIdAndProjectIdAndDirectlyDeletedFlag;
	}

	/**
	 * Load by key `file_manager_folder_id` (`file_manager_folder_id`,`virtual_file_name`).
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @param string $virtual_file_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileManagerFilesByFileManagerFolderIdAndVirtualFileName($database, $file_manager_folder_id, $virtual_file_name, Input $options=null)
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
			self::$_arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName = null;
		}

		$arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName = self::$_arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName;
		if (isset($arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName) && !empty($arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName)) {
			return $arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName;
		}

		$file_manager_folder_id = (int) $file_manager_folder_id;
		$virtual_file_name = (string) $virtual_file_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`file_manager_folder_id` = ?
AND fmfiles.`virtual_file_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($file_manager_folder_id, $virtual_file_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName = $arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName;

		return $arrFileManagerFilesByFileManagerFolderIdAndVirtualFileName;
	}

	/**
	 * Load by key `virtual_file_name` (`virtual_file_name`).
	 *
	 * @param string $database
	 * @param string $virtual_file_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileManagerFilesByVirtualFileName($database, $virtual_file_name, Input $options=null)
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
			self::$_arrFileManagerFilesByVirtualFileName = null;
		}

		$arrFileManagerFilesByVirtualFileName = self::$_arrFileManagerFilesByVirtualFileName;
		if (isset($arrFileManagerFilesByVirtualFileName) && !empty($arrFileManagerFilesByVirtualFileName)) {
			return $arrFileManagerFilesByVirtualFileName;
		}

		$virtual_file_name = (string) $virtual_file_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`virtual_file_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($virtual_file_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByVirtualFileName = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByVirtualFileName[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByVirtualFileName = $arrFileManagerFilesByVirtualFileName;

		return $arrFileManagerFilesByVirtualFileName;
	}

	/**
	 * Load by key `virtual_file_mime_type` (`virtual_file_mime_type`).
	 *
	 * @param string $database
	 * @param string $virtual_file_mime_type
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileManagerFilesByVirtualFileMimeType($database, $virtual_file_mime_type, Input $options=null)
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
			self::$_arrFileManagerFilesByVirtualFileMimeType = null;
		}

		$arrFileManagerFilesByVirtualFileMimeType = self::$_arrFileManagerFilesByVirtualFileMimeType;
		if (isset($arrFileManagerFilesByVirtualFileMimeType) && !empty($arrFileManagerFilesByVirtualFileMimeType)) {
			return $arrFileManagerFilesByVirtualFileMimeType;
		}

		$virtual_file_mime_type = (string) $virtual_file_mime_type;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles
WHERE fmfiles.`virtual_file_mime_type` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$arrValues = array($virtual_file_mime_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFilesByVirtualFileMimeType = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrFileManagerFilesByVirtualFileMimeType[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrFileManagerFilesByVirtualFileMimeType = $arrFileManagerFilesByVirtualFileMimeType;

		return $arrFileManagerFilesByVirtualFileMimeType;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all file_manager_files records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllFileManagerFiles($database, Input $options=null)
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
			self::$_arrAllFileManagerFiles = null;
		}

		$arrAllFileManagerFiles = self::$_arrAllFileManagerFiles;
		if (isset($arrAllFileManagerFiles) && !empty($arrAllFileManagerFiles)) {
			return $arrAllFileManagerFiles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileManagerFile = new FileManagerFile($database);
			$sqlOrderByColumns = $tmpFileManagerFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	fmfiles.*

FROM `file_manager_files` fmfiles{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `contact_id` ASC, `project_id` ASC, `file_manager_folder_id` ASC, `file_location_id` ASC, `virtual_file_name` ASC, `version_number` ASC, `virtual_file_name_sha1` ASC, `virtual_file_mime_type` ASC, `modified` ASC, `created` ASC, `deleted_flag` ASC, `directly_deleted_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllFileManagerFiles = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id);
			/* @var $fileManagerFile FileManagerFile */
			$arrAllFileManagerFiles[$file_manager_file_id] = $fileManagerFile;
		}

		$db->free_result();

		self::$_arrAllFileManagerFiles = $arrAllFileManagerFiles;

		return $arrAllFileManagerFiles;
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
INTO `file_manager_files`
(`user_company_id`, `contact_id`, `project_id`, `file_manager_folder_id`, `file_location_id`, `virtual_file_name`, `version_number`, `virtual_file_name_sha1`, `virtual_file_mime_type`, `modified`, `created`, `deleted_flag`, `directly_deleted_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `contact_id` = ?, `file_location_id` = ?, `version_number` = ?, `virtual_file_name_sha1` = ?, `virtual_file_mime_type` = ?, `modified` = ?, `created` = ?, `deleted_flag` = ?, `directly_deleted_flag` = ?
";
		$arrValues = array($this->user_company_id, $this->contact_id, $this->project_id, $this->file_manager_folder_id, $this->file_location_id, $this->virtual_file_name, $this->version_number, $this->virtual_file_name_sha1, $this->virtual_file_mime_type, $this->modified, $this->created, $this->deleted_flag, $this->directly_deleted_flag, $this->contact_id, $this->file_location_id, $this->version_number, $this->virtual_file_name_sha1, $this->virtual_file_mime_type, $this->modified, $this->created, $this->deleted_flag, $this->directly_deleted_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$file_manager_file_id = $db->insertId;
		$db->free_result();

		return $file_manager_file_id;
	}

	// Save: insert ignore

	/**
	 * Filter out bad filename/filepath chars \ / : * ? " < > |
	 *
	 * @param unknown_type $filepath
	 */
	public function getFilteredVirtualFileName()
	{
		if (!isset($this->filteredVirtualFileName)) {
			$filteredVirtualFileName = preg_replace('#[\/\\\:\*\?\"\>\<]+#', '', $this->virtual_file_name);
			$this->filteredVirtualFileName = $filteredVirtualFileName;
		}

		return $this->filteredVirtualFileName;
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
			$cdnFileUrl .= '?v=' . $version_number;
		}
		$this->fileUrl = $cdnFileUrl;

		return $cdnFileUrl;
	}

	public function generateUrlBasePath($useAbsoluteCdnUrl=false)
	{
		$useAbsoluteCdnUrl = (bool) $useAbsoluteCdnUrl;
		$file_location_id = $this->file_location_id;
		$config = Zend_Registry::get('config');
		// $file_manager_file_id = Data::parseInt($this->file_manager_file_id);
		$file_manager_base_path = $config->system->file_manager_base_path;
		$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
		$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;
		$fileManagerBackendFolderPath = $file_manager_base_path.$file_manager_backend_storage_path;
		/*get the file locatioin id */
		$arrFilePath = FileManager::createFilePathFromId($file_location_id, $fileManagerBackendFolderPath, $file_manager_file_name_prefix);
		$arrPath = $arrFilePath['file_path'].$arrFilePath['file_name'];
		$path = $arrPath;
		return $path;
	}

	public function generateDownloadUrl($useAbsoluteCdnUrl=false)
	{
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
		$fileDownloadUrl = $baseCdnUrl . $file_manager_file_name_prefix . $file_manager_file_id . '?download=1';
		$this->fileDownloadUrl = $fileDownloadUrl;

		return $fileDownloadUrl;
	}

	public function loadPermissions($permissions=null)
	{
		if (!isset($this->file_manager_file_id) || !isset($this->project_id)) {
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
		$file_manager_file_id = $this->file_manager_file_id;
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
				// non-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
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
			$this->view_privilege = 'Y';
			$this->grant_privileges_privilege = 'Y';
			$this->rename_privilege = 'Y';
			$this->move_privilege = 'Y';
			$this->delete_privilege = 'Y';

			return;
		}

		$this->view_privilege = 'N';
		$this->grant_privileges_privilege = 'N';
		$this->rename_privilege = 'N';
		$this->move_privilege = 'N';
		$this->delete_privilege = 'N';

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		$query =
"
SELECT r2f.*
FROM `roles_to_files` r2f
WHERE `file_manager_file_id` = $this->file_manager_file_id
AND `role_id` IN ($in)
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrRolesToFiles = array();
		while($row = $db->fetch()) {
			$grant_privileges_privilege = $row['grant_privileges_privilege'];
			$rename_privilege = $row['rename_privilege'];
			$move_privilege = $row['move_privilege'];
			$delete_privilege = $row['delete_privilege'];

			if ($grant_privileges_privilege == 'Y') {
				$this->grant_privileges_privilege = 'Y';
			}

			if ($rename_privilege == 'Y') {
				$this->rename_privilege = 'Y';
			}

			if ($move_privilege == 'Y') {
				$this->move_privilege = 'Y';
			}

			if ($delete_privilege == 'Y') {
				$this->delete_privilege = 'Y';
			}

			// set view_privilege
			if (($this->grant_privileges_privilege == 'N') && ($this->rename_privilege == 'N') && ($this->move_privilege == 'N') && ($this->delete_privilege == 'N')) {
				$this->view_privilege = 'Y';
			}

			$role_id = $row['role_id'];
			$roleToFile = new RoleToFile($database);
			$key = array(
				'role_id' => $role_id,
				'file_manager_file_id' => $this->file_manager_file_id
			);
			$roleToFile->setKey($key);
			$roleToFile->setData($row);
			$roleToFile->convertDataToProperties();

			$arrRolesToFiles[$role_id] = $roleToFile;
		}

		// set view_privilege
		if (($this->grant_privileges_privilege == 'Y') || ($this->rename_privilege == 'Y') || ($this->move_privilege == 'Y') || ($this->delete_privilege == 'Y')) {
			$this->view_privilege = 'Y';
		}

		$this->setRolesToFiles($arrRolesToFiles);

		return;
	}

	public function getRolesToFiles()
	{
		if (isset($this->rolesToFiles)) {
			return $this->rolesToFiles;
		} else {
			return null;
		}
	}

	public function setRolesToFiles($arrRolesToFiles)
	{
		$this->rolesToFiles = $arrRolesToFiles;
	}

	public function loadRolesToFiles()
	{
		if (!isset($this->file_manager_file_id)) {
			return;
		}

		$db = $this->getDb();

		$query =
"
SELECT *
FROM `roles_to_files`
WHERE `file_manager_file_id` = $this->file_manager_file_id
";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrRolesToFiles = array();
		while($row = $db->fetch()) {
			$role_id = $row['role_id'];
			$roleToFile = new RoleToFile($database);
			$key = array(
				'role_id' => $role_id,
				'file_manager_file_id' => $this->file_manager_file_id
			);
			$roleToFile->setKey($key);
			$roleToFile->setData($row);
			$roleToFile->convertDataToProperties();

			$arrRolesToFiles[$role_id] = $roleToFile;
		}

		$this->setRolesToFiles($arrRolesToFiles);
	}

	public function deriveFileNameAndExtension()
	{
		$virtual_file_name = $this->virtual_file_name;
		$arrFileNamePieces = preg_split('/[.]{1}/', $virtual_file_name, -1, PREG_SPLIT_NO_EMPTY);
		if (count($arrFileNamePieces) > 1) {
			$derivedFileExtension = array_pop($arrFileNamePieces);
			$derivedFileExtension = trim($derivedFileExtension);
		} else {
			$derivedFileExtension = '';
		}

		$derivedFileNameWithoutExtension = join('.', $arrFileNamePieces);
		$derivedFileNameWithoutExtension = trim($derivedFileNameWithoutExtension);

		$this->derivedFileExtension = $derivedFileExtension;
		$this->derivedFileNameWithoutExtension = $derivedFileNameWithoutExtension;
	}

	public function getFileNameWithoutExtension()
	{
		if (!isset($this->derivedFileNameWithoutExtension)) {
			$this->deriveFileNameAndExtension();
		}

		return $this->derivedFileNameWithoutExtension;
	}

	public function getFileExtension()
	{
		if (!isset($this->derivedFileExtension)) {
			$this->deriveFileNameAndExtension();
		}

		return $this->derivedFileExtension;
	}

	/**
	 * Pass in the $virtual_file_name only because will still have the same parent file_manager_folder_id
	 *
	 * @param string $virtual_file_name
	 * @return bool
	 */
	public function checkIfVirtualFileNameExists($virtual_file_name)
	{
		$database = $this->getDatabase();
		$db = $this->getDb();
		/* @var $db DBI_mysqli */

		// Check for duplicate name case
		// unique index (`user_company_id`, `project_id`, `file_manager_folder_id`, `virtual_file_name`)
		$query =
"
SELECT `id`
FROM `file_manager_files`
WHERE `user_company_id` = ?
AND `project_id` = ?
AND `file_manager_folder_id` = ?
AND BINARY `virtual_file_name` = ?
";
		$arrValues = array($this->user_company_id, $this->project_id, $this->file_manager_folder_id, $virtual_file_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			return true;
		} else {
			return false;
		}
	}

	public function permanentlyDelete()
	{
		$id = $this->file_manager_file_id;
		if (!isset($id) || empty($id)) {
			throw new Exception('Invalid file node.');
		}

		// Mark the folder and all child folders and files as deleted
//		$database = $this->getDatabase();

		// wrap all updates in a single transaction
		$db = $this->getDb();
		$db->begin();

		// delete from contacts_to_files
		$query =
"
DELETE
FROM `contacts_to_files`
WHERE `file_manager_file_id` = $id
";
		$db->query($query, MYSQLI_USE_RESULT);

		// delete from roles_to_files
		$query =
"
DELETE
FROM `roles_to_files`
WHERE `file_manager_file_id` = $id
";
		$db->query($query, MYSQLI_USE_RESULT);

		// delete from project_bid_invitations
		$query =
"
DELETE
FROM `project_bid_invitations`
WHERE `project_bid_invitation_file_manager_file_id` = $id
";
		$db->query($query, MYSQLI_USE_RESULT);

		// delete from gc_budget_line_item_unsigned_scope_of_work_documents
		$query =
"
DELETE
FROM `gc_budget_line_item_unsigned_scope_of_work_documents`
WHERE `unsigned_scope_of_work_document_file_manager_file_id` = $id
";
		$db->query($query, MYSQLI_USE_RESULT);

		// delete from gc_budget_line_item_bid_invitations
		$query =
"
DELETE
FROM `gc_budget_line_item_bid_invitations`
WHERE `gc_budget_line_item_bid_invitation_file_manager_file_id` = $id
";
		$db->query($query, MYSQLI_USE_RESULT);

		// delete from subcontractor_bid_documents
		$query =
"
DELETE
FROM `subcontractor_bid_documents`
WHERE `subcontractor_bid_document_file_manager_file_id` = $id
";
		$db->query($query, MYSQLI_USE_RESULT);

		// delete from submittal_attachments
		$query =
"
DELETE
FROM `submittal_attachments`
WHERE `su_attachment_file_manager_file_id` = $id
";
		$db->query($query, MYSQLI_USE_RESULT);

		// delete from request_for_information_attachments
		$query =
"
DELETE
FROM `request_for_information_attachments`
WHERE `rfi_attachment_file_manager_file_id` = $id
";
		$db->query($query, MYSQLI_USE_RESULT);
		//update file id in request for information
		$query = "
		 UPDATE `requests_for_information` SET `rfi_file_manager_file_id` = NULL
		 WHERE `rfi_file_manager_file_id`= $id
		 ";
		$db->query($query, MYSQLI_USE_RESULT);

		//delete from submittal draft attachment
		$query = "
		DELETE FROM `submittal_draft_attachments`
		WHERE `su_attachment_file_manager_file_id`= $id
		";
		$db->query($query, MYSQLI_USE_RESULT);
		//update file id in submittals
		$query = "
		 UPDATE `submittals` SET `su_file_manager_file_id` = NULL
		 WHERE `su_file_manager_file_id`= $id
		 ";
		$db->query($query, MYSQLI_USE_RESULT);
		//delete from rfi draft attachment
		$query = "
		DELETE FROM `request_for_information_draft_attachments`
		WHERE `rfi_attachment_file_manager_file_id`= $id
		";
		$db->query($query, MYSQLI_USE_RESULT);
		//delete from subcontract change order attachment
		 $query = "
		 DELETE FROM `subcontract_change_order_attachments`
		 WHERE `attachment_file_manager_file_id`= $id
		 ";
		 $db->query($query, MYSQLI_USE_RESULT);

		 //delete from punch list attachment
		 $query = "
		 DELETE FROM `punch_item_attachments`
		 WHERE `pi_attachment_file_manager_file_id`= $id
		 ";
		 $db->query($query, MYSQLI_USE_RESULT);
		 //update file id in change order
		 $query = "
		  UPDATE `change_orders` SET `co_file_manager_file_id` = NULL
			WHERE `co_file_manager_file_id`= $id
			";
		 $db->query($query, MYSQLI_USE_RESULT);
		 //delete from change order attachments
		 $query = "
		  DELETE FROM `change_order_attachments`
			WHERE `co_attachment_file_manager_file_id`= $id
			";
		 $db->query($query, MYSQLI_USE_RESULT);

		 //delete from transmittal attachments
		 $query = "
		  DELETE FROM `transmittal_attachments`
			WHERE `attachment_file_manager_file_id`= $id
			";
		 $db->query($query, MYSQLI_USE_RESULT);

		 //delete bid spread attachments
		 $query = "
		  DELETE FROM `bid_spreads`
			WHERE `unsigned_bid_spread_pdf_file_manager_file_id`= $id
			";
		 $db->query($query, MYSQLI_USE_RESULT);

		 //delete from daily construction reports
		$query = "
		 DELETE FROM `daily_construction_reports`
		 WHERE `daily_construction_report_file_manager_file_id`= $id
		 ";
		$db->query($query, MYSQLI_USE_RESULT);

		//delete from jobsite photos
		 $query = "
			DELETE FROM `jobsite_photos`
			WHERE `jobsite_photo_file_manager_file_id`= $id
			";
		 $db->query($query, MYSQLI_USE_RESULT);

		 //delete from jobsite signin sheets
 		 $query = "
 			DELETE FROM `jobsite_sign_in_sheets`
 			WHERE `jobsite_sign_in_sheet_file_manager_file_id`= $id
 			";
 		 $db->query($query, MYSQLI_USE_RESULT);

		 //delete from jobsite field reports
			$query = "
			 DELETE FROM `jobsite_field_reports`
			 WHERE `jobsite_field_report_file_manager_file_id`= $id
			 ";
			$db->query($query, MYSQLI_USE_RESULT);

			//delete from subcontract documents unsigned
 			$query = "
 			 DELETE FROM `subcontract_documents`
 			 WHERE `unsigned_subcontract_document_file_manager_file_id`= $id
 			 ";
 			$db->query($query, MYSQLI_USE_RESULT);

			//delete from subcontract documents signed
			$query = "
			 DELETE FROM `subcontract_documents`
			 WHERE `signed_subcontract_document_file_manager_file_id`= $id
			 ";
			$db->query($query, MYSQLI_USE_RESULT);
			//update unsigned file id in subcontracts
	 		 $query = "
	 		  UPDATE `subcontracts` SET `unsigned_subcontract_file_manager_file_id` = NULL
	 			WHERE `unsigned_subcontract_file_manager_file_id`= $id
	 			";
	 		 $db->query($query, MYSQLI_USE_RESULT);
			 //update signed file id in subcontracts
 	 		 $query = "
 	 		  UPDATE `subcontracts` SET `signed_subcontract_file_manager_file_id` = NULL
 	 			WHERE `signed_subcontract_file_manager_file_id`= $id
 	 			";
 	 		 $db->query($query, MYSQLI_USE_RESULT);
			 //update file id in subcontract item template
				$query = "
				 UPDATE `subcontract_item_templates` SET `file_manager_file_id` = NULL
				 WHERE `file_manager_file_id`= $id
				 ";
				$db->query($query, MYSQLI_USE_RESULT);
			// delete from file_manager_files
			$query =
			"
			DELETE
			FROM `file_manager_files`
			WHERE `id` = $id
			";
			$db->query($query, MYSQLI_USE_RESULT);

		$db->commit();

		return;
	}

	public static function restoreFromTrash($database,$file_manager_file_id)
	{
		$delete_fg ='N';
		$db = DBI::getInstance($database);
      	$query1 ="UPDATE `file_manager_files` set `deleted_flag`= 'N' , `directly_deleted_flag`='N' WHERE id = $file_manager_file_id " ;
		$db->execute($query1);
        $db->free_result();
	}

	/**
	 * Load a record from its virtual_file_name or save and return data.
	 */
	public static function findByVirtualFileName($database, $user_company_id, $contact_id, $project_id, $file_manager_folder_id, $file_location_id, $virtual_file_name, $virtual_file_mime_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		// unique index (`user_company_id`, `project_id`, `file_manager_folder_id`, `virtual_file_name`)
		$query = 'SELECT * '.
				 'FROM `file_manager_files` '.
				 'WHERE `user_company_id` = ? '.
				 'AND `project_id` = ? '.
				 'AND `file_manager_folder_id` = ? '.
				 'AND `virtual_file_name` = ? ';
		$arrValues = array($user_company_id, $project_id, $file_manager_folder_id, $virtual_file_name);
		$db->execute($query, $arrValues);

		$row = $db->fetch();
		$db->free_result();

		$fmf = new FileManagerFile($database);
		if ($row) {
			$file_manager_file_id = $row['id'];
			$fmf->setData($row);
			$fmf->convertDataToProperties();
			$key = array('id' => $file_manager_file_id);
			$fmf->setKey($key);
			$fmf->setId($file_manager_file_id);

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
			$fmf->project_id = $project_id;
			$fmf->file_manager_folder_id = $file_manager_folder_id;
			$fmf->file_location_id = $file_location_id;
			$fmf->virtual_file_name = $virtual_file_name;
			$fmf->virtual_file_mime_type = $virtual_file_mime_type;
			$fmf->convertPropertiesToData();
			$fmf['created'] = null;
			$file_manager_file_id = $fmf->save();
			$key = array('id' => $file_manager_file_id);
			$fmf->setKey($key);
			$fmf->setData(array());
			$fmf->load();
			$fmf->convertDataToProperties();
			$fmf->setId($file_manager_file_id);
		}

		$db->commit();

		return $fmf;
	}

	/**
	 * Load a record from its virtual_file_name or save and return data.
	 *
	 * @param $type 'project' | 'company'
	 */
	public static function searchByVirtualFileName($database, $permissions, $keywords, $type='project_non_owner', $showDeleted)
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
		$projectOwnerAdminFlag = $permissions->getProjectOwnerAdminFlag();
		$paying_customer_flag = $permissions->getPayingCustomerFlag();

		$arrContactRoles = $permissions->getContactRoles();
		$arrProjectRoles = $permissions->getProjectRoles();


		// Determine project_id by the type of search
		if ($type == 'project') {
			$project_id = $currentlySelectedProjectId;
			$scopedUserCompanyId = $currentlySelectedProjectUserCompanyId;
		} elseif ($type == 'company') {
			$project_id = $AXIS_NON_EXISTENT_PROJECT_ID;
			$scopedUserCompanyId = $user_company_id;
		} elseif ($type == 'project_non_owner') {
			$project_id = $currentlySelectedProjectId;
			$scopedUserCompanyId = $user_company_id;
		}

		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			if ($userRole == 'user') {
				// non-admins must have at least one role
				if (empty($arrContactRoles)) {
					return array();
				}
				if (isset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
					$loadAllFilesFlag = true;
				} else {
					$loadAllFilesFlag = false;
					$arrContactRoleIds = array_keys($arrContactRoles);
					$in = join(',', $arrContactRoleIds);
				}
			} else {
				// admin or global_admin case
				$loadAllFilesFlag = true;
			}
		} else {
			if ($type == 'project') {
				// Project Files case
				if ($projectOwnerAdminFlag) {
					$loadAllFilesFlag = true;
				} elseif (!$projectOwnerFlag || ($projectOwnerFlag && ($userRole == 'user'))) {
					// non-admins must have at least one role
					if (empty($arrProjectRoles)) {
						return array();
					}
					if (isset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
						$loadAllFilesFlag = true;
					} else {
						$loadAllFilesFlag = false;
						$arrProjectRoleIds = array_keys($arrProjectRoles);
						$in = join(',', $arrProjectRoleIds);
					}
				}
			} elseif ($type == 'project_non_owner') {
				// Project Files case
				if (($userRole == 'global_admin') || ($userRole == 'admin')) {
					$loadAllFilesFlag = true;
				} elseif (!$projectOwnerFlag || ($projectOwnerFlag && ($userRole == 'user'))) {
					// non-admins must have at least one role
					if (empty($arrProjectRoles)) {
						return array();
					}
					if (isset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN])) {
						$loadAllFilesFlag = true;
					} else {
						$loadAllFilesFlag = false;
						$arrProjectRoleIds = array_keys($arrProjectRoles);
						$in = join(',', $arrProjectRoleIds);
					}
				}
			}
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		//$escaped_keywords = preg_quote($keywords);
		//$escaped_keywords = mysqli_real_escape_string($db->link_id, $escaped_keywords);
		$escaped_keywords = mysqli_real_escape_string($db->link_id, $keywords);
		$arrEscapedKeywords = explode(' ', $escaped_keywords);
		$mysqlEscapedKeywords = join('%', $arrEscapedKeywords);
		$mysqlEscapedKeywords = '%'.$mysqlEscapedKeywords.'%';

		// global_admin is just like admin for the file manager - sees all folders for their user_company_id
		// global_admin can use the impersonate user feature to see other files and folders
		// admin sees all folders for their given user_company_id
		$query =
"
SELECT *
FROM `file_manager_files` fmf";

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			$query .=
", `roles_to_files` r2f ";
		}

		$query .=
"
WHERE fmf.`user_company_id` = ?
AND fmf.`project_id` = ?
AND fmf.`virtual_file_name` LIKE '$mysqlEscapedKeywords'";

		if ($showDeleted) {
			$query .=
"
AND fmf.`deleted_flag` = 'Y'";
		} else {
			$query .=
"
AND fmf.`deleted_flag` = 'N'";
		}

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			//$arrIn = array_keys($arrRoleIds);
			//$in = join(',', $arrIn);
			$query .=
"
AND fmf.`id` = r2f.`file_manager_file_id`
AND r2f.`role_id` IN ($in)
GROUP BY fmf.`id`";
		}

		$query .=
"
ORDER BY fmf.`virtual_file_name`";
		$arrValues = array($scopedUserCompanyId, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileManagerFiles = array();
		$arrFileManagerFolderIds = array();
		$arrFolderToFileMap = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fmf = new FileManagerFile($database);
			$fmf->setData($row);
			$fmf->convertDataToProperties();
			$arrFileManagerFiles[$file_manager_file_id] = $fmf;

			$file_manager_folder_id = $row['file_manager_folder_id'];
			$arrFileManagerFolderIds[] = $file_manager_folder_id;

			$arrFolderToFileMap[$file_manager_folder_id][$file_manager_file_id] = $fmf;
		}
		$db->free_result();

		$arrFileManagerFolders = array();
		if (!empty($arrFileManagerFolderIds)) {
			$fileManagerFolderIdIn = join(',', $arrFileManagerFolderIds);
			$query =
"
SELECT *
FROM `file_manager_folders`
WHERE `id` IN ($fileManagerFolderIdIn)
";
			$db->query($query, MYSQLI_USE_RESULT);

			while ($row = $db->fetch()) {
				$file_manager_folder_id = $row['id'];
				$fmf = new FileManagerFolder($database);
				$fmf->setData($row);
				$fmf->convertDataToProperties();
				$arrFileManagerFolders[$file_manager_folder_id] = $fmf;

				$arrFiles = $arrFolderToFileMap[$file_manager_folder_id];
				foreach ($arrFiles as $fileManageFile) {
					$fileManageFile->setFileManagerFolder($fmf);
				}
			}
			$db->free_result();
		}

		$arrReturn = array(
			'files' => $arrFileManagerFiles,
			'folders' => $arrFileManagerFolders,
			'map' => $arrFolderToFileMap
		);

		return $arrReturn;
	}

	/**
	 * Load a list of file_manager_files records from the file_manager_folder_id of their parent folder
	 */
	//public static function loadAccessibleChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $contact_id, $file_manager_folder_id, $showDeleted = false)
	public static function loadAccessibleChildFilesByVirtualFolderId($database, $permissions, $parentFileManagerFolder, $showDeleted = false, $project_id='')
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
				// non-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
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


		// global_admin is just like admin for the file manager - sees all folders for their user_company_id
		// global_admin can use the impersonate user feature to see other files and folders
		// admin sees all folders for their given user_company_id
		$query =
"
SELECT *
FROM `file_manager_files` fmf
";

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			$query .= ", `roles_to_files` r2f ";
		}

		$query .=
			"WHERE fmf.`user_company_id` = ? ".
			"AND fmf.`project_id` = ? ".
			"AND fmf.`file_manager_folder_id` = ? ";

		if ($showDeleted) {
			$query .= "AND fmf.`deleted_flag` = 'Y' ";
		} else {
			$query .= "AND fmf.`deleted_flag` = 'N' ";
		}

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			//$arrIn = array_keys($arrRoleIds);
			//$in = join(',', $arrIn);
			$query .=
				"AND fmf.`id` = r2f.`file_manager_file_id` ".
				"AND r2f.`role_id` IN ($in) ".
				"GROUP BY fmf.`id` ";
		}

		$query .=
			"ORDER BY fmf.`virtual_file_name` ";
		$arrValues = array($parentFileManagerFolder->user_company_id, $parentFileManagerFolder->project_id, $parentFileManagerFolder->file_manager_folder_id);
		$db->execute($query, $arrValues);

		$arrFileManagerFiles = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fmf = new FileManagerFile($database);
			$fmf->setData($row);
			$fmf->convertDataToProperties();
			$arrFileManagerFiles[$file_manager_file_id] = $fmf;
		}
		$db->free_result();

		return $arrFileManagerFiles;
	}

	/**
	 * Load a list of file_manager_files records from the file_manager_folder_id of their parent folder
	 */
	public static function loadChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $file_manager_folder_id, $showDeleted = false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if ($showDeleted) {
			$and = "AND deleted_flag = 'Y' ";
		} else {
			$and = "AND deleted_flag = 'N' ";
		}

		$query = "SELECT * ".
				 "FROM `file_manager_files` ".
				 "WHERE `user_company_id` = ? ".
				 "AND `project_id` = ? ".
				 "AND `file_manager_folder_id` = ? ".
				 $and.
				 "ORDER BY `virtual_file_name` ";
		$arrValues = array($user_company_id, $project_id, $file_manager_folder_id);
		$db->execute($query, $arrValues);

		$arrFileManagerFiles = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fileManagerFile = new FileManagerFile($database);
			$fileManagerFile->setId($file_manager_file_id);
			$key = array('id' => $file_manager_file_id);
			$fileManagerFile->setKey($key);
			$fileManagerFile->setData($row);
			$fileManagerFile->convertDataToProperties();
			$arrFileManagerFiles[$file_manager_file_id] = $fileManagerFile;
		}
		$db->free_result();

		return $arrFileManagerFiles;
	}

	/**
	 * Load files that are in the trash.
	 */
	public static function loadTrashByProjectId($database, $user_company_id, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query = "SELECT * ".
				 "FROM `file_manager_files` ".
				 "WHERE `user_company_id` = ? ".
				 "AND `project_id` = ? ".
				 "AND `directly_deleted_flag` = 'Y' ".
				 "ORDER BY `virtual_file_name` ";
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues);

		$arrFileManagerFiles = array();
		while ($row = $db->fetch()) {
			$fileManagerFile = new FileManagerFile($database);
			$fileManagerFile->setData($row);
			$fileManagerFile->convertDataToProperties();
			$arrFileManagerFiles[] = $fileManagerFile;
		}
		$db->free_result();

		return $arrFileManagerFiles;
	}

	public static function groupFileManagerFileIdsByProject($database, array $arrFileIds)
	{
		if (empty($arrFileIds)) {
			return array();
		}

		$in = join(',', $arrFileIds);

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query = "SELECT `id`, `project_id` ".
				 "FROM `file_manager_files` ".
				 "WHERE `id` IN ($in) ".
				 "AND `deleted_flag` = 'N' ".
				 "AND `directly_deleted_flag` = 'N' ";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrFileManagerFileIdsByProjectId = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$project_id = $row['project_id'];
			$arrFileManagerFileIdsByProjectId[$project_id][] = $file_manager_file_id;
		}
		$db->free_result();

		return $arrFileManagerFileIdsByProjectId;
	}

	public static function loadPermissionsMatrixByIdList($database, $arrFileManagerFileIds, $project_id, $permissions=null)
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
				// non-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
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
			foreach ($arrFileManagerFileIds as $file_manager_file_id) {
				$arrPermissionsMatrix[$file_manager_file_id]['grant_privileges_privilege'] = 'Y';
				$arrPermissionsMatrix[$file_manager_file_id]['rename_privilege'] = 'Y';
				$arrPermissionsMatrix[$file_manager_file_id]['move_privilege'] = 'Y';
				$arrPermissionsMatrix[$file_manager_file_id]['delete_privilege'] = 'Y';
			}

			$arrPermissionsMatrix['grant_privileges_privilege'] = 'Y';
			$arrPermissionsMatrix['rename_privilege'] = 'Y';
			$arrPermissionsMatrix['move_privilege'] = 'Y';
			$arrPermissionsMatrix['delete_privilege'] = 'Y';

			return $arrPermissionsMatrix;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->connect();

		$fileIdIn = join(',', $arrFileManagerFileIds);

		$query =
"
SELECT r2f.*
FROM `roles_to_files` r2f
WHERE r2f.`role_id` IN ($in)
AND r2f.`file_manager_file_id` IN ($fileIdIn)
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrPermissionsMatrix['grant_privileges_privilege'] = 'Y';
		$arrPermissionsMatrix['rename_privilege'] = 'Y';
		$arrPermissionsMatrix['move_privilege'] = 'Y';
		$arrPermissionsMatrix['delete_privilege'] = 'Y';

		$counter = 0;
		while($row = $db->fetch()) {
			$counter++;
			$file_manager_file_id = $row['file_manager_file_id'];
			$grant_privileges_privilege = $row['grant_privileges_privilege'];
			$rename_privilege = $row['rename_privilege'];
			$move_privilege = $row['move_privilege'];
			$delete_privilege = $row['delete_privilege'];

			$arrPermissionsMatrix[$file_manager_file_id]['grant_privileges_privilege'] = $grant_privileges_privilege;
			$arrPermissionsMatrix[$file_manager_file_id]['rename_privilege'] = $rename_privilege;
			$arrPermissionsMatrix[$file_manager_file_id]['move_privilege'] = $move_privilege;
			$arrPermissionsMatrix[$file_manager_file_id]['delete_privilege'] = $delete_privilege;

			if ($grant_privileges_privilege == 'N') {
				$arrPermissionsMatrix['grant_privileges_privilege'] = 'N';
			}
			if ($rename_privilege == 'N') {
				$arrPermissionsMatrix['rename_privilege'] = 'N';
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
			$arrPermissionsMatrix['move_privilege'] = 'N';
			$arrPermissionsMatrix['delete_privilege'] = 'N';
		}

		$arrPermissionsMatrix[$file_manager_file_id]['grant_privileges_privilege'] = $grant_privileges_privilege;
		$arrPermissionsMatrix[$file_manager_file_id]['rename_privilege'] = $rename_privilege;
		$arrPermissionsMatrix[$file_manager_file_id]['move_privilege'] = $move_privilege;
		$arrPermissionsMatrix[$file_manager_file_id]['delete_privilege'] = $delete_privilege;

		return $arrPermissionsMatrix;
	}

	public static function setPermissionsToMatchParentFolder($database, $file_manager_file_id, $file_manager_folder_id)
	{
		$file_manager_file_id = (int) $file_manager_file_id;
		$file_manager_folder_id = (int) $file_manager_folder_id;

		// Set Permissions of the file to match the parent folder.
		$db = DBI::getInstance($database);

		// Role-based permissions
		// Delete Old Records
		$query =
"
DELETE FROM `roles_to_files`
WHERE `file_manager_file_id` = ?
";
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		$query =
"
INSERT INTO `roles_to_files`
(`role_id`, `file_manager_file_id`, `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`)
SELECT `role_id`, ? AS 'file_manager_file_id', `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`
FROM roles_to_folders
WHERE file_manager_folder_id = ?
";
		$arrValues = array($file_manager_file_id, $file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		// Contact-based permissions
		// Delete Old Records
		$query =
"
DELETE FROM `contacts_to_files`
WHERE `file_manager_file_id` = ?
";
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		$query =
"
INSERT INTO `contacts_to_files`
(`contact_id`, `file_manager_file_id`, `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`)
SELECT `contact_id`, ? AS 'file_manager_file_id', `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`
FROM contacts_to_folders
WHERE file_manager_folder_id = ?
";
		$arrValues = array($file_manager_file_id, $file_manager_folder_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		return;
	}

	public static function setSingleUserPermissions($database, $file_manager_file_id, $project_id, $contact_id)
	{
		// Set Permissions of the file for a single user.
		$db = DBI::getInstance($database);

		$file_manager_file_id = (int) $file_manager_file_id;

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
		$arrProjectRoles = $permissions->getProjectRoles();

		if ($project_id == $AXIS_NON_EXISTENT_PROJECT_ID) {
			// Company Files case
			// Unset the admin and global_admin role_id values
			unset($arrContactRoles[$AXIS_USER_ROLE_ID_ADMIN]);
			unset($arrContactRoles[$AXIS_USER_ROLE_ID_GLOBAL_ADMIN]);
			if (!empty($arrContactRoles)) {
				$arrContactRoleIds = array_keys($arrContactRoles);
				$in = join(',', $arrContactRoleIds);
				$arrRoleIds = $arrContactRoleIds;
			} else {
				$arrRoleIds = array();
			}
		} else {
			// Project Files case
			// Unset the admin and global_admin role_id values
			unset($arrProjectRoles[$AXIS_USER_ROLE_ID_ADMIN]);
			unset($arrProjectRoles[$AXIS_USER_ROLE_ID_GLOBAL_ADMIN]);
			if (!empty($arrProjectRoles)) {
				$arrProjectRoleIds = array_keys($arrProjectRoles);
				$in = join(',', $arrProjectRoleIds);
				$arrRoleIds = $arrProjectRoleIds;
			} else {
				$arrRoleIds = array();
			}
		}

		// Role-based permissions
		// @todo Decide if want to delete all relationships here
		// Delete Old Records
		$query =
"
DELETE FROM `roles_to_files`
WHERE `file_manager_file_id` = ?
";
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		$query =
"
INSERT INTO `roles_to_files`
(`role_id`, `file_manager_file_id`, `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, 'Y', 'Y', 'Y', 'Y')
";
		foreach ($arrRoleIds as $tmpRoleId) {
			$arrValues = array($tmpRoleId, $file_manager_file_id);
			$db->execute($query, $arrValues);
			$db->free_result();
		}

		// Contact-based permissions
		// @todo Decide if want to delete all relationships here
		// Delete Old Records
		$query =
"
DELETE FROM `contacts_to_files`
WHERE `file_manager_file_id` = ?
";
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		// Just the currentlyActiveContactId here
		$query =
"
INSERT INTO `contacts_to_files`
(`contact_id`, `file_manager_file_id`, `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, 'Y', 'Y', 'Y', 'Y')
";
		$arrValues = array($contact_id, $file_manager_file_id);
		$db->execute($query, $arrValues);
		$db->free_result();

		return;
	}
	/**
	 * Load a list of file_manager_files records from the file_manager_folder_id of their parent folder
	 */
	//public static function loadAccessibleChildFilesByVirtualFolderId($database, $user_company_id, $project_id, $contact_id, $file_manager_folder_id, $showDeleted = false)
	public static function loadAccessibleChildFilesByVirtualFolderIdForGues($database, $permissions, $parentFileManagerFolder, $showDeleted = false, $permissions)
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
		$projectOwnerAdminFlag = true; //allow guest users to view plan files
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
				// non-admins must have at least one role
				if (empty($arrProjectRoles)) {
					return array();
				}
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


		// global_admin is just like admin for the file manager - sees all folders for their user_company_id
		// global_admin can use the impersonate user feature to see other files and folders
		// admin sees all folders for their given user_company_id
		$query =
"
SELECT *
FROM `file_manager_files` fmf
";

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			$query .= ", `roles_to_files` r2f ";
		}

		$query .=
			"WHERE fmf.`user_company_id` = ? ".
			"AND fmf.`project_id` = ? ".
			"AND fmf.`file_manager_folder_id` = ? ";

		if ($showDeleted) {
			$query .= "AND fmf.`deleted_flag` = 'Y' ";
		} else {
			$query .= "AND fmf.`deleted_flag` = 'N' ";
		}

		// Role-based permissions
		if (!$loadAllFilesFlag) {
			//$arrIn = array_keys($arrRoleIds);
			//$in = join(',', $arrIn);
			$query .=
				"AND fmf.`id` = r2f.`file_manager_file_id` ".
				"AND r2f.`role_id` IN ($in) ".
				"GROUP BY fmf.`id` ";
		}

		$query .=
			"ORDER BY fmf.`virtual_file_name` ";
		$arrValues = array($parentFileManagerFolder->user_company_id, $parentFileManagerFolder->project_id, $parentFileManagerFolder->file_manager_folder_id);
		$db->execute($query, $arrValues);

		$arrFileManagerFiles = array();
		while ($row = $db->fetch()) {
			$file_manager_file_id = $row['id'];
			$fmf = new FileManagerFile($database);
			$fmf->setData($row);
			$fmf->convertDataToProperties();
			$arrFileManagerFiles[$file_manager_file_id] = $fmf;
		}
		$db->free_result();

		return $arrFileManagerFiles;
	}

	//To get the file location based on the file manager id
	function getFilelocationForFiles($database,$file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		$query ="SELECT * FROM `file_manager_files` WHERE `id` = ? ";
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues);
		$row = $db->fetch();
		$fileLocation = $row['file_location_id'];
		$db->free_result();
		return $fileLocation;
	}

	//To rename virtual file name in the trash folder
	function renameFileInTrashFolder($database,$file_manager_file_id)
	{
		$db = DBI::getInstance($database);
        $query ="UPDATE `file_manager_files` SET virtual_file_name=CONCAT('tr','~',virtual_file_name) WHERE `id` = $file_manager_file_id ";
        $db->execute($query);
        $db->free_result();
       
	}

	//To rename All virtual File present in a folder
	function renameAllFileMoveToTrashFolder($database,$file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
        $query ="UPDATE `file_manager_files` SET virtual_file_name=CONCAT('tr','~',virtual_file_name) WHERE `file_manager_folder_id` = $file_manager_folder_id ";
        $db->execute($query);
        $db->free_result();
       
	}
	//To remove the prefix file name
	function RemoveAllFilePrefixRestore($database,$file_manager_file_id)
	{
		$db = DBI::getInstance($database);
        $query ="UPDATE `file_manager_files`  SET virtual_file_name = SUBSTRING_INDEX(virtual_file_name, '~', -1) WHERE `id` = $file_manager_file_id ";
        $db->execute($query);
        $db->free_result();
	}

		//To remove the prefix file name
	function RemoveAllFolderPrefixRestore($database,$file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
        $query ="UPDATE `file_manager_files`  SET virtual_file_name = SUBSTRING_INDEX(virtual_file_name, '~', -1) WHERE `file_manager_folder_id` = $file_manager_folder_id ";
        $db->execute($query);
        $db->free_result();
	}

	
	
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

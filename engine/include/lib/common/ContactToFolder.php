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
 * ContactToFolder.
 *
 * @category   Framework
 * @package    ContactToFolder
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactToFolder extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactToFolder';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contacts_to_folders';

	/**
	 * primary key (`contact_id`,`file_manager_folder_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'contact_id' => 'int',
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
		'unique_contact_to_folder_via_primary_key' => array(
			'contact_id' => 'int',
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
		'contact_id' => 'contact_id',
		'file_manager_folder_id' => 'file_manager_folder_id',

		'grant_privileges_privilege' => 'grant_privileges_privilege',
		'rename_privilege' => 'rename_privilege',
		'upload_privilege' => 'upload_privilege',
		'move_privilege' => 'move_privilege',
		'delete_privilege' => 'delete_privilege'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_id;
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
	protected static $_arrContactsToFoldersByContactId;
	protected static $_arrContactsToFoldersByFileManagerFolderId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactsToFolders;

	// Foreign Key Objects
	private $_contact;
	private $_fileManagerFolder;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contacts_to_folders')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
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
	public static function getArrContactsToFoldersByContactId()
	{
		if (isset(self::$_arrContactsToFoldersByContactId)) {
			return self::$_arrContactsToFoldersByContactId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToFoldersByContactId($arrContactsToFoldersByContactId)
	{
		self::$_arrContactsToFoldersByContactId = $arrContactsToFoldersByContactId;
	}

	public static function getArrContactsToFoldersByFileManagerFolderId()
	{
		if (isset(self::$_arrContactsToFoldersByFileManagerFolderId)) {
			return self::$_arrContactsToFoldersByFileManagerFolderId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToFoldersByFileManagerFolderId($arrContactsToFoldersByFileManagerFolderId)
	{
		self::$_arrContactsToFoldersByFileManagerFolderId = $arrContactsToFoldersByFileManagerFolderId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactsToFolders()
	{
		if (isset(self::$_arrAllContactsToFolders)) {
			return self::$_arrAllContactsToFolders;
		} else {
			return null;
		}
	}

	public static function setArrAllContactsToFolders($arrAllContactsToFolders)
	{
		self::$_arrAllContactsToFolders = $arrAllContactsToFolders;
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
	 * Find by primary key (`contact_id`,`file_manager_folder_id`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndFileManagerFolderId($database, $contact_id, $file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	c2folders.*

FROM `contacts_to_folders` c2folders
WHERE c2folders.`contact_id` = ?
AND c2folders.`file_manager_folder_id` = ?
";
		$arrValues = array($contact_id, $file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToFolder = self::instantiateOrm($database, 'ContactToFolder', $row);
			/* @var $contactToFolder ContactToFolder */
			return $contactToFolder;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`contact_id`,`file_manager_folder_id`) Extended.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $file_manager_folder_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndFileManagerFolderIdExtended($database, $contact_id, $file_manager_folder_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	c2folders_fk_c.`id` AS 'c2folders_fk_c__contact_id',
	c2folders_fk_c.`user_company_id` AS 'c2folders_fk_c__user_company_id',
	c2folders_fk_c.`user_id` AS 'c2folders_fk_c__user_id',
	c2folders_fk_c.`contact_company_id` AS 'c2folders_fk_c__contact_company_id',
	c2folders_fk_c.`email` AS 'c2folders_fk_c__email',
	c2folders_fk_c.`name_prefix` AS 'c2folders_fk_c__name_prefix',
	c2folders_fk_c.`first_name` AS 'c2folders_fk_c__first_name',
	c2folders_fk_c.`additional_name` AS 'c2folders_fk_c__additional_name',
	c2folders_fk_c.`middle_name` AS 'c2folders_fk_c__middle_name',
	c2folders_fk_c.`last_name` AS 'c2folders_fk_c__last_name',
	c2folders_fk_c.`name_suffix` AS 'c2folders_fk_c__name_suffix',
	c2folders_fk_c.`title` AS 'c2folders_fk_c__title',
	c2folders_fk_c.`vendor_flag` AS 'c2folders_fk_c__vendor_flag',

	c2folders_fk_fmfolders.`id` AS 'c2folders_fk_fmfolders__file_manager_folder_id',
	c2folders_fk_fmfolders.`user_company_id` AS 'c2folders_fk_fmfolders__user_company_id',
	c2folders_fk_fmfolders.`contact_id` AS 'c2folders_fk_fmfolders__contact_id',
	c2folders_fk_fmfolders.`project_id` AS 'c2folders_fk_fmfolders__project_id',
	c2folders_fk_fmfolders.`virtual_file_path` AS 'c2folders_fk_fmfolders__virtual_file_path',
	c2folders_fk_fmfolders.`virtual_file_path_sha1` AS 'c2folders_fk_fmfolders__virtual_file_path_sha1',
	c2folders_fk_fmfolders.`modified` AS 'c2folders_fk_fmfolders__modified',
	c2folders_fk_fmfolders.`created` AS 'c2folders_fk_fmfolders__created',
	c2folders_fk_fmfolders.`deleted_flag` AS 'c2folders_fk_fmfolders__deleted_flag',
	c2folders_fk_fmfolders.`directly_deleted_flag` AS 'c2folders_fk_fmfolders__directly_deleted_flag',

	c2folders.*

FROM `contacts_to_folders` c2folders
	INNER JOIN `contacts` c2folders_fk_c ON c2folders.`contact_id` = c2folders_fk_c.`id`
	INNER JOIN `file_manager_folders` c2folders_fk_fmfolders ON c2folders.`file_manager_folder_id` = c2folders_fk_fmfolders.`id`
WHERE c2folders.`contact_id` = ?
AND c2folders.`file_manager_folder_id` = ?
";
		$arrValues = array($contact_id, $file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToFolder = self::instantiateOrm($database, 'ContactToFolder', $row);
			/* @var $contactToFolder ContactToFolder */
			$contactToFolder->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['c2folders_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'c2folders_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$contactToFolder->setContact($contact);

			if (isset($row['file_manager_folder_id'])) {
				$file_manager_folder_id = $row['file_manager_folder_id'];
				$row['c2folders_fk_fmfolders__id'] = $file_manager_folder_id;
				$fileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'c2folders_fk_fmfolders__');
				/* @var $fileManagerFolder FileManagerFolder */
				$fileManagerFolder->convertPropertiesToData();
			} else {
				$fileManagerFolder = false;
			}
			$contactToFolder->setFileManagerFolder($fileManagerFolder);

			return $contactToFolder;
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
	 * @param array $arrContactIdAndFileManagerFolderIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToFoldersByArrContactIdAndFileManagerFolderIdList($database, $arrContactIdAndFileManagerFolderIdList, Input $options=null)
	{
		if (empty($arrContactIdAndFileManagerFolderIdList)) {
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
		// ORDER BY `contact_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToFolder = new ContactToFolder($database);
			$sqlOrderByColumns = $tmpContactToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrContactIdAndFileManagerFolderIdList as $k => $arrTmp) {
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
		if (count($arrContactIdAndFileManagerFolderIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	c2folders.*

FROM `contacts_to_folders` c2folders
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToFoldersByArrContactIdAndFileManagerFolderIdList = array();
		while ($row = $db->fetch()) {
			$contactToFolder = self::instantiateOrm($database, 'ContactToFolder', $row);
			/* @var $contactToFolder ContactToFolder */
			$arrContactsToFoldersByArrContactIdAndFileManagerFolderIdList[] = $contactToFolder;
		}

		$db->free_result();

		return $arrContactsToFoldersByArrContactIdAndFileManagerFolderIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_to_folders_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToFoldersByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrContactsToFoldersByContactId = null;
		}

		$arrContactsToFoldersByContactId = self::$_arrContactsToFoldersByContactId;
		if (isset($arrContactsToFoldersByContactId) && !empty($arrContactsToFoldersByContactId)) {
			return $arrContactsToFoldersByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToFolder = new ContactToFolder($database);
			$sqlOrderByColumns = $tmpContactToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2folders.*

FROM `contacts_to_folders` c2folders
WHERE c2folders.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToFoldersByContactId = array();
		while ($row = $db->fetch()) {
			$contactToFolder = self::instantiateOrm($database, 'ContactToFolder', $row);
			/* @var $contactToFolder ContactToFolder */
			$arrContactsToFoldersByContactId[] = $contactToFolder;
		}

		$db->free_result();

		self::$_arrContactsToFoldersByContactId = $arrContactsToFoldersByContactId;

		return $arrContactsToFoldersByContactId;
	}

	/**
	 * Load by constraint `contacts_to_folders_fk_fmfolders` foreign key (`file_manager_folder_id`) references `file_manager_folders` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $file_manager_folder_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToFoldersByFileManagerFolderId($database, $file_manager_folder_id, Input $options=null)
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
			self::$_arrContactsToFoldersByFileManagerFolderId = null;
		}

		$arrContactsToFoldersByFileManagerFolderId = self::$_arrContactsToFoldersByFileManagerFolderId;
		if (isset($arrContactsToFoldersByFileManagerFolderId) && !empty($arrContactsToFoldersByFileManagerFolderId)) {
			return $arrContactsToFoldersByFileManagerFolderId;
		}

		$file_manager_folder_id = (int) $file_manager_folder_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToFolder = new ContactToFolder($database);
			$sqlOrderByColumns = $tmpContactToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2folders.*

FROM `contacts_to_folders` c2folders
WHERE c2folders.`file_manager_folder_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($file_manager_folder_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToFoldersByFileManagerFolderId = array();
		while ($row = $db->fetch()) {
			$contactToFolder = self::instantiateOrm($database, 'ContactToFolder', $row);
			/* @var $contactToFolder ContactToFolder */
			$arrContactsToFoldersByFileManagerFolderId[] = $contactToFolder;
		}

		$db->free_result();

		self::$_arrContactsToFoldersByFileManagerFolderId = $arrContactsToFoldersByFileManagerFolderId;

		return $arrContactsToFoldersByFileManagerFolderId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contacts_to_folders records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactsToFolders($database, Input $options=null)
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
			self::$_arrAllContactsToFolders = null;
		}

		$arrAllContactsToFolders = self::$_arrAllContactsToFolders;
		if (isset($arrAllContactsToFolders) && !empty($arrAllContactsToFolders)) {
			return $arrAllContactsToFolders;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToFolder = new ContactToFolder($database);
			$sqlOrderByColumns = $tmpContactToFolder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2folders.*

FROM `contacts_to_folders` c2folders{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `file_manager_folder_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `upload_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactsToFolders = array();
		while ($row = $db->fetch()) {
			$contactToFolder = self::instantiateOrm($database, 'ContactToFolder', $row);
			/* @var $contactToFolder ContactToFolder */
			$arrAllContactsToFolders[] = $contactToFolder;
		}

		$db->free_result();

		self::$_arrAllContactsToFolders = $arrAllContactsToFolders;

		return $arrAllContactsToFolders;
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
INTO `contacts_to_folders`
(`contact_id`, `file_manager_folder_id`, `grant_privileges_privilege`, `rename_privilege`, `upload_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `grant_privileges_privilege` = ?, `rename_privilege` = ?, `upload_privilege` = ?, `move_privilege` = ?, `delete_privilege` = ?
";
		$arrValues = array($this->contact_id, $this->file_manager_folder_id, $this->grant_privileges_privilege, $this->rename_privilege, $this->upload_privilege, $this->move_privilege, $this->delete_privilege, $this->grant_privileges_privilege, $this->rename_privilege, $this->upload_privilege, $this->move_privilege, $this->delete_privilege);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$contact_to_folder_id = $db->insertId;
		$db->free_result();

		return $contact_to_folder_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * ContactToFile.
 *
 * @category   Framework
 * @package    ContactToFile
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactToFile extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactToFile';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contacts_to_files';

	/**
	 * primary key (`contact_id`,`file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'contact_id' => 'int',
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
		'unique_contact_to_file_via_primary_key' => array(
			'contact_id' => 'int',
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
		'contact_id' => 'contact_id',
		'file_manager_file_id' => 'file_manager_file_id',

		'grant_privileges_privilege' => 'grant_privileges_privilege',
		'rename_privilege' => 'rename_privilege',
		'move_privilege' => 'move_privilege',
		'delete_privilege' => 'delete_privilege'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_id;
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
	protected static $_arrContactsToFilesByContactId;
	protected static $_arrContactsToFilesByFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactsToFiles;

	// Foreign Key Objects
	private $_contact;
	private $_fileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contacts_to_files')
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
	public static function getArrContactsToFilesByContactId()
	{
		if (isset(self::$_arrContactsToFilesByContactId)) {
			return self::$_arrContactsToFilesByContactId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToFilesByContactId($arrContactsToFilesByContactId)
	{
		self::$_arrContactsToFilesByContactId = $arrContactsToFilesByContactId;
	}

	public static function getArrContactsToFilesByFileManagerFileId()
	{
		if (isset(self::$_arrContactsToFilesByFileManagerFileId)) {
			return self::$_arrContactsToFilesByFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToFilesByFileManagerFileId($arrContactsToFilesByFileManagerFileId)
	{
		self::$_arrContactsToFilesByFileManagerFileId = $arrContactsToFilesByFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactsToFiles()
	{
		if (isset(self::$_arrAllContactsToFiles)) {
			return self::$_arrAllContactsToFiles;
		} else {
			return null;
		}
	}

	public static function setArrAllContactsToFiles($arrAllContactsToFiles)
	{
		self::$_arrAllContactsToFiles = $arrAllContactsToFiles;
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
	 * Find by primary key (`contact_id`,`file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndFileManagerFileId($database, $contact_id, $file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	c2files.*

FROM `contacts_to_files` c2files
WHERE c2files.`contact_id` = ?
AND c2files.`file_manager_file_id` = ?
";
		$arrValues = array($contact_id, $file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToFile = self::instantiateOrm($database, 'ContactToFile', $row);
			/* @var $contactToFile ContactToFile */
			return $contactToFile;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`contact_id`,`file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndFileManagerFileIdExtended($database, $contact_id, $file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	c2files_fk_c.`id` AS 'c2files_fk_c__contact_id',
	c2files_fk_c.`user_company_id` AS 'c2files_fk_c__user_company_id',
	c2files_fk_c.`user_id` AS 'c2files_fk_c__user_id',
	c2files_fk_c.`contact_company_id` AS 'c2files_fk_c__contact_company_id',
	c2files_fk_c.`email` AS 'c2files_fk_c__email',
	c2files_fk_c.`name_prefix` AS 'c2files_fk_c__name_prefix',
	c2files_fk_c.`first_name` AS 'c2files_fk_c__first_name',
	c2files_fk_c.`additional_name` AS 'c2files_fk_c__additional_name',
	c2files_fk_c.`middle_name` AS 'c2files_fk_c__middle_name',
	c2files_fk_c.`last_name` AS 'c2files_fk_c__last_name',
	c2files_fk_c.`name_suffix` AS 'c2files_fk_c__name_suffix',
	c2files_fk_c.`title` AS 'c2files_fk_c__title',
	c2files_fk_c.`vendor_flag` AS 'c2files_fk_c__vendor_flag',

	c2files_fk_fmfiles.`id` AS 'c2files_fk_fmfiles__file_manager_file_id',
	c2files_fk_fmfiles.`user_company_id` AS 'c2files_fk_fmfiles__user_company_id',
	c2files_fk_fmfiles.`contact_id` AS 'c2files_fk_fmfiles__contact_id',
	c2files_fk_fmfiles.`project_id` AS 'c2files_fk_fmfiles__project_id',
	c2files_fk_fmfiles.`file_manager_folder_id` AS 'c2files_fk_fmfiles__file_manager_folder_id',
	c2files_fk_fmfiles.`file_location_id` AS 'c2files_fk_fmfiles__file_location_id',
	c2files_fk_fmfiles.`virtual_file_name` AS 'c2files_fk_fmfiles__virtual_file_name',
	c2files_fk_fmfiles.`version_number` AS 'c2files_fk_fmfiles__version_number',
	c2files_fk_fmfiles.`virtual_file_name_sha1` AS 'c2files_fk_fmfiles__virtual_file_name_sha1',
	c2files_fk_fmfiles.`virtual_file_mime_type` AS 'c2files_fk_fmfiles__virtual_file_mime_type',
	c2files_fk_fmfiles.`modified` AS 'c2files_fk_fmfiles__modified',
	c2files_fk_fmfiles.`created` AS 'c2files_fk_fmfiles__created',
	c2files_fk_fmfiles.`deleted_flag` AS 'c2files_fk_fmfiles__deleted_flag',
	c2files_fk_fmfiles.`directly_deleted_flag` AS 'c2files_fk_fmfiles__directly_deleted_flag',

	c2files.*

FROM `contacts_to_files` c2files
	INNER JOIN `contacts` c2files_fk_c ON c2files.`contact_id` = c2files_fk_c.`id`
	INNER JOIN `file_manager_files` c2files_fk_fmfiles ON c2files.`file_manager_file_id` = c2files_fk_fmfiles.`id`
WHERE c2files.`contact_id` = ?
AND c2files.`file_manager_file_id` = ?
";
		$arrValues = array($contact_id, $file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToFile = self::instantiateOrm($database, 'ContactToFile', $row);
			/* @var $contactToFile ContactToFile */
			$contactToFile->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['c2files_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'c2files_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$contactToFile->setContact($contact);

			if (isset($row['file_manager_file_id'])) {
				$file_manager_file_id = $row['file_manager_file_id'];
				$row['c2files_fk_fmfiles__id'] = $file_manager_file_id;
				$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id, 'c2files_fk_fmfiles__');
				/* @var $fileManagerFile FileManagerFile */
				$fileManagerFile->convertPropertiesToData();
			} else {
				$fileManagerFile = false;
			}
			$contactToFile->setFileManagerFile($fileManagerFile);

			return $contactToFile;
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
	 * @param array $arrContactIdAndFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToFilesByArrContactIdAndFileManagerFileIdList($database, $arrContactIdAndFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrContactIdAndFileManagerFileIdList)) {
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
		// ORDER BY `contact_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToFile = new ContactToFile($database);
			$sqlOrderByColumns = $tmpContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrContactIdAndFileManagerFileIdList as $k => $arrTmp) {
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
		if (count($arrContactIdAndFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	c2files.*

FROM `contacts_to_files` c2files
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToFilesByArrContactIdAndFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$contactToFile = self::instantiateOrm($database, 'ContactToFile', $row);
			/* @var $contactToFile ContactToFile */
			$arrContactsToFilesByArrContactIdAndFileManagerFileIdList[] = $contactToFile;
		}

		$db->free_result();

		return $arrContactsToFilesByArrContactIdAndFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_to_files_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToFilesByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrContactsToFilesByContactId = null;
		}

		$arrContactsToFilesByContactId = self::$_arrContactsToFilesByContactId;
		if (isset($arrContactsToFilesByContactId) && !empty($arrContactsToFilesByContactId)) {
			return $arrContactsToFilesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToFile = new ContactToFile($database);
			$sqlOrderByColumns = $tmpContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2files.*

FROM `contacts_to_files` c2files
WHERE c2files.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToFilesByContactId = array();
		while ($row = $db->fetch()) {
			$contactToFile = self::instantiateOrm($database, 'ContactToFile', $row);
			/* @var $contactToFile ContactToFile */
			$arrContactsToFilesByContactId[] = $contactToFile;
		}

		$db->free_result();

		self::$_arrContactsToFilesByContactId = $arrContactsToFilesByContactId;

		return $arrContactsToFilesByContactId;
	}

	/**
	 * Load by constraint `contacts_to_files_fk_fmfiles` foreign key (`file_manager_file_id`) references `file_manager_files` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToFilesByFileManagerFileId($database, $file_manager_file_id, Input $options=null)
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
			self::$_arrContactsToFilesByFileManagerFileId = null;
		}

		$arrContactsToFilesByFileManagerFileId = self::$_arrContactsToFilesByFileManagerFileId;
		if (isset($arrContactsToFilesByFileManagerFileId) && !empty($arrContactsToFilesByFileManagerFileId)) {
			return $arrContactsToFilesByFileManagerFileId;
		}

		$file_manager_file_id = (int) $file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToFile = new ContactToFile($database);
			$sqlOrderByColumns = $tmpContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2files.*

FROM `contacts_to_files` c2files
WHERE c2files.`file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToFilesByFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$contactToFile = self::instantiateOrm($database, 'ContactToFile', $row);
			/* @var $contactToFile ContactToFile */
			$arrContactsToFilesByFileManagerFileId[] = $contactToFile;
		}

		$db->free_result();

		self::$_arrContactsToFilesByFileManagerFileId = $arrContactsToFilesByFileManagerFileId;

		return $arrContactsToFilesByFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contacts_to_files records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactsToFiles($database, Input $options=null)
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
			self::$_arrAllContactsToFiles = null;
		}

		$arrAllContactsToFiles = self::$_arrAllContactsToFiles;
		if (isset($arrAllContactsToFiles) && !empty($arrAllContactsToFiles)) {
			return $arrAllContactsToFiles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToFile = new ContactToFile($database);
			$sqlOrderByColumns = $tmpContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2files.*

FROM `contacts_to_files` c2files{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `file_manager_file_id` ASC, `grant_privileges_privilege` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactsToFiles = array();
		while ($row = $db->fetch()) {
			$contactToFile = self::instantiateOrm($database, 'ContactToFile', $row);
			/* @var $contactToFile ContactToFile */
			$arrAllContactsToFiles[] = $contactToFile;
		}

		$db->free_result();

		self::$_arrAllContactsToFiles = $arrAllContactsToFiles;

		return $arrAllContactsToFiles;
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
INTO `contacts_to_files`
(`contact_id`, `file_manager_file_id`, `grant_privileges_privilege`, `rename_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `grant_privileges_privilege` = ?, `rename_privilege` = ?, `move_privilege` = ?, `delete_privilege` = ?
";
		$arrValues = array($this->contact_id, $this->file_manager_file_id, $this->grant_privileges_privilege, $this->rename_privilege, $this->move_privilege, $this->delete_privilege, $this->grant_privileges_privilege, $this->rename_privilege, $this->move_privilege, $this->delete_privilege);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$contact_to_file_id = $db->insertId;
		$db->free_result();

		return $contact_to_file_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

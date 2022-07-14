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
 * ProjectToContactToFile.
 *
 * @category   Framework
 * @package    ProjectToContactToFile
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ProjectToContactToFile extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ProjectToContactToFile';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'projects_to_contacts_to_files';

	/**
	 * primary key (`project_id`,`contact_id`,`file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'project_id' => 'int',
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
		'unique_project_to_contact_to_file_via_primary_key' => array(
			'project_id' => 'int',
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
		'project_id' => 'project_id',
		'contact_id' => 'contact_id',
		'file_manager_file_id' => 'file_manager_file_id',

		'rename_privilege' => 'rename_privilege',
		'move_privilege' => 'move_privilege',
		'delete_privilege' => 'delete_privilege'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_id;
	public $contact_id;
	public $file_manager_file_id;

	public $rename_privilege;
	public $move_privilege;
	public $delete_privilege;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrProjectsToContactsToFilesByProjectId;
	protected static $_arrProjectsToContactsToFilesByContactId;
	protected static $_arrProjectsToContactsToFilesByFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjectsToContactsToFiles;

	// Foreign Key Objects
	private $_project;
	private $_contact;
	private $_fileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='projects_to_contacts_to_files')
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
	public static function getArrProjectsToContactsToFilesByProjectId()
	{
		if (isset(self::$_arrProjectsToContactsToFilesByProjectId)) {
			return self::$_arrProjectsToContactsToFilesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToFilesByProjectId($arrProjectsToContactsToFilesByProjectId)
	{
		self::$_arrProjectsToContactsToFilesByProjectId = $arrProjectsToContactsToFilesByProjectId;
	}

	public static function getArrProjectsToContactsToFilesByContactId()
	{
		if (isset(self::$_arrProjectsToContactsToFilesByContactId)) {
			return self::$_arrProjectsToContactsToFilesByContactId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToFilesByContactId($arrProjectsToContactsToFilesByContactId)
	{
		self::$_arrProjectsToContactsToFilesByContactId = $arrProjectsToContactsToFilesByContactId;
	}

	public static function getArrProjectsToContactsToFilesByFileManagerFileId()
	{
		if (isset(self::$_arrProjectsToContactsToFilesByFileManagerFileId)) {
			return self::$_arrProjectsToContactsToFilesByFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToFilesByFileManagerFileId($arrProjectsToContactsToFilesByFileManagerFileId)
	{
		self::$_arrProjectsToContactsToFilesByFileManagerFileId = $arrProjectsToContactsToFilesByFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllProjectsToContactsToFiles()
	{
		if (isset(self::$_arrAllProjectsToContactsToFiles)) {
			return self::$_arrAllProjectsToContactsToFiles;
		} else {
			return null;
		}
	}

	public static function setArrAllProjectsToContactsToFiles($arrAllProjectsToContactsToFiles)
	{
		self::$_arrAllProjectsToContactsToFiles = $arrAllProjectsToContactsToFiles;
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
	 * Find by primary key (`project_id`,`contact_id`,`file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndContactIdAndFileManagerFileId($database, $project_id, $contact_id, $file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	p2c2files.*

FROM `projects_to_contacts_to_files` p2c2files
WHERE p2c2files.`project_id` = ?
AND p2c2files.`contact_id` = ?
AND p2c2files.`file_manager_file_id` = ?
";
		$arrValues = array($project_id, $contact_id, $file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToContactToFile = self::instantiateOrm($database, 'ProjectToContactToFile', $row);
			/* @var $projectToContactToFile ProjectToContactToFile */
			return $projectToContactToFile;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`project_id`,`contact_id`,`file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndContactIdAndFileManagerFileIdExtended($database, $project_id, $contact_id, $file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	p2c2files_fk_p.`id` AS 'p2c2files_fk_p__project_id',
	p2c2files_fk_p.`project_type_id` AS 'p2c2files_fk_p__project_type_id',
	p2c2files_fk_p.`user_company_id` AS 'p2c2files_fk_p__user_company_id',
	p2c2files_fk_p.`user_custom_project_id` AS 'p2c2files_fk_p__user_custom_project_id',
	p2c2files_fk_p.`project_name` AS 'p2c2files_fk_p__project_name',
	p2c2files_fk_p.`project_owner_name` AS 'p2c2files_fk_p__project_owner_name',
	p2c2files_fk_p.`latitude` AS 'p2c2files_fk_p__latitude',
	p2c2files_fk_p.`longitude` AS 'p2c2files_fk_p__longitude',
	p2c2files_fk_p.`address_line_1` AS 'p2c2files_fk_p__address_line_1',
	p2c2files_fk_p.`address_line_2` AS 'p2c2files_fk_p__address_line_2',
	p2c2files_fk_p.`address_line_3` AS 'p2c2files_fk_p__address_line_3',
	p2c2files_fk_p.`address_line_4` AS 'p2c2files_fk_p__address_line_4',
	p2c2files_fk_p.`address_city` AS 'p2c2files_fk_p__address_city',
	p2c2files_fk_p.`address_county` AS 'p2c2files_fk_p__address_county',
	p2c2files_fk_p.`address_state_or_region` AS 'p2c2files_fk_p__address_state_or_region',
	p2c2files_fk_p.`address_postal_code` AS 'p2c2files_fk_p__address_postal_code',
	p2c2files_fk_p.`address_postal_code_extension` AS 'p2c2files_fk_p__address_postal_code_extension',
	p2c2files_fk_p.`address_country` AS 'p2c2files_fk_p__address_country',
	p2c2files_fk_p.`building_count` AS 'p2c2files_fk_p__building_count',
	p2c2files_fk_p.`unit_count` AS 'p2c2files_fk_p__unit_count',
	p2c2files_fk_p.`gross_square_footage` AS 'p2c2files_fk_p__gross_square_footage',
	p2c2files_fk_p.`net_rentable_square_footage` AS 'p2c2files_fk_p__net_rentable_square_footage',
	p2c2files_fk_p.`is_active_flag` AS 'p2c2files_fk_p__is_active_flag',
	p2c2files_fk_p.`public_plans_flag` AS 'p2c2files_fk_p__public_plans_flag',
	p2c2files_fk_p.`prevailing_wage_flag` AS 'p2c2files_fk_p__prevailing_wage_flag',
	p2c2files_fk_p.`city_business_license_required_flag` AS 'p2c2files_fk_p__city_business_license_required_flag',
	p2c2files_fk_p.`is_internal_flag` AS 'p2c2files_fk_p__is_internal_flag',
	p2c2files_fk_p.`project_contract_date` AS 'p2c2files_fk_p__project_contract_date',
	p2c2files_fk_p.`project_start_date` AS 'p2c2files_fk_p__project_start_date',
	p2c2files_fk_p.`project_completed_date` AS 'p2c2files_fk_p__project_completed_date',
	p2c2files_fk_p.`sort_order` AS 'p2c2files_fk_p__sort_order',

	p2c2files_fk_c.`id` AS 'p2c2files_fk_c__contact_id',
	p2c2files_fk_c.`user_company_id` AS 'p2c2files_fk_c__user_company_id',
	p2c2files_fk_c.`user_id` AS 'p2c2files_fk_c__user_id',
	p2c2files_fk_c.`contact_company_id` AS 'p2c2files_fk_c__contact_company_id',
	p2c2files_fk_c.`email` AS 'p2c2files_fk_c__email',
	p2c2files_fk_c.`name_prefix` AS 'p2c2files_fk_c__name_prefix',
	p2c2files_fk_c.`first_name` AS 'p2c2files_fk_c__first_name',
	p2c2files_fk_c.`additional_name` AS 'p2c2files_fk_c__additional_name',
	p2c2files_fk_c.`middle_name` AS 'p2c2files_fk_c__middle_name',
	p2c2files_fk_c.`last_name` AS 'p2c2files_fk_c__last_name',
	p2c2files_fk_c.`name_suffix` AS 'p2c2files_fk_c__name_suffix',
	p2c2files_fk_c.`title` AS 'p2c2files_fk_c__title',
	p2c2files_fk_c.`vendor_flag` AS 'p2c2files_fk_c__vendor_flag',

	p2c2files_fk_fmfiles.`id` AS 'p2c2files_fk_fmfiles__file_manager_file_id',
	p2c2files_fk_fmfiles.`user_company_id` AS 'p2c2files_fk_fmfiles__user_company_id',
	p2c2files_fk_fmfiles.`contact_id` AS 'p2c2files_fk_fmfiles__contact_id',
	p2c2files_fk_fmfiles.`project_id` AS 'p2c2files_fk_fmfiles__project_id',
	p2c2files_fk_fmfiles.`file_manager_folder_id` AS 'p2c2files_fk_fmfiles__file_manager_folder_id',
	p2c2files_fk_fmfiles.`file_location_id` AS 'p2c2files_fk_fmfiles__file_location_id',
	p2c2files_fk_fmfiles.`virtual_file_name` AS 'p2c2files_fk_fmfiles__virtual_file_name',
	p2c2files_fk_fmfiles.`version_number` AS 'p2c2files_fk_fmfiles__version_number',
	p2c2files_fk_fmfiles.`virtual_file_name_sha1` AS 'p2c2files_fk_fmfiles__virtual_file_name_sha1',
	p2c2files_fk_fmfiles.`virtual_file_mime_type` AS 'p2c2files_fk_fmfiles__virtual_file_mime_type',
	p2c2files_fk_fmfiles.`modified` AS 'p2c2files_fk_fmfiles__modified',
	p2c2files_fk_fmfiles.`created` AS 'p2c2files_fk_fmfiles__created',
	p2c2files_fk_fmfiles.`deleted_flag` AS 'p2c2files_fk_fmfiles__deleted_flag',
	p2c2files_fk_fmfiles.`directly_deleted_flag` AS 'p2c2files_fk_fmfiles__directly_deleted_flag',

	p2c2files.*

FROM `projects_to_contacts_to_files` p2c2files
	INNER JOIN `projects` p2c2files_fk_p ON p2c2files.`project_id` = p2c2files_fk_p.`id`
	INNER JOIN `contacts` p2c2files_fk_c ON p2c2files.`contact_id` = p2c2files_fk_c.`id`
	INNER JOIN `file_manager_files` p2c2files_fk_fmfiles ON p2c2files.`file_manager_file_id` = p2c2files_fk_fmfiles.`id`
WHERE p2c2files.`project_id` = ?
AND p2c2files.`contact_id` = ?
AND p2c2files.`file_manager_file_id` = ?
";
		$arrValues = array($project_id, $contact_id, $file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToContactToFile = self::instantiateOrm($database, 'ProjectToContactToFile', $row);
			/* @var $projectToContactToFile ProjectToContactToFile */
			$projectToContactToFile->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['p2c2files_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'p2c2files_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectToContactToFile->setProject($project);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['p2c2files_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'p2c2files_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$projectToContactToFile->setContact($contact);

			if (isset($row['file_manager_file_id'])) {
				$file_manager_file_id = $row['file_manager_file_id'];
				$row['p2c2files_fk_fmfiles__id'] = $file_manager_file_id;
				$fileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $file_manager_file_id, 'p2c2files_fk_fmfiles__');
				/* @var $fileManagerFile FileManagerFile */
				$fileManagerFile->convertPropertiesToData();
			} else {
				$fileManagerFile = false;
			}
			$projectToContactToFile->setFileManagerFile($fileManagerFile);

			return $projectToContactToFile;
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
	 * @param array $arrProjectIdAndContactIdAndFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToFilesByArrProjectIdAndContactIdAndFileManagerFileIdList($database, $arrProjectIdAndContactIdAndFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrProjectIdAndContactIdAndFileManagerFileIdList)) {
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
		// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToFile = new ProjectToContactToFile($database);
			$sqlOrderByColumns = $tmpProjectToContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrProjectIdAndContactIdAndFileManagerFileIdList as $k => $arrTmp) {
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
		if (count($arrProjectIdAndContactIdAndFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	p2c2files.*

FROM `projects_to_contacts_to_files` p2c2files
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToFilesByArrProjectIdAndContactIdAndFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$projectToContactToFile = self::instantiateOrm($database, 'ProjectToContactToFile', $row);
			/* @var $projectToContactToFile ProjectToContactToFile */
			$arrProjectsToContactsToFilesByArrProjectIdAndContactIdAndFileManagerFileIdList[] = $projectToContactToFile;
		}

		$db->free_result();

		return $arrProjectsToContactsToFilesByArrProjectIdAndContactIdAndFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `projects_to_contacts_to_files_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToFilesByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrProjectsToContactsToFilesByProjectId = null;
		}

		$arrProjectsToContactsToFilesByProjectId = self::$_arrProjectsToContactsToFilesByProjectId;
		if (isset($arrProjectsToContactsToFilesByProjectId) && !empty($arrProjectsToContactsToFilesByProjectId)) {
			return $arrProjectsToContactsToFilesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToFile = new ProjectToContactToFile($database);
			$sqlOrderByColumns = $tmpProjectToContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2files.*

FROM `projects_to_contacts_to_files` p2c2files
WHERE p2c2files.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToFilesByProjectId = array();
		while ($row = $db->fetch()) {
			$projectToContactToFile = self::instantiateOrm($database, 'ProjectToContactToFile', $row);
			/* @var $projectToContactToFile ProjectToContactToFile */
			$arrProjectsToContactsToFilesByProjectId[] = $projectToContactToFile;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToFilesByProjectId = $arrProjectsToContactsToFilesByProjectId;

		return $arrProjectsToContactsToFilesByProjectId;
	}

	/**
	 * Load by constraint `projects_to_contacts_to_files_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToFilesByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrProjectsToContactsToFilesByContactId = null;
		}

		$arrProjectsToContactsToFilesByContactId = self::$_arrProjectsToContactsToFilesByContactId;
		if (isset($arrProjectsToContactsToFilesByContactId) && !empty($arrProjectsToContactsToFilesByContactId)) {
			return $arrProjectsToContactsToFilesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToFile = new ProjectToContactToFile($database);
			$sqlOrderByColumns = $tmpProjectToContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2files.*

FROM `projects_to_contacts_to_files` p2c2files
WHERE p2c2files.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToFilesByContactId = array();
		while ($row = $db->fetch()) {
			$projectToContactToFile = self::instantiateOrm($database, 'ProjectToContactToFile', $row);
			/* @var $projectToContactToFile ProjectToContactToFile */
			$arrProjectsToContactsToFilesByContactId[] = $projectToContactToFile;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToFilesByContactId = $arrProjectsToContactsToFilesByContactId;

		return $arrProjectsToContactsToFilesByContactId;
	}

	/**
	 * Load by constraint `projects_to_contacts_to_files_fk_fmfiles` foreign key (`file_manager_file_id`) references `file_manager_files` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToFilesByFileManagerFileId($database, $file_manager_file_id, Input $options=null)
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
			self::$_arrProjectsToContactsToFilesByFileManagerFileId = null;
		}

		$arrProjectsToContactsToFilesByFileManagerFileId = self::$_arrProjectsToContactsToFilesByFileManagerFileId;
		if (isset($arrProjectsToContactsToFilesByFileManagerFileId) && !empty($arrProjectsToContactsToFilesByFileManagerFileId)) {
			return $arrProjectsToContactsToFilesByFileManagerFileId;
		}

		$file_manager_file_id = (int) $file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToFile = new ProjectToContactToFile($database);
			$sqlOrderByColumns = $tmpProjectToContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2files.*

FROM `projects_to_contacts_to_files` p2c2files
WHERE p2c2files.`file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$arrValues = array($file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToFilesByFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$projectToContactToFile = self::instantiateOrm($database, 'ProjectToContactToFile', $row);
			/* @var $projectToContactToFile ProjectToContactToFile */
			$arrProjectsToContactsToFilesByFileManagerFileId[] = $projectToContactToFile;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToFilesByFileManagerFileId = $arrProjectsToContactsToFilesByFileManagerFileId;

		return $arrProjectsToContactsToFilesByFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all projects_to_contacts_to_files records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllProjectsToContactsToFiles($database, Input $options=null)
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
			self::$_arrAllProjectsToContactsToFiles = null;
		}

		$arrAllProjectsToContactsToFiles = self::$_arrAllProjectsToContactsToFiles;
		if (isset($arrAllProjectsToContactsToFiles) && !empty($arrAllProjectsToContactsToFiles)) {
			return $arrAllProjectsToContactsToFiles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToFile = new ProjectToContactToFile($database);
			$sqlOrderByColumns = $tmpProjectToContactToFile->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2files.*

FROM `projects_to_contacts_to_files` p2c2files{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `file_manager_file_id` ASC, `rename_privilege` ASC, `move_privilege` ASC, `delete_privilege` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjectsToContactsToFiles = array();
		while ($row = $db->fetch()) {
			$projectToContactToFile = self::instantiateOrm($database, 'ProjectToContactToFile', $row);
			/* @var $projectToContactToFile ProjectToContactToFile */
			$arrAllProjectsToContactsToFiles[] = $projectToContactToFile;
		}

		$db->free_result();

		self::$_arrAllProjectsToContactsToFiles = $arrAllProjectsToContactsToFiles;

		return $arrAllProjectsToContactsToFiles;
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
INTO `projects_to_contacts_to_files`
(`project_id`, `contact_id`, `file_manager_file_id`, `rename_privilege`, `move_privilege`, `delete_privilege`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `rename_privilege` = ?, `move_privilege` = ?, `delete_privilege` = ?
";
		$arrValues = array($this->project_id, $this->contact_id, $this->file_manager_file_id, $this->rename_privilege, $this->move_privilege, $this->delete_privilege, $this->rename_privilege, $this->move_privilege, $this->delete_privilege);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$project_to_contact_to_file_id = $db->insertId;
		$db->free_result();

		return $project_to_contact_to_file_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * ProjectBidInvitation.
 *
 * @category   Framework
 * @package    ProjectBidInvitation
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ProjectBidInvitation extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ProjectBidInvitation';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'project_bid_invitations';

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
	 * unique index `unique_project_bid_invitation` (`project_id`,`project_bid_invitation_sequence_number`)
	 * unique index `unique_project_bid_invitation_by_file` (`project_id`,`project_bid_invitation_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_project_bid_invitation' => array(
			'project_id' => 'int',
			'project_bid_invitation_sequence_number' => 'int'
		),
		'unique_project_bid_invitation_by_file' => array(
			'project_id' => 'int',
			'project_bid_invitation_file_manager_file_id' => 'int'
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
		'id' => 'project_bid_invitation_id',

		'project_id' => 'project_id',
		'project_bid_invitation_sequence_number' => 'project_bid_invitation_sequence_number',
		'project_bid_invitation_file_manager_file_id' => 'project_bid_invitation_file_manager_file_id',

		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_bid_invitation_id;

	public $project_id;
	public $project_bid_invitation_sequence_number;
	public $project_bid_invitation_file_manager_file_id;

	public $created;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrProjectBidInvitationsByProjectId;
	protected static $_arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjectBidInvitations;

	// Foreign Key Objects
	private $_project;
	private $_projectBidInvitationFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='project_bid_invitations')
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

	public function getProjectBidInvitationFileManagerFile()
	{
		if (isset($this->_projectBidInvitationFileManagerFile)) {
			return $this->_projectBidInvitationFileManagerFile;
		} else {
			return null;
		}
	}

	public function setProjectBidInvitationFileManagerFile($projectBidInvitationFileManagerFile)
	{
		$this->_projectBidInvitationFileManagerFile = $projectBidInvitationFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrProjectBidInvitationsByProjectId()
	{
		if (isset(self::$_arrProjectBidInvitationsByProjectId)) {
			return self::$_arrProjectBidInvitationsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrProjectBidInvitationsByProjectId($arrProjectBidInvitationsByProjectId)
	{
		self::$_arrProjectBidInvitationsByProjectId = $arrProjectBidInvitationsByProjectId;
	}

	public static function getArrProjectBidInvitationsByProjectBidInvitationFileManagerFileId()
	{
		if (isset(self::$_arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId)) {
			return self::$_arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrProjectBidInvitationsByProjectBidInvitationFileManagerFileId($arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId)
	{
		self::$_arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId = $arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllProjectBidInvitations()
	{
		if (isset(self::$_arrAllProjectBidInvitations)) {
			return self::$_arrAllProjectBidInvitations;
		} else {
			return null;
		}
	}

	public static function setArrAllProjectBidInvitations($arrAllProjectBidInvitations)
	{
		self::$_arrAllProjectBidInvitations = $arrAllProjectBidInvitations;
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
	 * @param int $project_bid_invitation_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $project_bid_invitation_id,$table='project_bid_invitations', $module='ProjectBidInvitation')
	{
		$projectBidInvitation = parent::findById($database, $project_bid_invitation_id, $table, $module);

		return $projectBidInvitation;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $project_bid_invitation_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findProjectBidInvitationByIdExtended($database, $project_bid_invitation_id)
	{
		$project_bid_invitation_id = (int) $project_bid_invitation_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	pbi_fk_p.`id` AS 'pbi_fk_p__project_id',
	pbi_fk_p.`project_type_id` AS 'pbi_fk_p__project_type_id',
	pbi_fk_p.`user_company_id` AS 'pbi_fk_p__user_company_id',
	pbi_fk_p.`user_custom_project_id` AS 'pbi_fk_p__user_custom_project_id',
	pbi_fk_p.`project_name` AS 'pbi_fk_p__project_name',
	pbi_fk_p.`project_owner_name` AS 'pbi_fk_p__project_owner_name',
	pbi_fk_p.`latitude` AS 'pbi_fk_p__latitude',
	pbi_fk_p.`longitude` AS 'pbi_fk_p__longitude',
	pbi_fk_p.`address_line_1` AS 'pbi_fk_p__address_line_1',
	pbi_fk_p.`address_line_2` AS 'pbi_fk_p__address_line_2',
	pbi_fk_p.`address_line_3` AS 'pbi_fk_p__address_line_3',
	pbi_fk_p.`address_line_4` AS 'pbi_fk_p__address_line_4',
	pbi_fk_p.`address_city` AS 'pbi_fk_p__address_city',
	pbi_fk_p.`address_county` AS 'pbi_fk_p__address_county',
	pbi_fk_p.`address_state_or_region` AS 'pbi_fk_p__address_state_or_region',
	pbi_fk_p.`address_postal_code` AS 'pbi_fk_p__address_postal_code',
	pbi_fk_p.`address_postal_code_extension` AS 'pbi_fk_p__address_postal_code_extension',
	pbi_fk_p.`address_country` AS 'pbi_fk_p__address_country',
	pbi_fk_p.`building_count` AS 'pbi_fk_p__building_count',
	pbi_fk_p.`unit_count` AS 'pbi_fk_p__unit_count',
	pbi_fk_p.`gross_square_footage` AS 'pbi_fk_p__gross_square_footage',
	pbi_fk_p.`net_rentable_square_footage` AS 'pbi_fk_p__net_rentable_square_footage',
	pbi_fk_p.`is_active_flag` AS 'pbi_fk_p__is_active_flag',
	pbi_fk_p.`public_plans_flag` AS 'pbi_fk_p__public_plans_flag',
	pbi_fk_p.`prevailing_wage_flag` AS 'pbi_fk_p__prevailing_wage_flag',
	pbi_fk_p.`city_business_license_required_flag` AS 'pbi_fk_p__city_business_license_required_flag',
	pbi_fk_p.`is_internal_flag` AS 'pbi_fk_p__is_internal_flag',
	pbi_fk_p.`project_contract_date` AS 'pbi_fk_p__project_contract_date',
	pbi_fk_p.`project_start_date` AS 'pbi_fk_p__project_start_date',
	pbi_fk_p.`project_completed_date` AS 'pbi_fk_p__project_completed_date',
	pbi_fk_p.`sort_order` AS 'pbi_fk_p__sort_order',

	pbi_fk_fmfiles.`id` AS 'pbi_fk_fmfiles__file_manager_file_id',
	pbi_fk_fmfiles.`user_company_id` AS 'pbi_fk_fmfiles__user_company_id',
	pbi_fk_fmfiles.`contact_id` AS 'pbi_fk_fmfiles__contact_id',
	pbi_fk_fmfiles.`project_id` AS 'pbi_fk_fmfiles__project_id',
	pbi_fk_fmfiles.`file_manager_folder_id` AS 'pbi_fk_fmfiles__file_manager_folder_id',
	pbi_fk_fmfiles.`file_location_id` AS 'pbi_fk_fmfiles__file_location_id',
	pbi_fk_fmfiles.`virtual_file_name` AS 'pbi_fk_fmfiles__virtual_file_name',
	pbi_fk_fmfiles.`version_number` AS 'pbi_fk_fmfiles__version_number',
	pbi_fk_fmfiles.`virtual_file_name_sha1` AS 'pbi_fk_fmfiles__virtual_file_name_sha1',
	pbi_fk_fmfiles.`virtual_file_mime_type` AS 'pbi_fk_fmfiles__virtual_file_mime_type',
	pbi_fk_fmfiles.`modified` AS 'pbi_fk_fmfiles__modified',
	pbi_fk_fmfiles.`created` AS 'pbi_fk_fmfiles__created',
	pbi_fk_fmfiles.`deleted_flag` AS 'pbi_fk_fmfiles__deleted_flag',
	pbi_fk_fmfiles.`directly_deleted_flag` AS 'pbi_fk_fmfiles__directly_deleted_flag',

	pbi.*

FROM `project_bid_invitations` pbi
	INNER JOIN `projects` pbi_fk_p ON pbi.`project_id` = pbi_fk_p.`id`
	INNER JOIN `file_manager_files` pbi_fk_fmfiles ON pbi.`project_bid_invitation_file_manager_file_id` = pbi_fk_fmfiles.`id`
WHERE pbi.`id` = ?
";
		$arrValues = array($project_bid_invitation_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$project_bid_invitation_id = $row['id'];
			$projectBidInvitation = self::instantiateOrm($database, 'ProjectBidInvitation', $row, null, $project_bid_invitation_id);
			/* @var $projectBidInvitation ProjectBidInvitation */
			$projectBidInvitation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['pbi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'pbi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectBidInvitation->setProject($project);

			if (isset($row['project_bid_invitation_file_manager_file_id'])) {
				$project_bid_invitation_file_manager_file_id = $row['project_bid_invitation_file_manager_file_id'];
				$row['pbi_fk_fmfiles__id'] = $project_bid_invitation_file_manager_file_id;
				$projectBidInvitationFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $project_bid_invitation_file_manager_file_id, 'pbi_fk_fmfiles__');
				/* @var $projectBidInvitationFileManagerFile FileManagerFile */
				$projectBidInvitationFileManagerFile->convertPropertiesToData();
			} else {
				$projectBidInvitationFileManagerFile = false;
			}
			$projectBidInvitation->setProjectBidInvitationFileManagerFile($projectBidInvitationFileManagerFile);

			return $projectBidInvitation;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_project_bid_invitation` (`project_id`,`project_bid_invitation_sequence_number`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $project_bid_invitation_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndProjectBidInvitationSequenceNumber($database, $project_id, $project_bid_invitation_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pbi.*

FROM `project_bid_invitations` pbi
WHERE pbi.`project_id` = ?
AND pbi.`project_bid_invitation_sequence_number` = ?
";
		$arrValues = array($project_id, $project_bid_invitation_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$project_bid_invitation_id = $row['id'];
			$projectBidInvitation = self::instantiateOrm($database, 'ProjectBidInvitation', $row, null, $project_bid_invitation_id);
			/* @var $projectBidInvitation ProjectBidInvitation */
			return $projectBidInvitation;
		} else {
			return false;
		}
	}

	/**
	 * Find by unique index `unique_project_bid_invitation_by_file` (`project_id`,`project_bid_invitation_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $project_bid_invitation_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndProjectBidInvitationFileManagerFileId($database, $project_id, $project_bid_invitation_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pbi.*

FROM `project_bid_invitations` pbi
WHERE pbi.`project_id` = ?
AND pbi.`project_bid_invitation_file_manager_file_id` = ?
";
		$arrValues = array($project_id, $project_bid_invitation_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$project_bid_invitation_id = $row['id'];
			$projectBidInvitation = self::instantiateOrm($database, 'ProjectBidInvitation', $row, null, $project_bid_invitation_id);
			/* @var $projectBidInvitation ProjectBidInvitation */
			return $projectBidInvitation;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrProjectBidInvitationIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectBidInvitationsByArrProjectBidInvitationIds($database, $arrProjectBidInvitationIds, Input $options=null)
	{
		if (empty($arrProjectBidInvitationIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectBidInvitation = new ProjectBidInvitation($database);
			$sqlOrderByColumns = $tmpProjectBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrProjectBidInvitationIds as $k => $project_bid_invitation_id) {
			$project_bid_invitation_id = (int) $project_bid_invitation_id;
			$arrProjectBidInvitationIds[$k] = $db->escape($project_bid_invitation_id);
		}
		$csvProjectBidInvitationIds = join(',', $arrProjectBidInvitationIds);

		$query =
"
SELECT

	pbi_fk_p.`id` AS 'pbi_fk_p__project_id',
	pbi_fk_p.`project_type_id` AS 'pbi_fk_p__project_type_id',
	pbi_fk_p.`user_company_id` AS 'pbi_fk_p__user_company_id',
	pbi_fk_p.`user_custom_project_id` AS 'pbi_fk_p__user_custom_project_id',
	pbi_fk_p.`project_name` AS 'pbi_fk_p__project_name',
	pbi_fk_p.`project_owner_name` AS 'pbi_fk_p__project_owner_name',
	pbi_fk_p.`latitude` AS 'pbi_fk_p__latitude',
	pbi_fk_p.`longitude` AS 'pbi_fk_p__longitude',
	pbi_fk_p.`address_line_1` AS 'pbi_fk_p__address_line_1',
	pbi_fk_p.`address_line_2` AS 'pbi_fk_p__address_line_2',
	pbi_fk_p.`address_line_3` AS 'pbi_fk_p__address_line_3',
	pbi_fk_p.`address_line_4` AS 'pbi_fk_p__address_line_4',
	pbi_fk_p.`address_city` AS 'pbi_fk_p__address_city',
	pbi_fk_p.`address_county` AS 'pbi_fk_p__address_county',
	pbi_fk_p.`address_state_or_region` AS 'pbi_fk_p__address_state_or_region',
	pbi_fk_p.`address_postal_code` AS 'pbi_fk_p__address_postal_code',
	pbi_fk_p.`address_postal_code_extension` AS 'pbi_fk_p__address_postal_code_extension',
	pbi_fk_p.`address_country` AS 'pbi_fk_p__address_country',
	pbi_fk_p.`building_count` AS 'pbi_fk_p__building_count',
	pbi_fk_p.`unit_count` AS 'pbi_fk_p__unit_count',
	pbi_fk_p.`gross_square_footage` AS 'pbi_fk_p__gross_square_footage',
	pbi_fk_p.`net_rentable_square_footage` AS 'pbi_fk_p__net_rentable_square_footage',
	pbi_fk_p.`is_active_flag` AS 'pbi_fk_p__is_active_flag',
	pbi_fk_p.`public_plans_flag` AS 'pbi_fk_p__public_plans_flag',
	pbi_fk_p.`prevailing_wage_flag` AS 'pbi_fk_p__prevailing_wage_flag',
	pbi_fk_p.`city_business_license_required_flag` AS 'pbi_fk_p__city_business_license_required_flag',
	pbi_fk_p.`is_internal_flag` AS 'pbi_fk_p__is_internal_flag',
	pbi_fk_p.`project_contract_date` AS 'pbi_fk_p__project_contract_date',
	pbi_fk_p.`project_start_date` AS 'pbi_fk_p__project_start_date',
	pbi_fk_p.`project_completed_date` AS 'pbi_fk_p__project_completed_date',
	pbi_fk_p.`sort_order` AS 'pbi_fk_p__sort_order',

	pbi_fk_fmfiles.`id` AS 'pbi_fk_fmfiles__file_manager_file_id',
	pbi_fk_fmfiles.`user_company_id` AS 'pbi_fk_fmfiles__user_company_id',
	pbi_fk_fmfiles.`contact_id` AS 'pbi_fk_fmfiles__contact_id',
	pbi_fk_fmfiles.`project_id` AS 'pbi_fk_fmfiles__project_id',
	pbi_fk_fmfiles.`file_manager_folder_id` AS 'pbi_fk_fmfiles__file_manager_folder_id',
	pbi_fk_fmfiles.`file_location_id` AS 'pbi_fk_fmfiles__file_location_id',
	pbi_fk_fmfiles.`virtual_file_name` AS 'pbi_fk_fmfiles__virtual_file_name',
	pbi_fk_fmfiles.`version_number` AS 'pbi_fk_fmfiles__version_number',
	pbi_fk_fmfiles.`virtual_file_name_sha1` AS 'pbi_fk_fmfiles__virtual_file_name_sha1',
	pbi_fk_fmfiles.`virtual_file_mime_type` AS 'pbi_fk_fmfiles__virtual_file_mime_type',
	pbi_fk_fmfiles.`modified` AS 'pbi_fk_fmfiles__modified',
	pbi_fk_fmfiles.`created` AS 'pbi_fk_fmfiles__created',
	pbi_fk_fmfiles.`deleted_flag` AS 'pbi_fk_fmfiles__deleted_flag',
	pbi_fk_fmfiles.`directly_deleted_flag` AS 'pbi_fk_fmfiles__directly_deleted_flag',

	pbi.*

FROM `project_bid_invitations` pbi
	INNER JOIN `projects` pbi_fk_p ON pbi.`project_id` = pbi_fk_p.`id`
	INNER JOIN `file_manager_files` pbi_fk_fmfiles ON pbi.`project_bid_invitation_file_manager_file_id` = pbi_fk_fmfiles.`id`
WHERE pbi.`id` IN ($csvProjectBidInvitationIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectBidInvitationsByCsvProjectBidInvitationIds = array();
		while ($row = $db->fetch()) {
			$project_bid_invitation_id = $row['id'];
			$projectBidInvitation = self::instantiateOrm($database, 'ProjectBidInvitation', $row, null, $project_bid_invitation_id);
			/* @var $projectBidInvitation ProjectBidInvitation */
			$projectBidInvitation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['pbi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'pbi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectBidInvitation->setProject($project);

			if (isset($row['project_bid_invitation_file_manager_file_id'])) {
				$project_bid_invitation_file_manager_file_id = $row['project_bid_invitation_file_manager_file_id'];
				$row['pbi_fk_fmfiles__id'] = $project_bid_invitation_file_manager_file_id;
				$projectBidInvitationFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $project_bid_invitation_file_manager_file_id, 'pbi_fk_fmfiles__');
				/* @var $projectBidInvitationFileManagerFile FileManagerFile */
				$projectBidInvitationFileManagerFile->convertPropertiesToData();
			} else {
				$projectBidInvitationFileManagerFile = false;
			}
			$projectBidInvitation->setProjectBidInvitationFileManagerFile($projectBidInvitationFileManagerFile);

			$arrProjectBidInvitationsByCsvProjectBidInvitationIds[$project_bid_invitation_id] = $projectBidInvitation;
		}

		$db->free_result();

		return $arrProjectBidInvitationsByCsvProjectBidInvitationIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `project_bid_invitations_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectBidInvitationsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrProjectBidInvitationsByProjectId = null;
		}

		$arrProjectBidInvitationsByProjectId = self::$_arrProjectBidInvitationsByProjectId;
		if (isset($arrProjectBidInvitationsByProjectId) && !empty($arrProjectBidInvitationsByProjectId)) {
			return $arrProjectBidInvitationsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectBidInvitation = new ProjectBidInvitation($database);
			$sqlOrderByColumns = $tmpProjectBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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

	pbi_fk_p.`id` AS 'pbi_fk_p__project_id',
	pbi_fk_p.`project_type_id` AS 'pbi_fk_p__project_type_id',
	pbi_fk_p.`user_company_id` AS 'pbi_fk_p__user_company_id',
	pbi_fk_p.`user_custom_project_id` AS 'pbi_fk_p__user_custom_project_id',
	pbi_fk_p.`project_name` AS 'pbi_fk_p__project_name',
	pbi_fk_p.`project_owner_name` AS 'pbi_fk_p__project_owner_name',
	pbi_fk_p.`latitude` AS 'pbi_fk_p__latitude',
	pbi_fk_p.`longitude` AS 'pbi_fk_p__longitude',
	pbi_fk_p.`address_line_1` AS 'pbi_fk_p__address_line_1',
	pbi_fk_p.`address_line_2` AS 'pbi_fk_p__address_line_2',
	pbi_fk_p.`address_line_3` AS 'pbi_fk_p__address_line_3',
	pbi_fk_p.`address_line_4` AS 'pbi_fk_p__address_line_4',
	pbi_fk_p.`address_city` AS 'pbi_fk_p__address_city',
	pbi_fk_p.`address_county` AS 'pbi_fk_p__address_county',
	pbi_fk_p.`address_state_or_region` AS 'pbi_fk_p__address_state_or_region',
	pbi_fk_p.`address_postal_code` AS 'pbi_fk_p__address_postal_code',
	pbi_fk_p.`address_postal_code_extension` AS 'pbi_fk_p__address_postal_code_extension',
	pbi_fk_p.`address_country` AS 'pbi_fk_p__address_country',
	pbi_fk_p.`building_count` AS 'pbi_fk_p__building_count',
	pbi_fk_p.`unit_count` AS 'pbi_fk_p__unit_count',
	pbi_fk_p.`gross_square_footage` AS 'pbi_fk_p__gross_square_footage',
	pbi_fk_p.`net_rentable_square_footage` AS 'pbi_fk_p__net_rentable_square_footage',
	pbi_fk_p.`is_active_flag` AS 'pbi_fk_p__is_active_flag',
	pbi_fk_p.`public_plans_flag` AS 'pbi_fk_p__public_plans_flag',
	pbi_fk_p.`prevailing_wage_flag` AS 'pbi_fk_p__prevailing_wage_flag',
	pbi_fk_p.`city_business_license_required_flag` AS 'pbi_fk_p__city_business_license_required_flag',
	pbi_fk_p.`is_internal_flag` AS 'pbi_fk_p__is_internal_flag',
	pbi_fk_p.`project_contract_date` AS 'pbi_fk_p__project_contract_date',
	pbi_fk_p.`project_start_date` AS 'pbi_fk_p__project_start_date',
	pbi_fk_p.`project_completed_date` AS 'pbi_fk_p__project_completed_date',
	pbi_fk_p.`sort_order` AS 'pbi_fk_p__sort_order',

	pbi_fk_fmfiles.`id` AS 'pbi_fk_fmfiles__file_manager_file_id',
	pbi_fk_fmfiles.`user_company_id` AS 'pbi_fk_fmfiles__user_company_id',
	pbi_fk_fmfiles.`contact_id` AS 'pbi_fk_fmfiles__contact_id',
	pbi_fk_fmfiles.`project_id` AS 'pbi_fk_fmfiles__project_id',
	pbi_fk_fmfiles.`file_manager_folder_id` AS 'pbi_fk_fmfiles__file_manager_folder_id',
	pbi_fk_fmfiles.`file_location_id` AS 'pbi_fk_fmfiles__file_location_id',
	pbi_fk_fmfiles.`virtual_file_name` AS 'pbi_fk_fmfiles__virtual_file_name',
	pbi_fk_fmfiles.`version_number` AS 'pbi_fk_fmfiles__version_number',
	pbi_fk_fmfiles.`virtual_file_name_sha1` AS 'pbi_fk_fmfiles__virtual_file_name_sha1',
	pbi_fk_fmfiles.`virtual_file_mime_type` AS 'pbi_fk_fmfiles__virtual_file_mime_type',
	pbi_fk_fmfiles.`modified` AS 'pbi_fk_fmfiles__modified',
	pbi_fk_fmfiles.`created` AS 'pbi_fk_fmfiles__created',
	pbi_fk_fmfiles.`deleted_flag` AS 'pbi_fk_fmfiles__deleted_flag',
	pbi_fk_fmfiles.`directly_deleted_flag` AS 'pbi_fk_fmfiles__directly_deleted_flag',

	pbi.*

FROM `project_bid_invitations` pbi
	INNER JOIN `projects` pbi_fk_p ON pbi.`project_id` = pbi_fk_p.`id`
	INNER JOIN `file_manager_files` pbi_fk_fmfiles ON pbi.`project_bid_invitation_file_manager_file_id` = pbi_fk_fmfiles.`id`
WHERE pbi.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectBidInvitationsByProjectId = array();
		while ($row = $db->fetch()) {
			$project_bid_invitation_id = $row['id'];
			$projectBidInvitation = self::instantiateOrm($database, 'ProjectBidInvitation', $row, null, $project_bid_invitation_id);
			/* @var $projectBidInvitation ProjectBidInvitation */
			$projectBidInvitation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['pbi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'pbi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectBidInvitation->setProject($project);

			if (isset($row['project_bid_invitation_file_manager_file_id'])) {
				$project_bid_invitation_file_manager_file_id = $row['project_bid_invitation_file_manager_file_id'];
				$row['pbi_fk_fmfiles__id'] = $project_bid_invitation_file_manager_file_id;
				$projectBidInvitationFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $project_bid_invitation_file_manager_file_id, 'pbi_fk_fmfiles__');
				/* @var $projectBidInvitationFileManagerFile FileManagerFile */
				$projectBidInvitationFileManagerFile->convertPropertiesToData();
			} else {
				$projectBidInvitationFileManagerFile = false;
			}
			$projectBidInvitation->setProjectBidInvitationFileManagerFile($projectBidInvitationFileManagerFile);

			$arrProjectBidInvitationsByProjectId[$project_bid_invitation_id] = $projectBidInvitation;
		}

		$db->free_result();

		self::$_arrProjectBidInvitationsByProjectId = $arrProjectBidInvitationsByProjectId;

		return $arrProjectBidInvitationsByProjectId;
	}

	/**
	 * Load by constraint `project_bid_invitations_fk_fmfiles` foreign key (`project_bid_invitation_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $project_bid_invitation_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectBidInvitationsByProjectBidInvitationFileManagerFileId($database, $project_bid_invitation_file_manager_file_id, Input $options=null)
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
			self::$_arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId = null;
		}

		$arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId = self::$_arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId;
		if (isset($arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId) && !empty($arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId)) {
			return $arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId;
		}

		$project_bid_invitation_file_manager_file_id = (int) $project_bid_invitation_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectBidInvitation = new ProjectBidInvitation($database);
			$sqlOrderByColumns = $tmpProjectBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	pbi.*

FROM `project_bid_invitations` pbi
WHERE pbi.`project_bid_invitation_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$arrValues = array($project_bid_invitation_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$project_bid_invitation_id = $row['id'];
			$projectBidInvitation = self::instantiateOrm($database, 'ProjectBidInvitation', $row, null, $project_bid_invitation_id);
			/* @var $projectBidInvitation ProjectBidInvitation */
			$arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId[$project_bid_invitation_id] = $projectBidInvitation;
		}

		$db->free_result();

		self::$_arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId = $arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId;

		return $arrProjectBidInvitationsByProjectBidInvitationFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all project_bid_invitations records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllProjectBidInvitations($database, Input $options=null)
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
			self::$_arrAllProjectBidInvitations = null;
		}

		$arrAllProjectBidInvitations = self::$_arrAllProjectBidInvitations;
		if (isset($arrAllProjectBidInvitations) && !empty($arrAllProjectBidInvitations)) {
			return $arrAllProjectBidInvitations;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectBidInvitation = new ProjectBidInvitation($database);
			$sqlOrderByColumns = $tmpProjectBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	pbi.*

FROM `project_bid_invitations` pbi{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjectBidInvitations = array();
		while ($row = $db->fetch()) {
			$project_bid_invitation_id = $row['id'];
			$projectBidInvitation = self::instantiateOrm($database, 'ProjectBidInvitation', $row, null, $project_bid_invitation_id);
			/* @var $projectBidInvitation ProjectBidInvitation */
			$arrAllProjectBidInvitations[$project_bid_invitation_id] = $projectBidInvitation;
		}

		$db->free_result();

		self::$_arrAllProjectBidInvitations = $arrAllProjectBidInvitations;

		return $arrAllProjectBidInvitations;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public static function findNextProjectBidInvitationSequenceNumber($database, $project_id)
	{
		$next_project_bid_invitation_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(`project_bid_invitation_sequence_number`) AS 'max_project_bid_invitation_sequence_number'
FROM `project_bid_invitations`
WHERE `project_id` = ?
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_project_bid_invitation_sequence_number = $row['max_project_bid_invitation_sequence_number'];
			$next_project_bid_invitation_sequence_number = $max_project_bid_invitation_sequence_number + 1;
		}

		return $next_project_bid_invitation_sequence_number;
	}

	public static function deriveProjectBidInvitationCount($database, $project_id)
	{
		$projectBidInvitationCount = 0;

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT count(*) AS 'total'
FROM `project_bid_invitations`
WHERE `project_id` = ?
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$projectBidInvitationCount = $row['total'];
		}

		return $projectBidInvitationCount;
	}

	/**
	 * Load by constraint `project_bid_invitations_fk_fmfiles` foreign key (`project_bid_invitation_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param array $arrProjectBidInvitationFileManagerFileIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds($database, $arrProjectBidInvitationFileManagerFileIds, Input $options=null)
	{
		if (empty($arrProjectBidInvitationFileManagerFileIds)) {
			return array();
		}

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

		/*
		if ($forceLoadFlag) {
			self::$_arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds = null;
		}

		$arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds = self::$_arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds;
		if (isset($arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds) && !empty($arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds)) {
			return $arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds;
		}
		*/

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectBidInvitation = new ProjectBidInvitation($database);
			$sqlOrderByColumns = $tmpProjectBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrProjectBidInvitationFileManagerFileIds as $k => $project_bid_invitation_file_manager_file_id) {
			$project_bid_invitation_file_manager_file_id = (int) $project_bid_invitation_file_manager_file_id;
			$arrProjectBidInvitationFileManagerFileIds[$k] = $db->escape($project_bid_invitation_file_manager_file_id);
		}
		$csvProjectBidInvitationFileManagerFileIds = join(',', $arrProjectBidInvitationFileManagerFileIds);

		$query =
"
SELECT
	pbi.*

FROM `project_bid_invitations` pbi
WHERE pbi.`project_bid_invitation_file_manager_file_id` IN ($csvProjectBidInvitationFileManagerFileIds){$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `project_bid_invitation_sequence_number` ASC, `project_bid_invitation_file_manager_file_id` ASC, `created` ASC
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds = array();
		while ($row = $db->fetch()) {
			$project_bid_invitation_id = $row['id'];
			$projectBidInvitation = self::instantiateOrm($database, 'ProjectBidInvitation', $row, null, $project_bid_invitation_id);
			/* @var $projectBidInvitation ProjectBidInvitation */
			$arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds[$project_bid_invitation_id] = $projectBidInvitation;
		}

		$db->free_result();

		//self::$_arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds = $arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds;

		return $arrProjectBidInvitationsByArrProjectBidInvitationFileManagerFileIds;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

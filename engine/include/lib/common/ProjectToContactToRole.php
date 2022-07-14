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
 * ProjectToContactToRole.
 *
 * @category   Framework
 * @package    ProjectToContactToRole
 */

/**
 * Role
 */
require_once('lib/common/Role.php');

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ProjectToContactToRole extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ProjectToContactToRole';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'projects_to_contacts_to_roles';

	/**
	 * primary key (`project_id`,`contact_id`,`role_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'project_id' => 'int',
		'contact_id' => 'int',
		'role_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_project_to_contact_to_role_via_primary_key' => array(
			'project_id' => 'int',
			'contact_id' => 'int',
			'role_id' => 'int'
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
		'role_id' => 'role_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_id;
	public $contact_id;
	public $role_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrProjectsToContactsToRolesByProjectId;
	protected static $_arrProjectsToContactsToRolesByContactId;
	protected static $_arrProjectsToContactsToRolesByRoleId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjectsToContactsToRoles;

	// Foreign Key Objects
	private $_project;
	private $_contact;
	private $_role;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='projects_to_contacts_to_roles')
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrProjectsToContactsToRolesByProjectId()
	{
		if (isset(self::$_arrProjectsToContactsToRolesByProjectId)) {
			return self::$_arrProjectsToContactsToRolesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToRolesByProjectId($arrProjectsToContactsToRolesByProjectId)
	{
		self::$_arrProjectsToContactsToRolesByProjectId = $arrProjectsToContactsToRolesByProjectId;
	}

	public static function getArrProjectsToContactsToRolesByContactId()
	{
		if (isset(self::$_arrProjectsToContactsToRolesByContactId)) {
			return self::$_arrProjectsToContactsToRolesByContactId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToRolesByContactId($arrProjectsToContactsToRolesByContactId)
	{
		self::$_arrProjectsToContactsToRolesByContactId = $arrProjectsToContactsToRolesByContactId;
	}

	public static function getArrProjectsToContactsToRolesByRoleId()
	{
		if (isset(self::$_arrProjectsToContactsToRolesByRoleId)) {
			return self::$_arrProjectsToContactsToRolesByRoleId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToRolesByRoleId($arrProjectsToContactsToRolesByRoleId)
	{
		self::$_arrProjectsToContactsToRolesByRoleId = $arrProjectsToContactsToRolesByRoleId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllProjectsToContactsToRoles()
	{
		if (isset(self::$_arrAllProjectsToContactsToRoles)) {
			return self::$_arrAllProjectsToContactsToRoles;
		} else {
			return null;
		}
	}

	public static function setArrAllProjectsToContactsToRoles($arrAllProjectsToContactsToRoles)
	{
		self::$_arrAllProjectsToContactsToRoles = $arrAllProjectsToContactsToRoles;
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
	 * Find by primary key (`project_id`,`contact_id`,`role_id`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndContactIdAndRoleId($database, $project_id, $contact_id, $role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r
WHERE p2c2r.`project_id` = ?
AND p2c2r.`contact_id` = ?
AND p2c2r.`role_id` = ?
";
		$arrValues = array($project_id, $contact_id, $role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			return $projectToContactToRole;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`project_id`,`contact_id`,`role_id`) Extended.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndContactIdAndRoleIdExtended($database, $project_id, $contact_id, $role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	p2c2r_fk_p.`id` AS 'p2c2r_fk_p__project_id',
	p2c2r_fk_p.`project_type_id` AS 'p2c2r_fk_p__project_type_id',
	p2c2r_fk_p.`user_company_id` AS 'p2c2r_fk_p__user_company_id',
	p2c2r_fk_p.`user_custom_project_id` AS 'p2c2r_fk_p__user_custom_project_id',
	p2c2r_fk_p.`project_name` AS 'p2c2r_fk_p__project_name',
	p2c2r_fk_p.`project_owner_name` AS 'p2c2r_fk_p__project_owner_name',
	p2c2r_fk_p.`latitude` AS 'p2c2r_fk_p__latitude',
	p2c2r_fk_p.`longitude` AS 'p2c2r_fk_p__longitude',
	p2c2r_fk_p.`address_line_1` AS 'p2c2r_fk_p__address_line_1',
	p2c2r_fk_p.`address_line_2` AS 'p2c2r_fk_p__address_line_2',
	p2c2r_fk_p.`address_line_3` AS 'p2c2r_fk_p__address_line_3',
	p2c2r_fk_p.`address_line_4` AS 'p2c2r_fk_p__address_line_4',
	p2c2r_fk_p.`address_city` AS 'p2c2r_fk_p__address_city',
	p2c2r_fk_p.`address_county` AS 'p2c2r_fk_p__address_county',
	p2c2r_fk_p.`address_state_or_region` AS 'p2c2r_fk_p__address_state_or_region',
	p2c2r_fk_p.`address_postal_code` AS 'p2c2r_fk_p__address_postal_code',
	p2c2r_fk_p.`address_postal_code_extension` AS 'p2c2r_fk_p__address_postal_code_extension',
	p2c2r_fk_p.`address_country` AS 'p2c2r_fk_p__address_country',
	p2c2r_fk_p.`building_count` AS 'p2c2r_fk_p__building_count',
	p2c2r_fk_p.`unit_count` AS 'p2c2r_fk_p__unit_count',
	p2c2r_fk_p.`gross_square_footage` AS 'p2c2r_fk_p__gross_square_footage',
	p2c2r_fk_p.`net_rentable_square_footage` AS 'p2c2r_fk_p__net_rentable_square_footage',
	p2c2r_fk_p.`is_active_flag` AS 'p2c2r_fk_p__is_active_flag',
	p2c2r_fk_p.`public_plans_flag` AS 'p2c2r_fk_p__public_plans_flag',
	p2c2r_fk_p.`prevailing_wage_flag` AS 'p2c2r_fk_p__prevailing_wage_flag',
	p2c2r_fk_p.`city_business_license_required_flag` AS 'p2c2r_fk_p__city_business_license_required_flag',
	p2c2r_fk_p.`is_internal_flag` AS 'p2c2r_fk_p__is_internal_flag',
	p2c2r_fk_p.`project_contract_date` AS 'p2c2r_fk_p__project_contract_date',
	p2c2r_fk_p.`project_start_date` AS 'p2c2r_fk_p__project_start_date',
	p2c2r_fk_p.`project_completed_date` AS 'p2c2r_fk_p__project_completed_date',
	p2c2r_fk_p.`sort_order` AS 'p2c2r_fk_p__sort_order',

	p2c2r_fk_c.`id` AS 'p2c2r_fk_c__contact_id',
	p2c2r_fk_c.`user_company_id` AS 'p2c2r_fk_c__user_company_id',
	p2c2r_fk_c.`user_id` AS 'p2c2r_fk_c__user_id',
	p2c2r_fk_c.`contact_company_id` AS 'p2c2r_fk_c__contact_company_id',
	p2c2r_fk_c.`email` AS 'p2c2r_fk_c__email',
	p2c2r_fk_c.`name_prefix` AS 'p2c2r_fk_c__name_prefix',
	p2c2r_fk_c.`first_name` AS 'p2c2r_fk_c__first_name',
	p2c2r_fk_c.`additional_name` AS 'p2c2r_fk_c__additional_name',
	p2c2r_fk_c.`middle_name` AS 'p2c2r_fk_c__middle_name',
	p2c2r_fk_c.`last_name` AS 'p2c2r_fk_c__last_name',
	p2c2r_fk_c.`name_suffix` AS 'p2c2r_fk_c__name_suffix',
	p2c2r_fk_c.`title` AS 'p2c2r_fk_c__title',
	p2c2r_fk_c.`vendor_flag` AS 'p2c2r_fk_c__vendor_flag',

	p2c2r_fk_r.`id` AS 'p2c2r_fk_r__role_id',
	p2c2r_fk_r.`role` AS 'p2c2r_fk_r__role',
	p2c2r_fk_r.`role_description` AS 'p2c2r_fk_r__role_description',
	p2c2r_fk_r.`project_specific_flag` AS 'p2c2r_fk_r__project_specific_flag',
	p2c2r_fk_r.`sort_order` AS 'p2c2r_fk_r__sort_order',

	p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r
	INNER JOIN `projects` p2c2r_fk_p ON p2c2r.`project_id` = p2c2r_fk_p.`id`
	INNER JOIN `contacts` p2c2r_fk_c ON p2c2r.`contact_id` = p2c2r_fk_c.`id`
	INNER JOIN `roles` p2c2r_fk_r ON p2c2r.`role_id` = p2c2r_fk_r.`id`
WHERE p2c2r.`project_id` = ?
AND p2c2r.`contact_id` = ?
AND p2c2r.`role_id` = ?
";
		$arrValues = array($project_id, $contact_id, $role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			$projectToContactToRole->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['p2c2r_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'p2c2r_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectToContactToRole->setProject($project);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['p2c2r_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'p2c2r_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$projectToContactToRole->setContact($contact);

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['p2c2r_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'p2c2r_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$projectToContactToRole->setRole($role);

			return $projectToContactToRole;
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
	 * @param array $arrProjectIdAndContactIdAndRoleIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToRolesByArrProjectIdAndContactIdAndRoleIdList($database, $arrProjectIdAndContactIdAndRoleIdList, Input $options=null)
	{
		if (empty($arrProjectIdAndContactIdAndRoleIdList)) {
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
		// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToRole = new ProjectToContactToRole($database);
			$sqlOrderByColumns = $tmpProjectToContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrProjectIdAndContactIdAndRoleIdList as $k => $arrTmp) {
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
		if (count($arrProjectIdAndContactIdAndRoleIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToRolesByArrProjectIdAndContactIdAndRoleIdList = array();
		while ($row = $db->fetch()) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			$arrProjectsToContactsToRolesByArrProjectIdAndContactIdAndRoleIdList[] = $projectToContactToRole;
		}

		$db->free_result();

		return $arrProjectsToContactsToRolesByArrProjectIdAndContactIdAndRoleIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `projects_to_contacts_to_roles_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToRolesByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrProjectsToContactsToRolesByProjectId = null;
		}

		$arrProjectsToContactsToRolesByProjectId = self::$_arrProjectsToContactsToRolesByProjectId;
		if (isset($arrProjectsToContactsToRolesByProjectId) && !empty($arrProjectsToContactsToRolesByProjectId)) {
			return $arrProjectsToContactsToRolesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToRole = new ProjectToContactToRole($database);
			$sqlOrderByColumns = $tmpProjectToContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r
WHERE p2c2r.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToRolesByProjectId = array();
		while ($row = $db->fetch()) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			$arrProjectsToContactsToRolesByProjectId[] = $projectToContactToRole;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToRolesByProjectId = $arrProjectsToContactsToRolesByProjectId;

		return $arrProjectsToContactsToRolesByProjectId;
	}

	/**
	 * Load by constraint `projects_to_contacts_to_roles_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToRolesByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrProjectsToContactsToRolesByContactId = null;
		}

		$arrProjectsToContactsToRolesByContactId = self::$_arrProjectsToContactsToRolesByContactId;
		if (isset($arrProjectsToContactsToRolesByContactId) && !empty($arrProjectsToContactsToRolesByContactId)) {
			return $arrProjectsToContactsToRolesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToRole = new ProjectToContactToRole($database);
			$sqlOrderByColumns = $tmpProjectToContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r
WHERE p2c2r.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToRolesByContactId = array();
		while ($row = $db->fetch()) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			$arrProjectsToContactsToRolesByContactId[] = $projectToContactToRole;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToRolesByContactId = $arrProjectsToContactsToRolesByContactId;

		return $arrProjectsToContactsToRolesByContactId;
	}

	/**
	 * Load by constraint `projects_to_contacts_to_roles_fk_r` foreign key (`role_id`) references `roles` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToRolesByRoleId($database, $role_id, Input $options=null)
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
			self::$_arrProjectsToContactsToRolesByRoleId = null;
		}

		$arrProjectsToContactsToRolesByRoleId = self::$_arrProjectsToContactsToRolesByRoleId;
		if (isset($arrProjectsToContactsToRolesByRoleId) && !empty($arrProjectsToContactsToRolesByRoleId)) {
			return $arrProjectsToContactsToRolesByRoleId;
		}

		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToRole = new ProjectToContactToRole($database);
			$sqlOrderByColumns = $tmpProjectToContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r
WHERE p2c2r.`role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToRolesByRoleId = array();
		while ($row = $db->fetch()) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			$arrProjectsToContactsToRolesByRoleId[] = $projectToContactToRole;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToRolesByRoleId = $arrProjectsToContactsToRolesByRoleId;

		return $arrProjectsToContactsToRolesByRoleId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all projects_to_contacts_to_roles records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllProjectsToContactsToRoles($database, Input $options=null)
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
			self::$_arrAllProjectsToContactsToRoles = null;
		}

		$arrAllProjectsToContactsToRoles = self::$_arrAllProjectsToContactsToRoles;
		if (isset($arrAllProjectsToContactsToRoles) && !empty($arrAllProjectsToContactsToRoles)) {
			return $arrAllProjectsToContactsToRoles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToRole = new ProjectToContactToRole($database);
			$sqlOrderByColumns = $tmpProjectToContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `role_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjectsToContactsToRoles = array();
		while ($row = $db->fetch()) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			$arrAllProjectsToContactsToRoles[] = $projectToContactToRole;
		}

		$db->free_result();

		self::$_arrAllProjectsToContactsToRoles = $arrAllProjectsToContactsToRoles;

		return $arrAllProjectsToContactsToRoles;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
	public function insertIgnore()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT IGNORE
INTO `projects_to_contacts_to_roles`
(`project_id`, `contact_id`, `role_id`)
VALUES (?, ?, ?)
";
		$arrValues = array($this->project_id, $this->contact_id, $this->role_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}

	/**
	 * Load by primary key (`project_id`,`contact_id`,`role_id`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadRolesByProjectIdAndContactId($database, $project_id, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	p2c2r_fk_p.`id` AS 'p2c2r_fk_p__project_id',
	p2c2r_fk_p.`project_type_id` AS 'p2c2r_fk_p__project_type_id',
	p2c2r_fk_p.`user_company_id` AS 'p2c2r_fk_p__user_company_id',
	p2c2r_fk_p.`user_custom_project_id` AS 'p2c2r_fk_p__user_custom_project_id',
	p2c2r_fk_p.`project_name` AS 'p2c2r_fk_p__project_name',
	p2c2r_fk_p.`project_owner_name` AS 'p2c2r_fk_p__project_owner_name',
	p2c2r_fk_p.`latitude` AS 'p2c2r_fk_p__latitude',
	p2c2r_fk_p.`longitude` AS 'p2c2r_fk_p__longitude',
	p2c2r_fk_p.`address_line_1` AS 'p2c2r_fk_p__address_line_1',
	p2c2r_fk_p.`address_line_2` AS 'p2c2r_fk_p__address_line_2',
	p2c2r_fk_p.`address_line_3` AS 'p2c2r_fk_p__address_line_3',
	p2c2r_fk_p.`address_line_4` AS 'p2c2r_fk_p__address_line_4',
	p2c2r_fk_p.`address_city` AS 'p2c2r_fk_p__address_city',
	p2c2r_fk_p.`address_county` AS 'p2c2r_fk_p__address_county',
	p2c2r_fk_p.`address_state_or_region` AS 'p2c2r_fk_p__address_state_or_region',
	p2c2r_fk_p.`address_postal_code` AS 'p2c2r_fk_p__address_postal_code',
	p2c2r_fk_p.`address_postal_code_extension` AS 'p2c2r_fk_p__address_postal_code_extension',
	p2c2r_fk_p.`address_country` AS 'p2c2r_fk_p__address_country',
	p2c2r_fk_p.`building_count` AS 'p2c2r_fk_p__building_count',
	p2c2r_fk_p.`unit_count` AS 'p2c2r_fk_p__unit_count',
	p2c2r_fk_p.`gross_square_footage` AS 'p2c2r_fk_p__gross_square_footage',
	p2c2r_fk_p.`net_rentable_square_footage` AS 'p2c2r_fk_p__net_rentable_square_footage',
	p2c2r_fk_p.`is_active_flag` AS 'p2c2r_fk_p__is_active_flag',
	p2c2r_fk_p.`public_plans_flag` AS 'p2c2r_fk_p__public_plans_flag',
	p2c2r_fk_p.`prevailing_wage_flag` AS 'p2c2r_fk_p__prevailing_wage_flag',
	p2c2r_fk_p.`city_business_license_required_flag` AS 'p2c2r_fk_p__city_business_license_required_flag',
	p2c2r_fk_p.`is_internal_flag` AS 'p2c2r_fk_p__is_internal_flag',
	p2c2r_fk_p.`project_contract_date` AS 'p2c2r_fk_p__project_contract_date',
	p2c2r_fk_p.`project_start_date` AS 'p2c2r_fk_p__project_start_date',
	p2c2r_fk_p.`project_completed_date` AS 'p2c2r_fk_p__project_completed_date',
	p2c2r_fk_p.`sort_order` AS 'p2c2r_fk_p__sort_order',

	p2c2r_fk_c.`id` AS 'p2c2r_fk_c__contact_id',
	p2c2r_fk_c.`user_company_id` AS 'p2c2r_fk_c__user_company_id',
	p2c2r_fk_c.`user_id` AS 'p2c2r_fk_c__user_id',
	p2c2r_fk_c.`contact_company_id` AS 'p2c2r_fk_c__contact_company_id',
	p2c2r_fk_c.`email` AS 'p2c2r_fk_c__email',
	p2c2r_fk_c.`name_prefix` AS 'p2c2r_fk_c__name_prefix',
	p2c2r_fk_c.`first_name` AS 'p2c2r_fk_c__first_name',
	p2c2r_fk_c.`additional_name` AS 'p2c2r_fk_c__additional_name',
	p2c2r_fk_c.`middle_name` AS 'p2c2r_fk_c__middle_name',
	p2c2r_fk_c.`last_name` AS 'p2c2r_fk_c__last_name',
	p2c2r_fk_c.`name_suffix` AS 'p2c2r_fk_c__name_suffix',
	p2c2r_fk_c.`title` AS 'p2c2r_fk_c__title',
	p2c2r_fk_c.`vendor_flag` AS 'p2c2r_fk_c__vendor_flag',

	p2c2r_fk_r.`id` AS 'p2c2r_fk_r__role_id',
	p2c2r_fk_r.`role` AS 'p2c2r_fk_r__role',
	p2c2r_fk_r.`role_description` AS 'p2c2r_fk_r__role_description',
	p2c2r_fk_r.`project_specific_flag` AS 'p2c2r_fk_r__project_specific_flag',
	p2c2r_fk_r.`sort_order` AS 'p2c2r_fk_r__sort_order',

		p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r
	INNER JOIN `projects` p2c2r_fk_p ON p2c2r.`project_id` = p2c2r_fk_p.`id`
	INNER JOIN `contacts` p2c2r_fk_c ON p2c2r.`contact_id` = p2c2r_fk_c.`id`
	INNER JOIN `roles` p2c2r_fk_r ON p2c2r.`role_id` = p2c2r_fk_r.`id`
WHERE p2c2r.`project_id` = ?
AND p2c2r.`contact_id` = ?
";
		$arrValues = array($project_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRolesByProjectIdAndContactId = array();
		if ($row && !empty($row)) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			$projectToContactToRole->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['p2c2r_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'p2c2r_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectToContactToRole->setProject($project);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['p2c2r_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'p2c2r_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$projectToContactToRole->setContact($contact);

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['p2c2r_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'p2c2r_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$projectToContactToRole->setRole($role);

			$arrRolesByProjectIdAndContactId[] = $projectToContactToRole;
		}

		return $arrRolesByProjectIdAndContactId;
	}

	public static function loadProjectsToContactsToRolesListByUserId($database, $user_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT p2c2r.*, r.`role` 'role_name'
FROM `contacts` c, `projects_to_contacts_to_roles` p2c2r, `roles` r,
WHERE c.`user_id` = ?
AND c.`id` = p2c2r.`contact_id`
AND p2c2r.`role_id = r.`id`
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToRolesList = array();
		while ($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$contact_id = $row['contact_id'];
			$role_id = $row['role_id'];
			$arrProjectsToContactsToRolesList[$project_id][] = $row;
		}
		$db->free_result();

		return $arrProjectsToContactsToRolesList;
	}

	public static function loadProjectsListByContactId($database, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT p.*
FROM `projects_to_contacts_to_roles` p2c2r, `projects` p
WHERE p2c2r.`contact_id` = ?
AND p2c2r.`project_id` = p.`id`
GROUP BY p.`id`
";
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjects = array();
		while ($row = $db->fetch()) {
			$project_id = $row['id'];

			$p = new Project($database);
			$p->setId($project_id);
			$key = array(
				'id' => $project_id
			);
			$p->setKey($key);
			$p->setData($row);
			$p->convertDataToProperties();

			$arrProjects[$project_id] = $p;
		}
		$db->free_result();

		return $arrProjects;
	}

	public static function loadRolesListByProjectIdAndContactId($database, $project_id, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT r.*
FROM `projects_to_contacts_to_roles` p2c2r, `roles` r
WHERE p2c2r.`project_id` = ?
AND p2c2r.`contact_id` = ?
AND p2c2r.`role_id` = r.`id`
";
		$arrValues = array($project_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRolesList = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];

			$r = new Role($database);
			$key = array('id' => $role_id);
			$r->setKey($key);
			$r->setData($row);
			$r->convertDataToProperties();

			$arrRolesList[$role_id] = $r;
		}
		$db->free_result();

		return $arrRolesList;
	}

	/**
	 * This loads the list of contacts and their roles by project for a "Team Members" view.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param unknown_type $orderBy
	 * @return array
	 */
	public static function loadContactsWithRolesByProjectId($database, $project_id, $orderBy, $filterByProjectTeamMembers=false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if ($filterByProjectTeamMembers) {
			$joinFilter =
"
	INNER JOIN `role_groups_to_roles` rg2r ON p2c2r.`role_id` = rg2r.`role_id`
	INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id`";
			$whereFilter =
"
AND rg.`role_group` = 'project_team_members'";
		} else {
			$joinFilter = '';
			$whereFilter = '';
		}

		$query =
"
SELECT
	p2c2r.`contact_id`,
	p2c2r.`role_id`
FROM `projects_to_contacts_to_roles` p2c2r$joinFilter
WHERE p2c2r.`project_id` = ?$whereFilter
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrContactIdsToRoleIdsByProjectId = array();
		$arrContactIds = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$role_id = $row['role_id'];

			$arrContactIdsToRoleIdsByProjectId[$contact_id][$project_id][$role_id] = $role_id;
			$arrContactIds[$contact_id] = 1;
		}
		$db->free_result();

		$arrContactsWithRolesByProjectId = array();
		if (!empty($arrContactIds)) {

			// Assign role_id by project_id lists to each $contact object
			$arrContactIds = array_keys($arrContactIds);
			$in = join(',', $arrContactIds);
			$query =
"
SELECT
	c.*,
	cc.*,
	ui.*,
	c.`id` as 'contact_id',
	cc.`id` as 'contact_company_id',
	ui.`id` as 'user_invitation_id',
	c.`user_id` AS 'contact_user_id',
	ui.`user_id` as 'user_invitation_user_id',
	ui.`created` as 'ui_created'
FROM `contacts` c
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
	LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id`
WHERE c.`id` IN ($in) AND c.`is_archive` = 'N'
ORDER BY $orderBy
";
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$arrContactsWithRolesByProjectId = array();
			while ($row = $db->fetch()) {
				$contact_id = $row['contact_id'];
				$contact_user_id = $row['contact_user_id'];
				$contact_company_id = $row['contact_company_id'];
				$user_invitation_user_id = $row['user_id'];
				$user_invitation_id = $row['user_invitation_id'];
				$invitation_date = $row['ui_created'];

				$row['id'] = $contact_id;
				$row['user_id'] = $contact_user_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrRoleIdsByProjectId = $arrContactIdsToRoleIdsByProjectId[$contact_id];
				$contact->setArrRoleIdsByProjectId($arrRoleIdsByProjectId);

				$row['id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
				$contact->setContactCompany($contactCompany);

				// LEFT OUTER JOIN `user_invitations` ui ON p2c2r.`contact_id` = ui.`contact_id`
				if (isset($row['user_invitation_id']) && !empty($row['user_invitation_id'])) {
					$row['id'] = $user_invitation_id;
					$row['user_id'] = $user_invitation_user_id;
					$row['created'] = $invitation_date;
					$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
					/* @var $userInvitation UserInvitation */
					$userInvitation->convertPropertiesToData();
					$contact->setUserInvitation($userInvitation);
				} else {
					$contact->setUserInvitation(false);
				}

				$arrContactsWithRolesByProjectId[$contact_id] = $contact;

			}
			$db->free_result();
		}

		return $arrContactsWithRolesByProjectId;
	}

	// Query to show only team contact in permission page

	public static function loadContactsWithRolesByProjectIdforteam($database, $project_id, $orderBy, $filterByProjectTeamMembers=false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$AXIS_USER_ROLE_ID_SUBCONTRACTOR = AXIS_USER_ROLE_ID_SUBCONTRACTOR;
		$AXIS_USER_ROLE_ID_BIDDER = AXIS_USER_ROLE_ID_BIDDER;

		if ($filterByProjectTeamMembers) {
			$joinFilter =
"
	INNER JOIN `role_groups_to_roles` rg2r ON p2c2r.`role_id` = rg2r.`role_id`
	INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id`";
			$whereFilter =
"
AND rg.`role_group` = 'project_team_members'";
		} else {
			$joinFilter = '';
			$whereFilter = '';
		}

		$query =
"
SELECT
	p2c2r.`contact_id`,
	p2c2r.`role_id`
FROM `projects_to_contacts_to_roles` p2c2r$joinFilter
WHERE p2c2r.`project_id` = ?$whereFilter
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrContactIdsToRoleIdsByProjectId = array();
		$arrContactIds = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$role_id = $row['role_id'];

			$arrContactIdsToRoleIdsByProjectId[$contact_id][$project_id][$role_id] = $role_id;
			$arrContactIds[$contact_id] = 1;
		}
		$db->free_result();

		$arrContactsWithRolesByProjectId = array();
		if (!empty($arrContactIds)) {

			// Assign role_id by project_id lists to each $contact object
			$arrContactIds = array_keys($arrContactIds);
			$in = join(',', $arrContactIds);
			$query =
"
SELECT
	c.*,
	cc.*,
	ui.*,
	c.`id` as 'contact_id',
	cc.`id` as 'contact_company_id',
	ui.`id` as 'user_invitation_id',
	c.`user_id` AS 'contact_user_id',
	ui.`user_id` as 'user_invitation_user_id',
	ui.`created` as 'ui_created'
FROM `contacts` c
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
	LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id`
WHERE c.`id` IN ($in) AND c.`is_archive` = 'N'
ORDER BY $orderBy
";
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$arrContactsWithRolesByProjectId = array();
			while ($row = $db->fetch()) {
				$contact_id = $row['contact_id'];
				$contact_user_id = $row['contact_user_id'];
				$contact_company_id = $row['contact_company_id'];
				$user_invitation_user_id = $row['user_id'];
				$user_invitation_id = $row['user_invitation_id'];
				$invitation_date = $row['ui_created'];

				$row['id'] = $contact_id;
				$row['user_id'] = $contact_user_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrRoleIdsByProjectId = $arrContactIdsToRoleIdsByProjectId[$contact_id];
				$contact->setArrRoleIdsByProjectId($arrRoleIdsByProjectId);

				$row['id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
				$contact->setContactCompany($contactCompany);

				// LEFT OUTER JOIN `user_invitations` ui ON p2c2r.`contact_id` = ui.`contact_id`
				if (isset($row['user_invitation_id']) && !empty($row['user_invitation_id'])) {
					$row['id'] = $user_invitation_id;
					$row['user_id'] = $user_invitation_user_id;
					$row['created'] = $invitation_date;
					$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
					/* @var $userInvitation UserInvitation */
					$userInvitation->convertPropertiesToData();
					$contact->setUserInvitation($userInvitation);
				} else {
					$contact->setUserInvitation(false);
				}

				$arrContactsWithRolesByProjectId[$contact_id] = $contact;

			}
			$db->free_result();
		}

		return $arrContactsWithRolesByProjectId;
	}

	// Query to show only subcontractor contact in permission page

	public static function loadContactsWithRolesByProjectIdforsubcontractor($database, $project_id, $orderBy, $filterByProjectTeamMembers=false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$AXIS_USER_ROLE_ID_SUBCONTRACTOR = AXIS_USER_ROLE_ID_SUBCONTRACTOR;		

		if ($filterByProjectTeamMembers) {
			$joinFilter =
"
	INNER JOIN `role_groups_to_roles` rg2r ON p2c2r.`role_id` = rg2r.`role_id`
	INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id`";
			$whereFilter =
"
AND rg.`role_group` = 'project_team_members'";
		} else {
			$joinFilter = '';
			$whereFilter = '';
		}

		$query =
"
SELECT
	p2c2r.`contact_id`,
	p2c2r.`role_id`
FROM `projects_to_contacts_to_roles` p2c2r$joinFilter
WHERE p2c2r.`project_id` = ?$whereFilter AND p2c2r.`role_id` = ?
";
		$arrValues = array($project_id,$AXIS_USER_ROLE_ID_SUBCONTRACTOR);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrContactIdsToRoleIdsByProjectId = array();
		$arrContactIds = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$role_id = $row['role_id'];

			$arrContactIdsToRoleIdsByProjectId[$contact_id][$project_id][$role_id] = $role_id;
			$arrContactIds[$contact_id] = 1;
		}
		$db->free_result();

		$arrContactsWithRolesByProjectId = array();
		if (!empty($arrContactIds)) {

			// Assign role_id by project_id lists to each $contact object
			$arrContactIds = array_keys($arrContactIds);
			$in = join(',', $arrContactIds);
			$query =
"
SELECT
	c.*,
	cc.*,
	ui.*,
	c.`id` as 'contact_id',
	cc.`id` as 'contact_company_id',
	ui.`id` as 'user_invitation_id',
	c.`user_id` AS 'contact_user_id',
	ui.`user_id` as 'user_invitation_user_id',
	ui.`created` as 'ui_created'
FROM `contacts` c
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
	LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id`
WHERE c.`id` IN ($in) AND c.`is_archive` = 'N'
ORDER BY $orderBy
";
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$arrContactsWithRolesByProjectId = array();
			while ($row = $db->fetch()) {
				$contact_id = $row['contact_id'];
				$contact_user_id = $row['contact_user_id'];
				$contact_company_id = $row['contact_company_id'];
				$user_invitation_user_id = $row['user_id'];
				$user_invitation_id = $row['user_invitation_id'];
				$invitation_date = $row['ui_created'];

				$row['id'] = $contact_id;
				$row['user_id'] = $contact_user_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrRoleIdsByProjectId = $arrContactIdsToRoleIdsByProjectId[$contact_id];
				$contact->setArrRoleIdsByProjectId($arrRoleIdsByProjectId);

				$row['id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
				$contact->setContactCompany($contactCompany);

				// LEFT OUTER JOIN `user_invitations` ui ON p2c2r.`contact_id` = ui.`contact_id`
				if (isset($row['user_invitation_id']) && !empty($row['user_invitation_id'])) {
					$row['id'] = $user_invitation_id;
					$row['user_id'] = $user_invitation_user_id;
					$row['created'] = $invitation_date;
					$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
					/* @var $userInvitation UserInvitation */
					$userInvitation->convertPropertiesToData();
					$contact->setUserInvitation($userInvitation);
				} else {
					$contact->setUserInvitation(false);
				}

				$arrContactsWithRolesByProjectId[$contact_id] = $contact;

			}
			$db->free_result();
		}

		return $arrContactsWithRolesByProjectId;
	}

	// Query to show only bidder contact in permission page

	public static function loadContactsWithRolesByProjectIdforbidder($database, $project_id, $orderBy, $filterByProjectTeamMembers=false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$AXIS_USER_ROLE_ID_BIDDER = AXIS_USER_ROLE_ID_BIDDER;

		if ($filterByProjectTeamMembers) {
			$joinFilter =
"
	INNER JOIN `role_groups_to_roles` rg2r ON p2c2r.`role_id` = rg2r.`role_id`
	INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id`";
			$whereFilter =
"
AND rg.`role_group` = 'project_team_members'";
		} else {
			$joinFilter = '';
			$whereFilter = '';
		}

		$query =
"
SELECT
	p2c2r.`contact_id`,
	p2c2r.`role_id`
FROM `projects_to_contacts_to_roles` p2c2r$joinFilter
WHERE p2c2r.`project_id` = ?$whereFilter AND p2c2r.`role_id` = ?
";
		$arrValues = array($project_id,$AXIS_USER_ROLE_ID_BIDDER);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrContactIdsToRoleIdsByProjectId = array();
		$arrContactIds = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$role_id = $row['role_id'];

			$arrContactIdsToRoleIdsByProjectId[$contact_id][$project_id][$role_id] = $role_id;
			$arrContactIds[$contact_id] = 1;
		}
		$db->free_result();

		$arrContactsWithRolesByProjectId = array();
		if (!empty($arrContactIds)) {

			// Assign role_id by project_id lists to each $contact object
			$arrContactIds = array_keys($arrContactIds);
			$in = join(',', $arrContactIds);
			$query =
"
SELECT
	c.*,
	cc.*,
	ui.*,
	c.`id` as 'contact_id',
	cc.`id` as 'contact_company_id',
	ui.`id` as 'user_invitation_id',
	c.`user_id` AS 'contact_user_id',
	ui.`user_id` as 'user_invitation_user_id',
	ui.`created` as 'ui_created'
FROM `contacts` c
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
	LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id`
WHERE c.`id` IN ($in) AND c.`is_archive` = 'N'
ORDER BY $orderBy
";
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$arrContactsWithRolesByProjectId = array();
			while ($row = $db->fetch()) {
				$contact_id = $row['contact_id'];
				$contact_user_id = $row['contact_user_id'];
				$contact_company_id = $row['contact_company_id'];
				$user_invitation_user_id = $row['user_id'];
				$user_invitation_id = $row['user_invitation_id'];
				$invitation_date = $row['ui_created'];

				$row['id'] = $contact_id;
				$row['user_id'] = $contact_user_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();

				$arrRoleIdsByProjectId = $arrContactIdsToRoleIdsByProjectId[$contact_id];
				$contact->setArrRoleIdsByProjectId($arrRoleIdsByProjectId);

				$row['id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
				$contact->setContactCompany($contactCompany);

				// LEFT OUTER JOIN `user_invitations` ui ON p2c2r.`contact_id` = ui.`contact_id`
				if (isset($row['user_invitation_id']) && !empty($row['user_invitation_id'])) {
					$row['id'] = $user_invitation_id;
					$row['user_id'] = $user_invitation_user_id;
					$row['created'] = $invitation_date;
					$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
					/* @var $userInvitation UserInvitation */
					$userInvitation->convertPropertiesToData();
					$contact->setUserInvitation($userInvitation);
				} else {
					$contact->setUserInvitation(false);
				}

				$arrContactsWithRolesByProjectId[$contact_id] = $contact;

			}
			$db->free_result();
		}

		return $arrContactsWithRolesByProjectId;
	}

/**
	 * This loads the list of contacts and their roles by project for a "Team Members" view for report mdule contact list.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param unknown_type $orderBy
	 * @return array
	 */
	public static function loadContactsWithRolesByProjectIdReport($database, $project_id, $orderBy, $filterByProjectTeamMembers=false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		if ($filterByProjectTeamMembers) {
			$joinFilter =
"
	INNER JOIN `role_groups_to_roles` rg2r ON p2c2r.`role_id` = rg2r.`role_id`
	INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id`";
			$whereFilter =
"
AND rg.`role_group` = 'project_team_members'";
		} else {
			$joinFilter = '';
			$whereFilter = '';
		}

		$query =
"
SELECT
	p2c2r.`contact_id`,
	p2c2r.`role_id`
FROM `projects_to_contacts_to_roles` p2c2r$joinFilter
WHERE p2c2r.`project_id` = ?$whereFilter
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrContactIdsToRoleIdsByProjectId = array();
		$arrContactIds = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$role_id = $row['role_id'];

			$arrContactIdsToRoleIdsByProjectId[$contact_id][$project_id][$role_id] = $role_id;
			$arrContactIds[$contact_id] = 1;
		}
		$db->free_result();

		$arrContactsWithRolesByProjectId = array();
		if (!empty($arrContactIds)) {

			// Assign role_id by project_id lists to each $contact object
			$arrContactIds = array_keys($arrContactIds);
			$in = join(',', $arrContactIds);
			$query =
"
SELECT
	c.*,
	cc.*,
	ui.*,
	uc.`mobile_phone_number`,
	uc.`id`,
	c.`id` as 'contact_id',
	cc.`id` as 'contact_company_id',
	ui.`id` as 'user_invitation_id',
	c.`user_id` AS 'contact_user_id',
	ui.`user_id` as 'user_invitation_user_id',
	ui.`created` as 'ui_created'
FROM `contacts` c
	INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
	LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id`
	INNER JOIN `users` uc on c.`user_id` = uc.`id`
WHERE c.`id` IN ($in)
ORDER BY $orderBy
";
			$arrValues = array();
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$arrContactsWithRolesByProjectId = array();
			while ($row = $db->fetch()) {
				$contact_id = $row['contact_id'];
				$contact_user_id = $row['contact_user_id'];
				$contact_company_id = $row['contact_company_id'];
				$user_invitation_user_id = $row['user_id'];
				$user_invitation_id = $row['user_invitation_id'];
				$invitation_date = $row['ui_created'];
				
				$row['id'] = $contact_id;
				$row['user_id'] = $contact_user_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
				if(empty($contact->mobile_phone_number) && !empty($row['mobile_phone_number'])){
					$contact->mobile_phone_number = $row['mobile_phone_number'];
				}

				$arrRoleIdsByProjectId = $arrContactIdsToRoleIdsByProjectId[$contact_id];
				$contact->setArrRoleIdsByProjectId($arrRoleIdsByProjectId);

				$row['id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
				$contact->setContactCompany($contactCompany);

				// LEFT OUTER JOIN `user_invitations` ui ON p2c2r.`contact_id` = ui.`contact_id`
				if (isset($row['user_invitation_id']) && !empty($row['user_invitation_id'])) {
					$row['id'] = $user_invitation_id;
					$row['user_id'] = $user_invitation_user_id;
					$row['created'] = $invitation_date;
					$userInvitation = null;
					/* @var $userInvitation UserInvitation */
					$contact->setUserInvitation($userInvitation);
				} else {
					$contact->setUserInvitation(false);
				}

				$arrContactsWithRolesByProjectId[$contact_id] = $contact;

			}
			$db->free_result();
		}
		
		return $arrContactsWithRolesByProjectId;
	}
	/**
	 * This loads the list of contacts and their roles by project for a "Team Members" view.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param unknown_type $orderBy
	 * @return array
	 */
	public static function loadAssignedRolesByProjectId($database, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT r.*
FROM `roles` r, `projects_to_contacts_to_roles` p2c2r
WHERE p2c2r.`project_id` = ?
AND p2c2r.`role_id` = r.`id`
GROUP BY r.`id`
ORDER BY r.`role` ASC
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrAssignedRolesByProject = array();
		while ($row = $db->fetch()) {
			$role_id = $row['id'];

			$role = new Role($database);
			$role->setData($row);
			$role->convertDataToProperties();
			$key = array('id' => $role_id);
			$role->setKey($key);
			$role->setId($role_id);

			$arrAssignedRolesByProject[$role_id] = $role;
		}
		$db->free_result();

		return $arrAssignedRolesByProject;
	}

	/**
	 * This loads the list of contacts by the project_id and role_id.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param unknown_type $orderBy
	 * @return array
	 */
	public static function loadContactsByProjectIdAndRoleId($database, $project_id, $role_id,$contact_id=null)
	{
		$project_id = (int) $project_id;
		// $role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$filterContact="";
		if ($contact_id != null || $contact_id !="")
		{
			$filterContact  = "and c.id IN ($contact_id) ";
			
		}
		$query =
"
SELECT

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`

	INNER JOIN `projects_to_contacts_to_roles` p2c2r ON c.`id` = p2c2r.`contact_id`

WHERE p2c2r.`project_id` = ?
AND c.`is_archive` = 'N'
AND p2c2r.`role_id` IN ($role_id) $filterContact
ORDER BY c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByProjectIdAndRoleId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrContactsByProjectIdAndRoleId[$contact_id] = $contact;
		}
		$db->free_result();

		return $arrContactsByProjectIdAndRoleId;
	}

	/**
	 * INSERT a single record into an "association table" (join-box).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $role_id
	 */
	public static function addRoleToContactOnProject($database, $project_id, $contact_id, $role_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$selectCountQuery =
"
SELECT count(*)
FROM `projects_to_contacts_to_roles`
WHERE `project_id` = ?
AND `contact_id` = ?
AND `role_id` = ?
";

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `projects_to_contacts_to_roles` (`project_id`, `contact_id`, `role_id`)
VALUES (?, ?, ?)
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($project_id, $contact_id, $role_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		if ($role_id <> $AXIS_USER_ROLE_ID_USER) {
			$arrValues = array($project_id, $contact_id, $AXIS_USER_ROLE_ID_USER);
			$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
		$db->free_result();
	}

	// Add role to contact on project exper the team and user role

	public static function addRoleToContactOnProjectExceptTeam($database, $project_id, $contact_id, $role_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$selectCountQuery =
"
SELECT count(*)
FROM `projects_to_contacts_to_roles`
WHERE `project_id` = ?
AND `contact_id` = ?
AND `role_id` = ?
";

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `projects_to_contacts_to_roles` (`project_id`, `contact_id`, `role_id`)
VALUES (?, ?, ?)
";

		$db = DBI::getInstance($database);
		$db->begin();
		$arrValues = array($project_id, $contact_id, $role_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		if ($role_id <> $AXIS_USER_ROLE_ID_USER) {
			$arrValues = array($project_id, $contact_id, $AXIS_USER_ROLE_ID_USER);
			$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
		$db->free_result();
	}

	/**
	 * INSERT a single record into an "association table" (join-box).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $role_id
	 */
	public static function removeRoleFromContactOnProject($database, $project_id, $contact_id, $role_id)
	{
		$AXIS_USER_ROLE_ID_USER = (int) AXIS_USER_ROLE_ID_USER;

		if ($role_id == $AXIS_USER_ROLE_ID_USER) {
			return;
		}

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `projects_to_contacts_to_roles` (`project_id`, `contact_id`, `role_id`)
VALUES (?, ?, $AXIS_USER_ROLE_ID_USER)
";

		$deleteQuery =
"
DELETE FROM `projects_to_contacts_to_roles`
WHERE `project_id` = ?
AND `contact_id` = ?
AND `role_id` = ?
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($project_id, $contact_id, $role_id);
		$db->execute($deleteQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$arrValues = array($project_id, $contact_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	/**
	 * Add a contact to a project.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 */
	public static function addContactToProject($database, $project_id, $contact_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `projects_to_contacts_to_roles` (`project_id`, `contact_id`, `role_id`)
VALUES (?, ?, $AXIS_USER_ROLE_ID_USER)
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($project_id, $contact_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	public static function removeContactFromProject($database, $project_id, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
DELETE
FROM `projects_to_contacts_to_roles`
WHERE `project_id` = ?
AND `contact_id` = ?
";

		$db->begin();

		$arrValues = array($project_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	//To get all the project manager in a project
	// role_id = 5 for project managers
	public static function loadAllMembersbasedonRole($database,$project_id,$role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`

	INNER JOIN `projects_to_contacts_to_roles` p2c2r ON c.`id` = p2c2r.`contact_id`

WHERE p2c2r.`project_id` = ?
AND p2c2r.`role_id` IN ($role_id) and c.`is_archive` = ?
ORDER BY c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC
";


		$db->begin();

		$arrValues = array($project_id, 'N');
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$pmlist = array();
		while($row = $db->fetch())
		{
		   	$contact_id = $row['id'];
		   	$val = $row['email'];
		   	$pmlist[$contact_id] = $val;
		}
		$db->free_result();
		return $pmlist;
	
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

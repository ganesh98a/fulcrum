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
 * ProjectToContactToSoftwareModuleFunction.
 *
 * @category   Framework
 * @package    ProjectToContactToSoftwareModuleFunction
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ProjectToContactToSoftwareModuleFunction extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ProjectToContactToSoftwareModuleFunction';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'projects_to_contacts_to_software_module_functions';

	/**
	 * primary key (`project_id`,`contact_id`,`software_module_function_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'project_id' => 'int',
		'contact_id' => 'int',
		'software_module_function_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_project_to_contact_to_software_module_function_via_primary_key' => array(
			'project_id' => 'int',
			'contact_id' => 'int',
			'software_module_function_id' => 'int'
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
		'software_module_function_id' => 'software_module_function_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_id;
	public $contact_id;
	public $software_module_function_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrProjectsToContactsToSoftwareModuleFunctionsByProjectId;
	protected static $_arrProjectsToContactsToSoftwareModuleFunctionsByContactId;
	protected static $_arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjectsToContactsToSoftwareModuleFunctions;

	// Foreign Key Objects
	private $_project;
	private $_contact;
	private $_softwareModuleFunction;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='projects_to_contacts_to_software_module_functions')
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

	public function getSoftwareModuleFunction()
	{
		if (isset($this->_softwareModuleFunction)) {
			return $this->_softwareModuleFunction;
		} else {
			return null;
		}
	}

	public function setSoftwareModuleFunction($softwareModuleFunction)
	{
		$this->_softwareModuleFunction = $softwareModuleFunction;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrProjectsToContactsToSoftwareModuleFunctionsByProjectId()
	{
		if (isset(self::$_arrProjectsToContactsToSoftwareModuleFunctionsByProjectId)) {
			return self::$_arrProjectsToContactsToSoftwareModuleFunctionsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToSoftwareModuleFunctionsByProjectId($arrProjectsToContactsToSoftwareModuleFunctionsByProjectId)
	{
		self::$_arrProjectsToContactsToSoftwareModuleFunctionsByProjectId = $arrProjectsToContactsToSoftwareModuleFunctionsByProjectId;
	}

	public static function getArrProjectsToContactsToSoftwareModuleFunctionsByContactId()
	{
		if (isset(self::$_arrProjectsToContactsToSoftwareModuleFunctionsByContactId)) {
			return self::$_arrProjectsToContactsToSoftwareModuleFunctionsByContactId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToSoftwareModuleFunctionsByContactId($arrProjectsToContactsToSoftwareModuleFunctionsByContactId)
	{
		self::$_arrProjectsToContactsToSoftwareModuleFunctionsByContactId = $arrProjectsToContactsToSoftwareModuleFunctionsByContactId;
	}

	public static function getArrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId()
	{
		if (isset(self::$_arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId)) {
			return self::$_arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId($arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId)
	{
		self::$_arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = $arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllProjectsToContactsToSoftwareModuleFunctions()
	{
		if (isset(self::$_arrAllProjectsToContactsToSoftwareModuleFunctions)) {
			return self::$_arrAllProjectsToContactsToSoftwareModuleFunctions;
		} else {
			return null;
		}
	}

	public static function setArrAllProjectsToContactsToSoftwareModuleFunctions($arrAllProjectsToContactsToSoftwareModuleFunctions)
	{
		self::$_arrAllProjectsToContactsToSoftwareModuleFunctions = $arrAllProjectsToContactsToSoftwareModuleFunctions;
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
	 * Find by primary key (`project_id`,`contact_id`,`software_module_function_id`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndContactIdAndSoftwareModuleFunctionId($database, $project_id, $contact_id, $software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	p2c2smf.*

FROM `projects_to_contacts_to_software_module_functions` p2c2smf
WHERE p2c2smf.`project_id` = ?
AND p2c2smf.`contact_id` = ?
AND p2c2smf.`software_module_function_id` = ?
";
		$arrValues = array($project_id, $contact_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToContactToSoftwareModuleFunction = self::instantiateOrm($database, 'ProjectToContactToSoftwareModuleFunction', $row);
			/* @var $projectToContactToSoftwareModuleFunction ProjectToContactToSoftwareModuleFunction */
			return $projectToContactToSoftwareModuleFunction;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`project_id`,`contact_id`,`software_module_function_id`) Extended.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $contact_id
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndContactIdAndSoftwareModuleFunctionIdExtended($database, $project_id, $contact_id, $software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	p2c2smf_fk_p.`id` AS 'p2c2smf_fk_p__project_id',
	p2c2smf_fk_p.`project_type_id` AS 'p2c2smf_fk_p__project_type_id',
	p2c2smf_fk_p.`user_company_id` AS 'p2c2smf_fk_p__user_company_id',
	p2c2smf_fk_p.`user_custom_project_id` AS 'p2c2smf_fk_p__user_custom_project_id',
	p2c2smf_fk_p.`project_name` AS 'p2c2smf_fk_p__project_name',
	p2c2smf_fk_p.`project_owner_name` AS 'p2c2smf_fk_p__project_owner_name',
	p2c2smf_fk_p.`latitude` AS 'p2c2smf_fk_p__latitude',
	p2c2smf_fk_p.`longitude` AS 'p2c2smf_fk_p__longitude',
	p2c2smf_fk_p.`address_line_1` AS 'p2c2smf_fk_p__address_line_1',
	p2c2smf_fk_p.`address_line_2` AS 'p2c2smf_fk_p__address_line_2',
	p2c2smf_fk_p.`address_line_3` AS 'p2c2smf_fk_p__address_line_3',
	p2c2smf_fk_p.`address_line_4` AS 'p2c2smf_fk_p__address_line_4',
	p2c2smf_fk_p.`address_city` AS 'p2c2smf_fk_p__address_city',
	p2c2smf_fk_p.`address_county` AS 'p2c2smf_fk_p__address_county',
	p2c2smf_fk_p.`address_state_or_region` AS 'p2c2smf_fk_p__address_state_or_region',
	p2c2smf_fk_p.`address_postal_code` AS 'p2c2smf_fk_p__address_postal_code',
	p2c2smf_fk_p.`address_postal_code_extension` AS 'p2c2smf_fk_p__address_postal_code_extension',
	p2c2smf_fk_p.`address_country` AS 'p2c2smf_fk_p__address_country',
	p2c2smf_fk_p.`building_count` AS 'p2c2smf_fk_p__building_count',
	p2c2smf_fk_p.`unit_count` AS 'p2c2smf_fk_p__unit_count',
	p2c2smf_fk_p.`gross_square_footage` AS 'p2c2smf_fk_p__gross_square_footage',
	p2c2smf_fk_p.`net_rentable_square_footage` AS 'p2c2smf_fk_p__net_rentable_square_footage',
	p2c2smf_fk_p.`is_active_flag` AS 'p2c2smf_fk_p__is_active_flag',
	p2c2smf_fk_p.`public_plans_flag` AS 'p2c2smf_fk_p__public_plans_flag',
	p2c2smf_fk_p.`prevailing_wage_flag` AS 'p2c2smf_fk_p__prevailing_wage_flag',
	p2c2smf_fk_p.`city_business_license_required_flag` AS 'p2c2smf_fk_p__city_business_license_required_flag',
	p2c2smf_fk_p.`is_internal_flag` AS 'p2c2smf_fk_p__is_internal_flag',
	p2c2smf_fk_p.`project_contract_date` AS 'p2c2smf_fk_p__project_contract_date',
	p2c2smf_fk_p.`project_start_date` AS 'p2c2smf_fk_p__project_start_date',
	p2c2smf_fk_p.`project_completed_date` AS 'p2c2smf_fk_p__project_completed_date',
	p2c2smf_fk_p.`sort_order` AS 'p2c2smf_fk_p__sort_order',

	p2c2smf_fk_c.`id` AS 'p2c2smf_fk_c__contact_id',
	p2c2smf_fk_c.`user_company_id` AS 'p2c2smf_fk_c__user_company_id',
	p2c2smf_fk_c.`user_id` AS 'p2c2smf_fk_c__user_id',
	p2c2smf_fk_c.`contact_company_id` AS 'p2c2smf_fk_c__contact_company_id',
	p2c2smf_fk_c.`email` AS 'p2c2smf_fk_c__email',
	p2c2smf_fk_c.`name_prefix` AS 'p2c2smf_fk_c__name_prefix',
	p2c2smf_fk_c.`first_name` AS 'p2c2smf_fk_c__first_name',
	p2c2smf_fk_c.`additional_name` AS 'p2c2smf_fk_c__additional_name',
	p2c2smf_fk_c.`middle_name` AS 'p2c2smf_fk_c__middle_name',
	p2c2smf_fk_c.`last_name` AS 'p2c2smf_fk_c__last_name',
	p2c2smf_fk_c.`name_suffix` AS 'p2c2smf_fk_c__name_suffix',
	p2c2smf_fk_c.`title` AS 'p2c2smf_fk_c__title',
	p2c2smf_fk_c.`vendor_flag` AS 'p2c2smf_fk_c__vendor_flag',

	p2c2smf_fk_smf.`id` AS 'p2c2smf_fk_smf__software_module_function_id',
	p2c2smf_fk_smf.`software_module_id` AS 'p2c2smf_fk_smf__software_module_id',
	p2c2smf_fk_smf.`software_module_function` AS 'p2c2smf_fk_smf__software_module_function',
	p2c2smf_fk_smf.`software_module_function_label` AS 'p2c2smf_fk_smf__software_module_function_label',
	p2c2smf_fk_smf.`software_module_function_navigation_label` AS 'p2c2smf_fk_smf__software_module_function_navigation_label',
	p2c2smf_fk_smf.`software_module_function_description` AS 'p2c2smf_fk_smf__software_module_function_description',
	p2c2smf_fk_smf.`default_software_module_function_url` AS 'p2c2smf_fk_smf__default_software_module_function_url',
	p2c2smf_fk_smf.`show_in_navigation_flag` AS 'p2c2smf_fk_smf__show_in_navigation_flag',
	p2c2smf_fk_smf.`available_to_all_users_flag` AS 'p2c2smf_fk_smf__available_to_all_users_flag',
	p2c2smf_fk_smf.`global_admin_only_flag` AS 'p2c2smf_fk_smf__global_admin_only_flag',
	p2c2smf_fk_smf.`purchased_function_flag` AS 'p2c2smf_fk_smf__purchased_function_flag',
	p2c2smf_fk_smf.`customer_configurable_permissions_by_role_flag` AS 'p2c2smf_fk_smf__customer_configurable_permissions_by_role_flag',
	p2c2smf_fk_smf.`customer_configurable_permissions_by_project_by_role_flag` AS 'p2c2smf_fk_smf__customer_configurable_permissions_by_project_by_role_flag',
	p2c2smf_fk_smf.`customer_configurable_permissions_by_contact_flag` AS 'p2c2smf_fk_smf__customer_configurable_permissions_by_contact_flag',
	p2c2smf_fk_smf.`project_specific_flag` AS 'p2c2smf_fk_smf__project_specific_flag',
	p2c2smf_fk_smf.`disabled_flag` AS 'p2c2smf_fk_smf__disabled_flag',
	p2c2smf_fk_smf.`sort_order` AS 'p2c2smf_fk_smf__sort_order',

	p2c2smf.*

FROM `projects_to_contacts_to_software_module_functions` p2c2smf
	INNER JOIN `projects` p2c2smf_fk_p ON p2c2smf.`project_id` = p2c2smf_fk_p.`id`
	INNER JOIN `contacts` p2c2smf_fk_c ON p2c2smf.`contact_id` = p2c2smf_fk_c.`id`
	INNER JOIN `software_module_functions` p2c2smf_fk_smf ON p2c2smf.`software_module_function_id` = p2c2smf_fk_smf.`id`
WHERE p2c2smf.`project_id` = ?
AND p2c2smf.`contact_id` = ?
AND p2c2smf.`software_module_function_id` = ?
";
		$arrValues = array($project_id, $contact_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToContactToSoftwareModuleFunction = self::instantiateOrm($database, 'ProjectToContactToSoftwareModuleFunction', $row);
			/* @var $projectToContactToSoftwareModuleFunction ProjectToContactToSoftwareModuleFunction */
			$projectToContactToSoftwareModuleFunction->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['p2c2smf_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'p2c2smf_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectToContactToSoftwareModuleFunction->setProject($project);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['p2c2smf_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'p2c2smf_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$projectToContactToSoftwareModuleFunction->setContact($contact);

			if (isset($row['software_module_function_id'])) {
				$software_module_function_id = $row['software_module_function_id'];
				$row['p2c2smf_fk_smf__id'] = $software_module_function_id;
				$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id, 'p2c2smf_fk_smf__');
				/* @var $softwareModuleFunction SoftwareModuleFunction */
				$softwareModuleFunction->convertPropertiesToData();
			} else {
				$softwareModuleFunction = false;
			}
			$projectToContactToSoftwareModuleFunction->setSoftwareModuleFunction($softwareModuleFunction);

			return $projectToContactToSoftwareModuleFunction;
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
	 * @param array $arrProjectIdAndContactIdAndSoftwareModuleFunctionIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToSoftwareModuleFunctionsByArrProjectIdAndContactIdAndSoftwareModuleFunctionIdList($database, $arrProjectIdAndContactIdAndSoftwareModuleFunctionIdList, Input $options=null)
	{
		if (empty($arrProjectIdAndContactIdAndSoftwareModuleFunctionIdList)) {
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
		// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToSoftwareModuleFunction = new ProjectToContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpProjectToContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrProjectIdAndContactIdAndSoftwareModuleFunctionIdList as $k => $arrTmp) {
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
		if (count($arrProjectIdAndContactIdAndSoftwareModuleFunctionIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	p2c2smf.*

FROM `projects_to_contacts_to_software_module_functions` p2c2smf
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToSoftwareModuleFunctionsByArrProjectIdAndContactIdAndSoftwareModuleFunctionIdList = array();
		while ($row = $db->fetch()) {
			$projectToContactToSoftwareModuleFunction = self::instantiateOrm($database, 'ProjectToContactToSoftwareModuleFunction', $row);
			/* @var $projectToContactToSoftwareModuleFunction ProjectToContactToSoftwareModuleFunction */
			$arrProjectsToContactsToSoftwareModuleFunctionsByArrProjectIdAndContactIdAndSoftwareModuleFunctionIdList[] = $projectToContactToSoftwareModuleFunction;
		}

		$db->free_result();

		return $arrProjectsToContactsToSoftwareModuleFunctionsByArrProjectIdAndContactIdAndSoftwareModuleFunctionIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `projects_to_contacts_to_software_module_functions_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToSoftwareModuleFunctionsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrProjectsToContactsToSoftwareModuleFunctionsByProjectId = null;
		}

		$arrProjectsToContactsToSoftwareModuleFunctionsByProjectId = self::$_arrProjectsToContactsToSoftwareModuleFunctionsByProjectId;
		if (isset($arrProjectsToContactsToSoftwareModuleFunctionsByProjectId) && !empty($arrProjectsToContactsToSoftwareModuleFunctionsByProjectId)) {
			return $arrProjectsToContactsToSoftwareModuleFunctionsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToSoftwareModuleFunction = new ProjectToContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpProjectToContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2smf.*

FROM `projects_to_contacts_to_software_module_functions` p2c2smf
WHERE p2c2smf.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToSoftwareModuleFunctionsByProjectId = array();
		while ($row = $db->fetch()) {
			$projectToContactToSoftwareModuleFunction = self::instantiateOrm($database, 'ProjectToContactToSoftwareModuleFunction', $row);
			/* @var $projectToContactToSoftwareModuleFunction ProjectToContactToSoftwareModuleFunction */
			$arrProjectsToContactsToSoftwareModuleFunctionsByProjectId[] = $projectToContactToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToSoftwareModuleFunctionsByProjectId = $arrProjectsToContactsToSoftwareModuleFunctionsByProjectId;

		return $arrProjectsToContactsToSoftwareModuleFunctionsByProjectId;
	}

	/**
	 * Load by constraint `projects_to_contacts_to_software_module_functions_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToSoftwareModuleFunctionsByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrProjectsToContactsToSoftwareModuleFunctionsByContactId = null;
		}

		$arrProjectsToContactsToSoftwareModuleFunctionsByContactId = self::$_arrProjectsToContactsToSoftwareModuleFunctionsByContactId;
		if (isset($arrProjectsToContactsToSoftwareModuleFunctionsByContactId) && !empty($arrProjectsToContactsToSoftwareModuleFunctionsByContactId)) {
			return $arrProjectsToContactsToSoftwareModuleFunctionsByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToSoftwareModuleFunction = new ProjectToContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpProjectToContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2smf.*

FROM `projects_to_contacts_to_software_module_functions` p2c2smf
WHERE p2c2smf.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToSoftwareModuleFunctionsByContactId = array();
		while ($row = $db->fetch()) {
			$projectToContactToSoftwareModuleFunction = self::instantiateOrm($database, 'ProjectToContactToSoftwareModuleFunction', $row);
			/* @var $projectToContactToSoftwareModuleFunction ProjectToContactToSoftwareModuleFunction */
			$arrProjectsToContactsToSoftwareModuleFunctionsByContactId[] = $projectToContactToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToSoftwareModuleFunctionsByContactId = $arrProjectsToContactsToSoftwareModuleFunctionsByContactId;

		return $arrProjectsToContactsToSoftwareModuleFunctionsByContactId;
	}

	/**
	 * Load by constraint `projects_to_contacts_to_software_module_functions_fk_smf` foreign key (`software_module_function_id`) references `software_module_functions` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $software_module_function_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId($database, $software_module_function_id, Input $options=null)
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
			self::$_arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = null;
		}

		$arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = self::$_arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		if (isset($arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId) && !empty($arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId)) {
			return $arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		}

		$software_module_function_id = (int) $software_module_function_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToSoftwareModuleFunction = new ProjectToContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpProjectToContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2smf.*

FROM `projects_to_contacts_to_software_module_functions` p2c2smf
WHERE p2c2smf.`software_module_function_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$arrValues = array($software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = array();
		while ($row = $db->fetch()) {
			$projectToContactToSoftwareModuleFunction = self::instantiateOrm($database, 'ProjectToContactToSoftwareModuleFunction', $row);
			/* @var $projectToContactToSoftwareModuleFunction ProjectToContactToSoftwareModuleFunction */
			$arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId[] = $projectToContactToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = $arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;

		return $arrProjectsToContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all projects_to_contacts_to_software_module_functions records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllProjectsToContactsToSoftwareModuleFunctions($database, Input $options=null)
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
			self::$_arrAllProjectsToContactsToSoftwareModuleFunctions = null;
		}

		$arrAllProjectsToContactsToSoftwareModuleFunctions = self::$_arrAllProjectsToContactsToSoftwareModuleFunctions;
		if (isset($arrAllProjectsToContactsToSoftwareModuleFunctions) && !empty($arrAllProjectsToContactsToSoftwareModuleFunctions)) {
			return $arrAllProjectsToContactsToSoftwareModuleFunctions;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToContactToSoftwareModuleFunction = new ProjectToContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpProjectToContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2c2smf.*

FROM `projects_to_contacts_to_software_module_functions` p2c2smf{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `contact_id` ASC, `software_module_function_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjectsToContactsToSoftwareModuleFunctions = array();
		while ($row = $db->fetch()) {
			$projectToContactToSoftwareModuleFunction = self::instantiateOrm($database, 'ProjectToContactToSoftwareModuleFunction', $row);
			/* @var $projectToContactToSoftwareModuleFunction ProjectToContactToSoftwareModuleFunction */
			$arrAllProjectsToContactsToSoftwareModuleFunctions[] = $projectToContactToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrAllProjectsToContactsToSoftwareModuleFunctions = $arrAllProjectsToContactsToSoftwareModuleFunctions;

		return $arrAllProjectsToContactsToSoftwareModuleFunctions;
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
INTO `projects_to_contacts_to_software_module_functions`
(`project_id`, `contact_id`, `software_module_function_id`)
VALUES (?, ?, ?)
";
		$arrValues = array($this->project_id, $this->contact_id, $this->software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

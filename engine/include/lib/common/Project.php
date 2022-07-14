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
 * Generic Project class.
 *
 * "Is A":
 * Project
 *
 * "Has A":
 * 1) a
 * 2) b
 * 3) c
 *
 * @category	Framework
 * @package		Project
 */

/**
 * Project.
 *
 * @category   Framework
 * @package    Project
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Project extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Project';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'projects';

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
	 * unique index `unique_project` (`user_company_id`,`project_name`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_project' => array(
			'user_company_id' => 'int',
			'project_name' => 'string'
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
		'id' => 'project_id',

		'project_type_id' => 'project_type_id',
		'user_company_id' => 'user_company_id',
		'contracting_entity_id' => 'contracting_entity_id',
		'qb_customer_id' => 'qb_customer_id',
		'user_custom_project_id' => 'user_custom_project_id',
		'project_name' => 'project_name',

		'project_owner_name' => 'project_owner_name',
		'latitude' => 'latitude',
		'longitude' => 'longitude',
		'address_line_1' => 'address_line_1',
		'address_line_2' => 'address_line_2',
		'address_line_3' => 'address_line_3',
		'address_line_4' => 'address_line_4',
		'address_city' => 'address_city',
		'address_county' => 'address_county',
		'address_state_or_region' => 'address_state_or_region',
		'address_postal_code' => 'address_postal_code',
		'address_postal_code_extension' => 'address_postal_code_extension',
		'address_country' => 'address_country',
		'building_count' => 'building_count',
		'unit_count' => 'unit_count',
		'gross_square_footage' => 'gross_square_footage',
		'net_rentable_square_footage' => 'net_rentable_square_footage',
		'is_active_flag' => 'is_active_flag',
		'public_plans_flag' => 'public_plans_flag',
		'prevailing_wage_flag' => 'prevailing_wage_flag',
		'city_business_license_required_flag' => 'city_business_license_required_flag',
		'is_internal_flag' => 'is_internal_flag',
		'project_contract_date' => 'project_contract_date',
		'project_start_date' => 'project_start_date',
		'project_completed_date' => 'project_completed_date',
		'sort_order' => 'sort_order',
		'retainer_rate' => 'retainer_rate',
		'max_retention_cap' => 'max_retention_cap',
		'draw_template_id' => 'draw_template_id',
		'time_zone_id' => 'time_zone_id',
		'delivery_time_id' => 'delivery_time_id',
		'delivery_time' => 'delivery_time',
		'max_photos_displayed'=> 'max_photos_displayed',
		'photos_displayed_per_page'=>'photos_displayed_per_page',
		'COR_type' => 'COR_type',
		'alias_type' =>'alias_type',
		'is_subtotal' => 'is_subtotal',
		'owner_address'=>'owner_address',
		'owner_city'=>'owner_city',
		'owner_state_or_region'=>'owner_state_or_region',
		'owner_postal_code'=>'owner_postal_code',
		'architect_cmpy_id'=>'architect_cmpy_id',
		'architect_cont_id'=>'architect_cont_id',

	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_id;

	public $project_type_id;
	public $user_company_id;

	public $user_custom_project_id;
	public $project_name;

	public $project_owner_name;
	public $owner_address; 
	public $owner_city; 
	public $owner_state_or_region; 
	public $owner_postal_code;
	public $latitude;
	public $longitude;
	public $address_line_1;
	public $address_line_2;
	public $address_line_3;
	public $address_line_4;
	public $address_city;
	public $address_county;
	public $address_state_or_region;
	public $address_postal_code;
	public $address_postal_code_extension;
	public $address_country;
	public $building_count;
	public $unit_count;
	public $gross_square_footage;
	public $net_rentable_square_footage;
	public $is_active_flag;
	public $public_plans_flag;
	public $prevailing_wage_flag;
	public $city_business_license_required_flag;
	public $is_internal_flag;
	public $project_contract_date;
	public $project_start_date;
	public $project_completed_date;
	public $sort_order;
	public $retainer_rate;
	public $draw_template_id;
	public $time_zone_id;
	public $delivery_time_id;
	public $delivery_time;
	public $max_photos_displayed;
	public $COR_type;
	public $alias_type;
	public $is_subtotal;
	public $architect_cmpy_id;
	public $architect_cont_id;
	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_user_custom_project_id;
	public $escaped_project_name;
	public $escaped_project_owner_name;
	public $escaped_owner_address;   
	public $escaped_owner_city;
	public $escaped_owner_state_or_region;
	public $escaped_owner_postal_code;
	public $escaped_address_line_1;
	public $escaped_address_line_2;
	public $escaped_address_line_3;
	public $escaped_address_line_4;
	public $escaped_address_city;
	public $escaped_address_county;
	public $escaped_address_state_or_region;
	public $escaped_address_postal_code;
	public $escaped_address_postal_code_extension;
	public $escaped_address_country;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_user_custom_project_id_nl2br;
	public $escaped_project_name_nl2br;
	public $escaped_project_owner_name_nl2br;
	public $escaped_owner_address_nl2br;   
	public $escaped_owner_city_nl2br;
	public $escaped_owner_state_or_region_nl2br;
	public $escaped_owner_postal_code_nl2br;
	public $escaped_address_line_1_nl2br;
	public $escaped_address_line_2_nl2br;
	public $escaped_address_line_3_nl2br;
	public $escaped_address_line_4_nl2br;
	public $escaped_address_city_nl2br;
	public $escaped_address_county_nl2br;
	public $escaped_address_state_or_region_nl2br;
	public $escaped_address_postal_code_nl2br;
	public $escaped_address_postal_code_extension_nl2br;
	public $escaped_address_country_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrProjectsByProjectTypeId;
	protected static $_arrProjectsByUserCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjects;

	// Foreign Key Objects
	private $_projectType;
	private $_userCompany;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='projects')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getProjectType()
	{
		if (isset($this->_projectType)) {
			return $this->_projectType;
		} else {
			return null;
		}
	}

	public function setProjectType($projectType)
	{
		$this->_projectType = $projectType;
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public function getArrProjectsByProjectTypeId()
	{
		if (isset(self::$_arrProjectsByProjectTypeId)) {
			return self::$_arrProjectsByProjectTypeId;
		} else {
			return null;
		}
	}

	public function setArrProjectsByProjectTypeId($arrProjectsByProjectTypeId)
	{
		self::$_arrProjectsByProjectTypeId = $arrProjectsByProjectTypeId;
	}

	public function getArrProjectsByUserCompanyId()
	{
		if (isset(self::$_arrProjectsByUserCompanyId)) {
			return self::$_arrProjectsByUserCompanyId;
		} else {
			return null;
		}
	}

	public function setArrProjectsByUserCompanyId($arrProjectsByUserCompanyId)
	{
		self::$_arrProjectsByUserCompanyId = $arrProjectsByUserCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public function getArrAllProjects()
	{
		if (isset(self::$_arrAllProjects)) {
			return self::$_arrAllProjects;
		} else {
			return null;
		}
	}

	public function setArrAllProjects($arrAllProjects)
	{
		self::$_arrAllProjects = $arrAllProjects;
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
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $project_id,$table='projects', $module='Project')
	{
		$project = parent::findById($database, $project_id,  $table, $module);

		return $project;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findProjectByIdExtended($database, $project_id)
	{
		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		$db->free_result();
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	p_fk_pt.`id` AS 'p_fk_pt__project_type_id',
	p_fk_pt.`user_company_id` AS 'p_fk_pt__user_company_id',
	p_fk_pt.`construction_type` AS 'p_fk_pt__construction_type',
	p_fk_pt.`project_type` AS 'p_fk_pt__project_type',
	p_fk_pt.`project_type_label` AS 'p_fk_pt__project_type_label',
	p_fk_pt.`project_type_description` AS 'p_fk_pt__project_type_description',
	p_fk_pt.`hidden_flag` AS 'p_fk_pt__hidden_flag',
	p_fk_pt.`disabled_flag` AS 'p_fk_pt__disabled_flag',
	p_fk_pt.`sort_order` AS 'p_fk_pt__sort_order',

	p_fk_uc.`id` AS 'p_fk_uc__user_company_id',
	p_fk_uc.`company` AS 'p_fk_uc__company',
	p_fk_uc.`primary_phone_number` AS 'p_fk_uc__primary_phone_number',
	p_fk_uc.`employer_identification_number` AS 'p_fk_uc__employer_identification_number',
	p_fk_uc.`construction_license_number` AS 'p_fk_uc__construction_license_number',
	p_fk_uc.`construction_license_number_expiration_date` AS 'p_fk_uc__construction_license_number_expiration_date',
	p_fk_uc.`paying_customer_flag` AS 'p_fk_uc__paying_customer_flag',

	p.*

FROM `projects` p
	INNER JOIN `project_types` p_fk_pt ON p.`project_type_id` = p_fk_pt.`id`
	INNER JOIN `user_companies` p_fk_uc ON p.`user_company_id` = p_fk_uc.`id`
WHERE p.`id` = ?
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$project_id = $row['id'];
			$project = self::instantiateOrm($database, 'Project', $row, null, $project_id);
			/* @var $project Project */
			$project->convertPropertiesToData();

			if (isset($row['project_type_id'])) {
				$project_type_id = $row['project_type_id'];
				$row['p_fk_pt__id'] = $project_type_id;
				$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id, 'p_fk_pt__');
				/* @var $projectType ProjectType */
				$projectType->convertPropertiesToData();
			} else {
				$projectType = false;
			}
			$project->setProjectType($projectType);

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['p_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'p_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$project->setUserCompany($userCompany);

			return $project;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_project` (`user_company_id`,`project_name`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $project_name
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndProjectName($database, $user_company_id, $project_name)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	p.*

FROM `projects` p
WHERE p.`user_company_id` = ?
AND p.`project_name` = ?
";
		$arrValues = array($user_company_id, $project_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$project_id = $row['id'];
			$project = self::instantiateOrm($database, 'Project', $row, null, $project_id);
			/* @var $project Project */
			return $project;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrProjectIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsByArrProjectIds($database, $arrProjectIds, Input $options=null)
	{
		if (empty($arrProjectIds)) {
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
		// ORDER BY `id` ASC, `project_type_id` ASC, `user_company_id` ASC, `user_custom_project_id` ASC, `project_name` ASC, `project_owner_name` ASC, `latitude` ASC, `longitude` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `building_count` ASC, `unit_count` ASC, `gross_square_footage` ASC, `net_rentable_square_footage` ASC, `is_active_flag` ASC, `public_plans_flag` ASC, `prevailing_wage_flag` ASC, `city_business_license_required_flag` ASC, `is_internal_flag` ASC, `project_contract_date` ASC, `project_start_date` ASC, `project_completed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY p.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProject = new Project($database);
			$sqlOrderByColumns = $tmpProject->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrProjectIds as $k => $project_id) {
			$project_id = (int) $project_id;
			$arrProjectIds[$k] = $db->escape($project_id);
		}
		$csvProjectIds = join(',', $arrProjectIds);

		$query =
"
SELECT

	p.*

FROM `projects` p
WHERE p.`id` IN ($csvProjectIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrProjectsByCsvProjectIds = array();
		while ($row = $db->fetch()) {
			$project_id = $row['id'];
			$project = self::instantiateOrm($database, 'Project', $row, null, $project_id);
			/* @var $project Project */
			$project->convertPropertiesToData();

			$arrProjectsByCsvProjectIds[$project_id] = $project;
		}

		$db->free_result();

		return $arrProjectsByCsvProjectIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `projects_fk_pt` foreign key (`project_type_id`) references `project_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $project_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsByProjectTypeId($database, $project_type_id, Input $options=null)
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
			self::$_arrProjectsByProjectTypeId = null;
		}

		$arrProjectsByProjectTypeId = self::$_arrProjectsByProjectTypeId;
		if (isset($arrProjectsByProjectTypeId) && !empty($arrProjectsByProjectTypeId)) {
			return $arrProjectsByProjectTypeId;
		}

		$project_type_id = (int) $project_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_type_id` ASC, `user_company_id` ASC, `user_custom_project_id` ASC, `project_name` ASC, `project_owner_name` ASC, `latitude` ASC, `longitude` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `building_count` ASC, `unit_count` ASC, `gross_square_footage` ASC, `net_rentable_square_footage` ASC, `is_active_flag` ASC, `public_plans_flag` ASC, `prevailing_wage_flag` ASC, `city_business_license_required_flag` ASC, `is_internal_flag` ASC, `project_contract_date` ASC, `project_start_date` ASC, `project_completed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY p.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProject = new Project($database);
			$sqlOrderByColumns = $tmpProject->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p.*

FROM `projects` p
WHERE p.`project_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_type_id` ASC, `user_company_id` ASC, `user_custom_project_id` ASC, `project_name` ASC, `project_owner_name` ASC, `latitude` ASC, `longitude` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `building_count` ASC, `unit_count` ASC, `gross_square_footage` ASC, `net_rentable_square_footage` ASC, `is_active_flag` ASC, `public_plans_flag` ASC, `prevailing_wage_flag` ASC, `city_business_license_required_flag` ASC, `is_internal_flag` ASC, `project_contract_date` ASC, `project_start_date` ASC, `project_completed_date` ASC, `sort_order` ASC
		$arrValues = array($project_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsByProjectTypeId = array();
		while ($row = $db->fetch()) {
			$project_id = $row['id'];
			$project = self::instantiateOrm($database, 'Project', $row, null, $project_id);
			/* @var $project Project */
			$arrProjectsByProjectTypeId[$project_id] = $project;
		}

		$db->free_result();

		self::$_arrProjectsByProjectTypeId = $arrProjectsByProjectTypeId;

		return $arrProjectsByProjectTypeId;
	}

	/**
	 * Load by constraint `projects_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrProjectsByUserCompanyId = null;
		}

		$arrProjectsByUserCompanyId = self::$_arrProjectsByUserCompanyId;
		if (isset($arrProjectsByUserCompanyId) && !empty($arrProjectsByUserCompanyId)) {
			return $arrProjectsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_type_id` ASC, `user_company_id` ASC, `user_custom_project_id` ASC, `project_name` ASC, `project_owner_name` ASC, `latitude` ASC, `longitude` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `building_count` ASC, `unit_count` ASC, `gross_square_footage` ASC, `net_rentable_square_footage` ASC, `is_active_flag` ASC, `public_plans_flag` ASC, `prevailing_wage_flag` ASC, `city_business_license_required_flag` ASC, `is_internal_flag` ASC, `project_contract_date` ASC, `project_start_date` ASC, `project_completed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY p.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProject = new Project($database);
			$sqlOrderByColumns = $tmpProject->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p.*

FROM `projects` p
WHERE p.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_type_id` ASC, `user_company_id` ASC, `user_custom_project_id` ASC, `project_name` ASC, `project_owner_name` ASC, `latitude` ASC, `longitude` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `building_count` ASC, `unit_count` ASC, `gross_square_footage` ASC, `net_rentable_square_footage` ASC, `is_active_flag` ASC, `public_plans_flag` ASC, `prevailing_wage_flag` ASC, `city_business_license_required_flag` ASC, `is_internal_flag` ASC, `project_contract_date` ASC, `project_start_date` ASC, `project_completed_date` ASC, `sort_order` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$project_id = $row['id'];
			$project = self::instantiateOrm($database, 'Project', $row, null, $project_id);
			/* @var $project Project */
			$arrProjectsByUserCompanyId[$project_id] = $project;
		}

		$db->free_result();

		self::$_arrProjectsByUserCompanyId = $arrProjectsByUserCompanyId;

		return $arrProjectsByUserCompanyId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all projects records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllProjects($database, Input $options=null)
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
			self::$_arrAllProjects = null;
		}

		$arrAllProjects = self::$_arrAllProjects;
		if (isset($arrAllProjects) && !empty($arrAllProjects)) {
			return $arrAllProjects;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_type_id` ASC, `user_company_id` ASC, `user_custom_project_id` ASC, `project_name` ASC, `project_owner_name` ASC, `latitude` ASC, `longitude` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `building_count` ASC, `unit_count` ASC, `gross_square_footage` ASC, `net_rentable_square_footage` ASC, `is_active_flag` ASC, `public_plans_flag` ASC, `prevailing_wage_flag` ASC, `city_business_license_required_flag` ASC, `is_internal_flag` ASC, `project_contract_date` ASC, `project_start_date` ASC, `project_completed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY p.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProject = new Project($database);
			$sqlOrderByColumns = $tmpProject->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p.*

FROM `projects` p{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_type_id` ASC, `user_company_id` ASC, `user_custom_project_id` ASC, `project_name` ASC, `project_owner_name` ASC, `latitude` ASC, `longitude` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `building_count` ASC, `unit_count` ASC, `gross_square_footage` ASC, `net_rentable_square_footage` ASC, `is_active_flag` ASC, `public_plans_flag` ASC, `prevailing_wage_flag` ASC, `city_business_license_required_flag` ASC, `is_internal_flag` ASC, `project_contract_date` ASC, `project_start_date` ASC, `project_completed_date` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjects = array();
		while ($row = $db->fetch()) {
			$project_id = $row['id'];
			$project = self::instantiateOrm($database, 'Project', $row, null, $project_id);
			/* @var $project Project */
			$arrAllProjects[$project_id] = $project;
		}

		$db->free_result();

		self::$_arrAllProjects = $arrAllProjects;

		return $arrAllProjects;
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
INTO `projects`
(`project_type_id`, `user_company_id`, `user_custom_project_id`, `project_name`, `project_owner_name`, `latitude`, `longitude`, `address_line_1`, `address_line_2`, `address_line_3`, `address_line_4`, `address_city`, `address_county`, `address_state_or_region`, `address_postal_code`, `address_postal_code_extension`, `address_country`, `building_count`, `unit_count`, `gross_square_footage`, `net_rentable_square_footage`, `is_active_flag`, `public_plans_flag`, `prevailing_wage_flag`, `city_business_license_required_flag`, `is_internal_flag`, `project_contract_date`, `project_start_date`, `project_completed_date`, `sort_order`, `time_zone_id`, `delivery_time_id`, `delivery_time`,`max_photos_displayed`,`owner_address`,`owner_city`,`owner_state_or_region`,`owner_postal_code`,`architect_cmpy_id`,`architect_cont_id`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `project_type_id` = ?, `user_custom_project_id` = ?, `project_owner_name` = ?, `latitude` = ?, `longitude` = ?, `address_line_1` = ?, `address_line_2` = ?, `address_line_3` = ?, `address_line_4` = ?, `address_city` = ?, `address_county` = ?, `address_state_or_region` = ?, `address_postal_code` = ?, `address_postal_code_extension` = ?, `address_country` = ?, `building_count` = ?, `unit_count` = ?, `gross_square_footage` = ?, `net_rentable_square_footage` = ?, `is_active_flag` = ?, `public_plans_flag` = ?, `prevailing_wage_flag` = ?, `city_business_license_required_flag` = ?, `is_internal_flag` = ?, `project_contract_date` = ?, `project_start_date` = ?, `project_completed_date` = ?, `sort_order` = ?, `owner_address` = ?, `owner_city` = ?, `owner_state_or_region` = ?,`owner_postal_code` = ?
";
		$arrValues = array($this->project_type_id, $this->user_company_id, $this->user_custom_project_id, $this->project_name, $this->project_owner_name, $this->latitude, $this->longitude, $this->address_line_1, $this->address_line_2, $this->address_line_3, $this->address_line_4, $this->address_city, $this->address_county, $this->address_state_or_region, $this->address_postal_code, $this->address_postal_code_extension, $this->address_country, $this->building_count, $this->unit_count, $this->gross_square_footage, $this->net_rentable_square_footage, $this->is_active_flag, $this->public_plans_flag, $this->prevailing_wage_flag, $this->city_business_license_required_flag, $this->is_internal_flag, $this->project_contract_date, $this->project_start_date, $this->project_completed_date, $this->sort_order, $this->time_zone_id, $this->delivery_time_id, $this->delivery_time,$this->max_photos_displayed,$this->owner_address,$this->owner_city,$this->owner_state_or_region,$this->owner_postal_code,$this->architect_cmpy_id,$this->architect_cont_id,$this->project_type_id, $this->user_custom_project_id, $this->project_owner_name, $this->latitude, $this->longitude, $this->address_line_1, $this->address_line_2, $this->address_line_3, $this->address_line_4, $this->address_city, $this->address_county, $this->address_state_or_region, $this->address_postal_code, $this->address_postal_code_extension, $this->address_country, $this->building_count, $this->unit_count, $this->gross_square_footage, $this->net_rentable_square_footage, $this->is_active_flag, $this->public_plans_flag, $this->prevailing_wage_flag, $this->city_business_license_required_flag, $this->is_internal_flag, $this->project_contract_date, $this->project_start_date, $this->project_completed_date, $this->sort_order,$this->owner_address,$this->owner_city,$this->owner_state_or_region,$this->owner_postal_code);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$project_id = $db->insertId;
		$db->free_result();

		return $project_id;
	}

	// Save: insert ignore

	public static function findProjectById($database, $project_id)
	{
		$db = DBI::getInstance($database);

		$query =
"
SELECT p.*
FROM `projects` p
WHERE p.`id` = ?
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {

			$project = new Project($database);
			$key = array('id' => $project_id);
			$project->setKey($key);
			$project->setId($project_id);
			$project->setData($row);
			$project->convertDataToProperties();

			return $project;

		} else {

			return false;

		}

		return false;
	}

	public static function loadOwnedProjects($database, $userRole, $user_company_id, $user_id, $primary_contact_id)
	{
		$arrOwnedProjectIds = array();

		$db = DBI::getInstance($database);

		// Load "Owned Projects" that the given user has access to
		$loadAllOwnedProjectsFlag = false;
		if (($userRole == "admin") || ($userRole == "global_admin")) {
			$loadAllOwnedProjectsFlag = true;
		} else {
			// Determine if the user has access to all of their companies projects
			// contacts_to_roles is NOT for role-based access across ALL PROJECTS
			// user_companies_to_all_owned_projects_to_contacts_to_roles, user_companies_to_all_owned_projects_to_roles_to_smfs
			// ALWAYS show project regardless of a role being linked to software_module_functions via:
			//		user_companies_to_all_owned_projects_to_roles_to_smfs
			$query =
"
SELECT count(*)
FROM user_companies_to_all_owned_projects_to_contacts_to_roles uc2aop2c2r
WHERE uc2aop2c2r.contact_id = $primary_contact_id
AND uc2aop2c2r.user_company_id = $user_company_id
";
			$db->query($query);
			$row = $db->fetch();
			$db->free_result();
			$total = $row['count(*)'];
			if ($total > 0) {
				$loadAllOwnedProjectsFlag = true;
			}

			if (!$loadAllOwnedProjectsFlag) {
				// Attempt to load lists of project_id values, not just "all projects" since the user does not have all projects access

				// contacts_to_roles is NOT for role-based access across ALL PROJECTS
				// projects_to_contacts_to_roles, projects_to_roles_to_software_module_functions
				// ALWAYS show project regardless of a role being linked to software_module_functions via:
				//		projects_to_roles_to_software_module_functions
				/*
				$query =
"
SELECT distinct(p.`id`)
FROM `projects_to_contacts_to_roles` p2c2r, `projects` p
WHERE p2c2r.`contact_id` = $primary_contact_id
AND p2c2r.`project_id` = p.`id`
AND p.`user_company_id` = $user_company_id
";
				$db->query($query);
				while ($row = $db->fetch()) {
					$tmpProjectId = $row['project_id'];
					$arrOwnedProjectIds[$tmpProjectId] = 1;
				}
				$db->free_result();
				*/

				// projects_to_contacts_to_roles is for role-based access for a SPECIFIC PROJECT ONLY
				// projects_to_contacts_to_roles
				$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
				$query =
"
SELECT distinct(p2c2r.`project_id`)
FROM `projects_to_contacts_to_roles` p2c2r
WHERE p2c2r.`contact_id` = $primary_contact_id
AND p2c2r.`project_id` <> $AXIS_NON_EXISTENT_PROJECT_ID
";
				$db->query($query);
				while ($row = $db->fetch()) {
					$tmpProjectId = $row['project_id'];
					$arrOwnedProjectIds[$tmpProjectId] = 1;
				}
				$db->free_result();
			}
		}

		// Load all "Owned Projects if appropriate
		if ($loadAllOwnedProjectsFlag) {
			$query =
"
SELECT distinct(p.`id`)
FROM `projects` p
WHERE p.`user_company_id` = $user_company_id
";
			$db->query($query);
			$arrOwnedProjectIds = array();
			while ($row = $db->fetch()) {
				$tmpProjectId = $row['id'];
				$arrOwnedProjectIds[$tmpProjectId] = 1;
			}
			$db->free_result();
		}

		// Load project Data from the project_id list
		if (!empty($arrOwnedProjectIds)) {
			$arrOwnedProjectIds = array_keys($arrOwnedProjectIds);
			$in = join(',', $arrOwnedProjectIds);
			$query =
				//"SELECT p.`id`, p.`project_name`, p.`user_company_id`
"
SELECT p.*
FROM `projects` p
WHERE p.`id` IN ($in)
ORDER BY p.`is_active_flag` DESC, p.`project_name` ASC
";
			$db->query($query);

			$arrProjects = array();
			$counter = 0;
			while ($row = $db->fetch()) {
				// Use project_id as the key
				$project_id = $row['id'];
				$arrProjects[$project_id] = $row;

				//$arrProjects[$counter] = $row;
				//$counter++;
			}
			$db->free_result();
		} else {
			$arrProjects = array();
		}

		return $arrProjects;
	}

	/**
	 * user_id provides the linkage to third parties via contacts table FK
	 * and primary_contact_id is how we filter out any "Owned Projects"
	 *
	 * @param string $database
	 * @param string $user_id
	 * @param string $primary_contact_id
	 * @return array
	 */
	public static function loadGuestProjects($database, $user_company_id, $user_id, $primary_contact_id)
	{
		$arrGuestProjectIds = array();

		$db = DBI::getInstance($database);

		// get all guest contact_id values for convenience
		$AXIS_NON_EXISTENT_CONTACT_ID = AXIS_NON_EXISTENT_CONTACT_ID;
		$query =
"
SELECT c.`id` 'contact_id'
FROM contacts c
WHERE c.user_id = $user_id
AND c.user_company_id <> $user_company_id
AND c.`id` NOT IN ($AXIS_NON_EXISTENT_CONTACT_ID, $primary_contact_id)
";
		$db->query($query);

		$arrContactIds = array();
		while($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$arrContactIds[$contact_id] = 1;
		}
		$db->free_result();
		$arrContactIds = array_keys($arrContactIds);
		$contactIdCSV = join(',', $arrContactIds);

		/**
		 * @todo If "All Projects" is selected we can just link the contact_id in to all of the company's project_id
		 * via projects_to_contacts_to_roles or projects_to_contacts_to_software_module_functions
		 */

		// Determine if the user has access to all of a given companies' projects that they are linked to via the contacts table
		// contacts_to_roles is NOT for role-based access across ALL PROJECTS
		// contacts_to_roles, user_companies_to_roles_to_all_owned_projects
		/*
		$query =
"
SELECT p.`id` 'project_id'
FROM contacts c, `projects` p, contacts_to_roles c2r, user_companies_to_roles_to_all_owned_projects uc2r2aop
WHERE c2r.contact_id <> $primary_contact_id
AND uc2r2aop.user_company_id <> $user_company_id
AND uc2r2aop.employee_only_flag = 'N'
AND uc2r2aop.user_company_id = p.user_company_id
AND c2r.role_id = uc2r2aop.role_id

AND c.user_company_id <> $user_company_id
AND c.user_id = $user_id
AND c.`id` <> $primary_contact_id
";
		$db->query($query);

		while($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$arrGuestProjectIds[$project_id] = 1;
		}
		$db->free_result();
		*/

		/*
		// contacts_to_roles is NOT for role-based access across ALL PROJECTS
		// contacts_to_roles, projects_to_roles_to_software_module_functions
		$query =
"
SELECT distinct(p2r2smf.project_id)
FROM contacts c, contacts_to_roles c2r, projects_to_roles_to_software_module_functions p2r2smf
WHERE c2r.contact_id <> $primary_contact_id
AND c.user_company_id <> $user_company_id
AND c.user_id = $user_id
AND c.`id` <> $primary_contact_id
AND c.`id` = c2r.contact_id
AND c2r.role_id = p2r2smf.role_id
";
		$db->query($query);
		while ($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$arrGuestProjectIds[$project_id] = 1;
		}
		$db->free_result();
		*/

		// projects_to_contacts_to_roles is for role-based access for a SPECIFIC PROJECT ONLY
		// projects_to_contacts_to_roles
		$query =
"
SELECT distinct(p2c2r.project_id)
FROM contacts c, projects_to_contacts_to_roles p2c2r
WHERE p2c2r.contact_id <> $primary_contact_id
AND c.user_company_id <> $user_company_id
AND c.user_id = $user_id
AND c.`id` <> $primary_contact_id
AND c.`id` = p2c2r.contact_id
";
		$db->query($query);
		while ($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$arrGuestProjectIds[$project_id] = 1;
		}
		$db->free_result();


		if (!empty($arrGuestProjectIds)) {
			$arrGuestProjectIds = array_keys($arrGuestProjectIds);
			$in = join(',', $arrGuestProjectIds);
			$query =
				//"SELECT p.`id`, p.`project_name`, p.`user_company_id`
"
SELECT p.*
FROM `projects` p
WHERE p.`id` IN ($in)
ORDER BY p.`is_active_flag` DESC, p.`project_name` ASC
";
			//$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->query($query);

			$arrProjects = array();
			$counter = 0;
			while ($row = $db->fetch()) {
				// Use project_id as the key
				$project_id = $row['id'];
				$arrProjects[$project_id] = $row;

				//$arrProjects[$counter] = $row;
				//$counter++;
			}
			$db->free_result();
		} else {
			$arrProjects = array();
		}

		return $arrProjects;
	}

	/**
	 * user_id provides the linkage to third parties via contacts table FK
	 * and primary_contact_id is how we filter out any "Owned Projects"
	 *
	 * @param string $database
	 * @param string $user_id
	 * @param string $primary_contact_id
	 * @return array
	 */
	public static function loadGuestProjectsWhereContactHasBeenInvitedToBidThroughThePurchasingModule($database, $user_company_id, $user_id, $primary_contact_id)
	{
		$arrGuestProjectIds = array();

		$db = DBI::getInstance($database);

		// Get guest projects where the contact has been invited and the status is not "1=Potential", "6=Not Bidding", "7=Rejected"
		$query =
"
SELECT distinct(gbli.project_id)
FROM contacts c, subcontractor_bids sb, gc_budget_line_items gbli
WHERE sb.subcontractor_contact_id <> $primary_contact_id
AND c.user_company_id <> $user_company_id
AND c.user_id = $user_id
AND c.`id` <> $primary_contact_id
AND c.`id` = sb.subcontractor_contact_id
AND sb.gc_budget_line_item_id = gbli.`id`
AND sb.subcontractor_bid_status_id <> 1 AND sb.subcontractor_bid_status_id <> 6 AND sb.subcontractor_bid_status_id <> 7
";
		$db->query($query);
		while ($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$arrGuestProjectIds[$project_id] = 1;
		}
		$db->free_result();


		if (!empty($arrGuestProjectIds)) {
			$arrGuestProjectIds = array_keys($arrGuestProjectIds);
			$in = join(',', $arrGuestProjectIds);
			$query =
				//"SELECT p.`id`, p.`project_name`, p.`user_company_id`
"
SELECT p.*
FROM `projects` p
WHERE p.`id` IN ($in)
ORDER BY p.`is_active_flag` DESC, p.`project_name` ASC
";
			//$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->query($query);

			$arrProjects = array();
			$counter = 0;
			while ($row = $db->fetch()) {
				// Use project_id as the key
				$project_id = $row['id'];
				$arrProjects[$project_id] = $row;

				//$arrProjects[$counter] = $row;
				//$counter++;
			}
			$db->free_result();
		} else {
			$arrProjects = array();
		}

		return $arrProjects;
	}

	public static function loadProjectsList($database, $user_company_id)
	{
		$db = DBI::getInstance($database);

		$query =
"
SELECT p.*
FROM `projects` p
WHERE p.`user_company_id` = ?
ORDER BY `project_name` ASC
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsList = array();
		$arrProjectOptions = array();
		while ($row = $db->fetch()) {
			$project_id = $row['id'];
			$project_name = $row['project_name'];
			$p = new Project($database);
			$p->setId($project_id);
			$p->setData($row);
			$p->convertDataToProperties();
			// Object list format
			$arrProjectsList[$project_id] = $p;

			// Drop down list format
			$arrProjectOptions[$project_id] = $project_name;
		}
		$db->free_result();

		$arrReturn = array(
			'objects_list' => $arrProjectsList,
			'options_list' => $arrProjectOptions
		);

		return $arrReturn;
	}

	public static function loadCompleteProjectsList($database, $user_id)
	{
		$db = DBI::getInstance($database);

		$arrProjectIds = array();
		$arrOwnedProjectIds = array();

		// projects for the user_company_id for this given user
		// "owned" projects
		$query =
"
SELECT p.`id`
FROM `users` u, `projects` p
WHERE u.`id` = ?
AND u.`user_company_id` = p.`user_company_id`
GROUP BY p.`id`
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		while ($row = $db->fetch()) {
			$project_id = $row['id'];
			$arrProjectIds[$project_id] = 1;
			$arrOwnedProjectIds[$project_id] = 1;
		}
		$db->free_result();

		// projects for contacts linked to projects via contact_roles
		$query =
"
SELECT p2cr2smf.`project_id`
".// `contacts_to_roles` soon to be `contacts_to_contact_roles`
// `projects_to_roles_to_software_module_functions` soon to be `projects_to_contact_roles_to_software_module_functions`
"FROM `contacts` c, `contacts_to_roles` c2cr, `projects_to_roles_to_software_module_functions` p2cr2smf
WHERE c.`user_id` = ?
AND c.`id` = c2cr.`contact_id`
AND c2cr.`role_id` = p2cr2smf.`role_id`
GROUP BY p2cr2smf.`project_id`
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		while ($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$arrProjectIds[$project_id] = 1;
		}
		$db->free_result();

		// projects for directly linked to projects via `projects_to_contacts_to_software_module_functions`
		$query =
"
SELECT p2c2smf.`project_id`
FROM `contacts` c, `projects_to_contacts_to_software_module_functions` p2c2smf
WHERE c.`user_id` = ?
AND c.`id` = p2c2smf.`contact_id`
GROUP BY p2c2smf.`project_id`
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		while ($row = $db->fetch()) {
			$project_id = $row['project_id'];
			$arrProjectIds[$project_id] = 1;
		}
		$db->free_result();

		// Load the projects by project_id
		$arrProjectIds = array_keys($arrProjectIds);
		$in = join(',', $arrProjectIds);
		$query =
"
SELECT p.*
FROM `projects` p
WHERE p.`id` IN($in)
ORDER BY p.`project_name`
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsList = array();
		$arrProjectOptions = array();
		$arrActiveProjects = array();
		$arrBiddingProjects = array();
		$arrCompletedProjects = array();
		$arrOtherProjects = array();
		$arrOwnedProjects = array();
		while ($row = $db->fetch()) {
			$project_id = $row['id'];
			$project_name = $row['project_name'];
			$is_active_flag = $row['is_active_flag'];
			$is_internal_flag = $row['is_internal_flag'];
			$project_completed_date = $row['project_completed_date'];

			if ($is_active_flag == 'Y') {
				$arrActiveProjects[$project_id] = $project_name;
			} elseif ($is_internal_flag == 'Y') {
				$arrBiddingProjects[$project_id] = $project_name;
			} elseif($project_completed_date != '0000-00-00') {
				$arrCompletedProjects[$project_id] = $project_name;
			} else {
				$arrOtherProjects[$project_id] = $project_name;
			}

			$p = new Project($database);
			$p->setId($project_id);
			$p->setData($row);
			$p->convertDataToProperties();
			// Object list format
			$arrProjectsList[$project_id] = $p;

			// Drop down list format
			$arrProjectOptions[$project_id] = $project_name;

			// Projects owned by the user's company
			if (isset($arrOwnedProjectIds[$project_id])) {
				$arrOwnedProjects[$project_id] = $p;
			}
		}
		$db->free_result();

		$arrProjectsByType = array(
			'active_projects' => $arrActiveProjects,
			'bidding_projects' => $arrBiddingProjects,
			'completed_projects' => $arrCompletedProjects,
			'other_projects' => $arrOtherProjects,
		);

		$arrReturn = array(
			'objects_list' => $arrProjectsList,
			'options_list' => $arrProjectOptions,
			'projects_by_type' => $arrProjectsByType
		);

		return $arrReturn;
	}

	public static function loadAllActiveProjects($database,$time_zone_id)
	{
		$db = DBI::getInstance($database);

		$time_zone_id = implode(',', $time_zone_id);

		$query =
"
SELECT p.*
FROM `projects` p
WHERE p.`is_active_flag` = 'Y'
AND ((p.`project_completed_date` = '0000-00-00') || (p.`project_completed_date` >= DATE(now())))
AND p.`id` > 2
AND p.`time_zone_id` IN ($time_zone_id)
";
		$db->query($query);

		$arrAllActiveProjects = array();
		while ($row = $db->fetch()) {
			$project_id = $row['id'];

			$project = self::instantiateOrm($database, 'Project', $row);
			/* @var $project Project */
			$project->convertPropertiesToData();

			$arrAllActiveProjects[$project_id] = $project;
		}
		$db->free_result();

		return $arrAllActiveProjects;
	}

	public static function saveProject($database, $project_id, $arrProjectDetails)
	{
		$db = DBI::getInstance($database);

		$arrKeyMap = array(
			'prime_contract_scheduled_value' => 'prime_contract_scheduled_value',
			'cost_code' => 'cost_code',
			'cost_code_description' => 'cost_code_description',
			'forecasted_expenses' => 'forecasted_expenses',
		);

		foreach ($arrGcBudgetLineItems as $null => $arrTmp) {
			$row = array();
			foreach ($arrTmp as $k => $v) {
				$key = $arrKeyMap[$k];
				$row[$key] = $v;
			}

			$b = new Budget($database);
			$b->setData($row);
			$b->disabled_flag = 'N';
			$b->deltifyAndSave();
		}

		return true;
	}
	/* To get the project main company*/
	public static function ProjectsMainCompany($database,$project_id)
	{
		$db = DBI::getInstance($database);
		$query ="SELECT * FROM `projects` WHERE `id` = '$project_id' ORDER BY `id` DESC ";
		$db->execute($query);
		$row=$db->fetch();
		$main_company=$row['user_company_id'];
		$db->free_result();
		return $main_company;
	}

	/* To get the project main company Api*/
	public static function ProjectsMainCompanyApi($database, $project_id)
	{
		$db = DBI::getInstance($database);
		$query ="SELECT * FROM `projects` WHERE `id` = '$project_id' ORDER BY `id` DESC ";
		$db->execute($query);
		$row=$db->fetch();
		$main_company=$row['user_company_id'];
		$db->free_result();
		return $main_company;
	}
	
	/* To get the project main company*/
	public static function AutoUpdateDatas($table,$column,$primary_id,$new_val)
	{
		$db = DBI::getInstance($database);
		$query ="UPDATE  $table set $column='$new_val' WHERE `id` = '$primary_id' ";
		if($db->execute($query))
		{
			$res_value='1';
		}else
		{
			$res_value='0';
		}
		$db->free_result();
		return $res_value;
	}

	public static function deleteProject($database, $project_id)
	{
		$db = DBI::getInstance($database);

		$arrKeyMap = array(
			'prime_contract_scheduled_value' => 'prime_contract_scheduled_value',
			'cost_code' => 'cost_code',
			'cost_code_description' => 'cost_code_description',
			'forecasted_expenses' => 'forecasted_expenses',
		);

		$query =
"
DELETE FROM `gc_budget_line_items`
WHERE `cost_code`=?
AND `cost_code_description`=?
";

		foreach ($arrGcBudgetLineItems as $null => $arrTmp) {
			$row = array();
			foreach ($arrTmp as $k => $v) {
				$key = $arrKeyMap[$k];
				$row[$key] = $v;
			}
			$cost_code = $row['cost_code'];
			$cost_code_description = $row['cost_code_description'];
			$arrValues = array($cost_code, $cost_code_description);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		return true;
	}


	//To get the project owner name
	public static function getProjectOwner($database,$project_id){

		$db = DBI::getInstance();
        $query = "SELECT  project_owner_name FROM  projects where id='$project_id'";
        $db->execute($query);
		$row = $db->fetch();
        $project_owner_name=$row['project_owner_name'];
		$db->free_result();

		return $project_owner_name;

	}

	//To get the project Type name
	public static function getProjectTypeName($database,$project_type_id){

		$db = DBI::getInstance();
        $query = "SELECT  project_type FROM  project_types where id='$project_type_id'";
        $db->execute($query);
		$row = $db->fetch();
        $project_type=$row['project_type'];
		$db->free_result();

		return $project_type;

	}
	// To check whether COR above the line or below the line
	public static function CORAboveOrBelow($database,$project_id)
	{

		$db = DBI::getInstance();
        $query = "SELECT  COR_type FROM  projects where id=?";
       	$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
        $COR_type=$row['COR_type'];
		$db->free_result();

		return $COR_type;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		// prevent error messages
		$newRecord = false;

		//load existing

		//deltify

		//save (insert, update, or do nothing)

		$newData = $this->getData();
		$row = $newData;

		// These GUIDs taken as a composite are the primary key of gc_budget_line_items
		// <cost_code, cost_code_description>
		$cost_code = $this->cost_code;
		$cost_code_description = $this->cost_code_description;

		$key = array(
			'cost_code' => $cost_code,
			'cost_code_description' => $cost_code_description,
		);

		$database = $this->getDatabase();
		$table = $this->getTable();
		$bi = new Budget($database, $table);
		$bi->setKey($key);
		$bi->load();

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */
		$newData = $row;

		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $bi->isDataLoaded();
		if ($existsFlag) {
			$record_id = $bi->id;

			//Conditionally Update the record
			//Don't compare the key values that loaded the record.
			unset($bi->id);
			unset($bi->modified);
			//unset($bi->created);
			//unset($bi->deleted_flag);

			$existingData = $bi->getData();

			//debug
			/*
			$keyDiffFlag = Data::diffKeys($existingData, $newData);
			if (!$keyDiffFlag) {
				echo "Key:\n".print_r($key, true)."\n\n\n\n";
				echo 'Existing:'."\n";
				ksort($existingData);
				print_r($existingData);
				echo 'New:'."\n";
				ksort($newData);
				print_r($newData);
				$n = array_keys($newData);
				$e = array_keys($existingData);
				$_1 = array_diff_key($n, $e);
				echo 'New:'."\n";
				print_r($_1);
				$_2 = array_diff_key($e, $n);
				echo 'Old:'."\n";
				print_r($_2);
				throw new Exception('Keys mismatch');
			}
			*/

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$bi->setData($data);
				$save = true;
				//$this->updatedRecords++;
			} else {
				$bi->id = $record_id;
				return $bi;
			}
		} else {
			//normalize since record is just being inserted for the first time
			//$this->setData($newData);
			//$this->normalize();
			//$newData = $this->getData();
			//get only the attributes that will go into the details table
			//$newData = array_intersect_key($newData, $arrAttributes);

			//Insert the record
			$bi->setKey(null);
			$bi->setData($newData);
			// Add value for created timestamp.
			$bi->created = null;
			$save = true;
			//$this->insertedRecords++;
		}

		//Save if needed (conditionally Insert/Update)
		if ($save) {
			$id = $bi->save();

			if (isset($id)) {
				$bi->id = $record_id;
			}
		}

		return $bi;
	}
	
	public function getOwnerAddress($database,$project_id){
		$project = Project::findProjectByIdExtended($database,$project_id);
		$projectOwner_address = $project->owner_address;
		$projectOwner_city = $project->owner_city;
		$projectOwner_state = $project->owner_state_or_region;
		$projectOwner_postal_code = $project->owner_postal_code;
		$arr = array();
    	$arr['address'] = $projectOwner_address;
    	$arr['address1'] = $projectOwner_city.($projectOwner_city == '' ? '' : ',').$projectOwner_state.' '.$projectOwner_postal_code;
    	return $arr;
	}

	public function getProjectAddress($database,$project_id){
		$project = Project::findProjectByIdExtended($database,$project_id);
		$project_address = $project->address_line_1;
		$project_city = $project->address_city;
		$project_state = $project->address_state_or_region;
		$project_postal_code = $project->address_postal_code;
		$arr = array();
    	$arr['address'] = $project_address;
    	$arr['address1'] = $project_city.($project_city == '' ? '' : ',').$project_state.' '.$project_postal_code;
    	return $arr;
	}

	public function getContactCompanyAddress($database,$contact_company_id){

		$db = DBI::getInstance();

        $query1 = "SELECT *  FROM `contact_company_offices` WHERE `contact_company_id` = ? AND `head_quarters_flag` = 'Y' ORDER BY id DESC limit 1";
       	$arrValues1 = array($contact_company_id);
		$db->execute($query1, $arrValues1, MYSQLI_USE_RESULT);
		$row1 = $db->fetch();
		$db->free_result();

		$query2 = "SELECT *  FROM `contact_company_offices` WHERE `contact_company_id` = ? AND `head_quarters_flag` = 'N' ORDER BY id DESC limit 1";
       	$arrValues2 = array($contact_company_id);
		$db->execute($query2, $arrValues2, MYSQLI_USE_RESULT);
		$row2 = $db->fetch();
		$db->free_result();

		$arr = array();
		if ($row1) {
			$arr['address'] = $row1['address_line_1'].' '.$row1['address_line_2'];
    		$arr['address1'] = $row1['address_city'].($row1['address_city'] == '' ? '' : ',').$row1['address_state_or_region'].' '.$row1['address_postal_code'];
		}else{ 
			$arr['address'] = $row2['address_line_1'].' '.$row2['address_line_2'];
    		$arr['address1'] = $row2['address_city'].($row2['address_city'] == '' ? '' : ',').$row2['address_state_or_region'].' '.$row2['address_postal_code'];
		}			
    	return $arr;
	}



	// Finders: Find By Unique Index
	/**
	 * Find by QB customer name (`qb_customer_id`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $project_name
	 * @return mixed (single ORM object | false)
	 */
	public static function findByQBCustomer($database, $qb_customer_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	p.*

FROM `qb_customers` p
WHERE p.`id` = ?
";
		$arrValues = array($qb_customer_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {			
			return $row;
		} else {
			return false;
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

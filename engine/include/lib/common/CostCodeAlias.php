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
 * CostCodeAlias.
 *
 * @category   Framework
 * @package    CostCodeAlias
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class CostCodeAlias extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'CostCodeAlias';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'cost_code_aliases';

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
	 * unique index `unique_cost_code_alias` (`user_company_id`,`project_id`,`cost_code_id`,`contact_company_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_cost_code_alias' => array(
			'user_company_id' => 'int',
			'project_id' => 'int',
			'cost_code_id' => 'int',
			'contact_company_id' => 'int'
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
		'id' => 'cost_code_alias_id',

		'user_company_id' => 'user_company_id',
		'project_id' => 'project_id',
		'cost_code_id' => 'cost_code_id',
		'contact_company_id' => 'contact_company_id',

		'cost_code_division_alias_id' => 'cost_code_division_alias_id',

		'cost_code_alias' => 'cost_code_alias',
		'cost_code_description_alias' => 'cost_code_description_alias',
		'cost_code_description_abbreviation_alias' => 'cost_code_description_abbreviation_alias'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $cost_code_alias_id;

	public $user_company_id;
	public $project_id;
	public $cost_code_id;
	public $contact_company_id;

	public $cost_code_division_alias_id;

	public $cost_code_alias;
	public $cost_code_description_alias;
	public $cost_code_description_abbreviation_alias;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_cost_code_alias;
	public $escaped_cost_code_description_alias;
	public $escaped_cost_code_description_abbreviation_alias;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_cost_code_alias_nl2br;
	public $escaped_cost_code_description_alias_nl2br;
	public $escaped_cost_code_description_abbreviation_alias_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrCostCodeAliasesByUserCompanyId;
	protected static $_arrCostCodeAliasesByProjectId;
	protected static $_arrCostCodeAliasesByCostCodeId;
	protected static $_arrCostCodeAliasesByContactCompanyId;
	protected static $_arrCostCodeAliasesByCostCodeDivisionAliasId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllCostCodeAliases;

	// Foreign Key Objects
	private $_userCompany;
	private $_project;
	private $_costCode;
	private $_contactCompany;
	private $_costCodeDivisionAlias;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='cost_code_aliases')
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

	public function getCostCode()
	{
		if (isset($this->_costCode)) {
			return $this->_costCode;
		} else {
			return null;
		}
	}

	public function setCostCode($costCode)
	{
		$this->_costCode = $costCode;
	}

	public function getContactCompany()
	{
		if (isset($this->_contactCompany)) {
			return $this->_contactCompany;
		} else {
			return null;
		}
	}

	public function setContactCompany($contactCompany)
	{
		$this->_contactCompany = $contactCompany;
	}

	public function getCostCodeDivisionAlias()
	{
		if (isset($this->_costCodeDivisionAlias)) {
			return $this->_costCodeDivisionAlias;
		} else {
			return null;
		}
	}

	public function setCostCodeDivisionAlias($costCodeDivisionAlias)
	{
		$this->_costCodeDivisionAlias = $costCodeDivisionAlias;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrCostCodeAliasesByUserCompanyId()
	{
		if (isset(self::$_arrCostCodeAliasesByUserCompanyId)) {
			return self::$_arrCostCodeAliasesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeAliasesByUserCompanyId($arrCostCodeAliasesByUserCompanyId)
	{
		self::$_arrCostCodeAliasesByUserCompanyId = $arrCostCodeAliasesByUserCompanyId;
	}

	public static function getArrCostCodeAliasesByProjectId()
	{
		if (isset(self::$_arrCostCodeAliasesByProjectId)) {
			return self::$_arrCostCodeAliasesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeAliasesByProjectId($arrCostCodeAliasesByProjectId)
	{
		self::$_arrCostCodeAliasesByProjectId = $arrCostCodeAliasesByProjectId;
	}

	public static function getArrCostCodeAliasesByCostCodeId()
	{
		if (isset(self::$_arrCostCodeAliasesByCostCodeId)) {
			return self::$_arrCostCodeAliasesByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeAliasesByCostCodeId($arrCostCodeAliasesByCostCodeId)
	{
		self::$_arrCostCodeAliasesByCostCodeId = $arrCostCodeAliasesByCostCodeId;
	}

	public static function getArrCostCodeAliasesByContactCompanyId()
	{
		if (isset(self::$_arrCostCodeAliasesByContactCompanyId)) {
			return self::$_arrCostCodeAliasesByContactCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeAliasesByContactCompanyId($arrCostCodeAliasesByContactCompanyId)
	{
		self::$_arrCostCodeAliasesByContactCompanyId = $arrCostCodeAliasesByContactCompanyId;
	}

	public static function getArrCostCodeAliasesByCostCodeDivisionAliasId()
	{
		if (isset(self::$_arrCostCodeAliasesByCostCodeDivisionAliasId)) {
			return self::$_arrCostCodeAliasesByCostCodeDivisionAliasId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeAliasesByCostCodeDivisionAliasId($arrCostCodeAliasesByCostCodeDivisionAliasId)
	{
		self::$_arrCostCodeAliasesByCostCodeDivisionAliasId = $arrCostCodeAliasesByCostCodeDivisionAliasId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId()
	{
		if (isset(self::$_arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId)) {
			return self::$_arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId($arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId)
	{
		self::$_arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId = $arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllCostCodeAliases()
	{
		if (isset(self::$_arrAllCostCodeAliases)) {
			return self::$_arrAllCostCodeAliases;
		} else {
			return null;
		}
	}

	public static function setArrAllCostCodeAliases($arrAllCostCodeAliases)
	{
		self::$_arrAllCostCodeAliases = $arrAllCostCodeAliases;
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
	 * @param int $cost_code_alias_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $cost_code_alias_id, $table='cost_code_aliases', $module='CostCodeAlias')
	{
		$costCodeAlias = parent::findById($database, $cost_code_alias_id, $table, $module);

		return $costCodeAlias;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $cost_code_alias_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findCostCodeAliasByIdExtended($database, $cost_code_alias_id)
	{
		$cost_code_alias_id = (int) $cost_code_alias_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	cca_fk_uc.`id` AS 'cca_fk_uc__user_company_id',
	cca_fk_uc.`company` AS 'cca_fk_uc__company',
	cca_fk_uc.`primary_phone_number` AS 'cca_fk_uc__primary_phone_number',
	cca_fk_uc.`employer_identification_number` AS 'cca_fk_uc__employer_identification_number',
	cca_fk_uc.`construction_license_number` AS 'cca_fk_uc__construction_license_number',
	cca_fk_uc.`construction_license_number_expiration_date` AS 'cca_fk_uc__construction_license_number_expiration_date',
	cca_fk_uc.`paying_customer_flag` AS 'cca_fk_uc__paying_customer_flag',

	cca_fk_p.`id` AS 'cca_fk_p__project_id',
	cca_fk_p.`project_type_id` AS 'cca_fk_p__project_type_id',
	cca_fk_p.`user_company_id` AS 'cca_fk_p__user_company_id',
	cca_fk_p.`user_custom_project_id` AS 'cca_fk_p__user_custom_project_id',
	cca_fk_p.`project_name` AS 'cca_fk_p__project_name',
	cca_fk_p.`project_owner_name` AS 'cca_fk_p__project_owner_name',
	cca_fk_p.`latitude` AS 'cca_fk_p__latitude',
	cca_fk_p.`longitude` AS 'cca_fk_p__longitude',
	cca_fk_p.`address_line_1` AS 'cca_fk_p__address_line_1',
	cca_fk_p.`address_line_2` AS 'cca_fk_p__address_line_2',
	cca_fk_p.`address_line_3` AS 'cca_fk_p__address_line_3',
	cca_fk_p.`address_line_4` AS 'cca_fk_p__address_line_4',
	cca_fk_p.`address_city` AS 'cca_fk_p__address_city',
	cca_fk_p.`address_county` AS 'cca_fk_p__address_county',
	cca_fk_p.`address_state_or_region` AS 'cca_fk_p__address_state_or_region',
	cca_fk_p.`address_postal_code` AS 'cca_fk_p__address_postal_code',
	cca_fk_p.`address_postal_code_extension` AS 'cca_fk_p__address_postal_code_extension',
	cca_fk_p.`address_country` AS 'cca_fk_p__address_country',
	cca_fk_p.`building_count` AS 'cca_fk_p__building_count',
	cca_fk_p.`unit_count` AS 'cca_fk_p__unit_count',
	cca_fk_p.`gross_square_footage` AS 'cca_fk_p__gross_square_footage',
	cca_fk_p.`net_rentable_square_footage` AS 'cca_fk_p__net_rentable_square_footage',
	cca_fk_p.`is_active_flag` AS 'cca_fk_p__is_active_flag',
	cca_fk_p.`public_plans_flag` AS 'cca_fk_p__public_plans_flag',
	cca_fk_p.`prevailing_wage_flag` AS 'cca_fk_p__prevailing_wage_flag',
	cca_fk_p.`city_business_license_required_flag` AS 'cca_fk_p__city_business_license_required_flag',
	cca_fk_p.`is_internal_flag` AS 'cca_fk_p__is_internal_flag',
	cca_fk_p.`project_contract_date` AS 'cca_fk_p__project_contract_date',
	cca_fk_p.`project_start_date` AS 'cca_fk_p__project_start_date',
	cca_fk_p.`project_completed_date` AS 'cca_fk_p__project_completed_date',
	cca_fk_p.`sort_order` AS 'cca_fk_p__sort_order',

	cca_fk_codes.`id` AS 'cca_fk_codes__cost_code_id',
	cca_fk_codes.`cost_code_division_id` AS 'cca_fk_codes__cost_code_division_id',
	cca_fk_codes.`cost_code` AS 'cca_fk_codes__cost_code',
	cca_fk_codes.`cost_code_description` AS 'cca_fk_codes__cost_code_description',
	cca_fk_codes.`cost_code_description_abbreviation` AS 'cca_fk_codes__cost_code_description_abbreviation',
	cca_fk_codes.`sort_order` AS 'cca_fk_codes__sort_order',
	cca_fk_codes.`disabled_flag` AS 'cca_fk_codes__disabled_flag',

	cca_fk_cc.`id` AS 'cca_fk_cc__contact_company_id',
	cca_fk_cc.`user_user_company_id` AS 'cca_fk_cc__user_user_company_id',
	cca_fk_cc.`contact_user_company_id` AS 'cca_fk_cc__contact_user_company_id',
	cca_fk_cc.`company` AS 'cca_fk_cc__company',
	cca_fk_cc.`primary_phone_number` AS 'cca_fk_cc__primary_phone_number',
	cca_fk_cc.`employer_identification_number` AS 'cca_fk_cc__employer_identification_number',
	cca_fk_cc.`construction_license_number` AS 'cca_fk_cc__construction_license_number',
	cca_fk_cc.`construction_license_number_expiration_date` AS 'cca_fk_cc__construction_license_number_expiration_date',
	cca_fk_cc.`vendor_flag` AS 'cca_fk_cc__vendor_flag',

	cca_fk_ccda.`id` AS 'cca_fk_ccda__cost_code_division_alias_id',
	cca_fk_ccda.`user_company_id` AS 'cca_fk_ccda__user_company_id',
	cca_fk_ccda.`project_id` AS 'cca_fk_ccda__project_id',
	cca_fk_ccda.`cost_code_division_id` AS 'cca_fk_ccda__cost_code_division_id',
	cca_fk_ccda.`contact_company_id` AS 'cca_fk_ccda__contact_company_id',
	cca_fk_ccda.`division_number_alias` AS 'cca_fk_ccda__division_number_alias',
	cca_fk_ccda.`division_code_heading_alias` AS 'cca_fk_ccda__division_code_heading_alias',
	cca_fk_ccda.`division_alias` AS 'cca_fk_ccda__division_alias',
	cca_fk_ccda.`division_abbreviation_alias` AS 'cca_fk_ccda__division_abbreviation_alias',

	cca.*

FROM `cost_code_aliases` cca
	INNER JOIN `user_companies` cca_fk_uc ON cca.`user_company_id` = cca_fk_uc.`id`
	INNER JOIN `projects` cca_fk_p ON cca.`project_id` = cca_fk_p.`id`
	INNER JOIN `cost_codes` cca_fk_codes ON cca.`cost_code_id` = cca_fk_codes.`id`
	INNER JOIN `contact_companies` cca_fk_cc ON cca.`contact_company_id` = cca_fk_cc.`id`
	LEFT OUTER JOIN `cost_code_division_aliases` cca_fk_ccda ON cca.`cost_code_division_alias_id` = cca_fk_ccda.`id`
WHERE cca.`id` = ?
";
		$arrValues = array($cost_code_alias_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$costCodeAlias->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['cca_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'cca_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$costCodeAlias->setUserCompany($userCompany);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['cca_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'cca_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$costCodeAlias->setProject($project);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['cca_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'cca_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$costCodeAlias->setCostCode($costCode);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['cca_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'cca_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$costCodeAlias->setContactCompany($contactCompany);

			if (isset($row['cost_code_division_alias_id'])) {
				$cost_code_division_alias_id = $row['cost_code_division_alias_id'];
				$row['cca_fk_ccda__id'] = $cost_code_division_alias_id;
				$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id, 'cca_fk_ccda__');
				/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
				$costCodeDivisionAlias->convertPropertiesToData();
			} else {
				$costCodeDivisionAlias = false;
			}
			$costCodeAlias->setCostCodeDivisionAlias($costCodeDivisionAlias);

			return $costCodeAlias;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_cost_code_alias` (`user_company_id`,`project_id`,`cost_code_id`,`contact_company_id`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param int $cost_code_id
	 * @param int $contact_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndProjectIdAndCostCodeIdAndContactCompanyId($database, $user_company_id, $project_id, $cost_code_id, $contact_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cca.*

FROM `cost_code_aliases` cca
WHERE cca.`user_company_id` = ?
AND cca.`project_id` = ?
AND cca.`cost_code_id` = ?
AND cca.`contact_company_id` = ?
";
		$arrValues = array($user_company_id, $project_id, $cost_code_id, $contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			return $costCodeAlias;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrCostCodeAliasIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeAliasesByArrCostCodeAliasIds($database, $arrCostCodeAliasIds, Input $options=null)
	{
		if (empty($arrCostCodeAliasIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeAlias = new CostCodeAlias($database);
			$sqlOrderByColumns = $tmpCostCodeAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrCostCodeAliasIds as $k => $cost_code_alias_id) {
			$cost_code_alias_id = (int) $cost_code_alias_id;
			$arrCostCodeAliasIds[$k] = $db->escape($cost_code_alias_id);
		}
		$csvCostCodeAliasIds = join(',', $arrCostCodeAliasIds);

		$query =
"
SELECT

	cca.*

FROM `cost_code_aliases` cca
WHERE cca.`id` IN ($csvCostCodeAliasIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrCostCodeAliasesByCsvCostCodeAliasIds = array();
		while ($row = $db->fetch()) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$costCodeAlias->convertPropertiesToData();

			$arrCostCodeAliasesByCsvCostCodeAliasIds[$cost_code_alias_id] = $costCodeAlias;
		}

		$db->free_result();

		return $arrCostCodeAliasesByCsvCostCodeAliasIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `cost_code_aliases_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeAliasesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrCostCodeAliasesByUserCompanyId = null;
		}

		$arrCostCodeAliasesByUserCompanyId = self::$_arrCostCodeAliasesByUserCompanyId;
		if (isset($arrCostCodeAliasesByUserCompanyId) && !empty($arrCostCodeAliasesByUserCompanyId)) {
			return $arrCostCodeAliasesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeAlias = new CostCodeAlias($database);
			$sqlOrderByColumns = $tmpCostCodeAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cca.*

FROM `cost_code_aliases` cca
WHERE cca.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeAliasesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$arrCostCodeAliasesByUserCompanyId[$cost_code_alias_id] = $costCodeAlias;
		}

		$db->free_result();

		self::$_arrCostCodeAliasesByUserCompanyId = $arrCostCodeAliasesByUserCompanyId;

		return $arrCostCodeAliasesByUserCompanyId;
	}

	/**
	 * Load by constraint `cost_code_aliases_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeAliasesByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrCostCodeAliasesByProjectId = null;
		}

		$arrCostCodeAliasesByProjectId = self::$_arrCostCodeAliasesByProjectId;
		if (isset($arrCostCodeAliasesByProjectId) && !empty($arrCostCodeAliasesByProjectId)) {
			return $arrCostCodeAliasesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeAlias = new CostCodeAlias($database);
			$sqlOrderByColumns = $tmpCostCodeAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cca.*

FROM `cost_code_aliases` cca
WHERE cca.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeAliasesByProjectId = array();
		while ($row = $db->fetch()) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$arrCostCodeAliasesByProjectId[$cost_code_alias_id] = $costCodeAlias;
		}

		$db->free_result();

		self::$_arrCostCodeAliasesByProjectId = $arrCostCodeAliasesByProjectId;

		return $arrCostCodeAliasesByProjectId;
	}

	/**
	 * Load by constraint `cost_code_aliases_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeAliasesByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrCostCodeAliasesByCostCodeId = null;
		}

		$arrCostCodeAliasesByCostCodeId = self::$_arrCostCodeAliasesByCostCodeId;
		if (isset($arrCostCodeAliasesByCostCodeId) && !empty($arrCostCodeAliasesByCostCodeId)) {
			return $arrCostCodeAliasesByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeAlias = new CostCodeAlias($database);
			$sqlOrderByColumns = $tmpCostCodeAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cca.*

FROM `cost_code_aliases` cca
WHERE cca.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeAliasesByCostCodeId = array();
		while ($row = $db->fetch()) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$arrCostCodeAliasesByCostCodeId[$cost_code_alias_id] = $costCodeAlias;
		}

		$db->free_result();

		self::$_arrCostCodeAliasesByCostCodeId = $arrCostCodeAliasesByCostCodeId;

		return $arrCostCodeAliasesByCostCodeId;
	}

	/**
	 * Load by constraint `cost_code_aliases_fk_cc` foreign key (`contact_company_id`) references `contact_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeAliasesByContactCompanyId($database, $contact_company_id, Input $options=null)
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
			self::$_arrCostCodeAliasesByContactCompanyId = null;
		}

		$arrCostCodeAliasesByContactCompanyId = self::$_arrCostCodeAliasesByContactCompanyId;
		if (isset($arrCostCodeAliasesByContactCompanyId) && !empty($arrCostCodeAliasesByContactCompanyId)) {
			return $arrCostCodeAliasesByContactCompanyId;
		}

		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeAlias = new CostCodeAlias($database);
			$sqlOrderByColumns = $tmpCostCodeAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cca.*

FROM `cost_code_aliases` cca
WHERE cca.`contact_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeAliasesByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$arrCostCodeAliasesByContactCompanyId[$cost_code_alias_id] = $costCodeAlias;
		}

		$db->free_result();

		self::$_arrCostCodeAliasesByContactCompanyId = $arrCostCodeAliasesByContactCompanyId;

		return $arrCostCodeAliasesByContactCompanyId;
	}

	/**
	 * Load by constraint `cost_code_aliases_fk_ccda` foreign key (`cost_code_division_alias_id`) references `cost_code_division_aliases` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_division_alias_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeAliasesByCostCodeDivisionAliasId($database, $cost_code_division_alias_id, Input $options=null)
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
			self::$_arrCostCodeAliasesByCostCodeDivisionAliasId = null;
		}

		$arrCostCodeAliasesByCostCodeDivisionAliasId = self::$_arrCostCodeAliasesByCostCodeDivisionAliasId;
		if (isset($arrCostCodeAliasesByCostCodeDivisionAliasId) && !empty($arrCostCodeAliasesByCostCodeDivisionAliasId)) {
			return $arrCostCodeAliasesByCostCodeDivisionAliasId;
		}

		$cost_code_division_alias_id = (int) $cost_code_division_alias_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeAlias = new CostCodeAlias($database);
			$sqlOrderByColumns = $tmpCostCodeAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cca.*

FROM `cost_code_aliases` cca
WHERE cca.`cost_code_division_alias_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$arrValues = array($cost_code_division_alias_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeAliasesByCostCodeDivisionAliasId = array();
		while ($row = $db->fetch()) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$arrCostCodeAliasesByCostCodeDivisionAliasId[$cost_code_alias_id] = $costCodeAlias;
		}

		$db->free_result();

		self::$_arrCostCodeAliasesByCostCodeDivisionAliasId = $arrCostCodeAliasesByCostCodeDivisionAliasId;

		return $arrCostCodeAliasesByCostCodeDivisionAliasId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `cost_code_aliases_by_contact_company_id` (`user_company_id`,`project_id`,`contact_company_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param int $contact_company_id
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId($database, $user_company_id, $project_id, $contact_company_id, $cost_code_id, Input $options=null)
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
			self::$_arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId = null;
		}

		$arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId = self::$_arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId;
		if (isset($arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId) && !empty($arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId)) {
			return $arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId;
		}

		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;
		$contact_company_id = (int) $contact_company_id;
		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeAlias = new CostCodeAlias($database);
			$sqlOrderByColumns = $tmpCostCodeAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cca.*

FROM `cost_code_aliases` cca
WHERE cca.`user_company_id` = ?
AND cca.`project_id` = ?
AND cca.`contact_company_id` = ?
AND cca.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$arrValues = array($user_company_id, $project_id, $contact_company_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId = array();
		while ($row = $db->fetch()) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId[$cost_code_alias_id] = $costCodeAlias;
		}

		$db->free_result();

		self::$_arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId = $arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId;

		return $arrCostCodeAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeId;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all cost_code_aliases records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllCostCodeAliases($database, Input $options=null)
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
			self::$_arrAllCostCodeAliases = null;
		}

		$arrAllCostCodeAliases = self::$_arrAllCostCodeAliases;
		if (isset($arrAllCostCodeAliases) && !empty($arrAllCostCodeAliases)) {
			return $arrAllCostCodeAliases;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeAlias = new CostCodeAlias($database);
			$sqlOrderByColumns = $tmpCostCodeAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cca.*

FROM `cost_code_aliases` cca{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `contact_company_id` ASC, `cost_code_division_alias_id` ASC, `cost_code_alias` ASC, `cost_code_description_alias` ASC, `cost_code_description_abbreviation_alias` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllCostCodeAliases = array();
		while ($row = $db->fetch()) {
			$cost_code_alias_id = $row['id'];
			$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id);
			/* @var $costCodeAlias CostCodeAlias */
			$arrAllCostCodeAliases[$cost_code_alias_id] = $costCodeAlias;
		}

		$db->free_result();

		self::$_arrAllCostCodeAliases = $arrAllCostCodeAliases;

		return $arrAllCostCodeAliases;
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
INTO `cost_code_aliases`
(`user_company_id`, `project_id`, `cost_code_id`, `contact_company_id`, `cost_code_division_alias_id`, `cost_code_alias`, `cost_code_description_alias`, `cost_code_description_abbreviation_alias`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `cost_code_division_alias_id` = ?, `cost_code_alias` = ?, `cost_code_description_alias` = ?, `cost_code_description_abbreviation_alias` = ?
";
		$arrValues = array($this->user_company_id, $this->project_id, $this->cost_code_id, $this->contact_company_id, $this->cost_code_division_alias_id, $this->cost_code_alias, $this->cost_code_description_alias, $this->cost_code_description_abbreviation_alias, $this->cost_code_division_alias_id, $this->cost_code_alias, $this->cost_code_description_alias, $this->cost_code_description_abbreviation_alias);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$cost_code_alias_id = $db->insertId;
		$db->free_result();

		return $cost_code_alias_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

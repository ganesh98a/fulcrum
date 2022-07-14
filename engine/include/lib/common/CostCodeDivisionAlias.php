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
 * CostCodeDivisionAlias.
 *
 * @category   Framework
 * @package    CostCodeDivisionAlias
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class CostCodeDivisionAlias extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'CostCodeDivisionAlias';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'cost_code_division_aliases';

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
	 * unique index `unique_cost_code_division_alias` (`user_company_id`,`project_id`,`cost_code_division_id`,`contact_company_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_cost_code_division_alias' => array(
			'user_company_id' => 'int',
			'project_id' => 'int',
			'cost_code_division_id' => 'int',
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
		'id' => 'cost_code_division_alias_id',

		'user_company_id' => 'user_company_id',
		'project_id' => 'project_id',
		'cost_code_division_id' => 'cost_code_division_id',
		'contact_company_id' => 'contact_company_id',

		'division_number_alias' => 'division_number_alias',
		'division_code_heading_alias' => 'division_code_heading_alias',
		'division_alias' => 'division_alias',
		'division_abbreviation_alias' => 'division_abbreviation_alias'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $cost_code_division_alias_id;

	public $user_company_id;
	public $project_id;
	public $cost_code_division_id;
	public $contact_company_id;

	public $division_number_alias;
	public $division_code_heading_alias;
	public $division_alias;
	public $division_abbreviation_alias;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_division_number_alias;
	public $escaped_division_code_heading_alias;
	public $escaped_division_alias;
	public $escaped_division_abbreviation_alias;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_division_number_alias_nl2br;
	public $escaped_division_code_heading_alias_nl2br;
	public $escaped_division_alias_nl2br;
	public $escaped_division_abbreviation_alias_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrCostCodeDivisionAliasesByUserCompanyId;
	protected static $_arrCostCodeDivisionAliasesByProjectId;
	protected static $_arrCostCodeDivisionAliasesByCostCodeDivisionId;
	protected static $_arrCostCodeDivisionAliasesByContactCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllCostCodeDivisionAliases;

	// Foreign Key Objects
	private $_userCompany;
	private $_project;
	private $_costCodeDivision;
	private $_contactCompany;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='cost_code_division_aliases')
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

	public function getCostCodeDivision()
	{
		if (isset($this->_costCodeDivision)) {
			return $this->_costCodeDivision;
		} else {
			return null;
		}
	}

	public function setCostCodeDivision($costCodeDivision)
	{
		$this->_costCodeDivision = $costCodeDivision;
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrCostCodeDivisionAliasesByUserCompanyId()
	{
		if (isset(self::$_arrCostCodeDivisionAliasesByUserCompanyId)) {
			return self::$_arrCostCodeDivisionAliasesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionAliasesByUserCompanyId($arrCostCodeDivisionAliasesByUserCompanyId)
	{
		self::$_arrCostCodeDivisionAliasesByUserCompanyId = $arrCostCodeDivisionAliasesByUserCompanyId;
	}

	public static function getArrCostCodeDivisionAliasesByProjectId()
	{
		if (isset(self::$_arrCostCodeDivisionAliasesByProjectId)) {
			return self::$_arrCostCodeDivisionAliasesByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionAliasesByProjectId($arrCostCodeDivisionAliasesByProjectId)
	{
		self::$_arrCostCodeDivisionAliasesByProjectId = $arrCostCodeDivisionAliasesByProjectId;
	}

	public static function getArrCostCodeDivisionAliasesByCostCodeDivisionId()
	{
		if (isset(self::$_arrCostCodeDivisionAliasesByCostCodeDivisionId)) {
			return self::$_arrCostCodeDivisionAliasesByCostCodeDivisionId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionAliasesByCostCodeDivisionId($arrCostCodeDivisionAliasesByCostCodeDivisionId)
	{
		self::$_arrCostCodeDivisionAliasesByCostCodeDivisionId = $arrCostCodeDivisionAliasesByCostCodeDivisionId;
	}

	public static function getArrCostCodeDivisionAliasesByContactCompanyId()
	{
		if (isset(self::$_arrCostCodeDivisionAliasesByContactCompanyId)) {
			return self::$_arrCostCodeDivisionAliasesByContactCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionAliasesByContactCompanyId($arrCostCodeDivisionAliasesByContactCompanyId)
	{
		self::$_arrCostCodeDivisionAliasesByContactCompanyId = $arrCostCodeDivisionAliasesByContactCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId()
	{
		if (isset(self::$_arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId)) {
			return self::$_arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId;
		} else {
			return null;
		}
	}

	public static function setArrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId($arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId)
	{
		self::$_arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId = $arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllCostCodeDivisionAliases()
	{
		if (isset(self::$_arrAllCostCodeDivisionAliases)) {
			return self::$_arrAllCostCodeDivisionAliases;
		} else {
			return null;
		}
	}

	public static function setArrAllCostCodeDivisionAliases($arrAllCostCodeDivisionAliases)
	{
		self::$_arrAllCostCodeDivisionAliases = $arrAllCostCodeDivisionAliases;
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
	 * @param int $cost_code_division_alias_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $cost_code_division_alias_id, $table='cost_code_division_aliases', $module='CostCodeDivisionAlias')
	{
		$costCodeDivisionAlias = parent::findById($database, $cost_code_division_alias_id, $table, $module);

		return $costCodeDivisionAlias;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $cost_code_division_alias_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findCostCodeDivisionAliasByIdExtended($database, $cost_code_division_alias_id)
	{
		$cost_code_division_alias_id = (int) $cost_code_division_alias_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ccda_fk_uc.`id` AS 'ccda_fk_uc__user_company_id',
	ccda_fk_uc.`company` AS 'ccda_fk_uc__company',
	ccda_fk_uc.`primary_phone_number` AS 'ccda_fk_uc__primary_phone_number',
	ccda_fk_uc.`employer_identification_number` AS 'ccda_fk_uc__employer_identification_number',
	ccda_fk_uc.`construction_license_number` AS 'ccda_fk_uc__construction_license_number',
	ccda_fk_uc.`construction_license_number_expiration_date` AS 'ccda_fk_uc__construction_license_number_expiration_date',
	ccda_fk_uc.`paying_customer_flag` AS 'ccda_fk_uc__paying_customer_flag',

	ccda_fk_p.`id` AS 'ccda_fk_p__project_id',
	ccda_fk_p.`project_type_id` AS 'ccda_fk_p__project_type_id',
	ccda_fk_p.`user_company_id` AS 'ccda_fk_p__user_company_id',
	ccda_fk_p.`user_custom_project_id` AS 'ccda_fk_p__user_custom_project_id',
	ccda_fk_p.`project_name` AS 'ccda_fk_p__project_name',
	ccda_fk_p.`project_owner_name` AS 'ccda_fk_p__project_owner_name',
	ccda_fk_p.`latitude` AS 'ccda_fk_p__latitude',
	ccda_fk_p.`longitude` AS 'ccda_fk_p__longitude',
	ccda_fk_p.`address_line_1` AS 'ccda_fk_p__address_line_1',
	ccda_fk_p.`address_line_2` AS 'ccda_fk_p__address_line_2',
	ccda_fk_p.`address_line_3` AS 'ccda_fk_p__address_line_3',
	ccda_fk_p.`address_line_4` AS 'ccda_fk_p__address_line_4',
	ccda_fk_p.`address_city` AS 'ccda_fk_p__address_city',
	ccda_fk_p.`address_county` AS 'ccda_fk_p__address_county',
	ccda_fk_p.`address_state_or_region` AS 'ccda_fk_p__address_state_or_region',
	ccda_fk_p.`address_postal_code` AS 'ccda_fk_p__address_postal_code',
	ccda_fk_p.`address_postal_code_extension` AS 'ccda_fk_p__address_postal_code_extension',
	ccda_fk_p.`address_country` AS 'ccda_fk_p__address_country',
	ccda_fk_p.`building_count` AS 'ccda_fk_p__building_count',
	ccda_fk_p.`unit_count` AS 'ccda_fk_p__unit_count',
	ccda_fk_p.`gross_square_footage` AS 'ccda_fk_p__gross_square_footage',
	ccda_fk_p.`net_rentable_square_footage` AS 'ccda_fk_p__net_rentable_square_footage',
	ccda_fk_p.`is_active_flag` AS 'ccda_fk_p__is_active_flag',
	ccda_fk_p.`public_plans_flag` AS 'ccda_fk_p__public_plans_flag',
	ccda_fk_p.`prevailing_wage_flag` AS 'ccda_fk_p__prevailing_wage_flag',
	ccda_fk_p.`city_business_license_required_flag` AS 'ccda_fk_p__city_business_license_required_flag',
	ccda_fk_p.`is_internal_flag` AS 'ccda_fk_p__is_internal_flag',
	ccda_fk_p.`project_contract_date` AS 'ccda_fk_p__project_contract_date',
	ccda_fk_p.`project_start_date` AS 'ccda_fk_p__project_start_date',
	ccda_fk_p.`project_completed_date` AS 'ccda_fk_p__project_completed_date',
	ccda_fk_p.`sort_order` AS 'ccda_fk_p__sort_order',

	ccda_fk_ccd.`id` AS 'ccda_fk_ccd__cost_code_division_id',
	ccda_fk_ccd.`user_company_id` AS 'ccda_fk_ccd__user_company_id',
	ccda_fk_ccd.`cost_code_type_id` AS 'ccda_fk_ccd__cost_code_type_id',
	ccda_fk_ccd.`division_number` AS 'ccda_fk_ccd__division_number',
	ccda_fk_ccd.`division_code_heading` AS 'ccda_fk_ccd__division_code_heading',
	ccda_fk_ccd.`division` AS 'ccda_fk_ccd__division',
	ccda_fk_ccd.`division_abbreviation` AS 'ccda_fk_ccd__division_abbreviation',
	ccda_fk_ccd.`sort_order` AS 'ccda_fk_ccd__sort_order',
	ccda_fk_ccd.`disabled_flag` AS 'ccda_fk_ccd__disabled_flag',

	ccda_fk_cc.`id` AS 'ccda_fk_cc__contact_company_id',
	ccda_fk_cc.`user_user_company_id` AS 'ccda_fk_cc__user_user_company_id',
	ccda_fk_cc.`contact_user_company_id` AS 'ccda_fk_cc__contact_user_company_id',
	ccda_fk_cc.`company` AS 'ccda_fk_cc__company',
	ccda_fk_cc.`primary_phone_number` AS 'ccda_fk_cc__primary_phone_number',
	ccda_fk_cc.`employer_identification_number` AS 'ccda_fk_cc__employer_identification_number',
	ccda_fk_cc.`construction_license_number` AS 'ccda_fk_cc__construction_license_number',
	ccda_fk_cc.`construction_license_number_expiration_date` AS 'ccda_fk_cc__construction_license_number_expiration_date',
	ccda_fk_cc.`vendor_flag` AS 'ccda_fk_cc__vendor_flag',

	ccda.*

FROM `cost_code_division_aliases` ccda
	INNER JOIN `user_companies` ccda_fk_uc ON ccda.`user_company_id` = ccda_fk_uc.`id`
	INNER JOIN `projects` ccda_fk_p ON ccda.`project_id` = ccda_fk_p.`id`
	INNER JOIN `cost_code_divisions` ccda_fk_ccd ON ccda.`cost_code_division_id` = ccda_fk_ccd.`id`
	INNER JOIN `contact_companies` ccda_fk_cc ON ccda.`contact_company_id` = ccda_fk_cc.`id`
WHERE ccda.`id` = ?
";
		$arrValues = array($cost_code_division_alias_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			$costCodeDivisionAlias->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['ccda_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'ccda_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$costCodeDivisionAlias->setUserCompany($userCompany);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['ccda_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'ccda_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$costCodeDivisionAlias->setProject($project);

			if (isset($row['cost_code_division_id'])) {
				$cost_code_division_id = $row['cost_code_division_id'];
				$row['ccda_fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'ccda_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCodeDivisionAlias->setCostCodeDivision($costCodeDivision);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['ccda_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'ccda_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$costCodeDivisionAlias->setContactCompany($contactCompany);

			return $costCodeDivisionAlias;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_cost_code_division_alias` (`user_company_id`,`project_id`,`cost_code_division_id`,`contact_company_id`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param int $cost_code_division_id
	 * @param int $contact_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndProjectIdAndCostCodeDivisionIdAndContactCompanyId($database, $user_company_id, $project_id, $cost_code_division_id, $contact_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ccda.*

FROM `cost_code_division_aliases` ccda
WHERE ccda.`user_company_id` = ?
AND ccda.`project_id` = ?
AND ccda.`cost_code_division_id` = ?
AND ccda.`contact_company_id` = ?
";
		$arrValues = array($user_company_id, $project_id, $cost_code_division_id, $contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			return $costCodeDivisionAlias;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrCostCodeDivisionAliasIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDivisionAliasesByArrCostCodeDivisionAliasIds($database, $arrCostCodeDivisionAliasIds, Input $options=null)
	{
		if (empty($arrCostCodeDivisionAliasIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivisionAlias = new CostCodeDivisionAlias($database);
			$sqlOrderByColumns = $tmpCostCodeDivisionAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrCostCodeDivisionAliasIds as $k => $cost_code_division_alias_id) {
			$cost_code_division_alias_id = (int) $cost_code_division_alias_id;
			$arrCostCodeDivisionAliasIds[$k] = $db->escape($cost_code_division_alias_id);
		}
		$csvCostCodeDivisionAliasIds = join(',', $arrCostCodeDivisionAliasIds);

		$query =
"
SELECT

	ccda.*

FROM `cost_code_division_aliases` ccda
WHERE ccda.`id` IN ($csvCostCodeDivisionAliasIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrCostCodeDivisionAliasesByCsvCostCodeDivisionAliasIds = array();
		while ($row = $db->fetch()) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			$costCodeDivisionAlias->convertPropertiesToData();

			$arrCostCodeDivisionAliasesByCsvCostCodeDivisionAliasIds[$cost_code_division_alias_id] = $costCodeDivisionAlias;
		}

		$db->free_result();

		return $arrCostCodeDivisionAliasesByCsvCostCodeDivisionAliasIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `cost_code_division_aliases_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDivisionAliasesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrCostCodeDivisionAliasesByUserCompanyId = null;
		}

		$arrCostCodeDivisionAliasesByUserCompanyId = self::$_arrCostCodeDivisionAliasesByUserCompanyId;
		if (isset($arrCostCodeDivisionAliasesByUserCompanyId) && !empty($arrCostCodeDivisionAliasesByUserCompanyId)) {
			return $arrCostCodeDivisionAliasesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivisionAlias = new CostCodeDivisionAlias($database);
			$sqlOrderByColumns = $tmpCostCodeDivisionAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccda.*

FROM `cost_code_division_aliases` ccda
WHERE ccda.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionAliasesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			$arrCostCodeDivisionAliasesByUserCompanyId[$cost_code_division_alias_id] = $costCodeDivisionAlias;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionAliasesByUserCompanyId = $arrCostCodeDivisionAliasesByUserCompanyId;

		return $arrCostCodeDivisionAliasesByUserCompanyId;
	}

	/**
	 * Load by constraint `cost_code_division_aliases_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDivisionAliasesByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrCostCodeDivisionAliasesByProjectId = null;
		}

		$arrCostCodeDivisionAliasesByProjectId = self::$_arrCostCodeDivisionAliasesByProjectId;
		if (isset($arrCostCodeDivisionAliasesByProjectId) && !empty($arrCostCodeDivisionAliasesByProjectId)) {
			return $arrCostCodeDivisionAliasesByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivisionAlias = new CostCodeDivisionAlias($database);
			$sqlOrderByColumns = $tmpCostCodeDivisionAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccda.*

FROM `cost_code_division_aliases` ccda
WHERE ccda.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionAliasesByProjectId = array();
		while ($row = $db->fetch()) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			$arrCostCodeDivisionAliasesByProjectId[$cost_code_division_alias_id] = $costCodeDivisionAlias;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionAliasesByProjectId = $arrCostCodeDivisionAliasesByProjectId;

		return $arrCostCodeDivisionAliasesByProjectId;
	}

	/**
	 * Load by constraint `cost_code_division_aliases_fk_ccd` foreign key (`cost_code_division_id`) references `cost_code_divisions` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_division_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDivisionAliasesByCostCodeDivisionId($database, $cost_code_division_id, Input $options=null)
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
			self::$_arrCostCodeDivisionAliasesByCostCodeDivisionId = null;
		}

		$arrCostCodeDivisionAliasesByCostCodeDivisionId = self::$_arrCostCodeDivisionAliasesByCostCodeDivisionId;
		if (isset($arrCostCodeDivisionAliasesByCostCodeDivisionId) && !empty($arrCostCodeDivisionAliasesByCostCodeDivisionId)) {
			return $arrCostCodeDivisionAliasesByCostCodeDivisionId;
		}

		$cost_code_division_id = (int) $cost_code_division_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivisionAlias = new CostCodeDivisionAlias($database);
			$sqlOrderByColumns = $tmpCostCodeDivisionAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccda.*

FROM `cost_code_division_aliases` ccda
WHERE ccda.`cost_code_division_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$arrValues = array($cost_code_division_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionAliasesByCostCodeDivisionId = array();
		while ($row = $db->fetch()) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			$arrCostCodeDivisionAliasesByCostCodeDivisionId[$cost_code_division_alias_id] = $costCodeDivisionAlias;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionAliasesByCostCodeDivisionId = $arrCostCodeDivisionAliasesByCostCodeDivisionId;

		return $arrCostCodeDivisionAliasesByCostCodeDivisionId;
	}

	/**
	 * Load by constraint `cost_code_division_aliases_fk_cc` foreign key (`contact_company_id`) references `contact_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeDivisionAliasesByContactCompanyId($database, $contact_company_id, Input $options=null)
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
			self::$_arrCostCodeDivisionAliasesByContactCompanyId = null;
		}

		$arrCostCodeDivisionAliasesByContactCompanyId = self::$_arrCostCodeDivisionAliasesByContactCompanyId;
		if (isset($arrCostCodeDivisionAliasesByContactCompanyId) && !empty($arrCostCodeDivisionAliasesByContactCompanyId)) {
			return $arrCostCodeDivisionAliasesByContactCompanyId;
		}

		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivisionAlias = new CostCodeDivisionAlias($database);
			$sqlOrderByColumns = $tmpCostCodeDivisionAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccda.*

FROM `cost_code_division_aliases` ccda
WHERE ccda.`contact_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionAliasesByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			$arrCostCodeDivisionAliasesByContactCompanyId[$cost_code_division_alias_id] = $costCodeDivisionAlias;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionAliasesByContactCompanyId = $arrCostCodeDivisionAliasesByContactCompanyId;

		return $arrCostCodeDivisionAliasesByContactCompanyId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `division_aliases_by_contact_company_id` (`user_company_id`,`project_id`,`contact_company_id`,`cost_code_division_id`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param int $contact_company_id
	 * @param int $cost_code_division_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId($database, $user_company_id, $project_id, $contact_company_id, $cost_code_division_id, Input $options=null)
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
			self::$_arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId = null;
		}

		$arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId = self::$_arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId;
		if (isset($arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId) && !empty($arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId)) {
			return $arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId;
		}

		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;
		$contact_company_id = (int) $contact_company_id;
		$cost_code_division_id = (int) $cost_code_division_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivisionAlias = new CostCodeDivisionAlias($database);
			$sqlOrderByColumns = $tmpCostCodeDivisionAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccda.*

FROM `cost_code_division_aliases` ccda
WHERE ccda.`user_company_id` = ?
AND ccda.`project_id` = ?
AND ccda.`contact_company_id` = ?
AND ccda.`cost_code_division_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$arrValues = array($user_company_id, $project_id, $contact_company_id, $cost_code_division_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId = array();
		while ($row = $db->fetch()) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			$arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId[$cost_code_division_alias_id] = $costCodeDivisionAlias;
		}

		$db->free_result();

		self::$_arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId = $arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId;

		return $arrCostCodeDivisionAliasesByUserCompanyIdAndProjectIdAndContactCompanyIdAndCostCodeDivisionId;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all cost_code_division_aliases records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllCostCodeDivisionAliases($database, Input $options=null)
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
			self::$_arrAllCostCodeDivisionAliases = null;
		}

		$arrAllCostCodeDivisionAliases = self::$_arrAllCostCodeDivisionAliases;
		if (isset($arrAllCostCodeDivisionAliases) && !empty($arrAllCostCodeDivisionAliases)) {
			return $arrAllCostCodeDivisionAliases;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpCostCodeDivisionAlias = new CostCodeDivisionAlias($database);
			$sqlOrderByColumns = $tmpCostCodeDivisionAlias->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccda.*

FROM `cost_code_division_aliases` ccda{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_division_id` ASC, `contact_company_id` ASC, `division_number_alias` ASC, `division_code_heading_alias` ASC, `division_alias` ASC, `division_abbreviation_alias` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllCostCodeDivisionAliases = array();
		while ($row = $db->fetch()) {
			$cost_code_division_alias_id = $row['id'];
			$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id);
			/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
			$arrAllCostCodeDivisionAliases[$cost_code_division_alias_id] = $costCodeDivisionAlias;
		}

		$db->free_result();

		self::$_arrAllCostCodeDivisionAliases = $arrAllCostCodeDivisionAliases;

		return $arrAllCostCodeDivisionAliases;
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
INTO `cost_code_division_aliases`
(`user_company_id`, `project_id`, `cost_code_division_id`, `contact_company_id`, `division_number_alias`, `division_code_heading_alias`, `division_alias`, `division_abbreviation_alias`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `division_number_alias` = ?, `division_code_heading_alias` = ?, `division_alias` = ?, `division_abbreviation_alias` = ?
";
		$arrValues = array($this->user_company_id, $this->project_id, $this->cost_code_division_id, $this->contact_company_id, $this->division_number_alias, $this->division_code_heading_alias, $this->division_alias, $this->division_abbreviation_alias, $this->division_number_alias, $this->division_code_heading_alias, $this->division_alias, $this->division_abbreviation_alias);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$cost_code_division_alias_id = $db->insertId;
		$db->free_result();

		return $cost_code_division_alias_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

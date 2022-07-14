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
 * GcBudgetLineItem.
 *
 * @category   Framework
 * @package    GcBudgetLineItem
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

require_once('lib/common/CostCodeDivision.php');

require_once('lib/common/CostCode.php');

require_once('lib/common/CostCodeDivisionAlias.php');

require_once('lib/common/CostCodeAlias.php');

class GcBudgetLineItem extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'GcBudgetLineItem';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'gc_budget_line_items';

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
	 * unique index `unique_gc_budget_line_item` (`user_company_id`,`project_id`,`cost_code_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_gc_budget_line_item' => array(
			'user_company_id' => 'int',
			'project_id' => 'int',
			'cost_code_id' => 'int'
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
		'id' => 'gc_budget_line_item_id',

		'user_company_id' => 'user_company_id',
		'project_id' => 'project_id',
		'cost_code_id' => 'cost_code_id',

		'modified' => 'modified',
		'prime_contract_scheduled_value' => 'prime_contract_scheduled_value',
		'forecasted_expenses' => 'forecasted_expenses',
		'buyout_forecasted_expenses' => 'buyout_forecasted_expenses',
		'purchasing_target_date' => 'purchasing_target_date',
		'notes' => 'notes',
		'created' => 'created',
		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag',
		'is_dcr_flag' => 'is_dcr_flag',
		'cc_bid' =>'cc_bid'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $gc_budget_line_item_id;

	public $user_company_id;
	public $project_id;
	public $cost_code_id;

	public $modified;
	public $prime_contract_scheduled_value;
	public $forecasted_expenses;
	public $buyout_forecasted_expenses;
	public $purchasing_target_date;
	public $notes;
	public $created;
	public $sort_order;
	public $disabled_flag;
	public $is_dcr_flag;
	public $cc_bid;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrGcBudgetLineItemsByUserCompanyId;
	protected static $_arrGcBudgetLineItemsByProjectId;
	protected static $_arrGcBudgetLineItemsByCostCodeId;
	protected static $_arrGcBudgetLineItemsByUserCompanyIdAndProjectId;
	protected static $_arrGcBudgetLineItemsByCommitedContracts;
	protected static $_arrGcBudgetLineItemsByUnCommitedContracts;
	protected static $_arrCurrentGcBudgetLineItems;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllGcBudgetLineItems;

	// Foreign Key Objects
	private $_userCompany;
	private $_project;
	private $_costCode;

	private $_costCodeDivision;
	private $_contactCompany;
	private $_costCodeAlias;
	private $_costCodeDivisionAlias;
	private $_subcontractorBid;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='gc_budget_line_items')
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

	public function getCostCodeDivision()
	{
		return $this->_costCodeDivision;
	}

	public function setCostCodeDivision($costCodeDivision)
	{
		$this->_costCodeDivision = $costCodeDivision;
	}

	public function getContactCompany()
	{
		return $this->_contactCompany;
	}

	public function setContactCompany($contactCompany)
	{
		$this->_contactCompany = $contactCompany;
	}

	public function getCostCodeAlias()
	{
		return $this->_costCodeAlias;
	}

	public function setCostCodeAlias($costCodeAlias)
	{
		$this->_costCodeAlias = $costCodeAlias;
	}

	public function getCostCodeDivisionAlias()
	{
		return $this->_costCodeDivisionAlias;
	}

	public function setCostCodeDivisionAlias($costCodeDivisionAlias)
	{
		$this->_costCodeDivisionAlias = $costCodeDivisionAlias;
	}

	public function getSubcontractorBid()
	{
		return $this->_subcontractorBid;
	}

	public function setSubcontractorBid($subcontractorBid)
	{
		$this->_subcontractorBid = $subcontractorBid;
	}

	// ******ADD LIMIT/OFFSET/FILTERS AS SUBKEYS HERE???
	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrGcBudgetLineItemsByUserCompanyId()
	{
		if (isset(self::$_arrGcBudgetLineItemsByUserCompanyId)) {
			return self::$_arrGcBudgetLineItemsByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemsByUserCompanyId($arrGcBudgetLineItemsByUserCompanyId)
	{
		self::$_arrGcBudgetLineItemsByUserCompanyId = $arrGcBudgetLineItemsByUserCompanyId;
	}

	public static function getArrGcBudgetLineItemsByProjectId()
	{
		if (isset(self::$_arrGcBudgetLineItemsByProjectId)) {
			return self::$_arrGcBudgetLineItemsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemsByProjectId($arrGcBudgetLineItemsByProjectId)
	{
		self::$_arrGcBudgetLineItemsByProjectId = $arrGcBudgetLineItemsByProjectId;
	}

	public static function getArrGcBudgetLineItemsByCostCodeId()
	{
		if (isset(self::$_arrGcBudgetLineItemsByCostCodeId)) {
			return self::$_arrGcBudgetLineItemsByCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemsByCostCodeId($arrGcBudgetLineItemsByCostCodeId)
	{
		self::$_arrGcBudgetLineItemsByCostCodeId = $arrGcBudgetLineItemsByCostCodeId;
	}

	public static function getArrGcBudgetLineItemsByUserCompanyIdAndProjectId()
	{
		if (isset(self::$_arrGcBudgetLineItemsByUserCompanyIdAndProjectId)) {
			return self::$_arrGcBudgetLineItemsByUserCompanyIdAndProjectId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemsByUserCompanyIdAndProjectId($arrGcBudgetLineItemsByUserCompanyIdAndProjectId)
	{
		self::$_arrGcBudgetLineItemsByUserCompanyIdAndProjectId = $arrGcBudgetLineItemsByUserCompanyIdAndProjectId;
	}

	public static function setArrGcBudgetLineItemsByCommittedContracts($arrGcBudgetLineItemsByCommitedContracts)
	{
		self::$_arrGcBudgetLineItemsByCommitedContracts = $arrGcBudgetLineItemsByCommitedContracts;
	}

	public static function setArrGcBudgetLineItemsByUnCommittedContracts($arrGcBudgetLineItemsByUnCommitedContracts)
	{
		self::$_arrGcBudgetLineItemsByUnCommitedContracts = $arrGcBudgetLineItemsByUnCommitedContracts;
	}

  public static function setArrCurrentGcBudgetLineItems($arrCurrentGcBudgetLineItems){
		self::$_arrCurrentGcBudgetLineItems = $arrCurrentGcBudgetLineItems;
	}
	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllGcBudgetLineItems()
	{
		if (isset(self::$_arrAllGcBudgetLineItems)) {
			return self::$_arrAllGcBudgetLineItems;
		} else {
			return null;
		}
	}

	public static function setArrAllGcBudgetLineItems($arrAllGcBudgetLineItems)
	{
		self::$_arrAllGcBudgetLineItems = $arrAllGcBudgetLineItems;
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
	 * @param int $gc_budget_line_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $gc_budget_line_item_id, $table='gc_budget_line_items', $module='GcBudgetLineItem')
	{
		$gcBudgetLineItem = parent::findById($database, $gc_budget_line_item_id, $table, $module);

		return $gcBudgetLineItem;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @return mixed (single ORM object | false)
	 */

	public static function countAllIsDcrFlag($database, $project_id){

		$project_id = (int) $project_id;
		
		$db = DBI::getInstance($database);
		$query ="SELECT group_concat(id) AS ids FROM `gc_budget_line_items` WHERE `project_id` = $project_id";
		$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		$count = 1;
		if (isset($row) && !empty($row)) {
			$gc_budget_line_item_ids = $row['ids'];
			$query ="SELECT count(id) as cou FROM `subcontracts` WHERE `gc_budget_line_item_id` IN ($gc_budget_line_item_ids)";
			$db->execute($query);
			$row = $db->fetch();
			$db->free_result();

			$query ="SELECT count(id) as cou FROM `subcontracts` WHERE `gc_budget_line_item_id` IN ($gc_budget_line_item_ids) AND `is_dcr_flag` = 'Y'";
			$db->execute($query);
			$rowall = $db->fetch();
			$db->free_result();
			if ($row['cou'] == 0) {
				$count = 1;
			}else{
				$count = $row['cou'] - $rowall['cou'];	
			}
		}
	
		return $count;
	}

	public static function findGcBudgetLineItemByIdExtended($database, $gc_budget_line_item_id)
	{
		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	gbli_fk_uc.`id` AS 'gbli_fk_uc__user_company_id',
	gbli_fk_uc.`company` AS 'gbli_fk_uc__company',
	gbli_fk_uc.`primary_phone_number` AS 'gbli_fk_uc__primary_phone_number',
	gbli_fk_uc.`employer_identification_number` AS 'gbli_fk_uc__employer_identification_number',
	gbli_fk_uc.`construction_license_number` AS 'gbli_fk_uc__construction_license_number',
	gbli_fk_uc.`construction_license_number_expiration_date` AS 'gbli_fk_uc__construction_license_number_expiration_date',
	gbli_fk_uc.`paying_customer_flag` AS 'gbli_fk_uc__paying_customer_flag',

	gbli_fk_p.`id` AS 'gbli_fk_p__project_id',
	gbli_fk_p.`project_type_id` AS 'gbli_fk_p__project_type_id',
	gbli_fk_p.`user_company_id` AS 'gbli_fk_p__user_company_id',
	gbli_fk_p.`user_custom_project_id` AS 'gbli_fk_p__user_custom_project_id',
	gbli_fk_p.`project_name` AS 'gbli_fk_p__project_name',
	gbli_fk_p.`project_owner_name` AS 'gbli_fk_p__project_owner_name',
	gbli_fk_p.`latitude` AS 'gbli_fk_p__latitude',
	gbli_fk_p.`longitude` AS 'gbli_fk_p__longitude',
	gbli_fk_p.`address_line_1` AS 'gbli_fk_p__address_line_1',
	gbli_fk_p.`address_line_2` AS 'gbli_fk_p__address_line_2',
	gbli_fk_p.`address_line_3` AS 'gbli_fk_p__address_line_3',
	gbli_fk_p.`address_line_4` AS 'gbli_fk_p__address_line_4',
	gbli_fk_p.`address_city` AS 'gbli_fk_p__address_city',
	gbli_fk_p.`address_county` AS 'gbli_fk_p__address_county',
	gbli_fk_p.`address_state_or_region` AS 'gbli_fk_p__address_state_or_region',
	gbli_fk_p.`address_postal_code` AS 'gbli_fk_p__address_postal_code',
	gbli_fk_p.`address_postal_code_extension` AS 'gbli_fk_p__address_postal_code_extension',
	gbli_fk_p.`address_country` AS 'gbli_fk_p__address_country',
	gbli_fk_p.`building_count` AS 'gbli_fk_p__building_count',
	gbli_fk_p.`unit_count` AS 'gbli_fk_p__unit_count',
	gbli_fk_p.`gross_square_footage` AS 'gbli_fk_p__gross_square_footage',
	gbli_fk_p.`net_rentable_square_footage` AS 'gbli_fk_p__net_rentable_square_footage',
	gbli_fk_p.`is_active_flag` AS 'gbli_fk_p__is_active_flag',
	gbli_fk_p.`public_plans_flag` AS 'gbli_fk_p__public_plans_flag',
	gbli_fk_p.`prevailing_wage_flag` AS 'gbli_fk_p__prevailing_wage_flag',
	gbli_fk_p.`city_business_license_required_flag` AS 'gbli_fk_p__city_business_license_required_flag',
	gbli_fk_p.`is_internal_flag` AS 'gbli_fk_p__is_internal_flag',
	gbli_fk_p.`project_contract_date` AS 'gbli_fk_p__project_contract_date',
	gbli_fk_p.`project_start_date` AS 'gbli_fk_p__project_start_date',
	gbli_fk_p.`project_completed_date` AS 'gbli_fk_p__project_completed_date',
	gbli_fk_p.`sort_order` AS 'gbli_fk_p__sort_order',

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	gbli.*

FROM `gc_budget_line_items` gbli
	INNER JOIN `user_companies` gbli_fk_uc ON gbli.`user_company_id` = gbli_fk_uc.`id`
	INNER JOIN `projects` gbli_fk_p ON gbli.`project_id` = gbli_fk_p.`id`
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`

	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
WHERE gbli.`id` = ?
";
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$gcBudgetLineItem->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['gbli_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'gbli_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$gcBudgetLineItem->setUserCompany($userCompany);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['gbli_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'gbli_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$gcBudgetLineItem->setProject($project);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['gbli_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$gcBudgetLineItem->setCostCode($costCode);

			if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
				$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
				if ($costCode) {
					$costCode->setCostCodeDivision($costCodeDivision);
				}
			} else {
				$costCodeDivision = false;
			}
			$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

			return $gcBudgetLineItem;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_gc_budget_line_item` (`user_company_id`,`project_id`,`cost_code_id`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $project_id
	 * @param int $cost_code_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndProjectIdAndCostCodeId($database, $user_company_id, $project_id, $cost_code_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	gbli.*

FROM `gc_budget_line_items` gbli
WHERE gbli.`user_company_id` = ?
AND gbli.`project_id` = ?
AND gbli.`cost_code_id` = ?
";
		$arrValues = array($user_company_id, $project_id, $cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			return $gcBudgetLineItem;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrGcBudgetLineItemIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemsByArrGcBudgetLineItemIds($database, $arrGcBudgetLineItemIds, Input $options=null)
	{
		if (empty($arrGcBudgetLineItemIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY gbli.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrGcBudgetLineItemIds as $k => $gc_budget_line_item_id) {
			$gc_budget_line_item_id = (int) $gc_budget_line_item_id;
			$arrGcBudgetLineItemIds[$k] = $db->escape($gc_budget_line_item_id);
		}
		$csvGcBudgetLineItemIds = join(',', $arrGcBudgetLineItemIds);

		$query =
"
SELECT

	gbli.*

FROM `gc_budget_line_items` gbli
WHERE gbli.`id` IN ($csvGcBudgetLineItemIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrGcBudgetLineItemsByCsvGcBudgetLineItemIds = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$gcBudgetLineItem->convertPropertiesToData();

			$arrGcBudgetLineItemsByCsvGcBudgetLineItemIds[$gc_budget_line_item_id] = $gcBudgetLineItem;
		}

		$db->free_result();

		return $arrGcBudgetLineItemsByCsvGcBudgetLineItemIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `gc_budget_line_items_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemsByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemsByUserCompanyId = null;
		}

		$arrGcBudgetLineItemsByUserCompanyId = self::$_arrGcBudgetLineItemsByUserCompanyId;
		if (isset($arrGcBudgetLineItemsByUserCompanyId) && !empty($arrGcBudgetLineItemsByUserCompanyId)) {
			return $arrGcBudgetLineItemsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY gbli.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gbli.*

FROM `gc_budget_line_items` gbli
WHERE gbli.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$arrGcBudgetLineItemsByUserCompanyId[$gc_budget_line_item_id] = $gcBudgetLineItem;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemsByUserCompanyId = $arrGcBudgetLineItemsByUserCompanyId;

		return $arrGcBudgetLineItemsByUserCompanyId;
	}

	/**
	 * Load by constraint `gc_budget_line_items_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemsByProjectId($database, $project_id, Input $options=null, $whereNotIn='')
	{
		$whereNotSql = '';
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
			self::$_arrGcBudgetLineItemsByProjectId = null;
		}

		$arrGcBudgetLineItemsByProjectId = self::$_arrGcBudgetLineItemsByProjectId;
		if (isset($arrGcBudgetLineItemsByProjectId) && !empty($arrGcBudgetLineItemsByProjectId)) {
			return $arrGcBudgetLineItemsByProjectId;
		}
		// sort values only for API
		if(isset($whereNotIn) && !empty($whereNotIn)){
			$whereNotSql = "AND gbli.id NOT IN($whereNotIn)";
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			// $escapedLimit = $db->escape($limit);
			$escapedLimit = 10;
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

	gbli_fk_uc.`id` AS 'gbli_fk_uc__user_company_id',
	gbli_fk_uc.`company` AS 'gbli_fk_uc__company',
	gbli_fk_uc.`primary_phone_number` AS 'gbli_fk_uc__primary_phone_number',
	gbli_fk_uc.`employer_identification_number` AS 'gbli_fk_uc__employer_identification_number',
	gbli_fk_uc.`construction_license_number` AS 'gbli_fk_uc__construction_license_number',
	gbli_fk_uc.`construction_license_number_expiration_date` AS 'gbli_fk_uc__construction_license_number_expiration_date',
	gbli_fk_uc.`paying_customer_flag` AS 'gbli_fk_uc__paying_customer_flag',

	gbli_fk_p.`id` AS 'gbli_fk_p__project_id',
	gbli_fk_p.`project_type_id` AS 'gbli_fk_p__project_type_id',
	gbli_fk_p.`user_company_id` AS 'gbli_fk_p__user_company_id',
	gbli_fk_p.`user_custom_project_id` AS 'gbli_fk_p__user_custom_project_id',
	gbli_fk_p.`project_name` AS 'gbli_fk_p__project_name',
	gbli_fk_p.`project_owner_name` AS 'gbli_fk_p__project_owner_name',
	gbli_fk_p.`latitude` AS 'gbli_fk_p__latitude',
	gbli_fk_p.`longitude` AS 'gbli_fk_p__longitude',
	gbli_fk_p.`address_line_1` AS 'gbli_fk_p__address_line_1',
	gbli_fk_p.`address_line_2` AS 'gbli_fk_p__address_line_2',
	gbli_fk_p.`address_line_3` AS 'gbli_fk_p__address_line_3',
	gbli_fk_p.`address_line_4` AS 'gbli_fk_p__address_line_4',
	gbli_fk_p.`address_city` AS 'gbli_fk_p__address_city',
	gbli_fk_p.`address_county` AS 'gbli_fk_p__address_county',
	gbli_fk_p.`address_state_or_region` AS 'gbli_fk_p__address_state_or_region',
	gbli_fk_p.`address_postal_code` AS 'gbli_fk_p__address_postal_code',
	gbli_fk_p.`address_postal_code_extension` AS 'gbli_fk_p__address_postal_code_extension',
	gbli_fk_p.`address_country` AS 'gbli_fk_p__address_country',
	gbli_fk_p.`building_count` AS 'gbli_fk_p__building_count',
	gbli_fk_p.`unit_count` AS 'gbli_fk_p__unit_count',
	gbli_fk_p.`gross_square_footage` AS 'gbli_fk_p__gross_square_footage',
	gbli_fk_p.`net_rentable_square_footage` AS 'gbli_fk_p__net_rentable_square_footage',
	gbli_fk_p.`is_active_flag` AS 'gbli_fk_p__is_active_flag',
	gbli_fk_p.`public_plans_flag` AS 'gbli_fk_p__public_plans_flag',
	gbli_fk_p.`prevailing_wage_flag` AS 'gbli_fk_p__prevailing_wage_flag',
	gbli_fk_p.`city_business_license_required_flag` AS 'gbli_fk_p__city_business_license_required_flag',
	gbli_fk_p.`is_internal_flag` AS 'gbli_fk_p__is_internal_flag',
	gbli_fk_p.`project_contract_date` AS 'gbli_fk_p__project_contract_date',
	gbli_fk_p.`project_start_date` AS 'gbli_fk_p__project_start_date',
	gbli_fk_p.`project_completed_date` AS 'gbli_fk_p__project_completed_date',
	gbli_fk_p.`sort_order` AS 'gbli_fk_p__sort_order',

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',
	gbli_fk_codes__fk_ccd.`division_number_group_id` AS 'gbli_fk_codes__fk_ccd__division_number_group_id',

	cca.`id` AS 'cca__cost_code_alias_id',
	cca.`user_company_id` AS 'cca__user_company_id',
	cca.`project_id` AS 'cca__project_id',
	cca.`cost_code_id` AS 'cca__cost_code_id',
	cca.`contact_company_id` AS 'cca__contact_company_id',
	cca.`cost_code_division_alias_id` AS 'cca__cost_code_division_alias_id',
	cca.`cost_code_alias` AS 'cca__cost_code_alias',
	cca.`cost_code_description_alias` AS 'cca__cost_code_description_alias',
	cca.`cost_code_description_abbreviation_alias` AS 'cca__cost_code_description_abbreviation_alias',

	ccda.`id` AS 'ccda__cost_code_division_alias_id',
	ccda.`user_company_id` AS 'ccda__user_company_id',
	ccda.`project_id` AS 'ccda__project_id',
	ccda.`cost_code_division_id` AS 'ccda__cost_code_division_id',
	ccda.`contact_company_id` AS 'ccda__contact_company_id',
	ccda.`division_number_alias` AS 'ccda__division_number_alias',
	ccda.`division_code_heading_alias` AS 'ccda__division_code_heading_alias',
	ccda.`division_alias` AS 'ccda__division_alias',
	ccda.`division_abbreviation_alias` AS 'ccda__division_abbreviation_alias',

	sb.`id` AS 'sb__subcontractor_bid_id',
	sb.`gc_budget_line_item_id` AS 'sb__gc_budget_line_item_id',
	sb.`subcontractor_contact_id` AS 'sb__subcontractor_contact_id',
	sb.`subcontractor_bid_status_id` AS 'sb__subcontractor_bid_status_id',
	sb.`sort_order` AS 'sb__sort_order',

	gbli.*

FROM `gc_budget_line_items` gbli
	INNER JOIN `user_companies` gbli_fk_uc ON gbli.`user_company_id` = gbli_fk_uc.`id`
	INNER JOIN `projects` gbli_fk_p ON gbli.`project_id` = gbli_fk_p.`id`
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`

	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
	LEFT OUTER JOIN cost_code_aliases cca ON
		(gbli.user_company_id = cca.user_company_id AND gbli.project_id = cca.project_id AND gbli_fk_codes.`id` = cca.cost_code_id)
	LEFT OUTER JOIN cost_code_division_aliases ccda ON
		(gbli.user_company_id = ccda.user_company_id AND gbli.project_id = ccda.project_id AND gbli_fk_codes__fk_ccd.`id` = ccda.cost_code_division_id)
	LEFT OUTER JOIN subcontractor_bids sb ON (gbli.`id` = sb.gc_budget_line_item_id AND sb.subcontractor_bid_status_id = 12)
WHERE gbli.`project_id` = ? {$whereNotSql}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10

//  s.*, v.*
//	s.`id` as 'subcontract_id',
//	v.`id` as 'vendor_id'
//LEFT OUTER JOIN subcontracts s ON gbli.`id` = s.

#WHERE gbli.user_company_id = ?
#AND gbli_fk_codes__fk_ccd.`id` = ?
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemsByProjectId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$gcBudgetLineItem->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['gbli_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'gbli_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$gcBudgetLineItem->setUserCompany($userCompany);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['gbli_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'gbli_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$gcBudgetLineItem->setProject($project);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['gbli_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$gcBudgetLineItem->setCostCode($costCode);

			if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
				$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
				if ($costCode) {
					$costCode->setCostCodeDivision($costCodeDivision);
				}
			} else {
				$costCodeDivision = false;
			}
			$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

			if (isset($row['cca__cost_code_alias_id'])) {
				$cost_code_alias_id = $row['cca__cost_code_alias_id'];
				$row['cca__id'] = $cost_code_alias_id;
				$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id, 'cca__');
				/* @var $costCodeAlias CostCodeAlias */
				$costCodeAlias->convertPropertiesToData();
			} else {
				$costCodeAlias = false;
			}
			$gcBudgetLineItem->setCostCodeAlias($costCodeAlias);

			if (isset($row['ccda__cost_code_division_alias_id'])) {
				$cost_code_division_alias_id = $row['ccda__cost_code_division_alias_id'];
				$row['ccda__id'] = $cost_code_division_alias_id;
				$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id, 'ccda__');
				/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
				$costCodeDivisionAlias->convertPropertiesToData();
			} else {
				$costCodeDivisionAlias = false;
			}
			$gcBudgetLineItem->setCostCodeDivisionAlias($costCodeDivisionAlias);

			if (isset($row['sb__subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['sb__subcontractor_bid_id'];
				$row['sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$gcBudgetLineItem->setSubcontractorBid($subcontractorBid);

			$arrGcBudgetLineItemsByProjectId[$gc_budget_line_item_id] = $gcBudgetLineItem;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemsByProjectId = $arrGcBudgetLineItemsByProjectId;

		return $arrGcBudgetLineItemsByProjectId;
	}

	// Code code division count for the project
	public static function costCodeDivisionCountByProjectId($database, $project_id){

		$project_id = (int) $project_id;
		$db = DBI::getInstance($database);
		$query = "
SELECT 
count(gbli_fk_codes__fk_ccd.`division_number`) as count, gbli_fk_codes__fk_ccd.`division_number` as division_number
FROM `gc_budget_line_items` gbli
	INNER JOIN `user_companies` gbli_fk_uc ON gbli.`user_company_id` = gbli_fk_uc.`id`
	INNER JOIN `projects` gbli_fk_p ON gbli.`project_id` = gbli_fk_p.`id`
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`
	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
WHERE gbli.`project_id` = ? group BY gbli_fk_codes__fk_ccd.`division_number`

		";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$costCodeArray = array();
		while ($row = $db->fetch()) {
			$divisionNumber = $row['division_number'];
			$costCodeArray[$divisionNumber] = $row;
		}
		$db->free_result();
		return $costCodeArray;

	}

	/**
	 For Api Sorting Filter
	 * Load by constraint `gc_budget_line_items_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemsByProjectIdSortApi($database, $project_id, Input $options=null, $schedule_value_only, $need_buy_out)
	{
		
		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query =
"
SELECT
gbli.`id`,
gbli.`project_id`,
gbli.`prime_contract_scheduled_value`,
s.`subcontract_actual_value` as s_sca,
s.`gc_budget_line_item_id` as s_gc_id,
s.`id` as s_id,
SUM(s.`subcontract_actual_value`) as total_sca
FROM `gc_budget_line_items` gbli
LEFT JOIN `subcontracts` s ON gbli.`id` = s.`gc_budget_line_item_id`
WHERE gbli.`project_id` = ? GROUP BY gbli.id
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemsByProjectId = array();
		$whereNotIn = array();
		$buyoutArray = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$prime_contract_scheduled_value = $row['prime_contract_scheduled_value'];
			$total_sca = $row['total_sca'];
			if(($schedule_value_only && (!$prime_contract_scheduled_value || $prime_contract_scheduled_value == 0)) && !($need_buy_out)){
				$whereNotIn[$id] = $id;
			}

			if(!$schedule_value_only && ($need_buy_out && $total_sca && $total_sca > 0)){
				$whereNotIn[$id] = $id;	
			}

			if(($schedule_value_only && (!$prime_contract_scheduled_value || $prime_contract_scheduled_value == 0)) || ($need_buy_out && $total_sca && $total_sca > 0) ){
				$whereNotIn[$id] = $id;
			}
		}
		$db->free_result();
		// self::$_arrGcBudgetLineItemsByProjectId = $arrGcBudgetLineItemsByProjectId;
		return $whereNotIn;
	}
	public static function loadGcBudgetLineItemsByProjectIdReport($database, $project_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemsByProjectId = null;
		}

		$arrGcBudgetLineItemsByProjectId = self::$_arrGcBudgetLineItemsByProjectId;
		if (isset($arrGcBudgetLineItemsByProjectId) && !empty($arrGcBudgetLineItemsByProjectId)) {
			return $arrGcBudgetLineItemsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

	gbli_fk_uc.`id` AS 'gbli_fk_uc__user_company_id',
	gbli_fk_uc.`company` AS 'gbli_fk_uc__company',
	gbli_fk_uc.`primary_phone_number` AS 'gbli_fk_uc__primary_phone_number',
	gbli_fk_uc.`employer_identification_number` AS 'gbli_fk_uc__employer_identification_number',
	gbli_fk_uc.`construction_license_number` AS 'gbli_fk_uc__construction_license_number',
	gbli_fk_uc.`construction_license_number_expiration_date` AS 'gbli_fk_uc__construction_license_number_expiration_date',
	gbli_fk_uc.`paying_customer_flag` AS 'gbli_fk_uc__paying_customer_flag',

	gbli_fk_p.`id` AS 'gbli_fk_p__project_id',
	gbli_fk_p.`project_type_id` AS 'gbli_fk_p__project_type_id',
	gbli_fk_p.`user_company_id` AS 'gbli_fk_p__user_company_id',
	gbli_fk_p.`user_custom_project_id` AS 'gbli_fk_p__user_custom_project_id',
	gbli_fk_p.`project_name` AS 'gbli_fk_p__project_name',
	gbli_fk_p.`project_owner_name` AS 'gbli_fk_p__project_owner_name',
	gbli_fk_p.`latitude` AS 'gbli_fk_p__latitude',
	gbli_fk_p.`longitude` AS 'gbli_fk_p__longitude',
	gbli_fk_p.`address_line_1` AS 'gbli_fk_p__address_line_1',
	gbli_fk_p.`address_line_2` AS 'gbli_fk_p__address_line_2',
	gbli_fk_p.`address_line_3` AS 'gbli_fk_p__address_line_3',
	gbli_fk_p.`address_line_4` AS 'gbli_fk_p__address_line_4',
	gbli_fk_p.`address_city` AS 'gbli_fk_p__address_city',
	gbli_fk_p.`address_county` AS 'gbli_fk_p__address_county',
	gbli_fk_p.`address_state_or_region` AS 'gbli_fk_p__address_state_or_region',
	gbli_fk_p.`address_postal_code` AS 'gbli_fk_p__address_postal_code',
	gbli_fk_p.`address_postal_code_extension` AS 'gbli_fk_p__address_postal_code_extension',
	gbli_fk_p.`address_country` AS 'gbli_fk_p__address_country',
	gbli_fk_p.`building_count` AS 'gbli_fk_p__building_count',
	gbli_fk_p.`unit_count` AS 'gbli_fk_p__unit_count',
	gbli_fk_p.`gross_square_footage` AS 'gbli_fk_p__gross_square_footage',
	gbli_fk_p.`net_rentable_square_footage` AS 'gbli_fk_p__net_rentable_square_footage',
	gbli_fk_p.`is_active_flag` AS 'gbli_fk_p__is_active_flag',
	gbli_fk_p.`public_plans_flag` AS 'gbli_fk_p__public_plans_flag',
	gbli_fk_p.`prevailing_wage_flag` AS 'gbli_fk_p__prevailing_wage_flag',
	gbli_fk_p.`city_business_license_required_flag` AS 'gbli_fk_p__city_business_license_required_flag',
	gbli_fk_p.`is_internal_flag` AS 'gbli_fk_p__is_internal_flag',
	gbli_fk_p.`project_contract_date` AS 'gbli_fk_p__project_contract_date',
	gbli_fk_p.`project_start_date` AS 'gbli_fk_p__project_start_date',
	gbli_fk_p.`project_completed_date` AS 'gbli_fk_p__project_completed_date',
	gbli_fk_p.`sort_order` AS 'gbli_fk_p__sort_order',

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	cca.`id` AS 'cca__cost_code_alias_id',
	cca.`user_company_id` AS 'cca__user_company_id',
	cca.`project_id` AS 'cca__project_id',
	cca.`cost_code_id` AS 'cca__cost_code_id',
	cca.`contact_company_id` AS 'cca__contact_company_id',
	cca.`cost_code_division_alias_id` AS 'cca__cost_code_division_alias_id',
	cca.`cost_code_alias` AS 'cca__cost_code_alias',
	cca.`cost_code_description_alias` AS 'cca__cost_code_description_alias',
	cca.`cost_code_description_abbreviation_alias` AS 'cca__cost_code_description_abbreviation_alias',

	ccda.`id` AS 'ccda__cost_code_division_alias_id',
	ccda.`user_company_id` AS 'ccda__user_company_id',
	ccda.`project_id` AS 'ccda__project_id',
	ccda.`cost_code_division_id` AS 'ccda__cost_code_division_id',
	ccda.`contact_company_id` AS 'ccda__contact_company_id',
	ccda.`division_number_alias` AS 'ccda__division_number_alias',
	ccda.`division_code_heading_alias` AS 'ccda__division_code_heading_alias',
	ccda.`division_alias` AS 'ccda__division_alias',
	ccda.`division_abbreviation_alias` AS 'ccda__division_abbreviation_alias',

	sb.`id` AS 'sb__subcontractor_bid_id',
	sb.`gc_budget_line_item_id` AS 'sb__gc_budget_line_item_id',
	sb.`subcontractor_contact_id` AS 'sb__subcontractor_contact_id',
	sb.`subcontractor_bid_status_id` AS 'sb__subcontractor_bid_status_id',
	sb.`sort_order` AS 'sb__sort_order',

	gbli.*

FROM `gc_budget_line_items` gbli
	INNER JOIN `user_companies` gbli_fk_uc ON gbli.`user_company_id` = gbli_fk_uc.`id`
	INNER JOIN `projects` gbli_fk_p ON gbli.`project_id` = gbli_fk_p.`id`
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`

	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
	LEFT OUTER JOIN cost_code_aliases cca ON
		(gbli.user_company_id = cca.user_company_id AND gbli.project_id = cca.project_id AND gbli_fk_codes.`id` = cca.cost_code_id)
	LEFT OUTER JOIN cost_code_division_aliases ccda ON
		(gbli.user_company_id = ccda.user_company_id AND gbli.project_id = ccda.project_id AND gbli_fk_codes__fk_ccd.`id` = ccda.cost_code_division_id)
	LEFT OUTER JOIN subcontractor_bids sb ON (gbli.`id` = sb.gc_budget_line_item_id AND sb.subcontractor_bid_status_id = 12)
WHERE gbli.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10

//  s.*, v.*
//	s.`id` as 'subcontract_id',
//	v.`id` as 'vendor_id'
//LEFT OUTER JOIN subcontracts s ON gbli.`id` = s.

#WHERE gbli.user_company_id = ?
#AND gbli_fk_codes__fk_ccd.`id` = ?
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemsByProjectId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$gcBudgetLineItem->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['gbli_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'gbli_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$gcBudgetLineItem->setUserCompany($userCompany);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['gbli_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'gbli_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$gcBudgetLineItem->setProject($project);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['gbli_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$gcBudgetLineItem->setCostCode($costCode);

			if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
				$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
				if ($costCode) {
					$costCode->setCostCodeDivision($costCodeDivision);
				}
			} else {
				$costCodeDivision = false;
			}
			$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

			if (isset($row['cca__cost_code_alias_id'])) {
				$cost_code_alias_id = $row['cca__cost_code_alias_id'];
				$row['cca__id'] = $cost_code_alias_id;
				$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id, 'cca__');
				/* @var $costCodeAlias CostCodeAlias */
				$costCodeAlias->convertPropertiesToData();
			} else {
				$costCodeAlias = false;
			}
			$gcBudgetLineItem->setCostCodeAlias($costCodeAlias);

			if (isset($row['ccda__cost_code_division_alias_id'])) {
				$cost_code_division_alias_id = $row['ccda__cost_code_division_alias_id'];
				$row['ccda__id'] = $cost_code_division_alias_id;
				$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivisionAlias', $row, null, $cost_code_division_alias_id, 'ccda__');
				/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
				$costCodeDivisionAlias->convertPropertiesToData();
			} else {
				$costCodeDivisionAlias = false;
			}
			$gcBudgetLineItem->setCostCodeDivisionAlias($costCodeDivisionAlias);

			if (isset($row['sb__subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['sb__subcontractor_bid_id'];
				$row['sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$gcBudgetLineItem->setSubcontractorBid($subcontractorBid);

			$arrGcBudgetLineItemsByProjectId[$gc_budget_line_item_id] = $gcBudgetLineItem;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemsByProjectId = $arrGcBudgetLineItemsByProjectId;

		return $arrGcBudgetLineItemsByProjectId;
	}

	/**
	 * Load by constraint `gc_budget_line_items_fk_codes` foreign key (`cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemsByCostCodeId($database, $cost_code_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemsByCostCodeId = null;
		}

		$arrGcBudgetLineItemsByCostCodeId = self::$_arrGcBudgetLineItemsByCostCodeId;
		if (isset($arrGcBudgetLineItemsByCostCodeId) && !empty($arrGcBudgetLineItemsByCostCodeId)) {
			return $arrGcBudgetLineItemsByCostCodeId;
		}

		$cost_code_id = (int) $cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY gbli.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gbli.*

FROM `gc_budget_line_items` gbli
WHERE gbli.`cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemsByCostCodeId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$arrGcBudgetLineItemsByCostCodeId[$gc_budget_line_item_id] = $gcBudgetLineItem;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemsByCostCodeId = $arrGcBudgetLineItemsByCostCodeId;

		return $arrGcBudgetLineItemsByCostCodeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all gc_budget_line_items records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllGcBudgetLineItems($database, Input $options=null)
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
			self::$_arrAllGcBudgetLineItems = null;
		}

		$arrAllGcBudgetLineItems = self::$_arrAllGcBudgetLineItems;
		if (isset($arrAllGcBudgetLineItems) && !empty($arrAllGcBudgetLineItems)) {
			return $arrAllGcBudgetLineItems;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY gbli.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gbli.*

FROM `gc_budget_line_items` gbli{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllGcBudgetLineItems = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$arrAllGcBudgetLineItems[$gc_budget_line_item_id] = $gcBudgetLineItem;
		}

		$db->free_result();

		self::$_arrAllGcBudgetLineItems = $arrAllGcBudgetLineItems;

		return $arrAllGcBudgetLineItems;
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
INTO `gc_budget_line_items`
(`user_company_id`, `project_id`, `cost_code_id`, `modified`, `prime_contract_scheduled_value`, `forecasted_expenses`,`buyout_forecasted_expenses`,`created`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `modified` = ?, `prime_contract_scheduled_value` = ?, `forecasted_expenses` = ?,`buyout_forecasted_expenses` = ?,`created` = ?, `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->user_company_id, $this->project_id, $this->cost_code_id, $this->modified, $this->prime_contract_scheduled_value, $this->forecasted_expenses,$this->buyout_forecasted_expenses, $this->created, $this->sort_order, $this->disabled_flag, $this->modified, $this->prime_contract_scheduled_value, $this->forecasted_expenses,$this->buyout_forecasted_expenses, $this->created, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$gc_budget_line_item_id = $db->insertId;
		$db->free_result();

		return $gc_budget_line_item_id;
	}

	// Save: insert ignore

	public static function loadGcBudgetLineItemsByUserCompanyIdAndProjectId($database, $user_company_id, $project_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemsByUserCompanyIdAndProjectId = null;
		}

		$arrGcBudgetLineItemsByUserCompanyIdAndProjectId = self::$_arrGcBudgetLineItemsByUserCompanyIdAndProjectId;
		if (isset($arrGcBudgetLineItemsByUserCompanyIdAndProjectId) && !empty($arrGcBudgetLineItemsByUserCompanyIdAndProjectId)) {
			return $arrGcBudgetLineItemsByUserCompanyIdAndProjectId;
		}

		$user_company_id = (int) $user_company_id;
		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

	gbli_fk_uc.`id` AS 'gbli_fk_uc__user_company_id',
	gbli_fk_uc.`company` AS 'gbli_fk_uc__company',
	gbli_fk_uc.`primary_phone_number` AS 'gbli_fk_uc__primary_phone_number',
	gbli_fk_uc.`employer_identification_number` AS 'gbli_fk_uc__employer_identification_number',
	gbli_fk_uc.`construction_license_number` AS 'gbli_fk_uc__construction_license_number',
	gbli_fk_uc.`construction_license_number_expiration_date` AS 'gbli_fk_uc__construction_license_number_expiration_date',
	gbli_fk_uc.`paying_customer_flag` AS 'gbli_fk_uc__paying_customer_flag',

	gbli_fk_p.`id` AS 'gbli_fk_p__project_id',
	gbli_fk_p.`project_type_id` AS 'gbli_fk_p__project_type_id',
	gbli_fk_p.`user_company_id` AS 'gbli_fk_p__user_company_id',
	gbli_fk_p.`user_custom_project_id` AS 'gbli_fk_p__user_custom_project_id',
	gbli_fk_p.`project_name` AS 'gbli_fk_p__project_name',
	gbli_fk_p.`project_owner_name` AS 'gbli_fk_p__project_owner_name',
	gbli_fk_p.`latitude` AS 'gbli_fk_p__latitude',
	gbli_fk_p.`longitude` AS 'gbli_fk_p__longitude',
	gbli_fk_p.`address_line_1` AS 'gbli_fk_p__address_line_1',
	gbli_fk_p.`address_line_2` AS 'gbli_fk_p__address_line_2',
	gbli_fk_p.`address_line_3` AS 'gbli_fk_p__address_line_3',
	gbli_fk_p.`address_line_4` AS 'gbli_fk_p__address_line_4',
	gbli_fk_p.`address_city` AS 'gbli_fk_p__address_city',
	gbli_fk_p.`address_county` AS 'gbli_fk_p__address_county',
	gbli_fk_p.`address_state_or_region` AS 'gbli_fk_p__address_state_or_region',
	gbli_fk_p.`address_postal_code` AS 'gbli_fk_p__address_postal_code',
	gbli_fk_p.`address_postal_code_extension` AS 'gbli_fk_p__address_postal_code_extension',
	gbli_fk_p.`address_country` AS 'gbli_fk_p__address_country',
	gbli_fk_p.`building_count` AS 'gbli_fk_p__building_count',
	gbli_fk_p.`unit_count` AS 'gbli_fk_p__unit_count',
	gbli_fk_p.`gross_square_footage` AS 'gbli_fk_p__gross_square_footage',
	gbli_fk_p.`net_rentable_square_footage` AS 'gbli_fk_p__net_rentable_square_footage',
	gbli_fk_p.`is_active_flag` AS 'gbli_fk_p__is_active_flag',
	gbli_fk_p.`public_plans_flag` AS 'gbli_fk_p__public_plans_flag',
	gbli_fk_p.`prevailing_wage_flag` AS 'gbli_fk_p__prevailing_wage_flag',
	gbli_fk_p.`city_business_license_required_flag` AS 'gbli_fk_p__city_business_license_required_flag',
	gbli_fk_p.`is_internal_flag` AS 'gbli_fk_p__is_internal_flag',
	gbli_fk_p.`project_contract_date` AS 'gbli_fk_p__project_contract_date',
	gbli_fk_p.`project_start_date` AS 'gbli_fk_p__project_start_date',
	gbli_fk_p.`project_completed_date` AS 'gbli_fk_p__project_completed_date',
	gbli_fk_p.`sort_order` AS 'gbli_fk_p__sort_order',

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	cca.`id` AS 'cca__cost_code_alias_id',
	cca.`user_company_id` AS 'cca__user_company_id',
	cca.`project_id` AS 'cca__project_id',
	cca.`cost_code_id` AS 'cca__cost_code_id',
	cca.`contact_company_id` AS 'cca__contact_company_id',
	cca.`cost_code_division_alias_id` AS 'cca__cost_code_division_alias_id',

	ccda.`id` AS 'ccda__cost_code_division_alias_id',
	ccda.`user_company_id` AS 'ccda__user_company_id',
	ccda.`project_id` AS 'ccda__project_id',
	ccda.`cost_code_division_id` AS 'ccda__cost_code_division_id',
	ccda.`contact_company_id` AS 'ccda__contact_company_id',

	gbli.*

FROM `gc_budget_line_items` gbli
	INNER JOIN `user_companies` gbli_fk_uc ON gbli.`user_company_id` = gbli_fk_uc.`id`
	INNER JOIN `projects` gbli_fk_p ON gbli.`project_id` = gbli_fk_p.`id`
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`

	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
	LEFT OUTER JOIN `cost_code_aliases` cca ON
		(gbli.`user_company_id` = cca.`user_company_id` AND gbli.`project_id` = cca.`project_id` AND gbli_fk_codes.`id` = cca.`cost_code_id`)
	LEFT OUTER JOIN `cost_code_division_aliases` ccda ON
		(gbli.`user_company_id` = ccda.`user_company_id` AND gbli.`project_id` = ccda.`project_id` AND gbli_fk_codes__fk_ccd.`id` = ccda.`cost_code_division_id`)
WHERE gbli.`user_company_id` = ?
AND gbli.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemsByUserCompanyIdAndProjectId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_id = $row['id'];
			$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
			/* @var $gcBudgetLineItem GcBudgetLineItem */
			$gcBudgetLineItem->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['gbli_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'gbli_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$gcBudgetLineItem->setUserCompany($userCompany);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['gbli_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'gbli_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$gcBudgetLineItem->setProject($project);

			if (isset($row['cost_code_id'])) {
				$cost_code_id = $row['cost_code_id'];
				$row['gbli_fk_codes__id'] = $cost_code_id;
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$gcBudgetLineItem->setCostCode($costCode);

			if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
				$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
				if ($costCode) {
					$costCode->setCostCodeDivision($costCodeDivision);
				}
			} else {
				$costCodeDivision = false;
			}
			$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

			// @todo && !empty($row['cca__cost_code_alias_id'])
			if (isset($row['cca__cost_code_alias_id'])) {
				$cost_code_alias_id = $row['cost_code_alias_id'];
				$row['cca__id'] = $cost_code_alias_id;
				$costCodeAlias = self::instantiateOrm($database, 'CostCodeAlias', $row, null, $cost_code_alias_id, 'cca__');
				/* @var $costCodeAlias CostCodeAlias */
				$costCodeAlias->convertPropertiesToData();
			} else {
				$costCodeAlias = false;
			}
			$gcBudgetLineItem->setCostCodeAlias($costCodeAlias);

			if (isset($row['ccda__cost_code_division_alias_id'])) {
				$cost_code_division_alias_id = $row['ccda__cost_code_division_alias_id'];
				$row['ccda__id'] = $cost_code_division_alias_id;
				$costCodeDivisionAlias = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_alias_id, 'ccda__');
				/* @var $costCodeDivisionAlias CostCodeDivisionAlias */
				$costCodeDivisionAlias->convertPropertiesToData();
			} else {
				$costCodeDivisionAlias = false;
			}
			$gcBudgetLineItem->setCostCodeDivisionAlias($costCodeDivisionAlias);

			$arrGcBudgetLineItemsByUserCompanyIdAndProjectId[$gc_budget_line_item_id] = $gcBudgetLineItem;
		}

		$db->free_result();

		return $arrGcBudgetLineItemsByUserCompanyIdAndProjectId;
	}

	public function deriveTotalPrimeContractScheduledValue($database)
	{
		$loadLinkedGcBudgetLineItemsOptions = new Input();
		$loadLinkedGcBudgetLineItemsOptions->forceLoadFlag = true;
		$gc_budget_line_item_id = $this->gc_budget_line_item_id;
		$arrLinkedGcBudgetLineItems = GcBudgetLineItemRelationship::loadLinkedGcBudgetLineItems($database, $gc_budget_line_item_id, $loadLinkedGcBudgetLineItemsOptions);

		$primeContractScheduledValueTotals = $this->prime_contract_scheduled_value;
		$linkedGcBudgetLineItemsCount = count($arrLinkedGcBudgetLineItems);
		foreach ($arrLinkedGcBudgetLineItems as $linked_gc_budget_line_item_id => $linkedGcBudgetLineItem) {
			$primeContractScheduledValueTotals += $linkedGcBudgetLineItem->prime_contract_scheduled_value;
		}

		$arrReturn = array(
			'primeContractScheduledValueTotals' => $primeContractScheduledValueTotals,
			'linkedGcBudgetLineItemsCount' => $linkedGcBudgetLineItemsCount
		);

	return $arrReturn;
}

public static function loadCommittedContractsByProjectId($database, $project_id, $new_begindate, $enddate, Input $options=null){
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
		self::$_arrGcBudgetLineItemsByCommitedContracts = null;
	}

	$arrGcBudgetLineItemsByCommitedContracts = self::$_arrGcBudgetLineItemsByCommitedContracts;
	if (isset($arrGcBudgetLineItemsByCommitedContracts) && !empty($arrGcBudgetLineItemsByCommitedContracts)) {
		return $arrGcBudgetLineItemsByCommitedContracts;
	}

	$project_id = (int) $project_id;
  $startDate = date('Y-m-d',strtotime($new_begindate));
	$endDate = date('Y-m-d',strtotime($enddate));
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
	$sqlOrderBy = "\nORDER BY gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC";
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
		$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	gbli.*,sc.*

	FROM `gc_budget_line_items` gbli
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`
	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
	INNER JOIN `subcontracts` sc ON sc.`gc_budget_line_item_id` = gbli.`id`
	WHERE gbli.`prime_contract_scheduled_value` <>0 AND gbli.`project_id` = ?
	AND ((sc.`subcontract_execution_date` BETWEEN ? AND ?) OR sc.`subcontract_execution_date` = '0000-00-00')
	GROUP BY gbli.id{$sqlOrderBy}{$sqlLimit}
	";
	$arrValues = array($project_id, $startDate, $endDate);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrGcBudgetLineItemsByCommitedContracts = array();
	while ($row = $db->fetch()) {
		$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
		$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
		/* @var $gcBudgetLineItem GcBudgetLineItem */
		$gcBudgetLineItem->convertPropertiesToData();

		if (isset($row['cost_code_id'])) {
			$cost_code_id = $row['cost_code_id'];
			$row['gbli_fk_codes__id'] = $cost_code_id;
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();
		} else {
			$costCode = false;
		}
		$gcBudgetLineItem->setCostCode($costCode);

		if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
			$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
			$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
			/* @var $costCodeDivision CostCodeDivision */
			$costCodeDivision->convertPropertiesToData();
			if ($costCode) {
				$costCode->setCostCodeDivision($costCodeDivision);
			}
		} else {
			$costCodeDivision = false;
		}
		$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

		$arrGcBudgetLineItemsByCommitedContracts[$gc_budget_line_item_id] = $gcBudgetLineItem;
	}

	$db->free_result();

	return $arrGcBudgetLineItemsByCommitedContracts;
}
public static function loadUnCommittedContractsByProjectId($database, $project_id, Input $options=null){
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
		self::$_arrGcBudgetLineItemsByUnCommitedContracts = null;
	}

	$arrGcBudgetLineItemsByUnCommitedContracts = self::$_arrGcBudgetLineItemsByUnCommitedContracts;
	if (isset($arrGcBudgetLineItemsByUnCommitedContracts) && !empty($arrGcBudgetLineItemsByUnCommitedContracts)) {
		return $arrGcBudgetLineItemsByUnCommitedContracts;
	}

	$project_id = (int) $project_id;
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
	$sqlOrderBy = "\nORDER BY gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC";
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
		$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	gbli.*

	FROM `gc_budget_line_items` gbli
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`
	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
	WHERE gbli.`prime_contract_scheduled_value` <>0 AND gbli.`project_id` = ?
	AND gbli.`id` NOT IN (
		SELECT s.`gc_budget_line_item_id` FROM `subcontracts` s
		LEFT JOIN `gc_budget_line_items` gbli ON gbli.`id` = s.`gc_budget_line_item_id`
		WHERE gbli.`project_id`= ?
		AND gbli.`prime_contract_scheduled_value` <>0
	){$sqlOrderBy}{$sqlLimit}
	";
	$arrValues = array($project_id, $project_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrGcBudgetLineItemsByUnCommitedContracts = array();
	while ($row = $db->fetch()) {
		$gc_budget_line_item_id = $row['id'];
		$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
		/* @var $gcBudgetLineItem GcBudgetLineItem */
		$gcBudgetLineItem->convertPropertiesToData();

		if (isset($row['cost_code_id'])) {
			$cost_code_id = $row['cost_code_id'];
			$row['gbli_fk_codes__id'] = $cost_code_id;
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();
		} else {
			$costCode = false;
		}
		$gcBudgetLineItem->setCostCode($costCode);

		if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
			$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
			$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
			/* @var $costCodeDivision CostCodeDivision */
			$costCodeDivision->convertPropertiesToData();
			if ($costCode) {
				$costCode->setCostCodeDivision($costCodeDivision);
			}
		} else {
			$costCodeDivision = false;
		}
		$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

		$arrGcBudgetLineItemsByUnCommitedContracts[$gc_budget_line_item_id] = $gcBudgetLineItem;
	}

	$db->free_result();

	return $arrGcBudgetLineItemsByUnCommitedContracts;
}


public static function loadBuyoutLogData($database, $project_id) {

	$arrGcBudgetLineItemsByCommitedContracts = self::$_arrGcBudgetLineItemsByCommitedContracts;
	if (isset($arrGcBudgetLineItemsByCommitedContracts) && !empty($arrGcBudgetLineItemsByCommitedContracts)) {
		return $arrGcBudgetLineItemsByCommitedContracts;
	}

	$project_id = (int) $project_id;

	$db = DBI::getInstance($database);
	
	$query =
	"
	SELECT

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	gbli.*

	FROM `gc_budget_line_items` gbli
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`
	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
	WHERE gbli.`prime_contract_scheduled_value` <> 0 AND gbli.`project_id` = ?
	GROUP BY gbli.id
	ORDER BY gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC
	";
	$arrValues = array($project_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrGcBudgetLineItemsByCommitedContracts = array();
	while ($row = $db->fetch()) {

		$gc_budget_line_item_id = $row['id'];
		$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
		$gcBudgetLineItem->convertPropertiesToData();

		if (isset($row['cost_code_id'])) {
			$cost_code_id = $row['cost_code_id'];
			$row['gbli_fk_codes__id'] = $cost_code_id;
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();
		} else {
			$costCode = false;
		}
		$gcBudgetLineItem->setCostCode($costCode);

		if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
			$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
			$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
			/* @var $costCodeDivision CostCodeDivision */
			$costCodeDivision->convertPropertiesToData();
			if ($costCode) {
				$costCode->setCostCodeDivision($costCodeDivision);
			}
		} else {
			$costCodeDivision = false;
		}
		$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

		$arrGcBudgetLineItemsByCommitedContracts[$gc_budget_line_item_id] = $gcBudgetLineItem;
	}

	$db->free_result();

	return $arrGcBudgetLineItemsByCommitedContracts;
}

public static function DeleteAllCostCodeRelatedItems($database,$budgetid)
{
		$db = DBI::getInstance($database);
		$query1 ="DELETE FROM `bid_spreads` WHERE `gc_budget_line_item_id`=? ";
		$arrValues = array($budgetid);
		$db->execute($query1, $arrValues);
		$db->free_result();

		$query1 ="DELETE FROM `bid_items` WHERE `gc_budget_line_item_id` = ? ";
		$arrValues = array($budgetid);
		$db->execute($query1, $arrValues);
		$db->free_result();

		$query1 ="DELETE FROM `subcontractor_bids` WHERE `gc_budget_line_item_id` = ? ";
		$arrValues = array($budgetid);
		$db->execute($query1, $arrValues);
		$db->free_result();		
}

public static function loadCurrentGcBudgetLineItems($database, $project_id, $new_begindate, $enddate, Input $options=null){
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
		self::$_arrCurrentGcBudgetLineItems = null;
	}

	$arrCurrentGcBudgetLineItems = self::$_arrCurrentGcBudgetLineItems;
	if (isset($arrCurrentGcBudgetLineItems) && !empty($arrCurrentGcBudgetLineItems)) {
		return $arrCurrentGcBudgetLineItems;
	}

	$project_id = (int) $project_id;
	$startDate = date('Y-m-d',strtotime($new_begindate));
	$endDate = date('Y-m-d',strtotime($enddate));
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_company_id` ASC, `project_id` ASC, `cost_code_id` ASC, `modified` ASC, `prime_contract_scheduled_value` ASC, `forecasted_expenses` ASC, `created` ASC, `sort_order` ASC, `disabled_flag` ASC
	$sqlOrderBy = "\nORDER BY gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC";
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpGcBudgetLineItem = new GcBudgetLineItem($database);
		$sqlOrderByColumns = $tmpGcBudgetLineItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	gbli.*

	FROM `gc_budget_line_items` gbli
	INNER JOIN `cost_codes` gbli_fk_codes ON gbli.`cost_code_id` = gbli_fk_codes.`id`
	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`
	LEFT JOIN `subcontracts` sc ON sc.`gc_budget_line_item_id` = gbli.`id`
	WHERE  gbli.`project_id` = ?
	GROUP BY gbli.id{$sqlOrderBy}{$sqlLimit}
	";
	$arrValues = array($project_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$arrCurrentGcBudgetLineItems = array();
	while ($row = $db->fetch()) {
		$gc_budget_line_item_id = $row['id'];
		$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id);
		/* @var $gcBudgetLineItem GcBudgetLineItem */
		$gcBudgetLineItem->convertPropertiesToData();

		if (isset($row['cost_code_id'])) {
			$cost_code_id = $row['cost_code_id'];
			$row['gbli_fk_codes__id'] = $cost_code_id;
			$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();
		} else {
			$costCode = false;
		}
		$gcBudgetLineItem->setCostCode($costCode);

		if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
			$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
			$row['gbli_fk_codes__fk_ccd__id'] = $cost_code_division_id;
			$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
			/* @var $costCodeDivision CostCodeDivision */
			$costCodeDivision->convertPropertiesToData();
			if ($costCode) {
				$costCode->setCostCodeDivision($costCodeDivision);
			}
		} else {
			$costCodeDivision = false;
		}
		$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

		$arrCurrentGcBudgetLineItems[$gc_budget_line_item_id] = $gcBudgetLineItem;
	}

	$db->free_result();

	return $arrCurrentGcBudgetLineItems;
}

public static function getprelimbudget($database,$project_id)
{
	$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		 $query ="SELECT  gbl.*,s.id as subcontractor_id, ccd.division_number, cc.cost_code,cc.cost_code_description FROM `gc_budget_line_items` gbl 
		inner join subcontracts s on s.gc_budget_line_item_id = gbl.id 
		inner join cost_codes  cc on cc.id = gbl.cost_code_id  
		inner join  cost_code_divisions ccd on ccd.id = cc.cost_code_division_id
		inner join subcontractor_additional_documents sad on s.id = sad.subcontractor_id
		inner join preliminary_items pi on pi.additional_doc_id = sad.id
		 WHERE gbl.`project_id` = ? and gbl.prime_contract_scheduled_value is not null order by ccd.division_number,cc.cost_code ASC";
		$arrValues = array($project_id);
		$db->execute($query,$arrValues);
		$budget = array();
		$bud_id =$subcontractor_id= "";
		while ($row = $db->fetch())
		{
			$budget_id =$row['id'];
			if($budget_id != $bud_id)
			{
				$bud_id = $budget_id;
				$subcontractor_id ="";
			}

			$subcontractor_id .=$row['subcontractor_id'].',';
			
			$budget[$budget_id] =$row;
			$budget[$budget_id]['subcontractor_id'] =$subcontractor_id;
		
		}

		$db->free_result();
		return $budget;
}

public static function getprelimsubcontractor($database,$subcontractor_id)
{
	$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		 $query ="SELECT  cc.company,s.id as sub_id  FROM `subcontracts` s 
		inner join vendors v on s.vendor_id = v.id 
		inner join contact_companies cc on cc.id = v.vendor_contact_company_id
		WHERE s.`id` IN ($subcontractor_id) ";
		$db->execute($query);
		$budget = array();
		while ($row = $db->fetch())
		{
			$subcont =$row['sub_id'];
			$budget[$subcont] =$row;
		
		}

		$db->free_result();
		return $budget;
}

public static function getprelimDataforsubcontractor($database,$subcontractor_id)
{
	$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		 $query ="SELECT pi.*, s.id as sub_id  FROM `subcontracts` s 
		inner join subcontractor_additional_documents sad on s.id = sad.subcontractor_id inner join preliminary_items pi on pi.additional_doc_id = sad.id WHERE s.id = ?";
		$arrValues = array($subcontractor_id);
		$db->execute($query,$arrValues);
		$budget = array();
		while ($row = $db->fetch())
		{
			$prelim =$row['id'];
			$prelim_data[$prelim] =$row;
		
		}

		$db->free_result();
		return $prelim_data;
}

public static function getTotalOriginalPSCV($database,$project_id)
{
	$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	$query ="SELECT SUM(`prime_contract_scheduled_value`) as 'total' FROM `gc_budget_line_items` WHERE `project_id` = ?";
	$arrValues = array($project_id);
	$db->execute($query,$arrValues);
	
	$row = $db->fetch();	
	$total =$row['total'];

	$db->free_result();
	return $total;
}

public static function getCompanyBaseCostCode($database, $vendor_id, $project_id)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$query ="SELECT * FROM gc_budget_line_items  AS gc
	INNER JOIN cost_codes cc ON gc.cost_code_id = cc.id
	WHERE gc.user_company_id = ".$vendor_id." AND gc.project_id = ".$project_id." ";
	$db->execute($query);
	while ($row = $db->fetch())
	{
		$cost =$row['id'];
		$cost_Code_data[$cost] =$row;	
	}
	$db->free_result();	
	return $cost_Code_data;
}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

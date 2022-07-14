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
 * ActionItem.
 *
 * @category   Framework
 * @package    ActionItem
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ActionItem extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ActionItem';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'action_items';

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
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_action_item_via_primary_key' => array(
			'action_item_id' => 'int'
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
		'id' => 'action_item_id',

		'project_id' => 'project_id',
		'action_item_type_id' => 'action_item_type_id',
		'action_item_type_reference_id' => 'action_item_type_reference_id',
		'action_item_sequence_number' => 'action_item_sequence_number',
		'action_item_status_id' => 'action_item_status_id',
		'action_item_priority_id' => 'action_item_priority_id',
		'action_item_cost_code_id' => 'action_item_cost_code_id',
		'created_by_contact_id' => 'created_by_contact_id',

		'action_item_title' => 'action_item_title',
		'action_item' => 'action_item',
		'created' => 'created',
		'action_item_due_date' => 'action_item_due_date',
		'action_item_completed_timestamp' => 'action_item_completed_timestamp',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $action_item_id;

	public $project_id;
	public $action_item_type_id;
	public $action_item_sequence_number;
	public $action_item_status_id;
	public $action_item_priority_id;
	public $action_item_cost_code_id;
	public $created_by_contact_id;

	public $action_item_title;
	public $action_item;
	public $created;
	public $action_item_due_date;
	public $action_item_completed_timestamp;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_action_item_title;
	public $escaped_action_item;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_action_item_title_nl2br;
	public $escaped_action_item_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrActionItemsByProjectId;
	protected static $_arrActionItemsByActionItemTypeId;
	protected static $_arrActionItemsByActionItemStatusId;
	protected static $_arrActionItemsByActionItemPriorityId;
	protected static $_arrActionItemsByActionItemCostCodeId;
	protected static $_arrActionItemsByCreatedByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllActionItems;

	// Foreign Key Objects
	private $_project;
	private $_actionItemType;
	private $_actionItemStatus;
	private $_actionItemPriority;
	private $_actionItemCostCode;
	private $_createdByContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='action_items')
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

	public function getActionItemType()
	{
		if (isset($this->_actionItemType)) {
			return $this->_actionItemType;
		} else {
			return null;
		}
	}

	public function setActionItemType($actionItemType)
	{
		$this->_actionItemType = $actionItemType;
	}

	public function getActionItemStatus()
	{
		if (isset($this->_actionItemStatus)) {
			return $this->_actionItemStatus;
		} else {
			return null;
		}
	}

	public function setActionItemStatus($actionItemStatus)
	{
		$this->_actionItemStatus = $actionItemStatus;
	}

	public function getActionItemPriority()
	{
		if (isset($this->_actionItemPriority)) {
			return $this->_actionItemPriority;
		} else {
			return null;
		}
	}

	public function setActionItemPriority($actionItemPriority)
	{
		$this->_actionItemPriority = $actionItemPriority;
	}

	public function getActionItemCostCode()
	{
		if (isset($this->_actionItemCostCode)) {
			return $this->_actionItemCostCode;
		} else {
			return null;
		}
	}

	public function setActionItemCostCode($actionItemCostCode)
	{
		$this->_actionItemCostCode = $actionItemCostCode;
	}

	public function getCreatedByContact()
	{
		if (isset($this->_createdByContact)) {
			return $this->_createdByContact;
		} else {
			return null;
		}
	}

	public function setCreatedByContact($createdByContact)
	{
		$this->_createdByContact = $createdByContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrActionItemsByProjectId()
	{
		if (isset(self::$_arrActionItemsByProjectId)) {
			return self::$_arrActionItemsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrActionItemsByProjectId($arrActionItemsByProjectId)
	{
		self::$_arrActionItemsByProjectId = $arrActionItemsByProjectId;
	}

	public static function getArrActionItemsByActionItemTypeId()
	{
		if (isset(self::$_arrActionItemsByActionItemTypeId)) {
			return self::$_arrActionItemsByActionItemTypeId;
		} else {
			return null;
		}
	}

	public static function setArrActionItemsByActionItemTypeId($arrActionItemsByActionItemTypeId)
	{
		self::$_arrActionItemsByActionItemTypeId = $arrActionItemsByActionItemTypeId;
	}

	public static function getArrActionItemsByActionItemStatusId()
	{
		if (isset(self::$_arrActionItemsByActionItemStatusId)) {
			return self::$_arrActionItemsByActionItemStatusId;
		} else {
			return null;
		}
	}

	public static function setArrActionItemsByActionItemStatusId($arrActionItemsByActionItemStatusId)
	{
		self::$_arrActionItemsByActionItemStatusId = $arrActionItemsByActionItemStatusId;
	}

	public static function getArrActionItemsByActionItemPriorityId()
	{
		if (isset(self::$_arrActionItemsByActionItemPriorityId)) {
			return self::$_arrActionItemsByActionItemPriorityId;
		} else {
			return null;
		}
	}

	public static function setArrActionItemsByActionItemPriorityId($arrActionItemsByActionItemPriorityId)
	{
		self::$_arrActionItemsByActionItemPriorityId = $arrActionItemsByActionItemPriorityId;
	}

	public static function getArrActionItemsByActionItemCostCodeId()
	{
		if (isset(self::$_arrActionItemsByActionItemCostCodeId)) {
			return self::$_arrActionItemsByActionItemCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrActionItemsByActionItemCostCodeId($arrActionItemsByActionItemCostCodeId)
	{
		self::$_arrActionItemsByActionItemCostCodeId = $arrActionItemsByActionItemCostCodeId;
	}

	public static function getArrActionItemsByCreatedByContactId()
	{
		if (isset(self::$_arrActionItemsByCreatedByContactId)) {
			return self::$_arrActionItemsByCreatedByContactId;
		} else {
			return null;
		}
	}

	public static function setArrActionItemsByCreatedByContactId($arrActionItemsByCreatedByContactId)
	{
		self::$_arrActionItemsByCreatedByContactId = $arrActionItemsByCreatedByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllActionItems()
	{
		if (isset(self::$_arrAllActionItems)) {
			return self::$_arrAllActionItems;
		} else {
			return null;
		}
	}

	public static function setArrAllActionItems($arrAllActionItems)
	{
		self::$_arrAllActionItems = $arrAllActionItems;
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
	 * @param int $action_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $action_item_id, $table='action_items', $module='ActionItem')
	{
		$actionItem = parent::findById($database, $action_item_id, $table, $module);

		return $actionItem;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $action_item_reference_type_id &$action_item_reference_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByReferenceTypeId($database, $action_item_type_id, $action_item_type_reference_id, $table='action_items', $module='ActionItem')
	{	
		$action_item_type_reference_id = (int) $action_item_type_reference_id;
		$action_item_type_id = (int) $action_item_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		SELECT
			ai.*

		FROM `action_items` ai
		WHERE ai.`action_item_type_id` = ?
		AND ai.`action_item_type_reference_id` = ?
		";		
		$arrValues = array($action_item_type_id, $action_item_type_reference_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$actionItem = array();

		if ($row) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
		}

		return $actionItem;
	}

	// Finder: Update By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $action_item_reference_type_id &$action_item_reference_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function UpdateDateByReferenceTypeId($database, $action_item_type_id, $action_item_type_reference_id, $action_item_completed_timestamp, $table='action_items', $module='ActionItem')
	{	
		$action_item_type_reference_id = (int) $action_item_type_reference_id;
		$action_item_type_id = (int) $action_item_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		UPDATE `action_items` SET `action_item_completed_timestamp` = ?
		WHERE `action_item_type_id` = ?
		AND `action_item_type_reference_id` = ?
		";		
		$arrValues = array($action_item_completed_timestamp, $action_item_type_id, $action_item_type_reference_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findActionItemByIdExtended($database, $action_item_id)
	{
		$action_item_id = (int) $action_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ai_fk_p.`id` AS 'ai_fk_p__project_id',
	ai_fk_p.`project_type_id` AS 'ai_fk_p__project_type_id',
	ai_fk_p.`user_company_id` AS 'ai_fk_p__user_company_id',
	ai_fk_p.`user_custom_project_id` AS 'ai_fk_p__user_custom_project_id',
	ai_fk_p.`project_name` AS 'ai_fk_p__project_name',
	ai_fk_p.`project_owner_name` AS 'ai_fk_p__project_owner_name',
	ai_fk_p.`latitude` AS 'ai_fk_p__latitude',
	ai_fk_p.`longitude` AS 'ai_fk_p__longitude',
	ai_fk_p.`address_line_1` AS 'ai_fk_p__address_line_1',
	ai_fk_p.`address_line_2` AS 'ai_fk_p__address_line_2',
	ai_fk_p.`address_line_3` AS 'ai_fk_p__address_line_3',
	ai_fk_p.`address_line_4` AS 'ai_fk_p__address_line_4',
	ai_fk_p.`address_city` AS 'ai_fk_p__address_city',
	ai_fk_p.`address_county` AS 'ai_fk_p__address_county',
	ai_fk_p.`address_state_or_region` AS 'ai_fk_p__address_state_or_region',
	ai_fk_p.`address_postal_code` AS 'ai_fk_p__address_postal_code',
	ai_fk_p.`address_postal_code_extension` AS 'ai_fk_p__address_postal_code_extension',
	ai_fk_p.`address_country` AS 'ai_fk_p__address_country',
	ai_fk_p.`building_count` AS 'ai_fk_p__building_count',
	ai_fk_p.`unit_count` AS 'ai_fk_p__unit_count',
	ai_fk_p.`gross_square_footage` AS 'ai_fk_p__gross_square_footage',
	ai_fk_p.`net_rentable_square_footage` AS 'ai_fk_p__net_rentable_square_footage',
	ai_fk_p.`is_active_flag` AS 'ai_fk_p__is_active_flag',
	ai_fk_p.`public_plans_flag` AS 'ai_fk_p__public_plans_flag',
	ai_fk_p.`prevailing_wage_flag` AS 'ai_fk_p__prevailing_wage_flag',
	ai_fk_p.`city_business_license_required_flag` AS 'ai_fk_p__city_business_license_required_flag',
	ai_fk_p.`is_internal_flag` AS 'ai_fk_p__is_internal_flag',
	ai_fk_p.`project_contract_date` AS 'ai_fk_p__project_contract_date',
	ai_fk_p.`project_start_date` AS 'ai_fk_p__project_start_date',
	ai_fk_p.`project_completed_date` AS 'ai_fk_p__project_completed_date',
	ai_fk_p.`sort_order` AS 'ai_fk_p__sort_order',

	ai_fk_ait.`id` AS 'ai_fk_ait__action_item_type_id',
	ai_fk_ait.`action_item_type` AS 'ai_fk_ait__action_item_type',
	ai_fk_ait.`sort_order` AS 'ai_fk_ait__sort_order',
	ai_fk_ait.`disabled_flag` AS 'ai_fk_ait__disabled_flag',

	ai_fk_ais.`id` AS 'ai_fk_ais__action_item_status_id',
	ai_fk_ais.`action_item_status` AS 'ai_fk_ais__action_item_status',
	ai_fk_ais.`disabled_flag` AS 'ai_fk_ais__disabled_flag',

	ai_fk_aip.`id` AS 'ai_fk_aip__action_item_priority_id',
	ai_fk_aip.`action_item_priority` AS 'ai_fk_aip__action_item_priority',
	ai_fk_aip.`disabled_flag` AS 'ai_fk_aip__disabled_flag',

	ai_fk_codes.`id` AS 'ai_fk_codes__cost_code_id',
	ai_fk_codes.`cost_code_division_id` AS 'ai_fk_codes__cost_code_division_id',
	ai_fk_codes.`cost_code` AS 'ai_fk_codes__cost_code',
	ai_fk_codes.`cost_code_description` AS 'ai_fk_codes__cost_code_description',
	ai_fk_codes.`cost_code_description_abbreviation` AS 'ai_fk_codes__cost_code_description_abbreviation',
	ai_fk_codes.`sort_order` AS 'ai_fk_codes__sort_order',
	ai_fk_codes.`disabled_flag` AS 'ai_fk_codes__disabled_flag',

	ai_fk_created_by_c.`id` AS 'ai_fk_created_by_c__contact_id',
	ai_fk_created_by_c.`user_company_id` AS 'ai_fk_created_by_c__user_company_id',
	ai_fk_created_by_c.`user_id` AS 'ai_fk_created_by_c__user_id',
	ai_fk_created_by_c.`contact_company_id` AS 'ai_fk_created_by_c__contact_company_id',
	ai_fk_created_by_c.`email` AS 'ai_fk_created_by_c__email',
	ai_fk_created_by_c.`name_prefix` AS 'ai_fk_created_by_c__name_prefix',
	ai_fk_created_by_c.`first_name` AS 'ai_fk_created_by_c__first_name',
	ai_fk_created_by_c.`additional_name` AS 'ai_fk_created_by_c__additional_name',
	ai_fk_created_by_c.`middle_name` AS 'ai_fk_created_by_c__middle_name',
	ai_fk_created_by_c.`last_name` AS 'ai_fk_created_by_c__last_name',
	ai_fk_created_by_c.`name_suffix` AS 'ai_fk_created_by_c__name_suffix',
	ai_fk_created_by_c.`title` AS 'ai_fk_created_by_c__title',
	ai_fk_created_by_c.`vendor_flag` AS 'ai_fk_created_by_c__vendor_flag',

	ai.*

FROM `action_items` ai
	INNER JOIN `projects` ai_fk_p ON ai.`project_id` = ai_fk_p.`id`
	INNER JOIN `action_item_types` ai_fk_ait ON ai.`action_item_type_id` = ai_fk_ait.`id`
	INNER JOIN `action_item_statuses` ai_fk_ais ON ai.`action_item_status_id` = ai_fk_ais.`id`
	INNER JOIN `action_item_priorities` ai_fk_aip ON ai.`action_item_priority_id` = ai_fk_aip.`id`
	LEFT OUTER JOIN `cost_codes` ai_fk_codes ON ai.`action_item_cost_code_id` = ai_fk_codes.`id`
	INNER JOIN `contacts` ai_fk_created_by_c ON ai.`created_by_contact_id` = ai_fk_created_by_c.`id`
WHERE ai.`id` = ?
";
		$arrValues = array($action_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$actionItem->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['ai_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'ai_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$actionItem->setProject($project);

			if (isset($row['action_item_type_id'])) {
				$action_item_type_id = $row['action_item_type_id'];
				$row['ai_fk_ait__id'] = $action_item_type_id;
				$actionItemType = self::instantiateOrm($database, 'ActionItemType', $row, null, $action_item_type_id, 'ai_fk_ait__');
				/* @var $actionItemType ActionItemType */
				$actionItemType->convertPropertiesToData();
			} else {
				$actionItemType = false;
			}
			$actionItem->setActionItemType($actionItemType);

			if (isset($row['action_item_status_id'])) {
				$action_item_status_id = $row['action_item_status_id'];
				$row['ai_fk_ais__id'] = $action_item_status_id;
				$actionItemStatus = self::instantiateOrm($database, 'ActionItemStatus', $row, null, $action_item_status_id, 'ai_fk_ais__');
				/* @var $actionItemStatus ActionItemStatus */
				$actionItemStatus->convertPropertiesToData();
			} else {
				$actionItemStatus = false;
			}
			$actionItem->setActionItemStatus($actionItemStatus);

			if (isset($row['action_item_priority_id'])) {
				$action_item_priority_id = $row['action_item_priority_id'];
				$row['ai_fk_aip__id'] = $action_item_priority_id;
				$actionItemPriority = self::instantiateOrm($database, 'ActionItemPriority', $row, null, $action_item_priority_id, 'ai_fk_aip__');
				/* @var $actionItemPriority ActionItemPriority */
				$actionItemPriority->convertPropertiesToData();
			} else {
				$actionItemPriority = false;
			}
			$actionItem->setActionItemPriority($actionItemPriority);

			if (isset($row['action_item_cost_code_id'])) {
				$action_item_cost_code_id = $row['action_item_cost_code_id'];
				$row['ai_fk_codes__id'] = $action_item_cost_code_id;
				$actionItemCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $action_item_cost_code_id, 'ai_fk_codes__');
				/* @var $actionItemCostCode CostCode */
				$actionItemCostCode->convertPropertiesToData();
			} else {
				$actionItemCostCode = false;
			}
			$actionItem->setActionItemCostCode($actionItemCostCode);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['ai_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'ai_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$actionItem->setCreatedByContact($createdByContact);

			return $actionItem;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrActionItemIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByArrActionItemIds($database, $arrActionItemIds, Input $options=null)
	{
		if (empty($arrActionItemIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrActionItemIds as $k => $action_item_id) {
			$action_item_id = (int) $action_item_id;
			$arrActionItemIds[$k] = $db->escape($action_item_id);
		}
		$csvActionItemIds = join(',', $arrActionItemIds);

		$query =
"
SELECT

	ai.*

FROM `action_items` ai
WHERE ai.`id` IN ($csvActionItemIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrActionItemsByCsvActionItemIds = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$actionItem->convertPropertiesToData();

			$arrActionItemsByCsvActionItemIds[$action_item_id] = $actionItem;
		}

		$db->free_result();

		return $arrActionItemsByCsvActionItemIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `action_items_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrActionItemsByProjectId = null;
		}

		$arrActionItemsByProjectId = self::$_arrActionItemsByProjectId;
		if (isset($arrActionItemsByProjectId) && !empty($arrActionItemsByProjectId)) {
			return $arrActionItemsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ai.*

FROM `action_items` ai
WHERE ai.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByProjectId = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$arrActionItemsByProjectId[$action_item_id] = $actionItem;
		}

		$db->free_result();

		self::$_arrActionItemsByProjectId = $arrActionItemsByProjectId;

		return $arrActionItemsByProjectId;
	}

	/**
	 * Load by constraint `action_items_fk_ait` foreign key (`action_item_type_id`) references `action_item_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $action_item_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByActionItemTypeId($database, $action_item_type_id, Input $options=null)
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
			self::$_arrActionItemsByActionItemTypeId = null;
		}

		$arrActionItemsByActionItemTypeId = self::$_arrActionItemsByActionItemTypeId;
		if (isset($arrActionItemsByActionItemTypeId) && !empty($arrActionItemsByActionItemTypeId)) {
			return $arrActionItemsByActionItemTypeId;
		}

		$action_item_type_id = (int) $action_item_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ai.*

FROM `action_items` ai
WHERE ai.`action_item_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$arrValues = array($action_item_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByActionItemTypeId = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$arrActionItemsByActionItemTypeId[$action_item_id] = $actionItem;
		}

		$db->free_result();

		self::$_arrActionItemsByActionItemTypeId = $arrActionItemsByActionItemTypeId;

		return $arrActionItemsByActionItemTypeId;
	}

	/**
	 * Load by constraint `action_items_fk_ais` foreign key (`action_item_status_id`) references `action_item_statuses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $action_item_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByActionItemStatusId($database, $action_item_status_id, Input $options=null)
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
			self::$_arrActionItemsByActionItemStatusId = null;
		}

		$arrActionItemsByActionItemStatusId = self::$_arrActionItemsByActionItemStatusId;
		if (isset($arrActionItemsByActionItemStatusId) && !empty($arrActionItemsByActionItemStatusId)) {
			return $arrActionItemsByActionItemStatusId;
		}

		$action_item_status_id = (int) $action_item_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ai.*

FROM `action_items` ai
WHERE ai.`action_item_status_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$arrValues = array($action_item_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByActionItemStatusId = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$arrActionItemsByActionItemStatusId[$action_item_id] = $actionItem;
		}

		$db->free_result();

		self::$_arrActionItemsByActionItemStatusId = $arrActionItemsByActionItemStatusId;

		return $arrActionItemsByActionItemStatusId;
	}

	/**
	 * Load by constraint `action_items_fk_aip` foreign key (`action_item_priority_id`) references `action_item_priorities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $action_item_priority_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByActionItemPriorityId($database, $action_item_priority_id, Input $options=null)
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
			self::$_arrActionItemsByActionItemPriorityId = null;
		}

		$arrActionItemsByActionItemPriorityId = self::$_arrActionItemsByActionItemPriorityId;
		if (isset($arrActionItemsByActionItemPriorityId) && !empty($arrActionItemsByActionItemPriorityId)) {
			return $arrActionItemsByActionItemPriorityId;
		}

		$action_item_priority_id = (int) $action_item_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ai.*

FROM `action_items` ai
WHERE ai.`action_item_priority_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$arrValues = array($action_item_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByActionItemPriorityId = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$arrActionItemsByActionItemPriorityId[$action_item_id] = $actionItem;
		}

		$db->free_result();

		self::$_arrActionItemsByActionItemPriorityId = $arrActionItemsByActionItemPriorityId;

		return $arrActionItemsByActionItemPriorityId;
	}

	/**
	 * Load by constraint `action_items_fk_codes` foreign key (`action_item_cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $action_item_cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByActionItemCostCodeId($database, $action_item_cost_code_id, Input $options=null)
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
			self::$_arrActionItemsByActionItemCostCodeId = null;
		}

		$arrActionItemsByActionItemCostCodeId = self::$_arrActionItemsByActionItemCostCodeId;
		if (isset($arrActionItemsByActionItemCostCodeId) && !empty($arrActionItemsByActionItemCostCodeId)) {
			return $arrActionItemsByActionItemCostCodeId;
		}

		$action_item_cost_code_id = (int) $action_item_cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ai.*

FROM `action_items` ai
WHERE ai.`action_item_cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$arrValues = array($action_item_cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByActionItemCostCodeId = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$arrActionItemsByActionItemCostCodeId[$action_item_id] = $actionItem;
		}

		$db->free_result();

		self::$_arrActionItemsByActionItemCostCodeId = $arrActionItemsByActionItemCostCodeId;

		return $arrActionItemsByActionItemCostCodeId;
	}

	/**
	 * Load by constraint `action_items_fk_created_by_c` foreign key (`created_by_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $created_by_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByCreatedByContactId($database, $created_by_contact_id, Input $options=null)
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
			self::$_arrActionItemsByCreatedByContactId = null;
		}

		$arrActionItemsByCreatedByContactId = self::$_arrActionItemsByCreatedByContactId;
		if (isset($arrActionItemsByCreatedByContactId) && !empty($arrActionItemsByCreatedByContactId)) {
			return $arrActionItemsByCreatedByContactId;
		}

		$created_by_contact_id = (int) $created_by_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ai.*

FROM `action_items` ai
WHERE ai.`created_by_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$arrValues = array($created_by_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByCreatedByContactId = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$arrActionItemsByCreatedByContactId[$action_item_id] = $actionItem;
		}

		$db->free_result();

		self::$_arrActionItemsByCreatedByContactId = $arrActionItemsByCreatedByContactId;

		return $arrActionItemsByCreatedByContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all action_items records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllActionItems($database, Input $options=null)
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
			self::$_arrAllActionItems = null;
		}

		$arrAllActionItems = self::$_arrAllActionItems;
		if (isset($arrAllActionItems) && !empty($arrAllActionItems)) {
			return $arrAllActionItems;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ai.*

FROM `action_items` ai{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllActionItems = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$arrAllActionItems[$action_item_id] = $actionItem;
		}

		$db->free_result();

		self::$_arrAllActionItems = $arrAllActionItems;

		return $arrAllActionItems;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	/**
	 * Load zero or more action_items by a list of discussion_item_id values via discussion_items_to_action_items.
	 *
	 * @param string $database
	 * @param array $arrDiscussionItemIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByArrDiscussionItemIds($database, $arrDiscussionItemIds, Input $options=null)
	{
		if (empty($arrDiscussionItemIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		
		// $sqlOrderByColumns = 'ai.`sort_order` ASC, di2ai.`discussion_item_id` ASC, ai.`action_item_due_date` ASC, ai.`action_item_completed_timestamp` ASC, di2ai.`action_item_id` ASC, aia_fk_ai_assignee_c.`last_name` ASC, aia_fk_ai_assignee_c.`first_name` ASC';
		$sqlOrderByColumns = 'ai.`action_item_type_id` ASC,ai.`id` ASC';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItem = new ActionItem($database);
			$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

			// Unique code for this method only
			if (!empty($sqlOrderByColumns)) {
				$sqlOrderByColumns = ", $sqlOrderByColumns";
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

		foreach ($arrDiscussionItemIds as $k => $discussion_item_id) {
			$discussion_item_id = (int) $discussion_item_id;
			$arrDiscussionItemIds[$k] = $db->escape($discussion_item_id);
		}
		$csvDiscussionItemIds = join(',', $arrDiscussionItemIds);

		$query =
"
SELECT

	ai_fk_p.`id` AS 'ai_fk_p__project_id',
	ai_fk_p.`project_type_id` AS 'ai_fk_p__project_type_id',
	ai_fk_p.`user_company_id` AS 'ai_fk_p__user_company_id',
	ai_fk_p.`user_custom_project_id` AS 'ai_fk_p__user_custom_project_id',
	ai_fk_p.`project_name` AS 'ai_fk_p__project_name',
	ai_fk_p.`project_owner_name` AS 'ai_fk_p__project_owner_name',
	ai_fk_p.`latitude` AS 'ai_fk_p__latitude',
	ai_fk_p.`longitude` AS 'ai_fk_p__longitude',
	ai_fk_p.`address_line_1` AS 'ai_fk_p__address_line_1',
	ai_fk_p.`address_line_2` AS 'ai_fk_p__address_line_2',
	ai_fk_p.`address_line_3` AS 'ai_fk_p__address_line_3',
	ai_fk_p.`address_line_4` AS 'ai_fk_p__address_line_4',
	ai_fk_p.`address_city` AS 'ai_fk_p__address_city',
	ai_fk_p.`address_county` AS 'ai_fk_p__address_county',
	ai_fk_p.`address_state_or_region` AS 'ai_fk_p__address_state_or_region',
	ai_fk_p.`address_postal_code` AS 'ai_fk_p__address_postal_code',
	ai_fk_p.`address_postal_code_extension` AS 'ai_fk_p__address_postal_code_extension',
	ai_fk_p.`address_country` AS 'ai_fk_p__address_country',
	ai_fk_p.`building_count` AS 'ai_fk_p__building_count',
	ai_fk_p.`unit_count` AS 'ai_fk_p__unit_count',
	ai_fk_p.`gross_square_footage` AS 'ai_fk_p__gross_square_footage',
	ai_fk_p.`net_rentable_square_footage` AS 'ai_fk_p__net_rentable_square_footage',
	ai_fk_p.`is_active_flag` AS 'ai_fk_p__is_active_flag',
	ai_fk_p.`public_plans_flag` AS 'ai_fk_p__public_plans_flag',
	ai_fk_p.`prevailing_wage_flag` AS 'ai_fk_p__prevailing_wage_flag',
	ai_fk_p.`city_business_license_required_flag` AS 'ai_fk_p__city_business_license_required_flag',
	ai_fk_p.`is_internal_flag` AS 'ai_fk_p__is_internal_flag',
	ai_fk_p.`project_contract_date` AS 'ai_fk_p__project_contract_date',
	ai_fk_p.`project_start_date` AS 'ai_fk_p__project_start_date',
	ai_fk_p.`project_completed_date` AS 'ai_fk_p__project_completed_date',
	ai_fk_p.`sort_order` AS 'ai_fk_p__sort_order',

	ai_fk_ait.`id` AS 'ai_fk_ait__action_item_type_id',
	ai_fk_ait.`action_item_type` AS 'ai_fk_ait__action_item_type',
	ai_fk_ait.`sort_order` AS 'ai_fk_ait__sort_order',
	ai_fk_ait.`disabled_flag` AS 'ai_fk_ait__disabled_flag',

	ai_fk_ais.`id` AS 'ai_fk_ais__action_item_status_id',
	ai_fk_ais.`action_item_status` AS 'ai_fk_ais__action_item_status',
	ai_fk_ais.`disabled_flag` AS 'ai_fk_ais__disabled_flag',

	ai_fk_aip.`id` AS 'ai_fk_aip__action_item_priority_id',
	ai_fk_aip.`action_item_priority` AS 'ai_fk_aip__action_item_priority',
	ai_fk_aip.`disabled_flag` AS 'ai_fk_aip__disabled_flag',

	ai_fk_codes.`id` AS 'ai_fk_codes__cost_code_id',
	ai_fk_codes.`cost_code_division_id` AS 'ai_fk_codes__cost_code_division_id',
	ai_fk_codes.`cost_code` AS 'ai_fk_codes__cost_code',
	ai_fk_codes.`cost_code_description` AS 'ai_fk_codes__cost_code_description',
	ai_fk_codes.`cost_code_description_abbreviation` AS 'ai_fk_codes__cost_code_description_abbreviation',
	ai_fk_codes.`sort_order` AS 'ai_fk_codes__sort_order',
	ai_fk_codes.`disabled_flag` AS 'ai_fk_codes__disabled_flag',

	ai_fk_created_by_c.`id` AS 'ai_fk_created_by_c__contact_id',
	ai_fk_created_by_c.`user_company_id` AS 'ai_fk_created_by_c__user_company_id',
	ai_fk_created_by_c.`user_id` AS 'ai_fk_created_by_c__user_id',
	ai_fk_created_by_c.`contact_company_id` AS 'ai_fk_created_by_c__contact_company_id',
	ai_fk_created_by_c.`email` AS 'ai_fk_created_by_c__email',
	ai_fk_created_by_c.`name_prefix` AS 'ai_fk_created_by_c__name_prefix',
	ai_fk_created_by_c.`first_name` AS 'ai_fk_created_by_c__first_name',
	ai_fk_created_by_c.`additional_name` AS 'ai_fk_created_by_c__additional_name',
	ai_fk_created_by_c.`middle_name` AS 'ai_fk_created_by_c__middle_name',
	ai_fk_created_by_c.`last_name` AS 'ai_fk_created_by_c__last_name',
	ai_fk_created_by_c.`name_suffix` AS 'ai_fk_created_by_c__name_suffix',
	ai_fk_created_by_c.`title` AS 'ai_fk_created_by_c__title',
	ai_fk_created_by_c.`vendor_flag` AS 'ai_fk_created_by_c__vendor_flag',

	aia_fk_ai_assignee_c.`id` AS 'aia_fk_ai_assignee_c__contact_id',
	aia_fk_ai_assignee_c.`user_company_id` AS 'aia_fk_ai_assignee_c__user_company_id',
	aia_fk_ai_assignee_c.`user_id` AS 'aia_fk_ai_assignee_c__user_id',
	aia_fk_ai_assignee_c.`contact_company_id` AS 'aia_fk_ai_assignee_c__contact_company_id',
	aia_fk_ai_assignee_c.`email` AS 'aia_fk_ai_assignee_c__email',
	aia_fk_ai_assignee_c.`name_prefix` AS 'aia_fk_ai_assignee_c__name_prefix',
	aia_fk_ai_assignee_c.`first_name` AS 'aia_fk_ai_assignee_c__first_name',
	aia_fk_ai_assignee_c.`additional_name` AS 'aia_fk_ai_assignee_c__additional_name',
	aia_fk_ai_assignee_c.`middle_name` AS 'aia_fk_ai_assignee_c__middle_name',
	aia_fk_ai_assignee_c.`last_name` AS 'aia_fk_ai_assignee_c__last_name',
	aia_fk_ai_assignee_c.`name_suffix` AS 'aia_fk_ai_assignee_c__name_suffix',
	aia_fk_ai_assignee_c.`title` AS 'aia_fk_ai_assignee_c__title',
	aia_fk_ai_assignee_c.`vendor_flag` AS 'aia_fk_ai_assignee_c__vendor_flag',

	ai.*,

	di2ai.`discussion_item_id`

FROM `action_items` ai
	INNER JOIN `projects` ai_fk_p ON ai.`project_id` = ai_fk_p.`id`
	INNER JOIN `action_item_types` ai_fk_ait ON ai.`action_item_type_id` = ai_fk_ait.`id`
	INNER JOIN `action_item_statuses` ai_fk_ais ON ai.`action_item_status_id` = ai_fk_ais.`id`
	INNER JOIN `action_item_priorities` ai_fk_aip ON ai.`action_item_priority_id` = ai_fk_aip.`id`
	LEFT OUTER JOIN `cost_codes` ai_fk_codes ON ai.`action_item_cost_code_id` = ai_fk_codes.`id`
	INNER JOIN `contacts` ai_fk_created_by_c ON ai.`created_by_contact_id` = ai_fk_created_by_c.`id`

	INNER JOIN `discussion_items_to_action_items` di2ai ON ai.`id` = di2ai.`action_item_id`
	LEFT OUTER JOIN action_item_assignments aia ON ai.`id` = aia.`action_item_id`
	LEFT OUTER JOIN `contacts` aia_fk_ai_assignee_c ON aia.`action_item_assignee_contact_id` = aia_fk_ai_assignee_c.`id`
WHERE di2ai.`discussion_item_id` IN ($csvDiscussionItemIds)
ORDER BY {$sqlOrderByColumns}{$sqlLimit}
";
#ORDER BY CASE WHEN ai.`action_item_due_date` = '0000-00-00' THEN 1 ELSE 0 END{$sqlOrderByColumns}{$sqlLimit}

		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByDiscussionItemIds = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$actionItem->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['ai_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'ai_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$actionItem->setProject($project);

			if (isset($row['action_item_type_id'])) {
				$action_item_type_id = $row['action_item_type_id'];
				$row['ai_fk_ait__id'] = $action_item_type_id;
				$actionItemType = self::instantiateOrm($database, 'ActionItemType', $row, null, $action_item_type_id, 'ai_fk_ait__');
				/* @var $actionItemType ActionItemType */
				$actionItemType->convertPropertiesToData();
			} else {
				$actionItemType = false;
			}
			$actionItem->setActionItemType($actionItemType);

			if (isset($row['action_item_status_id'])) {
				$action_item_status_id = $row['action_item_status_id'];
				$row['ai_fk_ais__id'] = $action_item_status_id;
				$actionItemStatus = self::instantiateOrm($database, 'ActionItemStatus', $row, null, $action_item_status_id, 'ai_fk_ais__');
				/* @var $actionItemStatus ActionItemStatus */
				$actionItemStatus->convertPropertiesToData();
			} else {
				$actionItemStatus = false;
			}
			$actionItem->setActionItemStatus($actionItemStatus);

			if (isset($row['action_item_priority_id'])) {
				$action_item_priority_id = $row['action_item_priority_id'];
				$row['ai_fk_aip__id'] = $action_item_priority_id;
				$actionItemPriority = self::instantiateOrm($database, 'ActionItemPriority', $row, null, $action_item_priority_id, 'ai_fk_aip__');
				/* @var $actionItemPriority ActionItemPriority */
				$actionItemPriority->convertPropertiesToData();
			} else {
				$actionItemPriority = false;
			}
			$actionItem->setActionItemPriority($actionItemPriority);

			if (isset($row['action_item_cost_code_id'])) {
				$action_item_cost_code_id = $row['action_item_cost_code_id'];
				$row['ai_fk_codes__id'] = $action_item_cost_code_id;
				$actionItemCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $action_item_cost_code_id, 'ai_fk_codes__');
				/* @var $actionItemCostCode CostCode */
				$actionItemCostCode->convertPropertiesToData();
			} else {
				$actionItemCostCode = false;
			}
			$actionItem->setActionItemCostCode($actionItemCostCode);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['ai_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'ai_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$actionItem->setCreatedByContact($createdByContact);

			if (isset($row['aia_fk_ai_assignee_c__contact_id'])) {
				$action_item_assignee_contact_id = $row['aia_fk_ai_assignee_c__contact_id'];
				$row['aia_fk_ai_assignee_c__id'] = $action_item_assignee_contact_id;
				$actionItemAssigneeContact = self::instantiateOrm($database, 'Contact', $row, null, $action_item_assignee_contact_id, 'aia_fk_ai_assignee_c__');
				/* @var $actionItemAssigneeContact Contact */
				$actionItemAssigneeContact->convertPropertiesToData();
			} else {
				$actionItemAssigneeContact = false;
			}
			$actionItem->setActionItemAssigneeContact($actionItemAssigneeContact);

			$discussion_item_id = $row['discussion_item_id'];

			$arrActionItemsByDiscussionItemIds[$discussion_item_id][$action_item_id] = $actionItem;
		}
		$db->free_result();

		return $arrActionItemsByDiscussionItemIds;
	}
		// Save: insert ignore

	/**
	 * Load zero or more action_items by a list of discussion_item_id values via discussion_items_to_action_items for Report with from and end date comparison.
	 *
	 * @param string $database
	 * @param array $arrDiscussionItemIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemsByProjectReport($database, $project_id, $begindate, $endate, Input $options=null)
	{
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}
$arrActionItemsByDiscussionItemIds = array();
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query =
"
SELECT

	ai_fk_p.`id` AS 'ai_fk_p__project_id',
	ai_fk_p.`project_type_id` AS 'ai_fk_p__project_type_id',
	ai_fk_p.`user_company_id` AS 'ai_fk_p__user_company_id',
	ai_fk_p.`user_custom_project_id` AS 'ai_fk_p__user_custom_project_id',
	ai_fk_p.`project_name` AS 'ai_fk_p__project_name',
	ai_fk_p.`project_owner_name` AS 'ai_fk_p__project_owner_name',
	ai_fk_p.`latitude` AS 'ai_fk_p__latitude',
	ai_fk_p.`longitude` AS 'ai_fk_p__longitude',
	ai_fk_p.`address_line_1` AS 'ai_fk_p__address_line_1',
	ai_fk_p.`address_line_2` AS 'ai_fk_p__address_line_2',
	ai_fk_p.`address_line_3` AS 'ai_fk_p__address_line_3',
	ai_fk_p.`address_line_4` AS 'ai_fk_p__address_line_4',
	ai_fk_p.`address_city` AS 'ai_fk_p__address_city',
	ai_fk_p.`address_county` AS 'ai_fk_p__address_county',
	ai_fk_p.`address_state_or_region` AS 'ai_fk_p__address_state_or_region',
	ai_fk_p.`address_postal_code` AS 'ai_fk_p__address_postal_code',
	ai_fk_p.`address_postal_code_extension` AS 'ai_fk_p__address_postal_code_extension',
	ai_fk_p.`address_country` AS 'ai_fk_p__address_country',
	ai_fk_p.`building_count` AS 'ai_fk_p__building_count',
	ai_fk_p.`unit_count` AS 'ai_fk_p__unit_count',
	ai_fk_p.`gross_square_footage` AS 'ai_fk_p__gross_square_footage',
	ai_fk_p.`net_rentable_square_footage` AS 'ai_fk_p__net_rentable_square_footage',
	ai_fk_p.`is_active_flag` AS 'ai_fk_p__is_active_flag',
	ai_fk_p.`public_plans_flag` AS 'ai_fk_p__public_plans_flag',
	ai_fk_p.`prevailing_wage_flag` AS 'ai_fk_p__prevailing_wage_flag',
	ai_fk_p.`city_business_license_required_flag` AS 'ai_fk_p__city_business_license_required_flag',
	ai_fk_p.`is_internal_flag` AS 'ai_fk_p__is_internal_flag',
	ai_fk_p.`project_contract_date` AS 'ai_fk_p__project_contract_date',
	ai_fk_p.`project_start_date` AS 'ai_fk_p__project_start_date',
	ai_fk_p.`project_completed_date` AS 'ai_fk_p__project_completed_date',
	ai_fk_p.`sort_order` AS 'ai_fk_p__sort_order',

	ai_fk_ait.`id` AS 'ai_fk_ait__action_item_type_id',
	ai_fk_ait.`action_item_type` AS 'ai_fk_ait__action_item_type',
	ai_fk_ait.`sort_order` AS 'ai_fk_ait__sort_order',
	ai_fk_ait.`disabled_flag` AS 'ai_fk_ait__disabled_flag',

	ai_fk_ais.`id` AS 'ai_fk_ais__action_item_status_id',
	ai_fk_ais.`action_item_status` AS 'ai_fk_ais__action_item_status',
	ai_fk_ais.`disabled_flag` AS 'ai_fk_ais__disabled_flag',

	ai_fk_aip.`id` AS 'ai_fk_aip__action_item_priority_id',
	ai_fk_aip.`action_item_priority` AS 'ai_fk_aip__action_item_priority',
	ai_fk_aip.`disabled_flag` AS 'ai_fk_aip__disabled_flag',

	ai_fk_codes.`id` AS 'ai_fk_codes__cost_code_id',
	ai_fk_codes.`cost_code_division_id` AS 'ai_fk_codes__cost_code_division_id',
	ai_fk_codes.`cost_code` AS 'ai_fk_codes__cost_code',
	ai_fk_codes.`cost_code_description` AS 'ai_fk_codes__cost_code_description',
	ai_fk_codes.`cost_code_description_abbreviation` AS 'ai_fk_codes__cost_code_description_abbreviation',
	ai_fk_codes.`sort_order` AS 'ai_fk_codes__sort_order',
	ai_fk_codes.`disabled_flag` AS 'ai_fk_codes__disabled_flag',

	ai_fk_created_by_c.`id` AS 'ai_fk_created_by_c__contact_id',
	ai_fk_created_by_c.`user_company_id` AS 'ai_fk_created_by_c__user_company_id',
	ai_fk_created_by_c.`user_id` AS 'ai_fk_created_by_c__user_id',
	ai_fk_created_by_c.`contact_company_id` AS 'ai_fk_created_by_c__contact_company_id',
	ai_fk_created_by_c.`email` AS 'ai_fk_created_by_c__email',
	ai_fk_created_by_c.`name_prefix` AS 'ai_fk_created_by_c__name_prefix',
	ai_fk_created_by_c.`first_name` AS 'ai_fk_created_by_c__first_name',
	ai_fk_created_by_c.`additional_name` AS 'ai_fk_created_by_c__additional_name',
	ai_fk_created_by_c.`middle_name` AS 'ai_fk_created_by_c__middle_name',
	ai_fk_created_by_c.`last_name` AS 'ai_fk_created_by_c__last_name',
	ai_fk_created_by_c.`name_suffix` AS 'ai_fk_created_by_c__name_suffix',
	ai_fk_created_by_c.`title` AS 'ai_fk_created_by_c__title',
	ai_fk_created_by_c.`vendor_flag` AS 'ai_fk_created_by_c__vendor_flag',

	aia_fk_ai_assignee_c.`id` AS 'aia_fk_ai_assignee_c__contact_id',
	aia_fk_ai_assignee_c.`user_company_id` AS 'aia_fk_ai_assignee_c__user_company_id',
	aia_fk_ai_assignee_c.`user_id` AS 'aia_fk_ai_assignee_c__user_id',
	aia_fk_ai_assignee_c.`contact_company_id` AS 'aia_fk_ai_assignee_c__contact_company_id',
	aia_fk_ai_assignee_c.`email` AS 'aia_fk_ai_assignee_c__email',
	aia_fk_ai_assignee_c.`name_prefix` AS 'aia_fk_ai_assignee_c__name_prefix',
	aia_fk_ai_assignee_c.`first_name` AS 'aia_fk_ai_assignee_c__first_name',
	aia_fk_ai_assignee_c.`additional_name` AS 'aia_fk_ai_assignee_c__additional_name',
	aia_fk_ai_assignee_c.`middle_name` AS 'aia_fk_ai_assignee_c__middle_name',
	aia_fk_ai_assignee_c.`last_name` AS 'aia_fk_ai_assignee_c__last_name',
	aia_fk_ai_assignee_c.`name_suffix` AS 'aia_fk_ai_assignee_c__name_suffix',
	aia_fk_ai_assignee_c.`title` AS 'aia_fk_ai_assignee_c__title',
	aia_fk_ai_assignee_c.`vendor_flag` AS 'aia_fk_ai_assignee_c__vendor_flag',

	ai.*,

	di2ai.`discussion_item_id`,
	di.discussion_item_status_id

FROM `action_items` ai
	INNER JOIN `projects` ai_fk_p ON ai.`project_id` = ai_fk_p.`id`
	INNER JOIN `action_item_types` ai_fk_ait ON ai.`action_item_type_id` = ai_fk_ait.`id`
	INNER JOIN `action_item_statuses` ai_fk_ais ON ai.`action_item_status_id` = ai_fk_ais.`id`
	INNER JOIN `action_item_priorities` ai_fk_aip ON ai.`action_item_priority_id` = ai_fk_aip.`id`
	LEFT OUTER JOIN `cost_codes` ai_fk_codes ON ai.`action_item_cost_code_id` = ai_fk_codes.`id`
	INNER JOIN `contacts` ai_fk_created_by_c ON ai.`created_by_contact_id` = ai_fk_created_by_c.`id`

	INNER JOIN `discussion_items_to_action_items` di2ai ON ai.`id` = di2ai.`action_item_id`
	LEFT OUTER JOIN action_item_assignments aia ON ai.`id` = aia.`action_item_id`
	LEFT OUTER JOIN `contacts` aia_fk_ai_assignee_c ON aia.`action_item_assignee_contact_id` = aia_fk_ai_assignee_c.`id`
	RIGHT JOIN discussion_items di ON di.id = di2ai.discussion_item_id
WHERE ai.`project_id`= $project_id AND di.discussion_item_status_id = 1  AND date(ai.`created`) BETWEEN '$begindate' AND '$endate' ";
		
		$db->execute($query);
	
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$actionItem->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['ai_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'ai_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$actionItem->setProject($project);

			if (isset($row['action_item_type_id'])) {
				$action_item_type_id = $row['action_item_type_id'];
				$row['ai_fk_ait__id'] = $action_item_type_id;
				$actionItemType = self::instantiateOrm($database, 'ActionItemType', $row, null, $action_item_type_id, 'ai_fk_ait__');
				/* @var $actionItemType ActionItemType */
				$actionItemType->convertPropertiesToData();
			} else {
				$actionItemType = false;
			}
			$actionItem->setActionItemType($actionItemType);

			if (isset($row['action_item_status_id'])) {
				$action_item_status_id = $row['action_item_status_id'];
				$row['ai_fk_ais__id'] = $action_item_status_id;
				$actionItemStatus = self::instantiateOrm($database, 'ActionItemStatus', $row, null, $action_item_status_id, 'ai_fk_ais__');
				/* @var $actionItemStatus ActionItemStatus */
				$actionItemStatus->convertPropertiesToData();
			} else {
				$actionItemStatus = false;
			}
			$actionItem->setActionItemStatus($actionItemStatus);

			if (isset($row['action_item_priority_id'])) {
				$action_item_priority_id = $row['action_item_priority_id'];
				$row['ai_fk_aip__id'] = $action_item_priority_id;
				$actionItemPriority = self::instantiateOrm($database, 'ActionItemPriority', $row, null, $action_item_priority_id, 'ai_fk_aip__');
				/* @var $actionItemPriority ActionItemPriority */
				$actionItemPriority->convertPropertiesToData();
			} else {
				$actionItemPriority = false;
			}
			$actionItem->setActionItemPriority($actionItemPriority);

			if (isset($row['action_item_cost_code_id'])) {
				$action_item_cost_code_id = $row['action_item_cost_code_id'];
				$row['ai_fk_codes__id'] = $action_item_cost_code_id;
				$actionItemCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $action_item_cost_code_id, 'ai_fk_codes__');
				/* @var $actionItemCostCode CostCode */
				$actionItemCostCode->convertPropertiesToData();
			} else {
				$actionItemCostCode = false;
			}
			$actionItem->setActionItemCostCode($actionItemCostCode);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['ai_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'ai_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$actionItem->setCreatedByContact($createdByContact);

			if (isset($row['aia_fk_ai_assignee_c__contact_id'])) {
				$action_item_assignee_contact_id = $row['aia_fk_ai_assignee_c__contact_id'];
				$row['aia_fk_ai_assignee_c__id'] = $action_item_assignee_contact_id;
				$actionItemAssigneeContact = self::instantiateOrm($database, 'Contact', $row, null, $action_item_assignee_contact_id, 'aia_fk_ai_assignee_c__');
				/* @var $actionItemAssigneeContact Contact */
				$actionItemAssigneeContact->convertPropertiesToData();
			} else {
				$actionItemAssigneeContact = false;
			}
			$actionItem->setActionItemAssigneeContact($actionItemAssigneeContact);

			$discussion_item_id = $row['discussion_item_id'];

			$arrActionItemsByDiscussionItemIds[$action_item_id] = $actionItem;
		}
		$db->free_result();

		return $arrActionItemsByDiscussionItemIds;
	}
	/**
	 * Delete the associated action_items records and return an array of their id values.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @return Mixed (void | array)
	 */
	public static function deleteActionItemsByDiscussionItemId($database, $discussion_item_id)
	{
		$discussion_item_id = (int) $discussion_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ai.`id` AS 'action_item_id'

FROM `action_items` ai
	INNER JOIN `discussion_items_to_action_items` di2ai ON ai.`id` = di2ai.`action_item_id`

WHERE di2ai.`discussion_item_id` = ?
ORDER BY ai.`sort_order` ASC, ai.`id` ASC;
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `action_item_type_id` ASC, `action_item_sequence_number` ASC, `action_item_status_id` ASC, `action_item_priority_id` ASC, `action_item_cost_code_id` ASC, `created_by_contact_id` ASC, `action_item_title` ASC, `action_item` ASC, `created` ASC, `action_item_due_date` ASC, `action_item_completed_timestamp` ASC, `sort_order` ASC
		$arrValues = array($discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByDiscussionItemId = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['action_item_id'];
			$arrActionItemsByDiscussionItemId[$action_item_id] = 1;
		}

		$db->free_result();

		if (!empty($arrActionItemsByDiscussionItemId)) {
			$arrActionItemsIds = array_keys($arrActionItemsByDiscussionItemId);
			$csvActionItemIds = join(',', $arrActionItemsIds);

			$query =
"
DELETE
FROM `action_items`
WHERE `id` IN ($csvActionItemIds)
";
			$db->query($query, MYSQLI_USE_RESULT);
			$db->free_result();
		}
	}
	/**
	 * Load all action_items records By user id.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllActionItemsTotalApi($database, $project_id, $user_id, $userRole, $projManager, Input $options=null)
	{
		$forceLoadFlag = false;
		$fromCase="`action_items` ai";
		$selectCase = "ai.*";
		$arrValues = array();
		$arrValues[] = $project_id;
		$returnType = '';
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

			$sqlOrderBy = "\nORDER BY ai.`sort_order` ASC";
			if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
				$tmpActionItem = new ActionItem($database);
				$sqlOrderByColumns = $tmpActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

				if (!empty($sqlOrderByColumns)) {
					$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
				}
			}

			// where condition with user
			$userBased = $options->userBased;
			if($userBased) {
				$whereConAdd = " AND contacts.`user_id` = ?";
				$fromCase = "
				`contacts` 
				INNER JOIN `action_item_assignments` 
					ON action_item_assignments.`action_item_assignee_contact_id` = contacts.`id` 
				INNER JOIN
				 `action_items` `ai`
					ON  action_item_assignments.`action_item_id` = ai.`id`
				";
				$arrValues[] = $user_id;
			}
			if(isset($options->action_item_type_id)) {
				$action_item_type_id = $options->action_item_type_id;
				// $whereConAdd .= " AND ai.`action_item_type_id` = ?";
				// $arrValues[] = $action_item_type_id;
			}
			// where due date by format
			$dateDifferBW = $options->dateDifferBW;
			if($dateDifferBW) {
				$dateDifferFormatType = $options->dateDifferFormatType;
				$filter_completed_date = null;
				if ($options->filter_completed_date) {
					$filter_completed_date = $options->filter_completed_date;	
				}
				switch($dateDifferFormatType) {
					// 0 - 7 days without completed
					case 1:
					$mindueDate = date('Y-m-d');
					$maxDueDate	= date('Y-m-d', strtotime('+7 days'));
					$compDate = '0000-00-00 00:00:00';
					$whereConAdd .= " AND date(ai.`action_item_due_date`) >= ? AND date(ai.`action_item_due_date`) <= ? AND ( ai.`action_item_completed_timestamp` = ? )";
					$arrValues[] = $mindueDate;
					$arrValues[] = $maxDueDate;
					$arrValues[] = $compDate;
					$sqlOrderBy .= ', ai.`action_item_due_date` IS NULL ASC, ai.`action_item_due_date` ASC';
					break;
					// 7 - 15 days without completed
					case 2:
					$mindueDate = date('Y-m-d', strtotime('+8 days'));
					$maxDueDate	= date('Y-m-d', strtotime('+15 days'));
					$compDate = '0000-00-00 00:00:00';
					$whereConAdd .= " AND date(ai.`action_item_due_date`) > ? AND date(ai.`action_item_due_date`) <= ? AND (  ai.`action_item_completed_timestamp` = ? )";
					$arrValues[] = $mindueDate;
					$arrValues[] = $maxDueDate;
					$arrValues[] = $compDate;
					$sqlOrderBy .= ', ai.`action_item_due_date` IS NULL ASC, ai.`action_item_due_date` ASC';
					break;
					// overdue without completed
					case 3:
					$mindueDate = date('Y-m-d');
					$maxDueDate	= date('Y-m-d', strtotime('+0 days'));
					$compDate = '0000-00-00 00:00:00';
					$whereConAdd .= " AND date(ai.`action_item_due_date`) < ? AND (  ai.`action_item_completed_timestamp` = ? )";
					$arrValues[] = $mindueDate;
					$arrValues[] = $compDate;
					$sqlOrderBy .= ', ai.`action_item_due_date` IS NULL ASC, ai.`action_item_due_date` ASC';
					break;
					// TBD without completed
					case 4:
					$mindueDate = '0000-00-00 00:00:00';
					$compDate = '0000-00-00 00:00:00';
					$whereConAdd .= " AND ( ai.`action_item_due_date` IS NULL OR ai.`action_item_due_date` = ? ) AND ( ai.`action_item_completed_timestamp` = ? )";
					$arrValues[] = $mindueDate;
					$arrValues[] = $compDate;
					$sqlOrderBy .= ', ai.`action_item_due_date` IS NULL ASC, ai.`action_item_due_date` ASC';
					break;
					// completed
					case 5:
					$compDate = '0000-00-00 00:00:00';
					if ($filter_completed_date) {
						$whereConAdd .= " AND date(ai.`action_item_completed_timestamp`) = ? ";
						$arrValues[] = $filter_completed_date;
					} else {
						$whereConAdd .= " AND ( ai.`action_item_completed_timestamp` != ? )";
						$arrValues[] = $compDate;
					}
					
					$sqlOrderBy .= ', ai.`action_item_completed_timestamp` DESC';
					
					break;
					// all without completed
					default:
					$compDate = '0000-00-00 00:00:00';
					$whereConAdd .= " AND ( ai.`action_item_completed_timestamp` = ? )";
					$arrValues[] = $compDate;
					$sqlOrderBy .= ', ai.`action_item_due_date` IS NULL ASC, ai.`action_item_due_date` ASC';
					break;
				}
			}
			// return type count
			$returnType = $options->returnType;
			if($returnType == 'Count') {
				$selectCase = "count(ai.`id`) as total";
			}
		}

		if ($forceLoadFlag) {
			self::$_arrAllActionItems = null;
		}

		$arrAllActionItems = self::$_arrAllActionItems;
		if (isset($arrAllActionItems) && !empty($arrAllActionItems)) {
			return $arrAllActionItems;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();

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
		{$selectCase}
		FROM {$fromCase}
		WHERE ai.`project_id` = ?{$whereConAdd}
		{$sqlOrderBy}{$sqlLimit}
		";
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllActionItems = array();
		
		if($returnType == '') {
			while ($row = $db->fetch()) {
				$action_item_id = $row['id'];
				$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
				/* @var $actionItem ActionItem */
				// $arrAllActionItems[$action_item_id] = $actionItem;
				$arrAllActionItems[$action_item_id]['item_title'] = $actionItem->action_item;
				$arrAllActionItems[$action_item_id]['item_id'] = $actionItem->action_item_id;
				$arrAllActionItems[$action_item_id]['item_due_date'] = date('m/d/Y', strtotime($actionItem->action_item_due_date));
				// due date convert
				if ($actionItem->action_item_due_date != '0000-00-00 00:00:00' && $actionItem->action_item_due_date != Null) {
					$arrAllActionItems[$action_item_id]['item_due_date'] = date('m/d/Y', strtotime($actionItem->action_item_due_date));
				} else {
					$arrAllActionItems[$action_item_id]['item_due_date'] = '-';
				}
				// completed date convert 
				if ($actionItem->action_item_completed_timestamp != '0000-00-00 00:00:00') {
					$arrAllActionItems[$action_item_id]['item_completed_date'] = date('m/d/Y', strtotime($actionItem->action_item_completed_timestamp));
				} else {
					$arrAllActionItems[$action_item_id]['item_completed_date'] = '-';
				}
				// check date format type
				$date_format_type = 0;
				if ($arrAllActionItems[$action_item_id]['item_due_date'] != '-') {
					$due_date_str = strtotime(date('Y-m-d',strtotime($arrAllActionItems[$action_item_id]['item_due_date'])));
					$cur_date_str = strtotime(date('Y-m-d'));
					$seven_date_str = strtotime(date('Y-m-d', strtotime('+7 days')));
					$eight_date_str = strtotime(date('Y-m-d', strtotime('+8 days')));
					$fifteen_date_str = strtotime(date('Y-m-d', strtotime('+15 days')));
					if ($due_date_str <= $seven_date_str) {
						$date_format_type = 1;
					}
					if ($due_date_str >= $eight_date_str && $due_date_str <= $fifteen_date_str) {
						$date_format_type = 2;
					}
					if ($due_date_str < $cur_date_str) {
						$date_format_type = 3;
					}
				}
				$arrAllActionItems[$action_item_id]['date_format_type'] = $date_format_type;
				$arrAllActionItems[$action_item_id]['item_assignees'] = null;
				
			}
		} else {
			$row = $db->fetch();
			return $row;
		}

		$db->free_result();

		self::$_arrAllActionItems = $arrAllActionItems;

		return $arrAllActionItems;
	}
		/**
	 * Load the detail of action item by action_item_id
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @return Mixed (void | array)
	 */
	public static function loadActionItemsDetailById($database, $action_item_id)
	{
		$action_item_id = (int) $action_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
"
SELECT
	ai.`id` AS 'action_item_id',
	di.`id` AS 'discussion_item_id',
	m.`id` AS 'meeting_id',
	m.`meeting_type_id` AS 'meeting_type_id'
FROM `action_items` ai
	INNER JOIN `discussion_items_to_action_items` di2ai ON ai.`id` = di2ai.`action_item_id`
	INNER JOIN `discussion_items` di ON di.`id` = di2ai.`discussion_item_id`
	INNER JOIN `meetings` m ON m.`id` = di.`meeting_id`
WHERE ai.`id` = ?
ORDER BY ai.`sort_order` ASC, ai.`id` ASC;
";

		$arrValues = array($action_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemsByDiscussionItemId = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['action_item_id'];
			$discussion_item_id = $row['discussion_item_id'];
			$meeting_id = $row['meeting_id'];
			$meeting_type_id = $row['meeting_type_id'];

			$arrActionItemsByDiscussionItemId['meeting_type_id'] = $meeting_type_id;
			$arrActionItemsByDiscussionItemId['meeting_id'] = $meeting_id;
			$arrActionItemsByDiscussionItemId['discussion_item_id'] = $discussion_item_id;
			$arrActionItemsByDiscussionItemId['action_item_id'] = $action_item_id;
		}

		$db->free_result();
		return $arrActionItemsByDiscussionItemId;
	}
	/**
	 * Load the detail of action item by action_item_id
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @return Mixed (void | array)
	 */
	public static function loadActionItemsDetailByDueDateApi($database, $action_item_due_date)
	{

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
"
SELECT
	ai.*
FROM `action_items` ai
WHERE ai.`action_item_due_date` = ?
";

		$arrValues = array($action_item_due_date);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllActionItems = array();
		while ($row = $db->fetch()) {
			$action_item_id = $row['id'];
			$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id);
			/* @var $actionItem ActionItem */
			$arrAllActionItems[$action_item_id] = $actionItem;
		}

		$db->free_result();
		return $arrAllActionItems;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

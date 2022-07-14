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
 * ActionItemAssignment.
 *
 * @category   Framework
 * @package    ActionItemAssignment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ActionItemAssignment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ActionItemAssignment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'action_item_assignments';

	/**
	 * primary key (`action_item_id`,`action_item_assignee_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'action_item_id' => 'int',
		'action_item_assignee_contact_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_action_item_assignment_via_primary_key' => array(
			'action_item_id' => 'int',
			'action_item_assignee_contact_id' => 'int'
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
		'action_item_id' => 'action_item_id',
		'action_item_assignee_contact_id' => 'action_item_assignee_contact_id',
		'notify_flag' => 'notify_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $action_item_id;
	public $action_item_assignee_contact_id;
	public $notify_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrActionItemAssignmentsByActionItemId;
	protected static $_arrActionItemAssignmentsByActionItemAssigneeContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllActionItemAssignments;

	// Foreign Key Objects
	private $_actionItem;
	private $_actionItemAssigneeContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='action_item_assignments')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getActionItem()
	{
		if (isset($this->_actionItem)) {
			return $this->_actionItem;
		} else {
			return null;
		}
	}

	public function setActionItem($actionItem)
	{
		$this->_actionItem = $actionItem;
	}

	public function getActionItemAssigneeContact()
	{
		if (isset($this->_actionItemAssigneeContact)) {
			return $this->_actionItemAssigneeContact;
		} else {
			return null;
		}
	}

	public function setActionItemAssigneeContact($actionItemAssigneeContact)
	{
		$this->_actionItemAssigneeContact = $actionItemAssigneeContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrActionItemAssignmentsByActionItemId()
	{
		if (isset(self::$_arrActionItemAssignmentsByActionItemId)) {
			return self::$_arrActionItemAssignmentsByActionItemId;
		} else {
			return null;
		}
	}

	public static function setArrActionItemAssignmentsByActionItemId($arrActionItemAssignmentsByActionItemId)
	{
		self::$_arrActionItemAssignmentsByActionItemId = $arrActionItemAssignmentsByActionItemId;
	}

	public static function getArrActionItemAssignmentsByActionItemAssigneeContactId()
	{
		if (isset(self::$_arrActionItemAssignmentsByActionItemAssigneeContactId)) {
			return self::$_arrActionItemAssignmentsByActionItemAssigneeContactId;
		} else {
			return null;
		}
	}

	public static function setArrActionItemAssignmentsByActionItemAssigneeContactId($arrActionItemAssignmentsByActionItemAssigneeContactId)
	{
		self::$_arrActionItemAssignmentsByActionItemAssigneeContactId = $arrActionItemAssignmentsByActionItemAssigneeContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllActionItemAssignments()
	{
		if (isset(self::$_arrAllActionItemAssignments)) {
			return self::$_arrAllActionItemAssignments;
		} else {
			return null;
		}
	}

	public static function setArrAllActionItemAssignments($arrAllActionItemAssignments)
	{
		self::$_arrAllActionItemAssignments = $arrAllActionItemAssignments;
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
	 * Find by primary key (`action_item_id`,`action_item_assignee_contact_id`).
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @param int $action_item_assignee_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByActionItemIdAndActionItemAssigneeContactId($database, $action_item_id, $action_item_assignee_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	aia.*

FROM `action_item_assignments` aia
WHERE aia.`action_item_id` = ?
AND aia.`action_item_assignee_contact_id` = ?
";
		$arrValues = array($action_item_id, $action_item_assignee_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$actionItemAssignment = self::instantiateOrm($database, 'ActionItemAssignment', $row);
			/* @var $actionItemAssignment ActionItemAssignment */
			return $actionItemAssignment;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`action_item_id`,`action_item_assignee_contact_id`) Extended.
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @param int $action_item_assignee_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByActionItemIdAndActionItemAssigneeContactIdExtended($database, $action_item_id, $action_item_assignee_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	aia_fk_ai.`id` AS 'aia_fk_ai__action_item_id',
	aia_fk_ai.`project_id` AS 'aia_fk_ai__project_id',
	aia_fk_ai.`action_item_type_id` AS 'aia_fk_ai__action_item_type_id',
	aia_fk_ai.`action_item_sequence_number` AS 'aia_fk_ai__action_item_sequence_number',
	aia_fk_ai.`action_item_status_id` AS 'aia_fk_ai__action_item_status_id',
	aia_fk_ai.`action_item_priority_id` AS 'aia_fk_ai__action_item_priority_id',
	aia_fk_ai.`action_item_cost_code_id` AS 'aia_fk_ai__action_item_cost_code_id',
	aia_fk_ai.`created_by_contact_id` AS 'aia_fk_ai__created_by_contact_id',
	aia_fk_ai.`action_item_title` AS 'aia_fk_ai__action_item_title',
	aia_fk_ai.`action_item` AS 'aia_fk_ai__action_item',
	aia_fk_ai.`created` AS 'aia_fk_ai__created',
	aia_fk_ai.`action_item_due_date` AS 'aia_fk_ai__action_item_due_date',
	aia_fk_ai.`action_item_completed_timestamp` AS 'aia_fk_ai__action_item_completed_timestamp',
	aia_fk_ai.`sort_order` AS 'aia_fk_ai__sort_order',

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

	aia.*

FROM `action_item_assignments` aia
	INNER JOIN `action_items` aia_fk_ai ON aia.`action_item_id` = aia_fk_ai.`id`
	INNER JOIN `contacts` aia_fk_ai_assignee_c ON aia.`action_item_assignee_contact_id` = aia_fk_ai_assignee_c.`id`
WHERE aia.`action_item_id` = ?
AND aia.`action_item_assignee_contact_id` = ?
";
		$arrValues = array($action_item_id, $action_item_assignee_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$actionItemAssignment = self::instantiateOrm($database, 'ActionItemAssignment', $row);
			/* @var $actionItemAssignment ActionItemAssignment */
			$actionItemAssignment->convertPropertiesToData();

			if (isset($row['action_item_id'])) {
				$action_item_id = $row['action_item_id'];
				$row['aia_fk_ai__id'] = $action_item_id;
				$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id, 'aia_fk_ai__');
				/* @var $actionItem ActionItem */
				$actionItem->convertPropertiesToData();
			} else {
				$actionItem = false;
			}
			$actionItemAssignment->setActionItem($actionItem);

			if (isset($row['action_item_assignee_contact_id'])) {
				$action_item_assignee_contact_id = $row['action_item_assignee_contact_id'];
				$row['aia_fk_ai_assignee_c__id'] = $action_item_assignee_contact_id;
				$actionItemAssigneeContact = self::instantiateOrm($database, 'Contact', $row, null, $action_item_assignee_contact_id, 'aia_fk_ai_assignee_c__');
				/* @var $actionItemAssigneeContact Contact */
				$actionItemAssigneeContact->convertPropertiesToData();
			} else {
				$actionItemAssigneeContact = false;
			}
			$actionItemAssignment->setActionItemAssigneeContact($actionItemAssigneeContact);

			return $actionItemAssignment;
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
	 * @param array $arrActionItemIdAndActionItemAssigneeContactIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemAssignmentsByArrActionItemIdAndActionItemAssigneeContactIdList($database, $arrActionItemIdAndActionItemAssigneeContactIdList, Input $options=null)
	{
		if (empty($arrActionItemIdAndActionItemAssigneeContactIdList)) {
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
		// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemAssignment = new ActionItemAssignment($database);
			$sqlOrderByColumns = $tmpActionItemAssignment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrActionItemIdAndActionItemAssigneeContactIdList as $k => $arrTmp) {
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
		if (count($arrActionItemIdAndActionItemAssigneeContactIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	aia.*

FROM `action_item_assignments` aia
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemAssignmentsByArrActionItemIdAndActionItemAssigneeContactIdList = array();
		while ($row = $db->fetch()) {
			$actionItemAssignment = self::instantiateOrm($database, 'ActionItemAssignment', $row);
			/* @var $actionItemAssignment ActionItemAssignment */
			$arrActionItemAssignmentsByArrActionItemIdAndActionItemAssigneeContactIdList[] = $actionItemAssignment;
		}

		$db->free_result();

		return $arrActionItemAssignmentsByArrActionItemIdAndActionItemAssigneeContactIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `action_item_assignments_fk_ai` foreign key (`action_item_id`) references `action_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemAssignmentsByActionItemId($database, $action_item_id, Input $options=null)
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
			self::$_arrActionItemAssignmentsByActionItemId = null;
		}

		$arrActionItemAssignmentsByActionItemId = self::$_arrActionItemAssignmentsByActionItemId;
		if (isset($arrActionItemAssignmentsByActionItemId) && !empty($arrActionItemAssignmentsByActionItemId)) {
			return $arrActionItemAssignmentsByActionItemId;
		}

		$action_item_id = (int) $action_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemAssignment = new ActionItemAssignment($database);
			$sqlOrderByColumns = $tmpActionItemAssignment->constructSqlOrderByColumns($arrOrderByAttributes);

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

	aia_fk_ai.`id` AS 'aia_fk_ai__action_item_id',
	aia_fk_ai.`project_id` AS 'aia_fk_ai__project_id',
	aia_fk_ai.`action_item_type_id` AS 'aia_fk_ai__action_item_type_id',
	aia_fk_ai.`action_item_type_reference_id` AS 'aia_fk_ai__action_item_type_reference_id',
	aia_fk_ai.`action_item_sequence_number` AS 'aia_fk_ai__action_item_sequence_number',
	aia_fk_ai.`action_item_status_id` AS 'aia_fk_ai__action_item_status_id',
	aia_fk_ai.`action_item_priority_id` AS 'aia_fk_ai__action_item_priority_id',
	aia_fk_ai.`action_item_cost_code_id` AS 'aia_fk_ai__action_item_cost_code_id',
	aia_fk_ai.`created_by_contact_id` AS 'aia_fk_ai__created_by_contact_id',
	aia_fk_ai.`action_item_title` AS 'aia_fk_ai__action_item_title',
	aia_fk_ai.`action_item` AS 'aia_fk_ai__action_item',
	aia_fk_ai.`created` AS 'aia_fk_ai__created',
	aia_fk_ai.`action_item_due_date` AS 'aia_fk_ai__action_item_due_date',
	aia_fk_ai.`action_item_completed_timestamp` AS 'aia_fk_ai__action_item_completed_timestamp',
	aia_fk_ai.`sort_order` AS 'aia_fk_ai__sort_order',

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
	aia_fk_ai_assignee_c.`is_archive` AS 'aia_fk_ai_assignee_c__is_archive',

	aia.*

FROM `action_item_assignments` aia
	INNER JOIN `action_items` aia_fk_ai ON aia.`action_item_id` = aia_fk_ai.`id`
	INNER JOIN `contacts` aia_fk_ai_assignee_c ON aia.`action_item_assignee_contact_id` = aia_fk_ai_assignee_c.`id`
WHERE aia.`action_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
		$arrValues = array($action_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemAssignmentsByActionItemId = array();
		while ($row = $db->fetch()) {
			$actionItemAssignment = self::instantiateOrm($database, 'ActionItemAssignment', $row);
			/* @var $actionItemAssignment ActionItemAssignment */
			$actionItemAssignment->convertPropertiesToData();

			if (isset($row['action_item_id'])) {
				$action_item_id = $row['action_item_id'];
				$row['aia_fk_ai__id'] = $action_item_id;
				$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id, 'aia_fk_ai__');
				/* @var $actionItem ActionItem */
				$actionItem->convertPropertiesToData();
			} else {
				$actionItem = false;
			}
			$actionItemAssignment->setActionItem($actionItem);

			if (isset($row['action_item_assignee_contact_id'])) {
				$action_item_assignee_contact_id = $row['action_item_assignee_contact_id'];
				$row['aia_fk_ai_assignee_c__id'] = $action_item_assignee_contact_id;
				$actionItemAssigneeContact = self::instantiateOrm($database, 'Contact', $row, null, $action_item_assignee_contact_id, 'aia_fk_ai_assignee_c__');
				/* @var $actionItemAssigneeContact Contact */
				$actionItemAssigneeContact->convertPropertiesToData();
			} else {
				$actionItemAssigneeContact = false;
			}
			$actionItemAssignment->setActionItemAssigneeContact($actionItemAssigneeContact);

			$arrActionItemAssignmentsByActionItemId[$action_item_assignee_contact_id] = $actionItemAssignment;
		}

		$db->free_result();

		self::$_arrActionItemAssignmentsByActionItemId = $arrActionItemAssignmentsByActionItemId;

		return $arrActionItemAssignmentsByActionItemId;
	}

	/**
	 * Load by constraint `action_item_assignments_fk_ai_assignee_c` foreign key (`action_item_assignee_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $action_item_assignee_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadActionItemAssignmentsByActionItemAssigneeContactId($database, $action_item_assignee_contact_id, Input $options=null)
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
			self::$_arrActionItemAssignmentsByActionItemAssigneeContactId = null;
		}

		$arrActionItemAssignmentsByActionItemAssigneeContactId = self::$_arrActionItemAssignmentsByActionItemAssigneeContactId;
		if (isset($arrActionItemAssignmentsByActionItemAssigneeContactId) && !empty($arrActionItemAssignmentsByActionItemAssigneeContactId)) {
			return $arrActionItemAssignmentsByActionItemAssigneeContactId;
		}

		$action_item_assignee_contact_id = (int) $action_item_assignee_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemAssignment = new ActionItemAssignment($database);
			$sqlOrderByColumns = $tmpActionItemAssignment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	aia.*

FROM `action_item_assignments` aia
WHERE aia.`action_item_assignee_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
		$arrValues = array($action_item_assignee_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrActionItemAssignmentsByActionItemAssigneeContactId = array();
		while ($row = $db->fetch()) {
			$actionItemAssignment = self::instantiateOrm($database, 'ActionItemAssignment', $row);
			/* @var $actionItemAssignment ActionItemAssignment */
			$arrActionItemAssignmentsByActionItemAssigneeContactId[] = $actionItemAssignment;
		}

		$db->free_result();

		self::$_arrActionItemAssignmentsByActionItemAssigneeContactId = $arrActionItemAssignmentsByActionItemAssigneeContactId;

		return $arrActionItemAssignmentsByActionItemAssigneeContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all action_item_assignments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllActionItemAssignments($database, Input $options=null)
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
			self::$_arrAllActionItemAssignments = null;
		}

		$arrAllActionItemAssignments = self::$_arrAllActionItemAssignments;
		if (isset($arrAllActionItemAssignments) && !empty($arrAllActionItemAssignments)) {
			return $arrAllActionItemAssignments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemAssignment = new ActionItemAssignment($database);
			$sqlOrderByColumns = $tmpActionItemAssignment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	aia.*

FROM `action_item_assignments` aia{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllActionItemAssignments = array();
		while ($row = $db->fetch()) {
			$actionItemAssignment = self::instantiateOrm($database, 'ActionItemAssignment', $row);
			/* @var $actionItemAssignment ActionItemAssignment */
			$arrAllActionItemAssignments[] = $actionItemAssignment;
		}

		$db->free_result();

		self::$_arrAllActionItemAssignments = $arrAllActionItemAssignments;

		return $arrAllActionItemAssignments;
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
INTO `action_item_assignments`
(`action_item_id`, `action_item_assignee_contact_id`)
VALUES (?, ?)
";
		$arrValues = array($this->action_item_id, $this->action_item_assignee_contact_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}

	// Get: Assinees notify true false using contact_id for notification Api
	public function findByActionItemUsingContactIdApi($database, $primary_contact_id, $project_id)
	{
		// $database = $this->getDatabase();
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT aia.*, ai.id as act_id, ai.action_item_due_date FROM `action_item_assignments` as aia
LEFT JOIN `action_items` as ai ON ai.id = aia.action_item_id
WHERE `action_item_assignee_contact_id` = ? AND ai.`project_id` = ?
";
		$arrValues = array($primary_contact_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$RN_red_notify_flag = false;
		$RN_notify_flag = false;
		while($row = $db->fetch()){
			$RN_action_item_due_date = $row['action_item_due_date'];
			// due date red alert
			if ($RN_action_item_due_date == '') {
				$RN_dueDateUneditable = 'N/A';
			} else {
				$RN_dueDateUneditable = date('M j, Y', strtotime($RN_action_item_due_date));
				$current_date = date('M j, Y');
				if(strtotime($RN_dueDateUneditable) == strtotime($current_date)){
					$RN_red_notify_flag = true;
				}
			}
			// assign shown flag
			$RN_notify_flag_raw = $row['notify_flag'];
			if($RN_notify_flag_raw == 'Y'){
				$RN_notify_flag = true;
			}
		}
		$RN_arrayTmp = array();
		$RN_arrayTmp['red_notify'] = $RN_red_notify_flag;
		$RN_arrayTmp['notify'] = $RN_notify_flag;
		$db->free_result();
		return $RN_arrayTmp;
	}

	// Update: Assinees notify true false using contact_id of flag 'Y' To 'N'
	public static function UpdateByActionItemUsingContactIdApi($database, $primary_contact_id, $action_item_id)
	{
		// $database = $this->getDatabase();
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
UPDATE action_item_assignments SET `notify_flag` = 'N' WHERE `action_item_assignee_contact_id` = ? AND `action_item_id` = ?
";
		$arrValues = array($primary_contact_id, $action_item_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();
		return true;
	}

	// Finder: Delete By pk (a single auto int id or a single non auto int pk)
	/**
	 * Delete by primary key (`action_item_id`).
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @param int $action_item_assignee_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function deleteActionItemAssigneeByActionItemId($database, $action_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$action_item_id =(int) $action_item_id;
		$query =
"
DELETE
FROM action_item_assignments
WHERE action_item_id = ?
";
		$arrValues = array($action_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);		
		$db->free_result();
		return true;
	}

	// Finder: Delete By pk (a single auto int id or a single non auto int pk)
	/**
	 * Delete by primary key (`action_item_id`, `action_item_assignee_contact_id`).
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @param int $action_item_assignee_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function deleteActionItemAssigneeByActionItemAssigneeId($database, $action_item_id, $action_item_assignee_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$action_item_id =(int) $action_item_id;
		$action_item_assignee_contact_id =(int) $action_item_assignee_contact_id;
		$query =
"
DELETE
FROM action_item_assignments
WHERE action_item_id = ? AND action_item_assignee_contact_id = ?
";
		$arrValues = array($action_item_id, $action_item_assignee_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);		
		$db->free_result();
		return true;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all action_item_assignments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllActionItemAssignmentsByActionItemId($database, $action_item_id, Input $options=null)
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
			self::$_arrAllActionItemAssignments = null;
		}

		$arrAllActionItemAssignments = self::$_arrAllActionItemAssignments;
		if (isset($arrAllActionItemAssignments) && !empty($arrAllActionItemAssignments)) {
			return $arrAllActionItemAssignments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpActionItemAssignment = new ActionItemAssignment($database);
			$sqlOrderByColumns = $tmpActionItemAssignment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	aia.*
FROM `action_item_assignments` aia
WHERE aia.`action_item_id` = ?
{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `action_item_id` ASC, `action_item_assignee_contact_id` ASC
	$arrValues = array($action_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllActionItemAssignments = array();
		while ($row = $db->fetch()) {
			// $actionItemAssignment = self::instantiateOrm($database, 'ActionItemAssignment', $row);
			/* @var $actionItemAssignment ActionItemAssignment */
			$actionItemAssigneeId = $row['action_item_assignee_contact_id'];
			$arrAllActionItemAssignments[$actionItemAssigneeId] = $actionItemAssigneeId;
		}

		$db->free_result();

		// self::$_arrAllActionItemAssignments = $arrAllActionItemAssignments;

		return $arrAllActionItemAssignments;
	}

	public static function updateAassignments($database,$action_item_type_id,$action_item_type_reference_id,$old_contact_id,$new_contact_id){

		$db = DBI::getInstance($database);

		$query = "SELECT GROUP_CONCAT(id) as id FROM `action_items` WHERE `action_item_type_id`=? AND `action_item_type_reference_id`=?";
		$arrValues = array($action_item_type_id,$action_item_type_reference_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$ids = $row['id'];
		$idsArr = explode (",", $ids);  
		$db->free_result();

		foreach ($idsArr as $value) {

			$querya = "SELECT count(action_item_id) as count FROM `action_item_assignments` WHERE `action_item_id`=? AND `action_item_assignee_contact_id`=?";
			$arrValuea = array($value,$old_contact_id);
			$db->execute($querya, $arrValuea, MYSQLI_USE_RESULT);
			$row = $db->fetch();
			$count = $row['count'];
			$db->free_result();

			if($count > 0){
				$queryb = "UPDATE `action_item_assignments` SET `action_item_assignee_contact_id` = ?  WHERE `action_item_id` = ? AND `action_item_assignee_contact_id` = ?";
				$arrValueb = array($new_contact_id,$value,$old_contact_id);
				$db->execute($queryb, $arrValueb, MYSQLI_USE_RESULT);
				$db->free_result();			
			}
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

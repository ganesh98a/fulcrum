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
 * DiscussionItemToActionItem.
 *
 * @category   Framework
 * @package    DiscussionItemToActionItem
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DiscussionItemToActionItem extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DiscussionItemToActionItem';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'discussion_items_to_action_items';

	/**
	 * primary key (`discussion_item_id`,`action_item_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'discussion_item_id' => 'int',
		'action_item_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_discussion_item_to_action_item_via_primary_key' => array(
			'discussion_item_id' => 'int',
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
		'discussion_item_id' => 'discussion_item_id',
		'action_item_id' => 'action_item_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $discussion_item_id;
	public $action_item_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrDiscussionItemsToActionItemsByDiscussionItemId;
	protected static $_arrDiscussionItemsToActionItemsByActionItemId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDiscussionItemsToActionItems;

	// Foreign Key Objects
	private $_discussionItem;
	private $_actionItem;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='discussion_items_to_action_items')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getDiscussionItem()
	{
		if (isset($this->_discussionItem)) {
			return $this->_discussionItem;
		} else {
			return null;
		}
	}

	public function setDiscussionItem($discussionItem)
	{
		$this->_discussionItem = $discussionItem;
	}

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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrDiscussionItemsToActionItemsByDiscussionItemId()
	{
		if (isset(self::$_arrDiscussionItemsToActionItemsByDiscussionItemId)) {
			return self::$_arrDiscussionItemsToActionItemsByDiscussionItemId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsToActionItemsByDiscussionItemId($arrDiscussionItemsToActionItemsByDiscussionItemId)
	{
		self::$_arrDiscussionItemsToActionItemsByDiscussionItemId = $arrDiscussionItemsToActionItemsByDiscussionItemId;
	}

	public static function getArrDiscussionItemsToActionItemsByActionItemId()
	{
		if (isset(self::$_arrDiscussionItemsToActionItemsByActionItemId)) {
			return self::$_arrDiscussionItemsToActionItemsByActionItemId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsToActionItemsByActionItemId($arrDiscussionItemsToActionItemsByActionItemId)
	{
		self::$_arrDiscussionItemsToActionItemsByActionItemId = $arrDiscussionItemsToActionItemsByActionItemId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllDiscussionItemsToActionItems()
	{
		if (isset(self::$_arrAllDiscussionItemsToActionItems)) {
			return self::$_arrAllDiscussionItemsToActionItems;
		} else {
			return null;
		}
	}

	public static function setArrAllDiscussionItemsToActionItems($arrAllDiscussionItemsToActionItems)
	{
		self::$_arrAllDiscussionItemsToActionItems = $arrAllDiscussionItemsToActionItems;
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
	 * Find by primary key (`discussion_item_id`,`action_item_id`).
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param int $action_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByDiscussionItemIdAndActionItemId($database, $discussion_item_id, $action_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	di2ai.*

FROM `discussion_items_to_action_items` di2ai
WHERE di2ai.`discussion_item_id` = ?
AND di2ai.`action_item_id` = ?
";
		$arrValues = array($discussion_item_id, $action_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$discussionItemToActionItem = self::instantiateOrm($database, 'DiscussionItemToActionItem', $row);
			/* @var $discussionItemToActionItem DiscussionItemToActionItem */
			return $discussionItemToActionItem;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`discussion_item_id`,`action_item_id`) Extended.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param int $action_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByDiscussionItemIdAndActionItemIdExtended($database, $discussion_item_id, $action_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	di2ai_fk_di.`id` AS 'di2ai_fk_di__discussion_item_id',
	di2ai_fk_di.`meeting_id` AS 'di2ai_fk_di__meeting_id',
	di2ai_fk_di.`discussion_item_sequence_number` AS 'di2ai_fk_di__discussion_item_sequence_number',
	di2ai_fk_di.`discussion_item_status_id` AS 'di2ai_fk_di__discussion_item_status_id',
	di2ai_fk_di.`discussion_item_priority_id` AS 'di2ai_fk_di__discussion_item_priority_id',
	di2ai_fk_di.`discussion_item_cost_code_id` AS 'di2ai_fk_di__discussion_item_cost_code_id',
	di2ai_fk_di.`created_by_contact_id` AS 'di2ai_fk_di__created_by_contact_id',
	di2ai_fk_di.`discussion_item_title` AS 'di2ai_fk_di__discussion_item_title',
	di2ai_fk_di.`discussion_item` AS 'di2ai_fk_di__discussion_item',
	di2ai_fk_di.`created` AS 'di2ai_fk_di__created',
	di2ai_fk_di.`discussion_item_closed_date` AS 'di2ai_fk_di__discussion_item_closed_date',
	di2ai_fk_di.`sort_order` AS 'di2ai_fk_di__sort_order',

	di2ai_fk_ai.`id` AS 'di2ai_fk_ai__action_item_id',
	di2ai_fk_ai.`project_id` AS 'di2ai_fk_ai__project_id',
	di2ai_fk_ai.`action_item_type_id` AS 'di2ai_fk_ai__action_item_type_id',
	di2ai_fk_ai.`action_item_sequence_number` AS 'di2ai_fk_ai__action_item_sequence_number',
	di2ai_fk_ai.`action_item_status_id` AS 'di2ai_fk_ai__action_item_status_id',
	di2ai_fk_ai.`action_item_priority_id` AS 'di2ai_fk_ai__action_item_priority_id',
	di2ai_fk_ai.`action_item_cost_code_id` AS 'di2ai_fk_ai__action_item_cost_code_id',
	di2ai_fk_ai.`created_by_contact_id` AS 'di2ai_fk_ai__created_by_contact_id',
	di2ai_fk_ai.`action_item_title` AS 'di2ai_fk_ai__action_item_title',
	di2ai_fk_ai.`action_item` AS 'di2ai_fk_ai__action_item',
	di2ai_fk_ai.`created` AS 'di2ai_fk_ai__created',
	di2ai_fk_ai.`action_item_due_date` AS 'di2ai_fk_ai__action_item_due_date',
	di2ai_fk_ai.`action_item_completed_timestamp` AS 'di2ai_fk_ai__action_item_completed_timestamp',
	di2ai_fk_ai.`sort_order` AS 'di2ai_fk_ai__sort_order',

	di2ai.*

FROM `discussion_items_to_action_items` di2ai
	INNER JOIN `discussion_items` di2ai_fk_di ON di2ai.`discussion_item_id` = di2ai_fk_di.`id`
	INNER JOIN `action_items` di2ai_fk_ai ON di2ai.`action_item_id` = di2ai_fk_ai.`id`
WHERE di2ai.`discussion_item_id` = ?
AND di2ai.`action_item_id` = ?
";
		$arrValues = array($discussion_item_id, $action_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$discussionItemToActionItem = self::instantiateOrm($database, 'DiscussionItemToActionItem', $row);
			/* @var $discussionItemToActionItem DiscussionItemToActionItem */
			$discussionItemToActionItem->convertPropertiesToData();

			if (isset($row['discussion_item_id'])) {
				$discussion_item_id = $row['discussion_item_id'];
				$row['di2ai_fk_di__id'] = $discussion_item_id;
				$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id, 'di2ai_fk_di__');
				/* @var $discussionItem DiscussionItem */
				$discussionItem->convertPropertiesToData();
			} else {
				$discussionItem = false;
			}
			$discussionItemToActionItem->setDiscussionItem($discussionItem);

			if (isset($row['action_item_id'])) {
				$action_item_id = $row['action_item_id'];
				$row['di2ai_fk_ai__id'] = $action_item_id;
				$actionItem = self::instantiateOrm($database, 'ActionItem', $row, null, $action_item_id, 'di2ai_fk_ai__');
				/* @var $actionItem ActionItem */
				$actionItem->convertPropertiesToData();
			} else {
				$actionItem = false;
			}
			$discussionItemToActionItem->setActionItem($actionItem);

			return $discussionItemToActionItem;
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
	 * @param array $arrDiscussionItemIdAndActionItemIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsToActionItemsByArrDiscussionItemIdAndActionItemIdList($database, $arrDiscussionItemIdAndActionItemIdList, Input $options=null)
	{
		if (empty($arrDiscussionItemIdAndActionItemIdList)) {
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
		// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToActionItem = new DiscussionItemToActionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItemToActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrDiscussionItemIdAndActionItemIdList as $k => $arrTmp) {
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
		if (count($arrDiscussionItemIdAndActionItemIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	di2ai.*

FROM `discussion_items_to_action_items` di2ai
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsToActionItemsByArrDiscussionItemIdAndActionItemIdList = array();
		while ($row = $db->fetch()) {
			$discussionItemToActionItem = self::instantiateOrm($database, 'DiscussionItemToActionItem', $row);
			/* @var $discussionItemToActionItem DiscussionItemToActionItem */
			$arrDiscussionItemsToActionItemsByArrDiscussionItemIdAndActionItemIdList[] = $discussionItemToActionItem;
		}

		$db->free_result();

		return $arrDiscussionItemsToActionItemsByArrDiscussionItemIdAndActionItemIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `discussion_items_to_action_items_fk_di` foreign key (`discussion_item_id`) references `discussion_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsToActionItemsByDiscussionItemId($database, $discussion_item_id, Input $options=null)
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
			self::$_arrDiscussionItemsToActionItemsByDiscussionItemId = null;
		}

		$arrDiscussionItemsToActionItemsByDiscussionItemId = self::$_arrDiscussionItemsToActionItemsByDiscussionItemId;
		if (isset($arrDiscussionItemsToActionItemsByDiscussionItemId) && !empty($arrDiscussionItemsToActionItemsByDiscussionItemId)) {
			return $arrDiscussionItemsToActionItemsByDiscussionItemId;
		}

		$discussion_item_id = (int) $discussion_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToActionItem = new DiscussionItemToActionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItemToActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}else{
			$sqlOrderBy = "\nORDER BY di2ai_fk_di.`action_item_type_id` ASC,di2ai_fk_di.`id` ASC";
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
	di2ai.*,di2ai_fk_di.`action_item_type_id`

FROM `discussion_items_to_action_items` di2ai
INNER JOIN `action_items` di2ai_fk_di ON di2ai.`action_item_id` = di2ai_fk_di.`id`
WHERE di2ai.`discussion_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$arrValues = array($discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsToActionItemsByDiscussionItemId = array();
		while ($row = $db->fetch()) {
			$discussionItemToActionItem = self::instantiateOrm($database, 'DiscussionItemToActionItem', $row);
			/* @var $discussionItemToActionItem DiscussionItemToActionItem */
			$arrDiscussionItemsToActionItemsByDiscussionItemId[] = $discussionItemToActionItem;
		}

		$db->free_result();

		self::$_arrDiscussionItemsToActionItemsByDiscussionItemId = $arrDiscussionItemsToActionItemsByDiscussionItemId;

		return $arrDiscussionItemsToActionItemsByDiscussionItemId;
	}

	public static function countActionItemType($database, $discussion_item_id, $action_item_type_id){

		$db = DBI::getInstance($database);

		$query =
"
SELECT
	count(di2ai_fk_di.`action_item_type_id`) as count

FROM `discussion_items_to_action_items` di2ai
INNER JOIN `action_items` di2ai_fk_di ON di2ai.`action_item_id` = di2ai_fk_di.`id`
WHERE di2ai.`discussion_item_id` = ? and di2ai_fk_di.`action_item_type_id` = ?
";

		$arrValues = array($discussion_item_id,$action_item_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsToActionItemsByDiscussionItemId = array();
		$row = $db->fetch();
		$count = $row['count'];

		$db->free_result();

		return $count;

	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `discussion_items_to_action_items_fk_di` foreign key (`discussion_item_id`) references `discussion_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsToActionItemsByDiscussionItemIdApi($database, $discussion_item_id, Input $options=null)
	{
		$forceLoadFlag = false;
		$whereCondFlag = false;
		$whereCondQuery = '';
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
			$whereCondFlag = $options->whereCondFlag;
			$whereCondQuery = $options->whereCondQuery;
		}

		if ($forceLoadFlag) {
			self::$_arrDiscussionItemsToActionItemsByDiscussionItemId = null;
		}

		$arrDiscussionItemsToActionItemsByDiscussionItemId = self::$_arrDiscussionItemsToActionItemsByDiscussionItemId;
		if (isset($arrDiscussionItemsToActionItemsByDiscussionItemId) && !empty($arrDiscussionItemsToActionItemsByDiscussionItemId)) {
			return $arrDiscussionItemsToActionItemsByDiscussionItemId;
		}

		$discussion_item_id = (int) $discussion_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToActionItem = new DiscussionItemToActionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItemToActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di2ai.*,
	ai.`id`,
	ai.`action_item_type_id`,
	ai.`action_item_due_date`,
	ai.`action_item_completed_timestamp`
FROM `discussion_items_to_action_items` di2ai
LEFT JOIN `action_items` ai ON ai.`id` = di2ai.`action_item_id`
WHERE di2ai.`discussion_item_id` = ? {$whereCondQuery} {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$arrValues = array($discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsToActionItemsByDiscussionItemId = array();
		while ($row = $db->fetch()) {
			$discussionItemToActionItem = self::instantiateOrm($database, 'DiscussionItemToActionItem', $row);
			/* @var $discussionItemToActionItem DiscussionItemToActionItem */
			$arrDiscussionItemsToActionItemsByDiscussionItemId[] = $discussionItemToActionItem;
		}

		$db->free_result();

		self::$_arrDiscussionItemsToActionItemsByDiscussionItemId = $arrDiscussionItemsToActionItemsByDiscussionItemId;

		return $arrDiscussionItemsToActionItemsByDiscussionItemId;
	}

	/**
	 * Load by constraint `discussion_items_to_action_items_fk_ai` foreign key (`action_item_id`) references `action_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $action_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsToActionItemsByActionItemId($database, $action_item_id, Input $options=null)
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
			self::$_arrDiscussionItemsToActionItemsByActionItemId = null;
		}

		$arrDiscussionItemsToActionItemsByActionItemId = self::$_arrDiscussionItemsToActionItemsByActionItemId;
		if (isset($arrDiscussionItemsToActionItemsByActionItemId) && !empty($arrDiscussionItemsToActionItemsByActionItemId)) {
			return $arrDiscussionItemsToActionItemsByActionItemId;
		}

		$action_item_id = (int) $action_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToActionItem = new DiscussionItemToActionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItemToActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di2ai.*

FROM `discussion_items_to_action_items` di2ai
WHERE di2ai.`action_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$arrValues = array($action_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsToActionItemsByActionItemId = array();
		while ($row = $db->fetch()) {
			$discussionItemToActionItem = self::instantiateOrm($database, 'DiscussionItemToActionItem', $row);
			/* @var $discussionItemToActionItem DiscussionItemToActionItem */
			$arrDiscussionItemsToActionItemsByActionItemId[] = $discussionItemToActionItem;
		}

		$db->free_result();

		self::$_arrDiscussionItemsToActionItemsByActionItemId = $arrDiscussionItemsToActionItemsByActionItemId;

		return $arrDiscussionItemsToActionItemsByActionItemId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all discussion_items_to_action_items records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDiscussionItemsToActionItems($database, Input $options=null)
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
			self::$_arrAllDiscussionItemsToActionItems = null;
		}

		$arrAllDiscussionItemsToActionItems = self::$_arrAllDiscussionItemsToActionItems;
		if (isset($arrAllDiscussionItemsToActionItems) && !empty($arrAllDiscussionItemsToActionItems)) {
			return $arrAllDiscussionItemsToActionItems;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToActionItem = new DiscussionItemToActionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItemToActionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di2ai.*

FROM `discussion_items_to_action_items` di2ai{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `action_item_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDiscussionItemsToActionItems = array();
		while ($row = $db->fetch()) {
			$discussionItemToActionItem = self::instantiateOrm($database, 'DiscussionItemToActionItem', $row);
			/* @var $discussionItemToActionItem DiscussionItemToActionItem */
			$arrAllDiscussionItemsToActionItems[] = $discussionItemToActionItem;
		}

		$db->free_result();

		self::$_arrAllDiscussionItemsToActionItems = $arrAllDiscussionItemsToActionItems;

		return $arrAllDiscussionItemsToActionItems;
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
INTO `discussion_items_to_action_items`
(`discussion_item_id`, `action_item_id`)
VALUES (?, ?)
";
		$arrValues = array($this->discussion_item_id, $this->action_item_id);
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

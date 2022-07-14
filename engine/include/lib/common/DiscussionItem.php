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
 * DiscussionItem.
 *
 * @category   Framework
 * @package    DiscussionItem
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DiscussionItem extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DiscussionItem';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'discussion_items';

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
		'unique_discussion_item_via_primary_key' => array(
			'discussion_item_id' => 'int'
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
		'id' => 'discussion_item_id',

		'meeting_id' => 'meeting_id',
		'discussion_item_sequence_number' => 'discussion_item_sequence_number',
		'discussion_item_status_id' => 'discussion_item_status_id',
		'discussion_item_priority_id' => 'discussion_item_priority_id',
		'discussion_item_cost_code_id' => 'discussion_item_cost_code_id',
		'created_by_contact_id' => 'created_by_contact_id',

		'discussion_item_title' => 'discussion_item_title',
		'discussion_item' => 'discussion_item',
		'created' => 'created',
		'discussion_item_closed_date' => 'discussion_item_closed_date',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $discussion_item_id;

	public $meeting_id;
	public $discussion_item_sequence_number;
	public $discussion_item_status_id;
	public $discussion_item_priority_id;
	public $discussion_item_cost_code_id;
	public $created_by_contact_id;

	public $discussion_item_title;
	public $discussion_item;
	public $created;
	public $discussion_item_closed_date;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_discussion_item_title;
	public $escaped_discussion_item;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_discussion_item_title_nl2br;
	public $escaped_discussion_item_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrDiscussionItemsByMeetingId;
	protected static $_arrDiscussionItemsByDiscussionItemStatusId;
	protected static $_arrDiscussionItemsByDiscussionItemPriorityId;
	protected static $_arrDiscussionItemsByDiscussionItemCostCodeId;
	protected static $_arrDiscussionItemsByCreatedByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDiscussionItems;

	// Foreign Key Objects
	private $_meeting;
	private $_discussionItemStatus;
	private $_discussionItemPriority;
	private $_discussionItemCostCode;
	private $_createdByContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='discussion_items')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getMeeting()
	{
		if (isset($this->_meeting)) {
			return $this->_meeting;
		} else {
			return null;
		}
	}

	public function setMeeting($meeting)
	{
		$this->_meeting = $meeting;
	}

	public function getDiscussionItemStatus()
	{
		if (isset($this->_discussionItemStatus)) {
			return $this->_discussionItemStatus;
		} else {
			return null;
		}
	}

	public function setDiscussionItemStatus($discussionItemStatus)
	{
		$this->_discussionItemStatus = $discussionItemStatus;
	}

	public function getDiscussionItemPriority()
	{
		if (isset($this->_discussionItemPriority)) {
			return $this->_discussionItemPriority;
		} else {
			return null;
		}
	}

	public function setDiscussionItemPriority($discussionItemPriority)
	{
		$this->_discussionItemPriority = $discussionItemPriority;
	}

	public function getDiscussionItemCostCode()
	{
		if (isset($this->_discussionItemCostCode)) {
			return $this->_discussionItemCostCode;
		} else {
			return null;
		}
	}

	public function setDiscussionItemCostCode($discussionItemCostCode)
	{
		$this->_discussionItemCostCode = $discussionItemCostCode;
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
	public static function getArrDiscussionItemsByMeetingId()
	{
		if (isset(self::$_arrDiscussionItemsByMeetingId)) {
			return self::$_arrDiscussionItemsByMeetingId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsByMeetingId($arrDiscussionItemsByMeetingId)
	{
		self::$_arrDiscussionItemsByMeetingId = $arrDiscussionItemsByMeetingId;
	}

	public static function getArrDiscussionItemsByDiscussionItemStatusId()
	{
		if (isset(self::$_arrDiscussionItemsByDiscussionItemStatusId)) {
			return self::$_arrDiscussionItemsByDiscussionItemStatusId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsByDiscussionItemStatusId($arrDiscussionItemsByDiscussionItemStatusId)
	{
		self::$_arrDiscussionItemsByDiscussionItemStatusId = $arrDiscussionItemsByDiscussionItemStatusId;
	}

	public static function getArrDiscussionItemsByDiscussionItemPriorityId()
	{
		if (isset(self::$_arrDiscussionItemsByDiscussionItemPriorityId)) {
			return self::$_arrDiscussionItemsByDiscussionItemPriorityId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsByDiscussionItemPriorityId($arrDiscussionItemsByDiscussionItemPriorityId)
	{
		self::$_arrDiscussionItemsByDiscussionItemPriorityId = $arrDiscussionItemsByDiscussionItemPriorityId;
	}

	public static function getArrDiscussionItemsByDiscussionItemCostCodeId()
	{
		if (isset(self::$_arrDiscussionItemsByDiscussionItemCostCodeId)) {
			return self::$_arrDiscussionItemsByDiscussionItemCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsByDiscussionItemCostCodeId($arrDiscussionItemsByDiscussionItemCostCodeId)
	{
		self::$_arrDiscussionItemsByDiscussionItemCostCodeId = $arrDiscussionItemsByDiscussionItemCostCodeId;
	}

	public static function getArrDiscussionItemsByCreatedByContactId()
	{
		if (isset(self::$_arrDiscussionItemsByCreatedByContactId)) {
			return self::$_arrDiscussionItemsByCreatedByContactId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsByCreatedByContactId($arrDiscussionItemsByCreatedByContactId)
	{
		self::$_arrDiscussionItemsByCreatedByContactId = $arrDiscussionItemsByCreatedByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllDiscussionItems()
	{
		if (isset(self::$_arrAllDiscussionItems)) {
			return self::$_arrAllDiscussionItems;
		} else {
			return null;
		}
	}

	public static function setArrAllDiscussionItems($arrAllDiscussionItems)
	{
		self::$_arrAllDiscussionItems = $arrAllDiscussionItems;
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
	 * @param int $discussion_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $discussion_item_id ,$table='discussion_items', $module='DiscussionItem')
	{
		$discussionItem = parent::findById($database, $discussion_item_id,$table, $module);

		return $discussionItem;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findDiscussionItemByIdExtended($database, $discussion_item_id)
	{
		$discussion_item_id = (int) $discussion_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	di_fk_m.`id` AS 'di_fk_m__meeting_id',
	di_fk_m.`previous_meeting_id` AS 'di_fk_m__previous_meeting_id',
	di_fk_m.`project_id` AS 'di_fk_m__project_id',
	di_fk_m.`meeting_type_id` AS 'di_fk_m__meeting_type_id',
	di_fk_m.`meeting_location_id` AS 'di_fk_m__meeting_location_id',
	di_fk_m.`meeting_chair_contact_id` AS 'di_fk_m__meeting_chair_contact_id',
	di_fk_m.`modified_by_contact_id` AS 'di_fk_m__modified_by_contact_id',
	di_fk_m.`meeting_sequence_number` AS 'di_fk_m__meeting_sequence_number',
	di_fk_m.`meeting_start_date` AS 'di_fk_m__meeting_start_date',
	di_fk_m.`meeting_start_time` AS 'di_fk_m__meeting_start_time',
	di_fk_m.`meeting_end_date` AS 'di_fk_m__meeting_end_date',
	di_fk_m.`meeting_end_time` AS 'di_fk_m__meeting_end_time',
	di_fk_m.`modified` AS 'di_fk_m__modified',
	di_fk_m.`created` AS 'di_fk_m__created',
	di_fk_m.`all_day_event_flag` AS 'di_fk_m__all_day_event_flag',

	di_fk_dis.`id` AS 'di_fk_dis__discussion_item_status_id',
	di_fk_dis.`discussion_item_status` AS 'di_fk_dis__discussion_item_status',
	di_fk_dis.`disabled_flag` AS 'di_fk_dis__disabled_flag',

	di_fk_dip.`id` AS 'di_fk_dip__discussion_item_priority_id',
	di_fk_dip.`discussion_item_priority` AS 'di_fk_dip__discussion_item_priority',
	di_fk_dip.`disabled_flag` AS 'di_fk_dip__disabled_flag',

	di_fk_codes.`id` AS 'di_fk_codes__cost_code_id',
	di_fk_codes.`cost_code_division_id` AS 'di_fk_codes__cost_code_division_id',
	di_fk_codes.`cost_code` AS 'di_fk_codes__cost_code',
	di_fk_codes.`cost_code_description` AS 'di_fk_codes__cost_code_description',
	di_fk_codes.`cost_code_description_abbreviation` AS 'di_fk_codes__cost_code_description_abbreviation',
	di_fk_codes.`sort_order` AS 'di_fk_codes__sort_order',
	di_fk_codes.`disabled_flag` AS 'di_fk_codes__disabled_flag',

	di_fk_created_by_c.`id` AS 'di_fk_created_by_c__contact_id',
	di_fk_created_by_c.`user_company_id` AS 'di_fk_created_by_c__user_company_id',
	di_fk_created_by_c.`user_id` AS 'di_fk_created_by_c__user_id',
	di_fk_created_by_c.`contact_company_id` AS 'di_fk_created_by_c__contact_company_id',
	di_fk_created_by_c.`email` AS 'di_fk_created_by_c__email',
	di_fk_created_by_c.`name_prefix` AS 'di_fk_created_by_c__name_prefix',
	di_fk_created_by_c.`first_name` AS 'di_fk_created_by_c__first_name',
	di_fk_created_by_c.`additional_name` AS 'di_fk_created_by_c__additional_name',
	di_fk_created_by_c.`middle_name` AS 'di_fk_created_by_c__middle_name',
	di_fk_created_by_c.`last_name` AS 'di_fk_created_by_c__last_name',
	di_fk_created_by_c.`name_suffix` AS 'di_fk_created_by_c__name_suffix',
	di_fk_created_by_c.`title` AS 'di_fk_created_by_c__title',
	di_fk_created_by_c.`vendor_flag` AS 'di_fk_created_by_c__vendor_flag',

	di.*

FROM `discussion_items` di
	INNER JOIN `meetings` di_fk_m ON di.`meeting_id` = di_fk_m.`id`
	INNER JOIN `discussion_item_statuses` di_fk_dis ON di.`discussion_item_status_id` = di_fk_dis.`id`
	INNER JOIN `discussion_item_priorities` di_fk_dip ON di.`discussion_item_priority_id` = di_fk_dip.`id`
	LEFT OUTER JOIN `cost_codes` di_fk_codes ON di.`discussion_item_cost_code_id` = di_fk_codes.`id`
	INNER JOIN `contacts` di_fk_created_by_c ON di.`created_by_contact_id` = di_fk_created_by_c.`id`
WHERE di.`id` = ?
";
		$arrValues = array($discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$discussion_item_id = $row['id'];
			$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id);
			/* @var $discussionItem DiscussionItem */
			$discussionItem->convertPropertiesToData();

			if (isset($row['meeting_id'])) {
				$meeting_id = $row['meeting_id'];
				$row['di_fk_m__id'] = $meeting_id;
				$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id, 'di_fk_m__');
				/* @var $meeting Meeting */
				$meeting->convertPropertiesToData();
			} else {
				$meeting = false;
			}
			$discussionItem->setMeeting($meeting);

			if (isset($row['discussion_item_status_id'])) {
				$discussion_item_status_id = $row['discussion_item_status_id'];
				$row['di_fk_dis__id'] = $discussion_item_status_id;
				$discussionItemStatus = self::instantiateOrm($database, 'DiscussionItemStatus', $row, null, $discussion_item_status_id, 'di_fk_dis__');
				/* @var $discussionItemStatus DiscussionItemStatus */
				$discussionItemStatus->convertPropertiesToData();
			} else {
				$discussionItemStatus = false;
			}
			$discussionItem->setDiscussionItemStatus($discussionItemStatus);

			if (isset($row['discussion_item_priority_id'])) {
				$discussion_item_priority_id = $row['discussion_item_priority_id'];
				$row['di_fk_dip__id'] = $discussion_item_priority_id;
				$discussionItemPriority = self::instantiateOrm($database, 'DiscussionItemPriority', $row, null, $discussion_item_priority_id, 'di_fk_dip__');
				/* @var $discussionItemPriority DiscussionItemPriority */
				$discussionItemPriority->convertPropertiesToData();
			} else {
				$discussionItemPriority = false;
			}
			$discussionItem->setDiscussionItemPriority($discussionItemPriority);

			if (isset($row['discussion_item_cost_code_id'])) {
				$discussion_item_cost_code_id = $row['discussion_item_cost_code_id'];
				$row['di_fk_codes__id'] = $discussion_item_cost_code_id;
				$discussionItemCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $discussion_item_cost_code_id, 'di_fk_codes__');
				/* @var $discussionItemCostCode CostCode */
				$discussionItemCostCode->convertPropertiesToData();
			} else {
				$discussionItemCostCode = false;
			}
			$discussionItem->setDiscussionItemCostCode($discussionItemCostCode);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['di_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'di_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$discussionItem->setCreatedByContact($createdByContact);

			return $discussionItem;
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
	 * @param array $arrDiscussionItemIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsByArrDiscussionItemIds($database, $arrDiscussionItemIds, Input $options=null)
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
		// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY di.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItem = new DiscussionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrDiscussionItemIds as $k => $discussion_item_id) {
			$discussion_item_id = (int) $discussion_item_id;
			$arrDiscussionItemIds[$k] = $db->escape($discussion_item_id);
		}
		$csvDiscussionItemIds = join(',', $arrDiscussionItemIds);

		$query =
"
SELECT

	di.*

FROM `discussion_items` di
WHERE di.`id` IN ($csvDiscussionItemIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrDiscussionItemsByCsvDiscussionItemIds = array();
		while ($row = $db->fetch()) {
			$discussion_item_id = $row['id'];
			$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id);
			/* @var $discussionItem DiscussionItem */
			$discussionItem->convertPropertiesToData();

			$arrDiscussionItemsByCsvDiscussionItemIds[$discussion_item_id] = $discussionItem;
		}

		$db->free_result();

		return $arrDiscussionItemsByCsvDiscussionItemIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `discussion_items_fk_m` foreign key (`meeting_id`) references `meetings` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsByMeetingId($database, $meeting_id, Input $options=null)
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
			self::$_arrDiscussionItemsByMeetingId = null;
		}

		$arrDiscussionItemsByMeetingId = self::$_arrDiscussionItemsByMeetingId;
		if (isset($arrDiscussionItemsByMeetingId) && !empty($arrDiscussionItemsByMeetingId)) {
			return $arrDiscussionItemsByMeetingId;
		}

		$meeting_id = (int) $meeting_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		/* di.`id`DESC, removed for manual sorting issue */
		$sqlOrderBy = "\nORDER BY di.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItem = new DiscussionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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

	di_fk_m.`id` AS 'di_fk_m__meeting_id',
	di_fk_m.`previous_meeting_id` AS 'di_fk_m__previous_meeting_id',
	di_fk_m.`project_id` AS 'di_fk_m__project_id',
	di_fk_m.`meeting_type_id` AS 'di_fk_m__meeting_type_id',
	di_fk_m.`meeting_location_id` AS 'di_fk_m__meeting_location_id',
	di_fk_m.`meeting_chair_contact_id` AS 'di_fk_m__meeting_chair_contact_id',
	di_fk_m.`modified_by_contact_id` AS 'di_fk_m__modified_by_contact_id',
	di_fk_m.`meeting_sequence_number` AS 'di_fk_m__meeting_sequence_number',
	di_fk_m.`meeting_start_date` AS 'di_fk_m__meeting_start_date',
	di_fk_m.`meeting_start_time` AS 'di_fk_m__meeting_start_time',
	di_fk_m.`meeting_end_date` AS 'di_fk_m__meeting_end_date',
	di_fk_m.`meeting_end_time` AS 'di_fk_m__meeting_end_time',
	di_fk_m.`modified` AS 'di_fk_m__modified',
	di_fk_m.`created` AS 'di_fk_m__created',
	di_fk_m.`all_day_event_flag` AS 'di_fk_m__all_day_event_flag',

	di_fk_dis.`id` AS 'di_fk_dis__discussion_item_status_id',
	di_fk_dis.`discussion_item_status` AS 'di_fk_dis__discussion_item_status',
	di_fk_dis.`disabled_flag` AS 'di_fk_dis__disabled_flag',

	di_fk_dip.`id` AS 'di_fk_dip__discussion_item_priority_id',
	di_fk_dip.`discussion_item_priority` AS 'di_fk_dip__discussion_item_priority',
	di_fk_dip.`disabled_flag` AS 'di_fk_dip__disabled_flag',

	di_fk_codes.`id` AS 'di_fk_codes__cost_code_id',
	di_fk_codes.`cost_code_division_id` AS 'di_fk_codes__cost_code_division_id',
	di_fk_codes.`cost_code` AS 'di_fk_codes__cost_code',
	di_fk_codes.`cost_code_description` AS 'di_fk_codes__cost_code_description',
	di_fk_codes.`cost_code_description_abbreviation` AS 'di_fk_codes__cost_code_description_abbreviation',
	di_fk_codes.`sort_order` AS 'di_fk_codes__sort_order',
	di_fk_codes.`disabled_flag` AS 'di_fk_codes__disabled_flag',

	di_fk_created_by_c.`id` AS 'di_fk_created_by_c__contact_id',
	di_fk_created_by_c.`user_company_id` AS 'di_fk_created_by_c__user_company_id',
	di_fk_created_by_c.`user_id` AS 'di_fk_created_by_c__user_id',
	di_fk_created_by_c.`contact_company_id` AS 'di_fk_created_by_c__contact_company_id',
	di_fk_created_by_c.`email` AS 'di_fk_created_by_c__email',
	di_fk_created_by_c.`name_prefix` AS 'di_fk_created_by_c__name_prefix',
	di_fk_created_by_c.`first_name` AS 'di_fk_created_by_c__first_name',
	di_fk_created_by_c.`additional_name` AS 'di_fk_created_by_c__additional_name',
	di_fk_created_by_c.`middle_name` AS 'di_fk_created_by_c__middle_name',
	di_fk_created_by_c.`last_name` AS 'di_fk_created_by_c__last_name',
	di_fk_created_by_c.`name_suffix` AS 'di_fk_created_by_c__name_suffix',
	di_fk_created_by_c.`title` AS 'di_fk_created_by_c__title',
	di_fk_created_by_c.`vendor_flag` AS 'di_fk_created_by_c__vendor_flag',

	di.*

FROM `discussion_items` di
	INNER JOIN `meetings` di_fk_m ON di.`meeting_id` = di_fk_m.`id`
	INNER JOIN `discussion_item_statuses` di_fk_dis ON di.`discussion_item_status_id` = di_fk_dis.`id`
	INNER JOIN `discussion_item_priorities` di_fk_dip ON di.`discussion_item_priority_id` = di_fk_dip.`id`
	LEFT OUTER JOIN `cost_codes` di_fk_codes ON di.`discussion_item_cost_code_id` = di_fk_codes.`id`
	INNER JOIN `contacts` di_fk_created_by_c ON di.`created_by_contact_id` = di_fk_created_by_c.`id`
WHERE di.`meeting_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$arrValues = array($meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByMeetingId = array();
		while ($row = $db->fetch()) {
			$discussion_item_id = $row['id'];
			$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id);
			/* @var $discussionItem DiscussionItem */
			$discussionItem->convertPropertiesToData();

			if (isset($row['meeting_id'])) {
				$meeting_id = $row['meeting_id'];
				$row['di_fk_m__id'] = $meeting_id;
				$meeting = self::instantiateOrm($database, 'Meeting', $row, null, $meeting_id, 'di_fk_m__');
				/* @var $meeting Meeting */
				$meeting->convertPropertiesToData();
			} else {
				$meeting = false;
			}
			$discussionItem->setMeeting($meeting);

			if (isset($row['discussion_item_status_id'])) {
				$discussion_item_status_id = $row['discussion_item_status_id'];
				$row['di_fk_dis__id'] = $discussion_item_status_id;
				$discussionItemStatus = self::instantiateOrm($database, 'DiscussionItemStatus', $row, null, $discussion_item_status_id, 'di_fk_dis__');
				/* @var $discussionItemStatus DiscussionItemStatus */
				$discussionItemStatus->convertPropertiesToData();
			} else {
				$discussionItemStatus = false;
			}
			$discussionItem->setDiscussionItemStatus($discussionItemStatus);

			if (isset($row['discussion_item_priority_id'])) {
				$discussion_item_priority_id = $row['discussion_item_priority_id'];
				$row['di_fk_dip__id'] = $discussion_item_priority_id;
				$discussionItemPriority = self::instantiateOrm($database, 'DiscussionItemPriority', $row, null, $discussion_item_priority_id, 'di_fk_dip__');
				/* @var $discussionItemPriority DiscussionItemPriority */
				$discussionItemPriority->convertPropertiesToData();
			} else {
				$discussionItemPriority = false;
			}
			$discussionItem->setDiscussionItemPriority($discussionItemPriority);

			if (isset($row['discussion_item_cost_code_id'])) {
				$discussion_item_cost_code_id = $row['discussion_item_cost_code_id'];
				$row['di_fk_codes__id'] = $discussion_item_cost_code_id;
				$discussionItemCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $discussion_item_cost_code_id, 'di_fk_codes__');
				/* @var $discussionItemCostCode CostCode */
				$discussionItemCostCode->convertPropertiesToData();
			} else {
				$discussionItemCostCode = false;
			}
			$discussionItem->setDiscussionItemCostCode($discussionItemCostCode);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['di_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'di_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$discussionItem->setCreatedByContact($createdByContact);

			$arrDiscussionItemsByMeetingId[$discussion_item_id] = $discussionItem;
		}

		$db->free_result();

		self::$_arrDiscussionItemsByMeetingId = $arrDiscussionItemsByMeetingId;

		return $arrDiscussionItemsByMeetingId;
	}

	/**
	 * Load by constraint `discussion_items_fk_dis` foreign key (`discussion_item_status_id`) references `discussion_item_statuses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsByDiscussionItemStatusId($database, $discussion_item_status_id, Input $options=null)
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
			self::$_arrDiscussionItemsByDiscussionItemStatusId = null;
		}

		$arrDiscussionItemsByDiscussionItemStatusId = self::$_arrDiscussionItemsByDiscussionItemStatusId;
		if (isset($arrDiscussionItemsByDiscussionItemStatusId) && !empty($arrDiscussionItemsByDiscussionItemStatusId)) {
			return $arrDiscussionItemsByDiscussionItemStatusId;
		}

		$discussion_item_status_id = (int) $discussion_item_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY di.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItem = new DiscussionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di.*

FROM `discussion_items` di
WHERE di.`discussion_item_status_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$arrValues = array($discussion_item_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByDiscussionItemStatusId = array();
		while ($row = $db->fetch()) {
			$discussion_item_id = $row['id'];
			$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id);
			/* @var $discussionItem DiscussionItem */
			$arrDiscussionItemsByDiscussionItemStatusId[$discussion_item_id] = $discussionItem;
		}

		$db->free_result();

		self::$_arrDiscussionItemsByDiscussionItemStatusId = $arrDiscussionItemsByDiscussionItemStatusId;

		return $arrDiscussionItemsByDiscussionItemStatusId;
	}

	/**
	 * Load by constraint `discussion_items_fk_dip` foreign key (`discussion_item_priority_id`) references `discussion_item_priorities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_priority_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsByDiscussionItemPriorityId($database, $discussion_item_priority_id, Input $options=null)
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
			self::$_arrDiscussionItemsByDiscussionItemPriorityId = null;
		}

		$arrDiscussionItemsByDiscussionItemPriorityId = self::$_arrDiscussionItemsByDiscussionItemPriorityId;
		if (isset($arrDiscussionItemsByDiscussionItemPriorityId) && !empty($arrDiscussionItemsByDiscussionItemPriorityId)) {
			return $arrDiscussionItemsByDiscussionItemPriorityId;
		}

		$discussion_item_priority_id = (int) $discussion_item_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY di.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItem = new DiscussionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di.*

FROM `discussion_items` di
WHERE di.`discussion_item_priority_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$arrValues = array($discussion_item_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByDiscussionItemPriorityId = array();
		while ($row = $db->fetch()) {
			$discussion_item_id = $row['id'];
			$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id);
			/* @var $discussionItem DiscussionItem */
			$arrDiscussionItemsByDiscussionItemPriorityId[$discussion_item_id] = $discussionItem;
		}

		$db->free_result();

		self::$_arrDiscussionItemsByDiscussionItemPriorityId = $arrDiscussionItemsByDiscussionItemPriorityId;

		return $arrDiscussionItemsByDiscussionItemPriorityId;
	}

	/**
	 * Load by constraint `discussion_items_fk_codes` foreign key (`discussion_item_cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsByDiscussionItemCostCodeId($database, $discussion_item_cost_code_id, Input $options=null)
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
			self::$_arrDiscussionItemsByDiscussionItemCostCodeId = null;
		}

		$arrDiscussionItemsByDiscussionItemCostCodeId = self::$_arrDiscussionItemsByDiscussionItemCostCodeId;
		if (isset($arrDiscussionItemsByDiscussionItemCostCodeId) && !empty($arrDiscussionItemsByDiscussionItemCostCodeId)) {
			return $arrDiscussionItemsByDiscussionItemCostCodeId;
		}

		$discussion_item_cost_code_id = (int) $discussion_item_cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY di.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItem = new DiscussionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di.*

FROM `discussion_items` di
WHERE di.`discussion_item_cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$arrValues = array($discussion_item_cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByDiscussionItemCostCodeId = array();
		while ($row = $db->fetch()) {
			$discussion_item_id = $row['id'];
			$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id);
			/* @var $discussionItem DiscussionItem */
			$arrDiscussionItemsByDiscussionItemCostCodeId[$discussion_item_id] = $discussionItem;
		}

		$db->free_result();

		self::$_arrDiscussionItemsByDiscussionItemCostCodeId = $arrDiscussionItemsByDiscussionItemCostCodeId;

		return $arrDiscussionItemsByDiscussionItemCostCodeId;
	}

	/**
	 * Load by constraint `discussion_items_fk_created_by_c` foreign key (`created_by_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $created_by_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsByCreatedByContactId($database, $created_by_contact_id, Input $options=null)
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
			self::$_arrDiscussionItemsByCreatedByContactId = null;
		}

		$arrDiscussionItemsByCreatedByContactId = self::$_arrDiscussionItemsByCreatedByContactId;
		if (isset($arrDiscussionItemsByCreatedByContactId) && !empty($arrDiscussionItemsByCreatedByContactId)) {
			return $arrDiscussionItemsByCreatedByContactId;
		}

		$created_by_contact_id = (int) $created_by_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY di.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItem = new DiscussionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di.*

FROM `discussion_items` di
WHERE di.`created_by_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$arrValues = array($created_by_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByCreatedByContactId = array();
		while ($row = $db->fetch()) {
			$discussion_item_id = $row['id'];
			$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id);
			/* @var $discussionItem DiscussionItem */
			$arrDiscussionItemsByCreatedByContactId[$discussion_item_id] = $discussionItem;
		}

		$db->free_result();

		self::$_arrDiscussionItemsByCreatedByContactId = $arrDiscussionItemsByCreatedByContactId;

		return $arrDiscussionItemsByCreatedByContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all discussion_items records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDiscussionItems($database, Input $options=null)
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
			self::$_arrAllDiscussionItems = null;
		}

		$arrAllDiscussionItems = self::$_arrAllDiscussionItems;
		if (isset($arrAllDiscussionItems) && !empty($arrAllDiscussionItems)) {
			return $arrAllDiscussionItems;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY di.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItem = new DiscussionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di.*

FROM `discussion_items` di{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `meeting_id` ASC, `discussion_item_sequence_number` ASC, `discussion_item_status_id` ASC, `discussion_item_priority_id` ASC, `discussion_item_cost_code_id` ASC, `created_by_contact_id` ASC, `discussion_item_title` ASC, `discussion_item` ASC, `created` ASC, `discussion_item_closed_date` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDiscussionItems = array();
		while ($row = $db->fetch()) {
			$discussion_item_id = $row['id'];
			$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id);
			/* @var $discussionItem DiscussionItem */
			$arrAllDiscussionItems[$discussion_item_id] = $discussionItem;
		}

		$db->free_result();

		self::$_arrAllDiscussionItems = $arrAllDiscussionItems;

		return $arrAllDiscussionItems;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	/**
	 * Load by constraint `discussion_items_fk_m` foreign key (`meeting_id`) references `meetings` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType($database, $meeting_id)
	{
		$meeting_id = (int) $meeting_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	`discussion_item_status`,
	COUNT(`discussion_item_status_id`) AS 'total'

FROM `discussion_items` di
	INNER JOIN `discussion_item_statuses` dis ON di.`discussion_item_status_id` = dis.`id`
WHERE di.`meeting_id` = ?
GROUP by `discussion_item_status_id`
";
		$arrValues = array($meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType = array();
		$allTypesTotal = 0;
		while ($row = $db->fetch()) {
			$discussion_item_status = $row['discussion_item_status'];
			$total = $row['total'];
			$allTypesTotal += $total;

			$arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType[$discussion_item_status] = $total;
		}
		$db->free_result();

		if ($allTypesTotal > 0) {
			$arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType['All'] = $allTypesTotal;
		}

		return $arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType;
	}

	public static function setNaturalSortOrderOnDiscussionItemsByMeetingId($database, $meeting_id, $original_discussion_item_id)
	{
		$meeting_id = (int) $meeting_id;
		$original_discussion_item_id = (int) $original_discussion_item_id;

		$loadDiscussionItemsByMeetingIdInput = new Input();
		$loadDiscussionItemsByMeetingIdInput->forceLoadFlag = true;

		// Set natural sort order on all records first
		$arrDiscussionItems = DiscussionItem::loadDiscussionItemsByMeetingId($database, $meeting_id, $loadDiscussionItemsByMeetingIdInput);
		$i = 0;
		foreach ($arrDiscussionItems as $discussion_item_id => $discussionItem) {
			/* @var $discussionItem DiscussionItem */

			$sort_order = $discussionItem->sort_order;
			if ($sort_order != $i) {
				$data = array('sort_order' => $i);
				$discussionItem->setData($data);
				$discussionItem->save();
			}

			// Get the original sort_order value after updating to sane values
			if ($discussionItem->discussion_item_id == $original_discussion_item_id) {
				$original_sort_order = $i;
			}

			$i++;
		}

		return $original_sort_order;
	}

	public function updateSortOrder($database, $new_sort_order, $discussion_item_id = null)
	{
		$meeting_id = $this->meeting_id;
		$new_sort_order = (int) $new_sort_order;

		// @todo Conditionally update sort_order based on table meta-data
		$original_sort_order = DiscussionItem::setNaturalSortOrderOnDiscussionItemsByMeetingId($database, $meeting_id, $this->discussion_item_id);

		if ($new_sort_order > $original_sort_order) {
			$movedDown = true;
			$movedUp = false;
		} elseif ($new_sort_order < $original_sort_order) {
			$movedDown = false;
			$movedUp = true;
		} else {
			// Same sort_order
			// Default to Moved Down
			$movedDown = true;
			$movedUp = false;
		}

		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$db->begin();
		if ($movedDown) {
			$query =
"
UPDATE `discussion_items`
SET `sort_order` = (`sort_order`-1)
WHERE `meeting_id` = ?
AND `sort_order` > ?
AND `sort_order` <= ?
";
			$arrValues = array($this->meeting_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} elseif ($movedUp) {
			$whereNot = '';
			if($discussion_item_id != null)
			{
				$whereNot = "AND id NOT IN(?)";
				$arrValues = array($this->meeting_id, $discussion_item_id, $original_sort_order, $new_sort_order);
			}
			else{
				$arrValues = array($this->meeting_id, $original_sort_order, $new_sort_order);
			}
			$query =
"
UPDATE `discussion_items`
SET `sort_order` = (`sort_order`+1)
WHERE `meeting_id` = ?
$whereNot
AND `sort_order` < ?
AND `sort_order` >= ?
";

			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
		if($discussion_item_id != null)
		{
			$query =
"
UPDATE `discussion_items`
SET `sort_order` = 0
WHERE `meeting_id` = ?
AND `id` = ?
";
			$arrValues = array($this->meeting_id, $discussion_item_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
			$db->commit();
		}
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `discussion_items_fk_m` foreign key (`meeting_id`) references `meetings` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsByProjectUserId($database, $project_id, $user_id,$userRole, $projManager, Input $options=null){


		
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
			self::$_arrDiscussionItemsByMeetingId = null;
		}

		$arrDiscussionItemsByMeetingId = self::$_arrDiscussionItemsByMeetingId;
		if (isset($arrDiscussionItemsByMeetingId) && !empty($arrDiscussionItemsByMeetingId)) {
			return $arrDiscussionItemsByMeetingId;
		}

		$project_id = (int) $project_id;
		$user_id = (int) $user_id;


		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	
		$sqlOrderBy = "\nORDER BY ai.`id` DESC";
		if(!empty($options['sort_task'])){
			$sqlOrderBy = $options['sort_task'];
		}
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItem = new DiscussionItem($database);
			$sqlOrderByColumns = $tmpDiscussionItem->constructSqlOrderByColumns($arrOrderByAttributes);

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
		$groupby = '';
		$sqlcond = array();
		if(!empty($userRole) && !empty($projManager)){

			$sqlcond[] = "ai.`project_id` = ?";
			$groupby = 'GROUP BY ai.`id`';
			$contactstable = '`action_items` `ai`';
		}else if(!empty($userRole) && ($userRole =='user' || $userRole == 'admin')){
			$sqlcond[] = "contacts.`user_id` = ?  AND ai.`project_id` = ?";
			$groupby = '';

			$contactstable = "`contacts` 
				INNER JOIN `action_item_assignments` 
					ON action_item_assignments.`action_item_assignee_contact_id` = contacts.`id` 
				INNER JOIN
				 `action_items` `ai`
					ON  action_item_assignments.`action_item_id` = ai.`id`
				";
		}

		if(!empty($userRole) && !empty($projManager)){
			$arrValues = array($project_id);
		}else if(!empty($userRole) && ($userRole =='user' || $userRole == 'admin')){
			$arrValues = array($user_id, $project_id);
		}

		


		if(!empty($options['conditions'])){
			if(!empty($options['conditions']['task'])){
				$sqlcond[] = "ai.`action_item` LIKE ?";
				$arrValues[] =  '%'.$options['conditions']['task'].'%';
			}
			if(!empty($options['conditions']['assigned_to'])){
				$contactstable = "`contacts` 
				INNER JOIN `action_item_assignments` 
					ON action_item_assignments.`action_item_assignee_contact_id` = contacts.`id` 
				INNER JOIN
				 `action_items` `ai`
					ON  action_item_assignments.`action_item_id` = ai.`id`
				";

				$contactquery = "SELECT `contacts`.`id`,`contacts`.`user_id`,`contacts`.`email`,`contacts`.`first_name`,`contacts`.`last_name` FROM  `contacts`  WHERE `contacts`.`email` LIKE ?
				OR  `contacts`.`first_name` LIKE ? OR  `contacts`.`last_name` LIKE ?";

				$arr_contValues = array('%'.$options['conditions']['assigned_to'].'%','%'.$options['conditions']['assigned_to'].'%','%'.$options['conditions']['assigned_to'].'%');
				$db->execute($contactquery, $arr_contValues, MYSQLI_USE_RESULT);

				$user_id_arr = array();
				while($cont_row = $db->fetch()){
					$user_id_arr[] = $cont_row['user_id'];
				}
				if(!empty($user_id_arr)){
					//echo  "contacts.`user_id` IN (".implode(',',$user_id_arr).")";
					$sqlcond[] = " contacts.`user_id` IN (".implode(',',$user_id_arr).")"; 
				}
				$db->free_result();
				

			}
			if(!empty($options['conditions']['due_date'])){
				$sqlcond[] = "ai.`action_item_due_date` = ?";
				$due_date = DateTime::createFromFormat("m/d/Y" , $options['conditions']['due_date']);
				$arrValues[] =  $due_date->format('Y-m-d');
			}

			if(!empty($options['conditions']['complete_date']) && $options['conditions']['complete_date'] =='uncomplete'){
				$arrValues[] = '0000-00-00 00:00:00';
				$sqlcond[] = "ai.`action_item_completed_timestamp` != ?";
			}else{
				$arrValues[] = '0000-00-00 00:00:00';
				$sqlcond[] = "ai.`action_item_completed_timestamp` = ?";
			}
			/*if(!empty($options['conditions']['complete_date'])){
				$sqlcond[] = "DATE(ai.`action_item_completed_timestamp`) = ?";
				$comp_date = DateTime::createFromFormat("m/d/Y" , $options['conditions']['complete_date']);
				$arrValues[] =  $comp_date->format('Y-m-d');
			}*/
			
			

			if(!empty($options['conditions']['discussion'])){
				$sqlcond[] = "di.`discussion_item_title` LIKE ?";
				$arrValues[] =  '%'.$options['conditions']['discussion'].'%';
			}

			if(!empty($options['conditions']['meeting_type'])){
				$sqlcond[] = "mt.`meeting_type` LIKE ?";
				$arrValues[] =  '%'.$options['conditions']['meeting_type'].'%';
			}
		}else{
			$arrValues[] = '0000-00-00 00:00:00';
			$sqlcond[] = "ai.`action_item_completed_timestamp` = ?";
		}


		if(!empty($sqlcond)){
			$sqlcond = implode(' AND ', $sqlcond);
		}
	/*	print_r($sqlcond);
		print_r($arrValues);*/
		$query ="SELECT
				 	di.*,  
				 	m.`meeting_type_id`,
				 	mt.`meeting_type`,
				 	m.`meeting_sequence_number`,
				 	ai.`action_item_due_date`,
				 	ai.`created`,
				 	ai.`action_item`,
				 	ai.`project_id`,
				 	ai.`created_by_contact_id` as ac_created_by_contact_id,
				 	ai.`id` as ac_id,
				 	ai.`action_item_completed_timestamp`
				FROM  
					{$contactstable}
				
				INNER JOIN `discussion_items_to_action_items` 
					ON `discussion_items_to_action_items`.`action_item_id` = ai.`id` 
				INNER JOIN `discussion_items` di
					ON di.`id` = `discussion_items_to_action_items`.discussion_item_id
				INNER JOIN `meetings` m
					ON di.`meeting_id` = m.`id`
				INNER JOIN `meeting_types` mt
					ON mt.`id` = m.`meeting_type_id`
				WHERE   {$sqlcond} {$groupby} {$sqlOrderBy}{$sqlLimit}";
		
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByMeetingId = array();
		while($row = $db->fetch()){
			/*echo '<pre>';
			print_r($row);*/
			$arrDiscussionItemsByMeetingId[] = $row;
		}
		/*echo '<pre>';
		print_r($arrDiscussionItemsByMeetingId);*/
		/*die;*/
		return $arrDiscussionItemsByMeetingId;

	}

	/**
	 * Load by constraint `discussion_items_fk_m` foreign key (`meeting_id`) references `meetings` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $meeting_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadDiscussionItemCountsByMeetingId($database, $meeting_id)
	{
		$meeting_id = (int) $meeting_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	COUNT(`discussion_item_status_id`) AS 'total'
FROM `discussion_items` di
WHERE di.`meeting_id` = ?
";
		$arrValues = array($meeting_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemCountsByMeetingIdGroupedByDiscussionItemType = array();
		$allTypesTotal = 0;
		while ($row = $db->fetch()) {
			$allTypesTotal = $row['total'];
		}
		$db->free_result();

		return $allTypesTotal;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

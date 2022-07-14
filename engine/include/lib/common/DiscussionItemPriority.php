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
 * DiscussionItemPriority.
 *
 * @category   Framework
 * @package    DiscussionItemPriority
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DiscussionItemPriority extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DiscussionItemPriority';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'discussion_item_priorities';

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
	 * unique index `unique_discussion_item_priority` (`discussion_item_priority`) comment 'Discussion Item Priorities transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_discussion_item_priority' => array(
			'discussion_item_priority' => 'string'
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
		'id' => 'discussion_item_priority_id',

		'discussion_item_priority' => 'discussion_item_priority',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $discussion_item_priority_id;

	public $discussion_item_priority;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_discussion_item_priority;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_discussion_item_priority_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDiscussionItemPriorities;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='discussion_item_priorities')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllDiscussionItemPriorities()
	{
		if (isset(self::$_arrAllDiscussionItemPriorities)) {
			return self::$_arrAllDiscussionItemPriorities;
		} else {
			return null;
		}
	}

	public static function setArrAllDiscussionItemPriorities($arrAllDiscussionItemPriorities)
	{
		self::$_arrAllDiscussionItemPriorities = $arrAllDiscussionItemPriorities;
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
	 * @param int $discussion_item_priority_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $discussion_item_priority_id, $table='discussion_item_priorities', $module='DiscussionItemPriority')
	{
		$discussionItemPriority = parent::findById($database, $discussion_item_priority_id, $table, $module);

		return $discussionItemPriority;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $discussion_item_priority_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findDiscussionItemPriorityByIdExtended($database, $discussion_item_priority_id)
	{
		$discussion_item_priority_id = (int) $discussion_item_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	dip.*

FROM `discussion_item_priorities` dip
WHERE dip.`id` = ?
";
		$arrValues = array($discussion_item_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$discussion_item_priority_id = $row['id'];
			$discussionItemPriority = self::instantiateOrm($database, 'DiscussionItemPriority', $row, null, $discussion_item_priority_id);
			/* @var $discussionItemPriority DiscussionItemPriority */
			$discussionItemPriority->convertPropertiesToData();

			return $discussionItemPriority;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_discussion_item_priority` (`discussion_item_priority`) comment 'Discussion Item Priorities transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $discussion_item_priority
	 * @return mixed (single ORM object | false)
	 */
	public static function findByDiscussionItemPriority($database, $discussion_item_priority)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	dip.*

FROM `discussion_item_priorities` dip
WHERE dip.`discussion_item_priority` = ?
";
		$arrValues = array($discussion_item_priority);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$discussion_item_priority_id = $row['id'];
			$discussionItemPriority = self::instantiateOrm($database, 'DiscussionItemPriority', $row, null, $discussion_item_priority_id);
			/* @var $discussionItemPriority DiscussionItemPriority */
			return $discussionItemPriority;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrDiscussionItemPriorityIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemPrioritiesByArrDiscussionItemPriorityIds($database, $arrDiscussionItemPriorityIds, Input $options=null)
	{
		if (empty($arrDiscussionItemPriorityIds)) {
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
		// ORDER BY `id` ASC, `discussion_item_priority` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemPriority = new DiscussionItemPriority($database);
			$sqlOrderByColumns = $tmpDiscussionItemPriority->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrDiscussionItemPriorityIds as $k => $discussion_item_priority_id) {
			$discussion_item_priority_id = (int) $discussion_item_priority_id;
			$arrDiscussionItemPriorityIds[$k] = $db->escape($discussion_item_priority_id);
		}
		$csvDiscussionItemPriorityIds = join(',', $arrDiscussionItemPriorityIds);

		$query =
"
SELECT

	dip.*

FROM `discussion_item_priorities` dip
WHERE dip.`id` IN ($csvDiscussionItemPriorityIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrDiscussionItemPrioritiesByCsvDiscussionItemPriorityIds = array();
		while ($row = $db->fetch()) {
			$discussion_item_priority_id = $row['id'];
			$discussionItemPriority = self::instantiateOrm($database, 'DiscussionItemPriority', $row, null, $discussion_item_priority_id);
			/* @var $discussionItemPriority DiscussionItemPriority */
			$discussionItemPriority->convertPropertiesToData();

			$arrDiscussionItemPrioritiesByCsvDiscussionItemPriorityIds[$discussion_item_priority_id] = $discussionItemPriority;
		}

		$db->free_result();

		return $arrDiscussionItemPrioritiesByCsvDiscussionItemPriorityIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all discussion_item_priorities records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDiscussionItemPriorities($database, Input $options=null)
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
			self::$_arrAllDiscussionItemPriorities = null;
		}

		$arrAllDiscussionItemPriorities = self::$_arrAllDiscussionItemPriorities;
		if (isset($arrAllDiscussionItemPriorities) && !empty($arrAllDiscussionItemPriorities)) {
			return $arrAllDiscussionItemPriorities;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `discussion_item_priority` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemPriority = new DiscussionItemPriority($database);
			$sqlOrderByColumns = $tmpDiscussionItemPriority->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dip.*

FROM `discussion_item_priorities` dip{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `discussion_item_priority` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDiscussionItemPriorities = array();
		while ($row = $db->fetch()) {
			$discussion_item_priority_id = $row['id'];
			$discussionItemPriority = self::instantiateOrm($database, 'DiscussionItemPriority', $row, null, $discussion_item_priority_id);
			/* @var $discussionItemPriority DiscussionItemPriority */
			$arrAllDiscussionItemPriorities[$discussion_item_priority_id] = $discussionItemPriority;
		}

		$db->free_result();

		self::$_arrAllDiscussionItemPriorities = $arrAllDiscussionItemPriorities;

		return $arrAllDiscussionItemPriorities;
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
INTO `discussion_item_priorities`
(`discussion_item_priority`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->discussion_item_priority, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$discussion_item_priority_id = $db->insertId;
		$db->free_result();

		return $discussion_item_priority_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

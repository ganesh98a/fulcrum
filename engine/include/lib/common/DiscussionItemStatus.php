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
 * DiscussionItemStatus.
 *
 * @category   Framework
 * @package    DiscussionItemStatus
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DiscussionItemStatus extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DiscussionItemStatus';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'discussion_item_statuses';

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
	 * unique index `unique_discussion_item_status` (`discussion_item_status`) comment 'Discussion Item Statuses transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_discussion_item_status' => array(
			'discussion_item_status' => 'string'
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
		'id' => 'discussion_item_status_id',

		'discussion_item_status' => 'discussion_item_status',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $discussion_item_status_id;

	public $discussion_item_status;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_discussion_item_status;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_discussion_item_status_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDiscussionItemStatuses;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='discussion_item_statuses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllDiscussionItemStatuses()
	{
		if (isset(self::$_arrAllDiscussionItemStatuses)) {
			return self::$_arrAllDiscussionItemStatuses;
		} else {
			return null;
		}
	}

	public static function setArrAllDiscussionItemStatuses($arrAllDiscussionItemStatuses)
	{
		self::$_arrAllDiscussionItemStatuses = $arrAllDiscussionItemStatuses;
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
	 * @param int $discussion_item_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $discussion_item_status_id, $table='discussion_item_statuses', $module='DiscussionItemStatus')
	{
		$discussionItemStatus = parent::findById($database, $discussion_item_status_id, $table, $module);

		return $discussionItemStatus;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $discussion_item_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findDiscussionItemStatusByIdExtended($database, $discussion_item_status_id)
	{
		$discussion_item_status_id = (int) $discussion_item_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	dis.*

FROM `discussion_item_statuses` dis
WHERE dis.`id` = ?
";
		$arrValues = array($discussion_item_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$discussion_item_status_id = $row['id'];
			$discussionItemStatus = self::instantiateOrm($database, 'DiscussionItemStatus', $row, null, $discussion_item_status_id);
			/* @var $discussionItemStatus DiscussionItemStatus */
			$discussionItemStatus->convertPropertiesToData();

			return $discussionItemStatus;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_discussion_item_status` (`discussion_item_status`) comment 'Discussion Item Statuses transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $discussion_item_status
	 * @return mixed (single ORM object | false)
	 */
	public static function findByDiscussionItemStatus($database, $discussion_item_status)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	dis.*

FROM `discussion_item_statuses` dis
WHERE dis.`discussion_item_status` = ?
";
		$arrValues = array($discussion_item_status);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$discussion_item_status_id = $row['id'];
			$discussionItemStatus = self::instantiateOrm($database, 'DiscussionItemStatus', $row, null, $discussion_item_status_id);
			/* @var $discussionItemStatus DiscussionItemStatus */
			return $discussionItemStatus;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrDiscussionItemStatusIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemStatusesByArrDiscussionItemStatusIds($database, $arrDiscussionItemStatusIds, Input $options=null)
	{
		if (empty($arrDiscussionItemStatusIds)) {
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
		// ORDER BY `id` ASC, `discussion_item_status` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemStatus = new DiscussionItemStatus($database);
			$sqlOrderByColumns = $tmpDiscussionItemStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrDiscussionItemStatusIds as $k => $discussion_item_status_id) {
			$discussion_item_status_id = (int) $discussion_item_status_id;
			$arrDiscussionItemStatusIds[$k] = $db->escape($discussion_item_status_id);
		}
		$csvDiscussionItemStatusIds = join(',', $arrDiscussionItemStatusIds);

		$query =
"
SELECT

	dis.*

FROM `discussion_item_statuses` dis
WHERE dis.`id` IN ($csvDiscussionItemStatusIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrDiscussionItemStatusesByCsvDiscussionItemStatusIds = array();
		while ($row = $db->fetch()) {
			$discussion_item_status_id = $row['id'];
			$discussionItemStatus = self::instantiateOrm($database, 'DiscussionItemStatus', $row, null, $discussion_item_status_id);
			/* @var $discussionItemStatus DiscussionItemStatus */
			$discussionItemStatus->convertPropertiesToData();

			$arrDiscussionItemStatusesByCsvDiscussionItemStatusIds[$discussion_item_status_id] = $discussionItemStatus;
		}

		$db->free_result();

		return $arrDiscussionItemStatusesByCsvDiscussionItemStatusIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all discussion_item_statuses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDiscussionItemStatuses($database, Input $options=null)
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
			self::$_arrAllDiscussionItemStatuses = null;
		}

		$arrAllDiscussionItemStatuses = self::$_arrAllDiscussionItemStatuses;
		if (isset($arrAllDiscussionItemStatuses) && !empty($arrAllDiscussionItemStatuses)) {
			return $arrAllDiscussionItemStatuses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `discussion_item_status` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemStatus = new DiscussionItemStatus($database);
			$sqlOrderByColumns = $tmpDiscussionItemStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dis.*

FROM `discussion_item_statuses` dis
WHERE dis.disabled_flag = 'N'{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `discussion_item_status` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDiscussionItemStatuses = array();
		while ($row = $db->fetch()) {
			$discussion_item_status_id = $row['id'];
			$discussionItemStatus = self::instantiateOrm($database, 'DiscussionItemStatus', $row, null, $discussion_item_status_id);
			/* @var $discussionItemStatus DiscussionItemStatus */
			$arrAllDiscussionItemStatuses[$discussion_item_status_id] = $discussionItemStatus;
		}

		$db->free_result();

		self::$_arrAllDiscussionItemStatuses = $arrAllDiscussionItemStatuses;

		return $arrAllDiscussionItemStatuses;
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
INTO `discussion_item_statuses`
(`discussion_item_status`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->discussion_item_status, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$discussion_item_status_id = $db->insertId;
		$db->free_result();

		return $discussion_item_status_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

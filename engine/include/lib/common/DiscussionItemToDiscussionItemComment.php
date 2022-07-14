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
 * DiscussionItemToDiscussionItemComment.
 *
 * @category   Framework
 * @package    DiscussionItemToDiscussionItemComment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DiscussionItemToDiscussionItemComment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DiscussionItemToDiscussionItemComment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'discussion_items_to_discussion_item_comments';

	/**
	 * primary key (`discussion_item_id`,`discussion_item_comment_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'discussion_item_id' => 'int',
		'discussion_item_comment_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_discussion_item_to_discussion_item_comment_via_primary_key' => array(
			'discussion_item_id' => 'int',
			'discussion_item_comment_id' => 'int'
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
		'discussion_item_comment_id' => 'discussion_item_comment_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $discussion_item_id;
	public $discussion_item_comment_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId;
	protected static $_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDiscussionItemsToDiscussionItemComments;

	// Foreign Key Objects
	private $_discussionItem;
	private $_discussionItemComment;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='discussion_items_to_discussion_item_comments')
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

	public function getDiscussionItemComment()
	{
		if (isset($this->_discussionItemComment)) {
			return $this->_discussionItemComment;
		} else {
			return null;
		}
	}

	public function setDiscussionItemComment($discussionItemComment)
	{
		$this->_discussionItemComment = $discussionItemComment;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId()
	{
		if (isset(self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId)) {
			return self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId($arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId)
	{
		self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId = $arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId;
	}

	public static function getArrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId()
	{
		if (isset(self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId)) {
			return self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId($arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId)
	{
		self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId = $arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllDiscussionItemsToDiscussionItemComments()
	{
		if (isset(self::$_arrAllDiscussionItemsToDiscussionItemComments)) {
			return self::$_arrAllDiscussionItemsToDiscussionItemComments;
		} else {
			return null;
		}
	}

	public static function setArrAllDiscussionItemsToDiscussionItemComments($arrAllDiscussionItemsToDiscussionItemComments)
	{
		self::$_arrAllDiscussionItemsToDiscussionItemComments = $arrAllDiscussionItemsToDiscussionItemComments;
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
	 * Find by primary key (`discussion_item_id`,`discussion_item_comment_id`).
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param int $discussion_item_comment_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByDiscussionItemIdAndDiscussionItemCommentId($database, $discussion_item_id, $discussion_item_comment_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	di2dic.*

FROM `discussion_items_to_discussion_item_comments` di2dic
WHERE di2dic.`discussion_item_id` = ?
AND di2dic.`discussion_item_comment_id` = ?
";
		$arrValues = array($discussion_item_id, $discussion_item_comment_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$discussionItemToDiscussionItemComment = self::instantiateOrm($database, 'DiscussionItemToDiscussionItemComment', $row);
			/* @var $discussionItemToDiscussionItemComment DiscussionItemToDiscussionItemComment */
			return $discussionItemToDiscussionItemComment;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`discussion_item_id`,`discussion_item_comment_id`) Extended.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param int $discussion_item_comment_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByDiscussionItemIdAndDiscussionItemCommentIdExtended($database, $discussion_item_id, $discussion_item_comment_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	di2dic_fk_di.`id` AS 'di2dic_fk_di__discussion_item_id',
	di2dic_fk_di.`meeting_id` AS 'di2dic_fk_di__meeting_id',
	di2dic_fk_di.`discussion_item_sequence_number` AS 'di2dic_fk_di__discussion_item_sequence_number',
	di2dic_fk_di.`discussion_item_status_id` AS 'di2dic_fk_di__discussion_item_status_id',
	di2dic_fk_di.`discussion_item_priority_id` AS 'di2dic_fk_di__discussion_item_priority_id',
	di2dic_fk_di.`discussion_item_cost_code_id` AS 'di2dic_fk_di__discussion_item_cost_code_id',
	di2dic_fk_di.`created_by_contact_id` AS 'di2dic_fk_di__created_by_contact_id',
	di2dic_fk_di.`discussion_item_title` AS 'di2dic_fk_di__discussion_item_title',
	di2dic_fk_di.`discussion_item` AS 'di2dic_fk_di__discussion_item',
	di2dic_fk_di.`created` AS 'di2dic_fk_di__created',
	di2dic_fk_di.`discussion_item_closed_date` AS 'di2dic_fk_di__discussion_item_closed_date',
	di2dic_fk_di.`sort_order` AS 'di2dic_fk_di__sort_order',

	di2dic_fk_dic.`id` AS 'di2dic_fk_dic__discussion_item_comment_id',
	di2dic_fk_dic.`discussion_item_id` AS 'di2dic_fk_dic__discussion_item_id',
	di2dic_fk_dic.`created_by_contact_id` AS 'di2dic_fk_dic__created_by_contact_id',
	di2dic_fk_dic.`discussion_item_comment` AS 'di2dic_fk_dic__discussion_item_comment',
	di2dic_fk_dic.`modified` AS 'di2dic_fk_dic__modified',
	di2dic_fk_dic.`created` AS 'di2dic_fk_dic__created',
	di2dic_fk_dic.`is_visible_flag` AS 'di2dic_fk_dic__is_visible_flag',

	di2dic.*

FROM `discussion_items_to_discussion_item_comments` di2dic
	INNER JOIN `discussion_items` di2dic_fk_di ON di2dic.`discussion_item_id` = di2dic_fk_di.`id`
	INNER JOIN `discussion_item_comments` di2dic_fk_dic ON di2dic.`discussion_item_comment_id` = di2dic_fk_dic.`id`
WHERE di2dic.`discussion_item_id` = ?
AND di2dic.`discussion_item_comment_id` = ?
";
		$arrValues = array($discussion_item_id, $discussion_item_comment_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$discussionItemToDiscussionItemComment = self::instantiateOrm($database, 'DiscussionItemToDiscussionItemComment', $row);
			/* @var $discussionItemToDiscussionItemComment DiscussionItemToDiscussionItemComment */
			$discussionItemToDiscussionItemComment->convertPropertiesToData();

			if (isset($row['discussion_item_id'])) {
				$discussion_item_id = $row['discussion_item_id'];
				$row['di2dic_fk_di__id'] = $discussion_item_id;
				$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id, 'di2dic_fk_di__');
				/* @var $discussionItem DiscussionItem */
				$discussionItem->convertPropertiesToData();
			} else {
				$discussionItem = false;
			}
			$discussionItemToDiscussionItemComment->setDiscussionItem($discussionItem);

			if (isset($row['discussion_item_comment_id'])) {
				$discussion_item_comment_id = $row['discussion_item_comment_id'];
				$row['di2dic_fk_dic__id'] = $discussion_item_comment_id;
				$discussionItemComment = self::instantiateOrm($database, 'DiscussionItemComment', $row, null, $discussion_item_comment_id, 'di2dic_fk_dic__');
				/* @var $discussionItemComment DiscussionItemComment */
				$discussionItemComment->convertPropertiesToData();
			} else {
				$discussionItemComment = false;
			}
			$discussionItemToDiscussionItemComment->setDiscussionItemComment($discussionItemComment);

			return $discussionItemToDiscussionItemComment;
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
	 * @param array $arrDiscussionItemIdAndDiscussionItemCommentIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsToDiscussionItemCommentsByArrDiscussionItemIdAndDiscussionItemCommentIdList($database, $arrDiscussionItemIdAndDiscussionItemCommentIdList, Input $options=null)
	{
		if (empty($arrDiscussionItemIdAndDiscussionItemCommentIdList)) {
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
		// ORDER BY `discussion_item_id` ASC, `discussion_item_comment_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToDiscussionItemComment = new DiscussionItemToDiscussionItemComment($database);
			$sqlOrderByColumns = $tmpDiscussionItemToDiscussionItemComment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrDiscussionItemIdAndDiscussionItemCommentIdList as $k => $arrTmp) {
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
		if (count($arrDiscussionItemIdAndDiscussionItemCommentIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	di2dic.*

FROM `discussion_items_to_discussion_item_comments` di2dic
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsToDiscussionItemCommentsByArrDiscussionItemIdAndDiscussionItemCommentIdList = array();
		while ($row = $db->fetch()) {
			$discussionItemToDiscussionItemComment = self::instantiateOrm($database, 'DiscussionItemToDiscussionItemComment', $row);
			/* @var $discussionItemToDiscussionItemComment DiscussionItemToDiscussionItemComment */
			$arrDiscussionItemsToDiscussionItemCommentsByArrDiscussionItemIdAndDiscussionItemCommentIdList[] = $discussionItemToDiscussionItemComment;
		}

		$db->free_result();

		return $arrDiscussionItemsToDiscussionItemCommentsByArrDiscussionItemIdAndDiscussionItemCommentIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `discussion_items_to_discussion_item_comments_fk_di` foreign key (`discussion_item_id`) references `discussion_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsToDiscussionItemCommentsByDiscussionItemId($database, $discussion_item_id, Input $options=null)
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
			self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId = null;
		}

		$arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId = self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId;
		if (isset($arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId) && !empty($arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId)) {
			return $arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId;
		}

		$discussion_item_id = (int) $discussion_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `discussion_item_comment_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToDiscussionItemComment = new DiscussionItemToDiscussionItemComment($database);
			$sqlOrderByColumns = $tmpDiscussionItemToDiscussionItemComment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di2dic.*

FROM `discussion_items_to_discussion_item_comments` di2dic
WHERE di2dic.`discussion_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `discussion_item_comment_id` ASC
		$arrValues = array($discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId = array();
		while ($row = $db->fetch()) {
			$discussionItemToDiscussionItemComment = self::instantiateOrm($database, 'DiscussionItemToDiscussionItemComment', $row);
			/* @var $discussionItemToDiscussionItemComment DiscussionItemToDiscussionItemComment */
			$arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId[] = $discussionItemToDiscussionItemComment;
		}

		$db->free_result();

		self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId = $arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId;

		return $arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemId;
	}

	/**
	 * Load by constraint `discussion_items_to_discussion_item_comments_fk_dic` foreign key (`discussion_item_comment_id`) references `discussion_item_comments` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_comment_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId($database, $discussion_item_comment_id, Input $options=null)
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
			self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId = null;
		}

		$arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId = self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId;
		if (isset($arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId) && !empty($arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId)) {
			return $arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId;
		}

		$discussion_item_comment_id = (int) $discussion_item_comment_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `discussion_item_comment_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToDiscussionItemComment = new DiscussionItemToDiscussionItemComment($database);
			$sqlOrderByColumns = $tmpDiscussionItemToDiscussionItemComment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di2dic.*

FROM `discussion_items_to_discussion_item_comments` di2dic
WHERE di2dic.`discussion_item_comment_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `discussion_item_comment_id` ASC
		$arrValues = array($discussion_item_comment_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId = array();
		while ($row = $db->fetch()) {
			$discussionItemToDiscussionItemComment = self::instantiateOrm($database, 'DiscussionItemToDiscussionItemComment', $row);
			/* @var $discussionItemToDiscussionItemComment DiscussionItemToDiscussionItemComment */
			$arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId[] = $discussionItemToDiscussionItemComment;
		}

		$db->free_result();

		self::$_arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId = $arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId;

		return $arrDiscussionItemsToDiscussionItemCommentsByDiscussionItemCommentId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all discussion_items_to_discussion_item_comments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDiscussionItemsToDiscussionItemComments($database, Input $options=null)
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
			self::$_arrAllDiscussionItemsToDiscussionItemComments = null;
		}

		$arrAllDiscussionItemsToDiscussionItemComments = self::$_arrAllDiscussionItemsToDiscussionItemComments;
		if (isset($arrAllDiscussionItemsToDiscussionItemComments) && !empty($arrAllDiscussionItemsToDiscussionItemComments)) {
			return $arrAllDiscussionItemsToDiscussionItemComments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `discussion_item_comment_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemToDiscussionItemComment = new DiscussionItemToDiscussionItemComment($database);
			$sqlOrderByColumns = $tmpDiscussionItemToDiscussionItemComment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	di2dic.*

FROM `discussion_items_to_discussion_item_comments` di2dic{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `discussion_item_comment_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDiscussionItemsToDiscussionItemComments = array();
		while ($row = $db->fetch()) {
			$discussionItemToDiscussionItemComment = self::instantiateOrm($database, 'DiscussionItemToDiscussionItemComment', $row);
			/* @var $discussionItemToDiscussionItemComment DiscussionItemToDiscussionItemComment */
			$arrAllDiscussionItemsToDiscussionItemComments[] = $discussionItemToDiscussionItemComment;
		}

		$db->free_result();

		self::$_arrAllDiscussionItemsToDiscussionItemComments = $arrAllDiscussionItemsToDiscussionItemComments;

		return $arrAllDiscussionItemsToDiscussionItemComments;
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
INTO `discussion_items_to_discussion_item_comments`
(`discussion_item_id`, `discussion_item_comment_id`)
VALUES (?, ?)
";
		$arrValues = array($this->discussion_item_id, $this->discussion_item_comment_id);
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

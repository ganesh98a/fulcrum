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
 * DiscussionItemComment.
 *
 * @category   Framework
 * @package    DiscussionItemComment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DiscussionItemComment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DiscussionItemComment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'discussion_item_comments';

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
		'unique_discussion_item_comment_via_primary_key' => array(
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
		'id' => 'discussion_item_comment_id',

		'discussion_item_id' => 'discussion_item_id',
		'created_by_contact_id' => 'created_by_contact_id',

		'discussion_item_comment' => 'discussion_item_comment',
		'modified' => 'modified',
		'created' => 'created',
		'is_visible_flag' => 'is_visible_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $discussion_item_comment_id;

	public $discussion_item_id;
	public $created_by_contact_id;

	public $discussion_item_comment;
	public $modified;
	public $created;
	public $is_visible_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_discussion_item_comment;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_discussion_item_comment_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrDiscussionItemCommentsByDiscussionItemId;
	protected static $_arrDiscussionItemCommentsByCreatedByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDiscussionItemComments;

	// Foreign Key Objects
	private $_discussionItem;
	private $_createdByContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='discussion_item_comments')
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
	public static function getArrDiscussionItemCommentsByDiscussionItemId()
	{
		if (isset(self::$_arrDiscussionItemCommentsByDiscussionItemId)) {
			return self::$_arrDiscussionItemCommentsByDiscussionItemId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemCommentsByDiscussionItemId($arrDiscussionItemCommentsByDiscussionItemId)
	{
		self::$_arrDiscussionItemCommentsByDiscussionItemId = $arrDiscussionItemCommentsByDiscussionItemId;
	}

	public static function getArrDiscussionItemCommentsByCreatedByContactId()
	{
		if (isset(self::$_arrDiscussionItemCommentsByCreatedByContactId)) {
			return self::$_arrDiscussionItemCommentsByCreatedByContactId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemCommentsByCreatedByContactId($arrDiscussionItemCommentsByCreatedByContactId)
	{
		self::$_arrDiscussionItemCommentsByCreatedByContactId = $arrDiscussionItemCommentsByCreatedByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllDiscussionItemComments()
	{
		if (isset(self::$_arrAllDiscussionItemComments)) {
			return self::$_arrAllDiscussionItemComments;
		} else {
			return null;
		}
	}

	public static function setArrAllDiscussionItemComments($arrAllDiscussionItemComments)
	{
		self::$_arrAllDiscussionItemComments = $arrAllDiscussionItemComments;
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
	 * @param int $discussion_item_comment_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $discussion_item_comment_id, $table='discussion_item_comments', $module='DiscussionItemComment')
	{
		$discussionItemComment = parent::findById($database, $discussion_item_comment_id, $table, $module);

		return $discussionItemComment;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $discussion_item_comment_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findDiscussionItemCommentByIdExtended($database, $discussion_item_comment_id)
	{
		$discussion_item_comment_id = (int) $discussion_item_comment_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	dic_fk_di.`id` AS 'dic_fk_di__discussion_item_id',
	dic_fk_di.`meeting_id` AS 'dic_fk_di__meeting_id',
	dic_fk_di.`discussion_item_sequence_number` AS 'dic_fk_di__discussion_item_sequence_number',
	dic_fk_di.`discussion_item_status_id` AS 'dic_fk_di__discussion_item_status_id',
	dic_fk_di.`discussion_item_priority_id` AS 'dic_fk_di__discussion_item_priority_id',
	dic_fk_di.`discussion_item_cost_code_id` AS 'dic_fk_di__discussion_item_cost_code_id',
	dic_fk_di.`created_by_contact_id` AS 'dic_fk_di__created_by_contact_id',
	dic_fk_di.`discussion_item_title` AS 'dic_fk_di__discussion_item_title',
	dic_fk_di.`discussion_item` AS 'dic_fk_di__discussion_item',
	dic_fk_di.`created` AS 'dic_fk_di__created',
	dic_fk_di.`discussion_item_closed_date` AS 'dic_fk_di__discussion_item_closed_date',
	dic_fk_di.`sort_order` AS 'dic_fk_di__sort_order',

	dic_fk_created_by_c.`id` AS 'dic_fk_created_by_c__contact_id',
	dic_fk_created_by_c.`user_company_id` AS 'dic_fk_created_by_c__user_company_id',
	dic_fk_created_by_c.`user_id` AS 'dic_fk_created_by_c__user_id',
	dic_fk_created_by_c.`contact_company_id` AS 'dic_fk_created_by_c__contact_company_id',
	dic_fk_created_by_c.`email` AS 'dic_fk_created_by_c__email',
	dic_fk_created_by_c.`name_prefix` AS 'dic_fk_created_by_c__name_prefix',
	dic_fk_created_by_c.`first_name` AS 'dic_fk_created_by_c__first_name',
	dic_fk_created_by_c.`additional_name` AS 'dic_fk_created_by_c__additional_name',
	dic_fk_created_by_c.`middle_name` AS 'dic_fk_created_by_c__middle_name',
	dic_fk_created_by_c.`last_name` AS 'dic_fk_created_by_c__last_name',
	dic_fk_created_by_c.`name_suffix` AS 'dic_fk_created_by_c__name_suffix',
	dic_fk_created_by_c.`title` AS 'dic_fk_created_by_c__title',
	dic_fk_created_by_c.`vendor_flag` AS 'dic_fk_created_by_c__vendor_flag',

	dic.*

FROM `discussion_item_comments` dic
	INNER JOIN `discussion_items` dic_fk_di ON dic.`discussion_item_id` = dic_fk_di.`id`
	INNER JOIN `contacts` dic_fk_created_by_c ON dic.`created_by_contact_id` = dic_fk_created_by_c.`id`
WHERE dic.`id` = ?
";
		$arrValues = array($discussion_item_comment_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$discussion_item_comment_id = $row['id'];
			$discussionItemComment = self::instantiateOrm($database, 'DiscussionItemComment', $row, null, $discussion_item_comment_id);
			/* @var $discussionItemComment DiscussionItemComment */
			$discussionItemComment->convertPropertiesToData();

			if (isset($row['discussion_item_id'])) {
				$discussion_item_id = $row['discussion_item_id'];
				$row['dic_fk_di__id'] = $discussion_item_id;
				$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id, 'dic_fk_di__');
				/* @var $discussionItem DiscussionItem */
				$discussionItem->convertPropertiesToData();
			} else {
				$discussionItem = false;
			}
			$discussionItemComment->setDiscussionItem($discussionItem);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['dic_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'dic_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$discussionItemComment->setCreatedByContact($createdByContact);

			return $discussionItemComment;
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
	 * @param array $arrDiscussionItemCommentIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemCommentsByArrDiscussionItemCommentIds($database, $arrDiscussionItemCommentIds, Input $options=null)
	{
		if (empty($arrDiscussionItemCommentIds)) {
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
		// ORDER BY `id` ASC, `discussion_item_id` ASC, `created_by_contact_id` ASC, `discussion_item_comment` ASC, `modified` ASC, `created` ASC, `is_visible_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemComment = new DiscussionItemComment($database);
			$sqlOrderByColumns = $tmpDiscussionItemComment->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrDiscussionItemCommentIds as $k => $discussion_item_comment_id) {
			$discussion_item_comment_id = (int) $discussion_item_comment_id;
			$arrDiscussionItemCommentIds[$k] = $db->escape($discussion_item_comment_id);
		}
		$csvDiscussionItemCommentIds = join(',', $arrDiscussionItemCommentIds);

		$query =
"
SELECT

	dic.*

FROM `discussion_item_comments` dic
WHERE dic.`id` IN ($csvDiscussionItemCommentIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrDiscussionItemCommentsByCsvDiscussionItemCommentIds = array();
		while ($row = $db->fetch()) {
			$discussion_item_comment_id = $row['id'];
			$discussionItemComment = self::instantiateOrm($database, 'DiscussionItemComment', $row, null, $discussion_item_comment_id);
			/* @var $discussionItemComment DiscussionItemComment */
			$discussionItemComment->convertPropertiesToData();

			$arrDiscussionItemCommentsByCsvDiscussionItemCommentIds[$discussion_item_comment_id] = $discussionItemComment;
		}

		$db->free_result();

		return $arrDiscussionItemCommentsByCsvDiscussionItemCommentIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `discussion_item_comments_fk_di` foreign key (`discussion_item_id`) references `discussion_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemCommentsByDiscussionItemId($database, $discussion_item_id, Input $options=null)
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
			self::$_arrDiscussionItemCommentsByDiscussionItemId = null;
		}

		$arrDiscussionItemCommentsByDiscussionItemId = self::$_arrDiscussionItemCommentsByDiscussionItemId;
		if (isset($arrDiscussionItemCommentsByDiscussionItemId) && !empty($arrDiscussionItemCommentsByDiscussionItemId)) {
			return $arrDiscussionItemCommentsByDiscussionItemId;
		}

		$discussion_item_id = (int) $discussion_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `discussion_item_id` ASC, `created_by_contact_id` ASC, `discussion_item_comment` ASC, `modified` ASC, `created` ASC, `is_visible_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemComment = new DiscussionItemComment($database);
			$sqlOrderByColumns = $tmpDiscussionItemComment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dic.*

FROM `discussion_item_comments` dic
WHERE dic.`discussion_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `discussion_item_id` ASC, `created_by_contact_id` ASC, `discussion_item_comment` ASC, `modified` ASC, `created` ASC, `is_visible_flag` ASC
		$arrValues = array($discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemCommentsByDiscussionItemId = array();
		while ($row = $db->fetch()) {
			$discussion_item_comment_id = $row['id'];
			$discussionItemComment = self::instantiateOrm($database, 'DiscussionItemComment', $row, null, $discussion_item_comment_id);
			/* @var $discussionItemComment DiscussionItemComment */
			$arrDiscussionItemCommentsByDiscussionItemId[$discussion_item_comment_id] = $discussionItemComment;
		}

		$db->free_result();

		self::$_arrDiscussionItemCommentsByDiscussionItemId = $arrDiscussionItemCommentsByDiscussionItemId;

		return $arrDiscussionItemCommentsByDiscussionItemId;
	}

	/**
	 * Load by constraint `discussion_item_comments_fk_created_by_c` foreign key (`created_by_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $created_by_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemCommentsByCreatedByContactId($database, $created_by_contact_id, Input $options=null)
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
			self::$_arrDiscussionItemCommentsByCreatedByContactId = null;
		}

		$arrDiscussionItemCommentsByCreatedByContactId = self::$_arrDiscussionItemCommentsByCreatedByContactId;
		if (isset($arrDiscussionItemCommentsByCreatedByContactId) && !empty($arrDiscussionItemCommentsByCreatedByContactId)) {
			return $arrDiscussionItemCommentsByCreatedByContactId;
		}

		$created_by_contact_id = (int) $created_by_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `discussion_item_id` ASC, `created_by_contact_id` ASC, `discussion_item_comment` ASC, `modified` ASC, `created` ASC, `is_visible_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemComment = new DiscussionItemComment($database);
			$sqlOrderByColumns = $tmpDiscussionItemComment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dic.*

FROM `discussion_item_comments` dic
WHERE dic.`created_by_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `discussion_item_id` ASC, `created_by_contact_id` ASC, `discussion_item_comment` ASC, `modified` ASC, `created` ASC, `is_visible_flag` ASC
		$arrValues = array($created_by_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemCommentsByCreatedByContactId = array();
		while ($row = $db->fetch()) {
			$discussion_item_comment_id = $row['id'];
			$discussionItemComment = self::instantiateOrm($database, 'DiscussionItemComment', $row, null, $discussion_item_comment_id);
			/* @var $discussionItemComment DiscussionItemComment */
			$arrDiscussionItemCommentsByCreatedByContactId[$discussion_item_comment_id] = $discussionItemComment;
		}

		$db->free_result();

		self::$_arrDiscussionItemCommentsByCreatedByContactId = $arrDiscussionItemCommentsByCreatedByContactId;

		return $arrDiscussionItemCommentsByCreatedByContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all discussion_item_comments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDiscussionItemComments($database, Input $options=null)
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
			self::$_arrAllDiscussionItemComments = null;
		}

		$arrAllDiscussionItemComments = self::$_arrAllDiscussionItemComments;
		if (isset($arrAllDiscussionItemComments) && !empty($arrAllDiscussionItemComments)) {
			return $arrAllDiscussionItemComments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `discussion_item_id` ASC, `created_by_contact_id` ASC, `discussion_item_comment` ASC, `modified` ASC, `created` ASC, `is_visible_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemComment = new DiscussionItemComment($database);
			$sqlOrderByColumns = $tmpDiscussionItemComment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dic.*

FROM `discussion_item_comments` dic{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `discussion_item_id` ASC, `created_by_contact_id` ASC, `discussion_item_comment` ASC, `modified` ASC, `created` ASC, `is_visible_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDiscussionItemComments = array();
		while ($row = $db->fetch()) {
			$discussion_item_comment_id = $row['id'];
			$discussionItemComment = self::instantiateOrm($database, 'DiscussionItemComment', $row, null, $discussion_item_comment_id);
			/* @var $discussionItemComment DiscussionItemComment */
			$arrAllDiscussionItemComments[$discussion_item_comment_id] = $discussionItemComment;
		}

		$db->free_result();

		self::$_arrAllDiscussionItemComments = $arrAllDiscussionItemComments;

		return $arrAllDiscussionItemComments;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	/**
	 * Load discussion_item_comments by discussion_item_id.
	 *
	 * @param string $database
	 * @param int $discussion_item_comment_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadDiscussionItemCommentsByDiscussionItemIds($database, $arrDiscussionItemIds, $filterByIsVisibleFlag=false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (empty($arrDiscussionItemIds)) {
			return array();
		}

		foreach ($arrDiscussionItemIds as $k => $discussion_item_id) {
			$discussion_item_id = (int) $discussion_item_id;
			$arrDiscussionItemIds[$k] = $db->escape($discussion_item_id);
		}
		$csvDiscussionItemIds = join(',', $arrDiscussionItemIds);

		if ($filterByIsVisibleFlag) {
			$filterByIsVisibleFlagSql =
"AND dic.`is_visible_flag` = 'Y'
";
		} else {
			$filterByIsVisibleFlagSql = '';
		}

		$query =
"
SELECT

	dic_fk_di.`id` AS 'dic_fk_di__discussion_item_id',
	dic_fk_di.`meeting_id` AS 'dic_fk_di__meeting_id',
	dic_fk_di.`discussion_item_sequence_number` AS 'dic_fk_di__discussion_item_sequence_number',
	dic_fk_di.`discussion_item_status_id` AS 'dic_fk_di__discussion_item_status_id',
	dic_fk_di.`discussion_item_priority_id` AS 'dic_fk_di__discussion_item_priority_id',
	dic_fk_di.`discussion_item_cost_code_id` AS 'dic_fk_di__discussion_item_cost_code_id',
	dic_fk_di.`created_by_contact_id` AS 'dic_fk_di__created_by_contact_id',
	dic_fk_di.`discussion_item_title` AS 'dic_fk_di__discussion_item_title',
	dic_fk_di.`discussion_item` AS 'dic_fk_di__discussion_item',
	dic_fk_di.`created` AS 'dic_fk_di__created',
	dic_fk_di.`discussion_item_closed_date` AS 'dic_fk_di__discussion_item_closed_date',
	dic_fk_di.`sort_order` AS 'dic_fk_di__sort_order',

	dic_fk_created_by_c.`id` AS 'dic_fk_created_by_c__contact_id',
	dic_fk_created_by_c.`user_company_id` AS 'dic_fk_created_by_c__user_company_id',
	dic_fk_created_by_c.`user_id` AS 'dic_fk_created_by_c__user_id',
	dic_fk_created_by_c.`contact_company_id` AS 'dic_fk_created_by_c__contact_company_id',
	dic_fk_created_by_c.`email` AS 'dic_fk_created_by_c__email',
	dic_fk_created_by_c.`name_prefix` AS 'dic_fk_created_by_c__name_prefix',
	dic_fk_created_by_c.`first_name` AS 'dic_fk_created_by_c__first_name',
	dic_fk_created_by_c.`additional_name` AS 'dic_fk_created_by_c__additional_name',
	dic_fk_created_by_c.`middle_name` AS 'dic_fk_created_by_c__middle_name',
	dic_fk_created_by_c.`last_name` AS 'dic_fk_created_by_c__last_name',
	dic_fk_created_by_c.`name_suffix` AS 'dic_fk_created_by_c__name_suffix',
	dic_fk_created_by_c.`title` AS 'dic_fk_created_by_c__title',
	dic_fk_created_by_c.`vendor_flag` AS 'dic_fk_created_by_c__vendor_flag',
	dic_fk_created_by_c.`is_archive` AS 'dic_fk_created_by_c__is_archive',

	dic.*

FROM `discussion_item_comments` dic
	INNER JOIN `discussion_items` dic_fk_di ON dic.`discussion_item_id` = dic_fk_di.`id`
	INNER JOIN `contacts` dic_fk_created_by_c ON dic.`created_by_contact_id` = dic_fk_created_by_c.`id`
WHERE dic_fk_di.`id` IN ($csvDiscussionItemIds)
$filterByIsVisibleFlagSql
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemCommentsByDiscussionItemIds = array();
		while ($row = $db->fetch()) {
			$discussion_item_comment_id = $row['id'];
			$discussionItemComment = self::instantiateOrm($database, 'DiscussionItemComment', $row, null, $discussion_item_comment_id);
			/* @var $discussionItemComment DiscussionItemComment */
			$discussionItemComment->convertPropertiesToData();

			if (isset($row['discussion_item_id'])) {
				$discussion_item_id = $row['discussion_item_id'];
				$row['dic_fk_di__id'] = $discussion_item_id;
				$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id, 'dic_fk_di__');
				/* @var $discussionItem DiscussionItem */
				$discussionItem->convertPropertiesToData();
			} else {
				$discussionItem = false;
			}
			$discussionItemComment->setDiscussionItem($discussionItem);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['dic_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'dic_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$discussionItemComment->setCreatedByContact($createdByContact);

			$discussion_item_id = $row['discussion_item_id'];
			$arrDiscussionItemCommentsByDiscussionItemIds[$discussion_item_id][$discussion_item_comment_id] = $discussionItemComment;
		}
		$db->free_result();

		return $arrDiscussionItemCommentsByDiscussionItemIds;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
